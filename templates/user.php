<?php
require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/../classes/date/DateUtil.php');
require_once (__DIR__ . '/../include/htmlutils.php');
require_once (__DIR__ . '/../include/stringutils.php');

$api = new DatabaseAPI();
$myuid = $api->getUIDBySessionID(session_id());

$lastid = isset($last_user) ? $last_user->getUID() : 0; // 0 does never exist
$last_user = $user;

$from_before = urlencode($_SERVER['REQUEST_URI'] . '#' . $user->getUID());
$from_delete = urlencode($_SERVER['REQUEST_URI'] . '#' . $lastid . "end");

$content = splitTextAtLength(escapeHTML($user->getDescription()), 800);
?>
		<div class="post" id="<?php echo $user->getUID();?>">
			<a class="post-category" href="users.php?uid=<?php echo $user->getUID();?>&from=<?php echo $from_before; ?>"><?php echo $user->getName(); ?></a>
			<br><br>
			<div class="post-content"><?php echo $content[0]; if (strlen($content[1]) > 0) { ?><input type="checkbox" class="showMore" id="showMore<?php echo $user->getUID(); ?>"><label for="showMore<?php echo $user->getUID();?>" id="showMoreL<?php echo $user->getUID(); ?>">Mehr anzeigen <i class="fa fa-arrow-down" aria-hidden="true"></i></label><div for="showMoreL<?php echo $user->getUID(); ?>"><?php echo $content[1]; ?></div><?php } ?></div>
			<br>
<?php
if ($user->getUID() != $myuid) {
?>
			<a class="button" onclick="return callURLWithReload('api/subscribe.php?uid=<?php echo $user->getUID();?>');" href="api/subscribe.php?uid=<?php echo $user->getUID();?>&from=<?php echo $from_delete; ?>"><?php echo $api->hasSubscribed($myuid, $user->getUID()) ? "Abonniert" : "Abonnieren"; ?></a>
<?php
}
?>
		</div>
