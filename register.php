<?php

function sendVerifyMail(string $email, string $key) {
	$headers = "From: NichtLachen.nl <verify@nichtlachen.nl>";
	$subject = "NichtLachen.nl | E-Mail bestätigen";
	$content = "Willkommen auf NichtLachen.nl, bitte bestätigen Sie Ihre E-Mail Adresse indem Sie auf den folgenden Link in ihrem Browser öffnen: ";
	$content = $content . "\n" . "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?key=" . $key;

	mail($email, $subject, $content, $headers);
}

?>
