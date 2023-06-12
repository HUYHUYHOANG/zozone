<?php
$key = CBoCtrl::generateSessionKey();
//$siteURL = $_SESSION['user']['site_url'];
global $config;
$siteURL = $config['site_url'];
?>
<?php isset($this) or die(':-)'); ?>
<form id="frm-booking-settings" action="<?php echo $siteURL?>php/ctrls/bo/?<?php echo $_SESSION['user']['login_string']?>&d0=save-booking-settings&m=reservation">
    <div class="popup-tab-content">
        <div class="submit-field">
            <div class="row">                
                <label class="col-sm-12 dialog control-label font-weight-bold"><?php echo $lang['BOOKING'] . ' ' . $lang['TEMPLATE'] ?></label>
                <label class="col-sm-12"><?php echo $lang['PLZ_SELECT_THE_BOOKING_TEMPLATE_FRONT_END']?></label>
                <div class="col-sm-12">
                    <select class="form-control selectpicker" id="shop_booking_template" name="shop_booking_template">
                        <option value="1" <?php echo $settings['template']==1?'selected':'' ?>><?php echo $lang['BOOKING_TEMPLATE_TYPE_EPML_FIRST']?></option>
                        <option value="2" <?php echo $settings['template']==2?'selected':'' ?>><?php echo $lang['BOOKING_TEMPLATE_TYPE_SVCS_FIRST']?></option>
                    </select>
                </div>
            </div>
            <!--total number of employees who can perform the service-->
            <div class="row booking-settings-staffs">
                <div class="col-sm-12 switch-container" style="margin-top:6px;">
                    <label class="switch">
                        <input name="booking_show_staffs_list" id="booking_show_staffs_list" value="1" type="checkbox" <?php if($settings['booking_show_staffs_list']) echo "checked='checked'"?>>
                        <span class="switch-button-right"></span> <?php echo $lang['BOOKING_SHOW_STAFFS_LIST']?>
                    </label>
                </div>
                <label class="col-sm-9 control-label"><?php echo $lang['BOOKING_NUMBER_OF_STAFFS']?></label>
                <div class="col-sm-3"><input type="number" max="20" class="width-border text-right" id="total_bookable_staffs" name="total_bookable_staffs" value="<?php echo $settings['booking_total_bookable_staffs'] ?>"/></div>                
            </div>
            <div class="row">                
                <label class="col-sm-12 dialog control-label label-payment font-weight-bold"><?php echo $lang['ALLOW_ONLINE_PAYMENT']?></label>                
                <div class="col-sm-12 switch-container">
                    <label class="switch">
                        <input name="shop_pay_via_paypal" id="shop_pay_via_paypal" value="1" type="checkbox" <?php if($settings['paypal']) echo "checked='checked'"?>>
                        <span class="switch-button-right"></span> <?php echo $lang['PAYPAL']?>
                    </label>
                </div>
                <div class="col-sm-12 switch-container">
                    <label class="switch">
                        <input name="shop_pay_via_stripe" id="shop_pay_via_stripe" value="1" type="checkbox" <?php if($settings['stripe']) echo "checked='checked'"?>>
                        <span class="switch-button-right"></span> <?php echo $lang['STRIPE']?>
                    </label>
                </div>
            </div>            
            <!--remind the customers when their booking date is coming up-->
            <div class="row">
                <label class="col-sm-12 dialog control-label label-payment font-weight-bold"><?php echo $lang['BOOKING_COMING_UP_REMINDER_LABEL']?></label>
                <div class="col-sm-12 switch-container">
                    <label class="switch">
                        <input name="booking_reminder_by_a_week" id="booking_reminder_by_7_week" value="1" type="checkbox" <?php if($settings['booking_reminder_by_a_week']) echo "checked='checked'"?>>
                        <span class="switch-button-right"></span> <?php echo $lang['BOOKING_COMING_UP_REMINDER_BY_A_WEEK']?>
                    </label>
                </div>
                <div class="col-sm-12 switch-container">
                    <label class="switch">
                        <input name="booking_reminder_by_a_day" id="booking_reminder_by_a_day" value="1" type="checkbox" <?php if($settings['booking_reminder_by_a_day']) echo "checked='checked'"?>>
                        <span class="switch-button-right"></span> <?php echo $lang['BOOKING_COMING_UP_REMINDER_BY_A_DAY']?>
                    </label>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-12 control-label"><?php echo $lang['BOOKING_REMINDER_MESSASGE_TEMPLATE'] ?></label>
                <div class="col-sm-8">
                    <select class="selectpicker" id="msg-template" name="booking_reminder_msg_template">
                    <?php
                        $preType = "";
                        foreach($settings['messageTemplates'] as $template){
                            /*if($preType != $template->template_type){
                                if($preType != "")
                                    echo '</optgroup>';
                                $ttype = strtoupper($template->template_type);
                                $label = isset($lang[$ttype]) ? $lang[$ttype] : str_replace('_', ' ', $template->template_type);                                
                                echo "<optgroup label='{$label}'>";
                                $preType = $template->template_type;
                            }*/
                            $selected = $settings['booking_reminder_msg_template'] == $template->id ? 'selected' : '';
                            echo "<option value='{$template->id}' {$selected}>{$template->name}</option>";
                        }
                    ?>
                    </select>
                </div>
                <!--<div class="col-sm-4">
                    <select class="selectpicker" id="msg-lang-code" name="booking_reminder_msg_langcode">
                    <?php
                    foreach($settings['activeLangCodes'] as $alang){
                        $selected = $settings['booking_reminder_msg_langcode'] == $alang['code'] ? 'selected' : '';
                        echo "<option value='{$alang['code']}' {$selected}>{$alang['name']}</option>";
                    }
                    ?>  
                    </select>
                </div>-->
            </div>
        </div>
        <div id="form-submit-msg" class="notification success" style="display:none;padding:10px;margin-top:12px;" data-success="<?php echo $lang['SAVED_SUCCESS']?>" data-error="<?php echo $lang['ERROR']?>"><?php echo $lang['SAVED_SUCCESS']?></div>
        <div class="row" style="margin-top:12px;">
            <div class="col-sm-6">
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="submit"><span><?php echo $lang['SAVE'] ?></span><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
            <div class="col-sm-6">
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="button" onclick="$.magnificPopup.close()"><?php echo $lang['CLOSE'] ?><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
        </div>
    </div>    
    <input type="hidden" id="ptkn" name="<?php echo $_SESSION['user']['login_string']?>" data-challenge="<?php echo $key?>">
