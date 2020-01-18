#!/usr/bin/env php
<?php

$root = dirname(__FILE__);
require_once ($root . '/db/database.php');

// delete expired verify entries
$stmt = $conn->prepare('DELETE FROM verify WHERE ExpiresAt < NOW()');
$stmt->execute();

// delete expired sessions
$stmt = $conn->prepare('DELETE FROM sessions WHERE ExpiresAt < NOW()');
$stmt->execute();

?>
