<?php

include_once 'clsDb.php';
/**
 * Description of clsSite
 *
 * @author alfredo
 * @coauthor dani
 */
class clsSite {
       
			public $idVereine;
			public $name;
			public $kontakt;
			public $Vorsitzender;
			public $sex;
			public $Strasse;
			public $Wohnort;
			public $spielort;
			public $lat;
			public $lon;
			public $spielzeiten;
			public $gruendungsjahr;
			public $anzahlMitglieder;
			public $jahresbeitrag;
			public $anzahlUebungsleiter;
			public $anzahlSchiedsrichter;
			public $email;
			public $telefon;
			public $website;
			public $feed;
			public $position;
			public $logo;
			public $vereinsnummer;
			public $kuerzel;
			public $aktiv;
			private $extensions =array();
	   function __construct() 
		{
		$zaehler=0;
			if (isset($_GET["vereinsnummer"])) 
				{$this->vereinsnummer=$_GET["vereinsnummer"];}
				if($this->vereinsnummer){
						$sql = "SELECT * FROM tblVereine WHERE vereinsnummer=$this->vereinsnummer";
						}
				else {
						$sql = "SELECT * FROM tblVereine WHERE vereinsnummer=''";
						}
								$dbh = clsDb::connect();
								foreach ($dbh->query($sql) as $row) 
								{ 
								$zaehler=1;
									$this->idVereine=$row["idVereine"];
									$this->name=$row["name"];
									$this->kontakt=$row["kontakt"];
									$this->Vorsitzender=$row["Vorsitzender"];
									$this->sex=$row["sex"];
									$this->Strasse=$row["Strasse"];
									$this->Wohnort=$row["Wohnort"];
									$this->spielort=$row["spielort"];
									$this->lat=$row["lat"];
									$this->lon=$row["lon"];
									$this->spielzeiten=$row["spielzeiten"];
									$this->gruendungsjahr=$row["gruendungsjahr"];
									$this->anzahlMitglieder=$row["anzahlMitglieder"];
									$this->jahresbeitrag=$row["jahresbeitrag"];
									$this->anzahlUebungsleiter=$row["anzahlUebungsleiter"];
									$this->anzahlSchiedsrichter=$row["anzahlSchiedsrichter"];
									$this->email=$row["email"];
									$this->telefon=$row["telefon"];
									$this->website=$row["website"];
									$this->feed=$row["feed"];
									$this->position=$row["position"];
									$this->logo=$row["logo"];
									$this->kuerzel=$row["kuerzel"];
									$this->aktiv=$row["aktiv"];
								}
						if($zaehler==0){
						$sql = "SELECT * FROM tblVereine WHERE vereinsnummer=''";
								foreach ($dbh->query($sql) as $row) 
								{ 
								$zaehler=1;
									$this->idVereine=$row["idVereine"];
									$this->vereinsnummer=$row["vereinsnummer"];
									$this->name=$row["name"];
									$this->kontakt=$row["kontakt"];
									$this->Vorsitzender=$row["Vorsitzender"];
									$this->sex=$row["sex"];
									$this->Strasse=$row["Strasse"];
									$this->Wohnort=$row["Wohnort"];
									$this->spielort=$row["spielort"];
									$this->lat=$row["lat"];
									$this->lon=$row["lon"];
									$this->spielzeiten=$row["spielzeiten"];
									$this->gruendungsjahr=$row["gruendungsjahr"];
									$this->anzahlMitglieder=$row["anzahlMitglieder"];
									$this->jahresbeitrag=$row["jahresbeitrag"];
									$this->anzahlUebungsleiter=$row["anzahlUebungsleiter"];
									$this->anzahlSchiedsrichter=$row["anzahlSchiedsrichter"];
									$this->email=$row["email"];
									$this->telefon=$row["telefon"];
									$this->website=$row["website"];
									$this->feed=$row["feed"];
									$this->position=$row["position"];
									$this->logo=$row["logo"];
									$this->kuerzel=$row["kuerzel"];
									$this->aktiv=$row["aktiv"];
								}
						}
						$dbh = NULL;
$this->extensions = array("pdf", "jpg", "txt", "doc", "xls", "ppt", "odt", "ods", "save");
		}	
    function showNews($category="", $edit=false){
        $dbh = clsDb::connect();
		if($edit){
			$sql="SELECT * FROM viewNews ORDER BY freigabe, date DESC";
		}else{
        if (strlen($category) < 2) {
            $sql="SELECT * FROM viewNews WHERE freigabe=1 AND date > '".date("Y-m-d", strtotime("-12 month"))."' ORDER BY date DESC";
        } else {
            $sql="SELECT * FROM viewNews WHERE freigabe=1 AND css='".$category."' AND date > '".date("Y-m-d", strtotime("-12 month"))."'  ORDER BY date DESC";
        }
		}
		if($edit){
            echo "<div class='beitrag'>";
            echo "<p>Hallo Admin!<br/><br/>";
			echo "Auf dieser Seite kannst Du Beiträge<br/>"; 
            echo "veröffentlichen ( = <img alt='Veröffentlichen' class='inline' src='../verwaltung/images/icons/publish.png' />)<br/>";
			echo "Sperren ( = <img alt='Sperren' class='inline' src='../verwaltung/images/icons/stop.png' />)<br/>";
			echo "unwiederruflich Löschen ( = <img alt='Löschen' class='inline' src='../verwaltung/images/icons/delete.png' />)<br/>";
			echo "und Beiträge beabeiten ( = <img alt='Bearbeiten' class='inline' src='../verwaltung/images/icons/edit.png' />)";
            echo "</p>";
            echo "</div>";
		}
        foreach ($dbh->query($sql) as $row)
        {
		  if($edit and isset($_GET["id"])){
              if ($row["idNewsItems"]==$_GET["id"]) {
                  echo "<div class='beitrag edit ".$row["css"]."'>";
                  } else {echo "<div class='beitrag ".$row["css"]."'>";}
            }
            else if ($edit and isset($_GET["id"])==false){
                echo "<div class='beitrag ".$row["css"]."'>";
                }
            if ($edit){
				echo "<a id='rnl_".$row["date"]."_".$row["idNewsItems"]."'></a>";
				echo "<a title='Bearbeiten' href='?site=news&amp;id=".$row["idNewsItems"]."&amp;edit=1#rnl_".$row["date"]."_".$row["idNewsItems"]."'><img alt='Bearbeiten' class='button' src='../verwaltung/images/icons/edit.png' /></a>";
					if ($row["freigabe"]==1) {
						echo "<a title='Sperren' href='?site=news&amp;id=".$row["idNewsItems"]."&amp;freigabe=0#rnl_".$row["date"]."_".$row["idNewsItems"]."'><img alt='Sperren' class='button' src='../verwaltung/images/icons/stop.png' /></a>";
					}
					else {
						echo "<a title='Veröffentlichen' href='?site=news&amp;id=".$row["idNewsItems"]."&amp;freigabe=1#rnl_".$row["date"]."_".$row["idNewsItems"]."'><img alt='Veröfentlichen' class='button' src='../verwaltung/images/icons/publish.png' /></a>";
						echo "<a title='Löschen' href='?site=news&amp;id=".$row["idNewsItems"]."&amp;delete=1'><img alt='Löschen' class='button' src='../verwaltung/images/icons/delete.png' /></a>";
					}
				echo "<br /><br />";
            }
          else {
             echo "<div class='beitrag ".$row["css"]."'>";
          }
          echo "<h1>".$row["title"]."</h1>";
          echo $row["description"];
          echo "<p class='autor'>".$row["author"]." am ".date("d.m.Y",strtotime($row["date"]))."</p>";
          echo '</div>';
        }
        $dbh = NULL;
    }

