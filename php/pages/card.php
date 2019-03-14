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
		$infoContent['g_title'] = $cardName;
		$formatText = $format($loadedDB['text'], false);
		//Thanks to http://www.10stripe.com/articles/automatically-generate-table-of-contents-php.php !
		preg_match_all("/<h[1-6].*>(.*)<\/h[1-6]>/Ums", preg_replace('/<aside.*<\/aside>/Ums', '', $formatText), $tocTitles);
		if (!empty(implode("",$tocTitles[0]))) {
			$toc = "<details open='' class='toc'><summary>Sommaire</summary>".implode("\n", $tocTitles[0]);
			$toc = preg_replace('/\<[usbi]\>()\<\/?[usbi]\>/Um', '$1', $toc);
			$toc = preg_replace('/<h([1-6]) id="(.*)">(.*)<\/h[1-6]\>/Um', '<a class="toc-title-$1" href="#$2">$3</a>', $toc);
			$toc .= "</details>";
		} else $toc = "";

		$content['card'] = "<h1>{$cardName}</h1>{$toc}{$formatText}";
	}
}
?>
