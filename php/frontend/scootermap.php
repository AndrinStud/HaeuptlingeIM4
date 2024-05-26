<!DOCTYPE html>
<html lang="de-CH">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scooter Map</title>
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/scootermap.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
    <article class="start">
    <h1 class="title title-background">Trotti-Tracker</h1>
        <p class="abstand_top">Willst du wissen wann die Mobility Fahrzeuge sich wo aufhalten?</p>
        <br />
        <p>Komm nie wieder zu spät. Steh nie wieder vor einer leeren E-Bike-Station. Finde sofort ein Trotti, wenn du es brauchst.</p>
    </article>

    <article id="charts">
        <!-- Scooter Availability Chart -->
        <div id="scooterAvailabilityChartContainer">
            <canvas id="scooterAvailabilityChart"></canvas>
            <h2 style="text-align: center;">  </h2>
        </div>

        <!-- Station Usage Chart -->
        <div id="stationUsageChartContainer">
            <canvas id="stationUsageChart"></canvas>
            <h2 style="text-align: center;">  </h2>
        </div>
    </article>

    <!-- Datepicker buttons -->

    <div id="datepicker-buttons">
    <button class="date-button" data-date="2024-05-06" style="--button-index: 1;">MO</button>
    <button class="date-button" data-date="2024-05-07" style="--button-index: 2;">DI</button>
    <button class="date-button" data-date="2024-05-08" style="--button-index: 3;">MI</button>
    <button class="date-button" data-date="2024-05-09" style="--button-index: 4;">DO</button>
    <button class="date-button" data-date="2024-05-10" style="--button-index: 5;">FR</button>
    <button class="date-button" data-date="2024-05-11" style="--button-index: 6;">SA</button>
    <button class="date-button" data-date="2024-05-12" style="--button-index: 7;">SO</button>
