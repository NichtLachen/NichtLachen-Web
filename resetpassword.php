<?php

require_once (__DIR__ . '/include/loginredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/config.php');
require_once (__DIR__ . '/include/stringutils.php');

function sendResetMail(User $user, string $key) {
	$headers = array("Content-Type: text/plain; charset=UTF-8");
	$subject = "NichtLachen.nl | Passwort zurücksetzen";
	$content = file_get_contents(__DIR__ . '/templates/email-resetpw.txt');
	$content = str_replace('$USER', $user->getName(), $content);
	$content = str_replace('$URL', "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?uid=" . $user->getUID() . "&key=" . $key, $content);

	mail($user->getEMail(), "=?utf-8?B?" . base64_encode($subject) . "?=", $content, $headers, "-f verify@nichtlachen.nl -F NichtLachen.nl");
}

$TITLE = "Passwort zurücksetzen";

require_once (__DIR__ . '/templates/header.php');

if (isset($_POST['resetpassword'])) {
	if(isset ($_POST['email']) && strlen($_POST['email']) > 0) {
		$email = trim($_POST['email']);
		$user = $api->getUserByEMail($email);

		if($user != null) {
			sendResetMail($user, $api->resetPasswordVerify($user->getUID()));
		}

		$SUCCESS = "Eine EMail wurde an die angegebene EMail-Adresse gesendet, klicken Sie auf den Link in der EMail um Ihr Passwort zurückzusetzen!";
		require (__DIR__ . '/templates/success.php');

	} else {
		$ERROR = "EMail darf nicht leer sein!";
		require (__DIR__ . '/templates/error.php');
	}
} else if(isset($_GET['uid']) && isset($_GET['key']) && isset($_POST['password'])) {
	$api = new DatabaseAPI();

	if(strlen($_POST['password']) > 8) {
		if($api->resetPassword($_GET['uid'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_GET['key'])) {
			$SUCCESS = 'Ihr Passwort wurde erfolgreich geändert! <div class="container"><a href="login.php" class="button">Anmelden</a></div>';
			require (__DIR__ . '/templates/success.php');
		} else {
			$ERROR = "Die angegebene Verifikations-ID existiert nicht! Ist Ihre Passwort-Reset abgelaufen?";
			require (__DIR__ . '/templates/error.php');
		}
	} else {
		$ERROR = "Das Passwort muss mindestens 8 Zeichen lang sein!";
		require (__DIR__ . '/templates/error.php');
	}
}

require_once (__DIR__ . '/templates/navbar_back.php');

if(isset($_GET['uid']) && isset($_GET['key'])) {
?>
		<div class="center">
			<form class="default-form" style="margin-top: 6em;" method="POST">
				<input type="password" name="password" placeholder="Neues Passwort"/><br>
				<br>
				<input class="button" type="submit" name="resetpassword-stage2" value="Passwort zurücksetzen"/>
			</form>
		</div>
<?php
} else {
?>
		<div class="center">
			<form class="default-form" style="margin-top: 6em;" method="POST">
				<input type="email" name="email" placeholder="EMail-Adresse"/><br>
				<br>
				<input class="button" type="submit" name="resetpassword" value="Passwort zurücksetzen"/>
			</form>
		</div>
<?php
}

require_once (__DIR__ . '/templates/footer.html');

?>
