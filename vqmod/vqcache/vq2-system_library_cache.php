<?php
class Cache { 
	private $expire = 3600; 

	public function get($key) {
		$files = glob(DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');

		if ($files) {
			$cache = file_get_contents($files[0]);
			
			$data = unserialize($cache);
			
			foreach ($files as $file) {
				$time = substr(strrchr($file, '.'), 1);

      			if ($time < time()) {
					if (file_exists($file)) {
						unlink($file);

				clearstatcache();
			
					}
      			}
    		}
			
			return $data;			
		}
	}

  	public function set($key, $value) {
    	$this->delete($key);

				require_once DIR_SYSTEM.'nitro/core/core.php';
				
				if (getNitroPersistence('Enabled') && getNitroPersistence('OpenCartCache.Enabled')) {
				  $nitro_expire = getNitroPersistence('OpenCartCache.ExpireTime');
				  $this->expire = !empty($nitro_expire) ? $nitro_expire : 0;
				}
			
		
		$file = DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . (time() + $this->expire);
    	
		$handle = fopen($file, 'w');

    	fwrite($handle, serialize($value));
		
    	fclose($handle);
  	}
	
  	public function delete($key) {
		$files = glob(DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');
		
		if ($files) {
    		foreach ($files as $file) {
      			if (file_exists($file)) {
					unlink($file);

				clearstatcache();
			
				}
    		}
		}
  	}
}
?>