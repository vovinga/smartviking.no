<?php echo $header; ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </div>
  
	<style type="text/css">
		.shortcuts {text-align:center;}
		.shortcuts ul {list-style: none;margin:0;padding:0;}
		.shortcuts li {width: 90px;height: 120px;line-height:normal;display:inline-block;vertical-align:top;padding:10px 10px;border:1px solid #ccc;margin: 7px 9px 15px 9px;}
		.shortcuts li a {text-decoration: none;}
		.shortcuts li:hover {border:1px solid #aaa;background: #ddd;}
		.shortcuts li img {padding: 8px 20px 12px 14px;}
		.shortcuts li h6 {color: #333;font-size:11px;margin:0;padding:0;}
	</style>

  <!--<h1><span><?php echo $heading_title; ?></span></h1>-->
  
  <h2 style="margin-top: 20px;"><?php echo $text_my_account; ?></h2>
  <div class="shortcuts">
    <ul>
      <li><a href="<?php echo $edit; ?>"> <img src="catalog/view/theme/default/image/account/customers.png"> 
	  <h6><?php echo $text_edit; ?></h6>
	  </a></li>
      <li><a href="<?php echo $password; ?>"> <img src="catalog/view/theme/default/image/account/password.png"> 
	  <h6><?php echo $text_password; ?></h6>
	  </a></li>
	  <li><a href="<?php echo $payment; ?>"> <img src="catalog/view/theme/default/image/account/transaction.png">
	  <h6><?php echo $text_payment; ?></h6>
	  </a></li>
	  <li><a href="<?php echo $tracking; ?>"> <img src="catalog/view/theme/default/image/account/reward.png">
	  <h6><?php echo $text_tracking; ?></h6>
	  </a></li>
	  <li><a href="<?php echo $transaction; ?>"> <img src="catalog/view/theme/default/image/account/orders.png">
	  <h6><?php echo $text_transaction; ?></h6>
	  </a></li>
	</ul>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>