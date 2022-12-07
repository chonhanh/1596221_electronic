<?php
if (!defined('LIBRARIES')) die("Error");

/* Timezone */
date_default_timezone_set('Asia/Ho_Chi_Minh');
$code_api_rand = "6667";
/* Cấu hình coder */
define('NN_MSHD', '1253517w');
define('NN_AUTHOR', 'phuctai.nina@gmail.com');
/* Cấu hình chung */
$config = array(
    'author' => array(
        'name' => 'Diệp Phúc Tài',
        'email' => 'phuctai.nina@gmail.com',
        'timestart' => '03/2021'
    ),
    'arrayDomainSSL' => array(),
    'database' => array(
        'server-name' => $_SERVER["SERVER_NAME"],
        'url' => '/chonhanh_dientu/',
        'type' => 'mysql',
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => 'chonhanh_dientu',

        // 'username' => 'chonhanhvn_db',
        // 'password' => 'er979hJ6',
        // 'dbname' => 'chonhanhvn_db',

        'port' => 3306,
        'prefix' => 'table_',
        'charset' => 'utf8mb4'
    ),
    'website' => array(
        'name' => 'Điện Tử',
        'sectors' => 'dien-tu',
        'list' => '9',
        'error-reporting' => false,
        'secret' => '$nina@',
        'salt' => 'zRMjc%KvF',
        'debug-developer' => false,
        'debug-css' => true,
        'debug-js' => true,
        'index' => false,
        'image' => array(
            'hasWebp' => false,
        ),
        'dayNewPost' => 3,
        'theme-color' => '#FFFC43',
        'video' => array(
            'extension' => array('mp4', 'mkv'),
            'poster' => array(
                'width' => 700,
                'height' => 610,
                'extension' => '.jpg|.png|.jpeg'
            ),
            'allow-size' => '100Mb',
            'max-size' => 100 * 1024 * 1024
        ),
        'load-more' => array(
            'group-cat' => array(
                'show' => 4,
                'get' => 4
            ),
            'video' => array(
                'show' => 28,
                'get' => 4
            ),
            'newsfeed' => array(
                'viewers' => array(
                    'show' => 40,
                    'get' => 10
                ),
                'lists' => array(
                    'show' => 2,
                    'get' => 3
                )
            ),
            'chat' => array(
                'show' => 10,
                'get' => 5
            )
        ),
        'upload' => array(
            'max-width' => 1600,
            'max-height' => 1600
        ),
        'lang' => array(
            'vi' => 'Tiếng Việt',
            // 'en'=>'Tiếng Anh'
        ),
        'lang-doc' => 'vi',
        'slug' => array(
            'vi' => 'Tiếng Việt',
            // 'en'=>'Tiếng Anh'
        ),
        'seo' => array(
            'vi' => 'Tiếng Việt',
            // 'en'=>'Tiếng Anh'
        )
    ),
    'login' => array(
        'admin' => 'LoginAdmin' . NN_MSHD,
        'member' => 'LoginMember' . NN_MSHD,
        'attempt' => 5,
        'delay' => 15
    ),
    'googleAPI' => array(
        'recaptcha' => array(
            'active' => false,
            'urlapi' => 'https://www.google.com/recaptcha/api/siteverify',
            'sitekey' => '6LezS5kUAAAAAF2A6ICaSvm7R5M-BUAcVOgJT_31',
            'secretkey' => '6LezS5kUAAAAAGCGtfV7C1DyiqlPFFuxvacuJfdq'
        ),
        'map' => array(
            'key' => 'AIzaSyCSaOkH3-RuO5G5au4guUxausk2-w1d_mA'
        )
    ),
    'license' => array(
        'version' => "7.0.0",
        'powered' => "phuctai.nina@gmail.com"
    )
);

/* Error reporting */
error_reporting(($config['website']['error-reporting']) ? E_ALL : 0);

/* Cấu hình base */
$http = 'http://';
$configUrl = $config['database']['server-name'] . $config['database']['url'];
$configBase = $http . $configUrl;
$configBaseShop = $http . $configUrl . 'shop/';

