<?php
/*==== BASIC FILES ====*/
require_once 'config.php'; /*Various functions*/
require_once 'php/functions.inc.php'; /*Various functions*/
require_once 'php/sidenav.php'; /*Well... The sidenav.*/
/*Looking the right page to choose*/
if(isset($_GET['type'])) {
	$type = $_GET['type'];
	if(array_key_exists($type, $configTypes)) {
		if(isset($_GET['name']) AND !empty($_GET['name'])) { /*Shows a card*/
			require_once("php/pages/card.php");
		} else { /*Shows a type (Cards large groups)*/
			require_once("php/pages/type.php");
		}
	} else {
		$err = "404-1";
		require_once("php/pages/error.php");
	}
} else { /*Shows the homepage*/
	if (isset($_GET['error'])) {
		$err = $_GET['error'];
		require_once("php/pages/error.php");
	} else {
		if (isset($_GET['edit'])) {
			require_once('php/pages/homepage-edit.php');
		} else {
			require_once("php/pages/homepage.php");
		}
	}
}
/*=== HEADER ===*/
$headerContent = "";
if (isset($loadedText)) {
	preg_match_all('/\!\[(.*)\]\((.*)\)/Ums', $loadedText, $matches);
	$headerContent .= '<meta property="og:image:url" content="'.$matches['2']['0'].'">';
	$headerContent .= '<meta name="twitter:image" content="'.$matches['2']['0'].'">';
	$headerContent .= '<meta name="twitter:card" content="summary_large_image">';
	$headerContent .= '<meta property="og:image:alt" content="Artwork : '.$matches['1']['0'].'">';
}
$headerContent .= '<meta property="og:title" content="'.$infoContent['g_title'].'">';
?>
<!DOCTYPE html>
<html lang="<?=$langSelected?>">
	<head>
		<title><?=$infoContent['g_title']." • ".$config['general']['site_name']?></title>
		<?=$headerContent?>
		<meta property="og:type" content="article">
		<meta property="og:site_name" content="<?=$config['general']['site_name']?>">
		<meta charset="utf-8">
		<script src="<?=$config['general']['path']?>/content/js/script.js" defer></script>
		<script src="<?=$config['general']['path']?>/content/js/editor.js" defer></script>
		<script src="<?=$config['general']['path']?>/content/js/onclick.js"></script>
		<link rel="icon" href="<?=$config['general']['path']?>/content/favicon.ico">
		<link rel="stylesheet" href="<?=$config['general']['path']?>/content/css/main.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?=$config['general']['path']?>/content/css/sidenav.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?=$config['general']['path']?>/content/css/card.css" type="text/css" media="screen">
		<style>
		<?php
			if (isset($_COOKIE['mode'])) {
				if ($_COOKIE['mode'] == 'night') {echo $content['css']['nightmode'];}
				else echo $content['css']['daymode'];
			} else echo $content['css']['daymode'];
		?>
		</style>
		<script>
			const langNotifShow = "<?=$lang['notif-show']?>";
			const langNotifClose = "<?=$lang['close']?>";
			var path = "<?=$config['general']['path']?>";
		</script>
	</head>
	<body>
		<div id="page-content">
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
						if (isset($_GET['type'])) {
							$footerEditURL = $_SERVER['REQUEST_URI']."&edit";
						}
						else {
							$footerEditURL = $_SERVER['REQUEST_URI']."?edit";
						}
					} else {
						$footerEditURL = substr($_SERVER['REQUEST_URI'], 0, -5);
						$footerEditTXT = $lang['footer-show_page'];
					}
					?>
					<a href='https://github.com/Olpouin/gallery' target='_blank'><?=$lang['homepage-sourcecode']?></a>
					<a href="<?=$footerEditURL?>"><?=$footerEditTXT?></a>
					<a href="<?=$config['general']['path']?>[PATH]/#pref"><?=$lang['homepage-prefs-title']?></a>
					<a href="#card"><?=$lang['footer-top']?></a>
				</footer>
			</div>
		</div>
	</body>
</html>
