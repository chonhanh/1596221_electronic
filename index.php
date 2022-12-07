<?php
session_start();
define('LIBRARIES', './libraries/');
define('NEWPOST', './data/newpost/');
define('JSONS', './data/jsons/');
define('SOURCES', './sources/');
define('TEMPLATE', './templates/');
define('LAYOUT', 'layout/');
define('THUMBS', 'thumbs');

/* Config */
require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';
require_once LIBRARIES . "api-routes.php";
require_once LIBRARIES.'Faker/src/autoload.php';
new AutoLoad();
$injection = new AntiSQLInjection();
$d = new PDODb($config['database']);
$flash = new Flash();
$seo = new Seo($d);
$emailer = new Email($d);
$router = new AltoRouter();
$cache = new Cache($d);
$variation = new Variations($d, $cache);
$func = new Functions($d, $cache);
$cart = new Cart($d, $func);
$detect = new MobileDetect();
$statistic = new Statistic($d, $cache);
$addons = new AddonsOnline();
$restApi = new RestApi();
$css = new CssMinify($config['website']['debug-css'], $func);
$js = new JsMinify($config['website']['debug-js'], $func);
$_REQUEST['sectorType'] = $config['website']['sectors'];
$faker = Faker\Factory::create();

    // unset($_SESSION[$loginMember]);

    // setcookie('cookieLoginMemberId', "", -1, '/');
    // setcookie('cookieLoginMemberSession', "", -1, '/');

 
/* Lock Web */
require_once SOURCES . "lockWeb.php";


/* Router */
require_once LIBRARIES . "router.php";

/* Template */
include TEMPLATE . "index.php";
