<?php
require_once('../config.php');
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['type'])) {
	if(array_key_exists($data['type'], $configTypes)) { //IF TYPE EXISTS AND IS CORRECT
		if(isset($data['name'])) {
			$search = searchCard($data['name'], $config['cardsList'][$data['type']]);
			if (!$search['isFound']) {
				if (strlen($data['name']) < 35 AND strlen($data['name']) > 1) { //IF NAME EXISTS AND IS CORRECT
					if (isset($data['group'])) {
						if (strlen($data['group']) < 25 AND strlen($data['group']) >= 0) {
							if (isset($data['pass'])) {
								if (password_verify($data['pass'], $config['general']['globalPassword'])) {
									if (isset($data['addPass'])) {
										if (strlen($data['addPass']) < 1) $data['addPass'] = NULL;
										else $data['addPass'] = password_hash($data['addPass'], PASSWORD_DEFAULT);
									} else $data['addPass'] = NULL;
									$createCard = $db->prepare("INSERT INTO {$config['database']['table']}(name, type, groupe, password, hidden) VALUES(?, ?, ?, ?, 1)");
									$createCard->execute(
										array(
											$data['name'],
											$data['type'],
											$data['group'],
											$data['addPass']
										)
									);
									$json = array(
										'title' => $lang['api']['titles']['success'],
										'message' => $lang['api']['success-add']
									);
								} else {
									$json = array(
										'title' => $lang['api']['titles']['error'],
										'message' => $lang['api']['error-pass-wrong']
									);
								}
							} else {
								$json = array(
									'title' => $lang['api']['titles']['error'],
									'message' => $lang['api']['error-pass']
								);
							}
						} else {
							$json = array(
								'title' => $lang['api']['titles']['error'],
								'message' => $lang['api']['error-group-size']
							);
						}
					} else {
						$json = array(
							'title' => $lang['api']['titles']['error'],
							'message' => $lang['api']['error-group']
						);
					}
				} else {
					$json = array(
						'title' => $lang['api']['titles']['error'],
						'message' => $lang['api']['error-name-size']
					);
				}
			} else {
				$json = array(
					'title' => $lang['api']['titles']['error'],
					'message' => $lang['api']['error-name-alreadyexist']
				);
			}
		} else {
			$json = array(
				'title' => $lang['api']['titles']['error'],
				'message' => $lang['api']['error-name']
			);
		}
	} else {
		$json = array(
			'title' => $lang['api']['titles']['error'],
			'message' => $lang['api']['error-type-notfound']
		);
	}
} else {
	$json = array(
		'title' => $lang['api']['titles']['error'],
		'message' => $lang['api']['error-type']
	);
}

echo json_encode($json);
?>
