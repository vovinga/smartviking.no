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
<form method="post" action="index.php?route=report/adv_customer_profit&token=<?php echo $token; ?>" id="report" name="report"> 
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
      <div style="padding-top: 7px; margin-right: 5px;"><?php echo $entry_customer_type; ?>
		<select name="filter_types" class="styled-select-type"> 
            <?php if (!$filter_types) { ?>        
            <option value="3" selected="selected"><?php echo $text_all_cust_types; ?></option> 
            <?php } else { ?>
            <option value="3"><?php echo $text_all_cust_types; ?></option> 
            <?php } ?>                      
            <?php if ($filter_types == '1') { ?>
            <option value="1" selected="selected"><?php echo $text_registered; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_registered; ?></option>
            <?php } ?>
            <?php if ($filter_types == '0') { ?>
            <option value="0" selected="selected"><?php echo $text_guest; ?></option>
            <?php } else { ?>
            <option value="0"><?php echo $text_guest; ?></option>
            <?php } ?>            
          </select>&nbsp;&nbsp; 
          <?php echo $entry_group; ?>
          <select name="filter_group" class="styled-select" <?php echo ($filter_details == 4) ? 'disabled="disabled"' : '' ?>> 
            <?php foreach ($groups as $groups) { ?>
            <?php if ($groups['value'] == $filter_group) { ?>
            <option value="<?php echo $groups['value']; ?>" selected="selected"><?php echo $groups['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $groups['value']; ?>"><?php echo $groups['text']; ?></option>
            <?php } ?>
            <?php } ?>
          	<?php if ($filter_details == 4) { ?>
			<option selected="selected">----</option>
			<?php } ?>
          </select>&nbsp;&nbsp;           
          <?php echo $entry_sort_by; ?>
		  <select name="filter_sort" class="styled-select" <?php echo ($filter_details == 4) ? 'disabled="disabled"' : '' ?>>
            <?php if ($filter_sort == 'date') { ?>
            <option value="date" selected="selected"><?php echo $column_date; ?></option>
            <?php } else { ?>
            <option value="date"><?php echo $column_date; ?></option>
            <?php } ?>          
            <?php if ($filter_sort == 'customer_id') { ?>
            <option value="customer_id" selected="selected"><?php echo $column_id; ?></option>
            <?php } else { ?>
            <option value="customer_id"><?php echo $column_id; ?></option>
            <?php } ?>
            <?php if ($filter_sort == 'cust_name') { ?>
            <option value="cust_name" selected="selected"><?php echo $column_customer; ?></option>
            <?php } else { ?>
            <option value="cust_name"><?php echo $column_customer; ?></option>
            <?php } ?>
            <?php if ($filter_sort == 'cust_company') { ?>
            <option value="cust_company" selected="selected"><?php echo $column_company; ?></option>
            <?php } else { ?>
            <option value="cust_company"><?php echo $column_company; ?></option>
            <?php } ?>            
            <?php if ($filter_sort == 'cust_email') { ?>
            <option value="cust_email" selected="selected"><?php echo $column_email; ?></option>
            <?php } else { ?>
            <option value="cust_email"><?php echo $column_email; ?></option>
            <?php } ?>
            <?php if ($filter_sort == 'cust_telephone') { ?>
            <option value="cust_telephone" selected="selected"><?php echo $column_telephone; ?></option>
            <?php } else { ?>
            <option value="cust_telephone"><?php echo $column_telephone; ?></option>
            <?php } ?>            
            <?php if ($filter_sort == 'cust_country') { ?>
            <option value="cust_country" selected="selected"><?php echo $column_country; ?></option>
            <?php } else { ?>
            <option value="cust_country"><?php echo $column_country; ?></option>
            <?php } ?>            
            <?php if ($filter_sort == 'cust_group_reg') { ?>
            <option value="cust_group_reg" selected="selected"><?php echo $column_customer_group; ?></option>
            <?php } else { ?>
            <option value="cust_group_reg"><?php echo $column_customer_group; ?></option>
            <?php } ?>
            <?php if ($filter_sort == 'cust_status') { ?>
            <option value="cust_status" selected="selected"><?php echo $column_status; ?></option>
            <?php } else { ?>
            <option value="cust_status"><?php echo $column_status; ?></option>
            <?php } ?>
            <?php if ($filter_sort == 'cust_ip') { ?>
            <option value="cust_ip" selected="selected"><?php echo $column_ip; ?></option>
            <?php } else { ?>
            <option value="cust_ip"><?php echo $column_ip; ?></option>
            <?php } ?>
            <?php if ($filter_sort == 'mostrecent') { ?>
            <option value="mostrecent" selected="selected"><?php echo $column_mostrecent; ?></option>
            <?php } else { ?>
            <option value="mostrecent"><?php echo $column_mostrecent; ?></option>
            <?php } ?>                                                                                                        
            <?php if (!$filter_sort or $filter_sort == 'orders') { ?>
            <option value="orders" selected="selected"><?php echo $column_orders; ?></option>
            <?php } else { ?>
            <option value="orders"><?php echo $column_orders; ?></option>
            <?php } ?>
            <?php if ($filter_sort == 'products') { ?>
            <option value="products" selected="selected"><?php echo $column_products; ?></option>
            <?php } else { ?>
            <option value="products"><?php echo $column_products; ?></option>
            <?php } ?>
            <?php if ($filter_sort == 'total') { ?>
            <option value="total" selected="selected"><?php echo $column_value; ?></option>
            <?php } else { ?>
            <option value="total"><?php echo $column_value; ?></option>
            <?php } ?>            
            <?php if ($filter_sort == 'sales') { ?>
            <option value="sales" selected="selected"><?php echo $column_total_sales; ?></option>
            <?php } else { ?>
            <option value="sales"><?php echo $column_total_sales; ?></option>
            <?php } ?>            
            <?php if ($filter_sort == 'costs') { ?>
            <option value="costs" selected="selected"><?php echo $column_total_costs; ?></option>
            <?php } else { ?>
            <option value="costs"><?php echo $column_total_costs; ?></option>
            <?php } ?>              
            <?php if ($filter_sort == 'profit') { ?>
            <option value="profit" selected="selected"><?php echo $column_total_profit; ?></option>
            <?php } else { ?>
            <option value="profit"><?php echo $column_total_profit; ?></option>
            <?php } ?>
            <?php if ($filter_sort == 'profit_margin') { ?>
            <option value="profit_margin" selected="selected"><?php echo $column_profit_margin; ?></option>
            <?php } else { ?>
            <option value="profit_margin"><?php echo $column_profit_margin; ?></option>
            <?php } ?>
          	<?php if ($filter_details == 4) { ?>
			<option selected="selected">----</option>
			<?php } ?>
          </select>&nbsp;&nbsp; 
          <?php echo $entry_show_details; ?>
		  <select name="filter_details" class="styled-select">                      
            <?php if (!$filter_details or $filter_details == '0') { ?>
            <option value="0" selected="selected"><?php echo $text_no_details; ?></option>
            <?php } else { ?>
            <option value="0"><?php echo $text_no_details; ?></option>
            <?php } ?>
            <?php if ($filter_details == '1') { ?>
            <option value="1" selected="selected"><?php echo $text_order_list; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_order_list; ?></option>
            <?php } ?>
            <?php if ($filter_details == '2') { ?>
            <option value="2" selected="selected"><?php echo $text_product_list; ?></option>
            <?php } else { ?>
            <option value="2"><?php echo $text_product_list; ?></option>
            <?php } ?>  
            <?php if ($filter_details == '3') { ?>
            <option value="3" selected="selected"><?php echo $text_address_list; ?></option>
            <?php } else { ?>
            <option value="3"><?php echo $text_address_list; ?></option>
            <?php } ?>               
            <?php if ($filter_details == '4') { ?>
            <option value="4" selected="selected"><?php echo $text_all_details; ?></option>
            <?php } else { ?>
            <option value="4"><?php echo $text_all_details; ?></option>
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
          </select>&nbsp; <a id="button" onclick="$('#report').submit();" class="cbutton" style="background:#069;"><span><?php echo $button_filter; ?></span></a>&nbsp;<?php if ($customers) { ?><?php if (($filter_range != 'all_time' && ($filter_group == 'year' or $filter_group == 'quarter' or $filter_group == 'month')) or ($filter_range == 'all_time' && $filter_group == 'year')) { ?><a id="show_tab_chart" class="cbutton" style="background:#930;"><span><?php echo $button_chart; ?></span></a><?php } ?><?php } ?>&nbsp;<a id="show_tab_export" class="cbutton" style="background:#699;"><span><?php echo $button_export; ?></span></a>&nbsp;<a id="settings" class="cbutton" style="background:#666;"><span><?php echo $button_settings; ?></span></a></div>
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
							return '<em><a href="index.php?route=report/adv_customer_profit&token=<?php echo $token; ?>#' + this.value + '">' + this.value + '</a></em>';
						return '<span class="current">' + this.value + '</span>';

					case 'next':

						if (this.active) {
							return '<a href="index.php?route=report/adv_customer_profit&token=<?php echo $token; ?>#' + this.value + '" class="next">Next &gt;</a>';
						}
						return '';						

					case 'prev':

						if (this.active) {
							return '<a href="index.php?route=report/adv_customer_profit&token=<?php echo $token; ?>#' + this.value + '" class="prev">&lt; Previous</a>';
						}	
						return '';						

					case 'first':

						if (this.active) {
							return '<?php echo $text_pagin_page; ?> ' + this.page + ' <?php echo $text_pagin_of; ?> ' + this.pages + '&nbsp;&nbsp;<a href="index.php?route=report/adv_customer_profit&token=<?php echo $token; ?>#' + this.value + '" class="first">|&lt;</a>';
						}	
						return '<?php echo $text_pagin_page; ?> ' + this.page + ' <?php echo $text_pagin_of; ?> ' + this.pages + '&nbsp;&nbsp';
							
					case 'last':

						if (this.active) {
							return '<a href="index.php?route=report/adv_customer_profit&token=<?php echo $token; ?>#' + this.value + '" class="prev">&gt;|</a>&nbsp;&nbsp;(' + cont.length + ' <?php echo $text_pagin_results; ?>)';
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
			<?php if ($customers) {
					foreach ($customers as $key => $customer) {
						echo "$('#'+this.id+'_" . $customer['order_id'] . "_title').toggle($(this).is(':checked')); ";
						echo "$('#'+this.id+'_" . $customer['order_id'] . "').toggle($(this).is(':checked')); ";						
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
    <table width="100%" cellspacing="0" cellpadding="0" style="background:#FFEFDF; border:1px solid #CCCCCC; padding:3px;"> 
    <tr><td width="1%" nowrap="nowrap">&nbsp;<?php echo $text_formula_setting1; ?> &nbsp;</td>
    <td width="1%" nowrap="nowrap"><select name="adv_profit_reports_formula_cop1">
    <?php if ($adv_profit_reports_formula_cop1) { ?>
	<option value="1" selected="selected"><?php echo $text_yes; ?></option>
	<option value="0"><?php echo $text_no; ?></option>
	<?php } else { ?>
	<option value="1"><?php echo $text_yes; ?></option>
	<option value="0" selected="selected"><?php echo $text_no; ?></option>
	<?php } ?>
	</select></td>
    <td rowspan="3" align="center"><a onclick="$('#report').submit();" class="cbutton" style="background:#069;"><span><?php echo $button_save; ?></span></a>&nbsp;<a onclick="location = '<?php echo $settings; ?>'" class="cbutton" style="background:#666;"><span><?php echo $button_module_settings; ?></span></a></td></tr> 
    <tr><td width="1%" nowrap="nowrap">&nbsp;<?php echo $text_formula_setting2; ?> &nbsp;</td>
    <td width="1%" nowrap="nowrap"><select name="adv_profit_reports_formula_cop2">
    <?php if ($adv_profit_reports_formula_cop2) { ?>
	<option value="1" selected="selected"><?php echo $text_yes; ?></option>
	<option value="0"><?php echo $text_no; ?></option>
	<?php } else { ?>
	<option value="1"><?php echo $text_yes; ?></option>
	<option value="0" selected="selected"><?php echo $text_no; ?></option>
	<?php } ?>
	</select></td></tr> 
    <tr><td width="1%" nowrap="nowrap">&nbsp;<?php echo $text_formula_setting3; ?> &nbsp;</td>
    <td width="1%" nowrap="nowrap"><select name="adv_profit_reports_formula_cop3">
    <?php if ($adv_profit_reports_formula_cop3) { ?>
	<option value="1" selected="selected"><?php echo $text_yes; ?></option>
	<option value="0"><?php echo $text_no; ?></option>
	<?php } else { ?>
	<option value="1"><?php echo $text_yes; ?></option>
	<option value="0" selected="selected"><?php echo $text_no; ?></option>
	<?php } ?>
	</select></td></tr> 
    </table>
    </td></tr> 
    <tr><td><br />
      &nbsp;<span style="font-size:14px; font-weight:bold;"><?php echo $text_filtering_options; ?></span><br />        
      <table width="100%" cellspacing="0" cellpadding="3" style="background:#E7EFEF; border:1px solid #DDDDDD; margin-top:3px;">
        <tr>
          <td>       
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1" checked="checked" type="checkbox"><label for="cop1"><?php echo substr($entry_status,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop2" checked="checked" type="checkbox"><label for="cop2"><?php echo substr($entry_store,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop3" checked="checked" type="checkbox"><label for="cop3"><?php echo substr($entry_currency,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop4" checked="checked" type="checkbox"><label for="cop4"><?php echo substr($entry_tax,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop5" checked="checked" type="checkbox"><label for="cop5"><?php echo substr($entry_customer_group,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop6" checked="checked" type="checkbox"><label for="cop6"><?php echo substr($entry_customer_status,0,-1); ?></label></div>	
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop7" checked="checked" type="checkbox"><label for="cop7"><?php echo substr($entry_customer_name,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop8a" checked="checked" type="checkbox"><label for="cop8a"><?php echo substr($entry_customer_email,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop8b" checked="checked" type="checkbox"><label for="cop8b"><?php echo substr($entry_customer_telephone,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop10" checked="checked" type="checkbox"><label for="cop10"><?php echo substr($entry_ip,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop17a" checked="checked" type="checkbox"><label for="cop17a"><?php echo substr($entry_payment_company,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop17b" checked="checked" type="checkbox"><label for="cop17b"><?php echo substr($entry_payment_address,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop17c" checked="checked" type="checkbox"><label for="cop17c"><?php echo substr($entry_payment_city,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop17d" checked="checked" type="checkbox"><label for="cop17d"><?php echo substr($entry_payment_zone,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop17e" checked="checked" type="checkbox"><label for="cop17e"><?php echo substr($entry_payment_postcode,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop17f" checked="checked" type="checkbox"><label for="cop17f"><?php echo substr($entry_payment_country,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop14" checked="checked" type="checkbox"><label for="cop13"><?php echo substr($entry_payment_method,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop16a" checked="checked" type="checkbox"><label for="cop16a"><?php echo substr($entry_shipping_company,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop16b" checked="checked" type="checkbox"><label for="cop16b"><?php echo substr($entry_shipping_address,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop16c" checked="checked" type="checkbox"><label for="cop16c"><?php echo substr($entry_shipping_city,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop16d" checked="checked" type="checkbox"><label for="cop16d"><?php echo substr($entry_shipping_zone,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop16e" checked="checked" type="checkbox"><label for="cop16e"><?php echo substr($entry_shipping_postcode,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop16f" checked="checked" type="checkbox"><label for="cop16f"><?php echo substr($entry_shipping_country,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop13" checked="checked" type="checkbox"><label for="cop14"><?php echo substr($entry_shipping_method,0,-1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop9d" checked="checked" type="checkbox"><label for="cop9d"><?php echo substr($entry_category,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop9e" checked="checked" type="checkbox"><label for="cop9e"><?php echo substr($entry_manufacturer,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop9a" checked="checked" type="checkbox"><label for="cop9a"><?php echo substr($entry_sku,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop9b" checked="checked" type="checkbox"><label for="cop9b"><?php echo substr($entry_product,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop9c" checked="checked" type="checkbox"><label for="cop9c"><?php echo substr($entry_model,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop10" checked="checked" type="checkbox"><label for="cop10"><?php echo substr($entry_option,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop18" checked="checked" type="checkbox"><label for="cop18"><?php echo substr($entry_attributes,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop11" checked="checked" type="checkbox"><label for="cop11"><?php echo substr($entry_location,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop12a" checked="checked" type="checkbox"><label for="cop12a"><?php echo substr($entry_affiliate_name,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop12b" checked="checked" type="checkbox"><label for="cop12b"><?php echo substr($entry_affiliate_email,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop15a" checked="checked" type="checkbox"><label for="cop15a"><?php echo substr($entry_coupon_name,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop15b" checked="checked" type="checkbox"><label for="cop15b"><?php echo substr($entry_coupon_code,0,-1); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop19" checked="checked" type="checkbox"><label for="cop19"><?php echo substr($entry_voucher_code,0,-1); ?></label></div>
          </td>                                                                                                                        
        </tr>
      </table><br />
      &nbsp;<span style="font-size:14px; font-weight:bold;"><?php echo $text_column_settings; ?></span><br />  
      <table width="100%" cellspacing="0" cellpadding="3" style="background:#E5E5E5; border:1px solid #DDDDDD; margin-top:3px;">
        <tr>
          <td>
            &nbsp;<span style="font-size:11px; font-weight:bold;"><?php echo $text_mv_columns; ?></span><br />      
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop20" name="cop20" checked="checked" type="checkbox"><label for="cop20"><?php echo $column_id; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop21" name="cop21" checked="checked" type="checkbox"><label for="cop21"><?php echo $column_customer; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop22" name="cop22" checked="checked" type="checkbox"><label for="cop22"><?php echo $column_email; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop35" name="cop35" checked="checked" type="checkbox"><label for="cop35"><?php echo $column_telephone; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop34" name="cop34" checked="checked" type="checkbox"><label for="cop34"><?php echo $column_country; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop23" name="cop23" checked="checked" type="checkbox"><label for="cop23"><?php echo $column_customer_group; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop24" name="cop24" checked="checked" type="checkbox"><label for="cop24"><?php echo $column_status; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop25" name="cop25" checked="checked" type="checkbox"><label for="cop25"><?php echo $column_ip; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop26" name="cop26" checked="checked" type="checkbox"><label for="cop26"><?php echo $column_mostrecent; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop27" name="cop27" checked="checked" type="checkbox"><label for="cop27"><?php echo $column_orders; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop28" name="cop28" checked="checked" type="checkbox"><label for="cop28"><?php echo $column_products; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop30" name="cop30" checked="checked" type="checkbox"><label for="cop30"><?php echo $column_value; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop29" name="cop29" checked="checked" type="checkbox"><label for="cop29"><?php echo $column_total_sales; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop31" name="cop31" checked="checked" type="checkbox"><label for="cop31"><?php echo $column_total_costs; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop32" name="cop32" checked="checked" type="checkbox"><label for="cop32"><?php echo $column_total_profit; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop33" name="cop33" checked="checked" type="checkbox"><label for="cop33"><?php echo $column_total_profit; ?> [%]</label></div>
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
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop40" name="cop40" checked="checked" type="checkbox"><label for="cop40"><?php echo $column_order_order_id; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop41" name="cop41" checked="checked" type="checkbox"><label for="cop41"><?php echo $column_order_date_added; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop42" name="cop42" checked="checked" type="checkbox"><label for="cop42"><?php echo $column_order_inv_no; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop43" name="cop43" checked="checked" type="checkbox"><label for="cop43"><?php echo $column_order_customer; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop44" name="cop44" checked="checked" type="checkbox"><label for="cop44"><?php echo $column_order_email; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop45" name="cop45" checked="checked" type="checkbox"><label for="cop45"><?php echo $column_order_customer_group; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop46" name="cop46" checked="checked" type="checkbox"><label for="cop46"><?php echo $column_order_shipping_method; ?></label></div>	
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop47" name="cop47" checked="checked" type="checkbox"><label for="cop47"><?php echo $column_order_payment_method; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop48" name="cop48" checked="checked" type="checkbox"><label for="cop48"><?php echo $column_order_status; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop49" name="cop49" checked="checked" type="checkbox"><label for="cop49"><?php echo $column_order_store; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop50" name="cop50" checked="checked" type="checkbox"><label for="cop50"><?php echo $column_order_currency; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop51" name="cop51" checked="checked" type="checkbox"><label for="cop51"><?php echo $column_order_quantity; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop52" name="cop52" checked="checked" type="checkbox"><label for="cop52"><?php echo $column_order_sub_total; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop54" name="cop54" checked="checked" type="checkbox"><label for="cop54"><?php echo $column_order_shipping; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop55" name="cop55" checked="checked" type="checkbox"><label for="cop55"><?php echo $column_order_tax; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop56" name="cop56" checked="checked" type="checkbox"><label for="cop56"><?php echo $column_order_value; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop53" name="cop53" checked="checked" type="checkbox"><label for="cop53"><?php echo $column_order_sales; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop57" name="cop57" checked="checked" type="checkbox"><label for="cop57"><?php echo $column_order_costs; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop58" name="cop58" checked="checked" type="checkbox"><label for="cop58"><?php echo $column_order_profit; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop59" name="cop59" checked="checked" type="checkbox"><label for="cop59"><?php echo $column_order_profit; ?> [%]</label></div>
          </td>                                                                                                                        
        </tr>
		<tr><td>
		<span style="font-size:11px; color:#3C0;">* <?php echo $text_export_note; ?> - <strong><?php echo strip_tags($text_export_order_list); ?></strong></span>  
		</td></tr>          
      </table>
      <table width="100%" cellspacing="0" cellpadding="3" style="background:#F0F0F0; border:1px solid #DDDDDD; margin-top:3px;">
        <tr>
          <td>
            &nbsp;<span style="font-size:11px; font-weight:bold;"><?php echo $text_pl_columns; ?></span><br />     
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop60" name="cop60" checked="checked" type="checkbox"><label for="cop60"><?php echo $column_prod_order_id; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop61" name="cop61" checked="checked" type="checkbox"><label for="cop61"><?php echo $column_prod_date_added; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop62" name="cop62" checked="checked" type="checkbox"><label for="cop62"><?php echo $column_prod_inv_no; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop63" name="cop63" checked="checked" type="checkbox"><label for="cop63"><?php echo $column_prod_id; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop64" name="cop64" checked="checked" type="checkbox"><label for="cop64"><?php echo $column_prod_sku; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop65" name="cop65" checked="checked" type="checkbox"><label for="cop65"><?php echo $column_prod_model; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop66" name="cop66" checked="checked" type="checkbox"><label for="cop66"><?php echo $column_prod_name; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop67" name="cop67" checked="checked" type="checkbox"><label for="cop67"><?php echo $column_prod_option; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop77" name="cop77" checked="checked" type="checkbox"><label for="cop77"><?php echo $column_prod_attributes; ?></label></div>            
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop68" name="cop68" checked="checked" type="checkbox"><label for="cop68"><?php echo $column_prod_manu; ?></label></div> 
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop79" name="cop79" checked="checked" type="checkbox"><label for="cop79"><?php echo $column_prod_category; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop69" name="cop69" checked="checked" type="checkbox"><label for="cop69"><?php echo $column_prod_currency; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop70" name="cop70" checked="checked" type="checkbox"><label for="cop70"><?php echo $column_prod_price; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop71" name="cop71" checked="checked" type="checkbox"><label for="cop71"><?php echo $column_prod_quantity; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop73" name="cop73" checked="checked" type="checkbox"><label for="cop73"><?php echo $column_prod_tax; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop72" name="cop72" checked="checked" type="checkbox"><label for="cop72"><?php echo $column_prod_total; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop74" name="cop74" checked="checked" type="checkbox"><label for="cop74"><?php echo $column_prod_costs; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop75" name="cop75" checked="checked" type="checkbox"><label for="cop75"><?php echo $column_prod_profit; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop76" name="cop76" checked="checked" type="checkbox"><label for="cop76"><?php echo $column_prod_profit; ?> [%]</label></div>
          </td>                                                                                                                        
        </tr>
		<tr><td>
		<span style="font-size:11px; color:#3C0;">* <?php echo $text_export_note; ?> - <strong><?php echo strip_tags($text_export_product_list); ?></strong></span>  
		</td></tr>          
      </table>
      <table width="100%" cellspacing="0" cellpadding="3" style="background:#F0F0F0; border:1px solid #DDDDDD; margin-top:3px;">
        <tr>
          <td>
            &nbsp;<span style="font-size:11px; font-weight:bold;"><?php echo $text_al_columns; ?></span><br />       
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop84" name="cop84" checked="checked" type="checkbox"><label for="cop84"><?php echo strip_tags($column_billing_name); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop85" name="cop85" checked="checked" type="checkbox"><label for="cop85"><?php echo strip_tags($column_billing_company); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop86" name="cop86" checked="checked" type="checkbox"><label for="cop86"><?php echo strip_tags($column_billing_address_1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop87" name="cop87" checked="checked" type="checkbox"><label for="cop87"><?php echo strip_tags($column_billing_address_2); ?></label></div>			
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop88" name="cop88" checked="checked" type="checkbox"><label for="cop88"><?php echo strip_tags($column_billing_city); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop89" name="cop89" checked="checked" type="checkbox"><label for="cop89"><?php echo strip_tags($column_billing_zone); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop90" name="cop90" checked="checked" type="checkbox"><label for="cop90"><?php echo strip_tags($column_billing_postcode); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop91" name="cop91" checked="checked" type="checkbox"><label for="cop91"><?php echo strip_tags($column_billing_country); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop93" name="cop93" checked="checked" type="checkbox"><label for="cop93"><?php echo strip_tags($column_shipping_name); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop94" name="cop94" checked="checked" type="checkbox"><label for="cop94"><?php echo strip_tags($column_shipping_company); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop95" name="cop95" checked="checked" type="checkbox"><label for="cop95"><?php echo strip_tags($column_shipping_address_1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop96" name="cop96" checked="checked" type="checkbox"><label for="cop96"><?php echo strip_tags($column_shipping_address_2); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop97" name="cop97" checked="checked" type="checkbox"><label for="cop97"><?php echo strip_tags($column_shipping_city); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop98" name="cop98" checked="checked" type="checkbox"><label for="cop98"><?php echo strip_tags($column_shipping_zone); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop99" name="cop99" checked="checked" type="checkbox"><label for="cop99"><?php echo strip_tags($column_shipping_postcode); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop100" name="cop100" checked="checked" type="checkbox"><label for="cop100"><?php echo strip_tags($column_shipping_country); ?></label></div>
          </td>                                                                                                                        
        </tr>
		<tr><td>
		<span style="font-size:11px; color:#3C0;">* <?php echo $text_export_note; ?> - <strong><?php echo strip_tags($text_export_address_list); ?></strong></span>  
		</td></tr>         
      </table>
      <table width="100%" cellspacing="0" cellpadding="3" style="background:#F0F0F0; border:1px solid #DDDDDD; margin-top:3px;">
        <tr>
          <td>
            &nbsp;<span style="font-size:11px; font-weight:bold;"><?php echo $text_all_columns; ?></span><br />            
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1001" name="cop1001" checked="checked" type="checkbox"><label for="cop1001"><?php echo $column_order_customer; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1002" name="cop1002" checked="checked" type="checkbox"><label for="cop1002"><?php echo $column_order_email; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1003" name="cop1003" checked="checked" type="checkbox"><label for="cop1003"><?php echo $column_order_customer_group; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1004" name="cop1004" checked="checked" type="checkbox"><label for="cop1004"><?php echo $column_prod_id; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1005" name="cop1005" checked="checked" type="checkbox"><label for="cop1005"><?php echo $column_prod_sku; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1006" name="cop1006" checked="checked" type="checkbox"><label for="cop1006"><?php echo $column_prod_model; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1007" name="cop1007" checked="checked" type="checkbox"><label for="cop1007"><?php echo $column_prod_name; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1008" name="cop1008" checked="checked" type="checkbox"><label for="cop1008"><?php echo $column_prod_option; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1009" name="cop1009" checked="checked" type="checkbox"><label for="cop1009"><?php echo $column_prod_attributes; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1010" name="cop1010" checked="checked" type="checkbox"><label for="cop1010"><?php echo $column_prod_manu; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1011" name="cop1011" checked="checked" type="checkbox"><label for="cop1011"><?php echo $column_prod_category; ?></label></div>            
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1012" name="cop1012" checked="checked" type="checkbox"><label for="cop1012"><?php echo $column_prod_currency; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1062" name="cop1062" checked="checked" type="checkbox"><label for="cop1062"><?php echo $column_order_quantity; ?></label></div>            
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1013" name="cop1013" checked="checked" type="checkbox"><label for="cop1013"><?php echo $column_prod_price; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1014" name="cop1014" checked="checked" type="checkbox"><label for="cop1014"><?php echo $column_prod_quantity; ?></label></div>            
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1015" name="cop1015" checked="checked" type="checkbox"><label for="cop1015"><?php echo $column_prod_tax; ?></label></div>            
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1016" name="cop1016" checked="checked" type="checkbox"><label for="cop1016"><?php echo $column_prod_total; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1017" name="cop1017" checked="checked" type="checkbox"><label for="cop1017"><?php echo $column_prod_costs; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1018" name="cop1018" checked="checked" type="checkbox"><label for="cop1018"><?php echo $column_prod_profit; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1019" name="cop1019" checked="checked" type="checkbox"><label for="cop1019"><?php echo $column_prod_profit; ?> [%]</label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1020" name="cop1020" checked="checked" type="checkbox"><label for="cop1020"><?php echo $column_order_sub_total; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1023" name="cop1023" checked="checked" type="checkbox"><label for="cop1023"><?php echo $column_order_shipping; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1027" name="cop1027" checked="checked" type="checkbox"><label for="cop1027"><?php echo $column_order_tax; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1031" name="cop1031" checked="checked" type="checkbox"><label for="cop1031"><?php echo $column_order_value; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1032" name="cop1032" checked="checked" type="checkbox"><label for="cop1032"><?php echo $column_order_sales; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1037" name="cop1037" checked="checked" type="checkbox"><label for="cop1037"><?php echo $column_order_costs; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1038" name="cop1038" checked="checked" type="checkbox"><label for="cop1038"><?php echo $column_order_profit; ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1039" name="cop1039" checked="checked" type="checkbox"><label for="cop1039"><?php echo $column_order_profit; ?> [%]</label></div>            
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1040" name="cop1040" checked="checked" type="checkbox"><label for="cop1040"><?php echo $column_order_shipping_method; ?></label></div>            
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1041" name="cop1041" checked="checked" type="checkbox"><label for="cop1041"><?php echo $column_order_payment_method; ?></label></div>            
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1042" name="cop1042" checked="checked" type="checkbox"><label for="cop1042"><?php echo $column_order_status; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1043" name="cop1043" checked="checked" type="checkbox"><label for="cop1043"><?php echo $column_order_store; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1044" name="cop1044" checked="checked" type="checkbox"><label for="cop1044"><?php echo $column_customer_cust_id; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1045" name="cop1045" checked="checked" type="checkbox"><label for="cop1045"><?php echo strip_tags($column_billing_name); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1046" name="cop1046" checked="checked" type="checkbox"><label for="cop1046"><?php echo strip_tags($column_billing_company); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1047" name="cop1047" checked="checked" type="checkbox"><label for="cop1047"><?php echo strip_tags($column_billing_address_1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1048" name="cop1048" checked="checked" type="checkbox"><label for="cop1048"><?php echo strip_tags($column_billing_address_2); ?></label></div>			
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1049" name="cop1049" checked="checked" type="checkbox"><label for="cop1049"><?php echo strip_tags($column_billing_city); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1050" name="cop1050" checked="checked" type="checkbox"><label for="cop1050"><?php echo strip_tags($column_billing_zone); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1051" name="cop1051" checked="checked" type="checkbox"><label for="cop1051"><?php echo strip_tags($column_billing_postcode); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1052" name="cop1052" checked="checked" type="checkbox"><label for="cop1052"><?php echo strip_tags($column_billing_country); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1053" name="cop1053" checked="checked" type="checkbox"><label for="cop1053"><?php echo $column_customer_telephone; ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1054" name="cop1054" checked="checked" type="checkbox"><label for="cop1054"><?php echo strip_tags($column_shipping_name); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1055" name="cop1055" checked="checked" type="checkbox"><label for="cop1055"><?php echo strip_tags($column_shipping_company); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1056" name="cop1056" checked="checked" type="checkbox"><label for="cop1056"><?php echo strip_tags($column_shipping_address_1); ?></label></div>
			<div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1057" name="cop1057" checked="checked" type="checkbox"><label for="cop1057"><?php echo strip_tags($column_shipping_address_2); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1058" name="cop1058" checked="checked" type="checkbox"><label for="cop1058"><?php echo strip_tags($column_shipping_city); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1059" name="cop1059" checked="checked" type="checkbox"><label for="cop1059"><?php echo strip_tags($column_shipping_zone); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1060" name="cop1060" checked="checked" type="checkbox"><label for="cop1060"><?php echo strip_tags($column_shipping_postcode); ?></label></div>
            <div style="float:left; padding-right:5px; margin:1px; border:thin dotted #666;"><input id="cop1061" name="cop1061" checked="checked" type="checkbox"><label for="cop1061"><?php echo strip_tags($column_shipping_country); ?></label></div>          
          </td>                                                                                                                        
        </tr>
		<tr><td>
		<span style="font-size:11px; color:#3C0;">* <?php echo $text_export_note; ?> - <strong><?php echo strip_tags($text_export_all_details); ?></strong></span>  
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
	 <table width="225" border="0" cellspacing="0" cellpadding="0" height="49%" style="background:#C6D7D7; border:1px solid #CCCCCC; padding:5px; margin-top:5px;" id="cop1_filter">
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
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop2_filter">
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
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop3_filter">
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
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop4_filter">
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
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop5_filter">
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
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop6_filter">
        <tr><td><?php echo $entry_customer_status; ?><br />
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
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop7_filter">
        <tr><td> <?php echo $entry_customer_name; ?><br />
        <input type="text" name="filter_customer_name" value="<?php echo $filter_customer_name; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
		</td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>  
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop8a_filter">
        <tr><td> <?php echo $entry_customer_email; ?><br />
        <input type="text" name="filter_customer_email" value="<?php echo $filter_customer_email; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>  
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop8b_filter">
        <tr><td> <?php echo $entry_customer_telephone; ?><br />
        <input type="text" name="filter_customer_telephone" value="<?php echo $filter_customer_telephone; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop10_filter">
        <tr><td> <?php echo $entry_ip; ?><br />
        <input type="text" name="filter_ip" value="<?php echo $filter_ip; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>       
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop17a_filter">
        <tr><td> <?php echo $entry_payment_company; ?><br />
        <input type="text" name="filter_payment_company" value="<?php echo $filter_payment_company; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop17b_filter">
        <tr><td> <?php echo $entry_payment_address; ?><br />
        <input type="text" name="filter_payment_address" value="<?php echo $filter_payment_address; ?>" size="25" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop17c_filter">
        <tr><td> <?php echo $entry_payment_city; ?><br />
        <input type="text" name="filter_payment_city" value="<?php echo $filter_payment_city; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
		</td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop17d_filter">
        <tr><td> <?php echo $entry_payment_zone; ?><br />
        <input type="text" name="filter_payment_zone" value="<?php echo $filter_payment_zone; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
		</td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>  
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop17e_filter">
        <tr><td> <?php echo $entry_payment_postcode; ?><br />
        <input type="text" name="filter_payment_postcode" value="<?php echo $filter_payment_postcode; ?>" size="15" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop17f_filter">
        <tr><td> <?php echo $entry_payment_country; ?><br />
        <input type="text" name="filter_payment_country" value="<?php echo $filter_payment_country; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop13_filter">
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
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop16a_filter">
        <tr><td> <?php echo $entry_shipping_company; ?><br />
        <input type="text" name="filter_shipping_company" value="<?php echo $filter_shipping_company; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop16b_filter">
        <tr><td> <?php echo $entry_shipping_address; ?><br />
        <input type="text" name="filter_shipping_address" value="<?php echo $filter_shipping_address; ?>" size="25" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop16c_filter">
        <tr><td> <?php echo $entry_shipping_city; ?><br />
        <input type="text" name="filter_shipping_city" value="<?php echo $filter_shipping_city; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop16d_filter">
        <tr><td> <?php echo $entry_shipping_zone; ?><br />
        <input type="text" name="filter_shipping_zone" value="<?php echo $filter_shipping_zone; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>                     
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop16e_filter">
        <tr><td> <?php echo $entry_shipping_postcode; ?><br />
        <input type="text" name="filter_shipping_postcode" value="<?php echo $filter_shipping_postcode; ?>" size="15" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop16f_filter">
        <tr><td> <?php echo $entry_shipping_country; ?><br />
        <input type="text" name="filter_shipping_country" value="<?php echo $filter_shipping_country; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>           
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop14_filter">
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
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop9d_filter">
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
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop9e_filter">
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
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop9a_filter">
        <tr><td> <?php echo $entry_sku; ?><br />
        <input type="text" name="filter_sku" value="<?php echo $filter_sku; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop9b_filter">
        <tr><td> <?php echo $entry_product; ?><br />
        <input type="text" name="filter_product_id" value="<?php echo $filter_product_id; ?>" size="40" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table> 
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop9c_filter">
        <tr><td> <?php echo $entry_model; ?><br />
        <input type="text" name="filter_model" value="<?php echo $filter_model; ?>" size="20" style="margin-top:4px; height:16px; border:solid 1px #BBB; color:#F90;" onclick="this.value = '';">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>  
	  <table cellpadding="0" cellspacing="0" style="float:left;" id="cop10_filter">
        <tr><td><?php echo $entry_option; ?><br />
          <span <?php echo (!$filter_option) ? '' : 'class="vtip"' ?> title="<?php foreach ($product_options as $product_option) { ?><?php if (isset($filter_option[$product_option['options']])) { ?><?php echo $product_option['option_name']; ?>: <?php echo $product_option['option_value']; ?><br /><?php } ?><?php } ?>">        
          <select name="filter_option" id="filter_option" multiple="multiple" size="1">
            <?php foreach ($product_options as $product_option) { ?>
            <?php if (isset($filter_option[$product_option['options']])) { ?>              
            <option value="<?php echo $product_option['options']; ?>" selected="selected"><?php echo $product_option['option_name']; ?>: <?php echo $product_option['option_value']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $product_option['options']; ?>"><?php echo $product_option['option_name']; ?>: <?php echo $product_option['option_value']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></span></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td></td>
	  </tr></table>  
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop18_filter">
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
      <table cellpadding="0" cellspacing="0" style="float:left;" id="cop11_filter">
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
	  <table cellpadding="0" cellspacing="0" style="float:left;" id="cop12a_filter">
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
	  <table cellpadding="0" cellspacing="0" style="float:left;" id="cop12b_filter">
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
	  <table cellpadding="0" cellspacing="0" style="float:left;" id="cop15a_filter">
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
	  <table cellpadding="0" cellspacing="0" style="float:left;" id="cop15b_filter">
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
	  <table cellpadding="0" cellspacing="0" style="float:left;" id="cop19_filter">
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
          <td width="10%">&nbsp;</td>
          <td width="16%" align="center" nowrap="nowrap"><span id="export_xls" class="export_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" title="XLS" /></span><span id="export_html" class="export_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" title="HTML" /></span><span id="export_pdf" class="export_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" title="PDF" /></span></td>
          <td width="16%" align="center" nowrap="nowrap"><span id="export_xls_order_list" class="export_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" title="XLS" /></span><span id="export_html_order_list" class="export_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" title="HTML" /></span><span id="export_pdf_order_list" class="export_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" title="PDF" /></span></td>
          <td width="16%" align="center" nowrap="nowrap"><span id="export_xls_product_list" class="export_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" title="XLS" /></span><span id="export_html_product_list" class="export_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" title="HTML" /></span><span id="export_pdf_product_list" class="export_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" title="PDF" /></span></td>
          <td width="16%" align="center" nowrap="nowrap"><span id="export_xls_address_list" class="export_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" title="XLS" /></span><span id="export_html_address_list" class="export_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" title="HTML" /></span><span id="export_pdf_address_list" class="export_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" title="PDF" /></span></td>
          <td width="16%" align="center" nowrap="nowrap"><span id="export_xls_all_details" class="export_item"><img src="view/image/adv_reports/XLS.png" width="48" height="48" border="0" title="XLS" /></span><span id="export_html_all_details" class="export_item"><img src="view/image/adv_reports/HTML.png" width="48" height="48" border="0" title="HTML" /></span><span id="export_pdf_all_details" class="export_item"><img src="view/image/adv_reports/PDF.png" width="48" height="48" border="0" title="PDF" /></span></td>
          <td width="10%">&nbsp;</td>
        </tr>
        <tr>
          <td width="10%">&nbsp;</td>
          <td width="16%" align="center" nowrap="nowrap"><?php echo $text_export_no_details; ?></td>
          <td width="16%" align="center" nowrap="nowrap"><?php echo $text_export_order_list; ?></td>
          <td width="16%" align="center" nowrap="nowrap"><?php echo $text_export_product_list; ?></td>
          <td width="16%" align="center" nowrap="nowrap"><?php echo $text_export_address_list; ?></td>
          <td width="16%" align="center" nowrap="nowrap"><?php echo $text_export_all_details; ?></td>
          <td width="10%">&nbsp;</td>                                                                                                                       
        </tr>
        <tr>
          <td colspan="6">*<span style="font-size:10px"><?php echo $text_export_notice1; ?> <a href="view/template/module/adv_reports/adv_requirements_limitations.htm" id="adv_export_limit"><strong><?php echo $text_export_limit; ?></strong></a> <?php echo $text_export_notice2; ?></span></td>
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
<?php if ($customers) { ?>
<?php if (($filter_range != 'all_time' && $filter_details != '4' && ($filter_group == 'year' or $filter_group == 'quarter' or $filter_group == 'month')) or ($filter_range == 'all_time' && $filter_group == 'year')) { ?>      
<script type="text/javascript">$(function(){ 
$('#show_tab_chart').click(function() {
		$('#tab_chart').slideToggle('slow');
	});
});
</script>  
    <div id="tab_chart">
      <table align="center" cellspacing="0" cellpadding="3">
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
<?php if ($filter_details == 4) { ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">    
	<tr><td> 
	<?php if ($customers) { ?>
	<?php foreach ($customers as $customer) { ?>
    <?php if ($customer['product_pidc']) { ?>    
		<table class="list_detail" id="element" style="border-bottom:2px solid #999; border-top:2px solid #999;">
		<thead>
		<tr>
          <td class="left" nowrap="nowrap"><?php echo $column_order_order_id; ?></td>        
          <td class="left" nowrap="nowrap"><?php echo $column_order_date_added; ?></td>
          <td class="left" nowrap="nowrap"><?php echo $column_order_inv_no; ?></td>                  
          <td id="cop1001_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_order_customer; ?></td>
          <td id="cop1002_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_order_email; ?></td>
          <td id="cop1003_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_order_customer_group; ?></td>
          <td id="cop1040_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_order_shipping_method; ?></td>
          <td id="cop1041_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_order_payment_method; ?></td>          
          <td id="cop1042_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_order_status; ?></td>
          <td id="cop1043_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_order_store; ?></td>
          <td id="cop1012_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_order_currency; ?></td>
          <td id="cop1062_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_order_quantity; ?></td>  
          <td id="cop1020_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_order_sub_total; ?></td>                               
          <td id="cop1023_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_order_shipping; ?></td>         
          <td id="cop1027_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_order_tax; ?></td>
          <td id="cop1031_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_order_value; ?></td>  
          <td id="cop1032_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_order_sales; ?></td>                    
          <td id="cop1037_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_order_costs; ?></td> 
          <td id="cop1038_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_order_profit; ?></td>
          <td id="cop1039_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_profit_margin; ?></td>        
		</tr>
		</thead>
        <tbody>
		<tr bgcolor="#FFFFFF">
          <td class="left" nowrap="nowrap"><a><?php echo $customer['order_ord_id']; ?></a></td>        
          <td class="left" nowrap="nowrap"><?php echo $customer['order_order_date']; ?></td>
          <td class="left" nowrap="nowrap"><?php echo $customer['order_inv_no']; ?></td>
          <td id="cop1001_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_name']; ?></td>
          <td id="cop1002_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_email']; ?></td>
          <td id="cop1003_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_group']; ?></td>
          <td id="cop1040_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_shipping_method']; ?></td>
          <td id="cop1041_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_payment_method']; ?></td>          
          <td id="cop1042_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_status']; ?></td>
          <td id="cop1043_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_store']; ?></td> 
          <td id="cop1012_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['order_currency']; ?></td>          
          <td id="cop1062_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['order_products']; ?></td> 
          <td id="cop1020_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['order_sub_total']; ?></td>                    
          <td id="cop1023_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['order_shipping']; ?></td>           
          <td id="cop1027_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['order_tax']; ?></td>                              
          <td id="cop1031_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['order_value']; ?></td>
          <td id="cop1032_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#DCFFB9;"><?php echo $customer['order_sales']; ?></td>           
          <td id="cop1037_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#ffd7d7;">-<?php echo $customer['order_costs']; ?></td>
          <td id="cop1038_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#c4d9ee; font-weight:bold;"><?php echo $customer['order_profit']; ?></td> 
          <td id="cop1039_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#c4d9ee; font-weight:bold;"><?php echo $customer['order_profit_margin_percent']; ?>%</td>      
		</tr>  
		<tr>
		<td colspan="3"></td> 
		<td colspan="17">
		  <table class="list_detail">
          <thead>
          <tr>
          <td id="cop1004_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_prod_id; ?></td>                                          
		  <td id="cop1005_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_prod_sku; ?></td>
		  <td id="cop1006_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_prod_model; ?></td>            
          <td id="cop1007_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_prod_name; ?></td> 
          <td id="cop1008_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_prod_option; ?></td>           
          <td id="cop1009_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_prod_attributes; ?></td>                      
          <td id="cop1010_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_prod_manu; ?></td> 
          <td id="cop1011_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_prod_category; ?></td>           
          <td id="cop1013_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_prod_price; ?></td>                     
          <td id="cop1014_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_prod_quantity; ?></td>
          <td id="cop1015_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_prod_tax; ?></td>           
          <td id="cop1016_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_prod_total; ?></td>        
          <td id="cop1017_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_prod_costs; ?></td>           
          <td id="cop1018_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_prod_profit; ?></td>
          <td id="cop1019_<?php echo $customer['order_id']; ?>_title" class="right"><?php echo $column_profit_margin; ?></td>  
          </tr>
          </thead>
          <tr bgcolor="#FFFFFF">
          <td id="cop1004_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_pid']; ?></td>  
          <td id="cop1005_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_sku']; ?></td>
          <td id="cop1006_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_model']; ?></td>                 
          <td id="cop1007_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_name']; ?></td> 
          <td id="cop1008_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_option']; ?></td>            
          <td id="cop1009_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_attributes']; ?></td>                    
          <td id="cop1010_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_manu']; ?></td> 
          <td id="cop1011_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_category']; ?></td> 
          <td id="cop1013_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['product_price']; ?></td> 
          <td id="cop1014_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['product_quantity']; ?></td>
          <td id="cop1015_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['product_tax']; ?></td>            
          <td id="cop1016_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#DCFFB9;"><?php echo $customer['product_total']; ?></td>        
          <td id="cop1017_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#ffd7d7;">-<?php echo $customer['product_costs']; ?></td>         
          <td id="cop1018_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#c4d9ee; font-weight:bold;"><?php echo $customer['product_profit']; ?></td>
          <td id="cop1019_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#c4d9ee; font-weight:bold;"><?php echo $customer['product_profit_margin_percent']; ?>%</td>  
          </tr>                  
	      </table>
          <table class="list_detail">
          <thead>
          <tr>
          <td id="cop1044_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_customer_cust_id; ?></td>           
          <td id="cop1045_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_billing_name; ?></td> 
          <td id="cop1046_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_billing_company; ?></td> 
          <td id="cop1047_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_billing_address_1; ?></td> 
          <td id="cop1048_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_billing_address_2; ?></td> 
          <td id="cop1049_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_billing_city; ?></td>
          <td id="cop1050_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_billing_zone; ?></td> 
          <td id="cop1051_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_billing_postcode; ?></td>
          <td id="cop1052_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_billing_country; ?></td>
          <td id="cop1053_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_customer_telephone; ?></td>
          <td id="cop1054_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_shipping_name; ?></td> 
          <td id="cop1055_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_shipping_company; ?></td> 
          <td id="cop1056_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_shipping_address_1; ?></td> 
          <td id="cop1057_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_shipping_address_2; ?></td> 
          <td id="cop1058_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_shipping_city; ?></td>
          <td id="cop1059_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_shipping_zone; ?></td> 
          <td id="cop1060_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_shipping_postcode; ?></td>
          <td id="cop1061_<?php echo $customer['order_id']; ?>_title" class="left"><?php echo $column_shipping_country; ?></td>    
          </tr>
          </thead>
          <tr bgcolor="#FFFFFF">
          <td id="cop1044_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['customer_cust_id']; ?></td>             
          <td id="cop1045_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_name']; ?></td>         
          <td id="cop1046_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_company']; ?></td> 
          <td id="cop1047_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_address_1']; ?></td> 
          <td id="cop1048_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_address_2']; ?></td> 
          <td id="cop1049_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_city']; ?></td> 
          <td id="cop1050_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_zone']; ?></td> 
          <td id="cop1051_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_postcode']; ?></td>                    
          <td id="cop1052_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_country']; ?></td>
          <td id="cop1053_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['customer_telephone']; ?></td> 
          <td id="cop1054_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_name']; ?></td>         
          <td id="cop1055_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_company']; ?></td> 
          <td id="cop1056_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_address_1']; ?></td> 
          <td id="cop1057_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_address_2']; ?></td> 
          <td id="cop1058_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_city']; ?></td> 
          <td id="cop1059_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_zone']; ?></td> 
          <td id="cop1060_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_postcode']; ?></td>                    
          <td id="cop1061_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_country']; ?></td>  
          </tr>                  
	      </table>            
		</td>               
		</tr> 
        </tbody>
		</table>                
	<?php } ?>
	<?php } ?>  
    </td></tr>
    </table>        
	<?php } else { ?>
		<table width="100%">    
		<tr>
		<td align="center"><?php echo $text_no_results; ?></td>
		</tr>
        </table>          
	<?php } ?>  
<br />     
<?php } ?>
<?php if ($filter_details != '4') { ?>
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
          <td class="left" nowrap="nowrap"><?php echo $column_order_order_id; ?></td>
          <td class="left" nowrap="nowrap"><?php echo $column_order_date_added; ?></td>                     
		  <?php } else { ?>    
          <td class="left" width="70" nowrap="nowrap"><?php echo $column_date_start; ?></td>
          <td class="left" width="70" nowrap="nowrap"><?php echo $column_date_end; ?></td>           
		  <?php } ?> 
          <td id="cop20_title" class="right"><?php echo $column_id; ?></td>
          <td id="cop21_title" class="left"><?php echo $column_customer; ?> / <?php echo $column_company; ?></td>         
          <td id="cop22_title" class="left"><?php echo $column_email; ?></td>
          <td id="cop35_title" class="left"><?php echo $column_telephone; ?></td>          
          <td id="cop34_title" class="left"><?php echo $column_country; ?></td>           
          <td id="cop23_title" class="left"><?php echo $column_customer_group; ?></td> 
          <td id="cop24_title" class="left"><?php echo $column_status; ?></td>  
          <td id="cop25_title" class="left"><?php echo $column_ip; ?></td>           
          <td id="cop26_title" class="left"><?php echo $column_mostrecent; ?></td>          
          <td id="cop27_title" class="right"><?php echo $column_orders; ?></td> 
          <td id="cop28_title" class="right"><?php echo $column_products; ?></td>                          
          <td id="cop30_title" class="right"><?php echo $column_value; ?></td>
          <td id="cop29_title" class="right"><?php echo $column_total_sales; ?></td>           
          <td id="cop31_title" class="right"><?php echo $column_total_costs; ?></td>            
          <td id="cop32_title" class="right"><?php echo $column_total_profit; ?></td>
          <td id="cop33_title" class="right"><?php echo $column_profit_margin; ?></td>          
          <?php if ($filter_details == 1 OR $filter_details == 2 OR $filter_details == 3) { ?><td class="right" nowrap="nowrap"><?php echo $column_action; ?></td><?php } ?>
          </tr>
      	  </thead>
          <?php if ($customers) { ?>
          <?php foreach ($customers as $customer) { ?>
      	  <tbody id="element">
          <tr <?php echo ($filter_details == 1 OR $filter_details == 2 OR $filter_details == 3) ? 'style="cursor:pointer;" title="' . $text_detail . '"' : '' ?> id="show_details_<?php echo $customer['order_id']; ?>">
		  <?php if ($filter_group == 'year') { ?>           
          <td class="left" colspan="2" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $customer['year']; ?></td>
		  <?php } elseif ($filter_group == 'quarter') { ?> 
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $customer['year']; ?></td>
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $customer['quarter']; ?></td>  
		  <?php } elseif ($filter_group == 'month') { ?> 
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $customer['year']; ?></td>
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $customer['month']; ?></td>
		  <?php } elseif ($filter_group == 'day') { ?> 
          <td class="left" colspan="2" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $customer['date_start']; ?></td>    
		  <?php } elseif ($filter_group == 'order') { ?> 
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $customer['order_id']; ?></td>
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $customer['date_start']; ?></td>
		  <?php } else { ?>    
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $customer['date_start']; ?></td>
          <td class="left" nowrap="nowrap" style="background-color:#F0F0F0;"><?php echo $customer['date_end']; ?></td>         
		  <?php } ?>  
	  	  <td id="cop20_<?php echo $customer['order_id']; ?>" class="right">
          <?php if ($customer['customer_id'] == 0) { ?>
          <?php echo $text_guest; ?>          
          <?php } else { ?>
          <?php echo $customer['customer_id']; ?>
          <?php } ?></td>           
	  	  <td id="cop21_<?php echo $customer['order_id']; ?>" class="left">
          <?php if ($customer['customer_id'] == 0) { ?>
          <?php echo $customer['cust_name']; ?>
          <br /><?php echo $customer['cust_company']; ?>
          <?php } else { ?>
          <a href="<?php echo $customer['href']; ?>"><?php echo $customer['cust_name']; ?></a>
          <br /><?php echo $customer['cust_company']; ?>
          <?php } ?></td>
      	  <td id="cop22_<?php echo $customer['order_id']; ?>" class="left"><?php echo $customer['cust_email']; ?></td> 
      	  <td id="cop35_<?php echo $customer['order_id']; ?>" class="left"><?php echo $customer['cust_telephone']; ?></td>           
      	  <td id="cop34_<?php echo $customer['order_id']; ?>" class="left"><?php echo $customer['cust_country']; ?></td>           
	  	  <td id="cop23_<?php echo $customer['order_id']; ?>" class="left">
          <?php if ($customer['customer_id'] == 0) { ?>
          <?php echo $customer['cust_group_guest']; ?>         
          <?php } else { ?>
          <?php echo $customer['cust_group_reg']; ?>
          <?php } ?></td>                                
          <td id="cop24_<?php echo $customer['order_id']; ?>" class="left"><?php if (!$customer['customer_id'] == 0) { ?><?php echo $customer['cust_status']; ?><?php } ?></td>
      	  <td id="cop25_<?php echo $customer['order_id']; ?>" class="left"><?php echo $customer['cust_ip']; ?></td>            
          <td id="cop26_<?php echo $customer['order_id']; ?>" class="left"><?php echo $customer['mostrecent']; ?></td>          
          <td id="cop27_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['orders']; ?></td>
          <td id="cop28_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['products']; ?></td>                 
          <td id="cop30_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['value']; ?></td>
          <td id="cop29_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#DCFFB9;"><?php echo $customer['total_sales']; ?></td>             
          <td id="cop31_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#ffd7d7;"><?php echo $customer['total_costs']; ?></td>          
          <td id="cop32_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#c4d9ee; font-weight:bold;"><?php echo $customer['total_profit']; ?></td>
          <td id="cop33_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#c4d9ee; font-weight:bold;"><?php echo $customer['profit_margin_percent']; ?></td>          
          <?php if ($filter_details == 1 OR $filter_details == 2 OR $filter_details == 3) { ?><td class="right" nowrap="nowrap">[ <a><?php echo $text_detail; ?></a> ]</td><?php } ?>
          </tr>
<tr class="detail">         
<td colspan="19" class="center">
<?php if ($filter_details == 1) { ?> 
<script type="text/javascript">$(function(){ 
$('#show_details_<?php echo $customer["order_id"]; ?>').click(function() {
		$('#tab_details_<?php echo $customer["order_id"]; ?>').slideToggle('slow');
	});
});
</script>
<div id="tab_details_<?php echo $customer['order_id']; ?>" style="display:none">
    <table class="list_detail">
      <thead>
        <tr>
          <td id="cop40_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_order_id; ?></td>        
          <td id="cop41_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_date_added; ?></td>
          <td id="cop42_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_inv_no; ?></td>                  
          <td id="cop43_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_customer; ?></td>
          <td id="cop44_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_email; ?></td>
          <td id="cop45_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_customer_group; ?></td>
          <td id="cop46_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_shipping_method; ?></td>
          <td id="cop47_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_payment_method; ?></td>          
          <td id="cop48_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_status; ?></td>
          <td id="cop49_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_order_store; ?></td>
          <td id="cop50_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_currency; ?></td>
          <td id="cop51_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_quantity; ?></td>  
          <td id="cop52_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_sub_total; ?></td>                               
          <td id="cop54_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_shipping; ?></td>         
          <td id="cop55_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_tax; ?></td>
          <td id="cop56_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_value; ?></td>  
          <td id="cop53_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_sales; ?></td>                    
          <td id="cop57_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_costs; ?></td> 
          <td id="cop58_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_order_profit; ?></td>
          <td id="cop59_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_profit_margin; ?></td>         
        </tr>
      </thead>
        <tr bgcolor="#FFFFFF">
          <td id="cop40_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><a><?php echo $customer['order_ord_id']; ?></a></td>        
          <td id="cop41_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_order_date']; ?></td>
          <td id="cop42_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_inv_no']; ?></td>
          <td id="cop43_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_name']; ?></td>
          <td id="cop44_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_email']; ?></td>
          <td id="cop45_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_group']; ?></td>
          <td id="cop46_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_shipping_method']; ?></td>
          <td id="cop47_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_payment_method']; ?></td>          
          <td id="cop48_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_status']; ?></td>
          <td id="cop49_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['order_store']; ?></td> 
          <td id="cop50_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['order_currency']; ?></td>          
          <td id="cop51_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['order_products']; ?></td> 
          <td id="cop52_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['order_sub_total']; ?></td>                    
          <td id="cop54_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['order_shipping']; ?></td>           
          <td id="cop55_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['order_tax']; ?></td>                              
          <td id="cop56_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['order_value']; ?></td>
          <td id="cop53_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#DCFFB9;"><?php echo $customer['order_sales']; ?></td>           
          <td id="cop57_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#ffd7d7;">-<?php echo $customer['order_costs']; ?></td>
          <td id="cop58_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#c4d9ee; font-weight:bold;"><?php echo $customer['order_profit']; ?></td> 
          <td id="cop59_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#c4d9ee; font-weight:bold;"><?php echo $customer['order_profit_margin_percent']; ?>%</td>      
         </tr>
    </table>
</div>  
<?php } ?> 
<?php if ($filter_details == 2) { ?>
<script type="text/javascript">$(function(){ 
$('#show_details_<?php echo $customer["order_id"]; ?>').click(function() {
		$('#tab_details_<?php echo $customer["order_id"]; ?>').slideToggle('slow');
	});
});
</script>
<div id="tab_details_<?php echo $customer['order_id']; ?>" style="display:none">
    <table class="list_detail">
      <thead>
        <tr>
          <td id="cop60_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_order_id; ?></td>  
          <td id="cop61_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_date_added; ?></td>
          <td id="cop62_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_inv_no; ?></td> 
          <td id="cop63_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_id; ?></td>                                          
          <td id="cop64_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_sku; ?></td>
          <td id="cop65_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_model; ?></td>            
          <td id="cop66_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_name; ?></td> 
          <td id="cop67_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_option; ?></td>           
          <td id="cop77_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_attributes; ?></td>                      
          <td id="cop68_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_manu; ?></td> 
          <td id="cop79_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_prod_category; ?></td>           
          <td id="cop69_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_prod_currency; ?></td>   
          <td id="cop70_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_prod_price; ?></td>                     
          <td id="cop71_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_prod_quantity; ?></td>           
          <td id="cop73_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_prod_tax; ?></td>                   
          <td id="cop72_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_prod_total; ?></td>                     
          <td id="cop74_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_prod_costs; ?></td>           
          <td id="cop75_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_prod_profit; ?></td>
          <td id="cop76_<?php echo $customer['order_id']; ?>_title" class="right" nowrap="nowrap"><?php echo $column_profit_margin; ?></td>  
        </tr>
      </thead>
        <tr bgcolor="#FFFFFF">
          <td id="cop60_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><a><?php echo $customer['product_ord_id']; ?></a></td>  
          <td id="cop61_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_order_date']; ?></td>
          <td id="cop62_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_inv_no']; ?></td>
          <td id="cop63_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_pid']; ?></td>  
          <td id="cop64_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_sku']; ?></td>
          <td id="cop65_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_model']; ?></td>                 
          <td id="cop66_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_name']; ?></td> 
          <td id="cop67_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_option']; ?></td>            
          <td id="cop77_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_attributes']; ?></td>                    
          <td id="cop68_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_manu']; ?></td> 
          <td id="cop79_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['product_category']; ?></td>           
          <td id="cop69_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['product_currency']; ?></td> 
          <td id="cop70_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['product_price']; ?></td> 
          <td id="cop71_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['product_quantity']; ?></td> 
          <td id="cop73_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap"><?php echo $customer['product_tax']; ?></td>            
          <td id="cop72_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#DCFFB9;"><?php echo $customer['product_total']; ?></td>                      
          <td id="cop74_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#ffd7d7;">-<?php echo $customer['product_costs']; ?></td>         
          <td id="cop75_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#c4d9ee; font-weight:bold;"><?php echo $customer['product_profit']; ?></td>
          <td id="cop76_<?php echo $customer['order_id']; ?>" class="right" nowrap="nowrap" style="background-color:#c4d9ee; font-weight:bold;"><?php echo $customer['product_profit_margin_percent']; ?>%</td>   
         </tr>       
    </table>
</div> 
<?php } ?>  
<?php if ($filter_details == 3) { ?>
<script type="text/javascript">$(function(){ 
$('#show_details_<?php echo $customer["order_id"]; ?>').click(function() {
		$('#tab_details_<?php echo $customer["order_id"]; ?>').slideToggle('slow');
	});
});
</script>
<div id="tab_details_<?php echo $customer['order_id']; ?>" style="display:none">
    <table class="list_detail">
      <thead>
        <tr>       
          <td id="cop84_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_name; ?></td> 
          <td id="cop85_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_company; ?></td> 
          <td id="cop86_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_address_1; ?></td> 
          <td id="cop87_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_address_2; ?></td> 
          <td id="cop88_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_city; ?></td>
          <td id="cop89_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_zone; ?></td> 
          <td id="cop90_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_postcode; ?></td>
          <td id="cop91_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_billing_country; ?></td>
          <td id="cop93_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_name; ?></td> 
          <td id="cop94_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_company; ?></td> 
          <td id="cop95_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_address_1; ?></td> 
          <td id="cop96_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_address_2; ?></td> 
          <td id="cop97_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_city; ?></td>
          <td id="cop98_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_zone; ?></td> 
          <td id="cop99_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_postcode; ?></td>
          <td id="cop100_<?php echo $customer['order_id']; ?>_title" class="left" nowrap="nowrap"><?php echo $column_shipping_country; ?></td>          
        </tr>
      </thead>
        <tr bgcolor="#FFFFFF">           
          <td id="cop84_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_name']; ?></td>         
          <td id="cop85_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_company']; ?></td> 
          <td id="cop86_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_address_1']; ?></td> 
          <td id="cop87_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_address_2']; ?></td> 
          <td id="cop88_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_city']; ?></td> 
          <td id="cop89_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_zone']; ?></td> 
          <td id="cop90_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_postcode']; ?></td>                    
          <td id="cop91_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['billing_country']; ?></td>
          <td id="cop93_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_name']; ?></td>         
          <td id="cop94_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_company']; ?></td> 
          <td id="cop95_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_address_1']; ?></td> 
          <td id="cop96_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_address_2']; ?></td> 
          <td id="cop97_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_city']; ?></td> 
          <td id="cop98_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_zone']; ?></td> 
          <td id="cop99_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_postcode']; ?></td>                    
          <td id="cop100_<?php echo $customer['order_id']; ?>" class="left" nowrap="nowrap"><?php echo $customer['shipping_country']; ?></td>          
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
          <td id="cop20_total" style="background-color:#DDDDDD;"></td>
          <td id="cop21_total" style="background-color:#DDDDDD;"></td>
          <td id="cop22_total" style="background-color:#DDDDDD;"></td>
          <td id="cop35_total" style="background-color:#DDDDDD;"></td>          
          <td id="cop34_total" style="background-color:#DDDDDD;"></td>
          <td id="cop23_total" style="background-color:#DDDDDD;"></td>
          <td id="cop24_total" style="background-color:#DDDDDD;"></td>
          <td id="cop25_total" style="background-color:#DDDDDD;"></td>
          <td id="cop26_total" style="background-color:#DDDDDD;"></td>            
          <td id="cop27_total" class="right" nowrap="nowrap" style="background-color:#E7EFEF; color:#003A88;"><strong><?php echo $customer['orders_total']; ?></strong></td>  
          <td id="cop28_total" class="right" nowrap="nowrap" style="background-color:#E7EFEF; color:#003A88;"><strong><?php echo $customer['products_total']; ?></strong></td> 
          <td id="cop30_total" class="right" nowrap="nowrap" style="background-color:#E7EFEF; color:#003A88;"><strong><?php echo $customer['value_total']; ?></strong></td>           
          <td id="cop29_total" class="right" nowrap="nowrap" style="background-color:#DCFFB9; color:#003A88;"><strong><?php echo $customer['sales_total']; ?></strong></td>           
          <td id="cop31_total" class="right" nowrap="nowrap" style="background-color:#ffd7d7; color:#003A88;"><strong><?php echo $customer['costs_total']; ?></strong></td>           
          <td id="cop32_total" class="right" nowrap="nowrap" style="background-color:#c4d9ee; color:#003A88;"><strong><?php echo $customer['profit_total']; ?></strong></td>
          <td id="cop33_total" class="right" nowrap="nowrap" style="background-color:#c4d9ee; color:#003A88;"><strong><?php echo $customer['profit_margin_total_percent']; ?></strong></td>          
          <?php if ($filter_details == 1 OR $filter_details == 2 OR $filter_details == 3) { ?><td></td><?php } ?>                  
          </tr>        
          <?php } else { ?>
          <tr>
          <td class="noresult" colspan="19"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
<?php } ?>      
    </div>
      <?php if ($customers) { ?>    
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

    $('#filter_status').multiSelect({
      selectAllText:'<?php echo $text_all_status; ?>', noneSelected:'<?php echo $text_all_status; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
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
      selectAllText:'<?php echo $text_all_options; ?>', noneSelected:'<?php echo $text_all_options; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
      });

    $('#filter_attribute').multiSelect({
      selectAllText:'<?php echo $text_all_attributes; ?>', noneSelected:'<?php echo $text_all_attributes; ?>', oneOrMoreSelected:'<?php echo $text_selected; ?>'
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
	
    $('#export_xls').click(function() {
      $('#export').val('1') ; // export_xls: #1
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_xls_order_list').click(function() {
      $('#export').val('2') ; // export_xls_order_list: #2
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	

    $('#export_xls_product_list').click(function() {
      $('#export').val('3') ; // export_xls_product_list: #3
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	

    $('#export_xls_address_list').click(function() {
      $('#export').val('4') ; // export_xls_address_list: #4
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_xls_all_details').click(function() {
      $('#export').val('5') ; // export_xls_all_details: #5
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_html').click(function() {
      $('#export').val('6') ; // export_html: #6
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_html_order_list').click(function() {
      $('#export').val('7') ; // export_html_order_list: #7
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_html_product_list').click(function() {
      $('#export').val('8') ; // export_html_product_list: #8
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });		

    $('#export_html_address_list').click(function() {
      $('#export').val('9') ; // export_html_address_list: #9
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_html_all_details').click(function() {
      $('#export').val('10') ; // export_html_all_details: #10
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_pdf').click(function() {
      $('#export').val('11') ; // export_pdf: #11
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_pdf_order_list').click(function() {
      $('#export').val('12') ; // export_pdf_order_list: #12
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_pdf_product_list').click(function() {
      $('#export').val('13') ; // export_pdf_product_list: #13
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });		

    $('#export_pdf_address_list').click(function() {
      $('#export').val('14') ; // export_pdf_address_list: #14
      $('#report').attr('target', '_blank'); // opening file in a new window
      $('#report').submit() ;
      $('#report').attr('target', '_self'); // preserve current form      
      $('#export').val('') ; 
      return(false)
    });	
	
    $('#export_pdf_all_details').click(function() {
      $('#export').val('15') ; // export_pdf_all_details: #15
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
			url: 'index.php?route=report/adv_customer_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_customer_name=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_customer_email=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_customer_telephone=' +  encodeURIComponent(request.term),
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

$('input[name=\'filter_ip\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_customer_profit/ip_autocomplete&token=<?php echo $token; ?>&filter_ip=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.cust_ip,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_ip\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_payment_company\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_customer_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_company=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_address=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_city=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_zone=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_postcode=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_country=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_company=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_address=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_city=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_zone=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_postcode=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_country=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/product_autocomplete&token=<?php echo $token; ?>&filter_sku=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/product_autocomplete&token=<?php echo $token; ?>&filter_product_id=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_customer_profit/product_autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request.term),
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
<?php if ($filter_details != '4') { ?> 
<?php if ($customers) { ?>    
<?php if (($filter_range != 'all_time' && $filter_details != '4' && ($filter_group == 'year' or $filter_group == 'quarter' or $filter_group == 'month')) or ($filter_range == 'all_time' && $filter_group == 'year')) { ?>
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
				echo "['" . $column_month . "','". $column_total_sales . "','" . $column_total_costs . "','" . $column_total_profit . "'],";
					foreach ($sales as $key => $sale) {
						if (count($sales)==($key+1)) {
							echo "['" . $sale['gyear_month'] . "',". $sale['gsales'] . ",". $sale['gcosts'] . ",". $sale['gnetprofit'] . "]";
						} else {
							echo "['" . $sale['gyear_month'] . "',". $sale['gsales'] . ",". $sale['gcosts'] . ",". $sale['gnetprofit'] . "],";
						}
					}	
			} elseif ($sales && $filter_group == 'quarter') {
				echo "['" . $column_quarter . "','". $column_total_sales . "','" . $column_total_costs . "','" . $column_total_profit . "'],";
					foreach ($sales as $key => $sale) {
						if (count($sales)==($key+1)) {
							echo "['" . $sale['gyear_quarter'] . "',". $sale['gsales'] . ",". $sale['gcosts'] . ",". $sale['gnetprofit'] . "]";
						} else {
							echo "['" . $sale['gyear_quarter'] . "',". $sale['gsales'] . ",". $sale['gcosts'] . ",". $sale['gnetprofit'] . "],";
						}
					}	
			} elseif ($sales && $filter_group == 'year') {
				echo "['" . $column_year . "','". $column_total_sales . "','" . $column_total_costs . "','" . $column_total_profit . "'],";
					foreach ($sales as $key => $sale) {
						if (count($sales)==($key+1)) {
							echo "['" . $sale['gyear'] . "',". $sale['gsales'] . ",". $sale['gcosts'] . ",". $sale['gnetprofit'] . "]";
						} else {
							echo "['" . $sale['gyear'] . "',". $sale['gsales'] . ",". $sale['gcosts'] . ",". $sale['gnetprofit'] . "],";
						}
					}	
			} 
			;?>
		]);

        var options = {
			width: 630,	
			height: 266,  
			colors: ['#b5e08b', '#ed9999', '#739cc3'],
			chartArea: {left: 45, top: 30, width: "75%", height: "70%"},
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
<?php } ?>
<?php echo $footer; ?>