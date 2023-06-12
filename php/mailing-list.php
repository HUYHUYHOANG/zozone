<?php
if(isset($_GET['setup-cron']) && $_GET['setup-cron']=='yes'){        
    
    //$command = "0 6 * * * wget https://zozone.de/mailing-list";
    $command = "0 6 * * * " . PHP_BINARY . " " . __DIR__ . "/ctrls/cron.php";

    echo "<br/>Add: ";
    echo $command;
    echo " : ";
    echo CronShell::addCron($command) ? ' ok'  : ' failed';
    echo '<Br/>LIST:<br>';
    CronShell::listCrons();      
    die;
}

//$config['lang'] = "german";
if($config['lang'] != "german"){
    unset($lang);
    require_once(__DIR__."/../includes/lang/lang_german.php");
}

require("ctrls/bo/base.class.php");
require("ctrls/bo/shop-options-ctrl.class.php");
require("ctrls/bo/mail-list-ctrl.class.php");

$tblPre = $config['db']['pre'];

$error = 0;
$gaShops = array();

//get active shops
$rows = ORM::for_table("{$tblPre}shop")->select_many('id', 'name', 'slug', 'shop_smtp_user', 'shop_smtp_secret')->where('status','active')->where_not_null('slug')->order_by_asc('id')->find_many();
if($rows){    
    foreach($rows as $r){
        $gaShops[$r['id']] = array('id' => $r['id'], 'name' => $r['name'], 'slug' => $r['slug'], 'shop_smtp_user' => $r['shop_smtp_user'], 'shop_smtp_secret' => $r['shop_smtp_secret']);
    }
}

if(!count($gaShops)) die;

set_time_limit(0);

new CShopMailingList();

class CShopMailingList{
    private $logFile;
    private $mailerCtrl;
    private $debugMode;

    public function __construct(){
        global $gaShops, $config;
        
        $this->debugMode = isset($_GET['debug']) && $_GET['debug']=="yes";
        $this->logFile = fopen(__DIR__ . "/cron-log.txt", "wb");

        $mailEngineInit = 0;
        foreach($gaShops as $shopId=>$info){
            if(!$mailEngineInit){
                $this->mailerCtrl = new CMailListCtrl($config, $shopId);
                $this->mailerCtrl->view->initEmailEngine();
                $mailEngineInit = 1;
            }else{
                $this->mailerCtrl->setShopId($shopId);
            }

            $this->mailerCtrl->setUsernameAndPwd($info['shop_smtp_user'], $info['shop_smtp_secret']);

            $this->serviceComingUpReminder($shopId);

            $this->comebackShopReminder($shopId);
        }
    }

    public function __destruct(){
        @fclose($this->logFile);
    }

    //******************************************************************************* */
    //** SEND EMAIL TO ALL CUSTOMERS IN THE SHOP THAT HER/HIM SERVICE BOOKING WAS CONFIRMED */
    //******************************************************************************* */
    public function serviceComingUpReminder($shopId){
        global $config;
        $shopModel = new CShopOptionsData($config, $shopId);
        $booking_reminder_by_a_week = $shopModel->getShopOtion($shopId, 'booking_reminder_by_a_week', 0);
        $booking_reminder_by_a_day = $shopModel->getShopOtion($shopId, 'booking_reminder_by_a_day', 0);
        $booking_reminder_msg_template = $shopModel->getShopOtion($shopId, 'booking_reminder_msg_template', 0);
        $themsg = 0;
        if($booking_reminder_msg_template){
            $themsg = $this->getMessage($shopId);
            if(!$themsg){
                $this->logError("Message template TYPE: booking_remind not found...");
                return false;
            }            
        }else{
            $this->logError(sprintf("Shop %d, param [booking_reminder_msg_template = %d] invalid", $shopId, $booking_reminder_msg_template));
            return false;
        }

        if(!CShopInfo::getInfo($shopId)){
            $this->logError("Shop info ID " . $shopId . " not found...");
            return false;
        }

        $subject = html_entity_decode($themsg->title);
        $content = html_entity_decode($themsg->content);
        $footer = CShopInfo::emaiFooter();
        
        $this->mailerCtrl->view->mailer->clearReplyTos();
        $this->mailerCtrl->view->mailer->SetFrom($config['smtp_username'], CShopInfo::$data->name);
        $this->mailerCtrl->view->mailer->AddReplyTo(CShopInfo::$data->email, CShopInfo::$data->name);

        $customersList = array();

        //7 DAYS LEFT
        if($booking_reminder_by_a_week){
            $customersList[] = $this->getComingUpCustomers($shopId, 7);            
        }        
        //1 DAY LEFT
        if($booking_reminder_by_a_day){
            $customersList[] = $this->getComingUpCustomers($shopId, 1);
        }
        //TODAY
        if(1){
            $customersList[] = $this->getComingUpCustomers($shopId, 0);
        }

        if(!count($customersList)){
            $this->logError('Customers list not found...');
            return;
        }

        $customerCount = 0;
        foreach($customersList as $customers){                
            if(!count($customers)){
                continue;
            } 

            foreach($customers as $customer){
                $serviceTable = $this->buildServicesContent($customer);
                $body = str_replace(array('{CUSTOMER_NAME}', '{SERVICE_TIME}', '{BOOKING_CONTENT}', '{SHOP_NAME}'), 
                                    array($customer->name, date("m-d-Y H:i A", strtotime($customer->arr_time)), $serviceTable, CShopInfo::$data->name), $content);
                $ret = $this->mailerCtrl->view->emailCustomer($customer->email, $customer->name, $subject, $body . $footer);                
                if(!$ret){                        
                    $this->logError($config['email_result_message']);
                }else $this->logError("Send to <b>{$customer->email}</b> : OK");
                ++$customerCount;
            }
        }
        $this->logError("serviceComingUpReminder() : shopId : {$shopId} - {$customerCount} emails sent...");
    }

