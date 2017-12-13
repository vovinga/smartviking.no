<?php 
//-----------------------------------------------------
// Sitemap Generator for Opencart v1.5.6   				
// Created by villagedefrance                          		
// contact@villagedefrance.net      						
//-----------------------------------------------------

class ControllerModuleSitemapGenerator extends Controller { 
	private $error = array();
	private $_name = 'sitemapgenerator';
	private $_version = '1.5.6';
	private $_revision = '1.1';

	public function index() { 
	
		if ((substr(VERSION, 0, 5) == '1.5.5') || (substr(VERSION, 0, 5) == '1.5.6')) {
			$this->language->load('module/' . $this->_name);
		} else {
			$this->load->language('module/' . $this->_name);
		}
	
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->data[$this->_name . '_version'] = $this->_version;
	
		$this->load->model('tool/' . $this->_name);
	
		$this->data['heading_title'] = $this->language->get('heading_title');
	
		$this->data['text_sitemaps'] = $this->language->get('text_sitemaps');
		$this->data['text_output'] = $this->language->get('text_output');
		$this->data['text_submit'] = $this->language->get('text_submit');
	
		$this->data['text_head_sitemap'] = $this->language->get('text_head_sitemap');
		$this->data['text_head_filename'] = $this->language->get('text_head_filename');
		$this->data['text_head_filesize'] = $this->language->get('text_head_filesize');
		$this->data['text_head_filedate'] = $this->language->get('text_head_filedate');
		$this->data['text_head_filecheck'] = $this->language->get('text_head_filecheck');
	
		$this->data['button_check'] = $this->language->get('button_check');
		$this->data['button_generate'] = $this->language->get('button_generate');
		$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
	
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
	
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
	
		if (isset($this->session->data['output'])) {
			$this->data['output'] = $this->session->data['output'];
		
			unset($this->session->data['output']);
		} else {
			$this->data['output'] = '';
		}
	
		$this->data['breadcrumbs'] = array();
	
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
	
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
	
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
	
		$this->data['generate_sitemap'] = $this->url->link('module/' . $this->_name . '/generate', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['refresh'] = $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['generate'] = $this->url->link('module/' . $this->_name . '/generate', 'token=' . $this->session->data['token'], 'SSL');
	
		$this->data['googleweb'] = 'https://www.google.com/webmasters/tools/home';
		$this->data['bingweb'] = 'https://ssl.bing.com/webmaster/home/mysites';
		$this->data['yandexweb'] = 'http://webmaster.yandex.com/sites/';
		$this->data['baiduweb'] = 'http://zhanzhang.baidu.com/sitemap/index';
		
		$this->data['text_create'] = $this->language->get('text_create');
		$this->data['text_publish'] = $this->language->get('text_publish');
		
		// Categories
		if (file_exists("../sitemaps/sitemapcategories.xml") && is_file("../sitemaps/sitemapcategories.xml")) {
			$getsitemapcat = file_get_contents("../sitemaps/sitemapcategories.xml");
		
			$this->data['sitemapcategories'] = htmlspecialchars($getsitemapcat, ENT_QUOTES);
		
			$filecat = "../sitemaps/sitemapcategories.xml";
			
			$size = filesize($filecat);
		
			$i = 0;
		
			$suffix = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
		
			while (($size / 1024) > 1) { $size = $size / 1024; $i++; }
		
			$this->data['text_cat'] = $this->language->get('text_cat');
			$this->data['text_namecat'] = $this->language->get('text_namecat');
			$this->data['text_sizecat'] = round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i];
			$this->data['text_datecat'] = sprintf($this->language->get('text_datecat'), date ("d-m-Y H:i:s", filemtime($filecat)));
			$this->data['checkcat'] = HTTP_CATALOG . "sitemaps/sitemapcategories.xml";
		} else {
			$this->data['sitemapcategories'] = '';
		
			$this->data['text_nocat'] = $this->language->get('text_nocat');
		}
	
		// Products
		if (file_exists("../sitemaps/sitemapproducts.xml") && is_file("../sitemaps/sitemapproducts.xml")) {
			$getsitemappro = file_get_contents("../sitemaps/sitemapproducts.xml");
		
			$this->data['sitemapproducts'] = htmlspecialchars($getsitemappro, ENT_QUOTES);
		
			$filepro = "../sitemaps/sitemapproducts.xml";
		
			$size = filesize($filepro);
		
			$i = 0;
		
			$suffix = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
		
			while (($size / 1024) > 1) { $size = $size / 1024; $i++; }
			
			$this->data['text_pro'] = $this->language->get('text_pro');
			$this->data['text_namepro'] = $this->language->get('text_namepro');
			$this->data['text_sizepro'] = round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i];
			$this->data['text_datepro'] = sprintf($this->language->get('text_datepro'), date ("d-m-Y H:i:s", filemtime($filepro)));
			$this->data['checkpro'] = HTTP_CATALOG . "sitemaps/sitemapproducts.xml";
		} else {
			$this->data['sitemapproducts'] = '';
		
			$this->data['text_nopro'] = $this->language->get('text_nopro');
		}
	
