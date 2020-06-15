<?php

require_once (__DIR__ . '/include/loginredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$TITLE = "Willkommen";

require_once (__DIR__ . '/templates/header.php');

if(isset($_POST['login'])) {
	$login = false;
	if(isset($_POST['username'])) {
		if(isset($_POST['password'])) {
			$api = new DatabaseAPI();
			$user = $api->getUserByName(trim($_POST['username']));
			$user = $user != null ? $user : $api->getUserByEMail(trim($_POST['username']));

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
		<h1 class="h1">
			<center><br>Willkommen bei Nicht Lachen 2.0!<br>
			<br>
		</h1>

		<div class="center" style="font-family: Arial; background-color: #ff9900; color: var(--colorSecondaryText); border-radius: 16px; max-width: 30em; font-size: 14pt; padding: 0.5em; overflow-wrap: normal;">
			<h2>Anmelden</h2>
			<form class="default-form" method="POST">
				<input type="text" style="width: 75%; height: 2em; color: var(--colorSecondaryText);" name="username" placeholder="Benutzername/EMail-Adresse"/><br>
				<br>
				<input type="password" style="width: 75%; height: 2em; color: var(--colorSecondaryText);" name="password" placeholder="Passwort"/><br>
				<br>
				<input class="button" type="submit" name="login" value="Anmelden"/><br>
				<br>
				<a class="button" style="font-size: 10pt;" href="resetpassword.php">Passwort vergessen?</a><br>
				<br>
				<br>
				<br>
				<a class="button" style="font-size: 12pt;" href="register.php">Noch kein Account? Hier registrieren!</a>
			</form>
		</div>
<?php
require_once (__DIR__ . '/templates/footer.html');
?>
