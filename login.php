<?php

require_once (__DIR__ . '/include/loginredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Anmelden</title>
		<link rel="stylesheet" href="/css/stylesheet.min.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
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
					require (__DIR__ . '/templates/success.php');

					// Session ID:
					if(session_status() == PHP_SESSION_NONE) {
						session_start();
					}
					session_regenerate_id(); // new session id for every session
					$api->setSessionID($user->getUID(), session_id());
?>
		<meta http-equiv="refresh" content="1; url=top.php">
<?php
				}
			}
		}
	}

	if(!$login) {
		$ERROR = "Benutzername oder Passwort falsch!";
		require (__DIR__ . '/templates/error.php');
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
require_once (__DIR__ . '/templates/footer.html');
?>
	</body>
</html>
