<?php
if (checkloggedin()) {
    $errors = array();
    $cat = $image_menu = array();

    $ses_userdata = get_user_data($_SESSION['user']['username']);
    $currency = !empty($ses_userdata['currency']) ? $ses_userdata['currency'] : get_option('currency_code');

    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one();
   /// $settings = get_all_setting($_SESSION['user']['id']);
    $templates_setting = "all";//$settings['restaurant_template'];
    $restaurant_template = "classic-theme";
    if ($templates_setting == "all")
    {
       $restaurant_template =   get_restaurant_option($restaurant['id'], 'restaurant_template', 'classic-theme');
    }
    else
    {
        $restaurant_template =  $templates_setting;
    }

        if($restaurant_template == 'flipbook-pdf')
        {
            $result = ORM::for_table($config['db']['pre'] . 'pdf_menu')
            ->where('user_id', $_SESSION['user']['id'])
            ->find_one();
            if(!empty($result['name']))
            {
                $pdf_menu = $result['name'];
                $pdf_id = $result['id'];
            }
            else
            {
                $pdf_menu = '';
                $pdf_id = '';
            }
         

        }
        elseif($restaurant_template == 'flipbook-2')
        {
            $result = ORM::for_table($config['db']['pre'] . 'image_menu')
            ->where('user_id', $_SESSION['user']['id'])
            ->order_by_asc('position')
            ->find_many();

        foreach ($result as $info) {
            $image_menu[$info['id']]['id'] = $info['id'];
            $image_menu[$info['id']]['name'] = $info['name'];
            $image_menu[$info['id']]['image'] = !empty($info['image']) ? $info['image'] : 'default.png';
            $image_menu[$info['id']]['active'] = $info['active'];
        }
        }
        else
        {
            function get_menu_tpl_by_cat_id($menu_tpl, $cat_id)
            {
                global $config, $lang, $link;
    
                $menu = ORM::for_table($config['db']['pre'] . 'menu')
                    ->where(array(
                        'cat_id' => $cat_id,
                        'user_id' => $_SESSION['user']['id'],
                    ))
                    ->order_by_asc('position')
                    ->find_many();
                if ($menu->count()) {
                    $menu_tpl .= '<div class="cat-menu-items">';
                }
              
             
                foreach ($menu as $info2) {
                    $menuId = $info2['id'];
                    //select alle_aliases from qr_allegie a INNER JOIN qr_allegie_menu m ON a.id = m.alle_id WHERE m.menu_id = 1
                    $menu_allegie = ORM::for_table($config['db']['pre'] . 'allegie')
                                  ->table_alias('a')
                                  ->inner_join($config['db']['pre']."allegie_menu","a.id = am.alle_id",'am')
                                  ->where('am.menu_id',$menuId)
                                  ->find_many();
                                  $sAllegie  ='';
                                  foreach ($menu_allegie as $info) {
                                   if ($sAllegie == '')
                                   {
                                    $sAllegie .=  $info['alle_aliases'];
                                   }
                                   else
                                   {
                                    $sAllegie .=  ', '. $info['alle_aliases'];
                                   }
                                  }
                    $user_lang = !empty($_COOKIE['Quick_user_lang_code'])? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
                    $json = json_decode($info2['translation'],true);
    
            
                    $menuName = !empty($json[$user_lang]['title'])?$json[$user_lang]['title']:$info2['name'];
                    $menuImage = !empty($info2['image']) ? $info2['image'] : 'default.png';
                    $sMenu_id =!empty($info2['menu_res_id']) ? $info2['menu_res_id'] . '. ' : ''; 
    
                    $menu_tpl .= '
                    <div class="dashboard-box margin-top-0 margin-bottom-15" data-menuid="' . $menuId . '">
                        <div class="headline">
                                <h3><i class="icon-feather-menu quickad-js-handle"></i><img class="menu-avatar" src="' . $config['site_url'] . 'storage/menu/' . $menuImage . '" alt="' . $menuName . '"> ' . $sMenu_id  . $menuName . '</h3>
                                <div class="margin-left-auto">
                                <a href="#" data-id="' . $menuId . '" data-catid="' . $cat_id . '" class="button ripple-effect btn-sm copy_menu_item" title="' . $lang['COPY_MENU'] . '" data-tippy-placement="top"><i class="icon-feather-copy"></i></a>
                                    <a href="#" data-id="' . $menuId . '" data-catid="' . $cat_id . '" class="button ripple-effect btn-sm edit_menu_item" title="' . $lang['EDIT_MENU'] . '" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                        <a href="' . $link['MENU'] . '/' . $menuId . '" class="button ripple-effect btn-sm" title="' . $lang['EXTRAS'] . '" data-tippy-placement="top"><i class="icon-feather-layers"></i></a>
                                        <a href="#" data-id="' . $menuId . '" class="popup-with-zoom-anim button red ripple-effect btn-sm delete_menu_item" title="' . $lang['DELETE_MENU'] . '" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                </div>
                            </div>
                        </div>
                    ';
                }
                if ($menu->count()) {
                    $menu_tpl .= '</div>';
                }
                return $menu_tpl;
            }
    
            $result = ORM::for_table($config['db']['pre'] . 'catagory_main')
                ->where(array(
                    'user_id' => $_SESSION['user']['id'],
                    'parent' => 0
                ))
                ->order_by_asc('cat_order')
                ->find_many();
            $count = 0;
            foreach ($result as $info) {         
                $cat[$count]['id'] = $info['cat_id'];
    
                $user_lang = !empty($_COOKIE['Quick_user_lang_code'])? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
                $json = json_decode($info['translation'],true);
    
                $cat[$count]['name'] = !empty($json[$user_lang]['title'])?$json[$user_lang]['title']:$info['cat_name'];
    
                $cat[$count]['menu'] = '<div class="margin-bottom-30 text-center">' . $lang['MENU_NOT_AVAILABLE'] . '</div>';
    
                $menu_tpl = '';
    
                $sub_cats = ORM::for_table($config['db']['pre'] . 'catagory_main')
                    ->where(array(
                        'parent' => $info['cat_id']
                    ))
                    ->order_by_asc('cat_order')
                    ->find_many();
                if ($sub_cats->count()) {
                    $menu_tpl .= '<div class="js-accordion menu-subcategories">';
                }
                foreach ($sub_cats as $sub_cat) {
                    $user_lang = !empty($_COOKIE['Quick_user_lang_code'])? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
                    $json = json_decode($sub_cat['translation'],true);
    
                    $sub_cat_name = !empty($json[$user_lang]['title'])?$json[$user_lang]['title']:$sub_cat['cat_name'];
    
                    $menu_tpl .= '<div class="dashboard-box margin-top-0 margin-bottom-15 js-accordion-item" data-catid="' . $info['cat_id'] . '" data-subcatid="' . $sub_cat['cat_id'] . '">
    
                                <!-- Headline -->
                                <div class="headline js-accordion-header">
                                    <h3><i class="icon-feather-menu quickad-js-handle"></i> <span class="sub-category-display-name">' . $sub_cat_name . '</span></h3>
                                    <div class="margin-left-auto">
                                        <a href="#" data-catid="' . $sub_cat['cat_id'] . '" class="button ripple-effect btn-sm add_menu_item" title="' . $lang['ADD_MENU'] . '" data-tippy-placement="top"><i class="icon-feather-plus"></i></a>
                                        <a href="#" data-catid="' . $info['cat_id'] . '" data-subcatid="' . $sub_cat['cat_id'] . '" class="button ripple-effect btn-sm edit-sub-cat" title="' . $lang['EDIT_SUB_CATEGORY'] . '" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                        <a href="#" data-subcatid="' . $sub_cat['cat_id'] . '" class="popup-with-zoom-anim button red ripple-effect btn-sm delete-sub-cat" title="' . $lang['DELETE_SUB_CATEGORY'] . '" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                                    </div>
                                </div>
                                <div class="content with-padding padding-bottom-10 js-accordion-body" style="display: none">
                                    <div class="cat-menu-items">';
                    $menu_tpl = get_menu_tpl_by_cat_id($menu_tpl, $sub_cat['cat_id']);
                    $menu_tpl .= '</div>
                                </div>
                            </div>';
                }
                if ($sub_cats->count()) {
                    $menu_tpl .= '</div>';
                }
    
                $menu_tpl = get_menu_tpl_by_cat_id($menu_tpl, $info['cat_id']);
    
                $cat[$count]['menu'] = !empty($menu_tpl) ? $menu_tpl : $cat[$count]['menu'];
                $count++;
            }
        }
    //$setting = get_all_setting($restaurant->id);
    $RESTAURANT_MANAGER_MENU = get_module_settting($_SESSION['user']['id'],'menu');//$settings['allow_manager_menu'];
    $RESTAURANT_MENU_REDUCED = $RESTAURANT_MANAGER_MENU;//$settings['restaurant_menu_reduced'];
    if ($RESTAURANT_MANAGER_MENU == 1)
    {
        switch ($restaurant_template) {
            case "flipbook-2":
                $page = new HtmlTemplate ('templates/' . $config['tpl_name'] . '/menu-image.tpl');
                $page->SetLoop('IMAGE_MENU', $image_menu);
                break;
            case "flipbook-pdf":
                 $page = new HtmlTemplate ('templates/' . $config['tpl_name'] . '/menu-pdf.tpl');
                 $page->SetParameter('PDF_MENU', $pdf_menu);
                 $page->SetParameter('PDF_ID', $pdf_id);
                break;
             default:
                $page = new HtmlTemplate ('templates/' . $config['tpl_name'] . '/menu.tpl');
                break;
        }   
        $menu_lang = get_user_option($_SESSION['user']['id'],'restaurant_menu_languages','');
        $menu_lang = explode(',', $menu_lang);
    
        $language = array();
        if(!empty($menu_lang) && count($menu_lang) > 1) {
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
        $page->SetParameter('RESTAURANT_MENU_REDUCED',$RESTAURANT_MENU_REDUCED);
        $page->SetParameter('OVERALL_HEADER', create_header($lang['MANAGE_MENU']));
        $page->SetParameter('RESTAURANT_TEMPLATE', $restaurant_template);
        $page->SetParameter('SHOW_LANGS', count($language));
        $page->SetLoop ('LANGS', $language);
        $page->SetLoop('CATEGORY', $cat);
        $page->SetParameter('OVERALL_FOOTER', create_footer());
        $page->CreatePageEcho();
    }
    else
    {
        error_content($lang['PERMISSION_DENIED'], $lang['CONTENT_PERMISSION_DENIED']);
    }
} else {
    headerRedirect($link['LOGIN']);
}