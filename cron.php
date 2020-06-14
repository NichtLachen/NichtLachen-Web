#!/usr/bin/env php
<?php

$root = __DIR__;

require_once ($root . '/include/cli_only.php');

require_once ($root . '/classes/db/Database.php');

$database = new Database();
$conn = $database->conn;

// delete expired verify entries
$stmt = $conn->prepare('DELETE FROM verify WHERE ExpiresAt < NOW()');
$stmt->execute();
echo $stmt->rowCount() . " verifications expired\n";

// delete expired sessions
$stmt = $conn->prepare('DELETE FROM sessions WHERE ExpiresAt < NOW()');
$stmt->execute();
echo $stmt->rowCount() . " sessions expired\n";

// delete expired resetpassword entries
$stmt = $conn->prepare('DELETE FROM resetpassword WHERE ExpiresAt < NOW()');
$stmt->execute();
echo $stmt->rowCount() . " resetpassword verifications expired\n";

?>
