<?php
/*
 *	location: admin/controller
 */

class ControllerModuleDQuickcheckout extends Controller {
	protected $id = 'd_quickcheckout';
	private $route = 'module/d_quickcheckout';
	private $sub_versions = array('lite', 'light', 'free');
	private $mbooth = 'mbooth_d_quickcheckout';
	private $config_file = '';
	private $prefix = '';
	private $store_id = 0;
	private $error = array(); 
	

	public function index(){
  
  $this->load->model($this->route);

		$this->mbooth = $this->model_module_d_quickcheckout->getMboothFile($this->id, $this->sub_versions);

		$this->model_module_d_quickcheckout->installDatabase();

		$this->config_file = $this->model_module_d_quickcheckout->getConfigFile($this->id, $this->sub_versions);

		//dependencies
		$this->language->load($this->route);
		$this->load->model('setting/setting');
		$this->load->model('setting/extension');

		//save post
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			if(isset($this->request->get['setting_id'])){

				$this->model_module_d_quickcheckout->editSetting($this->request->get['setting_id'], $this->request->post[$this->id.'_setting']);
			}
			$this->model_setting_setting->editSetting($this->id, $this->request->post, $this->store_id);
			$this->session->data['success'] = $this->language->get('text_success'); 
			$this->response->redirect(html_entity_decode($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')));
			
		}

		// styles and scripts
  $this->document->addStyle('view/stylesheet/shopunity/bootstrap/bootstrap.css');
		$this->document->addStyle('view/stylesheet/shopunity/bootstrap.css');
		// sortable
// $this->document->addScript('view/javascript/shopunity/jquery-1.11.3.js');
		$this->document->addScript('view/javascript/shopunity/rubaxa-sortable/sortable.js');
		$this->document->addStyle('view/stylesheet/shopunity/rubaxa-sortable/sortable.css');
		$this->document->addScript('view/javascript/shopunity/tinysort/jquery.tinysort.min.js');
	
		// $this->document->addScript('view/javascript/shopunity/bootstrap-colorpicker/bootstrap-colorpicker.min.js');
		// $this->document->addStyle('view/stylesheet/shopunity/bootstrap-colorpicker/bootstrap-colorpicker.min.css');
	
		$this->document->addScript('view/javascript/shopunity/tinysort/jquery.tinysort.min.js');	
  	$this->document->addScript('view/javascript/shopunity/bootstrap/bootstrap.min.js');
		$this->document->addScript('view/javascript/shopunity/bootstrap-sortable.js');
		$this->document->addScript('view/javascript/shopunity/bootstrap-slider/js/bootstrap-slider.js');
		$this->document->addStyle('view/javascript/shopunity/bootstrap-slider/css/slider.css');
		$this->document->addScript('view/javascript/shopunity/bootstrap-switch/bootstrap-switch.min.js');
		$this->document->addStyle('view/stylesheet/shopunity/bootstrap-switch/bootstrap-switch.css');

		$this->document->addScript('view/javascript/shopunity/serializeObject/serializeObject.js');
		// $this->document->addStyle('view/stylesheet/d_social_login/styles.css');
		$this->document->addStyle('view/stylesheet/d_quickcheckout.css');

		
		// $this->document->addScript('view/javascript/shopunity/bootstrap-editable/bootstrap-editable.js');
		// $this->document->addStyle('view/stylesheet/shopunity/bootstrap-editable/bootstrap-editable.css');
		// Add more styles, links or scripts to the project is necessary
		// $this->document->addLink('//fonts.googleapis.com/css?family=PT+Sans:400,700,700italic,400italic&subset=latin,cyrillic-ext,latin-ext,cyrillic', "stylesheet");
		// $this->document->addStyle('view/stylesheet/shopunity/normalize.css');
		// $this->document->addScript('view/javascript/shopunity/tooltip/tooltip.js');


		$url = '';
		if(isset($this->request->get['store_id'])){
			$url .=  '&store_id='.$this->store_id;
		}

		if(isset($this->request->get['setting_id'])){
			$url .=  '&setting_id='.$this->request->get['setting_id'];

		}elseif($this->model_module_d_quickcheckout->getCurrentSettingId($this->id, $this->store_id)){
			$url .=  '&setting_id='. $this->model_module_d_quickcheckout->getCurrentSettingId($this->id, $this->store_id);
		}

		if(isset($this->request->get['config'])){
			$url .=  '&config='.$this->request->get['config'];
		}

		// Breadcrumbs
		$this->data['breadcrumbs'] = array(); 
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
			);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
			);

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_main'),
			'href' => $this->url->link($this->route, 'token=' . $this->session->data['token'] . $url, 'SSL')
			);

		// Notification
		foreach($this->error as $key => $error){
			$this->data['error'][$key] = $error;
		}

		// Heading
		$this->document->setTitle($this->language->get('heading_title_main'));
		$this->data['heading_title'] = $this->language->get('heading_title_main');
		$this->data['text_edit'] = $this->language->get('text_edit');
		
		// Variable
		$this->data['id'] = $this->id;
		$this->data['route'] = $this->route;
		$this->data['store_id'] = $this->store_id;
		$this->data['stores'] = $this->model_module_d_quickcheckout->getStores();
		$this->data['mbooth'] = $this->mbooth;
		$this->data['config'] = $this->config_file;
		$this->data['support_email'] = $this->model_module_d_quickcheckout->getMboothInfo($this->mbooth)->support_email;
		$this->data['version'] = $this->model_module_d_quickcheckout->getVersion($this->data['mbooth']);
		$this->data['token'] =  $this->session->data['token'];

		// Tab
		$this->data['tab_setting'] = $this->language->get('tab_setting');

		$this->data['text_home'] = $this->language->get('text_home');
		$this->data['text_general'] = $this->language->get('text_general');
		$this->data['text_login'] = $this->language->get('text_login');
		$this->data['text_payment_address'] = $this->language->get('text_payment_address');	
		$this->data['text_shipping_address'] = $this->language->get('text_shipping_address');
		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_cart'] = $this->language->get('text_cart');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_payment'] = $this->language->get('text_payment');
		$this->data['text_design'] = $this->language->get('text_design');
		$this->data['text_analytics'] = $this->language->get('text_analytics');

		// Button
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_save_and_stay'] = $this->language->get('button_save_and_stay');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_clear'] = $this->language->get('button_clear');
		$this->data['button_add'] = $this->language->get('button_add');
		$this->data['button_remove'] = $this->language->get('button_remove');

		// Text
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_enable'] = $this->language->get('text_enable');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_display'] = $this->language->get('text_display');
		$this->data['text_require'] = $this->language->get('text_require');
		$this->data['text_always_show'] = $this->language->get('text_always_show');
		$this->data['text_defualt'] = $this->language->get('text_defualt');
		$this->data['text_register'] = $this->language->get('text_register');
		$this->data['text_guest'] = $this->language->get('text_guest');
		$this->data['text_logged'] = $this->language->get('text_logged');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_input_radio'] = $this->language->get('text_input_radio');	
		$this->data['text_input_select'] = $this->language->get('text_input_select');
		$this->data['text_input_list'] = $this->language->get('text_input_list');
		$this->data['text_row'] = $this->language->get('text_row');
		$this->data['text_block'] = $this->language->get('text_block');
		$this->data['text_popup'] = $this->language->get('text_popup');
		$this->data['text_width'] = $this->language->get('text_width');
		$this->data['text_height'] = $this->language->get('text_height');
		$this->data['text_type'] = $this->language->get('text_type');
		$this->data['entry_new_field'] = $this->language->get('entry_new_field');
		$this->data['text_custom_field'] = $this->language->get('text_custom_field');
		$this->data['help_new_field'] = $this->language->get('help_new_field');
		$this->data['button_new_field'] = $this->language->get('button_new_field');
		$this->data['help_maskedinput'] = $this->language->get('help_maskedinput');
		$this->data['text_probability'] = $this->language->get('text_probability');
		$this->data['text_create_setting'] = $this->language->get('text_create_setting');
		$this->data['text_create_setting_heading'] = $this->language->get('text_create_setting_heading');
		$this->data['text_create_setting_probability'] = $this->language->get('text_create_setting_probability');

		//action
		$this->data['module_link'] = $this->url->link($this->route, 'token=' . $this->session->data['token'], 'SSL');
	 
		$this->data['action'] = $this->url->link($this->route, 'token=' . $this->session->data['token'] . $url, 'SSL');
 
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['add_field'] = $this->url->link('sale/custom_field/add', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['custom_field'] = $this->url->link('sale/custom_field', 'token=' . $this->session->data['token'], 'SSL');
		//update
		$this->data['entry_update'] = sprintf($this->language->get('entry_update'), $this->data['version']);
		$this->data['button_update'] = $this->language->get('button_update');
		$this->data['update'] = str_replace('&amp;', '&', $this->url->link($this->route.'/getUpdate', 'token=' . $this->session->data['token'], 'SSL'));
		
		//debug
		$this->data['tab_debug'] = $this->language->get('tab_debug');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_debug_file'] = $this->language->get('entry_debug_file');
		$this->data['clear_debug_file'] = $this->model_module_d_quickcheckout->ajax($this->url->link($this->route.'/clearDebugFile', 'token=' . $this->session->data['token'], 'SSL'));
		
		//support
		$this->data['tab_support'] = $this->language->get('tab_support');
		$this->data['text_support'] = $this->language->get('text_support');
		$this->data['entry_support'] = $this->language->get('entry_support');
		$this->data['button_support_email'] = $this->language->get('button_support_email');				
		
		//instruction
		$this->data['tab_instruction'] = $this->language->get('tab_instruction');
		$this->data['text_instruction'] = $this->language->get('text_instruction');

		// Home
		$this->data['text_intro_home'] = $this->language->get('text_intro_home');
		$this->data['text_intro_general'] = $this->language->get('text_intro_general');
		$this->data['text_intro_login'] = $this->language->get('text_intro_login');
		$this->data['text_intro_payment_address'] = $this->language->get('text_intro_payment_address');
		$this->data['text_intro_shipping_address'] = $this->language->get('text_intro_shipping_address');
		$this->data['text_intro_shipping_method'] = $this->language->get('text_intro_shipping_method');
		$this->data['text_intro_payment_method'] = $this->language->get('text_intro_payment_method');
		$this->data['text_intro_confirm'] = $this->language->get('text_intro_confirm');
		$this->data['text_intro_design'] = $this->language->get('text_intro_design');
		$this->data['text_intro_plugins'] = $this->language->get('text_intro_plugins');
		$this->data['text_intro_analytics'] = $this->language->get('text_intro_analytics');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['help_name'] = $this->language->get('help_name');
		$this->data['entry_enable'] = $this->language->get('entry_enable');
		$this->data['help_enable'] = $this->language->get('help_enable');
		$this->data['entry_trigger'] = $this->language->get('entry_trigger');
		$this->data['help_trigger'] = $this->language->get('help_trigger');
		$this->data['help_average_time'] = $this->language->get('help_average_time');
		$this->data['help_average_rating'] = $this->language->get('help_average_rating');
		$this->data['text_intro_create_setting'] = $this->language->get('text_intro_create_setting');

		// General
		$this->data['entry_general_default_option'] = $this->language->get('entry_general_default_option');
		$this->data['help_general_default_option'] = $this->language->get('help_general_default_option');
		$this->data['entry_general_main_checkout'] = $this->language->get('entry_general_main_checkout');
		$this->data['help_general_main_checkout'] = $this->language->get('help_general_main_checkout');
		$this->data['entry_general_clear_session'] = $this->language->get('entry_general_clear_session');
		$this->data['help_general_clear_session'] = $this->language->get('help_general_clear_session');
		$this->data['entry_general_login_refresh'] = $this->language->get('entry_general_login_refresh');
		$this->data['help_general_login_refresh'] = $this->language->get('help_general_login_refresh');
		$this->data['entry_general_default_email'] = $this->language->get('entry_general_default_email');
		$this->data['help_general_default_email'] = $this->language->get('help_general_default_email');
		$this->data['entry_general_min_order'] = $this->language->get('entry_general_min_order');
		$this->data['help_general_min_order'] = $this->language->get('help_general_min_order');
		$this->data['text_value_min_order'] = $this->language->get('text_value_min_order');
		$this->data['entry_general_min_quantity'] = $this->language->get('entry_general_min_quantity');
		$this->data['help_general_min_quantity'] = $this->language->get('help_general_min_quantity');
		$this->data['text_value_min_quantity'] = $this->language->get('text_value_min_quantity');
		$this->data['entry_delete_setting'] = $this->language->get('entry_delete_setting');
		$this->data['text_confirm_delete_setting'] = $this->language->get('text_confirm_delete_setting');
		$this->data['button_delete_setting'] = $this->language->get('button_delete_setting');	
		$this->data['entry_config_files'] = $this->language->get('entry_config_files');
		$this->data['entry_action_bulk_setting'] = $this->language->get('entry_action_bulk_setting');
		$this->data['help_action_bulk_setting'] = $this->language->get('help_action_bulk_setting');
		$this->data['entry_bulk_setting'] = $this->language->get('entry_bulk_setting');
		$this->data['help_bulk_setting'] = $this->language->get('help_bulk_setting');
		$this->data['button_create_bulk_setting'] = $this->language->get('button_create_bulk_setting');
		$this->data['button_save_bulk_setting'] = $this->language->get('button_save_bulk_setting');
		$this->data['entry_general_analytics_event'] = $this->language->get('entry_general_analytics_event');
		$this->data['help_general_analytics_event'] = $this->language->get('help_general_analytics_event');
		
		//social login
		$this->data['text_social_login_required'] = $this->language->get('text_social_login_required');
		// $this->data['entry_socila_login_style'] = $this->language->get('entry_socila_login_style');
		// $this->data['help_socila_login_style'] = $this->language->get('help_socila_login_style');
		$this->data['entry_social_login'] = $this->language->get('entry_social_login');
		$this->data['help_social_login'] = $this->language->get('help_social_login');
		$this->data['text_icons'] = $this->language->get('text_icons');
		$this->data['text_small'] = $this->language->get('text_small');
		$this->data['text_medium'] = $this->language->get('text_medium');		
		$this->data['text_large'] = $this->language->get('text_large');
		$this->data['text_huge'] = $this->language->get('text_huge');
		$this->data['button_social_login_edit'] = $this->language->get('button_social_login_edit');
		$this->data['link_social_login_edit'] = $this->url->link('module/d_social_login', 'token=' . $this->session->data['token'] . '&store_id='.$this->store_id, 'SSL');
		
		//Payment address
		$this->data['entry_payment_address_display'] = $this->language->get('entry_payment_address_display');
		$this->data['help_payment_address_display'] = $this->language->get('help_payment_address_display');

		//Shipping address
		$this->data['entry_shipping_address_display'] = $this->language->get('entry_shipping_address_display');
		$this->data['help_shipping_address_display'] = $this->language->get('help_shipping_address_display');
		
		//Shipping method
		$this->data['entry_shipping_method_display'] = $this->language->get('entry_shipping_method_display');	
		$this->data['help_shipping_method_display'] = $this->language->get('help_shipping_method_display');
		$this->data['entry_shipping_method_display_options'] = $this->language->get('entry_shipping_method_display_options');
		$this->data['help_shipping_method_display_options'] = $this->language->get('help_shipping_method_display_options');	
		$this->data['entry_shipping_method_display_title'] = $this->language->get('entry_shipping_method_display_title');
		$this->data['help_shipping_method_display_title'] = $this->language->get('help_shipping_method_display_title');	
		$this->data['entry_shipping_method_input_style'] = $this->language->get('entry_shipping_method_input_style');	
		$this->data['help_shipping_method_input_style'] = $this->language->get('help_shipping_method_input_style');
		$this->data['entry_shipping_method_default_option'] = $this->language->get('entry_shipping_method_default_option');
		$this->data['help_shipping_method_default_option'] = $this->language->get('help_shipping_method_default_option');
		
		//Payment method
		$this->data['entry_payment_method_display'] = $this->language->get('entry_payment_method_display');
		$this->data['help_payment_method_display'] = $this->language->get('help_payment_method_display');
		$this->data['entry_payment_method_display_options'] = $this->language->get('entry_payment_method_display_options');
		$this->data['help_payment_method_display_options'] = $this->language->get('help_payment_method_display_options');
		$this->data['entry_payment_method_display_images'] = $this->language->get('entry_payment_method_display_images');
		$this->data['help_payment_method_display_images'] = $this->language->get('help_payment_method_display_images');
		$this->data['entry_payment_method_display_title'] = $this->language->get('entry_payment_method_display_title');
		$this->data['help_payment_method_display_title'] = $this->language->get('help_payment_method_display_title');
		$this->data['entry_payment_method_input_style'] = $this->language->get('entry_payment_method_input_style');
		$this->data['help_payment_method_input_style'] = $this->language->get('help_payment_method_input_style');
		$this->data['entry_payment_method_default_option'] = $this->language->get('entry_payment_method_default_option');
		$this->data['help_payment_method_default_option'] = $this->language->get('help_payment_method_default_option');
		
		//Cart
		$this->data['entry_cart_display'] = $this->language->get('entry_cart_display');
		$this->data['help_cart_display'] = $this->language->get('help_cart_display');
		$this->data['entry_cart_columns_image'] = $this->language->get('entry_cart_columns_image');
		$this->data['entry_cart_columns_name'] = $this->language->get('entry_cart_columns_name');
		$this->data['entry_cart_columns_model'] = $this->language->get('entry_cart_columns_model');
		$this->data['entry_cart_columns_quantity'] = $this->language->get('entry_cart_columns_quantity');
		$this->data['entry_cart_columns_price'] = $this->language->get('entry_cart_columns_price');
		$this->data['entry_cart_columns_total'] = $this->language->get('entry_cart_columns_total');
		$this->data['entry_cart_option_coupon'] = $this->language->get('entry_cart_option_coupon');
		$this->data['help_cart_option_coupon'] = $this->language->get('help_cart_option_coupon');
		$this->data['entry_cart_option_voucher'] = $this->language->get('entry_cart_option_voucher');
		$this->data['help_cart_option_voucher'] = $this->language->get('help_cart_option_voucher');
		$this->data['entry_cart_option_reward'] = $this->language->get('entry_cart_option_reward');
		$this->data['help_cart_option_reward'] = $this->language->get('help_cart_option_reward');

		//Design
		$this->data['entry_design_theme'] = $this->language->get('entry_design_theme');
		$this->data['help_design_theme'] = $this->language->get('help_design_theme');
		$this->data['entry_design_field'] = $this->language->get('entry_design_field');
		$this->data['help_design_field'] = $this->language->get('help_design_field');
		$this->data['entry_design_placeholder'] = $this->language->get('entry_design_placeholder');
		$this->data['help_design_placeholder'] = $this->language->get('help_design_placeholder');
		$this->data['entry_design_login_option'] = $this->language->get('entry_design_login_option');
		$this->data['help_design_login_option'] = $this->language->get('help_design_login_option');
		$this->data['entry_design_login'] = $this->language->get('entry_design_login');
		$this->data['help_design_login'] = $this->language->get('help_design_login');
		$this->data['entry_design_address'] = $this->language->get('entry_design_address');
		$this->data['help_design_address'] = $this->language->get('help_design_address');
		$this->data['entry_design_cart_image_size'] = $this->language->get('entry_design_cart_image_size');
		$this->data['help_design_cart_image_size'] = $this->language->get('help_design_cart_image_size');
		$this->data['entry_design_max_width'] = $this->language->get('entry_design_max_width');
		$this->data['help_design_max_width'] = $this->language->get('help_design_max_width');
		$this->data['entry_design_bootstrap'] = $this->language->get('entry_design_bootstrap');
		$this->data['help_design_bootstrap'] = $this->language->get('help_design_bootstrap');	
		$this->data['entry_design_only_d_quickcheckout'] = $this->language->get('entry_design_only_d_quickcheckout');
		$this->data['help_design_only_d_quickcheckout'] = $this->language->get('help_design_only_d_quickcheckout');
		$this->data['entry_design_column'] = $this->language->get('entry_design_column');
		$this->data['help_design_column'] = $this->language->get('help_design_column');
		$this->data['help_login'] = $this->language->get('help_login');
		$this->data['help_payment_address'] = $this->language->get('help_payment_address');
		$this->data['help_shipping_address'] = $this->language->get('help_shipping_address');
		$this->data['help_shipping_method'] = $this->language->get('help_shipping_method');
		$this->data['help_payment_method'] = $this->language->get('help_payment_method');
		$this->data['help_cart'] = $this->language->get('help_cart');
		$this->data['help_payment'] = $this->language->get('help_payment');
		$this->data['help_confirm'] = $this->language->get('help_confirm');
		$this->data['entry_design_custom_style'] = $this->language->get('entry_design_custom_style');
		$this->data['help_design_custom_style'] = $this->language->get('help_design_custom_style');

		//statistic
		$this->data['column_order_id'] = $this->language->get('column_order_id');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_account'] = $this->language->get('column_account');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_data'] = $this->language->get('column_data');
		$this->data['column_checkout_time'] = $this->language->get('column_checkout_time');
		$this->data['column_rating'] = $this->language->get('column_rating');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->session->data['error'])) {
			$this->data['error']['warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}

		//get currant setting
		$this->data[$this->id.'_status'] = $this->model_module_d_quickcheckout->getConfigData($this->id, $this->id.'_status', $this->store_id, $this->config_file);
		$this->data['debug'] = $this->model_module_d_quickcheckout->getConfigData($this->id, $this->id.'_debug', $this->store_id, $this->config_file);
		$this->data['debug_file'] = $this->model_module_d_quickcheckout->getConfigData($this->id, $this->id.'_debug_file', $this->store_id, $this->config_file);
		$this->data['setting'] = $this->model_module_d_quickcheckout->getConfigSetting($this->id, $this->id.'_setting', $this->store_id, $this->config_file);
		$this->data[$this->id.'_trigger'] = $this->model_module_d_quickcheckout->getConfigData($this->id, $this->id.'_trigger', $this->store_id, $this->config_file);
			
		//language for fields
		$this->data['setting'] = $this->model_module_d_quickcheckout->languageFilter($this->data['setting']);

				
		if($this->data['debug']){
			$this->data['debug_log'] = $this->model_module_d_quickcheckout->getFileContents(DIR_LOGS.$this->data['debug_file']);
		}else{
			$this->data['debug_log'] = '';
		}

		//get all settings
		$this->data['settings'] = $this->model_module_d_quickcheckout->getSettings($this->store_id, true);
		foreach($this->data['settings'] as $key => $setting){
			$this->data['settings'][$key]['href'] = HTTP_CATALOG.'index.php?route=checkout/checkout&setting_id='.$setting['setting_id'];
		}
		
		$this->data['setting_id'] = $this->model_module_d_quickcheckout->getCurrentSettingId($this->id, $this->store_id);			        	
		$this->data['create_setting'] = $this->model_module_d_quickcheckout->ajax($this->url->link($this->route.'/createSetting', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		$this->data['delete_setting'] = $this->model_module_d_quickcheckout->ajax($this->url->link($this->route.'/deleteSetting', 'setting_id='.$this->data['setting_id'].'&token=' . $this->session->data['token'] . $url, 'SSL'));
		$this->data['save_bulk_setting'] = $this->model_module_d_quickcheckout->ajax($this->url->link($this->route.'/saveBulkSetting', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		$this->data['setting_cycle'] = $this->config->get($this->id.'_setting_cycle');
		$this->data['setting_name'] = $this->model_module_d_quickcheckout->getSettingName($this->data['setting_id']);

		$this->data['options'] = array('guest' , 'register' , 'logged');
		//get config 
		$this->data['config_files'] = $this->model_module_d_quickcheckout->getConfigFiles($this->id);
	
		//Get Shipping methods
		$this->data['shipping_methods'] = $this->model_module_d_quickcheckout->getShippingMethods();

		//Get Payment methods
		$this->data['payment_methods'] = $this->model_module_d_quickcheckout->getPaymentMethods();
		
		//Get designes
		$this->data['themes'] = $this->model_module_d_quickcheckout->getThemes();
		
		//Get stores
		$this->data['stores'] = $this->model_module_d_quickcheckout->getStores();
		
		//Social login
		$this->data['social_login'] = $this->model_module_d_quickcheckout->isInstalled('d_social_login');

		//Statistic
		$this->data['statistics'] = $this->model_module_d_quickcheckout->getStatistics($this->data['setting_id']);
		foreach($this->data['statistics'] as $key => $value){
			$this->data['statistics'][$key]['total'] = $this->currency->format($value['total'], $value['currency_code'], $value['currency_value']);
			$this->data['statistics'][$key]['rating'] = round($value['rating'] * 100) . '%';
 
			if($value['customer_id']){
				$this->data['statistics'][$key]['href_customer'] = $this->url->link('sale/customer/edit', 'token=' . $this->session->data['token'] . '&customer_id=' . $value['customer_id'], 'SSL');
			}else{
				$this->data['statistics'][$key]['href_customer'] = '';
			}
		}
		//steps
		foreach($this->data['setting']['step'] as $step => $value){
			if(isset($value['column'])){
				$this->data['steps'][$step] = array('column' => $value['column'], 'row' => $value['row']);
			}	
		}

		$sort_order = array(); 
		foreach ($this->data['steps'] as $key => $value) {

      			$sort_order[$key]['column'] = $value['column'];
      			$sort_order[$key]['row'] = $value['row'];
    	}
		array_multisort($sort_order, SORT_ASC, $this->data['steps'] );

		//languages
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

    
        $this->template = 'module/d_quickcheckout.tpl';
				$this->children = array(
    'common/d_quickcheckout_header',
			'common/footer'
		);
 // $this->data['header'] = $this->getHeader();
				
		$this->response->setOutput($this->render());
   	}
 
   	/**

	Add Assisting functions here 

	 **/

	public function createSetting(){
     		$this->load->model($this->route);
		$json = array();
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$setting_name = date('m/d/Y h:i:s a', time());
			$setting_id = $this->model_module_d_quickcheckout->setSetting($setting_name, $this->request->post[$this->id.'_setting'], $this->store_id);
		}
		$this->load->language($this->route);
		if($setting_id){
			$this->session->data['success'] = $this->language->get('success_setting_created');
			$json['redirect'] = $this->model_module_d_quickcheckout->ajax($this->url->link($this->route, 'store_id='.$this->store_id.'&setting_id='.$setting_id.'&token=' . $this->session->data['token'], 'SSL'));
		}else{
			$json['error'] = $this->language->get('error_setting_not_created');
		}
		
		$this->response->setOutput(json_encode($json));
	}

	public function deleteSetting(){
			$this->load->model($this->route);
		

		if (($this->request->server['REQUEST_METHOD'] == 'GET') && $this->validate() && isset($this->request->get['setting_id']) ) {
			
			$this->model_module_d_quickcheckout->deleteSetting($this->request->get['setting_id']);
			$this->session->data['success'] = $this->language->get('success_setting_deleted');
			$this->response->redirect($this->url->link($this->route, 'store_id='.$this->store_id.'&token=' . $this->session->data['token'], 'SSL'));
		}else{
			$setting_id = $this->request->get['setting_id'];
			$this->session->data['error'] = $this->language->get('error_setting_not_deleted');
			$this->response->redirect($this->model_module_d_quickcheckout->ajax($this->url->link($this->route, 'store_id='.$this->store_id.'&setting_id='.$setting_id.'&token=' . $this->session->data['token'], 'SSL')));
		}
			
	}

	public function saveBulkSetting(){

		$json = array();
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate() && !empty($this->request->post['setting'])) {
			$setting_id = $this->request->post['setting_id'];
			$setting = json_decode(html_entity_decode($this->request->post['setting']), true);
			$this->model_module_d_quickcheckout->editSetting($setting_id, $setting);
			$json['data'] = $setting;
			
		}
		$this->load->language($this->route);
		if(isset($setting_id)){
			$this->session->data['success'] = $this->language->get('success_setting_saved');
			$json['redirect'] = $this->model_module_d_quickcheckout->ajax($this->url->link($this->route, 'store_id='.$this->store_id.'&setting_id='.$setting_id.'&token=' . $this->session->data['token'], 'SSL'));
		}else{
			$json['error'] = $this->language->get('error_setting_not_saved');
		}
		
		$this->response->setOutput(json_encode($json));
	}

	private function validate($permission = 'modify') {

		$this->language->load($this->route);
		
		if (!$this->user->hasPermission($permission, $this->route)) {
			$this->error['warning'] = $this->language->get('error_permission');
			return false;
		}

		if(isset($this->request->post['config'])){
			return false;
		}

		return true;
	}

	public function install() {
		$this->load->model('module/d_quickcheckout');
  
  $this->model_module_d_quickcheckout->deleteOldVersion();
  
		$this->model_module_d_quickcheckout->setVqmod('a_vqmod_d_quickcheckout.xml', 1);

		$this->model_module_d_quickcheckout->installDatabase();

		$this->model_module_d_quickcheckout->installDependencies($this->mbooth);

		$this->getUpdate(1);	  
	}

	public function uninstall() {
		$this->load->model('module/d_quickcheckout');
		$this->model_module_d_quickcheckout->setVqmod('a_vqmod_d_quickcheckout.xml', 0);	

		$this->model_module_d_quickcheckout->uninstallDatabase();

		$this->getUpdate(0);	  
	}

	

	/*
	*	Ajax: clear debug file.
	*/

	public function clearDebugFile() {
		$this->load->language($this->route);
		$json = array();

		if (!$this->user->hasPermission('modify', $this->route)) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$file = DIR_LOGS.$this->request->post['debug_file'];

			$handle = fopen($file, 'w+');

			fclose($handle);

			$json['success'] = $this->language->get('success_clear_debug_file');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));

	}

	/*
	*	Ajax: Get the update information on this module. 
	*/
	public function getZone(){
        $this->load->model('module/d_quickcheckout');
        $json = $this->model_module_d_quickcheckout->getZonesByCountryId($this->request->get['country_id']);
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

	public function getUpdate($status = 1){
		if($status !== 0){	$status = 1; }

		$json = array();

		$this->load->language($this->route);
		$this->load->model($this->route);

		$current_version = $this->model_module_d_quickcheckout->getVersion($this->mbooth);
		$info = $this->model_module_d_quickcheckout->getUpdateInfo($this->mbooth, $status);

		if ($info['code'] == 200) {
			$this->data = simplexml_load_string($info['data']);

			if ((string) $this->data->version == (string) $current_version 
				|| (string) $this->data->version <= (string) $current_version) 
			{
				$json['success']   = $this->language->get('success_no_update') ;
			} 
			elseif ((string) $this->data->version > (string) $current_version) 
			{
				$json['warning']   = $this->language->get('warning_new_update');

				foreach($this->data->updates->update as $update)
				{
					if((string) $update->attributes()->version > (string)$current_version)
					{
						$version = (string)$update->attributes()->version;
						$json['update'][$version] = (string) $update[0];
					}
				}
			} 
			else 
			{
				$json['error']   = $this->language->get('error_update');
			}
		} 
		else 
		{ 
			$json['error']   =  $this->language->get('error_failed');
		}

		$this->response->setOutput(json_encode($json));
	}

}
 