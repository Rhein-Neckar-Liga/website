<?php
include_once "../includes/clsSite.php";
include_once '../includes/clsDb.php';

$site=new clsSite();

switch ($_POST["action"]){
	case "stop": //gibt es nicht, wird per get erledigt, Insert into Archiv einbauen
		break;
	case "edit":
		$spieltage=getPost($_POST["idSpieltag"]);
		editDB($spieltage);
		getPost();
		break;
	case "insert":
        $spieltage=getPost();
    	insertDB($spieltage);
		getPost();
		break;
	case "spielplanhinweis":
		$spielplanhinweis=getPostSpielplanhinweis();
    	editSpielplanhinweis($spielplanhinweis);
		break;
}
switch ($_GET["action"]){
	case "stop":
        $spieltag=getSpieltag($_GET["id"]);
        stopDB($spieltag);
        $site->showSpieltage(true);
		break;
	case "edit":
		showForm($_GET["id"]);
		break;
	case "insert":
		showForm();
		break;
    case "publish":
        $spieltag=getSpieltag($_GET["id"]);
        publishDB($spieltag);
       $site->showSpieltage(true);
        break;
	default:
		$site->showSpieltage(true);
}
function showForm($index=false){
		echo "<form method ='post' action='?site=spielplan'><table>";
	if($index){
		$spieltag=getSpieltag($index);
		echo "<input type ='hidden' name='idSpieltag' value ='$index'/>";
	}
		echo "<tr><td><label for='aktiv'>Aktiv</label></td><td><input type='text' name='aktiv' size='100' maxlength ='500' value='".$spieltag["aktiv"]."' /></td></tr>";
		echo "<tr><td><label for='Datum'>Datum</label></td><td><input type='text' name='Datum' size='100' maxlength ='500' value='".date("d.m.Y", strtotime($spieltag["Datum"]))."' /></td></tr>";
		echo "<tr><td><label for='Oberliga'>Oberliga</label></td><td><input type='text' name='Oberliga' size='100' maxlength ='500' value='".$spieltag["Oberliga"]."' /></td></tr>";
		echo "<tr><td><label for='Landesliga'>Landesliga</label></td><td><input type='text' name='Landesliga' size='100' maxlength ='500' value='".$spieltag["Landesliga"]."' /></td></tr>";
		echo "<tr><td><label for='Bezirksliga'>Bezirksliga</label></td><td><input type='text' name='Bezirksliga' size='100' maxlength ='500' value='".$spieltag["Bezirksliga"]."' /></td></tr>";
		echo "<tr><td><label for='Kreisliga'>Kreisliga</label></td><td><input type='text' name='Kreisliga' size='100' maxlength ='500' value='".$spieltag["Kreisliga"]."' /></td></tr>";
		echo "<tr><td><label for='Jugendliga'>Jugendliga</label></td><td><input type='text' name='Jugendliga' size='100' maxlength ='500' value='".$spieltag["Jugendliga"]."' /></td></tr>";
		echo "</table>";
		
		if ($index)
		{
		echo "<input type ='hidden' name='action' value ='edit'/>";
		}
		else {
		echo "<input type ='hidden' name='action' value ='insert'/>";
		}
		echo "<input type='image' class='button' src='images/icons/save.png'  alt='Absenden'/>";
		echo "<a href='index.php?site=spielplan'><img alt='Cancel' class='button' src='images/icons/cancel.png' /></a>";
		echo "</form>";
}

