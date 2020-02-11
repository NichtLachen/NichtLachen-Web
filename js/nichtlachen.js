function deleteConfirmClose(id) {
	document.getElementById('delete' + id).checked = false;
	return false;
}

function deleteConfirmed(id, url) {
	const XHR = new XMLHttpRequest();

	XHR.onreadystatechange = function() {
		if (XHR.readyState = XMLHttpRequest.DONE) {
			document.getElementById(id).style.display = 'none';
			document.getElementById('delete' + id).checked = false;
		}
	}

	XHR.open('GET', url, true);
	XHR.send(null);

	return false;
}

function reload() {
	window.location.reload(true);
}

function back() {
	history.back();
	return false;
}

function sendForm(id, callback) {
	const form = document.getElementById(id);
	const XHR = new XMLHttpRequest();
	const data = new FormData(form);

	XHR.onreadystatechange = function() {
		if (XHR.readyState = XMLHttpRequest.DONE) {
			setTimeout(function() {
				callback();
			}, 100);
		}
	}

	XHR.open(form.method, form.action);
	XHR.send(data);

	return false;
}
