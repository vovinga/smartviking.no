<?php 
class ModelModuleModGiftsGift extends Model {
	
	/**
	 * Pobierz listę grup
	 * 
	 * @param float $amount
	 * @return array
	 */
	public function getGroupsByCart( $amount ) {
		$isFirst	= ! $this->customer->isLogged() || $this->model_module_mod_gifts_gift->isFirstOrder( $this->customer->getId() );
		$sql		= '
			SELECT 
				*
			FROM
				`' . DB_PREFIX . 'mod_gift_group` AS `g`
			INNER JOIN
				`' . DB_PREFIX . 'mod_gift_group_description` AS `gd`
			ON
				`g`.`group_id` = `gd`.`group_id`
			WHERE
				`g`.`status` = "1" AND
				`gd`.`language_id` = "' . (int) $this->config->get( 'config_language_id' ) . '" AND
				`g`.`amount` IS NULL OR `g`.`amount` <= ' . (float) $amount . '
				' . ( $isFirst ? '' : ' AND `g`.`type` = "every_order"' ) . '
		';
		
		// ORDER BY
		$sql .= '
			ORDER BY
				`g`.`amount` DESC';
		
		// LIMIT
		$sql .= '
			LIMIT 1';
		
		$items		= array();
		$hasAmount	= false;
		
		foreach( $this->db->query($sql)->rows as $item ) {
			if( ! $hasAmount || ! $item['amount'] )
				$items[] = $item;
			
			if( $item['amount'] )
				$hasAmount = true;
		}
		
		return array_reverse( $items );
	}
	
	public function isFirstOrder( $user_id ) {
		$sql = '
			SELECT
				*
			FROM
				`' . DB_PREFIX . 'order` AS `o`
			WHERE
				`o`.`customer_id` = ' . (int) $user_id . '
		';
		
		return $this->db->query($sql)->rows ? false : true;
	}
	
	public function getGroupsMaxProducts() {
		$sql = '
			SELECT
				*
			FROM
				`' . DB_PREFIX . 'mod_gift_group` AS `g`
		';
		
		$items = array();
		
		foreach( $this->db->query($sql)->rows as $item ) {
			$items[$item['group_id']] = $item['items'];
		}
		
		return $items;
	}
	
	private function _getGiftsSQL( $data = array() ) {
		
		$sql = '
			SELECT
				`gift`.*, 
				`group`.*, 
				`desc`.*,
				`group`.`amount` `g_amount`,
				`group`.`items` `g_items`,
				`gdesc`.`name` `gdesc_name`,
				`gdesc`.`description` `gdesc_description`,
				`product`.*,
				`product`.`status` `p_status`
			FROM
				`' . DB_PREFIX . 'mod_gift` AS `gift`
			INNER JOIN
				`' . DB_PREFIX . 'product` AS `product`
			ON
				`gift`.`product_id` = `product`.`product_id`
			INNER JOIN
				`' . DB_PREFIX . 'product_description` AS `desc`
			ON
				`gift`.`product_id` = `desc`.`product_id` AND `desc`.`language_id` = "' . (int) $this->config->get( 'config_language_id' ) . '"
			INNER JOIN
				`' . DB_PREFIX . 'mod_gift_group_item` AS `item`
			ON 
				`gift`.`gift_id` = `item`.`gift_id`
			INNER JOIN
				`' . DB_PREFIX . 'mod_gift_group` AS `group`
			ON
				`item`.`group_id` = `group`.`group_id`
			INNER JOIN
				`' . DB_PREFIX . 'mod_gift_group_description` AS `gdesc`
			ON
				`group`.`group_id` = `gdesc`.`group_id` AND `gdesc`.`language_id` = "' . (int) $this->config->get( 'config_language_id' ) . '"
			WHERE
				`gift`.`status` = "1" AND
				`group`.`status` = "1" AND
				`product`.`quantity` > 0
		';
		
		// visible_on_list
		if( isset( $data['visible_on_list'] ) )
			$sql .= 'AND `group`.`visible_on_list` = "' . (int) $data['visible_on_list'] . '"';
		
		// amount
		if( isset( $data['amount'] ) )
			$sql .= 'AND ( `group`.`amount` IS NULL OR `group`.`amount` <= ' . (float) $data['amount'] . ' )';
		
		// group_id
		if( isset( $data['group_id'] ) ) {
			if( ! is_array( $data['group_id'] ) )
				$data['group_id'] = array( $data['group_id'] );
			
			foreach( $data['group_id'] as $k => $v )
				$data['group_id'][$k] = (int) $v;
			
			$sql .= 'AND `group`.`group_id` IN(' . implode( ',', $data['group_id'] ) . ')';
		}
		
		// ORDER BY
		if( ! isset( $data['order_by'] ) )
			$sql .= '
				ORDER BY
					`gift`.`sort_order` ASC, `group`.`amount` DESC, `desc`.`name` ASC';
		else
			$sql .= 'ORDER BY' . $data['order_by'];
		
		// LIMIT
		if( isset( $data['page'] ) ) {
			$start	= ( $data['page'] - 1 ) * $this->config->get('config_admin_limit');
			$limit	= $this->config->get('config_admin_limit');
			
			if( $start < 0 )
				$start = 0;
			
			if( $limit < 1 )
				$limit = 20;
			
			$sql .= ' LIMIT ' . (int) $start . ',' . (int) $limit; 
		}
		
		return $sql;
	}
	
