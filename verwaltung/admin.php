<?php
	echo "<div class='beitrag'>
	<p><strong>Hallo Admin</strong></p>
	<p>Auf diesen Seiten kannst Du <em>fast</em> alle Inhalte von www.rhein-neckar-liga.de bearbeiten bzw. neue Einträge erstellen. <br/>
			Zu Anschauungszwecken siehst Du hier jeweils auf der linken Seite einen Screenshot der Seite, die veröffentlicht (online) ist, sowie auf der rechten Seite die entsprechende Abbildung des Verwaltungsbereichs.</p>
	<p>Folgende Symbole werden verwendet:<br/>
	Veröffentlichen  = <img alt='Veröffentlichen' class='inline' src='../verwaltung/images/icons/publish.png' /><br/>
	Sperren  = <img alt='Sperren' class='inline' src='../verwaltung/images/icons/stop.png' /><br/>
	Löschen  = <img alt='Löschen' class='inline' src='../verwaltung/images/icons/delete.png' /><br/>
	Beabeiten  = <img alt='Bearbeiten' class='inline' src='../verwaltung/images/icons/edit.png' /><br/>
	Speichern  = <img alt='Speichern' class='inline' src='../verwaltung/images/icons/save.png' /><br/>
	Abbrechen  = <img alt='Cancel' class='inline' src='../verwaltung/images/icons/cancel.png' /> <br/> <br/>
	Ligaergebnisse werden <b>nicht</b> hier gepflegt sondern im <a href='http://www.liga-net.de/'>Liga-net</a>
    </p><hr/>";
	
    echo "<h3>News/Start:</h3>
	<a href='../'><img src='images/screens/online_news.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<a href='?site=news'><img src='images/screens/admin_news.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<p>Hier wird die Startseite mit den Newseinträgen administriert. Außerdem werden hier die Newsbeiträge der einzelnen Ligastaffeln verwaltet. Der Editor ist etwas aufwendiger als auf den anderen Seiten. Hier kann auch formatiert, Bilder und Tabellen eingefügt werden usw. Beiträge können nachdem sie gesperrt wurden auch gelöscht werden. </p>
	<br style='clear: both;'/>";
    
	echo "<h3>Vereine:</h3>
	<a href='../?site=vereine'><img src='images/screens/online_vereine.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<a href='?site=vereine'><img src='images/screens/admin_vereine.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<p>Hier können die Mitgliedsvereine angelegt und verwaltet werden. Vereine können nicht gelöscht, sondern nur gesperrt werden. Gesperrte Vereine erscheinen nicht in der Online-Vereinsliste.</p>
	<br style='clear: both;'/></p>";
	
    echo "<h3>Ligaleitung:</h3>
	<a href='../?site=ligaleitung'><img src='images/screens/online_ligaleitung.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<a href='?site=ligaleitung'><img src='images/screens/admin_ligaleitung.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<p>Nicht so häufig, aber einmal im Jahr müssen hier die Liga- und Staffelleiter verändert werden. Wie bei den Vereinen können hier keine Daten gelöscht, sondern nur gesperrt werden. </p>
	<br style='clear: both;'/></p>";
    
	echo "<h3>Turniere:</h3>
	<a href='../?site=turniere'><img src='images/screens/online_turniere.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<a href='?site=turniere'><img src='images/screens/admin_turniere.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<p>Der Turnierkalender erfreut sich stets großer Beliebtheit bei unseren Seitenbesuchern. Nicht nur deshalb sollte er möglichst aktuell bleiben. Auf diesen Seiten hast Du die Möglichkeit alle Turniere komfortabel zu verwalten. Hinweis: Turniere müssen einem Verein zugeordnet werden können! Externe Turniere sind hier nicht eintragbar. (außer RNL, BBPV und DPV - Turniere)</p>
	<br style='clear: both;'/></p>";
    
	echo "<h3>Spielplan:</h3>
	<a href='../?site=spielplan'><img src='images/screens/online_spielplan.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<a href='?site=spielplan'><img src='images/screens/admin_spielplan.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<p>Der Spielplan ist zentraler Bestandteil von www.rhein-neckar-liga.de. Hier können alle Boulespieler sehen, welche Liga wann und wo spielt. Hier können die Spielorte und -daten eingetragen werden. Einträge können gesperrt und wieder freigegeben werden. </p>
	<br style='clear: both;'/></p>";
    
	echo "<h3>Dokumente:</h3>
	<a href='../?site=dokumente'><img src='images/screens/online_dokumente.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<a href='?site=dokumente'><img src='images/screens/admin_dokumente.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<p>Immer mal wieder sollen verschiedene Dokumente zum Download bereitgestellt werden. Das sind u.a. Dokumente zur Liga, zum BBPV, zum Pokal, Richtlinien, Regeln usw. <br/>Die verschiedenen Links zu den Dokumenten können hier verwaltet werden. Die Möglichkeit Dokumente gleich hochzuladen, ist bisher noch nicht implementiert, voerst läuft das noch per FTP.</p>
	<br style='clear: both;'/></p>";
    
	echo "<h3>RNL-Pokal:</h3>
	<a href='../?liga=rnl-pokal'><img src='images/screens/online_rnl-pokal.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<a href='?site=news'><img src='images/screens/admin_news.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<p>Die Administration des RNL-Pokal habe ich jetzt anders als geplant gelöst: RNL-Pokal ist einfach eine zusätzliche News-Kategorie und wird dort gepflegt.</p>
	<p>Der Logik halber sind die Pokalseiten deswegen jetzt auch im Untermenu zu finden.</p>
	<br style='clear: both;'/></p>";
	
	echo "<h3>Bilder:</h3>
	<a href='../?site=bilder'><img src='images/screens/online_bilder.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<a href='?site=bilder'><img src='images/screens/admin_bilder.jpg' style='display:inline;float:left;width:25%;margin:0 1% 0 0;'></a>
	<p>Um ein Bilderalbum zu erstellen, ist ein etwas anderes Vorgehen notwendig, das in <a href='?site=bilder'>diesem Dokument </a>beschrieben ist.</p>
	<p></p>
	<br style='clear: both;'/></p>";
	
	echo "</div>";
?>