<?php
require_once (dirname(__FILE__) . '/include/guestredirect.php');
require_once (dirname(__FILE__) . '/classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();
$api->removeSession(session_id());

header("Status: 302 Found");
header("Location: ./");
?>
