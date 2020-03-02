<?php

require_once (__DIR__ . '/../include/navutils.php');
$from = isset($_GET['from']) ? $_GET['from'] : "./";
$myfrom = urlencode($_SERVER['REQUEST_URI']);

?>
		<div class="topnav">
			<a onclick="return back();" style="margin-left: 1.5em;" href="<?php echo $from; ?>"><i class="fa fa-arrow-left"></i></a>
			<a style="float: right; margin-right: 20px;" href="post.php?cid=<?php echo $_GET['cid']; ?>&from=<?php echo $myfrom; ?>"><i class="fas fa-plus"></i></a>
			<div class="header"><?php echo $TITLE; ?></div>
			<br><br>
		</div>
