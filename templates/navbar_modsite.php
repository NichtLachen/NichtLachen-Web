<?php

require_once (__DIR__ . '/../include/navutils.php');

$from = isset($_GET['from']) ? $_GET['from'] : "./";
$myfrom = $_SERVER['REQUEST_URI'];

?>
		<div class="topnav">
			<a id="navbar_back" onclick="return back();" style="margin-left: 1.5em;" href="<?php echo $from; ?>"><i class="fa fa-arrow-left"></i></a>
			<div class="header"><?php echo $TITLE; ?></div>
			<br><br>

			<div class="links">
				<a<?php echo active("modsite.php");?> href="<?php echo $myfrom; ?>">Übersicht</a>
				<a href="reports.php?from=<?php echo urlencode($myfrom); ?>">Reports</a> <!-- TODO: improve? (this can never be active!) -->
			</div>
		</div>
