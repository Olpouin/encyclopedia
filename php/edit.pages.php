<?php
$infoContent['g_title'] = "Édition de ".$cardName;
$editorFunctionBar = '<div class="editor-bar">';
foreach ($config['general']['editor-bar'] as $groupNumber => $groupData) {
	$editorFunctionBar .= '<div class="editor-bar_group">';
	foreach ($config['general']['editor-bar'][$groupNumber] as $formatNumber => $formatNumber) {
		$editorFunction = $config['general']['editor-bar'][$groupNumber][$formatNumber];
		$editorFunctionBar .= '<img class="edit-object" src="'.$config['general']['path'].'/content/icons/'.$editorFunction['icon'].'.svg" title="'.$editorFunction['name'].'" alt="'.$editorFunction['name'].'" onclick="addTextElement(\''.$editorFunction['format'].'\', '.$editorFunction['cursor_move'].')">';
	}
	$editorFunctionBar .= '</div>';
}
$editorFunctionBar .= '</div>';
if ($loadedDB['hidden'] == 1) $hideCheckboxValue = "checked=\"checked\"";
else $hideCheckboxValue = "";

$cardContent = str_replace('[QUOTE_EDITION_BAR]', $editorFunctionBar, $HTMLdata['editor-form']);
$cardContent = str_replace('[QUOTE_EDITION_HIDECHECK]', $hideCheckboxValue, $cardContent);
$cardContent = str_replace('[CARD_NAME]', $cardName, $cardContent);
$cardContent = str_replace('[QUOTE_EDITION_GROUPNAME]', $searchInfo['group'], $cardContent);
$cardContent = str_replace('[API_URL]', $config['general']['path']."/api/add.php", $cardContent);
$cardContent = str_replace('[CARD_TYPE]', $type, $cardContent);
$cardContent = str_replace('[CARD_NAME]', preg_replace('/\'/Um','\\\'',$cardName), $cardContent);
$cardContent = str_replace('[QUOTE_TEXT]', $loadedDB['text'], $cardContent);
$cardContent .= $HTMLdata['format-info'];
?>
