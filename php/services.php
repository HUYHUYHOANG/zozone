<?php
if (checkloggedin()) {

    if(isEmployer()){
        headerRedirect('./reservations'); exit;
    }    
    
    $errors = array();
    $cat = $image_menu = array();
    $search_string = '';

    if(!isset($_GET['page']))
        $page = 1;
    else
        $page = $_GET['page'];

// $limit = 100;
// $offset = ($page - 1) * $limit;
// $total_product = 0;

    if(isset($_GET['searchString']))
    {
     $search_string = trim($_GET['searchString']);     
    }
    $ses_userdata = get_user_data($_SESSION['user']['username']);
    $currency = !empty($ses_userdata['currency']) ? $ses_userdata['currency'] : get_option('currency_code');

    $shop = ORM::for_table($config['db']['pre'] . 'shop')
        ->where('id', $_SESSION['user']['shop_id'])
        ->find_one();
            function get_menu_tpl_by_cat_id($menu_tpl, $cat_id)
            {              
                
                global $config, $lang, $link,$search_string,$page_tpl;
                if(!isset($_GET['page']))
                $page = 1;
            else
                $page = $_GET['page'];

            if($_GET['cat_id'] != $cat_id)
               {
                $page = 1;
               }
            $limit = 100;
            $offset = ($page - 1) * $limit;
            $total_service = 0;
                    
                    if(!empty($search_string))
                    {
                        $total_service = 0;             
                        $sql = "SELECT distinct m.* FROM ". $config['db']['pre']  ."menu m  WHERE  m.cat_id = " .$cat_id . " and m.shop_id = ".  $_SESSION['user']['shop_id'] ." and m.name like '%" . $search_string . "%' limit " . $limit;
                        $menu = ORM::for_table($config['db']['pre'] . 'menu')->raw_query($sql)->find_many();                        
                    }
                    else
                    {
                         $menu_query = ORM::for_table($config['db']['pre'] . 'menu')
                        ->where(array(
                            'cat_id' => $cat_id,
                            'shop_id' => $_SESSION['user']['shop_id']
                        ))
                        ->order_by_asc('position');
                        $total_service = $menu_query->count();
                        $menu = $menu_query
                        ->limit($limit)
                        ->offset($offset)
                        ->find_many();
                      
                    }
                    
                if ($menu->count()) {
                    $menu_tpl .= '<div class="cat-menu-items">';
                }else return false;

                $page_tpl = '';
                $SHOW_PAGING = (int)($total_service > $limit);
                if ($SHOW_PAGING) {
                    $page_tpl .= '<div class="pagination-container margin-top-20"><nav class="pagination"><ul>';
                
                $paging = pagenav($total_service, $page, $limit, $link['SERVICES'],0,false);
                foreach ($paging as $p) {
                    if($p['current']=="0")
                    {
                     $page_tpl .= '<li><a href="'. $p['link'] .'&cat_id='. $cat_id .'">'.$p['title'].'</a></li>';
                    }
                    else
                    {
                     $page_tpl .= '<li><a href="#" class="current-page">'.$p['title'].'</a></li>';
                    }
           
                 }
                    $page_tpl .= '</ul></nav></div>';
                }
                    
                foreach ($menu as $info2) {
                    $menuId = $info2['id'];
                    //select alle_aliases from qr_allegie a INNER JOIN qr_allegie_menu m ON a.id = m.alle_id WHERE m.menu_id = 1
                 
                    //$user_lang = !empty($_COOKIE['Quick_user_lang_code'])? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
                    $user_lang = $config['lang_code'];
                    $json = json_decode($info2['translation'],true);
    
                    $menuName = !empty($json[$user_lang]['title'])?$json[$user_lang]['title']:$info2['name'];
                    $menuImage = !empty($info2['image']) ? $info2['image'] : 'default.png';
                    $sMenu_id =!empty($info2['menu_res_id']) ? $info2['menu_res_id'] . '. ' : ''; 
    
                    $menu_tpl .= '
                    <div class="dashboard-box margin-top-0 margin-bottom-15" data-menuid="' . $menuId . '">
                        <div class="headline">
                                <h3><i class="icon-feather-menu quickad-js-handle"> </i> <img class="menu-avatar" src="' . $config['site_url'] . 'storage/menu/' . $menuImage . '" alt="' . $menuName . '">' .   $menuName . '</h3>
                                <div class="margin-left-auto">
                                <a href="#" data-id="' . $menuId . '" data-catid="' . $cat_id . '" class="button ripple-effect btn-sm copy_menu_item" title="' . $lang['COPY_MENU'] . '" data-tippy-placement="top"><i class="icon-feather-copy"></i></a>
                                    <a href="#" data-id="' . $menuId . '" data-catid="' . $cat_id . '" class="button ripple-effect btn-sm edit_menu_item" title="' . $lang['EDIT_MENU'] . '" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>                                      
                                        <a href="#" data-id="' . $menuId . '" class="button red ripple-effect btn-sm delete_menu_item" title="' . $lang['DELETE_MENU'] . '" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
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

            if(!empty($search_string))
            {
                $sql = "SELECT distinct cat_id FROM ". $config['db']['pre']  ."menu WHERE shop_id = ".  $_SESSION['user']['shop_id'] ." and name like '%" . $search_string . "%' ";                                
            $result_cat_id = ORM::for_table($config['db']['pre'] . 'menu')->raw_query($sql)->find_many();  
            $arTable= array();
            $cat_id = array();
            array_push($cat_id,'0');
            foreach ($result_cat_id as $info) {
                array_push($cat_id,$info['cat_id']);
            }
            $result = ORM::for_table($config['db']['pre'] . 'catagory_main')
            ->where(array(
                'shop_id' => $_SESSION['user']['shop_id'],
                'parent' => 0
            ))
            ->where_in('cat_id', $cat_id)->find_many()
            ->order_by_asc('cat_order')
            ->find_many();
            }
            else
            {                
                $result = ORM::for_table($config['db']['pre'] . 'catagory_main')
                ->where(array(
                    'shop_id' => $_SESSION['user']['shop_id'],
                    'parent' => 0
                ))
                ->order_by_asc('cat_order')
                ->find_many();

            }  
            $count = 0;
            $page_tpl= '';            
            
            foreach ($result as $info) {         
                $cat[$count]['id'] = $info['cat_id'];
                $cat[$count]['display'] = 'none';
                if($_GET['cat_id'] == $info['cat_id'])
                {
                    $cat[$count]['display'] = 'block';
                }                
                
                //$user_lang = !empty($_COOKIE['Quick_user_lang_code'])? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
                $user_lang = $config['lang_code'];
                $json = json_decode($info['translation'],true);
                //echo $user_lang;
                //print_r($json);
                $cat[$count]['name'] = !empty($json[$user_lang]['title'])?$json[$user_lang]['title']:$info['cat_name'];
    
                $cat[$count]['menu'] = '<div class="margin-bottom-30 text-center">' . $lang['MENU_NOT_AVAILABLE'] . '</div>';
    
                $menu_tpl = '';
                if(empty($search_string))
                {
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
                                        <a href="#" data-catid="' . $sub_cat['cat_id'] . '" class="button ripple-effect btn-sm add_menu_item" title="' . $lang['ADD_SERVICE'] . '" data-tippy-placement="top"><i class="icon-feather-plus"></i></a>
                                        <a href="#" data-catid="' . $info['cat_id'] . '" data-subcatid="' . $sub_cat['cat_id'] . '" class="button ripple-effect btn-sm edit-sub-cat" title="' . $lang['EDIT_SUB_CATEGORY'] . '" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                        <a href="#" data-subcatid="' . $sub_cat['cat_id'] . '" class="button red ripple-effect btn-sm delete-sub-cat" title="' . $lang['DELETE_SUB_CATEGORY'] . '" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
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
            }
                $menu_tpl = get_menu_tpl_by_cat_id($menu_tpl, $info['cat_id']);             
                $cat[$count]['paging'] = !empty($page_tpl) ? $page_tpl :'';
                $cat[$count]['menu'] = !empty($menu_tpl) ? $menu_tpl : $cat[$count]['menu'];
                $count++;
            }
        
    //$setting = get_all_setting($restaurant->id);
    $SHOP_MANAGER_MENU =  1;// $settings['allow_manager_menu'];
    $SHOP_MENU_REDUCED = 1;//$settings['restaurant_menu_reduced'];
    if ($SHOP_MANAGER_MENU == 1)
    {  
        $page = new HtmlTemplate ('templates/' . $config['tpl_name'] . '/services.tpl'); 
        $menu_lang = get_user_option($_SESSION['user']['id'],'shop_menu_languages','');
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
        $cat_id = '';
        if(!empty($_GET['cat_id']))
        {
            $cat_id = $_GET['cat_id'];
        }

    
        $page->SetParameter('SHOP_MENU_REDUCED',$SHOP_MENU_REDUCED);
        $page->SetParameter('OVERALL_HEADER', create_header($lang['MANAGE_SERVICES']));
        $rightMenu = '';
        $page->SetParameter ('OVERALL_SIDEBAR', sidebar_add_custom_menu_items($rightMenu));
        $page->SetParameter ('OVERALL_RIGHT_NOTIFICATION_MENU', $rightMenu);
        
        $page->SetParameter('CUSTOM_CSS_FILES', '');
        $page->SetParameter('SHOP_TEMPLATE', $shop_template);
        $page->SetParameter('SHOW_LANGS', count($language));
        $page->SetParameter('SEARCH_STRING',$search_string);
        $page->SetParameter('CAT_ID',$cat_id);      
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