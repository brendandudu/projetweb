
/*LOAD MAP*/
let mymap = L.map('mapid').setView([47.171079, 2.700238], 11);
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    tileSize: 512,
    zoomOffset: -1,
    id: 'mapbox/streets-v11',
    accessToken: 'pk.eyJ1IjoiYnJlbmRhbjc4MzMwIiwiYSI6ImNrbHMzbDNueTB2NzIycGxsdG9icTZmZ3oifQ.tOMbhVIstg5MBHh6_m5_WA'
}).addTo(mymap);



let bounds = [];
let activePopup = null; //la popup active


/*ADD POPUPS & EVENT*/
Array.from(document.querySelectorAll('.js-marker')).forEach((item) => {

    let point = [item.dataset.lat, item.dataset.lon];

    bounds.push(point);
    let popup = placePopup(point, item.dataset.price);

    item.addEventListener('mouseover', function () {
        if(activePopup !== null){
            activePopup.getElement().classList.remove('is-active')//on "desactive"
        }
        popup.getElement().classList.add('is-active'); //on "active"
        activePopup = popup;
    })
});

if(bounds.length > 0) {
    mymap.fitBounds(bounds);
}

function placePopup(point, text) {
    return L.popup({
        autoClose: false,
        closeOnEscapeKey: false,
        closeOnClick: false,
        closeButton: false,
        className: 'marker',
        maxWidth: 400
    })
        .setLatLng(point)
        .setContent(text + "€")
        .openOn(mymap);
}
