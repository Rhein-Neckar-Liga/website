<?php
//##########
// die zugelassenen Schlüssel in ein array packen
$keys = array("site","liga","jahr","spieltag",);
//das Array für die Schlüsselwerte vorbereiten
$gets = array();
$link="";
// $Ligen=array("oberliga","landesliga","bezirksliga","kreisliga", "jugendliga", "rnl", "ligaleitung", "rnl-pokal");
//DEBUG hier zweidimensionales Array Ligen / Jahr !!!
//einlesen über Datei
// - die im admin Bereich editiert werden kann
// - oder die vom Liganet als xml erzeugt wird
		       for ($index = 0; $index < count($main->Ligen2[$getJahr]); $index++) 
				{
					//echo "<li class='$main->Ligen2[$getJahr][$index]'><a  href='?site=liga&amp;spieltag=news&amp;liga=$main->Ligen2[$getJahr][$index]&amp;jahr=$getJahr' >$main->Ligen2[$getJahr][$index]</a></li>";
					$Ligen[] = $main->Ligen2[$getJahr][$index];
					// echo $Ligen2[$getJahr][$index];
				}
//die GET Parameter auslesen, überprüfen und in ein Array packen
	 foreach($_GET as $key => $value) 
		{
			if(in_array($key,$keys)!==FALSE){
				//der key gehört zu den möglichen Paratmeterschlüsseln
					switch ($key) 
					{
					 case "liga": //überprüfen ob Liga im Array Ligen enthalten ist
						//array wird erweitert
					 	if(in_array($value,$Ligen)==TRUE) {
							$gets[$key]=$value;
							$link.="$key=$value&amp;";
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
        //gewaehlte Liga
	if (isset($_GET["liga"])) {
		$getLiga = $_GET["liga"];
	}
	if (in_array($getLiga,$Ligen)==FALSE)
    {$getLiga="";$anzeige="Alle News";}
    else {
        $anzeige=strtoupper($getLiga);
    }
//##########
//include('includes/jahreswechsler.php');
$link="?".$link;
$main->showLigenmenu($getLiga,$link);
// echo 
// "
        // <div id='content'>
		// <div class='beitrag'>";

     // echo "<span class='headergrau'>"
             // .$getJahr."   ".$anzeige."
           // </span>";

// echo "			<ul class='ligennavi'>
				// <li><a class='dropdown' href='#'>$getJahr</a> ";
				// echo "<ul class='untermenu'>";
					// foreach ($Jahre as $Jahr){
						// echo "<li class='untermenu'><a href='".$link."jahr=$Jahr'>$Jahr</a> </li>";
						// }
				// echo "</ul></li>";
			
			// echo "
				// <li><a href='?liga=beitrag&amp;jahr=$getJahr'>Alle News</a></li>
				// <li><a  href='?liga=rnl&amp;jahr=$getJahr' >RNL allgemein</a></li>
				// <li class='oberliga'><a  href='?site=liga&amp;spieltag=news&amp;liga=oberliga&amp;jahr=$getJahr' >Oberliga</a></li>
				// <li class='landesliga' ><a href='?site=liga&amp;spieltag=news&amp;liga=landesliga&amp;jahr=$getJahr'>Landesliga</a></li>
				// <li class='bezirksliga' ><a href='?site=liga&amp;spieltag=news&amp;liga=bezirksliga&amp;jahr=$getJahr'>Bezirksliga</a></li>
				// <li class='kreisliga'><a href='?site=liga&amp;spieltag=news&amp;liga=kreisliga&amp;jahr=$getJahr'>Kreisliga</a></li>
				// <li class='jugendliga'><a href='?liga=jugendliga&amp;jahr=$getJahr'>Jugendliga</a></li>";
			// if ($getLiga=="jugendliga") {
			// echo "<li class='jugendliga'><a href='../docs/Ehrenkodex.pdf'>Ehrenkodex Jugend</a></li>";
			// echo "<li class='jugendliga'><a href='#'>Ehrler &amp; Wöppel</a></li>";
			// }
			// echo "
                // <li class='rnl-pokal'><a href='?liga=rnl-pokal&amp;jahr=$getJahr'>RNL-Pokal</a></li>
			// </ul>
		// </div>
// ";
?>
<?php
include "includes/clsNews.php";
$news= new clsNews();
$news->showNews($getLiga, $getJahr, $aktJahr);
echo "</div>";
?>
