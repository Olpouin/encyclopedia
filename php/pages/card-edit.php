<?php
Config::add('head.js', 'editor/editor.min');
Config::add('head.js', 'editor/tools/embed');
Config::add('head.js', 'editor/tools/header');
Config::add('head.js', 'editor/tools/list');
Config::add('head.js', 'editor/tools/quote');
Config::add('head.js', 'editor/tools/simple-image');
Config::add('head.js', 'editor/tools/strikethrough');
Config::add('head.js', 'editor/tools/subscript');
Config::add('head.js', 'editor/tools/superscript');
Config::add('head.js', 'editor/tools/table');
Config::add('head.js', 'editor/tools/underline');
$infoContent['g_title'] = "Édition : ".$cardName;

if ($card->hidden()) $hideCheckboxValue = "checked=\"checked\"";
else $hideCheckboxValue = "";
$text = nl2br($card->text());
$content['card'] = <<<CARDEDIT
<h1>{$lang['footer-edit_page']} "{$cardName}"</h1>
<input id="cardsName" value="{$cardName}" type="hidden">
<input id="cardsType" value="{$type}" type="hidden">
<div id="editor" class="format"></div>
<label for="hide-card">{$lang['edition-hide_card']}</label>
<input id="hide-card" type="checkbox" name="hide-card" {$hideCheckboxValue}><br><br>
<label for="group">{$lang['edition-group_placeholder']}</label>
<input id="group" type="text" name="group" required="" placeholder="{$lang['edition-group_placeholder']}" value="{$card->group()}"><br><br>
<label for="pass">{$lang['password']}</label>
<input id="pass" type="password" name="pass" required="" placeholder="{$lang['password']}">
<button class="submit" onclick="editCardOC()">{$lang['send']}</button>
<br>
<h1 style="text-align:center;display:block;">{$lang['help']}</h1>
<div class="flexboxData">
	<div>
		<h2>Les infobox</h2>
		- Une infobox se délimite par [ib]Données de l'infobox...[/ib]<br>
		- Dans les infobox, les tags [h1] et les images fonctionnent.<br>
		- Vous pouvez entrer des informations avec [ibd]Titre/nom|Information[/ibd]<br>
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
		</pre>
	</div>
</div>
<script>
const editor = new EditorJS({
	holder: 'editor',
	tools: {
		header: Header,
		quote: {
			class: Quote,
			inlineToolbar: true
		},
		list: {
			class: List,
			inlineToolbar: true
		},
		embed: {
			class: Embed,
			config: {
				services: {
					youtube:true
				}
			}
		},
		table: {
			class: Table,
			inlineToolbar: true
		},
		image: SimpleImage,
		strikethrough: Strikethrough,
		underline: Underline,
		subscript: {
			class: Subscript,
			shortcut: 'CTRL+DOWN'
		},
		superscript: {
			class: Superscript,
			shortcut: 'CTRL+UP'
		}
	},
	autofocus: true,
	onReady: () => {
		console.log('Editor.JS is ready!')
	},
	data: {blocks:{$text}}
});

function editCardOC() { //Edit a card
	editor.save().then((outputData) => {
		var text = outputData.blocks;
		API(
			'edit',
			{
				'type': value('cardsType'),
				'name': value('cardsName'),
				'text': text,
				'group': value('group'),
				'pass': value('pass'),
				'hide': document.getElementById('hide-card').checked
			},
			window.location.pathname.slice(0,-5)
		);
	}).catch((error) => {
		console.log('Error : ',error);
	})
}
</script>
CARDEDIT;
?>
