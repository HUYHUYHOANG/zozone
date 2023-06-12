{OVERALL_HEADER}
<style>
    .loading{height:100px;width:100%;background:#FFF url({SITE_URL}templates/{TPL_NAME}/images/loading.svg.php) no-repeat center center !important;}    
    a.change-lang-state.loading{width: 30px;
        cursor: default;
        height: 24px;
        display: block;
        background-size: cover !important;
        background-position-x: 2px !important;
    }
    a.change-lang-state.loading i{display: none;}
    .swal-text{text-align: center !important;line-height:26px !important;}
    #btnClose.loading{background-color: #F1F2F3 !important;cursor:default;}
    #btnClose.loading i{display: none;}
    
    .set-floating-btn-wrap{
        z-index:10;background:rgba(200,200,200,0.7);opacity:0.7;height:30px;position:absolute;bottom:0px;left:1px;display:block;width:100% !important;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }    
    .set-floating-btn-wrap:hover{
        background:var(--classic-color-1);opacity:1;
    }
    .set-floating-btn-wrap:hover a{
        color:#FFF;
    }
    .set-floating-btn-wrap.hidden{
        display:none;
    }
    a.btn-set-floating-banner{font-weight:normal !important;font-size: 16px;z-index:1;cursor: pointer;max-width:100% !important;}

    @media screen and (min-width: 1024px){
        .item-table{
            margin-left:30px;
        }
    }    

    .dialog.control-label{margin-top:5px;font-weight: bold;}
    .button.font-preview{                
        margin-top: 0 !important;
    }
    .text-right{text-align: right !important;}
    .preview-wrap{text-align: center;padding:10px;max-width: 100%;overflow-x: hidden;}
    .text-preview{margin:10px 0;white-space: nowrap;}
    .preview-wrap::-webkit-scrollbar{ width:10px;}
    .preview-wrap::-webkit-scrollbar-track {border-radius:4px;background: #f1f1f1; } 
    .preview-wrap::-webkit-scrollbar-thumb {border-radius:4px;background: rgb(0 0 0 / 12%); }
    .preview-wrap::-webkit-scrollbar-thumb:hover {  background: rgb(0 0 0 / 22%); }
    .input-error{
        border:1px solid #F00 !important;
    }
    #frm-font-settings .dropdown-menu{max-height:200px !important;overflow-y:scroll;}
</style>

<!-- Dashboard Container -->
<div class="dashboard-container">

    <!-- Dashboard Sidebar
    ================================================== -->
    <div class="dashboard-sidebar">
        <div class="dashboard-sidebar-inner" data-simplebar>
            <div class="dashboard-nav-container">

                <!-- Responsive Navigation Trigger -->
                <a href="#" class="dashboard-responsive-nav-trigger">
                    <span class="hamburger hamburger--collapse">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </span>
                    <span class="trigger-title">{LANG_DASH_NAVIGATION}</span>
                </a>

                <!-- Navigation --> {OVERALL_SIDEBAR} <!-- Navigation / End -->

            </div>
        </div>
    </div>
    <!-- Dashboard Sidebar / End -->


    <!-- Dashboard Content
    ================================================== -->
    <div class="dashboard-content-container" data-simplebar>
        <div class="dashboard-content-inner">

            <!-- Dashboard Headline -->
            <div class="dashboard-headline">
                <h3>{LANG_WEBSITE}</h3>
                
                <div class="menu-button">
                    <a href="{SHOP_LINK}"
                        class="button ripple-effect button-sliding-icon margin-left-auto live-preview-button">{LANG_LIVE_PREVIEW}<i
                            class="icon-feather-arrow-right"></i></a>
                </div>
            </div>

            <!-- Row -->
            <!-- <div style="display: block;" class="row"> -->
                <form name="restaurent_form" id="restaurant_form" method="post" action="#"
                    enctype="multipart/form-data">
                    <div class="col-xl-12 margin-bottom-5">{LANG_SHOP_INFO}</div>
                    <div class="col-xl-12 margin-bottom-15">
                        <div class="dashboard-box margin-top-0">
                            <div class="content with-padding padding-bottom-10">
                                <div class="row">
                                    <div class="col-xl-1">
                                        <!-- <img class="svg svg-store-nav"
                                            src="{SITE_URL}templates/{TPL_NAME}/images/svg/store.svg" /> -->
                                            <a class="edit_shop_button" href="{LINK_EDIT_SHOP_INFO}"><img
                                                class="svg svg-edit-shop"
                                                src="{SITE_URL}templates/{TPL_NAME}/images/svg/script_editor.svg" />
                                            </a>
                                    </div>
                                    <div class="col-xl-7">
                                        <ul class="list-left-right">
                                            <li class="Restaurant-Name">{NAME}</li>
                                            <li class="Restaurant-Welcome">{LANG_SHOP_SUBTITLE} <span>{SUB_TITLE}</span></li>
                                            <li class="list-left">{LANG_STREET_NAME_HOUSE_NUMBER}:<span>{STREET_NAME}
                                                    {HOUSE_NUMBER}</span></li>
                                            <li class="list-left">{LANG_POSTCODE_CITY}: <span>{ZIPCODE} {CITY}</span>
                                            </li>
                                            <li class="list-left">{LANG_SHOP_TAXCODE}: <span>{TAXCODE}</span></li>
                                            <li class="list-left">{LANG_SHOP_PHONE_NUMBER}:
                                                <span>{PHONE_NUMBER}</span></li>
                                            <li class="list-left">{LANG_TWITTER}: <span>{SHOP_LINK_TWITTER}</span>
                                            </li>
                                            <li class="list-left">{LANG_FACEBOOK}:
                                                <span>{SHOP_LINK_FACEBOOK}</span></li>
                                            <li class="list-left">{LANG_INSTAGRAM}:
                                                <span>{SHOP_LINK_INSTAGRAM}</span></li>
                                        </ul>
                                    </div>
                                    <div style="position: relative;" class="col-xl-4">
                                        <a href="{LINK_DATA_PROTECTION_KUNDEN}"
                                            class="margin-left-auto">{LANG_TERMS_AND_CONDITIONS_DATA_PROTECTION}</a>
                                        <div>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 
                    <div class="col-xl-12 margin-top-30 margin-bottom-5">{LANG_DESIGN}</div>
                 
                    <div class="col-xl-12 margin-bottom-5">
                        <div class="dashboard-box row margin-0-auto" style="display:flex ;">
                            <div class="col-xl-2 col-md-2 col-sm-6 col-12 dashboard-box-left">
                                <div class="align-items-center margin-bottom-15">
                                    <div class="margin-top-15">                                     
                                        <div class="color_wrapper">
                                            <div class="wrapper-left">
                                                <div class="qr-bg-color-wrapper qr-color-wrapper">
                                                    <button class="bm-color-picker"> </button>  
                                                    <input type="hidden" class="color-input" name="shop_theme_color"
                                                        value="{SHOP_THEME_COLOR}">       
                                                </div>
                                            </div>
                                            <div class="wrapper-right"> <div>
                                                <h5 class="margin-bottom-0">{LANG_THEME_COLOR}</h5>
                                            </div></div>
                                        </div>
                                    </div>        
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-2 col-sm-6 col-12 dashboard-box-right align-items-center">
                                <div class="align-items-center margin-bottom-15">
                                    <div class="margin-top-15"> 
                                    <div class="color_wrapper">
                                        <div class="wrapper-left">
                                            <div class="qr-fg-color-wrapper qr-color-wrapper">
                                                <button class="bm-color-picker"></button>
                                                <input type="hidden" class="color-input" name="shop_fore_color"
                                                    value="{SHOP_FORE_COLOR}">
                                            </div>
                                        </div>
                                        <div class="wrapper-right"> <div>
                                            <h5 class="margin-bottom-0">{LANG_FORGROUND_COLOR}</h5>
                                        </div></div>
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>

                            <!--FONT SETTINGS-->
                            <div class="col-xl-3 col-md-3 col-sm-6 col-12 dashboard-box-right">
                                <div class="margin-bottom-15">
                                    <div class="margin-top-15">                                     
                                        <div class="color_wrapper" style="cursor:pointer;" onclick="$.fontSettingsDialog()">
                                            <div class="wrapper-left">
                                                <div class="">
                                                    <span class=""><i class="fa fa-font"></i></span>
                                                </div>
                                            </div>
                                            <div class="wrapper-right">
                                                <div>
                                                    <h5 class="margin-bottom-0" style="text-align:left;">{LANG_CUSTOMIZE_FONT}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>        
                                </div>
                            </div>
                            <!--END FONT SETTINGS-->
                            <!--LANGUAGE SETTINGS-->
                            <div class="col-xl-3 col-md-3 col-sm-6 col-12 dashboard-box-right">
                                <div class="margin-bottom-15">
                                    <div class="margin-top-15">                                     
                                        <div class="color_wrapper" style="cursor:pointer;" onclick="$.languageSettingsDialog()">
                                            <div class="wrapper-left">
                                                <div class="">
                                                    <span class=""><i class="fa fa-language"></i></span>
                                                </div>
                                            </div>
                                            <div class="wrapper-right">
                                                <div>
                                                    <h5 class="margin-bottom-0" style="text-align:left;">{LANG_LANGUAGE}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>        
                                </div>
                            </div>
                            <!--END LANGUAGE SETTINGS-->
                              <!--MENU ICON SETTINGS-->
                              <div class="col-xl-2 col-md-2 col-sm-6 col-12 dashboard-box-right">
                                <div class="margin-bottom-15">
                                    <div class="margin-top-15">
                                        <div class="color_wrapper" style="cursor:pointer;" onclick="$.menuIconSettingsDialog()">
                                            <div class="wrapper-left">
                                                <div class="">
                                                    <span class=""><i class="fa fa-th-list"></i></span>
                                                </div>
                                            </div>
                                            <div class="wrapper-right">
                                                <div>
                                                    <h5 class="margin-bottom-0" style="text-align:left;">{LANG_MENU_ICON_SETTINGS}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--END MENU ICON SETTINGS-->
                        </div>
                    </div>
                           
                    <div class="col-xl-12 js-accordion">
                        <div class="dashboard-box margin-top-0 margin-bottom-15 js-accordion-item">
                          
                            <div class="headline js-accordion-header">
                                {LANG_SHOP_TEMPLATE}
                                <div class="js-accordion-header-image">
                                    <img class="svg svg-dashboard-nav"
                                        src="{SITE_URL}templates/{TPL_NAME}/images/svg/hand_point.svg" />
                                </div>

                            </div>
                            <div class="content with-padding padding-bottom-10 js-accordion-body" style="display: none">
                                <div class="submit-field">
                                    <div class="account-type row template-chooser">
                                        {LOOP: SHOP_TEMPLATES}
                                        <div class="col-md-3 margin-right-0">
                                            <input type="radio" name="shop_template"
                                                value="{SHOP_TEMPLATES.folder}" id="{SHOP_TEMPLATES.folder}"
                                                class="account-type-radio"
                                                IF("{SHOP_TEMPLATE}"=="{SHOP_TEMPLATES.folder}" ){ checked
                                                {:IF}>
                                            <label for="{SHOP_TEMPLATES.folder}" class="ripple-effect-dark">
                                                <img class="margin-bottom-5"
                                                    src="{SITE_URL}/shop-templates/{SHOP_TEMPLATES.folder}/screenshot.png">
                                                <strong>{SHOP_TEMPLATES.name} </strong>
                                                <!-- IF("flipbook-2" == "{RESTAURANT_TEMPLATES.folder}"){ <i class="icon-feather-image" data-tippy-placement="top" title="{LANG_TEMPLATE_IMAGES_ONLY}"></i>{:IF} -->
                                            </label>
                                        </div>
                                        {/LOOP: SHOP_TEMPLATES}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                
                        <div class="col-xl-12 margin-top-30 margin-bottom-5">{LANG_WEBSITE}</div>
                        <div style="z-index: 1;" class="col-xl-5 margin-bottom-5">
                            <div style="position: relative;" class="dashboard-box row margin-0-auto readImageURLParent">

                               <p style="position:absolute;top: 0px;right: 5px;">{LANG_SIZE_50_50}</p>
                                <div class="dashboard-box-wrapper-left">
                                 <p style="text-align: left;" class="margin-top-25 margin-left-30">{LANG_LOGO}</p>
                                </div>
                                <div class="dashboard-box-wrapper-center">          
                                       
                                        <div class="input-file-logo">
                                            <img src="{SITE_URL}storage/shop/logo/{MAIN_IMAGE}" id="logo_image">
                                        </div>
                                </div>

                                <div class="dashboard-box-wrapper-right"> 
                                    <div class="uploadButton margin-top-30">
                                        <input class="uploadButton-input" type="file" accept="image/*"  onchange="readImageURLandSave(this,'logo_image')" id="image_upload" name="main_image"/>
                                        <label class="uploadButton-button ripple-effect" for="image_upload">{LANG_UPLOAD}</label>
                                    </div>
                                    </div>

                                </div>
                            </div>

                            <div  class="col-xl-12 row margin-top-30 margin-bottom-5">
                            
                                    <div class="col-xl-6 readImageURLParent">
                                        <div class="submit-field">
                                            <h5>{LANG_SHOP_SPECIAL_OFFER_IMAGE}</h5>
                                            <div class="input-file">
                                                <img src="{SITE_URL}storage/shop/background/{SHOP_BACKGROUND_IMAGE}" id="shop_background_image">
                                            </div>
                                            <div class="uploadButton margin-top-30">
                                                <input class="uploadButton-input" type="file" accept="image/*" onchange="readImageURLandSave(this,'shop_background_image')" id="background_upload" name="shop_background_image"/>
                                                <label class="uploadButton-button ripple-effect" for="background_upload">{LANG_UPLOAD}</label>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="col-xl-6 readImageURLParent">
                                        <div class="submit-field">
                                            <h5>{LANG_SHOP_INTRO_IMAGE}</h5>
                                            <div class="input-file">
                                                <img src="{SITE_URL}storage/shop/outstanding_service/{SHOP_OUTSTANDING_SERVICE_IMAGE}" id="shop_outstanding_service_image">
                                            </div>
                                            <div class="uploadButton margin-top-30">
                                                <input class="uploadButton-input" type="file" accept="image/*" onchange="readImageURLandSave(this,'shop_outstanding_service_image')" id="outstanding_service_upload" name="shop_outstanding_service_image"/>
                                                <label class="uploadButton-button ripple-effect" for="outstanding_service_upload">{LANG_UPLOAD}</label>
                                            </div>
                                        </div>
                                    </div>            
                            </div>

                            <div class="col-xl-12 js-accordion ">
                                <div class="dashboard-box margin-top-0 margin-bottom-15 js-accordion-item">
                                    <!-- Headline -->
                                    <div class="headline js-accordion-header accordion-banner">
                                        Banners
                                        <!--{LANG_BANNER_ON_OFF}-->
                                        <div class="js-accordion-header-image">
                                            <img class="svg svg-dashboard-nav"
                                                src="{SITE_URL}templates/{TPL_NAME}/images/svg/hand_point.svg" />
                                        </div>                                        
                                    </div>
                                    <div class="content with-padding padding-bottom-10 js-accordion-body" style="display: none">                                        
                                        <!--<div class="dashboard-box margin-top-0">                                  
                                            <div class="col-xl-12 switch-container">
                                                <label class="switch">
                                                    <input name="shop_open_banner" id="shop_open_banner" value="1"
                                                        type="checkbox" IF("{SHOP_OPEN_BANNER}"=="1" ){ checked {:IF}>
                                                    <span class="switch-button-right"></span> {LANG_BANNER_ON_OFF}
                                                </label>
                                            </div>
                                        </div>-->
                                        <div class="col-xl-12 margin-top-20">
                                          <h4>{LANG_THE_BANNER_PHOTO_OF_THE_SHOP}</h4>
                                        </div>
                                                                                      
                                        <div class="row">
                                            <div class="col-xl-8 margin-top-5">
                                           
                                                <div class="item-table">
                                                    <ul id="content-slider-banner" class="content-slider">
            
                                                    </ul>           
                                                </div> 

                                                </div>
                                        <div class="col-md-4" style="margin:auto;text-align: right;">
                                            <input class="uploadButton-input" type="file" accept="image/*" onchange="readImageURLSlide(this,'banner')" id="add_banner_slide" name="restaurant_background_image"/>
                                            <label for="add_banner_slide" href="#"
                                            class="uploadButton-button button circle-button ripple-effect add-banner"><i
                                                class="icon-feather-plus circle-button-icon"></i></label>  
                                           
                                       
                                            </div>

                                            <div class="col-xl-12">
                                                <button data-timer="{TIMER_COVER_IMAGE}" type="button" name="timer_cover_image" id="timer_cover_image"
                                                    class="button ripple-effect margin-top-30 timer-button"><i class="icon-timer"></i> <span>{TIMER_COVER_IMAGE}</span></button>
                                            </div>
                                            <div class="col-xl-12">
                                            <p>{LANG_TIME_TO_CHANGE_THE_IMAGE}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-12 js-accordion ">
                                <div class="dashboard-box margin-top-0 margin-bottom-15 js-accordion-item">
                                    <!-- Headline -->
                                    <div class="headline js-accordion-header">
                                        {LANG_STORY}
                                        <div class="js-accordion-header-image">
                                            <img class="svg svg-dashboard-nav"
                                                src="{SITE_URL}templates/{TPL_NAME}/images/svg/hand_point.svg" />
                                        </div>
                                        
                                    </div>
                                    <div class="content with-padding padding-bottom-10 js-accordion-body" style="display: none">
                                        <div class="dashboard-box margin-top-0">                                  
                                                <div class="col-xl-12 switch-container">
                                                    <label class="switch">
                                                        <input name="shop_open_story" id="shop_open_story" value="{SHOP_OPEN_STORY}"
                                                            type="checkbox" IF("{SHOP_OPEN_STORY}"=="1" ){ checked {:IF}>
                                                        <span class="switch-button-right"></span> {LANG_STORY_ON_OFF}
                                                    </label>
                                                </div>                                          
                                        </div>
                                      
                                            <div class="form-group margin-top-15">
                                                <label class="col-form-label">{LANG_TITLE_STORY}</label>        
                                                    <input class="with-border" type="text" value="{SHOP_TITLE_STORY}" name="shop_title_story" id="shop_title_story">
                                            </div> 
                                            <div class="form-group">
                                                <label  class="col-form-label">{LANG_SUB_TITLE_STORY}</label>        
                                                    <input class="with-border" type="text" value="{SHOP_SUB_TITLE_STORY}" name="shop_sub_title_story" id="shop_sub_title_story">
                                            </div> 
                                            <div class="form-group">
                                                <label class="col-form-label">{LANG_STORY}</label>        
                                                    <textarea class="with-border" rows="4"  name="shop_story" id="shop_story">{SHOP_STORY}</textarea>
                                            </div>                                                                    
                                    </div>
                                </div>
                            </div>
                            <!--special offers on/off-->
                            <div class="col-xl-12 margin-top-30 margin-bottom-5">{LANG_SHOP_SPECIAL_OFFER}</div>
                            <div class="col-xl-12 margin-top-5">
                                <div class="dashboard-box margin-top-0">
                                    <div class="col-xl-12 switch-container">
                                        <label class="switch">
                                            <input name="shop_display_special_offer" id="shop_display_special_offer" value="1" type="checkbox"
                                                IF("{SHOP_SPECIAL_OFFER_DISPLAY}"=="1" ){ checked {:IF}>
                                            <span class="switch-button-right"></span> {LANG_ON_OFF_SPECIAL_OFFER}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!--our staffs on/off-->
                            <div class="col-xl-12 margin-top-30 margin-bottom-5">{LANG_OUR_STAFFS}</div>
                            <div class="col-xl-12 margin-top-5">
                                <div class="dashboard-box margin-top-0">
                                    <div class="col-xl-12 switch-container">
                                        <label class="switch">
                                            <input name="shop_display_our_staffs" id="shop_display_our_staffs" value="1" type="checkbox"
                                                IF("{SHOP_OUR_STAFFS_DISPLAY}"=="1" ){ checked {:IF}>
                                            <span class="switch-button-right"></span> {LANG_ON_OFF_OUR_STAFFS}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!--portfolio on/off-->
                            <div class="col-xl-12 margin-top-30 margin-bottom-5">{LANG_GROUP_IMAGE}</div>
                            <div class="col-xl-12 margin-top-5">
                                <div class="dashboard-box margin-top-0">
                                    <div class="col-xl-12 switch-container">
                                        <label class="switch">
                                            <input name="shop_display_group_image" id="shop_display_group_image" value="1" type="checkbox"
                                                IF("{SHOP_DISPLAY_GROUP_IMAGE}"=="1" ){ checked {:IF}>
                                            <span class="switch-button-right"></span> {LANG_ON_OFF_GROUP_IMAGE}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 text-align-right margin-bottom-15 margin-top-15">
                                <button  type="button" name="add_group_image" id="add_group_image"
                                    class="button ripple-effect">{LANG_ADD_GROUP_IMAGE}</button>
                            </div>
                            <div class="shop_group_image_component">
                                {LOOP: SHOP_GROUP_IMAGE}
                                <div class="col-xl-12 js-accordion ">
                                    <div class="dashboard-box margin-top-0 margin-bottom-15 js-accordion-item">
                                        <!-- Headline -->
                                        <div data-id="{SHOP_GROUP_IMAGE.id}" class="headline js-accordion-header accordion-group-image">
                                            {SHOP_GROUP_IMAGE.name}
    
                                            <div class="margin-left-auto">
                                                <a href="#" data-name="{SHOP_GROUP_IMAGE.name}" data-id="{SHOP_GROUP_IMAGE.id}" class="button ripple-effect btn-sm edit-group-image-name"
                                                    title="{LANG_EDIT_GROUP_NAME}" data-tippy-placement="top"><i
                                                        class="icon-feather-edit"></i></a>
                                                <a href="#" data-id="{SHOP_GROUP_IMAGE.id}"
                                                    class="popup-with-zoom-anim button red ripple-effect btn-sm delete-group-image"
                                                    title="{LANG_DELETE_GROUP_IMAGE}" data-tippy-placement="top"><i
                                                        class="icon-feather-trash-2"></i></a>
                                            </div>                             
                                        </div>
                                        <div class="content with-padding padding-bottom-10 js-accordion-body" style="display: none">
                                            <div class="dashboard-box margin-top-0">                                  
                                                    <div class="col-xl-12 switch-container">
                                                        <label class="switch">
                                                            <input  value="1" data-id="{SHOP_GROUP_IMAGE.id}" class="shop_group_image_active"
                                                                type="checkbox" IF("{SHOP_GROUP_IMAGE.active}"=="1" ){ checked {:IF}>
                                                            <span class="switch-button-right"></span> {LANG_GROUP_IMAGE_ON_OFF}
                                                        </label>
                                                    </div>                                          
                                            </div>
    
                                            <div class="col-xl-12 margin-top-20">
                                                <h4>{LANG_THE_GROUP_PHOTO}</h4>
                                              </div>
    
                                            <div class="row">
                                                <div class="col-xl-8 margin-top-5">
                                               
                                                    <div class="item-table">
                                                        <ul id="content_group_image_{SHOP_GROUP_IMAGE.id}" class="content-group-image">
                
                                                        </ul>           
                                                    </div> 
                                                    </div>
                                            <div class="col-md-4" style="margin:auto;text-align: right;">
                                                <input class="uploadButton-input" type="file" accept="image/*" onchange="AddImageInGroup(this,'{SHOP_GROUP_IMAGE.id}')" id="add_group_image_{SHOP_GROUP_IMAGE.id}" />
                                                <label for="add_group_image_{SHOP_GROUP_IMAGE.id}" href="#"
                                                class="uploadButton-button button circle-button ripple-effect add-group-image-{SHOP_GROUP_IMAGE.id}"><i
                                                    class="icon-feather-plus circle-button-icon"></i></label>                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {/LOOP: SHOP_GROUP_IMAGE}
                            </div>

                            <div class="col-xl-12 margin-top-30 margin-bottom-5">{LANG_FOOTER_IMAGE}</div>

                            <div class="col-xl-12 js-accordion ">
                                <div class="dashboard-box margin-top-0 margin-bottom-15 js-accordion-item">
                                    <!-- Headline -->
                                    <div class="headline js-accordion-header accordion-footer-image">
                                        {LANG_FOOTER_IMAGE}
                                        <div class="js-accordion-header-image">
                                            <img class="svg svg-dashboard-nav"
                                                src="{SITE_URL}templates/{TPL_NAME}/images/svg/hand_point.svg" />
                                        </div>       
                                    </div>
                                    <div class="content with-padding padding-bottom-10 js-accordion-body" style="display: none">
                                        <div class="dashboard-box margin-top-0">                                  
                                                <div class="col-xl-12 switch-container">
                                                    <label class="switch">
                                                        <input name="shop_open_footer_image" id="shop_open_footer_image" value="1"
                                                            type="checkbox" IF("{SHOP_OPEN_FOOTER_IMAGE}"=="1" ){ checked {:IF}>
                                                        <span class="switch-button-right"></span> {LANG_FOOTER_IMAGE_ON_OFF}
                                                    </label>
                                                </div>                                          
                                        </div>
                                        <div class="col-xl-12 margin-top-20">
                                          <h4>{LANG_THE_FOOTER_PHOTO_OF_THE_SHOP}</h4>
                                        </div>
                                                                                      
                                        <div class="row">
                                            <div class="col-xl-8 margin-top-5">  
                                                <div class="item-table">
                                                    <ul id="content-slider-footer-image" class="content-slider">
                                                     
                                                    </ul>           
                                                </div> 

                                                </div>
                                        <div class="col-md-4" style="margin:auto;text-align: right;">
                                            <input class="uploadButton-input" type="file" accept="image/*" onchange="addFooterImage(this)" id="add_footer_slide_slide" name="add_footer_slide_slide" />
                                            <label for="add_footer_slide_slide" href="#"
                                            class="uploadButton-button button circle-button ripple-effect add-footer-image"><i
                                                class="icon-feather-plus circle-button-icon"></i></label>                                                         
                                        </div>

                                            <div class="col-xl-12">
                                                <button data-timer="{TIMER_FOOTER_IMAGE}" type="button" name="timer_footer_image" id="timer_footer_image"
                                                    class="button ripple-effect margin-top-30 timer-button"><i class="icon-timer"></i> <span>{TIMER_FOOTER_IMAGE}</span></button>
                                            </div>
                                            <div class="col-xl-12">
                                            <p>{LANG_TIME_TO_CHANGE_THE_IMAGE}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                           
                 
                 

                    <div class="col-xl-12 margin-bottom-5">{LANG_OPEN_CLOSE_HOUR_TITLE}</div>
                    <div class="col-xl-12">
                        <div class=" margin-top-0">                      
                            <div class="menu-button">
                                <a  href="#"
                                class="button ripple-effect button-sliding-icon margin-left-auto add-open-hour"
                             >{LANG_ADD_OPEN_HOUR}<i
                                    class="icon-feather-plus"></i></a>
                            </div>
                          
                            <div class="content with-padding padding-bottom-10">
                                <div class="row">
                             
                                    <div class=" main-box-in-row col-xl-12">
                                        <div class="content with-padding">
                                            <div class="dataTables_wrapper">
                                                <table class="basic-table dashboard-box-list"
                                                    id="qr-open-close-hours-table">
                                                    <thead>
                                                        <tr>
                                                            <th>{LANG_DAY_OF_WEEK}</th>
                                                            <th>{LANG_OPEN_HOUR}</th>
                                                            <th>{LANG_CLOSE_HOUR}</th>
                                                            <th>{LANG_OPEN_HOUR_2}</th>
                                                            <th>{LANG_CLOSE_HOUR_2}</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="qr-body-table-open-close-house">
                                                        {LOOP: OPEN_CLOSE_HOUR}
                                                        <tr>
                                                            <td class="day_of_week" data-label="{LANG_DAY_OF_WEEK}">
                                                                {OPEN_CLOSE_HOUR.day_of_week} &nbsp;
                                                            </td>
                                                            <td class="open_hour" data-label="{LANG_OPEN_HOUR}">
                                                                {OPEN_CLOSE_HOUR.open_hour} &nbsp;</td>
                                                            <td class="close_hour" data-label="{LANG_CLOSE_HOUR}">
                                                                {OPEN_CLOSE_HOUR.close_hour} &nbsp;</td>

                                                            <td class="open_hour_2" data-label="{LANG_OPEN_HOUR_2}">
                                                                {OPEN_CLOSE_HOUR.open_hour_2} &nbsp;</td>
                                                            <td class="close_hour_2" data-label="{LANG_CLOSE_HOUR_2}">
                                                                {OPEN_CLOSE_HOUR.close_hour_2} &nbsp;</td>
                                                            <td>
                                                                <a href="#"
                                                                    data-dayofweek="{OPEN_CLOSE_HOUR.day_of_week_value}"
                                                                    data-dayofweek2="{OPEN_CLOSE_HOUR.day_of_week_to_value}"
                                                                    data-isfromto="{OPEN_CLOSE_HOUR.is_from_to}"
                                                                    data-openid="{OPEN_CLOSE_HOUR.id}"
                                                                    class=" button ripple-effect btn-sm edit_open_time"
                                                                    title="{LANG_OPEN_HOUR_EDIT}"
                                                                    data-tippy-placement="top"><i
                                                                        class="icon-feather-edit-3"></i></a>

                                                                <a href="#" data-openid="{OPEN_CLOSE_HOUR.id}"
                                                                    class="button red ripple-effect btn-sm delete-open-hour"
                                                                    title="{LANG_DELETE_OPEN_HOUR}"
                                                                    data-tippy-placement="top"><i
                                                                        class="icon-feather-trash-2"></i></a>
                                                            </td>
                                                        </tr>
                                                        {/LOOP: OPEN_CLOSE_HOUR}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                            
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-12 margin-top-20">{LANG_ORDER_SERVICE}</div>
                    <div class="col-xl-12 margin-top-5">
                        <div class="dashboard-box margin-top-0">
                            <div class="col-xl-12 switch-container">
                                <label class="switch">
                                    <input name="shop_order_service" id="shop_order_service" value="1" type="checkbox"
                                        IF("{SHOP_ORDER_SERVICE}"=="1" ){ checked {:IF}>
                                    <span class="switch-button-right"></span> {LANG_ON_OFF_ORDER_SERVICE}
                                </label>
                            </div>
                        </div>
                    </div>


               
                    <div class="col-xl-12 margin-top-5">
                        <div class="dashboard-box margin-top-0">
                            <div class="col-xl-12 switch-container">
                                <label class="switch">
                                    <input name="shop_display_price" id="shop_display_price" value="1" type="checkbox"
                                        IF("{SHOP_DISPLAY_PRICE}"=="1" ){ checked {:IF}>
                                    <span class="switch-button-right"></span> {LANG_ON_OFF_DISPLAY_PRICE}
                                </label>
                            </div>
                        </div>
                    </div>

                    <!--
                    <div class="col-xl-12 margin-top-30">{LANG_CONTACT}</div>
                    <div class="col-xl-12 margin-top-5">
                        <div class="dashboard-box margin-top-0">
                            <div class="col-xl-12 switch-container">
                                <label class="switch">
                                    <input name="shop_open_contact" id="shop_open_contact" value="1" type="checkbox"
                                        IF("{SHOP_OPEN_CONTACT}"=="1" ){ checked {:IF}>
                                    <span class="switch-button-right"></span> {LANG_ON_OFF_CONTACT}
                                </label>
                            </div>
                        </div>
                    </div>
                    !-->

                    <div class="col-xl-12 margin-bottom-5">{LANG_MESSAGES_POPUP}</div>
                    <div class="col-xl-12 margin-bottom-5">
                        <div class="dashboard-box margin-top-0">
                            <table style="width:100%;">
                                <tr>
                                <td style="padding-top: 16px;padding-left: 10px;width: 200px;"><input type="text" class="with-border" id="shop_second_popup" name="shop_second_popup" value="{SHOP_SECOND_POPUP}"> </td>
                               <td style="padding-left: 5px;">{LANG_SECONDS}</td>
                                <td>
                                    <div class="col-xl-12 switch-container">                                  
                                        <label class="switch">
                                            <input name="shop_popup_messages_on_off" id="shop_popup_messages_on_off" value="1"
                                                type="checkbox" IF("{SHOP_POPUP_MESSAGES_ON_OFF}"=="1" ){ checked {:IF}>
                                            <span style="top:0" class="switch-button-right"></span>
                                        </label>
                                    </div>
                                </td>
                            </tr></table>
                           
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="submit-field">
                            <textarea class="form-control with-border" id="shop_popup_messages" name="shop_popup_messages"
                            placeholder="{LANG_MESSAGES_POPUP}" rows="4">{SHOP_POPUP_MESSAGES}</textarea>
                        </div>
                        <div id="shop-check-status" class="notification error" style="display:none"></div>
                    </div>
                    <div class="col-xl-12">
                        <button type="submit" name="submit"
                            class="button ripple-effect margin-top-30">{LANG_SAVE}</button>
                    </div>
                </form>
            </div>
            <!-- Row / End -->

            <!-- Footer -->
            <div class="dashboard-footer-spacer"></div>
            <div class="small-footer margin-top-15">
                <div class="small-footer-copyrights">
                    {COPYRIGHT_TEXT}
                </div>
                <ul class="footer-social-links">
                    IF('{FACEBOOK_LINK}'!=""){
                    <li>
                        <a href="{FACEBOOK_LINK}" target="_blank" rel="nofollow">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                    {:IF}
                    IF('{TWITTER_LINK}'!=""){
                    <li>
                        <a href="{TWITTER_LINK}" target="_blank" rel="nofollow">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </li>
                    {:IF}
                    IF('{INSTAGRAM_LINK}'!=""){
                    <li>
                        <a href="{INSTAGRAM_LINK}" target="_blank" rel="nofollow">
                            <i class="fa fa-instagram"></i>
                        </a>
                    </li>
                    {:IF}
                    IF('{LINKEDIN_LINK}'!=""){
                    <li>
                        <a href="{LINKEDIN_LINK}" target="_blank" rel="nofollow">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </li>
                    {:IF}
                    IF('{PINTEREST_LINK}'!=""){
                    <li>
                        <a href="{PINTEREST_LINK}" target="_blank" rel="nofollow">
                            <i class="fa fa-pinterest-p"></i>
                        </a>
                    </li>
                    {:IF}
                    IF('{YOUTUBE_LINK}'!=""){
                    <li>
                        <a href="{YOUTUBE_LINK}" target="_blank" rel="nofollow">
                            <i class="fa fa-youtube-play"></i>
                        </a>
                    </li>
                    {:IF}
                </ul>
                <div class="clearfix"></div>
            </div>
            <!-- Footer / End -->

        </div>
    </div>
    <!-- Dashboard Content / End -->

</div>
<!-- Dashboard Container / End -->

</div>
<!-- Wrapper / End -->

<!-- Edit Open Time Popup / End -->
<div id="open-hour-popup" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="sign-in-form">
        <ul class="popup-tabs-nav">
            <li><a>{LANG_OPEN_HOUR_EDIT}</a></li>
        </ul>
        <div class="popup-tabs-container">
            <!-- Tab -->
            <div class="popup-tab-content">
                <div id="open-hour-status" class="notification error" style="display:none"></div>
                <div class="submit-field">
                    <h2 style="text-align: center;color:red;margin-bottom: 10px" id="day_of_week_text"></h2>
                    <div class="form-group row" style="margin-bottom: 10px;">
                        <label id="label_lang_from" class="col-sm-4 control-label">{LANG_FROM}</label>
                        <div class="col-sm-6">
                            <select name="day_of_week_from" id="day_of_week_from" class="orm-control">
                                <option value="sunday"> {LANG_SUNDAY} </option>
                                <option value="monday">{LANG_MONDAY}</option>
                                <option value="tuesday"> {LANG_TUESDAY} </option>
                                <option value="wednesday">{LANG_WEDNESDAY}</option>
                                <option value="thursday"> {LANG_THURSDAY} </option>
                                <option value="friday">{LANG_FRIDAY}</option>
                                <option value="saturday">{LANG_SATURDAY}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row " id="div_day_of_week_to" style="margin-bottom: 10px;">
                        <label class="col-sm-4 control-label">{LANG_TO}</label>
                        <div class="col-sm-6">
                            <select name="day_of_week_to" id="day_of_week_to" class="orm-control">
                                <option value="sunday"> {LANG_SUNDAY} </option>
                                <option value="monday">{LANG_MONDAY}</option>
                                <option value="tuesday"> {LANG_TUESDAY} </option>
                                <option value="wednesday">{LANG_WEDNESDAY}</option>
                                <option value="thursday"> {LANG_THURSDAY} </option>
                                <option value="friday">{LANG_FRIDAY}</option>
                                <option value="saturday">{LANG_SATURDAY}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-time-input" class="col-4 col-form-label">{LANG_OPEN_TIME}</label>
                        <div class="col-6">
                            <input class="form-control not-padding-top" type="time" value="" id="open_time_value">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-time-input" class="col-4 col-form-label">{LANG_CLOSE_TIME}</label>
                        <div class="col-6">
                            <input class="form-control not-padding-top" type="time" value="" id="close_time_value">
                        </div>
                    </div>
                    <div class="form-check">
                        <label class="radio-inline"><input style="margin-top:0px;" type="checkbox" value="1"
                                name="open_close_hour_2" id="open_close_hour_2" />{LANG_OPEN_CLOSE_2}</label>
                    </div>

                    <div class="form-group row">
                        <label for="example-time-input" class="col-4 col-form-label">{LANG_OPEN_TIME}</label>
                        <div class="col-6">
                            <input class="form-control not-padding-top" type="time" value="" id="open_time_value_2" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-time-input" class="col-4 col-form-label">{LANG_CLOSE_TIME}</label>
                        <div class="col-6">
                            <input class="form-control not-padding-top" type="time" value="" id="close_time_value_2" disabled>
                        </div>
                    </div>
                    <input type="hidden" name="open_hour_id" id="open_hour_id" value="">
                </div>

                <!-- Button -->
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="submit"
                    id="save-open-time">{LANG_SAVE} <i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
        </div>
    </div>
</div>

<div id="timer-change-popup" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="sign-in-form">
        <ul class="popup-tabs-nav">
            <li><a>{LANG_EDIT_TIME}</a></li>
        </ul>
        <div class="popup-tabs-container">
            <!-- Tab -->
            <div class="popup-tab-content">
                <div id="timer-change-status" class="notification error" style="display:none"></div>
           
                    <div class="form-group">
                        <label for="example-time-input" class="col-form-label">{LANG_TIMER_SECOND}</label>        
                            <input class="with-border" type="number" value="" id="input_timer">
                    </div>  
                    <input type="hidden" name="timer_for" id="timer_for" value="">
             
                <button class="button button-sliding-icon ripple-effect" type="button"
                    id="save-timer">{LANG_SAVE} <i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
        </div>
    </div>
</div>

<div id="group-image-popup" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="sign-in-form">
        <ul class="popup-tabs-nav">
            <li><a class="group-image-popup-title"></a></li>
        </ul>
        <div class="popup-tabs-container">
            <!-- Tab -->
            <div class="popup-tab-content">
                <div id="group-image-status" class="notification error" style="display:none"></div>  
                    <div class="form-group">
                        <label class="col-form-label">{LANG_NAME}</label>        
                            <input class="with-border" type="text" value="" id="group-image-name">
                    </div>  
                    <input type="hidden" name="group-image-id" id="group-image-id" value="">
                <button class="button button-sliding-icon ripple-effect" type="button"
                    id="save-group-image-name">{LANG_SAVE} <i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#header-container").addClass('dashboard-header not-sticky');
    });
</script>
<!-- Footer Code -->

<!--DIALOG TEMPLATE-->
<div id="dlgWrapper" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="log-item-form">
        <ul class="popup-tabs-nav">
            <li class="active"><a class="tab-title">{LANG_CUSTOMIZE_FONT}</a></li>
        </ul>
        <div class="popup-tabs-container"></div>
    </div>
</div>
<!--END DIALOG-->

<script>
    var session_uname = "{USERNAME}";
    var session_uid = "{USER_ID}";
    // Language Var
    var LANG_ERROR_TRY_AGAIN = "{LANG_ERROR_TRY_AGAIN}";
    var LANG_LOGGED_IN_SUCCESS = "{LANG_LOGGED_IN_SUCCESS}";
    var LANG_ERROR = "{LANG_ERROR}";
    var LANG_CANCEL = "{LANG_CANCEL}";
    var LANG_DELETED = "{LANG_DELETED}";
    var LANG_ARE_YOU_SURE = "{LANG_ARE_YOU_SURE}";
    var LANG_YES_DELETE = "{LANG_YES_DELETE}";
    var LANG_SHOW = "{LANG_SHOW}";
    var LANG_HIDE = "{LANG_HIDE}";
    var LANG_HIDDEN = "{LANG_HIDDEN}";
    var LANG_TYPE_A_MESSAGE = "{LANG_TYPE_A_MESSAGE}";
    var LANG_JUST_NOW = "{LANG_JUST_NOW}";
    var LANG_PREVIEW = "{LANG_PREVIEW}";
    var LANG_SEND = "{LANG_SEND}";
    var LANG_STATUS = "{LANG_STATUS}";
    var LANG_SIZE = "{LANG_SIZE}";
    var LANG_NO_MSG_FOUND = "{LANG_NO_MSG_FOUND}";
    var LANG_ONLINE = "{LANG_ONLINE}";
    var LANG_OFFLINE = "{LANG_OFFLINE}";
    var LANG_GOT_MESSAGE = "{LANG_GOT_MESSAGE}";
    var LANG_RESTAURANT_OPEN_TIME = "{LANG_RESTAURANT_OPEN_TIME}";
    var LANG_RESTAURANT_OPEN_TIME = "{LANG_RESTAURANT_CLOSE_TIME}";
    var LANG_PLEASE_ENTER_THE_CORRECT_TELEPHONE_NUMBER = "{LANG_PLEASE_ENTER_THE_CORRECT_TELEPHONE_NUMBER}";
    var LANG_ARE_YOU_SURE = "{LANG_ARE_YOU_SURE}";
    var LANG_UPLOAD_IMAGE = "{LANG_UPLOAD_IMAGE}";
    var LANG_DELETE = "{LANG_DELETE}";
    var LANG_ADD_GROUP_IMAGE = "{LANG_ADD_GROUP_IMAGE}";
    var LANG_EDIT_GROUP_IMAGE = "{LANG_EDIT_GROUP_IMAGE}";
</script>

<script type="text/javascript" src="{SITE_URL}templates/{TPL_NAME}/js/chosen.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/jquery.lazyload.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/tippy.all.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/simplebar.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/bootstrap-slider.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/bootstrap-select.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/snackbar.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/counterup.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/magnific-popup.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/slick.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/jquery.cookie.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/user-ajax.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/custom.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/color-picker.es5.min.js?ver={VERSION}"></script>
<!-- <script src="{SITE_URL}templates/{TPL_NAME}/js/script.js?ver={VERSION}"></script> -->
<script src="{SITE_URL}templates/{TPL_NAME}/js/svg.js?ver={VERSION}"></script>


<script>
        var setting_slick = {
            dots: false,
     rows: 1,
     infinite: true,
     slidesToShow: 2,
     slidesToScroll: 2,
     arrows: true ,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 2,
                        infinite: true,
                        dots: false,
                        rows: 1,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: false,
                        rows: 1,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: false,
                        rows: 1,
                    }
                }
            ]
        };
    var content_slider = '{CONTENT_SLIDER_BANNER}';    
    $("#content-slider-banner").html(content_slider);
    $("#content-slider-banner").slick(setting_slick);  
    $("#content-slider-footer-image").slick(setting_slick);  
   
$('.shop_group_image_component').find('.content-group-image').each(function () {
  $(this).slick(setting_slick);
});

// accordion-footer-image
// content-slider-footer-image
// footer_image


$(document).on('click', ".accordion-footer-image", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'getSliderFooterImage'
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $("#content-slider-footer-image").prop('disabled', false);
                        $("#content-slider-footer-image").slick('unslick');
                        $("#content-slider-footer-image").html(response.data);
                        $("#content-slider-footer-image").not('.slick-initialized').slick(setting_slick);
                    }
                }
            });

 
 });


 $(document).on('click', ".accordion-banner", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'getSliderBanner'
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $("#content-slider-banner").prop('disabled', false);
                        $("#content-slider-banner").slick('unslick');
                        $("#content-slider-banner").html(response.data);
                        $("#content-slider-banner").not('.slick-initialized').slick(setting_slick);
                    }
                }
            });

 
 });

 
 $(document).on('click', ".accordion-group-image", function (e) {
    e.preventDefault();
    e.stopPropagation();
    let id = $(this).data('id');
    $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'getGroupImageById',
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {

                        $("#content_group_image_" + id).prop('disabled', false);
                        $("#content_group_image_" + id).slick('unslick');
                        $("#content_group_image_" + id).html(response.data);
                        $("#content_group_image_" + id).not('.slick-initialized').slick(setting_slick);
                    }
                }
            });

 
 });


 



</script>

<script>
    initColorPicker('.qr-fg-color-wrapper');
    initColorPicker('.qr-bg-color-wrapper');
    function initColorPicker(container) {
        var $element = container + ' .bm-color-picker';
        var $input = jQuery($element).siblings('.color-input');
        var picker = Pickr.create({
            container: container,
            el: $element,
            theme: 'monolith',
            comparison: false,
            closeOnScroll: true,
            position: 'bottom-start',
            default: $input.val() || '#333333',
            components: {
                preview: false,
                opacity: false,
                hue: true,
                interaction: {
                    input: true
                }
            }
        });
        picker.on('change', function (color, instance) {
            $input.val(color.toHEXA().toString()).trigger('change');
        });
    }

    $(document).on('click', ".delete-open-hour", function (e) {
        e.preventDefault();
        e.stopPropagation();

        var id = $(this).data('openid'),
            $this = $(this);

        if (confirm(LANG_ARE_YOU_SURE)) {
            $this.addClass('button-progress').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'deleteOpenHour',
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    $this.removeClass('button-progress').prop('disabled', false);
                    if (response.success) {
                        $this.closest('tr').remove();
                    }
                    Snackbar.show({
                        text: response.message,
                        pos: 'bottom-center',
                        showAction: false,
                        actionText: "Dismiss",
                        duration: 3000,
                        textColor: '#fff',
                        backgroundColor: '#383838'
                    });
                }
            });
        }
    });
    

    $(document).on('click', ".delete-group-image", function (e) {
        e.preventDefault();
        e.stopPropagation();

        var id = $(this).data('id'),
            $this = $(this);

        if (confirm(LANG_ARE_YOU_SURE)) {
            $this.addClass('button-progress').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'deleteGroupImage',
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    $this.removeClass('button-progress').prop('disabled', false);
                    if (response.success) {
                        //$this.closest('tr').remove();
                        location.reload();
                    }
                    // Snackbar.show({
                    //     text: response.message,
                    //     pos: 'bottom-center',
                    //     showAction: false,
                    //     actionText: "Dismiss",
                    //     duration: 3000,
                    //     textColor: '#fff',
                    //     backgroundColor: '#383838'
                    // });
                }
            });
        }
    });
    
    $(document).on('click', ".edit-group-image-name", function (e) {
        e.preventDefault();
       $('.group-image-popup-title').html(LANG_EDIT_GROUP_IMAGE);
       $('#group-image-name').val($(this).data('name'));
       $('#group-image-id').val($(this).data('id'));
       $("#group-image-status").hide();
        $.magnificPopup.open({
            items: {
                src: '#group-image-popup',
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            }, callbacks : {
                open : function(){
                    setTimeout(function(){ $('#group-image-name').focus(); }, 100);
                }
            }
        });

    });
    
    $(document).on('click', "#add_group_image", function (e) {
        e.preventDefault();

       $('.group-image-popup-title').html(LANG_ADD_GROUP_IMAGE);
       $('#group-image-name').val('');
       $('#group-image-id').val('');
       $("#group-image-status").hide();
        $.magnificPopup.open({
            items: {
                src: '#group-image-popup',
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            }
        });

    });


    
    $("#save-group-image-name").on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var id = $("#group-image-id").val();
        var form_data = {
            action: 'addGroupImageName',
            group_name: $('#group-image-name').val()
        };
        if (id) {
            form_data['id'] = id;
            form_data['action'] = 'editGroupImageName';
        }
        $('#save-group-image-name').addClass('button-progress').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: form_data,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    location.reload();
                }
                else {
                    $("#group-image-status").removeClass('success').addClass('error').html('<p>' + response.message + '</p>').slideDown();
                }
                $('#save-group-image-name').removeClass('button-progress').prop('disabled', false);
            }
        });
        return false;
    });


    $(document).on('click', ".add-open-hour", function (e) {
        e.preventDefault();
        //$('input:radio[name="day_of_week_type"]').filter('[value="from_to"]').prop('checked', true);
        $("#div_day_of_week_to").addClass("hide");
        $("#label_lang_from").text('{LANG_DAY_OF_WEEK}');
        $("select[id=day_of_week_from]").val("monday").change();
        // $("select[id=day_of_week_to]").val("saturday").change(); 
        $('#open_time_value').val("07:00");
        $('#close_time_value').val("11:00");
        $('#open_time_value_2').attr('disabled', 'disabled');
        $('#close_time_value_2').attr('disabled', 'disabled');
        $('input:checkbox[name="open_close_hour_2"]').prop('checked', false);
        $('#open_time_value_2').val("");
        $('#close_time_value_2').val("");
        $('#open_hour_id').val("");
        $("#open-hour-status").hide();
        $.magnificPopup.open({
            items: {
                src: '#open-hour-popup',
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            }
        });
    });


    document.querySelector("#input_timer").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
});

    $(document).on('click',"#save-timer",function(e){
                let timer_for = $("#timer_for").val();
                let timer = $("#input_timer").val();


                if(timer.length == 0)
                {
                    $("#timer-change-status").removeClass('success').addClass('error').html('<p>'+LANG_ERROR_TRY_AGAIN+'</p>').slideDown();
                    return;
                }
             
                $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'changeTimerImage',
                    timer_for: timer_for,
                    timer:  timer
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {

                        if(timer_for == "timer_cover_image")
                        {
                          $("#timer_cover_image").find('span').html(timer);
                          $("#timer_cover_image").data('timer',timer)
                        }
                        else if(timer_for == "timer_footer_image")
                        {
                            $("#timer_footer_image").find('span').html(timer);
                          $("#timer_footer_image").data('timer',timer)
                        }
                        $.magnificPopup.close();
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#383838'
                        });
                    }
                 
                }
            });
    })

    $(document).on('click', "#timer_footer_image", function (e) {
        e.preventDefault();
        e.stopPropagation();
        let timer = $(this).data('timer');       
 		$("#timer_for").val('timer_footer_image')		
        $("#input_timer").val(timer);
        $("#timer-change-status").hide();
  $.magnificPopup.open({
            items: {
                src: '#timer-change-popup',
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            }
        });
    });
    
    $(document).on('click', "#timer_cover_image", function (e) {
        e.preventDefault();
        e.stopPropagation();
        let timer = $(this).data('timer');       
 		$("#timer_for").val('timer_cover_image')		
        $("#input_timer").val(timer);
        $("#timer-change-status").hide();
  $.magnificPopup.open({
            items: {
                src: '#timer-change-popup',
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            }
        });
    });

    $(document).on('click', ".edit_open_time", function (e) {
        e.preventDefault();
        e.stopPropagation();
       
        var $row = $(this).closest("tr");    // Find the row
        var $open_hour = $row.find(".open_hour").text().trim(); // Find the text 
        var $close_hour = $row.find(".close_hour").text().trim(); // Find the text 
        var $open_hour_2 = $row.find(".open_hour_2").text().trim(); // Find the text 
        var $close_hour_2 = $row.find(".close_hour_2").text().trim(); // Find the text    
        var $day_of_week = $(this).data('dayofweek');
        var $day_of_week_2 = $(this).data('dayofweek2');
        var $id = $(this).data('openid');
        $("#open-hour-status").hide();
        $("#open_hour_id").val($id);
        $("select[id=day_of_week_from]").val($day_of_week).change(); 
        $('input:radio[name="day_of_week_type"]').filter('[value="day_of_week"]').prop('checked', true);
        $("#div_day_of_week_to").addClass("hide");
        $("#label_lang_from").text('{LANG_DAY_OF_WEEK}');
        $("select[id=day_of_week_to]").val($day_of_week).change();

        $("#open_time_value").val($open_hour);
        $('#close_time_value').val($close_hour);
        if ($open_hour_2 == "" && $close_hour_2 == "") {
            $('#open_time_value_2').attr('disabled', 'disabled');
            $('#close_time_value_2').attr('disabled', 'disabled');
            $('input:checkbox[name="open_close_hour_2"]').prop('checked', false);
            $('#open_time_value_2').val('');
            $('#close_time_value_2').val('');
        }
        else {
            $('#open_time_value_2').removeAttr("disabled");
            $('#close_time_value_2').removeAttr("disabled");
            $('input:checkbox[name="open_close_hour_2"]').prop('checked', true);
            $('#open_time_value_2').val($open_hour_2);
            $('#close_time_value_2').val($close_hour_2);
        }


        $.magnificPopup.open({
            items: {
                src: '#open-hour-popup',
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            }
        });
    });

    $("#save-open-time").on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var id = $("#open_hour_id").val();
        $is_from_to = $('input[name="day_of_week_type"]:checked').val() == 'from_to' ? '1' : '0';

        var open_time_2 = "";
        var close_time_2 = "";
        if ($('input:checkbox[name="open_close_hour_2"]').is(':checked')) {
            open_time_2 = $("#open_time_value_2").val();
            close_time_2 = $("#close_time_value_2").val();
        }
        var form_data = {
            action: 'addNewOpenHour',
            is_from_to: $is_from_to,
            day_of_week: $("#day_of_week_from").val(),
            day_of_week_to: $("#day_of_week_to").val(),
            open_time: $("#open_time_value").val(),
            close_time: $("#close_time_value").val(),
            open_time_2: open_time_2,
            close_time_2: close_time_2
        };
        if (id) {
            form_data['id'] = id;
            form_data['action'] = 'editOpenHour';
        }
        $('#save-open-time').addClass('button-progress').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: form_data,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $("#open-hour-status").addClass('success').removeClass('error').html('<p>' + response.message + '</p>').slideDown();
                    location.reload();
                }
                else {
                    $("#open-hour-status").removeClass('success').addClass('error').html('<p>' + response.message + '</p>').slideDown();
                }
                $('#save-open-time').removeClass('button-progress').prop('disabled', false);
            }
        });
        return false;
    });
