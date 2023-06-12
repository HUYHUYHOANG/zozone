<?php

$page = new HtmlTemplate ('templates/' . $config['tpl_name'] . '/data-protection-kunden.tpl');
$page->SetParameter ('OVERALL_HEADER', create_header($lang['DATA_PROTECTION_KUNDEN']));
$page->SetParameter ('PHONE',get_option("contact_phone"));
$page->SetParameter ('EMAIL',get_option("contact_email"));
$page->SetParameter ('FAX',get_option("contact_fax"));
$page->SetParameter ('OVERALL_FOOTER', create_footer());
$page->CreatePageEcho();
?>
