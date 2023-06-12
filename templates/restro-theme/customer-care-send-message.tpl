{OVERALL_HEADER}
<link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/simditor/simditor.css" />
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
                <h3>{LANG_BO_MENU_CUSTOMER_CARE} / {LANG_MESSAGE}</h3>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="{LINK_INDEX}">{LANG_HOME}</a></li>
                        <li>{LANG_BO_MENU_CUSTOMER_CARE}</li>
                    </ul>
                </nav>
            </div>

            <!-- BEGIN CONTENT -->
            <div class="row">                
                <div class="col-xl-12">
                    <div class="margin-top-0">                      
                        <div class="right-toolbox menu-button">
                            <a class="button margin-left-auto disabled">{LANG_MESSAGE} <i class="icon-feather-send"></i></a>                            
                            <a href="./customer-care" class="button ripple-effect button-sliding-icon margin-left-auto">{LANG_BO_MENU_CUSTOMER_CARE} <i class="icon-feather-calendar"></i></a>
                        </div>
                        <div class="dashboard-box content" style="padding:20px;">
                            <div class="row main-box-in-row">                                
                                <form class="col-xl-12" id="frm-send-msg">
                                    <div class="row">
                                        <div class="col-xl-3 col-md-4 col-sm-12">
                                            <div class="submit-field">
                                                <h5>Customers</h5>
                                                <select class="selectpicker" id="msg-via">
                                                    <option value="0">All</option>
                                                    <option value="15">Last 15-day activity</option>
                                                    <option value="30">Last 30-day activity</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-4 col-sm-12">
                                            <div class="submit-field">
                                                <h5>Send message using</h5>
                                                <select class="selectpicker" id="msg-via">
                                                    <option value="email">Email</option>
                                                    <option value="whatsapp">What's App</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-4 col-sm-12">
                                            <div class="submit-field">
                                                <h5>Message template</h5>
                                                <select class="selectpicker" id="msg-template">
                                                    <option value="1">Email</option>
                                                    <option value="2">What's App</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div><!--options row -->
                                    <div class="row">
                                        <div class="col-xl-8 col-md-12 col-sm-12">
                                            <textarea id="msg-editor" rows="10" style="resize:no-resize;width:100%;"></textarea>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-xl-12 col-md-12 col-sm-12">
                                            <button class="button button-sliding-icon ripple-effect" type="submit" style="margin-right:12px;"><span>{LANG_SAVE}</span><i class="icon-material-outline-arrow-right-alt"></i></button>
                                            <button class="button button-sliding-icon ripple-effect" type="button"><span>{LANG_SEND}</span><i class="icon-feather-send"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!--dashboard-box content-->
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

<div id="ccl-modal-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="log-item-form">
        <ul class="popup-tabs-nav">
            <li class="active"><a class="tab-title">{LANG_BO_MENU_CUSTOMER_CARE}</a></li>
        </ul>
        <div class="popup-tabs-container"></div>
    </div>
</div><!--popup template-->

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

<script src="{SITE_URL}templates/{TPL_NAME}/js/jquery.cookie.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/custom.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/svg.js?ver={VERSION}"></script>

<!--custom js files-->
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/codec.min.php?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/shop-util.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>

<script src="{SITE_URL}templates/{TPL_NAME}/plugins/simditor/module.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/simditor/hotkeys.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/simditor/uploader.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/simditor/simditor.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/simditor/mobilecheck.js"></script>

<script>
    var readOnly = {READONLY_PERMISSION};
    var boDialog = { wrapper : $('#ccl-modal-dialog'), contentWrapper : $('.popup-tabs-container') };
    boConfigParams = $.extend({selectedStatus : [], ajxAction : 'customer-care-log', defaultView : 'load-the-logs'}, boConfigParams);        
    boConfigParams.boSvrSide = '{SITE_URL}php/ctrls/bo/?{USER_AUTH_STRING}&m=' + boConfigParams.ajxAction + '&d0=action-here';

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
        
        $initSelectPicker();
        $('#frm-send-msg').submit(function(){
            console.log($('#msg-editor').val());
            return false;
        });
    });

    $initSelectPicker = function(){        
        $('.selectpicker').selectpicker({title: '{LANG_ALL}'}).selectpicker('render')
        .on('change', function(){
            
        });
    };

(function() {
  $(function(){
    var $preview, editor, mobileToolbar, toolbar;
    Simditor.locale = 'en-US';
    toolbar = ['bold', 'italic', 'underline', 'strikethrough', 'fontScale', 'color', '|', 'ol', 'ul', 'table', '|', 'link', 'alignment'];
    mobileToolbar = ["bold", "underline", "strikethrough", "color", "ul", "ol"];
    if (mobilecheck()) {
      toolbar = mobileToolbar;
    }
    editor = new Simditor({
      textarea: $('#msg-editor'),
      placeholder: '',
      toolbar: toolbar,
      pasteImage: true,
      upload : false
      /*defaultImage: 'assets/images/image.png',
      upload: location.search === '?upload' ? {
        url: '/upload'
      } : false*/
    });
    $preview = $('#preview');
    if ($preview.length > 0) {
      return editor.on('valuechanged', function(e) {
        return $preview.html(editor.getValue());
      });
    }
  });
}).call(this);

</script>
<style>
    .popup-tabs-container.loading{height:200px;width:100%;background:#FFF url({SITE_URL}templates/{TPL_NAME}/images/loading2.svg) no-repeat center center !important;}    
    .loading{height:100px;width:100%;background:#FFF url({SITE_URL}templates/{TPL_NAME}/images/loading2.svg) no-repeat center center !important;}

    .dropdown-header{padding:10px !important;font-size:16px;font-weight: 600;}

    #customr-care-logs td.date-time{
        white-space:nowrap;
    }
</style>
</body>
</html>