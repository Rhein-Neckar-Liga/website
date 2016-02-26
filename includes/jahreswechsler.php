<?php
$timestamp = time();
$aktJahr=date("Y",$timestamp);
$temp="2009"; //da haben wir angefangen
$Jahre=array();
$getJahr ="";
while($temp <= $aktJahr)
{
  $Jahre[] = $temp;
  $temp++;
}
//gewaehltes Jahr
if (isset($_GET["jahr"])) {
	$getJahr = $_GET["jahr"];
	$jahr = $_GET["jahr"];
}
	if (in_array($getJahr,$Jahre)==FALSE)
		{
		$getJahr=$aktJahr;
		$jahr=$aktJahr;
		}
//##########
rsort($Jahre);
?>