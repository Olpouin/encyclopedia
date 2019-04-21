<?php //exit(APIresponse('', $langAPI['']));
require_once('../config.php');
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['pass'])) exit(APIresponse('servererror', $langAPI['isset']."pass"));
if (!isset($data['type'])) exit(APIresponse('servererror', $langAPI['isset']."type"));
if (!isset($data['name'])) exit(APIresponse('servererror', $langAPI['isset']."name"));
if (!isset($data['group'])) exit(APIresponse('servererror', $langAPI['isset']."group"));
if (!isset($data['addPass'])) exit(APIresponse('servererror', $langAPI['isset']."addPass"));

if (!$checkPassword($data['pass'])) exit(APIresponse('error',$langAPI['error-pass']));

if (!array_key_exists($data['type'], $configTypes)) exit(APIresponse('servererror', $langAPI['error-type-notfound']));
$cardR = $db->prepare("SELECT * FROM {$config['database']['table']} WHERE hidden = 0 AND type = ? AND name = ?");
$cardR->execute(array($data['type'],$data['name']));
$card = $cardR->fetch(PDO::FETCH_ASSOC);
if (!empty($card)) exit(APIresponse('error',$langAPI['error-name-alreadyexist']));
if (strlen($data['name']) > 35 OR strlen($data['name']) < 1) exit(APIresponse('error',$langAPI['error-name-size']));
if (strlen($data['group']) > 25 OR strlen($data['group']) <= 0) exit(APIresponse('error',$langAPI['error-group-size']));

$addPass = (strlen($data['addPass']) < 1) ? NULL : password_hash($data['addPass'], PASSWORD_DEFAULT);

$createCard = $db->prepare("INSERT INTO {$config['database']['table']}(name, type, groupe, password, hidden) VALUES(?, ?, ?, ?, 1)");
$createCard->execute(
	array(
		$data['name'],
		$data['type'],
		$data['group'],
		$addPass
	)
);

echo(APIresponse('success',$langAPI['successes']['add']));
?>
