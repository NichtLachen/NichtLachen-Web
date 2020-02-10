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
	} else {
		$res[0] = $text;
	}

	return $res;
}

function formatText(?string $text) : ?string {
	if ($text == null) {
		return null;
	}

	$res = preg_replace('/\*(.*?)\*/', '<b>${1}</b>', $text); // bold
	$res = preg_replace('/\_(.*?)\_/', '<i>${1}</i>', $res); // italic
	$res = preg_replace('/\~(.*?)\~/', '<s>${1}</s>', $res); // striketrough
	return $res;
}

?>
