<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirecționare bazată pe numele utilizatorului
        if ($username == 'admin') {
            header("Location: admin.php");
        } elseif ($username == 'pdc1') {
            header("Location: ../pages/pdc1.php");
        } elseif ($username == 'pdc2') {
            header("Location: ../pages/pdc2.php");
        } elseif ($username == 'pdc3') {
            header("Location: ../pages/pdc3.php");
        } else {
            header("Location: ../pages/index.php");
        }
        exit();
    } else {
        echo "Nume utilizator sau parolă incorectă!";
    }
}
?>
