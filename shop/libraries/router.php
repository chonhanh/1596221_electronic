<?php
/* Mobile detect */
$deviceType = ($detect->isMobile() || $detect->isTablet()) ? 'mobile' : 'computer';
if ($deviceType != 'computer') {
    header('HTTP/1.0 404 Not Found', true, 404);
    include("404.php");
    exit;
}

/* Router */
$router->setBasePath($config['database']['urlShop']);
$router->map('GET', '[a:shop]/' . ADMIN . '/', function () {
    header("HTTP/1.1 301 Moved Permanently");
    header("location:" . ADMIN . "/");
    exit;
});
$router->map('GET', '[a:shop]/' . ADMIN, function () {
    header("HTTP/1.1 301 Moved Permanently");
    header("location:" . ADMIN . "/");
    exit;
});
$router->map('GET', '[a:shop]', function ($a) {
    header("HTTP/1.1 301 Moved Permanently");
    header("location:" . $a . "/");
    exit;
});
$router->map('GET|POST', '[a:shop]/', 'index', 'home');
$router->map('GET|POST', '[a:shop]/[a:com]', 'page', 'page');
$router->map('GET|POST', '[a:shop]/[a:com]/[a:slug]/[i:id]', 'detail', 'detail');
$router->map('GET', THUMBS . '/[i:w]x[i:h]x[i:z]/[**:src]', function ($w, $h, $z, $src) {
    global $func;
    $func->createThumb($w, $h, $z, $src, null, THUMBS);
}, 'thumb');

/* Router match */
$match = $router->match();

/* Router check */
if (is_array($match)) {
    if (is_callable($match['target'])) {
        if (!empty($match['params']['shop'])) {
            header("HTTP/1.1 301 Moved Permanently");
            header("location:" . ADMIN . "/");
            exit;
        } else {
            call_user_func_array($match['target'], $match['params']);
        }
    } else {
        $com = (!empty($match['params']['com'])) ? htmlspecialchars($match['params']['com']) : htmlspecialchars($match['target']);
        $slug = (!empty($match['params']['slug'])) ? htmlspecialchars($match['params']['slug']) : '';
        $id = (!empty($match['params']['id'])) ? htmlspecialchars($match['params']['id']) : 0;
        $getPage = !empty($_GET['p']) ? htmlspecialchars($_GET['p']) : 1;
    }
} else {
    header('HTTP/1.0 404 Not Found', true, 404);
    include("404.php");
    exit;
}

/* Setting main */
$sqlCache = "select * from #_setting where id_shop = 0 limit 0,1";
$settingMain = $cache->get($sqlCache, null, 'fetch', 7200);
$optsettingMain = (!empty($setting['options'])) ? json_decode($setting['options'], true) : null;

/* Logo main */
$logoMain = $cache->get("select photo from #_photo where id_shop = 0 and type = ? and act = ? limit 0,1", array('logo', 'photo_static'), 'fetch', 7200);

/* Setting */
$sqlCache = "select * from #_setting where id_shop = $idShop and sector_prefix = ? limit 0,1";
$setting = $cache->get($sqlCache, array($prefixSector), 'fetch', 7200);
$optsetting = (!empty($setting['options'])) ? json_decode($setting['options'], true) : null;

/* Lang */
// if(!empty($match['params']['lang'])) $_SESSION['lang'] = $match['params']['lang'];
// else if(empty($_SESSION['lang']) && empty($match['params']['lang'])) $_SESSION['lang'] = $optsetting['lang_default'];
// $lang = $_SESSION['lang'];
$lang = 'vi';

/* Slug lang */
$sluglang = 'slugvi';

/* SEO Lang */
$seolang = "vi";

/* Sector detail */
$sectorDetail = $cache->get("select name$lang, slugvi, slugen, id, photo, photo2, type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($idSectorList), 'fetch', 7200);

$sectorCats = $cache->get("select name$lang, photo, slugvi, slugen, id from #_product_cat where id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array($idSectorList), 'result', 7200);

/* Sector item */
$sectorItems = $cache->get("select A.id as id, A.name$lang as name$lang, A.slugvi as slugvi, A.slugen as slugen, A.photo as photo, B.status as status from #_product_item as A left join #_product_item_status as B on A.id = B.id_parent and B.id_shop = $idShop and B.sector_prefix = ? where A.id_list = ? and A.id_cat = ? and find_in_set('hienthi',A.status) order by A.numb,A.id desc", array($prefixSector, $idSectorList, $idSectorCat), 'result', 7200);

/* Sector item split */
$sectorItemsPage = array();
$sectorItemsPage['active'] = $func->splitStatusShop($sectorItems, 'hienthishop');


/* Sector sub */
$sectorSubs = $cache->get("select A.id as id, A.id_item as id_item, A.name$lang as name$lang, A.slugvi as slugvi, A.slugen as slugen, A.photo as photo, B.status as status from #_product_sub as A left join #_product_sub_status as B on A.id = B.id_parent and B.id_shop = $idShop and B.sector_prefix = ? where A.id_list = ? and A.id_cat = ? and find_in_set('hienthi',A.status) order by A.numb,A.id desc", array($prefixSector, $idSectorList, $idSectorCat), 'result', 7200);

/* Sector sub split */
$sectorSubsPage = array();
$sectorSubsPage['active'] = $func->splitStatusShop($sectorSubs, 'hienthishop');

/* Get subscribe */
$subscribeMember = $d->rawQueryOne("select id from #_member_subscribe where id_member = ? and id_shop = ? and sector_prefix = ? limit 0,1", array($idMember, $idShop, $prefixSector));
$subscribeQuantity = $d->rawQueryOne("select quantity from #_$tableShopSubscribe where id_shop = ? limit 0,1", array($idShop));

/* Get rating */
$ratingScore = 0;
$shopRating = $cache->get("select score, hit from #_$tableShopRating where id_shop = ? limit 0,1", array($idShop), 'fetch', 7200);

if (!empty($shopRating)) {
    $ratingScore = $func->mathRating($shopRating['score'], $shopRating['hit']);
}

/* Require datas */
require_once LIBRARIES . "lang/$lang.php";
require_once SOURCES . "chat.php";
require_once SOURCES . "report.php";
require_once SOURCES . "newsletter/newsletter-1.php";
require_once SOURCES . "allpage.php";

/* Switch coms */
require_once LIBRARIES . "switch/switch-1.php";

/* Include sources */
if (!empty($source)) {
    include SOURCES . $source . ".php";
}

/* Include template */
if (empty($template)) {
    header('HTTP/1.0 404 Not Found', true, 404);
    include("404.php");
    exit();
}
