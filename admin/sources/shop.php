<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active shop */
if (empty($config['shop']) || !$func->hasShop($configSector)) {
    $func->transfer("Trang không tồn tại", "index.php", false);
}

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('id_cat', 'id_interface', 'id_store', 'id_region', 'id_city', 'id_district', 'id_wards');
if (!empty($_POST['data'])) {
    $dataUrl = $_POST['data'];
    foreach ($arrUrl as $k => $v) {
        if (!empty($dataUrl[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($dataUrl[$arrUrl[$k]]);
    }
} else {
    foreach ($arrUrl as $k => $v) {
        if (!empty($_REQUEST[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($_REQUEST[$arrUrl[$k]]);
    }
    if (!empty($_REQUEST['shop_type'])) $strUrl .= "&shop_type=" . htmlspecialchars($_REQUEST['shop_type']);
    if (!empty($_REQUEST['shop_user'])) $strUrl .= "&shop_user=" . htmlspecialchars($_REQUEST['shop_user']);
    if (!empty($_REQUEST['shop_poster'])) $strUrl .= "&shop_poster=" . htmlspecialchars($_REQUEST['shop_poster']);
    if (!empty($_REQUEST['shop_date'])) $strUrl .= "&shop_date=" . htmlspecialchars($_REQUEST['shop_date']);
    if (!empty($_REQUEST['shop_status'])) $strUrl .= "&shop_status=" . htmlspecialchars($_REQUEST['shop_status']);
    if (!empty($_REQUEST['keyword'])) $strUrl .= "&keyword=" . htmlspecialchars($_REQUEST['keyword']);
}

switch ($act) {
    case "man":
        viewMans();
        $template = "shop/man/mans";
        break;
    case "add":
        addMan();
        $template = "shop/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "shop/man/man_add";
        break;
    case "save":
        saveMan();
        break;
    case "delete":
        deleteMan();
        break;

    default:
        $template = "404";
}

/* View man */
function viewMans()
{
    global $d, $func, $id_list, $strUrl, $loginAdmin, $curPage, $items, $paging, $configSector, $interface, $store;

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        /* Get data */
        $where = "";
        $idlist = $id_list;
        $iduser = $_SESSION[$loginAdmin]['owner']['id'];

        /* Lọc cấp 2 theo Group */
        if ($func->getGroup('active')) {
            if (empty($_REQUEST['id_cat'])) {
                $idCatByGroup = $func->getGroup('cat');
            } else {
                $idcat = (!empty($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
            }
        } else {
            $idcat = (!empty($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
        }

        /* Lọc place theo Group */
        if ($func->getGroup('active') && empty($_REQUEST['id_region']) && empty($_REQUEST['id_city'])) {
            $idregion = $func->getGroup('regions');
            $idcity = $func->getGroup('citys');
        } else if (!empty($_REQUEST['id_region']) || !empty($_REQUEST['id_city'])) {
            if (!empty($_REQUEST['id_region'])) {
                $idregion = (!empty($_REQUEST['id_region'])) ? htmlspecialchars($_REQUEST['id_region']) : 0;
                $idcity = $func->getGroup('citys');
            }

            if (!empty($_REQUEST['id_city'])) {
                $idregion = (!empty($_REQUEST['id_region'])) ? htmlspecialchars($_REQUEST['id_region']) : 0;
                $idcity = (!empty($_REQUEST['id_city'])) ? htmlspecialchars($_REQUEST['id_city']) : 0;
            }
        } else {
            $idregion = $idcity = 0;
        }

        /* Lọc shop theo admin nếu là Group virtual */
        if ($func->getGroup('virtual')) {
            if ($func->getGroup('loggedByLeader')) {
                $id_admin_virtual = $func->getGroup('admins');
            } else {
                $id_admin_virtual = $iduser;
            }
        } else {
            $id_admin_virtual = null;
        }

        /* Get data */
        $idstore = (!empty($_REQUEST['id_store'])) ? htmlspecialchars($_REQUEST['id_store']) : 0;
        $iddistrict = (!empty($_REQUEST['id_district'])) ? htmlspecialchars($_REQUEST['id_district']) : 0;
        $idwards = (!empty($_REQUEST['id_wards'])) ? htmlspecialchars($_REQUEST['id_wards']) : 0;
        $shop_type = (!empty($_REQUEST['shop_type'])) ? htmlspecialchars($_REQUEST['shop_type']) : 0;
        $shop_user = (!empty($_REQUEST['shop_user'])) ? htmlspecialchars($_REQUEST['shop_user']) : 0;
        $shop_poster = (!empty($_REQUEST['shop_poster'])) ? htmlspecialchars($_REQUEST['shop_poster']) : '';
        $shop_date = (!empty($_REQUEST['shop_date'])) ? htmlspecialchars($_REQUEST['shop_date']) : 0;
        $shop_status = (!empty($_REQUEST['shop_status'])) ? htmlspecialchars($_REQUEST['shop_status']) : 0;
        $idinterface = (!empty($_REQUEST['id_interface'])) ? htmlspecialchars($_REQUEST['id_interface']) : 0;

        if ($idlist) $where .= " and S.id_list=$idlist";
        if (!empty($idCatByGroup)) {
            $idcat = implode(',', $idCatByGroup);
            $where .= " and S.id_cat in ($idcat)";
        } else if (!empty($idcat)) {
            $where .= " and S.id_cat=$idcat";
        }
        if ($idstore) $where .= " and S.id_store=$idstore";
        if ($idregion) $where .= (!strstr($idregion, ",")) ? " and S.id_region=$idregion" : " and S.id_region in ($idregion)";
        if ($idcity) $where .= (!strstr($idcity, ",")) ? " and S.id_city=$idcity" : " and S.id_city in ($idcity)";
        if ($iddistrict) $where .= " and S.id_district=$iddistrict";
        if ($idwards) $where .= " and S.id_wards=$idwards";
        if ($idinterface) $where .= " and S.id_interface=$idinterface";
        if ($id_admin_virtual) $where .= " and S.id_admin_virtual in ($id_admin_virtual)";
        if ($shop_type) {
            if ($shop_type == 1) {
                $where .= " and (!find_in_set('virtual',S.status_attr) or S.status_attr is null or S.status_attr = '')";
            } else if ($shop_type == 2) {
                $where .= " and find_in_set('virtual',S.status_attr)";
            } else if ($shop_type == 3) {
                $where .= " and (ST.namevi is null or ltrim(rtrim(ST.namevi)) = '' or C.name is null or ltrim(rtrim(C.name)) = '' or D.name is null or ltrim(rtrim(D.name)) = '' or W.name is null or ltrim(rtrim(W.name)) = '')";
            }
        }
        if ($shop_user) $where .= ($shop_user == 1) ? " and S.id_member > 0" : (($shop_user == 2) ? " and S.id_admin > 0" : "");
        if ($shop_poster && ($shop_type || $shop_user)) {
            $filterPoster = array();
            $filterPoster['table'] = '';
            $filterPoster['where'] = '';

            if ($shop_type == 1) {
                if ($shop_user == 1) {
                    $filterPoster['table'] = "member";
                    $filterPoster['idWhere'] = "id_member";
                } else if ($shop_user == 2) {
                    $filterPoster['table'] = "user";
                    $filterPoster['idWhere'] = "id_admin";
                }
            } else if ($shop_type == 2) {
                $filterPoster['table'] = "user";
                $filterPoster['where'] = " and find_in_set('virtual',status)";
                $filterPoster['idWhere'] = "id_admin_virtual";
            }

            if ($filterPoster['table']) {
                $listsPoster = $d->rawQuery("select id from #_" . $filterPoster['table'] . " where fullname like ? and find_in_set('hienthi',status) " . $filterPoster['where'] . "", array("%$shop_poster%"));
                $IDPoster = (!empty($listsPoster)) ? $func->joinCols($listsPoster, 'id') : '';
                $where .= (!empty($IDPoster)) ? " and S." . $filterPoster['idWhere'] . " in ($IDPoster)" : " and S." . $filterPoster['idWhere'] . " = 0";
            }
        }
        if ($shop_date) {
            $shop_date = explode("-", $shop_date);
            $date_from = trim($shop_date[0] . ' 12:00:00 AM');
            $date_to = trim($shop_date[1] . ' 11:59:59 PM');
            $date_from = strtotime(str_replace("/", "-", $date_from));
            $date_to = strtotime(str_replace("/", "-", $date_to));
            $where .= " and S.date_created<=$date_to and S.date_created>=$date_from";
        }
        if ($shop_status) {
            $where .= ($shop_status == 'new') ? " and S.status = ''" : '';
        }
        if (!empty($_REQUEST['keyword'])) {
            $keyword = htmlspecialchars($_REQUEST['keyword']);
            $where .= " and (S.name LIKE '%$keyword%' or S.slug LIKE '%$keyword%' or S.slug_url LIKE '%$keyword%')";
        }

        /* Where shop not in owner is UNACTIVE */
        $ownerUnActive = $func->getAllOwnerUnActive();

        /* Where owner member */
        if (!empty($ownerUnActive['member'])) {
            $where .= " and S.id_member not in(" . $ownerUnActive['member'] . ")";
        }

        /* Where owner admin */
        if (!empty($ownerUnActive['admin'])) {
            $where .= " and S.id_admin not in(" . $ownerUnActive['admin'] . ")";
        }

        /* Where owner admin virtual */
        if (!empty($ownerUnActive['admin-virtual'])) {
            $where .= " and S.id_admin_virtual not in(" . $ownerUnActive['admin-virtual'] . ")";
        }

        $perPage = 10;
        $startpoint = ($curPage * $perPage) - $perPage;
        $limit = " limit " . $startpoint . "," . $perPage;
        $sql = "select S.*, PC.namevi as productCatName, ST.namevi as storeName, C.name as cityName, D.name as districtName, W.name as wardName, U.fullname as adminFullname from #_" . $configSector['tables']['shop'] . " as S left join #_product_cat as PC on PC.id = S.id_cat left join #_store as ST on ST.id = S.id_store left join #_city as C on C.id = S.id_city left join #_district as D on D.id = S.id_district left join #_wards as W on W.id = S.id_wards left join #_user as U on S.id_admin_virtual = U.id or S.id_admin = U.id where S.id > 0 $where order by S.numb,S.id desc $limit";
        $items = $d->rawQuery($sql);
        $sqlNum = "select count(*) as 'num' from #_" . $configSector['tables']['shop'] . " as S left join #_product_cat as PC on PC.id = S.id_cat left join #_store as ST on ST.id = S.id_store left join #_city as C on C.id = S.id_city left join #_district as D on D.id = S.id_district left join #_wards as W on W.id = S.id_wards left join #_user as U on S.id_admin_virtual = U.id or S.id_admin = U.id where S.id > 0 $where order by S.numb,S.id desc";
        $count = $d->rawQueryOne($sqlNum);
        $total = (!empty($count)) ? $count['num'] : 0;
        $url = "index.php?com=shop&act=man&id_list=" . $id_list . $strUrl;
        $paging = $func->pagination($total, $perPage, $curPage, $url);

        /* Get interface category */
        $interfaceCategory = $d->rawQuery("select id_interface from #_interface_category where id_list = ?", array($idlist));
        $interfaceCategory = (!empty($interfaceCategory)) ? $func->joinCols($interfaceCategory, 'id_interface') : '';

        /* Get interface */
        $whereInterface = (!empty($interfaceCategory)) ? ' and id in (' . $interfaceCategory . ')' : '';
        $interface = $d->rawQuery("select namevi, id from #_interface where id > 0 $whereInterface order by numb,id desc");

        /* Get store */
        $where_store = "";
        if ($idlist) $where_store .= " and id_list=$idlist";
        if (!empty($idCatByGroup)) {
            $idcat = implode(',', $idCatByGroup);
            $where_store .= " and id_cat in ($idcat)";
        } else if (!empty($idcat)) {
            $where_store .= " and id_cat=$idcat";
        }
        $store = $d->rawQuery("select namevi, id from #_store where id > 0 $where_store order by numb,id desc");
    }
}

/* Add man */
function addMan()
{
    global $d, $func, $id_list, $interface, $store;

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        /* Get store */
        $where = "";
        $idlist = $id_list;

        /* Lọc cấp 2 theo Group */
        if ($func->getGroup('active')) {
            if (empty($_REQUEST['id_cat'])) {
                $idCatByGroup = $func->getGroup('cat');
            } else {
                $idcat = (!empty($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
            }
        } else {
            $idcat = (!empty($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
        }

        if ($idlist) $where .= " and id_list=$idlist";
        if (!empty($idCatByGroup)) {
            $idcat = implode(',', $idCatByGroup);
            $where .= " and id_cat in ($idcat)";
        } else if (!empty($idcat)) {
            $where .= " and id_cat=$idcat";
        }

        $store = $d->rawQuery("select namevi, id from #_store where id > 0 $where order by numb,id desc");

        /* Get interface category */
        $interfaceCategory = $d->rawQuery("select id_interface from #_interface_category where id_list = ?", array($idlist));
        $interfaceCategory = (!empty($interfaceCategory)) ? $func->joinCols($interfaceCategory, 'id_interface') : '';

        /* Get interface */
        $whereInterface = (!empty($interfaceCategory)) ? ' and id in (' . $interfaceCategory . ')' : '';
        $interface = $d->rawQuery("select namevi, id from #_interface where id > 0 $whereInterface order by numb,id desc");
    }
}

/* Edit man */
function editMan()
{
    global $d, $func, $id_list, $loginAdmin, $strUrl, $curPage, $item, $itemOwner, $configSector, $interface, $store;

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        $where = "";
        $iduser = $_SESSION[$loginAdmin]['owner']['id'];

        /* Lọc shop theo admin nếu là Group virtual */
        if ($func->getGroup('virtual')) {
            $id_admin_virtual = ($func->getGroup('loggedByLeader')) ? $func->getGroup('admins') : $iduser;
            $where .= " and id_admin_virtual in ($id_admin_virtual)";
        }

        /* ID data */
        $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

        /* Where shop not in owner is UNACTIVE */
        $ownerUnActive = $func->getAllOwnerUnActive();

        /* Where owner member */
        if (!empty($ownerUnActive['member'])) {
            $where .= " and S.id_member not in(" . $ownerUnActive['member'] . ")";
        }

        /* Where owner admin */
        if (!empty($ownerUnActive['admin'])) {
            $where .= " and S.id_admin not in(" . $ownerUnActive['admin'] . ")";
        }

        /* Where owner admin virtual */
        if (!empty($ownerUnActive['admin-virtual'])) {
            $where .= " and S.id_admin_virtual not in(" . $ownerUnActive['admin-virtual'] . ")";
        }

        /* Get data detail from Group */
        if ($func->getGroup('active')) {
            $where .= " and S.id_list=$id_list";

            $idCatByGroup = $func->getGroup('cat');

            if (!empty($idCatByGroup)) {
                $id_cat = (!empty($idCatByGroup)) ? implode(',', $idCatByGroup) : '';
                $where .= " and S.id_cat in ($id_cat)";
            }

            $id_regions = $func->getGroup('regions');
            $where .= " and S.id_region in ($id_regions)";

            $id_citys = $func->getGroup('citys');
            $where .= " and S.id_city in ($id_citys)";
        }

        /* Get data detail */
        $item = $d->rawQueryOne("select S.* from #_" . $configSector['tables']['shop'] . " as S where S.id = ? $where limit 0,1", array($id));

        /* Check data detail */
        if (!empty($item)) {
            /* Get owner Admin or Member */
            if (!empty($item['id_member'])) {
                /* Get owner Member */
                $itemOwner = $d->rawQueryOne("select username, fullname, phone, email, address, password_virtual from #_member where id = ?", array($item['id_member']));
            } else {
                /* Get owner Admin */
                $itemOwner = $d->rawQueryOne("select fullname, phone, email, address from #_user where id = ?", array($item['id_admin']));
            }

            /* Get store */
            $where = "";
            $idlist = $id_list;
            $idcat = (!empty($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
            if ($idlist) $where .= " and id_list=$idlist";
            if ($idcat) $where .= " and id_cat=$idcat";
            $store = $d->rawQuery("select namevi, id from #_store where id > 0 $where order by numb,id desc");

            /* Get interface category */
            $interfaceCategory = $d->rawQuery("select id_interface from #_interface_category where id_list = ?", array($idlist));
            $interfaceCategory = (!empty($interfaceCategory)) ? $func->joinCols($interfaceCategory, 'id_interface') : '';

            /* Get interface */
            $whereInterface = (!empty($interfaceCategory)) ? ' and id in (' . $interfaceCategory . ')' : '';
            $interface = $d->rawQuery("select namevi, id from #_interface where id > 0 $whereInterface order by numb,id desc");
        } else {
            $func->transfer("Dữ liệu không có thực", "index.php?com=shop&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Save man */
function saveMan()
{
    global $d, $strUrl, $id_list, $backPage, $func, $flash, $curPage, $loginAdmin, $config, $configSector;

    /* Check empty post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=shop&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
    }

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        /* Post data */
        $message = '';
        $response = array();
        $backPageDecrypted = $func->decryptString($backPage);
        $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
        $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
        $dataOwnerVirtual = (!empty($_POST['dataOwnerVirtual'])) ? $_POST['dataOwnerVirtual'] : null;

        /* Check logic before save */
        if ($id) {
            /* Where shop not in owner is UNACTIVE */
            $ownerUnActive = $func->getAllOwnerUnActive();
            $whereCheck = '';

            /* Where owner member */
            if (!empty($ownerUnActive['member'])) {
                $whereCheck .= " and S.id_member not in(" . $ownerUnActive['member'] . ")";
            }

            /* Where owner admin */
            if (!empty($ownerUnActive['admin'])) {
                $whereCheck .= " and S.id_admin not in(" . $ownerUnActive['admin'] . ")";
            }

            /* Where owner admin virtual */
            if (!empty($ownerUnActive['admin-virtual'])) {
                $whereCheck .= " and S.id_admin_virtual not in(" . $ownerUnActive['admin-virtual'] . ")";
            }

            /* Check owner */
            $rowDetail = $d->rawQueryOne("select S.id as id from #_" . $configSector['tables']['shop'] . " as S where S.id = ? $whereCheck limit 0,1", array($id));

            if (empty($rowDetail)) {
                $func->transfer("Trang không tồn tại", "index.php?com=shop&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl . "&backPage=" . $backPage, false);
            }
        }

        if ($data) {
            $data['id_list'] = $id_list;

            foreach ($data as $column => $value) {
                $data[$column] = htmlspecialchars($func->sanitize($value));
            }

            if (!empty($data['name'])) {
                $data['slug'] = (!empty($data['name'])) ? $func->changeTitle($data['name']) : '';
                $data['slug_url'] = (!empty($data['slug'])) ? str_replace("-", "", $data['slug']) : '';
            }
        }

        /* data owner virtual */
        if ($dataOwnerVirtual) {
            foreach ($dataOwnerVirtual as $column => $value) {
                $dataOwnerVirtual[$column] = htmlspecialchars($func->sanitize($value));
            }
        }

        /* Valid data */
        if (empty($id)) {
            if (empty($data['name'])) {
                $response['messages'][] = 'Tên gian hàng không được trống';
            }

            if (!empty($data['slug'])) {
                if ($func->checkShop($data, 'name')) {
                    $response['messages'][] = 'Tên gian hàng đã tồn tại';
                }

                if ($func->checkShop($data, 'restricted')) {
                    $response['messages'][] = 'Tên gian hàng không hợp lệ';
                }
            }

            if (!empty($data['name']) && mb_strlen($data['name'], 'utf8') > 50) {
                $response['messages'][] = 'Tên gian hàng không được vượt quá 50 ký tự';
            }

            if (empty($data['email'])) {
                $response['messages'][] = 'Email không được trống';
            }

            if (!empty($data['email']) && !$func->isEmail($data['email'])) {
                $response['messages'][] = 'Email không hợp lệ';
            }

            if (!empty($data['email'])) {
                if ($func->checkShop($data, 'email')) {
                    $response['messages'][] = 'Email đã tồn tại';
                }
            }

            if (!$func->hasFile('file')) {
                $response['messages'][] = 'Hình đại diện không được trống';
            }
        }

        if (empty($data['password'])) {
            $response['messages'][] = 'Mật khẩu không được trống';
        }

        if (empty($data['phone'])) {
            $response['messages'][] = 'Số điện thoại không được trống';
        }

        if (!empty($data['phone']) && !$func->isPhone($data['phone'])) {
            $response['messages'][] = 'Số điện thoại không hợp lệ';
        }

        if (empty($data['id_cat'])) {
            $response['messages'][] = 'Chưa chọn danh mục ngành nghề';
        }

        // if (empty($data['id_interface'])) {
        //     $response['messages'][] = 'Chưa chọn giao diện gian hàng';
        // }

        // if (!empty($data['id_interface'])) {
        //     /* Get interface category */
        //     $checkInterface = $d->rawQueryOne("select id from #_interface_category where id_interface = ? and id_list = ? limit 0,1", array($data['id_interface'], $id_list));

        //     if (empty($checkInterface)) {
        //         $response['messages'][] = 'Giao diện gian hàng không phù hợp';
        //     }
        // }

        if (empty($data['id_store'])) {
            $response['messages'][] = 'Chưa chọn cửa hàng';
        }

        if (empty($data['id_region'])) {
            $response['messages'][] = 'Chưa chọn vùng/miền';
        }

        if (empty($data['id_city'])) {
            $response['messages'][] = 'Chưa chọn tỉnh/thành phố';
        }

        if (empty($data['id_district'])) {
            $response['messages'][] = 'Chưa chọn quận/huyện';
        }

        if (empty($data['id_wards'])) {
            $response['messages'][] = 'Chưa chọn phường/xã';
        }

        if (empty($id) && $func->getGroup('virtual')) {
            if (empty($dataOwnerVirtual['username'])) {
                $response['messages'][] = 'Tài khoản không được trống';
            }

            if (!empty($dataOwnerVirtual['username']) && !$func->isPhone($dataOwnerVirtual['username'])) {
                $response['messages'][] = 'Tài khoản không hợp lệ';
            }

            if (!empty($dataOwnerVirtual['username'])) {
                if ($func->checkAccount($dataOwnerVirtual['username'], 'username', 'member', $id)) {
                    $response['messages'][] = 'Tài khoản đã tồn tại';
                }
            }

            if (empty($dataOwnerVirtual['password_virtual'])) {
                $response['messages'][] = 'Mật khẩu không được trống';
            }

            if (empty($dataOwnerVirtual['first_name']) || empty($dataOwnerVirtual['last_name'])) {
                $response['messages'][] = 'Họ tên không được trống';
            } else {
                $dataOwnerVirtual['fullname'] = trim($dataOwnerVirtual['first_name']) . ' ' . trim($dataOwnerVirtual['last_name']);
            }

            if (empty($dataOwnerVirtual['phone'])) {
                $response['messages'][] = 'Số điện thoại không được trống';
            }

            if (!empty($dataOwnerVirtual['phone']) && !$func->isPhone($dataOwnerVirtual['phone'])) {
                $response['messages'][] = 'Số điện thoại không hợp lệ';
            }

            if (empty($dataOwnerVirtual['email'])) {
                $response['messages'][] = 'Email không được trống';
            }

            if (!empty($dataOwnerVirtual['email']) && !$func->isEmail($dataOwnerVirtual['email'])) {
                $response['messages'][] = 'Email không hợp lệ';
            }

            if (!empty($dataOwnerVirtual['email'])) {
                if ($func->checkAccount($dataOwnerVirtual['email'], 'email', 'member', $id)) {
                    $response['messages'][] = 'Email đã tồn tại';
                }
            }

            if (empty($dataOwnerVirtual['gender'])) {
                $response['messages'][] = 'Chưa chọn giới tính';
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

            /* Flash dataOwnerVirtual */
            if (!empty($dataOwnerVirtual)) {
                foreach ($dataOwnerVirtual as $k => $v) {
                    if (!empty($v)) {
                        $flash->set($k . '_owner_virtual', $v);
                    }
                }
            }

            /* Errors */
            $response['status'] = 'danger';
            $message = base64_encode(json_encode($response));
            $flash->set('message', $message);

            if (empty($id)) {
                $func->redirect("index.php?com=shop&act=add&id_list=" . $id_list . $strUrl . "&backPage=" . $backPage);
            } else {
                $func->redirect("index.php?com=shop&act=edit&id_list=" . $id_list . $strUrl . "&id=" . $id . "&backPage=" . $backPage);
            }
        }

        /* Update or add data */
        if ($id) {
            /* Config for create folder */
            $slugUrl = $func->getInfoDetail('slug_url', $configSector['tables']['shop'], $id);
            $slugUrl = (!empty($slugUrl['slug_url'])) ? $slugUrl['slug_url'] : '';

            $data['date_updated'] = time();

            $d->where('id', $id);
            if ($d->update($configSector['tables']['shop'], $data)) {
                /* Photo */
                if ($func->hasFile("file")) {
                    $photoUpdate = array();
                    $file_name = $func->uploadName($_FILES["file"]["name"]);

                    if ($photo = $func->uploadImage("file", $config['shop']['img_type'], UPLOAD_SHOP, $file_name)) {
                        $row = $d->rawQueryOne("select id, photo from #_" . $configSector['tables']['shop'] . " where id = ? limit 0,1", array($id));

                        if (!empty($row)) {
                            $func->deleteFile(UPLOAD_SHOP . $row['photo']);
                        }

                        $photoUpdate['photo'] = $photo;
                        $d->where('id', $id);
                        $d->update($configSector['tables']['shop'], $photoUpdate);
                        unset($photoUpdate);
                    }
                }

                /* Create folder for Shop */
                if (!empty($slugUrl)) {
                    $dataUpdate = array();
                    $dataUpdate['folder'] = date("Y", time()) . "-" . $slugUrl;
                    $folderFileManager = UPLOAD_FILEMANAGER . $dataUpdate['folder'];

                    if (!file_exists($folderFileManager)) {
                        mkdir($folderFileManager, 0777, true);
                        chmod($folderFileManager, 0777);

                        $d->where('id', $id);
                        $d->update($configSector['tables']['shop'], $dataUpdate);
                        unset($dataUpdate);
                    }
                }

                $func->transfer("Cập nhật dữ liệu thành công", $backPageDecrypted);
            } else {
                $func->transfer("Cập nhật dữ liệu bị lỗi", $backPageDecrypted, false);
            }
        } else {
            /* Check if creator is Virtual */
            if ($func->getGroup("virtual")) {
                $data['id_admin_virtual'] = $_SESSION[$loginAdmin]['owner']['id'];
                $data['status_attr'] = 'virtual';

                /* Create new user virtual for customer */
                $wards = $d->rawQueryOne("select id, id_region, id_city, id_district from #_wards where find_in_set('hienthi',status) limit 0,1");
                $dataOwnerVirtual['id_region'] = $wards['id_region'];
                $dataOwnerVirtual['id_city'] = $wards['id_city'];
                $dataOwnerVirtual['id_district'] = $wards['id_district'];
                $dataOwnerVirtual['id_wards'] = $wards['id'];
                $dataOwnerVirtual['password'] = md5($dataOwnerVirtual['password_virtual']);
                $dataOwnerVirtual['status'] = 'hienthi,virtual';

                if ($d->insert('member', $dataOwnerVirtual)) {
                    $data['id_member'] = $d->getLastInsertId();
                }
            } else {
                $data['id_admin'] = $_SESSION[$loginAdmin]['owner']['id'];
            }

            $data['status'] = 'xetduyet';
            $data['status_user'] = 'hienthi';
            $data['date_created'] = time();

            /* Config for create folder */
            $slugUrl = $data['slug_url'];

            if ($d->insert($configSector['tables']['shop'], $data)) {
                $id_insert = $d->getLastInsertId();

                /* Photo */
                if ($func->hasFile("file")) {
                    $photoUpdate = array();
                    $file_name = $func->uploadName($_FILES['file']["name"]);

                    if ($photo = $func->uploadImage("file", $config['shop']['img_type'], UPLOAD_SHOP, $file_name)) {
                        $photoUpdate['photo'] = $photo;
                        $d->where('id', $id_insert);
                        $d->update($configSector['tables']['shop'], $photoUpdate);
                        unset($photoUpdate);
                    }
                }

                /* Create folder for Shop */
                if (!empty($slugUrl)) {
                    $dataUpdate = array();
                    $dataUpdate['folder'] = date("Y", time()) . "-" . $slugUrl;
                    $folderFileManager = UPLOAD_FILEMANAGER . $dataUpdate['folder'];

                    if (!file_exists($folderFileManager)) {
                        mkdir($folderFileManager, 0777, true);
                        chmod($folderFileManager, 0777);
                    }

                    $d->where('id', $id_insert);
                    $d->update($configSector['tables']['shop'], $dataUpdate);
                    unset($dataUpdate);
                }

                $func->transfer("Lưu dữ liệu thành công", $backPageDecrypted);
            } else {
                $func->transfer("Lưu dữ liệu bị lỗi", $backPageDecrypted, false);
            }
        }
    }
}

/* Delete man */
function deleteMan()
{
    global $d, $strUrl, $id_list, $func, $curPage, $com, $configSector;

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } elseif (!empty($_GET['listid'])) {
 
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);


            $whereCheck = '';



            /* Check owner */
            $rowDetail = $d->rawQueryOne("select S.id as id from #_" . $configSector['tables']['shop'] . " as S where S.id = ?  limit 0,1", array($id));

            /* Get data detail */
            $row = $d->rawQueryOne("select id, id_member, id_admin, name, photo, folder, status, status_attr from #_" . $configSector['tables']['shop'] . " where id = ? limit 0,1", array($id));
                
     
            /* Check data detail */
            if (!empty($row['id']) ) {
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
                $func->deleteShop($row, $configSector, $paths);

                /* Delete member virtual */
                if (in_array($row['status_attr'], array('virtual'))) {
                    $d->rawQuery("delete from #_member where id = ? and find_in_set('virtual',status)", array($row['id_member']));
                }

            }

        }
        $d->runMaintain();

    $func->transfer("Xóa dữ liệu thành công", "index.php?com=shop&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl);
    }
    else {
        /* ID data */
        $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
        $reason = (!empty($_POST['reason-to-delete'])) ? htmlspecialchars($_POST['reason-to-delete']) : '';

        if ($id && $reason) {
            /* Check logic before save */
            /* Where shop not in owner is UNACTIVE */
            $ownerUnActive = $func->getAllOwnerUnActive();
            $whereCheck = '';

            /* Where owner member */
            if (!empty($ownerUnActive['member'])) {
                $whereCheck .= " and S.id_member not in(" . $ownerUnActive['member'] . ")";
            }

            /* Where owner admin */
            if (!empty($ownerUnActive['admin'])) {
                $whereCheck .= " and S.id_admin not in(" . $ownerUnActive['admin'] . ")";
            }

            /* Where owner admin virtual */
            if (!empty($ownerUnActive['admin-virtual'])) {
                $whereCheck .= " and S.id_admin_virtual not in(" . $ownerUnActive['admin-virtual'] . ")";
            }

            /* Check owner */
            $rowDetail = $d->rawQueryOne("select S.id as id from #_" . $configSector['tables']['shop'] . " as S where S.id = ? $whereCheck limit 0,1", array($id));

            if (empty($rowDetail)) {
                $func->transfer("Trang không tồn tại", "index.php?com=shop&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
            }

            /* Get data detail */
            $row = $d->rawQueryOne("select id, id_member, id_admin, name, photo, folder, status, status_attr from #_" . $configSector['tables']['shop'] . " where id = ? limit 0,1", array($id));

            /* Check data detail */
            if ((!empty($row['id']) && (in_array($row['status_attr'], array('virtual')) || in_array($row['status'], array('', 'deleted', 'dangsai', 'vipham')))) || !empty($row['id_admin'])) {
                /* Reason to delete */
                $row['reason'] = $reason;

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
                $func->deleteShop($row, $configSector, $paths);

                /* Delete member virtual */
                if (in_array($row['status_attr'], array('virtual'))) {
                    $d->rawQuery("delete from #_member where id = ? and find_in_set('virtual',status)", array($row['id_member']));
                }

                /* Notice for user */
                noticeForUser($row);

                /* Run Maintain database */
                $d->runMaintain();

                $func->transfer("Xóa dữ liệu thành công", "index.php?com=shop&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl);
            } else {
                $func->transfer("Chỉ được xóa khi shop ở trạng thái: Đang chờ duyệt, Sở hữu bởi ADMIN, Đã xóa bởi thành viên, Đăng sai, Vi phạm", "index.php?com=shop&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
            }
        } else {
            $func->transfer("Không nhận được dữ liệu", "index.php?com=shop&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Notice for user */
function noticeForUser($detail = array())
{
    global $cache, $emailer, $setting;

    if (!empty($detail)) {
        /* Get user info */
        if (!empty($detail['id_member'])) {
            $userDetail = $cache->get("select fullname, email from #_member where id = ? and find_in_set('hienthi',status) limit 0,1", array($detail['id_member']), 'fetch', 7200);
        } else {
            $userDetail = $cache->get("select fullname, email from #_user where id = ? and find_in_set('hienthi',status) limit 0,1", array($detail['id_admin']), 'fetch', 7200);
        }

        /* Send email customer */
        if (!empty($userDetail)) {
            /* Defaults attributes email */
            $emailDefaultAttrs = $emailer->defaultAttrs();

            /* Variables email */
            $emailVars = array(
                '{emailShopName}',
                '{emailReason}'
            );
            $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

            /* Values email */
            $emailVals = array(
                $detail['name'],
                nl2br($detail['reason'])
            );
            $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

            /* Info to send */
            $arrayEmail = array(
                "dataEmail" => array(
                    "name" => $userDetail['fullname'],
                    "email" => $userDetail['email']
                )
            );
            $subject = "Thư thông báo từ " . $setting['namevi'];
            $message = str_replace($emailVars, $emailVals, $emailer->markdown('shop/notice-for-user'));
            $file = null;

            /* Send */
            $emailer->send("customer", $arrayEmail, $subject, $message, $file);
        }
    }
}
