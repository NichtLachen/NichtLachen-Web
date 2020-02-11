			<div>
				<div class="modal">
					<div class="modal-content error">
						<a style="text-decoration: none;" class="close" href="<?php echo urldecode($from); ?>" onclick="return deleteConfirmClose(<?php echo $delid; ?>);">&times;</a>
						<p>Soll Beitrag #<?php echo $delid; ?> wirklich gelöscht werden?</p>
						<a class="button success" href="<?php echo urldecode($from); ?>" onclick="return deleteConfirmClose(<?php echo $delid; ?>);">Nein</a> <a class="button error" href="<?php echo $delete; ?>" onclick="return deleteConfirmed('<?php echo $delid;?>', '<?php echo $delete; ?>');">Ja</a>
					</div>
				</div>
			</div>
