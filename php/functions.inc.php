<?php
function URLConvert($name, $toURL = true) {
	if ($toURL) {
		$result = str_replace(' ','-', $name);
	} else {
		$result = str_replace('-',' ', $name);
	}
	return $result;
}

function searchCard($searchName, $array) {
	foreach ($array as $group => $cardArray) {
		if (array_key_exists($searchName, $cardArray)) {
			return array(
				'isFound' => true,
				'group' => $group,
				'card' => $cardArray[$searchName]
			);
		}
	}
	return array('isFound'=>false);
}

$hrefGen = function ($type = null, $name = null) use ($config) {
	if (isset($type)) {
		if (isset($name)) {
			return htmlentities($config['general']['path'].'/'.$type.'/'.URLConvert($name));
		}
		return htmlentities($config['general']['path'].'/'.$type.'/');
	}
	return htmlentities($config['general']['path']);
};

$previewBox = function ($card) use ($config) {
	preg_match('/\?\[(.*)\]\((.*)\)/m', $card['text'], $matches);
	if (empty($matches)) {
		$matches['2'] = $config['homepage']['box-default_image'];
	}
	$formattedCard = '<a href="'.$config['general']['path'].'/'.$card['type'].'/'.URLConvert($card['name']).'" title="'.$card['name'].'" ><div class="previewBox" style="background-image: url('.$matches['2'].');"><span>'.$card['name'].'</span></div></a>';
	return $formattedCard;
};


?>
