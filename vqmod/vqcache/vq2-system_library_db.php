<?php
class DB {
	private $driver;
	
	public function __construct($driver, $hostname, $username, $password, $database) {
		if (file_exists(DIR_DATABASE . $driver . '.php')) {
			require_once(VQMod::modCheck(DIR_DATABASE . $driver . '.php'));
		} else {
			exit('Error: Could not load database file ' . $driver . '!');
		}
				
		$this->driver = new $driver($hostname, $username, $password, $database);
	}
		
  	public function query($sql) {

				require_once DIR_SYSTEM . 'nitro/lib/NitroDbCache.php';
				
				$inAdmin = basename(DIR_APPLICATION) != "catalog";
				
				if (!$inAdmin && getNitroPersistence('Enabled') && getNitroPersistence('DBCache.Enabled')) {
				  $nitro_matches = array();
				  $nitro_match = false;
				  
				  // Product COUNT Queries
				  if (getNitroPersistence('DBCache.ProductCountQueries')) $nitro_match = preg_match('~SELECT.*COUNT\(.*FROM.*[^0-9a-zA-Z_]' . DB_PREFIX . '(product)([\s]|$)~i', $sql, $nitro_matches);
				  
				  // Category COUNT Queries
				  if (!$nitro_match && getNitroPersistence('DBCache.CategoryCountQueries')) $nitro_match = preg_match('~SELECT.*COUNT\(.*FROM.*[^0-9a-zA-Z_]' . DB_PREFIX . '(category)([\s]|$)~i', $sql, $nitro_matches);
				  
				  // Category Queries
				  if (!$nitro_match && getNitroPersistence('DBCache.CategoryQueries')) $nitro_match = preg_match('~SELECT.*FROM.*[^0-9a-zA-Z_]' . DB_PREFIX . '(category)([\s]|$)~i', $sql, $nitro_matches);
				  
				  // SEO URLs Queries
				  if (!$nitro_match && getNitroPersistence('DBCache.SeoUrls')) $nitro_match = preg_match('~SELECT.*FROM.*[^0-9a-zA-Z_]' . DB_PREFIX . '(url_alias)([\s]|$)~i', $sql, $nitro_matches);
				  
				  // Search Queries
				  if (!$nitro_match && getNitroPersistence('DBCache.Search')) {
				    $nitro_match = preg_match('~SELECT.*WHERE.*(LIKE|MATCH)~i', $sql, $nitro_matches);
				    if ($nitro_match) {
				      $nitro_match = false;
				      if (getNitroPersistence('DBCache.SearchKeywords')) {
				        $nitro_keywords = explodeTrim(",", getNitroPersistence('DBCache.SearchKeywords'));
				        foreach ($nitro_keywords as $nitro_keyword) {
				          if (stripos(trim($nitro_keyword), $sql) !== FALSE) {
				            $nitro_match = true;
				            break;
				          }
				        }
				      }
				    }
				  }
				  
				  if ($nitro_match) {
				    $nitro_cache_selector = strtolower($nitro_matches[1]) . '.' . md5($sql);

				    $nitro_result = NitroDbCache::get($nitro_cache_selector);

				    if ($nitro_result !== FALSE) return $nitro_result;
				  }

				  if (!empty($nitro_cache_selector)) {
				    $nitro_db_result = $this->driver->query($sql);
				  	
				    NitroDbCache::set($nitro_cache_selector, $nitro_db_result);
				  
				    return $nitro_db_result;
				  }
				}
			
		return $this->driver->query($sql);
  	}
	
	public function escape($value) {
	   
		return $this->driver->escape($value);
	}
	
  	public function countAffected() {
		return $this->driver->countAffected();
  	}

  	public function getLastId() {
		return $this->driver->getLastId();
  	}	
}
?>