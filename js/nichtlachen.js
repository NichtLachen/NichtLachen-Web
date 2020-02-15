function onLoad() {
	var lasturl = localStorage.getItem('lastUrl');
	if (window.location.href == lasturl) {
		console.log('back() did not work, retrying');
		back();
	}

	localStorage.removeItem('lastUrl');

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

function removeParam(key, sourceURL) {
	var rtn = sourceURL.split("?")[0],
		param,
		params_arr = [],
		queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
	if (queryString !== "") {
		params_arr = queryString.split("&");
		for (var i = params_arr.length - 1; i >= 0; i -= 1) {
			param = params_arr[i].split("=")[0];
			if (param === key) {
				params_arr.splice(i, 1);
			}
		}
		rtn = rtn + "?" + params_arr.join("&");
	}

	return rtn;
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
	localStorage.setItem('lastUrl', removeParam('errors', window.location.href)); // needed for editprofile.php
	history.back();
	return false;
}

function goto(url) {
	window.location.href = url;
}
