<?php
include 'extract.php';

echo "Transform<br/>";
echo "<script>console.log('Start transforming data');</script>";

$timeOfApiCall = date('Y-m-d H:i:s', floor(time() / (15 * 60)) * (15 * 60));
$vehiclesData = [];
$data;

do {
    $data = getFinalData();
    $freeFloatingIndex = 0;
    $duplicationIndex = 0;
    
    foreach ($data as $item) {
        /*
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
        */
    
        $isDuplicate = false;
        foreach ($vehiclesData as $vehicle) {
            if ($vehicle['provider_id'] . ":" . $vehicle['id'] == $item['id']) {
                $isDuplicate = true;
                $duplicationIndex++;
                break;
            }
        }
        
        if (!$isDuplicate) {
            if ($item['attributes']['pickup_type'] == "free_floating"){
                $freeFloatingIndex++;
            }

            $splittedId = explode(":", $item['id']);
            $available = 0;
            $availableAtt = $item['attributes']['available'];

            if ($item['attributes']['pickup_type'] == "free_floating") {
                $available = $availableAtt ? 1 : 0;
            }
            else {
                if (!$availableAtt)
                    $available = 0;
                else 
                    $available = $item['attributes']['station_status_num_vehicle_available'];
            }
            
            $vehiclesData[] = [
                'id' => $splittedId[1],
                'provider_id' => $splittedId[0],
                'available' => $available,
                'x' => $item['geometry']['x'],
                'y' => $item['geometry']['y'],
                'datetime' => $timeOfApiCall
            ];
        }
    }
    
    echo "<br/></br/>Duplication: " . $duplicationIndex . "<br/>";
    echo "Free floating vehicles: " . $freeFloatingIndex . "<br/>";
    echo "Total vehicles: " . count($vehiclesData) . "<br/>";

    sleep(5);
}
while (count($vehiclesData) < count($data));

echo "<script>console.log('Finished transforming data: ');</script>";
echo "<script>console.log(" . json_encode($vehiclesData) . ");</script>";

?>