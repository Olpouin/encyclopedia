<?php
if (!isset($_GET['edit'])) {
	$footerEditURL = "edit";
	$footerEditTXT = "Modifier la page";
} else {
	$footerEditURL = substr($_SERVER['REQUEST_URI'], 0, -5);
	$footerEditTXT = "Afficher la page";
}
if (!isset($_GET['type']) AND !isset($_GET['admin'])) $admin = "<a href=\"".Config::read('gene.path')."/admin/\">Interface d'administration</a>";
else $admin = "";

$footerPath = Config::read('gene.path');
$content['footer'] = <<<FOOTER
<a href='https://github.com/Olpouin/gallery' target='_blank'>Code sur GitHub</a>
<a href="{$footerEditURL}">{$footerEditTXT}</a>
{$admin}
<a href="{$footerPath}/#pref">Préférences</a>
<a href="#card">Retour en hauit de page</a>
FOOTER;
?>
