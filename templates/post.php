<?php
require_once (dirname(__FILE__) . '/../classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$category = $api->getCategoryName($post->getCID());
$user = $api->getUserByUID($post->getCreatorUID());
?>
		<div class="post" id="<?php echo $post->getPID();?>">
			<div class="post-category"><?php echo $category; ?></div>
			<div class="post-content"><?php echo $post->getContent(); ?></div>
			<p class="post-info">Eingereicht von <?php echo $user->getName();?> am <?php echo $post->getCreatedAt(); ?></p>
			<div class="post-like"><i class="far fa-thumbs-up"></i> <?php echo $api->countPostLikes($post->getPID());?></div>
			<div class="post-dislike"><i class="far fa-thumbs-down"></i> <?php echo $api->countPostDislikes($post->getPID());?></div>
		</div>
