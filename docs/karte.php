            <?php
            echo "<h1 class='ueberschrift'>Spielorte der Vereine der Rhein-Neckar-Region</h1>";
            include_once "includes/clsSite.php";
            $content = new clsSite(); 
				//Einbinden der Karte 
            $content->showKarte();
            $content->showVereinsliste();
            // $content->showVereinsFeed(); 
            
			//Korrigieren der Höhe in Abhängikeit der Linkliste 
			echo "<script type='text/javascript'>
				//<![CDATA[
				new_heigth=document.getElementById('linkliste').offsetHeight+100; 
				old_heigth=document.getElementById('mapdiv').offsetHeight; 
					if (new_heigth < old_heigth) {
					document.getElementById('mapdiv').style.height=new_heigth+'px';
					document.getElementById('linkliste').style.height=new_heigth+'px';
					}
					else
					{";
					echo "
					}
					//]]>
				</script>
				";
            ?>
 