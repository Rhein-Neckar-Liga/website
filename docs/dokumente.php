            <?php
            echo "<h1 class='ueberschrift'>Dokumente</h1>";
            include_once "includes/clsSite.php";
            $content = new clsSite();
            $content->showDokumente();
            ?>
