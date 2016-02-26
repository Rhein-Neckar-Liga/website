<?php 
class clsMain {
Public $Ligen2;
  function __construct() 
  {
  //innerhalb von Klassen kann über $this->xyz darauf zugegriffen werden
  $this->Ligen2 = array
	(
		"2016"=>array("oberliga","landesliga","bezirksliga","kreisliga-A","kreisliga-B"),
		"2015"=>array("oberliga","landesliga","bezirksliga","kreisliga"),
		"2014"=>array("oberliga","landesliga","bezirksliga","kreisliga"),
		"2013"=>array("oberliga","landesliga","bezirksliga","kreisliga"),
		"2012"=>array("oberliga","landesliga","bezirksliga","kreisliga"),
		"2011"=>array("oberliga","landesliga","bezirksliga","kreisliga")
	);

  }
  function showDocType() 
  {
    echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>\n";
  }
  function includeScripts()
  {
    echo "
        <!--show-hide für Facebook Like box-->
        <script type='text/javascript' language='JavaScript1.2' src='java/show-hide.js'></script>
        <!--Ende show-hide für Facebook Like box-->
        <!--Greybox-->
        <script type='text/javascript'>var GB_ROOT_DIR = 'java/greybox/';</script>
        <script type='text/javascript' src='java/greybox/AJS.js'></script>
        <script type='text/javascript' src='java/greybox/AJS_fx.js'></script>
        <script type='text/javascript' src='java/greybox/gb_scripts.js'></script>
        <link href='java/greybox/gb_styles.css' rel='stylesheet' type='text/css' media='all' />
        <!--Ende Greybox-->
        <script type='text/javascript' src='includes/jquery/jquery-1.5.min.js'></script>
         <!--<script type='text/javascript' src='includes/jquery/jquery-1.11.min.js'></script>-->
        <script type='text/javascript' src='includes/jquery/jquery.qtip-1.0.0-rc3.min.js'></script>
        <script type='text/javascript' src='java/harmonica.js'></script>
        
        <script type='text/javascript' src='java/showMannschaft.js'></script>
        <script type='text/javascript' src='java/showSpieler.js'></script>
	";
  }
  function showHeader()
  {
    echo '
	            <div id="header" style="text-align:center;">
                <ul id="navigation">
                    <li><a href="?site=start">Start</a></li>
                    <li><a href="?site=vereine">Vereine</a></li>
                    <li><a href="?site=ligaleitung">Ligaleitung</a></li>
                    <li><a href="?site=turniere">Turniere</a></li>
                    <li><a href="?site=spielplan">Spielplan</a></li>
                    <li><a href="?site=dokumente">Dokumente</a></li>
                    <li><a href="?site=bilder">Bilder</a></li>
                </ul>
                <div id="rechts">
                    <div class="box">
                        <ul class="ligennavi">
                            <li class="bundesliga"><a href="http://www.deutsche-petanque-bundesliga.de/index.php?id=34">Bundesliga</a></li>
                            <li class="bawueliga"><a href="http://www.petanque-bw.de/index.php?id=53">BaWü-Liga</a></li>
                            <li class="regionalliga"><a href="http://www.petanque-bw.de/index.php?id=866">Regionalliga</a></li>
                        </ul>
                    </div>
                    <div class="box">
                        <ul class="ligennavi">
                            <li class="oberliga"><a href="?site=liga&amp;liga=oberliga">Oberliga</a></li>
                            <li class="landesliga"><a href="?site=liga&amp;liga=landesliga">Landesliga</a></li>
                            <li class="bezirksliga"><a href="?site=liga&amp;liga=bezirksliga">Bezirksliga</a></li>
                            <li class="kreisliga"><a href="?site=liga&amp;liga=kreisliga">Kreisliga</a></li>
                            <li class="jugendliga"><a href="?liga=jugendliga">Jugendliga</a></li>
                        </ul>
                    </div>
				</div><!--rechts-->
			</div><!--header-->
			<div id="wrapper" class="clearfix" > </div>
			<div id="maincol" style="overflow:hidden;" > 
				<div style="margin-top:160px;">&nbsp;</div>
	';
  }
    function showFooter()
  {
    echo "
                <div id='footer' > <div class='inhalt'><span style=' float: right;'><a href='?site=impressum'>Impressum</a> </span><a href='http://www.rhein-neckar-liga.de/index.htm'>Archiv</a><p style='text-align:center;margin: -1.2em 0 0 0;padding:0;'>Offizielle Seite der Rhein-Neckar-Liga</p></div></div>
	";
  }
function showLigenmenu($getLiga,$link,$getSpieltag=0,$maxSpieltag=0) {
	include('includes/jahreswechsler.php');
    //
//DEBUG Ligen xml einlesen  BAUSTELLE
 //schlechter Ort nochdazu muss in clsMain
 libxml_use_internal_errors(true);
$xml_file_Ligen ="";
if ($getJahr>2010)  
{
	// $xml_file_Ligen = simplexml_load_file("http://liga-net.de/ligasaison/leagues/saison/". $getJahr ."/region/RNL/xml");
	$xml_file_Ligen = simplexml_load_file("http://localhost/rhein-neckar-liga.de/xml/". $getJahr ."RNL.xml");

if ($xml_file_Ligen) 
	{
	 $alleLigen = $xml_file_Ligen->xpath("liga");
	// echo "<hr/>";
     foreach ($alleLigen as $Einzelliga) {
         foreach ($Einzelliga[0]->attributes() as $wert => $value) //durch jede Liga durch und Informationen holen
			{
			//$name  $farbeTabellenKopf  $farbeTabellenKopfSchrift  $farbeUeberschriftHintergrund  §farbeUeberschrift
               if ($wert=='name') 
				{ //wenn es der Ligenname ist, Array Ligen füllen
					$this->Ligen2[$getJahr]=$value;    
				}
			}
		}
	}
}
//DEBUG Ligen xml einlesen  #Ende

	//
    echo "
            <div id='content'>
            <div class='beitrag $getLiga'>";
// echo $link;
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
                <li><a  href='?liga=rnl&amp;jahr=$getJahr' >RNL allgemein</a></li>";
				//DEBUG Hier brauchen wir eine Schleife durch die Ligen des jeweiligen Jahres
		       for ($index = 0; $index < count($this->Ligen2[$getJahr]); $index++) 
		       // for ($index = 0; $index < count($this->Ligen); $index++) 
				{				//substr('abcdef', 1, 3);
						//mit den geteilten Staffeln nach - suchen und String bis dort als Klasse verwenden
					 $Klasse=strtolower($this->Ligen2[$getJahr][$index]);
					 // $Klasse=strtolower($this->Ligen[$index]);
					 if (!$Klasse) {$Klasse=strtolower($this->Ligen2[$getJahr][$index]);}
					 // if (!$Klasse) {$Klasse=strtolower($Ligen[$index]);}
					echo "<li class='".$Klasse."'><a  href='?site=liga&amp;spieltag=news&amp;liga=".$this->Ligen2[$getJahr][$index]."&amp;jahr=$getJahr' >".ucfirst($this->Ligen2[$getJahr][$index])."</a></li>";
					// echo "<li class='".$Klasse."'><a  href='?site=liga&amp;spieltag=news&amp;liga=".$this->Ligen[$index]."&amp;jahr=$getJahr' >".ucfirst($this->Ligen[$index])."</a></li>";
				}
				//DEBUG Ende Schleife durch die Ligen des jeweiligen Jahres
				// echo "
                // <li class='oberliga'><a  href='?site=liga&amp;spieltag=news&amp;liga=oberliga&amp;jahr=$getJahr' >Oberliga</a></li>
                // <li class='landesliga' ><a href='?site=liga&amp;spieltag=news&amp;liga=landesliga&amp;jahr=$getJahr'>Landesliga</a></li>
                // <li class='bezirksliga' ><a href='?site=liga&amp;spieltag=news&amp;liga=bezirksliga&amp;jahr=$getJahr'>Bezirksliga</a></li>
                // <li class='kreisliga'><a href='?site=liga&amp;spieltag=news&amp;liga=kreisliga&amp;jahr=$getJahr'>Kreisliga</a></li>
				// ";
				
           echo "<li class='jugendliga'><a href='?liga=Jugendliga&amp;jahr=$getJahr'>Jugendliga</a></li>
                <li class='rnl-pokal'><a href='?liga=rnl-pokal&amp;jahr=$getJahr'>RNL-Pokal</a></li></ul>
            </div>
    ";
    //ausgabe nur beim druck , über css geregelt
    // echo "<div id='timestamp'>" . date('m.d.Y  H:i:s') . $_SERVER['HTTP_REFERER'] . "</div>";
	if ($getLiga){
    echo
    "<div class='beitrag $getLiga hide'>
		<ul class='ligennavi'>
			<li class='".strtolower($getLiga)."'><a href='?site=liga&amp;liga=$getLiga&amp;spieltag=news&amp;jahr=$getJahr'>Nachrichten</a></li>
			<li class='".strtolower($getLiga)."'><a href='?site=liga&amp;liga=$getLiga&amp;jahr=$getJahr'>Alle Spieltage</a></li>
        ";
		$aktSpieltag=1;
		while($aktSpieltag <= $maxSpieltag)
		{
			echo "
				<li class='".strtolower($getLiga)."'><a href='?site=liga&amp;liga=$getLiga&amp;spieltag=$aktSpieltag&amp;jahr=$getJahr'>$aktSpieltag. Spieltag</a></li>";
				$aktSpieltag++;
		}
	}
	echo "</ul></div>";
 }

  }


?>