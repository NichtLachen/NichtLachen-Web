function onLoad() {
	var lasturl = localStorage.getItem('lastUrl');

	if (window.location.href == lasturl) {
		console.log('back() did not work, retrying');
		back();
	} else {
		localStorage.removeItem('lastUrl');
	}

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

		window.scrollTo(0, scrollpos);
		setTimeout(function() { // for Android
			window.scrollTo(0, scrollpos);
		}, 0);
	}

	var parts = window.location.href.split("#");
	window.history.replaceState({}, window.title, parts[0]);

	if (parts.length > 1) {
		var element = document.getElementById(parts[1]);

		if (element) {
			element.scrollIntoView();
			setTimeout(function() { // for Android
				element.scrollIntoView();
			}, 0);
		}
	}

	if (window.pageYOffset > 0) {
		document.getElementsByClassName("topnav")[0].style.visibility = "hidden"; // hide navbar if not at top of page

		setTimeout(function() {
			document.getElementsByClassName("topnav")[0].style.visibility = "visible"; // show navbar
		}, 300);
	}

	setTimeout(function() { // for Android
		// clear last search queries
		var elements = document.getElementsByClassName("search");

		if(elements) {
			for (var i = 0; i < elements.length; i++) {
				elements[i].value = "";
			}
		}
	}, 0);


	// hide navbar
	var prevScrollpos = window.pageYOffset;
	window.onscroll = function() {
		var currentScrollPos = window.pageYOffset;
		if (prevScrollpos > currentScrollPos) {
			document.getElementsByClassName("topnav")[0].style.top = "0";
		} else {
			document.getElementsByClassName("topnav")[0].style.top = "-8em";
		}
		prevScrollpos = currentScrollPos;
	}

	if (NichtLachen && NichtLachen.setStatusBarColor && NichtLachen.setNavigationBarColor) {
		var style = getComputedStyle(document.body);
		var colorSecondaryBackground = style.getPropertyValue('--colorSecondaryBackground');

		if (colorSecondaryBackground != null) {
			NichtLachen.setStatusBarColor(colorSecondaryBackground);
			NichtLachen.setNavigationBarColor(colorSecondaryBackground);
		}
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

function getParam(paramName) {
	var result = null,
		tmp = [];
	var items = location.search.substr(1).split("&");
	for (var index = 0; index < items.length; index++) {
		tmp = items[index].split("=");
		if (tmp[0] === paramName) result = decodeURIComponent(tmp[1]);
	}

	return result;
}

function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for(var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
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
	var lasturl = window.location.href;
	localStorage.setItem('lastUrl', lasturl);
	history.back();

	return false;
}

function goto(url) {
	window.location.href = url;
}
