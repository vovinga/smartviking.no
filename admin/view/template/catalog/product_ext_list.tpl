<?php echo $header; ?>
<!-- display length configuration -->
<div class="modal fade" id="iDisplayLengthModal" tabindex="-1" role="dialog" aria-labelledby="iDisplayLengthModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="iDisplayLengthModalLabel"><?php echo $text_items_per_page; ?></h4>
      </div>
      <div class="modal-body aqe-container">
        <div class="aqe-overlay fade">
          <div class="aqe-tbl">
            <div class="aqe-tbl-cell"><i class="fa fa-refresh fa-spin fa-5x text-muted"></i></div>
          </div>
        </div>
        <div class="notice">
        </div>
        <form method="post" action="<?php echo $settings; ?>" class="form-horizontal ajax-form" role="form" id="iDisplayLengthForm">
          <fieldset>
            <div class="form-group">
              <label for="iDisplayLength" class="col-sm-4 control-label"><?php echo $entry_products_per_page; ?></label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="aqe_items_per_page" id="iDisplayLength" value="<?php echo $items_per_page; ?>">
              </div>
              <div class="col-sm-offset-4 col-sm-8 error-container">
              </div>
            </div>
            <span class="help-block"><?php echo $help_items_per_page; ?></span>
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default cancel" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $button_close; ?></button>
        <button type="button" class="btn btn-primary submit" data-form="#iDisplayLengthForm"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- confirm deletion -->
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="confirmDeleteLabel"><?php echo $text_confirm_delete; ?></h4>
      </div>
      <div class="modal-body">
        <p><?php echo $text_are_you_sure; ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> <?php echo $button_cancel; ?></button>
        <button type="button" class="btn btn-danger delete"><i class="fa fa-trash-o"></i> <?php echo $button_delete; ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- column settings -->
