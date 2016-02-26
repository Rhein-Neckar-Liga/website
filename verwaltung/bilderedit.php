<?php
$timestamp = time();
$heute=date("d.m.Y",$timestamp);
$jahr=date("Y",$timestamp);
$letztjahr=$jahr-1;
$vorletztjahr=$letztjahr-1;
$monat=date("m",$timestamp);
$tag=date("d",$timestamp);
$stunde=date("H",$timestamp);
$minute=date("i",$timestamp);
$sekunde=date("s",$timestamp);
echo  "<div class='beitrag'>$heute $stunde $minute $sekunde</div>";
  echo "<div class='beitrag'>
			<p>Hallo Admin!<br/>Unsere Bilderalben entstehen quasi 'von selbst', Voraussetzung ist lediglich, dass die Bilder in bestimmtem Format in bestimmten Ordnern liegen, die einigen Regeln unterliegen, was die Dateinamen anbelangt. Das Ganze liesse sich sicherlich komfortabler lösen, ich arbeite seit Jahren mit dieser Variante und bin eigentlich zufrieden. Vielleicht finde ich (oder ihr) irgendwann was komfortableres.  <br/>
			Das Skript arbeitet nach folgenden Regeln: 
			</p>
			<ul>
			<li>Im Ordner <span class='sql'>www.rhein-neckar-liga.de/images/alben</span> gibt es <strong>für jedes Jahr ein Verzeichnis </strong>(z.B. <span class='sql'>images/alben/$jahr/</span><br/>Wenn das noch nicht existiert, bitte per ftp anlegen</li>
			<li>Jedes Verzeichnis, das ihr als Unterordner dieser Jahresordner anlegt, ist ein <strong>Album</strong>. Den Namen des Albums könnt ihr frei wählen, bedenkt aber, dass er als Überschrift im Album verwendet wird ergänzt um den Namen des übergeordneten Verzeichnisses (Jahreszahl). Bitte verwendet 
				<ul> 
				<li>keine Leerzeichen, nehmt stattdessen den Unterstrich '_'</li>
				<li>keine Sonderzeichen oder Umlaute, das erspart Probleme</li>
				<li>wenn ihr wollt, dass ein Album nicht auf der Webseite erscheint, setzt ein '@' for den Namen, z.B. <span class='sql'>@Bezirksliga_Schwetzingen</span></li>
				<li>Beispiele für Alben im Verzeichnis $jahr:<br/><span class='sql'>@Turnier XY</span> &raquo; erscheint nicht<br/>
								   <span class='sql'>Anboulen_Musterstadt</span> &raquo; Anboulen Musterstadt $jahr<br/>
								   <span class='sql'>RNL-Liga_Spieltag_2</span> &raquo; RNL-Liga Spieltag 2 $jahr
				</li>
				</ul>
				</li>
			<li>In diese Verzeichnisse kommen die Bilder im Großformat, am besten mit einer Seitenbreite von 600-1000px
				<ul>
				<li>Dort erstellt ihr auch einen Unterordner <span class='sql'>thumbs</span>, wo die kleinen Varianten der Bilder reinkommen. Die Breite dieser thumbs sollte 120px betragen, der Name stimmt mit der grossen Variante überein ergänzt um das Präfix <span class='sql'>th_</span> also zB. <span class='sql'>PIC_001.jpg</span> und das Vorschaubild <span class='sql'>th_PIC_001.jpg'</span>.<br/>
				<strong>Vorsicht: Gross- und Kleinschreibung wird unterschieden!</strong> </li>
				<li>zum erstellen dieser thumbs könnt ihr zum Beispiel <a href='http://www.irfanview.de/'>IrfanView</a> benutzen <br/><span class='sql'>Tipp: 'B' drücken = Batch(Stapel-)Verarbeitung von Bildern (umbenennen, Grösse verändern in einem Rutsch)</span></li>
				</ul></li>
			<li>Wenn ihr möchtet, dass euer Album selbst ein Vorschaubild enthält (statt der Kugeln, die standardmäßig eingeblendet werden), legt ihr ein Bild mit dem Dateinamen <span class='sql'>dirimage.<strong>jpeg</strong></span> in das Bildverzeichnis in der Breite 100px (Endung <span class='sql'><em>jpeg</em></span> beachten!)</li>
			<li>Wenn ein Bericht unterhalb der Vorschaubilder erscheinen soll, legt ihr eine Kopie der Datei <span class='sql'>www.rhein-neckar-liga.de/images/alben/bildindex.xml</span> in das Verzeichnis eures Albums und editiert <span class='sql'>&lt;beschreibung&gt; &lt;name&gt; &lt;date&gt;</span> entsprechend<br/>
			Ein Beispiel findet ihr beim <a href='http://rhein-neckar-liga.de/?site=bilder&year=2013&album=Jugendliga_Abschlusspieltag_LU-Oppau'>Jugendliga Abschlusspieltag in LU-Oppau</a></li>
			</ul>
		</div>";
  echo "<div class='beitrag'>";
        echo "<h4>Verzeichnisstruktur</h4>
<pre>
rhein-neckar-liga.de/
--- images/
--- --- alben/
--- --- --- $jahr/
--- --- --- --- @Musteralbum_ausgeblendet/
--- --- --- --- Musteralbum_XY-Turnier/
--- --- --- --&gt; Musteralbum_XY-Versammlung/
--- --- --- --- --- bildindex.xml	 &lt;!-- fakultativ: ausführliche Beschreibung des Turniers --&gt;
--- --- --- --- --- dirimage.jpeg	 &lt;!-- fakultativ: Vorschaubild des Albums, Breite 100px --&gt;
--- --- --- --- --- PIC_001.jpg	 	 &lt;!-- obligatorisch: Bild das bei click aufs thumb angezeigt wird, Breite 600-1200px --&gt;
--- --- --- --- --- PIC_002.jpg	 	 &lt;!-- obligatorisch: Bild das bei click aufs thumb angezeigt wird, Breite 600-1200px --&gt;
--- --- --- --- --- ...
--- --- --- --- --&gt; thumbs/
--- --- --- --- --- --- th_PIC_001.jpg	 &lt;!-- obligatorisch: Vorschaubild für PIC_001.jpg, Breite 120px, Präfix 'th_' --&gt;
--- --- --- --- --- --- th_PIC_001.jpg	 &lt;!-- obligatorisch: Vorschaubild für PIC_002.jpg, Breite 120px, Präfix 'th_' --&gt;
--- --- --- --- --- --- ...
--- --- --- $letztjahr/
--- --- --- $vorletztjahr/
--- --- --- ...
</pre>
		";
    echo "</div>";
  echo "<div class='beitrag'>";
        echo "<h4>Die Bilder</h4>
			<p>Wie ihr eure Bilder nennt, bleibt euch überlassen. Bitte keine Umlaute und Leerzeichen in den Dateinamen! <br/>
			Das Album wird alphabnumerisch nach Dateinamen sortiert, damit könnt ihr die Reihenfolge der Anzeige beeinflussen. <br/>
			Meist bietet sich die Benamsung nach folgendem Muster an: <span class='sql'>JJJJMMTT_HHMMSS.jpg</span> also zum Beispiel <span class='sql'>$jahr$monat$tag_$stunde$minute$sekunde.jpg</span> für ein Bild, das am $tag.$monat.$jahr um $stunde:$minute:$sekunde Uhr aufgenommen wurde.
			</p>
		";
    echo "</div>";
  echo "<div class='beitrag'>";
        echo "<h4>Die Vorschaubilder (<em>thumbs</em>)</h4>
			<p>Die Dateinamen der Vorschaubilder sind dieselben, wie die der eigentlichen Bilder ergänzt um das Präfix <span class='sql'>th_</span><br/>
			Wenn ihr dem vorigen Beispiel folgt ist das also: <span class='sql'>th_JJJJMMTT_HHMMSS.jpg</span> das heisst <span class='sql'>th_$jahr$monat$tag_$stunde$minute$sekunde.jpg</span> als Vorschau für das Bild, das am $tag.$monat.$jahr um $stunde:$minute:$sekunde Uhr aufgenommen wurde.
			<br/>Bitte beachten: <span class='sql'>th_$jahr$monat$tag_$stunde$minute$sekunde.<strong>jpg</strong></span> ist nicht dasselbe wie <span class='sql'>th_$jahr$monat$tag_$stunde$minute$sekunde.<strong>JPG</strong></span>
			</p>
		";
    echo "</div>";

  echo "<div class='beitrag'>";
        echo "<h4>Die Datei dirimage.jpeg</h4>
<p>Wenn ihr ein neues Album angelegt habt, bekommt das standardmäßig als Hintergrundbild ein paar Boulekugeln. 
Wenn ein anderes Bild angezeigt werden soll, sucht euch einfach eins der Bilder des Albums raus, speichert es als <span class='sql'>dirmage.jpeg</span> 
in das Albumverzeichnis und ändert die Breite auf 100px.
</p>
		";
    echo "</div>";
  echo "<div class='beitrag'>";
        echo "<h4>Die Datei bildindex.xml</h4>
<p>Wenn ein Bericht unterhalb der Vorschaubilder erscheinen soll, legt ihr eine Kopie der Datei <span class='sql'>www.rhein-neckar-liga.de/images/alben/bildindex.xml</span> in das Verzeichnis eures Albums und editiert <span class='sql'>&lt;beschreibung&gt; &lt;name&gt; &lt;date&gt;</span> entsprechend<br/>
</p>
<pre>
&lt;?xml version='1.0' encoding='utf-8'?&gt;
&lt;fake&gt;
	&lt;bildindex&gt;
	&lt;beschreibung&gt;
		&lt;![CDATA[ 
		&lt;!-- ab hier bitte ändern, normales html verwenden--&gt;
		&lt;h3&gt;Überschrift&lt;/h3&gt;
		&lt;p&gt;Mustertext  Mustertext &lt;/p&gt;
		]]&gt;
	&lt;/beschreibung&gt;
	&lt;name&gt;Wird als Überschrift verwendet&lt;/name&gt;
	&lt;date&gt;14.05.$jahr&lt;/date&gt;
	&lt;/bildindex&gt;
&lt;/fake&gt;
</pre>
<p>In <span class='sql'> &lt;beschreibung&gt;</span> könnt ihr im Prinzip das html eines Newsbeitrags reinkopieren, den ihr vorher erstellt habt. Bitte beachten, dass die <span class='sql'>&lt;![CDATA[ <strong>Beschreibung</strong> ]]&gt; </span> so umschlossen wird.</p>
		";
    echo "</div>";
?>