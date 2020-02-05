#!/usr/bin/env php
<?php

$root = dirname(__FILE__);

require_once ($root . '/../include/cli_only.php');

$cssFiles = array($root . "/stylesheet.css");

$buffer = "";

foreach ($cssFiles as $cssFile) {
	$buffer .= file_get_contents($cssFile);
}

$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
$buffer = str_replace(': ', ':', $buffer);
$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);

file_put_contents($root . "/stylesheet.min.css", $buffer);

?>
