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

    <!-- Dashboard Content
            ================================================== -->
    <div class="dashboard-content-container" data-simplebar>
        <div class="dashboard-content-inner">
            <!-- Dashboard Headline -->
            <div class="dashboard-headline">     
                    <form name="search_menu_form" id="search_menu_form" method="GET" action="#" enctype="multipart/form-data">               
                        <div style="display: flex;" class="open-datetimepicker-dasboard">
                            <h3>{LANG_MANAGE_SERVICES}</h3>
                             <div style="margin-left: auto;margin-right: 10px;position: relative; width: 200px; ">
                                <input name="searchString" type="text" class="with-border" id="searchString"
                                placeholder="{LANG_SEARCH}" value="{SEARCH_STRING}">
                            </div>
                            <a href="#"
                            class="button ripple-effect search-menu" style="margin-right:10px;height: 50px;"><i
                                class="icon-feather-search margin-right-5"></i></a>
                        </div>
                    </form>          
            </div>       
            IF('{SEARCH_STRING}'==""){
            <div class="dashboard-headline">
                <div class="menu-button">
                    <a href="#"
                        class="button ripple-effect button-sliding-icon margin-left-auto add-cat" style="margin-right:10px;">{LANG_ADD_SERVICE_GROUP}<i
                            class="icon-feather-plus"></i></a>
                </div>
            </div>
            {:IF}

            <!-- Row -->
            <div class="row">
                <div class="col-xl-12 js-accordion" id="menu-categories">
                   
                        {LOOP: CATEGORY}
                        <!-- Dashboard Box -->
                        IF('{SEARCH_STRING}'==""){
                        <div id="js-accordion-body-{CATEGORY.id}" class="dashboard-box margin-top-0 margin-bottom-15 js-accordion-item"
                            data-catid="{CATEGORY.id}">           
                            <div class="headline js-accordion-header">
                                <h3><i class="icon-feather-menu quickad-js-handle"></i> <span
                                        class="category-display-name">{CATEGORY.name}</span></h3>
                                <div class="margin-left-auto">
                                    <!--<a href="#" data-catid="{CATEGORY.id}"
                                        class="button ripple-effect btn-sm add_sub_cat_item" title="{LANG_ADD_SUB_SERVICE_GROUP}"
                                        data-tippy-placement="top"><i class="icon-feather-folder-plus"></i></a>-->
                                    <a href="#" data-catid="{CATEGORY.id}" class="button ripple-effect btn-sm add_menu_item"
                                        title="{LANG_ADD_SERVICE}" data-tippy-placement="top"><i
                                            class="icon-feather-plus"></i></a>
                                    <a href="#" data-catid="{CATEGORY.id}" class="button ripple-effect btn-sm edit-cat"
                                        title="{LANG_EDIT_SERVICE_GROUP}" data-tippy-placement="top"><i
                                            class="icon-feather-edit"></i></a>
                                    <a href="#" data-catid="{CATEGORY.id}"
                                        class="button red ripple-effect btn-sm delete-cat"
                                        title="{LANG_DELETE_SERVICE_GROUP}" data-tippy-placement="top"><i
                                            class="icon-feather-trash-2"></i></a>
                                </div>
                            </div>
                          {:IF}

                          IF('{SEARCH_STRING}'==""){
                            <div class="content with-padding padding-bottom-10 js-accordion-body"  style="display: {CATEGORY.display};">                       
                           {:IF}   
                                {CATEGORY.menu}
                                {CATEGORY.paging}
                        IF('{SEARCH_STRING}'==""){
                            </div>     
                        </div>
                        {:IF}
                        {/LOOP: CATEGORY}
              
                 
                </div>
            </div>
            <!-- Row / End -->

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


<!-- Add Category Popup / End -->
<div id="add-category" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="sign-in-form">
        <ul class="popup-tabs-nav">
            <li><a id="title_popup_category">{LANG_ADD_SERVICE_GROUP}</a></li>
        </ul>

        <div class="popup-tabs-container">
            <!-- Tab -->
            <div class="popup-tab-content">
                <div id="category-status" class="notification error" style="display:none"></div>
                <div class="submit-field">
                    <input type="text" class="with-border" placeholder="{LANG_SERVICE_GROUP_NAME}" id="category_name">
                    <input type="hidden" name="id" id="cat-edit-id" value="">
                </div>
                <!-- Button -->
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="submit"
                    id="save-category">{LANG_SAVE} <i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>

        </div>
    </div>
</div>
<!-- Add Category Popup / End -->

<!-- Add Sub Category Popup / End -->
<div id="add-sub-category" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="sign-in-form">
        <ul class="popup-tabs-nav">
            <li><a id="title_popup_sub_category">{LANG_ADD_SUB_SERVICE_GROUP}</a></li>
        </ul>

        <div class="popup-tabs-container">
            <!-- Tab -->
            <div class="popup-tab-content">
                <div id="category-status" class="notification error" style="display:none"></div>
                <div class="submit-field">
                    <input type="text" class="with-border" placeholder="{LANG_SUB_SERVICE_GROUP_NAME}" id="sub_category_name">
                    <input type="hidden" name="id" id="cat-id" value="">
                    <input type="hidden" name="id" id="sub-cat-id" value="">
                </div>
                <!-- Button -->
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="submit"
                    id="save-sub-category">{LANG_SAVE} <i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
        </div>
    </div>
</div>
<!-- Add Sub Category Popup / End -->


<!-- Add Item Popup / End -->

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
    var LANG_ADD_NEW_ITEM = "{LANG_ADD_NEW_ITEM}";
    var LANG_EDIT_ITEM = "{LANG_EDIT_ITEM}";
    var LANG_ADD_SUB_CATEGORY = "{LANG_ADD_SUB_CATEGORY}";
    var LANG_EDIT_SUB_CATEGORY = "{LANG_EDIT_SUB_CATEGORY}";
    var LANG_ADD_SERVICE_GROUP = "{LANG_ADD_SERVICE_GROUP}";
    var LANG_EDIT_SERVICE_GROUP = "{LANG_EDIT_SERVICE_GROUP}";
    var LANG_PLEASE_ENTER_ITEM_ID = "{LANG_PLEASE_ENTER_ITEM_ID}";
    var LANG_ADD_SUB_SERVICE_GROUP = "{LANG_ADD_SUB_SERVICE_GROUP}";
    var LANG_EDIT_SUB_SERVICE_GROUP = "{LANG_EDIT_SUB_SERVICE_GROUP}";
    var CAT_ID = "{CAT_ID}";
  
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
<script src="{SITE_URL}templates/{TPL_NAME}/js/services.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/svg.js?ver={VERSION}"></script>

<script src="{SITE_URL}templates/{TPL_NAME}/js/sweetalert.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/shop-util.js?ver={VERSION}"></script>

<script>
    /* THIS PORTION OF CODE IS ONLY EXECUTED WHEN THE USER THE LANGUAGE(CLIENT-SIDE) */
    $(function () {
       
        $('#menu-item-price').on('input', function(e) {
                $('#menu-item-price').val( CurrencyFormatted($('#menu-item-price').val()));
            });

            $('#menu-item-discount-price').on('input', function(e) {
                $('#menu-item-discount-price').val( CurrencyFormatted($('#menu-item-discount-price').val()));
            });

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
    });
 

    $(document).ready(function () {
        $("#header-container").addClass('dashboard-header not-sticky');
    });

    $(".search-menu").on('click',function(e){
        e.preventDefault();
        e.stopPropagation();
        $("#search_menu_form").submit();
    })
    window.onload = function() {
    function aboutUsScroll() {
        var aboutUs = document.getElementById("js-accordion-body-" + CAT_ID);
        aboutUs.scrollIntoView({ block: "start", behavior: "smooth" });
    }
    if(CAT_ID != "")
    {
        aboutUsScroll();
    }
    
}
</script>
</body>

</html>