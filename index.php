<?php
require_once "gbook.class.php";
require_once "credentials.php";
global $gbook;
$gbook = new gbook($host, $port, $dbname, $user, $pass);
$gbook->addPost("Jmeno", "Predmet", "Text");
//$gbook->deletePost(1);
$posts = $gbook->getPosts();
foreach ($posts as $row) {
	$srow = json_decode(json_encode($row), true);
    //print "<p>" . $row["name"] . "-" . $row["subject"] ."<br/>". $row["text"]. "</p>";
    var_dump($srow);
}
?>