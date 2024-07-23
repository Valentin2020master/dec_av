<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location:actions/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="creator" content="RED-Nord">
    <link rel="icon" type="image/x-icon" href="../assets/imagis/red.gif">
    <title>Adaugă Înregistrare</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include "../includes/header.php" ?>
<a href="admin.php" class="button">Admin</a>
<main>
    <h4>Adaugă Înregistrare Nouă</h4>
    <form id="add-record-form">
        <label for="oficiu">Oficiu:</label>
        <input type="text" id="oficiu" name="oficiu" required><br>

        <label for="statiune">Statiune:</label>
        <input type="text" id="statiune" name="statiune" required><br>

        <label for="fider">Fiderul:</label>
        <input type="text" id="fider" name="fider" required><br>

        <label for="segment1">Segmentul1</label>
        <input type="text" id="segment1" name="segment1"><br>

        <label for="segment2">Segmentul2</label>
        <input type="text" id="segment2" name="segment2"><br>

        <label for="segment3">Segmentul3</label>
        <input type="text" id="segment3" name="segment3"><br>

        <label for="segment4">Segmentul4</label>
        <input type="text" id="segment4" name="segment4"><br>

        <label for="segment5">Segmentul5</label>
        <input type="text" id="segment5" name="segment5"><br>

        <label for="segment6">Segmentul6</label>
        <input type="text" id="segment6" name="segment6"><br>

        <label for="segment7">Segmentul7</label>
        <input type="text" id="segment7" name="segment7"><br>

        <label for="segment8">Segmentul8</label>
        <input type="text" id="segment8" name="segment8"><br>

        <label for="pt">PT:</label>
        <input type="text" id="pt" name="pt" required><br>

        <label for="casnici">Casnici:</label>
        <input type="number" id="casnici" name="casnici" required><br>

        <label for="economici">Economici:</label>
        <input type="number" id="economici" name="economici" required><br>

        <label for="localitatea">Localitatea:</label>
        <input type="text" id="localitatea" name="localitatea" required><br>

        <label for="adresa">Adresa:</label>
        <input type="text" id="adresa" name="adresa" required><br>

        <label for="apartenenta">Apartenenta:</label>
        <input type="text" id="apartenenta" name="apartenenta" required><br>

        <label for="table">Selectează Tabela:</label>
        <select id="table" name="table" required>
            <option value="dis1">dis1</option>
            <option value="dis2">dis2</option>
            <option value="dis3">dis3</option>
        </select><br>

        <button type="submit">Adaugă</button>
    </form>
    <p id="message"></p>
</main>
<script src="../assets/js/add_record.js"></script>
</body>
</html>
