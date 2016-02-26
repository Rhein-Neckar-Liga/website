<?php
//error_reporting(0);
require_once 'clsDb.php';

if ($_POST){
	$dbh = clsDb::getConnection();
	
	$stmt = $dbh->prepare("SELECT * FROM viewNewsDani WHERE idNewsItems=?");

	if ($stmt->execute(array($_POST['id']))) {
		$news = $stmt->fetch();
		$newsArray=array(
			'title' => $news["title"],
			'description' => $news["description"],
			'date' => $news["date"],
		);
		echo json_encode($newsArray);
	}
} 
?>
