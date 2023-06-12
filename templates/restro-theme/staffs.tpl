{OVERALL_HEADER}
<style>    
    button.btn-search{
        position:relative;
        top:-8px;
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
                <h3>{LANG_BO_MENU_STAFFS}</h3>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="{LINK_INDEX}">{LANG_HOME}</a></li>
                        <li>{LANG_BO_MENU_STAFFS}</li>
                    </ul>
                </nav>
            </div>

            <!-- BEGIN CONTENT -->
            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="margin-top-0">                      
                        <div class="right-toolbox menu-button">
                            <!--<a href="javascript:void(0);" class="button ripple-effect button-sliding-icon margin-left-auto" id="btnCustGroups">{LANG_GROUPS} <i class="icon-feather-users"></i></a>-->
                            <a href="./staffs?d0=add-staff" class="button ripple-effect button-sliding-icon margin-left-auto" id="btnAddstaff">{LANG_ADD} {LANG_STAFF} <i class="icon-feather-user-plus"></i></a>                            
                        </div>
                        <div class="dashboard-box margin-top-0 content with-padding padding-bottom-10" style="margin-right:0;padding-right:0;">
                            <div class="row main-box-in-row col-xl-12">
                                <div class="col-xl-12 col-lg-12 col-sm-12 headline" style="margin-top:16px;margin-right:0;padding-right:0;">
                                    <div class="col-xl-3 input-with-icon-left">
                                        <i class="icon-feather-search"></i>                                            
                                        <input type="text" class="with-border form-control" id="txtSearch" placeholder="{LANG_NAME}/{LANG_PHONE}/Email">
                                    </div>                                    
                                    <div class="col-xl-2">
                                        <button class="btn-search button" id="ccl-search"><i class="icon-feather-search"></i></button>
                                    </div>
                                    <div class="col-xl-7 text-right right-cmds">
                                        <!--<a class="button" id="btnPrint" href="#" target="_blank"><i class="icon-feather-printer"></i> {LANG_PRINT}</a>
                                        <button class="button" id="btnCSV"><i class="icon-feather-file"></i> CSV</button>=-->
                                    </div>
                                </div><!--end headline-->
                                
                                <!--data table container-->
                                <div class="col-xl-12 col-lg-12 col-sm-12">
                                    <div class="staffs-data-wrap table-responsive-xl"></div>
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
<script src="{SITE_URL}templates/{TPL_NAME}/js/sweetalert.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/shop-util.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/js/moment.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/js/bootstrap-datetimepicker.min.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>

<script type="text/javascript">
    boConfigParams = $.extend({selectedStatus : [], ajxAction : 'staffs', defaultView : 'load-staffs'}, boConfigParams);    
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

        $.search();
        $.loadstaffs();
        $.staffGroups();
        $.export();
        $.printTheList();
    });

    $.search = function(){
        $('#txtSearch').focus().keydown(function(e){
            if(e.which==13){
                var v = CStr.trim($(this).val());
                $.loadstaffs(v);
            }
        });
        $('.btn-search').click(function(){
            $.loadstaffs($('#txtSearch').val().trim());
        });
    };

    $.loadstaffs = function(v){
        var data = {
                m   :   boConfigParams.ajxAction,
                d0  :   boConfigParams.defaultView,
                staff : v,
                page : -1
            };
            $('.staffs-data-wrap').html('').addClass('loading');
            $bkGet(data, function(rp){                
                $('.staffs-data-wrap').removeClass('loading').html(rp);
                $.rowActions();
                $.paginationClick();                
            }); 
    };

    $.paginationClick = function(){
        $('ul.pagination>li>a').click(function(){
            if(typeof($(this).data('page'))=="undefined") return;            
            var data = {
                m   :   boConfigParams.ajxAction,
                d0  :   boConfigParams.defaultView,
                page : $(this).data('page')
            };
            $bkGet(data, function(rp){                
                $('.staffs-data-wrap').html(rp);
                $.paginationClick();
                $.rowActions();
            });            
        });
    };
    
    $.staffGroups = function(){
        $('#btnCustGroups').click(function(){
            $.magnificPopup.open({
                items: {
                    src: '#dlgWrapper',
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
                        $('.popup-tabs-container').html('').addClass('loading');
                    },
                    open : function(){
                        $('.popup-tabs-container').addClass('loading');
                        var data = {m:boConfigParams.ajxAction, d0:'staff-groups'};
                        $bkGet(data, function(rp){
                            $('.popup-tabs-container').removeClass('loading').
                            slideDown('slow', function(){ 
                                $(this).html(rp);
                                $('#group_name').focus();
                                $.initStaffGroupDlg(); 
                            });
                        });
                    }
                }
            });
        })/*click;*/
    };

    $.staffGroupChanged = function(id){
        var data = {m:boConfigParams.ajxAction, d0:'group-data', gid : id};        
        $('.selectpicker').prop('disabled',true).addClass('disabled');
        $bkGet(data, function(rp){            
            var r = $.parseJSON(rp);
            $('#group_name').val(r.name).focus();
            $('#commission').val(r.commission);
            $('#position').val(r.position);            
            $('#group_active').val(r.active);            

            if(r.active==0 && $('#cust_active').prop('checked')){
                $('#group_active').trigger('click');                
            }
            else{
                $('#group_active').val(r.active).prop('checked', r.active==1 ? true : false).click(function(){
                    $(this).val(($(this).val()+1)%2);
                });
            }
            $('.selectpicker').prop('disabled',false).removeClass('disabled');
            $('#btnDelete').disableMe(r.removable==1 ? 0:1);
        });
    };/*staffGroupChanged*/

    $.staffGroupSubmit = function(frm){
        var gname = CStr.trim($('#group_name').val());
        if(!gname.length){
            $('#group_name').hilite(1); return false;
        }
        var data = {
                m:boConfigParams.ajxAction, d0:'save-group-data', 
                gid : $('#group_id').val(),
                name : gname, commission : $('#commission').val(), position : $('#position').val(),
                active : $('#group_active').prop('checked')?1:0
        };
        frm.disableForm(true);
        $bkGet(data, function(rp){
            var r = $.parseJSON(rp);            
            if(data.gid <= 0){                
                if(r.result > 0){  

                    $('#group_id').append('<option data-subtext="<i class=\'icon-feather-users\'></i> 0" selected value="' + r.result + '">' + data.name + '</option>');
                    $('.selectpicker').selectpicker('refresh');
                }
            }else{
                $('#group_id').find(':selected').text(data.name);
                $('.selectpicker').selectpicker('refresh');
            }
            frm.disableForm(false);
        });
        return false;
    };/*staffGroupSubmit*/

    $.deleteGroup = function(){
        swal({                
                text: "{LANG_DELETE_THE_SELECTED_RECORD}",
                icon: "warning", 
                buttons: true
            }).then((letGo) => {
                if(!letGo) return;
                var data = {m : boConfigParams.ajxAction, d0 : 'delete-the-group', id : $('#group_id').val()};

                $('#frmgroup').disableForm(true);
                $bkGet(data, function(rp){                    
                    var r = $.parseJSON(rp);
                    if(r.ret!=0){
                        $('#btnDelete').disableMe(1);
                        $('#group_id').find('option:selected').remove().val(0);
                        $('.selectpicker').selectpicker('refresh');
                        $('#frmgroup').find('input,textarea').each(function(){
                            $(this).val('');
                        });
                    }
                    $('#frmgroup').disableForm(false);
                });   
            });
    };/*deleteGroup*/

    $.initStaffGroupDlg = function(){
        $('#btnClose').click(function(){ $.magnificPopup.close(); });
        $('#btnDelete').click(function(){ $.deleteGroup(); });
        $('.selectpicker').selectpicker({title: '',})
        .selectpicker('render').change(function(){
            $.staffGroupChanged($(this).val());            
        });
        /*$('textarea').autoHeight();*/
        $('input.number').numericInput();
        $('.mfp-container,.mfp-content').preventBgClose();
        $('#frmgroup').submit(function(){
            return $.staffGroupSubmit($(this));
        });
    };

    $.export = function(){
        $('#btnCSV').click(function(){
            var ts = new Date().getTime();
            var s = './' + boConfigParams.ajxAction + '?{USER_AUTH_STRING}='+ts+'&d0=csv-export&t='+ (ts);
            document.location.href = s;
        });
    };
    $.printTheList = function(){
        $('#btnPrint').click(function(){  
            var ts = new Date().getTime();          
            var s = './' + boConfigParams.ajxAction + '?{USER_AUTH_STRING}='+ts+'&d0=printable-staffs-list&t='+ (ts);
            $(this).prop('href', s);
        });
    };

    $.rowActions = function(){        
        $('a.cust-delete').click(function(){
            var cid = $(this).data('id');
            $(this).confirm('{LANG_DELETE_THE_SELECTED_STAFF}', function(obj){
                var data = {m : boConfigParams.ajxAction, d0 : 'delete-the-staff', id : cid};
                obj.addClass('ajxloading');
                $bkGet(data, function(rp){                    
                    var r = $.parseJSON(rp);
                    obj.removeClass('ajxloading');
                    if(r.ret==true){
                        obj.parent().parent().remove();
                    }
                });
            });
        });
    };/*rowActions*/

    $.initStaffDlg = function(){
        $('#btnClose').click(function() { $.magnificPopup.close(); });
        $('.selectpicker').selectpicker({title: '',})
        .selectpicker('render').change(function(){
            
        });

        $('#cust-dob').datetimepicker({            
            locale: '{LANG_LOCALE}',
            format: 'MM-DD-YYYY',
            date : '01-01-2000',
            minDate : '01-01-1950',
            maxDate : moment()
        });
    };/* $.initstaffDlg */
</script>
</body>
</html>