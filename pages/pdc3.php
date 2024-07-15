<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="creator" content="RED-Nord">
    <title>RED-Nord</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include "../includes/header.php" ?>
<main>
    <div>
        <button id="deselecteaza-toate" class="button">Deselectează toate</button>
        <a href="../actions/logout.php" class="button">Delogare</a>
    </div>
    <div class="container">
        <div class="tab_stinga">
            <div class="table-container">
                <table>
                    <thead>
                    <tr>
                        <th>PDC3</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td id="principal-list" class="tree">
                            <?php
                            include '../includes/db.php';
                            include '../functions/functie.php';
                            $parentConditions = "1=1";
                            fetchNodes($parentConditions, 0, $conn);
                            ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab_dreapta">
            <div class="table-container">
                <table>
                    <thead class="antet">
                    <tr>
                        <th>Oficiu</th>
                        <th>Statiune</th>
                        <th>Fiderul</th>
                        <th>PT</th>
                        <th>Casnici</th>
                        <th>Economici</th>
                        <th>Localitatea</th>
                        <th>Adresa</th>
                        <th>Apartenenta</th>

                    </tr>
                    </thead>
                    <tbody id="bifate-list">
                    <!-- Lista în care vor apărea elementele bifate -->
                    </tbody>
                    <tr>
                        <td colspan="4" class="subsol">Total</td>
                        <td class="subsol"><?php ?></td>
                        <td class="subsol"><?php ?></td>
                        <td colspan="3" class="subsol"><?php ?></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

</main>
<script src="../assets/js/script3.js"></script>

<?php //include "includes/footer.php"?>
</body>
</html>
