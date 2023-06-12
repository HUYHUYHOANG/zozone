{OVERALL_HEADER}
<style>
    button.ajxloading i, button.ajxloading span{
        display:none;
    }

    table td.td-group{background-color:#FAFAFA !important;font-weight:600;}
    .white-popup {
        position: relative;
        background: #FFF;
        padding: 40px;
        width: auto;
        max-width: 200px;
        margin: 20px auto;
        text-align: center;
        border-radius:2px;
    }
    button.mfp-close{top:0;right:0;color:#000;} button.mfp-close:hover{color:#666;}

    button.resv-status{width:50%;cursor: default !important;}
    button.resv-status, button.resv-status:focus, button.resv-status:active{outline:none !important;border:0 !important;tabindex:0;}

    .booking-status .dropdown-menu>li>a, #frmBookingDlg .dropdown-menu>li>a{
        padding: 2px 5px;
    }
    .booking-status .bootstrap-select .dropdown-menu li.selected a span.check-mark:before{
        color:#FFF;
    }
    .bootstrap-select.btn-group .dropdown-menu li a .btn{width:100%;height:100% !important;}    
    .filter-option div.btn{        
    }

    #frmBookingDlg .button{min-width: 150px;}
    #frmBookingDlg .submit-field{padding-bottom:0;margin-bottom:0}
    #frmBookingDlg .submit-field h5{margin-bottom: 4px;}

    #frm-booking-settings .label-payment{
        margin-top: 22px;
    }
    #frm-booking-settings .popup-tab-content{
        padding-top:0;
    }
    #frm-booking-settings .popup-tab-content .submit-field{
        margin-bottom: 0;
    }
    #frm-booking-settings .switch-container {
        padding-top:0;
        padding-bottom:5px;
    }    

    #tblReservations td button, #tblReservations td.buttons-wrap, td.price-col span, span.resv-time{
        white-space: nowrap;                
    }
    #tblReservations td button{
        width: 100%;overflow: visible;
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
                <h3>{LANG_RESERVATIONS}</h3>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="{LINK_INDEX}">{LANG_HOME}</a></li>
                        <li>{LANG_RESERVATIONS}</li>
                    </ul>
                </nav>
            </div>

            <!-- BEGIN CONTENT -->
            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="margin-top-0">
                        <div class="right-toolbox menu-button">
                            <a href="javascript:void(0);" class="button ripple-effect button-sliding-icon margin-left-auto" id="btnAddBooking">{LANG_ADD} {LANG_RESERVATION} <i class="icon-feather-plus"></i></a>                            
                        </div>
                        <div class="dashboard-box margin-top-0 content with-padding padding-bottom-10">
                            <div class="row main-box-in-row padding-bottom-0 margin-bottom-0" style="padding:30px 30px 0;">
                                <div class="col-xl-3 col-md-3 col-sm-6">
                                    <div class="submit-field">
                                        <h5>{LANG_DATE}</h5>
                                        <div class="input-with-icon-left">
                                            <i class="icon-feather-calendar"></i>                                            
                                            <input type="text" class="with-border search-date-range" id="rs-date-range" type="text" placeholder="{LANG_BOOKING} {LANG_DATE}" onkeydown="return false" onpaste="return false">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-3 col-sm-6">
                                    <div class="submit-field">
                                        <h5>{LANG_STAFF}</h5>
                                        <select id="staffsList" class="selectpicker with-border" multiple>
                                            {LOOP: STAFFS}
                                            <option value="{STAFFS.id}">{STAFFS.name}</option>
                                            {/LOOP: STAFFS}
                                        </select>
                                    </div>
                                </div>                                

                                <div class="col-xl-6 col-md-6 col-sm-12 xs-with-margin-top">
                                    <div class="submit-field">
                                        <h5 class="sm-hide">&nbsp;</h5>
                                        <button class="btn-search button"><i class="icon-feather-search"></i>&nbsp;</button>
                                        <button class="btn-listview button" onclick="document.location='./reservations?d0=calenderview'" style="margin-left:4px;"><i class="icon-feather-calendar"></i>&nbsp;</button>
                                        <button class="btn-settings button" style="float:right"><i class="icon-feather-settings"></i></button>
                                    </div>
                                </div>
                                <!--data table container-->                                
                            </div>
                            <div>
                                <div class="col-xl-12 col-lg-12 col-sm-12">
                                    <div class="resv-wrapper table-responsive-xl">
                                        {RESV_LIST_DATA}
                                    </div>
                                </div>
                            </div>
                            <!--data table  container-->
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

<!--custom js files-->
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap/js/popper.min.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<!--<script src="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap/js/bootstrap.min.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>-->

<script src="{SITE_URL}templates/{TPL_NAME}/plugins/shop-util.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/sweetalert.min.js"></script>

<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/js/moment.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/moment/moment-timezone.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/moment/moment-timezone-with-data.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<!--<script src="{SITE_URL}templates/{TPL_NAME}/plugins/typeahead/typeahead.bundle.min.js"></script>-->
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/typeahead/1.2.1/bloodhound.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/typeahead/1.2.1/typeahead.jquery.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/codec.min.php"></script>

