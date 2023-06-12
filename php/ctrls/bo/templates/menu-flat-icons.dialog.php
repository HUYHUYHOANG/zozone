<?php
$key = CBoCtrl::generateSessionKey();
$siteURL = $config['site_url'];

?>
<?php isset($this) or die(':-)'); ?>
<form id="frm-settings" action="<?php echo $siteURL?>php/ctrls/bo/?<?php echo $_SESSION['user']['login_string']?>&d0=save-flat-icon-setting&m=advanced-shop-options">
    <div class="popup-tab-content">
        <div class="submit-field" style="margin-bottom:12px;padding-right:0;">
            <div class="row">                
                <div class="col-sm-12 row">
                    <?php
                    $idx = 0;
                    for($i = 256; $i<=300; ++$i){
                        $hex = "f" . dechex($i);
                        if($hex == $flatIconCode) $activeClass = 'active';
                        else $activeClass = '';
                        echo sprintf("<div class='col-sm-1'><a href='#' class='flat-icon-wrap' data-code='%s'><i class='flat-icon {$activeClass} icon-%d'></i></a></div>", $hex, $i);
                    }
                    ?>
                </div>                
            </div>
        </div>
        <div id="form-submit-msg" class="notification success" style="display:none;padding:10px;" data-success="<?php echo $lang['SAVED_SUCCESS']?>" data-error="<?php echo $lang['ERROR']?>"></div>
        <div class="row">
            <div class="col-sm-6">
                <button id="btnSave" class="margin-top-15 button button-sliding-icon ripple-effect" data-text="<?php echo $lang['SAVE'] ?>" type="button"><span><?php echo $lang['SAVE'] ?></span><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
            <div class="col-sm-6">
                <button id="btnClose" class="margin-top-15 button button-sliding-icon ripple-effect" data-text="<?php echo $lang['CLOSE'] ?>" type="button" onclick="$.magnificPopup.close();"><span><?php echo $lang['CLOSE'] ?></span><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
        </div>
    </div>    
    <input type="hidden" id="ptkn" name="<?php echo $_SESSION['user']['login_string']?>" data-challenge="<?php echo $key?>">
    <input type="hidden" id="flaticon-code" name="flaticon-code" value="<?php echo $flatIconCode ?>">
</form>

<script type="text/javascript">
    $(function(){
        $('.flat-icon-wrap').click(function(){            
            let code = $(this).data('code');            
            
            $('.flat-icon-wrap[data-code!="' + code + '"]').find('i.active').removeClass('active');
            $(this).children('i').toggleClass('active');

            if($(this).children('i').hasClass('active')) $('#flaticon-code').val($(this).data('code'));
            else $('#flaticon-code').val('');
        });

        $('#btnSave').click(function(){            
            let code = $('#flaticon-code').val();
            let themsg = $('#form-submit-msg');
            let $form = $('#frm-settings');
            
            var ptRequest = $.post($form.prop('action'), $form.serialize(), function(response){                
                let r = $.parseJSON(response);                    
                if(r.error){
                    themsg.removeClass('success').addClass('text-danger').text(r.message);
                }else{
                    themsg.removeClass('text-danger').addClass('success').text(r.message);                        
                }
                themsg.slideDown();
            });

            ptRequest.always(function(dataOrjqXHR, textStatus, jqXHRorErrorThrown){
                setTimeout(function(){
                    themsg.slideUp();
                }, 3000);
            });            
        });
    });
</script>