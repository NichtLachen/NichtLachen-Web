<?php

require_once (__DIR__ . '/../include/navutils.php');
require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
$from = urlencode($_SERVER['REQUEST_URI']);

?>
		<div class="topnav">
			<div class="header">Nicht lachen!</div>
			<div class="dropdown" style="float: right;">
				<button class="dropbtn"><i class="fas fa-bars" style="font-size: xx-large;"></i></button>
				<div class="dropdown-content">
					<a href="users.php?uid=<?php echo $uid; ?>&from=<?php echo $from; ?>">Mein Profil</a>
					<a href="queue.php?from=<?php echo $from; ?>">Warteschlange</a>
					<a href="myfavorites.php?from=<?php echo $from; ?>">Favoriten</a>
					<!--<a href="categoryfilter.php?from=<?php echo $from; ?>">Kategoriefilter</a>-->
					<a href="about.php?from=<?php echo $from; ?>">Über</a>
				</div>
			</div>
			<div class="dropdown" style="float: right;">
				<button class="dropbtn" style="border-radius: 50%;"><i class="fas fa-search" style="font-size: xx-large;"></i></button>
				<div class="dropdown-content">
					<form method="GET" action="search_user.php">
						<input type="hidden" name="from" value="<?php echo urldecode($from); ?>">
						<input class="search" type="text" name="q" placeholder="Benutzer suchen">
					</form>

					<form method="GET" action="search_post.php">
						<input type="hidden" name="from" value="<?php echo urldecode($from); ?>">
						<input class="search" type="text" name="q" placeholder="Beitrag suchen">
					</form>
				</div>
			</div>
			<br><br>

			<a<?php echo active("top.php"); ?> href="top.php">Top</a>
			<a<?php echo active("new.php"); ?> href="new.php">Neu</a>
			<a<?php echo active("categories.php"); ?> href="categories.php">Kategorien</a>
			<a<?php echo active("subs.php"); ?> href="subs.php">Abos</a>
		</div>
