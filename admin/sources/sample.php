<?php
if (!defined('SOURCES')) die("Error");

switch ($act) {
    case "update":
        viewSample();
        $template = "sample/man/man_add";
        break;
    case "save":
        saveSample();
        break;
    default:
        $template = "404";
}

/* View sample */
function viewSample()
{
    global $d, $item, $func, $interface;

    $interface = $d->rawQuery("select namevi, id from #_interface order by numb,id desc");

    if (!empty($_REQUEST['id_interface'])) {
        $detail_interface = $d->rawQueryOne("select id from #_interface where id = ? limit 0,1", array($_REQUEST['id_interface']));

        if (!empty($detail_interface)) {
            $item = $d->rawQueryOne("select * from #_sample where id_interface = ? limit 0,1", array($detail_interface['id']));
        } else {
            $func->transfer("Dữ liệu không hợp lệ", "index.php?com=sample&act=update", false);
        }
    }
}

/* Save sample */
function saveSample()
{
    global $d, $func, $flash, $config;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=sample&act=update", false);

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $row = $d->rawQueryOne("select id from #_sample where id = ? limit 0,1", array($id));
    $data = (isset($_POST['data'])) ? $_POST['data'] : null;

    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }
    }

    /* Valid data */
    if (empty($data['id_interface'])) {
        $response['messages'][] = 'Chưa chọn giao diện gian hàng';
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
        $func->redirect("index.php?com=sample&act=update");
    }

    /* Update or add data */
    if (isset($row['id']) && $row['id'] > 0) {
        $d->where('id', $id);
        if ($d->update('sample', $data)) {
            /* Photo 1 */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($header = $func->uploadImage("file", $config['sample']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, header from #_sample where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PHOTO . $row['header']);
                    }

                    $photoUpdate['header'] = $header;
                    $d->where('id', $id);
                    $d->update('sample', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 2 */
            if ($func->hasFile("file-2")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file-2"]["name"]);

                if ($banner = $func->uploadImage("file-2", $config['sample']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, banner from #_sample where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PHOTO . $row['banner']);
                    }

                    $photoUpdate['banner'] = $banner;
                    $d->where('id', $id);
                    $d->update('sample', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 3 */
            if ($func->hasFile("file-3")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file-3"]["name"]);

                if ($logo = $func->uploadImage("file-3", $config['sample']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, logo from #_sample where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PHOTO . $row['logo']);
                    }

                    $photoUpdate['logo'] = $logo;
                    $d->where('id', $id);
                    $d->update('sample', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 4 */
            if ($func->hasFile("file-4")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file-4"]["name"]);

                if ($favicon = $func->uploadImage("file-4", $config['sample']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, favicon from #_sample where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PHOTO . $row['favicon']);
                    }

                    $photoUpdate['favicon'] = $favicon;
                    $d->where('id', $id);
                    $d->update('sample', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 5 */
            if ($func->hasFile("file-5")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file-5"]["name"]);

                if ($social = $func->uploadImage("file-5", $config['sample']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, social from #_sample where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PHOTO . $row['social']);
                    }

                    $photoUpdate['social'] = $social;
                    $d->where('id', $id);
                    $d->update('sample', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 6 */
            if ($func->hasFile("file-6")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file-6"]["name"]);

                if ($slideshow = $func->uploadImage("file-6", $config['sample']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, slideshow from #_sample where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PHOTO . $row['slideshow']);
                    }

                    $photoUpdate['slideshow'] = $slideshow;
                    $d->where('id', $id);
                    $d->update('sample', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=sample&act=update&id_interface=" . $data['id_interface']);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=sample&act=update&id_interface=" . $data['id_interface'], false);
        }
    } else {
        if ($d->insert('sample', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo 1 */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($header = $func->uploadImage("file", $config['sample']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $photoUpdate['header'] = $header;
                    $d->where('id', $id_insert);
                    $d->update('sample', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 2 */
            if ($func->hasFile("file-2")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file-2']["name"]);

                if ($banner = $func->uploadImage("file-2", $config['sample']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $photoUpdate['banner'] = $banner;
                    $d->where('id', $id_insert);
                    $d->update('sample', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 3 */
            if ($func->hasFile("file-3")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file-3']["name"]);

                if ($logo = $func->uploadImage("file-3", $config['sample']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $photoUpdate['logo'] = $logo;
                    $d->where('id', $id_insert);
                    $d->update('sample', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 4 */
            if ($func->hasFile("file-4")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file-4']["name"]);

                if ($favicon = $func->uploadImage("file-4", $config['sample']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $photoUpdate['favicon'] = $favicon;
                    $d->where('id', $id_insert);
                    $d->update('sample', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 5 */
            if ($func->hasFile("file-5")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file-5']["name"]);

                if ($social = $func->uploadImage("file-5", $config['sample']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $photoUpdate['social'] = $social;
                    $d->where('id', $id_insert);
                    $d->update('sample', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 6 */
            if ($func->hasFile("file-6")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file-6']["name"]);

                if ($slideshow = $func->uploadImage("file-6", $config['sample']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $photoUpdate['slideshow'] = $slideshow;
                    $d->where('id', $id_insert);
                    $d->update('sample', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Thêm dữ liệu thành công", "index.php?com=sample&act=update&id_interface=" . $data['id_interface']);
        } else {
            $func->transfer("Thêm dữ liệu bị lỗi", "index.php?com=sample&act=update&id_interface=" . $data['id_interface'], false);
        }
    }
}
