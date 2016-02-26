<?php 
//Turniereditform
include_once "../includes/clsSite.php";
include_once '../includes/clsDb.php';
//include_once 'turniereedit.php';
$site=new clsSite();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Turniereditform</title>
<style type="text/css">
/*<![CDATA[*/
<!--
body{background-color:#ccc;}
label, table, tr, td, input, select {
    color: #666;
    font-family: arial;
    font-size: 0.8em;
}
?>
-->
/*]]>*/
</style>
    </head>
    <body>

<?php
showForm($_GET["id"]);
function showForm($index=false){
		$dbh = clsDb::connect();
		echo "<form method ='post' action='index.php?site=turniere'>";
		if($index){
			$turnier=getTurnier($index);
			echo "<input type ='hidden' name='idTurniere' value ='$index'/>";
		}
		echo "<table summary='Turniertabelle'><tr><td><label for='aktiv'>Aktiv</label></td><td><input type='text' name='aktiv' size='50' maxlength ='500' value='".$turnier["aktiv"]."' /></td></tr>";
		echo "<tr><td><label for='datum'>Datum</label></td><td><input type='text' name='datum' size='50' maxlength ='500' value='".date("d.m.Y", strtotime($turnier["datum"]))."' /></td></tr>";
		echo "<tr><td><label for='zeit'>Zeit</label></td><td><input type='text' name='zeit' size='50' maxlength ='500' value='".$turnier["zeit"]."' /></td></tr>";
		echo "<tr><td><label for='einschreibung'>Einschreibung</label></td><td><input type='text' name='einschreibung' size='50' maxlength ='500' value='".$turnier["einschreibung"]."' /></td></tr>";
		echo "<tr><td><label for='modus'>Modus</label></td><td><input type='text' name='modus' size='50' maxlength ='500' value='".$turnier["modus"]."' /></td></tr>";
		echo "<tr><td><label for='einladung'>Einladung</label></td><td><input type='text' name='einladung' size='100' maxlength ='500' value='".$turnier["einladung"]."' /></td></tr>";
//
		echo "<tr><td><label for='idVereine'>idVereine</label></td><td><select name='idVereine'>";
			if($index){
					foreach ($dbh->query("SELECT * FROM tblVereine") as $row)
					{
						if($turnier["idVereine"]==$row["idVereine"]){
							echo "<option value=".$row["idVereine"]." selected='selected'>".$row["name"]."</option>";
						}else{
							echo "<option value=".$row["idVereine"].">".$row["name"]."</option>";
						}
					}
				echo "</select></td></tr>";
				}
//
		//echo "<tr><td><label for='idVereine'>idVereine</label></td><td><input type='text' name='idVereine' size='100' maxlength ='500' value='".$turnier["idVereine"]."' /></td></tr>";
		echo "<tr><td><label for='telefon'>Telefon</label></td><td><input type='text' name='telefon' size='50' maxlength ='500' value='".$turnier["telefon"]."' /></td></tr>";
		echo "<tr><td><label for='email'>Email</label></td><td><input type='text' name='email' size='50' maxlength ='500' value='".$turnier["email"]."' /></td></tr>";
		echo "</table>";
		
		if ($index)
		{
		echo "<input type ='hidden'  name='action' value ='edit'/>";
		}
		else {
		echo "<input type ='hidden' name='action' value ='insert'/>";
		}
		echo "<input type ='submit' onclick='parent.GB_hide()' value ='ab damit'/><a href='' onclick='parent.GB_hide()'>schließen</a>";
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
?>
</body>
</html>