<!-- Js Config -->
<script type="text/javascript">
    var NN_FRAMEWORK = NN_FRAMEWORK || {};
    var CONFIG_BASE = '<?= $configBase ?>';
    var ASSET = '<?= ASSET ?>';
    var WEBSITE_NAME = '<?= (!empty($setting['name' . $lang])) ? addslashes($setting['name' . $lang]) : '' ?>';
    var URL_CURRENT = '<?= $func->getCurrentPageURL() ?>';
    var URL_CURRENT_ORIGIN = '<?= $func->getCurrentOriginURL() ?>';
    var URL_LOGIN = '<?= $configBase . 'account/dang-nhap' ?>';
    var URL_SECTOR = '<?= (!empty($sector['type'])) ? $configBase . $sector['type'] : '' ?>';
    var URL_BACK_SUCCCESS_SHOP = '<?= (!empty($backSuccessShop)) ? $backSuccessShop : '' ?>';
    var IS_LOGIN = <?= (!empty($func->getMember('active'))) ? 'true' : 'false' ?>;
    var SECTOR = <?= (!empty($sector)) ? json_encode($sector) : '{}' ?>;
    var SECTOR_CAT = <?= (!empty($sectorCats)) ? json_encode($sectorCats) : '{}' ?>;
    var NEWSFEED = <?= (!empty($sectorNewsfeed)) ? json_encode($sectorNewsfeed) : '{}' ?>;
    var ID_CAT = <?= (!empty($IDCat)) ? $IDCat : 0 ?>;
    var ID_ITEM = <?= (!empty($IDItem)) ? $IDItem : 0 ?>;
    var ID_CITY = <?= (!empty($IDCity)) ? $IDCity : 0 ?>;
    var ID_DISTRICT = <?= (!empty($IDDistrict)) ? $IDDistrict : 0 ?>;
    var ID_WARD = <?= (!empty($IDWard)) ? $IDWard : 0 ?>;
    var ID_NEW_POSTING = '<?= (!empty($newPosting)) ? $newPosting : '' ?>';
    var PATH_JSON = '<?= JSONS ?>';
    var THUMBS = '<?= THUMBS ?>';
    var UPLOAD_PRODUCT_L = '<?= UPLOAD_PRODUCT_L ?>';
    var UPLOAD_PHOTO_L = '<?= UPLOAD_PHOTO_L ?>';
    var UPLOAD_STORE_L = '<?= UPLOAD_STORE_L ?>';
    var MAX_DATE = '<?= date("d/m/Y", time()) ?>';
    var MIN_TOTAL_ORDER = <?= (!empty($minTotal)) ? $minTotal : 1 ?>;
    var MAX_TOTAL_ORDER = <?= (!empty($maxTotal)) ? $maxTotal : 1 ?>;
    var PRICE_FROM_ORDER = <?= (!empty($price_from)) ? $price_from : 1 ?>;
    var PRICE_TO_ORDER = <?= (!empty($price_to)) ? $price_to : ((!empty($maxTotal)) ? $maxTotal : 1) ?>;
    var EXTENSION_VIDEO = <?= (!empty($config['website']['video']['extension'])) ? json_encode($config['website']['video']['extension']) : '{}' ?>;
    var MAX_SIZE_VIDEO = <?= $config['website']['video']['max-size'] ?>;
    var RECAPTCHA_ACTIVE = <?= (!empty($config['googleAPI']['recaptcha']['active'])) ? 'true' : 'false' ?>;
    var RECAPTCHA_SITEKEY = '<?= $config['googleAPI']['recaptcha']['sitekey'] ?>';
    var SLUG_LANG = '<?= $sluglang ?>';
    var LANG_MAIN = '<?= $lang ?>';
    var LANG = {
        'no_keywords': '<?= chuanhaptukhoatimkiem ?>',
        'mycart': '<?= giohangcuaban ?>',
        'wards': '<?= phuongxa ?>',
        'back_to_home': '<?= vetrangchu ?>',
    };
    var EMPTY_CART =
        '<div class="empty-cart"><div class="title-cart bg-white shadow-sm rounded px-3 py-3">' +
        LANG['mycart'] +
        '</div><div class="bg-white text-center shadow-sm rounded px-3 py-5"><img src="' +
        ASSET +
        'assets/images/empty-cart.png" alt="Không có sản phẩm nào trong giỏ hàng của bạn."><div class="mt-5 mb-3">Không có sản phẩm nào trong giỏ hàng của bạn.</div><a class="btn btn-sm btn-warning px-3 py-2" href="" title="Tiếp tục mua sắm">Tiếp tục mua sắm</a></div></div>';
