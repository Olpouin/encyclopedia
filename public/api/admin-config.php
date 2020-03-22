<?php
require_once('../../main.php');
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['pass'])) exit(APIresponse('error', "isset-pass"));
if (!isset($data['site_name'])) exit(APIresponse('error', "isset-site_name"));
if (!isset($data['box-default_image'])) exit(APIresponse('error', "isset-box-default_image"));

if (!Config::checkPassword($data['pass'])) exit(APIresponse('error','wrong-password'));

if (strlen($data['site_name']) > 20 OR strlen($data['site_name']) < 1) exit(APIresponse('error','size-site_name'));
if (strlen($data['box-default_image']) > 100 OR strlen($data['box-default_image']) < 7) exit(APIresponse('error','size-image'));

$configGeneralNewArray = [
	"site_name" => $data['site_name'],
	"box-default_image" => $data['box-default_image']
];

try {
	$sql = "UPDATE ".Config::read('db.table')." SET text = ? WHERE name = 'general' AND type = '[SERVERDATA]'";
	$core = Core::getInstance();
	$editConfig = $core->db->prepare($sql);
	$editConfig->execute(
		array (
			json_encode($configGeneralNewArray)
		)
	);
} catch (Exception $e) {
	die('Error : '.$e->getMessage());
}


echo(APIresponse('success','edited'));
logging(
	'Paramètres modifiés',
	"**Nom du site :** ".$data['site_name'].
	"\n**Image par défaut des aperçus :** ".$data['box-default_image']
);
?>
