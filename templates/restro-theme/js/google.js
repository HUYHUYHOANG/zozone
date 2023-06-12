
var placeSearch, autocomplete,autocomplete2,bookmarks_autocomplete;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
};
function initAutocomplete() {
    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById('address-field'), {
        types: ['geocode']
    });
    autocomplete2 = new google.maps.places.Autocomplete(
        document.getElementById('address-field-2'), {
        types: ['geocode']
    });
    bookmarks_autocomplete = new google.maps.places.Autocomplete(
        document.getElementById('bookmarks-address-field'), {
        types: ['geocode']
    });

    autocomplete.setFields(['address_component', 'geometry']);
     autocomplete.addListener('place_changed', fillInAddress);

    autocomplete2.setFields(['address_component', 'geometry']);

    autocomplete2.addListener('place_changed', fillInAddress2);

    bookmarks_autocomplete.setFields(['address_component', 'geometry']);

    bookmarks_autocomplete.addListener('place_changed', bookmarks_fillInAddress);
}
function addClassError(element,is_focus = true)
{
    parents =  element.closest('.bookmarks-input-group').addClass('error');
    if(is_focus)
    {
        element.focus(); 
    }      
    parents.find('.error-message').show()
}
function removeClassError(element)
{
    parents =  element.closest('.bookmarks-input-group').removeClass('error'); 
    parents.find('.error-message').hide();
}
function fillAddress(place)
{
    $("#house-number-field").val('');
    $("#street-name-field").val('');
    $("#city-field").val('');
    $("#zip-code-field").val('');
    $("#bookmarks-house-number-field").val('');
    $("#bookmarks-street-name-field").val('');
    $("#bookmarks-city-field").val('');
    $("#bookmarks-zip-code-field").val('');
    $('#bookmarks-address-field').val(localStorage.getItem('quickqr_address'));
    $('#baddress-field').val(localStorage.getItem('quickqr_address'));
    $('#baddress-field-2').val(localStorage.getItem('quickqr_address'));
    var element = null;
    var bookmarks_element = null;
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            switch (addressType) {
                case "street_number":
                    $("#house-number-field").val(val);
                    $("#bookmarks-house-number-field").val(val);
                    localStorage.setItem('quickqr_house_number', val);
                    bookmarks_element = $("#bookmarks-house-number-field");
                    if(bookmarks_element.val().length === 0)
                    {
                        addClassError(bookmarks_element,false);
                    }
                    else
                    {
                        removeClassError(bookmarks_element);
                    }

                    element = $("#house-number-field");
                    if(element.val().length === 0)
                    {
                        addClassError(element,false);
                    }
                    else
                    {
                        removeClassError(element);
                    }
                    break;
                case "route":
                    $("#street-name-field").val(val);
                    $("#bookmarks-street-name-field").val(val);
                    localStorage.setItem('quickqr_street_name', val);
                    bookmarks_element = $("#bookmarks-street-name-field");
                    if(bookmarks_element.val().length === 0)
                    {
                        addClassError(bookmarks_element,false);
                    }
                    else
                    {
                        removeClassError(bookmarks_element);
                    }

                    element = $("#street-name-field");
                    if(element.val().length === 0)
                    {
                        addClassError(element,false);
                    }
                    else
                    {
                        removeClassError(element);
                    }
                    break;
                case "locality":
                    $("#city-field").val(val);
                    $("#bookmarks-city-field").val(val);
                    localStorage.setItem('quickqr_city', val);
                    bookmarks_element = $("#bookmarks-city-field");
                    if(bookmarks_element.val().length === 0)
                    {
                        addClassError(bookmarks_element,false);
                    }
                    else
                    {
                        removeClassError(bookmarks_element);
                    }
                    element = $("#city-field");
                    if(element.val().length === 0)
                    {
                        addClassError(element,false);
                    }
                    else
                    {
                        removeClassError(element);
                    }
                    break;
                case "postal_code":
                    $("#zip-code-field").val(val);
                    $("#bookmarks-zip-code-field").val(val);
                    localStorage.setItem('quickqr_zip_code', val);
                    bookmarks_element = $("#bookmarks-zip-code-field");
                    if(bookmarks_element.val().length === 0)
                    {
                        addClassError(bookmarks_element,false);
                    }
                    else
                    {
                        removeClassError(bookmarks_element);
                    }
                    element = $("#zip-code-field");
                    if(element.val().length === 0)
                    {
                        addClassError(element,false);
                    }
                    else
                    {
                        removeClassError(element);
                    }
                    break;
                default:
                    break;
            }
        }
    }
}
function bookmarks_fillInAddress() {
    var place = bookmarks_autocomplete.getPlace();
    localStorage.setItem('quickqr_address', $('#bookmarks-address-field').val());
    fillAddress(place)
    getShippingFee($('#bookmarks-order-button-step-3'),$('#bookmarks-address-field'))
}
function fillInAddress2() {
    var place = autocomplete2.getPlace();
    localStorage.setItem('quickqr_address', $('#address-field-2').val());
    fillAddress(place)
    getShippingFee($('#send-data-to-form'),$('#address-field-2'))
}

function fillInAddress() {
    var place = autocomplete.getPlace();
    localStorage.setItem('quickqr_address', $('#address-field').val());
    fillAddress(place)
    getShippingFee($('#submit-order-button'),$('#address-field'))
}
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
        });
    }
}

function getShippingFee($btn,address_field) {
    $return = true;
    $data = [];
     $data.push({ name: 'action', value: 'getShippingFee' });
    $data.push({ name: 'address', value: address_field.val() });
    $data.push({ name: 'zip_code', value: $("#zip-code-field").val() });
    $data.push({ name: 'restaurant', value: $("#restaurant_id").val() });
    $data.push({ name: 'route', value: $("#street-name-field").val() });
    $btn.addClass('button-progress').prop('disabled', true);
    $.ajax({
        type: "POST",
        url: ajaxurl,
        data: $data,
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                localStorage.setItem('quickqr_shipping_fee', response.message);
            } 
            $btn.removeClass('button-progress').prop('disabled', false);
        }
    });
    return $return;
}
