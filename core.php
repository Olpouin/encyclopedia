<?php
//https://stackoverflow.com/questions/2047264/use-of-pdo-in-classes
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
Config::write('db.host', '');
Config::write('db.name', '');
Config::write('db.user', '');
Config::write('db.password', '');
Config::write('db.table', '');
Config::write('gene.password', [

]);  //The general password. Hash with "password_hash("YOURPASSWORD", PASSWORD_DEFAULT);". Possibility to set multiple passwords.
Config::write('gene.types', [

]);
Config::write('head.js', []);
Config::write('head.css', []);

class Core {
	public $db;
	private static $instance;

	function __construct() {
		$dsn = 'mysql:host='.Config::read('db.host').';dbname='.Config::read('db.name');
		$user = Config::read('db.user');
		$password = Config::read('db.password');

		$this->db = new PDO($dsn, $user, $password);
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

$config['lang'] = [
	'en_US' => 'English, US',
	'fr_FR' => 'Français, France'
];

//Path detection
preg_match('/(\/(.*))\//Um', $_SERVER['PHP_SELF'], $detectedPaths);
$config['general']['path'] = $detectedPaths['1'];

define("PATH",$config['general']['path']);

require_once 'php/functions.inc.php';
?>
