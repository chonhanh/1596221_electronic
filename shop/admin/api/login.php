<?php
session_start();
define('LIBRARIES', '../../libraries/');

require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';
new AutoLoad();
$injection = new AntiSQLInjection();
$d = new PDODb($config['database']);

/* Shop */
$shop = new Shop($d);
$shopInit = $shop->init((!empty($_SERVER['HTTP_SHOP'])) ? trim($_SERVER['HTTP_SHOP']) : '');

if (!empty($shopInit)) {
    $shopInfo = $shop->get('shop');
    $idShop = (!empty($shopInfo)) ? $shopInfo['id'] : 0;
    $idSectorList = (!empty($shopInfo)) ? $shopInfo['id_list'] : 0;
    $idSectorCat = (!empty($shopInfo)) ? $shopInfo['id_cat'] : 0;
    $tableProductMain = $shopInfo['table-main'];
    $tableProductPhoto = $shopInfo['table-photo'];
    $tableProductTag = $shopInfo['table-tag'];
    $tableProductContent = $shopInfo['table-content'];
    $tableProductSeo = $shopInfo['table-seo'];
    $tableShop = $shopInfo['table-shop'];
    $tableShopLimit = $shopInfo['table-shop-limit'];
    $tableShopLog = $shopInfo['table-shop-log'];
    $loginShop = $config['login']['admin'] . $shopInfo['slug_url'];

    /* Class */
    $cache = new Cache($d);
    $func = new Functions($d, $cache);

    /* Login */
    $username = (!empty($_POST['username'])) ? $_POST['username'] : '';
    $password = (!empty($_POST['password'])) ? $_POST['password'] : '';
    $error = "";
    $success = "";
    $login_failed = false;

    /* Kiểm tra đăng nhập tài khoản sai theo số lần */
    $ip = $func->getRealIPAddress();
    $row = $d->rawQuery("select id, login_ip, login_attempts, attempt_time, locked_time from #_$tableShopLimit WHERE id_shop = ? and login_ip = ? order by id desc limit 1", array($idShop, $ip));

    if (!empty($row) && count($row) == 1) {
        $id_login = $row[0]['id'];
        $time_now = time();
        if ($row[0]['locked_time'] > 0) {
            $locked_time = $row[0]['locked_time'];
            $delay_time = $config['login']['delay'];
            $interval = $time_now  - $locked_time;

            if ($interval <= $delay_time * 60) {
                $time_remain = $delay_time * 60 - $interval;
                $error = "Xin lỗi..! Vui lòng thử lại sau " . round($time_remain / 60) . " phút..!";
            } else {
                $d->rawQuery("update #_$tableShopLimit set login_attempts = 0, attempt_time = ?, locked_time = 0 where id = ?", array($time_now, $id_login));
            }
        }
    }

    /* Còn số lần đăng nhập */
    if ($error == '') {
        /* Kiểm tra thông tin đăng nhập */
        if ($username == '' && $password == '') {
            $error = "Chưa nhập tên đăng nhập và mật khẩu";
        } else if ($username == '') {
            $error = "Chưa nhập tên đăng nhập ";
        } else if ($password == '') {
            $error = "Chưa nhập mật khẩu";
        } else {
            /* Kiểm tra đăng nhập */
            $row = $d->rawQueryOne("select * from #_$tableShop where slug_url = ? and username = ? and (status = ? or status = ?) and status_user = ? and id_member not in (select id from #_member where !find_in_set('hienthi',status)) and id_admin not in (select id from #_user where !find_in_set('hienthi',status)) limit 0,1", array($shopInfo['slug_url'], $username, 'xetduyet', 'dangsai', 'hienthi'));

            if (!empty($row['id'])) {
                if ($row['password'] == $password) {
                    $timenow = time();
                    $id_shop = $row['id'];
                    $ip = $func->getRealIPAddress();
                    $token = md5(time());
                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    $sessionhash = md5(sha1($row['password'] . $row['username']));

                    /* Ghi log truy cập thành công */
                    $d->rawQuery("insert into #_$tableShopLog (id_shop, ip, timelog, user_agent) values (?,?,?,?)", array($id_shop, $ip, $timenow, $user_agent));

                    /* Tạo log và login session */
                    $d->rawQuery("update #_$tableShop set login_session = ?, lastlogin = ?, user_token = ? where id = ?", array($sessionhash, $timenow, $token, $id_shop));

                    /* Khởi tạo Session để kiểm tra số lần đăng nhập */
                    $d->rawQuery("update #_$tableShop set login_session = ?, lastlogin = ? where id = ?", array($sessionhash, $timenow, $id_shop));

                    /* Reset số lần đăng nhập và thời gian đăng nhập */
                    $limitlogin = $d->rawQuery("select id, login_ip, login_attempts, attempt_time, locked_time from #_$tableShopLimit where id_shop = ? and login_ip = ? order by id desc", array($idShop, $ip));

                    if (count($limitlogin) == 1) {
                        $id_login = $limitlogin[0]['id'];
                        $d->rawQuery("update #_$tableShopLimit set login_attempts = 0, locked_time = 0 where id = ?", array($id_login));
                    }

                    /* Tạo Session login */
                    $_SESSION[$loginShop]['shop']['active'] = true;
                    $_SESSION[$loginShop]['shop']['id'] = $row['id'];
                    $_SESSION[$loginShop]['shop']['email'] = $row['email'];
                    $_SESSION[$loginShop]['shop']['username'] = $row['username'];
                    $_SESSION[$loginShop]['shop']['name'] = $row['name'];
                    $_SESSION[$loginShop]['shop']['secret_key'] = $row['secret_key'];
                    $_SESSION[$loginShop]['shop']['token'] = $sessionhash;
                    $_SESSION[$loginShop]['shop']['login_session'] = $sessionhash;
                    $_SESSION[$loginShop]['shop']['login_token'] = $token;

                    /* Tạo Session Token Shop */
                    $_SESSION[TOKEN_SHOP] = array();
                    $_SESSION[TOKEN_SHOP]['active'] = true;
                    $_SESSION[TOKEN_SHOP]['folder'] = $shopInfo['folder'];

                    /* Cập nhật quyền của user đăng nhập */
                    $secret_key = $_SESSION[$loginShop]['shop']['token'];
                    $d->rawQuery("update #_$tableShop set secret_key = ? where id = ?", array($secret_key, $row['id']));

                    $success = "Đăng nhập thành công";
                } else {
                    $login_failed = true;
                    $error = "Mật khẩu không chính xác";
                }
            } else {
                $login_failed = true;
                $error = "Tên đăng nhập không chính xác";
            }
   
            /* Xử lý khi đăng nhập thất bại */
            if ($login_failed) {
                $ip = $func->getRealIPAddress();
                $row = $d->rawQuery("select id, login_ip, login_attempts, attempt_time, locked_time from #_$tableShopLimit where id_shop = ? and login_ip = ? order by id desc limit 1", array($idShop, $ip));

                if (count($row) == 1) {
                    $id_login = $row[0]['id'];
                    $attempt = $row[0]['login_attempts'];
                    $noofattmpt = $config['login']['attempt'];
                    if ($attempt < $noofattmpt) {
                        $attempt = $attempt + 1;

                        /* Cập nhật số lần đăng nhập sai */
                        $d->rawQuery("update #_$tableShopLimit set login_attempts = ? where id = ?", array($attempt, $id_login));

                        $no_ofattmpt = $noofattmpt + 1;
                        $remain_attempt = $no_ofattmpt - $attempt;
                        $error = 'Sai thông tin. Còn ' . $remain_attempt . ' lần thử';
                    } else {
                        if ($row[0]['locked_time'] == 0) {
                            $attempt = $attempt + 1;
                            $timenow = time();

                            /* Cập nhật số lần đăng nhập sai */
                            $d->rawQuery("update #_$tableShopLimit set login_attempts = ?, locked_time = ? where id = ?", array($attempt, $timenow, $id_login));
                        } else {
                            $attempt = $attempt + 1;

                            /* Cập nhật số lần đăng nhập sai */
                            $d->rawQuery("update #_$tableShopLimit set login_attempts = ? where id = ?", array($attempt, $id_login));
                        }
                        $delay_time = $config['login']['delay'];
                        $error = "Bạn đã hết lần thử. Vui lòng thử lại sau " . $delay_time . " phút";
                    }
                } else {
                    $timenow = time();

                    /* Cập nhật thông tin đăng nhập sai */
                    $d->rawQuery("insert into #_$tableShopLimit (id_shop, login_ip, login_attempts, attempt_time, locked_time) values (?, ?, ?, ?, ?)", array($idShop, $ip, 1, $timenow, 0));

                    $remain_attempt = $config['login']['attempt'];
                    $error = 'Sai thông tin. Còn ' . $remain_attempt . ' lần thử';
                }
            }
        }
    }
} else {
    $success = '';
    $error = 'Gian hàng của bạn chưa được ban quản trị website xét duyệt hoặc không tồn tại. Vui lòng liên hệ với chúng tôi.';
}

$data = array('success' => $success, 'error' => $error);
echo json_encode($data);
