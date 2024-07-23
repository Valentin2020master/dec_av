<?php
function fetchNodes($parentConditions, $level, $conn)
{
    // Preluăm numele utilizatorului din sesiune
    session_start();
    $username = $_SESSION['username'];

    // Stabilim tabelul în funcție de utilizator
    $table = getTableForUser($username);

    $fields = ['oficiu', 'statiune', 'fider', 'segment1', 'segment2', 'segment3', 'segment4', 'segment5', 'segment6', 'segment7', 'segment8'];
    $currentField = $fields[$level];
    $sql = "SELECT DISTINCT $currentField FROM $table WHERE $parentConditions ORDER BY $currentField";
    $result = $conn->query($sql);
    if (!$result) {
        echo "Eroare SQL: " . $conn->error;
        return;
    }
    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            $value = $row[$currentField];
            $nextParentConditions = "$parentConditions AND $currentField = '$value'";
            if ($value === '0' || $value === '') {
                fetchPTNodes($nextParentConditions, $conn, $table);
                continue;
            }
            echo "<li>";
            echo "<details>";
            echo "<summary>";
            echo "<input type='checkbox' class='pt-checkbox' data-pt='$value'><span>$value</span>";
            echo "</summary>";
            if ($level < count($fields) - 1) {
                fetchNodes($nextParentConditions, $level + 1, $conn);
            } else {
                echo "<ul>";
                fetchPTNodes($nextParentConditions, $conn, $table);
                echo "</ul>";
            }
            echo "</details>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        fetchPTNodes($parentConditions, $conn, $table);
    }
}

function fetchPTNodes($parentConditions, $conn, $table)
{
    $sql = "SELECT pt, oficiu, fider, statiune, casnici, economici, localitatea, adresa, apartenenta FROM $table WHERE $parentConditions AND pt IS NOT NULL AND pt != ''";
    $result = $conn->query($sql);
    if (!$result) {
        echo "Eroare SQL: " . $conn->error;
        return;
    }
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Concatenarea valorilor pentru ultima coloană
            $concatenatedValue = $row['pt'] . ' - ' . $row['localitatea'] . ' - ' . $row['adresa'];

            echo "<li>";
            echo "<input type='checkbox' class='pt-checkbox' data-pt='" . htmlspecialchars($row['pt']) . "' data-oficiu='" . htmlspecialchars($row['oficiu']) . "' data-fider='" . htmlspecialchars($row['fider']) . "' data-statiune='" . htmlspecialchars($row['statiune']) . "' data-localitatea='" . htmlspecialchars($row['localitatea']) . "' data-adresa='" . htmlspecialchars($row['adresa']) . "' data-apartenenta='" . htmlspecialchars($row['apartenenta']) . "'>";
            echo "<span>" . htmlspecialchars($concatenatedValue) . "</span>";
            echo "</li>";
        }
    }
}


function getTableForUser($username) {
    // Mapping utilizator -> tabel
    $userTableMapping = [
        'pdc1' => 'dis1',
        'pdc2' => 'dis2',
        'pdc3' => 'dis3',
        // adaugă mai multe mappări după necesitate
    ];

    return isset($userTableMapping[$username]) ? $userTableMapping[$username] : 'dis1';
}
?>
