<?php
$sidenavContent = '<span class="title"><a href="/gallery/">Galerie Windersteel</a> <a href="#" class="sidenav-button" onclick="closeNav();">&times; Fermer le menu</a></span>';
foreach ($databasesArray as $letterCode => $value) {
	$listGroups = $db->prepare('SELECT groupe FROM bestiaire WHERE type = ? GROUP BY groupe');
	$listGroups->execute(array($letterCode));
	$groups = $listGroups->fetchAll(PDO::FETCH_COLUMN);
	$listGroups->closeCursor();

	$listGlobal = $db->prepare('SELECT * FROM bestiaire WHERE groupe = ? ORDER BY name');
	$sidenavContent .= '<ul class="type"><span><a href="/gallery/'.$letterCode.'/">'.ucfirst($value).'</a></span>';
	foreach ($groups as $grp) {
		$sidenavContent .= "<ul><span>".$grp."</span>";

		$listGlobal->execute(array($grp));
		while ($listing = $listGlobal->fetch()) {
			$sidenavContent .= '<li><a href="/gallery/'.$letterCode.'/'.str_replace(' ','-', $listing['name']).'" title="'.$listing['name'].'">'.$listing['name'].'</a></li>';
		}
		$sidenavContent .= "</ul>";
	}
	$sidenavContent .= "</ul>";
}
?>
