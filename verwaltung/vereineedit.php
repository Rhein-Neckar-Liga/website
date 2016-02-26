<?php
include_once "../includes/clsSite.php";
include_once '../includes/clsDb.php';

$site=new clsSite();

switch ($_POST["action"]){
	case "delete": //gibt es nicht, wird per get erledigt, Insert into Archiv einbauen
		break;
	case "edit":
		$vereine=getPost($_POST["idVerein"]);
		editDB($vereine);
		getPost();
		break;
	case "insert":
        $vereine=getPost();
    	insertDB($vereine);
		getPost();
		break;
}



switch ($_GET["action"]){
	case "delete":
        $verein=getVerein($_GET["id"]);
        archiveDB($verein);
        stopDB($verein);
        $site->showVereine(true);
		break;
	case "edit":
		showForm($_GET["id"]);
		break;
	case "insert":
		showForm();
		break;
    case "publish":
        $verein=getVerein($_GET["id"]);
        publishDB($verein);
        $site->showVereine(true);
        break;
	default:
		$site->showVereine(true);
}

function showForm($index=false){
		echo "<form method ='post' action='?site=vereine'><table>";
	if($index){
		$verein=getVerein($index);
		echo "<input type ='hidden' name='idVereine' value ='$index'/>";
	}
		echo "<tr><td><label for='aktiv'>Aktiv</label></td><td><input type='text' name='aktiv' size='100' maxlength ='500' value='".$verein["aktiv"]."' /></td></tr>";
		echo "<tr><td><label for='name'>Name</label></td><td><input type='text' name='name' size='100' maxlength ='500' value='".$verein["name"]."' /></td></tr>";
		echo "<tr><td><label for='kontakt'>kontakt</label></td><td><input type='text' name='kontakt' size='100' maxlength ='500' value='".$verein["kontakt"]."' /></td></tr>";
		echo "<tr><td><label for='spielort'>spielort</label></td><td><input type='text' name='spielort' size='100' maxlength ='500' value='".$verein["spielort"]."' /></td></tr>";
		echo "<tr><td><label for='spielzeiten'>spielzeiten</label></td><td><input type='text' name='spielzeiten' size='100' maxlength ='500' value='".$verein["spielzeiten"]."' /></td></tr>";
		echo "<tr><td><label for='gruendungsjahr'>gruendungsjahr</label></td><td><input type='text' name='gruendungsjahr' size='100' maxlength ='500' value='".$verein["gruendungsjahr"]."' /></td></tr>";
		echo "<tr><td><label for='anzahlMitglieder'>anzahlMitglieder</label></td><td><input type='text' name='anzahlMitglieder' size='100' maxlength ='500' value='".$verein["anzahlMitglieder"]."' /></td></tr>";
		echo "<tr><td><label for='jahresbeitrag'>jahresbeitrag</label></td><td><input type='text' name='jahresbeitrag' size='100' maxlength ='500' value='".$verein["jahresbeitrag"]."' /></td></tr>";
		echo "<tr><td><label for='anzahlUebungsleiter'>anzahlUebungsleiter</label></td><td><input type='text' name='anzahlUebungsleiter' size='100' maxlength ='500' value='".$verein["anzahlUebungsleiter"]."' /></td></tr>";
		echo "<tr><td><label for='anzahlSchiedsrichter'>anzahlSchiedsrichter</label></td><td><input type='text' name='anzahlSchiedsrichter' size='100' maxlength ='500' value='".$verein["anzahlSchiedsrichter"]."' /></td></tr>";
		echo "<tr><td><label for='email'>email</label></td><td><input type='text' name='email'  size='100' maxlength ='500'value='".$verein["email"]."' /></td></tr>";
		echo "<tr><td><label for='telefon'>telefon</label></td><td><input type='text' name='telefon'  size='100' maxlength ='500'value='".$verein["telefon"]."' /></td></tr>";
		echo "<tr><td><label for='website'>website</label></td><td><input type='text' name='website'  size='100' maxlength ='500'value='".$verein["website"]."' /></td></tr>";
		echo "<tr><td><label for='position'>position</label></td><td><input type='text' name='position'  size='100' maxlength ='500'value='".$verein["position"]."' /></td></tr>";
		echo "<tr><td><label for='logo'>logo</label></td><td><input type='text' name='logo'  size='100' maxlength ='500'value='".$verein["logo"]."' /></td></tr>";
		echo "<tr><td><label for='vereinsnummer'>vereinsnummer</label></td><td><input type='text'  size='100' maxlength ='500'name='vereinsnummer' value='".$verein["vereinsnummer"]."' /></td></tr>";
		echo "<tr><td><label for='kuerzel'>kuerzel</label></td><td><input type='text' name='kuerzel'  size='100' maxlength ='500'value='".$verein["kuerzel"]."' /></td></tr>";
		echo "<tr><td><label for='lat'>Breitengrad</label></td><td><input type='text' name='lat'  size='100' maxlength ='50'value='".$verein["lat"]."' /></td></tr>";
		echo "<tr><td><label for='lon'>Längengrad</label></td><td><input type='text' name='lon'  size='100' maxlength ='50'value='".$verein["lon"]."' /></td></tr>";
		
		echo "</table>";
		
		if ($index)
		{
		echo "<input type ='hidden' name='action' value ='edit'/>";
		}
		else {
		echo "<input type ='hidden' name='action' value ='insert'/>";
		}
		echo "<input type='image' class='button' src='images/icons/save.png'  alt='Absenden'/>";
		echo "<a href='index.php?site=vereine'><img alt='Cancel' class='button' src='images/icons/cancel.png' /></a>";
		echo "</form>";
}

