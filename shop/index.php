<?php
session_start();
define('LIBRARIES', './libraries/');
define('SOURCES', './sources/');
define('TEMPLATE', './templates/');
define('LAYOUT', 'layout/');
define('TEMPLATE_MAIN', '../templates/');
define('THUMBS', '../../thumbs');
define('THUMBS_SOURCE', 'thumbs');
define('JSONS', '../../data/jsons/');

/* Config */
require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';
require_once LIBRARIES . "api-routes.php";
new AutoLoad();
$injection = new AntiSQLInjection();
$d = new PDODb($config['database']);

/* Shop */
$shop = new Shop($d);
$shop->init(NAME_SHOP);

/* Check necessary info before acccess shop */
$shop->checkInfo();

/* Get data from shop */
$shopInfo = $shop->get('shop');
$statusShop = $shopInfo['status'];
$idShop = (!empty($shopInfo)) ? $shopInfo['id'] : 0;
$idSectorList = (!empty($shopInfo)) ? $shopInfo['id_list'] : 0;
$idSectorCat = (!empty($shopInfo)) ? $shopInfo['id_cat'] : 0;
$prefixSector = (!empty($shopInfo)) ? $shopInfo['sector-prefix'] : 0;
$nameSectorList = (!empty($shopInfo)) ? $shopInfo['sector-list-name'] : 0;
$nameSectorCat = (!empty($shopInfo)) ? $shopInfo['sector-cat-name'] : 0;
$sampleData = $shopInfo['sample-data'];
$themeColor = $shopInfo['theme-color'];
$tableProductMain = $shopInfo['table-main'];
$tableProductPhoto = $shopInfo['table-photo'];
$tableProductTag = $shopInfo['table-tag'];
$tableProductContent = $shopInfo['table-content'];
$tableProductSeo = $shopInfo['table-seo'];
$tableProductVariation = $shopInfo['table-variation'];
$tableShop = $shopInfo['table-shop'];
$tableShopCounter = $shopInfo['table-shop-counter'];
$tableShopUserOnline = $shopInfo['table-shop-user-online'];
$tableShopRating = $shopInfo['table-shop-rating'];
$tableShopSubscribe = $shopInfo['table-shop-subscribe'];
$tableShopChat = $shopInfo['table-shop-chat'];
$tableShopChatPhoto = $shopInfo['table-shop-chat-photo'];
$tableShopLimit = $shopInfo['table-shop-limit'];
$tableShopLog = $shopInfo['table-shop-log'];
$tableShopReport = $shopInfo['table-shop-report'];
$tableShopReportInfo = $shopInfo['table-shop-report-info'];

/* Define shop */
define('INTERFACE_SHOP', $shopInfo['id_interface']);

/* Class */
$flash = new Flash();
$seo = new Seo($d);
$emailer = new Email($d);
$router = new AltoRouter();
$cache = new Cache($d);
$variation = new Variations($d, $cache);
$func = new Functions($d, $cache);
$detect = new MobileDetect();
$statistic = new Statistic($d, $cache);
$addons = new AddonsOnline();
$css = new CssMinify($config['website']['debug-css'], $func);
$js = new JsMinify($config['website']['debug-js'], $func);
$restApi = new RestApi();

/* Check owned shop */
$idMember = $func->getMember('id');
$shopInfo['isOwned'] = (!empty($shopInfo['id_member']) && $idMember == $shopInfo['id_member']) ? true : false;

/* Router */
require_once LIBRARIES . "router.php";

/* Template */
include TEMPLATE . "index.php";
