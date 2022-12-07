<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active news */
if (isset($config['news'])) {
    $arrCheck = array();
    foreach ($config['news'] as $k => $v) $arrCheck[] = $k;
    if (!count($arrCheck) || !in_array($type, $arrCheck)) $func->transfer("Trang không tồn tại", "index.php", false);
} else {
    $func->transfer("Trang không tồn tại", "index.php", false);
}

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$strUrl .= (isset($_REQUEST['keyword'])) ? "&keyword=" . htmlspecialchars($_REQUEST['keyword']) : "";

switch ($act) {
    case "man":
        viewMans();
        $template = "news/man/mans";
        break;
    case "add":
        $template = "news/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "news/man/man_add";
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
    global $d, $idShop, $func, $strUrl, $curPage, $items, $paging, $type;

    $where = "";

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_news where id_shop = $idShop and type = ? $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($type));
    $sqlNum = "select count(*) as 'num' from #_news where id_shop = $idShop and type = ? $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($type));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=news&act=man" . $strUrl . "&type=" . $type;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit man */
function editMan()
{
    global $d, $idShop, $strUrl, $func, $curPage, $item, $itemContent, $type, $com, $act;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);

    $item = $d->rawQueryOne("select * from #_news where id_shop = $idShop and id = ? and type = ? limit 0,1", array($id, $type));

    if (empty($item)) $func->transfer("Dữ liệu không có thực", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);

    /* Get content */
    $itemContent = $d->rawQueryOne("select * from #_news_content where id_parent = ?", array($id));
}

/* Save man */
function saveMan()
{
    global $d, $idShop, $strUrl, $func, $flash, $curPage, $config, $com, $act, $type;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    $dataContent = (!empty($_POST['dataContent'])) ? $_POST['dataContent'] : null;
    $dataSeo = (!empty($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;

    /* Check data main */
    if ($data) {
        $data['id_shop'] = $idShop;

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

        $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
        $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
        $data['type'] = $type;
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

    if (!empty($config['news'][$type]['desc'])) {
        if (empty($dataContent['descvi'])) {
            $response['messages'][] = 'Mô tả không được trống';
        }
    }

    if (!empty($config['news'][$type]['content'])) {
        if (empty($dataContent['contentvi'])) {
            $response['messages'][] = 'Nội dung không được trống';
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

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if (empty($id)) {
            $func->redirect("index.php?com=news&act=add&type=" . $type . $strUrl);
        } else {
            $func->redirect("index.php?com=news&act=edit&type=" . $type . $strUrl . "&id=" . $id);
        }
    }

    /* Save or insert data by sectors */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id_shop', $idShop);
        $d->where('id', $id);
        $d->where('type', $type);
        if ($d->update('news', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['news'][$type]['img_type'], UPLOAD_NEWS, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_news where id_shop = $idShop and id = ? and type = ? limit 0,1", array($id, $type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_NEWS . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->where('id_shop', $idShop);
                    $d->update('news', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Content */
            $d->rawQuery("delete from #_news_content where id_parent = ?", array($id));
            $dataContent['id_parent'] = $id;
            $d->insert('news_content', $dataContent);

            /* SEO */
            $d->rawQuery("delete from #_news_seo where id_parent = ?", array($id));
            $dataSeo['id_parent'] = $id;
            $d->insert('news_seo', $dataSeo);

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('news', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['news'][$type]['img_type'], UPLOAD_NEWS, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->where('id_shop', $idShop);
                    $d->update('news', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Content */
            $dataContent['id_parent'] = $id_insert;
            $d->insert('news_content', $dataContent);

            /* SEO */
            $dataSeo['id_parent'] = $id_insert;
            $d->insert('news_seo', $dataSeo);

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Delete man */
function deleteMan()
{
    global $d, $idShop, $strUrl, $func, $curPage, $com, $type;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_news where id_shop = $idShop and id = ? and type = ? limit 0,1", array($id, $type));

        if (isset($row['id']) && $row['id'] > 0) {
            /* Xóa chính */
            $func->deleteFile(UPLOAD_NEWS . $row['photo']);
            $d->rawQuery("delete from #_news where id_shop = $idShop and id = ?", array($id));

            /* Delete seo */
            $d->rawQuery("delete from #_news_seo where id_parent = ?", array($id));

            /* Delete content */
            $d->rawQuery("delete from #_news_content where id_parent = ?", array($id));

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
        } else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_news where id_shop = $idShop and id = ? and type = ? limit 0,1", array($id, $type));

            if (isset($row['id']) && $row['id'] > 0) {
                /* Xóa chính */
                $func->deleteFile(UPLOAD_NEWS . $row['photo']);
                $d->rawQuery("delete from #_news where id_shop = $idShop and id = ?", array($id));

                /* Delete seo */
                $d->rawQuery("delete from #_news_seo where id_parent = ?", array($id));

                /* Delete content */
                $d->rawQuery("delete from #_news_content where id_parent = ?", array($id));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl);
    } else $func->transfer("Không nhận được dữ liệu", "index.php?com=news&act=man&type=" . $type . "&p=" . $curPage . $strUrl, false);
}
