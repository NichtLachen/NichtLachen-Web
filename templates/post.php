<?php
require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/../classes/date/DateUtil.php');
require_once (__DIR__ . '/../include/htmlutils.php');
require_once (__DIR__ . '/../include/stringutils.php');

$api = new DatabaseAPI();
$category = $api->getCategoryName($post->getCID());
$user = $api->getUserByUID($post->getCreatorUID());
$uid = $api->getUIDBySessionID(session_id());

$dislike = $api->isLikeSet($post->getPID(), $uid, -1) ? "fas" : "far";
$like = $api->isLikeSet($post->getPID(), $uid, 1) ? "fas" : "far";

$from = urlencode($_SERVER['REQUEST_URI'] . "#" . $post->getPID() . "_end");
$from_before = urlencode($_SERVER['REQUEST_URI'] . '#' . $post->getPID());

$content = splitTextAtLength(escapeHTML($post->getContent()), 800);

?>
		<div class="post" id="<?php echo $post->getPID();?>">
			<a class="post-category" href="categories.php?cid=<?php echo $post->getCID();?>&from=<?php echo $from_before; ?>"><?php echo $category; ?></a>
			<br><br>
			<div class="post-content"><?php echo $content[0]; if (!empty($content[1])) { ?><input type="checkbox" class="showMore" id="showMore_<?php echo $post->getPID(); ?>"><label for="showMore_<?php echo $post->getPID();?>" id="showMoreL_<?php echo $post->getPID(); ?>">Mehr anzeigen <i class="fa fa-arrow-down" aria-hidden="true"></i></label><div for="showMoreL_<?php echo $post->getPID(); ?>"><?php echo $content[1]; ?></div><?php } ?></div>
<?php
if (!isset($queue) || !$queue) {
?>

			<p id="<?php echo $post->getPID(); ?>_end" class="post-info">Eingereicht von <a href="users.php?uid=<?php echo $user->getUID();?>&from=<?php echo $from; ?>"><?php echo $user->getName();?></a> vor <?php echo DateUtil::diff($post->getCreatedAt()); ?></p>
			<div class="post-like"><a href="like.php?like=1&pid=<?php echo $post->getPID();?>&from=<?php echo $from; ?>"><i class="<?php echo $like; ?> fa-thumbs-up"></i></a> <?php echo $api->countPostLikes($post->getPID());?></div>
			<div class="post-dislike"><a href="like.php?like=-1&pid=<?php echo $post->getPID();?>&from=<?php echo $from; ?>"><i class="<?php echo $dislike; ?> fa-thumbs-down"></i></a> <?php echo $api->countPostDislikes($post->getPID());?></div>
			<div class="post-comments"><a href="comments.php?pid=<?php echo $post->getPID(); ?>&from=<?php echo $from; ?>"><i class="fas fa-comments"></i></a> <?php echo $api->countPostComments($post->getPID());?></div>
			<div class="post-fav<?php echo $api->isFavSet($post->getPID(), $uid) ? " active" : "";?>"><a href="fav.php?pid=<?php echo $post->getPID();?>&from=<?php echo $from;?>"><i class="fas fa-star"></i></a></div>
<?php
} else {

$accepts = $api->getPostQueueAccepts($post->getPID());
?>
			<br>
			<div class="post-like"><a href="accept.php?accept=1&pid=<?php echo $post->getPID(); ?>&from=<?php echo $from; ?>"><i class="fas fa-check"></i></a></div>
			<div class="post-dislike"><a href="accept.php?accept=-1&pid=<?php echo $post->getPID(); ?>&from=<?php echo $from; ?>"><i class="fas fa-times"></i></a></div>
			<div class="<?php echo $accepts >= 0 ? 'post-like' : 'post-dislike'; ?>"><?php echo $accepts; ?></div>
<?php
}
?>
		</div>
