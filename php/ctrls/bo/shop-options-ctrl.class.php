<?php
////*********************************************************************************************************************** */
/// CONTROL
////*********************************************************************************************************************** */
class CShopOptionsCtrl extends CBoCtrl{
    private $ggtl = 0;

    public function __construct (&$config, $shopID){
        parent::__construct($config, $shopID);
        $this->model = new CShopOptionsData($config, $shopID);
        $this->view = new CShopOptionsView($this->model);
    }

    public function loadLanguageSettings(){
        $this->view->loadLanguageSettings();
    }

    public function loadFontSettings(){
        $this->view->fontSettingsForm();
    }

    public function changeLanguageSettings (){
        $id = CRequest::postNbr('id');
        $state = CRequest::postNbr('state');
        $code = CRequest::postStr('code'); 
        $ret = $this->model->changeLanguageSettings($id, $state, $code);
        echo json_encode( array( 'id' => $id, 'result' => $ret ? 1:0) );
    }

    public function saveFontSettings(){
        $stmp = "";
        /*if(!CBoCtrl::checkSessionKey($stmp)){
            echo json_encode(array('error' => 1, 'text' => 'INVALID TOKEN...' . $stmp)); return 0;    
        }*/
        unset($_POST[$_SESSION['user']['login_string']]);

        $err = new stdClass();
        $continue = $this->validateParamArray($_POST, $err);        
        if(!$continue){
            $err->error = 1;
            echo json_encode($err); return 0;
        }else{
            $err->field = '';
        }
        $ret = $this->model->saveFontSettings();
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
            /*case 'font-face':
                return !empty($value);*/
            default:
                $errObj->text = '';
        }
        return true;
    }
}

////*********************************************************************************************************************** */
// DATA
////*********************************************************************************************************************** */
class CShopOptionsData extends CBoLogicData{

    public function __construct($config, $shopID){
        parent::__construct($config, $shopID);
        $this->tableName = $this->config['db']['pre'].'shop_options';
    }

    public function saveFontSettings(){
        $data = &$_POST;
        $option = $data['font-option-section'];
        unset($data['font-option-section']);
        $fontSize = intval($data['font-size']);        
        $value = json_encode($data);
        $ret = $this->updateShopOption($this->shopID, $option, $value);
        return $ret;
    }

    public function addShopOption($shop_id, $option, $value = null){
        $option = trim($option);
        if ( empty($option) )
            return false;
    
        $option_id = ORM::for_table($this->config['db']['pre'].'shop_options')->create();
        $option_id->shop_id = $shop_id;
        $option_id->option_name = $option;
        $option_id->option_value = $value;
        $option_id->save();
    
        return $option_id->id();
    }
    
    public function getShopOtion($shop_id, $option, $default = null){
        $option = trim($option);
        if ( empty($option) )
            return $default;
    
        $result = ORM::for_table($this->config['db']['pre'].'shop_options')
            ->where('option_name', $option)
            ->where('shop_id', $shop_id)
            ->find_one();
    
        if ( isset($result['option_value']))
            return $result['option_value'];
        else
            return $default;
    }
    
    public function checkShopOptionExist($shop_id, $option){
        $option = trim($option);
        if ( empty($option) )
            return false;
    
        $num_rows = ORM::for_table($this->config['db']['pre'].'shop_options')
            ->where('option_name',$option)
            ->where('shop_id', $shop_id)
            ->count();
        if($num_rows == 1)
            return true;
        else
            return false;
    }
    
    public function updateShopOption($shop_id, $option, $value){
        $option = trim($option);
        if ( empty($option) )
            return false;
    
        if($this->checkShopOptionExist($shop_id, $option )){
            $pdo = ORM::get_db();
            $data = [
                'shop_id' => $shop_id,
                'option_value' => $value,
                'option_name' => $option
            ];
            $sql = "UPDATE ".$this->config['db']['pre']."shop_options SET option_value=:option_value WHERE option_name=:option_name AND shop_id=:shop_id";
            
            $query_result = $pdo->prepare($sql)->execute($data);
            
            if (!$query_result)
                return false;
            else
                return true;
        }
        else{
            $this->addShopOption($shop_id,$option,$value);
            return true;
        }
    }

