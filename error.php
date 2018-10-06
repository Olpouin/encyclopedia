<?php
$config_JSON = file_get_contents("config.json");
$config = json_decode($config_JSON, true);

if (isset($_GET['e'])) $error = $_GET['e'];
else $error = "Unknown error";

$errorMessages = array(
	'400' => 'Bad Request: "The 400 (Bad Request) status code indicates that the server cannot or will not process the request due to something that is perceived to be a client error (e.g., malformed request syntax, invalid request message framing, or deceptive request routing)." - <a href="https://tools.ietf.org/html/rfc7231#section-6.5.1" target="_blank">ietf.org</a>',
	'401' => 'Unauthorized: You are trying to access something you should not have the right to use. Sorry, but that\'s a nope.',
	'403' => 'Forbidden: You are not allowed to look at that. Wherever you are, it probably is a file that will just create a lot of errors if used alone. or something you shouldn\'t use at all.',
	'404' => 'Not Found: We can\'t find this page. The entry may have changed name, been moved to another category or even removed. If you weren\'t looking for a card, you are somewhere you should not be.',
	'408' => 'Request Timeout: It seems you have a problem right now. Please come back later.',
	'414' => 'URI Too Long: The URL is too long. Don\'t know what you are trying to do, but it certainly isn\'t right.',
	'Unknown error' => 'We can\'t find what error you got or (most likely) there are no error message prepared for this case. Sorry.'
);

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
		<h1><?php echo htmlentities($error);  ?></h1>
		<h2><a href="<?php echo $config['general']['path']; ?>/">Homepage</a> • <a href="#error-code">Report error</a></h2>
		<div><p><?php echo $errorMessage; ?></p></div>
		<div id="error-code" style="top: 100%;">
			<a href="#">&times; Close the error report</a><br><br>
			Please send the following to the owner of the website:
			<pre><?php echo "====== ERROR CODE REPORT\r\nERROR: ".htmlentities($error)."\r\nDATE : ".date('o-m-d H:i:s P')."\r\nURL  : ".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."\r\n======"; ?></pre>
		</div>
	</body>
</html>
