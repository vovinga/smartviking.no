<?php echo $header; ?>
<style>
.tab-content h2{
  font-size:18px!important;
  font-weight:bold!important;
}
</style>

<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
<div style="display:block; width:100%; margin-bottom:10px;">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" id="bread_2">
        <?php echo $breadcrumb['separator']; ?><a rel="nofollow" href="<?php echo $breadcrumb['href']; ?>" itemprop="url"><span itemprop="title"><?php echo $breadcrumb['text']; ?></span></a>
   </span>
		<?php } ?>
		</div>
  <!--h1><?php echo $heading_title; ?></h1-->
  <br/>
  <div class="product-info">
    <?php if ($thumb || $images) { ?>
    <div class="left">
      <?php if ($thumb) { ?>
       
      <div class="image"><a href="<?php echo $popup; ?>" title="<?php echo $custom_imgtitle; ?>" id="zoom01" <? if(($this->config->get('metroshop_status') == '1') && ($this->config->get('metroshop_effects_productimage') == 'zoom')) { echo 'class="cloud-zoom" rel="position:\'right\', zoomWidth:320, zoomHeight:320, adjustX:10, adjustY:0, tint:\'#FFFFFF\', showTitle:false, softFocus:1, smoothMove:5, tintOpacity:0.8"';} else { echo 'rel="prettyPhoto"';} ?>><img width="320" height="320" src="<?php echo $thumb; ?>" title="<?php echo $custom_imgtitle; ?>" alt="<?php echo $custom_alt; ?>" id="image" /><?php echo $labels; ?></a></div>
      
      <?php } ?>
      <?php if ($images) { ?>
   
       
        <div class="image-additional gallery">
          <a href="<?php echo $popup; ?>" title="<?php echo $custom_imgtitle; ?>" <? if(($this->config->get('metroshop_status') == '1') && ($this->config->get('metroshop_effects_productimage') == 'zoom')) { echo 'rel="useZoom: \'zoom01\', smallImage: \''.$thumb.'\'" class="cloud-zoom-gallery"';} else { echo 'rel="prettyPhoto[pp_gal]"';} ?>><img width="102" height="102" class="fade-image" src="<?php echo $thumb; ?>" title="<?php echo $custom_imgtitle; ?>" alt="<?php echo $custom_alt; ?>" /></a>
          <?php foreach ($images as $image) { ?>
          <a href="<?php echo $image['popup']; ?>" title="<?php echo $custom_imgtitle; ?>" <? if(($this->config->get('metroshop_status') == '1') && ($this->config->get('metroshop_effects_productimage') == 'zoom')) { echo 'rel="useZoom: \'zoom01\', smallImage: \''.$image['zoom_thumb'].'\'" class="cloud-zoom-gallery"';} else { echo 'rel="prettyPhoto[pp_gal]"';} ?>><img class="fade-image" src="<?php echo $image['thumb']; ?>" title="<?php echo $custom_imgtitle; ?>" alt="<?php echo $custom_alt; ?>" /></a>
          <?php } ?>
          <div class="clear"></div>
        </div>
    
      <?php } ?>
    </div>
    <?php } ?>
    <div class="right">

			
				<?php $richsnippets = $this->config->get('richsnippets');
				if (isset($richsnippets['breadcrumbs'])) { ?>
				<span xmlns:v="http://rdf.data-vocabulary.org/#">
				<?php foreach ($mbreadcrumbs as $mbreadcrumb) { ?>
				<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $mbreadcrumb['href']; ?>" alt="<?php echo $mbreadcrumb['text']; ?>"></a></span>
				<?php } ?>				
				</span>
				<?php }
				if (isset($richsnippets['product'])) {
				?>
				<span itemscope itemtype="http://schema.org/Product">
				<meta itemprop="url" content="<?php $mlink = end($breadcrumbs); echo $mlink['href']; ?>" >
				<meta itemprop="name" content="<?php echo $heading_title; ?>" >
				<meta itemprop="model" content="<?php echo $model; ?>" >
				<meta itemprop="manufacturer" content="<?php echo $manufacturer; ?>" >
				
				<?php if ($thumb) { ?>
				<meta itemprop="image" content="<?php echo $thumb; ?>" >
				<?php } ?>
				
				<?php if ($images) { foreach ($images as $image) {?>
				<meta itemprop="image" content="<?php echo $image['thumb']; ?>" >
				<?php } } ?>
				
				<?php if (isset($richsnippets['offer'])) { ?>
				<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<meta itemprop="price" content="<?php echo preg_replace( '/[^.,0-9]/', '',($special ? $special : $price)); ?>" />
				<meta itemprop="priceCurrency" content="<?php echo $this->currency->getCode(); ?>" />
				<link itemprop="availability" href="http://schema.org/<?php echo (($quantity > 0) ? "InStock" : "OutOfStock") ?>" />
				</span>
				<?php } ?>
				
				<?php if (isset($richsnippets['rating']) && $review_no) { ?>
				<span itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
				<meta itemprop="reviewCount" content="<?php echo $review_no; ?>">
				<meta itemprop="ratingValue" content="<?php echo $rating; ?>">
				<meta itemprop="bestRating" content="5">
				<meta itemprop="worstRating" content="1">
				</span>
				<?php } ?>

				
				</span>
				<?php } ?>
            
			
	<h1><?php echo $heading_title; ?></h1>
      <!--div class="breadcrumb">
	 
        <?php //foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php //echo $breadcrumb['separator']; ?><a href="<?php //echo $breadcrumb['href']; ?>"><?php //echo $breadcrumb['text']; ?></a>
        <?php //} ?>
      </div-->
      <?php if ($price) { ?>
      <div class="price"><b><?php echo $text_price; ?></b>
        <?php if (!$special) { ?>
        <?php echo $price; ?>
        <?php } else { ?>
        <span class="price-old"><?php echo $price; ?></span> <span class="price-new"><?php echo $special; ?></span>
        <?php } ?>
        
        <?php if ($tax) { ?>
        <br><span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span>
        <?php } ?><br />
        <?php if ($points) { ?>
        <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span><br />
        <?php } ?>
        <?php if ($discounts) { ?>
        
        <div class="discount">
          <?php foreach ($discounts as $discount) { ?>
          <?php echo sprintf($text_discount, $discount['quantity'], $discount['price']); ?><br />
          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
      <div class="description">
        <div class="right-rating" onclick="$('a[href=\'#tab-review\']').trigger('click');"><img class="fade-image" src="catalog/view/theme/metroshop/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" /></div>
        <?php if ($manufacturer) { ?>
        <span><?php echo $text_manufacturer; ?></span> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a><br />
        <?php } ?>
        <span><?php echo $text_model; ?></span> <?php echo $model; ?><br />
        <?php if ($reward) { ?>
        <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
        <?php } ?>
        <span><?php echo $text_stock; ?></span> <?php echo $stock; ?></div>
      
      <?php if ($options) { ?>
      <div class="options">
        <h2><?php echo $text_option; ?></h2>
       
        <?php foreach ($options as $option) { ?>
        <?php if ($option['type'] == 'select') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          
          <b><?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?><?php echo $option['name']; ?>:</b>
          <select name="option[<?php echo $option['product_option_id']; ?>]">
            <option value=""><?php echo $text_select; ?></option>
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
            </option>
            <?php } ?>
          </select>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'radio') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          
          <b><?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?><?php echo $option['name']; ?>:</b>
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'checkbox') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          
          <b><?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?><?php echo $option['name']; ?>:</b>
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'image') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          
          <b><?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?><?php echo $option['name']; ?>:</b>
          <table class="option-image">
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <tr>
              <td style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" /></td>
              <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /></label></td>
              <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                  <?php if ($option_value['price']) { ?>
                  (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                  <?php } ?>
                </label></td>
            </tr>
            <?php } ?>
          </table>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'text') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          
          <b><?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?><?php echo $option['name']; ?>:</b>
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'textarea') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
         
          <b> <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?><?php echo $option['name']; ?>:</b>
          <textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'file') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          
          <b><?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?><?php echo $option['name']; ?>:</b>
          <input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="button">
          <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'date') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
         
          <b> <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?><?php echo $option['name']; ?>:</b>
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'datetime') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          
          <b><?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?><?php echo $option['name']; ?>:</b>
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'time') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
         
          <b> <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?><?php echo $option['name']; ?>:</b>
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
        </div>
        <br />
        <?php } ?>
        <?php } ?>
      </div>
      <?php } ?>
      
          <noindex>
          <div class="product-info-buttons">
                <div class="input-qty"><span><?php echo $text_qty; ?></span><input type="text" name="quantity" size="2" value="<?php echo $minimum; ?>" />
          <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
                </div><a rel="nofollow" class="button" id="button-cart"><?php echo $button_cart; ?></a> 
          </div>
          <div class="product-info-buttons2 box-product">
		    <div class="btn-wish" 
			onclick="addToWishList('<?php echo $product_id; ?>'); <?php if ($this->config->get('config_ga_tracking_type') == 2) { echo "ga('send', 'event', 'Product Page', 'Add to Wishlist', '".htmlspecialchars($heading_title,ENT_QUOTES)."');";} else{echo "_gaq.push(['_trackEvent', 'Product Page', 'Add to Wishlist', '".htmlspecialchars($heading_title,ENT_QUOTES)."']);"; } ?>"
			><?php echo $button_wishlist; ?></div>
	    	    <div class="btn-compare" 
			onclick="addToCompare('<?php echo $product_id; ?>'); <?php if ($this->config->get('config_ga_tracking_type') == 2) { echo "ga('send', 'event', 'Product Page', 'Add to Compare', '".htmlspecialchars($heading_title,ENT_QUOTES)."');";} else{echo "_gaq.push(['_trackEvent', 'Product Page', 'Add to Compare', '".htmlspecialchars($heading_title,ENT_QUOTES)."']);"; } ?>"
			><?php echo $button_compare; ?></div>
	  </div>
        <?php if ($minimum > 1) { ?>
            <div class="minimum"><?php echo $text_minimum; ?></div>
          <?php } ?>
      
      
      <?php if ($review_status) { ?>
      <div class="review">
       <span class='st_facebook_large' displayText='Facebook'></span>
<span class='st_twitter_large' displayText='Tweet'></span>
<span class='st_pinterest_large' displayText='Pinterest'></span>
<span class='st_plusone_large' displayText='Google +1'></span>
      </div>
	  </noindex>
      <?php } ?>
    </div>
   
  </div>
  <div id="tabs" class="htabs">
  <a rel="nofollow" href="#tab-description"><?php echo $tab_description; ?></a>
    <?php if ($attribute_groups) { ?>
    <a rel="nofollow" href="#tab-attribute"><?php echo $tab_attribute; ?></a>
    <?php } ?>
    <?php if ($review_status) { ?>
    <a rel="nofollow" href="#tab-review"><?php echo $tab_review; ?></a>
    <?php } ?>
    
