<?php
class ModelReportAdvProducts extends Model {
	public function getProducts($data = array()) {
		$query = $this->db->query("SET SESSION group_concat_max_len=500000");
		
		$token = $this->session->data['token'];

		if (!empty($data['filter_date_start'])) {	
			$date_start = $data['filter_date_start'];
		} else {
			$date_start = '';
		}

		if (!empty($data['filter_date_end'])) {	
			$date_end = $data['filter_date_end'];
		} else {
			$date_end = '';
		}

		if (isset($data['filter_range'])) {
			$range = $data['filter_range'];
		} else {
			$range = 'current_year'; //show Current Year in Statistical Range by default
		}

		switch($range) 
		{
			case 'custom';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
					$date_end = " AND DATE(p.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";				
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < '" . $this->db->escape($data['filter_date_start']) . "'";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
					$date_end = " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape($data['filter_date_start']) . "'))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape($data['filter_date_start']) . "')) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "') AND (DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'))";
				} else {
					$type = '';
				}				
				break;	
			case 'today';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) = CURDATE()";
					$date_end = '';				
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < CURDATE()";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) = CURDATE()";
					$date_end = '';	
				}
				$type = '';				
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) = CURDATE()))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE())) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) = CURDATE()))";
				} else {
					$type = '';
				}					
				break;
			case 'yesterday';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= DATE_ADD(CURDATE(), INTERVAL -1 DAY)";
					$date_end = " AND DATE(p.date_added) < CURDATE()";		
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < DATE_ADD(CURDATE(), INTERVAL -1 DAY)";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) >= DATE_ADD(CURDATE(), INTERVAL -1 DAY)";
					$date_end = " AND DATE(o.date_added) < CURDATE()";	
				}
				$type = '';				
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) >= DATE_ADD(CURDATE(), INTERVAL -1 DAY)))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < DATE_ADD(CURDATE(), INTERVAL -1 DAY))) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= DATE_ADD(CURDATE(), INTERVAL -1 DAY)) AND (DATE(o.date_added) < CURDATE()))";					
				} else {
					$type = '';
				}					
				break;					
			case 'week';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-7 day'))) . "'";
					$date_end = " AND DATE(p.date_added) <= DATE (NOW())";	
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-7 day'))) . "'";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-7 day'))) . "'";
					$date_end = " AND DATE(o.date_added) <= DATE (NOW())";		
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-7 day'))) . "'))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-7 day'))) . "')) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-7 day'))) . "'))";
				} else {
					$type = '';
				}					
				break;
			case 'month';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-30 day'))) . "'";
					$date_end = " AND DATE(p.date_added) <= DATE (NOW())";	
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-30 day'))) . "'";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-30 day'))) . "'";
					$date_end = " AND DATE(o.date_added) <= DATE (NOW())";			
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-30 day'))) . "'))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-30 day'))) . "')) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-30 day'))) . "'))";
				} else {
					$type = '';
				}					
				break;			
			case 'quarter';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-91 day'))) . "'";
					$date_end = " AND DATE(p.date_added) <= DATE (NOW())";	
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-91 day'))) . "'";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-91 day'))) . "'";
					$date_end = " AND DATE(o.date_added) <= DATE (NOW())";			
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-91 day'))) . "'))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-91 day'))) . "')) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-91 day'))) . "'))";						
				} else {
					$type = '';
				}					
				break;
			case 'year';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-365 day'))) . "'";
					$date_end = " AND DATE(p.date_added) <= DATE (NOW())";	
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-365 day'))) . "'";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-365 day'))) . "'";
					$date_end = " AND DATE(o.date_added) <= DATE (NOW())";			
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-365 day'))) . "'))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-365 day'))) . "')) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-365 day'))) . "'))";					
				} else {
					$type = '';
				}					
				break;
			case 'current_week';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= CURDATE() - WEEKDAY(CURDATE())";
					$date_end = " AND DATE(p.date_added) <= DATE (NOW())";	
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < CURDATE() - WEEKDAY(CURDATE())";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) >= CURDATE() - WEEKDAY(CURDATE())";
					$date_end = " AND DATE(o.date_added) <= DATE (NOW())";			
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - WEEKDAY(CURDATE())))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - WEEKDAY(CURDATE()))) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= CURDATE() - WEEKDAY(CURDATE())))";
				} else {
					$type = '';
				}				
				break;	
			case 'current_month';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "YEAR(p.date_added) = YEAR(CURDATE())";
					$date_end = " AND MONTH(p.date_added) = MONTH(CURDATE())";		
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < CURDATE() - DAYOFMONTH(CURDATE()) + 1";
					$date_end = '';					
				} else {
					$date_start = "YEAR(o.date_added) = YEAR(CURDATE())";
					$date_end = " AND MONTH(o.date_added) = MONTH(CURDATE())";				
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - DAYOFMONTH(CURDATE()) + 1))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - DAYOFMONTH(CURDATE()) + 1)) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= CURDATE() - DAYOFMONTH(CURDATE()) + 1))";
				} else {
					$type = '';
				}					
				break;
			case 'current_quarter';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "QUARTER(p.date_added) = QUARTER(CURDATE())";
					$date_end = " AND YEAR(p.date_added) = YEAR(CURDATE())";	
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < MAKEDATE(YEAR(CURDATE()), 1) + INTERVAL QUARTER(CURDATE()) QUARTER - INTERVAL 1 QUARTER";
					$date_end = '';					
				} else {
					$date_start = "QUARTER(o.date_added) = QUARTER(CURDATE())";
					$date_end = " AND YEAR(o.date_added) = YEAR(CURDATE())";				
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < MAKEDATE(YEAR(CURDATE()), 1) + INTERVAL QUARTER(CURDATE()) QUARTER - INTERVAL 1 QUARTER))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < MAKEDATE(YEAR(CURDATE()), 1) + INTERVAL QUARTER(CURDATE()) QUARTER - INTERVAL 1 QUARTER)) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= MAKEDATE(YEAR(CURDATE()), 1) + INTERVAL QUARTER(CURDATE()) QUARTER - INTERVAL 1 QUARTER))";					
				} else {
					$type = '';
				}
				break;					
			case 'current_year';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "YEAR(p.date_added) = YEAR(CURDATE())";
					$date_end = '';					
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < CURDATE() - YEAR(CURDATE())";
					$date_end = '';					
				} else {
					$date_start = "YEAR(o.date_added) = YEAR(CURDATE())";
					$date_end = '';					
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - YEAR(CURDATE())))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - YEAR(CURDATE()))) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= CURDATE() - YEAR(CURDATE())))";
				} else {
					$type = '';
				}					
				break;					
			case 'last_week';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+5 DAY";
					$date_end = " AND DATE(p.date_added) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())-2 DAY";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+5 DAY";
					$date_end = '';
				} else {
					$date_start = "DATE(o.date_added) >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+5 DAY";
					$date_end = " AND DATE(o.date_added) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())-2 DAY";
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+5 DAY))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+5 DAY)) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+5 DAY) AND (DATE(o.date_added) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())-2 DAY))";
				} else {
					$type = '';
				}				
				break;	
			case 'last_month';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01')";
					$date_end = " AND DATE(p.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/%m/01')";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01')";
					$date_end = '';
				} else {
					$date_start = "DATE(o.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01')";
					$date_end = " AND DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/%m/01')";
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01')))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {					
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01'))) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01')) AND (DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/%m/01')))";
				} else {
					$type = '';
				}					
				break;
			case 'last_quarter';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "QUARTER(p.date_added) = QUARTER(DATE_ADD(NOW(), INTERVAL -3 MONTH))";
					$date_end = " AND YEAR(p.date_added) = YEAR(CURDATE())";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_customers') {
					$date_start = "DATE(o.date_added) < LAST_DAY(CURRENT_DATE - INTERVAL 2 QUARTER) + INTERVAL 1 DAY";
					$date_end = '';
				} else {
					$date_start = "QUARTER(o.date_added) = QUARTER(DATE_ADD(NOW(), INTERVAL -3 MONTH))";
					$date_end = " AND YEAR(o.date_added) = YEAR(CURDATE())";
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < LAST_DAY(CURRENT_DATE - INTERVAL 2 QUARTER) + INTERVAL 1 DAY))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {					
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < LAST_DAY(CURRENT_DATE - INTERVAL 2 QUARTER) + INTERVAL 1 DAY)) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= LAST_DAY(CURRENT_DATE - INTERVAL 2 QUARTER) + INTERVAL 1 DAY) AND (DATE(o.date_added) < LAST_DAY(CURRENT_DATE - INTERVAL 1 QUARTER) + INTERVAL 1 DAY))";					
				} else {
					$type = '';
				}					
				break;					
			case 'last_year';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 YEAR, '%Y/01/01')";
					$date_end = " AND DATE(p.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/01/01')";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE - INTERVAL 1 YEAR, '%Y/01/01')";
					$date_end = '';
				} else {
					$date_start = "DATE(o.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 YEAR, '%Y/01/01')";
					$date_end = " AND DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/01/01')";
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE - INTERVAL 1 YEAR, '%Y/01/01')))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {					
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE - INTERVAL 1 YEAR, '%Y/01/01'))) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 YEAR, '%Y/01/01')) AND (DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/01/01')))";
				} else {
					$type = '';
				}					
				break;					
			case 'all_time';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "'";
					$date_end = " AND DATE(p.date_added) <= DATE (NOW())";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "'";
					$date_end = " AND DATE(o.date_added) <= DATE (NOW())";			
				} else {
					$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "'";
					$date_end = " AND DATE(o.date_added) <= DATE (NOW())";
				}	
				$type = '';				
				break;	
		}

		if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$date = ' AND (' . $date_start . $date_end . ')';								
		} else {
			$date = ' WHERE (' . $date_start . $date_end . ')';				
		}
		
		$osi = '';
		$osii = '';
		$sdate = '';
		if (isset($data['filter_report']) && $data['filter_report'] != 'products_without_orders') {
		if (!empty($data['filter_order_status_id'])) {
			if ((!empty($data['filter_status_date_start'])) && (!empty($data['filter_status_date_end']))) {			
				$osi .= " AND (SELECT DISTINCT oh.order_id FROM `" . DB_PREFIX . "order_history` oh WHERE o.order_id = oh.order_id AND (";
				$implode = array();
				foreach ($data['filter_order_status_id'] as $order_status_id) {
					$implode[] = "oh.order_status_id = '" . (int)$order_status_id . "'";
				}
				if ($implode) {
					$osi .= implode(" OR ", $implode) . "";
				}
				$osi .= ") AND DATE(oh.date_added) >= '" . $this->db->escape($data['filter_status_date_start']) . "' AND DATE(oh.date_added) <= '" . $this->db->escape($data['filter_status_date_end']) . "')";
			} else {
				if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$osi .= " AND (SELECT o.order_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_id = op.order_id AND p.product_id = op.product_id AND o.order_status_id > 0 AND (";
				$osii .= " AND (";
				} else {
				$osi .= " AND (";
				}
				$implode = array();
				foreach ($data['filter_order_status_id'] as $order_status_id) {
					$implode[] = "o.order_status_id = '" . (int)$order_status_id . "'";
				}
				if ($implode) {
					if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
					$osi .= implode(" OR ", $implode) . "";
					$osii .= implode(" OR ", $implode) . "";
					} else {
					$osi .= implode(" OR ", $implode) . "";
					}
				}
				if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$osi .= ") GROUP BY p.product_id)";
				$osii .= ")";
				} else {
				$osi .= ")";
				}
				
				$status_date_start = '';
				$status_date_end = '';
				$sdate = $status_date_start . $status_date_end;				
			}
		} else {
			if (!empty($data['filter_status_date_start'])) {		
				$status_date_start = "AND DATE(o.date_modified) >= '" . $this->db->escape($data['filter_status_date_start']) . "'";
			} else {
				$status_date_start = '';
			}
			if (!empty($data['filter_status_date_end'])) {
				$status_date_end = "AND DATE(o.date_modified) <= '" . $this->db->escape($data['filter_status_date_end']) . "'";	
			} else {
				$status_date_end = '';
			}

			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
			$osi .= '';
			} else {
			$osi = " AND o.order_status_id > 0";
			}
			$sdate = $status_date_start . $status_date_end;
		}

		$order_id_from = '';
		$order_id_to = '';
		if (!empty($data['filter_order_id_from'])) {		
			$order_id_from = " AND o.order_id >= '" . $this->db->escape($data['filter_order_id_from']) . "'";
		} else {
			$order_id_from = '';
		}
		if (!empty($data['filter_order_id_to'])) {	
			$order_id_to = " AND o.order_id <= '" . $this->db->escape($data['filter_order_id_to']) . "'";	
		} else {
			$order_id_to = '';
		}
		$order_id = $order_id_from . $order_id_to;
		}
		
		$store = '';
		if (!empty($data['filter_store_id'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$store .= " AND (SELECT DISTINCT p.product_id FROM `" . DB_PREFIX . "product_to_store` pts WHERE p.product_id = pts.product_id AND (";
			} else {
			$store .= " AND (";
			}	
			$implode = array();
			foreach ($data['filter_store_id'] as $store_id) {
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
				$implode[] = "pts.store_id = '" . (int)$store_id . "'";	
				} else {
				$implode[] = "o.store_id = '" . (int)$store_id . "'";
				}
			}
			if ($implode) {
				$store .= implode(" OR ", $implode) . "";
			}
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$store .= "))";
			} else {
			$store .= ")";
			}
		}
		
		$cur = '';
		if (!empty($data['filter_currency'])) {
			$cur .= " AND (";
			$implode = array();
			foreach ($data['filter_currency'] as $currency) {
				$implode[] = "o.currency_id = '" . (int)$currency . "'";
			}
			if ($implode) {
				$cur .= implode(" OR ", $implode) . "";
			}
			$cur .= ")";
		}
		
		$tax = '';
		if (!empty($data['filter_taxes'])) {
			$tax .= " AND (SELECT DISTINCT ot.order_id FROM `" . DB_PREFIX . "order_total` ot WHERE o.order_id = ot.order_id AND ot.code = 'tax' AND (";
			$implode = array();
			foreach ($data['filter_taxes'] as $taxes) {
				$implode[] = "LCASE(ot.title) = '" . $taxes . "'";
			}
			if ($implode) {
				$tax .= implode(" OR ", $implode) . "";
			}
			$tax .= "))";
		}

		$tclass = '';
		if (!empty($data['filter_tax_classes'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$tclass .= " AND (";
			} else {
			$tclass .= " AND (SELECT DISTINCT p.product_id FROM `" . DB_PREFIX . "tax_class` tc, `" . DB_PREFIX . "product` p WHERE p.product_id = op.product_id AND (";
			}
			$implode = array();
			foreach ($data['filter_tax_classes'] as $tax_classes) {
				$implode[] = "p.tax_class_id = '" . (int)$tax_classes . "'";
			}
			if ($implode) {
				$tclass .= implode(" OR ", $implode) . "";
			}
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$tclass .= ")";
			} else {
			$tclass .= "))";
			}
		}
		
		$geo_zone = '';
		if (!empty($data['filter_geo_zones'])) {
			$geo_zone .= " AND (SELECT gz.geo_zone_id FROM `" . DB_PREFIX . "geo_zone` gz, `" . DB_PREFIX . "zone_to_geo_zone` zgz WHERE (";
			$implode = array();
			foreach ($data['filter_geo_zones'] as $geo_zones) {
				$implode[] = "(gz.geo_zone_id = zgz.geo_zone_id AND zgz.zone_id = 0 AND zgz.country_id = o.payment_country_id AND gz.geo_zone_id = '" . (int)$geo_zones . "') OR (gz.geo_zone_id = zgz.geo_zone_id AND o.payment_zone_id = zgz.zone_id AND gz.geo_zone_id = '" . (int)$geo_zones . "')";
			}
			if ($implode) {
				$geo_zone .= implode(" OR ", $implode) . "";
			}
			$geo_zone .= "))";
		}
		
		$cgrp = '';
		if (!empty($data['filter_customer_group_id'])) {
			$cgrp .= " AND (";
			$implode = array();
			foreach ($data['filter_customer_group_id'] as $customer_group_id) {
				$implode[] = "(SELECT c.customer_group_id FROM `" . DB_PREFIX . "customer` c WHERE c.customer_id = o.customer_id AND c.customer_group_id = '" . (int)$customer_group_id . "') OR (o.customer_group_id = '" . (int)$customer_group_id . "' AND o.customer_id = 0)";
			}
			if ($implode) {
				$cgrp .= implode(" OR ", $implode) . "";
			}
			$cgrp .= ")";
		}
		
		$cust = '';
		if (!empty($data['filter_customer_name'])) {
			$cust = " AND LCASE(CONCAT(o.firstname, ' ', o.lastname)) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_customer_name'], 'UTF-8')) . "%'";
		} else {
			$cust = '';
		}

		$email = '';
		if (!empty($data['filter_customer_email'])) {
			$email = " AND LCASE(o.email) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_customer_email'], 'UTF-8')) . "%'";
		} else {
			$email = '';
		}

		$tel = '';
		if (!empty($data['filter_customer_telephone'])) {
			$tel = " AND LCASE(o.telephone) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_customer_telephone'], 'UTF-8')) . "%'";
		} else {
			$tel = '';
		}

		$ip = '';
		if (!empty($data['filter_ip'])) {
        	$ip = " AND LCASE(o.ip) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_ip'], 'UTF-8')) . "%'";
		} else {
			$ip = '';
		}
		
		$pcomp = '';
		if (!empty($data['filter_payment_company'])) {
        	$pcomp = " AND LCASE(o.payment_company) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_company'], 'UTF-8')) . "%'";
		} else {
			$pcomp = '';
		}

		$paddr = '';
		if (!empty($data['filter_payment_address'])) {
        	$paddr = " AND LCASE(CONCAT(o.payment_address_1, ', ', o.payment_address_2)) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_address'], 'UTF-8')) . "%'";
		} else {
			$paddr = '';
		}

		$pcity = '';
		if (!empty($data['filter_payment_city'])) {
        	$pcity = " AND LCASE(o.payment_city) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_city'], 'UTF-8')) . "%'";
		} else {
			$pcity = '';
		}

		$pzone = '';
		if (!empty($data['filter_payment_zone'])) {
        	$pzone = " AND LCASE(o.payment_zone) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_zone'], 'UTF-8')) . "%'";
		} else {
			$pzone = '';
		}

		$ppsc = '';
		if (!empty($data['filter_payment_postcode'])) {
        	$ppsc = " AND LCASE(o.payment_postcode) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_postcode'], 'UTF-8')) . "%'";
		} else {
			$ppsc = '';
		}

		$pcntr = '';
		if (!empty($data['filter_payment_country'])) {
        	$pcntr = " AND LCASE(o.payment_country) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_country'], 'UTF-8')) . "%'";
		} else {
			$pcntr = '';
		}

		$pmeth = '';
		if (!empty($data['filter_payment_method'])) {
			$pmeth .= " AND (";
			$implode = array();
			foreach ($data['filter_payment_method'] as $payment_code) {
				$implode[] = "o.payment_code = '" . $payment_code . "'";
			}
			if ($implode) {
				$pmeth .= implode(" OR ", $implode) . "";
			}
			$pmeth .= ")";
		}

		$scomp = '';
		if (!empty($data['filter_shipping_company'])) {
			$scomp = " AND LCASE(o.shipping_company) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_company'], 'UTF-8')) . "%'";
		} else {
			$scomp = '';
		}

		$saddr = '';
		if (!empty($data['filter_shipping_address'])) {
			$saddr = " AND LCASE(CONCAT(o.shipping_address_1, ', ', o.shipping_address_2)) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_address'], 'UTF-8')) . "%'";

		} else {
			$saddr = '';
		}

		$scity = '';
		if (!empty($data['filter_shipping_city'])) {
			$scity = " AND LCASE(o.shipping_city) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_city'], 'UTF-8')) . "%'";
		} else {
			$scity = '';
		}

		$szone = '';
		if (!empty($data['filter_shipping_zone'])) {
			$szone = " AND LCASE(o.shipping_zone) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_zone'], 'UTF-8')) . "%'";
		} else {
			$szone = '';
		}

		$spsc = '';
		if (!empty($data['filter_shipping_postcode'])) {
			$spsc = " AND LCASE(o.shipping_postcode) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_postcode'], 'UTF-8')) . "%'";			
		} else {
			$spsc = '';
		}

		$scntr = '';
		if (!empty($data['filter_shipping_country'])) {
			$scntr = " AND LCASE(o.shipping_country) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_country'], 'UTF-8')) . "%'";			
		} else {
			$scntr = '';
		}

		$smeth = '';
		if (!empty($data['filter_shipping_method'])) {
			$smeth .= " AND (";
			$implode = array();
			foreach ($data['filter_shipping_method'] as $shipping_code) {
				$implode[] = "o.shipping_code = '" . $shipping_code . "'";
			}
			if ($implode) {
				$smeth .= implode(" OR ", $implode) . "";
			}
			$smeth .= ")";
		}
		
		$cat = '';
		if (!empty($data['filter_category'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$cat .= " AND (SELECT DISTINCT p2c.product_id FROM `" . DB_PREFIX . "product_to_category` p2c WHERE p2c.product_id = p.product_id AND (";
			} else {
			$cat .= " AND (SELECT DISTINCT p2c.product_id FROM `" . DB_PREFIX . "product_to_category` p2c WHERE p2c.product_id = op.product_id AND (";
			}			
			$implode = array();
			foreach ($data['filter_category'] as $category_id) {
				$implode[] = "p2c.category_id = '" . (int)$category_id . "'";
			}
			if ($implode) {
				$cat .= implode(" OR ", $implode) . "";
			}
			$cat .= "))";
		}
		
		$manu = '';
		if (!empty($data['filter_manufacturer'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$manu .= " AND (";
			} else {
			$manu .= " AND (SELECT DISTINCT p.manufacturer_id FROM `" . DB_PREFIX . "product` p WHERE p.product_id = op.product_id AND (";
			}	
			$implode = array();
			foreach ($data['filter_manufacturer'] as $manufacturer) {
				$implode[] = "p.manufacturer_id = '" . (int)$manufacturer . "'";
			}
			if ($implode) {
				$manu .= implode(" OR ", $implode) . "";
			}
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$manu .= ")";
			} else {
			$manu .= "))";
			}
		}
		
		$sku = '';
		if (!empty($data['filter_sku'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
        	$sku = " AND LCASE(p.sku) LIKE '" . $this->db->escape(mb_strtolower($data['filter_sku'], 'UTF-8')) . "'";
			} else {
        	$sku = " AND (SELECT DISTINCT p.product_id FROM `" . DB_PREFIX . "product` p WHERE p.product_id = op.product_id AND LCASE(p.sku) LIKE '" . $this->db->escape(mb_strtolower($data['filter_sku'], 'UTF-8')) . "')";
			}	
		} else {
			$sku = '';
		}
		
		$prod = '';
		if (!empty($data['filter_product_name'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
        	$prod = " AND LCASE(pd.name) LIKE '" . $this->db->escape(mb_strtolower($data['filter_product_name'], 'UTF-8')) . "'";	
			} else {
        	$prod = " AND LCASE(op.name) LIKE '" . $this->db->escape(mb_strtolower($data['filter_product_name'], 'UTF-8')) . "'";	
			}				
		} else {
			$prod = '';
		}
		
		$mod = '';
		if (!empty($data['filter_model'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
        	$mod = " AND LCASE(p.model) LIKE '" . $this->db->escape(mb_strtolower($data['filter_model'], 'UTF-8')) . "'";		
			} else {
        	$mod = " AND LCASE(op.model) LIKE '" . $this->db->escape(mb_strtolower($data['filter_model'], 'UTF-8')) . "'";			
			}
		} else {
			$mod = '';
		}
		
		$opt = '';
		if (!empty($data['filter_option'])) {
			$opt .= " AND ";
			$implode = array();
			foreach ($data['filter_option'] as $option) {
				$implode[] = "(SELECT DISTINCT oo.order_product_id FROM `" . DB_PREFIX . "order_option` oo WHERE oo.order_product_id = op.order_product_id AND LCASE(CONCAT(oo.name,'_',oo.value,'_',oo.type)) = '" . $option . "' AND LCASE(op.name) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_product_name'], 'UTF-8')) . "%')";
			}
			if ($implode) {
				$opt .= implode(" AND ", $implode) . "";
			}
		}

		$atr = '';
		if (!empty($data['filter_attribute'])) {
			$atr .= " AND ";
			$implode = array();
			foreach ($data['filter_attribute'] as $attribute) {
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
				$implode[] = "(SELECT DISTINCT pa.product_id FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.product_id = p.product_id AND pa.attribute_id = ad.attribute_id AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND LCASE(CONCAT(agd.name,'_',ad.name,'_',pa.text)) = '" . $attribute . "')";
				} else {
				$implode[] = "(SELECT DISTINCT pa.product_id FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.product_id = op.product_id AND pa.attribute_id = ad.attribute_id AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND LCASE(CONCAT(agd.name,'_',ad.name,'_',pa.text)) = '" . $attribute . "')";		
				}
			}
			if ($implode) {
				$atr .= implode(" AND ", $implode) . "";
			}
		}

		$stat = '';
		if (!empty($data['filter_product_status'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$stat .= " AND (";
			} else {
			$stat .= " AND (SELECT DISTINCT p.product_id FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id AND (";
			}
			$implode = array();
			foreach ($data['filter_product_status'] as $product_status) {
				$implode[] = "p.status = '" . (int)$product_status . "'";
			}
			if ($implode) {
				$stat .= implode(" OR ", $implode) . "";
			}
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$stat .= ")";
			} else {
			$stat .= "))";
			}
		}
		
		$loc = '';
		if (!empty($data['filter_location'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$loc .= " AND (";
			} else {
			$loc .= " AND (SELECT DISTINCT p.product_id FROM `" . DB_PREFIX . "product` p WHERE p.product_id = op.product_id AND (";
			}	
			$implode = array();
			foreach ($data['filter_location'] as $location) {
				$implode[] = "LCASE(p.location) = '" . $location . "'";
			}
			if ($implode) {
				$loc .= implode(" OR ", $implode) . "";
			}
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$loc .= ")";
			} else {
			$loc .= "))";
			}
		}

		$affn = '';
		if (!empty($data['filter_affiliate_name'])) {
			$affn .= " AND (SELECT DISTINCT at.order_id FROM `" . DB_PREFIX . "affiliate_transaction` at WHERE at.order_id = o.order_id AND (";
			$implode = array();
			foreach ($data['filter_affiliate_name'] as $affiliate_name) {
				$implode[] = "at.affiliate_id = '" . (int)$affiliate_name . "'";
			}
			if ($implode) {
				$affn .= implode(" OR ", $implode) . "";
			}
			$affn .= "))";
		}

		$affe = '';
		if (!empty($data['filter_affiliate_email'])) {
			$affe .= " AND (SELECT DISTINCT at.order_id FROM `" . DB_PREFIX . "affiliate_transaction` at WHERE at.order_id = o.order_id AND (";
			$implode = array();
			foreach ($data['filter_affiliate_email'] as $affiliate_email) {
				$implode[] = "at.affiliate_id = '" . (int)$affiliate_email . "'";
			}
			if ($implode) {
				$affe .= implode(" OR ", $implode) . "";
			}
			$affe .= "))";
		}

		$cpn = '';
		if (!empty($data['filter_coupon_name'])) {
			$cpn .= " AND (SELECT DISTINCT cph.order_id FROM `" . DB_PREFIX . "coupon_history` cph WHERE cph.order_id = o.order_id AND (";
			$implode = array();
			foreach ($data['filter_coupon_name'] as $coupon_name) {
				$implode[] = "cph.coupon_id = '" . (int)$coupon_name . "'";
			}
			if ($implode) {
				$cpn .= implode(" OR ", $implode) . "";
			}
			$cpn .= "))";
		}

		$cpc = '';
		if (!empty($data['filter_coupon_code'])) {
			$cpc = " AND (SELECT DISTINCT cph.order_id FROM `" . DB_PREFIX . "coupon` cp, `" . DB_PREFIX . "coupon_history` cph WHERE cph.coupon_id = cp.coupon_id AND cph.order_id = o.order_id AND LCASE(cp.code) LIKE '" . $this->db->escape(mb_strtolower($data['filter_coupon_code'], 'UTF-8')) . "')";	
		} else {
			$cpc = '';
		}

		$gvc = '';
		if (!empty($data['filter_voucher_code'])) {
        	$gvc = " AND (SELECT DISTINCT gvh.order_id FROM `" . DB_PREFIX . "voucher` gv, `" . DB_PREFIX . "voucher_history` gvh WHERE gvh.voucher_id = gv.voucher_id AND gvh.order_id = o.order_id AND LCASE(gv.code) LIKE '" . $this->db->escape(mb_strtolower($data['filter_voucher_code'], 'UTF-8')) . "')";	
		} else {
			$gvc = '';
		}
		
		if (isset($data['filter_details']) && $data['filter_details'] != 'all_details') {
			
		if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
			
		$sql = "SELECT p.*, 
		p.product_id AS id, 
		p.price AS prod_price, 
		pd.name AS name, 
		(SELECT cd.name FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "category` c, `" . DB_PREFIX . "product_to_category` p2c WHERE c.category_id = cd.category_id AND p2c.category_id = c.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.product_id = p2c.product_id GROUP BY p.product_id) AS category, 
		(SELECT GROUP_CONCAT(cd.name SEPARATOR ', ') FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "category` c, `" . DB_PREFIX . "product_to_category` p2c WHERE p.product_id = p2c.product_id AND p2c.category_id = c.category_id AND (c.category_id = cd.category_id OR c.parent_id = cd.category_id) AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.status > 0) AS categories, 
		(SELECT m.name FROM `" . DB_PREFIX . "manufacturer` m WHERE p.manufacturer_id = m.manufacturer_id) AS manufacturer, 
		(SELECT GROUP_CONCAT(CONCAT(agd.name,' &gt; ',ad.name,' &gt; ',pa.text) ORDER BY agd.name, ad.name, pa.text ASC SEPARATOR '<br>') FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.product_id = p.product_id AND pa.attribute_id = ad.attribute_id AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute, 
		(SELECT tc.title FROM `" . DB_PREFIX . "tax_class` tc WHERE p.tax_class_id = tc.tax_class_id) AS tax_class, 
		p.quantity AS stock_quantity, 
		(SELECT SUM(op.quantity) FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_id = op.order_id AND p.product_id = op.product_id AND o.order_status_id > 0" . $osii . " GROUP BY p.product_id) AS sold_quantity, 
		(SELECT SUM(op.total) FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_id = op.order_id AND p.product_id = op.product_id AND o.order_status_id > 0" . $osii . " GROUP BY p.product_id) AS total_excl_vat, 
		(SELECT SUM(op.tax*op.quantity) FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_id = op.order_id AND p.product_id = op.product_id AND o.order_status_id > 0" . $osii . " GROUP BY p.product_id) AS total_tax, 
		(SELECT SUM(op.total+(op.tax*op.quantity)) FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_id = op.order_id AND p.product_id = op.product_id AND o.order_status_id > 0" . $osii . " GROUP BY p.product_id) AS total_incl_vat, 
		SUM((SELECT SUM(op.price*r.quantity) FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "return` r WHERE o.order_id = op.order_id AND p.product_id = op.product_id AND r.product_id = p.product_id AND r.order_id = op.order_id AND r.return_action_id =  '" . $this->config->get('advpp' . $this->user->getId() . '_return_action_refund') . "' AND o.order_status_id > 0" . $osii . " GROUP BY r.product_id)) AS refunds, 
		SUM((SELECT op.reward FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id AND p.product_id = op.product_id AND o.customer_id > 0 AND o.order_status_id > 0" . $osii . " GROUP BY p.product_id)) AS reward_points ";
					
		$sql .= "FROM " . DB_PREFIX . "product p, " . DB_PREFIX . "product_description pd WHERE p.product_id = pd.product_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'" . $date . $osi . $tclass . $cat . $manu . $sku . $prod . $mod . $atr . $stat . $loc . $type;

		} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
			
		$sql = "SELECT p.*, 
		p.product_id AS id, 
		p.price AS prod_price, 
		pd.name AS name, 
		(SELECT cd.name FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "category` c, `" . DB_PREFIX . "product_to_category` p2c WHERE c.category_id = cd.category_id AND p2c.category_id = c.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND p.product_id = p2c.product_id GROUP BY p.product_id) AS category, 
		(SELECT GROUP_CONCAT(cd.name SEPARATOR ', ') FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "category` c, `" . DB_PREFIX . "product_to_category` p2c WHERE p.product_id = p2c.product_id AND p2c.category_id = c.category_id AND (c.category_id = cd.category_id OR c.parent_id = cd.category_id) AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.status > 0) AS categories, 
		(SELECT m.name FROM `" . DB_PREFIX . "manufacturer` m WHERE p.manufacturer_id = m.manufacturer_id) AS manufacturer, 
		(SELECT GROUP_CONCAT(CONCAT(agd.name,' &gt; ',ad.name,' &gt; ',pa.text) ORDER BY agd.name, ad.name, pa.text ASC SEPARATOR '<br>') FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.product_id = p.product_id AND pa.attribute_id = ad.attribute_id AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute, 
		(SELECT tc.title FROM `" . DB_PREFIX . "tax_class` tc WHERE p.tax_class_id = tc.tax_class_id) AS tax_class ";
					
		$sql .= "FROM " . DB_PREFIX . "product p, " . DB_PREFIX . "product_description pd WHERE p.product_id = pd.product_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.product_id NOT IN (SELECT product_id FROM `" . DB_PREFIX . "order_product`)" . $date . $tclass . $cat . $manu . $sku . $prod . $mod . $atr . $stat . $loc . $type;
		
		} else {
			
		$sql = "SELECT *,
		o.date_added AS date,
		YEAR(o.date_added) AS year, 
		QUARTER(o.date_added) AS quarter, 		
		MONTHNAME(o.date_added) AS month, 		
		MIN(o.date_added) AS date_start, 
		MAX(o.date_added) AS date_end, 
		op.order_id, 
		op.product_id, 
		op.order_product_id, ";
		if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'products_purchased_with_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
			$sql .= " (SELECT p.image FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS image, 
			(SELECT p.sku FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS sku, 
			op.name, 
			op.model, 
			(SELECT cd.name FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "category` c, `" . DB_PREFIX . "product_to_category` p2c WHERE c.category_id = cd.category_id AND p2c.category_id = c.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND op.product_id = p2c.product_id GROUP BY op.product_id) AS category, 
			(SELECT GROUP_CONCAT(cd.name SEPARATOR ', ') FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "category` c, `" . DB_PREFIX . "product_to_category` p2c WHERE op.product_id = p2c.product_id AND p2c.category_id = c.category_id AND (c.category_id = cd.category_id OR c.parent_id = cd.category_id) AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.status > 0) AS categories, 
			(SELECT p.manufacturer_id FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS manufacturer_id, 
			(SELECT m.name FROM `" . DB_PREFIX . "manufacturer` m, `" . DB_PREFIX . "product` p WHERE p.manufacturer_id = m.manufacturer_id AND op.product_id = p.product_id) AS manufacturer, 
			(SELECT GROUP_CONCAT(CONCAT(agd.name,' &gt; ',ad.name,' &gt; ',pa.text) ORDER BY agd.name, ad.name, pa.text ASC SEPARATOR '<br>') FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.product_id = op.product_id AND pa.attribute_id = ad.attribute_id AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute, 
			(SELECT p.status FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS status, 
			(SELECT p.location FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS location, 
			(SELECT tc.title FROM `" . DB_PREFIX . "tax_class` tc, `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id AND p.tax_class_id = tc.tax_class_id) AS tax_class, 
			(SELECT p.price FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS prod_price, 
			(SELECT p.viewed FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS viewed, 
			(SELECT p.quantity FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS stock_quantity, ";
			if (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
			$sql .= " (SELECT GROUP_CONCAT(IFNULL(pov.quantity,'&nbsp;') SEPARATOR '<br>') FROM `" . DB_PREFIX . "order_option` oo, `" . DB_PREFIX . "product_option_value` pov WHERE op.order_product_id = oo.order_product_id AND op.product_id = pov.product_id AND pov.product_option_value_id = oo.product_option_value_id) AS stock_oquantity, 
			(SELECT GROUP_CONCAT(CONCAT(oo.name,': ',oo.value) SEPARATOR '; ') FROM `" . DB_PREFIX . "order_option` oo WHERE op.order_product_id = oo.order_product_id AND (oo.type = 'radio' OR oo.type = 'checkbox' OR oo.type = 'select' OR oo.type = 'image' OR oo.type = 'colour' OR oo.type = 'size' OR oo.type = 'multiple') ORDER BY op.order_product_id) AS options, ";
			} else {
			$sql .= " '' AS stock_oquantity, 
			'' AS options, ";
			}
		} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
			$sql .= " '' AS image, 
			'' AS sku, 
			'' AS name, 
			'' AS options, 
			'' AS model, 
			'' AS category, 
			'' AS categories, 			
			(SELECT p.manufacturer_id FROM `" . DB_PREFIX . "product` p WHERE op.order_id = o.order_id AND op.product_id = p.product_id) AS manufacturer_id, 
			(SELECT m.name FROM `" . DB_PREFIX . "manufacturer` m, `" . DB_PREFIX . "product` p WHERE op.order_id = o.order_id AND op.product_id = p.product_id AND p.manufacturer_id = m.manufacturer_id) AS manufacturer, 
			'' AS attribute, 
			'' AS status, 
			'' AS location, 
			'' AS tax_class, 
			'' AS prod_price, 
			'' AS viewed, 
			'' AS stock_quantity, 
			'' AS stock_oquantity, ";
		} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
			$sql .= " '' AS image, 
			'' AS sku, 
			'' AS name, 
			'' AS options, 
			'' AS model, 			
			(SELECT cd.name FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "product_to_category` p2c WHERE op.order_id = o.order_id AND op.product_id = p2c.product_id AND p2c.category_id = cd.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY op.product_id) AS category, 
			(SELECT GROUP_CONCAT(cd.name SEPARATOR ', ') FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "category` c, `" . DB_PREFIX . "product_to_category` p2c WHERE op.product_id = p2c.product_id AND p2c.category_id = c.category_id AND (c.category_id = cd.category_id OR c.parent_id = cd.category_id) AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.status > 0) AS categories, 
			'' AS manufacturer_id, 
			'' AS manufacturer, 
			'' AS attribute, 			
			'' AS status, 
			'' AS location, 
			'' AS tax_class, 
			'' AS prod_price, 
			'' AS viewed, 			
			'' AS stock_quantity, 
			'' AS stock_oquantity, ";
		}
		$sql .= " SUM(op.quantity) AS sold_quantity, 
		op.price, 
		SUM(op.total) AS total_excl_vat, 
		SUM(op.tax*op.quantity) AS total_tax, 
		SUM(op.total+(op.tax*op.quantity)) AS total_incl_vat, 
		SUM((SELECT SUM(op.price*r.quantity) FROM `" . DB_PREFIX . "return` r WHERE r.product_id = op.product_id AND r.order_id = op.order_id AND r.return_action_id =  '" . $this->config->get('advpp' . $this->user->getId() . '_return_action_refund') . "' GROUP BY r.product_id)) AS refunds, 
		SUM((SELECT op.reward FROM `" . DB_PREFIX . "order` o WHERE op.order_id = o.order_id AND o.customer_id > 0)) AS reward_points ";

		if (isset($data['filter_details']) && $data['filter_details'] == 'basic_details') {
		if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'products_purchased_with_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
			$sql .= ", GROUP_CONCAT(op.order_id ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_ord_id, 
			GROUP_CONCAT('<a href=\"index.php?route=sale/order/info&token=$token&order_id=',op.order_id,'\">',op.order_id,'</a>' ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_ord_id_link, ";
			if ($this->config->get('advpp' . $this->user->getId() . '_date_format') == 'DDMMYYYY') {																																																																																																																																																																																																																																												   			$sql .= "GROUP_CONCAT(DATE_FORMAT(o.date_added, '%d/%m/%Y') ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_ord_date, ";
			} else {	
				$sql .= "GROUP_CONCAT(DATE_FORMAT(o.date_added, '%m/%d/%Y') ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_ord_date, ";
			}
			$sql .= "GROUP_CONCAT(IFNULL(o.invoice_prefix,'&nbsp;&nbsp;'),IFNULL(o.invoice_no,'&nbsp;&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_inv_no, 
			GROUP_CONCAT(CONCAT(o.firstname,' ',o.lastname) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_name, 
			GROUP_CONCAT(o.email ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_email, 
			GROUP_CONCAT(IFNULL((SELECT cgd.name FROM `" . DB_PREFIX . "customer_group_description` cgd WHERE cgd.customer_group_id = o.customer_group_id AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'),'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_group, 
			GROUP_CONCAT(IF (o.shipping_method = '','&nbsp;&nbsp;',o.shipping_method) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_shipping_method, 
			GROUP_CONCAT(IF (o.payment_method = '','&nbsp;&nbsp;',o.payment_method) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_payment_method, 
			GROUP_CONCAT(IFNULL((SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "'),'&nbsp;&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_status, 
 			GROUP_CONCAT(o.store_name ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_store, 
			GROUP_CONCAT(o.currency_code ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_currency, 
			GROUP_CONCAT(ROUND(o.currency_value*op.price, 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_price, 
			GROUP_CONCAT(op.quantity ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_quantity, 
			GROUP_CONCAT(ROUND(o.currency_value*op.total, 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_total_excl_vat, 
			GROUP_CONCAT(ROUND(o.currency_value*op.tax*op.quantity, 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_tax, 
			GROUP_CONCAT(ROUND(o.currency_value*(op.total+(op.tax*op.quantity)), 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_total_incl_vat, ";

		} elseif (isset($data['filter_report']) && ($data['filter_report'] == 'manufacturers' or $data['filter_report'] == 'categories') && isset($data['filter_details'])) {
			$sql .= ", GROUP_CONCAT(op.order_id ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_ord_id, 
			GROUP_CONCAT('<a href=\"index.php?route=sale/order/info&token=$token&order_id=',op.order_id,'\">',op.order_id,'</a>' ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_ord_id_link, ";
			if ($this->config->get('advpp' . $this->user->getId() . '_date_format') == 'DDMMYYYY') {																																																																																																																																																																																																																																												   				$sql .= "GROUP_CONCAT(DATE_FORMAT(o.date_added, '%d/%m/%Y') ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_ord_date, ";
			} else {	
			$sql .= "GROUP_CONCAT(DATE_FORMAT(o.date_added, '%m/%d/%Y') ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_ord_date, ";
					}			
			$sql .= "GROUP_CONCAT(IFNULL(o.invoice_prefix,'&nbsp;'),IFNULL(o.invoice_no,'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_inv_no, 
			GROUP_CONCAT(op.product_id ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_prod_id, 
			GROUP_CONCAT(IFNULL(CONCAT('<a href=\"index.php?route=catalog/product/update&token=$token&product_id=',op.product_id,'\">',op.product_id,'</a>'),op.product_id) ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_prod_id_link, 
			GROUP_CONCAT((SELECT IF (p.sku = '','&nbsp;&nbsp;',p.sku) FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_sku, 
			GROUP_CONCAT(op.model ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_model, 
			GROUP_CONCAT(op.name ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_name, 
			GROUP_CONCAT(IFNULL((SELECT GROUP_CONCAT(CONCAT(oo.name,': ',oo.value) SEPARATOR '; ') FROM `" . DB_PREFIX . "order_option` oo WHERE op.order_product_id = oo.order_product_id AND (type != 'textarea' OR type != 'file' OR type != 'date' OR type != 'datetime' OR type != 'time') ORDER BY op.order_product_id),'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_option, 
			GROUP_CONCAT(IFNULL((SELECT GROUP_CONCAT(CONCAT(agd.name,'&nbsp;&gt;&nbsp;',ad.name,'&nbsp;&gt;&nbsp;',pa.text) SEPARATOR '; ') FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.product_id = op.product_id AND pa.attribute_id = ad.attribute_id AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY agd.name, ad.name, pa.text ASC),'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_attributes, 					
			GROUP_CONCAT(IFNULL((SELECT m.name FROM `" . DB_PREFIX . "product` p, `" . DB_PREFIX . "manufacturer` m WHERE op.product_id = p.product_id AND p.manufacturer_id = m.manufacturer_id),'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_manu, 
			GROUP_CONCAT(IFNULL((SELECT GROUP_CONCAT(cd.name SEPARATOR ', ') FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "category` c, `" . DB_PREFIX . "product_to_category` p2c WHERE op.product_id = p2c.product_id AND p2c.category_id = c.category_id AND (c.category_id = cd.category_id OR c.parent_id = cd.category_id) AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.status > 0),'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_category, 
			GROUP_CONCAT(o.currency_code ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_currency,  
			GROUP_CONCAT(ROUND(o.currency_value*op.price, 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_price, 
			GROUP_CONCAT(op.quantity ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_quantity, 
			GROUP_CONCAT(ROUND(o.currency_value*op.total, 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_total_excl_vat, 
			GROUP_CONCAT(ROUND(o.currency_value*op.tax*op.quantity, 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_tax, 
			GROUP_CONCAT(ROUND(o.currency_value*(op.total+(op.tax*op.quantity)), 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_total_incl_vat, ";

		}
			$sql .= "GROUP_CONCAT(op.order_id ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_ord_id, 
			GROUP_CONCAT('<a href=\"index.php?route=sale/order/info&token=$token&order_id=',op.order_id,'\">',op.order_id,'</a>' ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_ord_id_link, ";
			if ($this->config->get('advpp' . $this->user->getId() . '_date_format') == 'DDMMYYYY') {																																																																																																																																																																																																																																												   				$sql .= "GROUP_CONCAT(DATE_FORMAT(o.date_added, '%d/%m/%Y') ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_ord_date, ";
			} else {	
				$sql .= "GROUP_CONCAT(DATE_FORMAT(o.date_added, '%m/%d/%Y') ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_ord_date, ";
			}	
			$sql .= "GROUP_CONCAT(IF (o.customer_id = 0,'0',CONCAT('<a href=\"index.php?route=sale/customer/update&token=$token&customer_id=',o.customer_id,'\">',o.customer_id,'</a>')) ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_cust_id_link, 
			GROUP_CONCAT(IF (o.customer_id = 0,'0',o.customer_id) ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_cust_id, 
			GROUP_CONCAT(IF ((CONCAT(o.payment_firstname,o.payment_lastname) = ''),'&nbsp;&nbsp;',(CONCAT(o.payment_firstname,' ',o.payment_lastname))) ORDER BY op.order_id DESC SEPARATOR '<br>') AS billing_name, 
			GROUP_CONCAT(IF (o.payment_company = '','&nbsp;&nbsp;',o.payment_company) ORDER BY op.order_id DESC SEPARATOR '<br>') AS billing_company, 
			GROUP_CONCAT(IF (o.payment_address_1 = '','&nbsp;&nbsp;',o.payment_address_1) ORDER BY op.order_id DESC SEPARATOR '<br>') AS billing_address_1, 
			GROUP_CONCAT(IF (o.payment_address_2 = '','&nbsp;&nbsp;',o.payment_address_2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS billing_address_2, 
			GROUP_CONCAT(IF (o.payment_city = '','&nbsp;&nbsp;',o.payment_city) ORDER BY op.order_id DESC SEPARATOR '<br>') AS billing_city, 
			GROUP_CONCAT(IF (o.payment_zone = '','&nbsp;&nbsp;',o.payment_zone) ORDER BY op.order_id DESC SEPARATOR '<br>') AS billing_zone, 
			GROUP_CONCAT(IF (o.payment_postcode = '','&nbsp;&nbsp;',o.payment_postcode) ORDER BY op.order_id DESC SEPARATOR '<br>') AS billing_postcode, 
			GROUP_CONCAT(IF (o.payment_country = '','&nbsp;&nbsp;',o.payment_country) ORDER BY op.order_id DESC SEPARATOR '<br>') AS billing_country, 
			GROUP_CONCAT(IF (o.telephone = '','&nbsp;&nbsp;',o.telephone) ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_telephone, 
			GROUP_CONCAT(IF ((CONCAT(o.shipping_firstname,o.shipping_lastname) = ''),'&nbsp;&nbsp;',(CONCAT(o.shipping_firstname,' ',o.shipping_lastname))) ORDER BY op.order_id DESC SEPARATOR '<br>') AS shipping_name, 
			GROUP_CONCAT(IF (o.shipping_company = '','&nbsp;&nbsp;',o.shipping_company) ORDER BY op.order_id DESC SEPARATOR '<br>') AS shipping_company, 
			GROUP_CONCAT(IF (o.shipping_address_1 = '','&nbsp;&nbsp;',o.shipping_address_1) ORDER BY op.order_id DESC SEPARATOR '<br>') AS shipping_address_1, 
			GROUP_CONCAT(IF (o.shipping_address_2 = '','&nbsp;&nbsp;',o.shipping_address_2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS shipping_address_2, 
			GROUP_CONCAT(IF (o.shipping_city = '','&nbsp;&nbsp;',o.shipping_city) ORDER BY op.order_id DESC SEPARATOR '<br>') AS shipping_city, 
			GROUP_CONCAT(IF (o.shipping_zone = '','&nbsp;&nbsp;',o.shipping_zone) ORDER BY op.order_id DESC SEPARATOR '<br>') AS shipping_zone, 			
			GROUP_CONCAT(IF (o.shipping_postcode = '','&nbsp;&nbsp;',o.shipping_postcode) ORDER BY op.order_id DESC SEPARATOR '<br>') AS shipping_postcode, 
			GROUP_CONCAT(IF (o.shipping_country = '','&nbsp;&nbsp;',o.shipping_country) ORDER BY op.order_id DESC SEPARATOR '<br>') AS shipping_country ";
		}
		
		if (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {		
		$sql .= "FROM `" . DB_PREFIX . "order` o INNER JOIN `" . DB_PREFIX . "order_product` op ON (o.order_id = op.order_id) LEFT JOIN (SELECT oo.order_product_id, GROUP_CONCAT(oo.name, oo.value, oo.type ORDER BY oo.name, oo.value, oo.type) AS options FROM `" . DB_PREFIX . "order_option` oo WHERE (type != 'textarea' OR type != 'file' OR type != 'date' OR type != 'datetime' OR type != 'time') GROUP BY oo.order_product_id) qa ON (op.order_product_id = qa.order_product_id)" . $date . $sdate . $osi . $order_id . $store . $cur . $tax . $tclass . $geo_zone . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . $type;
		} else {
		$sql .= "FROM `" . DB_PREFIX . "order` o INNER JOIN `" . DB_PREFIX . "order_product` op ON (o.order_id = op.order_id)" . $date . $sdate . $osi . $order_id . $store . $cur . $tax . $tclass . $geo_zone . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . $type;
		}
		
		}
		
		} else {
			
		$sql = "SELECT *, 
		CONCAT('<a href=\"index.php?route=sale/order/info&token=$token&order_id=',o.order_id,'\">',o.order_id,'</a>') AS order_id_link, 
		CONCAT('<a href=\"index.php?route=catalog/product/update&token=$token&product_id=',op.product_id,'\">',op.product_id,'</a>') AS product_id_link, 		
		CONCAT('<a href=\"index.php?route=sale/customer/update&token=$token&customer_id=',o.customer_id,'\">',o.customer_id,'</a>') AS customer_id_link, 
		(SELECT cgd.name FROM `" . DB_PREFIX . "customer_group_description` cgd WHERE op.order_id = o.order_id AND cgd.customer_group_id = o.customer_group_id AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS cust_group, 
		(SELECT p.sku FROM " . DB_PREFIX . "product p WHERE op.order_id = o.order_id AND op.product_id = p.product_id) AS product_sku, 
		op.model AS product_model, 
		op.name AS product_name, 
		(SELECT GROUP_CONCAT(CONCAT(oo.name,': ',oo.value) SEPARATOR '; ') FROM `" . DB_PREFIX . "order_option` oo WHERE op.order_product_id = oo.order_product_id AND oo.type != 'textarea' ORDER BY op.order_product_id) AS product_option, 
		(SELECT GROUP_CONCAT(CONCAT(agd.name,'&nbsp;&gt;&nbsp;',ad.name,'&nbsp;&gt;&nbsp;',pa.text) SEPARATOR '; ') FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.product_id = op.product_id AND pa.attribute_id = ad.attribute_id AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY agd.name, ad.name, pa.text ASC) AS product_attributes, 
		(SELECT m.name FROM `" . DB_PREFIX . "product` p, `" . DB_PREFIX . "manufacturer` m WHERE op.product_id = p.product_id AND p.manufacturer_id = m.manufacturer_id) AS product_manu, 
		(SELECT GROUP_CONCAT(cd.name SEPARATOR ', ') FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "category` c, `" . DB_PREFIX . "product_to_category` p2c WHERE op.product_id = p2c.product_id AND p2c.category_id = c.category_id AND (c.category_id = cd.category_id OR c.parent_id = cd.category_id) AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.status > 0) AS product_category, 
		(o.currency_value*op.price) AS product_price, 
		op.quantity AS product_quantity, 
		(o.currency_value*op.total) AS product_total_excl_vat, 
		(o.currency_value*op.tax*op.quantity) AS product_tax, 
		(o.currency_value*(op.total+(op.tax*op.quantity))) AS product_total_incl_vat, 
		IFNULL((SELECT SUM(r.quantity) FROM `" . DB_PREFIX . "return` r WHERE r.product_id = op.product_id AND r.order_id = op.order_id AND r.return_action_id = '1'), 0) AS product_qty_refund, 
		(SELECT o.currency_value*(op.price*r.quantity) FROM `" . DB_PREFIX . "return` r WHERE r.product_id = op.product_id AND r.order_id = op.order_id AND r.return_action_id = '1') AS product_refund, 
		op.reward AS product_reward_points, 
		(SELECT o.currency_value*SUM(ot.value) FROM " . DB_PREFIX . "order_total ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id) AS order_sub_total, 
		(SELECT o.currency_value*SUM(ot.value) FROM " . DB_PREFIX . "order_total ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id) AS order_handling, 
		(SELECT o.currency_value*SUM(ot.value) FROM " . DB_PREFIX . "order_total ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id) AS order_low_order_fee, 
		(SELECT o.currency_value*SUM(ot.value) FROM " . DB_PREFIX . "order_total ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id) AS order_shipping, 
		(SELECT o.currency_value*SUM(ot.value) FROM " . DB_PREFIX . "order_total ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id) AS order_reward, 
		(SELECT SUM(op.reward) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id) AS order_earned_points, 
		(SELECT SUM(crp.points) FROM `" . DB_PREFIX . "customer_reward` crp WHERE crp.order_id = o.order_id AND crp.points < 0 GROUP BY op.order_id) AS order_used_points, 	
		(SELECT o.currency_value*SUM(ot.value) FROM " . DB_PREFIX . "order_total ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id) AS order_coupon, 
		(SELECT CONCAT(cp.name,' [',cp.code,']') FROM `" . DB_PREFIX . "coupon` cp, `" . DB_PREFIX . "coupon_history` cph WHERE cph.order_id = op.order_id AND cph.coupon_id = cp.coupon_id) AS order_coupon_code, 
		(SELECT o.currency_value*SUM(ot.value) FROM " . DB_PREFIX . "order_total ot WHERE ot.order_id = o.order_id AND ot.code = 'tax' GROUP BY ot.order_id) AS order_tax, 
		(SELECT o.currency_value*SUM(ot.value) FROM " . DB_PREFIX . "order_total ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id) AS order_credit, 
		(SELECT o.currency_value*SUM(ot.value) FROM " . DB_PREFIX . "order_total ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id) AS order_voucher, 
		(SELECT v.code FROM `" . DB_PREFIX . "voucher` v, `" . DB_PREFIX . "voucher_history` vh WHERE vh.order_id = op.order_id AND vh.voucher_id = v.voucher_id) AS order_voucher_code, 
		(o.currency_value*o.commission) AS order_commission, 		
		(SELECT o.currency_value*SUM(op.price*r.quantity) FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "return` r WHERE r.product_id = op.product_id AND r.order_id = op.order_id AND o.order_id = op.order_id AND r.return_action_id = '1' GROUP BY r.order_id) AS order_refund, 
		(o.currency_value*o.total) AS order_value, 
		(SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE op.order_id = o.order_id AND os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status, 
		(SELECT z.code FROM `" . DB_PREFIX . "zone` z WHERE z.zone_id = o.payment_zone_id) AS payment_zone_code, 
		(SELECT cnt.iso_code_2 FROM `" . DB_PREFIX . "country` cnt WHERE cnt.country_id = o.payment_country_id) AS payment_country_code, 
		(SELECT z.code FROM `" . DB_PREFIX . "zone` z WHERE z.zone_id = o.shipping_zone_id) AS shipping_zone_code, 
		(SELECT cnt.iso_code_2 FROM `" . DB_PREFIX . "country` cnt WHERE cnt.country_id = o.shipping_country_id) AS shipping_country_code, 
		ROUND(IFNULL((SELECT SUM((p.weight*op.quantity) / wc.value) FROM `" . DB_PREFIX . "product` p, `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "weight_class` wc WHERE op.product_id = p.product_id AND op.order_id = o.order_id AND wc.weight_class_id = p.weight_class_id GROUP BY op.order_id),0) + IFNULL((SELECT SUM((pov.weight*op.quantity) / wc.value) FROM `" . DB_PREFIX . "product` p, `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order_option` oo, `" . DB_PREFIX . "product_option_value` pov, `" . DB_PREFIX . "weight_class` wc WHERE op.product_id = p.product_id AND op.order_id = o.order_id AND op.order_product_id = oo.order_product_id AND oo.product_option_value_id = pov.product_option_value_id AND wc.weight_class_id = p.weight_class_id GROUP BY op.order_id),0), 2) AS order_weight, 
		(SELECT wcd.unit FROM `" . DB_PREFIX . "weight_class_description` wcd WHERE wcd.weight_class_id = '" . $this->config->get('config_weight_class_id') . "' AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class 

		FROM `" . DB_PREFIX . "order` o INNER JOIN `" . DB_PREFIX . "order_product` op ON (o.order_id = op.order_id)" . $date . $sdate . $osi . $order_id . $store . $cur . $tax . $tclass . $geo_zone . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . $type;
		
		$sql .= " ORDER BY o.order_id DESC";
		}

		if (isset($data['filter_details']) && $data['filter_details'] != 'all_details') {

		if (isset($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'no_group'; //show No Grouping in Group By default
		}
		
		if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
		
			$sql .= " GROUP BY p.product_id";

		} else {
		
		switch($group) {
			case 'no_group';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
					$sql .= " GROUP BY op.product_id";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
					$sql .= " GROUP BY op.product_id, options";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
					$sql .= " GROUP BY manufacturer";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
					$sql .= " GROUP BY category";	
				}
				break;	
			case 'order';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
					$sql .= " GROUP BY o.order_id, op.product_id";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
					$sql .= " GROUP BY o.order_id, op.product_id, options";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
					$sql .= " GROUP BY o.order_id, manufacturer";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
					$sql .= " GROUP BY o.order_id, category";	
				}			
				break;				
			case 'day';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, DAY(o.date_added) DESC, op.product_id";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, DAY(o.date_added) DESC, op.product_id, options";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, DAY(o.date_added) DESC, manufacturer";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, DAY(o.date_added) DESC, category";	
				}
				break;
			case 'week':
				if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, WEEK(o.date_added) DESC, op.product_id";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, WEEK(o.date_added) DESC, op.product_id, options";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, WEEK(o.date_added) DESC, manufacturer";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, WEEK(o.date_added) DESC, category";	
				}
				break;			
			case 'month':
				if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, op.product_id";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, op.product_id, options";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, manufacturer";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, category";	
				}
				break;
			case 'quarter':
				if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, QUARTER(o.date_added) DESC, op.product_id";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, QUARTER(o.date_added) DESC, op.product_id, options";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, QUARTER(o.date_added) DESC, manufacturer";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, QUARTER(o.date_added) DESC, category";	
				}
				break;				
			case 'year':
				if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, op.product_id";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, op.product_id, options";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, manufacturer";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, category";	
				}
				break;			
		}
		
		}

		if (isset($data['filter_sort']) && $data['filter_sort'] == 'date') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY date_added DESC, id DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= " ORDER BY date_added DESC, id DESC ";
			} else {
				$sql .= " ORDER BY date_start DESC, sold_quantity DESC ";
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'id') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY id DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= " ORDER BY id DESC ";
			} else {	
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY product_id DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY product_id DESC, o.order_id DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, product_id DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, product_id DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, product_id DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, product_id DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, product_id DESC ";
			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'sku') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY LCASE(sku) ASC, sold_quantity DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= " ORDER BY LCASE(sku) ASC ";
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(sku) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(sku) ASC, sold_quantity DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, LCASE(sku) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(sku) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(sku) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(sku) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(sku) ASC, sold_quantity DESC ";
			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'name') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY LCASE(name) ASC, sold_quantity DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= " ORDER BY LCASE(name) ASC ";
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(name) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(name) ASC, sold_quantity DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, LCASE(name) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(name) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(name) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(name) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(name) ASC, sold_quantity DESC ";
			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'model') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY LCASE(model) ASC, sold_quantity DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= " ORDER BY LCASE(model) ASC ";
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(model) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(model) ASC, sold_quantity DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, LCASE(model) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(model) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(model) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(model) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(model) ASC, sold_quantity DESC ";
			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'category') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY LCASE(category) ASC, sold_quantity DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= " ORDER BY LCASE(category) ASC ";
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(category) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(category) ASC, sold_quantity DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, LCASE(category) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(category) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(category) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(category) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(category) ASC, sold_quantity DESC ";
			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'manufacturer') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY LCASE(manufacturer) ASC, sold_quantity DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= " ORDER BY LCASE(manufacturer) ASC ";
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(manufacturer) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(manufacturer) ASC, sold_quantity DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, LCASE(manufacturer) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(manufacturer) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(manufacturer) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(manufacturer) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(manufacturer) ASC, sold_quantity DESC ";
			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'attribute') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY LCASE(attribute) ASC, sold_quantity DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= " ORDER BY LCASE(attribute) ASC ";
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(attribute) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(attribute) ASC, sold_quantity DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, LCASE(attribute) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(attribute) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(attribute) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(attribute) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(attribute) ASC, sold_quantity DESC ";
			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'status') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY status DESC, sold_quantity DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= " ORDER BY status DESC ";
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY status DESC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY status DESC, sold_quantity DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, status DESC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, status DESC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, status DESC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, status DESC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, status DESC, sold_quantity DESC ";
			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'location') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY LCASE(location) ASC, sold_quantity DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= " ORDER BY LCASE(location) ASC ";
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(location) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(location) ASC, sold_quantity DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, LCASE(location) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(location) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(location) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(location) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(location) ASC, sold_quantity DESC ";
			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'tax_class') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY LCASE(tax_class) ASC, sold_quantity DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= " ORDER BY LCASE(tax_class) ASC ";
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(tax_class) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(tax_class) ASC, sold_quantity DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, LCASE(tax_class) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(tax_class) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(tax_class) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(tax_class) ASC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(tax_class) ASC, sold_quantity DESC ";

			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'price') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY prod_price DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= " ORDER BY prod_price DESC ";
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY prod_price DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY prod_price DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, prod_price DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, prod_price DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, prod_price DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, prod_price DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, prod_price DESC ";
			}
			}		
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'viewed') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY viewed DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= " ORDER BY viewed DESC ";
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY viewed DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY viewed DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, viewed DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, viewed DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, viewed DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, viewed DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, viewed DESC ";
			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'stock_quantity') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY stock_quantity DESC, sold_quantity DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= " ORDER BY quantity DESC ";
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY stock_quantity DESC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY stock_quantity DESC, sold_quantity DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, stock_quantity DESC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, stock_quantity DESC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, stock_quantity DESC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, stock_quantity DESC, sold_quantity DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, stock_quantity DESC, sold_quantity DESC ";
			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'sold_quantity') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY sold_quantity DESC, total_excl_vat DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= '';
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY sold_quantity DESC, total_excl_vat DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY sold_quantity DESC, total_excl_vat DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, sold_quantity DESC, total_excl_vat DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, sold_quantity DESC, total_excl_vat DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, sold_quantity DESC, total_excl_vat DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, sold_quantity DESC, total_excl_vat DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, sold_quantity DESC, total_excl_vat DESC ";
			}
			}	
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'total_excl_vat') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY total_excl_vat DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= '';
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY total_excl_vat DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY total_excl_vat DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, total_excl_vat DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, total_excl_vat DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, total_excl_vat DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, total_excl_vat DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, total_excl_vat DESC ";
			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'total_tax') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY total_tax DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= '';
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY total_tax DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY total_tax DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, total_tax DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, total_tax DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, total_tax DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, total_tax DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, total_tax DESC ";
			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'total_incl_vat') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY total_incl_vat DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= '';
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY total_incl_vat DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY total_incl_vat DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, total_incl_vat DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, total_incl_vat DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, total_incl_vat DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, total_incl_vat DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, total_incl_vat DESC ";
			}
			}			
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'app') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY (total_excl_vat / sold_quantity) DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= '';
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY (SUM(op.total) / SUM(op.quantity)) DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY (SUM(op.total) / SUM(op.quantity)) DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, (SUM(op.total) / SUM(op.quantity)) DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, (SUM(op.total) / SUM(op.quantity)) DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, (SUM(op.total) / SUM(op.quantity)) DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, (SUM(op.total) / SUM(op.quantity)) DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, (SUM(op.total) / SUM(op.quantity)) DESC ";
			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'refunds') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY refunds DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= '';
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY refunds DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY refunds DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, refunds DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, refunds DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, refunds DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, refunds DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, refunds DESC ";
			}
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'reward_points') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$sql .= " ORDER BY reward_points DESC ";
			} else if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= '';
			} else {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY reward_points DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY reward_points DESC, o.order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, DAY(date) DESC, reward_points DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, reward_points DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, reward_points DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, reward_points DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, reward_points DESC ";
			}
			}
		} else {
			if (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
				$sql .= " ORDER BY id DESC ";
			} else {
				$sql .= " ORDER BY sold_quantity DESC, total_excl_vat DESC ";
			}
		}
		
		}
		
		if (isset($data['start']) || isset($data['filter_limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['filter_limit'] < 1) {
				$data['filter_limit'] = 25;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['filter_limit'];
		}
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}	

	public function getProductsTotal($data = array()) {
		$query = $this->db->query("SET SESSION group_concat_max_len=500000");
		
		$token = $this->session->data['token'];

		if (!empty($data['filter_date_start'])) {	
			$date_start = $data['filter_date_start'];
		} else {
			$date_start = '';
		}

		if (!empty($data['filter_date_end'])) {	
			$date_end = $data['filter_date_end'];
		} else {
			$date_end = '';
		}

		if (isset($data['filter_range'])) {
			$range = $data['filter_range'];
		} else {
			$range = 'current_year'; //show Current Year in Statistical Range by default
		}

		switch($range) 
		{
			case 'custom';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
					$date_end = " AND DATE(p.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";				
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < '" . $this->db->escape($data['filter_date_start']) . "'";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
					$date_end = " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape($data['filter_date_start']) . "'))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape($data['filter_date_start']) . "')) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "') AND (DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'))";
				} else {
					$type = '';
				}				
				break;	
			case 'today';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) = CURDATE()";
					$date_end = '';				
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < CURDATE()";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) = CURDATE()";
					$date_end = '';	
				}
				$type = '';				
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) = CURDATE()))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE())) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) = CURDATE()))";
				} else {
					$type = '';
				}					
				break;
			case 'yesterday';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= DATE_ADD(CURDATE(), INTERVAL -1 DAY)";
					$date_end = " AND DATE(p.date_added) < CURDATE()";		
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < DATE_ADD(CURDATE(), INTERVAL -1 DAY)";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) >= DATE_ADD(CURDATE(), INTERVAL -1 DAY)";
					$date_end = " AND DATE(o.date_added) < CURDATE()";	
				}
				$type = '';				
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) >= DATE_ADD(CURDATE(), INTERVAL -1 DAY)))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < DATE_ADD(CURDATE(), INTERVAL -1 DAY))) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= DATE_ADD(CURDATE(), INTERVAL -1 DAY)) AND (DATE(o.date_added) < CURDATE()))";					
				} else {
					$type = '';
				}					
				break;					
			case 'week';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-7 day'))) . "'";
					$date_end = " AND DATE(p.date_added) <= DATE (NOW())";	
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-7 day'))) . "'";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-7 day'))) . "'";
					$date_end = " AND DATE(o.date_added) <= DATE (NOW())";		
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-7 day'))) . "'))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-7 day'))) . "')) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-7 day'))) . "'))";
				} else {
					$type = '';
				}					
				break;
			case 'month';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-30 day'))) . "'";
					$date_end = " AND DATE(p.date_added) <= DATE (NOW())";	
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-30 day'))) . "'";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-30 day'))) . "'";
					$date_end = " AND DATE(o.date_added) <= DATE (NOW())";			
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-30 day'))) . "'))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-30 day'))) . "')) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-30 day'))) . "'))";
				} else {
					$type = '';
				}					
				break;			
			case 'quarter';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-91 day'))) . "'";
					$date_end = " AND DATE(p.date_added) <= DATE (NOW())";	
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-91 day'))) . "'";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-91 day'))) . "'";
					$date_end = " AND DATE(o.date_added) <= DATE (NOW())";			
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-91 day'))) . "'))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-91 day'))) . "')) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-91 day'))) . "'))";						
				} else {
					$type = '';
				}					
				break;
			case 'year';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-365 day'))) . "'";
					$date_end = " AND DATE(p.date_added) <= DATE (NOW())";	
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-365 day'))) . "'";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-365 day'))) . "'";
					$date_end = " AND DATE(o.date_added) <= DATE (NOW())";			
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-365 day'))) . "'))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < '" . $this->db->escape(date('Y-m-d', strtotime('-365 day'))) . "')) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-365 day'))) . "'))";					
				} else {
					$type = '';
				}					
				break;
			case 'current_week';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= CURDATE() - WEEKDAY(CURDATE())";
					$date_end = " AND DATE(p.date_added) <= DATE (NOW())";	
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < CURDATE() - WEEKDAY(CURDATE())";
					$date_end = '';					
				} else {
					$date_start = "DATE(o.date_added) >= CURDATE() - WEEKDAY(CURDATE())";
					$date_end = " AND DATE(o.date_added) <= DATE (NOW())";			
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - WEEKDAY(CURDATE())))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - WEEKDAY(CURDATE()))) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= CURDATE() - WEEKDAY(CURDATE())))";
				} else {
					$type = '';
				}				
				break;	
			case 'current_month';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "YEAR(p.date_added) = YEAR(CURDATE())";
					$date_end = " AND MONTH(p.date_added) = MONTH(CURDATE())";		
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < CURDATE() - DAYOFMONTH(CURDATE()) + 1";
					$date_end = '';					
				} else {
					$date_start = "YEAR(o.date_added) = YEAR(CURDATE())";
					$date_end = " AND MONTH(o.date_added) = MONTH(CURDATE())";				
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - DAYOFMONTH(CURDATE()) + 1))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - DAYOFMONTH(CURDATE()) + 1)) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= CURDATE() - DAYOFMONTH(CURDATE()) + 1))";
				} else {
					$type = '';
				}					
				break;
			case 'current_quarter';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "QUARTER(p.date_added) = QUARTER(CURDATE())";
					$date_end = " AND YEAR(p.date_added) = YEAR(CURDATE())";	
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < MAKEDATE(YEAR(CURDATE()), 1) + INTERVAL QUARTER(CURDATE()) QUARTER - INTERVAL 1 QUARTER";
					$date_end = '';					
				} else {
					$date_start = "QUARTER(o.date_added) = QUARTER(CURDATE())";
					$date_end = " AND YEAR(o.date_added) = YEAR(CURDATE())";				
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < MAKEDATE(YEAR(CURDATE()), 1) + INTERVAL QUARTER(CURDATE()) QUARTER - INTERVAL 1 QUARTER))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < MAKEDATE(YEAR(CURDATE()), 1) + INTERVAL QUARTER(CURDATE()) QUARTER - INTERVAL 1 QUARTER)) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= MAKEDATE(YEAR(CURDATE()), 1) + INTERVAL QUARTER(CURDATE()) QUARTER - INTERVAL 1 QUARTER))";					
				} else {
					$type = '';
				}
				break;					
			case 'current_year';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "YEAR(p.date_added) = YEAR(CURDATE())";
					$date_end = '';					
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < CURDATE() - YEAR(CURDATE())";
					$date_end = '';					
				} else {
					$date_start = "YEAR(o.date_added) = YEAR(CURDATE())";
					$date_end = '';					
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - YEAR(CURDATE())))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - YEAR(CURDATE()))) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= CURDATE() - YEAR(CURDATE())))";
				} else {
					$type = '';
				}					
				break;					
			case 'last_week';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+5 DAY";
					$date_end = " AND DATE(p.date_added) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())-2 DAY";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+5 DAY";
					$date_end = '';
				} else {
					$date_start = "DATE(o.date_added) >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+5 DAY";
					$date_end = " AND DATE(o.date_added) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())-2 DAY";
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+5 DAY))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+5 DAY)) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+5 DAY) AND (DATE(o.date_added) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())-2 DAY))";
				} else {
					$type = '';
				}				
				break;	
			case 'last_month';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01')";
					$date_end = " AND DATE(p.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/%m/01')";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01')";
					$date_end = '';
				} else {
					$date_start = "DATE(o.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01')";
					$date_end = " AND DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/%m/01')";
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01')))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {					
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01'))) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01')) AND (DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/%m/01')))";
				} else {
					$type = '';
				}					
				break;
			case 'last_quarter';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "QUARTER(p.date_added) = QUARTER(DATE_ADD(NOW(), INTERVAL -3 MONTH))";
					$date_end = " AND YEAR(p.date_added) = YEAR(CURDATE())";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_customers') {
					$date_start = "DATE(o.date_added) < LAST_DAY(CURRENT_DATE - INTERVAL 2 QUARTER) + INTERVAL 1 DAY";
					$date_end = '';
				} else {
					$date_start = "QUARTER(o.date_added) = QUARTER(DATE_ADD(NOW(), INTERVAL -3 MONTH))";
					$date_end = " AND YEAR(o.date_added) = YEAR(CURDATE())";
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < LAST_DAY(CURRENT_DATE - INTERVAL 2 QUARTER) + INTERVAL 1 DAY))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {					
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < LAST_DAY(CURRENT_DATE - INTERVAL 2 QUARTER) + INTERVAL 1 DAY)) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= LAST_DAY(CURRENT_DATE - INTERVAL 2 QUARTER) + INTERVAL 1 DAY) AND (DATE(o.date_added) < LAST_DAY(CURRENT_DATE - INTERVAL 1 QUARTER) + INTERVAL 1 DAY))";					
				} else {
					$type = '';
				}					
				break;					
			case 'last_year';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 YEAR, '%Y/01/01')";
					$date_end = " AND DATE(p.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/01/01')";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE - INTERVAL 1 YEAR, '%Y/01/01')";
					$date_end = '';
				} else {
					$date_start = "DATE(o.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 YEAR, '%Y/01/01')";
					$date_end = " AND DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/01/01')";
				}
				$type = '';
				if (isset($data['filter_report']) && $data['filter_report'] == 'new_products_purchased') {
					$type = " AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE - INTERVAL 1 YEAR, '%Y/01/01')))";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {					
					$type = " AND op.product_id IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "') AND (DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE - INTERVAL 1 YEAR, '%Y/01/01'))) AND op.product_id NOT IN (SELECT op.product_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_status_id > 0 AND o.order_id = op.order_id AND (DATE(o.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 YEAR, '%Y/01/01')) AND (DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/01/01')))";
				} else {
					$type = '';
				}					
				break;					
			case 'all_time';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
					$date_start = "DATE(p.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "'";
					$date_end = " AND DATE(p.date_added) <= DATE (NOW())";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'old_products_purchased') {
					$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "'";
					$date_end = " AND DATE(o.date_added) <= DATE (NOW())";			
				} else {
					$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "'";
					$date_end = " AND DATE(o.date_added) <= DATE (NOW())";
				}	
				$type = '';				
				break;	
		}

		if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$date = ' AND (' . $date_start . $date_end . ')';								
		} else {
			$date = ' WHERE (' . $date_start . $date_end . ')';				
		}
		
		$osi = '';
		$osii = '';
		$sdate = '';
		if (isset($data['filter_report']) && $data['filter_report'] != 'products_without_orders') {
		if (!empty($data['filter_order_status_id'])) {
			if ((!empty($data['filter_status_date_start'])) && (!empty($data['filter_status_date_end']))) {			
				$osi .= " AND (SELECT DISTINCT oh.order_id FROM `" . DB_PREFIX . "order_history` oh WHERE o.order_id = oh.order_id AND (";
				$implode = array();
				foreach ($data['filter_order_status_id'] as $order_status_id) {
					$implode[] = "oh.order_status_id = '" . (int)$order_status_id . "'";
				}
				if ($implode) {
					$osi .= implode(" OR ", $implode) . "";
				}
				$osi .= ") AND DATE(oh.date_added) >= '" . $this->db->escape($data['filter_status_date_start']) . "' AND DATE(oh.date_added) <= '" . $this->db->escape($data['filter_status_date_end']) . "')";
			} else {
				if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$osi .= " AND (SELECT o.order_id FROM `" . DB_PREFIX . "order` o, `" . DB_PREFIX . "order_product` op WHERE o.order_id = op.order_id AND p.product_id = op.product_id AND o.order_status_id > 0 AND (";
				$osii .= " AND (";
				} else {
				$osi .= " AND (";
				}
				$implode = array();
				foreach ($data['filter_order_status_id'] as $order_status_id) {
					$implode[] = "o.order_status_id = '" . (int)$order_status_id . "'";
				}
				if ($implode) {
					if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
					$osi .= implode(" OR ", $implode) . "";
					$osii .= implode(" OR ", $implode) . "";
					} else {
					$osi .= implode(" OR ", $implode) . "";
					}
				}
				if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
				$osi .= ") GROUP BY p.product_id)";
				$osii .= ")";
				} else {
				$osi .= ")";
				}
				
				$status_date_start = '';
				$status_date_end = '';
				$sdate = $status_date_start . $status_date_end;				
			}
		} else {
			if (!empty($data['filter_status_date_start'])) {		
				$status_date_start = "AND DATE(o.date_modified) >= '" . $this->db->escape($data['filter_status_date_start']) . "'";
			} else {
				$status_date_start = '';
			}
			if (!empty($data['filter_status_date_end'])) {
				$status_date_end = "AND DATE(o.date_modified) <= '" . $this->db->escape($data['filter_status_date_end']) . "'";	
			} else {
				$status_date_end = '';
			}

			if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
			$osi .= '';
			} else {
			$osi = " AND o.order_status_id > 0";
			}
			$sdate = $status_date_start . $status_date_end;
		}

		$order_id_from = '';
		$order_id_to = '';
		if (!empty($data['filter_order_id_from'])) {		
			$order_id_from = " AND o.order_id >= '" . $this->db->escape($data['filter_order_id_from']) . "'";
		} else {
			$order_id_from = '';
		}
		if (!empty($data['filter_order_id_to'])) {	
			$order_id_to = " AND o.order_id <= '" . $this->db->escape($data['filter_order_id_to']) . "'";	
		} else {
			$order_id_to = '';
		}
		$order_id = $order_id_from . $order_id_to;
		}
		
		$store = '';
		if (!empty($data['filter_store_id'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$store .= " AND (SELECT DISTINCT p.product_id FROM `" . DB_PREFIX . "product_to_store` pts WHERE p.product_id = pts.product_id AND (";
			} else {
			$store .= " AND (";
			}	
			$implode = array();
			foreach ($data['filter_store_id'] as $store_id) {
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
				$implode[] = "pts.store_id = '" . (int)$store_id . "'";	
				} else {
				$implode[] = "o.store_id = '" . (int)$store_id . "'";
				}
			}
			if ($implode) {
				$store .= implode(" OR ", $implode) . "";
			}
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$store .= "))";
			} else {
			$store .= ")";
			}
		}
		
		$cur = '';
		if (!empty($data['filter_currency'])) {
			$cur .= " AND (";
			$implode = array();
			foreach ($data['filter_currency'] as $currency) {
				$implode[] = "o.currency_id = '" . (int)$currency . "'";
			}
			if ($implode) {
				$cur .= implode(" OR ", $implode) . "";
			}
			$cur .= ")";
		}
		
		$tax = '';
		if (!empty($data['filter_taxes'])) {
			$tax .= " AND (SELECT DISTINCT ot.order_id FROM `" . DB_PREFIX . "order_total` ot WHERE o.order_id = ot.order_id AND ot.code = 'tax' AND (";
			$implode = array();
			foreach ($data['filter_taxes'] as $taxes) {
				$implode[] = "LCASE(ot.title) = '" . $taxes . "'";
			}
			if ($implode) {
				$tax .= implode(" OR ", $implode) . "";
			}
			$tax .= "))";
		}

		$tclass = '';
		if (!empty($data['filter_tax_classes'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$tclass .= " AND (";
			} else {
			$tclass .= " AND (SELECT DISTINCT p.product_id FROM `" . DB_PREFIX . "tax_class` tc, `" . DB_PREFIX . "product` p WHERE p.product_id = op.product_id AND (";
			}
			$implode = array();
			foreach ($data['filter_tax_classes'] as $tax_classes) {
				$implode[] = "p.tax_class_id = '" . (int)$tax_classes . "'";
			}
			if ($implode) {
				$tclass .= implode(" OR ", $implode) . "";
			}
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$tclass .= ")";
			} else {
			$tclass .= "))";
			}
		}
		
		$geo_zone = '';
		if (!empty($data['filter_geo_zones'])) {
			$geo_zone .= " AND (SELECT gz.geo_zone_id FROM `" . DB_PREFIX . "geo_zone` gz, `" . DB_PREFIX . "zone_to_geo_zone` zgz WHERE (";
			$implode = array();
			foreach ($data['filter_geo_zones'] as $geo_zones) {
				$implode[] = "(gz.geo_zone_id = zgz.geo_zone_id AND zgz.zone_id = 0 AND zgz.country_id = o.payment_country_id AND gz.geo_zone_id = '" . (int)$geo_zones . "') OR (gz.geo_zone_id = zgz.geo_zone_id AND o.payment_zone_id = zgz.zone_id AND gz.geo_zone_id = '" . (int)$geo_zones . "')";
			}
			if ($implode) {
				$geo_zone .= implode(" OR ", $implode) . "";
			}
			$geo_zone .= "))";
		}
		
		$cgrp = '';
		if (!empty($data['filter_customer_group_id'])) {
			$cgrp .= " AND (";
			$implode = array();
			foreach ($data['filter_customer_group_id'] as $customer_group_id) {
				$implode[] = "(SELECT c.customer_group_id FROM `" . DB_PREFIX . "customer` c WHERE c.customer_id = o.customer_id AND c.customer_group_id = '" . (int)$customer_group_id . "') OR (o.customer_group_id = '" . (int)$customer_group_id . "' AND o.customer_id = 0)";
			}
			if ($implode) {
				$cgrp .= implode(" OR ", $implode) . "";
			}
			$cgrp .= ")";
		}
		
		$cust = '';
		if (!empty($data['filter_customer_name'])) {
			$cust = " AND LCASE(CONCAT(o.firstname, ' ', o.lastname)) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_customer_name'], 'UTF-8')) . "%'";
		} else {
			$cust = '';
		}

		$email = '';
		if (!empty($data['filter_customer_email'])) {
			$email = " AND LCASE(o.email) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_customer_email'], 'UTF-8')) . "%'";
		} else {
			$email = '';
		}

		$tel = '';
		if (!empty($data['filter_customer_telephone'])) {
			$tel = " AND LCASE(o.telephone) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_customer_telephone'], 'UTF-8')) . "%'";
		} else {
			$tel = '';
		}

		$ip = '';
		if (!empty($data['filter_ip'])) {
        	$ip = " AND LCASE(o.ip) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_ip'], 'UTF-8')) . "%'";
		} else {
			$ip = '';
		}
		
		$pcomp = '';
		if (!empty($data['filter_payment_company'])) {
        	$pcomp = " AND LCASE(o.payment_company) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_company'], 'UTF-8')) . "%'";
		} else {
			$pcomp = '';
		}

		$paddr = '';
		if (!empty($data['filter_payment_address'])) {
        	$paddr = " AND LCASE(CONCAT(o.payment_address_1, ', ', o.payment_address_2)) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_address'], 'UTF-8')) . "%'";
		} else {
			$paddr = '';
		}

		$pcity = '';
		if (!empty($data['filter_payment_city'])) {
        	$pcity = " AND LCASE(o.payment_city) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_city'], 'UTF-8')) . "%'";
		} else {
			$pcity = '';
		}

		$pzone = '';
		if (!empty($data['filter_payment_zone'])) {
        	$pzone = " AND LCASE(o.payment_zone) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_zone'], 'UTF-8')) . "%'";
		} else {
			$pzone = '';
		}

		$ppsc = '';
		if (!empty($data['filter_payment_postcode'])) {
        	$ppsc = " AND LCASE(o.payment_postcode) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_postcode'], 'UTF-8')) . "%'";
		} else {
			$ppsc = '';
		}

		$pcntr = '';
		if (!empty($data['filter_payment_country'])) {
        	$pcntr = " AND LCASE(o.payment_country) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_country'], 'UTF-8')) . "%'";
		} else {
			$pcntr = '';
		}

		$pmeth = '';
		if (!empty($data['filter_payment_method'])) {
			$pmeth .= " AND (";
			$implode = array();
			foreach ($data['filter_payment_method'] as $payment_code) {
				$implode[] = "o.payment_code = '" . $payment_code . "'";
			}
			if ($implode) {
				$pmeth .= implode(" OR ", $implode) . "";
			}
			$pmeth .= ")";
		}

		$scomp = '';
		if (!empty($data['filter_shipping_company'])) {
			$scomp = " AND LCASE(o.shipping_company) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_company'], 'UTF-8')) . "%'";
		} else {
			$scomp = '';
		}

		$saddr = '';
		if (!empty($data['filter_shipping_address'])) {
			$saddr = " AND LCASE(CONCAT(o.shipping_address_1, ', ', o.shipping_address_2)) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_address'], 'UTF-8')) . "%'";

		} else {
			$saddr = '';
		}

		$scity = '';
		if (!empty($data['filter_shipping_city'])) {
			$scity = " AND LCASE(o.shipping_city) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_city'], 'UTF-8')) . "%'";
		} else {
			$scity = '';
		}

		$szone = '';
		if (!empty($data['filter_shipping_zone'])) {
			$szone = " AND LCASE(o.shipping_zone) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_zone'], 'UTF-8')) . "%'";
		} else {
			$szone = '';
		}

		$spsc = '';
		if (!empty($data['filter_shipping_postcode'])) {
			$spsc = " AND LCASE(o.shipping_postcode) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_postcode'], 'UTF-8')) . "%'";			
		} else {
			$spsc = '';
		}

		$scntr = '';
		if (!empty($data['filter_shipping_country'])) {
			$scntr = " AND LCASE(o.shipping_country) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_country'], 'UTF-8')) . "%'";			
		} else {
			$scntr = '';
		}

		$smeth = '';
		if (!empty($data['filter_shipping_method'])) {
			$smeth .= " AND (";
			$implode = array();
			foreach ($data['filter_shipping_method'] as $shipping_code) {
				$implode[] = "o.shipping_code = '" . $shipping_code . "'";
			}
			if ($implode) {
				$smeth .= implode(" OR ", $implode) . "";
			}
			$smeth .= ")";
		}
		
		$cat = '';
		if (!empty($data['filter_category'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$cat .= " AND (SELECT DISTINCT p2c.product_id FROM `" . DB_PREFIX . "product_to_category` p2c WHERE p2c.product_id = p.product_id AND (";
			} else {
			$cat .= " AND (SELECT DISTINCT p2c.product_id FROM `" . DB_PREFIX . "product_to_category` p2c WHERE p2c.product_id = op.product_id AND (";
			}			
			$implode = array();
			foreach ($data['filter_category'] as $category_id) {
				$implode[] = "p2c.category_id = '" . (int)$category_id . "'";
			}
			if ($implode) {
				$cat .= implode(" OR ", $implode) . "";
			}
			$cat .= "))";
		}
		
		$manu = '';
		if (!empty($data['filter_manufacturer'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$manu .= " AND (";
			} else {
			$manu .= " AND (SELECT DISTINCT p.manufacturer_id FROM `" . DB_PREFIX . "product` p WHERE p.product_id = op.product_id AND (";
			}	
			$implode = array();
			foreach ($data['filter_manufacturer'] as $manufacturer) {
				$implode[] = "p.manufacturer_id = '" . (int)$manufacturer . "'";
			}
			if ($implode) {
				$manu .= implode(" OR ", $implode) . "";
			}
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$manu .= ")";
			} else {
			$manu .= "))";
			}
		}
		
		$sku = '';
		if (!empty($data['filter_sku'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
        	$sku = " AND LCASE(p.sku) LIKE '" . $this->db->escape(mb_strtolower($data['filter_sku'], 'UTF-8')) . "'";
			} else {
        	$sku = " AND (SELECT DISTINCT p.product_id FROM `" . DB_PREFIX . "product` p WHERE p.product_id = op.product_id AND LCASE(p.sku) LIKE '" . $this->db->escape(mb_strtolower($data['filter_sku'], 'UTF-8')) . "')";
			}	
		} else {
			$sku = '';
		}
		
		$prod = '';
		if (!empty($data['filter_product_name'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
        	$prod = " AND LCASE(pd.name) LIKE '" . $this->db->escape(mb_strtolower($data['filter_product_name'], 'UTF-8')) . "'";	
			} else {
        	$prod = " AND LCASE(op.name) LIKE '" . $this->db->escape(mb_strtolower($data['filter_product_name'], 'UTF-8')) . "'";	
			}				
		} else {
			$prod = '';
		}
		
		$mod = '';
		if (!empty($data['filter_model'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
        	$mod = " AND LCASE(p.model) LIKE '" . $this->db->escape(mb_strtolower($data['filter_model'], 'UTF-8')) . "'";		
			} else {
        	$mod = " AND LCASE(op.model) LIKE '" . $this->db->escape(mb_strtolower($data['filter_model'], 'UTF-8')) . "'";			
			}
		} else {
			$mod = '';
		}
		
		$opt = '';
		if (!empty($data['filter_option'])) {
			$opt .= " AND ";
			$implode = array();
			foreach ($data['filter_option'] as $option) {
				$implode[] = "(SELECT DISTINCT oo.order_product_id FROM `" . DB_PREFIX . "order_option` oo WHERE oo.order_product_id = op.order_product_id AND LCASE(CONCAT(oo.name,'_',oo.value,'_',oo.type)) = '" . $option . "' AND LCASE(op.name) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_product_name'], 'UTF-8')) . "%')";
			}
			if ($implode) {
				$opt .= implode(" AND ", $implode) . "";
			}
		}

		$atr = '';
		if (!empty($data['filter_attribute'])) {
			$atr .= " AND ";
			$implode = array();
			foreach ($data['filter_attribute'] as $attribute) {
				if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
				$implode[] = "(SELECT DISTINCT pa.product_id FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.product_id = p.product_id AND pa.attribute_id = ad.attribute_id AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND LCASE(CONCAT(agd.name,'_',ad.name,'_',pa.text)) = '" . $attribute . "')";
				} else {
				$implode[] = "(SELECT DISTINCT pa.product_id FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.product_id = op.product_id AND pa.attribute_id = ad.attribute_id AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND LCASE(CONCAT(agd.name,'_',ad.name,'_',pa.text)) = '" . $attribute . "')";		
				}
			}
			if ($implode) {
				$atr .= implode(" AND ", $implode) . "";
			}
		}

		$stat = '';
		if (!empty($data['filter_product_status'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$stat .= " AND (";
			} else {
			$stat .= " AND (SELECT DISTINCT p.product_id FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id AND (";
			}
			$implode = array();
			foreach ($data['filter_product_status'] as $product_status) {
				$implode[] = "p.status = '" . (int)$product_status . "'";
			}
			if ($implode) {
				$stat .= implode(" OR ", $implode) . "";
			}
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$stat .= ")";
			} else {
			$stat .= "))";
			}
		}
		
		$loc = '';
		if (!empty($data['filter_location'])) {
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$loc .= " AND (";
			} else {
			$loc .= " AND (SELECT DISTINCT p.product_id FROM `" . DB_PREFIX . "product` p WHERE p.product_id = op.product_id AND (";
			}	
			$implode = array();
			foreach ($data['filter_location'] as $location) {
				$implode[] = "LCASE(p.location) = '" . $location . "'";
			}
			if ($implode) {
				$loc .= implode(" OR ", $implode) . "";
			}
			if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
			$loc .= ")";
			} else {
			$loc .= "))";
			}
		}

		$affn = '';
		if (!empty($data['filter_affiliate_name'])) {
			$affn .= " AND (SELECT DISTINCT at.order_id FROM `" . DB_PREFIX . "affiliate_transaction` at WHERE at.order_id = o.order_id AND (";
			$implode = array();
			foreach ($data['filter_affiliate_name'] as $affiliate_name) {
				$implode[] = "at.affiliate_id = '" . (int)$affiliate_name . "'";
			}
			if ($implode) {
				$affn .= implode(" OR ", $implode) . "";
			}
			$affn .= "))";
		}

		$affe = '';
		if (!empty($data['filter_affiliate_email'])) {
			$affe .= " AND (SELECT DISTINCT at.order_id FROM `" . DB_PREFIX . "affiliate_transaction` at WHERE at.order_id = o.order_id AND (";
			$implode = array();
			foreach ($data['filter_affiliate_email'] as $affiliate_email) {
				$implode[] = "at.affiliate_id = '" . (int)$affiliate_email . "'";
			}
			if ($implode) {
				$affe .= implode(" OR ", $implode) . "";
			}
			$affe .= "))";
		}

		$cpn = '';
		if (!empty($data['filter_coupon_name'])) {
			$cpn .= " AND (SELECT DISTINCT cph.order_id FROM `" . DB_PREFIX . "coupon_history` cph WHERE cph.order_id = o.order_id AND (";
			$implode = array();
			foreach ($data['filter_coupon_name'] as $coupon_name) {
				$implode[] = "cph.coupon_id = '" . (int)$coupon_name . "'";
			}
			if ($implode) {
				$cpn .= implode(" OR ", $implode) . "";
			}
			$cpn .= "))";
		}

		$cpc = '';
		if (!empty($data['filter_coupon_code'])) {
			$cpc = " AND (SELECT DISTINCT cph.order_id FROM `" . DB_PREFIX . "coupon` cp, `" . DB_PREFIX . "coupon_history` cph WHERE cph.coupon_id = cp.coupon_id AND cph.order_id = o.order_id AND LCASE(cp.code) LIKE '" . $this->db->escape(mb_strtolower($data['filter_coupon_code'], 'UTF-8')) . "')";	
		} else {
			$cpc = '';
		}

		$gvc = '';
		if (!empty($data['filter_voucher_code'])) {
        	$gvc = " AND (SELECT DISTINCT gvh.order_id FROM `" . DB_PREFIX . "voucher` gv, `" . DB_PREFIX . "voucher_history` gvh WHERE gvh.voucher_id = gv.voucher_id AND gvh.order_id = o.order_id AND LCASE(gv.code) LIKE '" . $this->db->escape(mb_strtolower($data['filter_voucher_code'], 'UTF-8')) . "')";	
		} else {
			$gvc = '';
		}
		
		if (isset($data['filter_details']) && $data['filter_details'] != 'all_details') {
			
		if (isset($data['filter_report']) && $data['filter_report'] == 'all_products_with_without_orders') {
			
		$sql = "SELECT p.*, p.product_id AS counter FROM " . DB_PREFIX . "product p, " . DB_PREFIX . "product_description pd WHERE p.product_id = pd.product_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'" . $date . $osi . $tclass . $cat . $manu . $sku . $prod . $mod . $atr . $stat . $loc . $type;

		} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_without_orders') {
			
		$sql = "SELECT p.*, p.product_id AS counter FROM " . DB_PREFIX . "product p, " . DB_PREFIX . "product_description pd WHERE p.product_id = pd.product_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.product_id NOT IN (SELECT product_id FROM `" . DB_PREFIX . "order_product`)" . $date . $tclass . $cat . $manu . $sku . $prod . $mod . $atr . $stat . $loc . $type;
		
		} else {
			
		if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
			$sql = "SELECT *, op.product_id AS counter FROM `" . DB_PREFIX . "order` o INNER JOIN `" . DB_PREFIX . "order_product` op ON (o.order_id = op.order_id)" . $date . $sdate . $osi . $order_id . $store . $cur . $tax . $tclass . $geo_zone . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . $type;
		} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
			$sql = "SELECT *, (SELECT m.name FROM `" . DB_PREFIX . "manufacturer` m, `" . DB_PREFIX . "product` p WHERE op.order_id = o.order_id AND op.product_id = p.product_id AND p.manufacturer_id = m.manufacturer_id) AS counter FROM `" . DB_PREFIX . "order` o INNER JOIN `" . DB_PREFIX . "order_product` op ON (o.order_id = op.order_id)" . $date . $sdate . $osi . $order_id . $store . $cur . $tax . $tclass . $geo_zone . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . $type;
		} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
			$sql = "SELECT *, (SELECT cd.name FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "product_to_category` p2c WHERE op.order_id = o.order_id AND op.product_id = p2c.product_id AND p2c.category_id = cd.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY op.product_id) AS counter FROM `" . DB_PREFIX . "order` o INNER JOIN `" . DB_PREFIX . "order_product` op ON (o.order_id = op.order_id)" . $date . $sdate . $osi . $order_id . $store . $cur . $tax . $tclass . $geo_zone . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . $type;
		} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
			$sql = "SELECT *, op.product_id AS counter FROM `" . DB_PREFIX . "order` o INNER JOIN `" . DB_PREFIX . "order_product` op ON (o.order_id = op.order_id) LEFT JOIN (SELECT oo.order_product_id, GROUP_CONCAT(oo.name, oo.value, oo.type ORDER BY oo.name, oo.value, oo.type) AS options FROM `" . DB_PREFIX . "order_option` oo WHERE (type != 'textarea' OR type != 'file' OR type != 'date' OR type != 'datetime' OR type != 'time') GROUP BY oo.order_product_id) qa ON (op.order_product_id = qa.order_product_id)" . $date . $sdate . $osi . $order_id . $store . $cur . $tax . $tclass . $geo_zone . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . $type;
		}
		
		}
		
		} else {
			
		$sql = "SELECT op.product_id AS counter FROM `" . DB_PREFIX . "order` o INNER JOIN `" . DB_PREFIX . "order_product` op ON (o.order_id = op.order_id)" . $date . $sdate . $osi . $order_id . $store . $cur . $tax . $tclass . $geo_zone . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . $type;
		
		}

		if (isset($data['filter_details']) && $data['filter_details'] != 'all_details') {

		if (isset($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'no_group'; //show No Grouping in Group By default
		}
		
		if (isset($data['filter_report']) && ($data['filter_report'] == 'all_products_with_without_orders' or $data['filter_report'] == 'products_without_orders')) {
		
			$sql .= " GROUP BY counter";

		} else {
		
		switch($group) {
			case 'no_group';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
					$sql .= " GROUP BY counter";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
					$sql .= " GROUP BY counter, options";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
					$sql .= " GROUP BY counter";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
					$sql .= " GROUP BY counter";	
				}
				break;	
			case 'order';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
					$sql .= " GROUP BY o.order_id, counter";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
					$sql .= " GROUP BY o.order_id, counter, options";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
					$sql .= " GROUP BY o.order_id, counter";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
					$sql .= " GROUP BY o.order_id, counter";	
				}			
				break;				
			case 'day';
				if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, DAY(o.date_added) DESC, counter";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, DAY(o.date_added) DESC, counter, options";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, DAY(o.date_added) DESC, counter";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, DAY(o.date_added) DESC, counter";	
				}
				break;
			case 'week':
				if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, WEEK(o.date_added) DESC, counter";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, WEEK(o.date_added) DESC, counter, options";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, WEEK(o.date_added) DESC, counter";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, WEEK(o.date_added) DESC, counter";	
				}
				break;			
			case 'month':
				if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, counter";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, counter, options";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, counter";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, counter";	
				}
				break;
			case 'quarter':
				if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, QUARTER(o.date_added) DESC, counter";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, QUARTER(o.date_added) DESC, counter, options";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, QUARTER(o.date_added) DESC, counter";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, QUARTER(o.date_added) DESC, counter";	
				}
				break;				
			case 'year':
				if (isset($data['filter_report']) && ($data['filter_report'] == 'products_purchased_without_options' or $data['filter_report'] == 'new_products_purchased' or $data['filter_report'] == 'old_products_purchased')) {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, counter";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products_purchased_with_options') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, counter, options";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, counter";
				} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
					$sql .= " GROUP BY YEAR(o.date_added) DESC, counter";	
				}
				break;			
		}
		
		}
		
		}
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}	

	public function getOrderStatuses($data = array()) {
		$query = $this->db->query("SELECT DISTINCT os.name, os.order_status_id FROM `" . DB_PREFIX . "order_status` os WHERE os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY LCASE(os.name) ASC");
		
		return $query->rows;	
	}
	
	public function getOrderStores($data = array()) {
		$query = $this->db->query("SELECT DISTINCT o.store_name, o.store_id FROM `" . DB_PREFIX . "order` o ORDER BY LCASE(o.store_name) ASC");
		
		return $query->rows;	
	}
	
	public function getOrderCurrencies($data = array()) {
		$query = $this->db->query("SELECT DISTINCT cur.currency_id, cur.code, cur.title FROM `" . DB_PREFIX . "currency` cur ORDER BY LCASE(cur.title) ASC");
		
		return $query->rows;	
	}

	public function getOrderTaxes($data = array()) {
		$query = $this->db->query("SELECT DISTINCT ot.title AS tax_title, LCASE(ot.title) AS tax FROM `" . DB_PREFIX . "order_total` ot WHERE ot.code = 'tax' ORDER BY LCASE(ot.title) ASC");
		
		return $query->rows;	
	}

	public function getOrderTaxClasses($data = array()) {
		$query = $this->db->query("SELECT DISTINCT tc.title AS tax_class_title, tc.tax_class_id AS tax_class FROM `" . DB_PREFIX . "tax_class` tc ORDER BY LCASE(tc.title) ASC");
		
		return $query->rows;	
	}
	
	public function getOrderGeoZones($data = array()) {
		$query = $this->db->query("SELECT DISTINCT gz.name AS geo_zone_name, gz.geo_zone_id AS geo_zone_country_id FROM `" . DB_PREFIX . "geo_zone` gz ORDER BY LCASE(gz.name) ASC");
		
		return $query->rows;	
	}
	
	public function getOrderCustomerGroups($data = array()) {
		$query = $this->db->query("SELECT DISTINCT cgd.name, cgd.customer_group_id FROM `" . DB_PREFIX . "customer_group_description` cgd WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY (cgd.name) ASC");
		
		return $query->rows;	
	}
	
	public function getOrderPaymentMethods($data = array()) {
		$query = $this->db->query("SELECT DISTINCT o.payment_method, o.payment_code FROM `" . DB_PREFIX . "order` o WHERE o.order_status_id > 0 AND o.payment_code IS NOT NULL AND o.payment_code != '' GROUP BY o.payment_code ORDER BY LCASE(o.payment_method) ASC");
		
		return $query->rows;	
	}
	
	public function getOrderShippingMethods($data = array()) {
		$query = $this->db->query("SELECT DISTINCT o.shipping_method, o.shipping_code FROM `" . DB_PREFIX . "order` o WHERE o.order_status_id > 0 AND o.shipping_code IS NOT NULL AND o.shipping_code != '' GROUP BY o.shipping_code ORDER BY LCASE(o.shipping_method) ASC");
		
		return $query->rows;	
	}	

	public function getProductsCategories($data = array()) {
		$sql = "SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, c1.parent_id, c1.sort_order FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c1 ON (cp.category_id = c1.category_id) LEFT JOIN " . DB_PREFIX . "category c2 ON (cp.path_id = c2.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (cp.path_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.category_id ORDER BY name";
		
		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getProductManufacturers($manufacturer_id) {
		$product_manufacturer_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
		
		foreach ($query->rows as $result) {
			$product_manufacturer_data[] = $result['manufacturer_id'];
		}

		return $product_manufacturer_data;
	}
	
	public function getProductsManufacturers($data = array()) {
		$query = $this->db->query("SELECT DISTINCT m.name, m.manufacturer_id FROM `" . DB_PREFIX . "manufacturer` m ORDER BY LCASE(m.name) ASC");
		
		return $query->rows;	
	}

	public function getOrderOptions($order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_product_id = '" . (int)$order_product_id . "'");

		return $query->rows;
	}
	
	public function getProductOptions($data = array()) {
		$query = $this->db->query("SELECT DISTINCT LCASE(CONCAT(oo.name,'_',oo.value,'_',oo.type)) AS options, oo.name AS option_name, oo.value AS option_value FROM `" . DB_PREFIX . "order_option` oo WHERE (oo.type = 'radio' OR oo.type = 'checkbox' OR oo.type = 'select' OR oo.type = 'image' OR oo.type = 'colour' OR oo.type = 'size' OR oo.type = 'multiple') GROUP BY oo.name, oo.value, oo.type ORDER BY oo.name, oo.value, oo.type ASC");		

		return $query->rows;
	}

	public function getProductAttributes($data = array()) {
		$query = $this->db->query("SELECT DISTINCT LCASE(CONCAT(agd.name,'_',ad.name,'_',pa.text)) AS attribute_title, CONCAT(agd.name,'&nbsp;&nbsp;&gt;&nbsp;&nbsp;',ad.name,'&nbsp;&nbsp;&gt;&nbsp;&nbsp;',pa.text) AS attribute_name FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.attribute_id = ad.attribute_id AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY agd.name, ad.name, pa.text ORDER BY agd.name, ad.name, pa.text ASC");		

		return $query->rows;
	}

	public function getProductStatuses($data = array()) {
		$query = $this->db->query("SELECT DISTINCT p.status FROM `" . DB_PREFIX . "product` p");

		return $query->rows;
	}
	
	public function getProductLocations($data = array()) {
		$query = $this->db->query("SELECT DISTINCT p.location AS location_name, LCASE(p.location) AS location_title FROM `" . DB_PREFIX . "product` p WHERE p.location != '' ORDER BY LCASE(p.location) ASC");
		
		return $query->rows;	
	}	

	public function getOrderAffiliates($data = array()) {
		$query = $this->db->query("SELECT DISTINCT a.affiliate_id, CONCAT(a.firstname, ' ', a.lastname) AS affiliate_name, a.email AS affiliate_email FROM `" . DB_PREFIX . "affiliate` a ORDER BY LCASE(a.firstname) ASC");
		
		return $query->rows;	
	}	

	public function getOrderCouponNames($data = array()) {
		$query = $this->db->query("SELECT DISTINCT cp.coupon_id, cp.name AS coupon_name FROM `" . DB_PREFIX . "coupon` cp ORDER BY LCASE(cp.code) ASC");
		
		return $query->rows;	
	}	

	public function getCustomerAutocomplete($data = array()) {
		$sql = "SELECT DISTINCT o.customer_id, CONCAT(o.firstname, ' ', o.lastname) AS cust_name, o.email AS cust_email, o.telephone AS cust_telephone, o.payment_company, CONCAT(o.payment_address_1, ', ', o.payment_address_2) AS payment_address, o.payment_city, o.payment_zone, o.payment_postcode, o.payment_country, o.shipping_company, CONCAT(o.shipping_address_1, ', ', o.shipping_address_2) AS shipping_address, o.shipping_city, o.shipping_zone, o.shipping_postcode, o.shipping_country, o.ip AS cust_ip FROM `" . DB_PREFIX . "order` o WHERE o.order_status_id > 0";
		
		if (!empty($data['filter_customer_name'])) {
			$sql .= " AND LCASE(CONCAT(o.firstname, ' ', o.lastname)) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_customer_name'], 'UTF-8')) . "%'";
		}

		if (!empty($data['filter_customer_email'])) {
			$sql .= " AND LCASE(o.email) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_customer_email'], 'UTF-8')) . "%'";			
		}

		if (!empty($data['filter_customer_telephone'])) {
			$sql .= " AND LCASE(o.telephone) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_customer_telephone'], 'UTF-8')) . "%'";			
		}
		
		if (!empty($data['filter_payment_company'])) {
			$sql .= " AND LCASE(o.payment_company) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_company'], 'UTF-8')) . "%'";
		}

		if (!empty($data['filter_payment_address'])) {
			$sql .= " AND LCASE(CONCAT(o.payment_address_1, ', ', o.payment_address_2)) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_address'], 'UTF-8')) . "%'";
		}

		if (!empty($data['filter_payment_city'])) {
			$sql .= " AND LCASE(o.payment_city) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_city'], 'UTF-8')) . "%'";
		}

		if (!empty($data['filter_payment_zone'])) {
			$sql .= " AND LCASE(o.payment_zone) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_zone'], 'UTF-8')) . "%'";
		}

		if (!empty($data['filter_payment_postcode'])) {
			$sql .= " AND LCASE(o.payment_postcode) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_postcode'], 'UTF-8')) . "%'";			
		}

		if (!empty($data['filter_payment_country'])) {
			$sql .= " AND LCASE(o.payment_country) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_payment_country'], 'UTF-8')) . "%'";			
		}
		
		if (!empty($data['filter_shipping_company'])) {
			$sql .= " AND LCASE(o.shipping_company) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_company'], 'UTF-8')) . "%'";
		}

		if (!empty($data['filter_shipping_address'])) {
			$sql .= " AND LCASE(CONCAT(o.shipping_address_1, ', ', o.shipping_address_2)) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_address'], 'UTF-8')) . "%'";
		}

		if (!empty($data['filter_shipping_city'])) {
			$sql .= " AND LCASE(o.shipping_city) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_city'], 'UTF-8')) . "%'";
		}

		if (!empty($data['filter_shipping_zone'])) {
			$sql .= " AND LCASE(o.shipping_zone) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_zone'], 'UTF-8')) . "%'";
		}

		if (!empty($data['filter_shipping_postcode'])) {
			$sql .= " AND LCASE(o.shipping_postcode) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_postcode'], 'UTF-8')) . "%'";			
		}

		if (!empty($data['filter_shipping_country'])) {
			$sql .= " AND LCASE(o.shipping_country) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_shipping_country'], 'UTF-8')) . "%'";			
		}

		if (!empty($data['filter_ip'])) {
        	$sql .= " AND LCASE(o.ip) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_ip'], 'UTF-8')) . "%'";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getProductAutocomplete($data = array()) {
		$sql = "SELECT DISTINCT p.product_id, p.sku AS prod_sku, pd.name AS prod_name, p.model AS prod_model FROM " . DB_PREFIX . "product_description pd, " . DB_PREFIX . "product p WHERE p.product_id = pd.product_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (!empty($data['filter_sku'])) {
        	$sql .= " AND LCASE(p.sku) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_sku'], 'UTF-8')) . "%'";				
		}
		
		if (!empty($data['filter_product_name'])) {
        	$sql .= " AND LCASE(pd.name) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_product_name'], 'UTF-8')) . "%'";				
		}

		if (!empty($data['filter_model'])) {
        	$sql .= " AND LCASE(p.model) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_model'], 'UTF-8')) . "%'";				
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
						
		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getCouponAutocomplete($data = array()) {
		$sql = "SELECT DISTINCT cp.coupon_id, cp.code AS coupon_code FROM `" . DB_PREFIX . "coupon` cp";
		
		if (!empty($data['filter_coupon_code'])) {
        	$sql .= " WHERE LCASE(cp.code) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_coupon_code'], 'UTF-8')) . "%'";
		}	

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
						
		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getVoucherAutocomplete($data = array()) {
		$sql = "SELECT DISTINCT gv.voucher_id, gv.code AS voucher_code FROM `" . DB_PREFIX . "voucher` gv";
		
		if (!empty($data['filter_voucher_code'])) {
        	$sql .= " WHERE LCASE(gv.code) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_voucher_code'], 'UTF-8')) . "%'";
		}	

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
						
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
}
?>