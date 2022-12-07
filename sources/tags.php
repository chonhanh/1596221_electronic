<?php
if (!defined('SOURCES')) die("Error");

/* Data */
$IDSector = (!empty($_GET['sector'])) ? $_GET['sector'] : 0;
$isLogin = $func->getMember('active');
$idMember = $func->getMember('id');

/* Check and Get sector data */
if (!empty($IDSector) && in_array($IDSector, $defineSectors['sectors']['IDs'])) {
    /* Get detail sector */
    $detailSector = $cache->get("select type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

    /* Sector config */
    $sector = $defineSectors['types'][$detailSector['type']];
    $tableProductMain = (!empty($sector['tables']['main'])) ? $sector['tables']['main'] : '';
    $tableProductTag = (!empty($sector['tables']['tag'])) ? $sector['tables']['tag'] : '';
    $tableProductInfo = (!empty($sector['tables']['info'])) ? $sector['tables']['info'] : '';
    $tableProductVariation = (!empty($sector['tables']['variation'])) ? $sector['tables']['variation'] : '';
    $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';

    /* Get ID product */
    if (!empty($tableProductTag)) {
        $tagDetail = $cache->get("select id, id_list, name$lang, photo from #_product_tags where id_list = ? and id = ? and find_in_set('hienthi',status) limit 0,1", array($sector['id'], $id), 'fetch', 7200);

        if (!empty($tagDetail)) {
            $title_crumb = $sector['name'] . ': ' . $tagDetail['name' . $lang];

            /* Get product */
            if (!empty($tableProductMain)) {
                /* Get data from member: Favourite */
                if (!empty($isLogin)) {
                    /* Get favourite */
                    $favourites = $cache->get("select id_variant from #_member_favourite where id_member = ? and type = ? and variant = ?", array($idMember, $sector['type'], 'product'), "result", 7200);
                    $favourites = (!empty($favourites)) ? $func->joinCols($favourites, 'id_variant') : array();
                    $favourites = (!empty($favourites)) ? explode(",", $favourites) : array();
                }

                /* Where product */
                $whereProduct = "A.status = ? and A.id = T.id_parent and T.id_tag = ?";
                $paramsProduct = array('xetduyet', $tagDetail['id']);

                /* Where logic when owner or shop unactive */
                $whereLogicOwner = $func->getLogicOwner($tableShop, $sector);
                $whereProduct .= $whereLogicOwner['where'];

                /* SQL paging */
                $curPage = $getPage;
                $perPage = 40;
                $startpoint = ($curPage * $perPage) - $perPage;

                /* SQL sector */
                if (in_array($sector['type'], array('bat-dong-san', 'xay-dung', 'xe-co', 'dien-tu', 'thoi-trang'))) {
                    /* Where product */
                    $whereProduct .= " and A.id_city = C.id and A.id_district = D.id";

                    /* Where logic when shop unactive */
                    $whereProduct .= $func->getLogicShop($tableShop, $whereLogicOwner);

                    /* SQL main */
                    $sqlProduct = "select A.id as id, A.id_shop as id_shop, A.id_member as id_member, A.id_admin as id_admin, A.name$lang as name$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, C.name as name_city, D.name as name_district, S.id_interface as shopInterface, S.name as shopName, S.slug_url as shopUrl, P.photo as shopLogo, M.avatar as memberAvatar, M.fullname as memberFullname, U.avatar as adminAvatar, U.fullname as adminFullname from #_$tableProductMain as A inner join #_$tableProductTag as T inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where $whereProduct order by A.date_created desc limit $startpoint,$perPage";

                    /* SQL num */
                    $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A inner join #_$tableProductTag as T inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where $whereProduct order by A.date_created desc";
                } else if (in_array($sector['type'], array('ung-vien'))) {
                    /* Where product */
                    $whereProduct .= " and A.status_user = 'hienthi' and A.id = B.id_parent and A.id_city = C.id and A.id_district = D.id";

                    /* SQL main */
                    $sqlProduct = "select A.id as id, A.id_member as id_member, A.name$lang as name$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, B.first_name as first_name, B.last_name as last_name, C.name as name_city, D.name as name_district from #_$tableProductMain as A, #_$tableProductTag as T, #_$tableProductInfo as B, #_city as C, #_district as D where $whereProduct order by A.date_created desc limit $startpoint,$perPage";

                    /* SQL num */
                    $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A, #_$tableProductTag as T, #_$tableProductInfo as B, #_city as C, #_district as D where $whereProduct order by A.date_created desc";
                } else if (in_array($sector['type'], array('nha-tuyen-dung'))) {
                    /* Where product */
                    $whereProduct .= " and A.status_user = 'hienthi' and A.id = B.id_parent and A.id_city = C.id and A.id_district = D.id";

                    /* SQL main */
                    $sqlProduct = "select A.id as id, A.id_member as id_member, A.name$lang as name$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, B.fullname as fullname, B.employee_quantity as employee_quantity, C.name as name_city, D.name as name_district from #_$tableProductMain as A, #_$tableProductTag as T, #_$tableProductInfo as B, #_city as C, #_district as D where $whereProduct order by A.date_created desc limit $startpoint,$perPage";

                    /* SQL num */
                    $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A, #_$tableProductTag as T, #_$tableProductInfo as B, #_city as C, #_district as D where $whereProduct order by A.date_created desc";
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
                $seoDB = $seo->getOnDB('*', 'product_tags_seo', $tagDetail['id']);
                $seo->set('h1', $tagDetail['name' . $lang]);
                if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
                else $seo->set('title', $tagDetail['name' . $lang]);
                if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
                if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
                $seo->set('url', $func->getPageURL());
                $img_json_bar = (!empty($tagDetail['options'])) ? json_decode($tagDetail['options'], true) : null;
                if (empty($img_json_bar) || ($img_json_bar['p'] != $tagDetail['photo'])) {
                    $img_json_bar = $func->getImgSize($tagDetail['photo'], UPLOAD_TAGS_L . $tagDetail['photo']);
                    $seo->updateSeoDB(json_encode($img_json_bar), 'store', $tagDetail['id']);
                }
                if (!empty($img_json_bar)) {
                    $seo->set('photo', $configBase . THUMBS . '/' . $img_json_bar['w'] . 'x' . $img_json_bar['h'] . 'x2/' . UPLOAD_TAGS_L . $tagDetail['photo']);
                    $seo->set('photo:width', $img_json_bar['w']);
                    $seo->set('photo:height', $img_json_bar['h']);
                    $seo->set('photo:type', $img_json_bar['m']);
                }
            } else {
                $func->transfer("Dữ liệu không hợp lệ", $configBase, false);
            }
        } else {
            $func->transfer("Dữ liệu không hợp lệ", $configBase, false);
        }
    } else {
        $func->transfer("Dữ liệu không hợp lệ", $configBase, false);
    }
} else {
    $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
}
