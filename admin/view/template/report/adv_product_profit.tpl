<?php echo $header; ?>
<script type="text/javascript">
$(document).ready(function() { 
  $("#pagination_content").hide(); 
  $(window).load(function() { 
    $("#pagination_content").show(); 
    $("#content-loading").hide(); 
  });
});
</script>
<div id="content-loading" style="position: absolute; background-color:white; layer-background-color:white; height:100%; width:100%; text-align:center;"><img src="view/image/adv_reports/page_loading.gif" border="0"></div>
<style type="text/css">
.box > .content_report {
	padding: 10px;
	border-left: 1px solid #CCCCCC;
	border-right: 1px solid #CCCCCC;
	border-bottom: 1px solid #CCCCCC;
	min-height: 300px;
}
.list_main {
	border-collapse: collapse;
	width: 100%;
	border-top: 1px solid #DDDDDD;
	border-left: 1px solid #DDDDDD;	
	margin-bottom: 10px;
}
.list_main td {
	border-right: 1px solid #DDDDDD;
	border-bottom: 1px solid #DDDDDD;	
}
.list_main thead td {
	background-color: #E5E5E5;
	padding: 0px 5px;
	font-weight: bold;	
}
.list_main tbody td {
	vertical-align: middle;
	padding: 0px 5px;
}
.list_main .left {
	text-align: left;
	padding: 7px;
}
.list_main .right {
	text-align: right;
	padding: 7px;
}
.list_main .center {
	text-align: center;
	padding: 3px;
}
.list_main .noresult {
	text-align: center;
	padding: 7px;
}

.list_detail {
	border-collapse: collapse;
	width: 100%;
	border-top: 1px solid #DDDDDD;
	border-left: 1px solid #DDDDDD;
	margin-top: 10px;
	margin-bottom: 10px;
}
.list_detail td {
	border-right: 1px solid #DDDDDD;
	border-bottom: 1px solid #DDDDDD;
}
.list_detail thead td {
	background-color: #F0F0F0;
	padding: 0px 3px;
	font-size: 11px;
	font-weight: bold;
}
.list_detail tbody td {
	padding: 0px 3px;
	font-size: 11px;	
}
.list_detail .left {
	text-align: left;
	padding: 3px;
}
.list_detail .right {
	text-align: right;
	padding: 3px;
}
.list_detail .center {
	text-align: center;
	padding: 3px;
}

.export_item {
  text-decoration: none;
  cursor: pointer;
}
.export_item a {
  text-decoration: none;
}
.export_item :hover {
  opacity: 0.7;
  -moz-opacity: 0.7;
  -ms-filter: "alpha(opacity=70)"; /* IE 8 */
  filter: alpha(opacity=70); /* IE < 8 */
} 
.noexport_item {
  opacity: 0.5;
  -moz-opacity: 0.5;
  -ms-filter: "alpha(opacity=50)"; /* IE 8 */
  filter: alpha(opacity=50); /* IE < 8 */
} 
a.cbutton {
	text-decoration: none;
	color: #FFF;
	display: inline-block;
	padding: 5px 15px 5px 15px;
	-webkit-border-radius: 5px 5px 5px 5px;
	-moz-border-radius: 5px 5px 5px 5px;
	-khtml-border-radius: 5px 5px 5px 5px;
	border-radius: 5px 5px 5px 5px;
}

.pagination_report {
	padding:3px;
	margin:3px;
	text-align:right;
	margin-top:10px;
}
.pagination_report a {
	padding: 4px 8px 4px 8px;
	margin-right: 2px;
	border: 1px solid #ddd;
	text-decoration: none; 
	color: #666;
}
.pagination_report a:hover, .pagination_report a:active {
	padding: 4px 8px 4px 8px;
	margin-right: 2px;
	border: 1px solid #c0c0c0;
}
.pagination_report span.current {
	padding: 4px 8px 4px 8px;
	margin-right: 2px;
	border: 1px solid #a0a0a0;
	font-weight: bold;
	background-color: #f0f0f0;
	color: #666;
}
.pagination_report span.disabled {
	padding: 4px 8px 4px 8px;
	margin-right: 2px;
	border: 1px solid #f3f3f3;
	color: #ccc;
}

.ui-dialog .ui-dialog-content {
  background: #f3f3f3 !important;
} 

