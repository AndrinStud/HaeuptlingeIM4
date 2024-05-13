<?php
include 'extract.php';
echo "Transform<br/>";

function getProviderId($textId){
    $providerId = "";
    switch ($textId) {
        case "2em_cars":
            $providerId = "40421aad-ffea-4c54-8223-893d6b02fa17";
            break;
        case "bolt_winterthur":
            $providerId = "a6cf8b5f-ced8-4638-8168-c10db85ebe14";
            break;
        case "carvelo2go":
            $providerId = "1eb2096e-6d2c-4172-993c-9ea52d1b7a0d";
            break;
        case "mobility":
            $providerId = "c737d0d8-0ed8-4a72-9ebd-2ce234ebf147";
            break;
        case "tier_winterthur":
            $providerId = "36192988-3a8a-4a9d-982c-9dc4b38c6057";
            break;
        case "voiscooters.com":
            $providerId = "3c76342c-f35e-4ec6-bb37-dd0384726ee0";
            break;
        case "other":
            $providerId = "93f241a8-c89f-4c0f-984e-8705bd435189";
            break;
    }
    return $providerId;
}

function getProviderTextId($providerId){
    $providerTextId = "";
    switch ($providerId) {
        case "40421aad-ffea-4c54-8223-893d6b02fa17":
            $providerTextId = "2em_cars";
            break;
        case "a6cf8b5f-ced8-4638-8168-c10db85ebe14":
            $providerTextId = "bolt_winterthur";
            break;
        case "1eb2096e-6d2c-4172-993c-9ea52d1b7a0d":
            $providerTextId = "carvelo2go";
            break;
        case "c737d0d8-0ed8-4a72-9ebd-2ce234ebf147":
            $providerTextId = "mobility";
            break;
        case "36192988-3a8a-4a9d-982c-9dc4b38c6057":
            $providerTextId = "tier_winterthur";
            break;
        case "3c76342c-f35e-4ec6-bb37-dd0384726ee0":
            $providerTextId = "voiscooters.com";
            break;
        case "93f241a8-c89f-4c0f-984e-8705bd435189":
            $providerTextId = "other";
            break;
    }
    return $providerTextId;
}

echo "<script>console.log('Start transforming data');</script>";
$timeOfApiCall = date('Y-m-d H:i:s', floor(time() / (15 * 60)) * (15 * 60));
$vehiclesData = [];
$data;
do {
    $data = getFinalData();
    $freeFloatingIndex = 0;
    $duplicationIndex = 0;
    
    foreach ($data as $item) {    
        $isDuplicate = false;
        foreach ($vehiclesData as $vehicle) {
            if (getProviderTextId($vehicle['provider_id']) . ":" . $vehicle['id'] == $item['id']) {
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
                'provider_id' => getProviderId($splittedId[0]),
                'available' => $available,
                'x' => $item['geometry']['x'],
                'y' => $item['geometry']['y'],
                'datetime' => $timeOfApiCall
            ];
        }
    }

    sleep(5);
}
while (count($vehiclesData) < count($data));

echo "<script>console.log('Finished transforming data: ');</script>";
echo "<script>console.log(" . json_encode($vehiclesData) . ");</script>";

?>