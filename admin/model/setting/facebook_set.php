<?php
class ModelSettingFacebookSet extends Model {

	public function createTable(){
		$sql= "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "social_media_user (
		`social_media_user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`type` varchar(255) NOT NULL,
		`user_id` int(11) NOT NULL,
		`social_media_id` varchar(255) NOT NULL,
		`from` varchar(255) NOT NULL,
		PRIMARY KEY (`social_media_user_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		
		$query = $this->db->query($sql);
	}
}
?>