 <table class="table table-hover">
<thead>
<tr>
<th><?php echo $col_batch_id; ?></th>
<th><?php echo $col_batch_range; ?></th>
<th><?php echo $col_batch_status; ?></th>
<th><?php echo $col_batch_tstatus; ?></th>
<th><?php echo $col_batch_date; ?></th>
</tr>
</thead>
<tbody>
<?php if(${"all_batches".$tpl_store_id}) { ?>
<?php foreach (${"all_batches".$storeid} as $all_batch) { ?>
<tr>
	<td><?php echo $all_batch['batch_id']; ?></td>
	<td><?php echo $all_batch['min_range'].' <i class="fa fa-long-arrow-right"></i> '.$all_batch['max_range']; ?></td>
	<td><?php if ($all_batch['pstatus'] == 0){ ?>
	<a class="btn btn-primary" onclick="generatebatchmap('<?php echo $all_batch['id']; ?>')"><?php echo $btn_generate; ?></a>
   <?php  } else { ?>
		<span style="color:green;"><?php echo $text_batch_generated. ' ('.$all_batch['count'].') '; ?>
		<a onclick="resetproductbatch('<?php echo $all_batch['id']; ?>','pstatus')"> <i class="fa fa-trash"></i> </a>
		</span>
   <?php }  ?></td>
   <td><?php if ($all_batch['tstatus'] == 0){ ?>
	<a title="Reset" class="btn btn-primary" onclick="generatetagmap('<?php echo $all_batch['id']; ?>')"><?php echo $btn_generate; ?></a>
   <?php  } else { ?>
		<span style="color:green;"><?php echo $text_batch_generated. ' ('.$all_batch['count'].') '; ?>
		<a title="Reset" onclick="resetproductbatch('<?php echo $all_batch['id']; ?>','tstatus')"> <i class="fa fa-trash"></i> </a></span>
   <?php }  ?></td>
	<td><?php echo $all_batch['date_added']; ?></td>
</tr>
<?php } ?>
<?php } else { ?>
<tr><td colspan="5"><?php echo $text_no_records; ?></td></tr>
<?php } ?>
</tbody>
</table>
<a class="btn btn-warning" onclick="batchestimate('<?php echo $storeid; ?>')"><?php echo $btn_batch; ?></a> <a class="btn btn-danger" onclick="clearbatch('<?php echo $storeid; ?>')"><?php echo $btn_clear_batch; ?></a>

<hr>
<h3><?php echo $header_others; ?></h3>
<table class="table table-hover">
<tr>
	<td><?php echo $text_category_map; ?></td>
	<td><a class="btn btn-primary" onclick="generatemap('<?php echo $storeid; ?>','generateCategoryMap')"><?php echo $btn_generate; ?></a></td>
</tr>
<tr>
	<td><?php echo $text_brand_map; ?></td>
	<td><a class="btn btn-primary" onclick="generatemap('<?php echo $storeid; ?>','generatebrandMap')"><?php echo $btn_generate; ?></a></td>
</tr>
<tr>
	<td><?php echo $text_info_map; ?></td>
	<td><a class="btn btn-primary" onclick="generatemap('<?php echo $storeid; ?>','generateInfoMap')"><?php echo $btn_generate; ?></a></td>
</tr>
<tr>
	<td><?php echo $text_custom_map; ?></td>
	<td><a class="btn btn-primary" onclick="generatemap('<?php echo $storeid; ?>','generateCustomMap')"><?php echo $btn_generate; ?></a></td>
</tr>
<tr>
	<td><?php echo $text_index_map; ?></td>
	<td><a class="btn btn-success" onclick="generatemap('<?php echo $storeid; ?>','generateIndexMap')"><?php echo $btn_generate; ?></a></td>
</tr>
</table>
<hr>
<h3><?php echo $header_sitemaps; ?></h3>
 
 <?php
 $source = "../sitemap_index".$tpl_store_id.".xml";
 // load as string
 if (file_exists($source)){
 $xmlstr = file_get_contents($source);
 $xmlcont = new SimpleXMLElement($xmlstr);
 echo '<div class="alert alert-warning" role="alert">';
 foreach($xmlcont as $url) 
	 {
		$link = $url->loc;
		echo "<i class='fa fa-check-square-o'></i> <a href='".$link."' target='_blank'>".$link."</a>";
		echo "<br>";
	 } 
	 
 echo '<br><div class="alert alert-info">Submit <b><span style="color:green;">'.$store_url.'sitemap_index'.$tpl_store_id.'.xml</span></b> to Search Engines</div>
 
 </div><hr>
							 
 <a class="btn btn-success" href="http://www.google.com/webmasters/sitemaps/ping?sitemap='.$store_url.'sitemap_index'.$tpl_store_id.'.xml" target="_blank" style="text-decoration:none;color:#FFF;"><i class="fa fa-google"></i> Ping Google</a>  <a class="btn btn-success" href="http://www.bing.com/webmaster/ping.aspx?siteMap='.$store_url.'sitemap_index'.$tpl_store_id.'.xml" target="_blank" style="text-decoration:none;color:#FFF;"><i class="fa fa-windows"></i> Ping MSN/Bing</a>
 
 ';
 }else { 
 	echo '<span style="color:#FF0000">'.$text_sitemap_not_found.'</span>';
 }?>