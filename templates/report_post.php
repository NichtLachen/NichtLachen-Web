<?php
require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/../classes/date/DateUtil.php');
require_once (__DIR__ . '/../include/htmlutils.php');
require_once (__DIR__ . '/../include/stringutils.php');
require_once (__DIR__ . '/../config.php');

$api = new DatabaseAPI();

print_r($report);
echo "<br><br>";

foreach ($report as $reason) {
	print_r($report[0]);
	echo "<br><br>";
}

echo "END<br><br>";

?>
