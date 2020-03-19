<?php

require_once (__DIR__ . '/../include/navutils.php');
require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/../classes/user/Rank.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
$user = $api->getUserByUID($uid);
$from = urlencode($_SERVER['REQUEST_URI']);

?>
		<div class="topnav">
			<div class="header">Nicht lachen!</div>
			<div class="dropdown" style="float: right; margin-top: -0.5em;">
				<button class="dropbtn"><i class="fas fa-bars"></i></button>
				<div class="dropdown-content">
					<a href="users.php?uid=<?php echo $uid; ?>&from=<?php echo $from; ?>">Mein Profil</a>
					<a href="queue.php?from=<?php echo $from; ?>">Warteschlange</a>
					<a href="myfavorites.php?from=<?php echo $from; ?>">Favoriten</a>
					<a href="categoryfilter.php?from=<?php echo $from; ?>">Kategoriefilter</a>
					<a href="colors.php?from=<?php echo $from; ?>">Farben</a>
<?php
if ($user->hasRank(Rank::MODERATOR) || $user->hasRank(Rank::ADMINISTRATOR)) {
?>
					<a href="modsite.php?from=<?php echo $from; ?>">Moderation & Administration</a>
<?php
}
?>
					<a href="about.php?from=<?php echo $from; ?>">Über</a>
				</div>
			</div>
			<div class="dropdown" style="float: right; margin-top: -0.5em;">
				<button class="dropbtn" style="border-radius: 50%;"><i class="fas fa-search"></i></button>
				<div class="dropdown-content">
					<form method="GET" action="search_user.php">
						<input type="hidden" name="from" value="<?php echo urldecode($from); ?>">
						<input class="search" type="search" name="q" placeholder="Benutzer suchen" autocomplete="off">
					</form>

					<form method="GET" action="search_post.php">
						<input type="hidden" name="from" value="<?php echo urldecode($from); ?>">
						<input class="search" type="search" name="q" placeholder="Beitrag suchen" autocomplete="off">
					</form>
				</div>
			</div>
			<br><br>

			<div class="links">
				<a<?php echo active("top.php"); ?> href="top.php">Top</a>
				<a<?php echo active("new.php"); ?> href="new.php">Neu</a>
				<a<?php echo active("categories.php"); ?> href="categories.php">Kategorien</a>
				<a<?php echo active("subs.php"); ?> href="subs.php">Abos</a>
			</div>
		</div>
