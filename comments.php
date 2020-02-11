<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/classes/post/Comment.php');

$api = new DatabaseAPI();
$pid = isset($_GET['pid']) && is_numeric($_GET['pid']) ? $_GET['pid'] : 0; // PID 0 does never exist
$post = $api->getPostByPID($pid);
$uid = $api->getUIDBySessionID(session_id());

$TITLE = $post != null ? "Kommentare zu Post #" . $post->getPID() : "Post nicht gefunden!";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

if ($post != null) {

	if (isset($_POST['text']) && !empty($_POST['text'])) {
		$text = $_POST['text'];
		$replyTo = [];
		$broken = explode(" ", $text);

		foreach ($broken as $part) {
			if ($part[0] == "@") {
				$user_f = $api->getUserByName(substr($part, 1));

				if ($user_f != null) {
					$replyTo[sizeof($replyTo)] = new CommentReply($user_f->getUID(), $part);
				}
			}
		}

		$api->postComment($pid, $uid, $replyTo, $text);

		if (isset($_POST['javascript']) && $_POST['javascript']) {
			header("Status: 204 No Content");
			die();
		}
	}

?>

		<form onsubmit="return sendForm('comment', function() { reload(); });" class="newcomment" method="POST" action="?pid=<?php echo $pid; ?>&from=<?php echo urlencode($_GET['from']); ?>" id="comment">
			<div class="post-category">Kommentieren</div><br>
			<input type="hidden" name="pid" value="<?php echo $pid; ?>">
			<textarea form="comment" name="text" autofocus><?php echo isset($_GET['to']) ? "@" . $_GET['to'] : ""; ?></textarea><br>
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

require_once (__DIR__ . '/templates/footer.html');
?>


