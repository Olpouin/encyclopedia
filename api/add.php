<?php
require_once('../config.php');
header('Content-Type: application/json');


if(isset($_POST['type'])) {
	$type = $_POST['type'];
	if(array_key_exists($type, $configTypes)) { //IF TYPE EXISTS AND IS CORRECT
		if(isset($_POST['name'])) {
			$name = urldecode($_POST['name']);
			$search = searchCard($name, $config['cardsList'][$type]);
			if ($search['isFound']) { //IF NAME EXISTS AND IS CORRECT
				$card = $search['card'];
				if(isset($_POST['pass'])) {
					if ((password_verify($_POST['pass'], $config['general']['globalPassword']) OR password_verify($_POST['pass'], $card['password'])) AND isset($_POST['text'])) { //IF PASSWORD EXISTS AND IS CORRECT + TEXT EXISTS
						$text = $_POST['text'];
						if (strlen($text) < 1000000 AND strlen($text) > 0) {
							if (isset($_POST['group'])) {
								$group = $_POST['group'];
								if (strlen($group) < 25 AND strlen($group) >= 0) {
									if (isset($_POST['hide-card'])) {
										if ($_POST['hide-card'] == "on") {
											$hidden = 1;
										} else {
											$hidden = 0;
										}
									}
									else $hidden = 0;

									$searchDB = $db->prepare('UPDATE bestiaire SET text = ?, groupe = ?, hidden = ? WHERE name = ? AND type = ?');
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
										'message' => $lang['api']['success-message']
									);
								} else {
									$json = array(
										'title' => $lang['api']['error'],
										'message' => $lang['api']['error-group-wrong']
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
								'message' => $lang['api']['error-text-wrong']
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
					'message' => $lang['api']['error-name-wrong']
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
			'message' => $lang['api']['error-type-wrong']
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