function getSpieltag($index){
	$dbh = clsDb::connect();
	$sql="SELECT * FROM tblSpieltage WHERE idSpieltag=$index";
	foreach ($dbh->query($sql) as $row){
	$spieltage=array();
	$spieltage["idSpieltag"]=$index;
	$spieltage["aktiv"]=$row["aktiv"];
	$spieltage["Datum"]=$row["Datum"];
	$spieltage["Oberliga"]=$row["Oberliga"];
	$spieltage["Landesliga"]=$row["Landesliga"];
	$spieltage["Bezirksliga"]=$row["Bezirksliga"];
	$spieltage["Kreisliga"]=$row["Kreisliga"];
	$spieltage["Jugendliga"]=$row["Jugendliga"];
	return $spieltage;
	}
}
function getPost(){
	$spieltage=array();
	$spieltage["idSpieltag"]=$_POST["idSpieltag"];
	$spieltage["aktiv"]=$_POST["aktiv"];
	$spieltage["Datum"]=date("Y-m-d", strtotime($_POST["Datum"]));
	$spieltage["Oberliga"]=$_POST["Oberliga"];
	$spieltage["Landesliga"]=$_POST["Landesliga"];
	$spieltage["Bezirksliga"]=$_POST["Bezirksliga"];
	$spieltage["Kreisliga"]=$_POST["Kreisliga"];
	$spieltage["Jugendliga"]=$_POST["Jugendliga"];
	return $spieltage;
}
function getPostSpielplanhinweis(){
	$spielplanhinweis=$_POST["hinweis"];
	return $spielplanhinweis;
}
function editSpielplanhinweis($spielplanhinweis){
                $datei = '../docs/spielplanhinweis.php';
                        if (is_writable($datei)) {
                            // Wir öffnen $filename im "Anhänge" - Modus.
                            // Der Dateizeiger befindet sich am Ende der Datei, und
                            // dort wird $spielplanhinweis später mit fwrite() geschrieben.
                            if (!$handle = fopen($datei, "w+")) {
                                 $message= "Can't open: $filename";
                                 exit;
                            }

                            // Schreibe $spielplanhinweis in die geöffnete Datei.
                            if (!fwrite($handle, $spielplanhinweis)) {
                                $message= "<p>Can' write into:  $datei<br/>Please check file permissions.</p>";
                                exit;
                            }

                            $message= "<p>Success! We wrote into $datei:</p><pre>$newcss</pre>\n";

                            fclose($handle);

                        } else {
                            $message="<p>Can' write into:  $datei<br/>Please check file permissions.</p>";
                        }

}
function editDB($spieltage){
	$dbh = clsDb::connect();
	$sql="UPDATE tblSpieltage SET ".
        "aktiv='".$spieltage["aktiv"]."', ".
		"Datum='".$spieltage["Datum"]."', ".
		"Oberliga='".$spieltage["Oberliga"]."', ".
		"Landesliga='".$spieltage["Landesliga"]."', ".
		"Bezirksliga='".$spieltage["Bezirksliga"]."', ".
		"Kreisliga='".$spieltage["Kreisliga"]."', ".
		"Jugendliga='".$spieltage["Jugendliga"]."' ".
		"WHERE idSpieltag=".$spieltage["idSpieltag"];
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
}
function insertDB($spieltage){
	$dbh = clsDb::connect();
    $sql="INSERT INTO tblSpieltage (aktiv, Datum, Oberliga, Landesliga, Bezirksliga, Kreisliga, Jugendliga) VALUES
    (
    '".$spieltage["aktiv"]."',
    '".$spieltage["Datum"]."',
    '".$spieltage["Oberliga"]."',
    '".$spieltage["Landesliga"]."',
    '".$spieltage["Bezirksliga"]."',
    '".$spieltage["Kreisliga"]."',
    '".$spieltage["Jugendliga"]."'
    )";
        $dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";

  }
function stopDB($spieltag){
	$dbh = clsDb::connect();
	$sql="UPDATE tblSpieltage ".
         "SET aktiv=0 ".
		"WHERE idSpieltag=".$spieltag["idSpieltag"].";";
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
}
function publishDB($spieltag){
	$dbh = clsDb::connect();
	$sql="UPDATE tblSpieltage ".
         "SET aktiv=1 ".
		"WHERE idSpieltag=".$spieltag["idSpieltag"].";";
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
}
?>