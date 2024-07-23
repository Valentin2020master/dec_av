<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="creator" content="RED-Nord">
    <link rel="icon" type="image/x-icon" href="../assets/imagis/red.gif">
    <title>Deconectari avariate</title>
    <link rel="stylesheet" href="../assets/css/style_bifate.css">
    <script src="../assets/js/script_bifate.js"></script>

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
<!-- Câmp de căutare -->
<div>
    <label for="searchInput">Caută:</label>
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Caută în deconectari...">
</div>

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
    <div class="table-decon">
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
            <tbody id="dataTable">
            <?php
            require_once '../includes/db.php';

            $sql = "
SELECT dis1.oficiu, dis1.statiune, dis1.fider, dis1.pt, dis1.localitatea, dis1.adresa, dis1.apartenenta
FROM dis1
JOIN bifate1 ON dis1.pt = bifate1.pt_id
WHERE bifate1.bifat = 1";

            if (isset($_POST['oficiu']) && !empty($_POST['oficiu'])) {
                $oficiuFilter = implode("','", array_map([$conn, 'real_escape_string'], $_POST['oficiu']));
                $sql .= " AND dis1.oficiu IN ('" . $oficiuFilter . "')";
            }

            $sql .= "
UNION ALL

SELECT dis2.oficiu, dis2.statiune, dis2.fider, dis2.pt, dis2.localitatea, dis2.adresa, dis2.apartenenta
FROM dis2
JOIN bifate2 ON dis2.pt = bifate2.pt_id
WHERE bifate2.bifat = 1";

            if (isset($_POST['oficiu']) && !empty($_POST['oficiu'])) {
                $sql .= " AND dis2.oficiu IN ('" . $oficiuFilter . "')";
            }

            $sql .= "
UNION ALL

SELECT dis3.oficiu, dis3.statiune, dis3.fider, dis3.pt, dis3.localitatea, dis3.adresa, dis3.apartenenta
FROM dis3
JOIN bifate3 ON dis3.pt = bifate3.pt_id
WHERE bifate3.bifat = 1";

            if (isset($_POST['oficiu']) && !empty($_POST['oficiu'])) {
                $sql .= " AND dis3.oficiu IN ('" . $oficiuFilter . "')";
            }

            $sql .= " ORDER BY oficiu, statiune";

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
                echo "<tr><td colspan='7'>Nu sunt deconectari avariate.</td></tr>";
            }

            $conn->close();
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function searchTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toUpperCase();
        const table = document.getElementById("dataTable");
        const rows = table.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName("td");
            let match = false;

            for (let j = 0; j < cells.length; j++) {
                if (cells[j]) {
                    if (cells[j].innerText.toUpperCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
            }

            if (match) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
</script>
</body>
</html>
