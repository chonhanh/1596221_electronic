<?php if ($com == 'product' && !empty($act) && in_array($act, array('add', 'edit')) && !empty($configSector) && $func->hasCoords($configSector)) { ?>
    <!-- JS Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= $config['googleAPI']['map']['key'] ?>"></script>
<?php } ?>

<!-- Js Config -->
<script type="text/javascript">
    var PHP_VERSION = parseFloat('<?= phpversion() ?>'.replaceAll('.', ','));
    var CONFIG_BASE = '<?= $configBase ?>';
    var TOKEN = '<?= TOKEN ?>';
    var ADMIN = '<?= ADMIN ?>';
    var SECTOR = <?= (!empty($configSector)) ? json_encode($configSector) : '{}' ?>;
    var LINK_FILTER = '<?= (!empty($linkFilter)) ? $linkFilter : '' ?>';
    var ID_LIST = <?= (!empty($id_list)) ? $id_list : 0 ?>;
    var ID = <?= (!empty($id)) ? $id : 0 ?>;
    var ID_OWNER_VIRTUAL = <?= (!empty($itemOwner['id'])) ? $itemOwner['id'] : 0 ?>;
    var COM = '<?= (!empty($com)) ? $com : '' ?>';
    var ACT = '<?= (!empty($act)) ? $act : '' ?>';
    var TYPE = '<?= (!empty($type)) ? $type : '' ?>';
    var MAX_DATE = '<?= date("Y/m/d", time()) ?>';
    var MAIN_PERMISSION = <?= (!empty($defineSectors['permissions']['types'])) ? json_encode($defineSectors['permissions']['types']) : '{}' ?>;
    var IS_USER = <?= (!empty($com) && $com == 'user') ? 'true' : 'false' ?>;
    var ID_INFO_ADMIN = <?= (!empty($act) && $act == 'info_admin' && !empty($item)) ? $item['id'] : 0 ?>;
    var IS_CHANGE_PASS = <?= (!empty($changepass)) ? 'true' : 'false' ?>;
    var IS_SETTING = <?= (!empty($com) && $com == 'setting') ? 'true' : 'false' ?>;
    var IS_CONTACT = <?= (!empty($com) && $com == 'contact') ? 'true' : 'false' ?>;
    var IS_NEWSLETTER = <?= (!empty($com) && $com == 'newsletter') ? 'true' : 'false' ?>;
    var IS_STORE = <?= (!empty($com) && $com == 'store') ? 'true' : 'false' ?>;
    var IS_VARIATION = <?= (!empty($com) && $com == 'variation') ? 'true' : 'false' ?>;
    var IS_SIZE = <?= (!empty($com) && ($com == 'product') && !empty($act) && in_array($act, array('man_size', 'add_size', 'edit_size'))) ? 'true' : 'false' ?>;
    var IS_POSTING = <?= (!empty($com) && ($com == 'product') && !empty($act) && in_array($act, array('man', 'add', 'edit'))) ? 'true' : 'false' ?>;
    var IS_REPORT = <?= (!empty($com) && ($com == 'report') && !empty($act) && in_array($act, array('man_report_posting', 'edit_report_posting', 'man_report_shop', 'edit_report_shop'))) ? 'true' : 'false' ?>;
    var IS_ORDER = <?= (!empty($com) && ($com == 'order') && !empty($act) && in_array($act, array('edit'))) ? 'true' : 'false' ?>;
    var IS_SHOP = <?= (!empty($com) && $com == 'shop') ? 'true' : 'false' ?>;
    var HAS_PHOTO = <?= (!empty($photoDetail) && $func->existFile($photoDetail)) ? 'true' : 'false' ?>;
    var COUNT_PHOTO_FILEUPLOADER = <?= (!empty($itemPhoto)) ? count($itemPhoto) : 0 ?>;
    var VARIATION_HAS_RANGE_TYPE = <?= (!empty($config['variation'][$type]['range_type'])) ? 'true' : 'false' ?>;
    var HAS_POSTER_VIDEO = <?= (!empty($photoVideoPoster) && $func->existFile($photoVideoPoster)) ? 'true' : 'false' ?>;
    var HAS_VIDEO = <?= (!empty($videoDetailCheck) && $func->existFile($videoDetailCheck)) ? 'true' : 'false' ?>;
    var EXTENSION_VIDEO = <?= (!empty($config['website']['video']['extension'])) ? json_encode($config['website']['video']['extension']) : '{}' ?>;
    var MAX_SIZE_VIDEO = <?= $config['website']['video']['max-size'] ?>;
</script>

<!-- Js Files -->
<script src="../assets/js/scripts.js?v=<?= $func->stringRandom(10) ?>"></script>
<script src="assets/js/apps.js?v=<?= $func->stringRandom(10) ?>"></script>