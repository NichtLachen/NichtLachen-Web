<?php

require_once (__DIR__ . '/classes/db/DatabaseAPI.php');
require_once (__DIR__ . '/include/version.php');

session_name("NL_SID");
if(session_status() == PHP_SESSION_NONE) {
	session_start();
}

$api = new DatabaseAPI();
$uid = $api->getUIDBySessionID(session_id());
if ($uid != null) {
	$user = $api->getUserByUID($uid);
}

$TITLE = "Regeln";

require_once (__DIR__ . '/templates/header.php');
require_once (__DIR__ . '/templates/navbar_back.php');
?>
		<div class="about">
			<h1>Regeln</h1>
			<ul>
				<li>kein spammen von Beiträgen und/oder Kommentaren</li>
				<li>keine Beleidigungen gegenüber anderen Usern</li>
				<li>freundlicher und respektvoller Umgang mit Usern</li>
				<li>nur Deutsch und Englisch schreiben</li>
				<li>kein Rassismus, Homophobie, Transphobie, Sexismus, Misogynie oder andere herabwürdigende Äußerungen</li>
				<li>kein Verbreiten von Propaganda</li>
				<li>keine Reposts</li>
				<li>in die richtigen Kategorien posten</li>
			</ul>
		</div>
<?php

require_once (__DIR__ . '/templates/footer.php');
?>
