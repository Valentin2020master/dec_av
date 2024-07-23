<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Toate câmpurile sunt obligatorii.";
        header("Location: ../actions/login.php");
        exit();
    }

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Stocăm rolul utilizatorului în sesiune

        // Redirecționare bazată pe rolul utilizatorului
        switch ($_SESSION['username']) {
            case 'admin':
                header("Location: ../pages/admin.php");
                break;
//            case 'pdc1':
//                header("Location: ../pages/pdc1.php");
//                break;
//            case 'pdc2':
//                header("Location: ../pages/pdc2.php");
//                break;
//            case 'pdc3':
//                header("Location: ../pages/pdc3.php");
//                break;
            default:
                header("Location: ../index.php");
                break;
        }
        exit();
    } else {
        $_SESSION['error'] = "Nume utilizator sau parolă incorectă!";
        header("Location: ../actions/login.php");
        exit();
    }
}
?>
