<?php echo $header; ?>
<div class="modal fade" id="legal_text" tabindex="-1" role="dialog" aria-labelledby="legal_text_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="legal_text_label"><?php echo $text_terms; ?></h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default cancel" data-dismiss="modal"><i class="fa fa-times"></i> <?php echo $button_close; ?></button>
      </div>
    </div>
  </div>
</div>

<div id="content" class="main-content">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li<?php echo ($breadcrumb['active']) ? ' class="active"' : ''; ?>><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>

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
          <span class="navbar-brand"><i class="fa fa-pencil ext-icon"></i> <?php echo $heading_title; ?></span>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#settings" data-toggle="tab"><?php echo $tab_settings; ?></a></li>
            <li><a href="#support" data-toggle="tab"><?php echo $tab_support; ?></a></li>
            <li><a href="#about" data-toggle="tab"><?php echo $tab_about; ?></a></li>
          </ul>
          <div class="nav navbar-nav btn-group navbar-btn navbar-right">
            <?php if ($update_pending) { ?><button type="button" class="btn btn-primary" id="upgrade" action="<?php echo $upgrade; ?>"><i class="fa fa-arrow-circle-up"></i> <?php echo $button_upgrade; ?></button><?php } ?>
            <button type="button" class="btn btn-default" id="apply" action="<?php echo $save; ?>"<?php echo $update_pending ? ' disabled': ''; ?>><?php echo $button_apply; ?></button>
            <button type="button" class="btn btn-default" id="save" action="<?php echo $save; ?>"<?php echo $update_pending ? ' disabled': ''; ?>><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
            <a href="<?php echo $cancel; ?>" class="btn btn-default"><i class="fa fa-ban"></i> <?php echo $button_cancel; ?></a>
          </div>
        </div>
      </div>
    </nav>
  </div>

  <div class="aqe-content aqe-container">
    <div id="page-overlay" class="aqe-overlay fade">
      <div class="page-overlay-progress"><i class="fa fa-refresh fa-spin fa-5x text-muted"></i></div>
    </div>

    <form action="<?php echo $save; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal" role="form">
      <div class="tab-content">
        <div class="tab-pane active" id="settings">
          <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-cog fa-fw"></i> <?php echo $tab_settings; ?></h3></div>
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-12">
                  <fieldset>
                    <div class="form-group">
                      <label class="col-sm-3 col-md-2 control-label" for="aqe_status"><?php echo $entry_extension_status; ?></label>
                      <div class="col-sm-2 fc-auto-width">
                        <select name="aqe_status" id="aqe_status" class="form-control">
                          <option value="1"<?php echo ((int)$aqe_status) ? ' selected' : ''; ?>><?php echo $text_enabled; ?></option>
                          <option value="0"<?php echo (!(int)$aqe_status) ? ' selected' : ''; ?>><?php echo $text_disabled; ?></option>
                        </select>
                        <input type="hidden" name="aqe_installed" value="1" />
                        <input type="hidden" name="aqe_installed_version" value="<?php echo $installed_version; ?>" />
                        <input type="hidden" name="aqe_multilingual_seo" value="<?php echo $aqe_multilingual_seo; ?>" />
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="alert alert-info"><?php echo $text_more_options; ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="support">
          <div class="panel panel-default">
            <div class="panel-heading">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#support-navbar-collapse">
                  <span class="sr-only"><?php echo $text_toggle_navigation; ?></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <h3 class="panel-title"><i class="fa fa-phone fa-fw"></i> <?php echo $tab_support; ?></h3>
              </div>
              <div class="collapse navbar-collapse" id="support-navbar-collapse">
                <ul class="nav navbar-nav">
                  <li class="active"><a href="#general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                  <li><a href="#faq" data-toggle="tab" title="<?php echo $text_faq; ?>"><?php echo $tab_faq; ?></a></li>
                  <li><a href="#services" data-toggle="tab"><?php echo $tab_services; ?></a></li>
                </ul>
              </div>
            </div>
            <div class="panel-body">
              <div class="tab-content">
                <div class="tab-pane active" id="general">
                  <div class="row">
                    <div class="col-sm-12">
                      <h3>Getting support</h3>
                      <p>I consider support a priority of mine, so if you need any help with your purchase you can contact me in one of the following ways:</p>
                      <ul>
                        <li>Send an email to <a href="mailto:<?php echo $ext_support_email; ?>?subject='<?php echo $text_support_subject; ?>'"><?php echo $ext_support_email; ?></a></li>
                        <li>Post in the <a href="<?php echo $ext_support_forum; ?>" target="_blank">extension forum thread</a> or send me a <a href="http://forum.opencart.com/ucp.php?i=pm&mode=compose&u=17771">private message</a></li>
                        <li><a href="<?php echo $ext_store_url; ?>" target="_blank">Leave a comment</a> in the extension store comments section</li>
                      </ul>
                      <p>I usually reply within a few hours, but can take up to 24 hours.</p>
                      <p>Please note that all support is free if it is an issue with the product. Only issues due conflicts with other third party extensions/modules or custom front end theme are the exception to free support. Resolving such conflicts, customizing the extension or doing additional bespoke work will be provided with the hourly rate of <span id="hourly_rate">USD 50 / EUR 40</span>.</p>

                      <h4>Things to note when asking for help</h4>
                      <p>Please describe your problem in as much detail as possible. When contacting, please provide the following information:</p>
                      <ul>
                        <li>The OpenCart version you are using. <small>This can be found at the bottom of any admin page.</small></li>
                        <li>The extension name and version. <small>You can find this information under the About tab.</small></li>
                        <li>If you got any error messages, please include them in the message.</li>
                        <li>In case the error message is generated by a vQmod cached file, please also attach that file.</li>
                      </ul>
                      <p>Any additional information that you can provide about the issue is greatly appreciated and will make problem solving much faster.</p>

                      <h3 class="page-header">Happy with <?php echo $ext_name; ?>?</h3>
                      <p>I would appreciate it very much if you could <a href="<?php echo $ext_store_url; ?>" target="_blank">rate the extension</a> once you've had a chance to try it out. Why not tell everybody how great this extension is by <a href="<?php echo $ext_store_url; ?>" target="_blank">leaving a comment</a> as well.</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="alert alert-info">
                        <p><?php echo $text_other_extensions; ?></p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="faq">
                  <h3><?php echo $text_faq; ?></h3>
                  <ul class="media-list" id="faqs">
                    <li class="media">
                      <div class="pull-left">
                        <i class="fa fa-question-circle fa-4x media-object"></i>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">How to translate the extension to another language?</h4>

                        <p class="short-answer">Copy the extension language files (<small><em>/admin/language/english/catalog/product_ext.php</em> and <em>/admin/language/english/module/admin_quick_edit.php</em></small>) to your language folder and translate the string inside the copied files.</p>

                        <button type="button" class="btn btn-default btn-sm" data-toggle="collapse" data-target="#translation" data-parent="#faqs">Show the full answer</button>
                        <div class="collapse full-answer" id="translation">
                          <ol>
                            <li>
                              <p><strong>Copy</strong> the following language files <strong>to YOUR_LANGUAGE folder</strong> under the appropriate location as shown below:</p>
                              <div class="btm-mgn">
                                <em class="text-muted"><small>FROM:</small></em>
                                <ul class="list-unstyled">
                                  <li>/admin/language/english/catalog/product_ext.php</li>
                                  <li>/admin/language/english/module/admin_quick_edit.php</li>
                                </ul>
                                <em class="text-muted"><small>TO:</small></em>
                                <ul class="list-unstyled">
                                  <li>/admin/language/YOUR_LANGUAGE/catalog/product_ext.php</li>
                                  <li>/admin/language/YOUR_LANGUAGE/module/admin_quick_edit.php</li>
                                </ul>
                              </div>
                            </li>

                            <li>
                              <p><strong>Open</strong> each copied <strong>language file</strong> with a text editor such as <a href="http://www.sublimetext.com/">Sublime Text</a> or <a href="http://notepad-plus-plus.org/">Notepad++</a> and <strong>make the required translations</strong>. You can also leave the files in English.</p>
                              <p><span class="label label-info">Note</span> You only need to translate the parts that are to the right of the equal sign.</p>
                            </li>
                          </ol>
                        </div>
                      </div>
                    </li>
                    <li class="media">
                      <div class="pull-left">
                        <i class="fa fa-question-circle fa-4x media-object"></i>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading">How to upgrade the extension?</h4>
                        <p class="short-answer">Overwrite the current extension files with new ones and click Upgrade on the extension settings page.</p>

                        <button type="button" class="btn btn-default btn-sm" data-toggle="collapse" data-target="#upgrade" data-parent="#faqs">Show the full answer</button>
                        <div class="collapse full-answer" id="upgrade">
                          <ol>
                            <li>
                              <p><strong>Copy</strong> the <strong>new files</strong> from the <em>FILES TO UPLOAD</em> directory <strong>to the root directory you have installed OpenCart in</strong>.</p>
                              <p><span class="label label-info">Note</span> Do not worry, no core files will be replaced! Only the previously installed <?php echo $ext_name; ?> files will be overwritten.</p>
                            </li>

                            <li>
                              <p><strong>Open</strong> the <?php echo $ext_name; ?> <strong>module settings page</strong> <small>(navigate to <em>Extensions > Modules</em> page and click on the <em>[ Edit ]</em> link next to the <?php echo $ext_name; ?> name)</small> and <strong>refresh the page</strong> by pressing <em>Ctrl + F5</em> twice to force the browser to update the css changes.</p>
                              <p>You should see a notice stating that new version of extension files have been found. <strong>Upgrade the extension</strong> by clicking on the 'Upgrade' button.</p>
                            </li>
                          </ol>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="tab-pane" id="services">
                  <h3>Premium Services</h3>
                  <div id="service-container">
                    <p data-bind="visible: services().length == 0">There are currently no available services for this extension.</p>
                    <table class="table table-hover">
                      <tbody data-bind="foreach: services">
                        <tr class="srvc">
                          <td>
                            <h4 class="service" data-bind="html: name"></h4>
                            <span class="help-block">
                              <p class="description" data-bind="visible: description != '', html: description"></p>
                              <p><strong>Turnaround time</strong>: <span class="turnaround" data-bind="html: turnaround"></span></p>
                              <span class="hidden code" data-bind="html: code"></span>
                            </span>
                          </td>
                          <td class="nowrap text-right top-pad"><span class="currency" data-bind="html: currency"></span> <span class="price" data-bind="html: price"></span></td>
                          <td class="text-right"><button type="button" class="btn btn-sm btn-primary purchase"><i class="fa fa-shopping-cart"></i> Buy Now</button></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="about">
          <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-info fa-fw"></i> <?php echo $tab_about; ?></h3></div>
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-12">
                  <h3><?php echo $text_extension_information; ?></h3>

                  <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label label-normal"><?php echo $entry_extension_name; ?></label>
                    <div class="col-sm-9 col-md-10">
                      <p class="form-control-static"><?php echo $ext_name; ?></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label label-normal"><?php echo $entry_installed_version; ?></label>
                    <div class="col-sm-9 col-md-10">
                      <p class="form-control-static"><strong><?php echo $installed_version; ?></strong></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label label-normal"><?php echo $entry_extension_compatibility; ?></label>
                    <div class="col-sm-9 col-md-10">
                      <p class="form-control-static"><?php echo $ext_compatibility; ?></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label label-normal"><?php echo $entry_extension_store_url; ?></label>
                    <div class="col-sm-9 col-md-10">
                      <p class="form-control-static"><a href="<?php echo $ext_store_url; ?>" target="_blank"><?php echo htmlspecialchars($ext_store_url); ?></a></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 col-md-2 control-label label-normal"><?php echo $entry_copyright_notice; ?></label>
                    <div class="col-sm-9 col-md-10">
                      <p class="form-control-static">&copy; 2011 - <?php echo date("Y"); ?> Romi Agar</p>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9 col-md-offset-2 col-md-10">
                      <p class="form-control-static"><a href="view/static/bull5i_pqe_plus_extension_terms.htm" id="legal_notice" data-modal="#legal_text"><?php echo $text_terms; ?></a></p>
                    </div>
                  </div>

                  <h3 class="page-header"><?php echo $text_license; ?></h3>
                  <p><?php echo $text_license_text; ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript"><!--
