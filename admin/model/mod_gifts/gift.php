<?php 

/**
 * Gifts
 * 
 * @author marsilea15 <marsilea15@gmail.com> 
 */
class ModelModGiftsGift extends Model {
	
	/**
	 * Dodaj dodatkowe informacje o grupie
	 * 
	 * @param int $group_id
	 * @param array $desc
	 */
	private function _addGroupDescription( $group_id, $desc ) {
		foreach( $desc as $language_id => $value ) {
			$this->db->query("
				INSERT INTO
					" . DB_PREFIX . "mod_gift_group_description
				SET
					group_id = " . (int) $group_id . ",
					language_id = " . (int) $language_id . ",
					name = " . ( empty( $value['name'] ) ? 'NULL' : "'" . $this->db->escape( $value['name'] ) . "'" ) . ",
					description = " . ( empty( $value['description'] ) ? 'NULL' : "'" . $this->db->escape( $value['description'] ) . "'" ) . ",
					notification = " . ( empty( $value['notification'] ) ? 'NULL' : "'" . $this->db->escape( $value['notification'] ) . "'" ) . "
			");
		}
	}
	
	/**
	 * Dodaj elementy grupy
	 * 
	 * @param int $group_id
	 * @param array $group_item
	 */
	private function _addGroupItem( $group_id, $group_item ) {
		foreach( $group_item as $gift_id )
			$this->db->query("
				INSERT INTO 
					" . DB_PREFIX . "mod_gift_group_item
				SET
					group_id = " . (int) $group_id . ",
					gift_id = " . (int) $gift_id . "
			");
	}
	
	/**
	 * Dodaj nowy prezent
	 * 
	 * @param array $data
	 */
	public function addGift( $data ) {
		$this->db->query("
			INSERT INTO
				" . DB_PREFIX . "mod_gift
			SET
				sort_order = '" . (int) $data['sort_order'] . "',
				status = '" . (int) $data['status'] . "',
				product_id = '" . (int) $data['product_id'] . "'
		");
		
		$this->cache->delete('mod_gifts_gift');
	}
	
	/**
	 * Dodaj grupę
	 * 
	 * @param array $data
	 */
	public function addGroup( $data ) {
		$this->db->query("
			INSERT INTO
				" . DB_PREFIX . "mod_gift_group
			SET
				amount = " . ( $data['amount'] ? "'" . (float) $data['amount'] . "'" : 'NULL' ) . ",
				status = '" . (int) $data['status'] . "',
				visible_on_list = '" . (int) $data['visible_on_list'] . "',
				type = '" . $this->db->escape( $data['type'] ) . "',
				items = '" . (int) $data['items'] . "'
		");
		
		$group_id	= $this->db->getLastId();
		
		$this->_addGroupItem( $group_id, $data['group_item'] );
		
		$this->_addGroupDescription( $group_id, $data['group_description'] );
		
		$this->cache->delete('mod_gifts_group');
	}
	
	/**
	 * Aktualizuj dane prezentu
	 * 
	 * @param int $gift_id
	 * @param array $data
	 */
	public function updateGift( $gift_id, $data ) {
		$this->db->query("
			UPDATE 
				" . DB_PREFIX . "mod_gift 
			SET 
				sort_order = '" . (int) $data['sort_order'] . "', 
				status = '" . (int) $data['status'] . "',
				product_id = '" . (int) $data['product_id'] . "'
			WHERE 
				gift_id = '" . (int) $gift_id . "'"
		);
		
		$this->cache->delete('mod_gifts_gift');
	}
	
	/**
	 * Aktualizuj dane grupy
	 * 
	 * @param int $group_id
	 * @param array $data
	 */
	public function updateGroup( $group_id, $data ) {
		$this->db->query("
			UPDATE 
				" . DB_PREFIX . "mod_gift_group
			SET 
				amount = " . ( $data['amount'] ? "'" . (float) $data['amount'] . "'" : 'NULL' ) . ",
				status = '" . (int) $data['status'] . "',
				visible_on_list = '" . (int) $data['visible_on_list'] . "',
				type = '" . $this->db->escape( $data['type'] ) . "',
				items = '" . (int) $data['items'] . "'
			WHERE 
				group_id = '" . (int) $group_id . "'"
		);
		
		$this->db->query("
			DELETE FROM 
				" . DB_PREFIX . "mod_gift_group_item
			WHERE 
				group_id = " . (int) $group_id
		);
		
		$this->db->query("
			DELETE FROM
				" . DB_PREFIX . "mod_gift_group_description
			WHERE
				group_id = " . (int) $group_id
		);
					
		$this->_addGroupItem( $group_id, $data['group_item'] );
		
		$this->_addGroupDescription( $group_id, $data['group_description'] );
		
		$this->cache->delete('mod_gifts_group');
	}
	
	/**
	 * Pobierz dodatkowe informacje o grupie
	 * 
	 * @param int $group_id
	 * @return array
	 */
	public function getGroupDescriptions( $group_id ) {
		$desc = array();
		
		$query = $this->db->query("
			SELECT 
				* 
			FROM 
				" . DB_PREFIX . "mod_gift_group_description 
			WHERE 
				group_id = '" . (int) $group_id . "'
		");

		foreach( $query->rows as $result ) {
			$desc[$result['language_id']] = array(
				'name'			=> $result['name'],
				'notification'	=> $result['notification'],
				'description'	=> $result['description']
			);
		}
		
		return $desc;
	}
	
	/**
	 * Pobierz listę prezentów
	 * 
	 * @param array $data
	 * @return array
	 */
	public function getGifts( $data = array() ) {
		$sql = '
			SELECT
				p.*, pd.*, g.*
			FROM
				' . DB_PREFIX . 'mod_gift g
			INNER JOIN
				' . DB_PREFIX . 'product_description pd
			ON
				g.product_id = pd.product_id
			INNER JOIN
				' . DB_PREFIX . 'product p
			ON
				p.product_id = g.product_id
			WHERE
				pd.language_id = "' . (int) $this->config->get( 'config_language_id' ) . '"
		';
		
		// SORT
		if( isset( $data['sort'] ) ) {
			// @todo
		} else {
			$sql .= ' ORDER BY pd.name';
		}
		
		// ORDER
		if( isset( $data['order'] ) && $data['order'] == 'DESC' ) {
			$sql .= ' DESC';
		} else {
			$sql .= ' ASC';
		}
		
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
			
		return $this->db->query($sql)->rows;
	}
	
	/**
	 * Pobierz listę group
	 * 
	 * @param array $data
	 * @return array
	 */
	public function getGroups( $data = array() ) {
		$sql = '
			SELECT
				gd.*, g.*
			FROM
				' . DB_PREFIX . 'mod_gift_group g
			LEFT JOIN
				' . DB_PREFIX . 'mod_gift_group_description gd
			ON
				g.group_id = gd.group_id AND gd.language_id = ' . (int) $this->config->get('config_language_id') . '
		';
		
		// SORT
		if( isset( $data['sort'] ) ) {
			// @todo
		} else {
			$sql .= ' ORDER BY g.amount';
		}
		
		// ORDER
		if( isset( $data['order'] ) && $data['order'] == 'DESC' ) {
			$sql .= ' DESC';
		} else {
			$sql .= ' ASC';
		}
		
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
			
		return $this->db->query($sql)->rows;
	}

	/**
	 * Pobierz informacje o prezencie
	 * 
	 * @param int $gift_id
	 * @return array
	 */
	public function getGift( $gift_id ) {
		return $this->db->query("
			SELECT 
				DISTINCT *
			FROM 
				" . DB_PREFIX . "mod_gift g
			LEFT JOIN
				" . DB_PREFIX . "product_description pd
			ON
				g.product_id = pd.product_id
			WHERE 
				gift_id = '" . (int) $gift_id . "' AND
				pd.language_id = '" . (int) $this->config->get( 'config_language_id' ) . "'
		")->row;
	}

	/**
	 * Pobierz informacje o grupie
	 * 
	 * @param int $group_id
	 * @return array
	 */
	public function getGroup( $group_id ) {
		return $this->db->query("
			SELECT 
				*
			FROM 
				" . DB_PREFIX . "mod_gift_group 
			WHERE 
				group_id = '" . (int) $group_id . "'
		")->row;
	}
	
	/**
	 * Pobierz listę elementów grupy
	 * 
	 * @param int $group_id
	 * @return array
	 */
	public function getGroupItems( $group_id ) {
		return $this->db->query("
			SELECT
				g.*
			FROM
				" . DB_PREFIX . "mod_gift_group_item gi
			INNER JOIN
				" . DB_PREFIX . "mod_gift g
			ON
				gi.gift_id = g.gift_id
			WHERE
				gi.group_id = '" . (int) $group_id . "'
		")->rows;
	}
	
	/**
	 * Usuń prezent
	 * 
	 * @param int $gift_id
	 */
	public function deleteGift( $gift_id ) {
		$this->db->query( "DELETE FROM " . DB_PREFIX . "mod_gift WHERE gift_id = '" . (int) $gift_id . "'" );
		$this->db->query( "DELETE FROM " . DB_PREFIX . "mod_gift_group_item WHERE gift_id = '" . (int) $gift_id . "'" );

		$this->cache->delete( 'mod_gifts_gift');
		$this->cache->delete( 'mod_gifts_group');
	}	
	
	/**
	 * Usuń grupę
	 * 
	 * @param int $group_id
	 */
	public function deleteGroup( $group_id ) {
		$this->db->query( "DELETE FROM " . DB_PREFIX . "mod_gift_group WHERE group_id = '" . (int) $group_id . "'" );
		$this->db->query( "DELETE FROM " . DB_PREFIX . "mod_gift_group_item WHERE group_id = '" . (int) $group_id . "'" );
		$this->db->query( "DELETE FROM " . DB_PREFIX . "mod_gift_group_description WHERE group_id = '" . (int) $group_id . "'" );

		$this->cache->delete( 'mod_gifts_group ');
	}
	
	/**
	 * Ilość wszystkich prezentów
	 * 
	 * @return int
	 */		
	public function getTotalGifts() {
      	$query = $this->db->query( 'SELECT COUNT(*) AS total FROM ' . DB_PREFIX . 'mod_gift' );
		
		return $query->row['total'];
	}
	
	/**
	 * Ilość wszystkich prezentów
	 * 
	 * @return int
	 */		
	public function getTotalGroupGifts() {
      	$query = $this->db->query( 'SELECT COUNT(*) AS total FROM ' . DB_PREFIX . 'mod_gift_group' );
		
		return $query->row['total'];
	}	
	
	/**
	 * Instalacja modułu
	 */
	public function install() {
		// tabela przechowująca informacje o prezentach
		$this->db->query('
			CREATE TABLE IF NOT EXISTS ' . DB_PREFIX . 'mod_gift (
				gift_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				sort_order INT(3) NOT NULL DEFAULT "0",
				status TINYINT(1) NOT NULL DEFAULT "1",
				product_id INT(11) UNSIGNED NOT NULL,
				PRIMARY KEY(gift_id)
			) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE utf8_unicode_ci
		');
		
		// tabela przechowująca informacje o wybranych prezentach w zamówieniach
		$this->db->query('
			CREATE TABLE IF NOT EXISTS ' . DB_PREFIX . 'mod_gift_order (
				gift_id INT(11) UNSIGNED NOT NULL,
				order_id INT(11) UNSIGNED NOT NULL
			) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE utf8_unicode_ci
		');
		
		// tabela przechowująca informacje o grupach prezentów
		$this->db->query('
			CREATE TABLE IF NOT EXISTS ' . DB_PREFIX . 'mod_gift_group (
				group_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				amount DOUBLE NULL DEFAULT NULL,
				status TINYINT(1) NOT NULL DEFAULT "1",
				visible_on_list TINYINT(1) NOT NULL DEFAULT "1",
				type ENUM("first_order", "every_order") NOT NULL,
				items SMALLINT(2) NULL DEFAULT NULL,
				PRIMARY KEY(group_id)
			) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE utf8_unicode_ci
		');
		
		// tabela przechowująca dodatkowe informacje dla grup
		$this->db->query('
			CREATE TABLE IF NOT EXISTS ' . DB_PREFIX . 'mod_gift_group_description (
				group_id INT(11) UNSIGNED NOT NULL,
				language_id INT(11) UNSIGNED NOT NULL,
				name VARCHAR(255) NULL,
				notification VARCHAR(255) NULL,
				description TEXT NULL
			) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE utf8_unicode_ci
		');		
		
		// tabela przechowująca informacje o elementach w grupie
		$this->db->query('
			CREATE TABLE IF NOT EXISTS ' . DB_PREFIX . 'mod_gift_group_item (
				group_id INT(11) UNSIGNED NOT NULL,
				gift_id INT(11) UNSIGNED NOT NULL
			) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE utf8_unicode_ci
		');
	}
	
	/**
	 * Deinstalacja modułu
	 */
	public function uninstall() {
		$this->db->query( 'DROP TABLE IF EXISTS ' . DB_PREFIX . 'mod_gift' );
		$this->db->query( 'DROP TABLE IF EXISTS ' . DB_PREFIX . 'mod_gift_order' );
		$this->db->query( 'DROP TABLE IF EXISTS ' . DB_PREFIX . 'mod_gift_group' );
		$this->db->query( 'DROP TABLE IF EXISTS ' . DB_PREFIX . 'mod_gift_group_description' );
		$this->db->query( 'DROP TABLE IF EXISTS ' . DB_PREFIX . 'mod_gift_group_item' );
	}
}
?>