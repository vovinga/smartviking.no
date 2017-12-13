<?php
class ModelModuleiBlog extends Model {
	public function getSetting($group, $store_id) {
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
	
	// 
	// Blog Posts
	//

	public function getFeaturedPost() {
		$query = $this->db->query("SELECT DISTINCT *, pd.title AS title, pd.body as body, (SELECT CONCAT_WS(' ', u.firstname, u.lastname) FROM " . DB_PREFIX . "user u WHERE p.author_id = u.user_id) as author FROM " . DB_PREFIX . "iblog_post p LEFT JOIN " . DB_PREFIX . "iblog_post_description pd ON (p.id = pd.iblog_post_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.is_published = '1' AND p.is_featured = '1' AND p.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p.created < NOW() ORDER BY created DESC LIMIT 0,1");
		
		if ($query->num_rows) {
			return array(
				'post_id'       	=> $query->row['iblog_post_id'],
				'title'             => $query->row['title'],
				'body'      		=> $query->row['body'],
				'excerpt'			=> $query->row['excerpt'],
				'meta_description'	=> $query->row['meta_description'],
				'meta_keyword'		=> $query->row['meta_keywords'],
				'image'				=> $query->row['image'],
				'category_id'		=> $query->row['category_id'],
				'is_published'		=> $query->row['is_published'],
				'author'			=> $query->row['author'],
				'created'			=> $query->row['created'],
				'featured'			=> $query->row['is_featured'],
				'href'				=> $this->url->link('module/iblog/post', 'post_id=' . $query->row['iblog_post_id'])
			);
		} else {
			return false;
		}	
	}
	
	public function getPosts($data = array()) {
		$sql = "SELECT *, (SELECT CONCAT_WS(' ', u.firstname, u.lastname) FROM " . DB_PREFIX . "user u WHERE p.author_id = u.user_id) as author FROM " . DB_PREFIX . "iblog_post p LEFT JOIN " . DB_PREFIX . "iblog_post_description pd ON (p.id = pd.iblog_post_id)";
		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.is_published = '1' AND p.store_id = '" . (int)$this->config->get('config_store_id') . "'"; 
		
		// Exclude future posts
		$sql .= " AND p.created < NOW() ";

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.title LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.body LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}
			$sql .= ")";
		}		
			
		if (!empty($data['filter_category_id'])) {
			$sql .= " AND p.category_id = " . (int)$data['filter_category_id'];
		}

		// Sorting
		$sql .= " GROUP BY p.id";
					
