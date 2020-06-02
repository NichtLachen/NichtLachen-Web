<?php
require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/../classes/date/DateUtil.php');
require_once (__DIR__ . '/../include/htmlutils.php');
require_once (__DIR__ . '/../include/varutils.php');
require_once (__DIR__ . '/../include/stringutils.php');
require_once (__DIR__ . '/../config.php');

$api = new DatabaseAPI();
$category = $api->getCategoryName($post->getCID());
$user = $api->getUserByUID($post->getCreatorUID());
$uid = $api->getUIDBySessionID(session_id());
$pid = $post->getPID();
$likeColor = "green";
$likeIcon = "fa-thumbs-up";
$pidStr = "pid";

$isComment = $post instanceof Comment;

if ($isComment) {
	$parent_post = $api->getPostByPID($pid);

	$cmtid = $post->getCMTID();
	$likeColor = $api->isCommentLikeSet($post->getCMTID(), $uid, 1) ? "red" : "grey";
	$likeIcon = "fa-heart";
	$pidStr = "cmtid";

	$anoninfo = in_array($post->getCID(), ANONYMOUS_CATEGORIES) && $parent_post->getCreatorUID() == $post->getCreatorUID() ? "Vor" : "vor";
	$anonreply = in_array($post->getCID(), ANONYMOUS_CATEGORIES) && $parent_post->getCreatorUID() == $post->getCreatorUID() ? "" : "<a id=\"". $post->getCMTID() . "end\" class=\"post-info\" style=\"display: inline; text-decoration: none;\" href=\"" . hrefReplaceVar("to", $user->getName()) . "\">Antworten</a>";
}

$dislike = $api->isLikeSet($post->getPID(), $uid, -1) ? "fas" : "far";
$like = $api->isLikeSet($post->getPID(), $uid, 1) || $isComment ? "fas" : "far";

$lastid = isset($last_post) ? $last_post->getPID() : 0; // 0 does never exist
$last_post = $post;

$from = urlencode($_SERVER['REQUEST_URI'] . "#" . $post->getPID() . "end");
$from_before = urlencode($_SERVER['REQUEST_URI'] . '#' . $post->getPID());
$from_delete = urlencode($_SERVER['REQUEST_URI'] . '#' . $lastid . "end");

$posted_by = in_array($post->getCID(), ANONYMOUS_CATEGORIES) && ($uid != $user->getUID() && (!$isComment || $parent_post->getCreatorUID() == $post->getCreatorUID())) ? "" : ($isComment ? "" : " von ") . "<a class=\"post-category\" href=\"users.php?uid=" . $user->getUID() . "&from=" .  $from . "\">" . $user->getName() . "</a> ";

$date = "vor " . DateUtil::diff($post->getCreatedAt());

$content = escapeHTML($post->getContent());

if ($isComment) {
	foreach($post->getReplyTo() as $replyTo) {
		$userTo = $api->getUserByUID($replyTo->getReplyTo());
		$to = "<a class=\"post-category\" href=\"users.php?uid=" . $replyTo->getReplyTo() . "&from=" . $from . "\">@" . $userTo->getName() . "</a>";

		$content = str_replace_first($replyTo->getReplaceValue(), $to, $content, 1);
	}
}

$content = formatText($content);

$content = splitTextAtLength($content, 800);

?>
		<div class="post" id="<?php echo $post->getPID();?>">
<?php
if ($isComment) {
	echo $posted_by;
?>
			<div class="post-info" style="display: inline;"><?php echo $anoninfo . " " . DateUtil::diff($post->getCreatedAt()); ?></div>
<?php
} else {
?>
			<a class="post-category" href="categories.php?cid=<?php echo $post->getCID();?>&from=<?php echo $from_before; ?>"><?php echo $category; ?></a>
<?php
}
?>
			<br><br>
			<div class="post-content"><?php
				echo $content[0];

				if (strlen($content[1]) > 0) {
					?><input type="checkbox" class="showMore" id="showMore_<?php echo $post->getPID(); ?>"><label for="showMore_<?php echo $post->getPID();?>" id="showMoreL_<?php echo $post->getPID(); ?>">Mehr anzeigen <i class="fa fa-arrow-down" aria-hidden="true"></i></label><div for="showMoreL_<?php echo $post->getPID(); ?>"><?php
					echo $content[1]; ?></div><?php
				} ?></div>
