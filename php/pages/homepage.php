<?php
$infoContent['g_title'] = "Accueil";
if (!isset($_COOKIE['lang'])) $_COOKIE['lang'] = $config['general']['default_language'];
$content['hp']['search'] = $content['hp']['langForm'] = $content['hp']['themeForm'] = "";
//Main text
$homepageReq = $db->prepare("SELECT * FROM {$config['database']['table']} WHERE type = '[SERVERDATA]' AND name = 'homepage'");
$homepageReq->execute();
$homepage = $homepageReq->fetch();
$homepage = format($homepage['text'], false);
//Search
if (isset($_GET['search'])) {
	$content['hp']['search'] = "<div class='center'>";
	$searchDB = $db->prepare("SELECT * FROM {$config['database']['table']} WHERE (name REGEXP ? OR groupe REGEXP ?) AND hidden = 0");
	$searchDB->execute(array($_GET['search'],$_GET['search']));
	while ($listing = $searchDB->fetch()) {
		$content['hp']['search'] .= previewBox($listing);
	}
	$content['hp']['search'] .= "</div>";
}

foreach ($config['lang'] as $key => $value) {
	$langSelected = ($key == $_COOKIE['lang']) ? "selected" : "";
	$content['hp']['langForm'] .= "<option {$langSelected} value='{$key}'>{$value}</option>";
}
foreach ($settings['modesList'] as $key => $value) {
	$themeSelected = ($key == $_COOKIE['theme']) ? "selected" : "";
	$name = ucfirst($key);
	$content['hp']['themeForm'] .= "<option {$themeSelected} value='{$key}'>{$name}</option>";
}

$prefTextedit = ($_COOKIE['prefeditor'] == "txt") ? "checked" : "";
$prefDyslexic = ($_COOKIE['dyslexic'] == "true") ? "checked" : "";

//STATS
$stats['topCards'] = $stats['topTypes'] = [
	'datasets' => [
		['data' => [], 'backgroundColor' => []]
	],
	'labels' => [],
];

$cards = $db->prepare("SELECT * FROM {$config['database']['table']} WHERE hidden = 0");
$cards->execute();
$stats['c'] = $stats['t'] = $stats['g']['totaltxt'] = "";
$stats['g']['length'] = $stats['g']['img'] = $stats['g']['vid'] = $stats['g']['cards'] = $stats['g']['words'] = $stats['topCards-length'] = 0;
while ($card = $cards->fetch()) {
	$stats['g']['length'] += strlen($card['text']);
	$stats['g']['words'] += str_word_count($card['text']);
	preg_match_all('/\!\[.*\]\(.*\)/Um', $card['text'], $imgMatches);
	$stats['g']['img'] += count($imgMatches[0]);
	preg_match_all('/\!\(https?\:\/\/www\.youtube\.com\/watch\?v\=(.*)\)/Um', $card['text'], $vidMatches);
	$stats['g']['vid'] += count($vidMatches[0]);
	$stats['g']['cards'] += 1;
	if (isset($stats['g']['t'][$card['type']])) $stats['g']['t'][$card['type']] += strlen($card['text']);
	else $stats['g']['t'][$card['type']] = strlen($card['text']);
}
$stats['g']['length-moy'] = round($stats['g']['length'] / $stats['g']['cards'], 2);
$stats['g']['img-moy'] = round($stats['g']['img'] / $stats['g']['cards'], 2);
$stats['g']['vid-moy'] = round($stats['g']['vid'] / $stats['g']['cards'], 2);
$stats['g']['words-moy'] = round($stats['g']['length'] / $stats['g']['words'], 2);


