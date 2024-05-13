<?php

function getData ($offset) {
    //Request an API
    $requestUrl = "https://api.sharedmobility.ch/v1/sharedmobility/identify?Geometry=8.737273%2C47.499115&Tolerance=5000&offset=" . $offset;
    $ch = curl_init($requestUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);

    //Umwandlung des JSON-Strings in ein PHP-Array und Rückgabe
    $dataSet = json_decode($output, true);
    return $dataSet;
}

function getFinalData(){
    echo '<script>console.log("Starting an API Call");</script>';
    $data = getData(0);
    $dataLength = count($data);
    $fullDataLength = $dataLength;
    while ($dataLength == 50) {
        $newData = getData($fullDataLength);
        $dataLength = count($newData);
        $data = array_merge($data, $newData);
        $fullDataLength += $dataLength;
    }
    echo '<script>console.log("Finished API Call");</script>';
    return $data;
}

echo "Extract<br/>";
?>