<?php
require_once('../../includes/config.php');
require_once('../../includes/sql_builder/idiorm.php');
require_once('../../includes/db.php');
require_once('lib/request.lib.php');

function getLangCode($name){
    $row = ORM::forTable('')->rawQuery("SELECT code FROM qr_languages WHERE file_name='{$name}'")->findOne();
    return $row ? $row->code : 'de';
}
function getOption($name){
    $row = ORM::forTable('')->rawQuery("SELECT option_value AS value FROM qr_options WHERE option_name='{$name}'")->findOne();
    return $row ? $row->value : '';
}


$langCode = '';
if(isset($_COOKIE['Quick_lang'])){    
    $langCode = getLangCode($_COOKIE['Quick_lang']);
}
if(!$langCode) $langCode = 'de';

$slug = CRequest::getStr("slug");
$shop = ORM::forTable('qr_shop')->select_many('name', 'translation', 'main_image')->where(array('status'=>'active', 'slug'=>$slug))->findOne();
$data = new stdClass;
$data->image = '';
$data->name = '';

if($shop){    
    $json = json_decode($shop->translation);
    if(isset($json->$langCode->name)) $data->name = $json->$langCode->name;
    else $data->name = $shop->name;

    if($shop->main_image)
        $data->image = getOption('site_url') . "storage/shop/logo/{$shop->main_image}";
    else
        $data->image = '';
}
echo json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
?>