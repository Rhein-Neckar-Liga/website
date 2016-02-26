<?php
//ergebnisfile einlesen
//$xml = simplexml_load_file("http://www.rhein-neckar-liga.de/ligaweb/docs/2012_Rhein-Neckar-Liga_".ucfirst($getLiga).".xml");
$xml = simplexml_load_file("http://liga-net.de/xml/".$getJahr."_Rhein-Neckar-Liga_".ucfirst($getLiga).".xml");
$result = $xml->xpath("//mannschaften/mannschaft[@kuerzel='" . $getKuerzel . "']");
echo "<div style='display:inline;float:right;width:29%;height:18.5em;overflow-y:scroll;overflow-x:hidden;'>";
$spieler = $result[0]->xpath("spieler");
echo "<table style='font-size:0.8em;border:1px solid $farbeTabellenKopf;border-collapse:collapse;width:92%;'>";
    echo "<tr style='background-color:#ccc;color:#000;'>
		<th style='white-space:nowrap;font-size:1.4em;' colspan='2'>" . $result[0]["name"][0] . "</th><th><img src='" . $result[0]["logo"][0] . "' style='height:30px;margin:0;' /></th>
		</tr>
		";
    echo "<tr style='background-color:#ccc;color:#000;'>
			  <td>LizNr.</td>
			  <td>Name</td>
			  <td>Status</td>
			  </tr>";

foreach ($spieler as $value) {
    echo "<tr style='border:1px solid $farbeTabellenKopf;'><td>" . $value["lizenz"][0] . "</td>
			  <td style='white-space:nowrap;'>" . $value["name"][0] . "</td>
			  <td>" . substr($value["status"][0],0,1) . "</td></tr>";
}
echo "</table>";
echo "</div><br style='clear:both;' />";
?>

