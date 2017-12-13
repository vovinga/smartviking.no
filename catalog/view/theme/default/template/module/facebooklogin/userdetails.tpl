<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
    <head>
    	<base href="<?php echo $base; ?>">
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" />
        <style type="text/css">
			#facebook-login-userdetails {
				margin: 20px;	
			}
			
			#facebook-login-userdetails form > div {
				margin: 5px;	
			}
			
			#facebook-login-userdetails form > div.error {
				margin-bottom: 10px;	
			}
			
			#facebook-login-userdetails form > div#facebook-info {
				margin-bottom: 20px;	
			}
		</style>
        <script type="text/javascript" src="catalog/view/javascript/facebooklogin/jquery-1.7.1.min.js"></script>
        <script type="text/javascript">
			$(document).ready(function() {
            <?php if ($has_customer_group) : ?>
				<?php if ($enabled['region']) : ?>
					$('#facebook-login-userdetails select[name=\'zone_id\']').parent().hide();
				<?php endif; ?>
				
                var triggerCustomerGroupDependentFields = function(value) {
                    var customer_group = [];
                    
                    <?php foreach ($customer_groups as $customer_group) { ?>
                    customer_group[<?php echo $customer_group['customer_group_id']; ?>] = [];
                    customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_display'] = '<?php echo $customer_group['company_id_display']; ?>';
                    customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_required'] = '<?php echo $customer_group['company_id_required']; ?>';
                    customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_display'] = '<?php echo $customer_group['tax_id_display']; ?>';
                    customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_required'] = '<?php echo $customer_group['tax_id_required']; ?>';
                    <?php } ?>	
                    
                    if (customer_group[value]) {
                        if (customer_group[value]['company_id_display'] == '1'<?php echo $enabled['company_id'] ? '&&true' : ''; ?>) {
                            $('#company-id-display').slideDown(300);
                        } else {
                            $('#company-id-display').slideUp(100);
                        }
                        
                        if (customer_group[value]['company_id_required'] == '1') {
                            $('#company-id-required').slideDown(300);
                        } else {
                            $('#company-id-required').slideUp(100);
                        }
                        
                        if (customer_group[value]['tax_id_display'] == '1'<?php echo $enabled['tax_id'] ? '&&true' : ''; ?>) {
                            $('#tax-id-display').slideDown(300);
                        } else {
                            $('#tax-id-display').slideUp(100);
                        }
                        
                        if (customer_group[value]['tax_id_required'] == '1') {
                            $('#tax-id-required').slideDown(300);
                        } else {
                            $('#tax-id-required').slideUp(100);
                        }	
                    }
                }
                
                <?php if (count($customer_groups) > 1) { ?>
                    $('#facebook-login-userdetails input[name=\'customer_group_id\']:checked').live('change', function() {
                        triggerCustomerGroupDependentFields($(this).val());
                    });
                    $('#facebook-login-userdetails input[name=\'customer_group_id\']:checked').trigger('change');
                    <?php } else { ?>
                    triggerCustomerGroupDependentFields($('#facebook-login-userdetails input[name=\'customer_group_id\']').val());
                    <?php } ?>
                <?php endif; ?>
				
				
				var triggerZoneField = function(value) {
					$.ajax({
						url: 'index.php?route=account/facebooklogin/country&country_id=' + value,
						dataType: 'json',
						beforeSend: function() {
							if ($('#facebook-login-userdetails select[name=\'country_id\']').length > 0) {
								$('#facebook-login-userdetails select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
							}
							<?php if ($enabled['region']) : ?>
								$('#facebook-login-userdetails select[name=\'zone_id\']').parent().slideUp(100);
							<?php endif; ?>
						},
						complete: function() {
							$('.wait').remove();
							<?php if ($enabled['region']) : ?>
								$('#facebook-login-userdetails select[name=\'zone_id\']').parent().slideDown();
							<?php endif; ?>
						},			
						success: function(json) {
							var html = '<div><strong><span id="postcode-required" class="required">*</span> <?php echo $entry_postcode; ?></strong><br /><input type="text" name="postcode" value="" class="large-field" /></div>';
							
							var element = $('<?php echo $enabled['region'] ? 'select[name="zone_id"]' : ($enabled['country'] ? 'select[name="country_id"]' : 'input[name="country_id"]'); ?>');
							
							<?php if ($enabled['postcode']) { ?>
								if ($('input[name="postcode"]').length == 0) $(element).parent().after(html);
							<?php } ?>
							
							if (json['postcode_required'] == '1') {
								<?php if ($enabled['postcode']) { ?>
									$('#postcode-required').show(100);
								<?php } ?>
							} else {
								<?php if (!$enabled['postcode']) { ?>
									$('input[name="postcode"]').parent().slideUp(100).remove();
								<?php } else { ?>
									$('#postcode-required').hide(100);
								<?php } ?>
							}
							
							html = '<option value=""><?php echo $text_select; ?></option>';
							
							if (json['zone'] != '' && typeof(json['zone']) != 'undefined') {
								for (i = 0; i < json['zone'].length; i++) {
									html += '<option value="' + json['zone'][i]['zone_id'] + '"';
									
									if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
										html += ' selected="selected"';
									}
					
									html += '>' + json['zone'][i]['name'] + '</option>';
								}
							} else {
								html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
							}
							
							$('#facebook-login-userdetails select[name=\'zone_id\']').html(html);
						},
						error: function(xhr, ajaxOptions, thrownError) {
							console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});
				}
			
				<?php if ($enabled['country']) { ?>
				$('#facebook-login-userdetails select[name=\'country_id\']').bind('change', function() {
					triggerZoneField($(this).val());
				});
				triggerZoneField($('#facebook-login-userdetails select[name=\'country_id\']').val());
				<?php } else { ?>
				triggerZoneField($('#facebook-login-userdetails input[type=\'hidden\'][name=\'country_id\']').val());
				<?php } ?>
				
				$('a[href!=""]').click(function(e) {
					e.preventDefault();
					window.open($(this).attr('href'), '_blank');
				});
				
				$('#button-submit').live('click', function(e) {
					e.preventDefault();
					var fields = $('<?php echo $has_customer_group ? ((count($customer_groups) > 1 ? 'input[name="customer_group_id"]:checked' : 'input[name="customer_group_id"]').', input[name="tax_id"], input[name="company_id"]') : '' ?>, input[name="telephone"], input[name="fax"], input[name="address_1"], input[name="address_2"], input[name="city"], input[name="postcode"], <?php echo $enabled['country'] ? 'select[name="country_id"]' : 'input[name="country_id"]'; ?>, select[name="zone_id"], input[name="newsletter"]:checked, input[name="agree"]:checked');
					
					$.ajax({
						url: 'index.php?route=account/facebooklogin/validate',
						type: 'post',
						data: fields,
						dataType: 'json',
						beforeSend: function() {
							$('#button-submit').attr('disabled', true);
							$(fields).attr('disabled', true);
							$('#button-submit').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
						},	
						complete: function() {
							$('#button-submit').attr('disabled', false);
							$(fields).attr('disabled', false);
							$('.wait').remove();
						},				
						success: function(json) {
							$('.warning, .error').remove();
							
							if (json['error']) {
								for (var i in json['error']) {
									$('input[name="'+i+'"],select[name="'+i+'"]').parent().append('<div class="error">'+json['error'][i]+'</div>');
								}
							} else {
								$(fields).attr('disabled', false);
								$('#facebook-login-userdetails form').submit();
							}
						},
						error: function(xhr, ajaxOptions, thrownError) {
							console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});	
				});
				
				setInterval(function() {
					window.resizeTo(400, $('html').outerHeight() + 100);
				}, 100);
            });
        </script> 
    </head>
    <body>
    	<div id="facebook-login-userdetails">
            <form method="POST" action="<?php echo $this->url->link('account/facebooklogin/submit', '', 'SSL'); ?>">
                <div id="facebook-info"><?php echo $text_your_details; ?></div>
                
                <?php if ($has_customer_group) : ?>
                    <?php if (count($customer_groups) > 1) { ?>
                        <div><strong><span class="required">*</span> <?php echo $text_customer_group; ?></strong><br />
                        <?php foreach($customer_groups as $customer_group) : ?>
                            <div>
                                <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" id="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"<?php echo $customer_group['customer_group_id'] == $customer_group_id ? ' checked="checked"' : '' ?>/>
                                <label for="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    <?php } else { ?>
                        <div>
                            <input type="hidden" name="customer_group_id" value="<?php echo $customer_group_id; ?>"/>
                        </div>
                    <?php } ?>
                <?php endif; ?>
                
                <?php if ($has_customer_group && $enabled['tax_id']) : ?>
                <div id="tax-id-display">
                    <strong><span id="tax-id-required" class="required">*</span> <?php echo $entry_tax_id; ?></strong><br />
                    <input type="text" name="tax_id" value="" class="large-field" />
                </div>
                <?php endif; ?>
                
                <?php if ($enabled['telephone']) : ?>
                <div>
                    <strong><span class="required">*</span> <?php echo $entry_telephone; ?></strong><br />
                    <input type="text" name="telephone" value="" class="large-field" />
                </div>
                <?php endif; ?>
                
                <?php if ($enabled['fax']) : ?>
                <div>
                    <strong><?php echo $entry_fax; ?></strong><br />
                    <input type="text" name="fax" value="" class="large-field" />
                </div>
                <?php endif; ?>
                
                <?php if ($enabled['company']) : ?>
                <div>
                    <strong><?php echo $entry_company; ?></strong><br />
                    <input type="text" name="company" value="" class="large-field" />
                </div>
                <?php endif; ?>
                
                
                <?php if ($has_customer_group && $enabled['company_id']) : ?>
                <div id="company-id-display">
                    <strong><span id="company-id-required" class="required">*</span> <?php echo $entry_company_id; ?></strong><br />
                    <input type="text" name="company_id" value="" class="large-field" />
                </div>
                <?php endif; ?>
                
                <?php if ($enabled['address']) : ?>
                <div>
                    <strong><span class="required">*</span> <?php echo $entry_address_1; ?></strong><br />
                    <input type="text" name="address_1" value="" class="large-field" />
                </div>
                
                <div>
                    <strong><?php echo $entry_address_2; ?></strong><br />
                    <input type="text" name="address_2" value="" class="large-field" />
                </div>
                <?php endif; ?>
                
                <?php if ($enabled['country']) { ?>
                <div>
                    <strong><span class="required">*</span> <?php echo $entry_country; ?></strong><br />
                    <select name="country_id" class="large-field">
                        <option value=""><?php echo $text_select; ?></option>
                        <?php foreach ($countries as $country) { ?>
                            <option value="<?php echo $country['country_id']; ?>"<?php echo $country['country_id'] == $country_id ? ' selected="selected"' : ''; ?>><?php echo $country['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php } else { ?>
                <div>
                    <input type="hidden" value="<?php echo $country_id; ?>" name="country_id" />
                </div>
                <?php } ?>
                
                <?php if ($enabled['region']) : ?>
                <div>
                    <strong><span class="required">*</span> <?php echo $entry_zone; ?></strong><br />
                    <select name="zone_id" class="large-field">
                    </select>
                </div>
                <?php endif; ?>
                
                <?php if ($enabled['postcode']) : ?>
                <div>
                    <strong><span id="postcode-required" class="required">*</span> <?php echo $entry_postcode; ?></strong><br />
                    <input type="text" name="postcode" value="" class="large-field" />
                </div>
                <?php endif; ?>
                
                <?php if ($enabled['city']) : ?>
                <div>
                    <strong><span class="required">*</span> <?php echo $entry_city; ?></strong><br />
                    <input type="text" name="city" value="" class="large-field" />
                </div>
                <?php endif; ?>
                
                <?php if ($enabled['newsletter']) : ?>
                <div>
                    <input type="checkbox" name="newsletter" value="1" id="newsletter" />
                    <label for="newsletter"><?php echo $entry_newsletter; ?></label>
                </div>
                <?php endif; ?>
                
                <?php if ($enabled['privacy']) : ?>
                <div>
                    <input type="checkbox" name="agree" value="1" id="agree" />
                    <label for="agree"><?php echo $text_agree; ?></label>
                </div>
                <?php endif; ?>
                
                <div>
                    <input type="button" value="<?php echo $button_submit; ?>" id="button-submit" class="button" />
                </div>
            </form>
        </div>
	</body>
</html>