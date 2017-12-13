<?php
class ModelToolNitroUpgrade extends ModelToolNitro {

  public function run_upgrade() {
    // NitroPack 1.4.2 -> NitroPack 1.5
    if (
        !empty($this->request->post['Nitro']['PageCache']['ClearCacheOnProductEdit']) && 
        $this->request->post['Nitro']['PageCache']['ClearCacheOnProductEdit'] == 'yes'
    ) {
        $this->update_nitro_product_cache_table();
    }
  }

  public function update_nitro_product_cache_table() {
      try {
          $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "nitro_product_cache");
          $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "nitro_category_cache");
          initNitroProductCacheDb();
      } catch (Exception $e) {}
  }
}
