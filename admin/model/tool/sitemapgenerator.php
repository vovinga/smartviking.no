<?php 
//-----------------------------------------------------
// Sitemap Generator for Opencart v1.5.6   				
// Created by villagedefrance                          		
// contact@villagedefrance.net      						
//-----------------------------------------------------

class ModelToolSitemapGenerator extends Model {	

	public function generate() {
	
		if ((substr(VERSION, 0, 5) == '1.5.5') || (substr(VERSION, 0, 5) == '1.5.6')) {
			$this->language->load('module/sitemapgenerator');
		} else {
			$this->load->language('module/sitemapgenerator');
		}
	
		$output = '';
	
		//Generating sitemaps for categories.
		$fp = fopen("../sitemaps/sitemapcategories.xml", "w+");
		fwrite($fp, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r");
		fwrite($fp, "<?xml-stylesheet type=\"text/xsl\" href=\"../sitemaps/stylesheet/xml-sitemap.xsl\"?>\r");
		fwrite($fp, "<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\" xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r");
		fwrite($fp, $this->getCategories(0));
		fwrite($fp, "</urlset>");
		fclose($fp);
		$output .= "<img src=\"view/image/success.png\" alt=\"\" /> &nbsp; <b>" . HTTP_CATALOG . "sitemaps/sitemapcategories.xml</b><br /><br />";
	
		//Generating sitemaps for products.
		$fp = fopen("../sitemaps/sitemapproducts.xml", "w+");
		fwrite($fp, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r");
		fwrite($fp, "<?xml-stylesheet type=\"text/xsl\" href=\"../sitemaps/stylesheet/xml-sitemap.xsl\"?>\r");
		fwrite($fp, "<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\" xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r");
		fwrite($fp, $this->getProducts());
		fwrite($fp, "</urlset>");
		fclose($fp);
		$output .= "<img src=\"view/image/success.png\" alt=\"\" /> &nbsp; <b>" . HTTP_CATALOG . "sitemaps/sitemapproducts.xml</b><br /><br />";
		
		//Generating sitemaps for manufacturers.
		$fp = fopen("../sitemaps/sitemapmanufacturers.xml", "w+");
		fwrite($fp, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r");
		fwrite($fp, "<?xml-stylesheet type=\"text/xsl\" href=\"../sitemaps/stylesheet/xml-sitemap.xsl\"?>\r");
		fwrite($fp, "<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\" xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r");
		fwrite($fp, $this->getManufacturers());
		fwrite($fp, "</urlset>");
		fclose($fp);
		$output .= "<img src=\"view/image/success.png\" alt=\"\" /> &nbsp; <b>" . HTTP_CATALOG . "sitemaps/sitemapmanufacturers.xml</b><br /><br />";
	
		//Generating sitemaps for information pages.
		$fp = fopen("../sitemaps/sitemappages.xml", "w+");
		fwrite($fp, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r");
		fwrite($fp, "<?xml-stylesheet type=\"text/xsl\" href=\"../sitemaps/stylesheet/xml-sitemap.xsl\"?>\r");
		fwrite($fp, "<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\" xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r");
		fwrite($fp, $this->getInformationPages());
		fwrite($fp, "</urlset>");
		fclose($fp);
		$output .= "<img src=\"view/image/success.png\" alt=\"\" /> &nbsp; <b>" . HTTP_CATALOG . "sitemaps/sitemappages.xml</b><br /><br />";
	
		return $output;
	}

	protected function getCategories($parent_id, $current_path = '') {
		$output = '';
	
		$this->load->model('catalog/sitemapgenerator');
	
		$stores_cat = $this->model_catalog_sitemapgenerator->getAllStores();
	
		if ($stores_cat) {
			foreach ($stores_cat as $store_cat) {
				if ($store_cat['store_id'] != 0) {
					$store_id = $store_cat['store_id'];
					$store_url = $store_cat['url'];
				
					$results = $this->model_catalog_sitemapgenerator->getAllCategories($parent_id, $store_id);
				
					foreach ($results as $result) {
					
						if (!$current_path) {
							$new_path = $result['category_id'];
						} else {
							$new_path = $current_path . '_' . $result['category_id'];
						}
					
						$output .= $this->generateLinkNode($store_url . 'index.php?route=product/category&path=' . $new_path);
					
						$output .= $this->getCategories($result['category_id'], $new_path);
					}
				}
			}
		}
		
		$store_id = 0;
		$store_url = HTTP_CATALOG;
	
		$results = $this->model_catalog_sitemapgenerator->getAllCategories($parent_id, $store_id);
	
		foreach ($results as $result) {
		
			if (!$current_path) {
				$new_path = $result['category_id'];
			} else {
				$new_path = $current_path . '_' . $result['category_id'];
			}
		
			$output .= $this->generateLinkNode($store_url . 'index.php?route=product/category&path=' . $new_path);
		
			$output .= $this->getCategories($result['category_id'], $new_path);
		}
	
		return $output;
	}

	protected function getProducts() {
		$output = '';
	
		$this->load->model('catalog/sitemapgenerator');
		
		$stores_pro = $this->model_catalog_sitemapgenerator->getAllStores();
		
		if ($stores_pro) {
			foreach ($stores_pro as $store_pro) {
				if ($store_pro['store_id'] != 0) {
					$store_id = $store_pro['store_id'];
					$store_url = $store_pro['url'];
				
					$results = $this->model_catalog_sitemapgenerator->getAllProducts($store_id);
				
					foreach ($results as $result) {	
						$output .= $this->generateLinkNode($store_url . 'index.php?route=product/product&product_id=' . $result['product_id'], "weekly", "0.8");
					}
				}
			}
		}
		
		$store_id = 0;
		$store_url = HTTP_CATALOG;
	
		$results = $this->model_catalog_sitemapgenerator->getAllProducts($store_id);
	
		foreach ($results as $result) {	
			$output .= $this->generateLinkNode($store_url . 'index.php?route=product/product&product_id=' . $result['product_id'], "weekly", "0.8");
		}
	
		return $output;
	}
	
	protected function getManufacturers() {
		$output = '';
	
		$this->load->model('catalog/sitemapgenerator');
		
		$stores_man = $this->model_catalog_sitemapgenerator->getAllStores();
		
		if ($stores_man) {
			foreach ($stores_man as $store_man) {
				if ($store_man['store_id'] != 0) {
					$store_id = $store_man['store_id'];
					$store_url = $store_man['url'];
					
					$results = $this->model_catalog_sitemapgenerator->getAllManufacturers($store_id);
				
					foreach ($results as $result) {	
						if ((substr(VERSION, 0, 5) == '1.5.4') || (substr(VERSION, 0, 5) == '1.5.5') || (substr(VERSION, 0, 5) == '1.5.6')) {
							$output .= $this->generateLinkNode($store_url . 'index.php?route=product/manufacturer/info&manufacturer_id=' . $result['manufacturer_id'], "weekly", "0.6");
						} else {
							$output .= $this->generateLinkNode($store_url . 'index.php?route=product/manufacturer/product&manufacturer_id=' . $result['manufacturer_id'], "weekly", "0.6");
						}
					}
				}
			}
		}
		
		$store_id = 0;
		$store_url = HTTP_CATALOG;
	
		$results = $this->model_catalog_sitemapgenerator->getAllManufacturers($store_id);
	
		foreach ($results as $result) {	
			if ((substr(VERSION, 0, 5) == '1.5.4') || (substr(VERSION, 0, 5) == '1.5.5') || (substr(VERSION, 0, 5) == '1.5.6')) {
				$output .= $this->generateLinkNode($store_url . 'index.php?route=product/manufacturer/info&manufacturer_id=' . $result['manufacturer_id'], "weekly", "0.6");
			} else {
				$output .= $this->generateLinkNode($store_url . 'index.php?route=product/manufacturer/product&manufacturer_id=' . $result['manufacturer_id'], "weekly", "0.6");
			}
		}
	
		return $output;
	}

	protected function getInformationPages() {
		$output = '';
	
		$this->load->model('catalog/sitemapgenerator');
	
		foreach ($this->model_catalog_sitemapgenerator->getAllInformations() as $result) {
			$output .= $this->generateLinkNode(HTTP_CATALOG .  'index.php?route=information/information&information_id=' . $result['information_id']);
		}
	
		$output .= $this->generateLinkNode(HTTP_CATALOG . 'index.php?route=information/contact', "monthly", "0.5");
	
		return $output;
	}

	protected function generateLinkNode($link, $changefreq = 'monthly', $priority = '1.0') {
	
		$this->load->model('tool/seo_url');
	
		$link = $this->model_tool_seo_url->rewrite($link);
	
		$link = str_replace("&", "&amp;", $link);
	
		$output = "<url>";
		$output .= "<loc>" . $link . "</loc>";
		$output .= "<lastmod>" . date("Y-m-d") . "</lastmod>";
		$output .= "<changefreq>" . $changefreq . "</changefreq>";
		$output .= "<priority>" . $priority . "</priority>";
		$output .= "</url>\r";
	
		return $output;
	}
}
?>