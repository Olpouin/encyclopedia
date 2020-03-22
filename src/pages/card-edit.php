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
$cardName = urldecode($_GET['name']);

$card = new Card();
if ($card->load($_GET['type'], $cardName)) {

if ($card->hidden()) $hideCheckboxValue = "checked=\"checked\"";
else $hideCheckboxValue = "";
$text = nl2br($card->text());

$content['title'] = "Édition : ".$cardName." (".ucfirst(Config::read('gene.types')[$_GET['type']]).")";
$content['page'] = <<<CARDEDIT
<h1>Modifier la fiche "{$cardName}"</h1>
<input id="cardsName" value="{$cardName}" type="hidden">
<div id="editor" class="format"></div>
<label for="hide-card">Cacher la fiche (ne pas afficher dans la barre de navigation)</label>
<input id="hide-card" type="checkbox" name="hide-card" {$hideCheckboxValue}><br><br>
<label for="group">Groupe de la fiche</label>
<input id="group" type="text" name="group" required="" placeholder="Groupe de la fiche" value="{$card->group()}"><br><br>
<label for="pass">Mot de passe</label>
<input id="pass" type="password" name="pass" required="" placeholder="Mot de passe">
<button class="submit" onclick="editCardOC()">Envoyer</button>
<br>
<h1 style="text-align:center;display:block;">Aide</h1>
<div class="flexboxData">
	<div>
		<h2>Les infobox</h2>
		- Une infobox se délimite par [ib]Données de l'infobox...[/ib]<br>
		- Dans les infobox, les tags [h1] et les images fonctionnent.<br>
		- Vous pouvez entrer des informations avec [ibd]Titre/nom|Information[/ibd]<br>
	</div>
	<div>
		<h2>Exemple</h2>
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
	data: {$text}
});

function editCardOC() { //Edit a card
	editor.save().then((outputData) => {
		var text = outputData;
		API(
			'edit',
			{
				'type': '{$_GET['type']}',
				'name': '{$cardName}',
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
}


?>
