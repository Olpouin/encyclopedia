<?php /*Here come all global variables so I don't have to edit this in every files*/
/*Databases codes matching their names.*/
$databasesArray = array(
	'b' => 'bestiaire',
	'p' => 'personnage',
	'l' => 'lieu',
	'e' => 'entités'
);
/*Home pages of gallery types.*/
$galleryHomes = array(
	'b' => array(
		'name' => "Bestiaire",
		'desc' => "Les bêtes de Windersteel peuvent être regroupées en plusieurs catégories.
<p>Bête : Les bêtes sont les créatures les plus communs de WinderSteel, ils vivent dans différents habitats et n'ont pas toujours affilié à la volonté, ils peuvent être tout de même être aussi dangereux que n'importe quel autre créature.</p>
<p>Golem : Les golems sont des entités qui sont le fruit de la création d'une personne ou d'une réaction avec la volonté ou même de la nature, effectivement, il est possible de rencontrer un golem naturel.</p>
<p>Insectoïde : Les insectoïdes sont des créatures qui présente des similitudes avec la morphologie des insectes.</p>
<p>Maudit : Les maudits sont des créatures ou des personnes qui ont étaient maudits par quelque chose de particulier, il peut aussi tout bonnement s'agir d'une malédiction obtenu par l'hérédité ou encore par divers transmission.</p>
<p>Ogroïd : Les ogroïds sont les créatures qui présente tous des similitudes avec les trolls, les ogres, les géants, grand ou petit d'ailleurs.</p>
<p>Vestige : Les vestiges sont des êtres vivants qui ont survécu aux affres des âges et qui n'ont toujours pas disparût, vestige d'un ancienne âge, de l'Archonte aux Précurseurs.</p>"
	),
	'p' => array(
		'name' => "Personnages",
		'desc' => "Ici siège la tombe d'une description utile et non chiante."
	),
	'l' => array(
		'name' => "Lieux",
		'desc' => "C'est des endroits... voilà ? :kevain:"
	),
	'e' => array(
		'name' => "Entités",
		'desc' => 'Entités.'
	),
	'home' => array(
		'name' => "Galerie",
		'desc' => "<p>Windersteel est un serveur Roleplay privé, au sujet d'un univers alternatif qui ce concentre sur l'Empire Britannique et sa colonie \"Windersteel\" qui va devoir apprendre à survivre sans son empire.</p>
<p>Le Roleplay est concentré sur l'action, l'aventure, la relation entre les personnages et le lore en lui-même. Dans un univers Steampunk-Médiéval-Fantaisie et utilisant des figures historiques du XVIIe au XIXe siècle. Les personnages doivent défendre le Nouveau-Monde, continent où se situe la colonie, devenue maintenant indépendante de l'Empire Britannique, contre plusieurs menaces tels que des Ordres Militaires, Démons, Royaumes Ennemis et l'Empire lui-même. </p>"
	)
);
/*==== BASIC FILES ====*/
include 'php/dbInfo.php'; /*Databse connection, so no need to update everytime on the server*/
include 'php/pages.php'; /*Everything in the pages*/
include 'php/sidenav.php'; /*Well... The sidenav.*/
/*=== HEADER ===*/
$headerContentDetectionArray = array(
	'img' => '/\?\[(.*)\]\((.*)\)/m',
	'desc' => '/\[quote\](.*)\[author\](.*)\[\/author\]\[\/quote\]/m'
);
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
				$description = "«".$matches['1']."»\n— ".$matches['2']."";
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
	'/\[p\](.*)\[\/p\]/Ums' => '<p>$1</p>',
	'/\[quote\](.*)\[author\](.*)\[\/author\]\[\/quote\]/Ums' => '<blockquote><span>$1</span><cite>— $2</cite></blockquote>',
	'/\[ib\](.*)\[\/ib\]/Ums' => '<aside class="infobox">$1</aside>',
	'/\[ibd\](.*)\|(.*)\[\/ibd\]/Ums' => '<div class="infobox-data"><span class="infobox-data-title">$1</span><span>$2</span></div>',
	'/\[br\]/m' => '<br>',
	'/[\!\?]\[(.*)\]\((.*)\)/Ums' => '<img src="$2" onclick="openImg(event)" alt="$1">'
);
foreach ($markdownArray as $key => $value) {
	$cardContent = preg_replace($key, $value, $cardContent);
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Windersteel • Galerie</title>
		<?php echo $headerContent ?>
		<meta property="og:type" content="article">
		<meta property="og:site_name" content="Windersteel">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta charset="utf-8">
		<link rel="icon" href="/gallery/content/favicon.ico">
		<link rel="stylesheet" href="/gallery/content/css/main.css" type="text/css" media="screen">
		<link rel="stylesheet" href="/gallery/content/css/sidenav.css" type="text/css" media="screen">
		<link rel="stylesheet" href="/gallery/content/css/card.css" type="text/css" media="screen">
		<script src="/gallery/content/script.js" type="text/javascript" defer="defer"></script>
	</head>
	<body>
		<div id="fullscreen-image" class="fullscreen-image">
			<h1 id="fs-img_title">Image title</h1>
			<img id="fs-img_img" src="https://i.imgur.com/gBpBwbM.jpg">
			<span class="button-s" onclick="imgResize()">OPTI</span>
			<span class="button-x" onclick="closeImg();">&times;</span>
		</div>
		<nav id="sidenav">
			<?php echo $sidenavContent; ?>
		</nav>
		<section class="card">
			<div class="sidenav-button" style="font-size: 20px;" onclick="openNav();">&#9776;</div> <!--- class="sidenav-button"-->
			<h1><?php echo $infoContent['g_title']; ?></h1>
			<?php echo $cardContent; ?>
		</section>
	</body>
</html>
