<?php
$randId = "btnControl" . rand(0, PHP_INT_MAX);
?>
<input type="checkbox" class="btnControl" id="<?php echo $randId; ?>"/>
<div class="modal">
	<div class="modal-content success">
		<label class="close" for="<?php echo $randId; ?>">&times;</label>
		<p><?php echo $SUCCESS ?></p>
	</div>
</div>
