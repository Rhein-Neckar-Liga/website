<?php

include_once 'clsDb.php';

/**
 * Description of clsSite
 *
 * @author alfredo
 */
class clsSite {

    /**
     *
     * @param int $category optional Übergibt die Kategorie
     */
    function showNews($category="", $edit=false){
        $dbh = clsDb::connect();
		if($edit){
			$sql="SELECT * FROM viewNews WHERE date > '".date("Y-m-d", strtotime("-6 month"))."' ORDER BY freigabe, date DESC";
		}else{
        if (strlen($category) < 2) {
            $sql="SELECT * FROM viewNews WHERE freigabe=1 AND date > '".date("Y-m-d", strtotime("-12 month"))."' ORDER BY date DESC";
        } else {
            $sql="SELECT * FROM viewNews WHERE freigabe=1 AND css='".$category."' AND date > '".date("Y-m-d", strtotime("-12 month"))."'  ORDER BY date DESC";
        }
		}
		if($edit){
			echo "<img alt='Veröffentlichen' class='button' src='../verwaltung/images/icons/publish.png' /> = Veröffentlichen ";
			echo "<img alt='Sperren' class='button' src='../verwaltung/images/icons/stop.png' /> = Sperren ";
			echo "<img alt='Löschen' class='button' src='../verwaltung/images/icons/delete.png' /> = Löschen (Unwiederruflich!) ";
			echo "<img alt='Editieren' class='button' src='../verwaltung/images/icons/edit.png' /> = Ändern ";
		}
        foreach ($dbh->query($sql) as $row)
        {
          echo "<div class='beitrag ".$row["css"]."'>";
		  if($edit){
		  echo "<a title='Editieren' href='?site=news&amp;id=".$row["idNewsItems"]."&amp;edit=1#rnl_".$row["date"]."_".$row["idNewsItems"]."'><img alt='Editieren' class='button' src='../verwaltung/images/icons/edit.png' /></a>";
		  if ($row["freigabe"]==1) {
		  echo "<a title='Sperren' href='?site=news&amp;id=".$row["idNewsItems"]."&amp;freigabe=0#rnl_".$row["date"]."_".$row["idNewsItems"]."'><img alt='Sperren' class='button' src='../verwaltung/images/icons/stop.png' /></a>";
		  }
          else {
			echo "<a title='Veröffentlichen' href='?site=news&amp;id=".$row["idNewsItems"]."&amp;freigabe=1#rnl_".$row["date"]."_".$row["idNewsItems"]."'><img alt='Veröfentlichen' class='button' src='../verwaltung/images/icons/publish.png' /></a>";
			echo "<a title='Löschen' href='?site=news&amp;id=".$row["idNewsItems"]."&amp;delete=1'><img alt='Löschen' class='button' src='../verwaltung/images/icons/delete.png' /></a>";
		  }
		  echo "<a id='rnl_".$row["date"]."_".$row["idNewsItems"]."'></a>";
		  echo "<br /><br />";
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
			echo "<p><a href='?site=vereine&amp;action=insert'>Neuen Eintrag erstellen</a></p>";
		}
        $dbh = clsDb::connect();
        $sql = "SELECT * FROM tblVereine ORDER BY name";
        foreach ($dbh->query($sql) as $row) { 
			echo "<div class='beitrag'>";
			if($edit){
				echo "<p>";
				echo "<a title='Editieren' href='?site=vereine&amp;id=".$row["idVereine"]."&amp;action=edit'><img alt='Editieren' class='button' src='../verwaltung/images/icons/edit.png' /></a>";
			echo "<a title='Löschen' href='?site=vereine&amp;id=".$row["idVereine"]."&amp;action=delete'><img alt='delete' class='button' src='../verwaltung/images/icons/stop.png' /></a>";
			echo "</p>";
			}
				echo "<h2>" . $row["name"] . "</h2>";
					if($row["logo"]) echo "<img style='margin:0;padding:0;display:inline;float:right;' src='../images/vereine/" . $row["logo"] . "' alt='Logo " . $row["name"] . "' align='right' height='100' />";
				echo"<p style='border-bottom:dotted 1px #039;'>";
					if($row["vereinsnummer"]) echo "VereinsNr.: " . $row["vereinsnummer"] . "<br/>";
					if($row["kontakt"]) echo "Kontakt: " . $row["kontakt"] . "<br/>";
					if($row["spielort"]) echo "Spielort: <a href='" . $row["position"] . "'>" . $row["spielort"] . "</a><br/>";
					if($row["spielzeiten"]) echo "Spielzeiten: " .$row["spielzeiten"];
					if($row["anzahlMitglieder"]) echo "Mitgliederzahl: " . $row["anzahlMitglieder"] . "<br/>";
					if($row["jahresbeitrag"]) echo "Jahresbeitrag: " . $row["jahresbeitrag"] . "<br/>";
					if($row["anzahlUebungsleiter"]) echo "Übungsleiter: " . $row["anzahlUebungsleiter"] ;
					if($row["anzahlSchiedsrichter"]) echo ", Schiedsrichter: " . $row["anzahlSchiedsrichter"] . "<br/>";
					if($row["email"]) echo "email: <a href='mailto:" . $row["email"] . "'>" . $row["email"] . "</a><br/>";
					if ($row["website"]) echo "Homepage: <a target='_blank' href='" . $row["website"] . "'>" . $row["website"] . "</a><br/>";
					if ($row["telefon"]) echo "Telefon: " . $row["telefon"] . "<br/>";
					if ($row["kuerzel"]) echo "<a target='_blank' href='../dokus/2011/Spielplan_" . $row["kuerzel"] . ".pdf'>&raquo;&raquo; Spielplanübersicht 2011 für " . $row["name"] . ".</a>";
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
				echo "<a title='Editieren' href='?site=vereine&amp;id=".$row["idVereine"]."&amp;action=edit'><img alt='Editieren' class='button' src='../verwaltung/images/icons/edit.png' /></a>";
			echo "<a title='Löschen' href='?site=vereine&amp;id=".$row["idVereine"]."&amp;action=delete'><img alt='delete' class='button' src='../verwaltung/images/icons/stop.png' /></a>";
			echo "</p>";
			}
				echo "<h2>" . $row["name"] . "</h2>";
					if($row["logo"]) echo "<img style='margin:0;padding:0;display:inline;float:right;' src='../images/vereine/" . $row["logo"] . "' alt='Logo " . $row["name"] . "' align='right' height='100' />";
				echo"<p style='border-bottom:dotted 1px #039;'>";
					if($row["vereinsnummer"]) echo "VereinsNr.: " . $row["vereinsnummer"] . "<br/>";
					if($row["kontakt"]) echo "Kontakt: " . $row["kontakt"] . "<br/>";
					if($row["spielort"]) echo "Spielort: <a href='" . $row["position"] . "'>" . $row["spielort"] . "</a><br/>";
					if($row["spielzeiten"]) echo "Spielzeiten: " .$row["spielzeiten"];
					if($row["anzahlMitglieder"]) echo "Mitgliederzahl: " . $row["anzahlMitglieder"] . "<br/>";
					if($row["jahresbeitrag"]) echo "Jahresbeitrag: " . $row["jahresbeitrag"] . "<br/>";
					if($row["anzahlUebungsleiter"]) echo "Übungsleiter: " . $row["anzahlUebungsleiter"] ;
					if($row["anzahlSchiedsrichter"]) echo ", Schiedsrichter: " . $row["anzahlSchiedsrichter"] . "<br/>";
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
    function showTurniere() {
        $dbh = clsDb::connect();
        $sql = "SELECT * FROM viewTurniere ORDER BY datum";
        echo "<div class='beitrag'>
			<table summary='Turniere der Rhein-Neckar-Region' style='width:99%;'>
                <tr>
                    <th>Datum<br />Beginn</th>
                    <th>Einschreibung</th>
                    <th>Turniername / Einladung<br />Formation / Modus / Ergebnisse</th>
                    <th>Veranstalter<br />Kontakt / Mail</th>
                </tr>";

        foreach ($dbh->query($sql) as $row) {
            if (strtotime($row["datum"]) < strtotime("-1 days")
                )continue; //Wenn der Eintrag mehr als 1 Tag in der Vergangenheit liegt, wird der Rest übersprungen
			echo "<tr>";
            echo "<td>" . date("d.m.Y", strtotime($row["datum"])) . "<br />" . date("H:i", strtotime($row["zeit"])) . " Uhr</td>";
            echo "<td>";
            if (isset($row["einschreibung"])) {
            echo "<b>".date("H:i", strtotime($row["einschreibung"])) . " Uhr</b>";
            }
            else {
            echo date("H:i", strtotime($row["zeit"])) . " Uhr";
            }

            echo    "</td>";
            $strPdf = "";
            if (isset($row["einladung"])) {
                $strPdf = "<a target='_blank' href='" . $row["einladung"] . "'><img alt='Einladung' src='../images/pdf.gif' border='0' align='right' /></a>";
            }
            echo "<td>" . $row["name"] . $strPdf . "<br />" . $row["modus"] . "</td>";
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
     *
     * @param bool $active optional Wahl ob aktuelle oder auch alte Dokumente angezeigt werden sollen (1 aktuelle 0 alle)
     */
    function showDokumente($active="1") {
        $dbh = clsDb::connect();
        if ($active==1) {
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
                    <td>".$row["name"]."</td>
                    <td><a href='".$row["link"]."'><img alt='' style='margin:0;' src='../images/".$row["imageType"]."' /></a></td>
                    <td>vom ".  date("d.m.Y",  strtotime($row["datum"]))."</td>
                    </tr>";
        }
        //letzte Tabelle schließen
        echo "</table>";
		echo "</div>";
        $dbh = NULL;
    }
    
}

?>
