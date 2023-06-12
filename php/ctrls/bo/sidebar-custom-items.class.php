<?php
//defined('LOAD_BO_SIDEBAR_TEMPL_FROM_FUNCTION') or die('');
require_once('base.class.php');

class CBOSidebarItems{
    public function __construct(&$out, &$rightMenu=null){
        /* $link : <home_dir>/includes/seo-url.php */
        /* $lang : <home_dir>/includes/lang/lang_<name>.php */
        global $lang, $link;
        
        $user = CBoCtrl::getUser();
        $items = self::getMenuItems($user->user_type);
        $user->name = !empty($user->name)?$user->name:$user->username;
        $current = $this->_getLastUriPart();        
        $s = '<div class="dashboard-nav"><div class="dashboard-nav-inner"><ul data-submenu-title="">';
        $s .= "<li><a style='cursor:default;'>
                    <img class='svg svg-dashboard-nav' src='{SITE_URL}templates/{TPL_NAME}/images/svg/user.svg'/> <strong>{$user->name}</strong>
                </a></li>";
        $rightMenu = '';        
        foreach($items as $item){
            if($item['title'] == 'DIVIDER'){
                $s .= '<div class="line-menu"></div>';
                $rightMenu .= '<div class="line-menu-right"></div>';
                continue;
            }
            
            $theLink = $this->_getLastUriPart($link[$item['link']]);
            $s .= sprintf('<li %s><a href="./%s"><img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/%s" /> %s</a></li>',
                            $current===$theLink ? 'class="active"' : '', $theLink, $item['icon'], $lang[$item['title']]);

            $rightMenu .= "<li ><a href='{$link[$item['link']]}'><img class='svg svg-dashboard-nav-small' src='{SITE_URL}templates/{TPL_NAME}/images/svg/{$item['icon']}'/><spacer style='width:12px;display:inline-block;'></spacer>{$lang[$item['title']]}</a></li>";
        }
        $s .= '</ul></div></div>';
        $rightMenu = '<ul class="user-menu-small-nav">' . $rightMenu . '</ul>';
        $out = $s;
    }

    public static function getMenuItems($userType){
        if($userType=='employer'){
            $items = array(
                        array('title' => 'DIVIDER'),
                        array('title' => 'BO_MENU_RESERVATIONS', 'icon' => 'schedule.svg', 'link' => 'RESERVATIONS'),
                        array('title' => 'DIVIDER'),
                        array('title' => 'BO_MENU_CUSTOMER_CARE', 'icon' => 'whatsapp.svg', 'link' => 'CUSTOMER_CARE'),
                        array('title' => 'DIVIDER'),
                        array('title' => 'ACCOUNT_SETTING', 'icon' => 'settings.svg', 'link' => 'ACCOUNT_SETTING'),
                        array('title' => 'DIVIDER'),
                        array('title' => 'LOGOUT', 'icon' => 'logout.svg', 'link' => 'LOGOUT')
                     );            
        }else{
            $items = array(
                array('title' => 'DIVIDER'),
                array('title' => 'DASHBOARD', 'icon' => 'speedomete.svg', 'link' => 'DASHBOARD'),
                array('title' => 'SERVICES', 'icon' => 'services.svg', 'link' => 'SERVICES'),
                array('title' => 'DIVIDER'),
                array('title' => 'VOUCHERS', 'icon' => 'discount.svg', 'link' => 'VOUCHERS'),
                array('title' => 'DIVIDER'),
                array('title' => 'BO_MENU_RESERVATIONS', 'icon' => 'schedule.svg', 'link' => 'RESERVATIONS'),
                array('title' => 'BO_MENU_RESERVATIONS_REPORT', 'icon' => 'calendar_year.svg', 'link' => 'RESERVATIONS_REPORT'),
                array('title' => 'BO_MENU_CUSTOMER_CARE', 'icon' => 'whatsapp.svg', 'link' => 'CUSTOMER_CARE'),
                array('title' => 'DIVIDER'),
                array('title' => 'BO_MENU_CUSTOMERS', 'icon' => 'groups.svg', 'link' => 'CUSTOMERS'),
                array('title' => 'BO_MENU_STAFFS', 'icon' => 'person_add.svg', 'link' => 'STAFFS'),
                array('title' => 'DIVIDER'),                
                array('title' => 'ACCOUNT_SETTING', 'icon' => 'settings.svg', 'link' => 'ACCOUNT_SETTING'),
                array('title' => 'WHATSAPP', 'icon' => 'whatsapp.svg', 'link' => 'WHATSAPP_ORDERING'),

                array('title' => 'WEBSITE', 'icon' => 'world.svg', 'link' => 'WEBSITE'),
                array('title' => 'DIVIDER'),
                array('title' => 'MESSAGE_TEMPLATES', 'icon' => 'web_design.svg', 'link' => 'MESSAGE_TEMPLATES'),
                array('title' => 'DIVIDER'),
                array('title' => 'LOGOUT', 'icon' => 'logout.svg', 'link' => 'LOGOUT')
            );
        }
        return $items;
    }
    
    private function _getLastUriPart($url=0){
        $matches = 0;
        if(!$url) $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $end = array_slice(explode('/', $url), -1);
        $end = trim($end[0]);
        $pos = strpos($end, '?');
        if($pos>1){
            $end = substr($end, 0, $pos);
        }
        return $end;
    }
}
?>