<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/date/DateUtil.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/include/profileimageutils.php');
require_once (__DIR__ . '/config.php');
require_once (__DIR__ . '/include/stringutils.php');
require_once (__DIR__ . '/include/varutils.php');

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

$success = false;

if(isset($_FILES['profileimage']) && strlen($_FILES['profileimage']['name']) > 0) {
	$image = $_FILES['profileimage'];
	$ext = pathinfo($image['name'], PATHINFO_EXTENSION);

	if(in_array($ext, ALLOWED_IMAGE_EXTENSIONS)) {
		deleteProfileImage();
		move_uploaded_file($image['tmp_name'], __DIR__ . '/profileimages/' . $uid . "." . $ext);
		$success = true;
	} else {
		$ERROR = "Das angegebene Bild besitzt eine unerlaubte Dateiendung";
		require (__DIR__ . '/templates/error.php');
	}
}

if(isset($_POST['delete_profileimage']) && $_POST['delete_profileimage'] == "on") {
	deleteProfileImage();
}

if(isset($_POST['username']) && strlen($_POST['username']) > 0) {
	$username = trim($_POST['username']);
	$changedAt = DateUtil::utcToLocalTime($user->getNameChangedAt());

	if (strtolower($username) != strtolower($user->getName())) {
		if ($changedAt->diff(new Datetime())->days >= 7) {
			if(validate_username($username)) {
				if((!$api->isNameInUse($username) && !$api->isNameInVerification($username)) || strtolower($user->getOldName()) == strtolower($username)) {
					$api->setUserName($uid, $username);
					$success = true;
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
}

if(isset($_POST['email']) && strlen($_POST['email']) > 0) {
	$api->setUserEMail($uid, $_POST['email']);
	$success = true;
}

if(isset($_POST['password']) && strlen($_POST['password']) > 0) {
	$password = $_POST['password'];

	if(strlen($password) >= 8) {
		$password = password_hash($password, PASSWORD_DEFAULT);
		$api->setUserPassword($uid, $password);
		$success = true;
	} else {
		$ERROR = "Das Passwort muss mindestens 8 Zeichen lang sein!";
		require (__DIR__ . '/templates/error.php');
	}
}

if(isset($_POST['description']) && strlen($_POST['description']) > 0 && $_POST['description'] != $api->getUserByUID($uid)->getDescription()) {
	$api->setUserDescription($uid, $_POST['description']);
	$success = true;
}

if(isset($_POST['delete_description']) && $_POST['delete_description'] == "on") {
	$api->setUserDescription($uid, null);
	$success = true;
}

if($success && !in_array(__DIR__ . '/templates/error.php', get_included_files())) {
	$SUCCESS = "Profil erfolgreich aktualisiert";
	require (__DIR__ . '/templates/success.php');
}

$user = $api->getUserByUID($uid);

?>
		<div class="center">
			<form class="default-form" method="POST" action="?from=<?php echo urlencode($_GET['from']); ?>" id="editprofile" enctype="multipart/form-data">
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
				<textarea style="width: 80%; height: 15em;" name="description" form="editprofile" placeholder="Neue Beschreibung"><?php echo $user->getDescription(); ?></textarea>
				<br><br>
				<input type="checkbox" name="delete_description"/> Beschreibung löschen
				<br><br>
				<input type="submit" name="submit" class="button" value="Speichern">
				<br><br><br>
				<div class="post-info">Hinweis: Es müssen nicht alle Felder ausgefüllt sein</div>
			</form>
		</div>
<?php

require_once (__DIR__ . '/templates/footer.php');
?>
