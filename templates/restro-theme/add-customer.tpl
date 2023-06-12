{OVERALL_HEADER}
<style>
    button:disabled{cursor:default;}
    
    .status-not-available{display:none !important;position:absolute;z-index:100;top:70%;}
    .status-not-available.open{display: block !important;}
    .switch-wrapper{
        text-align: right;
    }
    .switch-container{
        margin-left:10px;position:relative;float:right;bottom:5px;
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
                <h3>{LANG_BO_MENU_ADD_CUSTOMER}</h3>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="{LINK_INDEX}">{LANG_HOME}</a></li>
                        <li>{LANG_BO_MENU_CUSTOMERS}</li>
                    </ul>
                </nav>
            </div>

            <!-- BEGIN CONTENT -->
            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="margin-top-0">
                        <div class="row">
                            <!--form container-->                            
                            <div class="col-xl-8 col-lg-8 col-sm-8 dashboard-box content">
                                <div class="customers-data-wrap table-responsive-xl"></div>
                            </div>
                            <!--form  container-->
                            <div class="col-xl-2 col-lg-2 col-sm-2"></div>
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
<script src="{SITE_URL}templates/{TPL_NAME}/js/sweetalert.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/shop-util.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/js/moment.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/js/bootstrap-datetimepicker.min.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/codec.min.php"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/jquery.mask.js"></script>

<script type="text/javascript">
    boConfigParams = $.extend({selectedStatus : [], ajxAction : 'customers', defaultView : 'load-customers'}, boConfigParams);    
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
        $.loadCustomerForm();
    });
    
    $.loadCustomerForm = function(){
        var data = {
                m   :   boConfigParams.ajxAction,
                d0  :   'add-customer-form'
            };
            $('.customers-data-wrap').html('').addClass('loading');
            $bkGet(data, function(rp){
                $('.customers-data-wrap').removeClass('loading').html(rp);
                $.initCustomerControls();
            }); 
    };

    String.prototype.isDate = function(){
        var s = this;
        var a = s.split('-');
        if(a.length==3){
            var m = parseInt(a[0]);
            var d = parseInt(a[1]);
            var y = parseInt(a[2]);
            if(isNaN(m) || isNaN(d) || isNaN(y)) return 0;
            if(m>12 || d>31) return 0;
            var toDate = new Date();            
            if(y >= toDate.getFullYear()-10){
                console.log('less than 10 years');
                return 0;
            }
            
            if([1,3,5,7,8,10,12].includes(m)){
                return d <= 31;
            }else if([4,6,9,11].includes(m)){
                return d <= 30;
            }else{
                return (!(y % 4) && y % 100) || !(y % 400) ? d<=29 : d <= 28
            }
            return 1;
        }
        return 0;
    };
        
    $.initCustomerControls = function(){
        $('#cust-phone').mask('000 0000 0000 0000');
        $('#whatsapp_nbr').mask('000 0000 0000 0000');
        
        $('#cust-dob').mask('00-00-0000').change(function(){
            var date = $(this).val();
            if(!date.isDate()) {
                $(this).hilite(1);
            }
        }).val($('#cust-dob').data('value'));

        $('.selectpicker').selectpicker({title: '',})
        .selectpicker('render').change(function(){            
        });

        $('#email').emailInput(function(_this, ret){            
            var span = $('#email-status').children();            
            if(!ret){
                span.text(span.data('invalid'));                
                $('#email-status').showInputMessage();
            }else{
                /*check if email is already exists*/
                var data = {
                    m   :   boConfigParams.ajxAction,
                    d0  :   'find-customer-by-email',
                    email : _this.val().encode()
                };
                _this.prop('disabled',true).addClass('disabled');
                $bkGet(data, function(rp){                          
                    _this.prop('disabled',false).removeClass('disabled');                    
                    try{
                        var r = $.parseJSON(rp);
                        if(r.result>0){
                            _this.data('error',1);
                            span.text(span.data('exist'));
                            $('#email-status').showInputMessage();
                        }else _this.data('error','');
                    }catch(e){}
                }); 
            }
        });

        $('#cust_name').focus();
        $('textarea').autoHeight();

        $('#frmCustomer').submit(function(e){
            var cname = CStr.trim($('#cust-name').val());
            if(!cname.length){
                $('#cust-name').hilite(1);
                return false;
            }
            var group = $('#group_id').val();
            if(!group.length){
                $('#lbl-cust-group').selectPickerError(1);
                $('#cust-dob').focus(); setTimeout(function(){$('#cust-dob').blur();}, 200);
                return false;
            }
            /*decode the challenge*/
            try{
                if($('#ptkn').data('change') !='y'){
                    $('#ptkn').val($('#ptkn').data('challenge').decode()).data('change','y');
                }            
            }catch(e){
                console.log(e.message);
            }

            $('button[type="submit"]').addClass('ajxloading');
            $('#frmCustomer button').prop('disabled', false);
            theform = $(this);          
            var msg = $('label.save-result-msg').slideDown().text('{LANG_UPDATING}');  
            $.post(theform.prop('action'), theform.serialize(), 
                function(rp, status){
                    console.log(rp);
                    try{
                        var rs = $.parseJSON(rp);                        
                        if(rs.error==0){                            
                            msg.addClass('text-success').removeClass('text-danger').text(msg.data('success'));                            
                        }
                        else{                            
                            msg.addClass('text-danger').removeClass('text-success');
                            if(!rs.field.length) msg.text(msg.data('error'));
                            else{
                                msg.text(rs.text);
                                $('#' + rs.field).hilite();
                            }                            
                        }
                        msg.slideDown();
                        setTimeout(function(){
                            msg.slideUp();
                            if(rs.error==0) document.location='./customers';
                        }, 2030);
                    }catch(e){}
                    $('button[type="submit"]').removeClass('ajxloading');
                    $('#frmCustomer button').prop('disabled', false);                    
                }).fail(function(x){                    
                    $('button[type="submit"]').removeClass('ajxloading');
                    $('#frmCustomer button').prop('disabled', false);
                }
            );/*submit*/
            
            return false;
        });
    };/* $.initCustomerControls */
</script>
</body>
</html>