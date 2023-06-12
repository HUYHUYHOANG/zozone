<?php

$facebook_link = get_option("facebook_link");
$twitter_link = get_option("twitter_link");
$instagram_link = get_option("instagram_link");
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

$page = new HtmlTemplate ('templates/' . $config['tpl_name'] . '/impressum-kunden.tpl');
$page->SetParameter ('OVERALL_HEADER', create_header($lang['DATA_PROTECTION_KUNDEN']));
$page->SetParameter ('PHONE',get_option("contact_phone"));
$page->SetParameter ('EMAIL',get_option("contact_email"));
$page->SetParameter ('FAX',get_option("contact_fax"));
$page->SetParameter ('OWNER',get_option("contact_owner"));
$page->SetParameter ('TAXCODE',get_option("contact_tax_code"));
$page->SetParameter ('FACEBOOK_LINK',get_option("facebook_link"));
$page->SetParameter ('TWITTER_LINK',get_option("twitter_link"));
$page->SetParameter ('INSTAGRAM_LINK',get_option("instagram_link"));
$page->SetParameter ('SOCIAL_TEXT',$social_text);
$page->SetParameter ('SITE_URL',get_option("site_url"));
$page->SetParameter ('OVERALL_FOOTER', create_footer());
$page->CreatePageEcho();
?>
