<?php

require_once (__DIR__ . '/../config.php');

function findProfileImage(int $uid) : ?string {
	foreach (ALLOWED_IMAGE_EXTENSIONS as $ext) {
		if (file_exists(__DIR__ . '/../profileimages/' . $uid . "." . $ext)) {
			return $uid . "." . $ext;
		}
	}

	return null;
}

?>
