<?php
if (!defined('SOURCES')) die("Error");

/* Data */
$keyword = (!empty($_GET['keyword'])) ? htmlspecialchars($_GET['keyword']) : '';
$title_crumb = 'Kết quả tìm kiếm - ' . $keyword;

if (!empty($keyword)) {
    /* Search data */
    $whereProduct = "A.id_shop = $idShop and A.status = ? and find_in_set('hienthi',A.status_attr) and (A.name$lang like ? or A.slugvi like ? or A.slugen like ?)";
    $paramsProduct = array('xetduyet', "%$keyword%", "%$keyword%", "%$keyword%");

    /* Cols main */
    $colsSelect = "A.id as id, A.name$lang as name$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created";

    /* SQL shop */
    if (INTERFACE_SHOP == 1) {
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
    } else if (INTERFACE_SHOP == 2) {
        /* SQL paging */
        $curPage = $getPage;
        $perPage = 40;
        $startpoint = ($curPage * $perPage) - $perPage;

        /* SQL main */
        $sqlProduct = "select $colsSelect from #_$tableProductMain as A where $whereProduct order by A.date_created desc limit $startpoint,$perPage";

        /* SQL num */
        $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A where $whereProduct order by A.date_created desc";
    } else if (INTERFACE_SHOP == 3) {
        /* SQL paging */
        $curPage = $getPage;
        $perPage = 40;
        $startpoint = ($curPage * $perPage) - $perPage;

        /* SQL main */
        $sqlProduct = "select $colsSelect from #_$tableProductMain as A where $whereProduct order by A.date_created desc limit $startpoint,$perPage";

        /* SQL num */
        $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A where $whereProduct order by A.date_created desc";
    } else if (INTERFACE_SHOP == 4) {
        /* SQL paging */
        $curPage = $getPage;
        $perPage = 40;
        $startpoint = ($curPage * $perPage) - $perPage;

        /* Where main */
        $whereProduct .= ' and A.id_city = B.id and A.id_district = C.id';

        /* Cols shop */
        $colsSelect .= ", A.acreage as acreage, B.name as nameCity, C.name as nameDistrict";

        /* SQL main */
        $sqlProduct = "select $colsSelect from #_$tableProductMain as A, #_city as B, #_district as C where $whereProduct order by A.date_created desc limit $startpoint,$perPage";

        /* SQL num */
        $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A, #_city as B, #_district as C where $whereProduct order by A.date_created desc";
    }

    /* Get data */
    if (!empty($sqlProduct)) {
        $products = $cache->get($sqlProduct, $paramsProduct, 'result', 7200);
        $count = $cache->get($sqlProductNum, $paramsProduct, 'fetch', 7200);
        $total = (!empty($count)) ? $count['num'] : 0;
        $url = $func->getCurrentPageURL();
        $paging = $func->pagination($total, $perPage, $curPage, $url);
    }

    /* SEO */
    $seo->set('h1', $title_crumb);
    $seo->set('title', $title_crumb);
    $seo->set('keywords', $title_crumb);
    $seo->set('description', $title_crumb);
    $seo->set('url', $func->getPageURL());
    $img_json_bar = (!empty($logo['options'])) ? json_decode($logo['options'], true) : null;
    if (empty($img_json_bar) || ($img_json_bar['p'] != $logo['photo'])) {
        $img_json_bar = $func->getImgSize($logo['photo'], UPLOAD_PHOTO_SOURCE . $logo['photo']);
        $seo->updateSeoDB(json_encode($img_json_bar), 'photo', $logo['id']);
    }
    if (!empty($img_json_bar)) {
        $seo->set('photo', $configBase . THUMBS_SOURCE . '/' . $img_json_bar['w'] . 'x' . $img_json_bar['h'] . 'x2/' . UPLOAD_PHOTO_THUMB . $logo['photo']);
        $seo->set('photo:width', $img_json_bar['w']);
        $seo->set('photo:height', $img_json_bar['h']);
        $seo->set('photo:type', $img_json_bar['m']);
    }
} else {
    $func->transfer("Trang không tồn tại", URL_SHOP, false);
}
