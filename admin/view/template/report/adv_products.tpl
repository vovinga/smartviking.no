<?php echo $header; ?>
<div class="loader"></div>
<style type="text/css">
.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('view/image/adv_reports/page_loading.gif') 50% 50% no-repeat rgb(255,255,255);
}

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
	background-color: #F0F0F0;
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
.list_main .asc {
	padding-right: 15px;
	background: url('view/image/asc.png') right center no-repeat;
}
.list_main .desc {
	padding-right: 15px;
	background: url('view/image/desc.png') right center no-repeat;
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
	background-color: #f5f5f5;
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

.columns_setting {
	float: left; 
	margin: 1px;
	padding: 1px;
	padding-right: 3px; 	
	border: thin dotted #666;
    -moz-border-radius: 3px; 
    border-radius: 3px;	
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

.ui-dialog .ui-dialog-content {
  background: #f3f3f3 !important;
} 

.styled-select-type {
	background-color: #ffcc99;
	padding: 3px;
 	border: 1px solid #CCC;
    -moz-border-radius: 3px; 
    border-radius: 3px;
}
.styled-select {
	background-color: #fcfcfc;
	padding: 3px;
 	border: 1px solid #CCC;
    -moz-border-radius: 3px; 
    border-radius: 3px;
}
.styled-select-range {
	background-color: #fcfcfc;
 	border: 1px solid #CCC;
	padding: 2px;
	margin-top: 5px;
    -moz-border-radius: 3px; 
    border-radius: 3px;
}
.styled-input {
	margin-top: 4px;
	height: 17px;
	border: solid 1px #CCC;
	color: #F90;
	background-color: #fcfcfc;
    -moz-border-radius: 3px; 
    border-radius: 3px;	
}
.styled-input-range {
	margin-top: 4px;
	height: 17px;
	border: solid 1px #CCC;
	color: #F90;
    -moz-border-radius: 3px; 
    border-radius: 3px;	
}
</style>
<div id="content">
  <div class="box">
    <div class="heading">
      <h1><div style="float:left;"><img src="view/image/adv_reports/adv_report_icon.png" width="22" height="22" alt="" /><?php echo $heading_title; ?></div></h1><span style="float:right; padding-top:5px; padding-right:5px; font-size:11px; color:#666; text-align:right;"><?php echo $heading_version; ?></span></div>
      <div align="right" style="height: auto; background-color:#F0F0F0; border: 1px solid #DDDDDD; margin-top:5px;">
      <div style="padding-top: 5px; margin-right: 5px;"><a onclick="filter()" class="cbutton" style="background:#1e91cf;"><span><?php echo $button_filter; ?></span></a>&nbsp;<a id="export" class="cbutton" style="background:#8fbb6c;"><span><?php echo $button_export; ?></span></a>&nbsp;<?php if ($products) { ?><?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders' && $filter_details != 'all_details' && $filter_group == 'no_group') { ?><a id="show_tab_chart" class="cbutton" style="background:#ff6666;"><span><?php echo $button_chart; ?></span></a><?php } ?><?php } ?>&nbsp;<a id="settings" class="cbutton" style="background:#666;"><span><?php echo $button_settings; ?></span></a>&nbsp;<a href="http://www.opencartreports.com/documentation/pp/index.html" target="_blank" class="cbutton" style="background:#f38733;"><span><?php echo $button_documentation; ?></span></a></div>      
      <div style="padding-top:5px; padding-bottom:3px; margin-right:5px;"><strong><?php echo $entry_report; ?></strong>
          <select name="filter_report" id="filter_report" onchange="checkValidOptions(); filter();" class="styled-select-type"> 
              <?php foreach ($report as $report) { ?>
              <?php if ($report['value'] == $filter_report) { ?>
              <option value="<?php echo $report['value']; ?>" title="<?php echo $report['text']; ?>" selected="selected"><?php echo $report['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $report['value']; ?>" title="<?php echo $report['text']; ?>"><?php echo $report['text']; ?></option>
              <?php } ?>
              <?php } ?>
          </select>&nbsp;&nbsp;  
          <strong><?php echo $entry_show_details; ?></strong>
		  <select name="filter_details" id="filter_details" onchange="checkValidOptions();" class="styled-select" <?php echo ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') ? 'disabled="disabled"' : '' ?>>                      
			<?php foreach ($details as $details) { ?>
			<?php if ($details['value'] == $filter_details) { ?>
			<option value="<?php echo $details['value']; ?>" title="<?php echo $details['text']; ?>" selected="selected"><?php echo $details['text']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $details['value']; ?>" title="<?php echo $details['text']; ?>"><?php echo $details['text']; ?></option>
			<?php } ?> 
            <?php } ?>              
          	<?php if ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') { ?>
			<option value="" selected="selected"></option>
			<?php } ?>
          </select>&nbsp;&nbsp; 
      	  <strong><?php echo $entry_group; ?></strong>
          <select name="filter_group" id="filter_group" class="styled-select" <?php echo ($filter_details == 'all_details' or $filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') ? 'disabled="disabled"' : '' ?>> 
			<?php foreach ($group as $group) { ?>
			<?php if ($group['value'] == $filter_group) { ?>
			<option value="<?php echo $group['value']; ?>" selected="selected"><?php echo $group['text']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $group['value']; ?>"><?php echo $group['text']; ?></option>
			<?php } ?>
			<?php } ?> 
          	<?php if ($filter_details == 'all_details' or $filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') { ?>
			<option value="" selected="selected"></option>
			<?php } ?>               
          </select>&nbsp;&nbsp; 
          <strong><?php echo $entry_sort_by; ?></strong>
		  <select name="filter_sort" id="filter_sort" class="styled-select" <?php echo ($filter_details == 'all_details') ? 'disabled="disabled"' : '' ?>>
			<?php foreach ($sort as $sort) { ?>
			<?php if ($sort['value'] == $filter_sort) { ?>
			<option id="<?php echo $sort['value']; ?>" value="<?php echo $sort['value']; ?>" title="<?php echo $sort['text']; ?>" selected="selected"><?php echo $sort['text']; ?></option>

			<?php } else { ?>
			<option id="<?php echo $sort['value']; ?>" value="<?php echo $sort['value']; ?>" title="<?php echo $sort['text']; ?>"><?php echo $sort['text']; ?></option>
			<?php } ?> 
            <?php } ?>  
          	<?php if ($filter_details == 'all_details') { ?>
			<option value="report_type" selected="selected"></option>
			<?php } ?>            
          </select>&nbsp;&nbsp; 
          <strong><?php echo $entry_limit; ?></strong>
		  <select name="filter_limit" id="filter_limit" class="styled-select"> 
			<?php foreach ($limit as $limit) { ?>
			<?php if ($limit['value'] == $filter_limit) { ?>
			<option value="<?php echo $limit['value']; ?>" title="<?php echo $limit['text']; ?>" selected="selected"><?php echo $limit['text']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $limit['value']; ?>" title="<?php echo $limit['text']; ?>"><?php echo $limit['text']; ?></option>
			<?php } ?> 
            <?php } ?>                       
          </select></div>
    </div>
    <div class="content_report">
<div id="export_window" style="display:none">
<style type="text/css">
.ui-dialog-titlebar { background-color: #777; background-image: none; color: #FFF; }
</style>
	<h3><?php echo $text_export_options; ?></h3> 
    <table width="100%" cellspacing="0" cellpadding="0" style="background:#FFEFDF; border:1px solid #CCCCCC; padding:3px;"> 
    <tr>
    <td width="50%" nowrap="nowrap">&nbsp;<?php echo $text_report_type; ?> &nbsp;</td>
    <td nowrap="nowrap"><div id="report_to_export"><select id="report_type" name="report_type" class="styled-select-range">
    <?php foreach ($report_types as $report_type) { ?>                  
	<?php if ($report_type == $report_type['type']) { ?>
    <option value="<?php echo $report_type['type']; ?>" title="<?php echo $report_type['name']; ?>" selected="selected"><?php echo $report_type['name']; ?></option>
	<?php } else { ?>
	<option value="<?php echo $report_type['type']; ?>" title="<?php echo $report_type['name']; ?>"><?php echo $report_type['name']; ?></option>
	<?php } ?>
	<?php } ?>
	</select></div></td></tr> 
    <tr>
    <td width="50%" nowrap="nowrap">&nbsp;<span class="required">*</span> <?php echo $text_export_type; ?> &nbsp;</td>
    <td nowrap="nowrap"><div id="type_to_export"><select id="export_type" name="export_type" class="styled-select-range">
	<?php foreach ($export_types as $export_type) { ?>                
	<?php if ($export_type == $export_type['type']) { ?>
	<option value="<?php echo $export_type['type']; ?>" title="<?php echo $export_type['name']; ?>" selected="selected"><?php echo $export_type['name']; ?></option>
	<?php } else { ?>
	<option value="<?php echo $export_type['type']; ?>" title="<?php echo $export_type['name']; ?>"><?php echo $export_type['name']; ?></option>
	<?php } ?>
	<?php } ?>
	</select></div></td></tr> 
    </table>
    <table width="100%" cellspacing="0" cellpadding="0" style="background:#E6FFE6; border:1px solid #CCCCCC; padding:3px; margin-top:3px;"> 
    <tr>
    <td width="50%" nowrap="nowrap">&nbsp;<?php echo $text_export_logo_criteria; ?> &nbsp;</td>
    <td nowrap="nowrap"><select name="export_logo_criteria" class="styled-select-range">
	<?php if ($export_logo_criteria) { ?>
	<option value="1" title="<?php echo $text_yes; ?>" selected="selected"><?php echo $text_yes; ?></option>
	<option value="0" title="<?php echo $text_no; ?>"><?php echo $text_no; ?></option>
	<?php } else { ?>
	<option value="1" title="<?php echo $text_yes; ?>"><?php echo $text_yes; ?></option>
	<option value="0" title="<?php echo $text_no; ?>" selected="selected"><?php echo $text_no; ?></option>
	<?php } ?>
	</select></td></tr> 
    <tr>
    <td width="50%" nowrap="nowrap">&nbsp;<?php echo $text_export_csv_delimiter; ?> &nbsp;</td>
    <td nowrap="nowrap"><div id="csv_delimiter"><select id="export_csv_delimiter" name="export_csv_delimiter" class="styled-select-range">
	<?php foreach ($export_csv_delimiters as $export_csv_delimiter) { ?>                
	<?php if ($export_csv_delimiter == $export_csv_delimiter['type']) { ?>
	<option value="<?php echo $export_csv_delimiter['type']; ?>" title="<?php echo $export_csv_delimiter['name']; ?>" selected="selected"><?php echo $export_csv_delimiter['name']; ?></option>
	<?php } else { ?>
	<option value="<?php echo $export_csv_delimiter['type']; ?>" title="<?php echo $export_csv_delimiter['name']; ?>"><?php echo $export_csv_delimiter['name']; ?></option>
	<?php } ?>
	<?php } ?>
	</select></div> </td></tr>
	</table><br />
    <div><span class="required">*</span> <?php echo $text_export_notice1; ?> <a href="http://www.opencartreports.com/documentation/pp/index.html#req_limit" target="_blank"><strong><?php echo $text_export_limit; ?></strong></a> <?php echo $text_export_notice2; ?></div> 
	<div align="right" style="padding-top:15px; padding-bottom:15px;">
	<a id="close_export" class="cbutton" style="background:#FFF; color:#666;"><span><?php echo $button_close; ?></span></a>
	<a id="export_report" class="cbutton" style="background:#1e91cf;"><span><?php echo $button_export; ?></span></a>
	</div>
</div>   
<script type="text/javascript">
$("#export").click(function() {					  
    $("#export_window").dialog({
            title: '<?php echo $button_export; ?>',
            width: 900,
            height: 340,
			closeOnEscape: true,
            modal: true,			
    });
});
$("#close_export").click( function() {
    $("#export_window").dialog("close");
});
</script>  
<div id="settings_window" style="display:none">
<style type="text/css">
.ui-dialog-titlebar { background-color: #777; background-image: none; color: #FFF; }
</style>
	<h3><?php echo $text_local_settings; ?></h3> 
    <table width="100%" cellspacing="0" cellpadding="0" style="background:#E6FFE6; border:1px solid #CCCCCC; padding:3px;"> 
    <tr>
    <td width="50%" nowrap="nowrap">&nbsp;<?php echo $text_format_date; ?> &nbsp;</td>
    <td nowrap="nowrap"><select name="advpp<?php echo $user; ?>_date_format" class="styled-select-range">
	<?php if ($advpp_date_format == 'DDMMYYYY') { ?>
	<option value="DDMMYYYY" selected="selected"><?php echo $text_format_date_eu; ?></option>
	<option value="MMDDYYYY"><?php echo $text_format_date_us; ?></option>
	<?php } else { ?>
	<option value="DDMMYYYY"><?php echo $text_format_date_eu; ?></option>
	<option value="MMDDYYYY" selected="selected"><?php echo $text_format_date_us; ?></option>
	<?php } ?>
	</select></td></tr> 
    <tr>
    <td width="50%" nowrap="nowrap">&nbsp;<?php echo $text_format_hour; ?> &nbsp;</td>
    <td nowrap="nowrap"><select name="advpp<?php echo $user; ?>_hour_format" class="styled-select-range">
	<?php if ($advpp_hour_format == '24') { ?>
	<option value="24" selected="selected"><?php echo $text_format_hour_24; ?></option>
	<option value="12"><?php echo $text_format_hour_12; ?></option>
	<?php } else { ?>
	<option value="24"><?php echo $text_format_hour_24; ?></option>
	<option value="12" selected="selected"><?php echo $text_format_hour_12; ?></option>
	<?php } ?>
	</select></td></tr> 
    <tr>
    <td width="50%" nowrap="nowrap">&nbsp;<?php echo $text_format_week; ?> &nbsp;</td>
    <td nowrap="nowrap"><select name="advpp<?php echo $user; ?>_week_days" class="styled-select-range">
	<?php if ($advpp_week_days == 'mon_sun') { ?>
	<option value="mon_sun" selected="selected"><?php echo $text_format_week_mon_sun; ?></option>
	<option value="sun_sat"><?php echo $text_format_week_sun_sat; ?></option>
	<?php } else { ?>
	<option value="mon_sun"><?php echo $text_format_week_mon_sun; ?></option>
	<option value="sun_sat" selected="selected"><?php echo $text_format_week_sun_sat; ?></option>
	<?php } ?>
	</select></td></tr>
	</table>                      
	<h3><?php echo $text_filtering_options; ?></h3> 
    <table width="100%" cellspacing="0" cellpadding="0" style="background:#F0F0F0; border:1px solid #CCCCCC; padding:3px;"> 
    <tr>
    <td nowrap="nowrap">
	<?php foreach ($filters as $key => $filter) { ?>
	<div class="columns_setting"><label>
	<?php if (in_array($key, $advpp_settings_filters)) { ?>
		<input type="checkbox" value="<?php echo $key; ?>" name="advpp<?php echo $user; ?>_settings_filters[]" checked="checked"/> <?php echo $filter; ?>
	<?php } else { ?>
		<input type="checkbox" value="<?php echo $key; ?>" name="advpp<?php echo $user; ?>_settings_filters[]" /> <?php echo $filter; ?>
	<?php } ?>
	</label></div>
	<?php } ?>
    </td></tr> 
	</table> 
	<h3><?php echo $text_column_settings; ?> <span style="color:#390; font-size:small;"> [<?php echo $text_export_note; ?>]</span></h3>
    <div><span style="font-size:11px; font-weight:bold;"><?php echo $text_mv_columns; ?>:</span></div>     
    <table width="100%" cellspacing="0" cellpadding="0" style="background:#f5f5f5; border:1px solid #CCCCCC; padding:3px; margin-top:3px;"> 
    <tr>
    <td nowrap="nowrap">
	<?php foreach ($mv_columns as $key => $mv_column) { ?>
	<div class="columns_setting"><label>
	<?php if (in_array($key, $advpp_settings_mv_columns)) { ?>
		<input type="checkbox" value="<?php echo $key; ?>" name="advpp<?php echo $user; ?>_settings_mv_columns[]" checked="checked"/> <?php echo $mv_column; ?>
	<?php } else { ?>
		<input type="checkbox" value="<?php echo $key; ?>" name="advpp<?php echo $user; ?>_settings_mv_columns[]" /> <?php echo $mv_column; ?>
	<?php } ?>
	</label></div>
	<?php } ?>
    </td></tr>
	</table> 
    <div style="padding-top:20px;"><span style="font-size:11px; font-weight:bold;"><?php echo $text_bd_columns; ?>:</span></div>   
    <table width="100%" cellspacing="0" cellpadding="0" style="background:#f5f5f5; border:1px solid #CCCCCC; padding:3px; margin-top:3px;">      
    <tr>
    <td nowrap="nowrap">
	<?php foreach ($ol_columns as $key => $ol_column) { ?>
	<div class="columns_setting"><label>
	<?php if (in_array($key, $advpp_settings_ol_columns)) { ?>
		<input type="checkbox" value="<?php echo $key; ?>" name="advpp<?php echo $user; ?>_settings_ol_columns[]" checked="checked"/> <?php echo $ol_column; ?>
	<?php } else { ?>
		<input type="checkbox" value="<?php echo $key; ?>" name="advpp<?php echo $user; ?>_settings_ol_columns[]" /> <?php echo $ol_column; ?>
	<?php } ?>
	</label></div>
	<?php } ?>
    </td></tr>  
    <tr><td>&nbsp;</td></tr>
    <tr>
    <td nowrap="nowrap">
	<?php foreach ($pl_columns as $key => $pl_column) { ?>
	<div class="columns_setting"><label>
	<?php if (in_array($key, $advpp_settings_pl_columns)) { ?>
		<input type="checkbox" value="<?php echo $key; ?>" name="advpp<?php echo $user; ?>_settings_pl_columns[]" checked="checked"/> <?php echo $pl_column; ?>
	<?php } else { ?>
		<input type="checkbox" value="<?php echo $key; ?>" name="advpp<?php echo $user; ?>_settings_pl_columns[]" /> <?php echo $pl_column; ?>
	<?php } ?>
	</label></div>
	<?php } ?>
    </td></tr>     
    <tr><td>&nbsp;</td></tr>
    <tr>
    <td nowrap="nowrap">
	<?php foreach ($cl_columns as $key => $cl_column) { ?>
	<div class="columns_setting"><label>
	<?php if (in_array($key, $advpp_settings_cl_columns)) { ?>
		<input type="checkbox" value="<?php echo $key; ?>" name="advpp<?php echo $user; ?>_settings_cl_columns[]" checked="checked"/> <?php echo $cl_column; ?>
	<?php } else { ?>
		<input type="checkbox" value="<?php echo $key; ?>" name="advpp<?php echo $user; ?>_settings_cl_columns[]" /> <?php echo $cl_column; ?>
	<?php } ?>
	</label></div>
	<?php } ?>
    </td></tr>
	</table>     
    <div style="padding-top:20px;"><span style="font-size:11px; font-weight:bold;"><?php echo $text_all_columns; ?>:</span></div>     
    <table width="100%" cellspacing="0" cellpadding="0" style="background:#f5f5f5; border:1px solid #CCCCCC; padding:3px; margin-top:3px;"> 
    <tr>
    <td nowrap="nowrap">
	<?php foreach ($all_columns as $key => $all_column) { ?>
	<div class="columns_setting"><label>
	<?php if (in_array($key, $advpp_settings_all_columns)) { ?>
		<input type="checkbox" value="<?php echo $key; ?>" name="advpp<?php echo $user; ?>_settings_all_columns[]" checked="checked"/> <?php echo $all_column; ?>
	<?php } else { ?>
		<input type="checkbox" value="<?php echo $key; ?>" name="advpp<?php echo $user; ?>_settings_all_columns[]" /> <?php echo $all_column; ?>
	<?php } ?>
	</label></div>
	<?php } ?>
    </td></tr>
	</table> 
	<div align="right" style="padding-top:15px; padding-bottom:15px;">
	<a id="close_settings" class="cbutton" style="background:#FFF; color:#666;"><span><?php echo $button_close; ?></span></a>
	<a id="save_settings" class="cbutton" style="background:#1e91cf;"><span><?php echo $button_save; ?></span></a>
	</div>
</div>   
<script type="text/javascript">
$("#settings").click(function() {					  
    $("#settings_window").dialog({
            title: '<?php echo $button_settings; ?>',
            width: 900,
            height: 600,
			closeOnEscape: true,
            modal: true,			
    });
});
$("#close_settings").click( function() {
    $("#settings_window").dialog("close");
});
</script>  
<?php include(DIR_APPLICATION . 'view/image/adv_reports/separator.png'); ?>
<div style="background: #f5f5f5; border: 1px solid #C6D7D7; margin-bottom: 15px; -moz-border-radius: 3px; border-radius: 3px;">
	<table width="100%" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	 <table cellspacing="0" cellpadding="0">
  	 <tr>
     <td style="background:#f0f0f0;">
	 <table align="center" border="0" cellspacing="0" cellpadding="0" style="background:#f0f0f0; border:2px solid #E0E0E0; padding:5px; margin-top:3px; margin-bottom:3px;">
	 <tr><td colspan="3" align="center"><span style="font-weight:bold; color:#333;"><?php echo ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') ? $entry_product_added : $entry_order_created ?></span></td></tr>
  	 <tr><td>
       <table cellpadding="0" cellspacing="0" style="padding-top:3px;">
       <tr><td align="left"><?php echo $entry_range; ?><br />    
            <select name="filter_range" id="filter_range" class="styled-select-range">
              <?php foreach ($ranges as $range) { ?>
              <?php if ($range['value'] == $filter_range) { ?>
              <option value="<?php echo $range['value']; ?>" title="<?php echo $range['text']; ?>" style="<?php echo $range['style']; ?>" selected="selected"><?php echo $range['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $range['value']; ?>" title="<?php echo $range['text']; ?>" style="<?php echo $range['style']; ?>"><?php echo $range['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
       </td><td width="5"></td></tr></table>
     </td><td>      
       <table cellpadding="0" cellspacing="0" style="padding-top:3px;">
       <tr><td align="left">&nbsp;<?php echo $entry_date_start; ?><br />
          <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" class="styled-input-range" />
       </td><td width="5"></td></tr></table>
     </td><td>
       <table cellpadding="0" cellspacing="0" style="padding-top:3px;">
       <tr><td align="left">&nbsp;<?php echo $entry_date_end; ?><br />
          <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" class="styled-input-range" />
       </td><td></td></tr></table>
     </td></tr></table>  
     </td>
     <?php if ($filter_report != 'products_without_orders') { ?>
     <td align="center" style="background:#f0f0f0;">      
	 <table align="center" border="0" cellspacing="0" cellpadding="0" style="background:#f0f0f0; border:2px solid #E0E0E0; padding:5px; margin-top:3px; margin-bottom:3px;">
	 <tr><td colspan="3" align="center"><span style="font-weight:bold; color:#333;"><?php echo ($filter_report == 'all_products_with_without_orders') ? substr($entry_status,0,-1) : $entry_status_changed ?></span></td></tr>
  	 <tr>
     <?php if ($filter_report != 'all_products_with_without_orders') { ?>
     <td>
       <table cellpadding="0" cellspacing="0" style="padding-top:3px;">
       <tr><td align="left">&nbsp;<?php echo $entry_date_start; ?><br />
          <input type="text" name="filter_status_date_start" value="<?php echo $filter_status_date_start; ?>" id="status-date-start" size="12" class="styled-input" />
       </td><td width="5"></td></tr></table>
     </td><td> 
       <table cellpadding="0" cellspacing="0" style="padding-top:3px;">
       <tr><td align="left">&nbsp;<?php echo $entry_date_end; ?><br />
          <input type="text" name="filter_status_date_end" value="<?php echo $filter_status_date_end; ?>" id="status-date-end" size="12" class="styled-input" />
       </td><td width="5"></td></tr></table>
     </td>
     <?php } ?>
     <td> 
       <table cellpadding="0" cellspacing="0" style="padding-top:3px;">
       <tr><td align="left"><?php echo $entry_status; ?><br />
          <select name="filter_order_status_id" id="filter_order_status_id" multiple="multiple">
            <?php foreach ($order_statuses as $order_status) { ?>
            <?php if (in_array($order_status['order_status_id'], $filter_order_status_id)) { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
       </td></tr></table>
     </td></tr></table>
	 </td>
     <?php } ?>
     <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?> 
     <td style="background:#f0f0f0;">        
	 <table align="center" border="0" cellspacing="0" cellpadding="0" style="background:#f0f0f0; border:2px solid #E0E0E0; padding:5px; margin-top:3px; margin-bottom:3px;">
	 <tr><td colspan="2" align="center"><span style="font-weight:bold; color:#333;"><?php echo $entry_order_id; ?></span></td></tr>
  	 <tr><td>  
       <table cellpadding="0" cellspacing="0" style="padding-top:3px;">
       <tr><td align="left">&nbsp;<?php echo $entry_order_id_from; ?><br />
          <input type="text" name="filter_order_id_from" value="<?php echo $filter_order_id_from; ?>" size="12" class="styled-input" />
       </td><td width="5"></td></tr></table>
     </td><td> 
       <table cellpadding="0" cellspacing="0" style="padding-top:3px;">
       <tr><td align="left">&nbsp;<?php echo $entry_order_id_to; ?><br />
          <input type="text" name="filter_order_id_to" value="<?php echo $filter_order_id_to; ?>" size="12" class="styled-input" />
       </td><td></td></tr></table>
    </td></tr></table>
    </td>
    <?php } ?>
    </tr>
	<tr>
    <td colspan="3" valign="top" style="padding:5px;">  
      <?php if (in_array('store', $advpp_settings_filters)) { ?>
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_store; ?></span><br />
          <select name="filter_store_id" id="filter_store_id" multiple="multiple">
            <?php foreach ($stores as $store) { ?>
            <?php if (in_array($store['store_id'], $filter_store_id)) { ?>         
            <option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['store_name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $store['store_id']; ?>"><?php echo $store['store_name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>    
	  <?php } ?>      
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>     
	  <?php if (in_array('currency', $advpp_settings_filters)) { ?>        
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_currency; ?></span><br />
          <select name="filter_currency" id="filter_currency" multiple="multiple">
            <?php foreach ($currencies as $currency) { ?>
            <?php if (in_array($currency['currency_id'], $filter_currency)) { ?>
            <option value="<?php echo $currency['currency_id']; ?>" selected="selected"><?php echo $currency['title']; ?> (<?php echo $currency['code']; ?>)</option>
            <?php } else { ?>
            <option value="<?php echo $currency['currency_id']; ?>"><?php echo $currency['title']; ?> (<?php echo $currency['code']; ?>)</option>
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>          
	  </tr></table>
	  <?php } ?>     
      <?php } ?>
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>       
	  <?php if (in_array('tax', $advpp_settings_filters)) { ?>      
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_tax; ?></span><br />
		  <select name="filter_taxes" id="filter_taxes" multiple="multiple">
            <?php foreach ($taxes as $tax) { ?>
            <?php if (in_array($tax['tax'], $filter_taxes)) { ?>          
            <option value="<?php echo $tax['tax']; ?>" selected="selected"><?php echo $tax['tax_title']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $tax['tax']; ?>"><?php echo $tax['tax_title']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>
	  <?php } ?>
      <?php } ?>
	  <?php if (in_array('tax_class', $advpp_settings_filters)) { ?>      
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_tax_classes; ?></span><br />
		  <select name="filter_tax_classes" id="filter_tax_classes" multiple="multiple">
            <?php foreach ($tax_classes as $tax_class) { ?>
            <?php if (in_array($tax_class['tax_class'], $filter_tax_classes)) { ?>               
            <option value="<?php echo $tax_class['tax_class']; ?>" selected="selected"><?php echo $tax_class['tax_class_title']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $tax_class['tax_class']; ?>"><?php echo $tax_class['tax_class_title']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>   
	  <?php } ?>
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>  
	  <?php if (in_array('geo_zone', $advpp_settings_filters)) { ?>         
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_geo_zone; ?></span><br />
		  <select name="filter_geo_zones" id="filter_geo_zones" multiple="multiple">
            <?php foreach ($geo_zones as $geo_zone) { ?>
            <?php if (in_array($geo_zone['geo_zone_country_id'], $filter_geo_zones)) { ?>           
            <option value="<?php echo $geo_zone['geo_zone_country_id']; ?>" selected="selected"><?php echo $geo_zone['geo_zone_name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $geo_zone['geo_zone_country_id']; ?>"><?php echo $geo_zone['geo_zone_name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>
	  <?php } ?>  
      <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>      
	  <?php if (in_array('customer_group', $advpp_settings_filters)) { ?>      
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_customer_group; ?></span><br />
          <select name="filter_customer_group_id" id="filter_customer_group_id" multiple="multiple">
            <?php foreach ($customer_groups as $customer_group) { ?>
            <?php if (in_array($customer_group['customer_group_id'], $filter_customer_group_id)) { ?>          
            <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>
      <?php } ?>
      <?php } ?>      
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>       
      <?php if (in_array('customer_name', $advpp_settings_filters)) { ?>      
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo $entry_customer_name; ?></span><br />
        <input type="text" name="filter_customer_name" id="filter_customer_name" value="<?php echo $filter_customer_name; ?>" size="20" class="styled-input">
		</td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>  
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>       
      <?php if (in_array('customer_email', $advpp_settings_filters)) { ?>      
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo $entry_customer_email; ?></span><br />
        <input type="text" name="filter_customer_email" id="filter_customer_email" value="<?php echo $filter_customer_email; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>  
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>   
      <?php if (in_array('customer_telephone', $advpp_settings_filters)) { ?>      
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo $entry_customer_telephone; ?></span><br />
        <input type="text" name="filter_customer_telephone" id="filter_customer_telephone" value="<?php echo $filter_customer_telephone; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table> 
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>   
      <?php if (in_array('ip', $advpp_settings_filters)) { ?>      
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo $entry_ip; ?></span><br />
        <input type="text" name="filter_ip" id="filter_ip" value="<?php echo $filter_ip; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>  
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>   
      <?php if (in_array('payment_company', $advpp_settings_filters)) { ?>           
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') ? substr(strstr($entry_payment_company,' '), 1) : $entry_payment_company ?></span><br />
        <input type="text" name="filter_payment_company" id="filter_payment_company" value="<?php echo $filter_payment_company; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table> 
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>   
      <?php if (in_array('payment_address', $advpp_settings_filters)) { ?>      
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') ? substr(strstr($entry_payment_address,' '), 1) : $entry_payment_address ?></span><br />
        <input type="text" name="filter_payment_address" id="filter_payment_address" value="<?php echo $filter_payment_address; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table> 
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>   
      <?php if (in_array('payment_city', $advpp_settings_filters)) { ?>      
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') ? substr(strstr($entry_payment_city,' '), 1) : $entry_payment_city ?></span><br />
        <input type="text" name="filter_payment_city" id="filter_payment_city" value="<?php echo $filter_payment_city; ?>" size="20" class="styled-input">
		</td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table> 
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>   
      <?php if (in_array('payment_zone', $advpp_settings_filters)) { ?>      
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') ? substr(strstr($entry_payment_zone,' '), 1) : $entry_payment_zone ?></span><br />
        <input type="text" name="filter_payment_zone" id="filter_payment_zone" value="<?php echo $filter_payment_zone; ?>" size="20" class="styled-input">
		</td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>  
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>   
      <?php if (in_array('payment_postcode', $advpp_settings_filters)) { ?>      
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') ? substr(strstr($entry_payment_postcode,' '), 1) : $entry_payment_postcode ?></span><br />
        <input type="text" name="filter_payment_postcode" id="filter_payment_postcode" value="<?php echo $filter_payment_postcode; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table> 
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>   
      <?php if (in_array('payment_country', $advpp_settings_filters)) { ?>      
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') ? substr(strstr($entry_payment_country,' '), 1) : $entry_payment_country ?></span><br />
        <input type="text" name="filter_payment_country" id="filter_payment_country" value="<?php echo $filter_payment_country; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table> 
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>              
      <?php if (in_array('payment_method', $advpp_settings_filters)) { ?>      
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_payment_method; ?></span><br />
		  <select name="filter_payment_method" id="filter_payment_method" multiple="multiple">
            <?php foreach ($payment_methods as $payment_method) { ?>
            <?php if (in_array($payment_method['payment_code'], $filter_payment_method)) { ?>
            <option value="<?php echo $payment_method['payment_code']; ?>" selected="selected"><?php echo preg_replace('~\(.*?\)~', '', $payment_method['payment_method']); ?></option>
            <?php } else { ?>
            <option value="<?php echo $payment_method['payment_code']; ?>"><?php echo preg_replace('~\(.*?\)~', '', $payment_method['payment_method']); ?></option>
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>   
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>         
      <?php if (in_array('shipping_company', $advpp_settings_filters)) { ?>
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo $entry_shipping_company; ?></span><br />
        <input type="text" name="filter_shipping_company" id="filter_shipping_company" value="<?php echo $filter_shipping_company; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table> 
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>        
      <?php if (in_array('shipping_address', $advpp_settings_filters)) { ?>  
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo $entry_shipping_address; ?></span><br />
        <input type="text" name="filter_shipping_address" id="filter_shipping_address" value="<?php echo $filter_shipping_address; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table> 
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>         
      <?php if (in_array('shipping_city', $advpp_settings_filters)) { ?>  
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo $entry_shipping_city; ?></span><br />
        <input type="text" name="filter_shipping_city" id="filter_shipping_city" value="<?php echo $filter_shipping_city; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table> 
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>         
      <?php if (in_array('shipping_zone', $advpp_settings_filters)) { ?> 
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo $entry_shipping_zone; ?></span><br />
        <input type="text" name="filter_shipping_zone" id="filter_shipping_zone" value="<?php echo $filter_shipping_zone; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>  
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>         
      <?php if (in_array('shipping_postcode', $advpp_settings_filters)) { ?>                
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo $entry_shipping_postcode; ?></span><br />
        <input type="text" name="filter_shipping_postcode" id="filter_shipping_postcode" value="<?php echo $filter_shipping_postcode; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table> 
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>        
      <?php if (in_array('shipping_country', $advpp_settings_filters)) { ?>   
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo $entry_shipping_country; ?></span><br />
        <input type="text" name="filter_shipping_country" id="filter_shipping_country" value="<?php echo $filter_shipping_country; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>           
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>        
      <?php if (in_array('shipping_method', $advpp_settings_filters)) { ?> 
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_shipping_method; ?></span><br />
		  <select name="filter_shipping_method" id="filter_shipping_method" multiple="multiple">
            <?php foreach ($shipping_methods as $shipping_method) { ?>
            <?php if (in_array($shipping_method['shipping_code'], $filter_shipping_method)) { ?>
            <option value="<?php echo $shipping_method['shipping_code']; ?>" selected="selected"><?php echo preg_replace('~\(.*?\)~', '', $shipping_method['shipping_method']); ?></option>
            <?php } else { ?>
            <option value="<?php echo $shipping_method['shipping_code']; ?>"><?php echo preg_replace('~\(.*?\)~', '', $shipping_method['shipping_method']); ?></option>
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>
      <?php } ?>
      <?php } ?>
      <?php if (in_array('category', $advpp_settings_filters)) { ?> 
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_category; ?></span><br />
          <select name="filter_category" id="filter_category" multiple="multiple">
            <?php foreach ($categories as $category) { ?>
			<?php if (in_array($category['category_id'], $filter_category)) { ?>         
            <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option> 
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>     
      <?php } ?>
      <?php if (in_array('manufacturer', $advpp_settings_filters)) { ?>                         
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_manufacturer; ?></span><br />
          <select name="filter_manufacturer" id="filter_manufacturer" multiple="multiple">
            <?php foreach ($manufacturers as $manufacturer) { ?>
            <?php if (in_array($manufacturer['manufacturer_id'], $filter_manufacturer)) { ?>            
            <option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option> 
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>   
      <?php } ?>
      <?php if (in_array('sku', $advpp_settings_filters)) { ?>      
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo $entry_sku; ?></span><br />
        <input type="text" name="filter_sku" id="filter_sku" value="<?php echo $filter_sku; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table> 
      <?php } ?>
      <?php if (in_array('product', $advpp_settings_filters)) { ?>  
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo $entry_product; ?></span><br />
        <input type="text" name="filter_product_name" id="filter_product_name" value="<?php echo $filter_product_name; ?>" size="40" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table> 
      <?php } ?>
      <?php if (in_array('model', $advpp_settings_filters)) { ?>   
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo $entry_model; ?></span><br />
        <input type="text" name="filter_model" id="filter_model" value="<?php echo $filter_model; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>  
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>       
      <?php if (in_array('option', $advpp_settings_filters)) { ?> 
	  <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_option; ?></span><br />
          <select name="filter_option" id="filter_option" multiple="multiple">
            <?php foreach ($order_options as $order_option) { ?>
            <?php if (in_array($order_option['options'], $filter_option)) { ?>          
            <option value="<?php echo $order_option['options']; ?>" selected="selected"><?php echo $order_option['option_name']; ?>: <?php echo $order_option['option_value']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $order_option['options']; ?>"><?php echo $order_option['option_name']; ?>: <?php echo $order_option['option_value']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>  
      <?php } ?>
      <?php } ?>     
      <?php if (in_array('attribute', $advpp_settings_filters)) { ?> 
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_attributes; ?></span><br />
		  <select name="filter_attribute" id="filter_attribute" multiple="multiple">
            <?php foreach ($attributes as $attribute) { ?>
            <?php if (in_array($attribute['attribute_title'], $filter_attribute)) { ?>          
            <option value="<?php echo $attribute['attribute_title']; ?>" selected="selected"><?php echo $attribute['attribute_name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $attribute['attribute_title']; ?>"><?php echo $attribute['attribute_name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>    
      <?php } ?>
      <?php if (in_array('product_status', $advpp_settings_filters)) { ?>
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_product_status; ?></span><br />
          <select name="filter_product_status" id="filter_product_status" multiple="multiple">
            <?php foreach ($product_statuses as $product_status) { ?>
            <?php if (in_array($product_status['status'], $filter_product_status) && $product_status['status'] == 1) { ?>
            <option value="<?php echo $product_status['status']; ?>" selected="selected"><?php echo $text_enabled; ?></option>
            <?php } elseif (!in_array($product_status['status'], $filter_product_status) && $product_status['status'] == 1) { ?>
            <option value="<?php echo $product_status['status']; ?>"><?php echo $text_enabled; ?></option>
            <?php } ?>
            <?php if (in_array($product_status['status'], $filter_product_status) && $product_status['status'] == 0) { ?>
            <option value="<?php echo $product_status['status']; ?>" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } elseif (!in_array($product_status['status'], $filter_product_status) && $product_status['status'] == 0) { ?>
            <option value="<?php echo $product_status['status']; ?>"><?php echo $text_disabled; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>
      <?php } ?>       
      <?php if (in_array('location', $advpp_settings_filters)) { ?>           
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_location; ?></span><br />
		  <select name="filter_location" id="filter_location" multiple="multiple">
            <?php foreach ($locations as $location) { ?>
            <?php if (in_array($location['location_title'], $filter_location)) { ?>         
            <option value="<?php echo $location['location_title']; ?>" selected="selected"><?php echo $location['location_name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $location['location_title']; ?>"><?php echo $location['location_name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>         
      <?php if (in_array('affiliate_name', $advpp_settings_filters)) { ?> 
	  <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_affiliate_name; ?></span><br />
          <select name="filter_affiliate_name" id="filter_affiliate_name" multiple="multiple">
            <?php foreach ($affiliate_names as $affiliate_name) { ?>
            <?php if (in_array($affiliate_name['affiliate_id'], $filter_affiliate_name)) { ?>            
            <option value="<?php echo $affiliate_name['affiliate_id']; ?>" selected="selected"><?php echo $affiliate_name['affiliate_name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $affiliate_name['affiliate_id']; ?>"><?php echo $affiliate_name['affiliate_name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>        
      <?php if (in_array('affiliate_email', $advpp_settings_filters)) { ?> 
	  <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_affiliate_email; ?></span><br />
          <select name="filter_affiliate_email" id="filter_affiliate_email" multiple="multiple">
            <?php foreach ($affiliate_emails as $affiliate_email) { ?>
            <?php if (in_array($affiliate_email['affiliate_id'], $filter_affiliate_email)) { ?>        
            <option value="<?php echo $affiliate_email['affiliate_id']; ?>" selected="selected"><?php echo $affiliate_email['affiliate_email']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $affiliate_email['affiliate_id']; ?>"><?php echo $affiliate_email['affiliate_email']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>        
      <?php if (in_array('coupon_name', $advpp_settings_filters)) { ?> 
	  <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td><span style="font-weight:bold; color:#333;"><?php echo $entry_coupon_name; ?></span><br />
          <select name="filter_coupon_name" id="filter_coupon_name" multiple="multiple">
            <?php foreach ($coupon_names as $coupon_name) { ?>
            <?php if (in_array($coupon_name['coupon_id'], $filter_coupon_name)) { ?>          
            <option value="<?php echo $coupon_name['coupon_id']; ?>" selected="selected"><?php echo $coupon_name['coupon_name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $coupon_name['coupon_id']; ?>"><?php echo $coupon_name['coupon_name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>        
      <?php if (in_array('coupon_code', $advpp_settings_filters)) { ?>  
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo $entry_coupon_code; ?></span><br />
        <input type="text" name="filter_coupon_code" id="filter_coupon_code" value="<?php echo $filter_coupon_code; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>  
      <?php } ?>
	  <?php } ?>   
      <?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>         
      <?php if (in_array('voucher_code', $advpp_settings_filters)) { ?>         
      <table cellpadding="0" cellspacing="0" style="float:left; height:73px;">
        <tr><td>&nbsp;<span style="font-weight:bold; color:#333;"><?php echo $entry_voucher_code; ?></span><br />
        <input type="text" name="filter_voucher_code" id="filter_voucher_code" value="<?php echo $filter_voucher_code; ?>" size="20" class="styled-input">
        </td><td width="15"></td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td>
	  </tr></table>  
      <?php } ?>
      <?php } ?>
	   </td>
	  </tr>
	 </table>
	</td>
	</tr>
	</table>      
</div>
<?php if ($products) { ?>
<?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders' && $filter_details != 'all_details' && $filter_group == 'no_group') { ?>  
<script type="text/javascript">$(function(){ 
$('#show_tab_chart').click(function() {
		$('#tab_chart').slideToggle('slow');
	});
});
</script>   
    <div id="tab_chart">
      <table style="width:100%; padding-bottom:10px;" align="center" cellspacing="0" cellpadding="3">
        <tr>
          <td><div style="float:left; width:50%;" id="chart1_div"></div><div style="float:left; width:50%;" id="chart2_div"></div></td>
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
<?php if ($filter_details == 'all_details') { ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">       
	<tr> 
    <td> 
	<?php if ($products) { ?>          
		<table class="list_detail">
		<thead>
		<tr>
          <td class="left" nowrap="nowrap"><?php echo $column_order_order_id; ?></td>        
          <td class="left" nowrap="nowrap"><?php echo $column_order_date_added; ?></td> 
          <?php if (in_array('all_order_inv_no', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_order_inv_no; ?></td>
          <?php } ?>
          <?php if (in_array('all_order_customer_name', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_order_customer; ?></td>
          <?php } ?>
          <?php if (in_array('all_order_email', $advpp_settings_all_columns)) { ?>
          <td class="left" nowrap="nowrap"><?php echo $column_order_email; ?></td>
          <?php } ?>
          <?php if (in_array('all_order_customer_group', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_order_customer_group; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_id', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_prod_id; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_sku', $advpp_settings_all_columns)) { ?>           
		  <td class="left" nowrap="nowrap"><?php echo $column_prod_sku; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_model', $advpp_settings_all_columns)) { ?>           
		  <td class="left" nowrap="nowrap"><?php echo $column_prod_model; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_name', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_prod_name; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_option', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_prod_option; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_attributes', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_prod_attributes; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_manu', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_prod_manu; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_category', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_prod_category; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_currency', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_prod_currency; ?></td>
          <?php } ?>          
          <?php if (in_array('all_prod_price', $advpp_settings_all_columns)) { ?>           
          <td class="right" nowrap="nowrap"><?php echo $column_prod_price; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_quantity', $advpp_settings_all_columns)) { ?>           
          <td class="right" nowrap="nowrap"><?php echo $column_prod_quantity; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_total_excl_vat', $advpp_settings_all_columns)) { ?>           
          <td class="right" nowrap="nowrap"><?php echo $column_prod_total_excl_vat; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_tax', $advpp_settings_all_columns)) { ?>           
          <td class="right" nowrap="nowrap"><?php echo $column_prod_tax; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_total_incl_vat', $advpp_settings_all_columns)) { ?>           
          <td class="right" nowrap="nowrap"><?php echo $column_prod_total_incl_vat; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_qty_refund', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_prod_qty_refunded; ?></td>
          <?php } ?> 
          <?php if (in_array('all_prod_refund', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_prod_refunded; ?></td>
          <?php } ?>     
          <?php if (in_array('all_prod_reward_points', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_prod_reward_points; ?></td>
          <?php } ?> 
          <?php if (in_array('all_sub_total', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_sub_total; ?></td>
          <?php } ?>              
          <?php if (in_array('all_handling', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_handling; ?></td>
          <?php } ?>
          <?php if (in_array('all_loworder', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_loworder; ?></td>
          <?php } ?>                  
          <?php if (in_array('all_shipping', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_order_shipping; ?></td>
          <?php } ?>
          <?php if (in_array('all_reward', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_reward; ?></td>
          <?php } ?>
          <?php if (in_array('all_reward_points', $advpp_settings_all_columns)) { ?>          
          <td class="right" style="min-width:85px;"><?php echo $column_earned_reward_points; ?></td>
          <?php } ?>  
          <?php if (in_array('all_reward_points', $advpp_settings_all_columns)) { ?>          
          <td class="right" style="min-width:85px;"><?php echo $column_used_reward_points; ?></td>
          <?php } ?>            
          <?php if (in_array('all_coupon', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_coupon; ?></td>
          <?php } ?>
          <?php if (in_array('all_coupon_code', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_coupon_code; ?></td>
          <?php } ?>                              
          <?php if (in_array('all_order_tax', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_order_tax; ?></td>
          <?php } ?>
          <?php if (in_array('all_credit', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_credit; ?></td>
          <?php } ?>
          <?php if (in_array('all_voucher', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_voucher; ?></td>
          <?php } ?>
          <?php if (in_array('all_voucher_code', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_voucher_code; ?></td>
          <?php } ?>     
          <?php if (in_array('all_order_commission', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_commission; ?></td>
          <?php } ?>                                   
          <?php if (in_array('all_order_value', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_order_value; ?></td>
          <?php } ?>
          <?php if (in_array('all_refund', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_order_refund; ?></td>
          <?php } ?> 
          <?php if (in_array('all_order_shipping_method', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_order_shipping_method; ?></td>
          <?php } ?>
          <?php if (in_array('all_order_payment_method', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_order_payment_method; ?></td>
          <?php } ?>
          <?php if (in_array('all_order_status', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_order_status; ?></td>
          <?php } ?>
          <?php if (in_array('all_order_store', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_order_store; ?></td>
          <?php } ?>
          <?php if (in_array('all_customer_cust_id', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_customer_cust_id; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_name', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_billing_first_name; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_name', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_billing_last_name; ?></td>
          <?php } ?>          
          <?php if (in_array('all_billing_company', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_billing_company; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_address_1', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_billing_address_1; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_address_2', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_billing_address_2; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_city', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_billing_city; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_zone', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_billing_zone; ?></td> 
          <?php } ?>
          <?php if (in_array('all_billing_zone_id', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_billing_zone_id; ?></td> 
          <?php } ?>
          <?php if (in_array('all_billing_zone_code', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_billing_zone_code; ?></td> 
          <?php } ?>                    
          <?php if (in_array('all_billing_postcode', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_billing_postcode; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_country', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_billing_country; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_country_id', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_billing_country_id; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_country_code', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_billing_country_code; ?></td>
          <?php } ?>                    
          <?php if (in_array('all_customer_telephone', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_customer_telephone; ?></td>
          <?php } ?>
          <?php if (in_array('all_shipping_name', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_first_name; ?></td> 
          <?php } ?>
          <?php if (in_array('all_shipping_name', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_last_name; ?></td> 
          <?php } ?>          
          <?php if (in_array('all_shipping_company', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_company; ?></td> 
          <?php } ?>
          <?php if (in_array('all_shipping_address_1', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_address_1; ?></td> 
          <?php } ?>
          <?php if (in_array('all_shipping_address_2', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_address_2; ?></td> 
          <?php } ?>
          <?php if (in_array('all_shipping_city', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_city; ?></td>
          <?php } ?>
          <?php if (in_array('all_shipping_zone', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_zone; ?></td> 
          <?php } ?>
          <?php if (in_array('all_shipping_zone_id', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_zone_id; ?></td> 
          <?php } ?>
          <?php if (in_array('all_shipping_zone_code', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_zone_code; ?></td> 
          <?php } ?>                    
          <?php if (in_array('all_shipping_postcode', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_postcode; ?></td>
          <?php } ?>
          <?php if (in_array('all_shipping_country', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_country; ?></td>
          <?php } ?> 
          <?php if (in_array('all_shipping_country_id', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_country_id; ?></td>
          <?php } ?> 
          <?php if (in_array('all_shipping_country_code', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_country_code; ?></td>
          <?php } ?>                     
          <?php if (in_array('all_order_weight', $advpp_settings_all_columns)) { ?>           
          <td class="right" nowrap="nowrap"><?php echo $column_order_weight; ?></td>
          <?php } ?>           
          <?php if (in_array('all_order_comment', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $column_order_comment; ?></td>
          <?php } ?>        
		</tr>
		</thead>
        <tbody>
	<?php foreach ($products as $product) { ?>
    <?php if ($product['product_id']) { ?>          
		<tr bgcolor="#FFFFFF">
          <td class="left" nowrap="nowrap" style="background-color:#FFC;" title="<?php echo $column_order_order_id; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><a><?php echo $product['order_id_link']; ?></a></td>        
          <td class="left" nowrap="nowrap" title="<?php echo $column_order_date_added; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['date_added']; ?></td>
          <?php if (in_array('all_order_inv_no', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap" title="<?php echo $column_order_inv_no; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['invoice']; ?></td>
          <?php } ?>
          <?php if (in_array('all_order_customer_name', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap" title="<?php echo $column_order_customer; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['name']; ?></td>
          <?php } ?>
          <?php if (in_array('all_order_email', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap" title="<?php echo $column_order_email; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['email']; ?></td>
          <?php } ?>
          <?php if (in_array('all_order_customer_group', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap" title="<?php echo $column_order_customer_group; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['cust_group']; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_id', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo $column_prod_id; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_id_link']; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_sku', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo $column_prod_sku; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_sku']; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_model', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo $column_prod_model; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_model']; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_name', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo $column_prod_name; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_name']; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_option', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo $column_prod_option; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_option']; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_attributes', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo $column_prod_attributes; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_attributes']; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_manu', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo $column_prod_manu; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_manu']; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_category', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo $column_prod_category; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_category']; ?></td>
          <?php } ?>  
          <?php if (in_array('all_prod_currency', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo $column_prod_currency; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['currency_code']; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_price', $advpp_settings_all_columns)) { ?>           
          <td class="right" nowrap="nowrap" title="<?php echo $column_prod_price; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_price']; ?></td>
          <?php } ?>                  
          <?php if (in_array('all_prod_quantity', $advpp_settings_all_columns)) { ?>           
          <td class="right" nowrap="nowrap" title="<?php echo $column_prod_quantity; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_quantity']; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_total_excl_vat', $advpp_settings_all_columns)) { ?>           
          <td class="right" nowrap="nowrap" title="<?php echo $column_prod_total_excl_vat; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_total_excl_vat']; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_tax', $advpp_settings_all_columns)) { ?>           
          <td class="right" nowrap="nowrap" title="<?php echo $column_prod_tax; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_tax']; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_total_incl_vat', $advpp_settings_all_columns)) { ?>           
          <td class="right" nowrap="nowrap" title="<?php echo $column_prod_total_incl_vat; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_total_incl_vat']; ?></td>
          <?php } ?>
          <?php if (in_array('all_prod_qty_refund', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_prod_qty_refunded; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_qty_refund']; ?></td>
          <?php } ?>   
          <?php if (in_array('all_prod_refund', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_prod_refunded; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_refund']; ?></td>
          <?php } ?>       
          <?php if (in_array('all_prod_reward_points', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_prod_reward_points; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['product_reward_points']; ?></td>
          <?php } ?>
          <?php if (in_array('all_sub_total', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_sub_total; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_sub_total']; ?></td>
          <?php } ?>
          <?php if (in_array('all_handling', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_handling; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_handling']; ?></td>
          <?php } ?>
          <?php if (in_array('all_loworder', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_loworder; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_low_order_fee']; ?></td>
          <?php } ?>                    
          <?php if (in_array('all_shipping', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_shipping; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_shipping']; ?></td>
          <?php } ?>
          <?php if (in_array('all_reward', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_reward; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_reward']; ?></td>
          <?php } ?>
          <?php if (in_array('all_reward_points', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_earned_reward_points; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_earned_points']; ?></td>
          <?php } ?> 
          <?php if (in_array('all_reward_points', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_used_reward_points; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_used_points']; ?></td>
          <?php } ?>            
          <?php if (in_array('all_coupon', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_coupon; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_coupon']; ?></td>
          <?php } ?>
          <?php if (in_array('all_coupon_code', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap" title="<?php echo $column_coupon_code; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_coupon_code']; ?></td>
          <?php } ?>                              
          <?php if (in_array('all_order_tax', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_order_tax; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_tax']; ?></td>
          <?php } ?>
          <?php if (in_array('all_credit', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_credit; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_credit']; ?></td>
          <?php } ?>
          <?php if (in_array('all_voucher', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_voucher; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_voucher']; ?></td>
          <?php } ?>
          <?php if (in_array('all_voucher_code', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap" title="<?php echo $column_voucher_code; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_voucher_code']; ?></td>
          <?php } ?>         
          <?php if (in_array('all_order_commission', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_commission; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_commission']; ?></td>
          <?php } ?>          
          <?php if (in_array('all_order_value', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_order_value; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_value']; ?></td>
          <?php } ?>
          <?php if (in_array('all_refund', $advpp_settings_all_columns)) { ?>          
          <td class="right" nowrap="nowrap" title="<?php echo $column_order_refund; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_refund']; ?></td>
          <?php } ?>
          <?php if (in_array('all_order_shipping_method', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap" title="<?php echo $column_order_shipping_method; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['shipping_method']; ?></td>
          <?php } ?>
          <?php if (in_array('all_order_payment_method', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap" title="<?php echo $column_order_payment_method; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['payment_method']; ?></td>
          <?php } ?>
          <?php if (in_array('all_order_status', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap" title="<?php echo $column_order_status; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_status']; ?></td>
          <?php } ?>
          <?php if (in_array('all_order_store', $advpp_settings_all_columns)) { ?>          
          <td class="left" nowrap="nowrap" title="<?php echo $column_order_store; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['store_name']; ?></td> 
          <?php } ?>
          <?php if (in_array('all_customer_cust_id', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo $column_customer_cust_id; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]">
          <?php if ($product['customer_id'] == 0) { ?>
          <?php echo $product['customer_id']; ?>       
          <?php } else { ?>
          <?php echo $product['customer_id_link']; ?>
          <?php } ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_name', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_billing_first_name); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['payment_firstname']; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_name', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_billing_last_name); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['payment_lastname']; ?></td>
          <?php } ?>          
          <?php if (in_array('all_billing_company', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_billing_company); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['payment_company']; ?></td> 
          <?php } ?>
          <?php if (in_array('all_billing_address_1', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_billing_address_1); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['payment_address_1']; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_address_2', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_billing_address_2); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['payment_address_2']; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_city', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_billing_city); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['payment_city']; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_zone', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_billing_zone); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['payment_zone']; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_zone_id', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_billing_zone_id); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['payment_zone_id']; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_zone_code', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_billing_zone_code); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['payment_zone_code']; ?></td>
          <?php } ?>                    
          <?php if (in_array('all_billing_postcode', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_billing_postcode); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['payment_postcode']; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_country', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_billing_country); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['payment_country']; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_country_id', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_billing_country_id); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['payment_country_id']; ?></td>
          <?php } ?>
          <?php if (in_array('all_billing_country_code', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_billing_country_code); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['payment_country_code']; ?></td>
          <?php } ?>                    
          <?php if (in_array('all_customer_telephone', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo $column_customer_telephone; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['telephone']; ?></td> 
          <?php } ?>
          <?php if (in_array('all_shipping_name', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_shipping_first_name); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['shipping_firstname']; ?></td>
          <?php } ?>
          <?php if (in_array('all_shipping_name', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_shipping_last_name); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['shipping_lastname']; ?></td>
          <?php } ?>          
          <?php if (in_array('all_shipping_company', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_shipping_company); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['shipping_company']; ?></td>
          <?php } ?>
          <?php if (in_array('all_shipping_address_1', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_shipping_address_1); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['shipping_address_1']; ?></td>
          <?php } ?>
          <?php if (in_array('all_shipping_address_2', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_shipping_address_2); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['shipping_address_2']; ?></td> 
          <?php } ?>
          <?php if (in_array('all_shipping_city', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_shipping_city); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['shipping_city']; ?></td> 
          <?php } ?>                
          <?php if (in_array('all_shipping_zone', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_shipping_zone); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['shipping_zone']; ?></td> 
          <?php } ?>
          <?php if (in_array('all_shipping_zone_id', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_shipping_zone_id); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['shipping_zone_id']; ?></td> 
          <?php } ?>
          <?php if (in_array('all_shipping_zone_code', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_shipping_zone_code); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['shipping_zone_code']; ?></td> 
          <?php } ?>                    
          <?php if (in_array('all_shipping_postcode', $advpp_settings_all_columns)) { ?>           
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_shipping_postcode); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['shipping_postcode']; ?></td>
          <?php } ?>
          <?php if (in_array('all_shipping_country', $advpp_settings_all_columns)) { ?> 
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_shipping_country); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['shipping_country']; ?></td>
          <?php } ?>
          <?php if (in_array('all_shipping_country_id', $advpp_settings_all_columns)) { ?> 
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_shipping_country_id); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['shipping_country_id']; ?></td>
          <?php } ?>
          <?php if (in_array('all_shipping_country_code', $advpp_settings_all_columns)) { ?> 
          <td class="left" nowrap="nowrap" title="<?php echo strip_tags($column_shipping_country_code); ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['shipping_country_code']; ?></td>
          <?php } ?>                    
          <?php if (in_array('all_order_weight', $advpp_settings_all_columns)) { ?> 
          <td class="right" nowrap="nowrap" title="<?php echo $column_order_weight; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_weight']; ?></td>
          <?php } ?>           
          <?php if (in_array('all_order_comment', $advpp_settings_all_columns)) { ?> 
          <td class="left" nowrap="nowrap" title="<?php echo $column_order_comment; ?> [<?php echo $column_order_order_id; ?>: <?php echo $product['order_id']; ?>]"><?php echo $product['order_comment']; ?></td>
          <?php } ?>              
          </tr>   
	<?php } ?>
	<?php } ?>
	      </table>            
		</td>               
		</tr>       
    	</tbody>         
		</table>
	<?php } else { ?>
		<table width="100%">    
		<tr>
		<td align="center"><?php echo $text_no_results; ?></td>
		</tr>
        </table>          
	<?php } ?>      
    </td></tr>
    </table>  
<?php } ?>
<?php if ($filter_details != 'all_details') { ?>
    <table class="list_main">
        <thead>
          <tr>
          <?php if ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') { ?>
          <td class="left" nowrap="nowrap"><?php echo $column_date_added; ?></td>
          <?php } else { ?> 
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
          <?php } ?>
          <?php if ($filter_report != 'manufacturers' && $filter_report != 'categories') { ?>  
          <?php if (in_array('mv_id', $advpp_settings_mv_columns)) { ?>            
          <td class="right"><?php echo $column_id; ?></td>
          <?php } ?>   
          <?php if (in_array('mv_image', $advpp_settings_mv_columns)) { ?>            
          <td class="center"><?php echo $column_image; ?></td>
          <?php } ?>   
          <?php if (in_array('mv_sku', $advpp_settings_mv_columns)) { ?>            
          <td class="left"><?php echo $column_sku; ?></td>
          <?php } ?>   
          <?php if (in_array('mv_name', $advpp_settings_mv_columns)) { ?>            
          <td class="left"><?php if ($filter_report == 'products_purchased_with_options') { ?><?php echo $column_name; ?><?php } else { ?><?php echo $column_prod_name; ?><?php } ?></td>
          <?php } ?>     
          <?php if (in_array('mv_model', $advpp_settings_mv_columns)) { ?>            
          <td class="left"><?php echo $column_model; ?></td>
          <?php } ?>   
          <?php if (in_array('mv_category', $advpp_settings_mv_columns)) { ?>            
          <td class="left"><?php echo $column_category; ?></td>
          <?php } ?>   
          <?php if (in_array('mv_manufacturer', $advpp_settings_mv_columns)) { ?>
          <td class="left"><?php echo $column_manufacturer; ?></td>
          <?php } ?>
          <?php if (in_array('mv_attribute', $advpp_settings_mv_columns)) { ?>
          <td class="left"><?php echo $column_attribute; ?></td>
          <?php } ?>
          <?php if (in_array('mv_status', $advpp_settings_mv_columns)) { ?>          
          <td class="left"><?php echo $column_status; ?></td> 
          <?php } ?>
          <?php if (in_array('mv_location', $advpp_settings_mv_columns)) { ?>            
          <td class="left"><?php echo $column_location; ?></td>
          <?php } ?>   
          <?php if (in_array('mv_tax_class', $advpp_settings_mv_columns)) { ?>          
          <td class="left"><?php echo $column_tax_class; ?></td>
          <?php } ?>                    
          <?php if (in_array('mv_price', $advpp_settings_mv_columns)) { ?>          
          <td class="right"><?php echo $column_price; ?></td>
          <?php } ?>
          <?php if (in_array('mv_viewed', $advpp_settings_mv_columns)) { ?>          
          <td class="right"><?php echo $column_viewed; ?></td> 
          <?php } ?>           
          <?php if (in_array('mv_stock_quantity', $advpp_settings_mv_columns)) { ?>                           
          <td class="right"><?php echo $column_stock_quantity; ?></td>
          <?php } ?>
          <?php } elseif ($filter_report == 'manufacturers') { ?> 
          <?php if (in_array('mv_manufacturer', $advpp_settings_mv_columns)) { ?>
          <td class="left"><?php echo $column_manufacturer; ?></td>
          <?php } ?>
		  <?php } elseif ($filter_report == 'categories') { ?>
          <?php if (in_array('mv_category', $advpp_settings_mv_columns)) { ?>            
          <td class="left"><?php echo $column_category; ?></td>
          <?php } ?>   
		  <?php } ?>  
          <?php if ($filter_report != 'products_without_orders') { ?> 
          <?php if (in_array('mv_sold_quantity', $advpp_settings_mv_columns)) { ?>          
          <td class="right"><?php echo $column_sold_quantity; ?></td>
          <?php } ?>                  
          <?php if (in_array('mv_sold_percent', $advpp_settings_mv_columns)) { ?>          
          <td class="right"><?php echo $column_sold_percent; ?></td>
          <?php } ?>          
          <?php if (in_array('mv_total_excl_vat', $advpp_settings_mv_columns)) { ?>          
          <td class="right" style="min-width:75px;"><?php echo $column_prod_total_excl_vat; ?></td>
          <?php } ?>
          <?php if (in_array('mv_total_tax', $advpp_settings_mv_columns)) { ?>          
          <td class="right"><?php echo $column_total_tax; ?></td>
          <?php } ?>
          <?php if (in_array('mv_total_incl_vat', $advpp_settings_mv_columns)) { ?>          
          <td class="right" style="min-width:75px;"><?php echo $column_prod_total_incl_vat; ?></td>
          <?php } ?>                 
          <?php if (in_array('mv_app', $advpp_settings_mv_columns)) { ?>          
          <td class="right" style="min-width:90px;"><?php echo $column_app; ?></td>
          <?php } ?>
          <?php if (in_array('mv_refunds', $advpp_settings_mv_columns)) { ?>          
          <td class="right"><?php echo $column_product_refunds; ?></td>
          <?php } ?>
          <?php if (in_array('mv_reward_points', $advpp_settings_mv_columns)) { ?>          
          <td class="right"><?php echo $column_product_reward_points; ?></td>
          <?php } ?>
          <?php if ($filter_details == 'basic_details') { ?><td class="right" nowrap="nowrap"> <span class="toggle-all expand" title="<?php echo $button_toggle; ?>" style="cursor:pointer;"><?php echo $column_action; ?><a id="circle" class="desc"></a></span></td><?php } ?>
          <?php } ?>
          </tr>
      	  </thead>
          <?php if ($products) { ?>
          <?php foreach ($products as $product) { ?>
      	  <tbody>
          <tr <?php echo ($filter_details == 'basic_details') ? 'style="cursor:pointer;" title="' . $text_detail . '"' : '' ?> id="show_details_<?php echo $product['order_product_id']; ?>">     
          <?php if ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') { ?>
          <td class="left" nowrap="nowrap" style="background-color:#F9F9F9;"><?php echo $product['date_added']; ?></td>  
          <?php } else { ?>             
		  <?php if ($filter_group == 'year') { ?>           
          <td class="left" colspan="2" nowrap="nowrap" style="background-color:#F9F9F9;"><?php echo $product['year']; ?></td>
		  <?php } elseif ($filter_group == 'quarter') { ?> 
          <td class="left" nowrap="nowrap" style="background-color:#F9F9F9;"><?php echo $product['year']; ?></td>
          <td class="left" nowrap="nowrap" style="background-color:#F9F9F9;"><?php echo $product['quarter']; ?></td>  
		  <?php } elseif ($filter_group == 'month') { ?> 
          <td class="left" nowrap="nowrap" style="background-color:#F9F9F9;"><?php echo $product['year']; ?></td>
          <td class="left" nowrap="nowrap" style="background-color:#F9F9F9;"><?php echo $product['month']; ?></td>
		  <?php } elseif ($filter_group == 'day') { ?> 
          <td class="left" colspan="2" nowrap="nowrap" style="background-color:#F9F9F9;"><?php echo $product['date_start']; ?></td>
		  <?php } elseif ($filter_group == 'order') { ?> 
          <td class="left" nowrap="nowrap" style="background-color:#F9F9F9;"><?php echo $product['order_id']; ?></td>
          <td class="left" nowrap="nowrap" style="background-color:#F9F9F9;"><?php echo $product['date_start']; ?></td>         
		  <?php } else { ?>    
          <td class="left" nowrap="nowrap" style="background-color:#F9F9F9;"><?php echo $product['date_start']; ?></td>
          <td class="left" nowrap="nowrap" style="background-color:#F9F9F9;"><?php echo $product['date_end']; ?></td>         
		  <?php } ?>
          <?php } ?>
          <?php if ($filter_report != 'manufacturers' && $filter_report != 'categories') { ?> 
          <?php if (in_array('mv_id', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $product['product_id']; ?></td>
          <?php } ?>  
          <?php if (in_array('mv_image', $advpp_settings_mv_columns)) { ?>          
          <td class="center" nowrap="nowrap"><img src="<?php echo $product['image']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
          <?php } ?>   
          <?php if (in_array('mv_sku', $advpp_settings_mv_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['sku']; ?></td>
          <?php } ?>  
          <?php if (in_array('mv_name', $advpp_settings_mv_columns)) { ?>          
          <td class="left" nowrap="nowrap">
          <?php if ($product['status'] != NULL) { ?>
          <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
          <?php } else { ?>
          <?php echo $product['name']; ?>
          <?php } ?>
          <?php if ($filter_report == 'products_purchased_with_options') { ?>
          <?php if ($product['option']) { ?>          
          <div style="display:table; margin-left:3px;">
          <?php foreach ($product['option'] as $option) { ?>            
          <div style="display:table-row; white-space:nowrap;">         
		  <div style="display:table-cell; white-space:nowrap;"><small><?php echo $option['name']; ?>:</small></div>
          <div style="display:table-cell; white-space:nowrap; padding-left:5px;"><small><?php echo $option['value']; ?></small></div>
          </div>
          <?php } ?>
          </div>
          <?php } ?><?php } ?></td>          
          <?php } ?>    
          <?php if (in_array('mv_model', $advpp_settings_mv_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['model']; ?></td>
          <?php } ?> 
          <?php if (in_array('mv_category', $advpp_settings_mv_columns)) { ?>          
          <td class="left" nowrap="nowrap">
          <?php foreach ($categories as $category) { ?>
          <?php if (in_array($category['category_id'], $product['category'])) { ?>
          <?php echo $category['name'];?><br />
          <?php } ?> <?php } ?></td>  
          <?php } ?>
          <?php if (in_array('mv_manufacturer', $advpp_settings_mv_columns)) { ?>          
          <td class="left" nowrap="nowrap">
		  <?php foreach ($manufacturers as $manufacturer) { ?>
          <?php if (in_array($manufacturer['manufacturer_id'], $product['manufacturer'])) { ?>
          <?php echo $manufacturer['name'];?>
          <?php } ?> <?php } ?></td>          
          <?php } ?>
          <?php if (in_array('mv_attribute', $advpp_settings_mv_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['attribute']; ?></td>
          <?php } ?>
          <?php if (in_array('mv_status', $advpp_settings_mv_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['status']; ?></td>
          <?php } ?>
          <?php if (in_array('mv_location', $advpp_settings_mv_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['location']; ?></td>
          <?php } ?>  
          <?php if (in_array('mv_tax_class', $advpp_settings_mv_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['tax_class']; ?></td>
          <?php } ?>                     
          <?php if (in_array('mv_price', $advpp_settings_mv_columns)) { ?>           
          <td class="right" nowrap="nowrap"><?php echo $product['price']; ?></td>  
          <?php } ?>  
          <?php if (in_array('mv_viewed', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $product['viewed']; ?></td>
          <?php } ?>           
          <?php if (in_array('mv_stock_quantity', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap">
          <?php if ($product['stock_quantity'] <= 0) { ?>
		  <span style="color:#FF0000;"><?php echo $product['stock_quantity']; ?></span>
		  <?php } elseif ($product['stock_quantity'] <= 5) { ?>
		  <span style="color:#FFA500;"><?php echo $product['stock_quantity']; ?></span>
		  <?php } else { ?>
		  <?php echo $product['stock_quantity']; ?>
		  <?php } ?>
		  <?php if ($filter_report == 'products_purchased_with_options') { ?> 
		  <?php if ($product['option']) { ?><br />
		  <small><?php echo $product['stock_oquantity']; ?></small>
		  <?php } ?>
		  <?php } ?></td>
          <?php } ?>
          <?php } elseif ($filter_report == 'manufacturers') { ?> 
          <?php if (in_array('mv_manufacturer', $advpp_settings_mv_columns)) { ?>          
          <td class="left" nowrap="nowrap">
		  <?php foreach ($manufacturers as $manufacturer) { ?>
          <?php if (in_array($manufacturer['manufacturer_id'], $product['manufacturer'])) { ?>
          <?php echo $manufacturer['name'];?>
          <?php } ?> <?php } ?></td>          
          <?php } ?>
		  <?php } elseif ($filter_report == 'categories') { ?>
          <?php if (in_array('mv_category', $advpp_settings_mv_columns)) { ?>          
          <td class="left" nowrap="nowrap">
          <?php foreach ($categories as $category) { ?>
          <?php if (in_array($category['category_id'], $product['category'])) { ?>
          <?php echo $category['name'];?><br />
          <?php } ?> <?php } ?></td>  
          <?php } ?>  
		  <?php } ?>   
          <?php if ($filter_report != 'products_without_orders') { ?>        
          <?php if (in_array('mv_sold_quantity', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap" style="background-color:#FFC;"><?php echo $product['sold_quantity']; ?></td>
          <?php } ?>
          <?php if (in_array('mv_sold_percent', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap" style="background-color:#FFC;"><?php echo $product['sold_percent']; ?></td>
          <?php } ?>
          <?php if (in_array('mv_total_excl_vat', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $product['total_excl_vat']; ?></td>
          <?php } ?>
          <?php if (in_array('mv_total_tax', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $product['total_tax']; ?></td>
          <?php } ?>
          <?php if (in_array('mv_total_incl_vat', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $product['total_incl_vat']; ?></td>
          <?php } ?>    
          <?php if (in_array('mv_app', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $product['app']; ?></td>
          <?php } ?> 
          <?php if (in_array('mv_refunds', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $product['refunds']; ?></td>
          <?php } ?> 
          <?php if (in_array('mv_reward_points', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $product['reward_points']; ?></td>
          <?php } ?>
          <?php if ($filter_details == 'basic_details') { ?><td class="right" nowrap="nowrap">[ <a><?php echo $text_detail; ?></a> ]</td><?php } ?> 
          <?php } ?>
          </tr>        
<tr>
<td colspan="25" class="center">
<?php if (($filter_report == 'products_purchased_without_options' or $filter_report == 'products_purchased_with_options' or $filter_report == 'new_products_purchased' or $filter_report == 'old_products_purchased') && $filter_details == 'basic_details') { ?>
<script type="text/javascript">
$('#show_details_<?php echo $product["order_product_id"]; ?>').click(function() {
	$('#tab_details_<?php echo $product["order_product_id"]; ?>').slideToggle('slow');
});
</script>
<div id="tab_details_<?php echo $product['order_product_id']; ?>" class="more" style="display:none;">
    <table class="list_detail">
      <thead>
        <tr>
          <?php if (in_array('ol_order_order_id', $advpp_settings_ol_columns)) { ?>
          <td class="left" nowrap="nowrap"><?php echo $column_order_order_id; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_date_added', $advpp_settings_ol_columns)) { ?>
          <td class="left" nowrap="nowrap"><?php echo $column_order_date_added; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_inv_no', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_order_inv_no; ?></td> 
          <?php } ?>
          <?php if (in_array('ol_order_customer', $advpp_settings_ol_columns)) { ?>                           
          <td class="left" nowrap="nowrap"><?php echo $column_order_customer; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_email', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_order_email; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_customer_group', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_order_customer_group; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_shipping_method', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_order_shipping_method; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_payment_method', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_order_payment_method; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_status', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_order_status; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_store', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_order_store; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_currency', $advpp_settings_ol_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_order_currency; ?></td>
          <?php } ?>
          <?php if (in_array('ol_prod_price', $advpp_settings_ol_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_prod_price; ?></td>
          <?php } ?>
          <?php if (in_array('ol_prod_quantity', $advpp_settings_ol_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_prod_quantity; ?></td>  
          <?php } ?>          
          <?php if (in_array('ol_prod_total_excl_vat', $advpp_settings_ol_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_prod_total_excl_vat; ?></td>
          <?php } ?>
          <?php if (in_array('ol_prod_tax', $advpp_settings_ol_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_prod_tax; ?></td>
          <?php } ?>
          <?php if (in_array('ol_prod_total_incl_vat', $advpp_settings_ol_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_prod_total_incl_vat; ?></td>
          <?php } ?>
        </tr>
      </thead>
        <tr bgcolor="#FFFFFF">
          <?php if (in_array('ol_order_order_id', $advpp_settings_ol_columns)) { ?>
          <td class="left" nowrap="nowrap" style="background-color:#FFC;"><a><?php echo $product['order_prod_ord_id_link']; ?></a></td>
          <?php } ?>
          <?php if (in_array('ol_order_date_added', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['order_prod_ord_date']; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_inv_no', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['order_prod_inv_no']; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_customer', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['order_prod_name']; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_email', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['order_prod_email']; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_customer_group', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['order_prod_group']; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_shipping_method', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['order_prod_shipping_method']; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_payment_method', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['order_prod_payment_method']; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_status', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['order_prod_status']; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_store', $advpp_settings_ol_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['order_prod_store']; ?></td>
          <?php } ?>
          <?php if (in_array('ol_order_currency', $advpp_settings_ol_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $product['order_prod_currency']; ?></td>
          <?php } ?>
          <?php if (in_array('ol_prod_price', $advpp_settings_ol_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $product['order_prod_price']; ?></td>
          <?php } ?>
          <?php if (in_array('ol_prod_quantity', $advpp_settings_ol_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $product['order_prod_quantity']; ?></td>
          <?php } ?>
          <?php if (in_array('ol_prod_total_excl_vat', $advpp_settings_ol_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $product['order_prod_total_excl_vat']; ?></td>
          <?php } ?>
          <?php if (in_array('ol_prod_tax', $advpp_settings_ol_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $product['order_prod_tax']; ?></td>
          <?php } ?>
          <?php if (in_array('ol_prod_total_incl_vat', $advpp_settings_ol_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $product['order_prod_total_incl_vat']; ?></td>
          <?php } ?>
         </tr>
    </table> 
<?php } ?>    
<?php if (($filter_report == 'manufacturers' or $filter_report == 'categories') && $filter_details == 'basic_details') { ?>
<script type="text/javascript">$(function(){ 
$('#show_details_<?php echo $product["order_product_id"]; ?>').click(function() {
		$('#tab_details_<?php echo $product["order_product_id"]; ?>').slideToggle('slow');
	});
});
</script>
<div id="tab_details_<?php echo $product['order_product_id']; ?>" class="more" style="display:none">
    <table class="list_detail">
      <thead>
        <tr>
          <?php if (in_array('pl_prod_order_id', $advpp_settings_pl_columns)) { ?>
          <td class="left" nowrap="nowrap"><?php echo $column_prod_order_id; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_date_added', $advpp_settings_pl_columns)) { ?>
          <td class="left" nowrap="nowrap"><?php echo $column_prod_date_added; ?></td>
          <?php } ?> 
          <?php if (in_array('pl_prod_inv_no', $advpp_settings_pl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_prod_inv_no; ?></td>
          <?php } ?>                 
          <?php if (in_array('pl_prod_id', $advpp_settings_pl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_prod_id; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_sku', $advpp_settings_pl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_prod_sku; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_model', $advpp_settings_pl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_prod_model; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_name', $advpp_settings_pl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_prod_name; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_option', $advpp_settings_pl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_prod_option; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_attributes', $advpp_settings_pl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_prod_attributes; ?></td>
          <?php } ?>
          <?php if ($filter_report == 'categories') { ?>          
          <?php if (in_array('pl_prod_manu', $advpp_settings_pl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_prod_manu; ?></td>
          <?php } ?>
          <?php } ?>
          <?php if ($filter_report == 'manufacturers') { ?>          
          <?php if (in_array('pl_prod_category', $advpp_settings_pl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_prod_category; ?></td>
          <?php } ?>
          <?php } ?>
          <?php if (in_array('pl_prod_currency', $advpp_settings_pl_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_prod_currency; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_price', $advpp_settings_pl_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_prod_price; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_quantity', $advpp_settings_pl_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_prod_quantity; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_total_excl_vat', $advpp_settings_pl_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_prod_total_excl_vat; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_tax', $advpp_settings_pl_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_prod_tax; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_total_incl_vat', $advpp_settings_pl_columns)) { ?>          
          <td class="right" nowrap="nowrap"><?php echo $column_prod_total_incl_vat; ?></td>
          <?php } ?>
        </tr>
      </thead>
        <tr bgcolor="#FFFFFF">
          <?php if (in_array('pl_prod_order_id', $advpp_settings_pl_columns)) { ?>
          <td class="left" nowrap="nowrap" style="background-color:#FFC;"><a><?php echo $product['product_ord_id_link']; ?></a></td>
          <?php } ?>
          <?php if (in_array('pl_prod_date_added', $advpp_settings_pl_columns)) { ?>
          <td class="left" nowrap="nowrap"><?php echo $product['product_ord_date']; ?></td>
          <?php } ?> 
          <?php if (in_array('pl_prod_inv_no', $advpp_settings_pl_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $product['product_inv_no']; ?></td>
          <?php } ?>     
          <?php if (in_array('pl_prod_id', $advpp_settings_pl_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $product['product_prod_id_link']; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_sku', $advpp_settings_pl_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $product['product_sku']; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_model', $advpp_settings_pl_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $product['product_model']; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_name', $advpp_settings_pl_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $product['product_name']; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_option', $advpp_settings_pl_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $product['product_option']; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_attributes', $advpp_settings_pl_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $product['product_attributes']; ?></td>
          <?php } ?>
          <?php if ($filter_report == 'categories') { ?>          
          <?php if (in_array('pl_prod_manu', $advpp_settings_pl_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $product['product_manu']; ?></td>
          <?php } ?>
          <?php } ?>
          <?php if ($filter_report == 'manufacturers') { ?>          
          <?php if (in_array('pl_prod_category', $advpp_settings_pl_columns)) { ?>           
          <td class="left" nowrap="nowrap"><?php echo $product['product_category']; ?></td>
          <?php } ?>
          <?php } ?>            
          <?php if (in_array('pl_prod_currency', $advpp_settings_pl_columns)) { ?>           
          <td class="right" nowrap="nowrap"><?php echo $product['product_currency']; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_price', $advpp_settings_pl_columns)) { ?>           
          <td class="right" nowrap="nowrap"><?php echo $product['product_price']; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_quantity', $advpp_settings_pl_columns)) { ?>           
          <td class="right" nowrap="nowrap"><?php echo $product['product_quantity']; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_total_excl_vat', $advpp_settings_pl_columns)) { ?>           
          <td class="right" nowrap="nowrap"><?php echo $product['product_total_excl_vat']; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_tax', $advpp_settings_pl_columns)) { ?>           
          <td class="right" nowrap="nowrap"><?php echo $product['product_tax']; ?></td>
          <?php } ?>
          <?php if (in_array('pl_prod_total_incl_vat', $advpp_settings_pl_columns)) { ?>           
          <td class="right" nowrap="nowrap"><?php echo $product['product_total_incl_vat']; ?></td>
          <?php } ?>        
         </tr>       
    </table>
<?php } ?>
<?php if ($filter_details == 'basic_details') { ?>   
    <table class="list_detail">
      <thead>
        <tr>
          <?php if (in_array('cl_customer_order_id', $advpp_settings_cl_columns)) { ?>
          <td class="left" nowrap="nowrap"><?php echo $column_customer_order_id; ?></td>
          <?php } ?>
          <?php if (in_array('cl_customer_date_added', $advpp_settings_cl_columns)) { ?>
          <td class="left" nowrap="nowrap"><?php echo $column_customer_date_added; ?></td>
          <?php } ?>         
          <?php if (in_array('cl_customer_cust_id', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_customer_cust_id; ?></td>
          <?php } ?>
          <?php if (in_array('cl_billing_name', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_billing_name; ?></td>
          <?php } ?>
          <?php if (in_array('cl_billing_company', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_billing_company; ?></td>
          <?php } ?>
          <?php if (in_array('cl_billing_address_1', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_billing_address_1; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_billing_address_2', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_billing_address_2; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_billing_city', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_billing_city; ?></td>
          <?php } ?>
          <?php if (in_array('cl_billing_zone', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_billing_zone; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_billing_postcode', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_billing_postcode; ?></td>
          <?php } ?>
          <?php if (in_array('cl_billing_country', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_billing_country; ?></td>
          <?php } ?>
          <?php if (in_array('cl_customer_telephone', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_customer_telephone; ?></td>
          <?php } ?>
          <?php if (in_array('cl_shipping_name', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_name; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_shipping_company', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_company; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_shipping_address_1', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_address_1; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_shipping_address_2', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_address_2; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_shipping_city', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_city; ?></td>
          <?php } ?>
          <?php if (in_array('cl_shipping_zone', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_zone; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_shipping_postcode', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_postcode; ?></td>
          <?php } ?>
          <?php if (in_array('cl_shipping_country', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $column_shipping_country; ?></td>
          <?php } ?>          
        </tr>
      </thead>
        <tr bgcolor="#FFFFFF">
          <?php if (in_array('cl_customer_order_id', $advpp_settings_cl_columns)) { ?>
          <td class="left" nowrap="nowrap" style="background-color:#FFC;"><a><?php echo $product['customer_ord_id_link']; ?></a></td>
          <?php } ?>
          <?php if (in_array('cl_customer_date_added', $advpp_settings_cl_columns)) { ?>
          <td class="left" nowrap="nowrap"><?php echo $product['customer_ord_date']; ?></td>
          <?php } ?>          
          <?php if (in_array('cl_customer_cust_id', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['customer_cust_id_link']; ?></td>
          <?php } ?>
          <?php if (in_array('cl_billing_name', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['billing_name']; ?></td>
          <?php } ?>
          <?php if (in_array('cl_billing_company', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['billing_company']; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_billing_address_1', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['billing_address_1']; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_billing_address_2', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['billing_address_2']; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_billing_city', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['billing_city']; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_billing_zone', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['billing_zone']; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_billing_postcode', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['billing_postcode']; ?></td>
          <?php } ?>
          <?php if (in_array('cl_billing_country', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['billing_country']; ?></td>
          <?php } ?>
          <?php if (in_array('cl_customer_telephone', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['customer_telephone']; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_shipping_name', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['shipping_name']; ?></td>
          <?php } ?>
          <?php if (in_array('cl_shipping_company', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['shipping_company']; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_shipping_address_1', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['shipping_address_1']; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_shipping_address_2', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['shipping_address_2']; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_shipping_city', $advpp_settings_cl_columns)) { ?>
          <td class="left" nowrap="nowrap"><?php echo $product['shipping_city']; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_shipping_zone', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['shipping_zone']; ?></td> 
          <?php } ?>
          <?php if (in_array('cl_shipping_postcode', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['shipping_postcode']; ?></td>
          <?php } ?>
          <?php if (in_array('cl_shipping_country', $advpp_settings_cl_columns)) { ?>          
          <td class="left" nowrap="nowrap"><?php echo $product['shipping_country']; ?></td>
          <?php } ?>           
         </tr>
    </table>
</div> 
<?php } ?>
</td>
</tr>
          <?php } ?>
<?php if ($filter_report != 'products_without_orders') { ?>            
        <tr>
        <td colspan="25"></td>
        </tr>
        <tr>
          <td <?php echo ($filter_report == 'all_products_with_without_orders') ? '' : 'colspan="2"' ?> class="right" style="background-color:#E5E5E5;"><strong><?php echo $text_filter_total; ?></strong></td>
          <?php if ($filter_report != 'manufacturers' && $filter_report != 'categories') { ?> 
          <?php if (in_array('mv_id', $advpp_settings_mv_columns)) { ?>
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>
          <?php if (in_array('mv_image', $advpp_settings_mv_columns)) { ?>
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>
          <?php if (in_array('mv_sku', $advpp_settings_mv_columns)) { ?>
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>
          <?php if (in_array('mv_name', $advpp_settings_mv_columns)) { ?>
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>
          <?php if (in_array('mv_model', $advpp_settings_mv_columns)) { ?>
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>
          <?php if (in_array('mv_category', $advpp_settings_mv_columns)) { ?>
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>
          <?php if (in_array('mv_manufacturer', $advpp_settings_mv_columns)) { ?>
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>
          <?php if (in_array('mv_attribute', $advpp_settings_mv_columns)) { ?>
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>
          <?php if (in_array('mv_status', $advpp_settings_mv_columns)) { ?>
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>

          <?php if (in_array('mv_location', $advpp_settings_mv_columns)) { ?>
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>
          <?php if (in_array('mv_tax_class', $advpp_settings_mv_columns)) { ?>
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>
          <?php if (in_array('mv_price', $advpp_settings_mv_columns)) { ?>
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>
          <?php if (in_array('mv_viewed', $advpp_settings_mv_columns)) { ?>
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>                                                                      
          <?php if (in_array('mv_stock_quantity', $advpp_settings_mv_columns)) { ?>          
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>  
          <?php } elseif ($filter_report == 'manufacturers') { ?> 
          <?php if (in_array('mv_manufacturer', $advpp_settings_mv_columns)) { ?>
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>
		  <?php } elseif ($filter_report == 'categories') { ?>
          <?php if (in_array('mv_category', $advpp_settings_mv_columns)) { ?>
          <td style="background-color:#E5E5E5;"></td>
          <?php } ?>
		  <?php } ?>  
          <?php if ($filter_report != 'products_without_orders') { ?>          
          <?php if (in_array('mv_sold_quantity', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap" style="background-color:#E7EFEF; color:#003A88;"><strong><?php echo $product['sold_quantity_total']; ?></strong></td>
          <?php } ?>
          <?php if (in_array('mv_sold_percent', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap" style="background-color:#E7EFEF; color:#003A88;"><strong><?php echo $product['sold_percent_total']; ?></strong></td>
          <?php } ?>
          <?php if (in_array('mv_total_excl_vat', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap" style="background-color:#E7EFEF; color:#003A88;"><strong><?php echo $product['total_excl_vat_total']; ?></strong></td>
          <?php } ?>
          <?php if (in_array('mv_total_tax', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap" style="background-color:#E7EFEF; color:#003A88;"><strong><?php echo $product['total_tax_total']; ?></strong></td>
          <?php } ?>
          <?php if (in_array('mv_total_incl_vat', $advpp_settings_mv_columns)) { ?>          
          <td class="right" nowrap="nowrap" style="background-color:#E7EFEF; color:#003A88;"><strong><?php echo $product['total_incl_vat_total']; ?></strong></td>
          <?php } ?>               
          <?php if (in_array('mv_app', $advpp_settings_mv_columns)) { ?>            
          <td class="right" nowrap="nowrap" style="background-color:#E7EFEF; color:#003A88;"><strong><?php echo $product['app_total']; ?></strong></td>
          <?php } ?>
          <?php if (in_array('mv_refunds', $advpp_settings_mv_columns)) { ?>            
          <td class="right" nowrap="nowrap" style="background-color:#E7EFEF; color:#003A88;"><strong><?php echo $product['refunds_total']; ?></strong></td>
          <?php } ?>
          <?php if (in_array('mv_reward_points', $advpp_settings_mv_columns)) { ?>            
          <td class="right" nowrap="nowrap" style="background-color:#E7EFEF; color:#003A88;"><strong><?php echo $product['reward_points_total']; ?></strong></td>
          <?php } ?>      
          <?php if ($filter_details == 'basic_details') { ?><td></td><?php } ?>   
          <?php } ?>                
        </tr>   
<?php } ?>                      
          <?php } else { ?>
          <tr>
          <td class="noresult" colspan="25"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>  
          </tbody>
      </table>
<?php } ?>
    </div> 
      <?php if ($products) { ?>    
       <div class="pagination"><?php echo $pagination; ?></div>
      <?php } ?>       
    </div>
    </div>    
  </div>
</div>  
<script type="text/javascript">
function filter() {
	url = 'index.php?route=report/adv_products&token=<?php echo $token; ?>';										 

	var filter_report = $('select[name=\'filter_report\']').val();
	if (filter_report) {
		url += '&filter_report=' + encodeURIComponent(filter_report);
	}
	
	var filter_group = $('select[name=\'filter_group\']').val();
	if (filter_group) {
		url += '&filter_group=' + encodeURIComponent(filter_group);
	}
	
	var filter_sort = $('select[name=\'filter_sort\']').val();
	if (filter_sort) {
		url += '&filter_sort=' + encodeURIComponent(filter_sort);
	}

	var filter_details = $('select[name=\'filter_details\']').val();
	if (filter_details) {
		url += '&filter_details=' + encodeURIComponent(filter_details);
	}
	
	var filter_limit = $('select[name=\'filter_limit\']').val();
	if (filter_limit) {
		url += '&filter_limit=' + encodeURIComponent(filter_limit);
	}
	
	var filter_range = $('select[name=\'filter_range\']').val();
	if (filter_range) {
		url += '&filter_range=' + encodeURIComponent(filter_range);
	}
	
	var filter_date_start = $('input[name=\'filter_date_start\']').val();
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').val();
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}

	var filter_status_date_start = $('input[name=\'filter_status_date_start\']').val();
	if (filter_status_date_start) {
		url += '&filter_status_date_start=' + encodeURIComponent(filter_status_date_start);
	}

	var filter_status_date_end = $('input[name=\'filter_status_date_end\']').val();
	if (filter_status_date_end) {
		url += '&filter_status_date_end=' + encodeURIComponent(filter_status_date_end);
	}
	
	var order_status_id = [];
	$('#filter_order_status_id option:selected').each(function() {
		order_status_id.push($(this).val());
	});
	var filter_order_status_id = order_status_id.join(',');
	if (filter_order_status_id) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}

	var filter_order_id_from = $('input[name=\'filter_order_id_from\']').val();
	if (filter_order_id_from) {
		url += '&filter_order_id_from=' + encodeURIComponent(filter_order_id_from);
	}

	var filter_order_id_to = $('input[name=\'filter_order_id_to\']').val();
	if (filter_order_id_to) {
		url += '&filter_order_id_to=' + encodeURIComponent(filter_order_id_to);
	}
	
	var store_id = [];
	$('#filter_store_id option:selected').each(function() {
		store_id.push($(this).val());
	});
	var filter_store_id = store_id.join(',');
	if (filter_store_id) {
		url += '&filter_store_id=' + encodeURIComponent(filter_store_id);
	}
	
	var currency = [];
	$('#filter_currency option:selected').each(function() {
		currency.push($(this).val());
	});
	var filter_currency = currency.join(',');
	if (filter_currency) {
		url += '&filter_currency=' + encodeURIComponent(filter_currency);
	}	
	
	var taxes = [];
	$('#filter_taxes option:selected').each(function() {
		taxes.push($(this).val());
	});
	var filter_taxes = taxes.join(',');
	if (filter_taxes) {
		url += '&filter_taxes=' + encodeURIComponent(filter_taxes);
	}

	var tax_classes = [];
	$('#filter_tax_classes option:selected').each(function() {
		tax_classes.push($(this).val());
	});
	var filter_tax_classes = tax_classes.join(',');
	if (filter_tax_classes) {
		url += '&filter_tax_classes=' + encodeURIComponent(filter_tax_classes);
	}

	var geo_zones = [];
	$('#filter_geo_zones option:selected').each(function() {
		geo_zones.push($(this).val());
	});
	var filter_geo_zones = geo_zones.join(',');
	if (filter_geo_zones) {
		url += '&filter_geo_zones=' + encodeURIComponent(filter_geo_zones);
	}
	
	var customer_group_id = [];
	$('#filter_customer_group_id option:selected').each(function() {
		customer_group_id.push($(this).val());
	});
	var filter_customer_group_id = customer_group_id.join(',');
	if (filter_customer_group_id) {
		url += '&filter_customer_group_id=' + encodeURIComponent(filter_customer_group_id);
	}
	
	var filter_customer_name = $('input[name=\'filter_customer_name\']').val();
	if (filter_customer_name) {
		url += '&filter_customer_name=' + encodeURIComponent(filter_customer_name);
	}

	var filter_customer_email = $('input[name=\'filter_customer_email\']').val();
	if (filter_customer_email) {
		url += '&filter_customer_email=' + encodeURIComponent(filter_customer_email);
	}
	
	var filter_customer_telephone = $('input[name=\'filter_customer_telephone\']').val();
	if (filter_customer_telephone) {
		url += '&filter_customer_telephone=' + encodeURIComponent(filter_customer_telephone);
	}
	
	var filter_ip = $('input[name=\'filter_ip\']').val();
	if (filter_ip) {
		url += '&filter_ip=' + encodeURIComponent(filter_ip);
	}
	
	var filter_payment_company = $('input[name=\'filter_payment_company\']').val();
	if (filter_payment_company) {
		url += '&filter_payment_company=' + encodeURIComponent(filter_payment_company);
	}
	
	var filter_payment_address = $('input[name=\'filter_payment_address\']').val();
	if (filter_payment_address) {
		url += '&filter_payment_address=' + encodeURIComponent(filter_payment_address);
	}
	
	var filter_payment_city = $('input[name=\'filter_payment_city\']').val();
	if (filter_payment_city) {
		url += '&filter_payment_city=' + encodeURIComponent(filter_payment_city);
	}

	var filter_payment_zone = $('input[name=\'filter_payment_zone\']').val();
	if (filter_payment_zone) {
		url += '&filter_payment_zone=' + encodeURIComponent(filter_payment_zone);
	}
	
	var filter_payment_postcode = $('input[name=\'filter_payment_postcode\']').val();
	if (filter_payment_postcode) {
		url += '&filter_payment_postcode=' + encodeURIComponent(filter_payment_postcode);
	}
	
	var filter_payment_country = $('input[name=\'filter_payment_country\']').val();
	if (filter_payment_country) {
		url += '&filter_payment_country=' + encodeURIComponent(filter_payment_country);
	}
	
	var payment_method = [];
	$('#filter_payment_method option:selected').each(function() {
		payment_method.push($(this).val());
	});
	var filter_payment_method = payment_method.join(',');

	if (filter_payment_method) {
		url += '&filter_payment_method=' + encodeURIComponent(filter_payment_method);
	}

	var filter_shipping_company = $('input[name=\'filter_shipping_company\']').val();
	if (filter_shipping_company) {
		url += '&filter_shipping_company=' + encodeURIComponent(filter_shipping_company);
	}
	
	var filter_shipping_address = $('input[name=\'filter_shipping_address\']').val();
	if (filter_shipping_address) {
		url += '&filter_shipping_address=' + encodeURIComponent(filter_shipping_address);
	}
	
	var filter_shipping_city = $('input[name=\'filter_shipping_city\']').val();
	if (filter_shipping_city) {
		url += '&filter_shipping_city=' + encodeURIComponent(filter_shipping_city);
	}

	var filter_shipping_zone = $('input[name=\'filter_shipping_zone\']').val();
	if (filter_shipping_zone) {
		url += '&filter_shipping_zone=' + encodeURIComponent(filter_shipping_zone);
	}
	
	var filter_shipping_postcode = $('input[name=\'filter_shipping_postcode\']').val();
	if (filter_shipping_postcode) {
		url += '&filter_shipping_postcode=' + encodeURIComponent(filter_shipping_postcode);
	}
	
	var filter_shipping_country = $('input[name=\'filter_shipping_country\']').val();
	if (filter_shipping_country) {
		url += '&filter_shipping_country=' + encodeURIComponent(filter_shipping_country);
	}
	
	var shipping_method = [];
	$('#filter_shipping_method option:selected').each(function() {
		shipping_method.push($(this).val());
	});
	var filter_shipping_method = shipping_method.join(',');
	if (filter_shipping_method) {
		url += '&filter_shipping_method=' + encodeURIComponent(filter_shipping_method);
	}

	var category = [];
	$('#filter_category option:selected').each(function() {
		category.push($(this).val());
	});
	var filter_category = category.join(',');
	if (filter_category) {
		url += '&filter_category=' + encodeURIComponent(filter_category);
	}

	var manufacturer = [];
	$('#filter_manufacturer option:selected').each(function() {
		manufacturer.push($(this).val());
	});
	var filter_manufacturer = manufacturer.join(',');
	if (filter_manufacturer) {
		url += '&filter_manufacturer=' + encodeURIComponent(filter_manufacturer);
	}

	var filter_sku = $('input[name=\'filter_sku\']').val();
	if (filter_sku) {
		url += '&filter_sku=' + encodeURIComponent(filter_sku);
	}
	
	var filter_product_name = $('input[name=\'filter_product_name\']').val();
	if (filter_product_name) {
		url += '&filter_product_name=' + encodeURIComponent(filter_product_name);
	}
	
	var filter_model = $('input[name=\'filter_model\']').val();
	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}
	
	var option = [];
	$('#filter_option option:selected').each(function() {
		option.push($(this).val());
	});
	var filter_option = option.join(',');
	if (filter_option) {
		url += '&filter_option=' + encodeURIComponent(filter_option);
	}
	
	var attribute = [];
	$('#filter_attribute option:selected').each(function() {
		attribute.push($(this).val());
	});
	var filter_attribute = attribute.join(',');
	if (filter_attribute) {
		url += '&filter_attribute=' + encodeURIComponent(filter_attribute);
	}

	var product_statuses = [];
	$('#filter_product_status option:selected').each(function() {
		product_statuses.push($(this).val());
	});
	var filter_product_status = product_statuses.join(',');
	if (filter_product_status) {
		url += '&filter_product_status=' + encodeURIComponent(filter_product_status);
	}
	
	var locations = [];
	$('#filter_location option:selected').each(function() {
		locations.push($(this).val());
	});
	var filter_location = locations.join(',');
	if (filter_location) {
		url += '&filter_location=' + encodeURIComponent(filter_location);
	}
	
	var affiliate_name = [];
	$('#filter_affiliate_name option:selected').each(function() {
		affiliate_name.push($(this).val());
	});
	var filter_affiliate_name = affiliate_name.join(',');
	if (filter_affiliate_name) {
		url += '&filter_affiliate_name=' + encodeURIComponent(filter_affiliate_name);
	}

	var affiliate_email = [];
	$('#filter_affiliate_email option:selected').each(function() {
		affiliate_email.push($(this).val());
	});
	var filter_affiliate_email = affiliate_email.join(',');
	if (filter_affiliate_email) {
		url += '&filter_affiliate_email=' + encodeURIComponent(filter_affiliate_email);
	}

	var coupon_name = [];
	$('#filter_coupon_name option:selected').each(function() {
		coupon_name.push($(this).val());
	});
	var filter_coupon_name = coupon_name.join(',');
	if (filter_coupon_name) {
		url += '&filter_coupon_name=' + encodeURIComponent(filter_coupon_name);
	}

	var filter_coupon_code = $('input[name=\'filter_coupon_code\']').val();
	if (filter_coupon_code) {
		url += '&filter_coupon_code=' + encodeURIComponent(filter_coupon_code);
	}
	
	var filter_voucher_code = $('input[name=\'filter_voucher_code\']').val();
	if (filter_voucher_code) {
		url += '&filter_voucher_code=' + encodeURIComponent(filter_voucher_code);
	}
	
	location = url;
}	
</script> 
<script type="text/javascript">
$(document).ready(function() {
		$('#filter_order_status_id').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_status; ?>',
			minWidth: '200'
		});		
	
	<?php if (in_array('store', $advpp_settings_filters)) { ?>
		$('#filter_store_id').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_stores; ?>',
			minWidth: '200'
		});		
	<?php } ?>

	<?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>
	<?php if (in_array('currency', $advpp_settings_filters)) { ?>
		$('#filter_currency').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_currencies; ?>',
			minWidth: '200'
		});
	<?php } ?>
	<?php } ?>

	<?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>
	<?php if (in_array('tax', $advpp_settings_filters)) { ?>
		$('#filter_taxes').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_taxes; ?>',
			minWidth: '200'
		});	
	<?php } ?>
	<?php } ?>

	<?php if (in_array('tax_class', $advpp_settings_filters)) { ?>
		$('#filter_tax_classes').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_tax_classes; ?>',
			minWidth: '200'
		});	
	<?php } ?>

	<?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>
	<?php if (in_array('geo_zone', $advpp_settings_filters)) { ?>
		$('#filter_geo_zones').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_zones; ?>',
			minWidth: '200'
		});	
	<?php } ?>
	<?php } ?>

	<?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>
	<?php if (in_array('customer_group', $advpp_settings_filters)) { ?>
		$('#filter_customer_group_id').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_groups; ?>',
			minWidth: '200'
		});	
	<?php } ?>
	<?php } ?>

	<?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>
	<?php if (in_array('payment_method', $advpp_settings_filters)) { ?>
		$('#filter_payment_method').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_payment_methods; ?>',
			minWidth: '200'
		});	
	<?php } ?>
	<?php } ?>

	<?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>
	<?php if (in_array('shipping_method', $advpp_settings_filters)) { ?>
		$('#filter_shipping_method').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_shipping_methods; ?>',
			minWidth: '200'
		});	
	<?php } ?>
	<?php } ?>

	<?php if (in_array('category', $advpp_settings_filters)) { ?>
		$('#filter_category').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_categories; ?>',
			minWidth: '300'
		});	
	<?php } ?>

	<?php if (in_array('manufacturer', $advpp_settings_filters)) { ?>
		$('#filter_manufacturer').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_manufacturers; ?>',
			minWidth: '200'
		});	
	<?php } ?>

	<?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>
	<?php if (in_array('option', $advpp_settings_filters)) { ?>
		$('#filter_option').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_options; ?>',
			minWidth: '200'
		});	
	<?php } ?>
	<?php } ?>

	<?php if (in_array('attribute', $advpp_settings_filters)) { ?>
		$('#filter_attribute').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_attributes; ?>',
			minWidth: '300'
		});	
	<?php } ?>

	<?php if (in_array('product_status', $advpp_settings_filters)) { ?>
		$('#filter_product_status').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_status; ?>',
			minWidth: '200'
		});	
	<?php } ?>
	
	<?php if (in_array('location', $advpp_settings_filters)) { ?>
		$('#filter_location').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_locations; ?>',
			minWidth: '200'
		});	
	<?php } ?>

	<?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>
	<?php if (in_array('affiliate_name', $advpp_settings_filters)) { ?>
		$('#filter_affiliate_name').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_affiliate_names; ?>',
			minWidth: '200'
		});	
	<?php } ?>
	<?php } ?>

	<?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>
	<?php if (in_array('affiliate_email', $advpp_settings_filters)) { ?>
		$('#filter_affiliate_email').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_affiliate_emails; ?>',
			minWidth: '200'
		});	
	<?php } ?>
	<?php } ?>

	<?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders') { ?>
	<?php if (in_array('coupon_name', $advpp_settings_filters)) { ?>
		$('#filter_coupon_name').multiselect({
			checkAllText: '<?php echo $text_select_all; ?>',
			uncheckAllText: '<?php echo $text_unselect_all; ?>',
			selectedText: '<?php echo $text_selected; ?>',
			noneSelectedText: '<?php echo $text_all_coupon_names; ?>',
			minWidth: '200'
		});		
	<?php } ?>
	<?php } ?>
});
</script> 
<script type="text/javascript">
$(document).ready(function() {
	$('#date-start').datepicker({changeMonth: true, changeYear: true, dateFormat: 'yy-mm-dd'});
	$('#date-end').datepicker({changeMonth: true, changeYear: true, dateFormat: 'yy-mm-dd'});

	$('#status-date-start').datepicker({changeMonth: true, changeYear: true, dateFormat: 'yy-mm-dd'});
	$('#status-date-end').datepicker({changeMonth: true, changeYear: true, dateFormat: 'yy-mm-dd'});
});
</script>  
<script type="text/javascript"><!--
$('input[name=\'filter_customer_name\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_customer_name=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_customer_email=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_customer_telephone=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_ip=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_company=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_address=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_city=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_zone=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_postcode=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_payment_country=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_company=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_address=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_city=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_zone=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_postcode=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/customer_autocomplete&token=<?php echo $token; ?>&filter_shipping_country=' +  encodeURIComponent(request.term),
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
			url: 'index.php?route=report/adv_products/product_autocomplete&token=<?php echo $token; ?>&filter_sku=' +  encodeURIComponent(request.term),
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

$('input[name=\'filter_product_name\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_products/product_autocomplete&token=<?php echo $token; ?>&filter_product_name=' +  encodeURIComponent(request.term),
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
		$('input[name=\'filter_product_name\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_model\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_products/product_autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request.term),
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

$('input[name=\'filter_coupon_code\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_products/coupon_autocomplete&token=<?php echo $token; ?>&filter_coupon_code=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.coupon_code,
						value: item.coupon_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_coupon_code\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_voucher_code\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=report/adv_products/voucher_autocomplete&token=<?php echo $token; ?>&filter_voucher_code=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.voucher_code,
						value: item.voucher_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_voucher_code\']').val(ui.item.label);
						
		return false;
	}
});
//--></script> 
<?php if ($products) { ?> 
	<?php if ($filter_report != 'all_products_with_without_orders' && $filter_report != 'products_without_orders' && $filter_details != 'all_details' && $filter_group == 'no_group') { ?>  
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript"><!--
	google.load('visualization', '1', {packages: ['corechart']});
      google.setOnLoadCallback(drawChart);      
	  function drawChart() { 
   		var data = google.visualization.arrayToDataTable([
		<?php if ($filter_report == 'products_purchased_without_options' || $filter_report == 'products_purchased_with_options' || $filter_report == 'new_products_purchased' || $filter_report == 'old_products_purchased') {
			echo "['" . $column_name . "','". $column_sold_quantity . "'],";
					$i = 0;
					foreach ($products as $key => $product) {
						if (count($products)==($key+1)) {
							echo "['" . $product['gname'] . "',". $product['gsold'] . "]";
						} else {
							echo "['" . $product['gname'] . "',". $product['gsold'] . "],";
						}
						if (++$i > 9) break;
					}
		} elseif ($filter_report == 'manufacturers') {
			echo "['" . $column_name . "','". $column_sold_quantity . "'],";
					$i = 0;
					foreach ($products as $key => $product) {
						if (count($products)==($key+1)) {
							echo "['" . $product['gmanufacturer'] . "',". $product['gsold'] . "]";
						} else {
							echo "['" . $product['gmanufacturer'] . "',". $product['gsold'] . "],";
						}
						if (++$i > 9) break;
					}
		} elseif ($filter_report == 'categories') {
			echo "['" . $column_name . "','". $column_sold_quantity . "'],";
					$i = 0;
					foreach ($products as $key => $product) {
						if (count($products)==($key+1)) {
							echo "['" . $product['gcategories'] . "',". $product['gsold'] . "]";
						} else {
							echo "['" . $product['gcategories'] . "',". $product['gsold'] . "],";
						}
						if (++$i > 9) break;
					}
		}
		;?>
		]);


        var options = {
			title: <?php if ($filter_report != 'manufacturers' && $filter_report != 'categories') {
			echo "'Top Sold Products'";
			} elseif ($filter_report == 'manufacturers') {
			echo "'Top Manufacturers'";
			} elseif ($filter_report == 'categories') {
			echo "'Top Categories'";
			} ?>,
			height: 280,			
			pieSliceText: 'none',
			tooltip: {text: 'value'},
			pieHole: 0.4,
			chartArea: {right: 75, top: 40, width: "75%", height: "75%"}
        };

			var chart = new google.visualization.PieChart(document.getElementById('chart1_div'));
			chart.draw(data, options);

    		$(window).resize(function(){
        		chart.draw(data, options);
    		});
	}
//--></script>
<script type="text/javascript"><!--
	google.load('visualization', '1', {packages: ['corechart']});
      google.setOnLoadCallback(drawChart);      
	  function drawChart() { 
   		var data = google.visualization.arrayToDataTable([
		<?php if ($filter_report == 'products_purchased_without_options' || $filter_report == 'products_purchased_with_options' || $filter_report == 'new_products_purchased' || $filter_report == 'old_products_purchased') {
			echo "['" . $column_name . "','". $column_gtotal . "'],";
					$i = 0;
					foreach ($products as $key => $product) {
						if (count($products)==($key+1)) {
							echo "['" . $product['gname'] . "',". $product['gtotal'] . "]";
						} else {
							echo "['" . $product['gname'] . "',". $product['gtotal'] . "],";
						}
						if (++$i > 9) break;
					}
		} elseif ($filter_report == 'manufacturers') {
			echo "['" . $column_name . "','". $column_gtotal . "'],";
					$i = 0;
					foreach ($products as $key => $product) {
						if (count($products)==($key+1)) {
							echo "['" . $product['gmanufacturer'] . "',". $product['gtotal'] . "]";
						} else {
							echo "['" . $product['gmanufacturer'] . "',". $product['gtotal'] . "],";
						}
						if (++$i > 9) break;
					}
		} elseif ($filter_report == 'categories') {
			echo "['" . $column_name . "','". $column_gtotal . "'],";
					$i = 0;
					foreach ($products as $key => $product) {
						if (count($products)==($key+1)) {
							echo "['" . $product['gcategories'] . "',". $product['gtotal'] . "]";
						} else {
							echo "['" . $product['gcategories'] . "',". $product['gtotal'] . "],";
						}
						if (++$i > 9) break;
					}
		}
		;?>
		]);

        var options = {
			width: "100%",
			height: 280,			
			colors: ['#b5e08b'],			
			bar: {groupWidth: "80%"},
			chartArea: {top: 35, width: "60%", height: "70%"}		
		};

			var chart = new google.visualization.BarChart(document.getElementById('chart2_div'));
			chart.draw(data, options);

    		$(window).resize(function(){
        		chart.draw(data, options);
    		});
	}
//--></script>
	<?php } ?>
<?php } ?> 
<script type="text/javascript"><!--
$('#save_settings').on('click', function(){
	$.ajax ({
		url: 'index.php?route=report/adv_products/settings&token=<?php echo $token; ?>',		
		type: 'post',
		data: $('#settings_window input[type=\'text\'], #settings_window input[type=\'hidden\'], #settings_window input[type=\'radio\']:checked, #settings_window input[type=\'checkbox\']:checked, #settings_window select'),
		dataType: 'json',       
		success: function(json) {
				location=('<?php echo $url; ?>').replace(/&amp;/g, '&');
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#export_report').on('click', function(){
	var url_exp ='index.php?route=report/adv_products/export&token=<?php echo $token; ?>';

	var report_type = $('select[name=\'report_type\']').val();
	if (report_type) {
		url_exp += '&report_type=' + encodeURIComponent(report_type);
	}
	
	var export_type = $('select[name=\'export_type\']').val();
	if (export_type) {
		url_exp += '&export_type=' + encodeURIComponent(export_type);
	}
	
	var export_logo_criteria = $('select[name=\'export_logo_criteria\']').val();
	if (export_logo_criteria) {
		url_exp += '&export_logo_criteria=' + encodeURIComponent(export_logo_criteria);
	}
	
	var export_csv_delimiter = $('select[name=\'export_csv_delimiter\']').val();
	if (export_csv_delimiter) {
		url_exp += '&export_csv_delimiter=' + encodeURIComponent(export_csv_delimiter);
	}
	
	$.ajax ({
		url: 'index.php?route=report/adv_products/export_validate&token=<?php echo $token; ?>',
		type: 'post',
		data: $('#export input[type=\'text\'], #export input[type=\'hidden\'], #export input[type=\'radio\']:checked, #export input[type=\'checkbox\']:checked, #export select'),
		dataType: 'json',         
		success: function(json) {
			if (json['error']) {
				alert('<?php echo $error_no_data; ?>');
			} else {
				location = url_exp;
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//--></script>
<script type="text/javascript"><!--
function checkValidOptions() {
  var filter_report = document.getElementById('filter_report');
  var filter_details = document.getElementById('filter_details');
    if ((filter_report.options[0].selected === true) || (filter_report.options[3].selected === true)) {
        document.getElementById("filter_details").options[0].disabled = true;		
        document.getElementById("filter_details").options[1].disabled = true;
        document.getElementById("filter_details").options[2].disabled = true;
		
        document.getElementById("filter_group").options[0].disabled = true;
        document.getElementById("filter_group").options[1].disabled = true;		
        document.getElementById("filter_group").options[2].disabled = true;
        document.getElementById("filter_group").options[3].disabled = true;
		document.getElementById("filter_group").options[4].disabled = true;
		document.getElementById("filter_group").options[5].disabled = true;
		document.getElementById("filter_group").options[6].disabled = true;
	}	
    if (filter_report.options[3].selected === true) {
		<?php if (in_array('mv_sold_quantity', $advpp_settings_mv_columns)) { ?>document.getElementById("sold_quantity").disabled = true;<?php } ?>
		<?php if (in_array('mv_total_excl_vat', $advpp_settings_mv_columns)) { ?>document.getElementById("total_excl_vat").disabled = true;<?php } ?>
		<?php if (in_array('mv_total_tax', $advpp_settings_mv_columns)) { ?>document.getElementById("total_tax").disabled = true;<?php } ?>
		<?php if (in_array('mv_total_incl_vat', $advpp_settings_mv_columns)) { ?>document.getElementById("total_incl_vat").disabled = true;<?php } ?>
		<?php if (in_array('mv_app', $advpp_settings_mv_columns)) { ?>document.getElementById("app").disabled = true;<?php } ?>
		<?php if (in_array('mv_refunds', $advpp_settings_mv_columns)) { ?>document.getElementById("refunds").disabled = true;<?php } ?>
		<?php if (in_array('mv_reward_points', $advpp_settings_mv_columns)) { ?>document.getElementById("reward_points").disabled = true;<?php } ?>
	}	
    if (filter_report.options[6].selected === true) {
		<?php if (in_array('mv_category', $advpp_settings_mv_columns)) { ?>document.getElementById("category").disabled = true;<?php } ?>		
		<?php if ($filter_report != 'manufacturers' && $filter_report != 'categories') { ?>
		<?php if (in_array('mv_id', $advpp_settings_mv_columns)) { ?>document.getElementById("id").disabled = true;<?php } ?>
		<?php if (in_array('mv_sku', $advpp_settings_mv_columns)) { ?>document.getElementById("sku").disabled = true;<?php } ?>
		<?php if (in_array('mv_name', $advpp_settings_mv_columns)) { ?>document.getElementById("name").disabled = true;<?php } ?>
		<?php if (in_array('mv_model', $advpp_settings_mv_columns)) { ?>document.getElementById("model").disabled = true;<?php } ?>
		<?php if (in_array('mv_attribute', $advpp_settings_mv_columns)) { ?>document.getElementById("attribute").disabled = true;<?php } ?>
		<?php if (in_array('mv_status', $advpp_settings_mv_columns)) { ?>document.getElementById("status").disabled = true;<?php } ?>
		<?php if (in_array('mv_location', $advpp_settings_mv_columns)) { ?>document.getElementById("location").disabled = true;<?php } ?>
		<?php if (in_array('mv_tax_class', $advpp_settings_mv_columns)) { ?>document.getElementById("tax_class").disabled = true;<?php } ?>
		<?php if (in_array('mv_price', $advpp_settings_mv_columns)) { ?>document.getElementById("price").disabled = true;<?php } ?>
		<?php if (in_array('mv_viewed', $advpp_settings_mv_columns)) { ?>document.getElementById("viewed").disabled = true;<?php } ?>
		<?php if (in_array('mv_stock_quantity', $advpp_settings_mv_columns)) { ?>document.getElementById("stock_quantity").disabled = true;<?php } ?>
		<?php } ?>
	}	
    if (filter_report.options[7].selected === true) {
		<?php if (in_array('mv_manufacturer', $advpp_settings_mv_columns)) { ?>document.getElementById("manufacturer").disabled = true;<?php } ?>		
		<?php if ($filter_report != 'manufacturers' && $filter_report != 'categories') { ?>
		<?php if (in_array('mv_id', $advpp_settings_mv_columns)) { ?>document.getElementById("id").disabled = true;<?php } ?>
		<?php if (in_array('mv_sku', $advpp_settings_mv_columns)) { ?>document.getElementById("sku").disabled = true;<?php } ?>
		<?php if (in_array('mv_name', $advpp_settings_mv_columns)) { ?>document.getElementById("name").disabled = true;<?php } ?>
		<?php if (in_array('mv_model', $advpp_settings_mv_columns)) { ?>document.getElementById("model").disabled = true;<?php } ?>
		<?php if (in_array('mv_attribute', $advpp_settings_mv_columns)) { ?>document.getElementById("attribute").disabled = true;<?php } ?>
		<?php if (in_array('mv_status', $advpp_settings_mv_columns)) { ?>document.getElementById("status").disabled = true;<?php } ?>
		<?php if (in_array('mv_location', $advpp_settings_mv_columns)) { ?>document.getElementById("location").disabled = true;<?php } ?>
		<?php if (in_array('mv_tax_class', $advpp_settings_mv_columns)) { ?>document.getElementById("tax_class").disabled = true;<?php } ?>
		<?php if (in_array('mv_price', $advpp_settings_mv_columns)) { ?>document.getElementById("price").disabled = true;<?php } ?>
		<?php if (in_array('mv_viewed', $advpp_settings_mv_columns)) { ?>document.getElementById("viewed").disabled = true;<?php } ?>
		<?php if (in_array('mv_stock_quantity', $advpp_settings_mv_columns)) { ?>document.getElementById("stock_quantity").disabled = true;<?php } ?>
		<?php } ?>
	}	
    if (filter_details.options[2].selected === true) {
        document.getElementById("filter_group").options[0].disabled = true;
        document.getElementById("filter_group").options[1].disabled = true;		
        document.getElementById("filter_group").options[2].disabled = true;
        document.getElementById("filter_group").options[3].disabled = true;
		document.getElementById("filter_group").options[4].disabled = true;
		document.getElementById("filter_group").options[5].disabled = true;
		document.getElementById("filter_group").options[6].disabled = true;
		
		document.getElementById("date").disabled = true;
		<?php if (in_array('mv_id', $advpp_settings_mv_columns)) { ?>document.getElementById("id").disabled = true;<?php } ?>
		<?php if (in_array('mv_sku', $advpp_settings_mv_columns)) { ?>document.getElementById("sku").disabled = true;<?php } ?>
		<?php if (in_array('mv_name', $advpp_settings_mv_columns)) { ?>document.getElementById("name").disabled = true;<?php } ?>
		<?php if (in_array('mv_model', $advpp_settings_mv_columns)) { ?>document.getElementById("model").disabled = true;<?php } ?>
		<?php if (in_array('mv_category', $advpp_settings_mv_columns)) { ?>document.getElementById("category").disabled = true;<?php } ?>
		<?php if (in_array('mv_manufacturer', $advpp_settings_mv_columns)) { ?>document.getElementById("manufacturer").disabled = true;<?php } ?>
		<?php if (in_array('mv_attribute', $advpp_settings_mv_columns)) { ?>document.getElementById("attribute").disabled = true;<?php } ?>
		<?php if (in_array('mv_status', $advpp_settings_mv_columns)) { ?>document.getElementById("status").disabled = true;<?php } ?>
		<?php if (in_array('mv_location', $advpp_settings_mv_columns)) { ?>document.getElementById("location").disabled = true;<?php } ?>
		<?php if (in_array('mv_tax_class', $advpp_settings_mv_columns)) { ?>document.getElementById("tax_class").disabled = true;<?php } ?>
		<?php if (in_array('mv_price', $advpp_settings_mv_columns)) { ?>document.getElementById("price").disabled = true;<?php } ?>
		<?php if (in_array('mv_viewed', $advpp_settings_mv_columns)) { ?>document.getElementById("viewed").disabled = true;<?php } ?>
		<?php if (in_array('mv_stock_quantity', $advpp_settings_mv_columns)) { ?>document.getElementById("stock_quantity").disabled = true;<?php } ?>		
		<?php if (in_array('mv_sold_quantity', $advpp_settings_mv_columns)) { ?>document.getElementById("sold_quantity").disabled = true;<?php } ?>
		<?php if (in_array('mv_total_excl_vat', $advpp_settings_mv_columns)) { ?>document.getElementById("total_excl_vat").disabled = true;<?php } ?>
		<?php if (in_array('mv_total_tax', $advpp_settings_mv_columns)) { ?>document.getElementById("total_tax").disabled = true;<?php } ?>
		<?php if (in_array('mv_total_incl_vat', $advpp_settings_mv_columns)) { ?>document.getElementById("total_incl_vat").disabled = true;<?php } ?>
		<?php if (in_array('mv_app', $advpp_settings_mv_columns)) { ?>document.getElementById("app").disabled = true;<?php } ?>
		<?php if (in_array('mv_refunds', $advpp_settings_mv_columns)) { ?>document.getElementById("refunds").disabled = true;<?php } ?>
		<?php if (in_array('mv_reward_points', $advpp_settings_mv_columns)) { ?>document.getElementById("reward_points").disabled = true;<?php } ?>			
	}	
}
//--></script> 
<script type="text/javascript">
$(document).ready(function() {
var $filter_range = $('#filter_range'), $date_start = $('#date-start'), $date_end = $('#date-end');
$filter_range.change(function () {
    if ($filter_range.val() == 'custom') {
        $date_start.removeAttr('disabled');
		$date_start.css('background-color', '#F9F9F9');	
        $date_end.removeAttr('disabled');
		$date_end.css('background-color', '#F9F9F9');	
    } else {	
        $date_start.attr('disabled', 'disabled').val('');
		$date_start.css('background-color', '#EEE');
        $date_end.attr('disabled', 'disabled').val('');
		$date_end.css('background-color', '#EEE');
    }
}).trigger('change');

var $filter_report_to_export = $('select[name=\'filter_report\']');
var $filter_details_to_export = $('select[name=\'filter_details\']');
	if ($filter_report_to_export.val() == 'all_products_with_without_orders' || $filter_report_to_export.val() == 'products_without_orders') {
		$("#report_to_export option[value='export_no_details']").attr('disabled', false); 
		$("#report_to_export option[value='export_no_details']").attr('selected', true); 		
		$("#report_to_export option[value='export_basic_details']").attr('disabled', true);		
		$("#report_to_export option[value='export_all_details']").attr('disabled', true); 
		$("#type_to_export option[value='export_xlsx']").attr('selected', true); 
		$('#csv_delimiter select').attr('disabled', true);
		$("#type_to_export option[value='export_xls']").attr('disabled', false); 
		$("#type_to_export option[value='export_xlsx']").attr('disabled', false); 
		$("#type_to_export option[value='export_csv']").attr('disabled', false); 
		$("#type_to_export option[value='export_pdf']").attr('disabled', false); 
		$("#type_to_export option[value='export_html']").attr('disabled', false); 		
	} else {
		if ($filter_details_to_export.val() == 'no_details') {
			$("#report_to_export option[value='export_no_details']").attr('disabled', false); 
			$("#report_to_export option[value='export_no_details']").attr('selected', true); 			
			$("#report_to_export option[value='export_basic_details']").attr('disabled', true); 
			$("#report_to_export option[value='export_all_details']").attr('disabled', true); 
			$("#type_to_export option[value='export_xlsx']").attr('selected', true); 
			$('#csv_delimiter select').attr('disabled', true);
			$("#type_to_export option[value='export_xls']").attr('disabled', false); 
			$("#type_to_export option[value='export_xlsx']").attr('disabled', false); 
			$("#type_to_export option[value='export_csv']").attr('disabled', false); 
			$("#type_to_export option[value='export_pdf']").attr('disabled', false); 
			$("#type_to_export option[value='export_html']").attr('disabled', false); 			
		} else if ($filter_details_to_export.val() == 'basic_details') {
			$("#report_to_export option[value='export_no_details']").attr('disabled', true); 
			$("#report_to_export option[value='export_basic_details']").attr('disabled', false); 
			$("#report_to_export option[value='export_basic_details']").attr('selected', true); 
			$("#report_to_export option[value='export_all_details']").attr('disabled', true);
			$("#type_to_export option[value='export_pdf']").attr('selected', true); 
			$('#csv_delimiter select').attr('disabled', true);
			$("#type_to_export option[value='export_xls']").attr('disabled', true); 
			$("#type_to_export option[value='export_xlsx']").attr('disabled', true); 
			$("#type_to_export option[value='export_csv']").attr('disabled', true); 
			$("#type_to_export option[value='export_pdf']").attr('disabled', false); 
			$("#type_to_export option[value='export_html']").attr('disabled', false); 			
		} else if ($filter_details_to_export.val() == 'all_details') {
			$("#report_to_export option[value='export_no_details']").attr('disabled', true); 
			$("#report_to_export option[value='export_basic_details']").attr('disabled', true); 
			$("#report_to_export option[value='export_all_details']").attr('disabled', false);	
			$("#report_to_export option[value='export_all_details']").attr('selected', true);
			$("#type_to_export option[value='export_xlsx']").attr('selected', true);
			$('#csv_delimiter select').attr('disabled', true);
			$("#type_to_export option[value='export_xls']").attr('disabled', false); 
			$("#type_to_export option[value='export_xlsx']").attr('disabled', false); 
			$("#type_to_export option[value='export_csv']").attr('disabled', false); 
			$("#type_to_export option[value='export_pdf']").attr('disabled', true); 
			$("#type_to_export option[value='export_html']").attr('disabled', true); 			
		} else {
			$("#report_to_export option[value='export_no_details']").attr('disabled', false); 
			$("#report_to_export option[value='export_basic_details']").attr('disabled', false); 		
			$("#report_to_export option[value='export_all_details']").attr('disabled', false); 
			$("#type_to_export option[value='']").attr('selected', true); 
			$('#csv_delimiter select').attr('disabled', true);
			$("#type_to_export option[value='export_xls']").attr('disabled', true); 
			$("#type_to_export option[value='export_xlsx']").attr('disabled', true); 
			$("#type_to_export option[value='export_csv']").attr('disabled', true); 
			$("#type_to_export option[value='export_pdf']").attr('disabled', true); 
			$("#type_to_export option[value='export_html']").attr('disabled', true);  			
		}
	}	
});

$('select[name=\'export_type\']').on('change', function() {
	var export_type = $('select[name=\'export_type\']').val();
	if (export_type == 'export_csv') {
		$('#csv_delimiter select').attr('disabled', false);
		$("#csv_delimiter select").css('background-color', '');
	} else {
		$('#csv_delimiter select').attr('disabled', true);
		$("#csv_delimiter select").css('background-color', '#EEE');
	}
});
$('select[name=\'export_type\']').trigger('change');
</script>  
<?php if ($filter_details == 'basic_details') { ?>  
<script type="text/javascript">
$(".toggle-all").click(function() {
	if ($(this).hasClass("expand")) {
		$(this).removeClass("expand");
		$(".more").show();
		$("#circle").removeClass("desc");
		$("#circle").addClass("asc");			
	} else {
		$(this).addClass("expand");
		$(".more").hide();
		$("#circle").removeClass("asc");
		$("#circle").addClass("desc");	
	}
});
</script>
<?php } ?>
<script type="text/javascript">
$(window).load(function() {
	$(".loader").fadeOut("slow");
});
</script>
<?php echo $footer; ?>