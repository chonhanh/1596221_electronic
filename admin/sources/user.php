<?php
if (!defined('SOURCES')) die("Error");

/* Array access blocked user */
$array_access_blocked_user = array('man_group', 'add_group', 'edit_group', 'delete_group', 'info_admin', 'add_admin', 'delete_admin', 'edit_admin_virtual', 'delete_admin_virtual', 'add_member', 'update_member_dashboard', 'delete_member');

/* Cấm truy cập các quyền sau nếu không phải là LEADER */
if (!$func->getGroup('loggedByLeader')) {
    array_push($array_access_blocked_user, 'add_admin_perms');
}

/* Cấm truy cập các quyền sau nếu không phải là LEADER or Group là Virtual */
if (!$func->getGroup('loggedByLeader') || $func->getGroup('virtual')) {
    array_push($array_access_blocked_user, 'man_admin');
    array_push($array_access_blocked_user, 'edit_admin');
}

/* Cấm truy cập các quyền sau nếu không phải là Group Virtual */
if (!$func->getGroup('virtual')) {
    array_push($array_access_blocked_user, 'man_admin_virtual');
    array_push($array_access_blocked_user, 'add_admin_virtual');
    array_push($array_access_blocked_user, 'edit_admin_virtual');
}

/* Cấm truy cập các quyền sau nếu không tồn tại quyền quán lý Thành Viên */
if (!empty($is_permission)) {
    /* Cấm quyền xem danh sách Thành Viên */
    if (!$func->checkAccess('user', 'man_member', '')) {
        array_push($array_access_blocked_user, 'man_member');
    }

    /* Cấm quyền chỉnh sửa Thành Viên */
    if (!$func->checkAccess('user', 'edit_member', '')) {
        array_push($array_access_blocked_user, 'edit_member');
    }
}

/* Check access user */
if (!empty($act) && !in_array($act, array('login')) && in_array($act, $array_access_blocked_user) && $func->checkRole()) {
    $func->transfer("Bạn không có quyền truy cập vào khu vực này", "index.php", false);
    exit;
}

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('id_list', 'id_cat', 'id_region', 'id_city', 'id_district', 'id_wards');
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
        /* Login - Logout */
    case "login":
        if (!empty($_SESSION[$loginAdmin]['owner']['active'])) $func->transfer("Trang không tồn tại", "index.php", false);
        else $template = "user/login";
        break;
    case "logout":
        $func->logoutAdmin();
        break;

        /* Groups */
    case "man_group":
        viewGroups();
        $template = "user/man_group/mans";
        break;
    case "add_group":
        addGroup();
        $template = "user/man_group/man_add";
        break;
    case "edit_group":
        editGroup();
        $template = "user/man_group/man_add";
        break;
    case "save_group":
        saveGroup();
        break;
    case "delete_group":
        deleteGroup();
        break;

        /* Admins permissions */
    case "add_admin_perms":
        addAdminPerms();
        $template = "user/permission/mans";
        break;
    case "save_admin_perms":
        saveAdminPerms();
        break;

        /* Admins */
    case "man_admin":
        viewAdmins();
        $template = "user/man_admin/mans";
        break;
    case "add_admin":
        $template = "user/man_admin/man_add";
        break;
    case "edit_admin":
        editAdmin();
        $template = "user/man_admin/man_add";
        break;
    case "info_admin":
        infoAdmin();
        $template = "user/man_admin/info";
        break;
    case "save_admin":
        saveAdmin();
        break;
    case "delete_admin":
        deleteAdmin();
        break;

        /* Admins virtual */
    case "man_admin_virtual":
        viewAdminsVirtual();
        $template = "user/man_admin_virtual/mans";
        break;
    case "add_admin_virtual":
        $template = "user/man_admin_virtual/man_add";
        break;
    case "edit_admin_virtual":
        editAdminVirtual();
        $template = "user/man_admin_virtual/man_add";
        break;
    case "save_admin_virtual":
        saveAdminVirtual();
        break;
    case "delete_admin_virtual":
        deleteAdminVirtual();
        break;

        /* Members */
    case "man_member":
        viewMembers();
        $template = "user/man_member/mans";
        break;
    case "add_member":
        $template = "user/man_member/man_add";
        break;
    case "update_member_dashboard":
        viewMembersDashboard();
        $template = "user/man_member/man_dashboard";
        break;
    case "save_member_dashboard":
        saveMembersDashboard();
        break;
    case "edit_member":
        editMember();
        $template = "user/man_member/man_add";
        break;
    case "save_member":
        saveMember();
        break;
    case "delete_member":
        deleteMember();
        break;

        /* Send mails */
    case "send_mails":
        sendMails();
        break;

    default:
        $template = "404";
}

