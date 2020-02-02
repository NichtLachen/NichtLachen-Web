<?php

require_once (dirname(__FILE__) . '/include/guestredirect.php');
require_once (dirname(__FILE__) . '/classes/db/DatabaseAPI.php');
require_once (dirname(__FILE__) . '/config.php');

$api = new DatabaseAPI();
$uid = isset($_GET['uid']) && is_numeric($_GET['uid']) ? $_GET['uid'] : 0; // UID 0 does never exist
$user = $api->getUserByUID($uid);

$TITLE = $user != null ? "Beiträge von " . $user->getName() : "Benutzer nicht gefunden!";

if ($user != null) {
	$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

	$prev = $page > 1 ? " href=\"" . $_SERVER['PHP_SELF'] . "?uid=$uid&page=" . ($page - 1) . "\"": "";
	$prevNum = $page > 1 ? '<a href="' . $_SERVER['PHP_SELF'] . '?uid=' . $uid . '&page=' . ($page - 1) . '">' . ($page - 1) . '</a>' : "";
	$next = $api->moreUserPosts($uid, $page, POSTS_PER_PAGE) ? " href=\"" . $_SERVER['PHP_SELF'] . "?uid=$uid&page=" . ($page + 1) . "\"" : "";
	$nextNum = !empty($next) ? '<a href="' . $_SERVER['PHP_SELF'] . '?uid=' . $uid . '&page=' . ($page + 1) . '">' . ($page + 1) . '</a>' : "";
}

?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | <?php echo $TITLE; ?></title>
		<link rel="stylesheet" href="/css/stylesheet.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
<?php
require_once (dirname(__FILE__) . '/templates/navbar_back.php');
?>
<?php
if ($user != null) {
	$posts = $api->getUserPosts($uid, $page, POSTS_PER_PAGE);
	include (dirname(__FILE__) . '/templates/post_array.php');

	require_once (dirname(__FILE__) . '/templates/prevnext.php');
}
?>
		</center>
<?php
require_once (dirname(__FILE__) . '/templates/footer.html');
?>
	</body>
</html>


