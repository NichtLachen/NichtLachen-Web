<?php

require_once (__DIR__ . '/../config.php');
require_once (__DIR__ . '/../include/varutils.php');

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

$prev = $page > 1 ? " href=\"" . hrefReplaceVar("page", ($page - 1)) . "\"": "";
$prevNum = $page > 1 ? '<a href="' . hrefReplaceVar("page", ($page - 1)) . '">' . ($page - 1) . '</a>' : "";
$next = $checkMore($page, POSTS_PER_PAGE) ? " href=\"" . hrefReplaceVar("page", ($page + 1)) . "\"" : "";
$nextNum = !empty($next) ? '<a href="' . hrefReplaceVar("page", ($page + 1)) . '">' . ($page + 1) . '</a>' : "";

$users = $getUsers($page, POSTS_PER_PAGE);
require (__DIR__ . '/../templates/user_array.php');

if ($page > 1 || !empty($next)) {
	require_once (__DIR__ . '/../templates/prevnext.php');
}

?>
