<?php
/*==== BASIC FILES ====*/
require_once 'config.php'; /*Various functions*/
require_once 'php/functions.inc.php'; /*Various functions*/
require_once 'php/pages.php'; /*Everything in the pages*/
require_once 'php/sidenav.php'; /*Well... The sidenav.*/
/*=== HEADER ===*/
$headerContentDetectionArray = array(
	'img' => '/\?\[(.*)\]\((.*)\)/m',
	'desc' => '/\[p\](.*)\[\/p\]/Ums'
);
$headerContent = "";
foreach ($headerContentDetectionArray as $key => $value) {
	preg_match($value, $cardContent, $matches);
	if (!empty($matches)) {
		switch ($key) {
			case 'img':
				$headerContent .= '<meta property="og:image:url" content="'.$matches['2'].'">';
				$headerContent .= '<meta name="twitter:image" content="'.$matches['2'].'">';
				$headerContent .= '<meta name="twitter:card" content="summary_large_image">';
				$headerContent .= '<meta property="og:image:alt" content="Artwork : '.$matches['1'].'">';
				break;
			case 'desc':
				if (strlen($matches['1']) > 290) {
					$matches['1'] = substr($matches['1'], 0, 290)."...";
				}
				$description = $matches['1'];
				$headerContent .= '<meta property="og:description" content="'.htmlentities($description).'">';
				$headerContent .= '<meta name="description" content="'.htmlentities($description).'">';
				break;
		}
	}
}
$headerContent .= '<meta property="og:title" content="'.$infoContent['g_title'].'">';
?>
<!DOCTYPE html>
<html lang="<?=$config['general']['language']?>">
	<head>
		<title>Pages<?=$config['head-content']['title']?></title>
		<?=$headerContent?>
		<meta property="og:type" content="article">
		<meta property="og:site_name" content="<?=$config['head-content']['site_name']?>">
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
		<script src="<?=$config['general']['path']?>/content/script.js" defer></script>
	</head>
	<body>
		<nav id="sidenav">
			<?=$sidenavContent?>
		</nav>
		<div class="page-content">
			<main class="card" id="card">
				<button tabindex="-1" class="sidenav-button" style="font-size: 20px;" onclick="openNav();">&#9776;</button>
				<?=$cardContent?>
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
		<div id="notif" role="alert">
			<div class="notif-zone">
				<h1 id="notif-title"></h1>
				<p id="notif-text"></p>
				<a class="input" id="notif-load" style="color:inherit;text-decoration:none;padding: 10px 15px" href=""><?=$lang['notif-show']?></a>
				<button class="input notif-close" id="notif-close" onclick="closeNotif()"><?=$lang['notif-close']?></button>
			</div>
		</div>
		<div id="fullscreen-image" class="fullscreen-image" role="alert">
			<div>
				<img id="fs-img_img" alt="" src="">
			</div>
			<h1 id="fs-img_title">Image title</h1>
			<button class="button-x" onclick="closeImg();">&times; Fermer</button>
		</div>
	</body>
</html>
