<?php
$key = CBoCtrl::generateSessionKey();

$siteURL = $_SESSION['user']['site_url'];
$jsPath = $siteURL . 'storage/user-fonts/';
$fontFolder = '../../../storage/user-fonts/';
$fonts = $this->model->prepareUserFonts($fontFolder);
?>
<?php isset($this) or die(':-)'); ?>
<form id="frm-font-settings" action="<?php echo $siteURL?>php/ctrls/bo/?<?php echo $_SESSION['user']['login_string']?>&d0=save-font-settings&m=shop-options">
    <div class="popup-tab-content">
        <div class="submit-field" style="margin-bottom:0;">
            <div class="row">
                <label class="col-sm-12 dialog control-label"><?php echo $lang['SECTION']; ?></label>
                <div class="col-sm-12">
                    <select class="form-control" id="font-option-name" name="font-option-section">
                        <?php
                        $options = $this->model->getAllFontSettings();
                        foreach($options as $k => $obj){
                            $fontFace = $obj->{'font-face'};
                            $fontSize = $obj->{'font-size'};
                            $fontWeight = $obj->{'font-weight'};
                            $fontStyle = $obj->{'font-style'};
                            $fontPath = $obj->{'font-path'};
                            echo "<option value='{$k}' data-font-face='{$fontFace}' data-font-size='{$fontSize}' data-font-weight='{$fontWeight}' data-font-style='{$fontStyle}' data-font-path='{$fontPath}'>{$obj->{'section_name'}}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-12 dialog control-label"><?php echo $lang['SETTING']?></label>
                <div class="col-sm-9">
                    <select class="form-control font-options" id="font-face" name="font-face">
                        <option value=""><?php echo $lang['DEFAULT'] ?></option>
                        <?php
                            foreach($fonts as $font){
                                $srcList = $font->src;
                                $lists = "";
                                foreach($srcList as $src){
                                    $lists .= $src . ",";
                                }
                                $lists = trim($lists, ",");
                                echo "<option value='{$font->face_name}' data-path='{$font->path}' data-src='{$lists}'>{$font->face_name}</option>";
                            }
                        ?>
                    </select>
                </div>                
                <div class="col-sm-3">
                    <input type="text" class="form-control text-right font-options" id="font-size" name="font-size" value="20" placeholder="<?php echo $lang['SIZE'] ?>" maxlength="3">
                </div>
                <div class="col-sm-6">
                    <select class="form-control font-options" id="font-weight" name="font-weight">
                    <option value="normal">[<?php echo $lang['FONT_WEIGHT']; ?>]</option>
                        <option value="normal"><?php echo $lang['NORMAL']; ?></option>
                        <option value="bold"><?php echo $lang['BOLD']; ?></option>
                    </select>                    
                </div>
                <div class="col-sm-6">
                    <select class="form-control font-options" id="font-style" name="font-style">
                    <option value="normal">[<?php echo $lang['FONT_STYLE']; ?>]</option>
                        <option value="normal"><?php echo $lang['NORMAL']; ?></option>
                        <option value="italic"><?php echo $lang['ITALIC']; ?></option>
                    </select>
                </div>      
                <div class="col-sm-12 preview-wrap"  style="display:table">
                    <div class=""  style="display:table-cell;vertical-align:middle;">
                        <div class="text-preview" id="font-settings-preview">
                    </div>
                </div>
            </div>
        </div>        
        <div id="form-submit-msg" class="notification success" style="display:none;padding:10px;" data-success="<?php echo $lang['SAVED_SUCCESS']?>" data-error="<?php echo $lang['ERROR']?>"><?php echo $lang['SAVED_SUCCESS']?></div>
        <div class="row">            
            <div class="col-sm-6">
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="submit"><span><?php echo $lang['SAVE'] ?></span><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
            <div class="col-sm-6">
                <button class="margin-top-15 button button-sliding-icon ripple-effect" type="button" onclick="$.magnificPopup.close()"><?php echo $lang['CLOSE'] ?><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
        </div>
    </div>
    <input type="hidden" id="font-path" name="font-path">
    <input type="hidden" id="font-src" name="font-src">
    <input type="hidden" id="option-desc" name="option-desc" value="General">    
    <input type="hidden" id="ptkn" name="<?php echo $_SESSION['user']['login_string']?>" data-challenge="<?php echo $key?>">
</form>

<script type="text/javascript" src="<?php echo $siteURL?>templates/<?php echo $_SESSION['user']['tpl_name']?>/plugins/codec.min.php"></script>
<script type="text/javascript">
    var ptRequest = null, hidePreviewID = 0, bFormSubmiting = 0;
    $(function(){
        $('.selectpicker').each(function(){
            //$(this).selectpicker({title : $(this).data('hdr')}).selectpicker('render');
        });

        $('#frm-font-settings').submit(function(){
            $.saveFontSettings(this);
            return false;
        });

        $('#font-option-name').change(function(){
            var option = $(this).find(':selected');
            $('#option-desc').val(option.text());
            $('#font-face').val(option.data('font-face'));
            $('#font-size').val(option.data('font-size'));
            $('#font-weight').val(option.data('font-weight'));
            $('#font-style').val(option.data('font-style'));
            $.previewSetting();            
        });

        $('.font-options').change(function(){            
            if($(this).prop('id')=='font-size'){
                var v = parseInt($(this).val());
                if(isNaN(v) || v<10) v = '';
                else if(v>200) v = 200;
                $(this).val(v);
            }
            $.previewSetting();
        });

        $('button.font-preview').click(function(){
            $.previewSetting();
        });

        $('#font-option-name').trigger('change');
        $.previewSetting();
    });

    $.previewSetting = function(){
        if(hidePreviewID) clearTimeout(hidePreviewID);

        var fn = $('#font-face').val();
        if(fn===null) return;
        
        var path = $('#font-face').find(':selected').data('path');
        var src = $('#font-face').find(':selected').data('src');
        var preview = $('#font-settings-preview');
        var fontWeight = $('#font-weight').val();
        var fontStyle = $('#font-style').val();
        var fontSize = parseInt($('#font-size').val());
        if(isNaN(fontSize) || fontSize<=0)
            fontSize = '';
        else fontSize += "px";
        
        $('#font-path').val(path);
        $('#font-src').val(src);
        
        if(!fn.length){
            preview.text(''); return;
        } 

        preview.text(fn).css({'font-family':fn, 'font-size':fontSize, 'font-weight':fontWeight, 'font-style':fontStyle}).slideDown().fontface({
            fontName : fn,
            fontFamily : [fn],
            filePath : "<?php echo $jsPath?>" + path + "/",
            fileName : src,                 
        });

        preview.parent().parent().height(fontSize);
    };
    $.saveFontSettings = function(_form){
        if(bFormSubmiting) return;

        bFormSubmiting = 1;
        var $form = $(_form);        
        var $msg = $('#form-submit-msg');

        /*decode the challenge*/
        /*if($('#ptkn').data('change') !='y'){            
            $('#ptkn').val($('#ptkn').data('challenge').decode()).data('change','y');
        }*/
        $('#ptkn').val($('#ptkn').data('challenge').decode());
        
        $msg.removeClass('error').addClass('success').text("<?php echo $lang['UPDATING']?>").slideDown();
        var r = null;
        ptRequest = $.post($form.prop('action'), $form.serialize(), function(response){                     
            try{
                r = $.parseJSON(response);
                if(r.error){
                    $msg.removeClass('success').addClass('error');
                    if(r.field && r.field.length){
                        $msg.text(r.text);
                        $('#' + r.field).focus().addClass('input-error');
                    }else{
                        if(r.text && r.text.length) $msg.text(r.text);
                        else $msg.text($msg.data('error'));
                    } 
                    console.log(r);
                }else{
                    $msg.removeClass('error').addClass('success').text($msg.data('success'));
                    //update settings for preview
                    var option = $('#font-option-name').find(':selected');
                    option.data('font-face', $('#font-face').val());
                    option.data('font-size', $('#font-size').val());
                    option.data('font-weight', $('#font-weight').val());
                    option.data('font-style', $('#font-style').val());
                }                
            }catch(e){
                //console.log(e.message);
            }
        });
        ptRequest.always(function(dataOrjqXHR, textStatus, jqXHRorErrorThrown){
            bFormSubmiting = 0;
            /*console.log(jqXHRorErrorThrown);*/
            setTimeout(function(){
                $msg.slideUp();
                if(r && r.error && r.field && r.field.length){
                    $('#' + r.field).removeClass('input-error');
                }
            }, 1500);
        });
    };
</script>
<script type="text/javascript">
(function($){
    var hidePreviewID = 0;
    $.fn.preview = function(fontName, fontPath, fontSrc, fontSize){
        if(hidePreviewID) clearTimeout(hidePreviewID);
        $this = $(this);
        $(this).text(fontName).css('font-size', fontSize).slideDown().fontface({
                fontName : fontName,
                fontFamily : [fontName],
                filePath : fontPath,
                fileName : fontSrc, 
                fontSize : fontSize
            });
        hidePreviewID = setTimeout(function(){
            $this.slideUp();
        }, 3000);
    };

 	$.fn.fontface = function(options) {
		var stacks = {
				serif : ", Times New Roman , serif",
				sansserif : ", Helvetica, Arial, sans-serif"
			},
			 defaults = {
				filePath: "/_fonts/",//change this to your font directory location
				fontFamily: "sans-serif",
				fontStack: false,
				fontStretch: "normal",
				fontStyle: "normal",
				fontVariant: "normal",
				fontWeight: "normal",
                fontSize : 20                
			},
			options = $.extend(defaults, options);

		//options.fontFile = options.filePath + options.fileName;        
            
		if (options.fontStack || options.fontFamily === "sans-serif") {
			if (options.fontStack && options.fontStack.indexOf(", ") === -1) {
				options.fontFamily = options.fontName + stacks[options.fontStack];
			}
			else if (options.fontStack && options.fontStack.indexOf(", ") !== -1) {
				var concat = (options.fontStack.substring(0,2) !== ", ") ? "" + ", " : "";
				options.fontFamily = options.fontName + concat + options.fontStack;
			}
			else {
				options.fontFamily = options.fontName + stacks.sansserif
			}
		}

		if (typeof options.fontFamily === "object") {
			options.fontFamily = options.fontFamily.join(", ");
		}

		if ($("#jQueryFontFace").length === 0) {//haven't already made one
			$("head").prepend($("<style type=\"text/css\" id=\"jQueryFontFace\"/>"));
		}

		var FF = {
			selector: function (obj) {
				var tag = obj.tagName,
					className = (obj.className) ? "." + obj.className.split(" ").join(".") : "",
					id = ($(obj).attr("id")) ? "#" + $(obj).attr("id") : "";
					
				return tag + id + className;
			},
			create: function (obj) {
				var fontFace = "",
					rule = "",
					fontfamily = options.fontFamily.replace(/\s/g,"").replace(/,/g,""),
					fontfamilyStyleWeight = fontfamily + options.fontStyle + options.fontWeight,
					selector = FF.selector(obj);

				if (!$("#jQueryFontFace").data(fontfamilyStyleWeight)) {
                    var anames = options.fileName.split(',');
                    var uriList = '';
                    anames.forEach(function(item, index){
                        uriList += "url(\"" + (options.filePath + '' + item) + "\") format('truetype')";
                        if(index<anames.length-1) uriList += ",";
                    });
                    //"src: local('☺'), url('" + options.fontFile + ".woff') format('woff'), url('" + options.fontFile + ".ttf') format('truetype'), url('" + options.fontFile + ".svg#" + fontfamily + "') format('svg');",
					fontFace = [
						"@font-face {",
							"\tfont-family: \"" + options.fontName + "\";",
							/*"\tsrc: url('" + options.fontFile + ".eot');",*/
							"\tsrc: /*local('☺'),*/" + uriList + ";",
							"\tfont-stretch: " + options.fontStretch + ";",
							"\tfont-style: " + options.fontStyle + ";",
							"\tfont-variant: " + options.fontVariant + ";",
							"\tfont-weight: " + options.fontWeight + ";",
						"}"
					].join("\n");
					$("#jQueryFontFace").data(fontfamilyStyleWeight, true);
				}

				/*
                if (!$("#jQueryFontFace").data(selector)) {
					rule = [
						selector + " {",
							"\tfont-family: " + FF.quote(options.fontFamily) + " !important;",                            
                            "\tfont-size: " + options.fontSize + ";",
                            "\tfont-weight: " + options.fontWeight + ";",
                            "\tfont-style: " + options.fontStyle + ";",
						"}"
					].join("\n");
					$("#jQueryFontFace").data(selector, selector);
				}*/

				return (fontFace.length || rule.length) ? fontFace + "\n" + rule + "\n" : "";
			},
			quote: function (string) {
				var split = string.split(", "),
					length = split.length;
				for (var i = 0; i < length; i += 1) {
					if (split[i].indexOf(" ") !== -1) {
						split[i] = '"' + split[i] + '"';
					}
				}
				return split.join(", ");
			}
		};

		return this.each(function() {
			$("#jQueryFontFace").text($("#jQueryFontFace").text() + FF.create(this));
		});
	};
})(jQuery);
</script>