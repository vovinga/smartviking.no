<?php $passURLRoute = (!empty($data['ComparePrices']['URLRoute'])) ? ($data['ComparePrices']['URLRoute'] == $this->request->get['route']) : true; ?>
<?php if($passURLRoute) { ?>
<?php if($data['ComparePrices']['Enabled'] != 'no'): ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $currenttemplate?>/stylesheet/compareprices.css" />

<?php if($data['ComparePrices']['showInTab'] == 'no') { ?>
<!-- ComparePrices START -->
<h2><?php echo $h2_ComparePrices; ?></h2>
			<?php if (empty($ComparePricesSpecial)) $final_price=$ComparePricesPrice; else $final_price=$ComparePricesSpecial; ?>
            <?php $ComparePricesName = (empty($firstname)) ? "" : $firstname." ".$lastname; ?>
            <?php $ComparePricesEmail = $email; ?>
            <?php $ifInProduct = ((isset($this->request->get['route'])) && ($this->request->get['route']=="product/product")) ? true : false; ?>
            <?php $showPrice = ($ifInProduct) ? "<br/><small>".$ourPrice.": <strong>".$final_price."<strong></small>" : ""; ?>
            <div id="ComparePricesSuccess"></div>
			<div id="ComparePrices" style="width: <?php echo $data['ComparePrices']['Width']; ?>px;">		
			<div style="width:50%;padding:10px;float:right;"><strong><?php echo $pleaseFillInTheForm; ?></strong>
			<br /><small><span class="required">*</span> <?php echo $requiredFields; ?></small><br />
			<form id="ComparePricesForm">
			  <table class="form">
				<tr><td><span class="required">*</span> <?php echo $yourName; ?>:</td><td><input type="text" name="YourName" id="YourName" value="<?php echo $ComparePricesName; ?>"></td></tr>
				<tr><td><span class="required">*</span> <?php echo $yourEmail; ?>:</td><td><input type="text" name="YourEmail" id="YourEmail" value="<?php echo $ComparePricesEmail; ?>"></td></tr>
				<tr><td><span class="required">*</span> <?php echo $priceInOtherStore; ?>:<?php echo $showPrice; ?></td><td><input type="text" name="PriceInOtherStore" id="PriceInOtherStore"></td></tr>
				<tr><td><span class="required">*</span> <?php echo $linkToTheProduct; ?>:</td><td><input type="text" name="LinkToTheProduct" id="LinkToTheProduct"></td></tr>
				<tr><td colspan="2"><?php echo $commentsOptional; ?>:</td></tr>
				<tr><td colspan="2"><textarea name="YourComments" id="YourComments" style="width:310px !important; height:70px;" placeholder="<?php echo $isThereSomethingMoreWeShouldKnow; ?>"></textarea>
				<input type="hidden" name="CurrentProductURL" value="<?php echo $comparePricesCurrentURL; ?>">
                <?php if ($ifInProduct) { ?>
				<input type="hidden" name="CurrentProductName" value="<?php echo $ComparePricesProductName; ?>">
				<input type="hidden" name="CurrentProductPrice" value="<?php echo $final_price; ?>">
                <?php } ?>
                </td></tr>
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
<?php } ?>
<script>
$('#ComparePricesSubmit').on('click', function(){
	var email_validate = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if ((document.getElementById("YourName").value == 0) || 
	(document.getElementById("YourEmail").value.length == 0) ||
	(document.getElementById("PriceInOtherStore").value.length == 0) || 
	(document.getElementById("LinkToTheProduct").value.length == 0))
	{
    	alert("<?php echo $errorRequiredFields; ?>")
	} else if (!document.getElementById("YourEmail").value.match(email_validate)) {
		alert("<?php echo $errorInvalidEmail; ?>")
	} else {
		$.ajax({
			url: 'index.php?route=module/compareprices/sendemail',
			type: 'post',
			data: $('#ComparePricesForm').serialize(),
			dataType: 'json',
			success: function(response) {
				$('#ComparePricesSuccess').html("<div class='success' style='display: none;'><?php echo $successfulSubmit; ?></div>");
				$('.success').fadeIn('slow');
				$('#YourName').val('');
				$('#YourEmail').val('');
				$('#PriceInOtherStore').val('');
				$('#LinkToTheProduct').val('');
				$('#YourComments').val('');
			}
		});
	}
});
</script>
<!-- ComparePrices END -->
<style type="text/css">
<?php if($data['ComparePrices']['HideTabs'] != 'no'): ?>
.htabs, .tab-content {
	display:none !important;	
}
<?php endif; ?>
</style>

<?php endif; ?>
<?php } ?>