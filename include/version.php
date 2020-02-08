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

function getWebVersionTag() : ?string {
	return trim(shell_exec("git describe --tags --abbrev=0"));
}

function getWebVersion() : string {
	return shell_exec("git rev-parse --short HEAD");
}

?>
