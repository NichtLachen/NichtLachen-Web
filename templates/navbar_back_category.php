<?php

require_once (__DIR__ . '/../include/navutils.php');
$from = isset($_GET['from']) ? $_GET['from'] : "./";
$myfrom = urlencode($_SERVER['REQUEST_URI']);

?>
		<div class="topnav">
			<a style="margin-left: 20px;" href="<?php echo $from; ?>"><i class="fa fa-arrow-left"></i></a>
			<a style="float: right; margin-right: 20px;" href="post.php?cid=<?php echo $_GET['cid']; ?>&from=<?php echo $myfrom; ?>"><i class="fas fa-plus"></i></a>
			<font class="header"><?php echo $TITLE; ?></font>
			<br><br>
		</div>