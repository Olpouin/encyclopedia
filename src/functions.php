<?php
function rand_color() {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}
function textToColor($str) { //https://stackoverflow.com/questions/3724111/how-can-i-convert-strings-to-an-html-color-code-hash
  $code = dechex(crc32($str));
  $code = substr($code, 0, 6);
  return "#".$code;
}

function APIresponse($title, $msg) {
	$resp = [
		'title'=>$title,
		'message'=>$msg
	];
	return json_encode($resp);
};

function logging($title, $desc = '', $options=[]) {
	/*
	You can do whatever you want to log informations here.
	To make it quicker and easier to read, I just redirect everything to a Discord channel with the webhook feature because I frequently use Discord.
	Here's the code if you would like to use it.*/
	$url = Config::read('gene.discordWebhook');
	$color = (array_key_exists('color',$options)) ? $options['color'] : "3447003";
	$embed = [
		'title' => $title,
		'description' => $desc,
		'color' => $color,
		'timestamp' => date('c')
	];
	if (array_key_exists('url',$options)) $embed['url'] = $options['url'];
	$data = [
		'content' => '',
		'username' => '',
		'embeds' => [
			$embed
		]
	];

	$options = array(
			'http' => array(
			'header'  => "Content-type: application/json\r\n",
			'method'  => 'POST',
			'content' => json_encode($data)
		)
	);
	$context  = stream_context_create($options);
	file_get_contents($url, false, $context);
}



function hrefGen($type = null, $name = null) {
	if (isset($type)) {
		if (isset($name)) return Config::read('gene.path').'/'.urlencode($type).'/'.urlencode($name).'/';
		else return Config::read('gene.path').'/'.urlencode($type).'/';
	}
	return Config::read('gene.path');
};

function previewBox($card) {
	preg_match('/\!\[(.*)\]\((.*)\)/m', $card['text'], $matches);
	//$imgPreview = "";
	//if (!empty($matches)) $imgPreview = '<div class="previewBoxImg" style="background-image: url('.$matches['2'].');"></div>';
	if (empty($matches)) $matches['2'] = DEFAULT_IMAGE;
	$cardURL = hrefGen($card['type'], $card['name']);
	$langEdit = LANG['edit'];
	$langRead = LANG['read'];
	$formattedCard = <<<FORMATTEDCARD
<div class="previewBox">
	<a href="{$cardURL}" title="{$card['name']}">
		<div class="previewBoxImg" style="background-image: url({$matches['2']});"></div>
		<div class="previewBoxText">
			<span>{$card['name']}</span>
		</div>
	</a>
	<a class="button" href="{$cardURL}">{$langRead}</a>
	<a class="button" href="{$cardURL}&edit">{$langEdit}</a>
</div>
FORMATTEDCARD;
return $formattedCard;
};


?>
