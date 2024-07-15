<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="creator" content="RED-Nord">
    <title>Deconectari avariate</title>
    <link rel="stylesheet" href="../assets/css/style_bifate.css">
    <script src="../assets/js/script_bifate.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Verifică dacă pagina a fost deja redimensionată
            if (!localStorage.getItem('page_resized')) {
                // Marime prestabilită
                var width = 1200;
                var height = 800;

                // Deschide pagina într-o fereastră nouă cu dimensiunile prestabilite
                window.open(window.location.href, '_blank', `width=${width},height=${height}`);

                // Setează flag-ul în localStorage
                localStorage.setItem('page_resized', 'true');

                // Închide fereastra curentă pentru a evita ciclul de redeschidere
                window.close();
            }
        });
    </script>
    <style>
        .BL { background-color: #FFCDD2; }
        .FR { background-color: #E1BEE7; }
        .RS { background-color: #C5CAE9; }
        .FL { background-color: #B3E5FC; }
        .RZ { background-color: #B2DFDB; }
        .SG { background-color: #C8E6C9; }
        .UN { background-color: #FFF9C4; }
        .BR { background-color: #FFECB3; }
        .DN { background-color: #FFE0B2; }
        .DR { background-color: #FFCCBC; }
        .ED { background-color: #D7CCC8; }
        .OC { background-color: #F5F5F5; }
        .SR { background-color: #CFD8DC; }
    </style>
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

            $sql = "
SELECT pdc1.oficiu, pdc1.statiune, pdc1.fider, pdc1.pt, pdc1.localitatea, pdc1.adresa, pdc1.apartenenta
FROM pdc1
JOIN bifate1 ON pdc1.pt = bifate1.pt_id
WHERE bifate1.bifat = 1";

            if (isset($_POST['oficiu']) && !empty($_POST['oficiu'])) {
                $oficiuFilter = implode("','", array_map([$conn, 'real_escape_string'], $_POST['oficiu']));
                $sql .= " AND pdc1.oficiu IN ('" . $oficiuFilter . "')";
            }

            $sql .= "
UNION ALL

SELECT pdc2.oficiu, pdc2.statiune, pdc2.fider, pdc2.pt, pdc2.localitatea, pdc2.adresa, pdc2.apartenenta
FROM pdc2
JOIN bifate2 ON pdc2.pt = bifate2.pt_id
WHERE bifate2.bifat = 1";

            if (isset($_POST['oficiu']) && !empty($_POST['oficiu'])) {
                $sql .= " AND pdc2.oficiu IN ('" . $oficiuFilter . "')";
            }

            $sql .= "
UNION ALL

SELECT pdc3.oficiu, pdc3.statiune, pdc3.fider, pdc3.pt, pdc3.localitatea, pdc3.adresa, pdc3.apartenenta
FROM pdc3
JOIN bifate3 ON pdc3.pt = bifate3.pt_id
WHERE bifate3.bifat = 1";

            if (isset($_POST['oficiu']) && !empty($_POST['oficiu'])) {
                $sql .= " AND pdc3.oficiu IN ('" . $oficiuFilter . "')";
            }

            $sql .= " ORDER BY oficiu";

            $result = $conn->query($sql);

            if (!$result) {
                die("Eroare la executarea interogării pentru elementele bifate: " . $conn->error);
            }

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $oficiuClass = htmlspecialchars($row['oficiu']);
                    echo "<tr class='{$oficiuClass}'>";
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