    /**
     * Zeigt die Vereine an
     */
    function showVereine($edit=false) { 
		if($edit){
            echo "<div class='beitrag'><p>Hallo Admin!<br/><br/>";
            echo "Auf dieser Seite kannst Du die Mitgliedsvereine <br/>";
            echo "bearbeiten ( = <img alt='Bearbeiten' class='inline' src='../verwaltung/images/icons/edit.png' />)<br/>";
            echo "sperren ( = <img alt='sperren' class='inline' src='../verwaltung/images/icons/stop.png' />) bzw. wieder freigeben (=  <img alt='freigeben' class='inline' src='../verwaltung/images/icons/publish.png' />)<br/>";
            echo "und neue Vereine anlegen ( = <img alt='Bearbeiten' class='inline' src='../verwaltung/images/icons/new.png' />.)</p>";
			echo "<p><a href='?site=vereine&amp;action=insert'><img alt='Neuen Verein anlegen' class='button' src='../verwaltung/images/icons/new.png' /> Neuen Verein anlegen</a></p>";
            echo "</div>";
		$sql = "SELECT * FROM tblVereine ORDER BY vereinsnummer";
        }
        else { 
        //$sql = "SELECT * FROM tblVereine WHERE aktiv=1 ORDER BY name";
        $sql = "SELECT * FROM tblVereine WHERE aktiv=1 ORDER BY vereinsnummer";
        } 
        $dbh = clsDb::connect();
        foreach ($dbh->query($sql) as $row) { 
			echo "<div class='beitrag'>";
			if($edit){ 
                echo "<p>";
                echo "<a title='Bearbeiten' href='?site=vereine&amp;id=".$row["idVereine"]."&amp;action=edit'><img alt='Bearbeiten' class='button' src='../verwaltung/images/icons/edit.png' /></a>";
                if ($row["aktiv"]==1)echo "<a title='Sperren' href='?site=vereine&amp;id=".$row["idVereine"]."&amp;action=delete'><img alt='sperren' class='button' src='../verwaltung/images/icons/stop.png' /></a>";
                else echo "<a title='Freigeben' href='?site=vereine&amp;id=".$row["idVereine"]."&amp;action=publish'><img alt='Freigeben' class='button' src='../verwaltung/images/icons/publish.png' /></a>";
                echo "</p>"; 
			} 
				echo "<h2>" . $row["name"] . "</h2>";
					if($row["lat"]){ 
						echo "<a href='?site=karte&amp;vereinsnummer=" . $row["vereinsnummer"] . "'><img style='margin:-30px 0 0 0;padding:0;display:inline;float:right;'  alt='Map' src='http://staticmap.openstreetmap.de/staticmap.php?center=".$row["lat"].",".$row["lon"]."&amp;zoom=14&amp;size=150x150' /></a>";
						if($row["logo"]) echo "<img style='margin:-20px 0 0 0;padding:0;display:inline;float:right;' src='../images/vereine/" . $row["logo"] . "' alt='Logo " . $row["name"] . "' align='right' height='100' />";
					}
				echo"<p style='border-bottom:dotted 1px #039;'>";
                    if($edit) echo "aktiv: " . $row["aktiv"] . " (1=ja, 0=nein) <br/>";
					if($row["vereinsnummer"]) echo "VereinsNr.: " . $row["vereinsnummer"] . "<br/>";
					if($row["kontakt"]) echo "Kontakt: " . $row["kontakt"] . "<br/>";
					if($row["spielort"]) echo "Spielort: <a href='?site=karte&amp;vereinsnummer=" . $row["vereinsnummer"] . "'>" . $row["spielort"] . "</a><br/>";
					if($row["spielzeiten"]) echo "Spielzeiten: " .$row["spielzeiten"] . "<br/>";
					if($row["anzahlMitglieder"]) echo "Mitgliederzahl: " . $row["anzahlMitglieder"] . "<br/>";
					if($row["jahresbeitrag"]) echo "Jahresbeitrag: " . $row["jahresbeitrag"] . "<br/>";
					if($row["anzahlUebungsleiter"]) echo "Übungsleiter: " . $row["anzahlUebungsleiter"] . "<br/>";
					if($row["anzahlSchiedsrichter"]) echo "Schiedsrichter: " . $row["anzahlSchiedsrichter"] . "<br/>";
					if($row["email"]) echo "email: <a href='mailto:" . $row["email"] . "'>" . $row["email"] . "</a><br/>";
					if ($row["website"]) echo "Homepage: <a target='_blank' href='" . $row["website"] . "'>" . $row["website"] . "</a><br/>";
					if ($row["telefon"]) echo "Telefon: " . $row["telefon"] . "<br/>";
				echo "</p></div>";
        }
        $dbh = NULL;
    }

