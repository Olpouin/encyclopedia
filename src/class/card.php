<?php
use \EditorJS\EditorJS;

class Card {
	private $db;
	private $_password;
	private $_name;
	private $_type;
	private $_group;
	private $_text;
	private $_hidden;

	private $formatArray = array(
		'/\[ibd\](.*)\|(.*)\[\/ibd\]/Ums' => '<div class="infobox-data"><span class="infobox-data-title">$1</span><span>$2</span></div>',
		'/\[h1\](.*)\[\/h1\]/Ums' => '<h1>$1</h1>',
		'/\[h2\](.*)\[\/h2\]/Ums' => '<h2>$1</h2>',
		'/\!\[(.*)\]\((.*)\)/Um' => '<img src="$2" onclick="fullscreen(event)" alt="$1">',
		'/\[ib\](.*)\[\/ib\]/Ums' => '<aside>$1</aside>'
	);
	private function format($txt) {
		foreach ($this->formatArray as $key => $value) {
			$txt = preg_replace($key, $value, $txt);
		}
		return $txt;
	}

	public function group() {
		return $this->_group;
	}
	public function text($type='default') {
		switch ($type) { //
			case 'html':
				try {
					$editor = new EditorJS($this->_text, Config::read('gene.editorconfig'));
					$ARRAYtext = $editor->getBlocks();
				} catch (\EditorJSException $e) {
					$ARRAYtext = [["type"=>"paragraph","data"=>["text"=>"Erreur EditorJS lors de la transformation du JSON en HTML : ".$e]]];
				}

				$text = "";
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
							$text .= "<h{$data['level']} id=\"{$data['text']}\">{$data['text']}</h{$data['level']}>";
							break;
						case 'paragraph':
							$text .= "<p>{$this->format($data['text'])}</p>";
							break;
						case 'quote':
							$text .= "<blockquote><span>{$data['text']}</span><cite>{$data['caption']}</cite></blockquote>";
							break;
						case 'image':
							$class = "";
							if ($data['stretched']) $class .= "stretch ";
							$text .= "<img class=\"{$class}\" src=\"{$data['url']}\" onclick=\"fullscreen(event)\" alt=\"{$data['caption']}\">";
							break;
						case 'table':
							$text .= "<table>";
							foreach ($data['content'] as $line => $lineData) {
								$text .= "<tr>";
								foreach ($data['content'][$line] as $column => $columnData) {
									$text .= "<th>{$columnData}";
								}
								$text .= "</tr>";
							}
							$text .= "</table>";
							break;
						case 'list':
							$text .= ($data['style'] == 'unordered') ? "<ul>" : "<ol>";
							foreach ($data['items'] as $listText) {
								$text .= "<li>{$listText}</li>";
							}
							$text .= ($data['style'] == 'unordered') ? "</ul>" : "</ol>";
							break;
					}
				}
				return $text;
				break;
			default:
				if (empty($this->_text) OR strlen($this->_text) < 22) return '{"time":0,"blocks":[]}';
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
		if (is_array($text)) $realText = json_encode($text);
		else $realText = $text;

		if (strlen($realText) > 10000000 OR strlen($realText) < 0) return false;

		$this->_text = $realText;
		return true;
	}

	public function load($type='', $name='') {
		try {
			$core = Core::getInstance();
			$cardR = $core->db->prepare("SELECT * FROM ".Config::read('db.table')." WHERE type = ? AND name = ?");
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
					html_entity_decode(preg_replace('/\\\\u([\da-fA-F]{4})/', '&#x\1;', $this->_text)),
					$this->_group,
					$this->_hidden,
					$this->_name,
					$this->_type
				)
			);
			if ($this->_type != "[SERVERDATA]") {
				logging(
					'Fiche modifiée',
					"**Nom :** ".$this->_name.
					"\n**Type :** ".$this->_type." (".Config::read('gene.types')[$this->_type].")",
					["color"=>"16312092","url"=>"https://".$_SERVER['HTTP_HOST'].Config::read('gene.path')."/".$this->_type."/".urlencode($this->_name)."/"]
				);
			} else {
				logging(
					'Page d\'accueil modifiée',
					"La page d'accueil du site a été modifiée.",
					["url"=>"https://".$_SERVER['HTTP_HOST'].Config::read('gene.path')]
				);
			}
			return true;
		} catch (Exception $e) {
			die('Error : '.$e->getMessage());
		}
	}
	public function create() {
		if ($this->load($this->_type, $this->_name)) return false;
		try {
			$sql = "INSERT INTO ".Config::read('db.table')."(name, type, groupe, text, password, hidden) VALUES(?, ?, ?, ?, ?, ?)";
			$core = Core::getInstance();
			$addCard = $core->db->prepare($sql);
			$addCard->execute(
				array(
					$this->_name,
					$this->_type,
					$this->_group,
					'{"time":0,"blocks":[]}',
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
