<?php
header('Cache-Control: public, max-age=3600');
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
		http_response_code(404);
		header('Location: '.$config['general']['path'].'/error.php?e=404');
		die();
	}
} else { /*Shows the homepage*/
	require_once("php/pages/homepage.php");
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
		<link rel="icon" href="<?=$config['general']['path']?>/content/favicon.ico">
		<link rel="stylesheet" href="<?=$config['general']['path']?>/content/css/main.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?=$config['general']['path']?>/content/css/sidenav.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?=$config['general']['path']?>/content/css/card.css" type="text/css" media="screen">
		<style id="mainColorsCSS"></style>
		<template id="css_nightmode">
			:root {
				--color_main: #000000 !important;
				--color_borders: #323232;
				--color_sidenav: #060606;
				--color_main-opposite: #FFFFFF;
				--color_infobox-text_color: #F8F8F8;
				--invert-value: 100%;
			}
		</template>
		<template id="css_daymode">
			:root {
				--color_main: #FFFFFF;
				--color_borders: #DCDCDC;
				--color_sidenav: #FAFAFA;
				--color_main-opposite: #000000;
				--color_infobox-text_color: #F8F8F8;
				--invert-value: 0%;
			}
		</template>
		<script>
			const langNotifShow = "<?=$lang['notif-show']?>";
			const langNotifClose = "<?=$lang['close']?>";
		</script>
		<script src="<?=$config['general']['path']?>/content/js/script.js" defer></script>
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
					$clean_url = explode('&', $_SERVER['REQUEST_URI'], 2);
					$footer = str_replace('[EDITION_URL]', $clean_url[0]."&edit", $HTMLdata['footer']);
					$footer = str_replace('[PATH]', $config['general']['path'], $footer);
					echo $footer;
					?>
				</footer>
			</div>
		</div>
	</body>
</html>
