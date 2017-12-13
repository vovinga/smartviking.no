<?php
class ModelReportAdvCustomerProfit extends Model {
	public function getCustomerProfit($data = array()) { 	
		$query = $this->db->query("SET SESSION group_concat_max_len=500000");
		
		$token = $this->session->data['token'];

		if (isset($data['filter_date_start']) && $data['filter_date_start']) {
			$date_start = $data['filter_date_start'];
		} else {
			$date_start = '';
		}

		if (isset($data['filter_date_end']) && $data['filter_date_end']) {
			$date_end = $data['filter_date_end'];
		} else {
			$date_end = '';
		}

		if (isset($data['filter_range'])) {
			$range = $data['filter_range'];
		} else {
			$range = 'current_year'; //show Current Year in Statistics Range by default
		}

		switch($range) 
		{
			case 'custom';
				$date_start = "DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
				$date_end = " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";				
				break;			
			case 'week';
				$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-7 day'))) . "'";
				$date_end = " AND DATE(o.date_added) <= DATE (NOW())";	
				break;
			case 'month';
				$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-30 day'))) . "'";
				$date_end = " AND DATE(o.date_added) <= DATE (NOW())";					
				break;			
			case 'quarter';
				$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-91 day'))) . "'";
				$date_end = " AND DATE(o.date_added) <= DATE (NOW())";						
				break;
			case 'year';
				$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-365 day'))) . "'";
				$date_end = " AND DATE(o.date_added) <= DATE (NOW())";					
				break;
			case 'current_week';
				$date_start = "DATE(o.date_added) >= CURDATE() - WEEKDAY(CURDATE())";
				$date_end = " AND DATE(o.date_added) <= DATE (NOW())";			
				break;	
			case 'current_month';
				$date_start = "YEAR(o.date_added) = YEAR(CURDATE())";
				$date_end = " AND MONTH(o.date_added) = MONTH(CURDATE())";			
				break;
			case 'current_quarter';
				$date_start = "QUARTER(o.date_added) = QUARTER(CURDATE())";
				$date_end = " AND YEAR(o.date_added) = YEAR(CURDATE())";					
				break;					
			case 'current_year';
				$date_start = "DATE(o.date_added) >= CURDATE() - YEAR(CURDATE())";
				$date_end = " AND DATE(o.date_added) <= DATE (NOW())";				
				break;					
			case 'last_week';
				$date_start = "DATE(o.date_added) >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+5 DAY";
				$date_end = " AND DATE(o.date_added) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())-2 DAY";				
				break;	
			case 'last_month';
				$date_start = "DATE(o.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01')";
				$date_end = " AND DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/%m/01')";				
				break;
			case 'last_quarter';
				$date_start = "QUARTER(o.date_added) = QUARTER(DATE_ADD(NOW(), INTERVAL -3 MONTH))";
				$date_end = " AND YEAR(o.date_added) = YEAR(CURDATE())";				
				break;					
			case 'last_year';
				$date_start = "DATE(o.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 YEAR, '%Y/01/01')";
				$date_end = " AND DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/01/01')";				
				break;					
			case 'all_time';
				$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "'";
				$date_end = " AND DATE(o.date_added) <= DATE (NOW())";						
				break;	
		}
		
		$date = ' WHERE (' . $date_start . $date_end . ')';

		$osi = '';
		$sdate = '';
    	if (isset($data['filter_order_status_id']) && is_array($data['filter_order_status_id'])) {
			if ((isset($data['filter_status_date_start']) && $data['filter_status_date_start']) && (isset($data['filter_status_date_end']) && $data['filter_status_date_end'])) {
      			foreach($data['filter_order_status_id'] as $key => $val)
				{				
	        	if (!empty($osi)) $osi .= ' OR ';
    	    	$osi .= " (SELECT DISTINCT oh.order_id FROM `" . DB_PREFIX . "order_history` oh WHERE o.order_id = oh.order_id AND oh.order_status_id = '" . (int)$this->db->escape($key) . "' AND DATE(oh.date_added) >= '" . $this->db->escape($data['filter_status_date_start']) . "' AND DATE(oh.date_added) <= '" . $this->db->escape($data['filter_status_date_end']) . "')";
      			}
				$osi = ' AND (' . $osi . ') ';
			} else {
      			foreach($data['filter_order_status_id'] as $key => $val)
				{				
	        	if (!empty($osi)) $osi .= ' OR ';
    	   		$osi .= 'o.order_status_id = ' . (int)$this->db->escape($key);
      			}
				$osi = ' AND (' . $osi . ') ';
				
				$status_date_start = '';
				$status_date_end = '';
				$sdate = $status_date_start . $status_date_end;				
			}
		} else {
			if (isset($data['filter_status_date_start']) && $data['filter_status_date_start']) {		
				$status_date_start = "AND DATE(o.date_modified) >= '" . $this->db->escape($data['filter_status_date_start']) . "'";
			} else {
				$status_date_start = '';
			}
			if (isset($data['filter_status_date_end']) && $data['filter_status_date_end']) {
				$status_date_end = "AND DATE(o.date_modified) <= '" . $this->db->escape($data['filter_status_date_end']) . "'";	
			} else {
				$status_date_end = '';
			}

			$osi = ' AND o.order_status_id > 0';
			$sdate = $status_date_start . $status_date_end;
		}
			
		$store = '';
    	if (isset($data['filter_store_id']) && is_array($data['filter_store_id'])) {
      		foreach($data['filter_store_id'] as $key => $val)
		{
        if (!empty($store)) $store .= ' OR ';
        $store .= 'o.store_id = ' . (int)$this->db->escape($key);
      	}
		$store = ' AND (' . $store . ') ';
	    }
		
		$cur = '';
    	if (isset($data['filter_currency']) && is_array($data['filter_currency'])) {
      		foreach($data['filter_currency'] as $key => $val)
		{
        if (!empty($cur)) $cur .= ' OR ';
        $cur .= 'o.currency_id = ' . (int)$this->db->escape($key);
      	}
		$cur = ' AND (' . $cur . ') ';
	    }
		
		$tax = '';
    	if (isset($data['filter_taxes']) && is_array($data['filter_taxes'])) {
      		foreach($data['filter_taxes'] as $key => $val)
		{
        if (!empty($tax)) $tax .= ' OR ';
        $tax .= " (SELECT HEX(ot.title) FROM `" . DB_PREFIX . "order_total` ot WHERE o.order_id = ot.order_id AND ot.code = 'tax' AND HEX(ot.title) = '" . $this->db->escape($key) . "')";		
      	}
		$tax = ' AND (' . $tax . ') ';
	    }

		$cgrp = '';
    	if (isset($data['filter_customer_group_id']) && is_array($data['filter_customer_group_id'])) {
      		foreach($data['filter_customer_group_id'] as $key => $val)
		{
        if (!empty($cgrp)) $cgrp .= ' OR ';
        $cgrp .= " ((SELECT c.customer_group_id FROM `" . DB_PREFIX . "customer` c WHERE c.customer_id = o.customer_id AND c.customer_group_id = '" . (int)$this->db->escape($key) . "') OR (o.customer_group_id = '" . (int)$this->db->escape($key) . "' AND o.customer_id = 0))";
      	}
		$cgrp = ' AND (' . $cgrp . ') ';
	    }

		$stat = '';
    	if (isset($data['filter_status']) && is_array($data['filter_status'])) {
      		foreach($data['filter_status'] as $key => $val)
		{
        if (!empty($stat)) $stat .= ' OR ';
        $stat .= " (SELECT DISTINCT c.customer_id FROM `" . DB_PREFIX . "customer` c WHERE c.customer_id = o.customer_id AND c.status = '" . (int)$this->db->escape($key) . "')";
      	}
		$stat = ' AND (' . $stat . ') ';
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
			$ip = " AND (SELECT DISTINCT c.customer_id FROM `" . DB_PREFIX . "customer` c WHERE c.customer_id = o.customer_id AND c.ip LIKE '%" . $this->db->escape($data['filter_ip']) . "%')";			
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
    	if (isset($data['filter_payment_method']) && is_array($data['filter_payment_method'])) {
      		foreach($data['filter_payment_method'] as $key => $val)
		{
        if (!empty($pmeth)) $pmeth .= ' OR ';
        $pmeth .= " HEX(o.payment_method) = '" . $this->db->escape($key) . "'";
      	}
		$pmeth = ' AND (' . $pmeth . ') ';
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
    	if (isset($data['filter_shipping_method']) && is_array($data['filter_shipping_method'])) {
      		foreach($data['filter_shipping_method'] as $key => $val)
		{
        if (!empty($smeth)) $smeth .= ' OR ';
        $smeth .= " HEX(o.shipping_method) = '" . $this->db->escape($key) . "'";
      	}
		$smeth = ' AND (' . $smeth . ') ';
	    }

		$cat = '';
    	if (isset($data['filter_category']) && is_array($data['filter_category'])) {
      		foreach($data['filter_category'] as $key => $val)
		{
        if (!empty($cat)) $cat .= ' OR ';
        $cat .= " (SELECT DISTINCT op.order_id FROM `" . DB_PREFIX . "product_to_category` p2c, `" . DB_PREFIX . "order_product` op WHERE p2c.product_id = op.product_id AND o.order_id = op.order_id AND p2c.category_id = '" . (int)$this->db->escape($key) . "')";
      	}
		$cat = ' AND (' . $cat . ') ';
		} else {
		$cat = '';
		}

		$manu = '';
    	if (isset($data['filter_manufacturer']) && is_array($data['filter_manufacturer'])) {
      		foreach($data['filter_manufacturer'] as $key => $val)
		{
        if (!empty($manu)) $manu .= ' OR ';
        $manu .= " (SELECT DISTINCT op.order_id FROM `" . DB_PREFIX . "product` p, `" . DB_PREFIX . "order_product` op WHERE p.product_id = op.product_id AND o.order_id = op.order_id AND p.manufacturer_id = '" . (int)$this->db->escape($key) . "')";		
      	}
		$manu = ' AND (' . $manu . ') ';
	    }
		
		$sku = '';
		if (!empty($data['filter_sku'])) {
        	$sku = " AND (SELECT DISTINCT op.order_id FROM `" . DB_PREFIX . "product` p, `" . DB_PREFIX . "order_product` op WHERE p.product_id = op.product_id AND o.order_id = op.order_id AND LCASE(p.sku) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_sku'], 'UTF-8')) . "%')";	
		} else {
			$sku = '';
		}
		
		$prod = '';
		if (!empty($data['filter_product_id'])) {
        	$prod = " AND (SELECT DISTINCT op.order_id FROM `" . DB_PREFIX . "order_product` op WHERE o.order_id = op.order_id AND LCASE(op.name) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_product_id'], 'UTF-8')) . "%')";				
		} else {
			$prod = '';
		}
		
		$mod = '';
		if (!empty($data['filter_model'])) {
        	$mod = " AND (SELECT DISTINCT op.order_id FROM `" . DB_PREFIX . "order_product` op WHERE o.order_id = op.order_id AND LCASE(op.model) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_model'], 'UTF-8')) . "%')";		
		} else {
			$mod = '';
		}
		
		$opt = '';
    	if (isset($data['filter_option']) && is_array($data['filter_option'])) {	
      		foreach($data['filter_option'] as $key => $val)
		{
        if (!empty($opt)) $opt .= ' AND ';
        $opt .= " (SELECT DISTINCT op.order_id FROM `" . DB_PREFIX . "order_option` oo, `" . DB_PREFIX . "order_product` op WHERE o.order_id = op.order_id AND oo.order_product_id = op.order_product_id AND HEX(CONCAT(oo.name, oo.value, oo.type)) = '" . $this->db->escape($key) . "' AND LCASE(op.name) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_product_id'], 'UTF-8')) . "%')";
      	}
		$opt = ' AND ' . $opt;	
		}

		$atr = '';
    	if (isset($data['filter_attribute']) && is_array($data['filter_attribute'])) {	
      		foreach($data['filter_attribute'] as $key => $val)
		{
        if (!empty($atr)) $atr .= ' AND ';
        $atr .= " (SELECT DISTINCT op.product_id FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE o.order_id = op.order_id AND pa.product_id = op.product_id AND pa.attribute_id = ad.attribute_id AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND HEX(CONCAT(agd.name, ad.name, pa.text)) = '" . $this->db->escape($key) . "')";		
      	}
		$atr = ' AND ' . $atr;
		}
		
		$loc = '';
    	if (isset($data['filter_location']) && is_array($data['filter_location'])) {
      		foreach($data['filter_location'] as $key => $val)
		{
        if (!empty($loc)) $loc .= ' OR ';
        $loc .= " (SELECT DISTINCT HEX(p.location) FROM `" . DB_PREFIX . "product` p, `" . DB_PREFIX . "order_product` op WHERE p.product_id = op.product_id AND o.order_id = op.order_id AND HEX(p.location) = '" . $this->db->escape($key) . "')";
      	}
		$loc = ' AND (' . $loc . ') ';
	    }

		$affn = '';
    	if (isset($data['filter_affiliate_name']) && is_array($data['filter_affiliate_name'])) {
      		foreach($data['filter_affiliate_name'] as $key => $val)
		{
        if (!empty($affn)) $affn .= ' OR ';
        $affn .= " (SELECT at.affiliate_id FROM `" . DB_PREFIX . "affiliate_transaction` at WHERE at.order_id = o.order_id AND at.affiliate_id = '" . (int)$this->db->escape($key) . "')";
      	}
		$affn = ' AND (' . $affn . ') ';
	    }

		$affe = '';
    	if (isset($data['filter_affiliate_email']) && is_array($data['filter_affiliate_email'])) {
      		foreach($data['filter_affiliate_email'] as $key => $val)
		{
        if (!empty($affe)) $affe .= ' OR ';
        $affe .= " (SELECT at.affiliate_id FROM `" . DB_PREFIX . "affiliate_transaction` at WHERE at.order_id = o.order_id AND at.affiliate_id = '" . (int)$this->db->escape($key) . "')";
      	}
		$affe = ' AND (' . $affe . ') ';
	    }

		$cpn = '';
    	if (isset($data['filter_coupon_name']) && is_array($data['filter_coupon_name'])) {
      		foreach($data['filter_coupon_name'] as $key => $val)
		{
        if (!empty($cpn)) $cpn .= ' OR ';
        $cpn .= " (SELECT cph.coupon_id FROM `" . DB_PREFIX . "coupon_history` cph WHERE cph.order_id = o.order_id AND cph.coupon_id = '" . (int)$this->db->escape($key) . "')";
      	}
		$cpn = ' AND (' . $cpn . ') ';
	    }

		$cpc = '';
    	if (isset($data['filter_coupon_code']) && is_array($data['filter_coupon_code'])) {
      		foreach($data['filter_coupon_code'] as $key => $val)
		{
        if (!empty($cpc)) $cpc .= ' OR ';
        $cpc .= " (SELECT cph.coupon_id FROM `" . DB_PREFIX . "coupon_history` cph WHERE cph.order_id = o.order_id AND cph.coupon_id = '" . (int)$this->db->escape($key) . "')";
      	}
		$cpc = ' AND (' . $cpc . ') ';
	    }

		$gvc = '';
    	if (isset($data['filter_voucher_code']) && is_array($data['filter_voucher_code'])) {
      		foreach($data['filter_voucher_code'] as $key => $val)
		{
        if (!empty($gvc)) $gvc .= ' OR ';
        $gvc .= " (SELECT gvh.voucher_id FROM `" . DB_PREFIX . "voucher_history` gvh WHERE gvh.order_id = o.order_id AND gvh.voucher_id = '" . (int)$this->db->escape($key) . "')";
      	}
		$gvc = ' AND (' . $gvc . ') ';
	    }

		$type = '';
		if (isset($data['filter_types']) && $data['filter_types'] == 1) {
			$type = " AND o.customer_id > 0";
		} elseif (isset($data['filter_types']) && $data['filter_types'] == 0) {
			$type = " AND o.customer_id = 0";
		} elseif (isset($data['filter_types']) && $data['filter_types'] == 3) {
			$type = '';
		}

		$sql = "SELECT o.date_added AS date, 
		YEAR(o.date_added) AS year, 
		QUARTER(o.date_added) AS quarter, 		
		MONTHNAME(o.date_added) AS month, 		
		MIN(o.date_added) AS date_start, 
		MAX(o.date_added) AS date_end,			  
		o.date_added, 
		o.order_id,
		o.invoice_prefix, 
		o.invoice_no, 
		o.customer_id, 
		o.firstname, 
		o.lastname, 
		(SELECT adr.company FROM `" . DB_PREFIX . "address` adr WHERE o.customer_id > 0 AND adr.customer_id = o.customer_id GROUP BY o.customer_id) AS cust_company, 			  
		CONCAT(o.firstname, ' ', o.lastname) AS cust_name, 
		o.customer_group_id,		
		o.email AS cust_email, 
		o.telephone AS cust_telephone, 
		o.payment_country AS cust_country, 		
		(SELECT cgd.name FROM `" . DB_PREFIX . "customer_group_description` cgd, `" . DB_PREFIX . "customer` c WHERE o.customer_id > 0 AND c.customer_id = o.customer_id AND cgd.customer_group_id = c.customer_group_id AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS cust_group_reg, 
		(SELECT cgd.name FROM `" . DB_PREFIX . "customer_group_description` cgd WHERE o.customer_id = 0 AND cgd.customer_group_id = o.customer_group_id AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS cust_group_guest, 	  
		(SELECT c.status FROM `" . DB_PREFIX . "customer` c WHERE o.customer_id = c.customer_id) AS cust_status, 
		(SELECT c.ip FROM `" . DB_PREFIX . "customer` c WHERE o.customer_id = c.customer_id) AS cust_ip, 		
		o.shipping_method, 
		o.payment_method, 
		o.order_status_id, 
		o.store_name, 
		MAX(o.date_added) as mostrecent, 
		COUNT(o.order_id) AS orders, 
		SUM((SELECT SUM(op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)) AS products, 			  
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)) AS sub_total, 
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)) AS handling, 
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)) AS low_order_fee, 
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)) AS shipping, 
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)) AS reward, 
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)) AS coupon, 
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)) AS credit, 
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)) AS voucher, 
		SUM(o.commission) AS commission, 
		SUM(o.payment_cost) AS payment_cost, 
		SUM(o.shipping_cost) AS shipping_cost, 		
		SUM(o.total) AS total, 
		SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)) AS prod_costs, ";

		if (isset($data['filter_details']) && $data['filter_details'] == 1) {
			$sql .= " GROUP_CONCAT('<a href=\"index.php?route=sale/order/info&token=$token&order_id=',o.order_id,'\">',o.order_id,'</a>' ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_ord_id, 
					GROUP_CONCAT(o.order_id ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_ord_idc, 		
					GROUP_CONCAT(DATE_FORMAT(o.date_added, '%e/%m/%Y') ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_order_date, 
					GROUP_CONCAT(IFNULL(o.invoice_prefix,'&nbsp;'),IFNULL(o.invoice_no,'&nbsp;') ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_inv_no, 
					GROUP_CONCAT(CONCAT(o.firstname,' ',o.lastname,IF (o.payment_company = '','',CONCAT(' / ',o.payment_company))) ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_name, 
					GROUP_CONCAT(o.email ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_email, 
					GROUP_CONCAT((SELECT cgd.name FROM `" . DB_PREFIX . "customer_group_description` cgd WHERE cgd.customer_group_id = o.customer_group_id AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "') ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_group, 
					GROUP_CONCAT(IF (o.shipping_method = '','&nbsp;&nbsp;',o.shipping_method) ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_shipping_method, 
					GROUP_CONCAT(IF (o.payment_method = '','&nbsp;&nbsp;',o.payment_method) ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_payment_method, 
					GROUP_CONCAT(IFNULL((SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "'),'&nbsp;&nbsp;') ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_status, 
 					GROUP_CONCAT(o.store_name ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_store, 
					GROUP_CONCAT(o.currency_code ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_currency, 
					GROUP_CONCAT(IFNULL((SELECT SUM(op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id),'&nbsp;&nbsp;') ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_products, 
					GROUP_CONCAT(IFNULL((SELECT ROUND(o.currency_value*SUM(ot.value), 2) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id),0) ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_sub_total, 
					GROUP_CONCAT(IFNULL((SELECT ROUND(o.currency_value*SUM(ot.value), 2) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id),0) ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_shipping, 
					GROUP_CONCAT(IFNULL((SELECT ROUND(o.currency_value*SUM(ot.value), 2) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'tax' GROUP BY ot.order_id),0) ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_tax, 
					GROUP_CONCAT(ROUND(o.currency_value*o.total, 2) ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_value, 
					GROUP_CONCAT(ROUND(o.currency_value*(IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id),0)";
					if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   						$sql .= "+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id),0)";
					}
					$sql .= "), 2) ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_sales, 
					GROUP_CONCAT(ROUND(o.currency_value*(IFNULL((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id),0)+o.commission";
					if ($this->config->get('adv_profit_reports_formula_sop2')) {																																																																																																																																																																																																																																												   						$sql .= "+o.shipping_cost";
					}
					if ($this->config->get('adv_profit_reports_formula_sop3')) {		
						$sql .= "+o.payment_cost";
					}
					$sql .= "), 2) ORDER BY o.order_id DESC SEPARATOR '<br>-') AS order_costs, 
					GROUP_CONCAT(ROUND(o.currency_value*((IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id),0)";
					if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   						$sql .= "+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id),0)";
					}
					$sql .= ")";					
					$sql .= "-(IFNULL((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id),0)+o.commission";
					if ($this->config->get('adv_profit_reports_formula_sop2')) {																																																																																																																																																																																																																																												   						$sql .= "+o.shipping_cost";
					}
					if ($this->config->get('adv_profit_reports_formula_sop3')) {	
						$sql .= "+o.payment_cost";
					}
					$sql .= ")), 2) ORDER BY o.order_id DESC SEPARATOR '<br>') AS order_profit, 
					GROUP_CONCAT(IFNULL(ROUND(100*(((IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id),0)";
					if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   						$sql .= "+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id),0)";
					}
					$sql .= ")";					
					$sql .= "-(IFNULL((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id),0)+o.commission";
					if ($this->config->get('adv_profit_reports_formula_sop2')) {																																																																																																																																																																																																																																												   						$sql .= "+o.shipping_cost";
					}
					if ($this->config->get('adv_profit_reports_formula_sop3')) {	
						$sql .= "+o.payment_cost";
					}
					$sql .= ")) / (IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id),0)+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id),0)";
					if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   						$sql .= "+IFNULL((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id),0)";
					}
					$sql .= ")), 2),0) ORDER BY o.order_id DESC SEPARATOR '%<br>') AS order_profit_margin_percent, ";

		} elseif (isset($data['filter_details']) && $data['filter_details'] == 2) {
			$sql .= " GROUP_CONCAT((SELECT GROUP_CONCAT('<a href=\"index.php?route=sale/order/info&token=$token&order_id=',op.order_id,'\">',op.order_id,'</a>' SEPARATOR '<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_ord_id, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(op.order_id SEPARATOR '<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_ord_idc, 
					GROUP_CONCAT((SELECT GROUP_CONCAT((SELECT DATE_FORMAT(o.date_added, '%e/%m/%Y') FROM `" . DB_PREFIX . "order` o WHERE op.order_id = o.order_id) SEPARATOR '<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_order_date,  
					GROUP_CONCAT((SELECT GROUP_CONCAT(IFNULL((SELECT o.invoice_prefix FROM `" . DB_PREFIX . "order` o WHERE op.order_id = o.order_id),'&nbsp;'),IFNULL((SELECT o.invoice_no FROM `" . DB_PREFIX . "order` o WHERE op.order_id = o.order_id),'&nbsp;') SEPARATOR '&nbsp;<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_inv_no, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(IFNULL((SELECT CONCAT('<a href=\"index.php?route=catalog/product/update&token=$token&product_id=',op.product_id,'\">',op.product_id,'</a>') FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id),op.product_id) SEPARATOR '<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_pid, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(op.product_id SEPARATOR '<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_pidc, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(IFNULL((SELECT p.sku FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id),'&nbsp;') SEPARATOR '&nbsp;<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_sku, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(op.model SEPARATOR '<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_model, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(op.name SEPARATOR '<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_name, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(IFNULL((SELECT GROUP_CONCAT(CONCAT(oo.name,': ',oo.value) SEPARATOR '; ') FROM `" . DB_PREFIX . "order_option` oo WHERE op.order_product_id = oo.order_product_id AND (oo.type = 'radio' OR oo.type = 'checkbox' OR oo.type = 'select' OR oo.type = 'color') ORDER BY op.order_product_id),'&nbsp;') SEPARATOR '&nbsp;<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_option, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(IFNULL((SELECT GROUP_CONCAT(CONCAT(agd.name,'" . $this->language->get('text_separator') . "',ad.name,'" . $this->language->get('text_separator') . "',pa.text) SEPARATOR '; ') FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.product_id = op.product_id AND pa.attribute_id = ad.attribute_id AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY agd.name, ad.name, pa.text ASC),'&nbsp;') SEPARATOR '&nbsp;<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_attributes, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(IFNULL((SELECT m.name FROM `" . DB_PREFIX . "product` p, `" . DB_PREFIX . "manufacturer` m WHERE op.product_id = p.product_id AND p.manufacturer_id = m.manufacturer_id),'&nbsp;') SEPARATOR '&nbsp;<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_manu, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(IFNULL((SELECT GROUP_CONCAT(cd.name SEPARATOR ', ') FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "category` c, `" . DB_PREFIX . "product_to_category` p2c WHERE op.product_id = p2c.product_id AND p2c.category_id = c.category_id AND (c.category_id = cd.category_id OR c.parent_id = cd.category_id) AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.status > 0),'&nbsp;') SEPARATOR '&nbsp;<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_category, 
					GROUP_CONCAT((SELECT GROUP_CONCAT((SELECT o.currency_code FROM `" . DB_PREFIX . "order` o WHERE op.order_id = o.order_id) SEPARATOR '<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_currency, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(ROUND(o.currency_value*op.price, 2) SEPARATOR '<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_price, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(op.quantity SEPARATOR '<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_quantity, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(ROUND(o.currency_value*op.tax*op.quantity, 2) SEPARATOR '<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_tax, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(ROUND(o.currency_value*op.total, 2) SEPARATOR '<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_total, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(ROUND(o.currency_value*op.cost*op.quantity, 2) SEPARATOR '<br>-') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>-') AS product_costs, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(ROUND(o.currency_value*(op.total - (op.cost*op.quantity)), 2) SEPARATOR '<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '<br>') AS product_profit, 
					GROUP_CONCAT((SELECT GROUP_CONCAT(IFNULL(ROUND(100*(op.total - (op.cost*op.quantity)) / op.total, 2),0) SEPARATOR '%<br>') FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id ORDER BY op.order_product_id) ORDER BY o.order_id DESC SEPARATOR '%<br>') AS product_profit_margin_percent, ";
					
		} elseif (isset($data['filter_details']) && $data['filter_details'] == 3) {
			$sql .= " (IF ((CONCAT(o.payment_firstname,o.payment_lastname) = ''),'&nbsp;&nbsp;',(CONCAT(o.payment_firstname,' ',o.payment_lastname)))) AS billing_name, 
					(IF (o.payment_company = '','&nbsp;&nbsp;',o.payment_company)) AS billing_company, 
					(IF (o.payment_address_1 = '','&nbsp;&nbsp;',o.payment_address_1)) AS billing_address_1, 
					(IF (o.payment_address_2 = '','&nbsp;&nbsp;',o.payment_address_2)) AS billing_address_2, 
					(IF (o.payment_city = '','&nbsp;&nbsp;',o.payment_city)) AS billing_city, 
					(IF (o.payment_zone = '','&nbsp;&nbsp;',o.payment_zone)) AS billing_zone, 
					(IF (o.payment_postcode = '','&nbsp;&nbsp;',o.payment_postcode)) AS billing_postcode, 
					(IF (o.payment_country = '','&nbsp;&nbsp;',o.payment_country)) AS billing_country, 
					(IF ((CONCAT(o.shipping_firstname,o.shipping_lastname) = ''),'&nbsp;&nbsp;',(CONCAT(o.shipping_firstname,' ',o.shipping_lastname)))) AS shipping_name, 
					(IF (o.shipping_company = '','&nbsp;&nbsp;',o.shipping_company)) AS shipping_company, 
					(IF (o.shipping_address_1 = '','&nbsp;&nbsp;',o.shipping_address_1)) AS shipping_address_1, 
					(IF (o.shipping_address_2 = '','&nbsp;&nbsp;',o.shipping_address_2)) AS shipping_address_2, 
					(IF (o.shipping_city = '','&nbsp;&nbsp;',o.shipping_city)) AS shipping_city, 
					(IF (o.shipping_zone = '','&nbsp;&nbsp;',o.shipping_zone)) AS shipping_zone, 			
					(IF (o.shipping_postcode = '','&nbsp;&nbsp;',o.shipping_postcode)) AS shipping_postcode, 
					(IF (o.shipping_country = '','&nbsp;&nbsp;',o.shipping_country)) AS shipping_country, ";					
		}
		
		$sql .= " (SELECT COUNT(o.order_id) FROM `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type . ") AS orders_total, 
		(SELECT SUM(op.quantity) FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type . " AND op.order_id = o.order_id) AS products_total, 
		(SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot, `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type . " AND ot.order_id = o.order_id AND ot.code = 'sub_total') AS sub_total_total, 
		(SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot, `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type . " AND ot.order_id = o.order_id AND ot.code = 'handling') AS handling_total, 	
		(SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot, `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type . " AND ot.order_id = o.order_id AND ot.code = 'low_order_fee') AS low_order_fee_total, 	
		(SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot, `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type . " AND ot.order_id = o.order_id AND ot.code = 'shipping') AS shipping_total, 
		(SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot, `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type . " AND ot.order_id = o.order_id AND ot.code = 'reward') AS reward_total, 	
		(SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot, `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type . " AND ot.order_id = o.order_id AND ot.code = 'coupon') AS coupon_total, 
		(SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot, `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type . " AND ot.order_id = o.order_id AND ot.code = 'credit') AS credit_total, 	
		(SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot, `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type . " AND ot.order_id = o.order_id AND ot.code = 'voucher') AS voucher_total, 	
		(SELECT SUM(o.commission) FROM `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type . ") AS commission_total, 
		(SELECT SUM(o.total) FROM `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type . ") AS value_total, 
		(SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type . " AND op.order_id = o.order_id) AS prod_costs_total, 
		(SELECT SUM(o.payment_cost) FROM `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type . ") AS pay_costs_total, 
		(SELECT SUM(o.shipping_cost) FROM `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type . ") AS ship_costs_total 
		
		FROM `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type;

		if (isset($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'no_group'; //show No Grouping in Group By default
		}
		
		switch($group) {
			case 'no_group';
				$sql .= " GROUP BY CONCAT(o.firstname, ' ', o.lastname)";
				break;	
			case 'order';
				$sql .= " GROUP BY o.order_id, CONCAT(o.firstname, ' ', o.lastname)";
				break;				
			case 'day';
				$sql .= " GROUP BY YEAR(o.date_added) DESC, DAY(o.date_added) DESC, CONCAT(o.firstname, ' ', o.lastname)";
				break;
			case 'week':
				$sql .= " GROUP BY YEAR(o.date_added) DESC, WEEK(o.date_added) DESC, CONCAT(o.firstname, ' ', o.lastname)";
				break;			
			case 'month':
				$sql .= " GROUP BY YEAR(o.date_added) DESC, MONTH(o.date_added) DESC, CONCAT(o.firstname, ' ', o.lastname)";
				break;
			case 'quarter':
				$sql .= " GROUP BY YEAR(o.date_added) DESC, QUARTER(o.date_added) DESC, CONCAT(o.firstname, ' ', o.lastname)";
				break;				
			case 'year':
				$sql .= " GROUP BY YEAR(o.date_added) DESC, CONCAT(o.firstname, ' ', o.lastname)";
				break;			
		}

		if (isset($data['filter_sort']) && $data['filter_sort'] == 'date') {
			$sql .= " ORDER BY date_end DESC, orders DESC ";
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'customer_id') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY customer_id ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY customer_id ASC, order_id DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, customer_id ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, customer_id ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, customer_id ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, customer_id ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, customer_id ASC ";
			}	
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'cust_name') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(cust_name) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(cust_name) ASC, order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, LCASE(cust_name) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(cust_name) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(cust_name) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(cust_name) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(cust_name) ASC ";
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'cust_company') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(cust_company) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(cust_company) ASC, order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, LCASE(cust_company) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(cust_company) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(cust_company) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(cust_company) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(cust_company) ASC ";
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'cust_email') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(cust_email) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(cust_email) ASC, order_id DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, LCASE(cust_email) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(cust_email) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(cust_email) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(cust_email) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(cust_email) ASC ";
			}	
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'cust_telephone') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(cust_telephone) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(cust_telephone) ASC, order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, LCASE(cust_telephone) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(cust_telephone) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(cust_telephone) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(cust_telephone) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(cust_telephone) ASC ";
			}	
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'cust_country') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(cust_country) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(cust_country) ASC, order_id DESC ";					
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, LCASE(cust_country) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(cust_country) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(cust_country) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(cust_country) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(cust_country) ASC ";
			}				
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'cust_group_reg') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(cust_group_reg) ASC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(cust_group_reg) ASC, order_id DESC ";					
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, LCASE(cust_group_reg) ASC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(cust_group_reg) ASC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(cust_group_reg) ASC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(cust_group_reg) ASC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(cust_group_reg) ASC, total DESC ";
			}				
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'cust_status') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(cust_status) DESC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(cust_status) ASC, order_id DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, LCASE(cust_status) DESC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(cust_status) DESC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(cust_status) DESC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(cust_status) DESC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(cust_status) DESC, orders DESC ";
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'cust_ip') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY LCASE(cust_ip) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY LCASE(cust_ip) ASC, order_id DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, LCASE(cust_ip) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(cust_ip) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(cust_ip) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(cust_ip) ASC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, LCASE(cust_ip) ASC ";
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'mostrecent') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY mostrecent DESC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY mostrecent DESC, order_id DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, mostrecent DESC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, mostrecent DESC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, mostrecent DESC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, mostrecent DESC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, mostrecent DESC, orders DESC ";
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'orders') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY orders DESC, total DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY order_id DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, orders DESC, total DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, orders DESC, total DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, orders DESC, total DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, orders DESC, total DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, orders DESC, total DESC ";
			}		
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'products') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY products DESC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY products DESC, orders DESC, order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, products DESC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, products DESC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, products DESC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, products DESC, orders DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, products DESC, orders DESC ";
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'total') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY total DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY total DESC, order_id DESC ";					
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, total DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, total DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, total DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, total DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, total DESC ";
			}			
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'sales') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY (IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_cop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ") DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY (IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_cop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ") DESC, order_id DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {					
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, (IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_cop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ") DESC ";					
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, (IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_cop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ") DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, (IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_cop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ") DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, (IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_cop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ") DESC ";	
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {
				$sql .= " ORDER BY YEAR(date) DESC, (IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_cop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ") DESC ";			
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'costs') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY (IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_cop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_cop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ") DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY (IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_cop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_cop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ") DESC, order_id DESC ";			
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, (IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_cop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_cop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ") DESC ";			
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, (IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_cop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_cop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ") DESC ";	
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, (IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_cop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_cop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ") DESC ";	
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, (IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_cop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_cop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ") DESC ";	
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {
				$sql .= " ORDER BY YEAR(date) DESC, (IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_cop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_cop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ") DESC ";				
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'profit') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY ((IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_cop1')) {
					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")";			
				$sql .= "-(IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_cop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_cop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ")) DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY ((IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_cop1')) {
					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")";			
				$sql .= "-(IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_cop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_cop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ")) DESC, order_id DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, ((IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_cop1')) {
					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")";			
				$sql .= "-(IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_cop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_cop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ")) DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, ((IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_cop1')) {
					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")";			
				$sql .= "-(IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_cop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_cop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ")) DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, ((IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_cop1')) {
					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")";			
				$sql .= "-(IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_cop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_cop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ")) DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, ((IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_cop1')) {
					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")";			
				$sql .= "-(IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_cop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_cop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ")) DESC ";			
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, ((IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_cop1')) {
					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")";			
				$sql .= "-(IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_cop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_cop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ")) DESC ";	
			}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'profit_margin') {
			if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
				$sql .= " ORDER BY 100*(((IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")";
				$sql .= "-(IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_sop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_sop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ")) / (IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")) DESC ";
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
				$sql .= " ORDER BY 100*(((IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")";
				$sql .= "-(IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_sop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_sop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ")) / (IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")) DESC, order_id DESC ";			
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
				$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, 100*(((IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")";
				$sql .= "-(IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_sop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_sop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ")) / (IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")) DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {
				$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, 100*(((IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")";
				$sql .= "-(IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_sop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_sop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ")) / (IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")) DESC ";				
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {
				$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, 100*(((IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")";
				$sql .= "-(IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_sop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_sop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ")) / (IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")) DESC ";	
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
				$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, 100*(((IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")";
				$sql .= "-(IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_sop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_sop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ")) / (IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")) DESC ";		
			} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
				$sql .= " ORDER BY YEAR(date) DESC, 100*(((IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")";
				$sql .= "-(IFNULL(SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)),0)+SUM(o.commission)";
				if ($this->config->get('adv_profit_reports_formula_sop2')) {																																																																																																																																																																																																																																												   					$sql .= "+SUM(o.shipping_cost)";
				}
				if ($this->config->get('adv_profit_reports_formula_sop3')) {	
					$sql .= "+SUM(o.payment_cost)";
				}
				$sql .= ")) / (IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)),0)+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)),0)";
				if ($this->config->get('adv_profit_reports_formula_sop1')) {																																																																																																																																																																																																																																												   					$sql .= "+IFNULL(SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)),0)";
				}
				$sql .= ")) DESC ";	
			}			
		} else {
			$sql .= " ORDER BY orders DESC, total DESC ";
		}
				
		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getCustomerSaleChart($data = array()) {
		if (isset($data['filter_date_start']) && $data['filter_date_start']) {
			$date_start = $data['filter_date_start'];
		} else {
			$date_start = '';
		}

		if (isset($data['filter_date_end']) && $data['filter_date_end']) {
			$date_end = $data['filter_date_end'];
		} else {
			$date_end = '';
		}

		if (isset($data['filter_range'])) {
			$range = $data['filter_range'];
		} else {
			$range = 'current_year'; //show Current Year in Statistics Range by default
		}

		switch($range) 
		{
			case 'custom';
				$date_start = "DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
				$date_end = " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";				
				break;			
			case 'week';
				$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-7 day'))) . "'";
				$date_end = " AND DATE(o.date_added) <= DATE (NOW())";	
				break;
			case 'month';
				$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-30 day'))) . "'";
				$date_end = " AND DATE(o.date_added) <= DATE (NOW())";					
				break;			
			case 'quarter';
				$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-91 day'))) . "'";
				$date_end = " AND DATE(o.date_added) <= DATE (NOW())";						
				break;
			case 'year';
				$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d', strtotime('-365 day'))) . "'";
				$date_end = " AND DATE(o.date_added) <= DATE (NOW())";					
				break;
			case 'current_week';
				$date_start = "DATE(o.date_added) >= CURDATE() - WEEKDAY(CURDATE())";
				$date_end = " AND DATE(o.date_added) <= DATE (NOW())";			
				break;	
			case 'current_month';
				$date_start = "YEAR(o.date_added) = YEAR(CURDATE())";
				$date_end = " AND MONTH(o.date_added) = MONTH(CURDATE())";			
				break;
			case 'current_quarter';
				$date_start = "QUARTER(o.date_added) = QUARTER(CURDATE())";
				$date_end = " AND YEAR(o.date_added) = YEAR(CURDATE())";					
				break;					
			case 'current_year';
				$date_start = "DATE(o.date_added) >= CURDATE() - YEAR(CURDATE())";
				$date_end = " AND DATE(o.date_added) <= DATE (NOW())";				
				break;					
			case 'last_week';
				$date_start = "DATE(o.date_added) >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE())+5 DAY";
				$date_end = " AND DATE(o.date_added) < CURDATE() - INTERVAL DAYOFWEEK(CURDATE())-2 DAY";				
				break;	
			case 'last_month';
				$date_start = "DATE(o.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y/%m/01')";
				$date_end = " AND DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/%m/01')";				
				break;
			case 'last_quarter';
				$date_start = "QUARTER(o.date_added) = QUARTER(DATE_ADD(NOW(), INTERVAL -3 MONTH))";
				$date_end = " AND YEAR(o.date_added) = YEAR(CURDATE())";				
				break;					
			case 'last_year';
				$date_start = "DATE(o.date_added) >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 YEAR, '%Y/01/01')";
				$date_end = " AND DATE(o.date_added) < DATE_FORMAT(CURRENT_DATE, '%Y/01/01')";				
				break;					
			case 'all_time';
				$date_start = "DATE(o.date_added) >= '" . $this->db->escape(date('Y-m-d','0')) . "'";
				$date_end = " AND DATE(o.date_added) <= DATE (NOW())";						
				break;	
		}
		
		$date = ' WHERE (' . $date_start . $date_end . ')';

		if (isset($data['filter_status_date_start']) && $data['filter_status_date_start']) {		
			$status_date_start = "AND (SELECT DISTINCT oh.order_id FROM `" . DB_PREFIX . "order_history` oh WHERE o.order_id = oh.order_id AND DATE(oh.date_added) >= '" . $this->db->escape($data['filter_status_date_start']) . "')";
		} else {
			$status_date_start = '';
		}

		if (isset($data['filter_status_date_end']) && $data['filter_status_date_end']) {
			$status_date_end = "AND (SELECT DISTINCT oh.order_id FROM `" . DB_PREFIX . "order_history` oh WHERE o.order_id = oh.order_id AND DATE(oh.date_added) <= '" . $this->db->escape($data['filter_status_date_end']) . "')";
		} else {
			$status_date_end = '';
		}

		$sdate = $status_date_start . $status_date_end;
		
		$osi = '';
    	if (isset($data['filter_order_status_id']) && is_array($data['filter_order_status_id'])) {
			if ((isset($data['filter_status_date_start']) && $data['filter_status_date_start']) && (isset($data['filter_status_date_end']) && $data['filter_status_date_end'])) {
      			foreach($data['filter_order_status_id'] as $key => $val)
				{				
	        	if (!empty($osi)) $osi .= ' OR ';
    	    	$osi .= " (SELECT DISTINCT oh.order_id FROM `" . DB_PREFIX . "order_history` oh WHERE o.order_id = oh.order_id AND oh.order_status_id = '" . (int)$this->db->escape($key) . "')";
      			}
				$osi = ' AND (' . $osi . ') ';
			} else {
      			foreach($data['filter_order_status_id'] as $key => $val)
				{				
	        	if (!empty($osi)) $osi .= ' OR ';
    	   		$osi .= 'o.order_status_id = ' . (int)$this->db->escape($key);
      			}
				$osi = ' AND (' . $osi . ') ';
			}
		} else {
			if ((isset($data['filter_status_date_start']) && $data['filter_status_date_start']) && (isset($data['filter_status_date_end']) && $data['filter_status_date_end'])) {
				$osi = " AND (SELECT DISTINCT oh.order_id FROM `" . DB_PREFIX . "order_history` oh WHERE o.order_id = oh.order_id AND oh.order_status_id > 0)";
			} else {
				$osi = ' AND o.order_status_id > 0';
			}
		}
			
		$store = '';
    	if (isset($data['filter_store_id']) && is_array($data['filter_store_id'])) {
      		foreach($data['filter_store_id'] as $key => $val)
		{
        if (!empty($store)) $store .= ' OR ';
        $store .= 'o.store_id = ' . (int)$this->db->escape($key);
      	}
		$store = ' AND (' . $store . ') ';
	    }
		
		$cur = '';
    	if (isset($data['filter_currency']) && is_array($data['filter_currency'])) {
      		foreach($data['filter_currency'] as $key => $val)
		{
        if (!empty($cur)) $cur .= ' OR ';
        $cur .= 'o.currency_id = ' . (int)$this->db->escape($key);
      	}
		$cur = ' AND (' . $cur . ') ';
	    }
		
		$tax = '';
    	if (isset($data['filter_taxes']) && is_array($data['filter_taxes'])) {
      		foreach($data['filter_taxes'] as $key => $val)
		{
        if (!empty($tax)) $tax .= ' OR ';
        $tax .= " (SELECT HEX(ot.title) FROM `" . DB_PREFIX . "order_total` ot WHERE o.order_id = ot.order_id AND ot.code = 'tax' AND HEX(ot.title) = '" . $this->db->escape($key) . "')";		
      	}
		$tax = ' AND (' . $tax . ') ';
	    }

		$cgrp = '';
    	if (isset($data['filter_customer_group_id']) && is_array($data['filter_customer_group_id'])) {
      		foreach($data['filter_customer_group_id'] as $key => $val)
		{
        if (!empty($cgrp)) $cgrp .= ' OR ';
        $cgrp .= " ((SELECT c.customer_group_id FROM `" . DB_PREFIX . "customer` c WHERE c.customer_id = o.customer_id AND c.customer_group_id = '" . (int)$this->db->escape($key) . "') OR (o.customer_group_id = '" . (int)$this->db->escape($key) . "' AND o.customer_id = 0))";
      	}
		$cgrp = ' AND (' . $cgrp . ') ';
	    }

		$stat = '';
    	if (isset($data['filter_status']) && is_array($data['filter_status'])) {
      		foreach($data['filter_status'] as $key => $val)
		{
        if (!empty($stat)) $stat .= ' OR ';
        $stat .= " (SELECT DISTINCT c.customer_id FROM `" . DB_PREFIX . "customer` c WHERE c.customer_id = o.customer_id AND c.status = '" . (int)$this->db->escape($key) . "')";
      	}
		$stat = ' AND (' . $stat . ') ';
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
			$ip = " AND (SELECT DISTINCT c.customer_id FROM `" . DB_PREFIX . "customer` c WHERE c.customer_id = o.customer_id AND c.ip LIKE '%" . $this->db->escape($data['filter_ip']) . "%')";			
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
    	if (isset($data['filter_payment_method']) && is_array($data['filter_payment_method'])) {
      		foreach($data['filter_payment_method'] as $key => $val)
		{
        if (!empty($pmeth)) $pmeth .= ' OR ';
        $pmeth .= " HEX(o.payment_method) = '" . $this->db->escape($key) . "'";
      	}
		$pmeth = ' AND (' . $pmeth . ') ';
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
    	if (isset($data['filter_shipping_method']) && is_array($data['filter_shipping_method'])) {
      		foreach($data['filter_shipping_method'] as $key => $val)
		{
        if (!empty($smeth)) $smeth .= ' OR ';
        $smeth .= " HEX(o.shipping_method) = '" . $this->db->escape($key) . "'";
      	}
		$smeth = ' AND (' . $smeth . ') ';
	    }

		$cat = '';
    	if (isset($data['filter_category']) && is_array($data['filter_category'])) {
      		foreach($data['filter_category'] as $key => $val)
		{
        if (!empty($cat)) $cat .= ' OR ';
        $cat .= " (SELECT DISTINCT op.order_id FROM `" . DB_PREFIX . "product_to_category` p2c, `" . DB_PREFIX . "order_product` op WHERE p2c.product_id = op.product_id AND o.order_id = op.order_id AND p2c.category_id = '" . (int)$this->db->escape($key) . "')";
      	}
		$cat = ' AND (' . $cat . ') ';
		} else {
		$cat = '';
		}

		$manu = '';
    	if (isset($data['filter_manufacturer']) && is_array($data['filter_manufacturer'])) {
      		foreach($data['filter_manufacturer'] as $key => $val)
		{
        if (!empty($manu)) $manu .= ' OR ';
        $manu .= " (SELECT DISTINCT op.order_id FROM `" . DB_PREFIX . "product` p, `" . DB_PREFIX . "order_product` op WHERE p.product_id = op.product_id AND o.order_id = op.order_id AND p.manufacturer_id = '" . (int)$this->db->escape($key) . "')";		
      	}
		$manu = ' AND (' . $manu . ') ';
	    }
		
		$sku = '';
		if (!empty($data['filter_sku'])) {
        	$sku = " AND (SELECT DISTINCT op.order_id FROM `" . DB_PREFIX . "product` p, `" . DB_PREFIX . "order_product` op WHERE p.product_id = op.product_id AND o.order_id = op.order_id AND LCASE(p.sku) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_sku'], 'UTF-8')) . "%')";	
		} else {
			$sku = '';
		}
		
		$prod = '';
		if (!empty($data['filter_product_id'])) {
        	$prod = " AND (SELECT DISTINCT op.order_id FROM `" . DB_PREFIX . "order_product` op WHERE o.order_id = op.order_id AND LCASE(op.name) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_product_id'], 'UTF-8')) . "%')";				
		} else {
			$prod = '';
		}
		
		$mod = '';
		if (!empty($data['filter_model'])) {
        	$mod = " AND (SELECT DISTINCT op.order_id FROM `" . DB_PREFIX . "order_product` op WHERE o.order_id = op.order_id AND LCASE(op.model) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_model'], 'UTF-8')) . "%')";		
		} else {
			$mod = '';
		}
		
		$opt = '';
    	if (isset($data['filter_option']) && is_array($data['filter_option'])) {	
      		foreach($data['filter_option'] as $key => $val)
		{
        if (!empty($opt)) $opt .= ' AND ';
        $opt .= " (SELECT DISTINCT op.order_id FROM `" . DB_PREFIX . "order_option` oo, `" . DB_PREFIX . "order_product` op WHERE o.order_id = op.order_id AND oo.order_product_id = op.order_product_id AND HEX(CONCAT(oo.name, oo.value, oo.type)) = '" . $this->db->escape($key) . "' AND LCASE(op.name) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_product_id'], 'UTF-8')) . "%')";
      	}
		$opt = ' AND ' . $opt;	
		}

		$atr = '';
    	if (isset($data['filter_attribute']) && is_array($data['filter_attribute'])) {	
      		foreach($data['filter_attribute'] as $key => $val)
		{
        if (!empty($atr)) $atr .= ' AND ';
        $atr .= " (SELECT DISTINCT op.product_id FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE o.order_id = op.order_id AND pa.product_id = op.product_id AND pa.attribute_id = ad.attribute_id AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND HEX(CONCAT(agd.name, ad.name, pa.text)) = '" . $this->db->escape($key) . "')";		
      	}
		$atr = ' AND ' . $atr;
		}
		
		$loc = '';
    	if (isset($data['filter_location']) && is_array($data['filter_location'])) {
      		foreach($data['filter_location'] as $key => $val)
		{
        if (!empty($loc)) $loc .= ' OR ';
        $loc .= " (SELECT DISTINCT HEX(p.location) FROM `" . DB_PREFIX . "product` p, `" . DB_PREFIX . "order_product` op WHERE p.product_id = op.product_id AND o.order_id = op.order_id AND HEX(p.location) = '" . $this->db->escape($key) . "')";
      	}
		$loc = ' AND (' . $loc . ') ';
	    }

		$affn = '';
    	if (isset($data['filter_affiliate_name']) && is_array($data['filter_affiliate_name'])) {
      		foreach($data['filter_affiliate_name'] as $key => $val)
		{
        if (!empty($affn)) $affn .= ' OR ';
        $affn .= " (SELECT at.affiliate_id FROM `" . DB_PREFIX . "affiliate_transaction` at WHERE at.order_id = o.order_id AND at.affiliate_id = '" . (int)$this->db->escape($key) . "')";
      	}
		$affn = ' AND (' . $affn . ') ';
	    }

		$affe = '';
    	if (isset($data['filter_affiliate_email']) && is_array($data['filter_affiliate_email'])) {
      		foreach($data['filter_affiliate_email'] as $key => $val)
		{
        if (!empty($affe)) $affe .= ' OR ';
        $affe .= " (SELECT at.affiliate_id FROM `" . DB_PREFIX . "affiliate_transaction` at WHERE at.order_id = o.order_id AND at.affiliate_id = '" . (int)$this->db->escape($key) . "')";
      	}
		$affe = ' AND (' . $affe . ') ';
	    }

		$cpn = '';
    	if (isset($data['filter_coupon_name']) && is_array($data['filter_coupon_name'])) {
      		foreach($data['filter_coupon_name'] as $key => $val)
		{
        if (!empty($cpn)) $cpn .= ' OR ';
        $cpn .= " (SELECT cph.coupon_id FROM `" . DB_PREFIX . "coupon_history` cph WHERE cph.order_id = o.order_id AND cph.coupon_id = '" . (int)$this->db->escape($key) . "')";
      	}
		$cpn = ' AND (' . $cpn . ') ';
	    }

		$cpc = '';
    	if (isset($data['filter_coupon_code']) && is_array($data['filter_coupon_code'])) {
      		foreach($data['filter_coupon_code'] as $key => $val)
		{
        if (!empty($cpc)) $cpc .= ' OR ';
        $cpc .= " (SELECT cph.coupon_id FROM `" . DB_PREFIX . "coupon_history` cph WHERE cph.order_id = o.order_id AND cph.coupon_id = '" . (int)$this->db->escape($key) . "')";
      	}
		$cpc = ' AND (' . $cpc . ') ';
	    }

		$gvc = '';
    	if (isset($data['filter_voucher_code']) && is_array($data['filter_voucher_code'])) {
      		foreach($data['filter_voucher_code'] as $key => $val)
		{
        if (!empty($gvc)) $gvc .= ' OR ';
        $gvc .= " (SELECT gvh.voucher_id FROM `" . DB_PREFIX . "voucher_history` gvh WHERE gvh.order_id = o.order_id AND gvh.voucher_id = '" . (int)$this->db->escape($key) . "')";
      	}
		$gvc = ' AND (' . $gvc . ') ';
	    }

		$type = '';
		if (isset($data['filter_types']) && $data['filter_types'] == 1) {
			$type = " AND o.customer_id > 0";
		} elseif (isset($data['filter_types']) && $data['filter_types'] == 0) {
			$type = " AND o.customer_id = 0";
		} elseif (isset($data['filter_types']) && $data['filter_types'] == 3) {
			$type = '';
		}
				
		$sql = "SELECT 
		o.date_added, 
		YEAR(o.date_added) AS gyear, 
		QUARTER(o.date_added) AS gquarter, 
		MONTHNAME(o.date_added) AS gmonth, 
		COUNT(o.order_id) AS gorders, 
		COUNT(DISTINCT CONCAT(o.lastname, ', ', o.firstname)) AS gcustomers, 
		SUM((SELECT SUM(op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)) AS gproducts, 		
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'sub_total' GROUP BY ot.order_id)) AS gsub_total, 
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'handling' GROUP BY ot.order_id)) AS ghandling, 
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'low_order_fee' GROUP BY ot.order_id)) AS glow_order_fee, 
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'shipping' GROUP BY ot.order_id)) AS gshipping, 
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'reward' GROUP BY ot.order_id)) AS greward, 
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'coupon' GROUP BY ot.order_id)) AS gcoupon, 
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'credit' GROUP BY ot.order_id)) AS gcredit, 
		SUM((SELECT SUM(ot.value) FROM `" . DB_PREFIX . "order_total` ot WHERE ot.order_id = o.order_id AND ot.code = 'voucher' GROUP BY ot.order_id)) AS gvoucher, 
		SUM(o.commission) AS gcommission, 
		SUM(o.payment_cost) AS gpayment_cost, 
		SUM(o.shipping_cost) AS gshipping_cost, 
		SUM((SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id GROUP BY op.order_id)) AS gprod_costs 
		
		FROM `" . DB_PREFIX . "order` o" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $ip . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $loc  . $affn . $affe . $cpn . $cpc . $gvc . $type;

		if (isset($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'no_group'; //show No Grouping in Group By default
		}
		
		switch($group) {		
			case 'month':
				$sql .= " GROUP BY YEAR(o.date_added), MONTH(o.date_added)";
				break;
			case 'quarter':
				$sql .= " GROUP BY YEAR(o.date_added), QUARTER(o.date_added)";
				break;				
			case 'year':
				$sql .= " GROUP BY YEAR(o.date_added)";
				break;			
		}		
		
		$sql .= " ORDER BY date_added ASC ";
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getOrderStatuses($data = array()) {
		$query = $this->db->query("SELECT DISTINCT os.name, os.order_status_id FROM `" . DB_PREFIX . "order_status` os WHERE os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY LCASE(os.name) ASC");
		
		return $query->rows;	
	}
	
	public function getOrderStores($data = array()) {
		$query = $this->db->query("SELECT DISTINCT o.store_name, o.store_id FROM `" . DB_PREFIX . "order` o ORDER BY o.store_id ASC");
		
		return $query->rows;	
	}
	
	public function getOrderCurrencies($data = array()) {
		$query = $this->db->query("SELECT DISTINCT cur.currency_id, cur.code, cur.title FROM `" . DB_PREFIX . "currency` cur ORDER BY LCASE(cur.title) ASC");
		
		return $query->rows;	
	}

	public function getOrderTaxes($data = array()) {
		$query = $this->db->query("SELECT DISTINCT ot.title AS tax_title, HEX(ot.title) AS tax FROM `" . DB_PREFIX . "order_total` ot WHERE ot.code = 'tax' ORDER BY LCASE(ot.title) ASC");
		
		return $query->rows;	
	}
	
	public function getOrderCustomerGroups($data = array()) {
		$query = $this->db->query("SELECT DISTINCT cgd.name, cgd.customer_group_id FROM `" . DB_PREFIX . "customer_group_description` cgd WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY (cgd.name) ASC");
		
		return $query->rows;	
	}

	public function getOrderCustomerStatuses($data = array()) {
		$query = $this->db->query("SELECT DISTINCT c.status FROM `" . DB_PREFIX . "customer` c");

		return $query->rows;
	}
	
	public function getOrderPaymentMethods($data = array()) {
		$query = $this->db->query("SELECT DISTINCT o.payment_method AS payment_name, HEX(o.payment_method) AS payment_title FROM `" . DB_PREFIX . "order` o WHERE o.order_status_id > 0 ORDER BY LCASE(o.payment_method) ASC");
		
		return $query->rows;	
	}
	
	public function getOrderShippingMethods($data = array()) {
		$query = $this->db->query("SELECT DISTINCT o.shipping_method AS shipping_name, HEX(o.shipping_method) AS shipping_title FROM `" . DB_PREFIX . "order` o WHERE o.order_status_id > 0 ORDER BY LCASE(o.shipping_method) ASC");
		
		return $query->rows;	
	}	

	public function getProductsCategories($parent_id = 0) {
		$category_data = $this->cache->get('category.' . (int)$this->config->get('config_language_id') . '.' . (int)$parent_id);
	
		if (!$category_data) {		
			$category_data = array();

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
					
			foreach ($query->rows as $result) {
				$category_data[] = array(
					'category_id' => $result['category_id'],
					'name'        => $this->getCategoryPath($result['category_id'], $this->config->get('config_language_id')),
					'status'  	  => $result['status'],
					'sort_order'  => $result['sort_order']
				);
			
				$category_data = array_merge($category_data, $this->getProductsCategories($result['category_id']));
			}	

			$this->cache->set('category.' . (int)$this->config->get('config_language_id') . '.' . (int)$parent_id, $category_data);
		}
		
		return $category_data;
	}

	public function getCategoryPath($category_id) {
		$query = $this->db->query("SELECT name, parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name ASC");
		
		if ($query->row['parent_id']) {
			return $this->getCategoryPath($query->row['parent_id'], $this->config->get('config_language_id')) . $this->language->get('text_separator') . $query->row['name'];
		} else {
			return $query->row['name'];
		}
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
	
	public function getProductOptions($data = array()) {
		$query = $this->db->query("SELECT DISTINCT HEX(CONCAT(oo.name, oo.value, oo.type)) AS options, oo.name AS option_name, oo.value AS option_value FROM `" . DB_PREFIX . "order_option` oo WHERE (oo.type = 'radio' OR oo.type = 'checkbox' OR oo.type = 'select' OR oo.type = 'color') GROUP BY oo.name, oo.value, oo.type ORDER BY oo.name, oo.value, oo.type ASC");		

		return $query->rows;
	}

	public function getProductAttributes($data = array()) {
		$query = $this->db->query("SELECT DISTINCT HEX(CONCAT(agd.name, ad.name, pa.text)) AS attribute_title, CONCAT(agd.name,'" . $this->language->get('text_separator') . "',ad.name,'" . $this->language->get('text_separator') . "',pa.text) AS attribute_name FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.attribute_id = ad.attribute_id AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY agd.name, ad.name, pa.text ORDER BY agd.name, ad.name, pa.text ASC");		

		return $query->rows;
	}
	
	public function getProductLocations($data = array()) {
		$query = $this->db->query("SELECT DISTINCT p.location AS location_name, HEX(p.location) AS location_title FROM `" . DB_PREFIX . "product` p ORDER BY LCASE(p.location) ASC");
		
		return $query->rows;	
	}	

	public function getOrderAffiliates($data = array()) {
		$query = $this->db->query("SELECT DISTINCT a.affiliate_id, CONCAT(a.firstname, ' ', a.lastname) AS affiliate_name, a.email AS affiliate_email FROM `" . DB_PREFIX . "affiliate` a ORDER BY LCASE(a.firstname) ASC");
		
		return $query->rows;	
	}	

	public function getOrderCouponns($data = array()) {
		$query = $this->db->query("SELECT DISTINCT cp.coupon_id, cp.name AS coupon_name, cp.code AS coupon_code FROM `" . DB_PREFIX . "coupon` cp ORDER BY LCASE(cp.code) ASC");
		
		return $query->rows;	
	}	

	public function getOrderVouchers($data = array()) {
		$query = $this->db->query("SELECT DISTINCT gv.voucher_id, gv.code AS voucher_code FROM `" . DB_PREFIX . "voucher` gv ORDER BY LCASE(gv.code) ASC");
		
		return $query->rows;	
	}

	public function getIPAutocomplete($data = array()) {
		
		$ip = '';
		if (!empty($data['filter_ip'])) {
        	$ip = " WHERE c.ip LIKE '%" . $this->db->escape($data['filter_ip']) . "%'";	
		} else {
			$ip = '';
		}

		$sql = "SELECT DISTINCT c.customer_id, c.ip AS cust_ip FROM " . DB_PREFIX . "customer c" . $ip;
						
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getCustomerAutocomplete($data = array()) {

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
		
		$sql = "SELECT DISTINCT o.customer_id, CONCAT(o.firstname, ' ', o.lastname) AS cust_name, o.email AS cust_email, o.telephone AS cust_telephone, o.payment_company AS payment_company, CONCAT(o.payment_address_1, ', ', o.payment_address_2) AS payment_address, o.payment_city AS payment_city, o.payment_zone AS payment_zone, o.payment_postcode AS payment_postcode, o.payment_country AS payment_country, o.shipping_company AS shipping_company, CONCAT(o.shipping_address_1, ', ', o.shipping_address_2) AS shipping_address, o.shipping_city AS shipping_city, o.shipping_zone AS shipping_zone, o.shipping_postcode AS shipping_postcode, o.shipping_country AS shipping_country FROM `" . DB_PREFIX . "order` o WHERE o.order_status_id > 0" . $cust . $email . $tel . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $scomp . $saddr . $scity . $szone . $spsc . $scntr;
						
		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getProductAutocomplete($data = array()) {

		$sku = '';
		if (!empty($data['filter_sku'])) {
        	$sku = " AND LCASE(p.sku) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_sku'], 'UTF-8')) . "%'";				
		} else {
			$sku = '';
		}
		
		$prod = '';
		if (!empty($data['filter_product_id'])) {
        	$prod = " AND LCASE(op.name) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_product_id'], 'UTF-8')) . "%'";				
		} else {
			$prod = '';
		}

		$mod = '';
		if (!empty($data['filter_model'])) {
        	$mod = " AND LCASE(op.model) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_model'], 'UTF-8')) . "%'";				
		} else {
			$mod = '';
		}
		
		$sql = "SELECT DISTINCT op.product_id, p.sku AS prod_sku, op.name AS prod_name, op.model AS prod_model FROM " . DB_PREFIX . "order_product op, " . DB_PREFIX . "product p WHERE op.product_id = p.product_id" . $sku . $prod . $mod;		
						
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
}
?>