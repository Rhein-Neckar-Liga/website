<?php
include_once '../includes/clsDb.php';
/**
 * Description of clsNewsgesperrt
 *
 * @author dani
 */
class clsNewsgesperrt {
    function showNews($category=""){
        $dbh = clsDb::connect();
		$sql="SELECT * FROM viewNewsgesperrt";
		
	
		echo "<img alt='Veröffentlichen' class='button' src='../verwaltung/images/icons/publish.png' /> = Veröffentlichen ";
		echo "<img alt='Sperren' class='button' src='../verwaltung/images/icons/stop.png' /> = Sperren ";
		echo "<img alt='Löschen' class='button' src='../verwaltung/images/icons/delete.png' /> = Löschen (Unwiederruflich!) ";
		echo "<img alt='Editieren' class='button' src='../verwaltung/images/icons/edit.png' /> = Ändern ";
		
		
        foreach ($dbh->query($sql) as $row)
        {
          echo "<div style='font-size:smaller;' class='beitrag ".$row["css"]."'>";
		  echo "<a title='Editieren' href='?id=".$row["idNewsItems"]."&amp;edit=1'><img alt='Editieren' class='button' src='../verwaltung/images/icons/edit.png' /></a>";
		  if ($row["freigabe"]==1) {
		  echo "<a title='Sperren' href='?id=".$row["idNewsItems"]."&amp;freigabe=0'><img alt='Sperren' class='button' src='../verwaltung/images/icons/stop.png' /></a>";
		  }
          else {
			echo "<a title='Veröffentlichen' href='?id=".$row["idNewsItems"]."&amp;freigabe=1'><img alt='Veröfentlichen' class='button' src='../verwaltung/images/icons/publish.png' /></a>";
			echo "<a title='Löschen' href='?id=".$row["idNewsItems"]."&amp;delete=1'><img alt='Löschen' class='button' src='../verwaltung/images/icons/delete.png' /></a>";
		  }
		  echo "<br/>";
		  echo "<br/>";
          echo "<h1>".$row["title"]."</h1>";
          //echo "<h3>".$row["title"]."</h3>";
          echo $row["description"];
          echo "<p class='autor'>".$row["author"]." am ".date("d.m.Y",strtotime($row["date"]))."</p>";
		  echo "</div>";
        }
        $dbh = NULL;
    }
}
?>
