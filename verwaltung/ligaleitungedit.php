<?php
include_once "../includes/clsSite.php";
include_once '../includes/clsDb.php';

$site=new clsSite();

switch ($_POST["action"]){
	case "stop": //gibt es nicht, wird per get erledigt, Insert into Archiv einbauen
		break;
	case "edit":
		$ligaleitung=getPost($_POST["idLigaleiter"]);
		editDB($ligaleitung);
		getPost();
		break;
	case "insert":
        $ligaleitung=getPost();
    	insertDB($ligaleitung);
		getPost();
		break;
}
switch ($_GET["action"]){
	case "stop":
        $ligaleiter=getLigaleiter($_GET["id"]);
        stopDB($ligaleiter);
        $site->showLigaleitung(true);
		break;
	case "edit":
		showForm($_GET["id"]);
		break;
	case "insert":
		showForm();
		break;
    case "publish":
        $ligaleiter=getLigaleiter($_GET["id"]);
        publishDB($ligaleiter);
       $site->showLigaleitung(true);
        break;
	default:
		$site->showLigaleitung(true);
}
function showForm($index=false){
		echo "<form method ='post' action='?site=ligaleitung'><table>";
	if($index){
		$ligaleiter=getLigaleiter($index);
		echo "<input type ='hidden' name='idLigaleiter' value ='$index'/>";
	}
		echo "<tr><td><label for='aktiv'>Aktiv</label></td><td><input type='text' name='aktiv' size='100' maxlength ='500' value='".$ligaleiter["aktiv"]."' /></td></tr>";
		echo "<tr><td><label for='Position'>Position</label></td><td><input type='text' name='Position' size='100' maxlength ='500' value='".$ligaleiter["Position"]."' /></td></tr>";
		echo "<tr><td><label for='Position'>Sortierung</label></td><td><input type='text' name='Sortierung' size='100' maxlength ='500' value='".$ligaleiter["Sortierung"]."' /></td></tr>";
		echo "<tr><td><label for='Aufgaben'>Aufgaben</label></td><td><input type='text' name='Aufgaben' size='100' maxlength ='500' value='".$ligaleiter["Aufgaben"]."' /></td></tr>";
		echo "<tr><td><label for='Vorname'>Vorname</label></td><td><input type='text' name='Vorname' size='100' maxlength ='500' value='".$ligaleiter["Vorname"]."' /></td></tr>";
		echo "<tr><td><label for='Nachname'>Nachname</label></td><td><input type='text' name='Nachname' size='100' maxlength ='500' value='".$ligaleiter["Nachname"]."' /></td></tr>";
		echo "<tr><td><label for='Strasse'>Strasse</label></td><td><input type='text' name='Strasse' size='100' maxlength ='500' value='".$ligaleiter["Strasse"]."' /></td></tr>";
		echo "<tr><td><label for='Wohnort'>Wohnort</label></td><td><input type='text' name='Wohnort' size='100' maxlength ='500' value='".$ligaleiter["Wohnort"]."' /></td></tr>";
		echo "<tr><td><label for='Verein'>Verein</label></td><td><input type='text' name='Verein' size='100' maxlength ='500' value='".$ligaleiter["Verein"]."' /></td></tr>";
		echo "<tr><td><label for='Email'>Email</label></td><td><input type='text' name='Email' size='100' maxlength ='500' value='".$ligaleiter["Email"]."' /></td></tr>";
		echo "<tr><td><label for='Telefon'>Telefon</label></td><td><input type='text' name='Telefon' size='100' maxlength ='500' value='".$ligaleiter["Telefon"]."' /></td></tr>";
		echo "<tr><td><label for='Mobil'>Mobil</label></td><td><input type='text' name='Mobil' size='100' maxlength ='500' value='".$ligaleiter["Mobil"]."' /></td></tr>";
		echo "<tr><td><label for='Bild'>Bild</label></td><td><input type='text' name='Bild' size='100' maxlength ='500' value='".$ligaleiter["Bild"]."' /></td></tr>";
		echo "</table>";
		
		if ($index)
		{
		echo "<input type ='hidden' name='action' value ='edit'/>";
		}
		else {
		echo "<input type ='hidden' name='action' value ='insert'/>";
		}
		echo "<input type='image' class='button' src='images/icons/save.png'  alt='Absenden'/>";
		echo "<a href='index.php?site=ligaleitung'><img alt='Cancel' class='button' src='images/icons/cancel.png' /></a>";
		echo "</form>";
}

