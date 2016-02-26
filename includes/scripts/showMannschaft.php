
<?php
$mannschaft = $_GET['mannschaft'];
$getLiga = $_GET['liga'];
include('../jahreswechsler.php');
//ergebnisfile einlesen
//$xml = simplexml_load_file("http://www.rhein-neckar-liga.de/ligaweb/docs/2012_Rhein-Neckar-Liga_".ucfirst($getLiga).".xml");
// $xml_file = simplexml_load_file("http://localhost/rhein-neckar-liga.de/ligaweb/docs/".$getJahr."_Rhein-Neckar-Liga_".ucfirst($getLiga).".xml");
// $xml_file = simplexml_load_file("http://localhost/rhein-neckar-liga.de/ligaweb/docs/2013_Rhein-Neckar-Liga_".ucfirst($getLiga).".xml");
$xml = simplexml_load_file("http://liga-net.de/xml/".$getJahr."_Rhein-Neckar-Liga_".ucfirst($getLiga).".xml");
$result = $xml->xpath("//mannschaften/mannschaft[@kuerzel='" . $mannschaft . "']");
echo "<div id='tooltip' class='".strtolower($getLiga)."'>";
echo "<img src='" . $result[0]["logo"][0] . "' height='100' />";
echo "<h2>" . $result[0]["name"][0] . "</h2>";
$spieler = $result[0]->xpath("spieler");
echo "<table class='mannschaft'>";
    echo "<tr><td>LizNr.</td>
			  <td>Name</td>
			  <td>Status</td></tr>";

foreach ($spieler as $value) {
    echo "<tr><td>" . $value["lizenz"][0] . "</td>
			  <td>" . $value["name"][0] . "</td>
			  <td>" . $value["status"][0] . "</td></tr>";
}
echo "</table>";
echo "</div>";
?>

