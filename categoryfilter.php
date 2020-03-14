<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$TITLE = "Kategoriefilter";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$categoryfilterEnabled = isset($_POST['categoryfilter']) && $_POST['categoryfilter'];

	if ($categoryfilterEnabled) {
		$categoriesEnabled = [];

		foreach ($_POST as $key => $value) {
			if (strlen($key) >= strlen("cid_") && substr($key, 0, strlen("cid_")) == "cid_") {
				$categoriesEnabled[sizeof($categoriesEnabled)] = $value;
			}
		}

		if (sizeof($categoriesEnabled) > 0) {
			$api->deleteUserSettings($uid, "categoryfilter");
			$api->deleteUserSettings($uid, "filter_enabled_category");
			$api->addUserSetting($uid, "categoryfilter", "true");

			foreach ($categoriesEnabled as $cat) {
				$api->addUserSetting($uid, "filter_enabled_category", $cat);
			}
		} else {
			$ERROR = "Sie müssen mindestens eine Kategorie auswählen";
			require (__DIR__ . '/templates/error.php');
		}
	} else {
		$api->deleteUserSettings($uid, "categoryfilter");
	}
}

$categoryfilter = $api->getUserSettings($uid, "categoryfilter");
$categoryfilter = sizeof($categoryfilter) > 0 && $categoryfilter[0];
$enabledCategories = $api->getUserSettings($uid, "filter_enabled_category");

?>
		<div class="center">
			<form class="default-form" method="POST" id="post">
				<p class="center" style="width: 50%">Durch das Aktivieren des Kategoriefilters werden nur von Ihnen ausgewählte Kategorien im Top- und Neu-Bereich angezeigt.</p><br>
				Kategoriefilter <input type="checkbox" name="categoryfilter" value="true"<?php echo $categoryfilter ? " checked" : ""; ?>>
				<br><br>
				<?php
				foreach ($api->getAllSubCategories() as $category) {
					$categoryName = $api->getCategoryName($category);
					echo $categoryName . " <input type=\"checkbox\" name=\"cid_" . $category . "\" value=\"" . $category . "\"" . (in_array($category, $enabledCategories) ? " checked" : "") . "><br>\n\t\t\t\t";
				}
				?>				
				<br><br>
				<input type="submit" class="button">
			</form>
		</div>
<?php

require_once (__DIR__ . '/templates/footer.html');

?>