function getLigaleiter($index){
	$dbh = clsDb::connect();
	$sql="SELECT * FROM tblLigaleitung WHERE idLigaleiter=$index";
	foreach ($dbh->query($sql) as $row){
	$ligaleitung=array();
	$ligaleitung["idLigaleiter"]=$index;
	$ligaleitung["aktiv"]=$row["aktiv"];
	$ligaleitung["Position"]=$row["Position"];
	$ligaleitung["Sortierung"]=$row["Sortierung"];
	$ligaleitung["Aufgaben"]=$row["Aufgaben"];
	$ligaleitung["Vorname"]=$row["Vorname"];
	$ligaleitung["Nachname"]=$row["Nachname"];
	$ligaleitung["Strasse"]=$row["Strasse"];
	$ligaleitung["Wohnort"]=$row["Wohnort"];
	$ligaleitung["Verein"]=$row["Verein"];
	$ligaleitung["Email"]=$row["Email"];
	$ligaleitung["Telefon"]=$row["Telefon"];
	$ligaleitung["Mobil"]=$row["Mobil"];
	$ligaleitung["Bild"]=$row["Bild"];
	$ligaleitung["Bild"]=$row["Bild"];
	return $ligaleitung;
	}
}

function getPost(){
	$ligaleitung=array();
	$ligaleitung["idLigaleiter"]=$_POST["idLigaleiter"];
	$ligaleitung["aktiv"]=$_POST["aktiv"];
	$ligaleitung["Position"]=$_POST["Position"];
	$ligaleitung["Sortierung"]=$_POST["Sortierung"];
	$ligaleitung["Aufgaben"]=$_POST["Aufgaben"];
	$ligaleitung["Vorname"]=$_POST["Vorname"];
	$ligaleitung["Nachname"]=$_POST["Nachname"];
	$ligaleitung["Strasse"]=$_POST["Strasse"];
	$ligaleitung["Wohnort"]=$_POST["Wohnort"];
	$ligaleitung["Verein"]=$_POST["Verein"];
	$ligaleitung["Email"]=$_POST["Email"];
	$ligaleitung["Telefon"]=$_POST["Telefon"];
	$ligaleitung["Mobil"]=$_POST["Mobil"];
	$ligaleitung["Bild"]=$_POST["Bild"];
	$ligaleitung["Bild"]=$_POST["Bild"];
	return $ligaleitung;
}

function editDB($ligaleitung){
	$dbh = clsDb::connect();
	$sql="UPDATE tblLigaleitung SET ".
        "aktiv='".$ligaleitung["aktiv"]."', ".
		"Position='".$ligaleitung["Position"]."', ".
		"Sortierung='".$ligaleitung["Sortierung"]."', ".
		"Aufgaben='".$ligaleitung["Aufgaben"]."', ".
		"Vorname='".$ligaleitung["Vorname"]."', ".
		"Nachname='".$ligaleitung["Nachname"]."', ".
		"Strasse='".$ligaleitung["Strasse"]."', ".
		"Wohnort='".$ligaleitung["Wohnort"]."', ".
		"Verein='".$ligaleitung["Verein"]."', ".
		"Email='".$ligaleitung["Email"]."', ".
		"Telefon='".$ligaleitung["Telefon"]."', ".
		"Mobil='".$ligaleitung["Mobil"]."', ".
		"Bild='".$ligaleitung["Bild"]."' ".
		"WHERE idLigaleiter=".$ligaleitung["idLigaleiter"];
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
}
function insertDB($ligaleitung){
	$dbh = clsDb::connect();
    $sql="INSERT INTO tblLigaleitung (Position, Sortierung, Aufgaben, Vorname, Nachname, Strasse, Wohnort, Verein, Email, Telefon, Mobil, Bild, aktiv) VALUES
    (
    '".$ligaleitung["Position"]."',
    '".$ligaleitung["Sortierung"]."',
    '".$ligaleitung["Aufgaben"]."',
    '".$ligaleitung["Vorname"]."',
    '".$ligaleitung["Nachname"]."',
    '".$ligaleitung["Strasse"]."',
    '".$ligaleitung["Wohnort"]."',
    '".$ligaleitung["Verein"]."',
    '".$ligaleitung["Email"]."',
    '".$ligaleitung["Telefon"]."',
    '".$ligaleitung["Mobil"]."',
    '".$ligaleitung["Bild"]."',
    '".$ligaleitung["aktiv"]."'
    )";
        $dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";

  }
function stopDB($ligaleiter){
	$dbh = clsDb::connect();
	$sql="UPDATE tblLigaleitung ".
         "SET aktiv=0 ".
		"WHERE idLigaleiter=".$ligaleiter["idLigaleiter"].";";
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
}
function publishDB($ligaleiter){
	$dbh = clsDb::connect();
	$sql="UPDATE tblLigaleitung ".
         "SET aktiv=1 ".
		"WHERE idLigaleiter=".$ligaleiter["idLigaleiter"].";";
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
}
?>