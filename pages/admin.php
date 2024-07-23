<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location:actions/login.php");
    exit;
}

require_once '../includes/db.php';

// Functie pentru a prelua datele din tabel
function fetchTableData($conn, $table)
{
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

$dis1Data = fetchTableData($conn, 'dis1');
$dis2Data = fetchTableData($conn, 'dis2');
$dis3Data = fetchTableData($conn, 'dis3');
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="creator" content="RED-Nord">
    <link rel="icon" type="image/x-icon" href="../assets/imagis/red.gif">
    <title>Admin - Editare Date</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php require_once "../includes/header.php"; ?>
<main>
    <h2>Admin - Editare Date</h2>
    <a href="add_record.php" class="button">Adaugă Înregistrare</a> <!-- Adăugarea linkului către pagina de adăugare -->
    <div class="table-container">
        <h3>Dis1_Dis2_Dis3</h3>
        <table>
            <thead class="antet">
            <tr>
                <th>ID</th>
                <th>Oficiu</th>
                <th>Statiune</th>
                <th>Fiderul</th>
                <th>Segmentul1</th>
                <th>Segmentul2</th>
                <th>Segmentul3</th>
                <th>Segmentul4</th>
                <th>Segmentul5</th>
                <th>Segmentul6</th>
                <th>Segmentul7</th>
                <th>Segmentul8</th>
                <th>PT</th>
                <th>Casnici</th>
                <th>Economici</th>
                <th>Localitatea</th>
                <th>Adresa</th>
                <th>Apartenenta</th>
                <th>Salvare</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($dis1Data as $row): ?>
                <tr>
                    <?php foreach ($row as $key => $value): ?>
                        <td contenteditable="true" data-key="<?= $key ?>" data-id="<?= $row['id'] ?>"><?= $value ?></td>
                    <?php endforeach; ?>
                    <td>
                        <button class="save-btn" data-table="dis1" data-id="<?= $row['id'] ?>">Salvează</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tbody>
            <?php foreach ($dis2Data as $row): ?>
                <tr>
                    <?php foreach ($row as $key => $value): ?>
                        <td contenteditable="true" data-key="<?= $key ?>" data-id="<?= $row['id'] ?>"><?= $value ?></td>
                    <?php endforeach; ?>
                    <td>
                        <button class="save-btn" data-table="dis2" data-id="<?= $row['id'] ?>">Salvează</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tbody>
            <?php foreach ($dis3Data as $row): ?>
                <tr>
                    <?php foreach ($row as $key => $value): ?>
                        <td contenteditable="true" data-key="<?= $key ?>" data-id="<?= $row['id'] ?>"><?= $value ?></td>
                    <?php endforeach; ?>
                    <td>
                        <button class="save-btn" data-table="dis3" data-id="<?= $row['id'] ?>">Salvează</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<script src="../assets/js/admin.js"></script>
</body>
</html>


