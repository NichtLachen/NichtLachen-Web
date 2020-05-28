var socket;

function connectPushService(sid) {
	socket = new WebSocket("wss://" + location.host + "/websocket");

	socket.onopen = function () {
		console.log("Connection to WebSocket established.");

		login(sid);
	};

	socket.onmessage = function (messageEvent) {
		console.log(messageEvent.data);
	};

	socket.onerror = function (errorEvent) {
		console.log("Error! Connection closed.");
	};

	socket.onclose = function (closeEvent) {
		console.log('Connection to WebSocket closed!');
		console.log('Reconnecting...');

		connectPushService(sid);
	};
}

function login(sid) {
	var jsonData = {};
	jsonData['type'] = "login";
	jsonData['content'] = sid;

	sendPushService(JSON.stringify(jsonData));
}

function sendPushService(msg) {
	if (socket != null && socket.readyState == WebSocket.OPEN) {
		socket.send(msg);
	}
}
