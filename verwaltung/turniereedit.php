<?php
include_once "../includes/clsSite.php";
include_once '../includes/clsDb.php';

$site=new clsSite();

switch ($_POST["action"]){
	case "stop": //gibt es nicht, wird per get erledigt, Insert into Archiv einbauen
		break;
	case "edit":
		$turniere=getPost($_POST["idTurniere"]);
		editDB($turniere);
		//getPost();
		break;
	case "insert":
        $turniere=getPost();
    	insertDB($turniere);
		getPost();
		break;
	case "editcategory":
		$turniere=getPost($_POST["idTurniere"]);
		editDB($turniere);
		//getPost();
		break;
}
switch ($_GET["action"]){
	case "stop":
        $turnier=getTurnier($_GET["id"]);
        stopDB($turnier);
         $site->showTurniere(true); 
		break;
	case "edit":
		showForm($_GET["id"]);
		break;
	case "insert":
		showForm();
		break;
    case "publish":
        $turnier=getTurnier($_GET["id"]);
        publishDB($turnier);
        $site->showTurniere(true); 
        break;
    case "delete":
        $turnier=getTurnier($_GET["id"]);
        deleteDB($turnier);
        $site->showTurniere(true); 
        break;
	default:
		 $site->showTurniere(true); 
}
function showForm($index=false){
		$dbh = clsDb::connect();
		echo "<form method ='post' action='?site=turniere'><table>";
		if($index){
			$turnier=getTurnier($index);
			echo "<input type ='hidden' name='idTurniere' value ='$index'/>";
		}
		echo "<tr><td><label for='name'>Name</label></td><td><input type='text' name='name' size='100' maxlength ='500' value='".$turnier["name"]."' /></td></tr>";
		echo "<tr><td><label for='aktiv'>Aktiv</label></td><td><input type='text' name='aktiv' size='100' maxlength ='500' value='".$turnier["aktiv"]."' /></td></tr>";
		echo "<tr><td><label for='datum'>Datum</label></td><td><input type='text' name='datum' size='100' maxlength ='500' value='".date("d.m.Y", strtotime($turnier["datum"]))."' /></td></tr>";
		echo "<tr><td><label for='zeit'>Zeit</label></td><td><input type='text' name='zeit' size='100' maxlength ='500' value='".$turnier["zeit"]."' /></td></tr>";
		echo "<tr><td><label for='einschreibung'>Einschreibung</label></td><td><input type='text' name='einschreibung' size='100' maxlength ='500' value='".$turnier["einschreibung"]."' /></td></tr>";
		echo "<tr><td><label for='modus'>Modus</label></td><td><input type='text' name='modus' size='100' maxlength ='500' value='".$turnier["modus"]."' /></td></tr>";
		echo "<tr><td><label for='einladung'>Einladung</label></td><td><input type='text' name='einladung' size='100' maxlength ='500' value='".$turnier["einladung"]."' /></td></tr>";
//
		echo "<tr><td><label for='idVereine'>idVereine</label></td><td><select name='idVereine'>";
			if($index){
					foreach ($dbh->query("SELECT * FROM tblVereine") as $row)
					{
						if($turnier["idVereine"]==$row["idVereine"]){
							echo "<option value=".$row["idVereine"]." selected='selected'>".$row["name"]."</option>";
						}
						else{
							echo "<option value=".$row["idVereine"].">".$row["name"]."</option>";
						}
					}
				}
			else {
					foreach ($dbh->query("SELECT * FROM tblVereine") as $row)
					{
						echo "<option value=".$row["idVereine"].">".$row["name"]."</option>";
					}
			}
				echo "</select></td></tr>";
				
//
		//echo "<tr><td><label for='idVereine'>idVereine</label></td><td><input type='text' name='idVereine' size='100' maxlength ='500' value='".$turnier["idVereine"]."' /></td></tr>";
		echo "<tr><td><label for='telefon'>Telefon</label></td><td><input type='text' name='telefon' size='100' maxlength ='500' value='".$turnier["telefon"]."' /></td></tr>";
		echo "<tr><td><label for='email'>Email</label></td><td><input type='text' name='email' size='100' maxlength ='500' value='".$turnier["email"]."' /></td></tr>";
		echo "</table>";
		
		if ($index)
		{
		echo "<input type ='hidden' name='action' value ='edit'/>";
		}
		else {
		echo "<input type ='hidden' name='action' value ='insert'/>";
		}
		echo "<input type='image' class='button' src='images/icons/save.png'  alt='Absenden'/>";
		echo "<a href='index.php?site=turniere'><img alt='Cancel' class='button' src='images/icons/cancel.png' /></a>";
		echo "</form>";
		$dbh=NULL;
}

