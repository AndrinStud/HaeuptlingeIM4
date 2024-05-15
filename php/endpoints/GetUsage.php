<?php
require_once '../backend/config.php';

// Query to count the number of IDs for each hour
$sql = "SELECT HOUR(time) AS hour, COUNT(id) AS usage_count FROM Vehicles GROUP BY HOUR(time)";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the data as an associative array
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // If no data is found, return an empty array
    echo json_encode([]);
}

$conn->close();
?>