window.onload = function() {
  (function( bull5i, $, undefined ) {
    bull5i.texts = $.extend({}, bull5i.texts, {
      error_ajax_request: '<?php echo addslashes($error_ajax_request); ?>'
    });
    $("#legal_text .modal-body").load('view/static/bull5i_pqe_plus_extension_terms.htm');

    $('body').on('click', 'a.external-tab-link', function(e) {
      var tab = $(this).attr("data-target");
      e.preventDefault();
      $("[href=" + tab + "]").trigger('click');
    }).on('click', 'button.purchase', function(e) {
      var $service_container = $(this).closest('tr.srvc')
        , name = $service_container.find('.service').text()
        , code = $service_container.find('.code').text()
        , currency = $service_container.find('.currency').text()
        , amount = parseFloat($service_container.find('.price').text());

        if (name && code && currency && amount) {
          window.open('https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=support@opencart.ee&item_name=' + name + '&item_number=' + code + '&amount=' + amount + '&currency_code=' + currency + '&button_subtype=services&no_note=0&bn=OCEE_BuyNow_WPS_EE');
        }
    });

    var Service = function(code, name, description, currency, price, turnaround) {
      this.code = code;
      this.name = name;
      this.description = description;
      this.currency = currency;
      this.price = price;
      this.turnaround = turnaround;
    }

    var ServiceViewModel = function() {
      var self = this;
      self.services = ko.observableArray([]);

      // Operations
      self.addService = function(code, name, description, currency, price, turnaround) {
        self.services.push(new Service(code, name, description, currency, price, turnaround));
      }
    }

    var serviceVM = new ServiceViewModel();

    ko.applyBindings(serviceVM, $("#service-container")[0]);

    $.when($.ajax({
      url: 'http://www.opencart.ee/services/',
      data: {eid: <?php echo $ext_id; ?>, info: true, general: true},
      dataType: 'jsonp'
    })).then(function(data) {
      if (data.services) {
        $.each(data.services, function(i, service) {
          var code = service.code
            , name = service.name
            , description = service.description || ""
            , currency = service.currency
            , price = service.price
            , turnaround = service.turnaround;
          serviceVM.addService(code, name, description, currency, price, turnaround);
        })
      }
      if (data.rate) {
        $("#hourly_rate").html(data.rate);
      }
    }, function (jqXHR, textStatus, errorThrown) {
      if (window.console && window.console.log) {
        window.console.log("Failed to load services list: " + errorThrown)
      }
    });
  }( window.bull5i = window.bull5i || {}, jQuery ));
}
//--></script>
<?php echo $footer; ?>
