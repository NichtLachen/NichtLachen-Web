<div class="modal" id="modal">
	<div class="modal-content success">
		<span class="close">&times;</span>
		<p><?php echo $SUCCESS ?></p>
	</div>
</div>

<script language="javascript">
// Get the modal
var modal = document.getElementById("modal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
