<?php

require_once (__DIR__ . '/../include/navutils.php');
$from = isset($_GET['from']) ? $_GET['from'] : "./";

?>
		<div class="topnav">
			<a style="margin-left: 20px;" href="<?php echo $from; ?>"><i class="fa fa-arrow-left"></i></a>
			<div class="header">Mein Profil</div>
			<a style="float: right" href="logout.php">Ausloggen</a>
			<br><br>

			<a<?php echo active("myprofile.php");?> href="myprofile.php?from=<?php echo urlencode($from); ?>">Profil</a>
			<a<?php echo active("myposts.php");?> href="myposts.php?from=<?php echo urlencode($from); ?>">Beiträge</a>
			<a<?php echo active("myqueue.php");?> href="myqueue.php?from=<?php echo urlencode($from); ?>">Eingereicht</a>
		</div>
