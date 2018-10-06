<?php
$config_JSON = file_get_contents("config.json");
$config = json_decode($config_JSON, true);

if (isset($_GET['e'])) $error = $_GET['e'];
else $error = "Unknown error";

$errorMessages = $config['error']['error_messages'];

if (array_key_exists($error,$errorMessages)) $errorMessage = $errorMessages[$error];
else $errorMessage = $errorMessages['Unknown error'];
?>
<html>
	<head>
		<title><?php echo "Erreur".$config['head-content']['title'] ?></title>
		<meta property="og:type" content="article">
		<meta property="og:site_name" content="<?php echo $config['head-content']['site_name'] ?>">
		<meta property="og:description" content="<?php echo htmlentities($error)." : ".htmlentities($errorMessage) ?>">
		<meta name="description" content="<?php echo htmlentities($error)." : ".htmlentities($errorMessage) ?>">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta charset="utf-8">
		<link rel="icon" href="<?php echo $config['general']['path']; ?>/content/favicon.ico">
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
		<h1><?php echo htmlentities($error); ?></h1>
		<h2><a href="<?php echo htmlentities($config['general']['path']); ?>/"><?php echo htmlentities($config['error']['homepage']); ?></a> • <a href="#error-code"><?php echo htmlentities($config['error']['menu-open']); ?></a></h2>
		<div><p><?php echo htmlentities($errorMessage); ?></p></div>
		<div id="error-code" style="top: 100%;">
			<a href="#">&times; <?php echo htmlentities($config['error']['menu-close_message']); ?></a><br><br>
			<?php echo $config['error']['menu-send_message']; ?>
			<pre><?php echo "====== ERROR CODE REPORT\r\nERROR: ".htmlentities($error)."\r\nDATE : ".date('o-m-d H:i:s P')."\r\nURL  : ".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."\r\n======"; ?></pre>
		</div>
	</body>
</html>
