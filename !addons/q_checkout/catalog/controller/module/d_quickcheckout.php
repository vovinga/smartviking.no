<?php
class ControllerModuleDQuickcheckout extends Controller {
    protected $id = 'd_quickcheckout';
    private $route = 'module/d_quickcheckout';
    private $sub_versions = array('lite', 'light', 'free');
    private $mbooth = '';
    private $config_file = '';
    private $prefix = '';
    private $error = array(); 
    private $debug = false;
    //private $scripts = array();
    private $setting = array();
    private $current_setting_id = '';

    public function __construct($registry) {
        parent::__construct($registry);

        $this->load->model('module/d_quickcheckout');
        $this->load->model('d_quickcheckout/address');
        $this->load->model('d_quickcheckout/method');
        $this->load->model('d_quickcheckout/order');
        $this->load->model('d_quickcheckout/custom_field');
        $this->load->model('account/address');

        $this->mbooth = $this->model_module_d_quickcheckout->getMboothFile($this->id, $this->sub_versions);

        $this->config_file = $this->model_module_d_quickcheckout->getConfigFile($this->id, $this->sub_versions);
	 
        $this->current_setting_id = $this->model_module_d_quickcheckout->getCurrentSettingId($this->id, $this->config->get('config_store_id'));
    }

    public function index() {
        //if(!$this->config->get('d_quickcheckout_status')){
         //   return false;
      //  }
		$this->debug = $this->config->get('d_quickcheckout_status');
       
        $this->initialize();
         

        $this->model_module_d_quickcheckout->logWrite('Load:: Styles and Scripts', $this->debug);

        if($this->setting['design']['bootstrap']){
            $this->document->addStyle('catalog/view/theme/default/stylesheet/d_quickcheckout/bootstrap.css');
        }
        $this->document->addStyle('catalog/view/javascript/font-awesome/css/font-awesome.min.css'); 
        $this->document->addStyle('catalog/view/theme/default/stylesheet/d_quickcheckout/d_quickcheckout.css');
        $this->document->addStyle('catalog/view/theme/default/stylesheet/d_quickcheckout/theme/'.$this->setting['design']['theme'].'.css');
        $this->document->addScript('catalog/view/javascript/d_quickcheckout/library/jquery-validate/jquery.validate.min.js');
        $this->document->addScript('catalog/view/javascript/d_quickcheckout/library/jquery-maskedinput/jquery.maskedinput.min.js');
        $this->document->addScript('catalog/view/javascript/d_quickcheckout/library/underscore/underscore-min.js');
        $this->document->addScript('catalog/view/javascript/d_quickcheckout/library/backbone/backbone-min.js');
        $this->document->addScript('catalog/view/javascript/d_quickcheckout/library/backbone-nested/backbone-nested.js');
        $this->document->addScript('catalog/view/javascript/d_quickcheckout/library/backbone/backbone.validation.min.js');
        $this->document->addScript('catalog/view/javascript/d_quickcheckout/main.js');
        $this->document->addScript('catalog/view/javascript/d_quickcheckout/engine/model.js');
        $this->document->addScript('catalog/view/javascript/d_quickcheckout/engine/view.js');

        $this->data['json_config'] = json_encode($this->setting);
        $this->data['config'] = $this->setting;
        
        $this->model_module_d_quickcheckout->logWrite('Load:: Login', $this->debug);
        $this->data['login'] = $this->getChild('d_quickcheckout/login', $this->setting);
		
        $this->model_module_d_quickcheckout->logWrite('Load:: Field ', $this->debug);
        $this->data['field'] = $this->getChild('d_quickcheckout/field');
		
        $this->model_module_d_quickcheckout->logWrite('Load:: Payment Address', $this->debug);
        $this->data['payment_address'] = $this->getChild('d_quickcheckout/payment_address', $this->setting);

      
        $this->model_module_d_quickcheckout->logWrite('Load:: Shipping Address', $this->debug);
        $this->data['shipping_address'] = $this->getChild('d_quickcheckout/shipping_address', $this->setting);
		
		
        	$this->model_module_d_quickcheckout->logWrite('Load:: Shipping Method', $this->debug);
        $this->data['shipping_method'] = $this->getChild('d_quickcheckout/shipping_method', $this->setting);
		

        	$this->model_module_d_quickcheckout->logWrite('Load:: Ppayment_method', $this->debug);
        $this->data['payment_method'] = $this->getChild('d_quickcheckout/payment_method', $this->setting);
            
        $this->model_module_d_quickcheckout->logWrite('Load:: Cart', $this->debug);
        $this->data['cart'] = $this->getChild('d_quickcheckout/cart', $this->setting);
		
 
        $this->model_module_d_quickcheckout->logWrite('Load:: Payment View', $this->debug);
        $this->data['payment'] = $this->getChild('d_quickcheckout/payment', $this->setting);
		
      
        $this->model_module_d_quickcheckout->logWrite('Load:: Confirm', $this->debug);
        $this->data['confirm'] = $this->getChild('d_quickcheckout/confirm', $this->setting);

      
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/d_quickcheckout.tpl')) { 
           $this->template = $this->config->get('config_template') . '/template/module/d_quickcheckout.tpl';
        } else {
               $this->template = 'default/template/module/d_quickcheckout.tpl';
          }
         
