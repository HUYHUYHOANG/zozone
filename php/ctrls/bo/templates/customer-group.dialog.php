<?php isset($this) or die(':-)'); ?>
<form id="frmCustomer" action="">
    <div class="popup-tab-content">        
        <div class="submit-field" style="margin-bottom:0;">
            <div class="form-group row">
                <label id="label_lang_from" class="col-sm-3 control-label"><?php echo $lang['SELECT'] ?></label>
                <div class="col-sm-9">
                    <select class="selectpicker" id="group_id">
                        <option value="0">[<?php echo $lang['ADD'] . ' ' . $lang['GROUP'] ?>]</option>
                    <?php
                    if($this->model->groups){
                        foreach($this->model->groups as $r){
                            echo sprintf('<option value="%d" data-subtext="<i class=\'icon-feather-users\'></i> %12d">%s</option>', $r['id'], $r['customers'], $r['name']);
                        }
                    }
                    ?>
                    </select>
                </div>
            </div>
            <div class="form-group row divider"></div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['NAME'] ?></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="50" id="group_name"/>
                </div>
            </div>                    
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['DISCOUNT'] ?> (%)</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control number" maxlength="2" id="disc_perct"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['POSITION'] ?></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control number" maxlength="3" id="position"/>
                </div>
            </div>                
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['DESCRIPTION'] ?></label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="1" id="description"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['ACTIVE'] ?></label>
                <div class="col-sm-9">
                    <div class="switch-container">
                        <label class="switch">
                            <input id="cust_active" value="0" type="checkbox">
                            <span class="switch-button-right"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div id="form-submit-msg" class="notification success" style="display:none;padding:4px;" data-success="<?php echo $lang['SAVED_SUCCESS']?>" data-error="<?php echo $lang['ERROR_TRY_AGAIN']?>"></div>
        <div class="row">
            <div class="col-lg-4 col-sm-4">
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="submit"><?php echo $lang['SAVE'] ?><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
            <div class="col-lg-4 col-sm-4">
                <button class="margin-top-15 button button-sliding-icon ripple-effect disabled" disabled type="button" id="btnDelete"><?php echo $lang['DELETE'] ?><i class="icon-feather-trash-2"></i></button>
            </div>
            <div class="col-lg-4 col-sm-4">
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="button" id="btnClose"><?php echo $lang['CLOSE'] ?><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
        </div>
    </div>
</form>