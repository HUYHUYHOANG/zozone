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
	<link rel="stylesheet" type="text/css" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/vegas/vegas.min.css">
	

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
		div.loading, button.loading{
			background-image:url({SITE_URL}shop-templates/{SHOP_TEMPLATE}/images/loading.svg.php?clr={DEFAULT_LINK_COLOR}) !important;
			background-size: 60px,100px;
			min-height:50px;
		}
		button.loading{
			background-repeat: no-repeat;
			background-position: center center;
			min-height: 38px !important;
		}
		.page-content{padding-bottom: 1px;}
		.start-date,
		.bootstrap-select .dropdown-toggle .filter-option-inner-inner,
		.bootstrap-select .dropdown-menu>li>a{font-size:18px !important;}
		.slick-prev, .slick-next{min-width:40px;}
		
		.dlab-bnr-inr-entry{vertical-align: bottom;padding-bottom: 50px;}
		.overlay-primary:after{background-color: rgba(177, 166, 132, 0.6) !important;opacity:0.6 !important}		
		.header-transparent .main-bar{
			background-color: rgba(40,40,40,.2);
		}
		
		#dzservices{z-index:10;position:absolute;top:150px;width:100%;margin:0 auto;}
		#dzservices.is-fixed{z-index:1110;}
		.smartwizard-wrap{padding:0px 30px 30px;background:#FFF;border-radius:4px;border:1px solid #EEE;box-shadow:0 4px 8px #CCC;}	
		
		form-control:disabled, .form-control[readonly] {			
			color: #666;
		}
		.cartitems-tbl-wrap.hide-remove-buttons .sub-total-row{display: none;}
		.input-group-append .toggle-password{
			background-color: #fff; cursor: pointer;
			color: var(--classic-color-1);font-size:20px;
		}
		.input-group-append .toggle-password:hover{
			background-color: var(--classic-color-1);color:#FFF;
		}

		.service-booking-container{position:relative;}
		.btn-close-booking{
			z-index:100;
			position:absolute;top:2px;right:2px;
			font-size:20px;
			border-radius:50%;
			padding:4px;
			color:var(--classic-color-1);
			background-color:var(--classic-color-0_31);
			cursor:pointer;
		}
		.btn-close-booking:hover{
			background-color:var(--classic-color-1);
			color:#FFF;
		}
		
	</style>

	<script type="text/javascript">
		var gaCategories = [];
		var zozoneNailParams = {
			lang				: {
				prevBtnText	: '{LANG_PREVIOUS}',
				nextBtnText	: '{LANG_NEXT}'
			},
			viewType			: 'grid',
			theSelectedCategory : null,
			cartItems			: [],
			serviceImgPath		: '{SITE_URL}storage/menu/',
			shopHomeURL			: '{SITE_URL}{SLUG}',
			ajaxURL		: '{SITE_URL}php/?{SHOP_BOOKING_TOKEN}',
			apiKey		: '{SHOP_BOOKING_TOKEN}',
			customerLoggedIn : {LOGGED_IN},
			langCode	: '{CURRENT_LANGUAGE_CODE}',
			langName	: '{CURRENT_LANGUAGE_NAME}',
			bookingTemplateStyle 	: '{BOOKING_TEMPLATE_STYLE}',
			paymentPaypal		: {PAYMENT_PAYPAL},
			paymentStripe		: {PAYMENT_STRIPE},
			showStaffsList		: {BOOKING_SHOW_STAFFS_LIST}
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
						<a href="{SITE_URL}{SLUG}" class="dez-page">
							<img src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}" data-src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}">
						</a>
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
						<ul class="nav navbar-nav navbar menu-font-options">	
							<li><a class="dez-page" href="{SITE_URL}{SLUG}">{LANG_HOME}</a></li>
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
							
							IF("{LOGGED_IN}"=="1"){
							<li><a class="loginout" data-action="logout" href="{SITE_URL}{SLUG}/login?logout=true&return=booking">{LANG_LOGOUT}</a></li>
							{ELSE}
							<li><a class="loginout" data-action="login" href="{SITE_URL}{SLUG}/login?login=true&return=booking"><i class="la la-lock" style="font-size:15px;"></i>{LANG_LOGIN}</a></li>
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
        <div id="dzhome" class="dlab-bnr-inr" style="opacity:.6;">
			<!--<div class="dlab-bnr-inr">
				<div class="container">
					<div class="dlab-bnr-inr-entry">
						<h1 class="text-white text-secondary">{LANG_ONLINE_BOOKING}</h1>						
					</div>
				</div>
			</div>-->
		</div>
		<!--services container-->
		<div id="dzservices">
			<div class="container service-booking-container">
				<a href="{SITE_URL}{SLUG}"><i class="la la-close btn-close-booking"></i></a>
				<div class="row">
					<div class="col-lg-12 smartwizard-wrap">
						<!--smartwizard-->
						<div id="smartwizard" style="padding:0;margin:0;">
							<ul class="d-flex" style="display:none !important;">
							IF("{BOOKING_TEMPLATE_STYLE}"=="1"){
								<!--SELECT EMPLOYEE AND TIME FIRST-->
								<li class="flex-fill"><a href="#time"><span><strong>1</strong><i class="fa fa-check"></i></span> {LANG_SERVICES}</a></li>
								<li class="flex-fill"><a href="#service"><span><strong>2</strong><i class="fa fa-check"></i></span> {LANG_TIME}</a></li>
							{ELSE}
								<!--SELECT SERVICES FIRST-->
								<li class="flex-fill"><a href="#service"><span><strong>1</strong><i class="fa fa-check"></i></span> {LANG_TIME}</a></li>
								<li class="flex-fill"><a href="#time"><span><strong>2</strong><i class="fa fa-check"></i></span> {LANG_SERVICES}</a></li>								
							{:IF}
								<li class="flex-fill"><a href="#details"><span><strong>3</strong><i class="fa fa-check"></i></span> {LANG_DETAILS}</a></li>
								<li class="flex-fill"><a href="#done"><span><strong>4</strong><i class="fa fa-check"></i></span> {LANG_DONE}</a></li>
							</ul>
							<div>
								IF("{BOOKING_TEMPLATE_STYLE}"=="1"){
								<div id="time" class="wizard-box">
									<h6 class="m-b30">{LANG_PLZ_SELECT_BOOKING_TIME}</h6>
									<form class="row">						
										<div class="col-lg-6 col-md-6 col-sm-6">
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="fa fa-calendar"></i></span>
												</div>
												<input name="dzOther[date]" class="form-control" id="start-date" type="text" onkeydown="return false" onpaste="return false">								
											</div>							
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6">
											<select id="staff-list" class="selectpicker">
												<option value="0">{LANG_ANY_EMPLOYER}</option>
												IF("{BOOKING_SHOW_STAFFS_LIST}"=="1"){
													{LOOP: STAFFS_LIST}
													<option value={STAFFS_LIST.id}>{STAFFS_LIST.name}</option>
													{/LOOP: STAFFS_LIST}
												{:IF}
											</select>
										</div>			
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div id="staffs-list-slider" class="slider single-item">
												
											</div>
										</div>
										<input type="hidden" id="selected-time-slot">
									</form>
								</div>
								<div id="service">
									<h6 class="m-b30">{LANG_PLZ_SELECT_SERVICE}</h6>
									<form class="row">
										<div class="col-lg-7 service-group-wrap">
											<div class="row services-wrap">
												{LOOP: CATEGORY}
													<div class="col-6 col-sm-6 group-item">
														<a class="btn clickable text-center the-cat-name" href="#" data-catid="{CATEGORY.id}" data-image="{CATEGORY.image}">
															{CATEGORY.name}
														</a>
														<script type="text/javascript">
														gaCategories.push({
															image : '{CATEGORY.image}',
															id : '{CATEGORY.id}',															
															name : '{CATEGORY.name}', 
															count : '{CATEGORY.count}',
															service_items : '{CATEGORY.service_items}'
														});
													</script>
													</div>													
												{/LOOP: CATEGORY}												
											</div>
											<div class="row services-wrap the-selected-category-wrap">
												<div class="col-sm-12 box-header" style="position:relative;">
													<a class="btn active no-click the-selected-category-name" data-imgpath="{SITE_URL}storage/menu/">
														<span class="the-cat-img-wrap" style="float:left;width:70px;height:40px;display:block;"><img src="" style="max-width:70px;max-height:40px;border-radius:4px;"/></span>
														<span class="the-cat-name"></span>
													</a>
													<i class="fa fa-th-large thumb-view active"></i>
													<i class="fa fa-list list-view"></i>
													<div class="row selected-category-service-items"></div>									
												</div>
											</div>
										</div><!--end left side-->
										<div class="col-lg-5 card-content-wrap">
											<div class="row">
												<div class="col-sm-12 box-header"><a class="btn no-click active font-weight-bold"><i class="fa fa-shopping-cart"></i>{LANG_YOUR_BOOKING_SERVICE}</a></div>
												<div class="col-sm-12 card-item">
													<table class="table table-responsive cartitems-tbl-wrap">
													</table>
													<p class="btn text-danger text-center empty-list-msg"><span class="fa fa-ban"></span></p>
												</div>
											</div>
										</div><!--end right side-->
									</form>
								</div>
								{ELSE}
								<div id="service">
									<h6 class="m-b30">{LANG_PLZ_SELECT_SERVICE}</h6>
									<form class="row">
										<div class="col-lg-7 service-group-wrap">
											<div class="row services-wrap">
												{LOOP: CATEGORY_2}
													<div class="col-6 col-sm-6 group-item">
														<a class="btn clickable text-center the-cat-name" href="#" data-catid="{CATEGORY_2.id}" data-image="{CATEGORY_2.image}">
															{CATEGORY_2.name}
														</a>
														<script type="text/javascript">
														gaCategories.push({
															image : '{CATEGORY_2.image}',
															id : '{CATEGORY_2.id}',															
															name : '{CATEGORY_2.name}', 
															count : '{CATEGORY_2.count}',
															service_items : '{CATEGORY_2.service_items}'
														});
													</script>
													</div>													
												{/LOOP: CATEGORY_2}
											</div>
											<div class="row services-wrap the-selected-category-wrap">
												<div class="col-sm-12 box-header" style="position:relative;">
													<a class="btn active no-click the-selected-category-name" data-imgpath="{SITE_URL}storage/menu/">
														<span class="the-cat-img-wrap" style="float:left;width:70px;height:40px;display:block;"><img src="" style="max-width:70px;max-height:40px;border-radius:4px;"/></span>
														<span class="the-cat-name"></span>
													</a>
													<i class="fa fa-th-large thumb-view active"></i>
													<i class="fa fa-list list-view"></i>
													<div class="row selected-category-service-items"></div>									
												</div>
											</div>
										</div><!--end left side-->
										<div class="col-lg-5 card-content-wrap">
											<div class="row">
												<div class="col-sm-12 box-header"><a class="btn no-click active font-weight-bold"><i class="fa fa-shopping-cart"></i>{LANG_YOUR_BOOKING_SERVICE}</a></div>
												<div class="col-sm-12 card-item">
													<table class="table table-responsive cartitems-tbl-wrap">
													</table>
													<p class="btn text-danger text-center empty-list-msg"><span class="fa fa-ban"></span></p>
												</div>
											</div>
										</div><!--end right side-->
									</form>
								</div>
								<div id="time" class="wizard-box">
									<h6 class="m-b30">{LANG_PLZ_SELECT_BOOKING_TIME}</h6>
									<form class="row">						
										<div class="col-lg-6 col-md-6 col-sm-6">
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="fa fa-calendar"></i></span>
												</div>
												<input name="dzOther[date]" class="form-control" id="start-date" type="text" onkeydown="return false" onpaste="return false">								
											</div>							
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6">
											<select id="staff-list" class="selectpicker">
												<option value="0">{LANG_ANY_EMPLOYER}</option>
												IF("{BOOKING_SHOW_STAFFS_LIST}"=="1"){
													{LOOP: STAFFS_LIST_2}
													<option value={STAFFS_LIST_2.id}>{STAFFS_LIST_2.name}</option>
													{/LOOP: STAFFS_LIST_2}
												{:IF}
											</select>
										</div>			
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div id="staffs-list-slider" class="slider single-item">
												
											</div>
										</div>
										<input type="hidden" id="selected-time-slot">
									</form>
								</div>
								{:IF}
								<div id="details" class="">
									<h6 class="m-b30">{LANG_CONFIRM} {LANG_BOOKING}</h6>
									<form class="row confirm-wrap" id="frmConfirm">
										<div class="col-lg-4 col-md-12 ">
											<a class="btn active no-click font-weight-bold" style="margin-bottom:6px;"><i class="fa fa-shopping-cart"></i>{LANG_YOUR_BOOKING_SERVICE}</a>											
											<div class="col-sm-12 card-item">
												<!--cart items contaner-->
												<table class="table table-responsive cartitems-tbl-wrap hide-remove-buttons">
												</table>												
												<!--apply voucher-->
												<table class="table table-responsive">
													<tr>
														<td class="col-md-6" style="padding-right:4px !important;">
															<div class="input-group">
																<div class="input-group-prepend">
																	<span class="input-group-text"><i class="fa fa-tag" style="font-size:18px;"></i></span>
																</div>
																<input type="text" id="voucher-code" name="vcc" class="form-control" placeholder="{LANG_VOUCHER}" maxlength="8">
															</div>
															<div class="text-danger apply-voucher-result" style="display:none;"></div>
														</td>
														<td class="col-md-4" style="padding-left:0 !important;"><button id="apply-voucher" class="site-button apply-voucher" data-action="apply" data-apply-text="{LANG_APPLY}" data-clear-text="{LANG_CLEAR}">{LANG_APPLY}</button></td>
														<td class="col-md-1"></td>
														<td class="col-md-3 voucher-amt" style="white-space:nowrap;vertical-align:middle;"><span class="item-price">0.00 &euro;</span></td>
													</tr>
													<tr><td colspan="4" class="total-amt item-price text-right">Total</td></tr>
												</table>
											</div>											
										</div>										
										<div class="col-lg-5 col-md-12">
											IF("{LOGGED_IN}" != "1"){
											<div class="col-sm-12 login-form-wrap">											
												<a href="#" class="btn font-weight-bold login-header" data-ref-class="login-form-wrap" data-login-type="login"><i class="fa fa-check-circle active"></i>{LANG_LOGIN}</a>
												<div class="login-return-msg text-danger" style="display:none;padding-top:6px;" data-inv-email="{LANG_EMAILINV}" data-inv-pwd="{LANG_PLEASE_ENTER_A_PASSWORD_WITH_A_LENGTH_OF_8_20_CHARACTERS}"></div>
												<div class="form-content sign-in">
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text"><i class="fa fa-envelope"></i></span>
														</div>
														<input type="text" id="login-email" class="form-control" placeholder="{LANG_EMAIL}" aria-label="Username">
													</div>
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text"><i class="fa fa-key"></i></span>
														</div>
														<input type="password" id="login-pwd" class="form-control" placeholder="{LANG_PASSWORD}" aria-label="Password">
														<div class="input-group-append">
															<span class="input-group-text toggle-password"><i class="la la-eye-slash"></i></span>
														</div>
													</div>
													<div class="input-group">														
														<a href="#" class="forgot-password" data-toggle="modal" data-target="#forgotpwddlg">{LANG_FORGOT_PASSWORD}</a>
													</div>
												</div>
											</div>											
											<!--address form-->
											<div class="col-sm-12 register-form-wrap">
												<a href="#" class="btn font-weight-bold login-header" data-ref-class="register-form-wrap"  data-login-type="signup">
													<i class="fa fa-circle"></i> {LANG_DONT_HAVE_ACCOUNT}
												</a>
												<div class="signup-return-msg text-danger" style="display:none;padding-top:6px;" data-inv-email="{LANG_EMAILINV}" data-pwd-notmatch="{LANG_PASSNOMATCH}" data-inv-pwd="{LANG_PLEASE_ENTER_A_PASSWORD_WITH_A_LENGTH_OF_8_20_CHARACTERS}" data-default="{LANG_YOUR_NAME_REQUIRED}">{LANG_YOUR_NAME_REQUIRED}</div>
												<div class="form-content sign-up">
													<div class="input-group">
														<input type="text" id="fname" name="fname" class="form-control" placeholder="{LANG_FIRST_NAME}" aria-label="First Name">
													</div>
													<div class="input-group">									
														<input type="text" id="surname" name="surname" class="form-control" placeholder="{LANG_LAST_NAME}" aria-label="Surname">
													</div>
													<div class="input-group">									
														<input type="text" id="signup-email" class="form-control" placeholder="{LANG_EMAIL}" aria-label="Email">
													</div>
													<div class="input-group">									
														<input type="text" id="phone" name="phone" class="form-control" placeholder="{LANG_PHONE}" aria-label="Phone">
													</div>
												</div>
											</div>
											<!--register account option-->
											<div class="col-sm-12 register-form-wrap">
												<a href="#" class="btn text-left  font-weight-bold login-header register-account">													
													{LANG_SIGNUP_NOW}<span class="fa fa-arrow-circle-up"></span>
												</a>
												<div class="form-content sign-up" style="display:none">
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text"><i class="fa fa-key"></i></span>
														</div>
														<input type="password" class="form-control" placeholder="{LANG_PASSWORD}" id="signup-pwd" aria-label="Password">
														<div class="input-group-append">
															<span class="input-group-text toggle-password"><i class="la la-eye-slash"></i></span>
														</div>
													</div>
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text"><i class="fa fa-key"></i></span>
														</div>
														<input type="password" class="form-control" placeholder="{LANG_CONFIRM_PASSWORD}" id="signup-pwd2" aria-label="Password">
														<div class="input-group-append">
															<span class="input-group-text toggle-password"><i class="la la-eye-slash"></i></span>
														</div>
													</div>
													<div class="input-group">
														<label class="control-label newsletter-option" data-value="0"><i class="fa fa-square-o"></i> {LANG_NEWSLETTER}</label>
													</div>
												</div>
											</div>
											<input type="hidden" name="login-type" value="login">
											<input type="hidden" name="newsletter-option" value="0">
											<input type="hidden" name="md" value="customer-service">
											<input type="hidden" name="d0" value="complete-customer-booking">
											<input type="hidden" name="secret" value="{SHOP_BOOKING_TOKEN}">
											<input type="hidden" id="payment-type" name="payment-type" value="local">
											<input type="hidden" name="p" value="">
											<input type="hidden" name="e" value="">
											<input type="hidden" name="date" value="">
											<input type="hidden" name="time" value="">
											<input type="hidden" name="staff-id" value="">
											{ELSE}
											<!--logged in, show the info form but disable email address -->
											<div class="col-sm-12 customer-info-form no-margin">
												<a href="#" class="btn font-weight-bold login-header">{LANG_INFORMATION}</a>
												<div class="form-content sign-up">
													<div class="input-group">
														<input type="text" id="fname" readonly class="form-control" value="{CUSTOMER_FNAME}" placeholder="{LANG_FIRST_NAME}" aria-label="First Name">
													</div>
													<div class="input-group">									
														<input type="text" id="surname" readonly class="form-control" value="{CUSTOMER_LNAME}" placeholder="{LANG_LAST_NAME}" aria-label="Surname">
													</div>
													<div class="input-group">									
														<input type="text" id="email" class="form-control" readonly value="{CUSTOMER_EMAIL}" placeholder="{LANG_EMAIL}" aria-label="Email" onkeydown="return false;" onpaste="return false;">
													</div>
													<div class="input-group">									
														<input type="text" id="phone" readonly class="form-control" value="{CUSTOMER_PHONE}" placeholder="{LANG_PHONE}" aria-label="Phone">
													</div>
												</div>
											</div>
											<input type="hidden" name="md" value="customer-service">
											<input type="hidden" name="d0" value="complete-customer-booking">
											<input type="hidden" name="secret" value="{SHOP_BOOKING_TOKEN}">
											<input type="hidden" id="payment-type" name="payment-type" value="local">											
											<input type="hidden" name="date" value="">
											<input type="hidden" name="time" value="">
											<input type="hidden" name="staff-id" value="">
											{:IF}
										</div>										
										<div class="col-lg-3 col-md-12 payment-item-wrap">
											<a class="btn active no-click font-weight-bold"><i class="fa fa-paypal"></i>{LANG_PAYMENT}</a>
											<div class="thin-sep"></div>
											<div class="payment-method-item"><a class="btn active" data-value="local"><i class="fa fa-check-circle"></i> {LANG_PAYMENT_LOCALLY}</a></div>
											IF("{PAYMENT_PAYPAL}"=="1"){
											<div class="payment-method-item"><a href="#" class="btn" data-value="paypal"><i class="fa fa-circle"></i> {LANG_PAYMENT_WITH_PAYPAL}</a></div>
											{:IF}
											IF("{PAYMENT_STRIPE}"=="1"){
											<div class="payment-method-item"><a href="#" class="btn" data-value="stripe"><i class="fa fa-circle"></i> Stripe</a></div>
											{:IF}
											<h3 class="booking-return-msg text-danger font-weight-bold" style="display:block;padding-top:12px;" data-error="{LANG_ERROR}" data-success="{LANG_SUCCESS}"></h3>
										</div>
										<input type="hidden" id="lang-text-msg" value="{LANG_TOTAL_AMOUNT}">
									</form>
								</div>	
								<div id="done" class="">
									<div class="successful-box text-center">
										<div class="successful-check"><i class="ti-check"></i></div>
										<h2>
											<span class="successfull">{LANG_SUCCESSFUL}</span>
											<span class="error" style="display:none;">{LANG_RESERVATION_ERROR_MSG}</span>
										</h2>
									</div>
								</div>
							</div>
						</div>
						<!--end smartwizard-->
					</div>
				</div>
			</div>
		</div><!--end services container-->
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
		<!-- Our Portfolio -->
		IF("{SHOP_OPEN_FOOTER_IMAGE}"=="1"){
		<div class="portfolio-gallery-wrapper" style="padding:50px 0;background-color:var(--classic-color-0_2);">
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
		<div class="container dzbottom-line">
			<div class="row">
				<div class="col-lg-6 col-sm-6 col-xs-6 bottom-line-text"><a href="">{COPYRIGHT_TEXT}</a></div>
				<div class="col-lg-6 col-sm-6 col-xs-6 bottom-line-text text-right">
					<a class="right-ft-link" href="{SITE_URL}{SLUG}/privacy#agb">AGB</a>
					<a class="right-ft-link" href="{SITE_URL}{SLUG}/privacy#datenschutzerklarung">Datenschutzerklärung</a>
					<a class="right-ft-link" href="{SITE_URL}{SLUG}/privacy#impressum">Impressum</a>
				</div>
			</div>
		</div>
    </footer>	
    <!-- Footer END-->
    <button class="scroltop fa fa-chevron-up" ></button>
</div>

<!-- The service item info modal -->
<div class="modal" id="forgotpwddlg">
  <div class="modal-dialog modal-fade modal-md modal-dialog-centered">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header" style="background-color:var(--classic-color-1) !important;">
        <h6 class="modal-title">{LANG_FORGOT_PASSWORD}</h6>
        <a class="site-buton close" data-dismiss="modal"><i class="ti ti-close"></i></a>
      </div>      
      <div class="modal-body item-info-content">
	  	<form method="post">
		  	<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text"><i class="fa fa-envelope"></i></span>
				</div>
				<input type="email" class="form-control" id="email-getpwd" placeholder="{LANG_EMAIL}"/>
			</div>
			<div class="thin-sep" style="height:5px;"></div>
			<div class="text-danger getpwd-msg" style="display:none;" data-text="{LANG_PLEASE_ENTER_THE_CORRECT_EMAILL}">{LANG_PLEASE_ENTER_THE_CORRECT_EMAILL}</div>
			<div class="thin-sep" style="height:15px;"></div>
			<button class="btn site-button form-control" id="btn-getpwd" type="submit" data-text="{LANG_REQ_PASS}">{LANG_REQ_PASS}</button>
		</form>
	  </div>
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

<!-- JAVASCRIPT FILES ========================================= -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/jquery.min.js"></script><!-- JQUERY.MIN JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/wow/wow.js"></script><!-- WOW JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/bootstrap/js/popper.min.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/bootstrap/js/bootstrap.min.js"></script><!-- BOOTSTRAP.MIN JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/magnific-popup/magnific-popup.js"></script><!-- MAGNIFIC POPUP JS -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/imagesloaded/imagesloaded.js"></script><!-- IMAGESLOADED -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/owl-carousel/owl.carousel.js"></script><!-- OWL SLIDER -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/custom.js?ver={VERSION}"></script><!-- CUSTOM FUCTIONS  -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/dz.carousel.min.js"></script><!-- SORTCODE FUCTIONS  -->

<!--<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/dz.ajax.js"></script>-->

<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/datepicker/js/moment.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/datepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/smartwizard/js/jquery.smartWizard.js"></script>

<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/jquery.cookie.min.js?v={VERSION}"></script><!-- SHOP API  -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/shop.api.js?v={VERSION}"></script><!-- SHOP API  -->
<script type="text/javascript" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/customer.js.php?v={VERSION}&t={SHOP_TIME_NOW}"></script>
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/shop.ui.js?v={VERSION}&t={SHOP_TIME_NOW}"></script><!-- SHOP API  -->
<script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/booking-v2.ui.js?v={VERSION}&t={SHOP_TIME_NOW}"></script><!-- SHOP API  -->

<script type="text/javascript" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/slick/slick.min.js"></script>
<script type="text/javascript" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/plugins/vegas/vegas.min.js"></script>

<script type="text/javascript">
	var aBannerImages = [];	
	var bannerIndex = 1;
	var $theBannerImage = null;
	{LOOP: BANNER_IMAGES}
	aBannerImages.push({'src' : '{SITE_URL}storage/shop/cover/{BANNER_IMAGES.image}'});
	{/LOOP: BANNER_IMAGES}	

	jQuery(document).ready(function(){
		var bdheight = $('body').height() + 118;		
		if(aBannerImages.length){
			aBannerImages = shuffle(aBannerImages);
			$('#dzhome').height(bdheight).vegas({
				slides: aBannerImages,
				transition: 'fade'
			});
			
		}

		$('.extra-nav').css('height',$('.header').height());
	});	

	let preTop = 0, fixedTop = $('.header').height();
	let scrollDirection = '';

	$(window).resize(function(){		
		setTimeout(function(){
			$('.extra-nav').css('height',$('.logo-header').height());
		}, 60);
	}).scroll(function(){
		let themodal = $('#dzservices');
		let scrollTop = $(window).scrollTop() + $('.header').height();
		if(preTop < scrollTop){
			scrollDirection = 'down';
			preTop = scrollTop;
		}else{
			scrollDirection = 'up';
			preTop = scrollTop;
		}

		if(scrollDirection=='down'){
			if(themodal.position().top <= scrollTop){
				if(!themodal.hasClass('is-fixed')){
					themodal.data('top', themodal.position().top);
					themodal.addClass('is-fixed');
					fixedTop = $(window).scrollTop() + $('.header').height();
				}
			}
		}else{		
			if(scrollTop<=fixedTop){
				themodal.removeClass('is-fixed');
			} 
		}
	});

	function shuffle(array) {
		let currentIndex = array.length,  randomIndex;
		while (currentIndex != 0) {			
			randomIndex = Math.floor(Math.random() * currentIndex);
			currentIndex--;
			[array[currentIndex], array[randomIndex]] = [
			array[randomIndex], array[currentIndex]];
		}
		return array;
	}
</script>
</body>
</html>
