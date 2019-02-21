<?php
if (isset($_COOKIE['lang'])) {
	if ($_COOKIE['lang']) {
		if (file_exists(htmlentities('lang/'.$_COOKIE['lang'].'.php'))) {
			$langFile = "lang/".$_COOKIE['lang'].".php";
		} else {
			$langFile = "lang/fr.php";
		}
	} else {
		$langFile = "lang/fr.php";
	}
} else {
	$langFile = "lang/fr.php";
}
require_once $langFile; //The language file
/*General configuration.*/
$config['database'] = array(
	"host" => "",
	"name" => "",
	"username" => "",
	"password" => ""
);
$config['types'] = array(
	"b" => "bestiaire",
	"p" => "personnages",
	"l" => "lieux",
	"e" => "entités"
);
$config['head-content'] = array(
	"title" => " • Galerie",
	"site_name" => "Gallery"
);
$config['general'] = array(
	"globalPassword" => '', //The general password. Hash with "password_hash("YOURPASSWORD", PASSWORD_DEFAULT);"
	"language" => "fr",
	"sidenav_title" => "Galerie"
);
$config['homepage'] = array(
	"box-default_image" => "https://img.jpg",
	"box-top_message" => "La galerie a un total de [TOTALPAGES] pages."
);
$config['homepage']['top_description'] = <<<HOMEPAGETOPDESC
Homepage
HOMEPAGETOPDESC;
$config['general']['editor-bar'] = array(
	array(
		array(
			"name" => $lang['editor-bar']['title1'],
			"format" => "[h1][/h1]",
			"cursor_move" => "4",
			"icon" => "format-title1"
		),
		array(
			"name" => $lang['editor-bar']['title2'],
			"format" => "[h2][/h2]",
			"cursor_move" => "4",
			"icon" => "format-title2"
		),
		array(
			"name" => $lang['editor-bar']['title3'],
			"format" => "[h3][/h3]",
			"cursor_move" => "4",
			"icon" => "format-title3"
		),
		array(
			"name" => $lang['editor-bar']['title4'],
			"format" => "[h4][/h4]",
			"cursor_move" => "4",
			"icon" => "format-title4"
		),
		array(
			"name" => $lang['editor-bar']['title5'],
			"format" => "[h5][/h5]",
			"cursor_move" => "4",
			"icon" => "format-title5"
		),
		array(
			"name" => $lang['editor-bar']['title6'],
			"format" => "[h6][/h6]",
			"cursor_move" => "4",
			"icon" => "format-title6"
		)
	),
	array(
		array(
			"name" => $lang['editor-bar']['italic'],
			"format" => "[i][/i]",
			"cursor_move" => "3",
			"icon" => "format-italic"
		),
		array(
			"name" => $lang['editor-bar']['bold'],
			"format" => "[b][/b]",
			"cursor_move" => "3",
			"icon" => "format-bold"
		),
		array(
			"name" => $lang['editor-bar']['strikethrough'],
			"format" => "[s][/s]",
			"cursor_move" => "3",
			"icon" => "format-strikethrough"
		),
		array(
			"name" => $lang['editor-bar']['underlined'],
			"format" => "[u][/u]",
			"cursor_move" => "3",
			"icon" => "format-underlined"
		)
	),
	array(
		array(
			"name" => $lang['editor-bar']['img'],
			"format" => "![]()",
			"cursor_move" => "2",
			"icon" => "special-image"
		),
		array(
			"name" => $lang['editor-bar']['url'],
			"format" => "[]()",
			"cursor_move" => "1",
			"icon" => "special-url"
		),
		array(
			"name" => $lang['editor-bar']['sound'],
			"format" => "!()",
			"cursor_move" => "2",
			"icon" => "special-sound"
		),
		array(
			"name" => $lang['editor-bar']['video'],
			"format" => "!()",
			"cursor_move" => "2",
			"icon" => "special-video"
		),
	),
	array(
		array(
			"name" => $lang['editor-bar']['quote'],
			"format" => "[quote][author][/author][/quote]",
			"cursor_move" => "7",
			"icon" => "special-quote"
		),
		array(
			'name' => $lang['editor-bar']['hr'],
			"format" => "[hr]",
			"cursor_move" => "4",
			"icon" => "special-hr"
		)
	)
);

