<?php
if (!defined('SOURCES')) die("Error");

/* Data */
$title_crumb = "Đăng ký gian hàng";
$IDSector = (!empty($_GET['sector'])) ? $_GET['sector'] : 0;
$backSuccessShop = (!empty($_GET['backSuccessShop'])) ? $_GET['backSuccessShop'] : '';
$isLogin = $func->getMember('active');
$idMember = $func->getMember('id');

/* Check login */
if (empty($isLogin)) {
    if ($func->isAjax() && !empty($_GET['isAjaxShop'])) {
        /* Is ajax */
        $resultAjax = array();
        $resultAjax['status'] = 'error';
        $resultAjax['message'] = 'Vui lòng đăng nhập để đăng ký gian hàng';
        echo json_encode($resultAjax);
        exit();
    } else {
        $urlLogin = $configBase . 'account/dang-nhap';
        $urlCreateShop = $urlLogin . '?back=' . $configBase . 'dang-ky-gian-hang?sector=' . $IDSector;
        $urlCreateShop .= !empty($backSuccessShop) ? '&backSuccessShop=' . $backSuccessShop : '';
        $urlRedirect = (!empty($IDSector)) ? $urlCreateShop : $urlLogin;
        $func->redirect($urlRedirect);
    }
}

/* Sector detail */
if (!empty($IDSector)) {
    $sectorDetail = $cache->get("select type, id from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

    /* Check sector */
    if (!empty($sectorDetail) && $func->hasShop($sectorDetail)) {
        /* Sector list */
        $sector = $defineSectors['types'][$sectorDetail['type']];
        $title_crumb .= ' - ' . $sector['name'];
        $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';

        /* Get interface category */
        $interfaceCategory = $d->rawQuery("select id_interface from #_interface_category where id_list = ?", array($sector['id']));
        $interfacesID = array();

        if (!empty($interfaceCategory)) {
            foreach ($interfaceCategory as $v) {
                $interfacesID[] = $v['id_interface'];
            }
        }

        /* Get interfaces */
        $interfaces = $cache->get("select id, name$lang, desc$lang, photo, photo2 from #_interface", null, 'result', 7200);

        /* Get sector cat */
        $sectorCats = $cache->get("select name$lang, id from #_product_cat where id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array($sector['id']), 'result', 7200);

        /* City */
        $city = $cache->get("select name, id from #_city where find_in_set('hienthi',status) order by numb,id asc", null, 'result', 7200);

        /* Tìm hiểu gian hàng */
        $learnShop = $cache->get("select B.content$lang as content$lang from #_static as A, #_static_content as B where A.id = B.id_parent and A.type = ? and find_in_set('hienthi',A.status)", array('tim-hieu-gian-hang'), 'fetch', 7200);

        /* Hoàn tất gian hàng */
        $completeShop = $cache->get("select B.content$lang as content$lang from #_static as A, #_static_content as B where A.id = B.id_parent and A.type = ? and find_in_set('hienthi',A.status)", array('hoan-tat-gian-hang'), 'fetch', 7200);

        /* Save data */
        if (!empty($_POST['submit-shop']) || ($func->isAjax() && !empty($_GET['isAjaxShop']))) {
            /* Post data */
            $message = '';
            $response = array();
            $codeCaptcha = $_POST['captcha-shop'];
            $sessionCaptcha = (!empty($_SESSION["captcha"]["shop"])) ? $_SESSION["captcha"]["shop"] : null;
            $dataShop = (!empty($_POST['dataShop'])) ? $_POST['dataShop'] : null;

            if ($dataShop) {
                $dataShop['id_member'] = $idMember;
                $dataShop['id_list'] = $sector['id'];
                $regionInfo = (!empty($dataShop['id_city'])) ? $func->getInfoDetail('id_region', 'city', $dataShop['id_city']) : 0;
                $dataShop['id_region'] = (!empty($regionInfo)) ? $regionInfo['id_region'] : 0;

                foreach ($dataShop as $column => $value) {
                    $dataShop[$column] = htmlspecialchars($func->sanitize($value));
                }

                if (!empty($dataShop['name'])) {
                    $dataShop['slug'] = (!empty($dataShop['name'])) ? $func->changeTitle($dataShop['name']) : '';
                    $dataShop['slug_url'] = (!empty($dataShop['slug'])) ? str_replace("-", "", $dataShop['slug']) : '';
                }

                if (!empty($dataShop['slug_url'])) {
                    $dataShop['folder'] = date("Y", time()) . "-" . $dataShop['slug_url'];
                    $folderShop = $dataShop['folder'];
                }

                $dataShop['status'] = '';
                $dataShop['status_user'] = 'hienthi';
                $dataShop['date_created'] = time();
            }

            /* Valid data */
            if (empty($dataShop['name'])) {
                $response['messages'][] = 'Tên gian hàng không được trống';
            }

            if (!empty($dataShop['slug'])) {
                if ($func->checkShop($dataShop, 'name')) {
                    $response['messages'][] = 'Tên gian hàng đã tồn tại';
                }

                if ($func->checkShop($dataShop, 'restricted')) {
                    $response['messages'][] = 'Tên gian hàng không hợp lệ';
                }
            }

            if (!empty($dataShop['name']) && mb_strlen($dataShop['name'], 'utf8') > 50) {
                $response['messages'][] = 'Tên gian hàng không được vượt quá 50 ký tự';
            }

            if (empty($dataShop['email'])) {
                $response['messages'][] = 'Email không được trống';
            }

            if (!empty($dataShop['email']) && !$func->isEmail($dataShop['email'])) {
                $response['messages'][] = 'Email không hợp lệ';
            }

            if (!empty($dataShop['email'])) {
                if ($func->checkShop($dataShop, 'email')) {
                    $response['messages'][] = 'Email đã tồn tại';
                }
            }

            if (empty($dataShop['password'])) {
                $response['messages'][] = 'Mật khẩu không được trống';
            }

            if (empty($dataShop['phone'])) {
                $response['messages'][] = 'Số điện thoại không được trống';
            }

            if (!empty($dataShop['phone']) && !$func->isPhone($dataShop['phone'])) {
                $response['messages'][] = 'Số điện thoại không hợp lệ';
            }

            if (empty($dataShop['id_cat'])) {
                $response['messages'][] = 'Chưa chọn danh mục ngành nghề';
            }

            if (empty($dataShop['id_interface'])) {
                $response['messages'][] = 'Chưa chọn giao diện gian hàng';
            }

            if (!empty($dataShop['id_interface']) && !empty($interfacesID) && !in_array($dataShop['id_interface'], $interfacesID)) {
                $response['messages'][] = 'Giao diện gian hàng không phù hợp';
            }

            if (empty($dataShop['id_store'])) {
                $response['messages'][] = 'Chưa chọn cửa hàng';
            }

            if (empty($dataShop['id_region'])) {
                $response['messages'][] = 'Chưa chọn vùng/miền';
            }

            if (empty($dataShop['id_city'])) {
                $response['messages'][] = 'Chưa chọn tỉnh/thành phố';
            }

            if (empty($dataShop['id_district'])) {
                $response['messages'][] = 'Chưa chọn quận/huyện';
            }

            if (empty($dataShop['id_wards'])) {
                $response['messages'][] = 'Chưa chọn phường/xã';
            }

            if (!$func->hasFile('file_shop')) {
                $response['messages'][] = 'Hình đại diện không được trống';
            }

            if (empty($codeCaptcha)) {
                $response['messages'][] = 'Mã bảo mật không được trống';
            }

            if (!empty($codeCaptcha) && !empty($sessionCaptcha) && $codeCaptcha != $sessionCaptcha) {
                $response['messages'][] = 'Mã bảo mật không chính xác';
            }

            if (!empty($response)) {
                /* Destroy session captcha */
                unset($_SESSION["captcha"]["shop"]);

                /* Is ajax */
                if ($func->isAjax()) {
                    $str = '<div class="text-left">';

                    foreach ($response['messages'] as $v_error) {
                        $str .= "- " . $v_error . "</br>";
                    }

                    $str .= "</div>";

                    $resultAjax = array();
                    $resultAjax['status'] = 'error';
                    $resultAjax['message'] = $str;
                    echo json_encode($resultAjax);
                    exit();
                } else {
                    $response['status'] = 'danger';
                    $message = base64_encode(json_encode($response));
                    $flash->set('message', $message);
                    $func->redirect("dang-ky-gian-hang?sector=" . $sector['id'] . '&backSuccessShop=' . $backSuccessShop);
                }
            }

            /* Import data */
            if ($d->insert($sector['tables']['shop'], $dataShop)) {
                $id_insert = $d->getLastInsertId();

                /* Avatar */
                if (!empty($_FILES["file_shop"])) {
                    $photoShop = array();
                    $file_name = $func->uploadName($_FILES["file_shop"]["name"]);
                    if ($file = $func->uploadImage("file_shop", '.jpg|.png|.gif|.JPG|.PNG|.GIF', UPLOAD_SHOP_L, $file_name)) {
                        $photoShop['photo'] = $file;
                        $d->where('id', $id_insert);
                        $d->update($sector['tables']['shop'], $photoShop);
                        unset($photoShop);
                    }
                }

                /* Create folder for Shop */
                if (!empty($folderShop)) {
                    $folderFileManager = UPLOAD_FILEMANAGER_L . $folderShop;
                    if (!file_exists($folderFileManager)) {
                        mkdir($folderFileManager, 0777, true);
                        chmod($folderFileManager, 0777);
                    }
                }

                /* Destroy session captcha */
                unset($_SESSION["captcha"]["shop"]);

                /* Is ajax */
                if ($func->isAjax()) {
                    $resultAjax = array();
                    $resultAjax['status'] = 'success';
                    echo json_encode($resultAjax);
                    exit();
                } else {
                    /* Redirect */
                    $func->redirect("dang-ky-gian-hang?sector=" . $sector['id'] . '&backSuccessShop=' . $backSuccessShop);
                }
            } else {
                /* Destroy session captcha */
                unset($_SESSION["captcha"]["shop"]);

                /* Is ajax */
                if ($func->isAjax()) {
                    $resultAjax = array();
                    $resultAjax['status'] = 'error';
                    $resultAjax['message'] = 'Đăng ký gian hàng thất bại. Vui lòng thử lại sau.';
                    echo json_encode($resultAjax);
                    exit();
                } else {
                    /* Redirect */
                    $func->transfer("Đăng ký gian hàng thất bại. Vui lòng thử lại sau.", "dang-ky-gian-hang?sector=" . $sector['id'] . '&backSuccessShop=' . $backSuccessShop, false);
                }
            }
        }

        /* SEO */
        $seoDB = $seo->getOnDB('*', 'setting_seo', $setting['id']);
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
    } else {
        /* Is ajax */
        if ($func->isAjax()) {
            $resultAjax = array();
            $resultAjax['status'] = 'error';
            $resultAjax['message'] = 'Lĩnh vực kinh doanh không hợp lệ';
            echo json_encode($resultAjax);
            exit();
        } else {
            /* Redirect */
            $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
        }
    }
} else {
    /* Is ajax */
    if ($func->isAjax()) {
        $resultAjax = array();
        $resultAjax['status'] = 'error';
        $resultAjax['message'] = 'Lĩnh vực kinh doanh không hợp lệ';
        echo json_encode($resultAjax);
        exit();
    } else {
        /* Redirect */
        $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
    }
}
