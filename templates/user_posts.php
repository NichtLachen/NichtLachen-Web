<?php

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

$prev = $page > 1 ? " href=\"" . $_SERVER['PHP_SELF'] . "?uid=$uid&page=" . ($page - 1) . "\"": "";
$prevNum = $page > 1 ? '<a href="' . $_SERVER['PHP_SELF'] . '?uid=' . $uid . '&page=' . ($page - 1) . '">' . ($page - 1) . '</a>' : "";
$next = $api->moreUserPosts($uid, $page, POSTS_PER_PAGE) ? " href=\"" . $_SERVER['PHP_SELF'] . "?uid=$uid&page=" . ($page + 1) . "\"" : "";
$nextNum = !empty($next) ? '<a href="' . $_SERVER['PHP_SELF'] . '?uid=' . $uid . '&page=' . ($page + 1) . '">' . ($page + 1) . '</a>' : "";


$posts = $api->getUserPosts($uid, $page, POSTS_PER_PAGE);
require (dirname(__FILE__) . '/../templates/post_array.php');

require_once (dirname(__FILE__) . '/../templates/prevnext.php');

?>
