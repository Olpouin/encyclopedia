<?php
if(isset($_GET['type'])) {
	$type = $_GET['type'];
	if(array_key_exists($type, $configTypes)) {
		if(isset($_GET['name']) AND !empty($_GET['name'])) { /*Shows a card*/
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
	$cardContent .= "<form action=\"\" class=\"cardSearchBox\"><input class=\"cardSearch\" type=\"text\" name=\"search\" placeholder=\"Recherche d'une fiche...\"><input class=\"cardSearch-button\" type=\"submit\" value=\"Chercher\"></form><div class='previewBoxes'>";
	if (isset($_GET['search'])) {
		$searchDB = $db->prepare('SELECT * FROM bestiaire WHERE name REGEXP ? OR groupe REGEXP ?');
		$searchDB->execute(array($_GET['search'],$_GET['search']));
		while ($listing = $searchDB->fetch()) {
			preg_match('/\?\[(.*)\]\((.*)\)/m', $listing['text'], $matches);
			if (empty($matches)) {
				$matches['2'] = $config['homepage']['box-default_image'];
			}
			$cardContent .= '<a href="'.$config['general']['path'].'/'.$listing['type'].'/'.str_replace(' ','-', $listing['name']).'" title="'.$listing['name'].'" ><div class="previewBox" style="background-image: url('.$matches['2'].');"><span>'.$listing['name'].'</span></div></a>';
		}
	$cardContent .= "</div>";
	}


	$totalDBCounter = $db->query('select count(*) from bestiaire')->fetchColumn();
	$config['homepage']['box-top_message'] = str_replace('[$TOTALPAGES]', $totalDBCounter, $config['homepage']['box-top_message']);
	$cardContent .= "<div class='previewBoxes'><h2>".$config['homepage']['box-top_message']."</h2>";
	$boxList = $db->prepare('SELECT * FROM bestiaire ORDER BY rand() LIMIT 8');
	$boxList->execute();
	while ($listing = $boxList->fetch()) {
		preg_match('/\?\[(.*)\]\((.*)\)/m', $listing['text'], $matches);
		if (empty($matches)) {
			$matches['2'] = $config['homepage']['box-default_image'];
		}
		$cardContent .= '<a href="'.$config['general']['path'].'/'.$listing['type'].'/'.str_replace(' ','-', $listing['name']).'" title="'.$listing['name'].'" ><div class="previewBox" style="background-image: url('.$matches['2'].');"><span>'.$listing['name'].'</span></div></a>';
	}
	$cardContent .= "<div>Source code on GitHub at <a href='https://github.com/Olpouin/gallery' target='_blank' style='color: #0066d3;text-decoration:none;'>github.com/Olpouin/gallery</a></div></div>";
}

?>
