<?php
require_once('./models/config-data-model.class.php');
$key = CBoCtrl::generateSessionKey();
?>
<?php isset($this) or die(':-)'); ?>
<form id="frmVCGenerator" action="./vouchers?d0=generate-vouchers&ajax=true">
    <div class="popup-tab-content">
        <div id="form-submit-msg" class="notification error" style="display:none"></div>
        <div class="submit-field" style="margin-bottom:0;">            
            <div class="form-group row">
                <label class="col-sm-7 control-label"><?php echo $lang['QUANTITY']?></label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" maxlength="2" id="vouchers_nbr" name="vouchers_nbr" placeholder="10" value="10"/>
                </div>
            </div>                    
            <div class="form-group row">
                <label class="col-sm-7 control-label"><?php echo $lang['VALID_DAYS']?></label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" maxlength="3" id="period" name="period" placeholder="30" value="30"/>
                </div>
            </div>            
        </div>
        <div class="row">            
            <div class="col-sm-6">
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="submit"><span><?php echo $lang['CONTINUE'] ?></span><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
            <div class="col-sm-6">
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="button" onclick="$.magnificPopup.close()"><?php echo $lang['CLOSE'] ?><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
        </div>
    </div>
    <input type="hidden" id="ptkn" name="<?php echo $_SESSION['user']['login_string']?>" data-challenge="<?php echo $key?>">        
</form>