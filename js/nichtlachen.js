function onLoad() {
	var showMore = JSON.parse(sessionStorage.getItem('showMore'));
	if (showMore) {
		sessionStorage.removeItem('showMore');

		for (var i = 0; i < showMore.length; i++) {
			var checkbox = document.getElementById(showMore[i]);

			if (checkbox != null) {
				checkbox.checked = true;
			}
		}
	}

	var navbar_back = document.getElementById('navbar_back');
	var backScrollpos = JSON.parse(sessionStorage.getItem('back_scrollpos'));

	if (backScrollpos) {
		console.log("Found back_scrollpos array");
		for (var i = 0; i < backScrollpos.length; i++) {
			console.log("Found back_scrollpos entry: " + backScrollpos[i].url);
			if (backScrollpos[i].url === window.location.href) {
				console.log("Restoring scroll position...");
				window.scrollTo(0, backScrollpos[i].scrollpos);
				break;
			}
		}
	}

	if (!navbar_back) {
		sessionStorage.removeItem('back_scrollpos');
	}

	window.onbeforeunload = function() {
		var backScrollpos = JSON.parse(sessionStorage.getItem('back_scrollpos'));
		if (!backScrollpos) {
			backScrollpos = [];
		}

		for (var i = 0; i < backScrollpos.length; i++) {
			if (backScrollpos[i].url === window.location.href) {
				backScrollpos.splice(i);
			}
		}

		backScrollpos.push({ url:window.location.href, scrollpos: window.pageYOffset});
		sessionStorage.setItem('back_scrollpos', JSON.stringify(backScrollpos));
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

	if (window.NichtLachen && window.NichtLachen.setStatusBarColor && window.NichtLachen.setNavigationBarColor) {
		var style = getComputedStyle(document.body);
		var colorSecondaryBackground = style.getPropertyValue('--colorSecondaryBackground');

		if (colorSecondaryBackground != null) {
			window.NichtLachen.setStatusBarColor(colorSecondaryBackground);
			window.NichtLachen.setNavigationBarColor(colorSecondaryBackground);
		}
	}

	// PushService
	connectPushService(getSessionID());
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

function getSessionID() {
	return getCookie("NL_SID");
}

function reload() {
	console.log('Reloading page...');
	sessionStorage.setItem('scrollpos', window.pageYOffset);

	var checkboxes = document.getElementsByClassName("showMore");

	if (checkboxes.length > 0) {
		var checkedCheckboxes = [];

		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].checked) {
				console.log('Saving showMore:' + checkboxes[i].id);
				checkedCheckboxes.push(checkboxes[i].id);
			}
		}

		sessionStorage.setItem('showMore', JSON.stringify(checkedCheckboxes));
	}

	location.reload(true);
}

function back() {
	var navbar_back = document.getElementById('navbar_back');

	if (navbar_back) {
		window.location.href = navbar_back.href.split("#")[0];
	}

	return false;
}

function goto(url) {
	window.location.href = url;
}

function share(text) {
	if (window.NichtLachen && window.NichtLachen.shareURL) {
		window.NichtLachen.shareURL(text);
	} else {
		window.prompt("Zum Teilen kopieren: ", text);
	}
}
