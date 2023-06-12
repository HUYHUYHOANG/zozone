<?php
if(!empty($_SESSION['customer']['slug']))
{
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
    ->where('slug', $_SESSION['customer']['slug'])
    ->find_one();  
   if (checkcustomerloggedin($restaurant['id'])) {
         
          $main_image = $restaurant['main_image'];
          $cover_image = $restaurant['cover_image'];
          $name = $restaurant['name'];
          $sub_title = $restaurant['sub_title'];
          $address = $restaurant['address'];
          $userdata = get_user_data(null, $restaurant['user_id']);
          $phone = $userdata['phone'];
          $restro_id = $restaurant['id'];
          $slug = $restaurant['slug'];
          $menu_lang = get_user_option( $restaurant['user_id'], 'restaurant_menu_languages', '');
          $menu_lang = explode(',', $menu_lang);
      
          $customer = ORM::for_table($config['db']['pre'] . 'customers')
          ->where('id', $_SESSION['customer']['id'])
          ->find_one();
          $customer_name = $customer['name'];
          $customer_phone_number = $customer['phone'];
          $customer_email = $customer['email'];
          $customer_address = $customer['address'];
          $customer_house_number = $customer['house_number'];
          $customer_street_name = $customer['street_name'];
          $customer_city = $customer['city'];
          $customer_zip_code = $customer['zip_code'];
      
          $language = array();
          if (!empty($menu_lang) && count($menu_lang) > 1) {
              $menu_languages = ORM::for_table($config['db']['pre'] . 'languages')
                  ->where('active', 1)
                  ->order_by_asc('name')
                  ->where_in('code', $menu_lang)
                  ->find_many();
              foreach ($menu_languages as $info) {
                  $language[$info['id']]['code'] = $info['code'];
                  $language[$info['id']]['name'] = $info['name'];
                  $language[$info['id']]['file_name'] = $info['file_name'];
              }
          }
          
          // Check if this is an Name availability check from signup page using ajax
      $page = new HtmlTemplate ('templates/' . $config['tpl_name'] . '/change-password.tpl'); 
      $page->SetParameter('OVERALL_HEADER', create_header($lang['RESTAURANT']));
      $page->SetParameter('SITE_TITLE', $config['site_title']);
      $page->SetParameter('SHOW_LANGS', count($language));
      $page->SetLoop('LANGS', $language);       
      $page->SetParameter('PAGE_TITLE', $name);
      $page->SetParameter('PAGE_LINK', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
      $page->SetParameter('PAGE_META_KEYWORDS', $config['meta_keywords']);
      $page->SetParameter('PAGE_META_DESCRIPTION', $config['meta_description']);
      $page->SetParameter('LANGUAGE_DIRECTION', get_current_lang_direction());
      $page->SetParameter('RESTRO_ID', $restro_id);
      $page->SetParameter('NAME', $name);
      $page->SetParameter('SUB_TITLE', $sub_title);
      $page->SetParameter('ADDRESS', $address);
      $page->SetParameter('PHONE', $phone);   
      $page->SetParameter('MAIN_IMAGE', $main_image);
      $page->SetParameter('COVER_IMAGE', $cover_image);  
      $page->SetParameter('CUSTOMER_EMAIL',$customer_email);
      $page->SetParameter('CUSTOMER_ID',$_SESSION['customer']['id']);
      $page->SetParameter('CUSTOMER_USERNAME', $_SESSION['customer']['username']);
      
      $page->SetParameter('SLUG',$slug);
      $themecolor = $config['theme_color'];
      $colors = array();
      list($r, $g, $b) = sscanf($themecolor, "#%02x%02x%02x");
      $i = 0.01;
      while ($i <= 1) {
          $colors["$i"]['id'] = str_replace('.', '_', $i);
          $colors["$i"]['value'] = "rgba($r,$g,$b,$i)";
          $i += 0.01;
      }
      $colors[1]['id'] = 1;
      $colors[1]['value'] = "rgba($r,$g,$b,1)";
      
      
      $page->SetLoop('COLORS', $colors);
      
      $classic_boder_color = get_restaurant_option($restro_id, 'restaurant_theme_color',$config['theme_color']);
      $classic_border_colors = array();
      list($r2, $g2, $b2) = sscanf($classic_boder_color, "#%02x%02x%02x");
      $i = 0.01;
      while ($i <= 1) {
          $classic_border_colors["$i"]['id'] = str_replace('.', '_', $i);
          $classic_border_colors["$i"]['value'] = "rgba($r2,$g2,$b2,$i)";
          $i += 0.01;
       }
        $classic_border_colors[1]['id'] = 1;
        $classic_border_colors[1]['value'] = "rgba($r2,$g2,$b2,1)";
        $page->setLoop('CLASSIC_COLOR',$classic_border_colors);
        $page->SetParameter('OVERALL_FOOTER', create_footer());
        $page->CreatePageEcho();
   }
   else
   {
       headerRedirect($link['INDEX']);
   }
}
else
{
    headerRedirect($link['INDEX']);
}


