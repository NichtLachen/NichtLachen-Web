<?php

require_once (__DIR__ . '/../include/navutils.php');
$from = isset($_GET['from']) ? $_GET['from'] : "./";

?>
		<div class="topnav">
			<a onclick="return back();" style="margin-left: 20px;" href="<?php echo $from; ?>"><i class="fa fa-arrow-left"></i></a>
			<font class="header"><?php echo $TITLE; ?></font>
			<br><br>
		</div>
