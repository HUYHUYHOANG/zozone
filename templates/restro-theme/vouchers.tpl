{OVERALL_HEADER}
<style>
    .loading{background: none !important;}
    .loading-backdrop{position:absolute;width:100%;height:98%;min-height:40px;background-color:rgba(245,245,245,0.1);left:-2px;z-index:100;display:none;}
    .loading .loading-backdrop{
        display: block;
    }
    .loading-backdrop .loading-circle-icon{
        background:url({SITE_URL}templates/{TPL_NAME}/images/loading.svg.php) no-repeat center top !important;
        height:40px;width:100%;position:relative;bottom:10px;
    }
    
    .ajxloading:disabled{background:#FFF url({SITE_URL}templates/{TPL_NAME}/images/loading.svg.php) no-repeat center center !important;}
    .ajxloading:disabled span, .ajxloading:disabled i{
        visibility: hidden;
    }
    .right-cmd a.button{position: relative;top:-4px;}
    .dashboard-box .bootstrap-select.btn-group {
        top:-8px;    
        border: 1px solid #e0e0e0;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 5%);
        border-radius: 4px;
        padding-top:0px;padding-bottom: 0px;
    }
    .bootstrap-select.btn-group button{
        height: 46px !important;
    }
    tr.expired td{
        background-color:#FCFCFC !important;
    }
    td.voucher-status{text-transform: capitalize;}
    button.search{position: relative;top:-8px;}
    .qrcode-wrap{text-align: center;}
    .qrcode-wrap img{width:70%;height:auto;}
    
    #tblVouchers thead th.sort::after{
        content:'';
        border: solid var(--classic-color-1);
        border-width: 0 3px 3px 0;
        display: inline-block;
        padding: 3px;
        margin-left: 10px;    
    }
    #tblVouchers thead th.sort.desc::after{
      transform: rotate(45deg);
      -webkit-transform: rotate(45deg);
      margin-bottom: 3px;
    }
    #tblVouchers thead th.sort.asc:after{
      transform: rotate(-135deg);
      -webkit-transform: rotate(-135deg);
      margin-top: 3px;
    }
    
    #tblVouchers thead th.sort, #tblVouchers thead th:hover{
        color:var(--classic-color-1);
        cursor: pointer;
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
                            <!-- <a class="button margin-left-auto preview-qr-with-pdf" target="_blank" style="margin-right:6px;" href="./vouchers?{USER_AUTH_STRING}&d0=view-pdf-with-qr-codes"><i class="icon-feather-eye"></i> PDF</a>
                            <a class="button margin-left-auto download-qr-with-pdf" data-viewtype="download" href="javascript:void(0);"><i class="icon-feather-download"></i> {LANG_DOWNLOAD} PDF</a> -->
                            <a href="javascript:void(0);" class="button ripple-effect margin-left-auto" id="btnAddvoucher">{LANG_VOUCHER} <i class="icon-feather-plus"></i></a>
                            <!--<a href="./vouchers?d0=voucher-transaction" class="button ripple-effect button-sliding-icon margin-left-auto" id="btnAddvoucher">{LANG_VOUCHER} History<i class="icon-feather-clock"></i></a>-->
                        </div>
                        <div class="dashboard-box margin-top-0 content with-padding padding-bottom-10">
                            <div class="container main-box-in-row col-xl-12">
                                <div class="row headline">
                                    <div class="col-xl-9 col-lg-12 col-md-12 row">                                        
                                        <div class="col-xl-4 col-md-4 col-sm-12 input-with-icon-left" style="padding-right:0;">
                                            <i class="icon-feather-search"></i>                                            
                                            <input type="text" class="with-border form-control" id="txtSearch" placeholder="{LANG_VOUCHER}/{LANG_CUSTOMER}">
                                        </div>
                                        <div class="col-xl-4 col-md-4 col-sm-12 input-with-icon-left" style="padding-right:0;">
                                            <i class="icon-feather-calendar"></i>
                                            <input type="text" class="with-border search-date-range" data-id="issued" type="text" onkeydown="return false" onpaste="return false" style="padding-left:56px;" placeholder="{LANG_ISSUED_DATE}">
                                        </div>
                                        <div class="col-xl-4 col-md-4 col-sm-12 input-with-icon-left" style="padding-right:0;">
                                            <i class="icon-feather-calendar"></i>
                                            <input type="text" class="with-border search-date-range" data-id="expired" type="text" onkeydown="return false" onpaste="return false" style="padding-left:56px;" placeholder="{LANG_EXPIRED_DATE}">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-12 col-md-12 row">
                                        <div class="col-sm-6 " style="padding-right:0;">
                                            <select class="selectpicker" id="voucher-status">
                                                <option value="">{LANG_ALL}</option>
                                                <option value="ready">{LANG_READY}</option>
                                                <option value="in-use">{LANG_IN_USE}</option>
                                                <option value="used">{LANG_USED}</option>
                                                <option value="expired">{LANG_EXPIRED}</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 text-left search-voucher-wrap">                                        
                                            <button class="button search"><i class="icon-feather-search"></i></button>
                                        </div>
                                    </div>
                                </div><!--end headline-->
                                
                                <!--data table container-->
                                <div class="col-xl-12 col-lg-12 col-sm-12">                                    
                                    <div class="vouchers-data-wrap">
                                        <div class="loading-backdrop">
                                            <div class="loading-circle-icon"></div>
                                        </div>
                                        <div class="data-table-wrap table-responsive-xl"></div>
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

