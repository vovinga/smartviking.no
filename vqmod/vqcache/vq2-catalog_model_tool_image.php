<?php
class ModelToolImage extends Model {
	/**
	*	
	*	@param filename string
	*	@param width 
	*	@param height
	*	@param type char [default, w, h]
	*				default = scale with white space, 
	*				w = fill according to width, 
	*				h = fill according to height
	*	
	*/

                public function cdn_rewrite($host_url, $new_image) {
                    require_once(DIR_SYSTEM . 'nitro/core/core.php');
                    require_once(DIR_SYSTEM . 'nitro/core/cdn.php');
                    
                    $nitro_result = nitroCDNResolve($new_image, $host_url);

                    return $nitro_result;
                }
            
	public function resize($filename, $width, $height, $type = "") {
              if (function_exists("getMobilePrefix") && function_exists("getCurrentRoute")) {
                if (!isset($_COOKIE["save_image_dimensions"])) {
                    $route = getCurrentRoute();

                    switch ($route) {
                    case "common/home":
                        $page_type = "home";
                        break;
                    case "product/category":
                        $page_type = "category";
                        break;
                    case "product/product":
                        $page_type = "product";
                        break;
                    default:
                        $page_type = "";
                        break;
                    }

                    if ($page_type) {
                        $device_type = ucfirst(trim(getMobilePrefix(true), "-"));
                        if (!$device_type) {
                            $device_type = "Desktop";
                        }

                        $overrides = getNitroPersistence('DimensionOverride.' . $page_type . '.' . $device_type);
                        if ($overrides) {
                            $isAutoDetectionEnabled = getNitroPersistence('ImageCache.DimensionAutoDetect');
                            $controller_route = $isAutoDetectionEnabled ? getCurrentRoute() : 'undefined';
                            $controller_found = false;
                            $position_route = 'undefined';
                            $position_found = false;

                            if ($isAutoDetectionEnabled) {
                                $stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
                                foreach ($stack as $func) {
                                    if (!$controller_found && !empty($func['file']) && preg_match('@catalog[_/]controller[_/](.*?).php$@', $func['file'], $matches)) {
                                        $controller_route = $matches[1];
                                        $controller_found = true;
                                    }

                                    if (!$position_found && !empty($func['file']) && preg_match('@catalog[_/]controller[_/]common[_/]((?:content_|column_).*?).php$@', $func['file'], $matches)) {
                                        $position_route = $matches[1];
                                        $position_found = true;
                                    }
                                }
                            }

                            if (!empty($overrides[$controller_route])) {
                                if (!empty($overrides[$controller_route][$position_route])) {
                                    foreach ($overrides[$controller_route][$position_route] as $override) {
                                        if ((int)$override["old"]["width"] == (int)$width && (int)$override["old"]["height"] == (int)$height) {
                                            $width = (int)$override["new"]["width"];
                                            $height = (int)$override["new"]["height"];
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $isAutoDetectionEnabled = getNitroPersistence('ImageCache.DimensionAutoDetect');
                    $controller_route = $isAutoDetectionEnabled ? getCurrentRoute() : 'undefined';
                    $controller_found = false;
                    $position_route = 'undefined';
                    $position_found = false;

                    if ($isAutoDetectionEnabled) {
                        $stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
                        foreach ($stack as $func) {
                            if (!$controller_found && !empty($func['file']) && preg_match('@catalog[_/]controller[_/](.*?).php$@', $func['file'], $matches)) {
                                $controller_route = $matches[1];
                                $controller_found = true;
                            }

                            if (!$position_found && !empty($func['file']) && preg_match('@catalog[_/]controller[_/]common[_/]((?:content_|column_).*?).php$@', $func['file'], $matches)) {
                                $position_route = $matches[1];
                                $position_found = true;
                            }
                        }

                        if (empty($GLOBALS['nitro_image_routes_log'])) {
                            $GLOBALS['nitro_image_routes_log'] = array();
                        }

                        $image_key = $filename;

                        $image_key = preg_replace('/(.*?)\.[^\.]+$/', 'cache/', $image_key) . '-' . $width . 'x' . $height;
                        if (empty($GLOBALS['nitro_image_routes_log'][$image_key])) {
                            $GLOBALS['nitro_image_routes_log'][$image_key] = array();
                        }

                        $GLOBALS['nitro_image_routes_log'][$image_key][] = array($controller_route, $position_route);
                    }
                }
              }
              
          
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return;
		} 
		

                if (isset($_COOKIE["save_image_dimensions"])) {
                    if (empty($GLOBALS["reset_session_dimensions"])) {
                        $GLOBALS["reset_session_dimensions"] = true;
                        $this->session->data["nitro_image_dimensions"] = array();
                    }

                    $dimension_string = $width . "x" . $height;
                    if (!in_array($dimension_string, $this->session->data["nitro_image_dimensions"])) {
                        $this->session->data["nitro_image_dimensions"][] = $dimension_string;
                    }
                }
            
		$info = pathinfo($filename);
		
		$extension = $info['extension'];
		
		$old_image = $filename;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . $type .'.' . $extension;
		
		
                $nitro_refresh_file = getQuickImageCacheRefreshFilename();
                $nitro_recache = (getNitroPersistence('Enabled') && getNitroPersistence('ImageCache.OverrideCompression') && is_file(DIR_IMAGE . $new_image) && is_file($nitro_refresh_file)) ? filemtime($nitro_refresh_file) > filectime(DIR_IMAGE . $new_image) : false;

                if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image)) || $nitro_recache) {
            
			$path = '';
			
			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				
				if (!file_exists(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}		
			}

			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

			
                $isNitroImageOverrideEnabled = getNitroPersistence('Enabled') && getNitroPersistence('ImageCache.OverrideCompression');
                if ($width_orig != $width || $height_orig != $height || $isNitroImageOverrideEnabled) {
                
				$image = new Image(DIR_IMAGE . $old_image);
				$image->resize($width, $height, $type);
				{ $image->save(DIR_IMAGE . $new_image);
                require_once DIR_SYSTEM . 'nitro/core/core.php';
                include NITRO_INCLUDE_FOLDER . 'smush_on_demand.php';
            }
            
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);

                require_once DIR_SYSTEM . 'nitro/core/core.php';
                include NITRO_INCLUDE_FOLDER . 'smush_on_demand.php';
            
			}
		}
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			
                $default_link = $this->config->get('config_ssl') .'image/'.$new_image;
                $cdn_link = $this->cdn_rewrite($this->config->get('config_ssl'), 'image/' . $new_image);
                if ($default_link == $cdn_link) {
                    return $this->config->get('config_ssl')  . ( isset( $seoUrlImage ) ? $seoUrlImage : 'image/' . $new_image );
                } else {
                    return $cdn_link;
                }
            
		} else {
			
                $default_link = $this->config->get('config_url') .'image/'.$new_image;
                $cdn_link = $this->cdn_rewrite($this->config->get('config_url'), 'image/' . $new_image);
                if ($default_link == $cdn_link) {
                    return $this->config->get('config_url')  . ( isset( $seoUrlImage ) ? $seoUrlImage : 'image/' . $new_image );
                } else {
                    return $cdn_link;
                }
            
		}	
	}
}
?>