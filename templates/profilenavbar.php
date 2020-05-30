<?php

require_once (__DIR__ . '/../include/navutils.php');
require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();

if (!isset($uid)) {
	$uid = $api->getUIDBySessionID(session_id());
}

$user = $api->getUserByUID($uid);
$myuid = $api->getUIDBySessionID(session_id());
$from = isset($_GET['from']) ? $_GET['from'] : "./";

?>
		<div class="topnav">
			<a id="navbar_back" onclick="return back();" style="margin-left: 1.5em;" href="<?php echo $from; ?>"><i class="fa fa-arrow-left"></i></a>
			<div class="header"><?php echo $TITLE; ?></div>
<?php
if($uid == $myuid) {
?>
			<a style="float: right; margin-right: 1.5em; margin-top: -0.45em;" href="logout.php" onclick="return confirm('Wirklich abmelden?');">Ausloggen</a>
<?php
}
?>
			<br><br>

			<div class="links">
				<a<?php echo active("users.php");?> href="users.php?uid=<?php echo $uid; ?>&from=<?php echo urlencode($from); ?>">Profil</a>
				<a<?php echo active("user_posts.php");?> href="user_posts.php?uid=<?php echo $uid; ?>&from=<?php echo urlencode($from); ?>">Beiträge</a>
<?php
if($uid == $myuid) {
?>
				<a<?php echo active("myqueue.php");?> href="myqueue.php?from=<?php echo urlencode($from); ?>">Eingereicht</a>
<?php
}
?>
			</div>
		</div>
