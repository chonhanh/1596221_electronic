<?php
session_start();
define('LIBRARIES', '../libraries/');
define('SOURCES', './sources/');
define('TEMPLATE', './templates/');
define('LAYOUT', 'layout/');
define('THUMBS', '../../../thumbs');
define('THUMBS_COMMENT', THUMBS);

require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';

new AutoLoad();
$d = new PDODb($config['database']);

/* Shop */
$shop = new Shop($d);
$shop->init(NAME_SHOP);
$shopInfo = $shop->get('shop');
$statusShop = $shopInfo['status'];
$idShop = (!empty($shopInfo)) ? $shopInfo['id'] : 0;
$idSectorList = (!empty($shopInfo)) ? $shopInfo['id_list'] : 0;
$idSectorCat = (!empty($shopInfo)) ? $shopInfo['id_cat'] : 0;
$typeSectorList = (!empty($shopInfo)) ? $shopInfo['sector-type'] : '';
$prefixSector = (!empty($shopInfo)) ? $shopInfo['sector-prefix'] : 0;
$nameSectorList = (!empty($shopInfo)) ? $shopInfo['sector-list-name'] : 0;
$nameSectorCat = (!empty($shopInfo)) ? $shopInfo['sector-cat-name'] : 0;
$sampleData = $shopInfo['sample-data'];
$tableProductMain = $shopInfo['table-main'];
$tableProductPhoto = $shopInfo['table-photo'];
$tableProductTag = $shopInfo['table-tag'];
$tableProductContent = $shopInfo['table-content'];
$tableProductSeo = $shopInfo['table-seo'];
$tableProductVariation = $shopInfo['table-variation'];
$tableProductComment = $shopInfo['table-comment'];
$tableShop = $shopInfo['table-shop'];
$tableShopCounter = $shopInfo['table-shop-counter'];
$tableShopUserOnline = $shopInfo['table-shop-user-online'];
$tableShopChat = $shopInfo['table-shop-chat'];
$tableShopChatPhoto = $shopInfo['table-shop-chat'];
$tableShopLimit = $shopInfo['table-shop-limit'];
$tableShopLog = $shopInfo['table-shop-log'];

// var_dump($_SESSION);

/* Sector */
$sector = $defineSectors['types'][$typeSectorList];

/* Define shop */
define('INTERFACE_SHOP', $shopInfo['id_interface']);

/* Class */
$flash = new Flash();
$seo = new Seo($d);
$emailer = new Email($d);
$cache = new Cache($d);
$func = new Functions($d, $cache);

/* Config type */
require_once LIBRARIES . "config-type.php";

/* Setting */
$setting = $d->rawQueryOne("select * from #_setting where id_shop = $idShop and sector_prefix = ? limit 0,1", array($prefixSector));
$optsetting = (isset($setting['options']) && $setting['options'] != '') ? json_decode($setting['options'], true) : null;

/* Requick */
require_once LIBRARIES . "requick.php";
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <!-- Basehref -->
    <base href="<?= BASE_SHOP_ADMIN ?>" />

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/images/nina.png" rel="shortcut icon" type="image/x-icon" />
    <title>Administrator - <?= $setting['namevi'] ?></title>

    <!-- CSS -->
    <link href="assets/fontawesome512/all.css" rel="stylesheet">
    <link href="assets/css/animate.min.css" rel="stylesheet">
    <link href="assets/confirm/confirm.css" rel="stylesheet">
    <link href="assets/select2/select2.css" rel="stylesheet">
    <link href="assets/sumoselect/sumoselect.css" rel="stylesheet">
    <link href="assets/daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="assets/rangeSlider/ion.rangeSlider.css" rel="stylesheet">
    <link href="assets/holdon/HoldOn.css" rel="stylesheet">
    <link href="assets/holdon/HoldOn-style.css" rel="stylesheet">
    <link href="assets/fileuploader/font-fileuploader.css" rel="stylesheet">
    <link href="assets/fileuploader/jquery.fileuploader.min.css" rel="stylesheet">
    <link href="assets/fileuploader/jquery.fileuploader-theme-dragdrop.css" rel="stylesheet">
    <link href="assets/simplenotify/simple-notify.css" rel="stylesheet">
    <link href="assets/comment/comment.css" rel="stylesheet">
    <link href="assets/css/adminlte.css" rel="stylesheet">
    <link href="assets/css/adminlte-style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- JS -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/confirm/confirm.js"></script>
    <script src="assets/select2/select2.full.js"></script>
    <script src="assets/sumoselect/jquery.sumoselect.js"></script>
    <script src="assets/daterangepicker/daterangepicker.js"></script>
    <script src="assets/rangeSlider/ion.rangeSlider.js"></script>
    <script src="assets/js/priceFormat.js"></script>
    <script src="assets/jscolor/jscolor.js"></script>
    <script src="assets/holdon/HoldOn.js"></script>
    <script src="assets/fileuploader/jquery.fileuploader.min.js"></script>
    <script src="assets/simplenotify/simple-notify.js"></script>
    <script src="assets/comment/comment.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/adminlte.js"></script>
    <script src="ckeditor/ckeditor.js"></script>

    <!-- Ajax settings -->
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'shop': '<?= NAME_SHOP ?>'
            }
        });
    </script>
</head>

<body class="sidebar-mini hold-transition text-sm <?= (!isset($_SESSION[$loginShop]['shop']['active']) || $_SESSION[$loginShop]['shop']['active'] == false) ? 'login-page' : '' ?>">
    <!-- Wrapper -->
    <?php if (isset($_SESSION[$loginShop]['shop']['active']) && ($_SESSION[$loginShop]['shop']['active'] == true)) { ?>
        <div class="wrapper">
            <?php
            include TEMPLATE . LAYOUT . "header.php";
            include TEMPLATE . LAYOUT . "menu.php";
            ?>
            <div class="content-wrapper">
                <?php if (!empty($statusShop) && $statusShop == 'dangsai') { ?>
                    <section class="content">
                        <div class="container-fluid">
                            <div class="alert my-alert alert-warning alert-dismissible text-sm bg-gradient-warning mt-3 mb-0">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="icon fas fa-exclamation-triangle"></i> Gian hàng đang bị chặn bởi Ban Quản Trị. Các thông tin trên trang này tạm thời không còn khả dụng. Quý khách vui lòng chỉnh sửa các nội dung cần thiết và xác nhận với chúng tôi để Gian hàng được hoạt động trở lại.
                            </div>
                        </div>
                    </section>
                <?php } ?>
                <?php if ($alertlogin) { ?>
                    <section class="content">
                        <div class="container-fluid">
                            <div class="alert my-alert alert-warning alert-dismissible text-sm bg-gradient-warning mt-3 mb-0">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="icon fas fa-exclamation-triangle"></i> <?= $alertlogin ?>
                            </div>
                        </div>
                    </section>
                <?php } ?>
                <?php include TEMPLATE . $template . "_tpl.php"; ?>
            </div>
            <?php
            include TEMPLATE . LAYOUT . "footer.php";
            include TEMPLATE . LAYOUT . "js.php";
            ?>
        </div>
    <?php } else {
        include TEMPLATE . "user/login_tpl.php";
    } ?>
</body>

</html>