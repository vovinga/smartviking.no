<?php
switch($column) {
  case 'attributes': ?>
<table id="qe-attributes" cellpadding="0" cellspacing="0" border="0" class="table table-condensed<?php echo ($aqe_row_hover_highlighting) ? ' table-hover' : ''; ?><?php echo ($aqe_alternate_row_colour) ? ' table-striped' : ''; ?> qe">
  <thead>
    <tr>
      <th class="text-left act-qe-ta"><?php echo $entry_attribute; ?></th>
      <th class="text-left"><?php echo $entry_text; ?></th>
      <th width="1"></th>
    </tr>
  </thead>
  <tbody data-bind="foreach: attributes">
    <tr>
      <td>
        <input type="text" class="form-control attributes typeahead" placeholder="<?php echo $text_autocomplete; ?>" data-bind="value: name" />
        <input type="hidden" data-bind="attr: {name: 'product_attribute[' + $index()  + '][attribute_id]'}, value: id" data-column="<?php echo $column; ?>" />
      </td>
      <td class="multi-lang-values">
        <!-- ko foreach: values -->
        <div class="input-group">
          <textarea class="form-control input-sm" rows="2" data-bind="attr: {name: 'product_attribute[' + $parentContext.$index() + '][value][' + language_id + ']'}, value: value"></textarea>
          <span class="input-group-addon" data-bind="attr: {title: $root.languages[language_id].name}"><img data-bind="attr: {src: $root.languages[language_id].flag}" /></span>
        </div>
        <!-- /ko -->
      </td>
      <td class="text-vertical-middle"><button type="button" class="btn btn-warning" data-bind="click: $parent.removeAttribute"><i class="fa fa-trash-o"></i> <?php echo $button_remove; ?></button></td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="3" class="text-right"><button type="button" class="btn btn-success" data-bind="click: addAttribute"><i class="fa fa-plus"></i> <?php echo $button_add_attribute; ?></button></td>
    </tr>
  </tfoot>
</table>
<script type="text/javascript"><!--
(function( bull5i, $, undefined ) {
    var ta_options = {
      name: '<?php echo $column; ?>',
      remote: '<?php echo $typeahead; ?>',
      limit: 10,
      template: [
        '<p style="white-space:nowrap;float:left;"><strong>{{value}}</strong></p>' +
        '<p style="white-space:nowrap;font-style:italic;float:right;">{{group}}</p>'
      ].join(''),
      engine: Hogan
    };

    function attachTypeahead() {
      $('#qe-attributes .attributes.typeahead').not('.tt-query').on('typeahead:selected', function(e, datum, name) {
        $(this).data('ta-selected', datum).data('ta-name', name);
        $(this).closest("td").find("input[type=hidden][data-column=" + name + "]").val(datum.id);
        if ($(this).val() != datum.value) {
          $(this).typeahead('setQuery', datum.value);
        }
      }).on('typeahead:autocompleted', function(e, datum, name) {
        $(this).data('ta-selected', datum).data('ta-name', name);
        $(this).closest("td").find("input[type=hidden][data-column=" + name + "]").val(datum.id);
        if ($(this).val() != datum.value) {
          $(this).typeahead('setQuery', datum.value);
        }
      }).on('typeahead:closed', function() {
        if ($(this).data('ta-selected') == undefined) {
          $(this).typeahead('setQuery', '');
        } else if ($(this).val() != $(this).data('ta-selected').value) {
          $(this).typeahead('setQuery', '');
          $(this).closest("td").find("input[type=hidden][data-column=" + $(this).data('ta-name') + "]").val('');
          $(this).removeData('ta-selected');
          $(this).removeData('ta-name');
        }
      });

      $('#qe-attributes .attributes.typeahead').not('.tt-query').typeahead(ta_options);
    }

    var Language = function(id, name, flag) {
      this.id = id;
      this.name = name;
      this.flag = flag;
    }

    var AttributeValue = function(value, language_id) {
      //this.language = new Language(data.language.id, data.language.name, data.language.flag);
      this.language_id = language_id;
      this.value = ko.observable(value);
    }

    var Attribute = function(id, name, values) {
      this.id = ko.observable(id);
      this.name = ko.observable(name);
      this.values = ko.observableArray(ko.utils.arrayMap(values, function(attr_val) { return new AttributeValue(attr_val.value, attr_val.language_id); } ));
    }

    var AttributeViewModel = function() {
      var self = this;
      self.attributes = ko.observableArray(ko.utils.arrayMap(<?php echo json_encode($product_attributes); ?>, function(attr) { return new Attribute(attr.attribute_id, attr.name, attr.values); } ));
      self.languages = {};

      $.each(<?php echo json_encode($languages); ?>, function(k, v) {
        self.languages[k] = new Language(v.language_id, v.name, 'view/image/flags/' + v.image);
      });

      // Operations
      self.removeAttribute = function(attribute) { self.attributes.remove(attribute); }
      self.addAttribute = function() {
        var values = [];
        $.each(self.languages, function(i, v){
          values.push({value: "", language_id: v.id});
        })
        self.attributes.push(new Attribute(null, "", values));
        attachTypeahead();
      }
    }

    ko.applyBindings(new AttributeViewModel, $("#qe-attributes")[0]);

    attachTypeahead();

    $("#qe-attributes .attributes.typeahead").each(function(i, v) {
      var value = $(this).val()
        , id = $(this).closest("td").find("input[type=hidden][data-column=<?php echo $column; ?>]").val();
      $(this).data('ta-selected', {"value": value, "id": id})
      .data('ta-name', '<?php echo $column; ?>')
      .typeahead('setQuery', value);
    })
}( window.bull5i = window.bull5i || {}, jQuery ));
//--></script>
    <?php break;
  case 'discounts': ?>
<table id="qe-discounts" cellpadding="0" cellspacing="0" border="0" class="table table-condensed<?php echo ($aqe_row_hover_highlighting) ? ' table-hover' : ''; ?><?php echo ($aqe_alternate_row_colour) ? ' table-striped' : ''; ?> qe">
  <thead>
    <tr>
      <th class="text-left"><?php echo $entry_customer_group; ?></th>
      <th class="text-right quantity"><?php echo $entry_quantity; ?></th>
      <th class="text-right priority"><?php echo $entry_priority; ?></th>
      <th class="text-right price"><?php echo $entry_price; ?></th>
      <th class="text-left"><?php echo $entry_date_start; ?></th>
      <th class="text-left"><?php echo $entry_date_end; ?></th>
      <th width="1"></th>
    </tr>
  </thead>
  <tbody data-bind="foreach: discounts">
    <tr>
      <td class="text-left">
        <select class="form-control" data-bind="attr: {name: 'product_discount[' + $index()  + '][customer_group_id]'}, value: customer_group_id">
          <?php foreach ($customer_groups as $customer_group) { ?>
          <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
          <?php } ?>
        </select>
      </td>
      <td class="text-right"><input type="text" class="form-control text-right quantity" data-bind="attr: {name: 'product_discount[' + $index() + '][quantity]'}, value: quantity" /></td>
      <td class="text-right"><input type="text" class="form-control text-right priority" data-bind="attr: {name: 'product_discount[' + $index() + '][priority]'}, value: priority" /></td>
      <td class="text-right"><input type="text" class="form-control text-right price" data-bind="attr: {name: 'product_discount[' + $index() + '][price]'}, value: price" /></td>
      <td class="text-left"><input type="text" class="form-control date" data-bind="attr: {name: 'product_discount[' + $index() + '][date_start]'}, value: date_start" /></td>
      <td class="text-left"><input type="text" class="form-control date" data-bind="attr: {name: 'product_discount[' + $index() + '][date_end]'}, value: date_end" /></td>
      <td class="text-vertical-middle"><button type="button" class="btn btn-warning" data-bind="click: $parent.removeDiscount"><i class="fa fa-trash-o"></i> <?php echo $button_remove; ?></button></td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="7" class="text-right"><button type="button" class="btn btn-success" data-bind="click: addDiscount"><i class="fa fa-plus"></i> <?php echo $button_add_discount; ?></button></td>
    </tr>
  </tfoot>
</table>
<script type="text/javascript"><!--
(function( bull5i, $, undefined ) {
    var Discount = function(customer_group_id, quantity, priority, price, date_start, date_end) {
      this.customer_group_id = ko.observable(customer_group_id);
      this.quantity = ko.observable(quantity);
      this.priority = ko.observable(priority);
      this.price = ko.observable(price);
      this.date_start = ko.observable(date_start);
      this.date_end = ko.observable(date_end);
    }

    var DiscountViewModel = function() {
      var self = this;
      self.discounts = ko.observableArray(ko.utils.arrayMap(<?php echo json_encode($product_discounts); ?>, function(discount) { return new Discount(discount.customer_group_id, discount.quantity, discount.priority, discount.price, discount.date_start, discount.date_end); } ));

      // Operations
      self.removeDiscount = function(discount) { self.discounts.remove(discount); }
      self.addDiscount = function() {
        self.discounts.push(new Discount(null, 0, 0, "0.0000", "0000-00-00", "0000-00-00"));
      }
    }

    ko.applyBindings(new DiscountViewModel, $("#qe-discounts")[0]);
}( window.bull5i = window.bull5i || {}, jQuery ));
//--></script>
    <?php break;
  case 'specials': ?>
<table id="qe-specials" cellpadding="0" cellspacing="0" border="0" class="table table-condensed<?php echo ($aqe_row_hover_highlighting) ? ' table-hover' : ''; ?><?php echo ($aqe_alternate_row_colour) ? ' table-striped' : ''; ?> qe">
  <thead>
    <tr>
      <th class="text-left"><?php echo $entry_customer_group; ?></th>
      <th class="text-right priority"><?php echo $entry_priority; ?></th>
      <th class="text-right price"><?php echo $entry_price; ?></th>
      <th class="text-left"><?php echo $entry_date_start; ?></th>
      <th class="text-left"><?php echo $entry_date_end; ?></th>
      <th width="1"></th>
    </tr>
  </thead>
  <tbody data-bind="foreach: specials">
    <tr>
      <td class="text-left">
        <select class="form-control" data-bind="attr: {name: 'product_special[' + $index()  + '][customer_group_id]'}, value: customer_group_id">
          <?php foreach ($customer_groups as $customer_group) { ?>
          <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
          <?php } ?>
        </select>
      </td>
      <td class="text-right"><input type="text" class="form-control text-right priority" data-bind="attr: {name: 'product_special[' + $index() + '][priority]'}, value: priority" /></td>
      <td class="text-right"><input type="text" class="form-control text-right price" data-bind="attr: {name: 'product_special[' + $index() + '][price]'}, value: price" /></td>
      <td class="text-left"><input type="text" class="form-control date" data-bind="attr: {name: 'product_special[' + $index() + '][date_start]'}, value: date_start" /></td>
      <td class="text-left"><input type="text" class="form-control date" data-bind="attr: {name: 'product_special[' + $index() + '][date_end]'}, value: date_end" /></td>
      <td class="text-vertical-middle"><button type="button" class="btn btn-warning" data-bind="click: $parent.removeSpecial"><i class="fa fa-trash-o"></i> <?php echo $button_remove; ?></button></td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="7" class="text-right"><button type="button" class="btn btn-success" data-bind="click: addSpecial"><i class="fa fa-plus"></i> <?php echo $button_add_special; ?></button></td>
    </tr>
  </tfoot>
</table>
<script type="text/javascript"><!--
(function( bull5i, $, undefined ) {
    var Special = function(customer_group_id, priority, price, date_start, date_end) {
      this.customer_group_id = ko.observable(customer_group_id);
      this.priority = ko.observable(priority);
      this.price = ko.observable(price);
      this.date_start = ko.observable(date_start);
      this.date_end = ko.observable(date_end);
    }

    var SpecialViewModel = function() {
      var self = this;
      self.specials = ko.observableArray(ko.utils.arrayMap(<?php echo json_encode($product_specials); ?>, function(special) { return new Special(special.customer_group_id, special.priority, special.price, special.date_start, special.date_end); } ));

      // Operations
      self.removeSpecial = function(special) { self.specials.remove(special); }
      self.addSpecial = function() {
        var values = [];
        self.specials.push(new Special(null, 0, "0.0000", "0000-00-00", "0000-00-00"));
      }
    }

    ko.applyBindings(new SpecialViewModel, $("#qe-specials")[0]);
}( window.bull5i = window.bull5i || {}, jQuery ));
//--></script>
    <?php break;
  case 'filters': ?>
<div class="row" id="qe-filters">
  <div class="col-xs-12">
    <select name="product_filter[]" multiple="multiple" size="12" class="form-control">
    <?php foreach ($filters as $fg) { ?>
    <optgroup label="<?php echo addslashes($fg['name']); ?>">
    <?php foreach ($fg['filters'] as $f) { ?>
      <option value="<?php echo $f['filter_id']; ?>"<?php echo (in_array($f['filter_id'], $product_filters)) ? ' selected': ''; ?>><?php echo $f['name']; ?></option>
    <?php } ?>
    </optgroup>
    <?php } ?>
    </select>
  </div>
</div>
<script type="text/javascript"><!--
(function( bull5i, $, undefined ) {
  $(function(){
    $("#qe-filters select").select2({
      placeholder: "<?php echo addslashes($text_select_filter); ?>",
      allowClear: true,
      formatSelection: function(object, container) {
        var $parent = $(object.element).parent();
        if ($parent && $parent.is('optgroup') && $parent.attr('label')) {
          return $parent.attr('label') + ' &gt; ' + object.text;
        } else {
          return object.text;
        }
      }
    });
  });
}( window.bull5i = window.bull5i || {}, jQuery ));
//--></script>
    <?php break;
  case 'profiles': ?>
<table id="qe-profiles" cellpadding="0" cellspacing="0" border="0" class="table table-condensed<?php echo ($aqe_row_hover_highlighting) ? ' table-hover' : ''; ?><?php echo ($aqe_alternate_row_colour) ? ' table-striped' : ''; ?> qe">
  <thead>
    <tr>
      <th class="text-left"><?php echo $entry_profile; ?></th>
      <th class="text-left"><?php echo $entry_customer_group; ?></th>
      <th width="1"></th>
    </tr>
  </thead>
  <tbody data-bind="foreach: profiles">
    <tr>
      <td class="text-left">
        <select class="form-control" data-bind="attr: {name: 'product_profile[' + $index()  + '][profile_id]'}, value: profile_id">
          <?php foreach ($profiles as $profile) { ?>
          <option value="<?php echo $profile['profile_id']; ?>"><?php echo $profile['name']; ?></option>
          <?php } ?>
        </select>
      </td>
      <td class="text-left">
        <select class="form-control" data-bind="attr: {name: 'product_profile[' + $index()  + '][customer_group_id]'}, value: customer_group_id">
          <?php foreach ($customer_groups as $customer_group) { ?>
          <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
          <?php } ?>
        </select>
      </td>
      <td class="text-vertical-middle"><button type="button" class="btn btn-warning" data-bind="click: $parent.removeProfile"><i class="fa fa-trash-o"></i> <?php echo $button_remove; ?></button></td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="3" class="text-right"><button type="button" class="btn btn-success" data-bind="click: addProfile"><i class="fa fa-plus"></i> <?php echo $button_add_profile; ?></button></td>
    </tr>
  </tfoot>
</table>
<script type="text/javascript"><!--
(function( bull5i, $, undefined ) {
  var Profile = function(profile_id, customer_group_id) {
    this.profile_id = ko.observable(profile_id);
    this.customer_group_id = ko.observable(customer_group_id);
  }

  var ProfileViewModel = function() {
    var self = this;
    self.profiles = ko.observableArray(ko.utils.arrayMap(<?php echo json_encode($product_profiles); ?>, function(profile) { return new Profile(profile.profile_id, profile.customer_group_id); } ));

    // Operations
    self.removeProfile = function(profile) { self.profiles.remove(profile); }
    self.addProfile = function() {
      self.profiles.push(new Profile(null, null));
    }
  }

  ko.applyBindings(new ProfileViewModel, $("#qe-profiles")[0]);
}( window.bull5i = window.bull5i || {}, jQuery ));
//--></script>
    <?php break;
  case 'related': ?>
<div class="row" id="qe-related">
  <div class="col-xs-12">
    <!-- ko foreach: related -->
    <input type="hidden" name="product_related[]" data-bind="value: $data" />
    <!-- /ko -->
    <input type="hidden" id="rp-input" class="form-control" value="<?php echo implode(",", array_keys($product_related)); ?>">
  </div>
</div>
<script type="text/javascript"><!--
(function( bull5i, $, undefined ) {
  var RelatedViewModel = function() {
    var self = this;
    self.related = ko.observableArray(ko.utils.arrayMap(<?php echo json_encode(array_keys($product_related)); ?>, function(related) { return related.toString(); }));

    // Operations
    self.removeRelated = function(related_id) { self.related.remove(related_id); }
    self.addRelated = function(related_id) {
      self.related.push(related_id);
    }
  }
  var relatedVM = new RelatedViewModel;
  ko.applyBindings(relatedVM, $("#qe-related")[0]);
  $(function(){
    var initialData = <?php echo json_encode($product_related); ?>;
    $("#rp-input").select2({
      placeholder: "<?php echo addslashes($text_autocomplete); ?>",
      allowClear: true,
      minimumInputLength: 1,
      multiple: true,
      formatResult: function(object, container, query) {
        if (object.model) {
          return $('<span/>').append(
            $('<strong/>').html(object.text),
            $('<small/>', {'style':"padding-left:25px;", 'class': 'text-muted'}).html(object.model)
          );
        } else {
          return object.text;
        }
      },
      initSelection : function (element, callback) {
        var data = [];
        $(element.val().split(",")).each(function (i, v) {
            data.push({ id: v, text: initialData.hasOwnProperty(v) ? initialData[v].name : v });
        });
        callback(data);
      },
      ajax: {
        type: 'GET',
        url: "<?php echo $filter; ?>",
        dataType: 'json',
        cache: false,
        quietMillis: 150,
        data: function (term, page) {
          return {
            query: term,
            type: "product",
            token: "<?php echo $token; ?>"
          };
        },
        results: function (data, page) {
          var results = []
          $.each(data, function(i,v) {
            if (v.id != <?php echo $product_id; ?>) {
              results.push({id: v.id, text: v.value, model: v.model})
            }
          })
          return {results: results};
        }
      }
    });
    $('#rp-input').on('change', function(e) {
      if (e.added) {
        relatedVM.addRelated(e.added.id);
      } else if (e.removed) {
        relatedVM.removeRelated(e.removed.id);
      }
    })
  });
}( window.bull5i = window.bull5i || {}, jQuery ));
//--></script>
    <?php break;
  case 'descriptions': ?>
<div class="row" id="qe-descriptions">
  <div class="col-xs-12">
    <ul class="nav nav-tabs">
      <?php foreach ($languages as $language) { ?>
      <li><a href="#lang-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
      <?php } ?>
    </ul>
    <div class="tab-content">
      <?php foreach ($languages as $language) { ?>
      <div class="tab-pane" id="lang-<?php echo $language['language_id']; ?>">
        <div class="form-group">
          <label for="description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
          <textarea name="product_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($product_description[$language['language_id']]['description']) ? $product_description[$language['language_id']]['description'] : ''; ?></textarea>
        </div>
        <div class="form-group">
          <label for="meta_description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
          <textarea name="product_description[<?php echo $language['language_id']; ?>][meta_description]" class="form-control input-sm" rows="3" id="meta_description<?php echo $language['language_id']; ?>"><?php echo isset($product_description[$language['language_id']]['meta_description']) ? $product_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
        </div>
        <div class="form-group">
          <label for="meta_keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
          <textarea name="product_description[<?php echo $language['language_id']; ?>][meta_keyword]" class="form-control input-sm" rows="3" id="meta_keyword<?php echo $language['language_id']; ?>"><?php echo isset($product_description[$language['language_id']]['meta_keyword']) ? $product_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
(function( bull5i, $, undefined ) {
  $("#qe-descriptions .nav.nav-tabs a:first").tab('show');
}( window.bull5i = window.bull5i || {}, jQuery ));
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>', {
  filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
  filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
//--></script>
    <?php break;
  case 'images': ?>
<table id="qe-images" cellpadding="0" cellspacing="0" border="0" class="table table-condensed<?php echo ($aqe_row_hover_highlighting) ? ' table-hover' : ''; ?><?php echo ($aqe_alternate_row_colour) ? ' table-striped' : ''; ?> qe">
  <thead>
    <tr>
      <th class="text-left"><?php echo $entry_image; ?></th>
      <th class="text-right sort-order"><?php echo $entry_sort_order; ?></th>
      <th width="1"></th>
    </tr>
  </thead>
  <tbody data-bind="foreach: images">
    <tr>
      <td class="text-left">
        <img data-bind="attr: {src: thumb, id: 'ai-thumb-' + $index()}" class="img-thumbnail">
        <input type="hidden" data-bind="attr: {name: 'product_image[' + $index()  + '][image]', id: 'a-image-' + $index()}, value: image" />
        <span>
          <button type="button" class="btn btn-xs btn-link" data-bind="click: $parent.browseImage"><?php echo $text_browse; ?></button> /
          <button type="button" class="btn btn-xs btn-link" data-bind="click: $parent.clearImage"><?php echo $text_clear; ?></button>
        </span>
      </td>
      <td class="text-vertical-middle text-right"><input type="text" class="form-control text-right sort-order" data-bind="attr: {name: 'product_image[' + $index() + '][sort_order]'}, value: sort_order" /></td>
      <td class="text-vertical-middle"><button type="button" class="btn btn-warning" data-bind="click: $parent.removeImage"><i class="fa fa-trash-o"></i> <?php echo $button_remove; ?></button></td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="3" class="text-right"><button type="button" class="btn btn-success" data-bind="click: addImage"><i class="fa fa-plus"></i> <?php echo $button_add_image; ?></button></td>
    </tr>
  </tfoot>
</table>
<script type="text/javascript"><!--
(function( bull5i, $, undefined ) {
  var no_image = '<?php echo $no_image; ?>';
  var Image = function(image, thumb, sort_order) {
    this.image = ko.observable(image);
    this.thumb = ko.observable(thumb);
    this.sort_order = ko.observable(sort_order);
  }

  var ImageViewModel = function() {
    var self = this;
    self.images = ko.observableArray(ko.utils.arrayMap(<?php echo json_encode($product_images); ?>, function(image) { return new Image(image.image, image.thumb, image.sort_order); } ));

    // Operations
    self.removeImage = function(image) { self.images.remove(image); }
    self.clearImage = function(image) { image.image(''); image.thumb(no_image); }
    self.browseImage = function(image) {
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
            url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent(new_image) + '&width=<?php echo $additional_image_width; ?>&height=<?php echo $additional_image_height; ?>',
            dataType: 'text',
            success: function(data) {
              image.image(new_image);
              image.thumb(data)
            }
          });
        }
        $('#imageManagerModal').off('hide.bs.modal');
      }).on('hidden.bs.modal', function() {
        $('#imageManagerModal .modal-body .image-manager').empty();
        $('#imageManagerModal').off('hidden.bs.modal');
      })
    }
    self.addImage = function() {
      self.images.push(new Image('', no_image, 0));
    }
  }

  var imageVM = new ImageViewModel;

  ko.applyBindings(imageVM, $("#qe-images")[0]);
}( window.bull5i = window.bull5i || {}, jQuery ));
//--></script>
    <?php break;
  case 'options': ?>
