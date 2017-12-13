<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>

<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400' rel='stylesheet' type='text/css'>

<?php if(($this->config->get('metroshop_status') == '1')&&( $this->config->get('metroshop_header_font') != 'Arial')){	
?>
<link href='//fonts.googleapis.com/css?family=<?php echo $this->config->get('metroshop_header_font') ?>:<?php echo $this->config->get('metroshop_header_font_weight') ?>&amp;subset=<?php echo $this->config->get('metroshop_header_font_subset') ?>' rel='stylesheet' type='text/css'>
<?php } ?> 

<link rel="stylesheet" type="text/css" href="catalog/view/theme/metroshop/stylesheet/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/metroshop/stylesheet/flexslider.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/metroshop/stylesheet/dd.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/metroshop/stylesheet/prettyPhoto.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/metroshop/stylesheet/jquery.jqzoom.css" media="screen" />
<?php
// RTL support will be added soon. Do no edit code directly!
$rtl_enabled = false;

if(($direction == 'rtl')&&($rtl_enabled == true))
{
      echo '<link rel="stylesheet" type="text/css" href="catalog/view/theme/metroshop/stylesheet/rtl.css" />';
}
?>

<?php if(($this->config->get('metroshop_status') == '1')&&( $this->config->get('metroshop_layout_responsive') == 1)) { ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/metroshop/stylesheet/responsive.css" />
<?
      if(($direction == 'rtl')&&($rtl_enabled == true))
      {
	    echo '<link rel="stylesheet" type="text/css" href="catalog/view/theme/metroshop/stylesheet/responsive-rtl.css" />';
      }

} ?>

<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/external/jquery.cookie.js"></script>

<script type="text/javascript" src="catalog/view/javascript/jquery/tabs.js"></script>
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<script type="text/javascript" src="catalog/view/theme/metroshop/js/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="catalog/view/theme/metroshop/js/jquery.ba-throttle-debounce.min.js"></script>
<script type="text/javascript" src="catalog/view/theme/metroshop/js/jquery.touchSwipe.min.js"></script>
<script type="text/javascript" src="catalog/view/theme/metroshop/js/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="catalog/view/theme/metroshop/js/jquery.carouFredSel-6.1.0-packed.js"></script>
<script type="text/javascript" src="catalog/view/theme/metroshop/js/cloud-zoom.1.0.3.min.js"></script>
<script type="text/javascript" src="catalog/view/theme/metroshop/js/jquery.dd.min.js"></script>
<script type="text/javascript" src="catalog/view/theme/metroshop/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="catalog/view/theme/metroshop/js/twitter/jquery.tweet.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/colorbox/colorbox.css" media="screen" />

<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js" defer></script>
<script type="text/javascript">stLight.options({publisher: "fdf72e22-4d1c-4270-9aea-a784ad6c30c2"});</script>
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/metroshop/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/metroshop/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->

<?php if ($stores) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
<?php foreach ($stores as $store) { ?>
$('body').prepend('<iframe src="<?php echo $store; ?>" style="display: none;"></iframe>');
<?php } ?>
});
//--></script>
<?php } ?>

<?php echo $google_analytics; ?>

<script type="text/javascript"><!--

$(document).ready(function() {
      
      <?
      if(($this->config->get('metroshop_status') == '1'))
      {
	echo $this->config->get('metroshop_custom_js');
      }
      ?>
      
      // Image animation
      $(".fade-image, .box-category .menuopen, .box-category .menuclose").live({
        mouseenter:
           function()
           {
				$(this).stop().fadeTo(300, 0.6);
           },
        mouseleave:
           function()
           {
				$(this).stop().fadeTo(300, 1);
           }
       }
       );
      
      
      
      $(".box-category div.menuopen").live('click', function(event) {
	 
		event.preventDefault();
		
		$('.box-category a + ul').slideUp();
		$('+ a + ul', this).slideDown();
		
		$('.box-category ul li div.menuclose').removeClass("menuclose").addClass("menuopen");
		$(this).removeClass("menuopen").addClass("menuclose");
		
		$('.box-category ul li a.active').removeClass("active");
		$('+ a', this).addClass("active");
	});
      
	    
	$("select:not([name='zone_id']):not([name='country_id'])").msDropdown();
      
        $("a[rel^='prettyPhoto']").prettyPhoto();

});

