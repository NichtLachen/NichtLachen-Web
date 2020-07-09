<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/include/mods_and_admins_only.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/config.php');

$api = new DatabaseAPI();

$TITLE = "Reports";
require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_reports.php');

// TODO: find out on which page comment is on comments.php
if (isset($_GET['comments'])) {
	$checkMore = function(int $page, int $perPage) : bool {
		global $api;
		return $api->moreCommentReports($page, $perPage);
	};

	$getReports = function(int $page, int $perPage) : array {
		global $api;
		return $api->getCommentReports($page, $perPage);
	};
} else if (isset($_GET['users'])) {
	$checkMore = function(int $page, int $perPage) : bool {
		global $api;
		return $api->moreUserReports($page, $perPage);
	};

	$getReports = function(int $page, int $perPage) : array {
		global $api;
		return $api->getUserReports($page, $perPage);
	};
} else {
	$checkMore = function(int $page, int $perPage) : bool {
		global $api;
		return $api->morePostReports($page, $perPage);
	};

	$getReports = function(int $page, int $perPage) : array {
		global $api;
		return $api->getPostReports($page, $perPage);
	};
}

require(__DIR__ . '/templates/paged_report_array.php');

require_once (__DIR__ . '/templates/footer.html');

?>
