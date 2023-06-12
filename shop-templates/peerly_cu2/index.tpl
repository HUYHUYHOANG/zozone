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
    <link rel="shortcut icon" href="{SITE_URL}storage/logo/{SITE_FAVICON}" />

    <!-- CSS
	============================================ -->

    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/css/plugins/font-awesome.min.css">
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

        :root {
                {
                LOOP: CLASSIC_COLOR
            }

            --classic-color- {
                CLASSIC_COLOR.id
            }

            : {
                CLASSIC_COLOR.value
            }

            ;

                {
                /LOOP: CLASSIC_COLOR
            }

            --menu-fore-color: {
                SHOP_MENU_FORE_COLOR
            }

            ;

            --menu-color: {
                SHOP_MENU_FORE_COLOR
            }

            ;
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
                        <a href="#"><img src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}" width="172" height="45"
                                alt="Logo"></a>
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
                            <li><a href="#staff">{LANG_OUR_STAFFS}</a></li>
                            {:IF}
                            <li><a class="dez-page" href="#contact.id">{LANG_CONTACT}</a></li>
                            IF("{LOGGED_IN}"=="1"){
                            <li><a class="loginout" data-action="logout"
                                    href="{SITE_URL}{SLUG}/login?logout=true">{LANG_LOGOUT}</a></li>
                            {ELSE}
                            <li><a class="loginout" data-action="login" href="{SITE_URL}{SLUG}/login?login=true"><i
                                        class="fa-sharp fa-solid fa-lock" style="font-size:12px;"></i> {LANG_LOGIN}</a>
                            </li>
                            {:IF}
                        </ul>
                    </div>
                    <!-- Header Navbar End -->
                </div>
                <!-- Header Wrapper End -->

            </div>
        </div>
        <!-- Header End -->


        <!-- Offcanvas Start -->
        <div class="offcanvas offcanvas-start" id="offcanvasNavbar">

            <div class="offcanvas-header">
                <!-- Logo Start -->
                <div class="logo">
                    <a href="#"><img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/logo.webp" width="172"
                            height="45" alt="Logo"></a>
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
                        <li><a href="#staff">{LANG_OUR_STAFFS}</a></li>
                        {:IF}
                        <li><a class="dez-page" href="#contact.id">{LANG_CONTACT}</a></li>
                        IF("{LOGGED_IN}"=="1"){
                        <li><a class="loginout" data-action="logout"
                                href="{SITE_URL}{SLUG}/login?logout=true">{LANG_LOGOUT}</a></li>
                        {ELSE}
                        <li><a class="loginout" data-action="login" href="{SITE_URL}{SLUG}/login?login=true"><i
                                    class="fa-sharp fa-solid fa-lock" style="font-size:12px;"></i> {LANG_LOGIN}</a></li>
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
                        style="background-image: url(assets/images/slider/slider-1.webp);">
                        <div class="container">
                            <div class="slider-content">
                                <h1 class="title">Relaxation <br> Bath with the <br> Aroma Therapy</h1>
                                <ul class="slider-meta">
                                    <li><a href="#" class="btn btn-primary btn-hover-white">Book Now</a></li>
                                    <li><a href="https://www.youtube-nocookie.com/embed/Ga6RYejo6Hk"
                                            class="video-play glightbox"><span class="icon"><i
                                                    class="fa fa-play"></i></span> Watch Video</a></li>
                                </ul>
                                <ul class="slider-social">
                                    <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Single Slider End -->

                    <!-- Single Slider Start -->
                    <div class="swiper-slide animation-style-01 single-slider d-flex align-items-center"
                        style="background-image: url(assets/images/slider/slider-2.webp);">
                        <div class="container">
                            <div class="slider-content content-white">
                                <h1 class="title">Relaxation <br> Bath with the <br> Aroma Therapy</h1>
                                <ul class="slider-meta">
                                    <li><a href="#" class="btn btn-white btn-hover-primary">Book Now</a></li>
                                    <li><a href="https://www.youtube-nocookie.com/embed/Ga6RYejo6Hk"
                                            class="video-play glightbox"><span class="icon"><i
                                                    class="fa fa-play"></i></span> Watch Video</a></li>
                                </ul>
                                <ul class="slider-social">
                                    <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Single Slider End -->

                </div>
            </div>
        </div>
        <!-- Slider End -->

        <!-- Feature Start -->
        <div class="section section-padding">
            <div class="container">
                <!-- Features Wrapper Start -->
                <div class="features-wrapper row row-cols-1 row-cols-md-2 row-cols-lg-3 justify-content-center">
                    <div class="col" data-aos="fade-up" data-aos-delay="200">
                        <!-- Single Features Start -->
                        <div class="single-feature text-center">
                            <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/features/icon-1.webp"
                                height="156" alt="feature">
                            <h4 class="title"><a href="hot-stone-spa.html">Massage Therapy</a></h4>
                            <p>Message Therapy is the best way of Spa cases are perfectly simple and easy to
                                distinguish. In a free hour,power</p>
                            <a href="hot-stone-spa.html" class="more">Read more</a>
                        </div>
                        <!-- Single Features End -->
                    </div>
                    <div class="col active" data-aos="fade-up" data-aos-delay="400">
                        <!-- Single Features Start -->
                        <div class="single-feature text-center">
                            <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/features/icon-2.webp"
                                height="156" alt="feature">
                            <h4 class="title"><a href="hot-stone-spa.html">Aroma Therapy</a></h4>
                            <p>Message Therapy is the best way of Spa cases are perfectly simple and easy to
                                distinguish. In a free hour,power</p>
                            <a href="hot-stone-spa.html" class="more">Read more</a>
                        </div>
                        <!-- Single Features End -->
                    </div>
                    <div class="col" data-aos="fade-up" data-aos-delay="600">
                        <!-- Single Features Start -->
                        <div class="single-feature text-center">
                            <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/features/icon-3.webp"
                                height="156" alt="feature">
                            <h4 class="title"><a href="hot-stone-spa.html">Organic Therapy</a></h4>
                            <p>Message Therapy is the best way of Spa cases are perfectly simple and easy to
                                distinguish. In a free hour,power</p>
                            <a href="hot-stone-spa.html" class="more">Read more</a>
                        </div>
                        <!-- Single Features End -->
                    </div>
                </div>
                <!-- Features Wrapper End -->
            </div>
        </div>
        <!-- Feature End -->

        <!-- About Start -->
        <div class="section section-padding-02 about-section">

            <img class="shape-1 movebounce-03"
                src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-5.webp" width="420" height="210"
                alt="Shape">

            <div class="container">
                <!-- About Wrapper Start -->
                <div class="about-wrapper">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-6 col-md-8">
                            <!-- About Image Start -->
                            <div class="about-image" data-aos="fade-up" data-aos-delay="200">
                                <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/about.webp" width="540"
                                    height="565" alt="About">
                            </div>
                            <!-- About Image End -->
                        </div>
                        <div class="col-lg-6">
                            <!-- About Image Start -->
                            <div class="about-content" data-aos="fade-up" data-aos-delay="200">
                                <!-- Section Title Start -->
                                <div class="section-title">
                                    <h6 class="sub-title">Wellcom to Peerly</h6>
                                    <h2 class="title">Incredible & <br> Relaxiable Spa <img class="shape"
                                            src="assets/images/shape/shape-15.webp" alt="Shape"></h2>
                                </div>
                                <!-- Section Title End -->
                                <p class="text">We have more than 20 years of Exprience with 100% client Satisfaction
                                </p>
                                <p>Peerly is the best Spa therapy is the best way of Spa cases are some perfectly simple
                                    and easy to distinguish. In a free hour,power can help you for a relaxation and
                                    fresh mind with great enjoy take an example, which of us ever undertakes laborious
                                    physical satisfaction</p>
                                <a href="about.html" class="btn btn-primary btn-hover-dark">Learn more</a>
                            </div>
                            <!-- About Image End -->
                        </div>
                    </div>
                </div>
                <!-- About Wrapper End -->
            </div>
        </div>
        <!-- About End -->

        <!-- Services Start -->
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

                    <!-- Section Title Start -->
                    <div class="section-title text-center">
                        <h6 class="sub-title">Service</h6>
                        <h2 class="title">Our Spa Service</h2>
                        <p>Peerly is the best Spa therapy is the best way of Spa cases are some perfectly simple and
                            easy to distinguish free hour</p>
                    </div>
                    <!-- Section Title End -->

                    <div class="services-active">
                        <div class="swiper-container ">
                            <div class="swiper-wrapper ">
                                <div class="swiper-slide">
                                    <!-- Services Start -->
                                    <div class="single-services text-center">
                                        <div class="services-image">
                                            <a href="therapy-details.html"><img
                                                    src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/services/services-1.webp"
                                                    width="233" height="233" alt="services"></a>
                                            <span class="price"> $75</span>
                                        </div>
                                        <div class="services-content">
                                            <h4 class="title"><a href="therapy-details.html">Hot Stone</a></h4>
                                            <p>Hot Stone Spa is the best your health and refresh</p>
                                        </div>
                                    </div>
                                    <!-- Services End -->
                                </div>
                                <div class="swiper-slide">
                                    <!-- Services Start -->
                                    <div class="single-services text-center">
                                        <div class="services-image">
                                            <a href="therapy-details.html"><img
                                                    src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/services/services-2.webp"
                                                    width="233" height="233" alt="services"></a>
                                            <span class="price"> $64</span>
                                        </div>
                                        <div class="services-content">
                                            <h4 class="title"><a href="therapy-details.html">Face Scrub</a></h4>
                                            <p>Face Scrub Spa is the best your health and refresh</p>
                                        </div>
                                    </div>
                                    <!-- Services End -->
                                </div>
                                <div class="swiper-slide">
                                    <!-- Services Start -->
                                    <div class="single-services text-center">
                                        <div class="services-image">
                                            <a href="therapy-details.html"><img
                                                    src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/services/services-3.webp"
                                                    width="233" height="233" alt="services"></a>
                                            <span class="price"> $75</span>
                                        </div>
                                        <div class="services-content">
                                            <h4 class="title"><a href="therapy-details.html">Oil Massage</a></h4>
                                            <p>Oil Massage Spa is the best your health and refresh</p>
                                        </div>
                                    </div>
                                    <!-- Services End -->
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
                <!-- Services Main Content End -->

                <!-- Services Background Start -->
                <div class="services-background"
                    style="background-image: url({SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/services/service-bg.webp);">
                </div>
                <!-- Services Background End -->

            </div>
            <!-- Services Wrapper End -->

        </div>
        <!-- Services End -->

        <!-- Why Choose US Start -->
        <div class="section section-padding">
            <div class="container">

                <!-- Section Title Start -->
                <div class="section-title text-center">
                    <h6 class="sub-title">Good For Health</h6>
                    <h2 class="title">Why we are different </h2>
                    <p>Peerly is the best Spa therapy is the best way of Spa cases are some perfectly simple and easy to
                        distinguish free hour</p>
                </div>
                <!-- Section Title End -->

                <!-- Choose Wrapper Start -->
                <div class="choose-wrapper">
                    <div class="row justify-content-center align-items-center gx-lg-0">
                        <div class="col-lg-3 col-sm-6 order-2 order-lg-1">
                            <!-- Single Choose Start -->
                            <div class="single-choose" data-aos="fade-up" data-aos-delay="100">
                                <h4 class="title">Exprienced Specialists</h4>
                                <p>Message Therapy is the best way of Spa cases are perfectly simple and easy</p>
                            </div>
                            <!-- Single Choose End -->
                            <!-- Single Choose Start -->
                            <div class="single-choose" data-aos="fade-up" data-aos-delay="200">
                                <h4 class="title">100% Safe & Natural</h4>
                                <p>Message Therapy is the best way of Spa cases are perfectly simple and easy</p>
                            </div>
                            <!-- Single Choose End -->
                            <!-- Single Choose Start -->
                            <div class="single-choose" data-aos="fade-up" data-aos-delay="300">
                                <h4 class="title">Special gifts & Offers</h4>
                                <p>Message Therapy is the best way of Spa cases are perfectly simple and easy</p>
                            </div>
                            <!-- Single Choose End -->
                        </div>
                        <div class="col-lg-6 order-1 col-md-8 order-lg-2">
                            <!-- Choose Image Start -->
                            <div class="choose-image" data-aos="fade-up" data-aos-delay="200">
                                <div class="image">
                                    <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/choose.webp"
                                        width="488" height="499" alt="Choose">
                                </div>
                            </div>
                            <!-- Choose Image End -->
                        </div>
                        <div class="col-lg-3 col-sm-6 order-3 order-lg-3">
                            <!-- Single Choose Start -->
                            <div class="single-choose" data-aos="fade-up" data-aos-delay="100">
                                <h4 class="title">Qulaity & Natural Herbs</h4>
                                <p>Message Therapy is the best way of Spa cases are perfectly simple and easy</p>
                            </div>
                            <!-- Single Choose End -->
                            <!-- Single Choose Start -->
                            <div class="single-choose" data-aos="fade-up" data-aos-delay="200">
                                <h4 class="title">Unique from other Spa</h4>
                                <p>Message Therapy is the best way of Spa cases are perfectly simple and easy</p>
                            </div>
                            <!-- Single Choose End -->
                            <!-- Single Choose Start -->
                            <div class="single-choose" data-aos="fade-up" data-aos-delay="300">
                                <h4 class="title">Spa Consultancy</h4>
                                <p>Message Therapy is the best way of Spa cases are perfectly simple and easy</p>
                            </div>
                            <!-- Single Choose End -->
                        </div>
                    </div>
                </div>
                <!-- Choose Wrapper End -->

            </div>
        </div>
        <!-- Why Choose US End -->

        <!-- Spa Pricing Start -->
        <div class="section section-padding-02">
            <div class="container">
                <!-- Spa Pricing Wrapper Start -->
                <div class="spa-pricing-wrapper">

                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <!-- Spa Pricing Content Start -->
                            <div class="spa-pricing-content" data-aos="fade-right" data-aos-delay="200">
                                <!-- Section Title Start -->
                                <div class="section-title">
                                    <h6 class="sub-title">Spa Pricing</h6>
                                    <h2 class="title">Our Spa & <br> Therapy Price <img class="shape"
                                            src="assets/images/shape/shape-15.webp" alt="Shape"></h2>
                                </div>
                                <!-- Section Title End -->
                                <p class="text">Modern & Latest Spa Therapy is always available for our valuable clients
                                </p>
                                <p>Peerly is the best Spa therapy is the best way of Spa cases are perfectly simple and
                                    easy to distinguish. In a free hour, power can you for a relaxation and fresh mind
                                    with great enjoy take some which of us ever undertakes laborious satisfaction</p>
                                <a href="pricing.html" class="btn btn-primary btn-hover-dark">View more</a>
                            </div>
                            <!-- Spa Pricing Content End -->
                        </div>
                        <div class="col-lg-6">
                            <!-- Spa Pricing Table Start -->
                            <div class="spa-pricing-table" data-aos="fade-left" data-aos-delay="200">

                                <img class="shape-4 movebounce-02"
                                    src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-9.webp"
                                    width="178" height="138" alt="Shape">

                                <div class="spa-pricing-table-wrapper pricing-active">
                                    <img class="shape-1"
                                        src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-2.webp"
                                        alt="Shape">

                                    <img class="shape-3"
                                        src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-3.webp"
                                        alt="Shape">

                                    <div class="swiper-container">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="pricing-table-wrapper">

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Aroma Therapy</p>
                                                        <span class="line"></span>
                                                        <p class="price">$75</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Sauna Relax</p>
                                                        <span class="line"></span>
                                                        <p class="price">$60</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Geothermal Spa</p>
                                                        <span class="line"></span>
                                                        <p class="price">$90</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Face Mask</p>
                                                        <span class="line"></span>
                                                        <p class="price">$56</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Manicure Pack</p>
                                                        <span class="line"></span>
                                                        <p class="price">$35</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Hot Ston Spa</p>
                                                        <span class="line"></span>
                                                        <p class="price">$95</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="pricing-table-wrapper">

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Aroma Therapy</p>
                                                        <span class="line"></span>
                                                        <p class="price">$75</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Sauna Relax</p>
                                                        <span class="line"></span>
                                                        <p class="price">$60</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Geothermal Spa</p>
                                                        <span class="line"></span>
                                                        <p class="price">$90</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Face Mask</p>
                                                        <span class="line"></span>
                                                        <p class="price">$56</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Manicure Pack</p>
                                                        <span class="line"></span>
                                                        <p class="price">$35</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Hot Ston Spa</p>
                                                        <span class="line"></span>
                                                        <p class="price">$95</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="pricing-table-wrapper">

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Aroma Therapy</p>
                                                        <span class="line"></span>
                                                        <p class="price">$75</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Sauna Relax</p>
                                                        <span class="line"></span>
                                                        <p class="price">$60</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Geothermal Spa</p>
                                                        <span class="line"></span>
                                                        <p class="price">$90</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Face Mask</p>
                                                        <span class="line"></span>
                                                        <p class="price">$56</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Manicure Pack</p>
                                                        <span class="line"></span>
                                                        <p class="price">$35</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                    <!-- Ssingle Pricing Start -->
                                                    <div class="single-price">
                                                        <p class="title">Hot Ston Spa</p>
                                                        <span class="line"></span>
                                                        <p class="price">$95</p>
                                                    </div>
                                                    <!-- Ssingle Pricing End -->

                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-pagination"></div>
                                    </div>

                                    <img class="shape-2"
                                        src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-2.webp"
                                        alt="Shape">

                                </div>
                            </div>
                            <!-- Spa Pricing Table End -->
                        </div>
                    </div>

                </div>
                <!-- Spa Pricing Wrapper End -->
            </div>
        </div>
        <!-- Spa Pricing End -->

        <!-- Call to Action Start -->
        <div class="section call-to-action-serction"
            style="background-image: url({SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/patan-bg-2.webp);">
            <!-- Call to Action bg Start -->
            <div class="call-to-action-bg"
                style="background-image: url({SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/cta-bg.webp);">
            </div>
            <!-- Call to Action bg End -->

            <!-- Call to Action Content Start -->
            <div class="call-to-action-content section-padding-02">

                <img class="shape-1 movebounce-01" width="194" height="227"
                    src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-10.webp" alt="Shape">

                <img class="shape-2" src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-11.webp"
                    width="146" height="145" alt="Shape">

                <!-- Call to Action Wrapper Start -->
                <div class="call-to-action-wrapper text-center" data-aos="fade-up" data-aos-delay="200">
                    <!-- Section Title Start -->
                    <div class="section-title text-center">
                        <h6 class="sub-title">Special Offer</h6>
                        <h2 class="title">Spa Weekend!</h2>
                        <p>Peerly is the best Spa therapy is the best way of Spa cases are some perfectly simple and
                            easy to distinguish free hour</p>
                    </div>
                    <!-- Section Title End -->
                    <h4 class="discount">Get up to 65% Discount</h4>
                    <a href="contact.html" class="btn btn-primary btn-hover-dark">Book Now</a>
                </div>
                <!-- Call to Action Wrapper End -->

                <img class="shape-3 movebounce-03"
                    src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-12.webp" width="216"
                    height="190" alt="Shape">

                <img class="shape-4 movebounce-02"
                    src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-13.webp" width="363"
                    height="231" alt="Shape">

            </div>
            <!-- Call to Action Content End -->
        </div>
        <!-- Call to Action End -->

        <!-- Testimonial Start -->
        <div class="section section-padding testimonial-section">

            <img class="shape-1 movebounce-03"
                src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-14.webp" width="212"
                height="191" alt="Shape">

            <div class="container">

                <!-- Section Title Start -->
                <div class="section-title text-center">
                    <h6 class="sub-title">Testimonial</h6>
                    <h2 class="title">Our Client’s Expression</h2>
                    <p>Peerly is the best Spa therapy is the best way of Spa cases are some perfectly simple and easy to
                        distinguish free hour</p>
                </div>
                <!-- Section Title End -->

                <!-- Testimonial Wrapper Start -->
                <div class="testimonial-wrapper testimonial-active" data-aos="fade-up" data-aos-delay="200">
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">

                            <div class="swiper-container">
                                <div class="swiper-wrapper">

                                    <!-- Single Testimonial Start -->
                                    <div class="swiper-slide single-testimonial">
                                        <div class="testimonial-author">
                                            <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/author/author-1.webp"
                                                width="206" height="206" alt="Author">
                                            <div class="author-quote">
                                                <i class="icofont-quote-right"></i>
                                            </div>
                                        </div>
                                        <div class="testimonial-content">
                                            <p>Peerly is the best Spa centre. They serve best service for us amd I am
                                                very much so satisfy with them is the best way of Spa cases perfectly
                                                simple and easy</p>
                                            <h4 class="name">Rose Williams</h4>
                                            <div class="rating">
                                                <div class="rating-star" style="width: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Testimonial End -->

                                    <!-- Single Testimonial Start -->
                                    <div class="swiper-slide swiper-slide single-testimonial">
                                        <div class="testimonial-author">
                                            <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/author/author-2.webp"
                                                width="206" height="206" alt="Author">
                                            <div class="author-quote">
                                                <i class="icofont-quote-right"></i>
                                            </div>
                                        </div>
                                        <div class="testimonial-content">
                                            <p>Peerly is the best Spa centre. They serve best service for us amd I am
                                                very much so satisfy with them is the best way of Spa cases perfectly
                                                simple and easy</p>
                                            <h4 class="name">Rose Williams</h4>
                                            <div class="rating">
                                                <div class="rating-star" style="width: 80%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Testimonial End -->

                                </div>
                            </div>

                        </div>
                        <div class="col">

                            <div class="swiper-container">
                                <div class="swiper-wrapper">

                                    <!-- Single Testimonial Start -->
                                    <div class="swiper-slide swiper-slide single-testimonial">
                                        <div class="testimonial-author">
                                            <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/author/author-2.webp"
                                                width="206" height="206" alt="Author">
                                            <div class="author-quote">
                                                <i class="icofont-quote-right"></i>
                                            </div>
                                        </div>
                                        <div class="testimonial-content">
                                            <p>Peerly is the best Spa centre. They serve best service for us amd I am
                                                very much so satisfy with them is the best way of Spa cases perfectly
                                                simple and easy</p>
                                            <h4 class="name">Rose Williams</h4>
                                            <div class="rating">
                                                <div class="rating-star" style="width: 80%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Testimonial End -->

                                    <!-- Single Testimonial Start -->
                                    <div class="swiper-slide single-testimonial">
                                        <div class="testimonial-author">
                                            <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/author/author-1.webp"
                                                width="206" height="206" alt="Author">
                                            <div class="author-quote">
                                                <i class="icofont-quote-right"></i>
                                            </div>
                                        </div>
                                        <div class="testimonial-content">
                                            <p>Peerly is the best Spa centre. They serve best service for us amd I am
                                                very much so satisfy with them is the best way of Spa cases perfectly
                                                simple and easy</p>
                                            <h4 class="name">Rose Williams</h4>
                                            <div class="rating">
                                                <div class="rating-star" style="width: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Testimonial End -->

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <!-- Testimonial Wrapper End -->

            </div>
        </div>
        <!-- Testimonial End -->

        <!-- Blog Start -->
        <div class="section section-padding">
            <div class="container">
                <!-- Blog Wrapper Start -->
                <div class="blog-wrapper">
                    <div class="row">
                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                            <!-- Blog Sidebar Title Start -->
                            <div class="blog-sidebar-title">
                                <!-- Section Title Start -->
                                <div class="section-title">
                                    <h6 class="sub-title">Blog</h6>
                                    <h2 class="title">Latest Post <br> from Blog <img class="shape"
                                            src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-15.webp"
                                            alt="Shape"></h2>
                                </div>
                                <!-- Section Title End -->
                                <p class="text">Deep discuss about Spa and Therapy Treamment</p>
                                <a href="blog-left-sidebar.html" class="btn btn-primary btn-hover-dark">View more</a>
                            </div>
                            <!-- Blog Sidebar Title End -->
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                            <!-- Single Blog Start -->
                            <div class="single-blog">
                                <div class="blgo-image">
                                    <a href="blog-details-right-sidebar.html"><img
                                            src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/blog/blog-1.webp"
                                            width="314" height="238" alt="Blog"></a>
                                </div>
                                <div class="blgo-content">
                                    <ul class="meta">
                                        <li><a href="#"><i class="fa fa-calendar"></i> 20 Aug, 2022</a></li>
                                        <li><a href="#"><i class="fa fa-user-o"></i> Thomas</a></li>
                                    </ul>
                                    <h3 class="title"><a href="blog-details-right-sidebar.html">Benefit of Hot Ston Spa
                                            for your health & life.</a></h3>
                                </div>
                                <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-4.webp"
                                    class="shape" alt="Shape">
                            </div>
                            <!-- Single Blog End -->
                        </div>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                            <!-- Single Blog Start -->
                            <div class="single-blog">
                                <div class="blgo-image">
                                    <a href="blog-details-right-sidebar.html"><img
                                            src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/blog/blog-2.webp"
                                            width="314" height="238" alt="Blog"></a>
                                </div>
                                <div class="blgo-content">
                                    <ul class="meta">
                                        <li><a href="#"><i class="fa fa-calendar"></i> 20 Aug, 2022</a></li>
                                        <li><a href="#"><i class="fa fa-user-o"></i> Thomas</a></li>
                                    </ul>
                                    <h3 class="title"><a href="blog-details-right-sidebar.html">Facial Scrub is natural
                                            treatment for face.</a></h3>
                                </div>
                                <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-4.webp"
                                    class="shape" alt="Shape">
                            </div>
                            <!-- Single Blog End -->
                        </div>
                    </div>
                </div>
                <!-- Blog Wrapper End -->
            </div>
        </div>
        <!-- Blog End -->

        <!-- Brand Start -->
        <div class="section section-padding-02">
            <div class="container">
                <!-- Brand Start -->
                <div class="brand-wrapper brand-active">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <!-- Single Brand Start -->
                            <div class="swiper-slide single-brand">
                                <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/brand/brand-1.webp"
                                    height="107" alt="Brand">
                            </div>
                            <!-- Single Brand End -->
                            <!-- Single Brand Start -->
                            <div class="swiper-slide single-brand">
                                <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/brand/brand-2.webp"
                                    height="107" alt="Brand">
                            </div>
                            <!-- Single Brand End -->
                            <!-- Single Brand Start -->
                            <div class="swiper-slide single-brand">
                                <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/brand/brand-3.webp"
                                    height="107" alt="Brand">
                            </div>
                            <!-- Single Brand End -->
                            <!-- Single Brand Start -->
                            <div class="swiper-slide single-brand">
                                <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/brand/brand-4.webp"
                                    height="107" alt="Brand">
                            </div>
                            <!-- Single Brand End -->
                            <!-- Single Brand Start -->
                            <div class="swiper-slide single-brand">
                                <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/brand/brand-5.webp"
                                    height="107" alt="Brand">
                            </div>
                            <!-- Single Brand End -->
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

                <img class="shape-1 movebounce-01"
                    src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-16.webp" width="185"
                    height="231" alt="Shape">
                <img class="shape-2 movebounce-02"
                    src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/shape/shape-17.webp" width="188"
                    height="156" alt="Shape">
                <img class="shape-3 movebounce-01"
                    src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}//images/shape/shape-18.webp" width="503" height="287"
                    alt="Shape">

                <div class="container">
                    <!-- Newsletter Wrapper Start -->
                    <div class="newsletter-wrapper text-center" data-aos="fade-up" data-aos-delay="200">
                        <a class="logo" href="index.html"><img
                                src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/logo.webp" width="172"
                                height="45" alt="Logo"></a>
                        <h4 class="title">Want to get latest update and offers!</h4>
                        <p>Subscribe our Newsletter right now</p>
                        <div class="newsletter-form">
                            <form action="#">
                                <input type="text" placeholder="Enter your email here">
                                <button class="btn btn-white btn-hover-dark">Send</button>
                            </form>
                        </div>
                    </div>
                    <!-- Newsletter Wrapper End -->

                    <!-- Footer Widget Wrapper Start -->
                    <div class="footer-widget-wrapper">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <!-- Footer Widgte Start -->
                                <div class="footer-widget" data-aos="fade-up" data-aos-delay="150">
                                    <h4 class="widget-title">Contact Info</h4>

                                    <!-- Widgte Info Start -->
                                    <div class="footer-widget-info">
                                        <div class="single-widget-info">
                                            <h6 class="title">Address</h6>
                                            <p>258C, South City, Main town <br> Brolex Tower, New York</p>
                                        </div>
                                        <div class="single-widget-info">
                                            <h6 class="title">Phone</h6>
                                            <p><a href="tel:+02154785654">+02154 785 654</a></p>
                                            <p><a href="tel:+98745852147">+98745 852 147</a></p>
                                        </div>
                                        <div class="single-widget-info">
                                            <h6 class="title">Web</h6>
                                            <p><a href="mailto:info@example.com">info@example.com</a></p>
                                            <p><a href="mailto:www.example.com">www.example.com</a></p>
                                        </div>
                                    </div>
                                    <!-- Widgte Info End -->
                                </div>
                                <!-- Footer Widgte End -->
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <!-- Footer Widgte Start -->
                                <div class="footer-widget" data-aos="fade-up" data-aos-delay="300">
                                    <h4 class="widget-title">Quick Link</h4>

                                    <!-- Widgte Link Start -->
                                    <div class="footer-widget-link">
                                        <ul>
                                            <li><a href="about.html">About us</a></li>
                                            <li><a href="spa-service.html">Spa Service</a></li>
                                            <li><a href="#">Treatment</a></li>
                                            <li><a href="shop.html">Product</a></li>
                                            <li><a href="#">Our Experts</a></li>
                                            <li><a href="#">Support</a></li>
                                            <li><a href="contact.html">Contact</a></li>
                                        </ul>
                                    </div>
                                    <!-- Widgte Link End -->
                                </div>
                                <!-- Footer Widgte End -->
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <!-- Footer Widgte Start -->
                                <div class="footer-widget" data-aos="fade-up" data-aos-delay="450">
                                    <h4 class="widget-title">Information</h4>

                                    <!-- Widgte Link Start -->
                                    <div class="footer-widget-link">
                                        <ul>
                                            <li><a href="#">Terms & Conditions</a></li>
                                            <li><a href="#">Book Online</a></li>
                                            <li><a href="#">Spa Gift Card</a></li>
                                            <li><a href="#">Offers & Events</a></li>
                                            <li><a href="#">Purchase a Gift Card</a></li>
                                            <li><a href="pricing.html">Pricing Package</a></li>
                                            <li><a href="#">Payment</a></li>
                                        </ul>
                                    </div>
                                    <!-- Widgte Link End -->
                                </div>
                                <!-- Footer Widgte End -->
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <!-- Footer Widgte Start -->
                                <div class="footer-widget" data-aos="fade-up" data-aos-delay="600">
                                    <h4 class="widget-title">Opening Hour</h4>

                                    <!-- Widgte Info Start -->
                                    <div class="footer-widget-info">
                                        <div class="single-widget-info">
                                            <h6 class="title">Monday to Friday</h6>
                                            <p>9.00 am - 10.30 Pm</p>
                                        </div>
                                        <div class="single-widget-info">
                                            <h6 class="title">Saturday to Sunday</h6>
                                            <p>11.00 am - 9.30 Pm</p>
                                        </div>
                                    </div>
                                    <!-- Widgte Info End -->

                                    <!-- Widgte Book End -->
                                    <div class="footer-widget-book">
                                        <h5 class="book-title">Book Now!</h5>
                                        <p><a href="tel:+12345687754">+12345 687 754</a></p>
                                    </div>
                                    <!-- Widgte Book End -->
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
                                <li><img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/payment-icon/icon-1.webp"
                                        height="15" alt="Icon"></li>
                                <li><img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/payment-icon/icon-2.webp"
                                        height="15" alt="Icon"></li>
                                <li><img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/payment-icon/icon-3.webp"
                                        height="15" alt="Icon"></li>
                                <li><img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/images/payment-icon/icon-4.webp"
                                        height="15" alt="Icon"></li>
                            </ul>
                        </div>

                        <div class="copyright-text">
                            <p>&copy; 2022 <span> Peerly Spa </span> Made with <i class="fa fa-heart"></i> by <a
                                    href="#">Codecarnival</a></p>
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
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/js/main.js"></script>

</body>

</html>