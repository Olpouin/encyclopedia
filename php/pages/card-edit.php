<?php
$infoContent['g_title'] = "Édition : ".$cardName;

$fURL = $config['general']['path']."/content/icons/editor/";
$fARR = $lang['editor-bar'];
$editorBar = '<div class="editor-bar">';
foreach ($config['general']['editor-bar'] as $groupNumber => $groupData) {
	$editorBar .= '<div class="editor-bar_group">';
	foreach ($config['general']['editor-bar'][$groupNumber] as $formatNumber => $formatNumber) {
		$editor = $config['general']['editor-bar'][$groupNumber][$formatNumber];
		$edFormat = $editor['format'];
		$edName = $editor['name'];
		if (!isset($editor['e'])) $editor['e'] = "";
		$editorBar .= '<div tt-hlp="'.$editor['e'].'" tt-cmd="'.$edFormat.'" tt-name="'.$fARR[$edName].'" onclick="addText(\''.$edFormat.'\', '.$editor['cursor'].')">
			<img src="'.$fURL.$edName.'.svg" alt="'.$fARR[$edName].'">
		</div>';
	}
	$editorBar .= '</div>';
}
$editorBar .= '</div>';

if ($loadedDB['hidden'] == 1) $hideCheckboxValue = "checked=\"checked\"";
else $hideCheckboxValue = "";

$cardNameReplaced = preg_replace('/\'/Um','\\\'',$cardName);


$content['card'] = <<<CARDEDIT
<h1>{$lang['footer-edit_page']} "{$cardName}"</h1>
{$editorBar}
<div id="textEdit" required="" maxlength="1000000" name="text">{$loadedDB['text']}</div>
<label for="hide-card">{$lang['edition-hide_card']}</label>
<input id="hide-card" type="checkbox" name="hide-card" {$hideCheckboxValue}><br><br>
<label for="group">{$lang['edition-group_placeholder']}</label>
<input id="group" type="text" name="group" required="" placeholder="{$lang['edition-group_placeholder']}" value="{$searchInfo['group']}"><br><br>
<label for="pass">{$lang['password']}</label>
<input id="pass" type="password" name="pass" required="" placeholder="{$lang['password']}">
<button class="submit" onclick="API('edit',{'type':'{$type}','name':'{$cardNameReplaced}','text':document.getElementById('textEdit').value,'group':document.getElementById('group').value,'pass':document.getElementById('pass').value,'hide':document.getElementById('hide-card').checked},window.location.pathname.slice(0,-5))">{$lang['send']}</button>
<br>
<h1 style="text-align:center;display:block;">{$lang['help']}</h1>
<div class="flexboxData">
	<div>
		<h2>Formatage normal</h2>
		- Couleur : [c]Texte[/c]<br>
		- Couleur custom : [c#HEXA00]Texte[/c]<br>
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
CARDEDIT;
?>
