<?php
if (!defined('SOURCES')) die("Error");

/* Get data */
$hasAdvertise = true;
$IDSector = (!empty($_GET['sector'])) ? htmlspecialchars($_GET['sector']) : 0;
$IDCat = (!empty($_GET['cat'])) ? htmlspecialchars($_GET['cat']) : 0;
$isLogin = $func->getMember('active');
$idMember = $func->getMember('id');

/* Check login */
if (empty($isLogin)) {
    if ($func->isAjax() && !empty($_GET['isAjaxPosting'])) {
        /* Is ajax */
        $resultAjax = array();
        $resultAjax['status'] = 'error';
        $resultAjax['message'] = 'Vui lòng đăng nhập để đăng tin';
        echo json_encode($resultAjax);
        exit();
    } else {
        $urlLogin = $configBase . 'account/dang-nhap';
        $urlRedirect = (!empty($IDSector)) ? $urlLogin . '?back=' . $configBase . 'dang-tin?sector=' . $IDSector . '&cat=' . $IDCat : $urlLogin;
        $func->redirect($urlRedirect);
    }
}

/* Sector detail */
if (!empty($IDSector) && !empty($IDCat)) {
    $sectorDetail = $cache->get("select type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

    /* Sector cat detail */
    $sectorCatDetail = $cache->get("select label_posting_main$lang, label_posting_item$lang, label_posting_sub$lang from #_product_cat where id_list = ? and id = ? and find_in_set('hienthi',status) order by numb,id desc", array($IDSector, $IDCat), 'fetch', 7200);

    /* Check sector */
    if (!empty($sectorDetail) && !empty($sectorCatDetail)) {
        /* Sector list */
        $sector = $defineSectors['types'][$sectorDetail['type']];

        /* Labels */
        $func->set('sector-label', $sector['name']);
        $func->set('sector-label-posting-main', (!empty($sectorCatDetail['label_posting_main' . $lang])) ? $sectorCatDetail['label_posting_main' . $lang] : 'Đăng tin ' . $func->get('sector-label'));
        $func->set('sector-label-posting-item', (!empty($sectorCatDetail['label_posting_item' . $lang])) ? $sectorCatDetail['label_posting_item' . $lang] : 'Chọn danh mục');
        $func->set('sector-label-posting-sub', (!empty($sectorCatDetail['label_posting_sub' . $lang])) ? $sectorCatDetail['label_posting_sub' . $lang] : 'Chọn danh mục');
        if (in_array($sector['type'], array($config['website']['sectors']))) {
            $func->set('price-label', 'Giá');
            $func->set('content-label', 'Thông tin mô tả');
            $func->set('content-desc', 'Mô tả chi tiết các thông tin về tin đăng');
            $func->set('photo-label', 'Hình ảnh');
        } else if (in_array($sector['type'], array('nha-tuyen-dung'))) {
            $func->set('price-label', 'Mức lương');
            $func->set('content-label', 'Mô tả công việc');
            $func->set('content-desc', 'Mô tả chi tiết các thông tin về công việc');
        } else if (in_array($sector['type'], array('ung-vien'))) {
            $func->set('price-label', 'Mức lương');
            $func->set('content-label', 'Giới thiệu về bản thân');
            $func->set('content-desc', 'Sơ lược các thông tin về bản thân');
            $func->set('photo-label', 'Hình ảnh cá nhân và hồ sơ');
        }

        /* Sector item */
        $sectorItems = $cache->get("select name$lang, photo, slugvi, slugen, id from #_product_item where id_list = ? and id_cat = ? and find_in_set('hienthi',status) order by numb,id desc", array($IDSector, $IDCat), 'result', 7200);

        /* Is has sub sector */
        if (in_array($sector['type'], array($config['website']['sectors']))) {
            $func->set('hasSectorSub', true);
        }

        /* Tags */
        $sectorTags = $cache->get("select name$lang, id from #_product_tags where id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array($sector['id']), 'result', 7200);

        /* Price type */
        $typePrice = $cache->get("select name$lang, id from #_variation where id_list = ? and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($sector['id'], 'loai-gia'), 'result', 7200);

        if (in_array($sector['type'], array('nha-tuyen-dung', 'ung-vien'))) {
            /* Form work */
            $formWork = $cache->get("select name$lang, id from #_variation where id_list = ? and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($sector['id'], 'hinh-thuc-lam-viec'), 'result', 7200);

            /* Experience */
            $experience = $cache->get("select name$lang, id from #_variation where id_list = ? and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($sector['id'], 'kinh-nghiem'), 'result', 7200);
        }

        /* SEO */
        $seo->set('title', $func->get('sector-label-posting-main'));
        $seo->set('keywords', $func->get('sector-label-posting-main'));
        $seo->set('description', $func->get('sector-label-posting-main'));

        /* City */
        $city = $cache->get("select name, id from #_city where find_in_set('hienthi',status) order by numb,id asc", null, 'result', 7200);

        /* Save data */
        if (!empty($_POST['submit-posting']) || ($func->isAjax() && !empty($_GET['isAjaxPosting']))) {
            /* Post data */
            $message = '';
            $response = array();
            $dataPosting = (!empty($_POST['dataPosting'])) ? $_POST['dataPosting'] : null;
            $dataPostingVideo = (!empty($_POST['dataPostingVideo'])) ? $_POST['dataPostingVideo'] : null;
            $dataPostingTags = (!empty($_POST['dataPostingTags'])) ? $_POST['dataPostingTags'] : null;
            $dataPostingColor = (!empty($_POST['dataPostingColor'])) ? $_POST['dataPostingColor'] : null;
            $dataPostingSize = (!empty($_POST['dataPostingSize'])) ? $_POST['dataPostingSize'] : null;
            $dataPostingVariations = (!empty($_POST['dataPostingVariations'])) ? $_POST['dataPostingVariations'] : null;
            $dataPostingInfo = (!empty($_POST['dataPostingInfo'])) ? $_POST['dataPostingInfo'] : null;
            $dataPostingContent = (!empty($_POST['dataPostingContent'])) ? $_POST['dataPostingContent'] : null;
            $dataPostingSeo = array();
            $dataPostingContact = (!empty($_POST['dataPostingContact'])) ? $_POST['dataPostingContact'] : null;
            $listsGallery = $func->listsGallery('files-uploader-posting');

            /* Check data main */
            if ($dataPosting) {
                $dataPosting['id_shop'] = $idShop;
                $dataPosting['id_member'] = $idMember;
                $dataPosting['id_list'] = $sector['id'];
                $dataPosting['id_cat'] = $IDCat;
                $regionInfo = (!empty($dataPosting['id_city'])) ? $func->getInfoDetail('id_region', 'city', $dataPosting['id_city']) : 0;
                $dataPosting['id_region'] = (!empty($regionInfo)) ? $regionInfo['id_region'] : 0;

                foreach ($dataPosting as $column => $value) {
                    $dataPosting[$column] = htmlspecialchars($func->sanitize($value));
                }

                /* Regular price */
                if (!empty($dataPosting['regular_price']) && strstr($dataPosting['regular_price'], ',')) {
                    $dataPosting['regular_price'] = str_replace(",", ".", $dataPosting['regular_price']);
                }

                /* Acreage */
                if (!empty($dataPosting['acreage']) && strstr($dataPosting['acreage'], ',')) {
                    $dataPosting['acreage'] = str_replace(",", ".", $dataPosting['acreage']);
                }

                /* Real price */
                if (!empty($dataPostingVariations['type-price'])) {
                    $denomination = $cache->get("select denominations from #_variation where id = ? and type = ? and find_in_set('hienthi',status) limit 1", array($dataPostingVariations['type-price']['id'], $dataPostingVariations['type-price']['type']), 'fetch', 7200);
                    $dataPosting['real_price'] = (!empty($denomination['denominations'])) ? $denomination['denominations'] * $dataPosting['regular_price'] : 0;
                }

                /* Status attr */
                if ($func->hasService($sector) || $func->hasAccessary($sector)) {
                    $dataPosting['status_attr'] = (!empty($dataPosting['status_attr']) && $dataPosting['status_attr'] == 'service') ? 'dichvu' : ((!empty($dataPosting['status_attr']) && $dataPosting['status_attr'] == 'accessary') ? 'phutung' : '');
                }

                /* Others */
                $dataPosting['slugvi'] = (!empty($dataPosting['namevi'])) ? $func->changeTitle($dataPosting['namevi']) : '';
                $dataPosting['status'] = '';
                $dataPosting['status_user'] = 'hienthi';
                $dataPosting['date_created'] = time();
            }

            /* Check data info */
            if ($dataPostingInfo) {
                foreach ($dataPostingInfo as $column => $value) {
                    $dataPostingInfo[$column] = htmlspecialchars($func->sanitize($value));
                }

                if (!empty($dataPostingInfo['birthday'])) {
                    $birthdayInfo = $dataPostingInfo['birthday'];
                    $dataPostingInfo['birthday'] = strtotime(str_replace("/", "-", htmlspecialchars($dataPostingInfo['birthday'])));
                }

                if (!empty($dataPostingInfo['application_deadline'])) {
                    $applicationDeadlineInfo = $dataPostingInfo['application_deadline'];
                    $dataPostingInfo['application_deadline'] = strtotime(str_replace("/", "-", htmlspecialchars($dataPostingInfo['application_deadline'])));
                }
            }

            /* Check data video */
            if ($dataPostingVideo) {
                foreach ($dataPostingVideo as $column => $value) {
                    $dataPostingVideo[$column] = htmlspecialchars($func->sanitize($value));
                }

                $dataPostingVideo['slugvi'] = (!empty($dataPostingVideo['namevi'])) ? $func->changeTitle($dataPostingVideo['namevi']) : '';
            }

            /* Check data content */
            if ($dataPostingContent) {
                foreach ($dataPostingContent as $column => $value) {
                    $dataPostingContent[$column] = htmlspecialchars($func->sanitize($value));
                }
            }

            /* Check data seo */
            $dataPostingSeo['titlevi'] = (!empty($dataPosting['namevi'])) ? $dataPosting['namevi'] : '';
            $dataPostingSeo['keywordsvi'] = (!empty($dataPosting['namevi'])) ? $dataPosting['namevi'] : '';
            $dataPostingSeo['descriptionvi'] = (!empty($dataPostingContent['contentvi'])) ? $func->stringSub($func->stringOrigin($dataPostingContent['contentvi']), 160, '') : '';

            /* Check data contact */
            if ($dataPostingContact) {
                foreach ($dataPostingContact as $column => $value) {
                    $dataPostingContact[$column] = htmlspecialchars($func->sanitize($value));
                }
            }

            /* Valid data */
            if (empty($dataPosting['namevi'])) {
                $response['messages'][] = 'Tiêu đề không được trống';
            }

            if (empty($dataPosting['id_item'])) {
                $response['messages'][] = 'Chưa chọn danh mục cấp 3';
            }

            if (in_array("form-work", $sector['attributes'])) {
                if (empty($dataPostingVariations['form-work']['id'])) {
                    $response['messages'][] = 'Chưa chọn hình thức làm việc';
                }
            }

            if (in_array("experience", $sector['attributes'])) {
                if (empty($dataPostingVariations['experience']['id'])) {
                    $response['messages'][] = 'Chưa chọn kinh nghiệm';
                }
            }

            if (empty($dataPosting['id_city'])) {
                $response['messages'][] = 'Chưa chọn tỉnh/thành phố';
            }

            if (empty($dataPosting['id_district'])) {
                $response['messages'][] = 'Chưa chọn quận/huyện';
            }

            if (empty($dataPosting['id_wards'])) {
                $response['messages'][] = 'Chưa chọn phường/xã';
            }

            if (empty($dataPostingContent['contentvi'])) {
                $response['messages'][] = 'Nội dung không được trống';
            }

            if (empty($dataPostingVideo['namevi']) && ($func->hasFile('video-file') || $func->hasFile('file-poster'))) {
                $response['messages'][] = 'Tiêu đề video không được trống';
            }

            if (!empty($dataPostingVideo['namevi']) && $dataPostingVideo['type'] == 'file' && !$func->hasFile('file-poster')) {
                $response['messages'][] = 'Poster video không được trống';
            }

            if (!empty($dataPostingVideo['namevi']) && $dataPostingVideo['type'] == 'file' && !$func->hasFile('video-file')) {
                $response['messages'][] = 'Tập tin video không được trống';
            }

            if (!empty($dataPostingVideo['namevi']) && $dataPostingVideo['type'] == 'file' && !$func->checkExtFile('video-file')) {
                $response['messages'][] = 'Chi cho phép tập tin video với định dạng: ' . implode(",", $config['website']['video']['extension']);
            }

            if (!empty($dataPostingVideo['namevi']) && $dataPostingVideo['type'] == 'file' && !$func->checkFile('video-file')) {
                $sizeVideo = $func->formatBytes($config['website']['video']['max-size']);
                $response['messages'][] = 'Tập tin video không được vượt quá ' . $sizeVideo['numb'] . ' ' . $sizeVideo['ext'];
            }

            if (in_array("price", $sector['attributes'])) {
                $title_money = 'Giá';
            }

            if (in_array("salary", $sector['attributes'])) {
                $title_money = 'Mức lương';
            }

            if (!empty($title_money)) {
                if (empty($dataPosting['regular_price'])) {
                    $response['messages'][] = $title_money . ' không được trống';
                }

                if (!empty($dataPosting['regular_price']) && !$func->isDecimal($dataPosting['regular_price'])) {
                    $response['messages'][] = $title_money . ' không hợp lệ';
                }

                if (empty($dataPostingVariations['type-price']['id'])) {
                    $response['messages'][] = 'Chưa chọn đơn vị ' . $func->textConvert($title_money, 'lower');
                }
            }

            if (in_array("acreage", $sector['attributes'])) {
                if (empty($dataPosting['acreage'])) {
                    $response['messages'][] = 'Diện tích không được trống';
                }

                if (!empty($dataPosting['acreage']) && !$func->isDecimal($dataPosting['acreage'])) {
                    $response['messages'][] = 'Diện tích không hợp lệ';
                }
            }

            if (in_array("coordinates", $sector['attributes'])) {
                if (empty($dataPosting['coordinates'])) {
                    $response['messages'][] = 'Tọa độ không được trống';
                }

                if (!empty($dataPosting['coordinates']) && !$func->isCoords($dataPosting['coordinates'])) {
                    $response['messages'][] = 'Tọa độ không hợp lệ';
                }
            }

            if (in_array("info-candidate", $sector['attributes'])) {
                if (empty($dataPostingInfo['first_name'])) {
                    $response['messages'][] = 'Họ và chữ lót không được trống';
                }

                if (empty($dataPostingInfo['last_name'])) {
                    $response['messages'][] = 'Tên không được trống';
                }

                if (empty($birthdayInfo)) {
                    $response['messages'][] = 'Ngày sinh không được trống';
                }

                if (!empty($birthdayInfo) && !$func->isDate($birthdayInfo)) {
                    $response['messages'][] = 'Ngày sinh không hợp lệ';
                }
            }

            if (in_array("info-employer", $sector['attributes'])) {
                if (empty($_FILES['file_employer']['size'])) {
                    $response['messages'][] = 'Hình ảnh đại diện không được trống';
                }

                if (empty($dataPostingInfo['fullname'])) {
                    $response['messages'][] = 'Tên nhà tuyển dụng không được trống';
                }

                if (empty($dataPostingInfo['age_requirement'])) {
                    $response['messages'][] = 'Yêu cầu độ tuổi không được trống';
                }

                if (empty($dataPostingInfo['application_deadline'])) {
                    $response['messages'][] = 'Hạn nộp hồ sơ không được trống';
                }

                if (!empty($applicationDeadlineInfo) && !$func->isDate($applicationDeadlineInfo)) {
                    $response['messages'][] = 'Hạn nộp hồ sơ không hợp lệ';
                }

                if (empty($dataPostingInfo['trial_period'])) {
                    $response['messages'][] = 'Thời gian thử việc không được trống';
                }

                if (empty($dataPostingInfo['employee_quantity'])) {
                    $response['messages'][] = 'Số lượng tuyển dụng không được trống';
                }

                if (!empty($dataPostingInfo['employee_quantity']) && !$func->isNumber($dataPostingInfo['employee_quantity'])) {
                    $response['messages'][] = 'Số lượng tuyển dụng không hợp lệ';
                }
            }

            if (in_array("info-candidate", $sector['attributes']) || in_array("info-employer", $sector['attributes'])) {
                if (empty($dataPostingInfo['gender'])) {
                    $response['messages'][] = 'Chưa chọn giới tính';
                }

                if (empty($dataPostingInfo['phone'])) {
                    $response['messages'][] = 'Số điện thoại không được trống';
                }

                if (!empty($dataPostingInfo['phone']) && !$func->isPhone($dataPostingInfo['phone'])) {
                    $response['messages'][] = 'Số điện thoại không hợp lệ';
                }

                if (empty($dataPostingInfo['email'])) {
                    $response['messages'][] = 'Email không được trống';
                }

                if (!empty($dataPostingInfo['email']) && !$func->isEmail($dataPostingInfo['email'])) {
                    $response['messages'][] = 'Email không hợp lệ';
                }

                if (empty($dataPostingInfo['address'])) {
                    $response['messages'][] = 'Địa chỉ không được trống';
                }
            }

            if (in_array("info-employer", $sector['attributes'])) {
                if (empty($dataPostingInfo['introduce'])) {
                    $response['messages'][] = 'Giới thiệu không được trống';
                }
            }

            if (in_array($sector['type'], array($config['website']['sectors']))) {
                if (empty($listsGallery)) {
                    $response['messages'][] = 'Album hình ảnh không được trống';
                }

                if (!empty($listsGallery) && count($listsGallery) > 6) {
                    $response['messages'][] = 'Album hình ảnh không được vượt quá 6 hình';
                }
            }

            if (empty($dataPostingContact['fullname'])) {
                $response['messages'][] = 'Họ tên liên hệ không được trống';
            }
            if (empty($dataPostingContact['phone'])) {
                $response['messages'][] = 'Số điện thoại liên hệ không được trống';
            }
            if (!empty($dataPostingContact['phone']) && !$func->isPhone($dataPostingContact['phone'])) {
                $response['messages'][] = 'Số điện thoại liên hệ không hợp lệ';
            }

            if (empty($dataPostingContact['email'])) {
                $response['messages'][] = 'Email liên hệ không được trống';
            }

            if (!empty($dataPostingContact['email']) && !$func->isEmail($dataPostingContact['email'])) {
                $response['messages'][] = 'Email liên hệ không hợp lệ';
            }

            if (empty($dataPostingContact['address'])) {
                $response['messages'][] = 'Địa chỉ liên hệ không được trống';
            }

            if (!empty($response)) {
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
                    $func->redirect("dang-tin?sector=" . $sector['id']);
                }
            }

            /* Import data */
            if ($d->insert($sector['tables']['main'], $dataPosting)) {
                $id_insert = $d->getLastInsertId();

                /* Info */
                if ($dataPostingInfo) {
                    $dataPostingInfo['id_parent'] = $id_insert;
                    $d->insert($sector['tables']['info'], $dataPostingInfo);
                }

                /* Content */
                $dataPostingContent['id_parent'] = $id_insert;
                $d->insert($sector['tables']['content'], $dataPostingContent);

                /* Video */
                if ($dataPostingVideo['type'] == 'file') {
                    /* Upload poster */
                    $file_name = $func->uploadName($_FILES["file-poster"]["name"]);

                    if ($photo = $func->uploadImage("file-poster", $config['website']['video']['poster']['extension'], UPLOAD_PHOTO_L, $file_name)) {
                        $dataPostingVideo['photo'] = $photo;
                    }

                    /* Upload video */
                    $file_name = $func->uploadName($_FILES["video-file"]["name"]);

                    if ($video = $func->uploadImage("video-file", implode("|", $config['website']['video']['extension']), UPLOAD_VIDEO_L, $file_name)) {
                        $dataPostingVideo['video'] = $video;
                    }

                    /* Save video */
                    $dataPostingVideo['id_parent'] = $id_insert;
                    $d->insert($sector['tables']['video'], $dataPostingVideo);
                }

                /* Variation */
                if ($dataPostingVariations) {
                    foreach ($dataPostingVariations as $v) {
                        $dataPostingVariation = array();
                        $dataPostingVariation['id_parent'] = $id_insert;
                        $dataPostingVariation['id_variation'] = $v['id'];
                        $dataPostingVariation['type'] = $v['type'];
                        $d->insert($sector['tables']['variation'], $dataPostingVariation);
                    }
                }

                /* Tag */
                if ($dataPostingTags) {
                    foreach ($dataPostingTags as $v) {
                        $dataPostingTag = array();
                        $dataPostingTag['id_parent'] = $id_insert;
                        $dataPostingTag['id_tag'] = $v;
                        $d->insert($sector['tables']['tag'], $dataPostingTag);
                    }
                }

                /* Sale */
                if (($func->hasCart($sector) && !isset($dataPosting['status_attr'])) || ($func->hasCart($sector) && isset($dataPosting['status_attr']) && !strstr($dataPosting['status_attr'], 'dichvu'))) {
                    if (!empty($dataPostingColor) && !empty($dataPostingSize)) {
                        $dataSale1 = array();
                        $dataSale1['id'] = 'id_color';
                        $dataSale1['data'] = $dataPostingColor;

                        $dataSale2 = array();
                        $dataSale2['id'] = 'id_size';
                        $dataSale2['data'] = $dataPostingSize;
                    } else if (!empty($dataPostingColor)) {
                        $dataSale1 = array();
                        $dataSale1['id'] = 'id_color';
                        $dataSale1['data'] = $dataPostingColor;
                    } else if (!empty($dataPostingSize)) {
                        $dataSale1 = array();
                        $dataSale1['id'] = 'id_size';
                        $dataSale1['data'] = $dataPostingSize;
                    }

                    if (!empty($dataSale1['data']) || !empty($dataSale2['data'])) {
                        foreach ($dataSale1['data'] as $v_sale1) {
                            $dataSale = array();
                            $dataSale['id_parent'] = $id_insert;
                            $dataSale[$dataSale1['id']] = $v_sale1;

                            if (!empty($dataSale2['data'])) {
                                foreach ($dataSale2['data'] as $v_sale2) {
                                    $dataSale[$dataSale2['id']] = $v_sale2;
                                    $d->insert($sector['tables']['sale'], $dataSale);
                                }
                            } else {
                                $d->insert($sector['tables']['sale'], $dataSale);
                            }
                        }
                    }
                }

                /* SEO */
                $dataPostingSeo['id_parent'] = $id_insert;
                $d->insert($sector['tables']['seo'], $dataPostingSeo);

                /* Contact */
                $dataPostingContact['id_parent'] = $id_insert;
                $d->insert($sector['tables']['contact'], $dataPostingContact);

                /* Avatar */
                if (!empty($_FILES["file_employer"])) {
                    $photoPosting = array();
                    $file_name = $func->uploadName($_FILES["file_employer"]["name"]);
                    if ($file_employer = $func->uploadImage("file_employer", '.jpg|.png|.gif|.JPG|.PNG|.GIF', UPLOAD_PRODUCT_L, $file_name)) {
                        $photoPosting['photo'] = $file_employer;
                        $d->where('id', $id_insert);
                        $d->update($sector['tables']['main'], $photoPosting);
                        unset($photoPosting);
                    }
                }

                /* Gallery */
                if (in_array($sector['type'], array($config['website']['sectors'])) && !empty($listsGallery)) {
                    $myFile = $_FILES['files-uploader-posting'];
                    $fileCount = count($myFile["name"]);

                    for ($i = 0; $i < $fileCount; $i++) {
                        if (in_array($myFile["name"][$i], $listsGallery, true)) {
                            $_FILES['file-uploader-temp'] = array(
                                'name' => $myFile['name'][$i],
                                'type' => $myFile['type'][$i],
                                'tmp_name' => $myFile['tmp_name'][$i],
                                'error' => $myFile['error'][$i],
                                'size' => $myFile['size'][$i]
                            );
                            $file_name = $func->uploadName($myFile["name"][$i]);

                            if ($photo = $func->uploadImage("file-uploader-temp", '.jpg|.gif|.png|.jpeg|.gif', UPLOAD_PRODUCT_L, $file_name)) {
                                $dataGallery = array();
                                $dataGallery['id_parent'] = $id_insert;
                                $dataGallery['photo'] = $photo;
                                $dataGallery['namevi'] = $file_name;
                                $dataGallery['numb'] = ($i + 1);
                                $dataGallery['status'] = 'hienthi';
                                $dataGallery['date_created'] = time();
                                $d->insert($sector['tables']['photo'], $dataGallery);

                                /* Get first photo gallery for Photo Product */
                                if (empty($photoPosting)) {
                                    $photoPosting = array();
                                    $_FILES['file-photo'] = array(
                                        'name' => $myFile['name'][$i],
                                        'type' => $myFile['type'][$i],
                                        'tmp_name' => $myFile['tmp_name'][$i],
                                        'error' => $myFile['error'][$i],
                                        'size' => $myFile['size'][$i]
                                    );
                                    $file_name = $func->uploadName($myFile["name"][$i]) . '-' . $func->digitalRandom(0, 3, 6);

                                    if ($photo = $func->uploadImage("file-photo", '.jpg|.gif|.png|.jpeg|.gif', UPLOAD_PRODUCT_L, $file_name)) {
                                        $photoPosting['photo'] = $photo;
                                        $d->where('id_shop', $idShop);
                                        $d->where('id', $id_insert);
                                        $d->update($sector['tables']['main'], $photoPosting);
                                    }
                                }
                            }
                        }
                    }
                }

                /* Is ajax */
                if ($func->isAjax()) {
                    $resultAjax = array();
                    $resultAjax['status'] = 'success';
                    $resultAjax['message'] = 'Đăng tin thành công. Chúng tôi sẽ xem xét và duyệt tin của bạn sớm nhất.';
                    echo json_encode($resultAjax);
                    exit();
                } else {
                    /* Redirect */
                    $func->transfer("Đăng tin thành công. Chúng tôi sẽ xem xét và duyệt tin của bạn sớm nhất.", $configBase);
                }
            } else {
                /* Is ajax */
                if ($func->isAjax()) {
                    $resultAjax = array();
                    $resultAjax['status'] = 'error';
                    $resultAjax['message'] = 'Đăng tin thất bại. Vui lòng thử lại sau.';
                    echo json_encode($resultAjax);
                    exit();
                } else {
                    /* Redirect */
                    $func->transfer("Đăng tin thất bại. Vui lòng thử lại sau.", "dang-tin?sector=" . $sector['id'], false);
                }
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
