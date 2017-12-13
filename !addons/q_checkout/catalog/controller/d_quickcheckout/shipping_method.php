<?php 

class ControllerDQuickcheckoutShippingMethod extends Controller {
   
	public function index($config){

        $this->load->model('d_quickcheckout/method');

        $this->document->addScript('catalog/view/javascript/d_quickcheckout/model/shipping_method.js');
        $this->document->addScript('catalog/view/javascript/d_quickcheckout/view/shipping_method.js');

        $this->data['col'] = $config['account']['guest']['shipping_method']['column'];
        $this->data['row'] = $config['account']['guest']['shipping_method']['row'];

        $json['account'] = $this->session->data['account'];
        $json['shipping_methods'] = $this->session->data['shipping_methods'];
        $json['shipping_method'] = $this->session->data['shipping_method'];
        $json['show_shipping_method'] = $this->model_d_quickcheckout_method->shippingRequired();

        $this->data['json'] = json_encode($json);
        
	
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/d_quickcheckout/shipping_method.tpl')) { 
           $this->template = $this->config->get('config_template') . '/template/d_quickcheckout/shipping_method.tpl';
        } else {
               $this->template = 'default/template/d_quickcheckout/shipping_method.tpl';
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

        //payment method - for xshipping (optimization needed)
        $json = $this->getChild('d_quickcheckout/payment_method/prepare', $json);
        
        $json['totals'] = $this->session->data['totals'] = $this->model_d_quickcheckout_order->getTotals($total_data, $total, $taxes);
        $json['total'] = $this->model_d_quickcheckout_order->getCartTotal($total);
        $json['order_id'] = $this->session->data['order_id'] = $this->getChild('d_quickcheckout/confirm/updateOrder');

        //payment
        $json = $this->getChild('d_quickcheckout/payment/prepare', $json);

        //statistic
        $statistic = array(
            'update' => array(
                'shipping_method' => 1
            )
        );

       

        $this->model_module_d_quickcheckout->updateStatistic($statistic);
        $this->model_module_d_quickcheckout->endDebug('Update:: Shipping method');
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function prepare($json){
        $this->load->model('module/d_quickcheckout');
        $this->load->model('d_quickcheckout/method');
        $this->load->model('d_quickcheckout/address');

        $this->session->data['shipping_methods'] = $this->model_d_quickcheckout_method->getShippingMethods($this->model_d_quickcheckout_address->paymentOrShippingAddress());
        
        if(isset($this->request->post['shipping_method'])){
            $shipping = explode('.', $this->request->post['shipping_method']);
            $this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
        
        }

        if(isset($this->session->data['shipping_method']['code'])){
            if(!$this->model_module_d_quickcheckout->in_array_multi($this->session->data['shipping_method']['code'],$this->session->data['shipping_methods'])){      
                $this->session->data['shipping_method'] = $this->model_d_quickcheckout_method->getFirstShippingMethod();   
            
            }else{
                $shipping = explode('.', $this->session->data['shipping_method']['code']);
                $this->session->data['shipping_method'] = array_merge($this->session->data['shipping_method'], $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]]);
            }
        }

        if(empty($this->session->data['shipping_method'])){
            $this->session->data['shipping_method'] = $this->model_d_quickcheckout_method->getFirstShippingMethod(); 
        }
       

        $json['show_shipping_method'] = $this->model_d_quickcheckout_method->shippingRequired();
        $json['shipping_methods'] = $this->session->data['shipping_methods'];
        $json['shipping_method'] = $this->session->data['shipping_method'];

        $this->output =  $json;	
    }
}