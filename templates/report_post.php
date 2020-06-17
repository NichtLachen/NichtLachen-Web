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
$from = urlencode($_SERVER['REQUEST_URI'] . "#" . $rpid);

?>
				<div id="<?php echo $rpid; ?>" class="post">
					<a class="post-category" href="comments.php?pid=<?php echo $pid; ?>&from=<?php echo $from; ?>">Post #<?php echo $pid; ?></a><br><br>
<?php
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
