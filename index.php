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
	<link rel="shortcut icon" type="image/png" href="favicon.png"/>
	<link rel="stylesheet" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta property="og:title" content="Czechball's Guestbook">
	<meta property="og:description" content="Amazing website where you can rate your experience on Half-Life LambdaPosting">
	<meta property="og:image" content="https://gbook.lambdaposting.games/meta-thumb.png">
	<meta property="og:url" content="gbook.lambdaposting.games">
</head>
	<body>
		<h1><a href="https://gbook.lambdaposting.games/">Czechball's Guestbook</a></h1>
		<i>Please rate your <a href="https://lambdaposting.games/">LambdaPosting experience!</a></i>
		<?php
		if (isset($_POST["add"]))
		{
			$name = $_POST["name"];
			$subject = $_POST["subject"];
			$text = $_POST["text"];
			$gbook->addPost($name, $subject, $text);
			print '<div class="box style1 success">Post added.</div>';
		}

		if (isset($_POST["delete"]))
		{
			$id = $_POST["id"];
			$gbook->deletePost($id);
			echo '<div class="box style1 success">Post deleted.</div>';
		}

		if (isset($_POST["login"]))
		{
			$user = $_POST["user"];
			$password = $_POST["password"];
    	if ($gbook->verifyAdmin($user, $password))
    	{
        $_SESSION['username'] = $user;
        print '<div class="box style1 success">You were logged in succesfully.</div>';
    	}
    	else
    	{
        unset($_SESSION['username']);
        print '<div class="box style1 error">Incorrect credentials.</div>';
    	}
		}

		if (isset($_POST["logout"]))
		{
        unset($_SESSION['username']);
        print '<div class="box style1 success">You were logged out succesfully.</div>';
    	}
		?>
				<div class="box style3">
		<h2>Moderation</h2>
		<?php
		if (!isset($_SESSION['username']))
		{

		?>
		<p><i>Not logged in</i></p>
		<form method="POST" action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>">
			<table>
				<tr>
					<td align=right valign="top">Username</td>
					<td align=left><input required type="text" name="user"></td>
				</tr>
				<tr>
					<td align=right valign="top">Password</td>
					<td align=left><input required type="password" name="password"></td>
				</tr>
				<tr>
					<td align=right valign="top"></td>
					<td align=left><input type="submit" name="login" value="Login"></td>
				</tr>
			</table>
		</form>
		<?php
		}
		else
		{
			?>
			<p><i>Logged in</i></p>
			<form method="POST" action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>">
			<table>
				<tr>
					<td align=right valign="top"></td>
					<td align=left><input type="submit" name="logout" value="Logout"></td>
				</tr>
			</table>
		</form>
			<?php
		}
		?>
		</div>
		<div class="box style3">
			<h2>Add a post</h2>
		<form method="POST" action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>">
			<table>
				<tr>
					<td align=right valign="top">Nickname</td>
					<td align=left><input required type="text" name="name"></td>
				</tr>
				<tr>
					<td align=right valign="top">Subject</td>
					<td align=left><input required type="text" name="subject"></td>
				</tr>
				<tr>
					<td align=right valign="top">Message</td>
					<td align=left><textarea required name="text" cols="50" rows="5"></textarea></td>
				</tr>
				<tr>
					<td align=right valign="top"></td>
					<td align=left><input type="submit" name="add" value="Submit"></td>
				</tr>
			</table>
		</form>
		</div>
		<div class="box style3">
  <h2>Posts</h2>
  <?php
    foreach ($gbook->getPosts() as $row) { 
      $row = json_decode(json_encode($row), true);
  ?>
    <div class="box message">
      <?php if (isset($_SESSION['username'])) { ?>
      <form method="POST">
        <input type="hidden" name="id" value="<?php echo $row["id"] ?>">
        <button class="delete-button" name="delete"></button>
      </form>
      <?php } ?>
      <b><?php print htmlspecialchars($row["subject"]) ?></b><br />
      <?php print htmlspecialchars($row["text"]) ?><br />
      <?php print htmlspecialchars($row["name"]) ?>, <?php print htmlspecialchars($row["date"]) ?>
    </div>
  <?php } ?>
	</body>