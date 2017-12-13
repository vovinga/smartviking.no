<?php 
class ControllerPaymentepay extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/epay');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('epay', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		
		$this->data['text_merchantnumber'] = $this->language->get('text_merchantnumber');
		$this->data['text_paymentwindow'] = $this->language->get('text_paymentwindow');
		
		$this->data['text_ownreceipt'] = $this->language->get('text_ownreceipt');
		
		$this->data['text_paymentwindow_overlay'] = $this->language->get('text_paymentwindow_overlay');
		$this->data['text_paymentwindow_fullscreen'] = $this->language->get('text_paymentwindow_fullscreen');
		
		$this->data['text_payment'] = $this->language->get('text_payment');
		
		$this->data['text_fee'] = $this->language->get('text_fee');
		$this->data['text_group'] = $this->language->get('text_group');
		
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
				
		$this->data['text_paymentmethods'] = $this->language->get('text_paymentmethods');
		
		$this->data['text_service_not_free'] = $this->language->get('text_service_not_free');
		
		$this->data['text_help'] = $this->language->get('text_help');
		$this->data['text_logos'] = $this->language->get('text_logos');		
		
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');		
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$this->load->model('localisation/language');
		
		$languages = $this->model_localisation_language->getLanguages();
		
		foreach ($languages as $language) {
			if (isset($this->error['bank_' . $language['language_id']])) {
				$this->data['error_bank_' . $language['language_id']] = $this->error['bank_' . $language['language_id']];
			} else {
				$this->data['error_bank_' . $language['language_id']] = '';
			}
		}
		
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/pp_pro', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=payment/epay&token=' . $this->session->data['token'];
		
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];
		
		if (isset($this->request->post['epay_payment_name'])) {
			$this->data['epay_payment_name'] = $this->request->post['epay_payment_name'];
		} else {
			if(strlen($this->config->get('epay_payment_name')) == 0){
				$this->data['epay_payment_name'] = 'ePay Payment Solutions';
			}else{
				$this->data['epay_payment_name'] = $this->config->get('epay_payment_name');
			}
			
		}
		
		if (isset($this->request->post['epay_merchant_number'])) {
			$this->data['epay_merchant_number'] = $this->request->post['epay_merchant_number'];
		} else {
			$this->data['epay_merchant_number'] = $this->config->get('epay_merchant_number');
		}
		
		if (isset($this->request->post['epay_order_status_id'])) {
			$this->data['epay_order_status_id'] = $this->request->post['epay_order_status_id'];
		} else {
			$this->data['epay_order_status_id'] = $this->config->get('epay_order_status_id'); 
		} 
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['epay_geo_zone_id'])) {
			$this->data['epay_geo_zone_id'] = $this->request->post['epay_geo_zone_id'];
		} else {
			$this->data['epay_geo_zone_id'] = $this->config->get('epay_geo_zone_id'); 
		} 
		
		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['epay_status'])) {
			$this->data['epay_status'] = $this->request->post['epay_status'];
		} else {
			$this->data['epay_status'] = $this->config->get('epay_status');
		}
		
		if (isset($this->request->post['epay_sort_order'])) {
			if(strlen($this->request->post['epay_sort_order']) == 0){
				$this->data['epay_sort_order'] = 1;	
			}else{
				$this->data['epay_sort_order'] = $this->request->post['epay_sort_order'];	
			}
		} else {
			if(strlen($this->config->get('epay_sort_order')) == 0){
				$this->data['epay_sort_order'] = 1;	
			}else{
				$this->data['epay_sort_order'] = $this->config->get('epay_sort_order');
			}
		}
		
		
		if (isset($this->request->post['epay_payment_window'])) {
			$this->data['epay_payment_window'] = $this->request->post['epay_payment_window'];
		} else {
			$this->data['epay_payment_window'] = $this->config->get('epay_payment_window');
		}
		
		
		if (isset($this->request->post['epay_md5key'])) {
			$this->data['epay_md5key'] = $this->request->post['epay_md5key'];
		} else {
			$this->data['epay_md5key'] = $this->config->get('epay_md5key');
		}
		
		
		if (isset($this->request->post['epay_group'])) {
			$this->data['epay_group'] = $this->request->post['epay_group'];
		} else {
			$this->data['epay_group'] = $this->config->get('epay_group');
		}
		
		if (isset($this->request->post['epay_authsms'])) {
			$this->data['epay_authsms'] = $this->request->post['epay_authsms'];
		} else {
			$this->data['epay_authsms'] = $this->config->get('epay_authsms');
		}
		
		if (isset($this->request->post['epay_authemail'])) {
			$this->data['epay_authemail'] = $this->request->post['epay_authemail'];
		} else {
			$this->data['epay_authemail'] = $this->config->get('epay_authemail');
		}
		
		if (isset($this->request->post['epay_instantcapture'])) {
			$this->data['epay_instantcapture'] = $this->request->post['epay_instantcapture'];
		} else {
			$this->data['epay_instantcapture'] = $this->config->get('epay_instantcapture');
		}
		
		if (isset($this->request->post['epay_ownreceipt'])) {
			$this->data['epay_ownreceipt'] = $this->request->post['epay_ownreceipt'];
		} else {
			$this->data['epay_ownreceipt'] = $this->config->get('epay_ownreceipt');
		}		
		
		$this->template = 'payment/epay.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/epay')) {
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