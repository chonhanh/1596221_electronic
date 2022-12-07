<?php
if (!defined('SOURCES')) die("Error");

/* Cấu hình đường dẫn trả về */
$strUrl = "";
$strUrl .= (isset($_REQUEST['keyword'])) ? "&keyword=" . htmlspecialchars($_REQUEST['keyword']) : "";

switch ($act) {
    case "man":
        viewMans();
        $template = "chat/man/mans";
        break;
    case "message":
        messageMan();
        $template = "chat/man/man_message";
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
    global $d, $idShop, $configSector, $func, $strUrl, $curPage, $items, $paging;

    /* Tables */
    $tableShopChat = (!empty($configSector['tables']['shop-chat'])) ? $configSector['tables']['shop-chat'] : '';

    $where = "";

    $status = (!empty($_REQUEST['status'])) ? htmlspecialchars($_REQUEST['status']) : '';

    if (!empty($status) && $status == 'new') {
        $chat = $d->rawQuery("select distinct id_parent, id from #_$tableShopChat where id_shop = $idShop and find_in_set('new-shop',status)");

        if (!empty($chat)) {
            $newChat = array();

            foreach ($chat as $v) {
                if ($v['id_parent'] > 0 && !in_array($v['id_parent'], $newChat)) {
                    $parentChat = $d->rawQueryOne("select id from #_$tableShopChat where id_shop = $idShop and id = ? limit 0,1", array($v['id_parent']));

                    if (!empty($parentChat)) {
                        array_push($newChat, $parentChat['id']);
                    }
                } else if ($v['id_parent'] == 0) {
                    array_push($newChat, $v['id']);
                }
            }

            $newChat = (!empty($newChat)) ? implode(",", $newChat) : 0;
            $where .= " and A.id in ($newChat)";
        } else {
            $where .= " and find_in_set('new-shop',A.status)";
        }
    } else {
        $where .= " and A.id_parent = 0";
    }

    if (isset($_REQUEST['keyword'])) {
        $keyword = htmlspecialchars($_REQUEST['keyword']);
        $where .= " and (B.fullname LIKE '%$keyword%')";
    }

    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select A.*, B.avatar as avatar, B.fullname as fullname, B.phone as phone, B.email as email from #_$tableShopChat as A inner join #_member as B where A.id_member = B.id and A.id_shop = $idShop $where order by A.id desc $limit";
    $items = $d->rawQuery($sql);
    $sqlNum = "select count(*) as 'num' from #_$tableShopChat as A inner join #_member as B where A.id_member = B.id and A.id_shop = $idShop $where order by A.id desc";
    $count = $d->rawQueryOne($sqlNum);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = "index.php?com=chat&act=man" . $strUrl;
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

/* Message man */
function messageMan()
{
    global $d, $config, $idShop, $configSector, $prefixSector, $sampleData, $strUrl, $func, $curPage, $item, $messages, $logoShop, $chatPhoto, $limitLoad, $total;

    /* Tables */
    $tableShop = (!empty($configSector['tables']['shop'])) ? $configSector['tables']['shop'] : '';
    $tableShopChat = (!empty($configSector['tables']['shop-chat'])) ? $configSector['tables']['shop-chat'] : '';
    $tableShopChatPhoto = (!empty($configSector['tables']['shop-chat-photo'])) ? $configSector['tables']['shop-chat-photo'] : '';

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (empty($id)) $func->transfer("Không nhận được dữ liệu", "index.php?com=chat&act=man&p=" . $curPage . $strUrl, false);

    $item = $d->rawQueryOne("select A.*, B.avatar as avatar, B.fullname as fullname, B.address as address, B.phone as phone, B.email as email, S.name as shopName, P.photo as logo from #_$tableShopChat as A inner join #_member as B inner join #_$tableShop as S left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = ? and P.type = 'logo' where A.id_member = B.id and A.id_shop = $idShop and A.id_parent = 0 and A.id = ? and A.id_shop = S.id limit 0,1", array($prefixSector, $id));

    if (empty($item)) {
        $func->transfer("Dữ liệu không có thực", "index.php?com=chat&act=man&p=" . $curPage . $strUrl, false);
    }

    /* Logo for shop */
    $item['logo'] = (!empty($item['logo'])) ? $item['logo'] : ((!empty($sampleData['logo'])) ? $sampleData['logo'] : array());

    /* Photo for chat */
    $chatPhoto = $d->rawQuery("select photo from #_$tableShopChatPhoto where id_parent = ? order by id desc", array($item['id']));

    /* Update status */
    $d->rawQuery("update #_$tableShopChat set status = replace(status, 'new-shop', '') where id = ? or id_parent = ?", array($id, $id));

    /* SQL messages */
    $sqlMessages = "select * from #_$tableShopChat where id_shop = $idShop and id_member = ? order by date_posted desc";

    /* SQL num */
    $sqlMessagesNum = "select count(*) as 'num' from #_$tableShopChat where id_shop = $idShop and id_member = ? order by date_posted desc";

    /* For load more ajax */
    $limitLoad = $config['website']['load-more']['chat'];
    $limitFrom = (!empty($_GET['limitFrom'])) ? htmlspecialchars($_GET['limitFrom']) : 0;
    $limitGet = (!empty($_GET['limitGet'])) ? htmlspecialchars($_GET['limitGet']) : $limitLoad['show'];
    $messages = $d->rawQuery($sqlMessages . " limit " . $limitFrom . "," . $limitGet, array($item['id_member']));
    $count = $d->rawQueryOne($sqlMessagesNum, array($item['id_member']));
    $total = (!empty($count)) ? $count['num'] : 0;

    /* Order data */
    $messages = sortingChatMember($messages);

    /* Jsons data */
    if ($func->isAjax()) {
        $resultAjax = array();
        $resultAjax['data'] = '';

        if (!empty($messages)) {
            foreach ($messages as $v_message) {
                $params = array();
                $params['detail'] = $item;
                $params['message'] = $v_message;

                $resultAjax['data'] .= $func->markdown('chat/lists', $params);
            }
        }

        echo json_encode($resultAjax);
        exit();
    }
}

/* Sorting man */
function sortingChatMember($messages)
{
    function compareChat($data1, $data2)
    {
        return $data1['date_posted'] > $data2['date_posted'];
    }

    usort($messages, "compareChat");

    return $messages;
}

/* Save man */
function saveMan()
{
    global $d, $idShop, $configSector, $strUrl, $func, $flash, $curPage, $config, $com, $act;

    if (empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=chat&act=man&p=" . $curPage . $strUrl, false);

    /* Post dữ liệu */
    $message = '';
    $response = array();
    $id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
    $id_member = (!empty($_POST['id_member'])) ? htmlspecialchars($_POST['id_member']) : 0;
    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;
    $tableShopChat = (!empty($configSector['tables']['shop-chat'])) ? $configSector['tables']['shop-chat'] : '';

    /* Check data main */
    if ($data) {
        $data['id_shop'] = $idShop;
        $data['id_parent'] = $id;
        $data['id_member'] = $id_member;

        foreach ($data as $column => $value) {
            $data[$column] = htmlspecialchars($func->sanitize($value));
        }

        $data['poster'] = 'shop';
        $data['status'] = "new-member";
        $data['date_posted'] = time();
    }

    /* Valid data */
    if (empty($data['message'])) {
        $response['messages'][] = 'Nội dung tin nhắn không được trống';
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
            $func->redirect("index.php?com=chat&act=man&p=" . $curPage . $strUrl);
        } else {
            $func->redirect("index.php?com=chat&act=message&p=" . $curPage . $strUrl . "&id=" . $id);
        }
    }

    /* Save or insert data by sectors */
    if ($d->insert($tableShopChat, $data)) {
        $func->redirect("index.php?com=chat&act=message&p=" . $curPage . "&id=" . $id);
    } else {
        $func->transfer("Gửi tin nhắn bị lỗi. Vui lòng thử lại sau", "index.php?com=chat&act=message&p=" . $curPage . "&id=" . $id, false);
    }
}

/* Delete man */
function deleteMan()
{
    global $d, $idShop, $configSector, $strUrl, $func, $curPage, $com;

    $id = (isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;
    $tableShopChat = (!empty($configSector['tables']['shop-chat'])) ? $configSector['tables']['shop-chat'] : '';
    $tableShopChatPhoto = (!empty($configSector['tables']['shop-chat-photo'])) ? $configSector['tables']['shop-chat-photo'] : '';

    if ($id) {
        /* Lấy dữ liệu */
        $row = $d->rawQueryOne("select id from #_$tableShopChat where id_shop = $idShop and id = ? limit 0,1", array($id));

        if (isset($row['id']) && $row['id'] > 0) {
            /* Xóa chính */
            $d->rawQuery("delete from #_$tableShopChat where id_shop = $idShop and id = ?", array($id));
            $d->rawQuery("delete from #_$tableShopChat where id_shop = $idShop and id_parent = ?", array($id));

            /* Photo */
            $photo = $d->rawQuery("select photo from #_$tableShopChatPhoto where id_parent = ?", array($id));

            if (!empty($photo)) {
                foreach ($photo as $v_photo) {
                    $func->deleteFile(UPLOAD_PHOTO . $v_photo['photo']);
                }
            }

            /* Xóa photo */
            $d->rawQuery("delete from #_$tableShopChatPhoto where id_parent = ?", array($id));

            $func->transfer("Xóa dữ liệu thành công", "index.php?com=chat&act=man&p=" . $curPage . $strUrl);
        } else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=chat&act=man&p=" . $curPage . $strUrl, false);
    } elseif (isset($_GET['listid'])) {
        $listid = explode(",", $_GET['listid']);

        for ($i = 0; $i < count($listid); $i++) {
            $id = htmlspecialchars($listid[$i]);

            /* Lấy dữ liệu */
            $row = $d->rawQueryOne("select id from #_$tableShopChat where id_shop = $idShop and id = ? limit 0,1", array($id));

            if (isset($row['id']) && $row['id'] > 0) {
                /* Xóa chính */
                $d->rawQuery("delete from #_$tableShopChat where id_shop = $idShop and id = ?", array($id));
                $d->rawQuery("delete from #_$tableShopChat where id_shop = $idShop and id_parent = ?", array($id));

                /* Photo */
                $photo = $d->rawQuery("select photo from #_$tableShopChatPhoto where id_parent = ?", array($id));

                if (!empty($photo)) {
                    foreach ($photo as $v_photo) {
                        $func->deleteFile(UPLOAD_PHOTO . $v_photo['photo']);
                    }
                }

                /* Xóa photo */
                $d->rawQuery("delete from #_$tableShopChatPhoto where id_parent = ?", array($id));
            }
        }

        $func->transfer("Xóa dữ liệu thành công", "index.php?com=chat&act=man&p=" . $curPage . $strUrl);
    } else $func->transfer("Không nhận được dữ liệu", "index.php?com=chat&act=man&p=" . $curPage . $strUrl, false);
}

/* Total */
function totalMan($id_member = 0)
{
    global $d, $idShop, $configSector;

    /* Tables */
    $tableShopChat = (!empty($configSector['tables']['shop-chat'])) ? $configSector['tables']['shop-chat'] : '';

    $row = $d->rawQueryOne("select count(*) as num from #_$tableShopChat where id_shop = $idShop and id_member = ?", array($id_member));
    return (!empty($row)) ? $row['num'] : 0;
}

/* New */
function newMan($id_member = 0)
{
    global $d, $idShop, $configSector;

    /* Tables */
    $tableShopChat = (!empty($configSector['tables']['shop-chat'])) ? $configSector['tables']['shop-chat'] : '';

    $row = $d->rawQueryOne("select count(*) as num from #_$tableShopChat where id_shop = $idShop and id_member = ? and find_in_set('new-shop',status)", array($id_member));
    return (!empty($row)) ? $row['num'] : 0;
}
