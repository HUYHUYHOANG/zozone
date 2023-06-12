<!DOCTYPE html>
<html lang="{LANG_CODE}" dir="{LANGUAGE_DIRECTION}">
<head>
    <title>IF("{PAGE_TITLE}"!=""){ {PAGE_TITLE} - {:IF}{SITE_TITLE}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="{SITE_TITLE}">
    <meta name="keywords" content="{PAGE_META_KEYWORDS}">
    <meta name="description" content="{PAGE_META_DESCRIPTION}">

    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//google.com">
    <link rel="dns-prefetch" href="//apis.google.com">
    <link rel="dns-prefetch" href="//ajax.googleapis.com">
    <link rel="dns-prefetch" href="//www.google-analytics.com">
    <link rel="dns-prefetch" href="//pagead2.googlesyndication.com">
    <link rel="dns-prefetch" href="//gstatic.com">
    <link rel="dns-prefetch" href="//oss.maxcdn.com">

    <meta property="fb:app_id" content="{FACEBOOK_APP_ID}"/>
    <meta property="og:site_name" content="{SITE_TITLE}"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:url" content="{PAGE_LINK}"/>
    <meta property="og:title" content="IF("{PAGE_TITLE}"!=""){ {PAGE_TITLE} - {:IF}{SITE_TITLE}" />
    <meta property="og:description" content="{PAGE_META_DESCRIPTION}"/>
    <meta property="og:type" content="{META_CONTENT}"/>
    IF("{META_CONTENT}"=="article"){
    <meta property="article:author" content="#"/>
    <meta property="article:publisher" content="#"/>
    <meta property="og:image" content="{META_IMAGE}"/>
    {:IF}
    IF("{META_CONTENT}"=="website"){
    <meta property="og:image" content="{META_IMAGE}"/>
    {:IF}
    <meta property="twitter:card" content="summary">
    <meta property="twitter:title" content="{PAGE_TITLE} - {SITE_TITLE}">
    <meta property="twitter:description" content="{PAGE_META_DESCRIPTION}">
    <meta property="twitter:domain" content="{SITE_URL}">
    <meta name="twitter:image:src" content="{META_IMAGE}"/>
    <link rel="shortcut icon" href="{SITE_URL}storage/logo/{SITE_FAVICON}">
    <script async>
        var themecolor = '{THEME_COLOR}';
        var mapcolor = '{MAP_COLOR}';
        var siteurl = '{SITE_URL}';
        var template_name = '{TPL_NAME}';
        var ajaxurl = "{SITE_URL}php/{QUICKAD_USER_SECRET_FILE}.php";
    </script>
    <style>
        :root{{LOOP: COLORS}--theme-color-{COLORS.id}: {COLORS.value};{/LOOP: COLORS}
        {LOOP: CLASSIC_COLOR}--classic-color-{CLASSIC_COLOR.id}: {CLASSIC_COLOR.value};{/LOOP: CLASSIC_COLOR} 
    }
    </style>

    <link rel="stylesheet" href="{SITE_URL}includes/assets/css/icons.css">    
    <link rel="stylesheet" href="{SITE_URL}templates/{TPL_NAME}/css/color-picker.min.css?ver={VERSION}">
    <link rel="stylesheet" href="{SITE_URL}templates/{TPL_NAME}/css/style.css?ver={VERSION}">    
    <link rel="stylesheet" href="{SITE_URL}templates/{TPL_NAME}/css/color.css?ver={VERSION}">
    <link rel="stylesheet" href="{SITE_URL}templates/{TPL_NAME}/css/table.css?ver={VERSION}">
    <link rel="stylesheet" id="css-font-awesome" href="{SITE_URL}templates/{TPL_NAME}/css/font-awesome.css?ver={VERSION}" />
    <link rel="stylesheet" id="css-ionicons" href="{SITE_URL}templates/{TPL_NAME}/css/ionicons.css?ver={VERSION}" />
    <link href="{SITE_URL}templates/{TPL_NAME}/css/sweetalert.css?ver={VERSION}" rel="stylesheet" type="text/css">
 
    <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/slick/slick-theme.css">    

    <script src="{SITE_URL}templates/{TPL_NAME}/js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">        
        var boConfigParams = {
            boSvrSide           : './php/ctrls/bo?{USER_AUTH_STRING}',
            selectedStaffIDs    : 0
        };
    </script>

    IF("{LANGUAGE_DIRECTION}"=="rtl"){
    <link rel="stylesheet" href="{SITE_URL}templates/{TPL_NAME}/css/rtl.css?ver={VERSION}">
    {:IF}

    <!-- ===External Code=== -->
    {EXTERNAL_CODE}
    <!-- ===/External Code=== -->

    <!-- ===CUSTOM CSS FILES=== -->
    {CUSTOM_CSS_FILES}
    <!-- ===/CUSTOM CSS FILES=== -->     
</head>
<body class="{LANGUAGE_DIRECTION}">
    <!--[if lt IE 8]>
    <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
        your browser</a> to improve your experience.
    </p>
    <![endif]-->
    <!-- Wrapper -->
    <div id="wrapper" class="">
        <header id="header-container" class="fullwidth">
            IF("{USERSTATUS}"=="0" && "{NON_ACTIVE_MSG}"=="1"){
            <div class="user-status-message">
                <div class="container container-active-msg">
                    <div class="row">
                        <div class="col-lg-8">
                            <i class="icon-lock text-18"></i>
                            <span>{LANG_WELCOME} <strong>{USERNAME}</strong>, {LANG_GOTO_UR_EMAIL} <strong>{USEREMAIL}</strong>  {LANG_VERIFY_EMAIL_ADDRESS}</span>
                        </div>
                        <div class="col-lg-4">
                            <a class="button ripple-effect" rel="nofollow" target="_blank" role="button" href="http://{EMAILDOMAIN}/">{LANG_GOTO_UR_EMAIL}</a>
                            <a class="button ripple-effect gray resend_buttons{USER_ID} resend" href='javascript:void(0);' id="{USER_ID}">{LANG_RESEND_EMAIL}</a>
                            <span class='resend_count' id='resend_count{USER_ID}'></span>
                        </div>
                    </div>
                </div>
            </div>
            {:IF}
            <!-- Header -->
            <div id="header">
                <div class="container">
                    <!-- Left Side Content -->
                    <div class="left-side">
                        <!-- Logo -->
                        <div id="logo">
                            <a href="{LINK_INDEX}"><img src="{SITE_URL}storage/logo/{SITE_LOGO}" alt="{SITE_TITLE}"></a>
                        </div>
                    </div>
                    <!-- Left Side Content / End -->
                    <!-- Right Side Content / End -->
                    <div class="right-side">
                        <!-- User Menu -->
                        <div class="header-widget">
                            IF('{USERNAME}'==""){
                            <a href="#sign-in-dialog" class="popup-with-zoom-anim button ripple-effect">{LANG_JOIN_NOW}</a>
                            {ELSE}
                            <div class="header-notifications user-menu">
                                <div class="header-notifications-trigger">
                                    <a href="#"><div class="user-avatar"><img src="{SITE_URL}storage/shop/logo/{SHOP_MAIN_IMAGE}" alt="{USERNAME}"></div></a>                                  
                                </div>
                                <!-- Dropdown -->
                                <div class="header-notifications-dropdown">                                    
                                    {OVERALL_RIGHT_NOTIFICATION_MENU}
                                </div>
                            </div>
                            {:IF}
                        </div>
                        IF({LANG_SEL}){
                        <div class="header-widget">
                            <div class="btn-group bootstrap-select language-switcher">
                                <button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown"
                                        title="English">
                                    <span class="filter-option pull-left" id="selected_lang">GE</span>&nbsp;
                                    <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu scrollable-menu open">
                                    <ul class="dropdown-menu inner">
                                        {LOOP: LANGS}
                                            <li data-lang="{LANGS.file_name}">
                                                <a role="menuitem" tabindex="-1" rel="alternate"
                                                   href="{LINK_HOME}/{LANGS.code}">{LANGS.name}</a>
                                            </li>
                                        {/LOOP: LANGS}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {:IF}
                    </div>
                    <!-- Right Side Content / End -->
                </div>
            </div>
            <!-- Header / End -->
            <!-- Header Container / End -->
        </header>
        <div class="clearfix"></div>
