<?php
class Card {
	private $db;
	private $_password;
	private $_name;
	private $_type;
	private $_group;
	private $_text;
	private $_hidden;

	private $formatArray = array(
		'/&lt;i&gt;(.*)&lt;\/i&gt;/Ums' => '<i>$1</i>',
		'/&lt;b&gt;(.*)&lt;\/b&gt;/Ums' => '<b>$1</b>',
		'/&lt;u&gt;(.*)&lt;\/u&gt;/Ums' => '<u>$1</u>',
		'/&lt;s&gt;(.*)&lt;\/s&gt;/Ums' => '<s>$1</s>',
		'/&lt;sub&gt;(.*)&lt;\/sub&gt;/Ums' => '<sub>$1</sub>',
		'/&lt;sup&gt;(.*)&lt;\/sup&gt;/Ums' => '<sup>$1</sup>',
		'/&lt;a href=&quot;(.*)&quot;&gt;(.*)&lt;\/a&gt;/Ums' => '<a href="$1" target="_blank" rel="external">$2</a>',
		'/&lt;br&gt;/Ums' => '<br>',
		'/\[ibd\](.*)\|(.*)\[\/ibd\]/Ums' => '<div class="infobox-data"><span class="infobox-data-title">$1</span><span>$2</span></div>',
		'/\[h1\](.*)\[\/h1\]/Ums' => '<h1>$1</h1>',
		'/\[ib\](.*)\!\[(.*)\]\((.*)\)(.*)\[\/ib\]/Um' => '[ib]$1<img src="$3" onclick="fullscreen(event)" alt="$2">$4[/ib]',
		'/\[ib\](.*)\[\/ib\]/Ums' => '<aside>$1</aside>'
	);

	private function secure($txt) {
		$txt = htmlspecialchars($txt);
		foreach ($this->formatArray as $key => $value) {
			$txt = preg_replace($key, $value, $txt);
		}
		return $txt;
	}

	public function group() {
		return $this->_group;
	}
	public function text($type='default') {
		switch ($type) {
			case 'html':
				$JSONtext = $this->_text;
				if (empty($this->_text)) $JSONtext = "[]";
				$text = "";
				$ARRAYtext = json_decode($JSONtext, true);
				if(!is_array($ARRAYtext)) $ARRAYtext = [["type"=>"paragraph","data"=>["text"=>"Le texte sauvegardé n'est pas un array. Tout le contenu a été ignoré."]]];
				foreach ($ARRAYtext as $key => $value) {
					$data = $ARRAYtext[$key]['data'];
					switch ($ARRAYtext[$key]['type']) {
						case 'embed':
							switch ($data['service']) {
								case 'youtube':
									$text .= "<div class=\"embed\"><iframe src=\"".$data['embed']."\" allowfullscreen></iframe><div>".$data['caption']."</div></div>";
									break;
							}
							break;
						case 'header':
							if (!is_numeric($data['level']) OR $data['level'] > 6 OR $data['level'] < 1) $data['level'] = 1;
							$text .= "<h{$this->secure($data['level'])}>{$this->secure($data['text'])}</h{$this->secure($data['level'])}>";
							break;
						case 'paragraph':
							$text .= "<p>{$this->secure($data['text'])}</p>";
							break;
						case 'quote':
							$text .= "<blockquote><span>{$this->secure($data['text'])}</span><cite>{$this->secure($data['caption'])}</cite></blockquote>";
							break;
						case 'image':
							$class = "";
							if ($data['stretched']) $class .= "stretch ";
							$text .= "<img class=\"{$class}\" src=\"{$this->secure($data['url'])}\" onclick=\"fullscreen(event)\" alt=\"{$this->secure($data['caption'])}\">";
							break;
						case 'table':
							$text .= "<table>";
							foreach ($data['content'] as $line => $lineData) {
								$text .= "<tr>";
								foreach ($data['content'][$line] as $column => $columnData) {
									$text .= "<th>{$this->secure($columnData)}";
								}
								$text .= "</tr>";
							}
							$text .= "</table>";
							break;
						case 'list':
							$text .= ($data['style'] == 'unordered') ? "<ul>" : "<ol>";
							foreach ($data['items'] as $listText) {
								$text .= "<li>{$this->secure($listText)}</li>";
							}
							$text .= ($data['style'] == 'unordered') ? "</ul>" : "</ol>";
							break;
					}
				}
				return $text;
				break;
			default:
				if (empty($this->_text)) return "[]";
				return $this->_text;
				break;
		}
	}
	public function hidden() {
		return ($this->_hidden == 1) ? true : false;
	}
	public function password($pass) {
		if (Config::checkPassword($pass)) return true;
		return password_verify($pass, $this->_password);
	}

	public function setHidden($hidden) {
		$this->_hidden = $hidden;
		return true;
	}
	public function setGroup($group) {
		if (strlen($group) > 25 OR strlen($group) <= 0) return false;

		$this->_group = $group;
		return true;
	}
	public function setPassword($pass) {
		$newPass = (strlen($pass) < 1) ? NULL : password_hash($pass, PASSWORD_DEFAULT);

		$this->_password = $newPass;
		return true;
	}
	public function setName($name) {
		if (strlen($name) > 35 OR strlen($name) < 1) return false;

		$this->_name = $name;
		return true;
	}
	public function setType($type) {
		if (!array_key_exists($type, Config::read('gene.types'))) return false;

		$this->_type = $type;
		return true;
	}
	public function setText($text) {
		$realText = json_encode($text);

		if (strlen($realText) > 10000000 OR strlen($realText) < 0) return false;

		$textTesting = json_decode($JSONtext, true);
		// TODO: Test the data to make sure it is correct, refuse to save anything if it is not.

		$this->_text = $realText;
		return true;
	}

	public function load($type='', $name='') {
		try {
			$sql = "SELECT * FROM ".Config::read('db.table')." WHERE type = ? AND name = ?";
			$core = Core::getInstance();
			$cardR = $core->db->prepare($sql);
			$cardR->execute(array($type,$name));
			$card = $cardR->fetch(PDO::FETCH_ASSOC);

			if (!$card) return false;
			else {
				$this->_password = $card['password'];
				$this->_group = $card['groupe'];
				$this->_text = $card['text'];
				$this->_hidden = $card['hidden'];
				$this->_name = $card['name'];
				$this->_type = $card['type'];
			}
			return true;
		} catch (Exception $e) {
			die('Error : '.$e->getMessage());
		}
	}
	public function upload() {
		try {
			$sql = "UPDATE ".Config::read('db.table')." SET text = ?, groupe = ?, hidden = ? WHERE name = ? AND type = ?";
			$core = Core::getInstance();
			$searchDB = $core->db->prepare($sql);
			$searchDB->execute(
				array (
					$this->_text,
					$this->_group,
					$this->_hidden,
					$this->_name,
					$this->_type
				)
			);
			return true;
		} catch (Exception $e) {
			die('Error : '.$e->getMessage());
		}
	}
	public function create() {
		if ($this->load($this->_type, $this->_name)) return false;
		try {
			$sql = "INSERT INTO ".Config::read('db.table')."(name, type, groupe, password, hidden) VALUES(?, ?, ?, ?, ?)";
			$core = Core::getInstance();
			$addCard = $core->db->prepare($sql);
			$addCard->execute(
				array(
					$this->_name,
					$this->_type,
					$this->_group,
					$this->_password,
					$this->_hidden
				)
			);
		} catch (Exception $e) {
			die('Error : '.$e->getMessage());
		}
		return true;
	}
}
?>
