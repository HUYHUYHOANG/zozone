<div class="container">
    <div class="row">
        <form method="post" class="col-xl-5" style="margin:0 auto" data-lpcbsubmit="forgotPwd">
            <div class="font-weight-bold text-center" style="font-size:26px;margin:15px 0;">{LANG_FORGOT_PASSWORD}</div>
            <div class="text-center">
                <a href="{SITE_URL}{SLUG}/login?return={RETURN_URL}">{LANG_OR} {LANG_LOGIN}</a>
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="la la-envelope"></i></span>
                </div>
                <input type="email" class="form-control" id="e" placeholder="{LANG_EMAIL}"/>
            </div>            
            <div class="text-danger" id="themsg" style="display:none;margin-bottom:12px;" data-text="{LANG_PLEASE_ENTER_THE_CORRECT_EMAILL}">{LANG_PLEASE_ENTER_THE_CORRECT_EMAILL}</div>            
            <button class="btn site-button form-control" id="btn-getpwd" type="submit" data-text="{LANG_REQ_PASS}">{LANG_REQ_PASS}</button>
            <input type="hidden" id="d0" name="d0" value="send-forgot-pwd-request">
            <input type="hidden" id="md" name="md" value="customer-service">
            <input type="hidden" name="email" value="{SHOP_RANDOM_TOKEN}">
            <input type="hidden" name="secret" value="{SHOP_BOOKING_TOKEN}">
        </form>
    </div>
</div>