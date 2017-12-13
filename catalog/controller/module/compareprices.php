<?php  

class ControllerModuleCompareprices extends Controller {
	protected function index() {
		$this->language->load('module/compareprices');

      	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['h2_ComparePrices'] = $this->language->get('h2_ComparePrices');

		$this->data['pleaseFillInTheForm'] = $this->language->get('pleaseFillInTheForm');
		$this->data['requiredFields'] = $this->language->get('requiredFields');
		$this->data['yourName'] = $this->language->get('yourName');
		$this->data['yourEmail'] = $this->language->get('yourEmail');
		$this->data['priceInOtherStore'] = $this->language->get('priceInOtherStore');
		$this->data['ourPrice'] = $this->language->get('ourPrice');
		$this->data['linkToTheProduct'] = $this->language->get('linkToTheProduct');
		$this->data['commentsOptional'] = $this->language->get('commentsOptional');
		$this->data['isThereSomethingMoreWeShouldKnow'] = $this->language->get('isThereSomethingMoreWeShouldKnow');
		$this->data['submitForm'] = $this->language->get('submitForm');
		$this->data['errorRequiredFields'] = $this->language->get('errorRequiredFields');
		$this->data['errorInvalidEmail'] = $this->language->get('errorInvalidEmail');
		$this->data['successfulSubmit'] = $this->language->get('successfulSubmit');

		$this->data['currenttemplate'] =  $this->config->get('config_template');

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['data']['ComparePrices'] = str_replace('http', 'https', $this->config->get('ComparePrices'));
		} else {
			$this->data['data']['ComparePrices'] = $this->config->get('ComparePrices');
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/compareprices.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/compareprices.tpl';
		} else {
			$this->template = 'default/template/module/compareprices.tpl';
		}
		
		//
		if  ((isset($this->request->get['route'])) && ($this->request->get['route']=="product/product")) {
		$this->data['comparePricesCurrentURL'] = $this->url->link("product/product","product_id=".$this->request->get['product_id'],"");
		} else {
			if (strpos(HTTP_SERVER,'www.') && strpos(HTTPS_SERVER,'www.')) {
				$siteName = $_SERVER["SERVER_NAME"];
			} else {
			  $siteName = str_replace("www.", "", $_SERVER['SERVER_NAME']);
			}
			$this->data['comparePricesCurrentURL'] = "http://".$siteName.$_SERVER["REQUEST_URI"];  
		}
		
		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}
		$product_info = $this->model_catalog_product->getProduct($product_id);
		if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
			$this->data['ComparePricesPrice'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
		} else {
			$this->data['ComparePricesPrice'] = false;
		}
		if ((float)$product_info['special']) {
			$this->data['ComparePricesSpecial'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
		} else {
			$this->data['ComparePricesSpecial'] = false;
		}
		$this->data['ComparePricesProductName'] = $product_info['name'];
		
		if(!isset($this->data['data']['ComparePrices']['CustomText_'.$this->config->get('config_language')])){
			$this->data['data']['ComparePrices']['CustomText'] = '';
		} else {
			$this->data['data']['ComparePrices']['CustomText'] = $this->data['data']['ComparePrices']['CustomText_'.$this->config->get('config_language')];
		}
		if(!isset($this->data['data']['ComparePrices']['SecondCustomText_'.$this->config->get('config_language')])){
			$this->data['data']['ComparePrices']['SecondCustomText'] = '';
		} else {
			$this->data['data']['ComparePrices']['SecondCustomText'] = $this->data['data']['ComparePrices']['SecondCustomText_'.$this->config->get('config_language')];
		}
		
		if ($this->customer->isLogged()) {
			$this->load->model('account/customer');	
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
	
			if (isset($customer_info)) {
				$this->data['firstname'] = $customer_info['firstname'];
				$this->data['lastname'] = $customer_info['lastname'];
				$this->data['email'] = $customer_info['email'];
			} else {
				$this->data['email'] = '';
			}
		} else {
			$this->data['firstname'] = '';
			$this->data['lastname'] = '';
			$this->data['email'] = '';
		}
		//
		$this->render();
	}
	
	public function sendemail() {
		if (isset($_POST['YourName']) && isset($_POST['YourEmail']) && isset($_POST['PriceInOtherStore']) && isset($_POST['LinkToTheProduct'])) {
				$text = "User reported lower price on our product in another store!<br />
				User Name: ".$_POST['YourName']."<br />
				User Email: ".$_POST['YourEmail']."<br /><br />";			
				if (isset($_POST['CurrentProductName'])) { $text .= "Our Product: ".$_POST['CurrentProductName']."<br />"; }
				$text .= "Our Product link: ".$_POST['CurrentProductURL']."<br />";
				if (isset($_POST['CurrentProductName'])) { $text .= "Our Product price: ".$_POST['CurrentProductPrice']."<br /><br />"; }			
				$text .= "Price in other store: ".$_POST['PriceInOtherStore']."<br />
				Link to the product with that price: ".$_POST['LinkToTheProduct']."<br />";
				if (isset($_POST['YourComments'])) { $text .="<br />Additional comments by ".$_POST['YourName'].": ".$_POST['YourComments']; }
			    $mail = new Mail();
                $mail->protocol = $this->config->get('config_mail_protocol');
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->hostname = $this->config->get('config_smtp_host');
                $mail->username = $this->config->get('config_smtp_username');
                $mail->password = $this->config->get('config_smtp_password');
                $mail->port = $this->config->get('config_smtp_port');
                $mail->timeout = $this->config->get('config_smtp_timeout');
                $mail->setTo($this->config->get('config_email'));
                $mail->setFrom($this->config->get('config_email'));
                $mail->setSender($this->config->get('config_name'));
                $mail->setSubject(html_entity_decode("New message about lower price", ENT_QUOTES, 'UTF-8'));
                $mail->setHtml($text);
                $mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
                $mail->send();
				}
	}

}

?>