<?php echo $header; ?>

<link rel="stylesheet" href="view/stylesheet/css/hb-oc-bootstrap.css">
<link rel="stylesheet" href="view/stylesheet/css/hb-oc-bootstrap-theme.min.css">
<script src="view/stylesheet/js/bootstrap.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

<div id="content">
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="heading">
    <h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
  <div class="container-fluid">
<br>
      	<center><div id='loadgif' style='display:none;'><img src='view/image/loading-bar.gif'/></div></center>
		<div id="msgoutput" style="text-align:center;"></div>
        <br>

		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tabs" class="htabs">
                <a href="#tab-sitemap" data-toggle="tab"><?php echo $tab_sitemap; ?></a>
                <a href="#tab-customlist" data-toggle="tab"><?php echo $tab_customlist; ?></a>
				<a href="#tab-seoalias" data-toggle="tab"><?php echo $tab_seoalias; ?></a>
                <a href="#tab-setting" data-toggle="tab"><?php echo $tab_setting; ?></a>
        </div>
	    
        <div id="tab-sitemap">
	            <h3><?php echo $header_product; ?></h3>
	            
                <div id="stores" class="htabs">
                <?php foreach ($stores as $store) { ?>
                <a href="#store<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></a>
                <?php } ?>
                </div>
                     <?php foreach ($stores as $store) { ?>
                            <div id="store<?php echo $store['store_id']; ?>">
                                <div id="sitemap-files-<?php echo $store['store_id']; ?>"></div>
                            </div>
                        <?php } ?>
                    </div>

				<div id="tab-customlist">
				
                    <div id="stores2" class="htabs">
                    <?php foreach ($stores as $store) { ?>
                    <a href="#store2<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></a>
                    <?php } ?>
                    </div>
                        <?php foreach ($stores as $store) { ?>
                            <div id="store2<?php echo $store['store_id']; ?>">
                               <table class="table table-hover">
                                <thead>
                                <tr>
                                <th><?php echo $col_header; ?></th>
                                <th><?php echo $col_freq; ?></th>
                                <th><?php echo $col_priority; ?></th>
                                <th><?php echo $col_action; ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                <td><input type="text" id="hb_loc_<?php echo $store['store_id']; ?>" value="" class="form-control" /></td>
                                <td><select class="form-control" id="hb_freq_<?php echo $store['store_id']; ?>">
                             <option>monthly</option>
                            <option>weekly</option>
                            <option>yearly</option>
                            <option>daily</option>
                            <option>hourly</option>
                            <option>always</option>
                            <option>never</option>
                            </select></td>
                                <td><select class="form-control" id="hb_priority_<?php echo $store['store_id']; ?>">
                            <?php for ($i = 1.0;$i>0.1;$i-=0.1){ ?>
                            	<option><?php echo $i; ?></option>
                            <?php }  ?>                          	
                            </select></td>
							<td><a class="btn btn-success" id="addlink" onclick="addlink('<?php echo $store['store_id']; ?>')"><?php echo $btn_add; ?></a></td>
                                </tr>
                                
                                <?php if(${"all_links".$store['store_id']}) { ?>
                                <?php foreach (${"all_links".$store['store_id']} as $all_link) { ?>
                                <tr>
                                	<td><?php echo $all_link['loc']; ?></td>
                                    <td><?php echo $all_link['freq']; ?></td>
                                    <td><?php echo $all_link['priority']; ?></td>
                                    <td><a class="btn btn-danger" id="removelink" onclick="removelink('<?php echo $all_link['id']; ?>')"><?php echo $btn_remove; ?></a></td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr><td colspan="5"><?php echo $text_no_records; ?></td></tr>
								<?php } ?>
                                </tbody>
                                </table>
                             </div>
                        <?php } ?>
	            </div>
				
				<div id="tab-seoalias">
					 <div id="seourl_holder"></div>
				 </div>
	            
	            <div id="tab-setting">
				<h3><i class="fa fa-wrench"></i> Settings</h3>
				<a onclick="location = '<?php echo $uninstall; ?>';" class="btn btn-danger"><i class="fa fa-trash"></i> UNINSTALL</a>
                    <a class="btn btn-warning" onclick="autogeneratemap('resetsitemapdir')"><?php echo $btn_dir; ?></a> <hr><br>
			     	
			        <div class="form-group">
		                <label class="col-sm-4"><span><?php echo $text_link_count; ?></span></label>
		                <div class="col-sm-8">
		                  <input type="text" name="hb_sitemap_max_entries" value="<?php echo $hb_sitemap_max_entries; ?>" class="form-control" />
		                </div>
		             </div>
			        <hr>
			         <div class="form-group">
		                <label class="col-sm-4"><span><?php echo $text_automatic; ?></span></label>
		                <div class="col-sm-8">
							<select class="form-control" name="hb_sitemap_automatic">
                            <option value="1" <?php echo ($hb_sitemap_automatic == "1")? 'selected':''; ?>>Enable</option>
                            <option value="0" <?php echo ($hb_sitemap_automatic == "0")? 'selected':''; ?>>Disable</option>
                            </select>		                
                            </div>
		             </div>
			        <hr>

			        
                    <table class="table table-hover">
                        <thead>
                        <tr>
                        <th><?php echo $col_header; ?></th><th><?php echo $col_priority; ?></th><th><?php echo $col_freq; ?></th>
                        </tr>
                        </thead>
                        <tbody>
			              <tr>
                          	<td><?php echo $col_product; ?></td>
                            <td><select class="form-control" name="hb_sitemap_product_priority" >
                            <?php for ($i = 1.0;$i>0.1;$i-=0.1){ ?>
                            	<option value="<?php echo (string)$i; ?>" <?php echo ($hb_sitemap_product_priority == (string)$i)? 'selected':''; ?>><?php echo $i; ?></option>
                            <?php }  ?>                            	
                            </select></td>
                            <td><select class="form-control" name="hb_sitemap_product_freq">
                             <option <?php echo ($hb_sitemap_product_freq == "monthly")? 'selected':''; ?>>monthly</option>
                            <option <?php echo ($hb_sitemap_product_freq == "weekly")? 'selected':''; ?>>weekly</option>
                            <option <?php echo ($hb_sitemap_product_freq == "yearly")? 'selected':''; ?>>yearly</option>
                            <option <?php echo ($hb_sitemap_product_freq == "daily")? 'selected':''; ?>>daily</option>
                            <option <?php echo ($hb_sitemap_product_freq == "always")? 'selected':''; ?>>always</option>
                            <option <?php echo ($hb_sitemap_product_freq == "hourly")? 'selected':''; ?>>hourly</option>
                            <option <?php echo ($hb_sitemap_product_freq == "never")? 'selected':''; ?>>never</option>
                            </select></td>
                          </tr>
                          <tr>
                          	<td><?php echo $col_category; ?></td>
                            <td><select class="form-control" name="hb_sitemap_category_priority">
                            <?php for ($i = 1.0;$i>0.1;$i-=0.1){ ?>
                            	<option value="<?php echo (string)$i; ?>" <?php echo ($hb_sitemap_category_priority == (string)$i)? 'selected':''; ?>><?php echo $i; ?></option>
                            <?php }  ?>                          	
                            </select></td>
                            <td><select class="form-control" name="hb_sitemap_category_freq">
                            <option <?php echo ($hb_sitemap_category_freq == "monthly")? 'selected':''; ?>>monthly</option>
                             <option <?php echo ($hb_sitemap_category_freq == "weekly")? 'selected':''; ?>>weekly</option>
                            <option <?php echo ($hb_sitemap_category_freq == "yearly")? 'selected':''; ?>>yearly</option>
                           <option <?php echo ($hb_sitemap_category_freq == "always")? 'selected':''; ?>>always</option>
                            <option <?php echo ($hb_sitemap_category_freq == "daily")? 'selected':''; ?>>daily</option>
                            <option <?php echo ($hb_sitemap_category_freq == "hourly")? 'selected':''; ?>>hourly</option>
                            <option <?php echo ($hb_sitemap_category_freq == "never")? 'selected':''; ?>>never</option>
                            </select></td>
                          </tr>
                          <tr>
                          	<td><?php echo $col_brand; ?></td>
                            <td><select class="form-control" name="hb_sitemap_brand_priority">
                            <?php for ($i = 1.0;$i>0.1;$i-=0.1){ ?>
                            	<option value="<?php echo (string)$i; ?>" <?php echo ($hb_sitemap_brand_priority == (string)$i)? 'selected':''; ?>><?php echo $i; ?></option>
                            <?php }  ?>                           	
                            </select></td>
                            <td><select class="form-control" name="hb_sitemap_brand_freq">
                            <option <?php echo ($hb_sitemap_brand_freq == "monthly")? 'selected':''; ?>>monthly</option>
                            <option <?php echo ($hb_sitemap_brand_freq == "weekly")? 'selected':''; ?>>weekly</option>
                            <option <?php echo ($hb_sitemap_brand_freq == "yearly")? 'selected':''; ?>>yearly</option>
                            <option <?php echo ($hb_sitemap_brand_freq == "daily")? 'selected':''; ?>>daily</option>
                            <option <?php echo ($hb_sitemap_brand_freq == "always")? 'selected':''; ?>>always</option>
                            <option <?php echo ($hb_sitemap_brand_freq == "hourly")? 'selected':''; ?>>hourly</option>
                            <option <?php echo ($hb_sitemap_brand_freq == "never")? 'selected':''; ?>>never</option>
                            </select></td>
                          </tr>
                          <tr>
                          	<td><?php echo $col_info; ?></td>
                            <td><select class="form-control" name="hb_sitemap_info_priority">
                            <?php for ($i = 1.0;$i>0.1;$i-=0.1){ ?>
                            	<option value="<?php echo (string)$i; ?>" <?php echo ($hb_sitemap_info_priority == (string)$i)? 'selected':''; ?>><?php echo $i; ?></option>
                            <?php }  ?>                            	
                            </select></td>
                           <td><select class="form-control" name="hb_sitemap_info_freq">
                            <option <?php echo ($hb_sitemap_info_freq == "monthly")? 'selected':''; ?>>monthly</option>
                            <option <?php echo ($hb_sitemap_info_freq == "weekly")? 'selected':''; ?>>weekly</option>
                            <option <?php echo ($hb_sitemap_info_freq == "yearly")? 'selected':''; ?>>yearly</option>
                            <option <?php echo ($hb_sitemap_info_freq == "daily")? 'selected':''; ?>>daily</option>
                            <option <?php echo ($hb_sitemap_info_freq == "always")? 'selected':''; ?>>always</option>
                            <option <?php echo ($hb_sitemap_info_freq == "hourly")? 'selected':''; ?>>hourly</option>
                            <option <?php echo ($hb_sitemap_info_freq == "never")? 'selected':''; ?>>never</option>
                            </select></td>
                          </tr>
                
                          <tr>
                          	<td><?php echo $col_tag; ?></td>
                            <td><select class="form-control" name="hb_sitemap_tag_priority">
                            <?php for ($i = 1.0;$i>0.1;$i-=0.1){ ?>
                            	<option value="<?php echo (string)$i; ?>" <?php echo ($hb_sitemap_tag_priority == (string)$i)? 'selected':''; ?>><?php echo $i; ?></option>
                            <?php }  ?>                             	
                            </select></td>
                            <td><select class="form-control" name="hb_sitemap_tag_freq">
                            <option <?php echo ($hb_sitemap_tag_freq == "monthly")? 'selected':''; ?>>monthly</option>
                            <option <?php echo ($hb_sitemap_tag_freq == "weekly")? 'selected':''; ?>>weekly</option>
                            <option <?php echo ($hb_sitemap_tag_freq == "yearly")? 'selected':''; ?>>yearly</option>
                            <option <?php echo ($hb_sitemap_tag_freq == "daily")? 'selected':''; ?>>daily</option>
                            <option <?php echo ($hb_sitemap_tag_freq == "always")? 'selected':''; ?>>always</option>
                            <option <?php echo ($hb_sitemap_tag_freq == "hourly")? 'selected':''; ?>>hourly</option>
                            <option <?php echo ($hb_sitemap_tag_freq == "never")? 'selected':''; ?>>never</option>
                            </select></td>
                          </tr>
                          </tbody>
                         </table>
                         
						 <?php if ($store_total > 0) { ?>
                         <h3><?php echo $header_allstore; ?></h3>  
							<a class="btn btn-primary" onclick="autogeneratemap('autogenerateproductmap')"><?php echo $btn_auto_product; ?></a> <br><br>
							<a class="btn btn-primary" onclick="autogeneratemap('autogeneratetagmap')"><?php echo $btn_auto_tag; ?></a> <br><br>
							
							<a class="btn btn-primary" onclick="autogeneratemap('autogeneratecategorymap')"><?php echo $btn_auto_category; ?></a> <br><br>
							<a class="btn btn-primary" onclick="autogeneratemap('autogeneratebrandmap')"><?php echo $btn_auto_brand; ?></a> <br><br>
							<a class="btn btn-primary" onclick="autogeneratemap('autogenerateinfomap')"><?php echo $btn_auto_info; ?></a> <br><br>
							<a class="btn btn-primary" onclick="autogeneratemap('autogeneratecustommap')"><?php echo $btn_auto_custom; ?></a> <br><br>
							<a class="btn btn-primary" onclick="autogeneratemap('autogenerateindexmap')"><?php echo $btn_auto_index; ?></a> <br><br>
						 <?php } ?>

	            </div>
	            
          </form>
      </div></div>
        <br /><center>
  <span class="help">XML SITEMAP GENERATOR PRO VERSION 3.0 &copy; <a href="http://www.huntbee.com/">HUNTBEE.COM</a> | <a href="http://www.huntbee.com/index.php?route=account/support/">SUPPORT</a></span></center>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#stores a').tabs();
$('#stores2 a').tabs();
//--></script>
<script type="text/javascript"><!--
$( document ).ready(function() {
    loadsitemapfiles();
	loadseourlholder();
});
function loadsitemapfiles(){
<?php foreach ($stores as $store) { ?>
	$('#sitemap-files-<?php echo $store['store_id']; ?>').load('index.php?route=extension/hb_sitemap/loadsitemapfiles&token=<?php echo $token; ?>&store_id=<?php echo $store['store_id']; ?>&store_url=<?php echo $store['url']; ?>');
<?php } ?>
}

function loadseourlholder(){
	$('#seourl_holder').load('index.php?route=extension/hb_sitemap/loadseourlholder&token=<?php echo $token; ?>');
}
</script>
<script type="text/javascript">
function batchestimate(store_id){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_sitemap/estimatebatch&token=<?php echo $token; ?>',
		  data: {store_id: store_id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
					  loadsitemapfiles();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}	  
	 });
					
}

