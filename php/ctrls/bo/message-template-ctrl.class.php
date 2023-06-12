<?php
////*********************************************************************************************************************** */
/// CONTROL
////*********************************************************************************************************************** */
class CMessageTemplateCtrl extends CBoCtrl{
    
    public function __construct (&$config, $shopID){
        parent::__construct($config, $shopID);
        $this->model = new CMessageTemplateData($config, $shopID);
        $this->view = new CMessageTemplateView($this->model);
    }

    public function loadTemplates($searchData = 0, $outputFlag = 1){
        $html = $this->view->defaultView();
        if($outputFlag) echo $html;
        else return $html;
    }

    public function deleteTheItem(){
        $item = CRequest::getNbr('item');
        $ret = 0; $msg = '';
        if($item>0) $ret = $this->model->delete($item);// $this->model->updateOne($item, 'deleted', 1, $msg);
        echo json_encode(array('error' => ($ret ? 0 : 1) , 'error-msg' => $msg));
    }
    
    public function saveTemplate(){
        if(!CBoCtrl::checkSessionKey()){
            echo json_encode(array('error' => 1)); return 0;    
        }
        unset($_POST[$_SESSION['user']['login_string']]);

        $err = 0;
        $continue = $this->validateParamArray($_POST, $err);        
        if(!$continue){
            $err->error = 1;
            echo json_encode($err); return 0;
        }
        $json = 0;
        $ret = $this->model->saveTemplate($json);
        $err->post = $json;
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
            case 'name':
            case 'title':
            case 'content':
                return strlen($value);            
            default:
                $errObj->text = '';
        }
        return true;
    }

    public function loadMsgContent(){
        $id = CRequest::getNbr('id');
        $langCode = CRequest::getStr('lang_code');
        $json = false;
        if($id) $content = $this->model->loadMsgContent($id, $langCode, $json);
        if($json){
            $json->name = html_entity_decode($json->name);
            $json->title = html_entity_decode($json->title);
            $json->content = html_entity_decode($json->content);
        }
        echo json_encode(array('id' => $id, 'lang_code' => $langCode, 'data' => $json));
    }
}

////*********************************************************************************************************************** */
// DATA
////*********************************************************************************************************************** */
class CMessageTemplateData extends CBoLogicData{

    public function __construct($config, $shopID){
        parent::__construct($config, $shopID);
        $this->tableName = $this->config['db']['pre'] . 'message_templates';
    }

    /************************************************************************************* */
    //mesage template types: 
    // 01. booking_confirmation : message sent when a booking confirmed by SHOP
    // 02. booking_success : sent when a booking successful made
    // 03. booking_remind : remind the customers visit SHOP before 7 days, 1 day and at start (07:00 AM) of the serviec day
    // 04. comeback_shop_remind: sent to the customers (in settings) 
    // 05. special_offer : optional, 
    /************************************************************************************* */    
    //send_via: email, whatsapp
    public function &getAllTemplates($sendVia='email', $templateType=''){
        $sql = "SELECT id, template_type, name, lang_code FROM qr_message_templates WHERE active AND !deleted AND shop_id={$this->shopID} ";
        if($sendVia) $sql .= " AND send_via='{$sendVia}' ";
        if($templateType) $sql .= " AND template_type='{$templateType}' ";

        $sql .= " ORDER BY template_type ASC";
        $data = ORM::for_table($this->tableName)->raw_query($sql)->findMany();
        return $data;
    }

    public function loadMsgContent($id, $langCode, &$jsonOut){
        if($langCode=='de'){
            $row = ORM::forTable($this->tableName)->select_many('name', 'title', 'content')->where(array('shop_id'=>$this->shopID, 'active'=>1))->findOne($id);
            if($row){
                $jsonOut = new stdClass;
                $jsonOut->name = $row['name'];
                $jsonOut->title = $row['title'];
                $jsonOut->content = $row['content'];
            }
        }
        else{
            $row = ORM::forTable($this->tableName)->select_many('translation')->where(array('shop_id'=>$this->shopID, 'active'=>1))->findOne($id);
            $json = json_decode($row->translation);
            $jsonOut = new stdClass;
            if(isset($json->$langCode)){
                $jsonOut->name = $json->$langCode->name ? $json->$langCode->name : '';
                $jsonOut->title = $json->$langCode->title ? $json->$langCode->title : '';
                $jsonOut->content = $json->$langCode->content ? $json->$langCode->content : '';
            }
        }
        
    }

