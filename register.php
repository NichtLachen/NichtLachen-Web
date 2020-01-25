<?php

require_once (dirname(__FILE__) . '/include/loginredirect.php');
require_once (dirname(__FILE__) . '/classes/db/DatabaseAPI.php');

function sendVerifyMail(string $username, string $email, string $key) {
	$headers = "From: NichtLachen.nl <verify@nichtlachen.nl>";
	$subject = "NichtLachen.nl | E-Mail bestätigen";
	$content = file_get_contents(dirname(__FILE__) . '/templates/email.txt');
	$content = str_replace('$USER', $username, $content);
	$content = str_replace('$URL', "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?key=" . $key, $content);

	mail($email, $subject, $content, $headers);
}

?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Registrieren</title>
		<link rel="stylesheet" href="/css/stylesheet.css"/>
	</head>
	<body>
<?php
if (isset($_POST['register'])) {
	if(isset ($_POST['username']) && !empty($_POST['username'])) {
		$username = $_POST['username'];

		if(isset($_POST['email']) && !empty($_POST['email'])) {
			$email = $_POST['email'];
			$pwlen = isset($_POST['password']) ? strlen($_POST['password']) : 0;

			if($pwlen >= 8) {
				$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$api = new DatabaseAPI();
				$user = $api->getUserByName($username);

				if($user == null) {
					$user = $api->getUserByEMail($email);

					if($user == null) {
						$vid = $api->verify($username, $email, $password);
						sendVerifyMail($username, $email, $vid);
						$SUCCESS = "Eine Bestätigungsemail wurde an die angegebene EMail-Adresse gesendet, klicken Sie auf den Link in der EMail um Ihren Account zu aktivieren!";
						include (dirname(__FILE__) . '/templates/success.php');
					} else {
						$ERROR = "Diese EMail-Adresse wird bereits verwendet!";
						include (dirname(__FILE__) . '/templates/error.php');
					}
				} else {
					$ERROR = "Dieser Benutzername wird bereits verwendet!";
					include (dirname(__FILE__) . '/templates/error.php');
				}
			} else {
				$ERROR = "Das Passwort muss mindestens 8 Zeichen lang sein!";
				include (dirname(__FILE__) . '/templates/error.php');
			}
		} else {
			$ERROR = "EMail-Adresse darf nicht leer sein!";
			include (dirname(__FILE__) . '/templates/error.php');
		}
	} else {
		$ERROR = "Benutzername darf nicht leer sein!";
		include ($root . '/templates/error.php');
	}
} else if(isset($_GET['key'])) {
	$api = new DatabaseAPI();
	
	if($api->verifyEnable($_GET['key'])) {
		$SUCCESS = 'Ihr Account wurde erfolgreich aktiviert! <div class="container"><a href="login.php" class="button">Anmelden</a></div>';
		include (dirname(__FILE__) . '/templates/success.php');
	} else {
		$ERROR = "Die angegebene Verifikations-ID existiert nicht! Ist Ihre Registrierung abgelaufen?";
		include (dirname(__FILE__) . '/templates/error.php');
	}
} ?>
		<h1 style="margin-top: 0%;">
			<center><br>Registrieren<br><br></center>
		</h1>
		<center>
			<form method="POST" action="">
				<input type="text" name="username" placeholder="Benutzername"/><br>
				<br>
				<input type="email" name="email" placeholder="EMail-Adresse"/><br>
				<br>
				<input type="password" name="password" placeholder="Passwort"/><br>
				<br>
				<input type="submit" name="register" value="Registrieren"/>
			</form>
		</center>
<?php
require_once (dirname(__FILE__) . '/templates/footer.html');
?>
	</body>
</html>
