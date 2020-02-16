<?php

require_once (__DIR__ . '/include/loginredirect.php');

$TITLE = "Willkommen";

require_once (__DIR__ . '/templates/header.php');
?>
		<h1 class="h1" style="margin-top: 0%;">
			<center><br>Willkommen bei Nicht Lachen 2.0!<br><br></center>
		</h1>
		<div class="center" style="font-family: Arial; background-color: orange; color: white; border-radius: 8px;">
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
		</div>
<?php
require_once (__DIR__ . '/templates/footer.html');
?>


