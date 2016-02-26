        <?php
		include_once ('../includes/clsDb.php');
		include_once('../includes/clsSite.php');
		include_once "../includes/scripts/feed.php";
		error_reporting(E_ALL);
		$dbh = clsDb::connect();
		$message = "";
		$getsite = "news";
		//ein Datensatz ist zur Bearbeitung ausgewählt
		if (isset($_GET["id"]) and isset($_GET["edit"]))
		  {
				$eintrag = "SELECT * FROM tblNewsItems WHERE idNewsItems = ".$_GET["id"];
				//SQL Statement absetzen
				foreach ($dbh->query($eintrag) as $row)
				{
					$content=$row;
				}
			}
		//das Formular wurde versendet
          if (isset($_POST["category"]))
          {
                    $author = $_POST["author"];
                    $category = $_POST["category"];
                    $title = $_POST["title"];
                    $datum = $_POST["datum"];
                    $datum = date("Y-m-d", strtotime($datum));
                    $text = $_POST["text"];
                    $link="";
					
					//ein vorhandender Datensatz wird editiert
                    if(isset ($_POST["edit"])){

                    $eintrag = "UPDATE tblNewsItems SET date='$datum', title='$title',description='$text',link='$link',idNewsAuthor='$author',idNewsCategory='$category' WHERE idNewsItems=".$_POST["edit"];
                    $message = "<span style='background-color:green;color:#fff;font-weight:bold;'><i>".$title . "</i> für den " .$datum. " aktualisiert</span >";
                    $dbh->exec($eintrag); //SQL Statement absetzen
                    }
					//ein neuer Datensatz wird erzeugt
					else{
                    $eintrag = "INSERT INTO tblNewsItems (date,title,description,link,idNewsAuthor,idNewsCategory) VALUES ('$datum', '$title','$text','$link','$author','$category')";
                    $message = "<span style='background-color:green;color:#fff;font-weight:bold;'><i>".$title . "</i> für den " .$datum. " eingetragen</span>";
                    $dbh->exec($eintrag); //SQL Statement absetzen
                    }
					//war die Aktion erfolgreich?
                  if ($dbh == FALSE) {
                  $message = "<span style='background-color:red;color:#fff;font-weight:bold;'> fehlgeschlagen!</span>";
                  }
                //Mailversand an die Ligaleitung, nur wenn wir nicht localhost sind:
                $loc=sindwirlocalhost();
                if ($loc==false){
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
          }
		//ein Datensatz wurde freigegeben
		if (isset($_GET["id"]) and isset($_GET["freigabe"]))
          {
			$eintrag = "UPDATE tblNewsItems SET freigabe = ".$_GET["freigabe"]." WHERE idNewsItems = ".$_GET["id"];
            $dbh->exec($eintrag); //SQL Statement absetzen
			if ($dbh!==FALSE) {
			$message = "<p style='background-color:green;color:#fff;font-weight:bold;'>Update erfolgreich</p>";
			}
			}  
		//ein Datensatz wurde gelöscht
		if (isset($_GET["id"]) and isset($_GET["delete"]))
          {
			$eintrag = "DELETE FROM tblNewsItems WHERE idNewsItems = ".$_GET["id"];
            $dbh->exec($eintrag); //SQL Statement absetzen
			if ($dbh!==FALSE){
			$message = "<p style='background-color:red;color:#fff;font-weight:bold;'>Delete erfolgreich</p>";
			}
			} 
		//durchgeführte Aktion ausgeben
		echo $message . "<br/>";
		//news anzeigen
		$news=new clsSite();
		$news->showNews("", true);
		//Feed erzeugen
		$feed=new createFeed();
		$feed->create();
		$feed->save(); 
		echo "</div>";
		//Anzeige der Nachrichten beendet, neuer feed erzeugt
		//News-Formular erzeugen:
        echo "<div style='opacity: 0.9;position:fixed;right:10px;top:10px;padding:1em;border:2px solid #c03;background-color:#fff;'>";
        echo "<form method='post' action='index.php?site=news'>";
		echo "<select name='category'>";
			//content wurde oben über die GET Variablen gefüllt, sofern gewählt
			if (isset ($content)){
					foreach ($dbh->query("SELECT * FROM tblNewsCategory") as $row)
					{
						if($content["idNewsCategory"]==$row["idNewsCategory"]){
							echo "<option value=".$row["idNewsCategory"]." selected='selected'>".$row["name"]."</option>";
						}else{
							echo "<option value=".$row["idNewsCategory"].">".$row["name"]."</option>";
						}
					}
				echo "</select><br />";
				echo "<select name='author'>";
					foreach ($dbh->query("SELECT * FROM tblNewsAuthor") as $row)
					{
						if($content["idNewsAuthor"]==$row["idNewsAuthor"]){
							echo "<option value=".$row["idNewsAuthor"]." selected='selected'>".$row["name"]."</option>";
						}else{
							echo "<option value=".$row["idNewsAuthor"].">".$row["name"]."</option>";
						}
					}
					$dbh=NULL;
					echo "</select><br />";
					echo "<p>Datum</p>";
					echo "<input type='text' name='datum' size='10' value='".$content['date']."'/><br />";
					echo "<p>Titel</p>";
					echo "<input type='text' name='title' size='50' value='". $content['title']."'/><br />";
					echo "<input type='hidden' name='edit' value='". $content['idNewsItems']."' />";
					echo "<p>Text</p>";
					echo "<textarea name='text' cols='50' rows='15' >". $content['description']."</textarea><br />";
					echo "<input type='image' class='button' src='images/icons/save.png'  alt='Absenden'/>";
					echo "<a href='index.php?site=news'><img alt='Cancel' class='button' src='images/icons/cancel.png' /></a>";

			}
			//es wurde kein Datensatz ausgewählt, wir geben das leere Formular aus
			else{ //content not set
			foreach ($dbh->query("SELECT * FROM tblNewsCategory") as $row)
            {
              echo "<option value=".$row["idNewsCategory"].">".$row["name"]."</option>";
            }
            echo "</select><br />";
            echo "<select name='author'>";

            foreach ($dbh->query("SELECT * FROM tblNewsAuthor") as $row)
            {
              echo "<option value=".$row["idNewsAuthor"].">".$row["name"]."</option>";
            }
            $dbh=NULL;
            echo "</select><br />";
            echo "<p>Datum</p>";
            echo "<input type='text' name='datum' size='10' value='". date('Y-m-d') ."'/><br />";
            echo "<p>Titel</p>";
            echo "<input type='text' name='title' size='50' /><br />";
            echo "<p>Text</p>";
            echo "<textarea name='text' cols='50' rows='15'></textarea><br />";
			echo "<input type='image' class='button' src='images/icons/save.png'  alt='Absenden'/>";
			echo "<a href='index.php?site=news'><img alt='Cancel' class='button' src='images/icons/cancel.png' /></a>  </form>";
			echo "</p>";
           }
function sindwirlocalhost() {
		$dr = $_SERVER['DOCUMENT_ROOT'];
		if (substr_count($dr, "/xampp/")>0)
                {
                //localhost
                $loc=true;
                }
                else
                {
                //online
                $loc=false;
                }
            return $loc;
        }
?>