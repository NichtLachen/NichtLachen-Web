<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/include/profileimageutils.php');

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
$user = $api->getUserByUID($uid);

$TITLE = "Mein Profil";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/profilenavbar.php');

$profileimage = findProfileImage($uid);
$bgImage = $profileimage != null ? "url('profileimages/" . $profileimage . "')" : "none"; 
?>
		<center>
		<div class="profileimage" style="background-image: <?php echo $bgImage; ?>;">
		</div>
		<p style="font-size: x-large; font-weight: bold;"><?php echo $user->getName(); ?> <a class="edit" href="editprofile.php?from=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"><i class="fas fa-edit"></i></a></p>
		<br>
<?php
require_once (__DIR__ . '/templates/userinfo.php');
?>
		</center>
<?php
require_once (__DIR__ . '/templates/footer.html');
?>


