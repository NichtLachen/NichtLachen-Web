<?php

require_once (dirname(__FILE__) . '/include/guestredirect.php');
require_once (dirname(__FILE__) . '/classes/db/DatabaseAPI.php');
require_once (dirname(__FILE__) . '/config.php');

$api = new DatabaseAPI();

?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Neu</title>
		<link rel="stylesheet" href="/css/stylesheet.min.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
<?php
require_once (dirname(__FILE__) . '/templates/navbar.php');

$checkMore = function(int $page, int $perPage) : bool {
	global $api;
	return $api->moreNewPosts($page, $perPage);
};

$getPosts = function(int $page, int $perPage) : array {
	global $api;
	return $api->getNewPosts($page, $perPage);
};

require_once (dirname(__FILE__) . '/templates/paged_post_array.php');

require_once (dirname(__FILE__) . '/templates/prevnext.php');
require_once (dirname(__FILE__) . '/templates/footer.html');
?>
	</body>
</html>


