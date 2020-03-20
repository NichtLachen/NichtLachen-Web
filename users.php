<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/include/profileimageutils.php');
require_once (__DIR__ . '/include/htmlutils.php');
require_once (__DIR__ . '/classes/user/Rank.php');

$api = new DatabaseAPI();
$myuid = $api->getUIDBySessionID(session_id());
$uid = isset($_GET['uid']) && is_numeric($_GET['uid']) ? $_GET['uid'] : 0; // UID 0 does never exist
$user = $api->getUserByUID($uid);

$TITLE = $user != null ? ($uid == $myuid ? "Mein Profil" : "Profil von " . $user->getName()) : "Benutzer nicht gefunden!";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/profilenavbar.php');

if ($user != null) {

	$from = urlencode($_SERVER['REQUEST_URI']);

	$follows = $uid == $myuid ? "<a href=\"mysubscriptions.php?from=" . $from . "\">" . $api->countFollows($myuid) . "</a>" : $api->countFollows($uid);

	$profileimage = findProfileImage($uid);
	$bgImage = $profileimage != null ? "url('profileimages/" . $profileimage . "')" : "none"; 
?>
		<div class="center">
			<div class="center profileimage" style="background-image: <?php echo $bgImage; ?>;">
			</div>
			<p style="font-size: x-large; font-weight: bold;"><?php echo $user != null ? $user->getName() : ""; ?> <?php if ($uid == $myuid) { ?><a class="edit" href="editprofile.php?from=<?php echo $from; ?>"><i class="fas fa-edit"></i></a><?php } else { $rep = "report.php?uid=" . $uid . "&from=" . $from; ?><a class="edit report" href="<?php echo $rep; ?>"><i class="fas fa-exclamation-triangle"></i></a><?php } ?></p>
			<div>
<?php
	if ($user->hasRank(Rank::ADMINISTRATOR)) {
?>
				<div class="rank administrator">Administrator</div>
<?php
	}

	if ($user->hasRank(Rank::MODERATOR)) {
?>
				<div class="rank moderator">Moderator</div>
<?php
	}
?>
			</div>
<?php
	if ($uid != $myuid) {
?>
			<a class="button" onclick="return callURLWithReload('subscribe.php?uid=<?php echo $uid; ?>');" href="subscribe.php?uid=<?php echo $uid; ?>&from=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"><?php echo $api->hasSubscribed($myuid, $uid) ? "Abonniert" : "Abonnieren"; ?></a>
			<br>
<?php
	}
?>
			<br>
			<table class="center userinfo">
				<tr>
					<th><a href="user_posts.php?uid=<?php echo $uid;?>&from=<?php echo $from; ?>"><?php echo $api->countPosts($uid); ?></a></th>
					<th><?php echo $api->countFollowers($uid); ?></th>
					<th><?php echo $follows; ?></th>
				</tr>
				<tr>
					<td>Beiträge</td>
					<td>Folgen mir</td>
					<td>Folge ich</td>
				</tr>
				<tr class="space">
					<td colspan="3"></td>
				</tr>
				<tr>
					<td colspan="3"><?php echo escapeHTML($user->getDescription()); ?></td>
				</tr>
			</table>
		</div>
<?php
} else {
	$ERROR = $TITLE;
	require (__DIR__ . '/templates/error.php');
}

require_once (__DIR__ . '/templates/footer.html');
?>

