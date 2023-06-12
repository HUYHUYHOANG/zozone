jQuery(function ($) {
    var $notification_sound = $('.order-notification-sound');
    var audioogg = new Audio(siteurl+'includes/assets/audio/message.ogg');
    var audiomp3 = new Audio(siteurl+'includes/assets/audio/message.mp3');
    //localStorage.notification_sound = localStorage.notification_sound || 1;
    localStorage.notification_sound = 0;
    if(localStorage.notification_sound == 1){
        $notification_sound.html('<i class="icon-feather-volume-2"></i>');
    }else{
        $notification_sound.html('<i class="icon-feather-volume-x"></i>');
    }
    // complete order
    $(document).on('click','.qr-complete-order', function(e) {
        e.preventDefault();
        var id = $(this).data('id'),
            $this = $(this);

        $this.addClass('button-progress').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                action: 'completeOrderReserve',
                id: id
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $this.closest('tr').find('.order-status')
                        .removeClass('gray').addClass('green')
                        .attr('title',LANG_COMPLETE)
                        .html('<i class="icon-feather-check"></i>');
                      
                }
                $this.removeClass('button-progress').prop('disabled', false);
            }
        });
    });
    
    $(document).on('click','#delete-pre-order', function(e) {
        e.preventDefault();
        var id =  $("#id-pre-order").val(),
            cancellation_reason = $("#cancellation_reason").val(),
            $this = $(this);
            $this.addClass('button-progress').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    action: 'deleteOrderReserve',
                    id: id,
                    cancellation_reason: cancellation_reason
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {

                        if (response.whatsapp_url != '' && response.whatsapp_url != null) {
                            // send to whatsapp
                            location.href = response.whatsapp_url;
                        }
                        else
                        {
                            location.reload();
                        }
                    //     $this.closest('tr').find('.qr-complete-order').css('display','none');
                    //   //  $this.closest('tr').remove();
                    //   $this.closest('tr').find('.order-status')
                    //   .removeClass('gray').removeClass('green').addClass('red')
                    //   .attr('title',LANG_DELETED)
                    //   .html('<i class="icon-feather-trash-2"></i>');
                    //   let price_total_pre = $('.sum-total-order').data('price-total');
                    //   let price_total = price_total_pre - price
                    //   $('.sum-total-order span').html(formatPrice(price_total))
                    //   $('.sum-total-order').data('price-total',price_total);
                     }
                     $this.removeClass('button-progress').prop('disabled', false);
                    // $this.css('display','none');
                }
            });
        
    });
    // delete order
    $(document).on('click','.qr-delete-order', function(e) {
        e.preventDefault();
        var id = $(this).data('id'),
            price = $(this).data('price'),
            $this = $(this);
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

            // $this.addClass('button-progress').prop('disabled', true);
            // $.ajax({
            //     type: "POST",
            //     url: ajaxurl,
            //     data: {
            //         action: 'deleteOrderReserve',
            //         id: id
            //     },
            //     dataType: 'json',
            //     success: function (response) {
            //         if (response.success) {
            //             $this.closest('tr').find('.qr-complete-order').css('display','none');
            //           //  $this.closest('tr').remove();
            //           $this.closest('tr').find('.order-status')
            //           .removeClass('gray').removeClass('green').addClass('red')
            //           .attr('title',LANG_DELETED)
            //           .html('<i class="icon-feather-trash-2"></i>');
            //           let price_total_pre = $('.sum-total-order').data('price-total');
            //           let price_total = price_total_pre - price
            //           $('.sum-total-order span').html(formatPrice(price_total))
            //           $('.sum-total-order').data('price-total',price_total);
            //         }
            //         $this.removeClass('button-progress').prop('disabled', false);
            //         $this.css('display','none');
            //     }
            // });
        
    });
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

    // view order
    $(document).on('click','.qr-view-order', function(e) {
        e.preventDefault();
        var id = $(this).data('id'),
            $this = $(this);

        $('#order-print-content').html($('.order-print-tpl-'+id).html());

        $.magnificPopup.open({
            items: {
                src: '#view-order',
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

    // mute notification
    $(document).on('click','.order-notification-sound', function(e) {
        e.preventDefault();
        console.log(localStorage.notification_sound);
        if(localStorage.notification_sound == 1){
            localStorage.notification_sound = 0;
            $notification_sound.html('<i class="icon-feather-volume-x"></i>');
        }else{
            localStorage.notification_sound = 1;
            $notification_sound.html('<i class="icon-feather-volume-2"></i>');
            audiomp3.play();
            audioogg.play();
        }
    });

    // print order
    $(document).on('click','.order-print-button', function(e) {
        var mywindow = window.open('', 'qr_print', 'height=500,width=300');
        mywindow.document.write('<html><head><title>Print</title>');
        mywindow.document.write('<link rel="stylesheet" href="'+siteurl+'templates/'+template_name+'/css/style.css?ver={VERSION}" type="text/css" />');
        mywindow.document.write('</head><body><div class="order-print">');
        mywindow.document.write($('.order-print').html());
        mywindow.document.write('</div></body></html>');
        mywindow.print();
        mywindow.close();
        return true;
    });
});