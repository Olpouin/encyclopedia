<?php //exit(APIresponse('', $langAPI['']));
require_once('../../main.php');
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['pass'])) exit(APIresponse('error', "isset-pass"));
if (!isset($data['type'])) exit(APIresponse('error', "isset-type"));
if (!isset($data['name'])) exit(APIresponse('error', "isset-name"));
if (!isset($data['group'])) exit(APIresponse('error', "isset-group"));
if (!isset($data['addPass'])) exit(APIresponse('error', "isset-addPass"));

if (!Config::checkPassword($data['pass'])) exit(APIresponse('error','wrong-password'));


$card = new Card();
if ($card->load($data['type'], $data['name'])) exit(APIresponse('error','already-exist'));

if (!$card->setName($data['name'])) exit(APIresponse('error', 'size-name'));
if (!$card->setType($data['type'])) exit(APIresponse('error', 'set-type'));
if (!$card->setGroup($data['group'])) exit(APIresponse('error','size-group'));
if (!$card->setPassword($data['addPass'])) exit(APIresponse('error','set-password'));
$card->setHidden("1");

if (!$card->create()) exit(APIresponse('error','already-exist'));

echo(APIresponse('success','added'));
logging(
	'Fiche crée',
	"**Nom :** ".$data['name'].
	"\n**Groupe :** ".$data['group'].
	"\n**Type :** ".$data['type']." (".Config::read('gene.types')[$data['type']].")",
	["color"=>"8311585","url"=>"https://".$_SERVER['HTTP_HOST'].Config::read('gene.path')."/".$data['type']."/".urlencode($data['name'])]
);
?>
