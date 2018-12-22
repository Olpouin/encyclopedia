<?php
if(isset($_GET['type'])) {
	$type = $_GET['type'];
	if(array_key_exists($type, $configTypes)) {
		if(isset($_GET['name']) AND !empty($_GET['name'])) { /*Shows a card*/
			if (isset($_GET['edit'])) { /*EDIT PAGE*/
				$dbSearchName = str_replace('-',' ', $_GET['name']);
				$searchDB = $db->prepare('SELECT * FROM bestiaire WHERE name = ? AND type = ?');
				$searchDB->execute(array($dbSearchName,$type));
				$loadedDB = $searchDB->fetch();
				$infoContent['g_title'] = "Édition de ".$loadedDB['name'];
				if(isset($_POST['pass'])) {
					if ((password_verify($_POST['pass'], $config['general']['globalPassword']) OR password_verify($_POST['pass'], $loadedDB['password'])) AND isset($_POST['text'])) {
						if (strlen($_POST['text']) < 1000000 OR strlen($_POST['text']) > 10) {
							$searchDB = $db->prepare('UPDATE bestiaire SET text = ? WHERE name = ? AND type = ?');
							$searchDB->execute(array($_POST['text'],$dbSearchName,$type));
							$cardContent = "Modification réussie.";
							header('Location: '.$config['general']['path'].'/'.$type.'/'.str_replace(' ','-', $dbSearchName));
						} else {
							$cardContent = "Texte trop long. Retournez en arrière pour récupérer le texte";
						}
					} else {
						http_response_code(401);
						header('Location: '.$config['general']['path'].'/error.php?e=401');
						die();
					}
				} else {
					$infoContent['g_title'] = "Édition de fiche";
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
					$cardContent = str_replace('[QUOTE_TEXT]', $loadedDB['text'], $HTMLdata['editor-form']);
					$cardContent = str_replace('[QUOTE_EDITION_BAR]', $editorFunctionBar, $cardContent);
					$cardContent .= $HTMLdata['format-info'];
				}
			} else { /*DISPLAY PAGE*/
				$dbSearchName = str_replace('-',' ', $_GET['name']);
				$searchDB = $db->prepare('SELECT * FROM bestiaire WHERE name = ? AND type = ?');
				$searchDB->execute(array($dbSearchName,$type));
				$loadedDB = $searchDB->fetch();
				if (empty($loadedDB)) {
					http_response_code(404);
					header('Location: '.$config['general']['path'].'/error.php?e=404');
					die();
				}
				$infoContent['g_title'] = $loadedDB['name'];
				$loadedDB['text'] = htmlentities($loadedDB['text']);
				$loadedText = nl2br($loadedDB['text']);
				$loadedText = preg_replace('/\t/', '&emsp;', $loadedText);
				$cardContent = "<h1>{$loadedDB['name']}</h1>{$loadedText}";
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
		$searchDB = $db->prepare('SELECT * FROM bestiaire WHERE name REGEXP ? OR groupe REGEXP ?');
		$searchDB->execute(array($_GET['search'],$_GET['search']));
		while ($listing = $searchDB->fetch()) {
			$cardContent .= $previewBox($listing);
		}
	$cardContent .= "</div>";
	}


	$totalDBCounter = $db->query('select count(*) from bestiaire')->fetchColumn();
	$config['homepage']['box-top_message'] = str_replace('[TOTALPAGES]', $totalDBCounter, $config['homepage']['box-top_message']);
	$cardContent .= "<div class='previewBoxes'><h2>".$config['homepage']['box-top_message']."</h2>";
	$boxList = $db->prepare('SELECT * FROM bestiaire ORDER BY rand() LIMIT 8');
	$boxList->execute();
	while ($listing = $boxList->fetch()) {
		$cardContent .= $previewBox($listing);
	}
	$cardContent .= $HTMLdata['code-link'];
	$cardContent .= "</div>";
}

?>
