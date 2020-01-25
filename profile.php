<?php

require_once (dirname(__FILE__) . '/include/guestredirect.php');
require_once (dirname(__FILE__) . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$user = isset($_GET['user']) ? $api->getUserByName($_GET['user']) : $api->getUserByUID($api->getUIDBySessionID(session_id()));

?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | Profil | <?php echo $user->getName(); ?></title>
		<link rel="stylesheet" href="/css/stylesheet.css"/>
	</head>
	<body>
		<h1 style="margin-top: 0%;">
			<center><br>Profil von <?php echo $user->getName() . "#" . $user->getUID(); ?><br><br></center>
		</h1>
<?php
if ($user != null) {
?>
		<div class="profileimage" style="width: 256px; height: 256px; background-color: white;">
			<?php
			if(file_exists(dirname(__FILE__) . '/profileimages/' . $user->getUID() . ".jpg")) {
				echo '<img style="width: 100%; height: 100%;" src="profileimages/'. $user->getUID() . '.jpg"/>';
			}
			?>
		</div>
<?php
} else {
	$ERROR = "Benutzer nicht gefunden!";
	include (dirname(__FILE__) . '/templates/error.php');
}

require_once (dirname(__FILE__) . '/templates/footer.html');
?>
	</body>
</html>


