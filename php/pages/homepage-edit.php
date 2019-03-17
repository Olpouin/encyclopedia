<?php
$infoContent['g_title'] = "Administration";
$noPassword = <<<NOPASS
<h1>⚠ {$lang['password']} ⚠</h1><br>
<form action="" method="post" style="text-align:center;">
	<input class="input" type="password" name="pass" placeholder="{$lang['password']}">
</form>
NOPASS;
if (isset($_POST['pass'])) {
	if (password_verify($_POST['pass'],$config['general']['globalPassword'])) {
		$typesForm = '';
		foreach ($config['types'] as $key => $value) {
			$typesForm .= '<option value="'.$key.'">'.ucfirst($value).'</option>';
		}
		$cards = $db->prepare('SELECT * FROM bestiaire');
		$cards->execute();
		$stats['c'] = $stats['t'] = "";
		$stats['g']['length'] = $stats['g']['img'] = $stats['g']['vid'] = $stats['g']['cards'] = $stats['g']['words'] = 0;
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
		$stats['g']['words-moy'] = round($stats['g']['length'] / $stats['g']['words'], 2);

		$topCards = $db->prepare('SELECT * FROM bestiaire ORDER BY CHAR_LENGTH(text) DESC LIMIT 10');
		$topCards->execute();
		while ($topCard = $topCards->fetch()) {
			$topCard['stat-strlen'] = strlen($topCard['text']);
			$topCard['stat-strlen_tot'] = round(( $topCard['stat-strlen'] / $stats['g']['length'] ) * 100, 1);
$stats['c'] .= <<<TOPCARDSTAT
<li>
	<dl>
		<dt><u>{$topCard['name']}</u></dt>
		<dd>
			<span style="color:#003399;">{$topCard['stat-strlen']}</span> caractères (<span style="color:#003399;">{$topCard['stat-strlen_tot']}</span>% total)
		</dd>
	</dl>
</li>
TOPCARDSTAT;
		}

		foreach ($stats['g']['t'] as $key => $value) {
			$moy = round(( $value / $stats['g']['length'] ) * 100, 1);
			if (isset($config['types'][$key])) $name = ucfirst($config['types'][$key]);
			else $name = $key;
$stats['t'] .= <<<TOPCARDSTAT
<li>
	<dl>
		<dt><u>$name</u></dt>
		<dd>
			<span style="color:#003399;">{$value}</span> caractères (<span style="color:#003399;">{$moy}</span>% total)
		</dd>
	</dl>
</li>
TOPCARDSTAT;
		}
		$content['card'] = <<<HOMEPAGEEDITMAIN
<h1>{$lang['admin-title']}</h1><br>
<input id="pass" value="{$_POST['pass']}" type="hidden">
<div class="flexboxData">
	<div>
		<h2>{$lang['admin-createcard']}</h2><br>
		<input id="add-name" type="text" required="" placeholder="{$lang['edition-name_placeholder']}">
		<label for="add-name">{$lang['edition-name_placeholder']}</label><br><br>
		<input id="add-group" type="text" required="" placeholder="{$lang['edition-group_placeholder']}">
		<label for="add-group">{$lang['edition-group_placeholder']}</label><br><br>
		<select id="add-type" required="">
			{$typesForm}
		</select>
		<label for="add-type">{$lang['edition-type_placeholder']}</label><br><br>
		<input id="add-pass" type="password" required="" placeholder="{$lang['password']}">
		<label for="add-pass">{$lang['password']} ({$lang['optional']})</label><br><br>
		<button class="submit" onclick="addCardOC()">{$lang['send']}</button>
	</div>
	<div>
		<h2>Gérer les types</h2>
	</div>
	<div>
		<h2>Statistiques</h2>
		<div class="flexboxData">
			<div>
				<h2>Statistiques généraux</h2>
				Total de fiches : {$stats['g']['cards']}<br>
				Total de caractères: {$stats['g']['length']}<br>
				Nombre total de mots : {$stats['g']['words']}<br>
				Total d'images : {$stats['g']['img']}<br>
				Total de vidéos YouTube : {$stats['g']['vid']}<br>
				<br>
				Moyenne de lettre par mots : {$stats['g']['words-moy']}<br>
				Moyenne de caractères par fiche : {$stats['g']['length-moy']}<br>
			</div>
			<div>
				<h2>Fiches les plus grandes</h2>
				<ol type="1">
					{$stats['c']}
				</ol>
			</div>
			<div>
				<h2>Classement des types</h2>
				<ul>
					{$stats['t']}
				</ul>
			</div>
			<div>
				<h2>???</h2>
			</div>
		</div>
	</div>
</div>
HOMEPAGEEDITMAIN;
	} else {
		$content['card'] = "<span style='text-align:center;font-size:5em;display:block;'>".$lang['wrong']."</span>".$noPassword;
	}
} else {
	$content['card'] = $noPassword;
}
?>
