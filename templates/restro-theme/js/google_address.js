
var placeSearch, autocomplete;
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
    autocomplete.setFields(['address_component', 'geometry']);
    autocomplete.addListener('place_changed', fillAddress);
}

function fillAddress()
{
    // $("#house-number-field").val('');
    // $("#street-name-field").val('');
    // $("#city-field").val('');
    // $("#zip-code-field").val('');
    // $("#bookmarks-house-number-field").val('');
    // $("#bookmarks-street-name-field").val('');
    // $("#bookmarks-city-field").val('');
    // $("#bookmarks-zip-code-field").val('');
    // $('#bookmarks-address-field').val(localStorage.getItem('quickqr_address'));
    // $('#baddress-field').val(localStorage.getItem('quickqr_address'));
    // $('#baddress-field-2').val(localStorage.getItem('quickqr_address'));
    var place = autocomplete.getPlace();
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            switch (addressType) {
                case "street_number":
                    $("#house-number-field").val(val);
                    break;
                case "route":
                    $("#street-name-field").val(val);
                    break;
                case "locality":
                    $("#city-field").val(val);
                    break;
                case "postal_code":
                    $("#zip-code-field").val(val);
                    break;
                default:
                    break;
            }
        }
    }
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

