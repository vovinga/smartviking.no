<?php
class ControllerModuleCompareprices extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('module/compareprices');
	
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('setting/setting');
		$this->data['error_warning'] = '';
		
		$this->document->addScript('view/javascript/compareprices/bootstrap/js/bootstrap.min.js');
		$this->document->addStyle('view/javascript/compareprices/bootstrap/css/bootstrap.min.css');
		$this->document->addStyle('view/javascript/compareprices/font-awesome/css/font-awesome.min.css');
		$this->document->addStyle('view/stylesheet/compareprices.css');		

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			if (!$this->user->hasPermission('modify', 'module/compareprices')) {
				$this->validate();
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}

			if (!empty($_POST['OaXRyb1BhY2sgLSBDb21'])) {
				$this->request->post['ComparePrices']['LicensedOn'] = $_POST['OaXRyb1BhY2sgLSBDb21'];
			}
			if (!empty($_POST['cHRpbWl6YXRpb24ef4fe'])) {
				$this->request->post['ComparePrices']['License'] = json_decode(base64_decode($_POST['cHRpbWl6YXRpb24ef4fe']),true);
			}

			
			$this->model_setting_setting->editSetting('ComparePrices', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
			
			if (!empty($_GET['activate'])) {
				$this->session->data['success'] = $this->language->get('text_success_activation');
			}
			
			$selectedTab = (empty($this->request->post['selectedTab'])) ? 0 : $this->request->post['selectedTab'];
			$this->redirect($this->url->link('module/compareprices', 'token=' . $this->session->data['token'] . '&tab='.$selectedTab, 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');

		$this->data['entry_code'] = $this->language->get('entry_code');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['entry_layouts_active'] = $this->language->get('entry_layouts_active');
		$this->data['entry_highlightcolor'] = $this->language->get('entry_highlightcolor');
		
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();;
		$this->data['languages'] = $languages;
		$firstLanguage = array_shift($languages);
		$this->data['firstLanguageCode'] = $firstLanguage['code'];
			
 		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
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
			'href'      => $this->url->link('module/compareprices', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/compareprices', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['ComparePrices'])) {
			foreach ($this->request->post['ComparePrices'] as $key => $value) {
				$this->data['data']['ComparePrices'][$key] = $this->request->post['ComparePrices'][$key];
			}
		} else {
			$configValue = $this->config->get('ComparePrices');
			$this->data['data']['ComparePrices'] = $configValue;		
		}
		
		$this->data['currenttemplate'] =  $this->config->get('config_template');
		$this->data['modules'] = array();

		if (isset($this->request->post['compareprices_module'])) {
			$this->data['modules'] = $this->request->post['compareprices_module'];
			exit;
		} elseif ($this->config->get('compareprices_module')) { 
			$this->data['modules'] = $this->config->get('compareprices_module');
		}	

		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		$this->template = 'module/compareprices.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);		

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/compareprices')) {
			$this->error = true;
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>