<?php
if(!empty($_GET['id']))
{
    $restaurant = ORM::for_table($config['db']['pre'] . 'shop')
    ->find_one($_GET['id']);
    if(!empty($restaurant['id']))
    {
   $page = new HtmlTemplate ('templates/' . $config['tpl_name'] . '/agb-restaurants.tpl');
   $page->SetParameter ('OVERALL_HEADER', create_header($lang['AGB_RESTAURANTS']));
   $page->SetParameter ('RESTAURANT_NAME',$restaurant['name']);
   $page->SetParameter ('RESTRO_ID',$restaurant['id']);
   $page->SetParameter ('OVERALL_FOOTER', create_footer());
   $page->SetParameter ('SLUG',$restaurant['slug']);
   $page->CreatePageEcho();
    }
    else {
       error($lang['PAGE_NOT_FOUND'], __LINE__, __FILE__, 1);
       exit();
   }
}
else {
    error($lang['PAGE_NOT_FOUND'], __LINE__, __FILE__, 1);
    exit();
}
 
?>