</script>
<script>
    /* THIS PORTION OF CODE IS ONLY EXECUTED WHEN THE USER THE LANGUAGE(CLIENT-SIDE) */
    $(function () {
        $('.language-switcher').on('click', '.dropdown-menu li', function (e) {
            e.preventDefault();
            var lang = $(this).data('lang');
            if (lang != null) {
                var res = lang.substr(0, 2);
                $('#selected_lang').html(res.toUpperCase());
                $.cookie('Quick_lang', lang, { path: '/' });
                location.reload();
            }
        });
    });
    $(document).ready(function () {
        var lang = $.cookie('Quick_lang');
        if (lang != null) {
            var res = lang.substr(0, 2);
            $('#selected_lang').html(res.toUpperCase());
        }
    });

    $('.live-preview-button').on('click', function (e) {
        e.preventDefault();
        window.open($(this).attr('href'), "live-preview-button", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no,display=popup, width=380, height=' + screen.height + ', top=0, left=0');
    });

    function checkAvailabilityStoreSlug() {
        var $item = $("#store-slug").closest('.submit-field');
        var form_data = {
            action: 'checkStoreSlug',
            slug: $("#store-slug").val()
        };
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: form_data,
            dataType: 'html',
            success: function (response) {
                $("#slug-availability-status").html(response);
            }
        });
    }
   
    $('#shop_open_footer_image').change(
            function () {
                let active = 0;
                if ($(this).is(':checked')) {
                    active = 1;
                }
                $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'changeOnOffFooterImage',
                    active: active
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#383838'
                        });
                    }
                 
                }
            });
              

            });



    $('#shop_open_banner').change(
            function () {
                let active = 0;
                if ($(this).is(':checked')) {
                    active = 1;
                }
                $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'changeOnOffOpenBanner',
                    active: active
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#383838'
                        });
                    }
                 
                }
            });
              

            });

    $('.shop_group_image_active').change(
            function () {
                let $id = $(this).data('id');
                let active = 0;
                if ($(this).is(':checked')) {
                    active = 1;
                }
                $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'changeGroupImageActive',
                    id: $id,
                    active: active
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#383838'
                        });
                    }
                 
                }
            });
              

            });
    
