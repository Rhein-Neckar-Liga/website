<style type="text/css">
    table.spiel{
        font-size: small;
    }
    td.Ergebnis{
        font-size: large;
    }
</style>
<?php
$idSpiel = $_GET['idSpiel'];
$getLiga = $_GET['liga'];
include('../jahreswechsler.php');
// if(isset($_GET["jahr"])){
   // $jahr = $_GET['jahr'];  
// }else{
    // $jahr="2014";
// }

//ergebnisfile einlesen
$fileXml="http://www.liga-net.de/xml/".$jahr."_Rhein-Neckar-Liga_".ucfirst($getLiga).".xml";
$xml = simplexml_load_file($fileXml);
$result = $xml->xpath("//spielrunden/spielrunde/begegnungen/begegnung/spiele/spiel[@id='" . $idSpiel . "']");
echo "<div id='tooltip' class='" . strtolower($getLiga) . "'>";
if (($result[0]["kugeln1"][0] == 0) & ($result[0]["kugeln2"][0] == 0)) {
    echo "<p>$idSpiel: Partie steht noch aus<br/>".$fileXml."</p>";
} else {
    $spieler = $result[0]->xpath("spieler");
    foreach ($spieler as $value) {
        if ($value["team"][0] == 1) {
            $team1[] = $value;
        } else {
            $team2[] = $value;
        }
    }
    echo "<br />";
    echo '<table class="spiel"><tr><td>';
    $mannschaftKuerzel = $xml->xpath("//spielrunden/spielrunde/begegnungen/begegnung/spiele/spiel[@id='" . $idSpiel . "']/../../team1");
    $mannschaft = $xml->xpath("//mannschaften/mannschaft[@kuerzel='" . $mannschaftKuerzel[0] . "']");
    echo "<img src='" . $mannschaft[0]["logo"][0] . "' height='80' />";
    echo '</td><td></td><td>';
    $mannschaftKuerzel = $xml->xpath("//spielrunden/spielrunde/begegnungen/begegnung/spiele/spiel[@id='" . $idSpiel . "']/../../team2");
    $mannschaft = $xml->xpath("//mannschaften/mannschaft[@kuerzel='" . $mannschaftKuerzel[0] . "']");
    echo "<img src='" . $mannschaft[0]["logo"][0] . "' height='80' />";
    echo '</td></tr>
    <tr><td>';
	if(isset($team1)){
    foreach ($team1 as $value) {
        $resultSpieler = $xml->xpath("//eigenschaften/mannschaften/mannschaft/spieler[@id='" . $value["nummer"] . "']");
        if (isset($value["ausgewechselt"][0])) {
            echo "<img src='../../images/ausgewechselt.png' alt='ausgewechselt'/>";
        }
        if (isset($value["eingewechselt"][0])) {
            echo "<img src='../../images/eingewechselt.png' alt='eingewechselt' />";
        }
        echo $resultSpieler[0]["lizenz"][0] . " " . $resultSpieler[0]["name"][0] . " ";
        echo "<br />";
    }
	}
    echo '</td>
        <td class="Ergebnis">' . $result[0]["kugeln1"][0] . ':' . $result[0]["kugeln2"][0] . '</td>
        <td>';
	if(isset($team2)){
    foreach ($team2 as $value) {
        $resultSpieler = $xml->xpath("//eigenschaften/mannschaften/mannschaft/spieler[@id='" . $value["nummer"] . "']");
        if (isset($value["ausgewechselt"][0])) {
            echo "<img src='../../images/ausgewechselt.png' alt='ausgewechselt' />";
        }
        if (isset($value["eingewechselt"][0])) {
            echo "<img src='../../images/eingewechselt.png' alt='eingewechselt'/>";
        }
        echo $resultSpieler[0]["lizenz"][0] . " " . $resultSpieler[0]["name"][0] . " ";
        echo "<br />";
    }
	}
    echo '</td>
    </tr>
</table>';
}
echo "</div>";
?>

