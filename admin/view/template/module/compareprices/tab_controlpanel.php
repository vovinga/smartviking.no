<table class="form">
  <tr>
    <td><span class="required">*</span> <?php echo $entry_code; ?></td>
    <td>
        <select name="ComparePrices[Enabled]" class="ComparePricesEnabled">
            <option value="yes" <?php echo ($data['ComparePrices']['Enabled'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
            <option value="no" <?php echo ($data['ComparePrices']['Enabled'] == 'no') ? 'selected=selected' : '' ?>>Disabled</option>
        </select>
   </td>
  </tr>
  <tr class="ComparePricesActiveTR">
    <td><span class="required">*</span> <?php echo $entry_layouts_active; ?></td>
    <td>
    <?php $i=0; $checked=""; ?>
    <?php foreach ($layouts as $layout) { ?>
    <?php 
	    $status = null;
        foreach ($modules as $module) {
            if(!empty($module)) {
                if ($module['layout_id'] == $layout['layout_id']) {
                    $status = $module['status'];
                    if ((int)$status == 1) {
                        $checked = ' checked=checked';
                    } else { 
                        $checked = '';
                   }
                }
            } 
          
          }
          if (!isset($status) && $layout['name'] == 'Product') {
                $status = 1;
                $checked = ' checked=checked';	
          }
		  if (!isset($status) && $layout['name'] == 'Sitemap') {
                $status = 0;
                $checked = '';	
          }

    ?>
    <div class="ComparePricesLayout">
        <input type="checkbox" value="<?php echo $layout['layout_id']; ?>" id="ComparePricesActive<?php echo $i?>" <?php echo $checked?> /><label for="ComparePricesActive<?php echo $i?>"><?php echo $layout['name']; ?></label>
        <input type="hidden" name="compareprices_module[<?php echo $i?>][position]" value="content_bottom" />
        <input type="hidden" class="ComparePricesItemLayoutIDField" name="compareprices_module[<?php echo $i?>][layout_id]" value="<?php echo $layout['layout_id']; ?>" />
        <input type="hidden" class="ComparePricesItemStatusField" name="compareprices_module[<?php echo $i?>][status]" value="<?php echo $status ?>" />
        <input type="hidden" name="compareprices_module[<?php echo $i?>][sort_order]" value="<?php echo $i+10?>" />
    </div>
    <?php $i++;} ?>
     </td>
  </tr>
</table>
<script>
$('.ComparePricesLayout input[type=checkbox]').change(function() {
    if ($(this).is(':checked')) { 
        $('.ComparePricesItemStatusField', $(this).parent()).val(1);
    } else {
        $('.ComparePricesItemStatusField', $(this).parent()).val(0);
    }
});

$('.ComparePricesEnabled').change(function() {
    toggleComparePricesActive(true);
});

var toggleComparePricesActive = function(animated) {
    if ($('.ComparePricesEnabled').val() == 'yes') {
        if (animated) 
            $('.ComparePricesActiveTR').fadeIn();
        else 
            $('.ComparePricesActiveTR').show();
    } else {
        if (animated) 
            $('.ComparePricesActiveTR').fadeOut();
        else 
            $('.ComparePricesActiveTR').hide();
    }
}

toggleComparePricesActive(false);
</script>