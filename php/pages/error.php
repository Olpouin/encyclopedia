<?php
$infoContent['g_title'] = "Erreur";

if (isset($err)) $error = $err;
else $error = "Unknown error";
$errorMessages = $lang['error']['error_messages'];

if (array_key_exists($error,$errorMessages)) $errorMessage = $errorMessages[$error];
else {
	$errorMessage = $errorMessages['Unknown error'];
	$error = "Unknown error";
}

$errorCode = "====== ERROR CODE REPORT\r\nERROR: ".htmlentities($error)."\r\nDATE : ".date('o-m-d H:i:s P')."\r\nURL  : ".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\r\n======";

$content['card'] = <<<ERRORPAGE
<h1>{$error}</h1>
<div><p>{$errorMessage}</p></div>
<div id="error-code" style="top: 100%;">
	{$lang['error']['menu-send_message']}
	<pre>{$errorCode}</pre>
</div>
ERRORPAGE;
?>
