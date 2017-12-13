<?php
class ControllerModuleiBlog extends Controller {
	
	private $moduleName = 'iBlog';
	private $moduleNameSmall = 'iblog';
	private $moduleData_module = 'iblog_module';
	private $moduleModel = 'model_module_iblog';
	
	private function is_enabled() {
		$store_id = (int)$this->config->get('config_store_id');
		$language_id = (int)$this->config->get('config_language_id');

		// iBlog Settings
		$this->load->model('module/' . $this->moduleNameSmall);
		$iBlogSetting = $this->{$this->moduleModel}->getSetting($this->moduleName, $store_id);

		if (empty($iBlogSetting[$this->moduleName]['Enabled']) || (!empty($iBlogSetting[$this->moduleName]['Enabled']) && $iBlogSetting[$this->moduleName]['Enabled'] !== 'yes')) {
			return false;
		} else {
			return true;
		}
	}

	public function index($widget_setting = array()) {
		// iBlog Globally Enabled
		if (!$this->is_enabled()) {
			return;
		}

		if (empty($widget_setting['status'])) {
			return;
		}

		$store_id = (int)$this->config->get('config_store_id');
		$language_id = (int)$this->config->get('config_language_id');

		$this->language->load('module/' . $this->moduleNameSmall);
		$this->load->model('module/' . $this->moduleNameSmall);

		// iBlog Settings
		$iBlogSetting = $this->{$this->moduleModel}->getSetting($this->moduleName, $store_id);
		$this->data['data'] = $iBlogSetting[$this->moduleName];
		
		$language_variables = array(
			'heading_title',
			'no_posts',
			'no_categories',
			'iblog_button',
			'categories_title'
		);

		foreach ($language_variables as $variable) {
			$this->data[$variable] 	= $this->language->get($variable);
		}

		// Featured Blog Post
		if (!empty($widget_setting['FeaturedEnabled'])) {
			$this->data['featured'] = $this->{$this->moduleModel}->getFeaturedPost();

			if ($this->data['featured'] !== false) {
				$this->load->model('tool/image');

				if (file_exists(DIR_IMAGE . $this->data['featured']['image'])) {
					if (isset($widget_setting['FeaturedImageWidth']) && isset($widget_setting['FeaturedImageHeight'])) {
						$this->data['featured']['image'] = $this->model_tool_image->resize($this->data['featured']['image'], $widget_setting['FeaturedImageWidth'], $widget_setting['FeaturedImageHeight']);
					} else {
						$this->data['featured']['image'] = $this->model_tool_image->resize($this->data['featured']['image'], 130, 130);
					}
				} else {
					$this->data['featured']['image'] = false;
				}
			}
		}

		// Blog Categories
		if (!empty($widget_setting['CategoriesEnabled'])) {
			$this->data['categories'] = array();

			$categories = $this->{$this->moduleModel}->getCategories(array('parent_id' => 0));

			foreach ($categories as $category) {
				$children_data = array();

				$children = $this->{$this->moduleModel}->getCategories(array('parent_id' => $category['iblog_category_id']));

				foreach ($children as $child) {
					$children_data[] = array(
						'category_id'	=> $child['iblog_category_id'],
						'title'			=> $child['title'],
						'image'			=> $child['image'],
						'href'			=> $this->url->link('module/' . $this->moduleNameSmall . '/category', 'iblog_category_id=' . $child['iblog_category_id'])
					);						
				}

				$this->data['categories'][] = array(
					'category_id'	=> $category['iblog_category_id'],
					'title'			=> $category['title'],
					'image'			=> $category['image'],
					'href'			=> $this->url->link('module/' . $this->moduleNameSmall . '/category', 'iblog_category_id=' . $category['iblog_category_id']),
					'children'		=> $children_data,
				);
			}

			$this->data['category_id'] = !empty($this->request->get['iblog_category_id']) ? $this->request->get['iblog_category_id'] : 0;
		}

		// Blog Posts
		$this->data['posts'] = array();

		$data = array(
			'sort'	=> 'p.created',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 5
		);

		$posts = $this->{$this->moduleModel}->getPosts($data);

		foreach ($posts as $post) {
			$this->data['posts'][] = array(
				'post_id'	=> $post['iblog_post_id'],
				'title'		=> $post['title'],
				'image'		=> $post['image'],
				'excerpt'	=> $post['excerpt'],
				'href'		=> $this->url->link('module/' . $this->moduleNameSmall . '/post', 'post_id=' . $post['iblog_post_id'])
			);
		}

		$this->data['post_id'] = !empty($this->request->get['post_id']) ? $this->request->get['post_id'] : 0;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->moduleNameSmall . '.tpl')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/iblog.css');
			
