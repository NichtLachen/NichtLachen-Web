<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/classes/post/Comment.php');

$api = new DatabaseAPI();
$pid = isset($_GET['pid']) && is_numeric($_GET['pid']) ? $_GET['pid'] : 0; // PID 0 does never exist
$post = $api->getPostByPID($pid);
$uid = $api->getUIDBySessionID(session_id());
$comment_from = isset($_GET['from']) ? ("&from=" . urlencode($_GET['from'])) : "";

$TITLE = $post != null ? "Kommentare zu Post #" . $post->getPID() : "Post nicht gefunden!";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

if ($post != null) {

	if (isset($_POST['text']) && strlen($_POST['text']) > 0) {
		$text = $_POST['text'];
		$replyTo = [];
		$broken = explode(" ", $text);

		foreach ($broken as $part) {
			if (strlen($part) > 1) {
				if ($part[0] == "@") {
					$user_f = $api->getUserByName(substr($part, 1));

					if ($user_f != null) {
						$replyTo[sizeof($replyTo)] = new CommentReply($user_f->getUID(), $part);
					}
				}
			}
		}

		$api->postComment($pid, $uid, $replyTo, $text);

	}

require_once(__DIR__ . '/templates/post.php');

?>
		<br><br>
		<div class="center">
			<form class="default-form" method="POST" action="?pid=<?php echo $pid . $comment_from; ?>" id="comment">
				<div class="post-category">Kommentieren</div><br>
				<input type="hidden" name="pid" value="<?php echo $pid; ?>">
				<textarea style="width: 90%; height: 8em;" form="comment" name="text"><?php echo isset($_GET['to']) ? "@" . $_GET['to'] : ""; ?></textarea><br>
				<br>
				<input type="submit" class="button">
			</form>
		</div>
<?php
	$checkMore = function(int $page, int $perPage) : bool {
		global $api, $pid;
		return $api->moreComments($pid, $page, $perPage);
	};

	$getPosts = function(int $page, int $perPage) : array {
		global $api, $pid;
		return $api->getComments($pid, $page, $perPage);
	};

	require_once (__DIR__ . '/templates/paged_post_array.php');
} else {
	$ERROR = $TITLE;
	require (__DIR__ . '/templates/error.php');
}

require_once (__DIR__ . '/templates/footer.html');
?>


