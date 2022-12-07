<?php
if (!defined('SOURCES')) die("Error");

/* Get data */
$isLogin = $func->getMember('active');
$idMember = $func->getMember('id');
$IDCat = (!empty($_GET['cat'])) ? htmlspecialchars($_GET['cat']) : 0;
$IDItem = (!empty($_GET['item'])) ? htmlspecialchars($_GET['item']) : 0;
$IDSub = (!empty($_GET['sub'])) ? htmlspecialchars($_GET['sub']) : 0;
$IDCity = (!empty($_GET['city'])) ? htmlspecialchars($_GET['city']) : 0;
$IDDistrict = (!empty($_GET['district'])) ? htmlspecialchars($_GET['district']) : 0;
$IDWard = (!empty($_GET['ward'])) ? htmlspecialchars($_GET['ward']) : 0;
$variantPost = (!empty($_GET['variantpost'])) ? htmlspecialchars($_GET['variantpost']) : '';
$IDFormWork = (!empty($_GET['formwork'])) ? htmlspecialchars($_GET['formwork']) : 0;
$IDPriceRange = (!empty($_GET['pricerange'])) ? htmlspecialchars($_GET['pricerange']) : 0;
$IDAcreage = (!empty($_GET['acreage'])) ? htmlspecialchars($_GET['acreage']) : 0;
$IDDatePost = (!empty($_GET['datepost'])) ? htmlspecialchars($_GET['datepost']) : 0;
$statusPost = (!empty($_GET['statuspost'])) ? htmlspecialchars($_GET['statuspost']) : 0;
$IDVideo = (!empty($_GET['video'])) ? htmlspecialchars($_GET['video']) : 0;
$FiltersActived = array();

/* Check sector */
// if (!in_array($type, $defineSectors['sectors']['types'])) {
//     $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
// }

/* Get sector */
$sector = $defineSectors['types'][$config['website']['sectors']];

/* New posting */
if (!empty($_POST['new-posting'])) {
    $message = '';
    $errors = array();
    $dataNewPosting = (!empty($_POST['dataNewPosting'])) ? $_POST['dataNewPosting'] : array();

    /* Valid data */
    if (empty($isLogin)) {
        $errors[] = 'Chưa đăng nhập thành viên';
    }

    if (empty($dataNewPosting)) {
        $errors[] = 'Chưa chọn lĩnh vực';
    }

    if (!empty($errors)) {
        $str = '<div class="text-left">';

        foreach ($errors as $v_error) {
            $str .= "- " . $v_error . "</br>";
        }

        $str .= "</div>";

        $func->transfer($str, $func->getCurrentPageURL(), false);
    }

    /* Delete old data */
    $d->rawQuery("delete from #_member_new_posting where id_member = ?", array($idMember));

    /* Save data */
    foreach ($dataNewPosting as $k => $v) {
        if (!empty($v)) {
            foreach ($v as $idCat) {
                $data = array();
                $data['id_member'] = $idMember;
                $data['id_list'] = $k;
                $data['id_cat'] = $idCat;
                $d->insert('member_new_posting', $data);
            }
        }
    }

    /* Delete cache */
    $cache->delete();

    /* Success */
    $func->transfer('Đăng ký thành công', $func->getCurrentPageURL());
}

/* Get data from member: New Posting, Favourite */
if (!empty($isLogin)) {
    /* Get newPosting */
    $newPosting = $cache->get("select id_cat from #_member_new_posting where id_member = ?", array($idMember), "result", 7200);
    $newPosting = (!empty($newPosting)) ? $func->joinCols($newPosting, 'id_cat') : array();

    /* Get favourite */
    $favourites = $cache->get("select id_variant from #_member_favourite where id_member = ? and type = ? and variant = ?", array($idMember, $sector['type'], 'product'), "result", 7200);
    $favourites = (!empty($favourites)) ? $func->joinCols($favourites, 'id_variant') : array();
    $favourites = (!empty($favourites)) ? explode(",", $favourites) : array();
}

