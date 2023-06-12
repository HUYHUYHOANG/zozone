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

    .color_wrapper h5{font-size:16px;line-height:26px;}
    .color_wrapper{cursor:pointer;border:1px solid #e8e8e8 !important;}
    .color_wrapper:hover h5, .color_wrapper:hover i{color: var(--classic-color-1);}
    .color_wrapper span i{margin-top:6px;}
    
    .popup-tabs-container{overflow-x: hidden !important;}
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
					<span class="hamburger hamburger--collapse" >
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
        <div class="dashboard-content-inner" >

            <!-- Dashboard Headline -->
            <div class="dashboard-headline">
                <h3>{LANG_ADVANCED_SETTINGS}</h3>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="{LINK_INDEX}">{LANG_HOME}</a></li>
                        <li>{LANG_ADVANCED_SETTINGS}</li>
                    </ul>
                </nav>
            </div>

            <!-- BEGIN CONTENT -->
            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box">                        
                        <div class="headline"></div>
                        <div class="content">
                            <div class="content with-padding staffs-data-wrap">
                                <!--COLOR-->
                                <div class="col-xl-12 margin-bottom-5 font-weight-bold">{LANG_COLOR}</div>
                                <div class="col-xl-12 margin-bottom-5">
                                    <div class="dashboard-box row margin-0-auto" style="display:flex ;">
                                        <!--THEME COLOR-->
                                        <div class="col-xl-3 col-md-3 col-sm-6 col-12 dashboard-box-left">
                                            <div class="align-items-center margin-bottom-15">
                                                <div class="margin-top-15">                                     
                                                    <div class="color_wrapper">
                                                        <div class="wrapper-left">
                                                            <div class="qr-bg-color-wrapper qr-color-wrapper">
                                                                <button class="bm-color-picker"> </button>  
                                                                <input type="hidden" class="color-input" name="shop_theme_color" value="{SHOP_THEME_COLOR}">       
                                                            </div>
                                                        </div>
                                                        <div class="wrapper-right"> <div>
                                                            <h5 class="margin-bottom-0">{LANG_THEME_COLOR}</h5>
                                                        </div></div>
                                                    </div>
                                                </div>        
                                            </div>
                                        </div>
                                        <!--FORE COLOR-->
                                        <div class="col-xl-3 col-md-3 col-sm-6 col-12 dashboard-box-right align-items-center">
                                            <div class="align-items-center margin-bottom-15">
                                                <div class="margin-top-15"> 
                                                <div class="color_wrapper">
                                                    <div class="wrapper-left">
                                                        <div class="qr-fg-color-wrapper qr-color-wrapper">
                                                            <button class="bm-color-picker"></button>
                                                            <input type="hidden" class="color-input" name="shop_fore_color" value="{SHOP_FORE_COLOR}">
                                                        </div>
                                                    </div>
                                                    <div class="wrapper-right"> <div>
                                                        <h5 class="margin-bottom-0">{LANG_FORGROUND_COLOR}</h5>
                                                    </div></div>
                                                    </div>
                                                  
                                                </div>
                                            </div>
                                        </div>
                                        <!--END FORE COLOR-->
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
                                        <!--MENU ICON SETTINGS-->
                                        <div class="col-xl-3 col-md-3 col-sm-6 col-12 dashboard-box-right">
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
                                <!--END COLOR-->
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->

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

<!--DIALOG TEMPLATE -->
<div id="dlgWrapper" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="log-item-form">
        <ul class="popup-tabs-nav">
            <li class="active"><a class="tab-title">{LANG_GROUPS}</a></li>
        </ul>
        <div class="popup-tabs-container"></div>
    </div>
</div><!--DIALOG TEMPLATE-->

<script>
    $(document).ready(function () {
        $("#header-container").addClass('dashboard-header not-sticky');
    });
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
<script src="{SITE_URL}templates/{TPL_NAME}/js/svg.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/color-picker.es5.min.js?ver={VERSION}"></script>

<script src="{SITE_URL}templates/{TPL_NAME}/js/sweetalert.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/shop-util.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/codec.min.php"></script>

<script type="text/javascript">
    boConfigParams = $.extend({secretChanged : 0, selectedStatus : [], ajxAction : 'staffs', defaultView : 'load-staffs'}, boConfigParams);    
    var boDialog = { wrapper : $('#dlgWrapper'), contentWrapper : $('.popup-tabs-container') };
    /* THIS PORTION OF CODE IS ONLY EXECUTED WHEN THE USER THE LANGUAGE(CLIENT-SIDE) */
    $(function () {
        $('.language-switcher').on('click', '.dropdown-menu li', function (e) {
            e.preventDefault();
            var lang = $(this).data('lang');
            if (lang != null) {
                var res = lang.substr(0, 2);
                $('#selected_lang').html(res.toUpperCase());
                $.cookie('Quick_lang', lang,{ path: '/' });
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

        $.initColorPickers();        
    });    
    
    $.initColorPickers = function(){
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

    $.menuIconSettingsDialog = function(){
        boDialog.wrapper.mfpPopup(boDialog, function(){
            boDialog.wrapper.find('.tab-title').text('{LANG_MENU_ICON_SETTINGS}');
            var url = '{SITE_URL}php/ctrls/bo/?{USER_AUTH_STRING}&m=advanced-shop-options&d0=load-flat-icon';            
            $.get(url, function(rp){                
                boDialog.contentWrapper.html(rp).removeClass('loading');                
            });
        }); 
    }
</script>
</body>
</html>