</script>

IF("{RESTAURANT_TEXT_EDITOR}"=="1"){
<script type="text/javascript">
    $(document).ready(function () {
        let radio = $('input:radio[name="day_of_week_type"]:checked');
        $('#open_time_value_2').val("07:00:00");
        $('#close_time_value_2').val("17:00:00");
        if (radio.val() == 'from_to') {
            $("#div_day_of_week_to").removeClass("hide");
            $("#label_lang_from").text('{LANG_FROM_TO}');
        }
        if (radio.val() == 'day_of_week') {
            $("#div_day_of_week_to").addClass("hide");
            $("#label_lang_from").text('{LANG_DAY_OF_WEEK}');
        }
        $('input:radio[name="day_of_week_type"]').change(
            function () {
                if ($(this).is(':checked') && $(this).val() == 'day_of_week') {

                    $("#div_day_of_week_to").addClass("hide");
                    $("#label_lang_from").text('{LANG_DAY_OF_WEEK}');
                }
                if ($(this).is(':checked') && $(this).val() == 'from_to') {
                    $("#div_day_of_week_to").removeClass("hide");
                    $("#label_lang_from").text('{LANG_FROM_TO}');
                }
            });

        $('input:checkbox[name="open_close_hour_2"]').change(
            function () {
                if ($(this).is(':checked')) {
                    //remove it
                    $('#open_time_value_2').removeAttr("disabled");
                    $('#close_time_value_2').removeAttr("disabled");
                }
                else {
                    $('#open_time_value_2').attr('disabled', 'disabled');
                    $('#close_time_value_2').attr('disabled', 'disabled');

                }

            });
    })
</script>

<script>





 
     $(document).on('click',".delete_group_image",function(e){
        e.stopPropagation();
// $(".accordion-group-image .delete_group_image").click(function(e) {
//         e.stopPropagation();
        let $id = $(this).closest('.input-file-slide').data('id'),
            $this = $(this),
            $group_id = $(this).closest('.input-file-slide').data('group-id');
                if (confirm(LANG_ARE_YOU_SURE)) {
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'deleteGroupImageById',
                    id: $id,
                    group_id: $group_id
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#383838'
                        });
                        $("#content_group_image_" + $group_id).prop('disabled', false);
                        $("#content_group_image_" + $group_id).slick('unslick');
                        $("#content_group_image_" + $group_id).html(response.data);
                        $("#content_group_image_" + $group_id).not('.slick-initialized').slick(setting_slick);
                    }
                 
                }
            });
        }
        return true;
    })

    $(document).on('click',".delete_footer_image",function(e){
        e.preventDefault();
        e.stopPropagation();
        let $id = $(this).closest('.input-file-slide').data('id'),
            $this = $(this);
                if (confirm(LANG_ARE_YOU_SURE)) {
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'deleteFooterImage',
                    id: $id,
                    image_type: 'footer_image'
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#383838'
                        });
                        $("#content-slider-footer-image").prop('disabled', false);
                        $("#content-slider-footer-image").slick('unslick');
                        $("#content-slider-footer-image").html(response.data);
                        $("#content-slider-footer-image").not('.slick-initialized').slick(setting_slick);
                    }
                 
                }
            });
        }
    })

