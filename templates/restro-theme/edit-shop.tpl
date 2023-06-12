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
                <h3>{LANG_SHOP_INFO}</h3>
            </div>

            <!-- Row -->
            <div class="row">
                <form name="restaurent_form" id="restaurant_form" method="post" action="#" enctype="multipart/form-data">
                    <!-- Dashboard Box -->
                    <div class="col-xl-12">
                        <div class="dashboard-box margin-top-0">          
                            {LOOP: ERRORS}
                                <div class="notification error"><p>! {ERRORS.message}</p></div>
                            {/LOOP: ERRORS}
                            <div class="content with-padding padding-bottom-10">
                                <div class="row">

                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>{LANG_SHOP_NAME} <span style="color: red;">*</span></h5>
                                            <input type="text" class="with-border" name="name" value="{NAME}" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>{LANG_SHOP_SUBTITLE} <span style="color: red;">*</span></h5>
                                            <input type="text" class="with-border" name="sub_title" value="{SUB_TITLE}" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="submit-field">
                                            <h5>{LANG_STORE_SLUG} <span style="color: red;">*</span></h5>
                                            <input type="text" id="store-slug" class="with-border" name="slug" value="{SLUG}" onBlur="checkAvailabilityStoreSlug()" required>
                                            <div id="slug-availability-status"></div>
                                            <small>{LANG_STORE_SLUG_HINT}</small>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="submit-field">
                                            <h5>{LANG_DESCRIPTION}</h5>
                                            <textarea class="with-border"placeholder="{LANG_DESCRIPTION}" name="description" id="description" style="resize:none;" rows="2">{SHOP_DESCRIPTION}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="submit-field">
                                            <h5>{LANG_SHOP_LOCATION} <span style="color: red;">*</span></h5>
                                            <input class="with-border" type="text" placeholder="{LANG_ADDRESS}" name="address" id="address-autocomplete" value="{ADDRESS}" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>{LANG_LATITUDE}</h5>
                                            <input type="text" class="with-border" name="latitude" id="latitude" value="{LATITUDE}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>{LANG_LONGITUDE}</h5>
                                            <input type="text" class="with-border" name="longitude" id="longitude" value="{LONGITUDE}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>{LANG_STREET_NAME}</h5>
                                            <input type="text" class="with-border" name="street_name" value="{STREET_NAME}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>{LANG_HOUSE_NUMBER}</h5>
                                            <input type="text" class="with-border" name="house_number" value="{HOUSE_NUMBER}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>{LANG_ZIPCODE}</h5>
                                            <input type="text" class="with-border" name="zipcode" value="{ZIPCODE}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>{LANG_CITY}</h5>
                                            <input type="text" class="with-border" name="city" value="{CITY}">
                                        </div>
                                    </div>
                                   
                                    <div class="col-xl-4">
                                        <div class="submit-field">
                                            <h5>{LANG_SHOP_TAXCODE}</h5>
                                            <input type="text" class="with-border" name="taxcode" value="{TAXCODE}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>{LANG_SHOP_PHONE_NUMBER}<!--<span style="color: red;">*</span>--></h5>
                                            <input type="text" class="with-border" id="phone_number" name="phone_number" value="{PHONE_NUMBER}">
                                        </div>
                                        <div id="restaurant-check-status" class="notification error" style="display:none"></div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>{LANG_EMAIL}<span style="color: red;">*</span></h5>
                                            <input type="text" class="with-border" id="email" name="email" value="{EMAIL}">
                                        </div>
                                        <div id="email-check-status" class="notification error" style="display:none">{LANG_EMAILINV}</div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="submit-field">
                                            <h5>{LANG_TWITTER} </h5>
                                            <input type="text" class="with-border" name="shop_link_twitter" value="{SHOP_LINK_TWITTER}" >
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="submit-field">
                                            <h5>{LANG_FACEBOOK} </h5>
                                            <input type="text" class="with-border" name="shop_link_facebook" value="{SHOP_LINK_FACEBOOK}" >
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="submit-field">
                                            <h5>{LANG_INSTAGRAM} </h5>
                                            <input type="text" class="with-border" name="shop_link_instagram" value="{SHOP_LINK_INSTAGRAM}" >
                                        </div>
                                    </div>
                                

                                                                   
                                </div>
                            </div>
                        </div>
                      
                    </div>
                  
                    <div class="col-xl-12">
                        <button type="submit" name="submit" class="button ripple-effect margin-top-30">{LANG_SAVE}</button>
                    </div>
                </form>
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
<!-- Footer Code -->

