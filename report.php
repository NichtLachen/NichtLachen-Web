<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
$success = false;

$obj = isset($_GET['pid']) ? "Post #" . $_GET['pid'] : (isset($_GET['cmtid']) ? "Kommentar #" . $_GET['cmtid'] : (isset($_GET['uid']) ? $api->getUserByUID($_GET['uid'])->getName() : null));
$TITLE = $obj . " melden";
require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

?>
		<div class="center">
			<form class="default-form" method="POST" id="report">
				<div class="post-category">Bitte geben Sie den Grund Ihrer Meldung von <?php echo $obj; ?> an</div><br>
<?php
if (isset($_GET['pid']) && !isset($_POST['pid'])) {
	if ($api->getPostByPID($_GET['pid']) != null) {
?>
				<input type="hidden" name="pid" value="<?php echo $_GET['pid']; ?>">
<?php
	} else {
		$ERROR = "Post nicht gefunden";
		require (__DIR__ . '/templates/error.php');
	}
} else if (isset($_GET['cmtid']) && !isset($_POST['cmtid'])) {
	if ($api->getCommentByCMTID($_GET['cmtid']) != null) {
?>
				<input type="hidden" name="cmtid" value="<?php echo $_GET['cmtid']; ?>">
<?php
	} else {
		$ERROR = "Kommentar nicht gefunden";
		require (__DIR__ . '/templates/error.php');
	}
} else if (isset($_GET['uid']) && !isset($_POST['uid'])) {
	if ($api->getUserByUID($_GET['uid']) != null) {
?>
				<input type="hidden" name="uid" value="<?php echo $_GET['uid']; ?>">
<?php
	} else {
		$ERROR = "Benutzer nicht gefunden";
		require (__DIR__ . '/templates/error.php');
	}
} else if (isset($_POST['pid']) && isset($_POST['reason'])) {
	$success = true;
	$pid = $_GET['pid'];
	$reason = $_POST['reason'];
	if (!empty($reason) && $api->getPostByPID($pid) != null && !$api->hasReportedPost($uid, $pid)) {
		$api->reportPost($uid, $pid, $reason);
	}
} else if (isset($_POST['cmtid']) && isset($_POST['reason'])) {
	$success = true;
	$cmtid = $_GET['cmtid'];
	$reason = $_POST['reason'];
	if (!empty($reason) && $api->getCommentByCMTID($cmtid) != null && !$api->hasReportedComment($uid, $cmtid)) {
		$api->reportComment($uid, $cmtid, $reason);
	}
} else if (isset($_POST['uid']) && isset($_POST['reason'])) {
	$success = true;
	$ruid = $_GET['uid'];
	$reason = $_POST['reason'];
	if (!empty($reason) && $api->getUserByUID($ruid) != null && !$api->hasReportedUser($uid, $ruid)) {
		$api->reportUser($uid, $ruid, $reason);
	}
} else {
	$ERROR = "Ungültige Anfrage";
	require (__DIR__ . '/templates/error.php');
}

?>
				<textarea style="width: 95%; height: 15em;" form="report" name="reason"></textarea><br>
				<br>
				<input type="submit" class="button" value="Melden">
			</form>
		</div>
<?php

if ($success) {
?>
		<script language="javascript">back();</script>
		<noscript><meta http-equiv="refresh" content="0; url=<?php echo $_GET['from']; ?>" /></noscript>
<?php
}

require_once (__DIR__ . '/templates/footer.html');

?>


