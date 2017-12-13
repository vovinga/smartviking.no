<table class="form">
   <tr>
    <td>Width<span class="help">In Pixels</span></td>
    <td valign="top">
    	<input type="text" name="ComparePrices[Width]" value="<?php echo(!empty($data['ComparePrices']['Width'])) ? $data['ComparePrices']['Width'] : '760' ; ?>" />
   </td>
  </tr>
  <tr>
   <td>Hide Tabs</td>
    <td>
    	<select name="ComparePrices[HideTabs]">
			<option value="no" <?php echo($data['ComparePrices']['HideTabs'] == 'no') ? 'selected' : '' ; ?>>No</option>
            <option value="yes" <?php echo($data['ComparePrices']['HideTabs'] == 'yes') ? 'selected' : '' ; ?>>Yes</option>   
        </select>
   </td>
  </tr>
  <tr>
    <td>Show Compare Prices in product tab</td>
    <td>
    	<select name="ComparePrices[showInTab]">
			<option value="no" <?php echo($data['ComparePrices']['showInTab'] == 'no') ? 'selected' : '' ; ?>>No</option>
            <option value="yes" <?php echo($data['ComparePrices']['showInTab'] == 'yes') ? 'selected' : '' ; ?>>Yes</option>   
        </select>
   </td>
  </tr>
  <tr>
    <td>Custom text<span class="help">Accepts basic HTML tags</span></td>
    <td>
        <?php foreach ($languages as $lang) : ?>
        <img src="view/image/flags/<?php echo $lang['image']; ?>" title="<?php echo $lang['name']; ?>" />
        <textarea name="ComparePrices[CustomText_<?php echo $lang['code']; ?>]" style="width:600px; height:110px;"><?php echo (!empty($data['ComparePrices']['CustomText_'.$lang['code']])) ? trim($data['ComparePrices']['CustomText_'.$lang['code']]) : '<strong>Want to be sure you’re paying the lowest price?<br />We guarantee it.</strong><br /><br />
We are making everything possible to provide you the best products on the lowest prices possible. Due to the higher number of products in our store we think that is possible some of the prices on our products to not be accurate. <br /><br />
If you find one of our products with lower price than ours, please use this form. We will compare the prices and will offer you the product on the same price!' ; ?></textarea><br />
         <?php endforeach; ?>
   </td>
  </tr>
  <tr>
    <td>Second custom text<span class="help">Accepts basic HTML tags</span></td>
    <td>
    	<?php foreach ($languages as $lang) : ?>
        <img src="view/image/flags/<?php echo $lang['image']; ?>" title="<?php echo $lang['name']; ?>" />
        <textarea name="ComparePrices[SecondCustomText_<?php echo $lang['code']; ?>]" style="width:600px; height:80px;"><?php echo (!empty($data['ComparePrices']['SecondCustomText_'.$lang['code']])) ? trim($data['ComparePrices']['SecondCustomText_'.$lang['code']]) : '<strong>Here’s how it works: </strong><br /><br />1. Found a cheaper price?<br />2. Ask us for a price match - Just fill out the form and we’ll check the details.<br />3. If you are correct, we will offer you the product for the same price and you can enjoy your stay knowing you got the lowest price.' ; ?></textarea><br />
         <?php endforeach; ?>               
   </td>
  </tr>
</table>