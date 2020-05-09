<?php

require_once (__DIR__ . '/../config.php');
require_once (__DIR__ . '/../include/varutils.php');

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

$prev = $page > 1 ? " href=\"" . hrefReplaceVar("page", ($page - 1)) . "\"": "";
$prevNum = $page > 1 ? '<a href="' . hrefReplaceVar("page", ($page - 1)) . '">' . ($page - 1) . '</a>' : "";
$next = $checkMore($page, POSTS_PER_PAGE) ? " href=\"" . hrefReplaceVar("page", ($page + 1)) . "\"" : "";
$nextNum = strlen($next) > 0 ? '<a href="' . hrefReplaceVar("page", ($page + 1)) . '">' . ($page + 1) . '</a>' : "";

$posts = $getPosts($page, POSTS_PER_PAGE);
require (__DIR__ . '/../templates/post_array.php');

if ($page > 1 || strlen($next) > 0) {
	require_once (__DIR__ . '/../templates/prevnext.php');
}

?>
