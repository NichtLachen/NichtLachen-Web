<?php

require_once (__DIR__ . '/../include/navutils.php');
$from = isset($_GET['from']) ? $_GET['from'] : "./";

?>
		<div class="topnav">
			<a href="<?php echo $from; ?>"><i class="fa fa-arrow-left" style="font-size: large; margin-left: 20px;"></i></a>
			<font class="header"><?php echo $TITLE; ?></font>
			<br><br>
		</div>
