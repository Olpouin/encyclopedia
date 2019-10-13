<?php
if (isset($_GET['edit'])) {$editURL = "&edit";}
else {$editURL = "";}
$dsn = ($isAdmin) ?
	"SELECT type,groupe,name,hidden FROM ".Config::read('db.table')." ORDER BY type,groupe,name"
	: "SELECT type,groupe,name,hidden FROM ".Config::read('db.table')." WHERE hidden = 0 ORDER BY type,groupe,name";

$cardList = $core->db->prepare($dsn);
$cardList->execute();
$config['cardsList'] = array();
while ($data = $cardList->fetch()) {
	if (isset(Config::read('gene.types')[$data['type']])) {
		$config['cardsList'][$data['type']][$data['groupe']][$data['name']]['hidden'] = $data['hidden'];
	}
}

$content['sidenav'] = '<span class="title"><a href="'.PATH.'/">'.Config::read('gene.site_name').'</a> <button class="sidenav-button" onclick="closeNav();">&times; Fermer le menu</button></span>';
foreach ($config['cardsList'] as $type => $groups) {
	if (isset($_GET['type'])) {
		if ($type == $_GET['type']) $opened = 'open=""';
		else $opened = '';
	}
	else $opened = 'open=""';
	$content['sidenav'] .= '<details '.$opened.' class="type"><summary>'.Config::read('gene.types')[$type].'</summary>';
	foreach ($groups as $group => $cards) {
		$content['sidenav'] .= "<ul><span>".$group."</span>";
		foreach ($cards as $card => $data) {
			$selectedClass = $scrollTo = "";
			if (isset($_GET['name'])) {
				if (urldecode($_GET['name']) == $card) $selectedClass .= "selectedPage";
				if ($card == $_GET['name']) $scrollTo = "<script>window.onload = function(){document.getElementById('sidenav-".$card."').scrollIntoView()}</script>";
			}
			if ($isAdmin && $data['hidden'] == 1) $selectedClass .= " hiddenPage";
			$content['sidenav'] .= '<li><a id="sidenav-'.$card.'" class="'.$selectedClass.'" href="'.hrefGen($type,$card).$editURL.'">'.htmlentities($card).'</a></li>'.$scrollTo;
		}
		$content['sidenav'] .= '</ul>';
	}
	$content['sidenav'] .= '</details>';
}
?>
