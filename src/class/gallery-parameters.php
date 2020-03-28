<?php
class GalleryParameters {
	private $_siteName;
	private $_defaultImg;
	private $_types;

	function __construct() {
		try {
			$core = Core::getInstance();
			$sql = "SELECT * FROM ".Config::read('db.table')." WHERE type = '[SERVERDATA]' AND name = 'general'";
			$configGeneralDB = $core->db->prepare($sql);
			$configGeneralDB->execute();
			$configGeneralJSON = $configGeneralDB->fetch();
		} catch (Exception $e) {
			die('Error : '.$e->getMessage());
		}
		$configGeneralArray = json_decode($configGeneralJSON['text'], true);

		$this->_siteName = $configGeneralArray['site_name'];
		$this->_defaultImg = $configGeneralArray['box-default_image'];
		$this->_types = $configGeneralArray['types'];
	}

	public function setSiteName($name='Gallery') {
		if (strlen($name) > 20 OR strlen($name) < 1) throw new Exception("size-site_name");
		$this->_siteName = $name;
	}
	public function setDefaultImg($url) {
		if (strlen($url) > 100 OR strlen($url) < 7) throw new Exception("size-image");
		$this->_defaultImg = $url;
	}
	public function addType($id,$name) {
		if (array_key_exists($id, $this->_types)) throw new Exception("alreadyexit-type");
		if (strlen($name) > 20 OR strlen($name) < 1) throw new Exception("size-type_name");
		if (strlen($id) > 10 OR strlen($id) < 1) throw new Exception("size-type_id");
		$this->_types[$id] = $name;
	}
	public function delType($id) {
		if (!array_key_exists($id, $this->_types)) throw new Exception("unknown-type");
		unset($this->_types[$id]);
	}

	public function toConfig() {
		Config::write('gene.site_name', $this->_siteName);
		Config::write('gene.default_img', $this->_defaultImg);
		Config::write('gene.types', $this->_types);
	}
	public function update($password) {
		if (!Config::checkPassword($password)) throw new Exception("wrong-password");
		$paramArray = array(
			'site_name' => $this->_siteName,
			'box-default_image' => $this->_defaultImg,
			'types' => $this->_types
		);
		try {
			$sql = "UPDATE ".Config::read('db.table')." SET text = ? WHERE name = 'general' AND type = '[SERVERDATA]'";
			$core = Core::getInstance();
			$editConfig = $core->db->prepare($sql);
			$editConfig->execute(array(
				json_encode($paramArray)
			));
		} catch (Exception $e) {
			die('Error : '.$e->getMessage());
		}
		$logTypes = "";
		foreach ($this->_types as $key => $value) {
			$logTypes .= $value.'['.$key.'] ; ';
		}
		logging(
			'Paramètres modifiés',
			"**Nom du site :** ".$this->_siteName.
			"\n**Image par défaut :** ".$this->_defaultImg.
			"\n**Types :** ".$logTypes
		);
	}
}


?>
