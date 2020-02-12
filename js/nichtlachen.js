function onLoad() {
	var showMore = localStorage.getItem('showMore');
	if (showMore) {
		localStorage.removeItem('showMore');

		more = JSON.parse(showMore);

		for (var i = 0; i < more.length; i++) {
			var checkbox = document.getElementById(more[i]);

			if (checkbox != null) {
				checkbox.checked = true;
			}
		}
	}

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

	var checkboxes = document.getElementsByClassName("showMore");

	if (checkboxes.length > 0) {
		var checkedCheckboxes = [];

		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].checked) {
				console.log('Saving showMore:' + checkboxes[i].id);
				checkedCheckboxes.push(checkboxes[i].id);
			}
		}

		localStorage.setItem('showMore', JSON.stringify(checkedCheckboxes));
	}

	location.reload(true);
}

function back() {
	history.back();
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
