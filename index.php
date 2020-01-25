<?php
$root = dirname(__FILE__);
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Willkommen</title>
		<link rel="stylesheet" href="/css/stylesheet.css"/>
	</head>
	<body style="background-color: yellow">
		<h1 style="font-family: Arial; background-color: orange; color: white">
			<center><br>Willkommen bei Nicht Lachen 2.0!<br><br></center>
		</h1>
		<center>
			<table style="font-family: Arial; background-color: orange; color: white">
				<tr>
					<td style="font-size: x-large; text-align: center">
						Melden Sie sich an:<br>
						<div class="container">
							<a href="login.php" class="button">Anmelden</a>
						</div>
						<br>
					</td>
				</tr>
				<tr>
					<td style="font-size: x-large; text-align: center">
						Oder registrieren Sie sich:<br>
						<div class="container">
							<a href="register.php" class="button">Registrieren</a>
						</div>
						<br>
					</td>
				</tr>
			</table>
		</center>
<?php
require_once ($root . '/templates/footer.html');
?>
	</body>
</html>


