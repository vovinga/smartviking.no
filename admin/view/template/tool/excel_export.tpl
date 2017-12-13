<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($warning) { ?>
  <div class="warning"><?php echo $warning; ?></div>
  <?php } ?>
  <?php if ($success_alert) { ?>
  <div class="success"><?php echo $success_alert; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/icon_excel.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#excel_export').submit();" class="button"><span><?php echo $text_download_excel; ?></span></a>
      </div>
    </div>
    <div class="content">
      <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="excel_export">
      
      
      
    <div style="float: left; margin-right: 50px;">
      <h3><?php echo $text_export; ?>:</h3>
        <table cellpadding="0" cellspacing="0" style="float: left; margin-right: 30px;">
          <tr>
            <td><input type="checkbox" name="download[product_id]" id="download_product_id" value="1" /></td>
            <td><label for="download_product_id"><?php echo $text_product_id; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[model]" id="download_model" value="1" /></td>
            <td><label for="download_model"><?php echo $text_model; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[category]" id="download_category" value="1" /></td>
            <td><label for="download_category"><?php echo $text_category; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[name]" id="download_name" value="1" /></td>
            <td><label for="download_name"><?php echo $text_name; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[description]" id="download_description" value="1" /></td>
            <td><label for="download_description"><?php echo $text_description; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[manufacturer]" id="download_manufacturer" value="1" /></td>
            <td><label for="download_manufacturer"><?php echo $text_manufacturer; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[price]" id="download_price" value="1" /></td>
            <td><label for="download_price"><?php echo $text_price; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[tax_class]" id="download_tax_class" value="1" /></td>
            <td><label for="download_tax_class"><?php echo $text_tax_class; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[status]" id="download_status" value="1" /></td>
            <td><label for="download_status"><?php echo $text_status; ?></label></td>
          </tr>
        </table>
        
        <table cellpadding="0" cellspacing="0" style="float: left; margin-right: 30px;">
          <tr>
            <td><input type="checkbox" name="download[points]" id="download_points" value="1" /></td>
            <td><label for="download_points"><?php echo $text_points; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[quantity]" id="download_quantity" value="1" /></td>
            <td><label for="download_quantity"><?php echo $text_quantity; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[minimum]" id="download_minimum" value="1" /></td>
            <td><label for="download_minimum"><?php echo $text_minimum; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[stock_status]" id="download_stock_status" value="1" /></td>
            <td><label for="download_stock_status"><?php echo $text_stock_status; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[weight]" id="download_weight" value="1" /></td>
            <td><label for="download_weight"><?php echo $text_weight; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[weight_class]" id="download_weight_class" value="1" /></td>
            <td><label for="download_weight_class"><?php echo $text_weight_class; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[length]" id="download_length" value="1" /></td>
            <td><label for="download_length"><?php echo $text_length; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[length_class]" id="download_length_class" value="1" /></td>
            <td><label for="download_length_class"><?php echo $text_length_class; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[sort_order]" id="download_sort" value="1" /></td>
            <td><label for="download_sort"><?php echo $text_sort_order; ?></label></td>
          </tr>
        </table>
        
        <table cellpadding="0" cellspacing="0" style="float: left; margin-right: 30px;">
          <tr>
            <td><input type="checkbox" name="download[width]" id="download_width" value="1" /></td>
            <td><label for="download_width"><?php echo $text_width; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[height]" id="download_height" value="1" /></td>
            <td><label for="download_height"><?php echo $text_height; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[sku]" id="download_sku" value="1" /></td>
            <td><label for="download_sku"><?php echo $text_sku; ?></label></td>
          </tr>
		  <tr>
            <td><input type="checkbox" name="download[cost]" id="download_cost" value="1" /></td>
            <td><label for="download_cost"><?php echo $text_cost; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[upc]" id="download_upc" value="1" /></td>
            <td><label for="download_upc"><?php echo $text_upc; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[ean]" id="download_ean" value="1" /></td>
            <td><label for="download_ean"><?php echo $text_ean; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[jan]" id="download_jan" value="1" /></td>
            <td><label for="download_jan"><?php echo $text_jan; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[isbn]" id="download_isbn" value="1" /></td>
            <td><label for="download_isbn"><?php echo $text_isbn; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[mpn]" id="download_mpn" value="1" /></td>
            <td><label for="download_mpn"><?php echo $text_mpn; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[location]" id="download_location" value="1" /></td>
            <td><label for="download_location"><?php echo $text_location; ?></label></td>
          </tr>
        </table>
        
        <table cellpadding="0" cellspacing="0" style="float: left; margin-right: 30px;">
          <tr>
            <td><input type="checkbox" name="download[images]" id="download_images" value="1" /></td>
            <td><label for="download_images"><?php echo $text_images; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[product_attribute]" id="download_product_attribute" value="1" /></td>
            <td><label for="download_product_attribute"><?php echo $text_product_attribute; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[product_option]" id="download_product_option" value="1" /></td>
            <td><label for="download_product_option"><?php echo $text_product_option; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[meta_description]" id="download_meta_description" value="1" /></td>
            <td><label for="download_meta_description"><?php echo $text_meta_description; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[meta_keyword]" id="download_meta_keyword" value="1" /></td>
            <td><label for="download_meta_keyword"><?php echo $text_meta_keyword; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[viewed]" id="download_viewed" value="1" /></td>
            <td><label for="download_viewed"><?php echo $text_viewed; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[date_available]" id="download_date_available" value="1" /></td>
            <td><label for="download_date_available"><?php echo $text_date_available; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[date_added]" id="download_date_added" value="1" /></td>
            <td><label for="download_date_added"><?php echo $text_date_added; ?></label></td>
          </tr>
          <tr>
            <td><input type="checkbox" name="download[date_modified]" id="download_date_modified" value="1" /></td>
            <td><label for="download_date_modified"><?php echo $text_date_modified; ?></label></td>
          </tr>
        </table>
      </div>
      
      
      
      
    <div style="float: left; border-left: 1px solid gray; padding-left: 50px;">
      <h3><?php echo $text_checked; ?>:</h3>
      <table cellpadding="0" cellspacing="0">
        <tr>
          <td><input type="radio" name="checked" value="check_main_data" id="check_main_data" onClick="check(this.value);" /></td>
          <td><label for="check_main_data"><?php echo $text_check_main_data; ?></label></td>
        </tr>
        <tr>
          <td><input type="radio" name="checked" value="check_all_important_data" id="check_all_important_data" onClick="check(this.value);" /></td>
          <td><label for="check_all_important_data"><?php echo $text_check_all_important_data; ?></label></td>
        </tr>
        <tr>
          <td><input type="radio" name="checked" value="check_all" id="check_all" onClick="check(this.value);" /></td>
          <td><label for="check_all"><?php echo $text_check_all; ?></label></td>
        </tr>
        <tr>
          <td><input type="radio" name="checked" value="check_none" id="check_none" onClick="check(this.value);" /></td>
          <td><label for="check_none"><?php echo $text_check_none; ?></label></td>
        </tr>
      </table>
      
      
      <h3><?php echo $text_select_language; ?>:</h3>
      <select name="language_id">
        <?php foreach($languages as $language){?>
          <option value="<?php echo $language['language_id'];?>"><?php echo $language['name'];?></option>
        <?php }?>
      </select>
      
      <script type="text/javascript">
        function check(check_type){
        
          if(check_type == 'check_main_data'){
            uncheckAll();
            document.getElementById('download_product_id').checked              = true;
            document.getElementById('download_model').checked                   = true;
            document.getElementById('download_category').checked                = true;
            document.getElementById('download_name').checked                    = true;
            document.getElementById('download_description').checked             = true;
            document.getElementById('download_manufacturer').checked            = true;
            document.getElementById('download_price').checked                   = true;
            document.getElementById('download_points').checked                  = true;
            document.getElementById('download_quantity').checked                = true;
            document.getElementById('download_minimum').checked                 = true;
            document.getElementById('download_stock_status').checked            = true;
            document.getElementById('download_meta_description').checked        = true;
            document.getElementById('download_meta_keyword').checked            = true;
            document.getElementById('download_status').checked                  = true;
            document.getElementById('download_tax_class').checked               = false;
          }
        
          if(check_type == 'check_all_important_data'){
            uncheckAll();
            document.getElementById('download_product_id').checked              = true;
            document.getElementById('download_model').checked                   = true;
            document.getElementById('download_category').checked                = true;
            document.getElementById('download_name').checked                    = true;
            document.getElementById('download_description').checked             = true;
            document.getElementById('download_manufacturer').checked            = true;
            document.getElementById('download_price').checked                   = true;
            document.getElementById('download_points').checked                  = true;
            document.getElementById('download_quantity').checked                = true;
            document.getElementById('download_minimum').checked                 = true;
            document.getElementById('download_stock_status').checked            = true;
            document.getElementById('download_meta_description').checked        = true;
            document.getElementById('download_meta_keyword').checked            = true;
            document.getElementById('download_status').checked                  = true;
            document.getElementById('download_date_available').checked          = true;
            document.getElementById('download_images').checked                  = true;
            document.getElementById('download_product_attribute').checked       = true;
            document.getElementById('download_product_option').checked          = true;
            document.getElementById('download_tax_class').checked               = true;
            document.getElementById('download_weight').checked                  = true;
            document.getElementById('download_weight_class').checked            = true;
            document.getElementById('download_length').checked                  = true;
            document.getElementById('download_length_class').checked            = true;
            document.getElementById('download_width').checked                   = true;
            document.getElementById('download_height').checked                  = true;
          }
          if(check_type == 'check_all'){checkAll();}
          if(check_type == 'check_none'){uncheckAll();}
        }

        function uncheckAll(){
            document.getElementById('download_product_id').checked              = false;
            document.getElementById('download_model').checked                   = false;
            document.getElementById('download_category').checked                = false;
            document.getElementById('download_name').checked                    = false;
            document.getElementById('download_description').checked             = false;
            document.getElementById('download_manufacturer').checked            = false;
            document.getElementById('download_price').checked                   = false;
            document.getElementById('download_tax_class').checked               = false;
            document.getElementById('download_points').checked                  = false;
            document.getElementById('download_quantity').checked                = false;
            document.getElementById('download_minimum').checked                 = false;
            document.getElementById('download_stock_status').checked            = false;
            document.getElementById('download_weight').checked                  = false;
            document.getElementById('download_weight_class').checked            = false;
            document.getElementById('download_length').checked                  = false;
            document.getElementById('download_length_class').checked            = false;
            document.getElementById('download_width').checked                   = false;
            document.getElementById('download_height').checked                  = false;
            document.getElementById('download_sku').checked                     = false;
			document.getElementById('download_cost').checked                     = false;
            document.getElementById('download_upc').checked                     = false;
            document.getElementById('download_location').checked                = false;
            document.getElementById('download_images').checked                  = false;
            document.getElementById('download_product_attribute').checked       = false;
            document.getElementById('download_product_option').checked          = false;
            document.getElementById('download_meta_description').checked        = false;
            document.getElementById('download_meta_keyword').checked            = false;
            document.getElementById('download_viewed').checked                  = false;
            document.getElementById('download_date_available').checked          = false;
            document.getElementById('download_date_added').checked              = false;
            document.getElementById('download_date_modified').checked           = false;
            document.getElementById('download_status').checked                  = false;
            document.getElementById('download_sort').checked                    = false;
            document.getElementById('download_ean').checked                     = false;
            document.getElementById('download_jan').checked                     = false;
            document.getElementById('download_isbn').checked                    = false;
            document.getElementById('download_mpn').checked                     = false;
        }

        function checkAll(){
            document.getElementById('download_product_id').checked              = true;
            document.getElementById('download_model').checked                   = true;
            document.getElementById('download_category').checked                = true;
            document.getElementById('download_name').checked                    = true;
            document.getElementById('download_description').checked             = true;
            document.getElementById('download_manufacturer').checked            = true;
            document.getElementById('download_price').checked                   = true;
            document.getElementById('download_tax_class').checked               = true;
            document.getElementById('download_points').checked                  = true;
            document.getElementById('download_quantity').checked                = true;
            document.getElementById('download_minimum').checked                 = true;
            document.getElementById('download_stock_status').checked            = true;
            document.getElementById('download_weight').checked                  = true;
            document.getElementById('download_weight_class').checked            = true;
            document.getElementById('download_length').checked                  = true;
            document.getElementById('download_length_class').checked            = true;
            document.getElementById('download_width').checked                   = true;
            document.getElementById('download_height').checked                  = true;
            document.getElementById('download_sku').checked                     = true;
			document.getElementById('download_cost').checked                     = true;
            document.getElementById('download_upc').checked                     = true;
            document.getElementById('download_location').checked                = true;
            document.getElementById('download_images').checked                  = true;
            document.getElementById('download_product_attribute').checked       = true;
            document.getElementById('download_product_option').checked          = true;
            document.getElementById('download_meta_description').checked        = true;
            document.getElementById('download_meta_keyword').checked            = true;
            document.getElementById('download_viewed').checked                  = true;
            document.getElementById('download_date_available').checked          = true;
            document.getElementById('download_date_added').checked              = true;
            document.getElementById('download_date_modified').checked           = true;
            document.getElementById('download_status').checked                  = true;
            document.getElementById('download_sort').checked                    = true;
            document.getElementById('download_ean').checked                     = true;
            document.getElementById('download_jan').checked                     = true;
            document.getElementById('download_isbn').checked                    = true;
            document.getElementById('download_mpn').checked                     = true;
        }
        
        
      </script>
    </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>