--></script>
<? if($this->config->get('metroshop_status') == '1') {
      
   // custom css
  
   $metroshop_layout_theight = $this->config->get('metroshop_layout_theight');
   
   if(!$metroshop_layout_theight)
   {
      $metroshop_layout_theight = 188;
   }
    ?>	
<style type="text/css">
    
      <?
      if(($this->config->get('metroshop_status') == '1'))
      {
	echo $this->config->get('metroshop_custom_css');
      }
      ?>
      /* backgrounds */
      body {
	background-color: #<?php echo $this->config->get('metroshop_color_body_bg') ?>;
      }
      
      input[type='text'], input[type='password'], textarea, select, {
	background-color: #<?php echo $this->config->get('metroshop_color_formbg') ?>;
      }
      
      #cboxContent, #header #cart .content, .buttons, .htabs a.selected, .htabs a:nth-child(odd).selected, .htabs a:nth-child(even).selected, .tab-content, .box-product-item, #content .content, #content table, .mini-ads a, .magnifyarea {
	background-color: #<?php echo $this->config->get('metroshop_color_content_bg') ?>;
      }
      
      #header_mainmenu .mm_logo {
	    background-color: #<?php echo $this->config->get('metroshop_color_headermenu_logo') ?>;
      }
      
      #header_mainmenu a.mm_home, #header_mainmenu a.mm_account, .htabs a:nth-child(even) {
	    background-color: #<?php echo $this->config->get('metroshop_color_headermenu_button1') ?>;
      }
      
      #header_mainmenu a.mm_wishlist, #header_mainmenu a.mm_checkout, .htabs a {
	    background-color: #<?php echo $this->config->get('metroshop_color_headermenu_button2') ?>;
      }
      
      #header_mainmenu .mm_shopcart, .footer-about .social .twitter, .footer-about .social .facebook, .footer-about .social .skype {
	    background-color: #<?php echo $this->config->get('metroshop_color_headermenu_buttoncart') ?>;
      }
      
      .search-bar {
	    background-color: #<?php echo $this->config->get('metroshop_color_searchblock_bg') ?>;
      }
      
      #search .button-search, .flexslider:hover .flex-next:hover, .flexslider:hover .flex-prev:hover, .box-heading .prev, .box-heading .next, .jcarousel-next-horizontal, .jcarousel-prev-horizontal {
	    background-color: #<?php echo $this->config->get('metroshop_color_navbuttonbg') ?>;
      }
      
      .pagination .links a, a.button, input.button, .product-filter .display .list-switch, .product-filter .display .grid-switch {
	    background-color: #<?php echo $this->config->get('metroshop_color_buttonbg') ?>;
      }
      
      #search .button-search:hover, .pagination .links a:hover, .pagination .links b, a.button:hover, input.button:hover, .htabs a:hover, .box-product .btn-wish:hover, .box-product .btn-compare:hover, .product-filter .display .grid-switch.active,.product-filter .display .grid-switch:hover, .product-filter .display .list-switch.active, .product-filter .display .list-switch:hover, .box-heading .prev:hover, .box-heading .next:hover, .jcarousel-prev-horizontal:hover, .jcarousel-next-horizontal:hover {
	    background-color: #<?php echo $this->config->get('metroshop_color_buttonhoverbg') ?>;
      }
      
      #menu > ul > li:hover, .box-category {
	    background-color: #<?php echo $this->config->get('metroshop_color_topmenu_hover_bg') ?>;
      }
      
      #menu .separator {
	    background-color: #<?php echo $this->config->get('metroshop_color_topmenu_separator') ?>;
      }
      
      #menu > ul > li > div {
	    background-color: #<?php echo $this->config->get('metroshop_color_topmenu_submenu_bg') ?>;
      }
      
      #menu > ul > li ul > li > a:hover, .box-category > ul > li > a:hover, .box-category > ul > li ul > li > a:hover {
	    background-color: #<?php echo $this->config->get('metroshop_color_topmenu_submenu_hover_bg') ?>;
      }
      
      table.list thead td, table.radio tr.highlight:hover td, .manufacturer-heading, .attribute thead td, .attribute thead tr td:first-child, .compare-info thead td, .compare-info thead tr td:first-child, .wishlist-info thead td, .order-detail, .cart-info thead td, .checkout-heading, .checkout-product thead td  {
	    background-color: #<?php echo $this->config->get('metroshop_color_tableheader_bg') ?>;
      }
 
      .product-list .list-product-item, .box-product .bottom-block, .category-info, .product-info > .left + .right {
	    background-color: #<?php echo $this->config->get('metroshop_color_productbg') ?>;
      }
	  
      .view-first:hover .bottom-block {
	    background-color: #<?php echo $this->config->get('metroshop_color_hover_productbg') ?>;
      }
      
      .box-product .btn-wish {
	    background-color: #<?php echo $this->config->get('metroshop_color_wlbuttonbg') ?>;
      }
      
      .box-product .btn-compare {
	    background-color: #<?php echo $this->config->get('metroshop_color_cmpbuttonbg') ?>;
      }
      
      .product-filter {
	    background-color: #<?php echo $this->config->get('metroshop_color_displaybg') ?>;
      }
      
      #footer {
	    background-color: #<?php echo $this->config->get('metroshop_color_footerbg') ?>;
      }
      
      .footer-about {
	    background-color: #<?php echo $this->config->get('metroshop_color_aboutbg') ?>;
      }
      
      
      <?php 
      if ($this->config->get('dxmetroshop_bg_image') == '1') {
      ?>
      body{
	background-image:url("<?php echo 'image/' . $this->config->get('dxmetroshop_image') ?>");
      } 	
      <?php   }
	else if ($this->config->get('metroshop_body_bg_pattern')!= "no_pattern") { 
      ?>
      body {
	background-image:url("catalog/view/theme/metroshop/image/bg/<?php echo $this->config->get('metroshop_body_bg_pattern');?>.png");
      }
      <?php } ?>
	
	
      <?php 
      if ($this->config->get('dxmetroshop_full_bg_image') == '1') {
      ?>
      body {
	background:url("<?php echo 'image/' . $this->config->get('dxmetroshop_full_image') ?>") repeat fixed center top transparent;
      } 	
      <?php   } ?>
      
      <?php 
	
      if ($this->config->get('metroshop_transparent_content') == '1') {
          
      ?>
      #container, .box .box-content, .mini-sliders {
	background:none;
	
      }
      #header #cart .content, .htabs a.selected {
	background:url("catalog/view/theme/metroshop/image/transparent_bg.png") transparent repeat;
	
      }
      <?php }  ?>
      
      /* font size */
      
        /* 12 */
      .help, .box-product .btn-wish, .box-product .btn-compare, .product-info .price-tax, .product-info .price .reward small, .product-info .price .discount, .product-info .minimum, #twitter_update_list {
        font-size:<?php echo ($this->config->get('metroshop_body_fontsize')-2) ?>px;
      }
      
      /* 14 */
      body, td, th, input, textarea, select, #currency a, #phone span, #menu > ul > li > a, #menu > ul > li ul > li > a, .pagination .links, .htabs a, .product-info .input-qty input, .box-product .name a, .box-product .link-cart, .box-category, .manufacturer-heading, .product-filter .display, .product-filter .sort, .product-filter .limit, .product-info > .left + .right, .attribute thead td, .attribute thead tr td:first-child, .checkout-heading {
	font-size:<?php echo $this->config->get('metroshop_body_fontsize') ?>px;
      }
      
      /* 16 */
      .box-product .price, #footer .column span {
	    font-size:<?php echo ($this->config->get('metroshop_body_fontsize')+3) ?>px;
      }
      
       /* 22 */
      .footer-about .text h1 {
	font-size:<?php echo ($this->config->get('metroshop_header_fontsize')-2) ?>px;
      }
       /* 24 */
      h1, .welcome, .box .box-heading, .product-info .price {
	font-size:<?php echo $this->config->get('metroshop_header_fontsize') ?>px;
      }
      /* 18 */
      h2, #phone, .product-list .list-product-item .center-block .list-name a, .product-list .list-product-item .right-block .list-price {
        font-size:<?php echo ($this->config->get('metroshop_header_fontsize')-6) ?>px;
      }
      
      /* font family */
      body {
	font-family:"<?php echo $this->config->get('metroshop_body_font') ?>";
      }
      
      h1, .welcome, h2, .box .box-heading, #footer .column span, .footer-about .social h1 {
	font-family:"<?php echo $this->config->get('metroshop_header_font') ?>";
	<?
	$header_font_weight = str_replace("italic","",$this->config->get('metroshop_header_font_weight'));
	if(strlen($header_font_weight) < strlen($this->config->get('metroshop_header_font_weight')))
	{
	  echo 'font-style: italic';
	}
	?>
	font-weight:<?=$header_font_weight?>;
	text-transform: <?php echo $this->config->get('metroshop_fonts_transform') ?>;
      }
      
      #menu > ul > li > a, #menu > ul > li ul > li > a, a.button, input.button, #footer .column span, .footer-about .text h1, .footer-about .social h1 {
	text-transform: <?php echo $this->config->get('metroshop_bfonts_transform') ?>;
      }
      
      /* colors */
      body, #currency a, .mini-cart-info td, .mini-cart-info .name small, .mini-cart-total td, table.form > * > * > td, .htabs a.selected, .htabs a:nth-child(even).selected, .htabs a:nth-child(odd).selected, .product-filter .sort, .product-filter .limit {
	color: #<?=$this->config->get('metroshop_color_text')?>;
      }

      h1, .welcome, h2, .box .box-heading {
	color: #<?=$this->config->get('metroshop_color_header_text')?>;
      }
      
      a, a:visited, a b {
	color: #<?=$this->config->get('metroshop_color_link')?>;
      }
      
      a:hover, #currency a:hover, #currency .active {
	color: #<?=$this->config->get('metroshop_color_linkhover')?>;
      }
      
      #header #cart .heading a, #header_mainmenu > a, #phone, #phone a, .htabs a {
        color: #<?=$this->config->get('metroshop_color_headermenu_link')?>;
      }
      
      #menu > ul > li > a {
        color: #<?=$this->config->get('metroshop_color_topmenu_link')?>;
      }
      
      #menu > ul > li:hover > a, .box-category > ul > li > a, .box-category > ul > li ul > li > a {
	color: #<?=$this->config->get('metroshop_color_topmenu_hover_link')?>;
      }
      
      #menu > ul > li ul > li > a:hover {
	    color: #<?=$this->config->get('metroshop_color_topmenu_submenu_hover_link')?>;
      }
      
      table.radio tr.highlight:hover td, .manufacturer-heading, .attribute thead td, .attribute thead tr td:first-child, .compare-info thead td, .compare-info thead tr td:first-child, .wishlist-info thead td, .cart-info thead td, .checkout-heading {
	    color: #<?=$this->config->get('metroshop_color_tableheader_text')?>;
      }
      
      .help {
	    color: #<?=$this->config->get('metroshop_color_product_descr')?>;
      }
      
      a.button, input.button, .pagination .links a, .pagination .links a:hover, .pagination .links b, .htabs a:hover, .box-product .btn-wish, .box-product .btn-compare, .product-compare a {
	    color: #<?=$this->config->get('metroshop_color_buttonlink')?>;
      }
      
      .product-info .right .breadcrumb a, .product-list .list-product-item .center-block .description, .box-product .name a, .box-product .link-cart, .category-info .description, .product-info > .left + .right, .product-info .description a, .product-info .price b, .product-info .price-tax {
	    color: #<?=$this->config->get('metroshop_color_product_link')?>;
      }
      
      .product-info .description span, .product-info .price .reward small, .product-info .price .discount, .product-info h2, .product-info .minimum {
	    color: #<?=$this->config->get('metroshop_color_product_descr')?>;
      }
      
      .product-list .list-product-item .right-block .list-price, .box-product .price, .product-info .price {
	    color: #<?=$this->config->get('metroshop_color_price')?>;
      }
	  
	  .box-product .price-old, .product-info .price-old, .compare-info .price-old {
	    color: #<?=$this->config->get('metroshop_color_priceold')?>;
      }
      
      #footer .column span {
	    color: #<?=$this->config->get('metroshop_color_footerheader')?>;
		font-weight: bold;
      }
      
      #footer .column a {
	    color: #<?=$this->config->get('metroshop_color_footerlink')?>;
      }
      
      .footer-about {
	    color: #<?=$this->config->get('metroshop_color_abouttext')?>;
      }
      
      .footer-about .text h1, .footer-about .social h1 {
	    color: #<?=$this->config->get('metroshop_color_aboutheader')?>;
      }
      
      #twitter_update_list {
	    color: #<?=$this->config->get('metroshop_color_footertext')?>;
      }
      
      /* borders */
      input[type='text'], input[type='password'], textarea, select, .mini-cart-info td, table.list, table.list td, .pagination, .manufacturer-list, .review-list, .attribute, .attribute td, .compare-info, .compare-info td, .wishlist-info table, .wishlist-info tbody td, .order-list .order-content, .return-list .return-content, .download-list .download-content, .cart-info table, .cart-info thead td, .cart-info tbody td, .cart-total, .checkout-heading, .checkout-product table, .checkout-product tbody td, .checkout-product tfoot td {
	    border-color:#<?=($this->config->get('metroshop_color_border'))?>;
      }
      
      .product-info .product-info-buttons, .product-info .price {
	    border-color:#<?=($this->config->get('metroshop_color_product_descr_border'))?>;
      }
      
      /* invert images */
      <?
      if($this->config->get('metroshop_invert_images') == 1)
      {
	?>
	.footer-about .text h1 {
	    background-image: url("catalog/view/theme/metroshop/image/about-icon-invert.png");
	}
	
	.footer-about .social h1 {
	    background-image: url("catalog/view/theme/metroshop/image/findus-icon-invert.png");
	}
	<?    
      }
      ?>
      
      <?
      if($this->config->get('contact_status') == 0)
      {
	?>
	.search-bar {
	    background-image: none;
        }
	<?    
      }
      ?>
      
      
      <?
      $metroshop_effects_carousel = $this->config->get('metroshop_effects_carousel');

      if($metroshop_effects_carousel !== 'enable')
      {
	?>
	.navigate  {
		display:none;
	  
	}
	.caruofredsel {
		height:auto;
	}
	.caruofredsel .box-product-item {
		margin-bottom:10px;
	}
	
	<?
      }
      ?>

