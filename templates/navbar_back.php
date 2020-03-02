<?php

require_once (__DIR__ . '/../include/navutils.php');
$from = isset($_GET['from']) ? $_GET['from'] : "./";

?>
		<div class="topnav">
			<a onclick="return back();" style="margin-left: 1.5em;" href="<?php echo $from; ?>"><i class="fa fa-arrow-left"></i></a>
			<div class="header"><?php echo $TITLE; ?></div>
			<br><br>
		</div>
