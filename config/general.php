<?php
Config::write('gene.path', '');
Config::write('gene.types', [
	'z' => 'Example'
]);
Config::write('gene.password', [
	''
]);  //The general password. Hash with "password_hash("YOURPASSWORD", PASSWORD_DEFAULT);". Possibility to set multiple passwords.
?>
