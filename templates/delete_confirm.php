<div>
	<script language="javascript">
		function reset<?php echo $delid; ?>() {
			document.getElementById('delete<?php echo $delid; ?>').checked = false;
			document.getElementbyId('btnControl<?php echo $delid; ?>').checked = false;
			return false;
		}
	</script>
	<div class="modal">
		<div class="modal-content error">
			<a style="text-decoration: none;" class="close" href="<?php echo urldecode($from); ?>" onclick="return reset<?php echo $delid; ?>();">&times;</a>
			<p>Soll Beitrag #<?php echo $delid; ?> wirklich gelöscht werden?</p>
			<a class="button success" href="<?php echo urldecode($from); ?>" onclick="return reset<?php echo $delid; ?>();">Nein</a> <a class="button error" href="<?php echo $delete; ?>">Ja</a>
		</div>
	</div>
</div>
