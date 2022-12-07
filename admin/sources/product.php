<?php
if (!defined('SOURCES')) die("Error");

/* Kiểm tra active product */
if (empty($config['product'])) {
    $func->transfer("Trang không tồn tại", "index.php", false);
}

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$arrUrl = array('id_list', 'id_cat', 'id_item', 'id_sub', 'id_region', 'id_city', 'id_district', 'id_wards');
if (!empty($_POST['data'])) {
    $dataUrl = $_POST['data'];
    foreach ($arrUrl as $k => $v) {
        if (!empty($dataUrl[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($dataUrl[$arrUrl[$k]]);
    }
} else {
    foreach ($arrUrl as $k => $v) {
        if (!empty($_REQUEST[$arrUrl[$k]])) $strUrl .= "&" . $arrUrl[$k] . "=" . htmlspecialchars($_REQUEST[$arrUrl[$k]]);
    }
    if (!empty($_REQUEST['posting_type'])) $strUrl .= "&posting_type=" . htmlspecialchars($_REQUEST['posting_type']);
    if (!empty($_REQUEST['posting_user'])) $strUrl .= "&posting_user=" . htmlspecialchars($_REQUEST['posting_user']);
    if (!empty($_REQUEST['posting_poster'])) $strUrl .= "&posting_poster=" . htmlspecialchars($_REQUEST['posting_poster']);
    if (!empty($_REQUEST['posting_date'])) $strUrl .= "&posting_date=" . htmlspecialchars($_REQUEST['posting_date']);
    if (!empty($_REQUEST['posting_status'])) $strUrl .= "&posting_status=" . htmlspecialchars($_REQUEST['posting_status']);
    if (!empty($_REQUEST['comment_status'])) $strUrl .= "&comment_status=" . htmlspecialchars($_REQUEST['comment_status']);
    if (!empty($_REQUEST['keyword'])) $strUrl .= "&keyword=" . htmlspecialchars($_REQUEST['keyword']);
}

switch ($act) {
        /* Man */
    case "man":
        viewMans();
        $template = "product/man/mans";
        break;
    case "add":
        addMan();
        $template = "product/man/man_add";
        break;
    case "edit":
        editMan();
        $template = "product/man/man_add";
        break;
    case "save":
        saveMan();
        break;
    case "delete":
        deleteMan();
        break;

        /* List */
    case "man_list":
        viewLists();
        $template = "product/list/lists";
        break;
    case "add_list":
        $template = "product/list/list_add";
        break;
    case "edit_list":
        editList();
        $template = "product/list/list_add";
        break;
    case "save_list":
        saveList();
        break;

        /* Cat */
    case "man_cat":
        viewCats();
        $template = "product/cat/cats";
        break;
    case "add_cat":
        $template = "product/cat/cat_add";
        break;
    case "edit_cat":
        editCat();
        $template = "product/cat/cat_add";
        break;
    case "save_cat":
        saveCat();
        break;
    case "delete_cat":
        deleteCat();
        break;

        /* Item */
    case "man_item":
        viewItems();
        $template = "product/item/items";
        break;
    case "add_item":
        $template = "product/item/item_add";
        break;
    case "edit_item":
        editItem();
        $template = "product/item/item_add";
        break;
    case "save_item":
        saveItem();
        break;
    case "delete_item":
        deleteItem();
        break;

        /* Sub */
    case "man_sub":
        viewSubs();
        $template = "product/sub/subs";
        break;
    case "add_sub":
        $template = "product/sub/sub_add";
        break;
    case "edit_sub":
        editSub();
        $template = "product/sub/sub_add";
        break;
    case "save_sub":
        saveSub();
        break;
    case "delete_sub":
        deleteSub();
        break;

        /* Tags */
    case "man_tags":
        viewTagss();
        $template = "product/tags/tagss";
        break;
    case "add_tags":
        $template = "product/tags/tags_add";
        break;
    case "edit_tags":
        editTags();
        $template = "product/tags/tags_add";
        break;
    case "save_tags":
        saveTags();
        break;
    case "delete_tags":
        deleteTags();
        break;

        /* Size */
    case "man_size":
        viewSizes();
        $template = "product/size/sizes";
        break;
    case "add_size":
        $template = "product/size/size_add";
        break;
    case "edit_size":
        editSize();
        $template = "product/size/size_add";
        break;
    case "save_size":
        saveSize();
        break;
    case "delete_size":
        deleteSize();
        break;

        /* Color */
    case "man_color":
        viewColors();
        $template = "product/color/colors";
        break;
    case "add_color":
        $template = "product/color/color_add";
        break;
    case "edit_color":
        editColor();
        $template = "product/color/color_add";
        break;
    case "save_color":
        saveColor();
        break;
    case "delete_color":
        deleteColor();
        break;

    default:
        $template = "404";
}

/* View man */
function viewMans()
{
    global $d, $func, $cache, $comment, $id_list, $strUrl, $curPage, $items, $paging, $configSector;

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        /* Get data */
        $where = "";
        $idlist = $id_list;
        $tableShop = (!empty($configSector['tables']['shop'])) ? $configSector['tables']['shop'] : '';
        $tableComment = (!empty($configSector['tables']['comment'])) ? $configSector['tables']['comment'] : '';
        $tableCommentPhoto = (!empty($configSector['tables']['comment-photo'])) ? $configSector['tables']['comment-photo'] : '';
        $tableCommentVideo = (!empty($configSector['tables']['comment-video'])) ? $configSector['tables']['comment-video'] : '';

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

        $iditem = (!empty($_REQUEST['id_item'])) ? htmlspecialchars($_REQUEST['id_item']) : 0;
        $idsub = (!empty($_REQUEST['id_sub'])) ? htmlspecialchars($_REQUEST['id_sub']) : 0;
        $iddistrict = (!empty($_REQUEST['id_district'])) ? htmlspecialchars($_REQUEST['id_district']) : 0;
        $idwards = (!empty($_REQUEST['id_wards'])) ? htmlspecialchars($_REQUEST['id_wards']) : 0;
        $posting_type = (!empty($_REQUEST['posting_type'])) ? htmlspecialchars($_REQUEST['posting_type']) : 0;
        $posting_user = (!empty($_REQUEST['posting_user'])) ? htmlspecialchars($_REQUEST['posting_user']) : 0;
        $posting_poster = (!empty($_REQUEST['posting_poster'])) ? htmlspecialchars($_REQUEST['posting_poster']) : '';
        $posting_date = (!empty($_REQUEST['posting_date'])) ? htmlspecialchars($_REQUEST['posting_date']) : 0;
        $posting_status = (!empty($_REQUEST['posting_status'])) ? htmlspecialchars($_REQUEST['posting_status']) : '';
        $comment_status = (!empty($_REQUEST['comment_status'])) ? htmlspecialchars($_REQUEST['comment_status']) : '';

        if ($idlist) $where .= " and A.id_list=$idlist";
        if (!empty($idCatByGroup)) {
            $idcat = implode(',', $idCatByGroup);
            $where .= " and A.id_cat in ($idcat)";
        } else if (!empty($idcat)) {
            $where .= " and A.id_cat=$idcat";
        }
        if ($iditem) $where .= " and A.id_item=$iditem";
        if ($idsub) $where .= " and A.id_sub=$idsub";
        if ($idregion) $where .= (!strstr($idregion, ",")) ? " and A.id_region=$idregion" : " and A.id_region in ($idregion)";
        if ($idcity) $where .= (!strstr($idcity, ",")) ? " and A.id_city=$idcity" : " and A.id_city in ($idcity)";
        if ($iddistrict) $where .= " and A.id_district=$iddistrict";
        if ($idwards) $where .= " and A.id_wards=$idwards";
        if ($posting_type) {
            $where .= ($posting_type == 1) ? " and A.id_shop = 0" : (($posting_type == 2) ? " and A.id_shop > 0" : "");
        }
        if ($posting_user) {
            $where .= ($posting_user == 1) ? " and A.id_member > 0" : (($posting_user == 2) ? " and A.id_admin > 0" : "");
        }
        if ($posting_poster) {
            $filterPoster = array();
            $filterPoster['table'] = '';
            $filterPoster['where'] = '';

            if ($posting_type == 1) {
                if ($posting_user == 1) {
                    $filterPoster['table'] = "member";
                    $filterPoster['idWhere'] = "id_member";
                } else if ($posting_user == 2) {
                    $filterPoster['table'] = "user";
                    $filterPoster['idWhere'] = "id_admin";
                }
            }

            if ($filterPoster['table']) {
                $listsPoster = $d->rawQuery("select id from #_" . $filterPoster['table'] . " where fullname like ? and find_in_set('hienthi',status) " . $filterPoster['where'] . "", array("%$posting_poster%"));
                $IDPoster = (!empty($listsPoster)) ? $func->joinCols($listsPoster, 'id') : '';
                $where .= (!empty($IDPoster)) ? " and A." . $filterPoster['idWhere'] . " in ($IDPoster)" : '';
            }
        }
        if ($posting_date) {
            $posting_date = explode("-", $posting_date);
            $date_from = trim($posting_date[0] . ' 12:00:00 AM');
            $date_to = trim($posting_date[1] . ' 11:59:59 PM');
            $date_from = strtotime(str_replace("/", "-", $date_from));
            $date_to = strtotime(str_replace("/", "-", $date_to));
            $where .= " and A.date_created<=$date_to and A.date_created>=$date_from";
        }
        if ($posting_status == 'new') {
            $where .= " and A.status = ''";
        }
        if ($comment_status == 'new' && !empty($tableComment)) {
            $comment = $d->rawQuery("select distinct id_product from #_$tableComment where find_in_set('new-admin',status)");
            $idcomment = (!empty($comment)) ? $func->joinCols($comment, 'id_product') : 0;
            $where .= " and id in ($idcomment)";
        }
        if (!empty($_REQUEST['keyword'])) {
            $keyword = htmlspecialchars($_REQUEST['keyword']);
            $where .= " and (A.namevi LIKE '%$keyword%' or A.nameen LIKE '%$keyword%')";
        }

        /* Where logic when owner or shop unactive */
        $whereLogicOwner = $func->getLogicOwner($tableShop, $configSector, false);
        $where .= $whereLogicOwner['where'];

        $perPage = 10;
        $startpoint = ($curPage * $perPage) - $perPage;
        $limit = " limit " . $startpoint . "," . $perPage;
        $sql = "select A.*, A.id as id from #_" . $configSector['tables']['main'] . " as A where A.id > 0 $where order by A.date_created desc $limit";
        $items = $d->rawQuery($sql);
        $sqlNum = "select count(*) as 'num' from #_" . $configSector['tables']['main'] . " as A where A.id > 0 $where order by A.date_created desc";
        $count = $d->rawQueryOne($sqlNum);
        $total = (!empty($count)) ? $count['num'] : 0;
        $url = "index.php?com=product&act=man&id_list=" . $id_list . $strUrl;
        $paging = $func->pagination($total, $perPage, $curPage, $url);

        /* Comment */
        $comment = new Comments($d, $func, ['shop' => $tableShop, 'main' => $tableComment, 'photo' => $tableCommentPhoto, 'video' => $tableCommentVideo], $configSector['prefix']);
    }
}

/* Add man */
function addMan()
{
    global $d, $func, $id_list, $curPage, $configSector, $typePrice, $formWork, $experience;

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        /* Get type price */
        if (in_array("price", $configSector['attributes']) || in_array("salary", $configSector['attributes'])) {
            $typePrice = $d->rawQuery("select namevi, id from #_variation where id_list = ? and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($configSector['id'], 'loai-gia'));
        }

        /* Get form work */
        if (in_array("form-work", $configSector['attributes'])) {
            $formWork = $d->rawQuery("select namevi, id from #_variation where id_list = ? and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($configSector['id'], 'hinh-thuc-lam-viec'));
        }

        /* Get experience */
        if (in_array("experience", $configSector['attributes'])) {
            $experience = $d->rawQuery("select namevi, id from #_variation where id_list = ? and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($configSector['id'], 'kinh-nghiem'));
        }
    }
}

/* Edit man */
function editMan()
{
    global $d, $func, $id_list, $strUrl, $curPage, $item, $itemContent, $itemSale, $itemOwnerShop, $itemOwnerPoster, $itemOwnerContact, $itemPhoto, $itemInfo, $itemVideo, $itemVariation, $configSector, $typePrice, $formWork, $experience;

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        /* ID data */
        $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

        /* Check sector data */
        if (!empty($id)) {
            /* Get data */
            $tableShop = (!empty($configSector['tables']['shop'])) ? $configSector['tables']['shop'] : '';

            /* Where logic when owner or shop unactive */
            $whereLogicOwner = $func->getLogicOwner($tableShop, $configSector, false);
            $where = $whereLogicOwner['where'];

            /* Get data detail from Group */
            if ($func->getGroup('active')) {
                $where .= " and A.id_list=$id_list";

                $idCatByGroup = $func->getGroup('cat');

                if (!empty($idCatByGroup)) {
                    $id_cat = (!empty($idCatByGroup)) ? implode(',', $idCatByGroup) : '';
                    $where .= " and A.id_cat in ($id_cat)";
                }

                $id_regions = $func->getGroup('regions');
                $where .= " and A.id_region in ($id_regions)";

                $id_citys = $func->getGroup('citys');
                $where .= " and A.id_city in ($id_citys)";
            }

            /* Get data detail */
            $item = $d->rawQueryOne("select A.*, A.id as id from #_" . $configSector['tables']['main'] . " as A where A.id = ? $where limit 0,1", array($id));

            /* Check data detail */
            if (!empty($item)) {
                /* Get type price */
                if (in_array("price", $configSector['attributes']) || in_array("salary", $configSector['attributes'])) {
                    $typePrice = $d->rawQuery("select namevi, id from #_variation where id_list = ? and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($configSector['id'], 'loai-gia'));
                }

                /* Get form work */
                if (in_array("form-work", $configSector['attributes'])) {
                    $formWork = $d->rawQuery("select namevi, id from #_variation where id_list = ? and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($configSector['id'], 'hinh-thuc-lam-viec'));
                }

                /* Get experience */
                if (in_array("experience", $configSector['attributes'])) {
                    $experience = $d->rawQuery("select namevi, id from #_variation where id_list = ? and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($configSector['id'], 'kinh-nghiem'));
                }

                /* Get info */
                if (!empty($configSector['tables']['info'])) {
                    $itemInfo = $d->rawQueryOne("select * from #_" . $configSector['tables']['info'] . " where id_parent = ?", array($id));
                }

                /* Get content */
                $itemContent = $d->rawQueryOne("select * from #_" . $configSector['tables']['content'] . " where id_parent = ?", array($id));

                /* Get sale */
                if (!empty($configSector['tables']['sale'])) {
                    $itemSale = $d->rawQuery("select * from #_" . $configSector['tables']['sale'] . " where id_parent = ?", array($id));
                    $itemSale['colors'] = (!empty($itemSale)) ? $func->joinCols($itemSale, 'id_color') : '';
                    $itemSale['sizes'] = (!empty($itemSale)) ? $func->joinCols($itemSale, 'id_size') : '';
                }

                /* Get owner Admin or Member or Shop */
                if (!empty($item['id_shop'])) {
                    $itemOwnerShop = $d->rawQueryOne("select A.id as id, A.id_member as id_member, A.id_admin as id_admin, A.name as name, A.slug_url as slug_url, A.email as email, A.phone as phone, B.name as nameCity, C.name as nameDistrict, D.name as nameWard from #_" . $configSector['tables']['shop'] . " as A, #_city as B, #_district as C, #_wards as D where A.id = ? and A.id_city = B.id and A.id_district = C.id and A.id_wards = D.id limit 0, 1", array($item['id_shop']));

                    if (!empty($itemOwnerShop['id_member'])) {
                        /* Get owner Member */
                        $itemOwnerPoster = $d->rawQueryOne("select fullname, phone, email, address from #_member where id = ?", array($itemOwnerShop['id_member']));
                    } else {
                        /* Get owner Admin */
                        $itemOwnerPoster = $d->rawQueryOne("select fullname, phone, email, address from #_user where id = ?", array($itemOwnerShop['id_admin']));
                    }
                } else {
                    if (!empty($item['id_member'])) {
                        /* Get owner Member */
                        $itemOwnerPoster = $d->rawQueryOne("select fullname, phone, email, address from #_member where id = ?", array($item['id_member']));

                        /* Get owner Contact */
                        $itemOwnerContact = $d->rawQueryOne("select * from #_" . $configSector['tables']['contact'] . " where id_parent = ?", array($id));
                    } else {
                        /* Get owner Admin */
                        $itemOwnerPoster = $d->rawQueryOne("select fullname, phone, email, address from #_user where id = ?", array($item['id_admin']));
                    }
                }

                /* Get photos */
                if (!empty($configSector['tables']['photo'])) {
                    $itemPhoto = $d->rawQuery("select * from #_" . $configSector['tables']['photo'] . " where id_parent = ? order by numb,id desc", array($id));
                }

                /* Get videos */
                $itemVideo = $d->rawQueryOne("select * from #_" . $configSector['tables']['video'] . " where id_parent = ? limit 0,1", array($id));

                /* Get variation */
                if (!empty($configSector['tables']['variation'])) {
                    $itemVariations = $d->rawQuery("select * from #_" . $configSector['tables']['variation'] . " where id_parent = ?", array($id));
                    if (!empty($itemVariations)) {
                        foreach ($itemVariations as $v) {
                            $itemVariation[$v['type']] = $v;
                        }
                    } else {
                        $itemVariation = array();
                    }
                }
            } else {
                $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
            }
        } else {
            $func->transfer("Lĩnh vực kinh doanh và dữ liệu không hợp lệ", "index.php", false);
        }
    }
}

/* Save man */
function saveMan()
{
    global $d, $act, $strUrl, $id_list, $func, $flash, $curPage, $config, $loginAdmin, $configSector;

    /* Check empty post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
    }

    /* Check empty sector */
    if (empty($id_list)) {
        $func->transfer("Không tìm thấy lĩnh vực kinh doanh", "index.php", false);
    } else {
        /* Post data */
        $message = '';
        $response = array();
        $tableShop = (!empty($configSector['tables']['shop'])) ? $configSector['tables']['shop'] : '';
        $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;

        /* Check logic before save */
        if ($id) {
            $whereLogicOwner = $func->getLogicOwner($tableShop, $configSector, false);
            $whereDetail = $whereLogicOwner['where'];
            $sqlDetail = "select A.id as id from #_" . $configSector['tables']['main'] . " as A where A.id = ? $whereDetail limit 0,1";
            $paramsDetail = array($id);
            $rowDetail = $d->rawQueryOne($sqlDetail, $paramsDetail);

            if (empty($rowDetail)) {
                $func->transfer("Trang không tồn tại", "index.php?com=product&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
            }
        }

        /* Post data */
        $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
        $dataInfo = (!empty($_POST['dataInfo'])) ? $_POST['dataInfo'] : null;
        $dataTags = (!empty($_POST['dataTags'])) ? $_POST['dataTags'] : null;
        $dataColor = (!empty($_POST['dataColor'])) ? $_POST['dataColor'] : null;
        $dataSize = (!empty($_POST['dataSize'])) ? $_POST['dataSize'] : null;
        $dataVideo = (!empty($_POST['dataVideo'])) ? $_POST['dataVideo'] : null;
        $existVideo = (!empty($_POST['existVideo'])) ? $_POST['existVideo'] : false;
        $existVideoPhoto = (!empty($_POST['existVideoPhoto'])) ? $_POST['existVideoPhoto'] : false;
        $dataVariations = (!empty($_POST['dataVariations'])) ? $_POST['dataVariations'] : null;
        $dataContent = (!empty($_POST['dataContent'])) ? $_POST['dataContent'] : null;
        $dataSeo = (!empty($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
        $existPhoto = (!empty($_POST['existPhoto'])) ? $_POST['existPhoto'] : false;
        $listsGallery = $func->listsGallery('files-uploader-product');

        /* Check data main */
        if ($data) {
            $data['id_list'] = $id_list;

            foreach ($data as $column => $value) {
                $data[$column] = htmlspecialchars($func->sanitize($value));
            }

            /* Regular price */
            if (!empty($data['regular_price']) && strstr($data['regular_price'], ',')) {
                $data['regular_price'] = str_replace(",", ".", $data['regular_price']);
            }

            /* Acreage */
            if (in_array("acreage", $configSector['attributes'])) {
                if (!empty($data['acreage']) && strstr($data['acreage'], ',')) {
                    $data['acreage'] = str_replace(",", ".", $data['acreage']);
                }
            }

            /* Real price */
            if (!empty($dataVariations['type-price'])) {
                $denomination = $d->rawQueryOne("select denominations from #_variation where id = ? and type = ? and find_in_set('hienthi',status) limit 1", array($dataVariations['type-price']['id'], $dataVariations['type-price']['type']));
                $data['real_price'] = (!empty($denomination['denominations'])) ? $denomination['denominations'] * $data['regular_price'] : 0;
            }

            /* Others */
            $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
            $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';

            /* Status attr */
            if (isset($_POST['status_attr'])) {
                $status = '';
                foreach ($_POST['status_attr'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
                $data['status_attr'] = (!empty($status)) ? rtrim($status, ",") : "";
            }
        }

        /* Check data info */
        if ($dataInfo) {
            foreach ($dataInfo as $column => $value) {
                $dataInfo[$column] = htmlspecialchars($func->sanitize($value));
            }

            if (!empty($dataInfo['birthday'])) {
                $birthdayInfo = $dataInfo['birthday'];
                $dataInfo['birthday'] = strtotime(str_replace("/", "-", htmlspecialchars($dataInfo['birthday'])));
            }

            if (!empty($dataInfo['application_deadline'])) {
                $applicationDeadlineInfo = $dataInfo['application_deadline'];
                $dataInfo['application_deadline'] = strtotime(str_replace("/", "-", htmlspecialchars($dataInfo['application_deadline'])));
            }
        }

        /* Check data video */
        if ($dataVideo) {
            foreach ($dataVideo as $column => $value) {
                $dataVideo[$column] = htmlspecialchars($func->sanitize($value));
            }

            $dataVideo['slugvi'] = (!empty($dataVideo['namevi'])) ? $func->changeTitle($dataVideo['namevi']) : '';
        }

        /* Check data content */
        if ($dataContent) {

            foreach ($dataContent as $column => $value) {
                if ($column=="propertiesvi"|| $column=="propertiesen") {
                    if ($value) { foreach ($value as $k => $v) {
                        $arr[$k] = htmlspecialchars($func->sanitize($v, 'iframe'));
                    } }
                    $dataContent[$column] = json_encode($arr);
                }else{
                    $dataContent[$column] = htmlspecialchars($func->sanitize($value, 'iframe'));
                }
            }
        }

        /* Check data seo */
        if ($dataSeo) {
            foreach ($dataSeo as $column => $value) {
                $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
            }
        }

        /* Valid data */
        if (empty($data['namevi'])) {
            $response['messages'][] = 'Tiêu đề không được trống';
        }

        if (empty($dataContent['contentvi'])) {
            $response['messages'][] = 'Nội dung không được trống';
        }

        if (empty($dataVideo['namevi']) ) {
            $response['messages'][] = 'Tiêu đề video không được trống';
        }

        if (!$func->hasFile('file-poster') && !$existVideoPhoto) {
            $response['messages'][] = 'Poster video không được trống';
        }

        if ($dataVideo['type'] == 'file' && !$func->hasFile('video-file') && !$existVideo) {
            $response['messages'][] = 'Tập tin video không được trống';
        }

        if ($dataVideo['type'] == 'file' && !$func->checkExtFile('video-file')) {
            $response['messages'][] = 'Chi cho phép tập tin video với định dạng: ' . implode(",", $config['website']['video']['extension']);
        }

        if ($dataVideo['type'] == 'file' && !$func->checkFile('video-file')) {
            $sizeVideo = $func->formatBytes($config['website']['video']['max-size']);
            $response['messages'][] = 'Tập tin video không được vượt quá ' . $sizeVideo['numb'] . ' ' . $sizeVideo['ext'];
        }

        if (in_array("price", $configSector['attributes'])) {
            $title_money = 'Giá';
        }

        if (in_array("salary", $configSector['attributes'])) {
            $title_money = 'Mức lương';
        }

        if (!empty($title_money)) {
            if (empty($data['regular_price'])) {
                $response['messages'][] = $title_money . ' không được trống';
            }

            if (!empty($data['regular_price']) && (!$func->isDecimal($data['regular_price']) || $func->isZero($data['regular_price']))) {
                $response['messages'][] = $title_money . ' không hợp lệ';
            }

            if (empty($dataVariations['type-price']['id'])) {
                $response['messages'][] = 'Chưa chọn đơn vị ' . $func->textConvert($title_money, 'lower');
            }
        }

        if (in_array("acreage", $configSector['attributes'])) {
            if (empty($data['acreage'])) {
                $response['messages'][] = 'Diện tích không được trống';
            }

            if (!empty($data['acreage']) && (!$func->isDecimal($data['acreage']) || $func->isZero($data['acreage']))) {
                $response['messages'][] = 'Diện tích không hợp lệ';
            }
        }

        if (in_array("coordinates", $configSector['attributes'])) {
            if (empty($data['coordinates'])) {
                $response['messages'][] = 'Tọa độ không được trống';
            }

            if (!empty($data['coordinates']) && !$func->isCoords($data['coordinates'])) {
                $response['messages'][] = 'Tọa độ không hợp lệ';
            }
        }

        if (in_array("info-candidate", $configSector['attributes'])) {
            if (empty($dataInfo['first_name'])) {
                $response['messages'][] = 'Họ và chữ lót không được trống';
            }

            if (empty($dataInfo['last_name'])) {
                $response['messages'][] = 'Tên không được trống';
            }

            if (empty($birthdayInfo)) {
                $response['messages'][] = 'Ngày sinh không được trống';
            }

            if (!empty($birthdayInfo) && !$func->isDate($birthdayInfo)) {
                $response['messages'][] = 'Ngày sinh không hợp lệ';
            }
        }

        if (in_array("info-employer", $configSector['attributes'])) {
            if (empty($dataInfo['fullname'])) {
                $response['messages'][] = 'Tên nhà tuyển dụng không được trống';
            }

            if (empty($dataInfo['age_requirement'])) {
                $response['messages'][] = 'Yêu cầu độ tuổi không được trống';
            }

            if (empty($dataInfo['application_deadline'])) {
                $response['messages'][] = 'Hạn nộp hồ sơ không được trống';
            }

            if (!empty($applicationDeadlineInfo) && !$func->isDate($applicationDeadlineInfo)) {
                $response['messages'][] = 'Hạn nộp hồ sơ không hợp lệ';
            }

            if (empty($dataInfo['trial_period'])) {
                $response['messages'][] = 'Thời gian thử việc không được trống';
            }

            if (empty($dataInfo['employee_quantity'])) {
                $response['messages'][] = 'Số lượng tuyển dụng không được trống';
            }

            if (!empty($dataInfo['employee_quantity']) && (!$func->isNumber($dataInfo['employee_quantity']) || $func->isZero($dataInfo['employee_quantity']))) {
                $response['messages'][] = 'Số lượng tuyển dụng không hợp lệ';
            }
        }

        if (in_array("info-candidate", $configSector['attributes']) || in_array("info-employer", $configSector['attributes'])) {
            if (empty($dataInfo['gender'])) {
                $response['messages'][] = 'Chưa chọn giới tính';
            }

            if (empty($dataInfo['phone'])) {
                $response['messages'][] = 'Số điện thoại không được trống';
            }

            if (!empty($dataInfo['phone']) && !$func->isPhone($dataInfo['phone'])) {
                $response['messages'][] = 'Số điện thoại không hợp lệ';
            }

            if (empty($dataInfo['email'])) {
                $response['messages'][] = 'Email không được trống';
            }

            if (!empty($dataInfo['email']) && !$func->isEmail($dataInfo['email'])) {
                $response['messages'][] = 'Email không hợp lệ';
            }

            if (empty($dataInfo['address'])) {
                $response['messages'][] = 'Địa chỉ không được trống';
            }
        }

        if (in_array("info-employer", $configSector['attributes'])) {
            if (empty($dataInfo['introduce'])) {
                $response['messages'][] = 'Giới thiệu không được trống';
            }
        }

        if (empty($data['id_cat'])) {
            $response['messages'][] = 'Chưa chọn danh mục cấp 2';
        }

        if (empty($data['id_item'])) {
            $response['messages'][] = 'Chưa chọn danh mục cấp 3';
        }

        if (in_array("form-work", $configSector['attributes'])) {
            if (empty($dataVariations['form-work']['id'])) {
                $response['messages'][] = 'Chưa chọn hình thức làm việc';
            }
        }

        if (in_array("experience", $configSector['attributes'])) {
            if (empty($dataVariations['experience']['id'])) {
                $response['messages'][] = 'Chưa chọn kinh nghiệm';
            }
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

        if (!$func->hasFile('file') && !$existPhoto) {
            $response['messages'][] = 'Hình đại diện không được trống';
        }

        if (in_array($configSector['type'], array($config['website']['sectors']))) {
            if (empty($id)) {
                if (empty($listsGallery)) {
                    $response['messages'][] = 'Album hình ảnh không được trống';
                }

                if (!empty($listsGallery) && count($listsGallery) > 6) {
                    $response['messages'][] = 'Album hình ảnh không được vượt quá 6 hình';
                }
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

            if (!empty($dataInfo)) {
                foreach ($dataInfo as $k => $v) {
                    if (!empty($v)) {
                        $flash->set($k, $v);
                    }
                }
            }

            if (!empty($dataVideo)) {
                foreach ($dataVideo as $k => $v) {
                    if (!empty($v)) {
                        $flash->set('video_' . $k, $v);
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

            $flash->set('type-price-id', (!empty($dataVariations['type-price']['id'])) ? $dataVariations['type-price']['id'] : 0);
            $flash->set('form-work-id', (!empty($dataVariations['form-work']['id'])) ? $dataVariations['form-work']['id'] : 0);
            $flash->set('experience-id', (!empty($dataVariations['experience']['id'])) ? $dataVariations['experience']['id'] : 0);

            /* Errors */
            $response['status'] = 'danger';
            $message = base64_encode(json_encode($response));
            $flash->set('message', $message);

            if (empty($id)) {
                $func->redirect("index.php?com=product&act=add&id_list=" . $id_list . $strUrl);
            } else {
                $func->redirect("index.php?com=product&act=edit&id_list=" . $id_list . $strUrl . "&id=" . $id);
            }
        }

        /* Save or insert data by sectors */
        if ($id) {
            $data['date_updated'] = time();

            $d->where('id', $id);
            if ($d->update($configSector['tables']['main'], $data)) {
                /* Photo */
                if ($func->hasFile("file")) {
                    $photoUpdate = array();
                    $file_name = $func->uploadName($_FILES["file"]["name"]);

                    if ($photo = $func->uploadImage("file", $config['product']['img_type'], UPLOAD_PRODUCT, $file_name)) {
                        $row = $d->rawQueryOne("select id, photo from #_" . $configSector['tables']['main'] . " where id = ? limit 0,1", array($id));

                        if (!empty($row)) {
                            $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                        }

                        $photoUpdate['photo'] = $photo;
                        $d->where('id', $id);
                        $d->update($configSector['tables']['main'], $photoUpdate);
                        unset($photoUpdate);
                    }
                }

                /* Info */
                if ($dataInfo) {
                    $d->rawQuery("delete from #_" . $configSector['tables']['info'] . " where id_parent = ?", array($id));
                    $dataInfo['id_parent'] = $id;
                    $d->insert($configSector['tables']['info'], $dataInfo);
                }

                /* Content */
                $d->rawQuery("delete from #_" . $configSector['tables']['content'] . " where id_parent = ?", array($id));
                $dataContent['id_parent'] = $id;
                $d->insert($configSector['tables']['content'], $dataContent);

                /* Video */
                if ($dataVideo['type'] == 'file') {
                    /* Upload info */
                    if (!empty($dataVideo['namevi'])) {
                        $d->where('id_parent', $id);
                        $d->update($configSector['tables']['video'], $dataVideo);
                    }

                    /* Upload poster */
                    if ($func->hasFile("file-poster")) {
                        $posterUpdate = array();
                        $file_name = $func->uploadName($_FILES["file-poster"]["name"]);

                        if ($photo = $func->uploadImage("file-poster", $config['website']['video']['poster']['extension'], UPLOAD_PHOTO, $file_name)) {
                            $row = $d->rawQueryOne("select id, photo from #_" . $configSector['tables']['video'] . " where id_parent = ? limit 0,1", array($id));

                            if (!empty($row)) {
                                $func->deleteFile(UPLOAD_PHOTO . $row['photo']);

                                $posterUpdate['photo'] = $photo;
                                $posterUpdate['type'] = $dataVideo['type'];
                                $d->where('id_parent', $id);
                                $d->update($configSector['tables']['video'], $posterUpdate);
                            } else {
                                $posterUpdate['photo'] = $photo;
                                $posterUpdate['type'] = $dataVideo['type'];
                                $posterUpdate['id_parent'] = $id;
                                $d->insert($configSector['tables']['video'], $posterUpdate);
                            }

                            unset($posterUpdate);
                        }
                    }

                    /* Upload video */
                    if ($func->hasFile("video-file")) {
                        $videoUpdate = array();
                        $file_name = $func->uploadName($_FILES["video-file"]["name"]);

                        if ($video = $func->uploadImage("video-file", implode("|", $config['website']['video']['extension']), UPLOAD_VIDEO, $file_name)) {
                            $row = $d->rawQueryOne("select id, video from #_" . $configSector['tables']['video'] . " where id_parent = ? limit 0,1", array($id));

                            if (!empty($row)) {
                                $func->deleteFile(UPLOAD_VIDEO . $row['video']);
                            }

                            $videoUpdate['video'] = $video;
                            $videoUpdate['type'] = $dataVideo['type'];
                            $d->where('id_parent', $id);
                            $d->update($configSector['tables']['video'], $videoUpdate);
                            unset($videoUpdate);
                        }
                    }
                }

                /* Variation */
                if ($dataVariations) {
                    $d->rawQuery("delete from #_" . $configSector['tables']['variation'] . " where id_parent = ?", array($id));
                    foreach ($dataVariations as $v) {
                        $dataVariation = array();
                        $dataVariation['id_parent'] = $id;
                        $dataVariation['id_variation'] = $v['id'];
                        $dataVariation['type'] = $v['type'];
                        $d->insert($configSector['tables']['variation'], $dataVariation);
                    }
                }

                /* Tag */
                if ($dataTags) {
                    $d->rawQuery("delete from #_" . $configSector['tables']['tag'] . " where id_parent = ?", array($id));
                    foreach ($dataTags as $v) {
                        $dataTag = array();
                        $dataTag['id_parent'] = $id;
                        $dataTag['id_tag'] = $v;
                        $d->insert($configSector['tables']['tag'], $dataTag);
                    }
                } else {
                    $d->rawQuery("delete from #_" . $configSector['tables']['tag'] . " where id_parent = ?", array($id));
                }

                /* Sale */
                if (($func->hasCart($configSector) && !isset($data['status_attr'])) || ($func->hasCart($configSector) && isset($data['status_attr']) && !strstr($data['status_attr'], 'dichvu'))) {
                    if (!empty($dataColor) && !empty($dataSize)) {
                        $dataSale1 = array();
                        $dataSale1['id'] = 'id_color';
                        $dataSale1['data'] = $dataColor;

                        $dataSale2 = array();
                        $dataSale2['id'] = 'id_size';
                        $dataSale2['data'] = $dataSize;
                    } else if (!empty($dataColor)) {
                        $dataSale1 = array();
                        $dataSale1['id'] = 'id_color';
                        $dataSale1['data'] = $dataColor;
                    } else if (!empty($dataSize)) {
                        $dataSale1 = array();
                        $dataSale1['id'] = 'id_size';
                        $dataSale1['data'] = $dataSize;
                    }

                    if (!empty($dataSale1['data']) || !empty($dataSale2['data'])) {
                        $d->rawQuery("delete from #_" . $configSector['tables']['sale'] . " where id_parent = ?", array($id));

                        foreach ($dataSale1['data'] as $v_sale1) {
                            $dataSale = array();
                            $dataSale['id_parent'] = $id;
                            $dataSale[$dataSale1['id']] = $v_sale1;

                            if (!empty($dataSale2['data'])) {
                                foreach ($dataSale2['data'] as $v_sale2) {
                                    $dataSale[$dataSale2['id']] = $v_sale2;
                                    $d->insert($configSector['tables']['sale'], $dataSale);
                                }
                            } else {
                                $d->insert($configSector['tables']['sale'], $dataSale);
                            }
                        }
                    } else {
                        $d->rawQuery("delete from #_" . $configSector['tables']['sale'] . " where id_parent = ?", array($id));
                    }
                } else if (!empty($configSector['tables']['sale'])) {
                    $d->rawQuery("delete from #_" . $configSector['tables']['sale'] . " where id_parent = ?", array($id));
                }

                /* SEO */
                $d->rawQuery("delete from #_" . $configSector['tables']['seo'] . " where id_parent = ?", array($id));
                $dataSeo['id_parent'] = $id;
                $d->insert($configSector['tables']['seo'], $dataSeo);

                /* Gallery */
                if (in_array($configSector['type'], array($config['website']['sectors']))) {
                    $func->uploadGallery('files-uploader-product', $configSector['tables']['photo'], $config['product']['img_type'], UPLOAD_PRODUCT, $id);
                }

                $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl);
            } else {
                $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
            }
        } else {
            $data['id_admin'] = $_SESSION[$loginAdmin]['owner']['id'];
            $data['status'] = 'xetduyet';
            $data['status_user'] = 'hienthi';
            $data['date_created'] = time();

            if ($d->insert($configSector['tables']['main'], $data)) {
                $id_insert = $d->getLastInsertId();

                /* Photo */
                if ($func->hasFile("file")) {
                    $photoUpdate = array();
                    $file_name = $func->uploadName($_FILES['file']["name"]);

                    if ($photo = $func->uploadImage("file", $config['product']['img_type'], UPLOAD_PRODUCT, $file_name)) {
                        $photoUpdate['photo'] = $photo;
                        $d->where('id', $id_insert);
                        $d->update($configSector['tables']['main'], $photoUpdate);
                        unset($photoUpdate);
                    }
                }

                /* Info */
                if ($dataInfo) {
                    $dataInfo['id_parent'] = $id_insert;
                    $d->insert($configSector['tables']['info'], $dataInfo);
                }

                /* Content */
                $dataContent['id_parent'] = $id_insert;
                $d->insert($configSector['tables']['content'], $dataContent);

                /* Video */
                if ($dataVideo['type'] == 'file') {
                    /* Upload poster */
                    $file_name = $func->uploadName($_FILES["file-poster"]["name"]);

                    if ($photo = $func->uploadImage("file-poster", $config['website']['video']['poster']['extension'], UPLOAD_PHOTO, $file_name)) {
                        $dataVideo['photo'] = $photo;
                    }

                    /* Upload video */
                    $file_name = $func->uploadName($_FILES["video-file"]["name"]);

                    if ($video = $func->uploadImage("video-file", implode("|", $config['website']['video']['extension']), UPLOAD_VIDEO, $file_name)) {
                        $dataVideo['video'] = $video;
                    }

                    /* Save video */
                    $dataVideo['id_parent'] = $id_insert;
                    $d->insert($configSector['tables']['video'], $dataVideo);
                }

                /* Variation */
                if ($dataVariations) {
                    foreach ($dataVariations as $v) {
                        $dataVariation = array();
                        $dataVariation['id_parent'] = $id_insert;
                        $dataVariation['id_variation'] = $v['id'];
                        $dataVariation['type'] = $v['type'];
                        $d->insert($configSector['tables']['variation'], $dataVariation);
                    }
                }

                /* Tag */
                if ($dataTags) {
                    foreach ($dataTags as $v) {
                        $dataTag = array();
                        $dataTag['id_parent'] = $id_insert;
                        $dataTag['id_tag'] = $v;
                        $d->insert($configSector['tables']['tag'], $dataTag);
                    }
                }

                /* Sale */
                if (($func->hasCart($configSector) && !isset($data['status_attr'])) || ($func->hasCart($configSector) && isset($data['status_attr']) && !strstr($data['status_attr'], 'dichvu'))) {
                    if (!empty($dataColor) && !empty($dataSize)) {
                        $dataSale1 = array();
                        $dataSale1['id'] = 'id_color';
                        $dataSale1['data'] = $dataColor;

                        $dataSale2 = array();
                        $dataSale2['id'] = 'id_size';
                        $dataSale2['data'] = $dataSize;
                    } else if (!empty($dataColor)) {
                        $dataSale1 = array();
                        $dataSale1['id'] = 'id_color';
                        $dataSale1['data'] = $dataColor;
                    } else if (!empty($dataSize)) {
                        $dataSale1 = array();
                        $dataSale1['id'] = 'id_size';
                        $dataSale1['data'] = $dataSize;
                    }

                    if (!empty($dataSale1['data']) || !empty($dataSale2['data'])) {
                        foreach ($dataSale1['data'] as $v_sale1) {
                            $dataSale = array();
                            $dataSale['id_parent'] = $id_insert;
                            $dataSale[$dataSale1['id']] = $v_sale1;

                            if (!empty($dataSale2['data'])) {
                                foreach ($dataSale2['data'] as $v_sale2) {
                                    $dataSale[$dataSale2['id']] = $v_sale2;
                                    $d->insert($configSector['tables']['sale'], $dataSale);
                                }
                            } else {
                                $d->insert($configSector['tables']['sale'], $dataSale);
                            }
                        }
                    }
                }

                /* SEO */
                $dataSeo['id_parent'] = $id_insert;
                $d->insert($configSector['tables']['seo'], $dataSeo);

                /* Gallery */
                if (in_array($configSector['type'], array($config['website']['sectors']))) {
                    $func->uploadGallery('files-uploader-product', $configSector['tables']['photo'], $config['product']['img_type'], UPLOAD_PRODUCT, $id_insert);
                }

                $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl);
            } else {
                $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
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
    } else {
        /* ID data */
        $tableShop = (!empty($configSector['tables']['shop'])) ? $configSector['tables']['shop'] : '';
        $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
        $reason = (!empty($_POST['reason-to-delete'])) ? htmlspecialchars($_POST['reason-to-delete']) : '';

        if ($id && $reason) {
            /* Check logic before save */
            $whereLogicOwner = $func->getLogicOwner($tableShop, $configSector, false);
            $whereDetail = $whereLogicOwner['where'];
            $sqlDetail = "select A.id as id from #_" . $configSector['tables']['main'] . " as A where A.id = ? $whereDetail limit 0,1";
            $paramsDetail = array($id);
            $rowDetail = $d->rawQueryOne($sqlDetail, $paramsDetail);

            if (empty($rowDetail)) {
                $func->transfer("Trang không tồn tại", "index.php?com=product&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
            }

            /* Get data detail */
            $row = $d->rawQueryOne("select id, id_member, id_admin, namevi, photo, status from #_" . $configSector['tables']['main'] . " where id = ? limit 0,1", array($id));

            /* Check data detail */
            if (!empty($row['id']) && (in_array($row['status'], array('', 'deleted', 'dangsai', 'vipham')) || !empty($row['id_admin']))) {
                /* Reason to delete */
                $row['reason'] = $reason;

                /* Delete action */
                $func->deleteProduct($row, $configSector, UPLOAD_PRODUCT);

                /* Notice for user */
                noticeForUser($row);

                /* Run Maintain database */
                $d->runMaintain();

                $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl);
            } else {
                $func->transfer("Chỉ được xóa khi tin đăng ở trạng thái: Đang chờ duyệt, Sở hữu bởi ADMIN, Đăng sai, Vi phạm", "index.php?com=product&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
            }
        } else {
            $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man&id_list=" . $id_list . "&p=" . $curPage . $strUrl, false);
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
                '{emailProductName}',
                '{emailReason}'
            );
            $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

            /* Values email */
            $emailVals = array(
                $detail['namevi'],
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
            $message = str_replace($emailVars, $emailVals, $emailer->markdown('product/notice-for-user'));
            $file = null;

            /* Send */
            $emailer->send("customer", $arrayEmail, $subject, $message, $file);
        }
    }
}

/* View list */
function viewLists()
{
    global $d, $func, $strUrl, $curPage, $items, $paging;

    $where = "";

    if (!empty($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_product_list where id > 0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_product_list where id > 0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_list";
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit list */
function editList()
{
    global $d, $func, $strUrl, $curPage, $item;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_list&p=" . $curPage . $strUrl, false);
    }

    $item = $d->rawQueryOne("select * from #_product_list where id = ? limit 0,1", array($id));

    if (empty($item['id'])) {
        $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man_list&p=" . $curPage . $strUrl, false);
    }
}

/* Save list */
function saveList()
{
    global $d, $strUrl, $func, $curPage, $config, $com;

    /* Check empty post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_list&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        if (!empty($config['website']['debug-developer'])) {
            if (!empty($_POST['status'])) {
                $status = '';
                foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
                $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
            } else {
                $data['status'] = "";
            }
        }

        $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
        $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
    }

    /* Developer */
    if (empty($config['website']['debug-developer']) && empty($id)) $func->transfer("Trang không tồn tại", "index.php?com=product&act=man_list&p=" . $curPage . $strUrl, false);

    /* Post seo */
    $dataSeo = (!empty($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
    if ($dataSeo) {
        foreach ($dataSeo as $column => $value) {
            $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
        }
    }

    /* Update or add data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('product_list', $data)) {
            /* Photo 1 */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['product']['img_type_list'], UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_product_list where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('product_list', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 2 */
            /*
				if($func->hasFile("file-2"))
				{
					$photoUpdate = array();
					$file_name = $func->uploadName($_FILES["file-2"]["name"]);

					if($photo2 = $func->uploadImage("file-2", $config['product']['img_type_list'], UPLOAD_PRODUCT, $file_name))
					{
						$row = $d->rawQueryOne("select id, photo2 from #_product_list where id = ? limit 0,1",array($id));

						if(!empty($row))
						{
							$func->deleteFile(UPLOAD_PRODUCT.$row['photo2']);
						}

						$photoUpdate['photo2'] = $photo2;
						$d->where('id', $id);
						$d->update('product_list', $photoUpdate);
						unset($photoUpdate);
					}
				}
				*/

            /* Photo 3 */
            if ($func->hasFile("file-3")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file-3"]["name"]);

                if ($photo3 = $func->uploadImage("file-3", $config['product']['img_type_list'], UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo3 from #_product_list where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PRODUCT . $row['photo3']);
                    }

                    $photoUpdate['photo3'] = $photo3;
                    $d->where('id', $id);
                    $d->update('product_list', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            $d->rawQuery("delete from #_product_list_seo where id_parent = ?", array($id));
            $dataSeo['id_parent'] = $id;
            $d->insert('product_list_seo', $dataSeo);

            /* Write json */
            $dataJson = array('type' => 'list');
            $func->writeJson($dataJson);

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_list&p=" . $curPage . $strUrl);
        } else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_list&p=" . $curPage . $strUrl, false);
    } else {
        $data['date_created'] = time();

        if ($d->insert('product_list', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo 1 */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['product']['img_type_list'], UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('product_list', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 2 */
            /*
				if($func->hasFile("file-2"))
				{
					$photoUpdate = array();
					$file_name = $func->uploadName($_FILES['file-2']["name"]);

					if($photo2 = $func->uploadImage("file-2", $config['product']['img_type_list'], UPLOAD_PRODUCT, $file_name))
					{
						$photoUpdate['photo2'] = $photo2;
						$d->where('id', $id_insert);
						$d->update('product_list', $photoUpdate);
						unset($photoUpdate);
					}
				}
				*/

            /* Photo 3 */
            if ($func->hasFile("file-3")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file-3']["name"]);

                if ($photo3 = $func->uploadImage("file-3", $config['product']['img_type_list'], UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo3'] = $photo3;
                    $d->where('id', $id_insert);
                    $d->update('product_list', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            $dataSeo['id_parent'] = $id_insert;
            $d->insert('product_list_seo', $dataSeo);

            /* Write json */
            $dataJson = array('type' => 'list');
            $func->writeJson($dataJson);

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_list&p=" . $curPage . $strUrl);
        } else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_list&p=" . $curPage . $strUrl, false);
    }
}

/* View cat */
function viewCats()
{
    global $d, $func, $strUrl, $curPage, $items, $paging;

    $where = "";

    if ($func->getGroup('active')) {
        /* Lọc cấp 1 theo Group */
        $idlist = $func->getGroup('list');
    } else {
        $idlist = (!empty($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    }

    if ($idlist) $where .= " and id_list=$idlist";
    if (!empty($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_product_cat where id > 0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_product_cat where id > 0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_cat" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit cat */
function editCat()
{
    global $d, $func, $id_list, $strUrl, $curPage, $item;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_cat&p=" . $curPage . $strUrl, false);
    }

    $item = $d->rawQueryOne("select * from #_product_cat where id = ? limit 0,1", array($id));

    if (empty($item['id'])) {
        $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man_cat&p=" . $curPage . $strUrl, false);
    }
}

/* Save cat */
function saveCat()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com;

    /* Check empty post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_cat&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        if (!empty($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
        $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
    }

    /* Post seo */
    $dataSeo = (!empty($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
    if ($dataSeo) {
        foreach ($dataSeo as $column => $value) {
            $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
        }
    }

    /* Valid data */
    if (empty($data['namevi'])) {
        $response['messages'][] = 'Tiêu đề không được trống';
    }

    if (empty($data['name_storevi'])) {
        $response['messages'][] = 'Tiêu đề công ty không được trống';
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

        if (empty($id)) {
            $func->redirect("index.php?com=product&act=add_cat" . $strUrl);
        } else {
            $func->redirect("index.php?com=product&act=edit_cat" . $strUrl . "&id=" . $id);
        }
    }

    /* Update or add data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('product_cat', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['product']['img_type_cat'], UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_product_cat where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('product_cat', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 2 */
            if ($func->hasFile("file-2")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file-2"]["name"]);

                if ($photo2 = $func->uploadImage("file-2", $config['product']['img_type_cat'], UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo2 from #_product_cat where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PRODUCT . $row['photo2']);
                    }

                    $photoUpdate['photo2'] = $photo2;
                    $d->where('id', $id);
                    $d->update('product_cat', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            $d->rawQuery("delete from #_product_cat_seo where id_parent = ?", array($id));
            $dataSeo['id_parent'] = $id;
            $d->insert('product_cat_seo', $dataSeo);

            /* Write json */
            $dataJson = array('type' => 'cat');
            $func->writeJson($dataJson);

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_cat&p=" . $curPage . $strUrl);
        } else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_cat&p=" . $curPage . $strUrl, false);
    } else {
        $data['date_created'] = time();

        if ($d->insert('product_cat', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['product']['img_type_cat'], UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('product_cat', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 2 */
            if ($func->hasFile("file-2")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file-2']["name"]);

                if ($photo2 = $func->uploadImage("file-2", $config['product']['img_type_cat'], UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo2'] = $photo2;
                    $d->where('id', $id_insert);
                    $d->update('product_cat', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            $dataSeo['id_parent'] = $id_insert;
            $d->insert('product_cat_seo', $dataSeo);

            /* Write json */
            $dataJson = array('type' => 'cat');
            $func->writeJson($dataJson);

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_cat&p=" . $curPage . $strUrl);
        } else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_cat&p=" . $curPage . $strUrl, false);
    }
}

/* Delete cat */
function deleteCat()
{
    global $d, $strUrl, $func, $curPage, $com;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo, photo2 from #_product_cat where id = ? limit 0,1", array($id));

        if (!empty($row['id'])) {
            $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
            $func->deleteFile(UPLOAD_PRODUCT . $row['photo2']);
            $d->rawQuery("delete from #_product_cat where id = ?", array($id));

            /* Xóa SEO */
            $d->rawQuery("delete from #_product_cat_seo where id_parent = ?", array($id));

            /* Xóa member new posting */
            $d->rawQuery("delete from #_member_new_posting where id_cat = ?", array($id));

            /* Write json */
            $dataJson = array('type' => 'cat');
            $func->writeJson($dataJson);

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_cat&p=" . $curPage . $strUrl);
        } else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_cat&p=" . $curPage . $strUrl, false);
    } elseif (!empty($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo, photo2 from #_product_cat where id = ? limit 0,1", array($id));

            if (!empty($row['id'])) {
                $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                $func->deleteFile(UPLOAD_PRODUCT . $row['photo2']);
                $d->rawQuery("delete from #_product_cat where id = ?", array($id));

                /* Xóa SEO */
                $d->rawQuery("delete from #_product_cat_seo where id_parent = ?", array($id));

                /* Xóa member new posting */
                $d->rawQuery("delete from #_member_new_posting where id_cat = ?", array($id));

                /* Write json */
                $dataJson = array('type' => 'cat');
                $func->writeJson($dataJson);
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_cat&p=" . $curPage . $strUrl);
    } else $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_cat&p=" . $curPage . $strUrl, false);
}

/* View item */
function viewItems()
{
    global $d, $func, $strUrl, $curPage, $items, $paging;

    $where = "";

    if ($func->getGroup('active')) {
        /* Lọc cấp 1 theo Group */
        $idlist = $func->getGroup('list');

        /* Lọc cấp 2 theo Group */
        if (empty($_REQUEST['id_cat'])) {
            $idCatByGroup = $func->getGroup('cat');
        } else {
            $idcat = (!empty($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
        }
    } else {
        $idlist = (!empty($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
        $idcat = (!empty($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
    }

    if ($idlist) $where .= " and id_list=$idlist";
    if (!empty($idCatByGroup)) {
        $idcat = implode(',', $idCatByGroup);
        $where .= " and id_cat in ($idcat)";
    } else if (!empty($idcat)) {
        $where .= " and id_cat=$idcat";
    }
    if (!empty($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_product_item where id > 0 $where order by numb asc, id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_product_item where id > 0 $where order by numb asc, id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_item" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit item */
function editItem()
{
    global $d, $func, $id_list, $strUrl, $curPage, $item;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    $where = '';

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_item&p=" . $curPage . $strUrl, false);
    }

    /* Get data detail from Group */
    if ($func->getGroup('active')) {
        $where .= " and id_list=$id_list";
        $idCatByGroup = $func->getGroup('cat');

        if (!empty($idCatByGroup)) {
            $id_cat = (!empty($idCatByGroup)) ? implode(',', $idCatByGroup) : '';
            $where .= " and id_cat in ($id_cat)";
        }
    }

    $item = $d->rawQueryOne("select * from #_product_item where id = ? $where limit 0,1", array($id));

    if (empty($item['id'])) {
        $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man_item&p=" . $curPage . $strUrl, false);
    }
}

/* Save item */
function saveItem()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com;

    /* Check empty post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_item&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        if (!empty($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
        $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
    }

    /* Post seo */
    $dataSeo = (!empty($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
    if ($dataSeo) {
        foreach ($dataSeo as $column => $value) {
            $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
        }
    }

    /* Valid data */
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

        if (empty($id)) {
            $func->redirect("index.php?com=product&act=add_item" . $strUrl);
        } else {
            $func->redirect("index.php?com=product&act=edit_item" . $strUrl . "&id=" . $id);
        }
    }

    /* Update or add data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('product_item', $data)) {
            /* Photo 1 */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['product']['img_type_item'], UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_product_item where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('product_item', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 2 */
            /*
				if($func->hasFile("file-2"))
				{
					$photoUpdate = array();
					$file_name = $func->uploadName($_FILES["file-2"]["name"]);

					if($photo2 = $func->uploadImage("file-2", $config['product']['img_type_item'], UPLOAD_PRODUCT, $file_name))
					{
						$row = $d->rawQueryOne("select id, photo2 from #_product_item where id = ? limit 0,1",array($id));

						if(!empty($row))
						{
							$func->deleteFile(UPLOAD_PRODUCT.$row['photo2']);
						}

						$photoUpdate['photo2'] = $photo2;
						$d->where('id', $id);
						$d->update('product_item', $photoUpdate);
						unset($photoUpdate);
					}
				}
				*/

            /* SEO */
            $d->rawQuery("delete from #_product_item_seo where id_parent = ?", array($id));
            $dataSeo['id_parent'] = $id;
            $d->insert('product_item_seo', $dataSeo);

            /* Write json */
            $dataJson = array('type' => 'item');
            $func->writeJson($dataJson);

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_item&p=" . $curPage . $strUrl);
        } else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_item&p=" . $curPage . $strUrl, false);
    } else {
        $data['date_created'] = time();

        if ($d->insert('product_item', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo 1 */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['product']['img_type_item'], UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('product_item', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* Photo 2 */
            /*
				if($func->hasFile("file-2"))
				{
					$photoUpdate = array();
					$file_name = $func->uploadName($_FILES['file-2']["name"]);

					if($photo2 = $func->uploadImage("file-2", $config['product']['img_type_item'], UPLOAD_PRODUCT, $file_name))
					{
						$photoUpdate['photo2'] = $photo2;
						$d->where('id', $id_insert);
						$d->update('product_item', $photoUpdate);
						unset($photoUpdate);
					}
				}
				*/

            /* SEO */
            $dataSeo['id_parent'] = $id_insert;
            $d->insert('product_item_seo', $dataSeo);

            /* Write json */
            $dataJson = array('type' => 'item');
            $func->writeJson($dataJson);

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_item&p=" . $curPage . $strUrl);
        } else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_item&p=" . $curPage . $strUrl, false);
    }
}

/* Delete item */
function deleteItem()
{
    global $d, $strUrl, $func, $curPage, $com;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo, photo2 from #_product_item where id = ? limit 0,1", array($id));

        if (!empty($row['id'])) {
            $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
            $func->deleteFile(UPLOAD_PRODUCT . $row['photo2']);
            $d->rawQuery("delete from #_product_item where id = ?", array($id));

            /* Xóa Status Shop */
            $d->rawQuery("delete from #_product_item_status where id_parent = ?", array($id));

            /* Xóa SEO */
            $d->rawQuery("delete from #_product_item_seo where id_parent = ?", array($id));

            /* Write json */
            $dataJson = array('type' => 'item');
            $func->writeJson($dataJson);

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_item&p=" . $curPage . $strUrl);
        } else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_item&p=" . $curPage . $strUrl, false);
    } elseif (!empty($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo, photo2 from #_product_item where id = ? limit 0,1", array($id));

            if (!empty($row['id'])) {
                $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                $func->deleteFile(UPLOAD_PRODUCT . $row['photo2']);
                $d->rawQuery("delete from #_product_item where id = ?", array($id));

                /* Xóa Status Shop */
                $d->rawQuery("delete from #_product_item_status where id_parent = ?", array($id));

                /* Xóa SEO */
                $d->rawQuery("delete from #_product_item_seo where id_parent = ?", array($id));

                /* Write json */
                $dataJson = array('type' => 'item');
                $func->writeJson($dataJson);
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_item&p=" . $curPage . $strUrl);
    } else $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_item&p=" . $curPage . $strUrl, false);
}

/* View sub */
function viewSubs()
{
    global $d, $func, $strUrl, $curPage, $items, $paging;

    $where = "";

    if ($func->getGroup('active')) {
        /* Lọc cấp 1 theo Group */
        $idlist = $func->getGroup('list');

        /* Lọc cấp 2 theo Group */
        if (empty($_REQUEST['id_cat'])) {
            $idCatByGroup = $func->getGroup('cat');
        } else {
            $idcat = (!empty($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
        }
    } else {
        $idlist = (!empty($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
        $idcat = (!empty($_REQUEST['id_cat'])) ? htmlspecialchars($_REQUEST['id_cat']) : 0;
    }

    $iditem = (!empty($_REQUEST['id_item'])) ? htmlspecialchars($_REQUEST['id_item']) : 0;

    if ($idlist) $where .= " and id_list=$idlist";
    if (!empty($idCatByGroup)) {
        $idcat = implode(',', $idCatByGroup);
        $where .= " and id_cat in ($idcat)";
    } else if (!empty($idcat)) {
        $where .= " and id_cat=$idcat";
    }
    if ($iditem) $where .= " and id_item=$iditem";
    if (!empty($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_product_sub where id > 0 $where order by numb asc, id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_product_sub where id > 0 $where order by numb asc, id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_sub" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit sub */
function editSub()
{
    global $d, $func, $id_list, $strUrl, $curPage, $item;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    $where = '';

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_sub&p=" . $curPage . $strUrl, false);
    }

    /* Get data detail from Group */
    if ($func->getGroup('active')) {
        $where .= " and id_list=$id_list";
        $idCatByGroup = $func->getGroup('cat');

        if (!empty($idCatByGroup)) {
            $id_cat = (!empty($idCatByGroup)) ? implode(',', $idCatByGroup) : '';
            $where .= " and id_cat in ($id_cat)";
        }
    }

    $item = $d->rawQueryOne("select * from #_product_sub where id = ? $where limit 0,1", array($id));

    if (empty($item['id'])) {
        $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man_sub&p=" . $curPage . $strUrl, false);
    }
}

/* Save sub */
function saveSub()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com;

    /* Check empty post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_sub&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    $dataProperties = (!empty($_POST['properties'])) ? $_POST['properties'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        if (!empty($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
        $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
    }

    $data['properties'] = (!empty($dataProperties)) ? implode(',', $dataProperties) : '';

    /* Post seo */
    $dataSeo = (!empty($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
    if ($dataSeo) {
        foreach ($dataSeo as $column => $value) {
            $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
        }
    }

    /* Valid data */
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

        if (empty($id)) {
            $func->redirect("index.php?com=product&act=add_sub" . $strUrl);
        } else {
            $func->redirect("index.php?com=product&act=edit_sub" . $strUrl . "&id=" . $id);
        }
    }

    /* Update or add data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('product_sub', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['product']['img_type_sub'], UPLOAD_PRODUCT, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_product_sub where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('product_sub', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            $d->rawQuery("delete from #_product_sub_seo where id_parent = ?", array($id));
            $dataSeo['id_parent'] = $id;
            $d->insert('product_sub_seo', $dataSeo);

            /* Write json */
            $dataJson = array('type' => 'sub');
            $func->writeJson($dataJson);

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_sub&p=" . $curPage . $strUrl);
        } else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_sub&p=" . $curPage . $strUrl, false);
    } else {
        $data['date_created'] = time();

        if ($d->insert('product_sub', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['product']['img_type_sub'], UPLOAD_PRODUCT, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('product_sub', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            $dataSeo['id_parent'] = $id_insert;
            $d->insert('product_sub_seo', $dataSeo);

            /* Write json */
            $dataJson = array('type' => 'sub');
            $func->writeJson($dataJson);

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_sub&p=" . $curPage . $strUrl);
        } else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_sub&p=" . $curPage . $strUrl, false);
    }
}

/* Delete sub */
function deleteSub()
{
    global $d, $strUrl, $func, $curPage, $com;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_product_sub where id = ? limit 0,1", array($id));

        if (!empty($row['id'])) {
            $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
            $d->rawQuery("delete from #_product_sub where id = ?", array($id));

            /* Xóa SEO */
            $d->rawQuery("delete from #_product_sub_seo where id_parent = ?", array($id));

            /* Write json */
            $dataJson = array('type' => 'sub');
            $func->writeJson($dataJson);

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_sub&p=" . $curPage . $strUrl);
        } else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_sub&p=" . $curPage . $strUrl, false);
    } elseif (!empty($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_product_sub where id = ? limit 0,1", array($id));

            if (!empty($row['id'])) {
                $func->deleteFile(UPLOAD_PRODUCT . $row['photo']);
                $d->rawQuery("delete from #_product_sub where id = ?", array($id));

                /* Xóa SEO */
                $d->rawQuery("delete from #_product_sub_seo where id_parent = ?", array($id));

                /* Write json */
                $dataJson = array('type' => 'sub');
                $func->writeJson($dataJson);
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_sub&p=" . $curPage . $strUrl);
    } else $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_sub&p=" . $curPage . $strUrl, false);
}

/* View tags */
function viewTagss()
{
    global $d, $func, $strUrl, $curPage, $items, $paging;

    $where = "";

    if ($func->getGroup('active')) {
        /* Lọc cấp 1 theo Group */
        $idlist = $func->getGroup('list');
    } else {
        $idlist = (!empty($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    }

    if ($idlist) $where .= " and id_list=$idlist";
    if (!empty($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_product_tags where id > 0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_product_tags where id > 0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_tags" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit tags */
function editTags()
{
    global $d, $func, $id_list, $strUrl, $curPage, $item;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    $where = '';

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_tags&p=" . $curPage . $strUrl, false);
    }

    /* Get data detail from Group */
    if ($func->getGroup('active')) {
        $where .= " and id_list=$id_list";
    }

    $item = $d->rawQueryOne("select * from #_product_tags where id = ? $where limit 0,1", array($id));

    if (empty($item['id'])) {
        $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man_tags&p=" . $curPage . $strUrl, false);
    }
}

/* Save tags */
function saveTags()
{
    global $d, $strUrl, $func, $flash, $curPage, $config, $com;

    /* Check empty post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_tags&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        if (!empty($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
        $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
    }

    /* Post seo */
    $dataSeo = (!empty($_POST['dataSeo'])) ? $_POST['dataSeo'] : null;
    if ($dataSeo) {
        foreach ($dataSeo as $column => $value) {
            $dataSeo[$column] = htmlspecialchars($func->sanitize($value));
        }
    }

    /* Valid data */
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

        if (empty($id)) {
            $func->redirect("index.php?com=product&act=add_tags" . $strUrl);
        } else {
            $func->redirect("index.php?com=product&act=edit_tags" . $strUrl . "&id=" . $id);
        }
    }

    /* Update or add data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('product_tags', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['product']['img_type_tags'], UPLOAD_TAGS, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_product_tags where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_TAGS . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('product_tags', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            $d->rawQuery("delete from #_product_tags_seo where id_parent = ?", array($id));
            $dataSeo['id_parent'] = $id;
            $d->insert('product_tags_seo', $dataSeo);

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_tags&p=" . $curPage . $strUrl);
        } else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_tags&p=" . $curPage . $strUrl, false);
    } else {
        $data['date_created'] = time();

        if ($d->insert('product_tags', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['product']['img_type_tags'], UPLOAD_TAGS, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('product_tags', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            /* SEO */
            $dataSeo['id_parent'] = $id_insert;
            $d->insert('product_tags_seo', $dataSeo);

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_tags&p=" . $curPage . $strUrl);
        } else $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_tags&p=" . $curPage . $strUrl, false);
    }
}

/* Delete tags */
function deleteTags()
{
    global $d, $strUrl, $func, $curPage, $com, $defineSectors;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id, photo from #_product_tags where id = ? limit 0,1", array($id));

        if (!empty($row['id'])) {
            $func->deleteFile(UPLOAD_TAGS . $row['photo']);
            $d->rawQuery("delete from #_product_tags where id = ?", array($id));

            /* Xóa tags in products */
            foreach ($defineSectors['types'] as $v_tag) {
                if (!empty($v_tag['tables']['tag'])) {
                    $d->rawQuery("delete from #_" . $v_tag['tables']['tag'] . " where id_tag = ?", array($id));
                }
            }

            /* Xóa SEO */
            $d->rawQuery("delete from #_product_tags_seo where id_parent = ?", array($id));

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_tags&p=" . $curPage . $strUrl);
        } else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_tags&p=" . $curPage . $strUrl, false);
    } elseif (!empty($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id, photo from #_product_tags where id = ? limit 0,1", array($id));

            if (!empty($row['id'])) {
                $func->deleteFile(UPLOAD_TAGS . $row['photo']);
                $d->rawQuery("delete from #_product_tags where id = ?", array($id));

                /* Xóa tags in products */
                foreach ($defineSectors['types'] as $v_tag) {
                    if (!empty($v_tag['tables']['tag'])) {
                        $d->rawQuery("delete from #_" . $v_tag['tables']['tag'] . " where id_tag = ?", array($id));
                    }
                }

                /* Xóa SEO */
                $d->rawQuery("delete from #_product_tags_seo where id_parent = ?", array($id));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_tags&p=" . $curPage . $strUrl);
    } else $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_tags&p=" . $curPage . $strUrl, false);
}

/* View size */
function viewSizes()
{
    global $d, $func, $curPage, $strUrl, $items, $paging;

    $where = "";

    if ($func->getGroup('active')) {
        /* Lọc cấp 1 theo Group */
        $idlist = $func->getGroup('list');
    } else {
        $idlist = (!empty($_REQUEST['id_list'])) ? htmlspecialchars($_REQUEST['id_list']) : 0;
    }

    if ($idlist) $where .= " and id_list=$idlist";
    if (!empty($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_product_size where id > 0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_product_size where id > 0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_size" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit size */
function editSize()
{
    global $d, $func, $curPage, $strUrl, $item;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_size&p=" . $curPage . $strUrl, false);
    } else {
        $item = $d->rawQueryOne("select * from #_product_size where id = ? limit 0,1", array($id));

        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man_size&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Save size */
function saveSize()
{
    global $d, $func, $flash, $curPage, $strUrl, $config;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_size&p=" . $curPage . $strUrl, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
        $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
    }

    /* Valid data */
    if (empty($data['namevi'])) {
        $response['messages'][] = 'Tiêu đề không được trống';
    }

    if (!empty($data['namevi']) && $func->checkExistData($data['slugvi'], 'product_size', $id)) {
        $response['messages'][] = 'Kích cỡ đã tồn tại';
    }

    if (empty($data['id_list'])) {
        $response['messages'][] = 'Chưa chọn danh mục chính';
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

        if ($id) {
            $func->redirect("index.php?com=product&act=edit_size&p=" . $curPage . $strUrl . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=product&act=add_size&p=" . $curPage . $strUrl);
        }
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('product_size', $data)) {
            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_size&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_size&p=" . $curPage . $strUrl, false);
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('product_size', $data)) {
            $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_size&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_size&p=" . $curPage . $strUrl, false);
        }
    }
}

/* Delete size */
function deleteSize()
{
    global $d, $func, $curPage, $strUrl, $defineSectors;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select id from #_product_size where id = ? limit 0,1", array($id));

        if (!empty($row)) {
            $d->rawQuery("delete from #_product_size where id = ?", array($id));

            /* Delete related data */
            $func->deleteSale($id, 'size');

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_size&p=" . $curPage . $strUrl);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_size&p=" . $curPage . $strUrl, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select id from #_product_size where id = ? limit 0,1", array($id));

            if (!empty($row)) {
                $d->rawQuery("delete from #_product_size where id = ?", array($id));

                /* Delete related data */
                $func->deleteSale($id, 'size');
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_size&p=" . $curPage . $strUrl);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_size&p=" . $curPage . $strUrl, false);
    }
}

/* View color */
function viewColors()
{
    global $d, $func, $curPage, $items, $paging;

    $where = "";

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (namevi LIKE '%$keyword%' or nameen LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select * from #_product_color where id > 0 $where order by numb,id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_product_color where id > 0 $where order by numb,id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=product&act=man_color";
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Edit color */
function editColor()
{
    global $d, $func, $curPage, $item;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_color&p=" . $curPage, false);
    } else {
        $item = $d->rawQueryOne("select * from #_product_color where id = ? limit 0,1", array($id));

        if (empty($item)) {
            $func->transfer("Dữ liệu không có thực", "index.php?com=product&act=man_color&p=" . $curPage, false);
        }
    }
}

/* Save color */
function saveColor()
{
    global $d, $func, $flash, $curPage, $config;

    /* Check post */
    if (empty($_POST)) {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_color&p=" . $curPage, false);
    }

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    if ($data) {
        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        if (isset($_POST['status'])) {
            $status = '';
            foreach ($_POST['status'] as $attr_column => $attr_value) if ($attr_value != "") $status .= $attr_value . ',';
            $data['status'] = (!empty($status)) ? rtrim($status, ",") : "";
        } else {
            $data['status'] = "";
        }

        $data['slugvi'] = (!empty($data['namevi'])) ? $func->changeTitle($data['namevi']) : '';
        $data['slugen'] = (!empty($data['nameen'])) ? $func->changeTitle($data['nameen']) : '';
    }

    /* Valid data */
    if (empty($data['namevi'])) {
        $response['messages'][] = 'Tiêu đề không được trống';
    }

    if (!empty($data['namevi']) && $func->checkExistData($data['slugvi'], 'product_color', $id)) {
        $response['messages'][] = 'Màu sắc đã tồn tại';
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

        if ($id) {
            $func->redirect("index.php?com=product&act=edit_color&p=" . $curPage . "&id=" . $id);
        } else {
            $func->redirect("index.php?com=product&act=add_color&p=" . $curPage);
        }
    }

    /* Save data */
    if ($id) {
        $data['date_updated'] = time();

        $d->where('id', $id);
        if ($d->update('product_color', $data)) {
            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES["file"]["name"]);

                if ($photo = $func->uploadImage("file", $config['product']['img_type_color'], UPLOAD_COLOR, $file_name)) {
                    $row = $d->rawQueryOne("select id, photo from #_product_color where id = ? limit 0,1", array($id));

                    if (!empty($row)) {
                        $func->deleteFile(UPLOAD_COLOR . $row['photo']);
                    }

                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id);
                    $d->update('product_color', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=product&act=man_color&p=" . $curPage);
        } else {
            $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=product&act=man_color&p=" . $curPage, false);
        }
    } else {
        $data['date_created'] = time();

        if ($d->insert('product_color', $data)) {
            $id_insert = $d->getLastInsertId();

            /* Photo */
            if ($func->hasFile("file")) {
                $photoUpdate = array();
                $file_name = $func->uploadName($_FILES['file']["name"]);

                if ($photo = $func->uploadImage("file", $config['product']['img_type_color'], UPLOAD_COLOR, $file_name)) {
                    $photoUpdate['photo'] = $photo;
                    $d->where('id', $id_insert);
                    $d->update('product_color', $photoUpdate);
                    unset($photoUpdate);
                }
            }

            $func->transfer("Lưu dữ liệu thành công", "index.php?com=product&act=man_color&p=" . $curPage);
        } else {
            $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=product&act=man_color&p=" . $curPage, false);
        }
    }
}

/* Delete color */
function deleteColor()
{
    global $d, $curPage, $func;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if ($id) {
        $row = $d->rawQueryOne("select * from #_product_color where id = ? limit 0,1", array($id));

        if (!empty($row)) {
            $func->deleteFile(UPLOAD_COLOR . $row['photo']);
            $d->rawQuery("delete from #_product_color where id = ?", array($id));

            /* Delete related data */
            $func->deleteSale($id, 'color');

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_color&p=" . $curPage);
        } else {
            $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=product&act=man_color&p=" . $curPage, false);
        }
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);
            $row = $d->rawQueryOne("select * from #_product_color where id = ? limit 0,1", array($id));

            if (!empty($row)) {
                $func->deleteFile(UPLOAD_COLOR . $row['photo']);
                $d->rawQuery("delete from #_product_color where id = ?", array($id));

                /* Delete related data */
                $func->deleteSale($id, 'color');
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=product&act=man_color&p=" . $curPage);
    } else {
        $func->transfer("Không nhận được dữ liệu", "index.php?com=product&act=man_color&p=" . $curPage, false);
    }
}
