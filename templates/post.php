<?php
require_once (dirname(__FILE__) . '/../classes/db/DatabaseAPI.php');
require_once (dirname(__FILE__) . '/../classes/date/DateUtil.php');
require_once (dirname(__FILE__) . '/../include/htmlutils.php');

$api = new DatabaseAPI();
$category = $api->getCategoryName($post->getCID());
$user = $api->getUserByUID($post->getCreatorUID());
$uid = $api->getUIDBySessionID(session_id());

$from = urlencode($_SERVER['REQUEST_URI'] . "#" . $post->getPID());
?>
		<div class="post" id="<?php echo $post->getPID();?>">
			<a class="post-category" href="categories.php?cid=<?php echo $post->getCID();?>&from=<?php echo $from; ?>"><?php echo $category; ?></a>
			<div class="post-content"><?php echo escapeHTML($post->getContent()); ?></div>
			<p class="post-info">Eingereicht von <a href="users.php?uid=<?php echo $user->getUID();?>&from=<?php echo $from; ?>"><?php echo $user->getName();?></a> vor <?php echo DateUtil::diff($post->getCreatedAt()); ?></p>
			<div class="post-like"><a href="like.php?like=1&pid=<?php echo $post->getPID();?>&from=<?php echo $from; ?>"><i class="far fa-thumbs-up"></i></a> <?php echo $api->countPostLikes($post->getPID());?></div>
			<div class="post-dislike"><a href="like.php?like=-1&pid=<?php echo $post->getPID();?>&from=<?php echo $from; ?>"><i class="far fa-thumbs-down"></i></a> <?php echo $api->countPostDislikes($post->getPID());?></div>
			<div class="post-fav<?php echo $api->isFavSet($post->getPID(), $uid) ? " active" : "";?>"><a href="fav.php?pid=<?php echo $post->getPID();?>&from=<?php echo $from;?>"><i class="far fa-star"></i></a></div>
		</div>
