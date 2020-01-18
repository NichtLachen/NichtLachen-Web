<?php

$root = dirname(__FILE__);
require_once ($root . '/../config.php');

$conn = new PDO('mysql:dbname=' . DBNAME . ';host=' . DBHOST . ';charset=utf8', DBUSER, DBPASS);
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
