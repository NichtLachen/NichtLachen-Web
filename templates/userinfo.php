<?php
require_once (dirname(__FILE__) . '/../classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$user = $api->getUserByUID($uid);

function escapeHTML(?string $text) : ?string {
	if ($text == null) {
		return null;
	}

	$res = str_replace("<", "&lt;", $text);
	$res = str_replace(">", "&gt;", $res);
	return $res;
}
?>
		<table class="userinfo">
			<tr>
				<th><a href="user_posts.php?uid=<?php echo $uid;?>"><?php echo $api->countPosts($uid); ?></a></th>
				<th><?php echo $api->countFollowers($uid); ?></th>
				<th><?php echo $api->countFollows($uid); ?></th>
			</tr>
			<tr>
				<td>Beiträge</td>
				<td>Folgen mir</td>
				<td>Folge ich</td>
			</tr>
			<tr class="space"><td></td></tr>
			<tr>
				<td colspan="3"><?php echo escapeHTML($user->getDescription()); ?></td>
			</tr>
		</table>
