<?php
require_once 'config.php';

if (isset($_GET['e'])) $error = $_GET['e'];
else $error = "Unknown error";

$errorMessages = $lang['error']['error_messages'];

if (array_key_exists($error,$errorMessages)) $errorMessage = $errorMessages[$error];
else $errorMessage = $errorMessages['Unknown error'];
?>
<html>
	<head>
		<title><?="Erreur".$config['head-content']['title']?></title>
		<meta property="og:type" content="article">
		<meta property="og:site_name" content="<?=$config['head-content']['site_name']?>">
		<meta property="og:description" content="<?=htmlentities($error)." : ".htmlentities($errorMessage)?>">
		<meta name="description" content="<?=htmlentities($error)." : ".htmlentities($errorMessage)?>">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta charset="utf-8">
		<link rel="icon" href="<?=$config['general']['path']?>/content/favicon.ico">
		<style>
			@font-face {
				font-family: 'opensans-regular';
				src: url('content/OpenSans-Regular.ttf');
			}
			html {
				font-family: opensans-regular, sans-serif;
				background-color: #3295ff;
				font-size: 2em;
				color: #FFFFFF;
				padding: 5%;
				padding-top: 0;
			}
			h1 {
				font-size: 15vw;
				text-align: center;
				margin: 0;
			}
			h2 {
				font-size: 1em;
				text-align: center;
				margin: 0;
			}
			p::before {
				content: "\00a0\00a0\00a0\00a0";
			}
			a {
				color: #EEEEFF;
				text-decoration: none;
			}
			a:hover {
				text-decoration: underline;
			}
			#error-code {
				position: fixed;
				padding: 5%;
				bottom: 0;
				left: 0;
				right: 0;
				height: auto;
				background-color: #3295ff;
				transition: top 500ms;
			}
			#error-code:target {
				top: 0 !important;
				transition: top 1s;
			}
		</style>
	</head>
	<body>
		<h1><?=htmlentities($error)?></h1>
		<h2><a href="<?=htmlentities($config['general']['path'])?>/"><?=htmlentities($lang['error']['homepage'])?></a> • <a href="#error-code"><?=htmlentities($lang['error']['menu-open'])?></a></h2>
		<div><p><?=htmlentities($errorMessage)?></p></div>
		<div id="error-code" style="top: 100%;">
			<a href="#">&times; <?=htmlentities($lang['error']['menu-close_message'])?></a><br><br>
			<?php echo $lang['error']['menu-send_message']; ?>
			<pre><?="====== ERROR CODE REPORT\r\nERROR: ".htmlentities($error)."\r\nDATE : ".date('o-m-d H:i:s P')."\r\nURL  : ".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."\r\n======"?></pre>
		</div>
	</body>
</html>
