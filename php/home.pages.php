<?php
$infoContent['g_title'] = "Galerie de Windersteel";
$cardContent = $format($config['homepage']['top_description']);
$cardContent .= $HTMLdata['homepage-search'];
$cardContent .= "<div class='previewBoxes'>";
if (isset($_GET['search'])) {
	$searchDB = $db->prepare('SELECT * FROM bestiaire WHERE (name REGEXP ? OR groupe REGEXP ?) AND hidden = 0');
	$searchDB->execute(array($_GET['search'],$_GET['search']));
	while ($listing = $searchDB->fetch()) {
		$cardContent .= $previewBox($listing);
	}
$cardContent .= "</div>";
}


$totalDBCounter = $db->query('select count(*) from bestiaire where hidden = \'0\'')->fetchColumn();
$config['homepage']['box-top_message'] = str_replace('[TOTALPAGES]', $totalDBCounter, $lang['homepage-top_message']);
$cardContent .= "<div class='previewBoxes'><h2>".$config['homepage']['box-top_message']."</h2>";
$boxList = $db->prepare('SELECT * FROM bestiaire WHERE hidden = 0 ORDER BY rand() LIMIT 4');
$boxList->execute();
while ($listing = $boxList->fetch()) {
	$cardContent .= $previewBox($listing);
}
$cardContent .= $HTMLdata['homepage-parameters'];
$cardContent .= "</div>";
?>
