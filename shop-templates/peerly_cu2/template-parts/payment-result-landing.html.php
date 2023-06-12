<!DOCTYPE html>
<html  lang="{LANG_CODE}" dir="{LANGUAGE_DIRECTION}" data-menu="classicmenu">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="HandheldFriendly" content="True">

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

    <link rel="shortcut icon" href="{SITE_URL}storage/logo/{SITE_FAVICON}"/>

    <title>IF("{PAGE_TITLE}"!=""){ {PAGE_TITLE} - {:IF}{SITE_TITLE}</title>
	
	<!-- STYLESHEETS -->
	<link rel="stylesheet" href="{SITE_URL}includes/assets/css/icons.css">
	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/plugins.css">
	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/style.min.css">
	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/templete.min.css">
	
	<!--CUSTOMS FONT FACES FROM SETTINGS -->
	{CUSTOM_SETTING_FONT_FACES_AND_CLASSES}
	<!--END CUSTOMS FONT FACES FROM SETTINGS -->

	<!--customized style-->
	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/shop-nail.css?v={VERSION}&t={SHOP_TIME_NOW}"/>
	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/reset-and-customized.css?v={VERSION}&t={SHOP_TIME_NOW}"/>
	IF("{RESTAURANT_CHANGE_HOME_BACKGROUND_IMAGE}" == "1"){        
        <link class="skin" rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/skin/skin-3.css?v={VERSION}">
    {ELSE}
        <link class="skin" rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/skin/skin-2.css?v={VERSION}">
    {:IF}
	
	IF("{MENU_FLAT_ICON_CODE}"!=""){
	<style>
		@font-face {
			font-family: "Flaticon";
			src: url("{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/fonts/flaticon/Flaticon.eot");
			src: url("{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/fonts/flaticon/Flaticond41d.eot?#iefix") format("embedded-opentype"),
				url("{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/fonts/flaticon/Flaticon.woff") format("woff"),
				url("{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/fonts/flaticon/Flaticon.ttf") format("truetype"),
				url("{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/fonts/flaticon/Flaticon.svg#Flaticon") format("svg");
			font-weight: normal;
			font-style: normal;
		}
		.header-nav .nav>li>a:after{
			content: "{MENU_FLAT_ICON_CODE}";
		}
	</style>
	{:IF}
	
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Alumni+Sans');
		@import url('https://fonts.googleapis.com/css?family=Dancing+Script');		
		
		:root{  
			{LOOP: CLASSIC_COLOR}--classic-color-{CLASSIC_COLOR.id}: {CLASSIC_COLOR.value};{/LOOP: CLASSIC_COLOR} 
			--menu-fore-color: {RESTAURANT_MENU_FORE_COLOR};
			--menu-color: {RESTAURANT_MENU_COLOR};
		}
		#loading-area, div.loading{
			background-repeat: no-repeat;
			background-size: 120px ,  200px;
    		background-position: center;
		}
		#loading-area{
			background-color:#FAFAFA; opacity: 0.2;
			background-image:url({SITE_URL}shop-templates/{SHOP_TEMPLATE}/images/loading.svg.php?clr={DEFAULT_LINK_COLOR}),
							url({SITE_URL}shop-templates/{SHOP_TEMPLATE}/images/about/loading.png) !important;
			opacity:0.9;	
		}
		div.loading, .loading{
			background-image:url({SITE_URL}shop-templates/{SHOP_TEMPLATE}/images/loading.svg.php?clr={DEFAULT_LINK_COLOR}) !important;
			background-size: 60px,100px;
			min-height:50px;
		}

		button[type="button"].disabled.loading, button[type="submit"].disabled.loading{
			background-size: 42px 42px;
			background-position: center center;
			background-repeat: no-repeat;
			cursor: default;
		}

		.spa-header .extra-nav{padding:0 !important;}
		.header-transparent .main-bar{background-color: var(--classic-color-0_3);}

		.form-msg{display: none;}
		#dzcommon-customer-form-container .input-group{margin:15px 0 !important;}
		#dzcommon-customer-form-container a{color:var(--classic-color-1);}
		#dzcommon-customer-form-container input.form-control{line-height:48px !important;height: 48px !important;}
		#dzcommon-customer-form-container .site-button{height:48px !important;}

		.input-group-append .toggle-password{
			background-color: #fff; cursor: pointer;
			color: var(--classic-color-1);font-size:20px;
		}
		.input-group-append .toggle-password:hover{
			background-color: var(--classic-color-1);color:#FFF;
		}
	</style>

	<script type="text/javascript">
		var gaCategories = [];
		var zozoneNailParams = {
			bookingSiteURI 	: '{SITE_URL}{SLUG}/booking/',
			loginSiteURI 	: '{SITE_URL}{SLUG}/login?return={RETURN_URL}',
			returnURL		: '{RETURN_URL}',
			langName	: '{CURRENT_LANGUAGE_NAME}',
			langCode	: '{CURRENT_LANGUAGE_CODE}',
			ajaxURL		: '{SITE_URL}php/?{SHOP_BOOKING_TOKEN}',
			apiKey		: '{SHOP_BOOKING_TOKEN}',
			theForm		: '{THE_REQUEST_FORM}'			
		};
	</script>
</head>
<body id="bg">
<div class="page-wraper">
<div id="loading-area"></div>
	<!-- header -->
	<header class="site-header header header-transparent mo-left onepage spa-header ">
		<!-- main header -->
        <div class="sticky-header main-bar-wraper navbar-expand-lg">
            <div class="main-bar clearfix ">
                <div class="container clearfix">
                    <!-- website logo -->
                    <div class="logo-header mostion">						
						<a href="{SITE_URL}{SLUG}" class="dez-page"><img src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}" data-src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}"></a>
					</div>
                    <!-- nav toggle button -->
                    <button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span></span>
						<span></span>
						<span></span>
					</button>
					
					<!-- extra nav -->
                    <div class="extra-nav" style="display:table;">
                        <div class="extra-cell_001" style="display:table-cell;vertical-align:middle;">
							<div class="dzlang-menu">
								<div class="site-button scroll radius-no"><a href="javascript:;" class="dzlang-menu-btn flag-selected flag-German">German</a></div>
								<div class="dzlang-menu-content">									
									{LOOP: LANGS}
										<a href="#" class="flag-{LANGS.name}" data-lang="{LANGS.file_name}" data-code="{LANGS.code}">{LANGS.name}</a>
									{/LOOP: LANGS}
								</div>
							</div>
                        </div>
                    </div>
					
                    <!-- main nav -->
                    <div class="header-nav navbar-collapse navbar collapse justify-content-end" id="navbarNavDropdown">
						<ul class="nav navbar-nav navbar menu-font-options">	
							<li><a class="dez-page" href="{SITE_URL}{SLUG}#dzhome">{LANG_HOME}</a></li>
							<li><a class="dez-page" href="{SITE_URL}{SLUG}#dzaboutme">{LANG_ABOUT_ME}</a></li>
							<li>
								<a class="dez-page" href="{SITE_URL}{SLUG}#dzservices">{LANG_SERVICES} <i class="fa fa-chevron-down"></i></a>
								<ul class="sub-menu">
									{LOOP: CAT_MENU_2} 
                                	<li><a href="{SITE_URL}{SLUG}#dzservice-{CAT_MENU_2.id}">{CAT_MENU_2.name}</a></li>  									
                                	{/LOOP: CAT_MENU_2}
								</ul>
							</li>	
							IF("{SHOP_DISPLAY_GROUP_IMAGE}"=="1"){
							<li><a class="dez-page" href="{SITE_URL}{SLUG}#dzportfolio">{LANG_GALLERY}</a></li>
							{:IF}
							IF("{SHOP_OUR_STAFFS_DISPLAY}" == "1"){
							<li><a class="dez-page" href="{SITE_URL}{SLUG}#dzstaffs">{LANG_OUR_STAFFS}</a></li>
							{:IF}
							<li><a class="dez-page" href="{SITE_URL}{SLUG}#dzcontact">{LANG_CONTACT}</a></li>
							<li><a href="{SITE_URL}{SLUG}/booking">{LANG_BOOK_NOW}</a></li>
							<!--
							IF("{LOGGED_IN}"=="1"){
								<li><a class="loginout" data-action="logout" href="#">{LANG_LOGOUT}</a></li>
							{ELSE}
							<li><a class="loginout" data-action="login" href="#">{LANG_LOGIN}</a></li>
							{:IF}
							-->
						</ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- main header END -->
    </header>
		
    <!-- header END -->
    <!-- Content -->
    <div class="page-content bg-white">
		<!-- Main Slider -->
        <div id="dzhome" style="min-height:200px"></div>
		<div id="dzservice">
			<div class="container row" style="margin:0 auto;">
				<h1 class="col-lg-12 font-weight-bold text-center mb-30">
				{PAYMENT_RESULT}				
				</h1>
			</div>		
		</div>
	</div>
    <!-- Content END-->

	<!-- Footer -->
    <footer class="site-footer footer-white bridal-footer">
		<div class="footer-top">
            <div class="container">
				<div class="dlab-divider bg-gray-dark"><i class="icon-dot c-square"></i></div>				
                <div class="row d-flex dzfooter-info">
					<div class="col-xl-3 col-12 col-lg-3 col-md-6 col-sm-6">
                        <div class="widget">
                            <h6>{LANG_PHONE} &amp; {LANG_EMAIL_ADDRESS}</h6>
                            <ul>
								IF("{PHONE}"!=""){
                                <li><i class="fa fa-phone"></i><a href="tel:{PHONE}">{PHONE}</a> <br>
								{:IF}
								IF("{EMAIL}"!=""){
									<i class="fa fa-envelope"></i><a href="mailto:{EMAIL}">{EMAIL}</a></li>
								{:IF}
                            </ul>
                        </div>
                    </div>
					<div class="col-xl-3 col-12 col-lg-3 col-md-6 col-sm-6">
                        <div class="widget">
                            <h6>{LANG_ADDRESS}</h6>
                            <ul>
                                <li><i class="fa fa-map-marker"></i><a target="_blank" href="https://maps.google.com/?q={ADDRESS}">{ADDRESS}</a></li>
                            </ul>
                        </div>
                    </div>
					<div class="col-xl-6 col-12 col-lg-6 col-md-12 col-sm-12">
                        <div class="widget">
                            <h6>{LANG_OPEN_HOUR}</h6>
                            <ul class="dzopen-hour-list" style="width:100%;">
								<li>{LANG_MONDAY} <span>{OPEN_HOUR_2}</span></li>
								<li>{LANG_TUESDAY} <span>{OPEN_HOUR_3}</span></li>
								<li>{LANG_WEDNESDAY}<span>{OPEN_HOUR_4}</span></li>
								<li>{LANG_THURSDAY} <span>{OPEN_HOUR_5}</span></li>
								<li>{LANG_FRIDAY} <span>{OPEN_HOUR_6}</span></li>
								<li>{LANG_SATURDAY} <span>{OPEN_HOUR_7}</span></li>
								<li>{LANG_SUNDAY} <span>{OPEN_HOUR_1}</span></li>
							</ul>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
		
		<div class="container dzbottom-line">
			<div class="row">
				<div class="col-lg-6 col-sm-6 col-xs-6 bottom-line-text"><a href="">{COPYRIGHT_TEXT}</a></div>
				<div class="col-lg-6 col-sm-6 col-xs-6 bottom-line-text text-right">
					<a class="right-ft-link" href="{LINK_AGB_RESTAURANTS}?id={SHOP_ID}">AGB</a>
					<a class="right-ft-link" href="{LINK_DATA_PROTECTION_RESTAURANTS}?id={SHOP_ID}">Datenschutzerklärung</a>
					<a class="right-ft-link" href="{LINK_IMPRESSUM_RESTAURANTS}?id={SHOP_ID}">Impressum</a>
				</div>
			</div>
		</div>
    </footer>	
    <!-- Footer END-->
    <button class="scroltop fa fa-chevron-up" ></button>
</div>

<!-- JAVASCRIPT FILES ========================================= -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/jquery.min.js"></script><!-- JQUERY.MIN JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/custom.js"></script><!-- JQUERY.MIN JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/wow/wow.js"></script><!-- WOW JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/bootstrap/js/popper.min.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/bootstrap/js/bootstrap.min.js"></script><!-- BOOTSTRAP.MIN JS -->

<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/jquery.cookie.min.js?v={VERSION}"></script><!-- SHOP API  -->
<script type="text/javascript" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/customer.js.php?v={VERSION}&t={SHOP_TIME_NOW}"></script>
</body>
</html>
