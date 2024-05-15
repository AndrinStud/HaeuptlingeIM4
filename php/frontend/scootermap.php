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
    <style>
        #map-container {
            position: relative;
            margin-bottom: 20px;
        }

        #map {
            width: 100vw;
            height: 60vh;
        }

        #scooter-usage-chart {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        #slider-container {
            text-align: center;
            margin-bottom: 20px;
        }

        #datepicker {
            margin: 0 auto 20px;
            text-align: center;
            width: fit-content;
        }

        .slider-ticks {
            position: relative;
            width: 90%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
        }

        .tick-label {
            position: absolute;
            bottom: 10px; 
            width: calc(90% / 24);
            text-align: center;
            font-size: 12px;
            transform: translateX(-50%) rotate(0deg);
            left: calc(-50% + 20px);
            display: none; 
        }
        #slider {
            width: 100%;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://leaflet.github.io/Leaflet.heat/dist/leaflet-heat.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Scooter Map</h1>

    <!-- Map -->
    <div id="map-container">
        <div id="map"></div>
    </div>

    <!-- Slider container -->
    <div id="slider-container">
        <div class="slider-ticks" id="slider-ticks">
            <input type="range" min="0" max="95" value="0" id="slider" />
        </div>
    </div>

    <!-- Datepicker -->
    <div id="datepicker"></div>

    <!-- Chart -->
    <canvas id="scooter-usage-chart" width="800" height="400"></canvas>

    <script>
        // Function to fetch data from the PHP backend and update heatmap
        function loadData(date, time) {
            $.ajax({
                url: '/php/endpoints/getall.php', // Absolute path to the PHP file
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Process the response data
                    var data = response.map(function(item) {
                        return [parseFloat(item.xCoordinates), parseFloat(item.yCoordinates)];
                    });
                    // Update heatmap with new data
                    updateHeatmap(data);
                }
            });
        }

        // Function to fetch scooter usage data and update the line chart
        function loadScooterUsageData(date) {
            $.ajax({
                url: '/php/endpoints/getusage.php', // Modify the URL according to your backend endpoint
                method: 'GET',
                dataType: 'json',
                data: { date: date },
                success: function(response) {
                    // Process the response data
                    var labels = response.map(function(item) {
                        return item.time;
                    });
                    var data = response.map(function(item) {
                        return item.usage;
                    });
                    // Update the line chart with new data
                    updateScooterUsageChart(labels, data);
                }
            });
        }

        var map = L.map('map').setView([47.497429, 8.733204], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var heat = L.heatLayer([], { radius: 50 }).addTo(map);

        // Function to update the heatmap with new data
        function updateHeatmap(data) {
            heat.setLatLngs(data);
            // Set heatmap options (can adjust color gradient, radius, etc. here)
            heat.options.gradient = {0.4: 'blue', 0.65: 'lime', 1: 'red'};
        }

        // Function to update the line chart with new data
        function updateScooterUsageChart(labels, data) {
            var ctx = document.getElementById('scooter-usage-chart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Scooter Usage',
                        data: data,
                        borderColor: 'blue',
                        backgroundColor: 'rgba(0, 0, 255, 0.1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Time'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Scooter Usage'
                            }
                        }
                    }
                }
            });
        }

        $(function() {
            $("#datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                onSelect: function(dateText) {
                    // Trigger data loading based on the selected date
                    loadData(dateText, 0); // Load data for the selected date and initial time
                    loadScooterUsageData(dateText); // Load scooter usage data for the selected date
                }
            });

            var sliderTicks = document.getElementById('slider-ticks');
            var slider = document.getElementById('slider');
            var timeLabels = ["01:00", "01:15", "01:30", "01:45", "02:00", "02:15", "02:30", "02:45", "03:00", "03:15", "03:30", "03:45", "04:00", "04:15", "04:30", "04:45", "05:00", "05:15", "05:30", "05:45", "06:00", "06:15", "06:30", "06:45", "07:00", "07:15", "07:30", "07:45", "08:00", "08:15", "08:30", "08:45", "09:00", "09:15", "09:30", "09:45", "10:00", "10:15", "10:30", "10:45", "11:00", "11:15", "11:30", "11:45", "12:00", "12:15", "12:30", "12:45", "13:00", "13:15", "13:30", "13:45", "14:00", "14:15", "14:30", "14:45", "15:00", "15:15", "15:30", "15:45", "16:00", "16:15", "16:30", "16:45", "17:00", "17:15", "17:30", "17:45", "18:00", "18:15", "18:30", "18:45", "19:00", "19:15", "19:30", "19:45", "20:00", "20:15", "20:30", "20:45", "21:00", "21:15", "21:30", "21:45", "22:00", "22:15", "22:30", "22:45", "23:00", "23:15", "23:30", "23:45", "24:00"];

            for (var i = 0; i < timeLabels.length; i++) {
                var tickLabel = document.createElement('div');
                tickLabel.classList.add('tick-label');
                tickLabel.textContent = timeLabels[i];
                tickLabel.style.left = 'calc(' + (i * (100 / (timeLabels.length - 1))) + '% + 20px)';
                sliderTicks.appendChild(tickLabel);
            }

            slider.addEventListener('input', function() {
                var value = parseFloat(this.value);
                var index = Math.round(value / (95 / (timeLabels.length - 1)));
                var tickLabels = document.querySelectorAll('.tick-label');
                for (var i = 0; i < tickLabels.length; i++) {
                    if (i === index) {
                        tickLabels[i].style.display = 'block';
                    } else {
                        tickLabels[i].style.display = 'none';
                    }
                }
                // Do something with the selected time
            });
        });

        // Initial load of data based on the current date and time
        var currentDate = new Date().toISOString().slice(0, 10);
        loadData(currentDate, 0);
        loadScooterUsageData(currentDate);
    </script>
</body>
</html>
