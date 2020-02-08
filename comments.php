<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$pid = isset($_GET['pid']) && is_numeric($_GET['pid']) ? $_GET['pid'] : 0; // PID 0 does never exist
$post = $api->getPostByPID($pid);
$uid = $api->getUIDBySessionID(session_id());

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

	if (isset($_POST['text'])) {
		$text = $_POST['text'];
		$broken = explode(" ", $text);

		if($broken[0][0] == "@") {
			$user_f = $api->getUserByName(substr($broken[0], 1));
			$uid_f = $user_f != null ? $user_f->getUID() : null;
		} else {
			$uid_f = null;
		}

		if(isset($uid_f) && $uid_f != null) {
			$text = substr($text, strlen($broken[0]));
		}

		if (!empty($text)) {
			$api->postComment($pid, $uid, $uid_f, $text);
		}
	}

?>

		<form class="newcomment" method="POST" action="?pid=<?php echo $pid; ?>&from=<?php echo urlencode($_GET['from']); ?>" id="comment">
			<div class="post-category">Kommentieren</div><br>
			<input type="hidden" name="pid" value="<?php echo $pid; ?>">
			<textarea form="comment" name="text" autofocus></textarea><br>
			<br>
			<input type="submit" class="button">
		</form>
<?php
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


