<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../includes/db.php');

// Funcția getTableForUser care returnează tabela specifică utilizatorului
function getTableForUser($username) {
    // Mapping utilizator -> tabel
    $userTableMapping = [
        'pdc1' => 'dis1',
        'pdc2' => 'dis2',
        'pdc3' => 'dis3',
        // adaugă mai multe mappări după necesitate
    ];

    return isset($userTableMapping[$username]) ? $userTableMapping[$username] : 'pdc1';
}

session_start(); // Începe sesiunea pentru a accesa variabila de sesiune
$username = $_SESSION['username']; // Preia numele utilizatorului din sesiune

// Obține tabelul specific utilizatorului curent
$table = getTableForUser($username);

$pt = $_POST['pt'];


$sql = "SELECT oficiu, statiune, fider, pt, casnici, economici, localitatea, adresa, apartenenta FROM $table WHERE pt = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $pt);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
}
header('Content-Type: application/json');
echo json_encode($data);

$stmt->close();
$conn->close();




?>


