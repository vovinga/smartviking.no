<?php 

class ControllerDQuickcheckoutLogin extends Controller {

	public function index($config){

		$this->document->addScript('catalog/view/javascript/d_quickcheckout/model/login.js');
		$this->document->addScript('catalog/view/javascript/d_quickcheckout/view/login.js');

        $this->data['col'] = $config['account']['guest']['login']['column'];
        $this->data['row'] = $config['account']['guest']['login']['row'];

		$this->data['text_returning_customer'] = $this->language->get('text_returning_customer');
		$this->data['text_new_customer'] = $this->language->get('text_new_customer');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['text_guest'] = $this->language->get('text_guest');
		$this->data['button_login'] = $this->language->get('button_login');
		$this->data['text_forgotten'] = $this->language->get('text_forgotten');
		$this->data['step_option_guest_desciption'] = $this->language->get('step_option_guest_desciption');
        $this->load->model('module/d_quickcheckout');
        if($this->model_module_d_quickcheckout->isInstalled('d_social_login')  && $config['general']['social_login']){
		 
             $this->data['d_social_login'] = $this->getChild('module/d_social_login/dQuickcheckoutIndex');
        }else{
            $this->data['d_social_login'] = '';
        }
        

        $this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
		$json['account'] = $this->session->data['account'];
		$json['error'] = '';
        
        if ($this->config->get('config_customer_price') && !$this->customer->isLogged()) {
            $this->data['attention'] = sprintf($this->language->get('text_login'), $this->url->link('account/login'), $this->url->link('account/register'));
        } else {
            $this->data['attention'] = '';
        }

		$this->data['json'] = json_encode($json); 

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/d_quickcheckout/login.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/d_quickcheckout/login.tpl';
        } else {
            $this->template = 'default/template/d_quickcheckout/login.tpl';
        }
        
     //   return $this->load->view($this->template, $this->data);
       return  $this->response->setOutput($this->render());		

	}

	/*
    *   Update functions
    */

    public function loginAccount(){

        $this->load->language('checkout/checkout');
        $this->load->model('module/d_quickcheckout');
        $this->load->model('d_quickcheckout/address');
        $this->load->model('d_quickcheckout/method');
        $this->load->model('d_quickcheckout/order');
 
        $json = array();
 
        if ($this->customer->isLogged()) {
            $json['account'] = $this->session->data['account'] = 'logged';
        }

        if($this->model_d_quickcheckout_order->isCartEmpty()){
            $json['redirect'] = $this->model_module_d_quickcheckout->ajax($this->url->link('checkout/cart'));
        }

        if (!$json) {
            $this->load->model('account/customer');
       
        
 
            // Check if customer has been approved.
            $customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);
 
 
            if ($customer_info && !$customer_info['approved']) {
                $json['login_error'] = $this->language->get('error_approved');
            }
 
            if (!isset($json['login_error'])) {
                if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
                    $json['login_error'] = $this->language->get('error_login');
                }      
            }
			 
			 
        }

        if (!$json) {
            //unset($this->session->data['guest']);

            $this->load->model('account/address');

            $json['account'] = $this->session->data['account'] = 'logged';

            //payment address
            $json = $this->getChild('d_quickcheckout/payment_address/prepare', $json);

            //shipping address
            $json = $this->getChild('d_quickcheckout/shipping_address/prepare', $json);

            $json['addresses'] = $this->model_account_address->getAddresses();

            //shipping address
            $json['show_shipping_address'] = $this->model_d_quickcheckout_address->showShippingAddress();
            
            $this->model_d_quickcheckout_address->updateTaxAddress();

            //shipping method
            $json = $this->getChild('d_quickcheckout/shipping_method/prepare', $json);

            //payment method - for xshipping (optimization needed)
            $json = $this->getChild('d_quickcheckout/payment_method/prepare', $json);

            //totals
            $json = $this->getChild('d_quickcheckout/cart/prepare', $json);
            $json['totals'] = $this->session->data['totals'] = $this->model_d_quickcheckout_order->getTotals($total_data, $total, $taxes);
            $json['total'] = $this->model_d_quickcheckout_order->getCartTotal($total);
             
            //order
            $json['order_id'] = $this->session->data['order_id'] = $this->getChild('d_quickcheckout/confirm/updateOrder');

            //payment
            $json = $this->getChild('d_quickcheckout/payment/prepare', $json);
                
        }
        $this->load->model('module/d_quickcheckout');
        //statistic
        $statistic = array(
            'click' => array(
                'login' => 1
            )
        );
        
        $this->model_module_d_quickcheckout->updateStatistic($statistic);
           $this->log->write($json);
   
         $this->response->addHeader('Content-Type: application/json');
      
         $this->response->setOutput(json_encode($json));

    } 

    public function updateAccount(){
        $this->load->model('module/d_quickcheckout');
        
        $this->session->data['account'] = $this->request->post['account'];
        $json['account'] = $this->session->data['account'];

        //statistic
        $statistic = array(
            'click' => array(
                'login' => 1
            ),
            'account' => $json['account']
        );
        $this->model_module_d_quickcheckout->updateStatistic($statistic);

        $this->response->addHeader('Content-Type: application/json');
      
         $this->response->setOutput(json_encode($json));
    } 
}