
let locationIQToken = 'pk.5d976499747b8ec0b712e7145032b4a9';

//Initialize invisible map
let map = L.map('map', {
    center: [40.7259, -73.9805],
    zoom: 12,
    scrollWheelZoom: true,
    zoomControl: false,
    attributionControl: false,
});

//Geocoder options
let geocoderControlOptions = {
    bounds: false,
    markers: false,
    attribution: null,
    expanded: true,
    placeholder: 'Adresse exacte',
    panToPoint: false,
    params: {
        dedupe: 1,
        format: "json",
        countrycodes: 'FR',
        addressdetails: 1,
    }
}

//Initialize the geocoder and add event
let geocoderControl = new L.control.geocoder(locationIQToken, geocoderControlOptions).addTo(map).on('select', function (e) {
    console.log("ok");
    putInputValues(e.feature.feature.display_name, e.latlng.lat, e.latlng.lng);
});

//Get the "search-box" div
let searchBoxControl = document.getElementById("search-box");
//Get the geocoder container from the leaflet map
let geocoderContainer = geocoderControl.getContainer();
//Append the geocoder container to the "search-box" div
searchBoxControl.appendChild(geocoderContainer);

let fullAddressInput = document.getElementById("lodging_fullAddress");
let latInput = document.getElementById("lodging_lat");
let lonInput = document.getElementById("lodging_lon");

//Put the geocoding response in the input values
function putInputValues(fullAddress, lat, lon) {
    fullAddressInput.value = fullAddress;
    latInput.value = lat;
    lonInput.value = lon;
}

//Reset input on load to avoid conflicts
window.onload = function() {
    geocoderControl.reset();
}