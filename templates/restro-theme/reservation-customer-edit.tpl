{OVERALL_HEADER}
<!-- Dashboard Container -->
<div class="dashboard-container">
    <!-- Dashboard Content
    ================================================== -->
    <div class="dashboard-content-container" data-simplebar>
        <div class="dashboard-content-inner" >
            <!-- BEGIN CONTENT -->
            <div class="row">
                <!-- Dashboard Box -->
                <div class="col-xl-12">
                    <div class="margin-top-0">                      
                        <div class="right-toolbox menu-button">                            
                            <!--<a href="./vouchers?d0=add-voucher" class="button ripple-effect button-sliding-icon margin-left-auto" id="btnAddvoucher">{LANG_VOUCHER} <i class="icon-feather-book"></i></a>-->
                        </div>
                        <div class="dashboard-box margin-top-0 content with-padding padding-bottom-10" style="margin-right:0;padding-right:0;">                           
                            <div class="row main-box-in-row col-xl-12" style="justify-content: center;">   
               
                                <div class="reservation-data-wrap">
                                 
                                    <form id="frmBookingDlg" action="#">
                                        <div class="popup-tab-content">        
                                            <div style="margin-bottom:0;">            
                                                <div class="col-sm-12 submit-field text-center">
                                                    <h2>Termin stornieren</h2>           
                                                </div>
                                                IF("{RESERVATION_STATUS}" == "2"){
                                                <div class="row">
                                                    <div class="col-sm-12 submit-field">
                                                        <div class="alert alert-success" role="alert">
                                                            Ihre stornierte Termin wurde bestätigt
                                                          </div>
                                                    </div>                                    
                                                </div> 
                                                {:IF}
                                                <!--begin booking detail-->
                                                <div class="row" style="margin-bottom: 12px;">
                                                    <div class="col-sm-12 submit-field">
                                                        <h5>Service</h5>
                                                        <input type="text" class="with-border"  value="{LIST_SERVICES}" readonly name="service-name" data-value="">
                                                    </div>
                                                </div>
                                                <!-- <div class="row">
                                                    <div class="col-sm-6 submit-field">
                                                        <h5>{LANG_DURATION}</h5>
                                                        <input type="text" class="with-border" id="duration" name="duration" value="{DURATION}" readonly data-duration="">
                                                    </div>    
                                                    <div class="col-sm-6 submit-field">
                                                        <h5>{LANG_AMOUNT}</h5>
                                                        <input type="text" class="with-border" id="service_amount" name="service_amount" value="{AMOUNT}" readonly data-csign="">
                                                    </div>
                                                </div> -->
                                                <!-- <div class="row">
                                                    <div class="col-sm-6 submit-field">
                                                        <h5>{LANG_VOUCHER}</h5>
                                                        <input type="text" class="with-border" value="{VOUCHER_CODE}" readonly>
                                                    </div>    
                                                    <div class="col-sm-6 submit-field">
                                                        <h5>{LANG_VALUE}</h5>
                                                        <input type="text" class="with-border" value="{VOUCHER_VALUE}" readonly>
                                                    </div>
                                                </div>   -->

                                                <div class="row" style="margin-bottom: 0px;">                                                 
                                                    <div class="col-sm-6 submit-field">
                                                        <h5>Reservierungs Datum</h5>
                                                        <input type="text" class="with-border" name="res_date" value="{RES_DATE}" readonly>
                                                    </div>
                                                    <div class="col-sm-6 submit-field">
                                                        <h5>Terminvereinbarung Datum</h5>
                                                        <input type="text" class="with-border" id="start_time" name="arr_time" readonly value="{START_TIME}">
                                                    </div>
                                                </div>
                                               
                                                
                                                <div class="row" style="margin-bottom: 12px;">
                                                    <div class="col-sm-12 submit-field">
                                                        <h5>Stornierungsgrund</h5>
                                                       <select id="cancel_reason" name="cancel_reason" class="with-border form-control">
                                                        <option value="">[Auswahl]</option>
                                                        <option value="Persönliche Gründe">Persönliche Gründe</option>
                                                        <option value="Terminplanung geändert">Terminplanung geändert</option>
                                                        <option value="Krankheit oder Verletzung">Krankheit oder Verletzung</option>
                                                        <option value="Unvorhergesehene Umstände">Unvorhergesehene Umstände</option>
                                                        <option value="other">Sonstige Gründe</option>
                                                       </select>
                                                    </div>                                    
                                                </div> 
                                                <div id="cancel_reason_other_group" class="row" style="margin-bottom: 12px;">
                                                    <div class="col-sm-12 submit-field">
                                                        <h5>Sonstige Gründe</h5>
                                                        <input type="text" class="with-border" id="cancel_reason_other" name="cancel_reason_other" value="">
                                                    </div>                                    
                                                </div>      
                                                
                                                <div class="row" style="margin-bottom: 12px;">
                                                    <div class="col-sm-12 submit-field">
                                                        <div class="alert alert-danger error_content" style="display: none;" role="alert">
                                                        
                                                          </div>
                                                    </div>                                    
                                                </div> 
                                                                                
                                            </div>
                                            IF("{RESERVATION_STATUS}" == "0"){
                                            <div class="row">
                                                <!-- <div class="col-sm-6 col-xs-6">
                                                    <button class="margin-top-15 button ripple-effect btnSave" type="submit"><span></span><i class="icon-material-outline-arrow-right-alt"></i> Thay đổi thời gian </button>
                                                </div> -->
                                                <div class="col-sm-12 col-xs-12 text-center">
                                                    <input type="hidden" name="id" value="{RESERVATION_ID}">
                                                    <button class="margin-top-15 button btn-danger btnDelete" id="btnDeleteReservation" type="submit">
                                                       <i class="icon-feather-trash-2" style="margin-right: 5px;font-size: 18px;"></i>Stornieren
                                                    </button>
                                                </div>            
                                            </div>
                                            {:IF}
                                        </div>
                                      
                                    </form>
                                    
                                </div>  
                            </div>
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

<script>
    $(document).ready(function () {
        $("#header-container").addClass('dashboard-header not-sticky');
    });
</script>

<script src="{SITE_URL}templates/{TPL_NAME}/js/bootstrap-select.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/snackbar.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/jquery.cookie.min.js?ver={VERSION}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/js/svg.js?ver={VERSION}"></script>

<!--custom js files-->
<!--<script src="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap/js/popper.min.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/tooltip.min.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>-->

<script src="{SITE_URL}templates/{TPL_NAME}/plugins/shop-util.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/js/moment.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap/js/bootstrap.min.js?ver={VERSION}&t={JS_CSS_TIMESTAMP}"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script src="{SITE_URL}templates/{TPL_NAME}/plugins/typeahead/1.2.1/bloodhound.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/typeahead/1.2.1/typeahead.jquery.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="{SITE_URL}templates/{TPL_NAME}/plugins/codec.min.php"></script>


<script type="text/javascript">

    /* THIS PORTION OF CODE IS ONLY EXECUTED WHEN THE USER THE LANGUAGE(CLIENT-SIDE) */
    $(function () {
        $("#cancel_reason_other_group").hide();
        $(".error_content").hide();
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
        // var lang = $.cookie('Quick_lang');
        // if (lang != null) {
        //     var res = lang.substr(0, 2);
        //     $('#selected_lang').html(res.toUpperCase());
        // }

        $("#cancel_reason").change(function(e){
            $(".error_content").hide();
           if($(this).val() == "other")
           {
            $("#cancel_reason_other_group").show();
           }
           else
           {
            $("#cancel_reason_other_group").hide();
           }
        })
  
        $('#frmBookingDlg').submit(function(e){    
            e.preventDefault();
            let cancel_reason = $("#cancel_reason").val();
            let bError = false;
            if (cancel_reason == ""){
                bError = true
                $(".error_content").html("Bitte wählen Sie einen Grund für die Stornierung aus");
                $(".error_content").show();
               
            }
            if (cancel_reason == "other")
            {
                let other_cancel_reason_text = $("#cancel_reason_other").val();
                if(other_cancel_reason_text == "")
                {
                    bError = true
                $(".error_content").html("Bitte wählen Sie einen Grund für die Stornierung aus");
                $(".error_content").show();
                $("#cancel_reason_other").focus();
                }
            }
            if (bError == false){
                if (confirm("Sind Sie sicher, dass Sie den Termin stornieren möchten?")){
               // Nếu người dùng chọn OK
               this.submit(); // Submit form
             } else {
               // Nếu người dùng chọn Cancel
               return false; // Không submit form
             }
            }
      
           });
    });

  

   
</script>
</body>
</html>