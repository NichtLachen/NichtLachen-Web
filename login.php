<?php

require_once (__DIR__ . '/include/loginredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$TITLE = "Anmelden";

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

require_once (__DIR__ . '/templates/navbar_back.php');
?>
		<div class="center">
			<form class="default-form" style="margin-top: 6em;" method="POST">
				<input type="text" name="username" placeholder="Benutzername/EMail-Adresse"/><br>
				<br>
				<input type="password" name="password" placeholder="Passwort"/><br>
				<br>
				<input class="button" type="submit" name="login" value="Anmelden"/>
				<br><br><a class="button" href="resetpassword.php">Passwort vergessen?</a>
			</form>
		</div>
<?php
require_once (__DIR__ . '/templates/footer.html');
?>
