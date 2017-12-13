<?php
class ControllerModuleFeatured extends Controller {
	protected function index($setting) {
		$this->language->load('module/featured'); 

      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['button_cart'] = $this->language->get('button_cart');
		
		// Metroshop
		$this->data['button_wishlist'] = $this->language->get('button_wishlist');
		$this->data['button_compare'] = $this->language->get('button_compare');         
		$this->data['button_upload'] = $this->language->get('button_upload');
		$this->data['button_continue'] = $this->language->get('button_continue');
		//
		
		$this->load->model('catalog/product'); 
/* start - ipl extension - dbassa */

			// bestseller
			
			$bestseller_products = $this->model_catalog_product->getBestSellerProducts(25);
			$bestsellers = array();
			
			foreach ($bestseller_products as $bestseller_product) {
				$bestsellers[] = $bestseller_product['product_id'];
			}
			
			// featured

			$products_featured = explode(',', $this->config->get('featured_product'));

			// labels config

			$config_labels = $this->config->get('intelligent_product_labels_module');
			if ( empty($config_labels) ) { $config_labels = array(); }

			// current class name

			$current_layout = get_class($this);

			/* end - ipl extension - dbassa */
		
		$this->load->model('tool/image');

		$this->data['products'] = array();

		$products = explode(',', $this->config->get('featured_product'));		

		if (empty($setting['limit'])) {
			$setting['limit'] = 5;
		}
		
		$products = array_slice($products, 0, (int)$setting['limit']);
		
		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
				} else {
					$image = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
						
				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}
				
				if ($this->config->get('config_review_status')) {
					$rating = $product_info['rating'];
				} else {
					$rating = false;
				}
					

			/* start - ipl extension - dbassa */
			
			$mylabels = new Label($this->registry);

			$mylabels->labels = $config_labels;
			$mylabels->product_info = stripos($current_layout,'ControllerModuleFeatured') !== false || 
									  stripos($current_layout,'ControllerModuleFakelatest') !== false || 
									  stripos($current_layout,'ControllerModuleFakemostviewed') !== false || 
									  stripos($current_layout,'ControllerModuleFakebestseller')!== false ||
									  stripos($current_layout,'ControllerModuleBookoftheweek')!== false ||
									  stripos($current_layout,'ControllerModuledealoftheday')!== false ||
									  stripos($current_layout,'ControllerModulePreorders')!== false ? $product_info : $result;
			$mylabels->current_layout = $current_layout;
			$mylabels->current_layout_position = $setting['position'];
			$mylabels->products_featured = $products_featured;
			$mylabels->bestsellers = $bestsellers;
			$labels = $mylabels->RenderLabels();

			/* end - ipl extension - dbassa */
			
				$this->data['products'][] = array(

			/* start - ipl extension - dbassa */

			'labels' => $labels,

			/* end - ipl extension - dbassa */
			
					'product_id' => $product_info['product_id'],
					'thumb'   	 => $image,
					'name'    	 => $product_info['name'],
					'price'   	 => $price,
					'special' 	 => $special,
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
				);
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/featured.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/featured.tpl';
		} else {
			$this->template = 'default/template/module/featured.tpl';
		}

		$this->render();
	}
}
?>