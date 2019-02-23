<?php
require_once('../config.php');
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['type'])) {
	if(array_key_exists($data['type'], $configTypes)) { //IF TYPE EXISTS AND IS CORRECT
		if(isset($data['name'])) {
			if (strlen($data['name']) < 35 AND strlen($data['name']) > 1) { //IF NAME EXISTS AND IS CORRECT
				if (isset($data['group'])) {
					if (strlen($data['group']) < 25 AND strlen($data['group']) >= 0) {
						if (isset($data['pass'])) {
							if (password_verify($data['pass'], $config['general']['globalPassword'])) {
								$createCard = $db->prepare('INSERT INTO bestiaire(name, type, groupe, hidden) VALUES(?, ?, ?, 1)');
								$createCard->execute(
									array(
										$data['name'],
										$data['type'],
										$data['group'],
									)
								);
								$json = array(
									'title' => $lang['api']['success'],
									'message' => $lang['api']['success-add']
								);
							} else {
								$json = array(
									'title' => $lang['api']['error'],
									'message' => $lang['api']['error-pass-wrong']
								);
							}
						} else {
							$json = array(
								'title' => $lang['api']['error'],
								'message' => $lang['api']['error-pass']
							);
						}
					} else {
						$json = array(
							'title' => $lang['api']['error'],
							'message' => $lang['api']['error-group-size']
						);
					}
				} else {
					$json = array(
						'title' => $lang['api']['error'],
						'message' => $lang['api']['error-group']
					);
				}
			} else {
				$json = array(
					'title' => $lang['api']['error'],
					'message' => $lang['api']['error-name-size']
				);
			}
		} else {
			$json = array(
				'title' => $lang['api']['error'],
				'message' => $lang['api']['error-name']
			);
		}
	} else {
		$json = array(
			'title' => $lang['api']['error'],
			'message' => $lang['api']['error-type-notfound']
		);
	}
} else {
	$json = array(
		'title' => $lang['api']['error'],
		'message' => $lang['api']['error-type']
	);
}

echo json_encode($json);
?>
