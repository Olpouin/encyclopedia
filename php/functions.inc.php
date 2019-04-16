<?php
function rand_color() {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}
function textToColor($str) { //https://stackoverflow.com/questions/3724111/how-can-i-convert-strings-to-an-html-color-code-hash
  $code = dechex(crc32($str));
  $code = substr($code, 0, 6);
  return "#".$code;
}

$APIresponse = function ($title, $msg) use($langAPI) {
	$resp = [
		'title'=>$langAPI['titles'][$title],
		'message'=>$msg
	];
	return json_encode($resp);
};

$checkPassword = function ($pass) use($globalPasswords) {
	foreach ($globalPasswords as $key) {
		if (password_verify($pass, $key)) return true;
	}
	return false;
};

function format($text, $editor) {
	$text = htmlentities($text);
	foreach (MARKDOWN_TO_CLIENT as $key => $value) {
		if (!$editor) $text = preg_replace($key, $value['r'], $text);
		else {
			if ($value['e']) $text = preg_replace($key, $value['r'], $text);
		}
	}
	if ($editor) $text = str_replace(array("\r\n", "\r", "\n"), '<br>', $text);
	else $text = nl2br($text);
	return $text;
};
$serverFormat = function($text) use($serverMarkdownArray) {
	$text = html_entity_decode($text);
	foreach ($serverMarkdownArray as $key => $value) {
		$text = preg_replace($key, $value, $text);
	}
	$text = strip_tags($text);
	return $text;
};

function hrefGen($type = null, $name = null) {
	if (isset($type)) {
		if (isset($name)) return PATH.'/'.urlencode($type).'/'.urlencode($name);
		else return PATH.'/'.urlencode($type).'/';
	}
	return PATH;
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
