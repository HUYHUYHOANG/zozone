(function ($) {
  
    if (typeof RESTAURANT_POPUP_MESSAGES_ON_OFF !== 'undefined') {
        if(RESTAURANT_POPUP_MESSAGES_ON_OFF == "1")
        {
            swal({
                title: '',
                text: RESTAURANT_POPUP_MESSAGES,
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
        
            setTimeout(closePopup, RESTAURANT_SECOND_POPUP * 1000);
        }
    }
    function closePopup()
    {
        swal.close();
    }
    var bookmarks_payment_methoad_open = false;//bookmarks-order-button-step-3
    var $window = $(window);
    var loadPage = true;  
    let url = new URL(window.location.href);
    var table_number = '';
    if (url.searchParams.get('table')) {
        table_number = url.searchParams.get('table'); 
    }  
    localStorage.setItem('action_save_date_reservation',''); 
    var quickqr_discount_price = localStorage.getItem('quickqr_discount_price');
    var quickqr_discount_code =  localStorage.getItem('quickqr_discount_code');
    if(quickqr_discount_price != null && quickqr_discount_code != null && quickqr_discount_code.length > 0 && quickqr_discount_price.length > 0)
    {
        $("#bookmarks_discount_price").html('-' + formatPrice(quickqr_discount_price)); 
        $("#your_order_discount_price").html('-' + formatPrice(quickqr_discount_price));
        $("#bookmarks_discount_code").html(quickqr_discount_code); 
        $("#your_order_discount_code").html(quickqr_discount_code);
    }
                          
    onLoadPage();
    function openDateTimePicker() {
   
        $.magnificPopup.open({
            items: {
                src: '#DateTimeModal',
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
    function removeLocalStore(remove_address = false) {
        localStorage.setItem('quickqr_reserve_item', '{}');
        localStorage.setItem('quickqr_reserve', '{}');
        localStorage.setItem('quickqr_current_reserve_id', '');
        localStorage.setItem('quickqr_order', '{}');
        localStorage.setItem('quickqr_shipping_fee', '');
        localStorage.setItem('quickqr_id_customer', '');
        localStorage.setItem('quickqr_next_order', 1);
        localStorage.setItem('status_order', '');
        localStorage.setItem('quickqr_action', '');
        localStorage.setItem('quickqr_table', '');
        localStorage.setItem('quickqr_discount_price', '');      
        localStorage.setItem('quickqr_discount_code', '');   
        localStorage.setItem('action_save_date_reservation',''); 
        $("#bookmarks_discount_price").html(''); 
        $("#bookmarks_discount_code").html(''); 
        $("#your_order_discount_code").html(''); 
        $("#your_order_discount_price").html(''); 
        if (remove_address) {
            localStorage.setItem('quickqr_address', '');
            localStorage.setItem('quickqr_house_number', '');
            localStorage.setItem('quickqr_street_name', '');
            localStorage.setItem('quickqr_city', '');
            localStorage.setItem('quickqr_zip_code', '');
        }
    }
    function chẹkAndRemoveLocalStorage() {
        let Ref = false;
        // kiem tra xem co dang load vao trang dat hang online
        if (typeof RESTAURANT_ON_TABLE_ORDER !== 'undefined') {
            //set pay on counter
            localStorage.setItem('quickqr_pay_via', 'pay_on_counter');
            // remove old localstorage data
            var slug = $('#slug').val();
            var slug_pre = localStorage.getItem('slug');
            localStorage.setItem('slug', slug);
            if (slug != slug_pre) {
                removeLocalStore();
                Ref = true;
            }
            else {
                var order_data_init = JSON.parse(localStorage.getItem('quickqr_order'));
                if (order_data_init) {
                    var sum = getTotalSumOrder(false);
                    if (sum !== 0) {
                        checkWidthandSetViewOrderWrapper()
                        $("#bookmarks-order-button").show();
                        Ref = false;
                    }
                    else {
                        Ref = true;
                    }
                }
                else {
                    removeLocalStore();
                    Ref = true;
                }
            }
        }
        return Ref;
    }

    function showFunctionModel() {
        removeLocalStore();
        if(ONLY_ON_TABLE != "1" && RESTAURANT_SHOW_POPPUP == "1")
        {
    
            disabledMenu(false);
            if ($("#FunctionModal")[0]) {
                $.magnificPopup.open({
                    items: {
                        src: '#FunctionModal',
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
        }
     
    }

    function showReservationFood() {
        localStorage.setItem('quickqr_discount_price', '');      
        localStorage.setItem('quickqr_discount_code', '');    
        $("#bookmarks_discount_price").html(''); 
        $("#bookmarks_discount_code").html(''); 
        $("#your_order_discount_code").html(''); 
        $("#your_order_discount_price").html('');
        $(".user_discount_code_div").hide();
        $(".notification_total_amount").hide();
        $data = [];
        $data.push({ name: 'action', value: 'getShippingFee' });
        $data.push({ name: 'address', value: $("#bookmarks-address-field").val() });
        $data.push({ name: 'zip_code', value: $("#bookmarks-zip-code-field").val() });
        $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
        $data.push({ name: 'route', value: $("#bookmarks-street-name-field").val() });
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: $data,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    localStorage.setItem('quickqr_shipping_fee', response.message);
                    
                }
            }
        });
        //load list from server
        localStorage.setItem('quickqr_reserve', '{}');
        localStorage.setItem('quickqr_current_reserve_id', '');
        localStorage.setItem('quickqr_reserve_item', '{}');
        $('.bookmark-reserve-button-group').hide();
        $('.bookmarks-your-order-price').html('');
        $(".bookmarks_payment_methoad").css({ "left": "100%", "opacity": "0" });
        $(".bookmarks-cart-pay").css({ "left": "100%", "opacity": "0" })
        $(".bookmarks-cart-pay").hide()
        $('.bookmarks-your-order-content').css({ "opacity": "1" });
        $('.bookmarks-your-order-content').show();
        $('.cart-header-step-1').show();
        $('.cart-header-step-2').hide();
        $('.cart-header-step-3').hide();
        $('.cart-header-edit-address').hide();      
        $(".min_total_orders_amount").html(formatPrice(MIN_TOTAL_AMOUNT_PRE_ORDER));
        var reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
        $data = [];
        $data.push({ name: 'action', value: 'getReserveData' });
        $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: $data,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.success) {
                    let reserve_data_response = JSON.parse(response.data)
                    for (var i in reserve_data_response) {
                        let reserve = reserve_data_response[i],
                            date_reserve = reserve.date_reserve,
                            is_disabled = reserve.is_disabled,
                            type = reserve.type,
                            shipping_fee = reserve.shipping_fee,
                            address = reserve.address,
                            coupons_code = reserve.coupons_code,
                            include_total_discount_value = reserve.include_total_discount_value,
                            id = reserve.id;
                        let datetime_value = new Date(date_reserve.replace(" ", "T"))
                        let date = ("0" + datetime_value.getDate()).slice(-2);
                        let year = datetime_value.getFullYear();
                        let month = ("0" + (datetime_value.getMonth() + 1)).slice(-2);
                        let hours = ("0" + datetime_value.getHours()).slice(-2)
                        let minutes = ("0" + datetime_value.getMinutes()).slice(-2);
                        let stime = hours + ':' + minutes
                        let reserve_item_data = {
                            'id': id,
                            'date_reserve': date_reserve,
                            'is_disabled': is_disabled,
                            'date': date + '.' + month + '.' + year,
                            'time': stime,
                            'type': type,
                            'coupons_code': coupons_code,
                            'include_total_discount_value': include_total_discount_value,
                            'shipping_fee': shipping_fee,
                            'address' : address
                        };
                        reserve_data[id] = reserve_item_data;
                    }
                    localStorage.setItem('quickqr_reserve', JSON.stringify(reserve_data));
                    generateViewReserve();
                    $(".div-left").css("width", "100%");
                    $(".div-right").css("display", "none");
                }
            }
        });
        //End load
        $(".basket-empty").show()
        $(".notification_total_amount").hide();
      //  $(".user_discount_code_div").hide();
        $("#bookmarks-cart-content").hide();
        $("#bookmarks-order-button").hide();
        $(".add-item-button").show();
        $('.cart-reservation').show();
        checkWidthandSetViewOrderWrapper();
        $.magnificPopup.close();
    }
    function onLoadPage() {    
        let action = localStorage.getItem('quickqr_action');
        $('.bookmark-reserve-button-group').hide();
        $(".ordering-type-div").hide();
        localStorage.setItem('quickqr_reserve', '{}');
        localStorage.setItem('quickqr_current_reserve_id', '');
        localStorage.setItem('quickqr_reserve_item', '{}');
        let show_reservation = localStorage.getItem('show_reservation');
        if (action == "reservation-food-action" && show_reservation == "1") {
          //  removeLocalStore();
          localStorage.setItem('show_reservation',"0");
          localStorage.setItem('quickqr_discount_price', '');      
          localStorage.setItem('quickqr_discount_code', '');    
          $("#bookmarks_discount_price").html(''); 
          $("#bookmarks_discount_code").html(''); 
          $("#your_order_discount_code").html(''); 
          $("#your_order_discount_price").html('');
          $(".user_discount_code_div").hide();
          $(".notification_total_amount").hide();
          $(".min_total_orders_amount").html(formatPrice(MIN_TOTAL_AMOUNT_PRE_ORDER));
            $data = [];
            $data.push({ name: 'action', value: 'check_user_login' });
            $data.push({ name: 'restaurant_id', value: $("#restaurant_id").val() });
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: $data,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        showReservationFood()
                    }
                    else {
                        localStorage.setItem('quickqr_action','');
                        checkWidthandSetViewOrderWrapper();
                        onLoadOtherAction()
                    }
                }
            });
        }
        else {
            onLoadOtherAction();
        }
    }
    function onLoadOtherAction() {
        let is_remove = chẹkAndRemoveLocalStorage();
        let action = localStorage.getItem('quickqr_action');
        $('.edit_delivery').hide();
        $(".ordering-type-div").hide();
        if (typeof RESTAURANT_ON_TABLE_ORDER !== 'undefined') {
            $(".add-item-button").hide();
            $(".bookmarks-cart-pay").hide();
            $("#bookmarks-order-button").hide();
            $('.bookmarks_payment_methoad').hide();
            $("#w30").css({ "width": "0%", "display": "none" });
            $("#w70").css("width", "100%");
            if (RESTAURANT_ON_TABLE_ORDER == "1") {
                let table = localStorage.getItem('quickqr_table');
                let id_customer = localStorage.getItem('quickqr_id_customer');
                // kiểm tra xem có đang vào QRCode có số bàn
                 $(".min_total_orders_amount").html(formatPrice(MIN_TOTAL_AMOUNT_ON_TABLE_ORDER))
                if (table_number.length !== 0) {
                    if(action != "on-table-action")
                    {
                        localStorage.setItem('quickqr_order', '{}');
                    }
                    if(table_number != table && is_remove == false)
                    {
                        let UrlRedirect = new URL(url.href);                  
                        UrlRedirect.searchParams.set( 'table', table )          
                        window.location = UrlRedirect
                    }
                    else
                    {
                        localStorage.setItem('quickqr_action','on-table-action');
                        let $data = [];
                        $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
                        $data.push({ name: 'table', value: table_number });
                        $data.push({ name: 'table_before', value: table });
                        $data.push({ name: 'action', value: 'check_and_update_table' });
                        $data.push({ name: 'id_customer', value: id_customer });
                        $data.push({ name: 'table_confirm', value: RESTAURANT_TABLE_CONFIRM });
                        $('#send-data-to-form').addClass('button-progress').prop('disabled', true);
                        $.ajax({
                            type: "POST",
                            url: ajaxurl,
                            data: $data,
                            dataType: 'json',
                            success: function (response) {
                                $('#send-data-to-form').removeClass('button-progress').prop('disabled', false);
                                if (response.success) {
                                    localStorage.setItem('quickqr_id_customer', response.id_customer);
                                    localStorage.setItem('quickqr_action', "on-table-action");
                                    localStorage.setItem('quickqr_table', $('#table-number-field-2').val());
                                    $('#table-number-field').val($('#table-number-field-2').val());
                                    disabledMenu(true);
                                    if (RESTAURANT_TABLE_CONFIRM == 0) {
                                        $(".add-item-button").show();
                                        localStorage.setItem('status_order', 'using');
                                        $("#w30").css({ "width": "0%", "display": "none" });
                                        $("#w70").css("width", "100%");
                                    }
                                    else {
                                        if (response.message == 'using') {
                                            $(".add-item-button").show();
                                            localStorage.setItem('status_order', 'using');
                                            $("#w30").css({ "width": "0%", "display": "none" });
                                            $("#w70").css("width", "100%");
                                        }
                                        else {
                                            $(".add-item-button").hide();
                                            $.magnificPopup.open({
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
                                            $('.your-action-content').slideUp();
                                            $('.order-success-message').slideDown();
                                            localStorage.setItem('status_order', 'waiting');
                                        }
                                    }
                                }
                                else {
                                    $('#action-popup').val('on-table-action');
                                    $('#name-2').hide();
                                    $('#table-number-field-2').show();
                                    $('#phone-number-field-2').hide();
                                    $('#email-field-2').hide();
                                    $('#address-field-2').hide();
                                    $('#zip-code-field-2').hide();
                                    $('.your-action-content').slideDown();
                                    $('.order-success-message').slideUp();
                                    $('#form-error-2').html(response.message).slideDown();
                                    $.magnificPopup.open({
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
                                }
                            }
                        });
                    }                
                }
                else if (action == "on-table-action") {
                    let $data = [];
                    $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
                    $data.push({ name: 'table', value: table });
                    $data.push({ name: 'id_customer', value: id_customer });

                    if (is_remove && RESTAURANT_TABLE_CONFIRM == 0) {
                        $data.push({ name: 'action', value: 'ResetStatusOnTable' });
                    }
                    else {
                        $data.push({ name: 'action', value: 'checkTableUsing' });
                    }
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: $data,
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                localStorage.setItem('quickqr_action', action);
                                localStorage.setItem('quickqr_table', table);
                                $('#table-number-field-2').val(table);
                                $('#table-number-field').val(table);
                                disabledMenu(true);
                                $(".add-item-button").show();
                                if (is_remove && RESTAURANT_TABLE_CONFIRM == 0) {
                                    showFunctionModel();
                                }
                                else {
                                    if (response.status == "using") {
                                        $('#table-number-field-2').val(table);
                                        $('#table-number-field').val(table);
                                        disabledMenu(true);
                                        $(".add-item-button").show();
                                    }
                                    else {
                                        showFunctionModel();
                                    }
                                }
                            }
                            else {
                                showFunctionModel();
                            }
                        }
                    });

                }
                else {
                    if (is_remove) {
                        showFunctionModel();
                    }
                    else {
                        let pay_via = localStorage.getItem('quickqr_pay_via');
                        generateViewOrder('add-order-button');
                        getTotalSumOrder();
                        $(".div-left").css("width", "100%");
                        $(".div-right").css("display", "none");
                        $(".add-item-button").show();
                        if (action == "delivery-action") {
                            //set value input address
                             
                            $("#bookmarks-address-field").val(localStorage.getItem('quickqr_address'));
                            $("#address-field").val(localStorage.getItem('quickqr_address'));
                            $("#address-field-2").val(localStorage.getItem('quickqr_address'));
                            $("#bookmarks-house-number-field").val(localStorage.getItem('quickqr_house_number'));
                            $("#house-number-field").val(localStorage.getItem('quickqr_house_number'));
                            $("#bookmarks-street-name-field").val(localStorage.getItem('quickqr_street_name'));
                            $("#street-name-field").val(localStorage.getItem('quickqr_street_name'));
                            $("#bookmarks-zip-code-field").val(localStorage.getItem('quickqr_zip_code'));
                            $("#zip-code-field").val(localStorage.getItem('quickqr_zip_code'));
                            $("#bookmarks-city-field").val(localStorage.getItem('quickqr_city'));
                            $("#city-field").val(localStorage.getItem('quickqr_city'));

                            $(".min_total_orders_amount").html(formatPrice(MIN_TOTAL_AMOUNT_ONLINE_ORDER));
                            $('.bookmarks-name-group').show();
                            $('.bookmarks-table-number-field-group').hide();
                            $('.bookmarks-phone-number-field-group').show();
                            $('.bookmarks-address-field-group').show();
                            $('.bookmarks-email-field-group').show();
                            $('.bookmarks-house-number-field-group').show();
                            $('.bookmarks-street-name-field-group').show();
                            $('.bookmarks-zipcode-city-group').show();
                            $("#ordering-type").val("delivery").change();
                            $('.takeaway-time-to-group').show();
                            $(".add-item-button").show();
                            $('.order-total-shipping-fee').show();
                            $('.cart-delivery-text').show();
                            $(".bookmarks-cart-pay").hide();
                            $('.bookmarks_payment_methoad').hide();
                            let $sPrice = $('.your-order-price-shipping-fee').html();
                            if ($sPrice) {
                                if (pay_via == 'pay_on_counter') {
                                    $('#submit-order-button-text').html(LANG_SEND_ORDER);
                                } else if (pay_via == 'pay_online') {
                                    $('#submit-order-button-text').html(LANG_PAY_NOW);
                                }
                            }
                            else {
                                $('#submit-order-button-text').html(LANG_ORDER_FOR_A_FEE)
                            }
                        }
                        else if (action == "takeaway-action") {
                            $("#ordering-type").val("takeaway").change();
                            $('.order-total-shipping-fee').hide();
                            $(".add-item-button").show();
                            $('.takeaway-time-to-group').show();
                            if (pay_via == 'pay_on_counter') {
                                $('#submit-order-button span').html(LANG_SEND_ORDER);
                            } else if (pay_via == 'pay_online') {
                                $('#submit-order-button span').html(LANG_PAY_NOW);
                            }
                            $(".min_total_orders_amount").html(formatPrice(MIN_TOTAL_AMOUNT_ONLINE_ORDER));
                            $('.bookmarks-name-group').show();
                            $('.bookmarks-zipcode-city-group').hide();
                            $('.bookmarks-table-number-field-group').hide();
                            $('.bookmarks-address-field-group').hide();
                            $('.bookmarks-house-number-field-group').hide();
                            $('.bookmarks-street-name-field-group').hide();
                            $('.bookmarks-phone-number-field-group').show();
                            $('.bookmarks-email-field-group').show();
                            $('.cart-delivery-text').hide();
                            $(".bookmarks-cart-pay").hide();
                            $('.bookmarks_payment_methoad').hide();
                        }

                    }
                }
            }
            else if (RESTAURANT_RESERVATIONS == "1" || RESTAURANT_BOOKING == "1" || RESTAURANT_DELIVERY_ORDER == "1" || RESTAURANT_TAKEAWAY_ORDER == "1") {
                showFunctionModel();
                $(".add-item-button").hide();
            }
        }
    }

    function pay_via_change() {
        let ordering_type = $("#ordering-type").val();
        let pay_via = localStorage.getItem('quickqr_pay_via');
        if (ordering_type == 'delivery') {
            let $sPrice = $('.your-order-price-shipping-fee').html();
            if ($sPrice) {
                if (pay_via == 'pay_on_counter') {
                    $('#submit-order-button-text').html(LANG_SEND_ORDER);
                } else if (pay_via == 'pay_online') {
                    $('#submit-order-button-text').html(LANG_PAY_NOW);
                }
            }
            else {
                $('#submit-order-button-text').html(LANG_ORDER_FOR_A_FEE)
            }
        }
        else {
            if (pay_via == 'pay_on_counter') {
                $('#submit-order-button-text').html(LANG_SEND_ORDER);

            } else if (pay_via == 'pay_online') {
                $('#submit-order-button-text').html(LANG_PAY_NOW);

            }
        }
    }
    $(document).on('click', "#view-reserve-button", function (e) { 
        $("html, body").animate({
            scrollTop: $("#w30").offset().top
        }, 500);
    });
    $(document).on('click', ".table-element", function (e) {
        $(".table-element").removeClass("table-element-active");
        $(this).addClass("table-element-active");
    });


    $(document).on('click', "#bookmarks-pay-on-counter-button", function (e) {
        localStorage.setItem('quickqr_pay_via', 'pay_on_counter');
        $(this).removeClass('uncheck-button');
        $("#bookmarks-pay-online-button").addClass('uncheck-button');
        pay_via_change();
    });

    $(document).on('click', "#bookmarks-pay-online-button", function (e) {
        localStorage.setItem('quickqr_pay_via', 'pay_online');
        $(this).removeClass('uncheck-button');
        $("#bookmarks-pay-on-counter-button").addClass('uncheck-button');
        pay_via_change();
    });

    $(document).on('click', "#pay-on-counter-button", function (e) {
        localStorage.setItem('quickqr_pay_via', 'pay_on_counter');
        $(this).removeClass('uncheck-button');
        $("#pay-online-button").addClass('uncheck-button');
        $("#pay-online-button i").removeClass('icon-pay-online-white').addClass("icon-pay-online-gray");
        $("#pay-on-counter-button i").removeClass('icon-pay-on-counter-gray').addClass("icon-pay-on-counter-white");
        pay_via_change();
    });
    $(document).on('click', "#pay-online-button", function (e) {
        localStorage.setItem('quickqr_pay_via', 'pay_online');
        $(this).removeClass('uncheck-button');
        $("#pay-on-counter-button").addClass('uncheck-button');
        $("#pay-online-button i").removeClass('icon-pay-online-gray').addClass("icon-pay-online-white");
        $("#pay-on-counter-button i").removeClass('icon-pay-on-counter-white').addClass("icon-pay-on-counter-gray");
        pay_via_change();
    });
    $(document).on('click', "#process-next-order", function (e) {
        confirmNextOrder();
    });
    $(document).on('click', "#process-cancel-order", function (e) {
        $.magnificPopup.close();
    });
    $(document).on('click', "#send-data-to-form", function (e) {
        e.preventDefault();
        let action = $('#action-popup').val();
        switch (action) {
            case 'on-table-action':
                let $data = [];
                $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
                $data.push({ name: 'table', value: $('#table-number-field-2').val() });
                $data.push({ name: 'action', value: 'check_and_update_table' });
                $data.push({ name: 'table_confirm', value: RESTAURANT_TABLE_CONFIRM });
                $('#send-data-to-form').addClass('button-progress').prop('disabled', true);
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: $data,
                    dataType: 'json',
                    success: function (response) {
                        $('#send-data-to-form').removeClass('button-progress').prop('disabled', false);
                        if (response.success) {
                            localStorage.setItem('quickqr_id_customer', response.id_customer);
                            localStorage.setItem('quickqr_table', $('#table-number-field-2').val());
                            $('#table-number-field').val($('#table-number-field-2').val());
                            $('#form-error-2').slideUp();
                            disabledMenu(true);
                            if (RESTAURANT_TABLE_CONFIRM == 0) {
                                $(".add-item-button").show();
                                $.magnificPopup.close();
                                localStorage.setItem('status_order', 'using');
                            }
                            else {
                                $(".add-item-button").hide();
                                $('.your-action-content').slideUp();
                                $('.order-success-message').slideDown();
                                localStorage.setItem('status_order', 'waiting');
                            }
                        }
                        else {
                            $('#form-error-2').html(response.message).slideDown();
                        }
                    }
                });

                break;
            case 'delivery-action':
                $('#address-field').val($('#address-field-2').val());
                $('#bookmarks-address-field').val($('#address-field-2').val());
                if ($('#bookmarks-address-field').val()) {
                    let $is_delivery = false
                    let address = $('#address-field').val();
                    let zipcode = $("#zip-code-field").val();
                    let streetname = $("#street-name-field").val();
                    $is_delivery = getShippingFee($(this), address, zipcode, streetname);
                    if ($is_delivery) {
                        $(".add-item-button").show();
                        $.magnificPopup.close();
                    }
                }
                else {
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
                break;
            case 'menu-action':
                break;
            case "next-order-action":
                let table = $("#table-number-field-2").val();
                if (table.length === 0) {
                    $("#table-number-field-2").focus();
                }
                else {
                    $("#table-number-field").val($("#table-number-field-2").val());
                    $('#action-popup').val('on-table-action');
                    $("#order-button").click();
                    $.magnificPopup.close();
                }
                break;
            default:
                break;
        };


    });
    $(document).on('click', "#button-takeaway-time-to", function (e) {
        e.preventDefault();
    })
    $(document).on('click', ".reservation-food-action", function (e) {
        e.preventDefault();
        localStorage.setItem('quickqr_action', 'reservation-food-action');
        $('.edit_delivery').show();
        $data = [];
        $data.push({ name: 'action', value: 'check_user_login' });
        $data.push({ name: 'restaurant_id', value: $("#restaurant_id").val() });
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: $data,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    showReservationFood()
                }
                else {
                    showLoginForm();
                }
            }
        });
    });
    
    $(document).on('click', "#confirm_discount_code", function (e) {
        e.preventDefault();   
        let discount_code = $("#discount_code").val();
        let slug = $("#slug").val();
        let $btn = $(this);
        let $status = $("#form-error-coupon");
        let form_call_discount_code = localStorage.getItem("form_call_discount_code");
        let quickqr_action = localStorage.getItem('quickqr_action');
        let reserve_id = '';
        let date = '';
        
        if(quickqr_action == "reservation-food-action")
        {
            reserve_id = String(localStorage.getItem('quickqr_current_reserve_id'));
            let reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
            date =  reserve_data[reserve_id]['date_reserve'];
        }
        $data = [];
        if(discount_code.length == 0)
        {
        $status.removeClass('success').addClass('error').html('<p>' + LANG_PLEASE_ENTER_DISCOUNT_CODE + '</p>').slideDown();
        return;
        }
        $data.push({ name: 'action', value: 'checkDiscountCode' }); 
        $data.push({ name: 'discount_code', value: discount_code });
        $data.push({ name: 'date', value: date });
        $data.push({ name: 'reserve_id', value: reserve_id });
        $data.push({ name: 'quickqr_action', value: quickqr_action });
        $data.push({ name: 'slug', value: slug });
        $btn.addClass('button-progress').prop('disabled', true);
        $status.slideUp();
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: $data,
            dataType: 'json',
            success: function (response) {
                if (response.success) {   
                    localStorage.setItem('quickqr_discount_price', response.discount_price);      
                    localStorage.setItem('quickqr_discount_code', discount_code);   
                    $("#bookmarks_discount_price").html('-' + formatPrice(response.discount_price)); 
                    $("#bookmarks_discount_code").html(discount_code); 
                    $("#your_order_discount_code").html(discount_code);
                    $("#your_order_discount_price").html('-' + formatPrice(response.discount_price));
                    if(quickqr_action == "reservation-food-action")
                    {
                        let current_id = localStorage.getItem('quickqr_current_reserve_id');
                        let reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
                        reserve_data[current_id]['coupons_code'] = discount_code;
                        reserve_data[current_id]['include_total_discount_value'] = response.discount_price;
                        localStorage.setItem('quickqr_reserve', JSON.stringify(reserve_data));
                       generateViewReserveItem();
                    }
                    else
                    {
                        generateViewOrder("view-order-button");
                    }
                  
                    if(form_call_discount_code == "bookmarks")
                    {
                        $.magnificPopup.close();
                    }
                    else
                    {
                        $.magnificPopup.open({
                            items: {
                                src: '#your-order',
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
                }
                else {
                    $status.removeClass('success').addClass('error').html('<p>' + response.message + '</p>').slideDown();
                }
             
                $btn.removeClass('button-progress').prop('disabled', false);
            }
        });
    });
    
    $(document).on('click', ".your_order_user_discount_code_title", function (e) {
        e.preventDefault();   
        $data = [];
        $data.push({ name: 'action', value: 'check_user_login' });
        $data.push({ name: 'restaurant_id', value: $("#restaurant_id").val() });
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: $data,
            dataType: 'json',
            success: function (response) {
                $("#form-error-coupon").hide();
                $("#discount_code").val("");
                if (response.success) {
                    localStorage.setItem("form_call_discount_code","your_order");
                    $.magnificPopup.open({
                        items: {
                            src: '#CouponModal',
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
                else {
                    showLoginForm();
                }
            }
        });
    });

    $(document).on('click', ".user_discount_code_title", function (e) {
        e.preventDefault();   
        $data = [];
        $data.push({ name: 'action', value: 'check_user_login' });
        $data.push({ name: 'restaurant_id', value: $("#restaurant_id").val() });
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: $data,
            dataType: 'json',
            success: function (response) {
                localStorage.setItem("form_call_discount_code","bookmarks");
                $("#form-error-coupon").hide();
                $("#discount_code").val("");
                if (response.success) {
                    $.magnificPopup.open({
                        items: {
                            src: '#CouponModal',
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
                else {
                    showLoginForm();
                }
            }
        });
    });
    $(document).on('click', ".on-table-action", function (e) {
        e.preventDefault();
        let action = localStorage.getItem('quickqr_action');
        let table = localStorage.getItem('quickqr_table');
        let status = localStorage.getItem('status_order');
        if (action != "on-table-action" || table.length === 0) {
            removeLocalStore();
            localStorage.setItem('quickqr_action', 'on-table-action');
            $(".menu_title_popup_enter_data").html(LANG_PLEASE_ENTER_THE_TABLE_NUMBER);
            $(".div-left").css("width", "50%");
            $(".div-right").css("display", "block");
            $("#bookmarks-order-button").hide();
            checkWidthandSetViewOrderWrapper();
            $(".add-item-button").hide();
            $("#ordering-type").val("on-table").change();
            $('.order-total-shipping-fee').hide();
            $('.takeaway-time-to-group').hide();

            $('.bookmarks-name-group').hide();
            $('.bookmarks-table-number-field-group').show();
            $('.bookmarks-phone-number-field-group').hide();
            $('.bookmarks-address-field-group').hide();
            $('.bookmarks-email-field-group').hide();
            $('.bookmarks-house-number-field-group').hide();
            $('.bookmarks-street-name-field-group').hide();
            $('.bookmarks-city-field-group').hide();
            $('.bookmarks-zip-code-field-grroup').hide();

            $('#action-popup').val('on-table-action');
            $('#name-2').hide();
            $('#table-number-field-2').show();
            $('#phone-number-field-2').hide();
            $('#email-field-2').hide();
            $('#address-field-2').hide();
            $('#zip-code-field-2').hide();
            $('.your-action-content').slideDown();
            $('.order-success-message').slideUp();
            $.magnificPopup.open({
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
        }
        else if (table.length != 0 && status == "waiting") {
            $('.your-action-content').slideUp();
            $('.order-success-message').slideDown();
            $.magnificPopup.open({
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
        }
        else {
            $.magnificPopup.close();
        }

    })

    $(document).on('click', ".menu-action", function (e) {
        $(".add-item-button").hide();
        $('#action-popup').val('menu-action');
        removeLocalStore();
        localStorage.setItem('quickqr_action', 'menu-action');
        $("#bookmarks-order-button").hide();
        checkWidthandSetViewOrderWrapper();
        $.magnificPopup.close();
    })
    $(document).on('click', ".delivery-action", function (e) {
        e.preventDefault();
        $.magnificPopup.close();
        let pay_via = localStorage.getItem('quickqr_pay_via');

        $('#action-popup').val('delivery-action');
        $(".menu_title_popup_enter_data").html(LANG_PLEASE_ENTER);
        $("#ordering-type").val("delivery").change();
        $('.takeaway-time-to-group').show();
        $(".add-item-button").show();
        $('.order-total-shipping-fee').show();
        $('.cart-reservation').hide();
        $('.edit_delivery').hide();
        if (window.matchMedia('(max-width: 1200px)').matches) {
            $("#w30").css({ "width": "0%", "display": "none" })
            $("#w70").css("width", "100%")
        } else {
            $("#w30").css({ "width": "30%", "display": "block" })
            $("#w70").css("width", "70%")
        }
        $(".bookmarks_payment_methoad").animate({ "left": "100%", "opacity": "0" }, "slow");
        $(".bookmarks-cart-pay").animate({ "left": "100%", "opacity": "0" }, "slow")
        $(".bookmarks-cart-pay").hide()
        $('.bookmarks-your-order-content').animate({ "opacity": "1" }, "slow");
        $('.bookmarks-your-order-content').show();
        $('.cart-header-step-3').hide();
        $('.cart-header-step-1').show();
        $('.cart-header-step-2').hide();
        $('.cart-header-edit-address').hide();
        let $sPrice = $('.your-order-price-shipping-fee').html();
        if ($sPrice) {
            if (pay_via == 'pay_on_counter') {
                $('#submit-order-button-text').html(LANG_SEND_ORDER);
            } else if (pay_via == 'pay_online') {
                $('#submit-order-button-text').html(LANG_PAY_NOW);
            }
        }
        else {
            $('#submit-order-button-text').html(LANG_ORDER_FOR_A_FEE)
        }
        removeLocalStore();
        localStorage.setItem('quickqr_action', 'delivery-action');
        $(".min_total_orders_amount").html(formatPrice(MIN_TOTAL_AMOUNT_ONLINE_ORDER));
        $("#bookmarks-order-button").hide();
        $('.bookmarks-name-group').show();
        $('.bookmarks-table-number-field-group').hide();
        $('.bookmarks-phone-number-field-group').show();
        $('.bookmarks-address-field-group').show();
        $('.bookmarks-email-field-group').show();
        $('.bookmarks-house-number-field-group').show();
        $('.bookmarks-street-name-field-group').show();
        $('.bookmarks-zipcode-city-group').show();
        $('.cart-delivery-text').show();

        //  checkWidthandSetViewOrderWrapper();
        generateViewOrder('add-order-button');
        $(".div-left").css("width", "100%");
        $(".div-right").css("display", "none");
        $('#name-2').hide();
        $('#table-number-field-2').hide();
        $('#phone-number-field-2').hide();
        $('#email-field-2').hide();
        $('#address-field-2').show();
        $('#zip-code-field-2').hide();
        $(".bookmark-reserve-button-group").hide();
        $('.your-action-content').slideDown();
        $('.order-success-message').slideUp();
        $.magnificPopup.open({
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
    })
    $(document).on('click', ".takeaway-action", function (e) {
        e.preventDefault();
        $.magnificPopup.close();
        let pay_via = localStorage.getItem('quickqr_pay_via');
        $('.cart-reservation').hide();
        if (window.matchMedia('(max-width: 1200px)').matches) {
            $("#w30").css({ "width": "0%", "display": "none" })
            $("#w70").css("width", "100%")
        } else {
            $("#w30").css({ "width": "30%", "display": "block" })
            $("#w70").css("width", "70%")
        }
        $('.edit_delivery').hide();
        $(".bookmarks_payment_methoad").animate({ "left": "100%", "opacity": "0" }, "slow");
        $(".bookmarks-cart-pay").animate({ "left": "100%" }, "slow");
        $(".bookmarks-cart-pay").hide();
        $('.bookmarks-your-order-content').animate({ "opacity": "1" }, "slow");
        $('.bookmarks-your-order-content').show();
        $('#action-popup').val('takeaway-action');
        $(".menu_title_popup_enter_data").html(LANG_PLEASE_ENTER);
        $("#ordering-type").val("takeaway").change();
        $('.order-total-shipping-fee').hide();
        $(".add-item-button").show();
        $('.takeaway-delivery-time-group').show();
        if (pay_via == 'pay_on_counter') {
            $('#submit-order-button span').html(LANG_SEND_ORDER);
        } else if (pay_via == 'pay_online') {
            $('#submit-order-button span').html(LANG_PAY_NOW);
        }
        $('.bookmarks-name-group').show();
        $('.bookmarks-table-number-field-group').hide();
        $('.bookmarks-address-field-group').hide();
        $('.bookmarks-house-number-field-group').hide();
        $('.bookmarks-street-name-field-group').hide();
        $('.bookmarks-zipcode-city-group').hide();
        $('.bookmarks-phone-number-field-group').show();
        $('.bookmarks-email-field-group').show();
        $('.cart-delivery-text').hide();
        $('.cart-header-step-3').hide();
        $('.cart-header-step-1').show();
        $('.cart-header-step-2').hide();
        $('.cart-header-edit-address').hide();
        $(".bookmark-reserve-button-group").hide();
        $(".min_total_orders_amount").html(formatPrice(MIN_TOTAL_AMOUNT_ONLINE_ORDER));
        removeLocalStore();
        localStorage.setItem('quickqr_action', 'takeaway-action');
        $(".div-left").css("width", "100%");
        $(".div-right").css("display", "none");
        $("#bookmarks-order-button").hide();
        generateViewOrder('add-order-button');
    })
    $(document).on('click', '.open-datetimepicker', function (e) {
        e.preventDefault();
        localStorage.setItem('action_save_date_reservation','');
        openDateTimePicker();
    });
    function showSwalnotifi(title, type = "warning", confirmButtonText = "OK", confirmButtonColor = "var(--classic-color-1)", closeOnConfirm = false, closeOnCancel = false) {
        swal({
            title: '',
            text:title,
            type: type,
            showCancelButton: false,
            confirmButtonColor: confirmButtonColor,
            confirmButtonText: confirmButtonText,
            closeOnConfirm: closeOnConfirm,
            closeOnCancel: closeOnCancel,
            target: document.getElementById('body')
        },
            function (isConfirm) {
                if (isConfirm) {
                    swal.close();
                }
            });
    }
    function addDays(date, days) {
        var result = new Date(date);
        result.setDate(result.getDate() + days);
        return result;
    }
    $(document).on('click', ".reserve-item", function (e) {
        e.preventDefault();
        let id = $(this).data("reserve-id");
        let current_id = String(localStorage.getItem('quickqr_current_reserve_id'));
     
        if (current_id.slice(-4) == "-new") {
            showSwalnotifi(LANG_PLEASE_COMPLETE_YOUR_CURRENT_ORDER);
            return;
        }
        $(".reserve_post").removeClass("reserve_post_active");
        $(this).find(".reserve_post").addClass("reserve_post_active");

        let reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
        let reserve = reserve_data[id];
        let date = reserve.date;
        let time = reserve.time;
        let type = reserve.type;
        let bEdit = true;
        let date_reserve = reserve.date_reserve;   
        let is_disabled = reserve.is_disabled;
        let reserve_date = new Date(date_reserve);       
        let action_save_date_reservation = '';
        let today = new Date();
        let min_hour_edit = today.setHours(today.getHours() + MIN_HOUR_EDIT_PRE_ORDER);
        if (min_hour_edit > reserve_date.getTime()) {
            bEdit = false;
            localStorage.setItem('current_reserve_edit',0);
            $('.add-item-button').hide();

        }
        else
        {
            localStorage.setItem('current_reserve_edit',1);
            action_save_date_reservation = 'edit_date_reserve';  
            $('.add-item-button').show();
        }
        localStorage.setItem('action_save_date_reservation',action_save_date_reservation);
        if (id == current_id && bEdit) {
            setDatetimepicker(reserve_date);
            openDateTimePicker();
            return;
        }
      //  console.log(localStorage.getItem('action_save_date_reservation'));
        if(bEdit)
        {
            setDatetimepicker(reserve_date);
            openDateTimePicker();
        }
        //get list reserve item from serve
        let $data = [];
        $data.push({ name: 'action', value: 'getReserveItemData' });
        $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
        $data.push({ name: 'id', value: id });
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: $data,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    localStorage.setItem('quickqr_reserve_item', '{}')
                    let reserve_item_data = JSON.parse(localStorage.getItem('quickqr_reserve_item'));
                    let reserve_data_response = JSON.parse(response.data)
                    for (var i in reserve_data_response) {
                        let reserve = reserve_data_response[i];
                        let extra_data = JSON.parse(reserve.extras);
                        let id = reserve.id;
                        let item_id = reserve.item_id;
                        let name = reserve.name;
                        let quantity = reserve.quantity;
                        let amount_reduced = reserve.amount_reduced;
                        let amount = reserve.amount;
                        let price = Number(reserve.total_amount);
                        let deleted = reserve.deleted;
                        var extras = {};
                        for (var j in extra_data) {
                            let extra = extra_data[j];
                            let extra_id = extra.id;
                            let extra_deleted = extra.deleted;
                            extras[j] = {
                                'id': extra_id,
                                'extra_id': extra.extra_id,
                                'name': extra.name,
                                'price': extra.price,
                                'deleted': extra_deleted
                            };
                            price = price + (Number(quantity) * Number(extra.price))
                        }
                        let item_data = {
                            'id': id,
                            'item_id': item_id,
                            'order_price': price,
                            'item_name': name,
                            'item_price': amount,
                            'extras': extras,
                            'amount_reduced': amount_reduced,
                            'quantity': quantity,
                            'deleted': deleted
                        };
                        reserve_item_data[i] = item_data;
                    }
                    localStorage.setItem('quickqr_reserve_item', JSON.stringify(reserve_item_data));//
                    localStorage.setItem('quickqr_current_reserve_id', id);
                    generateViewReserveItem()
                    let current_reserve_edit = localStorage.getItem('current_reserve_edit');
                    if (type == "delivery") {
                        if(current_reserve_edit == "0")
                        {
                            $('.edit_delivery').hide();
                        }
                        else
                        {
                            $('.edit_delivery').show();
                        }
                        $('.bookmark-delivery-button').removeClass('bookmarks-uncheck-button');
                        $('.bookmark-takeaway-button').addClass('bookmarks-uncheck-button');
                    }
                    else {
                        $('.edit_delivery').hide();
                        $('.bookmark-takeaway-button').removeClass('bookmarks-uncheck-button');
                        $('.bookmark-delivery-button').addClass('bookmarks-uncheck-button');
                    }
                    if (is_disabled == "0") {
                        $('.bookmarks-on-button').removeClass('bookmarks-uncheck-button');
                        $('.bookmarks-off-button').addClass('bookmarks-uncheck-button');
                    }
                    else {
                        $('.bookmarks-off-button').removeClass('bookmarks-uncheck-button');
                        $('.bookmarks-on-button').addClass('bookmarks-uncheck-button');
                    }
                  
                }
                else {
                    showSwalnotifi(response.message)
                }
            }

        });
        //end get
        $(".reservation-date-value").html(date).parents().show();
        $(".reservation-time-value").html(time).parents().show();
        $('.date-notifi').hide();
    
    });
    $(document).on('click', ".bookmarks-off-button", function (e) {
        let current_id = String(localStorage.getItem('quickqr_current_reserve_id'));
        let reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
        let is_disable = reserve_data[current_id]['is_disabled'];
        if (is_disable == "1") {
            return;
        }
        if (current_id.slice(-4) == "-new") {
            $(this).removeClass('bookmarks-uncheck-button');
            $('.bookmarks-on-button').addClass('bookmarks-uncheck-button');
            setIsDisableReserve(1);
        }
        else {
            saveIsDisableReserve(1);
        }
    })
    $(document).on('click', ".bookmarks-on-button", function (e) {
        let current_id = String(localStorage.getItem('quickqr_current_reserve_id'));
        let reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
        let is_disable = reserve_data[current_id]['is_disabled'];
        if (is_disable == "0") {
            return;
        }
        if (current_id.slice(-4) == "-new") {
            $(this).removeClass('bookmarks-uncheck-button');
            $('.bookmarks-off-button').addClass('bookmarks-uncheck-button');
            setIsDisableReserve(0)
        }
        else {
            saveIsDisableReserve(0);
        }
    })
    $(document).on('click', ".bookmark-delivery-button", function (e) {
        $(this).removeClass('bookmarks-uncheck-button');
        $('.bookmark-takeaway-button').addClass('bookmarks-uncheck-button');
        setTypeReserve('delivery');
        generateViewReserveItem();
    })
    $(document).on('click', ".bookmark-takeaway-button", function (e) {
        $(this).removeClass('bookmarks-uncheck-button');
        $('.bookmark-delivery-button').addClass('bookmarks-uncheck-button');
        setTypeReserve('takeaway');
        generateViewReserveItem();
    })

    function setTypeReserve(type) {
        let current_id = localStorage.getItem('quickqr_current_reserve_id');
        var reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
        reserve_data[current_id]['type'] = type;
        if(type == "takeaway")
        {
            $('.edit_delivery').hide();
        }
        else
        {
            $('.edit_delivery').show();
        }
        if(current_id.slice(-4)=="-new")
        {
            reserve_data[current_id]['shipping_fee'] = localStorage.getItem('quickqr_shipping_fee');
        }    
        localStorage.setItem('quickqr_reserve', JSON.stringify(reserve_data));
    }

    function saveIsDisableReserve(is_disable) {
        let current_id = localStorage.getItem('quickqr_current_reserve_id');
        let reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
        swal({
            title: '',
            text:LANG_ARE_YOU_SURE,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "var(--classic-color-1)",
            confirmButtonText: "OK",
            cancelButtonText: LANG_CANCEL,
            closeOnConfirm: false,
            closeOnCancel: false
        },
            function (isConfirm) {
                if (isConfirm) {
                    let $data = [];
                    $data.push({ name: 'action', value: 'EditIsDisableReserve' });
                    $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
                    $data.push({ name: 'reserve_id', value: current_id });
                    $data.push({ name: 'is_disable', value: is_disable });
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: $data,
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                reserve_data[current_id]['is_disabled'] = is_disable;
                                localStorage.setItem('quickqr_reserve', JSON.stringify(reserve_data));
                                localStorage.setItem('quickqr_current_reserve_id', '');
                                localStorage.setItem('quickqr_reserve_item', '{}');
                                $('.reservation-time').hide();
                                $('.date-reservation').hide();
                                $('.date-notifi').show();
                                generateViewReserve();
                                generateViewReserveItem();
                                swal.close();
                            }
                        }
                    });
                }
                else {
                    swal.close();
                    return false;
                }
            });

    }

    function setIsDisableReserve(is_disable) {
        let current_id = localStorage.getItem('quickqr_current_reserve_id');
        let reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
        reserve_data[current_id]['is_disabled'] = is_disable;
        localStorage.setItem('quickqr_reserve', JSON.stringify(reserve_data));
    }
    $(document).on('click', ".edit_delivery", function (e) {
        e.preventDefault();
    
        $('.bookmarks-your-order-content').animate({ "opacity": "0" }, "slow");
        $('.bookmarks-your-order-content').hide();
        $('.bookmarks-cart-pay').show();
        $(".bookmarks-cart-pay").animate({ "right": "0", "left": "0", "opacity": "1" }, "slow")
        $('.cart-header-step-3').hide();
        $('.cart-header-step-1').hide();
        $('.cart-header-step-2').hide();
        $('.cart-header-edit-address').show();
        $(".add-item-button").hide();
        $(".cart-reservation").hide();

        $('.bookmarks-name-group').show();
        $('.bookmarks-table-number-field-group').hide();
        $('.bookmarks-phone-number-field-group').show();
        $('.bookmarks-address-field-group').show();
        $('.bookmarks-email-field-group').show();
        $('.bookmarks-house-number-field-group').show();
        $('.bookmarks-street-name-field-group').show();
        $('.bookmarks-zipcode-city-group').show();
        $('.takeaway-delivery-time-group').hide();
        $('.cart-delivery-text').show();

        $('#bookmarks-save-address').css('display', 'flex');
        $('#bookmarks-order-button-step-3').css('display', 'none');
        let height = $(".bookmarks-your-order-content").height() + $(".cart-header").height() + 520;
        $(".bookmarks").css('height', height + 'px');
    })
    $(document).on('click', "#bookmarks-reserve-button", function (e) {
        e.preventDefault();
        //check field valid
        $("#bookmarks-reserve-button").addClass('button-progress').prop('disabled', true);
        let name = $('#bookmarks-name');
        let phone = $('#bookmarks-phone-number-field');
        let zip_code = $('#bookmarks-zip-code-field');
        let address = $('#bookmarks-address-field');
        let house_number = $('#bookmarks-house-number-field');
        let street_name = $('#bookmarks-street-name-field');
        let city = $('#bookmarks-city-field');
        let email = $('#bookmarks-email-field');
        let bInvalidEmail = true;
        let bInvalidPhone = true;
        let bInvalidCity = true;
        let bInvalidZipcode = true;
        let bInvalidHouseNumber = true;
        let bInvalidStreetName = true;
        let bInvalidAddress = true;
        let bInvalidName = true;
        let bDelivery = true;
        bInvalidEmail = checkElementInvalid(email, true);
        bInvalidPhone = checkElementInvalid(phone, false, true);
        bInvalidName = checkElementInvalid(name);
        let current_id = localStorage.getItem('quickqr_current_reserve_id');
        var reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
        let type = reserve_data[current_id]['type'];
        if (type == "delivery") {
            bInvalidCity = checkElementInvalid(city);
            bInvalidZipcode = checkElementInvalid(zip_code);
            bInvalidHouseNumber = checkElementInvalid(house_number);
            bInvalidStreetName = checkElementInvalid(street_name);
            bInvalidAddress = checkElementInvalid(address);
        }
        if (bInvalidEmail && bInvalidPhone && bInvalidCity && bInvalidZipcode && bInvalidHouseNumber && bInvalidStreetName && bInvalidAddress && bInvalidName) {
            if (type == "delivery") {
                $data = [];
                $data.push({ name: 'action', value: 'getShippingFee' });
                $data.push({ name: 'address', value: $("#bookmarks-address-field").val() });
                $data.push({ name: 'zip_code', value: $("#bookmarks-zip-code-field").val() });
                $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
                $data.push({ name: 'route', value: $("#bookmarks-street-name-field").val() });
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: $data,
                    dataType: 'json',
                    success: function (response) {
                        $("#bookmarks-reserve-button").removeClass('button-progress').prop('disabled', false);
                        if (response.success) {                
                            bookmarksSendReserveForm();
                        }
                        else
                        {
                            showSwalnotifi(response.message);
                            return false;
                        }
                    }
                });
            }
            else
            {
                $("#bookmarks-reserve-button").removeClass('button-progress').prop('disabled', false);
                bookmarksSendReserveForm();
            }
       
          
        }
        else {
            $("#bookmarks-reserve-button").removeClass('button-progress').prop('disabled', false);
            showSwalnotifi(LANG_PLEASE_FULLY_UPDATE_THE_INFORMATION);
            return false;
        }
    });
    $(document).on('click', "#save_date_reservation", function (e) {
        e.preventDefault();
        let date_reserve = $("#date_reservation").val();
	    let time_reserve = $("#time_reservation").val();
        let restaurant_id = $("#restaurant_id").val();
        let datetime_value = date_reserve + "T" + time_reserve + ":00";
        if (!date_reserve || !time_reserve) {
            $.magnificPopup.close();
            swal({
                title: '',
                text: LANG_PLEASE_SELECT_A_DATE_AND_TIME_TO_RESERVE,
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
                        openDateTimePicker();
                    }
                });
        }
        else {
            $data = [];
            $data.push({ name: 'action', value: 'checkOpenHourRestaurant' });
            $data.push({ name: 'datetime', value: datetime_value });
            $data.push({ name: 'restaurant_id', value: restaurant_id });      
           $("#save_date_reservation").addClass('button-progress').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: $data,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        datetime_value = new Date(datetime_value)
                        let action_save_date_reservation = localStorage.getItem('action_save_date_reservation');
                        let current_id = String(localStorage.getItem('quickqr_current_reserve_id'));
                        let reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
                        let now = new Date();
                        let today = new Date();
                        let min_hour_edit = today.setHours(today.getHours() + MIN_HOUR_EDIT_PRE_ORDER);
                        let date = ("0" + datetime_value.getDate()).slice(-2);
                        let year = datetime_value.getFullYear();
                        let month = ("0" + (datetime_value.getMonth() + 1)).slice(-2);
                        let hours = ("0" + datetime_value.getHours()).slice(-2)
                        let minutes = ("0" + datetime_value.getMinutes()).slice(-2);
                        let stime = hours + ':' + minutes
                        let sdatetime = date + '.' + month + '.' + year + ' ' + stime;
                        let date_add_14_day = addDays(now, 14)
                        
                            if (min_hour_edit > datetime_value.getTime() || date_add_14_day.getTime() < datetime_value.getTime()) {
                                $.magnificPopup.close();
                                swal({
                                    title: '',
                                    text: LANG_ERROR_TIME,
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
                                            openDateTimePicker();
                                        }
                                    });
                            }
                            else {
                                //check exist
                                let bExist = false;
                                $('#bookmarks-reservations-content').find('.reserve-item').each(function () {
                                    let id_reserve_current = $(this).data('reserve-id');
                                    let sdate = $(this).find('.reserve_date').html();
                                    if(current_id != id_reserve_current || action_save_date_reservation.length === 0)
                                    {
                                        if (sdate == sdatetime) {
                                            bExist = true;
                                        }
                                    }                     
                                   
                                });
                                if (bExist) {
                                    $.magnificPopup.close();
                                    swal({
                                        title: '',
                                        text: LANG_TIME_HAS_EXISTED,
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
                                                openDateTimePicker();
                                            }
                                        });
                                }
                                else {  
                                    let id = new Date().getTime() + '-new';
                                    if(action_save_date_reservation == "edit_date_reserve")
                                    {
                                        id = current_id;
                                    }
                                    let reserve_item_data = {
                                        'id': id,
                                        'date_reserve': date_reserve + " " + time_reserve + ":00",
                                        'is_disabled': 0,
                                        'date': date + '.' + month + '.' + year,
                                        'time': stime,
                                        'type': 'delivery',
                                        'shipping_fee': localStorage.getItem('quickqr_shipping_fee'),
                                        'address' : $('#bookmarks-address-field').val()
                                    };
            
                                    if(action_save_date_reservation == "edit_date_reserve")
                                    {
                                      //  reserve_data[current_id] = reserve_item_data;
                                         generateViewReserveItem()
                                    }
                                    else
                                    {
                                      if(current_id.length === 0)
                                      {
                                        reserve_data[id] = reserve_item_data;
                                        localStorage.setItem('quickqr_reserve_item', '{}')
                                        generateViewReserveItem()                           
                                      }
                                       else if (current_id.slice(-4) == "-new") {
                                            delete reserve_data[current_id];
                                            reserve_data[id] = reserve_item_data;
                                        
                                        }
                                        else {
                                            reserve_data[id] = reserve_item_data;
                                            localStorage.setItem('quickqr_reserve_item', '{}')
                                            generateViewReserveItem()
                                        }  
                                    }  
                                                                
                                    localStorage.setItem('current_reserve_edit', 1);
                                    localStorage.setItem('quickqr_current_reserve_id', id);
                                    localStorage.setItem('quickqr_reserve', JSON.stringify(reserve_data));
                                    if(action_save_date_reservation != "edit_date_reserve")
                                    {
                                        generateViewReserve();
                                        $('.bookmark-delivery-button').removeClass('bookmarks-uncheck-button');
                                        $('.bookmark-takeaway-button').addClass('bookmarks-uncheck-button');
                                    } 
                                    $(".reservation-date-value").html(date + '.' + month + '.' + year).parents().show();
                                    $(".reservation-time-value").html(hours + ':' + minutes).parents().show();
                                    $('.date-notifi').hide();         
                                    // $('.bookmarks-on-button').removeClass('bookmarks-uncheck-button');
                                    // $('.bookmarks-off-button').addClass('bookmarks-uncheck-button');
                                    $('.bookmark-delivery-button').prop('disabled', false);
                                    $('.bookmark-takeaway-button').prop('disabled', false);
                                    $('#bookmarks-reserve-button').show();
                                    $('.edit_delivery').show();
                                    $('.add-item-button').show();
                                    $.magnificPopup.close();
                                }
                            }
                    }
                    else {
                        showSwalnotifi(response.message);
                    }
                }
            });
            $("#save_date_reservation").removeClass('button-progress').prop('disabled', false);    
        }
    })
    $(document).on('click', ".reservations-action", function (e) {
        e.preventDefault();
        $("#register_table").prop('disabled', true);
        $('.booking-form').slideDown();
        $('.order-success-message').slideUp();
        $("#bookmarks-order-button").hide();
        checkWidthandSetViewOrderWrapper();
        $.magnificPopup.open({
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


    $("#button_menu").on("click", function () {
        $.magnificPopup.open({
            items: {
                src: '#FunctionModal',
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


    // $(".login-form").on('submit', function (e) {
    //     e.stopPropagation();
    //     e.preventDefault();
    //     var $form = $(this),
    //         form_data = $form.serializeArray(),
    //         $btn = $form.find('button'),
    //         $btn = $form.find('button'),
    //         $form_error = $form.find('.form-error'),
    //         $data = $form.serializeArray();
    //     $data.push({ name: 'action', value: 'user_login' });
    //     $form_error.slideUp();
    //     $btn.addClass('button-progress').prop('disabled', true);
    //     $.ajax({
    //         type: "POST",
    //         url: ajaxurl,
    //         data: form_data,
    //         dataType: 'json',
    //         success: function (response) {
    //             if (response.success) {

    //                 $status.slideUp();
    //                 $('.allegie-' + id).find('.allegie-display-name').html($form.find('.allegie-aliases').val() + '. ' + $form.find('.alle_name').val());
    //                 Snackbar.show({
    //                     text: response.message,
    //                     pos: 'bottom-center',
    //                     showAction: false,
    //                     actionText: "Dismiss",
    //                     duration: 3000,
    //                     textColor: '#fff',
    //                     backgroundColor: '#383838'
    //                 });
    //             }
    //             else {
    //                 $status.removeClass('success').addClass('error').html('<p>' + response.message + '</p>').slideDown();
    //             }
    //             $btn.removeClass('button-progress').prop('disabled', false);
    //         }
    //     });
    //     return false;
    // });

    /* Check if the order paid */
    let current_url = new URL(window.location.href);

    if (current_url.searchParams.get('return') == 'success') {

        swal({
            title: LANG_SENT_SUCCESSFULLY,
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "var(--classic-color-1)",
            confirmButtonText: LANG_COMPLETE,
            closeOnConfirm: false,
            closeOnCancel: false
        },
            function (isConfirm) {
                if (isConfirm) {
                    disabledMenu(false);
                    swal.close();
                    if ($("#FunctionModal")[0]) {
                        $.magnificPopup.open({
                            items: {
                                src: '#FunctionModal',
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
                }
            });
        current_url.searchParams.delete('return');
    }

    if (current_url.searchParams.get('payment_status') == 'cancel') {

        swal({
            title: LANG_PAYMENT_FAILLED,
            type: "warning",
            showCancelButton: false,
            confirmButtonColor: "var(--classic-color-1)",
            confirmButtonText: 'OK',
            closeOnConfirm: false,
            closeOnCancel: false
        },
            function (isConfirm) {
                if (isConfirm) {
                    swal.close();
                }
            });

        current_url.searchParams.delete('payment_status');
    }

    if (typeof RESTAURANT_MENU_REDUCED !== 'undefined') {
        if (RESTAURANT_MENU_REDUCED == "1") {
            if (MENU_DISCOUNT_COUNT == "1") {
                $('.boxed-list:not([data-category-image*="show-our-actions"]').addClass("gallery-hidden");
                $('.boxed-list[data-category-image*="show-our-actions"]').removeClass("gallery-hidden");
            }
            else {
                $('.filter-gallery .filter-button[data-number="0"]').addClass('active');
                $('.boxed-list:not([data-category-count="0"]').addClass("gallery-hidden");
                $('.boxed-list[data-category-count="0"]').removeClass("gallery-hidden");
            }
        }
        else {
            $('.filter-gallery .filter-button[data-number="0"]').addClass('active');
            $('.boxed-list:not([data-category-count="0"]').addClass("gallery-hidden");
            $('.boxed-list[data-category-count="0"]').removeClass("gallery-hidden");
        }
    }

    /* GALLERY - FILTERING FUCTION */
    $(".filter-button").on("click", function () {
        var value = $(this).data('filter');

        if (value == "gallery-show-all") {
            $('.boxed-list').removeClass("gallery-hidden");
        }
        else if (value == "gallery-show-our-actions") {
            $('.boxed-list:not([data-category-image*="show-our-actions"]').addClass("gallery-hidden");
            $('.boxed-list[data-category-image*="show-our-actions"]').removeClass("gallery-hidden");
        }
        else {
            $('.boxed-list:not([data-category-image="' + value + '"]').addClass("gallery-hidden");
            $('.boxed-list[data-category-image="' + value + '"]').removeClass("gallery-hidden");
        }
    });

    $('.filter-gallery .filter-button').on("click", function () {
        $('.filter-gallery').find('.filter-button.active').removeClass('active');
        $(this).addClass('active');
    });

    $(".menu-filter").on("click", function (e) {
        e.preventDefault();
        $('.menu-filter.active').removeClass('active');
        $(this).addClass('active');
        var $container = $(this).closest('.boxed-list');
        if ($(this).data('filter') == 'grid') {
            $container.find('.menu-grid-view').show();
            $container.find('.menu-list-view').hide();
        } else {
            $container.find('.menu-list-view').show();
            $container.find('.menu-grid-view').hide();
        }
    });

    function getTotalSumOrder(minusShippingFee = true) {
        var order_total = 0;
        var order_data = JSON.parse(localStorage.getItem('quickqr_order'));
        let action = localStorage.getItem('quickqr_action');
        console.log(action);
        if (action == "reservation-food-action") {
            order_data = JSON.parse(localStorage.getItem('quickqr_reserve_item'));
            for (var i in order_data) {
                if (order_data.hasOwnProperty(i)) {
                    var order = order_data[i],
                        price = Number(order.item_price),
                        quantity = Number(order.quantity),
                        deleted = order.deleted,
                        extras = order.extras,
                        extra_total = 0;
                  
                    for (var j in extras) {
                        if (extras.hasOwnProperty(j)) {
                            var extra = extras[j],
                                extra_deleted = extra.deleted,
                                extra_price = Number(extra.price);
                                console.log(extra_deleted);
                                if(extra_deleted == "0")
                                {
                                    extra_total += extra_price;
                                }
                        
                        }
                    }
                    var this_item_total = (extra_total + price) * quantity;
                    if(deleted == "0")
                    {
                        order_total += this_item_total;
                    }            
                }
            }
        }
        else
        {
            for (var i in order_data) {
                if (order_data.hasOwnProperty(i)) {
                    var order = order_data[i],
                        price = Number(order.item_price),
                        quantity = Number(order.quantity),
                        extras = order.extras,
                        extra_total = 0;
                    for (var j in extras) {
                        if (extras.hasOwnProperty(j)) {
                            var extra = extras[j],
                                extra_price = Number(extra.price);
                            extra_total += extra_price;
                        }
                    }
                    var this_item_total = (extra_total + price) * quantity;
                    order_total += this_item_total;
                }
            }
        }
   

        let dDiscountPrice = 0;
        let quickqr_discount_price = localStorage.getItem('quickqr_discount_price');
      
        if (minusShippingFee) {
            if (action == 'delivery-action') {
                let shipping_fee = localStorage.getItem('quickqr_shipping_fee');
                if (shipping_fee.length != 0) {
                    order_total = getTotalSumOrderAndShippingFee();
                }
            }
        }
        if(quickqr_discount_price != '')
        {
         dDiscountPrice = Number(quickqr_discount_price); 
         order_total = order_total - dDiscountPrice;
         if(order_total < 0)
         {
            order_total = 0;   
         }
        }
        if (action == "reservation-food-action") {
            let current_id = localStorage.getItem('quickqr_current_reserve_id');
            let reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
            if (reserve_data[current_id]) {
                let type = reserve_data[current_id]['type'];
                if (type == "delivery") {
                    var shipping_fee = reserve_data[current_id]['shipping_fee'];
                    if (shipping_fee != null && shipping_fee.length != 0) {
                        $('.cart-delivery-text').show();
                        $('.cart-delivery-text span').html(formatPrice(shipping_fee));
                        order_total += Number(shipping_fee);
                    }
                }
                else {
                    $('.cart-delivery-text').hide();
                }
            }
        }
        if(order_total < 0)
         {
             order_total = 0;
         }
        $('#view-order-total-price').html(formatPrice(order_total));
        console.log(order_total);
        return order_total;
    }

    function getTotalSumOrderAndShippingFee() {
        var order_data = JSON.parse(localStorage.getItem('quickqr_order'));
        let action = localStorage.getItem('quickqr_action');
        if (action == "reservation-food-action") {
            order_data = JSON.parse(localStorage.getItem('quickqr_reserve_item'));
        }
        var shipping_fee = localStorage.getItem('quickqr_shipping_fee');
        var order_total = 0;
        if (shipping_fee.length != 0) {
            shipping_fee = Number(localStorage.getItem('quickqr_shipping_fee'));

            if (action == "reservation-food-action") {
                for (var i in order_data) {
                    if (order_data.hasOwnProperty(i)) {
                        var order = order_data[i],
                            price = Number(order.item_price),
                            quantity = Number(order.quantity),
                            extras = order.extras,
                            deleted = order.deleted,
                            extra_total = 0;
                        for (var j in extras) {
                            if (extras.hasOwnProperty(j)) {
                                var extra = extras[j],
                                    extra_deleted = extra.deleted,
                                    extra_price = Number(extra.price); 
                                    if(extra_deleted == "0") 
                                    {
                                        extra_total += extra_price;
                                    }               
                            }
                        }
                        var this_item_total = (extra_total + price) * quantity;
                        if(deleted == "0")
                        {
                            order_total += this_item_total;
                        }         
                    }
                }
            }
            else
            {
                for (var i in order_data) {
                    if (order_data.hasOwnProperty(i)) {
                        var order = order_data[i],
                            price = Number(order.item_price),
                            quantity = Number(order.quantity),
                            extras = order.extras,
                            extra_total = 0;
                        for (var j in extras) {
                            if (extras.hasOwnProperty(j)) {
                                var extra = extras[j],
                                    extra_price = Number(extra.price);      
                                    extra_total += extra_price;     
                            }
                        }
                        var this_item_total = (extra_total + price) * quantity;
                        
                        order_total += this_item_total;
                    }
                }
            }
         
            order_total += shipping_fee;
            $('.your-shipping-fee').html(formatPrice(shipping_fee));
            $('.your-order-price-shipping-fee').html(formatPrice(order_total));
            $('.bookmarks-your-shipping-fee').html(formatPrice(shipping_fee));
            $('.bookmarks-your-order-price-shipping-fee').html(formatPrice(order_total));
        }
        return order_total;
    }
    function showLoginForm() {
        $.magnificPopup.open({
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
    $(document).on('click', ".bookmarks-cart-pay-login", function (e) {
        e.preventDefault();
        showLoginForm();
    });

    $(document).on('click', ".button-login", function (e) {
        e.preventDefault();
        showLoginForm();
    });

    $(document).on('click', "#booking-table", function (e) {
        e.preventDefault();
        $("#register_date").val('');
        $("#register_time_from").val('');
        $("#register_time_to").val('');
        $("#register_table").prop('disabled', true);
        $('.booking-form').slideDown();
        $('.order-success-message').slideUp();
        $.magnificPopup.open({
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
    function ShowRegisterForm() {
        $.magnificPopup.open({
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
    $(document).on('click', ".bookmarks-cart-pay-register", function (e) {
        e.preventDefault();
        ShowRegisterForm();
    });
    $(document).on('click', ".button-signup", function (e) {
        e.preventDefault();
        ShowRegisterForm();
    });
    $(document).on('click', ".button-register", function (e) {
        e.preventDefault();
        ShowRegisterForm();
    });
   

    $(document).on('click', ".button-forgot-password", function (e) {
        e.preventDefault();
        $('.forgot-form').slideDown();
        $('.order-success-message').slideUp();
        $.magnificPopup.open({
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

function loadsvg(){
    jQuery('img.svg-restaurant-menu').each(function(){
        var $img = jQuery(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');
    
        jQuery.get(imgURL, function(data) {
            // Get the SVG tag, ignore the rest
            var $svg = jQuery(data).find('svg');
    
            // Add replaced image's ID to the new SVG
            if(typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            // Add replaced image's classes to the new SVG
            if(typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass+' replaced-svg');
            }
    
            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns');
            $svg = $svg.removeAttr('xmlns:xlink');
    
            // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
            if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
                $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
            }
    
            // Replace image with new SVG
            $img.replaceWith($svg);
    
        }, 'xml');
    
    });
}


$(document).on('click', ".info-item-button", function (e) {
    e.preventDefault();
    
    var $item = $(this).closest('.ajax-item-listing'),
        item_id = $item.data('id'),
        name = $item.data('name'),
        description = $item.data('description'),
        price = $item.data('price'),
        amount = $item.data('amount'),
        amount_reduced = $item.data('amount-reduced'),
        order_price = Number(amount);

       // properties
       var sproperties = $item.data('properties') + "";    
       var properties_tpl = "";
       if(sproperties)
       {
       var arr_properties = sproperties.split("#");
       properties_tpl = '<h4>'+ LANG_PROPERTIES +'</h4> <ul>';
           jQuery.each(arr_properties, function (index, item) {
               let a = item.split("|"); 
               let name = a[1];
               let image = a[2];
               let img_properties = '';
               if(image)
               {
                img_properties = '<img class="svg svg-restaurant-menu" src="'+ siteurl + 'storage/icon-food/' + image +  '"/>'
               }
               properties_tpl = properties_tpl + '<li>' + img_properties + '<span>'+ name +'</span></li>';
   
           });
       }


var sadditives = $item.data('additives') + "";    
    var additives_tpl = "";
  
    if(sadditives)
    {
    var arr_additives = sadditives.split("#");
    additives_tpl = '<h4>'+ LANG_ADDITIVES +'</h4> <ul>';
        jQuery.each(arr_additives, function (index, item) {
            let a = item.split("|"); 
            let aliases = a[0];           
            additives_tpl = additives_tpl + '<li>' + aliases + '</li>';  
        });
    }      
    var sallegie = $item.data('allegie') + "";    
    var allegie_tpl = "";
    if(sallegie)
    {
    var arr_allegie = sallegie.split("#");
    //console.log(sallegie);
     allegie_tpl = '<h4>' + LANG_ALLEGIE + '</h4> <ul>';
        jQuery.each(arr_allegie, function (index, item) {
            let a = item.split("|"); 
            let name = a[1];
            let image = a[2];
            let img_allegie = '';
            if(image)
            {
                img_allegie = '<img class="svg svg-restaurant-menu" src="'+ siteurl + 'storage/icon-food/' + image +  '"/>'
            }
            allegie_tpl = allegie_tpl + '<li>' + img_allegie + '<span>'+ name +'</span></li>';

        });
    }    
    $('#add-extras .menu_title2').html(name);
    $('#add-extras .menu_title').html(name);
    $('#add-extras .menu_desc').html(description);
    $('#add-extras .menu_price').html(price);    
    $('#Allegie_detail').html(allegie_tpl + additives_tpl + properties_tpl);       
    $('#Allegie_detail').css("display", "block");
    $('.menu-data').css("display","none");
    loadsvg();

    $('#order-price').html(formatPrice(amount));
    $('#menu-order-quantity').val(1);

    var $extra_wrapper = $('#menu-extra-items');
    $extra_wrapper.html('');
    var extras = TOTAL_MENUS[item_id].extras || [];

    var $menu_extra_option_wrapper = $('#menu-extra-option-items');
    $menu_extra_option_wrapper.html('');
     var extras_option = TOTAL_MENUS[item_id].extras_option || [];
     
         if (extras_option.length == 0) {
        $('#add-extras .menu_dots').show();
        $('#add-extras .menu_price').show();
        $('#add-extras .menu_price').html(price); 
        $('.menu-extra-option-wrapper').hide();
    } else {
        order_price = 0;
        $('#add-extras .menu_price').hide();
        $('#add-extras .menu_dots').hide();
        $('.menu-extra-option-wrapper').show();
    }
    for (var i in extras_option) {
        if (extras_option.hasOwnProperty(i)) {
               var $extra_option_tpl = $(
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
                        $extra_option_tpl.find('.extra-item-price').html(formatPrice(extras_option[i].price));
                        $extra_option_tpl.data('price', extras_option[i].price);
                        $extra_option_tpl.data('id', extras_option[i].id);
                        $extra_option_tpl.find('.radio input').on('change', function () {
                            calculateOrderPrice(order_price);
                        });
                        $menu_extra_option_wrapper.append($extra_option_tpl);       
        }
    }
    var min_extra_option_price = '';
    $('.menu-extra-option-item').each(function () {
        var price = Number($(this).data('price'));
        if(min_extra_option_price == '')
        {
            min_extra_option_price = price;
        }
   if(min_extra_option_price >= price)
   {
    min_extra_option_price = price;
    $(this).find('.radio input').attr('checked', true);
   }
    });

    if (extras.length == 0) {
        $('.menu-extra-wrapper').hide();
    } else {
        $('.menu-extra-wrapper').show();
    }
    for (var i in extras) {
        if (extras.hasOwnProperty(i)) {
            var $extra_tpl = $(
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
            $extra_tpl.find('.extra-item-price').html(formatPrice(extras[i].price));
            $extra_tpl.data('price', extras[i].price);
            $extra_tpl.data('id', extras[i].id);

            $extra_tpl.find('.checkbox input').on('change', function () {
                // $('#menu-order-quantity').val(1);
                calculateOrderPrice(order_price);
            });
            $extra_wrapper.append($extra_tpl);
        }
    }

    $.magnificPopup.open({
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



    /*
    * Add Order and Extras
    */
    $(document).on('click', ".add-extras", function (e) {
        e.preventDefault();
        let action = localStorage.getItem('quickqr_action');
        if (action == "reservation-food-action") {
            let current_id = String(localStorage.getItem('quickqr_current_reserve_id'));
            if (current_id.length === 0) {
                showSwalnotifi(LANG_PLEASE_ENTER_THE_RESERVATION_TIME);
                return;
            }
        }
        var $item = $(this).closest('.ajax-item-listing'),
            item_id = $item.data('id'),
            name = $item.data('name'),
            description = $item.data('description'),
            price = $item.data('price'),
            amount = $item.data('amount'),
            amount_reduced = $item.data('amount-reduced'),
            order_price = Number(amount);

           // properties
           var sproperties = $item.data('properties') + "";    
           var properties_tpl = "";
           if(sproperties)
           {
           var arr_properties = sproperties.split("#");
           properties_tpl = '<h4>'+ LANG_PROPERTIES +'</h4> <ul>';
               jQuery.each(arr_properties, function (index, item) {
                   let a = item.split("|"); 
                   let name = a[1];
                   let image = a[2];
                   let img_properties = '';
                   if(image)
                   {
                    img_properties = '<img class="svg svg-restaurant-menu" src="'+ siteurl + 'storage/icon-food/' + image +  '"/>'
                   }
                   properties_tpl = properties_tpl + '<li>' + img_properties + '<span>'+ name +'</span></li>';
       
               });
           }


  var sadditives = $item.data('additives') + "";    
        var additives_tpl = "";
        if(sadditives)
        {
        var arr_additives = sadditives.split("#");
        additives_tpl = '<h4>'+ LANG_ADDITIVES +'</h4> <ul>';
            jQuery.each(arr_additives, function (index, item) {
                let a = item.split("|"); 
                let aliases = a[0];           
                additives_tpl = additives_tpl + '<li>' + aliases + '</li>';  
            });
        }      
        var sallegie = $item.data('allegie') + "";    
        var allegie_tpl = "";
        if(sallegie)
        {
        var arr_allegie = sallegie.split("#");
         allegie_tpl = '<h4>' + LANG_ALLEGIE + '</h4> <ul>';
            jQuery.each(arr_allegie, function (index, item) {
                let a = item.split("|"); 
                let name = a[1];
                let image = a[2];
                let img_allegie = '';
                if(image)
                {
                    img_allegie = '<img class="svg svg-restaurant-menu" src="'+ siteurl + 'storage/icon-food/' + image +  '"/>'
                }
                allegie_tpl = allegie_tpl + '<li>' + img_allegie + '<span>'+ name +'</span></li>';
    
            });
        }    
        $('#add-extras .menu_title2').html(name);
        $('#add-extras .menu_title').html(name);
        $('#add-extras .menu_desc').html(description);
      
         
        $('#Allegie_detail').html(allegie_tpl + additives_tpl + properties_tpl);       
        $('#Allegie_detail').css("display", "block");
        $('.menu-data').css("display","block");
        loadsvg();

        $('#order-price').html(formatPrice(amount));
        $('#menu-order-quantity').val(1);

        var $extra_wrapper = $('#menu-extra-items');
        $extra_wrapper.html('');
        var $menu_extra_option_wrapper = $('#menu-extra-option-items');
        $menu_extra_option_wrapper.html('');
        var extras = TOTAL_MENUS[item_id].extras || [];
        var extras_option = TOTAL_MENUS[item_id].extras_option || [];

    
        if (extras_option.length == 0) {
            $('#add-extras .menu_dots').show();
            $('#add-extras .menu_price').show();
            $('#add-extras .menu_price').html(price); 
            $('.menu-extra-option-wrapper').hide();
        } else {
            order_price = 0;
            $('#add-extras .menu_dots').hide();
            $('.menu-extra-option-wrapper').show();
            $('#add-extras .menu_price').hide();
        }
        for (var i in extras_option) {
            if (extras_option.hasOwnProperty(i)) {
             
                   var $extra_option_tpl = $(
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
                            $extra_option_tpl.find('.extra-item-price').html(formatPrice(extras_option[i].price));
                            $extra_option_tpl.data('price', extras_option[i].price);
                            $extra_option_tpl.data('id', extras_option[i].id);
                            $extra_option_tpl.find('.radio input').on('change', function () {
                                calculateOrderPrice(order_price);
                            });
                            $menu_extra_option_wrapper.append($extra_option_tpl);       
            }
        }
        var min_extra_option_price = '';
        $('.menu-extra-option-item').each(function () {
            var price = Number($(this).data('price'));
            if(min_extra_option_price == '')
            {
                min_extra_option_price = price;
            }
       if(min_extra_option_price >= price)
       {
        min_extra_option_price = price;
        $(this).find('.radio input').attr('checked', true);
       }
        });
        calculateOrderPrice(order_price);

        if (extras.length == 0) {
            $('.menu-extra-wrapper').hide();
        } else {
            $('.menu-extra-wrapper').show();
        }
        for (var i in extras) {
            if (extras.hasOwnProperty(i)) {
             
                var $extra_tpl = $(
                    '<div class="d-flex menu-extra-item">' +
                    '<div class="checkbox">' +
                    '<input type="checkbox"  id="chekcbox1">' +
                    '<label for="chekcbox1">' +
                    '<span class="checkbox-icon"></span> <span class="extra-item-title"></span>' +
                    '</label>' +
                    '</div>' +
                    '<strong class="margin-left-auto extra-item-price"></strong>' +
                    '</div>');
                    $extra_tpl.find('.checkbox input').attr('id', 'checkbox' + extras[i].id);
                    $extra_tpl.find('label').attr('for', 'checkbox' + extras[i].id);
                    $extra_tpl.find('.extra-item-title').html(extras[i].title);
                    $extra_tpl.find('.extra-item-price').html(formatPrice(extras[i].price));
                    $extra_tpl.data('price', extras[i].price);
                    $extra_tpl.data('id', extras[i].id);
                    $extra_tpl.find('.checkbox input').on('change', function () {
                        calculateOrderPrice(order_price);
                    });
                    $extra_wrapper.append($extra_tpl);
            }
        }

        $('#menu-order-quantity-decrease').off().on('click', function (e) {
            var quatity = Number($('#menu-order-quantity').val()) - 1;
            if (quatity == 0) {
                quatity = 1;
            }
            $('#menu-order-quantity').val(quatity);
            calculateOrderPrice(order_price);
        });
        $('#menu-order-quantity-increase').off().on('click', function (e) {
            $('#menu-order-quantity').val(Number($('#menu-order-quantity').val()) + 1);
            calculateOrderPrice(order_price);
        });

        $('#add-order-button').off().on('click', function (e) {
            calculateOrderPrice(order_price);
            var price = $('#order-price').html();
            var order_data = JSON.parse(localStorage.getItem('quickqr_order'));
            var next_order = localStorage.getItem('quickqr_next_order');
            next_order = (next_order ? parseInt(next_order) : 1);
            let order_temp_item_id = '';
            let order_temp_extra_id = '';
            let action = localStorage.getItem('quickqr_action');
            let table = localStorage.getItem('quickqr_table');
            let id_customer = localStorage.getItem('quickqr_id_customer');
            let DateTick = new Date().getTime();

            if (action == "on-table-action") {
                order_temp_item_id = $("#restaurant_id").val() + "-" + table + "-" + DateTick;
            }
            else {
                order_temp_item_id = $("#restaurant_id").val() + "-" + DateTick;
            }
            // this order's extras
            var extras = {};
            $('.menu-extra-item').each(function () {
                if ($(this).find('.checkbox input').is(':checked')) {
                    order_temp_extra_id = $(this).data('id') + "-" + DateTick;
                    extras[order_temp_extra_id] = {
                        'id': order_temp_extra_id,
                        'extra_id': $(this).data('id'),
                        'deleted': 0,
                        'name': $(this).find('.extra-item-title').html(),
                        'price': $(this).data('price')
                    };
                }
            });
             var extra_option_id = '';
             var extra_option_name = '';
             var extra_option_price = 0;
            if (extras_option.length != 0) {
                $('.menu-extra-option-item').each(function () {
                    if ($(this).find('.radio input').is(':checked')) {
                        extra_option_id = $(this).data('id');
                        extra_option_name = ' - ' + $(this).find('.extra-item-title').html();
                        extra_option_price = $(this).data('price');
                        amount = extra_option_price;
                        amount_reduced = 0;
                    }
                });
            }

            let item_data = {
                'id': order_temp_item_id,
                'item_id': item_id,
                'extra_option_id': extra_option_id,
                'order_price': price,
                'item_name': name + extra_option_name,
                'item_price': amount,
                'extras': extras,
                'amount_reduced': amount_reduced,
                'quantity': $('#menu-order-quantity').val(),
                'next_order': next_order,
                'is_order': 0,
                'deleted' : 0,
                'date_order': getFormattedDate()
            };

            let reserve_item_data = JSON.parse(localStorage.getItem('quickqr_reserve_item'));
            if (action == "reservation-food-action") {
                reserve_item_data[DateTick] = item_data;
            }
            else {
                order_data[DateTick] = item_data;
            }
              console.log(order_data);
            if (action == "on-table-action") {
                let $data = [];
                $data.push({ name: 'action', value: 'pushDataToOrderTemp' });
                $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
                $data.push({ name: 'table', value: table });
                $data.push({ name: 'items', value: JSON.stringify(item_data) });
                $data.push({ name: 'id_customer', value: id_customer });
                let $btn = $(this);
                $btn.addClass('button-progress').prop('disabled', true);
                $('.error-add-order-buuton').slideUp();
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: $data,
                    dataType: 'json',
                    success: function (response) {
                        $btn.removeClass('button-progress').prop('disabled', false);
                        if (response.success) {
                            $('.error-add-order-buuton').slideUp();
                            localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                            getTotalSumOrder();
                            generateViewOrder('add-order-button')
                            //checkWidthandSetViewOrderWrapper();
                            $("#bookmarks-order-button").show();
                            $.magnificPopup.close();
                        }
                        else {
                            $('.error-add-order-buuton').html(response.message).slideDown();
                        }

                    }

                });
            }
            else if (action == "reservation-food-action") {
                localStorage.setItem('quickqr_reserve_item', JSON.stringify(reserve_item_data));
                getTotalSumOrder();
              //  $("#bookmarks-order-button").hide();
              // $(".bookmark-reserve-button-group").show()
                generateViewReserveItem()
                $.magnificPopup.close();
            }
            else {
                localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                getTotalSumOrder();   
              //  $("#bookmarks-order-button").show();
              //  $(".bookmark-reserve-button-group").hide();
                generateViewOrder('add-order-button')
                $.magnificPopup.close();
            }

        });


        $.magnificPopup.open({
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



    /*
    * View Order
    */
    $('#view-order-button').on('click', function (e) {
        let ordering_type = $("#ordering-type").val();
        $('#submit-order-button span').html(LANG_SEND_ORDER);
        if (ordering_type == 'on-table') {
            $('.order-total-shipping-fee').hide();
            $('.bookmarks-name-group').hide();
        } else if (ordering_type == 'takeaway') {
            $('.order-total-shipping-fee').hide();
        } else if (ordering_type == 'delivery') {
            $('.order-total-shipping-fee').show();
        }
        $('.your-order-content').show();
        $('.order-success-message').hide();

        generateViewOrder('view-order-button');
        $.magnificPopup.open({
            items: {
                src: '#your-order',
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
    $(document).on('click', '#back-to-order-overview', function (e) {
        e.preventDefault();
        let action = localStorage.getItem('quickqr_action');
        if (action == "reservation-food-action") {
            $('.cart-reservation').show();
        }
        else {
            $('.cart-reservation').hide();
        }
        $(".bookmarks-cart-pay").animate({ "left": "100%", "opacity": "0"}, "slow");
        $('.bookmarks-your-order-content').animate({ "opacity": "1" }, "slow");
        $('.bookmarks-your-order-content').show();
        $('.cart-header-step-3').hide();
        $('.cart-header-step-1').show();
        $('.cart-header-step-2').hide();
        $('.cart-header-edit-address').hide();
        $(".add-item-button").show();
        $(".bookmarks").css('height', 'auto');
        $(".bookmarks-cart-pay").css('display','none');
        $("html, body").animate({
            scrollTop: $("#w30").offset().top
        }, 500);
    });

    $(document).on('click', '#bookmarks-order-button', function (e) {
        $('.bookmarks-your-order-content').animate({ "opacity": "0" }, "slow");
        $('.bookmarks-your-order-content').hide();
        $('.bookmarks-cart-pay').show();
        $(".bookmarks-cart-pay").animate({ "right": "0", "left": "0", "opacity": "1" }, "slow")
        $('.cart-header-step-3').hide();
        $('.cart-header-step-1').hide();
        $('.cart-header-step-2').show();
        $('.cart-header-edit-address').hide();
        $(".add-item-button").hide();
        let height = $(".bookmarks-your-order-content").height() + $(".cart-header").height() + 520;
        $(".bookmarks").css('height', height + 'px');
        $('#bookmarks-save-address').css('display', 'none');
        $('#bookmarks-order-button-step-3').css('display', 'flex');
    });

    function checkElementInvalid(element, is_email = false, is_telephone = false) {
        let ref = true;
        if (is_telephone) {
            if (!validatePhone(element.attr('id'))) 
            {
                addClassError(element);
                ref = false;
            }
            else 
            {
                removeClassError(element);
            }
        }
        else {
            if (is_email) {
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
                    ref = false;
                   // removeClassError(element);
                }
            }
            else {
                if (element.val().length === 0) {
                    addClassError(element);
                    ref = false;
                }
                else {
                    removeClassError(element);
                }
            }
        }
        return ref
    }
    function addClassError(element, is_focus = true) {
        parents = element.closest('.bookmarks-input-group').addClass('error');
        if (is_focus) {
            element.focus();
        }
        parents.find('.error-message').show()
    }
    function removeClassError(element) {
        parents = element.closest('.bookmarks-input-group').removeClass('error');
        parents.find('.error-message').hide();
    }

    $(document).on('click', '#bookmarks-save-address', function (e) {
        e.preventDefault();
        //check field valid
        let name = $('#bookmarks-name');
        let phone = $('#bookmarks-phone-number-field');
        let zip_code = $('#bookmarks-zip-code-field');
        let address = $('#bookmarks-address-field');
        let house_number = $('#bookmarks-house-number-field');
        let street_name = $('#bookmarks-street-name-field');
        let city = $('#bookmarks-city-field');
        let email = $('#bookmarks-email-field');

        let bInvalidEmail = true;
        let bInvalidPhone = true;
        let bInvalidCity = true;
        let bInvalidZipcode = true;
        let bInvalidHouseNumber = true;
        let bInvalidStreetName = true;
        let bInvalidAddress = true;
        let bInvalidName = true;
        bInvalidEmail = checkElementInvalid(email, true);
        bInvalidPhone = checkElementInvalid(phone, false, true);
        bInvalidName = checkElementInvalid(name);
        bInvalidCity = checkElementInvalid(city);
        bInvalidZipcode = checkElementInvalid(zip_code);
        bInvalidHouseNumber = checkElementInvalid(house_number);
        bInvalidStreetName = checkElementInvalid(street_name);
        bInvalidAddress = checkElementInvalid(address);

        if (bInvalidEmail && bInvalidPhone && bInvalidCity && bInvalidZipcode && bInvalidHouseNumber && bInvalidStreetName && bInvalidAddress && bInvalidName) {
            
            $("#name").val(name.val());
             $("#address-field").val(address.val());
             $("#street-name-field").val(street_name.val()); 
             $("#house-number-field").val(house_number.val()); 
             $("#zip-code-field").val(zip_code.val()); 
             $("#city-field").val(city.val()); 
             $("#phone-number-field").val(phone.val()); 
             $("#email-field").val(email.val());

            let $form = $("#bookmarks-send-order-form");
            let $data = $form.serializeArray();
            let $btn = $('#bookmarks-save-address');
            $data.push({ name: 'action', value: 'saveAddressCustomer' });
            $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
            $btn.addClass('button-progress').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: $data,
                dataType: 'json',
                success: function (response) {
                    $btn.removeClass('button-progress').prop('disabled', false);
                    if (response.success) {
                        $data = [];
                        $data.push({ name: 'action', value: 'getShippingFee' });
                        $data.push({ name: 'address', value: $("#bookmarks-address-field").val() });
                        $data.push({ name: 'zip_code', value: $("#bookmarks-zip-code-field").val() });
                        $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
                        $data.push({ name: 'route', value: $("#bookmarks-street-name-field").val() });
                        $.ajax({
                            type: "POST",
                            url: ajaxurl,
                            data: $data,
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    localStorage.setItem('quickqr_shipping_fee', response.message);
                                    let current_id = localStorage.getItem('quickqr_current_reserve_id');
                                    var reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
                                    if(reserve_data[current_id])
                                    {
                                        // if(current_id.slice(-4) == "-new")
                                        // {
                                        reserve_data[current_id]['shipping_fee'] = response.message;
                                        reserve_data[current_id]['address'] = $('#bookmarks-address-field').val();
                                       // }                                 
                                        localStorage.setItem('quickqr_reserve', JSON.stringify(reserve_data));
                                        generateViewReserveItem();
                                        getTotalSumOrder();
                                    }                                 
                                    showSwalnotifi(LANG_SAVED_SUCCESS, "success");
                                }
                            }
                        });
                      
                    } else {
                        showSwalnotifi(response.message)
                    }
                    $('.cart-reservation').show();
                    $(".bookmarks-cart-pay").animate({ "left": "100%", "opacity": "0" }, "slow");
                    $(".bookmarks_payment_methoad").css('display','none');
                    $(".bookmarks-cart-pay").css('display','none');
                    
                    $('.bookmarks-your-order-content').animate({ "opacity": "1" }, "slow");
                    $('.bookmarks-your-order-content').show();
                    $('.cart-header-step-3').hide();
                    $('.cart-header-step-1').show();
                    $('.cart-header-step-2').hide();
                    $('.cart-header-edit-address').hide();
                    $(".add-item-button").show();
                    $(".bookmarks").css('height', 'auto');
                    $("html, body").animate({
                        scrollTop: $("#w30").offset().top
                    }, 500);
                }
            });
        }
        else {
            return false;
        }
    });
    $(document).on('click', '#bookmarks-order-button-step-3', function (e) {
        e.preventDefault();
        //check field valid
        bookmarks_payment_methoad_open = true;
        let name = $('#bookmarks-name');
        let phone = $('#bookmarks-phone-number-field');
        let zip_code = $('#bookmarks-zip-code-field');
        let address = $('#bookmarks-address-field');
        let house_number = $('#bookmarks-house-number-field');
        let street_name = $('#bookmarks-street-name-field');
        let city = $('#bookmarks-city-field');
        let email = $('#bookmarks-email-field');
        let bInvalidEmail = true;
        let bInvalidPhone = true;
        let bInvalidCity = true;
        let bInvalidZipcode = true;
        let bInvalidHouseNumber = true;
        let bInvalidStreetName = true;
        let bInvalidAddress = true;
        let bInvalidName = true;
        let action = localStorage.getItem('quickqr_action');
        bInvalidEmail = checkElementInvalid(email, true);
        bInvalidPhone = checkElementInvalid(phone, false, true);
        if (action == "delivery-action") {
            bInvalidCity = checkElementInvalid(city);
            bInvalidZipcode = checkElementInvalid(zip_code);
            bInvalidHouseNumber = checkElementInvalid(house_number);
            bInvalidStreetName = checkElementInvalid(street_name);
            bInvalidAddress = checkElementInvalid(address);
        }
        bInvalidName = checkElementInvalid(name);

        if (bInvalidEmail && bInvalidPhone && bInvalidCity && bInvalidZipcode && bInvalidHouseNumber && bInvalidStreetName && bInvalidAddress && bInvalidName) {
            if (action == "delivery-action") {
                let shipping_fee = localStorage.getItem('quickqr_shipping_fee');
                if (shipping_fee.length === 0) {
                    $btn = $('#bookmarks-order-button-step-3');
                    $data = [];
                    $data.push({ name: 'action', value: 'getShippingFee' });
                    $data.push({ name: 'address', value: $("#bookmarks-address-field").val() });
                    $data.push({ name: 'zip_code', value: $("#bookmarks-zip-code-field").val() });
                    $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
                    $data.push({ name: 'route', value: $("#bookmarks-street-name-field").val() });
                    $btn.addClass('button-progress').prop('disabled', true);
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: $data,
                        dataType: 'json',
                        success: function (response) {
                            $btn.removeClass('button-progress').prop('disabled', false);
                            if (response.success) {
                                localStorage.setItem('quickqr_shipping_fee', response.message)
                                localStorage.setItem('quickqr_address', address.val());
                                localStorage.setItem('quickqr_house_number', house_number.val());
                                localStorage.setItem('quickqr_street_name', street_name.val());
                                localStorage.setItem('quickqr_city', city.val());
                                localStorage.setItem('quickqr_zip_code', zip_code.val());
                                showBookmarksPaymentMethoad()
                            } else {
                                swal({
                                    title: '',
                                    text: LANG_NOT_DELIVER,
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
                                return false;
                            }
                        }
                    });
                }
                else {
                    showBookmarksPaymentMethoad();
                }
            }
            else {
                showBookmarksPaymentMethoad()
            }

        }
        else {
            return false;
        }

    });
    function showBookmarksPaymentMethoad() {
        $('.bookmarks-cart-pay').animate({ "opacity": "0" }, "slow");
        $('.bookmarks-cart-pay').hide();
        $(".bookmarks_payment_methoad").animate({ "right": "0", "left": "0", "opacity": "1" }, "slow")
        $('.bookmarks_payment_methoad').show();

        $('.cart-header-step-3').show();
        $('.cart-header-step-1').hide();
        $('.cart-header-step-2').hide();
        $('.cart-header-edit-address').hide();
        $(".add-item-button").hide();
        genrateViewOrderBookmarks();
    }
    $(document).on('input', '#bookmarks-email-field', function (e) {
        let element = $(this);
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
            removeClassError(element);
        }
    });
    $(document).on('input', '#email-field', function (e) {
        let element = $(this);
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
            removeClassError(element);
        }
    });
    $(document).on('input', '#bookmarks-city-field', function (e) {
        let element = $(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
    });
    $(document).on('input', '#city-field', function (e) {
        let element = $(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
    });
    $(document).on('input', '#bookmarks-street-name-field', function (e) {
        let element = $(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
    });
    $(document).on('input', '#street-name-field', function (e) {
        let element = $(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
    });
    $(document).on('input', '#bookmarks-house-number-field', function (e) {
        let element = $(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
    });
    $(document).on('input', '#house-number-field', function (e) {
        let element = $(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
    });
    $(document).on('input', '#bookmarks-address-field', function (e) {
        let element = $(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
        localStorage.setItem('quickqr_shipping_fee', '');
        $('.cart-delivery-text span').html('');
        let order_total = getTotalSumOrder();
        $('.bookmarks-your-order-price').html(formatPrice(order_total));
    });
    $(document).on('input', '#address-field', function (e) {
        let element = $(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
        localStorage.setItem('quickqr_shipping_fee', '');
        $('.cart-delivery-text span').html('');
        let order_total = getTotalSumOrder();
        $('.bookmarks-your-order-price').html(formatPrice(order_total));
    });
    $(document).on('input', '#bookmarks-zip-code-field', function (e) {
        let element = $(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
        localStorage.setItem('quickqr_shipping_fee', '');
        let order_total = getTotalSumOrder();
        $('.bookmarks-your-order-price').html(formatPrice(order_total));
    });
    $(document).on('input', '#zip-code-field', function (e) {
        let element = $(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
        localStorage.setItem('quickqr_shipping_fee', '');
        let order_total = getTotalSumOrder();
        $('.bookmarks-your-order-price').html(formatPrice(order_total));
    });

    $(document).on('input', '#bookmarks-phone-number-field', function (e) {
        let element = $(this);
        if (!validatePhone(element.attr('id'))) {
            addClassError(element);
        }
        else {
            removeClassError(element);
        }
    });
    $(document).on('input', '#phone-number-field', function (e) {
        let element = $(this);
        if (!validatePhone(element.attr('id'))) {
            addClassError(element);
        }
        else {
            removeClassError(element);
        }
    });

    $(document).on('input', '#bookmarks-name', function (e) {
        let element = $(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
    });
    $(document).on('input', '#name', function (e) {
        let element = $(this);
        if (element.val().length === 0) {
            addClassError(element, false);
        }
        else {
            removeClassError(element);
        }
    });

    $(document).on('click', '#back-to-cart-pay', function (e) {
        e.preventDefault();
        bookmarks_payment_methoad_open = false;
        $(".bookmarks_payment_methoad").animate({ "left": "100%", "opacity": "0" }, "slow");
        $('.bookmarks-cart-pay').animate({ "opacity": "1" }, "slow");
        $('.bookmarks-cart-pay').show();
        $('.cart-header-step-3').hide();
        $('.cart-header-step-1').hide();
        $('.cart-header-step-2').show();
        $('.cart-header-edit-address').hide();
        $(".add-item-button").hide();
    });

    /*
    * View Order
    */
    $(document).on('click', "#order-button", function (e) {
        e.preventDefault();
        let table = $("#table-number-field").val();
        if (table.length === 0) {
            $('#action-popup').val('next-order-action');
            $('#name-2').hide();
            $('#table-number-field-2').show();
            $('#phone-number-field-2').hide();
            $('#email-field-2').hide();
            $('#address-field-2').hide();
            $('#zip-code-field-2').hide();
            $.magnificPopup.open({
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
            return false;
        }
        generateViewOrder('order-button');
        $.magnificPopup.open({
            items: {
                src: '#your-next-order',
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


    $(".address-change").on("keyup", function (e) {
        $('.your-shipping-fee').html('');
        $('.your-order-price-shipping-fee').html('');
        $('#submit-order-button-text').html(LANG_ORDER_FOR_A_FEE);

    });

    /*
    * Ordering type
    */
    $("#ordering-type").on("change", function (e) {
        let ordering_type = $(this).val();
        let pay_via = localStorage.getItem('quickqr_pay_via');
        if (ordering_type == 'on-table') {
            $('#table-number-field').show();
            $('#phone-number-field').hide();
            $('.takeaway-delivery-time-group').hide();
            $('#address-field').hide();
            $('#email-field').hide();
            $('#house-number-field').hide();
            $('#street-name-field').hide();
            $('#city-field').hide();
            $('#zip-code-field').hide();
            $('.order-total-shipping-fee').hide();
            if (pay_via == 'pay_on_counter') {
                $('#submit-order-button span').html(LANG_SEND_ORDER);
            } else if (pay_via == 'pay_online') {
                $('#submit-order-button span').html(LANG_PAY_NOW);
            }
        } else if (ordering_type == 'takeaway') {
            $('#table-number-field').hide();
            $('#phone-number-field').show();
            $('#email-field').show();
            $('.takeaway-delivery-time-group').show();
            $('#address-field').hide();
            $('#house-number-field').hide();
            $('#street-name-field').hide();
            $('#city-field').hide();
            $('#zip-code-field').hide();
            $('.order-total-shipping-fee').hide();
            if (pay_via == 'pay_on_counter') {
                $('#submit-order-button span').html(LANG_SEND_ORDER);
            } else if (pay_via == 'pay_online') {
                $('#submit-order-button span').html(LANG_PAY_NOW);
            }
        } else if (ordering_type == 'delivery') {
            $('#table-number-field').hide();
            $('#phone-number-field').show();
            $('#address-field').show();
            $('.takeaway-delivery-time-group').show();
            $('#email-field').show();
            $('#house-number-field').show();
            $('#street-name-field').show();
            $('#city-field').show();
            $('#zip-code-field').show();
            $('.order-total-shipping-fee').show();
            let $sPrice = $('.your-order-price-shipping-fee').html();
            if ($sPrice) {
                if (pay_via == 'pay_on_counter') {
                    $('#submit-order-button-text').html(LANG_SEND_ORDER);

                } else if (pay_via == 'pay_online') {
                    $('#submit-order-button-text').html(LANG_PAY_NOW);

                }
            }
            else {
                $('#submit-order-button-text').html(LANG_ORDER_FOR_A_FEE)

            }

        }
    }).trigger('change');

    if ($("#ordering-type").find('option').length == 1) {
        $("#ordering-type").closest('.section').hide();
    }

    function getShippingFee($btn = null, $address, $zip_code, $route) {
        $return = true;
        $data = [];
        $data.push({ name: 'action', value: 'getShippingFee' });
        $data.push({ name: 'address', value: $address });
        $data.push({ name: 'zip_code', value: $zip_code });
        $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
        $data.push({ name: 'route', value: $route });
        if ($btn) {
            $btn.addClass('button-progress').prop('disabled', true);
        }
        $btn.addClass('button-progress').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: $data,
            dataType: 'json',
            success: function (response) {
                if ($btn) {
                    $btn.removeClass('button-progress').prop('disabled', false);
                }
                if (response.success) {
                    localStorage.setItem('quickqr_shipping_fee', response.message);
                    getTotalSumOrderAndShippingFee();
                    pay_via_change();
                    $('.order-total-shipping-fee').show();
                } else {
                    $return = false;
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
        return $return;
    }

    /*
    * pay via
    */
    function validatePhone(txtPhone) {
        var a = document.getElementById(txtPhone).value;
        var filter = /^((\[+][1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
        if (filter.test(a)) {
            return true;
        }
        else {
            return false;
        }
    }
    function bookmarksSendOrderForm() {
        var order_data = JSON.parse(localStorage.getItem('quickqr_order')),
            items = [],
            $form = $("#bookmarks-send-order-form"),
            $btn = $("#bookmarks-pay-on-counter-button"),
            $btn2 = $("#bookmarks-payment-online-button"),
            $data = $form.serializeArray();
        let total_sum = getTotalSumOrder();
        for (var i in order_data) {
            if (order_data.hasOwnProperty(i)) {
                items.push(order_data[i]);
            }
        }
        localStorage.setItem('quickqr_address',$("#bookmarks-address-field").val());
        localStorage.setItem('quickqr_house_number',$("#bookmarks-house-number-field").val());              
        localStorage.setItem('quickqr_street_name',$("#bookmarks-street-name-field").val());                
        localStorage.setItem('quickqr_zip_code',$("#bookmarks-zip-code-field").val());             
        localStorage.setItem('quickqr_city',$("#bookmarks-city-field").val());                   
        bookmarks_payment_methoad_open = false;
        let ordering_type = $("#ordering-type").val();
        $data.push({ name: 'action', value: 'sendRestaurantOrder' });
        $data.push({ name: 'ordering-type', value: ordering_type });
        $data.push({ name: 'items', value: JSON.stringify(items) });
        $data.push({ name: 'total_sum', value: total_sum });
        $data.push({ name: 'restaurant', value: $form.data('id') });
        $data.push({ name: 'pay_via', value: localStorage.getItem('quickqr_pay_via') });
        $data.push({ name: 'shipping_fee', value: localStorage.getItem('quickqr_shipping_fee') });
        $data.push({ name: 'discount_price', value: localStorage.getItem('quickqr_discount_price') });
        $data.push({ name: 'discount_code', value: localStorage.getItem('quickqr_discount_code') });
        $data.push({ name: 'takeaway_delivery_time', value: $("#bookmarks-button-takeaway-delivery-time").data('time') });
        // $form_error.slideUp();
        $btn.addClass('button-progress').prop('disabled', true);
        $btn2.addClass('button-progress').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: $data,
            dataType: 'json',
            success: function (response) {
                $btn.removeClass('button-progress').prop('disabled', false);
                $btn2.removeClass('button-progress').prop('disabled', false);
                if (response.success) {
                    if (response.message != '' && response.message != null) {
                        location.href = response.message;
                    } else {
                        removeLocalStore(true);
                        $("#bookmarks_discount_code").html('');
                        $("#bookmarks_discount_price").html('');
                        $("#your_order_discount_code").html('');
                        $("#your_order_discount_price").html('');
                        $("#bookmarks-order-button").hide();
                        if (ordering_type == "delivery") {
                            $('.your-shipping-fee').html('');
                            $('.your-order-price-shipping-fee').html('');
                            $('.bookmarks-your-shipping-fee').html('');
                            $('.bookmarks-your-order-price-shipping-fee').html('');
                        }
                        checkWidthandSetViewOrderWrapper();
                        $("#table-number-field").val('');
                        $("#message-field").val('');
                        $('.your-shipping-fee').html('');
                        $('.your-order-price-shipping-fee').html('');
                        $('.order-total-shipping-fee').hide();
                        $(".add-item-button").hide();
                        $("#bookmarks-table-number-field").val('');
                        $("#bookmarks-message-field").val('');
                        $(".bookmarks-cart-pay").animate({ "left": "100%", "opacity": "0" }, "slow");
                        $(".bookmarks_payment_methoad").animate({ "left": "100%", "opacity": "0" }, "slow");
                        $('.bookmarks-your-order-content').animate({ "opacity": "1" }, "slow");
                        $('.bookmarks-your-order-content').show();
                        $('.cart-header-step-3').hide();
                        $('.cart-header-step-1').show();
                        $('.cart-header-step-2').hide();
                        $('.cart-header-edit-address').hide();
                        $.magnificPopup.open({
                            items: {
                                src: '#OrderSuccessModal',
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
                        function displayPopup() {
                            disabledMenu(false);
                            swal.close();
                            if ($("#FunctionModal")[0]) {
                                $.magnificPopup.open({
                                    items: {
                                        src: '#FunctionModal',
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
                          
                        }
                        setTimeout(displayPopup, 3000);
                        if (response.whatsapp_url != '' && response.whatsapp_url != null) {
                            // send to whatsapp
                            location.href = response.whatsapp_url;
                         //  window.open(response.whatsapp_url);
                        }
                    }
                } else {
                    $(".bookmarks_payment_methoad").animate({ "left": "100%", "opacity": "0" }, "slow");
                    $('.bookmarks-cart-pay').animate({ "opacity": "1" }, "slow");
                    $('.bookmarks-cart-pay').show();
                    $('.cart-header-step-3').hide();
                    $('.cart-header-step-1').hide();
                    $('.cart-header-step-2').show();
                    $('.cart-header-edit-address').hide();
                    $(".add-item-button").show();
                    $form.find('.form-error').html(response.message).slideDown();
                }
            }
        });

    }


    function bookmarksSendReserveForm() {
        let reserve_item_data = JSON.parse(localStorage.getItem('quickqr_reserve_item'));
        let reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
        let reserve_id = String(localStorage.getItem('quickqr_current_reserve_id'));
        let reserve_items = [],
            reserve = reserve_data[reserve_id],
            $form = $("#bookmarks-send-order-form"),
            $btn = $("#bookmarks-reserve-button"),
            $data = $form.serializeArray();
        let total_sum = getTotalSumOrder();
        for (var i in reserve_item_data) {
            if (reserve_item_data.hasOwnProperty(i)) {
                reserve_items.push(reserve_item_data[i]);
            }

        }
        $data.push({ name: 'action', value: 'sendRestaurantReserve' });
        $data.push({ name: 'reserve_items', value: JSON.stringify(reserve_items) });
        $data.push({ name: 'reserve', value: JSON.stringify(reserve) });
        $data.push({ name: 'reserve_id', value: reserve_id });
        $data.push({ name: 'total_sum', value: total_sum });
        $data.push({ name: 'restaurant', value: $form.data('id') });
        $data.push({ name: 'shipping_fee', value: localStorage.getItem('quickqr_shipping_fee') });
        $data.push({ name: 'discount_price', value: localStorage.getItem('quickqr_discount_price') });
        $data.push({ name: 'discount_code', value: localStorage.getItem('quickqr_discount_code') });
        $btn.addClass('button-progress').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: $data,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                $btn.removeClass('button-progress').prop('disabled', false);
                if (response.success) {
                    if (response.message != '' && response.message != null) {
                        location.href = response.message;
                    } else {
                        localStorage.setItem('quickqr_reserve_item', '{}');
                        localStorage.setItem('quickqr_reserve', '{}');
                        localStorage.setItem('quickqr_current_reserve_id', '');
                        $('.bookmarks-your-order-content').animate({ "opacity": "1" }, "slow");
                        $('.bookmarks-your-order-content').show();
                
                        $('.cart-header-step-3').hide();
                        $('.cart-header-step-1').show();
                        $('.cart-header-step-2').hide();
                        $('.cart-header-edit-address').hide();
                        $('.reservation-time').hide();
                        $('.date-reservation').hide();
                        $('.date-notifi').show();      
                        $("#date_reservation").val(''); 
                        $("#time_reservation").val('');
                        $('.cart-delivery-text span').html('');
                        checkWidthandSetViewOrderWrapper();
                        showReservationFood()
                        $("html, body").animate({
                            scrollTop: $("#w30").offset().top
                        }, 500);
                        $.magnificPopup.open({
                            items: {
                                src: '#OrderSuccessModal',
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
                        // setTimeout(displayPopup, 3000);
                        if (response.whatsapp_url != '' && response.whatsapp_url != null) {
                            // send to whatsapp
                            location.href = response.whatsapp_url;
                        }
                    }
                } else {
                    $(".bookmarks_payment_methoad").animate({ "left": "100%", "opacity": "0" }, "slow");
                    $('.bookmarks-cart-pay').animate({ "opacity": "1" }, "slow");
                    $('.bookmarks-cart-pay').show();
                    $('.cart-header-step-3').hide();
                    $('.cart-header-step-1').hide();
                    $('.cart-header-step-2').show();
                    $('.cart-header-edit-address').hide();
                    $(".add-item-button").show();
                    $form.find('.form-error').html(response.message).slideDown();
                }
            }
        });
    }

    $(document).on('click', '#bookmarks-pay-on-counter-button', function () {
        localStorage.setItem('quickqr_pay_via', 'pay_on_counter');
        bookmarksSendOrderForm();
    });

    $(document).on('click', '#bookmarks-payment-online-button', function () {
        localStorage.setItem('quickqr_pay_via', 'pay_online');
        bookmarksSendOrderForm();
    })
    /*
    * Send Order
    */
    $("#send-order-form").on("submit", function (e) {
        e.preventDefault();
        var order_data = JSON.parse(localStorage.getItem('quickqr_order')),
            items = [],
            $form = $(this),
            $btn = $('#submit-order-button'),
            $form_error = $form.find('.form-error'),
            $data = $form.serializeArray(),
            $text_btn_submit = $('#submit-order-button span').html();
        let ordering_type = $("#ordering-type").val();
        let total_sum = getTotalSumOrder();

        //check field valid
        let name = $('#name');
        let phone = $('#phone-number-field');
        let zip_code = $('#zip-code-field');
        let address = $('#address-field');
        let house_number = $('#house-number-field');
        let street_name = $('#street-name-field');
        let city = $('#city-field');
        let email = $('#email-field');
        let bInvalidEmail = true;
        let bInvalidPhone = true;
        let bInvalidCity = true;
        let bInvalidZipcode = true;
        let bInvalidHouseNumber = true;
        let bInvalidStreetName = true;
        let bInvalidAddress = true;
        let bInvalidName = true;
        let action = localStorage.getItem('quickqr_action');
        if (action != "on-table-action") {
            bInvalidEmail = checkElementInvalid(email, true);
            bInvalidPhone = checkElementInvalid(phone, false, true);
            bInvalidName = checkElementInvalid(name);
        }
        if (action == "delivery-action") {
            bInvalidCity = checkElementInvalid(city);
            bInvalidZipcode = checkElementInvalid(zip_code);
            bInvalidHouseNumber = checkElementInvalid(house_number);
            bInvalidStreetName = checkElementInvalid(street_name);
            bInvalidAddress = checkElementInvalid(address);
        }
        if (bInvalidEmail && bInvalidPhone && bInvalidCity && bInvalidZipcode && bInvalidHouseNumber && bInvalidStreetName && bInvalidAddress && bInvalidName) {
            for (var i in order_data) {
                if (order_data.hasOwnProperty(i)) {
                    items.push(order_data[i]);
                }
            }

            localStorage.setItem('quickqr_address',$("#address-field").val());
            localStorage.setItem('quickqr_house_number', $("#house-number-field").val());              
            localStorage.setItem('quickqr_street_name',$("#street-name-field").val());                
            localStorage.setItem('quickqr_zip_code',$("#zip-code-field").val());             
            localStorage.setItem('quickqr_city',$("#city-field").val()); 


            $data.push({ name: 'action', value: 'sendRestaurantOrder' });
            $data.push({ name: 'items', value: JSON.stringify(items) });
            $data.push({ name: 'restaurant', value: $form.data('id') });
            $data.push({ name: 'pay_via', value: localStorage.getItem('quickqr_pay_via') });
            $data.push({ name: 'shipping_fee', value: localStorage.getItem('quickqr_shipping_fee') });
            $data.push({ name: 'total_sum', value: total_sum });
            $data.push({ name: 'takeaway_delivery_time', value: $("#button-takeaway-delivery-time").data('time') });
            $data.push({ name: 'discount_price', value: localStorage.getItem('quickqr_discount_price') });
            $data.push({ name: 'discount_code', value: localStorage.getItem('quickqr_discount_code') });
            $form_error.slideUp();
            $btn.addClass('button-progress').prop('disabled', true);

            if ($text_btn_submit == LANG_ORDER_FOR_A_FEE) {
                $data = [];
                $data.push({ name: 'action', value: 'getShippingFee' });
                $data.push({ name: 'address', value: $("#address-field").val() });
                $data.push({ name: 'zip_code', value: $("#zip-code-field").val() });
                $data.push({ name: 'restaurant', value: $form.data('id') });
                $data.push({ name: 'route', value: $("#street-name-field").val() });
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: $data,
                    dataType: 'json',
                    success: function (response) {
                        $btn.removeClass('button-progress').prop('disabled', false);
                        if (response.success) {
                            localStorage.setItem('quickqr_shipping_fee', response.message);
                            localStorage.setItem('quickqr_address', $("#address-field").val());
                            localStorage.setItem('quickqr_house_number', $("#house-number-field").val());
                            localStorage.setItem('quickqr_street_name', $("#street-name-field").val());
                            localStorage.setItem('quickqr_city', $("#city-field").val());
                            localStorage.setItem('quickqr_zip_code', $("#zip-code-field").val());
                            getTotalSumOrderAndShippingFee();
                            pay_via_change();
                            $('.order-total-shipping-fee').show();
                        } else {
                            $form.find('.form-error').html(response.message).slideDown();
                        }
                    }
                });
            }
            else {
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: $data,
                    dataType: 'json',
                    success: function (response) {

                        $btn.removeClass('button-progress').prop('disabled', false);
                        if (response.success) {

                            if (response.message != '' && response.message != null) {
                                location.href = response.message;
                            } else {
                                // clear order data
                                removeLocalStore(true);
                                $("#bookmarks-order-button").hide();
                                checkWidthandSetViewOrderWrapper();
                                if (ordering_type == "delivery") {
                                    $('.your-shipping-fee').html('');
                                    $('.your-order-price-shipping-fee').html('');
                                    $('.bookmarks-your-shipping-fee').html('');
                                    $('.bookmarks-your-order-price-shipping-fee').html('');
                                }
                                $("#table-number-field").val('');
                                $("#message-field").val('');
                                $('.your-shipping-fee').html('');
                                $('.your-order-price-shipping-fee').html('');
                                $("#submit-order-button-text").html(LANG_SEND_ORDER)
                                $('.order-total-shipping-fee').hide();
                                $(".add-item-button").hide();
                                $.magnificPopup.close();
                                swal({
                                    title: LANG_SENT_SUCCESSFULLY,
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonColor: "var(--classic-color-1)",
                                    confirmButtonText: LANG_COMPLETE,
                                    closeOnConfirm: false,
                                    closeOnCancel: false
                                },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            disabledMenu(false)
                                            swal.close();
                                            if(ONLY_ON_TABLE != "1")
                                            {
                                            if ($("#FunctionModal")[0]) {
                                                $.magnificPopup.open({
                                                    items: {
                                                        src: '#FunctionModal',
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
                                        }
                                        }
                                    });
                                if (response.whatsapp_url != '' && response.whatsapp_url != null) {
                                    // send to whatsapp
                                  location.href = response.whatsapp_url;
                                // window.open(response.whatsapp_url);
                                }
                            }
                        } else {
                            $form.find('.form-error').html(response.message).slideDown();
                        }
                    }
                });
            }
        }
        else {
            return false;
        }

    });
    $('.bookmarks-takeaway-delivery-time-class').on('click', '.dropdown-menu li', function (e) {
        e.preventDefault();
        var data = $(this).data('value');
        $("#bookmarks-button-takeaway-delivery-time span").html($(this).html());
        $("#bookmarks-button-takeaway-delivery-time").data('time', data);
    });

    $('.takeaway-delivery-time-class').on('click', '.dropdown-menu li', function (e) {
        e.preventDefault();
        var data = $(this).data('value');
        $("#button-takeaway-delivery-time span").html($(this).html());
        $("#button-takeaway-delivery-time").data('time', data);
    });
    /* on lang change */
    $('.user-lang-switcher').on('click', '.dropdown-menu li', function (e) {
        e.preventDefault();
        var lang = $(this).data('lang');
        var code = $(this).data('code');
        if (lang != null) {
            var res = lang.substr(0, 2);
            $('#selected_lang').html(res.toUpperCase());
            $.cookie('Quick_lang', lang, { path: '/' });
            $.cookie('Quick_user_lang', lang, { path: '/' });
            $.cookie('Quick_user_lang_code', code, { path: '/' });
            location.reload();
        }
    });
    var code = $.cookie('Quick_user_lang_code');
    var language = $.cookie('Quick_lang');
    if (language != null) {
        language = $.cookie('Quick_lang').charAt(0).toUpperCase() + $.cookie('Quick_lang').slice(1);
    }
    else {
        language = 'German';
    }
    if (code != null) {
        $('.user-lang-switcher .filter-option').html('<i class="sl-flag flag-' + language + '"></i>' + language);
    }

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

    function randomId(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
    function getFormattedDate() {
        var d = new Date();
        d = ('0' + d.getDate()).slice(-2) + "-" + ('0' + (d.getMonth() + 1)).slice(-2) + "-" + d.getFullYear() + " " + ('0' + d.getHours()).slice(-2) + ":" + ('0' + d.getMinutes()).slice(-2) + ":" + ('0' + d.getSeconds()).slice(-2);

        return d;
    }


    function confirm_order() {
        let status_order = localStorage.getItem('status_order');
        let table = localStorage.getItem('quickqr_table');
        let action = localStorage.getItem('quickqr_action');
        if (action == "on-table-action") {
            if (status_order == "waiting") {
                let $data = [];
                let id_customer = localStorage.getItem('quickqr_id_customer');
                id_customer = (id_customer ? id_customer : '');
                $data.push({ name: 'action', value: 'checkConfirmOrders' });
                $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
                $data.push({ name: 'table', value: table });
                $data.push({ name: 'id_customer', value: id_customer });
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: $data,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            localStorage.setItem('status_order', 'using');   //waiting              
                            $(".add-item-button").show();
                            $('.your-action-content').slideDown();
                            $('.order-success-message').slideUp();
                            $.magnificPopup.close();
                        }
                        else if (response.status == "empty") {
                            if(ONLY_ON_TABLE != "1")
                            {
                                disabledMenu(false)
                                $(".add-item-button").hide();
                                $('.your-action-content').slideDown();
                                $('.order-success-message').slideUp();
                                removeLocalStore();
                                showFunctionModel();
                            }
                            else
                            {
                                removeLocalStore();
                                $(".add-item-button").hide();
                                $.magnificPopup.close();
                            }
                           
                        }
                    }
                });
            }
            else if (status_order == "using") {
                // check table is remove
                let $data = [];
                $data.push({ name: 'action', value: 'checkRemoveTableFromMobile' });
                $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
                $data.push({ name: 'table', value: table });
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: $data,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            removeLocalStore();
                            $(".add-item-button").hide();
                            generateViewOrder("view-order-button")
                            if(ONLY_ON_TABLE != "1")
                            {
                                disabledMenu(false)
                                $('.your-action-content').slideDown();
                                $('.order-success-message').slideUp();                
                                showFunctionModel();
                            }
                            else
                            {
                            $.magnificPopup.close();
                            }                                           
                        }
                    }
                });
            }
        }
    }
    function disabledMenu(disabled) {
        $(".menu-action").children().prop('disabled', disabled);
        $(".delivery-action").children().prop('disabled', disabled);
        $(".takeaway-action").children().prop('disabled', disabled);
        $(".menu-action").prop('disabled', disabled);
        $(".delivery-action").prop('disabled', disabled);
        $(".takeaway-action").prop('disabled', disabled);
    }
    function generateViewReserve() {
        var reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
        var $reserve_wrapper = $('#bookmarks-reservations-content');
        $reserve_wrapper.html('');
        for (var i in reserve_data) {
            if (reserve_data.hasOwnProperty(i)) {
                var reserve = reserve_data[i],
                    id = String(reserve.id),
                    is_disabled = Number(reserve.is_disabled),
                    date = reserve.date + ' ' + reserve.time;
                    let reserve_date = new Date(reserve.date_reserve);       
                    let now = new Date();
                var $reserve_tpl = $('<div class="reserve-item">' +
                    '<h4 class="reserve_post">' +
                    '<span class="reserve_icon_cloud"></span>' +
                    '<span class="reserve_date"></span>' +
                    '<span class="reserve_action"> <a href="javascript:void(0)" class="item-delete"><i class="icon-delete-file"></i></a></span>' +
                    '</h4>' +
                    '</div>');
                $reserve_tpl.data('reserve-id', id);
                $reserve_tpl.find('.reserve_date').html(date);
                // if (reserve_date.setHours(0, 0, 0, 0) <= now.setHours(0, 0, 0, 0)) {
                //     $reserve_tpl.find('.item-delete').hide();  
                // }
                // else
                // {
                //     $reserve_tpl.find('.item-delete').show();
                // }
                let sTextid = id.slice(-4);
                if (sTextid == "-new") {
                    $reserve_tpl.find('.reserve_icon_cloud').html('<i class="icon-feather-cloud-off"></i>');
                }
                else {
                    $reserve_tpl.find('.reserve_icon_cloud').html('<i class="icon-feather-check"></i>');
                }
                // if (is_disabled == 1) {
                //     $reserve_tpl.find('.reserve_is_disabled').html(LANG_TURN_OFF)
                //     $reserve_tpl.find('.reserve_post').addClass('reserve_post_disabled')
                // }
                // else {
                //     $reserve_tpl.find('.reserve_is_disabled').html(LANG_TURN_ON)
                // }
                var $delete = $reserve_tpl.find('.item-delete');
                $delete.on('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    let id = $(this).closest('.reserve-item').data('reserve-id');
                    let current_id = String(localStorage.getItem('quickqr_current_reserve_id'));
                    let sid = String(id);
                    if (current_id.slice(-4) == "-new" && sid.slice(-4) != "-new") {
                        showSwalnotifi(LANG_PLEASE_COMPLETE_YOUR_CURRENT_ORDER);
                        return;
                    }

                    if (sid.slice(-4) != "-new") {                      
                                    let $data = [];
                                    let reserve = reserve_data[id];
                                    let date_reserve = reserve.date_reserve;   
                                    let reserve_date = new Date(date_reserve);       
                                    let today = new Date();
                                    let min_hour_edit = today.setHours(today.getHours() + MIN_HOUR_EDIT_PRE_ORDER);
                                    if (min_hour_edit > reserve_date.getTime()) {
                                        showSwalnotifi(LANG_DATA_CANNOT_BE_DELETED);  
                                    }
                                    else
                                    {

                                        $("#id-pre-order").val(id);
                                        $.magnificPopup.open({
                                            items: {
                                                src: '#delete-popup',
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
                                
                       
                    }
                    else {
                      //  console.log(reserve_data);
                        delete reserve_data[id];
                        localStorage.setItem('quickqr_reserve', JSON.stringify(reserve_data));
                        localStorage.setItem('quickqr_current_reserve_id', '');
                        localStorage.setItem('quickqr_reserve_item', '{}');
                        $('.reservation-time').hide();
                        $('.date-reservation').hide();
                        $('.date-notifi').show();
                        generateViewReserve();
                        generateViewReserveItem();
                    }

                });
                $reserve_wrapper.append($reserve_tpl);
            }
        }
    }

    $(document).on('click','#delete-pre-order', function(e) {
        e.preventDefault();
        var id =  $("#id-pre-order").val(),
            cancellation_reason = $("#cancellation_reason").val(),
            $this = $(this);
            let $data = [];
            if(cancellation_reason == null)
            {
                showSwalnotifi(LANG_INVALID_DATA);
                return;
            }
            $this.addClass('button-progress').prop('disabled', true);
           $data.push({ name: 'action', value: 'RemoveDataReserve' });
            $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
            $data.push({ name: 'reserve_id', value: id });
            $data.push({ name: 'cancellation_reason', value: cancellation_reason });
                                        $.ajax({
                                            type: "POST",
                                            url: ajaxurl,
                                            data: $data,
                                            dataType: 'json',
                                            success: function (response) {
                                                $("#delete-pre-order").removeClass('button-progress').prop('disabled', false);
                                                if (response.success) {
                                                    let   reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
                                                    delete reserve_data[id];
                                                    localStorage.setItem('quickqr_reserve', JSON.stringify(reserve_data));
                                                    localStorage.setItem('quickqr_current_reserve_id', '');
                                                    localStorage.setItem('quickqr_reserve_item', '{}');
                                                    $('.reservation-time').hide();
                                                    $('.date-reservation').hide();
                                                    $('.date-notifi').show();
                                                    generateViewReserve();
                                                    generateViewReserveItem();
                                                    if (response.whatsapp_url != '' && response.whatsapp_url != null) {
                                                     location.href = response.whatsapp_url;
                                                    }
                                                }
                                                else
                                                {
                                                    showSwalnotifi(response.message);
                                                }
                                            }
                                        });       
    });

    function genrateViewOrderBookmarks() {
        var order_data = JSON.parse(localStorage.getItem('quickqr_order'));
        var $order_items_wrapper = $('#bookmarks-payment-methoad-cart-content');
        var order_total = 0;
        $order_items_wrapper.html('');
        let action = localStorage.getItem('quickqr_action');
        var $title_tpl = $('<div class="title-cart-content"><h4>Ihre Bestellung</h4><div>');
        $order_items_wrapper.append($title_tpl);
        for (var i in order_data) {
            if (order_data.hasOwnProperty(i)) {
                var order = order_data[i],
                    price = Number(order.item_price),
                    quantity = Number(order.quantity),
                    extras = order.extras,
                    is_order = order.is_order,
                    extra_total = 0;
                var $order_tpl = $('<div class="your-order-item not-border">' +
                    '<div class="menu_detail">' +
                    '<h4 class="menu_post">' +
                    '<span class="menu_title line-height-1-6"></span>' +
                    '<span class="menu_price line-height-1-6"></span>' +
                    '</h4>' +
                    '</div>' +
                    '<div class="menu-data menu-extra-wrapper">' +
                    '</div>' +
                    '</div>');
                var title = (quantity > 1 ? quantity + ' &times; ' : '') + order.item_name;
                $order_tpl.data('cart_id', i);
                $order_tpl.find('.menu_title').html(title);
                $order_tpl.find('.menu_price').html(formatPrice(price * quantity));
                if (is_order == 1) {
                    $order_tpl.find('.cart-meal-edit-button').hide();
                    $order_tpl.find('.item-delete').hide()
                }
                for (var j in extras) {
                    if (extras.hasOwnProperty(j)) {
                        var extra = extras[j],
                            extra_price = Number(extra.price);
                        var $extra_tpl = $('<div class="d-flex menu-extra-item">' +
                            '<span class="extra-item-minus">+</span>' +
                            '<span class="extra-item-title line-height-1-6"></span>' +
                            '<strong class="margin-left-auto extra-item-price line-height-1-6"></strong>' +
                            '</div>');
                        $extra_tpl.data('extra_cart_id', j);
                        $extra_tpl.find('.extra-item-title').html(extra.name);
                        $extra_tpl.find('.extra-item-price').html(formatPrice(extra_price * quantity));
                        extra_total += extra_price;
                        $order_tpl.find('.menu-extra-wrapper').append($extra_tpl);
                    }
                }
                var this_item_total = (extra_total + price) * quantity;
                order_total += this_item_total;
                $order_items_wrapper.append($order_tpl);
            }
        }
        order_total = getTotalSumOrder();
        var $strikethrough_tpl = $('<div class="strikethrough"><div>');
        $order_items_wrapper.append($strikethrough_tpl);
        let text_order_total = '';
        text_order_total = formatPrice(order_total);
        if (action == "delivery-action") {
            var shipping_fee = localStorage.getItem('quickqr_shipping_fee');
            if (shipping_fee.length === 0) {
                shipping_fee = 0;
            }
            var $shipping_fee_tpl = $('<div class="bookmarks_order_shipping_fee"><h4>' +
                LANG_SHIPPING_FEE +
                '<span>' + formatPrice(shipping_fee) +
                '</span></h4><div>');
            $order_items_wrapper.append($shipping_fee_tpl);
        }
        let dDiscountPrice = 0;
        let quickqr_discount_price = localStorage.getItem('quickqr_discount_price');
        if(quickqr_discount_price != '')
        {
         dDiscountPrice = formatPrice(quickqr_discount_price); 
         var $discount_tpl = $('<div class="bookmarks_order_shipping_fee"><h4>' +
         LANG_DISCOUNT +
         '<span>-' + dDiscountPrice +
         '</span></h4><div>');
     $order_items_wrapper.append($discount_tpl);
        }

        var $bookmarks_order_total_tpl = $('<div class="bookmarks_order_total"><h4>' +
            LANG_TOTAL +
            '<span>' + text_order_total +
            '</span></h4><div>');
        $order_items_wrapper.append($bookmarks_order_total_tpl);

    }
    function generateViewReserveItem() {
        let reserve_edit = localStorage.getItem('current_reserve_edit');
        localStorage.setItem('quickqr_discount_price', '');      
        localStorage.setItem('quickqr_discount_code', '');    
        $("#bookmarks_discount_price").html(''); 
        $("#bookmarks_discount_code").html(''); 
        $("#your_order_discount_code").html(''); 
        $("#your_order_discount_price").html(''); 
        let reserve_items_data = JSON.parse(localStorage.getItem('quickqr_reserve_item'));
        let $reserve_wrapper = $('#bookmarks-cart-content'),
            $order_total_selector = $('.next-order-total-text');
        let $bookmarks_order_total_selector = $('.bookmarks-your-order-price');
        let order_total = 0;
        let current_id = String(localStorage.getItem('quickqr_current_reserve_id'));
        $reserve_wrapper.html('');
        let reserve_data = JSON.parse(localStorage.getItem('quickqr_reserve'));
        if (reserve_data[current_id]) {
            let type = reserve_data[current_id]['type'];
            if (type == 'delivery') {
                var $address_tpl = $('<div>' +
                '<h2 class="address_text">' + LANG_ADDRESS  + ': ' + reserve_data[current_id]['address']  +
                '</h2>' +
                '</div>');
                $reserve_wrapper.append($address_tpl);
            }
        let  coupons_code = reserve_data[current_id]['coupons_code'];
        let include_total_discount_value = reserve_data[current_id]['include_total_discount_value'];
        if(coupons_code != null && include_total_discount_value != null  && coupons_code.length > 0 && include_total_discount_value.length > 0)
        {
          
            localStorage.setItem('quickqr_discount_price',include_total_discount_value);      
            localStorage.setItem('quickqr_discount_code', coupons_code); 
            $("#bookmarks_discount_price").html('-' + formatPrice(include_total_discount_value)); 
            $("#your_order_discount_price").html('-' + formatPrice(include_total_discount_value));
            $("#bookmarks_discount_code").html(coupons_code); 
            $("#your_order_discount_code").html(coupons_code);
        }
        }
        for (var i in reserve_items_data) {
            if (reserve_items_data.hasOwnProperty(i)) {
                var reserve = reserve_items_data[i],
                    price = Number(reserve.item_price),
                    quantity = Number(reserve.quantity),
                    extras = reserve.extras,
                    deleted = reserve.deleted,
                    extra_total = 0;
                var $reserve_tpl = $('<div class="your-order-item not-border">' +
                    '<div class="menu_detail">' +
                    '<h4 class="menu_post">' +
                    '<div class="cart-meal-edit-button">' +
                    '<a href="javascript:void(0)" class="item-add"><i class="icon-feather-plus"></i></a>' +
                    '<a href="javascript:void(0)" class="item-remove-one"><i class="icon-feather-minus"></i></a>' +
                    '</div>' +
                    '<span class="menu_title line-height-1-6"></span>' +
                    '<span class="menu_price line-height-1-6"></span>' +
                    '<a href="javascript:void(0)" class="item-delete"><i class="icon-feather-trash-2"></i></a>' +
                    '</h4>' +
                    '</div>' +
                    '<div class="menu-data menu-extra-wrapper">' +
                    '</div>' +
                    '</div>');
                var title = (quantity > 1 ? quantity + ' &times; ' : '') + reserve.item_name;
                $reserve_tpl.data('cart_id', i);
                $reserve_tpl.find('.menu_title').html(title);
                $reserve_tpl.find('.menu_price').html(formatPrice(price * quantity));
                
                if (reserve_edit == "0") {
                    $reserve_tpl.find('.cart-meal-edit-button').hide();
                    $reserve_tpl.find('.item-delete').hide();
                }
                for (var j in extras) {
                    if (extras.hasOwnProperty(j)) {
                        var extra = extras[j],
                            extra_deleted = extra.deleted,
                            extra_price = Number(extra.price);
                        var $extra_tpl = $('<div class="d-flex menu-extra-item">' +
                            '<span class="extra-item-minus">+</span>' +
                            '<span class="extra-item-title line-height-1-8"></span>' +
                            '<strong class="margin-left-auto extra-item-price line-height-1-8"></strong>' +
                            '<a href="javascript:void(0)" class="item-extra-delete"><i class="icon-feather-trash-2 margin-right-5"></i></a>' +
                            '</div>');
                        $extra_tpl.data('extra_cart_id', j);
                        $extra_tpl.find('.extra-item-title').html(extra.name);
                        $extra_tpl.find('.extra-item-price').html(formatPrice(extra_price * quantity));
                        var $extra_delete = $extra_tpl.find('.item-extra-delete');
                        $extra_delete.data('price', extra_price * quantity);
                        $extra_delete.data('key', j);

                        // add envet delete extra
                        $extra_delete.on('click', function () {
                            var cart_key = $(this).closest('.your-order-item').data('cart_id');
                            var extra_cart_key = $(this).closest('.menu-extra-item').data('extra_cart_id');
                          //  delete reserve_items_data[cart_key]['extras'][extra_cart_key];
                            reserve_items_data[cart_key]['extras'][extra_cart_key]['deleted'] = "1";
                            localStorage.setItem('quickqr_reserve_item', JSON.stringify(reserve_items_data));
                            getTotalSumOrder();
                            generateViewReserveItem();
                        });
                        //end add event delete extra
                        if(extra_deleted=="0")
                        {
                            extra_total += extra_price;
                        }    
                        if (reserve_edit == "0") {
                            $extra_tpl.find('.item-extra-delete').hide();
                        }
                        if(extra_deleted == "0")
                        {
                            $reserve_tpl.find('.menu-extra-wrapper').append($extra_tpl);
                        }            
                    }
                }
                var this_item_total = (extra_total + price) * quantity;
                if(deleted == "0")
                {
                    order_total += this_item_total;
                }
                ////////////////////////

                var $add_item = $reserve_tpl.find('.item-add');
                $add_item.on('click', function () {
                    let cart_key = $(this).closest('.your-order-item').data('cart_id');
                    let cart_tpl = $(this).closest('.your-order-item');
                    let item_data = reserve_items_data[cart_key];
                    let extras_data = item_data['extras'];
                    let item_amount = Number(item_data['item_price']);
                    let item_quantity = Number(item_data['quantity']) + 1;
                    let sum_extra_price = 0;
                    for (var j in extras_data) {
                        let extra = extras_data[j];
                        sum_extra_price = sum_extra_price + Number(extra.price);
                    }
                    let item_order_price = formatPrice((item_amount + sum_extra_price) * item_quantity);
                    let title = (item_quantity > 1 ? item_quantity + ' &times; ' : '') + item_data.item_name;
                    cart_tpl.find('.menu_title').html(title);
                    cart_tpl.find('.menu_price').html(formatPrice(item_amount * item_quantity));
                    let menu_extra_wrappe = cart_tpl.find('.menu-extra-wrapper');
                    menu_extra_wrappe.find('.menu-extra-item').each(function () {
                        let extra_cart_key = $(this).data('extra_cart_id');
                        let extra_data = extras_data[extra_cart_key];
                        let extra_amount = Number(extra_data['price']);
                        $(this).find('.extra-item-price').html(formatPrice(extra_amount * item_quantity));
                    });
                    reserve_items_data[cart_key]['quantity'] = item_quantity;
                    reserve_items_data[cart_key]['order_price'] = item_order_price;
                    localStorage.setItem('quickqr_reserve_item', JSON.stringify(reserve_items_data));
                    getTotalSumOrder()
                    generateViewReserveItem();
                    $(".bookmark-reserve-button-group").show();
                });
                //add event remove one items action 
                var $remove_item_one = $reserve_tpl.find('.item-remove-one');
                $remove_item_one.on('click', function () {
                    let cart_key = $(this).closest('.your-order-item').data('cart_id');
                    let cart_tpl = $(this).closest('.your-order-item');
                    let item_data = reserve_items_data[cart_key];
                    let extras_data = item_data['extras'];
                    let item_amount = Number(item_data['item_price']);
                    let item_quantity = Number(item_data['quantity']) - 1;
                    if (item_quantity == 0) {

                        reserve_items_data[cart_key]['deleted'] = "1";
                       // delete reserve_items_data[cart_key];
                        localStorage.setItem('quickqr_reserve_item', JSON.stringify(reserve_items_data));
                        getTotalSumOrder();
                        generateViewReserveItem();
                    }
                    else {
                        let sum_extra_price = 0;
                        for (var j in extras_data) {
                            let extra = extras_data[j];
                            sum_extra_price = sum_extra_price + Number(extra.price);
                        }
                        let item_order_price = formatPrice((item_amount + sum_extra_price) * item_quantity);
                        let title = (item_quantity > 1 ? item_quantity + ' &times; ' : '') + item_data.item_name;
                        cart_tpl.find('.menu_title').html(title);
                        cart_tpl.find('.menu_price').html(formatPrice(item_amount * item_quantity));
                        let menu_extra_wrappe = cart_tpl.find('.menu-extra-wrapper');
                        menu_extra_wrappe.find('.menu-extra-item').each(function () {
                            let extra_cart_key = $(this).data('extra_cart_id');
                            let extra_data = extras_data[extra_cart_key];
                            let extra_amount = Number(extra_data['price']);
                            $(this).find('.extra-item-price').html(formatPrice(extra_amount * item_quantity));
                        });
                        reserve_items_data[cart_key]['quantity'] = item_quantity;
                        reserve_items_data[cart_key]['order_price'] = item_order_price;
                        localStorage.setItem('quickqr_reserve_item', JSON.stringify(reserve_items_data));
                        let total_order = getTotalSumOrder();
                        $order_total_selector.html(formatPrice(total_order));
                        //  checkWidthandSetViewOrderWrapper();
                        $(".bookmark-reserve-button-group").show();
                        generateViewReserveItem();
                    }
                });

                var $delete = $reserve_tpl.find('.item-delete');
                $delete.on('click', function () {
                    var cart_key = $(this).closest('.your-order-item').data('cart_id');
                  //  delete reserve_items_data[cart_key];
                    reserve_items_data[cart_key]['deleted'] = "1";
                    localStorage.setItem('quickqr_reserve_item', JSON.stringify(reserve_items_data));
                    getTotalSumOrder();
                    generateViewReserveItem();
                }); 
                if(deleted=="0")
                {
                    $reserve_wrapper.append($reserve_tpl);
                }                 
            }
        }
        let text_order_total = '';
        let dShippingFee = 0;
        let order_total_not_shipping_fee = order_total;
        let quickqr_discount_price = localStorage.getItem('quickqr_discount_price');
      
        if (reserve_data[current_id]) {
            let type = reserve_data[current_id]['type'];
            if (type == 'delivery') {
                let shipping_fee = reserve_data[current_id]['shipping_fee'];
                dShippingFee = Number(shipping_fee)
                $('.cart-delivery-text span').html(formatPrice(shipping_fee));
                $('.cart-delivery-text').show();
            }
            else        
             {
                $('.cart-delivery-text span').html('');
                $('.cart-delivery-text').hide();
             }
        }
        order_total = order_total + dShippingFee;
        if(quickqr_discount_price != '')
        {
         dDiscountPrice = Number(quickqr_discount_price); 
         order_total = order_total - dDiscountPrice;
         if(order_total < 0)
         {
             order_total = 0;
         }
        }
        text_order_total = formatPrice(order_total );
        $order_total_selector.html(text_order_total);
        $bookmarks_order_total_selector.html(formatPrice(order_total))
        if (order_total == 0 && jQuery.isEmptyObject(reserve_items_data)  == true) {
            $(".basket-empty").show()
            $(".user_discount_code_div").hide();
            $("#bookmarks-cart-content").hide();
            $(".bookmark-reserve-button-group").hide();
            $(".add-item-button").show();
            $(".user_discount_code_div").hide();
            $(".notification_total_amount").hide();
            $.magnificPopup.close();
        }
        else 
        {
            $(".user_discount_code_div").show();
            $(".notification_total_amount").show();
            $(".basket-empty").hide();
            $("#bookmarks-cart-content").show()
            $(".bookmark-reserve-button-group").show();
            $(".user_discount_code_title").show()
        }
        $("#bookmarks-order-button").hide();
        if (reserve_edit == "0") {
            if(quickqr_discount_price.length != 0)
            {
                $(".user_discount_code_div").show();
                $(".user_discount_code_title").hide()
            }
            else
            {   
                 $(".user_discount_code_div").hide();
            }
            $(".edit_delivery").hide();
            $(".bookmark-reserve-button-group").hide();  
        }
   if(order_total_not_shipping_fee < MIN_TOTAL_AMOUNT_PRE_ORDER)
   {
       $("#bookmarks-reserve-button").hide();
       if (order_total_not_shipping_fee == 0 && jQuery.isEmptyObject(reserve_items_data)  == true) {
        $(".notification_total_amount").hide();
     }
     else
     {
        $(".notification_total_amount").show();
     }
   }
   else
   {
    $(".notification_total_amount").hide();
    $("#bookmarks-reserve-button").show();
   }
}
    function generateViewOrder(button_action) {
        var order_data = JSON.parse(localStorage.getItem('quickqr_order'));
        var $order_items_wrapper = $('#your-next-order-items'),
            $order_total_selector = $('.next-order-total-text');
        var $bookmarks_order_total_selector = $('.bookmarks-your-order-price');
        if (button_action == "view-order-button") {
            $order_items_wrapper = $('.your-order-items');
            $order_total_selector = $('.order-total').find('.your-order-price');
        }
        else if (button_action == "add-order-button") {
            $order_items_wrapper = $('#bookmarks-cart-content');
        }
        var order_total = 0;
        $order_items_wrapper.html('');
        var min_next_order = 999;
        let action = localStorage.getItem('quickqr_action');
        let next_order_count = 0;
        // kiểm tra có hiển thị đợt đặt ra không?
        for (var i in order_data) {
            let current_next_order = Number(order_data[i].next_order);
            if (min_next_order > current_next_order) {
                min_next_order = current_next_order;
                next_order_count++;
            }
        }
        if (next_order_count >= 2) {
            bShowNextOrder = true
        }
        var $table_title_tpl = $('<div class="table_title">' +
            '<h2 class="table_number_text">' + LANG_TABLE_NUMBER + ": " + $("#table-number-field").val() +
            '</h2>' +
            '</div>');
        var show_first_next_order = true;
        if (button_action == 'order-button') {
            $order_items_wrapper.append($table_title_tpl);
        }
        for (var i in order_data) {
            if (order_data.hasOwnProperty(i)) {
                var order = order_data[i],
                    price = Number(order.item_price),
                    quantity = Number(order.quantity),
                    extras = order.extras,
                    current_next_order = Number(order.next_order),
                    is_order = order.is_order,
                    date_order = order.date_order,
                    extra_total = 0;
                if (show_first_next_order) {
                    if (is_order == 1) {
                        var $first_next_order_tpl = $('<div class="next_order">' +
                            '<h4 class="next_order_text">' + LANG_NEXT_ORDER + '<p>' + date_order + '</p>' +
                            '</h4>' +
                            '</div>');
                        $order_items_wrapper.append($first_next_order_tpl);
                        show_first_next_order = false;
                    }

                }
                if (current_next_order > min_next_order) {
                    var $next_order_tpl = $('<div class="next_order">' +
                        '<h4 class="next_order_text">' + LANG_NEXT_ORDER + '<p>' + (is_order == 1 ? date_order : '') + '</p>' +
                        '</h4>' +
                        '</div>');
                    $order_items_wrapper.append($next_order_tpl);
                    min_next_order = current_next_order;
                }
                var $order_tpl = $('<div class="your-order-item not-border">' +
                    '<div class="menu_detail">' +
                    '<h4 class="menu_post">' +
                    '<div class="cart-meal-edit-button">' +
                    '<a href="javascript:void(0)" class="item-add"><i class="icon-feather-plus"></i></a>' +
                    '<a href="javascript:void(0)" class="item-remove-one"><i class="icon-feather-minus"></i></a>' +
                    '</div>' +
                    '<span class="menu_title line-height-1-6"></span>' +
                    '<span class="menu_price line-height-1-6"></span>' +
                    '<a href="javascript:void(0)" class="item-delete"><i class="icon-feather-trash-2"></i></a>' +
                    '</h4>' +
                    '</div>' +
                    '<div class="menu-data menu-extra-wrapper">' +
                    '</div>' +
                    '</div>');
                var title = (quantity > 1 ? quantity + ' &times; ' : '') + order.item_name;
                $order_tpl.data('cart_id', i);
                $order_tpl.find('.menu_title').html(title);
                // if(price == 0)
                // {
                //     $order_tpl.find('.menu_price').html('');
                // }
                // else
                // {
                //     $order_tpl.find('.menu_price').html(formatPrice(price * quantity));
                // }

                $order_tpl.find('.menu_price').html(formatPrice(price * quantity));
                if (is_order == 1) {
                    $order_tpl.find('.cart-meal-edit-button').hide();
                    $order_tpl.find('.item-delete').hide()
                }
                for (var j in extras) {
                    if (extras.hasOwnProperty(j)) {
                        var extra = extras[j],
                            extra_price = Number(extra.price);
                        var $extra_tpl = $('<div class="d-flex menu-extra-item">' +
                        '<span class="extra-item-minus">+</span>' +
                            '<span class="extra-item-title line-height-1-8"></span>' +
                            '<strong class="margin-left-auto extra-item-price line-height-1-8"></strong>' +
                            '<a href="javascript:void(0)" class="item-extra-delete"><i class="icon-feather-trash-2 margin-right-5"></i></a>' +
                            '</div>');
                        $extra_tpl.data('extra_cart_id', j);
                        $extra_tpl.find('.extra-item-title').html(extra.name);
                        $extra_tpl.find('.extra-item-price').html(formatPrice(extra_price * quantity));
                        if (is_order == 1) {
                            $extra_tpl.find('.item-extra-delete').hide();
                        }
                        var $extra_delete = $extra_tpl.find('.item-extra-delete');
                        $extra_delete.data('price', extra_price * quantity);
                        $extra_delete.data('key', j);

                        // add envet delete extra
                        $extra_delete.on('click', function () {
                            var cart_key = $(this).closest('.your-order-item').data('cart_id');
                            var extra_cart_key = $(this).closest('.menu-extra-item').data('extra_cart_id');
                            let ordering_type = $("#ordering-type").val();
                            if (ordering_type == 'delivery') {
                                delete order_data[cart_key]['extras'][extra_cart_key];
                                localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                                getTotalSumOrder();
                                generateViewOrder(button_action);
                            }
                            else if (action == "on-table-action") {
                                let $data = [];
                                $data.push({ name: 'action', value: 'RemoveDataOrderTempExtra' });
                                $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
                                $data.push({ name: 'extra_cart_key', value: extra_cart_key });
                                let $btn = $('#submit-order-button');
                                $btn.addClass('button-progress').prop('disabled', true);
                                $('.form-error').slideUp();
                                $.ajax({
                                    type: "POST",
                                    url: ajaxurl,
                                    data: $data,
                                    dataType: 'json',
                                    success: function (response) {
                                        $btn.removeClass('button-progress').prop('disabled', false);
                                        if (response.success) {
                                            $('.form-error').slideUp();
                                            delete order_data[cart_key]['extras'][extra_cart_key];
                                            localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                                            getTotalSumOrder();
                                            generateViewOrder(button_action);
                                        }
                                        else {
                                            $('.form-error').html(response.message).slideDown();
                                        }
                                    }
                                });
                            }
                            else {
                                delete order_data[cart_key]['extras'][extra_cart_key];
                                localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                                getTotalSumOrder();
                                generateViewOrder(button_action);
                            }
                        });
                        //end add event delete extra
                        extra_total += extra_price;
                        $order_tpl.find('.menu-extra-wrapper').append($extra_tpl);
                    }
                }
                var this_item_total = (extra_total + price) * quantity;
                order_total += this_item_total;

                ////////////////////////

                var $add_item = $order_tpl.find('.item-add');
                $add_item.on('click', function () {
                    let cart_key = $(this).closest('.your-order-item').data('cart_id');
                    let cart_tpl = $(this).closest('.your-order-item');
                    let item_data = order_data[cart_key];
                    let extras_data = item_data['extras'];
                    let item_amount = Number(item_data['item_price']);
                    let item_quantity = Number(item_data['quantity']) + 1;
                    let sum_extra_price = 0;
                    for (var j in extras_data) {
                        let extra = extras_data[j];
                        sum_extra_price = sum_extra_price + Number(extra.price);
                    }
                    let item_order_price = formatPrice((item_amount + sum_extra_price) * item_quantity);
                    let title = (item_quantity > 1 ? item_quantity + ' &times; ' : '') + item_data.item_name;
                    cart_tpl.find('.menu_title').html(title);
                    cart_tpl.find('.menu_price').html(formatPrice(item_amount * item_quantity));
                    let menu_extra_wrappe = cart_tpl.find('.menu-extra-wrapper');
                    menu_extra_wrappe.find('.menu-extra-item').each(function () {
                        let extra_cart_key = $(this).data('extra_cart_id');
                        let extra_data = extras_data[extra_cart_key];
                        let extra_amount = Number(extra_data['price']);
                        $(this).find('.extra-item-price').html(formatPrice(extra_amount * item_quantity));
                    });
                    order_data[cart_key]['quantity'] = item_quantity;
                    order_data[cart_key]['order_price'] = item_order_price;
                    if (action == "on-table-action") {
                        let $data = [];
                        let table = localStorage.getItem('quickqr_table');
                        let id_customer = localStorage.getItem('quickqr_id_customer');
                        $data.push({ name: 'action', value: 'pushDataToOrderTemp' });
                        $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
                        $data.push({ name: 'table', value: table });
                        $data.push({ name: 'items', value: JSON.stringify(order_data[cart_key]) });
                        $data.push({ name: 'id_customer', value: id_customer });
                        let $btn = $('#submit-order-button');
                        $btn.addClass('button-progress').prop('disabled', true);
                        $('.form-error').slideUp();
                        $.ajax({
                            type: "POST",
                            url: ajaxurl,
                            data: $data,
                            dataType: 'json',
                            success: function (response) {
                                $btn.removeClass('button-progress').prop('disabled', false);
                                if (response.success) {
                                    $('.form-error').slideUp();
                                    localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                                    getTotalSumOrder()
                                    generateViewOrder(button_action);
                                }
                                else {
                                    $('.form-error').html(response.message).slideDown();
                                }
                            }
                        });
                    }
                    else {
                        localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                        getTotalSumOrder()
                        generateViewOrder(button_action);
                       
                    }
                });
                //add event remove one items action 
                var $remove_item_one = $order_tpl.find('.item-remove-one');
                $remove_item_one.on('click', function () {
                    let cart_key = $(this).closest('.your-order-item').data('cart_id');
                    let cart_tpl = $(this).closest('.your-order-item');
                    let item_data = order_data[cart_key];
                    let extras_data = item_data['extras'];
                    let item_amount = Number(item_data['item_price']);
                    let item_quantity = Number(item_data['quantity']) - 1;
                    if (item_quantity == 0) {
                        let ordering_type = $("#ordering-type").val();
                        if (ordering_type == 'delivery') {
                            delete order_data[cart_key];
                            localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                            getTotalSumOrder();
                            generateViewOrder(button_action);
                        }
                        else if (action == "on-table-action") {
                            let $data = [];
                            let table = localStorage.getItem('quickqr_table');
                            let id_customer = localStorage.getItem('quickqr_id_customer');
                            $data.push({ name: 'action', value: 'RemoveDataToOrderTemp' });
                            $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
                            $data.push({ name: 'table', value: table });
                            $data.push({ name: 'items', value: JSON.stringify(order_data[cart_key]) });
                            $data.push({ name: 'id_customer', value: id_customer });
                            let $btn = $('#submit-order-button');
                            $btn.addClass('button-progress').prop('disabled', true);
                            $('.form-error').slideUp();
                            $.ajax({
                                type: "POST",
                                url: ajaxurl,
                                data: $data,
                                dataType: 'json',
                                success: function (response) {
                                    $btn.removeClass('button-progress').prop('disabled', false);
                                    if (response.success) {
                                        $('.form-error').slideUp();
                                        delete order_data[cart_key];
                                        localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                                        getTotalSumOrder();
                                        generateViewOrder(button_action);
                                    }
                                    else {
                                        $('.form-error').html(response.message).slideDown();
                                    }
                                }

                            });
                        }
                        else {
                            delete order_data[cart_key];
                            localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                            getTotalSumOrder();
                            generateViewOrder(button_action);
                        }

                    }
                    else {
                        let sum_extra_price = 0;
                        for (var j in extras_data) {
                            let extra = extras_data[j];
                            sum_extra_price = sum_extra_price + Number(extra.price);
                        }
                        let item_order_price = formatPrice((item_amount + sum_extra_price) * item_quantity);
                        let title = (item_quantity > 1 ? item_quantity + ' &times; ' : '') + item_data.item_name;
                        cart_tpl.find('.menu_title').html(title);
                        cart_tpl.find('.menu_price').html(formatPrice(item_amount * item_quantity));
                        let menu_extra_wrappe = cart_tpl.find('.menu-extra-wrapper');
                        menu_extra_wrappe.find('.menu-extra-item').each(function () {
                            let extra_cart_key = $(this).data('extra_cart_id');
                            let extra_data = extras_data[extra_cart_key];
                            let extra_amount = Number(extra_data['price']);
                            $(this).find('.extra-item-price').html(formatPrice(extra_amount * item_quantity));
                        });
                        order_data[cart_key]['quantity'] = item_quantity;
                        order_data[cart_key]['order_price'] = item_order_price;
                        if (action == "on-table-action") {
                            let $data = [];
                            let table = localStorage.getItem('quickqr_table');
                            let id_customer = localStorage.getItem('quickqr_id_customer');
                            $data.push({ name: 'action', value: 'pushDataToOrderTemp' });
                            $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
                            $data.push({ name: 'table', value: table });
                            $data.push({ name: 'items', value: JSON.stringify(order_data[cart_key]) });
                            $data.push({ name: 'id_customer', value: id_customer });
                            let $btn = $('#submit-order-button');
                            $btn.addClass('button-progress').prop('disabled', true);
                            $('.form-error').slideUp();
                            $.ajax({
                                type: "POST",
                                url: ajaxurl,
                                data: $data,
                                dataType: 'json',
                                success: function (response) {
                                    $btn.removeClass('button-progress').prop('disabled', false);
                                    if (response.success) {
                                        $('.form-error').slideUp();
                                        localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                                        let total_order = getTotalSumOrder();
                                        let text_order_total = '';
                                        if (button_action == 'order-button') {
                                            text_order_total = LANG_TOTAL + ": " + formatPrice(total_order);
                                        }
                                        else {
                                            text_order_total = formatPrice(total_order);
                                        }
                                        $order_total_selector.html(text_order_total);
                                        $bookmarks_order_total_selector.html(formatPrice(total_order))
                                        generateViewOrder(button_action);
                                    }
                                    else {
                                        $('.form-error').html(response.message).slideDown();
                                    }

                                }

                            });
                        }
                        else {
                            localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                            let total_order = getTotalSumOrder();
                            $order_total_selector.html(formatPrice(total_order));
                            checkWidthandSetViewOrderWrapper();
                            $("#bookmarks-order-button").show();
                            generateViewOrder(button_action);
                        }
                    }
                });

                var $delete = $order_tpl.find('.item-delete');
                $delete.on('click', function () {
                    var cart_key = $(this).closest('.your-order-item').data('cart_id');
                    let ordering_type = $("#ordering-type").val();
                    if (ordering_type == 'delivery') {
                        delete order_data[cart_key];
                        localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                        getTotalSumOrder();
                        generateViewOrder(button_action);
                    }
                    else if (action == "on-table-action") {
                        let $data = [];
                        let table = localStorage.getItem('quickqr_table');
                        let id_customer = localStorage.getItem('quickqr_id_customer');
                        $data.push({ name: 'action', value: 'RemoveDataToOrderTemp' });
                        $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
                        $data.push({ name: 'table', value: table });
                        $data.push({ name: 'items', value: JSON.stringify(order_data[cart_key]) });
                        $data.push({ name: 'id_customer', value: id_customer });
                        let $btn = $('#submit-order-button');
                        $btn.addClass('button-progress').prop('disabled', true);
                        $('.form-error').slideUp();
                        $.ajax({
                            type: "POST",
                            url: ajaxurl,
                            data: $data,
                            dataType: 'json',
                            success: function (response) {
                                $btn.removeClass('button-progress').prop('disabled', false);
                                if (response.success) {
                                    $('.form-error').slideUp();
                                    delete order_data[cart_key];
                                    localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                                    getTotalSumOrder();
                                    generateViewOrder(button_action);
                                }
                                else {
                                    $('.form-error').html(response.message).slideDown();
                                }

                            }

                        });
                    }
                    else {
                        delete order_data[cart_key];
                        localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                        getTotalSumOrder();
                        generateViewOrder(button_action);
                    }
                });
                $order_items_wrapper.append($order_tpl);
            }
        }
        let text_order_total = '';
        let dShippingFee = 0;
        let dDiscountPrice = 0;
        let orderingType = localStorage.getItem('quickqr_action');
        let shipping_fee = localStorage.getItem('quickqr_shipping_fee');
        let quickqr_discount_price = localStorage.getItem('quickqr_discount_price');
        let order_total_not_shipping_fee = order_total;
        let your_order_price = order_total;
       
        if (orderingType == 'delivery-action') {
            if (shipping_fee.length != 0) {
                dShippingFee = Number(shipping_fee)
                order_total = order_total + dShippingFee
            }
        }

        if(quickqr_discount_price != '')
       {
        dDiscountPrice = Number(quickqr_discount_price); 
        your_order_price = your_order_price - dDiscountPrice;
        order_total = order_total - dDiscountPrice;
      
        if(order_total < 0)
        {
            order_total = 0;
        }
     

        if(your_order_price < 0)
        {
            your_order_price = 0;
        }
       }
        if (button_action == 'order-button') {
            text_order_total = LANG_TOTAL + ": " + formatPrice(order_total);
        }
        else {
            text_order_total = formatPrice(order_total);
        }
        $order_total_selector.html(text_order_total);
        $('.your-order-price').html(formatPrice(your_order_price));
        console.log(your_order_price);
        $bookmarks_order_total_selector.html(formatPrice(order_total))
        if (order_total == 0 && jQuery.isEmptyObject(order_data)  == true) {
            $(".basket-empty").show();
            $(".user_discount_code_div").hide();
            $(".notification_total_amount").hide();
            $("#bookmarks-cart-content").hide();
            checkWidthandSetViewOrderWrapper();
            $("#bookmarks-order-button").hide();
            $(".add-item-button").show();
            $.magnificPopup.close();
        }
        else {
            $(".basket-empty").hide();
            $("#bookmarks-cart-content").show();
            $("#bookmarks-order-button").show();
            $(".user_discount_code_div").show();
            $(".notification_total_amount").show();
        }

        if (orderingType == 'delivery-action') {
            if (shipping_fee.length === 0) {
                $('.your-shipping-fee').html('');
                $('.your-order-price-shipping-fee').html('');
                $('#submit-order-button-text').html(LANG_ORDER_FOR_A_FEE);
                $('.cart-delivery-text span').html('')
            }
            else {
                $('.cart-delivery-text span').html(formatPrice(shipping_fee))
            }
        }
        $('.bookmarks_payment_methoad').hide();
        if (orderingType != 'on-table-action') {
            if (button_action != 'add-order-button') {
                generateViewOrder('add-order-button')
            }
        }
        if (order_total == 0 && jQuery.isEmptyObject(order_data)  == true) {
            $("#view-order-wrapper").hide();
        }
        else {
            $("#view-order-wrapper").show();
        }
       
        if (orderingType == 'on-table-action') {       
            $("#w30").css({ "width": "0%", "display": "none" });
            $("#w70").css("width", "100%");
            $('#wrapper_container').css("display","flex");
            $("#bookmarks").removeClass('bookmarks-mobile').addClass('bookmarks');
            $(".bookmarks_payment_methoad").css('display','');
            $("#view-reserve-wrapper").hide();
        }
    
        checkWidthandSetViewOrderWrapper();

        

        if (orderingType == 'on-table-action') { 
            if(order_total_not_shipping_fee < MIN_TOTAL_AMOUNT_ON_TABLE_ORDER)
            {
                $(".notification_total_amount").show();
                $("#submit-order-button").hide();
            }
            else
            {
                $(".notification_total_amount").hide();
                $("#submit-order-button").show();
            }
        }
        else
        {
           if(order_total_not_shipping_fee < MIN_TOTAL_AMOUNT_ONLINE_ORDER)
            {
             $("#bookmarks-order-button").hide();
             $("#submit-order-button").hide();
             if (order_total_not_shipping_fee == 0 && jQuery.isEmptyObject(order_data)  == true) {
                $(".notification_total_amount").hide();
             }
             else
             {
                $(".notification_total_amount").show();
             }
           
            }
            else
            {
                $("#bookmarks-order-button").show();
                $("#submit-order-button").show();
                $(".notification_total_amount").hide();
            }
        }
 
    }
    function confirmNextOrder() {
        let order_data = JSON.parse(localStorage.getItem('quickqr_order'));
        let is_send_next_order = false
        //check còn món chưa được gửi đi? 
        $.each(order_data, function () {
            if (this.is_order == 0) {
                is_send_next_order = true
            }
        });
        if (is_send_next_order) {
            let next_order = localStorage.getItem('quickqr_next_order');
            let id_customer = localStorage.getItem('quickqr_id_customer');
            id_customer = (id_customer ? id_customer : '');
            next_order = (next_order ? parseInt(next_order) : 1);
            var order_temp_data = JSON.parse(localStorage.getItem('quickqr_order')),
                items = [],
                $btn = $(this);
            let $data = [];
            for (var i in order_temp_data) {
                if (order_temp_data.hasOwnProperty(i)) {
                    items.push(order_temp_data[i]);
                }
            }
         //   console.log(order_temp_data);
            $data.push({ name: 'action', value: 'sendRestaurantOrderTemp' });
            $data.push({ name: 'items', value: JSON.stringify(items) });
            $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
            $data.push({ name: 'table', value: $("#table-number-field").val() });
            $data.push({ name: 'next_order', value: next_order });
            $data.push({ name: 'id_customer', value: id_customer });
            $btn.addClass('button-progress').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: $data,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $.each(order_data, function () {
                            if (this.is_order == 0) {
                                this.is_order = 1;
                                this.date_order = response.date_order;
                            }
                        });
                        localStorage.setItem('quickqr_order', JSON.stringify(order_data));
                        localStorage.setItem('quickqr_next_order', Number(response.next_order));
                        swal({
                            title: LANG_SENT_SUCCESSFULLY,
                            type: "success",
                            showCancelButton: false,
                            confirmButtonColor: "var(--classic-color-1)",
                            confirmButtonText: LANG_COMPLETE,
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
        else {
            swal({
                title: LANG_SENT_SUCCESSFULLY,
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "var(--classic-color-1)",
                confirmButtonText: LANG_COMPLETE,
                closeOnConfirm: false,
                closeOnCancel: false
            },
                function (isConfirm) {
                    if (isConfirm) {        
                        swal.close();
                    }
                });
        }
        $.magnificPopup.close();
    }
    if (typeof RESTAURANT_ON_TABLE_ORDER !== 'undefined') {
        if (RESTAURANT_ON_TABLE_ORDER == "1") {
            setInterval(function () { confirm_order(); }, 3000);
        }
    }
    function checkWidthandSetViewOrderWrapper() {
        var windowsize = $window.width();
        var action = localStorage.getItem('quickqr_action');
        var order_data = JSON.parse(localStorage.getItem('quickqr_order'));
        var order_total = getTotalSumOrder();
        if (windowsize >= 1200) {
            $("#view-reserve-wrapper").hide();
            $('#wrapper_container').css("display","flex")
            if (loadPage == false)
            {
                if(bookmarks_payment_methoad_open == false)
                {
                    $(".bookmarks_payment_methoad").css('display','none');
                }            
            }    
            $("#bookmarks").removeClass('bookmarks-mobile').addClass('bookmarks')
            if (action == "delivery-action" || action == "takeaway-action" || action == "reservation-food-action") {
                $("#view-order-wrapper").hide();
                $.magnificPopup.close();
                $("#w30").css({ "width": "30%", "display": "block" })
                $("#w70").css("width", "70%")
            }
            else {
                $("#w30").css({ "width": "0%", "display": "none" })
                $("#w70").css("width", "100%")
                if (order_total == 0) {
                    $("#view-order-wrapper").hide();
                }
                else {
                    $("#view-order-wrapper").show();
                }
            }
        }
        else {
            if(action == "reservation-food-action")
            {
                $(".bookmarks_payment_methoad").css('display','none');
                $("#w30").css({ "width": "100%", "display": "block" });
                $("#w70").css("width", "100%");
                $('#wrapper_container').css( "flex-wrap","wrap");
                $("#bookmarks").removeClass('bookmarks').addClass('bookmarks-mobile');        
                $("#view-order-wrapper").hide();
                $("#view-reserve-wrapper").show();
              
            }
            else
            {
                if (order_total == 0 && jQuery.isEmptyObject(order_data)  == true) {
                    $("#view-order-wrapper").hide();
                }
                else {
                    $("#view-order-wrapper").show();
                }
                $("#w30").css({ "width": "0%", "display": "none" });
                $("#w70").css("width", "100%");
                $('#wrapper_container').css("display","flex");
                $("#bookmarks").removeClass('bookmarks-mobile').addClass('bookmarks');
                if(bookmarks_payment_methoad_open == false)
                {
                    $(".bookmarks_payment_methoad").css('display','none');
                }
                $("#view-reserve-wrapper").hide();
            }
          
        }
    }
      // Execute on load
      checkWidthandSetViewOrderWrapper();
      loadPage = false
      // Bind event listener
      $(window).resize(checkWidthandSetViewOrderWrapper);

    function validateEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    // get all the order notifications
    // var audioogg = new Audio(siteurl+'includes/assets/audio/message.ogg');
    //  var audiomp3 = new Audio(siteurl+'includes/assets/audio/message.mp3');
})(jQuery);
