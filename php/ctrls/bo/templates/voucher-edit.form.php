<?php
require_once('./models/config-data-model.class.php');
$key = CBoCtrl::generateSessionKey();
?>
<?php isset($this) or die(':-)'); ?>
<div style="margin:25px 5px ;">
    <form id="frmVoucher" accept-charset="UTF-8" method="post" data-working="no" action="./vouchers?d0=save-voucher&ajax=true&renew=<?php echo $data->status=='expired'?'true':''?>">
        <div class="row"><!--row 1-->
            <div class="col-xl-2 col-md-2">
                <div class="submit-field">
                    <h5><?php echo $lang['CODE'] ?> *</h5>                
                    <div class="input-with-icon-left">
                        <i class="la la-tag"></i>
                        <input type="text" class="with-border disabled" id="code" name="code" maxlength="8" value="<?php echo $data?$data->code:''?>" disabled/>
                    </div>
                </div>
            </div>        
            <div class="col-xl-3 col-md-3">
                <div class="submit-field">
                    <h5><?php echo $lang['ISSUED_DATE']?></h5>
                    <div class="input-with-icon-left">
                        <i class="la la-calendar"></i>
                        <input type="text" class="with-border dtp" id="issued_date" name="issued_date" value="<?php echo $data ? date('m-d-Y', strtotime($data->issued_date)) :''?>"/>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="submit-field">
                    <h5><?php echo $lang['EXPIRED_DATE']?></h5>
                    <div class="input-with-icon-left">
                        <i class="la la-calendar"></i>
                        <input type="text" class="with-border dtp" id="expired_date" name="expired_date" value="<?php echo $data ? date('m-d-Y', strtotime($data->expired_date)) :''?>"/>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4">
                <div class="submit-field">
                    <h5><?php echo $lang['STATUS'] ?></h5>
                    <input type="text" class="form-control <?php echo $data->status=='expired' ? 'text-danger' : 'text-primary' ?>" value="<?php echo $data->status?>" disabled style="text-transform:uppercase;font-weight:bold;">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2 col-md-2">
                <div class="submit-field">
                    <h5><?php echo $lang['VALUE']?></h5>                    
                    <div class="input-group">
                        <input type="text" class="form-control with-border" aria-label="" maxlength="4" name="value" id="value" data-type="<?php echo $data->sale_type?>" value="<?php echo $data->value?>">
                        <div class="input-group-append voucher-value">
                            <button type="button" class="btn btn-outline-secondary btn-value">
                                <?php                               
                                global $config; 
                                if($data->sale_type=="price") echo '&euro;';
                                else echo "%";
                                ?>
                            </button>
                            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only"></span>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item value-type" data-type="percent" href="#">%</a>
                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item value-type" data-type="value" href="#">&euro;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="submit-field customer-search-wrap">
                    <h5><?php echo $lang['CUSTOMER']?></h5>
                    <div class="input-with-icon-left">
                        <i class="la la-user"></i>
                        <input type="text" class="with-border" id="cust_name" name="cust_name" data-name="<?php echo $data->cname?>" autocomplete="off" data-noresults-text="" maxlength="50" value="<?php echo $data?$data->cname:''?>" placeholder="Type to find customers"/>
                    </div>                
                </div>
            </div>
            <div class="col-xl-5 col-md-12">
                <div class="submit-field">
                    <h5><?php echo $lang['NOTE']?></h5>
                    <input type="text" class="with-border" id="note" name="note" maxlength="100" value="<?php echo $data?$data->note:''?>"/>                
                </div>
            </div>
        </div>    
        <div class="row submit-field save-result-msg" style="display:none;" data-success="<?php echo $lang['SAVED_SUCCESS']?>" data-error="<?php echo $lang['ERROR']?>">
            <div class="col-xl-12 col-md-12"><i class="la la-exclamation-circle" style="font-weight:bold;font-size:20px;margin-right:12px;"></i><span><span></div>
        </div>
        
        <button class="button form-cmd button-sliding-icon ripple-effect" type="submit" style="margin-right:4px;">
            <span><?php echo $data->status=='expired' ? $lang['RENEW'] : $lang['SAVE'] ?></span>
            <i class="icon-material-outline-arrow-right-alt"></i>
        </button>
        <button class="button form-cmd button-sliding-icon ripple-effect" type="button" id="btnCancel" onclick="history.back()"><span><?php echo $lang['CANCEL'] ?></span><i class="icon-feather-x"></i></button>
        
        <input type="hidden" name="id" value="<?php echo isset($this->model->data['id']) ? $this->model->data['id'] : 0 ?>">
        <input type="hidden" id="ptkn" name="<?php echo $_SESSION['user']['login_string']?>" data-challenge="<?php echo $key?>">
        <input type="hidden" name="sale_type" id="sale_type" value="<?php echo $data->sale_type ? $data->sale_type : 'price'?>"/>
        <input type="hidden" name="cust_id" id="cust_id" value="<?php echo $data->cust_id?>"/>
        <input type="hidden" name="status" value="<?php echo $data->status?>"/>
    </form>
</div>