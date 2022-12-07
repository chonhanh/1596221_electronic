<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active photo */
if (isset($config['photo'])) {
    $arrCheck = array();
    $actCheck = '';
    if ($act == 'photo_static' || $act == 'save_static') $actCheck = 'photo_static';
    else $actCheck = 'man_photo';
    foreach ($config['photo'][$actCheck] as $k => $v) $arrCheck[] = $k;
    if (!count($arrCheck) || !in_array($type, $arrCheck)) $func->transfer("Trang không tồn tại", "index.php", false);
} else {
    $func->transfer("Trang không tồn tại", "index.php", false);
}

switch ($act) {
        /* Photo static */
    case "photo_static":
        viewPhotoStatic();
        $template = "photo/static/photo_static";
        break;
    case "save_static":
        savePhotoStatic();
        break;

        /* Photos */
    case "man_photo":
        viewPhotos();
        $template = "photo/man/photos";
        break;
    case "add_photo":
        $template = "photo/man/photo_add";
        break;
    case "edit_photo":
        editPhoto();
        $template = "photo/man/photo_edit";
        break;
    case "save_photo":
        savePhoto();
        break;
    case "delete_photo":
        deletePhoto();
        break;

    default:
        $template = "404";
}

/* View photo static */
function viewPhotoStatic()
{
    global $d, $idShop, $prefixSector, $item, $type;

    $item = $d->rawQueryOne("select * from #_photo where id_shop = $idShop and sector_prefix = ? and act = ? and type = ? limit 0,1", array($prefixSector, 'photo_static', $type));
}

