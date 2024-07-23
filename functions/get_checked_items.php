<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../includes/db.php');

// Funcția getTableForUser care returnează tabela specifică utilizatorului
function getTableForUser($username) {
    // Mapping utilizator -> tabel
    $userTableMapping = [
        'pdc1' => 'bifate1',
        'pdc2' => 'bifate2',
        'pdc3' => 'bifate3',
        // adaugă mai multe mappări după necesitate
    ];

    return isset($userTableMapping[$username]) ? $userTableMapping[$username] : 'pdc1';
}

session_start(); // Începe sesiunea pentru a accesa variabila de sesiune
$username = $_SESSION['username']; // Preia numele utilizatorului din sesiune

// Obține tabelul specific utilizatorului curent
$table = getTableForUser($username);

// Construiește interogarea SQL pentru a obține pt_id-urile bifate
$sql = "SELECT pt_id FROM $table WHERE bifat = 1";
$result = $conn->query($sql);

$checkedItems = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $checkedItems[] = $row['pt_id'];
    }
}

echo json_encode($checkedItems);

$conn->close();
?>