    public function &loadTemplates($searchData = 0){
        $condition = $this->_buildCondition($searchData);
        $rowsPerPage = PAGINATION_ROWS_PER_PAGE;

        $sql = "SELECT COUNT(*) AS items FROM qr_message_templates t WHERE t.deleted=0 AND t.shop_id=".$this->shopID . $condition;
        
        $rows = ORM::for_table($this->tableName)->raw_query($sql)->find_one();
        $itemCount = $rows['items'];
        
        if(!$itemCount) 
            return $this;

        $this->pager = new CPager($itemCount, $this->searchData['page'], $rowsPerPage, 5);

        $sql = "SELECT t.* FROM qr_message_templates t WHERE t.shop_id={$this->shopID} AND !t.deleted" . $condition
                . ' ORDER BY t.template_type ASC, t.send_via ASC LIMIT ' . $this->pager->begin() . ',' . $rowsPerPage;
        
        $this->data = ORM::for_table($this->tableName)->raw_query($sql)->find_many();
        return $this;
    }
    

    public function delete($item){
        $theLog = ORM::for_table($this->tableName)->find_one($item);
        /*$theLog->set('deleted', 1);
        return $theLog->save();*/
        return $theLog ? $theLog->delete() : 0;
    }

    public function updateOne($item, $name, $value, &$msg){        
        $sql = "UPDATE {$this->tableName} SET {$name}={$value} WHERE id={$item}";
        $msg = $sql;
        return ORM::get_db()->prepare($sql)->execute();
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
            $searchData = $_SESSION['SEARCH_MESSAGE_TEMPLATE_DATA'];
            $searchData['page'] = $offset;
        }
        
        //save
        $_SESSION['SEARCH_MESSAGE_TEMPLATE_DATA'] = $searchData;
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

    /************************************************************************************* */
    //mesage template types: 
    // 01. booking_confirmation : message sent when a booking confirmed by SHOP
    // 02. booking_success : sent when a booking successful made
    // 03. booking_remind : remind the customers visit SHOP before 7 days, 1 day and at start (07:00 AM) of the serviec day
    // 04. comeback_shop_remind: sent to the customers (in settings) 
    // 05. special_offer : optional, 
    /************************************************************************************* */  
    //'booking_confirmation', 'booking_success', 'booking_remind',  
    public function getTemplateTypes($selType=''){        
        $types = array('comeback_shop_remind', 'customer_service', 'special_offer');
        $count = count($types);
        $data = array();
        for($i=0; $i < $count; ++$i){
            $type = $types[$i];
            $data[$i] = array('type' => $type, 'name' => str_replace('_', ' ', $type), 'selected' => $selType==$type ? 'selected' : '');
        }
        return $data;
    }

    public function getTemplateItem($id){       
        
        $item = ORM::for_table($this->tableName)->find_one($id);
        return $item;
    }

