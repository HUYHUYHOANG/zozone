<?php
$key = CBoCtrl::generateSessionKey();
$siteURL = $config['site_url'];

//var_dump($this->settings);
?>
<?php isset($this) or die(':-)'); ?>
<form id="frm-mail-list-settings" action="<?php echo $siteURL?>php/ctrls/bo/?<?php echo $_SESSION['user']['login_string']?>&m=mail-list">
    <div class="popup-tab-content">        
        <div class="submit-field" style="margin-bottom:0;">
            <div class="row" style="margin-top:12px">
                <label class="col-sm-12 dialog control-label font-weight-bold"><?php echo $lang['LABEL_EMAIL_REMIND_CUSTOMER_COME_BACK_SHOP']?></label>
            </div>
            <div class="row">
                <label class="col-sm-12 dialog control-label font-weight-bold"><?php echo $lang['CUSTOMER']?></label>
                <div class="col-sm-12 radio-container">                    
                    <label for="opt_customer_all">
                        <input type="radio" name="customer_setting" id="opt_customer_all" value="all" <?php echo $this->settings->customer_setting=='all'? 'checked':''?>> 
                        <?php echo $lang['ALL_CUSTOMERS'] ?>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 radio-container">                    
                    <label for="opt_customer_group">
                        <input type="radio" name="customer_setting" id="opt_customer_group" value="in-group" <?php echo $this->settings->customer_setting=='in-group'? 'checked':''?>>
                        <?php echo $lang['CUSTOMERS_IN_GROUP']?>
                    </label>
                </div>            
                <div class="col-sm-12">
                    <select id="customer_group" class="form-control selectpicker" multiple>
                        <?php
                        foreach($customerModel->groups as $group){
                            $gid = $group->id;
                            echo "<option value={$gid}>{$group->name}</option>";
                        }
                        ?>                        
                    </select>
                </div>
            </div>
            <div class="row" style="margin-top:10px;">
                <div class="col-sm-12 radio-container">
                    <label for="opt_customer_activity">
                        <input type="radio" name="customer_setting" id="opt_customer_activity" value="last-activity" <?php echo $this->settings->customer_setting=='last-activity'? 'checked':''?>>     
                        <?php echo $lang['LAST_VISIT_AFTER_DAYS'] ?>
                    </label>
                </div>
                <div class="col-sm-12">
                    <input type="number" id="last_visit_days" name="last_visit_days" maxlength=2 class="form-control text-right" style="max-width:100px; float: left" value="<?php echo $this->settings->last_visit_days ?>"> <p style="margin-left: 110px;margin-top: 5px;"><?php echo $lang['DAYS']; ?></p>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-12 dialog control-label font-weight-bold"><?php echo $lang['TEMPLATE'] ?></label>
                <div class="col-sm-8">
                    <select id="email_template" name="email_template" class="form-control selectpicker">
                        <?php
                            $preType = "";
                            foreach($templates as $template){
                                if($preType != $template->template_type){
                                    if($preType != "")
                                        echo '</optgroup>';
                                    
                                    $strType = strtoupper($template->template_type);
                                    $label = isset($lang[$strType]) ? $lang[$strType] : str_replace('_', ' ', $template->template_type);
                                    echo "<optgroup label='{$label}'>";
                                    $preType = $template->template_type;
                                }
                                $selected = $this->settings->email_template==$template->id ? 'selected':'';
                                echo "<option {$selected} value='{$template->id}'>{$template->name}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-4">
                    <select id="email_template_langcode" name="email_template_langcode" class="form-control selectpicker">
                        <?php
                        foreach($activeLanguages as $alang) {
                            $selected = $this->settings->email_template_langcode==$alang['code']?'selected':'';
                            echo "<option {$selected} value='{$alang['code']}'>{$alang['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!--<div class="row">            
                <label class="col-sm-12 dialog control-label font-weight-bold"><?php echo $lang['EXECUTE_TASK'] ?></label>
                <div class="col-sm-12">                    
                    <select name="schedule" class="form-control selectpicker" style="max-width:50%;">                        
                        <option value="weekly"><?php echo $lang['WEEKLY']?></option>
                        <option value="semi-monthly"><?php echo $lang['SEMI_MONTHLY']?></option>
                        <option value="monthly"><?php echo $lang['MONTHLY']?></option>
                    </select>
                </div>
            </div>-->

            <div id="form-submit-msg" class="notification success" style="display:none;padding:10px;margin-top:20px;" 
                data-select-group="<?php echo $lang['PLZ_SELECT_GROUP']?>" data-success="<?php echo $lang['SAVED_SUCCESS']?>" data-error="<?php echo $lang['ERROR']?>"
                data-donotclose="<?php echo $lang['PLZ_DO_NOT_CLOSE_PAGE_WHILE_SENDING_EMAIL']?>"
                data-msgtemplate="<?php echo $lang['PLZ_SELECT_MESSAGE_TEMPLATE'] ?>"></div>

            <div class="row" style="margin-top:12px;">
                <div class="col-sm-4">
                    <button id="btnSendNow" class="margin-top-15 button button-sliding-icon ripple-effect" data-text="<?php echo $lang['SEND_NOW'] ?>" type="button"><span><?php echo $lang['SEND_NOW'] ?></span><i class="icon-material-outline-arrow-right-alt"></i></button>
                </div>
                <div class="col-sm-4">
                    <button id="btnSave" class="margin-top-15 button button-sliding-icon ripple-effect" data-text="<?php echo $lang['CLOSE'] ?>" type="button"><span><?php echo $lang['SAVE'] ?></span><i class="icon-material-outline-arrow-right-alt"></i></button>
                </div>
                <div class="col-sm-4">
                    <button id="btnClose" class="margin-top-15 button button-sliding-icon ripple-effect" data-text="<?php echo $lang['CLOSE'] ?>" type="button" onclick="$.magnificPopup.close()"><span><?php echo $lang['CLOSE'] ?></span><i class="icon-material-outline-arrow-right-alt"></i></button>
                </div>
            </div>
        </div>
    </div>    
    <input type="hidden" id="ptkn" name="<?php echo $_SESSION['user']['login_string']?>" data-challenge="<?php echo $key?>">    
    <input type="hidden" name="group_ids" id="group_ids">
</form>
<style>
    .switch-container.zero-padd-left{ padding-left:0; }
    .switch-button.left{ position:relative;top:5px; }

    .switch-button-right.disabled{        
        cursor: default;
        background-color:var(--classic-color-0_3) !important;
    }
    .switch-button-right.disabled::before{
        background-color:#EEE !important;
    }

    .radio-container{
        margin-top:10px;    
    }
    .radio-container input{
        position:relative;top:4px;
    }
    
    #frm-mail-list-settings .popup-tab-content{
        padding-top:5px;
    }
    #frm-mail-list-settings select{
        position:relative;
        top:-4px;        
    }
    optgroup, .dropdown-header {
        text-transform: capitalize;
    }
