<?php
if (!defined('SOURCES')) die("Error");

switch ($act) {
    case "login":
        if (!empty($_SESSION[$loginShop]['shop']['active'])) $func->transfer("Trang không tồn tại", "index.php", false);
        else $template = "user/login";
        break;
    case "logout":
        logout();
        $func->redirect("index.php?com=user&act=login");
        break;
    case "info":
        info();
        $template = "user/info";
        break;

    default:
        $template = "404";
}

/* Info admin */
function info()
{
    global $d, $func, $flash, $curPage, $config, $loginShop, $tableShop;

    if (!empty($_POST)) {
        /* Post dữ liệu */
        $isChangePass = false;
        $message = '';
        $response = array();
        $id = htmlspecialchars($_POST['id']);
        $data = (isset($_POST['data'])) ? $_POST['data'] : null;
        if ($data) {
            foreach ($data as $column => $value) {
                $data[$column] = htmlspecialchars($func->sanitize($value));
            }
        }

        /* Valid data */
        if (empty($data['password'])) {
            $response['messages'][] = 'Mật khẩu không được trống';
        } else {
            $row = $d->rawQueryOne("select id, password from #_$tableShop where id = ? limit 0,1", array($id));

            if (!empty($row) && $row['password'] != $data['password']) {
                $isChangePass = true;
            }
        }

        if (!empty($response)) {
            $response['status'] = 'danger';
            $message = base64_encode(json_encode($response));
            $flash->set('message', $message);
            $func->redirect("index.php?com=user&act=info");
        }

        /* Update or add data */
        $d->where('id', $id);
        if ($d->update($tableShop, $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['shop']['img_type'], UPLOAD_SHOP, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_$tableShop where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_SHOP . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update($tableShop, $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Change password */
            if (!empty($isChangePass)) {
                logout();
                $func->transfer("Cập nhật dữ liệu thành công", "index.php");
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=user&act=info");
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=user&act=info");
        }
    }
}

/* Logout */
function logout()
{
    global $d, $func, $loginShop, $tableShop;

    /* Hủy bỏ quyền */
    $data_update_permission['secret_key'] = '';
    $d->where('id', $_SESSION[$loginShop]['shop']['id']);
    $d->update($tableShop, $data_update_permission);

    /* Hủy bỏ login */
    if (!empty($_SESSION[TOKEN_SHOP])) unset($_SESSION[TOKEN_SHOP]);
}
