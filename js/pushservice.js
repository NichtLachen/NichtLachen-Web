var socket;
var pingTask;

function ping() {
	var jsonData = {};
	jsonData['type'] = "ping";
	jsonData['content'] = 1;

	sendPushService(JSON.stringify(jsonData));
}

function connectPushService(sid) {
	socket = new WebSocket("wss://" + location.host + "/websocket");

	socket.onopen = function () {
		console.log("Connection to WebSocket established.");

		login(sid);
		pingTask = setInterval(ping, 30000);
	};

	socket.onmessage = function (messageEvent) {
		console.log(messageEvent.data);
	};

	socket.onerror = function (errorEvent) {
		console.log("Error! Connection closed.");
	};

	socket.onclose = function (closeEvent) {
		if (closeEvent.code != 1001) { // closed by reloading page or socket.close()
			console.log('Connection to WebSocket closed!');
			console.log('Reconnecting...');

			clearInterval(pingTask);
			connectPushService(sid);
		}
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
