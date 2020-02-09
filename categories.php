<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();

$from = urlencode($_SERVER['REQUEST_URI']);

$TITLE = "Kategorien";
require_once (__DIR__ . '/templates/header.php');

if (!isset($_GET['cid'])) {
	require_once (__DIR__ . '/templates/navbar.php');
?>

		<div class="categories">
			<br><br>
			<hr>
<?php

foreach ($api->getParentLessCategories() as $cat) {
	echo "<a id=\"" . $cat . "\" href=\"?cid=" . $cat . "&from=" . $from . urlencode("#" . $cat) . "\">" . $api->getCategoryName($cat) . "</a><br>";
	echo "<hr>";
}

?>
			<br><br>
<?php

foreach ($api->getSuperCategories() as $supercat) {
	echo "<div class=\"super\">" . $api->getCategoryName($supercat) . "</div><br>";
	echo "<hr>";

	foreach ($api->getSubCategories($supercat) as $cat) {
		echo "<a id=\"" . $cat . "\" href=\"?cid=" . $cat . "&from=" . $from . urlencode("#" . $cat) . "\">" . $api->getCategoryName($cat) . "</a><br>";
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
		require_once (__DIR__ . '/templates/navbar_back_category.php');

		$checkMore = function(int $page, int $perPage) : bool {
			global $api, $cid;
			return $api->moreNewCategoryPosts($cid, $page, $perPage);
		};

		$getPosts = function(int $page, int $perPage) : array {
			global $api, $cid;
			return $api->getNewCategoryPosts($cid, $page, $perPage);
		};

		require_once (__DIR__ . '/templates/paged_post_array.php');
	} else {
		$TITLE = "Kategorie nicht gefunden!";
		require_once (__DIR__ . '/templates/navbar_back.php');

		$ERROR = $TITLE;
		require (__DIR__ . '/templates/error.php');
	}
}

require_once (__DIR__ . '/templates/footer.html');
?>

