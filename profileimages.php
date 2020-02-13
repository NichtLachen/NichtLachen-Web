<?php

require_once (__DIR__ . '/include/guestredirect.php');

$name = isset($_GET['imgpath']) ? basename($_GET['imgpath']) : null;
$file = __DIR__ . '/profileimages/' . $name;

if($name != null && file_exists($file)) {
	header("Content-Type: " . mime_content_type($file));
	header("Content-Length: " . filesize($file));

	readfile($file);
} else {
	header("Status: 404 Not Found");
}

?>