<script>
    var session_uname = "{USERNAME}";
    var session_uid = "{USER_ID}";
    // Language Var
    var LANG_ARE_YOU_SURE = "{LANG_ARE_YOU_SURE}";
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
    var LANG_RESTAURANT_OPEN_TIME = "{LANG_RESTAURANT_OPEN_TIME}";
    var LANG_RESTAURANT_OPEN_TIME = "{LANG_RESTAURANT_CLOSE_TIME}";
    var LANG_PLEASE_ENTER_THE_CORRECT_TELEPHONE_NUMBER = "{LANG_PLEASE_ENTER_THE_CORRECT_TELEPHONE_NUMBER}";
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

<script src="{SITE_URL}templates/{TPL_NAME}/plugins/shop-util.js?ver={VERSION}"></script>
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

    $('.live-preview-button').on('click',function (e) {
        e.preventDefault();
        window.open($(this).attr('href'), "live-preview-button", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no,display=popup, width=380, height=' + screen.height + ', top=0, left=0');
    });

    function checkAvailabilityStoreSlug() {
        var $item = $("#store-slug").closest('.submit-field');
        var form_data = {
            action: 'checkStoreSlug',
            slug: $("#store-slug").val()
        };
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: form_data,
            dataType: 'html',
            success: function (response) {
                $("#slug-availability-status").html(response);
            }
        });
    }
</script>

IF("{RESTAURANT_TEXT_EDITOR}"=="1"){
<link media="all" rel="stylesheet" type="text/css"
      href="{SITE_URL}includes/assets/plugins/simditor/styles/simditor.css"/>
<script src="{SITE_URL}includes/assets/plugins/simditor/scripts/mobilecheck.js"></script>
<script src="{SITE_URL}includes/assets/plugins/simditor/scripts/module.js"></script>
<script src="{SITE_URL}includes/assets/plugins/simditor/scripts/uploader.js"></script>
<script src="{SITE_URL}includes/assets/plugins/simditor/scripts/hotkeys.js"></script>
<script src="{SITE_URL}includes/assets/plugins/simditor/scripts/simditor.js"></script>
<script>
    (function () {
        $(function () {
            var $preview, editor, mobileToolbar, toolbar, allowedTags;
            Simditor.locale = 'en-US';
            toolbar = ['title', 'bold','italic','underline','|','ol','ul','blockquote','table','link','|','image','hr','indent','outdent','alignment'];
            mobileToolbar = ["bold", "italic", "underline", "ul", "ol"];
            if (mobilecheck()) {
                toolbar = mobileToolbar;
            }
            allowedTags = ['br', 'span', 'a', 'img', 'b', 'strong', 'i', 'strike', 'u', 'font', 'p', 'ul', 'ol', 'li', 'blockquote', 'pre',  'h2', 'h3', 'h4', 'hr', 'table'];
            editor = new Simditor({
                textarea: $('.text-editor'),
                placeholder: '',
                toolbar: toolbar,
                pasteImage: false,
                toolbarFloat: false,
                defaultImage: '{SITE_URL}includes/assets/plugins/simditor/images/image.png',
                upload: false,
                allowedTags: allowedTags
            });
            $preview = $('#preview');
            if ($preview.length > 0) {
                return editor.on('valuechanged', function (e) {
                    return $preview.html(editor.getValue());
                });
            }
        });
    }).call(this);
</script>
{:IF}
<script type="text/javascript">
    $("#restaurant_form").on('submit', function (e) {
        /*var a = $('#phone_number').val();
        var filter = /^((\[+][1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
        if(!filter.test(a)) {            
            $("#restaurant-check-status").removeClass('success').addClass('error').html('<p>'+ LANG_PLEASE_ENTER_THE_CORRECT_TELEPHONE_NUMBER +'</p>').slideDown();
            $('#phone_number').focus();
            return false;
        }*/
        var email = $('#email').val().trim();
        if(!email.isEmail()){            
            $("#email-check-status").removeClass('success').addClass('error').slideDown();
            $('#email').focus();
            return false;
        }
        return true;
    });
</script>
</body>
</html>