<?
if($this->config->get('metroshop_status') == '1') { $metroshop_layout_related = $this->config->get('metroshop_layout_related');} else {$metroshop_layout_related = 'tab';}

if($metroshop_layout_related == 'tab')
{
?>
    
    <?php if ($products) { ?>
    <a rel="nofollow" href="#tab-related"><?php echo $tab_related; ?> (<?php echo count($products); ?>)</a>
    <?php } ?>

			<?php if (!empty($data['ComparePrices']['Enabled']) && $data['ComparePrices']['Enabled'] == 'yes' && $data['ComparePrices']['showInTab'] == 'yes') { ?>	
			<a href="#tab-comparePrices"><?php echo $tab_ComparePrices; ?></a>			
			<script>
			$(document).ready(function() {
			if (window.location.hash == "#tab-comparePrices") {
					$('a[href="' + window.location.hash + '"]').click(); }
			});
			</script>
			<?php } ?>
			
<? } ?>

  </div>
  <div id="tab-description" class="tab-content"><?php echo $description; ?></div>
  <?php if ($attribute_groups) { ?>
  <div id="tab-attribute" class="tab-content">
    <table class="attribute">
      <?php foreach ($attribute_groups as $attribute_group) { ?>
      <thead>
        <tr>
          <td colspan="2"><?php echo $attribute_group['name']; ?></td>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
        <tr>
          <td><?php echo $attribute['name']; ?></td>
          <td><?php echo $attribute['text']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php } ?>
    </table>
  </div>
  <?php } ?>
  <?php if ($review_status) { ?>
  <div id="tab-review" class="tab-content">
    <div id="review"></div>
    <h2 id="review-title"><?php echo $text_write; ?></h2>
    <b><?php echo $entry_name; ?></b><br />
    <input type="text" name="name" value="" />
    <br />
    <br />
    <b><?php echo $entry_review; ?></b>
    <textarea name="text" cols="40" rows="8" style="width: 98%;"></textarea>
    <span style="font-size: 11px;"><?php echo $text_note; ?></span><br />
    <br />
    <b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>&nbsp;
    <input type="radio" name="rating" value="1" />
    &nbsp;
    <input type="radio" name="rating" value="2" />
    &nbsp;
    <input type="radio" name="rating" value="3" />
    &nbsp;
    <input type="radio" name="rating" value="4" />
    &nbsp;
    <input type="radio" name="rating" value="5" />
    &nbsp;<span><?php echo $entry_good; ?></span><br />
    <br />
<!--
    <b><?php echo $entry_captcha; ?></b><br />
    <input type="text" name="captcha" value="" />
    <br />
    <img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
-->
    <br />
    <div class="buttons">
      <div class="right"><a id="button-review" class="button"><?php echo $button_continue; ?></a></div>
    </div>
  </div>
  <?php } ?>

