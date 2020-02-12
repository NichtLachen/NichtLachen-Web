<?php
require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/../include/htmlutils.php');

$api = new DatabaseAPI();
$uid = $user->getUID();
$myuid = $api->getUIDBySessionID(session_id());

$from = urlencode($_SERVER['REQUEST_URI']);

$profileimage = findProfileImage($uid);
$bgImage = $profileimage != null ? "url('profileimages/" . $profileimage . "')" : "none"; 
?>
		<center>
			<div class="profileimage" style="background-image: <?php echo $bgImage; ?>;">
			</div>
			<p style="font-size: x-large; font-weight: bold;"><?php echo $user != null ? $user->getName() : ""; ?> <?php if ($uid == $myuid) { ?><a class="edit" href="editprofile.php?from=<?php echo $from; ?>"><i class="fas fa-edit"></i></a><?php } ?></p>
<?php
if ($uid != $myuid) {
?>
			<a class="button" onclick="return callURLWithReload('subscribe.php?uid=<?php echo $uid; ?>');" href="subscribe.php?uid=<?php echo $uid; ?>&from=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"><?php echo $api->hasSubscribed($myuid, $uid) ? "Abonniert" : "Abonnieren"; ?></a>
			<br>
<?php
}
?>
			<br>
			<table class="userinfo">
				<tr>
					<th><a href="user_posts.php?uid=<?php echo $uid;?>&from=<?php echo $from; ?>"><?php echo $api->countPosts($uid); ?></a></th>
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
		</center>
