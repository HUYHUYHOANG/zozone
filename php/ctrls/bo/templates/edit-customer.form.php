<?php
isset($this) or die(':-)');
require_once('./models/config-data-model.class.php');
$key = CBoCtrl::generateSessionKey();
$dob = '';  
if($data && $data->dob)
    $dob = DateTime::createFromFormat('Y-m-d', $data->dob);
?>

<form id="frmCustomer" method="post"  action="./customers?d0=save-customer&ajax=true">
    <div class="popup-tab-content">
        <div id="form-submit-msg" class="notification error" style="display:none"></div>
        <div class="submit-field" style="margin-bottom:0;">
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['NAME'] ?> *</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="50" id="cust-name" name="name" value="<?php echo $data?$data->name:''?>"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label" style="position:relative;top:-5px"><?php echo $lang['GENDER'] ?></label>
                <div class="col-sm-9 row" style="padding-right:0;">
                    <div class="col-lg-6 col-sm-6">
                        <div class="row" style="margin-top: 10px;">
                            <label class="col-sm-6 form-check form-check-inline" style="margin-right:0 !important">
                                <input type="radio" name="gender" value="male" <?php echo $data && $data->gender=='male'?'checked':'' ?>/><?php echo $lang['GENDER_MALE'] ?>
                            </label>
                            <label class="col-sm-6 form-check form-check-inline" style="margin-right:0 !important">
                                <input type="radio" name="gender" value="female" <?php echo $data && $data->gender=='female'?'checked': (!$data?'checked':'') ?>/><?php echo $lang['GENDER_FEMALE'] ?>
                            </label>
                            </div>
                    </div>
                    <label class="col-lg-2 col-sm-2 control-label text-right" style="text-overflow:ellipsis;overflow-x:hidden" title="<?php echo $lang['DOB'] ?>"><?php echo $lang['DOB'] ?></label>
                    <div class="col-lg-4 col-sm-4" style="padding-right:0;">
                        <input type="text" class="form-control" maxlength="10" id="cust-dob" name="dob" placeholder="mm-dd-yyyy" value="<?php echo $dob ? $dob->format('m-d-Y') : '' ?>" data-value="<?php echo $dob ? $dob->format('m-d-Y') : ''?>"/>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label id="lbl-cust-group" class="col-sm-3 control-label"><?php echo $lang['GROUP'] ?> *</label>
                <div class="col-sm-9">
                    <select class="selectpicker" data-live-search="true" id="group_id" name="group_id">
                        <option value="">[<?php echo $lang['SELECT'] . ' ' . $lang['GROUP'] ?>]</option>
                    <?php
                    if($this->model->groups){
                        $selectedID = $data ? $data->group_id : 0;
                        foreach($this->model->groups as $r){
                            echo sprintf('<option value="%d" %s data-subtext="<i class=\'icon-feather-users\'></i> %12d">%s</option>', $r['id'], $selectedID==$r['id']?'selected':'', $r['customers'], $r['name']);
                        }
                    }
                    ?>
                    </select>
                </div>
            </div>
            <div class="form-group row divider"></div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['PHONE'] ?></label>
                <div class="row col-sm-9" style="padding-right:0;">
                    <div class="col-lg-5 col-sm-5">    
                        <input type="text" class="form-control" maxlength="15"  name="phone" value="<?php echo $data ? $data->phone:''?>"/>
                    </div>
                    <label class="col-lg-2 col-sm-2 control-label text-right">Email</label>
                    <div class="col-lg-5 col-sm-5" style="padding-right:0;position:relative;">
                        <input type="text" maxlength="30" id="email" name="email" value="<?php echo $data ? $data->email:''?>"/>
                        <span id="email-status">
                            <span class="status-not-available" data-invalid="This is not a valid email address" data-exist="Email address already exists"></span>
                        </span>
                    </div>
                </div>
            </div>            
            <div class="form-group row">
                <label class="col-sm-3 control-label">Facebook</label>
                <div class="col-sm-9">                    
                    <input type="text" class="form-control" maxlength="100" id="cust-facebook" name="facebook" value="<?php echo $data ? $data->facebook:''?>"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label">Instagram</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="100" id="cust-instagram" name="instagram" value="<?php echo $data ? $data->instagram:''?>"/>
                </div>            
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['ADDRESS'] ?></label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" maxlength="255" id="cust-addr" name="address" value="<?php echo $data ? $data->address:''?>"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['CITY'] ?></label>
                <div class="row col-sm-9" style="padding-right:0;">
                    <div class="col-lg-5 col-sm-5">
                        <input type="text" class="form-control" maxlength="100" id="cust-city" name="city" value="<?php echo $data ? $data->city:''?>"/>
                    </div>
                    <label class="col-lg-2 col-sm-2 control-label text-right"><?php echo $lang['COUNTRY']?></label>
                    <div class="col-lg-5 col-sm-5" style="padding-right:0;">
                        <select class="selectpicker" data-live-search="true" name="country_code">
                            <option value="">[<?php echo $lang['SELECT'] . ' ' . $lang['COUNTRY'] ?>]</option>
                            <?php                                   
                                $file = 'data/countries.json';
                                $content = file_get_contents($file);
                                if($content){
                                    $countries = json_decode($content);
                                    $arr = array();
                                    foreach($countries as $code => $name){
                                        $arr[$code] = $name;
                                    }
                                    asort($arr);
                                    $cnCode = $data ? $data->country_code : '';
                                    foreach($arr as $code=>$name){
                                        $selected = $code==$cnCode ? 'selected' : '';
                                        echo "<option value='{$code}' {$selected}>$name</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['LAST_ACTIVITY'] ?></label>
                <div class="row col-sm-9" style="padding-right:0;">
                    <div class="col-sm-5">    
                        <input type="text" value="<?php echo $data && $data->last_activity ? date('m-d-Y H:i A', strtotime($data->last_activity)) : '' ?>" readonly/>
                    </div>
                    <div class="col-sm-7 switch-wrapper">
                        <label class="control-label" for="newsletter" style="cursor:pointer;">Newsletter</label>
                        <div class="switch-container">
                            <label class="switch">
                                <input id="newsletter" name="send_newsletter" value="1" <?php echo $data&&$data->newsletter==1?'checked':''?> type="checkbox">
                                <span class="switch-button-right"></span>
                            </label>
                        </div>                        
                    </div>                      
                </div>                
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo $lang['NOTE'] ?></label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="1" id="note" name="note"><?php echo $data ? $data->note : '' ?></textarea>
                </div>
            </div>

            <!-- <div class="form-group row">
                
                <div class="col-sm-12 switch-wrapper">
                        <label class="control-label" for="cust-logging" style="cursor:pointer;">Newsletter</label>
                        <div class="switch-container">
                            <label class="switch">
                                <input id="cust-logging" name="do_not_logging" value="<?php echo $data ? !$data->newsletter : 1 ?>" <?php echo $data&&$data->logging==1?'checked':''?> type="checkbox">
                                <span class="switch-button-right"></span>
                            </label>
                        </div>                        
                    </div>   
            </div> -->

            <div class="form-group row">
                <div class="col-sm-3"></div>                 
                <label class="col-sm-9 control-label save-result-msg text-success" style="display:none" data-success="<?php echo $lang['SAVED_SUCCESS']?>" data-error="<?php echo $lang['ERROR']?>..."><?php echo $lang['UPDATING']?>...</label>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-9">
                    <?php
                    if(!$viewOnly){?>
                        <button class="margin-top-15 button button-sliding-icon ripple-effect" type="submit" style="min-width:150px"><?php echo $lang['SAVE'] ?><i class="icon-material-outline-arrow-right-alt"></i></button>
                        <button class="margin-top-15 button button-sliding-icon ripple-effect" type="button" onclick="document.location='./customers'" style="min-width:150px"><?php echo $lang['CANCEL'] ?><i class="icon-feather-x"></i></button>
                    <?php }else{ ?>
                        <button class="margin-top-15 button button-sliding-icon ripple-effect" type="button" onclick="document.location='./customers'" style="min-width:150px"><i class="icon-feather-arrow-left"></i><?php echo $lang['BACK'] ?></button>
                    <?php }?>
                </div>
            </div>
        </div>        
    </div>
    <input type="hidden" name="id" value="<?php echo $id ?>"/>
    <input type="hidden" id="ptkn" name="<?php echo $_SESSION['user']['login_string']?>" data-challenge="<?php echo $key?>">    
</form>