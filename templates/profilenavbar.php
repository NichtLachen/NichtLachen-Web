<?php

require_once (__DIR__ . '/../include/navutils.php');
$from = isset($_GET['from']) ? $_GET['from'] : "./";
$myfrom = urlencode($_SERVER['REQUEST_URI']);

?>
		<div class="topnav">
			<a href="<?php echo $from; ?>"><i class="fa fa-arrow-left" style="font-size: large; margin-left: 20px;"></i></a>
			<font class="header">Mein Profil</font>
			<a style="float: right" href="logout.php">Ausloggen</a>
			<br><br>

			<a<?php echo active("myprofile.php");?> href="myprofile.php?from=<?php echo $myfrom; ?>">Profil</a>
			<a<?php echo active("myposts.php");?> href="myposts.php?from=<?php echo $myfrom; ?>">Beiträge</a>
			<a<?php echo active("myqueue.php");?> href="myqueue.php?from=<?php echo $myfrom; ?>">Eingereicht</a>
		</div>
