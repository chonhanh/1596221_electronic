<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active variation */
if (isset($config['variation'])) {
    $arrCheck = array();
    foreach ($config['variation'] as $k => $v) $arrCheck[] = $k;
    if (!count($arrCheck) || !in_array($type, $arrCheck)) $func->transfer("Trang không tồn tại", "index.php", false);
} else {
    $func->transfer("Trang không tồn tại", "index.php", false);
}

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('id_list');
if (isset($_POST['data'])) {
    $dataUrl = isset($_POST['data']) ? $_POST['data'] : null;
    if ($dataUrl) {
        foreach ($arrUrl as $k => $v) {
            if (isset($dataUrl[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($dataUrl[$arrUrl[$k]]);
        }
    }
} else {
    foreach ($arrUrl as $k => $v) {
        if (isset($_REQUEST[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($_REQUEST[$arrUrl[$k]]);
    }
    if (isset($_REQUEST['keyword'])) $strUrl .= "&keyword=" . htmlspecialchars($_REQUEST['keyword']);
}

switch ($act) {
    case "man":
        viewMans();
        $template = "variation/man/mans";
        break;
    case "add":
        $template = "variation/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "variation/man/man_add";
        break;
    case "save":
        saveMan();
        break;
    case "delete":
        deleteMan();
        break;
    default:
        $template = "404";
}

/* View man */
function viewMans()
{
    global $d, $func, $strUrl, $curPage, $items, $paging, $type;

    $where = "";

    // $idlist = (isset($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    // if ($idlist) $where .= " and id_list=$idlist";
    
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_variation where type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_variation where type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=variation&act=man" . $strUrl . "&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit man */
function editMan()
{
    global $d, $func, $strUrl, $curPage, $item, $gallery, $type, $com, $act;

    $id = 0;
    if (isset($_GET['id'])) $id = htmlspecialchars($_GET['id']);

    if (empty($id)) $func->transfer("Không nhận được dữ liệu", "index.php?com=variation&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);

    $item = $d->rawQueryOne("select * from #_variation where id = ? and type = ? limit 0,1", array($id, $type));

    if (empty($item)) $func->transfer("Dữ liệu không có thực", "index.php?com=variation&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
}

/* Save man */
function saveMan()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com, $act, $type;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=variation&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (isset($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        $data['denominations'] = (isset($data['denominations']) && $data['denominations'] != '') ? str_replace(",", "", $data['denominations']) : 0;

        if (!empty($data['value_type_from']) && !empty($data['value_type_to'])) {
            $denominations_from = $d->rawQueryOne("select denominations from #_variation where id = ? and type = ? limit 1", array($data['value_type_from'], 'loai-gia'));
            $denominations_to = $d->rawQueryOne("select denominations from #_variation where id = ? and type = ? limit 1", array($data['value_type_to'], 'loai-gia'));

            if (!empty($denominations_from['denominations']) && !empty($data['value_from'])) {
                $data['value_real_from'] = (!empty($denominations_from['denominations'])) ? $denominations_from['denominations'] * $data['value_from'] : 0;
            }

            if (!empty($denominations_to['denominations']) && !empty($data['value_to'])) {
                $data['value_real_to'] = (!empty($denominations_to['denominations'])) ? $denominations_to['denominations'] * $data['value_to'] : 0;
            }
        }

        $data['type'] = $type;
    }

    /* Valid data */
    if (!empty($config['variation'][$type]['list'])) {
        if (empty($data['id_list'])) {
            $response['messages'][] = 'Chưa chọn danh mục chính';
        }
    }

    if (empty($data['namevi'])) {
        $response['messages'][] = 'Tiêu đề không được trống';
    }

    if (!empty($config['variation'][$type]['date'])) {
        if (empty($data['date_filter'])) {
            $response['messages'][] = 'Số ngày không được trống';
        }

        if (!empty($data['date_filter']) && !$func->isnumber($data['date_filter'])) {
            $response['messages'][] = 'Số ngày không hợp lệ';
        }

        if (empty($data['date_comparison'])) {
            $response['messages'][] = 'Chưa chọn điều kiện lọc';
        }
    }

    if (!empty($config['variation'][$type]['denominations'])) {
        if (empty($data['denominations'])) {
            $response['messages'][] = 'Mệnh giá không được trống';
        }

        if (!empty($data['denominations']) && !$func->isDecimal($data['denominations'])) {
            $response['messages'][] = 'Mệnh giá không hợp lệ';
        }
    }

    if (!empty($config['variation'][$type]['range_value'])) {
        if (empty($data['value_from']) && empty($data['value_to'])) {
            $response['messages'][] = 'Một trong 2 giá trị từ hoặc đến không được trống hoặc bằng 0';
        }

        if (!empty($config['variation'][$type]['range_type'])) {
            if (empty($data['value_from']) && $data['value_from'] != 0) {
                $response['messages'][] = 'Giá trị từ không được trống';
            }

            if (!empty($config['variation'][$type]['range_type']) && empty($data['value_type_from'])) {
                $response['messages'][] = 'Chưa chọn đơn vị từ';
            }

            if (empty($data['value_to']) && $data['value_to'] != 0) {
                $response['messages'][] = 'Giá trị đến không được trống';
            }

            if (!empty($config['variation'][$type]['range_type']) && empty($data['value_type_to'])) {
                $response['messages'][] = 'Chưa chọn đơn vị đến';
            }
        }

        if (!empty($data['value_from']) && !$func->isDecimal($data['value_from'])) {
            $response['messages'][] = 'Giá trị từ không hợp lệ';
        }

        if (!empty($data['value_to']) && !$func->isDecimal($data['value_to'])) {
            $response['messages'][] = 'Giá trị đến không hợp lệ';
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

        if (empty($id)) {
            $func->redirect("index.php?com=variation&act=add&type=" . $type . $strUrl);
        } else {
            $func->redirect("index.php?com=variation&act=edit&id=" . $id . "&type=" . $type . $strUrl);
        }
    }

    /* Update or add data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('variation', $data)) {

            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['variation'][$type]['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_variation where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PHOTO . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('variation', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=variation&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=variation&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } else {
        $data['date_created'] = time();
        if ($d->insert('variation', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['variation'][$type]['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('variation', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=variation&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=variation&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Delete man */
function deleteMan()
{
    global $d, $strUrl, $func, $curPage, $com, $type;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id from #_variation where id = ? and type = ? limit 0,1", array($id, $type));

        if (isset($row['id']) && $row['id'] > 0) {
            $d->rawQuery("delete from #_variation where id = ?", array($id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=variation&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
        } else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=variation&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id from #_variation where id = ? and type = ? limit 0,1", array($id, $type));

            if (isset($row['id']) && $row['id'] > 0) {
                $d->rawQuery("delete from #_variation where id = ?", array($id));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=variation&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
    } else $func->transfer("Không nhận được dữ liệu", "index.php?com=variation&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
}
