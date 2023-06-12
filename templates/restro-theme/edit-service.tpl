{OVERALL_HEADER}

<!-- Dashboard Container -->
<div class="dashboard-container">

    <div class="dashboard-sidebar">
        <div class="dashboard-sidebar-inner" data-simplebar>
            <div class="dashboard-nav-container">
                <!-- Responsive Navigation Trigger -->
                <a href="#" class="dashboard-responsive-nav-trigger">
                    <span class="hamburger hamburger--collapse">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </span>
                    <span class="trigger-title">{LANG_DASH_NAVIGATION}</span>
                </a>

                <!-- Navigation -->
                {OVERALL_SIDEBAR}
                <!-- Navigation / End -->

            </div>
        </div>
    </div>
    <!-- Dashboard Sidebar / End -->
    <!-- Dashboard Content-->
    <div class="dashboard-content-container" data-simplebar>
        <div class="dashboard-content-inner">
            <!-- Dashboard Headline -->
            <div class="dashboard-headline">
                <h3>{LANG_CREATE_CHANGE_SERVICE}</h3>
                <div class="headline-right">
                    IF({SHOW_LANGS}){
                    <div class="btn-group bootstrap-select user-lang-switcher">
                        <button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown"
                            title="English">
                            <span class="filter-option pull-left">GE</span>&nbsp;
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu scrollable-menu open">
                            <ul class="dropdown-menu inner">
                                {LOOP: LANGS}
                                <li data-lang="{LANGS.file_name}" data-code="{LANGS.code}">
                                    <a role="menuitem" tabindex="-1" rel="alternate" href="#">{LANGS.name}</a>
                                </li>
                                {/LOOP: LANGS}
                            </ul>
                        </div>
                    </div>
                    {:IF}

                </div>
            </div>

            <!-- Row -->
            <div class="row">
                <form name="crush_menu_form" id="crush_menu_form" method="post" action="#"
                    enctype="multipart/form-data">
                    <!-- Dashboard Box -->
                    <div class="col-xl-12">
                        <div class="dashboard-box">
                            <div class="content with-padding padding-bottom-10">
                                <div class="row">
                                    <!-- <div class="col-xl-12">
                                        <label>{LANG_ITEM_NO_E_G}</label>
                                        <input name="menu_item_id" type="text" class="with-border" id="menu_item_id"
                                            placeholder="{LANG_ITEM_NO_E_G}" value="{MENU_MENU_RES_ID}">
                                    </div> -->
                                    <div class="col-xl-12 col-md-12 margin-bottom-15">
                                        <label>{LANG_CATEGORY}</label>
                                        <select name="category" id="category"
                                            class="with-border selectpicker" data-live-search="false">
                                            {LOOP: CATEGORY}
                                            <option value="{CATEGORY.cat_id}" {CATEGORY.selected}>
                                                {CATEGORY.cat_name}</option>
                                            {/LOOP: CATEGORY}
                                        </select>
                                    </div>
                                    
                                    <div class="col-xl-12">
                                        <label>{LANG_TITLE}</label>
                                        <input name="title" type="text" class="with-border" id="menu-item-name"
                                            placeholder="{LANG_TITLE}" value="{MENU_NAME}">
                                    </div>

                                    <div class="col-xl-12">
                                        <label>{LANG_DESCRIPTION}</label>
                                        <textarea name="description" cols="10" rows="2" class="with-border"
                                            id="menu-item-description"
                                            placeholder="{LANG_DESCRIPTION}">{MENU_DESCRIPTION}</textarea>
                                    </div>
                                    <div class="col-xl-6">
                                        <label>{LANG_PRICE}</label>
                                        <input class="price-input with-border" name="price" type="text" id="menu-item-price" placeholder="{LANG_PRICE}" value="{MENU_PRICE}">
                                    </div>
                                    <div class="col-xl-6">
                                        <label>{LANG_DURATION} [{LANG_MINUTES}]</label>
                                        <input name="service_duration" type="text" class="with-border" id="menu-item-duration" maxlength="3"
                                            placeholder="{LANG_DURATION}" value="{MENU_SERVICE_DURATION}">
                                    </div>                                    
                                    <div class="col-xl-12">
                                        <label>{LANG_EXTRAS}</label>
                                    </div>
                                    <div class="extra-wrapper">
                                        {LOOP: EXTRAS}
                                        <div class="extra-item col-xl-12">
                                            <input type="hidden" name="extra-delete[]" value="0">
                                            <input type="hidden" name="extra-id[]" value="{EXTRAS.id}">
                                           <div class="extra-wrapper-left">
                                               <a href="#" class="button red ripple-effect btn-sm delete_extra"><i class="icon-feather-trash-2"></i></a>
                                             </div>
                                             <div class="extra-wrapper-center">          
                                                 <input name="name-extra[]" type="text" class="with-border"
                                                 placeholder="{LANG_SUB_SERVICE}" value="{EXTRAS.name}">
                                             </div>
                                             <div class="extra-wrapper-right"> 
                                                 <input name="price-extra[]" type="text" class="with-border input-price" 
                                                 placeholder="{LANG_PRICE}" value="{EXTRAS.price}">
                                           </div>  
                                        </div>
                                        {/LOOP: EXTRAS}
                                                                                   
                                    </div>
    
                                    <div class="col-xl-12">
                                        <a href="#"
                class="button ripple-effect add-extra" style="border-radius:50%;width: 40px;height: 40px;"><i
                    class="icon-feather-plus" style="right: 15px;font-size: 24px;"></i></a>  
                                    </div>
                                  
                                    <div class="col-xl-12 margin-top-30">
                                        <label>{LANG_ITEM_IMAGE}</label>
                                        <div class="input-file">
                                            <img src="{MENU_IMAGE}" id="menu-item-image" alt="" data-image-copy="{MENU_IMAGE_COPY}">
                                        </div>
                                        <div class="uploadButton margin-top-30">
                                            <input class="uploadButton-input" type="file" accept="image/*"
                                                onchange="readImageURL(this,'menu-item-image')" id="image_upload"
                                                name="main_image" />
                                            <label class="uploadButton-button ripple-effect"
                                                for="image_upload">{LANG_UPLOAD_IMAGE}</label>
                                        </div>
                                    </div>

                               

                                    <div style="margin-top:10px" class="col-xl-12">
                                        <label class="switch padding-left-40">
                                            <input name="active" id="menu-item-available" value="1" type="checkbox"
                                                IF("{MENU_ACTIVE}"=="1" ){ checked {:IF}>
                                            <span class="switch-button"></span> {LANG_AVAILABLE}
                                        </label>
                                    </div>
                                    
                                    <div style="margin-top:10px" class="col-xl-12">
                                        <label class="switch padding-left-40">
                                            <input name="is_new_food" id="menu-item-new" value="1" type="checkbox"
                                                IF("{MENU_IS_NEW_FOOD}"=="1" ){ checked {:IF}>
                                            <span class="switch-button"></span> {LANG_NEW_ITEM}
                                        </label>
                                    </div>

                                    <div style="margin-top:10px" class="col-xl-12">
                                        <label class="switch padding-left-40">
                                            <input name="is_discount" id="menu-item-is-discount" value="1"
                                                type="checkbox" IF("{MENU_IS_DISCOUNT}"=="1" ){ checked {:IF}>
                                            <span class="switch-button"></span> {LANG_DISCOUNT_PRICE}
                                        </label>
                                    </div>
                                    <div class="col-xl-12 margin-top-15">
                                        <input class="price-input with-border" name="discount_price" type="text" id="menu-item-discount-price" placeholder="{LANG_DISCOUNT_PRICE}">
                                    </div>
                              
                                       <div class="col-xl-12">
                                        <div id="add-item-status" class="notification error" style="display:none"></div>
                                       </div>
                                    <input name="cat_id" id="cat_id" value="{MENU_CAT_ID}" type="hidden" />
                                    <input name="id" id="menu-id" value="{MENU_ID}" type="hidden" />
                                    <input name="service_action" id="service_action" value="{SERVICE_ACTION}" type="hidden">
                                    <input name="copy_image_file_name" id="copy_image_file_name" value="" type="hidden">
                                    <!-- Button -->
                                    <div class="col-xl-12">
                                        <button id="add-item-button"
                                            class="margin-top-15 button button-sliding-icon ripple-effect"
                                            type="submit">{LANG_SAVE} <i
                                                class="icon-material-outline-arrow-right-alt"></i></button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

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

<script>
    var session_uname = "{USERNAME}";
    var session_uid = "{USER_ID}";
    var SITE_URL = "{SITE_URL}";
    // Language Var
    var LANG_ERROR_TRY_AGAIN = "{LANG_ERROR_TRY_AGAIN}";
    var LANG_LOGGED_IN_SUCCESS = "{LANG_LOGGED_IN_SUCCESS}";
    var LANG_ERROR = "{LANG_ERROR}";
    var LANG_CANCEL = "{LANG_CANCEL}";
    var LANG_DELETED = "{LANG_DELETED}";
    var LANG_ARE_YOU_SURE = "{LANG_ARE_YOU_SURE}";
    var LANG_YES_DELETE = "{LANG_YES_DELETE}";
    var LANG_SHOW = "{LANG_SHOW}";
    var LANG_HIDE = "{LANG_HIDE}";
    var LANG_HIDDEN = "{LANG_HIDDEN}";
    var LANG_TYPE_A_MESSAGE = "{LANG_TYPE_A_MESSAGE}";
    var LANG_JUST_NOW = "{LANG_JUST_NOW}";
    var LANG_PREVIEW = "{LANG_PREVIEW}";
    var LANG_SEND = "{LANG_SEND}";
    var LANG_STATUS = "{LANG_STATUS}";
    var LANG_SIZE = "{LANG_SIZE}";
    var LANG_NO_MSG_FOUND = "{LANG_NO_MSG_FOUND}";
    var LANG_ONLINE = "{LANG_ONLINE}";
    var LANG_OFFLINE = "{LANG_OFFLINE}";
    var LANG_GOT_MESSAGE = "{LANG_GOT_MESSAGE}";
    var LANG_SUB_SERVICE = "{LANG_SUB_SERVICE}";
	var LANG_PRICE = "{LANG_PRICE}";
    var LANG_EXTRA_NAME_IS_REQUIRED = "{LANG_EXTRA_NAME_IS_REQUIRED}";
    var LANG_EXTRA_PRICE_IS_REQUIRED = "{LANG_EXTRA_PRICE_IS_REQUIRED}";
</script>

<script src="{SITE_URL}templates/{TPL_NAME}/js/chosen.min.js?ver={VERSION}"></script>
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

<script src="{SITE_URL}templates/{TPL_NAME}/js/jquery-ui.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/svg.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/shop-util.js?ver={VERSION}"></script>
<script>
    let MENU_IS_DISCOUNT = "{MENU_IS_DISCOUNT}"
    if(MENU_IS_DISCOUNT == "1")
    {   
    $('#menu-item-discount-price').removeAttr("disabled");
    $('#menu-item-discount-price').val({MENU_DISCOUNT_PRICE});
    }
    else
    {
    $('#menu-item-discount-price').attr('disabled', 'disabled');
    $('#menu-item-discount-price').val('');
    }

    function CurrencyFormatted(amount) {
    if (!amount) {
        amount = "0";
    }
    if (isNaN(amount) == false) {        
        var sTemp = amount.replace(".", "").replace(",", "");
        var dNum = parseFloat(sTemp).toFixed(2) / 100
        dNum = dNum.toFixed(2);
        return dNum;
    }
    else {
        // return amount.substr(0, amount.length - 1)
        dNum = 0;
        dNum = dNum.toFixed(2);
        // return  amount.substr(0, amount.length - 1)
        return dNum;
    }
}
    /* THIS PORTION OF CODE IS ONLY EXECUTED WHEN THE USER THE LANGUAGE(CLIENT-SIDE) */
    $(function () {
        $('.language-switcher').on('click', '.dropdown-menu li', function (e) {
            e.preventDefault();
            var lang = $(this).data('lang');
            if (lang != null) {
                var res = lang.substr(0, 2);
                $('#selected_lang').html(res.toUpperCase());
                $.cookie('Quick_lang', lang, { path: '/' });
                location.reload();
            }
        });

        $('.user-lang-switcher').on('click', '.dropdown-menu li', function (e) {
            e.preventDefault();
            var lang = $(this).data('lang');
            var code = $(this).data('code');
            if (lang != null) {
                var res = lang.substr(0, 2);
                $('#selected_lang').html(res.toUpperCase());
                $.cookie('Quick_user_lang', lang, { path: '/' });
                $.cookie('Quick_user_lang_code', code, { path: '/' });
                location.reload();
            }
        });

        
        $('.price-input').on('keypress', function(e){
            var k = e.which;
            if((k>=48 && k<=57) || k==46) return true;
            e.preventDefault(); 
            return false;
        }).on('change', function(){
            var n = parseFloat($(this).val().replace(/\D/g,''),10);
            if(isNaN(n)) $(this).val('0');
            else{
                var thename = $(this).prop('name');
                if(thename=='discount_price'){
                    var price = $('#menu-item-price').val();
                    price = parseFloat(price);
                    if(n>=price) n = 0;
                    $(this).val(n.toFixed(2));
                }                
            } 
        });
            
        /*
        $('#menu-item-discount-price').on('input', function(e) {
            $('#menu-item-discount-price').val( CurrencyFormatted($('#menu-item-discount-price').val()));
        });*/

        $('.input-price').on('input', function(e) {
            $(this).val(CurrencyFormatted($(this).val()));
        });
           
        if($('#service_action').val()=='copy'){
            $('input[name="extra-id[]"]').val(0);            
            $('#copy_image_file_name').val($('#menu-item-image').data('image-copy'));            
        }            
    });

    $(document).on('click','.delete_extra', function(e){
        $extra_item = $(this).closest('.extra-item')
        $extra_item.find('input[name="extra-delete[]"]').val("1")
        $extra_item.hide();
    });
    $(document).on('click','.add-extra', function(e){
        var $extra_tpl = $(
                        '<div class="extra-item col-xl-12"><input type="hidden" name="extra-id[]" value=""><input type="hidden" name="extra-delete[]" value="0"><div class="extra-wrapper-left"><a href="#" class="button red ripple-effect btn-sm delete_extra"><i class="icon-feather-trash-2"></i></a></div><div class="extra-wrapper-center"><input name="name-extra[]" type="text" class="with-border" placeholder="' + LANG_SUB_SERVICE + '" value=""></div><div class="extra-wrapper-right"><input name="price-extra[]" type="text" class="with-border input-price" placeholder="' + LANG_PRICE + '" value=""></div></div>');
                        let  input_price = $extra_tpl.find('.input-price');
                        input_price.on('input', function () {
                            input_price.val(CurrencyFormatted(input_price.val()));
                        });
                        $extra_tpl.find('.delete_extra').on('click', function(e){
                            $extra_tpl.find('input[name="extra-delete[]"]').val("1")
                            $extra_tpl.hide();
                        })
                        $(".extra-wrapper").append($extra_tpl);   
    });
   
    $(document).ready(function () {
        var lang = $.cookie('Quick_lang');
        if (lang != null) {
            var res = lang.substr(0, 2);
            $('#selected_lang').html(res.toUpperCase());
        }

        var code = $.cookie('Quick_user_lang_code');
        if (code != null) {
            $('.user-lang-switcher .filter-option').html(code.toUpperCase());
        }

        $("#header-container").addClass('dashboard-header not-sticky');
    });

    $(function () {     
        $("#crush_menu_form").on('submit', function (e) {
            e.stopPropagation();
            e.preventDefault();
            var data = new FormData(this);
            var $form = $(this),
                $btn = $form.find('button'),
                $status = $form.find('.notification');
            
            var bRef = true;
            $('.extra-item').each(function () {
                let name =  $(this).find('input[name="name-extra[]"]').val();
                let price =  $(this).find('input[name="price-extra[]"]').val();
                let id =  $(this).find('input[name="extra-id[]"]').val();
                let deleted =  $(this).find('input[name="extra-delete[]"]').val();
                if(deleted == 0)
                {
                    if(name.length == 0)
                    {
                        bRef = false;
                        $status.removeClass('success').addClass('error').html('<p>' + LANG_EXTRA_NAME_IS_REQUIRED + '</p>').slideDown();
                    }
                    if(price.length == 0)
                    {
                        bRef = false;
                        $status.removeClass('success').addClass('error').html('<p>' + LANG_EXTRA_PRICE_IS_REQUIRED + '</p>').slideDown();
                    }
                }
            });
    
            if(bRef == false)
            {
                return false;
            }
    
            $btn.addClass('button-progress').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: ajaxurl +  '?action=add_item',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {                    
                    if (response.success) {
                        $status.slideUp();
                        Snackbar.show({
                            text: response.message,
                            pos: 'bottom-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 3000,
                            textColor: '#fff',
                            backgroundColor: '#383838'
                        });

                        /*$('#menu-id').val(response.id);
                        if($('#service_action').val()=='copy') location.href = './edit-service?menu_id=' + response.id;*/
                        setTimeout(function(){
                            location.href = './services';
                            //location.href = './edit-service?menu_id=' + response.id;
                        }, 800);
                    }
                    else {
                        $status.removeClass('success').addClass('error').html('<p>' + response.message + '</p>').slideDown();
                        if(typeof(response.field)!=undefined){
                            $('input[name="'+response.field+'"]').hilite(1);
                        }
                    }
                    $btn.removeClass('button-progress').prop('disabled', false);
                }
            });
            return false;
        });
    });

    $('input:checkbox[id="menu-item-is-discount"]').change(
    function () {
        if ($(this).is(':checked')) {
            $('#menu-item-discount-price').removeAttr("disabled");
            $('#menu-item-discount-price').focus();
        }
        else {
            $('#menu-item-discount-price').attr('disabled', 'disabled');
        }

    });

    $('#menu-item-duration').keypress(function(e){
        var k = e.which;
        if(k < 48 || k > 57) return false;
    }).on('paste', function(){
        return false;
    });

</script>
</body>
<style>
    .input-error{border:1px solid #F00 !important;}
</style>
</html>