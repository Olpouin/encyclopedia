<?php
if (isset($_GET['edit'])) {$editURL = "&edit";}
else {$editURL = "";}
$sidenavContent = '<span class="title"><a href="'.$config['general']['path'].'/">'.$config['general']['sidenav_title'].'</a> <a href="#" class="sidenav-button" onclick="closeNav();">&times; Fermer le menu</a></span>';
foreach ($config['cardsList'] as $type => $groups) {
	$sidenavContent .= '<ul class="type"><span><a href="'.$hrefGen($type).'">'.ucfirst($config['types'][$type]).'</a></span>';
	foreach ($groups as $group => $cards) {
		$sidenavContent .= "<ul><span>".$group."</span>";
		foreach ($cards as $card => $data) {
			if ($data['hidden'] == 0) {
				$selectedClass = "";
				if (isset($_GET['name'])) {
					if (URLConvert($_GET['name'], false) == $card) {
						$selectedClass = "selectedPage";
					}
				}
				$sidenavContent .= '<li><a class="'.$selectedClass.'" href="'.$hrefGen($type,$card).$editURL.'" title="'.$card.'">'.$card.'</a></li>';
			}
		}
		$sidenavContent .= '</ul>';
	}
	$sidenavContent .= '</ul>';
}
?>
