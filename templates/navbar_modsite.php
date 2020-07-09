<?php

require_once (__DIR__ . '/../include/navutils.php');

$from = $_SERVER['REQUEST_URI'];

?>
		<div class="topnav">
			<a id="navbar_back" onclick="return back();" style="margin-left: 1.5em;" href="<?php echo $from; ?>"><i class="fa fa-arrow-left"></i></a>
			<div class="header"><?php echo $TITLE; ?></div>
			<br><br>

			<div class="links">
				<a<?php echo active("modsite.php");?> href="<?php echo $from; ?>">Übersicht</a>
				<a href="reports.php?from=<?php echo urlencode($from); ?>">Reports</a> <!-- TODO: improve? (this can never be active!) -->
			</div>
		</div>
