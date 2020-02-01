<?php

function isActive(string $php) : bool {
	return basename(get_included_files()[0]) == $php;
}

function active(string $php) : string {
	return isActive($php) ? ' class="active"' : '';
}

?>
