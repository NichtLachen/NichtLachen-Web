<?php

function isActive(string $php) : bool {
	return basename(get_included_files()[0]) == $php;
}

function active(string $php) : string {
	return isActive($php) ? ' class="active"' : '';
}

?>
	<div class="topnav" style="overflow: visible;">
		Nicht lachen!
		<div class="dropdown" style="float: right;">
			<button class="dropbtn" style="border-radius: 50%;"><i class="fas fa-cog" style="font-size: xx-large;"></i></button>
			<div class="dropdown-content">
				<a<?php echo active("myprofile.php"); ?> href="myprofile.php">Mein Profil</a>
			</div>
		</div>
		<br><br>

		<a<?php echo active("home.php"); ?> href="home.php">Home</a>
		<a<?php echo active("top.php"); ?> href="top.php">Top</a>
		<a<?php echo active("new.php"); ?> href="new.php">Neu</a>
		<a<?php echo active("categories.php"); ?> href="categories.php">Kategorien</a>
		<a<?php echo active("abos.php"); ?> href="abos.php">Abos</a>
	</div>
