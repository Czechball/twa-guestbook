<?php
require_once "gbook.class.php";
require_once "credentials.php";
global $gbook;
$gbook = new gbook($host, $port, $dbname, $user, $pass);
$gbook->addPost("Jmeno", "Predmet", "Text");
$gbook->deletePost(1);
?>