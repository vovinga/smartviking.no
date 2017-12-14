<?php
class ControllerExtensionHbSitemap extends Controller {
	
	private $error = array(); 
	private $language_id = 3;
	
	public function index() {   
		$this->load->language('extension/hb_sitemap');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('setting/hb_sitemap');
		
		if ($this->config->get('hb_sitemap_installed') <> 1){
			$this->redirect($this->url->link('extension/hb_sitemap/install', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		
		//Save the settings if the user has submitted the admin form (ie if someone has pressed save).
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('hb_sitemap', $this->request->post);	
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('extension/hb_sitemap', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		
		$text_strings = array(
				'heading_title',
				'button_save',
				'button_cancel',
				'tab_sitemap',
				'tab_customlist',
				'tab_seoalias',
				'tab_setting',
				'header_product',
				'header_others',
				'header_sitemaps',
				'header_allstore',
				'col_batch_id',
				'col_batch_range',
				'col_batch_status',
				'col_batch_tstatus',
				'col_batch_date',
				'col_header',
				'col_priority',
				'col_freq',
				'col_product',
				'col_category',
				'col_brand',
				'col_info',
				'col_tag',
				'col_action',
				'text_no_records',
				'text_batch_generated',
				'text_category_map',
				'text_brand_map',
				'text_info_map',
				'text_tag_map',
				'text_index_map',
				'text_custom_map',  
				'text_link_count',
				'text_automatic',
				'btn_batch',
				'btn_add',
				'btn_dir',
				'btn_remove',
				'btn_auto_product','btn_auto_tag','btn_auto_category','btn_auto_brand','btn_auto_info','btn_auto_custom','btn_auto_index',
				'btn_generate',
				'btn_clear',
				'btn_clear_batch'
		);
		
		foreach ($text_strings as $text) {
			$this->data[$text] = $this->language->get($text);
		}
		
		$this->load->model('setting/store');
		$this->data['stores'] = array();

		$this->data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name') . $this->language->get('text_default'),
			'url'      => HTTP_CATALOG
		);

		$this->data['store_total'] = $store_total = $this->model_setting_store->getTotalStores();

		$results = $this->model_setting_store->getStores();

		foreach ($results as $result) {
			$this->data['stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name'],
				'url'      => $result['url']
			);
		}
		
		//This creates an error message. The error['warning'] variable is set by the call to function validate() in this controller (below)
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (!$this->config->get('hb_sitemap_automatic')){
			$blog_link = 'http://www.huntbee.com/opencart-blog/opencart-seo-google-xml-sitemap?utm_source='.HTTP_CATALOG.'&utm_medium=installed_extension_16836&utm_campaign=XML%20Sitemap%20blog';
			$this->data['error_warning'] = 'SETTINGS NOT SAVED YET. KINDLY CHOOSE AND SAVE THE SETTINGS BEFORE GENERATING SITEMAPS! <hr> <a href="'.$blog_link.'" target="_blank">Read about XML Sitemap & How to use it effectively...</a>';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/hb_sitemap', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('extension/hb_sitemap', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['uninstall'] = $this->url->link('extension/hb_sitemap/uninstall', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		
		foreach ($this->data['stores'] as $result){
	 		$store_id = $result['store_id'];	
			$this->data['all_batches'.$store_id] =  $this->model_setting_hb_sitemap->getbatch($store_id);
			$this->data['all_links'.$store_id] =  $this->model_setting_hb_sitemap->getlink($store_id);

		}
		
		$this->data['all_batches'] =  $this->model_setting_hb_sitemap->getallbatch();
		
		$this->data['hb_sitemap_max_entries'] = $this->config->get('hb_sitemap_max_entries');
		
		$this->data['hb_sitemap_product_priority'] = $this->config->get('hb_sitemap_product_priority');
		$this->data['hb_sitemap_category_priority'] = $this->config->get('hb_sitemap_category_priority');
		$this->data['hb_sitemap_brand_priority'] = $this->config->get('hb_sitemap_brand_priority');
		$this->data['hb_sitemap_info_priority'] = $this->config->get('hb_sitemap_info_priority');
		$this->data['hb_sitemap_tag_priority'] = $this->config->get('hb_sitemap_tag_priority');
		
		$this->data['hb_sitemap_product_freq'] = $this->config->get('hb_sitemap_product_freq');
		$this->data['hb_sitemap_category_freq'] = $this->config->get('hb_sitemap_category_freq');
		$this->data['hb_sitemap_brand_freq'] = $this->config->get('hb_sitemap_brand_freq');
		$this->data['hb_sitemap_info_freq'] = $this->config->get('hb_sitemap_info_freq');
		$this->data['hb_sitemap_tag_freq'] = $this->config->get('hb_sitemap_tag_freq');
		$this->data['hb_sitemap_automatic'] = $this->config->get('hb_sitemap_automatic');
		
		$this->template = 'extension/hb_sitemap.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);

		$this->response->setOutput($this->render());

	}
		
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/hb_sitemap')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
	
	public function stores(){
		$this->load->model('setting/store');
		$this->data['stores'] = array();

		$this->data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name') . $this->language->get('text_default'),
			'url'      => HTTP_CATALOG
		);

		$store_total = $this->model_setting_store->getTotalStores();

		$results = $this->model_setting_store->getStores();

		foreach ($results as $result) {
			$this->data['stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name'],
				'url'      => $result['url']
			);
		}
		
		return $this->data['stores'];

	}
	
	public function estimatebatch($store_id = 0){
		if (isset($_POST['store_id'])){
			$store_id = $_POST['store_id'];
		}
		

		$product_count = $this->db->query("SELECT count(*) as count
													FROM  `" . DB_PREFIX . "product` a, `" . DB_PREFIX . "product_to_store` b
													WHERE a.product_id = b.product_id
													and a.status = 1
													and b.store_id = $store_id ORDER BY a.product_id ASC ");
		$product_count = $product_count->row['count'];
		
		$no_of_product = $this->config->get('hb_sitemap_max_entries'); //number of product links per page
		
		$number_of_batch = ceil($product_count / $no_of_product);
		$offset = 0;
		
		$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_sitemap_batch` WHERE `batch_id` > $number_of_batch and store_id= $store_id");
		
		for ($t = 1; $t<=$number_of_batch; $t++){
			
			$ranges = $this->db->query("SELECT min(c.product_id) as min_id , max(c.product_id) as max_id
									   FROM (SELECT a.product_id FROM " . DB_PREFIX . "product a , " . DB_PREFIX . "product_to_store b where a.product_id = b.product_id and a.status = 1 and b.store_id = $store_id ORDER BY a.product_id ASC LIMIT $no_of_product OFFSET $offset) c");
			$min_id = (isset($ranges->row['min_id']))? $ranges->row['min_id'] :'0';
			$max_id = (isset($ranges->row['max_id']))? $ranges->row['max_id'] :'0';
			
			$range_check = $this->db->query("SELECT count(*) as range_row_count FROM `" . DB_PREFIX . "hb_sitemap_batch` WHERE min_range = $min_id and max_range = $max_id and batch_id = $t and store_id= $store_id");
			$range_row = $range_check->row['range_row_count'];
			if ($range_row == 0){
			$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_sitemap_batch` WHERE `batch_id` = $t and store_id= $store_id");	
			$this->db->query("INSERT INTO `" . DB_PREFIX . "hb_sitemap_batch`(`batch_id`, `min_range`, `max_range`, `pstatus`, `tstatus`, `store_id`) VALUES ('".$t."','".$min_id."','".$max_id."','0','0','".$store_id."')");
			}
			
			$offset = $offset + $no_of_product;
			
		} //foreach ends 
		
		$this->resetdate();
		
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Batch Estimated Succesfully!</div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function getstoreurl($store_id){
		if ($store_id == 0){
			return $url = HTTPS_CATALOG;
		}else{
			$query = $this->db->query("SELECT url FROM `" . DB_PREFIX . "store` WHERE store_id = $store_id LIMIT 1");
			return $url = $query->row['url'];
		}	
	}
	
	public function resetbatch(){
			$store_id = $_POST['store_id'];
			$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_sitemap_batch` WHERE store_id = $store_id");
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Batch Records Deleted!</div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function resetproductbatch(){
			$id = $_POST['id'];
			$column = $_POST['column'];
			$this->db->query("UPDATE `" . DB_PREFIX . "hb_sitemap_batch` SET `".$column."` = 0 WHERE id = $id");
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Reset Successful </div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function resetsitemapdir(){
			$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_sitemap_batch`");
			$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_sitemaps`");
			$files = glob('../hbsitemaps/*'); // get all file names
			foreach($files as $file){ // iterate files
			  if(is_file($file))
			    unlink($file); // delete file
			}	
			$results = $this->stores();
			foreach ($results as $result){
				$store_id = $result['store_id'];
				$store_id = ($store_id == 0)? '' : $store_id;
				$indexfile = '../sitemap_index'.$store_id.'.xml';
				if(is_file($indexfile))
					unlink($indexfile); // delete file
			}
			
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Sitemap Directory Cleared!</div>';
		$this->response->setOutput(json_encode($json));	
	}

	
	public function autogenerateproductmap(){
		$this->generateProducturl();
		$results = $this->stores();
		foreach ($results as $result){
			$store_id = $result['store_id'];
			$this->estimatebatch($store_id);
		}

		$query = $this->db->query("SELECT id FROM `" . DB_PREFIX . "hb_sitemap_batch` WHERE pstatus = 0");
		$results = $query->rows;
		if (isset($results)){
		foreach ($results as $result){
			$this->generateProductMap($result['id']);
		}
		$this->autogenerateindexmap();
		}
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> XML Sitemap Generated</div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function autogeneratetagmap(){
		$results = $this->stores();
		foreach ($results as $result){
			$store_id = $result['store_id'];
			$this->estimatebatch($store_id);
		}

		$query = $this->db->query("SELECT id FROM `" . DB_PREFIX . "hb_sitemap_batch` WHERE tstatus = 0");
		$results = $query->rows;
		if (isset($results)){
		foreach ($results as $result){
			$this->generateTagMap($result['id']);
		}
		$this->autogenerateindexmap();
		}
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> XML Sitemap Generated</div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function autogeneratecategorymap(){
		$this->generateCategoryurl();
		$results = $this->stores();
		foreach ($results as $result){
			$store_id = $result['store_id'];
			$this->generateCategoryMap($store_id);
		}
		$this->autogenerateindexmap();
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> XML Sitemap Generated</div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function autogeneratebrandmap(){
		$this->generateBrandurl();
		$results = $this->stores();
		foreach ($results as $result){
			$store_id = $result['store_id'];
			$this->generateBrandMap($store_id);
		}
		$this->autogenerateindexmap();
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> XML Sitemap Generated</div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function autogenerateinfomap(){
		$this->generateInfourl();
		$results = $this->stores();
		foreach ($results as $result){
			$store_id = $result['store_id'];
			$this->generateInfoMap($store_id);
		}
		$this->autogenerateindexmap();
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> XML Sitemap Generated</div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function autogeneratecustommap(){
		$results = $this->stores();
		foreach ($results as $result){
			$store_id = $result['store_id'];
			$this->generateCustomMap($store_id);
		}
		$this->autogenerateindexmap();
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> XML Sitemap Generated</div>';
		$this->response->setOutput(json_encode($json));	
	}

	
	public function autogenerateindexmap(){
		$results = $this->stores();
		foreach ($results as $result){
			$store_id = $result['store_id'];
			$this->generateIndexMap($store_id);
		}
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> XML Sitemap Generated</div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function generateProductMap($id = 0){
		if (isset($_POST['id'])){
			$id = $_POST['id'];
		}
			
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "hb_sitemap_batch` WHERE id = $id LIMIT 1");
		$store_id = $query->row['store_id'];
		$batch_id = $query->row['batch_id'];
		$min_range = $query->row['min_range'];
		$max_range = $query->row['max_range'];
		
		$url = $this->getstoreurl($store_id);
		
		$this->load->model('setting/hb_sitemap');
		$enable = $this->model_setting_hb_sitemap->checkproduct($store_id);
		
	if ($enable > 0){
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
		xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
		
		$product_change_freq = $this->config->get('hb_sitemap_product_freq');
		$product_priority = $this->config->get('hb_sitemap_product_priority');
	
		$products = $this->db->query("SELECT a.product_id, a.date_modified, a.image FROM  `" . DB_PREFIX . "product` a, `" . DB_PREFIX . "product_to_store` b
									 WHERE a.product_id = b.product_id and a.status = 1 and b.store_id = $store_id and a.product_id >= $min_range and a.product_id <= $max_range ORDER BY a.product_id ASC ");
		$products_count = $products->num_rows;
		$products = $products->rows;
		
		foreach ($products as $product){
			$product_id = $product['product_id'];
			$image = $this->escapecodeurl($product['image']);
			$date_modified = date('Y-m-d', strtotime($product['date_modified']));
			
			$sql = "SELECT * FROM  `" . DB_PREFIX . "url_alias` WHERE `query` like('product_id=".$product_id."') AND language_id=".$this->language_id." LIMIT 1";
			
			$result = $this->db->query($sql);
			
			
			//$xml .="\n\t\t".$sql.' '.$result->num_rows;
			
			if (($result->num_rows) > 0){
				$keyword = urlencode($result->row['keyword']);
				$xml .="<url>\n\t\t";
				$xml .= "<loc>".$url.$keyword."</loc>\n\t\t";
				if (!empty($image)){
					//$xml .= "<image:image> <image:loc>".$url."image/".$image."</image:loc>   </image:image>";
				}
				if ($this->getadditionalproductimage($product_id,$url)){
					//$xml .= $this->getadditionalproductimage($product_id,$url);
				}
				$xml .= "<changefreq>".$product_change_freq."</changefreq>\n\t\t";
				$xml .= "<priority>".$product_priority."</priority>\n\t\t";
				$xml .= "<lastmod>".$date_modified."</lastmod>\n\t\t";
				$xml.="</url>\n\t";
			}else{
				$keyword = 'index.php?route=product/product&amp;product_id='.$product_id;
				$xml .="<url>\n\t\t";
				$xml .= "<loc>".$url.$keyword."</loc>\n\t\t";
				if (!empty($image)){
					//$xml .= "<image:image> <image:loc>".$url."image/".$image."</image:loc>   </image:image>";
				}
				if ($this->getadditionalproductimage($product_id,$url)){
					//$xml .= $this->getadditionalproductimage($product_id,$url);
				}
				$xml .= "<changefreq>".$product_change_freq."</changefreq>\n\t\t";
				$xml .= "<priority>".$product_priority."</priority>\n\t\t";
				$xml .= "<lastmod>".$date_modified."</lastmod>\n\t\t";
				$xml.="</url>\n\t";
			}
		}//end of foreach
		$xml.="</urlset>\n\r";
		header('content-type: application/xml');
		$xmlobj=new SimpleXMLElement($xml);
		$xmlobj->asXML("../hbsitemaps/prod_sitemap".$batch_id.$store_id.".xml");
		
		$this->db->query("UPDATE `" . DB_PREFIX . "hb_sitemap_batch` SET pstatus = 1, count = $products_count WHERE id = $id");
		$link = $url."hbsitemaps/prod_sitemap".$batch_id.$store_id.".xml";
		$this->insertsitemap($link,$store_id);
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> XML Sitemap Generated</div>';
		}else{
			$json['success'] = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> No Links Found!</div>';
		}
		$this->response->setOutput(json_encode($json));	
	}
	
	public function generateTagMap($id = 0){
		if (isset($_POST['id'])){
			$id = $_POST['id'];
		}
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "hb_sitemap_batch` WHERE id = $id LIMIT 1");
		$store_id = $query->row['store_id'];
		$batch_id = $query->row['batch_id'];
		$min_range = $query->row['min_range'];
		$max_range = $query->row['max_range'];
		
		$url = $this->getstoreurl($store_id);
		
		$this->load->model('setting/hb_sitemap');
		$enable_product = $this->model_setting_hb_sitemap->checkproduct($store_id);
		$enable_tag = $this->model_setting_hb_sitemap->checktag($store_id);
		$enable = $enable_product * $enable_tag;
		
	if ($enable <> 0){
		
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		
		$tag_change_freq = $this->config->get('hb_sitemap_tag_freq');
		$tag_priority = $this->config->get('hb_sitemap_tag_priority');

		$products = $this->db->query("SELECT a.product_id, a.date_modified FROM  `" . DB_PREFIX . "product` a, `" . DB_PREFIX . "product_to_store` b WHERE a.product_id = b.product_id and a.status = 1 and b.store_id = $store_id and a.product_id >= $min_range and a.product_id <= $max_range ORDER BY a.product_id ASC ");
		$products_count = $products->num_rows;
		$products = $products->rows;
		
		foreach ($products as $product){
			$product_id = $product['product_id'];
			//$date_modified = date('Y-m-d', strtotime($product['date_modified']));
			if ($this->getproducttags($product_id)){
				$tags = $this->getproducttags($product_id);
				$tags = explode(',',$tags);
				foreach ($tags as $tag){
					if (strlen($tag)>2){
						//$tag = urlencode($tag);
						$xml .="<url>\n\t\t";
						$xml .= "<loc>".$url."index.php?route=product/search&amp;tag=".urlencode($tag)."</loc>\n\t\t";
						$xml .= "<changefreq>".$tag_change_freq."</changefreq>\n\t\t";
						$xml .= "<priority>".$tag_priority."</priority>\n\t\t";
						//$xml .= "<lastmod>".$date_modified."</lastmod>\n\t\t";
						$xml .="</url>\n\t";
					}
				}
			}
		}//end of foreach
		$xml.="</urlset>\n\r";
		header('content-type: application/xml');
		$xmlobj=new SimpleXMLElement($xml);
		$xmlobj->asXML("../hbsitemaps/prod_tag_sitemap".$batch_id.$store_id.".xml");
		
		$this->db->query("UPDATE `" . DB_PREFIX . "hb_sitemap_batch` SET tstatus = 1, count = $products_count WHERE id = $id");
		$link = $url."hbsitemaps/prod_tag_sitemap".$batch_id.$store_id.".xml";
		$this->insertsitemap($link,$store_id);
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> XML Sitemap Generated</div>';
		}else{
			$json['success'] = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> No Links Found!</div>';
		}

		$this->response->setOutput(json_encode($json));	
	}
	
	public function getadditionalproductimage($product_id,$url){
		$results = $this->db->query("SELECT image FROM  `" . DB_PREFIX . "product_image` WHERE product_id= $product_id");
			if (($results->num_rows) > 0){
				$images = $results->rows;
				$text = '';
				foreach ($images as $image){
					$text = $text."<image:image> <image:loc>".$url."image/".$this->escapecodeurl($image['image'])."</image:loc>   </image:image>";
				}
				return $text;
			}else{
				return false;
			}
	}
	
	public function getproducttags($product_id){
	$results = $this->db->query("SELECT tag FROM  `" . DB_PREFIX . "product_description` WHERE product_id= $product_id");
			if (($results->num_rows) > 0){
				$tags = $results->rows;
				$text = '';
				foreach ($tags as $tag){
					if (strlen($tag['tag']) > 2){
						$text = $text.','.$tag['tag'];
					}
				}
				return $text;
			}else{
				return false;
			}
	}
	
	public function generateCategoryMap($store_id = 0){
		if (isset($_POST['store_id'])){
			$store_id = $_POST['store_id'];
		}
		$this->load->model('setting/hb_sitemap');
		$enable = $this->model_setting_hb_sitemap->checkcategory($store_id);
		
	if ($enable > 0){	
		$url = $this->getstoreurl($store_id);
			
		header('content-type: application/xml');
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
		xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
		
		$cat_change_freq = $this->config->get('hb_sitemap_category_freq');
		$cat_priority = $this->config->get('hb_sitemap_category_priority');


		$categories = $this->db->query("SELECT a.category_id, a.date_modified, a.image FROM  `" . DB_PREFIX . "category` a, `" . DB_PREFIX . "category_to_store` b WHERE a.category_id = b.category_id and a.status = 1 and b.store_id = $store_id ORDER BY a.category_id ASC ");
		$categories = $categories->rows;
		foreach ($categories as $category){
			$category_id = $category['category_id'];
			$image = $this->escapecodeurl($category['image']);
			$date_modified = date('Y-m-d', strtotime($category['date_modified']));
			$result = $this->db->query("SELECT * FROM  `" . DB_PREFIX . "url_alias` WHERE `query` like('category_id=".$category_id."')  AND language_id=".$this->language_id." LIMIT 1");
			if (($result->num_rows) > 0){
				$keyword = urlencode($result->row['keyword']);
				$xml .="<url>\n\t\t";
				$xml .= "<loc>".$url.$keyword."</loc>\n\t\t";
				if (strlen($image) > 5){
					//$xml .= "<image:image> <image:loc>".$url."image/".$image."</image:loc> </image:image>\n\t\t";
				}
				$xml .= "<changefreq>".$cat_change_freq."</changefreq>\n\t\t";
				$xml .= "<priority>".$cat_priority."</priority>\n\t\t";
				$xml .= "<lastmod>".$date_modified."</lastmod>\n\t\t";
				$xml.="</url>\n\t";
			}else{
				$keyword = 'index.php?route=product/category&amp;path='.$category_id;
				$xml .="<url>\n\t\t";
				$xml .= "<loc>".$url.$keyword."</loc>\n\t\t";
				if (strlen($image) > 5){
					//$xml .= "<image:image> <image:loc>".$url."image/".$image."</image:loc> </image:image>\n\t\t";
				}
				$xml .= "<changefreq>".$cat_change_freq."</changefreq>\n\t\t";
				$xml .= "<priority>".$cat_priority."</priority>\n\t\t";
				$xml .= "<lastmod>".$date_modified."</lastmod>\n\t\t";
				$xml.="</url>\n\t";
			}
		}
			
		$xml.="</urlset>\n\r";
		$xmlobj=new SimpleXMLElement($xml);
		$xmlobj->asXML("../hbsitemaps/category_sitemap".$store_id.".xml");
		
		$link = $url."hbsitemaps/category_sitemap".$store_id.".xml";
		$this->insertsitemap($link,$store_id);
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> XML Sitemap Generated</div>';
		}else{
			$json['success'] = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> No Links Found!</div>';
		}

		$this->response->setOutput(json_encode($json));	
	}
	
	public function generateBrandMap($store_id = 0){
		if (isset($_POST['store_id'])){
			$store_id = $_POST['store_id'];
		}
		$this->load->model('setting/hb_sitemap');
		$enable = $this->model_setting_hb_sitemap->checkbrand($store_id);
		
	if ($enable > 0){
		$url = $this->getstoreurl($store_id);
			
		header('content-type: application/xml');
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		
		$brand_change_freq = $this->config->get('hb_sitemap_brand_freq');
		$brand_priority = $this->config->get('hb_sitemap_brand_priority');

		$manufacturers = $this->db->query("SELECT a.manufacturer_id FROM  `" . DB_PREFIX . "manufacturer` a, `" . DB_PREFIX . "manufacturer_to_store` b WHERE a.manufacturer_id = b.manufacturer_id and b.store_id = $store_id ORDER BY a.manufacturer_id ASC ");
		$manufacturers = $manufacturers->rows;
		foreach ($manufacturers as $manufacturer){
			$manufacturer_id = $manufacturer['manufacturer_id'];
			$result = $this->db->query("SELECT * FROM  `" . DB_PREFIX . "url_alias` WHERE `query` like('manufacturer_id=".$manufacturer_id."')  AND language_id=".$this->language_id." LIMIT 1");
			if (($result->num_rows) > 0){
				$keyword = urlencode($result->row['keyword']);
				$xml .="<url>\n\t\t";
				$xml .= "<loc>".$url.$keyword."</loc>\n\t\t";
				$xml .= "<changefreq>".$brand_change_freq."</changefreq>\n\t\t";
				$xml .= "<priority>".$brand_priority."</priority>\n\t\t";
				$xml.="</url>\n\t";
			}else{
				$keyword = 'index.php?route=product/manufacturer/info&amp;manufacturer_id='.$manufacturer_id;
				$xml .="<url>\n\t\t";
				$xml .= "<loc>".$url.$keyword."</loc>\n\t\t";
				$xml .= "<changefreq>".$brand_change_freq."</changefreq>\n\t\t";
				$xml .= "<priority>".$brand_priority."</priority>\n\t\t";
				$xml.="</url>\n\t";
			}
		}
			
		$xml.="</urlset>\n\r";
		$xmlobj=new SimpleXMLElement($xml);
		$xmlobj->asXML("../hbsitemaps/brand_sitemap".$store_id.".xml");
		
		$link = $url."hbsitemaps/brand_sitemap".$store_id.".xml";
		$this->insertsitemap($link,$store_id);
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> XML Sitemap Generated</div>';
		}else{
			$json['success'] = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> No Links Found!</div>';
		}

		$this->response->setOutput(json_encode($json));	
	}
	
	public function generateInfoMap($store_id = 0){
		if (isset($_POST['store_id'])){
			$store_id = $_POST['store_id'];
		}
		$this->load->model('setting/hb_sitemap');
		$enable = $this->model_setting_hb_sitemap->checkinfo($store_id);
		
	if ($enable > 0){

		$url = $this->getstoreurl($store_id);
			
		header('content-type: application/xml');
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		
		$info_change_freq = $this->config->get('hb_sitemap_info_freq');
		$info_priority = $this->config->get('hb_sitemap_info_priority');

		$informations = $this->db->query("SELECT a.information_id FROM  `" . DB_PREFIX . "information` a, `" . DB_PREFIX . "information_to_store` b WHERE a.information_id = b.information_id and a.status = 1  and b.store_id = $store_id ORDER BY a.information_id ASC ");
		$informations = $informations->rows;
		foreach ($informations as $information){
			$information_id = $information['information_id'];
			$result = $this->db->query("SELECT * FROM  `" . DB_PREFIX . "url_alias` WHERE `query` like('information_id=".$information_id."') AND language_id=".$this->language_id." LIMIT 1");
			if (($result->num_rows) > 0){
				$keyword = urlencode($result->row['keyword']);
				$xml .="<url>\n\t\t";
				$xml .= "<loc>".$url.$keyword."</loc>\n\t\t";
				$xml .= "<changefreq>".$info_change_freq."</changefreq>\n\t\t";
				$xml .= "<priority>".$info_priority."</priority>\n\t\t";
				$xml.="</url>\n\t";
			}else{
				$keyword = 'index.php?route=information/information&amp;information_id='.$information_id;
				$xml .="<url>\n\t\t";
				$xml .= "<loc>".$url.$keyword."</loc>\n\t\t";
				$xml .= "<changefreq>".$info_change_freq."</changefreq>\n\t\t";
				$xml .= "<priority>".$info_priority."</priority>\n\t\t";
				$xml.="</url>\n\t";
			}
		}
			
		$xml.="</urlset>\n\r";
		$xmlobj=new SimpleXMLElement($xml);
		$xmlobj->asXML("../hbsitemaps/info_sitemap".$store_id.".xml");
		
		$link = $url."hbsitemaps/info_sitemap".$store_id.".xml";
		$this->insertsitemap($link,$store_id);
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> XML Sitemap Generated</div>';
		}else{
			$json['success'] = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> No Links Found!</div>';
		}

		$this->response->setOutput(json_encode($json));	
	}
	
	public function generateCustomMap($store_id = 0){
		if (isset($_POST['store_id'])){
			$store_id = $_POST['store_id'];
		}
		$customs = $this->db->query("SELECT * FROM  `" . DB_PREFIX . "hb_sitemap_custom` WHERE store_id = $store_id ORDER BY date_added ASC ");
		$custom_rows = $customs->num_rows;
		$customs = $customs->rows;
		
		if ($custom_rows > 0){
		$url = $this->getstoreurl($store_id);	
		header('content-type: application/xml');
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		
		foreach ($customs as $custom){
				$loc = $custom['loc'];
				$freq = $custom['freq'];
				$priority = $custom['priority'];
				$xml .="<url>\n\t\t";
				$xml .= "<loc>".$loc."</loc>\n\t\t";
				$xml .= "<changefreq>".$freq."</changefreq>\n\t\t";
				$xml .= "<priority>".$priority."</priority>\n\t\t";
				$xml.="</url>\n\t";
		}
			
		$xml.="</urlset>\n\r";
		$xmlobj=new SimpleXMLElement($xml);
		$xmlobj->asXML("../hbsitemaps/custom_sitemap".$store_id.".xml");
		
		$link = $url."hbsitemaps/custom_sitemap".$store_id.".xml";
		$this->insertsitemap($link,$store_id);
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> XML Sitemap Generated</div>';
		}else{
			$json['success'] = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> No Links Found!</div>';
		}

		$this->response->setOutput(json_encode($json));	
	}

	
	public function generateIndexMap($store_id = 0){
		if (isset($_POST['store_id'])){
			$store_id = $_POST['store_id'];
		}

		$url = $this->getstoreurl($store_id);
		
		$this->load->model('setting/hb_sitemap');
		$results =  $this->model_setting_hb_sitemap->getsitemaps($store_id);
		
		if ($results){	
		header('content-type: application/xml');
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		
		foreach ($results as $result){
			$xml .="<sitemap>\n\t\t";
			$xml .= "<loc>".$result['url']."</loc>\n\t\t";
			$xml .= "<lastmod>".date('c',time())."</lastmod>\n\t\t";
			$xml.="</sitemap>\n\t";
		}
			
		$xml.="</sitemapindex>\n\r";
		
		if ($store_id == 0){
			$store_id = '';
		}
		$xmlobj=new SimpleXMLElement($xml);
		$xmlobj->asXML("../sitemap_index".$store_id.".xml");
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> XML Sitemap Generated</div>';
		}else{
			$json['success'] = '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> No Links Found!</div>';
		}

		$this->response->setOutput(json_encode($json));	
	}
		
		public function insertsitemap($url, $store_id){
			$counts = $this->db->query("SELECT count(*) as count FROM  `" . DB_PREFIX . "hb_sitemaps` WHERE `url` = '".$url."' and store_id = $store_id");
			if ($counts->row['count'] == 0){
				$this->db->query("INSERT INTO  `" . DB_PREFIX . "hb_sitemaps` (`url`,`store_id`) VALUES ('".$this->db->escape($url)."', '".$store_id."')");
			}
		}
		
		public function addlink(){
			$store_id = $_POST['store_id'];
			$loc = $_POST['loc'];
			$freq = $_POST['freq'];
			$priority = $_POST['priority'];
			$counts = $this->db->query("SELECT count(*) as count FROM  `" . DB_PREFIX . "hb_sitemap_custom` WHERE `loc` = '".$loc."' and store_id = $store_id");
			if ($counts->row['count'] == 0){
				$this->db->query("INSERT INTO  `" . DB_PREFIX . "hb_sitemap_custom` (`loc`,`freq`,`priority`,`store_id`) VALUES ('".$this->db->escape($loc)."', '".$freq."', '".$priority."', '".$store_id."')");
			}
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Link Added Successfully. Reload the page to see changes.</div>';
			$this->response->setOutput(json_encode($json));		
		}
		
		public function removelink(){
			$id = $_POST['id'];
			$this->db->query("DELETE FROM `" . DB_PREFIX . "hb_sitemap_custom` WHERE id = $id");
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> Link has been Removed!</div>';
		    $this->response->setOutput(json_encode($json));	
		}

		
		public function install(){
			$this->load->model('setting/hb_sitemap');
			$this->model_setting_hb_sitemap->install();
			$this->data['success'] = 'This extension has been installed successfully';
			$this->redirect($this->url->link('extension/hb_sitemap', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		public function uninstall(){
				$this->load->model('setting/hb_sitemap');
				$this->model_setting_hb_sitemap->uninstall();
				$this->data['success'] = 'This extension is uninstalled successfully';
				$this->redirect($this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
	public function resetdate(){
		$this->db->query("UPDATE `" . DB_PREFIX . "product` SET `date_modified` = now() WHERE `date_modified` like '0000-00-00%' or `date_modified` IS NULL;");
		$this->db->query("UPDATE `" . DB_PREFIX . "category` SET `date_modified` = now() WHERE `date_modified` like '0000-00-00%' or `date_modified` IS NULL;");
	}
	
	public function escapecodeurl($url){
		$url = str_replace('&','&amp;',$url);
		$url = str_replace('\'','&apos;',$url);
		return $url;
	}
	
	public function loadsitemapfiles() {
		$this->data['storeid'] = $store_id = $this->request->get['store_id'];
		$this->data['store_url'] = $this->request->get['store_url'];
		$this->data['tpl_store_id'] =  ($store_id == 0)? '':$store_id;

		$this->language->load('extension/hb_sitemap');
		$this->load->model('setting/hb_sitemap');
		$this->data['text_sitemap_not_found'] = $this->language->get('text_sitemap_not_found');
		
		$text_strings = array(
				'header_others',
				'header_sitemaps',
				'col_batch_id',
				'col_batch_range',
				'col_batch_status',
				'col_batch_tstatus',
				'col_batch_date',
				'text_no_records',
				'text_batch_generated',
				'text_category_map',
				'text_brand_map',
				'text_info_map',
				'text_tag_map',
				'text_index_map',
				'text_custom_map', 
				'btn_batch',
				'btn_generate',
				'btn_clear',
				'btn_clear_batch'
		);
		
		foreach ($text_strings as $text) {
			$this->data[$text] = $this->language->get($text);
		}
		
		$this->load->model('setting/store');
		$this->data['stores'] = array();

		$this->data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name') . $this->language->get('text_default'),
			'url'      => HTTP_CATALOG
		);

		$store_total = $this->model_setting_store->getTotalStores();

		$results = $this->model_setting_store->getStores();

		foreach ($results as $result) {
			$this->data['stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name'],
				'url'      => $result['url']
			);
		}
		
		foreach ($this->data['stores'] as $result){
	 		$store_id = $result['store_id'];	
			$this->data['all_batches'.$store_id] =  $this->model_setting_hb_sitemap->getbatch($store_id);
			$this->data['all_links'.$store_id] =  $this->model_setting_hb_sitemap->getlink($store_id);

		}
		
		$this->data['all_batches'] =  $this->model_setting_hb_sitemap->getallbatch();

		$this->template = 'extension/hbsitemapfiles.tpl';
		$this->response->setOutput($this->render());
	}
	
	//seo url alias
	
	public function loadseourlholder() {
		$this->language->load('extension/hb_sitemap');
		$this->load->model('setting/hb_sitemap');
		
		$text_strings = array(
				'text_product_seo',
				'text_category_seo',
				'text_information_seo',
				'text_brand_seo',
				'btn_generate_seo',
				'btn_clear',
				'text_available',
				'text_total'
		);
		
		foreach ($text_strings as $text) {
			$this->data[$text] = $this->language->get($text);
		}
		
		$this->data['product_seourl_count'] =  $this->model_setting_hb_sitemap->getCountAlias('product_id');
		$this->data['category_seourl_count'] =  $this->model_setting_hb_sitemap->getCountAlias('category_id');
		$this->data['information_seourl_count'] =  $this->model_setting_hb_sitemap->getCountAlias('information_id');
		$this->data['brand_seourl_count'] =  $this->model_setting_hb_sitemap->getCountAlias('manufacturer_id');
		
		$language_id = $this->model_setting_hb_sitemap->defaultLanguage();
		$this->data['product_total'] =  $this->model_setting_hb_sitemap->getCountRecords('product_description', $language_id);
		$this->data['category_total'] =  $this->model_setting_hb_sitemap->getCountRecords('category_description', $language_id);
		$this->data['information_total'] =  $this->model_setting_hb_sitemap->getCountRecords('information_description', $language_id);
		$this->data['brand_total'] =  $this->model_setting_hb_sitemap->getCountRecordsNL('manufacturer');
		
		$this->template = 'extension/hbseourlholder.tpl';
		$this->response->setOutput($this->render());
	}
	
	public function generateProducturl(){
		$this->load->model('setting/hb_sitemap');
		$language_id = $this->model_setting_hb_sitemap->defaultLanguage();
		$gen = $this->generateurlkeyword('product',$language_id);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Product SEO URL Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-cthumbs-up"></i> Product SEO URL already generated. No empty SEO URL found!</div>';
		}
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateCategoryurl(){
		$this->load->model('setting/hb_sitemap');
		$language_id = $this->model_setting_hb_sitemap->defaultLanguage();
		$gen = $this->generateurlkeyword('category',$language_id);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Category SEO URL Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-cthumbs-up"></i> Category SEO URL already generated. No empty SEO URL found!</div>';
		}
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateInfourl(){
		$this->load->model('setting/hb_sitemap');
		$language_id = $this->model_setting_hb_sitemap->defaultLanguage();
		$gen = $this->generateurlkeyword('information',$language_id);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Information Page SEO URL Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-cthumbs-up"></i> Information Page SEO URL already generated. No empty SEO URL found!</div>';
		}
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateBrandurl(){
		$this->load->model('setting/hb_sitemap');
		$language_id = $this->model_setting_hb_sitemap->defaultLanguage();
		$gen = $this->generateurlkeyword('brand',$language_id);
		if ($gen > 0){
			$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> '.$gen .' Brand SEO URL Generated!</div>';
		}else {
			$json['success'] = '<div class="alert alert-info"><i class="fa fa-cthumbs-up"></i> Brand SEO URL already generated. No empty SEO URL found!</div>';
		}
		$this->response->setOutput(json_encode($json));
	}
	
	public function generateurlkeyword($pagetype,$language_id){
		$this->load->model('setting/hb_sitemap');		
		switch ($pagetype) {
		case "product":
			$records = $this->model_setting_hb_sitemap->productDataView($language_id);
			$count = 0;
			foreach ($records as $record){
				$product_id = $record['product_id'];
				$pname = $record['name'];
			
				if ($this->model_setting_hb_sitemap->getUrlkeyword('product_id', $product_id) == 0){
					$seourl = $this->url_slug($pname);
					if ($this->model_setting_hb_sitemap->checkURLKeyword($seourl) > 0){
						$seourl = $seourl. '-'.$product_id;
					}	
					$query = 'product_id='.$product_id;
					$this->model_setting_hb_sitemap->generateSeoUrl($query, $seourl);	
					$count = $count + 1;				
				}
			}	
	     break;
		 
		 case "category":
			$records = $this->model_setting_hb_sitemap->categoryDataView($language_id);
			$count = 0;
			foreach ($records as $record){
				$category_id = $record['category_id'];
				$cname = $record['name'];
			
				if ($this->model_setting_hb_sitemap->getUrlkeyword('category_id', $category_id) == 0){
					$seourl = $this->url_slug($cname);
					if ($this->model_setting_hb_sitemap->checkURLKeyword($seourl) > 0){
						$seourl = $seourl. '-'.$category_id;
					}	
					$query = 'category_id='.$category_id;
					$this->model_setting_hb_sitemap->generateSeoUrl($query, $seourl);	
					$count = $count + 1;				
				}
			}	
	     break;
		 
		case "information":
			$records = $this->model_setting_hb_sitemap->getIViewBasic($language_id);
			$count = 0;
			foreach ($records as $record){
				$information_id = $record['information_id'];
				$iname = $record['title'];
			
				if ($this->model_setting_hb_sitemap->getUrlkeyword('information_id',$information_id) == 0){
					$seourl = $this->url_slug($iname);
					if ($this->model_setting_hb_sitemap->checkURLKeyword($seourl) > 0){
						$seourl = $seourl. '-'.$information_id;
					}	
					$query = 'information_id='.$information_id;
					$this->model_setting_hb_sitemap->generateSeoUrl($query, $seourl);	
					$count = $count + 1;				
				}
			}	
	     break;
		 
		 case "brand":
			$records = $this->model_setting_hb_sitemap->getMViewBasic();
			$count = 0;
			foreach ($records as $record){
				$manufacturer_id = $record['manufacturer_id'];
				$bname = $record['name'];
			
				if ($this->model_setting_hb_sitemap->getUrlkeyword('manufacturer_id',$manufacturer_id) == 0){
					$seourl = $this->url_slug($bname);
					if ($this->model_setting_hb_sitemap->checkURLKeyword($seourl) > 0){
						$seourl = $seourl. '-'.$manufacturer_id;
					}	
					$query = 'manufacturer_id='.$manufacturer_id;
					$this->model_setting_hb_sitemap->generateSeoUrl($query, $seourl);	
					$count = $count + 1;				
				}
			}	
	     break;
		}//switch end
		return $count;	
	}
	
	public function clearseo(){
		$this->load->model('setting/hb_sitemap');
		$tablename = $_POST['clearname'];
		
		$this->model_setting_hb_sitemap->clearURL($tablename);
		$json['success'] = '<div class="alert alert-success"><i class="fa fa-check-square-o"></i> URL Keyword Cleared Successfully!</div>';
		$this->response->setOutput(json_encode($json));	
	}
	
	public function getseokeyword(){
		$this->load->model('setting/hb_sitemap');
		$title = $_POST['title'];
		$seourl = $this->url_slug($title);
			if ($this->model_setting_hb_sitemap->checkURLKeyword($seourl) > 0){
				$random_value = mt_rand(101,999);
				$seourl = $seourl. '-'.$random_value;
			}
		return $seourl;	
	}
	
	public function url_slug($string){
		  $string = htmlspecialchars_decode($string);
		  $string = $this->cleanwords($string);
		  $string = preg_replace('!\s+!', ' ',$string);
		  $string = str_replace(' ','-',$string);
		  $string = trim(preg_replace('/-+/', '-', $string), '-');
		  return $string;
	}	
	
	public function cleanwords($str, $options = array()) {
		// Make sure string is in UTF-8 and strip invalid UTF-8 characters
		$str = htmlspecialchars_decode($str);
		$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
		$defaults = array(
		'delimiter' => ' ',
		'limit' => null,
		'lowercase' => true,
		'replacements' => array(),
		'transliterate' => true,
		);
		// Merge options
		$options = array_merge($defaults, $options);
		$char_map = array(
		// Latin
		'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
		'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
		'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
		'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
		'ß' => 'ss',
		'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
		'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
		'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
		'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
		'ÿ' => 'y',
		 
		// Latin symbols
		'©' => '(c)',
		 
		// Greek
		'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
		'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
		'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
		'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
		'Ϋ' => 'Y',
		'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
		'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
		'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
		'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
		'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
		 
		// Turkish
		'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
		'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
		 
		// Russian
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
		'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
		'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
		'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
		'Я' => 'Ya',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
		'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
		'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
		'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
		'я' => 'ya',
		 
		// Ukrainian
		'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
		'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
		 
		// Czech
		'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
		'Ž' => 'Z',
		'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
		'ž' => 'z',
		 
		// Polish
		'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
		'Ż' => 'Z',
		'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
		'ż' => 'z',
		
		//Arabic
		"ا"=>"a", "أ"=>"a", "آ"=>"a", "إ"=>"e", "ب"=>"b", "ت"=>"t", "ث"=>"th", "ج"=>"j",
		"ح"=>"h", "خ"=>"kh", "د"=>"d", "ذ"=>"d", "ر"=>"r", "ز"=>"z", "س"=>"s", "ش"=>"sh",
		"ص"=>"s", "ض"=>"d", "ط"=>"t", "ظ"=>"z", "ع"=>"'e", "غ"=>"gh", "ف"=>"f", "ق"=>"q",
		"ك"=>"k", "ل"=>"l", "م"=>"m", "ن"=>"n", "ه"=>"h", "و"=>"w", "ي"=>"y", "ى"=>"a",
		"ئ"=>"'e", "ء"=>"'",   
		"ؤ"=>"'e", "لا"=>"la", "ة"=>"h", "؟"=>"?", "!"=>"!", 
		"ـ"=>"", 
		"،"=>",", 
		"َ‎"=>"a", "ُ"=>"u", "ِ‎"=>"e", "ٌ"=>"un", "ً"=>"an", "ٍ"=>"en", "ّ"=>"",
		
		//persian
		"ا" => "a", "أ" => "a", "آ" => "a", "إ" => "e", "ب" => "b", "ت" => "t", "ث" => "th",
		"ج" => "j", "ح" => "h", "خ" => "kh", "د" => "d", "ذ" => "d", "ر" => "r", "ز" => "z",
		"س" => "s", "ش" => "sh", "ص" => "s", "ض" => "d", "ط" => "t", "ظ" => "z", "ع" => "'e",
		"غ" => "gh", "ف" => "f", "ق" => "q", "ك" => "k", "ل" => "l", "م" => "m", "ن" => "n",
		"ه" => "h", "و" => "w", "ي" => "y", "ى" => "a", "ئ" => "'e", "ء" => "'", 
		"ؤ" => "'e", "لا" => "la", "ک" => "ke", "پ" => "pe", "چ" => "che", "ژ" => "je", "گ" => "gu",
		"ی" => "a", "ٔ" => "", "ة" => "h", "؟" => "?", "!" => "!", 
		"ـ" => "", 
		"،" => ",", 
		"َ‎" => "a", "ُ" => "u", "ِ‎" => "e", "ٌ" => "un", "ً" => "an", "ٍ" => "en", "ّ" => "",
		 
		// Latvian
		'Ā'  =>  'A', 'Č'  =>  'C', 'Ē'  =>  'E', 'Ģ'  =>  'G', 'Ī'  =>  'i', 'Ķ'  =>  'k', 'Ļ'  =>  'L', 'Ņ'  =>  'N',
		'Š'  =>  'S', 'Ū'  =>  'u', 'Ž'  =>  'Z',
		'ā'  =>  'a', 'č'  =>  'c', 'ē'  =>  'e', 'ģ'  =>  'g', 'ī'  =>  'i', 'ķ'  =>  'k', 'ļ'  =>  'l', 'ņ'  =>  'n',
		'š'  =>  's', 'ū'  =>  'u', 'ž'  =>  'z'
		);
		// Make custom replacements
		$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
		// Transliterate characters to ASCII
		if ($options['transliterate']) {
		$str = str_replace(array_keys($char_map), $char_map, $str);
		}
		// Replace non-alphanumeric characters with our delimiter
		$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
		// Remove duplicate delimiters
		$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

		// Remove delimiter from ends
		$str = trim($str, $options['delimiter']);
		return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
		}

}
?>