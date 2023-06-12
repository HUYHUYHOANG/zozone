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
                <h3>{RESV_LABEL_TEXT}</h3>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="{LINK_INDEX}">{LANG_HOME}</a></li>
                        <li>{RESV_LABEL_TEXT}</li>
                    </ul>
                </nav>
            </div>

            <!-- BEGIN CONTENT -->
            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="margin-top-0">                      
                        <div class="right-toolbox menu-button">
                            <a href="./customers?d0=view-customer&id={THE_CUSTOMER_ID}" class="button ripple-effect button-sliding-icon margin-left-auto">{LANG_CUSTOMER} <i class="icon-feather-user"></i></a>
                            <a href="./customers?d0=customer-vouchers&id={THE_CUSTOMER_ID}" class="button ripple-effect button-sliding-icon margin-left-auto">{LANG_VOUCHERS} <i class="icon-feather-tag"></i></a>
                            <a href="./customers?d0=customer-reservations&id={THE_CUSTOMER_ID}&t=new" class="{BTN_NEW_CLASS} margin-left-auto">{LANG_CUSTOMER_NEW_RESERVATIONS} <i class="icon-feather-calendar"></i></a>
                            <a href="./customers?d0=customer-reservations&id={THE_CUSTOMER_ID}&t=past" class="{BTN_PAST_CLASS} margin-left-auto">{LANG_CUSTOMER_PAST_RESERVATIONS} <i class="icon-feather-calendar"></i></a>
                        </div>
                        <div class="dashboard-box margin-top-0 content with-padding padding-bottom-10" style="margin-right:0;padding-right:0;">
                            <div class="row main-box-in-row col-xl-12">
                                <div class="col-xl-12 col-lg-12 col-sm-12 headline" style="margin-top:16px;margin-right:0;padding-right:0;">
                                    <div class="col-xl-6 input-with-icon-left">
                                        <strong>{LANG_CUSTOMER} {LANG_INFORMATION} : <a><span class="hdrCustName">{THE_CUSTOMER_NAME}</span></a></strong>
                                    </div>                                    
                                    <div class="col-xl-6 text-right right-cmds"></div>
                                </div><!--end headline-->
                                
                                <!--data table container-->
                                <div class="col-xl-12 col-lg-12 col-sm-12">
                                    <div class="customers-data-wrap table-responsive-xl"></div>
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

<!--DIALOG TEMPLATE -->
<div id="dlgWrapper" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="log-item-form">
        <ul class="popup-tabs-nav">
            <li class="active"><a class="tab-title">{LANG_RESERVATION}</a></li>
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

<script type="text/javascript">
    boConfigParams = $.extend({selectedStatus : [], ajxAction : 'customers', defaultView : 'load-customers'}, boConfigParams);    
    var boDialog = { wrapper : $('#dlgWrapper'), contentWrapper : $('.popup-tabs-container') };
    var customerID = {THE_CUSTOMER_ID};
    
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

        $.loadCustomerReservations();
    });

    $.loadCustomerReservations = function(){
        var data = {
                m   :   boConfigParams.ajxAction,
                d0  :   'customer-reservations',
                customer : customerID,
                t   : '{THE_RESV_TYPE}',
                page : -1
            };
            $('.customers-data-wrap').html('').addClass('loading');
            $bkGet(data, function(rp){
                $('.customers-data-wrap').removeClass('loading').html(rp);
                $.initListview();
            }); 
    };    
    
    $.initListview = function(){
        $('.resv-table .btn-action').click(function(){
            var theID = $(this).data('id');
            var action = $(this).data('action');
            if(action=='delete'){
                $.deleteResv($(this), theID);
            }else if(action=='edit'){
                $.editResv($(this), theID);
            }
        });
    };

    $.deleteResv = function(btn, theID){
        btn.confirm('{LANG_DELETE_THE_SELECTED_RECORD}', function(){
            var data = {
                m   :   boConfigParams.ajxAction,
                d0  :   'delete-customer-reservation',
                id : theID
            };
            btn.addClass('ajxloading');
            $bkGet(data, function(rp){
                var r = $.parseJSON(rp);
                if(r.ret>0 && r.id>0){
                    btn.parent().parent().remove();
                }
                btn.removeClass('ajxloading');
            });             
        });
    };

    $.editResv = function(btn, theID){
        boDialog.wrapper.mfpPopup(boDialog, function(){
            var data = {
                m   :   boConfigParams.ajxAction,
                d0  :   'edit-customer-reservation',
                id : theID
            };
            btn.addClass('ajxloading');
            $bkGet(data, function(rp){
                boDialog.contentWrapper.html(rp).removeClass('loading');
                btn.removeClass('ajxloading');
                $('.selectpicker').selectpicker({title: '',});
                $('#frmCustomerReservation').find('input[type="text"]').addClass('disabled').prop('disabled',1);
                $('#btnSave').click(function(e){                    
                    var data = {
                        m   :   boConfigParams.ajxAction,
                        d0  :   'change-customer-reservation-status',
                        id : theID,
                        state : $('#resv-status').val()
                    };
                    $('#btnSave').addClass('ajxloading');
                    $bkGet(data, function(rp){                        
                        $('#btnSave').removeClass('ajxloading');
                        $.magnificPopup.close();
                        console.log(rp);
                        try{
                            var js = $.parseJSON(rp);
                            if(js.ret && js.ret==js.id){
                                $.loadCustomerReservations();
                            }
                        }catch(e){}
                    });
                });
            });
        }, function(){
            /*boDialog.contentWrapper.removeClass('loading');*/
        });
    };
</script>
</body>
</html>