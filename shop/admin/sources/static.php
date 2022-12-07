<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active static */
if (isset($config['static'])) {
    $arrCheck = array();
    foreach ($config['static'] as $k => $v) $arrCheck[] = $k;
    if (!count($arrCheck) || !in_array($type, $arrCheck)) $func->transfer("Trang không tồn tại", "index.php", false);
} else {
    $func->transfer("Trang không tồn tại", "index.php", false);
}

switch ($act) {
    case "update":
        viewStatic();
        $template = "static/man/man_add";
        break;
    case "save":
        saveStatic();
        break;
    default:
        $template = "404";
}

/* View static */
function viewStatic()
{
    global $d, $idShop, $prefixSector, $item, $itemContent, $type;

    $item = $d->rawQueryOne("select * from #_static where id_shop = $idShop and sector_prefix = ? and type = ? limit 0,1", array($prefixSector, $type));

    /* Get content */
    if (!empty($item)) {
        $itemContent = $d->rawQueryOne("select * from #_static_content where id_parent = ?", array($item['id']));
    }
}

/* Save static */
function saveStatic()
{
    global $d, $idShop, $prefixSector, $config, $func, $flash, $com, $type;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=static&act=update&type=" . $type, false);

    $static = $d->rawQueryOne("select * from #_static where id_shop = $idShop and sector_prefix = ? and type = ? limit 0,1", array($prefixSector, $type));

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $data = (isset($_POST['data'])) ? $_POST['data'] : null;
    $dataContent = (!empty($_POST['dataContent'])) ? $_POST['dataContent'] : null;
    $dataSeo = (!empty($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
    if ($data) {
        $data['id_shop'] = $idShop;
        $data['sector_prefix'] = $prefixSector;

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

    $data['type'] = $type;

    /* Check data content */
    if (!empty($config['static'][$type]['desc']) || !empty($config['static'][$type]['content'])) {
        if ($dataContent) {
            foreach ($dataContent as $column => $value) {
                $dataContent[$column] = htmlspecialchars($func->sanitize($value, 'iframe'));
            }
        }
    }

    /* Check data seo */
    if (!empty($config['static'][$type]['seo'])) {
        if ($dataSeo) {
            foreach ($dataSeo as $column => $value) {
                $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
            }
        }
    }

    /* Valid data */
    if (!empty($config['static'][$type]['name'])) {
        if (empty($data['namevi'])) {
            $response['messages'][] = 'Tiêu đề không được trống';
        }
    }

    if (!empty($config['static'][$type]['desc'])) {
        if (empty($dataContent['descvi'])) {
            $response['messages'][] = 'Mô tả không được trống';
        }
    }

    if (!empty($config['static'][$type]['content'])) {
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
        $func->redirect("index.php?com=static&act=update&type=" . $type);
    }

    if (isset($static['id']) && $static['id'] > 0) {
        $data['date_updated'] = time();

        $d->where('id_shop', $idShop);
        $d->where('sector_prefix', $prefixSector);
        $d->where('type', $type);
        if ($d->update('static', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['static'][$type]['img_type'], UPLOAD_NEWS, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_static where id_shop = $idShop and sector_prefix = ? and type = ? limit 0,1", array($prefixSector, $type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_NEWS . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('type', $type);
                    $d->where('id_shop', $idShop);
                    $d->where('sector_prefix', $prefixSector);
                    $d->update('static', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Content */
            $d->rawQuery("delete from #_static_content where id_parent = ?", array($static['id']));
            $dataContent['id_parent'] = $static['id'];
            $d->insert('static_content', $dataContent);

            /* SEO */
            $d->rawQuery("delete from #_static_seo where id_parent = ?", array($static['id']));
            $dataSeo['id_parent'] = $static['id'];
            $d->insert('static_seo', $dataSeo);

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=static&act=update&type=" . $type);
        } else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=static&act=update&type=" . $type, false);
    } else {
        if (
            (isset($data['namevi']) && $data['namevi'] != '') ||
            (isset($dataContent['descvi']) && $dataContent['descvi'] != '') ||
            (isset($dataContent['contentvi']) && $dataContent['contentvi'] != '')
        ) {
            $data['date_created'] = time();

            if ($d->insert('static', $data)) {
                $id_insert = $d->getLastInsertId();

                /* Photo */
                if ($func->hasFile("file")) {
                    $photoUpdate = array();
                    $file_name = $func->uploadName($_FILES['file']["name"]);

                    if ($photo = $func->uploadImage("file", $config['static'][$type]['img_type'], UPLOAD_NEWS, $file_name)) {
                        $photoUpdate['photo'] = $photo;
                        $d->where('id', $id_insert);
                        $d->where('id_shop', $idShop);
                        $d->where('sector_prefix', $prefixSector);
                        $d->update('static', $photoUpdate);
                        unset($photoUpdate);
                    }
                }

                /* Content */
                $dataContent['id_parent'] = $id_insert;
                $d->insert('static_content', $dataContent);

                /* SEO */
                $dataSeo['id_parent'] = $id_insert;
                $d->insert('static_seo', $dataSeo);

                $func->transfer("Lưu dữ liệu thành công", "index.php?com=static&act=update&type=" . $type);
            } else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=static&act=update&type=" . $type, false);
        }
        $func->transfer("Dữ liệu rỗng", "index.php?com=static&act=update&type=" . $type, false);
    }
}
