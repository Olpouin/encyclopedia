<?php
$cardName = urldecode($_GET['name']);
$card = new Card();
if ($card->load($_GET['type'], $cardName)) {
	$content['title'] = $cardName." (".ucfirst(Config::read('gene.types')[$_GET['type']]).")";

	//Thanks to http://www.10stripe.com/articles/automatically-generate-table-of-contents-php.php !
	/*preg_match_all("/\[h[1-6].*\](.*)\[\/h[1-6]\]/Ums", preg_replace('/\[ib.*\[\/ib\]/Ums', '', $card->text()), $tocTitles);
	if (!empty(implode("",$tocTitles[0]))) {
		$toc = "<details class='toc'><summary>Sommaire</summary>".implode("\n", $tocTitles[0]);
		$toc = preg_replace('/\[h([1-6])\](.*)\[\/h[1-6]\]/Ums', '<a class="toc-title-$1" href="#$2">$2</a>', $toc);
		$toc = preg_replace('/\[.*\]/Ums', '', $toc);
		$toc .= "</details>";
	} else */$toc = "";
	try {
		$content['page'] = "<h1>{$cardName}</h1>{$toc}<div id=\"toolbar\"></div><div id=\"cardContent\" class=\"format ql-editor\">{$card->text('html')}</div>";
	} catch (\EditorJSException $e) {
		$content['page'] = "Erreur lors de la transformation du JSON en HTML : ".$e;
	}


} else {
	$content['page'] = "Cette erreur ne devrait pas s'afficher.";
}
?>
