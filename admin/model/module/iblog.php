<?php 
class ModelModuleiBlog extends Model {
	private function check_tables() {
		$install = false;

		$tables = array(
			'iblog_post' => array(
				'id' => 'int(11) NOT NULL auto_increment',
				'slug' => 'varchar(255) character set utf8 NOT NULL',
				'author_id' => 'int(11) NOT NULL',
				'image' => 'varchar(255) character set utf8 NOT NULL',
				'category_id' => 'int(11) NOT NULL',
				'is_published' => 'tinyint(1) NOT NULL',
				'is_featured' => 'tinyint(1) NOT NULL',
				'modified' => 'datetime NOT NULL',
				'created' => 'datetime NOT NULL',
				'store_id' => 'int(11) NOT NULL DEFAULT 0',
			),
			'iblog_post_description' => array(
				'id' => 'int(11) NOT NULL auto_increment',
				'iblog_post_id' => 'int(11) NOT NULL',
				'language_id' => 'int(11) NOT NULL',
				'title' => 'varchar(255) character set utf8 NOT NULL',
				'excerpt' => 'text character set utf8 NOT NULL',
				'body' => 'longtext character set utf8 NOT NULL',
				'meta_description' => 'text NOT NULL',
				'meta_keywords' => 'text NOT NULL',
			),
			'iblog_category' => array(
				'id' => 'int(11) NOT NULL auto_increment',
				'parent_id' => 'int(11) NOT NULL',
				'slug' => 'varchar(255) character set utf8 NOT NULL',
				'image' => 'varchar(255) character set utf8 NOT NULL',
				'modified' => 'datetime NOT NULL',
				'created' => 'datetime NOT NULL',
				'store_id' => 'int(11) NOT NULL DEFAULT 0',
			),
			'iblog_category_description' => array(
				'id' => 'int(11) NOT NULL auto_increment',
				'iblog_category_id' => 'int(11) NOT NULL',
				'language_id' => 'int(11) NOT NULL',
				'title' => 'varchar(255) character set utf8 NOT NULL',
				'description' => 'text NOT NULL',
				'meta_description' => 'text NOT NULL',
				'meta_keywords' => 'text NOT NULL',
			),
		);

		foreach ($tables as $table => $table_cols) {
			$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . $table . "'");

			if (empty($query->rows)) {
				$install = true;
			} else {
				foreach ($table_cols as $table_col => $table_col_type) {
					$table_col_query = $this->db->query("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . DB_PREFIX . $table . "' AND COLUMN_NAME = '" . $table_col . "'");
					
					if (empty($table_col_query) || !$table_col_query->num_rows) {
						$this->db->query("ALTER TABLE " . DB_PREFIX . $table ." ADD " . $table_col . " " . $table_col_type);
					}
				}
			}
		}

		if ($install) {
			$this->install();
		}

		return true;
	}

	public function getSetting($group, $store_id = 0) {
		$data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
		
		foreach ($query->rows as $result) {
			if (!$result['serialized']) {
				$data[$result['key']] = $result['value'];
			} else {
				$data[$result['key']] = unserialize($result['value']);
			}
		}

		return $data;
	}

