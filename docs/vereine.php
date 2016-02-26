            <?php
            echo "<h1 class='ueberschrift'>Vereine der Rhein-Neckar-Liga</h1>";
            include_once "includes/clsSite.php";
            $content = new clsSite();
            $content->showVereine();
            ?>
