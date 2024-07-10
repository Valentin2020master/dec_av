<!-- details.php -->
<div class="details">
    <table border="1">
        <thead>
        <tr>
            <th>Filial</th>
            <th>Statia</th>
            <th>Fider</th>
            <th>Sectia</th>
            <th>PD</th>
            <th>FiderPD</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Exemplu de date. Într-o aplicație reală, acestea vor veni dintr-o bază de date sau un fișier JSON/XML.
        $details = [
            ["FLO", "Floresti 110/35/10", "FR20", "0", "0", "PT04"],
            ["FLO", "Floresti 110/35/10", "FR20", "0", "0", "PT04"],
            // etc...
        ];

        foreach ($details as $detail) {
            echo "<tr>";
            foreach ($detail as $data) {
                echo "<td>$data</td>";
            }
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

