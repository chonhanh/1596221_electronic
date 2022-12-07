<?php
/* Config type - Shop */
require_once LIBRARIES . 'type/config-type-shop.php';

/* Config type - Interface */
require_once LIBRARIES . 'type/config-type-interface.php';

/* Config type - Store */
require_once LIBRARIES . 'type/config-type-store.php';

/* Config type - Product */
require_once LIBRARIES . 'type/config-type-product.php';

/* Config type - Variation */
require_once LIBRARIES . 'type/config-type-variation.php';

/* Config type - Report */
require_once LIBRARIES . 'type/config-type-report.php';

/* Config type - News */
require_once LIBRARIES . 'type/config-type-news.php';

/* Config type - Newsletter */
require_once LIBRARIES . 'type/config-type-newsletter.php';

/* Config type - Static */
require_once LIBRARIES . 'type/config-type-static.php';

/* Config type - Photo */
require_once LIBRARIES . 'type/config-type-photo.php';

/* Seo page */
$config['seopage']['page'] = array(
    "thong-bao" => "Thông báo",

);
$config['seopage']['width'] = 380;
$config['seopage']['height'] = 260;
$config['seopage']['thumb'] = '380x260x2';
$config['seopage']['img_type'] = '.jpg|.gif|.png|.jpeg|.gif';

/* Sample */
$config['sample']['title_main'] = 'Dữ liệu mẫu';
$config['sample']['data'] = array(
    1 => array(
        'header' => array('width' => 710, 'height' => 150, 'thumb' => '710x150x1'),
        'banner' => array('width' => 680, 'height' => 70, 'thumb' => '680x70x2'),
        'logo' => array('width' => 140, 'height' => 140, 'thumb' => '140x140x2'),
        'favicon' => array('width' => 48, 'height' => 48, 'thumb' => '48x48x2'),
        'slideshow' => array('width' => 1366, 'height' => 500, 'thumb' => '1366x500x1'),
        'social' => array('width' => 45, 'height' => 45, 'thumb' => '45x45x2')
    )
);
$config['sample']['img_type'] = '.jpg|.gif|.png|.jpeg|.gif';

/* Setting */
$config['setting']['address'] = true;
$config['setting']['phone'] = true;
$config['setting']['hotline'] = true;
$config['setting']['zalo'] = true;
$config['setting']['oaidzalo'] = true;
$config['setting']['email'] = true;
$config['setting']['website'] = true;
$config['setting']['fanpage'] = true;
$config['setting']['coords'] = false;
$config['setting']['coords_iframe'] = true;

/* Quản lý tài khoản */
$config['user']['active'] = true;
$config['user']['check_group'] = array("hienthi" => "Hiển thị");
$config['user']['check_admin'] = array("hienthi" => "Kích hoạt");
$config['user']['check_admin_virtual'] = array("hienthi" => "Kích hoạt");
$config['user']['check_member'] = array("hienthi" => "Kích hoạt");
$config['user']['member']['width'] = 200;
$config['user']['member']['height'] = 200;
$config['user']['member']['thumb'] = '100x100x2';
$config['user']['member_dashboard']['width'] = 825;
$config['user']['member_dashboard']['height'] = 550;
$config['user']['member']['img_type'] = '.jpg|.png|.jpeg|.JPG|.PNG|.JPEG|.Png';

/* Quản lý phân quyền */
$config['permission']['active'] = true;

/* Quản lý giỏ hàng */
$config['order']['thumb'] = '100x100x2';

/* Quản lý liên hệ */
$config['contact']['check'] = array("hienthi" => "Xác nhận");

/* Quản lý địa điểm */
$config['places']['active'] = true;
$config['places']['check_region'] = array("hienthi" => "Hiển thị");
$config['places']['check_city'] = array("trunguong" => "Trung ương", "hienthi" => "Hiển thị");
$config['places']['city']['width'] = 170;
$config['places']['city']['height'] = 170;
$config['places']['city']['thumb'] = '100x100x2';
$config['places']['city']['img_type'] = '.jpg|.gif|.png|.jpeg|.gif';
$config['places']['check_district'] = array("hienthi" => "Hiển thị");
$config['places']['check_wards'] = array("hienthi" => "Hiển thị");
$config['places']['placesship'] = false;
