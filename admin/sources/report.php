<?php
if (!defined('SOURCES')) die("Error");

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$strUrl .= (isset($_REQUEST['keyword'])) ? "&keyword=" . htmlspecialchars($_REQUEST['keyword']) : "";

switch ($act) {
        /* Status */
    case "man":
        viewMans();
        $template = "report/man/mans";
        break;
    case "add":
        $template = "report/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "report/man/man_add";
        break;
    case "save":
        saveMan();
        break;
    case "delete":
        deleteMan();
        break;

        /* Posting */
    case "man_report_posting":
        viewMansPostings();
        $template = "report/man_report_posting/mans";
        break;
    case "edit_report_posting":
        editManPosting();
        $template = "report/man_report_posting/man_add";
        break;
    case "save_report_posting":
        saveManPosting();
        break;
    case "delete_report_posting":
        deleteManPosting();
        break;

        /* Shop */
    case "man_report_shop":
        viewMansShops();
        $template = "report/man_report_shop/mans";
        break;
    case "edit_report_shop":
        editManShop();
        $template = "report/man_report_shop/man_add";
        break;
    case "save_report_shop":
        saveManShop();
        break;
    case "delete_report_shop":
        deleteManShop();
        break;

        /* Default */
    default:
        $template = "404";
}

/* View man */
function viewMans()
{
    global $d, $func, $strUrl, $curPage, $items, $paging;

    $where = "";

    if (!empty($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_report_status where id > 0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_report_status where id > 0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=report&act=man" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit man */
function editMan()
{
    global $d, $func, $strUrl, $curPage, $item;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=report&act=man&p=" . $curPage . $strUrl, false);
    }

    $item = $d->rawQueryOne("select * from #_report_status where id = ? limit 0,1", array($id));

    if (empty($item['id'])) {
        $func->transfer("Dữ liệu không có thực", "index.php?com=report&act=man&p=" . $curPage . $strUrl, false);
    }
}

/* Save man */
function saveMan()
{
    global $d, $strUrl, $func, $flash, $curPage, $com;

    /* Check empty post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=report&act=man&p=" . $curPage . $strUrl, false);
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
    }

    /* Valid data */
    if (empty($data['namevi'])) {
        $response['messages'][] = 'Tiêu đề không được trống';
    }

    if (empty($data['descvi'])) {
        $response['messages'][] = 'Mô tả không được trống';
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
            $func->redirect("index.php?com=report&act=add" . $strUrl);
        } else {
            $func->redirect("index.php?com=report&act=edit" . $strUrl . "&id=" . $id);
        }
    }

    /* Update or add data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('report_status', $data)) $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=report&act=man&p=" . $curPage . $strUrl);
        else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=report&act=man&p=" . $curPage . $strUrl, false);
    } else {
        $data['date_created'] = time();

        if ($d->insert('report_status', $data)) $func->transfer("Lưu dữ liệu thành công", "index.php?com=report&act=man&p=" . $curPage . $strUrl);
        else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=report&act=man&p=" . $curPage . $strUrl, false);
    }
}

/* Delete man */
function deleteMan()
{
    global $d, $strUrl, $func, $curPage, $com;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id from #_report_status where id = ? limit 0,1", array($id));

        if (!empty($row['id'])) {
            $d->rawQuery("delete from #_report_status where id = ?", array($id));
            $func->transfer("Xóa dữ liệu thành công", "index.php?com=report&act=man&p=" . $curPage . $strUrl);
        } else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=report&act=man&p=" . $curPage . $strUrl, false);
    } elseif (!empty($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id from #_report_status where id = ? limit 0,1", array($id));

            if (!empty($row['id'])) {
                $d->rawQuery("delete from #_report_status where id = ?", array($id));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=report&act=man&p=" . $curPage . $strUrl);
    } else $func->transfer("Không nhận được dữ liệu", "index.php?com=report&act=man&p=" . $curPage . $strUrl, false);
}

/* View man posting */
function viewMansPostings()
{
    global $d, $func, $id_list, $strUrl, $curPage, $items, $paging, $configSector;

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        $where = "";

        if (!empty($_REQUEST['keyword'])) {
            $keyword = htmlspecialchars($_REQUEST['keyword']);
            $where .= " and (A.namevi LIKE '%$keyword%' or A.slugvi LIKE '%$keyword%')";
        }

        $perPage = 10;
        $startpoint = ($curPage * $perPage) - $perPage;
        $limit = " limit " . $startpoint . "," . $perPage;
        $sql = "select A.namevi as productName, B.id as id, B.id_shop as id_shop, B.numb as numb, B.status as status, B.date_created as date_created, B.date_locked as date_locked, B.date_unlock as date_unlock from #_" . $configSector['tables']['main'] . " as A, #_" . $configSector['tables']['report-product'] . " as B where A.id = B.id_product $where order by B.numb,B.id desc $limit";
        $items = $d->rawQuery($sql);
        $sqlNum = "select count(*) as 'num' from #_" . $configSector['tables']['main'] . " as A, #_" . $configSector['tables']['report-product'] . " as B where A.id = B.id_product $where order by B.numb,B.id desc";
        $count = $d->rawQueryOne($sqlNum);
        $total = (!empty($count)) ? $count['num'] : 0;
        $url = "index.php?com=report&act=man_report_posting&id_list=" . $id_list . $strUrl;
        $paging = $func->pagination($total, $perPage, $curPage, $url);
    }
}

/* Edit man posting */
function editManPosting()
{
    global $d, $func, $id_list, $strUrl, $curPage, $curPageChild, $item, $paging, $configSector, $reportInfo, $productDetail;

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        /* ID data */
        $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
        $id_shop = (!empty($_GET['id_shop'])) ? htmlspecialchars($_GET['id_shop']) : 0;
        $id_product = (!empty($_GET['id_product'])) ? htmlspecialchars($_GET['id_product']) : 0;
        $where = '';

        if (empty($id) && empty($id_product)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=report&act=man_report_posting&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
        }

        /* Condition to get data from Report page or Product page */
        if (!empty($id)) {
            $where = 'id = ' . $id;
        } else if (!empty($id_product)) {
            $where = 'id_product = ' . $id_product;

            if (!empty($id_shop)) {
                $where .= ' and id_shop = ' . $id_shop;
            }
        }

        /* Get data detail */
        $item = $d->rawQueryOne("select * from #_" . $configSector['tables']['report-product'] . " where $where limit 0,1");

        /* Check data detail */
        if (!empty($item)) {
            /* Get variant detail */
            $productDetail = $d->rawQueryOne("select id, id_list, id_cat, id_item, id_sub, id_region, id_city, id_district, id_wards, namevi, slugvi, photo from #_" . $configSector['tables']['main'] . " where id = ? limit 0,1", array($item['id_product']));

            /* Get report info */
            if (!empty($productDetail)) {
                $perPage = 5;
                $startpoint = ($curPageChild * $perPage) - $perPage;
                $limit = " limit " . $startpoint . "," . $perPage;
                $sql = "select A.id as id, A.fullname as fullname, A.phone as phone, A.email as email, A.content as content, B.namevi as statusName from #_" . $configSector['tables']['report-product-info'] . " as A, #_report_status as B where A.id_parent = ? and A.id_status = B.id order by A.id desc $limit";
                $reportInfo = $d->rawQuery($sql, array($item['id']));
                $sqlNum = "select count(*) as 'num' from #_" . $configSector['tables']['report-product-info'] . " as A, #_report_status as B where A.id_parent = ? and A.id_status = B.id order by A.id desc";
                $count = $d->rawQueryOne($sqlNum, array($item['id']));
                $total = (!empty($count)) ? $count['num'] : 0;
                $url = "index.php?com=report&act=edit_report_posting&id_list=" . $id_list . "&p=" . $curPage . "&id=" . $id;
                $paging = $func->pagination($total, $perPage, $curPageChild, $url, 'pchild');
            } else {
                $func->transfer("Dữ liệu không có thực", "index.php?com=report&act=man_report_posting&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
            }
        } else {
            $func->transfer("Dữ liệu không có thực", "index.php?com=report&act=man_report_posting&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Save man posting */
function saveManPosting()
{
    global $d, $strUrl, $id_list, $act, $func, $flash, $curPage, $configSector;

    /* Check action post */
    $action = (!empty($_POST['submit-report'])) ? htmlspecialchars($_POST['submit-report']) : '';

    /* Check empty post */
    if (empty($action)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=report&act=man_report_posting&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
    }

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        /* Post data */
        $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;

        /* Get data detail */
        $item = $d->rawQueryOne("select * from #_" . $configSector['tables']['report-product'] . " where id = ? limit 0,1", array($id));

        /* Data */
        if (in_array($action, array('lock', 'banned'))) {
            $message = '';
            $response = array();
            $data = (!empty($_POST['data'])) ? $_POST['data'] : array();

            if ($data) {
                foreach ($data as $column => $value) {
                    $data[$column] = htmlspecialchars($func->sanitize($value));
                }
            }

            /* Valid data */
            if (empty($data['note'])) {
                $response['messages'][] = 'Mô tả thông tin không được trống';
            }

            if (!empty($response)) {
                $response['status'] = 'danger';
                $message = base64_encode(json_encode($response));
                $flash->set('message', $message);
                $func->redirect("index.php?com=report&act=edit_report_posting&id_list=" . $id_list . "&id=" . $id);
            }
        }

        /* Lock action */
        if ($action == 'lock') {
            /* Data report */
            $data['date_locked'] = time();
            $data['status'] = 1;
            $data['count_locked'] = $item['count_locked'] + 1;

            /* Data send report */
            $dataSendReport = array();
            $dataSendReport['lock'] = true;

            /* Data variant */
            $dataVariant = array();
            $dataVariant['status'] = 'dangsai';
        } else if ($action == 'unlock') /* Unlock action */ {
            /* Data report */
            $data['date_unlock'] = time();
            $data['note'] = '';
            $data['status'] = 2;
            $data['count_unlock'] = $item['count_unlock'] + 1;

            /* Data send report */
            $dataSendReport = array();
            $dataSendReport['unlock'] = true;

            /* Data variant */
            $dataVariant = array();
            $dataVariant['status'] = 'xetduyet';
        } else if ($action == 'banned') /* Banned action */ {
            /* Data report */
            $data['date_banned'] = time();
            $data['status'] = 3;
            $data['count_banned'] = $item['count_banned'] + 1;

            /* Data send report */
            $dataSendReport = array();
            $dataSendReport['banned'] = true;

            /* Data variant */
            $dataVariant = array();
            $dataVariant['status'] = 'vipham';
        }

        /* Check data detail */
        if (!empty($item)) {
            /* Get variant detail */
            $productDetail = $d->rawQueryOne("select id, id_shop, id_member, id_admin, id_list, id_cat, id_item, id_sub, id_region, id_city, id_district, id_wards, namevi, slugvi, id from #_" . $configSector['tables']['main'] . " where id = ? limit 0,1", array($item['id_product']));

            if (!empty($productDetail)) {
                /* Get sector */
                $productDetail['sectorInfo']['id'] = $configSector['id'];
                $productDetail['sectorInfo']['name'] = $configSector['name'];
                $productDetail['sectorInfo']['slug'] = $configSector['type'];

                /* Get info poster */
                if (!empty($productDetail['id_shop'])) {
                    $shopDetail = $d->rawQueryOne("select id, id_member, id_admin, name, slug_url from #_" . $configSector['tables']['shop'] . " where id = ?  limit 0, 1", array($item['id_shop']));

                    if (!empty($shopDetail['id_member'])) {
                        /* Get owner Member */
                        $userInfo = $d->rawQueryOne("select fullname, phone, email, address from #_member where id = ?", array($shopDetail['id_member']));
                    } else {
                        /* Get owner Admin */
                        $userInfo = $d->rawQueryOne("select fullname, phone, email, address from #_user where id = ?", array($shopDetail['id_admin']));
                    }
                } else {
                    if (!empty($productDetail['id_member'])) {
                        $userInfo = $d->rawQueryOne("select fullname, email from #_member where id = ? limit 0,1", array($productDetail['id_member']));
                    } else {
                        $userInfo = $d->rawQueryOne("select fullname, email from #_user where id = ? limit 0,1", array($productDetail['id_admin']));
                    }
                }

                /* Send email report */
                if (!empty($userInfo)) {
                    $dataSendReport['variant'] = 'product';
                    $dataSendReport['note'] = (!empty($data['note'])) ? $data['note'] : '';
                    $dataSendReport['productData'] = $productDetail;
                    $dataSendReport['shopData'] = (!empty($shopDetail)) ? $shopDetail : array();
                    $dataSendReport['userData'] = $userInfo;

                    /* Send report */
                    if (sendReport($dataSendReport)) {
                        /* Update status */
                        $d->where('id', $id);
                        $d->update($configSector['tables']['report-product'], $data);

                        /* Update product */
                        $d->where('id', $productDetail['id']);
                        $d->update($configSector['tables']['main'], $dataVariant);

                        if (!empty($dataSendReport['lock'])) {
                            $func->transfer("Đã chặn tin thành công", "index.php?com=report&act=edit_report_posting&id_list=" . $id_list . "&id=" . $id . "&p=" . $curPage . $strUrl);
                        } else if (!empty($dataSendReport['unlock'])) {
                            $func->transfer("Đã mở tin thành công", "index.php?com=report&act=edit_report_posting&id_list=" . $id_list . "&id=" . $id . "&p=" . $curPage . $strUrl);
                        } else if (!empty($dataSendReport['banned'])) {
                            $func->transfer("Đã khóa tin thành công", "index.php?com=report&act=edit_report_posting&id_list=" . $id_list . "&id=" . $id . "&p=" . $curPage . $strUrl);
                        }
                    } else {
                        if (!empty($dataSendReport['lock'])) {
                            $func->transfer("Đã chặn tin thất bại", "index.php?com=report&act=edit_report_posting&id_list=" . $id_list . "&id=" . $id . "&p=" . $curPage . $strUrl, false);
                        } else if (!empty($dataSendReport['unlock'])) {
                            $func->transfer("Đã mở tin thất bại", "index.php?com=report&act=edit_report_posting&id_list=" . $id_list . "&id=" . $id . "&p=" . $curPage . $strUrl, false);
                        } else if (!empty($dataSendReport['banned'])) {
                            $func->transfer("Đã khóa tin thất bại", "index.php?com=report&act=edit_report_posting&id_list=" . $id_list . "&id=" . $id . "&p=" . $curPage . $strUrl, false);
                        }
                    }
                } else {
                    $func->transfer("Dữ liệu chủ sở hữu không hợp lệ", "index.php?com=report&act=man_report_posting&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
                }
            } else {
                $func->transfer("Dữ liệu không có thực", "index.php?com=report&act=man_report_posting&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
            }
        } else {
            $func->transfer("Dữ liệu không có thực", "index.php?com=report&act=man_report_posting&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Delete man posting */
function deleteManPosting()
{
    global $d, $strUrl, $id_list, $func, $configSector, $curPage;

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        /* ID data */
        $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

        if ($id) {
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, status from #_" . $configSector['tables']['report-product'] . " where id = ? limit 0,1", array($id));

            if (!empty($row['id'])) {
                /* Kiểm tra tình trạng */
                if ($row['status'] == 2) {
                    $d->rawQuery("delete from #_" . $configSector['tables']['report-product'] . " where id = ?", array($id));
                    $d->rawQuery("delete from #_" . $configSector['tables']['report-product-info'] . " where id_parent = ?", array($id));

                    $func->transfer("Xóa dữ liệu thành công", "index.php?com=report&act=man_report_posting&id_list=" . $id_list . "&p=" . $curPage . $strUrl);
                } else {
                    $func->transfer("Không thể xóa dữ liệu. Tin đăng trong mục này đang trong trạng thái <strong>Chờ duyệt/Đăng Sai/Vi Phạm</strong>", "index.php?com=report&act=man_report_posting&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
                }
            } else {
                $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=report&act=man_report_posting&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
            }
        } elseif (!empty($_GET['listid'])) {
            $listid = explode(",", $_GET['listid']);
            $isInValid = false;

            for ($i = 0; $i < count($listid); $i++) {
                $id = htmlspecialchars($listid[$i]);

                /* Lấy dữ liệu */
                $row = $d->rawQueryOne("select id, status from #_" . $configSector['tables']['report-product'] . " where id = ? limit 0,1", array($id));

                if (!empty($row['id'])) {
                    /* Kiểm tra tình trạng */
                    if ($row['status'] == 2) {
                        $d->rawQuery("delete from #_" . $configSector['tables']['report-product'] . " where id = ?", array($id));
                        $d->rawQuery("delete from #_" . $configSector['tables']['report-product-info'] . " where id_parent = ?", array($id));
                    } else {
                        $isInValid = true;
                    }
                }
            }

            /* Thông báo dựa trên tình trạng */
            if ($isInValid) {
                $func->transfer("Xóa dữ liệu thành công. Một số mục không thể xóa do tin đăng trong các mục đó còn ở trạng thái <strong>Chờ duyệt/Đăng Sai/Vi Phạm</strong>", "index.php?com=report&act=man_report_posting&id_list=" . $id_list . "&p=" . $curPage . $strUrl);
            } else {
                $func->transfer("Xóa dữ liệu thành công", "index.php?com=report&act=man_report_posting&id_list=" . $id_list . "&p=" . $curPage . $strUrl);
            }
        } else {
            $func->transfer("Không nhận được dữ liệu", "index.php?com=report&act=man_report_posting&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
        }
    }
}

/* View man shop */
function viewMansShops()
{
    global $d, $func, $id_list, $strUrl, $curPage, $items, $paging, $configSector;

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        if (!$func->hasShop($configSector)) {
            $func->transfer("Trang không tồn tại", "index.php", false);
        } else {
            $where = "";

            if (!empty($_REQUEST['keyword'])) {
                $keyword = htmlspecialchars($_REQUEST['keyword']);
                $where .= " and (A.name LIKE '%$keyword%')";
            }

            $perPage = 10;
            $startpoint = ($curPage * $perPage) - $perPage;
            $limit = " limit " . $startpoint . "," . $perPage;
            $sql = "select A.name as shopName, B.id as id, B.id_shop as id_shop, B.numb as numb, B.status as status, B.date_created as date_created, B.date_locked as date_locked, B.date_unlock as date_unlock from #_" . $configSector['tables']['shop'] . " as A, #_" . $configSector['tables']['report-shop'] . " as B where A.id = B.id_shop $where order by B.numb,B.id desc $limit";
            $items = $d->rawQuery($sql);
            $sqlNum = "select count(*) as 'num' from #_" . $configSector['tables']['shop'] . " as A, #_" . $configSector['tables']['report-shop'] . " as B where A.id = B.id_shop $where order by B.numb,B.id desc";
            $count = $d->rawQueryOne($sqlNum);
            $total = (!empty($count)) ? $count['num'] : 0;
            $url = "index.php?com=report&act=man_report_shop&id_list=" . $id_list . $strUrl;
            $paging = $func->pagination($total, $perPage, $curPage, $url);
        }
    }
}

/* Edit man shop */
function editManShop()
{
    global $d, $func, $id_list, $strUrl, $curPage, $curPageChild, $item, $paging, $configSector, $reportInfo, $shopDetail;

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        if (!$func->hasShop($configSector)) {
            $func->transfer("Trang không tồn tại", "index.php", false);
        } else {
            /* ID data */
            $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
            $id_shop = (!empty($_GET['id_shop'])) ? htmlspecialchars($_GET['id_shop']) : 0;
            $where = '';

            if (empty($id) && empty($id_shop)) {
                $func->transfer("Dữ liệu không có thực", "index.php?com=report&act=man_report_posting&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
            }

            /* Condition to get data from Report page or Product page */
            if (!empty($id)) {
                $where = 'id = ' . $id;
            } else if (!empty($id_shop)) {
                $where = ' id_shop = ' . $id_shop;
            }

            /* Get data detail */
            $item = $d->rawQueryOne("select * from #_" . $configSector['tables']['report-shop'] . " where $where limit 0,1");

            /* Check data detail */
            if (!empty($item)) {
                /* Get shop detail */
                $shopDetail = $d->rawQueryOne("select id, id_list, id_cat, id_region, id_city, id_district, id_wards, name, slug_url, photo from #_" . $configSector['tables']['shop'] . " where id = ? limit 0,1", array($item['id_shop']));

                /* Get report info */
                if (!empty($shopDetail)) {
                    $perPage = 5;
                    $startpoint = ($curPageChild * $perPage) - $perPage;
                    $limit = " limit " . $startpoint . "," . $perPage;
                    $sql = "select A.id as id, A.fullname as fullname, A.phone as phone, A.email as email, A.content as content, B.namevi as statusName from #_" . $configSector['tables']['report-shop-info'] . " as A, #_report_status as B where A.id_parent = ? and A.id_status = B.id order by A.id desc $limit";
                    $reportInfo = $d->rawQuery($sql, array($item['id']));
                    $sqlNum = "select count(*) as 'num' from #_" . $configSector['tables']['report-shop-info'] . " as A, #_report_status as B where A.id_parent = ? and A.id_status = B.id order by A.id desc";
                    $count = $d->rawQueryOne($sqlNum, array($item['id']));
                    $total = (!empty($count)) ? $count['num'] : 0;
                    $url = "index.php?com=report&act=edit_report_shop&id_list=" . $id_list . "&p=" . $curPage . "&id=" . $id;
                    $paging = $func->pagination($total, $perPage, $curPageChild, $url, 'pchild');
                } else {
                    $func->transfer("Dữ liệu không có thực", "index.php?com=report&act=man_report_shop&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
                }
            } else {
                $func->transfer("Dữ liệu không có thực", "index.php?com=report&act=man_report_shop&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
            }
        }
    }
}

/* Save man shop */
function saveManShop()
{
    global $d, $strUrl, $id_list, $act, $func, $flash, $curPage, $configSector;

    /* Check action post */
    $action = (!empty($_POST['submit-report'])) ? htmlspecialchars($_POST['submit-report']) : '';

    /* Check empty post */
    if (empty($action)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=report&act=man_report_shop&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
    }

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        if (!$func->hasShop($configSector)) {
            $func->transfer("Trang không tồn tại", "index.php", false);
        }

        /* Post data */
        $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;

        /* Get data detail */
        $item = $d->rawQueryOne("select * from #_" . $configSector['tables']['report-shop'] . " where id = ? limit 0,1", array($id));

        /* Data */
        if (in_array($action, array('lock', 'banned'))) {
            $message = '';
            $response = array();
            $data = (!empty($_POST['data'])) ? $_POST['data'] : array();

            if ($data) {
                foreach ($data as $column => $value) {
                    $data[$column] = htmlspecialchars($func->sanitize($value));
                }
            }

            /* Valid data */
            if (empty($data['note'])) {
                $response['messages'][] = 'Mô tả thông tin không được trống';
            }

            if (!empty($response)) {
                $response['status'] = 'danger';
                $message = base64_encode(json_encode($response));
                $flash->set('message', $message);
                $func->redirect("index.php?com=report&act=edit_report_shop&id_list=" . $id_list . "&id=" . $id);
            }
        }

        /* Lock action */
        if ($action == 'lock') {
            /* Data report */
            $data['date_locked'] = time();
            $data['status'] = 1;
            $data['count_locked'] = $item['count_locked'] + 1;

            /* Data send report */
            $dataSendReport = array();
            $dataSendReport['lock'] = true;

            /* Data variant */
            $dataVariant = array();
            $dataVariant['status'] = 'dangsai';
        } else if ($action == 'unlock') /* Unlock action */ {
            /* Data report */
            $data['date_unlock'] = time();
            $data['note'] = '';
            $data['status'] = 2;
            $data['count_unlock'] = $item['count_unlock'] + 1;

            /* Data send report */
            $dataSendReport = array();
            $dataSendReport['unlock'] = true;

            /* Data variant */
            $dataVariant = array();
            $dataVariant['status'] = 'xetduyet';
        } else if ($action == 'banned') /* Banned action */ {
            /* Data report */
            $data['date_banned'] = time();
            $data['status'] = 3;
            $data['count_banned'] = $item['count_banned'] + 1;

            /* Data send report */
            $dataSendReport = array();
            $dataSendReport['banned'] = true;

            /* Data variant */
            $dataVariant = array();
            $dataVariant['status'] = 'vipham';
        }

        /* Check data detail */
        if (!empty($item)) {
            /* Get variant detail */
            $shopDetail = $d->rawQueryOne("select id, id_member, id_admin, id_list, id_cat, id_region, id_city, id_district, id_wards, name, slug_url, id from #_" . $configSector['tables']['shop'] . " where id = ? limit 0,1", array($item['id_shop']));

            if (!empty($shopDetail)) {
                /* Get sector */
                $shopDetail['sectorInfo']['id'] = $configSector['id'];
                $shopDetail['sectorInfo']['name'] = $configSector['name'];
                $shopDetail['sectorInfo']['slug'] = $configSector['type'];

                /* Get info poster */
                if (!empty($shopDetail['id_member'])) {
                    /* Get owner Member */
                    $userInfo = $d->rawQueryOne("select fullname, phone, email, address from #_member where id = ?", array($shopDetail['id_member']));
                } else {
                    /* Get owner Admin */
                    $userInfo = $d->rawQueryOne("select fullname, phone, email, address from #_user where id = ?", array($shopDetail['id_admin']));
                }

                /* Send email report */
                if (!empty($userInfo)) {
                    $dataSendReport['variant'] = 'shop';
                    $dataSendReport['note'] = (!empty($data['note'])) ? $data['note'] : '';
                    $dataSendReport['shopData'] = (!empty($shopDetail)) ? $shopDetail : array();
                    $dataSendReport['userData'] = $userInfo;

                    /* Send report */
                    if (sendReport($dataSendReport)) {
                        /* Update status */
                        $d->where('id', $id);
                        $d->update($configSector['tables']['report-shop'], $data);

                        /* Update shop */
                        $d->where('id', $shopDetail['id']);
                        $d->update($configSector['tables']['shop'], $dataVariant);

                        if (!empty($dataSendReport['lock'])) {
                            $func->transfer("Đã chặn gian hàng thành công", "index.php?com=report&act=edit_report_shop&id_list=" . $id_list . "&id=" . $id . "&p=" . $curPage . $strUrl);
                        } else if (!empty($dataSendReport['unlock'])) {
                            $func->transfer("Đã mở gian hàng thành công", "index.php?com=report&act=edit_report_shop&id_list=" . $id_list . "&id=" . $id . "&p=" . $curPage . $strUrl);
                        } else if (!empty($dataSendReport['banned'])) {
                            $func->transfer("Đã khóa gian hàng thành công", "index.php?com=report&act=edit_report_shop&id_list=" . $id_list . "&id=" . $id . "&p=" . $curPage . $strUrl);
                        }
                    } else {
                        if (!empty($dataSendReport['lock'])) {
                            $func->transfer("Đã chặn gian hàng thất bại", "index.php?com=report&act=edit_report_shop&id_list=" . $id_list . "&id=" . $id . "&p=" . $curPage . $strUrl, false);
                        } else if (!empty($dataSendReport['unlock'])) {
                            $func->transfer("Đã mở gian hàng thất bại", "index.php?com=report&act=edit_report_shop&id_list=" . $id_list . "&id=" . $id . "&p=" . $curPage . $strUrl, false);
                        } else if (!empty($dataSendReport['banned'])) {
                            $func->transfer("Đã khóa gian hàng thất bại", "index.php?com=report&act=edit_report_shop&id_list=" . $id_list . "&id=" . $id . "&p=" . $curPage . $strUrl, false);
                        }
                    }
                } else {
                    $func->transfer("Dữ liệu chủ sở hữu không hợp lệ", "index.php?com=report&act=man_report_shop&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
                }
            } else {
                $func->transfer("Dữ liệu không có thực", "index.php?com=report&act=man_report_shop&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
            }
        } else {
            $func->transfer("Dữ liệu không có thực", "index.php?com=report&act=man_report_shop&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Delete man shop */
function deleteManShop()
{
    global $d, $strUrl, $id_list, $func, $configSector, $curPage;

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        if (!$func->hasShop($configSector)) {
            $func->transfer("Trang không tồn tại", "index.php", false);
        }

        /* ID data */
        $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

        if ($id) {
            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, status from #_" . $configSector['tables']['report-shop'] . " where id = ? limit 0,1", array($id));

            if (!empty($row['id'])) {
                /* Kiểm tra tình trạng */
                if ($row['status'] == 2) {
                    $d->rawQuery("delete from #_" . $configSector['tables']['report-shop'] . " where id = ?", array($id));
                    $d->rawQuery("delete from #_" . $configSector['tables']['report-shop-info'] . " where id_parent = ?", array($id));

                    $func->transfer("Xóa dữ liệu thành công", "index.php?com=report&act=man_report_shop&id_list=" . $id_list . "&p=" . $curPage . $strUrl);
                } else {
                    $func->transfer("Không thể xóa dữ liệu. Gian hàng trong mục này đang trong trạng thái <strong>Chờ duyệt/Đăng Sai/Vi Phạm</strong>", "index.php?com=report&act=man_report_shop&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
                }
            } else {
                $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=report&act=man_report_shop&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
            }
        } elseif (!empty($_GET['listid'])) {
            $listid = explode(",", $_GET['listid']);
            $isInValid = false;

            for ($i = 0; $i < count($listid); $i++) {
                $id = htmlspecialchars($listid[$i]);

                /* Lấy dữ liệu */
                $row = $d->rawQueryOne("select id, status from #_" . $configSector['tables']['report-shop'] . " where id = ? limit 0,1", array($id));

                if (!empty($row['id'])) {
                    /* Kiểm tra tình trạng */
                    if ($row['status'] == 2) {
                        $d->rawQuery("delete from #_" . $configSector['tables']['report-shop'] . " where id = ?", array($id));
                        $d->rawQuery("delete from #_" . $configSector['tables']['report-shop-info'] . " where id_parent = ?", array($id));
                    } else {
                        $isInValid = true;
                    }
                }
            }

            /* Thông báo dựa trên tình trạng */
            if ($isInValid) {
                $func->transfer("Xóa dữ liệu thành công. Một số mục không thể xóa do gian hàng trong các mục đó còn ở trạng thái <strong>Chờ duyệt/Đăng Sai/Vi Phạm</strong>", "index.php?com=report&act=man_report_shop&id_list=" . $id_list . "&p=" . $curPage . $strUrl);
            } else {
                $func->transfer("Xóa dữ liệu thành công", "index.php?com=report&act=man_report_shop&id_list=" . $id_list . "&p=" . $curPage . $strUrl);
            }
        } else {
            $func->transfer("Không nhận được dữ liệu", "index.php?com=report&act=man_report_shop&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Report man */
function sendReport($data = array())
{
    global $emailer, $func, $setting, $configBase;

    /* Send email */
    $arrayEmail = array(
        "dataEmail" => array(
            "name" => $data['userData']['fullname'],
            "email" => $data['userData']['email']
        )
    );
    $subject = "Thư thông báo từ " . $setting['namevi'];
    $message = getMessageEmail($data);
    $file = null;

    if ($emailer->send("customer", $arrayEmail, $subject, $message, $file)) {
        return true;
    } else {
        return false;
    }
}

function getMessageEmail($data = array())
{
    global $emailer, $func, $setting, $configBase;

    /* For product */
    if ($data['variant'] == 'product') {
        /* Variables info */
        $infoVars = array(
            '{emailProductName}',
            '{emailProductURL}',
            '{emailSectorListName}'
        );

        /* Values info */
        $infoVals = array(
            $data['productData']['namevi'],
            $configBase . $data['productData']['sectorInfo']['slug'] . '/' . $data['productData']['slugvi'] . '/' . $data['productData']['id'],
            $data['productData']['sectorInfo']['name']
        );

        /* Info variants */
        if (!empty($data['shopData'])) {
            /* Add shop */
            array_push($infoVars, '{emailShopName}');
            array_push($infoVals, $data['shopData']['name']);

            /* Add link fix */
            array_push($infoVars, '{emailLinkFixLock}');
            array_push($infoVals, $configBase . 'shop/' . $data['shopData']['slug_url'] . '/admin/index.php?com=product&act=edit&id_list=' . $data['productData']['id_list'] . '&id_cat=' . $data['productData']['id_cat'] . '&id_item=' . $data['productData']['id_item'] . '&id_sub=' . $data['productData']['id_sub'] . '&id_region=' . $data['productData']['id_region'] . '&id_city=' . $data['productData']['id_city'] . '&id_district=' . $data['productData']['id_district'] . '&id_wards=' . $data['productData']['id_wards'] . '&id=' . $data['productData']['id']);
        } else {
            /* Add link fix */
            array_push($infoVars, '{emailLinkFixLock}');
            array_push($infoVals, $configBase . 'account/chi-tiet-tin-dang?sector=' . $data['productData']['sectorInfo']['id'] . '&id=' . $data['productData']['id']);
        }

        /* Get info */
        $infoVariant = str_replace($infoVars, $infoVals, $emailer->markdown('report/product/info', ['reportData' => $data]));

        /* Gán giá trị gửi email */
        if (!empty($data['lock'])) {
            /* Defaults attributes email */
            $emailDefaultAttrs = $emailer->defaultAttrs();

            /* Variables lock */
            $reportVars = array(
                '{emailReportSlogan}',
                '{emailInfoVariantTitle}',
                '{emailInfoVariantContent}',
                '{emailReportTitle}',
                '{emailReportNote}',
            );
            $reportVars = $emailer->addAttrs($reportVars, $emailDefaultAttrs['vars']);

            /* Values lock */
            $reportVals = array(
                'Mục <strong style="text-transform:uppercase">' . $data['productData']['namevi'] . '</strong> của quý khách đã bị chặn vì một số lý do. ' . $emailer->get('company:website') . ' xin gửi các mô tả để Quý khách có thể chỉnh lại tin đăng trở nên hợp lệ.',
                'Thông tin chi tiết',
                $infoVariant,
                'Những nội dung cần chỉnh sửa',
                nl2br($func->decodeHtmlChars($_POST['note'])),
            );
            $reportVals = $emailer->addAttrs($reportVals, $emailDefaultAttrs['vals']);

            /* Get content */
            $reportContent = str_replace($reportVars, $reportVals, $emailer->markdown('report/type/lock'));
        } else if (!empty($data['unlock'])) {
            /* Defaults attributes email */
            $emailDefaultAttrs = $emailer->defaultAttrs();

            /* Variables unlock */
            $reportVars = array(
                '{emailReportSlogan}',
                '{emailInfoVariantTitle}',
                '{emailInfoVariantContent}'
            );
            $reportVars = $emailer->addAttrs($reportVars, $emailDefaultAttrs['vars']);

            /* Values unlock */
            $reportVals = array(
                'Mục <strong style="text-transform:uppercase">' . $data['productData']['namevi'] . '</strong> của quý khách đã được bỏ chặn thành công.',
                'Mở tin đăng thành công',
                $infoVariant
            );
            $reportVals = $emailer->addAttrs($reportVals, $emailDefaultAttrs['vals']);

            /* Get content */
            $reportContent = str_replace($reportVars, $reportVals, $emailer->markdown('report/type/unlock'));
        } else if (!empty($data['banned'])) {
            /* Defaults attributes email */
            $emailDefaultAttrs = $emailer->defaultAttrs();

            /* Variables unlock */
            $reportVars = array(
                '{emailReportSlogan}',
                '{emailInfoVariantTitle}',
                '{emailInfoVariantContent}'
            );
            $reportVars = $emailer->addAttrs($reportVars, $emailDefaultAttrs['vars']);

            /* Values unlock */
            $reportVals = array(
                'Mục <strong style="text-transform:uppercase">' . $data['productData']['namevi'] . '</strong> của quý khách đã bị khóa. Do vi phạm và đăng sai nhiều lần.',
                'Khóa tin đăng',
                $infoVariant
            );
            $reportVals = $emailer->addAttrs($reportVals, $emailDefaultAttrs['vals']);

            /* Get content */
            $reportContent = str_replace($reportVars, $reportVals, $emailer->markdown('report/type/banned'));
        }
    }

    /* For shop */
    if ($data['variant'] == 'shop') {
        /* Variables info */
        $infoVars = array(
            '{emailSectorListName}',
            '{emailShopName}',
            '{emailShopURL}',
            '{emailLinkFixLockOwner}',
            '{emailLinkFixLockPage}'
        );

        /* Values info */
        $infoVals = array(
            $data['shopData']['sectorInfo']['name'],
            $data['shopData']['name'],
            $configBase . 'shop/' . $data['shopData']['slug_url'] . '/',
            $configBase . 'account/chi-tiet-gian-hang?sector=' . $data['shopData']['sectorInfo']['id'] . '&id=' . $data['shopData']['id'],
            $configBase . 'shop/' . $data['shopData']['slug_url'] . '/'
        );

        /* Get info */
        $infoVariant = str_replace($infoVars, $infoVals, $emailer->markdown('report/shop/info', ['reportData' => $data]));

        /* Gán giá trị gửi email */
        if (!empty($data['lock'])) {
            /* Defaults attributes email */
            $emailDefaultAttrs = $emailer->defaultAttrs();

            /* Variables lock */
            $reportVars = array(
                '{emailReportSlogan}',
                '{emailInfoVariantTitle}',
                '{emailInfoVariantContent}',
                '{emailReportTitle}',
                '{emailReportNote}',
            );
            $reportVars = $emailer->addAttrs($reportVars, $emailDefaultAttrs['vars']);

            /* Values lock */
            $reportVals = array(
                'Gian hàng <strong style="text-transform:uppercase">' . $data['shopData']['name'] . '</strong> của quý khách đã bị chặn vì một số lý do. ' . $emailer->get('company:website') . ' xin gửi các mô tả để Quý khách có thể chỉnh lại gian hàng trở nên hợp lệ.',
                'Thông tin chi tiết',
                $infoVariant,
                'Những nội dung cần chỉnh sửa',
                nl2br($func->decodeHtmlChars($_POST['note'])),
            );
            $reportVals = $emailer->addAttrs($reportVals, $emailDefaultAttrs['vals']);

            /* Get content */
            $reportContent = str_replace($reportVars, $reportVals, $emailer->markdown('report/type/lock'));
        } else if (!empty($data['unlock'])) {
            /* Defaults attributes email */
            $emailDefaultAttrs = $emailer->defaultAttrs();

            /* Variables unlock */
            $reportVars = array(
                '{emailReportSlogan}',
                '{emailInfoVariantTitle}',
                '{emailInfoVariantContent}'
            );
            $reportVars = $emailer->addAttrs($reportVars, $emailDefaultAttrs['vars']);

            /* Values unlock */
            $reportVals = array(
                'Mục <strong style="text-transform:uppercase">' . $data['shopData']['name'] . '</strong> của quý khách đã được bỏ chặn thành công.',
                'Mở gian hàng thành công',
                $infoVariant
            );
            $reportVals = $emailer->addAttrs($reportVals, $emailDefaultAttrs['vals']);

            /* Get content */
            $reportContent = str_replace($reportVars, $reportVals, $emailer->markdown('report/type/unlock'));
        } else if (!empty($data['banned'])) {
            /* Defaults attributes email */
            $emailDefaultAttrs = $emailer->defaultAttrs();

            /* Variables unlock */
            $reportVars = array(
                '{emailReportSlogan}',
                '{emailInfoVariantTitle}',
                '{emailInfoVariantContent}'
            );
            $reportVars = $emailer->addAttrs($reportVars, $emailDefaultAttrs['vars']);

            /* Values unlock */
            $reportVals = array(
                'Mục <strong style="text-transform:uppercase">' . $data['shopData']['name'] . '</strong> của quý khách đã bị khóa. Do vi phạm và đăng sai nhiều lần.',
                'Khóa gian hàng',
                $infoVariant
            );
            $reportVals = $emailer->addAttrs($reportVals, $emailDefaultAttrs['vals']);

            /* Get content */
            $reportContent = str_replace($reportVars, $reportVals, $emailer->markdown('report/type/banned'));
        }
    }

    return $reportContent;
}
