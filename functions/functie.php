<?php
//function fetchNodes($parentConditions, $level, $conn)
//{
//    $fields = ['oficiu', 'statiune', 'fider', 'segment1', 'segment2', 'segment3', 'segment4', 'segment5', 'segment6', 'segment7', 'segment8'];
//    $currentField = $fields[$level];
//    $sql = "SELECT DISTINCT $currentField FROM pdc1 WHERE $parentConditions ORDER BY $currentField";
//    $result = $conn->query($sql);
//    if (!$result) {
//        echo "Eroare SQL: " . $conn->error;
//        return;
//    }
//    if ($result->num_rows > 0) {
//        echo "<ul>";
//        while ($row = $result->fetch_assoc()) {
//            $value = $row[$currentField];
//            $nextParentConditions = "$parentConditions AND $currentField = '$value'";
//            if ($value === '0' || $value === '') {
//                fetchPTNodes($nextParentConditions, $conn);
//                continue;
//            }
//            echo "<li>";
//            echo "<details>";
//            echo "<summary>";
//            echo "<input type='checkbox' class='pt-checkbox' data-pt='$value'><span>$value</span>";
//            echo "</summary>";
//            if ($level < count($fields) - 1) {
//                fetchNodes($nextParentConditions, $level + 1, $conn);
//            } else {
//                echo "<ul>";
//                fetchPTNodes($nextParentConditions, $conn);
//                echo "</ul>";
//            }
//            echo "</details>";
//            echo "</li>";
//        }
//        echo "</ul>";
//    } else {
//        fetchPTNodes($parentConditions, $conn);
//    }
//}
//
//function fetchPTNodes($parentConditions, $conn)
//{
//    $sql = "SELECT pt, oficiu, fider, statiune, casnici, economici, localitatea, adresa, apartenenta FROM pdc1 WHERE $parentConditions AND pt IS NOT NULL AND pt != ''";
//    $result = $conn->query($sql);
//    if (!$result) {
//        echo "Eroare SQL: " . $conn->error;
//        return;
//    }
//    if ($result->num_rows > 0) {
//        while ($row = $result->fetch_assoc()) {
//            echo "<li><input type='checkbox' class='pt-checkbox' data-pt='" . $row['pt'] . "' data-oficiu='" . $row['oficiu'] . "' data-fider='" . $row['fider'] . "' data-statiune='" . $row['statiune'] . "' data-localitatea='" . $row['localitatea'] . "' data-adresa='" . $row['adresa'] . "' data-apartenenta='" . $row['apartenenta'] . "'><span>" . $row['pt'] . " - " . $row['adresa'] . "</span></li>";
//        }
//    }
//}
//?>



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
            echo "<li><input type='checkbox' class='pt-checkbox' data-pt='" . $row['pt'] . "' data-oficiu='" . $row['oficiu'] . "' data-fider='" . $row['fider'] . "' data-statiune='" . $row['statiune'] . "' data-localitatea='" . $row['localitatea'] . "' data-adresa='" . $row['adresa'] . "' data-apartenenta='" . $row['apartenenta'] . "'><span>" . $row['pt'] . " - " . $row['adresa'] . "</span></li>";
        }
    }
}

function getTableForUser($username) {
    // Mapping utilizator -> tabel
    $userTableMapping = [
        'pdc1' => 'pdc1',
        'pdc2' => 'pdc2',
        'pdc3' => 'pdc3',
        // adaugă mai multe mappări după necesitate
    ];

    return isset($userTableMapping[$username]) ? $userTableMapping[$username] : 'pdc1';
}
?>
