<!-- Js Config -->
<script type="text/javascript">
    var NN_FRAMEWORK = NN_FRAMEWORK || {};
    var CONFIG_BASE = '<?= $configBase ?>';
    var WEBSITE_NAME = '<?= (!empty($setting['name' . $lang])) ? addslashes($setting['name' . $lang]) : '' ?>';
    var URL_CURRENT = '<?= $func->getCurrentPageURL() ?>';
    var URL_CURRENT_ORIGIN = '<?= $func->getCurrentOriginURL() ?>';
    var URL_LOGIN = '<?= $configBase . 'account/dang-nhap' ?>';
    var IS_LOGIN = <?= (!empty($func->getMember('active'))) ? 'true' : 'false' ?>;
    var SHOP_INFO = <?= (!empty($shopInfo)) ? json_encode($shopInfo) : '{}' ?>;
    var SECTOR_CAT = <?= (!empty($sectorCats)) ? json_encode($sectorCats) : '{}' ?>;
    var RATING_SCORE = <?= (!empty($ratingScore)) ? $ratingScore : 0 ?>;
    var RECAPTCHA_ACTIVE = <?= (!empty($config['googleAPI']['recaptcha']['active'])) ? 'true' : 'false' ?>;
    var RECAPTCHA_SITEKEY = '<?= $config['googleAPI']['recaptcha']['sitekey'] ?>';
    var LANG_MAIN = '<?= $lang ?>';
    var LANG = {
        'no_keywords': '<?= chuanhaptukhoatimkiem ?>',
        'wards': '<?= phuongxa ?>',
        'back_to_home': '<?= vetrangchu ?>',
    };
    var ASSET = '<?= ASSET ?>';
    var PATH_JSON = '<?= JSONS ?>';
    var THUMBS = '<?= THUMBS ?>';
</script>

<!-- Js Files -->
<?php
$js->set("js/jquery.min.js");
$js->set("js/lazyload.min.js");
$js->set("bootstrap/bootstrap.js");
$js->set("confirm/confirm.js");
$js->set("holdon/HoldOn.js");
$js->set("owlcarousel2/owl.carousel.js");
$js->set("simplenotify/simple-notify.js");
$js->set("rating/star-rating-svg.js");
$js->set("fileuploader/jquery.fileuploader.min.js");
$js->set("fotorama/fotorama.js");
$js->set("scrollbar/mCustomScrollbar.js");
$js->set("js/scripts.js");
$js->set("js/functions.js");
$js->set("js/validation.js");
$js->set("js/validation-1.js");
$js->set("js/apps.js");
$js->set("js/apps-1.js");
echo $js->get();
?>

<!-- Ajax settings -->
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'shop': '<?= NAME_SHOP ?>'
        }
    });
</script>

<?php if (!empty($config['googleAPI']['recaptcha']['active'])) { ?>
    <!-- Js Google Recaptcha V3 -->
    <script src="https://www.google.com/recaptcha/api.js?render=<?= $config['googleAPI']['recaptcha']['sitekey'] ?>"></script>
    <script type="text/javascript">
        grecaptcha.ready(function() {
            <?php if (in_array(INTERFACE_SHOP, array(2, 4))) { ?>
                generateCaptcha('Newsletter', 'recaptchaResponseNewsletter');
            <?php } ?>

            generateCaptcha('Chat', 'recaptchaResponseChat');
            generateCaptcha('Report', 'recaptchaResponseReport');

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