<?php
if (isset($_GET['admin'])) $footerEdit = "";
elseif (!isset($_GET['edit'])) $footerEdit = "<a href=\"edit\">Modifier la page</a>";
else $footerEdit = "<a href=\"".substr($_SERVER['REQUEST_URI'], 0, -4)."\">Afficher la page</a>";

$footerPath = Config::read('gene.path');
$content['footer'] = <<<FOOTER
<a href='https://github.com/Olpouin/gallery' target='_blank'>Code sur GitHub</a>
{$footerEdit}
<a href="{$config->read('gene.path')}/admin/">Interface d'administration</a>
<a href="{$footerPath}/#pref">Préférences</a>
<a href="#card">Retour en haut de page</a>
FOOTER;
?>