</form>

<style>
    #total_bookable_staffs:disabled{
        background-color: #FAFAFA;
    }
</style>

<script type="text/javascript" src="<?php echo $siteURL?>templates/<?php echo $config['tpl_name']?>/plugins/codec.min.php"></script>
<script type="text/javascript">    
    $(function(){
        
        var $theShowListCheck = $('#booking_show_staffs_list');

        $('.selectpicker').each(function(){
            $(this).selectpicker({title : $(this).data('hdr')}).selectpicker('render');
        });

        $theShowListCheck.click(function(){            
            $('#total_bookable_staffs').prop('disabled', $(this).prop('checked')).toggleClass('disabled');            
        });
        if($theShowListCheck.prop('checked'))
            $('#total_bookable_staffs').prop('disabled', $theShowListCheck.prop('checked')).toggleClass('disabled');
        $('#total_bookable_staffs').change(function(){
            let v = parseInt($(this).val());
            if(v<=0) v = 1;
            if(v>20) v = 20;
            $(this).val(v);
        });

        $('#frm-booking-settings').submit(function(){
            try{
                $saveChanges($(this));
            }catch(e){
                console.log(e.message);
            }
            return false;
        });

        $saveChanges = function($form){
            $form.find('.button').addClass('loading').addClass('disabled').prop('disabled',1);
            $.post($form.prop('action'), $form.serialize(), function(rp){
                let json = $.parseJSON(rp);
                let themsg = $('#form-submit-msg');
                if(json.error){
                    themsg.addClass('text-danger').removeClass('success').text(themsg.data('error'));
                    themsg.slideDown();                    
                }else{
                    themsg.addClass('success').removeClass('text-danger').text(themsg.data('success'));
                    themsg.slideDown();
                    setTimeout(function(){
                        themsg.slideUp();
                    }, 2000);
                }
                $form.find('.button').removeClass('loading').removeClass('disabled').prop('disabled',0);
            });   
            return false;
        };
    });
</script>
<style>
    @media screen and (max-width: 576px){
        .booking-settings-staffs{
            margin-top:20px;
        }
    }
    
</style>