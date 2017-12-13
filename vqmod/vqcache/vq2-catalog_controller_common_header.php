<?php   
class ControllerCommonHeader extends Controller {
	protected function index() {
$this->load->library('user');
		$this->user = new User($this->registry);
	  
		$this->data['title'] = $this->document->getTitle();
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
        
        if (isset($this->session->data['error']) && !empty($this->session->data['error'])) {
            $this->data['error'] = $this->session->data['error'];
            
            unset($this->session->data['error']);
        } else {
            $this->data['error'] = '';
        }

		$this->data['base'] = $server;
		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = $this->document->getKeywords();
		$this->data['links'] = $this->document->getLinks();	 

				$this->data['robots'] = '';
				$extendedseo = $this->config->get('extendedseo');
				if (isset($extendedseo['robots'])) {
					$this->data['robots'] = '<meta name="robots" content="index">';
					}
				
				foreach ($this->data['links'] as $link) { 
					if ($link['rel']=='canonical') {$hasCanonical = true;
					if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])) {
					$this->db->query("insert into " . DB_PREFIX . "bots_report (link, bot, ip, `date`) values ('".$link['href']."','".$_SERVER['HTTP_USER_AGENT']."','".$_SERVER['REMOTE_ADDR']."',now());");
					}
					}
				}
				
				if (isset($this->request->get['route']) && !isset($hasCanonical) && (strpos($this->request->get['route'], 'error') === false)) {
					if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])) {
					$this->db->query("insert into " . DB_PREFIX . "bots_report (link, bot, ip, `date`) values ('".$this->url->link($this->request->get['route'])."','".$_SERVER['HTTP_USER_AGENT']."','".$_SERVER['REMOTE_ADDR']."',now());");
					}
				}
				
				$this->data['canonical_link'] = '';
				$canonicals = $this->config->get('canonicals'); 
				if (!isset($hasCanonical) && isset($this->request->get['route']) && (isset($canonicals['canonicals_extended']))) {
					$this->data['canonical_link'] = $this->url->link($this->request->get['route']);					
					}
				
				
		$this->data['styles'] = $this->document->getStyles();

                require_once(DIR_SYSTEM . 'nitro/core/core.php');
                require_once(DIR_SYSTEM . 'nitro/core/cdn.php');

                $this->data['styles'] = nitroCDNResolve($this->data['styles']);
            
		$this->data['scripts'] = $this->document->getScripts();

                require_once(DIR_SYSTEM . 'nitro/core/core.php');
                require_once(DIR_SYSTEM . 'nitro/core/cdn.php');
                
                $this->data['scripts'] = nitroCDNResolve($this->data['scripts']);
            
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
		$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		$this->data['name'] = $this->config->get('config_name');
		
		if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->data['icon'] = $server . 'image/' . $this->config->get('config_icon');
		} else {
			$this->data['icon'] = '';
		}
		
		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = '';
		}		
		
		$this->language->load('common/header');
		

			$extendedseo = $this->config->get('extendedseo'); 
			if ((isset($extendedseo['trim_descriptions'])) && ($this->data['description']) && (strlen($this->data['description']) > 160)) {
				$pos=strpos($this->data['description'], ' ', 156);
				$this->data['description'] = substr($this->data['description'],0,156). ' ...'; 
			}
			if ((isset($extendedseo['trim_titles'])) && ($this->data['title']) && (strlen($this->data['title']) > 60)) {
				$pos=strpos($this->data['title'], ' ', 56);
				$this->data['title'] = substr($this->data['title'],0,56). ' ...'; 
			}
			

				$this->data['richsnippets'] = $this->config->get('richsnippets');
				$richsnippets = $this->config->get('richsnippets');
				if (isset($richsnippets['googlepublisher']) && isset($richsnippets['googleid'])) {
					array_push($this->data['links'], array('href'=>'https://plus.google.com/'.$richsnippets['googleid'],'rel'=>'publisher'));
					}
				$this->data['socialseo'] = '';
				if (isset($richsnippets['ogsite']) & (!isset($this->request->get['route']) || ($this->request->get['route'] == 'common/home'))) {
					$this->data['socialseo'] .= '
<meta property="og:type" content="website"/>
<meta property="og:title" content="'.$this->data['title'].'"/>
<meta property="og:image" content="'.$this->data['logo'].'"/>
<meta property="og:site_name" content="'.$this->data['name'].'"/>
<meta property="og:url" content="'.$server.'"/>
<meta property="og:description" content="'.$this->data['description'].'"/>';
					}
				if (isset($richsnippets['twittersite']) & (!isset($this->request->get['route']) || ($this->request->get['route'] == 'common/home'))) {
					$this->data['socialseo'] .= '
<meta name="twitter:card" content="summary" />';
if (isset($richsnippets['twitteruser'])) { 
	$this->data['socialseo'] .= '
<meta name="twitter:site" content="'.$richsnippets['twitteruser'].'" />';
	} 
$this->data['socialseo'] .= '
<meta name="twitter:title" content="'.$this->data['title'].'" />
<meta name="twitter:description" content="'.$this->data['description'].'" />
<meta name="twitter:image" content="'.$this->data['logo'].'" />';
}
				if (isset($this->request->get['route']) && ($this->request->get['route'] == 'product/product')) {
					$this->data['socialseo'] .=  $this->document->getSocialSeo(); 
					}
					
			
		$this->data['text_home'] = $this->language->get('text_home');
		$this->data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		$this->data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
    	$this->data['text_search'] = $this->language->get('text_search');
		$this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
		$this->data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));
		$this->data['text_account'] = $this->language->get('text_account');
    	$this->data['text_checkout'] = $this->language->get('text_checkout');
				
		$this->data['home'] = $this->url->link('common/home');
		$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['shopping_cart'] = $this->url->link('checkout/cart');
		$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
		
		// Daniel's robot detector
		$status = true;
		
		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", trim($this->config->get('config_robots')));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;

					break;
				}
			}
		}
		
		// A dirty hack to try to set a cookie for the multi-store feature
		$this->load->model('setting/store');
		
		$this->data['stores'] = array();
		
		if ($this->config->get('config_shared') && $status) {
			$this->data['stores'][] = $server . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();
			
			$stores = $this->model_setting_store->getStores();
					
			foreach ($stores as $store) {
				$this->data['stores'][] = $store['url'] . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();
			}
		}
				
		// Search		
		if (isset($this->request->get['search'])) {
			$this->data['search'] = $this->request->get['search'];
		} else {
			$this->data['search'] = '';
		}
		
		// Menu
		$this->load->model('catalog/category');
		
		$this->load->model('catalog/product');
		
		$this->data['categories'] = array();
					
		$categories = $this->model_catalog_category->getCategories(0);
		
		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();
				
				$children = $this->model_catalog_category->getCategories($category['category_id']);
				
				foreach ($children as $child) {
					$data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);
					
					//$product_total = (getNitroPersistence('Enabled') && getNitroPersistence('ProductCountFix') && !$this->config->get('config_product_count')) ? 0 :  $this->model_catalog_product->getTotalProducts($data);
					$product_total = (getNitroPersistence('Enabled') && getNitroPersistence('ProductCountFix') && !$this->config->get('config_product_count')) ? 0 :  '';
									
					$children_data[] = array(
						//'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
						'name'  => $child['name'],
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);						
				}
				
				// Level 1
				$this->data['categories'][] = array(
'sort_order' => !empty($category['sort_order']) ? $category['sort_order'] : 0,
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}
		
		/* Start Facebook Set */
		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			// Decode URL
			if (isset($this->request->get['_route_'])) {
				$parts = explode('/', $this->request->get['_route_']);
				
				foreach ($parts as $part) {
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");
					
					if ($query->num_rows) {
						$url = explode('=', $query->row['query']);
						
						if ($url[0] == 'product_id') {
							$this->request->get['product_id'] = $url[1];							
						}
						
						if ($url[0] == 'category_id') {
							if (!isset($this->request->get['path'])) {
								$this->request->get['path'] = $url[1];
							} else {
								$this->request->get['path'] .= '_' . $url[1];
							}
						}	
						
						if ($url[0] == 'manufacturer_id') {
							$this->request->get['manufacturer_id'] = $url[1];
						}
						
						if ($url[0] == 'information_id') {
							$this->request->get['information_id'] = $url[1];
						}	
					} else {
						$this->request->get['route'] = 'error/not_found';	
					}
				}
				
				if (isset($this->request->get['product_id'])) {
					$this->request->get['route'] = 'product/product';
				} elseif (isset($this->request->get['path'])) {
					$this->request->get['route'] = 'product/category';
				} elseif (isset($this->request->get['manufacturer_id'])) {
					$this->request->get['route'] = 'product/manufacturer/info';
				} elseif (isset($this->request->get['information_id'])) {
					$this->request->get['route'] = 'information/information';
				}
			}
		}
		
		$this->load->model("setting/setting");
		$facebook_login_config= $this->model_setting_setting->getSetting("facebook_set");
		$route= ( isset($this->request->get['route']) ) ? $this->request->get['route'] : "";
		$theme= $this->config->get('config_template');
		$this->data['fbset']= array();
		$this->data['fbset']= $facebook_login_config;
		
		/* Start Facebook Social Shopping */		
		$add_to_html_tag= "";
		$fb_social_shopping_selector= "";
		$page_product_status= 0;		
		if( $route == "product/product" ){
			$product_url= $this->url->link("product/product", 'product_id=' . $this->request->get['product_id'], "SSL");
			$fb_social_shopping= array( 'fb_like', 'fb_send', 'fb_comment');
			$ct_fbml= 0;
			foreach( $fb_social_shopping as $item ){
				$field= "config_manages_" . $item;
				if( isset($facebook_login_config[$field]['display']) && $facebook_login_config[$field]['display'] ){
					switch ($field){
						case "config_manages_fb_like":
						$facebook_login_config[$field]['html']= '<fb:like href="' . $product_url . 
						'" send="true" width="470" show_faces="false"></fb:like>';
						break;
						case "config_manages_fb_comment":
						$facebook_login_config[$field]['html']= '<fb:comments  class="xfbml" ' . 
						'href="' . $product_url . '" width="470" num_posts="' . 
						$facebook_login_config[$field]['number_post'] . '"></fb:comments>';
						break;
					}
					$this->data['fbset'][$field]= $facebook_login_config[$field];
					$ct_fbml++;
				}
			}
			
			// Adding FB XML namespace attribute
			if( $ct_fbml ){
				$add_to_html_tag= ' xmlns:fb="http://ogp.me/ns/fb#"';
				$page_product_status= 1;
				$selectors= array("product/product"=>".right");
				$fb_social_shopping_selector= ( isset($selectors[$route]) ) ? $selectors[$route] : "";
				
				$fb_social_shopping= $facebook_login_config['config_manages_fb_comment'];
				$style= ( isset($fb_social_shopping['position_type']) && $fb_social_shopping['position_type'] ) ? 1 : 0;
				$fb_social_shopping_selector= ( $style ) ?  $fb_social_shopping_selector : 
				$fb_social_shopping['position_selector'];
			}
		}
		$this->data['fbset']['add_to_html_tag']= $add_to_html_tag;
		$this->data['fbset']['social_shopping_selector']= $fb_social_shopping_selector;
		$this->data['fbset']['page_product_status']= $page_product_status;
		/* End Facebook Social Shopping */
		// Start Facebook Login Configuration
		$dir_vqmod= str_replace("system", "vqmod", DIR_SYSTEM);
		$file_path= $dir_vqmod . "xml/facebook_set.xml";
		$handle= fopen($file_path, "r+");
		$xmlstr= fread($handle, filesize($file_path));
		fclose($handle);
		
		if( class_exists("SimpleXMLElement") ){
			$xmlconfig= new SimpleXMLElement($xmlstr);
			$selected_theme= $this->config->get('config_template');
			$tpl_name= (string)$xmlconfig->file[2]['name'];
			$regex_tpl= "/^catalog\/view\/theme\/(\w+)\/template\/common\/header\.tpl$/";
			$replacement= 'catalog/view/theme/' . $selected_theme . '/template/common/header.tpl';
			$new_config_tpl_name= preg_replace($regex_tpl, $replacement, $tpl_name);
			
			if( $tpl_name != $new_config_tpl_name ){
				// Change and Save XML Configuration
				$xmlconfig->file[2]['name']= $new_config_tpl_name;
				$xmlconfig->asXML($file_path);
			}
		}		
		// End Facebook Login Configuration
                

				$this->load->model('module/iblog');

				if ($this->model_module_iblog->is_installed()) {
					$iBlogSetting = $this->model_module_iblog->getSetting('iBlog', $this->config->get('config_store_id'));

					if (!empty($iBlogSetting['iBlog']['Enabled']) && $iBlogSetting['iBlog']['Enabled'] == 'yes') {
						$this->data['iBlog'] = $iBlogSetting['iBlog'];
						
						$this->data['iblog_og'] = $this->model_module_iblog->getOgData();

						if ($iBlogSetting['iBlog']['MainLinkEnabled'] == 'yes' && !empty($iBlogSetting['iBlog']['LinkTitle'][$this->config->get('config_language_id')])) {
							if (empty($this->data['categories'])) {
								$this->data['categories'] = array();
							}

							$this->data['categories'][] = array(
								'name'			=> $iBlogSetting['iBlog']['LinkTitle'][$this->config->get('config_language_id')],
								'children' 		=> array(),
								'column'   		=> 1,
								'sort_order' 	=> $iBlogSetting['iBlog']['LinkSortOrder'],
								'href'     		=> $this->url->link('module/iblog/listing')
							);

							if (!function_exists('cmpCategoriesOrder')) {
								function cmpCategoriesOrder($a, $b) {
									if (empty($a['sort_order']) || empty($b['sort_order'])) {
										return 0;
									}

									if ($a['sort_order'] == $b['sort_order']) {
										return 0;
									}
									
									return ($a['sort_order'] < $b['sort_order']) ? -1 : 1;
								}
							}

							uasort($this->data['categories'], 'cmpCategoriesOrder');
						}
					}
				}
			
		$this->children = array(
			'module/language',
			'module/currency',
			'module/cart'
		);
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/header.tpl';
		} else {
			$this->template = 'default/template/common/header.tpl';
		}
		
    	$this->render();
	} 	
}
?>
