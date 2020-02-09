<?php
require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/../classes/date/DateUtil.php');
require_once (__DIR__ . '/../include/htmlutils.php');
require_once (__DIR__ . '/../include/varutils.php');
require_once (__DIR__ . '/../include/stringutils.php');

$api = new DatabaseAPI();
$user = $api->getUserByUID($comment->getCreatorUID());
$uid = $api->getUIDBySessionID(session_id());

$from = urlencode($_SERVER['REQUEST_URI'] . "#" . $comment->getCMTID() . "_end");
$from_before = urlencode($_SERVER['REQUEST_URI'] . '#' . $comment->getCMTID());

$content = splitTextAtLength(escapeHTML($comment->getContent()), 800);

$to = "";
if ($comment->getReplyTo() != null) {
	$replyTo = $api->getUserByUID($comment->getReplyTo());
	$to = "<a class=\"post-category\" href=\"users.php?uid=" . $replyTo->getUID() . "&from=" . $from . "\">@" . $replyTo->getName() . " </a>";
}

$color = $api->isCommentLikeSet($comment->getCMTID(), $uid, 1) ? "red" : "grey";
?>
		<div class="post" id="<?php echo $comment->getCMTID();?>">
			<a class="post-category" href="users.php?uid=<?php echo $user->getUID();?>&from=<?php echo $from_before; ?>"><?php echo $user->getName(); ?></a>
			<div class="post-info" style="display: inline;">vor <?php echo DateUtil::diff($comment->getCreatedAt()); ?></div>
			<br><br>
			<div class="post-content"><?php echo $to . " " . $content[0]; if (!empty($content[1])) { ?><input type="checkbox" class="showMore" id="showMore_<?php echo $comment->getCMTID(); ?>"><label for="showMore_<?php echo $comment->getCMTID();?>" id="showMoreL_<?php echo $comment->getCMTID(); ?>">Mehr anzeigen <i class="fa fa-arrow-down" aria-hidden="true"></i></label><div for="showMoreL_<?php echo $comment->getCMTID(); ?>"><?php echo $content[1]; ?></div><?php } ?></div>
			<br>
			<a id="<?php echo $comment->getCMTID(); ?>_end" class="post-info" style="display: inline; text-decoration: none;" href="<?php echo hrefReplaceVar("to", $user->getName()); ?>">Antworten</a>
			<div class="post-like"><a href="like.php?like=1&cmtid=<?php echo $comment->getCMTID();?>&from=<?php echo $from; ?>"><i style="color: <?php echo $color; ?>" class="fas fa-heart"></i></a> <?php echo $api->countCommentLikes($comment->getCMTID());?></div>

<?php
if ($comment->getCreatorUID() == $uid) {
?>			<div class="post-delete"><a href="delete.php?cmtid=<?php echo $comment->getCMTID(); ?>&from=<?php echo $from; ?>"><i class="fas fa-trash-alt"></i></a></div>
<?php
}
?>
		</div>
