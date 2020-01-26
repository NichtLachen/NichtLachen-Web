<?php
require_once (dirname(__FILE__) . '/../classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
?>
		<table class="userinfo">
			<tr>
				<th><?php echo $api->countPosts($uid); ?></th>
				<th><?php echo $api->countFollowers($uid); ?></th>
				<th><?php echo $api->countFollows($uid); ?></th>
			</tr>
			<tr>
				<td>Beiträge</td>
				<td>Folgen mir</td>
				<td>Folge ich</td>
			</tr>
		</table>
