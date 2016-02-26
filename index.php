<?php
error_reporting(0);
@include_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/slimstat/stats_include.php' );
include_once 'includes/clsMain.php';
include('includes/jahreswechsler.php');
  $main=new clsMain();
  $main->showDocType();

echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>\n";
    echo "<head>\n";
        echo "<title>P&eacute;tanque in Nordbaden - Rhein-Neckar-Liga</title>\n";
        echo "<meta http-equiv='Content-Style-Type' content='text/css' />\n";
        echo "<meta http-equiv='content-type' content='text/html;charset=utf-8' />\n";
        echo "<link rel='stylesheet' href='css/main.css' type='text/css' />\n";
        echo "<link rel='alternate' type='application/rss+xml' title='News der Rhein-Neckar-Liga' href='http://www.rhein-neckar-liga.de/xml/feed.rss' />\n";
        echo "<!--[if IE]>
         <link rel='stylesheet' href='css/main-ie.css' type='text/css' />
        <![endif]-->\n";

        $sites = array("bbpv_pokal", "turniere", "vereine", "ligaleitung", "lizenz", "bbpv_info", "dokumente", "spielplan", "bilder", "sportordnung", "liga", "impressum", "karte");
		$getsite ="";
        //gewaehlte Seite
		if (isset($_GET["site"])) {
			$getsite = $_GET["site"];
		}
        //wenn $getsite keinen der in $sites definierten Werte hat dann ist $getsite=aktuell
        if (in_array($getsite, $sites) == FALSE) {
            $getsite = "docs/aktuell";
        } 
		else {
            $getsite = "docs/". $getsite;
        }
        $getsite.=".php";

        echo '<style type="text/css"> 
            /*<![CDATA[*/  
            <!--';
            //die Stylesheets kommen sich teilweise in die Quere, daher ein paar Anpassungen 
            if (($_GET["site"] == "spielplan") == TRUE)
                echo "@import url('css/ligen.css');";

            if (($_GET["site"] == "turniere") == TRUE)
                echo "
					.beitrag table {border-collapse: collapse;}
					.beitrag th {border:1px solid #fff;background-color:#CC9999;color:white;padding:4px;}
					.beitrag td {border:1px solid #CC9999;padding:4px;}
					";

				if (($_GET["site"] == "karte") == TRUE)
                echo "#mapdiv {height: 700px;}";

            if (($_GET["site"] == "liga") == TRUE) {
                echo "@import url('css/liga.css');";
                echo ".beitrag {font-size:smaller;}.beitrag ul li{font-size:0.95em;}.beitrag h1{cursor:pointer;}";
            }
            if (($_GET["site"] == "bilder") == TRUE) {
                echo "
				img.gallerie {border:3px solid #CCC;float:left;margin:5px 0 0 5px;width:120px;}
				div.directory
				{
                background-image:url(images/alben/ordner_klein.png);
                background-repeat:no-repeat;
                margin:10px 5px;
                width:110px;
                height:100px;
                overflow:hidden;
                display:inline;float:left;
                padding:20px;
            }
            .directory a{text-decoration:none;color:#000;font-size:0.7em;}
            .directory img{margin-top:17px;border:none;}";
            }

            if (($getsite == "docs/aktuell.php" or $getsite == "docs/impressum.php") == TRUE)
                echo ".beitrag {font-size:smaller;}.beitrag ul li{font-size:0.95em;}.beitrag h1{cursor:pointer;}";

            if (($getsite == "docs/aktuell.php") == TRUE)
                echo "#content div.hide{ opacity:0.7; -moz-opacity:0.0;-webkit-opacity:0.7;}";
            echo '-->
				/*]]>*/
			</style>';
			  $main->includeScripts();
    echo "</head>\n";
    echo "<body>\n";
        echo "<div id='pagewidth' >\n";
			  $main->showHeader();
				include($getsite);
                    //wenn Seiten nur wenig Inhalt haben, ist unten ein Abstand zwischen Content und footer, daher:
				echo "<div id='platzhalter'></div>\n";
                echo "</div>\n";
			  $main->showFooter();
                echo "</div>\n";
echo "</body>
	</html>";
			?>