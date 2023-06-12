$(document).on('click', ".add-cat", function (e) {
    e.preventDefault();

    $('#cat-edit-id').val('');
    $('#category_name').val('');
    $('#title_popup_category').html(LANG_ADD_SERVICE_GROUP);
    $("#category-status").hide();
    $.magnificPopup.open({
        items: {
            src: '#add-category',
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
function CurrencyFormatted(amount) {
    if (!amount) {
        amount = "0";
    }
    if (isNaN(amount) == false) {
        var sTemp = amount.replace(".", "").replace(",", "");

        var dNum = parseFloat(sTemp).toFixed(2) / 100
        dNum = dNum.toFixed(2);
        return dNum;
    }
    else {
        // return amount.substr(0, amount.length - 1)
        dNum = 0;
        dNum = dNum.toFixed(2);
        // return  amount.substr(0, amount.length - 1)
        return dNum;
    }
}


$(document).on('click', ".edit-cat", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $('#cat-edit-id').val($(this).data('catid'));
    $('#category_name').val($(this).closest('.dashboard-box').find('.category-display-name').html());
    $('#title_popup_category').html(LANG_EDIT_SERVICE_GROUP);
    $("#category-status").hide();
    $.magnificPopup.open({
        items: {
            src: '#add-category',
            type: 'inline',
            fixedContentPos: false,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            preloader: false,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
        },
        callbacks:{
            open : function(){
                setTimeout(function(){$('#category_name').focus();}, 100);
            }
        }
    });
});

$("#save-category").on('click', function (e) {
    e.stopPropagation();
    e.preventDefault();

    var id = $("#cat-edit-id").val();

    var form_data = {
        action: 'addNewCat',
        name: $("#category_name").val()
    };

    if (id) {
        form_data['id'] = id;
        form_data['action'] = 'editCat';
    }

    try{
    $('#save-category').addClass('button-progress').prop('disabled', true);
    $.ajax({
        type: "POST",
        url: ajaxurl,
        data: form_data,
        dataType: 'json',
        success: function (response) {
           
            if (response.success) {
                $("#category-status").addClass('success').removeClass('error').html('<p>' + response.message + '</p>').slideDown();
                location.reload();
            }
            else {
                $("#category-status").removeClass('success').addClass('error').html('<p>' + response.message + '</p>').slideDown();
            }
            $('#save-category').removeClass('button-progress').prop('disabled', false);
        }
    });
    }catch(e){
        console.log(e.message);
    }
    return false;
});

$(document).on('click', ".add_sub_cat_item", function (e) {
    e.preventDefault();

    $('#cat-id').val($(this).data('catid'));
    $('#sub-cat-id').val('');
    $('#sub_category_name').val('');
    $('#title_popup_sub_category').html(LANG_ADD_SUB_SERVICE_GROUP);

    $.magnificPopup.open({
        items: {
            src: '#add-sub-category',
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

$(document).on('click', ".edit-sub-cat", function (e) {
    e.preventDefault();
    e.stopPropagation();

    $('#cat-id').val($(this).data('catid'));
    $('#sub-cat-id').val($(this).data('subcatid'));
    $('#sub_category_name').val($(this).closest('.dashboard-box').find('.sub-category-display-name').html());
    $('#title_popup_sub_category').html(LANG_EDIT_SUB_SERVICE_GROUP);

    $.magnificPopup.open({
        items: {
            src: '#add-sub-category',
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

$("#save-sub-category").on('click', function (e) {
    e.stopPropagation();
    e.preventDefault();

    var id = $("#sub-cat-id").val();

    var form_data = {
        action: 'addNewSubCat',
        cat_id: $('#cat-id').val(),
        name: $("#sub_category_name").val()
    };

    if (id) {
        form_data['id'] = id;
        form_data['action'] = 'editSubCat';
    }

    $('#save-sub-category').addClass('button-progress').prop('disabled', true);
    $.ajax({
        type: "POST",
        url: ajaxurl,
        data: form_data,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                $("#category-status").addClass('success').removeClass('error').html('<p>' + response.message + '</p>').slideDown();
                location.reload();
            }
            else {
                $("#category-status").removeClass('success').addClass('error').html('<p>' + response.message + '</p>').slideDown();
            }
            $('#save-sub-category').removeClass('button-progress').prop('disabled', false);
        }
    });
    return false;
});

$(document).on('click', ".copy_menu_item", function(e){
    e.preventDefault();
    e.stopPropagation();
    var id = $(this).data('id');
   location.href = 'edit-service?menu_id=' + id + '&type=copy';
})
$(document).on('click', ".edit_menu_item", function (e) {
    e.preventDefault();
    e.stopPropagation();
    var id = $(this).data('id');
    location.href = 'edit-service?menu_id=' + id;
    // $('#image_upload').val('');
    // $('#cat_id').val($(this).data('catid'));
    // $("#add-item-status").slideUp();
              
    // $this.addClass('button-progress').prop('disabled', true);
    // $.ajax({
    //     type: "POST",
    //     url: ajaxurl + '?action=get_item&id=' + id,
    //     dataType: 'json',
    //     success: function (response) {
    //         // console.log(response);
    //         if (response.success) {
    //             $('#menu-id').val(id);
    //             $('#menu-item-name').val(response.name);
    //             $('#menu-item-description').val(response.description);
    //             $('#menu_item_id').val(response.menu_res_id);
    //             $('#menu-item-price').val(response.price);
    //             $('#menu-item-type').val(response.type).trigger('change');
    //             $('#menu-item-service-department').val(response.service).trigger('change');
    //             $('#menu-item-image').attr('src', response.image);
    //             $('#menu-item-available').prop('checked', response.active == 1);
    //             $('#menu-item-view-image').prop('checked', response.display_image == 1);
    //             $('#menu-item-discount-price').val(response.discount_price);
    //             $('#menu-item-is-discount').prop('checked', response.is_discount == 1);
    //             $('#menu-item-new').prop('checked', response.is_new_food == 1);

              
    //             if (response.is_discount == 1) 
    //             {   
    //             $('#menu-item-discount-price').removeAttr("disabled");
    //             $('#menu-item-discount-price').val(response.discount_price);
    //             }
    //             else
    //             {
    //             $('#menu-item-discount-price').attr('disabled', 'disabled');
    //             $('#menu-item-discount-price').val('');
    //             }

    //             if (response.Allegie_tlp) {
    //                 $('.allegie_group').css('display', 'block');
    //                 $('#menu-item-Allegie').html(response.Allegie_tlp);
    //             }
    //             else {
    //                 $('.allegie_group').css('display', 'none');
    //             }
    //             $('#title_popup_item').html(LANG_EDIT_ITEM);
    //             $.magnificPopup.open({
    //                 items: {
    //                     src: '#add_menu_item_dialog',
    //                     type: 'inline',
    //                     fixedContentPos: false,
    //                     fixedBgPos: true,
    //                     overflowY: 'auto',
    //                     closeBtnInside: true,
    //                     preloader: false,
    //                     midClick: true,
    //                     removalDelay: 300,
    //                     mainClass: 'my-mfp-zoom-in'
    //                 }
    //             });
    //         }
    //         $this.removeClass('button-progress').prop('disabled', false);
    //     }
    // });
});

$(document).on('click', ".add_menu_item", function (e) {
    e.stopPropagation();
    e.preventDefault();
    let car_id = $(this).data('catid');
    location.href = 'edit-service?cat_id=' + car_id;
    // $('#image_upload').val('');
    // $.ajax({
    //     type: "POST",
    //     url: ajaxurl + '?action=get_allegie',
    //     dataType: 'json',
    //     success: function (response) {
    //         if (response.Allegie_tlp) {
    //             $('.allegie_group').css('display', 'block');
    //             $('#menu-item-Allegie').html(response.Allegie_tlp);
    //         }
    //         else {
    //             $('.allegie_group').css('display', 'none');
    //         }
    //     }
    // });
    // $("#add-item-status").slideUp();
    // $('#cat_id').val($(this).data('catid'));
    // $('#menu-id').val('');
    // $('#menu-item-name').val('');
    // $('#menu-item-description').val('');
    // $('#menu_item_id').val('');
    // $('#menu-item-price').val('');
    // $('#menu-item-type').val('veg').trigger('change');
    // $('#menu-item-service-department').val('kitchen').trigger('change');
    // $('#menu-item-image').attr('src', SITE_URL + 'storage/restaurant/logo/default.png');
    // $('#menu-item-available').prop('checked', true);
    // $('#menu-item-view-image').prop('checked', false);
    // $('#menu-item-discount-price').val('');
    // $('#menu-item-is-discount').prop('checked', false);
    // $('#menu-item-new').prop('checked', true);
    // $('#menu-item-discount-price').attr('disabled', 'disabled');
    // $('#title_popup_item').html(LANG_ADD_NEW_ITEM);
    // $.magnificPopup.open({
    //     items: {
    //         src: '#add-category',
    //         type: 'inline',
    //         fixedContentPos: false,
    //         fixedBgPos: true,
    //         overflowY: 'auto',
    //         closeBtnInside: true,
    //         preloader: false,
    //         midClick: true,
    //         removalDelay: 300,
    //         mainClass: 'my-mfp-zoom-in'
    //     }
    // });
});

$(document).on('click', ".delete_menu_item", function (e) {
    e.preventDefault();
    e.stopPropagation();

    var id = $(this).data('id'),
        $this = $(this);

    $(this).confirm(LANG_ARE_YOU_SURE, function(){
        $this.addClass('button-progress').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: ajaxurl + '?action=delete_item&id=' + id,
            dataType: 'json',
            success: function (response) {
                $this.removeClass('button-progress').prop('disabled', false);
                if (response.success) {
                    $this.closest('.dashboard-box').remove();
                }
                Snackbar.show({
                    text: response.message,
                    pos: 'bottom-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#383838'
                });
            }
        });
    });
});

$(document).on('click', ".delete-cat", function (e) {
    e.preventDefault();
    e.stopPropagation();

    var id = $(this).data('catid');
    var $this = $(this);

    $(this).confirm(LANG_ARE_YOU_SURE, function(){
        $this.addClass('button-progress').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                action: 'deleteCat',
                id: id
            },
            dataType: 'json',
            success: function (response) {
                $this.removeClass('button-progress').prop('disabled', false);
                if (response.success) {
                    console.log(response);
                    $this.closest('.dashboard-box').remove();
                }
                Snackbar.show({
                    text: response.message,
                    pos: 'bottom-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#383838'
                });
            }
        });
    });
    return false;
});

$(document).on('click', ".delete-sub-cat", function (e) {
    e.preventDefault();
    e.stopPropagation();

    var id = $(this).data('subcatid'),
        $this = $(this);
    
    $(this).confirm(LANG_ARE_YOU_SURE, function(){
        $this.addClass('button-progress').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                action: 'deleteSubCat',
                id: id
            },
            dataType: 'json',
            success: function (response) {                
                $this.removeClass('button-progress').prop('disabled', false);
                if (response.success) {
                    $this.closest('.dashboard-box').remove();
                }
                Snackbar.show({
                    text: response.message,
                    pos: 'bottom-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#383838'
                });
            }
        });
    });
});



var $categories = $('#menu-categories');
$categories.sortable({
    //helper : fixHelper,
    axis: 'y',
    handle: '.quickad-js-handle',
    update: function (event, ui) {
        var data = [];
        $categories.children('div').each(function () {
            data.push($(this).data('catid'));
        });
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: { action: 'updateCatPosition', position: data },
            success: function (response, textStatus, jqXHR) {
                Snackbar.show({
                    text: response.message,
                    pos: 'bottom-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#383838'
                });
            }
        });
    }
});

$('.menu-subcategories').sortable({
    //helper : fixHelper,
    axis: 'y',
    handle: '.quickad-js-handle',
    update: function (event, ui) {
        var data = [];
        $('.menu-subcategories').children('div').each(function () {
            data.push($(this).data('subcatid'));
        });
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: { action: 'updateSubCatPosition', position: data },
            success: function (response, textStatus, jqXHR) {
                Snackbar.show({
                    text: response.message,
                    pos: 'bottom-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#383838'
                });
            }
        });
    }
});

$('.cat-menu-items').sortable({
    //helper : fixHelper,
    axis: 'y',
    handle: '.quickad-js-handle',
    update: function (event, ui) {
        var data = [];
        $(this).children('div').each(function () {
            data.push($(this).data('menuid'));
        });
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: { action: 'updateMenuPosition', position: data },
            success: function (response, textStatus, jqXHR) {
                Snackbar.show({
                    text: response.message,
                    pos: 'bottom-center',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#383838'
                });
            }
        });
    }
});

$('input:checkbox[id="menu-item-is-discount"]').change(
    function(){
        if ($(this).is(':checked')) 
        {   
        $('#menu-item-discount-price').removeAttr("disabled");
        }
        else
        {
        $('#menu-item-discount-price').attr('disabled', 'disabled');
        }

    });