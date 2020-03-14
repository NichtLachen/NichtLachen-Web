<?php

require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');

$api = new DatabaseAPI();

if (session_id() != null) {
	$uid = $api->getUIDBySessionID(session_id());
}

function getColor(string $name) : string {
	global $api,$uid;

	if (isset($uid) && $uid != null) {
		$settings = $api->getUserSettings($uid, $name);

		if (sizeof($settings) > 0) {
			return $settings[0];
		}
	}

	switch ($name) {
		case "colorPrimaryBackground":
			return "white";
		case "colorPostBackground":
			return "white";
		case "colorSecondaryBackground":
			return "orange";
		case "colorPrimaryHeading":
			return "orange";
		case "colorPrimaryText":
			return "black";
		case "colorSecondaryText":
			return "white";
		case "colorTextAdditionalInfo":
			return "grey";
		case "colorPrimarySeparator":
			return "lightgrey";
		default:
			return "white";
	}
}

?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>Nicht Lachen! | <?php echo $TITLE; ?></title>
		<link rel="preload" href="css/stylesheet.css" as="style"/>
		<link rel="preload" href="js/nichtlachen.js" as="script"/>
		<style>
			:root {
				--colorPrimaryBackground: <?php echo getColor("colorPrimaryBackground"); ?>;
				--colorPostBackground: <?php echo getColor("colorPostBackground"); ?>;
				--colorSecondaryBackground: <?php echo getColor("colorSecondaryBackground"); ?>;
				--colorPrimaryHeading: <?php echo getColor("colorPrimaryHeading"); ?>;
				--colorPrimaryText: <?php echo getColor("colorPrimaryText"); ?>;
				--colorSecondaryText: <?php echo getColor("colorSecondaryText"); ?>;
				--colorTextAdditionalInfo: <?php echo getColor("colorTextAdditionalInfo"); ?>;
				--colorPrimarySeparator: <?php echo getColor("colorPrimarySeparator"); ?>;
			}
		</style>
		<link rel="stylesheet" href="css/stylesheet.css"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css"/>
		<script src="js/nichtlachen.js"></script>
		<script>
			document.addEventListener("DOMContentLoaded", function() {
				onLoad();
			});
		</script>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
