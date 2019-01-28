<?php
if(isset($_GET['type'])) {
	$type = $_GET['type'];
	if(array_key_exists($type, $configTypes)) {
		if(isset($_GET['name']) AND !empty($_GET['name'])) { /*Shows a card*/
			$cardName = urldecode($_GET['name']);
			$searchInfo = searchCard($cardName, $config['cardsList'][$type]);
			if (!$searchInfo['isFound']) {
				http_response_code(404);
				header('Location: '.$config['general']['path'].'/error.php?e=404');
				die();
			}
			$loadedDB = $searchInfo['card'];
			if (isset($_GET['edit'])) { /*EDIT PAGE*/
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
				$cardContent = str_replace('[QUOTE_EDITION_GROUPNAME]', $searchInfo['group'], $cardContent);
				$cardContent = str_replace('[API_URL]', $config['general']['path']."/api/add.php", $cardContent);
				$cardContent = str_replace('[CARD_TYPE]', $type, $cardContent);
				$cardContent = str_replace('[CARD_NAME]', $cardName, $cardContent);
				$cardContent = str_replace('[QUOTE_TEXT]', $loadedDB['text'], $cardContent);
				$cardContent .= $HTMLdata['format-info'];

			} else { /*DISPLAY PAGE*/
				$infoContent['g_title'] = $cardName;
				$loadedDB['text'] = htmlentities($loadedDB['text']);
				$loadedText = nl2br($loadedDB['text']);
				$loadedText = preg_replace('/\t/', '&emsp;', $loadedText);
				$cardContent = "<h1>{$cardName}</h1>{$loadedText}";
			}
		} else { /*Shows a type (Cards large groups)*/
			$cardContent = "Page en développement. Si vous avez des idées, j'accepte :arnold:";
			$infoContent['g_title'] = "This page is not yet done.";
		}
	} else {
		http_response_code(404);
		header('Location: '.$config['general']['path'].'/error.php?e=404');
		die();
	}
} else { /*Shows the homepage*/
	$infoContent['g_title'] = "Galerie de Windersteel";
	$cardContent = $config['homepage']['top_description'];
	$cardContent .= $HTMLdata['homepage-search'];
	$cardContent .= "<div class='previewBoxes'>";
	if (isset($_GET['search'])) {
		$searchDB = $db->prepare('SELECT * FROM bestiaire WHERE (name REGEXP ? OR groupe REGEXP ?) AND hidden = 0');
		$searchDB->execute(array($_GET['search'],$_GET['search']));
		while ($listing = $searchDB->fetch()) {
			$cardContent .= $previewBox($listing);
		}
	$cardContent .= "</div>";
	}


	$totalDBCounter = $db->query('select count(*) from bestiaire where hidden = \'0\'')->fetchColumn();
	$config['homepage']['box-top_message'] = str_replace('[TOTALPAGES]', $totalDBCounter, $lang['homepage-top_message']);
	$cardContent .= "<div class='previewBoxes'><h2>".$config['homepage']['box-top_message']."</h2>";
	$boxList = $db->prepare('SELECT * FROM bestiaire WHERE hidden = 0 ORDER BY rand() LIMIT 4');
	$boxList->execute();
	while ($listing = $boxList->fetch()) {
		$cardContent .= $previewBox($listing);
	}
	$cardContent .= $HTMLdata['homepage-parameters'];
	$cardContent .= "</div>";
}

?>
