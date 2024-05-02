<?php
include 'extract.php';

$freeFloatingIndex = 0;

foreach ($data as $item) {
    /*print_r($item);
    echo "<br/><br/>";*/
    echo $item['id'] . "<br/>";
    echo $item['attributes']['provider_id'] . "<br/>";
    echo $item['attributes']['available'] . "<br/>";
    echo $item['geometry']['x'] . "<br/>";
    echo $item['geometry']['y'] . "<br/>";

    $pickupType = $item['attributes']['pickup_type'];
    if ($pickupType == "free_floating") {
        echo "Fahrzeug verfügbar: " . $item['attributes']['available'] . "<br/>";
    }
    else {
        echo "Fahrzeuge verfügbar:" . $item['attributes']['station_status_num_vehicle_available'] . "<br/>";
    }

    echo $pickupType . "<br/><br/>";
    
    /*if ($item['attributes']['pickup_type'] != "free_floating"){
        continue;
    }*/
    
    $freeFloatingIndex++;
    /*$temperature_2m = $item['current']['temperature_2m'];
    $precipitation = $item['current']['precipitation'];
    $cloud_cover = $item['current']['cloud_cover'];
    $latitude = $item['latitude'];
    $longitude = $item['longitude'];

    $weatherData[] = [
        'temperature_2m' => $temperature_2m,
        'precipitation' => $precipitation,
        'cloud_cover' => $cloud_cover,
        'latitude' => $latitude,
        'longitude' => $longitude
    ];*/
}

echo "Free floating vehicles: " . $freeFloatingIndex . "<br/>";

echo "Transform<br/>";
?>