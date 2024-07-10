<div class="sidebar">
    <ul>
        <?php
        // Exemplu de date. Într-o aplicație reală, acestea vor veni dintr-o bază de date sau un fișier JSON/XML.
        $items = [
            "PT107FR20 - s.Sitriceni - Populatie",
            "PT111FR20 - or.Floresti - str T.Ciorba Melioratia, extravilan",
            "PT118FR20 - s.Varvareuca - Statia tel, extravilan",
            // etc...
        ];

        foreach ($items as $item) {
            echo "<li><label><input type='checkbox'> $item</label></li>";
        }
        ?>
    </ul>
</div>
