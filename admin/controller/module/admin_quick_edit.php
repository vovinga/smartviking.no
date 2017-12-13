<?php
define('EXTENSION_NAME',            'Product Quick Edit Plus');
define('EXTENSION_VERSION',         '1.0.4');
define('EXTENSION_ID',              '15274');
define('EXTENSION_COMPATIBILITY',   'OpenCart 1.5.2.x, 1.5.3.x, 1.5.4.x, 1.5.5.x and 1.5.6.x');
define('EXTENSION_STORE_URL',       'http://www.opencart.com/index.php?route=extension/extension/info&extension_id=' . EXTENSION_ID);
define('EXTENSION_SUPPORT_EMAIL',   'support@opencart.ee');
define('EXTENSION_SUPPORT_FORUM',   'http://forum.opencart.com/viewtopic.php?f=123&t=116963');
define('OTHER_EXTENSIONS',          'http://www.opencart.com/index.php?route=extension/extension&filter_username=bull5-i');

class ControllerModuleAdminQuickEdit extends Controller {
    protected $error = array();
    protected $alert = array(
        'error'     => array(),
        'warning'   => array(),
        'success'   => array(),
        'info'      => array()
    );
    private $defaults = array(
        'aqe_installed'                             => 1,
        'aqe_installed_version'                     => EXTENSION_VERSION,
        'aqe_status'                                => 0,
        'aqe_alternate_row_colour'                  => false,
        'aqe_row_hover_highlighting'                => false,
        'aqe_highlight_status'                      => false,
        'aqe_quick_edit_on'                         => 'click',
        'aqe_list_view_image_width'                 => 40,
        'aqe_list_view_image_height'                => 40,
        'aqe_filter_sub_category'                   => false,
        'aqe_multilingual_seo'                      => false,
        'aqe_items_per_page'                        => 25
    );

