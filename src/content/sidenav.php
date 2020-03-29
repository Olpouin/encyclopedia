<?php
$cardList = (Config::read('gene.visibility') == 0) ?
	$core->db->prepare("SELECT type,groupe,name,hidden FROM ".Config::read('db.table')." WHERE hidden = 0 ORDER BY type,groupe,name") :
	$core->db->prepare("SELECT type,groupe,name,hidden FROM ".Config::read('db.table')." ORDER BY type,groupe,name");
$cardList->execute(array());
$cardListArray = array();
while ($data = $cardList->fetch()) {
	if (isset(Config::read('gene.types')[$data['type']])) {
		$cardListArray[$data['type']][$data['groupe']][$data['name']]['hidden'] = $data['hidden'];
	}
}

$content['sidenav'] = '<span class="title"><a href="'.Config::read('gene.path').'/">'.Config::read('gene.site_name').'</a></span>';
foreach ($cardListArray as $type => $groups) {
	if (isset($_GET['type'])) {
		if ($type == $_GET['type']) $opened = 'open=""';
		else $opened = '';
	}
	else $opened = 'open=""';
	$content['sidenav'] .= '<details '.$opened.' class="type"><summary>'.Config::read('gene.types')[$type].'</summary>';
	foreach ($groups as $group => $cards) {
		$content['sidenav'] .= "<ul><span>".htmlspecialchars($group)."</span>";
		foreach ($cards as $card => $data) {
			$selectedClass = $scrollTo = "";
			if (isset($_GET['name'])) {
				if (urldecode($_GET['name']) == $card) $selectedClass .= "selectedPage";
				if ($card == $_GET['name']) $scrollTo = "<script>window.onload = function(){document.getElementById(".json_encode("sidenav-".$card).").scrollIntoView()}</script>";
			}
			if ($data['hidden'] == 1) $selectedClass .= " hiddenPage";
			$content['sidenav'] .= '<li><a id="sidenav-'.$card.'" class="'.$selectedClass.'" href="'.hrefGen($type,$card).'">'.htmlentities($card).'</a></li>'.$scrollTo;
		}
		$content['sidenav'] .= '</ul>';
	}
	$content['sidenav'] .= '</details>';
}
?>
