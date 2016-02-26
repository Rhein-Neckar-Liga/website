<?php

error_reporting(0);
//den folgenden Text bitte anpassen
$einleitungstext = "
					<div class='beitrag'>Hier sind in Zukunft Bilder von Ligaspieltagen, Pokalspielen oder auch von Euren Turnieren zu finden. <br />
					Wenn Ihr Bilder von Euren Turnieren hier veröffentlichen möchtet, oder sonst irgendwelche Fragen oder Kommentare habt, wendet Euch bitte an die <a href='mailto:ligaleitung@rhein-neckar-liga.de'>Ligaleitung </a><br />
					Viel Spass beim Stöbern!</div>
					";
//Pfad in dem die Albengruppen abgelegt werden
$bildpfad = "images/alben/";
//relativen Pfad zusammensetzen
$relpfad = "../" . $bildpfad;
//falls es zuhause getestet werden soll, muss der Pfad wegen der Xamp Installation etwas umgeschrieben werden
//wir füllen die Variable $maindir in Abhängikeit unserer Umgebung
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $maindir = $_SERVER['DOCUMENT_ROOT'] . "/rhein-neckar-liga.de/" . $bildpfad;
}
//sonst können wir das über DOCUMENT_ROOT ermitteln
else {
    $maindir = $_SERVER['DOCUMENT_ROOT'] . $bildpfad;
}
//Prüfen ob die Kategorie (Jahr) und der Albenname übergeben wurden und das Verzeichnis auch existiert
$getyear = $_GET["year"];
$getalbum = $_GET["album"];
$directoryname = $getyear . "/" . $getalbum;
if (isset($_GET["year"]) and isset($_GET["album"]) and (false !== file_exists($maindir . $directoryname))) {
    //Album ist gesetzt, Verzeichnis exisiert
    echo "<div class='album'>";
    echo "<p><a href='bilder.php'>alle Alben anzeigen</a></p>";
    echo "<h1>" . $getalbum . " " . $getyear . "</h1>";
    $filename = $relpfad . $directoryname . "/bildindex.xml";
    //nur anzeigen wenn eine solche datei existiert DEBUG funzt noch net
    if (file_exists($filename)) {
        $xml_file = simplexml_load_file($filename);
        $result = $xml_file->xpath("bildindex");
        foreach ($result as $wert) {
            echo "<div class='album'>"; //border:1px solid #000;  style='padding:10px;border:1px solid #000;background-color:#fff;'
            echo $wert->beschreibung;
            echo "</div>";
        }
    }
    //
    $dir = opendir($maindir . $getyear . "/" . $getalbum);
    while (false !== ($file = readdir($dir))) {
        $parts = explode(".", $file);
        if (is_array($parts) && count($parts) > 1) {
            $extension = end($parts);
            if ($extension == "jpg" OR $extension == "JPG")    // is extension ext or EXT ?
            //den Array files mit den Dateinamen füllen
                $files[] = $file;
        }
    }
    //den Array alphabetisch sortieren damit die Bilder in der richtigen Reihenfolge erscheinen
    sort($files);
    foreach ($files as $file) {  //jedes thumb mit link zum Original ausgeben
        echo '<a href="' . $relpfad . $getyear . "/" . $getalbum . "/" . $file . '" rel="gb_imageset[]"><img class="gallerie" src="' . $relpfad . $getyear . "/" . $getalbum . "/thumbs/th_" . $file . '" title="' . $getalbum . '" alt="' . $getalbum . '" style="width:120px;height:90px;"/></a>';
    }
    echo "</div>";
    closedir($dir);        // Verzeichnis wieder schliessen, wir sind durch
} else //Album nicht gesetzt bzw Verzeichnis exisitert nicht {
    echo $einleitungstext;
    // Verzeichnis-Liste
    $verz = openDir($maindir);
    while (false !== ($file = readDir($verz))) {
        if ($file != "." && $file != ".." && substr_count($file, ".") == 0) {
            $arrayVerz[] = $file;
        }
    }
    arsort($arrayVerz);
    closeDir($verz);
    foreach ($arrayVerz as $file) {
        if ($file != "." && $file != ".." && substr_count($file, ".") == 0 && substr($file, 0, 1) != "@") {
            echo "<br style='clear:all;' /><div class='album' ><h1>" . $file . "</h1>";
            $unteradresse = $maindir . $file; // Pfad angeben
            $unterverz = openDir($unteradresse);
            while ($unterfile = readDir($unterverz)) {
                if ($unterfile != "." && $unterfile != ".." && substr_count($unterfile, ".") == 0 ) {
                    echo "<div class='directory'><a href='bilder.php?year=" . $file . "&amp;album=" . $unterfile . "'>";
                    //Vorschaubild nur einbinden wenn es existiert, sonst Standardbild verwenden
                    if (file_exists($maindir . $file . "/" . $unterfile . "/dirimage.jpeg")) {
                        echo "<img alt='" . $unterfile . "' src='" . $relpfad . $file . "/" . $unterfile . "/dirimage.jpeg' style='height:70px;width:100px;'/>";
                    } else {
                        echo "<img alt='" . $unterfile . "' src='" . $relpfad . "musterimage.png' style='height:70px;width:100px;'/>";
                    }
                    echo "<br/>" . $unterfile . "</a>";
                    echo "</div>";
                }
            }
            echo "</div>";
            closeDir($unterverz);
        }
    
};
?>