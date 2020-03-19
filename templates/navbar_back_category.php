<?php

require_once (__DIR__ . '/../include/navutils.php');
$from = isset($_GET['from']) ? $_GET['from'] : "./";
$myfrom = urlencode($_SERVER['REQUEST_URI']);

?>
		<div class="topnav">
			<a onclick="return back();" style="margin-left: 1.5em;" href="<?php echo $from; ?>"><i class="fa fa-arrow-left"></i></a>
			<div class="header"><?php echo $TITLE; ?></div>
			<a style="float: right; margin-right: 1.5em; margin-top: -0.5em" href="post.php?cid=<?php echo $_GET['cid']; ?>&from=<?php echo $myfrom; ?>"><i class="fas fa-plus"></i></a>
			<br><br>
		</div>
