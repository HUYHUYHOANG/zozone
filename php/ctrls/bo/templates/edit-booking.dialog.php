
<?php
require_once('./models/config-data-model.class.php');
$key = CBoCtrl::generateSessionKey();
$isPast = false;
$viewOnly = boolval(CRequest::getStr('viewOnly'));

$theServicesList = '';
if($found){    
    $data = (object)$this->model->data;
    $today = date('Y-m-d');
    $arrDate = date('Y-m-d', strtotime($data->arr_time));
    $isPast = ($today > $arrDate);

    $data->res_date = date('m-d-Y H:i', strtotime($data->res_date));
    $data->arr_time = date('m-d-Y H:i', strtotime($data->arr_time));
    $data->dep_time = date('m-d-Y H:i', strtotime($data->dep_time));    
    
    $obj = CBoCtrl::getUser();    
    $viewOnly = ($data->staff_id == $obj->id || $obj->user_type=='manager') ? 0 : 1;
    
    if($viewOnly) $theServicesList = CReservationData::getServiceNames($data->service_ids);    
}   
else{
    $date = DateTime::createFromFormat('Y-m-d H:i', CRequest::getStr('start'));    
    $data = new stdClass;
    $data->id = 0;
    $data->service_ids = 0;    
    $data->client_id = 0;
    $data->staff_id = 0;
    $data->arr_time = $date->format('m-d-Y H:i');
    $data->dep_time = $data->arr_time;
    $data->res_date = $data->arr_time;    
    $data->client = '';
    $data->staff = '';
    $data->service_amount = '';
    $data->duration = '';
    $data->status = 'pending';
    $viewOnly = 0;
}

