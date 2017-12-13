<?php
class ModelAccountSocialMedia extends Model {
	public function addCustomer($data) {
		if( $this->getCustomerByEmail($data['email']) ){
			return;
		}
		
		if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && 
		in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $data['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}
		
		$this->load->model('account/customer_group');
		
		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);
		
		$this->load->model("setting/setting");
		$facebook_login_config= $this->model_setting_setting->getSetting("facebook_set");
		$config_manages_fb_login= $facebook_login_config['config_manages_fb_login'];
		
		if( ! isset($config_manages_fb_login['show_dialog']) || $data['completedialog'] == "false" ){
		// Just Facebook Data
      	$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET store_id = '" . 
		(int)$this->config->get('config_store_id') . "', firstname = '" . $this->db->escape($data['firstname']) . 
		"', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . 
		$this->db->escape($data['email']) . "', customer_group_id = '" . 
		(int)$customer_group_id . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . 
		"', status = '1', approved = '" . (int)!$customer_group_info['approval'] . "', date_added = NOW()");
		}else{
		// Complete Data
      	$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET store_id = '" . 
		(int)$this->config->get('config_store_id') . "', firstname = '" . $this->db->escape($data['firstname']) . 
		"', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . 
		$this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . 
		"', newsletter = '" . $this->db->escape($data['newsletter']) . "', customer_group_id = '" . 
		(int)$customer_group_id . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . 
		"', status = '1', approved = '" . (int)!$customer_group_info['approval'] . "', date_added = NOW()");		
		}
      	
		$customer_id = $this->db->getLastId();
		
		if( ! isset($config_manages_fb_login['show_dialog']) || $data['completedialog'] == "false" ){
		// Add Address
      	$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . 
		"', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . 
		$this->db->escape($data['lastname']) . "', country_id = '" . $this->db->escape($data['country_id']) . 
		"', zone_id = '" . $this->db->escape($data['zone_id']) . "'");
		}else{
		// Add Address Complete
      	$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . 
		"', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . 
		$this->db->escape($data['lastname']) . "', address_1 = '" . $this->db->escape($data['address_1']) . 
		"', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . 
		"', country_id = '" . $this->db->escape($data['country_id']) . "', zone_id = '" . 
		$this->db->escape($data['zone_id']) . "'");
		}
		
		// Update Customer
		$address_id = $this->db->getLastId();
      	$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . 
		"' WHERE customer_id = '" . (int)$customer_id . "'");
		
		// Start Add Data Into Table social_media_user
      	$this->db->query("INSERT INTO " . DB_PREFIX . "social_media_user SET user_id= '" . (int)$customer_id . 
		"', type= '" . $this->db->escape($data['type']) . "', social_media_id= '" . $this->db->escape($data['id']) . 
		"', `from`= '" . $this->db->escape($data['from']) . "'");
		
		// End Add Data Into Table social_media_user
		
		$this->language->load('mail/customer');
		
		$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
		
		$message = sprintf($this->language->get('text_welcome'), $this->config->get('config_name')) . "\n\n";
		
		if (!$customer_group_info['approval']) {
			$message .= $this->language->get('text_login') . "\n";
		} else {
			$message .= $this->language->get('text_approval') . "\n";
		}
		
		$message .= $this->url->link('account/login', '', 'SSL') . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= $this->config->get('config_name');
		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');				
		$mail->setTo($data['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
		$mail->send();
		
		// Send to main admin email if new account email is enabled
		if ($this->config->get('config_account_mail')) {
			$mail->setTo($this->config->get('config_email'));
			$mail->send();
			
			// Send to additional alert emails if new account email is enabled
			$emails = explode(',', $this->config->get('config_alert_emails'));
			
			foreach ($emails as $email) {
				if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}
	}
	
	public function getCustomerByEmail($email){
		$sql= "SELECT a.* FROM " . DB_PREFIX . "customer a " . 
		"WHERE email = '" . $this->db->escape($email) . "'";
		$query = $this->db->query($sql);
		
		return $query->row;
	}
		
	public function getCustomer($social_media_id) {
		$sql= "SELECT a.* FROM " . DB_PREFIX . "customer a " . 
		"INNER JOIN " . DB_PREFIX . "social_media_user b ON b.user_id= a.customer_id " . 
		"WHERE social_media_id = '" . $this->db->escape($social_media_id) . "' AND `type`= 'customer'";
		$query = $this->db->query($sql);
		
		return $query->row;
	}

	public function getAffiliateByEmail($email) {
		$sql= "SELECT a.* FROM " . DB_PREFIX . "affiliate a " . 
		"WHERE email = '" . $this->db->escape($email) . "'";
		$query = $this->db->query($sql);
		
		return $query->row;
	}
	
	public function addAffiliate($data) {
		if( $this->getAffiliateByEmail($data['email']) ){
			return;
		}
				
		$this->load->model("setting/setting");
		$facebook_login_config= $this->model_setting_setting->getSetting("facebook_set");
		$config_manages_fb_login= $facebook_login_config['config_manages_fb_login'];		
		
		if( ! isset($config_manages_fb_login['show_dialog']) || $data['completedialog'] == "false" ){
		// Just Facebook Data
      	$this->db->query("INSERT INTO " . DB_PREFIX . "affiliate SET firstname = '" . 
		$this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . 
		"', email = '" . $this->db->escape($data['email']) . "', country_id = '" . (int)$data['country_id'] . 
		"', zone_id = '" . (int)$data['zone_id'] . "', salt = '" . 
		$this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . 
		$this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . 
		"', approved= '1', status= '1', date_added = NOW()");
		}else{
		// Complete Data
      	$this->db->query("INSERT INTO " . DB_PREFIX . "affiliate SET firstname = '" . 
		$this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . 
		"', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . 
		"', address_1 = '" . $this->db->escape($data['address_1']) . 
		"', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . 
		"', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "', salt = '" . 
		$this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . 
		$this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . 
		"', approved= '1', status= '1', date_added = NOW()");
		}
		
		$affiliate_id = $this->db->getLastId();
		// Start Add Data Into Table social_media_user
      	$this->db->query("INSERT INTO " . DB_PREFIX . "social_media_user SET user_id= '" . (int)$affiliate_id . 
		"', type= '" . $this->db->escape($data['type']) . "', social_media_id= '" . $this->db->escape($data['id']) . 
		"', `from`= '" . $this->db->escape($data['from']) . "'");
	
		$this->language->load('mail/affiliate');
		
		$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
		
		$message  = sprintf($this->language->get('text_welcome'), $this->config->get('config_name')) . "\n\n";
		$message .= $this->language->get('text_approval') . "\n";
		$message .= $this->url->link('affiliate/login', '', 'SSL') . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= $this->config->get('config_name');
		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');				
		$mail->setTo($this->request->post['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
		$mail->send();
	}
	
	public function getAffiliate($social_media_id){
		$sql= "SELECT a.* FROM " . DB_PREFIX . "affiliate a " . 
		"INNER JOIN " . DB_PREFIX . "social_media_user b ON b.user_id= a.affiliate_id " . 
		"WHERE social_media_id = '" . $this->db->escape($social_media_id) . "' AND `type`= 'affiliate'";
		$query = $this->db->query($sql);
		
		return $query->row;	
	}	

	public function getCountry($iso_code_2) {
		$query = $this->db->query("SELECT a.country_id, b.zone_id FROM " . DB_PREFIX . "country a 
		INNER JOIN " . DB_PREFIX . "zone b ON b.country_id= a.country_id 
		WHERE a.iso_code_2 = '" . $this->db->escape($iso_code_2) . "' AND a.status = '1'");
		
		return $query->row;
	}	
}
?>