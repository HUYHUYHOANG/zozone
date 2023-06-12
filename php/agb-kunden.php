<?php
$page = new HtmlTemplate ('templates/' . $config['tpl_name'] . '/agb-kunden.tpl');
$page->SetParameter ('OVERALL_HEADER', create_header($lang['AGB_KUNDEN']));
$page->SetParameter ('OVERALL_FOOTER', create_footer());
$page->CreatePageEcho();
?>
