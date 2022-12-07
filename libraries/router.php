<?php
/* Check HTTP */
$func->checkHTTP($http, $config['arrayDomainSSL'], $configBase, $configUrl);

/* Validate URL */
$func->checkUrl($config['website']['index']);

/* Check login */
$func->checkLoginMember();

/* Mobile detect */
$deviceType = ($detect->isMobile() || $detect->isTablet()) ? 'mobile' : 'computer';
if ($deviceType != 'computer') {
    header('HTTP/1.0 404 Not Found', true, 404);
    include("404.php");
    exit;
}

/* Router */
$router->setBasePath($config['database']['url']);
$router->map('GET', ADMIN . '/', function () {
    global $func, $config;
    $func->redirect($config['database']['url'] . ADMIN . "/index.php");
    exit;
});
$router->map('GET', ADMIN, function () {
    global $func, $config;
    $func->redirect($config['database']['url'] . ADMIN . "/index.php");
    exit;
});
$router->map('GET|POST', '', 'index', 'home');
$router->map('GET|POST', 'index.php', 'index', 'index');
$router->map('GET|POST', 'sitemap.xml', 'sitemap', 'sitemap');
$router->map('GET|POST', '[a:com]', 'page', 'page');
$router->map('GET|POST', '[a:com]/[a:slug]/[i:id]', 'detail', 'detail');
$router->map('GET|POST', 'account/[a:action]', 'account', 'account');
$router->map('GET', 'captcha/[:encryptCode]/', 'captcha', 'captcha');
$router->map('GET', THUMBS . '/[i:w]x[i:h]x[i:z]/[**:src]', function ($w, $h, $z, $src) {
    global $func;
    $func->createThumb($w, $h, $z, $src, null, THUMBS);
}, 'thumb');

/* Router match */
$match = $router->match();

/* Router check */
if (is_array($match)) {
    if (is_callable($match['target'])) {
        call_user_func_array($match['target'], $match['params']);
    } else {
        $com = (!empty($match['params']['com'])) ? htmlspecialchars($match['params']['com']) : htmlspecialchars($match['target']);
        $slug = (!empty($match['params']['slug'])) ? htmlspecialchars($match['params']['slug']) : '';
        $id = (!empty($match['params']['id'])) ? htmlspecialchars($match['params']['id']) : 0;
        $encryptCode = (!empty($match['params']['encryptCode'])) ? htmlspecialchars($match['params']['encryptCode']) : '';
        $getPage = !empty($_GET['p']) ? htmlspecialchars($_GET['p']) : 1;
    }
} else {
    header('HTTP/1.0 404 Not Found', true, 404);
    include("404.php");
    exit;
}

/* Setting */
$sqlCache = "select * from #_setting where id_shop = $idShop limit 0,1";
$setting = $cache->get($sqlCache, null, 'fetch', 7200);
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

/* Require datas lang */
require_once LIBRARIES . "lang/$lang.php";

/* Switch coms */
switch ($com) {
    case 'lien-he':
        $source = "contact";
        $template = "contact/contact";
        $seo->set('type', 'object');
        $title_crumb = lienhe;
        break;

    case 'gioi-thieu':
    case 'dieu-khoan':
        $source = "static";
        $template = "static/static";
        $type = $com;
        $seo->set('type', 'article');
        break;

    case 'thong-bao':
        $source = "news";
        $template = !empty($id) ? "news/news_detail" : "news/news";
        $seo->set('type', !empty($id) ? "article" : "object");
        $type = $com;
        $title_crumb = 'Thông báo';
        break;

    case 'chinh-sach-ho-tro':
    case 'tuyen-dung':
    case 'ho-tro-thanh-toan':
        $source = "news";
        $template = !empty($id) ? "news/news_detail" : "";
        $seo->set('type', !empty($id) ? "article" : "");
        $type = $com;
        $title_crumb = '';
        break;

    case 'dang-ky-gian-hang':
        $source = "shop";
        $template = "shop/shop";
        $seo->set('type', "object");
        break;

    case 'dang-tin':
        $source = "posting";
        $template = "posting/posting";
        $seo->set('type', "object");
        break;

    case 'bat-dong-san':
    case 'xay-dung':
    case 'ung-vien':
    case 'nha-tuyen-dung':
    case 'xe-co':
    case 'dien-tu':
    case 'thoi-trang':
        $source = "product";
        $template = !empty($id) ? "product/product_detail" : "product/product";
        $seo->set('type', !empty($id) ? "article" : "object");
        $type = $com;
        break;

    case 'cua-hang':
    case 'tim-kiem-cua-hang':
    case 'nhom-cua-hang':
        $source = "store";
        $template = "store/store";
        $seo->set('type', "object");
        break;

    case 'tim-kiem':
        $source = "search";
        $template = "search/search";
        $seo->set('type', 'object');
        break;

    case 'tags':
        $source = "tags";
        $template = "tags/tags";
        $seo->set('type', 'object');
        break;

    case 'tim-kiem-cua-hang-video':
    case 'video':
        $source = "video";
        $seo->set('type', 'object');

        if (!$func->isAjax()) {
            $template = "video/video";
        } else {
            include SOURCES . $source . ".php";
            $template = "video/video";
            die();
        }

        break;

    case 'gio-hang':
        $source = "order";
        $template = "order/order";
        $seo->set('type', 'object');
        $title_crumb = 'Giỏ hàng của bạn';
        break;

    case 'account':
        $source = "user";
        break;

    case 'sitemap':
        include_once LIBRARIES . "sitemap.php";
        exit();

    case 'captcha':
        include_once LIBRARIES . "captcha.php";
        exit();

    case '':
    case 'index':
        $type=$config['website']['sectors'];
        $source = "index";
        $template = "product/product";

        $seo->set('type', 'website');
        break;

    default:
        header('HTTP/1.0 404 Not Found', true, 404);
        include("404.php");
        exit();
}

/* Sectors */
$sectors = $cache->get("select name$lang, slugvi, slugen, id, photo, photo2, type from #_product_list where find_in_set('hienthi',status) order by numb,id desc", null, 'result', 7200);

/* Require datas for all page */
require_once SOURCES . "allpage.php";

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
