<?php
/*General configuration.*/
$config['database'] = array(
	"host" => "",
	"name" => "",
	"username" => "",
	"table" => ""
	"password" => "",
);
$config['types'] = array(
	"b" => "bestiaire",
	"p" => "personnages",
	"l" => "lieux",
	"e" => "entités",
	's' => 'souvenirs'
);

$config['lang'] = [
	'en_US' => 'English, US',
	'fr_FR' => 'Français, France'
];

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

$configGeneralDB = $db->prepare("SELECT * FROM {$config['database']['table']} WHERE type = '[SERVERDATA]' AND name = 'general'");
$configGeneralDB->execute();
$configGeneralJSON = $configGeneralDB->fetch();

$config['general'] = json_decode($configGeneralJSON['text'], true);
$globalPasswords = [
	'pass 1',
	'pass 2'
]; //The general password. Hash with "password_hash("YOURPASSWORD", PASSWORD_DEFAULT);". Possibility to set multiple passwords.

if (isset($_COOKIE['lang'])) {
	if (array_key_exists($_COOKIE['lang'], $config['lang'])) $langSelected = $_COOKIE['lang'];
	else $langSelected = $config['general']['default_language'];
} else $langSelected = $config['general']['default_language'];
$lang = require_once "lang/".$langSelected.".php";

$langAPI = $lang['api'];

//['format'=>'', 'name'=>'', 'e'=>'', 'param'=>[]]
$config['general']['editor-bar'] = [
	[
		['format'=>'heading', 'name'=>'title1', 'param'=>['def'=>'h1']],
		['format'=>'heading', 'name'=>'title2', 'param'=>['def'=>'h2']],
		['format'=>'heading', 'name'=>'title3', 'param'=>['def'=>'h3']],
		['format'=>'heading', 'name'=>'title4', 'param'=>['def'=>'h4']],
		['format'=>'heading', 'name'=>'title5', 'param'=>['def'=>'h5']],
		['format'=>'heading', 'name'=>'title6', 'param'=>['def'=>'h6']]
	],
	[
		['format'=>'italic', 'name'=>'italic', 'e'=>'CTRL + I'],
		['format'=>'bold', 'name'=>'bold', 'e'=>'CTRL + B'],
		['format'=>'strikeThrough', 'name'=>'strikethrough', 'e'=>'CTRL + S'],
		['format'=>'underline', 'name'=>'underlined', 'e'=>'CTRL + U'],
		['format'=>'foreColor', 'name'=>'color', 'e'=>'CTRL + O', 'param'=>['def'=>'#003399']],
		['format'=>'removeFormat', 'name'=>'clear']
	],
	[
		['format'=>'insertText', 'name'=>'img', 'e'=>"![{$lang['editor-bar']['help-dsc']}]({$lang['editor-bar']['url']})", 'param'=>['def'=>'![]()']],
		['format'=>'insertText', 'name'=>'url', 'e'=>"[{$lang['editor-bar']['help-dsc']}]({$lang['editor-bar']['url']})", 'param'=>['def'=>'[]()']],
		['format'=>'insertText', 'name'=>'sound', 'e'=>"!({$lang['editor-bar']['url']})", 'param'=>['def'=>'!()']],
		['format'=>'insertText', 'name'=>'video', 'e'=>"!({$lang['editor-bar']['url']})", 'param'=>['def'=>'!()']]
	],
	[
		['format'=>'insertHTML', 'name'=>'quote', 'param'=>['def'=>'<blockquote><span>Citation</span><cite>Auteur</cite></blockquote>']],
		['format'=>'insertHorizontalRule', 'name'=>'hr'],
		['format'=>'insertText', 'name'=>'tab', 'e'=>'SHIFT + TAB', 'param'=>['def'=>'   ']]
	],
	[
		['format'=>'insertHTML', 'name'=>'ib', 'param'=>['def'=>'<aside class="infobox"><br>Infobox<br></aside>']],
		['format'=>'insertHTML', 'name'=>'ibd', 'param'=>['def'=>'<div class="infobox-data"><span class="infobox-data-title">T</span><span>D</span></div>']]
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
	'/<h([1-6])(.*)>(.*)<\/h([1-6])>/Ums' => '[h$1]$3[/h$1]',
);

/*Automated things that you should not change*/
//Database connection
$configTypes = $config['types'];
//Path detection
preg_match('/(\/(.*))\//Um', $_SERVER['PHP_SELF'], $detectedPaths);
$config['general']['path'] = $detectedPaths['1'];

//Cards listing
$cardList = $db->prepare("SELECT * FROM {$config['database']['table']} ORDER BY type,groupe,name");
$cardList->execute();
$config['cardsList'] = array();
while ($data = $cardList->fetch()) {
	if (isset($config['types'][$data['type']])) {
		$config['cardsList'][$data['type']][$data['groupe']][$data['name']]['password'] = $data['password'];
		$config['cardsList'][$data['type']][$data['groupe']][$data['name']]['text'] = $data['text'];
		$config['cardsList'][$data['type']][$data['groupe']][$data['name']]['hidden'] = $data['hidden'];
	}
}

define("PATH",$config['general']['path']);
define("DEFAULT_IMAGE",$config['general']['box-default_image']);

require_once 'php/functions.inc.php';
?>
