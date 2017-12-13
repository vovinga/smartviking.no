<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php echo $text_message; ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?></div>

            <?php if(isset($orderDetails) && (isset($this->request->get['route']) && $this->request->get['route'] == 'checkout/success' || $this->request->get['route'] == 'quickcheckout/success') && (!$this->user->isLogged() || $this->config->get('config_ga_exclude_admin') != 1 && $this->user->isLogged())) { ?>     
           	<?php if ($this->config->get('config_ga_tracking_type') == 1) { ?>
           	<?php if ($this->config->get('config_ga_cookie') == 1) { echo '<script type="text/plain" class="cc-onconsent-analytics">';} else{echo '<script type="text/javascript">'; } ?>

              _gaq.push(['_addTrans',
                '<?php echo $orderDetails['order_id']; ?>',
                '<?php echo addslashes($orderDetails['store_name']); ?>',
                '<?php echo round($orderDetails['total'], 2); ?>',
                '<?php echo round($orderDetails['order_tax'], 2); ?>',
                '<?php echo $orderDetails['shipping_total']; ?>',
                '<?php echo $orderDetails['shipping_city']; ?>',
                '<?php echo $orderDetails['shipping_zone']; ?>',
                '<?php echo $orderDetails['shipping_country']; ?>',
              ]);

            <?php if(isset($orderProduct)) { ?>
            <?php foreach($orderProduct as $product) { ?>
                _gaq.push(['_addItem',
                "<?php echo $product['order_id']; ?>",
                <?php if(isset($product['sku'])) { ?><?php echo json_encode(html_entity_decode($product['sku'],ENT_QUOTES, 'UTF-8')); ?><?php } else { ?><?php echo json_encode(html_entity_decode($product['model'],ENT_QUOTES, 'UTF-8')); ?><?php } ?>,
                <?php echo json_encode(html_entity_decode($product['name'], ENT_QUOTES, 'UTF-8')); ?>,
                <?php echo json_encode(html_entity_decode($product['category_name'], ENT_QUOTES, 'UTF-8')); ?>,
                "<?php echo round($product['price'], 2); ?>",
                "<?php echo $product['quantity']; ?>"
              ]);
			<?php } ?>
 			<?php } ?>

			<?php if(isset($orderProductOptions)) { ?>
			<?php foreach($orderProductOptions as $product) { ?>
                _gaq.push(['_addItem',
                "<?php echo $product['order_id']; ?>",
                "<?php if(isset($product['sku'])) { ?><?php echo addslashes($product['sku']); ?><?php } else { ?><?php echo addslashes($product['model']); ?><?php } ?> - <?php echo html_entity_decode(addslashes($product['options_data']),ENT_QUOTES, 'UTF-8'); ?>",
                <?php echo json_encode(html_entity_decode($product['name'], ENT_QUOTES, 'UTF-8')); ?>,
                <?php echo json_encode(html_entity_decode($product['category_name'], ENT_QUOTES, 'UTF-8')); ?>,
                "<?php echo round($product['price'], 2); ?>",
                "<?php echo $product['quantity']; ?>"
              ]);
			<?php } ?>
			<?php } ?>
			
              _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers
              
              (function() {
              var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
              ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
              var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
              })();
            </script>  
            <?php } else if ($this->config->get('config_ga_tracking_type') == 2)  { ?>
            <?php if ($this->config->get('config_ga_cookie') == 1) { echo '<script type="text/plain" class="cc-onconsent-analytics">';} else{echo '<script>'; } ?>
            
              ga('require', 'ecommerce', 'ecommerce.js');

              ga('ecommerce:addTransaction', {
                'id': '<?php echo $orderDetails['order_id']; ?>',
                'affiliation': '<?php echo addslashes($orderDetails['store_name']); ?>',
                'revenue': '<?php echo round($orderDetails['total'], 2); ?>',
                'tax': '<?php echo round($orderDetails['order_tax'], 2); ?>',
                'shipping': '<?php echo round($orderDetails['shipping_total'], 2); ?>'
              });

            <?php if(isset($orderProduct)) { ?>
            <?php foreach($orderProduct as $product) { ?>
              ga('ecommerce:addItem', {
                'id': '<?php echo $product['order_id']; ?>',
                'sku': <?php if(isset($product['sku'])) { ?><?php echo json_encode(html_entity_decode($product['sku'],ENT_QUOTES, 'UTF-8')); ?><?php } else { ?><?php echo json_encode(html_entity_decode($product['model'],ENT_QUOTES, 'UTF-8')); ?><?php } ?>,
                'name': <?php echo json_encode(html_entity_decode($product['name'], ENT_QUOTES, 'UTF-8')); ?>,
                'category': <?php echo json_encode(html_entity_decode($product['category_name'], ENT_QUOTES, 'UTF-8')); ?>,
                'price': '<?php echo round($product['price'], 2); ?>',
                'quantity': '<?php echo $product['quantity']; ?>'
              });
			<?php } ?>
 			<?php } ?>

			<?php if(isset($orderProductOptions)) { ?>
			<?php foreach($orderProductOptions as $product) { ?>
              ga('ecommerce:addItem', {
                'id': '<?php echo $product['order_id']; ?>',
                'sku': '<?php if(isset($product['sku'])) { ?><?php echo addslashes($product['sku']); ?><?php } else { ?><?php echo addslashes($product['model']); ?><?php } ?> - <?php echo html_entity_decode(addslashes($product['options_data']),ENT_QUOTES, 'UTF-8'); ?>',
                'name': <?php echo json_encode(html_entity_decode($product['name'], ENT_QUOTES, 'UTF-8')); ?>,
                'category': <?php echo json_encode(html_entity_decode($product['category_name'], ENT_QUOTES, 'UTF-8')); ?>,
                'price': '<?php echo round($product['price'], 2); ?>',
                'quantity': '<?php echo $product['quantity']; ?>'
              });
			<?php } ?>
			<?php } ?>

              ga('ecommerce:send');

            </script>
            <?php } ?>
            
            <?php if ($this->config->get('config_ga_adwords') == 1) { ?> 
            <!-- begin Google Code for Adwords Conversion Page -->
            <?php if ($this->config->get('config_ga_cookie') == 1) { echo '<script type="text/plain" class="cc-onconsent-analytics">';} else{echo '<script type="text/javascript">'; } ?>
            
            var google_conversion_id = <?php echo $this->config->get('config_ga_conversion_id'); ?>;
            var google_conversion_language = "en";
            var google_conversion_format = "3";
            var google_conversion_color = "666666";
            var google_conversion_label = "<?php echo $this->config->get('config_ga_label'); ?>";
            var google_conversion_value = <?php echo round(($orderDetails['total'] - $orderDetails['order_tax']), 2); ?>;
            </script>
            <<?php if ($this->config->get('config_ga_cookie') == 1) { echo 'script type="text/plain" class="cc-onconsent-analytics"';} else{echo 'script type="text/javascript"'; } ?> src="//www.googleadservices.com/pagead/conversion.js">
            </script>
            <noscript>
            <div style="display:none;visibility:hidden">
            <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/<?php echo $this->config->get('config_ga_conversion_id'); ?>/?<?php if(isset($orderDetails)) { echo "value=" . round(($orderDetails['total'] - $orderDetails['order_tax']), 2); } ?>&amp;label=<?php echo $this->config->get('config_ga_label'); ?>&amp;guid=ON&amp;script=0"/>
            </div>
            </noscript>
            <!-- end Google Code for Adwords Conversion Page -->
            <?php } ?>
            
            <?php } ?>  
            
<?php echo $footer; ?>