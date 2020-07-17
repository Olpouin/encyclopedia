<?php
$content['page'] = $content['sidenav'] = $content['footer'] = $content['header'] = $content['title'] = $content['desc'] = "";

require_once('../main.php');
if (isset($_POST['pass']) AND Config::checkPassword($_POST['pass'])) Config::write('gene.visibility', '1');
require_once('../src/content/sidenav.php');
require_once('../src/content/footer.php');

Config::write('gene.themes', array_diff(scandir('content/css/themes'), array('..', '.')));
if (!isset($_COOKIE['theme'])) $_COOKIE['theme'] = 'sky.css';
if (!in_array($_COOKIE['theme'], Config::read('gene.themes'))) $_COOKIE['theme'] = 'sky.css';
Config::write('head.js',[]);
Config::write('head.css',[]);
//Page handler
if (isset($_GET['type'])) {
	if (!isset($_GET['edit'])) {
		if (isset($_GET['name'])) require_once('../src/pages/card.php');
		else require_once('../src/pages/type.php');
	} else {
		if (isset($_GET['name'])) require_once('../src/pages/card-edit.php');
		else require_once('../src/pages/type.php');
	}
} elseif (!isset($_GET['admin'])) {
	if (!isset($_GET['edit'])) require_once('../src/pages/home.php');
	else require_once('../src/pages/home-edit.php');
} else require_once('../src/pages/admin.php');

//Header handler
foreach (Config::read('head.js') as $key => $value) {
	$content['header'] .= "<script src=\"".Config::read('gene.path')."/content/js/{$value}.js\"></script>";
}
foreach (Config::read('head.css') as $key => $value) {
	$content['header'] .= "<link rel=\"stylesheet\" href=\"".Config::read('gene.path')."/content/css/{$value}.css\" type=\"text/css\">";
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?=$content['title']." • ".Config::read('gene.site_name')?></title>
		<?=$content['header']?>
		<meta property="og:site_name" content="<?=Config::read('gene.site_name')?>">
		<link rel="icon" href="<?=Config::read('gene.path')?>/content/favicon.ico">
		<meta property="og:type" content="article">
		<meta charset="utf-8">
		<script>var path = "<?=Config::read('gene.path')?>";</script>
		<script src="<?=Config::read('gene.path')?>/content/js/onclick.js"></script>
		<script src="<?=Config::read('gene.path')?>/content/js/script.js"></script>
		<script src="<?=Config::read('gene.path')?>/content/js/defer.js" defer></script>
		<!--<script src="<?=Config::read('gene.path')?>/content/js/stats.js" defer></script>-->
		<link rel="stylesheet" href="<?=Config::read('gene.path')?>/content/css/sidenav.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?=Config::read('gene.path')?>/content/css/card.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?=Config::read('gene.path')?>/content/css/main.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?=Config::read('gene.path')?>/content/css/themes/discord.css" type="text/css" media="screen">
	</head>
	<body>
		<div id="notifs" class="notifs-box"></div>
		<nav id="sidenav">
			<?=$content['sidenav']?>
		</nav>
		<div class="card-content">
			<main class="card" id="card">
				<?=$content['page']?>
			</main>
			<footer>
				<?=$content['footer']?>
			</footer>
		</div>
	</body>
</html>
