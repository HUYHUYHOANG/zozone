<?php
$key = CBoCtrl::generateSessionKey();
$siteURL = $_SESSION['user']['site_url'];
?>
<?php isset($this) or die(':-)'); ?>
<form id="frm-lang-settings" action="<?php echo $siteURL?>php/ctrls/bo/?<?php echo $_SESSION['user']['login_string']?>&d0=change-language-settings&m=shop-options">
    <div class="popup-tab-content">
        <div class="submit-field" style="margin-bottom:0;">
            <div class="row">                
                <div class="col-sm-12" style="max-height:350px;overflow-y:auto;border:1px dotted #CCC;">
                    <table class="table table-responsive" style="width:100%;">
                        <tr style="background-color:#FAFAFA;font-weight:bold;">
                            <td width="65%" class="text-left"><?php echo $lang['LANGUAGE']?></td>
                            <td width="15%" class="text-left">&nbsp;</td>
                            <td width="5%" class="text-center">&nbsp;</td>
                        </tr>
                        <?php
                        $langs = $this->model->getAllLanguages();
                        $idx = 1;
                        foreach($langs as $item){
                            $item = (object)$item;
                            echo "<tr><td><a data-id='{$item->id}'>{$item->name}</a></td><td>{$item->code}</td><td class='text-center'  style='height:36px;'>";
                            /*if($item->code!='de') echo $this->_languageState($item->id, $item->active);
                            else echo "<i style='color:var(--classic-color-1)' class='fa fa-check-square-o'></i>";*/
                            echo $this->_languageState($item->id, $item->active, $item->code);
                            echo "</td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">            
            <div class="col-sm-12 switch-container zero-padd-left">
                <label class="switch" style="cursor:pointer;">
                    <input id="optTranlateData" value="1" type="checkbox" checked="">
                    <span class="switch-button left"></span> <?php echo $lang['TRANSLATE_SHOP_DATA_SWITCH'] ?>
                </label>
            </div>
        </div>
        <div id="form-submit-msg" class="notification success" style="display:none;padding:10px;" data-success="<?php echo $lang['SAVED_SUCCESS']?>" data-error="<?php echo $lang['ERROR']?>"><?php echo 'Please do not close...' ?></div>
        <div class="row">            
            <div class="col-sm-12">
                <button id="btnClose" class="margin-top-15 button button-sliding-icon ripple-effect" data-text="<?php echo $lang['CLOSE'] ?>" type="button" onclick=""><span><?php echo $lang['CLOSE'] ?></span><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
        </div>
    </div>    
    <input type="hidden" id="ptkn" name="<?php echo $_SESSION['user']['login_string']?>" data-challenge="<?php echo $key?>">
    <input type="hidden" id="confirm-msg" value="<?php echo $lang['TURN_ON_LANGUAGE_CONFIRM_MSG'] ?>"/>
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
</style>
<script type="text/javascript" src="<?php echo $siteURL?>templates/<?php echo $_SESSION['user']['tpl_name']?>/plugins/codec.min.php"></script>
<script type="text/javascript" src="<?php echo $siteURL?>templates/<?php echo $_SESSION['user']['tpl_name']?>/plugins/shop-util.js"></script>
<script type="text/javascript" src="<?php echo $siteURL?>templates/<?php echo $_SESSION['user']['tpl_name']?>/js/sweetalert.min.js"></script>
<script type="text/javascript">
    
    $(function(){        
        $('#frm-lang-settings').data('setting-changed', 'n');
        $('.mfp-container,.mfp-content').preventBgClose();
        $('input[type="checkbox"].change-lang-state').click(function(){
            let $this = $(this);
            let id = $(this).data('id');
            let active = $(this).data('active');
            let code = $(this).data('code');
            let data = { id : id, code : code, state : (active+1)%2 , translate : $('#optTranlateData').prop('checked')?1:0};
            if(data.state && data.translate){
                $this.confirm( $('#confirm-msg').val(), 
                    function(){                        
                        $.updateShopLanguageState($this, data);                        
                    }, 
                    function(){
                        $this.prop('checked', false).val(0);
                        return false;
                    }
                );
            }else{                
                $.updateShopLanguageState($this, data);
            }
        });

        $('#btnClose, #dlgWrapper .mfp-close').click(function(){            
            $.magnificPopup.close();
            if($('#frm-lang-settings').data('setting-changed')=='y') document.location.reload();
        });
    });

    $.updateShopLanguageState = function($this, data){
        $('#frm-lang-settings').data('setting-changed', 'y');
        $.enableLangStateList(1);        
        $('#btnClose').addClass('loading').addClass('disabled').prop('disabled',1).children('span').text('');
        $('.mfp-close').hide();
        $.post($('#frm-lang-settings').prop('action'), data, function(rp){   
            console.log(rp);
            $.enableLangStateList(0);
            try{
                $('#btnClose').removeClass('loading').removeClass('disabled').prop('disabled',0).children('span').text($('#btnClose').data('text'));
                $('.mfp-close').show();

                let json = $.parseJSON(rp);                
                if(json.result==1){
                    $this.data('active', data.state);
                    if(!data.state) $this.children().toggleClass('fa-check-square-o').toggleClass('fa-square-o');
                    else  $this.children().toggleClass('fa-square-o').toggleClass('fa-check-square-o');
                }
            }catch(e){}
        });
    };

    $.enableLangStateList = function(flag){
        $('#frm-lang-settings').find('input[type="checkbox"]').each(function(){
            if($(this).data('code') == 'de') return;
            if(flag){
                $(this).prop('disabled', 1).next().addClass('disabled').parent().addClass('disabled');
            }else {
                $(this).prop('disabled', 0).next().removeClass('disabled').parent().removeClass('disabled');
            }
        });
    };
</script>