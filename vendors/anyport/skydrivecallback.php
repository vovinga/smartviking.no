<?php 

$url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'&page=callback';

$get = explode(' ', $_GET['state']);
$get = array_pop($get);
$url = str_replace(array('%20'), array('&adminFolder='), $url);

$url = str_replace('vendors/anyport/skydrivecallback.php', $get . '/index.php?route=module/anyport/skydrive', $url);
$url = str_replace('?code=', '&code=', $url);
$url = str_replace('state=', 'token=', $url);

header('Location: '.(!empty($_SERVER['HTTPS']) ? 'https://' : 'http://').$url);
?>