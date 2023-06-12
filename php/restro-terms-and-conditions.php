<?php
if(!empty($_GET['id']))
{
 $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
 ->find_one($_GET['id']);
 if(!empty($restaurant['id']))
 {
    $STREET_HOUSE_NUMBER = $restaurant['street_name'] . '. ' . $restaurant['house_number'];
    $PLZ_CITY = $restaurant['zipcode'] . ' ' . $restaurant['city'];
    $userdata = get_user_data(null, $restaurant['user_id']);
    $email = $userdata['email'];
    $OWNER = $userdata['name'];
    $facebook_link = get_restaurant_option($restaurant['id'], 'restaurant_link_facebook');
$twitter_link = get_restaurant_option($restaurant['id'], 'restaurant_link_twitter');
$instagram_link = get_restaurant_option($restaurant['id'], 'restaurant_link_instagram');
$social_text = '';

if(!empty($facebook_link))
{
    $social_text .= '<a href="' . $facebook_link . '">Facebook</a>';
}
if(!empty($twitter_link))
{
    if(!empty($social_text))
    {
        $social_text .= ', <a href="' . $twitter_link . '">Twitter</a>';
    }
    else
    {
        $social_text .= ' <a href="' . $twitter_link . '">Twitter</a>';
    }
}
if(!empty($instagram_link))
{
    if(!empty($social_text))
    {
        $social_text .= ', <a href="' . $instagram_link . '">Instagram</a>';
    }
    else
    {
        $social_text .= ' <a href="' . $instagram_link . '">Instagram</a>';
    }
}
    $page = new HtmlTemplate ('templates/' . $config['tpl_name'] . '/impressum-restaurants.tpl');
    $page->SetParameter ('OVERALL_HEADER', create_header($lang['AGB_RESTAURANTS']));
    $page->SetParameter ('RESTRO_ID',$restaurant['id']);
    $page->SetParameter ('RESTAURANT_NAME',$restaurant['name']);
    $page->SetParameter ('STREET_HOUSE_NUMBER',$STREET_HOUSE_NUMBER);
    $page->SetParameter ('PLZ_CITY',$PLZ_CITY);
    $page->SetParameter ('PHONE', $restaurant['phone_number']);
    $page->SetParameter ('SLUG', $restaurant['slug']);
    $page->SetParameter ('OWNER', $OWNER);
    $page->SetParameter ('TAXCODE', $restaurant['taxcode']);
    $page->SetParameter ('EMAIL', $email);
    $page->SetParameter ('FAX',$restaurant['fax_number']);
    $page->SetParameter ('SOCIAL_TEXT',$social_text);
    $page->SetParameter ('FACEBOOK_LINK',get_restaurant_option($restaurant['id'], 'restaurant_link_facebook'));
    $page->SetParameter ('INSTAGRAM_LINK',get_restaurant_option($restaurant['id'], 'restaurant_link_instagram'));
    $page->SetParameter ('TWITTER_LINK',get_restaurant_option($restaurant['id'], 'restaurant_link_twitter'));
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
