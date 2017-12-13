<?php
class ControllerModuleiBlog extends Controller {
	private $moduleName = 'iBlog';
	private $moduleNameSmall = 'iblog';
	private $moduleData_module = 'iblog_module';
	private $moduleModel = 'model_module_iblog';
	public $version = '1.5.3';

	public function index() { 
		$this->data['moduleName'] = $this->moduleName;
		$this->data['moduleNameSmall'] = $this->moduleNameSmall;
		$this->data['moduleData_module'] = $this->moduleData_module;
		$this->data['moduleModel'] = $this->moduleModel;

		$this->load->language('module/' . $this->moduleNameSmall);

		$this->load->model('module/' . $this->moduleNameSmall);
		$this->load->model('setting/store');
		$this->load->model('localisation/language');
		$this->load->model('design/layout');

		$catalogURL = $this->getCatalogURL();

		$this->document->addScript('view/javascript/jquery/ui/jquery-ui-timepicker-addon.js');
		$this->document->addScript('view/javascript/ckeditor/ckeditor.js'); 
		$this->document->addScript('view/javascript/' . $this->moduleNameSmall . '/bootstrap/js/bootstrap.min.js');
		$this->document->addStyle('view/javascript/' . $this->moduleNameSmall . '/bootstrap/css/bootstrap.min.css');
		$this->document->addStyle('view/stylesheet/' . $this->moduleNameSmall . '/font-awesome/css/font-awesome.min.css');
	

		$this->document->addStyle('view/stylesheet/' . $this->moduleNameSmall . '/' . $this->moduleNameSmall . '.css');
		$this->document->addScript('view/javascript/' . $this->moduleNameSmall . '/' . $this->moduleNameSmall . '.js');
		$this->document->addScript('view/javascript/jquery/ui/jquery-ui-timepicker-addon.js');

		$this->document->setTitle($this->language->get('heading_title').' '.$this->version);

		if (!isset($this->request->get['store_id'])) {
			$this->request->get['store_id'] = 0; 
		}

		$store = $this->getCurrentStore($this->request->get['store_id']);

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			if (!$this->user->hasPermission('modify', 'module/' . $this->moduleNameSmall)) {
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}

			if (!empty($_POST['OaXRyb1BhY2sgLSBDb21'])) {
				$this->request->post[$this->moduleName]['LicensedOn'] = $_POST['OaXRyb1BhY2sgLSBDb21'];
			}

			if (!empty($_POST['cHRpbWl6YXRpb24ef4fe'])) {
				$this->request->post[$this->moduleName]['License'] = json_decode(base64_decode($_POST['cHRpbWl6YXRpb24ef4fe']), true);
			}
			if (!isset($this->request->post[$this->moduleData_module])) {
				$this->request->post[$this->moduleData_module] = array();
			}

			$this->{$this->moduleModel}->editSetting($this->moduleData_module, $this->request->post[$this->moduleData_module], $this->request->post['store_id']);
			$this->{$this->moduleModel}->editSetting($this->moduleNameSmall, $this->request->post, $this->request->post['store_id']);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('module/' . $this->moduleNameSmall, 'store_id=' . $this->request->post['store_id'] . '&token=' . $this->session->data['token'], 'SSL'));
		}

		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}

		$this->data['breadcrumbs']   = array();
		
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
		);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
		);
		
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/' . $this->moduleNameSmall, 'token=' . $this->session->data['token'], 'SSL'),
		);

		$languageVariables = array(
			'error_permission',
			'text_success',
			'text_enabled',
			'text_disabled',
			'button_cancel',
			'save_changes',
			'text_default',
			'text_module',
			'entry_code',
			'entry_code_help',
			'text_content_top', 
			'text_content_bottom',
			'text_column_left', 
			'text_column_right',
			'entry_layout',         
			'entry_position',       
			'entry_status',         
			'entry_sort_order',     
			'entry_layout_options',  
			'entry_position_options',
			'entry_action_options',
			'button_add_module',
			'button_remove'
		);

		foreach ($languageVariables as $languageVariable) {
			$this->data[$languageVariable] = $this->language->get($languageVariable);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title').' '.$this->version;

		$this->data['stores']				  = array_merge(array(0 => array('store_id' => '0', 'name' => $this->config->get('config_name') . ' (' . $this->data['text_default'] . ')', 'url' => HTTP_SERVER, 'ssl' => HTTPS_SERVER)), $this->model_setting_store->getStores());
		$this->data['error_warning']          = '';  
		$this->data['languages']              = $this->model_localisation_language->getLanguages();
		$this->data['store']                  = $store;
		$this->data['token']                  = $this->session->data['token'];
		$this->data['action']                 = $this->url->link('module/' . $this->moduleNameSmall, 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel']                 = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['data']                   = $this->{$this->moduleModel}->getSetting($this->moduleNameSmall, $store['store_id']);
		$this->data['modules']				  = $this->{$this->data['moduleModel']}->getSetting($this->moduleData_module, $store['store_id']);
		$this->data['layouts']                = $this->model_design_layout->getLayouts();
		$this->data['catalog_url']			  = $catalogURL;

		if (isset($this->data['data'][$this->moduleName])) {
			$this->data['moduleData'] = $this->data['data'][$this->moduleName];
		} else {
			$this->data['moduleData'] = array();	
		}

		$this->template = 'module/' . $this->moduleNameSmall . '.tpl';
		$this->children = array('common/header', 'common/footer');
		$this->response->setOutput($this->render());
	}

	public function install() {
		$this->load->model('module/' . $this->moduleNameSmall);
		$this->{$this->moduleModel}->install();
	}

	public function uninstall() {
		$this->load->model('module/' . $this->moduleNameSmall);
		$this->load->model('setting/store');
		$this->load->model('localisation/language');
		$this->load->model('design/layout');

		$this->model_setting_setting->deleteSetting($this->moduleData_module,0);
		$stores=$this->model_setting_store->getStores();
		foreach ($stores as $store) {
			$this->model_setting_setting->deleteSetting($this->moduleData_module, $store['store_id']);
		}
		$this->load->model('module/' . $this->moduleNameSmall);
		$this->{$this->moduleModel}->uninstall();
	}


	private function getCatalogURL($store_id = 0) {
		$this->load->model('setting/store');

		if (!empty($store_id)) {
			$store = $this->model_setting_store->getStore($store_id);
		} else if (!empty($this->request->get['store_id'])) {
			$store = $this->model_setting_store->getStore($this->request->get['store_id']);
		}

		if (!empty($store)) {
			$http_catalog = $store['url'];
			$https_catalog = $store['ssl'];
		} else {
			$http_catalog = HTTP_CATALOG;
			$https_catalog = HTTPS_CATALOG;
		}

		if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
			$storeURL = $https_catalog;
		} else {
			$storeURL = $http_catalog;
		}
		
		return $storeURL;
	}

	private function getServerURL() {
		if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
			$storeURL = HTTPS_SERVER;
		} else {
			$storeURL = HTTP_SERVER;
		} 
		
		return $storeURL;
	}

	private function getCurrentStore($store_id) {
		$this->load->model('setting/store');

		if ($store_id && $store_id != 0) {
			$store = $this->model_setting_store->getStore($store_id);
		} else {
			$store['store_id'] = 0;
			$store['name'] = $this->config->get('config_name');
			$store['url'] = $this->getCatalogURL(); 
		}
		
		return $store;
	}

	// 
	// Blog Posts
	// 

	public function getPosts() {
		$this->data['moduleName'] = $this->moduleName;
		$this->data['moduleNameSmall'] = $this->moduleNameSmall;
		$this->data['moduleData_module'] = $this->moduleData_module;
		$this->data['moduleModel'] = $this->moduleModel;

		if (!empty($this->request->get['page'])) {
			$page = (int) $this->request->get['page'];
		} else {
			$page = 0;
		}

		if (!isset($this->request->get['store_id'])) {
			$this->request->get['store_id'] = 0;
		}

		$this->load->model('module/' . $this->moduleNameSmall);

		$pagination					= new Pagination();
		$pagination->num_links		= 2;
		$pagination->limit			= 10;
		$pagination->total			= $this->{$this->moduleModel}->getTotalPosts($this->request->get['store_id']);
		$pagination->page			= $page;
		$pagination->text			= $this->language->get('text_pagination');
		$pagination->url			= $this->url->link('module/' . $this->moduleNameSmall . '/getPosts','token=' . $this->session->data['token'] . '&page={page}&store_id=' . $this->request->get['store_id'], 'SSL');
		$this->data['pagination']	= $pagination->render();

		$this->data['posts']		= $this->{$this->moduleModel}->viewPosts($page, $pagination->limit, $this->request->get['store_id']);
		$this->data['limit']		= $pagination->limit;
		$this->template				= 'module/' . $this->moduleNameSmall . '/view_blogs.tpl';

		$this->response->setOutput($this->render());
	}

	public function newBlogPost() {
		$this->load->model('tool/image');
		$this->load->model('module/' . $this->moduleNameSmall);
		$this->load->model('localisation/language');
		$this->load->model('user/user');

		$this->language->load('module/' . $this->moduleNameSmall);		

		$this->data['text_published'] = $this->language->get('text_published');
		$this->data['text_draft'] = $this->language->get('text_draft');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');

		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$this->data['entry_body'] = $this->language->get('entry_body');
		$this->data['entry_excerpt'] = $this->language->get('entry_excerpt');
		$this->data['entry_slug'] = $this->language->get('entry_slug');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_author'] = $this->language->get('entry_author');
		$this->data['entry_date_published'] = $this->language->get('entry_date_published');
		$this->data['entry_featured'] = $this->language->get('entry_featured');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->get['post_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$post_info = $this->{$this->moduleModel}->getPost($this->request->get['post_id']);
			$this->data['post_id'] = $this->request->get['post_id'];
		}

		if (isset($this->request->post['post_description'])) {
			$this->data['post_description'] = $this->request->post['post_description'];
		} elseif (isset($this->request->get['post_id'])) {
			$this->data['post_description'] = $this->{$this->moduleModel}->getPostDescriptions($this->request->get['post_id']);
		} else {
			$this->data['post_description'] = array();
		}

		$this->data['category_options'] = $this->{$this->moduleModel}->getCategories($this->request->get['store_id']);

		if (isset($this->request->post['category_id'])) {
			$this->data['category_id'] = $this->request->post['category_id'];
		} elseif (!empty($post_info)) {
			$this->data['category_id'] = $post_info['category_id'];
		} else {
			$this->data['category_id'] = '';
		}

		if (isset($this->request->post['slug'])) {
			$this->data['slug'] = $this->request->post['slug'];
		} elseif (!empty($post_info)) {
			$this->data['slug'] = $post_info['slug'];
		} else {
			$this->data['slug'] = '';
		}

		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($post_info)) {
			$this->data['image'] = $post_info['image'];
		} else {
			$this->data['image'] = '';
		}

		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($post_info) && $post_info['image'] && file_exists(DIR_IMAGE . $post_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($post_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['date_published'])) {
			$this->data['date_published'] = $this->request->post['date_published'];
		} elseif (!empty($post_info)) {
			$this->data['date_published'] = date('Y-m-d H:i:s', strtotime($post_info['created']));
		} else {
			$this->data['date_published'] = date('Y-m-d H:i:s', time());
		}

		if (isset($this->request->post['is_published'])) {
			$this->data['is_published'] = $this->request->post['is_published'];
		} elseif (!empty($post_info)) {
			$this->data['is_published'] = $post_info['is_published'];
		} else {
			$this->data['is_published'] = 1;
		}

		if (isset($this->request->post['featured'])) {
			$this->data['featured'] = $this->request->post['featured'];
		} elseif (!empty($post_info)) {
			$this->data['featured'] = !empty($post_info['is_featured']);
		} else {
			$this->data['featured'] = 0;
		}

		$users = $this->model_user_user->getUsers();
		$this->data['authors'] = array();

		foreach ($users as $user) {
			$this->data['authors'][] = array(
				'author_id' => $user['user_id'],
				'name' => $user['firstname'] . ' ' . $user['lastname']
			);	
		}

		if (isset($this->request->post['author_id'])) {
			$this->data['author_id'] = $this->request->post['author_id'];
		} elseif (!empty($post_info)) {
			$this->data['author_id'] = $post_info['author_id'];
		} else {
			$this->data['author_id'] = 0;
		}

		$this->data['token'] = $this->session->data['token'];

		$this->template =  'module/' . $this->moduleNameSmall . '/add_edit_post.tpl';
		
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function updatePost() {
		if (!$this->user->hasPermission('modify', 'module/' . $this->moduleNameSmall)) {
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->load->model('module/' . $this->moduleNameSmall);

		if (!empty($this->request->post['slug'])) {
			$this->request->post['slug'] = $this->{$this->moduleModel}->url_slug($this->request->post['slug']);
		}

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && (!isset($this->request->post['post_id']))) {
			$this->{$this->moduleModel}->addPost($this->request->post);
		} else if ($this->request->server['REQUEST_METHOD'] == 'POST' && (isset($this->request->post['post_id']))) {
			$this->{$this->moduleModel}->editPost($this->request->post['post_id'], $this->request->post);
		}	
	}

	public function removePost() {
		if (!$this->user->hasPermission('modify', 'module/' . $this->moduleNameSmall)) {
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->load->model('module/' . $this->moduleNameSmall);

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (isset($this->request->post['id'])) {
				$this->{$this->moduleModel}->deletePost($this->request->post['id']);
			}
		}	
	}

	// 
	// Blog Categories
	//
	
	public function getCategories() {
		$this->data['moduleName'] = $this->moduleName;
		$this->data['moduleNameSmall'] = $this->moduleNameSmall;
		$this->data['moduleData_module'] = $this->moduleData_module;
		$this->data['moduleModel'] = $this->moduleModel;

		if (!empty($this->request->get['page'])) {
			$page = (int) $this->request->get['page'];
		} else {
			$page = 0;
		}

		if (!isset($this->request->get['store_id'])) {
			$this->request->get['store_id'] = 0;
		}

		$this->load->model('module/' . $this->moduleNameSmall);

		$pagination					= new Pagination();
		$pagination->num_links		= 2;
		$pagination->limit			= 10;
		$pagination->total			= $this->{$this->moduleModel}->getTotalCategories($this->request->get['store_id']);
		$pagination->page			= $page;
		$pagination->text			= $this->language->get('text_pagination');
		$pagination->url			= $this->url->link('module/' . $this->moduleNameSmall . '/getCategories','token=' . $this->session->data['token'] . '&page={page}&store_id=' . $this->request->get['store_id'], 'SSL');
		
		$this->data['limit']		= $pagination->limit;
		$this->data['pagination']	= $pagination->render();
			
		$this->data['categories'] = array();

		$results	= $this->{$this->moduleModel}->viewCategories($page, $pagination->limit, $this->request->get['store_id']);

		foreach ($results as $result) {
			$this->data['categories'][] = $result;
		}
		

		$this->template				= 'module/' . $this->moduleNameSmall . '/view_categories.tpl';

		$this->response->setOutput($this->render());
	}

	public function newBlogCategory() {
		$this->load->model('tool/image');
		$this->load->model('module/' . $this->moduleNameSmall);
		$this->load->model('localisation/language');
		$this->load->model('user/user');

		if (!isset($this->request->get['store_id'])) {
			$this->request->get['store_id'] = 0;
		}

		$this->language->load('module/' . $this->moduleNameSmall);		

		$this->data['text_published'] = $this->language->get('text_published');
		$this->data['text_draft'] = $this->language->get('text_draft');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');

		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$this->data['entry_body'] = $this->language->get('entry_body');
		$this->data['entry_excerpt'] = $this->language->get('entry_excerpt');
		$this->data['entry_slug'] = $this->language->get('entry_slug');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_author'] = $this->language->get('entry_author');
		$this->data['entry_date_published'] = $this->language->get('entry_date_published');
		$this->data['entry_featured'] = $this->language->get('entry_featured');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->get['category_id'])) {
			$this->data['category_options'] = $this->{$this->moduleModel}->getCategories($this->request->get['store_id'], array(
				'exclude' => array($this->request->get['category_id'])
			));
		} else {
			$this->data['category_options'] = $this->{$this->moduleModel}->getCategories($this->request->get['store_id']);
		}

		if (isset($this->request->get['category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$category_info = $this->{$this->moduleModel}->getCategory($this->request->get['category_id']);
			$this->data['category_id'] = $this->request->get['category_id'];
		}

		if (isset($this->request->post['category_description'])) {
			$this->data['category_description'] = $this->request->post['category_description'];
		} elseif (isset($this->request->get['category_id'])) {
			$this->data['category_description'] = $this->{$this->moduleModel}->getCategoryDescriptions($this->request->get['category_id']);
		} else {
			$this->data['category_description'] = array();
		}

		if (isset($this->request->post['slug'])) {
			$this->data['slug'] = $this->request->post['slug'];
		} elseif (!empty($category_info)) {
			$this->data['slug'] = $category_info['slug'];
		} else {
			$this->data['slug'] = '';
		}

		if (isset($this->request->post['parent_id'])) {
			$this->data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($category_info)) {
			$this->data['parent_id'] = $category_info['parent_id'];
		} else {
			$this->data['parent_id'] = '';
		}

		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($category_info)) {
			$this->data['image'] = $category_info['image'];
		} else {
			$this->data['image'] = '';
		}

		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($category_info) && $category_info['image'] && file_exists(DIR_IMAGE . $category_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($category_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['date_published'])) {
			$this->data['date_published'] = $this->request->post['date_published'];
		} elseif (!empty($category_info)) {
			$this->data['date_published'] = date('Y-m-d H:i:s', strtotime($category_info['created']));
		} else {
			$this->data['date_published'] = date('Y-m-d H:i:s', time());
		}

		$this->data['token'] = $this->session->data['token'];

		$this->template =  'module/' . $this->moduleNameSmall . '/add_edit_category.tpl';
		
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function updateCategory() {
		if (!$this->user->hasPermission('modify', 'module/' . $this->moduleNameSmall)) {
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->load->model('module/' . $this->moduleNameSmall);

		if (!empty($this->request->post['slug'])) {
			$this->request->post['slug'] = $this->{$this->moduleModel}->url_slug($this->request->post['slug']);
		}

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && (!isset($this->request->post['category_id']))) {
			$this->{$this->moduleModel}->addCategory($this->request->post);
		} else if ($this->request->server['REQUEST_METHOD'] == 'POST' && (isset($this->request->post['category_id']))) {
			$this->{$this->moduleModel}->editCategory($this->request->post['category_id'], $this->request->post);
		}	
	}

	public function removeCategory() {
		if (!$this->user->hasPermission('modify', 'module/' . $this->moduleNameSmall)) {
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->load->model('module/' . $this->moduleNameSmall);

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (isset($this->request->post['id'])) {
				$this->{$this->moduleModel}->deleteCategory($this->request->post['id']);
			}
		}	
	}
}
?>