<?
if($this->config->get('metroshop_status') == '1') { $metroshop_layout_related = $this->config->get('metroshop_layout_related');} else {$metroshop_layout_related = 'tab';}

if($metroshop_layout_related == 'tab')
{
?>
  
  <?php if ($products) { ?>
  <div id="tab-related" class="tab-content">
    <div class="box-product">
      <?php foreach ($products as $product) { ?>

<div class="box-product-item">
        <div class="view-first">
          <div class="view-content">  
            <?php if ($product['thumb']) { ?>
            <div class="image"><a href="<?php echo $product['href']; ?>"><!-- star ipl --><?php echo $product['labels']; ?><!-- end ipl --><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
            <?php } ?>
              
            <div class="bottom-block">
              <div class="name"><a href="<?php echo $product['href']; ?>"><?php
              mb_internal_encoding("UTF-8");
              if(strlen($product['name']) > 23) { $product['name'] = mb_substr($product['name'],0,23).'...'; } echo $product['name']; ?></a></div>
              <div class="link-cart" 
			onclick="addToCart('<?php echo $product['product_id']; ?>'); <?php if ($this->config->get('config_ga_tracking_type') == 2) { echo "ga('send', 'event', 'Related Product', 'Add to Cart', '".htmlspecialchars($product['name'],ENT_QUOTES)."');";} else{echo "_gaq.push(['_trackEvent', 'Related Product', 'Add to Cart', '".htmlspecialchars($product['name'],ENT_QUOTES)."']);"; } ?>"
			><?php echo $button_cart; ?></div>
              <?php if ($product['price']) { ?>
              <div class="price">
                <?php if (!$product['special']) { ?>
                <?php echo $product['price']; ?>
                <?php } else { ?>
                <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
                <?php } ?>
              </div>
              <?php } ?>
            </div>
          </div>
          
	  <div class="slide-block"><div class="image-rating"><?php if ($product['rating']) { ?><img src="catalog/view/theme/metroshop/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /><?php } ?></div><div class="btn-wish" onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></div><div class="btn-compare" onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></div></div>
        </div>
      </div>
            
            
        <?php } ?>
  </div>
  </div>
  <?php } ?>
  
  
<? }?>

<?php  ?> 
<?
if($this->config->get('metroshop_status') == '1') { $metroshop_layout_related = $this->config->get('metroshop_layout_related');} else {$metroshop_layout_related = 'tab';}

if(($metroshop_layout_related == 'carousel')&&($products)){
?>
  <div class="box">
  <div class="box-heading"><?php echo $tab_related; ?><div class="navigate navigate-related"><div class="prev"></div><div class="next"></div></div></div>
  <div class="clear"></div>
  <div class="box-product">
    <div class="caruofredsel caruofredsel-related">
      <?php foreach ($products as $product) { ?>
      
      <div class="box-product-item">
        <div class="view-first">
          <div class="view-content">  
            <?php if ($product['thumb']) { ?>
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
            <?php } ?>
              
            <div class="bottom-block">
              <div class="name"><a href="<?php echo $product['href']; ?>"><?php if(strlen($product['name']) > 23) { $product['name'] = substr($product['name'],0,23).'...'; } echo $product['name']; ?></a></div>
              <div class="link-cart" 
			onclick="addToCart('<?php echo $product['product_id']; ?>'); <?php if ($this->config->get('config_ga_tracking_type') == 2) { echo "ga('send', 'event', 'Related Product', 'Add to Cart', '".htmlspecialchars($product['name'],ENT_QUOTES)."');";} else{echo "_gaq.push(['_trackEvent', 'Related Product', 'Add to Cart', '".htmlspecialchars($product['name'],ENT_QUOTES)."']);"; } ?>"
			><?php echo $button_cart; ?></div>
              <?php if ($product['price']) { ?>
              <div class="price">
                <?php if (!$product['special']) { ?>
                <?php echo $product['price']; ?>
                <?php } else { ?>
                <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
                <?php } ?>
              </div>
              <?php } ?>
            </div>
          </div>
          
	  <div class="slide-block"><div class="image-rating"><?php if ($product['rating']) { ?><img src="catalog/view/theme/metroshop/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /><?php } ?></div><div class="btn-wish" onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></div><div class="btn-compare" onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></div></div>
        </div>
      </div>
            
        <?php } ?>
  </div>
  </div>
  </div>

<script type="text/javascript"><!--
$(document).ready(function() {
      
        
	// Using default configuration
	$(".caruofredsel-related").carouFredSel({
      
                  infinite: false,
                  auto 	: false,
		  width : "100%",
                  prev	: {	
                          button	: ".navigate-related .prev",
                          key		: "left"
                  },
                  next	: { 
                          button	: ".navigate-related .next",
                          key		: "right"
                  }
                  ,swipe           : {
                      onTouch     : false,
                      onMouse     : false
                  }
		  ,onCreate : function(data) { $(this).css("height","auto");  }
        
        })

});

--></script>
<? } ?>


			<?php if (!empty($data['ComparePrices']['Enabled']) && $data['ComparePrices']['Enabled'] == 'yes' && $data['ComparePrices']['showInTab'] == 'yes') { ?>
			<div id="tab-comparePrices" class="tab-content">
			            <div id="ComparePricesSuccess"></div>

			<div id="ComparePrices">
			<?php if (empty($special)) $final_price=$price; else $final_price=$special; ?>
            <?php $ComparePricesName = (empty($firstname)) ? "" : $firstname." ".$lastname; ?>
            <?php $ComparePricesEmail = (empty($email)) ? "" : $email; ?>
			<div class="ComparePrices" style="width: <?php echo $data['ComparePrices']['Width']; ?>px;">		
			<div style="width:50%;padding:10px;float:right;"><strong><?php echo $pleaseFillInTheForm; ?></strong>
			<br /><small><span class="required">*</span> <?php echo $requiredFields; ?></small><br />
			<form id="ComparePricesForm">
			
			  <table class="form">
				<tr><td><span class="required">*</span> <?php echo $yourName; ?>:</td><td><input type="text" name="YourName" id="YourName" value="<?php echo $ComparePricesName; ?>"></td></tr>
				<tr><td><span class="required">*</span> <?php echo $yourEmail; ?>:</td><td><input type="text" name="YourEmail" id="YourEmail" value="<?php echo $ComparePricesEmail; ?>"></td></tr>
				<tr><td><span class="required">*</span> <?php echo $priceInOtherStore; ?>:<br/><small><?php echo $ourPrice; ?>: <strong><?php echo $final_price; ?><strong></small></td><td><input type="text" name="PriceInOtherStore" id="PriceInOtherStore"></td></tr>
				<tr><td><span class="required">*</span> <?php echo $linkToTheProduct; ?>:</td><td><input type="text" name="LinkToTheProduct" id="LinkToTheProduct"></td></tr>
				<tr><td colspan="2"><?php echo $commentsOptional; ?>:</td></tr>
				<tr><td colspan="2"><textarea name="YourComments" id="YourComments" style="width:310px; height:70px;" placeholder="<?php echo $isThereSomethingMoreWeShouldKnow; ?>"></textarea>
				<input type="hidden" name="CurrentProductURL" value="<?php echo $ComparePricesCurrURL; ?>">
				<input type="hidden" name="CurrentProductName" value="<?php echo $heading_title; ?>">
				<input type="hidden" name="CurrentProductPrice" value="<?php echo $final_price; ?>"></td></tr>
				<tr><td colspan="2"><a id="ComparePricesSubmit" class="button"><?php echo $submitForm; ?></a></td></tr>
			  </table>
			</form>
			</div>
			<div style="width: 50%;padding: 10px;">
			<?php echo html_entity_decode($data['ComparePrices']['CustomText']); ?>
			<?php if ($data['ComparePrices']['CustomText']!="") { echo "<br /><br />".html_entity_decode($data['ComparePrices']['SecondCustomText']); } ?>
			</div>
			<div style="clear:both"></div>
			</div>
			</div>
			</div>
			<?php } ?>
			
  <?php if ($tags) { ?>
  <div class="tags content"><img src="catalog/view/theme/metroshop/image/tags.png" align="absmiddle"><b><?php echo $text_tags; ?></b>
    <?php for ($i = 0; $i < count($tags); $i++) { ?>
    <?php if ($i < (count($tags) - 1)) { ?>
    <a href="<?php echo $tags[$i]['href']; ?>" title="<?php echo $tags[$i]['tag']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
    <?php } else { ?>
    <a href="<?php echo $tags[$i]['href']; ?>" title="<?php echo $tags[$i]['tag']; ?>"><?php echo $tags[$i]['tag']; ?></a>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>
  <?php echo $content_bottom; ?></div>

<script type="text/javascript"><!--
$('#button-cart').bind('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
			
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}
			} 
			
			if (json['success']) {
				$('#notification').html('<noindex><div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/metroshop/image/close.png" alt="" class="close" /></div></noindex>');
					
				$('.success').fadeIn('slow');
					
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
});
//--></script>
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/metroshop/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);
		
		$('.error').remove();
		
		if (json['success']) {
			alert(json['success']);
			
			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
		}
		
		if (json['error']) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
		}
		
		$('.loading').remove();	
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
	$('#review').fadeOut('slow');
		
	$('#review').load(this.href);
	
	$('#review').fadeIn('slow');
	
	return false;
});			

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').bind('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data['error']) {
				$('#review-title').after('<div class="warning">' + data['error'] + '</div>');
			}
			
			if (data['success']) {
				$('#review-title').after('<div class="success">' + data['success'] + '</div>');
								
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
if ($.browser.msie && $.browser.version == 6) {
	$('.date, .datetime, .time').bgIframe();
}

$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});


$(document).ready(function(){
  
<?
  if(($this->config->get('metroshop_status') == '1') && ($this->config->get('metroshop_effects_productimage') == 'zoom')) {
?>      
       $('#zoom01, .cloud-zoom-gallery').CloudZoom();
<?
} 
?>
 

    });  
//--></script><?php echo $footer; ?><?php //die();?>