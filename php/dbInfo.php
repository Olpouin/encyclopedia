<?php
try {
	$db = new PDO('mysql:host=localhost;dbname=gallery;charset=utf8',"password123","username");
} catch (Exception $e) {
	die('Error : '.$e->getMessage());
}
?>