		// Manufacturers
		if (file_exists("../sitemaps/sitemapmanufacturers.xml") && is_file("../sitemaps/sitemapmanufacturers.xml")) {
			$getsitemapman = file_get_contents("../sitemaps/sitemapmanufacturers.xml");
		
			$this->data['sitemapmanufacturers'] = htmlspecialchars($getsitemapman, ENT_QUOTES);
		
			$fileman = "../sitemaps/sitemapmanufacturers.xml";
		
			$size = filesize($fileman);
		
			$i = 0;
		
			$suffix = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
		
			while (($size / 1024) > 1) { $size = $size / 1024; $i++; }
			
			$this->data['text_man'] = $this->language->get('text_man');
			$this->data['text_nameman'] = $this->language->get('text_nameman');
			$this->data['text_sizeman'] = round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i];
			$this->data['text_dateman'] = sprintf($this->language->get('text_dateman'), date ("d-m-Y H:i:s", filemtime($fileman)));
			$this->data['checkman'] = HTTP_CATALOG . "sitemaps/sitemapmanufacturers.xml";
		} else {
			$this->data['sitemapmanufacturers'] = '';
		
			$this->data['text_noman'] = $this->language->get('text_noman');
		}
	
		// Information
		if (file_exists("../sitemaps/sitemappages.xml") && is_file("../sitemaps/sitemappages.xml")) {
			$getsitemappag = file_get_contents("../sitemaps/sitemappages.xml");
		
			$this->data['sitemappages'] = htmlspecialchars($getsitemappag, ENT_QUOTES);
		
			$filepag = "../sitemaps/sitemappages.xml";
		
			$size = filesize($filepag);
		
			$i = 0;
		
			$suffix = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
		
			while (($size / 1024) > 1) { $size = $size / 1024; $i++; }
		
			$this->data['text_pag'] = $this->language->get('text_pag');
			$this->data['text_namepag'] = $this->language->get('text_namepag');
			$this->data['text_sizepag'] = round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i];
			$this->data['text_datepag'] = sprintf($this->language->get('text_datepag'), date ("d-m-Y H:i:s", filemtime($filepag)));
			$this->data['checkpag'] = HTTP_CATALOG . "sitemaps/sitemappages.xml";
		} else {
			$this->data['sitemappages'] = '';
		
			$this->data['text_nopag'] = $this->language->get('text_nopag');
		}
		
		// Version Check
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['module_name'] = $this->language->get('text_module_name');
		$this->data['module_current_name'] = $this->_name;
		$this->data['module_list'] = $this->language->get('text_module_list');
		$this->data['store_version'] = sprintf($this->language->get('text_store_version'), VERSION);
		$this->data['store_base_version'] = substr(VERSION, 0, 5);
		$this->data['text_template'] = $this->language->get('text_template');
	
		$this->data['compatibles'] = array();
	
		$this->data['compatibles'][] = array('opencart' => '1.5.1', 'title' => $this->language->get('text_v151'));
		$this->data['compatibles'][] = array('opencart' => '1.5.2', 'title' => $this->language->get('text_v152'));
		$this->data['compatibles'][] = array('opencart' => '1.5.3', 'title' => $this->language->get('text_v153'));
		$this->data['compatibles'][] = array('opencart' => '1.5.4', 'title' => $this->language->get('text_v154'));
		$this->data['compatibles'][] = array('opencart' => '1.5.5', 'title' => $this->language->get('text_v155'));
		$this->data['compatibles'][] = array('opencart' => '1.5.6', 'title' => $this->language->get('text_v156'));
		
		$this->data['button_showhide'] = $this->language->get('button_showhide');
		$this->data['button_support'] = $this->language->get('button_support');
	
		$this->data['module_current_version'] = sprintf($this->language->get('text_module_version'), $this->_version);
		$this->data['module_current_revision'] = sprintf($this->language->get('text_module_revision'), $this->_revision);
		$this->data['text_no_file'] = $this->language->get('text_no_file');
		$this->data['text_update'] = $this->language->get('text_update');
		$this->data['text_getupdate'] = $this->language->get('text_getupdate');
	
		$vdfurl = 'http://villagedefrance.net/updater/module/' . $this->_name . '/revisions.txt';
		$vdfhandler = curl_init($vdfurl);
		curl_setopt($vdfhandler,  CURLOPT_RETURNTRANSFER, TRUE);
		$resp = curl_exec($vdfhandler);
		$vdf = curl_getinfo($vdfhandler, CURLINFO_HTTP_CODE);
	
		if ($vdf == '200') { 
			$getRevisions = file_get_contents($vdfurl);
		} else {
			$getRevisions = '';
		}
	
		if ($getRevisions !== '') {
			$revisionList = explode("\n", $getRevisions);
		
			foreach ($revisionList as $revision) { 
			
				$version = substr($revision, 0, 5);
				$subversion = substr($revision, -3);
			
				if ($version > $this->_version) {
					$this->data['version'] = sprintf($this->language->get('text_v_update'), $version);
					$this->data['ver_update'] = true;
				
					$this->data['revision'] = $this->language->get('text_no_revision');
				} else {
					$this->data['version'] = sprintf($this->language->get('text_v_no_update'), $version);
					$this->data['ver_update'] = false;
				
					if ($subversion > $this->_revision) {
						$this->data['revision'] = sprintf($this->language->get('text_r_update'), $subversion);
						$this->data['rev_update'] = true;
					} else {
						$this->data['revision'] = sprintf($this->language->get('text_r_no_update'), $subversion);
						$this->data['rev_update'] = false;
					}
				}
			}
		} else {
			$this->data['version'] = '';
			$this->data['revision'] = '';
			$this->data['ver_update'] = false;
			$this->data['rev_update'] = false;
		}
	
		// Template
		$this->data['templates'] = array();
	
		$directories = glob(DIR_CATALOG . 'view/theme/*', GLOB_ONLYDIR);
	
		foreach ($directories as $directory) {
			$this->data['templates'][] = basename($directory);
		}
	
		if (isset($this->request->post['config_template'])) {
			$this->data['config_template'] = $this->request->post['config_template'];
		} else {
			$this->data['config_template'] = $this->config->get('config_template');	
		}
	
		$this->template = 'module/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
	
		$this->response->setOutput($this->render());
	}

	public function generate() {
		
		if ((substr(VERSION, 0, 5) == '1.5.5') || (substr(VERSION, 0, 5) == '1.5.6')) {
			$this->language->load('module/' . $this->_name);
		} else {
			$this->load->language('module/' . $this->_name);
		}
	
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('tool/' . $this->_name);
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()) {
		
			$this->session->data['output'] = $this->model_tool_sitemapgenerator->generate();
		
			$this->session->data['success'] = $this->language->get('text_success');
		
			$this->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			return $this->forward('error/permission');
		}
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/' . $this->_name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
	
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>