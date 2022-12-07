<?php
if (!defined('SOURCES')) die("Error");

/* Data */
$title_crumb = timkiem;
$keyword = (!empty($_GET['keyword'])) ? htmlspecialchars($_GET['keyword']) : '';
$IDSector = (!empty($_GET['sector'])) ? $_GET['sector'] : 0;
$isLogin = $func->getMember('active');
$idMember = $func->getMember('id');

/* Check and Get sector data */
if (!empty($keyword)) {
    if (!empty($IDSector) && in_array($IDSector, $defineSectors['sectors']['IDs'])) {
        /* Get detail sector */
        $detailSector = $cache->get("select type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

        /* Sector config */
        $sector = $defineSectors['types'][$detailSector['type']];
        $title_crumb = 'Kết quả tìm kiếm - ' . $keyword;
        $tableProductMain = (!empty($sector['tables']['main'])) ? $sector['tables']['main'] : '';
        $tableProductVariation = (!empty($sector['tables']['variation'])) ? $sector['tables']['variation'] : '';
        $tableProductInfo = (!empty($sector['tables']['info'])) ? $sector['tables']['info'] : '';
        $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';

        if (!empty($tableProductMain)) {
            /* Get data from member: Favourite */
            if (!empty($isLogin)) {
                /* Get favourite */
                $favourites = $cache->get("select id_variant from #_member_favourite where id_member = ? and type = ? and variant = ?", array($idMember, $sector['type'], 'product'), "result", 7200);
                $favourites = (!empty($favourites)) ? $func->joinCols($favourites, 'id_variant') : array();
                $favourites = (!empty($favourites)) ? explode(",", $favourites) : array();
            }

            /* Get shop owned to check favourite */
            if (!empty($isLogin)) {
                $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';

                if (!empty($tableShop)) {
                    $ownedShop = $cache->get("select id from #_$tableShop where id_member = ?", array($idMember), 'result', 7200);
                    $ownedShop = (!empty($ownedShop)) ? explode(",", $func->joinCols($ownedShop, 'id')) : array();
                }
            }

            /* Sample data */
            $sampleData = $cache->get("select id_interface, logo from #_sample", null, 'result', 7200);

            if (!empty($sampleData)) {
                $sampleData['interface'] = array();
                foreach ($sampleData as $k => $v) {
                    if ($func->isNumber($k)) {
                        $sampleData['interface'][$v['id_interface']] = $v;
                    }
                }
            }

            /* Where product */
            $whereProduct = "A.status = ? and (A.name$lang like ? or A.slugvi like ? or A.slugen like ?)";
            $paramsProduct = array('xetduyet', "%$keyword%", "%$keyword%", "%$keyword%");

            /* Where logic when owner or shop unactive */
            $whereLogicOwner = $func->getLogicOwner($tableShop, $sector);
            $whereProduct .= $whereLogicOwner['where'];

            /* SQL paging */
            $curPage = $getPage;
            $perPage = 40;
            $startpoint = ($curPage * $perPage) - $perPage;

            /* SQL sector */
            if (in_array($sector['type'], array( 'dien-tu', 'thoi-trang'))) {
                /* Where product */
                $whereProduct .= " and A.id_city = C.id and A.id_district = D.id";

                /* Where logic when shop unactive */
                $whereProduct .= $func->getLogicShop($tableShop, $whereLogicOwner);

                /* SQL main */
                $sqlProduct = "select A.id as id, A.id_shop as id_shop, A.id_member as id_member, A.id_admin as id_admin, A.name$lang as name$lang, A.desc$lang as desc$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, C.name as name_city, D.name as name_district, S.id_interface as shopInterface, S.name as shopName, S.slug_url as shopUrl, P.photo as shopLogo, M.avatar as memberAvatar, M.fullname as memberFullname, U.avatar as adminAvatar, U.fullname as adminFullname from #_$tableProductMain as A inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where $whereProduct order by A.date_created desc limit $startpoint,$perPage";

                /* SQL num */
                $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where $whereProduct order by A.date_created desc";
            } 

            /* Get data */
            if (!empty($sqlProduct)) {
                $products = $cache->get($sqlProduct, $paramsProduct, 'result', 7200);
                $count = $cache->get($sqlProductNum, $paramsProduct, 'fetch', 7200);
                $total = (!empty($count)) ? $count['num'] : 0;
                $url = $func->getCurrentPageURL();
                $paging = $func->pagination($total, $perPage, $curPage, $url);
            }
        } else {
            $func->transfer("Dữ liệu không hợp lệ", $configBase, false);
        }
    }
} else {
    $func->transfer("Trang không tồn tại", $configBase, false);
}

/* SEO */
$seo->set('h1', $title_crumb);
$seo->set('title', $title_crumb);
$seo->set('keywords', $title_crumb);
$seo->set('description', $title_crumb);
$seo->set('url', $func->getPageURL());
$img_json_bar = (!empty($logo['options'])) ? json_decode($logo['options'], true) : null;
if (empty($img_json_bar) || ($img_json_bar['p'] != $logo['photo'])) {
    $img_json_bar = $func->getImgSize($logo['photo'], UPLOAD_PHOTO_L . $logo['photo']);
    $seo->updateSeoDB(json_encode($img_json_bar), 'photo', $logo['id']);
}
if (!empty($img_json_bar)) {
    $seo->set('photo', $configBase . THUMBS . '/' . $img_json_bar['w'] . 'x' . $img_json_bar['h'] . 'x2/' . UPLOAD_PHOTO_L . $logo['photo']);
    $seo->set('photo:width', $img_json_bar['w']);
    $seo->set('photo:height', $img_json_bar['h']);
    $seo->set('photo:type', $img_json_bar['m']);
}
