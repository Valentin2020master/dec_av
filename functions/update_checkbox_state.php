<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(__DIR__ . '/../includes/db.php');

// Funcția getTableForUser care returnează tabela specifică utilizatorului
function getTableForUser($username) {
    // Mapping utilizator -> tabel
    $userTableMapping = [
        'pdc1' => 'bifate1',
        'pdc2' => 'bifate2',
        'pdc3' => 'bifate3',
        // adaugă mai multe mappări după necesitate
    ];

    return isset($userTableMapping[$username]) ? $userTableMapping[$username] : 'pdc1';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start(); // Începe sesiunea pentru a accesa variabila de sesiune
    $username = $_SESSION['username']; // Preia numele utilizatorului din sesiune
    $checkboxes = json_decode(file_get_contents('php://input'), true);

    // Obține tabelul specific utilizatorului curent
    $table = getTableForUser($username);

    foreach ($checkboxes as $checkbox) {
        $pt = $conn->real_escape_string($checkbox['pt']);
        $checked = (int)$checkbox['checked'];

        // Verifică dacă există deja o înregistrare pentru acest pt
        $sql = "SELECT * FROM $table WHERE pt_id = '$pt'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Actualizează starea dacă există deja înregistrarea
            $sql = "UPDATE $table SET bifat = '$checked' WHERE pt_id = '$pt'";
        } else {
            // Inserează o nouă înregistrare dacă nu există
            $sql = "INSERT INTO $table (pt_id, bifat) VALUES ('$pt', '$checked')";
        }

        if (!$conn->query($sql)) {
            echo "Eroare la actualizarea stării checkboxului: " . $conn->error;
            exit;
        }
    }

    echo "Starea checkboxurilor a fost actualizată cu succes.";
    $conn->close();
}
