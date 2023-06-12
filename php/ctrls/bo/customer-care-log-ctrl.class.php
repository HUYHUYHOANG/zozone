<?php
////*********************************************************************************************************************** */
/// CONTROL
////*********************************************************************************************************************** */
class CCustomerCareLogCtrl extends CBoCtrl{
    
    public function __construct (&$config, $shopID){
        parent::__construct($config, $shopID);
        $this->model = new CCustomerCareLogData($config, $shopID);
        $this->view = new CCustomerCareLogView($this->model);
    }

    public function loadTheLogs($searchData = 0, $outputFlag = 1){
        $html = $this->view->defaultView();
        if($outputFlag) echo $html;
        else return $html;
    }

    public function setItemStateDone(){
        $item = CRequest::getNbr('item');
        $ret = 0; $msg = '';
        if($item>0) $ret = $this->model->updateOne($item, 'status', 2);
        echo json_encode(array('error' => ($ret ? 0 : 1) , 'error-msg' => $msg));
    }

    public function deleteTheItem(){
        $item = CRequest::getNbr('item');
        $ret = 0; $msg = '';
        if($item>0) $ret = $this->model->updateOne($item, 'deleted', 1);
        echo json_encode(array('error' => ($ret ? 0 : 1) , 'error-msg' => $msg));
    }

    public function loadLogItemDetails(){
        $item = CRequest::getNbr('item');
        $view = CRequest::getStr('view');
        $this->view->loadItemDetails($item, $view=='view');
    }

    public function saveLogItemDetails(){
        if(!CBoCtrl::checkSessionKey()){
            echo json_encode(array('error' => 1)); return;    
        }
        unset($_POST[$_SESSION['user']['login_string']]);

        $err = 0;
        $continue = $this->validateParamArray($_POST, $err);        
        $id = 0;         
        if(!$continue){
            $err->error = 1;
            echo json_encode($err); return;
        }else{
        }
        
        $id = CRequest::postNbr('id');
        if($id<=0){
            $ret = $this->model->addCCLItem($_POST, $err);
        }else{
            $ret = $this->model->updateLogDetails($id, $_POST, $err);
        }
        $err->error = $ret ? 0 : 1;
        if($ret) $err->field = '';
        echo json_encode($err);
    }

    protected function validateParam($key, $value, &$errObj){
        global $lang;
        $errObj = new stdClass();
        $errObj->error = 0;
        $errObj->field = $key;
        $errObj->text = $lang['FIELD_REQUIRED'];
        switch($key){
            case 'service_ids':
                return strlen($value);
            case 'contact_time':                
                $errObj->text = $lang['ERROR_DATE'];
                if(empty($value)) return false;
                $dt = DateTime::createFromFormat('m-d-Y H:i A', $value);
                if(!$dt) return false;
                $_POST[$key] = $dt->format('Y-m-d H:i:s');
            case 'cust_id':
            case 'staff_id':                
                return $value > 0;
            default:
                $errObj->text = '';
        }
        return true;
    }

    public function sendBulkMessages(){
        $this->view->sendBulkMessagesDialog();
    }

    public function clearAllCclData(){
        $ret = $this->model->clearCCLData();
        echo json_encode(array('error' => ($ret ? 0 : 1) , 'error-msg' => ''));
    }

    public function addCustomerCareDialog(){
        $this->view->addCustomerCareDialog();
    }
}

////*********************************************************************************************************************** */
// DATA
////*********************************************************************************************************************** */
class CCustomerCareLogData extends CBoLogicData{

    public function __construct($config, $shopID){
        parent::__construct($config, $shopID);
        $this->tableName = $this->config['db']['pre'] . 'customer_care';
    }