		$sort_data = array(
			'pd.title',
			'pd.excerpt',
			'author',
			'p.created',
			'p.is_published'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
		} else {
			$sql .= " ORDER BY p.is_featured DESC, p.created DESC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getPost($post_id = 0) {	
		$query = $this->db->query("SELECT DISTINCT *, pd.title AS title, pd.body as body, (SELECT CONCAT_WS(' ', u.firstname, u.lastname) FROM " . DB_PREFIX . "user u WHERE p.author_id = u.user_id) as author FROM " . DB_PREFIX . "iblog_post p LEFT JOIN " . DB_PREFIX . "iblog_post_description pd ON (p.id = pd.iblog_post_id) WHERE p.id = '" . (int)$post_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.is_published = '1' AND p.created < NOW() AND p.store_id='" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return array(
				'post_id'       	=> $query->row['iblog_post_id'],
				'title'             => $query->row['title'],
				'body'      		=> $query->row['body'],
				'meta_description'	=> $query->row['meta_description'],
				'meta_keyword'		=> $query->row['meta_keywords'],
				'image'				=> $query->row['image'],
				'category_id'		=> $query->row['category_id'],
				'is_published'		=> $query->row['is_published'],
				'author'			=> $query->row['author'],
				'created'			=> $query->row['created'],
				'featured'			=> $query->row['is_featured']
			);
		} else {
			return false;
		}
	}
	
	public function getTotalPosts($store_id = 0, $data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.id) AS total FROM " . DB_PREFIX . "iblog_post p LEFT JOIN " . DB_PREFIX . "iblog_post_description pd ON (p.id = pd.iblog_post_id)";
		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.store_id = '" . (int)$store_id . "' AND p.created < NOW()";

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.title LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.body LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}
			$sql .= ")";
		}
		
		if (!empty($data['filter_category_id'])) {
			$sql .= " AND p.category_id = " . (int)$data['filter_category_id'];
		}
		
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	// 
	// Blog Categories
	//

	public function getCategories($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "iblog_category c LEFT JOIN " . DB_PREFIX . "iblog_category_description cd ON (c.id = cd.iblog_category_id)";
		$sql .= " WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.store_id = '" . (int)$this->config->get('config_store_id') . "'"; 
		
		if (isset($data['parent_id'])) {
			$sql .= " AND c.parent_id = '" . (int)$data['parent_id'] . "'";
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "cd.title LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR cd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}
			$sql .= ")";
		}
		
		$sql .= " GROUP BY c.id";
					
		$sort_data = array(
			'cd.title',
			'cd.excerpt',
			'c.created'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
		} else {
			$sql .= " ORDER BY c.created DESC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}

	public function getTotalCategories($store_id = 0) {
		$sql = "SELECT COUNT(DISTINCT c.id) AS total FROM " . DB_PREFIX . "iblog_category c LEFT JOIN " . DB_PREFIX . "iblog_category_description cd ON (c.id = cd.iblog_category_id)";

		$sql .= " WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.store_id = '" . (int)$store_id . "'";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getCategory($category_id = 0) {	
		$query = $this->db->query("SELECT DISTINCT *, cd.title AS title, cd.description as description FROM " . DB_PREFIX . "iblog_category c LEFT JOIN " . DB_PREFIX . "iblog_category_description cd ON (c.id = cd.iblog_category_id) WHERE c.id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.store_id='" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return array(
				'iblog_category_id'	=> $query->row['iblog_category_id'],
				'title'             => $query->row['title'],
				'description'      	=> $query->row['description'],
				'meta_description'	=> $query->row['meta_description'],
				'meta_keyword'		=> $query->row['meta_keywords'],
				'image'				=> $query->row['image'],
				'created'			=> $query->row['created']
			);
		} else {
			return false;
		}
	}

	// 
	// OpenGraph
	// 
	
	public function getOgData() {
		// Exclude for non-iBlog URLs
		if (empty($this->request->get['route']) || (!empty($this->request->get['route']) && strpos($this->request->get['route'], 'iblog') === FALSE)) {
			return false;
		}

		$this->load->model('tool/image');

		$store_id = (int)$this->config->get('config_store_id');
		$language_id = (int)$this->config->get('config_language_id');

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$iBlogSetting = $this->getSetting('iBlog', $this->config->get('config_store_id'));
		$iBlogSetting = $iBlogSetting['iBlog'];

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$logo = str_replace(' ', '%20', $this->model_tool_image->resize($this->config->get('config_logo'), 200, 200));
		} else {
			$logo = '';
		}

		$get_parameters = '';

		foreach ($this->request->get as $get_param => $get_param_value) {

			if (strpos($get_param, 'post') !== FALSE || strpos($get_param, 'iblog') !== FALSE) {
				if (!empty($get_parameters)) {
					$get_parameters .= '&';
				}

				$get_parameters .= $get_param . '=' . $get_param_value;
			}
		}

		$og = array(
			'url' 			=> str_replace(' ', '%20', $this->url->link($this->request->get['route'], $get_parameters)),
			'title' 		=> !empty($iBlogSetting['PageTitle'][$language_id]) ? $iBlogSetting['PageTitle'][$language_id] : '',
			'image' 		=> str_replace(' ', '%20', $logo),
			'site_name' 	=> $this->config->get('config_title'),
			'description' 	=> !empty($iBlogSetting['MetaDescription'][$language_id]) ? $iBlogSetting['MetaDescription'][$language_id] : ''
		);

		// 
		// Blog Category
		// 

		if (isset($this->request->get['iblog_category_id'])) {
			$category_info = $this->getCategory($this->request->get['iblog_category_id']);

			if (!empty($category_info['title'])) {
				$og['title'] = $category_info['title'];
			}

			if (!empty($category_info['description'])) {
				$og['description'] = strip_tags(html_entity_decode($category_info['description']), '');
			}

			if (!empty($category_info['image']) && file_exists(DIR_IMAGE . $category_info['image'])) {
				$og['image'] = str_replace(' ', '%20', $this->model_tool_image->resize($category_info['image'], 200, 200));
			}
		}

		// 
		// Blog Post
		//
		
		if (isset($this->request->get['post_id'])) {
			$post_info = $this->getPost($this->request->get['post_id']);

			if (!empty($post_info['title'])) {
				$og['title'] = $post_info['title'];
			}

			if (!empty($post_info['body'])) {
				$og['description'] = strip_tags(html_entity_decode($post_info['body']), '');
			}

			if (!empty($post_info['image']) && file_exists(DIR_IMAGE . $post_info['image'])) {
				$og['image'] = str_replace(' ', '%20', $this->model_tool_image->resize($post_info['image'], 200, 200));
			}
		}

		return $og;
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