</div>

    <!-- Slider container -->
    <div id="slider-container">
        <div class="slider-ticks" id="slider-ticks">
            <input type="range" min="0" max="95" value="0" id="slider" />
        </div>
    </div>

    <!-- Map -->
    <div id="map-container">
    <div id="info-tile"></div>
        <div id="map"></div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://leaflet.github.io/Leaflet.heat/dist/leaflet-heat.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Function to fetch data from the PHP backend and update heatmap
        function loadData(date, time) {
            var dateTime = date + ' ' + time + ':00';
            console.log('Fetching data for:', dateTime);
            $.ajax({
                url: '/php/endpoints/GetAll.php',
                method: 'GET',
                dataType: 'json',
                data: { time: dateTime },
                success: function(response) {
                    console.log('Data received for:', dateTime, response);
                    if (response.length > 0) {
                        var selectedDateTime = new Date(dateTime).getTime();
                        var data = response.filter(function(item) {
                            var pointDateTime = new Date(item.time).getTime();
                            return pointDateTime === selectedDateTime;
                        }).map(function(item) {
                            return [parseFloat(item.xCoordinates), parseFloat(item.yCoordinates)];
                        });
                        heat.setLatLngs([]);
                        heat.setLatLngs(data);
                    } else {
                        heat.setLatLngs([]);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        // Function to load scooter usage data for the selected date and update Chart 1
        function loadScooterUsageData(date) {
            console.log('Loading scooter usage data for date:', date);
            $.ajax({
                url: '/php/endpoints/GetAll.php',
                method: 'GET',
                dataType: 'json',
                data: { date: date },
                success: function(response) {
                    console.log('Scooter usage data received:', response);
                    if (response && response.length > 0) {
                        var availabilityCounts = {};
                        var timeLabels = ["00:00", "00:15", "00:30", "00:45", "01:00", "01:15", "01:30", "01:45", "02:00", "02:15", "02:30", "02:45", "03:00", "03:15", "03:30", "03:45", "04:00", "04:15", "04:30", "04:45", "05:00", "05:15", "05:30", "05:45", "06:00", "06:15", "06:30", "06:45", "07:00", "07:15", "07:30", "07:45", "08:00", "08:15", "08:30", "08:45", "09:00", "09:15", "09:30", "09:45", "10:00", "10:15", "10:30", "10:45", "11:00", "11:15", "11:30", "11:45", "12:00", "12:15", "12:30", "12:45", "13:00", "13:15", "13:30", "13:45", "14:00", "14:15", "14:30", "14:45", "15:00", "15:15", "15:30", "15:45", "16:00", "16:15", "16:30", "16:45", "17:00", "17:15", "17:30", "17:45", "18:00", "18:15", "18:30", "18:45", "19:00", "19:15", "19:30", "19:45", "20:00", "20:15", "20:30", "20:45", "21:00", "21:15", "21:30", "21:45", "22:00", "22:15", "22:30", "22:45", "23:00", "23:15", "23:30", "23:45"];

                        timeLabels.forEach(function(time) {
                            availabilityCounts[time] = 0;
                        });

                        var filteredData = response.filter(function(item) {
                            return item.time.slice(0, 10) === date;
                        });

                        filteredData.forEach(function(item) {
                            var itemTime = item.time.slice(11, 16);
                            if (itemTime in availabilityCounts) {
                                if (item.available === 1) {
                                    availabilityCounts[itemTime]++;
                                }
                            }
                        });

                        scooterAvailabilityChart.data.datasets[0].data = timeLabels.map(function(time) {
                            return availabilityCounts[time];
                        });
                        scooterAvailabilityChart.update();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching scooter usage data:", error);
                }
            });
        }

// Function to load station usage data for the selected date and time and update Chart 2
function loadStationUsageData(date, time = '00:00') {
    // Adjust the time format if it's in the format "0" to make it "00:00"
    if (time === '0') {
        time = '00:00';
    }
    
    console.log('Loading station usage data for:', date, time); // Log date and time
    
    $.ajax({
        url: '/php/endpoints/GetAll.php',
        method: 'GET',
        dataType: 'json',
        data: { date: date, time: time },
        success: function(response) {
            console.log('Ajax success callback triggered'); // Log success callback triggered
            console.log('Received data:', response); // Log received data
            if (response && response.length > 0) {
                // Log the entire response data before filtering
                console.log('Response data before filtering:', response);

                // Find the item with ID 'station1' and the specified date and time
                var station1Data = response.find(function(item) {
                    // Check if the time string in the data matches the specified time
                    return item.id === "station1" && item.time === (date + " " + time + ":00");
                });

                console.log('Station 1 Data:', station1Data); // Log station1Data

                if (station1Data && 'available' in station1Data) { // Check if 'available' property exists
                    var availableCount = parseInt(station1Data.available); // Parse available count as integer
                    console.log('Available count for Station1:', availableCount);

                    // Update the data for Bar 1 in Chart 2
                    console.log('Before chart update:', stationUsageChart.data.datasets[0].data);
                    stationUsageChart.data.datasets[0].data[0] = availableCount; // Update Bar 1 with availableCount
                    console.log('After chart update:', stationUsageChart.data.datasets[0].data);
                    stationUsageChart.update(); // Update the chart
                } else {
                    console.log('No available count found for Station1 at:', date, time);
                }
            } else {
                console.log('No data received for Station1 at:', date, time);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching station usage data:", error);
        }
    });

    // Similar logic for Bar 2 (Station2)
    $.ajax({
        url: '/php/endpoints/GetAll.php',
        method: 'GET',
        dataType: 'json',
        data: { date: date, time: time },
        success: function(response) {
            // Find the item with ID 'station2' and the specified date and time
            var station2Data = response.find(function(item) {
                // Check if the time string in the data matches the specified time
                return item.id === "station2" && item.time === (date + " " + time + ":00");
            });

            if (station2Data && 'available' in station2Data) { // Check if 'available' property exists
                var availableCount = parseInt(station2Data.available); // Parse available count as integer

                // Update the data for Bar 2 in Chart 2
                stationUsageChart.data.datasets[0].data[1] = availableCount; // Update Bar 2 with availableCount
                stationUsageChart.update(); // Update the chart
            } else {
                console.log('No available count found for Station2 at:', date, time);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching station usage data for Station2:", error);
        }
    });
}



        var map = L.map('map').setView([47.497429, 8.733204], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add markers
var station1 = L.marker([47.499115, 8.737273]).addTo(map);
station1.bindPopup("<b>Station Palmstrasse</b>");

var station2 = L.marker([47.499115, 8.747273]).addTo(map);
station2.bindPopup("<b>Station Eulach</b>");


        var heat = L.heatLayer([], { radius: 20 }).addTo(map);

        $(function() {
            $(".date-button").click(function() {
                $(".date-button").removeClass("active");
                $(this).addClass("active");
                var selectedDate = $(this).data('date');
                var selectedTime = $('#slider').val();
                console.log('Selected Date:', selectedDate);
                console.log('Selected Time:', selectedTime);
                loadData(selectedDate, selectedTime);
                loadScooterUsageData(selectedDate);
                console.log('Before calling loadStationUsageData');
                loadStationUsageData(selectedDate, selectedTime);
            });

            var sliderTicks = document.getElementById('slider-ticks');
            var slider = document.getElementById('slider');
            var timeLabels = ["00:00", "00:15", "00:30", "00:45", "01:00", "01:15", "01:30", "01:45", "02:00", "02:15", "02:30", "02:45", "03:00", "03:15", "03:30", "03:45", "04:00", "04:15", "04:30", "04:45", "05:00", "05:15", "05:30", "05:45", "06:00", "06:15", "06:30", "06:45", "07:00", "07:15", "07:30", "07:45", "08:00", "08:15", "08:30", "08:45", "09:00", "09:15", "09:30", "09:45", "10:00", "10:15", "10:30", "10:45", "11:00", "11:15", "11:30", "11:45", "12:00", "12:15", "12:30", "12:45", "13:00", "13:15", "13:30", "13:45", "14:00", "14:15", "14:30", "14:45", "15:00", "15:15", "15:30", "15:45", "16:00", "16:15", "16:30", "16:45", "17:00", "17:15", "17:30", "17:45", "18:00", "18:15", "18:30", "18:45", "19:00", "19:15", "19:30", "19:45", "20:00", "20:15", "20:30", "20:45", "21:00", "21:15", "21:30", "21:45", "22:00", "22:15", "22:30", "22:45", "23:00", "23:15", "23:30", "23:45"];

            for (var i = 0; i < timeLabels.length; i++) {
                var tickLabel = document.createElement('div');
                tickLabel.classList.add('tick-label');
                tickLabel.textContent = timeLabels[i];
                tickLabel.style.left = (i / (timeLabels.length - 1)) * 100 + '%';
                sliderTicks.appendChild(tickLabel);
            }

// Function to show/hide the tile
function toggleTile(show, date, time) {
    var tile = document.getElementById("info-tile");
    if (show) {
        tile.innerHTML = "Scooters move to the middle of the city";
        tile.style.display = "block";
    } else {
        tile.style.display = "none";
    }
}

// Adjusted event listener for slider
slider.addEventListener('input', function() {
    var value = parseFloat(this.value);
    var index = Math.round(value / (95 / (timeLabels.length - 1)));
    var tickLabels = document.querySelectorAll('.tick-label');
    for (var i = 0; i < tickLabels.length; i++) {
        if (i === index) {
            tickLabels[i].style.display = 'block';
            var selectedDate = $('.date-button.active').data('date');
            var selectedTime = timeLabels[i];
            loadData(selectedDate, selectedTime);
            loadStationUsageData(selectedDate, selectedTime); // Call loadStationUsageData with selectedTime
            
            // Show tile for specific times
            if (selectedTime === "08:00" || selectedTime === "08:15" || selectedTime === "08:30") {
                toggleTile(true, selectedDate, selectedTime);
            } else {
                toggleTile(false);
            }
        } else {
            tickLabels[i].style.display = 'none';
        }
    }
});

// Initialize the tile
var tile = document.createElement("div");
tile.id = "info-tile";
tile.style.position = "absolute";
tile.style.top = "20px";
tile.style.right = "20px";
tile.style.backgroundColor = "white";
tile.style.color = "black";
tile.style.padding = "10px";
tile.style.border = "1px solid black";
tile.style.display = "none"; // Initially hide the tile
document.body.appendChild(tile);


            $(".date-button:first").trigger("click");
        });

// Initialize scooter availability chart
var scooterAvailabilityChartCtx = document.getElementById('scooterAvailabilityChart').getContext('2d');
var scooterAvailabilityChart = new Chart(scooterAvailabilityChartCtx, {
    type: 'line',
    data: {
        labels: ["00:00", "01:00", "02:00", "03:00", "04:00", "05:00", "06:00", "07:00", "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00"],
        datasets: [{
            label: 'Scooter Availability',
            data: [],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    min: 60, // Set minimum y-axis value to 0
                    max: 100 // Set maximum y-axis value to 60
                }
            }]
        }
    }
});




        // Initialize station usage chart
        var stationUsageChartCtx = document.getElementById('stationUsageChart').getContext('2d');
        var stationUsageChart = new Chart(stationUsageChartCtx, {
            type: 'bar',
            data: {
                labels: ['Station Palmstrasse', 'Station Eulach'],
                datasets: [{
                    label: 'Available Scooters',
                    data: [],
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
