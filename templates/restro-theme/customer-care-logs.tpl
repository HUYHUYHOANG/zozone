{OVERALL_HEADER}
<style>    
    .dropdown-header{padding:10px !important;font-size:16px;font-weight: 600;}
    #customr-care-logs td.date-time{
        white-space:nowrap;
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
                <h3>{LANG_BO_MENU_CUSTOMER_CARE}</h3>
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
                            IF("{READONLY_PERMISSION}"!="1"){
                            <a href="#" class="button ripple-effect button-sliding-icon margin-left-auto" id="ccl-send-email">{LANG_SEND_EMAIL} <i class="icon-feather-send"></i></a>
                            <a href="javascript:void(0);" class="button ripple-effect button-sliding-icon margin-left-auto" id="clear-all-ccl-data">{LANG_CLEAR} <i class="icon-feather-calendar"></i></a>
                            {:IF}
                            <a href="javascript:void(0);" class="button ripple-effect button-sliding-icon margin-left-auto" id="ccl-add-ad-item">{LANG_ADD} <i class="icon-feather-plus"></i></a>
                        </div>
                        <div class="dashboard-box margin-top-0 content with-padding padding-bottom-10">
                            <div class="row main-box-in-row col-xl-12">
                                <div class="col-xl-12 col-lg-12 col-sm-12 headline">                                    
                                    <div class="col-xl-3 input-with-icon-left" style="margin-top:16px;">
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
                                        <button class="btn-search button" id="ccl-search"><i class="icon-feather-search"></i></button>
                                    </div>
                                </div><!--end headline-->
                                
                                <!--data table container-->
                                <div class="col-xl-12 col-lg-12 col-sm-12">
                                    <div class="ccl-data-wrap table-responsive-xl">
                                        {LIST_LOGS_DATA}
                                    </div>
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

<div id="view-log-item" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
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

<script src="{SITE_URL}templates/{TPL_NAME}/js/slick.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/jquery.cookie.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/user-ajax.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/custom.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/svg.js?ver={VERSION}"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!--custom js files-->
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/codec.min.php?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/shop-util.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/js/moment.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/js/bootstrap-datetimepicker.min.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>

<script>
    var readOnly = {READONLY_PERMISSION};
    var boDialog = { wrapper : $('#view-log-item'), contentWrapper : $('.popup-tabs-container') };
    boConfigParams = $.extend({selectedStatus : [], ajxAction : 'customer-care-log', defaultView : 'load-the-logs'}, boConfigParams);        
    boConfigParams.boSvrSide = '{SITE_URL}php/ctrls/bo/?{USER_AUTH_STRING}&m=' + boConfigParams.ajxAction + '&d0=save-log-item-details';

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

        var d = new Date();        
        $('#ccl-from-date-search').datetimepicker({
            locale: '{LANG_LOCALE}',
            format: 'MM-DD-YYYY',
            /*date : moment().subtract(30,'days').format('MM-DD-YYYY')*/

        }).on('dp.show', function(e){
            $('.bootstrap-datetimepicker-widget th').click(function(){
                var btn = $(this);                
            });
        });

        $.clearAllCCLData();
        $.addAnCCLItem();
        $initSelectPicker();
        $searchClick();
        $paginationClick();
        $rowActionsClick();
        $sendEmailModal();
    });

    $initSelectPicker = function(){
        $('.selectpicker').selectpicker({title: '{LANG_STATUS}',}).selectpicker('render')
        .on('change', function(){
            boConfigParams.selectedStatus = [];
            $(this).find('option:selected').each(function(){
                boConfigParams.selectedStatus.push($(this).val());
            });	
        });
    };

    $searchClick = function(){
        $('.btn-search').click(function(){
            var dr = $('#ccl-from-date-search').val();            
            var data = {
                m   :   boConfigParams.ajxAction,
                d0  :   boConfigParams.defaultView,
                customer : CStr.trim($('#ccl-customer').val()),
                std :   dr,
                status : boConfigParams.selectedStatus.toString(),                
                page : -1
            };
            $('.ccl-data-wrap').addClass('loading').html('');
            $bkGet(data, function(rp){
                
                $('.ccl-data-wrap').removeClass('loading').html(rp);
                $paginationClick();
                $rowActionsClick();
            });
        });
    };

    $paginationClick = function(){
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
        $('.ccl-action-button-wrap>a').click(function(){
            var action =  $(this).data('action');
            var theID =  $(this).parent().data('id');
            if(action=='delete') $deleteItem($(this), theID);
            else if(action=='check') $setItemDone($(this), theID); 
            else if(action=='view'||action=='edit') $viewLogItemPopup($(this), theID, action);
        });
    };

    $setItemDone = function(obj, theID){
        swal({                
                text: "Change status of the record?",
                icon: "warning", 
                buttons: true
            }).then((letGo) => {
                if(!letGo) return;
                var data = {m : boConfigParams.ajxAction, d0 : 'set-item-state-done', item : theID};
                $bkGet(data, function(rp){                    
                    obj.parent().find('a[data-action="edit"]').remove();
                    obj.parent().find('a[data-action="delete"]').remove();
                    obj.remove();
                    var row = $('#rw-' + theID);
                    row.find('td[role="status"]').children().removeClass('btn-warning').addClass('btn-success').text('{LANG_DONE}');
                });   
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
                        $reloadListOrderCol();
                    });
                }
            });
    };

    $reloadListOrderCol = function(){
        var index = 1;
        $('#customr-care-logs>tbody>tr').each(function(){
            $(this).children().first().text(index++);
        });
    };

    $viewLogItemPopup = function(obj, theID, action){
        boDialog.wrapper.mfpPopup(boDialog, function(){
            var data = {m:boConfigParams.ajxAction, d0:'load-log-item-details', view : action, item : theID};
            $bkGet(data, function(rp){
                boDialog.contentWrapper.html(rp).removeClass('loading');                
                $initItemDetailsModal();
            });
        });
    };
    

    $initItemDetailsModal = function(){        
        $('#contact-date').on('paste', function(e){
            e.preventDefault(); return false;
        }).datetimepicker({            
            locale: '{LANG_LOCALE}',
            format: 'MM-DD-YYYY hh:mm A'
        });
        $('#ccl-item-detail-form .selectpicker').selectpicker({title: '{LANG_SELECT}',})
        .selectpicker('render').change(function(){
            var theid = $(this).prop('id');            
            if(theid == "service_ids"){
                var aitems = [];
                $(this).find('option').each(function(){
                    if($(this).prop('selected')) aitems.push($(this).val());
                });
                $('input[name="service_ids"]').val(aitems.toString());
            }else if(theid == "cust-id"){                
                var theClient = $(this).find(":selected");                
                $('#phone').val(theClient.data('phone'));
                $('#email').val(theClient.data('email'));
            }
        });

        $('#ccl-form-close').click(function(){
            $.magnificPopup.close();
        });
        $('textarea').on('keyup keypress', function() {
            $(this).height(0);
            $(this).height((this.scrollHeight>140 ? 140:this.scrollHeight) - 20);
        });
        
        $('#ccl-item-detail-form').submit(function(){            
            try{
                var $form = $(this);
                var surl = boConfigParams.boSvrSide;                
                var themsg = $('#form-submit-msg');
                $form.find('button').addClass('disabled').prop('disabled', true);
                $('#ptkn').val($('#ptkn').data('challenge').decode());                
                $.post(surl, $form.serialize(), function(rp){                    
                    try{
                        var r = $.parseJSON(rp);
                        if(r.error==0){                            
                            themsg.text(themsg.data('success')).addClass('success').removeClass('error');
                            $('.btn-search').trigger('click');
                        }else{
                            if(r.text.length) themsg.text(r.text);
                            else themsg.text(themsg.data('error'));
                            themsg.addClass('error').removeClass('success');
                            $('input[name="'+r.field+'"]').hilite(1);
                        }
                        themsg.slideDown();
                    }catch(e){}
                    $form.find('button').removeClass('disabled').prop('disabled', false);
                    setTimeout(function(){
                        themsg.slideUp();
                        if(r.error==0) $.magnificPopup.close();
                    }, 2000);
                });
            }catch(e){console.log(e.message);}
            return false;
        });
    }/*end item popup*/;

    $.clearAllCCLData = function(){
        $('#clear-all-ccl-data').click(function(){
            swal({                
                text: "{LANG_CLEAR_CCL_DATA}",
                icon: "warning", 
                buttons: true
            }).then((letGo) => {
                if(!letGo) return;
                var data = {m : boConfigParams.ajxAction, d0 : 'clear-all-ccl-data'};
                $bkGet(data, function(rp){
                    var jsn = $.parseJSON(rp);
                    if(!jsn.error){
                        $('#customr-care-logs').remove();
                    }
                });   
            });
        });
    };/* $.clearAllCCLData */
    
    $.addAnCCLItem = function(){        
        $('#ccl-add-ad-item').click(function(){            
            boDialog.wrapper.mfpPopup(boDialog, function(){
                boDialog.wrapper.find('.tab-title').text('{LANG_ADD} {LANG_BO_MENU_CUSTOMER_CARE}');
                var data = {m : boConfigParams.ajxAction, d0 : 'add-customer-care-dialog'};
                $bkGet(data, function(rp){                
                    boDialog.contentWrapper.html(rp).removeClass('loading');
                    $initItemDetailsModal();
                });
            });
        });
    };/*addAnCCLItem*/

    $sendEmailModal = function(){
        $('#ccl-send-email').click(function(){
            boDialog.wrapper.find('.tab-title').text('{LANG_SEND_EMAIL}');
            boDialog.wrapper.mfpPopup(boDialog, function(){
                var data = {m:'mail-list', d0:'load-shop-maillist-option'};
                $bkGet(data, function(rp){
                    boDialog.contentWrapper.html(rp).removeClass('loading');
                    
                });
            });
        });        
    };
</script>
</body>
</html>