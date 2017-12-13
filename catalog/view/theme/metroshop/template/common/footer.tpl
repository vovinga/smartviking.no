
</div>
<div id="footer-container">
 <?php 
$displayCustomFooter =  $this->config->get('customFooter_status');

// Show custom footer
if($displayCustomFooter == 1) {
?>
<?php
// Show about
if ($this->config->get('about_status') == '1') {
  
  // Twitter
  $TWIITER_USERNAME = $this->config->get('twitter_username');
  
  if($TWIITER_USERNAME <> '')
  {
    $TWITTER_HTML = '<a href="http://twitter.com/'.$TWIITER_USERNAME.'" class="soc-img twitter"></a>';
  }
  else
  {
    $TWITTER_HTML = '';
  }
  
  // Facebook
  $FB_USERNAME = $this->config->get('facebook_id');
  
  if($FB_USERNAME <> '')
  {
    $FB_HTML = '<a href="http://facebook.com/pages/dx/'.$FB_USERNAME.'" class="soc-img facebook"></a>';
  }
  else
  {
    $FB_HTML = '';
  }
  
  // Skype
  $SKYPE_USERNAME = $this->config->get('skype');
  
  if($SKYPE_USERNAME <> '')
  {
    $SKYPE_HTML = '<a href="skype://'.$SKYPE_USERNAME.'" class="soc-img skype"></a>';
  }
  else
  {
    $SKYPE_HTML = '';
  }
  
?>

<div class="footer-about">
      <?php
if($this->config->get('about_us_image_status') == '1'){
        echo ' <style type="text/css">.footer-about .text {
	width:435px; } </style>';
	echo '<div class="mini-logo"><img alt ="About" src="image/' . $this->config->get('about_us_image') . '"/></div>';
}
?>
  <div class="text"><h1><?=$this->config->get('about_header');?></h1>
    <?=html_entity_decode($this->config->get('about_text'));?>	
</div>
  <div class="social">
    <h1><?=$this->config->get('contact_header')?></h1>
    <?=$FB_HTML?>
    <?=$TWITTER_HTML?>
    <?=$SKYPE_HTML?>
    <div class="contact">
      <div class="phone"><?php if ($this->config->get('telephone1')) { echo '<b>Phone:</b> '.$this->config->get('telephone1'); }?><?php if ($this->config->get('telephone2')) { echo ', '.$this->config->get('telephone2'); }?></div>
      <div class="fax"><?php if ($this->config->get('fax')) { echo '<b>Fax:</b> '.$this->config->get('fax'); }?></div>
      <div class="email"><?php if ($this->config->get('email1')) { echo '<a href="mailto:'.$this->config->get('email1').'">'.$this->config->get('email1').'</a>'; }?></div>
      <div class="email"><?php if ($this->config->get('email2')) { echo '<a href="mailto:'.$this->config->get('email2').'">'.$this->config->get('email2').'</a>'; }?></div>
    </div>
  </div>
  <div class="clear"></div>
</div>
<? }
// About end
?>


<? }
// Custom footer end
?>

<?php 
$linkes='rel="nofollow"';
if ($_SERVER['QUERY_STRING'] != true) 
global $linkes;
?>

<div id="footer">
  <?php if ($informations) { ?>
  <div class="column">
    <span><?php echo $text_information; ?></span>
    <ul>
      <?php foreach ($informations as $information) { ?>
      <li><a <?php echo $linkes;?> href="<?php echo $information['href']; ?>" title="<?php echo $information['title']; ?>"><?php echo $information['title']; ?></a></li>
      <?php } ?>
    </ul>
  </div>
  <?php } ?>
  <div class="column">
    <span><?php echo $text_service; ?></span>
    <ul>
      <li><a <?php echo $linkes;?> href="<?php echo $contact; ?>" title="<?php echo $text_contact; ?>"><?php echo $text_contact; ?></a></li>
      <li><a <?php echo $linkes;?> href="<?php echo $return; ?>" title="<?php echo $text_return; ?>"><?php echo $text_return; ?></a></li>
      <li><a <?php echo $linkes;?> href="<?php echo $sitemap; ?>" title="<?php echo $text_sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
    </ul>
  </div>
  <div class="column">
    <span><?php echo $text_extra; ?></span>
    <ul>
      <li><a <?php echo $linkes;?> href="<?php echo $manufacturer; ?>" title="<?php echo $text_manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
      <li><a <?php echo $linkes;?> href="<?php echo $voucher; ?>" title="<?php echo $text_voucher; ?>"><?php echo $text_voucher; ?></a></li>
      <li><a <?php echo $linkes;?> href="<?php echo $affiliate; ?>" title="<?php echo $text_affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
      <li><a <?php echo $linkes;?> href="<?php echo $special; ?>" title="<?php echo $text_special; ?>"><?php echo $text_special; ?></a></li>
    </ul>
  </div>
  <?php
  // TWITTER WIDGET
  if(($this->config->get('twitter_column_status') == '1')&&($displayCustomFooter == 1)) { ?>
  <div class="column">
  <span><?php echo $this->config->get('twitter_column_header'); ?></span>
  <script type="text/javascript">
jQuery(document).ready(function($){
 
 $('#twitter_update_list').tweet({
 modpath: 'catalog/view/theme/metroshop/js/twitter/',
 count: <?php echo $this->config->get('twitter_number_of_tweets') ; ?>,
 username: '<?php echo $this->config->get('twitter_username') ; ?>',
 template: "<span>{text}</span>",
 loading_text: '<img src="catalog/view/theme/metroshop/image/loading.gif">'

});
 

});
</script>

  
    <ul id="twitter_update_list"></ul>
  </div>
  <? } else {  ?>
  <div class="column">
    <span><?php echo $text_account; ?></span>
    <ul>
      <li><a <?php echo $linkes;?> href="<?php echo $account; ?>" title="<?php echo $text_account; ?>"><?php echo $text_account; ?></a></li>
      <li><a <?php echo $linkes;?> href="<?php echo $order; ?>" title="<?php echo $text_order; ?>"><?php echo $text_order; ?></a></li>
      <li><a <?php echo $linkes;?> href="<?php echo $wishlist; ?>" title="<?php echo $text_wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
      <li><a <?php echo $linkes;?> href="<?php echo $newsletter; ?>" title="<?php echo $text_newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
    </ul>
  </div>
  <? } ?>
   <?php
if (($this->config->get('facebook_status') == '1')&&($displayCustomFooter == 1)) {
	?>
  <div class="column">
    <span>FACEBOOK</span>
     <!-- Facebook -->
	 <script>
	    $('.facebookOuter').css({
	    	"background-color":"transparent",
			padding:"0px",
			border:"none",
			
		});
		$('.facebookInner').css({
	    	overflow:"hidden",
			
		});
	 </script>
 

<div class="facebookOuter">
 <div class="facebookInner">
  <div class="fb-like-box" data-href="http://www.facebook.com/pages/dx/<?php echo $this->config->get('facebook_id'); ?>" data-width="200" data-height="100" data-show-faces="false" data-colorscheme="dark" data-stream="false" data-border-color="transparent" data-header="false"></div>       
 </div>
</div>
 
    <!-- / Facebook -->
  </div>
  <? } else { ?>
  
  <style type="text/css">#footer .column  {
	width:25%; } </style>
  <? }?>
</div>
<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->
<div id="powered"><?php echo $powered; ?></div>
<div id="paymenticons"><img src="catalog/view/theme/metroshop/image/payment.png" alt="payment" /></div>
<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->
<div class="clear"></div>
</div>
  
</body>

</html>