	public function getAllGifts( $data = array() ) {
		if( ! isset( $data['order_by'] ) )
			$data['order_by'] = '`gift`.`sort_order` ASC, `group`.`amount` ASC, `desc`.`name` ASC';
		
		return $this->db->query( $this->_getGiftsSQL( $data ) )->rows;
	}
	
	/**
	 * Pobierz listę prezentów
	 * 
	 * @param array $data
	 * @return array
	 */
	public function getGifts( $data = array() ) {		
		$items		= array();
		$g_id = NULL;
		//$hasAmount	= false;
		
		foreach( $this->db->query( $this->_getGiftsSQL( $data ) )->rows as $item ) {
			if( $g_id !== NULL && $g_id != $item['group_id'] ) break;
			
			$item['price'] = 0;
			$item['mod_is_gift'] = true;
			$item['mod_group_id'] = $item['group_id'];
		//	if( ! $hasAmount || ! $item['g_amount'] )
				$items[] = $item;
			
			//if( $item['g_amount'] )
			//	$hasAmount = true;
				
			if( $g_id === NULL )
				$g_id = $item['group_id'];
		}
		
		return $items;
	}
}

class ModGiftsHelperCart {
	
	private $_parent	= NULL;
	
	private $_data = NULL;
	
	static public function newInstance( & $_parent, & $_data ) {
		return new self( $_parent, $_data );
	}
	
	public function __construct( & $_parent, & $_data ) {
		$this->_parent = & $_parent;
		$this->_data = & $_data;
	}
	
	public function getCartTotal() {
		$total_data = array();
		$total = 0;
		$taxes = $this->_parent->cart->getTaxes();
			 
		$this->_parent->load->model('setting/extension');
			
		$sort_order = array(); 
			
		$results = $this->_parent->model_setting_extension->getExtensions('total');
			
		foreach ($results as $key => $value) {
			$sort_order[$key] = $this->_parent->config->get($value['code'] . '_sort_order');
		}
			
		array_multisort($sort_order, SORT_ASC, $results);
			
		foreach ($results as $result) {
			if ($this->_parent->config->get($result['code'] . '_status')) {
				$this->_parent->load->model('total/' . $result['code']);
		
				$this->_parent->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
			}
		}
		
		if( $this->_parent->currency->getCode() != $this->_parent->config->get( 'config_currency' ) ) {
			$total *= $this->_parent->currency->getValue();
		}
		
		return $total;
	}
	
	private function _getProductOptions( $product_id ) {
		$this->_parent->load->model('catalog/product');
		
		$options = array();
		
		foreach( $this->_parent->model_catalog_product->getProductOptions( $product_id ) as $item ) {
			if( is_array( $item['option_value'] ) ) {
				$values = $item['option_value'];

				$item['option_value'] = array();

				foreach( $values as $value )
					$item['option_value'][$value['product_option_value_id']] = $value;
			}
			
			$options[$item['product_option_id']] = $item;
		}
		
		return $options;
	}
	
	public function initSetOptions() {
		$options = array();
		
		if( ! empty( $this->_parent->request->post['gifts'] ) ) {
			$this->_parent->session->data['mod_gifts'] = array();
			
			foreach( $this->_parent->request->post['gifts'] as $item ) {
				list( $group_id, $product_id ) = explode(',', $item);
				$this->_parent->session->data['mod_gifts'][$group_id][] = $product_id;
			}
		}
		
		if( ! empty( $this->_parent->request->post['option'] ) ) {
			$this->_parent->session->data['mod_options'] = array();
			foreach( $this->_parent->request->post['option'] as $product_id => $items ) {
				if( ! isset( $options[$product_id] ) )
					$options[$product_id] = $this->_getProductOptions( $product_id );

				foreach( $items as $option_id => $value ) {
					if( $value !== '' )
						$this->_parent->session->data['mod_options'][$product_id][$option_id] = $value;
				}
			}
		}
		
		return $this;
	}
	