    public function getAllFontSettings(){
        global $lang;
        $rows = ORM::forTable($this->tableName)->where('shop_id', $this->shopID)->where_like('option_name', '%font-options')->find_many();        
        // $data = array();
        // if($rows){            
        //     foreach($rows as $r){
        //         if($r['option_name']=='menu-font-options') continue;
        //         $optionName = $r['option_name'];
        //         $optionValue = json_decode($r['option_value']);
        //         $data[$optionName] = $optionValue;
        //     }            
        // }
        
        // $defData = array();
        // $options = array('font-face'=>'','font-size'=>'','font-weight'=>'normal', 'font-style'=>'normal','font-path'=>'');
        // //$data['default-font-options'] = 'General';
        // //$defData['menu-font-options'] = 'Menu';

        
        // $defData['shop-name-font-options'] = $lang['SHOP_NAME'];
        // $defData['subtitle-font-options'] = $lang['SHOP_SUB_TITLE'];
        // $defData['story-title-font-options'] = $lang['STORY_TITLE'];
        // $defData['story-subtitle-font-options'] = $lang['STORY_SUB_TITLE'];
        // $defData['action-title-font-options'] = $lang['OUR_ACTION_TITLE'];
        // $defData['action-subtitle-font-options'] = $lang['OUR_ACTION_SUB_TITLE'];
        // $defData['service-category-font-options'] = $lang['SERVICE_CATEGORY_NAME'];
        // $defData['heading-font-options'] = $lang['OTHER_HEADING'];

        // foreach($defData as $k=>$v){
        //     if(!isset($data[$k])){
        //         $options['option-desc'] = $v;
        //         $data[$k] = (object)$options;
        //     }
        // }        
        // return $data;
        $data = array();
        $defData = array();
        $options = array('font-face'=>'','font-size'=>'','font-weight'=>'normal', 'font-style'=>'normal','font-path'=>'');
        //$data['default-font-options'] = 'General';
        //$defData['menu-font-options'] = 'Menu';
        
        // $defData['1welcome-font-options'] = $lang['WELCOME_FONT'];
        // $defData['2restaurant-name-font-options'] = $lang['SHOP_NAME'];
        // $defData['3subtitle-font-options'] = $lang['RE_SUB_TITLE'];
        // $defData['4buttton-restaurant-font-options'] = $lang['RESTAURANT_BUTTON'];
        // $defData['5story-title-font-options'] = $lang['RESTAURANT_TITLE'];
        // $defData['6menu-category-banner-font-options'] = $lang['MENU_CATEGORY_BANNER_TITLE'];
        // $defData['7menu-category-font-options'] = $lang['MENU_CATEGORY_TITLE'];

        $defData['shop-name-font-options'] = $lang['SHOP_NAME'];
        $defData['subtitle-font-options'] = $lang['SHOP_SUB_TITLE'];
        $defData['story-title-font-options'] = $lang['STORY_TITLE'];
        $defData['story-subtitle-font-options'] = $lang['STORY_SUB_TITLE'];
        $defData['action-title-font-options'] = $lang['OUR_ACTION_TITLE'];
        $defData['action-subtitle-font-options'] = $lang['OUR_ACTION_SUB_TITLE'];
        $defData['service-category-font-options'] = $lang['SERVICE_CATEGORY_NAME'];
        $defData['heading-font-options'] = $lang['OTHER_HEADING'];


        // $defData['service-category-font-options'] = 'Service Category Name';
        // $defData['heading-font-options'] = 'Other Heading...';
        // action-subtitle-font-options
        foreach($defData as $k=>$v){
                $options['section_name'] = $v;
                $data[$k] = (object)$options;
        }        
 
        if($rows){            
            foreach($rows as $r){
                if($r['option_name']=='menu-font-options') continue;
                $optionName = $r['option_name'];
                $optionValue = json_decode($r['option_value']);

                $optionValue->section_name = $defData[$r['option_name']]  ;
                $data[$optionName] = $optionValue;
        
            }            
        }

       return $data;
    }

