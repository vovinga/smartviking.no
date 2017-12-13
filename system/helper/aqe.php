<?php
/**
  * Validate date
  *
  **/
function validate_date($date, $format = 'Y-m-d H:i:s') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

/**
  * Sort columns by index key
  *
  **/
function column_sort($a, $b) {
    if ($a['index'] == $b['index']) {
        return 0;
    }
    return ($a['index'] < $b['index']) ? -1 : 1;
}

/**
  * Filter columns by display value
  *
  **/
function column_display($a) {
    return (isset($a['display'])) ? (int)$a['display'] : false;
}

if (!function_exists("utf8_strlen")) {
    function utf8_strlen($string) {
        return strlen(utf8_decode($string));
    }
}

if (!defined("JSON_UNESCAPED_SLASHES")) {
    define("JSON_UNESCAPED_SLASHES", 0);
}

/**
  * Use our custom json_encode function in case of older PHP versions
  *
  **/
function json_enc($value, $options = 0, $depth = 512) {
    if (version_compare(phpversion(), '5.5.0') >= 0) {
        return json_encode($value, $options, $depth);
    } elseif (version_compare(phpversion(), '5.4.0') >= 0) {
        return json_encode($value, $options);
    } else {
        return json_encode($value);
    }
}
?>
