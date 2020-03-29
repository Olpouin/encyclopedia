<?php
require_once('../../main.php');

$card = new Card();
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data['type'])) exit(APIresponse('error', "isset-type"));
if(!isset($data['text'])) exit(APIresponse('error', "isset-text"));
if(!isset($data['name'])) exit(APIresponse('error', "isset-name"));
if(!isset($data['pass'])) exit(APIresponse('error', "isset-pass"));
if(!isset($data['group'])) exit(APIresponse('error', "isset-group"));
if(!isset($data['hide'])) exit(APIresponse('error', "isset-hide"));

$name = urldecode($data['name']);
if (!$card->load($data['type'], $name)) exit(APIresponse('error','notfound'));

if (!$card->password($data['pass'])) exit(APIresponse('error','wrong-password'));
if (!$card->setText(html_entity_decode(json_encode($data['text'])))) exit(APIresponse('error','size-text'));
$hidden = ($data['hide']) ? 1 : 0;
$card->setHidden($hidden);
if (!$card->setGroup($data['group'])) exit(APIresponse('error','size-group'));

if(!$card->upload()) exit(APIresponse('error','unknown'));

echo(APIresponse('success','edited'));
logging(
	'Fiche modifiée',
	"**Nom :** ".$name.
	"\n**Type :** ".$data['type']." (".Config::read('gene.types')[$data['type']].")",
	["color"=>"16312092","url"=>"https://".$_SERVER['HTTP_HOST'].Config::read('gene.path')."/".$data['type']."/".urlencode($data['name'])]
);
?>
