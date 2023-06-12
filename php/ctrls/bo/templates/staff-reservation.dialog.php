<?php

isset($this) or die(':-)'); 

if($this->model->data){    
    $resv = $this->model->data;
}else{    
    $resv = 0;
}

?>
<form id="frmStaffReservation">
    <div class="popup-tab-content">
        <div id="form-submit-msg" class="notification error" style="display:none"></div>
        <div class="submit-field" style="margin-bottom:0;">
            <div class="form-group row">
                <label id="label_lang_from" class="col-sm-3 control-label"><?php echo $lang['STATUS'] ?></label>
                <div class="col-sm-9">
                    <select class="selectpicker" id="resv-status">
                        <?php
                        $labels = array($lang['BO_CONFIRMED'],$lang['BO_DONE'],$lang['BO_CANCELLED']);
                        $count = count($labels);
                        for($i=0; $i < $count ; ++$i){  
                            $selected = $i==$resv['status']?'selected':'';
                            echo "<option value='{$i}' {$selected}>{$labels[$i]}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row divider"></div>            
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['NAME'] ?></label>
                <div class="col-sm-9"><input type="text" value="<?php echo $resv->customer?>"/></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['PHONE'] ?></label>
                <div class="col-sm-9"><input type="text" value="<?php echo $resv->phone?>"/></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['EMAIL'] ?></label>
                <div class="col-sm-9"><input type="text" value="<?php echo $resv->email?>"/></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['SERVICES'] ?></label>
                <div class="col-sm-9"><input type="text" value="<?php echo CBoLogicData::getServiceNames($resv->service_ids)?>"/></div>
            </div>            
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['START_TIME'] ?></label>
                <div class="col-sm-9"><input type="text" value="<?php echo date('m-d-Y H:i', strtotime($resv->arr_time))?>"/></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['END_TIME'] ?></label>
                <div class="col-sm-9"><input type="text" value="<?php echo date('m-d-Y H:i', strtotime($resv->dep_time))?>"/></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="button" id="btnSave"><?php echo $lang['SAVE'] ?><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>            
        </div>
    </div>
</form>