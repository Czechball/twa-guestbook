<?php
session_start();
require_once "gbook.class.php";
require_once "credentials.php";
global $gbook;
$gbook = new gbook($host, $port, $dbname, $user, $pass);
$name = $_POST["name"];
$subject = $_POST["subject"];
$text = $_POST["text"];
if(empty($name) || empty($subject) || empty($text))
{
	header('Location: ' . preg_split($_SERVER['HTTP_REFERER'],'?')[0] . '?add=2');
} else {
	$gbook->addPost($name, $subject, $text);
	header('Location: ' . preg_split($_SERVER['HTTP_REFERER'],'?')[0] . '?add=1');
}
?>