    private $column_defaults = array(
        'aqe_catalog_products'      => array(
            'selector'          => array('display' => 1, 'editable' => 0, 'index' =>   0, 'align' => 'text-center', 'type' =>           '', 'sort' => ''                , 'rel' => array()),
            'id'                => array('display' => 0, 'editable' => 0, 'index' =>   5, 'align' =>   'text-left', 'type' =>           '', 'sort' => 'p.product_id'    , 'rel' => array()),
            'image'             => array('display' => 1, 'editable' => 1, 'index' =>  10, 'align' => 'text-center', 'type' =>   'image_qe', 'sort' => ''                , 'rel' => array()),
            'category'          => array('display' => 0, 'editable' => 1, 'index' =>  20, 'align' =>   'text-left', 'type' =>     'cat_qe', 'sort' => ''                , 'rel' => array()),
            'manufacturer'      => array('display' => 0, 'editable' => 1, 'index' =>  30, 'align' =>   'text-left', 'type' => 'manufac_qe', 'sort' => 'm.name'          , 'rel' => array()),
            'name'              => array('display' => 1, 'editable' => 1, 'index' =>  40, 'align' =>   'text-left', 'type' =>    'name_qe', 'sort' => 'pd.name'         , 'rel' => array()),
            'tag'               => array('display' => 0, 'editable' => 1, 'index' =>  50, 'align' =>   'text-left', 'type' =>     'tag_qe', 'sort' => ''                , 'rel' => array()),
            'model'             => array('display' => 1, 'editable' => 1, 'index' =>  60, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.model'         , 'rel' => array()),
            'price'             => array('display' => 1, 'editable' => 1, 'index' =>  70, 'align' =>  'text-right', 'type' =>   'price_qe', 'sort' => 'p.price'         , 'rel' => array()),
            'quantity'          => array('display' => 1, 'editable' => 1, 'index' =>  80, 'align' =>  'text-right', 'type' =>     'qty_qe', 'sort' => 'p.quantity'      , 'rel' => array()),
            'sku'               => array('display' => 0, 'editable' => 1, 'index' =>  90, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.sku'           , 'rel' => array()),
            'upc'               => array('display' => 0, 'editable' => 1, 'index' => 100, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.upc'           , 'rel' => array()),
            'ean'               => array('display' => 0, 'editable' => 1, 'index' => 110, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.ean'           , 'rel' => array()),
            'jan'               => array('display' => 0, 'editable' => 1, 'index' => 120, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.jan'           , 'rel' => array()),
            'isbn'              => array('display' => 0, 'editable' => 1, 'index' => 130, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.isbn'          , 'rel' => array()),
            'mpn'               => array('display' => 0, 'editable' => 1, 'index' => 140, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.mpn'           , 'rel' => array()),
            'location'          => array('display' => 0, 'editable' => 1, 'index' => 150, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.location'      , 'rel' => array()),
            'seo'               => array('display' => 0, 'editable' => 1, 'index' => 160, 'align' =>   'text-left', 'type' =>     'seo_qe', 'sort' => 'seo'             , 'rel' => array()),
            'tax_class'         => array('display' => 0, 'editable' => 1, 'index' => 170, 'align' =>   'text-left', 'type' => 'tax_cls_qe', 'sort' => 'tc.title'        , 'rel' => array()),
            'minimum'           => array('display' => 0, 'editable' => 1, 'index' => 180, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.minimum'       , 'rel' => array()),
            'subtract'          => array('display' => 0, 'editable' => 1, 'index' => 190, 'align' => 'text-center', 'type' =>  'yes_no_qe', 'sort' => 'p.subtract'      , 'rel' => array()),
            'stock_status'      => array('display' => 0, 'editable' => 1, 'index' => 200, 'align' =>   'text-left', 'type' =>   'stock_qe', 'sort' => 'ss.name'         , 'rel' => array()),
            'shipping'          => array('display' => 0, 'editable' => 1, 'index' => 210, 'align' => 'text-center', 'type' =>  'yes_no_qe', 'sort' => 'p.shipping'      , 'rel' => array()),
            'date_added'        => array('display' => 0, 'editable' => 1, 'index' => 215, 'align' =>   'text-left', 'type' =>'datetime_qe', 'sort' => 'p.date_added'    , 'rel' => array()),
            'date_available'    => array('display' => 0, 'editable' => 1, 'index' => 220, 'align' =>   'text-left', 'type' =>    'date_qe', 'sort' => 'p.date_available', 'rel' => array()),
            'date_modified'     => array('display' => 0, 'editable' => 0, 'index' => 230, 'align' =>   'text-left', 'type' =>'datetime_qe', 'sort' => 'p.date_modified' , 'rel' => array()),
            'length'            => array('display' => 0, 'editable' => 1, 'index' => 240, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.length'        , 'rel' => array()),
            'width'             => array('display' => 0, 'editable' => 1, 'index' => 250, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.width'         , 'rel' => array()),
            'height'            => array('display' => 0, 'editable' => 1, 'index' => 260, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.height'        , 'rel' => array()),
            'weight'            => array('display' => 0, 'editable' => 1, 'index' => 270, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.weight'        , 'rel' => array()),
            'length_class'      => array('display' => 0, 'editable' => 1, 'index' => 280, 'align' =>   'text-left', 'type' =>  'length_qe', 'sort' => 'lc.title'        , 'rel' => array()),
            'weight_class'      => array('display' => 0, 'editable' => 1, 'index' => 290, 'align' =>   'text-left', 'type' =>  'weight_qe', 'sort' => 'wc.title'        , 'rel' => array()),
            'points'            => array('display' => 0, 'editable' => 1, 'index' => 300, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.points'        , 'rel' => array()),
            'filter'            => array('display' => 0, 'editable' => 1, 'index' => 310, 'align' =>   'text-left', 'type' =>  'filter_qe', 'sort' => ''                , 'rel' => array()),
            'download'          => array('display' => 0, 'editable' => 1, 'index' => 320, 'align' =>   'text-left', 'type' =>      'dl_qe', 'sort' => ''                , 'rel' => array()),
            'store'             => array('display' => 0, 'editable' => 1, 'index' => 330, 'align' =>   'text-left', 'type' =>   'store_qe', 'sort' => ''                , 'rel' => array()),
            'sort_order'        => array('display' => 1, 'editable' => 1, 'index' => 340, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.sort_order'    , 'rel' => array()),
            'status'            => array('display' => 1, 'editable' => 1, 'index' => 350, 'align' => 'text-center', 'type' =>  'status_qe', 'sort' => 'p.status'        , 'rel' => array()),
            'viewed'            => array('display' => 0, 'editable' => 1, 'index' => 360, 'align' =>  'text-right', 'type' =>         'qe', 'sort' => 'p.viewed'        , 'rel' => array()),
            'view_in_store'     => array('display' => 0, 'editable' => 0, 'index' => 370, 'align' =>   'text-left', 'type' =>           '', 'sort' => ''                , 'rel' => array()),
            'action'            => array('display' => 1, 'editable' => 0, 'index' => 380, 'align' =>  'text-right', 'type' =>           '', 'sort' => ''                , 'rel' => array()),
			'cost'               => array('display' => 0, 'editable' => 1, 'index' =>  390, 'align' =>   'text-left', 'type' =>         'qe', 'sort' => 'p.cost'           , 'rel' => array()),
        ),
        'aqe_catalog_products_actions' => array(
            'attributes'        => array('display' => 0, 'index' =>  0, 'short' => 'attr',  'type' =>    'attr_qe', 'rel' => array()),
            'discounts'         => array('display' => 0, 'index' =>  1, 'short' => 'dscnt', 'type' =>   'dscnt_qe', 'rel' => array()),
            'images'            => array('display' => 0, 'index' =>  2, 'short' => 'img',   'type' =>  'images_qe', 'rel' => array()),
            'filters'           => array('display' => 0, 'index' =>  3, 'short' => 'fltr',  'type' => 'filters_qe', 'rel' => array('filter')),
            'options'           => array('display' => 0, 'index' =>  4, 'short' => 'opts',  'type' =>  'option_qe', 'rel' => array()),
            'profiles'          => array('display' => 0, 'index' =>  5, 'short' => 'prof',  'type' => 'profile_qe', 'rel' => array()),
            'related'           => array('display' => 0, 'index' =>  6, 'short' => 'rel',   'type' => 'related_qe', 'rel' => array()),
            'specials'          => array('display' => 0, 'index' =>  7, 'short' => 'spcl',  'type' => 'special_qe', 'rel' => array('price')),
            'descriptions'      => array('display' => 0, 'index' =>  8, 'short' => 'desc',  'type' =>   'descr_qe', 'rel' => array()),
            'view'              => array('display' => 1, 'index' =>  9, 'short' => 'vw',    'type' =>       'view', 'rel' => array()),
            'edit'              => array('display' => 1, 'index' => 10, 'short' => 'ed',    'type' =>       'edit', 'rel' => array()),
        )
    );

    public function __construct($registry) {
        parent::__construct($registry);
        $this->load->helper('aqe');

        $this->language->load('module/admin_quick_edit');
    }

    public function index() {
        $this->document->addStyle('view/stylesheet/aqe/css/custom.min.css');

        $this->document->addScript('view/javascript/aqe/custom.min.js');
        $this->document->addScript('view/javascript/jquery/superfish/js/superfish.js');

        $this->document->setTitle($this->language->get('extension_name'));

        $this->load->model('setting/setting');

        $ajax_request = isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if ($this->request->server['REQUEST_METHOD'] == 'POST' && !$ajax_request && $this->validateForm($this->request->post)) {
            $original_settings = $this->model_setting_setting->getSetting('admin_quick_edit');

            foreach($this->column_defaults as $page => $columns) {
                $page_conf = $this->config->get($page);

                if ($page_conf === null) {
                    $page_conf = $value;
                }

                foreach ($columns as $column => $attributes) {
                    if (!isset($page_conf[$column])) {
                        $page_conf[$column] = $attributes;
                    } else {
                        foreach ($attributes as $key => $value) {
                            if (!isset($page_conf[$column][$key])) {
                                $page_conf[$column][$key] = $value;
                            } else {
                                switch ($key) {
                                    case 'display':
                                    case 'index':
                                        break;
                                    default:
                                        $page_conf[$column][$key] = $value;
                                        break;
                                }
                            }
                        }

                        foreach (array_diff(array_keys($page_conf[$column]), array_keys($columns[$column])) as $key) {
                            unset($page_conf[$column]);
                        }
                    }
                }

                foreach (array_diff(array_keys($page_conf), array_keys($columns)) as $key) {
                    unset($page_conf[$key]);
                }

                $this->request->post[$page] = $page_conf;
            }

            $settings = array_merge($original_settings, $this->request->post);
            $settings['aqe_installed_version'] = $original_settings['aqe_installed_version'];

            $this->model_setting_setting->editSetting('admin_quick_edit', $settings);

            $this->session->data['success'] = $this->language->get('text_success_update');

            $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        } else if ($this->request->server['REQUEST_METHOD'] == 'POST' && $ajax_request) {
            $response = array();

            if ($this->validateForm($this->request->post)) {
                $original_settings = $this->model_setting_setting->getSetting('admin_quick_edit');

                foreach($this->column_defaults as $page => $columns) {
                    $page_conf = $this->config->get($page);

                    if ($page_conf === null) {
                        $page_conf = $value;
                    }

                    foreach ($columns as $column => $attributes) {
                        if (!isset($page_conf[$column])) {
                            $page_conf[$column] = $attributes;
                        } else {
                            foreach ($attributes as $key => $value) {
                                if (!isset($page_conf[$column][$key])) {
                                    $page_conf[$column][$key] = $value;
                                } else {
                                    switch ($key) {
                                        case 'display':
                                        case 'index':
                                            break;
                                        default:
                                            $page_conf[$column][$key] = $value;
                                            break;
                                    }
                                }
                            }

                            foreach (array_diff(array_keys($page_conf[$column]), array_keys($columns[$column])) as $key) {
                                unset($page_conf[$column][$key]);
                            }
                        }
                    }

                    foreach (array_diff(array_keys($page_conf), array_keys($columns)) as $key) {
                        unset($page_conf[$key]);
                    }

                    $this->request->post[$page] = $page_conf;
                }

                if ((int)$original_settings['aqe_status'] != (int)$this->request->post['aqe_status']) {
                    $response['reload'] = true;
                    $this->session->data['success'] = $this->language->get('text_success_update');
                }

                $settings = array_merge($original_settings, $this->request->post);
                $settings['aqe_installed_version'] = $original_settings['aqe_installed_version'];

                $this->model_setting_setting->editSetting('admin_quick_edit', $settings);

                $response['success'] = true;
                $response['msg'] = $this->language->get("text_success_update");
            } else {
                if (!$this->checkVersion()) {
                    $response['reload'] = true;
                }
                $response = array_merge($response, array("error" => true), array("errors" => $this->error), array("alerts" => $this->alert));
            }

            $this->response->setOutput(json_enc($response, JSON_UNESCAPED_SLASHES));
            return;
        }

        $this->checkPrerequisites();

        $this->checkVersion();

        $this->data['heading_title'] = $this->language->get('extension_name');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_toggle_navigation'] = $this->language->get('text_toggle_navigation');
        $this->data['text_more_options'] = $this->language->get('text_more_options');
        $this->data['text_legal_notice'] = $this->language->get('text_legal_notice');
        $this->data['text_license'] = $this->language->get('text_license');
        $this->data['text_extension_information'] = $this->language->get('text_extension_information');
        $this->data['text_terms'] = $this->language->get('text_terms');
        $this->data['text_license_text'] = $this->language->get('text_license_text');
        $this->data['text_other_extensions'] = sprintf($this->language->get('text_other_extensions'), OTHER_EXTENSIONS);
        $this->data['text_support_subject'] = $this->language->get('text_support_subject');
        $this->data['text_faq'] = $this->language->get('text_faq');

        $this->data['tab_settings'] = $this->language->get('tab_settings');
        $this->data['tab_support'] = $this->language->get('tab_support');
        $this->data['tab_about'] = $this->language->get('tab_about');
        $this->data['tab_general'] = $this->language->get('tab_general');
        $this->data['tab_faq'] = $this->language->get('tab_faq');
        $this->data['tab_services'] = $this->language->get('tab_services');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_apply'] = $this->language->get('button_apply');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_close'] = $this->language->get('button_close');
        $this->data['button_upgrade'] = $this->language->get('button_upgrade');

        $this->data['entry_extension_status'] = $this->language->get('entry_extension_status');
        $this->data['entry_installed_version'] = $this->language->get('entry_installed_version');
        $this->data['entry_extension_name'] = $this->language->get('entry_extension_name');
        $this->data['entry_extension_compatibility'] = $this->language->get('entry_extension_compatibility');
        $this->data['entry_extension_store_url'] = $this->language->get('entry_extension_store_url');
        $this->data['entry_copyright_notice'] = $this->language->get('entry_copyright_notice');

        $this->data['error_ajax_request'] = $this->language->get('error_ajax_request');

        $this->data['ext_name'] = EXTENSION_NAME;
        $this->data['ext_version'] = EXTENSION_VERSION;
        $this->data['ext_id'] = EXTENSION_ID;
        $this->data['ext_compatibility'] = EXTENSION_COMPATIBILITY;
        $this->data['ext_store_url'] = EXTENSION_STORE_URL;
        $this->data['ext_support_email'] = EXTENSION_SUPPORT_EMAIL;
        $this->data['ext_support_forum'] = EXTENSION_SUPPORT_FORUM;
        $this->data['other_extensions_url'] = OTHER_EXTENSIONS;

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'active'    => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'active'    => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('extension_name'),
            'href'      => $this->url->link('module/admin_quick_edit', 'token=' . $this->session->data['token'], 'SSL'),
            'active'    => true
        );

        $this->data['save'] = $this->url->link('module/admin_quick_edit', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['upgrade'] = $this->url->link('module/admin_quick_edit/upgrade', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['update_pending'] = !$this->checkVersion();

        # Loop through all settings for the post/config values
        foreach (array_keys($this->defaults) as $setting) {
            if (isset($this->request->post[$setting])) {
                $this->data[$setting] = $this->request->post[$setting];
            } else {
                $this->data[$setting] = $this->config->get($setting);
                if ($this->data[$setting] === null) {
                    if (!isset($this->alert['warning']['unsaved']) && $this->checkVersion())  {
                        $this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
                    }
                    if (isset($this->defaults[$setting])) {
                        $this->data[$setting] = $this->defaults[$setting];
                    }
                }
            }
        }

        // Check for multilingual SEO keywords
        $column = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "url_alias` LIKE '%language_id'");
        if ($column->num_rows && isset($column->row['Field'])) {
            $multilingual_seo = $column->row['Field'];
        } else {
            $multilingual_seo = false;
        }

        if ($this->data['aqe_multilingual_seo'] != $multilingual_seo) {
            $this->data['aqe_multilingual_seo'] = $multilingual_seo;
            if (!isset($this->alert['warning']['unsaved']) && $this->checkVersion())  {
                $this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
            }
        }

        $this->data['installed_version'] = $this->installedVersion();

        foreach ($this->column_defaults as $page => $columns) {
            $conf = $this->config->get($page);
            if (!is_array($conf)) {
                if (!isset($this->alert['warning']['unsaved']) && $this->checkVersion())  {
                    $this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
                }
            }

            foreach($columns as $column => $attributes) {
                if (!isset($conf[$column])) {
                    if (!isset($this->alert['warning']['unsaved']) && $this->checkVersion())  {
                        $this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
                    }
                } else {
                    foreach ($attributes as $key => $value) {
                        if (!isset($conf[$column][$key])) {
                            if (!isset($this->alert['warning']['unsaved']) && $this->checkVersion())  {
                                $this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
                            }
                        } else {
                            switch ($key) {
                                case 'display':
                                case 'index':
                                    break;
                                default:
                                    if ($conf[$column][$key] != $value) {
                                        if (!isset($this->alert['warning']['unsaved']) && $this->checkVersion())  {
                                            $this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
                                        }
                                    }
                                    break;
                            }
                        }
                    }

                    if (array_diff(array_keys($conf[$column]), array_keys($columns[$column])) && !isset($this->alert['warning']['unsaved']) && $this->checkVersion()) {
                        $this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
                    }
                }
            }

            if (array_diff(array_keys($conf), array_keys($columns)) && !isset($this->alert['warning']['unsaved']) && $this->checkVersion()) {
                $this->alert['warning']['unsaved'] = $this->language->get('error_unsaved_settings');
            }
        }

        if (isset($this->session->data['error'])) {
            $this->error = $this->session->data['error'];

            unset($this->session->data['error']);
        }

        if (isset($this->error['warning'])) {
            $this->alert['warning']['warning'] = $this->error['warning'];
        }

        if (isset($this->error['error'])) {
            $this->alert['error']['error'] = $this->error['error'];
        }

        if (isset($this->session->data['success'])) {
            $this->alert['success']['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        }

        $this->data['errors'] = $this->error;

        $this->data['token'] = $this->session->data['token'];

        $this->data['alerts'] = $this->alert;

        $this->template = 'module/admin_quick_edit.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function install() {
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('admin_quick_edit', array_merge($this->defaults, $this->column_defaults));
    }

    public function uninstall() {
        $this->load->model('setting/setting');
        $this->model_setting_setting->deleteSetting('admin_quick_edit');
    }

    public function upgrade() {
        $ajax_request = isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        $response = array();

        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateUpgrade()) {
            $this->load->model('setting/setting');

            $settings = array();

            // Go over all settings, add new values and remove old ones
            foreach ($this->defaults as $setting => $default) {
                $value = $this->config->get($setting);
                if ($value === null) {
                    $settings[$setting] = $default;
                } else {
                    $settings[$setting] = $value;
                }
            }

            foreach ($this->column_defaults as $page => $columns) {
                $setting = array();

                $conf = $this->config->get($page);

                if ($conf === null || !is_array($conf)) {
                    $conf = $columns;
                }

                foreach ($columns as $column => $values) {
                    $setting[$column] = array();

                    foreach ($values as $key => $value) {
                        if (!isset($conf[$column][$key])) {
                            $setting[$column][$key] = $value;
                        } else {
                            $setting[$column][$key] = $conf[$column][$key];
                        }
                    }
                }

                $settings[$page] = $setting;
            }

            $settings['aqe_installed_version'] = EXTENSION_VERSION;

            $this->model_setting_setting->editSetting('admin_quick_edit', $settings);

            $this->session->data['success'] = sprintf($this->language->get('text_success_upgrade'), EXTENSION_VERSION);
            $response['reload'] = true;
            $response['success'] = true;
            $response['msg'] = sprintf($this->language->get('text_success_upgrade'), EXTENSION_VERSION);
        } else {
            $response = array_merge(array("error" => true), array("errors" => $this->error), array("alerts" => $this->alert));
        }

        if (!$ajax_request) {
            $this->redirect($this->url->link('module/admin_quick_edit', 'token=' . $this->session->data['token'], 'SSL'));
        } else {
            $this->response->setOutput(json_enc($response, JSON_UNESCAPED_SLASHES));
            return;
        }
    }

    private function checkPrerequisites() {
        $errors = false;

        if (!class_exists('VQMod')) {
            $errors = true;
            $this->alert['error']['vqmod'] = $this->language->get('error_vqmod');
        }

        return !$errors;
    }

    private function checkVersion() {
        $errors = false;

        $installed_version = $this->installedVersion();

        if ($installed_version != EXTENSION_VERSION) {
            $errors = true;
            $this->alert['info']['version'] = sprintf($this->language->get('error_version'), EXTENSION_VERSION);
        }

        return !$errors;
    }

    private function validate() {
        $errors = false;

        if (!$this->user->hasPermission('modify', 'module/admin_quick_edit')) {
            $errors = true;
            $this->alert['error']['permission'] = $this->language->get('error_permission');
        }

        if (!$errors) {
            return $this->checkVersion() && $this->checkPrerequisites();
        } else {
            return false;
        }
    }

    private function validateForm($data) {
        $errors = false;

        if ($errors) {
            $errors = true;
            $this->alert['warning']['warning'] = $this->language->get('error_warning');
        }

        if (!$errors) {
            return $this->validate();
        } else {
            return false;
        }
    }

    private function validateUpgrade() {
        $errors = false;

        if (!$this->user->hasPermission('modify', 'module/admin_quick_edit')) {
            $errors = true;
            $this->alert['error']['permission'] = $this->language->get('error_permission');
        }

        return !$errors;
    }

    private function installedVersion() {
        $installed_version = $this->config->get('aqe_installed_version');
        return $installed_version ? $installed_version : '2.3.0';
    }
}
?>
