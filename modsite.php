<?php

require_once (__DIR__ . '/include/guestredirect.php');
require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/config.php');

$api = new DatabaseAPI();

$TITLE = "Moderation & Administration";
require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');

?>
		<div class="flexbox">
			<div class="flexbox-column">
<?php

$checkMore = function(int $page, int $perPage) : bool {
	global $api;
	return $api->morePostReports($page, $perPage);
};

$getReports = function(int $page, int $perPage) : array {
	global $api;
	return $api->getPostReports($page, $perPage);
};

require(__DIR__ . '/templates/paged_report_post_array.php');

?>
			</div>
			<div class="flexbox-column">
				Hier kommen gemeldete Kommentare hin. <br> Diese Spalte kann man beliebig verlängern.
			</div>
			<div class="flexbox-column">
				Hier kommen gemeldete User hin. <br> Diese Spalte kann man beliebig verlängern.
			</div>
		</div>
<?php

require_once (__DIR__ . '/templates/footer.html');

?>
