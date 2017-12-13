<?php
class ModelCatalogProductExt extends Model {
    protected $productCount = 0;

    public function getProducts($data = array()) {
        $columns = isset($data['columns']) ? $data['columns'] : array();

        $sql = "SELECT SQL_CALC_FOUND_ROWS p.*, pd.*";

        $sql .= ", (SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = p.product_id AND (date_start = '0000-00-00' OR date_start < NOW() AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority, price LIMIT 1) AS special_price";

        if (in_array("subtract", $columns)) {
            $sql .= ", IF(p.subtract, '" . $this->db->escape($this->language->get('text_yes')) . "','" .$this->db->escape($this->language->get('text_no')) . "') AS subtract_text";
        }

        if (in_array("shipping", $columns)) {
            $sql .= ", IF(p.shipping, '" . $this->db->escape($this->language->get('text_yes')) . "','" .$this->db->escape($this->language->get('text_no')) . "') AS shipping_text";
        }

        if (in_array("status", $columns)) {
            $sql .= ", IF(p.status, '" . $this->db->escape($this->language->get('text_enabled')) . "','" .$this->db->escape($this->language->get('text_disabled')) . "') AS status_text";
        }

        if (in_array("seo", $columns)) {
            $multilingual_seo = $this->config->get('aqe_multilingual_seo');
            if ($multilingual_seo) {
                $sql .= ", (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('product_id=', p.product_id) AND (" . $this->db->escape($multilingual_seo) . " IS NULL OR " . $this->db->escape($multilingual_seo) . " = '" . (int)$this->config->get('config_language_id') . "') ORDER BY " . $this->db->escape($multilingual_seo) . " DESC LIMIT 1) AS seo";
            } else {
                $sql .= ", (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('product_id=', p.product_id) LIMIT 1) AS seo";
            }
        }

        if (in_array("manufacturer", $columns)) {
            $sql .= ", m.name AS manufacturer_text";
        }

        if (in_array("tax_class", $columns)) {
            $sql .= ", tc.title AS tax_class_text, tc.tax_class_id";
        }

        if (in_array("stock_status", $columns)) {
            $sql .= ", ss.name AS stock_status_text, ss.stock_status_id";
        }

        if (in_array("length_class", $columns)) {
            $sql .= ", lcd.title AS length_class_text, lcd.length_class_id";
        }

        if (in_array("weight_class", $columns)) {
            $sql .= ", wcd.title AS weight_class_text, wcd.weight_class_id";
        }

        if (in_array("tag", $columns) && defined('VERSION') && version_compare(VERSION, '1.5.4', '<')) {
            $sql .= ", GROUP_CONCAT(DISTINCT pt.tag ORDER BY pt.tag ASC SEPARATOR ', ') AS tag";
        }

        if (in_array("download", $columns)) {
            $sql .= ", GROUP_CONCAT(DISTINCT dd.name ORDER BY dd.name ASC SEPARATOR '<br/>') AS download_text, GROUP_CONCAT(DISTINCT dd.download_id ORDER BY dd.name ASC SEPARATOR '_') AS download";
        }

        if (in_array("filter", $columns)) {
            $sql .= ", GROUP_CONCAT(DISTINCT CONCAT_WS(' &gt; ', fgd.name, fd.name) ORDER BY CONCAT_WS(' &gt; ', fgd.name, fd.name) ASC SEPARATOR '<br/>') AS filter_text, GROUP_CONCAT(DISTINCT fd.filter_id ORDER BY CONCAT_WS(' &gt; ', fgd.name, fd.name) ASC SEPARATOR '_') AS filter";
        }

        if (in_array("category", $columns)) {
            $sql .= ", GROUP_CONCAT(DISTINCT cat.name ORDER BY cat.name ASC SEPARATOR '<br/>') AS category_text, GROUP_CONCAT(DISTINCT cat.category_id ORDER BY cat.name ASC SEPARATOR '_') AS category";
        }

        if (in_array("store", $columns)) {
            $sql .= ", GROUP_CONCAT(DISTINCT IF(p2s.store_id = 0, '" . $this->db->escape($this->config->get('config_name')) . "', s.name) SEPARATOR '<br/>') AS store_text, GROUP_CONCAT(DISTINCT p2s.store_id SEPARATOR '_') AS store";
        }

        if (in_array("view_in_store", $columns)) {
            $sql .= ", GROUP_CONCAT(DISTINCT p2s.store_id SEPARATOR '_') AS store_ids";
        }

        $sql .= " FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "')";

        if (!empty($data['filter']['special_price']) && in_array($data['filter']['special_price'], array("active", "expired", "future"))) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_special ps ON (ps.product_id = p.product_id)";
        }

