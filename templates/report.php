<?php
require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/../classes/date/DateUtil.php');
require_once (__DIR__ . '/../include/htmlutils.php');
require_once (__DIR__ . '/../include/stringutils.php');
require_once (__DIR__ . '/../config.php');

$api = new DatabaseAPI();

$firstreport = $report[0];
$rpid = $firstreport->getReportID();
$pid = $firstreport->getReportedPID();
$cmtid = $firstreport->getReportedCMTID();
$uid = $firstreport->getReportedUID();
$from = urlencode($_SERVER['REQUEST_URI'] . "#" . $rpid);

$post = $pid != null;
$comment = $cmtid != null;
$user = $uid != null;

if ($comment) {
	$commentPid = $api->getPIDByCMTID($cmtid);
	$commentPage = $api->getCommentPage($cmtid, POSTS_PER_PAGE);
}

if ($user) {
	$username = $api->getUserByUID($uid)->getName();
}

?>
				<div id="<?php echo $rpid; ?>" class="post">
<?php
if ($post) {
?>
					<a class="post-category" href="comments.php?pid=<?php echo $pid; ?>&from=<?php echo $from; ?>">Post #<?php echo $pid; ?></a><br><br>
<?php
} else if($comment) {
?>
					<a class="post-category" href="comments.php?pid=<?php echo $commentPid; ?>&page=<?php echo $commentPage; ?>&from=<?php echo $from; ?>#<?php echo $cmtid; ?>">Kommentar #<?php echo $cmtid; ?></a><br><br>
<?php
} else if ($user) {
?>
					<a class="post-category" href="users.php?uid=<?php echo $uid; ?>&from=<?php echo $from; ?>">Benutzer #<?php echo $uid; ?> (<?php echo $username; ?>)</a><br><br>
<?php
}

foreach ($report as $reason) {
	$reporter = $api->getUserByUID($reason->getReporterUID());
?>
					<a class="post-category" href="users.php?uid=<?php echo $reason->getReporterUID(); ?>&from=<?php echo $from; ?>"><?php echo $reporter->getName(); ?></a>:
					<?php echo $reason->getReason(); ?><br>
<?php
}
?>
				</div>
<?php

?>