<div style="padding-right:15px;" id="qe-options">
  <div class="row">
  <div class="col-xs-4 col-sm-4 col-md-3 tabs-left">
    <ul class="nav nav-tabs nav-stacked">
      <!-- ko foreach: options -->
      <li data-bind="attr: {class: $index() == 0 ? 'active' : ''}"><a data-bind="attr: {href: '#tab-option-' + $index()}" data-toggle="tab"><!-- ko text: name --><!-- /ko --> <button type="button" class="btn btn-xs btn-link remove-option" data-bind="click: $parent.removeOption"><i class="fa fa-minus-circle text-danger"></i></button></a></li>
      <!-- /ko -->
      <li>
        <div class="input-group">
          <input type="text" class="form-control options typeahead" placeholder="<?php echo $text_autocomplete; ?>">
          <span class="input-group-btn">
            <button type="button" class="btn btn-default" data-bind="click: $root.addOption"><i class="fa fa-plus-circle text-success"></i></button>
          </span>
        </div>
      </li>
    </ul>
  </div>
  <form class="form-horizontal" role="form">
  <div class="col-xs-8 col-sm-8 col-md-9">
    <div class="tab-content">
      <!-- ko foreach: options -->
      <div data-bind="attr: {id: 'tab-option-' + $index(), class: $index() == 0 ? 'tab-pane active' : 'tab-pane'}">
        <div class="row">
          <input type="hidden" data-bind="attr: {name: 'product_option[' + $index()  + '][product_option_id]'}, value: product_option_id" />
          <input type="hidden" data-bind="attr: {name: 'product_option[' + $index()  + '][option_id]'}, value: option_id" />
          <input type="hidden" data-bind="attr: {name: 'product_option[' + $index()  + '][name]'}, value: name" />
          <input type="hidden" data-bind="attr: {name: 'product_option[' + $index()  + '][type]'}, value: type" />
          <div class="form-group">
            <label data-bind="attr: {for: 'inputRequired' + $index()}" class="col-sm-3 col-lg-2 control-label"><?php echo $entry_required; ?></label>
            <div class="col-sm-3 col-md-2">
              <select data-bind="attr: {id: 'inputRequired' + $index(), name: 'product_option[' + $index()  + '][required]'}, value: required" class="form-control">
                <option value="1"><?php echo $text_yes; ?></option>
                <option value="0"><?php echo $text_no; ?></option>
              </select>
            </div>
          </div>
          <!-- ko if: type() == "text" -->
          <div class="form-group">
            <label data-bind="attr: {for: 'inputOptionValue' + $index()}" class="col-sm-3 col-lg-2 control-label"><?php echo $entry_option_value; ?></label>
            <div class="col-sm-9 col-lg-10">
              <input type="text" data-bind="attr: {id: 'inputOptionValue' + $index(), name: 'product_option[' + $index()  + '][option_value]'}, value: option_value" class="form-control">
            </div>
          </div>
          <!-- /ko -->
          <!-- ko if: type() == "date" -->
          <div class="form-group">
            <label data-bind="attr: {for: 'inputOptionValue' + $index()}" class="col-sm-3 col-lg-2 control-label"><?php echo $entry_option_value; ?></label>
            <div class="col-sm-4 col-md-3">
              <input type="text" data-bind="attr: {id: 'inputOptionValue' + $index(), name: 'product_option[' + $index()  + '][option_value]'}, value: option_value" class="form-control">
            </div>
          </div>
          <!-- /ko -->
          <!-- ko if: type() == "time" -->
          <div class="form-group">
            <label data-bind="attr: {for: 'inputOptionValue' + $index()}" class="col-sm-3 col-lg-2 control-label"><?php echo $entry_option_value; ?></label>
            <div class="col-sm-3 col-md-2">
              <input type="text" data-bind="attr: {id: 'inputOptionValue' + $index(), name: 'product_option[' + $index()  + '][option_value]'}, value: option_value" class="form-control">
            </div>
          </div>
          <!-- /ko -->
          <!-- ko if: type() == "datetime" -->
          <div class="form-group">
            <label data-bind="attr: {for: 'inputOptionValue' + $index()}" class="col-sm-3 col-lg-2 control-label"><?php echo $entry_option_value; ?></label>
            <div class="col-sm-5 col-md-4">
              <input type="text" data-bind="attr: {id: 'inputOptionValue' + $index(), name: 'product_option[' + $index()  + '][option_value]'}, value: option_value" class="form-control">
            </div>
          </div>
          <!-- /ko -->
          <!-- ko if: type() == "file" -->
          <input type="hidden" data-bind="attr: {id: 'inputOptionValue' + $index(), name: 'product_option[' + $index()  + '][option_value]'}, value: option_value">
          <!-- /ko -->
          <!-- ko if: type() == "textarea" -->
          <div class="form-group">
            <label data-bind="attr: {for: 'inputOptionValue' + $index()}" class="col-sm-3 col-lg-2 control-label"><?php echo $entry_option_value; ?></label>
            <div class="col-sm-9 col-lg-10">
              <textarea data-bind="attr: {id: 'inputOptionValue' + $index(), name: 'product_option[' + $index()  + '][option_value]'}, value: option_value" class="form-control" rows="5"></textarea>
            </div>
          </div>
          <!-- /ko -->
          <!-- ko if: $.inArray(type(), ['select', 'radio', 'checkbox', 'image']) != -1 -->
          <table cellpadding="0" cellspacing="0" border="0" class="table table-condensed<?php echo ($aqe_row_hover_highlighting) ? ' table-hover' : ''; ?><?php echo ($aqe_alternate_row_colour) ? ' table-striped' : ''; ?> qe">
            <thead>
              <tr>
                <th class="text-left"><?php echo $entry_option_value; ?></th>
                <th class="text-right quantity"><?php echo $entry_quantity; ?></th>
                <th class="text-left subtract"><?php echo $entry_subtract; ?></th>
                <th class="text-right price"><?php echo $entry_price; ?></th>
                <th class="text-right points"><?php echo $entry_option_points; ?></th>
                <th class="text-right weight"><?php echo $entry_weight; ?></th>
                <th width="1"></th>
              </tr>
            </thead>
            <tbody data-bind="foreach: option_value">
              <tr>
                <td class="text-vertical-middle text-left">
                  <select data-bind="attr: {name: 'product_option[' + $parentContext.$index() + '][product_option_value][' + $index() + '][option_value_id]'}, options: $root.option_values[$parent.option_id()], optionsValue: 'option_value_id', optionsText: 'name', value: option_value_id" class="form-control">
                    <option data-bind="value: option_value_id, text: name"></option>
                  </select>
                  <input type="hidden" data-bind="attr: {name: 'product_option[' + $parentContext.$index() + '][product_option_value][' + $index() + '][product_option_value_id]'}, value: product_option_value_id" /></td>
                </td>
                <td class="text-vertical-middle text-right"><input type="text" class="form-control text-right quantity" data-bind="attr: {name: 'product_option[' + $parentContext.$index() + '][product_option_value][' + $index() + '][quantity]'}, value: quantity" /></td>
                <td class="text-vertical-middle text-left">
                  <select data-bind="attr: {name: 'product_option[' + $parentContext.$index() + '][product_option_value][' + $index() + '][subtract]'}, value: subtract" class="form-control">
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                  </select>
                </td>
                <td class="text-right">
                  <select data-bind="attr: {name: 'product_option[' + $parentContext.$index() + '][product_option_value][' + $index() + '][price_prefix]'}, value: price_prefix" class="form-control prefix">
                    <option value="+"><?php echo $text_plus; ?></option>
                    <option value="-"><?php echo $text_minus; ?></option>
                  </select>
                  <input type="text" class="form-control text-right price" data-bind="attr: {name: 'product_option[' + $parentContext.$index() + '][product_option_value][' + $index() + '][price]'}, value: price" />
                </td>
                <td class="text-right">
                  <select data-bind="attr: {name: 'product_option[' + $parentContext.$index() + '][product_option_value][' + $index() + '][points_prefix]'}, value: points_prefix" class="form-control prefix">
                    <option value="+"><?php echo $text_plus; ?></option>
                    <option value="-"><?php echo $text_minus; ?></option>
                  </select>
                  <input type="text" class="form-control text-right points" data-bind="attr: {name: 'product_option[' + $parentContext.$index() + '][product_option_value][' + $index() + '][points]'}, value: points" />
                </td>
                <td class="text-right">
                  <select data-bind="attr: {name: 'product_option[' + $parentContext.$index() + '][product_option_value][' + $index() + '][weight_prefix]'}, value: weight_prefix" class="form-control prefix">
                    <option value="+"><?php echo $text_plus; ?></option>
                    <option value="-"><?php echo $text_minus; ?></option>
                  </select>
                  <input type="text" class="form-control text-right weight" data-bind="attr: {name: 'product_option[' + $parentContext.$index() + '][product_option_value][' + $index() + '][weight]'}, value: weight" />
                </td>
                <td class="text-vertical-middle"><button type="button" class="btn btn-warning" data-bind="click: $parent.removeOptionValue"><i class="fa fa-trash-o"></i> <?php echo $button_remove; ?></button></td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="7" class="text-right"><button type="button" class="btn btn-success" data-bind="click: addOptionValue"><i class="fa fa-plus"></i> <?php echo $button_add_option; ?></button></td>
              </tr>
            </tfoot>
          </table>
          <!-- /ko -->
        </div>
      </div>
      <!-- /ko -->
    </div>
  </div>
  </form>