			$this->template = $this->config->get('config_template') . '/template/module/' . $this->moduleNameSmall . '.tpl';
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/iblog.css');
			
			$this->template = 'default/template/module/' . $this->moduleNameSmall . '.tpl';
		}
		
		$this->render();
	}

	private function getStore($store_id) {    
		if ($store_id && $store_id != 0) {
			$store = $this->model_setting_store->getStore($store_id);
		} else {
			$store['store_id'] = 0;
			$store['name'] = $this->config->get('config_name');
			$store['url'] = $this->getCatalogURL();
		}
		
		return $store;
	}
	
	private function getCatalogURL() {
		if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
			$storeURL = HTTP_SERVER;
		} else {
			$storeURL = HTTPS_SERVER;
		}

		return $storeURL;
	}
	
	public function post() {
		// iBlog Globally Enabled
		if (!$this->is_enabled()) {
			$this->redirect($this->url->link('common/home', null, 'SSL'));
			return;
		}

		$store_id = (int)$this->config->get('config_store_id');
		$language_id = (int)$this->config->get('config_language_id');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),			
			'separator' => false
		);
		
		if (isset($this->request->get['post_id'])) {
			$post_id = (int)$this->request->get['post_id'];
		} else {
			$post_id = 0;
		}

		$this->language->load('module/' . $this->moduleNameSmall);		
		$this->load->model('module/' . $this->moduleNameSmall);
		
		// iBlog Settings
		$iBlogSetting = $this->{$this->moduleModel}->getSetting($this->moduleName, $store_id);
		$this->data['data'] = $iBlogSetting[$this->moduleName];
		
		$post_info = $this->{$this->moduleModel}->getPost($post_id);
		
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/iblog/listing'),
			'separator' => $this->language->get('text_separator')
		);
		

		if (!empty($this->request->get['iblog_category_id'])) {
			$category_info = $this->{$this->moduleModel}->getCategory($this->request->get['iblog_category_id']);

			if (!empty($category_info)) {
				$this->data['breadcrumbs'][] = array(
					'text'      => $category_info['title'],
					'href'      => $this->url->link('module/' . $this->moduleNameSmall . '/category', 'iblog_category_id=' . $category_info['iblog_category_id']),
					'separator' => $this->language->get('text_separator')
				);
			}
		}

		if ($post_info) {												
			$this->data['breadcrumbs'][] = array(
				'text'      => $post_info['title'],
				'href'      => $this->url->link('module/' . $this->moduleNameSmall . '/post', 'post_id=' . $this->request->get['post_id']),
				'separator' => $this->language->get('text_separator')
			);

			$this->document->setTitle($post_info['title']);
			$this->document->setDescription($post_info['meta_description']);
			$this->document->setKeywords($post_info['meta_keyword']);
			
			$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');
			
			$this->data['heading_title'] = $post_info['title'];
			
			$this->load->model('tool/image');

			if ($post_info['image']) {
				$this->data['popup'] = $this->model_tool_image->resize($post_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
			} else {
				$this->data['popup'] = '';
			}
			
			if ($post_info['image']) {
				$this->data['thumb'] = $this->model_tool_image->resize($post_info['image'], $this->data['data']['MainImageWidth'], $this->data['data']['MainImageHeight']);
			} else {
				$this->data['thumb'] = '';
			}
			
			$this->data['iblog_keywords'] = $this->language->get('iblog_keywords');
			$this->data['keywords'] = isset($post_info['meta_keyword']) ? $post_info['meta_keyword'] : $this->language->get('no_keywords');			
			$this->data['author'] = $post_info['author'];
			$this->data['date_created'] = date('Y/m/d', strtotime($post_info['created']));
			$this->data['body'] = html_entity_decode($post_info['body'], ENT_QUOTES, 'UTF-8');
			
			$this->data['text_author'] = $this->language->get('text_author');
			$this->data['text_date_created'] = $this->language->get('text_date_created');
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/iblog/post.tpl')) {
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/iblog.css');
				
				$this->template = $this->config->get('config_template') . '/template/iblog/post.tpl';
			} else {
				$this->document->addStyle('catalog/view/theme/default/stylesheet/iblog.css');
				
				$this->template = 'default/template/iblog/post.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);

			$this->response->setOutput($this->render());
		} else {
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error_post'),
				'href'      => $this->url->link('iblog/post', 'post_id=' . $post_id),
				'separator' => $this->language->get('text_separator')
			);			

			$this->document->setTitle($this->language->get('text_error_post'));

			$this->data['heading_title'] 	= $this->language->get('text_error_post');
			$this->data['text_error'] 	= $this->language->get('text_error_post');
			$this->data['button_continue'] 	= $this->language->get('button_continue');

			$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);

			$this->response->setOutput($this->render());
		}
	}
	
	public function listing() {
		// iBlog Globally Enabled
		if (!$this->is_enabled()) {
			$this->redirect($this->url->link('common/home', null, 'SSL'));
			return;
		}

		$store_id = (int)$this->config->get('config_store_id');
		$language_id = (int)$this->config->get('config_language_id');


		$this->load->model('tool/image'); 
		$this->language->load('module/' . $this->moduleNameSmall);
		$this->load->model('module/' . $this->moduleNameSmall);
		
		// iBlog Settings
		$iBlogSetting = $this->{$this->moduleModel}->getSetting($this->moduleName, $store_id);
		$this->data['data'] = $iBlogSetting[$this->moduleName];

		$language_variables = array(
			'heading_title',
			'text_iblog_empty',
			'button_continue',
			'text_display',
			'text_list',
			'text_grid',
			'text_sort',
			'text_limit',
			'iblog_button',
			'search_string',
			'search_button',
			'search_placeholder'
		);

		foreach ($language_variables as $variable) {
			$this->data[$variable] 	= $this->language->get($variable);
		}
		$this->data['heading_title'] = $iBlogSetting[$this->moduleName]['PageTitle'][$language_id];
		// Document Meta
		if (!empty($iBlogSetting[$this->moduleName]['PageTitle'][$language_id])) {
			$this->document->setTitle($iBlogSetting[$this->moduleName]['PageTitle'][$language_id]);
		} else {
			$this->document->setTitle($this->language->get('heading_title'));
		}
		

		if (!empty($iBlogSetting[$this->moduleName]['MetaDescription'][$language_id])) {
			$this->document->setDescription($iBlogSetting[$this->moduleName]['MetaDescription'][$language_id]);
		} else {
			$this->document->setDescription($this->config->get('config_meta_description'));
		}
		
		if (!empty($iBlogSetting[$this->moduleName]['MetaKeywords'][$language_id])) {
			$this->document->setKeywords($iBlogSetting[$this->moduleName]['MetaKeywords'][$language_id]);
		} else {
			$this->document->setKeywords($this->config->get('config_meta_keywords'));
		}

		$this->data['search_link'] 			= $this->url->link('module/iblog/search');
		$this->data['continue'] 			= $this->url->link('common/home');

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.created';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}	
		
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}
		
		$this->data['breadcrumbs'] = array();
		
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => false
		);
		
		$this->data['breadcrumbs'][] = array(
			'text'      => $iBlogSetting[$this->moduleName]['PageTitle'][$language_id],
			'href'      => $this->url->link('module/iblog/listing'),
			'separator' => $this->language->get('text_separator')
		);
		
		$url = '';

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}
		
		$this->data['sorts'] = array();

		$this->data['sorts'][] = array(
			'text'  => $this->language->get('text_default'),
			'value' => 'p.created-DESC',
			'href'  => $this->url->link('module/iblog/listing', '&sort=p.created&order=DESC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  => $this->language->get('text_name_asc'),
			'value' => 'pd.title-ASC',
			'href'  => $this->url->link('module/iblog/listing', '&sort=pd.title&order=ASC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  => $this->language->get('text_name_desc'),
			'value' => 'pd.title-ASC',
			'href'  => $this->url->link('module/iblog/listing', '&sort=pd.title&order=DESC' . $url)
		);
		
		$url = '';
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}	

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}	

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));
		
		sort($limits);

		foreach ($limits as $value) {
			$this->data['limits'][] = array(
				'text'  => $value,
				'value' => $value,
				'href'  => $this->url->link('module/iblog/listing', $url . '&limit=' . $value)
			);
		}

		$data = array(
			'sort'               => $sort,
			'order'              => $order,
			'start'              => ($page - 1) * $limit,
			'limit'              => $limit
		);
		
		$posts = $this->{$this->moduleModel}->getPosts($data); 
		$posts_total = $this->{$this->moduleModel}->getTotalPosts($store_id);
		
		$image_width = (!empty($this->data['data']['ListingImageWidth'])) ? (int)$this->data['data']['ListingImageWidth'] : 140;
		$image_height = (!empty($this->data['data']['ListingImageHeight'])) ? (int)$this->data['data']['ListingImageHeight'] : 140;

		foreach ($posts as $post) {
			$this->data['posts'][] = array(
				'post_id'	=> $post['iblog_post_id'],
				'title'		=> $post['title'],
				'image'		=> (isset($post['image'])) ? $this->model_tool_image->resize($post['image'], $image_width, $image_height) : '',
				'excerpt'	=> $post['excerpt'],
				'href'		=> $this->url->link('module/' . $this->moduleNameSmall . '/post', 'post_id=' . $post['iblog_post_id'])
			);	
		}

		$url = '';
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}	

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}	

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$pagination = new Pagination();
		$pagination->total = $posts_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/iblog/listing', $url . '&page={page}');

		$this->data['pagination'] = $pagination->render();
		
		$this->data['current_sort'] = $sort;
		$this->data['current_order'] = $order;
		$this->data['current_limit'] = $limit;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/iblog/listing.tpl')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/iblog.css');
			
			$this->template = $this->config->get('config_template') . '/template/iblog/listing.tpl';
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/iblog.css');
			
			$this->template = 'default/template/iblog/listing.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
	}
	
	public function search() {
		// iBlog Globally Enabled
		if (!$this->is_enabled()) {
			$this->redirect($this->url->link('common/home', null, 'SSL'));
			return;
		}

		$store_id = (int)$this->config->get('config_store_id');
		$language_id = (int)$this->config->get('config_language_id');

		$this->language->load('module/' . $this->moduleNameSmall);
		$this->load->model('module/' . $this->moduleNameSmall);		
		$this->load->model('tool/image'); 
		
		$iBlogSetting = $this->{$this->moduleModel}->getSetting($this->moduleName, $store_id);
		$this->data['data'] = $iBlogSetting[$this->moduleName];

		// Document Meta
		if (isset($this->request->get['search'])) {
			$this->document->setTitle($this->language->get('heading_title_search') .  ' - ' . $this->request->get['search']);
		} else {
			if (!empty($iBlogSetting[$this->moduleName]['LinkTitle'][$language_id])) {
				$this->document->setTitle($iBlogSetting[$this->moduleName]['LinkTitle'][$language_id]);
			} else {
				$this->document->setTitle($this->language->get('heading_title'));
			}
		}
		

		if (!empty($iBlogSetting[$this->moduleName]['MetaDescription'][$language_id])) {
			$this->document->setDescription($iBlogSetting[$this->moduleName]['MetaDescription'][$language_id]);
		} else {
			$this->document->setDescription($this->config->get('config_meta_description'));
		}
		
		if (!empty($iBlogSetting[$this->moduleName]['MetaKeywords'][$language_id])) {
			$this->document->setKeywords($iBlogSetting[$this->moduleName]['MetaKeywords'][$language_id]);
		} else {
			$this->document->setKeywords($this->config->get('config_meta_keywords'));
		}

		if (isset($this->request->get['search'])) {
			$search = $this->request->get['search'];
		} else {
			$search = '';
		} 
		if (isset($this->request->get['description'])) {
			$description = $this->request->get['description'];
		} else {
			$description = '';
		} 
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.created';
		} 
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/iblog/listing'),
			'separator' => $this->language->get('text_separator')
		);


		$url = '';
		if (isset($this->request->get['search'])) {
			$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['description'])) {
			$url .= '&description=' . $this->request->get['description'];
		}
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}	
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}	
		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title_search'),
			'href'      => $this->url->link('module/iblog/search', $url),
			'separator' => $this->language->get('text_separator')
		);

		if (isset($this->request->get['search'])) {
			$this->data['heading_title'] = $this->language->get('heading_title_search') .  ' - ' . $this->request->get['search'];
		} else {
			$this->data['heading_title'] = $this->language->get('heading_title_search');
		}

		$language_variables = array(
			'text_empty',
			'text_critea',
			'text_search',
			'text_keyword',
			'text_display',
			'text_list',
			'text_grid',
			'text_sort',
			'text_limit',
			'entry_search',
			'entry_description',
			'search_button',
			'iblog_button',
		);

		foreach ($language_variables as $variable) {
			$this->data[$variable] 	= $this->language->get($variable);
		}

		if (isset($this->request->get['search'])) {
			$data = array(
				'filter_name'         => $search, 
				'filter_description'  => $description,
				'sort'                => $sort,
				'order'               => $order,
				'start'               => ($page - 1) * $limit,
				'limit'               => $limit
			);
			
			$posts_total = $this->{$this->moduleModel}->getTotalPosts($store_id, $data);
			$results = $this->{$this->moduleModel}->getPosts($data); 
			
			$image_width = (!empty($this->data['data']['ListingImageWidth'])) ? (int)$this->data['data']['ListingImageWidth'] : 140;
			$image_height = (!empty($this->data['data']['ListingImageHeight'])) ? (int)$this->data['data']['ListingImageHeight'] : 140;

			foreach ($results as $post) {
				$this->data['posts'][] = array(
					'post_id'	=> $post['iblog_post_id'],
					'title'		=> $post['title'],
					'image'		=> (isset($post['image'])) ? $this->model_tool_image->resize($post['image'], $image_width, $image_height) : '',
					'excerpt'	=> $post['excerpt'],
					'href'		=> $this->url->link('module/' . $this->moduleNameSmall . '/post', 'post_id=' . $post['iblog_post_id'])
				);	
			}

			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$this->data['sorts'] = array();

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.created-DESC',
				'href'  => $this->url->link('module/iblog/search', '&sort=p.created&order=DESC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.title-ASC',
				'href'  => $this->url->link('module/iblog/search', '&sort=pd.title&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.title-ASC',
				'href'  => $this->url->link('module/iblog/search', '&sort=pd.title&order=DESC' . $url)
			);
			
			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$this->data['limits'] = array();

			$limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));

			sort($limits);

			foreach ($limits as $value) {
				$this->data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('module/iblog/search', $url . '&limit=' . $value)
					);
			}

			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$pagination = new Pagination();
			$pagination->total = $posts_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('module/iblog/search', $url . '&page={page}');

			$this->data['pagination'] = $pagination->render();
		}	

		$this->data['search'] = $search;
		$this->data['description'] = $description;

		$this->data['current_sort'] = $sort;
		$this->data['current_order'] = $order;
		$this->data['current_limit'] = $limit;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/iblog/search.tpl')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/iblog.css');
			
			$this->template = $this->config->get('config_template') . '/template/iblog/search.tpl';
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/iblog.css');
			
			$this->template = 'default/template/iblog/search.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());	
	}

	public function category() {
		// iBlog Globally Enabled
		if (!$this->is_enabled()) {
			$this->redirect($this->url->link('common/home', null, 'SSL'));
			return;
		}

		$store_id = (int)$this->config->get('config_store_id');
		$language_id = (int)$this->config->get('config_language_id');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),			
			'separator' => false
		);

		if (isset($this->request->get['iblog_category_id'])) {
			$category_id = (int)$this->request->get['iblog_category_id'];
		} else {
			$category_id = 0;
		}
		
		$this->language->load('module/' . $this->moduleNameSmall);
		$this->load->model('module/' . $this->moduleNameSmall);
		
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/iblog/listing'),
			'separator' => $this->language->get('text_separator')
		);

		$language_variables = array(
			'heading_title',
			'text_iblog_empty',
			'button_continue',
			'text_display',
			'text_list',
			'text_grid',
			'text_sort',
			'text_limit',
			'iblog_button',
			'search_string',
			'search_button',
			'search_placeholder'
		);

		foreach ($language_variables as $variable) {
			$this->data[$variable] 	= $this->language->get($variable);
		}

		$this->data['no_posts'] = $this->language->get('no_posts');
		$this->data['text_error'] = $this->language->get('text_error_category');
		$this->data['heading_title'] = $this->language->get('text_error_category');
		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['continue'] = $this->url->link('common/home');

		// iBlog Settings
		$iBlogSetting = $this->{$this->moduleModel}->getSetting($this->moduleName, $store_id);
		$this->data['data'] = $iBlogSetting[$this->moduleName];

		$category_info = $this->{$this->moduleModel}->getCategory($category_id);
		
		if ($category_info) {											
			$this->data['breadcrumbs'][] = array(
				'text'      => $category_info['title'],
				'href'      => $this->url->link('module/' . $this->moduleNameSmall . '/category', 'iblog_category_id=' . $category_id),
				'separator' => $this->language->get('text_separator')
			);			

			$this->document->setTitle($category_info['title']);
			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);
			
			$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');
			
			$this->data['heading_title'] = $category_info['title'];
			
			// Category Info
			$this->load->model('tool/image');

			if ($category_info['image']) {
				$this->data['popup'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
			} else {
				$this->data['popup'] = '';
			}
			
			if ($category_info['image']) {
				$this->data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->data['data']['MainImageWidth'], $this->data['data']['MainImageHeight']);
			} else {
				$this->data['thumb'] = '';
			}
			
			$this->data['iblog_keywords'] = $this->language->get('iblog_keywords');
			$this->data['keywords'] = isset($category_info['meta_keyword']) ? $category_info['meta_keyword'] : $this->language->get('no_keywords');
			$this->data['date_created'] = date('Y/m/d', strtotime($category_info['created']));
			
			$this->data['text_author'] = $this->language->get('text_author');
			$this->data['text_date_created'] = $this->language->get('text_date_created');
			
			// Category Blog Posts
			$url = '&iblog_category_id=' . $category_info['iblog_category_id'];

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			
			$this->data['sorts'] = array();

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.created-DESC',
				'href'  => $this->url->link('module/iblog/category', '&sort=p.created&order=DESC' . $url)
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.title-ASC',
				'href'  => $this->url->link('module/iblog/category', '&sort=pd.title&order=ASC' . $url)
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.title-ASC',
				'href'  => $this->url->link('module/iblog/category', '&sort=pd.title&order=DESC' . $url)
			);
			
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}	

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));
			
			sort($limits);

			foreach ($limits as $value) {
				$this->data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('module/iblog/listing', $url . '&limit=' . $value)
				);
			}

			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
			} else {
				$sort = 'p.created';
			}

			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
			} else {
				$order = 'DESC';
			}

			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else { 
				$page = 1;
			}	
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = $this->config->get('config_catalog_limit');
			}

			$data = array(
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit,
				'filter_category_id' => $category_info['iblog_category_id']
			);

			$posts = $this->{$this->moduleModel}->getPosts($data); 
			$posts_total = $this->{$this->moduleModel}->getTotalPosts($store_id, $data);
			
			$image_width = (!empty($this->data['data']['ListingImageWidth'])) ? (int)$this->data['data']['ListingImageWidth'] : 140;
			$image_height = (!empty($this->data['data']['ListingImageHeight'])) ? (int)$this->data['data']['ListingImageHeight'] : 140;

			foreach ($posts as $post) {
				$this->data['posts'][] = array(
					'post_id'	=> $post['iblog_post_id'],
					'title'		=> $post['title'],
					'image'		=> (isset($post['image'])) ? $this->model_tool_image->resize($post['image'], $image_width, $image_height) : '',
					'excerpt'	=> $post['excerpt'],
					'href'		=> $this->url->link('module/' . $this->moduleNameSmall . '/post', 'post_id=' . $post['iblog_post_id'])
				);	
			}

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}	

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$pagination = new Pagination();
			$pagination->total = $posts_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('module/iblog/listing', $url . '&page={page}');

			$this->data['pagination'] = $pagination->render();
			
			$this->data['current_sort'] = $sort;
			$this->data['current_order'] = $order;
			$this->data['current_limit'] = $limit;		

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/iblog/category.tpl')) {
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/iblog.css');
				
				$this->template = $this->config->get('config_template') . '/template/iblog/category.tpl';
			} else {
				$this->document->addStyle('catalog/view/theme/default/stylesheet/iblog.css');
				
				$this->template = 'default/template/iblog/category.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);

			$this->response->setOutput($this->render());
		} else {
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error_category'),
				'href'      => $this->url->link('module/' . $this->moduleNameSmall . '/category'),
				'separator' => $this->language->get('text_separator')
			);			

			$this->document->setTitle($this->language->get('text_error_category'));

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);

			$this->response->setOutput($this->render());
		}
	}
}
?>