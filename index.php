<?php
require_once "gbook.class.php";
require_once "credentials.php";
global $gbook;
$gbook = new gbook($host, $port, $dbname, $user, $pass);
echo $gbook->verifyAdmin("admin", "password");
$gbook->addPost("Jmeno", "Predmet", "Text");
//$gbook->deletePost(1);
$posts = $gbook->getPosts();
foreach ($posts as $row) {
	$row = json_decode(json_encode($row), true);
    print "<p>" . $row["name"] . "-" . $row["subject"] ."<br/>". $row["text"]. "</p>";
}
?>
<!DOCTYPE html>
<html lang="en-US">

<head>

	<title>Czechball's Guestbook</title>
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/ico" href="favicon.ico"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
	<body>
		<h1>Guest book</h1>
		<form method="POST" action="<?php echo $_["SCRIPT_NAME"]; ?>">
			<table margin="0" padding="2">
				<tr>
					<td align=right>Jméno</td>
					<td align=left><input type="text" name="name"></td>
				</tr>
				<tr>
					<td align=right>Předmět</td>
					<td align=left><input type="text" name="subject"></td>
				</tr>
				<tr>
					<td align=right>Text</td>
					<td align=left><textarea cols="50" rows="5"></textarea></td>
				</tr>
				<tr>
					<td align=right></td>
					<td align=left><input type="submit" name="add" value="Odeslat"></td>
				</tr>
			</table>
		</form>
	</body>