function getVerein($index){
	$dbh = clsDb::connect();
	$sql="SELECT * FROM tblVereine WHERE idVereine=$index";
	foreach ($dbh->query($sql) as $row){
	$vereine=array();
	$vereine["idVereine"]=$index;
    $vereine["aktiv"]=$row["aktiv"];
	$vereine["name"]=$row["name"];
	$vereine["kontakt"]=$row["kontakt"];
	$vereine["spielort"]=$row["spielort"];
	$vereine["spielzeiten"]=$row["spielzeiten"];
	$vereine["gruendungsjahr"]=$row["gruendungsjahr"];
	$vereine["anzahlMitglieder"]=$row["anzahlMitglieder"];
	$vereine["jahresbeitrag"]=$row["jahresbeitrag"];
	$vereine["anzahlUebungsleiter"]=$row["anzahlUebungsleiter"];
	$vereine["anzahlSchiedsrichter"]=$row["anzahlSchiedsrichter"];
	$vereine["email"]=$row["email"];
	$vereine["telefon"]=$row["telefon"];
	$vereine["website"]=$row["website"];
	$vereine["position"]=$row["position"];
	$vereine["logo"]=$row["logo"];
	$vereine["vereinsnummer"]=$row["vereinsnummer"];
	$vereine["kuerzel"]=$row["kuerzel"];
	$vereine["lat"]=$row["lat"];
	$vereine["lon"]=$row["lon"];
	return $vereine;
	}
    $dbh = NULL;
}

function getPost(){
	$vereine=array();
	//if($_POST["idVereine"]){
		$vereine["idVereine"]=$_POST["idVereine"];
		//echo "<h1>OK</h1>";
	//}
    $vereine["aktiv"]=$_POST["aktiv"];
	$vereine["name"]=$_POST["name"];
	$vereine["kontakt"]=$_POST["kontakt"];
	$vereine["spielort"]=$_POST["spielort"];
	$vereine["spielzeiten"]=$_POST["spielzeiten"];
	$vereine["gruendungsjahr"]=$_POST["gruendungsjahr"];
	$vereine["anzahlMitglieder"]=$_POST["anzahlMitglieder"];
	$vereine["jahresbeitrag"]=$_POST["jahresbeitrag"];
	$vereine["anzahlUebungsleiter"]=$_POST["anzahlUebungsleiter"];
	$vereine["anzahlSchiedsrichter"]=$_POST["anzahlSchiedsrichter"];
	$vereine["email"]=$_POST["email"];
	$vereine["telefon"]=$_POST["telefon"];
	$vereine["website"]=$_POST["website"];
	$vereine["position"]=$_POST["position"];
	$vereine["logo"]=$_POST["logo"];
	$vereine["vereinsnummer"]=$_POST["vereinsnummer"];
	$vereine["kuerzel"]=$_POST["kuerzel"];
	$vereine["lat"]=$_POST["lat"];
	$vereine["lon"]=$_POST["lon"];
	return $vereine;
}

