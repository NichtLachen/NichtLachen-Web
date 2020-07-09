<?php

require_once (__DIR__ . '/../include/navutils.php');

$from = isset($_GET['from']) ? $_GET['from'] : "./";
$comments = isset($_GET['comments']);
$users = !$comments && isset($_GET['users']);
$posts = !$users && !$comments

?>
		<div class="topnav">
			<a id="navbar_back" onclick="return back();" style="margin-left: 1.5em;" href="<?php echo $from; ?>"><i class="fa fa-arrow-left"></i></a>
			<div class="header"><?php echo $TITLE; ?></div>
			<br><br>

			<div class="links">
				<a<?php echo $posts ? active("reports.php") : "";?> href="reports.php?posts&from=<?php echo urlencode($from); ?>">Posts</a>
				<a<?php echo $comments ? active("reports.php") : "";?> href="reports.php?comments&from=<?php echo urlencode($from); ?>">Kommentare</a>
				<a<?php echo $users ? active("reports.php") : "";?> href="reports.php?users&from=<?php echo urlencode($from); ?>">Benutzer</a>
			</div>
		</div>