</style>

<script type="text/javascript">
    var bFormSubmiting = 0;
    var $form = $('#frm-mail-list-settings');
    var aSelectedGroups = [];
    var themsg = $('#form-submit-msg');
    var gsAction = "save-settings";

    $('.selectpicker').selectpicker({'title':''}).selectpicker('refresh').on('change', function(){            
            if($(this).prop('id')=='customer_group'){
                aSelectedGroups = [];
                $(this).find('option:selected').each(function(){
                    aSelectedGroups.push($(this).val());
                });
            }
        });

    $('#frm-mail-list-settings').find('.dropdown-toggle').click(function(){
        if($(this).data('id') == 'customer_group'){
            $('#opt_customer_group').trigger('click');
        }
    });
    $('#last_visit_days').click(function(){
        $('#opt_customer_activity').trigger('click');
    }).change(function(){
        let v = parseInt($(this).val());
        if(isNaN(v) || v<0) v = 0;
        else if(v>100) v = 100;
        $(this).val(v);
    });

    $('input[name="customer_setting"]').click(function(){
        let $this = $(this);        
        if($this.val()=="all"){
            $('#frm-mail-list-settings').find('.dropdown-toggle[data-id="customer_group"]').prop('disabled', 1);
            //$('#customer_group').prop('disabled', 1);
            $('#last_visit_days').prop('disabled', 1);
            return ;
        }else if($this.val()=='in-group'){
            $('#last_visit_days').prop('disabled', 1);
            $('#customer_group').prop('disabled', 0);
            $('#frm-mail-list-settings').find('.dropdown-toggle[data-id="customer_group"]').prop('disabled', 0);
        }else if($this.val()=='last-activity'){
            $('#frm-mail-list-settings').find('.dropdown-toggle[data-id="customer_group"]').prop('disabled', 1);
            $('#last_visit_days').prop('disabled', false).select();
            //$('#customer_group').prop('disabled', 1);
        }
    });

    $validateFormData = function(){
        if($('#opt_customer_activity').prop('checked')){
            let lastDays = $('#last_visit_days').val();
            if(!lastDays.length){
                $('#last_visit_days').focus(); return false;
            }
        }
        if($('#opt_customer_group').prop('checked')){            
            if(!aSelectedGroups.length){
                var text = themsg.data('select-group');
                themsg.text(text).removeClass('success').addClass('text-danger').slideDown();
                return false;
            }
        }

        var tmpid = $('#email_template').val();
        if(!tmpid || !tmpid.length){
            var text = themsg.data('msgtemplate');
            themsg.text(text).removeClass('success').addClass('text-danger').slideDown();
            return false;
        }
        return true;
    };

    $('#btnSendNow').click(function(){

        if(!$validateFormData()) return false;
        
        let $this = $(this);
        $this.addClass('ajxloading');
        $('.mfp-container,.mfp-content').preventBgClose();
        $('.mfp-close').hide();
        $('#btnSave').prop('disabled',1);
        $('#btnClose').prop('disabled',1);
        themsg.text(themsg.data('donotclose')).slideDown();
        gsAction = "send-mail-list-now";
        $('#frm-mail-list-settings').submit();
        return false;
    });

    $('#btnSave').click(function(){

        if(!$validateFormData()) return false;
        
        var $this= $(this);
        gsAction = "save-settings";
        $this.addClass('ajxloading');
        $('.mfp-container,.mfp-content').preventBgClose();
        $('.mfp-close').hide();
        $('#btnSave').prop('disabled',1);
        $('#btnClose').prop('disabled',1);
        $('#frm-mail-list-settings').submit();
        return false;
    });

    $('#frm-mail-list-settings').submit(function(){
        
        if(!$validateFormData()) return false;
        $('#group_ids').val(aSelectedGroups.toString());
        $form = $(this);
        
        try{        
            
            var ptRequest = $.post($form.prop('action')+'&d0='+gsAction, $form.serialize(), function(response){
                console.log(response);
                try{                    
                    let r = $.parseJSON(response);
                    
                    if(r.error){
                        themsg.removeClass('success').addClass('text-danger').text(r.message);
                    }else{
                        themsg.removeClass('text-danger').addClass('success').text(r.message);                        
                    }
                    themsg.slideDown();
                    setTimeout(function(){
                        themsg.slideUp();
                    }, 3000);
                }catch(e){
                    console.log(e.message);
                }
            });
            ptRequest.always(function(dataOrjqXHR, textStatus, jqXHRorErrorThrown){
                $('#btnSendNow').removeClass('ajxloading').prop('disabled', 0);
                $('#btnSave').removeClass('ajxloading').prop('disabled', 0);
                $('.mfp-close').show();
                $('#btnSave').prop('disabled', 0);
                $('#btnClose').prop('disabled', 0);
                bFormSubmiting = 0;
                
                setTimeout(function(){                    
                }, 1500);
            });
        }catch(e){
            consolog.log(e.message);
        }
        return false;
    });

    $(function(){        
        
    });
    
</script>