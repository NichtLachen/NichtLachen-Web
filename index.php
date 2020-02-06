<?php

require_once (__DIR__ . '/include/loginredirect.php');

?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Willkommen</title>
		<link rel="stylesheet" href="/css/stylesheet.min.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
		<h1 class="h1" style="margin-top: 0%;">
			<center><br>Willkommen bei Nicht Lachen 2.0!<br><br></center>
		</h1>
		<center class="container" style="font-family: Arial; background-color: orange; color: white; border-radius: 8px;">
			<table>
				<tr>
					<td style="font-size: x-large; text-align: center;">
						Melden Sie sich an:<br>
						<br>
						<a href="login.php" class="button">Anmelden</a>
						<br>
					</td>
				</tr>
				<tr>
					<td style="font-size: x-large; text-align: center">
						Oder registrieren Sie sich:<br>
						<br>
						<a href="register.php" class="button">Registrieren</a>
						<br>
					</td>
				</tr>
			</table>
		</center>
<?php
require_once (__DIR__ . '/templates/footer.html');
?>
	</body>
</html>