function generatebatchmap(id){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_sitemap/generateProductMap&token=<?php echo $token; ?>',
		  data: {id: id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
					   loadsitemapfiles();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}	  
	 });
					
}

function autogeneratemap(button){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_sitemap/'+button+'&token=<?php echo $token; ?>',
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
					  loadsitemapfiles();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}	  
	 });
					
}


function generatetagmap(id){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_sitemap/generateTagMap&token=<?php echo $token; ?>',
		  data: {id: id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
						loadsitemapfiles();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}	  
	 });
					
}

function generatemap(store_id,button){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_sitemap/'+button+'&token=<?php echo $token; ?>',
		  data: {store_id: store_id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
					 loadsitemapfiles();
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}	  
	 });
					
}

function clearbatch(store_id){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_sitemap/resetbatch&token=<?php echo $token; ?>',
		  data: {store_id: store_id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  loadsitemapfiles();
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
					  
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}

	 });
					
}

function resetproductbatch (id,column){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_sitemap/resetproductbatch&token=<?php echo $token; ?>',
		  data: {id: id, column : column},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
						loadsitemapfiles();	
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow"); 
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}

	 });
					
}

function addlink(store_id){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_sitemap/addlink&token=<?php echo $token; ?>',
		  data: {loc: $('#hb_loc_'+store_id).val(), freq: $('#hb_freq_'+store_id).val(), priority:$('#hb_priority_'+store_id).val(), store_id: store_id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
					  //window.setTimeout(function(){location.reload()},2000)
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}

	 });					
}

function removelink(id){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_sitemap/removelink&token=<?php echo $token; ?>',
		  data: {id: id},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
					 // window.setTimeout(function(){location.reload()},2000)
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}

	 });					
}

function generateSeo(button){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_sitemap/'+button+'&token=<?php echo $token; ?>',
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  loadseourlholder();
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
	 });
}
function clearSeo(button){
	$('#msgoutput').html('');
	$('#loadgif').show();
	$.ajax({
		  type: 'post',
		  url: 'index.php?route=extension/hb_sitemap/clearseo&token=<?php echo $token; ?>',
		  data: {clearname: button},
		  dataType: 'json',
		  success: function(json) {
				if (json['success']) {
					  loadseourlholder();
					  $('#msgoutput').html(json['success']);
					  $('#loadgif').hide();
					  $("html, body").animate({ scrollTop: 0 }, "slow");
				}
		  },			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
	 });
}
</script>
<?php echo $footer; ?>