
<form id="ccl-item-detail-form" action="">
    <div class="popup-tab-content">
        <div id="form-submit-msg" class="notification success" style="display:none"><?php echo $lang['UPDATING'] ?></div> 
        <div class="submit-field">
            <div class="form-group row">
                <label id="label_lang_from" class="col-sm-3 control-label">Send via</label>
                <div class="col-sm-9">
                    <select class="selectpicker">
                        <option>whatsapp</option>
                        <option>newsletter</option>
                    </select>
                </div>
            </div>            
            <div class="form-group row" style="margin-top:15px;">
                <label class="col-sm-3 control-label">Last activity</label>
                <div class="col-sm-9">
                    <select class="selectpicker">
                        <option>all</option>    
                        <option>15 days past</option>
                        <option>30 days past</option>
                    </select>
                </div>
            </div>            
            <div class="form-group row" style="margin-top:15px;">
                <label class="col-sm-3 control-label">Template</label>
                <div class="col-sm-9">
                    <select class="selectpicker">                        
                        <option>template EN</option>
                        <option>template DE</option>
                        <option>template VI</option>
                    </select>
                </div>
            </div>
        </div>            
        <div class="row container">                
            <div class="col-lg-6 col-sm-6">
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="submit"><?php echo $lang['SEND'] ?><i class="icon-feather-send"></i></button>
            </div>
            <div class="col-lg-6 col-sm-6">
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="button" id="ccl-form-close"><?php echo $lang['CLOSE'] ?><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
        </div>            
    </div>
</form>