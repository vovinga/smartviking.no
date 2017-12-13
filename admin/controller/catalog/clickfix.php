<?php 

/*******************************************************************************
*                                 Opencart SEO Pack                            *
*                             © Copyright Ovidiu Fechete                       *
*                              email: ovife21@gmail.com                        *
*                Below source-code or any part of the source-code              *
*                          cannot be resold or distributed.                    *
*******************************************************************************/

class ControllerCatalogClickFix extends Controller { 
	private $error = array();
 
	public function index() {
	
		$this->load->language('catalog/clickfix');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('clickfix', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('catalog/clickfix', 'token=' . $this->session->data['token'], 'SSL'));
		}
	
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/clickfix', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
	
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['token'] = $this->session->data['token'];
		$this->data['action'] = $this->url->link('catalog/clickfix', 'token=' . $this->session->data['token'], 'SSL');
		
		
		$meter = array();
		
		$this->data['aboutseourls'] = '';
		$this->data['fixseourls'] = false;
		
		$query = $this->db->query("select count(*) as total from " . DB_PREFIX . "url_alias where `query` like 'product_id=%';");
		$queryt = $this->db->query("select count(*) as total from " . DB_PREFIX . "product_description;");
		$q = (($query->row['total'] >= $queryt->row['total'])? $queryt->row['total'] : $query->row['total']);
		$meter[] .= ($queryt->row['total']>0)?($q/$queryt->row['total']):1;
		$this->data['aboutseourls'] .= $q.'/'.$queryt->row['total'].' SEO URLs for products '.(($query->row['total'] >= $queryt->row['total'])? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').'</br>';
		if ($query->row['total'] < $queryt->row['total']) $this->data['fixseourls'] = true;
		
		$query = $this->db->query("select count(*) as total from " . DB_PREFIX . "url_alias where `query` like 'category_id=%';");
		$queryt = $this->db->query("select count(*) as total from " . DB_PREFIX . "category_description;");
		$q = (($query->row['total'] >= $queryt->row['total'])? $queryt->row['total'] : $query->row['total']);
		$meter[] .= ($queryt->row['total']>0)?($q/$queryt->row['total']):1;
		$this->data['aboutseourls'] .= $q.'/'.$queryt->row['total'].' SEO URLs for categories '.(($query->row['total'] >= $queryt->row['total'])? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').' </br>';
		if ($query->row['total'] < $queryt->row['total']) $this->data['fixseourls'] = true;
		
		$query = $this->db->query("select count(*) as total from " . DB_PREFIX . "url_alias where `query` like 'manufacturer_id=%';");
		$queryt = $this->db->query("select count(*) as total from " . DB_PREFIX . "manufacturer;");
		$q = (($query->row['total'] >= $queryt->row['total'])? $queryt->row['total'] : $query->row['total']);
		$meter[] .= ($queryt->row['total']>0)?($q/$queryt->row['total']):1;
		$this->data['aboutseourls'] .= $q.'/'.$queryt->row['total'].' SEO URLs for manufacturers '.(($query->row['total'] >= $queryt->row['total'])? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').' </br>';
		if ($query->row['total'] < $queryt->row['total']) $this->data['fixseourls'] = true;
		
		$query = $this->db->query("select count(*) as total from " . DB_PREFIX . "url_alias where `query` like 'information_id=%';");
		$queryt = $this->db->query("select count(*) as total from " . DB_PREFIX . "information_description;");
		$q = (($query->row['total'] >= $queryt->row['total'])? $queryt->row['total'] : $query->row['total']);
		$meter[] .= ($queryt->row['total']>0)?($q/$queryt->row['total']):1;
		$this->data['aboutseourls'] .= $q.'/'.$queryt->row['total'].' SEO URLs for information '.(($query->row['total'] >= $queryt->row['total'])? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').' </br>';
		if ($query->row['total'] < $queryt->row['total']) $this->data['fixseourls'] = true;
		
		if ($this->data['fixseourls']) $this->data['fixseourls'] = $this->url->link('catalog/clickfix/fixseourls', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['aboutmetadescription'] = '';
		$this->data['fixmetadescription'] = false;
		
		$query = $this->db->query("select count(*) as total from " . DB_PREFIX . "product_description where meta_description <> '';");
		$queryt = $this->db->query("select count(*) as total from " . DB_PREFIX . "product_description;");
		$q = (($query->row['total'] >= $queryt->row['total'])? $queryt->row['total'] : $query->row['total']);
		$meter[] .= ($queryt->row['total']>0)?($q/$queryt->row['total']):1;
		$this->data['aboutmetadescription'] .= $q.'/'.$queryt->row['total'].' meta descriptions for product pages '.(($query->row['total'] >= $queryt->row['total'])? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').'</br>';
		if ($query->row['total'] < $queryt->row['total']) $this->data['fixmetadescription'] = true;
		
		$query = $this->db->query("select count(*) as total from " . DB_PREFIX . "category_description where meta_description <> '';");
		$queryt = $this->db->query("select count(*) as total from " . DB_PREFIX . "category_description;");
		$q = (($query->row['total'] >= $queryt->row['total'])? $queryt->row['total'] : $query->row['total']);
		$meter[] .= ($queryt->row['total']>0)?($q/$queryt->row['total']):1;
		$this->data['aboutmetadescription'] .= $q.'/'.$queryt->row['total'].' meta descriptions for category pages '.(($query->row['total'] >= $queryt->row['total'])? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').'</br>';
		if ($query->row['total'] < $queryt->row['total']) $this->data['fixmetadescription'] = true;
		
		$query = $this->db->query("select count(*) as total from " . DB_PREFIX . "information_description where meta_description <> '';");
		$queryt = $this->db->query("select count(*) as total from " . DB_PREFIX . "information_description;");
		$q = (($query->row['total'] >= $queryt->row['total'])? $queryt->row['total'] : $query->row['total']);
		$meter[] .= ($queryt->row['total']>0)?($q/$queryt->row['total']):1;
		$this->data['aboutmetadescription'] .= $q.'/'.$queryt->row['total'].' meta descriptions for info pages '.(($query->row['total'] >= $queryt->row['total'])? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').'</br>';
		if ($query->row['total'] < $queryt->row['total']) $this->data['fixmetadescription'] = true;
		
		if ($this->data['fixmetadescription']) $this->data['fixmetadescription'] = $this->url->link('catalog/clickfix/fixmetadescription', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['aboutmetakeyword'] = '';
		$this->data['fixmetakeyword'] = false;
		
		$query = $this->db->query("select count(*) as total from " . DB_PREFIX . "product_description where meta_keyword <> '';");
		$queryt = $this->db->query("select count(*) as total from " . DB_PREFIX . "product_description;");
		$q = (($query->row['total'] >= $queryt->row['total'])? $queryt->row['total'] : $query->row['total']);
		$meter[] .= ($queryt->row['total']>0)?($q/$queryt->row['total']):1;
		$this->data['aboutmetakeyword'] .= $q.'/'.$queryt->row['total'].' meta keywords for product pages '.(($query->row['total'] >= $queryt->row['total'])? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').'</br>';
		if ($query->row['total'] < $queryt->row['total']) $this->data['fixmetakeyword'] = true;
		
		$query = $this->db->query("select count(*) as total from " . DB_PREFIX . "category_description where meta_keyword <> '';");
		$queryt = $this->db->query("select count(*) as total from " . DB_PREFIX . "category_description;");
		$q = (($query->row['total'] >= $queryt->row['total'])? $queryt->row['total'] : $query->row['total']);
		$meter[] .= ($queryt->row['total']>0)?($q/$queryt->row['total']):1;
		$this->data['aboutmetakeyword'] .= $q.'/'.$queryt->row['total'].' meta keywords for category pages '.(($query->row['total'] >= $queryt->row['total'])? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').'</br>';
		if ($query->row['total'] < $queryt->row['total']) $this->data['fixmetakeyword'] = true;
		
		$query = $this->db->query("select count(*) as total from " . DB_PREFIX . "information_description where meta_keyword <> '';");
		$queryt = $this->db->query("select count(*) as total from " . DB_PREFIX . "information_description;");
		$q = (($query->row['total'] >= $queryt->row['total'])? $queryt->row['total'] : $query->row['total']);
		$meter[] .= ($queryt->row['total']>0)?($q/$queryt->row['total']):1;
		$this->data['aboutmetakeyword'] .= $q.'/'.$queryt->row['total'].' meta keywords for info pages '.(($query->row['total'] >= $queryt->row['total'])? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').'</br>';
		if ($query->row['total'] < $queryt->row['total']) $this->data['fixmetakeyword'] = true;
		
		if ($this->data['fixmetakeyword']) $this->data['fixmetakeyword'] = $this->url->link('catalog/clickfix/fixmetakeyword', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['aboutmetatitle'] = '';
		$this->data['fixmetatitle'] = false;
		
		$query = $this->db->query("select count(*) as total from " . DB_PREFIX . "product_description where custom_title <> '';");
		$queryt = $this->db->query("select count(*) as total from " . DB_PREFIX . "product_description;");
		$q = (($query->row['total'] >= $queryt->row['total'])? $queryt->row['total'] : $query->row['total']);
		$meter[] .= ($queryt->row['total']>0)?($q/$queryt->row['total']):1;
		$this->data['aboutmetatitle'] .= $q.'/'.$queryt->row['total'].' meta titles for product pages '.(($query->row['total'] >= $queryt->row['total'])? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').'</br>';
		if ($query->row['total'] < $queryt->row['total']) $this->data['fixmetatitle'] = true;
		
		$query = $this->db->query("select count(*) as total from " . DB_PREFIX . "category_description where custom_title <> '';");
		$queryt = $this->db->query("select count(*) as total from " . DB_PREFIX . "category_description;");
		$q = (($query->row['total'] >= $queryt->row['total'])? $queryt->row['total'] : $query->row['total']);
		$meter[] .= ($queryt->row['total']>0)?($q/$queryt->row['total']):1;
		$this->data['aboutmetatitle'] .= $q.'/'.$queryt->row['total'].' meta titles for category pages '.(($query->row['total'] >= $queryt->row['total'])? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').'</br>';
		if ($query->row['total'] < $queryt->row['total']) $this->data['fixmetatitle'] = true;
		
		$query = $this->db->query("select count(*) as total from " . DB_PREFIX . "information_description where custom_title <> '';");
		$queryt = $this->db->query("select count(*) as total from " . DB_PREFIX . "information_description;");
		$q = (($query->row['total'] >= $queryt->row['total'])? $queryt->row['total'] : $query->row['total']);
		$meter[] .= ($queryt->row['total']>0)?($q/$queryt->row['total']):1;
		$this->data['aboutmetatitle'] .= $q.'/'.$queryt->row['total'].' meta titles for info pages '.(($query->row['total'] >= $queryt->row['total'])? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').'</br>';
		if ($query->row['total'] < $queryt->row['total']) $this->data['fixmetatitle'] = true;
		
		if ($this->data['fixmetatitle']) $this->data['fixmetatitle'] = $this->url->link('catalog/clickfix/fixmetatitle', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['aboutmlseo'] = '';
		$this->data['fixmlseo'] = false;
				
		$mlseo = $this->config->get('mlseo');
		$tmlseo = 2;
		$q = ((count($mlseo) > $tmlseo)? $tmlseo : count($mlseo));
		$meter[] .= $q/$tmlseo;
		$this->data['aboutmlseo'] .= $q.'/'.$tmlseo.' features for Multi-Language enabled '.(($q >= $tmlseo)? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').' </br>';
		if ($q < $tmlseo) $this->data['fixmlseo'] = true;
		if ($this->data['fixmlseo']) $this->data['fixmlseo'] = $this->url->link('catalog/clickfix/fixmlseo', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['aboutcanonicals'] = '';
		$this->data['fixcanonicals'] = false;
				
		$canonicals = $this->config->get('canonicals');
		$tcanonicals = 6;
		$q = ((count($canonicals) > $tcanonicals)? $tcanonicals : count($canonicals));
		$meter[] .= $q/$tcanonicals;
		$this->data['aboutcanonicals'] .= $q.'/'.$tcanonicals.' features for Canonical Links enabled '.(($q >= $tcanonicals)? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').' </br>';
		if ($q < $tcanonicals) $this->data['fixcanonicals'] = true;
		if ($this->data['fixcanonicals']) $this->data['fixcanonicals'] = $this->url->link('catalog/clickfix/fixcanonicals', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['aboutrichsnippets'] = '';
		$this->data['fixrichsnippets'] = false;
				
		$richsnippets = $this->config->get('richsnippets');
		$cnt = 0;
		if (isset($richsnippets)) {foreach ($richsnippets as $element => $value) if ($value == 1) {$cnt++;}}
		$trichsnippets = 10;
		$q = (($cnt > $trichsnippets)? $trichsnippets : $cnt);
		$meter[] .= $q/$trichsnippets;
		$this->data['aboutrichsnippets'] .= $q.'/'.$trichsnippets.' features for Rich Snippets and Social SEO enabled '.(($q >= $trichsnippets)? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').' </br>';
		if ($q < $trichsnippets) $this->data['fixrichsnippets'] = true;
		if ($this->data['fixrichsnippets']) $this->data['fixrichsnippets'] = $this->url->link('catalog/clickfix/fixrichsnippets', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['aboutseopagination'] = '';
		$this->data['fixseopagination'] = false;
				
		$seopagination = $this->config->get('seopagination');
		$tseopagination = 2;
		$q = ((count($seopagination) > $tseopagination)? $tseopagination : count($seopagination));
		$meter[] .= $q/$tseopagination;
		$this->data['aboutseopagination'] .= $q.'/'.$tseopagination.' features for SEO Pagination enabled '.(($q >= $tseopagination)? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').' </br>';
		if ($q < $tseopagination) $this->data['fixseopagination'] = true;
		if ($this->data['fixseopagination']) $this->data['fixseopagination'] = $this->url->link('catalog/clickfix/fixseopagination', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['aboutextendedseo'] = '';
		$this->data['fixextendedseo'] = false;
				
		$extendedseo = $this->config->get('extendedseo');
		$textendedseo = 8;
		$q = ((count($extendedseo) > $textendedseo)? $textendedseo : count($extendedseo));
		$meter[] .= $q/$textendedseo;
		$this->data['aboutextendedseo'] .= $q.'/'.$textendedseo.' features for Canonical Links enabled '.(($q >= $textendedseo)? '<b style="color:green">- OK</b>':'<b style="color:red">- FIX</b>').' </br>';
		if ($q < $textendedseo) $this->data['fixextendedseo'] = true;
		if ($this->data['fixextendedseo']) $this->data['fixextendedseo'] = $this->url->link('catalog/clickfix/fixextendedseo', 'token=' . $this->session->data['token'], 'SSL');
		
		
		
		$this->data['seometer'] = array_sum($meter) / count($meter);
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
	
	
	
		$this->template = 'catalog/clickfix.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	public function fixseourls() {
	
		require_once(DIR_APPLICATION . 'controller/catalog/seopack.php');
		$seo = new ControllerCatalogSeoPack($this->registry);
		$seo-> seourls(1);
		$this->session->data['success'] = "SEO URLs were fixed.";
		
		$this->redirect($this->url->link('catalog/clickfix', 'token=' . $this->session->data['token'], 'SSL'));
	
	}
	public function fixmetakeyword() {
	
		$parameters = $this->config->get('seopack_parameters');
		
		$this->db->query("update " . DB_PREFIX . "category_description set meta_keyword = lower(name) where meta_keyword = '';");
		$this->db->query("update " . DB_PREFIX . "information_description set meta_keyword = lower(title) where meta_keyword = '';");
		
		$query = $this->db->query("select pd.name as pname, cd.name as cname, pd.language_id as language_id, pd.product_id as product_id, p.sku as sku, p.model as model, p.upc as upc, m.name as brand  from " . DB_PREFIX . "product_description pd
				left join " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
				inner join " . DB_PREFIX . "product p on pd.product_id = p.product_id
				left join " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id and cd.language_id = pd.language_id
				left join " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id
				where pd.meta_keyword = '';");

		foreach ($query->rows as $product) {
					
			$bef = array("%", "_","\"","'","\\");
			$aft = array("", " ", " ", " ", "");
			
			$included = explode('%', str_replace(array(' ',','), '', (($parameters['keywords'])?$parameters['keywords']:'%p%c')));
			
			$tags = array();
			
			if (in_array("p", $included)) {$tags = array_merge($tags, explode(' ',trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['pname']), ENT_COMPAT, "UTF-8")))));}
			if (in_array("c", $included)) {$tags = array_merge($tags, explode(' ',trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['cname']), ENT_COMPAT, "UTF-8")))));}
			if (in_array("s", $included)) {$tags = array_merge($tags, explode(' ',trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['sku']), ENT_COMPAT, "UTF-8")))));}
			if (in_array("m", $included)) {$tags = array_merge($tags, explode(' ',trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['model']), ENT_COMPAT, "UTF-8")))));}
			if (in_array("u", $included)) {$tags = array_merge($tags, explode(' ',trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['upc']), ENT_COMPAT, "UTF-8")))));}
			if (in_array("b", $included)) {$tags = array_merge($tags, explode(' ',trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['brand']), ENT_COMPAT, "UTF-8")))));}
			
			$keywords = '';
			
			foreach ($tags as $tag)
				{
				if (strlen($tag) > 2) 
					{
					
					$keywords = $keywords.' '.strtolower($tag);
					
					}
				}
				
			
			$exists = $this->db->query("select count(*) as times from " . DB_PREFIX . "product_description where product_id = ".$product['product_id']." and language_id = ".$product['language_id']." and meta_keyword like '%". htmlspecialchars($keywords) ."%';");
			
					foreach ($exists->rows as $exist)
						{
						$count = $exist['times'];
						}
			$exists = $this->db->query("select length(meta_keyword) as leng from " . DB_PREFIX . "product_description where product_id = ".$product['product_id']." and language_id = ".$product['language_id'].";");
			
					foreach ($exists->rows as $exist)
						{
						$leng = $exist['leng'];
						}

			if (($count == 0) && ($leng < 255)) {$this->db->query("update " . DB_PREFIX . "product_description set meta_keyword = concat(meta_keyword, '". htmlspecialchars($keywords) ."') where product_id = ".$product['product_id']." and language_id = ".$product['language_id'].";");}			
	
			}
	
		$this->session->data['success'] = "Meta Keywords were fixed.";
		
		$this->redirect($this->url->link('catalog/clickfix', 'token=' . $this->session->data['token'], 'SSL'));
	
	}
	private function first_sentence($content) {

		$content = strip_tags(html_entity_decode($content));
		$pos = strpos($content, '.');
		   
		if($pos === false) {
			return $content;
		}
		else {
			return substr($content, 0, $pos+1);
		}
	   
	}
	
	public function fixmetadescription() {
	
		$parameters = $this->config->get('seopack_parameters');
		
		$this->db->query("update " . DB_PREFIX . "category_description set meta_description = concat(name, case description when '' then '' else ' - ' end, substring_index(description, '.', 1)) where meta_description = '';");
		$this->db->query("update " . DB_PREFIX . "information_description set meta_description = concat(title, case description when '' then '' else ' - ' end, substring_index(description, '.', 1)) where meta_description = '';");

		$query = $this->db->query("select pd.name as pname, p.price as price, cd.name as cname, pd.description as pdescription, pd.language_id as language_id, pd.product_id as product_id, p.model as model, p.sku as sku, p.upc as upc, m.name as brand from " . DB_PREFIX . "product_description pd
				left join " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
				inner join " . DB_PREFIX . "product p on pd.product_id = p.product_id
				left join " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id and cd.language_id = pd.language_id
				left join " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id
				where pd.meta_description = '';");

		foreach ($query->rows as $product) {
						
			$bef = array("%", "_","\"","'","\\", "\r", "\n");
			$aft = array("", " ", " ", " ", "", "", "");
			
			$ncategory = trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['cname']), ENT_COMPAT, "UTF-8")));
			$nproduct = trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['pname']), ENT_COMPAT, "UTF-8")));
			$model = trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['model']), ENT_COMPAT, "UTF-8")));
			$sku = trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['sku']), ENT_COMPAT, "UTF-8")));
			$upc = trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['upc']), ENT_COMPAT, "UTF-8")));
			$sentence = trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$this->first_sentence($product['pdescription'])), ENT_COMPAT, "UTF-8")));
			$brand = trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['brand']), ENT_COMPAT, "UTF-8")));
			$price = trim($this->db->escape(html_entity_decode(str_replace($bef, $aft, number_format($product['price'], 2)), ENT_COMPAT, "UTF-8")));
			
			$bef = array("%c", "%p", "%m", "%s", "%u", "%f", "%b", "%$");
			$aft = array($ncategory, $nproduct, $model, $sku, $upc, $sentence, $brand, $price);
			
			$meta_description = str_replace($bef, $aft,  (($parameters['metas'])?$parameters['metas']:'%p - %f'));
			
			$exists = $this->db->query("select count(*) as times from " . DB_PREFIX . "product_description where product_id = ".$product['product_id']." and language_id = ".$product['language_id']." and meta_description not like '%".htmlspecialchars($meta_description)."%';");
			
					foreach ($exists->rows as $exist)
						{
						$count = $exist['times'];
						}
			
			if ($count) {$this->db->query("update " . DB_PREFIX . "product_description set meta_description = concat(meta_description, '". htmlspecialchars($meta_description) ."') where product_id = ".$product['product_id']." and language_id = ".$product['language_id'].";");}			
				
			}
	
		$this->session->data['success'] = "Meta Descriptions were fixed.";
		
		$this->redirect($this->url->link('catalog/clickfix', 'token=' . $this->session->data['token'], 'SSL'));
	
	}
	public function fixmetatitle() {
	
		$parameters = $this->config->get('seopack_parameters');
		
		$this->db->query("update " . DB_PREFIX . "category_description set custom_title = name where custom_title = '';");
		$this->db->query("update " . DB_PREFIX . "information_description set custom_title = title where custom_title = '';");
		
		
		$query = $this->db->query("select pd.name as pname, p.price as price, p.tax_class_id as tax_class_id, cd.name as cname, pd.description as pdescription, pd.language_id as language_id, pd.product_id as product_id, p.model as model, p.sku as sku, p.upc as upc, m.name as brand from " . DB_PREFIX . "product_description pd
				left join " . DB_PREFIX . "product_to_category pc on pd.product_id = pc.product_id
				inner join " . DB_PREFIX . "product p on pd.product_id = p.product_id
				left join " . DB_PREFIX . "category_description cd on cd.category_id = pc.category_id and cd.language_id = pd.language_id
				left join " . DB_PREFIX . "manufacturer m on m.manufacturer_id = p.manufacturer_id
				where pd.custom_title = '';");

		foreach ($query->rows as $product) {
						
			$bef = array("%", "_","\"","'","\\", "\r", "\n");
			$aft = array("", " ", " ", " ", "", "", "");
			
			$ncategory = trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['cname']), ENT_COMPAT, "UTF-8")));
			$nproduct = trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['pname']), ENT_COMPAT, "UTF-8")));
			$model = trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['model']), ENT_COMPAT, "UTF-8")));
			$sku = trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['sku']), ENT_COMPAT, "UTF-8")));
			$upc = trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['upc']), ENT_COMPAT, "UTF-8")));
			$brand = trim($this->db->escape(html_entity_decode(str_replace($bef, $aft,$product['brand']), ENT_COMPAT, "UTF-8")));
			$price = trim($this->db->escape(html_entity_decode(str_replace($bef, $aft, number_format($product['price'] * (($product['tax_class_id'] == 9)?1.21:1.06), 2)), ENT_COMPAT, "UTF-8")));
			
			$bef = array("%c", "%p", "%m", "%s", "%u", "%b", "%$");
			$aft = array($ncategory, $nproduct, $model, $sku, $upc, $brand, $price);
			
			$ctitles = str_replace($bef, $aft, (($parameters['ctitles'])?$parameters['ctitles']:'%p'));
			$this->db->query("update " . DB_PREFIX . "product_description set custom_title = '". htmlspecialchars($ctitles) ."' where product_id = ".$product['product_id']." and language_id = ".$product['language_id'].";");			
					
			}
	
		$this->session->data['success'] = "Meta Titles were fixed.";
		
		$this->redirect($this->url->link('catalog/clickfix', 'token=' . $this->session->data['token'], 'SSL'));
	
	}
	public function fixmlseo() {
		
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('mlseo', array('mlseo'=> array( 'subfolder' => 1 ,'hreflang' => 1 )));
		$this->session->data['success'] = "Multi Language SEO was fixed.";
		
		$this->redirect($this->url->link('catalog/clickfix', 'token=' . $this->session->data['token'], 'SSL'));
	
	}
	public function fixcanonicals() {
		
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('canonicals', array('canonicals'=> array(  'canonicals_categories' => 1, 'canonicals_brands' => 1, 'canonicals_info' => 1, 'canonicals_home' => 1, 'canonicals_specials' => 1, 'canonicals_extended' => 1  )));
		$this->session->data['success'] = "Canonical Links were fixed.";
		
		$this->redirect($this->url->link('catalog/clickfix', 'token=' . $this->session->data['token'], 'SSL'));
	
	}
	public function fixrichsnippets() {
		
		$this->load->model('setting/setting');
		$richsnippets = $this->config->get('richsnippets');
		$this->model_setting_setting->editSetting('richsnippets',  array('richsnippets'=> array('breadcrumbs' => 1, 'product' => 1, 'offer' => 1, 'rating' => 1, 'store' => 1, 'twittersite' => 1, 'twitterproduct' => 1, 'ogsite' => 1, 'ogproduct' => 1, 'googlepublisher' => 1, 'googleid' =>((isset($richsnippets['googleid']))?$richsnippets['googleid']:''), 'twitteruser' =>((isset($richsnippets['twitteruser']))?$richsnippets['twitteruser']:''))));
		$this->session->data['success'] = "Rich Snippets and Social SEO were fixed.";
		
		$this->redirect($this->url->link('catalog/clickfix', 'token=' . $this->session->data['token'], 'SSL'));
	
	}
	public function fixseopagination() {
		
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('seopagination', array('seopagination'=> array( 'pagination' => 1, 'prevnext' => 1 )));
		$this->session->data['success'] = "SEO Pagination was fixed.";
		
		$this->redirect($this->url->link('catalog/clickfix', 'token=' . $this->session->data['token'], 'SSL'));
	
	}
	public function fixextendedseo() {
		
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('extendedseo', array('extendedseo'=> array( 'seotags' => 1, 'productseo' => 1, 'categoryintitle' => 1, 'link' => 1, 'slash' => 1, 'robots' => 1, 'trim_titles' => 1, 'trim_descriptions' => 1 )));
		$this->session->data['success'] = "Extened SEO was fixed.";
		
		$this->redirect($this->url->link('catalog/clickfix', 'token=' . $this->session->data['token'], 'SSL'));
	
	}
	private function validate() {
		if (!$this->user->hasPermission('modify', 'catalog/clickfix')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	

	
}
?>