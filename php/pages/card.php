<?php
$cardName = urldecode($_GET['name']);
$searchInfo = searchCard($cardName, $config['cardsList'][$type]);

if (!$searchInfo['isFound']) {
	$err = "404-2";
	require_once("php/pages/error.php");
} else {
	$loadedDB = $searchInfo['card'];
	if (isset($_GET['edit'])) { /*EDIT PAGE*/
		require('card-edit.php');
	} else { /*DISPLAY PAGE*/
		$infoContent['g_title'] = $cardName." (".ucfirst($config['types'][$_GET['type']]).")";
		//Thanks to http://www.10stripe.com/articles/automatically-generate-table-of-contents-php.php !
		preg_match_all("/\[h[1-6].*\](.*)\[\/h[1-6]\]/Ums", preg_replace('/\[ib.*\[\/ib\]/Ums', '', $loadedDB['text']), $tocTitles);
		if (!empty(implode("",$tocTitles[0]))) {
			$toc = "<details open='' class='toc'><summary>Sommaire</summary>".implode("\n", $tocTitles[0]);
			$toc = preg_replace('/\[h([1-6])\](.*)\[\/h[1-6]\]/Ums', '<a class="toc-title-$1" href="#$2">$2</a>', $toc);
			$toc = preg_replace('/\[.*\]/Ums', '', $toc);
			$toc .= "</details>";
		} else $toc = "";
		$formatText = $format($loadedDB['text'], false);
		$content['card'] = "<h1>{$cardName}</h1>{$toc}<p>{$formatText}</p>";
	}
}
?>
