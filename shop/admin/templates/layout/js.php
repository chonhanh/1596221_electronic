<?php if ($com == 'product' && !empty($act) && in_array($act, array('add', 'edit')) && !empty($configSector) && $func->hasCoords($configSector)) { ?>
    <!-- JS Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= $config['googleAPI']['map']['key'] ?>"></script>
<?php } ?>

<!-- Js Config -->
<script type="text/javascript">
    var PHP_VERSION = parseFloat('<?= phpversion() ?>'.replaceAll('.', ','));
    var BASE_SHOP_ADMIN = '<?= BASE_SHOP_ADMIN ?>';
    var TOKEN_SHOP = '<?= TOKEN_SHOP ?>';
    var SECTOR = <?= (!empty($configSector)) ? json_encode($configSector) : '{}' ?>;
    var LINK_FILTER = '<?= (!empty($linkFilter)) ? $linkFilter : '' ?>';
    var ID_LIST = <?= (!empty($id_list)) ? $id_list : 0 ?>;
    var ID = <?= (!empty($id)) ? $id : 0 ?>;
    var COM = '<?= (!empty($com)) ? $com : '' ?>';
    var ACT = '<?= (!empty($act)) ? $act : '' ?>';
    var TYPE = '<?= (!empty($type)) ? $type : '' ?>';
    var MAX_DATE = '<?= date("Y/m/d", time()) ?>';
    var ASSET = '<?= ASSET ?>';
    var UPLOAD_PHOTO_THUMB = '<?= UPLOAD_PHOTO_THUMB ?>';
    var IS_SETTING = <?= (!empty($com) && $com == 'setting') ? 'true' : 'false' ?>;
    var IS_CONTACT = <?= (!empty($com) && $com == 'contact') ? 'true' : 'false' ?>;
    var IS_NEWSLETTER = <?= (!empty($com) && $com == 'newsletter') ? 'true' : 'false' ?>;
    var IS_SIZE = <?= (!empty($com) && ($com == 'product') && !empty($act) && in_array($act, array('man_size', 'add_size', 'edit_size'))) ? 'true' : 'false' ?>;
    var IS_POSTING = <?= (!empty($com) && ($com == 'product') && !empty($act) && in_array($act, array('man', 'add', 'edit'))) ? 'true' : 'false' ?>;
    var IS_ORDER = <?= (!empty($com) && ($com == 'order') && !empty($act) && in_array($act, array('edit'))) ? 'true' : 'false' ?>;
    var IS_CHAT = <?= (!empty($com) && ($com == 'chat') && !empty($act) && in_array($act, array('message'))) ? 'true' : 'false' ?>;
    var HAS_PHOTO = <?= (!empty($photoDetailCheck) && $func->existFile($photoDetailCheck)) ? 'true' : 'false' ?>;
    var COUNT_PHOTO_FILEUPLOADER = <?= (!empty($itemPhoto)) ? count($itemPhoto) : 0 ?>;
    var HAS_POSTER_VIDEO = <?= (!empty($photoVideoPosterCheck) && $func->existFile($photoVideoPosterCheck)) ? 'true' : 'false' ?>;
    var HAS_VIDEO = <?= (!empty($videoDetailCheck) && $func->existFile($videoDetailCheck)) ? 'true' : 'false' ?>;
    var EXTENSION_VIDEO = <?= (!empty($config['website']['video']['extension'])) ? json_encode($config['website']['video']['extension']) : '{}' ?>;
    var MAX_SIZE_VIDEO = <?= $config['website']['video']['max-size'] ?>;
</script>

<!-- Js Files -->
<script src="../assets/js/scripts.js?v=<?= $func->stringRandom(10) ?>"></script>
<script src="assets/js/apps.js?v=<?= $func->stringRandom(10) ?>"></script>