/* Category */
if (empty($id)) {
    /* Labels */
    $func->set('sector-label', $func->textConvert($sector['name'], 'capitalize'));

    /* Sector list detail */
    $sectorListDetail = $cache->get("select name$lang, id, options, photo, photo3, type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($sector['id']), 'fetch', 7200);

    /* Get seo */
    $sectorSeo = $sectorListDetail;
    $sectorSeo['tableMain'] = 'product_list';
    $sectorSeo['tableSeo'] = 'product_list_seo';

    /* Action class modal */
    $func->set('actionClsModal-cat-clsMain', 'filter-cat');
    $func->set('actionClsModal-city-clsMain', 'filter-city');
    $func->set('actionClsModal-district-clsMain', 'filter-district');
    $func->set('actionClsModal-ward-clsMain', 'filter-ward');

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

    /* Sector cat */
    $sectorCats = $cache->get("select name$lang, photo, slugvi, slugen, id from #_product_cat where id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array($sector['id']), 'result', 7200);

    /* Sector cat detail */
    if (!empty($IDCat)) {
        $sectorCatDetail = $cache->get("select name$lang, id, options, photo from #_product_cat where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDCat), 'fetch', 7200);

        /* Check sector */
        if (!empty($sectorCatDetail)) {
            /* Get seo */
            $sectorSeo = $sectorCatDetail;
            $sectorSeo['tableMain'] = 'product_cat';
            $sectorSeo['tableSeo'] = 'product_cat_seo';

            /* Get name */
            $func->set('sector-label', $func->textConvert($sectorCatDetail['name' . $lang], 'capitalize'));

            /* Get filters actived */
            $FiltersActived['cat']['clsFilter'] = 'filter-cat';
            $FiltersActived['cat']['clsMain'] = 'sectors-cat';
            $FiltersActived['cat']['name'] = $func->get('sector-label');
        } else {
            $func->transfer("Lĩnh vực ngành nghề không hợp lệ", $configBase, false);
        }
    }

    /* Sector item */
    $paramsItem = array($sector['id']);
    $whereItem = '';

    if (!empty($IDCat)) {
        $whereItem = ' and id_cat = ?';
        array_push($paramsItem, $IDCat);
    } else if (!empty($sectorCats[0])) {
        $whereItem = ' and id_cat = ?';
        array_push($paramsItem, $sectorCats[0]['id']);
    }

    if (!empty($whereItem)) {
        $sectorItems = $cache->get("select name$lang, photo, photo2, slugvi, slugen, id, id_cat from #_product_item where id_list = ? $whereItem and find_in_set('hienthi',status) order by numb,id desc", $paramsItem, 'result', 7200);
    }

    /* Sector item detail */
    if (!empty($IDItem)) {
        $sectorItemDetail = $cache->get("select name$lang, id, options, photo from #_product_item where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDItem), 'fetch', 7200);

        /* Check sector */
        if (!empty($sectorItemDetail)) {
            /* Get seo */
            $sectorSeo = $sectorItemDetail;
            $sectorSeo['tableMain'] = 'product_item';
            $sectorSeo['tableSeo'] = 'product_item_seo';

            /* Get name */
            $func->set('sector-label', $func->textConvert($sectorItemDetail['name' . $lang], 'capitalize'));

            /* Get filters actived */
            $FiltersActived['item']['clsFilter'] = 'filter-item';
            $FiltersActived['item']['clsMain'] = 'sectors-item';
            $FiltersActived['item']['name'] = $func->get('sector-label');
        } else {
            $func->transfer("Lĩnh vực ngành nghề không hợp lệ", $configBase, false);
        }
    }

    /* Sector sub */
    if (in_array($sector['type'], array($config['website']['sectors']))) {
        $paramsSub = array($sector['id']);
        $whereSub = '';

        if (!empty($IDCat)) {
            $whereSub = ' and id_cat = ?';
            array_push($paramsSub, $IDCat);

            if (!empty($IDItem)) {
                $whereSub .= ' and id_item = ?';
                array_push($paramsSub, $IDItem);
            } else if (!empty($sectorItems[0])) {
                $whereSub .= ' and id_item = ?';
                array_push($paramsSub, $sectorItems[0]['id']);
            }
        } else if (!empty($sectorCats[0]) && !empty($sectorItems[0])) {
            $whereSub = ' and id_cat = ? and id_item = ?';
            array_push($paramsSub, $sectorCats[0]['id']);
            array_push($paramsSub, $sectorItems[0]['id']);
        }

        if (!empty($whereSub)) {
            $sectorSubs = $cache->get("select name$lang, photo, slugvi, slugen, id, id_cat, id_item from #_product_sub where id_list = ? $whereSub and find_in_set('hienthi',status) order by numb,id desc", $paramsSub, 'result', 7200);
        }

        /* Sector sub detail */
        if (!empty($IDSub)) {
            $sectorSubDetail = $cache->get("select name$lang, id, options, photo from #_product_sub where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSub), 'fetch', 7200);

            /* Check sector */
            if (!empty($sectorSubDetail)) {
                /* Get seo */
                $sectorSeo = $sectorSubDetail;
                $sectorSeo['tableMain'] = 'product_sub';
                $sectorSeo['tableSeo'] = 'product_sub_seo';

                /* Get name */
                $func->set('sector-label', $func->textConvert($sectorSubDetail['name' . $lang], 'capitalize'));

                /* Get filters actived */
                $FiltersActived['sub']['clsFilter'] = 'filter-sub';
                $FiltersActived['sub']['clsMain'] = 'sectors-sub';
                $FiltersActived['sub']['name'] = $func->get('sector-label');
            } else {
                $func->transfer("Lĩnh vực ngành nghề không hợp lệ", $configBase, false);
            }
        }
    }

    /* City detail */
    if (!empty($IDCity)) {
        $cityDetail = $cache->get("select name from #_city where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDCity), 'fetch', 7200);

        /* Check city */
        if (!empty($cityDetail)) {
            $func->set('city-name', $func->textConvert($cityDetail['name'], 'capitalize'));

            /* Get filters actived */
            $FiltersActived['city']['clsFilter'] = 'filter-city';
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
            $FiltersActived['district']['clsFilter'] = 'filter-district';
            $FiltersActived['district']['clsMain'] = 'district';
            $FiltersActived['district']['name'] = $func->get('district-name');
        } else {
            $func->transfer("Quận/huyện không hợp lệ", $configBase, false);
        }
    }

    /* Ward detail */
    if (!empty($IDWard)) {
        $wardDetail = $cache->get("select name from #_wards where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDWard), 'fetch', 7200);

        /* Check ward */
        if (!empty($wardDetail)) {
            $func->set('ward-name', $func->textConvert($wardDetail['name'], 'capitalize'));

            /* Get filters actived */
            $FiltersActived['ward']['clsFilter'] = 'filter-ward';
            $FiltersActived['ward']['clsMain'] = 'ward';
            $FiltersActived['ward']['name'] = $func->get('ward-name');
        } else {
            $func->transfer("Phường/xã không hợp lệ", $configBase, false);
        }
    }

    /* Label place */
    $func->set('place-label', !empty($func->get('ward-name')) ? $func->get('ward-name') : (!empty($func->get('district-name')) ? $func->get('district-name') : (!empty($func->get('city-name')) ? $func->get('city-name') : 'Toàn quốc')));

    /* Label district */
    $labelDistrict = (!empty($func->get('sector-label'))) ? $func->get('sector-label') : '';
    $labelDistrict .= (empty($func->get('district-name')) && !empty($func->get('city-name'))) ? ' tại ' . $func->get('city-name') : ((!empty($func->get('district-name'))) ? ' tại ' . $func->get('district-name') : '');
    $func->set('district-label', $labelDistrict);

    /* Label ward */
    $labelWard = (!empty($func->get('sector-label'))) ? $func->get('sector-label') : '';
    $labelWard .= (empty($func->get('ward-name')) && !empty($func->get('district-name'))) ? ' tại ' . $func->get('district-name') : ((!empty($func->get('ward-name'))) ? ' tại ' . $func->get('ward-name') : '');
    $func->set('ward-label', $labelWard);

    /* Stores */
    if (in_array($sector['type'], array($config['website']['sectors']))) {
        $paramsStore = array($sector['id']);
        $whereStore = '';

        if (!empty($IDCat)) {
            $whereStore .= ' and id_cat = ?';
            array_push($paramsStore, $IDCat);
        }

        $stores = $cache->get("select name$lang, photo, slugvi, slugen, id from #_store where id_list = ? $whereStore and find_in_set('hienthi',status) order by numb,id desc", $paramsStore, 'result', 7200);
    }

    /* Advertises */
    if (in_array($sector['type'], array($config['website']['sectors']))) {
        $advertises = array();
        $advertises['data'] = $cache->get("select name$lang, photo, link from #_photo where id_shop = $idShop and type = ? and find_in_set('hienthi',status) order by numb,id desc", array('advertise-' . $sector['prefix']), 'result', 7200);

        /* Custom owl - image */
        if (!empty($advertises['data'])) {
          
                $advertises['owl-items'] = 'items:1,margin:0';
                $advertises['image']['show'] = 1;
                $advertises['image']['sizes'] = '1200x350x1';
            
        }
    }

    /* Get SEO from DB */
    $seoDB = $seo->getOnDB('*', $sectorSeo['tableSeo'], $sectorSeo['id']);

    /* Title for SEO */
    $seoTitle = '';

    if ($func->has('ward-name')) {
        $seoTitle .= $func->get('ward-name') . ', ';
    }

    if ($func->has('district-name')) {
        $seoTitle .= $func->get('district-name') . ', ';
    }

    if ($func->has('city-name')) {
        $seoTitle .= $func->get('city-name');
    }

    $seoTitle = (!empty($seoTitle)) ? ' tại ' . $seoTitle : '';

    /* Set SEO */
    $seo->set('h1', $sectorSeo['name' . $lang] . $seoTitle);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang] . $seoTitle);
    else $seo->set('title', $sectorSeo['name' . $lang] . $seoTitle);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $img_json_bar = (!empty($sectorSeo['options'])) ? json_decode($sectorSeo['options'], true) : null;
    if (empty($img_json_bar) || ($img_json_bar['p'] != $sectorSeo['photo'])) {
        $img_json_bar = $func->getImgSize($sectorSeo['photo'], UPLOAD_PRODUCT_L . $sectorSeo['photo']);
        $seo->updateSeoDB(json_encode($img_json_bar), $sectorSeo['tableMain'], $sectorSeo['id']);
    }
    if (!empty($img_json_bar)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $img_json_bar['w'] . 'x' . $img_json_bar['h'] . 'x2/' . UPLOAD_PRODUCT_L . $sectorSeo['photo']);
        $seo->set('photo:width', $img_json_bar['w']);
        $seo->set('photo:height', $img_json_bar['h']);
        $seo->set('photo:type', $img_json_bar['m']);
    }

    /* Products */
    if (!empty($sector['tables'])) {
        /* Tables */
        $tableProductMain = (!empty($sector['tables']['main'])) ? $sector['tables']['main'] : '';
        $tableProductVariation = (!empty($sector['tables']['variation'])) ? $sector['tables']['variation'] : '';
        $tableProductInfo = (!empty($sector['tables']['info'])) ? $sector['tables']['info'] : '';
        $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';

        /* Filters */
        if (!empty($tableProductMain)) {
            /* Get logic when owner or shop unactive */
            $whereLogicOwner = $func->getLogicOwner($tableShop, $sector);

            /* Filters form work */
            if (in_array($sector['type'], array('ung-vien', 'nha-tuyen-dung'))) {
                $func->set('formWork-active', true);
                $func->set('formWork-label', 'Hình thức làm việc');
                $func->set('formWork-data', $cache->get("select name$lang, id from #_variation where type = ? and id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array('hinh-thuc-lam-viec', $sector['id']), 'result', 7200));
            }

            /* Filters price range */
            $func->set('priceRange-active', true);
            $func->set('priceRange-label', (in_array($sector['type'], array('ung-vien', 'nha-tuyen-dung'))) ? 'Mức lương' : 'Mức giá');
            $func->set('priceRange-data', $cache->get("select name$lang, id from #_variation where type = ? and id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array('muc-gia', $sector['id']), 'result', 7200));

            /* Filters acreage */
            if (in_array("acreage", $sector['attributes'])) {
                $func->set('acreage-active', true);
                $func->set('acreage-label', 'Diện tích');
                $func->set('acreage-data', $cache->get("select name$lang, id from #_variation where type = ? and id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array('dien-tich', $sector['id']), 'result', 7200));
            }

            /* Filters date post */
            $func->set('datePost-active', true);
            $func->set('datePost-label', 'Thời gian đăng tin');
            $func->set('datePost-clsFilter', 'filter-date-post');
            $func->set('datePost-clsMain', 'date-post');
            $func->set('datePost-data', $cache->get("select name$lang, id from #_variation where type = ? and find_in_set('hienthi',status) order by numb,id desc", array('thoi-gian-dang-tin'), 'result', 7200));

            /* Where product */
            $whereProduct = "A.status = ?";
            $paramsProduct = array('xetduyet');

            /* Where cat */
            if (!empty($IDCat)) {
                $whereProduct .= " and A.id_cat = ?";
                array_push($paramsProduct, $IDCat);
            }

            /* Where item */
            if (!empty($IDItem)) {
                $whereProduct .= " and A.id_item = ?";
                array_push($paramsProduct, $IDItem);
            }

            /* Where sub */
            if (!empty($IDSub)) {
                if (in_array($sector['type'], array($config['website']['sectors']))) {
                    $whereProduct .= " and A.id_sub = ?";
                    array_push($paramsProduct, $IDSub);
                } else {
                    $func->transfer("Trang không hợp lệ", $configBase, false);
                }
            }

            /* Where city */
            if (!empty($IDCity)) {
                $whereProduct .= " and A.id_city = ?";
                array_push($paramsProduct, $IDCity);
            }

            /* Where district */
            if (!empty($IDDistrict)) {
                $whereProduct .= " and A.id_district = ?";
                array_push($paramsProduct, $IDDistrict);
            }

            /* Where ward */
            if (!empty($IDWard)) {
                $whereProduct .= " and A.id_wards = ?";
                array_push($paramsProduct, $IDWard);
            }

            /* Where variant post */
            if (!empty($variantPost)) {
                if ($func->hasShop($sectorListDetail)) {
                    /* Get filters actived */
                    $FiltersActived['variantPost']['clsFilter'] = 'filter-variant-post';
                    $FiltersActived['variantPost']['clsMain'] = 'variant-post';

                    /* Filter by variant */
                    if ($variantPost == 'all') {
                        $whereProduct .= "";
                        $FiltersActived['variantPost']['name'] = 'Tin đăng Cửa hàng và Cá nhân';
                    } else if ($variantPost == 'shop') {
                        $whereProduct .= " and A.id_shop > 0";
                        $FiltersActived['variantPost']['name'] = 'Tin đăng Cửa hàng';
                    } else if ($variantPost == 'personal') {
                        $whereProduct .= " and A.id_shop = 0";
                        $FiltersActived['variantPost']['name'] = 'Tin đăng Cá nhân';
                    } else {
                        $func->transfer("Trang không hợp lệ", $configBase, false);
                    }
                } else {
                    $func->transfer("Trang không hợp lệ", $configBase, false);
                }
            }

            /* Where price range */
            if (!empty($IDPriceRange)) {
                $info = $cache->get("select value_real_from, value_real_to, namevi, nameen from #_variation where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDPriceRange), 'fetch', 7200);

                if (!empty($info)) {
                    $whereProduct .= " and (A.real_price >= ? and A.real_price <= ?)";
                    array_push($paramsProduct, $info['value_real_from']);
                    array_push($paramsProduct, $info['value_real_to']);

                    /* Get filters actived */
                    $FiltersActived['priceRange']['clsFilter'] = 'filter-price-range';
                    $FiltersActived['priceRange']['clsMain'] = 'price-range';
                    $FiltersActived['priceRange']['name'] = $info['name' . $lang];

                    /* Unset info */
                    unset($info);
                } else {
                    $func->transfer("Trang không hợp lệ", $configBase, false);
                }
            }

            /* Where acreage */
            if (!empty($IDAcreage)) {
                if (in_array("acreage", $sector['attributes'])) {
                    $info = $cache->get("select value_from, value_to, namevi, nameen from #_variation where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDAcreage), 'fetch', 7200);

                    if (!empty($info)) {
                        $whereProduct .= " and (A.acreage >= ? and A.acreage <= ?)";
                        array_push($paramsProduct, $info['value_from']);
                        array_push($paramsProduct, $info['value_to']);

                        /* Get filters actived */
                        $FiltersActived['acreage']['clsFilter'] = 'filter-acreage';
                        $FiltersActived['acreage']['clsMain'] = 'acreage';
                        $FiltersActived['acreage']['name'] = $info['name' . $lang];

                        /* Unset info */
                        unset($info);
                    } else {
                        $func->transfer("Trang không hợp lệ", $configBase, false);
                    }
                } else {
                    $func->transfer("Trang không hợp lệ", $configBase, false);
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
                    $FiltersActived['datePost']['clsFilter'] = 'filter-date-post';
                    $FiltersActived['datePost']['clsMain'] = 'date-post';
                    $FiltersActived['datePost']['name'] = $info['name' . $lang];

                    /* Unset info */
                    unset($info);
                } else {
                    $func->transfer("Trang không hợp lệ", $configBase, false);
                }
            }

            /* As service or accessary */
            if (!empty($statusPost)) {
                if ($statusPost == 'service' && $func->hasService($sector)) {
                    $whereProduct .= " and find_in_set('dichvu',A.status_attr)";

                    /* Get filters actived */
                    $FiltersActived['statusPost']['clsFilter'] = 'filter-status-post';
                    $FiltersActived['statusPost']['clsMain'] = 'status-post';
                    $FiltersActived['statusPost']['name'] = 'Dịch vụ giấy tờ';
                } else if ($statusPost == 'accessary' && $func->hasAccessary($sector)) {
                    $whereProduct .= " and find_in_set('phutung',A.status_attr)";

                    /* Get filters actived */
                    $FiltersActived['statusPost']['clsFilter'] = 'filter-status-post';
                    $FiltersActived['statusPost']['clsMain'] = 'status-post';
                    $FiltersActived['statusPost']['name'] = 'Phụ tùng xe';
                } else {
                    $func->transfer("Trang không hợp lệ", $configBase, false);
                }
            }

            /* Where logic when owner or shop unactive */
            $whereProduct .= $whereLogicOwner['where'];

            /* SQL paging */
            $curPage = $getPage;
            $perPage = 40;
            $startpoint = ($curPage * $perPage) - $perPage;

            /* SQL sector */
            if (in_array($sector['type'], array($config['website']['sectors']))) {
                /* Where products */
                $whereProduct .= " and A.id_city = C.id and A.id_district = D.id";

                /* Where logic when shop unactive */
                $whereProduct .= $func->getLogicShop($tableShop, $whereLogicOwner);

                /* SQL main */
                $sqlProduct = "select A.id as id, A.id_shop as id_shop, A.id_member as id_member, A.id_admin as id_admin, A.name$lang as name$lang,A.desc$lang as desc$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, C.name as name_city, D.name as name_district, S.id_interface as shopInterface, S.name as shopName, S.slug_url as shopUrl, P.photo as shopLogo, M.avatar as memberAvatar, M.fullname as memberFullname, U.avatar as adminAvatar, U.fullname as adminFullname from #_$tableProductMain as A inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where $whereProduct order by A.date_created desc limit $startpoint,$perPage";

                /* SQL num */
                $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where $whereProduct order by A.date_created desc";
            } else if (in_array($sector['type'], array('ung-vien'))) {
                /* Where products */
                $whereProduct .= " and A.status_user = 'hienthi' and A.id = B.id_parent and A.id_city = C.id and A.id_district = D.id";

                /* Where form work */
                if (!empty($IDFormWork)) {
                    $whereProduct .= " and A.id = V.id_parent and V.id_variation = ? and V.type = ?";
                    array_push($paramsProduct, $IDFormWork);
                    array_push($paramsProduct, 'hinh-thuc-lam-viec');

                    /* Get filters actived */
                    $info = $cache->get("select namevi, nameen from #_variation where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDFormWork), 'fetch', 7200);

                    /* Get filters actived */
                    $FiltersActived['formWork']['clsFilter'] = 'filter-form-work';
                    $FiltersActived['formWork']['clsMain'] = 'form-work';
                    $FiltersActived['formWork']['name'] = $info['name' . $lang];

                    /* Unset info */
                    unset($info);

                    /* SQL main */
                    $sqlProduct = "select A.id as id, A.id_member as id_member, A.name$lang as name$lang,A.desc$lang as desc$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, B.first_name as first_name, B.last_name as last_name, C.name as name_city, D.name as name_district from #_$tableProductMain as A, #_$tableProductInfo as B, #_city as C, #_district as D, #_$tableProductVariation as V where $whereProduct order by A.date_created desc limit $startpoint,$perPage";

                    /* SQL num */
                    $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A, #_$tableProductInfo as B, #_city as C, #_district as D, #_$tableProductVariation as V where $whereProduct order by A.date_created desc";
                } else {
                    /* SQL main */
                    $sqlProduct = "select A.id as id, A.id_member as id_member, A.name$lang as name$lang,A.desc$lang as desc$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, B.first_name as first_name, B.last_name as last_name, C.name as name_city, D.name as name_district from #_$tableProductMain as A, #_$tableProductInfo as B, #_city as C, #_district as D where $whereProduct order by A.date_created desc limit $startpoint,$perPage";

                    /* SQL num */
                    $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A, #_$tableProductInfo as B, #_city as C, #_district as D where $whereProduct order by A.date_created desc";
                }
            } else if (in_array($sector['type'], array('nha-tuyen-dung'))) {
                /* Where products */
                $whereProduct .= " and A.status_user = 'hienthi' and A.id = B.id_parent and A.id_city = C.id and A.id_district = D.id";

                /* Where form work */
                if (!empty($IDFormWork)) {
                    $whereProduct .= " and A.id = V.id_parent and V.id_variation = ? and V.type = ?";
                    array_push($paramsProduct, $IDFormWork);
                    array_push($paramsProduct, 'hinh-thuc-lam-viec');

                    /* Get filters actived */
                    $info = $cache->get("select namevi, nameen from #_variation where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDFormWork), 'fetch', 7200);

                    /* Get filters actived */
                    $FiltersActived['formWork']['clsFilter'] = 'filter-form-work';
                    $FiltersActived['formWork']['clsMain'] = 'form-work';
                    $FiltersActived['formWork']['name'] = $info['name' . $lang];

                    /* Unset info */
                    unset($info);

                    /* SQL main */
                    $sqlProduct = "select A.id as id, A.id_member as id_member, A.name$lang as name$lang,A.desc$lang as desc$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, B.fullname as fullname, B.employee_quantity as employee_quantity, C.name as name_city, D.name as name_district from #_$tableProductMain as A, #_$tableProductInfo as B, #_city as C, #_district as D, #_$tableProductVariation as V where $whereProduct order by A.date_created desc limit $startpoint,$perPage";

                    /* SQL num */
                    $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A, #_$tableProductInfo as B, #_city as C, #_district as D, #_$tableProductVariation as V where $whereProduct order by A.date_created desc";
                } else {
                    /* SQL main */
                    $sqlProduct = "select A.id as id, A.id_member as id_member, A.name$lang as name$lang,A.desc$lang as desc$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, B.fullname as fullname, B.employee_quantity as employee_quantity, C.name as name_city, D.name as name_district from #_$tableProductMain as A, #_$tableProductInfo as B, #_city as C, #_district as D where $whereProduct order by A.date_created desc limit $startpoint,$perPage";

                    /* SQL num */
                    $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A, #_$tableProductInfo as B, #_city as C, #_district as D where $whereProduct order by A.date_created desc";
                }
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
            $func->transfer("Dữ liệu để lọc tin không hợp lệ", $configBase, false);
        }
    } else {
        $func->transfer("Dữ liệu để lọc tin không hợp lệ", $configBase, false);
    }
} else if (!empty($id)) /* Detail */ {
    /* Labels sector */
    $func->set('sector-label', $func->textConvert($sector['name'], 'capitalize'));

    /* Sector cat */
    $sectorCats = $cache->get("select name$lang, photo, slugvi, slugen, id from #_product_cat where id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array($sector['id']), 'result', 7200);

    /* Action class modal */
    $func->set('actionClsModal-cat-clsMain', 'filter-cat-posting-detail');

    /* City detail */
    if (!empty($IDCity)) {
        $cityDetail = $cache->get("select id from #_city where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDCity), 'fetch', 7200);

        /* Check city */
        if (empty($cityDetail)) {
            $func->transfer("Tỉnh/thành phố không hợp lệ", $configBase, false);
        }
    }

    /* Detail */
    if (!empty($sector['tables'])) {
        /* Tables */
        $tableProductMain = (!empty($sector['tables']['main'])) ? $sector['tables']['main'] : '';
        $tableProductContent = (!empty($sector['tables']['content'])) ? $sector['tables']['content'] : '';
        $tableProductInfo = (!empty($sector['tables']['info'])) ? $sector['tables']['info'] : '';
        $tableProductPhoto = (!empty($sector['tables']['photo'])) ? $sector['tables']['photo'] : '';
        $tableProductTag = (!empty($sector['tables']['tag'])) ? $sector['tables']['tag'] : '';
        $tableProductSale = (!empty($sector['tables']['sale'])) ? $sector['tables']['sale'] : '';
        $tableProductVideo = (!empty($sector['tables']['video'])) ? $sector['tables']['video'] : '';
        $tableProductContact = (!empty($sector['tables']['contact'])) ? $sector['tables']['contact'] : '';
        $tableProductComment = (!empty($sector['tables']['comment'])) ? $sector['tables']['comment'] : '';
        $tableProductCommentPhoto = (!empty($sector['tables']['comment-photo'])) ? $sector['tables']['comment-photo'] : '';
        $tableProductCommentVideo = (!empty($sector['tables']['comment-video'])) ? $sector['tables']['comment-video'] : '';
        $tableProductVariation = (!empty($sector['tables']['variation'])) ? $sector['tables']['variation'] : '';
        $tableProductSeo = (!empty($sector['tables']['seo'])) ? $sector['tables']['seo'] : '';
        $tableProductReport = (!empty($sector['tables']['report-product'])) ? $sector['tables']['report-product'] : '';
        $tableProductReportInfo = (!empty($sector['tables']['report-product-info'])) ? $sector['tables']['report-product-info'] : '';
        $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';
        $tableShopSubscribe = (!empty($sector['tables']['shop-subscribe'])) ? $sector['tables']['shop-subscribe'] : '';

        /* Get logic when owner or shop unactive */
        $whereLogicOwner = $func->getLogicOwner($tableShop, $sector);

        /* Where logic when owner or shop unactive */
        $whereDetail = $whereLogicOwner['where'];

        /* Get detail */
        if (in_array($sector['type'], array($config['website']['sectors']))) {
            /* Where logic when shop unactive */
            $whereDetail .= $func->getLogicShop($tableShop, $whereLogicOwner);

            $colsDetailSelect = "A.id as id, A.id_shop as id_shop, A.id_cat as id_cat, A.id_item as id_item, A.id_sub as id_sub, A.id_city as id_city, A.id_district as id_district, A.id_wards as id_wards, A.id_member as id_member, A.id_admin as id_admin, A.regular_price as regular_price, A.date_created as date_created, A.views as views, A.name$lang as name$lang,A.desc$lang as desc$lang, A.slugvi as slugvi, A.slugen as slugen, A.photo as photo, A.status_attr as status_attr, A.options as options";

            if (in_array("acreage", $sector['attributes'])) {
                $colsDetailSelect .= ", A.acreage as acreage";
            }

            if (in_array("coordinates", $sector['attributes'])) {
                $colsDetailSelect .= ", A.coordinates as coordinates";
            }

            $sqlDetail = "select $colsDetailSelect from #_$tableProductMain as A where A.id_list = ? and A.id = ? and A.slugvi = ? and A.status = ? $whereDetail limit 0,1";
            $paramsDetail = array($sector['id'], $id, $slug, 'xetduyet');
        } else if (in_array($sector['type'], array('ung-vien', 'nha-tuyen-dung'))) {
            $colsDetailSelect = "A.id as id, A.id_cat as id_cat, A.id_item as id_item, A.id_sub as id_sub, A.id_city as id_city, A.id_district as id_district, A.id_wards as id_wards, A.id_member as id_member, A.id_admin as id_admin, A.regular_price as regular_price, A.date_created as date_created, A.views as views, A.name$lang as name$lang,A.desc$lang as desc$lang, A.slugvi as slugvi, A.slugen as slugen, A.photo as photo, A.options as options";

            if (in_array("coordinates", $sector['attributes'])) {
                $colsDetailSelect .= ", A.coordinates as coordinates";
            }

            $sqlDetail = "select $colsDetailSelect from #_$tableProductMain as A where A.id_list = ? and A.id = ? and A.slugvi = ? and A.status = ? $whereDetail limit 0,1";
            $paramsDetail = array($sector['id'], $id, $slug, 'xetduyet');
        }

        $rowDetail = $cache->get($sqlDetail, $paramsDetail, 'fetch', 7200);

        /* Check if url has video */
        $videoDetail = (!empty($IDVideo)) ? $d->rawQueryOne("select * from #_$tableProductVideo where id_parent = ? and id = ? limit 0,1", array($rowDetail['id'], $IDVideo)) : array();

        /* Check exist */
        if (empty($rowDetail) || (!empty($IDVideo) && empty($videoDetail))) {
            /* Is ajax */
            if ($func->isAjax()) {
                $resultAjax = array();
                $resultAjax['status'] = 'error';
                $resultAjax['message'] = 'Tin đăng không tồn tại';
                echo json_encode($resultAjax);
                exit();
            } else {
                header('HTTP/1.0 404 Not Found', true, 404);
                include("404.php");
                exit();
            }
        }

        /* Update views */
        if (!$func->isAjax()) {
            if (!empty($IDVideo)) {
                /* Get now views */
                $rowVideoDetailView = $d->rawQueryOne("select views from #_$tableProductVideo where id = ? limit 0,1", array($videoDetail['id']));

                /* Math views */
                $dataViews = array();
                $dataViews['views'] = $rowVideoDetailView['views'] + 1;
                $d->where('id', $videoDetail['id']);

                if ($d->update($tableProductVideo, $dataViews)) {
                    /* Get newest views */
                    $videoDetail['views'] = $dataViews['views'];
                }
            } else {
                /* Get now views */
                $rowDetailView = $d->rawQueryOne("select views from #_$tableProductMain where id = ? limit 0,1", array($rowDetail['id']));

                /* Math views */
                $dataViews = array();
                $dataViews['views'] = $rowDetailView['views'] + 1;
                $d->where('id', $rowDetail['id']);

                if ($d->update($tableProductMain, $dataViews)) {
                    /* Get newest views */
                    $rowDetail['views'] = $dataViews['views'];
                }
            }
        }

        /* Comment */
        $comment = new Comments($d, $func, ['shop' => $tableShop, 'main' => $tableProductComment, 'photo' => $tableProductCommentPhoto, 'video' => $tableProductCommentVideo], $sector['prefix'], $rowDetail['id']);

        /* Report status */
        $reportStatus = $cache->get("select id, name$lang, desc$lang from #_report_status where find_in_set('hienthi',status) order by numb,id desc", null, 'result', 7200);

        /* Report */
        if (!empty($_POST['submit-report']) || ($func->isAjax() && !empty($_GET['isAjaxReport']))) {
            $codeCaptcha = $_POST['captcha-report'];
            $sessionCaptcha = (!empty($_SESSION["captcha"]["report"])) ? $_SESSION["captcha"]["report"] : null;
            $responseCaptcha = $_POST['recaptcha_response_report'];
            $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
            $scoreCaptcha = (!empty($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
            $actionCaptcha = (!empty($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
            $testCaptcha = (!empty($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;
            $dataReport = (!empty($_POST['dataReport'])) ? $_POST['dataReport'] : null;

            /* Check exist report of member */
            if (!empty($isLogin) && !empty($idMember)) {
                $existReport = $d->rawQueryOne("select B.id_member as idMember from #_$tableProductReport as A, #_$tableProductReportInfo as B where A.id = B.id_parent and A.id_product = ? and B.id_member = ?", array($rowDetail['id'], $idMember));
            }

            /* Valid data */
            $errors = array();
            if (empty($isLogin)) {
                $errors[] = 'Vui lòng đăng nhập để báo xấu tin đăng';
            } else if (!empty($existReport['idMember'])) {
                $errors[] = 'Bạn đã báo xấu tin đăng này';
            } else {
                if (empty($dataReport['id_status'])) {
                    $errors[] = 'Chưa chọn dữ liệu báo xấu';
                }

                if (empty($dataReport['fullname'])) {
                    $errors[] = 'Họ tên không được trống';
                }

                if (empty($dataReport['phone'])) {
                    $errors[] = 'Số điện thoại không được trống';
                }

                if (!empty($dataReport['phone']) && !$func->isPhone($dataReport['phone'])) {
                    $errors[] = 'Số điện thoại không hợp lệ';
                }

                if (empty($dataReport['email'])) {
                    $errors[] = 'Email không được trống';
                }

                if (!empty($dataReport['email']) && !$func->isEmail($dataReport['email'])) {
                    $errors[] = 'Email không hợp lệ';
                }

                if (empty($dataReport['content'])) {
                    $errors[] = 'Nội dung không được trống';
                }

                if (empty($codeCaptcha)) {
                    $errors[] = 'Mã bảo mật không được trống';
                }

                if (!empty($codeCaptcha) && !empty($sessionCaptcha) && $codeCaptcha != $sessionCaptcha) {
                    $errors[] = 'Mã bảo mật không chính xác';
                }
            }

            if (!empty($errors)) {
                $str = '<div class="text-left">';

                foreach ($errors as $v_error) {
                    $str .= "- " . $v_error . "</br>";
                }

                $str .= "</div>";

                /* Destroy session captcha */
                unset($_SESSION["captcha"]["report"]);

                /* Is ajax */
                if ($func->isAjax()) {
                    $resultAjax = array();
                    $resultAjax['status'] = 'error';
                    $resultAjax['message'] = $str;
                    echo json_encode($resultAjax);
                    exit();
                } else {
                    $func->transfer($str, $func->getCurrentPageURL(), false);
                }
            }

            if (($scoreCaptcha >= 0.5 && $actionCaptcha == 'Report' && $codeCaptcha == $sessionCaptcha) || $testCaptcha == true) {
                if (!empty($dataReport)) {
                    /* Check exist report */
                    $reportDetail = $d->rawQueryOne("select id, id_product from #_$tableProductReport where id_product = ? limit 0,1", array($rowDetail['id']));

                    /* Data report info */
                    $dataReportInfo = array();
                    $dataReportInfo['id_member'] = $idMember;
                    $dataReportInfo['id_status'] = htmlspecialchars($dataReport['id_status']);
                    $dataReportInfo['fullname'] = htmlspecialchars($dataReport['fullname']);
                    $dataReportInfo['phone'] = htmlspecialchars($dataReport['phone']);
                    $dataReportInfo['email'] = htmlspecialchars($dataReport['email']);
                    $dataReportInfo['content'] = htmlspecialchars($dataReport['content']);

                    /* Insert or Update data */
                    if (!empty($reportDetail['id'])) {
                        $dataReportInfo['id_parent'] = $reportDetail['id'];

                        /* Insert data report info */
                        if ($d->insert($tableProductReportInfo, $dataReportInfo)) {
                            $successReport = true;
                        } else {
                            $successReport = false;
                        }
                    } else {
                        /* Data report */
                        $dataReportMain = array();
                        $dataReportMain['id_shop'] = $rowDetail['id_shop'];
                        $dataReportMain['id_product'] = $rowDetail['id'];
                        $dataReportMain['numb'] = 0;
                        $dataReportMain['status'] = 0;
                        $dataReportMain['date_created'] = time();

                        if ($d->insert($tableProductReport, $dataReportMain)) {
                            $id_insert = $d->getLastInsertId();
                            $dataReportInfo['id_parent'] = $id_insert;

                            /* Insert data report info */
                            if ($d->insert($tableProductReportInfo, $dataReportInfo)) {
                                $successReport = true;
                            } else {
                                $successReport = false;
                            }
                        } else {
                            $successReport = false;
                        }
                    }
                } else {
                    $successReport = false;
                }
            } else {
                $successReport = false;
            }

            /* Destroy session captcha */
            unset($_SESSION["captcha"]["report"]);

            /* Flag report */
            if ($successReport == true) {
                /* Is ajax */
                if ($func->isAjax()) {
                    $resultAjax = array();
                    $resultAjax['status'] = 'success';
                    $resultAjax['message'] = 'Báo xấu tin đăng thành công. Chúng tôi sẽ xem xét trong thời gian sớm nhất.';
                    echo json_encode($resultAjax);
                    exit();
                } else {
                    $func->transfer("Báo xấu tin đăng thành công. Chúng tôi sẽ xem xét trong thời gian sớm nhất.", $configBase);
                }
            } else {
                /* Is ajax */
                if ($func->isAjax()) {
                    $resultAjax = array();
                    $resultAjax['status'] = 'error';
                    $resultAjax['message'] = 'Báo xấu tin đăng thất bại. Vui lòng thử lại sau.';
                    echo json_encode($resultAjax);
                    exit();
                } else {
                    $func->transfer("Báo xấu tin đăng thất bại. Vui lòng thử lại sau.", $func->getCurrentPageURL(), false);
                }
            }
        }

        /* Booking */
        if (!empty($_POST['submit-booking']) || ($func->isAjax() && !empty($_GET['isAjaxBooking']))) {
            if ($func->hasService($sector) && !empty($rowDetail['status_attr']) && strstr($rowDetail['status_attr'], 'dichvu')) {
                $codeCaptcha = $_POST['captcha-booking'];
                $sessionCaptcha = (!empty($_SESSION["captcha"]["booking"])) ? $_SESSION["captcha"]["booking"] : null;
                $responseCaptcha = $_POST['recaptcha_response_booking'];
                $resultCaptcha = $func->checkRecaptcha($responseCaptcha);
                $scoreCaptcha = (!empty($resultCaptcha['score'])) ? $resultCaptcha['score'] : 0;
                $actionCaptcha = (!empty($resultCaptcha['action'])) ? $resultCaptcha['action'] : '';
                $testCaptcha = (!empty($resultCaptcha['test'])) ? $resultCaptcha['test'] : false;
                $dataBooking = (!empty($_POST['dataBooking'])) ? $_POST['dataBooking'] : null;

                /* Valid data */
                $errors = array();
                if (empty($dataBooking['fullname'])) {
                    $errors[] = 'Họ tên không được trống';
                }

                if (empty($dataBooking['phone'])) {
                    $errors[] = 'Số điện thoại không được trống';
                }

                if (!empty($dataBooking['phone']) && !$func->isPhone($dataBooking['phone'])) {
                    $errors[] = 'Số điện thoại không hợp lệ';
                }

                if (empty($dataBooking['email'])) {
                    $errors[] = 'Email không được trống';
                }

                if (!empty($dataBooking['email']) && !$func->isEmail($dataBooking['email'])) {
                    $errors[] = 'Email không hợp lệ';
                }

                if (empty($dataBooking['address'])) {
                    $errors[] = 'Địa chỉ không được trống';
                }

                if (empty($dataBooking['content'])) {
                    $errors[] = 'Nội dung không được trống';
                }

                if (empty($codeCaptcha)) {
                    $errors[] = 'Mã bảo mật không được trống';
                }

                if (!empty($codeCaptcha) && !empty($sessionCaptcha) && $codeCaptcha != $sessionCaptcha) {
                    $errors[] = 'Mã bảo mật không chính xác';
                }

                if (!empty($errors)) {
                    $str = '<div class="text-left">';

                    foreach ($errors as $v_error) {
                        $str .= "- " . $v_error . "</br>";
                    }

                    $str .= "</div>";

                    /* Destroy session captcha */
                    unset($_SESSION["captcha"]["booking"]);

                    /* Is ajax */
                    if ($func->isAjax()) {
                        $resultAjax = array();
                        $resultAjax['status'] = 'error';
                        $resultAjax['message'] = $str;
                        echo json_encode($resultAjax);
                        exit();
                    } else {
                        $func->transfer($str, $func->getCurrentPageURL(), false);
                    }
                }

                if (($scoreCaptcha >= 0.5 && $actionCaptcha == 'Booking' && $codeCaptcha == $sessionCaptcha) || $testCaptcha == true) {
                    if (!empty($dataBooking)) {
                        /* Get info owner */
                        if (!empty($rowDetail['id_shop'])) {
                            $shopDetail = $cache->get("select id, id_member, id_admin, name, slug_url from #_$tableShop where id = ? limit 0,1", array($rowDetail['id_shop']), 'fetch', 7200);

                            if (!empty($shopDetail['id_member'])) {
                                $tableOwner = 'member';
                                $colIDOwner = 'id_member';
                                $IDOwner = $shopDetail['id_member'];
                            } else {
                                $tableOwner = 'user';
                                $colIDOwner = 'id_admin';
                                $IDOwner = $shopDetail['id_admin'];
                            }

                            /* Message email for shop */
                            /* Variables booking shop */
                            $shopBookingVars = array(
                                '{emailShopName}',
                                '{emailShopURL}'
                            );

                            /* Values booking shop */
                            $shopBookingVals = array(
                                $shopDetail['name'],
                                $configBaseShop . $shopDetail['slug_url']
                            );

                            /* Get shop Bookings */
                            $contentShop = str_replace($shopBookingVars, $shopBookingVals, $emailer->markdown('shop/booking'));
                        } else if (!empty($rowDetail['id_member']) || !empty($rowDetail['id_admin'])) {
                            if (!empty($rowDetail['id_member'])) {
                                $tableOwner = 'member';
                                $colIDOwner = 'id_member';
                                $IDOwner = $rowDetail['id_member'];
                            } else {
                                $tableOwner = 'user';
                                $colIDOwner = 'id_admin';
                                $IDOwner = $rowDetail['id_admin'];
                            }
                        }

                        /* Get owner */
                        if (!empty($tableOwner) && !empty($colIDOwner)) {
                            $rowDetailOwner = $cache->get("select fullname, email from #_$tableOwner where id = ? limit 0,1", array($IDOwner), 'fetch', 7200);
                        }

                        /* Check owner */
                        if (empty($tableOwner) || empty($colIDOwner) || empty($rowDetailOwner)) {
                            /* Is ajax */
                            if ($func->isAjax()) {
                                $resultAjax = array();
                                $resultAjax['status'] = 'error';
                                $resultAjax['message'] = 'Dữ liệu không hợp lệ. Vui lòng thử lại sau';
                                echo json_encode($resultAjax);
                                exit();
                            } else {
                                $func->transfer($str, $func->getCurrentPageURL(), false);
                            }
                        }

                        /* Data booking */
                        $data = array();
                        $data['fullname'] = htmlspecialchars($dataBooking['fullname']);
                        $data['phone'] = htmlspecialchars($dataBooking['phone']);
                        $data['email'] = htmlspecialchars($dataBooking['email']);
                        $data['address'] = htmlspecialchars($dataBooking['address']);
                        $data['content'] = htmlspecialchars($dataBooking['content']);
                        $data['date_created'] = time();
                        $data['type'] = 'dang-ky-hen';

                        /* Save data if this posting is in SHOP */
                        if (!empty($rowDetail['id_shop'])) {
                            /* ID for Shop */
                            $data['id_shop'] = $rowDetail['id_shop'];
                            $data['sector_prefix'] = $sector['prefix'];

                            /* Destroy session captcha */
                            unset($_SESSION["captcha"]["booking"]);

                            if (!$d->insert('newsletter', $data)) {
                                /* Is ajax */
                                if ($func->isAjax()) {
                                    $resultAjax = array();
                                    $resultAjax['status'] = 'error';
                                    $resultAjax['message'] = 'Đăng ký hẹn thất bại. Vui lòng thử lại sau.';
                                    echo json_encode($resultAjax);
                                    exit();
                                } else {
                                    $func->transfer("Đăng ký hẹn thất bại. Vui lòng thử lại sau.", $func->getCurrentPageURL(), false);
                                }
                            }
                        }

                        /* Gán giá trị gửi email */
                        $strThongtin = '';
                        $emailer->set('tennguoigui', $data['fullname']);
                        $emailer->set('emailnguoigui', $data['email']);
                        $emailer->set('dienthoainguoigui', $data['phone']);
                        $emailer->set('diachinguoigui', $data['address']);
                        $emailer->set('tieudelienhe', $rowDetail['name' . $lang]);
                        $emailer->set('noidunglienhe', $data['content']);
                        if ($emailer->get('tennguoigui')) {
                            $strThongtin .= '<span style="text-transform:capitalize">' . $emailer->get('tennguoigui') . '</span><br>';
                        }
                        if ($emailer->get('emailnguoigui')) {
                            $strThongtin .= '<a href="mailto:' . $emailer->get('emailnguoigui') . '" target="_blank">' . $emailer->get('emailnguoigui') . '</a><br>';
                        }
                        if ($emailer->get('diachinguoigui')) {
                            $strThongtin .= '' . $emailer->get('diachinguoigui') . '<br>';
                        }
                        if ($emailer->get('dienthoainguoigui')) {
                            $strThongtin .= 'Tel: ' . $emailer->get('dienthoainguoigui') . '';
                        }
                        $emailer->set('thongtin', $strThongtin);

                        /* Defaults attributes email */
                        $emailDefaultAttrs = $emailer->defaultAttrs();

                        /* Variables email */
                        $emailVars = array(
                            '{emailBookingInfo}',
                            '{emailBookingTitle}',
                            '{emailBookingContent}'
                        );
                        $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

                        /* Values email */
                        $emailVals = array(
                            $emailer->get('thongtin'),
                            $emailer->get('tieudelienhe'),
                            $emailer->get('noidunglienhe')
                        );
                        $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

                        /* Params email */
                        $emailParams = array();

                        if (!empty($rowDetail['id_shop'])) {
                            $emailParams['idShop'] = $rowDetail['id_shop'];
                            $emailParams['messageShop'] = $contentShop;
                        }

                        /* Send email for owner */
                        $arrayEmail = array(
                            "dataEmail" => array(
                                "name" => $rowDetailOwner['fullname'],
                                "email" => $rowDetailOwner['email']
                            )
                        );
                        $subject = "Thư đăng ký hẹn từ " . $setting['name' . $lang];
                        $message = str_replace($emailVars, $emailVals, $emailer->markdown('product/booking', $emailParams));
                        $file = null;

                        if ($emailer->send("customer", $arrayEmail, $subject, $message, $file)) {
                            /* Is ajax */
                            if ($func->isAjax()) {
                                $resultAjax = array();
                                $resultAjax['status'] = 'success';
                                $resultAjax['message'] = 'Đăng ký hẹn thành công.';
                                echo json_encode($resultAjax);
                                exit();
                            } else {
                                $func->transfer("Đăng ký hẹn thành công.", $func->getCurrentPageURL(), false);
                            }
                        } else {
                            /* Is ajax */
                            if ($func->isAjax()) {
                                $resultAjax = array();
                                $resultAjax['status'] = 'error';
                                $resultAjax['message'] = 'Đăng ký hẹn thất bại. Vui lòng thử lại sau.';
                                echo json_encode($resultAjax);
                                exit();
                            } else {
                                $func->transfer("Đăng ký hẹn thất bại. Vui lòng thử lại sau.", $func->getCurrentPageURL(), false);
                            }
                        }
                    } else {
                        /* Destroy session captcha */
                        unset($_SESSION["captcha"]["booking"]);

                        /* Is ajax */
                        if ($func->isAjax()) {
                            $resultAjax = array();
                            $resultAjax['status'] = 'error';
                            $resultAjax['message'] = 'Đăng ký hẹn thất bại. Vui lòng thử lại sau.';
                            echo json_encode($resultAjax);
                            exit();
                        } else {
                            $func->transfer("Đăng ký hẹn thất bại. Vui lòng thử lại sau.", $func->getCurrentPageURL(), false);
                        }
                    }
                } else {
                    /* Destroy session captcha */
                    unset($_SESSION["captcha"]["booking"]);

                    /* Is ajax */
                    if ($func->isAjax()) {
                        $resultAjax = array();
                        $resultAjax['status'] = 'error';
                        $resultAjax['message'] = 'Đăng ký hẹn thất bại. Vui lòng thử lại sau.';
                        echo json_encode($resultAjax);
                        exit();
                    } else {
                        $func->transfer("Đăng ký hẹn thất bại. Vui lòng thử lại sau.", $func->getCurrentPageURL(), false);
                    }
                }
            } else {
                /* Is ajax */
                if ($func->isAjax()) {
                    $resultAjax = array();
                    $resultAjax['status'] = 'error';
                    $resultAjax['message'] = 'Dữ liệu không hợp lệ. Vui lòng thử lại sau';
                    echo json_encode($resultAjax);
                    exit();
                } else {
                    $func->transfer('Dữ liệu không hợp lệ. Vui lòng thử lại sau', $func->getCurrentPageURL(), false);
                }
            }
        }

        /* Check owned */
        $rowDetail['isOwned'] = false;

        if (!empty($isLogin)) {
            /* Get shop owned */
            $ownedShop = array();

            if (!empty($tableShop)) {
                $ownedShop = $d->rawQueryOne("select id from #_$tableShop where id = ? and id_member = ? limit 0,1", array($rowDetail['id_shop'], $idMember));
            }

            if (($rowDetail['id_member'] == $idMember) || (!empty($ownedShop) && !empty($rowDetail['id_shop']) && $rowDetail['id_shop'] == $ownedShop['id'])) {
                $rowDetail['isOwned'] = true;
            }
        }

        /* Favourite */
        if (!empty($rowDetail['isOwned'])) {
            $func->set('favourite-active', 'text-secondary');
            $func->set('favourite-title', 'Tin đăng thuộc quyền sở hữu của bạn');
        } else if (!empty($favourites) && in_array($rowDetail['id'], $favourites)) {
            $func->set('favourite-active', 'active');
            $func->set('favourite-title', 'Bỏ quan tâm (' . $rowDetail['name' . $lang] . ')');
        } else {
            $func->set('favourite-active', '');
            $func->set('favourite-title', 'Quan tâm (' . $rowDetail['name' . $lang] . ')');
        }

        /* Sector cat detail */
        $sectorCatDetail = $cache->get("select name$lang from #_product_cat where id = ? and find_in_set('hienthi',status) limit 0,1", array($rowDetail['id_cat']), 'fetch', 7200);

        /* Insert data into product Detail */
        $rowDetail['sectorCatDetail'] = $sectorCatDetail;

        /* Sector item detail */
        $sectorItemDetail = $cache->get("select name$lang from #_product_item where id = ? and find_in_set('hienthi',status) limit 0,1", array($rowDetail['id_item']), 'fetch', 7200);

        /* Insert data into product Detail */
        $rowDetail['sectorItemDetail'] = $sectorItemDetail;

        /* Labels detail */
        if (in_array($sector['type'], array($config['website']['sectors']))) {
            $func->set('content-label', 'Thông tin mô tả');
        } else if (in_array($sector['type'], array('nha-tuyen-dung'))) {
            $func->set('content-label', 'Mô tả công việc');
        } else if (in_array($sector['type'], array('ung-vien'))) {
            $func->set('content-label', 'Giới thiệu về bản thân');
        }

        /* Places */
        $placeLabel = '';

        if (!empty($rowDetail['id_district'])) {
            $districtDetail = $cache->get("select name from #_district where id = ? and find_in_set('hienthi',status) limit 0,1", array($rowDetail['id_district']), 'fetch', 7200);

            /* Insert data into product Detail */
            $rowDetail['districtDetail'] = $districtDetail;

            $placeLabel .= (!empty($districtDetail['name'])) ? $func->textConvert($districtDetail['name'], 'capitalize') . ', ' : '';
        }

        if (!empty($rowDetail['id_city'])) {
            $cityDetail = $cache->get("select name from #_city where id = ? and find_in_set('hienthi',status) limit 0,1", array($rowDetail['id_city']), 'fetch', 7200);

            /* Insert data into product Detail */
            $rowDetail['cityDetail'] = $cityDetail;

            $placeLabel .= (!empty($cityDetail['name'])) ? $func->textConvert($cityDetail['name'], 'capitalize') . ', ' : '';
        }

        $func->set('place-label', (!empty($placeLabel)) ? trim($placeLabel, ', ') : '');

        /* Content */
        $rowDetailContent = $cache->get("select content$lang from #_$tableProductContent where id_parent = ? limit 0,1", array($rowDetail['id']), 'fetch', 7200);

        /* Insert data into product Detail */
        $rowDetail['rowDetailContent'] = $rowDetailContent;

        /* Info */
        if (in_array($sector['type'], array('nha-tuyen-dung'))) {
            $rowDetailInfo = $cache->get("select fullname, application_deadline, age_requirement, trial_period, employee_quantity, gender, address, phone, email, 	introduce from #_$tableProductInfo where id_parent = ? limit 0,1", array($rowDetail['id']), 'fetch', 7200);
        } else if (in_array($sector['type'], array('ung-vien'))) {
            $rowDetailInfo = $cache->get("select first_name, last_name, birthday, gender, address, phone, email from #_$tableProductInfo where id_parent = ? limit 0,1", array($rowDetail['id']), 'fetch', 7200);
        }

        /* Insert data into product Detail */
        $rowDetail['rowDetailInfo'] = (!empty($rowDetailInfo)) ? $rowDetailInfo : array();

        /* Video */
        $rowDetailVideo = $cache->get("select photo, video, name$lang, type from #_$tableProductVideo where id_parent = ? and name$lang != '' and video != ''", array($rowDetail['id']), 'fetch', 7200);

        /* Insert data into product Detail */
        $rowDetail['rowDetailVideo'] = $rowDetailVideo;

        /* Photo */
        if (in_array($sector['type'], array($config['website']['sectors']))) {
            $rowDetailPhoto = $cache->get("select id, photo, name$lang from #_$tableProductPhoto where id_parent = ?", array($rowDetail['id']), 'result', 7200);

            /* Insert data into product Detail */
            $rowDetail['rowDetailPhoto'] = $rowDetailPhoto;
        }

        /* Tags */
        $IDTags = $cache->get("select id_tag from #_$tableProductTag where id_parent = ?", array($rowDetail['id']), 'result', 7200);

        if (!empty($IDTags)) {
            $IDTags = $func->joinCols($IDTags, 'id_tag');
            $rowDetailTags = $cache->get("select id, name$lang, slugvi, slugen from #_product_tags where id_list = ? and id in ($IDTags) and find_in_set('hienthi',status) order by numb,id desc", array($sector['id']), 'result', 7200);

            /* Insert data into product Detail */
            $rowDetail['rowDetailTags'] = $rowDetailTags;
        }

        /* Sale */
        if ($func->hasCart($sector) && !strstr($rowDetail['status_attr'], 'dichvu')) {
            $rowDetailSale = $cache->get("select id, id_color, id_size from #_$tableProductSale where id_parent = ?", array($rowDetail['id']), 'result', 7200);

            /* Join data */
            $IDColors = (!empty($rowDetailSale)) ? $func->joinCols($rowDetailSale, 'id_color') : '';
            $IDSizes = (!empty($rowDetailSale)) ? $func->joinCols($rowDetailSale, 'id_size') : '';

            /* Get colors */
            if (!empty($IDColors)) {
                $colors = $cache->get("select id, namevi from #_product_color where id in ($IDColors) and find_in_set('hienthi',status) order by numb,id desc", null, 'result', 7200);
            }

            /* Get sizes */
            if (!empty($IDSizes)) {
                $sizes = $cache->get("select id, namevi from #_product_size where id_list = ? and id in ($IDSizes) and find_in_set('hienthi',status) order by numb,id desc", array($sector['id']), 'result', 7200);
            }

            /* Insert data into product Detail */
            $rowDetail['rowDetailSale']['colors'] = (!empty($colors)) ? $colors : array();
            $rowDetail['rowDetailSale']['sizes'] = (!empty($sizes)) ? $sizes : array();
        }

        /* Poster */
        if (!empty($rowDetail['id_shop'])) {
            $shopDetail = $cache->get("select A.id as id, A.id_member as id_member, A.id_admin as id_admin, A.id_interface as id_interface, A.name as name, A.slug_url as slug_url, A.phone as phone, A.email as email, B.name as nameCity, C.name as nameDistrict, D.name as nameWard, S.quantity as subscribeNumb, P.photo as logo from #_$tableShop as A inner join #_city as B inner join #_district as C inner join #_wards as D left join #_$tableShopSubscribe as S on A.id = S.id_shop left join #_photo as P on A.id = P.id_shop and P.sector_prefix = ? and P.type = 'logo' where A.id = ? and A.id_city = B.id and A.id_district = C.id and A.id_wards = D.id limit 0,1", array($sector['prefix'], $rowDetail['id_shop']), 'fetch', 7200);

            /* Get info of Shop */
            $sampleData = $cache->get("select logo from #_sample where id_interface = ?", array($shopDetail['id_interface']), 'fetch', 7200);

            /* Logo shop or sample data */
            if (empty($shopDetail['logo'])) {
                $shopDetail['logo'] = $sampleData['logo'];
            }

            /* Member subscribe */
            if (!empty($isLogin)) {
                $subscribeMember = $d->rawQueryOne("select id from #_member_subscribe where id_member = ? and id_shop = ? and sector_prefix = ? limit 0,1", array($idMember, $shopDetail['id'], $sector['prefix']));
                $shopDetail['subscribeActive'] = (!empty($subscribeMember)) ? 'active' : '';
            } else {
                $shopDetail['subscribeActive'] = '';
            }

            /* Href shop */
            $shopDetail['href'] = $configBaseShop . $shopDetail['slug_url'] . '/';

            /* Insert data into product Detail */
            $rowDetail['rowDetailShop'] = $shopDetail;
        } else if (!empty($rowDetail['id_member']) || !empty($rowDetail['id_admin'])) {
            if (!empty($rowDetail['id_member'])) {
                $tablePoster = 'member';
                $colIDPoster = 'id_member';

                /* Contact */
                $rowDetailContact = $cache->get("select fullname, phone, address, email from #_$tableProductContact where id_parent = ?", array($rowDetail['id']), 'fetch', 7200);

                /* Insert data into product Detail */
                $rowDetail['rowDetailContact'] = $rowDetailContact;
            } else if (!empty($rowDetail['id_admin'])) {
                $tablePoster = 'user';
                $colIDPoster = 'id_admin';
            }

            $rowDetailPoster = $cache->get("select fullname, address, phone, email, avatar from #_$tablePoster where id = ? limit 0,1", array($rowDetail[$colIDPoster]), 'fetch', 7200);

            /* Insert data into product Detail */
            $rowDetail['rowDetailPoster'] = $rowDetailPoster;
        }

        /* GET DATA OWNER SIMILAR, SEEN, SIMILAR BY PRODUCT OR VIDEO */
        if (!empty($IDVideo)) {
            /* VIDEO OWNER SIMILAR */
            /* Params video owner similar */
            $paramsProductOwnerSimilar = array($sector['id'], $IDVideo, 'xetduyet');

            /* Where logic when owner or shop unactive */
            $whereVideoOwnerSimilar = $whereLogicOwner['where'];

            if (in_array($sector['type'], array($config['website']['sectors']))) {
                /* Where videos by Shop or Member or Admin */
                if (!empty($rowDetail['id_shop'])) {
                    $whereVideoOwnerSimilar .= " and A.id_shop = ?";
                    array_push($paramsProductOwnerSimilar, $rowDetail['id_shop']);
                } else if (!empty($rowDetail['id_member'])) {
                    $whereVideoOwnerSimilar .= " and A.id_member = ?";
                    array_push($paramsProductOwnerSimilar, $rowDetail['id_member']);
                } else if (!empty($rowDetail['id_admin'])) {
                    $whereVideoOwnerSimilar .= " and A.id_admin = ?";
                    array_push($paramsProductOwnerSimilar, $rowDetail['id_admin']);
                }

                /* Where logic when shop unactive */
                $whereVideoOwnerSimilar .= $func->getLogicShop($tableShop, $whereLogicOwner);
            } else if (in_array($sector['type'], array('ung-vien', 'nha-tuyen-dung'))) {
                $whereVideoOwnerSimilar .= " and A.status_user = 'hienthi'";

                /* Where videos by Member or Admin */
                if (!empty($rowDetail['id_member'])) {
                    $whereVideoOwnerSimilar .= " and A.id_member = ?";
                    array_push($paramsProductOwnerSimilar, $rowDetail['id_member']);
                } else if (!empty($rowDetail['id_admin'])) {
                    $whereVideoOwnerSimilar .= " and A.id_admin = ?";
                    array_push($paramsProductOwnerSimilar, $rowDetail['id_admin']);
                }
            }

            /* SQL video owner similar */
            $sqlVideoOwnerSimilar = "select A.id as id, A.slugvi as slugvi, A.slugen as slugen, A.date_created as date_created, B.id as videoId, B.name$lang as videoName$lang, B.photo as videoPhoto, B.views as videoViews from #_$tableProductMain as A inner join #_$tableProductVideo as B where A.id = B.id_parent and A.id_list = ? and B.id != ? and A.status = ? $whereVideoOwnerSimilar order by A.date_created desc limit 0,30";

            /* Get data videos owner similar */
            $videoOwnerSimilar = $cache->get($sqlVideoOwnerSimilar, $paramsProductOwnerSimilar, 'result', 7200);

            /* VIDEO SEEN */
            $func->setSeen($sector['id'], $IDVideo, 'video');
            $IDVideoSeen = $func->getSeen($sector['id'], $IDVideo, 'video');
            if (!empty($IDVideoSeen)) {
                $whereVideoSeen = " and A.status = ? and B.id_parent = A.id and B.name$lang != '' and B.video != '' and A.id_city = C.id and A.id_district = D.id";

                /* Where logic when owner or shop unactive */
                $whereVideoSeen .= $whereLogicOwner['where'];

                if (in_array($sector['type'], array($config['website']['sectors']))) {
                    /* Where logic when shop unactive */
                    $whereVideoSeen .= $func->getLogicShop($tableShop, $whereLogicOwner);

                    /* SQL video */
                    $sqlVideoSeen = "select A.id as id, A.id_shop as id_shop, A.id_member as id_member, A.id_admin as id_admin, A.slugvi as slugvi, A.slugen as slugen, A.date_created as date_created, B.id as videoId, B.name$lang as videoName$lang, B.photo as videoPhoto, B.video as videoData, B.type as videoType, C.name as name_city, D.name as name_district, S.id_interface as shopInterface, S.name as shopName, S.slug_url as shopUrl, P.photo as shopLogo, M.avatar as memberAvatar, M.fullname as memberFullname, U.avatar as adminAvatar, U.fullname as adminFullname from #_$tableProductMain as A inner join #_$tableProductVideo as B inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where A.id_list = ? and B.id in ($IDVideoSeen) $whereVideoSeen order by A.date_created desc limit 0,30";
                } else if (in_array($sector['type'], array('ung-vien', 'nha-tuyen-dung'))) {
                    /* SQL video */
                    $sqlVideoSeen = "select A.id as id, A.id_member as id_member, A.id_admin as id_admin, A.slugvi as slugvi, A.slugen as slugen, A.date_created as date_created, B.id as videoId, B.name$lang as videoName$lang, B.photo as videoPhoto, B.video as videoData, B.type as videoType, C.name as name_city, D.name as name_district, M.avatar as memberAvatar, M.fullname as memberFullname, U.avatar as adminAvatar, U.fullname as adminFullname from #_$tableProductMain as A inner join #_$tableProductVideo as B inner join #_city as C inner join #_district as D left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where A.id_list = ? and B.id in ($IDVideoSeen) and A.status_user = 'hienthi' $whereVideoSeen order by A.date_created desc limit 0,30";
                }

                /* Get data videos seen */
                $paramsVideoSeen = array($sector['id'], 'xetduyet');
                $videoSeen = $cache->get($sqlVideoSeen, $paramsVideoSeen, 'result', 7200);
            }

            /* VIDEO SIMILAR */
            $whereVideoSimilar = " and A.status = ? and A.id = B.id_parent and B.name$lang != '' and B.video != '' and A.id_city = C.id and A.id_district = D.id";

            /* Where logic when owner or shop unactive */
            $whereVideoSimilar .= $whereLogicOwner['where'];

            if (in_array($sector['type'], array($config['website']['sectors']))) {
                /* Where logic when shop unactive */
                $whereVideoSimilar .= $func->getLogicShop($tableShop, $whereLogicOwner);

                /* SQL video */
                $sqlVideoSimilar = "select A.id as id, A.id_shop as id_shop, A.id_member as id_member, A.id_admin as id_admin, A.slugvi as slugvi, A.slugen as slugen, A.date_created as date_created, B.id as videoId, B.name$lang as videoName$lang, B.photo as videoPhoto, B.video as videoData, B.type as videoType, C.name as name_city, D.name as name_district, S.id_interface as shopInterface, S.name as shopName, S.slug_url as shopUrl, P.photo as shopLogo, M.avatar as memberAvatar, M.fullname as memberFullname, U.avatar as adminAvatar, U.fullname as adminFullname from #_$tableProductMain as A inner join #_$tableProductVideo as B inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where A.id_list = ? and A.id_cat = ? and A.id_item = ? and A.id_sub = ? and A.id != ? $whereVideoSimilar order by A.date_created desc limit 0,30";
            } else if (in_array($sector['type'], array('ung-vien', 'nha-tuyen-dung'))) {
                /* SQL video */
                $sqlVideoSimilar = "select A.id as id, A.id_member as id_member, A.id_admin as id_admin, A.slugvi as slugvi, A.slugen as slugen, A.date_created as date_created, B.id as videoId, B.name$lang as videoName$lang, B.photo as videoPhoto, B.video as videoData, B.type as videoType, C.name as name_city, D.name as name_district, M.avatar as memberAvatar, M.fullname as memberFullname, U.avatar as adminAvatar, U.fullname as adminFullname from #_$tableProductMain as A inner join #_$tableProductVideo as B inner join #_city as C inner join #_district as D left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where A.id_list = ? and A.id_cat = ? and A.id_item = ? and A.id_sub = ? and A.id != ? and A.status_user = 'hienthi' $whereVideoSimilar order by A.date_created desc limit 0,30";
            }

            /* Get data videos similar */
            $paramsVideoSimilar = array($sector['id'], $rowDetail['id_cat'], $rowDetail['id_item'], $rowDetail['id_sub'], $rowDetail['id'], 'xetduyet');
            $videoSimilar = $cache->get($sqlVideoSimilar, $paramsVideoSimilar, 'result', 7200);
        } else {
            /* PRODUCT OWNER SIMILAR */
            /* Params product owner similar */
            $paramsProductOwnerSimilar = array($sector['id'], $rowDetail['id'], 'xetduyet');

            /* Where logic when owner or shop unactive */
            $whereProductOwnerSimilar = $whereLogicOwner['where'];

            /* Get product owner similar */
            if (in_array($sector['type'], array($config['website']['sectors']))) {
                /* Where products by Shop or Member or Admin */
                if (!empty($rowDetail['id_shop'])) {
                    $whereProductOwnerSimilar .= " and A.id_shop = ?";
                    array_push($paramsProductOwnerSimilar, $rowDetail['id_shop']);
                } else if (!empty($rowDetail['id_member'])) {
                    $whereProductOwnerSimilar .= " and A.id_member = ?";
                    array_push($paramsProductOwnerSimilar, $rowDetail['id_member']);
                } else if (!empty($rowDetail['id_admin'])) {
                    $whereProductOwnerSimilar .= " and A.id_admin = ?";
                    array_push($paramsProductOwnerSimilar, $rowDetail['id_admin']);
                }

                /* Where logic when shop unactive */
                $whereProductOwnerSimilar .= $func->getLogicShop($tableShop, $whereLogicOwner);
            } else if (in_array($sector['type'], array('ung-vien', 'nha-tuyen-dung'))) {
                $whereProductOwnerSimilar .= " and A.status_user = 'hienthi'";

                /* Where products by Member or Admin */
                if (!empty($rowDetail['id_member'])) {
                    $whereProductOwnerSimilar .= " and A.id_member = ?";
                    array_push($paramsProductOwnerSimilar, $rowDetail['id_member']);
                } else if (!empty($rowDetail['id_admin'])) {
                    $whereProductOwnerSimilar .= " and A.id_admin = ?";
                    array_push($paramsProductOwnerSimilar, $rowDetail['id_admin']);
                }
            }

            /* SQL products owner similar */
            $sqlProductOwnerSimilar = "select A.id as id, A.name$lang as name$lang,A.desc$lang as desc$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, A.views as views from #_$tableProductMain as A where A.id_list = ? and A.id != ? and A.status = ? $whereProductOwnerSimilar order by A.views desc, A.date_created desc limit 0,30";

            /* Get data products owner similar */
            $productOwnerSimilar = $cache->get($sqlProductOwnerSimilar, $paramsProductOwnerSimilar, 'result', 7200);

            /* PRODUCT SEEN */
            $func->setSeen($sector['id'], $rowDetail['id'], 'product');
            $IDProductSeen = $func->getSeen($sector['id'], $rowDetail['id'], 'product');
            if (!empty($IDProductSeen)) {
                /* Where logic when owner or shop unactive */
                $whereProductSeen = $whereLogicOwner['where'];

                if (in_array($sector['type'], array($config['website']['sectors']))) {
                    /* Where products seen */
                    $whereProductSeen .= " and A.id_city = C.id and A.id_district = D.id";

                    /* Where logic when shop unactive */
                    $whereProductSeen .= $func->getLogicShop($tableShop, $whereLogicOwner);

                    /* SQL products seen */
                    $sqlProductSeen = "select A.id as id, A.id_shop as id_shop, A.id_member as id_member, A.id_admin as id_admin, A.name$lang as name$lang,A.desc$lang as desc$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, C.name as name_city, D.name as name_district, S.id_interface as shopInterface, S.name as shopName, S.slug_url as shopUrl, P.photo as shopLogo, M.avatar as memberAvatar, M.fullname as memberFullname, U.avatar as adminAvatar, U.fullname as adminFullname from #_$tableProductMain as A inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where A.id_list = ? and A.id in ($IDProductSeen) and A.status = ? $whereProductSeen order by A.date_created desc limit 0,30";
                } else if (in_array($sector['type'], array('ung-vien'))) {
                    /* Where products seen */
                    $whereProductSeen .= " and A.status_user = 'hienthi' and A.id = B.id_parent and A.id_city = C.id and A.id_district = D.id";

                    /* SQL products seen */
                    $sqlProductSeen = "select A.id as id, A.id_member as id_member, A.name$lang as name$lang,A.desc$lang as desc$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, B.first_name as first_name, B.last_name as last_name, C.name as name_city, D.name as name_district from #_$tableProductMain as A, #_$tableProductInfo as B, #_city as C, #_district as D where A.id_list = ? and A.id in ($IDProductSeen) and A.status = ? $whereProductSeen order by A.date_created desc limit 0,30";
                } else if (in_array($sector['type'], array('nha-tuyen-dung'))) {
                    /* Where products seen */
                    $whereProductSeen .= " and A.status_user = 'hienthi' and A.id = B.id_parent and A.id_city = C.id and A.id_district = D.id";

                    /* SQL products seen */
                    $sqlProductSeen = "select A.id as id, A.id_member as id_member, A.name$lang as name$lang,A.desc$lang as desc$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, B.fullname as fullname, B.employee_quantity as employee_quantity, C.name as name_city, D.name as name_district from #_$tableProductMain as A, #_$tableProductInfo as B, #_city as C, #_district as D where A.id_list = ? and A.id in ($IDProductSeen) and A.status = ? $whereProductSeen order by A.date_created desc limit 0,30";
                }

                /* Get data products seen */
                $paramsProductSeen = array($sector['id'], 'xetduyet');
                $productSeen = $cache->get($sqlProductSeen, $paramsProductSeen, 'result', 7200);
            }

            /* PRODUCT SIMILAR */
            /* Where logic when owner or shop unactive */
            $whereProductSimilar = $whereLogicOwner['where'];

            /* Get product similar */
            if (in_array($sector['type'], array($config['website']['sectors']))) {
                /* Where products similar */
                $whereProductSimilar .= " and A.id_city = C.id and A.id_district = D.id";

                /* Where logic when shop unactive */
                $whereProductSimilar .= $func->getLogicShop($tableShop, $whereLogicOwner);

                /* SQL products similar */
                $sqlProductSimilar = "select A.id as id, A.id_shop as id_shop, A.id_member as id_member, A.id_admin as id_admin, A.name$lang as name$lang,A.desc$lang as desc$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, C.name as name_city, D.name as name_district, S.id_interface as shopInterface, S.name as shopName, S.slug_url as shopUrl, P.photo as shopLogo, M.avatar as memberAvatar, M.fullname as memberFullname, U.avatar as adminAvatar, U.fullname as adminFullname from #_$tableProductMain as A inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where A.id_list = ? and A.id_cat = ? and A.id_item = ? and A.id_sub = ? and A.id != ? and A.status = ? $whereProductSimilar order by A.date_created desc limit 0,30";
            } else if (in_array($sector['type'], array('ung-vien'))) {
                /* Where product similar */
                $whereProductSimilar .= " and A.status_user = 'hienthi' and A.id = B.id_parent and A.id_city = C.id and A.id_district = D.id";

                /* SQL products similar */
                $sqlProductSimilar = "select A.id as id, A.id_member as id_member, A.name$lang as name$lang,A.desc$lang as desc$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, B.first_name as first_name, B.last_name as last_name, C.name as name_city, D.name as name_district from #_$tableProductMain as A, #_$tableProductInfo as B, #_city as C, #_district as D where A.id_list = ? and A.id_cat = ? and A.id_item = ? and A.id_sub = ? and A.id != ? and A.status = ? $whereProductSimilar order by A.date_created desc limit 0,30";
            } else if (in_array($sector['type'], array('nha-tuyen-dung'))) {
                /* Where product similar */
                $whereProductSimilar .= " and A.status_user = 'hienthi' and A.id = B.id_parent and A.id_city = C.id and A.id_district = D.id";

                /* SQL main similar */
                $sqlProductSimilar = "select A.id as id, A.id_member as id_member, A.name$lang as name$lang,A.desc$lang as desc$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, B.fullname as fullname, B.employee_quantity as employee_quantity, C.name as name_city, D.name as name_district from #_$tableProductMain as A, #_$tableProductInfo as B, #_city as C, #_district as D where A.id_list = ? and A.id_cat = ? and A.id_item = ? and A.id_sub = ? and A.id != ? and A.status = ? $whereProductSimilar order by A.date_created desc limit 0,30";
            }

            /* Get data products similar */
            $paramsProductSimilar = array($sector['id'], $rowDetail['id_cat'], $rowDetail['id_item'], $rowDetail['id_sub'], $rowDetail['id'], 'xetduyet');
            $productSimilar = $cache->get($sqlProductSimilar, $paramsProductSimilar, 'result', 7200);
        }

        /* Init data detail for SEO */
        $dataDetail = (!empty($videoDetail)) ? $videoDetail : $rowDetail;
        $dataDetail['upload'] = (!empty($videoDetail)) ? UPLOAD_PHOTO_L : UPLOAD_PRODUCT_L;
        $dataDetail['table'] = (!empty($videoDetail)) ? $tableProductVideo : $tableProductMain;

    }
}


/* SEO */
$seoDB = $seo->getOnDB('*', 'setting_seo', $setting['id']);
if (!empty($seoDB['title' . $seolang])) $seo->set('h1', $seoDB['title' . $seolang]);
if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
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
