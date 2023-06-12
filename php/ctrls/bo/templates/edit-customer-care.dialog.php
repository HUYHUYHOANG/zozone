<?php
//$categories = $this->model->getAllServices();    
$services = CBoLogicData::getServiceNames($r['service_ids']);
$key = CBoCtrl::generateSessionKey();
?>
<form id="ccl-item-detail-form" action="">
    <div class="popup-tab-content">        
        <div class="submit-field">
            <div class="form-group row">
                <label id="label_lang_from" class="col-sm-3 control-label"><?php echo $lang['SERVICES'] ?></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control readonly" value="<?php echo $services?>" data-value="<?php echo $r['service_ids']?>" readonly/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo sprintf('%s %s', $lang['CONTACT'], $lang['TIME']) ?></label>
                <div class="col-sm-9">                        
                    <input type="text" class="form-control" name="contact_time" id="contact-date" value="<?php echo $dt ? date('m-d-Y H:i A', $dt):'' ?>" data-value="<?php echo $dt?>" onkeydown="return false" onkeyup="return false"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['CUSTOMER'] ?></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control readonly" value="<?php echo $r['customer']?>" readonly/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['PHONE'] ?></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control readonly" value="<?php echo $r['phone']?>" readonly/>
                </div>
            </div>            
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['STAFF']?></label>
                <div class="col-sm-9">
                    <select id="staff-id" name="staff_id" class="selectpicker form-control">
                    <?php
                    $staffs = $this->model->loadStaffs();
                    foreach($staffs as $staff){
                        $staff = (object)$staff;
                        echo sprintf('<option value="%d" %s>%s</option>', $staff->id, $staff->id==$r['staff_id'] ? 'selected':'', $staff->name);
                    }
                    ?>
                    </select>
                </div>
            </div>            
            <div class="form-group row" style="margin:15px 0 15px 0;">
                <label class="col-sm-3 control-label"><?php echo $lang['NOTE'] ?></label>
                <div class="col-sm-9">
                    <textarea rows="1" class="" name="content" id="content"  style="margin-top:5px;"><?php echo CRequest::stripTags($r['content']) ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['STATUS']?></label>
                <div class="col-sm-9">
                    <select id="status" name="status" class="selectpicker form-control">
                    <?php
                    echo $this->getLogStatus($r['status']);
                    ?>
                    </select>
                </div>
            </div>            
            <input type="hidden" name="id" value="<?php echo $r['id']?>">
            <input type="hidden" id="ptkn" name="<?php echo $_SESSION['user']['login_string']?>" data-challenge="<?php echo $key?>">
        </div>
        <div id="form-submit-msg" class="notification success" style="padding:6px;display:none;" data-error="<?php echo $lang['ERROR']?>" data-success="<?php echo $lang['SAVED_SUCCESS']?>"><?php echo $lang['UPDATING'] ?></div>
        <div class="row container">                
            <div class="col-lg-6 col-sm-6">
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="submit"><?php echo $lang['SAVE'] ?><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
            <div class="col-lg-6 col-sm-6">
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="button" id="ccl-form-close"><?php echo $lang['CLOSE'] ?><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
        </div>        
    </div>
</form>
<script type="text/javascript">
    $(function(){
        var readonly = "<?php echo $readOnly?>";
        if(readonly=="readonly"){
            var $form = $('#ccl-item-detail-form');
            $form.find('input,textarea').addClass('readonly').prop('readonly', true);
            $form.find('select,button[type="submit"]').addClass('readonly').prop('disabled', true).selectpicker('refresh');
        }
    });
</script>