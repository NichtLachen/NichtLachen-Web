<?php

function isActive(string $php) : bool {
	return basename(get_included_files()[0]) == $php;
}

function active(string $php) : string {
	return isActive($php) ? ' class="active"' : '';
}

?>
		<div class="topnav" id="navbar">
			<font class="header">Nicht lachen!</font>
			<div class="dropdown" style="float: right;">
				<button class="dropbtn" style="border-radius: 50%;"><i class="fas fa-cog" style="font-size: xx-large;"></i></button>
				<div class="dropdown-content">
					<a<?php echo active("myprofile.php"); ?> href="myprofile.php">Mein Profil</a>
				</div>
			</div>
			<br><br>

			<a<?php echo active("top.php"); ?> href="top.php">Top</a>
			<a<?php echo active("new.php"); ?> href="new.php">Neu</a>
			<a<?php echo active("categories.php"); ?> href="categories.php">Kategorien</a>
			<a<?php echo active("abos.php"); ?> href="abos.php">Abos</a>
		</div>
		<script language="javascript">
			var prevScrollpos = window.pageYOffset;
			window.onscroll = function() {
				var currentScrollPos = window.pageYOffset;
				if (prevScrollpos > currentScrollPos) {
					document.getElementById("navbar").style.top = "0";
					document.getElementById("navbar").style.visibility = "visible";
					document.getElementById("footer").style.bottom = "0";
					document.getElementById("footer").style.visibility = "visible";
				} else {
					document.getElementById("navbar").style.top = "-1000px";
					document.getElementById("footer").style.bottom = "-1000px";
					document.getElementById("navbar").style.visibility = "hidden";
					document.getElementById("footer").style.visibility = "hidden";
				}
				prevScrollpos = currentScrollPos;
			} 
		</script>