define('BASE_URL_API',$http. $code_api_rand.'-113-161-88-45.ap.ngrok.io/chonhanh/');

/* Token */
define('TOKEN', md5(NN_MSHD . $config['database']['url']));

/* Path On Host */
define('ROOT', str_replace(basename(__DIR__), '', __DIR__));
// define('ASSET', $http . 'cdn.chonhanh.vn/');
define('ASSET', $configBase . '');
define('ADMIN', 'admin');

/* Cấu hình login */
$loginAdmin = $config['login']['admin'];
$loginMember = $config['login']['member'];

/* ID shop for Main Page */
$idShop = 0;

/* Cấu hình upload */
require_once LIBRARIES . "constant.php";


/* Define Sectors */
$defineSectors = array(
    'sectors' => array(
        'types' => array('dien-tu'),
        'IDs' => array(9),
    ),
    'hasShop' => array(
        'id' => array(9),
        'types' => array('dien-tu')
    ),
    'hasFourLevel' => array(
        'id' => array(9),
        'types' => array('dien-tu')
    ),
    'restrictedShop' => array('admin', 'administrator', 'quantri', 'trangquantri', 'quanly', 'trangquanly', 'manage', 'management'),
    'hasCoords' => array(
        'id' => array(9),
        'types' => array('dien-tu')
    ),
    'hasService' => array(
        'id' => array(),
        'types' => array()
    ),
    'hasAccessary' => array(
        'id' => array(),
        'types' => array()
    ),
    'hasCart' => array(
        'id' => array(9),
        'types' => array('dien-tu')
    ),
    'sortOrder' => array(
        'home' => array(
            'dien-tu' => 1
        )
    ),
    'IDs' => array(
        9 => 'dien-tu'
    ),
    'types' => array(
       
        'dien-tu' => array(
            'id' => 9,
            'type' => 'dien-tu',
            'name' => 'Điện Tử',
            'prefix' => 'electron',
            'attributes' => array('price'),//, 'coordinates'
            'tables' => array(
                'main' => 'product_electron',
                'photo' => 'product_electron_photo',
                'tag' => 'product_electron_tag',
                'sale' => 'product_electron_sale',
                'content' => 'product_electron_content',
                'variation' => 'product_electron_variation',
                'video' => 'product_electron_video',
                'seo' => 'product_electron_seo',
                'contact' => 'product_electron_contact',
                'comment' => 'product_electron_comment',
                'comment-photo' => 'product_electron_comment_photo',
                'comment-video' => 'product_electron_comment_video',
                'report-product' => 'report_product_electron',
                'report-product-info' => 'report_product_electron_info',
                'shop' => 'shop_electron',
                'shop-counter' => 'shop_electron_counter',
                'shop-user-online' => 'shop_electron_user_online',
                'shop-rating' => 'shop_electron_rating',
                'shop-subscribe' => 'shop_electron_subscribe',
                'shop-chat' => 'shop_electron_chat',
                'shop-chat-photo' => 'shop_electron_chat_photo',
                'shop-limit' => 'shop_electron_limit',
                'shop-log' => 'shop_electron_log',
                'report-shop' => 'report_shop_electron',
                'report-shop-info' => 'report_shop_electron_info'
            )
        )
    ),
    'permissions' => array(
        'types' => array('shop', 'product', 'variation', 'report', 'order', 'newsletter', 'news', 'photo', 'place', 'seopage', 'user', 'setting'),
        'lists' => array(
            'shop' => 'Quản lý gian hàng',
            'product' => 'Quản lý tin đăng',
            'variation' => 'Quản lý biến thể',
            'report' => 'Quản lý báo xấu',
            'order' => 'Quản lý đơn hàng',
            'newsletter' => 'Quản lý nhận tin',
            'news' => 'Quản lý bài viết',
            'photo' => 'Quản lý hình ảnh',
            'place' => 'Quản lý địa điểm',
            'seopage' => 'Quản lý SEO page',
            'user' => 'Quản lý thành viên',
            'setting' => 'Quản lý cài đặt'
        ),
        'types-virtual' => array('shop'),
        'lists-virtual' => array(
            'shop' => 'Quản lý gian hàng'
        )
    )
);
