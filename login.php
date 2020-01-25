<?php

require_once (dirname(__FILE__) . '/include/loginredirect.php');
require_once (dirname(__FILE__) . '/classes/db/DatabaseAPI.php');

?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Anmelden</title>
		<link rel="stylesheet" href="/css/stylesheet.css"/>
	</head>
	<body>
<?php
if(isset($_POST['login'])) {
	$login = false;
	if(isset($_POST['username'])) {
		if(isset($_POST['password'])) {
			$api = new DatabaseAPI();
			$user = $api->getUserByName($_POST['username']);
			$user = $user != null ? $user : $api->getUserByEMail($_POST['username']);
			
			if($user != null) {
				if ($api->authenticate($user->getUID(), $_POST['password'])) {
					$login = true;
					$SUCCESS = "Erfolgreich angemeldet!";
					include (dirname(__FILE__) . '/templates/success.php');

					// Session ID:
					session_start();
					$api->setSessionID($user->getUID(), session_id());
?>
		<meta http-equiv="refresh" content="1; url=home.php">
<?php
				}
			}
		}
	}

	if(!$login) {
		$ERROR = "Benutzername oder Passwort falsch!";
		include (dirname(__FILE__) . '/templates/error.php');
	}
}
?>
		<h1 style="margin-top: 0%;">
			<center><br>Anmelden<br><br></center>
		</h1>
		<center>
			<form method="POST" action="">
				<input type="text" name="username" placeholder="Benutzername/EMail-Adresse"/><br>
				<br>
				<input type="password" name="password" placeholder="Passwort"/><br>
				<br>
				<input type="submit" name="login" value="Anmelden"/>
			</form>
		</center>
<?php
require_once (dirname(__FILE__) . '/templates/footer.html');
?>
	</body>
</html>