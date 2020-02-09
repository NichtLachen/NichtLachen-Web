<?php

function countCharacters(string $text) : int {
	return strlen($text) + substr_count($text, "\n") * 20;
}

function splitTextAtLength(string $text, int $length) : array {
	$res = ["", ""];

	if (countCharacters($text) > $length) {
		foreach(str_split($text) as $char) { // PERFORMANCE intensive!
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

?>
