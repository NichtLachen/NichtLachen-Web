<?php

require_once (dirname(__FILE__) . '/../config.php');
require_once (dirname(__FILE__) . '/../include/varutils.php');

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

$prev = $page > 1 ? " href=\"" . hrefReplaceVar("page", ($page - 1)) . "\"": "";
$prevNum = $page > 1 ? '<a href="' . hrefReplaceVar("page", ($page - 1)) . '">' . ($page - 1) . '</a>' : "";
$next = $checkMore($page, POSTS_PER_PAGE) ? " href=\"" . hrefReplaceVar("page", ($page + 1)) . "\"" : "";
$nextNum = !empty($next) ? '<a href="' . $_SERVER['PHP_SELF'] . hrefReplaceVar("page", ($page + 1)) . '">' . ($page + 1) . '</a>' : "";

$posts = $getPosts($page, POSTS_PER_PAGE);
require (dirname(__FILE__) . '/../templates/post_array.php');

?>
