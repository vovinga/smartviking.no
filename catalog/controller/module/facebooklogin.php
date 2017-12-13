<?php  
class ControllerModuleFacebooklogin extends Controller {
	protected function index($config) {
		$this->language->load('module/facebooklogin');

      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		if(!$this->customer->isLogged()){
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$configuration = str_replace('http', 'https', $this->config->get('FacebookLogin'));
			} else {
				$configuration = $this->config->get('FacebookLogin');
			}
			
			$this->data['data']['FacebookLogin'] = $configuration[$this->config->get('config_store_id')];
			$this->data['data']['FacebookLoginConfig'] = $config;
			
			if (!empty($configuration['Activated']) && $configuration['Activated'] == 'Yes' && !empty($this->data['data']['FacebookLogin']['Enabled']) && $this->data['data']['FacebookLogin']['Enabled'] == 'Yes') {
				$this->data['url_login'] = $this->url->link('module/facebooklogin/display', '', 'SSL');
				
				if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/facebooklogin.css')) {
					$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/facebooklogin.css');
				} else {
					$this->document->addStyle('catalog/view/theme/default/stylesheet/facebooklogin.css');
				}
				
				if(!isset($this->data['data']['FacebookLogin']['ButtonName_'.$this->config->get('config_language')])){
					$this->data['data']['FacebookLogin']['ButtonLabel'] = 'Login with Facebook';
				} else {
					$this->data['data']['FacebookLogin']['ButtonLabel'] = $this->data['data']['FacebookLogin']['ButtonName_'.$this->config->get('config_language')];
				}
				
				if(!isset($this->data['data']['FacebookLogin']['WrapperTitle_'.$this->config->get('config_language')])){
					$this->data['data']['FacebookLogin']['WrapperTitle'] = 'Login';
				} else {
					$this->data['data']['FacebookLogin']['WrapperTitle'] = $this->data['data']['FacebookLogin']['WrapperTitle_'.$this->config->get('config_language')];
				}
	
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/facebooklogin.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/module/facebooklogin.tpl';
				} else {
					$this->template = 'default/template/module/facebooklogin.tpl';
				}
	
				$this->render();
			}
		}
	}
	
	public function display() {
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$configuration = str_replace('http', 'https', $this->config->get('FacebookLogin'));
		} else {
			$configuration = $this->config->get('FacebookLogin');
		}
		
		$this->data['data']['FacebookLogin'] = $configuration[$this->config->get('config_store_id')];
		
		if(!isset($this->facebookObject)){
			if (!class_exists('Facebook')) {	
				require_once(DIR_SYSTEM . '../vendors/facebook-api/facebook.php');
			}
			$this->facebookObject = new Facebook(array(
				'appId'  => $this->data['data']['FacebookLogin']['APIKey'],
				'secret' => $this->data['data']['FacebookLogin']['APISecret'],
			));
		}
		
		unset($this->session->data['facebooklogin_redirect']);
		
		echo $this->facebookObject->getLoginUrl(
			array(
				'scope' => 'email,user_birthday,user_location,user_hometown',
				'redirect_uri'  => $this->url->link('account/facebooklogin', !empty($this->session->data['facebooklogin_redirect']) ? 'redirect='.base64_encode($this->session->data['facebooklogin_redirect']) : '', 'SSL'),
				'display' => 'popup'
			)
		);
		
		exit;
	}
}
?>