<?php
session_start();
require_once "gbook.class.php";
require_once "credentials.php";
global $gbook;
$gbook = new gbook($host, $port, $dbname, $user, $pass);
//echo $gbook->verifyAdmin("admin", "password");
//$gbook->addPost("Jmeno", "Predmet", "Text");
//$gbook->deletePost(1);
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
		<?php
		if (isset($_POST["add"]))
		{
			$name = $_POST["name"];
			$subject = $_POST["subject"];
			$text = $_POST["text"];
			$gbook->addPost($name, $subject, $text);
			echo "Příspěvek přidán.";
		}

		if (isset($_POST["delete"]))
		{
			$id = $_POST["id"];
			$gbook->deletePost($id);
			echo "Příspěvek smazán.";
		}

		if (isset($_POST["login"]))
		{
			$user = $_POST["user"];
			$password = $_POST["password"];
    	if ($gbook->verifyAdmin($user, $password))
    	{
        $_SESSION['username'] = $user;
        echo "Přihlášen.";
    	}
    	else
    	{
        unset($_SESSION['username']);
        echo "Nesprávné údaje.";
    	}
		}

		if (isset($_POST["logout"]))
		{
        unset($_SESSION['username']);
        echo "Odhlášen.";
    	}
		?>
		<h1>Guest book</h1>
		<form method="POST" action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>">
			<table margin="0" padding="2">
				<tr>
					<td align=right valign="top">Jméno</td>
					<td align=left><input type="text" name="name"></td>
				</tr>
				<tr>
					<td align=right valign="top">Předmět</td>
					<td align=left><input type="text" name="subject"></td>
				</tr>
				<tr>
					<td align=right valign="top">Text</td>
					<td align=left><textarea name="text" cols="50" rows="5"></textarea></td>
				</tr>
				<tr>
					<td align=right valign="top"></td>
					<td align=left><input type="submit" name="add" value="Odeslat"></td>
				</tr>
			</table>
		</form>
		<?php 
		$posts = $gbook->getPosts();
		foreach ($posts as $row)
		{
		$row = json_decode(json_encode($row), true);
    	print "<p><b>". htmlspecialchars($row["subject"]) ."</b><br>". htmlspecialchars($row["text"]) . "<br><span size=-1>". htmlspecialchars($row["name"]). ", " . $row["date"] . "</span><br>";

		if (isset($_SESSION['username']))
			{	


		?>
		<form method="POST" action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>">
			<input type="hidden" name="id" value="<?php echo $row["id"] ?>">
			<input type="submit" name="delete" value="Smazat">
		</form>
		</p>
		<?php
			}
		}
		?>
		<h2>Administrace</h2>
		<?php
		if (!isset($_SESSION['username']))
		{

		?>
		<form method="POST" action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>">
			<table margin="0" padding="2">
				<tr>
					<td align=right valign="top">Jméno</td>
					<td align=left><input type="text" name="user"></td>
				</tr>
				<tr>
					<td align=right valign="top">Heslo</td>
					<td align=left><input type="password" name="password"></td>
				</tr>
				<tr>
					<td align=right valign="top"></td>
					<td align=left><input type="submit" name="login" value="Přihlásit"></td>
				</tr>
			</table>
		</form>
		<?php
		}
		else
		{
			?>
			<form method="POST" action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>">
			<table margin="0" padding="2">
				<tr>
					<td align=right valign="top"></td>
					<td align=left><input type="submit" name="logout" value="Odhlásit"></td>
				</tr>
			</table>
		</form>
			<?php
		}
		?>
	</body>