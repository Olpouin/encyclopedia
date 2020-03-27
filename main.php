<?php
require_once('vendor/autoload.php');

class Config {
	static $confArray;

	public static function read($name) {
		return self::$confArray[$name];
	}
	public static function write($name, $value) {
		self::$confArray[$name] = $value;
	}
	public static function add($name, $value) {
		if (!is_array(self::$confArray[$name])) return false;
		array_push(self::$confArray[$name], $value);
	}

	public static function checkPassword($pass) {
		foreach (Config::read('gene.password') as $key) {
			if (password_verify($pass, $key)) return true;
		} return false;
	}
}

require_once('config/database.php');
require_once('config/general.php');
Config::write('gene.editorconfig', file_get_contents("config/editorJS.json", FILE_USE_INCLUDE_PATH));
$config = new Config();

class Core {
	public $db;
	private static $instance;

	function __construct() {
		$dsn = 'mysql:host='.Config::read('db.host').';dbname='.Config::read('db.name');
		$user = Config::read('db.user');
		$password = Config::read('db.password');

		$this->db = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	}

	public static function getInstance() {
		if (!isset(self::$instance)) {
			$object = __CLASS__;
			self::$instance = new $object;
		}
		return self::$instance;
	}
}
$core = Core::getInstance();

try {
	$sql = "SELECT * FROM ".Config::read('db.table')." WHERE type = '[SERVERDATA]' AND name = 'general'";
	$configGeneralDB = $core->db->prepare($sql);
	$configGeneralDB->execute();
	$configGeneralJSON = $configGeneralDB->fetch();
} catch (Exception $e) {
	die('Error : '.$e->getMessage());
}
if (!$configGeneralJSON) {
	$sql = "INSERT INTO ".Config::read('db.table')."(name, type, text, hidden) VALUES(?, ?, ?, 1)";
	$createConfig = $core->db->prepare($sql);
	$createConfig->execute(array(
		'general',
		'[SERVERDATA]',
		'{"site_name":"Gallery","box-default_image":"https:\/\/url.com\/img.jpg"}'
	));

	$configGeneralDB->execute();
	$configGeneralJSON = $configGeneralDB->fetch();
}
$configGeneralArray = json_decode($configGeneralJSON['text'], true);
Config::write('gene.site_name', $configGeneralArray['site_name']);
Config::write('gene.default_img', $configGeneralArray['box-default_image']);

Config::write('gene.visibility', '0');
Config::write('gene.isEditing', '0');

require_once('src/class/card.php');
require_once('src/functions.php');
?>
