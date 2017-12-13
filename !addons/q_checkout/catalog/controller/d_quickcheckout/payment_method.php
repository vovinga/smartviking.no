<?php 

class ControllerDQuickcheckoutPaymentMethod extends Controller {
   	
	public function index($config){

		$this->document->addScript('catalog/view/javascript/d_quickcheckout/model/payment_method.js');
        $this->document->addScript('catalog/view/javascript/d_quickcheckout/view/payment_method.js');

        $this->data['col'] = $config['account']['guest']['payment_method']['column'];
        $this->data['row'] = $config['account']['guest']['payment_method']['row'];

        $json['account'] = $this->session->data['account'];
        $json['payment_methods'] = $this->session->data['payment_methods'];
        $json['payment_method'] = $this->session->data['payment_method'];
        $json['error_warning'] = '';

        $this->data['json'] = json_encode($json);
     
	 
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/d_quickcheckout/payment_method.tpl')) { 
           $this->template = $this->config->get('config_template') . '/template/d_quickcheckout/payment_method.tpl';
        } else {
               $this->template = 'default/template/d_quickcheckout/payment_method.tpl';
          }

   return  $this->response->setOutput($this->render());		
	}

	public function update(){
        $this->load->model('d_quickcheckout/order');
        $this->load->model('module/d_quickcheckout');
        $this->model_module_d_quickcheckout->startDebug();
        $json = array();
        
        $this->prepare($json);
        $json = $this-> output; 

        $json['totals'] = $this->session->data['totals'] = $this->model_d_quickcheckout_order->getTotals($total_data, $total, $taxes);
        $json['total'] = $this->model_d_quickcheckout_order->getCartTotal($total);
      
        $json['order_id'] = $this->session->data['order_id'] = $this->getChild('d_quickcheckout/confirm/updateOrder');

        //payment
        $json = $this->getChild('d_quickcheckout/payment/prepare', $json);
        
        //statistic
        $statistic = array(
            'update' => array(
                'payment_method' => 1
            )
        );
        $this->model_module_d_quickcheckout->updateStatistic($statistic);
        	$this->model_module_d_quickcheckout->endDebug('Update:: Payment method');
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function prepare($json){
        $this->load->model('module/d_quickcheckout');
        $this->load->model('d_quickcheckout/method');
        $this->load->model('d_quickcheckout/address');

        $this->session->data['payment_methods'] = $this->model_d_quickcheckout_method->getPaymentMethods($this->session->data['payment_address'], $this->session->data['totals']);
        
        if(isset($this->request->post['payment_method'])){
            $this->session->data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']];
        
        }

        if(isset($this->session->data['payment_method']['code'])){
            if(!$this->model_module_d_quickcheckout->in_array_multi($this->session->data['payment_method']['code'],$this->session->data['payment_methods'])){      
                $this->session->data['payment_method'] = $this->model_d_quickcheckout_method->getFirstPaymentMethod();   
            }
        }

        if(empty($this->session->data['payment_method'])){
            $this->session->data['payment_method'] = $this->model_d_quickcheckout_method->getFirstPaymentMethod(); 
        }

        $json['payment_methods'] = $this->session->data['payment_methods'];
        $json['payment_method'] = $this->session->data['payment_method'];

        $this->output =  $json;	
    }
}