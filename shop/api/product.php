<?php
include "config.php";

/* Paginations */
include LIBRARIES . "class/class.PaginationsAjax.php";
$pagingAjax = new PaginationsAjax();
$pagingAjax->perpage = (!empty($_GET['perpage'])) ? htmlspecialchars($_GET['perpage']) : 1;
$eShow = htmlspecialchars($_GET['eShow']);
$idItem = (!empty($_GET['idItem'])) ? htmlspecialchars($_GET['idItem']) : 0;
$idSub = (!empty($_GET['idSub'])) ? htmlspecialchars($_GET['idSub']) : 0;
$p = (!empty($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;
$start = ($p - 1) * $pagingAjax->perpage;
$pageLink = "api/product.php?perpage=" . $pagingAjax->perpage;
$tempLink = "";
$where = "";
$params = array($idSectorList, $idSectorCat);

/* Math url */
if ($idItem) {
    $tempLink .= "&idItem=" . $idItem;
    $where .= " and id_item = ?";
    array_push($params, $idItem);
}

if ($idSub) {
    $tempLink .= "&idSub=" . $idSub;
    $where .= " and id_sub = ?";
    array_push($params, $idSub);
}

$tempLink .= "&p=";
$pageLink .= $tempLink;

/* Get data */
if (INTERFACE_SHOP == 1) {
    $sql = "select A.id as id, A.name$lang as name$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, B.content$lang as content$lang from #_$tableProductMain as A, #_$tableProductContent as B where A.id_shop = $idShop and A.id = B.id_parent and A.id_list = ? and A.id_cat = ? $where and find_in_set('noibat',A.status_attr) and find_in_set('hienthi',A.status_attr) and find_in_set('xetduyet',A.status) order by A.numb,A.id desc";
} else if (INTERFACE_SHOP == 2) {
    $sql = "select id, name$lang, photo, slugvi, slugen, regular_price from #_$tableProductMain where id_shop = $idShop and id_list = ? and id_cat = ? $where and find_in_set('noibat',status_attr) and find_in_set('hienthi',status_attr) and find_in_set('xetduyet',status) order by numb,id desc";
} else if (INTERFACE_SHOP == 3) {
    $sql = "select id, name$lang, photo, slugvi, slugen from #_$tableProductMain where id_shop = $idShop and id_list = ? and id_cat = ? $where and find_in_set('menu',status_attr) and find_in_set('hienthi',status_attr) and find_in_set('xetduyet',status) order by numb,id desc";
} else if (INTERFACE_SHOP == 4) {
    $sql = "select A.id as id, A.name$lang as name$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.acreage as acreage, B.name as nameCity, C.name as nameDistrict from #_$tableProductMain as A, #_city as B, #_district as C where A.id_shop = $idShop and A.id_list = ? and A.id_cat = ? and A.id_city = B.id and A.id_district = C.id and find_in_set('noibat',A.status_attr) and find_in_set('hienthi',A.status_attr) and find_in_set('xetduyet',A.status) order by A.numb,A.id desc";
}

$sqlCache = $sql . " limit $start, $pagingAjax->perpage";
$items = $cache->get($sqlCache, $params, 'result', 7200);

/* Count all data */
$countItems = count($cache->get($sql, $params, 'result', 7200));

/* Get page result */
$pagingItems = $pagingAjax->getAllPageLinks($countItems, $pageLink, $eShow);
?>
<?php if (!empty($items)) { ?>
    <div class="grid-page form-row w-clear">
        <?php foreach ($items as $k_product => $v_product) {
            $v_product['name'] = $v_product['name' . $lang];
            $v_product['href'] = BASE_MAIN . $sectorDetail['type'] . '/' . $v_product[$sluglang] . '/' . $v_product['id'];
            $v_product['interface'] = INTERFACE_SHOP;

            if (INTERFACE_SHOP == 1) {
                $v_product['cols'] = 'col-3';
                $v_product['content'] = $v_product['content' . $lang];
            } else if (INTERFACE_SHOP == 2) {
                $v_product['cols'] = 'col-3';
                $v_product['priceType'] = $variation->get($tableProductVariation, $v_product['id'], 'loai-gia', $lang);
            } else if (INTERFACE_SHOP == 3) {
                $v_product['cols'] = 'col-3';
                $v_product['clsMain'] = 'product-menu';
            } else if (INTERFACE_SHOP == 4) {
                $v_product['cols'] = 'col-3';
                $v_product['priceType'] = $variation->get($tableProductVariation, $v_product['id'], 'loai-gia', $lang);
            } ?>
            <div class="<?= $v_product['cols'] ?> mb-3"><?= $func->getProduct($v_product) ?></div>
        <?php } ?>
    </div>
    <?php if (!empty($pagingItems)) { ?>
        <div class="pagination-ajax"><?= $pagingItems ?></div>
    <?php } ?>
<?php } else { ?>
    <div class="alert alert-warning w-100" role="alert"><strong><?= khongtimthayketqua ?></strong></div>
<?php } ?>