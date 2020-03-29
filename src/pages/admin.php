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
		$content['page'] = <<<HOMEPAGEEDITMAIN
<h1>Interface d'administration</h1><br>
<input id="pass" value="{$_POST['pass']}" type="hidden">
<div class="flexboxData">
	<div>
		<h2>Créer une fiche</h2>
		<form action="" onsubmit="addCardOC();return false;">
			<input id="add-name" type="text" placeholder="Nom" required="">
			<label for="add-name">Nom</label><br><br>
			<input id="add-group" type="text" placeholder="Groupe" required="">
			<label for="add-group">Groupe</label><br><br>
			<select id="add-type" required="">
				{$typesForm}
			</select>
			<label for="add-type">Type</label><br><br>
			<input id="add-pass" type="password" placeholder="Mot de passe">
			<label for="add-pass">Mot de passe (Optionel)</label><br><br>
			<input type="submit">
		</form>
	</div>
	<div>
		<h2>Supprimer une fiche</h2>
	</div>
	<div>
		<h2>Créer une catégorie</h2>
		<form action="" onsubmit="addNewType();return false;">
			<input id="type-add-id" type="text" placeholder="b" pattern="[a-z0-9]*" required="">
			<label for="type-add-id">ID de la catégorie</label><br><br>
			<input id="type-add-name" type="text" placeholder="Bestiaire" required="">
			<label for="type-add-name">Nom de la catégorie</label><br><br>
			<input type="submit">
		</form>
	</div>
	<div>
		<h2>Supprimer une catégorie</h2>

	</div>
	<div>
		<h2>Paramètres généraux</h2>
		<form action="" onsubmit="changeMainParam();return false;">
			<input id="gene-sitename" type="text" placeholder="Nom du site" value="{$config->read('gene.site_name')}" pattern=".{1,20}" required="">
			<label for="gene-sitename">Nom du site</label><br><br>
			<input id="gene-defimg" type="text" placeholder="Image par défaut" value="{$config->read('gene.default_img')}" pattern=".{7,100}" required="">
			<label for="gene-defimg">Image par défaut des cadres d'aperçu</label><br><br>
			<input type="submit">
		</form>
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
