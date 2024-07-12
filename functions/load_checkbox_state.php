<?php
include '../includes/db.php';

$sql = "SELECT pt_id FROM stare_bifata WHERE bifat = 1";
$result = $conn->query($sql);

$checkedItems = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $checkedItems[] = $row['pt_id'];
    }
}

echo json_encode($checkedItems);
?>
