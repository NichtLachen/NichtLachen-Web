<?php

function hrefReplaceVar(string $repKey, string $repValue) : string {
	$href = "";
	
	$i = 0;

	foreach ($_GET as $key => $value) {
		$q = $i == 0 ? "?" : "&";

		if ($key != $repKey) {
			$href .= $q . urlencode($key) . "=" . urlencode($value);
			$i++;
		}
	}

	$q = $i == 0 ? "?" : "&";
	$href .= $q . urlencode($repKey) . "=" . urlencode($repValue);

	return $_SERVER['PHP_SELF'] . $href;
}

?>