/* Save photo static */
function savePhotoStatic()
{
    global $d, $idShop, $prefixSector, $func, $flash, $config, $type;

    /* Post dữ liệu */
    $row = $d->rawQueryOne("select id from #_photo where id_shop = $idShop and sector_prefix = ? and act = ? and type = ? limit 0,1", array($prefixSector, 'photo_static', $type));
    $message = '';
    $response = array();
    $id = (isset($row['id']) && $row['id'] > 0) ? $row['id'] : 0;
    $data = (isset($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }
    }

    if (isset($_POST['status'])) {
        $status = '';
        foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
        $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
    } else {
        $data['status'] = "";
    }

    $data['id_shop'] = $idShop;
    $data['sector_prefix'] = $prefixSector;
    $data['type'] = $type;
    $data['act'] = 'photo_static';

    /* Valid data link */
    if (!empty($config['photo']['photo_static'][$type]['link'])) {
        if (!empty($data['link']) && !$func->isUrl($data['link'])) {
            $response['messages'][] = 'Đường dẫn không hợp lệ';
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

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);
        $func->redirect("index.php?com=photo&act=photo_static&type=" . $type);
    }

    if ($id) {
        $data['date_updated'] = time();

        $d->where('id_shop', $idShop);
        $d->where('sector_prefix', $prefixSector);
        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('photo', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['photo']['photo_static'][$type]['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_photo where id_shop = $idShop and sector_prefix = ? and id = ? and act = ? and type = ? limit 0,1", array($prefixSector, $id, 'photo_static', $type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PHOTO . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->where('id_shop', $idShop);
                    $d->where('sector_prefix', $prefixSector);
                    $d->update('photo', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=photo&act=photo_static&type=" . $type);
        } else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=photo&act=photo_static&type=" . $type, false);
    } else {
        $data['date_created'] = time();

        if (!empty($config['photo']['photo_static'][$type]['images']) && $func->hasFile("file")) {
            if ($d->insert('photo', $data)) {
                $id_insert = $d->getLastInsertId();

                /* Photo */
                if ($func->hasFile("file")) {
                    $photoUpdate = array();
                    $file_name = $func->uploadName($_FILES['file']["name"]);

                    if ($photo = $func->uploadImage("file", $config['photo']['photo_static'][$type]['img_type'], UPLOAD_PHOTO, $file_name)) {
                        $photoUpdate['photo'] = $photo;
                        $d->where('id', $id_insert);
                        $d->where('id_shop', $idShop);
                        $d->where('sector_prefix', $prefixSector);
                        $d->update('photo', $photoUpdate);
                        unset($photoUpdate);
                    }
                }

                $func->transfer("Lưu dữ liệu thành công", "index.php?com=photo&act=photo_static&type=" . $type);
            } else {
                $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=photo&act=photo_static&type=" . $type, false);
            }
        } else {
            $func->transfer("Dữ liệu rỗng", "index.php?com=photo&act=photo_static&type=" . $type, false);
        }
    }
}

/* View photo */
function viewPhotos()
{
    global $d, $idShop, $prefixSector, $func, $curPage, $items, $paging, $type;

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_photo where id_shop = $idShop and sector_prefix = ? and type = ? and act <> ? order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($prefixSector, $type, 'photo_static'));
    $sqlNum = "select count(*) as 'num' from #_photo where id_shop = $idShop and sector_prefix = ? and type = ? and act <> ? order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($prefixSector, $type, 'photo_static'));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=photo&act=man_photo&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit photo */
function editPhoto()
{
    global $d, $idShop, $prefixSector, $func, $curPage, $item, $list_cat, $type;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) $func->transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);

    $item = $d->rawQueryOne("select * from #_photo where id_shop = $idShop and sector_prefix = ? and id = ? and act <> ? and type = ? limit 0,1", array($prefixSector, $id, 'photo_static', $type));

    if (empty($item)) $func->transfer("Dữ liệu không có thực", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
}

/* Save photo */
function savePhoto()
{
    global $d, $idShop, $prefixSector, $func, $flash, $curPage, $config, $type;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $data = (isset($_POST['data'])) ? $_POST['data'] : null;
    $dataMultiTemp = (isset($_POST['dataMulti'])) ? $_POST['dataMulti'] : null;
    if ($data) {
        $data['id_shop'] = $idShop;
        $data['sector_prefix'] = $prefixSector;

        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }
    }

    $id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;

    if ($id) {
        /* Valid data link */
        if (!empty($config['photo']['man_photo'][$type]['link_photo'])) {
            if (!empty($data['link']) && !$func->isUrl($data['link'])) {
                $response['messages'][] = 'Đường dẫn không hợp lệ';
            }
        }

        /* Valid data video */
        if (!empty($config['photo']['man_photo'][$type]['video_photo'])) {
            if (empty($data['link_video'])) {
                $response['messages'][] = 'Đường dẫn video không được trống';
            }

            if (!empty($data['link_video']) && !$func->isYoutube($data['link_video'])) {
                $response['messages'][] = 'Đường dẫn video không hợp lệ';
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

            /* Errors */
            $response['status'] = 'danger';
            $message = base64_encode(json_encode($response));
            $flash->set('message', $message);
            $func->redirect("index.php?com=photo&act=edit_photo&type=" . $type . "&id=" . $id);
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        $data['date_updated'] = time();
        $data['act'] = 'photo_multi';

        $d->where('id_shop', $idShop);
        $d->where('sector_prefix', $prefixSector);
        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('photo', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['photo']['man_photo'][$type]['img_type_photo'], UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_photo where id_shop = $idShop and sector_prefix = ? and id = ? and type = ? limit 0,1", array($prefixSector, $id, $type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PHOTO . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->where('id_shop', $idShop);
                    $d->where('sector_prefix', $prefixSector);
                    $d->update('photo', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
        }
    } else {
        $numberPhoto = (isset($config['photo']['man_photo'][$type]['number_photo'])) ? $config['photo']['man_photo'][$type]['number_photo'] : 0;

        if ($numberPhoto && $dataMultiTemp) {
            $success = 0;

            for ($i = 0; $i < count($dataMultiTemp); $i++) {
                $success_photo = false;
                $success_video = false;
                $dataMulti = $dataMultiTemp[$i];
                if (!empty($dataMulti['status'])) {
                    $dataStatus = implode(",", $dataMulti['status']);
                    $dataMulti['status'] = (!empty($dataStatus)) ? rtrim($dataStatus, ",") : "";
                } else {
                    $dataMulti['status'] = "";
                }
                $dataMulti['id_shop'] = $idShop;
                $dataMulti['sector_prefix'] = $prefixSector;
                $dataMulti['date_created'] = time();
                $dataMulti['type'] = $type;
                $dataMulti['act'] = 'photo_multi';

                if (isset($config['photo']['man_photo'][$type]['images_photo']) && $config['photo']['man_photo'][$type]['images_photo'] == true) {
                    if ($func->hasFile("file" . $i)) {
                        $success_photo = true;
                    }
                }

                /* Valid data video */
                if (isset($config['photo']['man_photo'][$type]['video_photo']) && $config['photo']['man_photo'][$type]['video_photo'] == true) {
                    if (!empty($dataMulti['link_video'])) {
                        $success_video = true;
                    }

                    if (!empty($dataMulti['link_video']) && !$func->isYoutube($dataMulti['link_video'])) {
                        $response['messages'][] = 'Đường dẫn video không hợp lệ';
                    }
                }

                /* Valid data link */
                if (!empty($config['photo']['man_photo'][$type]['link_photo'])) {
                    if (!empty($dataMulti['link']) && !$func->isUrl($dataMulti['link'])) {
                        $response['messages'][] = 'Đường dẫn không hợp lệ';
                    }
                }

                if (!empty($response)) {
                    /* Flash data */
                    if (!empty($dataMulti)) {
                        foreach ($dataMulti as $k => $v) {
                            if (!empty($v)) {
                                $flash->set($k . $i, $v);
                            }
                        }
                    }
                }

                if (($success_photo || $success_video) && empty($response)) {
                    if ($d->insert('photo', $dataMulti)) {
                        $id_insert = $d->getLastInsertId();

                        /* Photo */
                        if (isset($config['photo']['man_photo'][$type]['images_photo']) && $config['photo']['man_photo'][$type]['images_photo'] == true) {
                            if ($func->hasFile("file" . $i)) {
                                $photoUpdate = array();
                                $file_name = $func->uploadName($_FILES["file" . $i]["name"]);

                                if ($photo = $func->uploadImage("file" . $i, $config['photo']['man_photo'][$type]['img_type_photo'], UPLOAD_PHOTO, $file_name . $i)) {
                                    $photoUpdate['photo'] = $photo;
                                    $d->where('id', $id_insert);
                                    $d->where('id_shop', $idShop);
                                    $d->where('sector_prefix', $prefixSector);
                                    $d->update('photo', $photoUpdate);
                                    unset($photoUpdate);
                                }
                            }
                        }

                        $success = true;
                    } else {
                        $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
                    }
                }
            }

            if (!empty($response)) {
                /* Errors */
                $response['status'] = 'danger';
                $message = base64_encode(json_encode($response));
                $flash->set('message', $message);
                $func->redirect("index.php?com=photo&act=add_photo&type=" . $type);
            }

            if ($success == false) {
                $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
            } else {
                $func->transfer("Lưu dữ liệu thành công", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage);
            }
        }
        $func->transfer("Dữ liệu rỗng", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
    }
}

/* Delete photo */
function deletePhoto()
{
    global $d, $idShop, $prefixSector, $func, $curPage, $type;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id, photo from #_photo where id_shop = $idShop and sector_prefix = ? and id = ? and type = ? limit 0,1", array($prefixSector, $id, $type));

        if (isset($row['id']) && $row['id'] > 0) {
            $func->deleteFile(UPLOAD_PHOTO . $row['photo']);
            $d->rawQuery("delete from #_photo where id_shop = $idShop and sector_prefix = ? and id = ? and type = ?", array($prefixSector, $id, $type));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage);
        } else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id, photo from #_photo where id_shop = $idShop and sector_prefix = ? and id = ? and type = ? limit 0,1", array($prefixSector, $id, $type));

            if (isset($row['id']) && $row['id'] > 0) {
                $func->deleteFile(UPLOAD_PHOTO . $row['photo']);
                $d->rawQuery("delete from #_photo where id_shop = $idShop and sector_prefix = ? and id = ? and type = ?", array($prefixSector, $id, $type));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage);
    } else $func->transfer("Không nhận được dữ liệu", "index.php?com=photo&act=man_photo&type=" . $type . "&p=" . $curPage, false);
}
