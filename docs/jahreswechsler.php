<?php
$timestamp = time();
$aktJahr=date("Y",$timestamp);
$temp="2009"; //da haben wir angefangen
$Jahre=array();
while($temp <= $aktJahr)
{
  $Jahre[] = $temp;
  $temp++;
}
$getJahr=($_GET["jahr"]);
	if (in_array($getJahr,$Jahre)==FALSE)
		{
		$getJahr=$aktJahr;
		}
//##########
rsort($Jahre);
?>