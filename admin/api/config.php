<?php
session_start();
define('LIBRARIES', '../../libraries/');
define('JSONS', '../../data/jsons/');
define('SOURCES', '../sources/');
define('THUMBS_COMMENT', '../thumbs');

require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';
new AutoLoad();
$d = new PDODb($config['database']);
$cache = new Cache($d);
$func = new Functions($d, $cache);
$emailer = new Email($d);

if ($func->checkLoginAdmin() == false) {
    die();
}

/* Lang */
$lang = 'vi';
require_once LIBRARIES . "lang/$lang.php";

/* Setting */
$sqlCache = "select * from #_setting where id_shop = $idShop limit 0,1";
$setting = $cache->get($sqlCache, null, 'fetch', 7200);
$optsetting = (!empty($setting['options'])) ? json_decode($setting['options'], true) : null;
