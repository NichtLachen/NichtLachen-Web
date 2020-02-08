<?php
require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/../classes/date/DateUtil.php');
require_once (__DIR__ . '/../include/htmlutils.php');

$api = new DatabaseAPI();
$user = $api->getUserByUID($comment->getCreatorUID());
$uid = $api->getUIDBySessionID(session_id());

$to = "";
if ($comment->getReplyTo() != null) {
	$replyTo = $api->getUserByUID($comment->getReplyTo());
	$to = "<a class=\"post-category\" href=\"users.php?uid=" . $replyTo->getUID() . "\">@" . $replyTo->getName() . " </a>";
}

$from = urlencode($_SERVER['REQUEST_URI'] . "#" . $comment->getCMTID());
?>
		<div class="post" id="<?php echo $comment->getCMTID();?>">
			<a class="post-category" href="users.php?uid=<?php echo $user->getUID();?>&from=<?php echo $from; ?>"><?php echo $user->getName(); ?></a>
			<div class="post-info" style="display: inline;">vor <?php echo DateUtil::diff($comment->getCreatedAt()); ?></div>
			<div class="post-content"><?php echo $to; ?><?php echo escapeHTML($comment->getContent()); ?></div>
			<br>
			<div class="post-dislike"><a href="like.php?like=1&cmtid=<?php echo $comment->getCMTID();?>&from=<?php echo $from; ?>"><i class="far fa-heart"></i></a> <?php echo $api->countPostLikes($post->getPID());?></div>
		</div>