    /**
     * Zeigt die Mannheimer Vereine an
     */
    function showVereineMannheim($edit=false) {
		if($edit){
			echo "<p><a href='?site=vereine&amp;action=insert'>Neuen Eintrag erstellen</a></p>";
		}
        $dbh = clsDb::connect();
        $sql = "SELECT * FROM viewVereineMannheim ORDER BY name";
        foreach ($dbh->query($sql) as $row) { 
			echo "<div class='beitrag'>";
			if($edit){
				echo "<p>";
				echo "<a title='Bearbeiten' href='?site=vereine&amp;id=".$row["idVereine"]."&amp;action=edit'><img alt='Bearbeiten' class='button' src='../verwaltung/images/icons/edit.png' /></a>";
			echo "<a title='Löschen' href='?site=vereine&amp;id=".$row["idVereine"]."&amp;action=delete'><img alt='delete' class='button' src='../verwaltung/images/icons/stop.png' /></a>";
			echo "</p>";
			}
				echo "<h2>" . $row["name"] . "</h2>";
					if($row["logo"]) echo "<img style='margin:0;padding:0;display:inline;float:right;' src='../images/vereine/" . $row["logo"] . "' alt='Logo " . $row["name"] . "' align='right' height='100' />";
				echo"<p style='border-bottom:dotted 1px #039;'>";
					if($row["vereinsnummer"]) echo "VereinsNr.: " . $row["vereinsnummer"] . "<br/>";
					if($row["kontakt"]) echo "Kontakt: " . $row["kontakt"] . "<br/>";
					if($row["spielort"]) echo "Spielort: <a href='" . $row["position"] . "'>" . $row["spielort"] . "</a><br/>";
					if($row["spielzeiten"]) echo "Spielzeiten: " .$row["spielzeiten"] . "<br/>";
					if($row["anzahlMitglieder"]) echo "Mitgliederzahl: " . $row["anzahlMitglieder"] . "<br/>";
					if($row["jahresbeitrag"]) echo "Jahresbeitrag: " . $row["jahresbeitrag"] . "<br/>";
					if($row["anzahlUebungsleiter"]) echo "Übungsleiter: " . $row["anzahlUebungsleiter"] . "<br/>";
					if($row["anzahlSchiedsrichter"]) echo "Schiedsrichter: " . $row["anzahlSchiedsrichter"] . "<br/>";
					if($row["email"]) echo "email: <a href='mailto:" . $row["email"] . "'>" . $row["email"] . "</a><br/>";
					if ($row["website"]) echo "Homepage: <a target='_blank' href='" . $row["website"] . "'>" . $row["website"] . "</a><br/>";
					if ($row["telefon"]) echo "Telefon: " . $row["telefon"] . "<br/>";
					if ($row["kuerzel"]) echo "<a target='_blank' href='../dokus/2011/Spielplan_" . $row["kuerzel"] . ".pdf'>&raquo;&raquo; Spielplanübersicht 2011 für " . $row["name"] . ".</a>";
				echo "</p></div>";
        }
        $dbh = NULL;
    }
    /**
     * Zeigt die Turniere an
     */
    function showTurniere($edit=false) {
       if($edit){
            echo "<div class='beitrag'><p>Hallo Admin!<br/><br/>";
            echo "Auf dieser Seite kannst Du die Turniere verwalten.<br/>";
            echo "Bearbeiten ( = <img alt='Bearbeiten' class='inline' src='../verwaltung/images/icons/edit.png' />)<br/>";
            echo "Sperren ( = <img alt='sperren' class='inline' src='../verwaltung/images/icons/stop.png' />) bzw. wieder freigeben (=  <img alt='freigeben' class='inline' src='../verwaltung/images/icons/publish.png' />)<br/>";
            echo "Gesperrte Turniere können gelöscht werden ( = <img alt='Löschen' class='inline' src='../verwaltung/images/icons/delete.png' />)<br/>";
            echo "Neues Turnier anlegen ( = <img alt='Anlegen' class='inline' src='../verwaltung/images/icons/new.png' />.)</p>";
			echo "<p><a href='?site=turniere&amp;action=insert'><img alt='Neues Turnier anlegen' class='button' src='../verwaltung/images/icons/new.png' /> Neues Turnier anlegen</a></p>";
            echo "</div>";
			$sql = "SELECT * FROM viewTurniere ORDER BY datum";
			}
			else $sql = "SELECT * FROM viewTurniere  WHERE aktiv=1 ORDER BY datum";
        $dbh = clsDb::connect();
        echo "<div class='beitrag'>
			<table summary='Turniere der Rhein-Neckar-Region' style='width:99%;'>
                <tr>";
				 if($edit) echo "<th>Edit</th>";
           echo "<th>Datum<br />Beginn</th>
                    <th>Einschreibung</th>
                    <th>Turnier</th>
                    <th>Veranstalter<br />Kontakt / Mail</th>
                </tr>";

        foreach ($dbh->query($sql) as $row) {
            if (strtotime($row["datum"]) < strtotime("-3 days")
                )continue; //Wenn der Eintrag mehr als 1 Tag in der Vergangenheit liegt, wird der Rest übersprungen
			echo "<tr>";
				if($edit){
					echo "<td style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>";
					echo "<a title='Bearbeiten' href='?site=turniere&amp;id=".$row["idTurniere"]."&amp;action=edit'><img alt='Bearbeiten' class='button' src='../verwaltung/images/icons/edit.png' /></a>";
					if ($row["aktiv"]==1)echo "<a title='Sperren' href='?site=turniere&amp;id=".$row["idTurniere"]."&amp;action=stop'><img alt='sperren' class='button' src='../verwaltung/images/icons/stop.png' /></a></td>";
					else echo  "<a title='Freigeben' href='?site=turniere&amp;id=".$row["idTurniere"]."&amp;action=publish'><img alt='Freigeben' class='button' src='../verwaltung/images/icons/publish.png' /></a>\n
								<a title='Löschen' href='?site=turniere&amp;id=".$row["idTurniere"]."&amp;action=delete'><img alt='Löschen' class='button' src='../verwaltung/images/icons/delete.png' /></a></td>
								";
				} 
            echo "<td>" . date("d.m.Y", strtotime($row["datum"])) . "<br />" . date("H:i", strtotime($row["zeit"])) . " Uhr</td>";
            echo "<td>";
            if (isset($row["einschreibung"])) {
            echo "<b>".date("H:i", strtotime($row["einschreibung"])) . " Uhr</b>";
            }
            else {
            echo date("H:i", strtotime($row["zeit"])) . " Uhr";
            }

            echo    "</td>"; 
            $strLink = "";
            if (isset($row["einladung"])) {
			//DEBUG
			$parts = explode(".", basename($row["einladung"]));
				if (is_array($parts)) 
					{    
						$extension = end($parts);  
							if (in_array($extension, $this->extensions) == true)
							{
							$class=$extension;
							$strLink = "<a class='$extension' target='_blank' href='" . $row["einladung"] . "'><b>".$row["name"]."</b></a>";
							}
							else 
							{
							$class="";
							$strLink =  "<b>" . $row["name"]."</b>";
							}
			
						}
			//DEBUG
                // $strLink = "<a class='$extension' target='_blank' href='" . $row["einladung"] . "'>Einladung</a>";
            }
			else {
				$class="";
				$strLink =  "<b>" . $row["name"]."</b>";
			}
            echo "<td>". $strLink . "<br />" . $row["modus"] . "</td>";
            echo "<td>";
            if (isset($row["website"])) {
                echo "<a target='_blank' href='" . $row["website"] . "' >" . $row["vereinsname"] . "</a>";
            } else {
                echo "<span style='color:#800000;'>" . $row["vereinsname"] . "</span>";
            }
            echo "<a href='mailto:" . $row["email"] . "'><img alt='email' src='../images/mail.gif' border='0' align='right' /></a>
                    <br />" . $row["telefon"] . "</td>";
            echo "</tr>";
        }
        echo "</table></div>";
        $dbh = NULL;
    }

