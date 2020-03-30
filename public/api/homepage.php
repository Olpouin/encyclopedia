<?php
require_once('../../main.php');

$card = new Card();
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data['text'])) exit(APIresponse('error', "isset-text"));
if(!isset($data['pass'])) exit(APIresponse('error', "isset-pass"));

if (!$card->load("[SERVERDATA]", "homepage")) exit(APIresponse('error','notfound'));

if (!$card->password($data['pass'])) exit(APIresponse('error','wrong-password'));
if (!$card->setText(html_entity_decode(json_encode($data['text'])))) exit(APIresponse('error','size-text'));

if(!$card->upload()) exit(APIresponse('error','unknown'));

echo(APIresponse('success','edited'));
?>
