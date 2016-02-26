<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
    <head>
        <title>Pétanque in Nordbaden - Rhein-Neckar-Liga</title>
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <?php
        $sites = array("bbpv_pokal", "turniere", "vereine", "ligaleitung", "rnl_ligapokal", "lizenz", "bbpv_info", "dokumente", "spielplan", "bilder", "sportordnung", "liga", "impressum");
        //gewaehlte Seite
        $getsite = $_GET["site"];
        //wenn $getsite keinen der in $sites definierten Werte hat dann ist $getsite=e =aktuell
        if (in_array($getsite, $sites) == FALSE) {
            $getsite = "docs/n_aktuell";
        } else {
            $getsite = "docs/n_" . $getsite;
            //header("Location: docs/index_versuch.php?.$getsite");
        }
        $getsite.=".php";
        ?>
    </head>
    <body>
                    <?php
                    include($getsite);
                    //wenn Seiten nur wenig Inhalt haben, ist unten ein Abstand zwischen Content und footer, daher:
                    ?>
                </div>
    </body>
</html>