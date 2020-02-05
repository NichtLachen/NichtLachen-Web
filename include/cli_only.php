<?php
if (php_sapi_name() != 'cli') {
	header("Content-Type: text/plain");
	echo "\n" . basename(get_included_files()[0]) . " can only be run from CLI!\n";
	die();
}
?>
