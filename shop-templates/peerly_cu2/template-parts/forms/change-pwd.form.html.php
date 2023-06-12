<div class="container">
    <div class="row">
        <form id="frmChangePwd" method="post" class="col-xl-5" style="margin:0 auto" data-lpcbsubmit="changePwd">
            <div class="font-weight-bold text-center" style="font-size:26px;margin:5px 0;">{LANG_CHANGE_PASS}</div>
            <div class="font-weight-bold text-center text-success" style="margin:5px 0;">{CUSTOMER_NAME}</div>
            <div class="text-primary">{LANG_PLEASE_ENTER_A_PASSWORD_WITH_A_LENGTH_OF_8_20_CHARACTERS}</div>
            <div class="text-danger form-msg" id="themsg" data-notmatch="{LANG_PASSNOMATCH}" data-invalid="{LANG_INVALID_PWD}">{LANG_INVALID_PWD}</div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="la la-lock"></i></span>
                </div>
                <input type="password" class="form-control" id="secret" placeholder="{LANG_PASSWORD}"/>
                <div class="input-group-append">
                    <span class="input-group-text toggle-password"><i class="la la-eye-slash"></i></span>
                </div>
            </div>            
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="la la-lock"></i></span>
                </div>
                <input type="password" class="form-control" id="secret2" placeholder="{LANG_CONFIRM_PASSWORD}"/>
                <div class="input-group-append">
                    <span class="input-group-text toggle-password"><i class="la la-eye-slash"></i></span>
                </div>
            </div>
            <p class="text-left">{LANG_OR}  <a href='{SITE_URL}{SLUG}/login?' class="link-login">{LANG_LOGIN}</a></p>
            <button class="btn site-button form-control" type="submit" data-text="{LANG_CHANGE_PASS}">{LANG_CHANGE_PASS}</button>
            <input type="hidden" id="f" name="f" value="{FIELD_FORGOT}"/>
            <input type="hidden" id="r" name="r" value="{FIELD_R}"/>
            <input type="hidden" id="t" name="t" value="{FIELD_T}"/>
            <input type="hidden" id="e" name="e" value="{FIELD_E}"/>
            <input type="hidden" id="p" name="p" value="{FIELD_FORGOT}">
            <input type="hidden" id="d0" name="d0" value="change-pwd">
            <input type="hidden" id="md" name="md" value="customer-service">
            <input type="hidden" name="secret" value="">
        </form>
    </div>
</div>