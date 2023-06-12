var $ = jQuery.noConflict();

var url = new URL(window.location.href);
    localStorage.setItem('current_url',url.href);

var setting_slick_booking = {
    dots: false,
    rows: 2,
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 4,
    arrows: true,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
                infinite: true,
                dots: false,
                rows: 2,
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                dots: false,
                rows: 2,
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                dots: false,
                rows: 2,
            }
        }
    ]
};

var id_customer_check = localStorage.getItem('quickqr_id_customer');
if(!id_customer_check)
{
    localStorage.setItem('quickqr_id_customer',randomId(60))
}
function randomId(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}
var slug = $('#slug').val();
var slug_pre = localStorage.getItem('slug');
localStorage.setItem('slug', slug);
if (slug != slug_pre) {
    localStorage.setItem('quickqr_reserve_item', '{}');
    localStorage.setItem('quickqr_reserve', '{}');
    localStorage.setItem('quickqr_current_reserve_id', '');
    localStorage.setItem('quickqr_order', '{}');
    localStorage.setItem('quickqr_shipping_fee', '');
   // localStorage.setItem('quickqr_id_customer', '');
    localStorage.setItem('quickqr_next_order', 0);
    localStorage.setItem('status_order', '');
    localStorage.setItem('quickqr_action', '');
    localStorage.setItem('quickqr_table', '');
    localStorage.setItem('quickqr_discount_price', '');
    localStorage.setItem('quickqr_discount_code', '');
    localStorage.setItem('action_save_date_reservation', '');
    localStorage.setItem('quickqr_address', '');
    localStorage.setItem('quickqr_house_number', '');
    localStorage.setItem('quickqr_street_name', '');
    localStorage.setItem('quickqr_city', '');
    localStorage.setItem('quickqr_zip_code', '');
}
$(document).on('ready', function () {
           // cookie consent
           if (COOKIE_ACCEPTANCE == "0") {
            jQuery('.cookieConsentContainer').delay(2000).fadeIn();
        }
        // else
        // {
        //     jQuery(".function-model-detail").children().prop('disabled', false);
        //     jQuery(".function-model-detail").prop('disabled', false);
        //     jQuery(".function-model-detail-small").prop('disabled', false);
        //     jQuery(".go-to-order-items").prop('disabled', false);
          
        // } 

        jQuery('.cookieAcceptButton').on('click', function () {
            jQuery('.cookieConsentContainer').fadeOut();
            localStorage.setItem('Quick-cookie', '1');
        //   let $data = [];
        //   $data.push({ name: 'action', value: 'cookieAccept' });
        //   jQuery(".cookieAcceptButton").addClass('button-progress').prop('disabled', true);
        //  jQuery.ajax({
        //          type: "POST",
        //          url: ajaxurl,
        //          data: $data,
        //          dataType: 'json',
        //          success: function (response) {
        //          if (response.success) {    
        //             jQuery('.cookieConsentContainer').fadeOut();
        //             localStorage.setItem('Quick-cookie', '1');
        //             jQuery(".function-model-detail").children().prop('disabled', false);
        //             jQuery(".function-model-detail").prop('disabled', false);
        //             jQuery(".go-to-order-items").prop('disabled', false);
        //             jQuery(".function-model-detail-small").prop('disabled', false);
                    
        //          }                             
        //        }
        //       });
          
        });

    $(document).on('click', '.go-to-order-items', function (e) {

        var item_id = jQuery(this).data('id');
        localStorage.setItem('reservation_food_action_click', '0');
        if(RESTAURANT_DELIVERY_ORDER == "1")
        {
            localStorage.setItem('quickqr_action','delivery-action');
        }
        else if(RESTAURANT_TAKEAWAY_ORDER == "1")
        {
            localStorage.setItem('quickqr_action','takeaway-action');
        }
        localStorage.setItem('quickqr_item_id',item_id);
        location.href = ORDER_LINK;
    });

    $(document).on('click', ".delivery-action", function (e) {
        e.preventDefault();
        localStorage.setItem('reservation_food_action_click', '0');
        localStorage.setItem('quickqr_action', 'delivery-action');
        jQuery.magnificPopup.open({
            items: {
                src: '#popup-data-function-model',
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            }
        });
  
      //  jQuery("#go-to-order-form").submit();
    })

    


    $(document).on('click', "#send-data-to-form", function (e) {
        e.preventDefault();
        if (jQuery('#address-field-2').val()) {
            let $btn = jQuery(this);
            let $data = [];

            $data.push({ name: 'action', value: 'getShippingFee' });
            $data.push({ name: 'address', value: jQuery('#address-field-2').val()});
            $data.push({ name: 'zip_code', value:  localStorage.getItem('quickqr_zip_code')});
            $data.push({ name: 'restaurant', value: RESTAURANT_ID });
            $data.push({ name: 'route', value:  localStorage.getItem('quickqr_street_name') });
            $btn.addClass('button-progress').prop('disabled', true); 
            $btn.addClass('button-progress').prop('disabled', true);
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: $data,
                dataType: 'json',
                success: function (response) {
                    $btn.removeClass('button-progress').prop('disabled', false);
                    if (response.success) {
                        localStorage.setItem('quickqr_action', 'delivery-action');
                        location.href = ORDER_LINK;
                    } else {
                            swal({
                                title: '',
                                text: response.message,
                                type: "warning",
                                showCancelButton: false,
                                confirmButtonColor: "var(--classic-color-1)",
                                confirmButtonText: "OK",
                                closeOnConfirm: false,
                                closeOnCancel: false
                            },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        swal.close();
                                    }
                                });
                        
                      
                    }
                }
            });

     
        }
        else 
        {
            swal({
                title: '',
                text:LANG_PLEASE_ENTER_YOUR_SHIPPING_ADDRESS,
                type: "warning",
                showCancelButton: false,
                confirmButtonColor: "var(--classic-color-1)",
                confirmButtonText: "OK",
                closeOnConfirm: false,
                closeOnCancel: false
            },
                function (isConfirm) {
                    if (isConfirm) {
                        swal.close();
                    }
                });
        }

    })
   
    $(document).on('click', ".takeaway-action", function (e) {
        e.preventDefault();
        localStorage.setItem('reservation_food_action_click', '0');
        localStorage.setItem('quickqr_action', 'takeaway-action');
        location.href = ORDER_LINK;
    })

    function convertTo24Hour(time) {
        var hours = parseInt(time.substr(0, 2));
        if (time.indexOf('am') != -1 && hours == 12) {
            time = time.replace('12', '0');
        }
        if (time.indexOf('pm') != -1 && hours < 12) {
            time = time.replace(hours, (hours + 12));
        }
        return time.replace(/(am|pm)/, '');
    }

    $(".register-input-date-time").on('change', function (e) {
        e.stopPropagation();
        e.preventDefault();
        load_all_table_exist();
    });

    function load_all_table_exist() {
        let date = jQuery("#register_date").val();
        let from = jQuery("#register_time_from").val();
        let to = jQuery("#register_time_to").val();
        let ticket = jQuery("#register_ticket").val();
        let inputDate = new Date(jQuery("#register_date").val());
        let todaysDate = new Date();
        let $status = jQuery('.content-slider-notifi');
        let $btn = jQuery(".btn-booking");
        let stt = new Date(date + "T" + from);
        console.log(inputDate)
        stt = stt.getTime();
        let endt = new Date(date + "T" + to);
        endt = endt.getTime();
        if (inputDate.setHours(0, 0, 0, 0) < todaysDate.setHours(0, 0, 0, 0)) {
            $status.removeClass('success').addClass('error').html('<p>' + LANG_ERROR_DATE + '</p>').slideDown()
            jQuery("#content-slider").html('');
            jQuery("#content-slider").hide;
            return false;
        }

        if (date && from && to && ticket) {
            if (stt > endt) {
                jQuery("#content-slider").html('');
                jQuery("#content-slider").hide;
                $status.removeClass('success').addClass('error').html('<p>' + LANG_ERROR_TIME + '</p>').slideDown()
                return false;
            }
            // else {
            //     $status.html(LANG_PLEASE_ENTER_THE_RESERVATION_TIME).slideDown();
            // }
            var date_from = new Date(date + "T" + convertTo24Hour(from) + ":00");
            var time_from_30 = date_from.setTime(date_from.getTime() + (30*60*1000))
            var date_to = new Date(date + "T" + convertTo24Hour(to) + ":00");
            var time_to = date_to.setTime(date_to.getTime());
            //kim tra thời gian khong nho hơn thoi gian hien tại  
            let f = new Date(date + "T" + convertTo24Hour(from) + ":00")
            let n = new Date()
            if (f.getTime() < n.getTime()) {
                jQuery("#content-slider").html('');
                jQuery("#content-slider").hide;
                $status.removeClass('success').addClass('error').html('<p>' + LANG_ERROR_TIME + '</p>').slideDown()
                return false;
            }

            // kiểm tra thời gian từ phải lớn nhỏ hơn thời gian đến tối thiểu 30 phút 

            if (time_to < time_from_30) {
                jQuery("#content-slider").html('');
                jQuery("#content-slider").hide;
                $status.removeClass('success').addClass('error').html('<p>' + LANG_TIME_FROM_AND_ARRIVAL_TIME_30 + '</p>').slideDown()
                return false;
            }
            let data = {
                "action": 'getTableExist',
                "from": date + " " + convertTo24Hour(from) + ":00",
                "to": date + " " + convertTo24Hour(to) + ":00",
                "slug": jQuery("#slug").val(),
                "ticket": ticket
            };

            $btn.addClass('button-progress').prop('disabled', true);
            console.log(siteurl + "php/get_table_exist.php");
            //call api
            jQuery.ajax({
                url: siteurl + "php/get_table_exist.php",
                data: data,
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        jQuery("#content-slider").show();
                        if (response.message) {
                            jQuery("#content-slider").prop('disabled', false);
                            jQuery("#content-slider").slick('unslick');
                            jQuery("#content-slider").html(response.message);
                            jQuery("#content-slider").not('.slick-initialized').slick(setting_slick_booking);
                            jQuery("#content-slider").find(".slick-prev").addClass('slick-prev-2');
                            jQuery("#content-slider").find(".slick-next").addClass('slick-next-2');
                            $("#content-slider").find(".slick-prev").html("<i class='fas fa-chevron-left' style='font-size:24px;color:white'></i>");
                                $("#content-slider").find(".slick-next").html("<i class='fas fa-chevron-right' style='font-size:24px;color:white'></i>");
                            $status.slideUp();
                        }
                    }
                    else {
                        jQuery("#content-slider").html('');
                        jQuery("#content-slider").hide;
                        $status.html(response.message).slideDown();
                    }
                },
            });

            $btn.removeClass('button-progress').prop('disabled', false);
        }
    }

    $("#forgot-password-form").on('submit', function (e) {
        e.stopPropagation();
        e.preventDefault();
        let $form = jQuery(this);
        let $btn = $form.find('button');
        $btn.addClass('button-progress').prop('disabled', true);
        let data = $form.serializeArray();
        data.push({ name: 'action', value: 'ForgotPassword' });
        data.push({ name: 'restaurant_id', value: RESTAURANT_ID });
        
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: data,
            dataType: 'json',
            success: function (response) {
                $btn.removeClass('button-progress').prop('disabled', false);
                if (response.success) {
                    jQuery("#forgotEmail").val('');
                    if (response.message != '' && response.message != null) {
                        //   location.href = response.message;
                    } else {
                        jQuery('.forgot-form').slideUp();
                        jQuery('.order-success-message').slideDown();
                    }

                } else {
                    $form.find('.form-error').html(response.message).slideDown();
                }
            }
        });
        return false;
    });

    $(document).on('click', ".table-element", function (e) {
        jQuery(".table-element").removeClass("table-element-active");
        jQuery(this).addClass("table-element-active");
    });

    $(document).on('click', ".reservations-action", function (e) {
        e.preventDefault();
        jQuery("#register_table").prop('disabled', true);
        jQuery('.booking-form').slideDown();
        jQuery('.order-success-message').slideUp();
        jQuery("#bookmarks-order-button").hide();
        jQuery.magnificPopup.open({
            items: {
                src: '#bookingModal',
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            }
        });
    });

    $(document).on('input', '#register_phone', function (e) {
        checkElementInvalid(jQuery("#register_phone"), false, true);
    });
    $(document).on('input', '#register_names', function (e) {
        let element = jQuery(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
    });
    $(document).on('input', '#register_time_to', function (e) {
        let element = jQuery(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
    });
    $(document).on('input', '#register_time_from', function (e) {
        let element = jQuery(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
    });
    $(document).on('input', '#register_date', function (e) {
        let element = jQuery(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
    });
    $(document).on('input', '#register_ticket', function (e) {
        let element = jQuery(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
    });
    $(document).on('click', ".button-login", function (e) {
        e.preventDefault();
        showLoginForm();
    });

    $(document).on('input', '#register_email', function (e) {
        let element = jQuery(this);
        if (element.val().length > 0) {
            if (!validateEmail(element.val())) {
                addClassError(element);
                ref = false;
            }
            else {
                removeClassError(element);
            }
        }
        else {
            addClassError(element);
        }
    });

    $(document).on('submit', '#booking-form', function (e) {
        e.stopPropagation();
        e.preventDefault();

        let $form = jQuery(this);
        let restaurant_id = RESTAURANT_ID;
        let date = jQuery("#register_date").val();
        let from = jQuery("#register_time_from").val();
        let to = jQuery("#register_time_to").val();
        let ticket = jQuery("#register_ticket").val();
        let inputDate = new Date(jQuery("#register_date").val());
        let todaysDate = new Date();
        let $status = jQuery('#type-status');
        let $btn = jQuery("#booking-submit-button");
        let stt = new Date(date + "T" + from);
        stt = stt.getTime();
        let endt = new Date(date + "T" + to);
        endt = endt.getTime();
        // "#booking-form"
        let bInvalidTicket = true;
        let bInvalidDate = true;
        let bInvalidTimeFrom = true;
        let bInvalidTimeTo = true;
        let bInvalidName = true;
        let bInvalidPhone = true;
        let bInvalidEmail = true;
        bInvalidEmail = checkElementInvalid(jQuery("#register_email"), true);
        bInvalidPhone = checkElementInvalid(jQuery("#register_phone"), false, true);
        bInvalidName = checkElementInvalid(jQuery("#register_names"), false);
        bInvalidTimeTo = checkElementInvalid(jQuery("#register_time_to"), false);
        bInvalidTimeFrom = checkElementInvalid(jQuery("#register_time_from"), false);
        bInvalidDate = checkElementInvalid(jQuery("#register_date"), false);
        bInvalidTicket = checkElementInvalid(jQuery("#register_ticket"), false);

        if (bInvalidEmail == false || bInvalidPhone == false || bInvalidName == false || bInvalidTimeTo == false || bInvalidTimeFrom == false || bInvalidDate == false || bInvalidTicket == false) {
            return false;
        }
        if (inputDate.setHours(0, 0, 0, 0) < todaysDate.setHours(0, 0, 0, 0)) {
            $status.removeClass('success').addClass('error').html('<p>' + LANG_ERROR_DATE + '</p>').slideDown()
            return false;
        }
        else {
            $status.slideUp();
        }

        if (date && from && to && ticket) {
            if (stt > endt) {
                $status.removeClass('success').addClass('error').html('<p>' + LANG_ERROR_TIME + '</p>').slideDown()
                return false;
            }
            else {
                $status.slideUp();
            }
            let table_element = jQuery('.table-element-active');
            if (!table_element) {
                $status.removeClass('success').addClass('error').html('<p>' + LANG_PLEASE_ENTER_THE_TABLE_NUMBER + '</p>').slideDown()
                return false;
            }

            if (!validatePhone('register_phone')) {
                $status.removeClass('success').addClass('error').html('<p>' + LANG_PHONE_INVALID + '</p>').slideDown()
                return false;
            }
            $data = [];
            $data.push({ name: 'action', value: 'checkOpenHourBooking' });
            $data.push({ name: 'datetime_from', value: date + " " + from });
            $data.push({ name: 'datetime_to', value: date + " " + to });
            $data.push({ name: 'restaurant_id', value: restaurant_id });

            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: $data,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {

                        let data = {
                            "action": 'SendRestaurantBooking',
                            "date": date,
                            "from": date + " " + convertTo24Hour(from) + ":00",
                            "to": date + " " + convertTo24Hour(to) + ":00",
                            "slug": jQuery("#slug").val(),
                            "ticket": ticket,
                            "table": table_element.data('table-number'),
                            "name": jQuery("#register_names").val(),
                            "phone": jQuery("#register_phone").val(),
                            "email": jQuery("#register_email").val(),
                            "note": jQuery("#register-message-field").val()
                        };
                        console.log(data)
                        $btn.addClass('button-progress').prop('disabled', true);
                        jQuery.ajax({
                            type: "POST",
                            url: ajaxurl,
                            data: data,
                            dataType: 'json',
                            success: function (response) {
                                $btn.removeClass('button-progress').prop('disabled', false);

                                if (response.success) {
                                    jQuery("#register_ticket").val('').trigger('change');
                                    jQuery("#register_date").val('');
                                    jQuery("#register_time_from").val('');
                                    jQuery("#register_time_to").val('');
                                    jQuery("#register-message-field").val('');
                                    $data = [];
                                    $data.push({ name: 'action', value: 'check_user_login' });
                                    $data.push({ name: 'restaurant_id', value: RESTAURANT_ID });

                                    jQuery.ajax({
                                        type: "POST",
                                        url: ajaxurl,
                                        data: $data,
                                        dataType: 'json',
                                        success: function (response) {
                                            if (response.success) {
                                                //  do nothing 
                                            }
                                            else {
                                                jQuery("#register_names").val('');
                                                jQuery("#register_phone").val('');
                                                jQuery("#register_email").val('');
                                            }
                                        }
                                    });
                                    jQuery("#content-slider").html('');
                                    jQuery("#content-slider").hide;
                                    jQuery("#register_table").html('<option value="">{LANG_PLEASE_CHOOSE_YOUR_TABLE}</option>');
                                    if (response.message != '' && response.message != null) {
                                        location.href = response.message;
                                    }
                                    else {
                                        jQuery('.booking-form').slideUp();
                                        jQuery('.order-success-message').slideDown();

                                        if (response.whatsapp_url != '' && response.whatsapp_url != null) {
                                            // send to whatsapp
                                            location.href = response.whatsapp_url;
                                        }
                                    }

                                } else {
                                    $form.find('.form-error').html(response.message).slideDown();
                                    if (response.message == LANG_THIS_TABLE_IS_ALREADY_BOOKED) {
                                        load_all_table_exist();
                                    }
                                }
                            }
                        });
                    }
                    else {

                           swal({
                            title: '',
                            text:response.message,
                            type: "warning",
                            showCancelButton: false,
                            confirmButtonColor: "var(--classic-color-1)",
                            confirmButtonText: "OK",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        },
                            function (isConfirm) {
                                if (isConfirm) {
                                    swal.close();
                                }
                            });
                    }
                }
            });



        }
        return false;
    });
    function showLoginForm() {
        jQuery.magnificPopup.open({
            items: {
                src: '#loginModal',
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            }
        });
    }
    $(document).on('click', ".button-signup", function (e) {
        e.preventDefault();
        ShowRegisterForm();
    });
    $(document).on('click', ".button-register", function (e) {
        e.preventDefault();
        ShowRegisterForm();
    });

    function ShowRegisterForm() {
        jQuery.magnificPopup.open({
            items: {
                src: '#registerModal',
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            }
        });
    }

    $("#register-account-button").on('click',function(e){
        e.stopPropagation();
        e.preventDefault(); 
        let $data = [];
         $data.push({ name: 'action', value: 'check_availability_customers_register' });
         $data.push({ name: 'name', value: jQuery("#Rname").val() });
         $data.push({ name: 'username', value: jQuery("#Rusername").val() });
         $data.push({ name: 'email', value: jQuery("#Remail").val() });
         $data.push({ name: 'password', value: jQuery("#Rpassword").val() });
         $data.push({ name: 'slug', value: jQuery("#slug").val() });
         jQuery("#register-account-button").addClass('button-progress').prop('disabled', true);
        jQuery.ajax({
                type: "POST",
                url: siteurl + "php/check_availability_customers_register.php",
                data: $data,
                dataType: 'json',
                success: function (response) {
                if (response.success) {    
                    let action = localStorage.getItem('reservation_food_action_click');
                    if (action == "1") {            
                      localStorage.setItem('show_reservation',"1");
                      localStorage.setItem('quickqr_action', 'reservation-food-action');
                      localStorage.setItem('current_url',ORDER_LINK)
                       }
                       else
                       {
                      localStorage.setItem('show_reservation',"0");
                       }                    
                    jQuery("#register-account-form").submit();  
                }
                else
                {
                    jQuery("#register-account-button").removeClass('button-progress').prop('disabled', false);
                                
                    if(response.password_status)
                    {
                        jQuery("#password-availability-status").html(response.password_status);
                        jQuery("#Rpassword").focus();
                    }
                    if(response.email_status)
                    {
                        jQuery("#email-availability-status").html(response.email_status);
                        jQuery("#Remail").focus();
                    }
                    if(response.user_status)
                    {
                        jQuery("#user-availability-status").html(response.user_status);
                        jQuery("#Rusername").focus();
                    }
                    if(response.name_status)
                    {
                        jQuery("#name-availability-status").html(response.name_status);
                        jQuery("#Rname").focus();
                    }	
        
                }
                                    
              }
             });
    })

    $("#login-form").on('submit', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var $form = jQuery(this),
            form_data = $form.serializeArray(),
            $btn = $form.find('button'),
            $status = $form.find('#type-status');
        form_data.push({
            name: 'action',
            value: 'customers_login'
        });
        form_data.push({
            name: 'slug',
            value: SLUG
        });
        $btn.addClass('button-progress').prop('disabled', true);
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: form_data,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                let action = localStorage.getItem('reservation_food_action_click');
              if (action == "1") {            
                localStorage.setItem('show_reservation',"1");
                localStorage.setItem('quickqr_action', 'reservation-food-action');
                location.href = ORDER_LINK;
                 }
                 else
                 {
                localStorage.setItem('show_reservation',"0");
                location.reload();
                 }
              
                 
                }
                else {
                    $status.removeClass('success').addClass('error').html('<p>' + response.message + '</p>').slideDown();
                }
                $btn.removeClass('button-progress').prop('disabled', false);
            }
        });
        return false;
    });

   
    $(document).on('click', ".button-forgot-password", function (e) {
        e.preventDefault();
        jQuery('.forgot-form').slideDown();
        jQuery('.order-success-message').slideUp();
        jQuery.magnificPopup.open({
            items: {
                src: '#ForgotPasswordModal',
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            }
        });

    });
    $(document).on('click', ".reservation-food-action", function (e) {
        e.preventDefault();
        localStorage.setItem('reservation_food_action_click', '1');
        let $data = [];
        $data.push({ name: 'action', value: 'check_user_login' });
        $data.push({ name: 'restaurant_id', value: RESTAURANT_ID });
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: $data,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    localStorage.setItem('show_reservation',"1");
                    localStorage.setItem('quickqr_action', 'reservation-food-action');
                    location.href = ORDER_LINK;
                }
                else {
                    showLoginForm();
                }
            }
        });
    });



    $(document).on('click', ".view-info-menu", function (e) {
        e.preventDefault();
        console.log(TOTAL_MENUS[jQuery(this).data('id')]);
        var item_id = jQuery(this).data('id'),
            name = TOTAL_MENUS[item_id].title,
            description = TOTAL_MENUS[item_id].description,
            price = TOTAL_MENUS[item_id].price,
            price_format = TOTAL_MENUS[item_id].price_format,
            order_price = Number(price),
            menu_id = TOTAL_MENUS[item_id].menu_id,
            cat_name = TOTAL_MENUS[item_id].cat_name;

        var img = TOTAL_MENUS[item_id].img;
        var imgFullLink = TOTAL_MENUS[item_id].imgFullLink;
        var img_tlp = '';
        if (RESTAURANT_DISPLAY_MENU_ID == 1) {
            name = menu_id + name;
        }
        if (RESTAURANT_DISPLAY_MENU_PRICE == 0) {
            price_format = '';
        }
        if (img != "default.png" && RESTAURANT_DISPLAY_MENU_IMAGE == 1) {
            img_tlp = '<img class="menu-avatar-add-extra" src="' + imgFullLink + '" alt="' + name + '" />  '
        }
        // properties
        var sproperties = TOTAL_MENUS[item_id].properties + "";
        var properties_tpl = "";
        if (sproperties) {
            var arr_properties = sproperties.split("#");
            properties_tpl = '<h4 class="allegie_title">' + LANG_PROPERTIES + '</h4> <ul>';
            jQuery.each(arr_properties, function (index, item) {
                let a = item.split("|");
                let name = a[1];
                let image = a[2];
                let img_properties = '';
                if (image) {
                    img_properties = '<img class="svg svg-restaurant-menu" src="' + siteurl + 'storage/icon-food/' + image + '"/>'
                }
                properties_tpl = properties_tpl + '<li>' + img_properties + '<span>' + name + '</span></li>';

            });
            properties_tpl = properties_tpl + '</ul>';
        }


        var sadditives = TOTAL_MENUS[item_id].additives + "";
        var additives_tpl = "";
        if (sadditives) {
            var arr_additives = sadditives.split("#");
            additives_tpl = '<h4 class="allegie_title">' + LANG_ADDITIVES + '</h4> <ul>';
            jQuery.each(arr_additives, function (index, item) {
                let a = item.split("|");
                let aliases = a[0];
                additives_tpl = additives_tpl + '<li>' + aliases + '</li>';
            });
            additives_tpl = additives_tpl + '</ul>';
        }
        var sallegie = TOTAL_MENUS[item_id].allegie + "";
        var allegie_tpl = "";
        if (sallegie) {
            var arr_allegie = sallegie.split("#");
            allegie_tpl = '<h4 class="allegie_title">' + LANG_ALLEGIE + '</h4> <ul>';
            jQuery.each(arr_allegie, function (index, item) {
                let a = item.split("|");
                let name = a[1];
                let image = a[2];
                let img_allegie = '';
                if (image) {
                    img_allegie = '<img class="svg svg-restaurant-menu" src="' + siteurl + 'storage/icon-food/' + image + '"/>'
                }
                allegie_tpl = allegie_tpl + '<li>' + img_allegie + '<span>' + name + '</span></li>';

            });
            allegie_tpl = allegie_tpl + '</ul>'
        }
        jQuery('#add-extras .category_name').html(cat_name);
        jQuery('#add-extras .menu_title').html(name);
        jQuery('#add-extras .menu_desc').html(description);
        jQuery('#add-extras .menu_price').html(price_format);
        jQuery('#add-extras .menu-avatar-container').html(img_tlp);
        jQuery('#Allegie_detail').html(allegie_tpl + additives_tpl + properties_tpl);
        jQuery('#Allegie_detail').css("display", "block");
        jQuery('.menu-data').css("display", "none");
        loadsvg();

        jQuery('#menu-order-quantity').val(1);

        var $extra_wrapper = jQuery('#menu-extra-items');
        $extra_wrapper.html('');
        var extras = TOTAL_MENUS[item_id].extras || [];

        var $menu_extra_option_wrapper = jQuery('#menu-extra-option-items');
        $menu_extra_option_wrapper.html('');
        var extras_option = TOTAL_MENUS[item_id].extras_option || [];

        if (extras_option.length == 0) {
            jQuery('#add-extras .menu_dots').show();
            jQuery('#add-extras .menu_price').show();
            jQuery('#add-extras .menu_price').html(price_format);
            jQuery('.menu-extra-option-wrapper').hide();
        } else {
            order_price = 0;
            jQuery('#add-extras .menu_price').hide();
            jQuery('#add-extras .menu_dots').hide();
            jQuery('.menu-extra-option-wrapper').show();
        }
        for (var i in extras_option) {
            if (extras_option.hasOwnProperty(i)) {

                var $extra_option_tpl = jQuery(
                    '<div class="d-flex menu-extra-option-item">' +
                    '<div class="radio">' +
                    '<input type="radio" name="radio_extra" id="radio1">' +
                    '<label for="radio1"> <span class="radio-label"></span> <span class="extra-item-title"></span>' +
                    '</label>' +
                    '</div>' +
                    '<strong class="margin-left-auto extra-item-price"> </strong>' +
                    '</div>');
                $extra_option_tpl.find('.radio input').attr('id', 'radio' + extras_option[i].id);
                $extra_option_tpl.find('label').attr('for', 'radio' + extras_option[i].id);
                $extra_option_tpl.find('.extra-item-title').html(extras_option[i].title);
                if (RESTAURANT_DISPLAY_MENU_PRICE == 0) {
                    $extra_option_tpl.find('.extra-item-price').html('');
                }
                else
                {
                    $extra_option_tpl.find('.extra-item-price').html(formatPrice(extras_option[i].price));
                }
               
                $extra_option_tpl.data('price', extras_option[i].price);
                $extra_option_tpl.data('id', extras_option[i].id);
                $extra_option_tpl.find('.radio input').on('change', function () {
                    calculateOrderPrice(order_price);
                });
                $menu_extra_option_wrapper.append($extra_option_tpl);
            }
        }
        var min_extra_option_price = '';
        jQuery('.menu-extra-option-item').each(function () {
            var price = Number(jQuery(this).data('price'));
            if (min_extra_option_price == '') {
                min_extra_option_price = price;
                jQuery(this).find('.radio input').attr('checked', true);
            }
            if (min_extra_option_price > price) {
                min_extra_option_price = price;
                jQuery(this).find('.radio input').attr('checked', true);
            }
        });

        if (extras.length == 0) {
            jQuery('.menu-extra-wrapper').hide();
        } else {
            jQuery('.menu-extra-wrapper').show();
        }
        for (var i in extras) {
            if (extras.hasOwnProperty(i)) {
                var $extra_tpl = jQuery(
                    '<div class="d-flex menu-extra-item">' +
                    '<div class="checkbox">' +
                    '<input type="checkbox" id="chekcbox1">' +
                    '<label for="chekcbox1">' +
                    '<span class="checkbox-icon"></span> <span class="extra-item-title"></span>' +
                    '</label>' +
                    '</div>' +
                    '<strong class="margin-left-auto extra-item-price"></strong>' +
                    '</div>');

                $extra_tpl.find('.checkbox input').attr('id', 'checkbox' + extras[i].id);
                $extra_tpl.find('label').attr('for', 'checkbox' + extras[i].id);
                $extra_tpl.find('.extra-item-title').html(extras[i].title);
                if (RESTAURANT_DISPLAY_MENU_PRICE == 0) {
                    $extra_tpl.find('.extra-item-price').html('');
                } 
                else
                {
                    $extra_tpl.find('.extra-item-price').html(formatPrice(extras[i].price));
                }
               
                $extra_tpl.data('price', extras[i].price);
                $extra_tpl.data('id', extras[i].id);

                $extra_wrapper.append($extra_tpl);
            }
        }

        jQuery.magnificPopup.open({
            items: {
                src: '#add-extras',
                type: 'inline',
                fixedContentPos: false,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            }
        });

    });



    function calculateOrderPrice(amount) {
        var extra = 0;
        var extra_option = 0;
        $('.menu-extra-item').each(function () {
            if ($(this).find('.checkbox input').is(':checked')) {
                extra += Number($(this).data('price'));
            }
        });
        $('.menu-extra-option-item').each(function () {
            if ($(this).find('.radio input').is(':checked')) {
                extra_option += Number($(this).data('price'));
            }
        });

        $('#order-price').html(formatPrice((amount + extra + extra_option) * Number($('#menu-order-quantity').val())));
        getTotalSumOrder();

    }

    function formatPrice(price) {
        var number = price * 1;//makes sure `number` is numeric value
        var str = number.toFixed(CURRENCY_DECIMAL_PLACES ? CURRENCY_DECIMAL_PLACES : 0).toString().split('.');
        var parts = [];
        for (var i = str[0].length; i > 0; i -= 3) {
            parts.unshift(str[0].substring(Math.max(0, i - 3), i));
        }
        str[0] = parts.join(CURRENCY_THOUSAND_SEPARATOR ? CURRENCY_THOUSAND_SEPARATOR : ',');
        price = str.join(CURRENCY_DECIMAL_SEPARATOR ? CURRENCY_DECIMAL_SEPARATOR : '.');

        return (CURRENCY_LEFT == 1 ? CURRENCY_SIGN + ' ' : '') + price + (CURRENCY_LEFT == 0 ? ' ' + CURRENCY_SIGN : '');
    }

    function loadsvg() {
        jQuery('img.svg-restaurant-menu').each(function () {
            var $img = jQuery(this);
            var imgID = $img.attr('id');
            var imgClass = $img.attr('class');
            var imgURL = $img.attr('src');

            jQuery.get(imgURL, function (data) {
                // Get the SVG tag, ignore the rest
                var $svg = jQuery(data).find('svg');

                // Add replaced image's ID to the new SVG
                if (typeof imgID !== 'undefined') {
                    $svg = $svg.attr('id', imgID);
                }
                // Add replaced image's classes to the new SVG
                if (typeof imgClass !== 'undefined') {
                    $svg = $svg.attr('class', imgClass + ' replaced-svg');
                }

                // Remove any invalid XML tags as per http://validator.w3.org
                $svg = $svg.removeAttr('xmlns');
                $svg = $svg.removeAttr('xmlns:xlink');

                // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
                if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
                    $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
                }

                // Replace image with new SVG
                $img.replaceWith($svg);

            }, 'xml');

        });
    }
});