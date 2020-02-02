<?php

require_once (dirname(__FILE__) . '/include/guestredirect.php');
require_once (dirname(__FILE__) . '/classes/db/DatabaseAPI.php');
require_once (dirname(__FILE__) . '/config.php');

$api = new DatabaseAPI();
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

$prev = $page > 1 ? " href=\"" . $_SERVER['PHP_SELF'] . "?page=" . ($page - 1) . "\"": "";
$next = $api->moreTopPosts($page, POSTS_PER_PAGE) ? " href=\"" . $_SERVER['PHP_SELF'] . "?page=" . ($page + 1) . "\"" : "";

?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Top</title>
		<link rel="stylesheet" href="/css/stylesheet.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
<?php
require_once (dirname(__FILE__) . '/templates/navbar.php');

$posts = $api->getTopPosts($page, POSTS_PER_PAGE);
require (dirname(__FILE__) . '/templates/post_array.php');

?>
		<div class="nextpage">
			<a id="previous" class="previous"<?php echo $prev; ?>><i class="fas fa-caret-left"></i></a>
			<a id="next" class="next"<?php echo $next; ?>><i class="fas fa-caret-right"></i></a>
		</div>
<?php

require_once (dirname(__FILE__) . '/templates/footer.html');
?>
	</body>
</html>


