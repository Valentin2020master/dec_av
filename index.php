<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="creator" content="RED-Nord">
    <title>RED-Nord</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include "includes/header.php" ?>
<main>
    <div>
        <button id="deselecteaza-toate">Deselectează toate</button>
    </div>
    <div class="container">
        <div class="tab_stinga">
            <div class="table-container">
                <table>
                    <thead>
                    <tr>
                        <th>PDC1</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td id="principal-list" class="tree">
                            <?php
                            include 'includes/db.php';
                            include 'includes/functie.php';
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
                </table>
            </div>
        </div>

    </div>

</main>
<script src="js/script.js"></script>

<?php //include "includes/footer.php"?>
</body>
</html>
