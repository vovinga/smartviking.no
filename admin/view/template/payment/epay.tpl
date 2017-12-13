<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
		<h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
    	<div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  	</div>
  	<div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
	  	<tr>
          <td><?php echo $text_help ?></td>
          <td><a href="http://www.opencartguiden.dk" target="_blank">www.opencartguiden.dk</a></td>
        </tr>
	    <tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="epay_status">
              <?php if ($epay_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
	    <tr>
          <td><?php echo $text_payment ?></td>
          <td><input type="text" name="epay_payment_name" value="<?php echo $epay_payment_name; ?>" /></td>
        </tr>
	    <tr>
          <td><?php echo $text_merchantnumber ?></td>
          <td><input type="text" name="epay_merchant_number" value="<?php echo $epay_merchant_number; ?>" /></td>
        </tr>
		<tr>
          <td><?php echo $entry_order_status; ?></td>
          <td><select name="epay_order_status_id">
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $epay_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
			</td>
        </tr>
	    <tr>
          <td><?php echo $text_paymentwindow ?></td>
          <td>
		 	<select name="epay_payment_window">
              <option value="1" <?php echo $epay_payment_window==1 ? 'selected' : '' ?>><?php echo $text_paymentwindow_overlay ?></option>
			  <option value="3" <?php echo $epay_payment_window==3 ? 'selected' : '' ?>><?php echo $text_paymentwindow_fullscreen ?></option>
            </select>
		  </td>
        </tr>
	    <tr>
          <td><?php echo $text_ownreceipt ?></td>
          <td>
		 	<select name="epay_ownreceipt">
              <option value="0" <?php echo $epay_ownreceipt==0 ? 'selected' : '' ?>><?php echo $text_no ?></option>
			  <option value="1" <?php echo $epay_ownreceipt==1 ? 'selected' : '' ?>><?php echo $text_yes ?></option>
            </select>
		  </td>
        </tr>
		<tr>
          <td>MD5 Key</td>
          <td><input type="text" name="epay_md5key" value="<?php echo $epay_md5key; ?>" /></td>
        </tr>
		<tr>
          <td><?php echo $text_group ?></td>
          <td><input type="text" name="epay_group" value="<?php echo $epay_group; ?>" /></td>
        </tr>
		<tr>
          <td>Auth SMS</td>
          <td><input type="text" name="epay_authsms" value="<?php echo $epay_authsms; ?>" /> <?php echo $text_service_not_free ?></td>
        </tr>
		 <tr>
          <td>Auth E-mail</td>
          <td><input type="text" name="epay_authemail" value="<?php echo $epay_authemail; ?>" /></td>
        </tr>
	    <tr>
          <td>Instant capture</td>
          <td>
		  	<select name="epay_instantcapture">
              <option value="0" <?php echo $epay_instantcapture==0 ? 'selected' : '' ?>><?php echo $text_no ?></option>
			  <option value="1" <?php echo $epay_instantcapture==1 ? 'selected' : '' ?>><?php echo $text_yes ?></option>
            </select>
		  </td>
        </tr>
		
        <tr>
          <td><?php echo $entry_geo_zone; ?></td>
          <td><select name="epay_geo_zone_id">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $epay_geo_zone_id) { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>

        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="epay_sort_order" value="<?php echo $epay_sort_order; ?>" size="1" /></td>
        </tr>
      </table>
    </form>
  	</div>
</div>
<?php echo $footer; ?>