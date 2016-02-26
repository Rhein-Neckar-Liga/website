<?php
@include_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/slimstat/stats_include.php' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		    <link rel="stylesheet" href="../css/main.css" type="text/css" />
        <title>Verwaltung</title>
<style type="text/css">
/*<![CDATA[*/
<!--
<?php
            if (($_GET["site"] == "spielplan") == TRUE)
                {echo "@import url('../css/ligen.css');\n";}
            if (($_GET["site"] == "turniere") == TRUE){
				echo ".beitrag th {background-color: #CC9999;\ncolor: white;}\n
					.beitrag td {border-bottom: 1px solid #CC9999;}\n";}
			echo ".beitrag img.button {float:left;margin:0;}\n";
?>
-->
/*]]>*/
</style>
		<script type="text/javascript" src="../includes/tinymce/tiny_mce.js"></script>
<script type="text/javascript">
			tinyMCE.init({
				mode : 'textareas',
				elements : 'main',
				theme : 'advanced',
				plugins : 'table,preview,inlinepopups,insertdatetime,style,xhtmlxtras,advimage',
				theme_advanced_buttons2_add : 'table,preview,insertdate,inserttime',
				theme_advanced_buttons3_add : 'styleprops,cite,ins,del,abbr,acronym,attribs',
				dialog_type : 'modal',
				plugin_insertdate_dateFormat : '%d.%m.%Y ',
				plugin_insertdate_timeFormat : '%H:%M:%S ',
				relative_urls : false,
				 document_base_url : '../' 
				});
</script>
       <script type="text/javascript">
	   function GB_hide() {    
						  GB_IFRAME.src = "";    
						  hideElement(GB_WINDOW);    
						  hideElement(GB_HEADER);    
						  hideElement(GB_OVERLAY);  
						  location.reload();
		}
		</script>
<?php 
        $sites = array("news", "vereine", "ligaleitung","turniere", "spielplan", "dokumente", "bilder");
        //gewaehlte Seite
        $getsite = $_GET["site"];
        //wenn $getsite keinen der in $sites definierten Werte hat dann ist $getsite=admin (startseite der adminoberfläche)
        if (in_array($getsite, $sites) == FALSE) {
            $getsite = "admin.php";
        } else {
            $getsite.="edit.php";
        }
?>
        <!--Greybox-->
        <script type="text/javascript">var GB_ROOT_DIR = "../java/greybox/";</script>
        <script type="text/javascript" src="../java/greybox/AJS.js"></script>
        <script type="text/javascript" src="../java/greybox/AJS_fx.js"></script>
        <script type="text/javascript" src="../java/greybox/gb_scripts.js"></script>
        <link href="../java/greybox/gb_styles.css" rel="stylesheet" type="text/css" media="all" />
        <!--Ende Greybox-->
    </head>
    <body>
	
        <div id="pagewidth" >
            <div id="header" style="text-align:center;">
                <ul id="navigation">
                    <li><a href="?site=admin">Admin</a></li>
                    <li><a href="?site=news">Start</a></li>
                    <li><a href="?site=vereine">Vereine</a></li>
                    <li><a href="?site=ligaleitung">Ligaleitung</a></li>
                    <li><a href="?site=turniere">Turniere</a></li>
                    <li><a href="?site=spielplan">Spielplan</a></li>
                    <li><a href="?site=dokumente">Dokumente</a></li>
                    <li><a href="?site=bilder">Bilder</a></li>
					</ul>
    	</div>
		<div id="maincol" style='margin-top:200px;'>
		<div id="content">
		<?php 
    		include($getsite);
			echo "<div style='height:400px;width:95%;background-color:#fff;'></div>";
		?>
		</div>
		</div>
		<div id="footer" > <div class="inhalt"><span style=" float: right;"><a href="../?site=impressum">Impressum</a> </span><a href="http://www.rhein-neckar-liga.de/index.htm">Archiv</a><p style="text-align:center;margin: -1.2em 0 0 0;padding:0;">Offizielle Seite der Rhein-Neckar-Liga</p></div></div>
		</div>
    </body>
</html>
