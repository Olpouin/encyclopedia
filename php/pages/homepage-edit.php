<?php
$infoContent['g_title'] = "Administration";
$noPassword = <<<NOPASS
<h1>⚠ {$lang['password']} ⚠</h1><br>
<form action="" method="post" style="text-align:center;">
	<input class="input" type="password" name="pass" placeholder="{$lang['password']}">
</form>
NOPASS;
if (isset($_POST['pass'])) {
	if (Config::checkPassword($_POST['pass'])) {
		$isAdmin = true;
		$langForm = "";
		foreach ($config['lang'] as $key => $value) {
			$langSelected = ($key == Config::read('gene.default_lang')) ? "selected='selected'" : "";
			$langForm .= "<option {$langSelected} value='{$key}'>{$value}</option>";
		}
		$typesForm = '';
		foreach (Config::read('gene.types') as $key => $value) {
			$typesForm .= '<option value="'.$key.'">'.ucfirst($value).'</option>';
		}

		$siteName = Config::read('gene.site_name');
		$defaultImg = Config::read('gene.default_img');
		$content['card'] = <<<HOMEPAGEEDITMAIN
<h1>{$lang['admin-title']}</h1><br>
<input id="pass" value="{$_POST['pass']}" type="hidden">
<div class="flexboxData">
	<div>
		<h2>{$lang['admin-createcard']}</h2><br>
		<input id="add-name" type="text" required="" placeholder="{$lang['edition-name_placeholder']}">
		<label for="add-name">{$lang['edition-name_placeholder']}</label><br><br>
		<input id="add-group" type="text" required="" placeholder="{$lang['edition-group_placeholder']}">
		<label for="add-group">{$lang['edition-group_placeholder']}</label><br><br>
		<select id="add-type" required="">
			{$typesForm}
		</select>
		<label for="add-type">{$lang['edition-type_placeholder']}</label><br><br>
		<input id="add-pass" type="password" required="" placeholder="{$lang['password']}">
		<label for="add-pass">{$lang['password']} ({$lang['optional']})</label><br><br>
		<button class="submit" onclick="addCardOC()">{$lang['send']}</button>
	</div>
	<div>
		<h2>Gérer les types</h2>
	</div>
	<div>
		<h2>Paramètres généraux</h2>
		<select id="gene-lang">
			{$langForm}
		</select>
		<label for="gene-lang">{$lang['edition-gene-deflang_placeholder']}</label><br><br>
		<input id="gene-sitename" type="text" placeholder="{$lang['edition-gene-sitename_placeholder']}" value="{$siteName}">
		<label for="gene-sitename">{$lang['edition-gene-sitename_placeholder']}</label><br><br>
		<input id="gene-defimg" type="text" placeholder="{$lang['edition-gene-defimg_placeholder']}" value="{$defaultImg}">
		<label for="gene-defimg">{$lang['edition-gene-defimg_placeholder']}</label><br><br>
		<button class="submit" onclick="changeMainParam()">{$lang['send']}</button>
	</div>
	<div>
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
