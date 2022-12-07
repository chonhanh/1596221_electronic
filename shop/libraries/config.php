<?php
if (!defined('LIBRARIES')) die("Error");

/* Config file */
require_once dirname(dirname(dirname(__FILE__))) . "/libraries/" . basename(__FILE__);

/* Config shop */
unset($idShop);
$config['database']['urlShop'] = $config['database']['url'] . 'shop/';

/* Define base shop */
define("BASE_MAIN", $configBase);
define("BASE_SHOP", $http . $config['database']['server-name'] . $config['database']['urlShop']);
define("NAME_SHOP", explode("/", str_replace($config['database']['urlShop'], "", $_SERVER['REQUEST_URI']))[0]);
define("URL_SHOP", BASE_SHOP . NAME_SHOP . '/');
define("BASE_SHOP_ADMIN", BASE_SHOP . NAME_SHOP . '/' . ADMIN . '/');


/* Token shop */
define('TOKEN_SHOP', md5(URL_SHOP));

/* Cấu hình 404 */
$configBase404 = URL_SHOP;

/* Cấu hình login */
$loginShop = $config['login']['admin'] . NAME_SHOP;
