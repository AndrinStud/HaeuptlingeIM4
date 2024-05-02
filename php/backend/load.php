<?php
include 'transform.php';
require_once 'config.php';

echo "Load:<br/>";

$vehiclesData = [
    0 => [
        'id' => '103a48c7-4951-4cfe-983a-acb95845895d',
        'provider_id' => rand(1, 5),
        'available' => true,
        'x' => 47.497505,
        'y' => 8.742115,
        'datetime' => null
    ],
    1 => [
        'id' => 'd2479fa5-618e-4971-8d04-f685326fb419',
        'provider_id' => rand(1, 5),
        'available' => true,
        'x' => 47.497826,
        'y' => 8.736857,
        'datetime' => date('Y-m-d H:i:s', strtotime('-2 hours'))
    ],
    2 => [
        'id' => '133d7630-b956-4aa4-bbf5-8b6dd6340946',
        'provider_id' => rand(1, 5),
        'available' => false,
        'x' => 47.49499,
        'y' => 8.737313,
        'datetime' => date('Y-m-d H:i:s', strtotime('-1 hours'))
    ],
    3 => [
        'id' => '5c6521a9-fcd9-45d8-b443-215ad1fbdb66',
        'provider_id' => rand(1, 5),
        'available' => true,
        'x' => 47.499645,
        'y' => 8.730882,
        'datetime' => date('Y-m-d H:i:s', strtotime('-43 minutes'))
    ]
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);

    // SQL-Query mit Platzhaltern für das Einfügen von Daten
    $sql = "INSERT INTO `Vehicles` (id, `name`, available, xCoordinates, yCoordinates) VALUES (?, ?, ?, ?, ?);";
    //$sql = "INSERT INTO `Vehicles` (id, `name`, available, xCoordinates, yCoordinates) VALUES ('26ba76b4-2053-4fa9-a3ee-a619bcfb18ec','some vehicle', 1, 47.5109, 8.696504);";

    // Bereitet die SQL-Anweisung vor
    $stmt = $pdo->prepare($sql);

    // Fügt jedes Element im Array in die Datenbank ein
    foreach ($vehiclesData as $item) {
        $stmt->execute([
            $item['id'],
            $item['provider_id'],
            $item['available'] ? 1 : 0,
            $item['x'],
            $item['y']
        ]);
    }

    echo "Daten erfolgreich eingefügt.<br/><br/>";
} catch (PDOException $e) {
    die("Verbindung zur Datenbank konnte nicht hergestellt werden: " . $e->getMessage());
}
?>