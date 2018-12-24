<?php
function URLConvert($name, $toURL = true) {
	if ($toURL) {
		$result = str_replace(' ','-', $name);
	} else {
		$result = str_replace('-',' ', $name);
	}
	return $result;
}

$previewBox = function ($card) use ($config) {
	preg_match('/\?\[(.*)\]\((.*)\)/m', $card['text'], $matches);
	if (empty($matches)) {
		$matches['2'] = $config['homepage']['box-default_image'];
	}
	$formattedCard = '<a href="'.$config['general']['path'].'/'.$card['type'].'/'.URLConvert($card['name']).'" title="'.$card['name'].'" ><div class="previewBox" style="background-image: url('.$matches['2'].');"><span>'.$card['name'].'</span></div></a>';
	return $formattedCard;
};


?>
