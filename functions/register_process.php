
<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Inserarea utilizatorului în baza de date
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Înregistrare reușită! Acum te poți loga.";
        header("Location: ../pages/login.php");
        exit();
    } else {
        echo "Eroare la înregistrare: " . $stmt->error;
    }
}
?>
