<?php
if (!defined('SOURCES')) die("Error");

/* Data */
$idMember = $func->getMember('id');
$IDSector = (!empty($_GET['sector'])) ? $_GET['sector'] : 0;
$IDCity = (!empty($_GET['city'])) ? htmlspecialchars($_GET['city']) : 0;
$IDDistrict = (!empty($_GET['district'])) ? htmlspecialchars($_GET['district']) : 0;
$keyword = (!empty($_GET['keyword'])) ? htmlspecialchars($_GET['keyword']) : '';
$FiltersActived = array();

/* Sector detail */
if (!empty($IDSector)) {
    $sectorDetail = $cache->get("select type, id from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

    /* Check sector */
    if (!empty($sectorDetail) && $func->hasShop($sectorDetail)) {
        /* Sector list */
        $sector = $defineSectors['types'][$sectorDetail['type']];
        $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';
        $tableShopRating = (!empty($sector['tables']['shop-rating'])) ? $sector['tables']['shop-rating'] : '';
        $tableShopSubscribe = (!empty($sector['tables']['shop-subscribe'])) ? $sector['tables']['shop-subscribe'] : '';

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

        /* Member subscribe */
        $memberSubscribe = (!empty($idMember)) ? $cache->get("select id_shop from #_member_subscribe where id_member = ? and sector_prefix = ?", array($idMember, $sector['prefix']), 'result', 7200) : array();
        $memberSubscribe = (!empty($memberSubscribe)) ? explode(",", $func->joinCols($memberSubscribe, 'id_shop')) : array();

        /* Labels */
        $func->set('sector-label', $func->textConvert($sector['name'], 'capitalize'));

        /* Action class modal */
        $func->set('actionClsModal-cat-clsMain', 'filter-cat-store');
        $func->set('actionClsModal-city-clsMain', 'filter-city-store');
        $func->set('actionClsModal-district-clsMain', 'filter-district-store');

        /* Get sector cat */
        $sectorCats = $cache->get("select name$lang, photo, slugvi, slugen, id from #_product_cat where id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array($sector['id']), 'result', 7200);

        /* City detail */
        if (!empty($IDCity)) {
            $cityDetail = $cache->get("select name from #_city where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDCity), 'fetch', 7200);

            /* Check city */
            if (!empty($cityDetail)) {
                $func->set('city-name', $func->textConvert($cityDetail['name'], 'capitalize'));

                /* Get filters actived */
                $FiltersActived['city']['clsFilter'] = 'filter-city-store';
                $FiltersActived['city']['clsMain'] = 'city';
                $FiltersActived['city']['name'] = $func->get('city-name');
            } else {
                $func->transfer("Tỉnh/thành phố không hợp lệ", $configBase, false);
            }
        }

        /* District detail */
        if (!empty($IDDistrict)) {
            $districtDetail = $cache->get("select name from #_district where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDDistrict), 'fetch', 7200);

            /* Check district */
            if (!empty($districtDetail)) {
                $func->set('district-name', $func->textConvert($districtDetail['name'], 'capitalize'));

                /* Get filters actived */
                $FiltersActived['district']['clsFilter'] = 'filter-district-store';
                $FiltersActived['district']['clsMain'] = 'district';
                $FiltersActived['district']['name'] = $func->get('district-name');
            } else {
                $func->transfer("Quận/huyện không hợp lệ", $configBase, false);
            }
        }

        /* Label place */
        $func->set('place-label', !empty($func->get('district-name')) ? $func->get('district-name') : (!empty($func->get('city-name')) ? $func->get('city-name') : 'Toàn quốc'));

        /* Label district */
        $districtLabel = (!empty($func->get('sector-label'))) ? $func->get('sector-label') : '';
        $districtLabel .= (empty($func->get('district-name')) && !empty($func->get('city-name'))) ? ' tại ' . $func->get('city-name') : ((!empty($func->get('district-name'))) ? ' tại ' . $func->get('district-name') : '');
        $func->set('district-label', $districtLabel);

        /* Get data by com */
        if ($com == 'tim-kiem-cua-hang' && !empty($keyword)) {
            /* Title crumb */
            $title_crumb = 'Kết quả tìm kiếm - ' . $keyword;

            /* Structs search */
            $func->set('search-id', 'keyword-shop-' . $sector['id']);
            $func->set('search-obj', 'keyword-shop' . '|' . $sector['id']);
            $func->set('search-val', 'keyword');

            /* Stores by sector */
            $stores = $cache->get("select name$lang, photo, slugvi, slugen, id from #_store where id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array($sector['id']), 'result', 7200);

            /* Shops */
            $curPage = $getPage;
            $perPage = 30;
            $startpoint = ($curPage * $perPage) - $perPage;
            $whereShop = "A.id_list = ? and A.status = ? and A.status_user = ? ";
            $paramsShop = array($sector['prefix'], $sector['id'], 'xetduyet', 'hienthi');

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
        } else if ($com == 'nhom-cua-hang' && !empty($id) && !empty($slug)) {
            /* Structs search */
            $func->set('search-id', 'keyword-shop');
            $func->set('search-obj', 'keyword-shop');
            $func->set('search-val', 'keyword');

            /* Detail */
            $sectorCatDetail = $cache->get("select id, name_store$lang, slugvi, slugen, photo2, options2 from #_product_cat where id_list = ? and id = ? and slugvi = ? and find_in_set('hienthi',status) limit 0,1", array($sector['id'], $id, $slug), 'fetch', 7200);

            /* Check exist */
            if (empty($sectorCatDetail)) {
                header('HTTP/1.0 404 Not Found', true, 404);
                include("404.php");
                exit();
            }

            /* Stores by sector */
            $stores = $cache->get("select name$lang, photo, slugvi, slugen, id from #_store where id_list = ? and id_cat = ? and find_in_set('hienthi',status) order by numb,id desc", array($sector['id'], $sectorCatDetail['id']), 'result', 7200);

            /* Shops */
            $curPage = $getPage;
            $perPage = 30;
            $startpoint = ($curPage * $perPage) - $perPage;
            $whereShop = "A.id_list = ? and A.id_cat = ? and A.status = ? and A.status_user = ? ";
            $paramsShop = array($sector['prefix'], $sector['id'], $sectorCatDetail['id'], 'xetduyet', 'hienthi');

            /* SEO */
            $seoDB = $seo->getOnDB('*', 'product_cat_seo', $sectorCatDetail['id']);
            $seo->set('h1', $sectorCatDetail['name_store' . $lang]);
            $seo->set('title', $sectorCatDetail['name_store' . $lang]);
            if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
            if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
            $seo->set('url', $func->getPageURL());
            $img_json_bar = (!empty($sectorCatDetail['options2'])) ? json_decode($sectorCatDetail['options2'], true) : null;
            if (empty($img_json_bar) || ($img_json_bar['p'] != $sectorCatDetail['photo2'])) {
                $img_json_bar = $func->getImgSize($sectorCatDetail['photo2'], UPLOAD_PRODUCT_L . $sectorCatDetail['photo2']);
                $seo->updateSeoDB(json_encode($img_json_bar), 'store', $sectorCatDetail['id']);
            }
            if (!empty($img_json_bar)) {
                $seo->set('photo', $configBase . THUMBS . '/' . $img_json_bar['w'] . 'x' . $img_json_bar['h'] . 'x2/' . UPLOAD_PRODUCT_L . $sectorCatDetail['photo2']);
                $seo->set('photo:width', $img_json_bar['w']);
                $seo->set('photo:height', $img_json_bar['h']);
                $seo->set('photo:type', $img_json_bar['m']);
            }
        } else if ($com == 'cua-hang' && !empty($id) && !empty($slug)) {
            /* Structs search */
            $func->set('search-id', 'keyword-shop');
            $func->set('search-obj', 'keyword-shop');
            $func->set('search-val', 'keyword');

            /* Detail */
            $storeDetail = $cache->get("select id, id_cat, name$lang, slugvi, slugen, photo, options from #_store where id_list = ? and id = ? and slugvi = ? and find_in_set('hienthi',status) limit 0,1", array($sector['id'], $id, $slug), 'fetch', 7200);

            /* Check exist */
            if (empty($storeDetail)) {
                header('HTTP/1.0 404 Not Found', true, 404);
                include("404.php");
                exit();
            }

            /* Stores by sector */
            $stores = $cache->get("select name$lang, photo, slugvi, slugen, id from #_store where id_list = ? and id_cat = ? and find_in_set('hienthi',status) order by numb,id desc", array($sector['id'], $storeDetail['id_cat']), 'result', 7200);

            /* Shops */
            $curPage = $getPage;
            $perPage = 30;
            $startpoint = ($curPage * $perPage) - $perPage;
            $whereShop = "A.id_list = ? and A.id_cat = ? and A.id_store = ? and A.status = ? and A.status_user = ? ";
            $paramsShop = array($sector['prefix'], $sector['id'], $storeDetail['id_cat'], $storeDetail['id'], 'xetduyet', 'hienthi');

            /* SEO */
            $seoDB = $seo->getOnDB('*', 'store_seo', $storeDetail['id']);
            $seo->set('h1', $storeDetail['name' . $lang]);
            if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
            else $seo->set('title', $storeDetail['name' . $lang]);
            if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
            if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
            $seo->set('url', $func->getPageURL());
            $img_json_bar = (!empty($storeDetail['options'])) ? json_decode($storeDetail['options'], true) : null;
            if (empty($img_json_bar) || ($img_json_bar['p'] != $storeDetail['photo'])) {
                $img_json_bar = $func->getImgSize($storeDetail['photo'], UPLOAD_STORE_L . $storeDetail['photo']);
                $seo->updateSeoDB(json_encode($img_json_bar), 'store', $storeDetail['id']);
            }
            if (!empty($img_json_bar)) {
                $seo->set('photo', $configBase . THUMBS . '/' . $img_json_bar['w'] . 'x' . $img_json_bar['h'] . 'x2/' . UPLOAD_STORE_L . $storeDetail['photo']);
                $seo->set('photo:width', $img_json_bar['w']);
                $seo->set('photo:height', $img_json_bar['h']);
                $seo->set('photo:type', $img_json_bar['m']);
            }
        } else {
            $func->transfer("Trang không hợp lệ", $configBase, false);
        }

        /* Where shop not in owner is UNACTIVE */
        $ownerUnActive = $func->getAllOwnerUnActive();

        /* Where owner member */
        if (!empty($ownerUnActive['member'])) {
            $whereShop .= " and A.id_member not in(" . $ownerUnActive['member'] . ")";
        }

        /* Where owner admin */
        if (!empty($ownerUnActive['admin'])) {
            $whereShop .= " and A.id_admin not in(" . $ownerUnActive['admin'] . ")";
        }

        /* Where owner admin virtual */
        if (!empty($ownerUnActive['admin-virtual'])) {
            $whereShop .= " and A.id_admin_virtual not in(" . $ownerUnActive['admin-virtual'] . ")";
        }

        if (!empty($IDCity)) {
            $whereShop .= ' and A.id_city = ?';
            array_push($paramsShop, $IDCity);
        }

        if (!empty($IDDistrict)) {
            $whereShop .= ' and A.id_district = ?';
            array_push($paramsShop, $IDDistrict);
        }

        if (!empty($keyword)) {
            $whereShop .= ' and (A.name like ? or A.slug like ? or A.slug_url like ? or B.name like ? or C.name like ? or D.name like ?)';
            array_push($paramsShop, "%$keyword%");
            array_push($paramsShop, "%$keyword%");
            array_push($paramsShop, "%$keyword%");
            array_push($paramsShop, "%$keyword%");
            array_push($paramsShop, "%$keyword%");
            array_push($paramsShop, "%$keyword%");
            // var_dump('expression');die();
            /* Get filters actived */
            $FiltersActived['keyword']['clsFilter'] = 'store-search-remove';
            $FiltersActived['keyword']['clsMain'] = '';
            $FiltersActived['keyword']['name'] = 'Từ khóa:<strong class="pl-1">' . $keyword . '</strong>';
            
        }

        /* SQL shop */
        $sqlShop = "select A.id as id, A.id_interface as interface, A.name as name, A.photo as photo, A.slug_url as slug_url, B.name as nameCity, C.name as nameDistrict, D.name as nameWard, R.score as score, R.hit as hit, S.quantity as subscribeNumb, P.photo as logo from #_$tableShop as A inner join #_city as B inner join #_district as C inner join #_wards as D left join #_$tableShopRating as R on A.id = R.id_shop left join #_$tableShopSubscribe as S on A.id = S.id_shop left join #_photo as P on A.id = P.id_shop and P.sector_prefix = ? and P.type = 'logo' where $whereShop and A.id_city = B.id and A.id_district = C.id and A.id_wards = D.id order by A.numb,A.id desc limit $startpoint,$perPage";

        /* SQL num */
        $sqlShopNum = "select count(*) as 'num' from #_$tableShop as A inner join #_city as B inner join #_district as C inner join #_wards as D left join #_$tableShopRating as R on A.id = R.id_shop left join #_$tableShopSubscribe as S on A.id = S.id_shop left join #_photo as P on A.id = P.id_shop and P.sector_prefix = ? and P.type = 'logo' where $whereShop and A.id_city = B.id and A.id_district = C.id and A.id_wards = D.id order by A.numb,A.id desc";

        /* Get data */
        if (!empty($sqlShop)) {
            $shops = $cache->get($sqlShop, $paramsShop, 'result', 7200);
            $count = $cache->get($sqlShopNum, $paramsShop, 'fetch', 7200);
            $total = (!empty($count)) ? $count['num'] : 0;
            $url = $func->getCurrentPageURL();
            $paging = $func->pagination($total, $perPage, $curPage, $url);
        }
    } else {
        $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
    }
} else {
    $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
}
