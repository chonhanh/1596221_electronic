<?php
if (!defined('SOURCES')) die("Error");

switch ($act) {
    case "update":
        viewSetting();
        $template = "setting/man/man_add";
        break;
    case "save":
        saveSetting();
        break;
    case "maintenance":
        maintainSetting();
        break;
    case "json":
        jsonSetting();
        break;
    default:
        $template = "404";
}

/* View setting */
function viewSetting()
{
    global $d, $idShop, $item;

    $item = $d->rawQueryOne("select * from #_setting where id_shop = $idShop limit 0,1");
}

/* Save setting */
function saveSetting()
{
    global $d, $idShop, $func, $flash, $config, $com;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=setting&act=update", false);

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $row = $d->rawQueryOne("select id, options from #_setting where id_shop = $idShop and id = ? limit 0,1", array($id));
    $option = json_decode($row['options'], true);
    $data = (isset($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            if (is_array($value)) {
                foreach ($value as $k2 => $v2) {
                    if ($k2 == 'coords_iframe') {
                        $option[$k2] = $func->sanitize($v2, 'iframe');
                    } else {
                        $option[$k2] = $v2;
                    }
                }

                $data[$column] = json_encode($option);
            } else {
                if ($column == 'mastertool') {
                    $data[$column] = htmlspecialchars($func->sanitize($value, 'meta'));
                } else if (in_array($column, array('headjs', 'bodyjs', 'analytics'))) {
                    $data[$column] = htmlspecialchars($func->sanitize($value, 'script'));
                } else {
                    $data[$column] = htmlspecialchars($func->sanitize($value));
                }
            }
        }
    }

    /* Post Seo */
    $dataSeo = (isset($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
    if ($dataSeo) {
        foreach ($dataSeo as $column => $value) {
            $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
        }
    }

    /* Valid data */
    if (empty($option['address'])) {
        $response['messages'][] = 'Địa chỉ không được trống';
    }

    if (empty($option['email'])) {
        $response['messages'][] = 'Email không được trống';
    }

    if (!empty($option['email']) && !$func->isEmail($option['email'])) {
        $response['messages'][] = 'Email không hợp lệ';
    }

    if (empty($option['hotline'])) {
        $response['messages'][] = 'Hotline không được trống';
    }

    if (!empty($option['hotline']) && !$func->isPhone($option['hotline'])) {
        $response['messages'][] = 'Hotline không hợp lệ';
    }

    if (empty($option['phone'])) {
        $response['messages'][] = 'Số điện thoại không được trống';
    }

    if (!empty($option['phone']) && !$func->isPhone($option['phone'])) {
        $response['messages'][] = 'Số điện thoại không hợp lệ';
    }

    if (!empty($option['zalo']) && !$func->isPhone($option['zalo'])) {
        $response['messages'][] = 'Zalo không hợp lệ';
    }

    if (empty($option['website'])) {
        $response['messages'][] = 'Website không được trống';
    }

    if (!empty($option['website']) && !$func->isUrl($option['website'])) {
        $response['messages'][] = 'Website không hợp lệ';
    }

    if (!empty($option['fanpage']) && !$func->isFanpage($option['fanpage'])) {
        $response['messages'][] = 'Fanpage không hợp lệ';
    }

    if (!empty($option['coords']) && !$func->isCoords($option['coords'])) {
        $response['messages'][] = 'Tọa độ không hợp lệ';
    }

    if (empty($option['greeting'])) {
        $response['messages'][] = 'Tiêu đề Lời Chào không được trống';
    }

    if (empty($option['group-store'])) {
        $response['messages'][] = 'Tiêu đề Nhóm Cửa Hàng không được trống';
    }

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

        if (!empty($option)) {
            foreach ($option as $k => $v) {
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
        $func->redirect("index.php?com=setting&act=update");
    }

    /* Update or add data */
    if (isset($row['id']) && $row['id'] > 0) {
        $d->where('id_shop', $idShop);
        $d->where('id', $id);
        if ($d->update('setting', $data)) {
            /* SEO */
            $d->rawQuery("delete from #_setting_seo where id_parent = ?", array($id));
            $dataSeo['id_parent'] = $id;
            $d->insert('setting_seo', $dataSeo);

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=setting&act=update");
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=setting&act=update", false);
        }
    } else {
        if ($d->insert('setting', $data)) {
            $id_insert = $d->getLastInsertId();

            /* SEO */
            $dataSeo['id_parent'] = $id_insert;
            $d->insert('setting_seo', $dataSeo);

            $func->transfer("Thêm dữ liệu thành công", "index.php?com=setting&act=update");
        } else {
            $func->transfer("Thêm dữ liệu bị lỗi", "index.php?com=setting&act=update", false);
        }
    }
}

/* Maintenance setting */
function maintainSetting()
{
    global $d, $func;

    /* Run Maintain database */
    $d->runMaintain();

    $func->transfer("Tối ưu database thành công", "index.php");
}

/* Json setting */
function jsonSetting()
{
    global $config, $func;

    if (!empty($config['website']['debug-developer'])) {
        /* Type */
        $type = (!empty($_GET['type'])) ? $_GET['type'] : '';

        /* Write json */
        if (!empty($type)) {
            $dataJson = array('type' => $type);
            $func->writeJson($dataJson);
        }

        $func->transfer("Tạo dữ liệu json thành công", "index.php?com=setting&act=update");
    } else {
        $func->transfer("Trang không tồn tại", "index.php?com=setting&act=update", false);
    }
}
