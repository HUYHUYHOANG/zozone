<?php isset($this) or die(':-)'); ?>
<form id="frmgroup" action="">
    <div class="popup-tab-content">
        <div id="form-submit-msg" class="notification error" style="display:none"></div>
        <div class="submit-field" style="margin-bottom:0;">
            <div class="form-group row">
                <label id="label_lang_from" class="col-sm-3 control-label"><?php echo $lang['SELECT'] ?></label>
                <div class="col-sm-9">
                    <select class="selectpicker" id="group_id">
                        <option value="0">[<?php echo $lang['ADD'] . ' ' . $lang['GROUP'] ?>]</option>
                    <?php
                    if($this->model->groups){
                        foreach($this->model->groups as $r){
                            echo sprintf('<option value="%d" data-subtext="<i class=\'icon-feather-users\'></i> %12d">%s</option>', $r['group_id'], $r['staffs'], $r['group_name']);
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
                <label class="col-sm-3 control-label" style="white-space:nowrap;"><?php /*echo $lang['COMMISSION']*/ ?>Commission (%)</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control number" maxlength="2" id="commission"/>
                </div>
            </div>
            <!--<div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['POSITION'] ?></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control number" maxlength="3" id="position"/>
                </div>
            </div>-->
            
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['ACTIVE'] ?></label>
                <div class="col-sm-9">
                    <div class="switch-container">
                        <label class="switch">
                            <input id="group_active" value="0" type="checkbox">
                            <span class="switch-button-right"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
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