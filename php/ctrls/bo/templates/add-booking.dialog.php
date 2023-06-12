
<?php
require_once('./models/config-data-model.class.php');
$key = CBoCtrl::generateSessionKey();
$settings = $_SESSION['__CURRENT_SETTINGS__'];

$startTime = CRequest::getStr("start");
if($startTime){
    $dt = DateTime::createFromFormat('Y-m-d H:i', $startTime);
    if($dt){
        $startTime = $dt->format("m-d-Y H:i");
    }else{
        $startTime = '';
    }
}
?>
<?php isset($this) or die(':-)'); ?>
<form id="frmBookingDlg" action="./reservations?ajax=true&d0=save-booking-record">
    <div class="popup-tab-content">        
        <div style="margin-bottom:0;">
            <!--begin booking detail-->
            <div class="row" style="margin-bottom: 12px;">
                <div class="col-sm-12 submit-field">
                    <h5><?php echo $lang['SERVICE'] ?></h5>                   
                    <input type="text" class="with-border" id="service-ids" name="service-ids" data-value="" data-namelist="" placeholder="<?php echo $lang['TYPE_TO_FIND_SERVICE']?>">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 submit-field">
                    <h5><?php echo $lang['DURATION']?></h5>
                    <input type="text" class="with-border" id="duration" name="duration" value="" data-duration="" readonly data-minute="<?php echo $lang["MINUTE"] ?>">
                </div>    
                <div class="col-sm-6 submit-field">
                    <h5><?php echo $lang['AMOUNT']?></h5>
                    <input type="text" class="with-border" id="service_amount" name="service_amount" value="" readonly data-csign="<?php echo $settings->currency_sign?>">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 submit-field clients-list">
                    <h5><?php echo $lang['CUSTOMER'] ?></h5>
                    <input type="text" class="with-border autocomplete" id="client_id" data-name="client_id" autocomplete="off" placeholder="<?php echo $lang['TYPE_TO_FIND_CUSTOMER']?>">
                    <input type="hidden" name="client_id" value="">
                </div>
            </div>            
            <!--<div class="row">
                <div class="col-sm-6 submit-field">
                    <h5><?php echo $lang['STATUS']?></h5>                    
                    <select class="selectpicker" id="booking-status" name="status">
                    <?php
                        echo CReservationCtrl::getStatuses($data->status);
                    ?>
                    </select>
                </div>
                <div class="col-sm-6 submit-field">
                    <h5><?php echo $lang['REGISTER'] . ' ' . $lang['DATE'] ?></h5>
                    <input type="text" class="with-border" name="res_date" value="" readonly>
                </div>
            </div>-->
            <div class="row">
                <div class="col-sm-6 submit-field">
                    <h5><?php echo $lang['START_TIME'] ?></h5>
                    <input type="text" class="with-border" id="start_time" name="arr_time" value="" data-locale="<?php echo $lang['LOCALE'];?>">
                </div>
                <div class="col-sm-6 submit-field">
                    <h5><?php echo $lang['END_TIME'] ?></h5>
                    <input type="text" class="with-border" id="dep_time" name="dep_time" value="" data-value="" readonly>
                </div>
            </div>
            <div class="row" style="margin-bottom:15px;">
                <div class="col-sm-12 submit-field">
                    <h5><?php echo $lang['STAFF'] ?></h5>                    
                    <select class="selectpicker" id="staff_id" name="staff_id" data-id="">
                        <option value="0">[<?php echo $lang['SELECT']?>]</option>
                        <?php
                        $staffs = $this->model->loadStaffs();
                        if($staffs){
                            foreach($staffs as $staff){                                
                                echo "<option value={$staff['id']} {$selected}>{$staff['name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!--end booking detail-->
        </div>
        <div class="row submit-field" id="save-result-msg" data-success="<?php echo $lang['SAVED_SUCCESS']?>" data-error="<?php echo $lang['ERROR']?>">
            <div class="col-xl-12 col-md-12"><i class="la la-exclamation-circle" style="font-weight:bold;font-size:20px;margin-right:6px;position:relative;top:3px;"></i><span><span></div>
        </div>
        <div class="row">            
            <div class="col-sm-6 col-xs-6">
                <button class="margin-top-15 button button-sliding-icon ripple-effect btnSave" type="submit"><span><?php echo $lang['SAVE'] ?></span><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>                
            <div class="col-sm-6 col-xs-6">
                <button class="margin-top-15 button button-sliding-icon ripple-effect btnClose" type="button" onclick="$.magnificPopup.close()"><?php echo $lang['CLOSE'] ?><i class="icon-material-outline-arrow-right-alt"></i></button>
            </div>
        </div>
    </div>
    <input type="hidden" id="ptkn" name="<?php echo $_SESSION['user']['login_string']?>" data-challenge="<?php echo $key?>">        
    <input type="hidden" id="recdid" name="id" value="">
</form>
<?php
    $this->getServicesJSONDataForScript();
    $this->getCustomerJSONDataForScript();
?>

<script type="text/javascript">
    var isPastRecord = 0;
    var isViewOnly = 0;
    var fCustChanged = 0;

    /*========================================================================================*/
    var clients = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: agclients
    });
    clients.initialize();

    var url_remote = '<?php echo $settings->site_url ?>reservations?d0=get-all-services-2json&ajax=true';        
    var services = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: agservices,        
        remote: {
            url : url_remote,
            wildcard: '%QUERY',
            replace: function (url, query){
                return url + '&qry=' + query;
            },
            filter: services => $.map(services.results, service => ({
                id : service.id,
                name : service.name,
                price : service.price,
                duration : service.duration
            }))
        }
    });
    services.initialize();

    $('#frmBookingDlg').submit(function(){
        
        var staffID = $('#staff_id').val();
        if(staffID==null){
            $('#staff_id').hilite(1); return false;
        }

        var data = {m : $('#frmBookingDlg').prop('action')};
        if($('#ptkn').data('change') !='y'){
            $('#ptkn').val($('#ptkn').data('challenge').decode()).data('change','y');                
        }

        //$('button[type="submit"]').slidingBtnAjaxIcon(true);
        $.post($('#frmBookingDlg').prop('action'), $('#frmBookingDlg').serialize(),        
            function(rp){                
                try{
                    var js = $.parseJSON(rp);
                    if(js.error>0){
                        if(js.field.length) $.submitErrorMsg(js.field, js.text);
                        if(js.field=='service-ids'){
                            $('#service-ids').parent().find('input.tt-input').focus();
                        }
                        
                        $('#save-result-msg').removeClass('text-success').addClass('text-danger').slideDown().find('span').text(js.text).prev().removeClass('la-check').addClass('la-exclamation');
                    }else{                        
                        $('#save-result-msg').removeClass('text-danger').addClass('text-success').slideDown().find('span').text($('#save-result-msg').data('success')).prev().removeClass('la-exclamation').addClass('la-check');
                        $.addRecordSuccessCb(js, 0);
                    }
                    setTimeout(function(){
                        $('#save-result-msg').slideUp();
                    }, 5000);
                }catch(e){
                    console.log(e.message);
                }
                $('button[type="submit"]').slidingBtnAjaxIcon(false);
            }//post-success
        );
        return false;
    });/*submit*/    

    $.addRecordSuccessCb = function(js){
        if(selectedBookingArg){
            if(selectedBookingArg.view.type != 'dayGridMonth'){
                $(selectedBookingArg.el).css({'background-color' : js.color});
                $(selectedBookingArg.el).css({'border-color' : js.color});
            }                            

            $(selectedBookingArg.el).css({'color' : js.color});
            $(selectedBookingArg.el).children().first().css({'border-color':js.color});

            var newText = $('#recdid').val() + ' - ' + $('#client_id').val() + ' (' + $('#staff_id').find('option:selected').text() + ')';
            $(selectedBookingArg.el).find('.fc-event-title').text(newText);                                                        
        }
        $('#save-result-msg').removeClass('text-danger').addClass('text-success').slideDown().find('span').text($('#save-result-msg').data('success')).prev().removeClass('la-exclamation').addClass('la-check');
        if(!parseInt($('#recdid').val()) && typeof $.bookingDialogSavedCallback=='function'){
            $.bookingDialogSavedCallback($.extend(js, {client : $('#client_id').val(), staff : $('#staff_id').find('option:selected').text()}));
        }
        $.magnificPopup.close();
    };

    $.bookingDialogInitCallback = function(){        
        $('#frmBookingDlg').find('.selectpicker').selectpicker({title : ''}).selectpicker('render');
        
        var today = new Date();
        var sentDtParam = '<?php echo $startTime?>';
        var defDate = '';
        if(!sentDtParam.length) defDate = moment(today).add(7, 'day').format('MM-DD-YYYY HH:mm');
        else defDate = sentDtParam;
        /*
        $('#start_time').datetimepicker({
            locale: $('#start_time').data('locale'),
            minDate: moment(today).format('MM-DD-YYYY HH:mm'),
            maxDate: moment(today).add(12, 'month').endOf('month').format('MM-DD-YYYY HH:mm'),
            format: 'MM-DD-YYYY HH:mm'
        }).on('dp.change', function(){
            $updateEndtime();
        }).val(defDate);*/
        $('#start_time').datetimepicker({
            language : 'en',
            minuteStep : 15,
            pickerPosition : 'top-right',            
            initialDate : today,
            format:'mm-dd-yyyy hh:ii',
            autoclose:true,
            startDate : moment(today).format('MM-DD-YYYY HH:mm')
        }).on('change', function(){            
            $updateEndtime();
        }).val(defDate);

        $('#service-ids').tagsinput({
            itemValue: 'id',
            itemText: 'name',
            maxTags : 50,
            typeaheadjs:[ 
                {
                    hint: true,
                    highlight: true,
                    minLength: 1
                },
                {
                    name: 'services',
                    displayKey: 'name',                    
                    source: services.ttAdapter(),
                    limit: 50,
                    templates:{
                        suggestion : function(item){                            
                            var name = item.name;                        
                            return "<div class='col-sm-12'>"+name+"<br/>"+item.price+"&euro; | "+item.duration+"'</div>";
                        }
                    }
                }
        ]
        });

        $('#client_id').typeahead(
            {
                hint: true,
                highlight: true,
                minLength: 1
            }, 
            {
                name: 'clients',
                display: 'name',
                source: clients, 
                limit : 20,
                templates:{
                    suggestion : function(item){                            
                        var name = item.name;
                        var html =  "<div class='col-sm-12 customer-item-info'>" + name;
                        if(item.email.length){
                            html += "<br/><i class='fa fa-envelope'></i><span>" + item.email + "</span>";
                        }
                        if(item.phone.length){
                            if(item.email.length) html += "<br/>";
                            html += "<i class='fa fa-phone'></i><span>" + item.phone + "</span>";
                        }
                        return html + "</div>";
                    }
                }
            }
        ).on('typeahead:autocomplete', function(evt, item){
            fCustChanged = 0;
            $(this).data('valid', 1);
            $('input[name="client_id"]').val(item.id);
        }).on('typeahead:selected', function(evt, item){
            fCustChanged = 0;
            $(this).data('valid', 1);
            $('input[name="client_id"]').val(item.id);
        }).keydown(function(e){
            if(e.which==8 || e.which==46){
                $(this).data('valid', 0);
                fCustChanged = 1;
            } 
        }).keypress(function(e){
            $(this).data('valid', 0);
            fCustChanged = 1;
        }).blur(function(){
            if(fCustChanged || $(this).data('valid')==0){
                $('input[name="client_id"]').val(0);
            }            
        });

        $('#service-ids').change(function(){
            var items = $('#service-ids').tagsinput('items');
            var amt = 0, drt = 0;
            if(items.length){
                items.forEach(function(item, index){
                    amt += parseFloat(item.price);
                    drt += parseInt(item.duration?item.duration:60);
                });            
            }
            
            $('#service_amount').val(amt.toFixed(2) + ' ' + $('#service_amount').data('csign'));
            $('#duration').val(drt + ' ' + $('#duration').data('minute'));            
            var sDepTime = moment($('#start_time').val(), 'MM-DD-YYYY hh:mm').add(drt, 'minutes');            
            $('#dep_time').val(sDepTime.format('MM-DD-YYYY HH:mm'));
        });

        $('#service-ids').parent().find('.tt-input').focus();        

        $.findTheStaffsByServiceIds = function(theIds, duration){            
            if(!isDialogInitialized) return;
            var url = './staffs?ajax=true&d0=find-staffs-by-services&services='+theIds+'&start='+$('#start_time').val() + '&duration=' + duration + '&staff=' + $('#staff_id').data('id');            
            var selectedID = $('#staff_id').data('id');            
            $.get(url, function(rp){                
                try{
                    var r = $.parseJSON(rp);                    
                    if(r.staffs.length){
                        $('#staff_id').children('option').each(function(){
                            if(!(this).prop('selected')) $(this).remove();
                        });
                        $('#staff_id').selectpicker('refresh');

                        var theSelectedID = $('#staff_id').data('id');
                        r.staffs.forEach(function(staff, idx){
                            $('#staff_id').append('<option value="'+staff.id+'"' + (selectedID==staff.id ? ' selected':'') + '>'+staff.name+'</option>');
                        });
                        $('#staff_id').selectpicker({title:''}).selectpicker('refresh');
                    }
                }catch(e){}
            });
        };        
        isDialogInitialized = 1;
    };/*initDialogCallback*/           

    $updateEndtime = function(){
        var items = $('#service-ids').tagsinput('items');
        var amt = 0, drt = 0;
        if(items.length){
            items.forEach(function(item, index){
                amt += parseFloat(item.price);
                drt += parseInt(item.duration?item.duration:60);
            });            
        }
        
        $('#service_amount').val(amt.toFixed(2) + ' ' + $('#service_amount').data('csign'));
        $('#duration').val(drt + ' ' + $('#duration').data('minute'));            
        var sDepTime = moment($('#start_time').val(), 'MM-DD-YYYY hh:mm').add(drt, 'minutes');            
        $('#dep_time').val(sDepTime.format('MM-DD-YYYY HH:mm'));
    };

    /*==========================================================================================*/

    String.prototype.highlight = function(text){
        var regex = new RegExp(text, 'gi')
        var response = this.replace(regex, function(str) {
            return "<span class='highlight'>" + str + "</span>"
        })
        return response;
    }
</script>