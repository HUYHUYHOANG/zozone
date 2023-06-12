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
	
	<link class="skin" rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/smartwizard/css/smart_wizard.css">
	<link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/datepicker/css/bootstrap-datetimepicker.min.css"/>
	
	<!-- Revolution Slider Css -->
	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/revolution/revolution/css/layers.css">
	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/revolution/revolution/css/settings.css">
	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/revolution/revolution/css/navigation.css">
	<!-- Revolution Navigation Style -->

	<!--CUSTOMS FONT FACES FROM SETTINGS -->
	{CUSTOM_SETTING_FONT_FACES_AND_CLASSES}
	<!--END CUSTOMS FONT FACES FROM SETTINGS -->

	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/slick/slick-theme.css"/>

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
			--menu-fore-color: {SHOP_MENU_FORE_COLOR};
			--menu-color: {SHOP_MENU_FORE_COLOR};
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
		div.loading{
			background-image:url({SITE_URL}shop-templates/{SHOP_TEMPLATE}/images/loading.svg.php?clr={DEFAULT_LINK_COLOR});
			background-size: 60px,100px;
			min-height:50px;
		}
		span.ribbon {			
			height: 120px;			
			top: 0px;
			right:0px;
			width: 120px;			
			z-index: 20;
			position: absolute;
			background-repeat: no-repeat;
			background-position: right;
		}
		span.ribbon.discount-item {			
			/*background-image: url({SITE_URL}shop-templates/{SHOP_TEMPLATE}/images/rb-disc.png) !important;*/
		}
		span.ribbon.new-item {
			/*background-image: url({SITE_URL}shop-templates/{SHOP_TEMPLATE}/images/rb-new.png) !important;*/
		}

		.scrollable-sub-menu{overflow-y: auto;}		
		.scrollable-sub-menu::-webkit-scrollbar { width: 10px;}		
		.scrollable-sub-menu::-webkit-scrollbar-track { background: #f1f1f1;}
		.scrollable-sub-menu::-webkit-scrollbar-thumb { background: var(--classic-color-0_2); border-radius:4px;}
		.scrollable-sub-menu::-webkit-scrollbar-thumb:hover { background: var(--classic-color-0_6); }
	</style>

	<script type="text/javascript">
		var gaCategories = [];
		var zozoneNailParams = {
			dataLoaded 	: 	[0,0,0,0,0],
			loadStaffsTimerId : 0,
			selectedServices : 0,
			selectedSpecIds : 0,
			selectedPayment : -1,
			smartWizardInit : 0,
			ajaxURL		: '{SITE_URL}php/',
			langCode	: '{CURRENT_LANGUAGE_CODE}',
			langName	: '{CURRENT_LANGUAGE_NAME}',
			lang		: {
				nextBtnText : '',
				prevBtnText : ''
			}
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
						<a href="" class="dez-page"><img src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}" data-src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}"></a>
					</div>
                    <!-- nav toggle button -->
                    <button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span></span>
						<span></span>
						<span></span>
					</button>
					
					<!-- extra nav -->
                    <div class="extra-nav">
                        <div class="extra-cell">
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
						<ul class="nav navbar-nav navbar navbar-nav-scroll "><!--menu-font-options-->
							<li class="active"><a class="dez-page" href="#dzhome">{LANG_HOME}</a></li>
							<li><a class="dez-page" href="#dzaboutme">{LANG_ABOUT_ME}</a></li>
							<li>
								<a class="dez-page" href="#dzservices">{LANG_SERVICES} <i class="fa fa-chevron-down"></i></a>
								<ul class="sub-menu">
									{LOOP: CAT_MENU_2} 
                                	<li><a href="#dzservice-{CAT_MENU_2.id}">{CAT_MENU_2.name}</a></li>  									
                                	{/LOOP: CAT_MENU_2}
								</ul>
							</li>	
							IF("{SHOP_DISPLAY_GROUP_IMAGE}"=="1"){
							<li><a class="dez-page" href="#dzportfolio">{LANG_GALLERY}</a></li>
							{:IF}
							IF("{SHOP_OUR_STAFFS_DISPLAY}" == "1"){
							<li><a class="dez-page" href="#dzstaffs">{LANG_OUR_STAFFS}</a></li>
							{:IF}
							<li><a class="dez-page" href="#dzcontact">{LANG_CONTACT}</a></li>							
							IF("{LOGGED_IN}"=="1"){
							<li><a class="loginout" data-action="logout" href="{SITE_URL}{SLUG}/login?logout=true">{LANG_LOGOUT}</a></li>
							{ELSE}
							<li><a class="loginout" data-action="login" href="{SITE_URL}{SLUG}/login?login=true"><i class="la la-lock" style="font-size:15px;"></i>{LANG_LOGIN}</a></li>
							{:IF}
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
		IF("{SHOP_BANNER_TYPE}" == "slider"){
        <div class="rev-slider" id="dzhome">
			IF("1" == "1"){
			<div id="rev_slider_1164_1_wrapper" class="rev_slider_wrapper fullscreen-container" data-alias="exploration-header" data-source="gallery" style="background-color:transparent;padding:0px;">
				<!-- START REVOLUTION SLIDER 5.4.1 fullscreen mode -->
				<div id="rev_slider_1164_1" class="rev_slider fullscreenbanner" style="display:none;" data-version="5.4.1">
					<ul>	<!-- SLIDE  -->
						<li data-index="rs-3204" data-transition="slideoververtical" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="default"  data-thumb="{SITE_URL}storage/shop/cover/{BANNER_2}"  data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="2000" data-fsslotamount="7" data-saveperformance="off"  data-title="" data-param1="What our team has found in the wild" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
							<!-- MAIN IMAGE -->
							<img id="main-cover-image" class="main-cover-image" src="{SITE_URL}storage/shop/cover/{BANNER_2}"  alt=""  data-lazyload="{SITE_URL}storage/shop/cover/{BANNER_2}" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="6" class="rev-slidebg" data-no-retina>
							<!-- LAYERS -->

							<!-- LAYER NR. 1 -->
							<div class="tp-caption tp-shape tp-shapewrapper" 
								id="slide-101-layer-14" 
								data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" 
								data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']" 
								data-width="full"
								data-height="full"
								data-whitespace="nowrap"
								data-type="shape" 
								data-basealign="slide" 
								data-responsive_offset="off" 
								data-responsive="off"
								data-frames='[{"delay":10,"speed":1000,"frame":"0","from":"opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1500,"frame":"999","to":"opacity:0;","ease":"Power4.easeIn"}]'
								data-textAlign="['inherit','inherit','inherit','inherit']"
								data-paddingtop="[0,0,0,0]"
								data-paddingright="[0,0,0,0]"
								data-paddingbottom="[0,0,0,0]"
								data-paddingleft="[0,0,0,0]"
								style="z-index: 5;font-family:'Alumni Sans'; background-color:rgba(0,0,0,0.15); background-size:100%; background-repeat:no-repeat; background-position:bottom;"></div>
								
							<!-- LAYER NR. 1 -->
							<div class="tp-caption classic-theme-color shop-name-font-options" 
								id="slide-3204-layer-1" 
								data-x="['center','left','middle','middle']" 
								data-hoffset="['-320px','-310px','0','0']" 
								data-y="['middle','middle','top','top']" 
								data-voffset="['-35','-35','200','250']" 
								data-fontsize="['200','150','100','60']"
								data-lineheight="['200','45','35','30']"
								data-width="['1000','1000','600','360']"
								data-height="none"
								data-whitespace="normal"
								data-type="text" 
								data-basealign="slide" 
								data-responsive_offset="off" 
								data-responsive="off"
								data-frames='[{"from":"y:50px;opacity:0;","speed":1500,"to":"o:1;","delay":500,"ease":"Power4.easeOut"},{"delay":"wait","speed":300,"to":"opacity:0;","ease":"nothing"}]'
								data-textAlign="['center','center','center','center']"
								data-paddingtop="[0,0,0,0]"
								data-paddingright="[0,0,0,0]"
								data-paddingbottom="[0,0,0,0]"
								data-paddingleft="[0,0,0,0]"
								style="z-index: 5;  white-space: normal; font-family:'white-monkey', cursive; border-width:0px;">
								{NAME}
							</div>

							<!-- LAYER NR. 2 -->
							<div class="tp-caption subtitle-font-options" 
								id="slide-3204-layer-2" 
								data-x="['center','center','middle','middle']" 
								data-hoffset="['-210px','-200px','0','0']" 
								data-y="['middle','middle','top','top']" 
								data-voffset="['90','70','280','310']" 
								data-width="['700','600','600','260']"
								data-fontsize="['72','60','40','30']"
								data-lineheight="['65','45','35','30']"
								data-height="none"
								data-whitespace="normal"
								data-type="text" 
								data-basealign="slide" 
								data-responsive_offset="off" 
								data-responsive="off"
								data-textAlign="['left','left','center','center']"
								data-frames='[{"from":"y:50px;opacity:0;","speed":1500,"to":"o:1;","delay":650,"ease":"Power4.easeOut"},{"delay":"wait","speed":300,"to":"opacity:0;","ease":"nothing"}]'
								data-paddingtop="[0,0,0,0]"
								data-paddingright="[0,0,0,0]"
								data-paddingbottom="[0,0,0,0]"
								data-paddingleft="[0,0,0,0]"
								style="z-index: 7; white-space: normal; color:{SHOP_MENU_FORE_COLOR}; font-family:'Alumni Sans', serif; border-width:0px; text-transform:uppercase; font-weight:600;">
								{SUB_TITLE}
							</div>
							<!-- LAYER NR. 4 -->
							IF("{BANNER_1}" != ""){
							<div class="tp-caption tp-resizeme rs-parallaxlevel-1" 
								id="slide-100-layer-5" 
								data-x="['right','right','middle','middle']" data-hoffset="['-330','-400','0','0']" 
								data-y="['bottom','bottom','bottom','bottom']" data-voffset="['-40','-40','-20','-20']" 
								data-width="none"
								data-height="none"
								data-whitespace="nowrap"
								data-type="image" 
								data-responsive_offset="on" 
								data-frames='[{"delay":250,"speed":5000,"frame":"0","from":"y:50px;rZ:5deg;opacity:0;fb:50px;","to":"o:1;fb:0;","ease":"Power4.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
								data-textAlign="['inherit','inherit','inherit','inherit']"
								data-paddingtop="[0,0,0,0]"
								data-paddingright="[0,0,0,0]"
								data-paddingbottom="[0,0,0,0]"
								data-paddingleft="[0,0,0,0]"
								style="z-index: 11;">
								<div class="rs-looped rs-wave"  data-speed="5" data-angle="0" data-radius="3px" data-origin="50% 50%">
									<img src="{SITE_URL}storage/shop/cover/{BANNER_1}" alt="" data-ww="['965px','965px','500px','300px']" data-hh="['894px','894px','463px','278px']" width="407" height="200" data-no-retina> 
								</div>
							</div>
							{:IF}
							
							<!--floating name in background-->
							<div class="tp-caption" 
								id="slide-3204-layer-20" 
								data-x="['left','left','left','left']" 
								data-hoffset="['0','0','0','0']" 
								data-y="['bottom','bottom','bottom','bottom']" 
								data-voffset="['30','0','70','40']" 
								data-width="['700','600','600','260']"
								data-fontsize="['300','300','40','30']"
								data-lineheight="['65','45','35','30']"
								data-height="none"
								data-whitespace="nowrap"
								data-type="text" 
								data-basealign="slide" 
								data-responsive_offset="off" 
								data-responsive="off"
								data-textAlign="['left','left','right','center']"
								data-frames='[{"delay":250,"speed":5000,"frame":"0","from":"y:50px;rZ:5deg;opacity:0;fb:50px;","to":"o:0.05;fb:0;","ease":"Power4.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
								data-paddingtop="[0,0,0,0]"
								data-paddingright="[0,0,0,0]"
								data-paddingbottom="[30,0,0,0]"
								data-paddingleft="[0,0,0,0]"
								style="z-index: 7; white-space: normal; color:#000; font-family:'Alumni Sans', serif; border-width:0px; text-transform:uppercase; font-weight:600;">
									<div class="rs-looped rs-wave"  data-speed="5" data-angle="0" data-radius="5px" data-origin="50% 50%">
										{NAME}
									</div>
							</div>
							
							<!-- LAYER NR. 3 -->
							<div class="tp-caption  " 
								id="slide-3204-layer-3" 
								data-x="['center','center','middle','middle']" 
								data-hoffset="['-255','-245','0','0']" 
								data-y="['middle','middle','middle','middle']" 
								data-voffset="['175','120','-140','60']" 
								data-width="['600','500','500','350']"
								data-fontsize="['18','16','18','16']"
								data-lineheight="['26','26','26','24']"
								data-height="none"
								data-whitespace="normal"
								data-type="text" 
								data-basealign="slide" 
								data-responsive_offset="off" 
								data-responsive="off"
								data-frames='[{"from":"y:50px;opacity:0;","speed":2000,"to":"o:1;","delay":750,"ease":"Power4.easeOut"},{"delay":"wait","speed":300,"to":"opacity:0;","ease":"nothing"}]'
								data-textAlign="['left','left','center','center']"
								data-paddingtop="[0,100,0,0]"
								data-paddingright="[0,0,0,0]"
								data-paddingbottom="[0,0,0,0]"
								data-paddingleft="[0,0,0,0]"
								style="z-index: 7; white-space: normal; color:{SHOP_MENU_FORE_COLOR}; font-family:'Alumni Sans', sans-serif; border-width:0px; font-weight:400;">
								{SHOP_DESCRIPTION}
							</div>
							<!--button -->
							<a class="tp-caption dez-page" 
								href="#dzaboutme"
								id="slide-411-layer-13" 
								data-x="['center','center','center','center']" 
								data-hoffset="['-470','-410','-90','-90']" 
								data-y="['center','center','middle','middle']" 
								data-voffset="['270','270','-50','-20']" 
								data-width="none"
								data-height="none"
								data-whitespace="['nowrap','nowrap','nowrap','nowrap']"
								data-type="button" 
								data-actions=''
								data-basealign="slide" 
								data-responsive_offset="off" 
								data-responsive="off"
								data-frames='[{"delay":"+690","speed":2000,"frame":"0","from":"y:50px;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power4.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"},{"frame":"hover","speed":"0","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;fb:0;","style":"c:rgba(0, 0, 0, 1.00);bg:rgba(255, 255, 255, 1.00);"}]'
								data-margintop="[0,0,0,0]"
								data-marginright="[0,0,0,0]"
								data-marginbottom="[0,0,0,0]"
								data-marginleft="[0,0,0,0]"
								data-textAlign="['inherit','inherit','inherit','inherit']"
								data-paddingtop="[0,0,0,0]"
								data-paddingright="[35,35,35,35]"
								data-paddingbottom="[0,0,0,0]"
								data-paddingleft="[35,35,35,35]"
								style="z-index: 13; white-space: normal; font-size: 22px; line-height: 50px; font-weight: 600; color: rgba(255, 255, 255, 1.00); display: inline-block;background-color:rgba(255, 255, 255, 0);border-color:rgba(255, 255, 255, 1.00);border-style:solid;border-width:1px 1px 1px 1px;border-radius:30px;outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;text-decoration: none;">{LANG_READ_MORE}
							</a>
							IF("{SHOP_ORDER_SERVICE}"=="1"){							
							<a class="tp-caption site-button radius-no booking-btn" 
								href="{SITE_URL}{SLUG}/booking" 								
								id="slide-411-layer-12" 
								data-x="['center','center','center','center']" 
								data-hoffset="['-290','-230','90','90']" 
								data-y="['center','center','middle','middle']" 
								data-voffset="['270','270','-50','-20']" 
								data-width="none"
								data-height="none"
								data-whitespace="['nowrap','nowrap','nowrap','nowrap']"
								data-type="button" 
								data-actions=''
								data-basealign="slide" 
								data-responsive_offset="off" 
								data-responsive="off"
								data-frames='[{"delay":"+690","speed":2000,"frame":"0","from":"y:50px;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power4.easeOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"},{"frame":"hover","speed":"0","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;fb:0;","style":"c:rgba(0, 0, 0, 1.00);bg:rgba(255, 255, 255, 1.00);"}]'
								data-margintop="[0,0,0,0]"
								data-marginright="[0,0,0,0]"
								data-marginbottom="[0,0,0,0]"
								data-marginleft="[0,0,0,0]"
								data-textAlign="['inherit','inherit','inherit','inherit']"
								data-paddingtop="[0,0,0,0]"
								data-paddingright="[35,35,35,35]"
								data-paddingbottom="[0,0,0,0]"
								data-paddingleft="[35,35,35,35]"
								style="opacity:0.5 !important;z-index: 13; white-space: normal; font-size: 22px; line-height: 50px; font-weight: 600; color: rgba(255, 255, 255, 1.00); display: inline-block;background-color:rgba(255, 255, 255, 0.5);border-color:rgba(255, 255, 255, 1.00);border-style:solid;border-width:1px 1px 1px 1px;border-radius:30px;outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;text-decoration: none;">{LANG_BOOK_NOW}
							</a>
							{:IF} 
							<!--end button-->
						</li>
					</ul>
					<div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>
				</div><!-- END REVOLUTION SLIDER -->
			</div>
			{:IF}
		</div>
		{ELSE}
		<div id="dzhome">
			<div class="header-video">
				<div id="hero_video">
					<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, .3)" style="background-color: rgba(0, 0, 0, .3);">
						<div class="container">
							<div class="row justify-content-center text-center shop-info">
								<div class="col-xl-8 col-lg-10 col-md-8 mt-2">
									<div class="subtitle-font-options" style="color:{SHOP_MENU_FORE_COLOR} !important;"">{SUB_TITLE} </div>
									<div class="shop-name-font-options classic-theme-color">{NAME}</div>
									<p class="owl-slide-animated owl-slide-subtitle shop-info-desc" style="color:{SHOP_MENU_FORE_COLOR};">{SHOP_DESCRIPTION}</p>
									<p class="shop-botton-wrap">
										<a class="tp-caption dez-page" href="#dzaboutme"
											style="padding:0 15px;min-width:120px;z-index: 13; white-space: normal; font-size: 22px; line-height: 50px; font-weight: 600; color: rgba(255, 255, 255, 1.00); display: inline-block;background-color:rgba(255, 255, 255, 0);border-color:rgba(255, 255, 255, 1.00);border-style:solid;border-width:1px 1px 1px 1px;border-radius:30px;outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;text-decoration: none;">{LANG_READ_MORE}</a>
										IF("{SHOP_ORDER_SERVICE}"=="1"){
										<a class="tp-caption site-button booking-btn" href="{SITE_URL}{SLUG}/booking"
											style="margin-left:15px;min-width:120px;padding:0 15px;z-index: 13; white-space: normal; font-size: 22px; line-height: 50px; font-weight: 600; color: rgba(255, 255, 255, 1.00); display: inline-block;background-color:rgba(255, 255, 255, 0.5);border-color:rgba(255, 255, 255, 1.00);border-style:solid;border-width:1px 1px 1px 1px;border-radius:30px;outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;text-decoration: none;">{LANG_BOOK_NOW}</a>
										{:IF}
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/images/video_fix.png" alt="" class="header-video--media" data-video-src="{SHOP_BANNER_VIDEO_URI}" data-teaser-source="{SHOP_BANNER_VIDEO_URI}" data-provider="" data-video-width="1920" data-video-height="960" style="display: none;">
				<video playsinline="" defaultmuted="" autoplay="true" loop="loop" muted="" id="teaser-video" class="teaser-video">
					<source src="{SHOP_BANNER_VIDEO_URI}" type="{SHOP_BANNER_VIDEO_MIME_TYPE}">
				</video>
			</div>
		</div>
		{:IF}
		<!-- Main Slider -->
		IF("{SHOP_OPEN_STORY}" == "1"){
		<div class="section-full bg-white content-inner-2 spa-about-bx" id="dzaboutme">			
			<div class="container">
				<div class="row d-flex align-items-center">
					<div class="col-lg-6 col-md-6">
						<div class="spa-bx-img wow slideInLeft">
							<img src="{SITE_URL}storage/shop/outstanding_service/{STORY_IMAGE}"/>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 spa-about-content wow slideInRight">
						<h2 class="classic-theme-color story-title-font-options">{SHOP_TITLE_STORY}</h2>
						<h5 class="classic-theme-color story-subtitle-font-options">{SHOP_SUB_TITLE_STORY}</h5>
						<p>{SHOP_STORY}</p>
					</div>
				</div>
			</div>			
		</div>
		{ELSE}
		<div id="dzaboutme" style="height:15px;"></div>
		{:IF}

		IF("{SHOP_SPECIAL_OFFER_DISPLAY}" == "1"){ 
		<div class="section-full bg-white content-inner-2 bridal-about wow fadeInUp" data-wow-delay="0.8s" style="background:url({SITE_URL}storage/shop/background/{SHOP_BACKGROUND_IMAGE}) no-repeat;background-size:cover;">
			<!-- inner page banner -->
			<div class="section-head text-black text-center bridal-head">
				<h5 class="classic-theme-color action-subtitle-font-options">{LANG_WELCOME} {NAME}</h5>
				<h2 class="m-b10 classic-font-and-color action-title-font-options">{LANG_OUR_ACTIONS}</h2>
				<!--<p></p>-->
			</div>
			<!-- inner page banner END -->
		</div>
		{:IF}

		<div id="dzservices" style="margin-top:20px;">
			<!-- new and/or discount items -->
			IF("{SHOP_SPECIAL_OFFER_DISPLAY}" == "1"){ 
			<div class="section-full bridal-price">
					<div class="row no-margin">
						{CAT_MENU_DISCOUNT}
					</div>
			</div>
			{:IF}
			<!-- end new and/or discount items -->

			<!-- begin shop items -->
			<div class="section-full content-inner-3 spa-price-bx">
					{LOOP: CAT_MENU}  
					<div class="category-name-wrap wow {CAT_MENU.wow_class_name}" style="background:{CAT_MENU.background};">
						IF("{CAT_MENU.display_image}" == "1"){ 
							<div id="dzservice-{CAT_MENU.id}"  style="background:url('{SITE_URL}storage/category/{CAT_MENU.image}') no-repeat;background-attachment: fixed;background-size: cover;opacity:.6">
								<div class="section-head text-black text-center">
									<h2 class="m-b10 category-name service-category-font-options">{CAT_MENU.name}</h2>
									<div class="dzcategory-info">{CAT_MENU.description}</div>
								</div>
							</div>
						{ELSE}
						<div id="dzservice-{CAT_MENU.id}" class="container section-head text-black text-center">
							<h2 class="m-b10 category-name service-category-font-options">{CAT_MENU.name}</h2>
							<div>{CAT_MENU.description}</div>
						</div>						
						{:IF}
						{CAT_MENU.menu}
					</div>
					<script> gaCategories.push({id : "{CAT_MENU.id}", name : "{CAT_MENU.name}", catid : "{CAT_MENU.cat_id}"}); </script>
					{/LOOP: CAT_MENU} 
			</div>
			<!-- end shop items -->
		</div>

		<!-- Gallery -->
		IF("{SHOP_DISPLAY_GROUP_IMAGE}"=="1"){
		<div id="dzportfolio" class="section-full content-inner-1 bridal-portfolio">
			<div class="container-fluid wow slideInUp">
				<div class="section-head text-black text-center bridal-head">					
					<h2 class="m-b10 classic-font-and-color heading-font-options">{LANG_GALLERY}</h2>
				</div>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="site-filters style1 clearfix center">
							<ul class="filters" data-toggle="buttons">
								<li data-filter="" class="btn active"><input type="radio"><a href="#"><span>{LANG_ALL}</span></a></li>
								{LOOP: GROUP_IMAGE}
								<li data-filter="{GROUP_IMAGE.id}" class="btn"><input type="radio"><a href="#"><span>{GROUP_IMAGE.name}</span></a></li>
								{/LOOP: GROUP_IMAGE}
							</ul>
						</div>
					</div>
				</div>
				<div class="clearfix">
					<ul id="masonry" class="row sp15 portfolio-box dlab-gallery-listing gallery-grid-4 gallery lightgallery">
						{LOOP: IMAGE_IN_GROUP}
						<li class="{IMAGE_IN_GROUP.group_id} card-container col-lg-3 col-md-6 col-sm-6 m-b15">
							<div class="dlab-box">
								<div class="dlab-media">
									<img src="{SITE_URL}storage/shop/group/{IMAGE_IN_GROUP.image}" alt="">
									<div class="overlay-bx">
										<div class="spa-port-bx">
											<div>
												<span data-exthumbimage="{SITE_URL}storage/shop/group/{IMAGE_IN_GROUP.image}" data-src="{SITE_URL}storage/shop/group/{IMAGE_IN_GROUP.image}" class="check-km" title="">
													<i class="ti-fullscreen"></i> 
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</li>
						{/LOOP: IMAGE_IN_GROUP}						
					</ul>
				</div>
			</div>
		</div>
		{:IF}	
		<!--end gallery -->

		<!--our team--->
		IF("{SHOP_OUR_STAFFS_DISPLAY}" == "1"){ 
		<div id="dzstaffs" class="section-full content-inner-2 spa-price-bx">
			<div class="container wow fadeInUp">
				<div class="text-black text-center bridal-head">
					<h2 class="m-b10 classic-font-and-color heading-font-options">{LANG_OUR_STAFFS}</h2>
					<div class="dlab-separator-outer m-b0">
						<p></p>						
					</div>					
				</div>
				<div class="carousel-service owl-carousel owl-theme owl-dots-primary-full owl-btn-center-lr owl-btn-3 owl-loaded owl-drag">
					{LOOP: OUR_STAFFS}
						<div class="item p-a5">
							<div class="testimonial-9">
								<div class="testimonial-pic radius style1">
									<div style="width:100%;height:100%;display:table;">
										<div style="display:table-cell;vertical-align: middle;height:200px;background:url('./storage/profile/{OUR_STAFFS.image}');background-size:cover;background-position:center center;border-radius:50%;">
											<!--<img src="./storage/profile/{OUR_STAFFS.image}" style="">-->
										</div>
									</div>
								</div>
								<div class="testimonial-detail"> <strong class="testimonial-name">{OUR_STAFFS.name}</strong></div>
							</div>
						</div>
					{/LOOP: OUR_STAFFS}					
				</div>
			</div>
		</div>
		{:IF}
		<!--end our team--->		
	</div>
    <!-- Content END-->

	<!-- Footer -->
    <footer class="site-footer footer-white bridal-footer">
		<div class="footer-top">
            <div class="container" id="dzcontact">
				<div class="section-head text-center bridal-head">
					<h2 class="m-b10 classic-font-and-color heading-font-options">{LANG_CONTACT}</h2>					
				</div>				
				<div class="footer-contact contact-form-bx">
					<div class="dezPlaceAni">
						<div class="dzFormMsg"></div>
						<form class="dzForm" action="{SITE_URL}php/?{SHOP_RANDOM_TOKEN}=">
							<input type="hidden" value="Contact" name="dzToDo">
							<div class="row">
								<div class="col-lg-5 col-md-5 col-sm-12">
									<div class="form-group">
										<div class="input-group">
											<label>{LANG_FULL_NAME}</label>
											<input name="dzName" type="text" required class="form-control" placeholder="">
										</div>
									</div>
									<div class="form-group">
										<div class="input-group"> 
											<label>{LANG_EMAIL}</label>
											<input name="dzEmail" type="email" class="form-control" required  placeholder="" >
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<label>{LANG_PHONE}</label>
											<input name="dzPhone" type="text" required class="form-control" placeholder="">
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<label>{LANG_MESSAGE}...</label>
											<textarea name="dzMessage" rows="4" class="form-control" required placeholder=""></textarea>
										</div>
									</div>
									<div class="send-contact-result" data-success="{LANG_SENT_SUCCESSFULLY}" data-error="{LANG_ERROR_TRY_AGAIN}">{LANG_SENT_SUCCESSFULLY}</div>
									<div class="form-group text-center">
										<button name="submit" type="submit" value="{LANG_SUBMIT}" class="site-button black button-md m-t10 radius-no">{LANG_SUBMIT}</button>
									</div>
									<input type="hidden" name="secret" value="{SHOP_RANDOM_TOKEN}">
									<input type="hidden" name="rcpt" value="{EMAIL}">
									<input type="hidden" name="shop-id" value="{SHOP_ID}">
									<input type="hidden" name="d0" value="s3ndC0nt2ct">
									<input type="hidden" name="md" value="send-contact-msg">
								</div>
								<div class="col-lg-7 col-md-7 col-sm-12">
									<div class="form-group" style="height:25px;"><label></label></div>
									<div class="form-group">
										<div id="map_canvas" data-title="{ADDRESS}" data-lat="{LATITUDE}" data-lng="{LONGITUDE}" data-zoom="{ZOOM}"></div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
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
								
								IF("{SHOP_LINK_TWITTER}" != ""){
								<li style="margin: 10px 0 0 0;"><a href="{SHOP_LINK_TWITTER}"><img src="{SITE_URL}shop-templates/nail/images/twitter.png" data-src="" alt="" class="lazy" style="width: 23px;height: 23px;    margin-right: 7px;">Twitter</a></li>
								{:IF}

								IF("{SHOP_LINK_FACEBOOK}" != ""){
								<li style="margin: 10px 0 0px 0;"><a href="{SHOP_LINK_FACEBOOK}"><img src="{SITE_URL}shop-templates/nail/images/facebook_icon.svg" data-src="" alt="" class="lazy"style="width: 23px;height: 23px;  margin-right: 7px;">Facebook</a></li>
								{:IF}
								IF("{SHOP_LINK_INSTAGRAM}" != ""){
								<li style="margin: 10px 0 0px 0;"><a href="{SHOP_LINK_INSTAGRAM}"><img src="{SITE_URL}shop-templates/nail/images/instagram_icon.svg" data-src="" alt="" class="lazy"style="width: 23px;height: 23px;    margin-right:7px;">Instagram</a></li>
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
					<div class="col-xl-4 col-12 col-lg-3 col-md-6 col-sm-6">
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
                    <div class="col-xl-2 col-12 col-lg-3 col-md-6 col-sm-6">
                        <div class="widget text-right">
                            <a href="{SITE_URL}{SLUG}/booking" class="site-button radius-no" style="font-size:20px;">{LANG_BOOK_NOW}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!--<div class="dlab-divider bg-gray-dark" style="margin-top:0;"><i class="icon-dot c-square"></i></div>-->
		<!-- Our Portfolio -->
		IF("{SHOP_OPEN_FOOTER_IMAGE}"=="1"){
		<div class="portfolio-gallery-wrapper" style="padding:50px 0; background-color:var(--classic-color-0_2);">
			<div class="portfolio-gallery">
				<div class="container-fluid">
					<div class="row">
						<div class="carousel-gallery dots-none owl-none owl-carousel owl-btn-center-lr owl-btn-3 owl-theme owl-btn-center-lr owl-btn-1 mfp-gallery">						
							{LOOP: FOOTER_IMAGE}
								<div class="item dlab-box">
									<a href="{SITE_URL}storage/shop/footer/big_{FOOTER_IMAGE.image}" data-source="{SITE_URL}storage/shop/footer/big_{FOOTER_IMAGE.image}" class="mfp-link dlab-media dlab-img-overlay3" title="{FOOTER_IMAGE.description}">
										<img width="205" height="184" src="{SITE_URL}storage/shop/footer/{FOOTER_IMAGE.image}" alt="{FOOTER_IMAGE.name}"/>
									</a>
								</div>
							{/LOOP: FOOTER_IMAGE}
						</div>
					</div>
				</div>
			</div>
		</div>
		{:IF}
		
		<!--<div class="dlab-divider bg-gray-dark"><i class="icon-dot c-square"></i></div>-->
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

<!-- The service item info modal -->
<div class="modal" id="itemInfoModal">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header" style="background-color:var(--classic-color-1) !important;">
        <h4 class="modal-title"><!--title--></h4>
        <a class="site-buton close" data-dismiss="modal"><i class="ti ti-close"></i></a>
      </div>      
      <div class="modal-body item-info-content"><!-- Modal body --></div>
    </div>
  </div>
</div>

<div id="lang-settings" style="display:none;" data-banner-change-time="{SHOP_OPEN_BANNER_CHANGE_TIME}" data-shop-token="{SHOP_RANDOM_TOKEN}" data-shop={SHOP_ID} data-site-url="{SITE_URL}" data-shop-template="{SHOP_TEMPLATE}" data-gmap-api-key="{GMAP_API_KEY}">	
	<i class="lang-online-booking">{LANG_ONLINE_BOOKING}</i>
	<i class="lang-back-btn">{LANG_PREVIOUS}</i>
	<i class="lang-next-btn">{LANG_NEXT}</i>
	<i class="lang-minutes">{LANG_MINUTE}</i>
	<i class="lang-done">{LANG_DONE}</i>
	<i class="current-lang-code">{CURRENT_LANGUAGE_CODE}</i>
	<i class="lang-error-input-required">{LANG_ERROR_INPUT_REQUIRED}</i>	
</div>
<!---------------------------------->
<!--service booking modal--->
{SHOP_BOOKING_MODAL_TEMPLATE_FILE}
<!-- end service booking modal -->
<!---------------------------------->

<!-- JAVASCRIPT FILES ========================================= -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/jquery.min.js"></script><!-- JQUERY.MIN JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/wow/wow.js"></script><!-- WOW JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/bootstrap/js/popper.min.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/bootstrap/js/bootstrap.min.js"></script><!-- BOOTSTRAP.MIN JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/magnific-popup/magnific-popup.js"></script><!-- MAGNIFIC POPUP JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/counter/waypoints-min.js"></script><!-- WAYPOINTS JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/counter/counterup.min.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/imagesloaded/imagesloaded.js"></script><!-- IMAGESLOADED -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/masonry/masonry-3.1.4.js"></script><!-- MASONRY -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/masonry/masonry.filter.js"></script><!-- MASONRY -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/owl-carousel/owl.carousel.js"></script><!-- OWL SLIDER -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/rangeslider/rangeslider.js" ></script><!-- Rangeslider -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/lightgallery/js/lightgallery-all.js"></script><!-- LIGHT GALLERY -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/custom.js?ver={VERSION}"></script><!-- CUSTOM FUCTIONS  -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/dz.carousel.min.js"></script><!-- SORTCODE FUCTIONS  -->

<!--<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/dz.ajax.js"></script>-->

<!-- revolution JS FILES -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/revolution/revolution/js/jquery.themepunch.tools.min.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/revolution/revolution/js/jquery.themepunch.revolution.min.js"></script>
<!-- Slider revolution 5.0 Extensions  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/revolution/revolution/js/extensions/revolution.extension.actions.min.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/revolution/revolution/js/extensions/revolution.extension.carousel.min.js"></script>

<!--<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/revolution/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>--->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/revolution/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/revolution/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/revolution/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/revolution/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
<!--<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/revolution/revolution/js/extensions/revolution.extension.video.min.js"></script>-->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/rev.slider.js"></script>

<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/datepicker/js/moment.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/datepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/smartwizard/js/jquery.smartWizard.js"></script>

<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/jquery.cookie.min.js?v={VERSION}"></script><!-- SHOP API  -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/shop.api.js?v={VERSION}&t={SHOP_TIME_NOW}"></script><!-- SHOP API  -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/shop.ui.js?v={VERSION}&t={SHOP_TIME_NOW}"></script><!-- SHOP API  -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/booking-v1.ui.js?v={VERSION}&t={SHOP_TIME_NOW}"></script><!-- SHOP API  -->

<script type="text/javascript" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/slick/slick.min.js"></script>
<script type="text/javascript" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/video_header.min.js"></script>

<script>
	try{
		HeaderVideo.init({
			container: $('.header-video'),
			header: $('.header-video--media'),
			videoTrigger: $("#video-trigger"),
			autoPlayVideo: true
		});
		var url = new URL(window.location.href);
		localStorage.setItem('current_url', url.href);
	}catch(e){
		/*console.log(e.message);*/
	}
</script>

<script type="text/javascript">
	var bannerImages = [];	
	var bannerIndex = 1;
	{LOOP: BANNER_IMAGES}
	bannerImages.push('{SITE_URL}storage/shop/cover/{BANNER_IMAGES.image}');
	{/LOOP: BANNER_IMAGES}

	jQuery(document).ready(function(){		
		var timeInterval = $('#lang-settings').data('banner-change-time');
		if(timeInterval<=1) timeInterval = 2;
		else if(timeInterval>10) timeInterval = 10;
		timeInterval *= 1000;		
		setInterval(function(){			
			if(bannerIndex >= bannerImages.length) bannerIndex = 0;
			$('.defaultimg').fadeOut(300, function(){
				$('.defaultimg').css({'background-image' : 'url('+bannerImages[bannerIndex]+')'});
				$('.defaultimg').attr('src', bannerImages[bannerIndex]);
				$('.defaultimg').fadeIn(300);
				++bannerIndex;
			});
		}, timeInterval);
		
		var bShowPopup, nPopupSencods, sPopupMsg;
		try{
			bShowPopup = parseInt('{SHOP_POPUP_MESSAGES_ON_OFF}');
			nPopupSencods = parseInt('{SHOP_SECOND_POPUP}');
			sPopupMsg = '{SHOP_POPUP_MESSAGES}';
			if(isNaN(nPopupSencods) || nPopupSencods<=0 || !sPopupMsg.length) bShowPopup = 0;
		}catch(e){}
		
		if(bShowPopup){
			if(nPopupSencods>10) nPopupSencods = 10;
			nPopupSencods *= 1000;
			$('#itemInfoModal').find('.modal-title').text('{PAGE_TITLE}');
			$('#itemInfoModal').find('.modal-body').html('<div style="margin:0 auto;font-size:20px;text-align:center">'+sPopupMsg+'</div>');
			$('#itemInfoModal').modal();
			
			setTimeout(function(){
				$('#itemInfoModal').modal('hide');
			}, nPopupSencods);
		}

		$.resizeNavbarSubMenuContainer();		
	});/*window.onload()*/

	$(window).resize(function(){
		$.resizeNavbarSubMenuContainer();
	});

	var gSubMenuHeight = $('.sub-menu').height();
	$.resizeNavbarSubMenuContainer = function(){
		var maxheight = $(window).height();
		var thesubmenu = $('.sub-menu');
		if(gSubMenuHeight + thesubmenu.offset().top > maxheight){		
			thesubmenu.addClass('scrollable-sub-menu').css('max-height', maxheight-thesubmenu.offset().top-10);
		}else{			
			thesubmenu.removeClass('scrollable-sub-menu').css('max-height','');
		}
	};
</script>
</body>
</html>
