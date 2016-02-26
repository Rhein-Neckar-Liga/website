<?php
echo '<script src="../includes/jquery/highcharts.js" type="text/javascript"></script>';
//wo sind wir?
$file = $_SERVER['SCRIPT_NAME']; //der ganze Pfad
//spieltage werden nachher aus dem xml befüllt
$spieltage = array();
// die zugelassenen Schlüssel in ein array packen
$keys = array("site","liga","jahr","spieltag");
//das Array für die Schlüsselwerte vorbereiten
$gets = array();
$link="";
$Ligen=array("oberliga","landesliga","bezirksliga","kreisliga");
//die GET Parameter auslesen, überprüfen und in ein Array packen
	 foreach($_GET as $key => $value) 
		{
			if(in_array($key,$keys)!==FALSE){
				//der key gehört zu den möglichen Paratmeterschlüsseln
					switch ($key) 
					{
					 case "liga": //überprüfen ob Liga im Array Ligen enthalten ist
						//array wird erweitert
					 	if(in_array(lcfirst($value),$Ligen)==TRUE) {
							$gets[$key]=lcfirst($value);
							$link.=$key."=".lcfirst($value)."&amp;";
							} 
					 break;
					 case "site": //wird hier nicht benötigt
							$gets[$key]=$value;
							$link.="$key=$value&amp;";
					 	break;
					 case "jahr": //Jahresprüfung einbauen
							$gets[$key]=$value;
						break;
					 case "spieltag": //wird hier nicht benötigt
							$gets[$key]=$value;
							$link.="$key=$value&amp;";
						break;
					 default: //eigentlich unnoetig, nur zur Sicherheit
					}
                   //$link.="&amp;";
				}
		}

$getLiga ="";
if (isset($_GET["liga"])) {
	$getLiga = lcfirst($_GET["liga"]);
}
	if (in_array($getLiga,$Ligen)==FALSE)
		$getLiga="";
//$Jahre = array("2011", "2012", "2013");
//Ende DEBUG statisch
$getSpieltag ="";
if (isset($_GET["spieltag"])) {
	$getSpieltag = $_GET["spieltag"];
}
$getKuerzel ="";
if (isset($_GET["kuerzel"])) {
	$getKuerzel = $_GET["kuerzel"];
}
$timestamp = time();
//$aktJahr = date("Y", $timestamp);
//if (isset($_GET["jahr"])) $getJahr = ($_GET["jahr"]);
//else $getJahr = $aktJahr;
if ($aktJahr==$getJahr) $aktuell=true;
else $aktuell=false;
//DEBUG 
if (in_array($getLiga, $Ligen) == FALSE)
    $getLiga = "oberliga";


//ergebnisfile einlesen
 libxml_use_internal_errors(true);
