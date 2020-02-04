<?php

require_once (dirname(__FILE__) . '/include/guestredirect.php');
require_once (dirname(__FILE__) . '/classes/db/DatabaseAPI.php');
require_once (dirname(__FILE__) . '/config.php');

$api = new DatabaseAPI();

?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Kategorien</title>
		<link rel="stylesheet" href="/css/stylesheet.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
<?php
require_once (dirname(__FILE__) . '/templates/navbar.php');
?>

		<div class="categories">
			<br><br>
			<hr>
<?php

foreach ($api->getParentLessCategories() as $cat) {
	echo "<a href=\"?cid=" . $cat . "\">" . $api->getCategoryName($cat) . "</a><br>";
	echo "<hr>";
}

?>
			<br><br>
<?php

foreach ($api->getSuperCategories() as $supercat) {
	echo "<div class=\"super\">" . $api->getCategoryName($supercat) . "</div><br>";
	echo "<hr>";

	foreach ($api->getSubCategories($supercat) as $cat) {
		echo "<a href=\"?cid=" . $cat . "\">" . $api->getCategoryName($cat) . "</a><br>";
		echo "<hr>";
	}
	echo "<br><br>";
}

?>

		</div>

<?php
require_once (dirname(__FILE__) . '/templates/footer.html');
?>
	</body>
</html>


