<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active store */
if (empty($config['store']) || (!empty($configSector) && !$func->hasShop($configSector))) {
    $func->transfer("Trang không tồn tại", "index.php", false);
}

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('id_list', 'id_cat');
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
    case "man":
        viewMans();
        $template = "store/man/mans";
        break;
    case "add":
        $template = "store/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "store/man/man_add";
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
    global $d, $func, $strUrl, $curPage, $items, $paging;

    $where = "";

    /* Lọc cấp 2 theo Group */
    if ($func->getGroup('active')) {
        $idlist = $func->getGroup('list');

        if (empty($_REQUEST['id_cat'])) {
            $idCatByGroup = $func->getGroup('cat');
        } else {
            $idcat = (!empty($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
        }
    } else {
        $idlist = (!empty($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
        $idcat = (!empty($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
    }

    if ($idlist) $where .= " and id_list=$idlist";
    if (!empty($idCatByGroup)) {
        $idcat = implode(',', $idCatByGroup);
        $where .= " and id_cat in ($idcat)";
    } else if (!empty($idcat)) {
        $where .= " and id_cat=$idcat";
    }
    if (!empty($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_store where id > 0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_store where id > 0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=store&act=man" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit man */
function editMan()
{
    global $d, $func, $strUrl, $curPage, $item;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=store&act=man&p=" . $curPage . $strUrl, false);
    }

    $item = $d->rawQueryOne("select * from #_store where id = ? limit 0,1", array($id));

    if (empty($item['id'])) {
        $func->transfer("Dữ liệu không có thực", "index.php?com=store&act=man&p=" . $curPage . $strUrl, false);
    }
}

/* Save man */
function saveMan()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com;

    /* Check empty post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=store&act=man&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        if (!empty($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
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

    if (empty($data['id_list'])) {
        $response['messages'][] = 'Chưa chọn danh mục chính';
    }

    if (empty($data['id_cat'])) {
        $response['messages'][] = 'Chưa chọn danh mục cấp 2';
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

        if (empty($id)) {
            $func->redirect("index.php?com=store&act=add" . $strUrl);
        } else {
            $func->redirect("index.php?com=store&act=edit" . $strUrl . "&id=" . $id);
        }
    }

    /* Update or add data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('store', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['store']['img_type'], UPLOAD_STORE, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_store where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_STORE . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('store', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            $d->rawQuery("delete from #_store_seo where id_parent = ?", array($id));
            $dataSeo['id_parent'] = $id;
            $d->insert('store_seo', $dataSeo);

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=store&act=man&p=" . $curPage . $strUrl);
        } else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=store&act=man&p=" . $curPage . $strUrl, false);
    } else {
        $data['date_created'] = time();

        if ($d->insert('store', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['store']['img_type'], UPLOAD_STORE, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('store', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            $dataSeo['id_parent'] = $id_insert;
            $d->insert('store_seo', $dataSeo);

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=store&act=man&p=" . $curPage . $strUrl);
        } else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=store&act=man&p=" . $curPage . $strUrl, false);
    }
}

/* Delete man */
function deleteMan()
{
    global $d, $strUrl, $func, $curPage, $com;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, id_list, photo from #_store where id = ? limit 0,1", array($id));

        if (!empty($row['id'])) {
            /* Xóa main */
            $func->deleteFile(UPLOAD_STORE . $row['photo']);
            $d->rawQuery("delete from #_store where id = ?", array($id));

            /* Xóa SEO */
            $d->rawQuery("delete from #_store_seo where id_parent = ?", array($id));

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=store&act=man&p=" . $curPage . $strUrl);
        } else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=store&act=man&p=" . $curPage . $strUrl, false);
    } elseif (!empty($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, id_list, photo from #_store where id = ? limit 0,1", array($id));

            if (!empty($row['id'])) {
                /* Xóa main */
                $func->deleteFile(UPLOAD_STORE . $row['photo']);
                $d->rawQuery("delete from #_store where id = ?", array($id));

                /* Xóa SEO */
                $d->rawQuery("delete from #_store_seo where id_parent = ?", array($id));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=store&act=man&p=" . $curPage . $strUrl);
    } else $func->transfer("Không nhận được dữ liệu", "index.php?com=store&act=man&p=" . $curPage . $strUrl, false);
}
