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
$config['general']['editor-bar'] = array(
	array(
		array(
			"format" => "[h1][/h1]",
			"cursor_move" => "4",
			"name" => "title1"
		),
		array(
			"format" => "[h2][/h2]",
			"cursor_move" => "4",
			"name" => "title2"
		),
		array(
			"format" => "[h3][/h3]",
			"cursor_move" => "4",
			"name" => "title3"
		),
		array(
			"format" => "[h4][/h4]",
			"cursor_move" => "4",
			"name" => "title4"
		),
		array(
			"format" => "[h5][/h5]",
			"cursor_move" => "4",
			"name" => "title5"
		),
		array(
			"format" => "[h6][/h6]",
			"cursor_move" => "4",
			"name" => "title6"
		)
	),
	array(
		array(
			"format" => "[i][/i]",
			"cursor_move" => "3",
			"name" => "italic"
		),
		array(
			"format" => "[b][/b]",
			"cursor_move" => "3",
			"name" => "bold"
		),
		array(
			"format" => "[s][/s]",
			"cursor_move" => "3",
			"name" => "strikethrough"
		),
		array(
			"format" => "[u][/u]",
			"cursor_move" => "3",
			"name" => "underlined"
		)
	),
	array(
		array(
			"format" => "![]()",
			"cursor_move" => "2",
			"name" => "img"
		),
		array(
			"format" => "[]()",
			"cursor_move" => "1",
			"name" => "url"
		),
		array(
			"format" => "!()",
			"cursor_move" => "2",
			"name" => "sound"
		),
		array(
			"format" => "!()",
			"cursor_move" => "2",
			"name" => "video"
		),
	),
	array(
		array(
			"format" => "[quote][author][/author][/quote]",
			"cursor_move" => "7",
			"name" => "quote"
		),
		array(
			"format" => "[hr]",
			"cursor_move" => "4",
			"name" => "hr"
		),
		array(
			"format" => "\t",
			"cursor_move" => "1",
			"name" => "tab"
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
$HTMLdata['footer'] = <<<FOOTER
<a href='https://github.com/Olpouin/gallery' target='_blank'>{$lang['homepage-sourcecode']}</a> | <a href="[EDITION_URL]">{$lang['footer-edit_page']}</a> | <a href="[PATH]/#pref">{$lang['homepage-prefs-title']}</a> | <a href="#card">{$lang['footer-top']}</a>
FOOTER;
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
