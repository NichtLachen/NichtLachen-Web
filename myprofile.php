<?php

require_once (dirname(__FILE__) . '/include/guestredirect.php');
require_once (dirname(__FILE__) . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
$user = $api->getUserByUID($uid);

?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Mein Profil</title>
		<link rel="stylesheet" href="/css/stylesheet.css"/>
	</head>
	<body>
<?php
require_once (dirname(__FILE__) . '/templates/navbar.php');
?>
		<div class="profileimage" style="float: left;">
			<?php
			if (file_exists(dirname(__FILE__) . '/profileimages/' . $uid . '.jpg')) {
				echo '<img src="profileimages/' . $uid . '.jpg"></img>';
			}
			?>
		</div>
		<center><p style="font-size: x-large; font-weight: bold;"><?php echo $user->getName(); ?></p></center>
<?php
require_once (dirname(__FILE__) . '/templates/footer.html');
?>
	</body>
</html>


