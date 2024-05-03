<!DOCTYPE html>
<html lang="de-CH">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/scootermap.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <title>Scooter Map</title>
</head>
<body>
    <h1>Scooter Map</h1>
    <p>Hier ist die Karte wheeee</p>
    
    <div id="map" style=" width: 100vw; height: calc(100vh - 200px);"></div>

    
    <div class="slider-ticks">
    <input type="range" min="0" max="23" value="0" id="slider" />
    <div class="tick-label" style="left: 0%">01:00</div>
    <div class="tick-label" style="left: 4.1666%">02:00</div>
    <div class="tick-label" style="left: 8.3333%">03:00</div>
    <div class="tick-label" style="left: 12.5%">04:00</div>
    <div class="tick-label" style="left: 16.6666%">05:00</div>
    <div class="tick-label" style="left: 20.8333%">06:00</div>
    <div class="tick-label" style="left: 25%">07:00</div>
    <div class="tick-label" style="left: 29.1666%">08:00</div>
    <div class="tick-label" style="left: 33.3333%">09:00</div>
    <div class="tick-label" style="left: 37.5%">10:00</div>
    <div class="tick-label" style="left: 41.6666%">11:00</div>
    <div class="tick-label" style="left: 45.8333%">12:00</div>
    <div class="tick-label" style="left: 50%">13:00</div>
    <div class="tick-label" style="left: 54.1666%">14:00</div>
    <div class="tick-label" style="left: 58.3333%">15:00</div>
    <div class="tick-label" style="left: 62.5%">16:00</div>
    <div class="tick-label" style="left: 66.6666%">17:00</div>
    <div class="tick-label" style="left: 70.8333%">18:00</div>
    <div class="tick-label" style="left: 75%">19:00</div>
    <div class="tick-label" style="left: 79.1666%">20:00</div>
    <div class="tick-label" style="left: 83.3333%">21:00</div>
    <div class="tick-label" style="left: 87.5%">22:00</div>
    <div class="tick-label" style="left: 91.6666%">23:00</div>
    <div class="tick-label" style="right: 0%">24:00</div>
</div>

    <script>
var map = L.map('map').setView([47.497429, 8.733204], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

var marker1 = L.marker([47.497429, 8.733204]).addTo(map);
var marker2 = L.marker([47.4975, 8.7333]).addTo(map);
var marker3 = L.marker([47.4976, 8.7332]).addTo(map);
var marker4 = L.marker([47.4974, 8.7331]).addTo(map);

marker1.bindPopup("<b>Hello world!</b><br>I am a popup.");
marker2.bindPopup("<b>Marker 2</b><br>Additional information here.");
marker3.bindPopup("<b>Marker 3</b><br>More details here.");
marker4.bindPopup("<b>Marker 4</b><br>Extra information.");

// Initially hide markers 3 and 4
map.removeLayer(marker3);
map.removeLayer(marker4);

var slider = document.getElementById('slider');
slider.addEventListener('input', function() {
    // Show markers 1 and 2 for slider value 0
    if (slider.value == '0') {
        map.addLayer(marker1);
        map.addLayer(marker2);
    } else {
        map.removeLayer(marker1);
        map.removeLayer(marker2);
    }
    // Show markers 3 and 4 for slider value 1
    if (slider.value == '1') {
        map.addLayer(marker3);
        map.addLayer(marker4);
    } else {
        map.removeLayer(marker3);
        map.removeLayer(marker4);
    }
});
</script>

</body>
</html>
