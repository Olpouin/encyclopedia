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
$card = new Card();
if ($card->load("[SERVERDATA]", "homepage")) {
$text = $card->text();

$content['title'] = "Modifier la page d'accueil";
$content['page'] = <<<CARDEDIT
<h1>Modifier la page d'accueil</h1>
<div id="editor"></div><br>
<label for="pass">Mot de passe</label>
<input id="pass" type="password" name="pass" required="" placeholder="Mot de passe">
<button class="submit" onclick="editHomepage()">Envoyer</button>
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

function editHomepage() { //Edit a card
	editor.save().then((outputData) => {
		var text = outputData;
		API(
			'homepage',
			{
				'text': text,
				'pass': value('pass')
			},
			window.location.pathname.slice(0,-4)
		);
	}).catch((error) => {
		console.log('Error : ',error);
	})
}
</script>
CARDEDIT;
}


?>