</style> 
    <? } ?>
<style type="text/css">
 
@-moz-document url-prefix() {
    #search {
        margin-top:0px!important;
    }
}
</style>
</head>
<body>
<div id="fb-root"></div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/nb_NO/all.js#xfbml=1&appId=662123663822608";
  setTimeout(function() {
  fjs.parentNode.insertBefore(js, fjs);
  }, 5000);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="container">

<div id="header_menu" style="margin-top:10px;">

    <div class="header_welcome">
	
	<noindex>
    <?php echo $language; ?><?php if (!$logged) { ?>
    <?php echo $text_welcome; ?>
    <?php } else { ?>
    <?php echo $text_logged; ?>
    <?php } ?>
    </div>
	</noindex>
    <?php echo $currency; ?>
    <div class="clear"></div>
</div>      

<div id="header">
  <noindex>
  <div id="header_mainmenu">
  <?php //echo $home; ?>
  <?php if ($_SERVER['QUERY_STRING'] == true) {
  echo '<a href="'.$home.'" class="mm_logo" style="background-image: url('.$logo.');"></a>';
  }  
  else {
  echo '<a class="mm_logo" style="background-image: url('.$logo.');"></a>';
  }
  ?>
  
  <a href="<?php echo $home; ?>" class="mm_home" rel="nofollow"><?php echo $text_home; ?></a>
  <a class="mm_wishlist" href="<?php echo $wishlist; ?>" id="wishlist-total" rel="nofollow"><?php echo $text_wishlist; ?></a>
  <a class="mm_account" href="<?php echo $account; ?>" rel="nofollow"><?php echo $text_account; ?></a>
  <a class="mm_checkout" href="<?php echo $checkout; ?>" rel="nofollow"><?php echo $text_checkout; ?></a>
  
  <?php echo $cart; ?><div class="clear"></div></div>
