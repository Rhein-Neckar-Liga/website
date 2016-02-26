<?php
include_once "../includes/clsSite.php";
include_once '../includes/clsDb.php';

$site=new clsSite();

switch ($_POST["action"]){
	case "edit":
		$dokumente=getPost($_POST["idDokument"]);
		editDB($dokumente);
		//getPost();
		break;
	case "insert":
        $dokumente=getPost();
    	insertDB($dokumente);
		getPost();
		break;
	case "insertcategory":
        $category=getcategoryPost();
    	insertcategoryDB($category);
		break;
}
switch ($_GET["action"]){
	case "stop":
        $dokument=getDokument($_GET["id"]);
        stopDB($dokument);
         $site->showDokumente(NULL,true);
		break;
	case "delete":
        $dokument=getDokument($_GET["id"]);
        deleteDB($dokument);
         $site->showDokumente(NULL,true);
		break;
	case "edit":
		showForm($_GET["id"]);
		break;
	case "insert":
		showForm();
		break;
    case "publish":
        $dokument=getDokument($_GET["id"]);
        publishDB($dokument);
        $site->showDokumente(NULL,true); 
        break;
	default:
		$site->showDokumente(NULL,true); 
}
function showForm($index=false){
		$dbh = clsDb::connect();
		echo "<form method ='post' action='?site=dokumente'><table>";
		if($index){
			$dokument=getDokument($index);
			echo "<input type ='hidden' name='idDokument' value ='$index'/>";
		}
		echo "<tr><td><label for='aktiv'>Aktiv</label></td><td><input type='text' name='aktiv' size='100' maxlength ='500' value='".$dokument["aktiv"]."' /></td></tr>";
		echo "<tr><td><label for='datum'>Datum</label></td><td><input type='text' name='datum' size='100' maxlength ='500' value='".date("d.m.Y", strtotime($dokument["datum"]))."' /></td></tr>";
		echo "<tr><td><label for='name'>Name</label></td><td><input type='text' name='name' size='100' maxlength ='500' value='".$dokument["name"]."' /></td></tr>";
		echo "<tr><td><label for='link'>Link</label></td><td><input type='text' name='link' size='100' maxlength ='500' value='".$dokument["link"]."' /></td></tr>";
		echo "<tr><td><label for='imageType'>imageType</label></td><td><input type='text' name='imageType' size='100' maxlength ='500' value='".$dokument["imageType"]."' /></td></tr>";
//
		echo "<tr><td><label for='idDokumentArt'>idDokumentArt</label></td><td><select name='idDokumentArt'>";
//			if($index){
					foreach ($dbh->query("SELECT * FROM tblDokumentArt") as $row)
					{
						if($dokument["idDokumentArt"]==$row["idDokumentArt"]){
							echo "<option value=".$row["idDokumentArt"]." selected='selected'>".$row["name"]."</option>";
						}else{
							echo "<option value=".$row["idDokumentArt"].">".$row["name"]."</option>";
						}
					}
				echo "</select></td></tr>";
	//			}
//
		echo "</table>";
		
		if ($index)
		{
		echo "<input type ='hidden' name='action' value ='edit'/>";
		}
		else {
		echo "<input type ='hidden' name='action' value ='insert'/>";
		}
		echo "<input type='image' class='button' src='images/icons/save.png'  alt='Absenden'/>";
		echo "<a href='index.php?site=dokumente'><img alt='Cancel' class='button' src='images/icons/cancel.png' /></a>";
		echo "</form>";
		$dbh=NULL;
}

function getDokument($index){
	$dbh = clsDb::connect();
	$sql="SELECT * FROM tblDokument WHERE idDokument=$index";
	foreach ($dbh->query($sql) as $row){
	$dokumente=array();
	$dokumente["idDokument"]=$index;
	$dokumente["idDokumentArt"]=$row["idDokumentArt"];
	$dokumente["aktiv"]=$row["aktiv"];
	$dokumente["name"]=$row["name"];
	$dokumente["datum"]=$row["datum"];
	$dokumente["link"]=$row["link"];
	$dokumente["imageType"]=$row["imageType"];
	return $dokumente;
	}
	$dbh=NULL;
}
function getPost(){
	$dokumente=array();
	$dokumente["idDokument"]=$_POST["idDokument"];
	$dokumente["aktiv"]=$_POST["aktiv"];
	$dokumente["idDokumentArt"]=$_POST["idDokumentArt"];
	$dokumente["name"]=$_POST["name"];
	$dokumente["datum"]=date("Y-m-d", strtotime($_POST["datum"]));
	$dokumente["link"]=$_POST["link"];
	$dokumente["imageType"]=$_POST["imageType"];
	return $dokumente;
}
function getcategoryPost(){
	$category["newcategory"]=$_POST["newcategory"];
	$category["idDokumentArt"]=$_POST["idDokumentArt"];
	return $category;
}
function editDB($dokumente){
	$dbh = clsDb::connect();
	$sql="UPDATE tblDokument SET ".
        "aktiv=".$dokumente["aktiv"].", ".
		"datum='".$dokumente["datum"]."', ". 
		"idDokumentArt='".$dokumente["idDokumentArt"]."', ". 
		"link='".$dokumente["link"]."', ".
		"imageType='".$dokumente["imageType"]."' ".
		"WHERE idDokument=".$dokumente["idDokument"];
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
	$dbh=NULL;
}
function insertDB($dokumente){
	$dbh = clsDb::connect();
    $sql="INSERT INTO tblDokument (idDokumentArt, aktiv, name, datum, link, imageType) VALUES
    (
    '".$dokumente["idDokumentArt"]."',
    '".$dokumente["aktiv"]."',
    '".$dokumente["name"]."',
    '".$dokumente["datum"]."',
	'".$dokumente["link"]."',
    '".$dokumente["imageType"]."'
    )";
        $dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
	$dbh=NULL;

  }
function insertcategoryDB($category){
	$dbh = clsDb::connect();
    $sql="INSERT INTO tblDokumentArt(idDokumentArt,name) VALUES
    (
	'".$category["idDokumentArt"]."',
    '".$category["newcategory"]."'
    )";
        $dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
	$dbh=NULL;

  }
function stopDB($dokument){
	$dbh = clsDb::connect();
	$sql="UPDATE tblDokument ".
         "SET aktiv=0 ".
		"WHERE idDokument=".$dokument["idDokument"].";";
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
	$dbh=NULL;
}
function publishDB($dokument){
	$dbh = clsDb::connect();
	$sql="UPDATE tblDokument ".
         "SET aktiv=1 ".
		"WHERE idDokument=".$dokument["idDokument"].";";
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
    echo "</div>";
	$dbh=NULL;
	}
function deleteDB($dokument){
	$dbh = clsDb::connect();
	$sql="DELETE FROM tblDokument ".
			"WHERE idDokument=".$dokument["idDokument"].";";
	$dbh->exec($sql);
    echo "<div class='beitrag sql'>";
        echo $sql;
			if ($dbh!==FALSE){
			echo "<p style='background-color:green;color:#fff;font-weight:bold;'>Delete erfolgreich</p>";
			}
			else echo "<p style='background-color:red;color:#fff;font-weight:bold;'>Delete nicht erfolgreich</p>";
    echo "</div>";
	$dbh=NULL;
	}
?>