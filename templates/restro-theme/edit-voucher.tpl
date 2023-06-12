{OVERALL_HEADER}
<style>
    .vouchers-data-wrap{margin:15px 0 0 15px;}
    #frmVoucher button.form-cmd{min-width: 120px;}    
    tr.expired td{
        background-color:#FCFCFC !important;
    }
    
    .btn-outline-secondary{
        border:1px solid #e0e0e0;outline: none;
    }
    .btn-outline-secondary:hover{
        color:#a0a0a0;
        background-color: #f8f8f8;
        border:1px solid #e0e0e0;
    }
    .btn-outline-secondary:focus, .btn-outline-secondary:active, .btn-outline-secondary.dropdown-toggle:focus{
        box-shadow: none !important;
    }
    .voucher-value .dropdown-menu{
        max-width: 100px;
        min-width: 1%;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        padding-top: 0;
        padding-bottom:0;
    }
    .voucher-value .dropdown-item{padding-left:10px;padding-right:10px;}
    
    .bootstrap-autocomplete .dropdown-item.active, .bootstrap-autocomplete  .dropdown-item:active{
        background-color: #e0e0e0;
    }
    
    .customer-search-wrap .dropdown-menu.show{
        overflow-y: auto;
        max-height: 300px;
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
                <h3>{LANG_VOUCHERS}</h3>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="{LINK_INDEX}">{LANG_HOME}</a></li>
                        <li>{LANG_VOUCHERS}</li>
                    </ul>
                </nav>
            </div>

            <!-- BEGIN CONTENT -->
            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="margin-top-0">                      
                        <div class="right-toolbox menu-button">                            
                            <!--<a href="./vouchers?d0=add-voucher" class="button ripple-effect button-sliding-icon margin-left-auto" id="btnAddvoucher">{LANG_VOUCHER} <i class="icon-feather-book"></i></a>-->
                        </div>
                        <div class="dashboard-box margin-top-0 content with-padding padding-bottom-10" style="margin-right:0;padding-right:0;">
                            <div class="row main-box-in-row col-xl-12">
                                <div class="col-xl-12 col-lg-12 col-sm-12 headline">                                    
                                </div><!--end headline-->
                                
                                <!--data table container-->
                                <div class="col-xl-12 col-lg-12 col-sm-12">
                                    <div class="vouchers-data-wrap"></div>
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
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap/js/popper.min.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap/js/bootstrap.min.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src='{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap-autocomplete.js'></script>";
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/codec.min.php"></script>

<script type="text/javascript">
    boConfigParams = $.extend({ajxAction : 'vouchers', defaultView : 'load-voucher', vid : "{THE_VOUCHER_ID}"}, boConfigParams);    
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

        $.getVoucher();        
    });
    
    $.getVoucher = function(page){
        var data = {
                m   :   boConfigParams.ajxAction,
                d0  :   boConfigParams.defaultView,
                id  :   boConfigParams.vid
            };
        $('.vouchers-data-wrap').html('').addClass('loading');
        $bkGet(data, function(rp){
            $('.vouchers-data-wrap').removeClass('loading').html(rp);
            setTimeout(function(){
                $.voucherInit();            
                $.autoCompleteInit();
                $('#value').keypress(function(e){
                    var k = e.which;
                    if(k==46 || (k>=48 && k<=57)) return true;
                    return false;
                }).on('paste', function(){ return false; });
            }, 500);            
        }); 
    };

    $.hightlightText = function(result, querystr){
        reg = new RegExp(querystr, 'gi');       
        return result.replace(reg, function(str) {return '<b>'+str+'</b>'});        
    };

    $.autoCompleteInit = function(){
        $('#cust_name').autoComplete({
            minLength:1,
            resolver: 'custom',
            formatResult: function (item) {                
                return {
                    value: item.id,
                    text: item.text,
                    html: [ 
                            '', ' ',
                            '<span data-id="' + item.id + '">' + item.highLightText + '</span>' 
                        ] 
                };
            },
            events: {
                search: function (qry, callback) {
                    var data = { m : 'customers' , d0 : 'find-customers', qry : qry };                    
                    /*console.log(boConfigParams.boSvrSide);*/
                    $bkGet(data, function(rp){
                        var res = $.parseJSON(rp);
                        res.results.forEach(function(item, index){                            
                            item.highLightText = $.hightlightText(item.text, qry);
                        });
                        callback(res.results);
                    });
                }/*search*/
            }/*events*/
        }).keydown(function(e){
            if(e.which==13) return false;
        }).on('autocomplete.select', function(e, item){
            $('#cust_id').val(item.id);
        }).on('autocomplete.freevalue', function(e, item){
            $(this).val('').data('id', 0);
            $('#cust_id').val(0);
        });
    };

    $.voucherInit = function(){
        var isd = '', expd = '';
        if(!$('#issued_date').val().trim().length){
            isd = moment().format('MM-DD-YYYY');            
            $('#issued_date').val(isd);
        }else isd = $('#issued_date').val();

        if(!$('#expired_date').val().trim().length){
            expd = moment().add(+30,'days');
            $('#expired_date').val(expd);
        } 

        $('.selectpicker').selectpicker();
        $('.dtp').keydown(function(){ return false; }).on('paste',function(e){e.preventDefault();return false;}).datetimepicker({
            locale: '{LANG_LOCALE}',
            format: 'MM-DD-YYYY'
        }).on('dp.show', function(e){
            $('.bootstrap-datetimepicker-widget th').click(function(){
                var btn = $(this);
                console.log(btn.prop('className'));
            });
        });

        $('.voucher-value .value-type').click(function(){
            var tp = $(this).data('type');
            $('.voucher-value .btn-value').text($(this).text());
            $('#value').data('type', $(this).text());
            $('#sale_type').val($(this).data('type'));            
        });

        $('#frmVoucher').submit(function(){
            var theform = $('#frmVoucher');

            /*decode the challenge*/
            if($('#ptkn').data('change') !='y'){
                $('#ptkn').val($('#ptkn').data('challenge').decode()).data('change','y');                
            }

            $('button[type="submit"]').slidingBtnAjaxIcon(true);

            $.post(theform.prop('action'), theform.serialize(), function(rp, status){
                $('button[type="submit"]').slidingBtnAjaxIcon(false);
                    try{
                        var r = $.parseJSON(rp);
                        if(r.error==1){                        
                            if(r.field != undefined){                            
                                $.submitErrorMsg(r.field, r.text);
                            }
                            $('.save-result-msg').removeClass('text-success').addClass('text-danger').slideDown().find('span').text(r.text).prev().removeClass('la-check').addClass('la-exclamation');
                        }else{
                            $('.save-result-msg').removeClass('text-danger').addClass('text-success').slideDown().find('span').text($('.save-result-msg').data('success')).prev().removeClass('la-exclamation').addClass('la-check');
                            if(r.voucherStatus=='in-use' || r.voucherStatus=='used'){
                                document.location.href = "./vouchers";
                            }
                        }
                        setTimeout(function(){
                            $('.save-result-msg').slideUp();
                        }, 3000);
                    }catch(e){
                        $('button[type="submit"]').slidingBtnAjaxIcon(false);                        
                    }                    
                }
            ).fail(function(x){
                console.log(e.message);
                $('button[type="submit"]').removeClass('ajxloading').addClass('button-sliding-icon');                
            });
            return false;
        });

        $('button[type="submit"]').click(function(){
            $(this).prop('disabled', 1);
            setTimeout(function(){
                $('#frmVoucher').trigger('submit');
            }, 200);            
        });
    };/*voucherInit*/
</script>
</body>
</html>