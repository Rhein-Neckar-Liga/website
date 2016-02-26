<?php
@include_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/slimstat/stats_include.php' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		    <link rel="stylesheet" href="../css/main.css" type="text/css" />
        <title>Verwaltung</title>
<style type="text/css">
/*<![CDATA[*/
<!--
.beitrag img.button {float:left;margin:0;}
-->
/*]]>*/
</style>
		<script type="text/javascript" src="../includes/tinymce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced"
});
</script>
    </head>
    <body>
	
        <div id="pagewidth" >
            <div id="header" style="text-align:center;">
                <ul id="navigation">
                    <li><a href="?site=start">Start</a></li>
                    <li><a href="?site=vereine">Vereine</a></li>
                    <li><a href="?site=ligaleitung">Ligaleitung</a></li>
                    <li><a href="?site=turniere">Turniere</a></li>
                    <li><a href="?site=spielplan">Spielplan</a></li>
                    <li><a href="?site=dokumente">Dokumente</a></li>
                    <li><a href="?site=rnl_ligapokal">RNL-Pokal</a></li>
                    <li><a href="?site=rnl_ligapokal">RNL-Pokal</a></li>
                </ul>
    	</div>
<div id="maincol">
        <?php
          include_once '../includes/clsDb.php';
          error_reporting(E_ALL);
          $dbh = clsDb::connect();
		  $message = "";
		  
		  //prüfen ob eine der anderen Seiten gesetzt wurde sonst das hier
        $sites = array("turniere", "vereine", "ligaleitung", "rnl_ligapokal", "dokumente", "spielplan", "impressum");
        //gewaehlte Seite
		//isset($_GET["site"]) ? $getsite = $_GET["site"] : $getsite = "";
		//ist site gesetzt übergebe es an getsite, sonst getsite initialisieren
		isset($_GET["site"]) ? $getsite = $_GET["site"] : $getsite = "";
		// ist getsitee im array ok sonst auf Keinee Seite setzen
		in_array($getsite, $sites)== FALSE ? $getsite = "news" : $getsite = $getsite;
		  if (isset($_GET["id"]) and isset($_GET["edit"]))
		  {
				$eintrag = "SELECT * FROM tblNewsItems WHERE idNewsItems = ".$_GET["id"];
				//SQL Statement absetzen
				foreach ($dbh->query($eintrag) as $row)
				{
					$content=$row;
				}
			}  
          if (isset($_POST["category"]))
          {
            $author = $_POST["author"];
            $category = $_POST["category"];
            $title = $_POST["title"];
            $datum = $_POST["datum"];
            $datum = date("Y-m-d", strtotime($datum));
            $text = $_POST["text"];
			$link="";
			if(isset ($_POST["edit"])){
			$eintrag = "UPDATE tblNewsItems SET date='$datum', title='$title',description='$text',link='$link',idNewsAuthor='$author',idNewsCategory='$category' WHERE idNewsItems=".$_POST["edit"];
//			$id= $_POST["id"];
			$message = "<p style='background-color:green;color:#fff;font-weight:bold;'>".$title . "für den " .$datum. " upgedated</p>";
			$dbh->exec($eintrag); //SQL Statement absetzen
			}else{
            $eintrag = "INSERT INTO tblNewsItems (date,title,description,link,idNewsAuthor,idNewsCategory) VALUES ('$datum', '$title','$text','$link','$author','$category')";
			$message = "<p style='background-color:green;color:#fff;font-weight:bold;'>".$title . "für den " .$datum. " eingetragen</p>";
			$dbh->exec($eintrag); //SQL Statement absetzen
			
			}
			
          if ($dbh == FALSE) {
		  $message = "<p style='background-color:red;color:#fff;font-weight:bold;'>fehlgeschlagen!</p>";
		  }
			//Mailversand an die Ligaleitung
			$sender="Ligaleitung - Newseintrag";
			$empfaenger="ligaleitung@rhein-neckar-liga.de";
			$sendermail="ligaleitung@rhein-neckar-liga.de";
			$betreff="Ligaleitung - Newseintrag";
			//weitere header infos
			$extra = "From: $sender\n <$sendermail>\n";
			$extra .= "MIME-Version: 1.0\n";
			$extra .= "Content-Type: text/html; charset=UTF-8"; 
			//quoted-printable bewirkt die Darstellung der Umlaute
			$extra .= "Content-Transfer-Encoding: quoted-printable\n";
	//		$text .= "<br/><a href=\'http://www.rhein-neckar-liga.de/verwaltung/index.php?edit=1&amp;id=".$id."\'>Testlink</a>";
			$mailtext= "datum: ".$datum."<br/>
					title: ".$title."<br/>
					text: ".$text."<br/>
					link: ".$link."<br/>
					author: ".$author."<br/>
					category: ".$category."<br/>"
				;
			mail($empfaenger, $betreff, $mailtext, $extra);
			//Ende Mailversand
          } 
		if (isset($_GET["id"]) and isset($_GET["freigabe"]))
          {
			$eintrag = "UPDATE tblNewsItems SET freigabe = ".$_GET["freigabe"]." WHERE idNewsItems = ".$_GET["id"];
            $dbh->exec($eintrag); //SQL Statement absetzen
			if ($dbh!==FALSE) {
			$message = "<p style='background-color:green;color:#fff;font-weight:bold;'>Update erfolgreich</p>";
			}
			}  
		if (isset($_GET["id"]) and isset($_GET["delete"]))
          {
			$eintrag = "DELETE FROM tblNewsItems WHERE idNewsItems = ".$_GET["id"];
            $dbh->exec($eintrag); //SQL Statement absetzen
			if ($dbh!==FALSE){
			$message = "<p style='background-color:red;color:#fff;font-weight:bold;'>Delete erfolgreich</p>";
			}
			}  
        ?>
