<?php
require_once (dirname(__FILE__) . '/../classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$category = $api->getCategoryName($post->getCID());
$user = $api->getUserByUID($post->getCreatorUID());
?>
		<div class="post" id="<?php echo $post->getPID();?>">
			<a class="post-category" href="categories.php?cid=<?php echo $post->getCID();?>"><?php echo $category; ?></a>
			<div class="post-content"><?php echo $post->getContent(); ?></div>
			<p class="post-info">Eingereicht von <a href="users.php?uid=<?php echo $user->getUID();?>"><?php echo $user->getName();?></a> am <?php echo $post->getCreatedAt(); ?></p>
			<div class="post-like"><a href="like.php?like=1&pid=<?php echo $post->getPID();?>&from=<?php echo urlencode($_SERVER['REQUEST_URI'] . "#" . $post->getPID());?>"><i class="far fa-thumbs-up"></i></a> <?php echo $api->countPostLikes($post->getPID());?></div>
			<div class="post-dislike"><a href="like.php?like=0&pid=<?php echo $post->getPID();?>&from=<?php echo urlencode($_SERVER['REQUEST_URI'] . "#" . $post->getPID());?>"><i class="far fa-thumbs-down"></i></a> <?php echo $api->countPostDislikes($post->getPID());?></div>
		</div>
