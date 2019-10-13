<?php
if (!isset($_COOKIE['theme'])) $_COOKIE['theme'] = "sky.css";
if (!isset($_COOKIE['dyslexic'])) $_COOKIE['dyslexic'] = false;
$isAdmin = false;
/*==== BASIC FILES ====*/
require_once 'core.php';
require_once 'php/functions.inc.php';

try {
	$sql = "SELECT * FROM ".Config::read('db.table')." WHERE type = '[SERVERDATA]' AND name = 'general'";
	$configGeneralDB = $core->db->prepare($sql);
	$configGeneralDB->execute();
	$configGeneralJSON = $configGeneralDB->fetch();
} catch (Exception $e) {
	die('Error : '.$e->getMessage());
}
if (!$configGeneralJSON) {
	$sql = "INSERT INTO ".Config::read('db.table')."(name, type, text, hidden) VALUES(?, ?, ?, 1)";
	$createConfig = $core->db->prepare($sql);
	$createConfig->execute(array(
		'general',
		'[SERVERDATA]',
		'{"default_language":"en_US","site_name":"Gallery","box-default_image":"https:\/\/url.com\/img.jpg"}'
	));

	$configGeneralDB->execute();
	$configGeneralJSON = $configGeneralDB->fetch();
}
$configGeneralArray = json_decode($configGeneralJSON['text'], true);
Config::write('gene.default_lang', $configGeneralArray['default_language']);
Config::write('gene.site_name', $configGeneralArray['site_name']);
Config::write('gene.default_img', $configGeneralArray['box-default_image']);

require_once 'php/class/card.php';
//Settings
if (isset($_COOKIE['lang'])) {
	if (array_key_exists($_COOKIE['lang'], $config['lang'])) $langSelected = $_COOKIE['lang'];
	else $langSelected = Config::read('gene.default_lang');
} else $langSelected = Config::read('gene.default_lang');
$lang = require_once "lang/".$langSelected.".php";

define("LANG",$lang);

$settings['themes'] = array_diff(scandir('content/css/themes'), array('..', '.'));
if (!in_array($_COOKIE['theme'], $settings['themes'])) $_COOKIE['theme'] = 'sky.css';

$settings['dyslexic'] = ($_COOKIE['dyslexic'] == "true") ?
	"html,select,button,input,blockquote{font-family:opendyslexic-regular,sans-serif!important;}"
	: "html{font-family:opensans-regular,sans-serif;}";

/*Looking the right page to choose*/
if(isset($_GET['type'])) {
	$type = $_GET['type'];
	if(array_key_exists($type, Config::read('gene.types'))) {
		if(isset($_GET['name']) AND !empty($_GET['name'])) require_once "php/pages/card.php"; //Shows a card
		else require_once "php/pages/type.php"; //Shows a type (Cards large groups)
	} else {
		$err = "404";
		require_once "php/pages/error.php";
	}
} else { /*Shows the homepage*/
	if (isset($_GET['error'])) {
		$err = $_GET['error'];
		require_once "php/pages/error.php";
	} else {
		if (isset($_GET['edit'])) require_once "php/pages/homepage-edit.php";
		else require_once "php/pages/homepage.php";
	}
}
require_once 'php/sidenav.php';
/*=== HEADER ===*/
$content['header'] = "";
$content['header'] .= '<meta property="og:title" content="'.$infoContent['g_title'].'">';

Config::add('head.js', 'onclick');

Config::add('head.css', 'sidenav');
Config::add('head.css', 'card');
Config::add('head.css', 'main');

foreach (Config::read('head.js') as $key => $value) {
	$content['header'] .= "<script src=\"{$config['general']['path']}/content/js/{$value}.js\"></script>";
}
foreach (Config::read('head.css') as $key => $value) {
	$content['header'] .= "<link rel=\"stylesheet\" href=\"{$config['general']['path']}/content/css/{$value}.css\" type=\"text/css\">";
}
?>
<!DOCTYPE html>
<html lang="<?=$langSelected?>">
	<head>
		<title><?=$infoContent['g_title']." • ".Config::read('gene.site_name')?></title>
		<?=$content['header']?>
		<meta property="og:type" content="article">
		<meta property="og:site_name" content="<?=Config::read('gene.site_name')?>">
		<meta charset="utf-8">
		<script src="<?=PATH?>/content/js/script.js" defer></script>
		<script src="<?=PATH?>/content/js/stats.js" defer></script>
		<script src="<?=PATH?>/content/js/editor.js" defer></script>
		<link rel="icon" href="<?=PATH?>/content/favicon.ico">
		<link rel="stylesheet" href="<?=PATH?>/content/css/themes/<?=$_COOKIE['theme']?>" type="text/css" media="screen">
		<style>
		<?=$settings['dyslexic']?>
		</style>
		<script>
			const langNotifShow = "<?=$lang['notif-show']?>";
			const langNotifClose = "<?=$lang['close']?>";
			var path = "<?=PATH?>";
		</script>
	</head>
	<body>
		<nav id="sidenav">
			<?=$content['sidenav']?>
		</nav>
		<div class="card-content">
			<main class="card" id="card">
				<button tabindex="-1" class="sidenav-button" style="font-size: 20px;" onclick="openNav();">&#9776;</button>
				<?=$content['card']?>
			</main>
			<footer>
				<?php
				if (!isset($_GET['edit'])) {
					$footerEditTXT = $lang['footer-edit_page'];
					if (isset($_GET['type'])) $footerEditURL = $_SERVER['REQUEST_URI']."&edit";
					else $footerEditURL = $_SERVER['REQUEST_URI']."?edit";
				} else {
					$footerEditURL = substr($_SERVER['REQUEST_URI'], 0, -5);
					$footerEditTXT = $lang['footer-show_page'];
				}
				?>
				<a href='https://github.com/Olpouin/gallery' target='_blank'><?=$lang['homepage-sourcecode']?></a>
				<a href="<?=$footerEditURL?>"><?=$footerEditTXT?></a>
				<a href="<?=PATH?>/#pref"><?=$lang['homepage-prefs-title']?></a>
				<a href="#card"><?=$lang['footer-top']?></a>
			</footer>
		</div>
	</body>
</html>