/* View group */
function viewGroups()
{
    global $d, $func, $curPage, $items, $paging, $config;

    /* Get data */
    $where = "";
    $id_type = (!empty($_REQUEST['id_type'])) ? htmlspecialchars($_REQUEST['id_type']) : 0;
    $idlist = (!empty($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    $idcat = (!empty($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
    $id_place = (!empty($_REQUEST['id_place'])) ? htmlspecialchars($_REQUEST['id_place']) : 0;

    if ($id_type == 1) {
        $where .= " and !find_in_set('virtual',status)";
    } else if ($id_type == 2) {
        $where .= " and find_in_set('virtual',status)";
    }

    if ($idlist || $idcat) {
        $whereCategory = "";
        $whereCategory .= (!empty($idlist)) ? " and id_list = $idlist" : "";
        $whereCategory .= (!empty($idcat)) ? " and id_cat = $idcat" : "";
        $category = $d->rawQuery("select id_user_group from #_user_group_category_cat where id > 0 $whereCategory");

        if (!empty($category)) {
            $strId = '';
            foreach ($category as $v) {
                $strId .= $v['id_user_group'] . ',';
            }

            if (!empty($strId)) {
                $strId = rtrim($strId, ',');
                $where .= " and id in ($strId)";
            }
        } else {
            $where .= " and id = 0";
        }
    }

    if ($id_place && strstr($id_place, ",")) {
        $id_place = explode(",", $id_place);
        $place = $d->rawQuery("select id_user_group from #_user_group_place where id_region = ? and id_city = ?", array($id_place[0], $id_place[1]));

        if (!empty($place)) {
            $strId = '';
            foreach ($place as $v) {
                $strId .= $v['id_user_group'] . ',';
            }

            if (!empty($strId)) {
                $strId = rtrim($strId, ',');
                $where .= " and id in ($strId)";
            }
        } else {
            $where .= " and id = 0";
        }
    }
    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (name LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_user_group where id <> 0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_user_group where id <> 0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=user&act=man_group";
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Add group */
function addGroup()
{
    global $mainPermissions;

    /* Main permission */
    $mainPermissions = array();
}

/* Edit group */
function editGroup()
{
    global $d, $func, $curPage, $item, $mainPermissions, $itemPlaces, $strIdPlaces, $itemAdmins, $strIdAdmins, $itemPermissions, $listPermissions;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man_group&p=" . $curPage, false);

    $item = $d->rawQueryOne("select * from #_user_group where id = ? limit 0,1", array($id));

    if (empty($item)) $func->transfer("Dữ liệu không có thực", "index.php?com=user&act=man_group&p=" . $curPage, false);

    /* Get places */
    $itemPlaces = $d->rawQuery("select id_city from #_user_group_place where id_user_group = ?", array($id));

    /* Create string list id places */
    if (!empty($itemPlaces)) {
        $strIdPlaces = '';
        foreach ($itemPlaces as $v) {
            $strIdPlaces .= $v['id_city'] . ',';
        }
        $strIdPlaces = (!empty($strIdPlaces)) ? rtrim($strIdPlaces, ',') : '';
    }

    /* Get admins */
    $itemAdmins = $d->rawQuery("select id_admin, is_leader from #_user_group_admin where id_user_group = ? order by id asc", array($id));

    /* Create string list id admins */
    if (!empty($itemAdmins)) {
        $strIdAdmins = '';
        foreach ($itemAdmins as $v) {
            $strIdAdmins .= $v['id_admin'] . ',';
        }
        $strIdAdmins = (!empty($strIdAdmins)) ? rtrim($strIdAdmins, ',') : '';
    }

    /* Create main permission */
    if (!empty($item['permission_group'])) {
        $mainPermissions = explode(",", $item['permission_group']);
    }

    /* Get permissions */
    $itemPermissions = $d->rawQuery("select permission from #_user_group_permission where id_user_group = ?", array($id));

    /* Create list permission */
    if (!empty($itemPermissions)) {
        $listPermissions = array();
        foreach ($itemPermissions as $v) {
            $listPermissions[] = $v['permission'];
        }
    }
}

/* Save group */
function saveGroup()
{
    global $d, $func, $flash, $curPage, $config;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man_group&p=" . $curPage, false);

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    $dataCategory = array();
    $dataMultiCategoryCat = (!empty($_POST['dataMultiCategoryCat'])) ? $_POST['dataMultiCategoryCat'] : null;
    $placeGroup = (!empty($_POST['place_group'])) ? $_POST['place_group'] : null;
    $adminGroup = (!empty($_POST['admin_group'])) ? $_POST['admin_group'] : null;
    $permissionGroup = (!empty($_POST['permission_group'])) ? $_POST['permission_group'] : null;
    $permissionLists = (!empty($_POST['permissionLists'])) ? $_POST['permissionLists'] : null;
    $leader = (!empty($_POST['leader'])) ? htmlspecialchars($_POST['leader']) : 0;

    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        if ($permissionGroup) {
            /* Lọc và XÓA những quyền mà user chưa chọn các quyền con */
            foreach ($permissionGroup as $kPermGroup => $vPermGroup) {
                if (empty($permissionLists[$vPermGroup])) {
                    unset($permissionGroup[$kPermGroup]);
                }
            }

            $data['permission_group'] = implode(",", $permissionGroup);
        } else {
            $data['permission_group'] = '';
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $status = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $status = "";
        }

        if (!empty($data['id_type'])) {
            if ($data['id_type'] == 2) {
                $data['status'] = (!empty($status)) ? $status . ',virtual' : 'virtual';
            } else {
                $data['status'] = $status;
            }
        }
    }

    /* Check data category list */
    if (!empty($data['id_list'])) {
        $dataCategory['id_list'] = $data['id_list'];
        unset($data['id_list']);
    }

    /* Valid data */
    if (empty($data['id_type'])) {
        $response['messages'][] = 'Chưa chọn loại nhóm';
    } else {
        unset($data['id_type']);
    }

    if (empty($dataCategory['id_list'])) {
        $response['messages'][] = 'Chưa chọn danh mục chính';
    }

    if (empty($dataMultiCategoryCat)) {
        $response['messages'][] = 'Chưa chọn danh mục cấp 2';
    }

    if (empty($placeGroup)) {
        $response['messages'][] = 'Chưa chọn tỉnh/thành phố';
    }

    if (empty($adminGroup)) {
        $response['messages'][] = 'Chưa chọn danh sách quản trị viên';
    }

    if (!empty($adminGroup) && count($adminGroup) < 2) {
        $response['messages'][] = 'Nhóm quản trị viên phải tối thiểu 2 người';
    }

    if (empty($permissionGroup)) {
        $response['messages'][] = 'Chưa chọn danh sách quyền';
    }

    if (empty($leader)) {
        $response['messages'][] = 'Chưa chọn trưởng nhóm';
    }

    if (empty($data['name'])) {
        $response['messages'][] = 'Tên nhóm không được trống';
    }

    if (!empty($permissionGroup) && empty($permissionLists)) {
        $response['messages'][] = 'Chưa chọn quyền cho nhóm';
    }

    if (!empty($response)) {
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);

        if (empty($id)) {
            $func->redirect("index.php?com=user&act=add_group");
        } else {
            $func->redirect("index.php?com=user&act=edit_group&id=" . $id);
        }
    }

    /* Update or add data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('user_group', $data)) {
            /* Category */
            if (!empty($dataCategory)) {
                $d->rawQuery("delete from #_user_group_category where id_user_group = ?", array($id));
                $d->rawQuery("delete from #_user_group_category_cat where id_user_group = ?", array($id));
                $dataCategory['id_user_group'] = $id;

                if ($d->insert('user_group_category', $dataCategory)) {
                    if (!empty($dataMultiCategoryCat)) {
                        foreach ($dataMultiCategoryCat as $v) {
                            $dataCategoryCat = array();
                            $dataCategoryCat['id_user_group'] = $id;
                            $dataCategoryCat['id_list'] = $dataCategory['id_list'];
                            $dataCategoryCat['id_cat'] = $v;
                            $d->insert('user_group_category_cat', $dataCategoryCat);
                        }
                    }
                }
            }

            /* Places */
            if ($placeGroup) {
                $d->rawQuery("delete from #_user_group_place where id_user_group = ?", array($id));
                foreach ($placeGroup as $v) {
                    if (strstr($v, ',')) {
                        $v_explode = explode(",", $v);
                        $dataPlace = array();
                        $dataPlace['id_region'] = trim($v_explode[0]);
                        $dataPlace['id_city'] = trim($v_explode[1]);
                        $dataPlace['id_user_group'] = $id;
                        $d->insert('user_group_place', $dataPlace);
                    }
                }
            }

            /* Admins */
            if ($adminGroup) {
                /* Lấy danh sách quản trị viên có trong group */
                $adminsOld = $d->rawQuery("select id_admin from #_user_group_admin where id_user_group = ?", array($id));

                /* Khởi tạo danh sách quản trị viên đã chọn */
                $adminIsLeader = array();

                foreach ($adminGroup as $v) {
                    $adminsNew[] = array(
                        'id_admin' => $v,
                        'is_leader' => ($leader == $v) ? 1 : 0
                    );

                    $adminIsLeader[$v] = ($leader == $v) ? 1 : 0;
                }

                if (!empty($adminsNew)) {
                    /* Tồn tại danh sách quản trị viên cũ */
                    if (!empty($adminsOld)) {
                        $adminsNewTemp = explode(",", $func->joinCols($adminsNew, 'id_admin'));
                        $adminsOldTemp = explode(",", $func->joinCols($adminsOld, 'id_admin'));

                        /* Các quản trị viên cũ cần xóa */
                        $permsDelete = array_diff($adminsOldTemp, $adminsNewTemp);

                        /* Các quản trị viên cũ cần giữ lại */
                        $permsInters = array_intersect($adminsNewTemp, $adminsOldTemp);

                        /* Các quản trị viên mới cần thêm */
                        $permsDiff = array_diff($adminsNewTemp, $adminsOldTemp);

                        /* Xóa và cập nhật quản trị viên */
                        if (!empty($permsDelete)) {
                            // $func->dump('Các quản trị viên cũ cần xóa');
                            // $func->dump($permsDelete);

                            foreach ($permsDelete as $vDel) {
                                // Xóa quản trị viên
                                $d->rawQuery("delete from #_user_group_admin where id_user_group = ? and id_admin = ?", array($id, $vDel));

                                // Xóa quyền của các quản trị viên
                                $d->rawQuery("delete from #_user_group_admin_permission where id_user_group = ? and id_admin = ?", array($id, $vDel));
                            }
                        }

                        /* Thêm các quản trị viên mới */
                        if (!empty($permsDiff)) {
                            // $func->dump('Các quản trị viên mới cần thêm');
                            // $func->dump($permsDiff);

                            foreach ($permsDiff as $vDiff) {
                                $dataAdmin = array();
                                $dataAdmin['id_admin'] = $vDiff;
                                $dataAdmin['is_leader'] = $adminIsLeader[$vDiff];
                                $dataAdmin['id_user_group'] = $id;
                                $d->insert('user_group_admin', $dataAdmin);
                            }
                        }

                        /* Cập nhật thông tin */
                        if (!empty($permsInters)) {
                            // $func->dump('Cập nhật thông tin quản trị viên');
                            // $func->dump($permsInters);

                            foreach ($adminsNew as $v) {
                                $dataAdmin = array();
                                $dataAdmin['is_leader'] = ($leader == $v['id_admin']) ? 1 : 0;
                                $d->where('id_admin', $v['id_admin']);
                                $d->update('user_group_admin', $dataAdmin);
                            }
                        }
                    } else {
                        /* Không tồn tại danh sách quản trị viên cũ => Thêm mới toàn bộ quản trị viên */
                        foreach ($adminsNew as $v) {
                            $dataAdmin = array();
                            $dataAdmin['id_admin'] = $v['id_admin'];
                            $dataAdmin['is_leader'] = $v['is_leader'];
                            $dataAdmin['id_user_group'] = $id;
                            $d->insert('user_group_admin', $dataAdmin);
                        }
                    }
                }
            }

            /* Permissions */
            if ($permissionGroup && $permissionLists) {
                /* Lấy danh sách quyền có trong group */
                $permsOld = $d->rawQuery("select perms_group, permission from #_user_group_permission where id_user_group = ?", array($id));

                /* Khởi tạo danh sách quyền đã chọn */
                $permsByGroup = array();

                foreach ($permissionGroup as $vPermGroup) {
                    if (!empty($permissionLists[$vPermGroup])) {
                        foreach ($permissionLists[$vPermGroup] as $v) {
                            $permsNew[] = array(
                                'perms_group' => $vPermGroup,
                                'permission' => $v
                            );
                            $permsByGroup[$v] = $vPermGroup;
                        }
                    }
                }

                if (!empty($permsNew)) {
                    /* Tồn tại quyền cũ */
                    if (!empty($permsOld)) {
                        $permsNewTemp = explode(",", $func->joinCols($permsNew, 'permission'));
                        $permsOldTemp = explode(",", $func->joinCols($permsOld, 'permission'));

                        /* Các quyền cũ cần xóa */
                        $permsDelete = array_diff($permsOldTemp, $permsNewTemp);

                        /* Các quyền cũ cần giữ lại */
                        $permsInters = array_intersect($permsNewTemp, $permsOldTemp);

                        /* Các quyền mới cần thêm */
                        $permsDiff = array_diff($permsNewTemp, $permsOldTemp);

                        /* Xóa quyền cũ */
                        /* Cách 1: Xóa các quyền cũ CÓ trong danh sách này */
                        if (!empty($permsDelete)) {
                            // $func->dump('Các quyền cũ cần xóa');
                            // $func->dump($permsDelete);

                            foreach ($permsDelete as $vDel) {
                                // Xóa quyền trong Group
                                $d->rawQuery("delete from #_user_group_permission where id_user_group = ? and permission = ?", array($id, $vDel));

                                // Xóa quyền của các admin con
                                $d->rawQuery("delete from #_user_group_admin_permission where id_user_group = ? and permission = ?", array($id, $vDel));
                            }
                        }

                        /* Xóa quyền cũ */
                        /* Cách 2: Xóa các quyền cũ KHÔNG CÓ trong danh sách này */
                        // if(!empty($permsInters))
                        // {
                        // 	$func->dump('Các quyền cũ cần giữ lại');
                        // 	$func->dump($permsInters);

                        // 	foreach($permsInters as $kInters => $vInters)
                        // 	{
                        // 		$permsInters[$kInters] = "'".$vInters."'";
                        // 	}

                        // 	$permsInters = implode(",", $permsInters);

                        // 	// Xóa quyền trong Group
                        // 	$d->rawQuery("delete from #_user_group_permission where id_user_group = ? and permission not in ($permsInters)",array($id));

                        // 	// Xóa quyền của các admin con
                        // 	$d->rawQuery("delete from #_user_group_admin_permission where id_user_group = ? and permission not in ($permsInters)",array($id));
                        // }

                        /* Thêm các quyền mới */
                        if (!empty($permsDiff)) {
                            // $func->dump('Các quyền mới cần thêm');
                            // $func->dump($permsDiff);

                            foreach ($permsDiff as $vDiff) {
                                $dataPermission = array();
                                $dataPermission['perms_group'] = (!empty($permsByGroup[$vDiff])) ? $permsByGroup[$vDiff] : '';
                                $dataPermission['permission'] = $vDiff;
                                $dataPermission['id_user_group'] = $id;
                                $d->insert('user_group_permission', $dataPermission);
                            }
                        }
                    } else {
                        /* Không tồn tại quyền cũ => Thêm mới toàn bộ quyền mới */
                        foreach ($permsNew as $v) {
                            $dataPermission = array();
                            $dataPermission['perms_group'] = $v['perms_group'];
                            $dataPermission['permission'] = $v['permission'];
                            $dataPermission['id_user_group'] = $id;
                            $d->insert('user_group_permission', $dataPermission);
                        }
                    }
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=user&act=man_group&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=user&act=man_group&p=" . $curPage, false);
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('user_group', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Category */
            if (!empty($dataCategory)) {
                $dataCategory['id_user_group'] = $id_insert;

                if ($d->insert('user_group_category', $dataCategory)) {
                    if (!empty($dataMultiCategoryCat)) {
                        foreach ($dataMultiCategoryCat as $v) {
                            $dataCategoryCat = array();
                            $dataCategoryCat['id_user_group'] = $id_insert;
                            $dataCategoryCat['id_list'] = $dataCategory['id_list'];
                            $dataCategoryCat['id_cat'] = $v;
                            $d->insert('user_group_category_cat', $dataCategoryCat);
                        }
                    }
                }
            }

            /* Places */
            if ($placeGroup) {
                foreach ($placeGroup as $v) {
                    if (strstr($v, ',')) {
                        $v_explode = explode(",", $v);
                        $dataPlace = array();
                        $dataPlace['id_region'] = trim($v_explode[0]);
                        $dataPlace['id_city'] = trim($v_explode[1]);
                        $dataPlace['id_user_group'] = $id_insert;
                        $d->insert('user_group_place', $dataPlace);
                    }
                }
            }

            /* Admins */
            if ($adminGroup) {
                foreach ($adminGroup as $v) {
                    $dataAdmin = array();
                    $dataAdmin['id_admin'] = $v;
                    $dataAdmin['is_leader'] = ($leader == $v) ? 1 : 0;
                    $dataAdmin['id_user_group'] = $id_insert;
                    $d->insert('user_group_admin', $dataAdmin);
                }
            }

            /* Permissions */
            if ($permissionGroup && $permissionLists) {
                foreach ($permissionGroup as $vPermGroup) {
                    if (!empty($permissionLists[$vPermGroup])) {
                        foreach ($permissionLists[$vPermGroup] as $v) {
                            $dataPermission = array();
                            $dataPermission['perms_group'] = $vPermGroup;
                            $dataPermission['permission'] = $v;
                            $dataPermission['id_user_group'] = $id_insert;
                            $d->insert('user_group_permission', $dataPermission);
                        }
                    }
                }
            }

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=user&act=man_group&p=" . $curPage);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=user&act=man_group", false);
        }
    }
}

/* Delete group */
function deleteGroup()
{
    global $d, $func, $curPage;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id from #_user_group where id = ? limit 0,1", array($id));

        if (!empty($row['id'])) {
            /* Xóa group */
            $d->rawQuery("delete from #_user_group where id = ?", array($id));

            /* Xóa category */
            $d->rawQuery("delete from #_user_group_category where id_user_group = ?", array($id));
            $d->rawQuery("delete from #_user_group_category_cat where id_user_group = ?", array($id));

            /* Xóa place */
            $d->rawQuery("delete from #_user_group_place where id_user_group = ?", array($id));

            /* Xóa admins */
            $d->rawQuery("delete from #_user_group_admin where id_user_group = ?", array($id));

            /* Xóa permission */
            $d->rawQuery("delete from #_user_group_permission where id_user_group = ?", array($id));
            $d->rawQuery("delete from #_user_group_admin_permission where id_user_group = ?", array($id));

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=user&act=man_group&p=" . $curPage);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=user&act=man_group&p=" . $curPage, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id from #_user_group where id = ? limit 0,1", array($id));

            if (!empty($row['id'])) {
                /* Xóa group */
                $d->rawQuery("delete from #_user_group where id = ?", array($id));

                /* Xóa category */
                $d->rawQuery("delete from #_user_group_category where id_user_group = ?", array($id));
                $d->rawQuery("delete from #_user_group_category_cat where id_user_group = ?", array($id));

                /* Xóa place */
                $d->rawQuery("delete from #_user_group_place where id_user_group = ?", array($id));

                /* Xóa admins */
                $d->rawQuery("delete from #_user_group_admin where id_user_group = ?", array($id));

                /* Xóa permission */
                $d->rawQuery("delete from #_user_group_permission where id_user_group = ?", array($id));
                $d->rawQuery("delete from #_user_group_admin_permission where id_user_group = ?", array($id));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=user&act=man_group&p=" . $curPage);
    }
    $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man_group&p=" . $curPage, false);
}

/* Add admin perms */
function addAdminPerms()
{
    global $d, $func, $curPage, $item, $loginAdmin, $mainPermissions, $typePermsSector, $listPermissions;

    $idGroup = $func->getGroup('id');
    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    $actBack = ($func->getGroup('virtual')) ? 'man_admin_virtual' : 'man_admin';

    if (empty($id)) $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=" . $actBack . "&p=" . $curPage, false);

    /* Kiểm tra user có tồn tại trong group */
    $checkAdmin = $d->rawQueryOne("select id from #_user_group_admin where id_user_group = ? and id_admin = ? limit 0,1", array($idGroup, $id));

    if (!empty($checkAdmin)) {
        /* Lấy thông tin admin */
        $item = $d->rawQueryOne("select * from #_user where role = 1 and id = ? limit 0,1", array($id));

        /* Kiểm tra nếu là LEADER thì không cho phân quyền */
        $adminDetail = $d->rawQueryOne("select is_leader from #_user_group_admin where id_user_group = ? and id_admin = ?", array($idGroup, $item['id']));

        if (!empty($adminDetail['is_leader'])) {
            $func->transfer("Không thể phân quyền các quản trị viên là trưởng nhóm.", "index.php?com=user&act=" . $actBack . "&p=" . $curPage, false);
        } else {
            /* Main permission */
            $mainPermissions = explode(",", $func->getGroup('permsGroup'));

            /* Type sector to permission */
            $detailList = $func->getInfoDetail('type', 'product_list', $func->getGroup('list'));
            $typePermsSector = $detailList['type'];

            /* Get permissions */
            $itemPermissions = $d->rawQuery("select permission from #_user_group_admin_permission where id_user_group = ? and id_admin = ?", array($idGroup, $id));

            /* Create list permission */
            if (!empty($itemPermissions)) {
                $listPermissions = array();
                foreach ($itemPermissions as $v) {
                    $listPermissions[] = $v['permission'];
                }
            }
        }
    } else {
        $func->transfer("Quản trị viên không tồn tại trong nhóm", "index.php?com=user&act=" . $actBack . "&p=" . $curPage, false);
    }
}

/* Save admin perms */
function saveAdminPerms()
{
    global $d, $func, $curPage, $item, $loginAdmin;

    $actBack = ($func->getGroup('virtual')) ? 'man_admin_virtual' : 'man_admin';

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=" . $actBack . "&p=" . $curPage, false);

    /* Post dữ liệu */
    $idGroup = $func->getGroup('id');
    $idAdmin = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $permissionLists = (!empty($_POST['permissionLists'])) ? $_POST['permissionLists'] : null;

    /* Update or add data */
    if ($permissionLists) {
        $permsOld = $d->rawQuery("select perms_group, permission from #_user_group_admin_permission where id_user_group = ? and id_admin = ?", array($idGroup, $idAdmin));

        foreach ($permissionLists as $kPermsLists => $vPermsLists) {
            foreach ($vPermsLists as $v) {
                $permsNew[] = array(
                    'perms_group' => $kPermsLists,
                    'permission' => $v
                );
                $permsByGroup[$v] = $kPermsLists;
            }
        }

        if (!empty($permsNew)) {
            /* Tồn tại quyền cũ */
            if (!empty($permsOld)) {
                $permsNewTemp = explode(",", $func->joinCols($permsNew, 'permission'));
                $permsOldTemp = explode(",", $func->joinCols($permsOld, 'permission'));

                /* Các quyền cũ cần xóa */
                $permDelete = array_diff($permsOldTemp, $permsNewTemp);

                /* Các quyền cũ cần giữ lại */
                $permInters = array_intersect($permsNewTemp, $permsOldTemp);

                /* Các quyền mới cần thêm */
                $permDiff = array_diff($permsNewTemp, $permsOldTemp);

                /* Xóa quyền cũ */
                /* Cách 1: Xóa các quyền cũ CÓ trong danh sách này */
                if (!empty($permDelete)) {
                    // $func->dump('Các quyền cũ cần xóa');
                    // $func->dump($permDelete);

                    foreach ($permDelete as $vDel) {
                        $d->rawQuery("delete from #_user_group_admin_permission where id_user_group = ? and id_admin = ? and permission = ?", array($idGroup, $idAdmin, $vDel));
                    }
                }

                /* Xóa quyền cũ */
                /* Cách 2: Xóa các quyền cũ KHÔNG CÓ trong danh sách này */
                // if(!empty($permInters))
                // {
                // 	// $func->dump('Các quyền cũ cần giữ lại');
                // 	// $func->dump($permInters);

                // 	foreach($permInters as $kInters => $vInters)
                // 	{
                // 		$permInters[$kInters] = "'".$vInters."'";
                // 	}

                // 	$permInters = implode(",", $permInters);
                // 	$d->rawQuery("delete from #_user_group_admin_permission where id_user_group = ? and id_admin = ? and permission not in ($permInters)",array($idGroup, $idAdmin));
                // }

                /* Thêm các quyền mới */
                if (!empty($permDiff)) {
                    // $func->dump('Các quyền mới cần thêm');
                    // $func->dump($permDiff);

                    foreach ($permDiff as $vDiff) {
                        $dataPermission = array();
                        $dataPermission['perms_group'] = (!empty($permsByGroup[$vDiff])) ? $permsByGroup[$vDiff] : '';
                        $dataPermission['permission'] = $vDiff;
                        $dataPermission['id_user_group'] = $idGroup;
                        $dataPermission['id_admin'] = $idAdmin;
                        $d->insert('user_group_admin_permission', $dataPermission);
                    }
                }
            } else {
                /* Không tồn tại quyền cũ => Thêm mới toàn bộ quyền mới */
                foreach ($permsNew as $v) {
                    $dataPermission = array();
                    $dataPermission['perms_group'] = $v['perms_group'];
                    $dataPermission['permission'] = $v['permission'];
                    $dataPermission['id_user_group'] = $idGroup;
                    $dataPermission['id_admin'] = $idAdmin;
                    $d->insert('user_group_admin_permission', $dataPermission);
                }
            }
        }

        $func->transfer("Phân quyền thành công", "index.php?com=user&act=" . $actBack . "&p=" . $curPage);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=" . $actBack . "&p=" . $curPage, false);
    }
}

/* View admin */
function viewAdmins()
{
    global $d, $func, $curPage, $items, $paging, $strUrl, $config, $loginAdmin;

    $where = " and !find_in_set('virtual',A.status)";
    $adminLists = $func->getGroup('admins');

    /* Lọc những admin thuộc trong group */
    if (!empty($adminLists)) {
        $adminNow = $_SESSION[$loginAdmin]['owner']['id'];
        $adminLists = $adminLists;
        $where .= " and A.id in ($adminLists) and A.id != $adminNow";
    }

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (A.username LIKE '%$keyword%' or A.fullname LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select A.*, C.name as GroupName from #_user as A left join #_user_group_admin as B on B.id_admin = A.id left join #_user_group as C on C.id = B.id_user_group where A.id <> 0 and A.role = 1 $where order by A.numb,A.id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_user as A left join #_user_group_admin as B on B.id_admin = A.id left join #_user_group as C on C.id = B.id_user_group where A.id <> 0 and A.role = 1 $where order by A.numb,A.id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=user&act=man_admin" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit admin */
function editAdmin()
{
    global $d, $func, $curPage, $item;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    $adminLists = (!empty($func->getGroup('admins'))) ? explode(",", $func->getGroup('admins')) : '';

    if (empty($id)) $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man_admin&p=" . $curPage, false);

    if (!empty($id) && !empty($adminLists) && !in_array($id, $adminLists)) $func->transfer("Dữ liệu không hợp lệ", "index.php?com=user&act=man_admin&p=" . $curPage, false);

    $item = $d->rawQueryOne("select A.*, C.name as GroupName from #_user as A left join #_user_group_admin as B on B.id_admin = A.id left join #_user_group as C on C.id = B.id_user_group where A.role = 1 and A.id = ? and !find_in_set('virtual',A.status) limit 0,1", array($id));

    if (empty($item)) $func->transfer("Dữ liệu không có thực", "index.php?com=user&act=man_admin&p=" . $curPage, false);
}

/* Save admin */
function saveAdmin()
{
    global $d, $func, $flash, $curPage, $config;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man_admin&p=" . $curPage, false);

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = htmlspecialchars($_POST['id']);
    $data = (isset($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = ($column == 'password') ? $value : htmlspecialchars($func->sanitize($value));
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        $data['role'] = 1;
        $birthday = $data['birthday'];
        $data['birthday'] = strtotime(str_replace("/", "-", $data['birthday']));
    }

    /* Valid data */
    if (empty($id)) {
        if (empty($data['username'])) {
            $response['messages'][] = 'Tài khoản không được trống';
        }

        if (!empty($data['username']) && !$func->isAlphaNum($data['username'])) {
            $response['messages'][] = 'Tài khoản chỉ được nhập chữ thường và số (chữ thường không dấu, ghi liền nhau, không khoảng trắng)';
        }

        if (!empty($data['username'])) {
            if ($func->checkAccount($data['username'], 'username', 'user')) {
                $response['messages'][] = 'Tài khoản đã tồn tại';
            }
        }
    }

    if (empty($id) || !empty($data['password'])) {
        if (empty($data['password'])) {
            $response['messages'][] = 'Mật khẩu không được trống';
        }

        if (!empty($data['password']) && !$func->isPassword($data['password'])) {
            $response['messages'][] = 'Mật khẩu ít nhất 8 ký tự';
            $response['messages'][] = 'Mật khẩu ít nhất 1 chữ thường';
            $response['messages'][] = 'Mật khẩu ít nhất 1 chữ hoa';
            $response['messages'][] = 'Mật khẩu ít nhất 1 chữ số';
            $response['messages'][] = 'Mật khẩu ít nhất 1 ký tự: !, @, #, &, $, *';
        }

        if (!empty($data['password']) && $func->isPassword($data['password']) && empty($_POST['confirm_password'])) {
            $response['messages'][] = 'Xác nhận mật khẩu không được trống';
        }

        if (!empty($data['password']) && !empty($_POST['confirm_password']) && !$func->isMatch($data['password'], $_POST['confirm_password'])) {
            $response['messages'][] = 'Mật khẩu không trùng khớp';
        }
    }

    if (empty($data['fullname'])) {
        $response['messages'][] = 'Họ tên không được trống';
    }

    if (empty($data['email'])) {
        $response['messages'][] = 'Email không được trống';
    }

    if (!empty($data['email']) && !$func->isEmail($data['email'])) {
        $response['messages'][] = 'Email không hợp lệ';
    }

    if (!empty($data['email'])) {
        if ($func->checkAccount($data['email'], 'email', 'user', $id)) {
            $response['messages'][] = 'Email đã tồn tại';
        }
    }

    if (!empty($data['phone']) && !$func->isPhone($data['phone'])) {
        $response['messages'][] = 'Số điện thoại không hợp lệ';
    }

    if (empty($data['gender'])) {
        $response['messages'][] = 'Chưa chọn giới tính';
    }

    if (empty($birthday)) {
        $response['messages'][] = 'Ngày sinh không được trống';
    }

    if (!empty($birthday) && !$func->isDate($birthday)) {
        $response['messages'][] = 'Ngày sinh không hợp lệ';
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
            $func->redirect("index.php?com=user&act=add_admin");
        } else {
            $func->redirect("index.php?com=user&act=edit_admin&id=" . $id);
        }
    }

    /* Update or add data */
    if ($id) {
        if (!empty($data['password'])) {
            $password = $data['password'];
            $confirm_password = !empty($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
            $data['password'] = md5($config['website']['secret'] . $password . $config['website']['salt']);
        } else {
            unset($data['password']);
        }

        $d->where('id', $id);
        if ($d->update('user', $data)) {
            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=user&act=man_admin&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=user&act=man_admin&p=" . $curPage, false);
        }
    } else {
        if (!empty($data['password'])) {
            $data['password'] = md5($config['website']['secret'] . $data['password'] . $config['website']['salt']);
        }

        if ($d->insert('user', $data)) {
            $func->transfer("Lưu dữ liệu thành công", "index.php?com=user&act=man_admin&p=" . $curPage);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=user&act=man_admin", false);
        }
    }
}

/* Info admin */
function infoAdmin()
{
    global $d, $func, $flash, $curPage, $item, $config, $loginAdmin;

    if (isset($_GET['changepass']) && ($_GET['changepass'] == 1)) $changepass = 1;
    else $changepass = 0;

    if (!empty($_POST)) {
        /* Post dữ liệu */
        $message = '';
        $response = array();
        $id = htmlspecialchars($_POST['id']);
        $data = (isset($_POST['data'])) ? $_POST['data'] : null;
        if ($data) {
            foreach ($data as $column => $value) {
                $data[$column] = htmlspecialchars($func->sanitize($value));
            }
        }

        if (isset($changepass) && $changepass == 1) {
            $old_pass = (isset($_POST['old-password'])) ? $_POST['old-password'] : '';
            $new_pass = (isset($_POST['new-password'])) ? $_POST['new-password'] : '';
            $renew_pass = (isset($_POST['renew-password'])) ? $_POST['renew-password'] : '';

            /* Valid data */
            if (empty($old_pass)) {
                $response['messages'][] = 'Mật khẩu cũ không được trống';
            }

            if (!empty($old_pass)) {
                $whereUser = (!empty($_SESSION[$loginAdmin]['virtual'])) ? " and find_in_set('virtual',status)" : "";
                $row = $d->rawQueryOne("select id, password from #_user where username = ? $whereUser limit 0,1", array($_SESSION[$loginAdmin]['owner']['username']));

                if (empty($row['id']) || (!empty($row['id']) && ($row['password'] != md5($config['website']['secret'] . $old_pass . $config['website']['salt'])))) {
                    $response['messages'][] = 'Mật khẩu cũ không chính xác';
                }
            }

            if (empty($new_pass)) {
                $response['messages'][] = 'Mật khẩu mới không được trống';
            }

            if (!empty($new_pass) && !$func->isPassword($new_pass)) {
                $response['messages'][] = 'Mật khẩu ít nhất 8 ký tự';
                $response['messages'][] = 'Mật khẩu ít nhất 1 chữ thường';
                $response['messages'][] = 'Mật khẩu ít nhất 1 chữ hoa';
                $response['messages'][] = 'Mật khẩu ít nhất 1 chữ số';
                $response['messages'][] = 'Mật khẩu ít nhất 1 ký tự: !, @, #, &, $, *';
            }

            if (!empty($new_pass) && $func->isPassword($new_pass) && empty($renew_pass)) {
                $response['messages'][] = 'Xác nhận mật khẩu mới không được trống';
            }

            if (!empty($new_pass) && !empty($renew_pass) && !$func->isMatch($new_pass, $renew_pass)) {
                $response['messages'][] = 'Mật khẩu mới không trùng khớp';
            }

            if (!empty($response)) {
                $response['status'] = 'danger';
                $message = base64_encode(json_encode($response));
                $flash->set('message', $message);
                $func->redirect("index.php?com=user&act=info_admin&changepass=1");
            }

            /* Change to new password */
            $data['password'] = md5($config['website']['secret'] . $new_pass . $config['website']['salt']);
            $flagchangepass = true;
        } else {
            $birthday = $data['birthday'];
            $data['birthday'] = strtotime(str_replace("/", "-", $data['birthday']));

            /* Valid data */
            if (empty($data['username'])) {
                $response['messages'][] = 'Tài khoản không được trống';
            }

            if (!empty($data['username']) && !$func->isAlphaNum($data['username'])) {
                $response['messages'][] = 'Tài khoản chỉ được nhập chữ thường và số (chữ thường không dấu, ghi liền nhau, không khoảng trắng)';
            }

            if (!empty($data['username'])) {
                if ($func->checkAccount($data['username'], 'username', 'user', $id)) {
                    $response['messages'][] = 'Tài khoản đã tồn tại';
                }
            }

            if (empty($data['fullname'])) {
                $response['messages'][] = 'Họ tên không được trống';
            }

            if (empty($data['email'])) {
                $response['messages'][] = 'Email không được trống';
            }

            if (!empty($data['email']) && !$func->isEmail($data['email'])) {
                $response['messages'][] = 'Email không hợp lệ';
            }

            if (!empty($data['email'])) {
                if ($func->checkAccount($data['email'], 'email', 'user', $id)) {
                    $response['messages'][] = 'Email đã tồn tại';
                }
            }

            if (!empty($data['phone']) && !$func->isPhone($data['phone'])) {
                $response['messages'][] = 'Số điện thoại không hợp lệ';
            }

            if (empty($data['gender'])) {
                $response['messages'][] = 'Chưa chọn giới tính';
            }

            if (empty($birthday)) {
                $response['messages'][] = 'Ngày sinh không được trống';
            }

            if (!empty($birthday) && !$func->isDate($birthday)) {
                $response['messages'][] = 'Ngày sinh không hợp lệ';
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
                $func->redirect("index.php?com=user&act=info_admin");
            }
        }

        /* Update or add data */
        $d->where('username', $_SESSION[$loginAdmin]['owner']['username']);
        if ($d->update('user', $data)) {
            if (isset($flagchangepass) && $flagchangepass == true) {
                if (!empty($_SESSION[TOKEN])) unset($_SESSION[TOKEN]);
                unset($_SESSION[$loginAdmin]);
                $func->transfer("Cập nhật dữ liệu thành công", "index.php");
            }
            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=user&act=info_admin");
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=user&act=info_admin");
        }
    }

    $item = $d->rawQueryOne("select * from #_user where username = ? limit 0,1", array($_SESSION[$loginAdmin]['owner']['username']));
}

/* Delete admin */
function deleteAdmin()
{
    global $d, $func, $curPage;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* check admin is exist in Group */
        $rowGroup = $d->rawQueryOne("select id from #_user_group_admin where id_admin = ? limit 0,1", array($id));

        if (!empty($rowGroup)) {
            $func->transfer("Không thể xóa. Admin đang tồn tại trong Nhóm Quản Trị.", "index.php?com=user&act=man_admin&p=" . $curPage, false);
        } else {
            $row = $d->rawQueryOne("select id from #_user where id = ? and !find_in_set('virtual',status) limit 0,1", array($id));

            if (!empty($row['id'])) {
                /* Xóa main */
                $d->rawQuery("delete from #_user where id = ? and role = 1 and !find_in_set('virtual',status)", array($id));

                /* Xóa dữ liệu liên quan */
                deleteRelatedData($id, 'admin');

                $func->transfer("Xóa dữ liệu thành công", "index.php?com=user&act=man_admin&p=" . $curPage);
            } else {
                $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=user&act=man_admin&p=" . $curPage, false);
            }
        }
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man_admin&p=" . $curPage, false);
    }
}

/* View admin virtual */
function viewAdminsVirtual()
{
    global $d, $func, $curPage, $items, $paging, $strUrl, $config, $loginAdmin;

    $where = " and find_in_set('virtual',A.status)";
    $adminLists = $func->getGroup('admins');

    /* Lọc những admin thuộc trong group */
    if (!empty($adminLists)) {
        $adminNow = $_SESSION[$loginAdmin]['owner']['id'];
        $adminLists = $adminLists;
        $where .= " and A.id in ($adminLists) and A.id != $adminNow";
    }

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (A.username LIKE '%$keyword%' or A.fullname LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select A.*, C.name as GroupName from #_user as A left join #_user_group_admin as B on B.id_admin = A.id left join #_user_group as C on C.id = B.id_user_group where A.id <> 0 and A.role = 1 $where order by A.numb,A.id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_user as A left join #_user_group_admin as B on B.id_admin = A.id left join #_user_group as C on C.id = B.id_user_group where A.id <> 0 and A.role = 1 $where order by A.numb,A.id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=user&act=man_admin_virtual" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit admin virtual */
function editAdminVirtual()
{
    global $d, $func, $curPage, $item;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    $adminLists = (!empty($func->getGroup('admins'))) ? explode(",", $func->getGroup('admins')) : '';

    if (empty($id)) $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man_admin_virtual&p=" . $curPage, false);

    if (!empty($id) && !empty($adminLists) && !in_array($id, $adminLists)) $func->transfer("Dữ liệu không hợp lệ", "index.php?com=user&act=man_admin_virtual&p=" . $curPage, false);

    $item = $d->rawQueryOne("select A.*, C.name as GroupName from #_user as A left join #_user_group_admin as B on B.id_admin = A.id left join #_user_group as C on C.id = B.id_user_group where A.role = 1 and A.id = ? and find_in_set('virtual',A.status) limit 0,1", array($id));

    if (empty($item)) $func->transfer("Dữ liệu không có thực", "index.php?com=user&act=man_admin_virtual&p=" . $curPage, false);
}

/* Save admin virtual */
function saveAdminVirtual()
{
    global $d, $func, $flash, $curPage, $config;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man_admin_virtual&p=" . $curPage, false);

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = htmlspecialchars($_POST['id']);
    $data = (isset($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = ($column == 'password') ? $value : htmlspecialchars($func->sanitize($value));
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? $status . 'virtual' : "virtual";
        } else {
            $data['status'] = "virtual";
        }

        $data['role'] = 1;
        $birthday = $data['birthday'];
        $data['birthday'] = strtotime(str_replace("/", "-", $data['birthday']));
    }

    /* Valid data */
    if (empty($id)) {
        if (empty($data['username'])) {
            $response['messages'][] = 'Tài khoản không được trống';
        }

        if (!empty($data['username']) && !$func->isAlphaNum($data['username'])) {
            $response['messages'][] = 'Tài khoản chỉ được nhập chữ thường và số (chữ thường không dấu, ghi liền nhau, không khoảng trắng)';
        }

        if (!empty($data['username'])) {
            if ($func->checkAccount($data['username'], 'username', 'user')) {
                $response['messages'][] = 'Tài khoản đã tồn tại';
            }
        }
    }

    if (empty($id) || !empty($data['password'])) {
        if (empty($data['password'])) {
            $response['messages'][] = 'Mật khẩu không được trống';
        }

        if (!empty($data['password']) && !$func->isPassword($data['password'])) {
            $response['messages'][] = 'Mật khẩu ít nhất 8 ký tự';
            $response['messages'][] = 'Mật khẩu ít nhất 1 chữ thường';
            $response['messages'][] = 'Mật khẩu ít nhất 1 chữ hoa';
            $response['messages'][] = 'Mật khẩu ít nhất 1 chữ số';
            $response['messages'][] = 'Mật khẩu ít nhất 1 ký tự: !, @, #, &, $, *';
        }

        if (!empty($data['password']) && $func->isPassword($data['password']) && empty($_POST['confirm_password'])) {
            $response['messages'][] = 'Xác nhận mật khẩu không được trống';
        }

        if (!empty($data['password']) && !empty($_POST['confirm_password']) && !$func->isMatch($data['password'], $_POST['confirm_password'])) {
            $response['messages'][] = 'Mật khẩu không trùng khớp';
        }
    }

    if (empty($data['fullname'])) {
        $response['messages'][] = 'Họ tên không được trống';
    }

    // if (empty($data['email'])) {
    //     $response['messages'][] = 'Email không được trống';
    // }

    // if (!empty($data['email']) && !$func->isEmail($data['email'])) {
    //     $response['messages'][] = 'Email không hợp lệ';
    // }

    // if (!empty($data['email'])) {
    //     if ($func->checkAccount($data['email'], 'email', 'user', $id)) {
    //         $response['messages'][] = 'Email đã tồn tại';
    //     }
    // }

    // if (!empty($data['phone']) && !$func->isPhone($data['phone'])) {
    //     $response['messages'][] = 'Số điện thoại không hợp lệ';
    // }

    if (empty($data['gender'])) {
        $response['messages'][] = 'Chưa chọn giới tính';
    }

    if (empty($birthday)) {
        $response['messages'][] = 'Ngày sinh không được trống';
    }

    if (!empty($birthday) && !$func->isDate($birthday)) {
        $response['messages'][] = 'Ngày sinh không hợp lệ';
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
            $func->redirect("index.php?com=user&act=add_admin_virtual");
        } else {
            $func->redirect("index.php?com=user&act=edit_admin_virtual&id=" . $id);
        }
    }

    /* Update or add data */
    if ($id) {
        if (!empty($data['password'])) {
            $password = $data['password'];
            $confirm_password = !empty($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
            $data['password'] = md5($config['website']['secret'] . $password . $config['website']['salt']);
        } else {
            unset($data['password']);
        }

        $d->where('id', $id);
        if ($d->update('user', $data)) {
            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=user&act=man_admin_virtual&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=user&act=man_admin_virtual&p=" . $curPage, false);
        }
    } else {
        if (!empty($data['password'])) {
            $data['password'] = md5($config['website']['secret'] . $data['password'] . $config['website']['salt']);
        }

        if ($d->insert('user', $data)) {
            $func->transfer("Lưu dữ liệu thành công", "index.php?com=user&act=man_admin_virtual&p=" . $curPage);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=user&act=man_admin_virtual", false);
        }
    }
}

/* Delete admin virtual */
function deleteAdminVirtual()
{
    global $d, $func, $curPage;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id from #_user where id = ? and find_in_set('virtual',status) limit 0,1", array($id));

        if (!empty($row['id'])) {
            /* Xóa main */
            $d->rawQuery("delete from #_user where id = ? and role = 1 and find_in_set('virtual',status)", array($id));

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=user&act=man_admin_virtual&p=" . $curPage);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=user&act=man_admin_virtual&p=" . $curPage, false);
        }
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man_admin_virtual&p=" . $curPage, false);
    }
}

/* View member */
function viewMembers()
{
    global $d, $func, $curPage, $items, $paging, $strUrl, $config;

    $where = " and !find_in_set('virtual',status)";

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (username LIKE '%$keyword%' or fullname LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_member where id <> 0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_member where id <> 0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=user&act=man_member" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* View dashboard member */
function viewMembersDashboard()
{
    global $d, $item;

    $item = $d->rawQueryOne("select * from #_member_dashboard limit 0,1");
}

/* Save dashboard member */
function saveMembersDashboard()
{
    global $d, $func, $flash, $config, $curPage;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=update_member_dashboard", false);

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (isset($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $placeGroup = (!empty($_POST['place_group'])) ? $_POST['place_group'] : null;
    $data['gender'] = (!empty($_POST['gender_group'])) ? implode(",", $_POST['gender_group']) : '';

    /* Detail */
    $dashboard = $d->rawQueryOne("select * from #_member_dashboard where id = ? limit 0,1", array($id));

    /* Place */
    if (!empty($placeGroup)) {
        $city = array();
        foreach ($placeGroup as $v) {
            $place = explode(",", $v);
            $city[] = $place[1];
        }

        if (!empty($city)) {
            $city = array_unique($city);
            $data['id_city'] = implode(",", $city);
        }
    }

    if (empty($placeGroup)) {
        $response['messages'][] = 'Chưa chọn tỉnh/thành phố';
    }

    if (empty($data['gender'])) {
        $response['messages'][] = 'Chưa chọn giới tính';
    }

    if (!empty($response)) {
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);
        $func->redirect("index.php?com=user&act=update_member_dashboard");
    }

    if (!empty($dashboard['id'])) {
        if ($d->update('member_dashboard', $data)) {
            /* Photo 1 */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo1 = $func->uploadImage("file", $config['user']['member']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo1 from #_member_dashboard limit 0,1");

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PHOTO . $row['photo1']);
                    }

                    $photoUpdate['photo1'] = $photo1;
                    $d->where('id', $id);
                    $d->update('member_dashboard', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 2 */
            if ($func->hasFile("file-2")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file-2"]["name"]);

                if ($photo2 = $func->uploadImage("file-2", $config['user']['member']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo2 from #_member_dashboard limit 0,1");

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PHOTO . $row['photo2']);
                    }

                    $photoUpdate['photo2'] = $photo2;
                    $d->where('id', $id);
                    $d->update('member_dashboard', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=user&act=update_member_dashboard");
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=user&act=update_member_dashboard", false);
        }
    } else {
        if ($d->insert('member_dashboard', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo 1 */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo1 = $func->uploadImage("file", $config['user']['member']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $photoUpdate['photo1'] = $photo1;
                    $d->where('id', $id_insert);
                    $d->update('member_dashboard', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 2 */
            if ($func->hasFile("file-2")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file-2']["name"]);

                if ($photo2 = $func->uploadImage("file-2", $config['user']['member']['img_type'], UPLOAD_PHOTO, $file_name)) {
                    $photoUpdate['photo2'] = $photo2;
                    $d->where('id', $id_insert);
                    $d->update('member_dashboard', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=user&act=update_member_dashboard");
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=user&act=update_member_dashboard", false);
        }
    }
}

/* Edit member */
function editMember()
{
    global $d, $func, $curPage, $curPageChild, $item, $mails, $paging;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man_member&p=" . $curPage, false);

    $item = $d->rawQueryOne("select * from #_member where id = ? and !find_in_set('virtual',status) limit 0,1", array($id));

    if (empty($item)) $func->transfer("Dữ liệu không có thực", "index.php?com=user&act=man_member&p=" . $curPage, false);

    /* Get mails */
    $perPage = 10;
    $startpoint = ($curPageChild * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select id, title, content from #_member_mails where id_member = ? order by id desc $limit";
    $mails = $d->rawQuery($sql, array($id));
    $sqlNum = "select count(*) as 'num' from #_member_mails where id_member = ? order by id desc";
    $count = $d->rawQueryOne($sqlNum, array($id));
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=user&act=edit_member&p=" . $curPage . "&id_city=" . $item['id_city'] . "&id_district=" . $item['id_district'] . "&id_wards=" . $item['id_wards'] . "&id=" . $item['id'] . "";
    $paging = $func->pagination($total, $perPage, $curPageChild, $url, 'pchild');
}

/* Save member */
function saveMember()
{
    global $d, $func, $flash, $strUrl, $config, $curPage;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man_member&p=" . $curPage, false);

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = htmlspecialchars($_POST['id']);
    $data = (isset($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = ($column == 'password') ? $value : htmlspecialchars($func->sanitize($value));
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        $birthday = $data['birthday'];
        $data['birthday'] = strtotime(str_replace("/", "-", $data['birthday']));
    }

    /* Valid data */
    if (empty($id)) {
        if (empty($data['username'])) {
            $response['messages'][] = 'Tài khoản không được trống';
        }

        if (!empty($data['username']) && !$func->isPhone($data['username'])) {
            $response['messages'][] = 'Tài khoản không hợp lệ';
        }

        if (!empty($data['username'])) {
            if ($func->checkAccount($data['username'], 'username', 'member')) {
                $response['messages'][] = 'Tài khoản đã tồn tại';
            }
        }
    }

    if (empty($id) || !empty($data['password'])) {
        if (empty($data['password'])) {
            $response['messages'][] = 'Mật khẩu không được trống';
        }

        if (!empty($data['password']) && !$func->isPassword($data['password'])) {
            $response['messages'][] = 'Mật khẩu ít nhất 8 ký tự';
            $response['messages'][] = 'Mật khẩu ít nhất 1 chữ thường';
            $response['messages'][] = 'Mật khẩu ít nhất 1 chữ hoa';
            $response['messages'][] = 'Mật khẩu ít nhất 1 chữ số';
            $response['messages'][] = 'Mật khẩu ít nhất 1 ký tự: !, @, #, &, $, *';
        }

        if (!empty($data['password']) && $func->isPassword($data['password']) && empty($_POST['confirm_password'])) {
            $response['messages'][] = 'Xác nhận mật khẩu không được trống';
        }

        if (!empty($data['password']) && !empty($_POST['confirm_password']) && !$func->isMatch($data['password'], $_POST['confirm_password'])) {
            $response['messages'][] = 'Mật khẩu không trùng khớp';
        }
    }

    if (empty($data['first_name']) || empty($data['last_name'])) {
        $response['messages'][] = 'Họ tên không được trống';
    } else {
        $data['fullname'] = trim($data['first_name']) . ' ' . trim($data['last_name']);
    }

    if (empty($data['id_city'])) {
        $response['messages'][] = 'Chưa chọn tỉnh/thành phố';
    } else {
        $cityInfo = $func->getInfoDetail('id_region', 'city', $data['id_city']);
        $data['id_region'] = (!empty($cityInfo)) ? $cityInfo['id_region'] : 0;
    }

    if (empty($data['id_district'])) {
        $response['messages'][] = 'Chưa chọn quận/huyện';
    }

    if (empty($data['id_wards'])) {
        $response['messages'][] = 'Chưa chọn phường/xã';
    }

    if (!empty($data['phone']) && !$func->isPhone($data['phone'])) {
        $response['messages'][] = 'Số điện thoại không hợp lệ';
    }

    if (empty($data['email'])) {
        $response['messages'][] = 'Email không được trống';
    }

    if (!empty($data['email']) && !$func->isEmail($data['email'])) {
        $response['messages'][] = 'Email không hợp lệ';
    }

    if (!empty($data['email'])) {
        if ($func->checkAccount($data['email'], 'email', 'member', $id)) {
            $response['messages'][] = 'Email đã tồn tại';
        }
    }

    if (empty($data['gender'])) {
        $response['messages'][] = 'Chưa chọn giới tính';
    }

    if (empty($birthday)) {
        $response['messages'][] = 'Ngày sinh không được trống';
    }

    if (!empty($birthday) && !$func->isDate($birthday)) {
        $response['messages'][] = 'Ngày sinh không hợp lệ';
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
            $func->redirect("index.php?com=user&act=add_member" . $strUrl);
        } else {
            $func->redirect("index.php?com=user&act=edit_member&id=" . $id . $strUrl);
        }
    }

    /* Update or add data */
    if ($id) {
        if (!empty($data['password'])) {
            $password = $data['password'];
            $confirm_password = !empty($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
            $data['password'] = md5($password);
        } else {
            unset($data['password']);
        }

        $d->where('id', $id);
        if ($d->update('member', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($avatar = $func->uploadImage("file", $config['user']['member']['img_type'], UPLOAD_USER, $file_name)) {
                    $row = $d->rawQueryOne("select id, avatar from #_member where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_USER . $row['avatar']);
                    }

                    $photoUpdate['avatar'] = $avatar;
                    $d->where('id', $id);
                    $d->update('member', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=user&act=man_member&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=user&act=man_member&p=" . $curPage, false);
        }
    } else {
        if (!empty($data['password'])) {
            $data['password'] = md5($data['password']);
        }

        if ($d->insert('member', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($avatar = $func->uploadImage("file", $config['user']['member']['img_type'], UPLOAD_USER, $file_name)) {
                    $photoUpdate['avatar'] = $avatar;
                    $d->where('id', $id_insert);
                    $d->update('member', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=user&act=man_member&p=" . $curPage);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=user&act=man_member&p=" . $curPage, false);
        }
    }
}

/* Delete member */
function deleteMember()
{
    global $d, $func, $curPage;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id, avatar from #_member where id = ? and !find_in_set('virtual',status) limit 0,1", array($id));

        if (!empty($row['id'])) {
            /* Xóa main */
            $func->deleteFile(UPLOAD_USER . $row['avatar']);
            $d->rawQuery("delete from #_member where id = ? and !find_in_set('virtual',status)", array($id));

            /* Xóa member new posting */
            $d->rawQuery("delete from #_member_new_posting where id_member = ?", array($id));

            /* Xóa member favourite */
            $d->rawQuery("delete from #_member_favourite where id_member = ?", array($id));

            /* Xóa member newsfeed */
            $d->rawQuery("delete from #_member_newsfeed where id_member = ?", array($id));

            /* Xóa member subscribe */
            $d->rawQuery("delete from #_member_subscribe where id_member = ?", array($id));

            /* Xóa dữ liệu liên quan */
            deleteRelatedData($id, 'member');

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=user&act=man_member&p=" . $curPage);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=user&act=man_member&p=" . $curPage, false);
        }
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=user&act=man_member&p=" . $curPage, false);
    }
}

/* Delete related data */
function deleteRelatedData($id = 0, $type = '')
{
    global $d, $func, $defineSectors;

    if (empty($id) || empty($type) || !in_array($type, array('member', 'admin'))) {
        return false;
    }

    /* Data */
    $dataTemp = array();
    $idOwner = ($type == 'member') ? 'id_member' : (($type == 'admin') ? 'id_admin' : '');

    if (empty($idOwner)) {
        return false;
    }

    /* Get data from order */
    if ($type == 'member') {
        /* Get order main */
        $orderMain = $d->rawQuery("select id from #_order where id_user = ?", array($id));

        /* Check to delete order main */
        if (!empty($orderMain)) {
            foreach ($orderMain as $v_orderMain) {
                /* Delete order main */
                $d->rawQuery("delete from #_order where id = ?", array($v_orderMain['id']));

                /* Delete order info */
                $d->rawQuery("delete from #_order_info where id_order = ?", array($v_orderMain['id']));

                /* Get order group */
                $orderGroup = $d->rawQuery("select id from #_order_group where id_order = ? or id_member = ?", array($v_orderMain['id'], $id));

                /* Delete order group */
                $d->rawQuery("delete from #_order_group where id_order = ?", array($v_orderMain['id']));

                /* Delete order group by id member */
                $d->rawQuery("delete from #_order_group where id_member = ?", array($id));

                /* Delete order detail */
                if (!empty($orderGroup)) {
                    foreach ($orderGroup as $v_orderGroup) {
                        $d->rawQuery("delete from #_order_detail where id_group = ?", array($v_orderGroup['id']));
                    }
                }
            }
        }

        /* Delete chat */
        foreach ($defineSectors['hasShop']['types'] as $k_define_sector => $v_define_sector) {
            $tableShopChat = $defineSectors['types'][$v_define_sector]['tables']['shop-chat'];
            $tableShopChatPhoto = $defineSectors['types'][$v_define_sector]['tables']['shop-chat-photo'];

            /* Get data chat */
            $rowChat = $d->rawQuery("select id, id_parent from #_$tableShopChat where id_member = ?", array($id));

            if (!empty($rowChat)) {
                foreach ($rowChat as $v) {
                    $d->rawQuery("delete from #_$tableShopChat where id = ?", array($v['id']));

                    /* Photo */
                    if ($v['id_parent'] == 0) {
                        $photo = $d->rawQuery("select photo from #_$tableShopChatPhoto where id_parent = ?", array($v['id']));

                        if (!empty($photo)) {
                            foreach ($photo as $v_photo) {
                                $func->deleteFile(UPLOAD_PHOTO . $v_photo['photo']);
                            }
                        }

                        $d->rawQuery("delete from #_$tableShopChatPhoto where id_parent = ?", array($v['id']));
                    }
                }
            }
        }
    }

    /* Get data from sector */
    foreach ($defineSectors['types'] as $k_define_sector => $v_define_sector) {
        /* Get data shop */
        if (!empty($v_define_sector['tables']['shop'])) {
            $shopMember = $d->rawQuery("select id from #_" . $v_define_sector['tables']['shop'] . " where $idOwner = ?", array($id));
            $dataTemp['shop'][$v_define_sector['tables']['shop']] = array(
                'config' => $v_define_sector,
                'data' => $shopMember
            );
        }

        /* Get data product */
        $productMember = $d->rawQuery("select id from #_" . $v_define_sector['tables']['main'] . " where $idOwner = ?", array($id));
        $dataTemp['product'][$v_define_sector['tables']['main']] = array(
            'config' => $v_define_sector,
            'data' => $productMember
        );
    }

    /* Xóa shop */
    if (!empty($dataTemp['shop'])) {
        foreach ($dataTemp['shop'] as $k_shop => $v_shop) {
            if (!empty($v_shop['data'])) {
                foreach ($v_shop['data'] as $v) {
                    $rowShop = $d->rawQueryOne("select id, photo, folder from #_$k_shop where id = ? limit 0,1", array($v['id']));

                    /* Check data detail */
                    if (!empty($rowShop['id'])) {
                        /* Paths to delete shop */
                        $paths = array(
                            'shop' => UPLOAD_SHOP,
                            'filemanager' => UPLOAD_FILEMANAGER,
                            'product' => UPLOAD_PRODUCT,
                            'photo' => UPLOAD_PHOTO,
                            'news' => UPLOAD_NEWS,
                            'contact-file' => UPLOAD_FILE,
                            'seopage' => UPLOAD_SEOPAGE,
                            'static' => UPLOAD_NEWS,
                        );

                        /* Delete shop */
                        $func->deleteShop($rowShop, $v_shop['config'], $paths);
                    }
                }
            }
        }
    }

    /* Xóa product */
    if (!empty($dataTemp['product'])) {
        foreach ($dataTemp['product'] as $k_product => $v_product) {
            if (!empty($v_product['data'])) {
                foreach ($v_product['data'] as $v) {
                    $rowProduct = $d->rawQueryOne("select id, photo from #_$k_product where id = ?", array($v['id']));

                    /* Check data detail */
                    if (!empty($rowProduct['id'])) {
                        /* Delete shop */
                        $func->deleteProduct($rowProduct, $v_product['config'], UPLOAD_PRODUCT);
                    }
                }
            }
        }
    }

    /* Run Maintain database */
    $d->runMaintain();
}

/* Send mails */
function sendMails()
{
    global $d, $func, $flash, $config, $curPage, $setting, $emailer;

    /* Action */
    $action = (!empty($_POST['submit-mails'])) ? htmlspecialchars($_POST['submit-mails']) : '';
    $url_back = (!empty($_POST['url_back'])) ? htmlspecialchars($_POST['url_back']) : '';
    $url_back = (!empty($url_back)) ? str_replace("&amp;", "&", $url_back) : '';
    $id_member = (!empty($_POST['id_member'])) ? htmlspecialchars($_POST['id_member']) : 0;

    if (empty($_POST) || empty($id_member) || empty($action) || $action != 'send-mails') {
        $func->transfer("Không nhận được dữ liệu", "index.php", false);
    }

    /* Get member info */
    $member = $d->rawQueryOne("select fullname, email from #_member where id = ? limit 0,1", array($id_member));

    if (empty($member)) {
        $func->transfer("Thành viên không tồn tại", $url_back, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $dataMails = (isset($_POST['dataMails'])) ? $_POST['dataMails'] : null;
    if ($dataMails) {
        $dataMails['id_member'] = $id_member;

        foreach ($dataMails as $column => $value) {
            $dataMails[$column] = htmlspecialchars($func->sanitize($value));
        }
    }

    /* Valid data */
    if (empty($dataMails['title'])) {
        $response['messages'][] = 'Tiêu đề gửi thư không được trống';
    }

    if (empty($dataMails['content'])) {
        $response['messages'][] = 'Nội dung gửi thư không được trống';
    }

    if (!empty($response)) {
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);
        $func->redirect($url_back);
    }

    /* Add data */
    if ($d->insert('member_mails', $dataMails)) {
        /* Defaults attributes email */
        $emailDefaultAttrs = $emailer->defaultAttrs();

        /* Variables email */
        $emailVars = array(
            '{emailMemberSendMailTitle}',
            '{emailMemberSendMailContent}'
        );
        $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

        /* Values email */
        $emailVals = array(
            htmlspecialchars($dataMails['title']),
            $func->decodeHtmlChars($dataMails['content']),
        );
        $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);


        /* Send mails */
        $arrayEmail = array(
            "dataEmail" => array(
                "name" => $member['fullname'],
                "email" => $member['email']
            )
        );
        $subject = "Thư thông báo từ " . $setting['namevi'];
        $message = str_replace($emailVars, $emailVals, $emailer->markdown('member/send-mail'));
        $file = null;
        $emailer->send("customer", $arrayEmail, $subject, $message, $file);
        $func->transfer("Gửi thông báo thành công. Thành viên có sẽ xem thông báo trong hộp email hoặc trong phần quản lý thông báo của trang tài khoản", $url_back);
    } else {
        $func->transfer("Lưu dữ liệu bị lỗi. Vui lòng thử lại sau", $url_back, false);
    }
}