    public function saveTemplate(&$json){
        $data = &$_POST;
        $id = $data['id'];
        unset($data['id']);
        
        $ret = 0;
        $langCode = '';
        $msgName = CRequest::postStr('name');
        
        $obj = ($id<=0) ? ORM::for_table($this->tableName)->create() : $obj = ORM::for_table($this->tableName)->find_one($id);
        if($obj){
            $langCode = CRequest::postStr('lang_code');
            $obj->shop_id = $this->shopID;
            
            $obj->template_type = CRequest::postStr('template_type');
            $obj->send_via = CRequest::postStr('send_via');            
            $obj->active = isset($data['active'])?1:0;

            //just set content for DE language, others langs will be auto-translated
            if(($id>0 && $langCode=='de') || $id<=0){
                $obj->name = htmlentities($msgName);
                $obj->title = htmlentities($data['title']);
                $obj->content = htmlentities($data['content']);
            }

            $ret = $obj->save();
            if($id<=0) $id = $obj->id();
        }
        
        $json = new stdClass;
        $json->id = $id;
        $json->langCode = $langCode;

        if($id){
            $obj = ORM::for_table($this->tableName)->find_one($id);
            if($langCode=='de'){
                include(__DIR__.DIRECTORY_SEPARATOR.'shop-options-ctrl.class.php');            
                $langs = CShopOptionsData::getActiveLangCodes();                
                if($langs){                    
                    if($obj){
                        $translation = (array)json_decode($obj->translation);
                        require_once(__DIR__.DIRECTORY_SEPARATOR.'CFr3eGoogl3Translat3.class.php');
                        $ggtl = new CFr3eGoogl3Translat3();
                        
                        foreach($langs as $code){
                            $transName = $ggtl->translate('de', $code, $obj->name);
                            $transTitle = $ggtl->translate('de', $code, $obj->title);                            
                            $transContent = $ggtl->translate('de', $code, $obj->content);
                            $translation[$code] = array('name' => $transName, 'title' => $transTitle, 'content' => $transContent);
                        }
                        $obj->translation = json_encode($translation, JSON_UNESCAPED_UNICODE);
                        $ret = $obj->save();
                    }
                }
            }else{
                $translation = json_decode($obj->translation);
                $translation->$langCode->name = $data['name'];
                $translation->$langCode->title = $data['title'];
                $translation->$langCode->content = htmlentities($data['content']);
                $obj->translation = json_encode($translation, JSON_UNESCAPED_UNICODE);
                $ret = $obj->save();
            }
        }
        return $ret;
    }
}//end data class

////*********************************************************************************************************************** */
// VIEW
////*********************************************************************************************************************** */
class CMessageTemplateView extends CBoHtmlView{    

    public function defaultView(){
        $this->model->loadTemplates();
        ob_start();
        if(!$this->model->data){
            global $lang;
            echo '<div class="text-danger" style="margin:15px;">' . $lang['RECD_NOT_FOUND'] . '</div>';
        }else{
            global $lang;
            ?>
            <table class="table table-stripped templates-table">
                <thead>
                    <th width="1%" class="text-center">#</th>
                    <th ><?php echo $lang['NAME'] ?></th>
                    <th  width="20%"><?php echo $lang['TYPE']?></th>
                    <th  width="20%"><?php echo $lang['FOR']?></th>
                    <th width="10%" class="text-center" width="10%"><?php echo $lang['STATUS']?></th>                    
                    <th width="15%"></th>
                </thead>            
                <tbody>
                    <?php
                    $idx = 0; $prevDate = 0;
                    foreach($this->model->data as $r){                        
                    ?>    
                    <tr id="rw-<?php echo $r['id']?>">
                        <td class="text-center"><?php echo ++$idx ?></td>
                        <td><?php echo $r['name'] ?></td>                        
                        <td class="template-type"><?php echo str_replace('_', ' ', $r['template_type']) ?></td>
                        <td class="template-type"><?php echo $r['send_via'] ?></td>
                        <td class="text-center" role="status"><?php
                            if($r['active']) echo "<i class='fa fa-check'></i>"
                        ?></td>
                        <td><div class="text-right" data-id="<?php echo $r['id'] ?>" class="action-button-wrap"><?php $this->_actionButtons($r['id']) ?></div></td>
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

    private function _actionButtons($id){
        echo '<a href="./message-templates?d0=edit-template&id=' . $id . '" class="btn btn-sm button edit text-white" data-action="edit"><i class="icon-feather-edit"></i></a>                
                <a class="btn btn-sm button delete text-white" data-action="delete"><i class="icon-feather-trash-2"></i></a>';        
    }
}//view
?>