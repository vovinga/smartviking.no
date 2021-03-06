<div class="row-fluid">
  <div class="span8">
    <div class="box-heading">
      <h1>GZIP HTTP Compression</h1>
    </div>
    <table class="form compression">
      <tr>
        <td>GZIP Compression Status</td>
        <td>
        <select name="Nitro[Compress][Enabled]" class="NitroCompressEnabled">
            <option value="yes" <?php echo( (!empty($nitroData['Nitro']['Compress']['Enabled']) && $nitroData['Nitro']['Compress']['Enabled'] == 'yes')) ? 'selected=selected' : ''?>>Enabled</option>
            <option value="no" <?php echo (empty($nitroData['Nitro']['Compress']['Enabled']) || $nitroData['Nitro']['Compress']['Enabled'] != 'yes') ? 'selected=selected' : ''?>>Disabled</option>
        </select>
        </td>
      </tr>
    </table>

   <div class="minification-tabbable-parent">
    <div class="tabbable tabs-left"> 
          <ul class="nav nav-tabs">
            <li class="active"><a href="#compress-css" data-toggle="tab">CSS files</a></li>
            <li><a href="#compress-javascript" data-toggle="tab">JavaScript files</a></li>
            <li><a href="#compress-html" data-toggle="tab">HTML files</a></li>
          </ul>
         <div class="tab-content">
         	<div id="compress-css" class="tab-pane active">
                <table class="form compression" style="margin-top:-10px;">
                  <tr>
                    <td>Compress CSS files</td>
                    <td>
                    <select name="Nitro[Compress][CSS]">
                        <option value="no" <?php echo (empty($nitroData['Nitro']['Compress']['CSS']) || $nitroData['Nitro']['Compress']['CSS'] == 'no') ? 'selected=selected' : ''?>>No</option>
                        <option value="yes" <?php echo( (!empty($nitroData['Nitro']['Compress']['CSS']) && $nitroData['Nitro']['Compress']['CSS'] == 'yes')) ? 'selected=selected' : ''?>>Yes</option>
                    </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Compression Level<span class="help"><strong>Recommended: </strong>4</span></td>
                    <td>
                      <select name="Nitro[Compress][CSSLevel]" val="<?php echo (!empty($nitroData['Nitro']['Compress']['CSSLevel'])) ? $nitroData['Nitro']['Compress']['CSSLevel'] : '4';?>" class="compressionLevel" id="compressionLevel1">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                      </select>
                      <div id="sliderCompression1" class="sliderCompression"></div>
                    </td>
                  </tr>
                  <tr>
                  <td colspan="2"><a href="javascript:void(0)" onclick="nitro.cachemanager.clearCSSCache();" class="btn btn-default clearJSCSSCache"><i class="icon-trash first-level-spinner"></i> Clear compressed CSS files cache</a></td>
                  </tr>
                </table> 
            </div>
         	<div id="compress-javascript" class="tab-pane">
                <table class="form compression" style="margin-top:-10px;">
                  <tr>
                    <td>Compress JavaScript files</td>
                    <td>
                    <select name="Nitro[Compress][JS]">
                        <option value="no" <?php echo (empty($nitroData['Nitro']['Compress']['JS']) || $nitroData['Nitro']['Compress']['JS'] == 'no') ? 'selected=selected' : ''?>>No</option>
                        <option value="yes" <?php echo( (!empty($nitroData['Nitro']['Compress']['JS']) && $nitroData['Nitro']['Compress']['JS'] == 'yes')) ? 'selected=selected' : ''?>>Yes</option>
                    </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Compression Level<span class="help"><strong>Recommended: </strong>4</span></td>
                    <td>
                      <select name="Nitro[Compress][JSLevel]" val="<?php echo (!empty($nitroData['Nitro']['Compress']['JSLevel'])) ? $nitroData['Nitro']['Compress']['JSLevel'] : '4';?>" class="compressionLevel" id="compressionLevel2">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                      </select>
                      <div id="sliderCompression2" class="sliderCompression"></div>
                    </td>
                  </tr>
                  <tr>
                  <td colspan="2"><a href="javascript:void(0)" onclick="nitro.cachemanager.clearJSCache();" class="btn btn-default clearJSCSSCache"><i class="icon-trash first-level-spinner"></i> Clear compressed JavaScript files cache</a></td>
                  </tr>
                </table> 
            </div>
         	<div id="compress-html" class="tab-pane">
                <table class="form minification" style="margin-top:-10px;">
                  <tr>
                    <td>Compress HTML files</td>
                    <td>
                    <select name="Nitro[Compress][HTML]">
                        <option value="no" <?php echo (empty($nitroData['Nitro']['Compress']['HTML']) || $nitroData['Nitro']['Compress']['HTML'] == 'no') ? 'selected=selected' : ''?>>No</option>
                        <option value="yes" <?php echo( (!empty($nitroData['Nitro']['Compress']['HTML']) && $nitroData['Nitro']['Compress']['HTML'] == 'yes')) ? 'selected=selected' : ''?>>Yes</option>
                    </select>
                    </td>
                  </tr>
                  <tr>
                    <td>Compression Level<span class="help"><strong>Recommended: </strong>4</span></td>
                    <td>
                      <select name="Nitro[Compress][HTMLLevel]" val="<?php echo (!empty($nitroData['Nitro']['Compress']['HTMLLevel'])) ? $nitroData['Nitro']['Compress']['HTMLLevel'] : '4';?>" class="compressionLevel" id="compressionLevel3">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                      </select>
                      <div id="sliderCompression3" class="sliderCompression"></div>
                    </td>
                  </tr>
                </table> 
            </div>
         </div>
       </div>
    </div>  
    
    
            
  </div>
  <div class="span4">
    <div class="box-heading">
      <h1><i class="icon-info-sign"></i>&nbsp;What is a GZIP HTTP compression?</h1>
    </div>
    <div class="box-content" style="min-height:100px; line-height:20px;">
    <p>GZIP HTTP compression is a capability that can be built into web servers and web clients to make better use of available bandwidth, and provide greater transmission speeds between both.</p>
    <p>HTTP data is compressed before it is sent from the server: compliant browsers will announce what methods are supported to the server before downloading the correct format; browsers that do not support compliant compression method will download uncompressed data.</p>
    </div>
  </div>
</div> 
<script>
  $(function() {
    function sliderHandler(select, sliderBox) {
        var slider = sliderBox.insertAfter(select).slider({
          min: 1,
          max: 9,
          range: "min",
          value: select[0].selectedIndex + 1,
          slide: function(event, ui) {
            select[0].selectedIndex = ui.value - 1;
          }
        });

        select.change(function() {
          slider.slider("value", this.selectedIndex + 1);
        });

        slider.slider("value", select.attr('val'));
        select.find('option:eq('+(select.attr('val') - 1)+')').attr('selected','selected');
    }

    sliderHandler($("#compressionLevel1"), $("#sliderCompression1"));
    sliderHandler($("#compressionLevel2"), $("#sliderCompression2"));
    sliderHandler($("#compressionLevel3"), $("#sliderCompression3"));
  });
  </script>
