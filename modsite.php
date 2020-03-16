<?php

require_once (__DIR__ . '/include/guestredirect.php');

$TITLE = "Moderation & Administration";
require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

?>
		<div class="flexbox">
			<div class="flexbox-column">
				Hier kommen gemeldete Beiträge hin. <br> Diese Spalte kann man beliebig verlängern.
			</div>
			<div class="flexbox-column">
				Hier kommen gemeldete Kommentare hin. <br> Diese Spalte kann man beliebig verlängern.
			</div>
			<div class="flexbox-column">
				Hier kommen gemeldete User hin. <br> Diese Spalte kann man beliebig verlängern.
			</div>
		</div>
<?php

require_once (__DIR__ . '/templates/footer.html');

?>
