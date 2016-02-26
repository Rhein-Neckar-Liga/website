<?php
 //Script zur Freigabe von Newseinträgen
 //@author: Dani 13.9.2010 11:05:19 
 
 /* if isset POST_ID = true and POST_FREIGABE == false
	echo "Möchten Sie folgenden Newseintrag, übermittelt von $autor  am $datum freigeben?";
	echo "$beitrag";
	Ja / Nein mit Links 
	elseif isset POST_ID = true and POST_FREIGABE == true
	dbh->exec(query)
	elseif isset POST_ID = false
	echo "freizugebende Beiträge Liste"
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Freigabe von Newseinträgen</title>
    </head>
    <body>
        <?php
          include_once '../includes/clsDb.php';
          error_reporting(E_ALL);
          $dbh = clsDb::connect();
          if (isset($_POST["category"]))
          {
            $author = $_POST["author"];
            $category = $_POST["category"];
            $title = $_POST["title"];
            $text = $_POST["text"];
            $datum = $_POST["datum"];
            $datum = date("Y-m-d", strtotime($datum));
            $link="";
            $eintrag = "INSERT INTO tblNewsItems (date,title,description,link,idNewsAuthor,idNewsCategory) VALUES ('$datum', '$title','$text','$link','$author','$category')";
            $dbh->exec($eintrag); //SQL Statement absetzen
            echo $title . "für den " .$datum. " eingetragen";
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
        ?>
<div style="float:left;width:40%;padding:1em;border:1px solid #c03;">
        <form method="post" action="">
            <select name="category">
            <?php
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
            <textarea name="text" cols="50" rows="30"></textarea><br />
            <input type="submit" />
        </form>
		</div>
		<div style="float:right;width:40%;padding:1em;border:1px solid #c03;">
		<?php include('../inhalte/neu.php');?>
		</div>
    </body>
</html>
