<?php
$cardName = urldecode($_GET['name']);
$card = new Card();
if ($card->load($_GET['type'], $cardName)) {
	$content['title'] = $cardName." (".ucfirst(Config::read('gene.types')[$_GET['type']]).")";

	//Thanks to http://www.10stripe.com/articles/automatically-generate-table-of-contents-php.php !
	preg_match_all('/\{"type":"header","data":\{"text":"(.*)","level":[1-6]\}\}/Ums', $card->text(), $tocTitles);
	if (!empty(implode("",$tocTitles[0]))) {
		$toc = "<details class='toc'><summary>Sommaire</summary>".implode("\n", $tocTitles[0]);
		$toc = preg_replace('/\{"type":"header","data":\{"text":"(.*)","level":([1-6])\}\}/Ums', '<a class="toc-title-$2" href="#$1">$1</a>', $toc);
		$toc .= "</details>";
	} else $toc = "";
	try {
		$content['page'] = "<h1>{$cardName}</h1>{$toc}<div id=\"toolbar\"></div><div id=\"cardContent\" class=\"format ql-editor\">{$card->text('html')}</div>";
	} catch (\EditorJSException $e) {
		$content['page'] = "Erreur lors de la transformation du JSON en HTML : ".$e;
	}

	preg_match('/!\[(.*)\]\((.*)\)/Um',$card->text(),$firstImg); //Detect img
	if (!empty($firstImg)) $content['header'] .= "<meta property=\"og:image\" content=\"".htmlspecialchars($firstImg['2'])."\">";
	//preg_match('/\{"type":"paragraph","data":\{"text":"(.*)"\}\}/Um', $card->text(), $firstPara); //Without infobox detection
	preg_match('/\{"type":"paragraph","data":\{"text":"((?!\[ib\]).*)"\}\}/Um', $card->text(), $firstPara); //Detect desc
	if (!empty($firstPara)) {
		$firstPara['1'] = preg_replace("/^\n(.*)/Ums", "$1", strip_tags(preg_replace("/<br ?\/?>/ms", "\n", $firstPara['1']))); //Cleaning from HTML
		if (strlen($firstPara['1'])>300) $cardDesc = htmlspecialchars(substr($firstPara['1'], 0, 300))."...";
		else $cardDesc = htmlspecialchars($firstPara['1']);
		$content['header'] .= "<meta property=\"og:description\" content=\"".$cardDesc."\">";
	}
	$content['header'] .= "<meta property=\"og:title\" content=\"".$cardName."\">";
} else {
	$content['page'] = "Cette erreur ne devrait pas s'afficher.";
}
?>
