<?php 

class ControllerDQuickcheckoutField extends Controller {
   
    public function index(){
        $this->document->addScript('catalog/view/javascript/d_quickcheckout/library/tinysort/jquery.tinysort.min.js');
        $this->document->addScript('catalog/view/javascript/d_quickcheckout/view/field.js');

        $this->data['text_select'] = $this->language->get('text_select');
        $this->data['error_field_required'] = $this->language->get('error_field_required');
        $this->data['error_email'] = $this->language->get('error_email');
        $this->data['settings'] =  $this->settings;
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/d_quickcheckout/field.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/d_quickcheckout/field.tpl';
        } else {
            $this->template = 'default/template/d_quickcheckout/field.tpl';
        }
        
        //$this->response->setOutput($this->render());		
         return  $this->response->setOutput($this->render());		
    }

    public function getZone(){
        $this->load->model('d_quickcheckout/address');
        $json = $this->model_d_quickcheckout_address->getZonesByCountryId($this->request->post['country_id']);
        if(!$json){
            $json = array( 0 => array( 'name' => $this->language->get('text_none'), 'value' => 0)); 
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function validate_email(){
        $this->load->model('account/customer');
        $this->load->language('checkout/checkout');
        $json = true;

        unset($this->request->get['route']);
        $email = current($this->request->get);

        if ($this->model_account_customer->getTotalCustomersByEmail($email)) {
            $json = $this->language->get('error_exists');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function validate_regex(){
        $this->load->model('account/customer');
        $this->load->language('checkout/checkout');
        $json = true;

        unset($this->request->get['route']);
        $regex = $this->request->get['regex'];
        unset($this->request->get['regex']);
        $value = current($this->request->get);

        if (!preg_match($regex, $value)){
            $json = false;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
