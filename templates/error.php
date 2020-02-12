<?php
$randId = "btnControl" . rand(0, PHP_INT_MAX);
?>
<input type="checkbox" class="btnControl" id="<?php echo $randId; ?>"/>
<div class="modal">
	<div class="modal-content error">
		<label class="close" for="<?php echo $randId; ?>">&times;</label>
		<p>Fehler: <?php echo $ERROR ?></p>
	</div>
</div>