        if (in_array("manufacturer", $columns)) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "manufacturer m ON (m.manufacturer_id = p.manufacturer_id)";
        }

        if (in_array("category", $columns)) {
            if (defined('VERSION') && version_compare(VERSION, '1.5.5', '<')) {
                $this->db->query("DROP FUNCTION IF EXISTS GetCategoryPath");
                $this->db->query("CREATE FUNCTION GetCategoryPath (ParentID INT, ParentName VARCHAR(1024)) RETURNS VARCHAR(1024)
                    DETERMINISTIC
                    BEGIN
                        DECLARE ret VARCHAR(1024);
                        DECLARE sep VARCHAR(10);
                        DECLARE cat_id INT;
                        DECLARE cat_name VARCHAR(1024);

                        SET ret = ParentName;
                        SET sep = ' &gt; ';
                        SET cat_id = ParentID;
                        SET cat_name = '';
                        WHILE cat_id > 0 DO
                            SELECT IFNULL(parent_id,-1), IFNULL(name,'') INTO cat_id, cat_name FROM
                            (SELECT parent_id, name FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.parent_id = cd.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "') WHERE c.category_id = cat_id) A;
                            IF cat_id > 0 THEN
                                SET ret = CONCAT(cat_name,sep,ret);
                            END IF;
                        END WHILE;
                        RETURN ret;
                    END ;");

                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) LEFT JOIN (SELECT c.category_id, GetCategoryPath(c.category_id, cd.name) AS name FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "')) AS cat ON (p2c.category_id = cat.category_id)";
            } else {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) LEFT JOIN (SELECT cp.category_id AS category_id, GROUP_CONCAT(cd1.name ORDER BY cp.level SEPARATOR ' &gt; ') AS name FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "category c ON (cp.path_id = c.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd1 ON (c.category_id = cd1.category_id) LEFT JOIN " . DB_PREFIX . "category_description cd2 ON (cp.category_id = cd2.category_id) WHERE cd1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND cd2.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY cp.category_id ORDER BY name) AS cat ON (p2c.category_id = cat.category_id)";
            }
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c2 ON (p.product_id = p2c2.product_id)";
        }

        if (in_array("tag", $columns) && defined('VERSION') && version_compare(VERSION, '1.5.4', '<')) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_tag pt ON (p.product_id = pt.product_id AND pt.language_id = '" . (int)$this->config->get('config_language_id') . "')";
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_tag pt2 ON (p.product_id = pt2.product_id AND pt2.language_id = '" . (int)$this->config->get('config_language_id') . "')";
        }

        if (in_array("filter", $columns)) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_filter p2f ON (p.product_id = p2f.product_id) LEFT JOIN " . DB_PREFIX . "filter f ON (f.filter_id = p2f.filter_id) LEFT JOIN " . DB_PREFIX . "filter_description fd ON (fd.filter_id = p2f.filter_id AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "') LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (f.filter_group_id = fgd.filter_group_id AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "')";
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_filter p2f2 ON (p.product_id = p2f2.product_id)";
        }

        if (in_array("download", $columns)) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_download p2d ON (p.product_id = p2d.product_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (dd.download_id = p2d.download_id AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "')";
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_download p2d2 ON (p.product_id = p2d2.product_id)";
        }

        if (in_array("store", $columns)) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "store s ON (s.store_id = p2s.store_id)";
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s2 ON (p.product_id = p2s2.product_id)";
        } else if (in_array("view_in_store", $columns)) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)";
        }

        if (in_array("tax_class", $columns)) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "tax_class tc ON (tc.tax_class_id = p.tax_class_id)";
        }

        if (in_array("stock_status", $columns)) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "stock_status ss ON (ss.stock_status_id = p.stock_status_id)";
        }

        if (in_array("length_class", $columns)) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "length_class lc ON (lc.length_class_id = p.length_class_id) LEFT JOIN " . DB_PREFIX . "length_class_description lcd ON (lcd.length_class_id = lc.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "')";
        }

        if (in_array("weight_class", $columns)) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "weight_class wc ON (wc.weight_class_id = p.weight_class_id) LEFT JOIN " . DB_PREFIX . "weight_class_description wcd ON (wcd.weight_class_id = wc.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "')";
        }

        $filters = array('AND' => array(), 'OR' => array());

        // Global search
        if (!empty($data['search']) && !in_array("download", $columns) && !in_array("store", $columns) && !in_array("category", $columns) && !in_array("filter", $columns) && !(in_array("tag", $columns) && defined('VERSION') && version_compare(VERSION, '1.5.4', '<'))) {
            $_filters = array(
                'tax_class'         => 'tc.title',
                'length_class'      => 'lcd.title',
                'weight_class'      => 'wcd.title',
                'manufacturer'      => 'm.name',
                'stock_status'      => 'ss.name',
                'subtract'          => "IF(p.subtract, '" . $this->db->escape($this->language->get('text_yes')) . "','" .$this->db->escape($this->language->get('text_no')) . "')",
                'id'                => 'p.product_id',
                'status'            => "IF(p.status, '" . $this->db->escape($this->language->get('text_enabled')) . "','" .$this->db->escape($this->language->get('text_disabled')) . "')",
                'shipping'          => "IF(p.shipping, '" . $this->db->escape($this->language->get('text_yes')) . "','" .$this->db->escape($this->language->get('text_no')) . "')",
                'date_added'        => 'p.date_added',
                'date_available'    => 'p.date_available',
                'date_modified'     => 'p.date_modified',
                'length'            => 'p.length',
                'width'             => 'p.width',
                'height'            => 'p.height',
                'weight'            => 'p.weight',
                'price'             => 'p.price',
                'quantity'          => 'p.quantity',
                'minimum'           => 'p.minimum',
                'points'            => 'p.points',
                'sort_order'        => 'p.sort_order',
                'sku'               => 'p.sku',
				'cost'               => 'p.cost',
                'upc'               => 'p.upc',
                'ean'               => 'p.ean',
                'jan'               => 'p.jan',
                'isbn'              => 'p.isbn',
                'mpn'               => 'p.mpn',
                'location'          => 'p.location',
                'name'              => 'pd.name',
                'model'             => 'p.model',
                'tag'               => 'pd.tag',
                'viewed'            => 'p.viewed',
                'seo'               => "(SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('product_id=', p.product_id))",
            );

            foreach ($columns as $column) {
                if (isset($_filters[$column])) {
                    $filters['OR'][] = $_filters[$column] . " LIKE '%" . $this->db->escape($data["search"]) . "%'";
                }
            }
        }

        $int_filters = array(
            'tax_class'         => 'p.tax_class_id',
            'length_class'      => 'p.length_class_id',
            'weight_class'      => 'p.weight_class_id',
            'manufacturer'      => 'p.manufacturer_id',
            'stock_status'      => 'p.stock_status_id',
            'subtract'          => 'p.subtract',
            'id'                => 'p.product_id',
            'status'            => 'p.status',
            'shipping'          => 'p.shipping',
            );

        foreach ($int_filters as $key => $value) {
            if (isset($data["filter"][$key]) && !is_null($data["filter"][$key])) {
                $filters['AND'][] = "$value = '" . (int)$data["filter"][$key] . "'";
            }
        }

        $date_filters = array(
            'date_added'        => 'p.date_added',
            'date_available'    => 'p.date_available',
            'date_modified'     => 'p.date_modified',
            );

        foreach ($date_filters as $key => $value) {
            if (isset($data["filter"][$key]) && !is_null($data["filter"][$key])) {
                $filters['AND'][] = $this->filterInterval($this->db->escape($data["filter"][$key]), $value, true);
            }
        }

        $float_interval_filters = array(
            'length'    => 'p.length',
            'width'     => 'p.width',
            'height'    => 'p.height',
            'weight'    => 'p.weight',
            'price'     => 'p.price',
            );

        foreach ($float_interval_filters as $key => $value) {
            if ($key == "price" && !empty($data['filter']['special_price']) && in_array($data['filter']['special_price'], array("active", "expired", "future"))) {
                if ($data['filter']['special_price'] == "active") {
                    $filters['AND'][] = "((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))";
                } elseif ($data['filter']['special_price'] == "expired") {
                    $filters['AND'][] = "(ps.date_end != '0000-00-00' AND ps.date_end < NOW())";
                } elseif ($data['filter']['special_price'] == "future") {
                    $filters['AND'][] = "(ps.date_start > NOW() AND ps.date_start != '0000-00-00')";
                }
            } else {
                if (isset($data["filter"][$key]) && !is_null($data["filter"][$key])) {
                    $filters['AND'][] = $this->filterInterval($data["filter"][$key], $value);
                }
            }
        }

        $int_interval_filters = array(
            'quantity'      => 'p.quantity',
            'minimum'       => 'p.minimum',
            'points'        => 'p.points',
            'sort_order'    => 'p.sort_order',
            'viewed'        => 'p.viewed',
            );

        foreach ($int_interval_filters as $key => $value) {
            if (isset($data["filter"][$key]) && !is_null($data["filter"][$key])) {
                $filters['AND'][] = $this->filterInterval($data["filter"][$key], $value);
            }
        }

        $anywhere_filters = array(
            'sku'       => 'p.sku',
			'cost'       => 'p.cost',
            'upc'       => 'p.upc',
            'ean'       => 'p.ean',
            'jan'       => 'p.jan',
            'isbn'      => 'p.isbn',
            'mpn'       => 'p.mpn',
            'location'  => 'p.location',
            'name'      => 'pd.name',
            'model'     => 'p.model',
			
            );

        if (defined('VERSION') && version_compare(VERSION, '1.5.4', '>=')) {
           $anywhere_filters['tag'] = 'pd.tag' ;
        } else {
           $anywhere_filters['tag'] = 'pt2.tag' ;
        }

        foreach ($anywhere_filters as $key => $value) {
            if (!empty($data["filter"][$key])) {
                $filters['AND'][] = "$value LIKE '%" . $this->db->escape($data["filter"][$key]) . "%'";
            }
        }

        if (!empty($data['filter']['seo'])) {
            $filters['AND'][] = "(SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('product_id=', p.product_id)) LIKE '%" . $this->db->escape($data['filter']['seo']) . "%'";
        }

        if (isset($data['filter']['store'])) {
            if ($data['filter']['store'] == '*') {
                $filters['AND'][] = "p2s2.store_id IS NULL";
            } else {
                $filters['AND'][] = "p2s2.store_id = '" . (int)$data['filter']['store'] . "'";
            }
        }

        if (isset($data['filter']['download'])) {
            if ($data['filter']['download'] == '*') {
                $filters['AND'][] = "p2d2.download_id IS NULL";
            } else {
                $filters['AND'][] = "p2d2.download_id = '" . (int)$data['filter']['download'] . "'";
            }
        }

        if (isset($data['filter']['filter'])) {
            if ($data['filter']['filter'] == '*') {
                $filters['AND'][] = "p2f2.filter_id IS NULL";
            } else {
                $filters['AND'][] = "p2f2.filter_id = '" . (int)$data['filter']['filter'] . "'";
            }
        }

        if (!empty($data['filter']['category'])) {
            if ($this->config->get('aqe_filter_sub_category')) {
                $implode_data = array();

                if ($data['filter']['category'] == '*')
                    $implode_data[] = "p2c2.category_id IS NULL";
                else
                    $implode_data[] = "p2c2.category_id = '" . (int)$data['filter']['category'] . "'";

                if (defined('VERSION') && version_compare(VERSION, '1.5.5', '<')) {
                    $this->db->query("DROP FUNCTION IF EXISTS GetSubCategories");
                    $this->db->query("CREATE FUNCTION GetSubCategories (ParentID INT) RETURNS varchar(1024) CHARSET utf8
                        DETERMINISTIC
                        BEGIN
                            DECLARE rv,q,queue,queue_children VARCHAR(1024);
                            DECLARE queue_length,front_id,pos INT;

                            SET rv = '';
                            SET queue = ParentID;
                            SET queue_length = 1;

                            WHILE queue_length > 0 DO
                                SET front_id = FORMAT(queue,0);
                                IF queue_length = 1 THEN
                                    SET queue = '';
                                ELSE
                                    SET pos = LOCATE(',',queue) + 1;
                                    SET q = SUBSTR(queue,pos);
                                    SET queue = q;
                                END IF;
                                SET queue_length = queue_length - 1;

                                SELECT IFNULL(qc,'') INTO queue_children
                                FROM (SELECT GROUP_CONCAT(category_id) qc
                                FROM " . DB_PREFIX . "category WHERE parent_id = front_id) A;

                                IF LENGTH(queue_children) = 0 THEN
                                    IF LENGTH(queue) = 0 THEN
                                        SET queue_length = 0;
                                    END IF;
                                ELSE
                                    IF LENGTH(rv) = 0 THEN
                                        SET rv = queue_children;
                                    ELSE
                                        SET rv = CONCAT(rv,',',queue_children);
                                    END IF;
                                    IF LENGTH(queue) = 0 THEN
                                        SET queue = queue_children;
                                    ELSE
                                        SET queue = CONCAT(queue,',',queue_children);
                                    END IF;
                                    SET queue_length = LENGTH(queue) - LENGTH(REPLACE(queue,',','')) + 1;
                                END IF;
                            END WHILE;
                            RETURN rv;
                        END ;");
                    $categories = $this->db->query("SELECT GetSubCategories(" . (int)$data['filter']['category'] . ") AS subcategories");
                    $implode_data[] = "p2c2.category_id IN (" . $categories->row['subcategories'] . ")";
                } else {
                    $implode_data[] = "p2c2.category_id IN (SELECT DISTINCT category_id FROM " . DB_PREFIX . "category_path WHERE path_id = '" . (int)$data['filter']['category'] . "')";
                }

                $filters['AND'][] = "(" . implode(' OR ', $implode_data) . ")";
            } else {
                if ($data['filter']['category'] == '*') {
                    $filters['AND'][] = "p2c2.category_id IS NULL";
                } else {
                    $filters['AND'][] = "p2c2.category_id = '" . (int)$data['filter']['category'] . "'";
                }
            }
        }

        if ($filters['AND'] || $filters['OR']) {
            $sql .= " WHERE";

            if ($filters['OR']) {
                $sql .= " (" . implode(" OR ", $filters['OR']) . ")";
            }

            if ($filters['AND']) {
                $sql .= " " . implode(" AND ", $filters['AND']);
            }
        }

        $sql .= " GROUP BY p.product_id";

        $filters = array('AND' => array(), 'OR' => array());

        // Global search
        if (!empty($data['search']) && (in_array("download", $columns) || in_array("store", $columns) || in_array("category", $columns) || in_array("filter", $columns) || (in_array("tag", $columns) && defined('VERSION') && version_compare(VERSION, '1.5.4', '<')))) {
            $_filters = array(
                'tax_class'         => 'tc.title',
                'length_class'      => 'lcd.title',
                'weight_class'      => 'wcd.title',
                'manufacturer'      => 'm.name',
                'stock_status'      => 'ss.name',
                'subtract'          => 'subtract_text',
                'id'                => 'p.product_id',
                'status'            => 'status_text',
                'shipping'          => 'shipping_text',
                'date_added'        => 'p.date_added',
                'date_available'    => 'p.date_available',
                'date_modified'     => 'p.date_modified',
                'length'            => 'p.length',
                'width'             => 'p.width',
                'height'            => 'p.height',
                'weight'            => 'p.weight',
                'price'             => 'p.price',
                'quantity'          => 'p.quantity',
                'minimum'           => 'p.minimum',
                'points'            => 'p.points',
                'sort_order'        => 'p.sort_order',
                'sku'               => 'p.sku',
				'cost'               => 'p.cost',
                'upc'               => 'p.upc',
                'ean'               => 'p.ean',
                'jan'               => 'p.jan',
                'isbn'              => 'p.isbn',
                'mpn'               => 'p.mpn',
                'location'          => 'p.location',
                'name'              => 'pd.name',
                'model'             => 'p.model',
                'download'          => "GROUP_CONCAT(DISTINCT dd.name SEPARATOR ' ')",
                'filter'            => "GROUP_CONCAT(DISTINCT fd.name SEPARATOR ' ')",
                'category'          => "GROUP_CONCAT(DISTINCT cat.name SEPARATOR ' ')",
                'tag'               => 'pd.tag',
                'store'             => "GROUP_CONCAT(DISTINCT IF(p2s.store_id = 0, '" . $this->db->escape($this->config->get('config_name')) . "', s.name) SEPARATOR ' ')",
                'viewed'            => 'p.viewed',
                'seo'               => "(SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('product_id=', p.product_id))",
            );

            if (in_array("tag", $columns) && defined('VERSION') && version_compare(VERSION, '1.5.4', '<')) {
                $_filters['tag'] = "GROUP_CONCAT(DISTINCT pt.tag SEPARATOR ' ')";
            }

            foreach ($columns as $column) {
                if (isset($_filters[$column])) {
                    $filters['OR'][] = $_filters[$column] . " LIKE '%" . $this->db->escape($data["search"]) . "%'";
                }
            }
        }

        if ($filters['AND'] || $filters['OR']) {
            $sql .= " HAVING";

            if ($filters['OR']) {
                $sql .= " (" . implode(" OR ", $filters['OR']) . ")";
            }

            if ($filters['AND']) {
                $sql .= " " . implode(" AND ", $filters['AND']);
            }
        }

        $sort = array();
        foreach ($data['sort'] as $idx => $value) {
            $sort[] = $this->db->escape($value['column']) . ' ' . $this->db->escape($value['order']);
        }

        if ($sort) {
            $sql .= " ORDER BY " . implode(", ", $sort);
        } else {
            $sql .= " ORDER BY pd.name ASC";
        }

        if ($data['start'] != '' || $data['limit'] != '') {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        $count = $this->db->query("SELECT FOUND_ROWS() AS count");
        $this->productCount = ($count->num_rows) ? (int)$count->row['count'] : 0;

        return $query->rows;
    }

    public function getFilteredTotalProducts() {
        return $this->productCount;
    }

    public function getTotalProducts() {
        $sql = "SELECT COUNT(product_id) AS total FROM " . DB_PREFIX . "product";

        $count = $this->cache->get('products.total');

        if (is_null($count)) {
            $query = $this->db->query($sql);

            $count = (int)$query->row['total'];

            $this->cache->set('products.total', $count);
        }

        return $count;
    }

    public function filterKeywords($key, $value) {
        $data = array();

        if ($key == "seo") {
            $query = $this->db->query("SELECT DISTINCT(keyword) AS seo FROM " . DB_PREFIX . "url_alias WHERE keyword LIKE '%" . $this->db->escape($value) . "%' AND query LIKE 'product_id=%' ORDER BY keyword ASC");
        } else {
            $query = $this->db->query("SELECT DISTINCT(" . $this->db->escape($key) . ") FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "') WHERE " . $this->db->escape($key) . " LIKE '%" . $this->db->escape($value) . "%' ORDER BY " . $this->db->escape($key) . " ASC");
        }

        foreach ($query->rows as $result) {
            if (isset($result[$key])) {
                $data[] = $result[$key];
            }
        }

        return $data;
    }

    public function getProductSeoKeywords($product_id) {
        $data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('product_id=', '" . (int)$product_id . "')");

        $multilingual_seo = $this->config->get('aqe_multilingual_seo');

        foreach ($query->rows as $result) {
            $lang = isset($result[$multilingual_seo]) ? $result[$multilingual_seo] : (isset($result['language_id']) ? $result['language_id'] : null);
            if ($lang) {
                $data[$lang] = $result['keyword'];
            }
        }

        return $data;
    }

    public function quickEditProduct($product_id, $column, $value, $data = null) {
        $result = false;

        if (in_array($column, array('image', 'model', 'sku','cost', 'upc', 'ean', 'jan', 'mpn', 'isbn', 'location', 'date_available', 'date_added')))
            $result = $this->db->query("UPDATE " . DB_PREFIX . "product SET " . $column . " = '" . $this->db->escape($value) . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
        else if (in_array($column, array('quantity', 'sort_order', 'status', 'minimum', 'subtract', 'shipping', 'points', 'viewed')))
            $result = $this->db->query("UPDATE " . DB_PREFIX . "product SET " . $column . " = '" . (int)$value . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
        else if (in_array($column, array('manufacturer', 'tax_class', 'stock_status', 'length_class', 'weight_class')))
            $result = $this->db->query("UPDATE " . DB_PREFIX . "product SET " . $column . "_id = '" . (int)$value . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
        else if (in_array($column, array('price', 'length', 'width', 'height', 'weight')))
            $result = $this->db->query("UPDATE " . DB_PREFIX . "product SET " . $column . " = '" . (float)$value . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
        else if ($column == 'seo') {
            $multilingual_seo = $this->config->get('aqe_multilingual_seo');
            $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id. "'");

            if ($multilingual_seo) {
                foreach ((array)$value as $v) {
                    if (!empty($v['value'])) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($v['value']) . "', " . $this->db->escape($multilingual_seo) . " = '" . (int)$v['lang'] . "'");
                    }
                }
                $result = 1;
            } else if (!empty($value))
                $result = $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($value) . "'");
            else
                $result = 1;
        } else if (in_array($column, array('name', 'tag'))) {
            if ($column == 'tag' && defined('VERSION') && version_compare(VERSION, '1.5.4', '<')) {
                $this->db->query("DELETE FROM " . DB_PREFIX . "product_tag WHERE product_id = '" . (int)$product_id . "'");
            }

            if (isset($data['value']) && is_array($data['value'])) {
                foreach ((array)$data['value'] as $value) {
                    if ($column == 'tag' && defined('VERSION') && version_compare(VERSION, '1.5.4', '<')) {
                        $tags = explode(',', $value['value']);

                        foreach ($tags as $tag) {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_tag SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$value['lang'] . "', tag = '" . $this->db->escape(trim($tag)) . "'");
                        }
                    } else {
                        $this->db->query("UPDATE " . DB_PREFIX . "product_description SET " . $column . " = '" . $this->db->escape($value['value']) . "' WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$value['lang'] . "'");
                    }
                }
                $result = 1;
            } else {
                $result = 0;
            }
        } else if ($column == 'category') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

            foreach ((array)$value as $category_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
            }
            $result = 1;
        } else if ($column == 'store') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

            foreach ((array)$value as $store_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
            }
            $result = 1;
        } else if ($column == 'filter') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");

            foreach ((array)$value as $filter_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
            }
            $result = 1;
        } else if ($column == 'download') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int)$product_id . "'");

            foreach ((array)$value as $download_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
            }
            $result = 1;
        } else if ($column == 'attributes') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");

            if (!empty($value['product_attribute'])) {
                foreach ((array)$value['product_attribute'] as $product_attribute) {
                    if ($product_attribute['attribute_id']) {
                        foreach ($product_attribute['value'] as $language_id => $value) {
                            $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($value) . "'");
                        }
                    }
                }
            }
            $result = 1;
        } else if ($column == 'discounts') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "'");

            if (isset($value['product_discount'])) {
                foreach ((array)$value['product_discount'] as $product_discount) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
                }
            }
            $result = 1;
        } else if ($column == 'specials') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");

            if (isset($value['product_special'])) {
                foreach ((array)$value['product_special'] as $product_special) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
                }
            }
            $result = 1;
        } else if ($column == 'filters') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int)$product_id . "'");

            if (isset($value['product_filter'])) {
                foreach ((array)$value['product_filter'] as $filter_id) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
                }
            }
            $result = 1;
        } else if ($column == 'profiles') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_profile WHERE product_id = '" . (int)$product_id . "'");

            $inserted = array();
            if (isset($value['product_profile'])) {
                foreach ((array)$value['product_profile'] as $product_profile) {
                    if (!in_array($product_profile['customer_group_id'] . "-" . $product_profile['profile_id'], $inserted)) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_profile SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_profile['customer_group_id'] . "', profile_id = '" . (int)$product_profile['profile_id'] . "'");
                        $inserted[] = $product_profile['customer_group_id'] . "-" . $product_profile['profile_id'];
                    }
                }
            }
            $result = 1;
        } else if ($column == 'related') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int)$product_id . "'");

            if (isset($value['product_related'])) {
                foreach ((array)$value['product_related'] as $related_id) {
                    // $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
                    // $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
                }
            }
            $result = 1;
        } else if ($column == 'descriptions') {
            foreach ((array)$value['product_description'] as $language_id => $value) {
                $this->db->query("UPDATE " . DB_PREFIX . "product_description SET description = '" . $this->db->escape($value['description']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "' WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$language_id . "'");
            }
            $result = 1;
        } else if ($column == 'images') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

            if (isset($value['product_image'])) {
                foreach ((array)$value['product_image'] as $product_image) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape(html_entity_decode($product_image['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
                }
            }
            $result = 1;
        } else if ($column == 'options') {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");

            if (isset($value['product_option'])) {
                foreach ((array)$value['product_option'] as $product_option) {
                    if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");

                        $product_option_id = $this->db->getLastId();

                        if (isset($product_option['product_option_value'])) {
                            foreach ((array)$product_option['product_option_value'] as $product_option_value) {
                                $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "', product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
                            }
                        }
                    } else {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value = '" . $this->db->escape($product_option['option_value']) . "', required = '" . (int)$product_option['required'] . "'");
                    }
                }
            }
            $result = 1;
        }

        $this->cache->delete('product');

        return $result;
    }

    public function urlAliasExists($product_id, $keyword, $lang_id=null) {
        if (!$keyword) return false;

        $multilingual_seo = $this->config->get('aqe_multilingual_seo');
        if ($lang_id && $multilingual_seo) {
            $query = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "' AND query <> 'product_id=" . (int)$product_id . "'");
            //$query = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "' AND " . $this->db->escape($multilingual_seo) . " = '" . (int)$lang_id . "' AND query <> 'product_id=" . (int)$product_id . "'");
        } else {
            $query = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "' AND query <> 'product_id=" . (int)$product_id . "'");
        }

        if ($query->row) {
            return true;
        } else {
            return false;
        }
    }

    public function filterInterval($filter, $field, $date=false) {
        if ($date) {
            if (preg_match('/^(!=|<>)\s*(\d{2,4}-\d{1,2}-\d{1,2})$/', html_entity_decode(trim($filter)), $matches) && count($matches) == 3) {
                return "DATE($field) <> DATE('" . $matches[2] . "')";
            } else if (preg_match('/^(\d{2,4}-\d{1,2}-\d{1,2})\s*(<|<=)\s*(\d{2,4}-\d{1,2}-\d{1,2})$/', html_entity_decode(trim($filter)), $matches) && count($matches) == 4 && strtotime($matches[1]) <= strtotime($matches[3])) {
                return "DATE('" . $matches[1] . "') ${matches[2]} DATE($field) AND DATE($field) ${matches[2]} DATE('" . $matches[3] . "')";
            } else if (preg_match('/^(\d{2,4}-\d{1,2}-\d{1,2})\s*(>|>=)\s*(\d{2,4}-\d{1,2}-\d{1,2})$/', html_entity_decode(trim($filter)), $matches) && count($matches) == 4 && strtotime($matches[1]) >= strtotime($matches[3])) {
                return "DATE('" . $matches[1] . "') ${matches[2]} DATE($field) AND DATE($field) ${matches[2]} DATE('" . $matches[3] . "')";
            } else if (preg_match('/^(<|<=|>|>=)\s*(\d{2,4}-\d{1,2}-\d{1,2})$/', html_entity_decode(trim($filter)), $matches) && count($matches) == 3) {
                return "DATE($field) ${matches[1]} DATE('" . $matches[2] . "')";
            } else if (preg_match('/^(\d{2,4}-\d{1,2}-\d{1,2})\s*(>|>=|<|<=)$/', html_entity_decode(trim($filter)), $matches) && count($matches) == 3) {
                return "DATE('" . $matches[1] . "') ${matches[2]} DATE($field)";
            } else {
                return "DATE(${field}) = DATE('${filter}')";
            }
        } else {
            if (preg_match('/^(!=|<>)\s*(-?\d+\.?\d*)$/', html_entity_decode(trim(str_replace(",", ".", $filter))), $matches) && count($matches) == 3) {
                return "$field <> '" . (float)$matches[2] . "'";
            } else if (preg_match('/^(-?\d+\.?\d*)\s*(<|<=)\s*(-?\d+\.?\d*)$/', html_entity_decode(trim(str_replace(",", ".", $filter))), $matches) && count($matches) == 4 && (float)$matches[1] <= (float)$matches[3]) {
                return "'" . (float)$matches[1] . "' ${matches[2]} $field AND $field ${matches[2]} '" . (float)$matches[3] . "'";
            } else if (preg_match('/^(-?\d+\.?\d*)\s*(>|>=)\s*(-?\d+\.?\d*)$/', html_entity_decode(trim(str_replace(",", ".", $filter))), $matches) && count($matches) == 4 && (float)$matches[1] >= (float)$matches[3]) {
                return "'" . (float)$matches[1] . "' ${matches[2]} $field AND $field ${matches[2]} '" . (float)$matches[3] . "'";
            } else if (preg_match('/^(<|<=|>|>=)\s*(-?\d+\.?\d*)$/', html_entity_decode(trim(str_replace(",", ".", $filter))), $matches) && count($matches) == 3) {
                return "$field ${matches[1]} '" . (float)$matches[2] . "'";
            } else if (preg_match('/^(-?\d+\.?\d*)\s*(>|>=|<|<=)$/', html_entity_decode(trim(str_replace(",", ".", $filter))), $matches) && count($matches) == 3) {
                return "'" . (float)$matches[1] . "' ${matches[2]} $field";
            } else {
                return $field . " = '" . (int)$filter . "'";
            }
        }
    }
}
?>
