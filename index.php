<?php
session_start();
if (!isset($_SESSION['user_id'])) {
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
    <link rel="icon" type="image/x-icon" href="./assets/imagis/red.gif">
    <title>RED-Nord</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<?php require_once "./includes/header.php" ?>
<main>
    <div class="container">
        <div class="tab_stinga">
            <div class="table-container">
                <table>
                    <thead class="antet">
                    <tr>
                        <th><?php echo strtoupper(htmlspecialchars($_SESSION['username'])); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td id="principal-list" class="tree">
                            <?php
                            require_once './includes/db.php';
                            require_once './functions/functie.php';
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
                        <th class="oficiu">Oficiu</th>
                        <th>Statiune</th>
                        <th class="oficiu">Fiderul</th>
                        <th>PT</th>
                        <th class="oficiu">Casnici</th>
                        <th class="oficiu">Economici</th>
                        <th>Localitatea</th>
                        <th>Adresa</th>
                        <th>Apartenenta</th>

                    </tr>
                    </thead>
                    <tbody id="bifate-list">
                    <!-- Lista în care vor apărea elementele bifate -->
                    </tbody>
                    <tr>
                    <tr>
                        <td colspan="4" class="subsol">Total</td>
                        <td id="total-casnici" class="subsol">0</td>
                        <td id="total-economici" class="subsol">0</td>
                        <td colspan="3" id="localitati-unice" class="subsol"></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

</main>
<script src="./assets/js/script.js"></script>
<script>
    
</script>
<?php require_once "includes/footer.php"?>
</body>
</html>