function getTurnier($index){
	$dbh = clsDb::connect();
	$sql="SELECT * FROM tblTurniere WHERE idTurniere=$index";
	foreach ($dbh->query($sql) as $row){
	$turniere=array();
	$turniere["idTurniere"]=$index;
	$turniere["aktiv"]=$row["aktiv"];
	$turniere["name"]=$row["name"];
	$turniere["datum"]=$row["datum"];
	$turniere["zeit"]=$row["zeit"];
	$turniere["einschreibung"]=$row["einschreibung"];
	$turniere["modus"]=$row["modus"];
	$turniere["einladung"]=$row["einladung"];
	$turniere["idVereine"]=$row["idVereine"];
	$turniere["telefon"]=$row["telefon"];
	$turniere["email"]=$row["email"];
	return $turniere;
	}
	$dbh=NULL;
}
function getPost(){
	$turniere=array();
	$turniere["idTurniere"]=$_POST["idTurniere"];
	$turniere["aktiv"]=$_POST["aktiv"];
	$turniere["name"]=$_POST["name"];
	$turniere["datum"]=date("Y-m-d", strtotime($_POST["datum"]));
	$turniere["zeit"]=$_POST["zeit"];
	if ($_POST["einschreibung"]){ $turniere["einschreibung"]=$_POST["einschreibung"];}
	else {$turniere["einschreibung"]=NULL;}
	$turniere["modus"]=$_POST["modus"];
	$turniere["einladung"]=$_POST["einladung"];
	$turniere["idVereine"]=$_POST["idVereine"];
	$turniere["telefon"]=$_POST["telefon"];
	$turniere["email"]=$_POST["email"];
	return $turniere;
}

function editDB($turniere){
	$dbh = clsDb::connect();
	$sql="UPDATE tblTurniere SET ".
        "name='".$turniere["name"]."', ".
        "modus='".$turniere["modus"]."', ".
        "aktiv=".$turniere["aktiv"].", ".
		"datum='".$turniere["datum"]."', ". 
		"zeit='".$turniere["zeit"]."', ";
        if ($turniere["einschreibung"]) $sql .= "einschreibung='".$turniere["einschreibung"]."', ";
        else $sql .= "einschreibung=NULL, ";
	$sql .= "einladung='".$turniere["einladung"]."', ".
		"idVereine='".$turniere["idVereine"]."', ".
		"email='".$turniere["email"]."', ".
		"telefon='".$turniere["telefon"]."' ".
		"WHERE idTurniere=".$turniere["idTurniere"];
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
	$dbh=NULL;
}
function insertDB($turniere){
	$dbh = clsDb::connect();
    $sql="INSERT INTO tblTurniere (name, modus, aktiv, datum, zeit, einschreibung, einladung, idVereine, email, telefon) VALUES
    (
    '".$turniere["name"]."',
    '".$turniere["modus"]."',
    ".$turniere["aktiv"].",
    '".$turniere["datum"]."',
    '".$turniere["zeit"]."',";
        if ($turniere["einschreibung"]) $sql .= "'".$turniere["einschreibung"]."', ";
        else $sql .= "NULL, ";
        if ($turniere["einladung"]) $sql .= "'".$turniere["einladung"]."', ";
        else $sql .= "NULL, ";
    $sql.="'".$turniere["idVereine"]."',";
	    if ($turniere["email"]) $sql .= "'".$turniere["email"]."', ";
        else $sql .= "NULL, ";
        if ($turniere["telefon"]) $sql .= "'".$turniere["telefon"]."'";
        else $sql .= "NULL ";
		$sql.=")";
        $dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
	$dbh=NULL;

  }
function stopDB($turnier){
	$dbh = clsDb::connect();
	$sql="UPDATE tblTurniere ".
         "SET aktiv=0 ".
		"WHERE idTurniere=".$turnier["idTurniere"].";";
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
	$dbh=NULL;
}
function publishDB($turnier){
	$dbh = clsDb::connect();
	$sql="UPDATE tblTurniere ".
         "SET aktiv=1 ".
		"WHERE idTurniere=".$turnier["idTurniere"].";";
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
	$dbh=NULL;
	}
function deleteDB($turnier){
	$dbh = clsDb::connect();
	$sql="DELETE FROM tblTurniere ".
		"WHERE idTurniere=".$turnier["idTurniere"].";";
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
	$dbh=NULL;
}
?>