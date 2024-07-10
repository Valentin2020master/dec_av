<?php
include 'includes/db.php';

$pt = $_POST['pt'];

$sql = "SELECT oficiu, statiune, fider, pt, casnici, economici, localitatea, adresa, apartenenta FROM pdc1 WHERE pt = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $pt);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
}

echo json_encode($data);

$stmt->close();
$conn->close();
?>
