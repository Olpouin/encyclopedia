<?php
$infoContent['g_title'] = "Accueil";
//Main text
$homepageReq = $db->prepare('SELECT * FROM bestiaire WHERE type = "$SERV" AND name = "homepage"');
$homepageReq->execute();
$homepage = $homepageReq->fetch();
$homepage = $format($homepage['text']);
//Search
if (isset($_GET['search'])) {
$content['hp']['search'] = "<div class='center'>";
	$searchDB = $db->prepare('SELECT * FROM bestiaire WHERE (name REGEXP ? OR groupe REGEXP ?) AND hidden = 0');
	$searchDB->execute(array($_GET['search'],$_GET['search']));
	while ($listing = $searchDB->fetch()) {
		$content['hp']['search'] .= $previewBox($listing);
	}
$content['hp']['search'] .= "</div>";
} else $content['hp']['search'] = "";
//4 random cards
$totalDBCounter = $db->query('select count(*) from bestiaire where hidden = \'0\'')->fetchColumn();
$content['hp']['rand'] = "<div class='center'><h2>".str_replace('[TOTALPAGES]', $totalDBCounter, $lang['homepage-top_message'])."</h2>";
$boxList = $db->prepare('SELECT * FROM bestiaire WHERE hidden = 0 ORDER BY rand() LIMIT 4');
$boxList->execute();
while ($listing = $boxList->fetch()) {
	$content['hp']['rand'] .= $previewBox($listing);
}
$content['hp']['rand'] .= "</div>";

//HTML
$content['card'] = <<<HOMEPAGE
{$homepage}
<label for="card-search-homepage">{$lang['homepage-search_input']}</label>
<form action="" class="cardSearchBox">
	<input id="card-search-homepage" class="cardSearch" type="text" name="search" placeholder="{$lang['homepage-search_input']}">
	<input class="cardSearch-button" type="submit" value="{$lang['homepage-search_button']}">
</form>
{$content['hp']['search']}
{$content['hp']['rand']}
<div class="center">
	<h2 id="pref">{$lang['homepage-prefs-title']}</h2>
</div>
<form action="">
	<input class="checkbox" id="nightmode" type="checkbox" value="on">
	<label for="nightmode" class="toggle">{$lang['homepage-prefs-nightmode']}</label><br><br>
	<select id="pref-chooseLang">
		<option value="en_US">English, US</option>
		<option value="fr_FR">Français, France</option>
	</select>
	<label for="pref-chooseLang">{$lang['language']}</label><br><br>
	{$lang['cookie-warning']}<br>
	<button class="input" onclick="changeParameters()">{$lang['homepage-prefs-confirm_changes']}</button>
</form>
HOMEPAGE;
?>
