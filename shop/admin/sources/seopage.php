<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active seopage */
if (isset($config['seopage']) && count($config['seopage']['page']) > 0) {
    $arrCheck = array();
    foreach ($config['seopage']['page'] as $k => $v) $arrCheck[] = $k;
    if (!count($arrCheck) || !in_array($type, $arrCheck)) $func->transfer("Trang không tồn tại", "index.php", false);
} else {
    $func->transfer("Trang không tồn tại", "index.php", false);
}

switch ($act) {
    case "update":
        viewSeoPage();
        $template = "seopage/man/man_add";
        break;
    case "save":
        saveSeoPage();
        break;
    default:
        $template = "404";
}

/* View Seopage */
function viewSeoPage()
{
    global $d, $idShop, $prefixSector, $item, $type;

    $item = $d->rawQueryOne("select * from #_seopage where id_shop = $idShop and sector_prefix = ? and type = ? limit 0,1", array($prefixSector, $type));
}

/* Save Seopage */
function saveSeoPage()
{
    global $d, $idShop, $prefixSector, $func, $config, $com, $type;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=seopage&act=update&type=" . $type, false);

    $seopage = $d->rawQueryOne("select * from #_seopage where id_shop = $idShop and sector_prefix = ? and type = ? limit 0,1", array($prefixSector, $type));

    /* Post dữ liệu */
    $dataSeo = (isset($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
    if ($dataSeo) {
        $dataSeo['id_shop'] = $idShop;
        $dataSeo['sector_prefix'] = $prefixSector;

        foreach ($dataSeo as $column => $value) {
            $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
        }

        $dataSeo['type'] = $type;
    }

    if (isset($seopage['id']) && $seopage['id'] > 0) {
        $d->where('id_shop', $idShop);
        $d->where('sector_prefix', $prefixSector);
        $d->where('type', $type);
        if ($d->update('seopage', $dataSeo)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['seopage']['img_type'], UPLOAD_SEOPAGE, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_seopage where id_shop = $idShop and sector_prefix = ? and type = ? limit 0,1", array($prefixSector, $type));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_SEOPAGE . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('type', $type);
                    $d->where('id_shop', $idShop);
                    $d->where('sector_prefix', $prefixSector);
                    $d->update('seopage', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=seopage&act=update&type=" . $type);
        } else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=seopage&act=update&type=" . $type, false);
    } else {
        if ($d->insert('seopage', $dataSeo)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['seopage']['img_type'], UPLOAD_SEOPAGE, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->where('id_shop', $idShop);
                    $d->where('sector_prefix', $prefixSector);
                    $d->update('seopage', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=seopage&act=update&type=" . $type);
        } else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=seopage&act=update&type=" . $type, false);
    }
}
