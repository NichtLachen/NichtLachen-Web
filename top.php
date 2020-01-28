<?php

require_once (dirname(__FILE__) . '/include/guestredirect.php');
require_once (dirname(__FILE__) . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();

?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Neu</title>
		<link rel="stylesheet" href="/css/stylesheet.css"/>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
<?php
require_once (dirname(__FILE__) . '/templates/navbar.php');

$posts = $api->getTopPosts(0, 30);
require (dirname(__FILE__) . '/templates/post_array.php');

require_once (dirname(__FILE__) . '/templates/footer.html');
?>
	</body>
</html>


