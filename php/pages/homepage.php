<?php
$infoContent['g_title'] = "Accueil";
$content['hp']['search'] = $content['hp']['rand'] = $content['hp']['langForm'] = "";
//Main text
$homepageReq = $db->prepare("SELECT * FROM {$config['database']['table']} WHERE type = '[SERVERDATA]' AND name = 'homepage'");
$homepageReq->execute();
$homepage = $homepageReq->fetch();
$homepage = $format($homepage['text'], false);
//Search
if (isset($_GET['search'])) {
	$content['hp']['search'] = "<div class='center'>";
	$searchDB = $db->prepare("SELECT * FROM {$config['database']['table']} WHERE (name REGEXP ? OR groupe REGEXP ?) AND hidden = 0");
	$searchDB->execute(array($_GET['search'],$_GET['search']));
	while ($listing = $searchDB->fetch()) {
		$content['hp']['search'] .= $previewBox($listing);
	}
	$content['hp']['search'] .= "</div>";
}
//4 random cards
$totalDBCounter = $db->query("select count(*) from {$config['database']['table']} where hidden = '0'")->fetchColumn();
$content['hp']['randTitle'] = str_replace('[TOTALPAGES]', $totalDBCounter, $lang['homepage-top_message']);
$boxList = $db->prepare("SELECT * FROM {$config['database']['table']} WHERE hidden = 0 ORDER BY rand() LIMIT 4");
$boxList->execute();
while ($listing = $boxList->fetch()) {
	$content['hp']['rand'] .= $previewBox($listing);
}

foreach ($config['lang'] as $key => $value) {
	$langSelected = ($key == $config['general']['default_language']) ? "selected='selected'" : "";
	$content['hp']['langForm'] .= "<option {$langSelected} value='{$key}'>{$value}</option>";
}

//HTML
$content['card'] = <<<HOMEPAGE
{$homepage}
<label for="card-search-homepage">{$lang['homepage-search_input']}</label>
<form action="" class="cardSearchBox">
	<input id="card-search-homepage" class="cardSearch" type="text" name="search" placeholder="{$lang['homepage-search_input']}">
	<input class="cardSearch-button" type="submit" value="{$lang['homepage-search_button']}">
</form>
{$content['hp']['search']}
<div class='center'>
	<h2>{$content['hp']['randTitle']}</h2>
	{$content['hp']['rand']}
</div>
<div class="center">
	<h2 id="pref">{$lang['homepage-prefs-title']}</h2>
</div>
<form action="">
	<input class="checkbox" id="nightmode" type="checkbox" value="on">
	<label for="nightmode" class="toggle">{$lang['homepage-prefs-nightmode']}</label><br><br>
	<select id="pref-chooseLang">
		{$content['hp']['langForm']}
	</select>
	<label for="pref-chooseLang">{$lang['language']}</label><br><br>
	<input class="checkbox" id="prefeditor" type="checkbox" value="on">
	<label for="prefeditor" class="toggle">{$lang['homepage-prefs-editor']}</label><br><br>
	<input class="checkbox" id="dyslexic" type="checkbox" value="on">
	<label for="dyslexic" class="toggle">{$lang['homepage-prefs-dyslexic']}</label><br><br>
	{$lang['cookie-warning']}<br>
	<button class="input" onclick="changeParameters()">{$lang['homepage-prefs-confirm_changes']}</button>
</form>
HOMEPAGE;
?>
