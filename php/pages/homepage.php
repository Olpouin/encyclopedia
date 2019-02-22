<?php
if (isset($_GET['edit'])) {
	require_once('homepage-edit.php');
} else {
$infoContent['g_title'] = "Accueil";
$homepageReq = $db->prepare('SELECT * FROM bestiaire WHERE type = "$SERV" AND name = "homepage"');
$homepageReq->execute();
$homepage = $homepageReq->fetch();

if (isset($homepage['text'])) $content['card'] = $format($homepage['text']);
else $content['card'] = "";

$content['card'] .= <<<HOMEPAGESEARCH
<label for="card-search-homepage">{$lang['homepage-search_input']}</label>
<form action="" class="cardSearchBox">
	<input id="card-search-homepage" class="cardSearch" type="text" name="search" placeholder="{$lang['homepage-search_input']}">
	<input class="cardSearch-button" type="submit" value="{$lang['homepage-search_button']}">
</form>
HOMEPAGESEARCH;
$content['card'] .= "<div class='previewBoxes'>";
if (isset($_GET['search'])) {
	$searchDB = $db->prepare('SELECT * FROM bestiaire WHERE (name REGEXP ? OR groupe REGEXP ?) AND hidden = 0');
	$searchDB->execute(array($_GET['search'],$_GET['search']));
	while ($listing = $searchDB->fetch()) {
		$content['card'] .= $previewBox($listing);
	}
$content['card'] .= "</div>";
}


$totalDBCounter = $db->query('select count(*) from bestiaire where hidden = \'0\'')->fetchColumn();
$content['card'] .= "<div class='previewBoxes'><h2>".str_replace('[TOTALPAGES]', $totalDBCounter, $lang['homepage-top_message'])."</h2>";
$boxList = $db->prepare('SELECT * FROM bestiaire WHERE hidden = 0 ORDER BY rand() LIMIT 4');
$boxList->execute();
while ($listing = $boxList->fetch()) {
	$content['card'] .= $previewBox($listing);
}
$content['card'] .= <<<HOMEPAGEPARAMETERS
<h2 id="pref">{$lang['homepage-prefs-title']}</h2>
<input class="checkbox" id="nightmode" type="checkbox" name="nightmode" value="on"><label for="nightmode" class="toggle">{$lang['homepage-prefs-nightmode']}</label><br><br>
<label for="pref-chooseLang">{$lang['language']} *</label>
<select id="pref-chooseLang">
	<option value="en_US">English, US</option>
	<option value="fr_FR">Français, France</option>
</select><br><br>
*{$lang['homepage-prefs-needsReload']}<br>
{$lang['cookie-warning']}<br><br>
<button class="input" onclick="changeParameters()">{$lang['homepage-prefs-confirm_changes']}</button>
HOMEPAGEPARAMETERS;
$content['card'] .= "</div>";
}
?>
