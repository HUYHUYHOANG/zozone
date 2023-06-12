{OVERALL_HEADER}
<style>
    @media screen and (min-width: 576px){
        #frm-booking-settings .booking-settings-staffs{
            margin-top:25px;
        }
    }
    
    button:disabled{cursor:default;}
    button[type="button"]:disabled{cursor:default !important;opacity:.8;}
    .loading{height:100px;width:100%;background:#FFF url({SITE_URL}templates/{TPL_NAME}/images/loading.svg.php) no-repeat center center !important;}
    .ajxloading{text-indent: -9999em;box-shadow:none;background:#FAFAFA url({SITE_URL}templates/{TPL_NAME}/images/loading.svg.php) no-repeat center center !important;}
    .ajxloading i::before{
        content:'';
    }
    .hdrCustName{color:var(--classic-color-1);}
    .dashboard-box.content{padding:30px;}
    .table thead th {
       background: #EEE !important;
    }

    .time-item{
        background-color: var(--classic-color-1); color:#FFF;padding:6px 12px;border-radius:4px;margin-top:6px;margin-right:4px;display: inline-block;
    }

    .services-item{
        display: block;
    }
    
    .table td.no-border{border-top:none !important;}

    @media (min-width: 576px){
        .d-sm-block {
            display: table-cell !important;
        }
    }

    @media screen and (min-width: 768px) and (max-width:1199px){
        .xs-with-margin-top .submit-field{margin-top:0;}        
    }

    @media screen and (max-width: 767px){        
        .submit-field{margin-bottom: 0;}
        .xs-with-margin-top{margin-top:20px;}
        .xs-with-margin-top .sm-hide{margin-bottom: -5px;}
    }

    @media screen and (max-width: 575px){
        .staffs-select-wrapper{margin-top:15px;}
        .xs-with-margin-top .sm-hide{display: none;}
    }
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
                <h3>{LANG_BO_MENU_RESERVATIONS_REPORT}</h3>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="{LINK_INDEX}">{LANG_HOME}</a></li>
                        <li>{LANG_BO_MENU_RESERVATIONS_REPORT}</li>
                    </ul>
                </nav>
            </div>

            <!-- BEGIN CONTENT -->
            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="margin-top-0">
                        <div class="dashboard-box margin-top-0 content with-padding padding-bottom-10">
                            <div class="row main-box-in-row">
                                <div class="col-xl-3 col-md-3 col-sm-6">
                                    <div class="submit-field">
                                        <h5>{LANG_FROM}</h5>
                                        <div class="input-with-icon-left">
                                            <i class="la la-calendar"></i>
                                            <input type="text" class="datepkr with-border" id="from-date" maxlength="20" autocomplete="off" placeholder="mm-dd-yyyyy"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-3 col-sm-6">
                                    <div class="submit-field">
                                        <h5>{LANG_TO}</h5>
                                        <div class="input-with-icon-left">
                                            <i class="la la-calendar"></i>
                                            <input type="text" class="datepkr with-border" id="to-date" maxlength="20" autocomplete="off" placeholder="mm-dd-yyyyy"/>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="col-xl-2 col-md-3 col-sm-6">
                                    <div class="submit-field">
                                        <h5>{LANG_REPORT}</h5>
                                        <select id="report-type" class="selectpicker">
                                            <option value="daily">{LANG_DAILY}</option>
                                            <option value="weekly">{LANG_WEEKLY}</option>
                                            <option value="monthly">{LANG_MONTHLY}</option>
                                            <option value="annually">{LANG_ANNUALLY}</option>
                                        </select>
                                    </div>
                                </div>-->
                                <div class="col-xl-3 col-md-3 col-sm-6 staffs-select-wrapper">
                                    <div class="submit-field">
                                        <h5>{LANG_STAFF}</h5>
                                        <select id="staff-id" data-selected="" class="selectpicker" title="{LANG_ALL}" multiple data-max-options="5">                                            
                                            {LOOP: STAFFS}
                                                <option value="{STAFFS.id}">{STAFFS.name}</option>                                                
                                            {/LOOP: STAFFS}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-3 col-sm-6 xs-with-margin-top">
                                    <div class="submit-field">
                                        <h5 class="sm-hide">&nbsp;</h5>
                                        <button id="btn-search" class="button ripple-effect margin-left-auto" style=""><i class="icon-feather-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--report content-->
                        <div class="dashboard-box content with-padding">
                            <div class="row main-box-in-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12">                                    
                                    <div class="report-wrap">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end report content-->
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
            <li class="active"><a class="tab-title">{LANG_CUSTOMER_GROUPS}</a></li>
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

<!--custom js files-->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/shop-util.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/js/moment.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/js/bootstrap-datetimepicker.min.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/codec.min.php"></script>

<script type="text/javascript">
    boConfigParams = $.extend({selectedStatus : [], ajxAction : 'reservation-report', defaultView : 'load-report'}, boConfigParams);    
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

        $.initReportOptions();
        $.doReport();
        $('#btn-search').click(function(){
            $.doReport();
        });
    });

    $.initReportOptions = function(){
        $('.datepkr').datetimepicker({
            locale: '{LANG_LOCALE}',
            format: 'MM-DD-YYYY',
            minDate: moment().subtract(5,'years'),
            maxDate: moment().endOf('month').format('MM-DD-YYYY')
        });
        $('#from-date').val(moment().startOf('month').format('MM-DD-YYYY'));
        $('#to-date').val(moment().endOf('month').format('MM-DD-YYYY'));

        $('#staff-id').change(function(){
            var selected = [];
            $(this).find(':selected').each(function(){
                selected.push($(this).val());
            });
            $(this).data('selected', selected.toString());
        });
    };

    $.doReport = function(){
        var fromDate = $('#from-date').val();
        var toDate = $('#to-date').val();
        var staffs = $('#staff-id').data('selected');
        var page = arguments.length ? arguments[0] : -1;
        $('.report-wrap').html('').addClass('loading');        
        var data = {m : boConfigParams.ajxAction, d0 : 'load-booking-report', from : fromDate, to : toDate, staffs : staffs, page : page};
        
        $bkGet(data, function(rp){                
            $('.report-wrap').html(rp).removeClass('loading');
            $.paginationClick();
        });
    };

    $.paginationClick = function(){
        $('ul.pagination>li>a').click(function(){
            if(typeof($(this).data('page'))=="undefined") return;            
            $.doReport($(this).data('page'));
        });
    };
</script>
</body>
</html>