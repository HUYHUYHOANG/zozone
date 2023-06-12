<?php

if(checkloggedin()) {

    $shop = ORM::for_table($config['db']['pre'] . 'shop')
    ->where('id', $_SESSION['user']['shop_id'])
    ->find_one();
    $shop_id = $shop['id'];

    if(isset($_POST['submit'])){
        update_shop_option($shop_id,'quickorder_enable', $_POST['quickorder_enable']);
        update_shop_option($shop_id,'whatsapp_number', $_POST['whatsapp_number']);
      //  update_shop_option($shop_id,'whatsapp_message', $_POST['whatsapp_message']);
        transfer($link['WHATSAPP_ORDERING'],$lang['SAVED_SUCCESS'],$lang['SAVED_SUCCESS']);
        exit;
    }
        $whatsapp_number = $whatsapp_message = '';
        $whatsapp_message = get_shop_option($shop_id,'whatsapp_message');
        $whatsapp_number = get_shop_option($shop_id,'whatsapp_number');      
        if(empty($whatsapp_message))
        $whatsapp_message = $config['quickorder_whatsapp_message'];
   
    // Output to template
    if (!file_exists('plugins/quickorder/index.tpl')) {
        error($lang['PAGE_NOT_FOUND'], __LINE__, __FILE__, 1);
        exit();
    }
        $page = new HtmlTemplate ('plugins/quickorder/index.tpl');
        $page->SetParameter ('OVERALL_HEADER', create_header($lang['WHATSAPP_ORDERING']));

        $page->SetParameter ('CUSTOM_CSS_FILES', ''); //css files
        $rightMenu = '';   
        $page->SetParameter ('OVERALL_SIDEBAR', sidebar_add_custom_menu_items($rightMenu));  
        $page->SetParameter ('OVERALL_RIGHT_NOTIFICATION_MENU', $rightMenu);
     
        
        $page->SetParameter ('WHATSAPP_NUMBER', $whatsapp_number);
        $page->SetParameter ('WHATSAPP_MESSAGE', $whatsapp_message);
        $page->SetParameter ('QUICKORDER_ENABLE', get_shop_option($shop_id,'quickorder_enable',0));
        $page->SetParameter ('OVERALL_FOOTER', create_footer());   
        $page->CreatePageEcho();
}
else{
    error($lang['PAGE_NOT_FOUND'], __LINE__, __FILE__, 1);
    exit();
}
?>