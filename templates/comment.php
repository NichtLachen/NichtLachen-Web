<?php
require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/../classes/date/DateUtil.php');
require_once (__DIR__ . '/../include/htmlutils.php');

$api = new DatabaseAPI();
$user = $api->getUserByUID($comment->getCreatorUID());
$uid = $api->getUIDBySessionID(session_id());

$from = urlencode($_SERVER['REQUEST_URI'] . "#" . $comment->getCMTID());

$to = "";
if ($comment->getReplyTo() != null) {
	$replyTo = $api->getUserByUID($comment->getReplyTo());
	$to = "<a class=\"post-category\" href=\"users.php?uid=" . $replyTo->getUID() . "&from=" . $from . "\">@" . $replyTo->getName() . " </a>";
}

$color = $api->isCommentLikeSet($comment->getCMTID(), $uid, 1) ? "red" : "grey";
?>
		<div class="post" id="<?php echo $comment->getCMTID();?>">
			<a class="post-category" href="users.php?uid=<?php echo $user->getUID();?>&from=<?php echo $from; ?>"><?php echo $user->getName(); ?></a>
			<div class="post-info" style="display: inline;">vor <?php echo DateUtil::diff($comment->getCreatedAt()); ?></div>
			<br><br>
			<div class="post-content"><?php echo $to; ?><?php echo escapeHTML($comment->getContent()); ?></div>
			<br>
			<div class="post-like"><a href="like.php?like=1&cmtid=<?php echo $comment->getCMTID();?>&from=<?php echo $from; ?>"><i style="color: <?php echo $color; ?>" class="fas fa-heart"></i></a> <?php echo $api->countCommentLikes($comment->getCMTID());?></div>
		</div>
