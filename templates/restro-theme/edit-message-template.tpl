{OVERALL_HEADER}
<link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/simditor/simditor.css" />
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
                <h3>{LANG_MESSAGE_TEMPLATES} / {LANG_MESSAGE}</h3>
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
                            <a class="button margin-left-auto disabled">{LANG_MESSAGE_TEMPLATE} <i class="icon-feather-edit"></i></a>
                        </div>
                        <div class="dashboard-box content" style="padding:20px;">
                            <div class="row main-box-in-row">                                
                                <form class="col-xl-12" id="frm-msg-template">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                            <div class="submit-field">
                                                <h5>{LANG_NAME} *</h5>
                                                <input type="text" class="form-control" name="name" id="name" value="{THE_NAME}" maxlength="100" autocomplete="off"/>
                                            </div>
                                        </div>

                                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12">
                                            <div class="submit-field">
                                                <h5>{LANG_LANGUAGE}</h5>
                                                <select class="selectpicker" id="lang_code" name="lang_code">
                                                    {LOOP: LANGUAGES}
                                                    <option {LANGUAGES.selected} value="{LANGUAGES.code}">{LANGUAGES.name}</option>
                                                    {/LOOP: LANGUAGES}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12">
                                            <div class="submit-field">
                                                <h5>{LANG_TYPE}</h5>
                                                <select class="selectpicker" id="template_type" name="template_type">
                                                    {LOOP: TMPL_TYPES}
                                                    <option {TMPL_TYPES.selected} value="{TMPL_TYPES.type}">{TMPL_TYPES.name}</option>
                                                    {/LOOP: TMPL_TYPES}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12">
                                            <div class="submit-field">
                                                <h5>{LANG_APPLY}</h5>
                                                <select class="selectpicker" id="send_via" name="send_via" data-value="{THE_SEND_VIA}">
                                                    <option value="email">Email</option>
                                                    <!-- <option value="whatsapp">What's App</option> -->
                                                </select>
                                            </div>
                                        </div>
                                    </div><!--options row -->
                                    
                                    <div class="row">
                                        <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
                                            <div class="submit-field">
                                                <h5>{LANG_TITLE} *</h5>
                                                <input type="text" class="form-control" id="title" name="title" maxlength="255" value="{THE_TITLE}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
                                            <textarea id="msg-editor" name="content" rows="10" style="resize:no-resize;width:100%;">{THE_CONTENT}</textarea>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-xl-12 col-md-12 col-sm-12">
                                            <label class="switch padding-left-40">
                                                <input name="active" id="active" {THE_CHECKED_STATE} value="{THE_STATUS}" type="checkbox">
                                                <span class="switch-button"></span> {LANG_ACTIVE}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div id="save-msg-result" class="col-xl-12 col-md-12 col-sm-12 text-danger" data-success="{LANG_SAVED_SUCCESS}" data-error="{LANG_ERROR}" data-required="{LANG_ALL_FIELDS_REQ}">{LANG_ALL_FIELDS_REQ}</div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-xl-12 col-md-12 col-sm-12">
                                            <button class="button button-sliding-icon ripple-effect" type="submit" style="margin-right:12px;"><span>{LANG_SAVE}</span><i class="icon-material-outline-arrow-right-alt"></i></button>                                            
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" id="template-id" value="{THE_ID}"/>
                                    <input type="hidden" id="ptkn" name="{USER_AUTH_STRING}" data-challenge="{PTKN_KEY}">
                                </form>
                            </div>
                        </div><!--dashboard-box content-->
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

<div id="ccl-modal-dialog" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
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

<script src="{SITE_URL}templates/{TPL_NAME}/js/jquery.cookie.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/custom.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/svg.js?ver={VERSION}"></script>

<!--custom js files-->
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/codec.min.php?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/shop-util.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>

<script src="{SITE_URL}templates/{TPL_NAME}/plugins/simditor/module.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/simditor/hotkeys.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/simditor/uploader.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/simditor/simditor.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/simditor/mobilecheck.js"></script>