</script>

<?php if ($com == 'dang-tin' && !empty($sector) && $func->hasCoords($sector)) { ?>
    <!-- JS Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= $config['googleAPI']['map']['key'] ?>"></script>
<?php } ?>

<!-- Js Files -->
<?php
$js->set("js/jquery.min.js");
$js->set("js/moment.min.js");
$js->set("js/variables.js");
$js->set("js/lazyload.min.js");
$js->set("bootstrap/bootstrap.js");
$js->set("confirm/confirm.js");
$js->set("holdon/HoldOn.js");
$js->set("owlcarousel2/owl.carousel.js");
$js->set("simplenotify/simple-notify.js");
$js->set("rating/star-rating-svg.js");
$js->set("lightgallery/lightgallery.js");
$js->set("lightgallery/lg-thumbnail.js");
$js->set("lightgallery/lg-zoom.js");
$js->set("lightgallery/lg-autoplay.js");
$js->set("lightgallery/lg-fullscreen.js");
$js->set("lightgallery/lg-pager.js");
$js->set("lightgallery/lg-rotate.js");
$js->set("lightgallery/lg-hash.js");
$js->set("lightgallery/lg-video.js");
$js->set("scrollbar/mCustomScrollbar.js");
$js->set("fileuploader/jquery.fileuploader.min.js");
$js->set("sumoselect/jquery.sumoselect.js");
$js->set("datetimepicker/php-date-formatter.min.js");
$js->set("datetimepicker/jquery.mousewheel.js");
$js->set("datetimepicker/jquery.datetimepicker.js");
$js->set("daterangepicker/daterangepicker.js");
$js->set("rangeSlider/ion.rangeSlider.js");
$js->set("videojs/video-js.min.js");
$js->set("js/scripts.js");
$js->set("js/functions.js");
$js->set("js/validation.js");
$js->set("comment/comment.js");
$js->set("js/apps.js");
echo $js->get();
?>

<?php if (!empty($config['googleAPI']['recaptcha']['active'])) { ?>
    <!-- Js Google Recaptcha V3 -->
    <script src="https://www.google.com/recaptcha/api.js?render=<?= $config['googleAPI']['recaptcha']['sitekey'] ?>"></script>
    <script type="text/javascript">
        grecaptcha.ready(function() {
            generateCaptcha('Feedback', 'recaptchaResponseFeedback');

            <?php if ($template == 'product/product_detail') { ?>
                generateCaptcha('Report', 'recaptchaResponseReport');

                <?php if (!empty($sector) && $func->hasService($sector) && !empty($rowDetail['status_attr']) && strstr($rowDetail['status_attr'], 'dichvu')) { ?>
                    generateCaptcha('Booking', 'recaptchaResponseBooking');
                <?php } ?>
            <?php } ?>

            <?php if ($source == 'contact') { ?>
                generateCaptcha('Contact', 'recaptchaResponseContact');
            <?php } ?>
        });
    </script>
<?php } ?>

<!-- Js Structdata -->
<?php include TEMPLATE . LAYOUT . "strucdata.php"; ?>

<!-- Js Addons -->
<?= $addons->set('script-main', 'script-main', 2); ?>
<?= $addons->get(); ?>

<!-- Js Body -->
<?= $func->decodeHtmlChars($setting['bodyjs']) ?>