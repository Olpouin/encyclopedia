<?php
Config::add('head.js', 'chart.min');
Config::add('head.css', 'chart.min');

$content['hp']['themeForm'] = "";
//Main text
$homepageReq = $core->db->prepare("SELECT * FROM ".Config::read('db.table')." WHERE type = '[SERVERDATA]' AND name = 'homepage'");
$homepageReq->execute();
$homepage = $homepageReq->fetch();
$homepage = $homepage['text'];

foreach (Config::read('gene.themes') as $value) {
	$themeSelected = ($value == $_COOKIE['theme']) ? "selected" : "";
	$name = ucwords(strtolower(str_replace('_', ' ', substr($value, 0, -4))));
	$content['hp']['themeForm'] .= "<option {$themeSelected} value=\"{$value}\">{$name}</option>";
}
//STATS
$stats['topCards'] = [
	'datasets' => [
		['data' => [], 'backgroundColor' => []]
	],
	'labels' => [],
];
$stats['topTypes'] = $stats['topGroups'] = [
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

	if (!isset($stats['g']['t']['txt'][$card['type']])) $stats['g']['t']['txt'][$card['type']] = strlen($card['text']);
	$stats['g']['t']['txt'][$card['type']] += strlen($card['text']);
	if (!isset($stats['g']['t']['nb'][$card['type']])) $stats['g']['t']['nb'][$card['type']] = 1;
	$stats['g']['t']['nb'][$card['type']] += 1;
}

//Top 10 cards
$topCards = $core->db->prepare("SELECT * FROM ".Config::read('db.table')." WHERE hidden = 0 ORDER BY CHAR_LENGTH(text) DESC LIMIT 10");
$topCards->execute();
while ($topCard = $topCards->fetch()) {
	$stats['topCards-length'] += strlen($topCard['text']);
	array_push($stats['topCards']['datasets'][0]['data'], strlen($topCard['text']));
	array_push($stats['topCards']['datasets'][0]['backgroundColor'], textToColor($topCard['name']));
	array_push($stats['topCards']['labels'], $topCard['name']);
}
$stats['topCard-perc'] = round(( $stats['topCards-length'] / $stats['g']['length'] ) * 100, 1);
//Types %
foreach ($stats['g']['t']['txt'] as $key => $value) {
	$name = ucfirst(Config::read('gene.types')[$key]);
	array_push($stats['topTypes']['datasets'][0]['data'], $value);
	array_push($stats['topTypes']['datasets'][0]['backgroundColor'], textToColor($name));
	array_push($stats['topTypes']['labels'], $name);
}
foreach ($stats['g']['t']['nb'] as $key => $value) {
	$name = ucfirst(Config::read('gene.types')[$key]);
	array_push($stats['topTypes']['datasets'][1]['data'], $value);
	array_push($stats['topTypes']['datasets'][1]['backgroundColor'], textToColor($name));
}

$stats['topCards'] = json_encode($stats['topCards']);
$stats['topTypes'] = json_encode($stats['topTypes']);
$stats['topGroups'] = json_encode($stats['topGroups']);

$content['title'] = "Accueil";
$content['page'] = <<<HOMEPAGE
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
<h2 class="center" id="pref">Préférences</h2>
<form action="">
	<div class="flexboxData borderMedium">
		<div>
			<h2>Design</h2>
			<select id="pref-theme">
				{$content['hp']['themeForm']}
			</select>
			<label for="pref-theme" class="toggle">Thème</label><br><br>
		</div>
		<div>
		</div>
		<div class="center">
			<button class="input" onclick="changeParameters()">Confirmer les changements</button><br>
			<span>*En modifiant les paramètres par défaut, vous acceptez l'utilisation de cookies.</span>
		</div>
	</div>
</form>

<script>
	generateChart('bar', 'chart-topcards', {$stats['topCards']}, {'yaxis': ' caractères'});
	generateChart('pie', 'chart-toptypes', {$stats['topTypes']}, {'display': true});
</script>
HOMEPAGE;
?>
