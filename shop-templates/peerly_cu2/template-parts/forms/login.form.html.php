<div class="container">
    <div class="row">
        <form id="frmLogin" method="post" class="col-xl-5" style="margin:0 auto" data-lpcbsubmit="logMeIn">
            <div class="font-weight-bold text-center" style="font-size:26px;margin:15px 0 0 0;">{LANG_LOGIN}</div>
            <div class="font-weight-normal text-center" style="margin-bottom:15px;">
                {LANG_DONT_HAVE_ACCOUNT} <a href="{SITE_URL}{SLUG}/login?signup=true&return={RETURN_URL}">{LANG_SIGNUP_NOW}</a>
            </div>
            <div class="text-danger form-msg" id="themsg" data-invalid-pwd="{LANG_PLEASE_ENTER_A_PASSWORD_WITH_A_LENGTH_OF_8_20_CHARACTERS}" data-invalid-email="{LANG_EMAILINV}"></div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="la la-envelope"></i></span>
                </div>
                <input type="text" class="form-control" id="e" placeholder="{LANG_EMAIL}" require/>
            </div>            
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="la la-lock"></i></span>
                </div>
                <input type="password" class="form-control" id="secret" placeholder="{LANG_PASSWORD}" require/>
                <div class="input-group-append">
                    <span class="input-group-text toggle-password"><i class="la la-eye-slash"></i></span>
                </div>
            </div>
            <div class="input-group">
                <a href="{SITE_URL}{SLUG}/login?forgot-pwd&return={RETURN_URL}" class="forgot-pwd">{LANG_FORGOT_PASSWORD}</a>
            </div>            
            <button class="btn site-button form-control" type="submit" data-text="{LANG_LOGIN}">{LANG_LOGIN}</button>            
            <input type="hidden" id="d0" name="d0" value="log-me-in">
            <input type="hidden" id="md" name="md" value="customer-service">
            <input type="hidden" name="p" value="{SHOP_RANDOM_TOKEN}">
            <input type="hidden" name="e" value="{SHOP_RANDOM_TOKEN}">
            <input type="hidden" name="secret" value="{SHOP_BOOKING_TOKEN}">
        </form>
    </div>
</div>