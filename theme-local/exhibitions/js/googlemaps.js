/**
 * googlemaps.js
 * 
 * simple script to initialise the google maps api centered on UofE main library
 * 
 * @author bparkes.ed.ac.uk
 */

function initMap() {
    var options = {
        zoom: 15,
        center:{lat:55.9427,lng:-3.1890}
    }

    var map = new google.maps.Map(document.getElementById('google-map'), options);

    var marker = new google.maps.Marker({
        position:{lat:55.9427,lng:-3.1890},
        /*label: {
                text: "Main Library Exhibition Gallery",
                color: "#b6015c",
                fontSize: "20px",
                labelInBackground: true,
                labelClass: "map-label",
            },*/
        animation: google.maps.Animation.DROP,
        map:map,
        
    });
}