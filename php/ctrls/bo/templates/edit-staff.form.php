<?php
require_once('./models/config-data-model.class.php');
$key = CBoCtrl::generateSessionKey();
$siteURL = $_SESSION['user']['site_url'];

$staffImage = 'default_user.png';
if($data){
    $staffImage = $data->image;
}
$staffImage = $siteURL . 'storage/profile/' . $staffImage;
?>
<?php isset($this) or die(':-)'); ?>
<form id="frmStaff" accept-charset="UTF-8" method="post" enctype="multipart/form-data" action="<?php echo $siteURL?>staffs?d0=save-staff&ajax=true">
    <div class="row"><!--row 1-->
        <div class="col-xl-6 col-md-12">
            <div class="submit-field">
                <h5><?php echo $lang['USERTYPE']?> *</h5>
                <?php
                $selectedType = 'employer';
                if($data){
                    $selectedType = $data['user_type'];
                }
                ?>
                <select class="selectpicker" id="user_type" name="user_type">
                    <option value="employer" <?php echo $selectedType=='employer'?'selected':''?> ><?php echo $lang['EMPLOYEE'] ?></option>
                    <option value="manager" <?php echo $selectedType=='manager'?'selected':''?> ><?php echo $lang['MANAGER'] ?></option>
                </select>                    
            </div>
        </div>
        <!--<div class="col-xl-4 col-md-12">
            <div class="submit-field">
                <h5 class='lblStaffGroup'><?php echo $lang['GROUP']?> *</h5>                
                <select class="selectpicker" id="group_id" name="group_id">
                    <?php
                    if($this->model->groups){                        
                        foreach($this->model->groups as $r){
                            $selectedID = !$data ? 0 : $r['group_id']==$data->group_id;
                            echo sprintf('<option value="%d" %s data-subtext="<i class=\'icon-feather-users\'></i> %12d">%s</option>', $r['group_id'], $selectedID?'selected':'', $r['staffs'], $r['group_name']);
                        }
                    }
                    ?>
                </select>
            </div>
        </div>-->
        <!--<div class="col-xl-6 col-md-12">
            <div class="submit-field">
                <h5 class='lblServiceGroup'><?php echo $lang['SERVICE']?> [staff's skill]</h5>
                <select class="selectpicker" id="svc_gids" multiple data-max-options="100">
                    <?php
                    /*if($this->model->serviceGroups){                        
                        foreach($this->model->serviceGroups as $r){
                            $selectedID = !$data ? 0 : in_array($r['cat_id'], explode(',' ,$data->spec_ids));
                            echo sprintf('<option value="%d" %s>%s</option>', $r['cat_id'], $selectedID?'selected':'', $r['cat_name']);
                        }
                    }*/
                    ?>
                </select>
            </div>
        </div>-->
        <div class="col-xl-6 col-md-12">
            <div class="submit-field">
                <h5><?php echo $lang['NAME']?> *</h5>                
                <input type="text" class="with-border" id="name" name="name" autocomplete="off" maxlength="50" value="<?php echo $data?$data->name:''?>"/>
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="submit-field">
                <h5><?php echo $lang['EMAIL']?> *</h5>
                <div class="input-with-icon-left">
                    <i class="la la-envelope"></i>
                    <input type="text" class="with-border" id="email" name="email" maxlength="50" value="<?php echo $data?$data->email:''?>"/>
                </div>
                <span id="email-status">
                    <span class="status-not-available" data-default-text="<?php echo $lang['EMAILINV']?>" data-exist="<?php echo $lang['EMAIL_EXISTS']?>"></span>
                </span>
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="submit-field">
                <h5><?php echo $lang['USERNAME']?> *</h5>
                <div class="input-with-icon-left">
                    <i class="la la-user"></i>
                    <input type="text" class="with-border" id="username" name="username" maxlength="15" value="<?php echo $data?$data->username:''?>"/>
                </div>
                <span id="user-status">
                    <span class="status-not-available" data-exists="<?php echo $lang['USERUNAV'] ?>" data-uid-ok="<?php echo $lang['USERUAV'] ?>"><?php echo $lang['USERLEN']?></span>
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-md-12">
            <div class="submit-field">
                <h5><?php echo $lang['PASSWORD']?> *</h5>
                <div class="input-with-icon-left">
                    <i class="la la-key"></i>
                    <input type="password" class="with-border pwd" id="pwd" maxlength="20"/>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="submit-field">
                <h5><?php echo $lang['CONFIRM_PASSWORD']?> *</h5>
                <div class="input-with-icon-left">
                    <i class="la la-key"></i>
                    <input type="password" class="with-border pwd" id="pwd-retype" maxlength="20">
                </div>
            </div>
        </div>
        <div id="password-status" class="col-xl-12 col-sm-12" style="position:relative;top:-32px;">
            <span class="status-not-available" data-not-match="<?php echo $lang['PASSNOMATCH'] ?>" data-default-text="<?php echo $lang['PLEASE_ENTER_A_PASSWORD_WITH_A_LENGTH_OF_8_20_CHARACTERS'] ?>"></span>
        </div>
    </div><!--row-->    
    <!--ROW 2-->
    <div class="row">
        <div class="col-xl-6 col-md-12">
            <div class="submit-field">
                <h5><?php echo $lang['GENDER']?></h5>
                <select name="sex" id="sex" class="selectpicker">
                    <?php
                    $selected = $data ? $data->sex : 'Female';
                    ?>
                    <option value="Male" <?php echo $selected=='Male' ? 'selected' : '' ?>><?php echo $lang['GENDER_MALE']?></option>
                    <option value="Female" <?php echo $selected=='Female' ? 'selected' : '' ?>><?php echo $lang['GENDER_FEMALE']?></option>
                </select>
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="submit-field">
            <h5><?php echo $lang['PHONE']?></h5>
                <div class="input-with-icon-left">
                    <i class="la la-phone"></i>
                    <input type="text" class="with-border"  name="phone" maxlength="20" value="<?php echo $data ? $data->phone : ''?>"/>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="submit-field">
                <h5><?php echo $lang['COUNTRY']?></h5>
                <select name="country_code" id="country_code" class="selectpicker" data-live-search="true">
                    <option value="">[<?php echo $lang['SELECT'] . ' ' . $lang['COUNTRY']?>]</option>
                <?php
                $selectedCode = isset($data->code) ? $data->code : 'DE';
                if($countries = CSystemDataModel::getCountriesList()){
                    foreach($countries as $c){
                        $selected = $selectedCode==$c['code']?'selected':'';
                        echo "<option {$selected} value='{$c['code']}'>{$c['asciiname']}</option>";
                    }
                }
                ?>    
                </select>
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="submit-field">
                <h5><?php echo $lang['ADDRESS']?></h5>
                <input type="text" class="with-border" id="address" name="address" value="<?php echo $data ? $data->address : ''?>"/>
            </div>
        </div>        
        <div class="col-xl-12 col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="submit-field">
                        <h5>City</h5>
                        <input type="text" id="city" name="city" class="with-border" placeholder="berlin" value="<?php echo $data ? $data->city : ''?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="submit-field">
                        <h5><?php echo $lang['STATE']?></h5>
                        <input type="text" id="state_code" name="state_code" class="with-border" value="<?php echo $data ? $data->state_code : ''?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="submit-field">
                        <h5><?php echo $lang['ZIPCODE']?></h5>
                        <input type="text" id="zip_code" name="zip_code" class="with-border" placeholder="12345" value="<?php echo $data ? $data->zip_code : ''?>">
                    </div>
                </div>
            </div>
        </div>        
    </div>
    <!--END ROW 2-->
    <!--social links-->
    <div class="row">
        <div class="col-xl-6 col-md-12">
            <div class="submit-field">
                <h5><?php echo $lang['FACEBOOK']?></h5>
                <div class="input-with-icon-left">
                    <i class="la la-facebook"></i>
                    <input type="text" class="with-border" id="facebook" name="facebook" value="<?php echo $data ? $data->facebook : ''?>"/>
                </div>                
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="submit-field">
                <h5><?php echo $lang['TWITTER']?></h5>
                <div class="input-with-icon-left">
                    <i class="la la-twitter"></i>
                    <input type="text" class="with-border" id="twitter" name="twitter" value="<?php echo $data ? $data->twitter : ''?>"/>
                </div>                
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="submit-field">
                <h5><?php echo $lang['GOOGLE_PLUS']?></h5>
                <div class="input-with-icon-left">
                    <i class="la la-twitter"></i>
                    <input type="text" class="with-border" id="googleplus" name="googleplus" value="<?php echo $data ? $data->googleplus : ''?>"/>
                </div>                
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <div class="submit-field">
                <h5><?php echo $lang['INSTAGRAM']?></h5>
                <div class="input-with-icon-left">
                    <i class="la la-instagram"></i>
                    <input type="text" class="with-border" id="instagram" name="instagram" value="<?php echo $data ? $data->instagram : ''?>"/>
                </div>                
            </div>
        </div>
        <div class="col-xl-6 col-md-12">
            <h5><?php echo $lang['IMAGE'] ?></h5>
            <div class="input-file">
                <img src="<?php echo $staffImage ?>" id="staff-image" alt="">
                <div class="uploadButton" <?php echo $viewOnly?"style='display:none'":"" ?>>
                    <input class="uploadButton-input" type="file" accept="image/*" onchange="readImageURL(this,'staff-image')" id="staff_image" name="staff_image"/>
                    <label class="uploadButton-button ripple-effect" for="staff_image"><?php echo $lang['UPLOAD_IMAGE']?></label>
                </div>
            </div>            
        </div>
    </div>
    <!--end social links-->    
    <div class="row submit-field save-result-msg  margin-top-30" data-success="<?php echo $lang['SAVED_SUCCESS']?>" data-error="<?php echo $lang['ERROR']?>">
        <div class="col-xl-12 col-md-12 text-success"><i class="la la-check" style="font-weight:bold;font-size:20px;margin-right:12px;"></i><span><span></div>
    </div>
    <!--analytic info-->
    <div class="row col-xl-12 margin-top-30">
        <button class="button button-sliding-icon ripple-effect" type="submit" style="margin-right:12px;"><span><?php echo $lang['SAVE'] ?></span><i class="icon-material-outline-arrow-right-alt"></i></button>
        <button class="button button-sliding-icon ripple-effect" type="button" id="btnCancel" onclick="document.location='./staffs'"><span><?php echo $lang['CANCEL'] ?></span><i class="icon-feather-x"></i></button>
    </div>
    <input type="hidden" name="id" value="<?php echo isset($this->model->data['id']) ? $this->model->data['id'] : 0 ?>">
    <input type="hidden" name="secret" id="secret">
    <input type="hidden" id="ptkn" name="<?php echo $_SESSION['user']['login_string']?>" data-challenge="<?php echo $key?>">
    <input type="hidden" name="spec_ids" id="spec_ids" value="<?php echo $data?$data->spec_ids:''?>">
</form>