<!--DIALOG TEMPLATE -->
<div id="dlgWrapper" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="log-item-form">
        <ul class="popup-tabs-nav">
            <li class="active"><a class="tab-title">{LANG_VOUCHER}</a></li>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/codec.min.php?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/jquery.mask.js"></script>
<script type="text/javascript">
    var startDate = moment().subtract(1, 'months'), endDate = moment();
    boConfigParams = $.extend({
                                ajxAction : 'vouchers', defaultView : 'load-vouchers',
                                issuedDate : {'start' : startDate, 'end' : endDate},
                                expiredDate : {'start' : moment().startOf('month'), 'end' : moment().endOf('month').add(1, 'months')}
                            }, boConfigParams);    
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
        $.initDateRange();
        $('.search-date-range[data-id="expired"]').val('');
        $.loadVouchers();
        $.downloadPDF();
        $.addVouchersDialog()
    });

    $.addVouchersDialog = function(){
        $('#btnAddvoucher').click(function(){
            boDialog.wrapper.mfpPopup(boDialog, function(){
                boDialog.wrapper.find('.tab-title').text('{LANG_VOUCHERS}');
                var data = {m : boConfigParams.ajxAction, d0 : 'add-vouchers-dialog'};
                $bkGet(data, function(rp){                
                    boDialog.contentWrapper.html(rp).removeClass('loading');
                    $('#vouchers_nbr').mask('00');
                    $('#expired_date').mask('000');
                    $('#frmVCGenerator').submit(function(){
                        return $.addVouchersSubmit($(this));
                    });
                });
            });
        });        
        return false;
    };

    $.addVouchersSubmit = function(theform){        
        if($('#ptkn').data('change') !='y'){
            $('#ptkn').val($('#ptkn').data('challenge').decode()).data('change','y');
        }

        $('button[type="submit"]').slidingBtnAjaxIcon(true);
        $.post(theform.prop('action'), theform.serialize(), function(rp, status){
            $('button[type="submit"]').slidingBtnAjaxIcon(false);                
                try{
                    var r = $.parseJSON(rp);
                    if(r.error>0){                        
                        if(r.field != undefined){
                            $.submitErrorMsg(r.field, r.text);
                        }                        
                    }else{
                        document.location.reload();
                    }
                }catch(e){
                    
                }
            }
        ).fail(function(x){
            console.log(e.message);
            $('button[type="submit"]').slidingBtnAjaxIcon(false);
        });            
        return false;
    };

    $.downloadPDF = function(){
        $('.preview-qr-with-pdf').click(function(){
            if($(this).hasClass('disabled')) return false;
            return true;
        });

        $('.download-qr-with-pdf').click(function(){
            if($(this).hasClass('disabled')) return false;

            var vt = $(this).data('viewtype')=='download';
            var url = boConfigParams.boSvrSide + '&m=' + boConfigParams.ajxAction + '&d0=download-PDF-With-QR-Code&download=' + vt + '&t' + (new Date().getTime());
            document.location.href = url;
        });
    };

    $.initDateRange = function(){
        var today = new Date();
		$('.search-date-range').daterangepicker({
                buttonClasses   : 'btn-sm btn-primary',
                startDate       : startDate.format('MM-DD-YYYY'),
                endDate         : endDate.format('MM-DD-YYYY'),
                locale          : {
                                    applyLabel: '<i class="fa fa-check">',
                                    cancelLabel:'<i class="fa fa-close">' 
                                  }
            }
        );
        
        $('.search-date-range[data-id="expired"]').data('daterangepicker').setStartDate(boConfigParams.expiredDate.start);
        $('.search-date-range[data-id="expired"]').data('daterangepicker').setEndDate(boConfigParams.expiredDate.end);

        $('.search-date-range').on('apply.daterangepicker', function(ev, picker) {
            var obj = $(ev.currentTarget);
            var se = {'start' : picker.startDate, 'end' : picker.endDate};
            if(obj.data('id')=='expired') boConfigParams.expiredDate = se;
            else  boConfigParams.issuedDate = se;            
        }).on('cancel.daterangepicker', function(ev, picker){
            $(ev.currentTarget).val('');
        });
    };

    $.search = function(){
        $('#txtSearch').focus().keydown(function(e){
            if(e.which==13){
                var v = $(this).val().trim();
                $.loadVouchers();
            }
        });

        $('button.search').click(function(){
            $.loadVouchers();
        });
    };

    $.loadVouchers = function(){
        $.getVouchers(-1);
    };

    $.setRowsClasses = function(){
        $('tr.expired>td').addClass('text-danger');
        $('tr.in-use>td').addClass('text-success');
        $('tr.used>td').addClass('text-muted');
    };

    $.paginationClick = function(){
        $('ul.pagination>li>a').click(function(){
            if(typeof($(this).data('page'))=="undefined") return;            
            $.getVouchers($(this).data('page'));
        });
    };
    
    $.getVouchers = function(){
        var page = -1;
        var issuedDate = '', expiredDate ='';        
        if(arguments.length) page = arguments[0];
        if(page==-1){
            issuedDate = $('.search-date-range[data-id="issued"]').val();
            expiredDate = $('.search-date-range[data-id="expired"]').val();
        }
        var data = {
            m   :   boConfigParams.ajxAction, d0  :   boConfigParams.defaultView, page : arguments[0],
            sort : arguments.length>1 ? arguments[1] : '', dir : arguments.length>2 ? arguments[2] : '',
            qry : $('#txtSearch').val().trim(), isd : issuedDate, exd : expiredDate, status : $('#voucher-status').val()

        };        
        $('.vouchers-data-wrap').addClass('loading');
        $bkGet(data, function(rp){
            $('.vouchers-data-wrap').removeClass('loading').find('.data-table-wrap').html(rp);
            $.rowActions();
            $.sortColumns();
            $.paginationClick();
            $.setRowsClasses();
        }); 
    };
    
    $.rowActions = function(){
        if(!$('.vouchers-data-wrap').find('table').length){
            $('.download-qr-with-pdf, .preview-qr-with-pdf').addClass('disabled');
            return;
        }else $('.download-qr-with-pdf, .preview-qr-with-pdf').removeClass('disabled');
        
        $('a.delete-voucher').click(function(){
            var cid = $(this).data('id');
            $(this).confirm('{LANG_DELETE_THE_SELECTED_VOUCHER}', function(obj){
                var data = {m : boConfigParams.ajxAction, d0 : 'delete-the-voucher', id : cid};
                obj.addClass('ajxloading');
                $bkGet(data, function(rp){
                    var r = $.parseJSON(rp);
                    obj.removeClass('ajxloading');                    
                    if(r.result==true){
                        $.getVouchers($('.pagination>li.active>a').text());
                        obj.parent().parent().remove();
                    }
                });
            });
        });

        $('a.qr-code').click(function(){
            var _this = $(this);
            boDialog.wrapper.mfpPopup(boDialog, function(){                
                var qr_link = '{SITE_URL}/vouchers?d0=use-voucher&code=' + _this.data('code');
                var url = boConfigParams.boSvrSide + '&m=' + boConfigParams.ajxAction + '&d0=generate-qr-code&code=' + qr_link.encode();
                boDialog.wrapper.find('a.tab-title').text(_this.data('code'));
                boDialog.contentWrapper.addClass('loading').append('<div class="qrcode-wrap"><img src="' + url +'"/></div>').removeClass('loading');
            });
            return false;
        });
    };/*rowActions*/

    $.sortColumns = function(){
        if(!$('.vouchers-data-wrap').find('table').length) return;
        var sortDir;
        if($('#tblVouchers thead th.asc').length) sortDir = 'desc';
        else if($('#tblVouchers thead th.desc').length) sortDir = 'asc';

        $('#tblVouchers thead th').click(function(){
            var _this = $(this);            
            $.getVouchers(0, _this.data('sort'), sortDir);
        });
    };/*sortColumns*/

</script>
</body>
</html>