</div>
</div>
<script type="text/javascript"><!--
(function( bull5i, $, undefined ) {
    $('#qe-options .options.typeahead').typeahead({
      name: '<?php echo $column; ?>',
      remote: '<?php echo $typeahead; ?>',
      limit: 10,
      template: [
        '<p style="white-space:nowrap;float:left;"><strong>{{value}}</strong></p>' +
        '<p style="white-space:nowrap;font-style:italic;float:right;">{{category}}</p>'
      ].join(''),
      engine: Hogan
    });

    $('#qe-options .options.typeahead').on('typeahead:selected', function(e, datum, name) {
      $(this).data('ta-selected', datum).data('ta-name', name);
      if ($(this).val() != datum.value) {
        $(this).typeahead('setQuery', datum.value);
      }
    }).on('typeahead:autocompleted', function(e, datum, name) {
      $(this).data('ta-selected', datum).data('ta-name', name);
      if ($(this).val() != datum.value) {
        $(this).typeahead('setQuery', datum.value);
      }
    }).on('typeahead:closed', function() {
      if ($(this).data('ta-selected') == undefined) {
        $(this).typeahead('setQuery', '');
      } else if ($(this).val() != $(this).data('ta-selected').value) {
        $(this).typeahead('setQuery', '');
        $(this).removeData('ta-selected');
        $(this).removeData('ta-name');
      }
    });

    var OptionValue = function(product_option_value_id, option_value_id, quantity, subtract, price, price_prefix, points, points_prefix, weight, weight_prefix) {
      this.product_option_value_id = ko.observable(product_option_value_id);
      this.option_value_id = ko.observable(option_value_id);
      this.quantity = ko.observable(quantity);
      this.subtract = ko.observable(subtract);
      this.price = ko.observable(price);
      this.price_prefix = ko.observable(price_prefix);
      this.points = ko.observable(points);
      this.points_prefix = ko.observable(points_prefix);
      this.weight = ko.observable(weight);
      this.weight_prefix = ko.observable(weight_prefix);
    }

    var Option = function(product_option_id, option_id, name, type, required, value) {
      var self = this;

      this.product_option_id = ko.observable(product_option_id);
      this.option_id = ko.observable(option_id);
      this.name = ko.observable(name);
      this.type = ko.observable(type);
      this.required = ko.observable(required);
      if ($.inArray(type, ['select', 'radio', 'checkbox', 'image']) != -1) {
        value = value == undefined ? [] : value;
        this.option_value = ko.observableArray(ko.utils.arrayMap(value, function(opt_val) { return new OptionValue(opt_val.product_option_value_id, opt_val.option_value_id, opt_val.quantity, opt_val.subtract, opt_val.price, opt_val.price_prefix, opt_val.points, opt_val.points_prefix, opt_val.weight, opt_val.weight_prefix); } ));
      } else {
        value = value == undefined ? "" : value;
        this.option_value = ko.observable(value);
      }

      this.removeOptionValue = function(opt_val) { self.option_value.remove(opt_val); }
      this.addOptionValue = function() {
        self.option_value.push(new OptionValue(null, "", 0, 0, "0.0000", "+", 0, "+", "0.0000", "+"))
      }
    }

    var OptionViewModel = function() {
      var self = this;
      self.options = ko.observableArray(ko.utils.arrayMap(<?php echo json_encode($product_options); ?>, function(opt) { return new Option(opt.product_option_id, opt.option_id, opt.name, opt.type, opt.required, opt.product_option_value); } ));
      self.option_values = <?php echo json_encode($option_values); ?>;
      // Operations
      self.removeOption = function(opt) { self.options.remove(opt); }
      self.addOption = function() {
        var $ta = $('#qe-options .options.typeahead');
        if ($ta && $ta.data('ta-selected') != undefined) {
          var data = $ta.data('ta-selected');
          if (data.option_value.length && !self.option_values.hasOwnProperty(data.id)) {
            self.option_values[data.id] = data.option_value;
          }
          self.options.push(new Option("", data.id, data.value, data.type, 0, undefined));
          $ta.typeahead('setQuery', '');
          $ta.removeData('ta-selected');
          $ta.removeData('ta-name');
        }
      }
    }

    ko.applyBindings(new OptionViewModel, $("#qe-options")[0]);
}( window.bull5i = window.bull5i || {}, jQuery ));
//--></script>
    <?php break;
  default:
    break;
}
?>
