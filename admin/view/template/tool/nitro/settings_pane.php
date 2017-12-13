<div class="box-heading">
  <h1>General Settings</h1>
</div>
<table class="form settings">
  <tr>
    <td>Extension Status<span class="help">Used to Enable/Disable NitroPack</span></td>
    <td>
    <select name="Nitro[Enabled]" class="NitroEnabled">
        <option value="yes" <?php echo( (!empty($nitroData['Nitro']['Enabled']) && $nitroData['Nitro']['Enabled'] == 'yes')) ? 'selected=selected' : ''?>>Enabled</option>
        <option value="no" <?php echo ( (empty($nitroData['Nitro']['Enabled']) || $nitroData['Nitro']['Enabled'] != 'yes')) ? 'selected=selected' : ''?>>Disabled</option>
    </select>
    </td>
  </tr>
  <tr>
    <td>Recommended settings<span class="help">This will apply the most popular NitroPack configuration.</span></td>
    <td><a class="btn btn-default" id="btn-recommended-settings"><i class="icon-magic"></i>&nbsp;&nbsp;Click to apply the recommended settings</a></td>
  </tr>
  <tr>
    <td>Google PageSpeed API Key<span class="help"><strong>Important: </strong>We have inserted a default code to get you up and running. Please obtain your own Server API Key from <a href="https://code.google.com/apis/console" target="_blank"><u>Google API Console</u></a></span></td>
    <td>
      <input type="text" name="Nitro[GooglePageSpeedApiKey]" id="pagespeedApiKey" value="<?php echo !empty($nitroData['Nitro']['GooglePageSpeedApiKey']) ? $nitroData['Nitro']['GooglePageSpeedApiKey'] : 'AIzaSyCxptR6CbHYrHkFfsO_XN3nkf6FjoQp2Mg'; ?>" />
    </td>
  </tr>
  <tr>
    <td>System information<span class="help">Displays useful system information.</span></td>
    <td>
      <a class="btn system-info-refresh" data-toggle="modal" href="#infoModal"><i class="icon-search"></i> Click to view system information</a>
      
        <div id="infoModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">System information</h3>
          </div>
          <div class="modal-body">
            <table>
            	<tr>
                	<td colspan="2"><h4>System test</h4></td>
                </tr>
            	<tr>
                	<td>PHP version:</td>
                    <td id="system_info_php_version"></td>
                </tr>
                <tr>
                	<td>PHP User:</td>
                    <td id="system_info_php_user"></td>
                </tr>
                <tr>
                	<td>Web Server:</td>
                    <td id="system_info_web_server"></td>
                </tr>
                <tr>
                	<td>FTP functions:</td>
                    <td id="system_info_ftp_functions"></td>
                </tr>
                <tr>
                	<td>OpenSSL extension:</td>
                    <td id="system_info_openssl"></td>
                </tr>
                <tr>
                	<td>cURL extension:</td>
                    <td id="system_info_curl"></td>
                </tr>
                <tr>
                	<td>Memcache extension:</td>
                    <td id="system_info_memcache"></td>
                </tr>
                <tr>
                	<td>exec() function:</td>
                    <td id="system_info_exec"></td>
                </tr>
                <tr>
                	<td>zlib:</td>
                    <td id="system_info_zlib"></td>
                </tr>
                <tr>
                	<td>Safe mode:</td>
                    <td id="system_info_safe_mode"></td>
                </tr>
            	<tr>
                	<td colspan="2"><h4>File system test</h4></td>
                </tr>
                <tr>
                    <td>assets/css/</td>
                    <td id="system_info_path_assets_css"></td>
                </tr>
                <tr>
                    <td>assets/js/</td>
                    <td id="system_info_path_assets_js"></td>
                </tr>
            	<tr>
                	<td>system/nitro/cache/</td>
                    <td id="system_info_path_system_nitro_cache"></td>
                </tr>
                <tr>
                	<td>system/nitro/data/</td>
                    <td id="system_info_path_system_nitro_data"></td>
                </tr>
                <tr>
                	<td>system/nitro/data/googlepagespeed-desktop.tpl</td>
                    <td id="system_info_path_system_nitro_data_googlepagespeed-desktop"></td>
                </tr>
                <tr>
                	<td>system/nitro/data/googlepagespeed-mobile.tpl</td>
                    <td id="system_info_path_system_nitro_data_googlepagespeed-mobile"></td>
                </tr>
                <tr>
                	<td>system/nitro/data/persistence.tpl</td>
                    <td id="system_info_path_system_nitro_data_persistence"></td>
                </tr>
                <tr>
                    <td>system/nitro/temp/</td>
                    <td id="system_info_path_system_nitro_temp"></td>
                </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button class="btn btn-primary system-info-refresh"><i class="icon-white icon-refresh"></i> Refresh</button>
          </div>
        </div>
    </td>
  </tr>
  <tr>
    <td>Google PageScore Debug<span class="help">Displays the raw PageScore response.</span></td>
    <td>
      <a class="btn google-raw-refresh" data-toggle="modal" href="#infoGoogleRaw"><i class="icon-search"></i> Click to view Google PageScore RAW result</a>
      <div id="infoGoogleRaw" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel2">Google PageScore RAW result</h3>
          </div>
          <div class="modal-body">
            <textarea id="infoGoogleRawText"></textarea>
          </div>
          <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
          </div>
        </div>
    </td>
  </tr>
  <tr>
    <td>Manage NitroPack modules<span class="help">Enable/Disable NitroPack VQMOD files</span></td>
    <td>
      <a class="btn manage-nitro-modules" data-toggle="modal" href="#manageNitroModules"><i class="icon-cog"></i> Click to manage active NitroPack modules</a>
      <div id="manageNitroModules" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel3">Manage active NitroPack modules</h3>
          </div>
          <div class="modal-body">
          	<p>By checking the following checkboxes, you are enabling the vQmod files of the respective services needed by NitroPack. By default all should be checked.</p>
            <ul style="list-style: none;">
            	<li><label><input type="checkbox" name="NitroTemp[ActiveModule][pagecache]"<?php echo (in_array('pagecache', $activeModules)) ? ' checked="checked"': '';?>/>&nbsp;nitro_pagecache.xml</label></li>
                <li><label><input type="checkbox" name="NitroTemp[ActiveModule][cdn_generic]"<?php echo (in_array('cdn_generic', $activeModules)) ? ' checked="checked"': '';?>/>&nbsp;nitro_cdn_generic.xml</label></li>
                <li><label><input type="checkbox" name="NitroTemp[ActiveModule][db_cache]"<?php echo (in_array('db_cache', $activeModules)) ? ' checked="checked"': '';?>/>&nbsp;nitro_db_cache.xml</label></li>
                <li><label><input type="checkbox" name="NitroTemp[ActiveModule][image_cache]"<?php echo (in_array('image_cache', $activeModules)) ? ' checked="checked"': '';?>/>&nbsp;nitro_image_cache.xml</label></li>
                <li><label><input type="checkbox" name="NitroTemp[ActiveModule][jquery]"<?php echo (in_array('jquery', $activeModules)) ? ' checked="checked"': '';?>/>&nbsp;nitro_jquery.xml</label></li>
                <li><label><input type="checkbox" name="NitroTemp[ActiveModule][minifier]"<?php echo (in_array('minifier', $activeModules)) ? ' checked="checked"': '';?>/>&nbsp;nitro_minifier.xml</label></li>
                <li><label><input type="checkbox" name="NitroTemp[ActiveModule][product_count_fix]"<?php echo (in_array('product_count_fix', $activeModules)) ? ' checked="checked"': '';?>/>&nbsp;nitro_product_count_fix.xml</label></li>
                <li><label><input type="checkbox" name="NitroTemp[ActiveModule][system_cache]"<?php echo (in_array('system_cache', $activeModules)) ? ' checked="checked"': '';?>/>&nbsp;nitro_system_cache.xml</label></li>
                <li><label><input type="checkbox" name="NitroTemp[ActiveModule][journal]"<?php echo (in_array('journal', $activeModules)) ? ' checked="checked"': '';?>/>&nbsp;nitro_journal.xml</label></li>
                <li><label><input type="checkbox" name="NitroTemp[ActiveModule][pagecache_widget]"<?php echo (in_array('pagecache_widget', $activeModules)) ? ' checked="checked"': '';?>/>&nbsp;nitro_pagecache_widget.xml</label></li>
            </ul>
          </div>
          <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button class="btn btn-primary save-nitro-modules"><i class="icon-white icon-save"></i> Save</button>
          </div>
        </div>
    </td>
  </tr>
   <tr>
    <td style="vertical-align:top;">Disable NitroPack for specific pages<span class="help">List the URLs (part or whole) of the pages, separated by newline. Wildcard * is available.</span></td>
    <td>
      <textarea placeholder="e.g. ?route=product/product, each file on a new line" style="width:400px; height:180px;" name="Nitro[DisabledURLs]"><?php echo !empty($nitroData['Nitro']['DisabledURLs']) ? $nitroData['Nitro']['DisabledURLs'] : ''; ?></textarea>
    </td>
  </tr>
  <tr>
    <td>OpenCart product count fix<span class="help">OpenCart has a setting to speed up your website by hiding the display of the product count in the category names. There is a bug in this functionality, which prohibits your site from speeding up. Enabling this will speed up the first page load.</span></td>
    <td>
    <select name="Nitro[ProductCountFix]">
    	<option value="no" <?php echo ( (!empty($nitroData['Nitro']['ProductCountFix']) && $nitroData['Nitro']['ProductCountFix'] == 'no')) ? 'selected=selected' : ''?>>Disabled</option>
        <option value="yes" <?php echo( (!empty($nitroData['Nitro']['ProductCountFix']) && $nitroData['Nitro']['ProductCountFix'] == 'yes')) ? 'selected=selected' : ''?>>Enabled (Recommended)</option>
    </select>
    </td>
  </tr>
  <tr>
    <td>Serve jQuery from Google?<span class="help">If you enable this option, jQuery will be served from Google's hosted library. This will save one HTTP request to your server and may help deliver jQuery faster.</span></td>
    <td>
    <select name="Nitro[GoogleJQuery]">
    	<option value="no" <?php echo ( (!empty($nitroData['Nitro']['GoogleJQuery']) && $nitroData['Nitro']['GoogleJQuery'] == 'no')) ? 'selected=selected' : ''?>>Disabled</option>
        <option value="yes" <?php echo( (!empty($nitroData['Nitro']['GoogleJQuery']) && $nitroData['Nitro']['GoogleJQuery'] == 'yes')) ? 'selected=selected' : ''?>>Enabled</option>
    </select>
    </td>
  </tr>