$markdownArray = array(
	'/\[h([1-6])\](.*)\[\/h[1-6]\]/Ums' => '<h$1 id="$2">$2</h1>',
	'/\[hr\]/Ums' => '<hr>',
	'/\[i\](.*)\[\/i\]/Ums' => '<i>$1</i>',
	'/\[b\](.*)\[\/b\]/Ums' => '<b>$1</b>',
	'/\[s\](.*)\[\/s\]/Ums' => '<s>$1</s>',
	'/\[u\](.*)\[\/u\]/Ums' => '<u>$1</u>',
	'/\[quote\](.*)\[author\](.*)\[\/author\]\[\/quote\]/Ums' => '<blockquote><span>$1</span><cite>— $2</cite></blockquote>',
	'/\[ib\](.*)\[\/ib\]/Ums' => '<aside class="infobox">$1</aside>',
	'/\[ibd\](.*)\|(.*)\[\/ibd\]/Ums' => '<div class="infobox-data"><span class="infobox-data-title">$1</span><span>$2</span></div>',
	'/\!\[(.*)\]\((.*)\)/Ums' => '<img src="$2" onclick="openImg(event)" alt="$1">',
	'/\!\(https?\:\/\/www\.youtube\.com\/watch\?v\=(.*)\)/Ums' => '<iframe width="560" height="315" frameborder="0" src="https://www.youtube-nocookie.com/embed/$1" allowfullscreen></iframe>',
	'/\!\((https?\:\/\/.*\.(mp3|wav|wave))\)/Ums' => '<audio controls><source src="$1" type="audio/$2"></audio>',
	'/\!\((https?\:\/\/.*\.(mp4|webm|ogg|avi|mov))\)/Ums' => '<video controls><source src="$1" type="video/$2"></video>',
	'/\[(.*)\]\(https?\:\/\/(.*)\)/Ums' => '<a href="$2" target="_blank">$1</a>'
);
/*More advanced data if you want to change something*/
$HTMLdata['homepage-search'] = <<<HOMEPAGESEARCH
<label for="card-search-homepage">{$lang['homepage-search_input']}</label>
<form action="" class="cardSearchBox">
	<input id="card-search-homepage" class="cardSearch" type="text" name="search" placeholder="{$lang['homepage-search_input']}">
	<input class="cardSearch-button" type="submit" value="{$lang['homepage-search_button']}">
</form>
HOMEPAGESEARCH;
$HTMLdata['footer'] = <<<FOOTER
<a href='https://github.com/Olpouin/gallery' target='_blank'>{$lang['homepage-sourcecode']}</a> | <a href="[EDITION_URL]">{$lang['footer-edit_page']}</a> | <a href="[PATH]/#pref">{$lang['homepage-prefs-title']}</a> | <a href="#card">{$lang['footer-top']}</a>
FOOTER;
$HTMLdata['homepage-parameters'] = <<<HOMEPAGEPARAMETERS
<h2 id="pref">{$lang['homepage-prefs-title']}</h2>
<input class="checkbox" id="nightmode" type="checkbox" name="nightmode" value="on"><label for="nightmode" class="toggle">{$lang['homepage-prefs-nightmode']}</label><br><br>
<label for="pref-chooseLang">{$lang['language']} *</label>
<select id="pref-chooseLang">
	<option value="fr">Français</option>
	<option value="en">English</option>
</select><br><br>
*{$lang['homepage-prefs-needsReload']}<br>
{$lang['cookie-warning']}<br><br>
<button class="input" onclick="changeParameters()">{$lang['homepage-prefs-confirm_changes']}</button>
HOMEPAGEPARAMETERS;
$HTMLdata['editor-form'] = <<<EDITORFORM
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
$HTMLdata['format-info'] = <<<FORMATINFO
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


/*Automated things that you should not change*/
//Database connection
$dsn = "mysql:host={$config['database']['host']};dbname={$config['database']['name']};charset=utf8";
try {
	$db = new PDO($dsn,
		$config['database']['username'],
		$config['database']['password'],
		array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
	);
} catch (Exception $e) {
	die('Error : '.$e->getMessage());
}
$configTypes = $config['types'];
//Path detection
preg_match('/(\/(.*))\//Um', $_SERVER['PHP_SELF'], $detectedPaths);
$config['general']['path'] = $detectedPaths['1'];
//Cards listing
$cardList = $db->prepare('SELECT * FROM bestiaire ORDER BY type,groupe,name');
$cardList->execute();
$config['cardsList'] = array();
while ($data = $cardList->fetch()) {
	$config['cardsList'][$data['type']][$data['groupe']][$data['name']]['password'] = $data['password'];
	$config['cardsList'][$data['type']][$data['groupe']][$data['name']]['text'] = $data['text'];
	$config['cardsList'][$data['type']][$data['groupe']][$data['name']]['hidden'] = $data['hidden'];
}

require_once 'php/functions.inc.php';
?>
