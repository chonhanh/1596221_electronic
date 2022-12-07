<?php
/* Request data */
$com = (!empty($_REQUEST['com'])) ? htmlspecialchars($_REQUEST['com']) : '';
$act = (!empty($_REQUEST['act'])) ? htmlspecialchars($_REQUEST['act']) : '';
$type = (!empty($_REQUEST['type'])) ? htmlspecialchars($_REQUEST['type']) : '';
$id_parent = (!empty($_REQUEST['id_parent'])) ? htmlspecialchars($_REQUEST['id_parent']) : '';
$id_list = (!empty($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : '';
$id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : '';
$backPage = (!empty($_GET['backPage'])) ? htmlspecialchars($_GET['backPage']) : '';
$curPage = (!empty($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;
$curPageChild = (!empty($_GET['pchild'])) ? htmlspecialchars($_GET['pchild']) : 1;

/* Check and Get sector data */
if (!empty($id_list)) {
    if (in_array($id_list, $defineSectors['sectors']['IDs'])) {
        /* Get detail sector */
        $detailSector = array();
        $detailSector = $func->getInfoDetail('*', 'product_list', $id_list);

        /* Get defined sector */
        if (!empty($detailSector)) {
            $configSector = array();
            $configSector = $defineSectors['types'][$detailSector['type']];

            /* Khởi tạo biến Type Perms khi truy cập vào các SHOP, POSTING, PERMISSION */
            $typePermsSector = $configSector['type'];
        } else {
            $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
        }
    } else {
        $func->transfer("Lĩnh vực kinh doanh không hợp lệ", "index.php", false);
    }
}

/* Kiểm tra 2 máy đăng nhập cùng 1 tài khoản */
if (!empty($_SESSION[$loginAdmin]['owner']['active'])) {
    $id_user = (int)$_SESSION[$loginAdmin]['owner']['id'];
    $timenow = time();

    $row = $d->rawQueryOne("select username, password, lastlogin, user_token from #_user WHERE id = ? limit 0,1", array($id_user));

    $sessionhash = md5(sha1($row['password'] . $row['username']));

    if ($_SESSION[$loginAdmin]['owner']['login_session'] != $sessionhash || ($timenow - $row['lastlogin']) > 3600 || !isset($_SESSION[TOKEN])) {
        if (!empty($_SESSION[TOKEN])) unset($_SESSION[TOKEN]);
        unset($_SESSION[$loginAdmin]);
        $func->redirect("index.php?com=user&act=login");
    }

    if ($_SESSION[$loginAdmin]['owner']['login_token'] !== $row['user_token']) $alertlogin = 'Có người đang đăng nhập tài khoản của bạn.';
    else $alertlogin = '';

    $token = md5(time());
    $_SESSION[$loginAdmin]['owner']['login_token'] = $token;

    /* Cập nhật lại thời gian hoạt động và token */
    $d->rawQuery("update #_user set lastlogin = ?, user_token = ? where id = ?", array($timenow, $token, $id_user));
}

/* Kiểm tra phân quyền */
if (!empty($config['permission']['active']) && !empty($_SESSION[$loginAdmin]['owner']['active'])) {
    $_SESSION[$loginAdmin]['group'] = array();
    $flagGroup = array();
    $idAdmin = (!empty($_SESSION[$loginAdmin]['owner']['id'])) ? $_SESSION[$loginAdmin]['owner']['id'] : 0;
    $roleAdmin = (!empty($_SESSION[$loginAdmin]['owner']['role'])) ? $_SESSION[$loginAdmin]['owner']['role'] : 1;

    if (!empty($idAdmin) && $roleAdmin != 3) {
        /* Lấy thông tin admin của Group */
        $adminDetail = $d->rawQueryOne("select id_user_group, is_leader, id_admin from #_user_group_admin where id_admin = ? limit 0,1", array($idAdmin));

        /* Kiểm tra admin */
        if (!empty($adminDetail)) {
            /* Lấy thông tin nhóm admin */
            $groupAdmin = $d->rawQueryOne("select * from #_user_group where id = ? and find_in_set('hienthi',status) limit 0,1", array($adminDetail['id_user_group']));

            /* Kiểm tra group admin */
            if (!empty($groupAdmin)) {
                /* Lấy category */
                $categoryList = $d->rawQueryOne("select id_list from #_user_group_category where id_user_group = ?", array($groupAdmin['id']));

                if (!empty($categoryList)) {
                    $categoryCats = $d->rawQuery("select id_cat from #_user_group_category_cat where id_user_group = ? and id_list = ?", array($groupAdmin['id'], $categoryList['id_list']));
                    $categoryCats = (!empty($categoryCats)) ? explode(',', $func->joinCols($categoryCats, 'id_cat')) : array();
                } else {
                    $categoryCats = array();
                }

                /* Lấy place Group */
                $placeLists = $d->rawQuery("select id_region, id_city from #_user_group_place where id_user_group = ?", array($groupAdmin['id']));
                if (!empty($placeLists)) {
                    $regionLists = $func->joinCols($placeLists, 'id_region');
                    $cityLists = $func->joinCols($placeLists, 'id_city');
                }

                /* Lấy các admin trong group */
                $userLists = $d->rawQuery("select id_admin from #_user_group_admin where id_user_group = ?", array($groupAdmin['id']));
                if (!empty($userLists)) {
                    $adminLists = $func->joinCols($userLists, 'id_admin');
                }

                /* Lấy thông tin Group */
                $_SESSION[$loginAdmin]['group']['active'] = true;
                $_SESSION[$loginAdmin]['group']['id'] = $groupAdmin['id'];
                $_SESSION[$loginAdmin]['group']['virtual'] = (strstr($groupAdmin['status'], 'virtual')) ? true : false;
                $_SESSION[$loginAdmin]['group']['list'] = $categoryList['id_list'];
                $_SESSION[$loginAdmin]['group']['cat'] = $categoryCats;
                $_SESSION[$loginAdmin]['group']['regions'] = (!empty($regionLists)) ? $regionLists : '';
                $_SESSION[$loginAdmin]['group']['citys'] = (!empty($cityLists)) ? $cityLists : '';
                $_SESSION[$loginAdmin]['group']['admins'] = (!empty($adminLists)) ? $adminLists : '';
                $_SESSION[$loginAdmin]['group']['name'] = $groupAdmin['name'];
                $_SESSION[$loginAdmin]['group']['permsGroup'] = $groupAdmin['permission_group'];
                $_SESSION[$loginAdmin]['group']['loggedByLeader'] = (!empty($adminDetail['is_leader'])) ? true : false;

                /* Kiểm tra user là LEADER hay MEMBER */
                if (!empty($adminDetail['is_leader'])) {
                    /* Lấy quyền cho admin là LEADER */
                    $permissions = $d->rawQuery("select permission from #_user_group_permission where id_user_group = ?", array($adminDetail['id_user_group']));
                } else {
                    /* Lấy quyền cho admin là MEMBER */
                    $permissions = $d->rawQuery("select perms_group, permission from #_user_group_admin_permission where id_user_group = ? and id_admin = ?", array($adminDetail['id_user_group'], $adminDetail['id_admin']));

                    /* permsSelf */
                    if (!empty($permissions)) {
                        $_SESSION[$loginAdmin]['group']['permsSelf'] = $func->joinCols($permissions, 'perms_group');
                    } else {
                        $flagGroup['error'] = true;
                        $flagGroup['message'] = "Bạn chưa được phân quyền. Vui lòng liên hệ với trưởng nhóm.";
                    }
                }

                /* Khởi tạo danh sách quyền */
                if (!empty($permissions)) {
                    foreach ($permissions as $value) {
                        $_SESSION[$loginAdmin]['group']['permissions'][] = $value['permission'];
                    }
                }
            } else {
                $flagGroup['error'] = true;
                $flagGroup['message'] = "Nhóm quản trị bạn trực thuộc không tồn tại. Vui lòng liên hệ quản trị website.";
            }
        } else {
            $flagGroup['error'] = true;
            $flagGroup['message'] = "Bạn không thuộc vào bất kỳ nhóm quản trị nào. Vui lòng liên hệ quản trị website.";
        }

        /* Logout admin */
        if (!empty($_SESSION[$loginAdmin]['owner']['active']) && !empty($flagGroup['error'])) {
            $_SESSION[$loginAdmin]['owner'] = NULL;
            $func->transfer($flagGroup['message'], "index.php", false);
        }
    }

    /* Kiểm tra quyền */
    if ($func->checkRole()) {
        $is_permission = true;
        $actPerms = array('save', 'save_list', 'save_cat', 'save_item', 'save_sub', 'save_color', 'save_size', 'saveImages', 'uploadExcel', 'save_static', 'save_photo');

        if (!in_array($act, $actPerms)) {
            if ($com != 'user' && $com != '' && $com != 'index') {
                /* Type perms */
                $permsType = $type;

                /* Bỏ Type nếu truy cập các danh mục cấp của product */
                if ($com == 'product' && !in_array($act, array('man', 'add', 'edit', 'delete'))) {
                    $permsType = '';
                } else if (($com == 'product' || $com == 'shop') && in_array($act, array('man', 'add', 'edit', 'delete'))) {
                    $permsType = $typePermsSector;
                } else if (($com == 'report') && in_array($act, array('man_report_posting', 'edit_report_posting', 'delete_report_posting', 'man_report_shop', 'edit_report_shop', 'delete_report_shop'))) {
                    $permsType = $typePermsSector;
                }

                /* Kiểm tra danh mục chính */
                $accessList = true;
                if (!empty($_REQUEST['id_list'])) {
                    $permsList = ($func->getGroup('list')) ? $func->getGroup('list') : 0;
                    if (!empty($permsList) && $_REQUEST['id_list'] != $permsList) {
                        $accessList = false;
                    }
                }

                /* Kiểm tra danh mục cấp 2 */
                $accessCat = true;
                if (!empty($_REQUEST['id_cat']) || (!empty($act) && !empty($id) && strstr($act, '_cat'))) {
                    if (!empty($_REQUEST['id_cat'])) {
                        $permsIDCat = $_REQUEST['id_cat'];
                    } else if (!empty($id)) {
                        $permsIDCat = $id;
                    }

                    $permsCat = ($func->getGroup('cat')) ? $func->getGroup('cat') : [];
                    if (!empty($permsCat) && !in_array($permsIDCat, $permsCat)) {
                        $accessCat = false;
                    }
                }

                /* Kiểm tra vùng/miền truy cập */
                $accessRegion = true;
                if (!empty($_REQUEST['id_region']) || (!empty($act) && !empty($id) && strstr($act, '_region'))) {
                    if (!empty($_REQUEST['id_region'])) {
                        $permsIDRegion = $_REQUEST['id_region'];
                    } else if (!empty($id)) {
                        $permsIDRegion = $id;
                    }

                    $permsRegion = ($func->getGroup('regions')) ? explode(",", $func->getGroup('regions')) : array();
                    if (!empty($permsRegion) && !in_array($permsIDRegion, $permsRegion)) {
                        $accessRegion = false;
                    }
                }

                /* Kiểm tra tỉnh/thành phố truy cập */
                $accessCity = true;
                if (!empty($_REQUEST['id_city']) || (!empty($act) && !empty($id) && strstr($act, '_city'))) {
                    if (!empty($_REQUEST['id_city'])) {
                        $permsIDCity = $_REQUEST['id_city'];
                    } else if (!empty($id)) {
                        $permsIDCity = $id;
                    }

                    $permsPlace = ($func->getGroup('citys')) ? explode(",", $func->getGroup('citys')) : array();
                    if (!empty($permsPlace) && !in_array($permsIDCity, $permsPlace)) {
                        $accessCity = false;
                    }
                }

                /* Check access */
                $permsAccess = (!$accessList || !$accessCat || !$accessRegion || !$accessCity) ? false : true;

                /* Xét quyền */
                if (!$func->checkAccess($com, $act, $permsType) || !$permsAccess) {
                    $func->transfer("Bạn không có quyền truy cập vào khu vực này", "index.php", false);
                    exit;
                }
            }
        }
    }
}

/* Kiểm tra đăng nhập */
if ($func->checkLoginAdmin() == false && $act != "login") {
    $func->redirect("index.php?com=user&act=login");
}

/* Delete cache */
$cacheAction = array(
    'save',
    'save_list',
    'save_cat',
    'save_item',
    'save_sub',
    'save_static',
    'save_photo',
    'save_tags',
    'save_size',
    'save_color',
    'save_region',
    'save_city',
    'save_district',
    'save_wards',
    'save_report_posting',
    'save_report_shop',
    'send_mails',
    'save_group',
    'update',
    'delete',
    'delete_list',
    'delete_cat',
    'delete_item',
    'delete_sub',
    'delete_tags',
    'delete_region',
    'delete_city',
    'delete_district',
    'delete_wards'
);
if (isset($_POST) && isset($cacheAction) && count($cacheAction) > 0) {
    if (in_array($act, $cacheAction)) {
        $cache->delete();
    }
}

/* Include sources */
if (file_exists(SOURCES . $com . '.php')) include SOURCES . $com . ".php";
else $template = "index";
