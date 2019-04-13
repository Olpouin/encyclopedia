<?php
$settings =  array();

$settings['mode'] = ($_COOKIE['mode'] == 'night') ?
	":root {--color_main: #0A0A0A;--color_borders: #323232;--color_sidenav: #060606;--color_main-opposite: #FFFFFF;--color_infobox-text_color: #F8F8F8;--invert-value: 100%;}"
	: ":root{--color_main: #FFFFFF;--color_borders:#DCDCDC;--color_sidenav:#FAFAFA;--color_main-opposite:#000000;--color_infobox-text_color:#F8F8F8;--invert-value:0%;}";
$settings['dyslexic'] = ($_COOKIE['dyslexic'] == "true") ?
	"html,select,button,input,blockquote{font-family:opendyslexic-regular,sans-serif!important;}"
	: "html{font-family:opensans-regular,sans-serif;}";


return $settings;
?>
