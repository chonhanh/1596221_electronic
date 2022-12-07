<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active places */
if (!isset($config['places']['active']) || $config['places']['active'] == false) $func->transfer("Trang không tồn tại", "index.php", false);

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('id_region', 'id_city', 'id_district', 'id_wards');
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
        /* Region */
    case "man_region":
        viewRegions();
        $template = "places/region/mans";
        break;
    case "add_region":
        $template = "places/region/man_add";
        break;
    case "edit_region":
        editRegion();
        $template = "places/region/man_add";
        break;
    case "save_region":
        saveRegion();
        break;
    case "delete_region":
        deleteRegion();
        break;

        /* City */
    case "man_city":
        viewCitys();
        $template = "places/city/mans";
        break;
    case "add_city":
        $template = "places/city/man_add";
        break;
    case "edit_city":
        editCity();
        $template = "places/city/man_add";
        break;
    case "save_city":
        saveCity();
        break;
    case "delete_city":
        deleteCity();
        break;

        /* District */
    case "man_district":
        viewDistricts();
        $template = "places/district/mans";
        break;
    case "add_district":
        $template = "places/district/man_add";
        break;
    case "edit_district":
        editDistrict();
        $template = "places/district/man_add";
        break;
    case "save_district":
        saveDistrict();
        break;
    case "delete_district":
        deleteDistrict();
        break;

        /* Wards */
    case "man_wards":
        viewWardss();
        $template = "places/wards/mans";
        break;
    case "add_wards":
        $template = "places/wards/man_add";
        break;
    case "edit_wards":
        editWards();
        $template = "places/wards/man_add";
        break;
    case "save_wards":
        saveWards();
        break;
    case "delete_wards":
        deleteWards();
        break;

    default:
        $template = "404";
}

