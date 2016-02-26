<?php
include_once '../includes/clsDb.php';

/**
 * Description of clsNews
 *
 * @author alfredo
 */
class clsNews {
    function showNews($category="", $edit=false){
        $dbh = clsDb::connect();
		if($edit){
			$sql="SELECT * FROM viewNews WHERE date > '".date("Y-m-d", strtotime("-6 month"))."' ORDER BY freigabe, date DESC";
		}else{
        if (strlen($category) < 2) {
            $sql="SELECT * FROM viewNews WHERE freigabe=1 AND date > '".date("Y-m-d", strtotime("-6 month"))."' ORDER BY date DESC";
        } else {
            $sql="SELECT * FROM viewNews WHERE freigabe=1 AND css='".$category."' AND date > '".date("Y-m-d", strtotime("-12 month"))."'  ORDER BY date DESC";
        }
		}
		if($edit){
			echo "<img alt='Veröffentlichen' class='button' src='../verwaltung/images/icons/publish.png' /> = Veröffentlichen ";
			echo "<img alt='Sperren' class='button' src='../verwaltung/images/icons/stop.png' /> = Sperren ";
			echo "<img alt='Löschen' class='button' src='../verwaltung/images/icons/delete.png' /> = Löschen (Unwiederruflich!) ";
			echo "<img alt='Editieren' class='button' src='../verwaltung/images/icons/edit.png' /> = Ändern ";
		}
        foreach ($dbh->query($sql) as $row)
        {
          echo "<div class='beitrag ".$row["css"]."'>";
		  if($edit){
		  echo "<a title='Editieren' href='?site=news&amp;id=".$row["idNewsItems"]."&amp;edit=1'><img alt='Editieren' class='button' src='../verwaltung/images/icons/edit.png' /></a>";
		  if ($row["freigabe"]==1) {
		  echo "<a title='Sperren' href='?site=news&amp;id=".$row["idNewsItems"]."&amp;freigabe=0'><img alt='Sperren' class='button' src='../verwaltung/images/icons/stop.png' /></a>";
		  }
          else {
			echo "<a title='Veröffentlichen' href='?site=news&amp;id=".$row["idNewsItems"]."&amp;freigabe=1'><img alt='Veröfentlichen' class='button' src='../verwaltung/images/icons/publish.png' /></a>";
			echo "<a title='Löschen' href='?site=news&amp;id=".$row["idNewsItems"]."&amp;delete=1'><img alt='Löschen' class='button' src='../verwaltung/images/icons/delete.png' /></a>";
		  }
		  echo "<br /><br />";
		  }
          echo "<h1>".$row["title"]."</h1>";
          echo $row["description"];
          echo "<p class='autor'>".$row["author"]." am ".date("d.m.Y",strtotime($row["date"]))."</p>";
          echo '</div>';
        }
        $dbh = NULL;
    }
}
?>
