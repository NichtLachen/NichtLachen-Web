<?php

require_once (dirname(__FILE__) . '/include/guestredirect.php');
require_once (dirname(__FILE__) . '/classes/db/DatabaseAPI.php');
require_once (dirname(__FILE__) . '/config.php');

$api = new DatabaseAPI();

$from = urlencode($_SERVER['REQUEST_URI']);

?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Kategorien</title>
		<link rel="stylesheet" href="/css/stylesheet.min.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
<?php
if (!isset($_GET['cid'])) {
	require_once (dirname(__FILE__) . '/templates/navbar.php');
?>

		<div class="categories">
			<br><br>
			<hr>
<?php

foreach ($api->getParentLessCategories() as $cat) {
	echo "<a href=\"?cid=" . $cat . "&from=" . $from . "\">" . $api->getCategoryName($cat) . "</a><br>";
	echo "<hr>";
}

?>
			<br><br>
<?php

foreach ($api->getSuperCategories() as $supercat) {
	echo "<div class=\"super\">" . $api->getCategoryName($supercat) . "</div><br>";
	echo "<hr>";

	foreach ($api->getSubCategories($supercat) as $cat) {
		echo "<a href=\"?cid=" . $cat . "&from=" . $from . "\">" . $api->getCategoryName($cat) . "</a><br>";
		echo "<hr>";
	}
	echo "<br><br>";
}

?>

		</div>

<?php
} else {
	$cid = $_GET['cid'];
	$name = $api->getCategoryName($cid);

	if ($name != null && !$api->isSuperCategory($cid)) {
		$TITLE = $name;
		require_once (dirname(__FILE__) . '/templates/navbar_back.php');

		$checkMore = function(int $page, int $perPage) : bool {
			global $api, $cid;
			return $api->moreNewCategoryPosts($cid, $page, $perPage);
		};

		$getPosts = function(int $page, int $perPage) : array {
			global $api, $cid;
			return $api->getNewCategoryPosts($cid, $page, $perPage);
		};

		require_once (dirname(__FILE__) . '/templates/paged_post_array.php');
	} else {
		$TITLE = "Kategorie nicht gefunden!";
		require_once (dirname(__FILE__) . '/templates/navbar_back.php');

		$ERROR = $TITLE;
		require (dirname(__FILE__) . '/templates/error.php');
	}
}

require_once (dirname(__FILE__) . '/templates/footer.html');
?>
	</body>
</html>


