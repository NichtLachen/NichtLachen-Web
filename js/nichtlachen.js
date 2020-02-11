function onLoad() {
	var scrollpos = localStorage.getItem('scrollpos');
	if (scrollpos) {
		console.log('Restoring scroll position...');
		localStorage.removeItem('scrollpos');
		window.scrollTo(0, scrollpos);
	}
}

function deleteConfirmClose(id) {
	document.getElementById('delete' + id).checked = false;
	return false;
}

function callURLWithReload(url) {
	console.log('Calling URL ' + url + '...');
	const XHR = new XMLHttpRequest();

	XHR.onreadystatechange = function() {
		if (XHR.readyState = XMLHttpRequest.DONE) {
			setTimeout(function() {
				console.log('Reloading page...');
				reload();
			}, 5);
		}
	}

	XHR.open('GET', url, true);
	XHR.send(null);

	return false;
}

function reload() {
	localStorage.setItem('scrollpos', window.pageYOffset);
	location.reload(true);
}

function back() {
	history.back();
	return false;
}

function goto(url) {
	window.location.href = url;
}

function sendForm(id, callback) {
	console.log('Sending form id:' + id);
	const form = document.getElementById(id);
	const XHR = new XMLHttpRequest();
	const data = new FormData(form);

	data.append('javascript', 'true');

	XHR.onreadystatechange = function() {
		if (XHR.readyState = XMLHttpRequest.DONE) {
			setTimeout(function() {
				callback();
			}, 5);
		}
	}

	XHR.open(form.method, form.action);
	XHR.send(data);

	return false;
}
