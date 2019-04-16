<?php
$modes['forest'] = <<<MODE_FOREST
--general-color: #1F704C;
--general-background: #FFFFFF;
--general-shadow: rgba(0, 0, 0, 0.59);
--general-text: #000000;
--general-text_second: #8c8c8c;
--general-text_third: #464242;
--general-link: #207951;
--general-border: #DCDCDC;
--general-scrollbar: #DCDCDC;
--sidenav-background: #FAFAFA;
--sidenav-border: #DCDCDC;
--button-background_hover: #c3efdb;
--button-background_active: #5ed49f;
--toc-background: #FDFDFD;
--footer-background: #F1F3F4;
--hr: #000000;
--infobox-text_h1: #F8F8F8;
--infobox-background: #FAFAFA;
--toolbar-icons: 0%;
MODE_FOREST;
$modes['sky'] = <<<MODE_SKY
--general-color: #3295FF;
--general-background: #FFFFFF;
--general-shadow: rgba(0, 0, 0, 0.59);
--general-text: #000000;
--general-text_second: #8c8c8c;
--general-text_third: #464242;
--general-link: #004A99;
--general-border: #DCDCDC;
--general-scrollbar: #DCDCDC;
--sidenav-background: #FAFAFA;
--sidenav-border: #DCDCDC;
--button-background_hover: #EBF5FF;
--button-background_active: #D6EAFF;
--toc-background: #FDFDFD;
--footer-background: #F1F3F4;
--hr: #000000;
--infobox-text_h1: #F8F8F8;
--infobox-background: #FAFAFA;
--toolbar-icons: 0%;
MODE_SKY;
$modes['galaxy'] = <<<MODE_GALAXY
--general-color: #5500cc;
--general-background: #0A0A0A;
--general-shadow: rgba(0, 0, 0, 0.59);
--general-text: #E0E0E0;
--general-text_second: #EEEEEE;
--general-text_third: #DDDDDD;
--general-link: #260099;
--general-border: #323232;
--general-scrollbar: #323232;
--sidenav-background: #111314;
--sidenav-border: #323232;
--button-background_hover: #11091D;
--button-background_active: #190831;
--toc-background: #0D0D0D;
--footer-background: #111314;
--hr: #FFFFFF;
--infobox-text_h1: #F8F8F8;
--infobox-background: #0D0D0D;
--toolbar-icons: 80%;
MODE_GALAXY;
$modes['abyss'] = <<<MODE_ABYSS
--general-color: #003399;
--general-background: #000000;
--general-shadow: rgba(255, 255, 255, 0.1);
--general-text: #CCCCCC;
--general-text_second: #8c8c8c;
--general-text_third: #464242;
--general-link: #002266;
--general-border: #313131;
--general-scrollbar: #323232;
--sidenav-background: #050505;
--sidenav-border: #050505;
--button-background_hover: #00050F;
--button-background_active: #000A1F;
--toc-background: #050505;
--footer-background: #050505;
--hr: #FFFFFF;
--infobox-text_h1: #F8F8F8;
--infobox-background: #050505;
--toolbar-icons: 40%;
MODE_ABYSS;

$settings =  array();
if (!array_key_exists($_COOKIE['theme'], $modes)) $_COOKIE['theme'] = 'sky';
$settings['design'] = ":root{".$modes[$_COOKIE['theme']]."}";
$settings['modesList'] = $modes;
$settings['dyslexic'] = ($_COOKIE['dyslexic'] == "true") ?
	"html,select,button,input,blockquote{font-family:opendyslexic-regular,sans-serif!important;}"
	: "html{font-family:opensans-regular,sans-serif;}";
return $settings;
?>
