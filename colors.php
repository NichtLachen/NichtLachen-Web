<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$TITLE = "Farben";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());

$availableColors = array("colorPrimaryBackground", "colorPostBackground", "colorSecondaryBackground", "colorPrimaryHeading", "colorPrimaryText", "colorSecondaryText", "colorTextAdditionalInfo", "colorPrimarySeparator", "colorPrimaryError", "colorPrimarySuccess", "colorPrimaryLink");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$colors = [];

	if (isset($_POST['reset']) && $_POST['reset']) {
		foreach ($availableColors as $color) {
			$api->deleteUserSettings($uid, $color);
		}
	} else {
		foreach ($_POST as $key => $value) {
			if (strlen($key) >= strlen("color") && substr($key, 0, strlen("color")) == "color") {
				if (in_array($key, $availableColors)) {
					$api->deleteUserSettings($uid, $key);
					$api->addUserSetting($uid, $key, $value);
				}
			}
		}
	}
}

?>
		<div class="center" style="text-align: left; width: 70%; font-size: 14pt;">
			<p class="center" style="text-align: left;">Hier können Sie das Aussehen von NichtLachen 2.0 verändern.</p><br>
			<form class="default-form" method="POST" id="colors-reset">
				<input type="hidden" name="reset" value="true">
				<input type="submit" class="button" value="Farben zurücksetzen">
			</form>
			<form class="default-form" method="POST" id="colors">
				<?php
				foreach ($availableColors as $color) {
					switch($color) {
						case "colorPrimaryBackground":
							$name = "Primäre Hintergrundfarbe";
							$desc = "Standard Hintergrundfarbe";
							break;
						case "colorPostBackground":
							$name = "Post Hintergrundfarbe";
							$desc = "Hintergrundfarbe für Posts";
							break;
						case "colorSecondaryBackground":
							$name = "Sekundäre Hintergrundfarbe";
							$desc = "Alternative Hintergrundfarbe für z.B Navigationsleiste";
							break;
						case "colorPrimaryHeading":
							$name = "Primäre Überschriftenfarbe";
							$desc = "Standard Überschriftenfarbe";
							break;
						case "colorPrimaryText":
							$name = "Primäre Textfarbe";
							$desc = "Standard Textfarbe";
							break;
						case "colorSecondaryText":
							$name = "Sekundäre Textfarbe";
							$desc = "Alternative Textfarbe (für Text auf Elementen mit alternativer Hintergrundfarbe)";
							break;
						case "colorTextAdditionalInfo":
							$name = "Textfarbe für zusätzliche Informationen";
							$desc = "Farbe für zusätzliche Informationen zu Posts etc., z.B Ersteller des Posts";
							break;
						case "colorPrimarySeparator":
							$name = "Primäre Trennerfarbe";
							$desc = "Farbe für Trennstriche, z.B Kategorieübersicht";
							break;
						case "colorPrimaryError":
							$name = "Standard Fehlermeldungenfarbe";
							$desc = "Farbe für Fehlermeldungen (Hintergrundfarbe)";
							break;
						case "colorPrimarySuccess":
							$name = "Standard Erfolgsmeldungenfarbe";
							$desc = "Farbe für Erfolgsmeldungen (Hintergrundfarbe)";
							break;
						case "colorPrimaryLink":
							$name = "Standard Linkfarbe";
							$desc = "Farbe für Links und z.B \"Mehr anzeigen\"";
							break;
						default:
							$name = $color;
							$desc = "Für diese Farbe ist leider keine Beschreibung vorhanden";
							break;
					}

					echo "<input type=\"color\" name=\"" . $color . "\" value=\"" . getColor($color) . "\"> " . $name . "<br>\n\t\t\t\t" . $desc . "<br><br>\n\t\t\t\t";
				}
				?>				
				<br><br>
				<input type="submit" class="button" value="Speichern">
			</form>
		</div>
<?php

require_once (__DIR__ . '/templates/footer.php');

?>
