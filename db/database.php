<?php

require_once ('../config.php');

$conn = new PDO('mysql:dbname=' . DBNAME . ';host=' . DBHOST . ';charset=utf8', DBUSER, DBPASS);
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
