<?php /*Changes the header depending on what is searched + page content;
useful for social media embeds*/



if (isset($_GET['type'])) {
	$type = $_GET['type'];

	if (array_key_exists($type, $databasesArray) AND isset($_GET['name']) AND !empty($_GET['name'])) {
		$displayType = 'info';
	} elseif (array_key_exists($type, $databasesArray)) {
		$displayType = 'welcome';
	} else {
		$displayType = 'error-2';
	}
} else {
	$displayType = 'home';
}

switch ($displayType) {
	case 'info':
		$_GET['name'] = str_replace('-',' ', $_GET['name']);
		$searchDB = $db->prepare('SELECT * FROM bestiaire WHERE name = ? AND type = ?');
		$searchDB->execute(array($_GET['name'],$type));
		$loadedDB = $searchDB->fetch();
		if (empty($loadedDB)) {
			$displayType = "error-1";
		}
		$infoContent = array(
			'g_title' => $loadedDB['name'],
			'c_desc' => $loadedDB['text']
		);
		break;

	case 'welcome':
		$infoContent = array(
			'g_title' => $galleryHomes[$type]['name'],
			'name' => $galleryHomes[$type]['name'],
			'desc' => $galleryHomes[$type]['desc']
		);
		break;
	case 'home':
		$infoContent = array(
			'g_title' => $galleryHomes['home']['name'],
			'name' => $galleryHomes['home']['name'],
			'desc' => $galleryHomes['home']['desc']
		);
		break;
}

if ($displayType == "info") {
$infoContent['c_desc'] = htmlentities($infoContent['c_desc']);
$cardContent = <<< EOPAGE
{$infoContent['c_desc']}
EOPAGE;
$headerContent = "";
} elseif ($displayType == "welcome" OR $displayType == "home") {
$cardContent = <<< EOPAGE
<div class="card-content">
	<div class="card-content-desc">
		<span>{$infoContent['desc']}</span>
	</div>
</div>
EOPAGE;
$headerContent = <<< COPAGE
<meta name="description" content="{$infoContent['name']} de Windersteel">
<meta property="og:description" content="{$infoContent['name']} de Windersteel">
COPAGE;
} else {
$infoContent = array('g_title' => 'Erreur');
$cardContent = <<< EOPAGE
<span>
	Woops, il y a eu une erreur ! Peut-être que ce n'est pas le bon lien...
</span>
EOPAGE;
$headerContent = "";
}
?>
