<!doctype html>
<html lang="{LANG_CODE}" dir="{LANGUAGE_DIRECTION}" data-menu="classicmenu">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>IF("{PAGE_TITLE}"!=""){ {PAGE_TITLE} - {:IF}{SITE_TITLE}</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{SITE_URL}storage/logo/{SITE_FAVICON}/assets/images/favicon.webp">
    <link rel="shortcut icon" href="{SITE_URL}storage/logo/{SITE_FAVICON}" />
    <!-- CSS ============================================ -->

    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/css/plugins/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/css/plugins/icofont.min.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/css/plugins/bootstrap.min.css">
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/css/plugins/animate.min.css">
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/css/plugins/swiper-bundle.min.css">
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/css/plugins/nouislider.css">
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/css/plugins/star-rating.css">
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/css/plugins/nice-select2.css">
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/css/plugins/glightbox.min.css">
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/css/plugins/aos.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/css/style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Alumni+Sans');
		@import url('https://fonts.googleapis.com/css?family=Dancing+Script');	
        :root{  
			{LOOP: CLASSIC_COLOR}--classic-color-{CLASSIC_COLOR.id}: {CLASSIC_COLOR.value};{/LOOP: CLASSIC_COLOR} 
			--menu-fore-color: {SHOP_MENU_FORE_COLOR};
			--menu-color: {SHOP_MENU_FORE_COLOR};
		}
    </style>

</head>

<body>

    <div class="main-wrapper">

        <!-- Header Start -->
        <div id="header" class="section header-area">
            <div class="container">

                <!-- Header Wrapper Start -->
                <div class="header-wrapper">

                    <!-- Header Logo Start -->
                    <div class="header-logo">
                        <a href="#"><img src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}" width="172" height="45"alt="Logo"></a>
                    </div>
                    <!-- Header Logo End -->

                    <!-- Header Navbar Start -->
                    <div class="header-navbar d-none d-lg-block">
                        <ul class="navbar-menu">
                            <li><a href="#">{LANG_HOME}</a></li>
                            <li><a class="dez-page" href="#about.id">{LANG_ABOUT_ME}</a></li>
                            <li>
                                <a class="dez-page" href="#dzservices.id">{LANG_SERVICES} </a>
                                <ul class="sub-menu">
                                    {LOOP: CATEGORY}
                                    <li><a href="#category_{CATEGORY.id}">{CATEGORY.name}</a></li>
                                    {/LOOP: CATEGORY}
                                </ul>
                            </li>
                            IF("{SHOP_DISPLAY_GROUP_IMAGE}"=="1"){
                            <li><a class="dez-page" href="#gallery">{LANG_GALLERY}</a></li>
                            {:IF}
                            IF("{SHOP_OUR_STAFFS_DISPLAY}" == "1"){
                            <li><a  href="#staff">{LANG_OUR_STAFFS}</a></li>
                            {:IF}
                            <li><a class="dez-page" href="#contact.id">{LANG_CONTACT}</a></li>
                            IF("{LOGGED_IN}"=="1"){
                            <li><a class="loginout" data-action="logout"
                                    href="{SITE_URL}{SLUG}/login?logout=true">{LANG_LOGOUT}</a></li>
                            {ELSE}
                            <li><a class="loginout" data-action="login" href="{SITE_URL}{SLUG}/login?login=true"><i class="fa-sharp fa-solid fa-lock" style="font-size:12px;"></i> {LANG_LOGIN}</a></li>
                            {:IF}
                        </ul>

                    </div>
                    <!-- Header Navbar End -->

                   

                    <!-- demo -->
                    <!-- extra nav -->
                    <div id="nav_wrapper">
                        <div class="nav_wrapper_inner">
                            <div id="menu_border_wrapper">
                                <div class="menu-one-page-menu-container">
                                    <ul id="main_menu" class="nav">
                                        <li style="color: #fff;" class="menu-item current-menu-item menu-item-has-children arrow "><a
                                                class="menu_list selected-lang" href="javascript:void(0)"><i
                                                    class="icon-flag-German icon-flag-country"></i>German</a>
                                            <ul class="sub-menu">
                                                {LOOP: LANGS}
                                                <li class="menu-item menu-lang" style="border-bottom: dotted 1px white;color: white;"
                                                    data-lang="{LANGS.file_name}" data-code="{LANGS.code}">
                                                    <a href="#" class="flag-{LANGS.name}"><i
                                                            class="icon-flag-{LANGS.name} icon-flag-country"></i>{LANGS.name}</a>
                                                </li>
                                                {/LOOP: LANGS}
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                   

                    <!-- Hewader Toggle Start -->
                    <div class="header-toggle d-lg-none">
                        <button class="toggle" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                    <!-- Hewader Toggle End -->
                </div>
                <!-- Hewader Meta End -->

            </div>
            <!-- Header Wrapper End -->

        </div>
    </div>
    <!-- Header End -->


    <!-- Offcanvas Start -->
    <div class="offcanvas offcanvas-start" id="offcanvasNavbar">

        <div class="offcanvas-header">
            <!-- Logo Start -->
            <div class="header-logo">
                <a href="#"><img src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}" width="172" height="45"alt="Logo"></a>
            </div>
            <!-- Logo End -->
            <button type="button" class="close" data-bs-dismiss="offcanvas">
                <span></span>
                <span></span>
            </button>
        </div>

        <div class="offcanvas-body">
            <div class="mobile-menu offcanvas-menu">
                <ul class="navbar-menu">
                    <li><a href="#">{LANG_HOME}</a></li>
                    <li><a class="dez-page" href="#about.id">{LANG_ABOUT_ME}</a></li>
                    <li>
                        <a class="dez-page" href="#dzservices.id">{LANG_SERVICES}</a>
                        <ul class="sub-menu">
                            {LOOP: CATEGORY_2} 
                                <li><a href="#category_{CATEGORY_2.id}">{CATEGORY_2.name}</a></li>  									
                            {/LOOP: CATEGORY_2}
                        </ul>
                    </li>
                    IF("{SHOP_DISPLAY_GROUP_IMAGE}"=="1"){
                        <li><a class="dez-page" href="#gallery">{LANG_GALLERY}</a></li>
                        {:IF}
                        IF("{SHOP_OUR_STAFFS_DISPLAY}" == "1"){
                        <li><a  href="#staff">{LANG_OUR_STAFFS}</a></li>
                        {:IF}
                        <li><a class="dez-page" href="#contact.id">{LANG_CONTACT}</a></li>
                        IF("{LOGGED_IN}"=="1"){
                        <li><a class="loginout" data-action="logout"
                                href="{SITE_URL}{SLUG}/login?logout=true">{LANG_LOGOUT}</a></li>
                        {ELSE}
                        <li><a class="loginout" data-action="login" href="{SITE_URL}{SLUG}/login?login=true"><i class="fa-sharp fa-solid fa-lock" style="font-size:12px;"></i> {LANG_LOGIN}</a></li>
                        {:IF}
                </ul>
            </div>
        </div>
    </div>
    <!-- Offcanvas End -->


    <!-- Slider Start -->
    <div class="section slider-area slider-active">
        <div class="swiper-container">
            <div class="swiper-wrapper">

                <!-- Single Slider Start -->
                <div class="swiper-slide animation-style-01 single-slider d-flex align-items-center"
                    style="background-image: url({SITE_URL}storage/shop/cover/{BANNER_2});">
                    <div class="container">
                        <div class="slider-content">
                            <h1 class="title">{NAME}</h1>
                            <ul class="slider-meta">
                                <li><a href="#dzservices.id" class="btn btn-primary btn-hover-white">{LANG_READ_MORE}</a></li>
                                <li><a href="https://demo.zozone.de/nail/booking/?do=add-item&amp;item=134" class="btn btn-primary btn-hover-white">{LANG_BOOK_NOW}</a></li>
                            </ul>
                            <ul class="slider-social">
                                <li><a href="{SHOP_LINK_FACEBOOK}"><i class="fa-brands fa-facebook"></i></a></li>
                                <li><a href="{SHOP_LINK_TWITTER}"><i class="fa-brands fa-twitter"></i></a></li>
                                <li><a href="{SHOP_LINK_INSTAGRAM}"><i class="fa-brands fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- <img src="https://demo.zozone.de/storage/shop/cover/16613143506305a52e91497.png" alt="" data-ww="['965px','965px','500px','300px']" data-hh="['894px','894px','463px','278px']" width="407" height="200" data-no-retina="" style="bottom: 0; position: absolute; width: auto; right: 0; height: 500px; transition: none 0s ease 0s; text-align: inherit; line-height: 0px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 3px;"> -->
                </div>
                <!-- Single Slider End -->

                <!-- Single Slider Start -->
                <div class="swiper-slide animation-style-01 single-slider d-flex align-items-center"
                    style="position: relative;background-image: url({SITE_URL}storage/shop/cover/{BANNER_1});">
                    <div class="container">
                        <div class="slider-content content-white">
                            <h1 class="title">{NAME}</h1>
                            <ul class="slider-meta">
                                <li><a href="#dzservices.id" class="btn btn-primary btn-hover-white">{LANG_READ_MORE}</a></li>
                                <li><a href="https://demo.zozone.de/nail/booking/?do=add-item&amp;item=134" class="btn btn-primary btn-hover-white">{LANG_BOOK_NOW}</a></li>
                            </ul>
                            <ul class="slider-social">
                                <li><a href="{SHOP_LINK_FACEBOOK}"><i class="fa-brands fa-facebook"></i></a></li>
                                <li><a href="{SHOP_LINK_TWITTER}"><i class="fa-brands fa-twitter"></i></a></li>
                                <li><a href="{SHOP_LINK_INSTAGRAM}"><i class="fa-brands fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- <img src="https://demo.zozone.de/storage/shop/cover/16613143506305a52e91497.png" alt="" data-ww="['965px','965px','500px','300px']" data-hh="['894px','894px','463px','278px']" width="407" height="200" data-no-retina="" style="bottom: 0; position: absolute; width: auto; right: 0; height: 500px; transition: none 0s ease 0s; text-align: inherit; line-height: 0px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 3px;"> -->
                </div>
                <!-- Single Slider End -->

            </div>
        </div>
    </div>
    <!-- Slider End -->

    <!-- About Start -->
    <div class="section section-padding-02 about-section">

        <img class="shape-1 movebounce-03" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-5.webp" width="420" height="210" alt="Shape">

        <div class="container">
            <!-- About Wrapper Start -->
            <div class="about-wrapper">
                <div id="about.id" class="row justify-content-center align-items-center">
                    <div class="col-lg-6 col-md-8">
                        <!-- About Image Start -->
                        <div class="about-image" data-aos="fade-up" data-aos-delay="200">
                            <img src="{SITE_URL}storage/shop/outstanding_service/{STORY_IMAGE}" width="540" height="565" alt="About">
                        </div>
                        <!-- About Image End -->
                    </div>
                    <div class="col-lg-6">
                        <!-- About Image Start -->
                        <div class="about-content" data-aos="fade-up" data-aos-delay="200">
                            <!-- Section Title Start -->
                            <div class="section-title">
                                <!-- <h6 class="sub-title">Wellcom to Peerly</h6> -->
                                <h2 id="dzservices.id" class="title">{SHOP_TITLE_STORY} <img class="shape"
                                        src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-15.webp" alt="Shape"></h2>
                            </div>
                            <!-- Section Title End -->
                            <p class="text">{SHOP_SUB_TITLE_STORY}</p>
                            <p>{SHOP_STORY}</p>
                            <!-- <a href="about.html" class="btn btn-primary btn-hover-dark">More</a> -->
                        </div>
                        <!-- About Image End -->
                    </div>
                </div>
            </div>
            <!-- About Wrapper End -->
        </div>
    </div>
    <!-- About End -->

    IF("{SHOP_SPECIAL_OFFER_DISPLAY}" == "1"){
        <div class="section services-section"
            style="background-image: url({SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/patan-bg.webp);">
    
            <!-- Services Wrapper Start -->
            <div class="services-wrapper">
    
                <!-- Services Main Content Start -->
                <div class="services-main-content" data-aos="fade-up" data-aos-delay="200">
    
                    <img class="shape-1 movebounce-02"
                        src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-6.webp" alt="Shape">
                    <img class="shape-2 movebounce-03"
                        src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-7.webp" alt="Shape">
                    <img class="shape-3" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-8.webp"
                        alt="Shape">
                        
                    IF("{SHOP_SPECIAL_OFFER_DISPLAY}" == "1"){ 
                    <!-- Section Title Start -->
                    <div class="section-title text-center">
                        <h6 class="sub-title">{LANG_WELCOME} {NAME}</h6>
                        <h2 class="title">{LANG_OUR_ACTIONS}</h2>
                        <!-- <p>Peerly is the best Spa therapy is the best way of Spa cases are some perfectly simple and easy to distinguish free hour</p> -->
                    </div>
                    {:IF}
                    <!-- Section Title End -->
                    IF("{SHOP_SPECIAL_OFFER_DISPLAY}" == "1"){ 
                    <div class="services-active">
                        <div class="swiper-container ">
                            <div class="swiper-wrapper ">
                                {CAT_MENU_DISCOUNT}
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    {:IF}
                </div>
                <!-- Services Main Content End -->
    
                <!-- Services Background Start -->
                <div class="services-background"
                    style="background-image: url({SITE_URL}storage/shop/cover/{BANNER_2});">
                </div>
                <!-- Services Background End -->
    
            </div>
            <!-- Services Wrapper End -->
    
        </div>
        {:IF}

   
  

    {LOOP: CAT_MENU} 
    <div class="section section-padding-02">
        <div class="container">
            <div  class="spa-pricing-wrapper">
                <div id="category_{CAT_MENU.id}" class="row align-items-center cat-menu-{CAT_MENU.left_or_right}">

                    IF("{CAT_MENU.left_or_right}" == "left"){
                    <div class="col-lg-6">
                        <div class="spa-pricing-content" data-aos="fade-right" data-aos-delay="200">             
                            <div class="section-title">                
                                <h2 class="title" style="text-align: center;">{CAT_MENU.name}<img class="shape"
                                        src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-15.webp" alt="Shape"></h2>
                            </div>                   
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="spa-pricing-table" data-aos="fade-left" data-aos-delay="200">
                            <img class="shape-4 movebounce-02" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-9.webp" width="178"
                                height="138" alt="Shape">
                            <div class="spa-pricing-table-wrapper pricing-active">
                                <img class="shape-1" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-2.webp" alt="Shape">
                                <img class="shape-3" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-3.webp" alt="Shape">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                           
                                            {CAT_MENU.menu}
                                        </div>

                                    
                                    </div>
                                </div>
                                <img class="shape-2" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-2.webp" alt="Shape">

                            </div>
                        </div>
                    </div>
                    {ELSE}
                    <div class="col-lg-6">
                        <div class="spa-pricing-content" data-aos="fade-right" data-aos-delay="200">             
                            <div class="section-title">                
                                <h2 class="title" style="text-align: center;">{CAT_MENU.name}<img class="shape"
                                        src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-15.webp" alt="Shape"></h2>
                            </div>                   
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="spa-pricing-table" data-aos="fade-left" data-aos-delay="200">
                            <img class="shape-4 movebounce-02" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-9.webp" width="178"
                                height="138" alt="Shape">
                            <div class="spa-pricing-table-wrapper pricing-active">
                                <img class="shape-1" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-2.webp" alt="Shape">
                                <img class="shape-3" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-3.webp" alt="Shape">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                           
                                            {CAT_MENU.menu}
                                        </div>

                                    
                                    </div>
                                </div>
                                <img class="shape-2" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-2.webp" alt="Shape">

                            </div>
                        </div>
                    </div>
                    
                    {:IF}

                </div>
            </div>
        </div>
    </div>
    {/LOOP: CAT_MENU}
    <!-- Gallery -->
		IF("{SHOP_DISPLAY_GROUP_IMAGE}"=="1"){
            <div class="section-full content-inner-1 bridal-portfolio">
                <div class="container-fluid wow slideInUp">
                    <div class="section-head text-black text-center bridal-head">					
                        <h2 class="m-b10 classic-font-and-color heading-font-options" style="font-size: 50px;
                        font-weight: 700;
                        color: var(--classic-color-1);
                        line-height: 1.2;
                        margin-top: 10px;
                        letter-spacing: 1px;">{LANG_GALLERY}</h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="site-filters style1 clearfix center">
                                <ul class="filters" data-toggle="buttons" style="text-align: center; font-size: 22px;">
                                    <li data-filter="" class="btnn"><a href="#"><span>{LANG_ALL}</span></a></li>
                                    {LOOP: GROUP_IMAGE}
                                    <li data-filter="{GROUP_IMAGE.id}" class="btnn"><a href="#"><span>{GROUP_IMAGE.name}</span></a></li>
                                    {/LOOP: GROUP_IMAGE}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="gallery" class="clearfix">
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
                    <!-- demo -->
                    <div class="wrapperr">
                        <div class="imager">
                            <img src="shop-templates/img1.jpeg" alt="" />
                        </div>
                        <div class="imager">
                            <img src="shop-templates/img2.jpeg" alt="" />
                        </div>
                        <div class="imager">
                            <img src="shop-templates/img3.jpeg" alt="" />
                        </div>
                        <div class="imager">
                            <img src="shop-templates/img4.jpeg" alt="" />
                        </div>
                        <div class="imager">
                            <img src="shop-templates/img5.jpeg" alt="" />
                        </div>
                        <div class="imager">
                            <img src="shop-templates/img6.jpeg" alt="" />
                        </div>
                        <div class="imager">
                            <img src="shop-templates/img7.jpeg" alt="" />
                        </div>
                        <div class="imager">
                            <img src="shop-templates/img8.jpeg" alt="" />
                        </div>
                    </div>
            
                    <div class="galleryr">
                        <span class="control prev">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                        <span class="control next">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                        <div class="gallery-inner">
                            <img src="" alt="" />
                        </div>
                        <i class="fas fa-times close"></i>
                    </div>
                    <!-- demo  -->
                </div>
            </div>
            {:IF}	
            <!--end gallery -->
 

    <!-- Brand Start -->
    <div class="text-black text-center bridal-head">
        <h2 class="m-b10 classic-font-and-color heading-font-options" style="font-size: 50px;font-weight: 700;color: var(--classic-color-1);line-height: 1.2;margin-top: 10px;letter-spacing: 1px;">{LANG_OUR_STAFFS}</h2>					
    </div>
    <div id="staff" class="section section-padding-02">
        <div class="container">
            <!-- Brand Start -->
            <div  class="brand-wrapper brand-active">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                    	{LOOP: OUR_STAFFS}
                        <div class="swiper-slide single-brand">
                            <img src="{SITE_URL}/storage/profile/{OUR_STAFFS.image}" height="107" alt="Brand" style="object-fit: cover; height: 150px; width: 150px; border-radius: 50%;">
                            <div class="testimonial-detail"> <strong class="testimonial-name" style="font-size: 22px;">{OUR_STAFFS.name}</strong></div>
                        </div>
                        
                        {/LOOP: OUR_STAFFS}	
                     
                     
                    </div>
                </div>
            </div>
            <!-- Brand End -->
        </div>
    </div>
    <!-- Brand End -->

    <!-- Footer Start -->
    <div class="footer-section section">

        <!-- Footer Top Start -->
        <div class="footer-top">

            <img class="shape-1 movebounce-01" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-16.webp" width="185" height="231"
                alt="Shape">
            <img class="shape-2 movebounce-02" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-17.webp" width="188" height="156"
                alt="Shape">
            <img class="shape-3 movebounce-01" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-18.webp" width="503" height="287"
                alt="Shape">

            <div class="container">

                <!-- Contact Form Wrapper Start -->
                <div id="contact.id" class="contact-form-wrapper">
                    <div class="row flex-row-reverse justify-content-center">
                        <div class="col-lg-6 col-md-8 col-sm-10">
                            <!-- Contact Form Image Start -->
                            <div id="googleMap" style="width:100%;height:400px;margin-top:70px;"></div>
                            <script>
                                function myMap() {
                                var mapProp= {
                                  center:new google.maps.LatLng(49.7321695,9.9665817),
                                  zoom:15,
                                };
                                var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
                                }
                                </script>
                            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxnzPUmpejQebxwVhA6BIoOOGjPjbq4Mo&callback=myMap"></script>
                            <!-- <div class="contact-form-image">
                                <div class="image">
                                    <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/contact-2.webp" width="506" height="527" alt="Choose">
                                </div>
                            </div> -->
                            <!-- Contact Form Image End -->
                        </div>

                        <div class="col-lg-6">
                            <!-- Contact Form Start -->
                            <div class="contact-form">
                                <h3 style="text-align: center;" class="form-title">{LANG_CONTACT}</h3>

                                <form action="#">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Single Form Start -->
                                            <div class="single-form">
                                                <input type="text" placeholder="{LANG_FULL_NAME}">
                                            </div>
                                            <!-- Single Form End -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Single Form Start -->
                                            <div class="single-form">
                                                <input type="email" placeholder="{LANG_EMAIL}">
                                            </div>
                                            <!-- Single Form End -->
                                        </div>
                                        <div class="col-md-12">
                                            <!-- Single Form Start -->
                                            <div class="single-form">
                                                <textarea placeholder="{LANG_MESSAGE}... "></textarea>
                                            </div>
                                            <!-- Single Form End -->
                                        </div>
                                        <div class="col-md-12">
                                            <!-- Single Form Start -->
                                            <div style="text-align: center;" class="btn-margin">
                                                <button class="btn btn-primary btn-hover-dark">{LANG_SUBMIT}</button>
                                            </div>
                                            <!-- Single Form End -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Contact Form End -->
                        </div>
                    </div>
                </div>
                <!-- Contact Form Wrapper End -->

                <!-- Footer Widget Wrapper Start -->
                <div class="footer-widget-wrapper">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <!-- Footer Widgte Start -->
                            <div class="footer-widget" data-aos="fade-up" data-aos-delay="150">
                                <h6 style="font-size: 20px;" class="widget-title">{LANG_PHONE} &amp; {LANG_EMAIL_ADDRESS}</h6>
                                <ul>
                                    IF("{PHONE}"!=""){
                                    <li><i class="fa fa-phone"></i><a style="margin-left: 10px;" href="tel:{PHONE}">{PHONE}</a> <br>
                                    {:IF}
                                    IF("{EMAIL}"!=""){
                                        <i class="fa fa-envelope"></i><a style="margin-left: 10px;" href="mailto:{EMAIL}">{EMAIL}</a></li>
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
                            <!-- Footer Widgte End -->
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <!-- Footer Widgte Start -->
                            <div class="footer-widget" data-aos="fade-up" data-aos-delay="300">
                                <h4 style="font-size: 20px;" class="widget-title">{LANG_ADDRESS}</h4>

                                <!-- Widgte Link Start -->
                                <div class="footer-widget-link">
                                    <ul>
                                        <li><i class="fa fa-map-marker"></i><a target="_blank" href="https://maps.google.com/?q={ADDRESS}" style="margin-left: 10px;">{ADDRESS}</a></li>                                      
                                    </ul>
                                </div>
                                <!-- Widgte Link End -->
                            </div>
                            <!-- Footer Widgte End -->
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <!-- Footer Widgte Start -->
                            <div class="footer-widget" data-aos="fade-up" data-aos-delay="450">
                                <h4 style="font-size: 20px;" class="widget-title">{LANG_OPEN_HOUR}</h4>

                                <!-- Widgte Link Start -->
                                <div class="footer-widget-link">
                                    <p>{LANG_MONDAY} <span>{OPEN_HOUR_2}</span></p>
                                    <p>{LANG_TUESDAY} <span>{OPEN_HOUR_3}</span></p>
                                    <p>{LANG_WEDNESDAY}<span>{OPEN_HOUR_4}</span></p>
                                    <p>{LANG_THURSDAY} <span>{OPEN_HOUR_5}</span></p>
                                    <p>{LANG_FRIDAY} <span>{OPEN_HOUR_6}</span></p>
                                    <p>{LANG_SATURDAY} <span>{OPEN_HOUR_7}</span></p>
                                    <p>{LANG_SUNDAY} <span>{OPEN_HOUR_1}</span></p>
                                </div>
                                <!-- Widgte Link End -->
                            </div>
                            <!-- Footer Widgte End -->
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <!-- Footer Widgte Start -->
                            <div class="footer-widget" data-aos="fade-up" data-aos-delay="600" style="float: right;">
                                <a href="{SITE_URL}{SLUG}/booking" class="btn btn-primary btn-hover-white">{LANG_BOOK_NOW}</a>
                            </div>
                            <!-- Footer Widgte End -->
                        </div>
                        
                    </div>
                </div>
                <!-- Footer Widget Wrapper End -->
            </div>
        </div>
        <!-- Footer Top End -->

        <!-- Footer Copyright Start -->
        <div class="footer-copyright">
            <div class="container">
                <!-- Copyright Wrapper Start -->
                <div class="copyright-wrapper flex-row-reverse">
                    <div class="payment-method">
                        <ul class="payment-icon">
                            <li><a class="right-ft-link" href="{LINK_AGB_RESTAURANTS}?id={SHOP_ID}">AGB</a></li>
                            <li><a class="right-ft-link" href="{LINK_DATA_PROTECTION_RESTAURANTS}?id={SHOP_ID}">Datenschutzerklärung</a></li>
                            <li><a class="right-ft-link" href="{LINK_IMPRESSUM_RESTAURANTS}?id={SHOP_ID}">Impressum</a></li>
                        </ul>
                    </div>

                    <div class="copyright-text">
                        <p>{COPYRIGHT_TEXT}</p>
                    </div>

                </div>
                <!-- Copyright Wrapper End -->
            </div>
        </div>
        <!-- Footer Copyright End -->

    </div>
    <!-- Footer End -->

    <!--Back To Start-->
    <button id="backBtn" class="back-to-top"><i class="icofont-simple-up"></i></button>
    <!--Back To End-->

    </div>

    <!-- The Modal -->
    <div id="modalProductDetail" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal_header">
                <p>Hello huy hoang</p>
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="modal_body">
            </div>
                
        </div>
    </div>

    <!-- JS
    ============================================ -->
    <!-- Bootstrap JS -->
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/js/plugins/popper.min.js"></script>
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/js/plugins/bootstrap.min.js"></script>

    <!-- Plugins JS -->
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/js/plugins/swiper-bundle.min.js"></script>
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/js/plugins/nouislider.js"></script>
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/js/plugins/star-rating.js"></script>
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/js/plugins/nice-select2.js"></script>
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/js/plugins/glightbox.min.js"></script>
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/js/plugins/aos.js"></script>


    <!-- Main JS -->
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/js/main.js"></script>
    
</body>

</html>