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
		$typesForm = '';
		foreach ($config['types'] as $key => $value) {
			$typesForm .= '<option value="'.$key.'">'.$value.'</option>';
		}
		$content['card'] = <<<HOMEPAGEEDITMAIN
<h1>{$lang['admin-title']}</h1><br>
<div class="flexboxData">
	<div>
		<h2>{$lang['admin-createcard']}</h2><br>
		<input id="name" type="text" name="group" required="" placeholder="{$lang['edition-name_placeholder']}">
		<label for="name">{$lang['edition-name_placeholder']}</label><br><br>
		<input id="group" type="text" name="group" required="" placeholder="{$lang['edition-group_placeholder']}">
		<label for="group">{$lang['edition-group_placeholder']}</label><br><br>
		<select id="type">
			{$typesForm}
		</select>
		<label for="type">{$lang['edition-type_placeholder']}</label><br><br>
		<input id="pass" type="password" name="pass" required="" placeholder="{$lang['password']}">
		<label for="pass">{$lang['password']}</label><br><br>
		<button class="submit" onclick="API('add',{'type':document.getElementById('type').value,'name':document.getElementById('name').value,'group':document.getElementById('group').value}, path+'/'+document.getElementById('type').value+'/'+document.getElementById('name').value)">{$lang['send']}</button>
	</div>
	<div>
		<h2>Gérer les types</h2>
	</div>
</div>
HOMEPAGEEDITMAIN;
	} else {
		$content['card'] = "<span style='text-align:center;font-size:5em;display:block;'>".$lang['wrong']."</span>".$noPassword;
	}
} else {
	$content['card'] = $noPassword;
}
?>