    public function &loadTheLogs($searchData = 0){
        $condition = $this->_buildCondition($searchData);
        $rowsPerPage = PAGINATION_ROWS_PER_PAGE;

        $sql = "SELECT COUNT(*) AS items FROM qr_customer_care log LEFT JOIN qr_customers c ON log.cust_id=c.id AND log.shop_id={$this->shopID}
                WHERE log.deleted=0 AND log.shop_id=".$this->shopID . $condition;

        $rows = ORM::for_table($this->tableName)->raw_query($sql)->find_one();
        $itemCount = $rows['items'];
        
        if(!$itemCount) 
            return $this;

        $this->pager = new CPager($itemCount, $this->searchData['page'], $rowsPerPage, 5);

        $sql = 'SELECT log.*, c.name AS customer, c.last_activity, c.phone AS cphone, u.name AS staff 
                FROM qr_customer_care log LEFT JOIN qr_customers c ON log.cust_id=c.id AND log.shop_id=c.shop_id 
                LEFT JOIN qr_user u ON log.staff_id=u.id AND u.shop_id=log.shop_id WHERE log.deleted=0 AND log.shop_id=' . $this->shopID . $condition
                . ' ORDER BY log.contact_time DESC LIMIT ' . $this->pager->begin() . ',' . $rowsPerPage;                
        $this->data = ORM::for_table($this->tableName)->raw_query($sql)->find_many();
        return $this;
    }
    
    public function loadItemData($item){
        $sql = 'SELECT log.*, REPLACE(log.content,"\r\n", "<br/>") AS note, c.name AS customer, c.email, c.phone AS phone, u.name AS staff 
                FROM qr_customer_care log LEFT JOIN qr_customers c ON log.cust_id=c.id AND log.shop_id=c.shop_id 
                LEFT JOIN qr_user u ON log.staff_id=u.id AND u.shop_id=log.shop_id WHERE log.deleted=0 AND log.shop_id=' . $this->shopID . ' AND log.id=' . $item;

        $this->data = ORM::for_table($this->tableName)->raw_query($sql)->find_one();
    }

    public function delete($item){
        $theLog = ORM::for_table($this->tableName)->find_one($item);
        $theLog->set('deleted', 1);
        return $theLog->save();
        //return $theLog->delete();
    }

    public function changeState($item){
        $theLog = ORM::for_table($this->tableName)->find_one($item);
        $theLog->set('status', 2);
        return $theLog->save();
    }

    public function updateOne($item, $name, $value){
        //$sql = "UPDATE {$this->tableName} SET {$name}={$value} WHERE id={$item}";
        $theLog = ORM::for_table($this->tableName)->find_one($item);
        if($theLog){
            $theLog->set($name, $value);
            return $theLog->save();
        }
        return false;
    }

    public function updateLogDetails($id, &$data, &$errObj){
        $sql = $this->prepareSQL($data, 'update');
        $pdo = ORM::get_db();
        $stmt = $pdo->prepare($sql);
        unset($data['id']);
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        $ret = $stmt->execute($data);
        if(!$ret){            
            $errorInfo = $stmt->errorInfo();
            $errObj->text = $errorInfo[0];
        }
        return $ret;
    }

    public function addCCLItem(&$data, &$errObj){
        $data['shop_id'] = $this->shopID;
        $sql = $this->prepareSQL($data, 'insert');
        $pdo = ORM::get_db();
        $stmt = $pdo->prepare($sql);
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        $ret = $stmt->execute($data);
        if(!$ret){            
            $errorInfo = $stmt->errorInfo();
            $errObj->text = $errorInfo[0];
        }        
        return $ret;
    }

    public function &getAllServices(){
        $rows = ORM::for_table($this->config['db']['pre'].'catagory_main')
            ->select_many(array('id'=>'cat_id','name'=>'cat_name'))
            ->where('shop_id', $this->shopID)->order_by_asc('cat_order')->find_many();
        if(!$rows) return 0;
        $categories = array();
        foreach($rows as $r){
            $catId = $r['id'];
            $categories[$catId] = array('id'=>$catId,'name'=>$r['name'], 'items'=>0);
            
            $items = ORM::for_table($this->config['db']['pre'].'menu')->select_many('id','name')
                        ->where('shop_id', $this->shopID)->where('cat_id',$catId)->order_by_asc('name')->find_many();
            if(!$items) continue;
            $menus = array();
            foreach($items as $item){
                $menus[$item['id']] = array('id' => $item['id'], 'name' => $item['name']);
            }
            
            $categories[$catId]['items'] = $menus;
        }
        return $categories;
    }

    public function &loadStaffs(){
        $sql = 'SELECT id, name FROM qr_user WHERE shop_id='.$this->shopID.' AND status<>"2" ORDER BY name ASC';
        $rows = ORM::for_table($this->config['db']['pre'] . 'user')->raw_query($sql)->find_many();
        $data = 0;
        if($rows){
            $data = array();
            foreach($rows as $row){
                $id = $row['id'];
                $data[$id] = array('id' => $id, 'name' => $row['name']);
            }
        }
        return $data;
    }

