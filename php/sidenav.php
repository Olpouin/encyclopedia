<?php
if (isset($_GET['edit'])) {$editURL = "&edit";}
else {$editURL = "";}
$content['sidenav'] = '<span class="title"><a href="'.PATH.'/">'.$config['general']['site_name'].'</a> <button class="sidenav-button" onclick="closeNav();">&times; Fermer le menu</button></span>';
foreach ($config['cardsList'] as $type => $groups) {
	if (isset($_GET['type'])) {
		if ($type == $_GET['type']) $opened = 'open=""';
		else $opened = 'open=""';
	} //yeah, not really useful yet...
	else $opened = 'open=""';
	$content['sidenav'] .= '<details '.$opened.' class="type"><summary>'.ucfirst($config['types'][$type]).'</summary>';
	foreach ($groups as $group => $cards) {
		$content['sidenav'] .= "<ul><span>".$group."</span>";
		foreach ($cards as $card => $data) {
			if (($data['hidden'] == 0) OR (isset($_POST['pass']) && $checkPassword($_POST['pass']))) {
				$selectedClass = $scrollTo = "";
				if (isset($_GET['name'])) {
					if (urldecode($_GET['name']) == $card) $selectedClass .= "selectedPage";
					if ($card == $_GET['name']) $scrollTo = "<script>window.onload = function(){document.getElementById('sidenav-".$card."').scrollIntoView()}</script>";
				}
				if ($data['hidden'] == 1) $selectedClass .= " hiddenPage";
				$content['sidenav'] .= '<li><a id="sidenav-'.$card.'" class="'.$selectedClass.'" href="'.hrefGen($type,$card).$editURL.'">'.htmlentities($card).'</a></li>'.$scrollTo;
			}
		}
		$content['sidenav'] .= '</ul>';
	}
	$content['sidenav'] .= '</details>';
}
?>
