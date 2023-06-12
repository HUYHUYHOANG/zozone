<?php

isset($this) or die(':-)'); 

if(isset($_SESSION['__CUSTOMER_INFO__'])){
    $customer = (object)$_SESSION['__CUSTOMER_INFO__'];                        
    $resv = $this->model->data;
}else{
    $customer = 0;
    $resv = 0;
}

?>
<form id="frmCustomerReservation">
    <div class="popup-tab-content">
        <div id="form-submit-msg" class="notification error" style="display:none"></div>
        <div class="submit-field" style="margin-bottom:0;">
            <div class="form-group row">
                <label id="label_lang_from" class="col-sm-3 control-label"><?php echo $lang['STATUS'] ?></label>
                <div class="col-sm-9">
                    <select class="selectpicker" data-live-search="true" id="resv-status">
                        <?php
                        $labels = array($lang['BO_PENDING'], $lang['BO_CANCELLED'], $lang['BO_CONFIRMED'],
                                        $lang['BO_NOT_COME'], $lang['BO_IN_SERVICE'], $lang['BO_DONE']);
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
                <div class="col-sm-9"><input type="text" value="<?php echo $customer->name?>"/></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['PHONE'] ?></label>
                <div class="col-sm-9"><input type="text" value="<?php echo $customer->phone?>"/></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['EMAIL'] ?></label>
                <div class="col-sm-9"><input type="text" value="<?php echo $customer->email?>"/></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['SERVICES'] ?></label>
                <div class="col-sm-9"><input type="text" value="<?php echo CBoLogicData::getServiceNames($resv->service_ids)?>"/></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['EMPLOYEE'] ?></label>
                <div class="col-sm-9"><input type="text" value="<?php echo $resv->staff?>"/></div>
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