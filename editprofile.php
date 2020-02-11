<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/include/profileimageutils.php');
require_once (__DIR__ . '/config.php');
require_once (__DIR__ . '/include/stringutils.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
$user = $api->getUserByUID($uid);

$from = isset($_GET['from']) ? $_GET['from'] : "./";

function deleteProfileImage() {
	global $uid;
	$image = findProfileImage($uid);
	$path = __DIR__ . '/profileimages/' . $image;

	if ($image != null && file_exists($path)) {
		unlink($path);
	}
}

$TITLE = "Profil bearbeiten";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

if(isset($_FILES['profileimage']) && !empty($_FILES['profileimage']['name'])) {
	$image = $_FILES['profileimage'];
	$ext = pathinfo($image['name'], PATHINFO_EXTENSION);

	if(in_array($ext, ALLOWED_IMAGE_EXTENSIONS)) {
		deleteProfileImage();
		move_uploaded_file($image['tmp_name'], __DIR__ . '/profileimages/' . $uid . "." . $ext);
	} else {
		$ERROR = "Das angegebene Bild besitzt eine unerlaubte Dateiendung";
		require (__DIR__ . '/templates/error.php');
	}
}

if(isset($_POST['delete_profileimage']) && $_POST['delete_profileimage'] == "on") {
	deleteProfileImage();
}

if(isset($_POST['username']) && !empty($_POST['username'])) {
	$changedAt = new DateTime($user->getNameChangedAt());

	if ($changedAt->diff(new Datetime())->days >= 7) {
		$username = trim($_POST['username']);

		if(validate_username($username)) {
			if(!$api->isNameInUse($username) && !$api->isNameInVerification($username)) {
				$api->setUserName($uid, $username);
			} else {
				$ERROR = "Benutzername wird bereits verwendet";
				require (__DIR__ . '/templates/error.php');
			}
		} else {
			$ERROR = "Der Benutzername enthält ein ungültiges Zeichen";
			require (__DIR__ . '/templates/error.php');
		}
	} else {
		$ERROR = "Der Benutzername kann nur alle 7 Tage geändert werden";
		require (__DIR__ . '/templates/error.php');
	}
}

if(isset($_POST['email']) && !empty($_POST['email'])) {
	$api->setUserEMail($uid, $_POST['email']);
}

if(isset($_POST['password']) && !empty($_POST['password'])) {
	$password = $_POST['password'];

	if(strlen($password) >= 8) {
		$password = password_hash($password, PASSWORD_DEFAULT);
		$api->setUserPassword($uid, $password);
	} else {
		$ERROR = "Das Passwort muss mindestens 8 Zeichen lang sein!";
		require (__DIR__ . '/templates/error.php');
	}
}

if(isset($_POST['description']) && !empty($_POST['description'])) {
	$api->setUserDescription($uid, $_POST['description']);
}

if(isset($_POST['delete_description']) && $_POST['delete_description'] == "on") {
	$api->setUserDescription($uid, null);
}

$user = $api->getUserByUID($uid);

?>
		<form onsubmit="return sendForm('editprofile', function() {}, true, true);" class="container" method="POST" action="?from=<?php echo urlencode($_GET['from']); ?>" id="editprofile" enctype="multipart/form-data">
			Neues Profilbild: <br><br>
			<input type="file" name="profileimage"/>
			<br><br>
			<input type="checkbox" name="delete_profileimage"/> Profilbild löschen
			<br><br>
			<input type="text" name="username" placeholder="<?php echo $user->getName(); ?>"/>
			<br><br>
			<input type="email" name="email" placeholder="<?php echo $user->getEMail(); ?>"/>
			<br><br>
			<input type="password" name="password" placeholder="Neues Passwort"/>
			<br><br>
			<textarea name="description" form="editprofile" placeholder="Neue Beschreibung"><?php echo $user->getDescription(); ?></textarea>
			<br><br>
			<input type="checkbox" name="delete_description"/> Beschreibung löschen
			<br><br>
			<input type="submit" name="submit" class="button">
			<br><br><br>
			<div class="post-info">Hinweis: Es müssen nicht alle Felder ausgefüllt sein</div>
		</form>
<?php

require_once (__DIR__ . '/templates/footer.html');
?>


