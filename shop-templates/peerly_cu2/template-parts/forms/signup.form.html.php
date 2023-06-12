<div class="container">
    <div class="row">
        <form method="post" class="col-xl-5" style="margin:0 auto" data-lpcbsubmit="signMeUp">
            <div class="font-weight-bold text-center" style="font-size:26px;margin:15px 0 0 0;">{LANG_LETS_CREATE_ACC}</div>
            <div class="font-weight-normal text-center" style="margin-bottom:15px;">
                {LANG_ALREADY_HAVE_ACC} <a href="{SITE_URL}{SLUG}/login?return={RETURN_URL}">{LANG_LOGIN}</a>
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="la la-user"></i></span>
                </div>
                <input type="text" class="form-control" name="fname" id="firstname" placeholder="{LANG_FIRST_NAME}" maxlength="30" require/>
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="la la-user"></i></span>
                </div>
                <input type="text" class="form-control" name="surname" id="lastname" placeholder="{LANG_LAST_NAME}" maxlength="30" require/>
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="la la-envelope"></i></span>
                </div>
                <input type="text" class="form-control" id="email" placeholder="{LANG_EMAIL}" maxlength="100" require/>
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="la la-phone"></i></span>
                </div>
                <input type="text" class="form-control" name="phone" id="phone" placeholder="{LANG_PHONE}" maxlength="15"/>
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
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="la la-lock"></i></span>
                </div>
                <input type="password" class="form-control" id="secret2" placeholder="{LANG_CONFIRM_PASSWORD}" require/>
                <div class="input-group-append">
                    <span class="input-group-text toggle-password"><i class="la la-eye-slash"></i></span>
                </div>
            </div>
            <div class="input-group">
                <a href="#" class="newsletter-opt" style="font-size:20px;"><i class="fa fa-check-square-o" style="position:relative;top:2px;margin-right:4px;"></i> {LANG_NEWSLETTER}</a>
            </div>
            <div class="text-danger font-weight-bold" id="themsg" style="display:none;margin-bottom:12px;" 
                data-invemail="{LANG_PLEASE_ENTER_THE_CORRECT_EMAILL}"
                data-field-req="{LANG_FIELD_REQ}"
                data-pwd-pat="{LANG_PLEASE_ENTER_A_PASSWORD_WITH_A_LENGTH_OF_8_20_CHARACTERS}"
                data-pwd-not-match="{LANG_PASSNOMATCH}">{LANG_PLEASE_ENTER_THE_CORRECT_EMAILL}</div>
            <button class="btn site-button form-control" id="btn-getpwd" type="submit" data-text="">{LANG_SIGNUP_NOW}</button>            
            <input type="hidden" id="e" name="e" value=""/>
            <input type="hidden" id="p" name="p" value="">
            <input type="hidden" id="d0" name="d0" value="sign-me-up">
            <input type="hidden" id="md" name="md" value="customer-service">
            <input type="hidden" name="secret" value="">
            <input type="hidden" name="newsletter-option" value="1">
        </form>
    </div>
</div>