$(document).on('click',".delete_cover_image",function(e){
        e.preventDefault();
        e.stopPropagation();
        let $id = $(this).closest('.input-file-slide').data('id'),
            $this = $(this);
                if (confirm(LANG_ARE_YOU_SURE)) {
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'deleteCoverImage',
                    id: $id,
                    image_type: 'banner'
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#383838'
                        });
                        $("#content-slider-banner").prop('disabled', false);
                        $("#content-slider-banner").slick('unslick');
                        $("#content-slider-banner").html(response.data);
                        $("#content-slider-banner").not('.slick-initialized').slick(setting_slick);
                    }
                 
                }
            });
        }
    })
  
    function EditGroupImage(group_id,image)
    {
        let $data = [];  
        let id = $('#' + image).closest('.input-file-slide').data('id');                 
        let action = '?action=EditGroupImageById&id=' + id;       
        var formData = new FormData(); 
        formData.append('image',$('#' + image).closest('.input-file-slide').find('.uploadButton-input')[0].files[0]); 
            $.ajax({
                type: "POST",
                url: ajaxurl + action ,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    console.log(response)
                    if (response.success) {
                        
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#383838'
                        });
                        $("#content_group_image_" + group_id).prop('disabled', false);
                        $("#content_group_image_" + group_id).slick('unslick');
                        $("#content_group_image_" + group_id).html(response.data);
                        $("#content_group_image_" + group_id).not('.slick-initialized').slick(setting_slick);
                    }
                }
            });  
    }
    
    function EditFooterImage(input,id_image_element,image_type)
    {
        let $data = [];  
        let id = $('#' + id_image_element).closest('.input-file-slide').data('id');                 
        let action = '?action=EditFooterImage&id=' + id + "&image_type=" + image_type;       
        var formData = new FormData(); 
     formData.append('image', $('#' + id_image_element).closest('.input-file-slide').find('.uploadButton-input')[0].files[0]); 
     console.log(formData);
            $.ajax({
                type: "POST",
                url: ajaxurl + action ,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    console.log(response)
                    if (response.success) {                
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#383838'
                        });
                        $("#content-slider-footer-image").prop('disabled', false);
                        $("#content-slider-footer-image").slick('unslick');
                        $("#content-slider-footer-image").html(response.data);
                        $("#content-slider-footer-image").not('.slick-initialized').slick(setting_slick);
                    }
                }
            });  
    }
    function readImageURLAndEdit(input,id_image_element,image_type)
    {
        let $data = [];  
        let id = $('#' + id_image_element).closest('.input-file-slide').data('id');                 
        let action = '?action=EditSlideImage&id=' + id + "&image_type=" + image_type;       
        var formData = new FormData(); 
     formData.append('image', $('#' + id_image_element).closest('.input-file-slide').find('.uploadButton-input')[0].files[0]); 
     console.log(formData);
            $.ajax({
                type: "POST",
                url: ajaxurl + action ,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    console.log(response)
                    if (response.success) {
                        
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#383838'
                        });
                        $("#content-slider-banner").prop('disabled', false);
                        $("#content-slider-banner").slick('unslick');
                        $("#content-slider-banner").html(response.data);
                        $("#content-slider-banner").not('.slick-initialized').slick(setting_slick);
                    }
                }
            });  
    }
    
    function AddImageInGroup(input,group_id)
    {
        var $btn = $('.add-group-image-' + group_id);
        let $data = [];                    
        let action = '?action=addImageInGroup&group_id=' + group_id;       
        var formData = new FormData();
        formData.append('image', $('#add_group_image_' + group_id)[0].files[0]);  
        $btn.addClass('button-progress').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: ajaxurl + action,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#383838'
                        });
                        $("#content_group_image_" + group_id).prop('disabled', false);
                        $("#content_group_image_" + group_id).slick('unslick');
                        $("#content_group_image_" + group_id).html(response.data);
                        $("#content_group_image_" + group_id).not('.slick-initialized').slick(setting_slick);
                    }
                    $btn.removeClass('button-progress').prop('disabled', false);
                }
            });
    }

    

    

    function addFooterImage(input,image_type)
    {
        var $btn = $('.add-footer-image');
        let $data = [];                    
        let action = '?action=addFooterImage';       
        var formData = new FormData();
        formData.append('image', $('#add_footer_slide_slide')[0].files[0]);  
        $btn.addClass('button-progress').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: ajaxurl + action ,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#383838'
                        });
                        $("#content-slider-footer-image").prop('disabled', false);
                        $("#content-slider-footer-image").slick('unslick');
                        $("#content-slider-footer-image").html(response.data);
                        $("#content-slider-footer-image").not('.slick-initialized').slick(setting_slick);
                    }
                    $btn.removeClass('button-progress').prop('disabled', false);
                }
            });
    }


    function readImageURLSlide(input,image_type)
    {
        var $btn = $('.add-banner');
        let $data = [];                    
        let action = '?action=addSlideImage&image_type=' + image_type;       
        var formData = new FormData();
        formData.append('image', $('#add_banner_slide')[0].files[0]);  
        $btn.addClass('button-progress').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: ajaxurl + action ,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#383838'
                        });
                        $("#content-slider-banner").prop('disabled', false);
                        $("#content-slider-banner").slick('unslick');
                        $("#content-slider-banner").html(response.data);
                        $("#content-slider-banner").not('.slick-initialized').slick(setting_slick);
                    }
                    $btn.removeClass('button-progress').prop('disabled', false);
                }
            });
    }


      function randomId(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    $("#restaurant_form").on('submit', function (e) {
        return true;
    });

    $(document).on('click',".btn-set-floating-banner",function(e){
        var id = $(this).data('id');
        var state = $(this).data('state');
        
        var _this = $(this);        
        $.post(ajaxurl + '?action=setFloattingImage&id=' + id + '&state=' + ((state+1)%2), function(rp){
            console.log(rp);
            try{
                var js = $.parseJSON(rp);
                if(js.result && js.id==id){
                    /*$('.set-floating-btn-wrap').removeClass('hidden');
                    _this.parent().addClass('hidden');*/
                    _this.text(js.btnText).data('state', (state+1)%2);
                }
            }catch(e){}            
        });
        return false;
    });    
    var boDialog = { wrapper : $('#dlgWrapper'), contentWrapper : $('.popup-tabs-container') };
    $.menuIconSettingsDialog = function(){
    
        $.magnificPopup.open({
            items: {
                src: $('#dlgWrapper'),
                type: 'inline',
                closeBtnInside: false,
                closeOnBgClick : false,
                enableEscapeKey : false,
                fixedContentPos: false,
                fixedBgPos: true,
                midClick: true,   
                mainClass: 'my-mfp-zoom-in',
                modal : true,
                overflowY: 'auto',
                preloader: true,
                removalDelay: 300,
            },
            callbacks:{
                beforeOpen: function(){
                    $('#dlgWrapper .popup-tabs-container').html('').addClass('loading');
                    $('#dlgWrapper').find('.tab-title').text('{LANG_MENU_ICON_SETTINGS}');
                },
                open : function(){
                    var url = '{SITE_URL}php/ctrls/bo/?{USER_AUTH_STRING}&m=advanced-shop-options&d0=load-flat-icon';     
                    $.get(url, function(response){                        
                        $('#dlgWrapper .popup-tabs-container').html(response).removeClass('loading');
                    })
                }/*open cb*/
            }/*callbacks*/
        });

    }
    $.languageSettingsDialog = function(){
        $.magnificPopup.open({
            items: {
                src: $('#dlgWrapper'),
                type: 'inline',
                closeBtnInside: false,
                closeOnBgClick : false,
                enableEscapeKey : false,
                fixedContentPos: false,
                fixedBgPos: true,
                midClick: true,   
                mainClass: 'my-mfp-zoom-in',
                modal : true,
                overflowY: 'auto',
                preloader: true,
                removalDelay: 300,
            },
            callbacks:{
                beforeOpen: function(){
                    $('#dlgWrapper .popup-tabs-container').html('').addClass('loading');
                    $('#dlgWrapper').find('.tab-title').text('{LANG_LANGUAGE}');
                },
                open : function(){
                    var url = '{SITE_URL}php/ctrls/bo/?{USER_AUTH_STRING}&m=shop-options&d0=load-language-settings';
                    $.get(url, function(response){                        
                        $('#dlgWrapper .popup-tabs-container').html(response).removeClass('loading');
                    })
                }/*open cb*/
            }/*callbacks*/
        });
    };

    $.fontSettingsDialog = function(){
        $.magnificPopup.open({
            items: {
                src: $('#dlgWrapper'),
                type: 'inline',
                closeBtnInside: false,
                closeOnBgClick : false,
                enableEscapeKey : false,
                fixedContentPos: false,
                fixedBgPos: true,
                midClick: true,   
                mainClass: 'my-mfp-zoom-in',
                modal : true,
                overflowY: 'auto',
                preloader: true,
                removalDelay: 300,
            },
            callbacks:{
                beforeOpen: function(){
                    $('#dlgWrapper .popup-tabs-container').html('').addClass('loading');
                    $('#dlgWrapper').find('.tab-title').text('{LANG_CUSTOMIZE_FONT}');
                },
                open : function(){
                    var url = '{SITE_URL}php/ctrls/bo/?{USER_AUTH_STRING}&m=shop-options&d0=load-font-settings';
                    $.get(url, function(response){                        
                        $('#dlgWrapper .popup-tabs-container').html(response).removeClass('loading');
                    })
                }/*open cb*/
            }/*callbacks*/
        });
    };
</script>
{:IF}

</body>

</html>