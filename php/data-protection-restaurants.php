<?php
if(!empty($_GET['id']))
{
 $restaurant = ORM::for_table($config['db']['pre'] . 'shop')
 ->find_one($_GET['id']);
 if(!empty($restaurant['id']))
 {
    $STREET_HOUSE_NUMBER = $restaurant['street_name'] . '. ' . $restaurant['house_number'];
    $PLZ_CITY = $restaurant['zipcode'] . ' ' . $restaurant['city'];
    $userdata = get_user_data(null, $restaurant['user_id']);
    $email = $userdata['email'];
    $page = new HtmlTemplate ('templates/' . $config['tpl_name'] . '/data-protection-restaurants.tpl');
    $page->SetParameter ('OVERALL_HEADER', create_header($lang['AGB_RESTAURANTS']));
    $page->SetParameter ('RESTRO_ID',$restaurant['id']);
    $page->SetParameter ('NAME',$restaurant['name']);
    $page->SetParameter ('STREET_HOUSE_NUMBER',$STREET_HOUSE_NUMBER);
    $page->SetParameter ('PLZ_CITY',$PLZ_CITY);
    $page->SetParameter ('PHONE', $restaurant['phone_number']);
    $page->SetParameter ('EMAIL', $email);
    $page->SetParameter ('FAX',$restaurant['fax_number']);
    $page->SetParameter ('SLUG',$restaurant['slug']);
    
    $page->SetParameter ('OVERALL_FOOTER', create_footer());
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
