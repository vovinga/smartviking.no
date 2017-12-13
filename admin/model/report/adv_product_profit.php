<?php
class ModelReportAdvProductProfit extends Model {
	public function getProductProfit($data = array()) {
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
		
		$date = ' AND (' . $date_start . $date_end . ')';

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
        $cat .= " (SELECT DISTINCT p2c.category_id FROM `" . DB_PREFIX . "product_to_category` p2c WHERE p2c.product_id = op.product_id AND p2c.category_id = '" . (int)$this->db->escape($key) . "')";
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
        $manu .= " (SELECT DISTINCT p.manufacturer_id FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id AND p.manufacturer_id = '" . (int)$this->db->escape($key) . "')";		
      	}
		$manu = ' AND (' . $manu . ') ';
	    }
		
		$sku = '';
		if (!empty($data['filter_sku'])) {
        	$sku = " AND (SELECT p.product_id FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id AND LCASE(p.sku) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_sku'], 'UTF-8')) . "%')";				
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
		
		$opt = '';
		$nopt = '';			
    	if (isset($data['filter_option']) && is_array($data['filter_option']) && $data['filter_ogrouping'] && $data['filter_report'] == 'products') {
			$nopt = " AND op.order_product_id = 0";		
      		foreach($data['filter_option'] as $key => $val)
		{
        if (!empty($opt)) $opt .= ' AND ';
        $opt .= " (SELECT DISTINCT oo.order_product_id FROM `" . DB_PREFIX . "order_option` oo WHERE oo.order_product_id = op.order_product_id AND HEX(CONCAT(oo.name, oo.value, oo.type)) = '" . $this->db->escape($key) . "')";		
      	}
		$opt = ' AND ' . $opt;
		} elseif (isset($data['filter_option']) && is_array($data['filter_option']) && $data['filter_report'] != 'products') {
      		foreach($data['filter_option'] as $key => $val)
		{
        if (!empty($nopt)) $nopt .= ' AND ';
        $nopt .= " (SELECT DISTINCT oo.order_product_id FROM `" . DB_PREFIX . "order_option` oo WHERE oo.order_product_id = op.order_product_id AND HEX(CONCAT(oo.name, oo.value, oo.type)) = '" . $this->db->escape($key) . "')";		
      	}
		$nopt = ' AND ' . $nopt;
		} else {
		$opt = '';
		$nopt = '';		
		}

		$atr = '';
    	if (isset($data['filter_attribute']) && is_array($data['filter_attribute'])) {	
      		foreach($data['filter_attribute'] as $key => $val)
		{
        if (!empty($atr)) $atr .= ' AND ';
        $atr .= " (SELECT DISTINCT pa.product_id FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.product_id = op.product_id AND pa.attribute_id = ad.attribute_id AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND HEX(CONCAT(agd.name, ad.name, pa.text)) = '" . $this->db->escape($key) . "')";		
      	}
		$atr = ' AND ' . $atr;
		}

		$stat = '';
    	if (isset($data['filter_status']) && is_array($data['filter_status'])) {
      		foreach($data['filter_status'] as $key => $val)
		{
        if (!empty($stat)) $stat .= ' OR ';
        $stat .= " (SELECT DISTINCT p.product_id FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id AND p.status = '" . (int)$this->db->escape($key) . "')";		
      	}
		$stat = ' AND (' . $stat . ') ';
	    }
		
		$loc = '';
    	if (isset($data['filter_location']) && is_array($data['filter_location'])) {
      		foreach($data['filter_location'] as $key => $val)
		{
        if (!empty($loc)) $loc .= ' OR ';
        $loc .= " (SELECT DISTINCT HEX(p.location) FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id AND HEX(p.location) = '" . $this->db->escape($key) . "')";			
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

		if (isset($data['filter_report'])) {
			$report = $data['filter_report'];
		} else {
			$report = 'products'; //show Products in Report By default
		}
		
		switch($report) {
			case 'products';
				if (isset($data['filter_ogrouping']) && $data['filter_ogrouping'] == 1) {
					$repo = " options, op.product_id ";
					$rep = " op.product_id ";
				} else {
					$repo = " op.product_id ";
					$rep = " op.product_id ";
				}
				break;				
			case 'manufacturers';
					$repo = " manufacturer ";
					$rep = " manufacturer ";			
				break;
			case 'categories':
					$repo = " category ";
					$rep = " category ";
				break;		
		}
		
		if (isset($data['filter_group'])) {
			$groups = $data['filter_group'];
		} else {
			$groups = 'no_group'; //show No Grouping in Group By default
		}
		
		switch($groups) {
			case 'no_group';
				if (isset($data['filter_ogrouping']) && $data['filter_ogrouping'] == 1) {
					$grpo = " GROUP BY " . $repo . "";
					$grp = " GROUP BY " . $rep . "";
				} else {
					$grpo = " GROUP BY " . $repo . "";
					$grp = " GROUP BY " . $rep . "";
				}
				break;				
			case 'order';
				if (isset($data['filter_ogrouping']) && $data['filter_ogrouping'] == 1) {
					$grpo = " GROUP BY o.order_id," . $repo . "";
					$grp = " GROUP BY o.order_id," . $rep . "";
				} else {
					$grpo = " GROUP BY o.order_id," . $repo . "";
					$grp = " GROUP BY o.order_id," . $rep . "";
				}
				break;
			case 'day';
				if (isset($data['filter_ogrouping']) && $data['filter_ogrouping'] == 1) {
					$grpo = " GROUP BY YEAR(o.date_added), DAY(o.date_added)," . $repo . "";
					$grp = " GROUP BY YEAR(o.date_added), DAY(o.date_added)," . $rep . "";
				} else {
					$grpo = " GROUP BY YEAR(o.date_added), DAY(o.date_added)," . $repo . "";
					$grp = " GROUP BY YEAR(o.date_added), DAY(o.date_added)," . $rep . "";
				}
				break;				
			case 'week':
				if (isset($data['filter_ogrouping']) && $data['filter_ogrouping'] == 1) {
					$grpo = " GROUP BY YEAR(o.date_added), WEEK(o.date_added)," . $repo . "";
					$grp = " GROUP BY YEAR(o.date_added), WEEK(o.date_added)," . $rep . "";
				} else {
					$grpo = " GROUP BY YEAR(o.date_added), WEEK(o.date_added)," . $repo . "";
					$grp = " GROUP BY YEAR(o.date_added), WEEK(o.date_added)," . $rep . "";
				}
				break;			
			case 'month':
				if (isset($data['filter_ogrouping']) && $data['filter_ogrouping'] == 1) {
					$grpo = " GROUP BY YEAR(o.date_added), MONTH(o.date_added)," . $repo . "";
					$grp = " GROUP BY YEAR(o.date_added), MONTH(o.date_added)," . $rep . "";
				} else {
					$grpo = " GROUP BY YEAR(o.date_added), MONTH(o.date_added)," . $repo . "";
					$grp = " GROUP BY YEAR(o.date_added), MONTH(o.date_added)," . $rep . "";
				}
				break;
			case 'quarter':
				if (isset($data['filter_ogrouping']) && $data['filter_ogrouping'] == 1) {
					$grpo = " GROUP BY YEAR(o.date_added), QUARTER(o.date_added)," . $repo . "";
					$grp = " GROUP BY YEAR(o.date_added), QUARTER(o.date_added)," . $rep . "";
				} else {
					$grpo = " GROUP BY YEAR(o.date_added), QUARTER(o.date_added)," . $repo . "";
					$grp = " GROUP BY YEAR(o.date_added), QUARTER(o.date_added)," . $rep . "";
				}
				break;				
			case 'year':
				if (isset($data['filter_ogrouping']) && $data['filter_ogrouping'] == 1) {
					$grpo = " GROUP BY YEAR(o.date_added)," . $repo . "";
					$grp = " GROUP BY YEAR(o.date_added)," . $rep . "";
				} else {
					$grpo = " GROUP BY YEAR(o.date_added)," . $repo . "";
					$grp = " GROUP BY YEAR(o.date_added)," . $rep . "";
				}
				break;			
		}
		
		$sql = "SELECT ";
		
		if (isset($data['filter_report']) && $data['filter_report'] == 'products' && isset($data['filter_ogrouping']) && $data['filter_ogrouping'] == 1) {
			
 		$sql .= " o.date_added AS date, 
		YEAR(o.date_added) AS year, 
		QUARTER(o.date_added) AS quarter, 		
		MONTHNAME(o.date_added) AS month, 		
		MIN(o.date_added) AS date_start, 
		MAX(o.date_added) AS date_end, 
		op.order_id, 
		op.product_id, 
		qa.order_product_id, 
		(SELECT p.image FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS image, 
		(SELECT p.sku FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS sku, 
		op.name, 
		op.model, 		
		(SELECT cd.name FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "category` c, `" . DB_PREFIX . "product_to_category` p2c WHERE c.category_id = cd.category_id AND p2c.category_id = c.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND op.product_id = p2c.product_id GROUP BY op.product_id) AS category, 
		(SELECT p.manufacturer_id FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS manufacturer_id, 
		(SELECT m.name FROM `" . DB_PREFIX . "manufacturer` m, `" . DB_PREFIX . "product` p WHERE p.manufacturer_id = m.manufacturer_id AND op.product_id = p.product_id) AS manufacturer, 
		(SELECT GROUP_CONCAT(CONCAT(agd.name,'" . $this->language->get('text_separator') . "',ad.name,'" . $this->language->get('text_separator') . "',pa.text) ORDER BY agd.name, ad.name, pa.text ASC SEPARATOR '<br>') FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.product_id = op.product_id AND pa.attribute_id = ad.attribute_id AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute, 
		(SELECT p.status FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS status, 
		(SELECT p.quantity FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS stock_quantity, 
		(SELECT GROUP_CONCAT(pov.quantity ORDER BY oo.order_option_id SEPARATOR '<br>') FROM `" . DB_PREFIX . "order_option` oo, `" . DB_PREFIX . "product_option_value` pov WHERE op.order_product_id = oo.order_product_id AND op.product_id = pov.product_id AND pov.product_option_value_id = oo.product_option_value_id) AS stock_oquantity, 		
		SUM(op.quantity) AS sold_quantity, 
		op.price, 
		o.currency_code, 
		o.currency_value, 
		SUM(op.tax*op.quantity) AS tax, 
		SUM(op.total) AS prod_sales, 
		SUM(op.cost*op.quantity) AS prod_costs, 
		SUM(op.total - op.cost*op.quantity) AS prod_profit, 	
		options, 
		oovalue, 
		ooname, ";

		if (isset($data['filter_details']) && $data['filter_details'] == 1) {
			$sql .= " GROUP_CONCAT('<a href=\"index.php?route=sale/order/info&token=$token&order_id=',op.order_id,'\">',op.order_id,'</a>' ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_ord_id, 
					GROUP_CONCAT(op.order_id ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_ord_idc, 	
					GROUP_CONCAT(DATE_FORMAT(o.date_added, '%e/%m/%Y') ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_order_date, 
					GROUP_CONCAT(IFNULL(o.invoice_prefix,'&nbsp;'),IFNULL(o.invoice_no,'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_inv_no, 
					GROUP_CONCAT(CONCAT(o.firstname,' ',o.lastname,IF (o.payment_company = '','',CONCAT(' / ',o.payment_company))) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_name, 
					GROUP_CONCAT(o.email ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_email, 
					GROUP_CONCAT(IFNULL((SELECT cgd.name FROM `" . DB_PREFIX . "customer_group_description` cgd WHERE cgd.customer_group_id = o.customer_group_id AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'),'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_group, 
					GROUP_CONCAT(IF (o.shipping_method = '','&nbsp;&nbsp;',o.shipping_method) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_shipping_method, 
					GROUP_CONCAT(IF (o.payment_method = '','&nbsp;&nbsp;',o.payment_method) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_payment_method, 
					GROUP_CONCAT(IFNULL((SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "'),'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_status, 
 					GROUP_CONCAT(o.store_name ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_store, 
					GROUP_CONCAT(o.currency_code ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_currency, 
					GROUP_CONCAT(ROUND(o.currency_value*op.price, 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_price, 
					GROUP_CONCAT(op.quantity ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_quantity, 
					GROUP_CONCAT(ROUND(o.currency_value*op.total, 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_total, 
					GROUP_CONCAT(ROUND(o.currency_value*op.tax*op.quantity, 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_tax, 
					GROUP_CONCAT(ROUND(o.currency_value*op.cost*op.quantity, 2) ORDER BY op.order_id DESC SEPARATOR '<br>-') AS order_prod_costs, 
					GROUP_CONCAT(ROUND(o.currency_value*(op.total - (op.cost*op.quantity)), 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_profit, 
					GROUP_CONCAT(IFNULL(ROUND(100*(op.total - (op.cost*op.quantity)) / op.total, 2),0) ORDER BY op.order_id DESC SEPARATOR '%<br>') AS order_prod_profit_margin_percent, ";
					
		} elseif (isset($data['filter_details']) && $data['filter_details'] == 2) {
			$sql .= " GROUP_CONCAT('<a href=\"index.php?route=sale/order/info&token=$token&order_id=',o.order_id,'\">',o.order_id,'</a>' ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_ord_id, 
					GROUP_CONCAT(o.order_id ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_ord_idc, 	
					GROUP_CONCAT(DATE_FORMAT(o.date_added, '%e/%m/%Y') ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_order_date, 
					GROUP_CONCAT(IFNULL(o.invoice_prefix,'&nbsp;&nbsp;'),IFNULL(o.invoice_no,'&nbsp;&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_inv_no, 			
					GROUP_CONCAT(IF (o.customer_id = 0,'&nbsp;&nbsp;',CONCAT('<a href=\"index.php?route=sale/customer/update&token=$token&customer_id=',o.customer_id,'\">',o.customer_id,'</a>')) ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_cust_id, 
					GROUP_CONCAT(IF (o.customer_id = 0,'&nbsp;&nbsp;',o.customer_id) ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_cust_idc, 
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
					GROUP_CONCAT(IF (o.shipping_country = '','&nbsp;&nbsp;',o.shipping_country) ORDER BY op.order_id DESC SEPARATOR '<br>') AS shipping_country, ";
		}

		$sql .= " (SELECT SUM(op.quantity) FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order` o WHERE op.order_id = o.order_id" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . ") AS sold_quantity_total, 
		(SELECT SUM(op.tax*op.quantity) FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order` o WHERE op.order_id = o.order_id" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . ") AS tax_total, 
		(SELECT SUM(op.total) FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order` o WHERE op.order_id = o.order_id" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . ") AS sales_total, 
		(SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order` o WHERE op.order_id = o.order_id" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . ") AS costs_total, 
		(SELECT SUM(op.total - op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order` o WHERE op.order_id = o.order_id" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . ") AS profit_total
				
		FROM (SELECT oo.order_product_id, GROUP_CONCAT(name, value, type) AS options, GROUP_CONCAT(value SEPARATOR '<br>') AS oovalue, GROUP_CONCAT(name SEPARATOR ':<br>') AS ooname FROM `" . DB_PREFIX . "order_option` oo WHERE (type = 'radio' OR type = 'checkbox' OR type = 'select') GROUP BY order_product_id) qa, `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order` o 
		
		WHERE op.order_product_id = qa.order_product_id AND op.order_id = o.order_id" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . $grpo;
		
		$sql .= " UNION ALL SELECT ";

		}
		
		if (isset($data['filter_report']) && $data['filter_report'] || !isset($data['filter_ogrouping']) && !$data['filter_ogrouping'] || isset($data['filter_ogrouping']) && $data['filter_ogrouping'] == 0 || isset($data['filter_ogrouping']) && $data['filter_ogrouping'] == 1) {		
		
		$sql .= "o.date_added AS date, 
		YEAR(o.date_added) AS year, 
		QUARTER(o.date_added) AS quarter, 		
		MONTHNAME(o.date_added) AS month, 		
		MIN(o.date_added) AS date_start, 
		MAX(o.date_added) AS date_end, 
		op.order_id, 
		op.product_id, 
		op.order_product_id, ";
		if (isset($data['filter_report']) && $data['filter_report'] == 'products') {
			$sql .= " (SELECT p.image FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS image, 
			(SELECT p.sku FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS sku, 
			op.name, 
			op.model, 		
			(SELECT cd.name FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "category` c, `" . DB_PREFIX . "product_to_category` p2c WHERE c.category_id = cd.category_id AND p2c.category_id = c.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'  AND op.product_id = p2c.product_id GROUP BY op.product_id) AS category, 
			(SELECT p.manufacturer_id FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS manufacturer_id, 
			(SELECT m.name FROM `" . DB_PREFIX . "manufacturer` m, `" . DB_PREFIX . "product` p WHERE p.manufacturer_id = m.manufacturer_id AND op.product_id = p.product_id) AS manufacturer, 
			(SELECT GROUP_CONCAT(CONCAT(agd.name,'" . $this->language->get('text_separator') . "',ad.name,'" . $this->language->get('text_separator') . "',pa.text) ORDER BY agd.name, ad.name, pa.text ASC SEPARATOR '<br>') FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.product_id = op.product_id AND pa.attribute_id = ad.attribute_id AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute, 
			(SELECT p.status FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS status, ";
		} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers') {
			$sql .= " '' AS image, 
			'' AS sku, 
			'' AS name, 
			'' AS model, 
			'' AS category, 
			(SELECT p.manufacturer_id FROM `" . DB_PREFIX . "product` p WHERE op.order_id = o.order_id AND op.product_id = p.product_id) AS manufacturer_id, 
			(SELECT m.name FROM `" . DB_PREFIX . "manufacturer` m, `" . DB_PREFIX . "product` p WHERE op.order_id = o.order_id AND op.product_id = p.product_id AND p.manufacturer_id = m.manufacturer_id) AS manufacturer, 
			'' AS attribute, 
			'' AS status, 
			'' AS stock_quantity, ";	
		} elseif (isset($data['filter_report']) && $data['filter_report'] == 'categories') {
			$sql .= " '' AS image, 
			'' AS sku, 
			'' AS name, 
			'' AS model, 			
			(SELECT cd.name FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "product_to_category` p2c WHERE op.order_id = o.order_id AND op.product_id = p2c.product_id AND p2c.category_id = cd.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY op.product_id) AS category, 
			'' AS manufacturer_id, 
			'' AS manufacturer, 
			'' AS attribute, 			
			'' AS status, 
			'' AS stock_quantity, ";
		}
		$sql .= " (SELECT p.quantity FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id) AS stock_quantity, 
		'' AS stock_oquantity, 
		SUM(op.quantity) AS sold_quantity, 
		op.price, 
		o.currency_code, 
		o.currency_value, 
		SUM(op.tax*op.quantity) AS tax, 
		SUM(op.total) AS prod_sales, 		
		SUM(op.cost*op.quantity) AS prod_costs, 
		SUM(op.total - op.cost*op.quantity) AS prod_profit, 
		'' AS options, 
		'' AS oovalue, 
		'' AS ooname, ";

		if (isset($data['filter_report']) && $data['filter_report'] == 'products' && isset($data['filter_details']) && $data['filter_details'] == 1) {
			$sql .= " GROUP_CONCAT('<a href=\"index.php?route=sale/order/info&token=$token&order_id=',op.order_id,'\">',op.order_id,'</a>' ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_ord_id, 
					GROUP_CONCAT(op.order_id ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_ord_idc, 	
					GROUP_CONCAT(DATE_FORMAT(o.date_added, '%e/%m/%Y') ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_order_date, 
					GROUP_CONCAT(IFNULL(o.invoice_prefix,'&nbsp;'),IFNULL(o.invoice_no,'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_inv_no, 
					GROUP_CONCAT(CONCAT(o.firstname,' ',o.lastname,IF (o.payment_company = '','',CONCAT(' / ',o.payment_company))) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_name, 
					GROUP_CONCAT(o.email ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_email, 
					GROUP_CONCAT(IFNULL((SELECT cgd.name FROM `" . DB_PREFIX . "customer_group_description` cgd WHERE cgd.customer_group_id = o.customer_group_id AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'),'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_group, 
					GROUP_CONCAT(IF (o.shipping_method = '','&nbsp;&nbsp;',o.shipping_method) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_shipping_method, 
					GROUP_CONCAT(IF (o.payment_method = '','&nbsp;&nbsp;',o.payment_method) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_payment_method, 
					GROUP_CONCAT(IFNULL((SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "'),'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_status, 
 					GROUP_CONCAT(o.store_name ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_store, 
					GROUP_CONCAT(o.currency_code ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_currency, 
					GROUP_CONCAT(ROUND(o.currency_value*op.price, 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_price, 
					GROUP_CONCAT(op.quantity ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_quantity, 
					GROUP_CONCAT(ROUND(o.currency_value*op.total, 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_total, 
					GROUP_CONCAT(ROUND(o.currency_value*op.tax*op.quantity, 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_tax, 
					GROUP_CONCAT(ROUND(o.currency_value*op.cost*op.quantity, 2) ORDER BY op.order_id DESC SEPARATOR '<br>-') AS order_prod_costs, 
					GROUP_CONCAT(ROUND(o.currency_value*(op.total - (op.cost*op.quantity)), 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS order_prod_profit, 
					GROUP_CONCAT(IFNULL(ROUND(100*(op.total - (op.cost*op.quantity)) / op.total, 2),0) ORDER BY op.order_id DESC SEPARATOR '%<br>') AS order_prod_profit_margin_percent, ";
					
		} elseif (isset($data['filter_report']) && $data['filter_report'] == 'manufacturers' && isset($data['filter_details']) && $data['filter_details'] == 3 || isset($data['filter_report']) && $data['filter_report'] == 'categories' && isset($data['filter_details']) && $data['filter_details'] == 3) {
			$sql .= " GROUP_CONCAT('<a href=\"index.php?route=sale/order/info&token=$token&order_id=',op.order_id,'\">',op.order_id,'</a>' ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_ord_id, 
					GROUP_CONCAT(op.order_id ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_ord_idc, 
					GROUP_CONCAT(DATE_FORMAT(o.date_added, '%e/%m/%Y') ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_order_date,  
					GROUP_CONCAT(IFNULL(o.invoice_prefix,'&nbsp;'),IFNULL(o.invoice_no,'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_inv_no, 
					GROUP_CONCAT(IFNULL(CONCAT('<a href=\"index.php?route=catalog/product/update&token=$token&product_id=',op.product_id,'\">',op.product_id,'</a>'),op.product_id) ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_pid, 
					GROUP_CONCAT(op.product_id ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_pidc, 
					GROUP_CONCAT(IFNULL((SELECT p.sku FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id),'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_sku, 
					GROUP_CONCAT(op.model ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_model, 
					GROUP_CONCAT(op.name ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_name, 
					GROUP_CONCAT(IFNULL((SELECT GROUP_CONCAT(CONCAT(oo.name,': ',oo.value) SEPARATOR '; ') FROM `" . DB_PREFIX . "order_option` oo WHERE op.order_product_id = oo.order_product_id AND (oo.type = 'radio' OR oo.type = 'checkbox' OR oo.type = 'select') ORDER BY op.order_product_id),'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_option, 
					GROUP_CONCAT(IFNULL((SELECT GROUP_CONCAT(CONCAT(agd.name,'" . $this->language->get('text_separator') . "',ad.name,'" . $this->language->get('text_separator') . "',pa.text) SEPARATOR '; ') FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.product_id = op.product_id AND pa.attribute_id = ad.attribute_id AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY agd.name, ad.name, pa.text ASC),'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_attributes, 					
					GROUP_CONCAT(IFNULL((SELECT m.name FROM `" . DB_PREFIX . "product` p, `" . DB_PREFIX . "manufacturer` m WHERE op.product_id = p.product_id AND p.manufacturer_id = m.manufacturer_id),'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_manu, 
					GROUP_CONCAT(IFNULL((SELECT GROUP_CONCAT(cd.name SEPARATOR ', ') FROM `" . DB_PREFIX . "category_description` cd, `" . DB_PREFIX . "category` c, `" . DB_PREFIX . "product_to_category` p2c WHERE op.product_id = p2c.product_id AND p2c.category_id = c.category_id AND (c.category_id = cd.category_id OR c.parent_id = cd.category_id) AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c.status > 0),'&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_category, 
					GROUP_CONCAT(o.currency_code ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_currency,  
					GROUP_CONCAT(ROUND(o.currency_value*op.price, 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_price, 
					GROUP_CONCAT(op.quantity ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_quantity, 
					GROUP_CONCAT(ROUND(o.currency_value*op.total, 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_total, 
					GROUP_CONCAT(ROUND(o.currency_value*op.tax*op.quantity, 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_tax, 
					GROUP_CONCAT(ROUND(o.currency_value*op.cost*op.quantity, 2) ORDER BY op.order_id DESC SEPARATOR '<br>-') AS product_costs, 
					GROUP_CONCAT(ROUND(o.currency_value*(op.total - (op.cost*op.quantity)), 2) ORDER BY op.order_id DESC SEPARATOR '<br>') AS product_profit, 
					GROUP_CONCAT(IFNULL(ROUND(100*(op.total - (op.cost*op.quantity)) / op.total, 2),0) ORDER BY op.order_id DESC SEPARATOR '%<br>') AS product_profit_margin_percent, ";
					
		} elseif (isset($data['filter_report']) && $data['filter_report'] == 'products' && isset($data['filter_details']) && $data['filter_details'] == 2) {
			$sql .= " GROUP_CONCAT('<a href=\"index.php?route=sale/order/info&token=$token&order_id=',o.order_id,'\">',o.order_id,'</a>' ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_ord_id, 
					GROUP_CONCAT(o.order_id ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_ord_idc, 	
					GROUP_CONCAT(DATE_FORMAT(o.date_added, '%e/%m/%Y') ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_order_date, 
					GROUP_CONCAT(IFNULL(o.invoice_prefix,'&nbsp;&nbsp;'),IFNULL(o.invoice_no,'&nbsp;&nbsp;') ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_inv_no, 			
					GROUP_CONCAT(IF (o.customer_id = 0,'&nbsp;&nbsp;',CONCAT('<a href=\"index.php?route=sale/customer/update&token=$token&customer_id=',o.customer_id,'\">',o.customer_id,'</a>')) ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_cust_id, 
					GROUP_CONCAT(IF (o.customer_id = 0,'&nbsp;&nbsp;',o.customer_id) ORDER BY op.order_id DESC SEPARATOR '<br>') AS customer_cust_idc, 
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
					GROUP_CONCAT(IF (o.shipping_country = '','&nbsp;&nbsp;',o.shipping_country) ORDER BY op.order_id DESC SEPARATOR '<br>') AS shipping_country, ";
		}

		$sql .= " (SELECT SUM(op.quantity) FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order` o WHERE op.order_id = o.order_id" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . ") AS sold_quantity_total, 
		(SELECT SUM(op.tax*op.quantity) FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order` o WHERE op.order_id = o.order_id" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . ") AS tax_total, 
		(SELECT SUM(op.total) FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order` o WHERE op.order_id = o.order_id" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . ") AS sales_total, 
		(SELECT SUM(op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order` o WHERE op.order_id = o.order_id" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . ") AS costs_total, 
		(SELECT SUM(op.total - op.cost*op.quantity) FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order` o WHERE op.order_id = o.order_id" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . ") AS profit_total 

		FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order` o ";
		
		}

		if (isset($data['filter_report']) && $data['filter_report'] == 'products' && (isset($data['filter_ogrouping']) && $data['filter_ogrouping'] == 1)) {
			
		$sql .= " WHERE op.order_id = o.order_id AND IF(op.order_product_id NOT IN (SELECT order_product_id FROM " . DB_PREFIX . "order_option), op.order_product_id NOT IN (SELECT order_product_id FROM " . DB_PREFIX . "order_option), op.order_product_id IN (SELECT order_product_id FROM " . DB_PREFIX . "order_option GROUP BY order_product_id HAVING SUM(product_option_value_id) = 0))" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . $grp;

		} elseif (isset($data['filter_report']) && $data['filter_report'] != 'products' || !isset($data['filter_ogrouping']) && !$data['filter_ogrouping'] || isset($data['filter_ogrouping']) && $data['filter_ogrouping'] == 0) {
			
		$sql .= " WHERE op.order_id = o.order_id" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc . $grp;
		
		}			
		
		if (isset($data['filter_sort']) && $data['filter_sort'] == 'date') {
			$sql .= " ORDER BY date_start DESC, sold_quantity DESC ";			
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'sku') {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY LCASE(sku) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, LCASE(sku) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(sku) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(sku) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(sku) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, LCASE(sku) ASC, sold_quantity DESC ";
				}	
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'name') {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY LCASE(name) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, LCASE(name) ASC, sold_quantity DESC ";					
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, LCASE(name) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(name) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(name) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(name) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, LCASE(name) ASC, sold_quantity DESC ";
				}	
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'model') {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY LCASE(model) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, LCASE(model) ASC, sold_quantity DESC ";						
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, LCASE(model) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(model) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(model) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(model) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, LCASE(model) ASC, sold_quantity DESC ";
				}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'category') {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY LCASE(category) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, LCASE(category) ASC, sold_quantity DESC ";						
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, LCASE(category) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(category) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(category) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(category) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, LCASE(category) ASC, sold_quantity DESC ";
				}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'manufacturer') {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY LCASE(manufacturer) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, LCASE(manufacturer) ASC, sold_quantity DESC ";					
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, LCASE(manufacturer) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(manufacturer) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(manufacturer) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(manufacturer) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, LCASE(manufacturer) ASC, sold_quantity DESC ";
				}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'attribute') {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY LCASE(attribute) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, LCASE(attribute) ASC, sold_quantity DESC ";					
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, LCASE(attribute) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, LCASE(attribute) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, LCASE(attribute) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, LCASE(attribute) ASC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, LCASE(attribute) ASC, sold_quantity DESC ";
				}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'status') {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY status DESC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, status DESC, sold_quantity DESC ";					
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, status DESC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, status DESC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, status DESC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, status DESC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, status DESC, sold_quantity DESC ";
				}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'stock_quantity') {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY stock_quantity DESC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, stock_quantity DESC, sold_quantity DESC ";						
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, stock_quantity DESC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, stock_quantity DESC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, stock_quantity DESC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, stock_quantity DESC, sold_quantity DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, stock_quantity DESC, sold_quantity DESC ";
				}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'sold_quantity') {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY sold_quantity DESC, prod_sales DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, sold_quantity DESC, prod_sales DESC ";						
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, sold_quantity DESC, prod_sales DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, sold_quantity DESC, prod_sales DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, sold_quantity DESC, prod_sales DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, sold_quantity DESC, prod_sales DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, sold_quantity DESC, prod_sales DESC ";
				}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'tax') {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY tax DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, tax DESC ";					
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, tax DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, tax DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, tax DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, tax DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, tax DESC ";
				}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'prod_sales') {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY prod_sales DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, prod_sales DESC ";						
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, prod_sales DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, prod_sales DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, prod_sales DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, prod_sales DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, prod_sales DESC ";
				}	
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'prod_costs') {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY prod_costs DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, prod_costs DESC ";						
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, prod_costs DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, prod_costs DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, prod_costs DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, prod_costs DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, prod_costs DESC ";
				}		
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'prod_profit') {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY prod_profit DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, prod_profit DESC ";					
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, prod_profit DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, prod_profit DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, prod_profit DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, prod_profit DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, prod_profit DESC ";
				}
		} elseif (isset($data['filter_sort']) && $data['filter_sort'] == 'profit_margin') {
			if (isset($data['filter_report']) && $data['filter_report'] == 'products' && isset($data['filter_ogrouping']) && $data['filter_ogrouping'] == 1) {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY 100*(prod_profit / prod_sales) DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, 100*(prod_profit / prod_sales) DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, 100*(prod_profit / prod_sales) DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, 100*(prod_profit / prod_sales) DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, 100*(prod_profit / prod_sales) DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, 100*(prod_profit / prod_sales) DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, 100*(prod_profit / prod_sales) DESC ";
				}
			} else {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY 100*(SUM(op.total - op.cost*op.quantity) / SUM(op.total)) DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, 100*(SUM(op.total - op.cost*op.quantity) / SUM(op.total)) DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, 100*(SUM(op.total - op.cost*op.quantity) / SUM(op.total)) DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, 100*(SUM(op.total - op.cost*op.quantity) / SUM(op.total)) DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, 100*(SUM(op.total - op.cost*op.quantity) / SUM(op.total)) DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, 100*(SUM(op.total - op.cost*op.quantity) / SUM(op.total)) DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, 100*(SUM(op.total - op.cost*op.quantity) / SUM(op.total)) DESC ";
				}				
			}	
		} else {
				if (isset($data['filter_group']) && $data['filter_group'] == 'no_group') {		
					$sql .= " ORDER BY sold_quantity DESC, prod_sales DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'order') {	
					$sql .= " ORDER BY order_id DESC, sold_quantity DESC, prod_sales DESC ";						
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'day') {	
					$sql .= " ORDER BY YEAR(date) DESC, DAY(date) DESC, sold_quantity DESC, prod_sales DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'week') {	
					$sql .= " ORDER BY YEAR(date) DESC, WEEK(date) DESC, sold_quantity DESC, prod_sales DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'month') {	
					$sql .= " ORDER BY YEAR(date) DESC, MONTH(date) DESC, sold_quantity DESC, prod_sales DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'quarter') {	
					$sql .= " ORDER BY YEAR(date) DESC, QUARTER(date) DESC, sold_quantity DESC, prod_sales DESC ";
				} elseif (isset($data['filter_group']) && $data['filter_group'] == 'year') {	
					$sql .= " ORDER BY YEAR(date) DESC, sold_quantity DESC, prod_sales DESC ";
				}
		}
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}	

	public function getProductSaleChart($data = array()) {
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
		
		$date = ' AND (' . $date_start . $date_end . ')';

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
        $cat .= " (SELECT DISTINCT p2c.category_id FROM `" . DB_PREFIX . "product_to_category` p2c WHERE p2c.product_id = op.product_id AND p2c.category_id = '" . (int)$this->db->escape($key) . "')";
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
        $manu .= " (SELECT DISTINCT p.manufacturer_id FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id AND p.manufacturer_id = '" . (int)$this->db->escape($key) . "')";		
      	}
		$manu = ' AND (' . $manu . ') ';
	    }
		
		$sku = '';
		if (!empty($data['filter_sku'])) {
        	$sku = " AND (SELECT p.product_id FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id AND LCASE(p.sku) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_sku'], 'UTF-8')) . "%')";				
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
		
		$opt = '';
		$nopt = '';			
    	if (isset($data['filter_option']) && is_array($data['filter_option']) && $data['filter_ogrouping'] && $data['filter_report'] == 'products') {
			$nopt = " AND op.order_product_id = 0";		
      		foreach($data['filter_option'] as $key => $val)
		{
        if (!empty($opt)) $opt .= ' AND ';
        $opt .= " (SELECT DISTINCT oo.order_product_id FROM `" . DB_PREFIX . "order_option` oo WHERE oo.order_product_id = op.order_product_id AND HEX(CONCAT(oo.name, oo.value, oo.type)) = '" . $this->db->escape($key) . "')";		
      	}
		$opt = ' AND ' . $opt;
		} elseif (isset($data['filter_option']) && is_array($data['filter_option']) && $data['filter_report'] != 'products') {
      		foreach($data['filter_option'] as $key => $val)
		{
        if (!empty($nopt)) $nopt .= ' AND ';
        $nopt .= " (SELECT DISTINCT oo.order_product_id FROM `" . DB_PREFIX . "order_option` oo WHERE oo.order_product_id = op.order_product_id AND HEX(CONCAT(oo.name, oo.value, oo.type)) = '" . $this->db->escape($key) . "')";		
      	}
		$nopt = ' AND ' . $nopt;
		} else {
		$opt = '';
		$nopt = '';		
		}

		$atr = '';
    	if (isset($data['filter_attribute']) && is_array($data['filter_attribute'])) {	
      		foreach($data['filter_attribute'] as $key => $val)
		{
        if (!empty($atr)) $atr .= ' AND ';
        $atr .= " (SELECT DISTINCT pa.product_id FROM `" . DB_PREFIX . "product_attribute` pa, `" . DB_PREFIX . "attribute_description` ad, `" . DB_PREFIX . "attribute` a, `" . DB_PREFIX . "attribute_group_description` agd WHERE pa.product_id = op.product_id AND pa.attribute_id = ad.attribute_id AND ad.attribute_id = a.attribute_id AND a.attribute_group_id = agd.attribute_group_id AND HEX(CONCAT(agd.name, ad.name, pa.text)) = '" . $this->db->escape($key) . "')";		
      	}
		$atr = ' AND ' . $atr;
		}

		$stat = '';
    	if (isset($data['filter_status']) && is_array($data['filter_status'])) {
      		foreach($data['filter_status'] as $key => $val)
		{
        if (!empty($stat)) $stat .= ' OR ';
        $stat .= " (SELECT DISTINCT p.product_id FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id AND p.status = '" . (int)$this->db->escape($key) . "')";		
      	}
		$stat = ' AND (' . $stat . ') ';
	    }
		
		$loc = '';
    	if (isset($data['filter_location']) && is_array($data['filter_location'])) {
      		foreach($data['filter_location'] as $key => $val)
		{
        if (!empty($loc)) $loc .= ' OR ';
        $loc .= " (SELECT DISTINCT HEX(p.location) FROM `" . DB_PREFIX . "product` p WHERE op.product_id = p.product_id AND HEX(p.location) = '" . $this->db->escape($key) . "')";			
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
		
		$sql = "SELECT 
		o.date_added, 
		YEAR(o.date_added) AS gyear, 
		QUARTER(o.date_added) AS gquarter, 
		MONTHNAME(o.date_added) AS gmonth, 
		COUNT(o.order_id) AS gorders, 
		COUNT(DISTINCT CONCAT(o.lastname, ', ', o.firstname)) AS gcustomers, 
		SUM(op.quantity) AS gproducts, 		
		SUM(op.total) AS gsales, 
		SUM(op.cost*op.quantity) AS gcosts, 
		SUM(op.total - op.cost*op.quantity) AS gprofit 
		
		FROM `" . DB_PREFIX . "order_product` op, `" . DB_PREFIX . "order` o 
		
		WHERE op.order_id = o.order_id" . $date . $sdate . $osi . $store . $cur . $tax . $cgrp . $stat . $cust . $email . $tel . $pcomp . $paddr . $pcity . $pzone . $ppsc . $pcntr . $pmeth . $scomp . $saddr . $scity . $szone . $spsc . $scntr . $smeth . $cat . $manu . $sku . $prod . $mod . $opt . $atr . $stat . $loc . $affn . $affe . $cpn . $cpc . $gvc;	
		
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

	public function getProductStatuses($data = array()) {
		$query = $this->db->query("SELECT DISTINCT p.status FROM `" . DB_PREFIX . "product` p");

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