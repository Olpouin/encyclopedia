<?php /*Here come all global variables so I don't have to edit this in every files*/
/*=== READ & TREAT config.json ===*/
$config_JSON = file_get_contents("config.json");
$config = json_decode($config_JSON, true);

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
/*==== BASIC FILES ====*/
include 'php/pages.php'; /*Everything in the pages*/
include 'php/sidenav.php'; /*Well... The sidenav.*/
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
				$headerContent .= '<meta property="og:description" content="'.$description.'">';
				$headerContent .= '<meta name="description" content="'.$description.'">';
				break;
		}
	}
}
$headerContent .= '<meta property="og:title" content="'.$infoContent['g_title'].'">';
/*=== VARIABLES ===*/
$markdownArray = array(
	'/\[h1\](.*)\[\/h1\]/Ums' => '<h1>$1</h1>',
	'/\[h2\](.*)\[\/h2\]/Ums' => '<h2>$1</h2>',
	'/\[p\](.*)\[\/p\]/Ums' => '<p>$1</p>',
	'/\[i\](.*)\[\/i\]/Ums' => '<i>$1</i>',
	'/\[quote\](.*)\[author\](.*)\[\/author\]\[\/quote\]/Ums' => '<blockquote><span>$1</span><cite>— $2</cite></blockquote>',
	'/\[ib\](.*)\[\/ib\]/Ums' => '<aside class="infobox">$1</aside>',
	'/\[ibd\](.*)\|(.*)\[\/ibd\]/Ums' => '<div class="infobox-data"><span class="infobox-data-title">$1</span><span>$2</span></div>',
	'/\[br\]/m' => '<br>',
	'/\[tab\]/m' => '<span class="large-space"></span>',
	'/[\!\?]\[(.*)\]\((.*)\)/Ums' => '<img src="$2" onclick="openImg(event)" alt="$1">'
);
foreach ($markdownArray as $key => $value) {
	$cardContent = preg_replace($key, $value, $cardContent);
}
?>
<!DOCTYPE html>
<html lang="<?php echo $config['general']['language'] ?>">
	<head>
		<title><?php echo $config['head-content']['title'] ?></title>
		<?php echo $headerContent ?>
		<meta property="og:type" content="article">
		<meta property="og:site_name" content="<?php echo $config['head-content']['site_name'] ?>">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta charset="utf-8">
		<link rel="icon" href="<?php echo $config['general']['path']; ?>/content/favicon.ico">
		<link rel="stylesheet" href="<?php echo $config['general']['path']; ?>/content/css/main.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?php echo $config['general']['path']; ?>/content/css/sidenav.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?php echo $config['general']['path']; ?>/content/css/card.css" type="text/css" media="screen">
		<script src="<?php echo $config['general']['path']; ?>/content/script.js" type="text/javascript" defer="defer"></script>
	</head>
	<body>
		<div id="fullscreen-image" class="fullscreen-image">
			<div>
				<img id="fs-img_img" src="">
			</div>
			<h1 id="fs-img_title">Image title</h1>
			<span class="button-x" onclick="closeImg();">&times;</span>
		</div>
		<nav id="sidenav">
			<?php echo $sidenavContent; ?>
		</nav>
		<section class="card" id="card">
			<div class="sidenav-button" style="font-size: 20px;" onclick="openNav();">&#9776;</div>
			<?php echo $cardContent; ?>
		</section>
	</body>
</html>
