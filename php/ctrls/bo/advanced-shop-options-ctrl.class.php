<?php
////*********************************************************************************************************************** */
/// CONTROL
////*********************************************************************************************************************** */
include(__DIR__.DIRECTORY_SEPARATOR.'shop-options-ctrl.class.php');

class CAdvancedShopOptionsCtrl extends CBoCtrl{
    private $ggtl = 0;

    public function __construct (&$config, $shopID){
        parent::__construct($config, $shopID);
        $this->model = new CCAdvancedShopOptionsData($config, $shopID);
        $this->view = new CCAdvancedShopOptionsView($this->model);
    }

    public function loadFlatIcon(){
        $this->view->loadFlatIcon();
    } 

    public function saveFlatIconSetting(){
        global $config, $lang;
        $code = CRequest::postStr('flaticon-code');
        $json = new stdClass;
        $json->error = 0;
        $json->message = $code;
        $theObj = new CShopOptionsData($config, $this->shopID);
        $json->error = !$theObj->updateShopOption($this->shopID, 'menu_flat_icon_code', $code);        
        $json->message = $json->error ? $lang['ERROR'] : $lang['SAVED_SUCCESS'];
        echo json_encode($json);
    }
}

////*********************************************************************************************************************** */
// DATA
////*********************************************************************************************************************** */
class CCAdvancedShopOptionsData extends CBoLogicData{

    public function __construct($config, $shopID){
        parent::__construct($config, $shopID);
        $this->tableName = $this->config['db']['pre'].'shop_options';
    }
 
}//end data class

////*********************************************************************************************************************** */
// VIEW
////*********************************************************************************************************************** */
class CCAdvancedShopOptionsView extends CBoHtmlView{    
    public function loadFlatIcon(){
        global $config, $lang;
        $theObj = new CShopOptionsData($config, $this->model->shopID);
        $flatIconCode = $theObj->getShopOtion($this->model->shopID, 'menu_flat_icon_code');

        include(__DIR__.DIRECTORY_SEPARATOR.'templates/menu-flat-icons.dialog.php');
    }
}//view
?>