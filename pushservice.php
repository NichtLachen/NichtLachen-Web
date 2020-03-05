#!/usr/bin/env php
<?php

$socket = socket_create(AF_INET6, SOCK_STREAM, getprotobyname('tcp'));
socket_bind($socket, '::', 44100);
socket_set_nonblock($socket);
socket_listen($socket, 512);

$unix = socket_create(AF_UNIX, SOCK_STREAM, 0);
socket_bind ($unix, __DIR__ . '/pushservice.sock');
socket_listen($unix, 512);

while (true) {
	if (($client = socket_accept($socket))) {
		socket_set_nonblock($client);
	}
}

?>
