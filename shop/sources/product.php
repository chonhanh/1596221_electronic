<?php
if (!defined('SOURCES')) die("Error");

/* Get data */
$IDItem = (!empty($_GET['item'])) ? htmlspecialchars($_GET['item']) : 0;
$IDSub = (!empty($_GET['sub'])) ? htmlspecialchars($_GET['sub']) : 0;
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


/* Sector item detail */
if (!empty($IDItem)) {
    $sectorItemDetail = $cache->get("select name$lang, id, options, photo from #_product_item where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDItem), 'fetch', 7200);

    /* Check sector */
    if (!empty($sectorItemDetail)) {
        /* Title crumb */
        $title_crumb = $sectorItemDetail['name' . $lang];

        /* Get seo */
        $sectorSeo = $sectorItemDetail;
        $sectorSeo['tableMain'] = 'product_item';
        $sectorSeo['tableSeo'] = 'product_item_seo';
    } else {
        $func->transfer("Lĩnh vực ngành nghề không hợp lệ", $configBase, false);
    }
}

/* Sector sub detail */
if (!empty($IDSub)) {
    $sectorSubDetail = $cache->get("select name$lang, id, options, photo from #_product_sub where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSub), 'fetch', 7200);

    /* Check sector */
    if (!empty($sectorSubDetail)) {
        /* Title crumb */
        $title_crumb = $sectorSubDetail['name' . $lang];

        /* Get seo */
        $sectorSeo = $sectorSubDetail;
        $sectorSeo['tableMain'] = 'product_sub';
        $sectorSeo['tableSeo'] = 'product_sub_seo';
    } else {
        $func->transfer("Lĩnh vực ngành nghề không hợp lệ", $configBase, false);
    }
}

/* SEO */
if (empty($sectorSeo)) {
    $seoPage = $d->rawQueryOne("select * from #_seopage where id_shop = $idShop and sector_prefix = ? and type = ? limit 0,1", array($prefixSector, $type));

    if (!empty($seoPage)) {
        $seoPage['h1'] = $title_crumb;
        $seoPage['tableMain'] = 'seopage';
        $seoPage['uploadSource'] = UPLOAD_SEOPAGE_SOURCE;
        $seoPage['uploadThumb'] = UPLOAD_SEOPAGE_THUMB;
    }
} else {
    $seoPage = $seo->getOnDB('*', $sectorSeo['tableSeo'], $sectorSeo['id']);

    if (!empty($seoPage)) {
        $seoPage['h1'] = $sectorSeo['name' . $lang];
        $seoPage['photo'] = $sectorSeo['photo'];
        $seoPage['tableMain'] = $sectorSeo['tableMain'];
        $seoPage['uploadSource'] = UPLOAD_PRODUCT_SOURCE;
        $seoPage['uploadThumb'] = UPLOAD_PRODUCT_THUMB;
    }
}

/* Show SEO */
if (!empty($seoPage)) {
    $seo->set('h1', $seoPage['h1']);
    if (!empty($seoPage['title' . $seolang])) $seo->set('title', $seoPage['title' . $seolang]);
    else $seo->set('title', $seoPage['h1']);
    if (!empty($seoPage['keywords' . $seolang])) $seo->set('keywords', $seoPage['keywords' . $seolang]);
    if (!empty($seoPage['description' . $seolang])) $seo->set('description', $seoPage['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $img_json_bar = (!empty($seoPage['options'])) ? json_decode($seoPage['options'], true) : null;
    if (empty($img_json_bar) || ($img_json_bar['p'] != $seoPage['photo'])) {
        $img_json_bar = $func->getImgSize($seoPage['photo'], $seoPage['uploadSource'] . $seoPage['photo']);
        $seo->updateSeoDB(json_encode($img_json_bar), $seoPage['tableMain'], $seoPage['id']);
    }
    if (!empty($img_json_bar)) {
        $seo->set('photo', $configBase . THUMBS_SOURCE . '/' . $img_json_bar['w'] . 'x' . $img_json_bar['h'] . 'x2/' . $seoPage['uploadThumb'] . $seoPage['photo']);
        $seo->set('photo:width', $img_json_bar['w']);
        $seo->set('photo:height', $img_json_bar['h']);
        $seo->set('photo:type', $img_json_bar['m']);
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


/* Get data */
if (!empty($sqlProduct)) {
    $products = $cache->get($sqlProduct, $paramsProduct, 'result', 7200);
    $count = $cache->get($sqlProductNum, $paramsProduct, 'fetch', 7200);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
