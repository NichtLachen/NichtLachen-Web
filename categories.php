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
} else {
	$cid = $_GET['cid'];
	$name = $api->getCategoryName($cid);
	$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

	$prev = $page > 1 ? " href=\"" . $_SERVER['PHP_SELF'] . "?cid=" . $cid . "&page=" . ($page - 1) . "\"": "";
	$prevNum = $page > 1 ? '<a href="' . $_SERVER['PHP_SELF'] . '?cid=' . $cid . '&page=' . ($page - 1) . '">' . ($page - 1) . '</a>' : "";
	$next = $api->moreNewCategoryPosts($cid, $page, POSTS_PER_PAGE) ? " href=\"" . $_SERVER['PHP_SELF'] . "?cid=" . $cid . "&page=" . ($page + 1) . "\"" : "";
	$nextNum = !empty($next) ? '<a href="' . $_SERVER['PHP_SELF'] . '?cid=' . $cid . '&page=' . ($page + 1) . '">' . ($page + 1) . '</a>' : "";

	if ($name != null && !$api->isSuperCategory($cid)) {
		$TITLE = $name;
		require_once (dirname(__FILE__) . '/templates/navbar_back.php');

		$posts = $api->getNewCategoryPosts($cid, $page, POSTS_PER_PAGE);
		require (dirname(__FILE__) . '/templates/post_array.php');

		require_once (dirname(__FILE__) . '/templates/prevnext.php');
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


