<?php
include 'transform.php';
require_once 'config.php';

echo "Load:<br/>";

$thisQuarterHour = date('Y-m-d H:i:s', floor(time() / (15 * 60)) * (15 * 60));
$lastQuarterHour = date('Y-m-d H:i:s', strtotime('-15 minutes', strtotime($thisQuarterHour)));

$vehiclesData = [
    0 => [
        'id' => '103a48c7-4951-4cfe-983a-acb95845895d',
        'provider_id' => 'a6cf8b5f-ced8-4638-8168-c10db85ebe14',
        'available' => 1,
        'x' => 47.497505,
        'y' => 8.742115,
        'datetime' => $thisQuarterHour
    ],
    1 => [
        'id' => 'd2479fa5-618e-4971-8d04-f685326fb419',
        'provider_id' => '93f241a8-c89f-4c0f-984e-8705bd435189',
        'available' => 1,
        'x' => 47.497826,
        'y' => 8.736857,
        'datetime' => $thisQuarterHour
    ],
    2 => [
        'id' => '133d7630-b956-4aa4-bbf5-8b6dd6340946',
        'provider_id' => '3c76342c-f35e-4ec6-bb37-dd0384726ee0',
        'available' => 0,
        'x' => 47.49499,
        'y' => 8.737313,
        'datetime' => $thisQuarterHour
    ],
    3 => [
        'id' => '5c6521a9-fcd9-45d8-b443-215ad1fbdb66',
        'provider_id' => '1eb2096e-6d2c-4172-993c-9ea52d1b7a0d',
        'available' => 2,
        'x' => 47.499645,
        'y' => 8.730882,
        'datetime' => $thisQuarterHour
    ],
    4 => [
        'id' => '103a48c7-4951-4cfe-983a-acb95845895d',
        'provider_id' => 'a6cf8b5f-ced8-4638-8168-c10db85ebe14',
        'available' => 1,
        'x' => 47.498505,
        'y' => 8.743115,
        'datetime' => $lastQuarterHour
    ],
    5 => [
        'id' => 'd2479fa5-618e-4971-8d04-f685326fb419',
        'provider_id' => '93f241a8-c89f-4c0f-984e-8705bd435189',
        'available' => 1,
        'x' => 47.498826,
        'y' => 8.735857,
        'datetime' => $lastQuarterHour
    ],
    6 => [
        'id' => '133d7630-b956-4aa4-bbf5-8b6dd6340946',
        'provider_id' => '3c76342c-f35e-4ec6-bb37-dd0384726ee0',
        'available' => 0,
        'x' => 47.49399,
        'y' => 8.736313,
        'datetime' => $lastQuarterHour
    ],
    7 => [
        'id' => '5c6521a9-fcd9-45d8-b443-215ad1fbdb66',
        'provider_id' => '1eb2096e-6d2c-4172-993c-9ea52d1b7a0d',
        'available' => 2,
        'x' => 47.498645,
        'y' => 8.731882,
        'datetime' => $lastQuarterHour
    ]
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);

    // SQL-Query mit Platzhaltern für das Einfügen von Daten
    $sql = "INSERT INTO Vehicles (id, time, provider_id, available, xCoordinates, yCoordinates) VALUES (?, ?, ?, ?, ?, ?);";

    // Bereitet die SQL-Anweisung vor
    $stmt = $pdo->prepare($sql);

    // Fügt jedes Element im Array in die Datenbank ein
    foreach ($vehiclesData as $item) {
        $stmt->execute([
            $item['id'],
            $item['datetime'],
            $item['provider_id'],
            $item['available'],
            $item['x'],
            $item['y']
        ]);
    }

    echo "Daten erfolgreich eingefügt.<br/><br/>";
} catch (PDOException $e) {
    die("Verbindung zur Datenbank konnte nicht hergestellt werden: " . $e->getMessage());
}
?>