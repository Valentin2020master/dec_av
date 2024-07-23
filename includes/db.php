<?php
$servername = "localhost";
$username = "root";
$password = "1";
$dbname = "red1";

// Crearea conexiunii
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");
// Verificarea conexiunii
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}
?>
