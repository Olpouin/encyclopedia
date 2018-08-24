<?php
include 'php/dbInfo.php';

$imgSearch = $db->prepare('SELECT * FROM bestiaire');
$imgSearch->execute();
$bestiaryData = $imgSearch->fetchAll(PDO::FETCH_ASSOC);
//print_r($bestiaryData);
$finalIMGValue = "";
foreach ($bestiaryData as $key => $value) {
	preg_match('/[\!\?]\[(.*)\]\((.*)\)/Ums', $value['text'], $matches);
	if (!empty($matches)) {
		$finalIMGValue .= "<img src=\"".$matches['2']."\">";
	}
}
/*TODO :
Tout mettre dans un array puis traiter avec un echo, pas mettre tout dans un grand texte moche.*/
echo $finalIMGValue;
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Windersteel • Images</title>
		<meta property="og:type" content="article">
		<meta property="og:site_name" content="Windersteel">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta charset="utf-8">
		<link rel="icon" href="/gallery/content/favicon.ico">
		<link rel="stylesheet" href="/gallery/content/css/images-tab.css" type="text/css" media="screen">
		<script src="/gallery/content/script.js" type="text/javascript" defer="defer"></script>
	</head>
</html>
