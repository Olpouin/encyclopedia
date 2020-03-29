<?php
$content['title'] = ucfirst(Config::read('gene.types')[$_GET['type']]);
$content['page'] = "type";
?>