<script>
    var $preview, editor, mobileToolbar, toolbar;
    var readOnly = {READONLY_PERMISSION};
    var boDialog = { wrapper : $('#ccl-modal-dialog'), contentWrapper : $('.popup-tabs-container') };
    boConfigParams = $.extend({selectedStatus : [], ajxAction : 'message-template', defaultView : 'load-the-logs'}, boConfigParams);        
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
        
        var sendvia = $('#send_via').data('value');
        if(!sendvia.length) sendvia = 'email';        
        $('#send_via').val(sendvia);
        $initSelectPicker();
       
        $('#lang_code').change(function(){
            $.languageChanged($(this).val());
        });

        $('#frm-msg-template').submit(function(){
            try{
                $.formSubmit(this);
            }catch(e){
                console.log(e.message);
            }
            return false;
        });
    });

    $initSelectPicker = function(){        
        $('.selectpicker').selectpicker({title: '{LANG_ALL}'}).selectpicker('render')
        .on('change', function(){            
        });
    };

    $.languageChanged = function(langCode){
        let id = $('input[name="id"]').val();
        if(id==0) return;
        
        var request = $.ajax({
            type: "POST",
            url: '{SITE_URL}php/ctrls/bo/?{USER_AUTH_STRING}&m=' + boConfigParams.ajxAction + '&d0=load-msg-content&id=' + id + '&lang_code=' + langCode,             
            cache: false,
            contentType: false,
            processData: false,
            success : function(response, textStatus, jqXHR){                
                try{                    
                    r = $.parseJSON(response);
                    console.log(r);
                    if(r.id == id){
                        $('#name').val(r.data.name);
                        $('#title').val(r.data.title);
                        editor.setValue(r.data.content);                        
                    }
                    
                }catch(e){
                    console.log(e.message);
                }
            }
        });
        request.always(function(x){
        });
    };

    $.formSubmit = function(_form){
        $form = $(_form);
        var name = $('#name').val().trim();
        var content = $('#msg-editor').val().trim();
        if(!name.length){
            $('#name').hilite(1);
            return false;
        }
        
        if($('#ptkn').data('change') !='y'){
            $('#ptkn').val($('#ptkn').data('challenge').decode()).data('change','y');
        }
        var r = null;
        var data = new FormData(_form);
        var themsg = $('#save-msg-result');
        var thebtn = $('button[type="submit"]').addClass('ajxloading').removeClass('button-sliding-icon');
        var request = $.ajax({
            type: "POST",
            url: boConfigParams.boSvrSide,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success : function(response, textStatus, jqXHR){
                console.log(response);
                try{                    
                    r = $.parseJSON(response);
                    var errorText;
                    if(r.error==1){  
                        if(r.field != undefined){                            
                            $.submitErrorMsg(r.field, r.text);
                            errorText = r.text;
                        }else errorText = themsg.data('error');
                        themsg.slideDown().text(errorText).removeClass('text-success').addClass('text-danger');
                    }else{
                        themsg.slideDown().text(themsg.data('success')).removeClass('text-danger').addClass('text-success');
                    }
                }catch(e){
                    console.log(e.message);
                }
            }
        });
        request.always(function(x){  
            thebtn.removeClass('ajxloading').addClass('button-sliding-icon');
            setTimeout(function(){
                    themsg.slideUp();
                    $('.simditor').removeClass('input-error');
                    if(r && !r.error) document.location='./message-templates';
                }, 1500);
        });
        return false;
    };

    $.submitErrorMsg = function(field, text){
        var elm = null, fc = field;
        if(field=="content") fc = $(".simditor").addClass('input-error');
        else $('#' + fc).hilite(1);        
    };
    

(function() {
    $(function(){        
        Simditor.locale = 'en-US';
        toolbar = ['bold', 'italic', 'underline', 'strikethrough', 'fontScale', 'color', '|', 'ol', 'ul', 'table', '|', 'link', 'alignment'];
        mobileToolbar = ["bold", "underline", "strikethrough", "color", "ul", "ol"];
        if (mobilecheck()) {
            toolbar = mobileToolbar;
        }
        editor = new Simditor({
            textarea: $('#msg-editor'),
            placeholder: '',
            toolbar: toolbar,
            pasteImage: true,
            upload : false
            /*defaultImage: 'assets/images/image.png',
            upload: location.search === '?upload' ? {
            url: '/upload'
            } : false*/
        });
        /*$preview = $('#preview');
        if ($preview.length > 0) {
            return editor.on('valuechanged', function(e) {
            return $preview.html(editor.getValue());
            });
        }*/

        editor.on('blur', function(e) {
            if(!editor.getValue().trim().length){
                $('.simditor').addClass('input-error');
                setTimeout(function(){
                    $('.simditor').removeClass('input-error');
                }, 3000);
            } 
            else $('.simditor').removeClass('input-error');
        });
    });
}).call(this);

</script>
<style>
    .popup-tabs-container.loading{height:200px;width:100%;background:#FFF url({SITE_URL}templates/{TPL_NAME}/images/loading2.svg) no-repeat center center !important;}    
    .loading{height:100px;width:100%;background:#FFF url({SITE_URL}templates/{TPL_NAME}/images/loading2.svg) no-repeat center center !important;}

    .dropdown-header{padding:10px !important;font-size:16px;font-weight: 600;}

    #customr-care-logs td.date-time{
        white-space:nowrap;
    }

    .bootstrap-select.btn-group .dropdown-toggle .filter-option,
    .dropdown-menu.inner span.text{
        text-transform: capitalize;
    } 

    .bootstrap-select.btn-group .dropdown-toggle .filter-option::first-letter,
    .dropdown-menu.inner span.text::first-letter {
        text-transform: uppercase;    
    }
    button[type="submit"]{min-width:100px;}
    #save-msg-result{display: none;}
    .simditor{border-radius: 4px;border: none;box-shadow: 0 1px 4px 0 rgb(0 0 0 / 12%);}
</style>
</body>
</html>