{OVERALL_HEADER}
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
                <h3>{LANG_MESSAGE_TEMPLATES}</h3>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="{LINK_INDEX}">{LANG_HOME}</a></li>
                        <li>{LANG_MESSAGE_TEMPLATES}</li>
                    </ul>
                </nav>
            </div>

            <!-- BEGIN CONTENT -->
            <div class="row">                
                <div class="col-xl-12">
                    <div class="margin-top-0">                      
                        <div class="right-toolbox menu-button">                            
                            <a href="./message-templates?d0=edit-template&id=0" class="button ripple-effect button-sliding-icon margin-left-auto">{LANG_ADD} <i class="icon-feather-plus"></i></a>
                        </div>
                        <div class="dashboard-box margin-top-0 content with-padding padding-bottom-10">
                            <div class="row main-box-in-row col-xl-12">
                                <div class="col-xl-12 col-lg-12 col-sm-12 headline" style="visibility:hidden">
                                    <!--<div class="col-xl-3 input-with-icon-left" style="margin-top:16px;">
                                        <i class="icon-feather-users"></i>                                            
                                        <input type="text" class="with-border form-control" id="ccl-customer" placeholder="{LANG_NAME}/{LANG_PHONE}/Email">
                                    </div>
                                    <div class="col-xl-2">
                                        <select id="ccl-status" class="selectpicker with-border" multiple>
                                            {LIST_LOGS_STATUS}
                                        </select>
                                    </div>
                                    <div class="col-xl-2 input-with-icon-left" style="margin-top:16px;">
                                        <i class="icon-feather-calendar"></i>
                                        <input type="text" class="with-border form-control" id="ccl-from-date-search">
                                    </div>
                                    <div class="col-xl-2">
                                        <button class="btn-search button" id="ccl-search"><i class="icon-feather-search"></i> {LANG_SEARCH}</button>
                                    </div>-->
                                </div><!--end headline-->
                                
                                <!--data table container-->
                                <div class="col-xl-12 col-lg-12 col-sm-12">
                                    <div class="templates-data-wrap table-responsive-xl"></div>
                                </div>
                                <!--data table  container-->
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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!--custom js files-->
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/codec.min.php?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/shop-util.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>

<script>
    var readOnly = {READONLY_PERMISSION};    
    boConfigParams = $.extend({selectedStatus : [], ajxAction : 'message-template', defaultView : 'load-templates'}, boConfigParams);        
    boConfigParams.boSvrSide = '{SITE_URL}php/ctrls/bo/?{USER_AUTH_STRING}&m=' + boConfigParams.ajxAction + '&d0=save-template';

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

        $.loadTemplates();        
    });

    $.loadTemplates = function(){        
        var data = {
                m   :   boConfigParams.ajxAction,
                d0  :   boConfigParams.defaultView,                
                page : -1
            };
        
        $('.templates-data-wrap').html('').addClass('loading');
        $bkGet(data, function(rp){
            $('.templates-data-wrap').removeClass('loading').html(rp);
            $paginationClick();
            $rowActionsClick();
        }); 
    };    

    $paginationClick = function(){
        return;
        $('ul.pagination>li>a').click(function(){
            if(typeof($(this).data('page'))=="undefined") return;            
            var data = {
                m   :   boConfigParams.ajxAction,
                d0  :   boConfigParams.defaultView,
                page : $(this).data('page')
            };
            $bkGet(data, function(rp){
                $('.ccl-data-wrap').html(rp);
                $paginationClick();
                $rowActionsClick();
            });
        });
    };

    $rowActionsClick = function(){
        $('a.delete').click(function(){
            var action =  $(this).data('action');
            var theID =  $(this).parent().data('id');
            if(action=='delete') $deleteItem($(this), theID);
        });
    };

    $deleteItem = function(obj, theID){
        swal({                
            text: "{LANG_DELETE_THE_SELECTED_RECORD}",
            icon: "warning", 
            buttons: true
        }).then((willDelete) => {
            if(willDelete){
                var data = {m:boConfigParams.ajxAction, d0:'delete-the-item', item : theID};
                $bkGet(data, function(rp){                    
                    obj.parent().parent().parent().remove();                    
                });
            }
        });
    };
</script>
<style>
    .templates-table th, .templates-table td.template-type{text-transform: capitalize;}
</style>
</body>
</html>