var sid;
var socket;

function connectPushService(sid) {
	this.sid = sid;
	socket = new WebSocket("wss://dev.nichtlachen.nl/websocket");

	socket.onopen = function () {
		console.log("Connection to WebSocket established.");

		sendPushService(sid);
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

		connectPushService(this.sid);
	};
}


function sendPushService(msg) {
	if (socket != null && socket.readyState == WebSocket.OPEN) {
		socket.send(msg);
	}
}
