<?php
session_start();
define('LIBRARIES', '../libraries/');
define('JSONS', '../data/jsons/');
define('SOURCES', './sources/');
define('TEMPLATE', './templates/');
define('LAYOUT', 'layout/');
define('THUMBS', '../thumbs');
define('THUMBS_COMMENT', THUMBS);
define('WATERMARK', '../watermark');

require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';
new AutoLoad();
$d = new PDODb($config['database']);
$flash = new Flash();
$seo = new Seo($d);
$emailer = new Email($d);
$cache = new Cache($d);
$func = new Functions($d, $cache);

$_REQUEST['id_list'] = $config['website']['list'];
/* Check HTTP */
$func->checkHTTP($http, $config['arrayDomainSSL'], $configBase, $configUrl);

/* Config type */
require_once LIBRARIES . "config-type.php";

/* Setting */
$setting = $d->rawQueryOne("select * from #_setting where id_shop = $idShop limit 0,1");
$optsetting = (isset($setting['options']) && $setting['options'] != '') ? json_decode($setting['options'], true) : null;

/* Requick */
require_once LIBRARIES . "requick.php";
?>
<!DOCTYPE html>
<html lang="vi">

<head>
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
    <link href="assets/datetimepicker/jquery.datetimepicker.css" rel="stylesheet">
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
    <script src="assets/datetimepicker/php-date-formatter.min.js"></script>
    <script src="assets/datetimepicker/jquery.mousewheel.js"></script>
    <script src="assets/datetimepicker/jquery.datetimepicker.js"></script>
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
</head>

<body class="sidebar-mini hold-transition text-sm <?= (!isset($_SESSION[$loginAdmin]['owner']['active']) || $_SESSION[$loginAdmin]['owner']['active'] == false) ? 'login-page' : '' ?>">
    <!-- Wrapper -->
    <?php if (isset($_SESSION[$loginAdmin]['owner']['active']) && ($_SESSION[$loginAdmin]['owner']['active'] == true)) { ?>
        <div class="wrapper">
            <?php
            include TEMPLATE . LAYOUT . "header.php";
            include TEMPLATE . LAYOUT . "menu.php";
            ?>
            <div class="content-wrapper">
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