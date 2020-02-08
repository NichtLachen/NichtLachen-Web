<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$pid = isset($_GET['pid']) && is_numeric($_GET['pid']) ? $_GET['pid'] : 0; // PID 0 does never exist
$post = $api->getPostByPID($pid);

$TITLE = $post != null ? "Kommentare zu Post #" . $post->getPID() : "Post nicht gefunden!";

?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | <?php echo $TITLE; ?></title>
		<link rel="stylesheet" href="css/stylesheet.min.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
<?php
require_once (__DIR__ . '/templates/navbar_back.php');

if ($post != null) {
	$checkMore = function(int $page, int $perPage) : bool {
		global $api, $pid;
		return $api->moreComments($pid, $page, $perPage);
	};

	$getComments = function(int $page, int $perPage) : array {
		global $api, $pid;
		return $api->getComments($pid, $page, $perPage);
	};

	require_once (__DIR__ . '/templates/paged_comment_array.php');
} else {
	$ERROR = $TITLE;
	require (__DIR__ . '/templates/error.php');
}
?>
		</center>
<?php
require_once (__DIR__ . '/templates/footer.html');
?>
	</body>
</html>


