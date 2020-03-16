<?php

function countCharacters(string $text) : int {
	return strlen($text) + substr_count($text, "\n") * 20;
}

function splitTextAtLength(?string $text, int $length) : array {
	$res = ["", ""];

	if ($text != null && countCharacters($text) > $length) {
		foreach(mb_str_split($text) as $char) { // PERFORMANCE intensive!
			$res[0] .= $char;

			if (countCharacters($res[0]) >= $length) {
				break;
			}
		}

		$res[1] = substr($text, strlen($res[0]));

		return $res;
	}

	$res[0] = $text;

	return $res;
}

function formatText(?string $text) : ?string {
	return $text; // currently disabled

	if ($text == null) {
		return null;
	}

	$res = preg_replace('/\*(.*?)\*/', '<b>${1}</b>', $text); // bold
	$res = preg_replace('/\_(.*?)\_/', '<i>${1}</i>', $res); // italic
	$res = preg_replace('/\~(.*?)\~/', '<s>${1}</s>', $res); // striketrough
	return $res;
}

function str_replace_first(string $from, string $to, string $content, int $count) : string {
	$from = '/'.preg_quote($from, '/').'/';
	return preg_replace($from, $to, $content, $count);
}

function validate_username(string $username) : bool {
	$allowed = array(".", "-", "_", "ä", "ö", "ü", "ß");

	return ctype_alnum(str_replace($allowed, '', strtolower($username)));
}

?>
