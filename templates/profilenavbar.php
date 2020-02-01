<?php

function isActive(string $php) : bool {
	return basename(get_included_files()[0]) == $php;
}

function active(string $php) : string {
	return isActive($php) ? ' class="active"' : '';
}

?>
		<div class="topnav">
			<a href="top.php"<i class="fa fa-arrow-left" style="font-size: large; margin-left: 20px;"></i></a>
			<font class="header">Mein Profil</font>
			<a style="float: right" href="logout.php">Ausloggen</a>
			<br><br>

			<a<?php echo active("myprofile.php");?> href="myprofile.php">Profil</a>
			<a<?php echo active("myposts.php");?> href="myposts.php">Beiträge</a>
			<a<?php echo active("myqueue.php");?> href="myqueue.php">Eingereicht</a>
		</div>