<div style="float:left;width:50%;padding:1em 0 0 1em;border:1px solid #c03;margin-top:180px;background-color:#fff;">
<?php echo $message . $getsite; ?>
<?php
	if ($getsite == "news"){
		echo "<h5 style='background-color:red;'>noch nicht freigegebene Beiträge stehen oben</h5>";
		include('../inhalte/gesperrt.php');
		include_once "../includes/scripts/feed.php";
			$feed=new createFeed();
			$feed->create();
			$feed->save();
			}
		?>
		</div>
<div style="position:fixed;left:51%;top:200px;margin-left:1em;padding:1em;border:1px solid #c03;background-color:#fff;">
        <form method="post" action="index.php">
            <select name="category">
            <?php
			if (isset ($content)){
			foreach ($dbh->query("SELECT * FROM tblNewsCategory") as $row)
            {
				if($content["idNewsCategory"]==$row["idNewsCategory"]){
					echo "<option value=".$row["idNewsCategory"]." selected='selected'>".$row["name"]."</option>";
				}else{
					echo "<option value=".$row["idNewsCategory"].">".$row["name"]."</option>";
				}
            }
            ?>
            </select><br />
            <select name="author">
            <?php
            foreach ($dbh->query("SELECT * FROM tblNewsAuthor") as $row)
            {
				if($content["idNewsAuthor"]==$row["idNewsAuthor"]){
					echo "<option value=".$row["idNewsAuthor"]." selected='selected'>".$row["name"]."</option>";
				}else{
					echo "<option value=".$row["idNewsAuthor"].">".$row["name"]."</option>";
				}
            }
            $dbh=NULL;
            ?>
            </select><br />
            <p>Datum</p>
            <input type="text" name="datum" size="10" value="<?php echo $content["date"];?>"/><br />
            <p>Titel</p>
            <input type="text" name="title" size="50" value="<?php echo $content["title"];?>"/><br />
			<input type="hidden" name="edit" value="<?php echo $content["idNewsItems"];?>" />
               <p>Text</p>
            <textarea name="text" cols="50" rows="15" ><?php echo $content["description"];?></textarea><br />
         <input type="image" class="button" src="images/icons/save.png"  alt="Absenden"/>
        <a href="index.php"><img alt="Cancel" class="button" src="images/icons/cancel.png" /></a>
			<?php
			}else{
			foreach ($dbh->query("SELECT * FROM tblNewsCategory") as $row)
            {
              echo "<option value=".$row["idNewsCategory"].">".$row["name"]."</option>";
            }
            ?>
            </select><br />
            <select name="author">
            <?php
            foreach ($dbh->query("SELECT * FROM tblNewsAuthor") as $row)
            {
              echo "<option value=".$row["idNewsAuthor"].">".$row["name"]."</option>";
            }
            $dbh=NULL;
            ?>
            </select><br />
            <p>Datum</p>
            <input type="text" name="datum" size="10" value="<?php date("Y-m-d"); ?>"/><br />
            <p>Titel</p>
            <input type="text" name="title" size="50" /><br />
            <p>Text</p>
            <textarea name="text" cols="50" rows="15"></textarea><br />
         <input type="image" class="button" src="images/icons/save.png"  alt="Absenden"/>
        <a href="index.php"><img alt="Cancel" class="button" src="images/icons/cancel.png" /></a>
			<?php
			}
			?>
        </form>
		</div>
		</div>
		</div>
    </body>
</html>
