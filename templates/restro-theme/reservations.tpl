{OVERALL_HEADER}
<!-- Dashboard Container -->
<div class="dashboard-container">

    <!-- Dashboard Sidebar
    ================================================== -->
    <div class="dashboard-sidebar">
        <div class="dashboard-sidebar-inner" data-simplebar>
            <div class="dashboard-nav-container">

                <!-- Responsive Navigation Trigger -->
                <a href="#" class="dashboard-responsive-nav-trigger">
					<span class="hamburger hamburger--collapse" >
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</span>
                    <span class="trigger-title">{LANG_DASH_NAVIGATION}</span>
                </a>

                <!-- Navigation --> {OVERALL_SIDEBAR} <!-- Navigation / End -->

            </div>
        </div>
    </div>
    <!-- Dashboard Sidebar / End -->

    <!-- Dashboard Content
    ================================================== -->
    <div class="dashboard-content-container" data-simplebar>
        <div class="dashboard-content-inner" >

            <!-- Dashboard Headline -->
            <div class="dashboard-headline">
                <h3>{LANG_RESERVATIONS}</h3>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="{LINK_INDEX}">{LANG_HOME}</a></li>
                        <li>{LANG_RESERVATIONS}</li>
                    </ul>
                </nav>
            </div>

            <!-- BEGIN CONTENT -->
            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="margin-top-0">                      
                        <div class="right-toolbox menu-button">
                            <a href="javascript:void(0);" class="button ripple-effect button-sliding-icon margin-left-auto" id="btnAddBooking">{LANG_ADD} {LANG_RESERVATION} <i class="icon-feather-plus"></i></a>
                        </div>
                        <div class="dashboard-box margin-top-0 content with-padding padding-bottom-10">
                            <div class="row main-box-in-row padding-bottom-0 margin-bottom-0" style="padding:30px 30px 0;">
                           

                               
                             
                                <div class="col-xl-3 col-md-3 col-sm-3">
                                    <div class="submit-field">
                                        <h5>{LANG_STATUS}</h5>
                                        <select id="statusList" class="selectpicker with-border" data-hdr="[{LANG_STATUS}]" data-max-options="3" data-multiple-separator=" " multiple>{STATUSES}</select>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-3 col-sm-3">
                                    <div class="submit-field">
                                        <h5>{LANG_STAFF}</h5>
                                        <select id="staffsList" class="selectpicker with-border" data-hdr="[{LANG_STAFF}]" >
                                            {LOOP: STAFFS}
                                            <option value="{STAFFS.id}">{STAFFS.name}</option>
                                            {/LOOP: STAFFS}
                                        </select>
                                    </div>
                                </div>

                            

                                <div class="col-xl-6 col-md-6 col-sm-6 xs-with-margin-top">
                                    <div class="submit-field">
                                        <h5 class="sm-hide">&nbsp;</h5>
                                        <button class="btn-search button"><i class="icon-feather-search"></i></button>
                                        <button style="float: right; margin-right: 10px;" class="btn-settings button" ><i class="icon-feather-settings"></i></button>
                                        <button  class="btn-listview button" onclick="document.location='./reservations'" style="margin-left:4px;"><i class="icon-feather-list"></i></button>                                    
                                   
                                    </div>
                                </div>
                                <!--data table container-->                                
                            </div>
                        
                            <!--data table  container-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-8">
                    <div id="calendar"></div>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-4">
                    <div class="dashboard-box margin-top-40 border-radius-5 content with-padding padding-bottom-10">
                        <div class="row main-box-in-row padding-bottom-0 margin-bottom-0" style="padding:30px 30px 0;">
                           <div class="col-xl-12">
                            <h3>{LANG_RESERVATIONS_LIST}</h3> 
                           </div>
                         
                         
                        {LOOP: APPOINTMENTS}
                        <div data-id="{APPOINTMENTS.id}" style="display: flex; position: relative;" class="appointment_items col-xl-12 margin-top-10">
                            <div class="parent_center">      
                              <i class="icon-padding-radius icon-feather-calendar"></i> 
                          </div>
                              <div class="services_info_detail">
                                  <p class="services_info_date">{LANG_APPOINTMENT_TIME}: {APPOINTMENTS.time}</p>
                                  <strong> {LANG_CUSTOMER}: {APPOINTMENTS.customer}</strong>
                                  <p style="margin-bottom: 0px;">{LANG_PHONE}: {APPOINTMENTS.phone}</p>
                                  <i>{LANG_STAFF}: {APPOINTMENTS.staff}</i>
                              </div>
                                  <div class="{APPOINTMENTS.status_class}">{APPOINTMENTS.status}</div>
                              </div>
                        {/LOOP: APPOINTMENTS}
                      

                    </div>
                </div>
            </div>

            </div>
            <!-- END CONTENT -->

            <!-- Footer -->
            <div class="dashboard-footer-spacer"></div>
            <div class="small-footer margin-top-15">
                <div class="small-footer-copyrights">
                    {COPYRIGHT_TEXT}
                </div>
                <ul class="footer-social-links">
                    IF('{FACEBOOK_LINK}'!=""){
                    <li>
                        <a href="{FACEBOOK_LINK}" target="_blank" rel="nofollow">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                    {:IF}
                    IF('{TWITTER_LINK}'!=""){
                    <li>
                        <a href="{TWITTER_LINK}" target="_blank" rel="nofollow">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </li>
                    {:IF}
                    IF('{INSTAGRAM_LINK}'!=""){
                    <li>
                        <a href="{INSTAGRAM_LINK}" target="_blank" rel="nofollow">
                            <i class="fa fa-instagram"></i>
                        </a>
                    </li>
                    {:IF}
                    IF('{LINKEDIN_LINK}'!=""){
                    <li>
                        <a href="{LINKEDIN_LINK}" target="_blank" rel="nofollow">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </li>
                    {:IF}
                    IF('{PINTEREST_LINK}'!=""){
                    <li>
                        <a href="{PINTEREST_LINK}" target="_blank" rel="nofollow">
                            <i class="fa fa-pinterest-p"></i>
                        </a>
                    </li>
                    {:IF}
                    IF('{YOUTUBE_LINK}'!=""){
                    <li>
                        <a href="{YOUTUBE_LINK}" target="_blank" rel="nofollow">
                            <i class="fa fa-youtube-play"></i>
                        </a>
                    </li>
                    {:IF}
                </ul>
                <div class="clearfix"></div>
            </div>
            <!-- Footer / End -->

        </div>
    </div>
    <!-- Dashboard Content / End -->

</div>
<!-- Dashboard Container / End -->
</div>
<!-- Wrapper / End -->

<!--DIALOG TEMPLATE -->
<div id="dlgWrapper" class="zoom-anim-dialog mfp-hide dialog-with-tabs">
    <!--Tabs -->
    <div class="log-item-form">
        <ul class="popup-tabs-nav">
            <li class="active"><a class="tab-title">{LANG_GROUPS}</a></li>
        </ul>
        <div class="popup-tabs-container"></div>
    </div>
</div><!--DIALOG TEMPLATE-->

<div id="bstoverlay" style="display:none;position:absolute;z-index:110;top:0;left:0;width:100%;height:100%;background-color:rgba(100,100,100,0.5);">
    <div class="overlay-content" style="max-width:560px;margin:30px auto;background-color:#FFF;"></div>
</div>
<script>
    $(document).ready(function () {
        $("#header-container").addClass('dashboard-header not-sticky');        
    });
</script>
<script type="text/javascript" src="{SITE_URL}templates/{TPL_NAME}/js/chosen.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/jquery.lazyload.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/tippy.all.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/simplebar.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/bootstrap-slider.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/bootstrap-select.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/snackbar.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/counterup.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/magnific-popup.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/slick.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/jquery.cookie.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/user-ajax.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/custom.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/svg.js?ver={VERSION}"></script>

<!--custom js files-->
<!--<script src="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap/js/popper.min.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap/js/bootstrap.min.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/tooltip.min.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>-->

<script src="{SITE_URL}templates/{TPL_NAME}/plugins/shop-util.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/sweetalert.min.js"></script>

<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/js/moment.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/moment/moment-timezone.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/moment/moment-timezone-with-data.js"></script>

<!--calendar-->
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/calendar/main.min.js?ver={VERSION}"></script>

<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<!--<script src="{SITE_URL}templates/{TPL_NAME}/plugins/typeahead/typeahead.bundle.min.js"></script>-->
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/typeahead/1.2.1/bloodhound.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/typeahead/1.2.1/typeahead.jquery.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/codec.min.php"></script>

<script>
    boConfigParams = $.extend({selectedStaffIDs : [], selectedStatus : [], ajxAction : 'reservation', defaultView : 'search-reservation'}, boConfigParams);
    var boDialog = { wrapper : $('#dlgWrapper'), contentWrapper : $('.popup-tabs-container') };
    var calendar = null;
    var viewOnly = {READONLY_PERMISSION};
    var isDialogInitialized = 0;
    
    /* THIS PORTION OF CODE IS ONLY EXECUTED WHEN THE USER THE LANGUAGE(CLIENT-SIDE) */
    $(function () {
        $('.language-switcher').on('click', '.dropdown-menu li', function (e) {
            e.preventDefault();
            var lang = $(this).data('lang');
            if (lang != null) {
                var res = lang.substr(0, 2);
                $('#selected_lang').html(res.toUpperCase());
                $.cookie('Quick_lang', lang,{ path: '/' });
                location.reload();
            }
        });
    });
    $(document).ready(function () {
        /*moment.tz.setDefault("Europe/Berlin");*/

        var lang = $.cookie('Quick_lang');
        if (lang != null) {
            var res = lang.substr(0, 2);
            $('#selected_lang').html(res.toUpperCase());
        }
       
        $initSelectPicker();
        $searchClick();

        $('.btn-settings').click(function(){
            $bookingSettingsDialog();
        });

        $('#btnAddBooking').click(function(){
            $.addBookingDialog();
        });

        return;        
    });

    $bookingSettingsDialog = function(){
        boDialog.wrapper.mfpPopup(boDialog, function(){
            boDialog.wrapper.find('.tab-title').text('{LANG_SETTING}');
            var data = {m : boConfigParams.ajxAction, d0 : 'booking-settings-dialog'};
            $bkGet(data, function(rp){
                boDialog.contentWrapper.html(rp).removeClass('loading');
            });
        });
    };

    $initSelectPicker = function(){
        $('.selectpicker').each(function(){
            $(this).selectpicker({title : $(this).data('hdr')}).selectpicker('render');
        });

        $('#staffsList').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue){
            boConfigParams.selectedStaffIDs = [];
            $(this).find('option:selected').each(function(){
                boConfigParams.selectedStaffIDs.push($(this).val());
            });	
        });
        $('#statusList').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue){
            boConfigParams.selectedStatus = [];
            $(this).find('option:selected').each(function(){
                boConfigParams.selectedStatus.push($(this).val());
            });	
        });
    };

    $.onDaySelect = function(arg){        
        if(arg.view.type=='dayGridMonth'){
            calendar.changeView('timeGridDay', arg.start);
            return;
        }

        calendar.unselect();
        /*  calendar.addEvent({
            title: 'testing booking...',
            start: arg.start,
            end: arg.end,
            allDay: arg.allDay
          });
        calendar.unselect();return;
          */
         
        $.bookingClickDialog(arg);
    };

    let selectedBookingArg = null;
    $.bookingClickDialog = function(arg){
        
        var start = moment(arg.start).format('YYYY-MM-DD HH:mm');
        var theID = arg.event ? arg.event.groupId : 0;
        var data = {m : boConfigParams.ajxAction, d0 : 'edit-booking-dialog', id : theID, start : start, viewOnly : viewOnly , ts : new Date().toString()};        
        
        selectedBookingArg = arg;
        isDialogInitialized = 0;
        boDialog.wrapper.mfpPopup(boDialog, function(){
            boDialog.wrapper.find('.tab-title').text('{LANG_BOOKING} {LANG_INFORMATION}');

            if(arg.event) theID = arg.event.groupId;
            if(theID==0){
                $.addBookingDialog(start);
                return;
            }            
            
            $bkGet(data, function(rp){
                boDialog.contentWrapper.html(rp).removeClass('loading');                
                setTimeout(function(){                    
                    if($.bookingDialogInitCallback) $.bookingDialogInitCallback();
                }, 100);
            });
        });
    };

    $('.appointment_items').click(function(e){
       
       // var start = moment('2023-01-01 12:30').format('YYYY-MM-DD HH:mm');
        var theID = $(this).data('id');
        var data = {m : boConfigParams.ajxAction, d0 : 'edit-booking-dialog', id : theID, start : null, viewOnly : false , ts : new Date().toString()};        
        
  
        isDialogInitialized = 0;
        boDialog.wrapper.mfpPopup(boDialog, function(){
            boDialog.wrapper.find('.tab-title').text('{LANG_BOOKING} {LANG_INFORMATION}');

        
            if(theID==0){
                $.addBookingDialog(start);
                return;
            }            
            
            $bkGet(data, function(rp){
                boDialog.contentWrapper.html(rp).removeClass('loading');                
                setTimeout(function(){                    
                    if($.bookingDialogInitCallback) $.bookingDialogInitCallback();
                }, 100);
            });
        });
    });

    $.bookingDialogSavedCallback = function(js, itemId){        
        if(!selectedBookingArg || typeof selectedBookingArg != "object") return;        

        if(isNaN(itemId)) return;

        /*update start time */
        if(itemId>0){
            var start = moment(js.start, 'MM-DD-YYYY HH:mm').format('YYYY-MM-DDTHH:mm:ss');            
            var end = moment(js.start, 'MM-DD-YYYY HH:mm').add(js.duration, 'minutes').format('YYYY-MM-DDTHH:mm:ss');
            selectedBookingArg.event.setStart(start);
            selectedBookingArg.event.setEnd(end);
            return;
        } 

        /*add new event */
        if(!selectedBookingArg || typeof selectedBookingArg.start != "object") return;        
        
        var endtime = moment(selectedBookingArg.start).add(js.duration, 'minutes').format('YYYY-MM-DDTHH:mm:ss');
        
        calendar.addEvent({            
            title: js.id + ' - ' + js.client + ' (' + js.staff + ')',
            groupId : js.id,
            start: selectedBookingArg.start,
            end: endtime,
            allDay: false,
            backgroundColor : js.color,
            borderColor : js.color
        });

    };

    $.addBookingDialog = function(){
        var start = "";
        if(arguments.length){
            start = arguments[0];
        }        

        boDialog.wrapper.mfpPopup(boDialog, function(){
            boDialog.wrapper.find('.tab-title').text('{LANG_ADD} {LANG_BOOKING}');
            var data = {m : boConfigParams.ajxAction, d0 : 'add-new-booking', 'start' : start};
            $bkGet(data, function(rp){
                boDialog.contentWrapper.html(rp).removeClass('loading');                
                setTimeout(function(){
                    if($.bookingDialogInitCallback) $.bookingDialogInitCallback();
                }, 100);
            });
        });
    };

    $searchClick = function(){
        $('.btn-search').click(function(){
            $(this).addClass('ajxloading');
            var startDate = '', endDate = '';
            var data = {
                std :   calendar.view.activeStart.toYMDString(),
                end :   calendar.view.activeEnd.toYMDString(),
                staffs : boConfigParams.selectedStaffIDs.toString(),
                status : boConfigParams.selectedStatus.toString(),
                page : -1
            };

            var url = './reservations?d0=get-booking-feeds&ajax=true&page=-1&std=' + data.std + '&end=' + data.end + '&staffs=' + data.staffs + '&status=' + data.status;
            calendar.getEventSources()[0].remove();
            calendar.addEventSource(url);
        });
    };

    $.updateBookingTime = function(info){
        var start = moment(info.event.start).format('YYYY-MM-DD HH:mm');
        var end = moment(info.event.end).format('YYYY-MM-DD HH:mm');
        var data = {m : boConfigParams.ajxAction, d0 : 'update-booking-time', id : info.event.groupId, start : start, end : end};        
        $bkGet(data, function(rp){
            try{                
                var rs = $.parseJSON(rp);
                if(rs.result==0){
                    info.revert();
                }
            }catch(e){}
        });
    };

    $.loadBookingFeeds = function(info){        
        return new Promise(function(resolve, reject) {
            var url, start, end;
            if(info) {
                start = new Date(info.start).toYMDString();
                end = new Date(info.end).toYMDString();
            }else{
                start = moment().startOf('month').format('YYYY-MM-DD');
                end   = moment().endOf('month').format('YYYY-MM-DD');
            }

            url = './reservations?d0=get-booking-feeds&ajax=true&page=-1&std=' + start
                      + '&end='  + end + '&staffs=' + boConfigParams.selectedStaffIDs.toString()
                      + '&status=' + boConfigParams.selectedStatus.toString();            
            $.get(url, function(rp){
                try{          
                    var js = $.parseJSON(rp);                    
                    resolve(js);
                }catch(e){                    
                }
            }).fail(function(){
                reject(Error('could not load resource...'));
            });
        });
    };

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            
            allDaySlot: false,
            dayMaxEvents: true, /* allow "more" link when too many events */
            /*droppable:true,*/
            editable: true, /*!viewOnly*/
            eventDurationEditable : false,
            initialDate: moment().format('YYYY-MM-DD'),            
            navLinks: true, /* can click day/week names to navigate views */
            selectable: true,
            selectMirror: true,
            slotMinTime : '07:00',
            slotMaxTime : '23:00',
            slotDuration : '00:15:00',
            showNonCurrentDates : true,
            businessHours: {OPEN_CLOSE_HOURS},
            selectConstraint: "businessHours",

            select: function(arg) {
                /*user must tap and hold on mobile mode*/
                $.onDaySelect(arg);
            },

            selectAllow : function(arg){
                var start = moment(arg.start).format('YYYY-MM-DD');
                var today = moment().format('YYYY-MM-DD');
                return start >= today;
            },
            
            eventAllow : function(dropInfo, draggedEvent){
                /*if(viewOnly) return false;*/
                /*var now = new Date(moment().add(-5,'hour').format('YYYY-MM-DD HH:mm'));*/                
                var now = new Date(new Date().toLocaleString('en', {timeZone: 'Europe/Berlin'}));
                if(draggedEvent.start >= now){                    
                    return dropInfo.start >= now;
                }else{                    
                    return dropInfo.end <= now;
                }
                return false;
            },
            
            eventClick: function(arg) {                
                $.bookingClickDialog(arg);
            },

            eventDrop: function(info){
                $(info.el).confirm("{LANG_CHANGE_BOOKING_TIME}", function(){
                    $.updateBookingTime(info);
                }, function(){
                    info.revert();
                });
            },

            eventResizeStart : function(info){
            },

            eventResize : function(eventResizeInfo){
            },

            events : function(info){
                return $.loadBookingFeeds(info);
            },

            loading : function(f){
                if(!f) $('.btn-search').removeClass('ajxloading');
            },

            dayHeaderClassNames : function(arg){
                if(arg.isPast) return 'disabled-time-slot';
            },

            dayCellClassNames : function(arg){
                if(arg.view.type!='dayGridMonth' && arg.isPast)
                    return 'disabled-time-slot';
            },
            
            slotLaneDidMount : function(arg){                
            },

            dayCellDidMount : function(arg){                
                if(arg.view.type!='dayGridMonth' && arg.isPast){                    
                } 
            },

            eventDidMount: function(info){
                /*
                var tooltip = new Tooltip(info.el, {                
                    title: info.event.extendedProps.description,
                    placement: 'top',
                    trigger: 'hover',
                    container: 'body',
                    html : true
                });*/
            }
        });/*calendar options*/
        calendar.render();
    });/*DOMContentLoaded*/    
</script>
</body>
</html>