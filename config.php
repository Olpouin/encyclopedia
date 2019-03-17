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
		['format' => 'heading', 'name' => 'title1', 'param' => ['def' => 'h1']],
		['format' => 'heading', 'name' => 'title2', 'param' => ['def' => 'h2']],
		['format' => 'heading', 'name' => 'title3', 'param' => ['def' => 'h3']],
		['format' => 'heading', 'name' => 'title4', 'param' => ['def' => 'h4']],
		['format' => 'heading', 'name' => 'title5', 'param' => ['def' => 'h5']],
		['format' => 'heading', 'name' => 'title6', 'param' => ['def' => 'h6']]
	],
	[
		['format' => 'italic', 'name' => 'italic', 'e' => 'CTRL + I'],
		['format' => 'bold', 'name' => 'bold', 'e' => 'CTRL + B'],
		['format' => 'strikeThrough', 'name' => 'strikethrough', 'e' => 'CTRL + S'],
		['format' => 'underline', 'name' => 'underlined', 'e' => 'CTRL + U'],
		['format' => 'foreColor', 'name' => 'color', 'e' => 'CTRL + O', 'param' => ['def' => '#003399']],
		['format' => 'removeFormat', 'name' => 'clear']
	],
	[
		['txt' => '![]()', 'cursor' => '2', 'name' => 'img', 'e' => "![{$lang['editor-bar']['help-dsc']}]({$lang['editor-bar']['url']})"],
		['txt' => '[]()', 'cursor' => '1', 'name' => 'url', 'e' => "[{$lang['editor-bar']['help-dsc']}]({$lang['editor-bar']['url']})"],
		['txt' => '!()', 'cursor' => '2', 'name' => 'sound', 'e' => "!({$lang['editor-bar']['url']})"],
		['txt' => '!()', 'cursor' => '2', 'name' => 'video', 'e' => "!({$lang['editor-bar']['url']})"]
	],
	[
		['txt' => '[quote][au][/au][/quote]', 'cursor' => '7', 'name' => 'quote'],
		['format' => 'insertHorizontalRule', 'name' => 'hr'],
		['format' => 'insertText', 'name' => 'tab', 'e' => 'SHIFT + TAB', 'param' => ['def' => '   ']]
	],
	[
		['format' => 'insertHTML', 'name' => 'ib', 'param' => ['def' => '<aside class="infobox"><br>Infobox<br></aside>']],
		['format' => 'insertHTML', 'name' => 'ibd', 'param' => ['def' => '<div class="infobox-data"><span class="infobox-data-title">T</span><span>D</span></div>']]
	]
];

$markdownArray = array(
	'/\[hr\]/Ums' => ['r'=>'<hr>','e'=>true],
	'/\[i\](.*)\[\/i\]/Ums' => ['r'=>'<i>$1</i>','e'=>true],
	'/\[b\](.*)\[\/b\]/Ums' => ['r'=>'<b>$1</b>','e'=>true],
	'/\[s\](.*)\[\/s\]/Ums' => ['r'=>'<s>$1</s>','e'=>true],
	'/\[u\](.*)\[\/u\]/Ums' => ['r'=>'<u>$1</u>','e'=>true],
	'/\[c\](.*)\[\/c\]/Ums' => ['r'=>'<span style="color:#003399;">$1</span>','e'=>true],
	'/\[c#([a-fA-F0-9]{6})\](.*)\[\/c\]/Ums' => ['r'=>'<span style="color:#$1;">$2</span>','e'=>false],
	'/\[quote\](.*)\[au\](.*)\[\/au\]\[\/quote\]/Ums' => ['r'=>'<blockquote><span>$1</span><cite>$2</cite></blockquote>','e'=>true],
	'/\[ib\](.*)\[\/ib\]/Ums' => ['r'=>'<aside class="infobox">$1</aside>','e'=>true],
	'/\[ibd\](.*)\|(.*)\[\/ibd\]/Ums' => ['r'=>'<div class="infobox-data"><span class="infobox-data-title">$1</span><span>$2</span></div>','e'=>true],
	'/\!\[(.*)\]\((.*)\)/Um' => ['r'=>'<img src="$2" onclick="fullscreen(event)" alt="$1">','e'=>false],
	'/\!\(https?\:\/\/www\.youtube\.com\/watch\?v\=(.*)\)/Um' => ['r'=>'<iframe frameborder="0" src="https://www.youtube-nocookie.com/embed/$1" allowfullscreen></iframe>','e'=>false],
	'/\!\((https?\:\/\/.*\.(mp3|wav|wave))\)/Um' => ['r'=>'<audio controls><source src="$1" type="audio/$2"></audio>','e'=>false],
	'/\!\((https?\:\/\/.*\.(mp4|webm|ogg|avi|mov))\)/Um' => ['r'=>'<video controls><source src="$1" type="video/$2"></video>','e'=>false],
	'/\[(.*)\]\((https?\:\/\/.*)\)/Um' => ['r'=>'<a href="$2" target="_blank">$1</a>','e'=>false],
	'/\[h([1-6])\](.*)\[\/h[1-6]\]/Ums' => ['r'=>'<h$1 id="$2">$2</h1>','e'=>true],
	'/\t/Ums' => ['r'=>'&emsp;','e'=>false],
	'/<h([1-6]) id="<(.*)>(.*)<\/(.*)>">/Ums' => ['r'=>'<h$1 id="$3">', 'e' => false]
);

$serverMarkdownArray = array(
	'/\<br(\s*)?\/?\>/i' => "\n",
	'/\<i\>(.*)\<\/i\>/Ums' => '[i]$1[/i]',
	'/\<b\>(.*)\<\/b\>/Ums' => '[b]$1[/b]',
	'/\<strike\>(.*)\<\/strike\>/Ums' => '[s]$1[/s]',
	'/\<s\>(.*)\<\/s\>/Ums' => '[s]$1[/s]',
	'/\<u\>(.*)\<\/u\>/Ums' => '[u]$1[/u]',
	'/\<span style="color:#003399;"\>(.*)\<\/span\>/Ums' => '[c]$1[/c]',
	'/\<font color="#003399"\>(.*)\<\/font\>/Ums' => '[c]$1[/c]',
	'/\<span style="color:#([a-fA-F0-9]{6});"\>(.*)\<\/span\>/Ums' => '[c#$1]$2[/c]',
	'/\<font color="([a-fA-F0-9]{6})"\>(.*)\<\/font\>/Ums' => '[c#$1]$2[/c]',
	'/<blockquote><span>(.*)<\/span><cite>(.*)<\/cite><\/blockquote>/Ums' => '[quote]$1[au]$2[/au][/quote]',
	'/<aside class="infobox">(.*)<\/aside>/Ums' => '[ib]$1[/ib]',
	'/<div class="infobox-data"><span class="infobox-data-title">(.*)<\/span><span>(.*)<\/span><\/div>/Ums' => '[ibd]$1|$2[/ibd]',
	'/<hr>/Ums' => '[hr]',
	'/\&emsp\;/Ums' => "\t",
	'/<div(.*)>(.*)<\/div>/Ums' => "$2",
	'/<span(.*)>(.*)<\/span>/Ums' => "$2",
	'/<\/?span(.*)>/Ums' => '',
	'/<\/?div(.*)>/Ums' => '',
	'/<h([1-6])(.*)>(.*)<\/h([1-6])>/Ums' => '[h$1]$3[/h$1]',
	'/<\/?.*>/Ums' => '',
	'/<em(.*)>(.*)<\/em>/Ums' => "$2"
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
