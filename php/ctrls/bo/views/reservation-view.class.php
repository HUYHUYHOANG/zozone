<?php
////*********************************************************************************************************************** */
/// VIEW
////*********************************************************************************************************************** */

class CReservationView extends CBoHtmlView{
    
    public function __construct(&$model){
        parent::__construct($model);
    }

    public static function _statusStyle($status, &$outArr=null){
        global $lang;
       // $colors = array('warning', 'danger', 'info', 'secondary', 'primary', 'success');
        $colors = array( 'info',  'success','danger');//'secondary', 'primary',
        $labels = array( $lang['BO_CONFIRMED'], $lang['BO_DONE'],$lang['BO_CANCELLED']);

                        // $labels = array($lang['BO_PENDING'], $lang['BO_CANCELLED'], $lang['BO_CONFIRMED'],
                      //  $lang['BO_NOT_COME'], $lang['BO_IN_SERVICE'], $lang['BO_DONE']);
        if($status > 2) $status = 0;
        if(!is_null($outArr)) $outArr = array('color' => $colors[$status], 'text' => $labels[$status]);
        return sprintf('<button type="button" class="resv-status not-click btn btn-sm btn-%s">%s</button>', $colors[$status], $labels[$status]);
    }

    public static function statusColor($status){
        if($status<0 || $status>5) $status = 0;
        $colors = array('#ffbb33', '#ff4444', '#33b5e5', '#6c757d', '#4285F4', '#00C851');
        return $colors[$status];
    }
    public static function statusLabel($status){
        if($status<0 || $status>5) $status = 0;
        global $lang;
        $labels = array($lang['BO_PENDING'], $lang['BO_CANCELLED'], $lang['BO_CONFIRMED'],
                        $lang['BO_NOT_COME'], $lang['BO_IN_SERVICE'], $lang['BO_DONE']);
        return $labels[$status];
    }

    public static function getBookingDescription($item){
        global $lang;
        $s ="<div class='tt-info'>
                <table border='0'>
                    <tr><td align='right'>" . $lang['CUSTOMER'] . "</td><td align='left'>" . $item['customer'] . "</td></tr>
                    <tr><td align='right'>" . $lang['STAFF'] . "</td><td align='left'>" . $item['staff'] . "</td></tr>
                    <tr><td align='right'>" . $lang['DURATION'] . "</td><td align='left'>" . $item['duration'] . " '</td></tr>
                    <tr><td align='right'>" . $lang['SERVICE'] . "</td><td align='left'>" . CReservationData::getServiceNames($item['service_ids']) . "</td></tr>
                    <tr><td colspan='2' style='height:12px;'></td></tr>
                    <tr><td align='right'>" . $lang['STATUS'] . "</td><td align='left'><div class='btn btn-sm' style='width:100%;color:#fff;background-color:" . self::statusColor($item['status']) . "'>" . self::statusLabel($item['status']) . "</div></td></tr>
                </table>
            </div>";
        return $s;
    }

