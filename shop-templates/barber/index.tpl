<!doctype html>
<html lang="{LANG_CODE}" dir="{LANGUAGE_DIRECTION}" data-menu="classicmenu">

</html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="BarberShop & Hair Salon HTML Template">
    <meta name="author" content="DynamicLayers">
    <title>IF("{PAGE_TITLE}"!=""){ {PAGE_TITLE} - {:IF}{SITE_TITLE}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon"
        href="{SITE_URL}storage/logo/{SITE_FAVICON}/assets/images/favicon.webp">
    <link rel="shortcut icon" href="{SITE_URL}storage/logo/{SITE_FAVICON}" />
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/assets/css/plugins/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {CUSTOM_SETTING_FONT_FACES_AND_CLASSES}

    <!-- Elegant Font Icons CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/elegant-font-icons.css">
    <!-- Elegant Line Icons CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/elegant-line-icons.css">
    <!-- Themify Icon CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/themify-icons.css">
    <!-- Barber Icons CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/barber-icons.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/bootstrap.min.css">
    <!-- animate CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/animate.min.css">
    <!-- Venobox CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/venobox/venobox.css">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/nice-select.css">
    <!-- OWL-Carousel CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/owl.carousel.css">
    <!-- Slick Nav CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/slicknav.min.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/main.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/css/responsive.css">

    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
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
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div id='preloader'>
        <div class='loader'>
            <img src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}" width="100" alt="">
        </div>
    </div><!-- Preloader -->

    <header id="header" class="header-section">
        <div class="container">
            <nav class="navbar ">
                <a href="" class="dez-page"><img src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}" width="190px"
                        height="auto" m data-src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}"></a>
                <div class="d-flex menu-wrap align-items-center">
                    <div id="mainmenu" class="mainmenu">
                        <ul class="nav">
                            <li class="active"><a class="dez-page" href="#dzhome">{LANG_HOME}</a></li>
                            <li><a class="dez-page" href="#dzaboutme">{LANG_ABOUT_ME}</a></li>
                            <li>
                                <a class="dez-page" href="#dzservices">{LANG_SERVICES} <i
                                        class="fa fa-chevron-down"></i></a>
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
                            <li><a class="loginout" data-action="logout"
                                    href="{SITE_URL}{SLUG}/login?logout=true">{LANG_LOGOUT}</a></li>
                            {ELSE}
                            <li><a class="loginout" data-action="login" href="{SITE_URL}{SLUG}/login?login=true"><i
                                        class="fa-sharp fa-solid fa-lock" style="font-size:12px;"></i> {LANG_LOGIN}</a>
                            </li>
                            {:IF}
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header> <!--.header-section -->

    <section class="slider_section">
        <ul id="main-slider" class="owl-carousel main_slider">
            <li class="main_slide d-flex align-items-center"
                style="background-image: url({SITE_URL}storage/shop/cover/{BANNER_2});">
                <div class="container">
                    <div class="slider_content">
                        <h1 class="title" style="color: var(--classic-color-1);">{NAME}</h1>
                        <a href="#" class="default_btn">{LANG_BOOK_NOW}</a>
                        <a href="#" class="default_btn">{LANG_READ_MORE}</a>
                    </div>
                </div>
            </li>
            <li class="main_slide d-flex align-items-center"
                style="background-image: url({SITE_URL}storage/shop/cover/{BANNER_1});">
                <div class="container">
                    <div class="slider_content">
                        <h1 class="title" style="color: var(--classic-color-1);">{NAME}</h1>
                        <a href="#" class="default_btn">{LANG_BOOK_NOW}</a>
                        <a href="#" class="default_btn">{LANG_READ_MORE}</a>
                    </div>
                </div>
            </li>
        </ul>
    </section><!-- /.slider_section -->

    <section id="about" class="about_section bd-bottom padding">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="about_content align-center">
                        <h2 id="dzservices.id" class="title">{SHOP_TITLE_STORY}</h2>
                        <p class="text">{SHOP_SUB_TITLE_STORY}</p>
                        <p>{SHOP_STORY}</p>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-block">
                    <div class="about_img">
                        <img src="{SITE_URL}storage/shop/outstanding_service/{STORY_IMAGE}" alt="idea-images"
                            class="about_img_1 wow fadeInLeft" data-wow-delay="200ms">
                        <img src="{SITE_URL}storage/shop/outstanding_service/{STORY_IMAGE}" alt="idea-images"
                            class="about_img_2 wow fadeInRight" data-wow-delay="400ms">
                        <img src="{SITE_URL}storage/shop/outstanding_service/{STORY_IMAGE}" alt="idea-images"
                            class="about_img_3 wow fadeInLeft" data-wow-delay="600ms">
                    </div>
                </div>
            </div>
        </div>
    </section> <!--/.about_section -->

    <section class="service_section bg-grey padding">
        <div class="container">
            <div class="section_heading text-center mb-40 wow fadeInUp" data-wow-delay="300ms">
                <h2>Our Services</h2>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 sm-padding wow fadeInUp" data-wow-delay="200ms">
                    <div class="service_box">
                        <i class="bs bs-scissors-1"></i>
                        <h3>Haircut Styles</h3>
                        <p>Barber is a person whose occupation is mainly to cut dress style.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 sm-padding wow fadeInUp" data-wow-delay="300ms">
                    <div class="service_box">
                        <i class="bs bs-razor-2"></i>
                        <h3>Beard Triming</h3>
                        <p>Barber is a person whose occupation is mainly to cut dress style.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 sm-padding wow fadeInUp" data-wow-delay="400ms">
                    <div class="service_box">
                        <i class="bs bs-brush"></i>
                        <h3>Smooth Shave</h3>
                        <p>Barber is a person whose occupation is mainly to cut dress style.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 sm-padding wow fadeInUp" data-wow-delay="500ms">
                    <div class="service_box">
                        <i class="bs bs-hairbrush-1"></i>
                        <h3>Face Masking</h3>
                        <p>Barber is a person whose occupation is mainly to cut dress style.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 sm-padding wow fadeInUp" data-wow-delay="200ms">
                    <div class="service_box">
                        <i class="bs bs-scissors-1"></i>
                        <h3>Haircut Styles</h3>
                        <p>Barber is a person whose occupation is mainly to cut dress style.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 sm-padding wow fadeInUp" data-wow-delay="300ms">
                    <div class="service_box">
                        <i class="bs bs-razor-2"></i>
                        <h3>Beard Triming</h3>
                        <p>Barber is a person whose occupation is mainly to cut dress style.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 sm-padding wow fadeInUp" data-wow-delay="400ms">
                    <div class="service_box">
                        <i class="bs bs-brush"></i>
                        <h3>Smooth Shave</h3>
                        <p>Barber is a person whose occupation is mainly to cut dress style.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 sm-padding wow fadeInUp" data-wow-delay="500ms">
                    <div class="service_box">
                        <i class="bs bs-hairbrush-1"></i>
                        <h3>Face Masking</h3>
                        <p>Barber is a person whose occupation is mainly to cut dress style.</p>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/. service_section -->

    <section class="book_section padding">
        <div class="book_bg"></div>
        <div class="map_pattern"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <form action="appointment.php" method="post" id="appointment_form"
                        class="form-horizontal appointment_form">
                        <div class="book_content">
                            <h2>Make an appointment</h2>
                            <p>Barber is a person whose occupation is mainly to cut dress groom <br>style and shave
                                men's and boys hair.</p>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 padding-10">
                                <input type="text" id="app_name" name="app_name" class="form-control" placeholder="Name"
                                    required>
                            </div>
                            <div class="col-md-6 padding-10">
                                <input type="email" id="app_email" name="app_email" class="form-control"
                                    placeholder="Your Email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 padding-10">
                                <input type="text" id="app_phone" name="app_phone" class="form-control"
                                    placeholder="Your Phone No" required>
                            </div>
                            <div class="col-md-6 padding-10">
                                <input type="text" id="app_free_time" name="app_free_time" class="form-control"
                                    placeholder="Your Free Time" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 padding-10">
                                <select class="form-control" id="app_services" name="app_services">
                                    <option>Services</option>
                                    <option>Hair Styling</option>
                                    <option>Shaving</option>
                                    <option>Face Mask</option>
                                    <option>Hair Wash</option>
                                    <option>Beard Triming</option>
                                </select>
                            </div>
                            <div class="col-md-6 padding-10">
                                <select class="form-control" id="app_barbers" name="app_barbers">
                                    <option>Choose Barbers</option>
                                    <option>Michel Brown</option>
                                    <option>Jonathan Smith</option>
                                    <option>Jack Tosan</option>
                                    <option>Martin Lane</option>
                                </select>
                            </div>
                        </div>
                        <button id="app_submit" class="default_btn" type="submit">Make Appointment</button>
                        <div id="msg-status" class="alert" role="alert"></div>
                    </form>
                </div>
            </div>
        </div>
    </section><!-- /.book_section -->

    <section id="team" class="team_section bd-bottom padding">
        <div class="container">
            <div class="section_heading text-center mb-40 wow fadeInUp" data-wow-delay="300ms">
                <h2>{LANG_OUR_STAFFS}</h2>
            </div>
            <ul class="team_members row">
                {LOOP: OUR_STAFFS}
                <li class="col-lg-3 col-md-6 sm-padding wow fadeInUp" data-wow-delay="200ms">
                    <div class="team_member">
                        <img src="{SITE_URL}/storage/profile/{OUR_STAFFS.image}" alt="Team Member">
                        <div class="overlay">
                            <h3>{OUR_STAFFS.name}</h3>
                        </div>
                    </div>
                </li>
                {/LOOP: OUR_STAFFS}
            
            </ul><!-- /.team_members -->
        </div>
    </section><!-- /.team_section -->

    <section class="pricing_section bg-grey bd-bottom padding">
        <div class="container">
            <div class="section_heading text-center mb-40 wow fadeInUp" data-wow-delay="300ms">
                <h2>Our Barber Pricing</h2>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 sm-padding">
                    <div class="price_wrap">
                        <h3>Hair Styling</h3>
                        <ul class="price_list">
                            <li>
                                <h4>Hair Cut</h4>
                                <p>Barber is a person whose occupation is mainly to cut dress groom style and shave men.
                                </p>
                                <span class="price">$8</span>
                            </li>
                            <li>
                                <h4>Hair Styling</h4>
                                <p>Barber is a person whose occupation is mainly to cut dress groom style and shave men.
                                </p>
                                <span class="price">$9</span>
                            </li>
                            <li>
                                <h4>Hair Triming</h4>
                                <p>Barber is a person whose occupation is mainly to cut dress groom style and shave men.
                                </p>
                                <span class="price">$10</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sm-padding">
                    <div class="price_wrap">
                        <h3>Shaving</h3>
                        <ul class="price_list">
                            <li>
                                <h4>Clean Shaving</h4>
                                <p>Barber is a person whose occupation is mainly to cut dress groom style and shave men.
                                </p>
                                <span class="price">$8</span>
                            </li>
                            <li>
                                <h4>Beard Triming</h4>
                                <p>Barber is a person whose occupation is mainly to cut dress groom style and shave men.
                                </p>
                                <span class="price">$9</span>
                            </li>
                            <li>
                                <h4>Smooth Shave</h4>
                                <p>Barber is a person whose occupation is mainly to cut dress groom style and shave men.
                                </p>
                                <span class="price">$10</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 sm-padding">
                    <div class="price_wrap">
                        <h3>Face Masking</h3>
                        <ul class="price_list">
                            <li>
                                <h4>White Facial</h4>
                                <p>Barber is a person whose occupation is mainly to cut dress groom style and shave men.
                                </p>
                                <span class="price">$8</span>
                            </li>
                            <li>
                                <h4>Face Cleaning</h4>
                                <p>Barber is a person whose occupation is mainly to cut dress groom style and shave men.
                                </p>
                                <span class="price">$9</span>
                            </li>
                            <li>
                                <h4>Bright Tuning</h4>
                                <p>Barber is a person whose occupation is mainly to cut dress groom style and shave men.
                                </p>
                                <span class="price">$10</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /. pricing_section -->

    <section class="blog-section bd-bottom padding">
        <div class="container">
            <div class="section-heading text-center mb-40 wow fadeInUp" data-wow-delay="300ms">
                <h3>From Blog</h3>
                <h2>A Good Newspaper Is A <br> Nation Talking To Itself</h2>
            </div><!--/.section-heading-->
            <div class="row blog-wrap">
                <div class="col-lg-4 col-md-6 sm-padding wow fadeInUp" data-wow-delay="200ms">
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/img/post-1.jpg" alt="post">
                            <span class="category"><a href="#">interior</a></span>
                        </div>
                        <div class="blog-content">
                            <h3><a href="#">Minimalist trending in modern architecture 2019</a></h3>
                            <p>Building first evolved out dynamics between needs means available building materials
                                attendant skills.</p>
                            <a href="#" class="read-more">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sm-padding wow fadeInUp" data-wow-delay="300ms">
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/img/post-2.jpg" alt="post">
                            <span class="category"><a href="#">Architecture</a></span>
                        </div>
                        <div class="blog-content">
                            <h3><a href="#">Terrace in the town yamazaki kentaro design workshop.</a></h3>
                            <p>Building first evolved out dynamics between needs means available building materials
                                attendant skills.</p>
                            <a href="#" class="read-more">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 sm-padding wow fadeInUp" data-wow-delay="400ms">
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/img/post-3.jpg" alt="post">
                            <span class="category"><a href="#">Design</a></span>
                        </div>
                        <div class="blog-content">
                            <h3><a href="#">W270 house são paulo arquitetos fabio jorge architeqture.</a></h3>
                            <p>Building first evolved out dynamics between needs means available building materials
                                attendant skills.</p>
                            <a href="#" class="read-more">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/.blog-section-->

    <section class="widget_section padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 sm-padding">
                    <div class="footer_widget">
                        <h6 style="font-size: 17px; color: white;">{LANG_PHONE} &amp; {LANG_EMAIL_ADDRESS}</h6>
                        <img class="mb-15" src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}" width="170px"
                        height="auto" alt="Brand">
                        <ul class="widget_social">
                            IF("{PHONE}"!=""){
                            <li><i class="fa fa-phone"></i><a style="margin-left: 10px;" href="tel:{PHONE}">{PHONE}</a>
                                <br>
                                {:IF}
                                IF("{EMAIL}"!=""){
                                <i class="fa fa-envelope"></i><a style="margin-left: 10px;"
                                    href="mailto:{EMAIL}">{EMAIL}</a>
                            </li>
                            {:IF}

                            IF("{SHOP_LINK_TWITTER}" != ""){
                            <li style="margin: 10px 0 0 0;"><a href="{SHOP_LINK_TWITTER}"><img
                                        src="{SITE_URL}shop-templates/nail/images/twitter.png" data-src="" alt=""
                                        class="lazy" style="width: 23px;height: 23px;    margin-right: 7px;">Twitter</a>
                            </li>
                            {:IF}

                            IF("{SHOP_LINK_FACEBOOK}" != ""){
                            <li style="margin: 10px 0 0px 0; display: block;"><a href="{SHOP_LINK_FACEBOOK}"><img
                                        src="{SITE_URL}shop-templates/nail/images/facebook_icon.svg" data-src="" alt=""
                                        class="lazy" style="width: 23px;height: 23px;  margin-right: 7px;">Facebook</a>
                            </li>
                            {:IF}
                            IF("{SHOP_LINK_INSTAGRAM}" != ""){
                            <li style="margin: 10px 0 0px 0;"><a href="{SHOP_LINK_INSTAGRAM}"><img
                                        src="{SITE_URL}shop-templates/nail/images/instagram_icon.svg" data-src="" alt=""
                                        class="lazy"
                                        style="width: 23px;height: 23px;    margin-right:7px;">Instagram</a></li>
                            {:IF}
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 sm-padding">
                    <div class="footer_widget">
                        <h3>{LANG_ADDRESS}</h3>
                        <p><i class="fa fa-map-marker"></i> <a target="_blank" href="https://maps.google.com/?q={ADDRESS}" style="margin-left: 7px; color: #999;">{ADDRESS}</a></p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 sm-padding">
                    <div class="footer_widget">
                        <h3>{LANG_OPEN_HOUR}</h3>
                        <ul class="opening_time">
                            <p>{LANG_MONDAY} <span>{OPEN_HOUR_2}</span></p>
                            <p>{LANG_TUESDAY} <span>{OPEN_HOUR_3}</span></p>
                            <p>{LANG_WEDNESDAY}<span>{OPEN_HOUR_4}</span></p>
                            <p>{LANG_THURSDAY} <span>{OPEN_HOUR_5}</span></p>
                            <p>{LANG_FRIDAY} <span>{OPEN_HOUR_6}</span></p>
                            <p>{LANG_SATURDAY} <span>{OPEN_HOUR_7}</span></p>
                            <p>{LANG_SUNDAY} <span>{OPEN_HOUR_1}</span></p>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 sm-padding">
                    <div class="footer_widget">
                        <a href="#" class="default_btn" style="float: right;">{LANG_BOOK_NOW}</a>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.widget_section -->

    <footer class="footer_section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 xs-padding">
                    <div class="copyright">&copy;
                        <script type="text/javascript"> document.write(new Date().getFullYear())</script>
                        {COPYRIGHT_TEXT}
                    </div>
                </div>
                <div class="col-md-6 xs-padding">
                    <ul class="footer_social">
                        <li><a class="right-ft-link" href="{LINK_AGB_RESTAURANTS}?id={SHOP_ID}">AGB</a></li>
                        <li><a class="right-ft-link"
                                href="{LINK_DATA_PROTECTION_RESTAURANTS}?id={SHOP_ID}">Datenschutzerklärung</a></li>
                        <li><a class="right-ft-link" href="{LINK_IMPRESSUM_RESTAURANTS}?id={SHOP_ID}">Impressum</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer><!-- /.footer_section -->

    <a data-scroll href="#header" id="scroll-to-top"><i class="arrow_up"></i></a>

    <!-- jQuery Lib -->
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/vendor/jquery-1.12.4.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/vendor/bootstrap.min.js"></script>
    <!-- Imagesloaded JS -->
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/vendor/imagesloaded.pkgd.min.js"></script>
    <!-- OWL-Carousel JS -->
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/vendor/owl.carousel.min.js"></script>
    <!-- isotope JS -->
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/vendor/jquery.isotope.v3.0.2.js"></script>
    <!-- Smooth Scroll JS -->
    <script src="js/vendor/smooth-scroll.min.js"></script>
    <!-- venobox JS -->
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/vendor/venobox.min.js"></script>
    <!-- ajaxchimp JS -->
    <script src="js/vendor/jquery.ajaxchimp.min.js"></script>
    <!--Slicknav-->
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/vendor/jquery.slicknav.min.js"></script>
    <!--Nice Select-->
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/vendor/jquery.nice-select.min.js"></script>
    <!-- YTPlayer JS -->
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/vendor/jquery.mb.YTPlayer.min.js"></script>
    <!-- Wow JS -->
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/vendor/wow.min.js"></script>
    <!-- Contact JS -->
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/contact.js"></script>
    <!-- Appointment JS -->
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/appointment.js"></script>
    <!-- Main JS -->
    <script src="{SITE_URL}shop-templates/{SHOP_TEMPLATE}/js/main.js"></script>

</body>

</html>