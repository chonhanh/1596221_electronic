<?php
session_start();
define('LIBRARIES', '../../libraries/');
define('SOURCES', '../sources/');
define('THUMBS', '../../../thumbs');
define('THUMBS_COMMENT', '../../../thumbs');

require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';
new AutoLoad();
$d = new PDODb($config['database']);

/* Shop */
$shop = new Shop($d);
$shop->init((!empty($_SERVER['HTTP_SHOP'])) ? trim($_SERVER['HTTP_SHOP']) : '');
$shopInfo = $shop->get('shop');
$idShop = (!empty($shopInfo)) ? $shopInfo['id'] : 0;
$idSectorList = (!empty($shopInfo)) ? $shopInfo['id_list'] : 0;
$idSectorCat = (!empty($shopInfo)) ? $shopInfo['id_cat'] : 0;
$prefixSector = (!empty($shopInfo)) ? $shopInfo['sector-prefix'] : 0;
$tableProductMain = $shopInfo['table-main'];
$tableProductPhoto = $shopInfo['table-photo'];
$tableProductTag = $shopInfo['table-tag'];
$tableProductContent = $shopInfo['table-content'];
$tableProductSeo = $shopInfo['table-seo'];
$tableShop = $shopInfo['table-shop'];
$tableShopLimit = $shopInfo['table-shop-limit'];
$tableShopLog = $shopInfo['table-shop-log'];
$loginShop = $config['login']['admin'] . $shopInfo['slug_url'];

/* Check shop */
if ($shop->checkLogin() == false) {
    die("Dữ liệu không hợp lệ");
}

/* Class */
$emailer = new Email($d);
$cache = new Cache($d);
$func = new Functions($d, $cache);

/* Lang */
$lang = 'vi';
require_once LIBRARIES . "lang/$lang.php";

/* Setting */
$sqlCache = "select * from #_setting where id_shop = $idShop and sector_prefix = ? limit 0,1";
$setting = $cache->get($sqlCache, array($prefixSector), 'fetch', 7200);
$optsetting = (!empty($setting['options'])) ? json_decode($setting['options'], true) : null;