    public function clearCCLData(){
        $pdo = ORM::get_db();
        $sql = 'UPDATE ' . $this->tableName . ' SET deleted=1';
        return $pdo->prepare($sql)->execute();
    }

    private function _buildCondition($searchData){
        $cond = '';
        $offset = CRequest::getNbr('page', -1);
        if(!$searchData){            
            $searchData = array(
                'from_date'    => date('Y-m-01'),
                'customer'        => '',
                'status'          => 0,
                'page'          => -1
            );
        }
        
        if($offset < 0){
            //set new search data
            $st = CRequest::getStr('std');
            $past30d = '';
            if(!$st){
                //$d2 = date('c', strtotime('-30 days'));
                //$past30d = date('Y-m-d', strtotime($d2));
            }
            $searchData['from_date'] = $st ? DateTime::createFromFormat('m-d-Y', $st)->format('Y-m-d') : $past30d;
            $searchData['customer'] = str_replace('%', '', CRequest::getStr('customer'));
            $searchData['status'] = CRequest::getStr('status');            
        }else{
            //get old search data, change the page index
            $searchData = $_SESSION['SEARCH_CUSTOMER_CARE_DATA'];
            $searchData['page'] = $offset;
        }
        
        //save
        $_SESSION['SEARCH_CUSTOMER_CARE_DATA'] = $searchData;
        $this->searchData = $searchData;
        
        $data = (object)$searchData;        
        if($data->from_date){
            $cond = sprintf(' AND log.contact_time >= "%s 00:00:00"', date('Y-m-d', strtotime($data->from_date)));            
        }       
        if($data->customer){
            $s = sprintf(' AND ( c.name LIKE "#%s#" OR c.phone LIKE "#%s#" OR c.email LIKE "#%s#" )', $data->customer, $data->customer, $data->customer);
            $cond .= str_replace('#', '%', $s);
        }
        if(strlen($data->status)){
            $cond .= ' AND log.status IN (' . $data->status . ')';
        }
        if($this->isEmployer()){
            $user = CBoCtrl::getUser();
            $cond .= " AND log.staff_id=" . $user->id;
        }
        return $cond;
    }//buildCondition

}//end data class

////*********************************************************************************************************************** */
// VIEW
////*********************************************************************************************************************** */
class CCustomerCareLogView extends CBoHtmlView{    

    public function defaultView(){
        $this->model->loadTheLogs();
        ob_start();
        if(!$this->model->data){
            global $lang;
            echo '<div class="text-danger" style="margin:15px;">' . $lang['RECD_NOT_FOUND'] . '</div>';
        }else{
            global $lang;
            ?>
            <table id="customr-care-logs" class="table table-stripped">
                <thead>
                    <th width="1%" class="text-center">#</th>
                    <th  width="15%"><?php echo $lang['CONTACT'] . ' ' . $lang['TIME'] ?></th>
                    <th  width="20%"><?php echo $lang['CUSTOMER']?></th>                
                    <th class="text-center" width="15%"><?php echo $lang['STATUS']?></th>
                    <th width="20%"><?php echo $lang['EMPLOYEE']?></th>
                    <!--<th class="text-center" width="10%"><?php echo 'Last activity' /*$lang['TYPE']*/ ?></th>-->
                    <th></th>
                </thead>            
                <tbody>
                    <?php
                    $idx = 0; $prevDate = 0;
                    foreach($this->model->data as $r){
                        $dt = strtotime($r['contact_time']);
                        $date = !empty($dt) ? date('m-d-Y H:i A', $dt) : 'n/a';
                        $cname = $r['customer'];
                        $customer = sprintf('<i class="icon-feather-user"></i> %s', !empty($cname) ? $cname : 'n/a');
                        $phone = '';
                        if($r['cphone']) $phone = sprintf('<i class="icon-feather-phone"></i> %s', $r['cphone']);
                    ?>    
                    <tr id="rw-<?php echo $r['id']?>">
                        <td class="text-center"><?php echo ++$idx ?></td>
                        <td class="date-time"><?php echo $date ?></td>
                        <td><?php echo $customer . '<br/>' . $phone ?></td>                    
                        <td class="text-center" role="status"><?php $this->_statusButton($r['status']) ?></td>
                        <td><?php echo $r['staff'] ?></td>
                        <td class="text-center">
                        <?php                        
                            /*$class = $r['log_via'] == 'phone' ? 'icon-feather-phone' : ($r['log_via'] == 'newsletter' ? 'icon-feather-mail' : 'icon-feather-message-square');
                            echo sprintf('<i class="%s"></i>', $class);*/
                            //echo $r['last_activity'] ? date('M-d-Y', strtotime($r['last_activity'])) : 'n/a';
                        ?></td>
                        <td><div data-id="<?php echo $r['id'] ?>" class="ccl-action-button-wrap"><?php $this->_actionButtons($r['status']) ?></div></td>
                    </tr>
                    <?php
                    }?>
                </tbody>
                <tfoot>
                    <tr><td colspan="7">
                        <?php $this->model->pager->renderBootstrapStyle('pagination') ?>
                    </td></tr>
                </tfoot>
            </table>        
            <?php
        }

        $content = ob_get_contents();
        ob_clean();
        ob_end_flush();
        return $content;
    }//viewTheLogs

