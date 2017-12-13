<?php
// ------------------------------------------------------
// Product Model Code Generator for Opencart
// By P.K Solutions
// sales@p-k-solutions.co.uk
// ------------------------------------------------------

class ControllerCatalogmodelcodegen extends Controller {
	
	private $error = array();
	private $_name = 'modelcodegen';
	private $_version = '1.1';	
	
	public function updateAll() {

		$this->load->model('catalog/modelcodegen');
		
		$this->model_catalog_modelcodegen->updateAll($this->request->get);		
	}

	public function index() {
	   $this->load->model('catalog/modelcodegen');
	   //check database
	   $this->model_catalog_modelcodegen->check_db();
	   
		$this->load->language('catalog/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->data[$this->_name . '_version'] = $this->_version;
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_catalog_modelcodegen->updateValues($this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
		
			$this->redirect($this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['module_title'] = $this->language->get('module_title');
		
		$this->data['condition1'] = $this->language->get('condition1');
		$this->data['condition1Text'] = $this->language->get('condition1Text');
		$this->data['condition2'] = $this->language->get('condition2');
		$this->data['condition2Text'] = $this->language->get('condition2Text');
		$this->data['conditionOption1'] = $this->language->get('conditionOption1');
		$this->data['conditionOption2'] = $this->language->get('conditionOption2');

		$this->data['conditionUser'] = $this->language->get('conditionUser');
		$this->data['conditionUserText'] = $this->language->get('conditionUserText');

		$this->data['sequential'] = $this->language->get('sequential');
		$this->data['sequentialText'] = $this->language->get('sequentialText');
		$this->data['useHyphens'] = $this->language->get('useHyphens');
		$this->data['useHyphensText'] = $this->language->get('useHyphensText');		
		$this->data['useHyphensYes'] = $this->language->get('useHyphensYes');
		$this->data['useHyphensNo'] = $this->language->get('useHyphensNo');	
		$this->data['updatebtn'] = $this->language->get('updatebtn');			
		
		$this->data['updateAll'] = $this->language->get('updateAll');	
		$this->data['updateAllText'] = $this->language->get('updateAllText');	
		$this->data['updateSuccess'] = $this->language->get('updateSuccess');		
		
		$this->data['conditions'] = $this->language->get('conditions');	
		$this->data['userConditions'] = $this->language->get('userConditions');	
		$this->data['defaults'] = $this->language->get('defaults');	
		$this->data['setup'] = $this->language->get('setup');				
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
	    $results = $this->model_catalog_modelcodegen->getValues();	
		
		$this->data['condition1value'] = $results['condition1'];
		$this->data['condition2value'] = $results['condition2'];
		$this->data['conditionUserValue'] = $results['conditionUser'];
		$this->data['sequentialValue'] = $results['sequential'];
		$this->data['useHyphensValue'] = $results['useHyphens'];		
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' : '
   		);						
		
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
		
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
			
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
	
		$this->template = 'catalog/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		$this->response->setOutput($this->render());		
		
		$this->data['breadcrumbs'] = array();
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	);					
}
}
?>
