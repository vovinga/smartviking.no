<?php 

class ControllerDQuickcheckoutPayment extends Controller {
	
	public function index($config){

		$this->load->model('module/d_quickcheckout');
		
		$this->document->addScript('catalog/view/javascript/d_quickcheckout/model/payment.js');
		$this->document->addScript('catalog/view/javascript/d_quickcheckout/view/payment.js');

		$this->data['col'] = $config['account']['guest']['payment']['column'];
        $this->data['row'] = $config['account']['guest']['payment']['row'];

        $json = array();
        $this->prepare($json);
        $json = $this-> output; 
			
        $json['account'] = $this->session->data['account'];
        $json['trigger'] = $config['trigger'];
		
		$this->data['json'] = json_encode($json);

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/d_quickcheckout/payment.tpl')) { 
           $this->template = $this->config->get('config_template') . '/template/d_quickcheckout/payment.tpl';
        }else {
               $this->template = 'default/template/d_quickcheckout/payment.tpl';
        }

		return  $this->response->setOutput($this->render());		
	}

	public function prepare($json){
		if(isset($this->session->data['payment_method']) && isset($this->session->data['payment_method']['code'])){
			$json['payment'] = $this->getChild('payment/' . $this->session->data['payment_method']['code']);
		}else{
			$json['payment'] = '';
		}

		$this->output = $json;
	}
}