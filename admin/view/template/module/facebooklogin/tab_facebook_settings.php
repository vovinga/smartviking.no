<div id="tabs" class="htabs">
	<?php foreach ($stores as $store) : ?>
    <a href="#tab-facebooklogin_<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></a>
    <?php endforeach; ?>
</div>
<?php foreach ($stores as $store) : ?>
<div id="tab-facebooklogin_<?php echo $store['store_id']; ?>">
    <table class="form wideBoxes">
      <tr>
        <td><span class="required">*</span> <?php echo $entry_enable_disable; ?></td>
        <td>
          <select name="FacebookLogin[<?php echo $store['store_id']; ?>][Enabled]">
            <option value="No" <?php echo(!empty($data['FacebookLogin'][$store['store_id']]['Enabled']) && $data['FacebookLogin'][$store['store_id']]['Enabled'] == 'No') ? 'selected="selected"' : '' ; ?>><?php echo $text_disabled; ?></option>   
            <option value="Yes" <?php echo(!empty($data['FacebookLogin'][$store['store_id']]['Enabled']) && $data['FacebookLogin'][$store['store_id']]['Enabled'] == 'Yes') ? 'selected="selected"' : '' ; ?>><?php echo $text_enabled; ?></option>        
          </select>
        </td>
      </tr>
      <tr class="hideableRow">
    	<td><span class="required">*</span> <?php echo $entry_redirect; ?></td>
    	<td>
    	<strong><?php echo $entry_callback[$store['store_id']]; ?></strong>
    	</td>
      </tr>
      <tr class="hideableRow">
        <td><span class="required">*</span> <?php echo $entry_api; ?></td>
        <td>
          <input type="text" name="FacebookLogin[<?php echo $store['store_id']; ?>][APIKey]" value="<?php echo(!empty($data['FacebookLogin'][$store['store_id']]['APIKey'])) ? $data['FacebookLogin'][$store['store_id']]['APIKey'] : '' ; ?>" />
        </td>
      </tr>
      <tr class="hideableRow">
        <td><span class="required">*</span> <?php echo $entry_secret; ?></td>
        <td>
          <input type="text" name="FacebookLogin[<?php echo $store['store_id']; ?>][APISecret]" value="<?php echo (!empty($data['FacebookLogin'][$store['store_id']]['APISecret'])) ? $data['FacebookLogin'][$store['store_id']]['APISecret'] : '' ; ?>" />
        </td>
      </tr>
      <tr class="hideableRow">
        <td><?php echo $entry_preview; ?></td>
        <td>
          <div class="buttonPreview">
          	<div id="facebookButtonWrapper">
                <div class="facebookButton">
                    <div class="box box-fbkconnect">
                      <div class="box-heading"><?php echo(isset($data['FacebookLogin'][$store['store_id']]['WrapperTitle_'.$firstLanguageCode])) ? $data['FacebookLogin'][$store['store_id']]['WrapperTitle_'.$firstLanguageCode] : 'Login with Facebook' ; ?></div>
                      <div class="box-content">
                      <?php $langarray = $languages; $lang = array_shift($langarray); ?>
                        <a href="javascript:void(0)" class="<?php echo !empty($data['FacebookLogin'][$store['store_id']]['ButtonDesign']) ? $data['FacebookLogin'][$store['store_id']]['ButtonDesign'] : 'fbkStandardBtn'; ?>"><span></span><div class="fbkTitle" style="display:inline;"><?php echo !empty($data['FacebookLogin'][$store['store_id']]['ButtonName_'.$firstLanguageCode]) ? $data['FacebookLogin'][$store['store_id']]['ButtonName_'.$firstLanguageCode] : ''; ?></div></a>
                      </div>
                    </div>
                </div>
            </div>
          </div>
        </td>
      </tr>
      <tr class="hideableRow">
        <td><span class="required">*</span> <?php echo $entry_design; ?></td>
        <td>
            <select name="FacebookLogin[<?php echo $store['store_id']; ?>][ButtonDesign]" class="FacebookBtnDesign">
                <option value="fbkStandardBtn" <?php echo(!empty($data['FacebookLogin'][$store['store_id']]['ButtonDesign']) && $data['FacebookLogin'][$store['store_id']]['ButtonDesign'] == 'fbkStandardBtn') ? 'selected="selected"' : '' ; ?>>Standard UI</option> 
                <option value="fbkMetroStyleBtn" <?php echo(!empty($data['FacebookLogin'][$store['store_id']]['ButtonDesign']) && $data['FacebookLogin'][$store['store_id']]['ButtonDesign'] == 'fbkMetroStyleBtn') ? 'selected="selected"' : '' ; ?>>Metro UI</option>        
                <option value="fbkRoundedBtn" <?php echo(!empty($data['FacebookLogin'][$store['store_id']]['ButtonDesign']) && $data['FacebookLogin'][$store['store_id']]['ButtonDesign'] == 'fbkRoundedBtn') ? 'selected="selected"' : '' ; ?>>Rounded UI</option>        
                <option value="" <?php echo(empty($data['FacebookLogin'][$store['store_id']]['ButtonDesign']) || $data['FacebookLogin'][$store['store_id']]['ButtonDesign'] == '') ? 'selected="selected"' : '' ; ?>><?php echo $entry_no_design; ?></option>        
            </select>
       </td>
      </tr>
      <tr class="hideableRow">
        <td><span class="required">*</span> <?php echo $entry_wrap_into_widget; ?></td>
        <td>
            <select name="FacebookLogin[<?php echo $store['store_id']; ?>][WrapIntoWidget]" class="FacebookWrapIntoWidget">
                <option value="No" <?php echo(!empty($data['FacebookLogin'][$store['store_id']]['WrapIntoWidget']) && $data['FacebookLogin'][$store['store_id']]['WrapIntoWidget'] == 'No') ? 'selected="selected"' : '' ; ?>><?php echo $entry_no; ?></option>   
                <option value="Yes" <?php echo(!empty($data['FacebookLogin'][$store['store_id']]['WrapIntoWidget']) && $data['FacebookLogin'][$store['store_id']]['WrapIntoWidget'] == 'Yes') ? 'selected="selected"' : '' ; ?>><?php echo $entry_yes; ?></option>        
            </select>
        </td>
      </tr>
      <tr class="hideableRow fbkWrapperTitle" <?php echo(!empty($data['FacebookLogin'][$store['store_id']]['WrapIntoWidget']) && $data['FacebookLogin'][$store['store_id']]['WrapIntoWidget'] == 'Yes') ? '' : 'style="display:none"' ; ?>>
        <td><span class="required">*</span> <?php echo $entry_wrapper_title; ?></td>
        <td>
        	<?php foreach ($languages as $lang) : ?>
            <img src="view/image/flags/<?php echo $lang['image']; ?>" title="<?php echo $lang['name']; ?>" />
            <input type="text" class="wrapperTitleTextbox" name="FacebookLogin[<?php echo $store['store_id']; ?>][WrapperTitle_<?php echo $lang['code']; ?>]" value="<?php echo(!empty($data['FacebookLogin'][$store['store_id']]['WrapperTitle_'.$lang['code']])) ? $data['FacebookLogin'][$store['store_id']]['WrapperTitle_'.$lang['code']] : 'Login' ; ?>" /><br />
            <?php endforeach; ?>
        </td>
      </tr>
      <tr class="hideableRow">
        <td><span class="required">*</span> <?php echo $entry_button_name; ?></td>
        <td class="buttonNameTextboxes">
            <?php foreach ($languages as $lang) : ?>
            <img src="view/image/flags/<?php echo $lang['image']; ?>" title="<?php echo $lang['name']; ?>" /> <input type="text" name="FacebookLogin[<?php echo $store['store_id']; ?>][ButtonName_<?php echo $lang['code']; ?>]" value="<?php echo (!empty($data['FacebookLogin'][$store['store_id']]['ButtonName_'.$lang['code']])) ? $data['FacebookLogin'][$store['store_id']]['ButtonName_'.$lang['code']] : 'Login with Facebook' ; ?>" /><br />
            <?php endforeach; ?>
       </td>
      </tr>
      
      <tr class="hideableRow">
        <td><span class="required">*</span> <?php echo $entry_use_oc_settings; ?></td>
        <td class="extraFields">
            <input type="checkbox" value="true" class="FacebookLoginUseDefaultCustomerGroups" name="FacebookLogin[<?php echo $store['store_id']; ?>][UseDefaultCustomerGroups]"<?php echo empty($data['FacebookLogin'][$store['store_id']]['UseDefaultCustomerGroups']) ? '' : 'checked="checked"'; ?> />
       </td>
      </tr>
      <tr class="hideableRow FacebookLoginCustomerGroupTR">
        <td><span class="required">*</span> <?php echo $entry_assign_to_cg; ?></td>
        <td>
            <?php if (!empty($customer_groups)) : ?>
            <select name="FacebookLogin[<?php echo $store['store_id']; ?>][CustomerGroup]" class="FacebookLoginCustomerGroup">
                <?php foreach ($customer_groups as $cg) : ?>
                <option value="<?php echo $cg['customer_group_id']; ?>"<?php echo !empty($data['FacebookLogin'][$store['store_id']]['CustomerGroup']) && $cg['customer_group_id'] == $data['FacebookLogin'][$store['store_id']]['CustomerGroup'] ? ' selected="selected"' : ''; ?>><?php echo $cg['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <?php endif; ?>
       </td>
      </tr>
      
      <tr class="hideableRow">
        <td><?php echo $entry_new_user_details; ?></td>
        <td class="extraFields">
            <?php foreach($more_user_details as $detail) : ?>
            <div>
                <input type="checkbox" id="FacebookLogin<?php echo $store['store_id']; ?>_<?php echo $detail['name'] ?>" class="FacebookLogin<?php echo $detail['name'] ?>" name="FacebookLogin[<?php echo $store['store_id']; ?>][<?php echo $detail['name'] ?>]"<?php echo empty($data['FacebookLogin'][$store['store_id']][$detail['name']]) ? ($detail['default_checked'] ? 'checked="checked"' : '') : 'checked="checked"'; ?>/><label for="FacebookLogin<?php echo $store['store_id']; ?>_<?php echo $detail['name'] ?>"><?php echo $detail['text'] ?></label>
            </div>
            <?php endforeach; ?>
       </td>
      </tr>
      <tr class="hideableRow">
        <td><?php echo $entry_custom_css; ?></td>
        <td>
            <textarea name="FacebookLogin[<?php echo $store['store_id']; ?>][CustomCSS]" style="width:320px; height:70px;"><?php echo (!empty($data['FacebookLogin'][$store['store_id']]['CustomCSS'])) ? $data['FacebookLogin'][$store['store_id']]['CustomCSS'] : '.facebookButton { margin: 0 0 20px 0; }' ; ?></textarea>
        </td>
      </tr>
    </table>
    <script type="text/javascript">
	$(document).ready(function() {
		// Preview Logic
	
		$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .FacebookBtnDesign').change(function() {
			$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .buttonPreview .box-content > a').removeClass().addClass($(this).val());
		}).trigger('change');
		
		$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .wrapperTitleTextbox').keyup(function() {
			$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .buttonPreview .box-heading').html($(this).val());
		}).focus(function() {
			$(this).trigger('keyup');	
		});
		
		$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .FacebookWrapIntoWidget').change(function() {
			if ($(this).val() == 'Yes') {
				$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .buttonPreview').removeClass('noBoxWrapper');
			} else {
				$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .buttonPreview').removeClass('noBoxWrapper').addClass('noBoxWrapper');
			}
		}).trigger('change');
		
		$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .buttonNameTextboxes input').keyup(function() {
			$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .buttonPreview div.fbkTitle').html($(this).val());
		}).focus(function() {
			$(this).trigger('keyup');	
		});
		
		// END Preview Logic
		
		$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .FacebookWrapIntoWidget').change(function() {
			if ($(this).val() == 'Yes') {
				$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .fbkWrapperTitle').show();
			} else {
				$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .fbkWrapperTitle').hide();
			}
		}).trigger('change');
		
		$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .FacebookLoginUseDefaultCustomerGroups').change(function() {
			if($(this).is(':checked')) $('#tab-facebooklogin_<?php echo $store['store_id']; ?> .FacebookLoginCustomerGroupTR').hide();
			else $('#tab-facebooklogin_<?php echo $store['store_id']; ?> .FacebookLoginCustomerGroupTR').show();
		}).trigger('change');
		
		$('#tab-facebooklogin_<?php echo $store['store_id']; ?> select[name="FacebookLogin[<?php echo $store['store_id']; ?>][Enabled]"]').change(function() {
			if ($(this).val() == 'Yes') {
				$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .hideableRow').show();
				$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .FacebookWrapIntoWidget').trigger('change');
				$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .FacebookLoginUseDefaultCustomerGroups').trigger('change');
			} else {
				$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .hideableRow').hide();
			}
		}).trigger('change');
		
		<?php if ($has_customer_group) : ?>
		$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .FacebookLoginCustomerGroup').live('change', function() {
			
			var customer_group = [];
			
			<?php foreach ($customer_groups as $customer_group) { ?>
			customer_group[<?php echo $customer_group['customer_group_id']; ?>] = [];
			customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_display'] = '<?php echo $customer_group['company_id_display']; ?>';
			customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_required'] = '<?php echo $customer_group['company_id_required']; ?>';
			customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_display'] = '<?php echo $customer_group['tax_id_display']; ?>';
			customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_required'] = '<?php echo $customer_group['tax_id_required']; ?>';
			<?php } ?>	
			
			if (customer_group[$(this).val()]) {
				if (customer_group[$(this).val()]['company_id_display'] == '1') {
					$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .FacebookLoginExtraCompanyId').prop('checked', true);
				} else {
					$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .FacebookLoginExtraCompanyId').prop('checked', false);
				}
				
				if (customer_group[$(this).val()]['tax_id_display'] == '1') {
					$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .FacebookLoginExtraTaxId').prop('checked', true);
				} else {
					$('#tab-facebooklogin_<?php echo $store['store_id']; ?> .FacebookLoginExtraTaxId').prop('checked', false);
				}	
			}
		});
		<?php endif; ?>
	});
    </script>
</div>
<?php endforeach; ?>
<script type="text/javascript">
$('#tabs a').tabs();
$(document).ready(function() {
	$('#tabs a').each(function(index) {
		$(this).click(function() {
			$('.selectedStore').val(index);
		});
	});
	var selectedStore = $('.selectedStore').val();
	$('#tabs a').eq(selectedStore).trigger('click');
});
</script>