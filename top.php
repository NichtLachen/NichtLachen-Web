<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/config.php');

$api = new DatabaseAPI();

?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Top</title>
		<link rel="stylesheet" href="/css/stylesheet.min.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
<?php
require_once (__DIR__ . '/templates/navbar.php');

$checkMore = function(int $page, int $perPage) : bool {
	global $api;
	return $api->moreTopPosts($page, $perPage);
};

$getPosts = function(int $page, int $perPage) : array {
	global $api;
	return $api->getTopPosts($page, $perPage);
};

require_once (__DIR__ . '/templates/paged_post_array.php');

require_once (__DIR__ . '/templates/footer.html');
?>
	</body>
</html>


