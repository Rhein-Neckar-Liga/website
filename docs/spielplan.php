            <?php
            echo "<h1 class='ueberschrift'>Ligaspieltage der Rhein-Neckar-Region</h1>";
            include_once "includes/clsSite.php";
            $content = new clsSite();
            $content->showSpieltage();
            ?>
 