<?php
include_once 'clsDb.php';

/**
 * Description of clsNews
 *
 * @author alfredo
 */
class clsNews {
    function showNews($category="landesliga", $getJahr, $aktJahr){
        $dbh = clsDb::connect();
		$nextJahr=$getJahr+1;
        if (strlen($category) < 2) {
			if ($getJahr==$aktJahr) {

            $sql="SELECT * FROM viewNewsDani WHERE date > '".date("Y-m-d", strtotime("-12 month"))."' ORDER BY date DESC, idNewsItems DESC";
			}
			else {

            $sql="SELECT * FROM viewNewsDani WHERE date >= '".$getJahr."' AND date <= '".$nextJahr."' ORDER BY date DESC, idNewsItems DESC";
			}
			
        } else {
            $sql="SELECT * FROM viewNewsDani WHERE css='".$category."' ORDER BY date DESC, idNewsItems DESC";
        }
        foreach ($dbh->query($sql) as $row)
        {
          echo "<div class='beitrag ".$row["css"]."'><a id='rnl_".$row["date"]."_".$row["idNewsItems"]."'></a>";
			  echo "<h1><span style='font-size: .8em;font-weight: normal;float:right'>".date("d.m.Y",strtotime($row["date"]))."</span> ".$row["title"]."</h1>";
				  echo "<div class='content'>";
					echo $row["description"];
					echo "<p class='autor'>".$row["author"]." am ".date("d.m.Y",strtotime($row["date"]))."</p>";
				  echo '</div>';
          echo "</div>\n";
        }
        $dbh = NULL;
    }
}
?>