    public static function prepareUserFonts($fontFolder){
        $jsonFile = "predefined-font.json";
        $path = realpath($fontFolder);
        if( !is_file($path.DIRECTORY_SEPARATOR.$jsonFile) ) {
            
            if ($handle = opendir(realpath($fontFolder))) {
                
                $aFonts = array();
                while (false !== ($entry = readdir($handle))) {        
                    if ($entry != "." && $entry != "..") {
                        if(is_file($path.DIRECTORY_SEPARATOR.$entry)) continue;
                        
                        $sub = $path . DIRECTORY_SEPARATOR . $entry;
                        $files = glob($sub.DIRECTORY_SEPARATOR."*.{ttf,otf,eot,woff,woff2}", GLOB_BRACE);
                        $count = count($files);
                        if(empty($files) || !$count) continue;
                        $aFiles = array();
                        foreach($files as $file){
                            $file = substr($file, strlen($sub)+1);
                            $aFiles[] = $file;
                        }
                        $aFonts[] = array("face_name"=> str_replace(array("-","_"), " ", $entry),
                                        "path"     => $entry,
                                        "src"      => $aFiles);
                    }
                }        
                closedir($handle);
                
                file_put_contents($path.DIRECTORY_SEPARATOR.$jsonFile, json_encode(array("fonts"=>$aFonts)));
            }
        }
        
        //$content = file_get_contents("{$fontFolder}fonts.json");
        $content = file_get_contents($path.DIRECTORY_SEPARATOR.$jsonFile);
        $fonts = 0;
        if($content){
            $fonts = json_decode($content);    
            if($fonts && isset($fonts->fonts) && is_array($fonts->fonts)){
                $fonts = $fonts->fonts;                
            }else{
                $fonts = 0;
            }
        }
        return $fonts;
    }//prepareUserFonts

    public function &getAllLanguages(){        
        $sql = "SELECT id, name, code, active, IF(code='de', 10, 0) AS priority FROM qr_languages l WHERE !deleted ORDER BY priority DESC, active DESC";
        //$data = ORM::for_table('qr_languages')->select_many('id','name','code','active')->where('deleted',0)->order_by_desc('active')->find_many();        
        $data = ORM::forTable('')->rawQuery($sql)->findMany();
        return $data;
    }

    public function changeLanguageSettings($id, $state, $code){
        $row = ORM::forTable('qr_languages')->findOne($id);
        if($row){            
            $row->active = $state;
            if(!$row->save()) return 0;
            $translate = CRequest::postNbr('translate');
            if($state && $translate && $code!='de') {
                $this->verifyAndTranslateData($code);                
            }
            return 1;
        }
        return 0;
    }

    private function verifyAndTranslateData($destLangCode, $srcLangCode='de'){

        set_time_limit(0);

        include(__DIR__.DIRECTORY_SEPARATOR.'CFr3eGoogl3Translat3.class.php');        
        $this->ggtl = new CFr3eGoogl3Translat3();

        //shop info
        $this->transShopInfo($destLangCode);
        //shop options
        $this->transShopOptions($destLangCode);
        //services
        $this->transShopServices($destLangCode);
    }

    private function transShopServices($destLangCode, $srcLangCode = 'de'){
        //categories
        $rows = ORM::forTable('qr_catagory_main')->where('shop_id', $this->shopID)->find_many();
        foreach($rows as $r){
            $name = $r['cat_name'];
            $id = $r['cat_id'];
            $json = (array)json_decode($r['translation']);
            $json[$destLangCode] = array('title' => $this->ggtl->translate($srcLangCode, $destLangCode, $name));            
            $translated = json_encode( $json , JSON_UNESCAPED_UNICODE );            
            $data = array('id' => $id, 'translation' => $translated);
            $sql = "UPDATE qr_catagory_main SET translation=:translation WHERE cat_id=:id";
            ORM::get_db()->prepare($sql)->execute($data);
        }

        //services
        $rows = ORM::forTable('qr_menu')->where('shop_id', $this->shopID)->find_many();
        foreach($rows as $r){
            $name = $r['name'];
            $id = $r['id'];
            $decription = $r['description'];
            
            $json = (array)json_decode($r['translation']);
            if($name) $name = $this->ggtl->translate($srcLangCode, $destLangCode, $name);
            if($decription) $decription = $this->ggtl->translate($srcLangCode, $destLangCode, $decription);
            $json[$destLangCode] = array('title' => $name, 'description' => $decription);
            
            $translated = json_encode( $json , JSON_UNESCAPED_UNICODE );
            $data = array('id' => $id, 'translation' => $translated);
            $sql = "UPDATE qr_menu SET translation=:translation WHERE id=:id";
            ORM::get_db()->prepare($sql)->execute($data);
        }
    }

