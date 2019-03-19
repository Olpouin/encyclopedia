<?php
require_once('../config.php');
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['pass'])) exit($APIresponse('serverror', $langAPI['isset']."pass"));
if (!isset($data['default_language'])) exit($APIresponse('serverror', $langAPI['isset']."default_language"));
if (!isset($data['site_name'])) exit($APIresponse('serverror', $langAPI['isset']."site_name"));
if (!isset($data['box-default_image'])) exit($APIresponse('serverror', $langAPI['isset']."box-default_image"));

if (!password_verify($data['pass'], $config['general']['globalPassword'])) exit($APIresponse('error',$langAPI['error-pass']));

if (!array_key_exists($data['default_language'], $config['lang'])) exit($APIresponse('serverror', $langAPI['errorserv-lang']));
if (strlen($data['site_name']) > 20 OR strlen($data['site_name']) < 1) exit($APIresponse('error',$langAPI['admin-config']['name-size']));
if (strlen($data['box-default_image']) > 100 OR strlen($data['box-default_image']) < 7) exit($APIresponse('error',$langAPI['admin-config']['image-size']));

$configGeneralNewArray = [
	"default_language" => $data['default_language'],
	"site_name" => $data['site_name'],
	"box-default_image" => $data['box-default_image']
];
$configGeneralUPDATE = $db->prepare("UPDATE {$config['database']['table']} SET text = ? WHERE name = 'general' AND type = '[SERVERDATA]'");
$configGeneralUPDATE->execute(
	array(
		json_encode($configGeneralNewArray)
	)
);

echo($APIresponse('success',$langAPI['successes']['admin-config']));
?>
