<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

require_once '../includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

function clean_input($data) {
    $data = trim($data); // Elimină spațiile albe de la început și sfârșit
    $data = stripslashes($data); // Elimină backslash-urile
    $data = htmlspecialchars($data); // Transformă caracterele speciale în entități HTML
    return $data;
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fields = [
            'oficiu', 'statiune', 'fider', 'segment1', 'segment2', 'segment3',
            'segment4', 'segment5', 'segment6', 'segment7', 'segment8', 'pt',
            'casnici', 'economici', 'localitatea', 'adresa', 'apartenenta'
        ];

        $table = clean_input($_POST['table']);
        $allowedTables = ['dis1', 'dis2', 'dis3'];

        if (!in_array($table, $allowedTables)) {
            echo json_encode(['success' => false, 'error' => 'Invalid table']);
            exit;
        }

        $columns = [];
        $placeholders = [];
        $values = [];
        $types = '';

        foreach ($fields as $field) {
            $columns[] = $field;
            $placeholders[] = '?';
            $value = isset($_POST[$field]) && $_POST[$field] !== '' ? clean_input($_POST[$field]) : '';

            $values[] = $value;

            // Determine the type of the field for bind_param
            if (in_array($field, ['casnici', 'economici'])) {
                $types .= 'i';  // integer
            } else {
                $types .= 's';  // string
            }
        }

        $sql = "INSERT INTO $table (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo json_encode(['success' => false, 'error' => 'Failed to prepare statement: ' . $conn->error]);
            exit;
        }

        $stmt->bind_param($types, ...$values);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to execute statement: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>