<div class="modal fade" id="pageColumnsModal" tabindex="-1" role="dialog" aria-labelledby="pageColumnsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="pageColumnsModalLabel"><?php echo $text_choose_columns; ?></h4>
      </div>
      <div class="modal-body aqe-container">
        <div class="aqe-overlay fade">
          <div class="aqe-tbl">
            <div class="aqe-tbl-cell"><i class="fa fa-refresh fa-spin fa-5x text-muted"></i></div>
          </div>
        </div>
        <div class="notice">
        </div>
        <form method="post" action="<?php echo $settings; ?>" class="form-horizontal ajax-form" role="form" id="pageColumnsModalForm">
          <fieldset>
            <h4><?php echo $entry_columns; ?></h4>
            <table class="table table-hover table-condensed page-columns">
              <thead>
                <tr>
                  <th>#</th>
                  <th><?php echo $text_column; ?></th>
                  <th class="text-center"><?php echo $text_display; ?></th>
                  <th class="text-center"><?php echo $text_editable; ?></th>
                </tr>
              </thead>
              <tbody class="sortable">
              <?php foreach ($product_columns as $column => $attr) { ?>
                <tr data-id="<?php echo $column; ?>"<?php echo (!(int)$attr['display']) ? ' class="danger"' : ''; ?>>
                  <td><i class="fa fa-arrows-v"></i></td>
                  <td><?php echo $attr['name']; ?><input name="index[columns][<?php echo $column; ?>]" type="hidden" class="index-column" value="<?php echo $attr['index']; ?>"></td>
                  <td class="text-center"><input name="display[columns][<?php echo $column; ?>]" type="checkbox" class="display-column" <?php echo ((int)$attr['display']) ? ' checked' : ''; ?>></td>
                  <td class="text-center"><?php echo ((int)$attr['editable']) ? $text_yes : $text_no; ?></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
            <h4><?php echo $entry_actions; ?></h4>
            <table class="table table-hover table-condensed page-actions">
              <thead>
                <tr>
                  <th>#</th>
                  <th><?php echo $text_action; ?></th>
                  <th class="text-center"><?php echo $text_display; ?></th>
                </tr>
              </thead>
              <tbody class="sortable">
              <?php foreach ($product_actions as $action => $attr) { ?>
                <tr data-id="<?php echo $column; ?>"<?php echo (!(int)$attr['display']) ? ' class="danger"' : ''; ?>>
                  <td><i class="fa fa-arrows-v"></i></td>
                  <td><?php echo $attr['name']; ?><input name="index[actions][<?php echo $action; ?>]" type="hidden" class="index-column" value="<?php echo $attr['index']; ?>"></td>
                  <td class="text-center"><input name="display[actions][<?php echo $action; ?>]" type="checkbox" class="display-column" <?php echo ((int)$attr['display']) ? ' checked' : ''; ?>></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default cancel" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $button_close; ?></button>
        <button type="button" class="btn btn-primary submit" data-form="#pageColumnsModalForm"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- other settings -->
<div class="modal fade" id="otherSettingsModal" tabindex="-1" role="dialog" aria-labelledby="otherSettingsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="otherSettingsModalLabel"><?php echo $text_other_settings; ?></h4>
      </div>
      <div class="modal-body aqe-container">
        <div class="aqe-overlay fade">
          <div class="aqe-tbl">
            <div class="aqe-tbl-cell"><i class="fa fa-refresh fa-spin fa-5x text-muted"></i></div>
          </div>
        </div>
        <div class="notice">
        </div>
        <form method="post" action="<?php echo $settings; ?>" class="form-horizontal ajax-form" role="form" id="otherSettingsForm">
          <fieldset>
            <div class="form-group">
              <label for="listViewImageWidth" class="col-sm-4 control-label"><?php echo $entry_list_view_image_size; ?></label>
              <div class="col-sm-8">
                <input type="text" class="form-control input-inline width-50px" name="aqe_list_view_image_width" id="listViewImageWidth" value="<?php echo $aqe_list_view_image_width; ?>"> x <input type="text" class="form-control input-inline width-50px" name="aqe_list_view_image_height" id="listViewImageHeight" value="<?php echo $aqe_list_view_image_height; ?>">
              </div>
              <div class="col-sm-offset-4 col-sm-8 error-container">
              </div>
            </div>
            <div class="form-group">
              <label for="quickEditOn" class="col-sm-4 control-label"><?php echo $entry_quick_edit_on; ?></label>
              <div class="col-sm-3 fc-auto-width">
                <select name="aqe_quick_edit_on" id="quickEditOn" class="form-control">
                  <option value="click"<?php echo ($aqe_quick_edit_on == 'click' || $aqe_quick_edit_on != 'dblclick') ? ' selected' : ''; ?>><?php echo $text_single_click; ?></option>
                  <option value="dblclick"<?php echo ($aqe_quick_edit_on == 'dblclick') ? ' selected' : ''; ?>><?php echo $text_double_click; ?></option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="alternateRowColour" class="col-sm-4 control-label"><?php echo $entry_alternate_row_colour; ?></label>
              <div class="col-sm-8">
                <label class="radio-inline">
                  <input type="radio" name="aqe_alternate_row_colour" id="alternateRowColour" value="1"<?php echo ((int)$aqe_alternate_row_colour) ? ' checked' : ''; ?>> <?php echo $text_yes; ?>
                </label>
                <label class="radio-inline">
                  <input type="radio" name="aqe_alternate_row_colour" id="alternateRowColourNo" value="0"<?php echo (!(int)$aqe_alternate_row_colour) ? ' checked' : ''; ?>> <?php echo $text_no; ?>
                </label>
              </div>
            </div>
            <div class="form-group">
              <label for="rowHoverHighlighting" class="col-sm-4 control-label"><?php echo $entry_row_hover_highlighting; ?></label>
              <div class="col-sm-8">
                <label class="radio-inline">
                  <input type="radio" name="aqe_row_hover_highlighting" id="rowHoverHighlighting" value="1"<?php echo ((int)$aqe_row_hover_highlighting) ? ' checked' : ''; ?>> <?php echo $text_yes; ?>
                </label>
                <label class="radio-inline">
                  <input type="radio" name="aqe_row_hover_highlighting" id="rowHoverHighlightingNo" value="0"<?php echo (!(int)$aqe_row_hover_highlighting) ? ' checked' : ''; ?>> <?php echo $text_no; ?>
                </label>
                <span class="help-block"><?php echo $help_row_hover_highlighting; ?></span>
              </div>
            </div>
            <div class="form-group">
              <label for="highlightStatus" class="col-sm-4 control-label"><?php echo $entry_highlight_status; ?></label>
              <div class="col-sm-8">
                <label class="radio-inline">
                  <input type="radio" name="aqe_highlight_status" id="highlightStatus" value="1"<?php echo ((int)$aqe_highlight_status) ? ' checked' : ''; ?>> <?php echo $text_yes; ?>
                </label>
                <label class="radio-inline">
                  <input type="radio" name="aqe_highlight_status" id="highlightStatusNo" value="0"<?php echo (!(int)$aqe_highlight_status) ? ' checked' : ''; ?>> <?php echo $text_no; ?>
                </label>
                <span class="help-block"><?php echo $help_highlight_status; ?></span>
              </div>
            </div>
            <div class="form-group">
              <label for="filterSubCategory" class="col-sm-4 control-label"><?php echo $entry_filter_sub_category; ?></label>
              <div class="col-sm-8">
                <label class="radio-inline">
                  <input type="radio" name="aqe_filter_sub_category" id="filterSubCategory" value="1"<?php echo ((int)$aqe_filter_sub_category) ? ' checked' : ''; ?>> <?php echo $text_yes; ?>
                </label>
                <label class="radio-inline">
                  <input type="radio" name="aqe_filter_sub_category" id="filterSubCategoryNo" value="0"<?php echo (!(int)$aqe_filter_sub_category) ? ' checked' : ''; ?>> <?php echo $text_no; ?>
                </label>
                <span class="help-block"><?php echo $help_filter_sub_category; ?></span>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default cancel" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $button_close; ?></button>
        <button type="button" class="btn btn-primary submit" data-form="#otherSettingsForm"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php if (in_array("image", $columns) || in_array("images", $actions)) { ?>
<!-- image manager -->
<div class="modal fade" id="imageManagerModal" tabindex="-1" role="dialog" aria-labelledby="imageManagerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="imageManagerModalLabel"><?php echo $text_image_manager; ?></h4>
      </div>
      <div class="modal-body">
        <input type="hidden" value="" id="im-new-image" />
        <div class="image-manager"></div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php } ?>

<!-- action menu modal -->
<div class="modal fade" id="actionQuickEditModal" tabindex="-1" role="dialog" aria-labelledby="actionQuickEditModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="actionQuickEditModalLabel"></h4>
      </div>
      <div class="modal-body aqe-container">
        <div class="aqe-overlay fade">
          <div class="aqe-tbl">
            <div class="aqe-tbl-cell"><i class="fa fa-refresh fa-spin fa-5x text-muted"></i></div>
          </div>
        </div>
        <div class="notice">
        </div>
        <form enctype="multipart/form-data" id="actionQuickEditForm" onsubmit="return false;">
          <fieldset>
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default cancel" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $button_close; ?></button>
        <button type="button" class="btn btn-primary submit" data-form="#actionQuickEditForm"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="alerts">
  <div class="container" id="alerts">
    <?php foreach ($alerts as $type => $_alerts) { ?>
      <?php foreach ((array)$_alerts as $alert) { ?>
        <?php if ($alert) { ?>
    <div class="alert alert-<?php echo ($type == "error") ? "danger" : $type; ?> fade in">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <?php echo $alert; ?>
    </div>
        <?php } ?>
      <?php } ?>
    <?php } ?>
  </div>
</div>

<div id="content" class="main-content">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li<?php echo ($breadcrumb['active']) ? ' class="active"' : ''; ?>><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>

  <div class="navbar-placeholder">
    <nav class="navbar navbar-default" role="navigation" id="aqe-navbar">
      <div class="nav-container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
            <span class="sr-only"><?php echo $text_toggle_navigation; ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <span class="navbar-brand"><i class="fa fa-cog"></i> <?php echo $heading_title; ?></span>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <div class="navbar-right">
            <div class="nav navbar-nav navbar-checkbox hidden" id="batch-edit-container">
              <div class="checkbox">
                <label>
                  <input type="checkbox" id="batch-edit"> <?php echo $text_batch_edit; ?>
                </label>
              </div>
            </div>
            <div class="nav navbar-nav navbar-form">
              <div class="form-group search-form">
                <label for="global-search" class="sr-only"><?php echo $text_search;?></label>
                <div class="search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="<?php echo $text_search;?>" id="global-search">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button" id="global-search-btn"><i class="fa fa-search fa-fw"></i></button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="nav navbar-nav btn-group navbar-btn">
              <button type="button" class="btn btn-default" data-action="<?php echo $insert; ?>" id="btn-insert"><i class="fa fa-plus"></i> <?php echo $button_insert; ?></button>
              <button type="button" class="btn btn-default" data-action="<?php echo $copy; ?>" id="btn-copy" disabled><i class="fa fa-files-o"></i> <?php echo $button_copy; ?></button>
              <button type="button" class="btn btn-default" data-action="<?php echo $delete; ?>" id="btn-delete" disabled><i class="fa fa-trash-o"></i> <?php echo $button_delete; ?></button>
            </div>
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $text_settings; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#" data-toggle="modal" data-target="#iDisplayLengthModal"><?php echo $text_items_per_page; ?></a></li>
                  <li><a href="#" data-toggle="modal" data-target="#pageColumnsModal"><?php echo $text_choose_columns; ?></a></li>
                  <li class="divider"></li>
                  <li><a href="#" data-toggle="modal" data-target="#otherSettingsModal"><?php echo $text_other_settings; ?></a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </div>

  <div class="content">
    <div id="dT_processing" class="dataTables_processing fade"><i class="fa fa-refresh fa-spin fa-5x"></i></div>
    <form method="post" enctype="multipart/form-data" id="form" class="form-horizontal" role="form">
      <fieldset>
        <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-condensed<?php echo ($aqe_row_hover_highlighting) ? ' table-hover' : ''; ?><?php echo ($aqe_alternate_row_colour) ? ' table-striped' : ''; ?>" id="dT">
          <thead>
            <tr>
              <?php foreach ($columns as $col) {
               switch($col) {
                case 'selector': ?>
              <th class="<?php echo $column_info[$col]['align']; ?> col_<?php echo $col; ?>" width="1"><input type="checkbox" id="dT-selector" /></th>
                <?php break;
                case 'image': ?>
              <th class="<?php echo $column_info[$col]['align']; ?> col_<?php echo $col; ?>" width="1"><?php echo $column_info[$col]['name']; ?></th>
                <?php break;
                default: ?>
              <th class="<?php echo $column_info[$col]['align']; ?> col_<?php echo $col; ?>"><?php echo $column_info[$col]['name']; ?></th>
                <?php break;
               } ?>
              <?php } ?>
            </tr>
            <tr class="filters">
              <?php foreach ($columns as $col) {
               switch($col) {
                case 'view_in_store':
                case 'selector':
                case 'image': ?>
              <td></td>
                <?php break;
                case 'status': ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <select name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
                  <option value="" selected></option>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                </select>
              </td>
                <?php break;
                case 'subtract':
                case 'shipping': ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <select name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
                  <option value="" selected></option>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <option value="0"><?php echo $text_no; ?></option>
                </select>
              </td>
                <?php break;
                case 'action': ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <div class="btn-group" style="white-space:nowrap;">
                  <button type="button" class="btn btn-sm btn-default" id="filter" title="<?php echo $text_filter; ?>"><i class="fa fa-filter fa-fw"></i></button>
                  <button type="button" class="btn btn-sm btn-default" id="clear-filter" title="<?php echo $text_clear_filter; ?>"><i class="fa fa-times fa-fw"></i></button>
                </div>
              </td>
                <?php break;
                case 'manufacturer': ?>
                <?php if (in_array($col, array_keys($typeahead))) { ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <input type="text" class="form-control input-sm fltr <?php echo $col; ?> typeahead id_based" placeholder="<?php echo $text_autocomplete; ?>">
                <input type="hidden" name="filter_<?php echo $col; ?>" class="search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
              </td>
                <?php } else { ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <select name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
                  <option value="" selected></option>
                  <option value="*"><?php echo $text_none; ?></option>
                  <?php foreach ($manufacturers as $m) { ?>
                  <option value="<?php echo $m['manufacturer_id']; ?>"><?php echo $m['name']; ?></option>
                  <?php } ?>
                </select>
              </td>
                <?php } ?>
                <?php break;
                case 'category': ?>
                <?php if (in_array($col, array_keys($typeahead))) { ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <input type="text" class="form-control input-sm fltr <?php echo $col; ?> typeahead id_based" placeholder="<?php echo $text_autocomplete; ?>">
                <input type="hidden" name="filter_<?php echo $col; ?>" class="search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
              </td>
                <?php } else { ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <select name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
                  <option value="" selected></option>
                  <option value="*"><?php echo $text_none; ?></option>
                  <?php foreach ($categories as $c) { ?>
                  <option value="<?php echo $c['category_id']; ?>"><?php echo $c['name']; ?></option>
                  <?php } ?>
                </select>
              </td>
                <?php } ?>
                <?php break;
                case 'download': ?>
                <?php if (in_array($col, array_keys($typeahead))) { ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <input type="text" class="form-control input-sm fltr <?php echo $col; ?> typeahead id_based" placeholder="<?php echo $text_autocomplete; ?>">
                <input type="hidden" name="filter_<?php echo $col; ?>" class="search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
              </td>
                <?php } else { ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <select name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
                  <option value="" selected></option>
                  <option value="*"><?php echo $text_none; ?></option>
                  <?php foreach ($downloads as $dl) { ?>
                  <option value="<?php echo $dl['download_id']; ?>"><?php echo $dl['name']; ?></option>
                  <?php } ?>
                </select>
              </td>
                <?php } ?>
                <?php break;
                case 'filter': ?>
                <?php if (in_array($col, array_keys($typeahead))) { ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <input type="text" class="form-control input-sm fltr <?php echo $col; ?> typeahead id_based" placeholder="<?php echo $text_autocomplete; ?>">
                <input type="hidden" name="filter_<?php echo $col; ?>" class="search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
              </td>
                <?php } else { ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <select name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
                  <option value="" selected></option>
                  <option value="*"><?php echo $text_none; ?></option>
                  <?php foreach ($filters as $fg) { ?>
                  <optgroup label="<?php echo addslashes($fg['name']); ?>">
                  <?php foreach ($fg['filters'] as $f) { ?>
                    <option value="<?php echo $f['filter_id']; ?>"><?php echo $f['name']; ?></option>
                  <?php } ?>
                  </optgroup>
                  <?php } ?>
                </select>
              </td>
                <?php } ?>
                <?php break;
                case 'store': ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <select name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
                  <option value="" selected></option>
                  <option value="*"><?php echo $text_none; ?></option>
                  <?php foreach ($stores as $s) { ?>
                  <option value="<?php echo $s['store_id']; ?>"><?php echo $s['name']; ?></option>
                  <?php } ?>
                </select>
              </td>
                <?php break;
                case 'length_class': ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <select name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
                  <option value="" selected></option>
                  <?php foreach ($length_classes as $lc) { ?>
                  <option value="<?php echo $lc['length_class_id']; ?>"><?php echo $lc['title']; ?></option>
                  <?php } ?>
                </select>
              </td>
                <?php break;
                case 'weight_class': ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <select name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
                  <option value="" selected></option>
                  <?php foreach ($weight_classes as $wc) { ?>
                  <option value="<?php echo $wc['weight_class_id']; ?>"><?php echo $wc['title']; ?></option>
                  <?php } ?>
                </select>
              </td>
                <?php break;
                case 'stock_status': ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <select name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
                  <option value="" selected></option>
                  <?php foreach ($stock_statuses as $ss) { ?>
                  <option value="<?php echo $ss['stock_status_id']; ?>"><?php echo $ss['name']; ?></option>
                  <?php } ?>
                </select>
              </td>
                <?php break;
                case 'tax_class': ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <select name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>">
                  <option value="" selected></option>
                  <option value="*"><?php echo $text_none; ?></option>
                  <?php foreach ($tax_classes as $tc) { ?>
                  <option value="<?php echo $tc['tax_class_id']; ?>"><?php echo $tc['title']; ?></option>
                  <?php } ?>
                </select>
              </td>
                <?php break;
                case 'price': ?>
              <td class="<?php echo $column_info[$col]['align']; ?>">
                <div class="input-group">
                  <input type="text" name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" id="filter_price" data-column="<?php echo $col; ?>">
                  <input type="hidden" value="" id="filter_special_price">
                  <div class="input-group-btn" data-toggle="buttons">
                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                      <span class="caret"></span>
                      <span class="sr-only"><?php echo $text_toggle_dropdown; ?></span>
                    </button>
                    <ul class="dropdown-menu text-left pull-right price" role="menu">
                      <li class="active"><a href="#" class="filter-special-price" data-value="" id="special-price-off"><i class="fa fa-fw fa-check"></i> <?php echo $text_special_off; ?></a></li>
                      <li><a href="#" class="filter-special-price" data-value="active"><i class="fa fa-fw"></i> <?php echo $text_special_active; ?></a></li>
                      <li><a href="#" class="filter-special-price" data-value="expired"><i class="fa fa-fw"></i> <?php echo $text_special_expired; ?></a></li>
                      <li><a href="#" class="filter-special-price" data-value="future"><i class="fa fa-fw"></i> <?php echo $text_special_future; ?></a></li>
                    </ul>
                  </div>
                </div>
              </td>
                <?php break;
				case 'cost':?>
				<td class="<?php echo $column_info[$col]['align']; ?>" width="120"><input type="text" name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?> typeahead"  placeholder="<?php echo $text_autocomplete; ?>" data-column="<?php echo $col; ?>"></td>
				<?php break;
                case 'name':
                case 'model':
                case 'sku':
                case 'upc':
                case 'ean':
				
                case 'jan':
                case 'isbn':
                case 'mpn':
                case 'location':
                case 'seo': ?>
              <td class="<?php echo $column_info[$col]['align']; ?>"><input type="text" name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?> typeahead"  placeholder="<?php echo $text_autocomplete; ?>" data-column="<?php echo $col; ?>"></td>
                <?php break;
                default: ?>
              <td class="<?php echo $column_info[$col]['align']; ?>"><input type="text" name="filter_<?php echo $col; ?>" class="form-control input-sm search_init fltr <?php echo $col; ?>" data-column="<?php echo $col; ?>"></td>
                <?php break;
               } ?>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </fieldset>
    </form>
  </div>

</div>
<script type="text/javascript"><!--
(function( bull5i, $, undefined ) {
  var oTable
    , xhr
    , related = <?php echo json_encode($related); ?>;

  bull5i.texts = $.extend({}, bull5i.texts, {
    error_ajax_request: '<?php echo addslashes($error_ajax_request); ?>'
  });

  $.fn.editableform.loading = '<div class="editableform-loading"><div class="aqe-tbl"><div class="aqe-tbl-cell"><i class="fa fa-refresh fa-spin fa-2x text-muted"></i></div></div></div>';
  $.fn.editableform.clear = '<span class="editable-clear-x"><i class="fa fa-times-circle"></i></span>';

  function responseHandler(response, hide) {
    hide = typeof hide === 'undefined' ? true : hide;
    if (!response.success) {
      if (response.alerts) {
        var dismiss = true;
        $.each(response.alerts, function(type, msg) {
          if ($.isArray(msg)) {
            $.each(msg, function(i, m) {
              if (m) {
                bull5i.display_alert(m, type, 0, dismiss);
                dismiss = false;
              }
            });
          } else if (msg) {
            bull5i.display_alert(msg, type, 0, dismiss);
            dismiss = false;
          }
        });
      }
      if (response.msg) {
        return response.msg;
      } else {
        if (hide) {
          $(this).editable('hide');
        }
        return false;
      }
    } else {
      var dismiss = true;
      if (response.msg) {
        bull5i.display_alert(response.msg, "success", 5000, dismiss);
        dismiss = false;
      }
      if (response.alerts) {
        $.each(response.alerts, function(type, msg) {
          if ($.isArray(msg)) {
            $.each(msg, function(i, m) {
              if (m) {
                bull5i.display_alert(m, type, 0, dismiss);
                dismiss = false;
              }
            });
          } else if (msg) {
            bull5i.display_alert(msg, type, 0, dismiss);
            dismiss = false;
          }
        });
      }
      return true;
    }
  }

  function setupEditables() {
    var defaultParams = {
        ajaxOptions: {
          type: 'POST',
          dataType: 'json',
          cache: false
        },
        type: 'text',
        url: '<?php echo $update; ?>',
        toggle: '<?php echo $aqe_quick_edit_on; ?>',
        highlight:false,
        container: 'body',
        title: '',
        emptytext: '',
        pk: bull5i.fnGetPkParams,
        value: function() {
          return oTable.fnGetData(this);
        },
        params: function(params) {
          var args = {};
          args.id = params.pk.id;
          args.column = params.pk.column;
          args.old = params.pk.old;
          args.value = ($.isArray(params.value) && params.value.length == 0) ? null : params.value;
          if ($('#batch-edit').is(':checked') && $('input[name*=\'selected\']:checked').length) {
            args.ids = $('input[name*=\'selected\']:checked').serializeObject().selected;
          }
          return args;
        },
        success: function(response, newValue) {
          result = responseHandler.call(this, response);
          editable = $(this).data('editable');
          if (result === true) {
            var aPos = oTable.fnGetPosition(this)
              , oSettings = oTable.fnSettings()
              , sName = oSettings.aoColumns[aPos[1]].sName;

            if (response.value) {
              newValue = response.value
            }

            if ($.isArray(response.results.done)) {
              $.each(response.results.done, function(i,v) {
                var aRow = $("#p_" + v).get(0);

                if(aRow) {
                  var iRow = oTable.fnGetPosition(aRow)
                    , aData = oSettings.aoData[iRow]._aData;

                  aData[sName] = newValue;

                  if (response.values != undefined) {
                    if (response.values.hasOwnProperty('*')) {
                      $.extend(aData, response.values['*']);
                    }
                    if (response.values.hasOwnProperty(v)) {
                      $.extend(aData, response.values[v]);
                    }
                  }

                  bull5i.fnDataTablesUpdateCache(iRow, aData);

                  oTable.fnUpdate(newValue, iRow, aPos[1]);
                }
              });

              updateRelated(sName, response.results.done);
            }

            return {newValue: newValue};
          } else {
            if (result === false) {
              return {newValue: $(this).html()}
            } else {
              return result;
            }
          }
        },
        display: function(value, response) {
          return;
        }
      }
      <?php if (array_reduce(array("status_qe", "yes_no_qe", "manufac_qe", "stock_qe", "tax_cls_qe", "length_qe", "weight_qe"), function($result, $type) use ($types) { return $result | in_array($type, $types); }, false) !== false) { ?>
      , selectParams = {
        type: 'select',
        showbuttons: true
      }
      <?php } ?>
      <?php if (array_reduce(array("cat_qe", "dl_qe", "filter_qe", "store_qe"), function($result, $type) use ($types) { return $result | in_array($type, $types); }, false) !== false) { ?>
      , select2Params = {
        type: 'select2',
        select2: {
          multiple: true,
          allowClear: true,
          placeholder: '<?php echo $text_autocomplete; ?>',
        },
        viewseparator: '<br/>'
      }
      <?php } ?>
      ;
    <?php if (in_array("seo_qe", $types) && !$multilingual_seo) { ?>
    $("td.seo_qe").editable(defaultParams);
    <?php } ?>
    <?php if (in_array("qe", $types)) { ?>
    $("td.qe").editable(defaultParams);
    <?php } ?>
    <?php if (in_array("date_qe", $types)) { ?>
    $("td.date_qe").editable($.extend(true, {}, defaultParams, {
      type: 'combodate',
      format: 'YYYY-MM-DD',
      template: 'D / MMMM / YYYY',
      combodate: {
        smartDays: true,
        maxYear: <?php echo date("Y") + 5; ?>
      }
    }));
    <?php } ?>
    <?php if (in_array("datetime_qe", $types)) { ?>
    $("td.datetime_qe").editable($.extend(true, {}, defaultParams, {
      type: 'combodate',
      format: 'YYYY-MM-DD HH:mm:ss',
      template: 'D / MMM / YYYY  HH:mm:ss',
      combodate: {
        smartDays: true,
        maxYear: <?php echo date("Y") + 5; ?>,
        minuteStep: 1
      }
    }));
    <?php } ?>
    <?php if (in_array("status_qe", $types)) { ?>
    $("td.status_qe").editable($.extend({}, defaultParams, selectParams, {
      source: [
        {value: 0, text: '<?php echo addslashes($text_disabled); ?>' },
        {value: 1, text: '<?php echo addslashes($text_enabled); ?>' }
      ]
    }));
    <?php } ?>
    <?php
    $multilingual_text = array();
    foreach (array('name_qe', 'tag_qe', 'seo_qe') as $type) {
      if (in_array($type, $types) && ($type == 'seo_qe' && $multilingual_seo || $type != 'seo_qe')) $multilingual_text[] = 'td.' . $type;
    } ?>
    <?php if ($multilingual_text) { ?>
    $("<?php echo implode(',', $multilingual_text); ?>").editable($.extend({}, defaultParams, {
      type: 'multilingual_text',
      source: '<?php echo $load; ?>',
      sourceOptions: function() {
        var oTable = bull5i.oTable
          , aPos = oTable.fnGetPosition(this)
          , oSettings = oTable.fnSettings()
          , options = {
              type: 'POST',
              dataType: 'json',
              data: { id: oSettings.aoData[aPos[0]]._aData.id, column: oSettings.aoColumns[aPos[1]].sName }
            };
        return options;
      },
      sourceLoaded: function(response) {
        if (response.success) {
          return response.data;
        } else {
          if (response.alerts) {
            var dismiss = true;
            $.each(response.alerts, function(type, msg) {
              if ($.isArray(msg)) {
                $.each(msg, function(i, m) {
                  if (m) {
                    bull5i.display_alert(m, type, 0, dismiss);
                    dismiss = false;
                  }
                });
              } else if (msg) {
                bull5i.display_alert(msg, type, 0, dismiss);
                dismiss = false;
              }
            });
          }
          if (response.msg) {
            return response.msg;
          } else {
            return null;
          }
        }
      },
      showbuttons: 'bottom',
      value: null,
      success: function(response, newValue) {
        result = responseHandler.call(this, response, false);
        if (result === true) {
          var aPos = oTable.fnGetPosition(this)
            , oSettings = oTable.fnSettings()
            , sName = oSettings.aoColumns[aPos[1]].sName
            , aData = oSettings.aoData[aPos[0]]._aData;

          if (response.value) {
            newValue = response.value
          }

          if ($.isArray(response.results.done)) {
            $.each(response.results.done, function(i,v) {
              var aRow = $("#p_" + v).get(0);

              if(aRow) {
                var iRow = oTable.fnGetPosition(aRow)
                  , aData = oSettings.aoData[iRow]._aData;

                aData[sName] = newValue;

                if (response.values != undefined) {
                  if (response.values['*']) {
                    $.extend(true, aData, response.values['*']);
                  }
                  if (response.values[v]) {
                    $.extend(true, aData, response.values[v]);
                  }
                }

                bull5i.fnDataTablesUpdateCache(iRow, aData);

                oTable.fnUpdate(newValue, iRow, aPos[1]);
              }
            });

            updateRelated(sName, response.results.done);
          }

          return {newValue: newValue};
        } else {
          var $container = $(this).data('editable').input.$tpl;

          if ($container) { // remove old errors
            $container.find('.form-group').removeClass("has-error");
            $container.find('.form-group .help-block').remove();
          }
          if (result === false) {
            if (response.errors && $.isArray(response.errors.value) && $container) {
              $.each(response.errors.value, function(i, v) {
                var lang = v.lang
                  , text = v.text
                  , $input_container = $container.find('.form-group[data-lang="' + lang + '"]');

                $input_container.addClass("has-error").append($('<span/>', { class: "help-block" }).html(text))
              });
              return false;
            } else {
              return {newValue: $(this).html()}
            }
          } else {
            return result;
          }
        }
      }
    }));
    <?php } ?>
    <?php if (in_array("yes_no_qe", $types)) { ?>
    $("td.yes_no_qe").editable($.extend({}, defaultParams, selectParams, {
      source: [
        {value: 0, text: '<?php echo addslashes($text_no); ?>' },
        {value: 1, text: '<?php echo addslashes($text_yes); ?>' }
      ]
    }));
    <?php } ?>
    <?php if (in_array("manufac_qe", $types) && $manufacturer_select !== false) { ?>
    $("td.manufac_qe").editable($.extend({}, defaultParams, selectParams, {
      source: <?php echo $manufacturer_select; ?>,
      prepend: [{value: 0, text: '<?php echo addslashes($text_none); ?>'}]
    }));
    <?php } else { ?>
    $("td.manufac_qe").editable($.extend({}, defaultParams, selectParams, {
      type: 'typeaheadjs',
      showbuttons: true,
      typeahead: {
        name: 'manufacturer',
        <?php if (isset($typeahead['manufacturer']['prefetch'])) { ?>
        prefetch: '<?php echo $typeahead['manufacturer']['prefetch']; ?>',
        <?php } else if (isset($typeahead['manufacturer']['remote'])) { ?>
        remote: '<?php echo $typeahead['manufacturer']['remote']; ?>',
        <?php } ?>
        limit: 10,
        template: [
          '<p><span style="white-space:nowrap;">{{value}}</span></p>'
        ].join(''),
        engine: Hogan
      },
      tpl:'<input type="text" placeholder="<?php echo $text_autocomplete; ?>">',
      value2input: function(value) {
        var aPos = oTable.fnGetPosition(this.options.scope)
          , oSettings = oTable.fnSettings()
          , sName = oSettings.aoColumns[aPos[1]].sName
          , aData = oSettings.aoData[aPos[0]]._aData
          , sValue = '';

        sValue = (aData[sName + '_text'] != '') ? aData[sName + '_text'] : '<?php echo $text_none; ?>';
        this.$input.data('ta-selected', { value:sValue, id:value })
        return sValue;
      },
      input2value: function(value) {
        var datum = this.$input.data('ta-selected');
        if (typeof datum !== 'undefined')
          return (datum.id != '*') ? datum.id : 0;
        else
          return null;
      }
    }));
    <?php } ?>
    <?php if (in_array("cat_qe", $types)) { ?>
    $("td.cat_qe").editable($.extend(true, {}, defaultParams, select2Params, {
      <?php if ($category_select !== false) { ?>
      source: <?php echo $category_select; ?>,
      <?php } else { ?>
      select2: {
        minimumInputLength: 1,
        ajax: {
          type: 'GET',
          url: "<?php echo $filter; ?>",
          dataType: 'json',
          cache: false,
          quietMillis: 150,
          data: function (term, page) {
            return {
              query: term,
              type: "category",
              token: "<?php echo $token; ?>"
            };
          },
          results: function (data, page) {
            var results = []
            $.each(data, function(i,v) {
              results.push({id: v.id, text: v.full_name})
            })
            return {results: results};
          }
        },
        initSelection: function(element, callback) {
          var data = [];
          $(element.val().split(",")).each(function () {
              data.push(this);
          });

          $.ajax({
            type: "GET",
            url: "<?php echo $filter; ?>",
            dataType: "json",
            data: {
              query: data,
              type: "category",
              multiple: true,
              token: "<?php echo $token; ?>"
            }
          }).done(function(data) {
            var results = [];
            $.each(data, function(i, v) {
              results.push({id: v.id, text: v.full_name})
            })
            callback(results);
          });
        }
      }
      <?php } ?>
    }));
    <?php } ?>
    <?php if (in_array("dl_qe", $types)) { ?>
    $("td.dl_qe").editable($.extend(true, {}, defaultParams, select2Params, {
      <?php if ($download_select !== false) { ?>
      source: <?php echo $download_select; ?>,
      <?php } else { ?>
      select2: {
        minimumInputLength: 1,
        ajax: {
          type: 'GET',
          url: "<?php echo $filter; ?>",
          dataType: 'json',
          cache: false,
          quietMillis: 150,
          data: function (term, page) {
            return {
              query: term,
              type: "download",
              token: "<?php echo $token; ?>"
            };
          },
          results: function (data, page) {
            var results = []
            $.each(data, function(i,v) {
              results.push({id: v.id, text: v.value})
            })
            return {results: results};
          }
        },
        initSelection: function(element, callback) {
          var data = [];
          $(element.val().split(",")).each(function () {
              data.push(this);
          });

          $.ajax({
            type: "GET",
            url: "<?php echo $filter; ?>",
            dataType: "json",
            data: {
              query: data,
              type: "download",
              multiple: true,
              token: "<?php echo $token; ?>"
            }
          }).done(function(data) {
            var results = [];
            $.each(data, function(i, v) {
              results.push({id: v.id, text: v.value})
            })
            callback(results);
          });
        }
      }
      <?php } ?>
    }));
    <?php } ?>
    <?php if (in_array("filter_qe", $types)) { ?>
    $("td.filter_qe").editable($.extend(true, {}, defaultParams, select2Params, {
      <?php if ($filter_select !== false) { ?>
      source: <?php echo $filter_select; ?>,
      <?php } else { ?>
      select2: {
        minimumInputLength: 1,
        ajax: {
          type: 'GET',
          url: "<?php echo $filter; ?>",
          dataType: 'json',
          cache: false,
          quietMillis: 150,
          data: function (term, page) {
            return {
              query: term,
              type: "filter",
              token: "<?php echo $token; ?>"
            };
          },
          results: function (data, page) {
            var results = []
              , groups = [];
            $.each(data, function(i, v) {
              var idx = $.inArray(v.group_name);
              if (idx == -1) {
                idx = groups.length;
                groups.push(v.group_name);
                results[idx] = { text: v.group_name, children:[] }
              }
              results[idx].children.push({id: v.id, text: v.value, group: v.group});
            })
            return {results: results};
          }
        },
        initSelection: function(element, callback) {
          var data = [];
          $(element.val().split(",")).each(function () {
              data.push(this);
          });

          $.ajax({
            type: "GET",
            url: "<?php echo $filter; ?>",
            dataType: "json",
            data: {
              query: data,
              type: "filter",
              multiple: true,
              token: "<?php echo $token; ?>"
            }
          }).done(function(data) {
            var results = [];
            $.each(data, function(i, v) {
              results.push({id: v.id, text: v.full_name})
            })
            callback(results);
          });
        },
        formatSelection: function(item, container) {
          if (item.group != undefined) {
            return item.group + item.text;
          } else {
            return item.text;
          }
        }
      }
      <?php } ?>
    }));
    <?php } ?>
    <?php if (in_array("store_qe", $types)) { ?>
    $("td.store_qe").editable($.extend({}, defaultParams, select2Params, {
      source: <?php echo $store_select; ?>
    }));
    <?php } ?>
    <?php if (in_array("stock_qe", $types)) { ?>
    $("td.stock_qe").editable($.extend({}, defaultParams, selectParams, {
      source: <?php echo $stock_status_select; ?>,
    }));
    <?php } ?>
    <?php if (in_array("tax_cls_qe", $types)) { ?>
    $("td.tax_cls_qe").editable($.extend({}, defaultParams, selectParams, {
      source: <?php echo $tax_class_select; ?>,
    }));
    <?php } ?>
    <?php if (in_array("length_qe", $types)) { ?>
    $("td.length_qe").editable($.extend({}, defaultParams, selectParams, {
      source: <?php echo $length_class_select; ?>
    }));
    <?php } ?>
    <?php if (in_array("weight_qe", $types)) { ?>
    $("td.weight_qe").editable($.extend({}, defaultParams, selectParams, {
      source: <?php echo $weight_class_select; ?>,
    }));
    <?php } ?>
    <?php if (in_array("qty_qe", $types)) { ?>
    $("td.qty_qe").editable($.extend({}, defaultParams));
    <?php } ?>
    <?php if (in_array("image_qe", $types)) { ?>
    $("td.image_qe").editable($.extend(true, {}, defaultParams, {
      type: 'image',
      noImage: '<?php echo $no_image; ?>',
      clearText: '<?php echo $text_clear; ?>',
      browseText: '<?php echo $text_browse; ?>',
      value: function() {
        var value = {}
          , aPos = oTable.fnGetPosition(this)
          , oSettings = oTable.fnSettings()
          , aData = oSettings.aoData[aPos[0]]._aData;
        value.image = oTable.fnGetData(this);
        value.thumbnail = aData.image_thumb;
        value.alt = aData.image_alt;
        value.title = aData.image_title;
        return value;
      },
      params: function(params) {
        var args = {};
        args.id = params.pk.id;
        args.column = params.pk.column;
        args.old = params.pk.old;
        args.value = params.value;
        if ($('#batch-edit').is(':checked') && $('input[name*=\'selected\']:checked').length) {
          args.ids = $('input[name*=\'selected\']:checked').serializeObject().selected;
        }
        return args;
      },
      chooseImage: function(value, callback) {
        var image_field = 'im-new-image'
          , new_image = '';

        $("#" + image_field).val('');
        $('#imageManagerModal .modal-body .image-manager').html('<iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(image_field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto" id="im-iframe"></iframe>');

        $("#imageManagerModal").modal("show");

        $("#im-iframe").load(function() {
          var $iframe = $(this).contents();
          $iframe.on('dblclick', '#column-right a', function(e) {
            $('#' + image_field).val('data/' + $(this).find('input[name=\'image\']').attr('value'));
            $("#imageManagerModal").modal("hide");
          })
        })

        $('#imageManagerModal').on('hide.bs.modal', function () {
          if ($('#' + image_field).val()) {
            new_image = $('#' + image_field).val();
            $.ajax({
              url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent(new_image) + '&width=<?php echo $list_view_image_width; ?>&height=<?php echo $list_view_image_height; ?>',
              dataType: 'text',
              success: function(data) {
                value.image = new_image;
                value.thumbnail = data;
                callback.call(null, value);
              }
            });
          } else {
            if (typeof callback === 'function') {
              callback.call(null, null);
            }
          }
          $('#imageManagerModal').off('hide.bs.modal');
        }).on('hidden.bs.modal', function() {
          $('#imageManagerModal .modal-body .image-manager').empty();
          $('#imageManagerModal').off('hidden.bs.modal');
        })
      }
    }));
    <?php } ?>
    <?php if (in_array("price_qe", $types)) { ?>
    $("td.price_qe").editable($.extend({}, defaultParams));
    <?php } ?>
  }

  function updateRelated(column, ids) {
    if (ids && related[column] && related[column].length) {
      var data = {}
        , oSettings = oTable.fnSettings();
      $.each(related[column], function(i, v) {
        data[v] = ids;
      });
      $.when( $.ajax({
          url: '<?php echo $reload; ?>',
          type: 'POST',
          cache: false,
          dataType: 'json',
          data: {data: data}
        }) )
      .done(function(response) {
        $.each(response.values, function(id, val) {
          var aRow = $("#p_" + id).get(0);

          if(aRow) {
            var iRow = oTable.fnGetPosition(aRow)
              , aData = oSettings.aoData[iRow]._aData;

            $.extend(aData, val);

            bull5i.fnDataTablesUpdateCache(iRow, aData);

            oTable.fnUpdate(aData, iRow);
          }
        });
      })
      .fail(function(xhr) {
        if (bull5i.display_alert) {
          var msg = typeof xhr === 'string' ? xhr : xhr.responseText || xhr.statusText || 'Unknown error!';
          bull5i.display_alert(bull5i.texts.error_ajax_request + " " + msg, 'error', 0);
        }
      })
    }
  }

  $(function() {
    oTable = $('#dT').dataTable({
      "sDom": "t<'row'<'col-xs-6'i><'col-xs-6'p>>",
      "bServerSide": true,
      "sAjaxSource": '<?php echo $source; ?>',
      "fnServerParams": function ( aoData ) {
        aoData.push( { "name": "token", "value": "<?php echo $token; ?>" } );
        if ($("#filter_special_price").length && $("#filter_special_price").val()) {
          aoData.push( { "name": "filter_special_price", "value": $("#filter_special_price").val() } );
        }
      },
      "fnServerData": bull5i.fnDataTablesPipeline,
      "fnInitComplete": function( oSettings, json ) {
        if (oSettings.oPreviousSearch.sSearch != "") {
          $("#global-search").val(oSettings.oPreviousSearch.sSearch);
          $("#global-search-btn").data('last-search', oSettings.oPreviousSearch.sSearch);
          bull5i.update_search_btn();
        }

        for ( var i=0, iLen=oSettings.aoColumns.length ; i<iLen ; i++ ) {
          if( oSettings.aoPreSearchCols[i].sSearch.length > 0 ) {
            $("tr.filters .fltr." + oSettings.aoColumns[i].sName + ":input").val(oSettings.aoPreSearchCols[i].sSearch);
          }
        }

        if (oSettings.oLoadedState && oSettings.oLoadedState.sSpecialPrice != undefined && oSettings.oLoadedState.sSpecialPrice != "") {
          $special = $('ul.price .filter-special-price[data-value="' + oSettings.oLoadedState.sSpecialPrice + '"]');
          if ($special.length) {
            bull5i.update_special_price_menu($special);
          }
        }

        if (oSettings.oLoadedState && oSettings.oLoadedState.aoTypeaheads != undefined) {
          if (oSettings.oLoadedState.aoTypeaheads != undefined) {
            for (key in oSettings.oLoadedState.aoTypeaheads) {
              $(".fltr.typeahead." + key)
                .data('ta-selected', {"value": oSettings.oLoadedState.aoTypeaheads[key]})
                .data('ta-name', key)
                .typeahead('setQuery', oSettings.oLoadedState.aoTypeaheads[key]);
            }
          }
        }
      },
      "fnStateSaveParams": function ( oSettings, oData ) {
        oData.sSpecialPrice = $("#filter_special_price").length ? $("#filter_special_price").val() : '';
        oData.aoTypeaheads = {};
        $(".fltr.typeahead").each(function(i) {
          var sValue = $(this).val()
            , sName =  oSettings.aoColumns[$(this).closest("td").index()].sName;
          oData.aoTypeaheads[sName] = sValue;
        })
      },
      "fnStateLoadParams": function ( oSettings, oData ) {
        if (oData.sSpecialPrice != undefined && oData.sSpecialPrice != "" && $("#filter_special_price").length) {
          $("#filter_special_price").val(oData.sSpecialPrice);
        }
        if (oData.aoTypeaheads != undefined) {
          for (key in oData.aoTypeaheads) {
            $(".fltr.typeahead." + key).val(oData.aoTypeaheads[key]);
          }
        }
      },
      "fnStateSave": function ( oSettings, oData ) {
        if (window.localStorage != undefined) {
          // use localstorage
          window.localStorage.setItem( 'aqe_dt', this.oApi._fnJsonString(oData) );
        } else { // use cookie
          this.oApi._fnCreateCookie(
            oSettings.sCookiePrefix + oSettings.sInstance,
            this.oApi._fnJsonString(oData),
            oSettings.iCookieDuration,
            oSettings.sCookiePrefix,
            oSettings.fnCookieCallback
          );
        }
      },
      "fnStateLoad": function ( oSettings ) {
        if (window.localStorage != undefined) {
          sValue = localStorage.getItem( 'aqe_dt' );
          if (window.JSON != undefined) {
            return JSON.parse( sValue );
          } else {
            return (typeof $.parseJSON === 'function') ? $.parseJSON( sValue ) : eval( '(' + sValue + ')' );
          }
        } else {
          var sData = this.oApi._fnReadCookie( oSettings.sCookiePrefix + oSettings.sInstance );
          var oData;

          try {
            oData = (typeof $.parseJSON === 'function') ? $.parseJSON(sData) : eval( '(' + sData + ')' );
          } catch (e) {
            oData = null;
          }

          return oData;
        }
      },
      "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
        $(nRow).attr("data-id", aData.id)
      },
      "fnDrawCallback": function( oSettings ) {
        setupEditables();
        bull5i.update_nav_buttons(true);
      },
      "oLanguage": {
        "oAria": {
          "sSortAscending": "<?php echo addslashes($text_sort_ascending); ?>",
          "sSortDescending": "<?php echo addslashes($text_sort_descending); ?>"
        },
        "oPaginate": {
          "sFirst": "<?php echo addslashes($text_first_page); ?>",
          "sLast": "<?php echo addslashes($text_last_page); ?>",
          "sNext": "<?php echo addslashes($text_next_page); ?>",
          "sPrevious": "<?php echo addslashes($text_previous_page); ?>"
        },
        "sEmptyTable": "<?php echo addslashes($text_empty_table); ?>",
        "sInfo": "<?php echo addslashes($text_showing_info); ?>",
        "sInfoEmpty": "<?php echo addslashes($text_showing_info_empty); ?>",
        "sInfoFiltered": "<?php echo addslashes($text_showing_info_filtered); ?>",
        "sInfoPostFix": "",
        "sInfoThousands": ",",
        //"sLengthMenu": "Show _MENU_ entries",
        "sLoadingRecords": "<?php echo addslashes($text_loading_records); ?>",
        //"sProcessing": "Processing...",
        //"sSearch": "Search:",
        "sZeroRecords": "<?php echo addslashes($text_no_matching_records); ?>"
      },
      "bDeferRender": true,
      "bProcessing": false,
      "bStateSave": true,
      "bScrollCollapse": true,
      "bAutoWidth": false,
      "bSortCellsTop": true,
      "iDisplayLength": <?php echo $items_per_page; ?>,
      "aoColumnDefs": [
        <?php if (in_array("selector", $columns)) { ?>
        { "aTargets": ['col_selector'],
          "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
            $(nTd).html($("<input/>", {"type":"checkbox", "name":"selected[]","value":oData.id}));
          }
        },
        <?php } ?>
        <?php if (in_array("view_in_store", $columns)) { ?>
        { "aTargets": ['col_view_in_store'],
          "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
            var $select = $("<select/>", {"class":"form-control view_in_store"}).append(
              $("<option/>", {"value":""}).html('<?php echo addslashes($text_select); ?>')
            );

            for (var i = 0; i < sData.length; i++) {
              $select.append($("<option/>", {"value":sData[i].url}).html(sData[i].name));
            };

            $(nTd).html($select);
          }
        },
        <?php } ?>
        <?php if (in_array("action", $columns)) { ?>
        { "aTargets": ['col_action'],
          "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
            var $div = $("<div/>", {"class":"btn-group"});

            for (var i = 0; i < sData.length; i++) {
              if (sData[i].url) {
                $btn = $("<a/>", {"href":sData[i].url, "class":"btn btn-default btn-xs " + sData[i].type, "id":sData[i].action + "-" + oData.id, "title":sData[i].title});
              } else {
                $btn = $("<button/>", {"type":"button", "class":"btn btn-default btn-xs action " + sData[i].type, "id":sData[i].action + "-" + oData.id, "data-column":sData[i].action, "title":sData[i].title});
              }

              if (sData[i].name) {
                $btn.html(sData[i].name);
              }

              if (sData[i].ref) {
                $btn.attr("data-ref", sData[i].ref);
              }

              if (sData[i].icon) {
                $btn.prepend($("<i/>", {"class":"fa fa-" + sData[i].icon}));
              }

              $div.append($btn);
            };

            $(nTd).html($div);
          }
        },
        <?php } ?>
        <?php if (in_array("image", $columns)) { ?>
        { "aTargets": ['col_image'],
          "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
            $(nTd).html($("<img/>", {"src":oData.image_thumb, "alt":oData.image_alt, "title":oData.image_title, "data-id":oData.id, "class":"img-thumbnail"}));
          }
        },
        <?php } ?>
        <?php if (in_array("price", $columns)) { ?>
        { "aTargets": ['col_price'],
          "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
            if (oData.special) {
              $(nTd).html($("<s/>").html(sData)).append($("<br/>")).append($("<span/>", {"class":"text-danger"}).html(oData.special));
            } else {
              $(nTd).html(sData);
            }
          }
        },
        <?php } ?>
        <?php if (in_array("status", $columns)) { ?>
        { "aTargets": ['col_status'],
          "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
            if (oData.status_class) {
              $(nTd).html($("<span/>", {"class":"label label-" + oData.status_class}).html(oData.status_text));
            } else {
              $(nTd).html(oData.status_text);
            }
          }
        },
        <?php } ?>
        <?php foreach (array("category", "download", "filter", "store") as $col) { ?>
        <?php if (in_array($col, $columns)) { ?>
        { "aTargets": ['col_<?php echo $col; ?>'],
          "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
            var html = [];
            $.each(oData.<?php echo $col; ?>_data, function(i, v){
              html.push(v.text)
            })
            $(nTd).html(html.join("<br/>"));
          }
        },
        <?php } ?>
        <?php } ?>
        <?php foreach (array("shipping", "subtract", "stock_status", "tax_class", "length_class", "weight_class", "manufacturer", "date_added", "date_modified", "date_available") as $col) { ?>
        <?php if (in_array($col, $columns)) { ?>
        { "aTargets": ['col_<?php echo $col; ?>'],
          "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
            $(nTd).html(oData.<?php echo $col; ?>_text);
          }
        },
        <?php } ?>
        <?php } ?>
        <?php if (in_array("quantity", $columns)) { ?>
        { "aTargets": ['col_quantity'],
          "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
            var container = $("<span/>").html(sData);
            sData = parseInt(sData);

            if (sData < 0) {
              container.addClass("text-danger");
            } else if (sData < 5) {
              container.addClass("text-warning");
            } else {
              container.addClass("text-success");
            }

            $(nTd).html(container);
          }
        },
        <?php } ?>
        { "bSortable": false, "aTargets": <?php echo $non_sortable_columns; ?> },
        { "bSearchable": false, "aTargets": [ 'col_selector', 'col_action' ] }
      ],
      "aoColumns": [
        <?php foreach ($column_classes as $idx => $class) { ?>
        <?php if ($class) { ?>
        { <?php if (!in_array($columns[$idx], array())) { ?>"mData": "<?php echo $columns[$idx]; ?>", <?php } ?>"sName": "<?php echo $columns[$idx]; ?>", "sClass": "<?php echo $class; ?>" },
        <?php } else { ?>
        { <?php if (!in_array($columns[$idx], array())) { ?>"mData": "<?php echo $columns[$idx]; ?>", <?php } ?>"sName": "<?php echo $columns[$idx]; ?>" },
        <?php } ?>
        <?php } ?>
      ]
    });
    bull5i.oTable = oTable;

    $(".sortable").sortable({
      axis: "y",
      opacity: 0.8,
      containment: "parent",
      forceHelperSize: true,
      forcePlaceholderSize: true,
      cursor: "move",
      helper: function(e, ui) {
        ui.children().each(function() {
          $(this).width($(this).width());
        });
        return ui;
      },
      update: function(e, ui) {
        $("tr", $(this)).each(function(i){
          $("input.index-column", $(this)).val(i)
        })
        $("tr td", $(this)).each(function(i){
          $(this).css({'width':'','opacity':'','z-index':''});
        })
      }
    }).disableSelection();
    <?php foreach ($typeahead as $column => $attr) { ?>
      <?php switch ($column) {
        case 'category': ?>
      $('.<?php echo $column; ?>.typeahead').typeahead({
        name: '<?php echo $column; ?>',
        <?php if (isset($attr['prefetch'])) { ?>
        prefetch: '<?php echo $attr['prefetch']; ?>',
        <?php } else if (isset($attr['remote'])) { ?>
        remote: '<?php echo $attr['remote']; ?>',
        <?php } ?>
        limit: 10,
        template: [
          '<p><span style="white-space:nowrap;">{{path}}<strong>{{value}}</strong></span></p>'
        ].join(''),
        engine: Hogan
      });
          <?php break;
        case 'filter': ?>
      $('.<?php echo $column; ?>.typeahead').typeahead({
        name: '<?php echo $column; ?>',
        <?php if (isset($attr['prefetch'])) { ?>
        prefetch: '<?php echo $attr['prefetch']; ?>',
        <?php } else if (isset($attr['remote'])) { ?>
        remote: '<?php echo $attr['remote']; ?>',
        <?php } ?>
        limit: 10,
        template: [
          '<p><span style="white-space:nowrap;">{{group}}<strong>{{value}}</strong></span></p>'
        ].join(''),
        engine: Hogan
      });
          <?php break;
        case 'name':
        case 'model':
        case 'sku':
        case 'upc':
        case 'ean':
        case 'jan':
        case 'isbn':
        case 'mpn':
        case 'location':
        case 'seo':
        case 'download':
        case 'manufacturer': ?>
      $('.<?php echo $column; ?>.typeahead').typeahead({
        name: '<?php echo $column; ?>',
        <?php if (isset($attr['prefetch'])) { ?>
        prefetch: '<?php echo $attr['prefetch']; ?>',
        <?php } else if (isset($attr['remote'])) { ?>
        remote: '<?php echo $attr['remote']; ?>',
        <?php } ?>
        limit: 10,
        template: [
          '<p><span style="white-space:nowrap;">{{value}}</span></p>'
        ].join(''),
        engine: Hogan
      });
          <?php break;
        default:?>
          <?php break;
      } ?>
    <?php } ?>
    if ($('.typeahead.input-sm').length) {
      $('.typeahead.input-sm').siblings('input.tt-hint').addClass('hint-small');
    }

    $.extend($.fn.select2.defaults, {
      formatNoMatches: function () { return "<?php echo addslashes($text_no_matches_found); ?>"; },
      formatInputTooShort: function (input, min) { var n = min - input.length; return "<?php echo addslashes($text_input_too_short); ?>".replace("%d", n); },
      formatInputTooLong: function (input, max) { var n = input.length - max; return "<?php echo addslashes($text_input_too_long); ?>".replace("%d", n); },
      formatSelectionTooBig: function (limit) { return "<?php echo addslashes($text_selection_too_big); ?>".replace("%d", limit); },
      formatLoadMore: function (pageNumber) { return "<?php echo addslashes($text_loading_more_results); ?>"; },
      formatSearching: function () { return "<?php echo addslashes($text_searching); ?>"; }
    });

    if (moment != undefined) {
      moment.lang('<?php echo $code; ?>');
    }

    function show_quick_edit_modal(response, success_callback) {
      if (response.success) {
        $('#actionQuickEditModal .modal-body form fieldset').html(response.data);

        if (response.title) {
          $("#actionQuickEditModal .modal-title").html(response.title);
        }

        $("#actionQuickEditModal").modal("show");

        $("#actionQuickEditModal").on('click', '.modal-footer .cancel', function(e) {
          xhr && xhr.abort();
        }).on('click', '.modal-footer .submit', function(e) {
          if (typeof success_callback === 'function') {
            if (typeof CKEDITOR !== "undefined" && CKEDITOR.instances) {
              for (var inst in CKEDITOR.instances) {
                CKEDITOR.instances[inst].updateElement();
              }
            }
            var data = $('#actionQuickEditModal .modal-body form').serializeObject();
            success_callback.call(this, data);
            if (typeof CKEDITOR !== "undefined" && CKEDITOR.instances) {
              CKEDITOR.instances = {};
            }
          } else {
            $(this).closest('.modal').modal('hide');
          }
        });

        $('#actionQuickEditModal').on('hide.bs.modal', function () {
          $('#actionQuickEditModal').off('hide.bs.modal');
        }).on('hidden.bs.modal', function() {
          $('#actionQuickEditModal .modal-body form fieldset').empty();
          $("#actionQuickEditModal .modal-title").empty();
          $('#actionQuickEditModal').off('hidden.bs.modal');
          $('#actionQuickEditModal').off('click', '.modal-footer .cancel');
          $('#actionQuickEditModal').off('click', '.modal-footer .submit');
        })

      } else {
        var dismiss = true;
        if (response.alerts) {
          $.each(response.alerts, function(type, msg) {
            if ($.isArray(msg)) {
              $.each(msg, function(i, m) {
                if (m) {
                  bull5i.display_alert(m, type, 0, dismiss);
                  dismiss = false;
                }
              });
            } else if (msg) {
              bull5i.display_alert(msg, type, 0, dismiss);
              dismiss = false;
            }
          });
        }
        if (response.msg) {
          bull5i.display_alert(response.msg, "error", 0, dismiss);
        }
      }
    }

    $('body').on('click', 'td button.action', function(e) {
      var td = $(this).closest('td').get(0)
        , column = $(this).attr('data-column')
        , aPos = oTable.fnGetPosition(td)
        , aData = oTable.fnGetData(td)
        , oSettings = oTable.fnSettings()
        , id = oSettings.aoData[aPos[0]]._aData.id;

      if (id != undefined && column != undefined) {
        if (bull5i.processing) {
          bull5i.processing(true);
        }
        $.when( $.ajax({
          url: '<?php echo $load; ?>',
          type: 'POST',
          cache: false,
          dataType: 'json',
          data: { id: id, column: column }
        }) )
        .then(
          function(response, status, xhr) {
            show_quick_edit_modal(response, function(data) {
              var $modal = $(this).closest('.modal')
                , $form = $($(this).attr("data-form"))
                , $overlay = $modal.find(".aqe-overlay")
                , $submit = $(this)
                , data = {id: id, column: column, value: $.isEmptyObject(data) ? null : data, old: ''};

              if ($('#batch-edit').is(':checked') && $('input[name*=\'selected\']:checked').length) {
                data.ids = $('input[name*=\'selected\']:checked').serializeObject().selected;
              }

              xhr = $.ajax({
                type: 'POST',
                url: '<?php echo $update; ?>',
                dataType: 'json',
                data: data,
                beforeSend: function() {
                  if ($overlay) {
                    $overlay.css("display","block");
                    setTimeout(function(){
                      $overlay.addClass("in");
                    }, 0);
                  }
                  $("fieldset", $form).attr("disabled", true);
                  $submit.attr("disabled", true)
                },
                success: function(data) {
                  $(".has-error span.help-block", $form).remove();
                  $("div.form-group.has-error", $form).removeClass("has-error");
                  $("div.notice", $modal).empty();

                  if (data && data.success) {
                    $modal.modal('hide');
                    if ((data.alerts || data.msg) && bull5i.display_alert) {
                      setTimeout(function() {
                        var dismiss = true;
                        if (data.msg) {
                          bull5i.display_alert(data.msg, "success", 5000, dismiss);
                          dismiss = false;
                        }

                        if (data.alerts) {
                          $.each(data.alerts, function(type, msg) {
                            if ($.isArray(msg)) {
                              $.each(msg, function(i, m) {
                                if (m) {
                                  bull5i.display_alert(m, type, 0, dismiss);
                                  dismiss = false;
                                }
                              });
                            } else if (msg) {
                              bull5i.display_alert(msg, type, 0, dismiss);
                              dismiss = false;
                            }
                          });
                        }
                      }, 500);
                    }

                    updateRelated(column, data.results.done);
                  } else {
                    if (data.errors) {
                      $.each(data.errors, function(k, v) {
                        $el = $("[name='" + k + "']", $form)
                        $el.closest(".form-group").addClass("has-error")
                        $el.parent().append($("<span/>", {"class":"help-block"}).html(v))
                      });
                    }
                    if (data.alerts) {
                      $.each(data.alerts, function(type, msg) {
                        if ($.isArray(msg)) {
                          $.each(msg, function(i, m) {
                            if (m) {
                              if (bull5i.alert_classes[type]) {
                                $("<div/>", {"class":"fade in alert " + bull5i.alert_classes[type]}).html(m).prepend($("<button/>", {"type":"button","class":"close","data-dismiss":"alert","aria-hidden":"true"}).html('&times;')).appendTo($("div.notice", $modal));
                              } else {
                                $("<div/>", {"class":"fade in alert alert-danger"}).html(m).prepend($("<button/>", {"type":"button","class":"close","data-dismiss":"alert","aria-hidden":"true"}).html('&times;')).appendTo($("div.notice", $modal));
                              }
                            }
                          });
                        } else if (msg) {
                          if (bull5i.alert_classes[type]) {
                            $("<div/>", {"class":"fade in alert " + bull5i.alert_classes[type]}).html(msg).prepend($("<button/>", {"type":"button","class":"close","data-dismiss":"alert","aria-hidden":"true"}).html('&times;')).appendTo($("div.notice", $modal));
                          } else {
                            $("<div/>", {"class":"fade in alert alert-danger"}).html(msg).prepend($("<button/>", {"type":"button","class":"close","data-dismiss":"alert","aria-hidden":"true"}).html('&times;')).appendTo($("div.notice", $modal));
                          }
                        }
                      });
                    }
                  }
                },
                complete: function() {
                  if ($overlay) {
                    $overlay.removeClass("in");

                    function hideElement() {
                      $overlay.css("display","none");
                    }

                    $.support.transition && $overlay.hasClass('fade') ?
                      $overlay
                        .one($.support.transition.end, hideElement)
                        .emulateTransitionEnd(500) :
                      hideElement()
                  }
                  $("fieldset", $form).attr("disabled", false);
                  $submit.attr("disabled", false);
                }
              });
              e.preventDefault();
            });
          },
          function(xhr, status, error) {
            if (bull5i.display_alert) {
              bull5i.display_alert(bull5i.texts.error_ajax_request, "error", 0);
            }
          } )
        .always(function() {
          if (bull5i.processing) {
            bull5i.processing(false);
          }
        });
      }
    })
  });
}( window.bull5i = window.bull5i || {}, jQuery ));
//--></script>
<?php echo $footer; ?>
