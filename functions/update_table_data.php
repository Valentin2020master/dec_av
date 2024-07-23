<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Access forbidden']);
    exit;
}

include '../includes/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$table = $data['table'];
$id = $data['id'];
$updateData = $data['data'];

$setClause = [];
foreach ($updateData as $key => $value) {
    $setClause[] = "$key = '" . $conn->real_escape_string($value) . "'";
}

$sql = "UPDATE $table SET " . implode(', ', $setClause) . " WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => 'Data updated successfully']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Database update error: ' . $conn->error]);
}

$conn->close();
?>
