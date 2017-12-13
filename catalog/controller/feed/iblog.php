<?php
class ControllerFeediBlog extends Controller {
	private $moduleName = 'iBlog';
	private $moduleNameSmall = 'iblog';
	private $moduleData_module = 'iblog_module';
	private $moduleModel = 'model_module_iblog';

	public function index() {
		$this->load->model('module/iblog');
		$this->load->model('tool/image');

		$iBlogSetting = $this->{$this->moduleModel}->getSetting('iBlog', $this->config->get('config_store_id'));

		if (!empty($iBlogSetting[$this->moduleName]['Enabled']) && $iBlogSetting[$this->moduleName]['Enabled'] == 'yes') {
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$server = $this->config->get('config_ssl');
			} else {
				$server = $this->config->get('config_url');
			}

			$output  = '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			$output .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
				$output .= '<channel>';
					$output .= '<atom:link href="' . $this->encode_url($this->url->link('feed/iblog')) . '" rel="self" type="application/rss+xml" />' . "\n";
					$output .= '<title>' . $this->config->get('config_name') . '</title>' . "\n";
					$output .= '<description>' . $this->config->get('config_meta_description') . '</description>' . "\n";
					$output .= '<link>' . $this->encode_url($server) . '</link>' . "\n";
					
					$guid_index = 0;

					$posts = $this->{$this->moduleModel}->getPosts();

					foreach ($posts as $post) {
						if (!empty($post)) {
							$guid = substr(md5($guid_index . 'iblog'), 0, 3);

							// Blog Post
							$output .= '<item>' . "\n";
								
								// Title
								$output .= '<title><![CDATA[' . html_entity_decode($post['title']) . ']]></title>' . "\n";

								// GUID
								$output .= '<guid isPermaLink="true"><![CDATA[';
									$output .= $this->encode_url($this->url->link('module/iblog/post', 'post_id=' . $post['iblog_post_id']), $guid);
								$output .= ']]></guid>' . "\n";

								// Link
								$output .= '<link><![CDATA[';
									$output .= $this->encode_url($this->url->link('module/iblog/post', 'post_id=' . $post['iblog_post_id']), $guid);
								$output .= ']]></link>' . "\n";

								// Description
								if (!empty($post['body'])) {
									$output .= '<description><![CDATA[' . strip_tags(html_entity_decode($post['body']), '') . ']]></description>' . "\n";
								}

								// Publication date
								if (!empty($post['created'])) {
									$output .= '<pubDate><![CDATA[' . date("D, d M Y H:i:s T", strtotime($post['created'])). ']]></pubDate>' . "\n";
								}
								
								// Last modified date
								if (!empty($post['modified'])) {
									$output .= '<lastBuildDate><![CDATA[' . date("D, d M Y H:i:s T", strtotime($post['modified'])). ']]></lastBuildDate>' . "\n";
								}

								// Image Enclosure 
								if (file_exists(DIR_IMAGE . $post['image'])) {
									$image = '<enclosure url="%s" length="%s" type="%s" />';

									$finfo = finfo_open(FILEINFO_MIME_TYPE);

									$image_url = $this->model_tool_image->resize($post['image'], 250, 250);							

									$mime_type = finfo_file($finfo, DIR_IMAGE . $post['image']);

									$image_url = str_replace(' ', '%20', $image_url);

									$image = sprintf($image, $image_url, filesize(DIR_IMAGE . $post['image']), $mime_type);
									
									$output .= $image . "\n";
								}

								// Category
								if (!empty($post['category_id'])) {
									$category = $this->{$this->moduleModel}->getCategory($post['category_id']);

									if (!empty($category)) {
										$output .= '<category><![CDATA[' . strip_tags(html_entity_decode($category['title']), '') . ']]></category>' . "\n";
									}
								}

							$output .= '</item>' . "\n";

							$guid_index++;
						}
					}

				$output .= '</channel>' . "\n";
			$output .= '</rss>' . "\n";	

			$this->response->addHeader('Content-Type: application/rss+xml');
			$this->response->setOutput($output);
		}
	}

	private function encode_url($url, $guid = false) {
		if (!empty($guid)) {
			$url = HTTP_SERVER . str_replace(HTTP_SERVER, '', $url) . '?' . $guid;
		} else {
			$url = HTTP_SERVER . str_replace(HTTP_SERVER, '', $url);
		}

		$url = str_replace(' ', '%20', $url);

		return $url;
	}
}
?>