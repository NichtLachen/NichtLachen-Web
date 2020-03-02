<?php
require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/../classes/date/DateUtil.php');
require_once (__DIR__ . '/../include/htmlutils.php');
require_once (__DIR__ . '/../include/stringutils.php');
require_once (__DIR__ . '/../config.php');

$api = new DatabaseAPI();
$category = $api->getCategoryName($post->getCID());
$user = $api->getUserByUID($post->getCreatorUID());
$uid = $api->getUIDBySessionID(session_id());

$dislike = $api->isLikeSet($post->getPID(), $uid, -1) ? "fas" : "far";
$like = $api->isLikeSet($post->getPID(), $uid, 1) ? "fas" : "far";

$lastid = isset($last_post) ? $last_post->getPID() : 0; // 0 does never exist
$last_post = $post;

$from = urlencode($_SERVER['REQUEST_URI'] . "#" . $post->getPID() . "end");
$from_before = urlencode($_SERVER['REQUEST_URI'] . '#' . $post->getPID());
$from_delete = urlencode($_SERVER['REQUEST_URI'] . '#' . $lastid . "end");

$posted_by = in_array($post->getCID(), ANONYMOUS_CATEGORIES) ? "" : "von <a href=\"users.php?uid=" . $user->getUID() . "&from=" .  $from . "\">" . $user->getName() . "</a> ";

$content = formatText(escapeHTML($post->getContent()));

$content = splitTextAtLength($content, 800);

?>
		<div class="post" id="<?php echo $post->getPID();?>">
			<a class="post-category" href="categories.php?cid=<?php echo $post->getCID();?>&from=<?php echo $from_before; ?>"><?php echo $category; ?></a>
			<br><br>
			<div class="post-content"><?php
				echo $content[0];

				if (!empty($content[1])) {
					?><input type="checkbox" class="showMore" id="showMore_<?php echo $post->getPID(); ?>"><label for="showMore_<?php echo $post->getPID();?>" id="showMoreL_<?php echo $post->getPID(); ?>">Mehr anzeigen <i class="fa fa-arrow-down" aria-hidden="true"></i></label><div for="showMoreL_<?php echo $post->getPID(); ?>"><?php
					echo $content[1]; ?></div><?php
				} ?></div>
<?php
if (!isset($queue) || !$queue) {
?>

			<p id="<?php echo $post->getPID(); ?>end" class="post-info">Eingereicht <?php echo $posted_by; ?>vor <?php echo DateUtil::diff($post->getCreatedAt()); ?></p>
			<div class="post-control post-like"><a onclick="return callURLWithReload('like.php?like=1&pid=<?php echo $post->getPID();?>');" href="like.php?like=1&pid=<?php echo $post->getPID();?>&from=<?php echo $from; ?>"><i class="<?php echo $like; ?> fa-thumbs-up"></i></a> <?php echo $api->countPostLikes($post->getPID());?></div>
			<div class="post-control post-dislike"><a onclick="return callURLWithReload('like.php?like=-1&pid=<?php echo $post->getPID();?>');" href="like.php?like=-1&pid=<?php echo $post->getPID();?>&from=<?php echo $from; ?>"><i class="<?php echo $dislike; ?> fa-thumbs-down"></i></a> <?php echo $api->countPostDislikes($post->getPID());?></div>
			<div class="post-control post-comments"><a href="comments.php?pid=<?php echo $post->getPID(); ?>&from=<?php echo $from; ?>"><i class="fas fa-comments"></i></a> <?php echo $api->countPostComments($post->getPID());?></div>
			<div class="post-control post-fav<?php echo $api->isFavSet($post->getPID(), $uid) ? " active" : "";?>"><a onclick="return callURLWithReload('fav.php?pid=<?php echo $post->getPID();?>');" href="fav.php?pid=<?php echo $post->getPID();?>&from=<?php echo $from;?>"><i class="fas fa-star"></i></a></div>
<?php
} else {

$accepts = $api->getPostQueueAccepts($post->getPID());
?>
			<br>
			<div class="post-control post-like"><a onclick="return callURLWithReload('accept.php?accept=1&pid=<?php echo $post->getPID(); ?>');" href="accept.php?accept=1&pid=<?php echo $post->getPID(); ?>&from=<?php echo $from_delete; ?>"><i class="fas fa-check"></i></a></div>
			<div class="post-control post-dislike"><a onclick="return callURLWithReload('accept.php?accept=-1&pid=<?php echo $post->getPID(); ?>');" href="accept.php?accept=-1&pid=<?php echo $post->getPID(); ?>&from=<?php echo $from_delete; ?>"><i class="fas fa-times"></i></a></div>
			<div class="post-control <?php echo $accepts >= 0 ? 'post-like' : 'post-dislike'; ?>"><?php echo $accepts; ?></div>
<?php
}

if ($post->getCreatorUID() == $uid) {
	$delid = $post->getPID();
	$q = isset($queue) && $queue ? "1" : "0";
	$delete_js = "delete.php?pid=" . $delid . "&queue=" . $q;
	$delete = $delete_js . "&from=" . $from_delete;
?>
			<input type="checkbox" class="showMore" id="delete<?php echo $delid; ?>">
			<label class="post-control post-delete" for="delete<?php echo $delid; ?>" style="color: red;"><i class="fas fa-trash-alt"></i></label>
<?php
	require (__DIR__ . '/../templates/delete_confirm.php');
} else {
	$repid = $post->getPID();
	$q = isset($queue) && $queue ? "1" : "0";
	$rep_js = "report.php?pid=" . $repid . "&queue=" . $q;
	$rep = $rep_js . "&from=" . $from;
?>
<!-- TODO: REPORT -->
<?php
}
?>
		</div>