/* View region */
function viewRegions()
{
    global $d, $func, $strUrl, $curPage, $items, $paging;

    $where = "";

    if ($func->getGroup('active')) {
        /* Lọc region theo Group */
        $id_regions = $func->getGroup('regions');
        if ($id_regions) $where .= " and id in ($id_regions)";
    }

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (name LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_region where id<>0 $where order by numb,id asc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_region where id<>0 $where order by numb,id asc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=places" . $strUrl . "&act=man_region";
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit region */
function editRegion()
{
    global $d, $strUrl, $func, $curPage, $item;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) $func->transfer("Không nhận được dữ liệu", "index.php?com=places&act=man_region&p=" . $curPage . $strUrl, false);

    $item = $d->rawQueryOne("select * from #_region where id = ? limit 0,1", array($id));

    if (empty($item)) $func->transfer("Dữ liệu không có thực", "index.php?com=places&act=man_region&p=" . $curPage . $strUrl, false);
}

/* Save region */
function saveRegion()
{
    global $d, $func, $flash, $strUrl, $curPage;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=places&act=man_region&p=" . $curPage . $strUrl, false);

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

        $data['slug'] = (!empty($data['name'])) ? $func->changeTitle($data['name']) : '';
    }

    /* Valid data */
    if (empty($data['name'])) {
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

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if (empty($id)) {
            $func->redirect("index.php?com=places&act=add_region" . $strUrl);
        } else {
            $func->redirect("index.php?com=places&act=edit_region" . $strUrl . "&id=" . $id);
        }
    }

    /* Update or add data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('region', $data)) {
            /* Write json */
            $dataJson = array('type' => 'region');
            $func->writeJson($dataJson);

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=places&act=man_region&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=places&act=man_region&p=" . $curPage . $strUrl, false);
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('region', $data)) {
            /* Write json */
            $dataJson = array('type' => 'region');
            $func->writeJson($dataJson);

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=places&act=man_region&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=places&act=man_region&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Delete region */
function deleteRegion()
{
    global $d, $func, $strUrl, $curPage;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id from #_region where id = ? limit 0,1", array($id));

        if (isset($row['id']) && $row['id'] > 0) {
            $d->rawQuery("delete from #_region where id = ?", array($id));

            /* Write json */
            $dataJson = array('type' => 'region');
            $func->writeJson($dataJson);

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=places&act=man_region&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=places&act=man_region&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id from #_region where id = ? limit 0,1", array($id));

            if (isset($row['id']) && $row['id'] > 0) {
                $d->rawQuery("delete from #_region where id = ?", array($id));

                /* Write json */
                $dataJson = array('type' => 'region');
                $func->writeJson($dataJson);
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=places&act=man_region&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=places&act=man_region&p=" . $curPage . $strUrl, false);
    }
}

/* View city */
function viewCitys()
{
    global $d, $func, $strUrl, $curPage, $items, $paging;

    $where = "";

    $id_region = (isset($_REQUEST['id_region'])) ? htmlspecialchars($_REQUEST['id_region']) : 0;
    if ($id_region) $where .= " and id_region=$id_region";

    if ($func->getGroup('active')) {
        /* Lọc city theo Group */
        $id_citys = $func->getGroup('citys');
        if ($id_citys) $where .= " and id in ($id_citys)";
    }

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (name LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_city where id<>0 $where order by numb,id asc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_city where id<>0 $where order by numb,id asc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=places" . $strUrl . "&act=man_city";
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit city */
function editCity()
{
    global $d, $strUrl, $func, $curPage, $item;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) $func->transfer("Không nhận được dữ liệu", "index.php?com=places&act=man_city&p=" . $curPage . $strUrl, false);

    $item = $d->rawQueryOne("select * from #_city where id = ? limit 0,1", array($id));

    if (empty($item)) $func->transfer("Dữ liệu không có thực", "index.php?com=places&act=man_city&p=" . $curPage . $strUrl, false);
}

/* Save city */
function saveCity()
{
    global $d, $func, $flash, $strUrl, $curPage, $config;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=places&act=man_city&p=" . $curPage . $strUrl, false);

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

        $data['slug'] = (!empty($data['name'])) ? $func->changeTitle($data['name']) : '';
    }

    /* Valid data */
    if (empty($data['id_region'])) {
        $response['messages'][] = 'Chưa chọn vùng/miền';
    }

    if (empty($data['name'])) {
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

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if (empty($id)) {
            $func->redirect("index.php?com=places&act=add_city" . $strUrl);
        } else {
            $func->redirect("index.php?com=places&act=edit_city" . $strUrl . "&id=" . $id);
        }
    }

    /* Update or add data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('city', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['places']['city']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_city where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PHOTO . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('city', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Write json */
            $dataJson = array('type' => 'city');
            $func->writeJson($dataJson);

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=places&act=man_city&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=places&act=man_city&p=" . $curPage . $strUrl, false);
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('city', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['places']['city']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('city', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Write json */
            $dataJson = array('type' => 'city');
            $func->writeJson($dataJson);

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=places&act=man_city&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=places&act=man_city&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Delete city */
function deleteCity()
{
    global $d, $func, $strUrl, $curPage;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id, photo from #_city where id = ? limit 0,1", array($id));

        if (isset($row['id']) && $row['id'] > 0) {
            $func->deleteFile(UPLOAD_PHOTO . $row['photo']);
            $d->rawQuery("delete from #_city where id = ?", array($id));

            /* Write json */
            $dataJson = array('type' => 'city');
            $func->writeJson($dataJson);

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=places&act=man_city&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=places&act=man_city&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id, photo from #_city where id = ? limit 0,1", array($id));

            if (isset($row['id']) && $row['id'] > 0) {
                $func->deleteFile(UPLOAD_PHOTO . $row['photo']);
                $d->rawQuery("delete from #_city where id = ?", array($id));

                /* Write json */
                $dataJson = array('type' => 'city');
                $func->writeJson($dataJson);
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=places&act=man_city&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=places&act=man_city&p=" . $curPage . $strUrl, false);
    }
}

/* View district */
function viewDistricts()
{
    global $d, $func, $strUrl, $curPage, $items, $paging;

    $where = "";

    $id_region = (isset($_REQUEST['id_region'])) ? htmlspecialchars($_REQUEST['id_region']) : 0;
    $id_city = (isset($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;

    if ($id_region) $where .= " and id_region=$id_region";
    if ($id_city) $where .= " and id_city=$id_city";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (name LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_district where id<>0 $where order by numb,id asc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_district where id<>0 $where order by numb,id asc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=places" . $strUrl . "&act=man_district";
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit district */
function editDistrict()
{
    global $d, $func, $strUrl, $curPage, $item;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    $where = '';

    if (empty($id)) $func->transfer("Không nhận được dữ liệu", "index.php?com=places&act=man_district&p=" . $curPage . $strUrl, false);

    if ($func->getGroup('active')) {
        /* Lọc region theo Group */
        $id_regions = $func->getGroup('regions');
        if ($id_regions) $where .= " and id_region in ($id_regions)";

        /* Lọc city theo Group */
        $id_citys = $func->getGroup('citys');
        if ($id_citys) $where .= " and id_city in ($id_citys)";
    }

    $item = $d->rawQueryOne("select * from #_district where id = ? $where limit 0,1", array($id));

    if (empty($item)) $func->transfer("Dữ liệu không có thực", "index.php?com=places&act=man_district&p=" . $curPage . $strUrl, false);
}

/* Save district */
function saveDistrict()
{
    global $d, $func, $flash, $strUrl, $curPage;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=places&act=man_district&p=" . $curPage . $strUrl, false);

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

        $data['slug'] = (!empty($data['name'])) ? $func->changeTitle($data['name']) : '';
    }

    /* Valid data */
    if (empty($data['id_region'])) {
        $response['messages'][] = 'Chưa chọn vùng/miền';
    }

    if (empty($data['id_city'])) {
        $response['messages'][] = 'Chưa chọn tỉnh/thành phố';
    }

    if (empty($data['name'])) {
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

        /* Errors */
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if (empty($id)) {
            $func->redirect("index.php?com=places&act=add_district" . $strUrl);
        } else {
            $func->redirect("index.php?com=places&act=edit_district" . $strUrl . "&id=" . $id);
        }
    }

    /* Update or add data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('district', $data)) {
            /* Write json */
            $dataJson = array('type' => 'district', 'idCity' => $data['id_city']);
            $func->writeJson($dataJson);

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=places&act=man_district&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=places&act=man_district&p=" . $curPage . $strUrl, false);
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('district', $data)) {
            /* Write json */
            $dataJson = array('type' => 'district', 'idCity' => $data['id_city']);
            $func->writeJson($dataJson);

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=places&act=man_district&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=places&act=man_district&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Delete district */
function deleteDistrict()
{
    global $d, $func, $strUrl, $curPage;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id, id_city from #_district where id = ? limit 0,1", array($id));

        if (isset($row['id']) && $row['id'] > 0) {
            /* Data json */
            $dataJson = array('type' => 'district', 'idCity' => $row['id_city']);

            /* Xóa main */
            $d->rawQuery("delete from #_district where id = ?", array($id));

            /* Write json */
            $func->writeJson($dataJson);

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=places&act=man_district&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=places&act=man_district&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id, id_city from #_district where id = ? limit 0,1", array($id));

            if (isset($row['id']) && $row['id'] > 0) {
                /* Data json */
                $dataJson = array('type' => 'district', 'idCity' => $row['id_city']);

                /* Xóa main */
                $d->rawQuery("delete from #_district where id = ?", array($id));

                /* Write json */
                $func->writeJson($dataJson);
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=places&act=man_district&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=places&act=man_district&p=" . $curPage . $strUrl, false);
    }
}

/* View wards */
function viewWardss()
{
    global $d, $func, $strUrl, $curPage, $items, $paging;

    $where = "";

    $id_region = (isset($_REQUEST['id_region'])) ? htmlspecialchars($_REQUEST['id_region']) : 0;
    $id_city = (isset($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
    $id_district = (isset($_REQUEST['id_district'])) ? htmlspecialchars($_REQUEST['id_district']) : 0;

    if ($id_region) $where .= " and id_region=$id_region";
    if ($id_city) $where .= " and id_city=$id_city";
    if ($id_district) $where .= " and id_district=$id_district";
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (name LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_wards where id<>0 $where order by numb,id asc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_wards where id<>0 $where order by numb,id asc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=places" . $strUrl . "&act=man_wards";
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit wards */
function editWards()
{
    global $d, $func, $strUrl, $curPage, $item;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    $where = '';

    if (empty($id)) $func->transfer("Không nhận được dữ liệu", "index.php?com=places&act=man_wards&p=" . $curPage . $strUrl, false);

    if ($func->getGroup('active')) {
        /* Lọc region theo Group */
        $id_regions = $func->getGroup('regions');
        if ($id_regions) $where .= " and id_region in ($id_regions)";

        /* Lọc city theo Group */
        $id_citys = $func->getGroup('citys');
        if ($id_citys) $where .= " and id_city in ($id_citys)";
    }

    $item = $d->rawQueryOne("select * from #_wards where id = ? $where limit 0,1", array($id));

    if (empty($item)) $func->transfer("Dữ liệu không có thực", "index.php?com=places&act=man_wards&p=" . $curPage . $strUrl, false);
}

/* Save wards */
function saveWards()
{
    global $d, $func, $flash, $strUrl, $curPage, $config;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=places&act=man_wards&p=" . $curPage . $strUrl, false);

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

        $data['slug'] = (!empty($data['name'])) ? $func->changeTitle($data['name']) : '';
        $data['ship_price'] = (!empty($data['ship_price'])) ? str_replace(",", "", $data['ship_price']) : 0;
    }

    /* Valid data */
    if (empty($data['id_region'])) {
        $response['messages'][] = 'Chưa chọn vùng/miền';
    }

    if (empty($data['id_city'])) {
        $response['messages'][] = 'Chưa chọn tỉnh/thành phố';
    }

    if (empty($data['id_district'])) {
        $response['messages'][] = 'Chưa chọn quận/huyện';
    }

    if (empty($data['name'])) {
        $response['messages'][] = 'Tiêu đề không được trống';
    }

    if (!empty($data['ship_price']) && !$func->isNumber($data['ship_price'])) {
        $response['messages'][] = 'Phí vận chuyển không hợp lệ';
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
            $func->redirect("index.php?com=places&act=add_wards" . $strUrl);
        } else {
            $func->redirect("index.php?com=places&act=edit_wards" . $strUrl . "&id=" . $id);
        }
    }

    /* Update or add data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('wards', $data)) {
            /* Write json */
            $dataJson = array('type' => 'wards', 'idCity' => $data['id_city'], 'idDistrict' => $data['id_district']);
            $func->writeJson($dataJson);

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=places&act=man_wards&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=places&act=man_wards&p=" . $curPage . $strUrl, false);
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('wards', $data)) {
            /* Write json */
            $dataJson = array('type' => 'wards', 'idCity' => $data['id_city'], 'idDistrict' => $data['id_district']);
            $func->writeJson($dataJson);

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=places&act=man_wards&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=places&act=man_wards&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Delete wards */
function deleteWards()
{
    global $d, $func, $strUrl, $curPage;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id, id_city, id_district from #_wards where id = ? limit 0,1", array($id));

        if (isset($row['id']) && $row['id'] > 0) {
            /* Data json */
            $dataJson = array('type' => 'wards', 'idCity' => $row['id_city'], 'idDistrict' => $row['id_district']);

            /* Xóa main */
            $d->rawQuery("delete from #_wards where id = ?", array($id));

            /* Write json */
            $func->writeJson($dataJson);

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=places&act=man_wards&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=places&act=man_wards&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id, id_city, id_district from #_wards where id = ? limit 0,1", array($id));

            if (isset($row['id']) && $row['id'] > 0) {
                /* Data json */
                $dataJson = array('type' => 'wards', 'idCity' => $row['id_city'], 'idDistrict' => $row['id_district']);

                /* Xóa main */
                $d->rawQuery("delete from #_wards where id = ?", array($id));

                /* Write json */
                $func->writeJson($dataJson);
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=places&act=man_wards&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=places&act=man_wards&p=" . $curPage . $strUrl, false);
    }
}