    private function transShopOptions($destLangCode, $srcLangCode='de'){
        $options = array('shop_title_story', 'shop_sub_title_story', 'shop_story', 'shop_popup_messages');
        foreach($options as $option){
            $json = (array)json_decode($this->getShopOtion($this->shopID, $option));
            if(isset($json[$srcLangCode]) && $json[$srcLangCode] && !isset($json[$destLangCode])){
                $json[$destLangCode] = $this->ggtl->translate($srcLangCode, $destLangCode, $json[$srcLangCode]);
            }
            $this->updateShopOption($this->shopID, $option, json_encode($json, JSON_UNESCAPED_UNICODE));
        }

        //image group name
        $rows = ORM::forTable('qr_shop_image_group')->where('shop_id', $this->shopID)->find_many();
        foreach($rows as $r){
            $name = $r['name'];
            $id = $r['id'];
            $json = (array)json_decode($r['translation']);
            $json[$destLangCode] = array('title' => $this->ggtl->translate($srcLangCode, $destLangCode, $name));
            
            $translated = json_encode( $json , JSON_UNESCAPED_UNICODE );            
            $data = array('id' => $id, 'translation' => $translated);
            $sql = "UPDATE qr_shop_image_group SET translation=:translation WHERE id=:id";
            $ret = ORM::get_db()->prepare($sql)->execute($data);            
        }
    }

    private function transShopInfo($destLangCode, $srcLangCode = 'de'){
        $r = ORM::forTable('qr_shop')->select_many('id', 'name', 'sub_title', 'description', 'translation')->find_one($this->shopID);
        if(!$r) return 0;        
            
        $id = $r['id']; $shopName = $r['name']; $shopSubTitle = $r['sub_title']; $shopDesc = $r['description'];
        $json = (array)json_decode($r['translation']);        
        if(!isset($json[$destLangCode])){            
            $json[$destLangCode] = array(
                'name' => $this->ggtl->translate($srcLangCode, $destLangCode, $shopName),
                'sub_title' => $this->ggtl->translate($srcLangCode, $destLangCode, $shopSubTitle),
                'description' => $shopDesc ? $this->ggtl->translate($srcLangCode, $destLangCode, $shopDesc) : ''
            );
            
            $translated = json_encode( $json , JSON_UNESCAPED_UNICODE );            
            $data = array('id' => $id, 'translation' => $translated);
            $sql = "UPDATE qr_shop SET translation=:translation WHERE id=:id";
            return ORM::get_db()->prepare($sql)->execute($data);
        }
        return 1;
    }

    public static function getActiveLangCodes($excludeCode='de'){
		$arr = ORM::for_table('qr_languages')->select('code')->where(array('active'=>1,'deleted'=>0))->order_by_asc('id')->find_many();        
		$items = array();
		foreach($arr as $item){
            if($excludeCode==$item['code']) continue;
			$items[] = $item['code'];
		}
		return count($items) ? $items : false;
	}
}//end data class

////*********************************************************************************************************************** */
// VIEW
////*********************************************************************************************************************** */
class CShopOptionsView extends CBoHtmlView{    
    public function fontSettingsForm(){
        global $lang;
        include(__DIR__.DIRECTORY_SEPARATOR.'templates/font-settings.dialog.php');
    }

    public function loadLanguageSettings(){
        global $lang;
        include(__DIR__.DIRECTORY_SEPARATOR.'templates/language-settings.dialog.php');
    }

    private function _languageState($id, $active, $code) {
        $checked = $active ? 'checked' : '';
        $disabled = $code=='de' ? 'disabled' : '';
        return "<label class='switch {$disabled}' style='margin-bottom:22px !important;margin-left:5px;'>
                    <input class='change-lang-state' value='1' type='checkbox' {$checked} data-id='{$id}' data-active='{$active}' data-code='{$code}' {$disabled}>
                    <span class='switch-button-right {$disabled}'></span>
                </label>";
    }
}//view
?>