   return  $this->render();
   
    }

     
    public function initialize(){

        $this->data = $this->model_module_d_quickcheckout->getConfigSetting($this->id, $this->id.'_setting', $this->config->get('config_store_id'), $this->config_file);
     
        $this->model_module_d_quickcheckout->logWrite('ControllerModuleDQuickcheckout Start...', $this->debug);

        $this->model_module_d_quickcheckout->logWrite('Initialize:: current_setting_id = '.$this->current_setting_id, $this->debug);

        $this->model_module_d_quickcheckout->logWrite('Initialize:: getConfigData('.$this->id.', '. $this->id.'_setting' .', '.$this->config->get('config_store_id').', '.$this->config_file .') = ' . serialize($this->data), $this->debug);


        //prepare config data
        $this->data['step']['payment_address']['fields']['country_id']['options'] = $this->model_d_quickcheckout_address->getCountries();
        $this->data['step']['payment_address']['fields']['zone_id']['options'] = $this->model_d_quickcheckout_address->getZonesByCountryId($this->model_d_quickcheckout_address->getPaymentAddressCountryId());
        $this->data['step']['payment_address']['fields']['customer_group_id']['options'] = $this->model_d_quickcheckout_address->getCustomerGroups();
        $this->data['step']['shipping_address']['fields']['country_id']['options'] = $this->model_d_quickcheckout_address->getCountries();
        $this->data['step']['shipping_address']['fields']['zone_id']['options'] = $this->model_d_quickcheckout_address->getZonesByCountryId($this->model_d_quickcheckout_address->getShippingAddressCountryId());

        foreach($this->data['account'] as $account => $account_data){
            $this->data['account'][$account] =  $this->model_module_d_quickcheckout->array_merge_r_d($account_data, $this->data['step']);
        }

        $this->model_module_d_quickcheckout->logWrite('Initialize:: prepare setting for accounts', $this->debug);

        $field_count = array(
            'guest' => array('payment_address' => 0, 'shipping_address' => 0, 'confirm' => 0),
            'register' => array('payment_address' => 0, 'shipping_address' => 0, 'confirm' => 0),
            'logged' => array('payment_address' => 0, 'shipping_address' => 0, 'confirm' => 0)
        );
        foreach($this->data['account'] as $account => $account_data){
            foreach($this->data['account'][$account]['payment_address']['fields'] as $field){
                if(isset($field['display']) && $field['display']){
                    $field_count[$account]['payment_address'] += 1;
                }   
            }
            foreach($this->data['account'][$account]['shipping_address']['fields'] as $field){
                if(isset($field['display']) && $field['display']){
                    $field_count[$account]['shipping_address'] += 1;
                }   
            }
            foreach($this->data['account'][$account]['confirm']['fields'] as $field){
                if(isset($field['display']) && $field['display']){
                    $field_count[$account]['confirm'] += 1;
                }   
            }
        }

        $this->model_module_d_quickcheckout->logWrite('Initialize:: count fields for statistics', $this->debug);
 
        $this->load->language('module/d_quickcheckout');
        $this->load->language('checkout/checkout');
        $this->data = $this->model_module_d_quickcheckout->languageFilter($this->data);
        $this->model_module_d_quickcheckout->logWrite('Initialize:: prepare languages', $this->debug);
        // check for different versions.
        foreach($this->data['account'] as $account => $account_data){
            $this->data['account'][$account]['payment_address']['fields']['newsletter']['title'] = sprintf($account_data['payment_address']['fields']['newsletter']['title'], $this->config->get('config_name'));
        }
        $this->data['trigger'] = $this->model_module_d_quickcheckout->getConfigData($this->id, $this->id.'_trigger', $this->config->get('config_store_id'), $this->config_file);
        $this->data['general']['debug'] = $this->model_module_d_quickcheckout->getConfigData($this->id, $this->id.'_debug', $this->config->get('config_store_id'), $this->config_file);


        $this->model_module_d_quickcheckout->logWrite('Initialize:: prepare setting and session->data[d_quickcheckout]', $this->debug);

        //prepare session data
        if($this->customer->isLogged()){
            $this->session->data['account'] = 'logged';
           $this->session->data['payment_address']['newsletter'] = $this->setSessionValue('newsletter','payment_address', $this->data, $account, false);
            
        }else{
            $this->session->data['account'] = (!empty($this->session->data['account']) && $this->session->data['account'] !== 'logged') ? $this->session->data['account'] : $this->data['step']['login']['default_option'];
        }

        $account = $this->session->data['account'];

        unset($this->data['step']);

        $this->session->data['d_quickcheckout'] = $this->data;
        $this->setting = $this->data; 

        $this->model_module_d_quickcheckout->logWrite('Initialize:: set $this->session->data[account] = ' . $this->session->data['account'], $this->debug);

         $customer_group_id = (!empty($this->session->data['payment_address']['customer_group_id'])) ? $this->session->data['payment_address']['customer_group_id'] : $this->config->get('config_customer_group_id');
        
          if($this->setting['general']['clear_session']){
            $this->session->data['guest'] = array(
                'customer_group_id' => $this->config->get('config_customer_group_id'),
                'firstname' => $this->setSessionValue('firstname','payment_address', $this->data, $account, false),
                'lastname' => $this->setSessionValue('lastname','payment_address', $this->data, $account, false),
                'email' => $this->setSessionValue('email','payment_address', $this->data, $account, false),
                'password' => $this->setSessionValue('password','payment_address', $this->data, $account, false),
                'telephone' => $this->setSessionValue('telephone','payment_address', $this->data, $account, false),
                'fax' => $this->setSessionValue('fax','payment_address', $this->data, $account, false),
                'custom_field' => $this->model_d_quickcheckout_custom_field->setCustomFieldsDefaultSessionData('account', $customer_group_id ),
                'shipping_address' => $this->setSessionValue('shipping_address','payment_address', $this->data, $account, false),
            );
            $this->session->data['payment_address'] = array(
                'firstname' => $this->setSessionValue('firstname','payment_address', $this->data, $account, false),
                'lastname' => $this->setSessionValue('lastname','payment_address', $this->data, $account, false),
                'email' => $this->setSessionValue('email','payment_address', $this->data, $account, false),
                'email_confirm' => '',
                'telephone' => $this->setSessionValue('telephone','payment_address', $this->data, $account, false),
                'fax' => $this->setSessionValue('fax','payment_address', $this->data, $account, false),
                'password' => $this->setSessionValue('password','payment_address', $this->data, $account, false),
                'confirm' => '',
                'customer_group_id' => $this->config->get('config_customer_group_id'),
                'company' => $this->setSessionValue('company','payment_address', $this->data, $account, false),
                 'company_id' => $this->setSessionValue('company_id','payment_address', $this->data, $account, false),
                 'tax_id' => $this->setSessionValue('tax_id','payment_address', $this->data, $account, false),
                'address_1' => $this->setSessionValue('address_1','payment_address', $this->data, $account, false),
                'address_2' => $this->setSessionValue('address_2','payment_address', $this->data, $account, false),
                'postcode' => $this->setSessionValue('postcode','payment_address', $this->data, $account, false),
                'city' => $this->setSessionValue('city','payment_address', $this->data, $account, false),
                'country_id' => $this->setSessionValue('country_id','payment_address', $this->data, $account, false),
                'zone_id' => $this->setSessionValue('zone_id','payment_address', $this->data, $account, false),
                'country' => '',
                'iso_code_2' => '',
                'iso_code_3' => '',
                'address_format' => '',
                'custom_field' => '',
                'zone' => '',
                'zone_code' => '',
                'agree' => $this->setSessionValue('agree','payment_address', $this->data, $account, false),
                'shipping_address' => $this->setSessionValue('shipping_address','payment_address', $this->data, $account, false),
                'newsletter' => $this->setSessionValue('newsletter','payment_address', $this->data, $account, false),
               // 'address_id' => $this->customer->getAddressId(),
            );
            $this->session->data['shipping_address'] = array(
                'firstname' => $this->setSessionValue('firstname','shipping_address', $this->data, $account, false),
                'lastname' => $this->setSessionValue('lastname','shipping_address', $this->data, $account, false),
                'company' => $this->setSessionValue('company','shipping_address', $this->data, $account, false),
                'address_1' => $this->setSessionValue('address_1','shipping_address', $this->data, $account, false),
                'address_2' => $this->setSessionValue('address_2','shipping_address', $this->data, $account, false),
                'postcode' => $this->setSessionValue('postcode','shipping_address', $this->data, $account, false),
                'city' => $this->setSessionValue('city','shipping_address', $this->data, $account, false),
                'country_id' => $this->setSessionValue('country_id','shipping_address', $this->data, $account, false),
                'zone_id' => $this->setSessionValue('zone_id','shipping_address', $this->data, $account, false),
                'country' => '',
                'iso_code_2' => '',
                'iso_code_3' => '',
                'address_format' => '',
                //'custom_field' => '',
                'zone' => '',
                'zone_code' => '',
           //     'address_id' => $this->customer->getAddressId(),
            );
            $this->session->data['confirm'] = array(

                'comment' =>  $this->setSessionValue('comment','confirm', $this->data, $account, false),
                'agree' =>  $this->setSessionValue('agree','confirm', $this->data, $account, false),

            );

        }else{
        
            $this->session->data['guest'] = array(
                'customer_group_id' => $customer_group_id,
                'firstname' => $this->setSessionValue('firstname','payment_address', $this->data, $account),
                'lastname' => $this->setSessionValue('lastname','payment_address', $this->data, $account),
                'email' =>  $this->setSessionValue('email','payment_address', $this->data, $account),
                'password' =>  $this->setSessionValue('password','payment_address', $this->data, $account),
                'telephone' =>  $this->setSessionValue('telephone','payment_address', $this->data, $account),
                'fax' =>  $this->setSessionValue('fax','payment_address', $this->data, $account),
              //  'custom_field' => (!empty($this->session->data['payment_address']['custom_field']['account'])) ? array('account' => $this->session->data['payment_address']['custom_field']['account']) : $this->model_d_quickcheckout_custom_field->setCustomFieldsDefaultSessionData('account', $customer_group_id ),
                'shipping_address' =>  $this->setSessionValue('shipping_address','payment_address', $this->data, $account),
                );
            
            $this->session->data['payment_address'] = array(
                'firstname' => $this->setSessionValue('firstname','payment_address', $this->data, $account),
                'lastname' => $this->setSessionValue('lastname','payment_address', $this->data, $account),
                'email' => $this->setSessionValue('email','payment_address', $this->data, $account),
                'email_confirm' => '',
                'telephone' => $this->setSessionValue('telephone','payment_address', $this->data, $account),
                'fax' => $this->setSessionValue('fax','payment_address', $this->data, $account),
                'password' => $this->setSessionValue('password','payment_address', $this->data, $account),
                'confirm' => '',
                'customer_group_id' => $customer_group_id ,
                'company' => $this->setSessionValue('company','payment_address', $this->data, $account),
                 'company_id' => $this->setSessionValue('company_id','payment_address', $this->data, $account),
                'tax_id' => $this->setSessionValue('tax_id','payment_address', $this->data, $account),
                'address_1' => $this->setSessionValue('address_1','payment_address', $this->data, $account),
                'address_2' => $this->setSessionValue('address_2','payment_address', $this->data, $account),
                'postcode' => $this->setSessionValue('postcode','payment_address', $this->data, $account),
                'city' => $this->setSessionValue('city','payment_address', $this->data, $account),
                'country_id' =>  $this->setSessionValue('country_id','payment_address', $this->data, $account),
                'zone_id' => $this->setSessionValue('zone_id','payment_address', $this->data, $account),
                'country' => $this->setSessionValue('country','payment_address', $this->data, $account),
                'iso_code_2' => $this->setSessionValue('iso_code_2','payment_address', $this->data, $account),
                'iso_code_3' => $this->setSessionValue('iso_code_3','payment_address', $this->data, $account),
                'address_format' => $this->setSessionValue('address_format','payment_address', $this->data, $account),
               // 'custom_field' => ((!empty($this->session->data['payment_address']['custom_field']['account'])) ? array('account' => $this->session->data['payment_address']['custom_field']['account']) : $this->model_d_quickcheckout_custom_field->setCustomFieldsDefaultSessionData('account', $customer_group_id)) + ((!empty($this->session->data['payment_address']['custom_field']['address'])) ? array('address' => $this->session->data['payment_address']['custom_field']['address']) :  $this->model_d_quickcheckout_custom_field->setCustomFieldsDefaultSessionData('address', $customer_group_id)),
                'zone' => $this->setSessionValue('zone','payment_address', $this->data, $account),
                'zone_code' => $this->setSessionValue('zone_code','payment_address', $this->data, $account),
                'agree' => $this->setSessionValue('agree','payment_address', $this->data, $account),
                'shipping_address' => $this->setSessionValue('shipping_address','payment_address', $this->data, $account),
                'newsletter' => $this->setSessionValue('newsletter','payment_address', $this->data, $account),
                //'address_id' => (!empty($this->session->data['payment_address']['address_id'])) ? $this->session->data['payment_address']['address_id'] : $this->customer->getAddressId(),

            );
             $this->model_module_d_quickcheckout->logWrite('Initialize:: set session payment address', $this->debug);
            
            $this->session->data['shipping_address'] = array(
                'firstname' =>  $this->setSessionValue('firstname','shipping_address', $this->data, $account),
                'lastname' =>  $this->setSessionValue('lastname','shipping_address', $this->data, $account),
                'company' =>  $this->setSessionValue('company','shipping_address', $this->data, $account),
                'address_1' =>  $this->setSessionValue('address_1','shipping_address', $this->data, $account),
                'address_2' => $this->setSessionValue('address_2','shipping_address', $this->data, $account),
                'postcode' => $this->setSessionValue('postcode','shipping_address', $this->data, $account),
                'city' => $this->setSessionValue('city','shipping_address', $this->data, $account),
                'country_id' => $this->setSessionValue('country_id','shipping_address', $this->data, $account),
                'zone_id' => $this->setSessionValue('zone_id','shipping_address', $this->data, $account),
                'country' => $this->setSessionValue('country','shipping_address', $this->data, $account),
                'iso_code_2' => $this->setSessionValue('iso_code_2','shipping_address', $this->data, $account),
                'iso_code_3' => $this->setSessionValue('iso_code_3','shipping_address', $this->data, $account),
                'address_format' =>  $this->setSessionValue('address_format','shipping_address', $this->data, $account),
                //'custom_field' => ((!empty($this->session->data['shipping_address']['custom_field']['address'])) ? array('address' => $this->session->data['shipping_address']['custom_field']['address']) : $this->model_d_quickcheckout_custom_field->setCustomFieldsDefaultSessionData('address', $customer_group_id )),
                'zone' =>  $this->setSessionValue('zone','shipping_address', $this->data, $account),
                'zone_code' => $this->setSessionValue('zone_code','shipping_address', $this->data, $account),
                //'address_id' => (!empty($this->session->data['shipping_address']['address_id'])) ? $this->session->data['shipping_address']['address_id'] : $this->customer->getAddressId(),
            );

        }
		
        $this->session->data['payment_address'] = $this->model_d_quickcheckout_address->prepareAddress($this->session->data['payment_address']);
        $this->session->data['shipping_address'] = $this->model_d_quickcheckout_address->prepareAddress($this->session->data['shipping_address']);
        
        $this->session->data['payment_address'] = $this->session->data['payment_address']; // + $this->model_d_quickcheckout_custom_field->getCustomFieldsSessionData('guest', 'account');
        $this->session->data['payment_address'] = $this->session->data['payment_address']; // + $this->model_d_quickcheckout_custom_field->getCustomFieldsSessionData('payment_address', 'address');
        $this->session->data['shipping_address'] = $this->session->data['shipping_address']; // + $this->model_d_quickcheckout_custom_field->getCustomFieldsSessionData('shipping_address', 'address');
 
      
        
		if($this->customer->isLogged()){ 
			if(!isset($this->session->data['payment_address']['address_id']) && isset($this->session->data['payment_address_id']) ) {
				$this->session->data['payment_address']['address_id'] = $this->session->data['payment_address_id'];
			}elseif( isset($this->session->data['payment_address']['address_id']) && !$this->setting['general']['clear_session'])  {
				$this->session->data['payment_address']['address_id'] = $this->session->data['payment_address']['address_id'];
			}else{
				$this->session->data['payment_address']['address_id'] = $this->customer->getAddressId();
			}
			
			if (!isset($this->session->data['shipping_address']['address_id']) && isset($this->session->data['shipping_address_id']) ) {
				$this->session->data['shipping_address']['address_id'] = $this->session->data['shipping_address_id'];	
			}elseif( isset($this->session->data['shipping_address']['address_id']) && !$this->setting['general']['clear_session'])  {
				$this->session->data['shipping_address']['address_id'] = $this->session->data['shipping_address']['address_id'];
			}else{
				$this->session->data['shipping_address']['address_id'] = $this->customer->getAddressId();
			}	
		}
      // 
        if($this->customer->isLogged() && $this->session->data['payment_address']['address_id'] && $this->session->data['payment_address']['address_id'] != 'new'){
            $this->session->data['payment_address'] = array_merge ($this->session->data['payment_address'] , $this->model_d_quickcheckout_address->getAddress($this->session->data['payment_address']['address_id']));
        }
 

        if($this->customer->isLogged() && $this->session->data['shipping_address']['address_id'] && $this->session->data['shipping_address']['address_id'] != 'new'){
              $this->session->data['shipping_address'] = array_merge ($this->session->data['shipping_address'] , $this->model_d_quickcheckout_address->getAddress($this->session->data['shipping_address']['address_id']));
        }

        $this->model_module_d_quickcheckout->logWrite('Initialize:: set session shipping address', $this->debug);
    
        $this->model_d_quickcheckout_address->updateTaxAddress();
            
        $this->getChild('d_quickcheckout/shipping_method/prepare');
 
        $this->model_module_d_quickcheckout->logWrite('Initialize:: set session shipping methods', $this->debug);
 
        $this->session->data['comment'] = (!empty($this->session->data['comment'])) ? $this->session->data['comment'] : $this->data['account'][$account]['confirm']['fields']['comment']['value'];
 
        $this->session->data['confirm'] = array(

            'comment' => $this->session->data['comment'],
            'agree' => (isset($this->session->data['confirm']['agree'])) ? $this->session->data['confirm']['agree'] : $this->data['account'][$account]['confirm']['fields']['agree']['value'],
        );

        $this->session->data['totals'] = $this->model_d_quickcheckout_order->getTotals($total_data, $total, $taxes);
      
        $this->getChild('d_quickcheckout/payment_method/prepare');
 
        $this->model_module_d_quickcheckout->logWrite('Initialize:: set session payment methods', $this->debug);
 
        $this->session->data['order_id'] = $this->createOrder();
 
        $this->model_module_d_quickcheckout->logWrite('Initialize:: create new Order_id and prepare $this->session->data', $this->debug);
 
        //statistic
        $this->session->data['statistic'] = array('account' => $this->session->data['account'], 'field' => $field_count);
        $this->session->data['statistic_id'] = $this->model_module_d_quickcheckout->setStatistic($this->current_setting_id, $this->session->data['order_id'], $this->session->data['statistic'], $this->customer->getId());
    }

    public function createOrder(){
        $order_data = array();
        
        $this->model_d_quickcheckout_order->getTotals($total_data, $total, $taxes);
        
        $this->load->language('checkout/checkout');

        if(isset($this->session->data['payment_address']['zone_id'])){
            $order_data['payment_zone_id'] = $this->session->data['payment_address']['zone_id'];
        }else{
            $order_data['payment_zone_id'] = $this->config->get('config_zone_id');
        }
        if(isset($this->session->data['payment_address']['country_id'])){
           $order_data['payment_country_id'] = $this->session->data['payment_address']['country_id']; 
        }else{
           $order_data['payment_country_id'] = $this->config->get('config_country_id');
        }
        
        $order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
        $order_data['store_id'] = $this->config->get('config_store_id');
        $order_data['store_name'] = $this->config->get('config_name');

        if ($order_data['store_id']) {
            $order_data['store_url'] = $this->config->get('config_url');
        } else {
            $order_data['store_url'] = HTTP_SERVER;
        }

        $order_data['total'] = $total;

        if (isset($this->request->cookie['tracking'])) {
            $order_data['tracking'] = $this->request->cookie['tracking'];

            $subtotal = $this->cart->getSubTotal();

            // Affiliate
            $this->load->model('affiliate/affiliate');

            $affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);

            if ($affiliate_info) {
                $order_data['affiliate_id'] = $affiliate_info['affiliate_id'];
                $order_data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
            } else {
                $order_data['affiliate_id'] = 0;
                $order_data['commission'] = 0;
            }

            
                $order_data['marketing_id'] = 0;
          
        } else {
            $order_data['affiliate_id'] = 0;
            $order_data['commission'] = 0;
            $order_data['marketing_id'] = 0;
            $order_data['tracking'] = '';
        }

        $order_data['language_id'] = $this->config->get('config_language_id');
        $order_data['currency_id'] = $this->currency->getId();
        $order_data['currency_code'] = $this->currency->getCode();
        $order_data['currency_value'] = $this->currency->getValue($this->currency->getCode());
        $order_data['ip'] = $this->request->server['REMOTE_ADDR'];

        if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
            $order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
            $order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
        } else {
            $order_data['forwarded_ip'] = '';
        }

        if (isset($this->request->server['HTTP_USER_AGENT'])) {
            $order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
        } else {
            $order_data['user_agent'] = '';
        }

        if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
            $order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
        } else {
            $order_data['accept_language'] = '';
        }

        return $this->model_d_quickcheckout_order->addOrder($order_data);
    }
    private function setSessionValue($field, $step, $data, $account, $session = true){
        $value = '';

        if($session && isset($this->session->data[$step][$field])){
            $value = $this->session->data[$step][$field]; 
        }elseif(isset($data['account'][$account][$step]['fields'][$field])){
            if(isset($data['account'][$account][$step]['fields'][$field]['value'])){
                $value = $data['account'][$account][$step]['fields'][$field]['value'];
            }
        }
        return $value;
        
    }
}