<?php

function hrefReplaceVar(string $repKey, string $repValue) : string {
	$href = $_SERVER['PHP_SELF'];
	
	$i = 0;

	foreach ($_GET as $key => $value) {
		$q = $i == 0 ? "?" : "&";

		if ($key != $repKey) {
			$href .= $q . $key . "=" . $value;
			$i++;
		}
	}

	$q = $i == 0 ? "?" : "&";
	$href .= $q . $repKey . "=" . $repValue;

	return $href;
}

?>
