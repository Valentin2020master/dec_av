<?php
session_start();
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Preluarea și validarea intrărilor
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Toate câmpurile sunt obligatorii.";
        header("Location: ../actions/register.php");
        exit();
    }

    // Hasharea parolei
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Verificarea existenței utilizatorului în baza de date
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Username-ul este deja folosit.";
        header("Location: ../actions/register.php");
        exit();
    }

    // Inserarea utilizatorului în baza de date cu rolul 'user'
    $stmt->close(); // Închide declarația anterioară
    $role = 'user'; // Rolul prestabilit
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $username, $passwordHash, $role);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Înregistrare reușită! Acum te poți loga.";
        header("Location: ../actions/login.php");
        exit();
    } else {
        echo "Eroare la înregistrare: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirecționează la pagina de înregistrare dacă metoda cererii nu este POST
    header("Location: ../actions/register.php");
    exit();
}
?>
