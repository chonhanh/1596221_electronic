<?php
/* Config type - Shop */
$config['shop'] = array();
$config['shop']['width'] = 380;
$config['shop']['height'] = 235;
$config['shop']['img_type'] = '.jpg|.gif|.png|.jpeg|.gif';

/* Config type - Product */
require_once LIBRARIES . 'type/interface-' . INTERFACE_SHOP . '/config-type-product.php';

/* Config type - Newsletter */
require_once LIBRARIES . 'type/interface-' . INTERFACE_SHOP . '/config-type-newsletter.php';

/* Config type - News */
require_once LIBRARIES . 'type/interface-' . INTERFACE_SHOP . '/config-type-news.php';

/* Config type - Static */
require_once LIBRARIES . 'type/interface-' . INTERFACE_SHOP . '/config-type-static.php';

/* Config type - Photo */
require_once LIBRARIES . 'type/interface-' . INTERFACE_SHOP . '/config-type-photo.php';

/* Config type - SEO Page */
require_once LIBRARIES . 'type/interface-' . INTERFACE_SHOP . '/config-type-seopage.php';

/* Config type - Setting */
$config['setting']['address'] = true;
$config['setting']['phone'] = true;
$config['setting']['hotline'] = true;
$config['setting']['zalo'] = true;
$config['setting']['oaidzalo'] = true;
$config['setting']['email'] = true;
$config['setting']['website'] = true;
$config['setting']['fanpage'] = (in_array(INTERFACE_SHOP, array(2, 3))) ? true : false;
$config['setting']['coords'] = false;
$config['setting']['coords_iframe'] = true;

/* Quản lý giỏ hàng */
$config['order']['thumb'] = '100x100x2';

/* Config type - Contact */
$config['contact']['check'] = array("hienthi" => "Xác nhận");
