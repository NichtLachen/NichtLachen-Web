<?php

require_once (dirname(__FILE__) . '/../include/navutils.php');

?>
		<div class="topnav">
			<a href="./"<i class="fa fa-arrow-left" style="font-size: large; margin-left: 20px;"></i></a>
			<font class="header">Mein Profil</font>
			<a style="float: right" href="logout.php">Ausloggen</a>
			<br><br>

			<a<?php echo active("myprofile.php");?> href="myprofile.php">Profil</a>
			<a<?php echo active("myposts.php");?> href="myposts.php">Beiträge</a>
			<a<?php echo active("myqueue.php");?> href="myqueue.php">Eingereicht</a>
		</div>
