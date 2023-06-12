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
					<span class="hamburger hamburger--collapse" >
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</span>
                    <span class="trigger-title">{LANG_DASH_NAVIGATION}</span>
                </a>

                <!-- Navigation -->
                <div class="dashboard-nav">
                    <div class="dashboard-nav-inner">

                        <ul data-submenu-title="">
                            <li><a href="{LINK_DASHBOARD}"><img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/speedomete.svg" /> {LANG_DASHBOARD}</a></li>
                          
                            <li><a href="{LINK_MENU}"><img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/sign_restaurant.svg" />  {LANG_MENU}</a></li>
                            <div class="line-menu"></div>
                            IF('{ONLY_ON_TABLE}'!="1"){ 
                            <li class="nav-item nav-item-has-subnav">
                                <a href="#"> <img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/deliverable.svg" /> {LANG_TAKEAWAY_DELIVERY_ORDERS}</a>
                                <ul class="nav nav-subnav">
                                    <li><a href="{LINK_DELIVERY_TAKEAWAY_ORDERS}"><img class="svg svg-dashboard-submenu-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/arrow_right.svg" />{LANG_MANAGER}</a></li>
                                    <li><a href="{LINK_COUPON_DELIVERY_TAKEAWAY_ORDERS}"><img class="svg svg-dashboard-submenu-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/discount.svg" />{LANG_COUPON}</a></li>
                                    <li><a href="{LINK_ONLINE_ORDER_SETTING}"><img class="svg svg-dashboard-submenu-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/settings.svg" />{LANG_SETTING}</a></li>
                                </ul>
                            </li>
                            <li class="nav-item nav-item-has-subnav">
                                <a href="#"> <img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/history_toggle_off.svg" /> {LANG_RESERVATIONS}</a>
                                <ul class="nav nav-subnav">
                                    <li><a href="{LINK_PRE_ORDER_ORDERS}"><img class="svg svg-dashboard-submenu-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/arrow_right.svg" />{LANG_MANAGER}</a></li>
                                    <li><a href="{LINK_PRE_TABLE_ORDER_SETTING}"><img class="svg svg-dashboard-submenu-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/settings.svg" />{LANG_SETTING}</a></li>
                                </ul>
                            </li>
                            {:IF}     
                            <li class="nav-item nav-item-has-subnav">
                                <a href="#"> <img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/couple.svg" /> {LANG_ON_TABLE_ORDERS}</a>
                                <ul class="nav nav-subnav">
                                    <li><a href="{LINK_ON_TABLE_ORDERS}"><img class="svg svg-dashboard-submenu-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/arrow_right.svg" />{LANG_MANAGER}</a></li>
                                    <li><a href="{LINK_COUPON_ON_TABLE_ORDERS}"><img class="svg svg-dashboard-submenu-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/discount.svg" />{LANG_COUPON}</a></li>
                                    <li><a href="{LINK_ON_TABLE_ORDER_SETTING}"><img class="svg svg-dashboard-submenu-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/settings.svg" />{LANG_SETTING}</a></li>
                                </ul>
                            </li>
                            <li><a href="{LINK_TABLE}"><img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/table_restaurant.svg" />  {LANG_TABLE}</a></li>
                            IF('{ONLY_ON_TABLE}'!="1"){ 
                            <li><a href="{LINK_BOOKING}"><img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/book_online.svg" />  {LANG_BOOKING}</a></li>
                            <li><a href="{LINK_SHIPPING_FEE}"><img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/local_shipping.svg" />  {LANG_SHIPPING_FEE}</a></li>
                            {:IF}
                            <li><a href="{LINK_MEMBERSHIP}"> <img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/view_module.svg" /> {LANG_MEMBERSHIP}</a></li>
                            <li><a href="{LINK_QRBUILDER}"><img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/qr_code.svg" /> {LANG_QRBUILDER}</a></li>
                            <li><a href="{LINK_CANCELLATION_REASON}"><img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/assignment.svg" /> {LANG_CANCELLATION_REASON}</a></li>
                            IF("{QUICKORDER_ENABLE}" == "1"){
                            <li><a href="{LINK_WHATSAPP_ORDERING}"><img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/whatsapp.svg" />  {LANG_WHATSAPP_ORDERING}</a></li>
                            {:IF}
                            <div class="line-menu"></div>
                            <li><a href="{LINK_TRANSACTION}"><img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/receipt_long.svg" /> {LANG_TRANSACTIONS}</a></li>
                            <li class="active"><a href="{LINK_ACCOUNT_SETTING}"><img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/manage_accounts.svg" /> {LANG_ACCOUNT_SETTING}</a></li>
                            <li><a href="{LINK_ADD_RESTAURANT}"><img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/store.svg" /> {LANG_RESTAURANT}</a></li>
                            <li><a href="{LINK_LOGOUT}"><img class="svg svg-dashboard-nav" src="{SITE_URL}templates/{TPL_NAME}/images/svg/logout.svg" /> {LANG_LOGOUT}</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Navigation / End -->

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
                <h3>{LANG_ACCOUNT_SETTING}</h3>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="{LINK_INDEX}">{LANG_HOME}</a></li>
                        <li>{LANG_ACCOUNT_SETTING}</li>
                    </ul>
                </nav>
            </div>

            <!-- Row -->
            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="dashboard-box">
                        <div class="headline">
                            <h3><i class="icon-material-baseline-notifications-none"></i> {LANG_ACCOUNT_SETTING}</h3>
                        </div>
                        <div class="content">
                            <div class="content with-padding">
                                <form method="post" accept-charset="UTF-8">
                                    <div class="row">
                                        <div class="col-xl-6 col-md-12">
                                            <div class="submit-field">
                                                <h5>{LANG_USERNAME} *</h5>
                                                <div class="input-with-icon-left">
                                                    <i class="la la-user"></i>
                                                    <input type="text" class="with-border" id="username" name="username" value="{USERNAME}" onBlur="checkAvailabilityUsername()">
                                                </div>
                                                <span id="user-availability-status">IF("{USERNAME_ERROR}"!=""){ {USERNAME_ERROR} {:IF}</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-12">
                                            <div class="submit-field">
                                                <h5>{LANG_EMAIL} *</h5>
                                                <div class="input-with-icon-left">
                                                    <i class="la la-envelope"></i>
                                                    <input type="text" class="with-border" id="email" name="email" value="{EMAIL_FIELD}" onBlur="checkAvailabilityEmail()">
                                                </div>
                                                <span id="email-availability-status">IF("{EMAIL_ERROR}"!=""){ {EMAIL_ERROR} {:IF}</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-12">
                                            <div class="submit-field">
                                                <h5>{LANG_NEW_PASSWORD}</h5>
                                                <input type="password" id="password" name="password" class="with-border" onkeyup="checkAvailabilityPassword()">
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-md-12">
                                            <div class="submit-field">
                                                <h5>{LANG_CONPASS}</h5>
                                                <input type="password" id="re_password" name="re_password" class="with-border" onkeyup="checkRePassword()">
                                            </div>
                                        </div>
                                    </div>
                                    <span id="password-availability-status">IF("{PASSWORD_ERROR}"!=""){ {PASSWORD_ERROR} {:IF}</span>
                                    <div class="row">
                                        <div class="col-xl-6 col-md-12">
                                            <div class="submit-field">
                                                <h5>{LANG_PHONE}</h5>
                                                <input type="text" id="phone" name="phone" class="with-border" value="{PHONE}">
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-12">
                                            <div class="submit-field">
                                                <h5>{LANG_CURRENCY}</h5>
                                                <select name="currency" id="currency"  class="with-border selectpicker" data-live-search="true">
                                                    {LOOP: CURRENCY}
                                                    <option value="{CURRENCY.code}" {CURRENCY.selected}>{CURRENCY.code} ({CURRENCY.html_entity})</option>
                                                    {/LOOP: CURRENCY}
                                                </select>
                                                <small>{LANG_USER_CURRENCY_HINT}</small>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-12">
                                            <div class="submit-field">
                                                <h5>{LANG_MENU_LAYOUT}</h5>
                                                <select name="menu_layout" id="menu_layout"  class="with-border selectpicker">
                                                    <option value="both" IF("{MENU_LAYOUT}"=="both"){ selected {:IF}>{LANG_BOTH_LAYOUTS}</option>
                                                    <option value="grid" IF("{MENU_LAYOUT}"=="grid"){ selected {:IF}>{LANG_GRID_LAYOUT}</option>
                                                    <option value="list" IF("{MENU_LAYOUT}"=="list"){ selected {:IF}>{LANG_LIST_LAYOUT}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-12">
                                            <div class="submit-field">
                                                <h5>{LANG_MENU_LANGUAGES}</h5>
                                                <select name="menu_languages[]" id="menu_languages" class="with-border selectpicker" data-live-search="true" multiple>
                                                    {LOOP: LANGS}
                                                        <option value="{LANGS.code}" {LANGS.selected}>{LANGS.name}</option>
                                                    {/LOOP: LANGS}
                                                </select>
                                                <small>{LANG_MENU_LANGUAGES_HINT}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="submit" class="button ripple-effect">{LANG_SAVE_CHANGES}</button>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="dashboard-box">
                        <div class="headline">
                            <h3><i class="icon-material-outline-description"></i> {LANG_BILLING_DETAILS}</h3>
                        </div>
                        <div class="content">
                            <div class="content with-padding">
                                <div class="notification notice">{LANG_BILLING_DETAILS_NOTES}</div>
                                IF("{BILLING_ERROR}"=="1"){
                                <div class="notification error">{LANG_ALL_FIELDS_REQ}</div>
                                {:IF}
                                <form method="post" accept-charset="UTF-8">
                                    <div class="submit-field">
                                        <h5>{LANG_TYPE}</h5>
                                        <select name="billing_details_type" id="billing_details_type"  class="with-border selectpicker" required>
                                            <option value="personal" IF("{BILLING_DETAILS_TYPE}"=="personal"){ selected {:IF}>{LANG_PERSONAL}</option>
                                            <option value="business" IF("{BILLING_DETAILS_TYPE}"=="business"){ selected {:IF}>{LANG_BUSINESS}</option>
                                        </select>
                                    </div>
                                    <div class="submit-field billing-tax-id">
                                        <h5>IF("{ADMIN_TAX_TYPE}"!=""){ {ADMIN_TAX_TYPE} {ELSE} {LANG_TAX_ID}{:IF}</h5>
                                        <input type="text" id="billing_tax_id" name="billing_tax_id" class="with-border" value="{BILLING_TAX_ID}">
                                    </div>
                                    <div class="submit-field">
                                        <h5>{LANG_NAME} *</h5>
                                        <input type="text" id="billing_name" name="billing_name" class="with-border" value="{BILLING_NAME}" required>
                                    </div>
                                    <div class="submit-field">
                                        <h5>{LANG_ADDRESS} *</h5>
                                        <input type="text" id="billing_address" name="billing_address" class="with-border" value="{BILLING_ADDRESS}" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="submit-field">
                                                <h5>{LANG_CITY} *</h5>
                                                <input type="text" id="billing_city" name="billing_city" class="with-border" value="{BILLING_CITY}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="submit-field">
                                                <h5>{LANG_STATE} *</h5>
                                                <input type="text" id="billing_state" name="billing_state" class="with-border" value="{BILLING_STATE}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="submit-field">
                                                <h5>{LANG_ZIPCODE} *</h5>
                                                <input type="text" id="billing_zipcode" name="billing_zipcode" class="with-border" value="{BILLING_ZIPCODE}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit-field">
                                        <h5>{LANG_COUNTRY} *</h5>
                                        <select name="billing_country" id="billing_country" class="with-border selectpicker" data-live-search="true" required>
                                            {LOOP: COUNTRIES}
                                                <option value="{COUNTRIES.code}" {COUNTRIES.selected}>{COUNTRIES.asciiname}</option>
                                            {/LOOP: COUNTRIES}
                                        </select>
                                    </div>
                                    <button type="submit" name="billing-submit" class="button ripple-effect">{LANG_SAVE_CHANGES}</button>
                                </form>

                            </div>
                        </div>
                    </div>

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
<script>
    $(document).ready(function () {
        $("#header-container").addClass('dashboard-header not-sticky');
    });
</script>

<script>
    var error = "";
    function checkAvailabilityUsername() {
        jQuery.ajax({
            url: "{APP_URL}check_availability.php",
            data: 'username=' + $("#username").val(),
            type: "POST",
            success: function (data) {
                if (data != "success") {
                    error = 1;
                    $("#user-availability-status").html(data);
                }
                else {
                    error = 0;
                    $("#user-availability-status").html("");
                }
            },
            error: function () {
            }
        });
    }
    function checkAvailabilityEmail() {
        jQuery.ajax({
            url: "{APP_URL}check_availability.php",
            data: 'email=' + $("#email").val(),
            type: "POST",
            success: function (data) {
                if (data != "success") {
                    error = 1;
                    $("#email-availability-status").html(data);
                }
                else {
                    error = 0;
                    $("#email-availability-status").html("");
                }
                $("#loaderIcon").hide();
            },
            error: function () {
            }
        });
    }
  
    // function checkAvailabilityPassword() {
    //     var length = $('#password').val().length;
    //     if (length != 0) {
    //         var PASSLENG = "{LANG_PASSLENG}";
    //         if (length < 4 || length > 20) {
    //             $("#password-availability-status").html("<span class='status-not-available'>" + PASSLENG + "</span>");
    //         }
    //         else {
    //             $("#password-availability-status").html("");
    //         }
    //     }

    // }
    function checkAvailabilityPassword() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "{APP_URL}check_availability.php",
            data: 'password=' + $("#password").val(),
            type: "POST",
            success: function (data) {
                if (data != "success") {
                    error = 1;
                    $("#password-availability-status").html(data);        
                }
                else {
                    error = 0;
                    $("#password-availability-status").html("");
               
                }
                $("#loaderIcon").hide();
            },
            error: function () {
            }
        });
    }
    function checkRePassword(){
        if($('#password').val() != $('#re_password').val()){
            var PASS = "{LANG_PASSNOMATCH}";
            $("#password-availability-status").html("<span class='status-not-available'>" + PASS + "</span>");
        }else{
            $("#password-availability-status").html("");
        }
    }
    jQuery(window).on('load',function () {
        jQuery('#password').val("");
    });

    $('#billing_details_type').on('change', function () {

        if($(this).val() == 'business')
            $('.billing-tax-id').slideDown();
        else
            $('.billing-tax-id').slideUp();
    }).trigger('change');
</script>
<!-- Footer Code -->

<script>
    var session_uname = "{USERNAME}";
    var session_uid = "{USER_ID}";
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

<script>
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
    });
</script>
</body>
</html>