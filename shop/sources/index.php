<?php
if (!defined('SOURCES')) die("Error");



/* Get data */
$sectorSeo = array();
$sector = $defineSectors['types'][$config['website']['sectors']];

$sampleData = $cache->get("select id_interface, logo from #_sample", null, 'result', 7200);

if (!empty($sampleData)) {
    $sampleData['interface'] = array();
    foreach ($sampleData as $k => $v) {
        if ($func->isNumber($k)) {
            $sampleData['interface'][$v['id_interface']] = $v;
        }
    }
}

/* Products */
$whereProduct = "id_shop = $idShop and A.status = ? and find_in_set('hienthi',A.status_attr)";
$paramsProduct = array('xetduyet');

/* Where list */
if (!empty($idSectorList)) {
    $whereProduct .= " and A.id_list = ?";
    array_push($paramsProduct, $idSectorList);
}

/* Where cat */
if (!empty($idSectorCat)) {
    $whereProduct .= " and A.id_cat = ?";
    array_push($paramsProduct, $idSectorCat);
}

/* Where item */
if (!empty($IDItem)) {
    $whereProduct .= " and A.id_item = ?";
    array_push($paramsProduct, $IDItem);
}

/* Where sub */
if (!empty($IDSub)) {
    $whereProduct .= " and A.id_sub = ?";
    array_push($paramsProduct, $IDSub);
}

/* Cols main */
$colsSelect = "A.id as id,A.id_shop as id_shop, A.name$lang as name$lang, A.desc$lang as desc$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created";

/* SQL shop */

    /* SQL paging */
    $curPage = $getPage;
    $perPage = 40;
    $startpoint = ($curPage * $perPage) - $perPage;

    /* Where main */
    $whereProduct .= ' and A.id = B.id_parent';

    /* Cols shop */
    $colsSelect .= ", B.content$lang as content$lang";

    /* SQL main */
    $sqlProduct = "select $colsSelect from #_$tableProductMain as A, #_$tableProductContent as B where $whereProduct order by A.date_created desc limit $startpoint,$perPage";

    /* SQL num */
    $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A, #_$tableProductContent as B where $whereProduct order by A.date_created desc";

if (!empty($sqlProduct)) {
    $products = $cache->get($sqlProduct, $paramsProduct, 'result', 7200);
    $count = $cache->get($sqlProductNum, $paramsProduct, 'fetch', 7200);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* SEO */
$seoDB = $seo->getOnDB('*', 'setting_seo', $setting['id']);
if (!empty($seoDB['title' . $seolang])) $seo->set('h1', $seoDB['title' . $seolang]);
if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
$seo->set('url', $func->getPageURL());
$img_json_bar = (!empty($logo['options'])) ? json_decode($logo['options'], true) : null;
if (!empty($logo['id']) && (empty($img_json_bar) || ($img_json_bar['p'] != $logo['photo']))) {
    $img_json_bar = $func->getImgSize($logo['photo'], UPLOAD_PHOTO_SOURCE . $logo['photo']);
    $seo->updateSeoDB(json_encode($img_json_bar), 'photo', $logo['id']);
}
if (!empty($img_json_bar)) {
    $seo->set('photo', $configBase . THUMBS_SOURCE . '/' . $img_json_bar['w'] . 'x' . $img_json_bar['h'] . 'x2/' . UPLOAD_PHOTO_THUMB . $logo['photo']);
    $seo->set('photo:width', $img_json_bar['w']);
    $seo->set('photo:height', $img_json_bar['h']);
    $seo->set('photo:type', $img_json_bar['m']);
}