    //******************************************************************************* */
    //** SEND EMAIL TO ALL CUSTOMERS IN THE SHOP THAT TAKE ALONG TIME NOT VISIT SHOP */
    //** GET CUSTOMER FORM SETTINGS
    //******************************************************************************* */
    public function comebackShopReminder($shopId){
        global $config;

        $shopModel = new CShopOptionsData($config, $shopId);
        $options = json_decode($shopModel->getShopOtion($shopId, 'send_email_cron_job', 0));
        if(!$options || !isset($options->customer_setting) || !isset($options->email_template)){
            $this->logError(sprintf("Shop ID: %d [send_email_cron_job] not found...", $shopId));
            return false;
        }

        $this->logError(sprintf("Setting: %s ", $options->customer_setting));        

        if(!CShopInfo::getInfo($shopId)){
            $this->logError(sprintf("Shop info ID: %d not found...", $shopId));
            return false;
        }
        $shopInfo = &CShopInfo::$data;

        //get the message template
        $themsg = $this->mailerCtrl->model->getMessageTemplate($options->email_template);
        if(!$themsg){
            $this->logError(sprintf("Message template ID: %d not found...", $options->email_template));
            return false;
        }

        $subject = html_entity_decode($themsg->title);
        $body = html_entity_decode($themsg->content);
        
        $customers = 0;        
        if($options->customer_setting  == 'all')
            $customers = $this->mailerCtrl->model->getCustomers();
        elseif($options->customer_setting == 'in-group'){            
            $customers = $this->mailerCtrl->model->getCustomers($options->group_ids);
        }elseif($options->customer_setting == 'last-activity'){            
            $customers = $this->mailerCtrl->model->getCustomers(0, $options->last_visit_days);
        }

        if(!$customers){
            $this->logError("Shop {$shopId}: customer not found...");
            return false;
        }

        $this->mailerCtrl->view->mailer->clearReplyTos();
        $this->mailerCtrl->view->mailer->SetFrom($config['smtp_username'], $shopInfo->name);
        $this->mailerCtrl->view->mailer->AddReplyTo($shopInfo->email, $shopInfo->name);

        $body = str_replace('{SHOP_NAME}', $shopInfo->name, $body);
        $footer = CShopInfo::emaiFooter();

        foreach($customers as $customer){
            $content = str_replace('{CUSTOMER_NAME}', $customer->name, $body);
            $ret = $this->mailerCtrl->view->emailCustomer($customer->email, $customer->name, $subject, $content . $footer);
            if(!$ret)
                $this->logError("Send to <b>{$customer->email}</b> failed : " . $config['email_result_message']);
            else
                $this->logError("Send to <b>{$customer->email}</b> : OK");
        }

        return true;
    }

    private function &getMessage($shopId, $type='booking_remind', $sendVia = 'email'){
        global $tblPre;
        $themsg = ORM::forTable("{$tblPre}message_templates")->selectMany('title', 'content')->where(array('shop_id'=>$shopId, 'template_type'=>$type, 'send_via'=>$sendVia, 'active'=>1))->findOne();
        return $themsg;
    }

