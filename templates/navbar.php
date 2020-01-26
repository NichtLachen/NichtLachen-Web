<?php

function isActive(string $php) : bool {
	return basename(get_included_files()[0]) == $php;
}

function active(string $php) : string {
	return isActive($php) ? ' class="active"' : '';
}

?>

	<ul class="topnav">
		<p>Nicht lachen!<br></p>

		<li<?php echo active("home.php"); ?>><a href="home.php">Home</a></li>
		<li<?php echo active("top.php"); ?>><a href="top.php">Top</a></li>
		<li<?php echo active("neu.php"); ?>><a href="neu.php">Neu</a></li>
		<li><?php echo active("kategorien.php"); ?><a href="kategorien.php">Kategorien</a></li>
		<li><?php echo active("abos.php"); ?><a href="abos.php">Abos</a></lI>
	</ul>
