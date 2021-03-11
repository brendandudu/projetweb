
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
    focus: true,
    placeholder: 'Où partez-vous ?',
    panToPoint: false,
    params: {
        dedupe: 1,
        addressdetails: 1,
        zoom: 10,
        tag: 'place:city,place:town,place:village',
        format: "json",
        countrycodes: 'FR'
    }
}

//Initialize the geocoder and add event
let geocoderControl = new L.control.geocoder(locationIQToken, geocoderControlOptions).addTo(map).on('select', function (e) {
    putInputValues(e.feature.feature.address.name, e.latlng.lat, e.latlng.lng);
});

//Get the "search-box" div
let searchBoxControl = document.getElementById("search-box");
//Get the geocoder container from the leaflet map
let geocoderContainer = geocoderControl.getContainer();
//Append the geocoder container to the "search-box" div
searchBoxControl.appendChild(geocoderContainer);

let cityNameInput = document.getElementById("search_cityName");
let latInput = document.getElementById("search_lat");
let lngInput = document.getElementById("search_lng");

//Put the geocoding response in the input values
function putInputValues(cityName, lat, lng) {
    cityNameInput.value = cityName;
    latInput.value = lat;
    lngInput.value = lng
}

//Reset input on load to avoid conflicts
window.onload = function() {
    geocoderControl.reset();
}