    //*************************************************************************/
    // IMPORTANT NOTE: JUST GET CONFIRMED RECORDS ONLY : reservation status === 2
    //**************************************************************************/
    private function &getComingUpCustomers($shopId, $days=7){
        //get CONFIRMED record ONLY
        $sql = "SELECT c.id, c.name, c.email, c.newsletter, r.service_ids, r.arr_time, r.duration, r.service_amount, r.recuded_amount, r.voucher, DATE(r.arr_time) AS service_date
                FROM qr_customers c INNER JOIN qr_reservations r ON r.client_id = c.id AND c.shop_id = r.shop_id
                WHERE c.shop_id={$shopId} AND r.status=2 AND DATE(TIMESTAMPADD(DAY, -{$days}, r.arr_time)) = DATE(NOW())";  
        
        $rows = ORM::forTable("")->rawQuery($sql)->findMany();
        return $rows;
    }

    private function buildServicesContent(&$data){
        global $tblPre, $lang;
        $html = "";
        $sql = "SELECT id, name, service_duration AS duration, description, IF(discount_price, discount_price, price) AS price, IF(discount_price,price-discount_price, 0) AS discount FROM {$tblPre}menu WHERE active='1' AND id IN({$data->service_ids})";
        $rows = ORM::forTable('')->rawQuery($sql)->findMany();
        if(!$rows) return "";
        $idx = 1; $srow = "";
        foreach($rows as $r){
            $r = (object)$r;
            $sprice = $this->getPrices($r->price, $r->discount);
            $srow .= "<tr><td style='text-align:center;'>{$idx}</td><td>{$r->name}</td><td>{$r->duration}</td><td>{$sprice}</td></tr>";
            ++$idx;
        }

        if($data->recuded_amount && $data->voucher){
            $srow .= "<tr style='background:#FAFAF5'><td></td><td>{$lang['VOUCHER']}</td><td>{$data->voucher}</td><td>" . $this->toPrice($data->recuded_amount) . "</td></tr>";
        }
        $srow .= "<tr style='background:#FAFAF5'><td></td><td style='font-weight:bold;'>{$lang['TOTAL']}</td><td><strong>{$data->duration}</strong></td><td><strong>" . $this->toPrice($data->service_amount - $data->recuded_amount) . "</strong></td></tr>";

        $html = "<table width='100%' style='margin:15px;' cellspacing='2' cellpadding='12'><tr style='font-weight:bold;background-color:#FAF5F5;'><td width='20px' style='text-align:center'>#</td>
                    <td width='30%'>{$lang['SERVICE']}</td><td width='30%'>{$lang['DURATION']} ({$lang['MINUTE']})</td><td width='30%'>{$lang['PRICE']}</td></tr>" . $srow . "</table>";
        return $html;
    }

    private function toPrice($nbr){
        return number_format($nbr, 2, '.', ',');
    }

    private function getPrices($price, $discount){
        $html = "";
        if($discount){
            $html = "<span style='margin-right:12px;text-decoration:line-through;'>" . number_format($price + $discount, 2, '.', ',') . "</span>";
        }
        $html = "<span style=''>" . number_format($price, 2, '.', ',') . "</span>";
        return $html;
    }

    private function logError($err){
        if($this->debugMode)
            echo $err;
        fwrite($this->logFile, sprintf("[%s] %s", date("Y-m-d H:i:s"), $err.PHP_EOL));
    }
}

//******************************************************************************************* */
//* CRONSHELL UNITILITIS*//
class CronShell{
    public static function addCron($cmd){
        if(self::cronExists($cmd)){
            echo "<br/>command exists...<br/>"; return false;
        }
        $output = @shell_exec('crontab -l');
        $cron_file = "/tmp/crontab.txt";
        @file_put_contents($cron_file, $output.$cmd.PHP_EOL);
        //@file_put_contents($cron_file, $cmd.PHP_EOL);
        @exec("crontab {$cron_file}");
        return true;
    }

    public static function listCrons(){
        @exec('crontab -l', $crontab);
        //Find command
        if(is_array($crontab)){
            print_r($crontab);
        }
    }

    public static function cronExists($cmd){
        $cronjob_exists=false;
        
        @exec('crontab -l', $crontab);
        
        if(isset($crontab)&&is_array($crontab)){
            $crontab = array_flip($crontab);
            if(isset($crontab[$cmd])){
                $cronjob_exists=true;
            }
        }
        return $cronjob_exists;
    }

    public static function deleteCron($cmd){
        @exec('crontab -l', $crontab);
        //Find command
        if(is_array($crontab)){
            $key = array_search($cmd, $crontab);
            unset($crontab[$key]);
            echo '<br/>---------------------------';
            print_r($crontab);
            echo '---------------------------';
            echo 'delete by key ' . $key;
        }else echo 'not found';
        $cron_file = "/tmp/crontab.txt";
        @file_put_contents($cron_file, implode(PHP_EOL,$crontab));
        @exec("crontab $cron_file");
    }
}
?>