<?php
if (!isset($queue) || !$queue) {
	if (!$isComment) {
?>

			<p id="<?php echo $post->getPID(); ?>end" class="post-info">Eingereicht <?php echo $posted_by; ?><?php echo $date; ?></p>
<?php
	} else {
?>
			<br>
<?php
			echo $anonreply;
	}
?>
			<div class="post-control post-like"><a onclick="return callURLWithReload('api/like.php?like=1&<?php echo $pidStr . "=" . ($isComment ? $post->getCMTID() : $post->getPID());?>');" href="api/like.php?like=1&pid=<?php echo $post->getPID();?>&from=<?php echo $from; ?>"><i class="<?php echo $like . " " . $likeIcon; ?>" style="color: <?php echo $likeColor; ?>"></i></a> <?php echo $api->countPostLikes($post->getPID());?></div>
<?php
	if (!$isComment) {
?>
			<div class="post-control post-dislike"><a onclick="return callURLWithReload('api/like.php?like=-1&pid=<?php echo $post->getPID();?>');" href="api/like.php?like=-1&pid=<?php echo $post->getPID();?>&from=<?php echo $from; ?>"><i class="<?php echo $dislike; ?> fa-thumbs-down"></i></a> <?php echo $api->countPostDislikes($post->getPID());?></div>
<?php
$comment_style = isset($comment_from) ? ' style="visibility: hidden;"' : "";
?>
			<div class="post-control post-comments"<?php echo $comment_style; ?>><a href="comments.php?pid=<?php echo $post->getPID(); ?>&from=<?php echo $from; ?>"><i class="fas fa-comments"></i></a> <?php echo $api->countPostComments($post->getPID());?></div>
			<div class="post-control post-fav<?php echo $api->isFavSet($post->getPID(), $uid) ? " active" : "";?>"><a onclick="return callURLWithReload('api/fav.php?pid=<?php echo $post->getPID();?>');" href="api/fav.php?pid=<?php echo $post->getPID();?>&from=<?php echo $from;?>"><i class="fas fa-star"></i></a></div>
			<div class="post-control post-fav"><a href="" onclick="return share('https://' + location.host + '/comments.php?pid=<?php echo $post->getPID(); ?>')"><i class="fas fa-share-alt"></i></a></div>
<?php
	}
} else {
// will never be reached with comment

$accepts = $api->getPostQueueAccepts($post->getPID());
?>
			<br>
			<div class="post-control post-like"><a onclick="return callURLWithReload('api/accept.php?accept=1&pid=<?php echo $post->getPID(); ?>');" href="api/accept.php?accept=1&pid=<?php echo $post->getPID(); ?>&from=<?php echo $from_delete; ?>"><i class="fas fa-check"></i></a></div>
			<div class="post-control post-dislike"><a onclick="return callURLWithReload('api/accept.php?accept=-1&pid=<?php echo $post->getPID(); ?>');" href="api/accept.php?accept=-1&pid=<?php echo $post->getPID(); ?>&from=<?php echo $from_delete; ?>"><i class="fas fa-times"></i></a></div>
			<div class="post-control <?php echo $accepts >= 0 ? 'post-like' : 'post-dislike'; ?>"><?php echo $accepts; ?></div>
<?php
}

if ($post->getCreatorUID() == $uid) {
	$delName = $isComment ? "Kommentar" : "Post";
	$delid = $isComment ? $post->getCMTID() : $post->getPID();
	$q = isset($queue) && $queue ? "1" : "0";
	$delete_js = "api/delete.php?" . $pidStr . "=" . $delid . "&queue=" . $q;
	$delete = $delete_js . "&from=" . $from_delete;
?>
			<input type="checkbox" class="showMore" id="delete<?php echo $delid; ?>">
			<label class="post-control post-delete" for="delete<?php echo $delid; ?>" style="color: red;"><i class="fas fa-trash-alt"></i></label>
<?php
	require (__DIR__ . '/../templates/delete_confirm.php');
} else if (!isset($queue) || !$queue) {
	$repid = $isComment ? $post->getCMTID() : $post->getPID();
	$rep = "report.php?" . $pidStr . "=" . $repid . "&from=" . $from;
?>
	<div class="post-control post-delete report"><a href="<?php echo $rep; ?>"><i class="fas fa-exclamation-triangle"></i></a></div>
<?php
}
?>
		</div>
