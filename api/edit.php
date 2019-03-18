<?php
require_once('../config.php');
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['type'])) {
	$type = $data['type'];
	if(array_key_exists($type, $configTypes)) { //IF TYPE EXISTS AND IS CORRECT
		if(isset($data['name'])) {
			$name = urldecode($data['name']);
			$search = searchCard($name, $config['cardsList'][$type]);
			if ($search['isFound']) { //IF NAME EXISTS AND IS CORRECT
				$card = $search['card'];
				if(isset($data['pass'])) {
					if ((password_verify($data['pass'], $config['general']['globalPassword']) OR password_verify($data['pass'], $card['password'])) AND isset($data['text'])) { //IF PASSWORD EXISTS AND IS CORRECT + TEXT EXISTS
						$text = $data['text'];
						if (strlen($text) < 1000000 AND strlen($text) > 0) {
							if (isset($data['group'])) {
								$group = $data['group'];
								if (strlen($group) < 25 AND strlen($group) >= 0) {
									if (isset($data['hide'])) {
										if ($data['hide']) {
											$hidden = 1;
										} else {
											$hidden = 0;
										}
									}
									else $hidden = 0;
									$text = $serverFormat($text);

									$searchDB = $db->prepare("UPDATE {$config['database']['table']} SET text = ?, groupe = ?, hidden = ? WHERE name = ? AND type = ?");
									$searchDB->execute(
										array(
											$text,
											$group,
											$hidden,
											$name,
											$type
											)
										);
									$json = array(
										'title' => $lang['api']['success'],
										'message' => $lang['api']['success-edit']
									);
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
								'message' => $lang['api']['error-text-size']
							);
						}
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
					'message' => $lang['api']['error-name-notfound']
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
