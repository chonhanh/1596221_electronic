<?php
if (!defined('SOURCES')) die("Error");

switch ($act) {
    case "man":
        viewMans();
        $template = "contact/man/mans";
        break;
    case "edit":
        editMan();
        $template = "contact/man/man_add";
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

/* View contact */
function viewMans()
{
    global $d, $idShop, $prefixSector, $func, $curPage, $items, $paging;

    $where = "";

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and fullname LIKE '%$keyword%'";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_contact where id_shop = $idShop and sector_prefix = ? and id<>0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql, array($prefixSector));
    $sqlNum = "select count(*) as 'num' from #_contact where id_shop = $idShop and sector_prefix = ? and id<>0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum, array($prefixSector));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=contact&act=man";
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit contact */
function editMan()
{
    global $d, $idShop, $prefixSector, $func, $curPage, $item;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) $func->transfer("Không nhận được dữ liệu", "index.php?com=contact&act=man&p=" . $curPage, false);

    $item = $d->rawQueryOne("select * from #_contact where id_shop = $idShop and sector_prefix = ? and id = ? limit 0,1", array($prefixSector, $id));

    if (empty($item)) $func->transfer("Dữ liệu không có thực", "index.php?com=contact&act=man&p=" . $curPage, false);
}

/* Save contact */
function saveMan()
{
    global $d, $idShop, $prefixSector, $func, $flash, $curPage;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=contact&act=man&p=" . $curPage, false);

    $id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;

    /* Post dữ liệu */
    $message = '';
    $response = array();
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
    }

    /* Valid data */
    if (empty($data['fullname'])) {
        $response['messages'][] = 'Họ tên không được trống';
    }

    if (empty($data['phone'])) {
        $response['messages'][] = 'Số điện thoại không được trống';
    }

    if (!empty($data['phone']) && !$func->isPhone($data['phone'])) {
        $response['messages'][] = 'Số điện thoại không hợp lệ';
    }

    if (empty($data['address'])) {
        $response['messages'][] = 'Địa chỉ không được trống';
    }

    if (empty($data['email'])) {
        $response['messages'][] = 'Email không được trống';
    }

    if (!empty($data['email']) && !$func->isEmail($data['email'])) {
        $response['messages'][] = 'Email không hợp lệ';
    }

    if (empty($data['subject'])) {
        $response['messages'][] = 'Chủ đề không được trống';
    }

    if (empty($data['content'])) {
        $response['messages'][] = 'Nội dung không được trống';
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
        $func->redirect("index.php?com=contact&act=edit&id=" . $id);
    }

    /* Update or add data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id_shop', $idShop);
        $d->where('sector_prefix', $prefixSector);
        $d->where('id', $id);
        if ($d->update('contact', $data)) $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=contact&act=man&p=" . $curPage);
        else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=contact&act=man&p=" . $curPage, false);
    } else {
        $func->transfer("Dữ liệu rỗng", "index.php?com=contact&act=man&p=" . $curPage, false);
    }
}

/* Delete contact */
function deleteMan()
{
    global $d, $idShop, $prefixSector, $func, $curPage;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id, file_attach from #_contact where id_shop = $idShop and sector_prefix = ? and id = ? limit 0,1", array($prefixSector, $id));

        if (isset($row['id']) && $row['id'] > 0) {
            $func->deleteFile(UPLOAD_FILE . $row['file_attach']);
            $d->rawQuery("delete from #_contact where id_shop = $idShop and sector_prefix = ? and id = ?", array($prefixSector, $id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=contact&act=man&p=" . $curPage);
        } else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=contact&act=man&p=" . $curPage, false);
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id, file_attach from #_contact where id_shop = $idShop and sector_prefix = ? and id = ? limit 0,1", array($prefixSector, $id));

            if (isset($row['id']) && $row['id'] > 0) {
                $func->deleteFile(UPLOAD_FILE . $row['file_attach']);
                $d->rawQuery("delete from #_contact where id_shop = $idShop and sector_prefix = ? and id = ?", array($prefixSector, $id));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=contact&act=man&p=" . $curPage);
    } else $func->transfer("Không nhận được dữ liệu", "index.php?com=contact&act=man&p=" . $curPage, false);
}