.styled-select-type {
	background-color: #ffcc99;
	padding: 3px;
 	border: 1px solid #999;
    -moz-border-radius: 3px; 
    border-radius: 3px;
}
.styled-select {
	background-color: #E7EFEF;
	padding: 3px;
 	border: 1px solid #999;
    -moz-border-radius: 3px; 
    border-radius: 3px;
}
</style>
<link href="view/stylesheet/jquery.multiSelect.css" rel="stylesheet" type="text/css" />
<form method="post" action="index.php?route=report/adv_product_profit&token=<?php echo $token; ?>" id="report" name="report"> 
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><div style="float:left;"><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></div><div style="float:left;"><span class="vtip" title="<?php echo $text_profit_help; ?>"><img style="padding-left:3px;" src="view/image/adv_reports/profit_info.png" alt="" /></span></div></h1><span style="float:right; padding-top:5px; padding-right:5px; font-size:11px; color:#666; text-align:right;"><?php echo $heading_version; ?></span></div>
      <div align="right" style="height:38px; background-color:#F0F0F0; border: 1px solid #DDDDDD; margin-top:5px;">
      <div style="padding-top: 7px; margin-right: 5px;"><?php echo $entry_report; ?>
          <select name="filter_report" id="filter_report" onchange="$('#report').submit();" class="styled-select-type"> 
              <?php foreach ($report as $report) { ?>
              <?php if ($report['value'] == $filter_report) { ?>
              <option value="<?php echo $report['value']; ?>" title="<?php echo $report['text']; ?>" selected="selected"><?php echo $report['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $report['value']; ?>" title="<?php echo $report['text']; ?>"><?php echo $report['text']; ?></option>
              <?php } ?>
              <?php } ?>
          </select>&nbsp;&nbsp; 
      	  <label <?php echo ($filter_report == 'manufacturers' or $filter_report == 'categories') ? 'style="color:#999; cursor:default;"' : 'style="color:#000; cursor:auto;"' ?>><?php echo $entry_option_grouping; ?></label>
          <select name="filter_ogrouping" class="styled-select" <?php echo ($filter_report == 'manufacturers' or $filter_report == 'categories') ? 'disabled="disabled"' : '' ?>> 
          <?php if ($filter_report == 'products') { ?> 
            <?php if ($filter_ogrouping && $filter_ogrouping == '1') { ?>
            <option value="1" selected="selected"><?php echo $text_yes; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_yes; ?></option>
            <?php } ?>
            <?php if (!$filter_ogrouping) { ?>
            <option value="0" selected="selected"><?php echo $text_no; ?></option>
            <?php } else { ?>
            <option value="0"><?php echo $text_no; ?></option>
            <?php } ?>
          <?php } elseif ($filter_report != 'products') { ?> 
          <option value="1">----</option>
          <?php } ?>
          </select>&nbsp;&nbsp; 
		  <?php echo $entry_group; ?>
          <select name="filter_group" class="styled-select"> 
              <?php foreach ($groups as $group) { ?>
              <?php if ($group['value'] == $filter_group) { ?>
              <option value="<?php echo $group['value']; ?>" selected="selected"><?php echo $group['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $group['value']; ?>"><?php echo $group['text']; ?></option>
              <?php } ?>
              <?php } ?>
          </select>&nbsp;&nbsp;
          <?php echo $entry_sort_by; ?>
		  <select name="filter_sort" class="styled-select"> 
            <?php if ($filter_sort == 'date') { ?>
            <option value="date" selected="selected"><?php echo $column_date; ?></option>
            <?php } else { ?>
            <option value="date"><?php echo $column_date; ?></option>
            <?php } ?>                                   
            <?php if ($filter_report == 'products' && $filter_sort == 'sku') { ?>
            <option value="sku" selected="selected"><?php echo $column_sku; ?></option>         
            <?php } else { ?>
            <option value="sku" <?php echo ($filter_report == 'manufacturers' or $filter_report == 'categories') ? 'disabled="disabled" style="color:#999"' : '' ?>><?php echo $column_sku; ?></option>
            <?php } ?>
            <?php if ($filter_report == 'products' && $filter_sort == 'name') { ?>
            <option value="name" selected="selected"><?php echo $column_prod_name; ?></option>            
            <?php } else { ?>
            <option value="name" <?php echo ($filter_report == 'manufacturers' or $filter_report == 'categories') ? 'disabled="disabled" style="color:#999"' : '' ?>><?php echo $column_prod_name; ?></option>
            <?php } ?>
            <?php if ($filter_report == 'products' && $filter_sort == 'model') { ?>
            <option value="model" selected="selected"><?php echo $column_model; ?></option>            
            <?php } else { ?>
            <option value="model" <?php echo ($filter_report == 'manufacturers' or $filter_report == 'categories') ? 'disabled="disabled" style="color:#999"' : '' ?>><?php echo $column_model; ?></option>
            <?php } ?>                                
            <?php if ($filter_report == 'products' && $filter_sort == 'category' or $filter_report == 'categories' && $filter_sort == 'category') { ?>
            <option value="category" selected="selected"><?php echo $column_category; ?></option>            
            <?php } else { ?>
            <option value="category" <?php echo ($filter_report == 'manufacturers') ? 'disabled="disabled" style="color:#999"' : '' ?>><?php echo $column_category; ?></option>
            <?php } ?>                       
            <?php if ($filter_report == 'products' && $filter_sort == 'manufacturer' or $filter_report == 'manufacturers' && $filter_sort == 'manufacturer') { ?>
            <option value="manufacturer" selected="selected"><?php echo $column_manufacturer; ?></option>           
            <?php } else { ?>
            <option value="manufacturer" <?php echo ($filter_report == 'categories') ? 'disabled="disabled" style="color:#999"' : '' ?>><?php echo $column_manufacturer; ?></option>
            <?php } ?>
            <?php if ($filter_report == 'products' && $filter_sort == 'attribute') { ?>
            <option value="attribute" selected="selected"><?php echo $column_attribute; ?></option>           
            <?php } else { ?>
            <option value="attribute" <?php echo ($filter_report == 'manufacturers' or $filter_report == 'categories') ? 'disabled="disabled" style="color:#999"' : '' ?>><?php echo $column_attribute; ?></option>
            <?php } ?>             
            <?php if ($filter_report == 'products' && $filter_sort == 'status') { ?>
            <option value="status" selected="selected"><?php echo $column_status; ?></option>           
            <?php } else { ?>
            <option value="status" <?php echo ($filter_report == 'manufacturers' or $filter_report == 'categories') ? 'disabled="disabled" style="color:#999"' : '' ?>><?php echo $column_status; ?></option>
            <?php } ?>
            <?php if ($filter_report == 'products' && $filter_sort == 'stock_quantity') { ?>
            <option value="stock_quantity" selected="selected"><?php echo $column_stock_quantity; ?></option>           
            <?php } else { ?>
            <option value="stock_quantity" <?php echo ($filter_report == 'manufacturers' or $filter_report == 'categories') ? 'disabled="disabled" style="color:#999"' : '' ?>><?php echo $column_stock_quantity; ?></option>
            <?php } ?>
            <?php if (!$filter_sort or $filter_sort == 'sold_quantity' or ($filter_report == 'manufacturers' && $filter_sort == 'category') or ($filter_report == 'categories' && $filter_sort == 'manufacturer')) { ?>
            <option value="sold_quantity" selected="selected"><?php echo $column_sold_quantity; ?></option>
            <?php } else { ?>
            <option value="sold_quantity"><?php echo $column_sold_quantity; ?></option>
            <?php } ?>
            <?php if ($filter_sort == 'tax') { ?>
            <option value="tax" selected="selected"><?php echo $column_tax; ?></option>
            <?php } else { ?>
            <option value="tax"><?php echo $column_tax; ?></option>
            <?php } ?>
            <?php if ($filter_sort == 'prod_sales') { ?>
            <option value="prod_sales" selected="selected"><?php echo $column_total; ?></option>
            <?php } else { ?>
            <option value="prod_sales"><?php echo $column_total; ?></option>
            <?php } ?>          
            <?php if ($filter_sort == 'prod_costs') { ?>
            <option value="prod_costs" selected="selected"><?php echo $column_prod_costs; ?></option>
            <?php } else { ?>
            <option value="prod_costs"><?php echo $column_prod_costs; ?></option>
            <?php } ?>            
            <?php if ($filter_sort == 'prod_profit') { ?>
            <option value="prod_profit" selected="selected"><?php echo $column_prod_profit; ?></option>
            <?php } else { ?>
            <option value="prod_profit"><?php echo $column_prod_profit; ?></option>
            <?php } ?>
            <?php if ($filter_sort == 'profit_margin') { ?>
            <option value="profit_margin" selected="selected"><?php echo $column_profit_margin; ?></option>
            <?php } else { ?>
            <option value="profit_margin"><?php echo $column_profit_margin; ?></option>
            <?php } ?>            
          </select>&nbsp;&nbsp; 
          <?php echo $entry_show_details; ?>
		  <select name="filter_details" class="styled-select">                           
            <?php if (!$filter_details or $filter_details == '0' or ($filter_report == 'products' && $filter_details == '3') or ($filter_report == 'manufacturers' && ($filter_details == '1' or $filter_details == '2')) or ($filter_report == 'categories' && ($filter_details == '1' or $filter_details == '2'))) { ?>
            <option value="0" selected="selected"><?php echo $text_no_details; ?></option>
            <?php } else { ?>
            <option value="0"><?php echo $text_no_details; ?></option>
            <?php } ?>
            <?php if ($filter_report == 'products' && $filter_details == '1') { ?>
            <option value="1" selected="selected"><?php echo $text_order_list; ?></option>
            <?php } else { ?>
            <option value="1" <?php echo ($filter_report == 'manufacturers' or $filter_report == 'categories') ? 'disabled="disabled" style="color:#999"' : '' ?>><?php echo $text_order_list; ?></option>
            <?php } ?>
            <?php if ($filter_report == 'manufacturers' && $filter_details == '3' or $filter_report == 'categories' && $filter_details == '3') { ?>
            <option value="3" selected="selected"><?php echo $text_product_list; ?></option>
            <?php } else { ?>
            <option value="3" <?php echo ($filter_report == 'products') ? 'disabled="disabled" style="color:#999"' : '' ?>><?php echo $text_product_list; ?></option>
            <?php } ?>            
            <?php if ($filter_report == 'products' && $filter_details == '2') { ?>
            <option value="2" selected="selected"><?php echo $text_customer_list; ?></option>
            <?php } else { ?>
            <option value="2" <?php echo ($filter_report == 'manufacturers' or $filter_report == 'categories') ? 'disabled="disabled" style="color:#999"' : '' ?>><?php echo $text_customer_list; ?></option>
            <?php } ?>                        
          </select>&nbsp;&nbsp; 
          <?php echo $entry_limit; ?>
		  <select name="filter_limit" class="styled-select"> 
            <?php if ($filter_limit == '10') { ?>
            <option value="10" selected="selected">10</option>
            <?php } else { ?>
            <option value="10">10</option>
            <?php } ?>                                
            <?php if (!$filter_limit or $filter_limit == '25') { ?>
            <option value="25" selected="selected">25</option>
            <?php } else { ?>
            <option value="25">25</option>
            <?php } ?>
            <?php if ($filter_limit == '50') { ?>
            <option value="50" selected="selected">50</option>
            <?php } else { ?>
            <option value="50">50</option>
            <?php } ?>
            <?php if ($filter_limit == '100') { ?>
            <option value="100" selected="selected">100</option>
            <?php } else { ?>
            <option value="100">100</option>
            <?php } ?>                        
          </select>&nbsp; <a id="button" onclick="$('#report').submit();" class="cbutton" style="background:#069;"><span><?php echo $button_filter; ?></span></a>&nbsp;<?php if ($products) { ?><?php if (($filter_range != 'all_time' && ($filter_group == 'year' or $filter_group == 'quarter' or $filter_group == 'month')) or ($filter_range == 'all_time' && $filter_group == 'year')) { ?><a id="show_tab_chart" class="cbutton" style="background:#930;"><span><?php echo $button_chart; ?></span></a><?php } ?><?php } ?>&nbsp;<a id="show_tab_export" class="cbutton" style="background:#699;"><span><?php echo $button_export; ?></span></a>&nbsp;<a id="settings" class="cbutton" style="background:#666;"><span><?php echo $button_settings; ?></span></a></div>
    </div>
    <div class="content_report">
<script type="text/javascript"><!--
$(document).ready(function() {
var prev = {start: 0, stop: 0},
    cont = $('#pagination_content #element');
	
$(".pagination_report").paging(cont.length, {
	format: '[< ncnnn! >]',
	perpage: '<?php echo $filter_limit; ?>',	
	lapping: 0,
	page: null, // we await hashchange() event
			onSelect: function() {

				var data = this.slice;

				cont.slice(prev[0], prev[1]).css('display', 'none');
				cont.slice(data[0], data[1]).fadeIn(0);

				prev = data;

				return true; // locate!
			},
			onFormat: function (type) {

				switch (type) {

					case 'block':

						if (!this.active)
							return '<span class="disabled">' + this.value + '</span>';
						else if (this.value != this.page)
							return '<em><a href="index.php?route=report/adv_product_profit&token=<?php echo $token; ?>#' + this.value + '">' + this.value + '</a></em>';
						return '<span class="current">' + this.value + '</span>';

					case 'next':

						if (this.active) {
							return '<a href="index.php?route=report/adv_product_profit&token=<?php echo $token; ?>#' + this.value + '" class="next">Next &gt;</a>';
						}
						return '';						

					case 'prev':

						if (this.active) {
							return '<a href="index.php?route=report/adv_product_profit&token=<?php echo $token; ?>#' + this.value + '" class="prev">&lt; Previous</a>';
						}	
						return '';						

					case 'first':

						if (this.active) {
							return '<?php echo $text_pagin_page; ?> ' + this.page + ' <?php echo $text_pagin_of; ?> ' + this.pages + '&nbsp;&nbsp;<a href="index.php?route=report/adv_product_profit&token=<?php echo $token; ?>#' + this.value + '" class="first">|&lt;</a>';
						}	
						return '<?php echo $text_pagin_page; ?> ' + this.page + ' <?php echo $text_pagin_of; ?> ' + this.pages + '&nbsp;&nbsp';
							
					case 'last':

						if (this.active) {
							return '<a href="index.php?route=report/adv_product_profit&token=<?php echo $token; ?>#' + this.value + '" class="prev">&gt;|</a>&nbsp;&nbsp;(' + cont.length + ' <?php echo $text_pagin_results; ?>)';
						}
						return '&nbsp;&nbsp;(' + cont.length + ' <?php echo $text_pagin_results; ?>)';					

				}
				return ''; // return nothing for missing branches
			}
});
});		
//--></script>     
<script type="text/javascript"><!--
function getStorage(key_prefix) {
    // this function will return us an object with a "set" and "get" method
    if (window.localStorage) {
        // use localStorage:
        return {
            set: function(id, data) {
                localStorage.setItem(key_prefix+id, data);
            },
            get: function(id) {
                return localStorage.getItem(key_prefix+id);
            }
        };
    }
}

$(document).ready(function() {
    // a key must is used for the cookie/storage
    var storedData = getStorage('com_mysite_checkboxes_'); 
    
    $('div.check input:checkbox').bind('change',function(){
        $('#'+this.id+'_filter').toggle($(this).is(':checked'));
        $('#'+this.id+'_title').toggle($(this).is(':checked'));
			<?php if ($products) {
					foreach ($products as $key => $product) {
						echo "$('#'+this.id+'_" . $product['order_product_id'] . "_title').toggle($(this).is(':checked')); ";
						echo "$('#'+this.id+'_" . $product['order_product_id'] . "').toggle($(this).is(':checked')); ";						
					}			
			} 
			;?>		
        $('#'+this.id+'_total').toggle($(this).is(':checked'));			
        // save the data on change
        storedData.set(this.id, $(this).is(':checked')?'checked':'not');
    }).each(function() {
        // on load, set the value to what we read from storage:
        var val = storedData.get(this.id);
        if (val == 'checked') $(this).attr('checked', 'checked');
        if (val == 'not') $(this).removeAttr('checked');
        if (val) $(this).trigger('change');
    });
});
//--></script>
<div id="settings_window" style="display:none">
<div class="check">
<table align="center" cellspacing="0" cellpadding="0">   
    <tr><td>
    <table width="100%" cellspacing="0" cellpadding="0" border="0"> 
    <tr><td align="right"><a onclick="location = '<?php echo $settings; ?>'" class="cbutton" style="background:#666;"><span><?php echo $button_module_settings; ?></span></a></td></tr> 
    </table>
    </td></tr> 
    <tr><td>
      &nbsp;<span style="font-size:14px; font-weight:bold;"><?php echo $text_filtering_options; ?></span><br />        
      <table width="100%" cellspacing="0" cellpadding="3" style="background:#E7EFEF; border:1px solid #DDDDDD; margin-top:3px;">
        <tr>
          <td>           
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp1" checked="checked" type="checkbox"><label for="ppp1"><?php echo substr($entry_status,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp2" checked="checked" type="checkbox"><label for="ppp2"><?php echo substr($entry_store,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp3" checked="checked" type="checkbox"><label for="ppp3"><?php echo substr($entry_currency,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp4" checked="checked" type="checkbox"><label for="ppp4"><?php echo substr($entry_tax,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp5" checked="checked" type="checkbox"><label for="ppp5"><?php echo substr($entry_customer_group,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp7" checked="checked" type="checkbox"><label for="ppp7"><?php echo substr($entry_customer_name,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp8a" checked="checked" type="checkbox"><label for="ppp8a"><?php echo substr($entry_customer_email,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp8b" checked="checked" type="checkbox"><label for="ppp8b"><?php echo substr($entry_customer_telephone,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp17a" checked="checked" type="checkbox"><label for="ppp17a"><?php echo substr($entry_payment_company,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp17b" checked="checked" type="checkbox"><label for="ppp17b"><?php echo substr($entry_payment_address,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp17c" checked="checked" type="checkbox"><label for="ppp17c"><?php echo substr($entry_payment_city,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp17d" checked="checked" type="checkbox"><label for="ppp17d"><?php echo substr($entry_payment_zone,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp17e" checked="checked" type="checkbox"><label for="ppp17e"><?php echo substr($entry_payment_postcode,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp17f" checked="checked" type="checkbox"><label for="ppp17f"><?php echo substr($entry_payment_country,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp13" checked="checked" type="checkbox"><label for="ppp13"><?php echo substr($entry_payment_method,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp16a" checked="checked" type="checkbox"><label for="ppp16a"><?php echo substr($entry_shipping_company,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp16b" checked="checked" type="checkbox"><label for="ppp16b"><?php echo substr($entry_shipping_address,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp16c" checked="checked" type="checkbox"><label for="ppp16c"><?php echo substr($entry_shipping_city,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp16d" checked="checked" type="checkbox"><label for="ppp16d"><?php echo substr($entry_shipping_zone,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp16e" checked="checked" type="checkbox"><label for="ppp16e"><?php echo substr($entry_shipping_postcode,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp16f" checked="checked" type="checkbox"><label for="ppp16f"><?php echo substr($entry_shipping_country,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp14" checked="checked" type="checkbox"><label for="ppp14"><?php echo substr($entry_shipping_method,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp9d" checked="checked" type="checkbox"><label for="ppp9d"><?php echo substr($entry_category,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp9e" checked="checked" type="checkbox"><label for="ppp9e"><?php echo substr($entry_manufacturer,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp9a" checked="checked" type="checkbox"><label for="ppp9a"><?php echo substr($entry_sku,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp9b" checked="checked" type="checkbox"><label for="ppp9b"><?php echo substr($entry_product,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp9c" checked="checked" type="checkbox"><label for="ppp9c"><?php echo substr($entry_model,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp10" checked="checked" type="checkbox"><label for="ppp10"><?php echo substr($entry_option,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp18" checked="checked" type="checkbox"><label for="ppp18"><?php echo substr($entry_attributes,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp6" checked="checked" type="checkbox"><label for="ppp6"><?php echo substr($entry_prod_status,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp11" checked="checked" type="checkbox"><label for="ppp11"><?php echo substr($entry_location,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp12a" checked="checked" type="checkbox"><label for="ppp12a"><?php echo substr($entry_affiliate_name,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp12b" checked="checked" type="checkbox"><label for="ppp12b"><?php echo substr($entry_affiliate_email,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp15a" checked="checked" type="checkbox"><label for="ppp15a"><?php echo substr($entry_coupon_name,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp15b" checked="checked" type="checkbox"><label for="ppp15b"><?php echo substr($entry_coupon_code,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp19" checked="checked" type="checkbox"><label for="ppp19"><?php echo substr($entry_voucher_code,0,-1); ?></label></div>
          </td>                                                                                                                        
        </tr>
      </table><br />
      &nbsp;<span style="font-size:14px; font-weight:bold;"><?php echo $text_column_settings; ?></span><br />  
      <table width="100%" cellspacing="0" cellpadding="3" style="background:#E5E5E5; border:1px solid #DDDDDD; margin-top:3px;">
        <tr>
          <td>
            &nbsp;<span style="font-size:11px; font-weight:bold;"><?php echo $text_mv_columns; ?></span><br />           
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp20" name="ppp20" checked="checked" type="checkbox"><label for="ppp20"><?php echo $column_image; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp21" name="ppp21" checked="checked" type="checkbox"><label for="ppp21"><?php echo $column_sku; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp22" name="ppp22" checked="checked" type="checkbox"><label for="ppp22"><?php echo $column_name; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp23" name="ppp23" checked="checked" type="checkbox"><label for="ppp23"><?php echo $column_model; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp24" name="ppp24" checked="checked" type="checkbox"><label for="ppp24"><?php echo $column_category; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp25" name="ppp25" checked="checked" type="checkbox"><label for="ppp25"><?php echo $column_manufacturer; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp34" name="ppp34" checked="checked" type="checkbox"><label for="ppp34"><?php echo $column_attribute; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp26" name="ppp26" checked="checked" type="checkbox"><label for="ppp26"><?php echo $column_status; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp35" name="ppp35" checked="checked" type="checkbox"><label for="ppp35"><?php echo $column_stock_quantity; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp27" name="ppp27" checked="checked" type="checkbox"><label for="ppp27"><?php echo $column_sold_quantity; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp28" name="ppp28" checked="checked" type="checkbox"><label for="ppp28"><?php echo $column_sold_percent; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp30" name="ppp30" checked="checked" type="checkbox"><label for="ppp30"><?php echo $column_tax; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp29" name="ppp29" checked="checked" type="checkbox"><label for="ppp29"><?php echo $column_total; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp31" name="ppp31" checked="checked" type="checkbox"><label for="ppp31"><?php echo $column_prod_costs; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp32" name="ppp32" checked="checked" type="checkbox"><label for="ppp32"><?php echo $column_prod_profit; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp33" name="ppp33" checked="checked" type="checkbox"><label for="ppp33"><?php echo $column_prod_profit; ?> [%]</label></div>
          </td>                                                                                                                        
        </tr>
		<tr><td>
		<span style="font-size:11px; color:#3C0;">* <?php echo $text_export_note; ?></span>  
		</td></tr>          
      </table>
      <table width="100%" cellspacing="0" cellpadding="3" style="background:#F0F0F0; border:1px solid #DDDDDD; margin-top:3px;">
        <tr>
          <td>
            &nbsp;<span style="font-size:11px; font-weight:bold;"><?php echo $text_ol_columns; ?></span><br />      
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp40" name="ppp40" checked="checked" type="checkbox"><label for="ppp40"><?php echo $column_order_prod_order_id; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp41" name="ppp41" checked="checked" type="checkbox"><label for="ppp41"><?php echo $column_order_prod_date_added; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp42" name="ppp42" checked="checked" type="checkbox"><label for="ppp42"><?php echo $column_order_prod_inv_no; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp43" name="ppp43" checked="checked" type="checkbox"><label for="ppp43"><?php echo $column_order_prod_customer; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp44" name="ppp44" checked="checked" type="checkbox"><label for="ppp44"><?php echo $column_order_prod_email; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp45" name="ppp45" checked="checked" type="checkbox"><label for="ppp45"><?php echo $column_order_prod_customer_group; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp46" name="ppp46" checked="checked" type="checkbox"><label for="ppp46"><?php echo $column_order_prod_shipping_method; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp47" name="ppp47" checked="checked" type="checkbox"><label for="ppp47"><?php echo $column_order_prod_payment_method; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp48" name="ppp48" checked="checked" type="checkbox"><label for="ppp48"><?php echo $column_order_prod_status; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp49" name="ppp49" checked="checked" type="checkbox"><label for="ppp49"><?php echo $column_order_prod_store; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp50" name="ppp50" checked="checked" type="checkbox"><label for="ppp50"><?php echo $column_order_prod_currency; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp51" name="ppp51" checked="checked" type="checkbox"><label for="ppp51"><?php echo $column_order_prod_price; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp52" name="ppp52" checked="checked" type="checkbox"><label for="ppp52"><?php echo $column_order_prod_quantity; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp54" name="ppp54" checked="checked" type="checkbox"><label for="ppp54"><?php echo $column_order_prod_tax; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp53" name="ppp53" checked="checked" type="checkbox"><label for="ppp53"><?php echo $column_order_prod_total; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp55" name="ppp55" checked="checked" type="checkbox"><label for="ppp55"><?php echo $column_order_prod_costs; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp56" name="ppp56" checked="checked" type="checkbox"><label for="ppp56"><?php echo $column_order_prod_profit; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp57" name="ppp57" checked="checked" type="checkbox"><label for="ppp57"><?php echo $column_order_prod_profit; ?> [%]</label></div>
          </td>                                                                                                                        
        </tr>
		<tr><td>
		<span style="font-size:11px; color:#3C0;">* <?php echo $text_export_note; ?> - <strong><?php echo strip_tags($text_export_prod_order_list); ?></strong></span>  
		</td></tr>          
      </table>
      <table width="100%" cellspacing="0" cellpadding="3" style="background:#F0F0F0; border:1px solid #DDDDDD; margin-top:3px;">
        <tr>
          <td>
            &nbsp;<span style="font-size:11px; font-weight:bold;"><?php echo $text_pl_columns; ?></span><br />     
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp60" name="ppp60" checked="checked" type="checkbox"><label for="ppp60"><?php echo $column_prod_order_id; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp61" name="ppp61" checked="checked" type="checkbox"><label for="ppp61"><?php echo $column_prod_date_added; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp62" name="ppp62" checked="checked" type="checkbox"><label for="ppp62"><?php echo $column_prod_inv_no; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp63" name="ppp63" checked="checked" type="checkbox"><label for="ppp63"><?php echo $column_prod_id; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp64" name="ppp64" checked="checked" type="checkbox"><label for="ppp64"><?php echo $column_prod_sku; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp65" name="ppp65" checked="checked" type="checkbox"><label for="ppp65"><?php echo $column_prod_model; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp66" name="ppp66" checked="checked" type="checkbox"><label for="ppp66"><?php echo $column_prod_name; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp67" name="ppp67" checked="checked" type="checkbox"><label for="ppp67"><?php echo $column_prod_option; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp77" name="ppp77" checked="checked" type="checkbox"><label for="ppp77"><?php echo $column_prod_attributes; ?></label></div>                      
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp68" name="ppp68" checked="checked" type="checkbox"><label for="ppp68"><?php echo $column_prod_manu; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp79" name="ppp79" checked="checked" type="checkbox"><label for="ppp79"><?php echo $column_prod_category; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp69" name="ppp69" checked="checked" type="checkbox"><label for="ppp69"><?php echo $column_prod_currency; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp70" name="ppp70" checked="checked" type="checkbox"><label for="ppp70"><?php echo $column_prod_price; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp71" name="ppp71" checked="checked" type="checkbox"><label for="ppp71"><?php echo $column_prod_quantity; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp73" name="ppp73" checked="checked" type="checkbox"><label for="ppp73"><?php echo $column_prod_tax; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp72" name="ppp72" checked="checked" type="checkbox"><label for="ppp72"><?php echo $column_prod_total; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp74" name="ppp74" checked="checked" type="checkbox"><label for="ppp74"><?php echo $column_prod_costs; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp75" name="ppp75" checked="checked" type="checkbox"><label for="ppp75"><?php echo $column_prod_profit; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp76" name="ppp76" checked="checked" type="checkbox"><label for="ppp76"><?php echo $column_prod_profit; ?> [%]</label></div>
          </td>                                                                                                                        
        </tr>
		<tr><td>
		<span style="font-size:11px; color:#3C0;">* <?php echo $text_export_note; ?> - <strong><?php echo strip_tags($text_export_manu_product_list); ?> + <?php echo strip_tags($text_export_cat_product_list); ?></strong></span>  
		</td></tr>          
      </table>
      <table width="100%" cellspacing="0" cellpadding="3" style="background:#F0F0F0; border:1px solid #DDDDDD; margin-top:3px;">
        <tr>
          <td>
            &nbsp;<span style="font-size:11px; font-weight:bold;"><?php echo $text_cl_columns; ?></span><br />       
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp80" name="ppp80" checked="checked" type="checkbox"><label for="ppp80"><?php echo $column_customer_order_id; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp81" name="ppp81" checked="checked" type="checkbox"><label for="ppp81"><?php echo $column_customer_date_added; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp82" name="ppp82" checked="checked" type="checkbox"><label for="ppp82"><?php echo $column_customer_inv_no; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp83" name="ppp83" checked="checked" type="checkbox"><label for="ppp83"><?php echo $column_customer_cust_id; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp84" name="ppp84" checked="checked" type="checkbox"><label for="ppp84"><?php echo strip_tags($column_billing_name); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp85" name="ppp85" checked="checked" type="checkbox"><label for="ppp85"><?php echo strip_tags($column_billing_company); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp86" name="ppp86" checked="checked" type="checkbox"><label for="ppp86"><?php echo strip_tags($column_billing_address_1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp87" name="ppp87" checked="checked" type="checkbox"><label for="ppp87"><?php echo strip_tags($column_billing_address_2); ?></label></div>		
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp88" name="ppp88" checked="checked" type="checkbox"><label for="ppp88"><?php echo strip_tags($column_billing_city); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp89" name="ppp89" checked="checked" type="checkbox"><label for="ppp89"><?php echo strip_tags($column_billing_zone); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp90" name="ppp90" checked="checked" type="checkbox"><label for="ppp90"><?php echo strip_tags($column_billing_postcode); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp91" name="ppp91" checked="checked" type="checkbox"><label for="ppp91"><?php echo strip_tags($column_billing_country); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp92" name="ppp92" checked="checked" type="checkbox"><label for="ppp92"><?php echo $column_customer_telephone; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp93" name="ppp93" checked="checked" type="checkbox"><label for="ppp93"><?php echo strip_tags($column_shipping_name); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp94" name="ppp94" checked="checked" type="checkbox"><label for="ppp94"><?php echo strip_tags($column_shipping_company); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp95" name="ppp95" checked="checked" type="checkbox"><label for="ppp95"><?php echo strip_tags($column_shipping_address_1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp96" name="ppp96" checked="checked" type="checkbox"><label for="ppp96"><?php echo strip_tags($column_shipping_address_2); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp97" name="ppp97" checked="checked" type="checkbox"><label for="ppp97"><?php echo strip_tags($column_shipping_city); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp98" name="ppp98" checked="checked" type="checkbox"><label for="ppp98"><?php echo strip_tags($column_shipping_zone); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp99" name="ppp99" checked="checked" type="checkbox"><label for="ppp99"><?php echo strip_tags($column_shipping_postcode); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="ppp100" name="ppp100" checked="checked" type="checkbox"><label for="ppp100"><?php echo strip_tags($column_shipping_country); ?></label></div>
          </td>                                                                                                                        
        </tr>
		<tr><td>
		<span style="font-size:11px; color:#3C0;">* <?php echo $text_export_note; ?> - <strong><?php echo strip_tags($text_export_prod_customer_list); ?></strong></span>  
		</td></tr>         
      </table>     
	</td></tr>              
</table>     
</div>
</div> 
<script type="text/javascript">
$("#settings").click(function() {					  
    var dlg = $("#settings_window").dialog({
            title: '<?php echo $button_settings; ?>',
            width: 900,
            height: 600,
            modal: true,			
    });
	dlg.parent().appendTo($("#report"));
});
</script> 
<script type="text/javascript">
$(document).ready(function() {
var $filter_range = $('#filter_range'), $date_start = $('#date-start'), $date_end = $('#date-end');
$filter_range.change(function () {
    if ($filter_range.val() == 'custom') {
        $date_start.removeAttr('disabled');
        $date_end.removeAttr('disabled');
    } else {	
        $date_start.attr('disabled', 'disabled').val('');
        $date_end.attr('disabled', 'disabled').val('');
    }
}).trigger('change');
});
</script>    
<div style="background: #E7EFEF; border: 1px solid #C6D7D7; margin-bottom: 15px;">
	<table width="100%" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	 <table cellspacing="0" cellpadding="0" height="100%">
  	 <tr>
     <td valign="top" nowrap="nowrap">
	 <table width="225" border="0" cellspacing="0" cellpadding="0" height="49%" style="background:#C6D7D7; border:1px solid #CCCCCC; padding:5px; margin-bottom:5px;">
	 <tr><td align="center" height="10%"><span style="font-weight:bold;"><?php echo $entry_order_created; ?></span></td></tr>
  	 <tr><td height="39%">         
      <table cellpadding="0" cellspacing="0" style="float:left; padding-top:3px;">
        <tr><td>&nbsp;<span style="font-size:11px;"><?php echo $entry_date_start; ?></span><br />
          <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" style="height:16px; border:solid 1px #BBB; margin-top:5px;" />
          </td><td width="10"></td></tr></table>
      <table cellpadding="0" cellspacing="0" style="float:left; padding-top:3px;">
        <tr><td>&nbsp;<span style="font-size:11px;"><?php echo $entry_date_end; ?></span><br />
          <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" style="height:16px; border:solid 1px #BBB; margin-top:5px;" />
          </td><td></td></tr></table>
      <table cellpadding="0" cellspacing="0" style="padding-top:5px; padding-bottom:3px;">
        <tr><td><?php echo $entry_range; ?><br />
            <select name="filter_range" id="filter_range" style="border:1px solid #999; margin-top:5px;">
              <?php foreach ($ranges as $range) { ?>
              <?php if ($range['value'] == $filter_range) { ?>
              <option value="<?php echo $range['value']; ?>" title="<?php echo $range['text']; ?>" style="<?php echo $range['style']; ?>" selected="selected"><?php echo $range['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $range['value']; ?>" title="<?php echo $range['text']; ?>" style="<?php echo $range['style']; ?>"><?php echo $range['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td></tr></table> 
      </td></tr></table>  
	 <table width="225" border="0" cellspacing="0" cellpadding="0" height="49%" style="background:#C6D7D7; border:1px solid #CCCCCC; padding:5px; margin-top:5px;" id="ppp1_filter">
	 <tr><td align="center" height="10%"><span style="font-weight:bold;"><?php echo $entry_status_changed; ?></span></td></tr>
  	 <tr><td height="39%">  
      <table cellpadding="0" cellspacing="0" style="float:left; padding-top:3px;">
        <tr><td>&nbsp;<span style="font-size:11px;"><?php echo $entry_date_start; ?></span><br />
          <input type="text" name="filter_status_date_start" value="<?php echo $filter_status_date_start; ?>" id="status-date-start" size="12" style="height:16px; border:solid 1px #BBB; margin-top:5px;" />
          </td><td width="10"></td></tr></table>
      <table cellpadding="0" cellspacing="0" style="float:left; padding-top:3px;">
        <tr><td>&nbsp;<span style="font-size:11px;"><?php echo $entry_date_end; ?></span><br />
          <input type="text" name="filter_status_date_end" value="<?php echo $filter_status_date_end; ?>" id="status-date-end" size="12" style="height:16px; border:solid 1px #BBB; margin-top:5px;" />
          </td><td></td></tr></table>
      <table cellpadding="0" cellspacing="0" style="padding-top:5px; padding-bottom:5px;">
        <tr><td><?php echo $entry_status; ?><br />
          <span <?php echo (!$filter_order_status_id) ? '' : 'class="vtip"' ?> title="<?php foreach ($order_statuses as $order_status) { ?><?php if (isset($filter_order_status_id[$order_status['order_status_id']])) { ?><?php echo $order_status['name']; ?><br /><?php } ?><?php } ?>">
          <select name="filter_order_status_id" id="filter_order_status_id" multiple="multiple" size="1">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if (isset($filter_order_status_id[$order_status['order_status_id']])) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></span></td></tr></table>
      </td></tr></table>           
      </td>
    <td valign="top" style="padding: 5px;">  
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp2_filter">
        <tr><td><?php echo $entry_store; ?><br />
          <span <?php echo (!$filter_store_id) ? '' : 'class="vtip"' ?> title="<?php foreach ($stores as $store) { ?><?php if (isset($filter_store_id[$store['store_id']])) { ?><?php echo $store['store_name']; ?><br /><?php } ?><?php } ?>">
          <select name="filter_store_id" id="filter_store_id" multiple="multiple" size="1">
            <?php foreach ($stores as $store) { ?>
            <?php if (isset($filter_store_id[$store['store_id']])) { ?>            
            <option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['store_name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $store['store_id']; ?>"><?php echo $store['store_name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>    
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp3_filter">
        <tr><td><?php echo $entry_currency; ?><br />
          <span <?php echo (!$filter_currency) ? '' : 'class="vtip"' ?> title="<?php foreach ($currencies as $currency) { ?><?php if (isset($filter_currency[$currency['currency_id']])) { ?><?php echo $currency['title']; ?> (<?php echo $currency['code']; ?>)<br /><?php } ?><?php } ?>">
          <select name="filter_currency" id="filter_currency" multiple="multiple" size="1">
            <?php foreach ($currencies as $currency) { ?>
            <?php if (isset($filter_currency[$currency['currency_id']])) { ?>
            <option value="<?php echo $currency['currency_id']; ?>" selected="selected"><?php echo $currency['title']; ?> (<?php echo $currency['code']; ?>)</option>
            <?php } else { ?>
            <option value="<?php echo $currency['currency_id']; ?>"><?php echo $currency['title']; ?> (<?php echo $currency['code']; ?>)</option>
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>          
	  </tr></table>
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp4_filter">
        <tr><td><?php echo $entry_tax; ?><br />
          <span <?php echo (!$filter_taxes) ? '' : 'class="vtip"' ?> title="<?php foreach ($taxes as $tax) { ?><?php if (isset($filter_taxes[$tax['tax']])) { ?><?php echo $tax['tax_title']; ?><br /><?php } ?><?php } ?>">
		  <select name="filter_taxes" id="filter_taxes" multiple="multiple" size="1">
            <?php foreach ($taxes as $tax) { ?>
            <?php if (isset($filter_taxes[$tax['tax']])) { ?>              
            <option value="<?php echo $tax['tax']; ?>" selected="selected"><?php echo $tax['tax_title']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $tax['tax']; ?>"><?php echo $tax['tax_title']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp5_filter">
        <tr><td><?php echo $entry_customer_group; ?><br />
          <span <?php echo (!$filter_customer_group_id) ? '' : 'class="vtip"' ?> title="<?php foreach ($customer_groups as $customer_group) { ?><?php if (isset($filter_customer_group_id[$customer_group['customer_group_id']])) { ?><?php echo $customer_group['name']; ?><br /><?php } ?><?php } ?>">
          <select name="filter_customer_group_id" id="filter_customer_group_id" multiple="multiple" size="1">
            <?php foreach ($customer_groups as $customer_group) { ?>
            <?php if (isset($filter_customer_group_id[$customer_group['customer_group_id']])) { ?>              
            <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
            <?php } else { ?>

            <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>     
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp7_filter">
        <tr><td> <?php echo $entry_customer_name; ?><br />
        <input type="text" name="filter_customer_name" value="<?php echo $filter_customer_name; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
		</td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>  
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp8a_filter">
        <tr><td> <?php echo $entry_customer_email; ?><br />
        <input type="text" name="filter_customer_email" value="<?php echo $filter_customer_email; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>  
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp8b_filter">
        <tr><td> <?php echo $entry_customer_telephone; ?><br />
        <input type="text" name="filter_customer_telephone" value="<?php echo $filter_customer_telephone; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>     
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp17a_filter">
        <tr><td> <?php echo $entry_payment_company; ?><br />
        <input type="text" name="filter_payment_company" value="<?php echo $filter_payment_company; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp17b_filter">
        <tr><td> <?php echo $entry_payment_address; ?><br />
        <input type="text" name="filter_payment_address" value="<?php echo $filter_payment_address; ?>" size="25" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp17c_filter">
        <tr><td> <?php echo $entry_payment_city; ?><br />
        <input type="text" name="filter_payment_city" value="<?php echo $filter_payment_city; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
		</td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp17d_filter">
        <tr><td> <?php echo $entry_payment_zone; ?><br />
        <input type="text" name="filter_payment_zone" value="<?php echo $filter_payment_zone; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
		</td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>  
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp17e_filter">
        <tr><td> <?php echo $entry_payment_postcode; ?><br />
        <input type="text" name="filter_payment_postcode" value="<?php echo $filter_payment_postcode; ?>" size="15" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp17f_filter">
        <tr><td> <?php echo $entry_payment_country; ?><br />
        <input type="text" name="filter_payment_country" value="<?php echo $filter_payment_country; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp13_filter">
        <tr><td><?php echo $entry_payment_method; ?><br />
          <span <?php echo (!$filter_payment_method) ? '' : 'class="vtip"' ?> title="<?php foreach ($payment_methods as $payment_method) { ?><?php if (isset($filter_payment_method[$payment_method['payment_title']])) { ?><?php echo $payment_method['payment_name']; ?><br /><?php } ?><?php } ?>">
		  <select name="filter_payment_method" id="filter_payment_method" multiple="multiple" size="1">
            <?php foreach ($payment_methods as $payment_method) { ?>
            <?php if (isset($filter_payment_method[$payment_method['payment_title']])) { ?>              
            <option value="<?php echo $payment_method['payment_title']; ?>" selected="selected"><?php echo $payment_method['payment_name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $payment_method['payment_title']; ?>"><?php echo $payment_method['payment_name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>   
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp16a_filter">
        <tr><td> <?php echo $entry_shipping_company; ?><br />
        <input type="text" name="filter_shipping_company" value="<?php echo $filter_shipping_company; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp16b_filter">
        <tr><td> <?php echo $entry_shipping_address; ?><br />
        <input type="text" name="filter_shipping_address" value="<?php echo $filter_shipping_address; ?>" size="25" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp16c_filter">
        <tr><td> <?php echo $entry_shipping_city; ?><br />
        <input type="text" name="filter_shipping_city" value="<?php echo $filter_shipping_city; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp16d_filter">
        <tr><td> <?php echo $entry_shipping_zone; ?><br />
        <input type="text" name="filter_shipping_zone" value="<?php echo $filter_shipping_zone; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>                     
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp16e_filter">
        <tr><td> <?php echo $entry_shipping_postcode; ?><br />
        <input type="text" name="filter_shipping_postcode" value="<?php echo $filter_shipping_postcode; ?>" size="15" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp16f_filter">
        <tr><td> <?php echo $entry_shipping_country; ?><br />
        <input type="text" name="filter_shipping_country" value="<?php echo $filter_shipping_country; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>           
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp14_filter">
        <tr><td><?php echo $entry_shipping_method; ?><br />
          <span <?php echo (!$filter_shipping_method) ? '' : 'class="vtip"' ?> title="<?php foreach ($shipping_methods as $shipping_method) { ?><?php if (isset($filter_shipping_method[$shipping_method['shipping_title']])) { ?><?php echo $shipping_method['shipping_name']; ?><br /><?php } ?><?php } ?>">
		  <select name="filter_shipping_method" id="filter_shipping_method" multiple="multiple" size="1">
            <?php foreach ($shipping_methods as $shipping_method) { ?>
            <?php if (isset($filter_shipping_method[$shipping_method['shipping_title']])) { ?>              
            <option value="<?php echo $shipping_method['shipping_title']; ?>" selected="selected"><?php echo $shipping_method['shipping_name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $shipping_method['shipping_title']; ?>"><?php echo $shipping_method['shipping_name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp9d_filter">
        <tr><td><?php echo $entry_category; ?><br />
          <span <?php echo (!$filter_category) ? '' : 'class="vtip"' ?> title="<?php foreach ($categories as $category) { ?><?php if (isset($filter_category[$category['category_id']])) { ?><?php echo $category['name']; ?><br /><?php } ?><?php } ?>">
          <select name="filter_category" id="filter_category" multiple="multiple" size="1">
            <?php foreach ($categories as $category) { ?>
            <?php if (isset($filter_category[$category['category_id']])) { ?>               
            <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option> 
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>                               
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp9e_filter">
        <tr><td><?php echo $entry_manufacturer; ?><br />
          <span <?php echo (!$filter_manufacturer) ? '' : 'class="vtip"' ?> title="<?php foreach ($manufacturers as $manufacturer) { ?><?php if (isset($filter_manufacturer[$manufacturer['manufacturer_id']])) { ?> <?php echo $manufacturer['name']; ?><br /><?php } ?><?php } ?>">
          <select name="filter_manufacturer" id="filter_manufacturer" multiple="multiple" size="1">
            <?php foreach ($manufacturers as $manufacturer) { ?>
            <?php if (isset($filter_manufacturer[$manufacturer['manufacturer_id']])) { ?>               
            <option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option> 
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>            
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp9a_filter">
        <tr><td> <?php echo $entry_sku; ?><br />
        <input type="text" name="filter_sku" value="<?php echo $filter_sku; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp9b_filter">
        <tr><td> <?php echo $entry_product; ?><br />
        <input type="text" name="filter_product_id" value="<?php echo $filter_product_id; ?>" size="40" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp9c_filter">
        <tr><td> <?php echo $entry_model; ?><br />
        <input type="text" name="filter_model" value="<?php echo $filter_model; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>  
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp10_filter">
        <tr><td><label <?php echo ($filter_ogrouping or $filter_report != 'products') ? 'style="color:#000; cursor:auto;"' : 'style="color:#999; cursor:default;"' ?>><?php echo $entry_option; ?></label><br />
          <span <?php echo (($filter_option && $filter_ogrouping && $filter_report == 'products') or ($filter_option && $filter_report != 'products')) ? 'class="vtip"' : '' ?> title="<?php foreach ($product_options as $product_option) { ?><?php if ((isset($filter_option[$product_option['options']]) && $filter_ogrouping && $filter_report == 'products') or (isset($filter_option[$product_option['options']]) && $filter_report != 'products')) { ?><?php echo $product_option['option_name']; ?>: <?php echo $product_option['option_value']; ?><br /><?php } ?><?php } ?>">        
          <select name="filter_option" id="filter_option" multiple="multiple" size="1">
          <?php if ($filter_ogrouping && $filter_report == 'products') { ?>          
            <?php foreach ($product_options as $product_option) { ?>
            <?php if (isset($filter_option[$product_option['options']]) && $filter_ogrouping && $filter_report == 'products') { ?>              
            <option value="<?php echo $product_option['options']; ?>" selected="selected"><?php echo $product_option['option_name']; ?>: <?php echo $product_option['option_value']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $product_option['options']; ?>"><?php echo $product_option['option_name']; ?>: <?php echo $product_option['option_value']; ?></option>
            <?php } ?>
            <?php } ?>
          <?php } elseif ($filter_report != 'products') { ?>
            <?php foreach ($product_options as $product_option) { ?>
            <?php if (isset($filter_option[$product_option['options']]) && $filter_report != 'products') { ?>              
            <option value="<?php echo $product_option['options']; ?>" selected="selected"><?php echo $product_option['option_name']; ?>: <?php echo $product_option['option_value']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $product_option['options']; ?>"><?php echo $product_option['option_name']; ?>: <?php echo $product_option['option_value']; ?></option>
            <?php } ?>
            <?php } ?>            
          <?php } ?>  
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
      </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp18_filter">
        <tr><td><?php echo $entry_attributes; ?><br />
          <span <?php echo (!$filter_attribute) ? '' : 'class="vtip"' ?> title="<?php foreach ($attributes as $attribute) { ?><?php if (isset($filter_attribute[$attribute['attribute_title']])) { ?><?php echo $attribute['attribute_name']; ?><br /><?php } ?><?php } ?>">
		  <select name="filter_attribute" id="filter_attribute" multiple="multiple" size="1">
            <?php foreach ($attributes as $attribute) { ?>
            <?php if (isset($filter_attribute[$attribute['attribute_title']])) { ?>              
            <option value="<?php echo $attribute['attribute_title']; ?>" selected="selected"><?php echo $attribute['attribute_name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $attribute['attribute_title']; ?>"><?php echo $attribute['attribute_name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp6_filter">
        <tr><td><?php echo $entry_prod_status; ?><br />
          <span <?php echo (!$filter_status) ? '' : 'class="vtip"' ?> title="<?php foreach ($statuses as $status) { ?><?php if (isset($filter_status[$status['status']]) && $status['status'] == 1) { ?><?php echo $text_enabled; ?><br /><?php } ?><?php if (isset($filter_status[$status['status']]) && $status['status'] == 0) { ?><?php echo $text_disabled; ?><br /><?php } ?><?php } ?>">         
          <select name="filter_status" id="filter_status" multiple="multiple" size="1">
            <?php foreach ($statuses as $status) { ?>
            <?php if (isset($filter_status[$status['status']]) && $status['status'] == 1) { ?>
            <option value="<?php echo $status['status']; ?>" selected="selected"><?php echo $text_enabled; ?></option>
            <?php } elseif (!isset($filter_status[$status['status']]) && $status['status'] == 1) { ?>
            <option value="<?php echo $status['status']; ?>"><?php echo $text_enabled; ?></option>
            <?php } ?>
            <?php if (isset($filter_status[$status['status']]) && $status['status'] == 0) { ?>
            <option value="<?php echo $status['status']; ?>" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } elseif (!isset($filter_status[$status['status']]) && $status['status'] == 0) { ?>
            <option value="<?php echo $status['status']; ?>"><?php echo $text_disabled; ?></option>
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
      </tr></table>
      <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp11_filter">
        <tr><td><?php echo $entry_location; ?><br />
          <span <?php echo (!$filter_location) ? '' : 'class="vtip"' ?> title="<?php foreach ($locations as $location) { ?><?php if (isset($filter_location[$location['location_title']])) { ?><?php echo $location['location_name']; ?><br /><?php } ?><?php } ?>">
		  <select name="filter_location" id="filter_location" multiple="multiple" size="1">
            <?php foreach ($locations as $location) { ?>
            <?php if (isset($filter_location[$location['location_title']])) { ?>              
            <option value="<?php echo $location['location_title']; ?>" selected="selected"><?php echo $location['location_name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $location['location_title']; ?>"><?php echo $location['location_name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>
	  <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp12a_filter">
        <tr><td><?php echo $entry_affiliate_name; ?><br />
          <span <?php echo (!$filter_affiliate_name) ? '' : 'class="vtip"' ?> title="<?php foreach ($affiliate_names as $affiliate_name) { ?><?php if (isset($filter_affiliate_name[$affiliate_name['affiliate_id']])) { ?><?php echo $affiliate_name['affiliate_name']; ?><br /><?php } ?><?php } ?>">        
          <select name="filter_affiliate_name" id="filter_affiliate_name" multiple="multiple" size="1">
            <?php foreach ($affiliate_names as $affiliate_name) { ?>
            <?php if (isset($filter_affiliate_name[$affiliate_name['affiliate_id']])) { ?>              
            <option value="<?php echo $affiliate_name['affiliate_id']; ?>" selected="selected"><?php echo $affiliate_name['affiliate_name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $affiliate_name['affiliate_id']; ?>"><?php echo $affiliate_name['affiliate_name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>
	  <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp12b_filter">
        <tr><td><?php echo $entry_affiliate_email; ?><br />
          <span <?php echo (!$filter_affiliate_email) ? '' : 'class="vtip"' ?> title="<?php foreach ($affiliate_emails as $affiliate_email) { ?><?php if (isset($filter_affiliate_email[$affiliate_email['affiliate_id']])) { ?><?php echo $affiliate_email['affiliate_email']; ?><br /><?php } ?><?php } ?>">        

          <select name="filter_affiliate_email" id="filter_affiliate_email" multiple="multiple" size="1">
            <?php foreach ($affiliate_emails as $affiliate_email) { ?>
            <?php if (isset($filter_affiliate_email[$affiliate_email['affiliate_id']])) { ?>              
            <option value="<?php echo $affiliate_email['affiliate_id']; ?>" selected="selected"><?php echo $affiliate_email['affiliate_email']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $affiliate_email['affiliate_id']; ?>"><?php echo $affiliate_email['affiliate_email']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>
	  <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp15a_filter">
        <tr><td><?php echo $entry_coupon_name; ?><br />
          <span <?php echo (!$filter_coupon_name) ? '' : 'class="vtip"' ?> title="<?php foreach ($coupon_names as $coupon_name) { ?><?php if (isset($filter_coupon_name[$coupon_name['coupon_id']])) { ?><?php echo $coupon_name['coupon_name']; ?><br /><?php } ?><?php } ?>">        
          <select name="filter_coupon_name" id="filter_coupon_name" multiple="multiple" size="1">
            <?php foreach ($coupon_names as $coupon_name) { ?>
            <?php if (isset($filter_coupon_name[$coupon_name['coupon_id']])) { ?>              
            <option value="<?php echo $coupon_name['coupon_id']; ?>" selected="selected"><?php echo $coupon_name['coupon_name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $coupon_name['coupon_id']; ?>"><?php echo $coupon_name['coupon_name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>
	  <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp15b_filter">
        <tr><td><?php echo $entry_coupon_code; ?><br />
          <span <?php echo (!$filter_coupon_code) ? '' : 'class="vtip"' ?> title="<?php foreach ($coupon_codes as $coupon_code) { ?><?php if (isset($filter_coupon_code[$coupon_code['coupon_id']])) { ?><?php echo $coupon_code['coupon_code']; ?><br /><?php } ?><?php } ?>">        
          <select name="filter_coupon_code" id="filter_coupon_code" multiple="multiple" size="1">
            <?php foreach ($coupon_codes as $coupon_code) { ?>
            <?php if (isset($filter_coupon_code[$coupon_code['coupon_id']])) { ?>              
            <option value="<?php echo $coupon_code['coupon_id']; ?>" selected="selected"><?php echo $coupon_code['coupon_code']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $coupon_code['coupon_id']; ?>"><?php echo $coupon_code['coupon_code']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>
	  <table cellpadding="0" cellspacing="0" style="float:left;" id="ppp19_filter">
        <tr><td><?php echo $entry_voucher_code; ?><br />
          <span <?php echo (!$filter_voucher_code) ? '' : 'class="vtip"' ?> title="<?php foreach ($voucher_codes as $voucher_code) { ?><?php if (isset($filter_voucher_code[$voucher_code['voucher_id']])) { ?><?php echo $voucher_code['voucher_code']; ?><br /><?php } ?><?php } ?>">        
          <select name="filter_voucher_code" id="filter_voucher_code" multiple="multiple" size="1">
            <?php foreach ($voucher_codes as $voucher_code) { ?>
            <?php if (isset($filter_voucher_code[$voucher_code['voucher_id']])) { ?>              
            <option value="<?php echo $voucher_code['voucher_id']; ?>" selected="selected"><?php echo $voucher_code['voucher_code']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $voucher_code['voucher_id']; ?>"><?php echo $voucher_code['voucher_code']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>
	   </td>
	  </tr>
	 </table>
	</td>
	</tr>
	</table>      
</div>
<script type="text/javascript">$(function(){ 
$('#show_tab_export').click(function() {
		$('#tab_export').slideToggle('fast');
	});
});
</script>    
  <div id="tab_export" style="background:#E7EFEF; border:1px solid #C6D7D7; padding:3px; margin-bottom:15px; display:none">
      <table width="100%" cellspacing="0" cellpadding="3">
        <tr>
          <td width="3%">&nbsp;</td>
          <td width="12%" align="center" nowrap="nowrap">
          <?php if ($filter_report == 'manufacturers' or $filter_report == 'categories') { ?>
          <span class="noexport_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" /></span><span class="noexport_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" /></span><span class="noexport_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" /></span>
          <?php } else { ?>          
          <span id="export_xls_prod" class="export_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" title="XLS" /></span><span id="export_html_prod" class="export_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" title="HTML" /></span><span id="export_pdf_prod" class="export_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" title="PDF" /></span>
          <?php } ?></td>   
          <td width="12%" align="center" nowrap="nowrap">
          <?php if ($filter_report == 'manufacturers' or $filter_report == 'categories') { ?>
          <span class="noexport_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" /></span><span class="noexport_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" /></span><span class="noexport_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" /></span>
          <?php } else { ?>            
          <span id="export_xls_prod_order_list" class="export_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" title="XLS" /></span><span id="export_html_prod_order_list" class="export_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" title="HTML" /></span><span id="export_pdf_prod_order_list" class="export_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" title="PDF" /></span>
          <?php } ?></td>   
          <td width="12%" align="center" nowrap="nowrap">
          <?php if ($filter_report == 'manufacturers' or $filter_report == 'categories') { ?>
          <span class="noexport_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" /></span><span class="noexport_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" /></span><span class="noexport_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" /></span>
          <?php } else { ?>            
          <span id="export_xls_prod_customer_list" class="export_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" title="XLS" /></span><span id="export_html_prod_customer_list" class="export_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" title="HTML" /></span><span id="export_pdf_prod_customer_list" class="export_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" title="PDF" /></span>
          <?php } ?></td>   
          <td width="5%">&nbsp;</td>
          <td width="12%" align="center" nowrap="nowrap">
          <?php if ($filter_report == 'products' or $filter_report == 'categories') { ?>
          <span class="noexport_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" /></span><span class="noexport_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" /></span><span class="noexport_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" /></span>
          <?php } else { ?>
          <span id="export_xls_manu" class="export_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" title="XLS" /></span><span id="export_html_manu" class="export_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" title="HTML" /></span><span id="export_pdf_manu" class="export_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" title="PDF" /></span>
          <?php } ?></td>                    
          <td width="12%" align="center" nowrap="nowrap">
          <?php if ($filter_report == 'products' or $filter_report == 'categories') { ?>
          <span class="noexport_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" /></span><span class="noexport_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" /></span><span class="noexport_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" /></span>
          <?php } else { ?>          
          <span id="export_xls_manu_product_list" class="export_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" title="XLS" /></span><span id="export_html_manu_product_list" class="export_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" title="HTML" /></span><span id="export_pdf_manu_product_list" class="export_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" title="PDF" /></span>
          <?php } ?></td> 
          <td width="5%">&nbsp;</td>
          <td width="12%" align="center" nowrap="nowrap">
          <?php if ($filter_report == 'products' or $filter_report == 'manufacturers') { ?>
          <span class="noexport_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" /></span><span class="noexport_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" /></span><span class="noexport_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" /></span>
          <?php } else { ?>          
          <span id="export_xls_cat" class="export_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" title="XLS" /></span><span id="export_html_cat" class="export_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" title="HTML" /></span><span id="export_pdf_cat" class="export_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" title="PDF" /></span>
          <?php } ?></td>                  
          <td width="12%" align="center" nowrap="nowrap">
          <?php if ($filter_report == 'products' or $filter_report == 'manufacturers') { ?>
          <span class="noexport_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" /></span><span class="noexport_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" /></span><span class="noexport_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" /></span>
          <?php } else { ?>          
          <span id="export_xls_cat_product_list" class="export_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" title="XLS" /></span><span id="export_html_cat_product_list" class="export_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" title="HTML" /></span><span id="export_pdf_cat_product_list" class="export_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" title="PDF" /></span>
          <?php } ?></td> 
          <td width="3%">&nbsp;</td>
        </tr>
        <tr>
          <td width="3%">&nbsp;</td>
          <td width="12%" align="center" nowrap="nowrap">
          <?php if ($filter_report == 'manufacturers' or $filter_report == 'categories') { ?>          
          <label style="color:#999; cursor:default;"><?php echo $text_export_prod_no_details; ?></label>
          <?php } else { ?>  
          <?php echo $text_export_prod_no_details; ?>          
          <?php } ?></td>          
          <td width="12%" align="center" nowrap="nowrap">
          <?php if ($filter_report == 'manufacturers' or $filter_report == 'categories') { ?>          
          <label style="color:#999; cursor:default;"><?php echo $text_export_prod_order_list; ?></label>
          <?php } else { ?>  
          <?php echo $text_export_prod_order_list; ?>          
          <?php } ?></td>  
          <td width="12%" align="center" nowrap="nowrap">
          <?php if ($filter_report == 'manufacturers' or $filter_report == 'categories') { ?>          
          <label style="color:#999; cursor:default;"><?php echo $text_export_prod_customer_list; ?></label>
          <?php } else { ?>  
          <?php echo $text_export_prod_customer_list; ?>          
          <?php } ?></td>  
          <td width="5%">&nbsp;</td>          
          <td width="12%" align="center" nowrap="nowrap">
          <?php if ($filter_report == 'products' or $filter_report == 'categories') { ?>          
          <label style="color:#999; cursor:default;"><?php echo $text_export_manu_no_details; ?></label>
          <?php } else { ?>  
          <?php echo $text_export_manu_no_details; ?>          
          <?php } ?></td>    
          <td width="12%" align="center" nowrap="nowrap">
          <?php if ($filter_report == 'products' or $filter_report == 'categories') { ?>          
          <label style="color:#999; cursor:default;"><?php echo $text_export_manu_product_list; ?></label>
          <?php } else { ?>            
          <?php echo $text_export_manu_product_list; ?>
          <?php } ?></td>  
          <td width="5%">&nbsp;</td>          
          <td width="12%" align="center" nowrap="nowrap">
          <?php if ($filter_report == 'products' or $filter_report == 'manufacturers') { ?>          
          <label style="color:#999; cursor:default;"><?php echo $text_export_cat_no_details; ?></label>
          <?php } else { ?>           
          <?php echo $text_export_cat_no_details; ?>
          <?php } ?></td>  
          <td width="12%" align="center" nowrap="nowrap">
          <?php if ($filter_report == 'products' or $filter_report == 'manufacturers') { ?>          
          <label style="color:#999; cursor:default;"><?php echo $text_export_cat_product_list; ?></label>
          <?php } else { ?>           
          <?php echo $text_export_cat_product_list; ?>
          <?php } ?></td>                                
          <td width="3%">&nbsp;</td>                                                                                                                       
        </tr>  
        <tr>
          <td colspan="11">*<span style="font-size:10px"><?php echo $text_export_notice1; ?> <a href="view/template/module/adv_reports/adv_requirements_limitations.htm" id="adv_export_limit"><strong><?php echo $text_export_limit; ?></strong></a> <?php echo $text_export_notice2; ?></span></td>
        </tr>                 
      </table> 
  <input type="hidden" id="export" name="export" value="" />
<div id="adv_export_limit_text" style="display:none"></div>
<script type="text/javascript">
$("#adv_export_limit").click(function(e) {
    e.preventDefault();
    $("#adv_export_limit_text").load(this.href, function() {
        $(this).dialog({
            title: '<?php echo $text_export_limit; ?>',
            width:  800,
            height:  600,
            minWidth:  500,
            minHeight:  400,
            modal: true,
        });
    });
    return false;
});
</script>   
  </div>  
<?php if ($products) { ?>
<?php if (($filter_range != 'all_time' && ($filter_group == 'year' or $filter_group == 'quarter' or $filter_group == 'month')) or ($filter_range == 'all_time' && $filter_group == 'year')) { ?>   
<script type="text/javascript">$(function(){ 
$('#show_tab_chart').click(function() {
		$('#tab_chart').slideToggle('slow');
	});
});
</script>  
    <div id="tab_chart">
      <table align="center" cellspacing="0" cellpadding="0">
        <tr>
          <td><div style="float:left;" id="chart1_div"></div><div style="float:left;" id="chart2_div"></div></td>
        </tr>              
      </table>
    </div>
<?php } ?> 
<?php } ?>     
	<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) { ?>
    <div id="pagination_content" style="overflow:scroll; padding:1px;"> 
    <?php } else { ?>
    <div id="pagination_content" style="overflow:auto; padding:1px;">     
    <?php } ?>
    <table class="list_main">
      <thead>
          <tr>
		  <?php if ($filter_group == 'year') { ?>           
          <td class="left" colspan="2" nowrap="nowrap"><?php echo $column_year; ?></td>
		  <?php } elseif ($filter_group == 'quarter') { ?> 
          <td class="left" nowrap="nowrap"><?php echo $column_year; ?></td>
          <td class="left" nowrap="nowrap"><?php echo $column_quarter; ?></td>       
		  <?php } elseif ($filter_group == 'month') { ?> 
          <td class="left" nowrap="nowrap"><?php echo $column_year; ?></td>
          <td class="left" nowrap="nowrap"><?php echo $column_month; ?></td> 
		  <?php } elseif ($filter_group == 'day') { ?> 
          <td class="left" colspan="2" nowrap="nowrap"><?php echo $column_date; ?></td>  
		  <?php } elseif ($filter_group == 'order') { ?> 
          <td class="left" nowrap="nowrap"><?php echo $column_order_prod_order_id; ?></td>
          <td class="left" nowrap="nowrap"><?php echo $column_order_prod_date_added; ?></td>           
		  <?php } else { ?>    
          <td class="left" width="70" nowrap="nowrap"><?php echo $column_date_start; ?></td>
          <td class="left" width="70" nowrap="nowrap"><?php echo $column_date_end; ?></td>           
		  <?php } ?> 
		  <?php if ($filter_report == 'products') { ?>          
          <td id="ppp20_title" class="center"><?php echo $column_image; ?></td> 
          <td id="ppp21_title" class="left"><?php echo $column_sku; ?></td>           
          <td id="ppp22_title" class="left"><?php echo $column_name; ?></td>                    
          <td id="ppp23_title" class="left"><?php echo $column_model; ?></td>  
          <td id="ppp24_title" class="left"><?php echo $column_category; ?></td>            
          <td id="ppp25_title" class="left"><?php echo $column_manufacturer; ?></td>
          <td id="ppp34_title" class="left"><?php echo $column_attribute; ?></td>            
          <td id="ppp26_title" class="left"><?php echo $column_status; ?></td> 
          <td id="ppp35_title" class="right"><?php echo $column_stock_quantity; ?></td>            
		  <?php } elseif ($filter_report == 'manufacturers') { ?>    
          <td id="ppp25_title" class="left"><?php echo $column_manufacturer; ?></td>
		  <?php } elseif ($filter_report == 'categories') { ?>
          <td id="ppp24_title" class="left"><?php echo $column_category; ?></td>  
		  <?php } ?>
          <td id="ppp27_title" class="right"><?php echo $column_sold_quantity; ?></td>            
          <td id="ppp28_title" class="right"><?php echo $column_sold_percent; ?></td>
          <td id="ppp30_title" class="right"><?php echo $column_tax; ?></td>
          <td id="ppp29_title" class="right"><?php echo $column_total; ?></td>          
          <td id="ppp31_title" class="right"><?php echo $column_prod_costs; ?></td>        
          <td id="ppp32_title" class="right"><?php echo $column_prod_profit; ?></td>
          <td id="ppp33_title" class="right"><?php echo $column_profit_margin; ?></td>
          <?php if (($filter_report == 'products' && $filter_details == 1 OR $filter_details == 2) OR ($filter_report == 'manufacturers' && $filter_details == 3) OR ($filter_report == 'categories' && $filter_details == 3)) { ?><td class="right" nowrap="nowrap"><?php echo $column_action; ?></td><?php } ?>
          </tr>
          </thead>
          <?php if ($products) { ?>
          <?php foreach ($products as $product) { ?>
      	  <tbody id="element">        
          <tr <?php echo ($filter_details == 1 OR $filter_details == 2 OR $filter_details == 3) ? 'style="cursor:pointer;" title="' . $text_detail . '"' : '' ?> id="show_details_<?php echo $product['order_product_id']; ?>">
		  <?php if ($filter_group == 'year') { ?>           
          <td class="left" colspan="2" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $product['year']; ?></td>
		  <?php } elseif ($filter_group == 'quarter') { ?> 
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $product['year']; ?></td>
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $product['quarter']; ?></td>  
		  <?php } elseif ($filter_group == 'month') { ?> 
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $product['year']; ?></td>
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $product['month']; ?></td>
		  <?php } elseif ($filter_group == 'day') { ?> 
          <td class="left" colspan="2" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $product['date_start']; ?></td>    
		  <?php } elseif ($filter_group == 'order') { ?> 
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $product['order_id']; ?></td>
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $product['date_start']; ?></td>          
		  <?php } else { ?>    
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $product['date_start']; ?></td>
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $product['date_end']; ?></td>         
		  <?php } ?>
		  <?php if ($filter_report == 'products') { ?>           
          <td id="ppp20_<?php echo $product['order_product_id']; ?>" class="center"><img src="<?php echo $product['image']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td> 
          <td id="ppp21_<?php echo $product['order_product_id']; ?>" class="left"><?php echo $product['sku']; ?></td>           
          <td id="ppp22_<?php echo $product['order_product_id']; ?>" class="left">
          <?php if ($product['status'] != NULL) { ?>
          <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
          <?php } else { ?>
          <?php echo $product['name']; ?>
          <?php } ?>
          <?php if ($filter_ogrouping) { ?>
          <?php if ($product['oovalue']) { ?>
          <table cellpadding="0" cellspacing="0" border="0" style="border:none;">
          <tr>
		  <td nowrap="nowrap" style="font-size:11px; border:none;"><?php echo $product['ooname']; ?>:</td>
          <td nowrap="nowrap" style="font-size:11px; border:none;"><?php echo $product['oovalue']; ?></td>
          </tr>
          </table>
          <?php } ?><?php } ?></td>
          <td id="ppp23_<?php echo $product['order_product_id']; ?>" class="left"><?php echo $product['model']; ?></td>             
          <td id="ppp24_<?php echo $product['order_product_id']; ?>" class="left"><?php foreach ($categories as $category) { ?>
                <?php if (in_array($category['category_id'], $product['category'])) { ?>
                <?php echo $category['name'];?><br />
                <?php } ?> <?php } ?></td>          
          <td id="ppp25_<?php echo $product['order_product_id']; ?>" class="left"><?php foreach ($manufacturers as $manufacturer) { ?>
                <?php if (in_array($manufacturer['manufacturer_id'], $product['manufacturer'])) { ?>
                <?php echo $manufacturer['name'];?>
                <?php } ?> <?php } ?></td>
          <td id="ppp34_<?php echo $product['order_product_id']; ?>" class="left"><?php echo $product['attribute']; ?></td>                  
		  <td id="ppp26_<?php echo $product['order_product_id']; ?>" class="left">
				<?php if ($product['status'] == '1') { ?>
				<?php echo $text_enabled; ?>
				<?php } else if ($product['status'] == '0') { ?>
				<?php echo $text_disabled; ?>
				<?php } ?></td>
          <td id="ppp35_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap">
          		<?php if ($product['stock_quantity'] <= 0) { ?>
				<span style="color:#FF0000;"><?php echo $product['stock_quantity']; ?></span>
				<?php } elseif ($product['stock_quantity'] <= 5) { ?>
				<span style="color:#FFA500;"><?php echo $product['stock_quantity']; ?></span>
				<?php } else { ?>
				<?php echo $product['stock_quantity']; ?>
				<?php } ?>
				<?php if ($filter_ogrouping) { ?>
				<?php if ($product['oovalue']) { ?><br />
				<?php if ($product['stock_oquantity'] <= 0) { ?>
				<span style="font-size:11px; color:#FF0000;"><?php echo $product['stock_oquantity']; ?></span>
				<?php } elseif ($product['stock_oquantity'] <= 5) { ?>
				<span style="font-size:11px; color:#FFA500;"><?php echo $product['stock_oquantity']; ?></span>
				<?php } else { ?>
				<span style="font-size:11px;"><?php echo $product['stock_oquantity']; ?></span>
				<?php } ?>
				<?php } ?>
				<?php } ?></td>
		  <?php } elseif ($filter_report == 'manufacturers') { ?>
          <td id="ppp25_<?php echo $product['order_product_id']; ?>" class="left"><?php foreach ($manufacturers as $manufacturer) { ?>
                <?php if (in_array($manufacturer['manufacturer_id'], $product['manufacturer'])) { ?>
                <?php echo $manufacturer['name'];?>
                <?php } ?> <?php } ?></td>
		  <?php } elseif ($filter_report == 'categories') { ?>
          <td id="ppp24_<?php echo $product['order_product_id']; ?>" class="left"><?php foreach ($categories as $category) { ?>
                <?php if (in_array($category['category_id'], $product['category'])) { ?>
                <?php echo $category['name'];?><br />
                <?php } ?> <?php } ?></td>              
		  <?php } ?>    
          <td id="ppp27_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap" style="background-color:#FFC;"><?php echo $product['sold_quantity']; ?></td>           
          <td id="ppp28_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap" style="background-color:#FFC;"><?php echo $product['sold_percent']; ?></td>
          <td id="ppp30_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap"><?php echo $product['tax']; ?></td>
          <td id="ppp29_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap" style="background-color:#DCFFB9;"><?php echo $product['prod_sales']; ?></td>
          <td id="ppp31_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap" style="background-color:#ffd7d7;"><?php echo $product['prod_costs']; ?></td>         
          <td id="ppp32_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap" style="background-color:#BCD5ED; font-weight:bold;"><?php echo $product['prod_profit']; ?></td> 
          <td id="ppp33_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap" style="background-color:#BCD5ED; font-weight:bold;"><?php echo $product['profit_margin_percent']; ?></td>
          <?php if (($filter_report == 'products' && $filter_details == 1 OR $filter_details == 2) OR ($filter_report == 'manufacturers' && $filter_details == 3) OR ($filter_report == 'categories' && $filter_details == 3)) { ?><td class="right" nowrap="nowrap">[ <a><?php echo $text_detail; ?></a> ]</td><?php } ?>
          </tr>
<tr class="detail">
<td colspan="19" class="center">
<?php if ($filter_report == 'products' && $filter_details == 1) { ?>
<script type="text/javascript">$(function(){ 
$('#show_details_<?php echo $product["order_product_id"]; ?>').click(function() {
		$('#tab_details_<?php echo $product["order_product_id"]; ?>').slideToggle('slow');
	});
});
</script>
<div id="tab_details_<?php echo $product['order_product_id']; ?>" style="display:none">
    <table class="list_detail">
      <thead>
        <tr>
          <td id="ppp40_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_prod_order_id; ?></td>        
          <td id="ppp41_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_prod_date_added; ?></td>
          <td id="ppp42_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_prod_inv_no; ?></td>            
          <td id="ppp43_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_prod_customer; ?></td>
          <td id="ppp44_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_prod_email; ?></td>
          <td id="ppp45_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_prod_customer_group; ?></td>
          <td id="ppp46_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_prod_shipping_method; ?></td>
          <td id="ppp47_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_prod_payment_method; ?></td>          
          <td id="ppp48_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_prod_status; ?></td>
          <td id="ppp49_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_prod_store; ?></td>
          <td id="ppp50_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_prod_currency; ?></td>
          <td id="ppp51_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_prod_price; ?></td> 
          <td id="ppp52_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_prod_quantity; ?></td>
          <td id="ppp54_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_prod_tax; ?></td>
          <td id="ppp53_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_prod_total; ?></td>
          <td id="ppp55_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_prod_costs; ?></td> 
          <td id="ppp56_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_prod_profit; ?></td>  
          <td id="ppp57_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_profit_margin; ?></td>                             
        </tr>
      </thead>
        <tr bgcolor="#FFFFFF">
          <td id="ppp40_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['order_prod_ord_id']; ?></td>        
          <td id="ppp41_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['order_prod_order_date']; ?></td>
          <td id="ppp42_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['order_prod_inv_no']; ?></td>
          <td id="ppp43_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['order_prod_name']; ?></td>
          <td id="ppp44_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['order_prod_email']; ?></td>
          <td id="ppp45_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['order_prod_group']; ?></td>
          <td id="ppp46_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['order_prod_shipping_method']; ?></td>
          <td id="ppp47_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['order_prod_payment_method']; ?></td>           
          <td id="ppp48_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['order_prod_status']; ?></td>
          <td id="ppp49_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['order_prod_store']; ?></td>           
          <td id="ppp50_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap"><?php echo $product['order_prod_currency']; ?></td>  
          <td id="ppp51_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap"><?php echo $product['order_prod_price']; ?></td> 
          <td id="ppp52_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap"><?php echo $product['order_prod_quantity']; ?></td>
          <td id="ppp54_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap"><?php echo $product['order_prod_tax']; ?></td>
          <td id="ppp53_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap" style="background-color:#DCFFB9;"><?php echo $product['order_prod_total']; ?></td>
          <td id="ppp55_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap" style="background-color:#ffd7d7;">-<?php echo $product['order_prod_costs']; ?></td>                    
          <td id="ppp56_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap" style="background-color:#BCD5ED; font-weight:bold;"><?php echo $product['order_prod_profit']; ?></td>
          <td id="ppp57_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap" style="background-color:#BCD5ED; font-weight:bold;"><?php echo $product['order_prod_profit_margin_percent']; ?>%</td>
         </tr>
    </table>
</div>
<?php } ?>
<?php if ($filter_report == 'manufacturers' && $filter_details == 3 or $filter_report == 'categories' && $filter_details == 3) { ?>
<script type="text/javascript">$(function(){ 
$('#show_details_<?php echo $product["order_product_id"]; ?>').click(function() {
		$('#tab_details_<?php echo $product["order_product_id"]; ?>').slideToggle('slow');
	});
});
</script>
<div id="tab_details_<?php echo $product['order_product_id']; ?>" style="display:none">
    <table class="list_detail">
      <thead>
        <tr>
          <td id="ppp60_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_order_id; ?></td>  
          <td id="ppp61_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_date_added; ?></td>
          <td id="ppp62_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_inv_no; ?></td> 
          <td id="ppp63_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_id; ?></td>                                          
          <td id="ppp64_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_sku; ?></td>
          <td id="ppp67_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_model; ?></td>            
          <td id="ppp65_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_name; ?></td> 
          <td id="ppp66_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_option; ?></td>
          <td id="ppp77_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_attributes; ?></td>          
          <?php if ($filter_report == 'categories') { ?>          
          <td id="ppp68_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_manu; ?></td> 
          <?php } ?>
          <?php if ($filter_report == 'manufacturers') { ?>          
          <td id="ppp79_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_category; ?></td> 
          <?php } ?>          
          <td id="ppp69_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_prod_currency; ?></td>   
          <td id="ppp70_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_prod_price; ?></td>                     
          <td id="ppp71_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_prod_quantity; ?></td> 
          <td id="ppp73_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_prod_tax; ?></td>
          <td id="ppp72_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_prod_total; ?></td>
          <td id="ppp74_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_prod_costs; ?></td> 
          <td id="ppp75_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_prod_profit; ?></td>
          <td id="ppp76_<?php echo $product['order_product_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_profit_margin; ?></td>                                                                      
        </tr>
      </thead>
        <tr bgcolor="#FFFFFF">
          <td id="ppp60_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><a><?php echo $product['product_ord_id']; ?></a></td>  
          <td id="ppp61_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['product_order_date']; ?></td>
          <td id="ppp62_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['product_inv_no']; ?></td>
          <td id="ppp63_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['product_pid']; ?></td>  
          <td id="ppp64_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['product_sku']; ?></td>
          <td id="ppp67_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['product_model']; ?></td>          
          <td id="ppp65_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['product_name']; ?></td> 
          <td id="ppp66_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['product_option']; ?></td>
          <td id="ppp77_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['product_attributes']; ?></td>          
          <?php if ($filter_report == 'categories') { ?>        
          <td id="ppp68_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['product_manu']; ?></td> 
          <?php } ?>
          <?php if ($filter_report == 'manufacturers') { ?>        
          <td id="ppp79_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['product_category']; ?></td> 
          <?php } ?>          
          <td id="ppp69_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap"><?php echo $product['product_currency']; ?></td> 
          <td id="ppp70_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap"><?php echo $product['product_price']; ?></td> 
          <td id="ppp71_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap"><?php echo $product['product_quantity']; ?></td>
          <td id="ppp73_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap"><?php echo $product['product_tax']; ?></td>
          <td id="ppp72_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap" style="background-color:#DCFFB9;"><?php echo $product['product_total']; ?></td>
          <td id="ppp74_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap" style="background-color:#ffd7d7;">-<?php echo $product['product_costs']; ?></td>
          <td id="ppp75_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap" style="background-color:#c4d9ee; font-weight:bold;"><?php echo $product['product_profit']; ?></td>
          <td id="ppp76_<?php echo $product['order_product_id']; ?>" class="right" nowrap="nowrap" style="background-color:#c4d9ee; font-weight:bold;"><?php echo $product['product_profit_margin_percent']; ?>%</td>   
         </tr>       
    </table>
</div> 
<?php } ?>  
<?php if ($filter_report == 'products' && $filter_details == 2) { ?>
<script type="text/javascript">$(function(){ 
$('#show_details_<?php echo $product["order_product_id"]; ?>').click(function() {
		$('#tab_details_<?php echo $product["order_product_id"]; ?>').slideToggle('slow');
	});
});
</script>
<div id="tab_details_<?php echo $product['order_product_id']; ?>" style="display:none">
    <table class="list_detail">
      <thead>
        <tr>
          <td id="ppp80_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_customer_order_id; ?></td>        
          <td id="ppp81_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_customer_date_added; ?></td>
          <td id="ppp82_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_customer_inv_no; ?></td>           
          <td id="ppp83_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_customer_cust_id; ?></td>           
          <td id="ppp84_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_name; ?></td> 
          <td id="ppp85_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_company; ?></td> 
          <td id="ppp86_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_address_1; ?></td> 
          <td id="ppp87_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_address_2; ?></td> 
          <td id="ppp88_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_city; ?></td>
          <td id="ppp89_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_zone; ?></td> 
          <td id="ppp90_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_postcode; ?></td>
          <td id="ppp91_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_country; ?></td>
          <td id="ppp92_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_customer_telephone; ?></td>
          <td id="ppp93_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_name; ?></td> 
          <td id="ppp94_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_company; ?></td> 
          <td id="ppp95_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_address_1; ?></td> 
          <td id="ppp96_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_address_2; ?></td> 
          <td id="ppp97_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_city; ?></td>
          <td id="ppp98_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_zone; ?></td> 
          <td id="ppp99_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_postcode; ?></td>
          <td id="ppp100_<?php echo $product['order_product_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_country; ?></td>          
        </tr>
      </thead>
        <tr bgcolor="#FFFFFF">
          <td id="ppp80_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['customer_ord_id']; ?></td>        
          <td id="ppp81_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['customer_order_date']; ?></td>
          <td id="ppp82_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['customer_inv_no']; ?></td>
          <td id="ppp83_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['customer_cust_id']; ?></td>             
          <td id="ppp84_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['billing_name']; ?></td>         
          <td id="ppp85_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['billing_company']; ?></td> 
          <td id="ppp86_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['billing_address_1']; ?></td> 
          <td id="ppp87_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['billing_address_2']; ?></td> 
          <td id="ppp88_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['billing_city']; ?></td> 
          <td id="ppp89_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['billing_zone']; ?></td> 
          <td id="ppp90_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['billing_postcode']; ?></td>                    
          <td id="ppp91_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['billing_country']; ?></td>
          <td id="ppp92_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['customer_telephone']; ?></td> 
          <td id="ppp93_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['shipping_name']; ?></td>         
          <td id="ppp94_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['shipping_company']; ?></td> 
          <td id="ppp95_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['shipping_address_1']; ?></td> 
          <td id="ppp96_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['shipping_address_2']; ?></td> 
          <td id="ppp97_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['shipping_city']; ?></td> 
          <td id="ppp98_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['shipping_zone']; ?></td> 
          <td id="ppp99_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['shipping_postcode']; ?></td>                    
          <td id="ppp100_<?php echo $product['order_product_id']; ?>" class="left" nowrap="nowrap"><?php echo $product['shipping_country']; ?></td>                                                         
         </tr>
    </table>
</div> 
<?php } ?>  
</td>
</tr>       
        <?php } ?>
        <tr>
        <td colspan="19"></td>
        </tr>               
        <tr>
          <td colspan="2" class="right" style="background-color:#E7EFEF;"><strong><?php echo $text_filter_total; ?></strong></td>
		  <?php if ($filter_report == 'products') { ?>            
          <td id="ppp20_total" style="background-color:#DDDDDD;"></td>
          <td id="ppp21_total" style="background-color:#DDDDDD;"></td>
          <td id="ppp22_total" style="background-color:#DDDDDD;"></td>
          <td id="ppp23_total" style="background-color:#DDDDDD;"></td>
          <td id="ppp24_total" style="background-color:#DDDDDD;"></td>
          <td id="ppp25_total" style="background-color:#DDDDDD;"></td>
          <td id="ppp34_total" style="background-color:#DDDDDD;"></td>
          <td id="ppp26_total" style="background-color:#DDDDDD;"></td>
          <td id="ppp35_total" style="background-color:#DDDDDD;"></td>              
		  <?php } elseif ($filter_report == 'manufacturers') { ?>    
          <td id="ppp25_total" style="background-color:#DDDDDD;"></td>
		  <?php } elseif ($filter_report == 'categories') { ?>
          <td id="ppp24_total" style="background-color:#DDDDDD;"></td>        
		  <?php } ?>        
          <td id="ppp27_total" class="right" nowrap="nowrap" style="background-color:#E7EFEF; color:#003A88;"><strong><?php echo $product['sold_quantity_total']; ?></strong></td>           
          <td id="ppp28_total" class="right" nowrap="nowrap" style="background-color:#E7EFEF; color:#003A88;"><strong><?php echo $product['sold_percent_total']; ?></strong></td>
          <td id="ppp30_total" class="right" nowrap="nowrap" style="background-color:#E7EFEF; color:#003A88;"><strong><?php echo $product['tax_total']; ?></strong></td>
          <td id="ppp29_total" class="right" nowrap="nowrap" style="background-color:#DCFFB9; color:#003A88;"><strong><?php echo $product['sales_total']; ?></strong></td>          
          <td id="ppp31_total" class="right" nowrap="nowrap" style="background-color:#ffd7d7; color:#003A88;"><strong><?php echo $product['costs_total']; ?></strong></td>
          <td id="ppp32_total" class="right" nowrap="nowrap" style="background-color:#c4d9ee; color:#003A88;"><strong><?php echo $product['profit_total']; ?></strong></td> 
          <td id="ppp33_total" class="right" nowrap="nowrap" style="background-color:#c4d9ee; color:#003A88;"><strong><?php echo $product['profit_margin_total_percent']; ?></strong></td>                    
          <?php if (($filter_report == 'products' && $filter_details == 1 OR $filter_details == 2) OR ($filter_report == 'manufacturers' && $filter_details == 3) OR ($filter_report == 'categories' && $filter_details == 3)) { ?><td></td><?php } ?>                  
        </tr>
        <?php } else { ?>
        <tr>
        <?php if ($filter_report == 'products') { ?> 
          <td class="noresult" colspan="19"><?php echo $text_no_results; ?></td>
        <?php } elseif ($filter_report == 'manufacturers' or $filter_report == 'categories') { ?> 
          <td class="noresult" colspan="11"><?php echo $text_no_results; ?></td>
        <?php } ?>      
        </tr>       
        <?php } ?>
      </tbody>        
    </table>
    </div>
      <?php if ($products) { ?>    
      <div class="pagination_report"></div>
      <?php } ?>
    </div>
    </div>    
  </div>
</div>  
</form> 
<script type="text/javascript" src="view/javascript/jquery/jquery.multiSelect.js"></script>
<script type="text/javascript" src="view/javascript/jquery/jquery.paging.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/vtip.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#date-start').datepicker({changeMonth: true, changeYear: true, dateFormat: 'yy-mm-dd'});
	$('#date-end').datepicker({changeMonth: true, changeYear: true, dateFormat: 'yy-mm-dd'});

	$('#status-date-start').datepicker({changeMonth: true, changeYear: true, dateFormat: 'yy-mm-dd'});
	$('#status-date-end').datepicker({changeMonth: true, changeYear: true, dateFormat: 'yy-mm-dd'});
	
    $('#filter_order_status_id').multiSelect({
      selectAllText:'<?php echo $text_all_status; ?>', noneSelected:'<?php echo $text_all_status; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });
	
    $('#filter_store_id').multiSelect({
      selectAllText:'<?php echo $text_all_stores; ?>', noneSelected:'<?php echo $text_all_stores; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });
	
    $('#filter_currency').multiSelect({
      selectAllText:'<?php echo $text_all_currencies; ?>', noneSelected:'<?php echo $text_all_currencies; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });

    $('#filter_taxes').multiSelect({
      selectAllText:'<?php echo $text_all_taxes; ?>', noneSelected:'<?php echo $text_all_taxes; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });

    $('#filter_customer_group_id').multiSelect({
      selectAllText:'<?php echo $text_all_groups; ?>', noneSelected:'<?php echo $text_all_groups; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });
	
    $('#filter_payment_method').multiSelect({
      selectAllText:'<?php echo $text_all_payment_methods; ?>', noneSelected:'<?php echo $text_all_payment_methods; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });

    $('#filter_shipping_method').multiSelect({
      selectAllText:'<?php echo $text_all_shipping_methods; ?>', noneSelected:'<?php echo $text_all_shipping_methods; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });

    $('#filter_category').multiSelect({
      selectAllText:'<?php echo $text_all_categories; ?>', noneSelected:'<?php echo $text_all_categories; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });

    $('#filter_manufacturer').multiSelect({
      selectAllText:'<?php echo $text_all_manufacturers; ?>', noneSelected:'<?php echo $text_all_manufacturers; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });
	
    $('#filter_option').multiSelect({
      selectAllText:'<?php if ($filter_ogrouping or $filter_report != "products") { ?><?php echo $text_all_options; ?><?php } else { ?><span style="color:#999"><?php echo $text_all_options; ?></span><?php } ?>', noneSelected:'<?php if ($filter_ogrouping or $filter_report != "products") { ?><?php echo $text_all_options; ?><?php } else { ?><span style="color:#999"><?php echo $text_all_options; ?></span><?php } ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });

    $('#filter_attribute').multiSelect({
      selectAllText:'<?php echo $text_all_attributes; ?>', noneSelected:'<?php echo $text_all_attributes; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });
	
    $('#filter_status').multiSelect({
      selectAllText:'<?php echo $text_all_status; ?>', noneSelected:'<?php echo $text_all_status; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });
	
    $('#filter_location').multiSelect({
      selectAllText:'<?php echo $text_all_locations; ?>', noneSelected:'<?php echo $text_all_locations; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });

    $('#filter_affiliate_name').multiSelect({
      selectAllText:'<?php echo $text_all_affiliate_names; ?>', noneSelected:'<?php echo $text_all_affiliate_names; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });

    $('#filter_affiliate_email').multiSelect({
      selectAllText:'<?php echo $text_all_affiliate_emails; ?>', noneSelected:'<?php echo $text_all_affiliate_emails; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });
	
    $('#filter_coupon_name').multiSelect({
      selectAllText:'<?php echo $text_all_coupon_names; ?>', noneSelected:'<?php echo $text_all_coupon_names; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });
	
    $('#filter_coupon_code').multiSelect({
      selectAllText:'<?php echo $text_all_coupon_codes; ?>', noneSelected:'<?php echo $text_all_coupon_codes; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });
	
    $('#filter_voucher_code').multiSelect({
      selectAllText:'<?php echo $text_all_voucher_codes; ?>', noneSelected:'<?php echo $text_all_voucher_codes; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });
	
    $('#export_xls_prod').click(function() {
      $('#export').val('1') ; // export_xls_prod: #1
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_xls_prod_order_list').click(function() {
      $('#export').val('2') ; // export_xls_prod_order_list: #2
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	

    $('#export_xls_prod_customer_list').click(function() {
      $('#export').val('3') ; // export_xls_prod_customer_list: #3
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	

    $('#export_xls_manu').click(function() {
      $('#export').val('4') ; // export_xls_manu: #4
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	

    $('#export_xls_manu_product_list').click(function() {
      $('#export').val('5') ; // export_xls_manu_product_list: #5
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	

    $('#export_xls_cat').click(function() {
      $('#export').val('6') ; // export_xls_cat: #6
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	

    $('#export_xls_cat_product_list').click(function() {
      $('#export').val('7') ; // export_xls_cat_product_list: #7
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_html_prod').click(function() {
      $('#export').val('8') ; // export_html_prod: #8
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_html_prod_order_list').click(function() {
      $('#export').val('9') ; // export_html_prod_order_list: #9
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
		
    $('#export_html_prod_customer_list').click(function() {
      $('#export').val('10') ; // export_html_prod_customer_list: #10
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_html_manu').click(function() {
      $('#export').val('11') ; // export_html_manu: #11
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	

    $('#export_html_manu_product_list').click(function() {
      $('#export').val('12') ; // export_html_manu_product_list: #12
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });		

    $('#export_html_cat').click(function() {
      $('#export').val('13') ; // export_html_cat: #13
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	

    $('#export_html_cat_product_list').click(function() {
      $('#export').val('14') ; // export_html_cat_product_list: #14
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });
	
    $('#export_pdf_prod').click(function() {
      $('#export').val('15') ; // export_pdf_prod: #15
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_pdf_prod_order_list').click(function() {
      $('#export').val('16') ; // export_pdf_prod_order_list: #16
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_pdf_prod_customer_list').click(function() {
      $('#export').val('17') ; // export_pdf_prod_customer_list: #17
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_pdf_manu').click(function() {
      $('#export').val('18') ; // export_pdf_manu: #18
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_pdf_manu_product_list').click(function() {
      $('#export').val('19') ; // export_pdf_manu_product_list: #19
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });		

    $('#export_pdf_cat').click(function() {
      $('#export').val('20') ; // export_pdf_cat: #20
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_pdf_cat_product_list').click(function() {
      $('#export').val('21') ; // export_pdf_cat_product_list: #21
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
});
</script>  
<script type="text/javascript"><!--
$('input[name=\'filter_customer_name\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_customer_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.cust_name,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_customer_name\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_customer_email\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_customer_email=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.cust_email,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_customer_email\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_customer_telephone\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_customer_telephone=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.cust_telephone,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_customer_telephone\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_payment_company\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_company=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.payment_company,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_payment_company\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_payment_address\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_address=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.payment_address,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_payment_address\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_payment_city\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_city=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.payment_city,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_payment_city\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_payment_zone\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_zone=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.payment_zone,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_payment_zone\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_payment_postcode\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_postcode=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.payment_postcode,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_payment_postcode\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_payment_country\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_country=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.payment_country,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_payment_country\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_shipping_company\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_company=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.shipping_company,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_shipping_company\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_shipping_address\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_address=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.shipping_address,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_shipping_address\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_shipping_city\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_city=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.shipping_city,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_shipping_city\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_shipping_zone\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_zone=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.shipping_zone,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_shipping_zone\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_shipping_postcode\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_postcode=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.shipping_postcode,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_shipping_postcode\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_shipping_country\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_country=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.shipping_country,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_shipping_country\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_sku\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/product_autocomplete&token=<?php echo $token; ?>&filter_sku=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.prod_sku,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_sku\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_product_id\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/product_autocomplete&token=<?php echo $token; ?>&filter_product_id=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.prod_name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_product_id\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_model\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_product_profit/product_autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.prod_model,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_model\']').val(ui.item.label);
						
		return false;
	}
});
//--></script> 
<?php if ($products) { ?>    
<?php if (($filter_range != 'all_time' && ($filter_group == 'year' or $filter_group == 'quarter' or $filter_group == 'month')) or ($filter_range == 'all_time' && $filter_group == 'year')) { ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript"><!--
	google.load('visualization', '1', {packages: ['corechart']});
      google.setOnLoadCallback(drawChart);      
	  function drawChart() {        
	  	var data = google.visualization.arrayToDataTable([
			<?php if ($sales && $filter_group == 'month') {
				echo "['" . $column_month . "','". $column_orders . "','" . $column_customers . "','" . $column_products . "'],";
					foreach ($sales as $key => $sale) {
						if (count($sales)==($key+1)) {
							echo "['" . $sale['gyear_month'] . "',". $sale['gorders'] . ",". $sale['gcustomers'] . ",". $sale['gproducts'] . "]";
						} else {
							echo "['" . $sale['gyear_month'] . "',". $sale['gorders'] . ",". $sale['gcustomers'] . ",". $sale['gproducts'] . "],";
						}
					}	
			} elseif ($sales && $filter_group == 'quarter') {
				echo "['" . $column_quarter . "','". $column_orders . "','" . $column_customers . "','" . $column_products . "'],";
					foreach ($sales as $key => $sale) {
						if (count($sales)==($key+1)) {
							echo "['" . $sale['gyear_quarter'] . "',". $sale['gorders'] . ",". $sale['gcustomers'] . ",". $sale['gproducts'] . "]";
						} else {
							echo "['" . $sale['gyear_quarter'] . "',". $sale['gorders'] . ",". $sale['gcustomers'] . ",". $sale['gproducts'] . "],";
						}
					}	
			} elseif ($sales && $filter_group == 'year') {
				echo "['" . $column_year . "','". $column_orders . "','" . $column_customers . "','" . $column_products . "'],";
					foreach ($sales as $key => $sale) {
						if (count($sales)==($key+1)) {
							echo "['" . $sale['gyear'] . "',". $sale['gorders'] . ",". $sale['gcustomers'] . ",". $sale['gproducts'] . "]";
						} else {
							echo "['" . $sale['gyear'] . "',". $sale['gorders'] . ",". $sale['gcustomers'] . ",". $sale['gproducts'] . "],";
						}
					}	
			} 
			;?>
		]);

        var options = {
			width: 630,	
			height: 266,  
			colors: ['#edc240', '#9dc7e8', '#CCCCCC'],
			chartArea: {left: 30, top: 30, width: "75%", height: "70%"},
			pointSize: '4',
			legend: {position: 'right', alignment: 'start', textStyle: {color: '#666666', fontSize: 12}}
		};

			var chart = new google.visualization.LineChart(document.getElementById('chart1_div'));
			chart.draw(data, options);
	}
//--></script>
<script type="text/javascript"><!--
	google.load('visualization', '1', {packages: ['corechart']});
	function drawVisualization() {
   		var data = google.visualization.arrayToDataTable([
			<?php if ($sales && $filter_group == 'month') {
				echo "['" . $column_month . "','". $column_total . "','" . $column_prod_costs . "','" . $column_prod_profit . "'],";
					foreach ($sales as $key => $sale) {
						if (count($sales)==($key+1)) {
							echo "['" . $sale['gyear_month'] . "',". $sale['gsales'] . ",". $sale['gcosts'] . ",". $sale['gprofit'] . "]";
						} else {
							echo "['" . $sale['gyear_month'] . "',". $sale['gsales'] . ",". $sale['gcosts'] . ",". $sale['gprofit'] . "],";
						}
					}	
			} elseif ($sales && $filter_group == 'quarter') {
				echo "['" . $column_quarter . "','". $column_total . "','" . $column_prod_costs . "','" . $column_prod_profit . "'],";
					foreach ($sales as $key => $sale) {
						if (count($sales)==($key+1)) {
							echo "['" . $sale['gyear_quarter'] . "',". $sale['gsales'] . ",". $sale['gcosts'] . ",". $sale['gprofit'] . "]";
						} else {
							echo "['" . $sale['gyear_quarter'] . "',". $sale['gsales'] . ",". $sale['gcosts'] . ",". $sale['gprofit'] . "],";
						}
					}	
			} elseif ($sales && $filter_group == 'year') {
				echo "['" . $column_year . "','". $column_total . "','" . $column_prod_costs . "','" . $column_prod_profit . "'],";
					foreach ($sales as $key => $sale) {
						if (count($sales)==($key+1)) {
							echo "['" . $sale['gyear'] . "',". $sale['gsales'] . ",". $sale['gcosts'] . ",". $sale['gprofit'] . "]";
						} else {
							echo "['" . $sale['gyear'] . "',". $sale['gsales'] . ",". $sale['gcosts'] . ",". $sale['gprofit'] . "],";
						}
					}	
			} 
			;?>
		]);

        var options = {
			width: 630,	
			height: 266,  
			colors: ['#b5e08b', '#ed9999', '#739cc3'],
			chartArea: {left: 45, top: 30, width: "74%", height: "70%"},
			legend: {position: 'right', alignment: 'start', textStyle: {color: '#666666', fontSize: 12}},				
			seriesType: "bars",
			series: {2: {type: "line", lineWidth: '3', pointSize: '5'}}
		};

			var chart = new google.visualization.ComboChart(document.getElementById('chart2_div'));
			chart.draw(data, options);
	}
	
	google.setOnLoadCallback(drawVisualization);
//--></script>
<?php } ?>
<?php } ?>
<?php echo $footer; ?>