    public function defaultView(){
        global $lang;
        $this->model->loadReservations();        
        $rows = $this->model->data;
        
        if(!count($rows)){            
            return '<div class="text-danger" style="margin:15px;">' . $lang['RECD_NOT_FOUND'] . '</div>';            
        } 

        ob_start();
        ?>
        <table id="tblReservations" class="table table-stripped" style="width:100%;">
            <thead>
                <th><?php echo $lang['TIME']?></th>
                <th><?php echo $lang['CUSTOMER']?></th>
                <th><?php echo $lang['STATUS']?></th>
                <th><?php echo $lang['STAFF']?></th>
                <th><?php echo $lang['VOUCHER']?></th>
                <th><?php echo $lang['PRICE']?></th>
                <th></th>
            </thead>
            <tbody>
        <?php
        $prevDate = '';
        $employer = $this->model->isEmployer();
        foreach($rows as $r){
            $dt = strtotime($r['arr_time']);
            $depDt = strtotime($r['dep_time']);
            $date = date('d-m-Y', $dt);
            $startTime = "<span class='resv-time'>" . date('H:i A', $dt) . "</span>";
            $depTime = "<span class='resv-time'>" . date('H:i A', $depDt) . "</span>";

            if($date != $prevDate){
                echo sprintf('<tr><td colspan="7" class="td-group">%s</td>', $this->formarDate($dt));
                $prevDate = $date;
            }
            ?>
            <tr>
                <td><?php  echo $startTime . ' - ' . $depTime ?></td>
                <td><?php echo $r['customer'] ? $r['customer'] : '[n/a]' ?></td>
                <td><?php echo self::_statusStyle($r['status']) ?></td>
                <td><?php echo $r['staff'] ?></td>
                <td><?php echo $r['voucher'] ?></td>
                <td class="price-col">
                    <?php
                        echo "<span>" . $this->formatPrice($r['service_amount']) . "</span>";
                        if($r['reduced'] && $r['voucher']){
                            echo "<span style='display:block;'> - " . $this->formatPrice($r['reduced']) . "</span>";
                        }
                    ?>
                </td>
                <td class="text-right buttons-wrap">
                    <?php
                    if(!$employer){?>
                        <a class="button btn-sm resv-detail" href="#" data-id="<?php echo $r['id'] ?>"><i class="icon-feather-edit"></i>&nbsp;</a>
                        <a class="button btn-sm btn-danger btnDelete" href="#" data-id="<?php echo $r['id'] ?>"><i class="icon-feather-trash-2"></i>&nbsp;</a>
                    <?php
                    }else{?>
                        <a class="button btn-sm resv-detail" href="#" data-readonly="true" data-id="<?php echo $r['id'] ?>"><i class="icon-feather-eye"></i>&nbsp;</a>
                    <?php
                    }?>
                </td>                
            </tr>
            <?php
        }
        ?>
            </tbody>
            <tfoot>
                <tr><td colspan="7" bgcolor="#00f">
                    <?php $this->model->pager->renderBootstrapStyle('pagination') ?>
                </td>
                </tr>
            </tfoot>
        </table>
        <?php
        $s = ob_get_contents();
        ob_clean();
        ob_end_flush();
        return $s;
    }//view
    
    public function editBookingDialog(){
        $id = CRequest::getNbr('id');        
        $found = $this->model->getBookingRecord($id);
        global $lang;
        include(__DIR__.DIRECTORY_SEPARATOR.'/../templates/edit-booking.dialog.php');
    }    

    public function addBookingDialog(){
        global $lang, $config;
        include(__DIR__.DIRECTORY_SEPARATOR.'/../templates/add-booking.dialog.php');
    }

    public function bookingSettingsDialog(){
        global $lang;
        $settings = $this->model->loadBookingSettings();
        include(__DIR__.DIRECTORY_SEPARATOR.'/../templates/reservation-settings.dialog.php');
    }

    private function getCustomerJSONDataForScript(){
        echo "<script type='text/javascript'>";
        echo "\r\n var agclients = ";

        $rows = ORM::forTable('qr_customers')->select_many('id', 'name', 'email', 'phone')->where('shop_id', $this->model->shopID)->order_by_asc('name')->findMany();
        if(!$rows){
            echo " []; "; return;
        }

        $data = array();
        foreach($rows as $r){
            $data[] = array('id' => $r['id'], 'name' => $r['name'], 'email' => $r['email'], 'phone' => $r['phone']);
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        echo ";";
        echo "\r\n</script>";
    }

    private function getServicesJSONDataForScript(){        
        $sql = "SELECT id, name, service_duration AS duration, IF(discount_price<>null OR discount_price<>'', discount_price, price) AS price FROM qr_menu WHERE shop_id={$this->model->shopID} ORDER BY cat_id ASC";        
        $rows = ORM::forTable("qr_menu")->rawQuery($sql)->findMany();
        $data = false;
        if(count($rows)){
            $data = array();
            foreach($rows as $r){
                $r = (object)$r;
                $data[] = array('id' => $r->id, 'name' => $r->name, 'price' => $r->price, 'duration' => $r->duration);
            }            
        }
        
        echo "<script type='text/javascript'>";
        echo "\r\n var agservices = ";
        if($data) echo json_encode($data, JSON_UNESCAPED_UNICODE);
        else echo "[]";
        echo "\r\n</script>";
    }
}//CReservationView
?>