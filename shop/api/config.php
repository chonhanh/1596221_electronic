<?php
session_start();
define('LIBRARIES', '../libraries/');
define('THUMBS', '../../thumbs');
define('THUMBS_SOURCE', 'thumbs');

if (empty($_SESSION['lang'])) $_SESSION['lang'] = 'vi';
$lang = $_SESSION['lang'];

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
$tableProductVariation = $shopInfo['table-variation'];
$tableShop = $shopInfo['table-shop'];
$tableShopRating = $shopInfo['table-shop-rating'];
$tableShopSubscribe = $shopInfo['table-shop-subscribe'];
$tableShopLimit = $shopInfo['table-shop-limit'];
$tableShopLog = $shopInfo['table-shop-log'];

/* Define shop */
define('INTERFACE_SHOP', $shopInfo['id_interface']);

/* Class */
$emailer = new Email($d);
$cache = new Cache($d);
$variation = new Variations($d, $cache);
$func = new Functions($d, $cache);

/* Lang */
$lang = 'vi';
require_once LIBRARIES . "lang/$lang.php";

/* Slug lang */
$sluglang = 'slugvi';

/* Setting */
$sqlCache = "select * from #_setting where id_shop = $idShop and sector_prefix = ? limit 0,1";
$setting = $cache->get($sqlCache, array($prefixSector), 'fetch', 7200);
$optsetting = (!empty($setting['options'])) ? json_decode($setting['options'], true) : null;

/* Sector detail */
$sectorDetail = $cache->get("select name$lang, slugvi, slugen, id, photo, photo2, type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($idSectorList), 'fetch', 7200);
