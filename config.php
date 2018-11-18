<?php
/*General configuration.*/
$config['database'] = array(
	"host" => "",
	"name" => "",
	"username" => "",
	"password" => ""
);
$config['types'] = array(
	"b" => "bestiaire",
	"p" => "personnages",
	"l" => "lieux",
	"e" => "entités"
);
$config['head-content'] = array(
	"title" => " • Galerie",
	"site_name" => "Gallery"
);
$config['general'] = array(
	"globalPassword" => "", //The general password. Hash with "password_hash("YOURPASSWORD", PASSWORD_DEFAULT);"
	"language" => "fr",
	"sidenav_title" => "Galerie"
);
$config['homepage'] = array(
	"box-default_image" => "https://img.jpg",
	"box-top_message" => "La galerie a un total de [TOTALPAGES] pages."
);
$config['homepage']['top_description'] = <<<HOMEPAGETOPDESC
[h1]Title[/h1]
![Img desc](URL)
Text
HOMEPAGETOPDESC;
$config['error'] = array(
	"menu-close_message" => "Close the error report",
	"menu-send_message" => "Please send the following to the owner of the website:",
	"homepage" => "Homepage",
	"menu-open" => "Report error",
	"error_messages" => array(
		"400" => "Bad Request: \"The 400 (Bad Request) status code indicates that the server cannot or will not process the request due to something that is perceived to be a client error (e.g., malformed request syntax, invalid request message framing, or deceptive request routing).\" - <a href=\"https://tools.ietf.org/html/rfc7231#section-6.5.1\" target=\"_blank\">ietf.org</a>",
		"401" => "Unauthorized: You are trying to access something you should not have the right to use. Sorry, but that's a nope.",
		"403" => "Forbidden: You are not allowed to look at that. Wherever you are, it probably is a file that will just create a lot of errors if used alone. or something you shouldn't use at all.",
		"404" => "Not Found: We can't find this page. The entry may have changed name, been moved to another category or even removed. If you weren't looking for a card, you are somewhere you should not be.",
		"408" => "Request Timeout: It seems you have a problem right now. Please come back later.",
		"414" => "URI Too Long: The URL is too long. Don't know what you are trying to do, but it certainly isn't right.",
		"Unknown error" => "We can't find what error you got or (most likely) there are no error message prepared for this case. Sorry."
	)
);



/*More advanced data if you want to change something*/
$HTMLdata['homepage-search'] = <<<HOMEPAGESEARCH
<form action="" class="cardSearchBox">
	<input class="cardSearch" type="text" name="search" placeholder="Recherche d'une fiche...">
	<input class="cardSearch-button" type="submit" value="Chercher">
</form>
HOMEPAGESEARCH;
$HTMLdata['code-link'] = <<<CODELINK
<div>
	Source code on GitHub at <a href='https://github.com/Olpouin/gallery' target='_blank' style='color: #0066d3;text-decoration:none;'>github.com/Olpouin/gallery</a>
</div>
CODELINK;
$HTMLdata['format-info'] = <<<FORMATINFO
<div class="flexboxData"">
	<div>
		<h2>Formatage normal</h2>
		- Vous pouvez ajouter une tabulation avec SHIFT + TAB.<br>
		- Titres : [h1]Titre[/h1] (Niveaux inferieurs : h2 à la place de h1)<br>
		- Italique : [i]Texte en italique[/i]<br>
		- Image : ![Description of the image](URL)<br>
		--- Remplacez le ! par un ? pour que l'image soit considérée comme la plus importante<br>
		- Citations : [quote]Texte de la citation[author]Auteur[/author][/quote]
	</div>
	<div>
		<h2>Les infobox</h2>
		- Une infobox se délimite par [ib]Données de l'infobox...[/ib]<br>
		- Dans les infobox, les tags [h1] et les images fonctionnent.<br>
		- Vous pouvez entrer des informations avec [ibd]Titre/nom|Information[/ibd]<br>
	</div>
	<div>
		<h2>Raccourcis</h2>
		- Créer une infobox rapidement : SHIFT + 1<br>
		- Créer une citation rapidement : SHIFT + 2<br>
		- Créer une [ibd] rapidement : SHIFT + 3<br>
	</div>
	<div>
		<h2>Exemple</h2>
		<pre>
[ib]
[h1]Titre[/h1]
![Description de l'image](URL)
[h1]Informations diverses[/h1]
[ibd]Âge|24 ans[/ibd]
[ibd]Lieu de naissance|La lune[/ibd]
[ibd]Couleur des yeux|Rouge[/ibd]
[/ib]
Reiciendis et cum aut et omnis aliquam odit. Aspernatur nostrum esse consequuntur.
[h1]Lorem ipsum[/h1]
[quote]
Ut occaecati magni quis.
[author]Qui dolore quisquam[/author]
[/quote]
[i]Sit tempora sit qui qui tempora.[/i] Et facere odit minus doloribus inventore autem occaecati vel.
		</pre>
	</div>
</div>
FORMATINFO;


/*Automated things that you should not change*/
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

preg_match('/(\/(.*))\//Um', $_SERVER['PHP_SELF'], $detectedPaths);
$config['general']['path'] = $detectedPaths['1'];
?>
