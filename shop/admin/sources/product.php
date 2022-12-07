<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active product */
if (empty($config['product']) || (in_array($act, array('add_size', 'save_size', 'man_size', 'add_color', 'save_color', 'man_color'))) && !$func->hasCart($sector)) {
    $func->transfer("Trang không tồn tại", "index.php", false);
}

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('id_list', 'id_cat', 'id_item', 'id_sub', 'id_region', 'id_city', 'id_district', 'id_wards');
if (!empty($_POST['data'])) {
    $dataUrl = $_POST['data'];
    foreach ($arrUrl as $k => $v) {
        if (!empty($dataUrl[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($dataUrl[$arrUrl[$k]]);
    }
} else {
    foreach ($arrUrl as $k => $v) {
        if (!empty($_REQUEST[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($_REQUEST[$arrUrl[$k]]);
    }
    if (!empty($_REQUEST['keyword'])) $strUrl .= "&keyword=" . htmlspecialchars($_REQUEST['keyword']);
}

switch ($act) {
        /* Man */
    case "man":
        viewMans();
        $template = "product/man/mans";
        break;
    case "add":
        addMan();
        $template = "product/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "product/man/man_add";
        break;
    case "save":
        saveMan();
        break;
    case "delete":
        deleteMan();
        break;

        /* Item */
    case "man_item":
        viewItems();
        $template = "product/item/items";
        break;
    case "add_item":
        $template = "product/item/item_add";
        break;
    case "save_item":
        saveItem();
        break;

        /* Sub */
    case "man_sub":
        viewSubs();
        $template = "product/sub/subs";
        break;
    case "add_sub":
        $template = "product/sub/sub_add";
        break;
    case "save_sub":
        saveSub();
        break;

        /* Size */
    case "man_size":
        viewSizes();
        $template = "product/size/sizes";
        break;
    case "add_size":
        $template = "product/size/size_add";
        break;
    case "save_size":
        saveSize();
        break;

        /* Color */
    case "man_color":
        viewColors();
        $template = "product/color/colors";
        break;
    case "add_color":
        $template = "product/color/color_add";
        break;
    case "save_color":
        saveColor();
        break;

    default:
        $template = "404";
}

/* View man */
function viewMans()
{
    global $d, $idShop, $func, $comment, $strUrl, $curPage, $items, $paging, $prefixSector, $configSector;

    /* Tables */
    $tableShop = (!empty($configSector['tables']['shop'])) ? $configSector['tables']['shop'] : '';
    $tableComment = (!empty($configSector['tables']['comment'])) ? $configSector['tables']['comment'] : '';
    $tableCommentPhoto = (!empty($configSector['tables']['comment-photo'])) ? $configSector['tables']['comment-photo'] : '';
    $tableCommentVideo = (!empty($configSector['tables']['comment-video'])) ? $configSector['tables']['comment-video'] : '';

    /* Get data */
    $where = "";
    $id_list = (!empty($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    $id_cat = (!empty($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
    $id_item = (!empty($_REQUEST['id_item'])) ? htmlspecialchars($_REQUEST['id_item']) : 0;
    $id_sub = (!empty($_REQUEST['id_sub'])) ? htmlspecialchars($_REQUEST['id_sub']) : 0;
    $idregion = (!empty($_REQUEST['id_region'])) ? htmlspecialchars($_REQUEST['id_region']) : 0;
    $idcity = (!empty($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
    $iddistrict = (!empty($_REQUEST['id_district'])) ? htmlspecialchars($_REQUEST['id_district']) : 0;
    $idwards = (!empty($_REQUEST['id_wards'])) ? htmlspecialchars($_REQUEST['id_wards']) : 0;
    $comment_status = (!empty($_REQUEST['comment_status'])) ? htmlspecialchars($_REQUEST['comment_status']) : '';

    if ($id_list) $where .= " and id_list=$id_list";
    if ($id_cat) $where .= " and id_cat=$id_cat";
    if ($id_item) $where .= " and id_item=$id_item";
    if ($id_sub) $where .= " and id_sub=$id_sub";
    if ($idregion) $where .= " and id_region=$idregion";
    if ($idcity) $where .= " and id_city=$idcity";
    if ($iddistrict) $where .= " and id_district=$iddistrict";
    if ($idwards) $where .= " and id_wards=$idwards";
    if ($comment_status == 'new' && !empty($tableComment)) {
        $comment = $d->rawQuery("select distinct id_product from #_$tableComment where id_shop = $idShop and find_in_set('new-shop',status) and find_in_set('hienthi',status)");
        $idcomment = (!empty($comment)) ? $func->joinCols($comment, 'id_product') : 0;
        $where .= " and id in ($idcomment)";
    }
    if (!empty($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_" . $configSector['tables']['main'] . " where id_shop = $idShop and id > 0 $where order by date_created desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_" . $configSector['tables']['main'] . " where id_shop = $idShop and id > 0 $where order by date_created desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* Comment */
    $comment = new Comments($d, $func, ['shop' => $tableShop, 'main' => $tableComment, 'photo' => $tableCommentPhoto, 'video' => $tableCommentVideo], $prefixSector);
}

/* Add man */
function addMan()
{
    global $d, $func, $curPage, $configSector, $typePrice, $formWork, $experience;

    /* Get type price */
    if (in_array("price", $configSector['attributes'])) {
        $typePrice = $d->rawQuery("select namevi, id from #_variation where id_list = ? and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($configSector['id'], 'loai-gia'));
    }
}

/* Edit man */
function editMan()
{
    global $d, $idShop, $func, $strUrl, $curPage, $item, $itemContent, $itemSale, $itemPhoto, $itemVideo, $itemVariation, $configSector, $typePrice;

    /* ID data */
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    /* Check sector data */
    if (!empty($id)) {
        /* Get data detail */
        $item = $d->rawQueryOne("select * from #_" . $configSector['tables']['main'] . " where id_shop = $idShop and id = ? limit 0,1", array($id));

        /* Check data detail */
        if (!empty($item)) {
            /* Get type price */
            if (in_array("price", $configSector['attributes'])) {
                $typePrice = $d->rawQuery("select namevi, id from #_variation where id_list = ? and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($configSector['id'], 'loai-gia'));
            }

            /* Get content */
            $itemContent = $d->rawQueryOne("select * from #_" . $configSector['tables']['content'] . " where id_parent = ?", array($id));

            /* Get sale */
            if (!empty($configSector['tables']['sale'])) {
                $itemSale = $d->rawQuery("select * from #_" . $configSector['tables']['sale'] . " where id_parent = ?", array($id));
                $itemSale['colors'] = (!empty($itemSale)) ? $func->joinCols($itemSale, 'id_color') : '';
                $itemSale['sizes'] = (!empty($itemSale)) ? $func->joinCols($itemSale, 'id_size') : '';
            }

            /* Get photos */
            if (!empty($configSector['tables']['photo'])) {
                $itemPhoto = $d->rawQuery("select * from #_" . $configSector['tables']['photo'] . " where id_parent = ? order by numb,id desc", array($id));
            }

            /* Get videos */
            $itemVideo = $d->rawQueryOne("select * from #_" . $configSector['tables']['video'] . " where id_parent = ? limit 0,1", array($id));

            /* Get variation */
            if (!empty($configSector['tables']['variation'])) {
                $itemVariations = $d->rawQuery("select * from #_" . $configSector['tables']['variation'] . " where id_parent = ?", array($id));
                if (!empty($itemVariations)) {
                    foreach ($itemVariations as $v) {
                        $itemVariation[$v['type']] = $v;
                    }
                } else {
                    $itemVariation = array();
                }
            }
        } else {
            $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man&p=" . $curPage . $strUrl, false);
        }
    } else {
        $func->transfer("Dữ liệu không hợp lệ", "index.php", false);
    }
}

/* Save man */
function saveMan()
{
    global $d, $idShop, $idSectorList, $idSectorCat, $strUrl, $func, $flash, $curPage, $config, $configSector;

    /* Check empty post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man&id_list=" . $idSectorList . "&p=" . $curPage . $strUrl, false);
    }

    /* Post data */
    $message = '';
    $response = array();
    $action = (!empty($_POST['submit-posting'])) ? $_POST['submit-posting'] : '';
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    $dataTags = (!empty($_POST['dataTags'])) ? $_POST['dataTags'] : null;
    $dataColor = (!empty($_POST['dataColor'])) ? $_POST['dataColor'] : null;
    $dataSize = (!empty($_POST['dataSize'])) ? $_POST['dataSize'] : null;
    $dataVideo = (!empty($_POST['dataVideo'])) ? $_POST['dataVideo'] : null;
    $existVideo = (!empty($_POST['existVideo'])) ? $_POST['existVideo'] : false;
    $existVideoPhoto = (!empty($_POST['existVideoPhoto'])) ? $_POST['existVideoPhoto'] : false;
    $dataVariations = (!empty($_POST['dataVariations'])) ? $_POST['dataVariations'] : null;
    $dataContent = (!empty($_POST['dataContent'])) ? $_POST['dataContent'] : null;
    $dataSeo = (!empty($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
    $existPhoto = (!empty($_POST['existPhoto'])) ? $_POST['existPhoto'] : false;
    $listsGallery = $func->listsGallery('files-uploader-product');

    /* Check data main */
    if ($data) {
        $data['id_shop'] = $idShop;
        $data['id_list'] = $idSectorList;
        $data['id_cat'] = $idSectorCat;

        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        /* Regular price */
        if (!empty($data['regular_price']) && strstr($data['regular_price'], ',')) {
            $data['regular_price'] = str_replace(",", ".", $data['regular_price']);
        }

        /* Acreage */
        if (in_array("acreage", $configSector['attributes'])) {
            if (!empty($data['acreage']) && strstr($data['acreage'], ',')) {
                $data['acreage'] = str_replace(",", ".", $data['acreage']);
            }
        }

        /* Real price */
        if (!empty($dataVariations['type-price'])) {
            $denomination = $d->rawQueryOne("select denominations from #_variation where id = ? and type = ? and find_in_set('hienthi',status) limit 1", array($dataVariations['type-price']['id'], $dataVariations['type-price']['type']));
            $data['real_price'] = (!empty($denomination['denominations'])) ? $denomination['denominations'] * $data['regular_price'] : 0;
        }

        /* Others */
        $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
        $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';

        /* Status attr */
        if (isset($_POST['status_attr'])) {
            $status = '';
            foreach ($_POST['status_attr'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status_attr'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status_attr'] = "";
        }
    }

    /* Check data video */
    if ($dataVideo) {
        foreach ($dataVideo as $column => $value) {
            $dataVideo[$column] = htmlspecialchars($func->sanitize($value));
        }

        $dataVideo['slugvi'] = (!empty($dataVideo['namevi'])) ? $func->changeTitle($dataVideo['namevi']) : '';
    }

    /* Check data content */
    if ($dataContent) {
        foreach ($dataContent as $column => $value) {
            $dataContent[$column] = htmlspecialchars($func->sanitize($value, 'iframe'));
        }
    }

    /* Check data seo */
    if ($dataSeo) {
        foreach ($dataSeo as $column => $value) {
            $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
        }
    }

    /* Valid data */
    if (empty($data['namevi'])) {
        $response['messages'][] = 'Tiêu đề không được trống';
    }

    if (empty($dataContent['contentvi'])) {
        $response['messages'][] = 'Nội dung không được trống';
    }

    if (empty($dataVideo['namevi']) && ($func->hasFile('video-file') || $func->hasFile('file-poster'))) {
        $response['messages'][] = 'Tiêu đề video không được trống';
    }

    if (!empty($dataVideo['namevi']) && $dataVideo['type'] == 'file' && !$func->hasFile('file-poster') && !$existVideoPhoto) {
        $response['messages'][] = 'Poster video không được trống';
    }

    if (!empty($dataVideo['namevi']) && $dataVideo['type'] == 'file' && !$func->hasFile('video-file') && !$existVideo) {
        $response['messages'][] = 'Tập tin video không được trống';
    }

    if (!empty($dataVideo['namevi']) && $dataVideo['type'] == 'file' && !$func->checkExtFile('video-file')) {
        $response['messages'][] = 'Chi cho phép tập tin video với định dạng: ' . implode(",", $config['website']['video']['extension']);
    }

    if (!empty($dataVideo['namevi']) && $dataVideo['type'] == 'file' && !$func->checkFile('video-file')) {
        $sizeVideo = $func->formatBytes($config['website']['video']['max-size']);
        $response['messages'][] = 'Tập tin video không được vượt quá ' . $sizeVideo['numb'] . ' ' . $sizeVideo['ext'];
    }

    if (in_array("price", $configSector['attributes'])) {
        $title_money = 'Giá';
    }

    if (!empty($title_money)) {
        if (empty($data['regular_price'])) {
            $response['messages'][] = $title_money . ' không được trống';
        }

        if (!empty($data['regular_price']) && (!$func->isDecimal($data['regular_price']) || $func->isZero($data['regular_price']))) {
            $response['messages'][] = $title_money . ' không hợp lệ';
        }

        if (empty($dataVariations['type-price']['id'])) {
            $response['messages'][] = 'Chưa chọn đơn vị ' . $func->textConvert($title_money, 'lower');
        }
    }

    if (in_array("acreage", $configSector['attributes'])) {
        if (empty($data['acreage'])) {
            $response['messages'][] = 'Diện tích không được trống';
        }

        if (!empty($data['acreage']) && (!$func->isDecimal($data['acreage']) || $func->isZero($data['acreage']))) {
            $response['messages'][] = 'Diện tích không hợp lệ';
        }
    }

    if (in_array("coordinates", $configSector['attributes'])) {
        if (empty($data['coordinates'])) {
            $response['messages'][] = 'Tọa độ không được trống';
        }

        if (!empty($data['coordinates']) && !$func->isCoords($data['coordinates'])) {
            $response['messages'][] = 'Tọa độ không hợp lệ';
        }
    }

    if (empty($data['id_item'])) {
        $response['messages'][] = 'Chưa chọn danh mục cấp 3';
    }

    if (empty($data['id_region'])) {
        $response['messages'][] = 'Chưa chọn vùng/miền';
    }

    if (empty($data['id_city'])) {
        $response['messages'][] = 'Chưa chọn tỉnh/thành phố';
    }

    if (empty($data['id_district'])) {
        $response['messages'][] = 'Chưa chọn quận/huyện';
    }

    if (empty($data['id_wards'])) {
        $response['messages'][] = 'Chưa chọn phường/xã';
    }

    if (!$func->hasFile('file') && !$existPhoto) {
        $response['messages'][] = 'Hình đại diện không được trống';
    }

    if (in_array($configSector['type'], array($config['website']['sectors']))) {
        if (empty($id)) {
            if (empty($listsGallery)) {
                $response['messages'][] = 'Album hình ảnh không được trống';
            }

            if (!empty($listsGallery) && count($listsGallery) > 6) {
                $response['messages'][] = 'Album hình ảnh không được vượt quá 6 hình';
            }
        }
    }

    if (!empty($response)) {
        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        if (!empty($dataVideo)) {
            foreach ($dataVideo as $k => $v) {
                if (!empty($v)) {
                    $flash->set('video_' . $k, $v);
                }
            }
        }

        if (!empty($dataContent)) {
            foreach ($dataContent as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        if (!empty($dataSeo)) {
            foreach ($dataSeo as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        $flash->set('type-price-id', (!empty($dataVariations['type-price']['id'])) ? $dataVariations['type-price']['id'] : 0);

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if (empty($id)) {
            $func->redirect("index.php?com=product&act=add" . $strUrl);
        } else {
            $func->redirect("index.php?com=product&act=edit" . $strUrl . "&id=" . $id);
        }
    }

    /* Save or insert data by sectors */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id_shop', $idShop);
        $d->where('id', $id);
        if ($d->update($configSector['tables']['main'], $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['product']['img_type'], UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_" . $configSector['tables']['main'] . " where id_shop = $idShop and id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->where('id_shop', $idShop);
                    $d->update($configSector['tables']['main'], $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Content */
            $d->rawQuery("delete from #_" . $configSector['tables']['content'] . " where id_parent = ?", array($id));
            $dataContent['id_parent'] = $id;
            $d->insert($configSector['tables']['content'], $dataContent);

            /* Video */
            if ($dataVideo['type'] == 'file') {
                /* Upload info */
                if (!empty($dataVideo['namevi'])) {
                    $d->where('id_parent', $id);
                    $d->update($configSector['tables']['video'], $dataVideo);
                }

                /* Upload poster */
                if ($func->hasFile("file-poster")) {
                    $posterUpdate = array();
                    $file_name = $func->uploadName($_FILES["file-poster"]["name"]);

                    if ($photo = $func->uploadImage("file-poster", $config['website']['video']['poster']['extension'], UPLOAD_PHOTO, $file_name)) {
                        $row = $d->rawQueryOne("select id, photo from #_" . $configSector['tables']['video'] . " where id_parent = ? limit 0,1", array($id));

                        if (!empty($row)) {
                            $func->deleteFile(UPLOAD_PHOTO . $row['photo']);

                            $posterUpdate['photo'] = $photo;
                            $posterUpdate['type'] = $dataVideo['type'];
                            $d->where('id_parent', $id);
                            $d->update($configSector['tables']['video'], $posterUpdate);
                        } else {
                            $posterUpdate['photo'] = $photo;
                            $posterUpdate['type'] = $dataVideo['type'];
                            $posterUpdate['id_parent'] = $id;
                            $d->insert($configSector['tables']['video'], $posterUpdate);
                        }

                        unset($posterUpdate);
                    }
                }

                /* Upload video */
                if ($func->hasFile("video-file")) {
                    $videoUpdate = array();
                    $file_name = $func->uploadName($_FILES["video-file"]["name"]);

                    if ($video = $func->uploadImage("video-file", implode("|", $config['website']['video']['extension']), UPLOAD_VIDEO, $file_name)) {
                        $row = $d->rawQueryOne("select id, video from #_" . $configSector['tables']['video'] . " where id_parent = ? limit 0,1", array($id));

                        if (!empty($row)) {
                            $func->deleteFile(UPLOAD_VIDEO . $row['video']);
                        }

                        $videoUpdate['video'] = $video;
                        $videoUpdate['type'] = $dataVideo['type'];
                        $d->where('id_parent', $id);
                        $d->update($configSector['tables']['video'], $videoUpdate);
                        unset($videoUpdate);
                    }
                }
            }

            /* Variation */
            if ($dataVariations) {
                $d->rawQuery("delete from #_" . $configSector['tables']['variation'] . " where id_parent = ?", array($id));
                foreach ($dataVariations as $v) {
                    $dataVariation = array();
                    $dataVariation['id_parent'] = $id;
                    $dataVariation['id_variation'] = $v['id'];
                    $dataVariation['type'] = $v['type'];
                    $d->insert($configSector['tables']['variation'], $dataVariation);
                }
            }

            /* Tag */
            if ($dataTags) {
                $d->rawQuery("delete from #_" . $configSector['tables']['tag'] . " where id_parent = ?", array($id));
                foreach ($dataTags as $v) {
                    $dataTag = array();
                    $dataTag['id_parent'] = $id;
                    $dataTag['id_tag'] = $v;
                    $d->insert($configSector['tables']['tag'], $dataTag);
                }
            } else {
                $d->rawQuery("delete from #_" . $configSector['tables']['tag'] . " where id_parent = ?", array($id));
            }

            /* Sale */
            if (($func->hasCart($configSector) && !isset($data['status_attr'])) || ($func->hasCart($configSector) && isset($data['status_attr']) && !strstr($data['status_attr'], 'dichvu'))) {
                if (!empty($dataColor) && !empty($dataSize)) {
                    $dataSale1 = array();
                    $dataSale1['id'] = 'id_color';
                    $dataSale1['data'] = $dataColor;

                    $dataSale2 = array();
                    $dataSale2['id'] = 'id_size';
                    $dataSale2['data'] = $dataSize;
                } else if (!empty($dataColor)) {
                    $dataSale1 = array();
                    $dataSale1['id'] = 'id_color';
                    $dataSale1['data'] = $dataColor;
                } else if (!empty($dataSize)) {
                    $dataSale1 = array();
                    $dataSale1['id'] = 'id_size';
                    $dataSale1['data'] = $dataSize;
                }

                if (!empty($dataSale1['data']) || !empty($dataSale2['data'])) {
                    $d->rawQuery("delete from #_" . $configSector['tables']['sale'] . " where id_parent = ?", array($id));

                    foreach ($dataSale1['data'] as $v_sale1) {
                        $dataSale = array();
                        $dataSale['id_parent'] = $id;
                        $dataSale[$dataSale1['id']] = $v_sale1;

                        if (!empty($dataSale2['data'])) {
                            foreach ($dataSale2['data'] as $v_sale2) {
                                $dataSale[$dataSale2['id']] = $v_sale2;
                                $d->insert($configSector['tables']['sale'], $dataSale);
                            }
                        } else {
                            $d->insert($configSector['tables']['sale'], $dataSale);
                        }
                    }
                } else {
                    $d->rawQuery("delete from #_" . $configSector['tables']['sale'] . " where id_parent = ?", array($id));
                }
            } else if (!empty($configSector['tables']['sale'])) {
                $d->rawQuery("delete from #_" . $configSector['tables']['sale'] . " where id_parent = ?", array($id));
            }

            /* SEO */
            $d->rawQuery("delete from #_" . $configSector['tables']['seo'] . " where id_parent = ?", array($id));
            $dataSeo['id_parent'] = $id;
            $d->insert($configSector['tables']['seo'], $dataSeo);

            /* Gallery */
            if (in_array($configSector['type'], array($config['website']['sectors']))) {
                $func->uploadGallery('files-uploader-product', $configSector['tables']['photo'], $config['product']['img_type'], UPLOAD_PRODUCT, $id);
            }

            if ($action == 'fix-posting') {
                /* Confirm fixed */
                confirmFixPosting($configSector, $id);
            } else {
                $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man&p=" . $curPage . $strUrl);
            }
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man&p=" . $curPage . $strUrl, false);
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert($configSector['tables']['main'], $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['product']['img_type'], UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->where('id_shop', $idShop);
                    $d->update($configSector['tables']['main'], $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Content */
            $dataContent['id_parent'] = $id_insert;
            $d->insert($configSector['tables']['content'], $dataContent);

            /* Video */
            if ($dataVideo['type'] == 'file') {
                /* Upload poster */
                $file_name = $func->uploadName($_FILES["file-poster"]["name"]);

                if ($photo = $func->uploadImage("file-poster", $config['website']['video']['poster']['extension'], UPLOAD_PHOTO, $file_name)) {
                    $dataVideo['photo'] = $photo;
                }

                /* Upload video */
                $file_name = $func->uploadName($_FILES["video-file"]["name"]);

                if ($video = $func->uploadImage("video-file", implode("|", $config['website']['video']['extension']), UPLOAD_VIDEO, $file_name)) {
                    $dataVideo['video'] = $video;
                }

                /* Save video */
                $dataVideo['id_parent'] = $id_insert;
                $d->insert($configSector['tables']['video'], $dataVideo);
            }

            /* Variation */
            if ($dataVariations) {
                foreach ($dataVariations as $v) {
                    $dataVariation = array();
                    $dataVariation['id_parent'] = $id_insert;
                    $dataVariation['id_variation'] = $v['id'];
                    $dataVariation['type'] = $v['type'];
                    $d->insert($configSector['tables']['variation'], $dataVariation);
                }
            }

            /* Tag */
            if ($dataTags) {
                foreach ($dataTags as $v) {
                    $dataTag = array();
                    $dataTag['id_parent'] = $id_insert;
                    $dataTag['id_tag'] = $v;
                    $d->insert($configSector['tables']['tag'], $dataTag);
                }
            }

            /* Sale */
            if (($func->hasCart($configSector) && !isset($data['status_attr'])) || ($func->hasCart($configSector) && isset($data['status_attr']) && !strstr($data['status_attr'], 'dichvu'))) {
                if (!empty($dataColor) && !empty($dataSize)) {
                    $dataSale1 = array();
                    $dataSale1['id'] = 'id_color';
                    $dataSale1['data'] = $dataColor;

                    $dataSale2 = array();
                    $dataSale2['id'] = 'id_size';
                    $dataSale2['data'] = $dataSize;
                } else if (!empty($dataColor)) {
                    $dataSale1 = array();
                    $dataSale1['id'] = 'id_color';
                    $dataSale1['data'] = $dataColor;
                } else if (!empty($dataSize)) {
                    $dataSale1 = array();
                    $dataSale1['id'] = 'id_size';
                    $dataSale1['data'] = $dataSize;
                }

                if (!empty($dataSale1['data']) || !empty($dataSale2['data'])) {
                    foreach ($dataSale1['data'] as $v_sale1) {
                        $dataSale = array();
                        $dataSale['id_parent'] = $id_insert;
                        $dataSale[$dataSale1['id']] = $v_sale1;

                        if (!empty($dataSale2['data'])) {
                            foreach ($dataSale2['data'] as $v_sale2) {
                                $dataSale[$dataSale2['id']] = $v_sale2;
                                $d->insert($configSector['tables']['sale'], $dataSale);
                            }
                        } else {
                            $d->insert($configSector['tables']['sale'], $dataSale);
                        }
                    }
                }
            }

            /* SEO */
            $dataSeo['id_parent'] = $id_insert;
            $d->insert($configSector['tables']['seo'], $dataSeo);

            /* Gallery */
            if (in_array($configSector['type'], array($config['website']['sectors']))) {
                $func->uploadGallery('files-uploader-product', $configSector['tables']['photo'], $config['product']['img_type'], UPLOAD_PRODUCT, $id_insert);
            }

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man&p=" . $curPage . $strUrl, false);
        }
    }
}

function confirmFixPosting($sector = array(), $id = 0)
{
    global $d, $idShop, $func, $emailer, $setting, $configBase;

    if (empty($sector) || empty($id)) {
        $func->transfer("Xác nhận không thành công. Vui lòng thử lại sau", $configBase, false);
    }

    /* Detail posting */
    $detailProduct = $d->rawQueryOne("select namevi, id, id_shop, id_list, id_cat, id_item, id_sub, id_region, id_city, id_district, id_wards from #_" . $sector['tables']['main'] . " where id = ? limit 0,1", array($id));

    /* Detail shop */
    $detailShop = $d->rawQueryOne("select id, id_member, id_admin, name, slug_url from #_" . $sector['tables']['shop'] . " where id = ?  limit 0, 1", array($idShop));

    /* Data send email */
    $dataSend = array();
    $dataSend['productData'] = $detailProduct;
    $dataSend['shopData'] = $detailShop;
    $dataSend['sectorInfo'] = $sector;

    /* Defaults attributes email */
    $emailDefaultAttrs = $emailer->defaultAttrs();

    /* Variables email */
    $emailVars = array(
        '{emailShopName}',
        '{emailProductName}',
        '{emailLinkReport}'
    );
    $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

    /* Values email */
    $emailVals = array(
        $dataSend['shopData']['name'],
        $dataSend['productData']['namevi'],
        $configBase . 'admin/index.php?com=report&act=edit_report_posting&id_list=' . $dataSend['sectorInfo']['id'] . '&id_shop=' . $dataSend['productData']['id_shop'] . '&id_product=' . $dataSend['productData']['id']
    );
    $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

    /* Send email */
    $arrayEmail = null;
    $subject = "Thư thông báo từ " . $setting['namevi'];
    $message = str_replace($emailVars, $emailVals, $emailer->markdown('product/confirm-fix'));
    $file = null;

    if ($emailer->send("admin", $arrayEmail, $subject, $message, $file)) {
        $func->transfer("Xác nhận chỉnh sửa thành công. Vui lòng chờ Ban Quản Trị duyệt xác nhận", 'index.php?com=product&act=edit&id_list=' . $dataSend['productData']['id_list'] . '&id_cat=' . $dataSend['productData']['id_cat'] . '&id_item=' . $dataSend['productData']['id_item'] . '&id_sub=' . $dataSend['productData']['id_sub'] . '&id_region=' . $dataSend['productData']['id_region'] . '&id_city=' . $dataSend['productData']['id_city'] . '&id_district=' . $dataSend['productData']['id_district'] . '&id_wards=' . $dataSend['productData']['id_wards'] . '&id=' . $dataSend['productData']['id']);
    } else {
        $func->transfer("Xác nhận chỉnh sửa thất bại. Vui lòng thử lại sau", 'index.php?com=product&act=edit&id_list=' . $dataSend['productData']['id_list'] . '&id_cat=' . $dataSend['productData']['id_cat'] . '&id_item=' . $dataSend['productData']['id_item'] . '&id_sub=' . $dataSend['productData']['id_sub'] . '&id_region=' . $dataSend['productData']['id_region'] . '&id_city=' . $dataSend['productData']['id_city'] . '&id_district=' . $dataSend['productData']['id_district'] . '&id_wards=' . $dataSend['productData']['id_wards'] . '&id=' . $dataSend['productData']['id'], false);
    }
}

/* Delete man */
function deleteMan()
{
    global $d, $idShop, $strUrl, $func, $curPage, $com, $configSector;

    /* ID data */
    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Get data detail */
        $row = $d->rawQueryOne("select id, photo from #_" . $configSector['tables']['main'] . " where id_shop = $idShop and id = ? limit 0,1", array($id));

        /* Check data detail */
        if (!empty($row['id'])) {
            /* Delete action */
            $func->deleteProduct($row, $configSector, UPLOAD_PRODUCT);

            /* Run Maintain database */
            $d->runMaintain();

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man&p=" . $curPage . $strUrl, false);
        }
    } elseif (!empty($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            /* ID data */
            $id = htmlspecialchars($listid[$i]);

            /* Get data detail */
            $row = $d->rawQueryOne("select id, photo from #_" . $configSector['tables']['main'] . " where id_shop = $idShop and id = ? limit 0,1", array($id));

            /* Check data detail */
            if (!empty($row['id'])) {
                /* Delete action */
                $func->deleteProduct($row, $configSector, UPLOAD_PRODUCT);
            }
        }

        /* Run Maintain database */
        $d->runMaintain();

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man&p=" . $curPage . $strUrl, false);
    }
}

/* View item */
function viewItems()
{
    global $d, $idShop, $idSectorList, $idSectorCat, $prefixSector, $func, $strUrl, $curPage, $items, $paging;

    $where = "";
    $where .= " and A.id_list=$idSectorList";
    $where .= " and A.id_cat=$idSectorCat";

    if (!empty($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (A.namevi LIKE '%$keyword%' or A.nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select A.*, B.status as statusShop from #_product_item as A left join #_product_item_status as B on A.id = B.id_parent and B.id_shop = $idShop where A.id > 0 $where order by A.numb asc, A.id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_product_item as A left join #_product_item_status as B on A.id = B.id_parent and B.id_shop = $idShop where A.id > 0 $where order by A.numb asc, A.id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_item" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Save item */
function saveItem()
{
    global $d, $idShop, $idSectorList, $idSectorCat, $prefixSector, $strUrl, $func, $flash, $curPage, $config, $com;

    /* Check empty post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_item&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        $data['id_shop'] = $idShop;
        $data['id_list'] = $idSectorList;
        $data['id_cat'] = $idSectorCat;
        $data['sector_prefix'] = $prefixSector;
        $data['date_created'] = time();

        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
        $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
    }

    /* Post seo */
    $dataSeo = (!empty($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
    if ($dataSeo) {
        foreach ($dataSeo as $column => $value) {
            $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
        }
    }

    /* Valid data */
    if (empty($data['namevi'])) {
        $response['messages'][] = 'Tiêu đề không được trống';
    }

    if (!empty($response)) {
        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        if (!empty($dataSeo)) {
            foreach ($dataSeo as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        $func->redirect("index.php?com=product&act=add_item" . $strUrl);
    }

    /* Add data */
    if ($d->insert('product_item', $data)) {
        $id_insert = $d->getLastInsertId();

        /* Photo 1 */
        if ($func->hasFile("file")) {
            $photoUpdate = array();
            $file_name = $func->uploadName($_FILES['file']["name"]);

            if ($photo = $func->uploadImage("file", $config['product']['img_type_item'], UPLOAD_PRODUCT, $file_name)) {
                $photoUpdate['photo'] = $photo;
                $d->where('id', $id_insert);
                $d->where('id_shop', $idShop);
                $d->update('product_item', $photoUpdate);
                unset($photoUpdate);
            }
        }

        /* Photo 2 */
        /*
			if($func->hasFile("file-2"))
			{
				$photoUpdate = array();
				$file_name = $func->uploadName($_FILES['file-2']["name"]);

				if($photo2 = $func->uploadImage("file-2", $config['product']['img_type_item'], UPLOAD_PRODUCT, $file_name))
				{
					$photoUpdate['photo2'] = $photo2;
					$d->where('id', $id_insert);
					$d->where('id_shop', $idShop);
					$d->update('product_item', $photoUpdate);
					unset($photoUpdate);
				}
			}
			*/

        /* SEO */
        $dataSeo['id_parent'] = $id_insert;
        $d->insert('product_item_seo', $dataSeo);

        $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_item&p=" . $curPage . $strUrl);
    } else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_item&p=" . $curPage . $strUrl, false);
}

/* View sub */
function viewSubs()
{
    global $d, $idShop, $idSectorList, $idSectorCat, $prefixSector, $func, $strUrl, $curPage, $items, $paging;

    $where = "";
    $where .= " and A.id_list=$idSectorList";
    $where .= " and A.id_cat=$idSectorCat";
    $iditem = (!empty($_REQUEST['id_item'])) ? htmlspecialchars($_REQUEST['id_item']) : 0;

    if ($iditem) $where .= " and A.id_item=$iditem";
    if (!empty($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (A.namevi LIKE '%$keyword%' or A.nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select A.*, B.status as statusShop from #_product_sub as A left join #_product_sub_status as B on A.id = B.id_parent and B.id_shop = $idShop where A.id > 0 $where order by A.numb asc, A.id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_product_sub as A left join #_product_sub_status as B on A.id = B.id_parent and B.id_shop = $idShop where A.id > 0 $where order by A.numb asc, A.id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_sub" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Save sub */
function saveSub()
{
    global $d, $idShop, $idSectorList, $idSectorCat, $prefixSector, $strUrl, $func, $flash, $curPage, $config, $com;

    /* Check empty post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_sub&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        $data['id_shop'] = $idShop;
        $data['id_list'] = $idSectorList;
        $data['id_cat'] = $idSectorCat;
        $data['sector_prefix'] = $prefixSector;
        $data['date_created'] = time();

        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
        $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
    }

    /* Post seo */
    $dataSeo = (!empty($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
    if ($dataSeo) {
        foreach ($dataSeo as $column => $value) {
            $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
        }
    }

    /* Valid data */
    if (empty($data['namevi'])) {
        $response['messages'][] = 'Tiêu đề không được trống';
    }

    if (!empty($response)) {
        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        if (!empty($dataSeo)) {
            foreach ($dataSeo as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        $func->redirect("index.php?com=product&act=add_sub" . $strUrl);
    }

    /* Add data */
    if ($d->insert('product_sub', $data)) {
        $id_insert = $d->getLastInsertId();

        /* Photo */
        if ($func->hasFile("file")) {
            $photoUpdate = array();
            $file_name = $func->uploadName($_FILES['file']["name"]);

            if ($photo = $func->uploadImage("file", $config['product']['img_type_sub'], UPLOAD_PRODUCT, $file_name)) {
                $photoUpdate['photo'] = $photo;
                $d->where('id', $id_insert);
                $d->where('id_shop', $idShop);
                $d->update('product_sub', $photoUpdate);
                unset($photoUpdate);
            }
        }

        /* SEO */
        $dataSeo['id_parent'] = $id_insert;
        $d->insert('product_sub_seo', $dataSeo);

        $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_sub&p=" . $curPage . $strUrl);
    } else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_sub&p=" . $curPage . $strUrl, false);
}

/* View size */
function viewSizes()
{
    global $d, $idSectorList, $func, $curPage, $strUrl, $items, $paging;

    $where = "";
    $where .= " and id_list=$idSectorList";

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_product_size where id > 0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_product_size where id > 0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_size" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Save size */
function saveSize()
{
    global $d, $idShop, $idSectorList, $prefixSector, $func, $flash, $curPage, $strUrl, $config;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_size&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        $data['id_list'] = $idSectorList;
        $data['id_shop'] = $idShop;
        $data['sector_prefix'] = $prefixSector;

        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
        $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
    }

    /* Valid data */
    if (empty($data['namevi'])) {
        $response['messages'][] = 'Tiêu đề không được trống';
    }

    if (!empty($data['namevi']) && $func->checkExistData($data['slugvi'], 'product_size')) {
        $response['messages'][] = 'Kích thước đã tồn tại';
    }

    if (!empty($response)) {
        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        $func->redirect("index.php?com=product&act=add_size&p=" . $curPage . $strUrl);
    }

    /* Save data */
    $data['date_created'] = time();

    if ($d->insert('product_size', $data)) {
        $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_size&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_size&p=" . $curPage . $strUrl, false);
    }
}

/* View color */
function viewColors()
{
    global $d, $func, $curPage, $items, $paging;

    $where = "";

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_product_color where id > 0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_product_color where id > 0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_color";
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Save color */
function saveColor()
{
    global $d, $idShop, $prefixSector, $func, $flash, $curPage, $config;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_color&p=" . $curPage, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        $data['id_shop'] = $idShop;
        $data['sector_prefix'] = $prefixSector;

        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
        $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
    }

    /* Valid data */
    if (empty($data['namevi'])) {
        $response['messages'][] = 'Tiêu đề không được trống';
    }

    if (!empty($data['namevi']) && $func->checkExistData($data['slugvi'], 'product_color')) {
        $response['messages'][] = 'Màu sắc đã tồn tại';
    }

    if (!empty($response)) {
        /* Flash data */
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $flash->set($k, $v);
                }
            }
        }

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        $func->redirect("index.php?com=product&act=add_color&p=" . $curPage);
    }

    /* Save data */
    $data['date_created'] = time();

    if ($d->insert('product_color', $data)) {
        $id_insert = $d->getLastInsertId();

        /* Photo */
        if ($func->hasFile("file")) {
            $photoUpdate = array();
            $file_name = $func->uploadName($_FILES['file']["name"]);

            if ($photo = $func->uploadImage("file", $config['product']['img_type_color'], UPLOAD_COLOR, $file_name)) {
                $photoUpdate['photo'] = $photo;
                $d->where('id', $id_insert);
                $d->where('id_shop', $idShop);
                $d->update('product_color', $photoUpdate);
                unset($photoUpdate);
            }
        }

        $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_color&p=" . $curPage);
    } else {
        $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_color&p=" . $curPage, false);
    }
}
