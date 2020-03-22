<?php
$noPassword = <<<NOPASS
<h1>⚠ Mot de passe ⚠</h1><br>
<form action="" method="post" style="text-align:center;">
	<input class="input" type="password" name="pass" placeholder="Mot de passe">
</form>
NOPASS;
if (isset($_POST['pass'])) {
	if (Config::checkPassword($_POST['pass'])) {
		$typesForm = '';
		foreach (Config::read('gene.types') as $key => $value) {
			$typesForm .= '<option value="'.$key.'">'.ucfirst($value).'</option>';
		}

		$siteName = Config::read('gene.site_name');
		$defaultImg = Config::read('gene.default_img');
		$content['page'] = <<<HOMEPAGEEDITMAIN
<h1>Interface d'administration</h1><br>
<input id="pass" value="{$_POST['pass']}" type="hidden">
<div class="flexboxData">
	<div>
		<h2>Créer une fiche</h2><br>
		<input id="add-name" type="text" required="" placeholder="Nom">
		<label for="add-name">Nom</label><br><br>
		<input id="add-group" type="text" required="" placeholder="Groupe">
		<label for="add-group">Groupe</label><br><br>
		<select id="add-type" required="">
			{$typesForm}
		</select>
		<label for="add-type">Type</label><br><br>
		<input id="add-pass" type="password" required="" placeholder="Mot de passe">
		<label for="add-pass">Mot de passe (Optionel)</label><br><br>
		<button class="submit" onclick="addCardOC()">Envoyer</button>
	</div>
	<div>
		<h2>Gérer les types</h2>
	</div>
	<div>
		<h2>Paramètres généraux</h2>
		<input id="gene-sitename" type="text" placeholder="Nom du site" value="{$siteName}">
		<label for="gene-sitename">Nom du site</label><br><br>
		<input id="gene-defimg" type="text" placeholder="Image par défaut" value="{$defaultImg}">
		<label for="gene-defimg">Image par défaut des cadres d'aperçu</label><br><br>
		<button class="submit" onclick="changeMainParam()">Envoyer</button>
	</div>
	<div>
	</div>
</div>
HOMEPAGEEDITMAIN;
	} else {
		$content['page'] = "<span style='text-align:center;font-size:5em;display:block;'>Mauvais mot de passe.</span>".$noPassword;
	}
} else {
	$content['page'] = $noPassword;
}
$content['title'] = "Administration";
?>
