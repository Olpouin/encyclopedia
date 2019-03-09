<?php
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
$config['general'] = array(
	"globalPassword" => '', //The general password. Hash with "password_hash("YOURPASSWORD", PASSWORD_DEFAULT);"
	"language" => "fr",
	"site_name" => "Gallery",
	"box-default_image" => "https://img.com/img.jpg"
	"default_language" => "fr_FR",
);

if (preg_match("/((edit|add)\.php)$/", $_SERVER['PHP_SELF'])) { //check file because there would be errors in the APIs
	$langDir = "../lang/";
} else {
	$langDir = "lang/";
}
$languages = array_diff(scandir($langDir), array('..', '.'));
if (isset($_COOKIE['lang'])) {
	if ($_COOKIE['lang']) {
		if (in_array(htmlentities($_COOKIE['lang'].'.php'), $languages)) {
			$langSelected = $_COOKIE['lang'];
		} else {
			$langSelected = $config['general']['default_language'];
		}
	} else {
		$langSelected = $config['general']['default_language'];
	}
} else {
	$langSelected = $config['general']['default_language'];
}
require_once "lang/".$langSelected.".php"; //The language Selected

$config['general']['editor-bar'] = [
	[
		['format' => '[h1][/h1]', 'cursor' => '4', 'name' => 'title1'],
		['format' => '[h2][/h2]', 'cursor' => '4', 'name' => 'title2'],
		['format' => '[h3][/h3]', 'cursor' => '4', 'name' => 'title3'],
		['format' => '[h4][/h4]', 'cursor' => '4', 'name' => 'title4'],
		['format' => '[h5][/h5]', 'cursor' => '4', 'name' => 'title5'],
		['format' => '[h6][/h6]', 'cursor' => '4', 'name' => 'title6']
	],
	[
		['format' => '[i][/i]', 'cursor' => '3', 'name' => 'italic', 'e' => 'CTRL + I'],
		['format' => '[b][/b]', 'cursor' => '3', 'name' => 'bold', 'e' => 'CTRL + B'],
		['format' => '[s][/s]', 'cursor' => '3', 'name' => 'strikethrough', 'e' => 'CTRL + S'],
		['format' => '[u][/u]', 'cursor' => '3', 'name' => 'underlined', 'e' => 'CTRL + U'],
		['format' => '[c][/c]', 'cursor' => '3', 'name' => 'color', 'e' => 'CTRL + O'],
	],
	[
		['format' => '![]()', 'cursor' => '2', 'name' => 'img', 'e' => "![{$lang['editor-bar']['help-dsc']}]({$lang['editor-bar']['url']})"],
		['format' => '[]()', 'cursor' => '1', 'name' => 'url', 'e' => "[{$lang['editor-bar']['help-dsc']}]({$lang['editor-bar']['url']})"],
		['format' => '!()', 'cursor' => '2', 'name' => 'sound', 'e' => "!({$lang['editor-bar']['url']})"],
		['format' => '!()', 'cursor' => '2', 'name' => 'video', 'e' => "!({$lang['editor-bar']['url']})"]
	],
	[
		['format' => '[quote][au][/au][/quote]', 'cursor' => '7', 'name' => 'quote'],
		['format' => '[hr]', 'cursor' => '4', 'name' => 'hr'],
		['format' => '\t', 'cursor' => '1', 'name' => 'tab', 'e' => 'SHIFT + TAB']
	]
];

$markdownArray = array(
	'/\[h([1-6])\](.*)\[\/h[1-6]\]/Ums' => '<h$1 id="$2">$2</h1>',
	'/\[hr\]/Ums' => '<hr>',
	'/\[i\](.*)\[\/i\]/Ums' => '<i>$1</i>',
	'/\[b\](.*)\[\/b\]/Ums' => '<b>$1</b>',
	'/\[s\](.*)\[\/s\]/Ums' => '<s>$1</s>',
	'/\[u\](.*)\[\/u\]/Ums' => '<u>$1</u>',
	'/\[c\](.*)\[\/c\]/Ums' => '<span style="color: #003399;">$1</span>',
	'/\[c#([a-fA-F0-9]{6})\](.*)\[\/c\]/Ums' => '<span style="color: #$1;">$2</span>',
	'/\[quote\](.*)\[au\](.*)\[\/au\]\[\/quote\]/Ums' => '<blockquote><span>$1</span><cite>— $2</cite></blockquote>',
	'/\[ib\](.*)\[\/ib\]/Ums' => '<aside class="infobox">$1</aside>',
	'/\[ibd\](.*)\|(.*)\[\/ibd\]/Ums' => '<div class="infobox-data"><span class="infobox-data-title">$1</span><span>$2</span></div>',
	'/\!\[(.*)\]\((.*)\)/Um' => '<img src="$2" onclick="fullscreen(event)" alt="$1">',
	'/\!\(https?\:\/\/www\.youtube\.com\/watch\?v\=(.*)\)/Um' => '<iframe width="560" height="315" frameborder="0" src="https://www.youtube-nocookie.com/embed/$1" allowfullscreen></iframe>',
	'/\!\((https?\:\/\/.*\.(mp3|wav|wave))\)/Um' => '<audio controls><source src="$1" type="audio/$2"></audio>',
	'/\!\((https?\:\/\/.*\.(mp4|webm|ogg|avi|mov))\)/Um' => '<video controls><source src="$1" type="video/$2"></video>',
	'/\[(.*)\]\((https?\:\/\/.*)\)/Um' => '<a href="$2" target="_blank">$1</a>'
);

$content['css']['nightmode'] = "
:root {
	--color_main: #000000;
	--color_borders: #323232;
	--color_sidenav: #060606;
	--color_main-opposite: #FFFFFF;
	--color_infobox-text_color: #F8F8F8;
	--invert-value: 100%;
}";
$content['css']['daymode'] = "
:root {
	--color_main: #FFFFFF;
	--color_borders: #DCDCDC;
	--color_sidenav: #FAFAFA;
	--color_main-opposite: #000000;
	--color_infobox-text_color: #F8F8F8;
	--invert-value: 0%;
}";
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
	if (isset($config['types'][$data['type']])) {
		$config['cardsList'][$data['type']][$data['groupe']][$data['name']]['password'] = $data['password'];
		$config['cardsList'][$data['type']][$data['groupe']][$data['name']]['text'] = $data['text'];
		$config['cardsList'][$data['type']][$data['groupe']][$data['name']]['hidden'] = $data['hidden'];
	}
}

require_once 'php/functions.inc.php';
?>