$settings = $_SESSION['__CURRENT_SETTINGS__'];
?>
<?php isset($this) or die(':-)'); ?>
<form id="frmBookingDlg" action="./reservations?ajax=true&d0=save-booking-record">
    <div class="popup-tab-content">        
        <div style="margin-bottom:0;">            
            <?php
            if(0 && !$found){
                ?>
                <div class="text-center">Booking record not found...</div>
                <div class="text-center" style="margin-bottom:20px;">Close after (<span class="timer-down-close">5</span>) minutes</div>
                <script type="text/javascript">
                    var interval = 1000, countdown=5, idi = 0;
                    $('button[type="submit"]').prop('disabled',1).addClass('disabled');
                    idi = setInterval(() => {
                        $('.timer-down-close').text(--countdown);
                        if(!countdown){
                            clearInterval(idi);
                            $('.btnClose').trigger('click');
                        }
                    }, interval);
                </script>
                <?php
            }else{?>
            <!--begin booking detail-->
            <div class="row" style="margin-bottom: 12px;">
                <div class="col-sm-12 submit-field">
                    <h5><?php echo $lang['SERVICE'] ?></h5>
                    <input type="text" class="with-border" id="service-ids" name="service-ids" data-value="<?php echo $data->service_ids ?>" data-namelist="<?php echo $theServicesList ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 submit-field">
                    <h5><?php echo $lang['DURATION']?></h5>
                    <input type="text" class="with-border" id="duration" name="duration" value="<?php echo $data->duration . ' ' . $lang['MINUTE'] ?>" data-duration="<?php echo $data->duration?>" readonly data-minute="<?php echo $lang["MINUTE"] ?>">
                </div>    
                <div class="col-sm-6 submit-field">
                    <h5><?php echo $lang['AMOUNT']?></h5>
                    <input type="text" class="with-border" id="service_amount" name="service_amount" value="<?php echo $data->service_amount . ' ' . $settings->currency_sign ?>" readonly data-csign="<?php echo $settings->currency_sign?>">
                </div>
            </div>
            <!--<div class="row">
                <div class="col-sm-6 submit-field">
                    <h5><?php echo $lang['VOUCHER']?></h5>
                    <input type="text" class="with-border" value="<?php echo $data->voucher?>" readonly>
                </div>    
                <div class="col-sm-6 submit-field">
                    <h5><?php echo $lang['VALUE']?></h5>
                    <input type="text" class="with-border" value="<?php echo $data->reduced ?>" readonly>
                </div>
            </div>-->
            <div class="row">
                <div class="col-sm-12 submit-field clients-list">
                    <h5><?php echo $lang['CUSTOMER'] ?></h5>
                    <input type="text" class="with-border autocomplete" id="client_id" data-name="client_id" autocomplete="off" value="<?php echo $data->client?>">
                    <input type="hidden" name="client_id" value="<?php echo $data->client_id?>">
                </div>
            </div>
            <div class="row" style="margin-bottom:15px;">
                <div class="col-sm-12 submit-field">
                    <h5><?php echo $lang['STAFF'] ?></h5>                    
                    <select class="selectpicker" id="staff_id" name="staff_id" data-id="<?php echo $data->staff_id?>">
                        <option value="0">[<?php echo $lang['SELECT']?>]</option>
                        <?php
                        if(1 || $isPast){
                            $staffs = $this->model->loadStaffs();
                            if($staffs){
                                foreach($staffs as $staff){
                                    $selected = $staff['id'] ==  $data->staff_id ? 'selected' : '';
                                    echo "<option value={$staff['id']} {$selected}>{$staff['name']}</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>            
            <div class="row">
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
                    <input type="text" class="with-border" name="res_date" value="<?php echo $data->res_date ?>" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 submit-field">
                    <h5><?php echo $lang['START_TIME'] ?></h5>
                    <input type="text" class="with-border" id="start_time" name="arr_time" value="<?php echo $data->arr_time ?>" data-locale="<?php echo $lang['LOCALE'];?>" autocomplete="off">
                </div>
                <div class="col-sm-6 submit-field">
                    <h5><?php echo $lang['END_TIME'] ?></h5>
                    <input type="text" class="with-border" id="dep_time" name="dep_time" value="<?php echo $data->dep_time ?>" data-value="<?php echo $data->dep_time?>" readonly>
                </div>
            </div>            
            <!--end booking detail-->
            <?php
            }
            ?>
        </div>
        <div class="row submit-field" id="save-result-msg" data-success="<?php echo $lang['SAVED_SUCCESS']?>" data-error="<?php echo $lang['ERROR']?>">
            <div class="col-xl-12 col-md-12"><i class="la la-exclamation-circle" style="font-weight:bold;font-size:20px;margin-right:6px;position:relative;top:3px;"></i><span><span></div>
        </div>
        <div class="row">
            <?php
            if($viewOnly){?>
                <div class="col-sm-12 col-xs-12">
                    <button class="margin-top-15 button button-sliding-icon ripple-effect btnClose" type="button" onclick="$.magnificPopup.close()"><?php echo $lang['CLOSE'] ?><i class="icon-material-outline-arrow-right-alt"></i></button>
                </div>
            <?php
            }else{?>
                <div class="col-sm-4 col-xs-4">
                    <button class="margin-top-15 button button-sliding-icon ripple-effect btnSave" type="submit"><span><?php echo $lang['SAVE'] ?></span><i class="icon-material-outline-arrow-right-alt"></i></button>
                </div>
                <div class="col-sm-4 col-xs-4">
                    <button class="margin-top-15 button <?php echo $data->id==0?'':'button-sliding-icon ripple-effect'?> btn-danger btnDelete" type="button" <?php echo $data->id==0?'disabled=true':'' ?>>
                        <?php echo $lang['DELETE'] ?><i class="icon-feather-trash-2"></i>
                    </button>
                </div>
                <div class="col-sm-4 col-xs-4">
                    <button class="margin-top-15 button button-sliding-icon ripple-effect btnClose" type="button" onclick="$.magnificPopup.close()"><?php echo $lang['CLOSE'] ?><i class="icon-material-outline-arrow-right-alt"></i></button>
                </div>
            <?php
            }?>
        </div>
    </div>
    <input type="hidden" id="ptkn" name="<?php echo $_SESSION['user']['login_string']?>" data-challenge="<?php echo $key?>">        
    <input type="hidden" id="recdid" name="id" value="<?php echo $data->id?>">    

    <input type="hidden" id="isPastRecord" value="<?php echo $isPast ? '1':'0'?>">
    <input type="hidden" id="isViewOnly" value="<?php echo $viewOnly ? '1':'0'?>">
</form>
<?php
$this->getServicesJSONDataForScript();
$this->getCustomerJSONDataForScript();

echo "<script type='text/javascript'>";
echo "\r\n var agBookedService = ";

$items = $this->model->getServicesInfo($data->service_ids);
if(!$items){
    echo " []; ";
}else{
    $data = array();
    foreach($items as $r){
        $data[] = array('id' => $r['id'], 'name' => $r['name'], 'price' => $r['price'], 'duration' => $r['duration']);
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    echo ";";
}
echo "\r\n</script>";
?>
<script type="text/javascript">
    var clients, services;
    var isPastRecord, isViewOnly;

    $.bookingDialogInitCallback = function(){       

        isPastRecord = parseInt($('#isPastRecord').val());
        isViewOnly = parseInt($('#isViewOnly').val());

        clients = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                local: agclients
            });
        clients.initialize();

        services = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: agservices,
            remote: {
                url : '<?php echo $settings->site_url ?>reservations?d0=get-all-services-2json&ajax=true',
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

        $('#frmBookingDlg button.btnDelete').click(function(){
            var recdID = ($('#recdid').val());
            $(this).confirm('<?php echo $lang['DELETE_THE_SELECTED_RESERVATION']?>', function(){
                if(!selectedBookingArg) return;

                var data = {m : boConfigParams.ajxAction, d0 : 'delete-booking-record', id : recdID};
                $bkGet(data, function(rp){
                    var r = $.parseJSON(rp);
                    if(r.result && selectedBookingArg){
                        selectedBookingArg.event.remove();
                        selectedBookingArg = null;
                        $.magnificPopup.close();
                    }
                });
            });
        });
    
        $('#frmBookingDlg').submit(function(){
        
        // var staffID = $('#staff_id').val();
        // if(staffID==null){
        //     $('#staff_id').hilite(1); return false;
        // }

        var data = {m : $('#frmBookingDlg').prop('action')};
        if($('#ptkn').data('change') !='y'){
            $('#ptkn').val($('#ptkn').data('challenge').decode()).data('change','y');                
        }

        $('button[type="submit"]').slidingBtnAjaxIcon(true);
        $.post($('#frmBookingDlg').prop('action'), $('#frmBookingDlg').serialize(),        
            function(rp){                
                try{
                    var js = $.parseJSON(rp);
                    if(js.error>0){
                  
                        if(js.field.length){
                            $.submitErrorMsg(js.field, js.text);
                        } 
                        if(js.field=='service-ids'){
                            $('#service-ids').parent().find('input.tt-input').focus();
                        }
                        $('#save-result-msg').removeClass('text-success').addClass('text-danger').slideDown().find('span').text(js.text).prev().removeClass('la-check').addClass('la-exclamation');
                    }else{
                        if(selectedBookingArg){
                            if(selectedBookingArg.view.type != 'dayGridMonth'){
                                $(selectedBookingArg.el).css({'background-color' : js.color});
                                $(selectedBookingArg.el).css({'border-color' : js.color});
                            }                            

                            $(selectedBookingArg.el).css({'color' : js.color});
                            $(selectedBookingArg.el).children().first().css({'border-color':js.color});

                            var newText = $('#recdid').val() + ' - ' + $('#client_id').val() + ' (' + $('#staff_id').find('option:selected').text() + ')';
                            $(selectedBookingArg.el).find('.fc-event-title').text(newText);                                                        
                        }else{
                        }
                        $('#save-result-msg').removeClass('text-danger').addClass('text-success').slideDown().find('span').text($('#save-result-msg').data('success')).prev().removeClass('la-exclamation').addClass('la-check');
                        if(typeof $.bookingDialogSavedCallback=='function'){
                            $.bookingDialogSavedCallback($.extend(js, {start : $('#start_time').val(), client : $('#client_id').val(), staff : $('#staff_id').find('option:selected').text()}), parseInt($('#recdid').val()));
                        }
                        $.magnificPopup.close();
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

    
        $('#frmBookingDlg').find('.selectpicker').selectpicker({title : ''}).selectpicker('render');        
        
        if(isViewOnly){
            $('#frmBookingDlg').disableForm(1);
            $('#service-ids').val($('#service-ids').data('namelist'));
            $('.btnClose').prop('disabled', false);
            return;
        }
        
        /*minDate: moment(today).add(-1, 'day').format('MM-DD-YYYY HH:mm'),
        maxDate: moment(today).add(12, 'month').endOf('month').format('MM-DD-YYYY HH:mm'),*/
        var today = new Date();
        var v = $('#start_time').val();
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
        });

        setTimeout(function(){
            $('#start_time').val(v);
            $updateEndtime();
        }, 300);

        $('#service-ids').tagsinput({
            itemValue: 'id',
            itemText: 'name',
            maxTags : 100,
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

        $('#service-ids').change(function(){
            var items = $(this).tagsinput('items');            
            var amt = 0, drt = 0;
            if(items.length){
                items.forEach(function(item, index){
                    amt += parseFloat(item.price);
                    drt += parseInt(item.duration?item.duration:60);
                });
                //search the staffs with these services and date
                //if(!isPastRecord) $.findTheStaffsByServiceIds($(this).val(), drt);
            }
            
            $('#service_amount').val(amt.toFixed(2) + ' ' + $('#service_amount').data('csign'));
            $('#duration').val(drt + ' ' + $('#duration').data('minute'));            
            var sDepTime = moment($('#start_time').val(), 'MM-DD-YYYY hh:mm').add(drt, 'minutes');            
            $('#dep_time').val(sDepTime.format('MM-DD-YYYY HH:mm'));
        });

        $('.autocomplete').each(function(){
            $.tahInit($(this));
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

        agBookedService.forEach(function(item, index){
            $('#service-ids').tagsinput('add', { id: item.id , name: item.name, price: item.price, duration : item.duration });
        });

        if($("#service-ids").data("value").length){
            if($("#service-ids").data("value").split(',').length>1){
                var e = jQuery.Event("keypress");
                e.which = 32;
                $("input.tt-input").trigger(e);
            }
        }

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

    /*========================================================================================*/    
    var fCustChanged = 0;
    $.tahInit = function(){
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