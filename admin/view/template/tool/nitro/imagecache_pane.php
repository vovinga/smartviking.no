<div class="row-fluid">
  <div class="span8">
    <div class="box-heading">
      <h1>Image Cache</h1>
    </div>
    <table class="form browserCache">
      <tr>
        <td>Override JPEG Quality<span class="help">This will override the default JPEG quality of OpenCart with the value below.</span></td>
        <td>
        <select name="Nitro[ImageCache][OverrideCompression]" class="NitroImageCacheOverrideCompression">
            <option value="yes" <?php echo( (!empty($nitroData['Nitro']['ImageCache']['OverrideCompression']) && $nitroData['Nitro']['ImageCache']['OverrideCompression'] == 'yes')) ? 'selected=selected' : ''?>>Yes</option>
            <option value="no" <?php echo (empty($nitroData['Nitro']['ImageCache']['OverrideCompression']) || $nitroData['Nitro']['ImageCache']['OverrideCompression'] != 'yes') ? 'selected=selected' : ''?>>No</option>
        </select>
        </td>
      </tr>
      <tr>
        <td>JPEG Quality<span class="help">Your JPEG cache images will be created with this quality / compression.</span></td>
        <td>
            <input type="number" name="Nitro[ImageCache][JPEGCompression]" max="100" min="0" value="<?php echo !empty($nitroData['Nitro']['ImageCache']['JPEGCompression']) ? $nitroData['Nitro']['ImageCache']['JPEGCompression'] : '90'?>" />
        </td>
      </tr>
      <tr>
        <td>Image Cache Directory<span class="help">The native OpenCart image cache directory, where it stores the files.</span></td>
        <td>
            <span class="cacheImageDirSpan cacheDirLink" ca="<?php echo DIR_IMAGE.'cache/'; ?>">********** (click to show)</span>
        </td>
      </tr>
      <tr>
        <td>Delete cache<span class="help">Use this button to delete the OpenCart Image Cache.</span></td>
        <td>
          <a href="javascript:void(0)" onclick="nitro.cachemanager.clearImageCache();" class="btn btn-default"><i class="icon-trash first-level-spinner"></i> Clear OpenCart Image Cache</a>
        </td>
      </tr>
    </table>            
    <script type="text/javascript">
    $('.cacheImageDirSpan').click(function() {
        $(this).html($(this).attr('ca')).removeClass('cacheDirLink');
    });
    </script>

    <div class="box-heading">
      <h1>Image Dimensions Override</h1>
    </div>
    <table class="form browserCache">
        <tr>
          <td>Automatically detect correct image dimensions<span class="help">When this is enabled NitroPack will attempt to automatically configure correct values for the image dimension overrides. Disable this if you want to use the old version of the tool.</span></td>
          <td>
          <select name="Nitro[ImageCache][DimensionAutoDetect]" class="form-control" id="DimensionAutoDetect">
              <option value="yes" <?php echo( (!empty($nitroData['Nitro']['ImageCache']['DimensionAutoDetect']) && $nitroData['Nitro']['ImageCache']['DimensionAutoDetect'] == 'yes')) ? 'selected=selected' : ''?>>Yes</option>
              <option value="no" <?php echo (empty($nitroData['Nitro']['ImageCache']['DimensionAutoDetect']) || $nitroData['Nitro']['ImageCache']['DimensionAutoDetect'] != 'yes') ? 'selected=selected' : ''?>>No</option>
          </select>
          </td>
        </tr>

      <?php $pages = array("home" => "Home page", "category" => "Category pages", "product" => "Product pages");
      foreach ($pages as $page_type=>$page_title) {?>
      <tr>
        <td><?php echo $page_title; ?></td>
        <td>
          <ul class="nav nav-tabs" id="img-dimensions-nav-<?php echo $page_type; ?>">
            <li class="active"><a href="#dimensions-desktop-<?php echo $page_type; ?>">Desktop</a></li>
            <li><a href="#dimensions-tablet-<?php echo $page_type; ?>">Tablet</a></li>
            <li><a href="#dimensions-mobile-<?php echo $page_type; ?>">Mobile</a></li>
          </ul>
          <div class="tab-content">
            <table id="dimensions-desktop-<?php echo $page_type; ?>" class="form-inline tab-pane active">
              <?php if (!empty($nitroData['Nitro']['DimensionOverride'][$page_type]['Desktop'])) {
              foreach ($nitroData['Nitro']['DimensionOverride'][$page_type]['Desktop'] as $category=>$positions) {
                foreach ($positions as $position=>$categoryOverrides) { ?>
                    <tr><td><h3><?php echo $dimensionCategoryTitles['positionTitles'][$position] . $dimensionCategoryTitles['categoryTitles'][$category]; ?></h3></td></tr>
                    <?php $name_base = 'Nitro[DimensionOverride]['.$page_type.'][Desktop]['.$category.']['.$position.']'; ?>
                    <?php foreach ($categoryOverrides as $x=>$dimensions) { ?>
                      <tr><td><input class="form-control-sm" type="text" size="4" value="<?php echo $dimensions['old']['width']; ?>" disabled />&nbsp;x&nbsp<input class="form-control-sm" size="4" type="text" value="<?php echo $dimensions['old']['height']; ?>" disabled />
                      <input type="hidden" name="<?php echo $name_base; ?>[<?php echo $x; ?>][old][width]" value="<?php echo $dimensions['old']['width']; ?>" />
                      <input type="hidden" name="<?php echo $name_base; ?>[<?php echo $x; ?>][old][height]" value="<?php echo $dimensions['old']['height']; ?>" />
                      <span style="font-size: 2em">&nbsp;&rarr;&nbsp;</span>
                      <input name="<?php echo $name_base; ?>[<?php echo $x; ?>][new][width]" class="form-control-sm" size="4" type="text" value="<?php echo $dimensions['new']['width']; ?>" />&nbsp;x&nbsp<input name="<?php echo $name_base; ?>[<?php echo $x; ?>][new][height]" class="form-control-sm" size="4" type="text" value="<?php echo $dimensions['new']['height']; ?>" /></td></tr>
                    <?php }
                    }
                  }
              } ?>
            </table>
            <table id="dimensions-tablet-<?php echo $page_type; ?>" class="form-inline tab-pane">
              <?php if (!empty($nitroData['Nitro']['DimensionOverride'][$page_type]['Tablet'])) {
              foreach ($nitroData['Nitro']['DimensionOverride'][$page_type]['Tablet'] as $category=>$positions) {
                foreach ($positions as $position=>$categoryOverrides) { ?>
                    <tr><td><h3><?php echo $dimensionCategoryTitles['positionTitles'][$position] . $dimensionCategoryTitles['categoryTitles'][$category]; ?></h3></td></tr>
                    <?php $name_base = 'Nitro[DimensionOverride]['.$page_type.'][Tablet]['.$category.']['.$position.']'; ?>
                    <?php foreach ($categoryOverrides as $x=>$dimensions) { ?>
                      <tr><td><input class="form-control-sm" type="text" size="4" value="<?php echo $dimensions['old']['width']; ?>" disabled />&nbsp;x&nbsp<input class="form-control-sm" size="4" type="text" value="<?php echo $dimensions['old']['height']; ?>" disabled />
                      <input type="hidden" name="<?php echo $name_base; ?>[<?php echo $x; ?>][old][width]" value="<?php echo $dimensions['old']['width']; ?>" />
                      <input type="hidden" name="<?php echo $name_base; ?>[<?php echo $x; ?>][old][height]" value="<?php echo $dimensions['old']['height']; ?>" />
                      <span style="font-size: 2em">&nbsp;&rarr;&nbsp;</span>
                      <input name="<?php echo $name_base; ?>[<?php echo $x; ?>][new][width]" class="form-control-sm" size="4" type="text" value="<?php echo $dimensions['new']['width']; ?>" />&nbsp;x&nbsp<input name="<?php echo $name_base; ?>[<?php echo $x; ?>][new][height]" class="form-control-sm" size="4" type="text" value="<?php echo $dimensions['new']['height']; ?>" /></td></tr>
                    <?php }
                    }
                  }
              } ?>
            </table>
            <table id="dimensions-mobile-<?php echo $page_type; ?>" class="form-inline tab-pane">
              <?php if (!empty($nitroData['Nitro']['DimensionOverride'][$page_type]['Mobile'])) {
              foreach ($nitroData['Nitro']['DimensionOverride'][$page_type]['Mobile'] as $category=>$positions) {
                foreach ($positions as $position=>$categoryOverrides) { ?>
                    <tr><td><h3><?php echo $dimensionCategoryTitles['positionTitles'][$position] . $dimensionCategoryTitles['categoryTitles'][$category]; ?></h3></td></tr>
                    <?php $name_base = 'Nitro[DimensionOverride]['.$page_type.'][Mobile]['.$category.']['.$position.']'; ?>
                    <?php foreach ($categoryOverrides as $x=>$dimensions) { ?>
                      <tr><td><input class="form-control-sm" type="text" size="4" value="<?php echo $dimensions['old']['width']; ?>" disabled />&nbsp;x&nbsp<input class="form-control-sm" size="4" type="text" value="<?php echo $dimensions['old']['height']; ?>" disabled />
                      <input type="hidden" name="<?php echo $name_base; ?>[<?php echo $x; ?>][old][width]" value="<?php echo $dimensions['old']['width']; ?>" />
                      <input type="hidden" name="<?php echo $name_base; ?>[<?php echo $x; ?>][old][height]" value="<?php echo $dimensions['old']['height']; ?>" />
                      <span style="font-size: 2em">&nbsp;&rarr;&nbsp;</span>
                      <input name="<?php echo $name_base; ?>[<?php echo $x; ?>][new][width]" class="form-control-sm" size="4" type="text" value="<?php echo $dimensions['new']['width']; ?>" />&nbsp;x&nbsp<input name="<?php echo $name_base; ?>[<?php echo $x; ?>][new][height]" class="form-control-sm" size="4" type="text" value="<?php echo $dimensions['new']['height']; ?>" /></td></tr>
                    <?php }
                  }
                }
              } ?>
            </table>
          </div>
          <a class="btn btn-success image-dimension-scan-btn" data-page-type="<?php echo $page_type; ?>"><i class="icon-spinner hide scan-loader"></i>&nbsp;Scan dimensions</a>
          <a class="btn btn-danger image-dimension-delete-btn" data-page-type="<?php echo $page_type; ?>"><i class="icon-trash"></i>&nbsp;Delete overrides</a>
        </td>
      </tr>
      <?php } ?>
    </table>         
    <script type="text/javascript">
      $('#img-dimensions-nav-home a, #img-dimensions-nav-category a, #img-dimensions-nav-product a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
      })

      $('.image-dimension-delete-btn').click(function() {
        var page_type = $(this).data("page-type");
        $("#dimensions-desktop-" + page_type).html("");
        $("#dimensions-tablet-" + page_type).html("");
        $("#dimensions-mobile-" + page_type).html("");
      });

      $('.image-dimension-scan-btn').click(function() {
        var page_type = $(this).data("page-type");
        var loader = $(this).find(".scan-loader");

        loader.addClass("icon-spin");

        $.ajax({
          url: "<?php echo $image_dimensions_url; ?>",
          type: "GET",
          data: {
            page_type: page_type,
            automatic_detection: $('#DimensionAutoDetect').val()
          },
          dataType: "json",
          success: function(resp) {
              var html;
              var pageTypeResults = resp.results;
              var heading_titles = resp.heading_titles;

              for (pageType in pageTypeResults) {
                var results = pageTypeResults[pageType];
                for (strategy in results) {
                  if (results[strategy]) {
                    html = "";

                    for (category in results[strategy]) {
                      for (position in results[strategy][category]) {
                        var name_base = 'Nitro[DimensionOverride]['+page_type+']['+strategy+']['+category+']['+position+']';
                        var data = results[strategy][category][position];
                        html += '<tr><td><h3>' + heading_titles.positionTitles[position] + heading_titles.categoryTitles[category] + '</h3></td></tr>';

                        for (var x=0; x < data.length; x++) {
                          var dimensions = data[x];
                          html += '<tr><td><input class="form-control-sm" type="text" size="4" value="'+dimensions.old.width+'" disabled />&nbsp;x&nbsp<input class="form-control-sm" size="4" type="text" value="'+dimensions.old.height+'" disabled />';
                          html += '<input type="hidden" name="'+name_base+'['+x+'][old][width]" value="'+dimensions.old.width+'" />';
                          html += '<input type="hidden" name="'+name_base+'['+x+'][old][height]" value="'+dimensions.old.height+'" />';
                          html += '<span style="font-size: 2em">&nbsp;&rarr;&nbsp;</span>';
                          html += '<input name="'+name_base+'['+x+'][new][width]" class="form-control-sm" size="4" type="text" value="'+dimensions.new.width+'" />&nbsp;x&nbsp<input name="'+name_base+'['+x+'][new][height]" class="form-control-sm" size="4" type="text" value="'+dimensions.new.height+'" /></td></tr>';
                        }
                      }
                    }

                    $("#dimensions-" + strategy.toLowerCase() + "-" + page_type).html(html);
                    html = "";
                  }
                }
              }
          },
          complete: function() {
            loader.removeClass("icon-spin");
          },
          error: function(xhr) {
            alert(xhr.responseText);
          }
        });
      });
    </script>
  </div>
  <div class="span4">
    <div class="row">
      <div class="box-heading">
        <h1><i class="icon-info-sign"></i>Image Cache?</h1>
      </div>
      <div class="box-content" style="min-height:100px; line-height:20px;">
        This is your OpenCart image cache functionality. Now you have the chance to control the quality of the images and clear the cache from the admin panel. The images are stored in the image cache directory and are created on-the-fly when an image request is sent. This means that if you clear your cache now, it will be auto-populated later while the users are browsing your site.
      </div>
    </div>

    <div class="row">
      <div class="box-heading">
        <h1><i class="icon-info-sign"></i>&nbsp;Image Dimensions Override?</h1>
      </div>
      <div class="box-content" style="min-height:100px; line-height:20px; padding: 15px">
          Most responsive themes need to supply images in high resolution in order to look good on all device types. The image containers for the different device types are with different dimensions and the resolution is usually based on the largest container's dimensions. However this adds overhead for the devices that will not display the image in the bigger resolution. This functionality allows you to override the image dimensions for the different device and page types.
      </div>
    </div>
  </div>
</div>