	public function initValidOptions() {		
		foreach( $this->_parent->model_module_mod_gifts_gift->getGifts(array( 'group_id' => array_keys( $this->_parent->session->data['mod_groups'] ) )) as $product ) {
			foreach( $this->_getProductOptions( $product['product_id'] ) as $option ) {
				if( isset( $this->_parent->session->data['mod_gifts'][$product['mod_group_id']] ) && 
					in_array( $product['product_id'], $this->_parent->session->data['mod_gifts'][$product['mod_group_id']] ) && 
					$option['required'] && 
					! isset( $this->_parent->session->data['mod_options'][$product['product_id']][$option['product_option_id']] ) )
					return false;
			}
		}
		
		return true;
	}
	
	public function initCartOptions( & $products, $only_selected = false ) {		
		$this->_data['mod_options'] = array();
		$this->_data['mod_options_values'] = array();
		
		if( isset( $this->_parent->session->data['mod_options'] ) )
			$this->_data['mod_options_values'] = $this->_parent->session->data['mod_options'];
		
		$this->_parent->load->model('tool/image');
		
		$items = array();
		foreach( $this->_parent->model_module_mod_gifts_gift->getGifts(array( 'group_id' => array_keys( $this->_parent->session->data['mod_groups'] ) )) as $product ) {
			if( $only_selected ) {
				if( ! isset( $this->_parent->session->data['mod_gifts'][$product['mod_group_id']] ) )
					continue;
				
				if( ! in_array( $product['product_id'], $this->_parent->session->data['mod_gifts'][$product['mod_group_id']] ) )
					continue;
				
				if( ! empty( $product['mod_is_gift'] ) ) {
					if( isset( $items[$product['mod_group_id']] ) && $items[$product['mod_group_id']] >= $product['g_items'] && $product['g_items'] != '-1' )
						continue;
					
					$items[$product['mod_group_id']] = isset( $items[$product['mod_group_id']] ) ? $items[$product['mod_group_id']] + 1 : 1;
				}
			}
			
			$product['option'] = array();
			$options = $this->_getProductOptions( $product['product_id'] );
			
			if( isset( $this->_parent->session->data['mod_options'][$product['product_id']] ) ) {				
				foreach( $this->_parent->session->data['mod_options'][$product['product_id']] as $option_id => $value ) {
					$opt = $options[$option_id];
					
					$opt['product_option_value_id'] = $value;
					$opt['option_value_id']			= $option_id;
					$opt['option_value']			= isset( $options[$option_id]['option_value'][$value]['name'] ) ? $options[$option_id]['option_value'][$value]['name'] : NULL;
					
					$product['option'][] = $opt;
				}
			}
			
			$product['key'] = $product['reward'] = '';
			$product['stock'] = true;
			$product['download'] = array();
			$product['total'] = 0;
			$product['quantity'] = 1;
						
			$products[] = $product;

			foreach ( $options as $option) { 
				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') { 
					$option_value_data = array();

					foreach ($option['option_value'] as $option_value) {
						if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
							$price = false;

							$option_value_data[] = array(
								'product_option_value_id' => $option_value['product_option_value_id'],
								'option_value_id'         => $option_value['option_value_id'],
								'name'                    => $option_value['name'],
								'image'                   => $this->_parent->model_tool_image->resize($option_value['image'], 50, 50),
								'price'                   => $price,
								'price_prefix'            => $option_value['price_prefix']
							);
						}
					}

					$this->_data['mod_options'][$product['product_id']][] = array(
						'product_option_id' => $option['product_option_id'],
						'option_id'         => $option['option_id'],
						'name'              => $option['name'],
						'type'              => $option['type'],
						'option_value'      => $option_value_data,
						'required'          => $option['required']
					);					
				} elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
					$this->_data['mod_options'][$product['product_id']][] = array(
						'product_option_id' => $option['product_option_id'],
						'option_id'         => $option['option_id'],
						'name'              => $option['name'],
						'type'              => $option['type'],
						'option_value'      => $option['option_value'],
						'required'          => $option['required']
					);						
				}
			}
		}
		
		return $this;
	}
}
?>