    /**
     * Zeigt die Liga- und Staffelleiter an
     */
    function showLigaleitung($edit=false) {
       if($edit){
            echo "<div class='beitrag'><p>Hallo Admin!<br/><br/>";
            echo "Auf dieser Seite kannst Du die Liga- und Staffelleiter verwalten.<br/>";
            echo "Bearbeiten ( = <img alt='Bearbeiten' class='inline' src='../verwaltung/images/icons/edit.png' />)<br/>";
            echo "Sperren ( = <img alt='sperren' class='inline' src='../verwaltung/images/icons/stop.png' />) bzw. wieder freigeben (=  <img alt='freigeben' class='inline' src='../verwaltung/images/icons/publish.png' />)<br/>";
            echo "Neue Leiter anlegen ( = <img alt='Anlegen' class='inline' src='../verwaltung/images/icons/new.png' />.)</p>";
			echo "<p><a href='?site=ligaleitung&amp;action=insert'><img alt='Neuen Leiter anlegen' class='button' src='../verwaltung/images/icons/new.png' /> Neuen Ligaleiter anlegen</a></p>";
            echo "</div>";
		$sql = "SELECT * FROM tblLigaleitung ORDER BY Sortierung";
        }
        else {
        $sql = "SELECT * FROM tblLigaleitung WHERE aktiv=1 ORDER BY Sortierung";
        }
        $dbh = clsDb::connect();
        echo "<div class='beitrag'>
			<table summary='' style='width:99%;border:solid 1px #D3AD9A;border-collapse:collapse;'>
                <tr>";
				if($edit){
					echo "<th style='width: 10%;border:solid 1px #D3AD9A;text-align:left;padding:0 5px;'>Edit</th>
					      <th style='border:solid 1px #D3AD9A;text-align:left;padding:0 5px;'>Sortierung</th>";
				 }
				echo "<th style='border:solid 1px #D3AD9A;text-align:left;padding:0 5px;'>Postition</th>
                    <th style='width: 10%;border:solid 1px #D3AD9A;text-align:left;padding:0 5px;'>Vorname</th>
                    <th style='width: 10%;border:solid 1px #D3AD9A;text-align:left;padding:0 5px;'>Nachname</th>
                    <th style='width: 15%;border:solid 1px #D3AD9A;text-align:left;padding:0 5px;'>Aufgaben</th>
                    <th style='width: 20%;border:solid 1px #D3AD9A;text-align:left;padding:0 5px;'>Kontakt</th>
                    <th style='width: 15%;border:solid 1px #D3AD9A;text-align:left;padding:0 5px;'>Verein</th>
                    <th style='width: 10%;border:solid 1px #D3AD9A;text-align:left;padding:0 5px;'>Bild</th>
                </tr>";
		foreach ($dbh->query($sql) as $row) {
			echo "<tr>";
				if($edit){
					echo "<td style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>";
					echo "<a title='Bearbeiten' href='?site=ligaleitung&amp;id=".$row["idLigaleiter"]."&amp;action=edit'><img alt='Bearbeiten' class='button' src='../verwaltung/images/icons/edit.png' /></a>";
					if ($row["aktiv"]==1)echo "<a title='Sperren' href='?site=ligaleitung&amp;id=".$row["idLigaleiter"]."&amp;action=stop'><img alt='sperren' class='button' src='../verwaltung/images/icons/stop.png' /></a></td>";
					else echo "<a title='Freigeben' href='?site=ligaleitung&amp;id=".$row["idLigaleiter"]."&amp;action=publish'><img alt='Freigeben' class='button' src='../verwaltung/images/icons/publish.png' /></a></td>";
					echo "<td style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>".$row["Sortierung"]."</td>";
				}                            
				echo "<td style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>".$row["Position"]."</td>";
				echo "<td style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>".$row["Vorname"]."</td>";
				echo "<td style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>".$row["Nachname"]."</td>";
				echo "<td style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>".$row["Aufgaben"]."</td>";
				echo "<td style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>Tel: ".$row["Telefon"]."<br/>Mobil: ".$row["Mobil"]."<br/><a href='mailto:".$row["Email"]."'>".$row["Email"]."</a><br/>".$row["Strasse"]."<br/>".$row["Wohnort"]."<br/></td>";
				echo "<td style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>".$row["Verein"]."</td>";
				echo "<td style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>";
				echo ($row["Bild"]!=="") ? "<img alt='' style='margin:0;' src='../images/personen/".$row["Bild"]."' width='100' /></td>" : "</td>";

			echo "</tr>";
			}
        echo "</table></div>";
        $dbh = NULL;
    }
    /**
     * Zeigt die Liga- und Staffelleiter an
     */
    function showSpieltage($edit=false) {
       if($edit){
            echo "<div class='beitrag'><p>Hallo Admin!<br/><br/>";
            echo "Auf dieser Seite kannst Du die Ligaspieltage verwalten:<br/><br/>";
            echo "<img alt='Bearbeiten' class='inline' src='../verwaltung/images/icons/edit.png' /> Bearbeiten <br/>";
            echo "<img alt='sperren' class='inline' src='../verwaltung/images/icons/stop.png' /> Sperren<br/>";
			echo "<img alt='freigeben' class='inline' src='../verwaltung/images/icons/publish.png' /> Freigeben<br/>";
            echo "<img alt='Anlegen' class='inline' src='../verwaltung/images/icons/new.png' /> Neuen Spieltag anlegen<br/>";
			echo"Spieltage zu löschen <img alt='Löschen' class='inline' src='../verwaltung/images/icons/delete.png' /> ist hier nicht vorgesehen.</p>";
			echo "<p><a href='?site=spielplan&amp;action=insert'><img alt='Neuen Spieltag anlegen' class='button' src='../verwaltung/images/icons/new.png' /> Neuen Spieltag anlegen</a></p>";
            echo "</div>";
       $sql = "SELECT * FROM tblSpieltage ORDER BY SUBSTRING(Datum,1,4) DESC, Datum ASC";
        }
        else {
        $sql = "SELECT * FROM tblSpieltage WHERE aktiv=1 ORDER BY Datum";
        }
        $dbh = clsDb::connect();
        echo "<div class='beitrag'>
			<table summary='' style='width:99%;border:solid 1px #D3AD9A;border-collapse:collapse;'>
                ";
				if($edit){
					echo "<tr><th style='color:#333;' colspan='7'>Spieltage der Rhein-Neckar-Liga</th></tr>";
					echo "<tr><th style='color:#333;'>Edit</th>";
				 }
				 else {
					echo "<tr><th style='color:#333;' colspan='6'>Spieltage der Rhein-Neckar-Liga</th></tr><tr>";
				}
				
				echo "
					<th style='color:#333;'>Spieltage</th>
                    <th class='oberliganordkopf' >Oberliga</th>
                    <th class='landesligakopf' >Landesliga</th>
                    <th class='bezirksligakopf' >Bezirksliga</th>
                    <th class='kreisligakopf' >Kreisliga</th>
                    <th class='jugendligakopf' >Jugendliga</th>
                </tr>";
		foreach ($dbh->query($sql) as $row) {
			echo "<tr>";
				if($edit){
					echo "<td style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>";
					echo "<a title='Bearbeiten' href='?site=spielplan&amp;id=".$row["idSpieltag"]."&amp;action=edit'><img alt='Bearbeiten' class='button' src='../verwaltung/images/icons/edit.png' /></a>";
					if ($row["aktiv"]==1)echo "<a title='Sperren' href='?site=spielplan&amp;id=".$row["idSpieltag"]."&amp;action=stop'><img alt='sperren' class='button' src='../verwaltung/images/icons/stop.png' /></a></td>";
					else echo "<a title='Freigeben' href='?site=spielplan&amp;id=".$row["idSpieltag"]."&amp;action=publish'><img alt='Freigeben' class='button' src='../verwaltung/images/icons/publish.png' /></a></td>";
				}                            
				echo "<td style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>" . date("d.m.Y", strtotime($row["Datum"])) ."</td>";
				echo "<td class='oberliganord' style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>".$row["Oberliga"]."</td>";
				echo "<td class='landesliga' style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>".$row["Landesliga"]."</td>";
				echo "<td class='bezirksliga' style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>".$row["Bezirksliga"]."</td>";
				echo "<td class='kreisliga' style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>".$row["Kreisliga"]."</td>";
				echo "<td class='jugendliga' style='vertical-align:top;border:solid 1px #D3AD9A;padding:0 5px;'>".$row["Jugendliga"]."</td>";
			echo "</tr>";
			}
        echo "</table>";
		//Hinweise zum Spielplan einbinden
		if ($_SERVER['SERVER_NAME'] == 'localhost') {
				$pfad = $_SERVER['DOCUMENT_ROOT'] . "/rhein-neckar-liga.de";
		}
		else {
				$pfad = $_SERVER['DOCUMENT_ROOT'];
			}
		$datei = $pfad.'/docs/spielplanhinweis.php'; // Pfad zur Datei
        if (file_exists ($datei)){
            if($edit){
                        $array = file($datei); // Datei in ein Array einlesen
                        echo "<form method='post' action='?site=spielplan' style='margin:10px;width:100%'>";
                        echo "<input type='hidden' name='action' value='spielplanhinweis'/>";
                        echo "<textarea cols='25' name='hinweis' rows='20'>";
                            foreach ($array as $element) {
                                echo $element; // Dateiinhalt ausgeben
                            }
                        echo"</textarea><br style='clear:both;' />";
                        echo "<input type='image' class='button' src='images/icons/save.png'  alt='Absenden'/>";
                        echo "<a href='index.html'><img alt='Cancel' class='button' src='images/icons/cancel.png' /></a>";
                        echo "</form>";
                          if ($message) echo "<p>".$message."</p>";
                    }
		else include ($datei);
        }
        else echo "<p><b>Konnte Datei $datei nicht laden!!!</b></p>";
		echo "</div>";
        $dbh = NULL;
    }
   /**
     *
     * @param bool $active optional Wahl ob aktuelle oder auch alte Dokumente angezeigt werden sollen (1 aktuelle 0 alle) 
     */
    function showDokumente($active="1", $edit=false) {
			if($edit){
            echo "<div class='beitrag'><div style='float:left;width:45%;'><p>Hallo Admin!<br/><br/>";
            echo "Auf dieser Seite kannst Du die Dokumente des Downloadbereiches <br/>";
            echo "bearbeiten ( = <img alt='Bearbeiten' class='inline' src='../verwaltung/images/icons/edit.png' />)<br/>";
            echo "sperren ( = <img alt='sperren' class='inline' src='../verwaltung/images/icons/stop.png' />) bzw. wieder freigeben (=  <img alt='freigeben' class='inline' src='../verwaltung/images/icons/publish.png' />)<br/>";
            echo "unwiederruflich Löschen ( = <img alt='Löschen' class='inline' src='../verwaltung/images/icons/delete.png' />)<br/>";
            echo "und neue Dokumente anlegen ( = <img alt='Bearbeiten' class='inline' src='../verwaltung/images/icons/new.png' />.)</p>";
			echo "<p><a href='?site=dokumente&amp;action=insert'><img alt='Neues Dokument anlegen' class='button' src='../verwaltung/images/icons/new.png' /> Neuen Dokument anlegen</a></p>";
			//
			echo "<p>Die Dokumente sind in Kategorien eingeteilt. Neue Kategorieren kannst Du hier anlegen:</p>";
					echo "<form method ='post' action='?site=dokumente'>";
					echo "<label for='newcategory'>Dokumentart&nbsp;</label><input type='text' name='newcategory' size='25' maxlength ='100' value='neue Kategorie' />&nbsp;";
					echo "<label for='idDokumentArt'>Sortierung&nbsp;</label><input type='text' name='idDokumentArt' size='4' maxlength ='4' value='1' />&nbsp;";
					echo "<input type ='submit' value ='Neue Kategorie anlegen'/>";
					echo "<input type ='hidden' name='action' value ='insertcategory'/>";
					echo "</form></div>";
			//
			// 
			echo "<div style='float:right;width:45%;'><p>Kategorieren bearbeiten:</p>";
					echo "<form method ='post' action='?site=dokumente'>";
					echo "<input type='hidden' name='action' value='editcategory'/>";
						echo "<p>Verfügbare Kategorien:</p>";
						$dbh = clsDb::connect();
						foreach ($dbh->query("SELECT * FROM tblDokumentArt") as $row)
							{
								echo "<input type='text' style='background-color:#ccc;' name='editcategoryID' size='3' maxlength ='4'  value='".$row["idDokumentArt"]."' />&nbsp<input type='text'  style='background-color:#ccc;' name='editcategoryName' size='50' maxlength ='100' value='".$row["name"]."' /><br/>";
							}
						$dbh = NULL;
					//echo "<input type ='submit' value ='Speichern'/>";
					echo "</form></div><br style='clear: both;'/>";
			//
            echo "</div>";
        }
        $dbh = clsDb::connect();
        if ($active==1 && $edit==false) {
            $sql = "SELECT * FROM viewDokumenteAktiv";
        } else {
            $sql = "SELECT * FROM viewDokumente";
        }
		
        $idArt=0; //Vergleicht mit idDokumentArt, ob neue Art vorliegt
        $firstTime=1; //bei neuer Art wird das tableTag geschlossen, außer beim ersten mal
		echo "<div class='beitrag'>";
        foreach ($dbh->query($sql) as $row) {
            if($idArt<>$row["idDokumentArt"]){
                if($firstTime<>1){
                    echo "</table>";
                }
                //Erstes mal für alle Zeiten vernichten
                $firstTime=0;
                echo "<h2>".$row["art"]."</h2>";
                $idArt=$row["idDokumentArt"];
                //Tabelle beginnen
                echo "<table summary='Dokumente'>";
            }
            echo "<tr>
                    <td>";
					//
						if ($edit){
							echo "<a title='Bearbeiten' href='?site=dokumente&amp;id=".$row["idDokument"]."&amp;action=edit'><img alt='Bearbeiten' class='button' src='../verwaltung/images/icons/edit.png' /></a>";
								if ($row["aktiv"]==1) {
									echo "<a title='Sperren' href='?site=dokumente&amp;id=".$row["idDokument"]."&amp;action=stop&amp;edit=1'><img alt='Sperren' class='button' src='../verwaltung/images/icons/stop.png' /></a>";
									}
								else {
									echo "<a title='Veröffentlichen' href='?site=dokumente&amp;id=".$row["idDokument"]."&amp;action=publish'><img alt='Veröfentlichen' class='button' src='../verwaltung/images/icons/publish.png' /></a>";
									echo "<a title='Löschen' href='?site=dokumente&amp;id=".$row["idDokument"]."&amp;action=delete&amp;delete=1'><img alt='Löschen' class='button' src='../verwaltung/images/icons/delete.png' /></a>";
								}
            }
					//
					echo $row["name"]."</td>
                    <td><a href='".$row["link"]."'><img alt='' style='margin:0;' src='../images/".$row["imageType"]."' /></a></td>
                    <td>vom ".  date("d.m.Y",  strtotime($row["datum"]))."</td>
                    </tr>";
        }
        //letzte Tabelle schließen
        echo "</table>";
		echo "</div>";
        $dbh = NULL;
    }
    function showKarte($lat=0, $lon=0, $vereinsnummer=false) {
			$this->showEinzelVerein($this->vereinsnummer);
					 if ($this->lat>0 and $this->lon>0) {
						$zoom=16;
					 }
					 else {
						$this->lon="8.8244";
						$this->lat="49.4454";
						$zoom=9;
					 }
					 
					echo "<div id='mapdiv' style='float:left;width:78%;'>";
					//Beginn der Karteneinbindung
					echo "<noscript>
						  <p>JavaScript ist in deinem Browser leider nicht aktiviert.<br/><br/>Das Einbinden der Karte ist so leider nicht möglich.</p>
						  </noscript>";
					echo "<script type='text/javascript' src='http://www.openlayers.org/api/OpenLayers.js'></script>\n";
					echo "<script type='text/javascript'>\n";
							echo "map = new OpenLayers.Map('mapdiv');\n";
							echo "map.addLayer(new OpenLayers.Layer.OSM());\n";
							echo "var pois = new OpenLayers.Layer.Text( 'Rhein-Neckar Region',
											{ location:'/docs/maps/locations.txt',
											  projection: map.displayProjection
											});\n";
							echo "map.addLayer(pois);\n";
						echo "var lonLat = new OpenLayers.LonLat($this->lon, $this->lat)\n";
						echo ".transform(\n";
						echo "new OpenLayers.Projection('EPSG:4326'),\n";
						echo "map.getProjectionObject()\n";
						echo ");\n";
						echo "var zoom=$zoom;\n";
						echo "map.setCenter (lonLat, zoom);  \n";
						echo "</script>\n";
					//Ende der Karteneinbindung
				echo "</div>";

//
//

    }
    /**
     * Zeigt die Vereine an
     */
    function showEinzelVerein($vereinsnummer=false) { 
				echo "<div class='beitrag'>";
					echo "<h2>" . $this->name . "</h2>";
						if($this->logo) echo "<img style='margin:0;padding:0;display:inline;float:right;' src='../images/vereine/" . $this->logo . "' alt='Logo " . $this->name . "' align='right' height='100' />";
					echo"<p style='border-bottom:dotted 1px #039;'>";
						if($edit) echo "aktiv: " . $this->aktiv . " (1=ja, 0=nein) <br/>";
						if($this->vereinsnummer) echo "VereinsNr.: " . $this->vereinsnummer . "<br/>";
						if($this->kontakt) echo "Kontakt: " . $this->kontakt . "<br/>";
						if($this->spielort) echo "Spielort: <a href='?site=karte&amp;vereinsnummer=" . $this->vereinsnummer . "'>" . $this->spielort . "</a><br/>";
						if($this->spielzeiten) echo "Spielzeiten: " .$this->spielzeiten . "<br/>";
						if($this->anzahlMitglieder) echo "Mitgliederzahl: " . $this->anzahlMitglieder . "<br/>";
						if($this->jahresbeitrag) echo "Jahresbeitrag: " . $this->jahresbeitrag . "<br/>";
						if($this->anzahlUebungsleiter) echo "Übungsleiter: " . $this->anzahlUebungsleiter . "<br/>";
						if($this->anzahlSchiedsrichter) echo "Schiedsrichter: " . $this->anzahlSchiedsrichter . "<br/>";
						if($this->email) echo "email: <a href='mailto:" . $this->email . "'>" . $this->email . "</a><br/>";
						if ($this->website) echo "Homepage: <a target='_blank' href='" . $this->website . "'>" . $this->website . "</a><br/>";
						if ($this->telefon) echo "Telefon: " . $this->telefon . "<br/>";
					echo "</p>
					</div>";
				echo "<br style='clear:both'>";
    }
    /**
     * Zeigt die Vereine an
     */ 
    function showVereinsliste($vereinsnummer=false) { 
			 echo "<div id='linkliste' style='padding:3px;float:left;margin-left:4px;width:17%;white-space:nowrap;overflow:hidden;border:1px dotted #633;'>";
			$sql = "SELECT * FROM tblVereine  WHERE aktiv=1 ORDER BY vereinsnummer";
        $dbh = clsDb::connect();
        foreach ($dbh->query($sql) as $row) { 
				if ($this->vereinsnummer!==$row["vereinsnummer"])
					echo "<a style='font-size:small;display:block;background-color:#fff;'title='".$row["name"]."' href='?site=karte&amp;vereinsnummer=".$row["vereinsnummer"]."'>".$row["name"]."</a>";
				else
					echo "<a style='font-size:small;display:block;background-color:#ccc;'title='".$row["name"]."' href='?site=karte&amp;vereinsnummer=".$row["vereinsnummer"]."'>".$row["name"]."</a>";
        }
		echo "</div>";
        $dbh = NULL;
        
    }   
    /**
     * Zeigt die Vereine an
     */
    function showVereinsFeed($vereinsnummer=false) { 
			if (isset($_GET["vereinsnummer"])) {
			{$vereinsnummer=$_GET["vereinsnummer"];}
			}
			else {$vereinsnummer='';}
		
		$sql = "SELECT feed FROM tblvereine WHERE vereinsnummer=$vereinsnummer";
        $dbh = clsDb::connect();
        foreach ($dbh->query($sql) as $row) { 
						if ($row["feed"]){ 
							$xml_file = simplexml_load_file($row["feed"]);
							$result = $xml_file->xpath("channel/item");
							foreach($result as $wert){
							  echo "<div class='beitrag'>";
							  $anker=explode("#",$wert->link);
							  echo '<span class="small"><a name="'.$anker[1].'"></a>'.$wert->author.', '.date("d.M.Y",strtotime($wert->pubDate)).' </span>';
							  if(isset($wert->enclosure)){
							  echo '<img src="'.$wert->enclosure[url].'" class="inlineright" alt="'.$wert->title.'" style="margin-left:15px;border:none;" />';
							  }
							  echo '<h3>'.$wert->title.'</h3>';
							  echo $wert->description;
							  echo '</div>';  
							  }

						}
        }
        $dbh = NULL;
        
    }
}

?>
