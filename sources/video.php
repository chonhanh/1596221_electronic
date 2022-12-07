<?php
if (!defined('SOURCES')) die("Error");

/* Data */
$title_crumb = "Video";
$type_seo = 'video';
$isLogin = $func->getMember('active');
$idMember = $func->getMember('id');
$IDSector = (!empty($_GET['sector'])) ? $_GET['sector'] : 0;
$IDCat = (!empty($_GET['cat'])) ? $_GET['cat'] : 0;
$IDShop = (!empty($_GET['shop'])) ? $_GET['shop'] : 0;
$keyword = (!empty($_GET['keyword'])) ? htmlspecialchars($_GET['keyword']) : '';
$variantPost = (!empty($_GET['variantpost'])) ? htmlspecialchars($_GET['variantpost']) : '';
$IDDatePost = (!empty($_GET['datepost'])) ? htmlspecialchars($_GET['datepost']) : 0;
$FiltersActived = $resultAjax = array();

/* Check and Get sector data */
if (!empty($IDSector)) {
    if (in_array($IDSector, $defineSectors['sectors']['IDs'])) {
        /* Get detail sector */
        $detailSector = $cache->get("select name$lang, type, id, photo from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

        /* Sector config */
        $sector = $defineSectors['types'][$detailSector['type']];
        $type_seo = 'video-' . $sector['type'];
        $tableProductMain = (!empty($sector['tables']['main'])) ? $sector['tables']['main'] : '';
        $tableProductVideo = (!empty($sector['tables']['video'])) ? $sector['tables']['video'] : '';
        $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';
        $tableShopSubscribe = (!empty($sector['tables']['shop-subscribe'])) ? $sector['tables']['shop-subscribe'] : '';

        /* Get sector cat */
        $sectorCats = $cache->get("select name$lang, photo, slugvi, slugen, id from #_product_cat where id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array($IDSector), 'result', 7200);

        /* Filters date post */
        $func->set('datePost-active', true);
        $func->set('datePost-label', 'Thời gian đăng video');
        $func->set('datePost-clsFilter', 'filter-date-post-video');
        $func->set('datePost-clsMain', 'date-post');
        $func->set('datePost-data', $cache->get("select name$lang, id from #_variation where type = ? and find_in_set('hienthi',status) order by numb,id desc", array('thoi-gian-dang-video'), 'result', 7200));

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

        /* Get data by com */
        if ($com == 'tim-kiem-cua-hang-video' && !empty($keyword)) {
            /* Title page */
            $title_crumb = 'Kết quả tìm kiếm - "<strong class="text-danger">' . $keyword . '</strong>"';
            $title_page = 'Video - ' . $sector['name'] . ' - Kết quả tìm kiếm';

            /* Shops */
            $curPage = $getPage;
            $perPage = 30;
            $startpoint = ($curPage * $perPage) - $perPage;
            $whereShop = "A.id_city = B.id and A.id_district = C.id and A.id_wards = D.id and (A.name like ? or A.slug like ? or A.slug_url like ?) and A.status = ? and A.status_user = ? ";
            $paramsShop = array($sector['prefix'], "%$keyword%", "%$keyword%", "%$keyword%", 'xetduyet', 'hienthi');

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

            /* SQL shop */
            $sqlShop = "select A.id as id, A.id_interface as interface, A.name as name, A.slug_url as slug_url, B.name as nameCity, C.name as nameDistrict, D.name as nameWard, P.photo as logo from #_$tableShop as A inner join #_city as B inner join #_district as C inner join #_wards as D left join #_photo as P on A.id = P.id_shop and P.sector_prefix = ? and P.type = 'logo' where $whereShop order by A.numb,A.id desc limit $startpoint,$perPage";

            /* SQL num */
            $sqlShopNum = "select count(*) as 'num' from #_$tableShop as A inner join #_city as B inner join #_district as C inner join #_wards as D left join #_photo as P on A.id = P.id_shop and P.sector_prefix = ? and P.type = 'logo' where $whereShop order by A.numb,A.id desc";

            /* Get data */
            $shops = $cache->get($sqlShop, $paramsShop, 'result', 7200);
            $count = $cache->get($sqlShopNum, $paramsShop, 'fetch', 7200);
            $total = (!empty($count)) ? $count['num'] : 0;
            $url = $func->getCurrentPageURL();
            $paging = $func->pagination($total, $perPage, $curPage, $url);
        } else if ($com == 'video' && !empty($tableProductMain) && !empty($tableProductVideo)) {
            /* Title page */
            $title_page = $title_crumb . ' - ' . $sector['name'];

            /* Get Owned Shop - Favourites */
            if (!empty($isLogin)) {
                /* Get shop owned to check favourite */
                if (!empty($tableShop)) {
                    $ownedShop = $cache->get("select id from #_$tableShop where id_member = ?", array($idMember), 'result', 7200);
                    $ownedShop = (!empty($ownedShop)) ? explode(",", $func->joinCols($ownedShop, 'id')) : array();
                }

                /* Get favourite */
                $favourites = $cache->get("select id_variant from #_member_favourite where id_member = ? and type = ? and variant = ?", array($idMember, $sector['type'], 'product'), "result", 7200);
                $favourites = (!empty($favourites)) ? $func->joinCols($favourites, 'id_variant') : array();
                $favourites = (!empty($favourites)) ? explode(",", $favourites) : array();
            }

            /* Where product video */
            $whereProduct = "A.status = ? and B.id_parent = A.id and B.name$lang != '' and B.video != '' and A.id_city = C.id and A.id_district = D.id";
            $paramsProduct = array('xetduyet');

            /* Where shop */
            if (!empty($IDShop)) {
                /* Shop detail params */
                $whereShop = "A.id = ? and A.status = ? and A.status_user = ? ";
                $paramsShop = array($sector['prefix'], $IDShop, 'xetduyet', 'hienthi');

                /* Shop detail */
                $shopDetail = $cache->get("select A.id as id, A.id_interface as interface, A.name as name, A.slug_url as slug_url, S.quantity as subscribeNumb, P.photo as logo from #_$tableShop as A left join #_$tableShopSubscribe as S on A.id = S.id_shop left join #_photo as P on A.id = P.id_shop and P.sector_prefix = ? and P.type = 'logo' where $whereShop limit 0,1", $paramsShop, 'fetch', 7200);

                if (!empty($shopDetail) && empty($variantPost)) {
                    /* Title page */
                    $title_page = $title_crumb . ' - ' . $shopDetail['name'];

                    /* Check owned shop */
                    $ownedShop = $cache->get("select id from #_$tableShop where id = ? and id_member = ?", array($IDShop, $idMember), 'fetch', 7200);

                    /* Count members favourited products in this shop */
                    $favouritedMembers = $func->getMembersFavouritedProducts($sector['type'], $tableProductMain, $IDShop);
                    $shopDetail['favourited-product-members'] = (!empty($favouritedMembers)) ? count($favouritedMembers) : 0;

                    /* Member favourited - subscribe */
                    $shopDetail['subscribeActive'] = '';
                    $shopDetail['favouriteActive'] = '';

                    if (empty($ownedShop) && !empty($isLogin)) {
                        /* Member subscribe */
                        $subscribeMember = $d->rawQueryOne("select id from #_member_subscribe where id_member = ? and id_shop = ? and sector_prefix = ? limit 0,1", array($idMember, $IDShop, $sector['prefix']));
                        $shopDetail['subscribeActive'] = (!empty($subscribeMember)) ? 'active' : '';

                        /* Member favourited product */
                        if (!empty($favouritedMembers)) {
                            $shopDetail['favouriteActive'] = (in_array($idMember, $favouritedMembers)) ? 'active' : '';
                        }
                    }

                    /* Logo */
                    $shopDetail['logo'] = (!empty($shopDetail['logo'])) ? $shopDetail['logo'] : $sampleData['interface'][$shopDetail['interface']]['logo'];

                    /* Href */
                    $shopDetail['href'] = $configBaseShop . $shopDetail['slug_url'] . '/';

                    /* Get filters actived */
                    $FiltersActived['shop']['clsFilter'] = 'filter-shop-video';
                    $FiltersActived['shop']['clsMain'] = 'shop-video';
                    $FiltersActived['shop']['name'] = "<strong class='text-uppercase'>" . $shopDetail['name'] . "</strong>";

                    /* Where video by shop */
                    $whereProduct .= " and A.id_shop = ?";
                    array_push($paramsProduct, $IDShop);
                } else {
                    if ($func->isAjax()) {
                        /* Is ajax */
                        $resultAjax['error'] = true;
                        $resultAjax['message'] = 'Trang không hợp lệ';
                        echo json_encode($resultAjax);
                        exit();
                    } else {

                        $func->transfer("Trang không hợp lệ", $configBase, false);
                    }
                }
            }

            /* Where cat */
            if (!empty($IDCat)) {
                /* Sector cat detail */
                $sectorCatDetail = $cache->get("select name$lang from #_product_cat where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDCat), 'fetch', 7200);

                if (!empty($sectorCatDetail)) {
                    $whereProduct .= " and A.id_cat = ?";
                    array_push($paramsProduct, $IDCat);

                    /* Get filters actived */
                    $FiltersActived['cat']['clsFilter'] = 'filter-cat-video';
                    $FiltersActived['cat']['clsMain'] = 'sectors-cat';
                    $FiltersActived['cat']['name'] = $sectorCatDetail['name' . $lang];
                } else {
                    if ($func->isAjax()) {
                        /* Is ajax */
                        $resultAjax['error'] = true;
                        $resultAjax['message'] = 'Trang không hợp lệ';
                        echo json_encode($resultAjax);
                        exit();
                    } else {

                        $func->transfer("Trang không hợp lệ", $configBase, false);
                    }
                }
            }

            /* Where variant video */
            if (empty($shopDetail) && !empty($variantPost)) {
                if ($func->hasShop($detailSector)) {
                    /* Get filters actived */
                    $FiltersActived['variantPost']['clsFilter'] = 'filter-variant-video';
                    $FiltersActived['variantPost']['clsMain'] = 'variant-post';

                    /* Filter by variant */
                    if ($variantPost == 'all') {
                        $whereProduct .= "";
                        $FiltersActived['variantPost']['name'] = 'Video Cửa hàng và Cá nhân';
                    } else if ($variantPost == 'shop') {
                        $whereProduct .= " and A.id_shop > 0";
                        $FiltersActived['variantPost']['name'] = 'Video Cửa hàng';
                    } else if ($variantPost == 'personal') {
                        $whereProduct .= " and A.id_shop = 0";
                        $FiltersActived['variantPost']['name'] = 'Video Cá nhân';
                    } else {
                        if ($func->isAjax()) {
                            /* Is ajax */
                            $resultAjax['error'] = true;
                            $resultAjax['message'] = 'Trang không hợp lệ';
                            echo json_encode($resultAjax);
                            exit();
                        } else {

                            $func->transfer("Trang không hợp lệ", $configBase, false);
                        }
                    }
                } else {
                    if ($func->isAjax()) {
                        /* Is ajax */
                        $resultAjax['error'] = true;
                        $resultAjax['message'] = 'Trang không hợp lệ';
                        echo json_encode($resultAjax);
                        exit();
                    } else {

                        $func->transfer("Trang không hợp lệ", $configBase, false);
                    }
                }
            }

            /* Where date post */
            if (!empty($IDDatePost)) {
                $info = $cache->get("select date_comparison, date_filter, namevi, nameen from #_variation where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDDatePost), 'fetch', 7200);

                if (!empty($info)) {
                    $info['timestamp'] = strtotime(date("d-m-Y", strtotime("-" . $info['date_filter'] . " day")));

                    if ($info['date_comparison'] == 1) {
                        $whereProduct .= " and A.date_created >= ?";
                        array_push($paramsProduct, $info['timestamp']);
                    } else if ($info['date_comparison'] == 2) {
                        $whereProduct .= " and A.date_created <= ?";
                        array_push($paramsProduct, $info['timestamp']);
                    }

                    /* Get filters actived */
                    $FiltersActived['datePost']['clsFilter'] = 'filter-date-post-video';
                    $FiltersActived['datePost']['clsMain'] = 'date-post';
                    $FiltersActived['datePost']['name'] = $info['name' . $lang];

                    /* Unset info */
                    unset($info);
                } else {
                    if ($func->isAjax()) {
                        /* Is ajax */
                        $resultAjax['error'] = true;
                        $resultAjax['message'] = 'Trang không hợp lệ';
                        echo json_encode($resultAjax);
                        exit();
                    } else {

                        $func->transfer("Trang không hợp lệ", $configBase, false);
                    }
                }
            }

            /* Where logic when owner or shop unactive */
            $whereLogicOwner = $func->getLogicOwner($tableShop, $sector);
            $whereProduct .= $whereLogicOwner['where'];

            if ($func->hasShop($detailSector)) {
                /* Where logic when shop unactive */
                $whereProduct .= $func->getLogicShop($tableShop, $whereLogicOwner);

                /* SQL product video */
                $sqlVideo = "select A.id as id, A.id_shop as id_shop, A.id_member as id_member, A.id_admin as id_admin, A.slugvi as slugvi, A.slugen as slugen, A.date_created as date_created, B.id as videoId, B.name$lang as videoName$lang, B.photo as videoPhoto, B.video as videoData, B.type as videoType, C.name as name_city, D.name as name_district, S.id_interface as shopInterface, S.name as shopName, S.slug_url as shopUrl, P.photo as shopLogo, M.avatar as memberAvatar, M.fullname as memberFullname, U.avatar as adminAvatar, U.fullname as adminFullname from #_$tableProductMain as A inner join #_$tableProductVideo as B inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where $whereProduct order by A.date_created desc";

                /* SQL product video num */
                $sqlVideoNum = "select count(*) as 'num' from #_$tableProductMain as A inner join #_$tableProductVideo as B inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where $whereProduct order by A.date_created desc";
            } else {
                /* SQL product video */
                $sqlVideo = "select A.id as id, A.id_member as id_member, A.id_admin as id_admin, A.slugvi as slugvi, A.slugen as slugen, A.date_created as date_created, B.id as videoId, B.name$lang as videoName$lang, B.photo as videoPhoto, B.video as videoData, B.type as videoType, C.name as name_city, D.name as name_district, M.avatar as memberAvatar, M.fullname as memberFullname, U.avatar as adminAvatar, U.fullname as adminFullname from #_$tableProductMain as A inner join #_$tableProductVideo as B inner join #_city as C inner join #_district as D left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where $whereProduct and A.status_user = 'hienthi' order by A.date_created desc";

                /* SQL product video num */
                $sqlVideoNum = "select count(*) as 'num' from #_$tableProductMain as A inner join #_$tableProductVideo as B inner join #_city as C inner join #_district as D left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where $whereProduct and A.status_user = 'hienthi' order by A.date_created desc";
            }

            /* For load more ajax */
            $limitLoad = $config['website']['load-more']['video'];
            $limitFrom = (!empty($_GET['limitFrom'])) ? htmlspecialchars($_GET['limitFrom']) : 0;
            $limitGet = (!empty($_GET['limitGet'])) ? htmlspecialchars($_GET['limitGet']) : $limitLoad['show'];
            $videos = $d->rawQuery($sqlVideo . " limit " . $limitFrom . "," . $limitGet, $paramsProduct);
            $count = $d->rawQueryOne($sqlVideoNum, $paramsProduct);
            $total = (!empty($count)) ? $count['num'] : 0;

            /* Jsons data */
            if ($func->isAjax()) {
                $resultAjax['data'] = '';
                $resultAjax['total'] = $total;

                if (!empty($videos)) {
                    foreach ($videos as $k_video => $v_video) {
                        $v_video['clsMain'] = 'product-shadow';
                        $v_video['name'] = $v_video['videoName' . $lang];
                        $v_video['photo'] = $v_video['videoPhoto'];
                        $v_video['href'] = $sector['type'] . '/' . $v_video[$sluglang] . '/' . $v_video['id'] . '?video=' . $v_video['videoId'];
                        $v_video['sector'] = $sector;
                        $v_video['favourites'] = (!empty($favourites)) ? $favourites : array();
                        $v_video['idMember'] = $idMember;
                        $v_video['ownedShop'] = (!empty($ownedShop)) ? $ownedShop : array();
                        $v_video['sample'] = (!empty($sampleData)) ? $sampleData : array();

                        $resultAjax['data'] .= '<div class="col-3 mb-4">' . $func->getVideo($v_video) . '</div>';
                    }
                }

                echo json_encode($resultAjax);
                exit();
            }
        } else {
            if ($func->isAjax()) {
                /* Is ajax */
                $resultAjax['error'] = true;
                $resultAjax['message'] = 'Dữ liệu không hợp lệ';
                echo json_encode($resultAjax);
                exit();
            } else {
                $func->transfer("Dữ liệu không hợp lệ", $configBase, false);
            }
        }
    } else {
        if ($func->isAjax()) {
            /* Is ajax */
            $resultAjax['error'] = true;
            $resultAjax['message'] = 'Lĩnh vực kinh doanh không hợp lệ';
            echo json_encode($resultAjax);
            exit();
        } else {
            $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
        }
    }
}

/* SEO */
$seopage = $d->rawQueryOne("select * from #_seopage where id_shop = $idShop and type = ? limit 0,1", array($type_seo));
$seo->set('h1', (!empty($title_page)) ? $title_page : $title_crumb);
if (!empty($title_page)) $seo->set('title', $title_page);
else if (!empty($seopage['title' . $seolang])) $seo->set('title', $seopage['title' . $seolang]);
else $seo->set('title', $title_crumb);
if (!empty($seopage['keywords' . $seolang])) $seo->set('keywords', $seopage['keywords' . $seolang]);
if (!empty($seopage['description' . $seolang])) $seo->set('description', $seopage['description' . $seolang]);
$seo->set('url', $func->getPageURL());
$img_json_bar = (!empty($seopage['options'])) ? json_decode($seopage['options'], true) : null;
if (!empty($seopage['photo'])) {
    if (empty($img_json_bar) || ($img_json_bar['p'] != $seopage['photo'])) {
        $img_json_bar = $func->getImgSize($seopage['photo'], UPLOAD_SEOPAGE_L . $seopage['photo']);
        $seo->updateSeoDB(json_encode($img_json_bar), 'seopage', $seopage['id']);
    }
    if (!empty($img_json_bar)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $img_json_bar['w'] . 'x' . $img_json_bar['h'] . 'x2/' . UPLOAD_SEOPAGE_L . $seopage['photo']);
        $seo->set('photo:width', $img_json_bar['w']);
        $seo->set('photo:height', $img_json_bar['h']);
        $seo->set('photo:type', $img_json_bar['m']);
    }
}