$topCards = $db->prepare("SELECT * FROM {$config['database']['table']} WHERE hidden = 0 ORDER BY CHAR_LENGTH(text) DESC LIMIT 10"); //TOP CARDS
$topCards->execute();
while ($topCard = $topCards->fetch()) {
	$value = round(( strlen($topCard['text']) / $stats['g']['length'] ) * 100, 1);
	$stats['topCards-length'] += strlen($topCard['text']);
	array_push($stats['topCards']['datasets'][0]['data'], strlen($topCard['text']));
	array_push($stats['topCards']['datasets'][0]['backgroundColor'], textToColor($topCard['name']));
	array_push($stats['topCards']['labels'], $topCard['name']);
}
$stats['topCard-perc'] = round(( $stats['topCards-length'] / $stats['g']['length'] ) * 100, 1);
foreach ($stats['g']['t'] as $key => $value) { //TYPES
	if (isset($config['types'][$key])) $name = ucfirst($config['types'][$key]);
	else $name = $key;
	$label = $name." (".$value." caractères)";
	$value = round(($value / $stats['g']['length'] ) * 100, 1);
	array_push($stats['topTypes']['datasets'][0]['data'], $value);
	array_push($stats['topTypes']['datasets'][0]['backgroundColor'], textToColor($name));
	array_push($stats['topTypes']['labels'], $label);
}

$stats['topCards'] = json_encode($stats['topCards']);
$stats['topTypes'] = json_encode($stats['topTypes']);
$content['card'] = <<<HOMEPAGE
{$homepage}
<label for="card-search-homepage">{$lang['homepage-search_input']}</label>
<form action="" class="cardSearchBox">
	<input id="card-search-homepage" class="cardSearch" type="text" name="search" placeholder="{$lang['homepage-search_input']}">
	<input class="cardSearch-button" type="submit" value="{$lang['homepage-search_button']}">
</form>
{$content['hp']['search']}
<h2 class="center">Statistiques</h2>
<div class="flexboxData">
	<div>
		<h2>Top des fiches</h2>
		<canvas id="chart-topcards"></canvas>
		Les 10 premières fiches représentent {$stats['topCard-perc']}% de la galerie.
	</div>
	<div>
		<h2>Proportion des catégories</h2>
		<canvas id="chart-toptypes"></canvas>
	</div>
	<div>
		<h2>Général</h2>
		Total de fiches : {$stats['g']['cards']}<br>
		Total de caractères: {$stats['g']['length']}<br>
		Nombre total de mots : {$stats['g']['words']}<br>
		Total d'images : {$stats['g']['img']}<br>
		Total de vidéos YouTube : {$stats['g']['vid']}<br>
		<br>
		Moyenne de lettre par mots : {$stats['g']['words-moy']}<br>
		Moyenne d'images par fiche : {$stats['g']['img-moy']}<br>
		Moyenne de vidéos par fiche : {$stats['g']['vid-moy']}<br>
		Moyenne de caractères par fiche : {$stats['g']['length-moy']}<br>
	</div>
	<div>
	</div>
</div>
<h2 class="center" id="pref">{$lang['homepage-prefs-title']}</h2>
<form action="">
	<select id="pref-theme">
		{$content['hp']['themeForm']}
	</select>
	<label for="pref-theme" class="toggle">{$lang['homepage-prefs-theme']}</label><br><br>
	<select id="pref-chooseLang">
		{$content['hp']['langForm']}
	</select>
	<label for="pref-chooseLang">{$lang['language']}</label><br><br>
	<input class="checkbox" id="prefeditor" type="checkbox" {$prefTextedit} value="on">
	<label for="prefeditor" class="toggle">{$lang['homepage-prefs-editor']}</label><br><br>
	<input class="checkbox" id="dyslexic" type="checkbox" {$prefDyslexic} value="on">
	<label for="dyslexic" class="toggle">{$lang['homepage-prefs-dyslexic']}</label><br><br>
	{$lang['cookie-warning']}<br>
	<button class="input" onclick="changeParameters()">{$lang['homepage-prefs-confirm_changes']}</button>
</form>

<script>
	generateChart('bar', 'chart-topcards', {$stats['topCards']}, {'yaxis': ' caractères'});
	generateChart('doughnut', 'chart-toptypes', {$stats['topTypes']}, {});
</script>
HOMEPAGE;
?>
