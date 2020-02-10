<div>
	<!--<input type="checkbox" class="btnControl" id="btnControl<?php echo $delid; ?>"/>-->
	<div class="modal">
		<div class="modal-content error">
			<label id="btnControlL<?php echo $delid; ?>" class="close" for="btnControl<?php echo $delid; ?>" onclick="document.getElementById('delete<?php echo $delid; ?>').checked = false;">&times;</label>
			<p>Soll Beitrag #<?php echo $delid; ?> wirklich gelöscht werden?</p>
			<a class="button error" href="<?php echo $delete; ?>">Ja</a>
		</div>
	</div>
</div>
