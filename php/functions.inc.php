<?php
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

$format = function($text) use($markdownArray) {
	$text = htmlentities($text);
	foreach ($markdownArray as $key => $value) {
		$text = preg_replace($key, $value, $text);
	}
	$text = nl2br($text);
	$text = preg_replace('/\t/', '&emsp;', $text);
	return $text;
};

$hrefGen = function ($type = null, $name = null) use ($config) {
	if (isset($type)) {
		if (isset($name)) {
			return $config['general']['path'].'/'.urlencode($type).'/'.urlencode($name);
		}
		return $config['general']['path'].'/'.urlencode($type).'/';
	}
	return $config['general']['path'];
};

$previewBox = function ($card) use ($config) {
	preg_match('/\!\[(.*)\]\((.*)\)/m', $card['text'], $matches);
	if (empty($matches)) {
		$matches['2'] = $config['homepage']['box-default_image'];
	}
	$formattedCard = '<a href="'.$config['general']['path'].'/'.$card['type'].'/'.urlencode($card['name']).'" title="'.$card['name'].'" ><div class="previewBox" style="background-image: url('.$matches['2'].');"><span>'.$card['name'].'</span></div></a>';
	return $formattedCard;
};


?>