<script>
    boConfigParams = $.extend({selectedStaffIDs : [], selectedStatus : [], ajxAction : 'reservation', defaultView : 'search-reservation'}, boConfigParams);
    var boDialog = { wrapper : $('#dlgWrapper'), contentWrapper : $('.popup-tabs-container') };
    var isDialogInitialized = 0;
    
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
        /*moment.tz.setDefault("Europe/Berlin");*/

        var lang = $.cookie('Quick_lang');
        if (lang != null) {
            var res = lang.substr(0, 2);
            $('#selected_lang').html(res.toUpperCase());
        }

        $('.btn-settings').click(function(){
            $bookingSettingsDialog();
        });

        $('#btnAddBooking').click(function(){
            $.addBookingDialog();
        });

        $.initDateRange()
        $.initSelectPicker();
        $.initDataGrid();
        $.searchClick();
        $.rowActions();
        $.paginationClick();
    });

    $bookingSettingsDialog = function(){
        boDialog.wrapper.mfpPopup(boDialog, function(){
            boDialog.wrapper.find('.tab-title').text('{LANG_SETTING}');
            var data = {m : boConfigParams.ajxAction, d0 : 'booking-settings-dialog'};
            $bkGet(data, function(rp){
                boDialog.contentWrapper.html(rp).removeClass('loading');
            });
        });
    };

    $.addBookingDialog = function(){
        boDialog.wrapper.mfpPopup(boDialog, function(){
            boDialog.wrapper.find('.tab-title').text('{LANG_ADD} {LANG_BOOKING}');
            var data = {m : boConfigParams.ajxAction, d0 : 'add-new-booking'};
            $bkGet(data, function(rp){
                boDialog.contentWrapper.html(rp).removeClass('loading');                
                setTimeout(function(){
                    if($.bookingDialogInitCallback) $.bookingDialogInitCallback();
                }, 100);
            });
        });
    };
    
    $.bookingDialogSavedCallback = function(js, itemId){        
        document.location.reload();
    };
    
    $.initDateRange = function(){
        var today = new Date();
		$('.search-date-range').daterangepicker({
                buttonClasses   : 'btn-sm btn-primary',
                startDate       : moment().subtract(1,'months').startOf('month').format('MM-DD-YYYY'),
                endDate         : moment().endOf('month').format('MM-DD-YYYY'),
                locale          : {
                                    applyLabel: '<i class="fa fa-check">',
                                    cancelLabel:'<i class="fa fa-close">' 
                                  }
            }, 
            function(start, end, label) {
                /*console.log("start.format('MM-DD-YYYY') + ' to ' + end.format('MM-DD-YYYY'));*/
            }
        );
        $('.search-date-range').on('cancel.daterangepicker', function(ev, picker){
            $(ev.currentTarget).val('');
        });
    };

    $.initSelectPicker = function(){
        $('.selectpicker').selectpicker({title: '{LANG_STAFF}',}).selectpicker('render')
        .on('change', function(){
            boConfigParams.selectedStaffIDs = [];
            $(this).find('option:selected').each(function(){
                boConfigParams.selectedStaffIDs.push($(this).val());
            });	
        });
    };

    $.initDataGrid = function(){        
    };

    $.searchClick = function(){
        $('.btn-search').click(function(){
            var dr = $('#rs-date-range').val();
            var parts = dr.split('-');
            var startDate = CStr.trim(parts[0]), endDate = CStr.trim(parts[1]);            
            var data = {
                m   :   'reservation',
                d0  :   'search-reservation',
                std :   moment(startDate, 'MM/DD/YYYY').format('YYYY-MM-DD'),
                end :   moment(endDate, 'MM/DD/YYYY').format('YYYY-MM-DD'),
                staffs : boConfigParams.selectedStaffIDs.toString(),
                done : $('#rs-done').prop('checked') ? 1 : 0,
                page : -1
            };
            var btn = $(this).addClass('ajxloading');
            $('.resv-wrapper').html('').addClass('loading');
            $bkGet(data, function(rp){                
                $('.resv-wrapper').html(rp).removeClass('loading');
                $.rowActions();
                $.paginationClick();
                btn.removeClass('ajxloading');
            });
        });
    };

    $.rowActions = function(){
        $('.resv-detail').click(function(e){            
            $.bookingClickDialog($(this).data('id'), $(this).data('readonly'));
        });

        $('.btnDelete').click(function(){
            $.deleteRecord($(this));
        });
    };

    $.deleteRecord = function(_this){
        _this.confirm('{LANG_DELETE_THE_SELECTED_RESERVATION}', function(){
            var data = {m : boConfigParams.ajxAction, d0 : 'delete-booking-record', id : _this.data('id')};
            $bkGet(data, function(rp){
                var r = $.parseJSON(rp);                
                if(r.result){
                    _this.parent().parent().remove();
                }
            });
        });
    };

    let selectedBookingArg = null;
    $.bookingClickDialog = function(theID, viewOnly){
        isDialogInitialized = 0;
        boDialog.wrapper.mfpPopup(boDialog, function(){
            boDialog.wrapper.find('.tab-title').text('{LANG_BOOKING} {LANG_INFORMATION}');
            var data = {m : boConfigParams.ajxAction, d0 : 'edit-booking-dialog', id : theID, viewOnly : viewOnly};            
            $bkGet(data, function(rp){
                boDialog.contentWrapper.html(rp).removeClass('loading');                
                setTimeout(function(){
                    if($.bookingDialogInitCallback) $.bookingDialogInitCallback();
                }, 100);
            });
        });
    };

    $.paginationClick = function(){
        $('ul.pagination>li>a').click(function(){
            if(typeof($(this).data('page'))=="undefined") return;            
            var data = {
                m   :   'reservation',
                d0  :   'search-reservation',
                page : $(this).data('page')
            };
            $bkGet(data, function(rp){
                $('.resv-wrapper').html(rp);
                $.rowActions();
                $.paginationClick();
            });            
        });
    };
</script>
</body>
</html>