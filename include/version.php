<?php

function isApp() : bool {
	return strstr($_SERVER['HTTP_USER_AGENT'], "NichtLachen");
}

function getAppVersion() : ?string {
	if (isApp()) {
		$broken = explode(" ", $_SERVER['HTTP_USER_AGENT']);
		return explode("/", $broken[0])[1];
	} else {
		return null;
	}
}

?>