</table>
<script type="text/javascript">

var refreshSystemInformation = function() {
    if ($(this).is(':disabled')) {
        return;
    }

	$.ajax({
		url: 'index.php?route=tool/nitro/serverinfo&token=' + getURLVar('token'),
		type: 'get',
		dataType: 'json',
		beforeSend: function() {
			$('.system-info-refresh').attr('disabled', 'disabled');
		},
		success: function(data) {
			for (var i in data) {
				$('#system_info_' + i).html(data[i]);
			}
		},
		complete: function() {
			$('.system-info-refresh').removeAttr('disabled');
		}
	});
}

$('.system-info-refresh').click(refreshSystemInformation);

var googleRawRefresh = function() {
	$.ajax({
		url: 'index.php?route=tool/nitro/googlerawrefresh&token=' + getURLVar('token'),
		type: 'get',
		beforeSend: function() {
			$('.google-raw-refresh').attr('disabled', 'disabled');
		},
		success: function(data) {
			$('#infoGoogleRawText').html(data);
		},
		complete: function() {
			$('.google-raw-refresh').removeAttr('disabled');
		}
	});
}

$('.google-raw-refresh').click(googleRawRefresh);

$('#btn-recommended-settings').on('click', function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    if (confirm("This will change your current NitroPack settings to pre-defined values. Are you sure you want to proceed?")) {
        $.ajax({
            url: 'index.php?route=tool/nitro/apply_recommended_settings&token=' + getURLVar('token'),
            complete: function() {
                location.reload();
            }
    });
    }
});
</script>
