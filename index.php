<?php
if (!isset($_COOKIE['theme'])) $_COOKIE['theme'] = "sky";
if (!isset($_COOKIE['dyslexic'])) $_COOKIE['dyslexic'] = false;
if (!isset($_COOKIE['prefeditor'])) $_COOKIE['prefeditor'] = "html";
/*==== BASIC FILES ====*/
require_once 'config.php';

$settings = require_once 'php/settings.php';
require_once 'php/functions.inc.php';
require_once 'php/sidenav.php';
/*Looking the right page to choose*/
if(isset($_GET['type'])) {
	$type = $_GET['type'];
	if(array_key_exists($type, $configTypes)) {
		if(isset($_GET['name']) AND !empty($_GET['name'])) require_once "php/pages/card.php"; //Shows a card
		else require_once "php/pages/type.php"; //Shows a type (Cards large groups)
	} else {
		$err = "404-1";
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
/*=== HEADER ===*/
$content['header'] = "";
if (isset($content['card'])) {
	preg_match_all('/<img src="(.*)".*alt="(.*)".*>/Ums', $content['card'], $matches);
	if (isset($matches[1][0]) && isset($matches[2][0])) {
		$content['header'] .= '<meta property="og:image:url" content="'.$matches[1][0].'">';
		$content['header'] .= '<meta name="twitter:image" content="'.$matches[1][0].'">';
		$content['header'] .= '<meta name="twitter:card" content="summary_large_image">';
		$content['header'] .= '<meta property="og:image:alt" content="Artwork : '.$matches[2][0].'">';
	}
}
$content['header'] .= '<meta property="og:title" content="'.$infoContent['g_title'].'">';
?>
<!DOCTYPE html>
<html lang="<?=$langSelected?>">
	<head>
		<title><?=$infoContent['g_title']." • ".$config['general']['site_name']?></title>
		<?=$content['header']?>
		<meta property="og:type" content="article">
		<meta property="og:site_name" content="<?=$config['general']['site_name']?>">
		<meta charset="utf-8">
		<script src="<?=PATH?>/content/js/script.js" defer></script>
		<script src="<?=PATH?>/content/js/editor.js" defer></script>
		<script src="<?=PATH?>/content/js/onclick.js"></script>
		<script src="<?=PATH?>/content/js/chart.min.js"></script>
		<link rel="icon" href="<?=PATH?>/content/favicon.ico">
		<link rel="stylesheet" href="<?=PATH?>/content/css/sidenav.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?=PATH?>/content/css/card.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?=PATH?>/content/css/main.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?=PATH?>/content/css/chard.min.css" type="text/css" media="screen">
		<style>
		<?=$settings['design'],$settings['dyslexic']?>
		</style>
		<script>
			const langNotifShow = "<?=$lang['notif-show']?>";
			const langNotifClose = "<?=$lang['close']?>";
			var path = "<?=PATH?>";
		</script>
	</head>
	<body>
		<div id="page-content">
			<nav id="sidenav">
				<?=$content['sidenav']?>
			</nav>
			<div class="card-content">
				<main class="card format" id="card">
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
		</div>
	</body>
</html>
