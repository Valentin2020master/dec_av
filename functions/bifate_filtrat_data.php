<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../includes/db.php';

$sql = "SELECT pdc1.oficiu, pdc1.statiune, pdc1.fider, pdc1.pt, pdc1.localitatea, pdc1.adresa, pdc1.apartenenta
        FROM pdc1
        JOIN stare_bifata ON pdc1.pt = stare_bifata.pt_id
        WHERE stare_bifata.bifat = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['oficiu']}</td>";
        echo "<td>{$row['statiune']}</td>";
        echo "<td>{$row['fider']}</td>";
        echo "<td>{$row['pt']}</td>";

        echo "<td>{$row['localitatea']}</td>";
        echo "<td>{$row['adresa']}</td>";
        echo "<td>{$row['apartenenta']}</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>Totul in regula.</td></tr>";
}
$conn->close();





?>





<?php
//
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//include 'includes/db.php';
//$sql = "SELECT oficiu, statiune, fider, pt, localitatea, adresa, apartenenta FROM stare_bifata1 WHERE checked = 1";
//$result = $conn->query($sql);
//
//$bifateItems = array();
//
//if ($result->num_rows > 0) {
//    while ($row = $result->fetch_assoc()) {
//        $bifateItems[] = $row;
//    }
//}
//
//$conn->close();
//
//header('Content-Type: application/json');
//echo json_encode($bifateItems);
//?>