    //******************************************************** */
    //   0            1             2
    //  pending     cancelled      done
    //******************************************************** */
    private function _statusButton($state){
        global $lang;
        $colors = array('warning', 'danger', 'success');
        $labels = array($lang['BO_PENDING'], $lang['BO_CANCELLED'], $lang['BO_DONE']);
        if($state > 2) $state = $state % 2;
        echo sprintf('<a class="btn btn-sm btn-%s text-white log-item-state">%s</a>', $colors[$state], $labels[$state]);
    }

    private function _actionButtons($state){
        if(!$state){
            echo '<a class="btn btn-sm button check text-white" data-action="check"><i class="icon-feather-check"></i></a>
                  <a class="btn btn-sm button edit text-white" data-action="edit"><i class="icon-feather-edit"></i></a>
                  <a class="btn btn-sm button view text-white" data-action="view"><i class="icon-feather-eye"></i></a>
                  <a class="btn btn-sm button delete text-white" data-action="delete"><i class="icon-feather-trash-2"></i></a>';
        }elseif($state==1){
            echo '<a class="btn btn-sm button check text-white" data-action="view"><i class="icon-feather-eye"></i></a>
                  <a class="btn btn-sm button delete text-white" data-action="delete"><i class="icon-feather-trash-2"></i></a>';
        }else echo '<a class="btn btn-sm button check text-white" data-action="view"><i class="icon-feather-eye"></i></a>';
    }

    public function getLogStatus($selected=0){
        global $lang;
        $status = array($lang['BO_PENDING'], $lang['BO_CANCELLED'], $lang['BO_DONE']);        
        $options = '';
        for($i = 0; $i < count($status); ++$i){
            $options .= sprintf('<option %s value="%d">%s</option>', $selected==$i?'selected':'', $i, $status[$i]);
        }
        return $options;
    }

    //******************************************************************************* */
    // EDIT ITEM DETAILS
    //******************************************************************************* */
    public function loadItemDetails($itemID, $readOnly = 0){
        $readOnly = $readOnly ? 'readonly':'';
        $this->model->loadItemData($itemID);
        if(!$this->model->data) return;
        $r = &$this->model->data;
        $dt = strtotime($r['contact_time']);
        global $lang;
        require_once(__DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'edit-customer-care.dialog.php');        
    }//loadItemDetails
    
    public function addCustomerCareDialog(){
        global $lang;
        require_once(__DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'add-customer-care.dialog.php');
    }

    public function sendBulkMessagesDialog(){
        global $lang;
        require_once('templates/bulk-messages.dialog.php');
    }//sendBulkMessagesDialog

    private function _contactType($selected = ''){
        $items = array('phone'=>'phone', 'newsletter'=>'mail', 'whatsapp'=>'message-square');
        foreach($items as $k=>$v){
           echo sprintf('<option value="%s" %s data-content="<span class=\'ccl-sp-contact-name\'><i class=\'icon-feather-%s\'></i> %s</span>"></option>', $k, $selected==$k?'selected':'', $v, $k);
        }
    }
}//view
?>