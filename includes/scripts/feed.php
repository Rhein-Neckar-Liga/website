<?php

//require_once '../../clsDb.php';

class createFeed {

    private $doc;
    private $news;
    private $channel;

    function __construct() {
        $dbh = clsDb::connect();
        $this->news = $dbh->query("SELECT * FROM viewNewsDani WHERE date > '".date("Y-m-d", strtotime("-3 month"))."' ORDER BY date DESC");
    }

    public function create() {
        $this->doc = new DOMDocument('1.0');
        $this->doc->formatOutput = true;
        $root = $this->doc->createElement('rss');
        $this->doc->appendChild($root);
        //Attribut version
        $attribut = $this->doc->createAttribute('version');
        $root->appendChild($attribut);
        $text = $this->doc->createTextNode("2.0");
        $attribut->appendChild($text);
        //Attribut Namespace
        $attribut = $this->doc->createAttribute('xmlns:atom');
        $root->appendChild($attribut);
        $text = $this->doc->createTextNode("http://www.w3.org/2005/Atom");
        $attribut->appendChild($text);
        //channel
        $root->appendChild($this->channel());
    }

    private function channel() {
        //channel
        $channel = $this->doc->createElement('channel');
        //title
        $xml = $this->doc->createElement('title');
        $text = $this->doc->createTextNode('Rhein-Neckar-Liga');
        $xml->appendChild($text);
        $channel->appendChild($xml);
        //link
        $xml = $this->doc->createElement('link');
        $text = $this->doc->createTextNode('http://www.rhein-neckar-liga.de');
        $xml->appendChild($text);
        $channel->appendChild($xml);
		//<atom:link href="http://dallas.example.com/rss.xml" rel="self" type="application/rss+xml" />
		//atom:link
        $xml = $this->doc->createElement('atom:link');
        $attribut = $this->doc->createAttribute('href');
        $xml->appendChild($attribut);
        $text = $this->doc->createTextNode("http://www.rhein-neckar-liga.de/xml/feed.rss");
        $attribut->appendChild($text);
		//$attribut = $this->doc->createAttribute('rel');
        //$xml->appendChild($attribut);
        //$text = $this->doc->createTextNode("self");
        //$attribut->appendChild($text);
		$attribut = $this->doc->createAttribute('type');
        $xml->appendChild($attribut);
        $text = $this->doc->createTextNode("application/rss+xml");
        $attribut->appendChild($text);
        $channel->appendChild($xml);
        //description
        $xml = $this->doc->createElement('description');
        $text = $this->doc->createTextNode('News der Rhein-Neckar-Liga');
        $xml->appendChild($text);
        $channel->appendChild($xml);
		//language
        $xml = $this->doc->createElement('language');
        $text = $this->doc->createTextNode('de-de');
        $xml->appendChild($text);
        $channel->appendChild($xml);
		//pubDate
        $xml = $this->doc->createElement('pubDate');
        $text = $this->doc->createTextNode(date("r"));
        $xml->appendChild($text);
        $channel->appendChild($xml);
		//image
		$channel->appendChild($this->image());
        //items
        foreach ($this->news as $row) {
            $xml = $this->doc->createElement('item');
            $channel->appendChild($this->item($row));
        }
        return $channel;
    }
	
	private function image(){
		$image = $this->doc->createElement('image');
		//title
		$xml = $this->doc->createElement('title');
        $text = $this->doc->createTextNode("Rhein-Neckar-Liga");
        $xml->appendChild($text);
        $image->appendChild($xml);
		//url
		$xml = $this->doc->createElement('url');
        $text = $this->doc->createTextNode("http://www.rhein-neckar-liga.de/rnl.jpg");
        $xml->appendChild($text);
        $image->appendChild($xml);
		//link
		$xml = $this->doc->createElement('link');
        $text = $this->doc->createTextNode("http://www.rhein-neckar-liga.de");
        $xml->appendChild($text);
        $image->appendChild($xml);
		return $image;
	}

    private function item($row) {
        $item = $this->doc->createElement('item');
        //title
        $xml = $this->doc->createElement('title');
        $text = $this->doc->createTextNode($row["title"]);
        $xml->appendChild($text);
        $item->appendChild($xml);
        //descrition
        $xml = $this->doc->createElement('description');
		$cdata=$this->doc->createCDATASection($row["description"]);
        //$text = $this->doc->createTextNode("<![CDATA[".$row["description"]."]]>");
        $xml->appendChild($cdata);
        $item->appendChild($xml);
        //category
        $xml = $this->doc->createElement('category');
        $text = $this->doc->createTextNode($row["category"]);
        $xml->appendChild($text);
        $item->appendChild($xml);
		
		//enclosure -> Erst mal herausgenommen
        //$xml = $this->doc->createElement('enclosure');
        //$attribut = $this->doc->createAttribute('length');
        //$text = $this->doc->createTextNode("1");
        //$attribut->appendChild($text);
        //$xml->appendChild($attribut);
		//$attribut = $this->doc->createAttribute('url');
        //$text = $this->doc->createTextNode("http://www.rhein-neckar-liga.de/images/".strtolower($row["category"]).".jpg");
        //$attribut->appendChild($text);
        //$xml->appendChild($attribut);
		//$attribut = $this->doc->createAttribute('type');
        //$text = $this->doc->createTextNode("image/jpeg");
        //$attribut->appendChild($text);
        //$xml->appendChild($attribut);
        //$item->appendChild($xml);
		//link
        $xml = $this->doc->createElement('link');
        $text = $this->doc->createTextNode("http://www.rhein-neckar-liga.de/index.php#rnl_".$row["date"]."_".$row["idNewsItems"]);
        $xml->appendChild($text);
        $item->appendChild($xml);
		//guid
        $xml = $this->doc->createElement('guid');
        $text = $this->doc->createTextNode("http://www.rhein-neckar-liga.de/index.php#rnl_".$row["date"]."_".$row["idNewsItems"]);
        $xml->appendChild($text);
        $item->appendChild($xml);
		//author
        $xml = $this->doc->createElement('author');
        $text = $this->doc->createTextNode($row["email"]." (".$row["author"].")");
        $xml->appendChild($text);
        $item->appendChild($xml);
		//pubDate
        $xml = $this->doc->createElement('pubDate');
        $text = $this->doc->createTextNode(date("r", strtotime($row["date"])));
        $xml->appendChild($text);
        $item->appendChild($xml);
        return $item;
    }

    public function save() {
        return $this->doc->save("../xml/feed.rss");
    }

}

?>