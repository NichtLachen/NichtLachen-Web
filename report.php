<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
$success = false;

function getCombinedReasons() : string {
	$reason = "";

	foreach ($_POST as $key => $value) {
		if (strlen($key) >= strlen("reason") && substr($key, 0, strlen("reason")) == "reason" && strlen($value) > 0) {
			$reason = strlen($reason) > 0 ? $reason . " & " . $value : $value;
		}
	}

	return $reason;
}

$obj = isset($_GET['pid']) ? "Post #" . $_GET['pid'] : (isset($_GET['cmtid']) ? "Kommentar #" . $_GET['cmtid'] : (isset($_GET['uid']) ? $api->getUserByUID($_GET['uid'])->getName() : null));
$TITLE = $obj . " melden";
require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

?>
		<div class="center" style="width: 50%; text-align: left; font-size: 14pt;">
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
} else if (isset($_POST['pid'])) {
	$success = true;
	$pid = $_GET['pid'];
	$reason = getCombinedReasons();
	if (strlen($reason) > 0 && $api->getPostByPID($pid) != null && !$api->hasReportedPost($uid, $pid)) {
		$api->reportPost($uid, $pid, $reason);
	}
} else if (isset($_POST['cmtid'])) {
	$success = true;
	$cmtid = $_GET['cmtid'];
	$reason = getCombinedReasons();
	if (strlen($reason) > 0 && $api->getCommentByCMTID($cmtid) != null && !$api->hasReportedComment($uid, $cmtid)) {
		$api->reportComment($uid, $cmtid, $reason);
	}
} else if (isset($_POST['uid'])) {
	$success = true;
	$reporteduid = $_GET['uid'];
	$reason = getCombinedReasons();
	if (strlen($reason) > 0 && $api->getUserByUID($reporteduid) != null && !$api->hasReportedUser($uid, $reporteduid)) {
		$api->reportUser($uid, $reporteduid, $reason);
	}
} else {
	$ERROR = "Ungültige Anfrage";
	require (__DIR__ . '/templates/error.php');
}

?>
				<input type="checkbox" name="reason1" value="Rechtschreibung/Grammatik"> Rechtschreibung/Grammatik<br>
				<input type="checkbox" name="reason2" value="Spam"> Spam<br>
				<input type="checkbox" name="reason3" value="Beleidigung anderer User"> Beleidigung anderer User<br>
				<input type="checkbox" name="reason4" value="Falsche Kategorie"> Falsche Kategorie<br>
				<input type="checkbox" name="reason5" value="Doppelter Post"> Doppelter Post<br><br>
				<input style="width: 100%;" type="text" name="reason6" placeholder="Anderer Grund"><br>
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

require_once (__DIR__ . '/templates/footer.php');

?>
