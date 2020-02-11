<?php
require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/../classes/date/DateUtil.php');
require_once (__DIR__ . '/../include/htmlutils.php');
require_once (__DIR__ . '/../include/varutils.php');
require_once (__DIR__ . '/../include/stringutils.php');

$api = new DatabaseAPI();
$user = $api->getUserByUID($comment->getCreatorUID());
$uid = $api->getUIDBySessionID(session_id());

$lastid = isset($last_comment) ? $last_comment->getCMTID() : 0; // 0 does never exist
$last_comment = $comment;

$from = urlencode($_SERVER['REQUEST_URI'] . "#" . $comment->getCMTID() . "end");
$from_before = urlencode($_SERVER['REQUEST_URI'] . '#' . $comment->getCMTID());
$from_delete = urlencode($_SERVER['REQUEST_URI'] . '#' . $lastid . "end");

$content = escapeHTML($comment->getContent());

foreach($comment->getReplyTo() as $replyTo) {
	$userTo = $api->getUserByUID($replyTo->getReplyTo());
	$to = "<a class=\"post-category\" href=\"users.php?uid=" . $replyTo->getReplyTo() . "&from=" . $from . "\">@" . $userTo->getName() . "</a>";

	$content = preg_replace($replyTo->getReplaceValue(), $to, $content, 1);
}

$content = formatText($content);

$content = splitTextAtLength($content, 800);

$color = $api->isCommentLikeSet($comment->getCMTID(), $uid, 1) ? "red" : "grey";
?>
		<div class="post" id="<?php echo $comment->getCMTID();?>">
			<a class="post-category" href="users.php?uid=<?php echo $user->getUID();?>&from=<?php echo $from_before; ?>"><?php echo $user->getName(); ?></a>
			<div class="post-info" style="display: inline;">vor <?php echo DateUtil::diff($comment->getCreatedAt()); ?></div>
			<br><br>
			<div class="post-content"><?php echo $content[0]; if (!empty($content[1])) { ?><input type="checkbox" class="showMore" id="showMore<?php echo $comment->getCMTID(); ?>"><label for="showMore<?php echo $comment->getCMTID();?>" id="showMoreL<?php echo $comment->getCMTID(); ?>">Mehr anzeigen <i class="fa fa-arrow-down" aria-hidden="true"></i></label><div for="showMoreL<?php echo $comment->getCMTID(); ?>"><?php echo $content[1]; ?></div><?php } ?></div>
			<br>
			<a id="<?php echo $comment->getCMTID(); ?>end" class="post-info" style="display: inline; text-decoration: none;" href="<?php echo hrefReplaceVar("to", $user->getName()); ?>">Antworten</a>
			<div class="post-like"><a onclick="return callURLWithReload('like.php?like=1&cmtid=<?php echo $comment->getCMTID();?>');" href="like.php?like=1&cmtid=<?php echo $comment->getCMTID();?>&from=<?php echo $from; ?>"><i style="color: <?php echo $color; ?>" class="fas fa-heart"></i></a> <?php echo $api->countCommentLikes($comment->getCMTID());?></div>

<?php
if ($comment->getCreatorUID() == $uid) {
	$delid = $comment->getCMTID();
	$delete_js = "delete.php?cmtid=" . $comment->getCMTID();
	$delete = "delete.php?cmtid=" . $comment->getCMTID() . "&from=" . $from_delete;
?>
			<input type="checkbox" class="showMore" id="delete<?php echo $comment->getCMTID(); ?>">
			<label class="post-delete" for="delete<?php echo $comment->getCMTID(); ?>" style="display: visible; color: red;"><i class="fas fa-trash-alt"></i></label>
<?php
	require (__DIR__ . '/../templates/delete_confirm.php');
}
?>
		</div>