function editDB($vereine){
	$dbh = clsDb::connect();
	$sql="UPDATE tblVereine SET ".
        "aktiv='".$vereine["aktiv"]."', ".
		"name='".$vereine["name"]."', ".
		"kontakt='".$vereine["kontakt"]."', ".
		"spielort='".$vereine["spielort"]."', ".
		"spielzeiten='".$vereine["spielzeiten"]."', ".
		"gruendungsjahr='".$vereine["gruendungsjahr"]."', ".
		"anzahlMitglieder='".$vereine["anzahlMitglieder"]."', ".
		"jahresbeitrag='".$vereine["jahresbeitrag"]."', ".
		"anzahlUebungsleiter='".$vereine["anzahlUebungsleiter"]."', ".
		"anzahlSchiedsrichter='".$vereine["anzahlSchiedsrichter"]."', ".
		"email='".$vereine["email"]."', ".
		"telefon='".$vereine["telefon"]."', ".
		"website='".$vereine["website"]."', ".
		"position='".$vereine["position"]."', ".
		"logo='".$vereine["logo"]."', ".
		"vereinsnummer='".$vereine["vereinsnummer"]."', ".
		"kuerzel='".$vereine["kuerzel"]."', ".
		"lat='".$vereine["lat"]."', ".
		"lon='".$vereine["lon"]."' ".
		"WHERE idVereine=".$vereine["idVereine"].";";
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
    $dbh = NULL;
}
function insertDB($vereine){
	$dbh = clsDb::connect();
    $sql="INSERT INTO tblVereine (aktiv,name,kontakt,spielort,spielzeiten,gruendungsjahr,anzahlMitglieder, jahresbeitrag, anzahlUebungsleiter, anzahlSchiedsrichter, email, telefon, website, position, logo, vereinsnummer, kuerzel, lat, lon ) VALUES
    (
    '".$vereine["aktiv"]."',
    '".$vereine["name"]."',
    '".$vereine["kontakt"]."',
    '".$vereine["spielort"]."',
    '".$vereine["spielzeiten"]."',
    '".$vereine["gruendungsjahr"]."',
    '".$vereine["anzahlMitglieder"]."',
    '".$vereine["jahresbeitrag"]."',
    '".$vereine["anzahlUebungsleiter"]."',
    '".$vereine["anzahlSchiedsrichter"]."',
    '".$vereine["email"]."',
    '".$vereine["telefon"]."',
    '".$vereine["website"]."',
    '".$vereine["position"]."',
    '".$vereine["logo"]."',
    '".$vereine["vereinsnummer"]."',
    '".$vereine["kuerzel"]."',
    '".$vereine["lat"]."',
    '".$vereine["lon"]."'
    )";
        $dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
    $dbh = NULL;

  }
function archiveDB($vereine){
	$dbh = clsDb::connect();
    $sql="INSERT INTO archiv_tblvereine (idVereine,name,kontakt,spielort,spielzeiten,gruendungsjahr,anzahlMitglieder, jahresbeitrag, anzahlUebungsleiter, anzahlSchiedsrichter, email, telefon, website, position, logo, vereinsnummer, kuerzel ) VALUES
    (
    '".$vereine["idVereine"]."',
    '".$vereine["name"]."',
    '".$vereine["kontakt"]."',
    '".$vereine["spielort"]."',
    '".$vereine["spielzeiten"]."',
    '".$vereine["gruendungsjahr"]."',
    '".$vereine["anzahlMitglieder"]."',
    '".$vereine["jahresbeitrag"]."',
    '".$vereine["anzahlUebungsleiter"]."',
    '".$vereine["anzahlSchiedsrichter"]."',
    '".$vereine["email"]."',
    '".$vereine["telefon"]."',
    '".$vereine["website"]."',
    '".$vereine["position"]."',
    '".$vereine["logo"]."',
    '".$vereine["vereinsnummer"]."',
    '".$vereine["kuerzel"]."'
    )";
        $dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
    $dbh = NULL;

  }
function stopDB($verein){
	$dbh = clsDb::connect();
	$sql="UPDATE tblVereine ".
         "SET aktiv=0 ".
		"WHERE idVereine=".$verein["idVereine"].";";
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
    $dbh = NULL;
}
function publishDB($verein){
	$dbh = clsDb::connect();
	$sql="UPDATE tblVereine ".
         "SET aktiv=1 ".
		"WHERE idVereine=".$verein["idVereine"].";";
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
    $dbh = NULL;
}
?>