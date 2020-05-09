<?php

require_once (__DIR__ . '/include/loginredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/config.php');
require_once (__DIR__ . '/include/stringutils.php');

function sendVerifyMail(string $username, string $email, string $key) {
	$headers = array("Content-Type: text/plain; charset=UTF-8");
	$subject = "NichtLachen.nl | E-Mail bestätigen";
	$content = file_get_contents(__DIR__ . '/templates/email.txt');
	$content = str_replace('$USER', $username, $content);
	$content = str_replace('$URL', "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?key=" . $key, $content);

	mail($email, "=?utf-8?B?" . base64_encode($subject) . "?=", $content, $headers, "-f verify@nichtlachen.nl -F NichtLachen.nl");
}

$TITLE = "Registrieren";

require_once (__DIR__ . '/templates/header.php');

if (ALLOW_REGISTRATION) {
	if (isset($_POST['register'])) {
		if(isset ($_POST['username']) && strlen($_POST['username']) > 0) {
			$username = trim($_POST['username']);

			if(isset($_POST['email']) && strlen($_POST['email']) > 0) {
				$email = $_POST['email'];
				$pwlen = isset($_POST['password']) ? strlen($_POST['password']) : 0;

				if($pwlen >= 8) {
					$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
					$api = new DatabaseAPI();

					if(!$api->isNameInUse($username) && !$api->isNameInVerification($username)) {
						if (validate_username($username)) {
							$user = $api->getUserByEMail($email);

							if($user == null && !$api->isEMailInVerification($email)) {
								$vid = $api->verify($username, $email, $password);
								sendVerifyMail($username, $email, $vid);
								$SUCCESS = "Eine Bestätigungsemail wurde an die angegebene EMail-Adresse gesendet, klicken Sie auf den Link in der EMail um Ihren Account zu aktivieren!";
								require (__DIR__ . '/templates/success.php');
							} else {
								$ERROR = "Diese EMail-Adresse wird bereits verwendet!";
								require (__DIR__ . '/templates/error.php');
							}
						} else {
							$ERROR = "Der Benutzername enthält ein ungültiges Zeichen!";
							require (__DIR__ . '/templates/error.php');
						}
					} else {
						$ERROR = "Dieser Benutzername wird bereits verwendet!";
						require (__DIR__ . '/templates/error.php');
					}
				} else {
					$ERROR = "Das Passwort muss mindestens 8 Zeichen lang sein!";
					require (__DIR__ . '/templates/error.php');
				}
			} else {
				$ERROR = "EMail-Adresse darf nicht leer sein!";
				require (__DIR__ . '/templates/error.php');
			}
		} else {
			$ERROR = "Benutzername darf nicht leer sein!";
			require (__DIR__ . '/templates/error.php');
		}
	} else if(isset($_GET['key'])) {
		$api = new DatabaseAPI();
	
		if($api->verifyEnable($_GET['key'])) {
			$SUCCESS = 'Ihr Account wurde erfolgreich aktiviert! <div class="container"><a href="login.php" class="button">Anmelden</a></div>';
			require (__DIR__ . '/templates/success.php');
		} else {
			$ERROR = "Die angegebene Verifikations-ID existiert nicht! Ist Ihre Registrierung abgelaufen?";
			require (__DIR__ . '/templates/error.php');
		}
	} 
} else {
	$ERROR = "Die Registrierung ist zurzeit deaktiviert";
	require (__DIR__ . '/templates/error.php');
}

$TITLE = "Registrieren";
require_once (__DIR__ . '/templates/navbar_back.php');
?>
		<div class="center">
			<form class="default-form" style="margin-top: 6em;" method="POST">
				<input type="text" name="username" placeholder="Benutzername"/><br>
				<br>
				<input type="email" name="email" placeholder="EMail-Adresse"/><br>
				<br>
				<input type="password" name="password" placeholder="Passwort"/><br>
				<br>
				<input class="button" type="submit" name="register" value="Registrieren"/>
			</form>
		</div>
<?php
require_once (__DIR__ . '/templates/footer.html');
?>