	public function editSetting($group, $data, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
		
		foreach ($data as $key => $value) {
			if (!is_array($value)) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET 
					`store_id` = '" . (int)$store_id . "', 
					`group` = '" . $this->db->escape($group) . "', 
					`key` = '" . $this->db->escape($key) . "', 
					`value` = '" . $this->db->escape($value) . "'");
			} else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET 
					`store_id` = '" . (int)$store_id . "', 
					`group` = '" . $this->db->escape($group) . "', 
					`key` = '" . $this->db->escape($key) . "', 
					`value` = '" . $this->db->escape(serialize($value)) . "', 
					`serialized` = '1'");
			}
		}
	}
	
	public function deleteSetting($group, $store_id = 0) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE store_id = '" . (int)$store_id . "' AND `group` = '" . $this->db->escape($group) . "'");
	}
	
	public function install() {
		$queries = array(
			"CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "iblog_post` (
				`id` int(11) NOT NULL auto_increment,
				`slug` varchar(255) character set utf8 NOT NULL,
				`author_id` int(11) NOT NULL,
				`image` varchar(255) character set utf8 NOT NULL,
				`category_id` int(11) NOT NULL,
				`is_published` tinyint(1) NOT NULL,
				`is_featured` tinyint(1) NOT NULL,
				`modified` datetime NOT NULL,
				`created` datetime NOT NULL,
				`store_id` int(11) NOT NULL DEFAULT 0,
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "iblog_post_description` (
				`id` int(11) NOT NULL auto_increment,
				`iblog_post_id` int(11) NOT NULL,
				`language_id` int(11) NOT NULL,
				`title` varchar(255) character set utf8 NOT NULL,
				`excerpt` text character set utf8 NOT NULL,
				`body` longtext character set utf8 NOT NULL,
				`meta_description` text NOT NULL,
				`meta_keywords` text NOT NULL,
			PRIMARY KEY  (`id`),
			KEY `select` (`iblog_post_id`,`language_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",

			"CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "iblog_category` (
				`id` int(11) NOT NULL auto_increment,
				`parent_id` int(11) NOT NULL,
				`slug` varchar(255) character set utf8 NOT NULL,
				`image` varchar(255) character set utf8 NOT NULL,
				`modified` datetime NOT NULL,
				`created` datetime NOT NULL,
				`store_id` int(11) NOT NULL DEFAULT 0,
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "iblog_category_description` (
				`id` int(11) NOT NULL auto_increment,
				`iblog_category_id` int(11) NOT NULL,
				`language_id` int(11) NOT NULL,
				`title` varchar(255) character set utf8 NOT NULL,
				`description` text NOT NULL,
				`meta_description` text NOT NULL,
				`meta_keywords` text NOT NULL,
			PRIMARY KEY  (`id`),
			KEY `select` (`iblog_category_id`,`language_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8",
		);

		foreach ($queries as $query) {
			$this->db->query($query);
		}
	}

	public function uninstall() {
		$queries = array(
			"DROP TABLE IF EXISTS `" . DB_PREFIX . "iblog_post`;",
			"DROP TABLE IF EXISTS `" . DB_PREFIX . "iblog_post_description`;",
			"DROP TABLE IF EXISTS `" . DB_PREFIX . "iblog_category`;",
			"DROP TABLE IF EXISTS `" . DB_PREFIX . "iblog_category_description`;"
		);

		foreach ($queries as $query) {
			$this->db->query($query);
		}
	}

	// 
	// Blog Posts
	// 

	public function getTotalPosts($store_id = 0) {
		$this->check_tables();

			$sql = "SELECT COUNT(DISTINCT p.id) AS total FROM " . DB_PREFIX . "iblog_post p LEFT JOIN " . DB_PREFIX . "iblog_post_description pd ON (p.id = pd.iblog_post_id)";

			$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.store_id = '" . (int)$store_id . "'";

			$query = $this->db->query($sql);

			return $query->row['total'];
	}

	public function viewPosts($page = 1, $limit = 8, $store_id = 0, $sort = "p.id", $order = "DESC") {
		$this->check_tables();

			if ($page) {
				$start = ($page - 1) * $limit;
			}

			$sql = "SELECT *, (SELECT CONCAT_WS(' ', u.firstname, u.lastname) FROM " . DB_PREFIX . "user u WHERE p.author_id = u.user_id) as author FROM " . DB_PREFIX . "iblog_post p LEFT JOIN " . DB_PREFIX . "iblog_post_description pd ON (p.id = pd.iblog_post_id)";
			$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.store_id = '" . (int)$store_id . "'"; 
			$sql .= " GROUP BY p.id";

			$sort_data = array(
				'pd.title',
				'pd.excerpt',
				'author',
				'p.created',
				'p.is_published'
			);

			if (isset($sort)) {
				$sql .= " ORDER BY " . $sort;	
			}

			if (isset($order)) {
				$sql .= " " . $order;
			}

			if (isset($start) || isset($limit)) {
				$sql .= " LIMIT " . $start . ", " . $limit;
			}	

			$query = $this->db->query($sql);

			return $query->rows;
	}

	public function addPost($data) {
		$this->check_tables();

		$this->db->query("INSERT INTO " . DB_PREFIX . "iblog_post SET 
			`slug` = '" . $this->db->escape($data['slug']) . "',
			`author_id` = '" . $this->db->escape($data['author_id']) . "',
			`category_id` = '" . (int)$data['category_id'] . "',
			`is_published` = '" . $this->db->escape($data['is_published']) . "',
			`is_featured` = '" . !empty($data['featured']) . "',
			`modified` = NOW(),
			`created` = '" . $data['date_published'] . "',
			`store_id` = '" . $this->db->escape($data['store_id']) . "'");

		$post_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "iblog_post SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$post_id . "'");
		}

		foreach ($data['post_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "iblog_post_description SET 
				`iblog_post_id` = '" . (int)$post_id . "',
				`language_id` = '" . (int)$language_id . "',
				`title` = '" . $this->db->escape($value['title']) . "',
				`excerpt` = '" . $this->db->escape($value['excerpt']) . "',
				`body` = '" . $this->db->escape($value['body']) . "',
				`meta_keywords` = '" . $this->db->escape($value['meta_keyword']) . "',
				`meta_description` = '" . $this->db->escape($value['meta_description']) . "'");
		}
	}

	public function deletePost($post_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "iblog_post WHERE id = '" . (int)$post_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "iblog_post_description WHERE iblog_post_id = '" . (int)$post_id . "'");
	}

	public function getPost($post_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "iblog_post p LEFT JOIN " . DB_PREFIX . "iblog_post_description pd ON (p.id = pd.iblog_post_id) WHERE pd.iblog_post_id = '" . (int)$post_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getPostDescriptions($post_id) {
		$this->check_tables();

		$post_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "iblog_post_description WHERE iblog_post_id = '" . (int)$post_id . "'");

		foreach ($query->rows as $result) {
			$post_description_data[$result['language_id']] = array(
				'title'             => $result['title'],
				'body'     			=> $result['body'],
				'meta_keyword'     	=> $result['meta_keywords'],
				'meta_description' 	=> $result['meta_description'],
				'excerpt'           => $result['excerpt']
			);
		}

		return $post_description_data;
	}

	public function editPost($post_id, $data) {
		$this->check_tables();

		$this->db->query("UPDATE " . DB_PREFIX . "iblog_post SET 
			`slug` = '" . $this->db->escape($data['slug']) . "', 
			`author_id` = '" . $this->db->escape($data['author_id']) . "', 
			`category_id` = '" . (int)$data['category_id'] . "', 
			`is_published` = '" . $this->db->escape($data['is_published']) . "', 
			`is_featured` = '" . !empty($data['featured']) . "', 
			`modified` = NOW(),
			`created` = '" . $data['date_published'] . "' WHERE id = '" . (int)$post_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "iblog_post SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$post_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "iblog_post_description WHERE iblog_post_id = '" . (int)$post_id . "'");

		foreach ($data['post_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "iblog_post_description SET 
				`iblog_post_id` = '" . (int)$post_id . "', 
				`language_id` = '" . (int)$language_id . "', 
				`title` = '" . $this->db->escape($value['title']) . "', 
				`excerpt` = '" . $this->db->escape($value['excerpt']) . "', 
				`body` = '" . $this->db->escape($value['body']) . "', 
				`meta_keywords` = '" . $this->db->escape($value['meta_keyword']) . "', 
				`meta_description` = '" . $this->db->escape($value['meta_description']) . "'");
		}
	}

	// 
	// Blog Categories
	// 

	public function getCategories($store_id = 0, $options = array()) {
		$this->check_tables();

		$sql = "SELECT * FROM " . DB_PREFIX . "iblog_category c LEFT JOIN " . DB_PREFIX . "iblog_category_description cd ON (c.id = cd.iblog_category_id)";

		$sql .= " WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.store_id = '" . (int)$store_id . "'";

		if (!empty($options['exclude']) && is_array($options['exclude'])) {
			$sql .= " AND c.id NOT IN (" . implode(',', $options['exclude']) . ")";
		}

		if (isset($options['parent_id'])) {
			$sql .= " AND c.parent_id = " . $options['parent_id'];
		}

		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getTotalCategories($store_id = 0) {
		$this->check_tables();

		$sql = "SELECT COUNT(DISTINCT c.id) AS total FROM " . DB_PREFIX . "iblog_category c LEFT JOIN " . DB_PREFIX . "iblog_category_description cd ON (c.id = cd.iblog_category_id)";

		$sql .= " WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.store_id = '" . (int)$store_id . "'";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function viewCategories($page = 1, $limit = 8, $store_id = 0, $sort = "c.id", $order = "DESC") {
		$this->check_tables();

		if ($page) {
			$start = ($page - 1) * $limit;
		}

		$sql = "SELECT * FROM " . DB_PREFIX . "iblog_category c LEFT JOIN " . DB_PREFIX . "iblog_category_description cd ON (c.id = cd.iblog_category_id)";
		$sql .= " WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.store_id = '" . (int)$store_id . "'"; 
		$sql .= " GROUP BY c.id";

		$sort_data = array(
			'cd.title',
			'c.created'
		);

		if (isset($sort)) {
			$sql .= " ORDER BY " . $sort;	
		}

		if (isset($order)) {
			$sql .= " " . $order;
		}

		if (isset($start) || isset($limit)) {
			$sql .= " LIMIT " . $start . ", " . $limit;
		}	

		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function addCategory($data) {
		$this->check_tables();

		$this->db->query("INSERT INTO " . DB_PREFIX . "iblog_category SET 
			`parent_id` = '" . (int)$data['parent_id'] . "', 
			`slug` = '" . $this->db->escape($data['slug']) . "', 
			`modified` = NOW(), created = '" . $data['date_published'] . "', 
			`store_id` = '" . $this->db->escape($data['store_id']) . "'");

		$category_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "iblog_category SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$category_id . "'");
		}

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "iblog_category_description SET 
				`iblog_category_id` = '" . (int)$category_id . "', 
				`language_id` = '" . (int)$language_id . "', 
				`title` = '" . $this->db->escape($value['title']) . "', 
				`description` = '" . $this->db->escape($value['description']) . "', 
				`meta_keywords` = '" . $this->db->escape($value['meta_keyword']) . "', 
				`meta_description` = '" . $this->db->escape($value['meta_description']) . "'");
		}
	}

	public function deleteCategory($category_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "iblog_category WHERE id = '" . (int)$category_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "iblog_category_description WHERE iblog_category_id = '" . (int)$category_id . "'");
	}

	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "iblog_category p LEFT JOIN " . DB_PREFIX . "iblog_category_description pd ON (p.id = pd.iblog_category_id) WHERE pd.iblog_category_id = '" . (int)$category_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getCategoryDescriptions($category_id) {
		$this->check_tables();

		$category_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "iblog_category_description WHERE iblog_category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'title'             => $result['title'],
				'description'     	=> $result['description'],
				'meta_keyword'     	=> $result['meta_keywords'],
				'meta_description' 	=> $result['meta_description']
			);
		}

		return $category_description_data;
	}

	public function editCategory($category_id, $data) {
		$this->check_tables();

		$this->db->query("UPDATE " . DB_PREFIX . "iblog_category SET 
			`parent_id` = '" . (int)$data['parent_id'] . "', 
			`slug` = '" . $this->db->escape($data['slug']) . "', 
			`modified` = NOW(), created = '" . $data['date_published'] . "', 
			`store_id` = '" . $this->db->escape($data['store_id']) . "' WHERE id = '" . (int)$category_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "iblog_category SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$category_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "iblog_category_description WHERE iblog_category_id = '" . (int)$category_id . "'");

		foreach ($data['category_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "iblog_category_description SET 
				`iblog_category_id` = '" . (int)$category_id . "',
				`language_id` = '" . (int)$language_id . "',
				`title` = '" . $this->db->escape($value['title']) . "',
				`description` = '" . $this->db->escape($value['description']) . "',
				`meta_keywords` = '" . $this->db->escape($value['meta_keyword']) . "',
				`meta_description` = '" . $this->db->escape($value['meta_description']) . "'");
		}
	}

	// 
	// Misc
	//
	public function url_slug($str, $options = array()) {
		$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

		$defaults = array(
			'delimiter' 		=> '-',
			'limit' 			=> null,
			'lowercase' 		=> true,
			'replacements' 		=> array(),
			'transliterate' 	=> false
		);

		$options = array_merge($defaults, $options);

		$char_map = array( 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 'ß' => 'ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 'ÿ' => 'y', '©' => '(c)', 'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8', 'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P', 'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W', 'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I', 'Ϋ' => 'Y', 'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8', 'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p', 'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w', 'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's', 'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i', 'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G', 'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya', 'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G', 'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g', 'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 'Ž' => 'Z', 'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u', 'ž' => 'z', 'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 'Ż' => 'Z', 'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z', 'ż' => 'z', 'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z', 'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n', 'š' => 's', 'ū' => 'u', 'ž' => 'z' );

		$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

		if ($options['transliterate']) {
			$str = str_replace(array_keys($char_map), $char_map, $str);
		}

		$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
		$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
		$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

		$str = trim($str, $options['delimiter']);

		return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
	}

	public function is_installed() {
		$iblog_table = array('iblog_post');
				
		foreach ($iblog_table as $table) {
			$table_exists = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . $table . "'");
			
			if (empty($table_exists->num_rows)) {
				return false;
			}
		}

		return true;
	}
}
?>