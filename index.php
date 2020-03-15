<?php

require_once (__DIR__ . '/include/loginredirect.php');

$TITLE = "Willkommen";

require_once (__DIR__ . '/templates/header.php');
?>
		<h1 class="h1" style="margin-top: 0%;">
			<center><br>Willkommen bei Nicht Lachen 2.0!<br><br></center>
		</h1>
		<div class="center" style="font-family: Arial; background-color: #ff9900; color: var(--colorSecondaryText); border-radius: 8px; width: 15em; font-size: x-large; margin-top: 6em; padding: 1em;">
			Melden Sie sich an:<br>
			<br>
			<a href="login.php" class="button">Anmelden</a>
			<br>
			Oder registrieren Sie sich:<br>
			<br>
			<a href="register.php" class="button">Registrieren</a>
			<br>
		</div>
<?php
require_once (__DIR__ . '/templates/footer.html');
?>


