<?php
require_once '../backend/config.php';

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
    
    // Prepare the SQL statement
    $stmt = $pdo->prepare("SELECT id, time, xCoordinates, yCoordinates, available FROM Vehicles");
    
    // Execute the statement
    $stmt->execute();

    // Fetch all rows as an associative array
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the result as JSON
    header('Content-Type: application/json'); // Set response header to JSON
    echo json_encode($result);
} catch(PDOException $e) {
    // Handle errors
    echo json_encode(['error' => $e->getMessage()]); // Return error message as JSON
}
?>
