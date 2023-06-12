{OVERALL_HEADER}
<style>    
    button{min-width: 150px;}
    .bootstrap-select{
        border: 1px solid #e0e0e0 !important;
        border-radius: 4px;
        box-shadow: 0 1px 4px 0 rgb(0 0 0 / 5%) !important;
    } 
    .bootstrap-select.input-error{
        border:1px solid #F00 !important;
    }
    span.status-not-available{display: none !important;position:absolute;width:96%;top:70%;padding:0px 0;}
    span.status-not-available.open{display: block !important;}
    #password-status .status-not-available{width: 98%;}
    .save-result-msg{display: none;}
    .bootstrap-select.open .dropdown-menu{
        max-height: 250px !important;
    }

    .input-file{position:relative;}
    .uploadButton{position:absolute;left:2px;bottom:-8px;}
    .uploadButton-button{background-color:var(--classic-color-1) !important;color:#Fff !important;}
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
                <h3>{LANG_EDIT} {LANG_STAFF}</h3>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="{LINK_INDEX}">{LANG_HOME}</a></li>
                        <li>{LANG_EDIT} {LANG_STAFF}</li>
                    </ul>
                </nav>
            </div>

            <!-- BEGIN CONTENT -->
            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box">                        
                        <div class="col-xl-12 col-sm-12">
                            <div class="row headline">
                                <div class="col-xl-3 col-sm-3">
                                    <h3><i class="la la-user"></i> {THE_STAFF_NAME}</h3>
                                </div>
                                <div class="col-xl-9 col-sm-9">
                                    <div class="right-toolbox menu-button">
                                        <a class="button disabled margin-left-auto" id="btnNewReservations">{LANG_INFORMATION} <i class="icon-feather-user"></i></a>
                                        <a href="./staffs?d0=reservations&id={THE_STAFF_ID}&t=new" class="button ripple-effect button-sliding-icon margin-left-auto" id="btnNewReservations">{LANG_CUSTOMER_NEW_RESERVATIONS} <i class="icon-feather-calendar"></i></a>
                                        <a href="./staffs?d0=reservations&id={THE_STAFF_ID}&t=past" class="button ripple-effect button-sliding-icon margin-left-auto" id="btnPastReservations">{LANG_CUSTOMER_PAST_RESERVATIONS} <i class="icon-feather-calendar"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content">
                            <div class="content with-padding staffs-data-wrap"><!--form content here --></div>
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
<script src="{SITE_URL}templates/{TPL_NAME}/js/jquery.mask.js"></script>

<script src="{SITE_URL}templates/{TPL_NAME}/js/sweetalert.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/shop-util.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/js/moment.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/js/bootstrap-datetimepicker.min.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/codec.min.php"></script>

<script type="text/javascript">
    boConfigParams = $.extend({theID : {THE_STAFF_ID}, secretChanged : 0, selectedStatus : [], ajxAction : 'staffs', defaultView : 'load-staffs'}, boConfigParams);    
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
        $.loadStaffForm();
    });
    
    $.loadStaffForm = function(){
        var data = {
            m   :   boConfigParams.ajxAction,
            d0  :   'edit-staff-form',
            staff : boConfigParams.theID
        };
        $('.staffs-data-wrap').html('').addClass('loading');
        $bkGet(data, function(rp){
            $('.staffs-data-wrap').removeClass('loading').html(rp);
            $.initStaffControls();
        }); 
    };
    $.initStaffControls = function(){        
        $('#phone').mask('000 0000 0000 0000');
        $('#zip_code').mask('00000');

        $('#email').emailInput(function(_this, ret){
            var span = $('#email-status').children();
            if(!ret){
                span.text(span.data('default-text'));
                $('#email-status').showInputMessage();
            }else{
                /*check if email is already exists*/
                var data = {
                    m   :   boConfigParams.ajxAction,
                    d0  :   'find-staff-by-email',
                    email : _this.val().encode()
                };
                _this.prop('disabled',true).addClass('disabled');
                $bkGet(data, function(rp){                          
                    _this.prop('disabled',false).removeClass('disabled');
                    try{                        
                        var r = $.parseJSON(rp);
                        if(r.result>0 && boConfigParams.theID!=r.result){
                            _this.data('error',1);
                            span.text(span.data('exist'));
                            $('#email-status').showInputMessage();
                        }else _this.data('error','');
                    }catch(e){}
                }); 
            }
        });
        $('#username').uidInput(function(_this, ret){
            var span = $('#user-status').children();
            if(!ret) $('#user-status').showInputMessage();
            else{
                /*check if UID is already exists*/
                var data = {
                    m   :   boConfigParams.ajxAction,
                    d0  :   'find-staff-by-uid',
                    uid : _this.val().encode()
                };
                _this.prop('disabled',true).addClass('disabled');
                $bkGet(data, function(rp){                    
                    _this.prop('disabled',false).removeClass('disabled');
                    try{
                        var r = $.parseJSON(rp);
                        if(r.result>0 && boConfigParams.theID!=r.result){
                            _this.data('error',1);
                            span.text(span.data('exists'));
                            $('#user-status').showInputMessage();
                        }else _this.data('error','');
                    }catch(e){}
                }); 
            }
        });
        $('.pwd').change(function(){
            boConfigParams.secretChanged = 1;
        }).pwdInput(function(_this, ret){            
            var span = $('#password-status').children();                
            if(!ret){                
                if(_this.prop('id')=='pwd'){
                    span.text(span.data('default-text'));                    
                }
                $('#password-status').showInputMessage();
            }else{
                if($('#pwd').val() != $('#pwd-retype').val()){                    
                    span.text(span.data('not-match'));
                    $('#password-status').showInputMessage();
                    $('#pwd-retype').hilite(1);
                }
            }
            
        });
        
        $('.selectpicker').selectpicker({title: '',})
        .selectpicker('render').change(function(){
            var agroups = [];
            $('#svc_gids option:selected').each(function(){
                agroups.push([$(this).val()]);
            });
            $('#spec_ids').val(agroups.toString());
        });

        $('#name').focus();
        $('#frmStaff').submit(function(e){
            $.staffformSubmit(this);
            return false;
        });
    };

    $.staffformSubmit = function(_form){        
        var theform = $(_form);

        /*var services = $('#spec_ids').val();        
        
        if(!services.length){
            $('.lblServiceGroup').selectPickerError();
            setTimeout(function(){
                $('.lblStaffGroup').next().children('button').focus();
            }, 1000);
            return false;
        }*/

        var cname = $('#name').val().trim();
        if(!cname.length){
            $('#name').hilite(1);
            return false;
        }
        
        /*var group = $('#group_id').val();
        if(!group.length){
            $('#name').focus();
            $('.lblStaffGroup').selectPickerError(1);
            setTimeout(function(){
                $('.lblStaffGroup').next().children('button').focus();
            }, 100);
            return false;
        }*/

        if(!$('#email').val().isEmail()){
            $('#email').blur().hilite(1);
            return false;
        }
        
        if($('#email').data('error')==1){            
            span = $('#email-status').children();
            span.text(span.data('exists')).parent().showInputMessage();
            $('#email').hilite(1);
            return false;
        }

        if(!$('#username').val().isZozoneUid()){
            $('#username').hilite(1); return false;
        }        
        if($('#username').data('error')==1){
            $('#username').hilite(1);
            span = $('#user-status').children();            
            span.text(span.data('exists')).parent().showInputMessage();
            return false;
        }
        
        if($('#pwd').val().length && !$('#pwd').val().isZozonePwd()){
            $('#pwd').hilite(1); return false;
        }
        if($('#pwd').val() != $('#pwd-retype').val()){
            var span = $('#password-status').children('span');
            span.text(span.data('not-match'));
            $('#password-status').showInputMessage();
            $('#pwd-retype').hilite(1); return false;
        }

        /*encode the pwd */
        if(boConfigParams.secretChanged){            
            $('#secret').val($('#pwd').val().encode());            
        }
        
        /*decode the challenge*/
        if($('#ptkn').data('change') !='y'){
            $('#ptkn').val($('#ptkn').data('challenge').decode()).data('change','y');
        }
        $('button[type="submit"]').addClass('ajxloading').removeClass('button-sliding-icon');
        var data = new FormData(_form);
        var request;        
        try{
            request = $.ajax({
                type: "POST",
                url: theform.prop('action'),
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json'
            });

            /*$.post(theform.prop('action'), data, function(rp, status){*/
            request.done(function(r, textStatus, jqXHR){
                    $('button[type="submit"]').removeClass('ajxloading').addClass('button-sliding-icon');                
                    try{                        
                        if(r.error==1){                        
                            if(r.field != undefined){                            
                                $.submitErrorMsg(r.field, r.text);
                            }
                            $('.save-result-msg').slideDown().find('span').text($('.save-result-msg').data('error'));
                        }else{
                            $('.save-result-msg').slideDown().find('span').text($('.save-result-msg').data('success'));                        
                        }
                        setTimeout(function(){
                            $('.save-result-msg').slideUp();
                            if(!r.error) document.location = './staffs';
                        }, 2000);
                    }catch(e){
                        console.log(e.message);
                    }
                }
            );
            request.always(function(x){            
                $('button[type="submit"]').removeClass('ajxloading').addClass('button-sliding-icon');
            });
        }catch(e){console.log(e.message);}
        return false;
    };/*submit*/

    $.submitErrorMsg = function(field, text){
        var elm = null, fc = field;
        switch(field){
            case 'email':
                elm = $('#email-status');
                break;
            case 'username':
                elm = $('#user-status');
                break;
            case 'secret':
                elm = $('#password-status'); fc = 'pwd';
                break;
            case 'spec_ids':
                $('.lblServiceGroup').selectPickerError(1);
                setTimeout(function(){
                    $('.lblServiceGroup').next().children('button').focus();
                }, 100);
                return;
        }

        $('#' + fc).hilite(1);
        if(elm){            
            elm.children().text(text);
            elm.showInputMessage();
        }
    };
</script>
</body>
</html>