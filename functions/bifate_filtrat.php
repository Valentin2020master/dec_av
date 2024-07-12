<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="creator" content="RED-Nord">
    <title>Bifate Filtrat</title>
    <link rel="stylesheet" href="../assets/css/style_bifate.css">
    <script src="../assets/js/script_bifate.js"></script>
</head>
<body>
<h2>Deconectari avariate</h2>

<!-- Filtre -->
<form id="filterForm" method="POST">
    <div>
        <label for="oficiu">Oficiu:</label>
        <?php
        $oficii = ['BL', 'FR', 'RS', 'FL', 'RZ', 'SG', 'UN', 'BR', 'DN', 'DR', 'ED', 'OC', 'SR']; // Lista predefinită de oficii

        foreach ($oficii as $oficiu) {
            $checked = isset($_POST['oficiu']) && in_array($oficiu, $_POST['oficiu']) ? 'checked' : '';
            echo '<input type="checkbox" name="oficiu[]" value="' . htmlspecialchars($oficiu) . '" ' . $checked . '> ' . htmlspecialchars($oficiu);
        }
        ?>
    </div>
</form>

<div>
    <div class="table-container">
        <table>
            <thead class="antet">
            <tr>
                <th>Oficiu</th>
                <th>Statiune</th>
                <th>Fiderul</th>
                <th>PT</th>
                <th>Localitatea</th>
                <th>Adresa</th>
                <th>Apartenenta</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include '../includes/db.php';

            $sql = "SELECT pdc1.oficiu, pdc1.statiune, pdc1.fider, pdc1.pt, pdc1.localitatea, pdc1.adresa, pdc1.apartenenta
                    FROM pdc1
                    JOIN stare_bifata ON pdc1.pt = stare_bifata.pt_id
                    WHERE stare_bifata.bifat = 1";

            if (isset($_POST['oficiu']) && !empty($_POST['oficiu'])) {
                $oficiuFilter = implode("','", array_map([$conn, 'real_escape_string'], $_POST['oficiu']));
                $sql .= " AND pdc1.oficiu IN ('" . $oficiuFilter . "')";
            }

            $sql .= " ORDER BY pdc1.oficiu"; // Sortarea automată după oficiu

            $result = $conn->query($sql);

            if (!$result) {
                die("Eroare la executarea interogării pentru elementele bifate: " . $conn->error);
            }

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['oficiu']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['statiune']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fider']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['pt']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['localitatea']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['adresa']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['apartenenta']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Nu sunt deconectari.</td></tr>";
            }

            $conn->close();
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>


