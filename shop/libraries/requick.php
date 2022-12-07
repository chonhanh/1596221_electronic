<?php
/* Request data */
$com = (!empty($_REQUEST['com'])) ? htmlspecialchars($_REQUEST['com']) : '';
$act = (!empty($_REQUEST['act'])) ? htmlspecialchars($_REQUEST['act']) : '';
$type = (!empty($_REQUEST['type'])) ? htmlspecialchars($_REQUEST['type']) : '';
$id_parent = (!empty($_REQUEST['id_parent'])) ? htmlspecialchars($_REQUEST['id_parent']) : '';
$id_list = (!empty($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : $idSectorList;
$id_cat = (!empty($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : $idSectorCat;
$id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : '';
$curPage = (!empty($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;
$curPageChild = (!empty($_GET['pchild'])) ? htmlspecialchars($_GET['pchild']) : 1;

/* Check and Get sector data */
if (!empty($id_list) && !empty($id_cat)) {
    if (in_array($id_list, $defineSectors['sectors']['IDs']) && ($id_list == $idSectorList) && ($id_cat == $idSectorCat)) {
        /* Get detail sector */
        $detailSector = array();
        $detailSector = $func->getInfoDetail('*', 'product_list', $id_list);

        /* Get defined sector */
        if (!empty($detailSector)) {
            $configSector = array();
            $configSector = $defineSectors['types'][$detailSector['type']];
        } else {
            $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
        }
    } else {
        $func->transfer("Lĩnh vực kinh doanh không hợp lệ", "index.php", false);
    }
}

/* Kiểm tra 2 máy đăng nhập cùng 1 tài khoản */
if (!empty($_SESSION[$loginShop]['shop']['active'])) {
    $id_shop = (int)$_SESSION[$loginShop]['shop']['id'];
    $timenow = time();

    $row = $d->rawQueryOne("select username, password, lastlogin, user_token from #_$tableShop WHERE id = ? limit 0,1", array($id_shop));

    $sessionhash = md5(sha1($row['password'] . $row['username']));

    if ($_SESSION[$loginShop]['shop']['login_session'] != $sessionhash || ($timenow - $row['lastlogin']) > 3600 || !isset($_SESSION[TOKEN_SHOP])) {
        if (!empty($_SESSION[TOKEN_SHOP])) unset($_SESSION[TOKEN_SHOP]);
        unset($_SESSION[$loginShop]);
        $func->redirect("index.php?com=user&act=login");
    }

    if ($_SESSION[$loginShop]['shop']['login_token'] !== $row['user_token']) $alertlogin = 'Có người đang đăng nhập tài khoản của bạn.';
    else $alertlogin = '';

    $token = md5(time());
    $_SESSION[$loginShop]['shop']['login_token'] = $token;

    /* Cập nhật lại thời gian hoạt động và token */
    $d->rawQuery("update #_$tableShop set lastlogin = ?, user_token = ? where id = ?", array($timenow, $token, $id_shop));
}

/* Check login */
if ($shop->checkLogin() == false && $act != "login") {
    $func->redirect("index.php?com=user&act=login");
}

/* Delete cache */
$cacheAction = array(
    'save',
    'save_item',
    'save_sub',
    'save_size',
    'save_color',
    'save_static',
    'save_photo',
    'update',
    'delete'
);
if (isset($_POST) && isset($cacheAction) && count($cacheAction) > 0) {
    if (in_array($act, $cacheAction)) {
        $cache->delete();
    }
}

/* Include sources */
if (file_exists(SOURCES . $com . '.php')) include SOURCES . $com . ".php";
else $template = "index";
