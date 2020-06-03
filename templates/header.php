<?php

require_once (__DIR__ . '/../classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/../include/version.php');

$api = new DatabaseAPI();

if (session_id() != null) {
	$myuid = $api->getUIDBySessionID(session_id());
}

function getColor(string $name) : ?string {
	global $api,$myuid;

	if (isset($myuid) && $myuid != null) {
		$settings = $api->getUserSettings($myuid, $name);

		if (sizeof($settings) > 0) {
			return $settings[0];
		}
	}

	switch ($name) {
		case "colorPrimaryBackground":
			return "#ffffff";
		case "colorPostBackground":
			return "#ffffff";
		case "colorSecondaryBackground":
			return "#ffa500";
		case "colorPrimaryHeading":
			return "#ffa500";
		case "colorPrimaryText":
			return "#000000";
		case "colorSecondaryText":
			return "#ffffff";
		case "colorTextAdditionalInfo":
			return "#808080";
		case "colorPrimarySeparator":
			return "#d3d3d3";
		case "colorPrimaryError":
			return "#d9534f";
		case "colorPrimarySuccess":
			return "#5cb85c";
		case "colorPrimaryLink":
			return "#0066ff";
		default:
			return null;
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
				--colorPrimaryError: <?php echo getColor("colorPrimaryError"); ?>;
				--colorPrimarySuccess: <?php echo getColor("colorPrimarySuccess"); ?>;
				--colorPrimaryLink: <?php echo getColor("colorPrimaryLink"); ?>;
			}
		</style>
		<link rel="stylesheet" href="css/stylesheet.css"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css"/>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
		<script src="js/pushservice.js"></script>
		<script src="js/nichtlachen.js"></script>
		<script>
			document.addEventListener("DOMContentLoaded", function() {
				onLoad();
			});
		</script>
		<meta name='viewport' content="width=device-width, initial-scale=1" />
	</head>
	<body>
<?php

if (isApp()) {
	if (getAppVersion() == "2.0-beta1" || getAppVersion() == "2.0-beta2") {
		$ERROR = "Die verwendete NichtLachen App ist veraltet, ein Update wird benötigt.";
		require (__DIR__ . '/../templates/error.php');
	}
}

?>
