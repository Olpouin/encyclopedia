<?php
Config::add('head.js', 'chart.min');
Config::add('head.css', 'chart.min');
$infoContent['g_title'] = "Accueil";

if (!isset($_COOKIE['lang'])) $_COOKIE['lang'] = Config::read('gene.default_lang');;
$content['hp']['langForm'] = $content['hp']['themeForm'] = "";
//Main text
$homepageReq = $core->db->prepare("SELECT * FROM ".Config::read('db.table')." WHERE type = '[SERVERDATA]' AND name = 'homepage'");
$homepageReq->execute();
$homepage = $homepageReq->fetch();
$homepage = $homepage['text'];

foreach ($config['lang'] as $key => $value) {
	$langSelected = ($key == $_COOKIE['lang']) ? "selected" : "";
	$content['hp']['langForm'] .= "<option {$langSelected} value='{$key}'>{$value}</option>";
}
foreach ($settings['themes'] as $value) {
	$themeSelected = ($value == $_COOKIE['theme']) ? "selected" : "";
	$name = ucwords(strtolower(str_replace('_', ' ', substr($value, 0, -4))));
	$content['hp']['themeForm'] .= "<option {$themeSelected} value=\"{$value}\">{$name}</option>";
}

$prefDyslexic = ($_COOKIE['dyslexic'] == "true") ? "checked" : "";

//NEW STATS

//STATS
$stats['topCards'] = [
	'datasets' => [
		['data' => [], 'backgroundColor' => []]
	],
	'labels' => [],
];
$stats['topTypes'] = [
	'datasets' => [
		['data' => [], 'backgroundColor' => []],
		['data' => [], 'backgroundColor' => []]
	],
	'labels' => [],
];

$cards = $core->db->prepare("SELECT * FROM ".Config::read('db.table')." WHERE hidden = 0");
$cards->execute();
$stats['c'] = $stats['t'] = $stats['g']['totaltxt'] = "";
$stats['g']['length'] = $stats['g']['img'] = $stats['g']['vid'] = $stats['g']['cards'] = $stats['g']['words'] = $stats['topCards-length'] = 0;

while ($card = $cards->fetch()) {
	$stats['g']['length'] += strlen($card['text']);
	$stats['g']['cards'] += 1;

	if (!isset($stats['g']['t'][$card['type']]['txt'])) $stats['g']['t'][$card['type']]['txt'] = strlen($card['text']);
	$stats['g']['t'][$card['type']]['txt'] += strlen($card['text']);
	if (!isset($stats['g']['t'][$card['type']]['nb'])) $stats['g']['t'][$card['type']]['nb'] = 1;
	$stats['g']['t'][$card['type']]['nb'] += 1;
}


$topCards = $core->db->prepare("SELECT * FROM ".Config::read('db.table')." WHERE hidden = 0 ORDER BY CHAR_LENGTH(text) DESC LIMIT 10"); //TOP CARDS
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
	$name = ucfirst(Config::read('gene.types')[$key]);
	array_push($stats['topTypes']['datasets'][0]['data'], $value['txt']);
	array_push($stats['topTypes']['datasets'][0]['backgroundColor'], textToColor($name));
	array_push($stats['topTypes']['labels'], $name);
	array_push($stats['topTypes']['datasets'][1]['data'], $value['nb']);
	array_push($stats['topTypes']['datasets'][1]['backgroundColor'], textToColor($name));
}

$stats['topCards'] = json_encode($stats['topCards']);
$stats['topTypes'] = json_encode($stats['topTypes']);
$content['card'] = <<<HOMEPAGE
<div class="format">{$homepage}</div>
<h2 class="center">Statistiques</h2>
<div class="flexboxData">
	<div>
		<h2>Top des fiches</h2>
		<canvas id="chart-topcards"></canvas>
		Les 10 premières fiches représentent {$stats['topCard-perc']}% de la galerie.
	</div>
	<div>
		<h2>Catégories</h2>
		<canvas id="chart-toptypes"></canvas>
	</div>
</div>
<h2 class="center" id="pref">{$lang['homepage-prefs-title']}</h2>
<form action="">
	<div class="flexboxData borderMedium">
		<div>
			<h2>Design</h2>
			<select id="pref-theme">
				{$content['hp']['themeForm']}
			</select>
			<label for="pref-theme" class="toggle">{$lang['homepage-prefs-theme']}</label><br><br>
			<input class="checkbox" id="dyslexic" type="checkbox" {$prefDyslexic} value="on">
			<label for="dyslexic" class="toggle">{$lang['homepage-prefs-dyslexic']}</label>
		</div>
		<div>
			<h2>Technique</h2>
			<select id="pref-chooseLang">
				{$content['hp']['langForm']}
			</select>
			<label for="pref-chooseLang">{$lang['language']}</label><br><br>
		</div>
		<div>
			<h2>Vie privée</h2>
			Soon
		</div>
		<div>
		</div>
		<div class="center">
			<button class="input" onclick="changeParameters()">{$lang['homepage-prefs-confirm_changes']}</button><br>
			<span>*{$lang['cookie-warning']}</span>
		</div>

	</div>
</form>

<script>
	generateChart('bar', 'chart-topcards', {$stats['topCards']}, {'yaxis': ' caractères'});
	generateChart('pie', 'chart-toptypes', {$stats['topTypes']}, {'display': true});
</script>
HOMEPAGE;
?>
