<?php

require_once (dirname(__FILE__) . '/../include/navutils.php');

?>
		<div class="topnav">
			<font class="header">Nicht lachen!</font>
			<div class="dropdown" style="float: right;">
				<button class="dropbtn" style="border-radius: 50%;"><i class="fas fa-cog" style="font-size: xx-large;"></i></button>
				<div class="dropdown-content">
					<a href="myprofile.php">Mein Profil</a>
				</div>
			</div>
			<br><br>

			<a<?php echo active("top.php"); ?> href="top.php">Top</a>
			<a<?php echo active("new.php"); ?> href="new.php">Neu</a>
			<a<?php echo active("categories.php"); ?> href="categories.php">Kategorien</a>
			<a<?php echo active("abos.php"); ?> href="abos.php">Abos</a>
		</div>
