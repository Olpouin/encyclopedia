<?php
$infoContent['g_title'] = "Administration";
$noPassword = <<<NOPASS
<h1>⚠ {$lang['password']} ⚠</h1><br>
<form action="" method="post" style="text-align:center;">
	<input class="input" type="password" name="pass" placeholder="{$lang['password']}">
</form>
NOPASS;
if (isset($_POST['pass'])) {
	if (password_verify($_POST['pass'],$config['general']['globalPassword'])) {
		$content['card'] = "Coming Soon";
	} else {
		$content['card'] = "<span style='text-align:center;font-size:5em;display:block;'>".$lang['wrong']."</span>".$noPassword;
	}
} else {
	$content['card'] = $noPassword;
}
?>
