<?php
$infoContent['g_title'] = "Édition : ".$cardName;
$editorFunctionBar = '<div class="editor-bar">';
foreach ($config['general']['editor-bar'] as $groupNumber => $groupData) {
	$editorFunctionBar .= '<div class="editor-bar_group">';
	foreach ($config['general']['editor-bar'][$groupNumber] as $formatNumber => $formatNumber) {
		$editorFunction = $config['general']['editor-bar'][$groupNumber][$formatNumber];
		$editorFunctionBar .= '<img class="edit-object" src="'.$config['general']['path'].'/content/icons/editor/'.$editorFunction['name'].'.svg" title="'.$lang['editor-bar'][$editorFunction['name']].'" alt="'.$lang['editor-bar'][$editorFunction['name']].'" onclick="addTextElement(\''.$editorFunction['format'].'\', '.$editorFunction['cursor_move'].')">';
	}
	$editorFunctionBar .= '</div>';
}
$editorFunctionBar .= '</div>';
if ($loadedDB['hidden'] == 1) $hideCheckboxValue = "checked=\"checked\"";
else $hideCheckboxValue = "";

$editForm = <<<EDITORFORM
<h1>{$lang['footer-edit_page']} "[CARD_NAME]"</h1>
<div class="cardEditor">
	[QUOTE_EDITION_BAR]
	<textarea id="textEdit" required="" maxlength="1000000" name="text">[QUOTE_TEXT]</textarea>
	<label for="hide-card">{$lang['edition-hide_card']}</label>
	<input id="hide-card" type="checkbox" name="hide-card" [QUOTE_EDITION_HIDECHECK]><br><br>
	<label for="group">{$lang['edition-group_placeholder']}</label>
	<input id="group" type="text" name="group" required="" placeholder="{$lang['edition-group_placeholder']}" value="[QUOTE_EDITION_GROUPNAME]"><br><br>
	<label for="pass">{$lang['edition-password']}</label>
	<input id="pass" type="password" name="pass" required="" placeholder="{$lang['edition-password']}">
	<button style="cursor:pointer" class="submit" onclick="changeCard('[API_URL]','[CARD_TYPE]','[CARD_NAME]')">Envoyer</button>
</div><br>
EDITORFORM;

$content['card'] = str_replace('[QUOTE_EDITION_BAR]', $editorFunctionBar, $editForm);
$content['card'] = str_replace('[QUOTE_EDITION_HIDECHECK]', $hideCheckboxValue, $content['card']);
$content['card'] = str_replace('[CARD_NAME]', $cardName, $content['card']);
$content['card'] = str_replace('[QUOTE_EDITION_GROUPNAME]', $searchInfo['group'], $content['card']);
$content['card'] = str_replace('[API_URL]', $config['general']['path']."/api/add.php", $content['card']);
$content['card'] = str_replace('[CARD_TYPE]', $type, $content['card']);
$content['card'] = str_replace('[CARD_NAME]', preg_replace('/\'/Um','\\\'',$cardName), $content['card']);
$content['card'] = str_replace('[QUOTE_TEXT]', $loadedDB['text'], $content['card']);
$content['card'] .= <<<FORMATINFO
<h1 style="text-align:center;display:block;">{$lang['help']}</h1>
<div class="flexboxData"">
	<div>
		<h2>Formatage normal</h2>
		- Vous pouvez ajouter une tabulation avec SHIFT + TAB.<br>
		- Titres : [h1]Titre[/h1] (Niveaux inferieurs : h2 à la place de h1)<br>
		- Italique : [i]Texte en italique[/i]<br>
		- Image : ![Description of the image](URL)<br>
		- Lien : [Description](URL)<br>
		- Son (mp3|wav|wave) : !(URL)<br>
		- Vidéo (mp4|webm|ogg|avi|mov) : !(URL)<br>
		  - Marche aussi avec les liens YouTube<br>
		- Citations : [quote]Texte de la citation[author]Auteur[/author][/quote]
	</div>
	<div>
		<h2>Les infobox</h2>
		- Une infobox se délimite par [ib]Données de l'infobox...[/ib]<br>
		- Dans les infobox, les tags [h1] et les images fonctionnent.<br>
		- Vous pouvez entrer des informations avec [ibd]Titre/nom|Information[/ibd]<br>
	</div>
	<div>
		<h2>Raccourcis</h2>
		- Créer une infobox rapidement : SHIFT + 1<br>
		- Créer une [ibd] rapidement : SHIFT + 2<br>
	</div>
	<div>
		<h2>{$lang['edition-info-example_title']}</h2>
		<pre>
[ib]
[h1]Debitis et qui[/h1]
![Quisquam quo enim](URL)
[h1]Nobis ut voluptatem[/h1]
[ibd]voluptates|24[/ibd]
[ibd]Cupiditate quas|Rem[/ibd]
[ibd]Est sit omnis|Occaecati labore soluta nam[/ibd]
[/ib]
Reiciendis et cum aut et omnis aliquam odit. Aspernatur nostrum esse consequuntur.
[h1]Lorem ipsum[/h1]
[quote]
Ut occaecati magni quis.
[author]Qui dolore quisquam[/author]
[/quote]
[i]Sit tempora sit qui qui tempora.[/i] Et facere odit minus doloribus inventore autem occaecati vel.
		</pre>
	</div>
</div>
FORMATINFO;
?>