$xml_file ="";
if ($getJahr>2010)  $xml_file = simplexml_load_file("http://liga-net.de/xml/".$getJahr."_Rhein-Neckar-Liga_".ucfirst($getLiga).".xml");
if ($xml_file) {
	//DEBUG
	$maxSpieltag = "";
	$resultMaxSpielrunden = $xml_file->xpath("eigenschaften/liga/anzahl_spieltage");
	$maxSpieltag = $resultMaxSpielrunden[0];
		$aktSpieltag=1;
		while($aktSpieltag <= $maxSpieltag)
			{
			$spieltage[]=$aktSpieltag;
			$aktSpieltag++;
			}
	
	//DEBUG

//Attribute der Region wie Name, Logo und Farben
$resultRegion = $xml_file->xpath("eigenschaften/region");
//Jahreszahl der abgebildeten Saison
$resultSaison = $xml_file->xpath("eigenschaften/saison");
//letztes update des files
$resultUpdate = $xml_file->xpath("update");
//Attribute der Staffel wie Name und Farben, als Tag ist der Staffelleiter hinterlegt
$resultLiga = $xml_file->xpath("eigenschaften/liga");
//Name des Staffelleiters
$resultStaffelleiter = $xml_file->xpath("eigenschaften/liga/staffelleiter");
//Spielmodus (Trip1, Doub1, Doub2 etc
$resultModus = $xml_file->xpath("eigenschaften/modus/spiel");
$resultModusBeschreibung = $xml_file->xpath("eigenschaften/modus");
$modus = array();
///////////////////////////////////////////////////////////////////////////////////////////////////////
/* #######Atrribute des Modus auslesen:
  $beschreibung */
foreach ($resultModusBeschreibung[0]->attributes() as $wert => $value) {
    $$wert = $value;
}
//####### Attribute ausgelesen
/* #######Atrribute der Region auslesen:
  $name	($update)	$logo 	$farbeTabelleSchrift	$farbeTabelleHintergrund
  $farbeTabelleZeile2Schrift	$farbeTabelleZeile2Hintergrund */
foreach ($resultRegion[0]->attributes() as $wert => $value) {
    $$wert = $value;
}
//####### Attribute ausgelesen
//wir haben nur eine Saison pro xml-file daher können wir das über den index 0 ansprechen
//$saison
$saison = $resultSaison[0];
//$update
$update = substr($resultUpdate[0],8,2).".".substr($resultUpdate[0],5,2).".".substr($resultUpdate[0],0,4);
//ebenso beim Staffelleiter (falls zwei, könnten die auch in einer Zeile stehen
//$staffelleiter
$staffelleiter = $resultStaffelleiter[0];
/* #######Atrribute der Staffel auslesen:
  $farbeTabellenKopf	$farbeTabellenKopfSchrift
  $farbeUeberschriftHintergrund		$farbeUeberschrift */
foreach ($resultLiga[0]->attributes() as $wert => $value) {
    $$wert = $value;
}
//####### Attribute ausgelesen
//wir gehen durch die einzelnen modi durch und speichern sie in einem array
//$modus[]
foreach ($resultModus as $wert) {
    $modus[] = $wert;
}
if (in_array($getSpieltag, $spieltage) == FALSE) {
    $getSpieltag = 0;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////
//DEBUGDEBUG
$link="?".$link;
showLigenmenu($getLiga,$link,$getSpieltag, $maxSpieltag);
//Staffelleiter einblenden
echo "<div class='beitrag $getLiga'>Ligastaffel: ".ucfirst($getLiga)."<br/>Staffelleiter/in: $staffelleiter<br/>Modus: $beschreibung</div>";
//News abfangen
if ($getSpieltag !== 'news') {
    if ($getSpieltag == '0') {
        $resultSpielrunden = $xml_file->xpath("spielrunden/spielrunde");
    }
    else
        $resultSpielrunden = $xml_file->xpath("spielrunden/spielrunde[@spieltagnr='$getSpieltag']");
//Tabelle
//################## T A B E L L E ##################################
    $resultTabelle = $xml_file->xpath("tabelle/platz");
	//
    //wenn die Mannschaft gesetzt ist, machen wir die Tabelle schmaler, damit die Spieler/innen noch daneben passen
    foreach ($resultTabelle as $wert){
	//#######Mannschaften in array packen
	$arrkuerzel[] = $wert["kuerzel"];
	}
	
	//
    echo "<div class='beitrag $getLiga hide'>";
if ((isset($getKuerzel))and (in_array($getKuerzel,$arrkuerzel)!==FALSE) ){
	echo "<table class='rangliste' summary='$getLiga' style='isplay:inline;float:left;width:70%;background-color:$farbeTabelleHintergrund;border:1px solid $farbeTabellenKopf;'>";
}
else {
	echo "<table class='rangliste' summary='$getLiga' style='background-color:$farbeTabelleHintergrund;border:1px solid $farbeTabellenKopf;'>";
} 
	echo "<colgroup>
								<col width='3%'/>
								<col width='57%'/>
								<col width='10%'/>
								<col width='10%'/>
								<col width='10%'/>
								<col width='10%'/>
						</colgroup>";
    echo "<tr style='background-color:$farbeTabellenKopf;color:$farbeTabellenKopfSchrift;'><th colspan='6'>Aktuelle Tabelle der " .ucfirst($getLiga). " Stand: $update</th></tr>";
    echo "<tr style='background-color:$farbeTabelleZeile2Hintergrund;color:$farbeTabelleZeile2Schrift;'>
							<td>Platz</td>
							<td>Verein</td>
							<td style='text-align:center;'>Kugeln</td>
							<td style='text-align:center;'>Diff.</td>
							<td style='text-align:center;'>Spiele</td>
							<td style='text-align:center;'>Punkte</td>
							</tr>";
    foreach ($resultTabelle as $wert) {
        //#######Atrribute des Modus auslesen:
        $nummer = $wert["nummer"];
        $kuerzel = $wert["kuerzel"];
        $vereinsname = $wert["name"];
        $kugeln_eigen = $wert["kugeln_eigen"];
        $kugeln_gegner = $wert["kugeln_gegner"];
        $diff = $wert["diff"];
        $spiele_eigen = $wert["spiele_eigen"];
        $spiele_gegner = $wert["spiele_gegner"];
        $punkte_eigen = $wert["punkte_eigen"];
        $punkte_gegner = $wert["punkte_gegner"];
        //####### Attribute ausgelesen
        echo "<tr";
        if ($getKuerzel == $kuerzel
            )echo " style='background-color:#BBB;font-weight:bold;'";
        echo ">
							<td>$nummer</td>
							<td style='white-space:nowrap;'><a href='$file?site=liga&amp;liga=$getLiga&amp;kuerzel=$kuerzel&amp;spieltag=$getSpieltag&amp;jahr=$getJahr'>$vereinsname( $kuerzel)</a></td>
							<td style='white-space:nowrap;text-align:center;border-left:1px solid $farbeTabellenKopf'>$kugeln_eigen : $kugeln_gegner</td>
							<td style='white-space:nowrap;text-align:center;border-left:1px solid $farbeTabellenKopf'>$diff</td>
							<td style='white-space:nowrap;text-align:center;border-left:1px solid $farbeTabellenKopf'>$spiele_eigen : $spiele_gegner</td>
							<td style='white-space:nowrap;text-align:center;border-left:1px solid $farbeTabellenKopf'>$punkte_eigen : $punkte_gegner</td>
						</tr>";
    }
    echo "</table>";
//##################  E N D E  T A B E L L E ##################################
//Ende Tabelle

//##################  A N F A N G   M A N N S C  H A F T S S P I E L E R  ##################################
//ist die Mannschaft gesetzt? wenn ja blende die Spieler ein, die Tabelle wurde entsprechend kleiner gemacht
if ((isset($getKuerzel))and (in_array($getKuerzel,$arrkuerzel)!==FALSE) ){
	include ('showMannschaft.php');
}
	echo "</div><br style='break:all;'/>";
//##################  E N D E  M A N N S C  H A F T S S P I E L E R  ##################################

//##################  S P I E L R U N D E  ##################################
    echo "<div class='beitrag $getLiga hide'>";
    foreach ($resultSpielrunden as $wert) {
        $spielrunde = $wert["nummer"];
        $spieltag = $wert["spieltagnr"];
        $spieltagdatum = $wert["datum"];
		//2011-03-26 10:00:00
        $spieltagdatum = substr($spieltagdatum, 8, 2) . "." . substr($spieltagdatum, 5, 2) . "." . substr($spieltagdatum, 0, 4). " " .substr($spieltagdatum, 11, 5) ." Uhr";
        $spieltagort = $wert["ort"];
        $resultBegegnung = $wert->xpath("begegnungen/begegnung");
        echo "<table summary='$getLiga' style='background-color:$farbeTabelleHintergrund;'>";
        echo "<colgroup>
								<col width='5%'/>
								<col width='25%'/>
								<col width='9%'/>
								<col width='9%'/>
								<col width='9%'/>
								<col width='9%'/>
								<col width='9%'/>
								<col width='9%'/>
								<col width='9%'/>
								<col width='9%'/>
						</colgroup>";
        echo "<tr style='background-color:$farbeTabellenKopf;color:$farbeTabellenKopfSchrift;'><th colspan='10'>$spieltag.Spieltag am $spieltagdatum - Ausrichter: <em>$spieltagort</em></th></tr>";
        echo "<tr style='background-color:$farbeTabelleZeile2Hintergrund;color:$farbeTabelleZeile2Schrift;'><td>Nr.</td><td>Begegnung</td><td>$modus[0]</td><td>$modus[1]</td><td>$modus[2]</td><td>$modus[3]</td><td>$modus[4]</td><td>Kugeln</td><td>Spiele</td><td>Punkte</td></tr>";
        foreach ($resultBegegnung as $begegnung) {
            $kugelnges1 = $begegnung->kugeln["team1"];
            $kugelnges2 = $begegnung->kugeln["team2"];
            $siegeges1 = $begegnung->siege["team1"];
            $siegeges2 = $begegnung->siege["team2"];
            $punktges1 = $begegnung->punkt["team1"];
            $punktges2 = $begegnung->punkt["team2"];
            $resultSpiel = $begegnung->xpath("spiele/spiel");
            echo "<tr";
            if ($getKuerzel == $begegnung->team1 or $getKuerzel == $begegnung->team2
                )echo " style='background-color:#BBB;font-weight:bold;'";
            echo "><td>$spielrunde</td><td><span class='mannschaft'>" . $begegnung->team1 . "</span> : <span class='mannschaft'>" . $begegnung->team2 . "</span></td>";
            foreach ($resultSpiel as $spiel) {
                foreach ($spiel[0]->attributes() as $attr => $value) {
                    $$attr = $value;
                }
                echo "<td class='spiel' title='$id'>$kugeln1 : $kugeln2</td>";
            }

            echo "<td>$kugelnges1:$kugelnges2</td><td>$siegeges1:$siegeges2</td><td>$punktges1:$punktges2</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    echo "</div>";
    //echo '<div id="chart-container-1" style="width: 95%; height: 400px"></div>';
    echo '<div id="chart-container-1" style="width: 95%"></div>';
        ?>

<script type="text/javascript">
var chart;
$(document).ready(function() {
   chart = new Highcharts.Chart({
      chart: {
         renderTo: 'chart-container-1',
         defaultSeriesType: 'line',
         marginRight: 130,
         marginBottom: 40
      },
      credits: {
        enabled: false
    },
      title: {
         text: 'Saisonverlauf',
         x: -20 //center
      },
      subtitle: {
         text: 'Saison <?php echo "$getJahr";?>',
         x: -20
      },
      xAxis: {
         title: {
            text: 'Runde'
         },
         allowDecimals : false,
         categories: [
    <?php 
        $runden = $xml_file->xpath("//spielrunden/spielrunde");
        for ($index = 0; $index < count($runden); $index++) {
            echo "'".$runden[$index]["nummer"]."'";
                if($index<count($runden)-1){
                    echo ",";
                }
        }
         ?>
         ]
      },
      yAxis: {
         title: {
            text: 'Rang'
         },
         plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
         }],
         tickInterval : 1,
         reversed : true,
         min : 1,
         max: <?php
            $mannschaften = $xml_file->xpath("//mannschaften/mannschaft");
            echo count($mannschaften);
         ?>
      },
      tooltip: {
         formatter: function() {
                   return '<b>'+ this.series.name +'<\/b><br/>Runde '+
               this.x +' '+ this.y +'. Platz';
         }
      },
      legend: {
         layout: 'vertical',
         align: 'right',
         verticalAlign: 'top',
         x: 0,
         y: 100,
         borderWidth: 0
      },
      series: [ <?php
        
        for ($indexM = 0; $indexM < count($mannschaften); $indexM++) {
            $name=$mannschaften[$indexM][0]["name"][0];
            $kuerzel=$mannschaften[$indexM][0]["kuerzel"][0];
            echo "{name: '".$kuerzel."', data: [";
            $rang=$xml_file->xpath("//spielrunde/tabelle/platz[@kuerzel='$kuerzel']");
            for ($index = 0; $index < count($rang); $index++) {
                echo $rang[$index]["nummer"][0];
                if($index<count($rang)-1){
                    echo ",";
                }
            }
            echo "]}";
            if($indexM<count($mannschaften)-1){
                    echo ",";
                }
        }
      ?>]
   });
   
   
});
</script>
        <?php
//##################  S P I E L R U N D E  ##################################
} else {
    //News der Liga einblenden
	
	include "includes/clsNews.php";
	$news= new clsNews();
	$news->showNews($getLiga, $getJahr, $aktJahr);
}
}
else {
    libxml_clear_errors();
    $link="?".$link;
    showLigenmenu($getLiga,$link, $maxSpieltag);
    echo "
		<div class='beitrag $getLiga hide'>Die Daten der ".ucfirst($getLiga)." $getJahr liegen leider (noch) nicht vor oder sind im <a href='index.htm'>Archiv</a> zu finden.";
    echo "</div>";
    	include "includes/clsNews.php";
	$news= new clsNews();
	$news->showNews($getLiga, $getJahr, $aktJahr);
    }
 function showLigenmenu($getLiga,$link,$getSpieltag=0,$maxSpieltag=0) {
    include('includes/jahreswechsler.php');
    echo "
            <div id='content'>
            <div class='beitrag $getLiga hide'>";

         echo "<span class='headergrau'>"
                 .$getJahr."   ".strtoupper($getLiga);
         if ($getSpieltag>0) {
             echo " ".$getSpieltag.". Spieltag";
         }
               echo"</span>";

            echo "
                <ul class='ligennavi'>
                    <li><a class='dropdown' href='#'>$getJahr</a> ";
                    echo "<ul class='untermenu'>";
                        foreach ($Jahre as $Jahr){
                            echo "<li class='untermenu'><a href='".$link."jahr=$Jahr'>$Jahr</a> </li>";
                            }
                    echo "</ul></li>";

                echo "
                <li><a href='?liga=beitrag&amp;jahr=$getJahr'>Alle News</a></li>
                <li><a  href='?liga=rnl&amp;jahr=$getJahr' >RNL allgemein</a></li>
                <li class='oberliga'><a  href='?site=liga&amp;spieltag=news&amp;liga=oberliga&amp;jahr=$getJahr' >Oberliga</a></li>
                <li class='landesliga' ><a href='?site=liga&amp;spieltag=news&amp;liga=landesliga&amp;jahr=$getJahr'>Landesliga</a></li>
                <li class='bezirksliga' ><a href='?site=liga&amp;spieltag=news&amp;liga=bezirksliga&amp;jahr=$getJahr'>Bezirksliga</a></li>
                <li class='kreisliga'><a href='?site=liga&amp;spieltag=news&amp;liga=kreisliga&amp;jahr=$getJahr'>Kreisliga</a></li>
                <li class='jugendliga'><a href='?liga=Jugendliga&amp;jahr=$getJahr'>Jugendliga</a></li>
                <li class='rnl-pokal'><a href='?liga=rnl-pokal&amp;jahr=$getJahr'>RNL-Pokal</a></li></ul>
            </div>
    ";
    //ausgabe nur beim druck , über css geregelt
    echo "<div id='timestamp'>" . date('m.d.Y  H:i:s') . $_SERVER['HTTP_REFERER'] . "</div>";

    echo
    "<div class='beitrag $getLiga hide'>
    <ul class='ligennavi'>
        <li class='".strtolower($getLiga)."'><a href='?site=liga&amp;liga=$getLiga&amp;spieltag=news&amp;jahr=$getJahr'>Nachrichten</a></li>
        <li class='".strtolower($getLiga)."'><a href='?site=liga&amp;liga=$getLiga&amp;jahr=$getJahr'>Alle Spieltage</a></li>
        ";
		$aktSpieltag=1;
while($aktSpieltag <= $maxSpieltag)
	{
	echo "<li class='".strtolower($getLiga)."'><a href='?site=liga&amp;liga=$getLiga&amp;spieltag=$aktSpieltag&amp;jahr=$getJahr'>$aktSpieltag. Spieltag</a></li>";
		  $aktSpieltag++;
	}

    echo "</ul></div>";

 }
?>

</div>
