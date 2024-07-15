<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pt = $_POST['pt'];
    $checked = $_POST['checked'];

    // Asigură-te că $pt și $checked sunt sanitizate
    $pt = $conn->real_escape_string($pt);
    $checked = (int)$checked;

    // Verifică dacă există deja o înregistrare pentru acest pt
    $sql = "SELECT * FROM bifate1 WHERE pt_id = '$pt'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Actualizează starea dacă există deja înregistrarea
        $sql = "UPDATE bifate1 SET bifat = '$checked' WHERE pt_id = '$pt'";
    } else {
        // Inserează o nouă înregistrare dacă nu există
        $sql = "INSERT INTO bifate1 (pt_id, bifat) VALUES ('$pt', '$checked')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Starea checkboxului a fost actualizată cu succes.";
    } else {
        echo "Eroare la actualizarea stării checkboxului: " . $conn->error;
    }

    $conn->close();
}
?>
