<?php
if (isset($_GET['edit'])) {$editURL = "&edit";}
else {$editURL = "";}
$sidenavContent = '<span class="title"><a href="'.$config['general']['path'].'/">'.$config['general']['sidenav_title'].'</a> <button class="sidenav-button" onclick="closeNav();">&times; Fermer le menu</button></span>';
foreach ($config['cardsList'] as $type => $groups) {
	$selectedClass = "";
	if (isset($_GET['type']) && isset($_GET['name'])) {
		if (empty($_GET['name'])) {
			if (urldecode($_GET['type']) == $type) {
				$selectedClass = "selectedPage";
			}
		}
	}
	$sidenavContent .= '<ul class="type"><span><a class="'.$selectedClass.'" href="'.$hrefGen($type).'">'.ucfirst($config['types'][$type]).'</a></span>';
	foreach ($groups as $group => $cards) {
		$sidenavContent .= "<ul><span>".$group."</span>";
		foreach ($cards as $card => $data) {
			if ($data['hidden'] == 0) {
				$selectedClass = "";
				if (isset($_GET['name'])) {
					if (urldecode($_GET['name']) == $card) {
						$selectedClass = "selectedPage";
					}
				}
				$sidenavContent .= '<li><a class="'.$selectedClass.'" href="'.$hrefGen($type,$card).$editURL.'">'.htmlentities($card).'</a></li>';
			}
		}
		$sidenavContent .= '</ul>';
	}
	$sidenavContent .= '</ul>';
}
?>
