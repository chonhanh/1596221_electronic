<?php
session_start();
define('LIBRARIES', '../libraries/');
define('NEWPOST', '../data/newpost/');
define('THUMBS', 'thumbs');
define('WATERMARK', 'watermark');

if (empty($_SESSION['lang'])) $_SESSION['lang'] = 'vi';
$lang = $_SESSION['lang'];

require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';
require_once LIBRARIES . "api-routes.php";
new AutoLoad();
$d = new PDODb($config['database']);
$cache = new Cache($d);
$func = new Functions($d, $cache);
$cart = new Cart($d, $func);
$restApi = new RestApi();
require_once LIBRARIES . "lang/$lang.php";

/* Slug lang */
$sluglang = 'slugvi';

/* Setting */
$sqlCache = "select * from #_setting where id_shop = $idShop limit 0,1";
$setting = $cache->get($sqlCache, null, 'fetch', 7200);
$optsetting = (!empty($setting['options'])) ? json_decode($setting['options'], true) : null;
