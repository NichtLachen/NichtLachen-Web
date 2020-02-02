<?php

function escapeHTML(?string $text) : ?string {
	if ($text == null) {
		return null;
	}

	$res = str_replace("<", "&lt;", $text);
	$res = str_replace(">", "&gt;", $res);
	return $res;
}

?>
