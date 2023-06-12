jQuery(function ($) {

    // email resend
    $('.resend').on('click', function (e) { 						// Button which will activate our modal
        var the_id = $(this).attr('id');						//get the id
        // show the spinner
        $(this).html("<i class='fa fa-spinner fa-pulse'></i>");
        $.ajax({											//the main ajax request
            type: "POST",
            data: "action=email_verify&id=" + $(this).attr("id"),
            url: ajaxurl,
            success: function (data) {
                $("span#resend_count" + the_id).html(data);
                //fadein the vote count
                $("span#resend_count" + the_id).fadeIn();
                //remove the spinner
                $("a.resend_buttons" + the_id).remove();

            }
        });
        return false;
    });

    // user login
    $("#login-form").on('submit', function (e) {
        e.preventDefault();
        $("#login-status").slideUp();
        $('#login-button').addClass('button-progress').prop('disabled', true);
        var form_data = {
            action: 'ajaxlogin',
            username: $("#username").val(),
            password: $("#password").val(),
            is_ajax: 1
        };
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: form_data,
            dataType: 'json',
            success: function (response) {
                $('#login-button').removeClass('button-progress').prop('disabled', false);
                if (response.success) {
                    $("#login-status").addClass('success').removeClass('error').html('<p>' + LANG_LOGGED_IN_SUCCESS + '</p>').slideDown();
                    window.location.href = response.message;
                }
                else {
                    $("#login-status").removeClass('success').addClass('error').html('<p>' + response.message + '</p>').slideDown();
                }
            }
        });
        return false;
    });

    // blog comment with ajax
    $('.blog-comment-form').on('submit', function (e) {
        e.preventDefault();
        var action = 'submitBlogComment';
        var data = $(this).serialize();
        var $parent_cmnt = $(this).find('#comment_parent').val();
        var $cmnt_field = $(this).find('#comment-field');
        var $btn = $(this).find('.button');
        $btn.addClass('button-progress').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: ajaxurl + '?action=' + action,
            data: data,
            dataType: 'json',
            success: function (response) {
                $btn.removeClass('button-progress').prop('disabled', false);
                if (response.success) {
                    if ($parent_cmnt == 0) {
                        $('.latest-comments > ul').prepend(response.html);
                    } else {
                        $('#li-comment-' + $parent_cmnt).after(response.html);
                    }
                    $('html, body').animate({
                        scrollTop: $("#li-comment-" + response.id).offset().top
                    }, 2000);
                    $cmnt_field.val('');
                } else {
                    $('#respond > .widget-content').prepend('<div class="notification error"><p>' + response.error + '</p></div>');
                }
            }
        });
    });

    // get all the order notifications
    var audioogg = new Audio(siteurl + 'includes/assets/audio/message.ogg');
    var audiomp3 = new Audio(siteurl + 'includes/assets/audio/message.mp3');

    // qr-pre-order-orders-table
    // qr-delivery-takeaway-orders-table	
    // qr-on-table-orders-table
    
    function prependTableOrderReserve(order) {
        let table_number = '';
   
        if ($('#qr-pre-order-orders-table').length) {
            if (order.type == 'takeaway')
            table_number = LANG_TAKEAWAY;
        else if (order.type == 'delivery')
            table_number = LANG_DELIVERY;

       var $row = null;
            $row = $('<tr class="row-highlight row-pre-order-orders" data-id="'+  order.id +'">' +
            '<td data-label="' + LANG_ID + '">' +
            order.id +
            '</td>' +
            '<td data-label="' + LANG_ORDER_2 + '"> <span class="small-label margin-left-0">' +
            table_number +
            '</span></td>' +
            '<td data-label="' + LANG_TIME + '"><small>' + order.created_at + '</small></td>' +
            '<td data-label="' + LANG_TAKEAWAY_DELIVERY + '"><small class="color-classic-color-1">' + order.date_reserve + '</small></td>' +           
            '<td data-label="' + LANG_CUSTOMER + '" class="width-30">' +
            '<div class="d-flex align-items-center">' +
            '<i class="icon-feather-user"></i>&nbsp;' + order.customer_name +
            (order.message != '' && order.message != null
                ? '<span class="button gray ico margin-left-5 order-row-message" data-tippy-placement="top" title="' + order.message + '"><i class="icon-feather-message-square"></i></span>'
                : '') +
            '</div>' +
            (order.phone_number != '' && order.phone_number != null
                ? '<div><i class="icon-feather-phone"></i> ' + order.phone_number + '</div>'
                : '') +
            (order.email != '' && order.email != null
                ? '<div><i class="icon-material-outline-email"></i> ' + order.email + '</div>'
                : '') +
            (order.address != '' && order.address != null
                ? '<span><i class="icon-feather-map-pin"></i> ' + order.address + '</span>'
                : '') +
            '</td>' +
            '<td data-label="' + LANG_PRICE + '">' +
            '<span class="small-label margin-left-0">' +
            order.price +
            '</span>' +
            '</td>' +
            '<td data-label="' + LANG_STATUS + '" class="order-row-status">' +
            '<span class="button gray ico order-status" data-tippy-placement="top" title="' + LANG_PENDING + '"><i class="icon-feather-clock"></i></span>' +
            '</td>' +
            '<td class="padding-bottom-15">' +
            '<button class="button ico qr-complete-order" data-tippy-placement="top" title="' + LANG_COMPLETE + '" data-id="' + order.id + '"><i class="icon-feather-check"></i></button>' +
            ' <button class="button red ico qr-delete-order" data-tippy-placement="top" title="' + LANG_DELETE + '" data-price="'+ order.price_number + '" data-id="' + order.id + '"><i class="icon-feather-trash-2"></i></button>' +
            ' <button class="button green ico qr-view-order" data-tippy-placement="top" title="' + LANG_VIEW_ORDER + '" data-id="' + order.id + '"><i class="icon-feather-eye"></i></button>' +
            '<div class="order-print-tpl-' + order.id + ' d-none">' +
            order.order_print_tpl +
            '</div>' +
            '</td>' +
            '</tr>');
            $('#qr-pre-order-orders-table').prepend($row);
            let price_total_pre = Number($('.sum-total-order').data('price-total'));
            let price = Number(order.price_number)
            let price_total = price_total_pre + price
            $('.sum-total-order span').html(formatPrice(price_total))
            $('.sum-total-order').data('price-total',price_total);
        } 
     
                   
    }
    function prependTable(order) {
        let table_number = '';
       var $row = null;
       if(order.type != 'on-table')
       {
        if ($('#qr-delivery-takeaway-orders-table').length) {
            if (order.type == 'takeaway')
            table_number = LANG_TAKEAWAY;
        else if (order.type == 'delivery')
            table_number = LANG_DELIVERY;

            $row = $('<tr class="row-delivery-takeaway-orders row-highlight" data-id="'+ order.id +'" >' +
            '<td data-label="' + LANG_ID + '">' +
            order.sid +
            '</td>' +
            '<td data-label="' + LANG_ORDER_2 + '"> <span class="small-label margin-left-0">' +
            table_number +
            '</span></td>' +
            '<td data-label="' + LANG_TIME + '"><small>' + order.created_at + '</small></td>' +
            '<td data-label="' + LANG_TAKEAWAY_DELIVERY + '"><small class="color-classic-color-1">' + order.takeaway_delivery_time + '</small></td>' +
            '<td data-label="' + LANG_CUSTOMER + '" class="width-30">' +
            '<div>' +
            '<i class="icon-feather-user"></i>&nbsp;' + order.customer_name +
            (order.message != '' && order.message != null
                ? '<span class="button gray ico margin-left-5 order-row-message" data-tippy-placement="top" title="' + order.message + '"><i class="icon-feather-message-square"></i></span>'
                : '') +
            '</div>' +
            (order.phone_number != '' && order.phone_number != null
                ? '<div><i class="icon-feather-phone"></i> ' + order.phone_number + '</div>'
                : '') +
            (order.email != '' && order.email != null
                ? '<div><i class="icon-material-outline-email"></i> ' + order.email + '</div>'
                : '') +
            (order.address != '' && order.address != null
                ? '<span><i class="icon-feather-map-pin"></i> ' + order.address + '</span>'
                : '') +
            '</td>' +
            '<td data-label="' + LANG_PRICE + '">' +
            '<span class="small-label margin-left-0">' +
            order.price +
            '</span>' +
            '</td>' +
            '<td data-label="' + LANG_STATUS + '" class="order-row-status">' +
            '<span class="button gray ico order-status" data-tippy-placement="top" title="' + LANG_PENDING + '"><i class="icon-feather-clock"></i></span>' +
            '</td>' +
            '<td class="padding-bottom-15">' +
            '<button class="button ico qr-complete-order" data-tippy-placement="top" title="' + LANG_COMPLETE + '" data-id="' + order.id + '"><i class="icon-feather-check"></i></button>' +
            ' <button class="button red ico qr-delete-order" data-tippy-placement="top" title="' + LANG_DELETE + '" data-price="'+ order.price_number + '" data-id="' + order.id + '"><i class="icon-feather-trash-2"></i></button>' +
            ' <button class="button green ico qr-view-order" data-tippy-placement="top" title="' + LANG_VIEW_ORDER + '" data-id="' + order.id + '"><i class="icon-feather-eye"></i></button>' +
            '<div class="order-print-tpl-' + order.id + ' d-none">' +
            order.order_print_tpl +
            '</div>' +
            '</td>' +
            '</tr>');
            $('#qr-delivery-takeaway-orders-table').prepend($row);
            let price_total_pre = Number($('.sum-total-order').data('price-total'));
            let price = Number(order.price_number);
            let price_total = price_total_pre + price;
            $('.sum-total-order span').html(formatPrice(price_total))
            $('.sum-total-order').data('price-total',price_total);
        }      
       }
       else
       {
        if ($('#qr-on-table-orders-table').length) {
            table_number = order.table_number;
            $row = $('<tr class="row-on-table-orders row-highlight" data-id="'+ order.id +'">' +
            '<td data-label="' + LANG_ID + '">' +
            order.sid +
            '</td>' +
            '<td data-label="' + LANG_TABLE + '">' +
            table_number +
            '</td>' +
            '<td data-label="' + LANG_TIME + '"><small>' + order.created_at + '</small></td>' +
            '<td data-label="' + LANG_MESSAGE + '">' +
            order.message +
            '&nbsp;</td>' +
            '<td data-label="' + LANG_PRICE + '">' +
            '<span class="small-label margin-left-0">' +
            order.price +
            '</span>' +
            '</td>' +
            '<td data-label="' + LANG_STATUS + '" class="order-row-status">' +
            '<span class="button gray ico order-status" data-tippy-placement="top" title="' + LANG_PENDING + '"><i class="icon-feather-clock"></i></span>' +
            '</td>' +
            '<td class="padding-bottom-15">' +
            '<button class="button ico qr-complete-order" data-tippy-placement="top" title="' + LANG_COMPLETE + '" data-id="' + order.id + '"><i class="icon-feather-check"></i></button>' +
            ' <button class="button red ico qr-delete-order" data-tippy-placement="top" title="' + LANG_DELETE + '" data-price="'+ order.price_number + '" data-id="' + order.id + '"><i class="icon-feather-trash-2"></i></button>' +
            ' <button class="button green ico qr-view-order" data-tippy-placement="top" title="' + LANG_VIEW_ORDER + '" data-id="' + order.id + '"><i class="icon-feather-eye"></i></button>' +
            '<div class="order-print-tpl-' + order.id + ' d-none">' +
            order.order_print_tpl +
            '</div>' +
            '</td>' +
            '</tr>');
            $('#qr-on-table-orders-table').prepend($row);
            let price_total_pre = Number($('.sum-total-order').data('price-total'));
            let price = Number(order.price_number)
            let price_total = price_total_pre + price
            $('.sum-total-order span').html(formatPrice(price_total))
            $('.sum-total-order').data('price-total',price_total);
        }     
       }            
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
    function get_orders() {
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                action: 'getOrders'
            },
            dataType: 'json',
            success: function (response) {
                if (!jQuery.isEmptyObject(response)) {
                        for (var i in response) {
                            if (response.hasOwnProperty(i)) {
                                var order = response[i];
                                prependTable(order);
                            }
                        }
                        $('.no-order-found').remove();             
                    if (localStorage.notification_sound == 1) {
                        audiomp3.play();
                        audioogg.play();
                    }

                    setTimeout(function () {
                        $('.row-highlight').removeClass("row-highlight");
                    }, 1000);
                }
            }
        });
    }
    function get_orders_reserve()
    {
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                action: 'getOrdersReserve'
            },
            dataType: 'json',
            success: function (response) {
                if (!jQuery.isEmptyObject(response)) {
                        for (var i in response) {
                            if (response.hasOwnProperty(i)) {
                                var order = response[i];
                                prependTableOrderReserve(order);
                            }
                        }

                        $('.no-order-found').remove();
                
                    if (localStorage.notification_sound == 1) {
                        audiomp3.play();
                        audioogg.play();
                    }

                    setTimeout(function () {
                        $('.row-highlight').removeClass("row-highlight");
                    }, 1000);

                }
            }
        });
    }
    setInterval(function () { get_orders(); }, 5000);
    setInterval(function () { get_orders_reserve(); }, 5000);
});