</noindex>
<?php if ($categories) { ?>
<div class="box mobile-menu" style="display: none;">
  <div class="box-content">
    <div class="box-category">
      <ul>
        <?php foreach ($categories as $category) { ?>
        <li>
        
        
          <?php if ($category['children']) { echo '<div class="menuopen"></div>';}?><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
         
          <?php if ($category['children']) { ?>
          <ul>
            <?php foreach ($category['children'] as $child) { ?>
            <li>
             
              <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
            
            </li>
            <?php } ?>
          </ul>
          <?php } ?>
        </li>
        <?php } ?>
	<?
if($this->config->get('metroshop_layout_custommenu_item1_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item1_url').'">'.$this->config->get('metroshop_layout_custommenu_item1_text').'</a></li>';
if($this->config->get('metroshop_layout_custommenu_item2_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item2_url').'">'.$this->config->get('metroshop_layout_custommenu_item2_text').'</a></li>';
if($this->config->get('metroshop_layout_custommenu_item3_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item3_url').'">'.$this->config->get('metroshop_layout_custommenu_item3_text').'</a></li>';
if($this->config->get('metroshop_layout_custommenu_item4_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item4_url').'">'.$this->config->get('metroshop_layout_custommenu_item4_text').'</a></li>';
if($this->config->get('metroshop_layout_custommenu_item5_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item5_url').'">'.$this->config->get('metroshop_layout_custommenu_item5_text').'</a></li>';
if($this->config->get('metroshop_layout_custommenu_item6_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item6_url').'">'.$this->config->get('metroshop_layout_custommenu_item6_text').'</a></li>';
if($this->config->get('metroshop_layout_custommenu_item7_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item7_url').'">'.$this->config->get('metroshop_layout_custommenu_item7_text').'</a></li>';
if($this->config->get('metroshop_layout_custommenu_item8_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item8_url').'">'.$this->config->get('metroshop_layout_custommenu_item8_text').'</a></li>';
if($this->config->get('metroshop_layout_custommenu_item9_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item9_url').'">'.$this->config->get('metroshop_layout_custommenu_item9_text').'</a></li>';
if($this->config->get('metroshop_layout_custommenu_item10_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item10_url').'">'.$this->config->get('metroshop_layout_custommenu_item10_text').'</a></li>';

?>  
      </ul>
    </div>
  </div>
</div>
<?php } ?>
<?
// custom menu
if(($this->config->get('metroshop_status') == '1')&&($this->config->get('metroshop_layout_custommenu') == 1))
{
?>


<div id="menu" class="custom-menu clearfix">
  <ul>
<?
if($this->config->get('metroshop_layout_custommenu_item1_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item1_url').'">'.$this->config->get('metroshop_layout_custommenu_item1_text').'</a></li><li class="separator"></li>';
if($this->config->get('metroshop_layout_custommenu_item2_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item2_url').'">'.$this->config->get('metroshop_layout_custommenu_item2_text').'</a></li><li class="separator"></li>';
if($this->config->get('metroshop_layout_custommenu_item3_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item3_url').'">'.$this->config->get('metroshop_layout_custommenu_item3_text').'</a></li><li class="separator"></li>';
if($this->config->get('metroshop_layout_custommenu_item4_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item4_url').'">'.$this->config->get('metroshop_layout_custommenu_item4_text').'</a></li><li class="separator"></li>';
if($this->config->get('metroshop_layout_custommenu_item5_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item5_url').'">'.$this->config->get('metroshop_layout_custommenu_item5_text').'</a></li><li class="separator"></li>';
if($this->config->get('metroshop_layout_custommenu_item6_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item6_url').'">'.$this->config->get('metroshop_layout_custommenu_item6_text').'</a></li><li class="separator"></li>';
if($this->config->get('metroshop_layout_custommenu_item7_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item7_url').'">'.$this->config->get('metroshop_layout_custommenu_item7_text').'</a></li><li class="separator"></li>';
if($this->config->get('metroshop_layout_custommenu_item8_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item8_url').'">'.$this->config->get('metroshop_layout_custommenu_item8_text').'</a></li><li class="separator"></li>';
if($this->config->get('metroshop_layout_custommenu_item9_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item9_url').'">'.$this->config->get('metroshop_layout_custommenu_item9_text').'</a></li><li class="separator"></li>';
if($this->config->get('metroshop_layout_custommenu_item10_text')<>'') echo '<li><a href="'.$this->config->get('metroshop_layout_custommenu_item10_url').'">'.$this->config->get('metroshop_layout_custommenu_item10_text').'</a></li><li class="separator"></li>';

?>  
  </ul>
</div>
<?
}
else
{
?>
<?php if ($categories) { ?>
<div id="menu" class="clearfix">
  <ul>
    <?php foreach ($categories as $category) { ?>
    <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
      <?php if ($category['children']) { ?>
      <div>
        <?php for ($i = 0; $i < count($category['children']);) { ?>
        <ul>
          <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
          <?php for (; $i < $j; $i++) { ?>
          <?php if (isset($category['children'][$i])) { ?>
          <li><a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a></li>
          <?php } ?>
          <?php } ?>
        </ul>
        <?php } ?>
      </div>
      <?php } ?>
    </li><li class="separator"></li>
    <?php } ?>
  </ul>
</div>
<?php } ?>
<? } //end custom menu?>

<div class="search-bar">

  <?
      if(($this->config->get('metroshop_status') == '1')&&($this->config->get('contact_status') == 1))
      {
	$contact_subheader = $this->config->get('contact_subheader');
       
	if(empty($contact_subheader))
	{
	  $contact_subheader = 'Call us Monday - Saturday: 8:30 am - 6:00 pm';
	}
	
	$telephone1 = $this->config->get('telephone1');
       
	if(empty($telephone1))
	{
	  $telephone1 = '8(802)234-5678';
	}
	
	echo '<div id="phone" style="margin-right:25px;"><b>'.$telephone1.'</b><br><span>'.$contact_subheader.'</span></div>';
      }
      
  ?>
 <div class="fb-like" data-href="https://facebook.com/smartviking.no" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true" style="margin-top:15px;display:inline-block;"></div>  
  <div id="search">
    <div class="search-input">
  
    <input type="text" name="search" value="<?php echo $text_search; ?>" onclick="this.value = ''" />
 
    </div>
    <div class="button-search"></div>
  </div>
</div>

</div> <!-- end header -->
<noindex>
<div id="notification"></div>
</noindex>
