function onLoad() {
	var scrollpos = localStorage.getItem('scrollpos');
	if (scrollpos) {
		console.log('Restoring scroll position...');
		localStorage.removeItem('scrollpos');
	
		setTimeout(function() {
			window.scrollTo(0, scrollpos);
		}, 0);
	}
}

function deleteConfirmClose(id) {
	document.getElementById('delete' + id).checked = false;
	return false;
}

function callURLWithReload(url) {
	console.log('Calling URL ' + url + '...');
	const XHR = new XMLHttpRequest();

	XHR.addEventListener('loadend', function() {
		setTimeout(function() {
			reload();
		}, 0);
	});

	XHR.open('GET', url, true);
	XHR.send(null);

	return false;
}

function reload() {
	console.log('Reloading page...');
	localStorage.setItem('scrollpos', window.pageYOffset);
	location.reload(true);
}

function back() {
	const urlParams = new URLSearchParams(window.location.search);
	const fromUrl = urlParams.get('from');
	var fallback = fromUrl != null ? fromUrl : "./";
	history.back();
	window.location.href = fallback;
	return false;
}

function goto(url) {
	window.location.href = url;
}

function sendForm(id, callback, disable, addContent) {
	console.log('Sending form id:' + id);
	const form = document.getElementById(id);

	if (disable) {
		form.onsubmit = function() { return false; };
	}

	const XHR = new XMLHttpRequest();
	const data = new FormData(form);

	data.append('javascript', 'true');

	XHR.addEventListener('loadend', function() {
		setTimeout(function() {
			callback();

			if(addContent) {
				var body = document.getElementsByTagName("BODY")[0];
				body.innerHTML += XHR.responseText;
			}
		}, 0);
	});

	XHR.open(form.method, form.action);
	XHR.send(data);

	return false;
}
