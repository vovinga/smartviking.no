<?php
class ControllerPaymentepay extends Controller {
	protected function index() {
		$this->language->load('payment/epay');
		
		$this->data['text_instruction'] = $this->language->get('text_instruction');
		$this->data['text_payment'] = $this->language->get('text_payment');
		
		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

		$this->data['continue'] = HTTPS_SERVER . 'index.php?route=checkout/epay';	
		
		if($this->request->get['route'] == 'checkout/confirm'){
			$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
		}elseif ($this->request->get['route'] != 'checkout/guest_step_3') {
			$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/confirm';
		} else {
			$this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
		}
		
		// Calculate Totals
		$total_data = array();					
		$total = 0;
		$taxes = $this->cart->getTaxes();
		
		$this->load->model('setting/extension');
		
		$sort_order = array(); 
		
		$results = $this->model_setting_extension->getExtensions('total');
		
		foreach ($results as $key => $value) {
			$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
		}
		
		array_multisort($sort_order, SORT_ASC, $results);
		
		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('total/' . $result['code']);
	
				$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
			}
		}
	
		$this->load->model('checkout/order');

		$totalsmax = count($total_data)-1;
		$amount = $this->currency->format($total_data[$totalsmax]['value'], $this->session->data['currency'], FALSE, FALSE)*100;
		 
		$params = array
		(
			'merchantnumber' => $this->config->get('epay_merchant_number'),
			'amount' => $amount,
			'currency' => $this->session->data['currency'],
			'orderid' => $this->session->data['order_id'],
			'group' => $this->config->get('epay_group'),
			'smsreceipt' => $this->config->get('epay_authsms'),
			'mailreceipt' => $this->config->get('epay_authemail'),
			'windowstate' => intval($this->config->get('epay_payment_window')),
			'instantcapture' => intval($this->config->get('epay_instantcapture')),
			'ownreceipt' => intval($this->config->get('epay_ownreceipt')),
			'accepturl' => HTTPS_SERVER . 'index.php?route=payment/epay/accept',
			'callbackurl' => HTTPS_SERVER . 'index.php?route=payment/epay/confirm',
			'cancelurl' => HTTPS_SERVER . 'index.php?route=checkout/epay',
			'description' => $this->session->data['comment']
		);
		
		$params["hash"] = md5(implode("", array_values($params)) . $this->config->get('epay_md5key'));
		
		$this->data['merchantnumber'] = $params["merchantnumber"];
		$this->data["amount"] = $params["amount"];
		$this->data["currency"] = $params["currency"];
		$this->data["orderid"] = $params["orderid"];
		$this->data['group'] = $params["group"];
		$this->data['smsreceipt'] = $params["smsreceipt"];
		$this->data['mailreceipt'] = $params["mailreceipt"];
		$this->data['windowstate'] = $params["windowstate"];
		$this->data['instantcapture'] = $params["instantcapture"];
		$this->data['ownreceipt'] = $params["ownreceipt"];
		$this->data["accepturl"] = $params["accepturl"];
		$this->data["callbackurl"] = $params["callbackurl"];
		$this->data["cancelurl"] = $params["cancelurl"];
		$this->data["description"] = $params["description"];
		$this->data['hash'] = $params["hash"];
		
		$this->id = 'payment';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/epay.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/epay.tpl';
		} else {
			$this->template = 'default/template/payment/epay.tpl';
		}	
		
		$this->render(); 
	}
	
	static function getCardnameById($cardid) {
		switch($cardid)
		{
			case 1:
				return 'Dankort / VISA/Dankort';
			case 2:
				return 'eDankort';
			case 3:
				return 'VISA / VISA Electron';
			case 4:
				return 'MasterCard';
			case 6:
				return 'JCB';
			case 7:
				return 'Maestro';
			case 8:
				return 'Diners Club';
			case 9:
				return 'American Express';
			case 10:
				return 'ewire';
			case 12:
				return 'Nordea e-betaling';
			case 13:
				return 'Danske Netbetalinger';
			case 14:
				return 'PayPal';
			case 16:
				return 'MobilPenge';
		}
		return 'unknown';
	}
	
	public function confirm() {
		$this->language->load('payment/epay');
		
		$this->load->model('checkout/order');
		
		$amount = $this->currency->format($_GET['amount']/100, $_GET['currency'], FALSE, TRUE);
		
		$comment = $this->language->get('payment_process') . $amount;
		$comment .= $this->language->get('payment_with_transactionid') . $_GET['txnid'];
		$comment .= $this->language->get('payment_card') . $this->getCardnameById($_GET['paymenttype']) . ' ' . $_GET['cardno'];
			
		
			if(strlen($this->config->get('epay_md5key')) > 0){
				$md5 = 0;
				
					$params = $_GET;
					$var = "";

					foreach ($params as $key => $value)
					{
					    if($key != "hash")
					    {
					        $var .= $value;
					    }
					}

					$genstamp = md5($var . $this->config->get('epay_md5key'));

					if($genstamp != $_GET["hash"])
					{
					    $md5 = 0;
					}
					else
					{
					    $md5 = 1; 
					}
		
			}else{
				$md5 = 1;
			}
		
			if($md5 == 1){
				
				//$this->log->write("Письма должны были отправиться");

				$this->model_checkout_order->confirm($_GET['orderid'], $this->config->get('epay_order_status_id'), $comment);
				echo "OK";
			}else{
				
				//$this->log->write("Письма не должны были отправиться");

				header('HTTP/1.1 500 Internal Server Error');
				header("Status: 500 Internal Server Error");

			}
		
	}
	
	public function accept() {
			if(strlen($this->config->get('epay_md5key')) > 0){
				$md5 = 0;
				
					$params = $_GET;
					$var = "";

					foreach ($params as $key => $value)
					{
					    if($key != "hash")
					    {
					        $var .= $value;
					    }
					}

					$genstamp = md5($var . $this->config->get('epay_md5key'));

					if($genstamp != $_GET["hash"])
					{
					    $md5 = 0;
					}
					else
					{
					    $md5 = 1; 
					}
		
			}else{
				$md5 = 1;
			}
			
			if($md5 == 1){
				$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/success');
			}else{
				$this->redirect(HTTPS_SERVER . 'index.php?route=checkout/epay&md5error=1');			
			}

	}	
}
?>