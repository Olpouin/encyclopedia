<?php
require_once('../../main.php');
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['pass'])) exit(APIresponse('error', "isset-pass"));
if (!isset($data['action'])) exit(APIresponse('error', "isset-action"));

switch ($data['action']) {
	case 'edit-config':
		if (!isset($data['site_name'])) exit(APIresponse('error', "isset-site_name"));
		if (!isset($data['box-default_image'])) exit(APIresponse('error', "isset-box-default_image"));
		try {
			$galleryParameters->setSiteName($data['site_name']);
			$galleryParameters->setDefaultImg($data['box-default_image']);
			$galleryParameters->update($data['pass']);
			echo(APIresponse('success','edited'));
		} catch (\Exception $e) {
			exit(APIresponse('error', $e->getMessage()));
		}
		break;
	case 'add-type':
		if (!isset($data['id'])) exit(APIresponse('error', "isset-type_id"));
		if (!isset($data['name'])) exit(APIresponse('error', "isset-type_name"));
		try {
			$galleryParameters->addType($data['id'],$data['name']);
			$galleryParameters->update($data['pass']);
			echo(APIresponse('success','edited'));
		} catch (\Exception $e) {
			exit(APIresponse('error', $e->getMessage()));
		}
		break;
	default:
		exit(APIresponse('error', "unknown-action"));
		break;
}

?>
