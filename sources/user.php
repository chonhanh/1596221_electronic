<?php
if (!defined('SOURCES')) die("Error");

$action = htmlspecialchars($match['params']['action']);

switch ($action) {
    case 'dashboard':
        $title_crumb = 'Trang cá nhân';
        $template = "account/dashboard";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        dashboardMember();
        break;

    case 'dang-nhap':
        $title_crumb = dangnhap;
        $template = "account/login";
        $hasAdvertise = true;
        if (!empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        if (!empty($_POST['login-user'])) loginMember();
        break;

    case 'dang-ky':
        $title_crumb = dangky;
        $template = "account/registration";
        $hasAdvertise = true;
        if (!empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        signupMember();
        break;

    case 'quen-mat-khau':
        $title_crumb = quenmatkhau;
        $template = "account/forgot_password";
        $hasAdvertise = true;
        if (!empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        if (!empty($_POST['forgot-password-user'])) forgotPasswordMember();
        break;

    case 'kich-hoat':
        $title_crumb = kichhoat;
        $template = "account/activation";
        $hasAdvertise = true;
        if (!empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        checkActivationMember();
        break;

    case 'thong-tin':
        $title_crumb = capnhatthongtin;
        $template = "account/info";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        infoMember();
        break;

    case 'doi-mat-khau':
        $title_crumb = 'Đổi mật khẩu';
        $template = "account/change_password";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        changePasswordMember();
        break;

    case 'dang-xuat':
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        logoutMember();

    case 'thong-bao':
        $title_crumb = 'Thông báo từ chợ nhanh';
        $template = "account/mails";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        mailsMember();
        break;

    case 'binh-luan':
        $title_crumb = 'Danh sách bình luận';
        $template = "account/comment/comment";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        commentMember();
        break;

    case 'chi-tiet-binh-luan':
        $title_crumb = 'Chi tiết bình luận';
        $template = "account/comment/comment_detail";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        detailCommentMember();
        break;

    case 'tro-chuyen':
        $title_crumb = 'Danh sách trò chuyện';
        $template = "account/chat/chat";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        chatMember();
        break;

    case 'chi-tiet-tro-chuyen':
        $title_crumb = 'Chi tiết trò chuyện';
        $template = "account/chat/chat_detail";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        detailChatMember();
        break;

    case 'gui-tin-nhan':
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        sendChatMember();
        break;

    case 'gian-hang':
        $title_crumb = 'Danh sách gian hàng';
        $template = "account/shop/shop";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        shopMember();
        break;

    case 'chi-tiet-gian-hang':
        $title_crumb = 'Chi tiết gian hàng';
        $template = "account/shop/shop_detail";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        detailShopMember();
        break;

    case 'cap-nhat-gian-hang':
        $title_crumb = 'Cập nhật gian hàng';
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        updateShopMember();
        break;

    case 'tin-dang-quan-tam':
        $title_crumb = 'Danh sách tin đăng đã quan tâm';
        $template = "account/posting/favourite";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        favouritePostingMember();
        break;

    case 'tin-dang-moi':
        $title_crumb = 'Danh sách tin đăng mới';
        $template = "account/posting/posting_new";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        newPostingMember();
        break;

    case 'tin-dang':
        $title_crumb = 'Danh sách tin đăng';
        $template = "account/posting/posting";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        postingMember();
        break;

    case 'chi-tiet-tin-dang':
        $title_crumb = 'Chi tiết tin đăng';
        $template = "account/posting/posting_detail";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        detailPostingMember();
        break;

    case 'cap-nhat-tin-dang':
        $title_crumb = 'Cập nhật tin đăng';
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        updatePostingMember();
        break;

    case 'dat-hang':
        $title_crumb = 'Danh sách đặt hàng';
        $template = "account/cart/cart";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        cartMember();
        break;

    case 'chi-tiet-dat-hang':
        $title_crumb = 'Chi tiết đặt hàng';
        $template = "account/cart/cart_detail";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        detailCartMember();
        break;

    case 'cap-nhat-dat-hang':
        $title_crumb = 'Cập nhật đặt hàng';
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        updateCartMember();
        break;

    case 'don-hang':
        $title_crumb = 'Danh sách đơn hàng';
        $template = "account/order/order";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        orderMember();
        break;

    case 'chi-tiet-don-hang':
        $title_crumb = 'Chi tiết đơn hàng';
        $template = "account/order/order_detail";
        $manageMember = true;
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        detailOrderMember();
        break;

    case 'cap-nhat-don-hang':
        $title_crumb = 'Cập nhật đơn hàng';
        if (empty($_SESSION[$loginMember]['active'])) $func->transfer("Trang không tồn tại", $configBase, false);
        updateOrderMember();
        break;

    default:
        header('HTTP/1.0 404 Not Found', true, 404);
        include("404.php");
        exit();
}

/* SEO */
$seo->set('title', $title_crumb);

function dashboardMember()
{
    global $d, $loginMember, $photoDashboard;

    /* Data */
    $iduser = $_SESSION[$loginMember]['id'];
    $dashboard = $d->rawQueryOne("select id_city, photo1, photo2, gender from #_member_dashboard limit 0,1");
    $detailMember = $d->rawQueryOne("select id_city, last_name, gender, birthday from #_member where id = ? limit 0,1", array($iduser));
    $today = date('d/m', time());
    $birthdayMember = (!empty($detailMember['birthday'])) ? date('d/m', $detailMember['birthday']) : '';
    $cityDashboard = (!empty($dashboard['id_city'])) ? explode(",", $dashboard['id_city']) : array();
    $photoDashboard = (!empty($dashboard['photo1'])) ? $dashboard['photo1'] : '';

    /* Check data */
    if (($birthdayMember == $today) && in_array($detailMember['id_city'], $cityDashboard) && strstr($dashboard['gender'], $detailMember['gender'])) {
        $photoDashboard = (!empty($dashboard['photo2'])) ? $dashboard['photo2'] : $dashboard['photo1'];
    }
}

function mailsMember()
{
    global $d, $func, $cache, $loginMember, $lang, $getPage, $mails, $paging;

    $iduser = $_SESSION[$loginMember]['id'];

    /* Lấy tất cả bài viết */
    $where = "";
    $where = "id_member = ?";
    $params = array($iduser);

    $curPage = $getPage;
    $perPage = 32;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select id, is_readed, title, content from #_member_mails where $where order by id desc $limit";
    $mails = $cache->get($sql, $params, "result", 7200);
    $sqlNum = "select count(*) as 'num' from #_member_mails where $where order by id desc";
    $count = $cache->get($sqlNum, $params, "fetch", 7200);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}

function commentMember()
{
    global $d, $idShop, $func, $cache, $defineSectors, $sector, $IDSector, $loginMember, $configBase, $lang, $getPage, $comment, $products, $paging;

    $iduser = $_SESSION[$loginMember]['id'];
    $IDSector = (!empty($_GET['sector'])) ? $_GET['sector'] : 0;

    /* Sector detail */
    if (!empty($IDSector)) {
        $sectorDetail = $cache->get("select type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

        /* Check sector */
        if (!empty($sectorDetail)) {
            /* Sector list */
            $sector = $defineSectors['types'][$sectorDetail['type']];
            $tableProductMain = (!empty($sector['tables']['main'])) ? $sector['tables']['main'] : '';
            $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';
            $tableProductComment = (!empty($sector['tables']['comment'])) ? $sector['tables']['comment'] : '';
            $tableProductCommentPhoto = (!empty($sector['tables']['comment-photo'])) ? $sector['tables']['comment-photo'] : '';
            $tableProductCommentVideo = (!empty($sector['tables']['comment-video'])) ? $sector['tables']['comment-video'] : '';

            if (!empty($tableProductMain) && !empty($tableProductComment)) {
                /* Where product */
                $whereProduct = "A.id_shop = $idShop and A.status = ? and A.status_user = ? and A.id_member = ?";
                $paramsProduct = array('xetduyet', 'hienthi', $iduser);

                /* SQL paging */
                $curPage = $getPage;
                $perPage = 28;
                $startpoint = ($curPage * $perPage) - $perPage;

                /* SQL main */
                $sqlProduct = "select A.id as id, A.name$lang as name$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.date_created as date_created from #_$tableProductMain as A inner join #_$tableProductComment as C on C.id = (select id from #_$tableProductComment as LJ_C where A.id = LJ_C.id_product limit 0,1) and find_in_set('hienthi',C.status) where $whereProduct order by C.date_posted desc limit $startpoint,$perPage";

                /* SQL num */
                $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A inner join #_$tableProductComment as C on C.id = (select id from #_$tableProductComment as LJ_C where A.id = LJ_C.id_product limit 0,1) and find_in_set('hienthi',C.status) where $whereProduct order by C.date_posted desc";

                /* Get data */
                if (!empty($sqlProduct)) {
                    $products = $cache->get($sqlProduct, $paramsProduct, 'result', 7200);
                    $count = $cache->get($sqlProductNum, $paramsProduct, 'fetch', 7200);
                    $total = (!empty($count)) ? $count['num'] : 0;
                    $url = $func->getCurrentPageURL();
                    $paging = $func->pagination($total, $perPage, $curPage, $url);
                }

                /* Comment */
                $comment = new Comments($d, $func, ['shop' => $tableShop, 'main' => $tableProductComment, 'photo' => $tableProductCommentPhoto, 'video' => $tableProductCommentVideo], $sector['prefix']);
            } else {
                $func->transfer("Dữ liệu không hợp lệ", $configBase, false);
            }
        } else {
            /* Redirect */
            $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
        }
    }
}

function detailCommentMember()
{
    global $d, $idShop, $func, $cache, $defineSectors, $sector, $IDSector, $loginMember, $configBase, $lang, $productDetail, $comment;

    $iduser = $_SESSION[$loginMember]['id'];
    $IDSector = (!empty($_GET['sector'])) ? $_GET['sector'] : 0;
    $IDPostingDetail = (!empty($_GET['id'])) ? $_GET['id'] : 0;

    /* Sector detail */
    if (!empty($IDSector) && !empty($IDPostingDetail)) {
        $sectorDetail = $cache->get("select type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

        /* Check sector */
        if (!empty($sectorDetail)) {
            /* Sector list */
            $sector = $defineSectors['types'][$sectorDetail['type']];

            /* Tables */
            $tableProductMain = (!empty($sector['tables']['main'])) ? $sector['tables']['main'] : '';
            $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';
            $tableProductComment = (!empty($sector['tables']['comment'])) ? $sector['tables']['comment'] : '';
            $tableProductCommentPhoto = (!empty($sector['tables']['comment-photo'])) ? $sector['tables']['comment-photo'] : '';
            $tableProductCommentVideo = (!empty($sector['tables']['comment-video'])) ? $sector['tables']['comment-video'] : '';

            if (!empty($tableProductMain) && !empty($tableProductComment)) {
                /* Where logic when owner or shop unactive */
                $whereLogicOwner = $func->getLogicOwner($tableShop, $sector, false);
                $where = $whereLogicOwner['where'];

                /* Get data detail */
                $productDetail = $cache->get("select id, namevi, slugvi, slugen, photo, date_created from #_$tableProductMain where id = ? and id_member = ? $where limit 0,1", array($IDPostingDetail, $iduser), 'fetch', 7200);

                /* Check data detail */
                if (!empty($productDetail)) {
                    /* Comment */
                    $comment = new Comments($d, $func, ['shop' => $tableShop, 'main' => $tableProductComment, 'photo' => $tableProductCommentPhoto, 'video' => $tableProductCommentVideo], $sector['prefix'], $productDetail['id']);
                } else {
                    $func->transfer("Dữ liệu không có thực", $configBase, false);
                }
            }
        } else {
            /* Redirect */
            $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
        }
    } else {
        $func->transfer("Trang không tồn tại", $configBase, false);
    }
}

function chatMember()
{
    global $d, $func, $cache, $defineSectors, $sector, $IDSector, $loginMember, $configBase, $lang, $getPage, $shops, $sampleData, $paging, $iduser;

    $iduser = $_SESSION[$loginMember]['id'];
    $IDSector = (!empty($_GET['sector'])) ? $_GET['sector'] : 0;

    /* Sector detail */
    if (!empty($IDSector)) {
        $sectorDetail = $cache->get("select type, id from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

        /* Check sector */
        if (!empty($sectorDetail) && $func->hasShop($sectorDetail)) {
            /* Sector list */
            $sector = $defineSectors['types'][$sectorDetail['type']];
            $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';
            $tableShopChat = (!empty($sector['tables']['shop-chat'])) ? $sector['tables']['shop-chat'] : '';

            if (!empty($tableShop) && !empty($tableShopChat)) {
                /* Sample data */
                $sampleData = $cache->get("select id_interface, logo from #_sample", null, 'result', 7200);

                if (!empty($sampleData)) {
                    $sampleData['interface'] = array();
                    foreach ($sampleData as $k => $v) {
                        if ($func->isNumber($k)) {
                            $sampleData['interface'][$v['id_interface']] = $v;
                        }
                    }
                }

                /* Shops */
                $curPage = $getPage;
                $perPage = 30;
                $startpoint = ($curPage * $perPage) - $perPage;
                $whereShop = "A.status = ? and A.status_user = ?";
                $paramsShop = array($sector['prefix'], 'xetduyet', 'hienthi');

                /* SQL shop */
                $sqlShop = "select A.id as id, A.id_interface as interface, A.date_created as date_created, A.name as name, A.photo as photo, A.slug_url as slug_url, CH.id as id_chat, B.name as nameCity, C.name as nameDistrict, D.name as nameWard, P.photo as logo from #_$tableShop as A inner join #_$tableShopChat as CH on CH.id = (select id from #_$tableShopChat as LJ_CH where A.id = LJ_CH.id_shop and LJ_CH.id_parent = 0 and LJ_CH.id_member = $iduser limit 0,1) inner join #_city as B inner join #_district as C inner join #_wards as D left join #_photo as P on A.id = P.id_shop and P.sector_prefix = ? and P.type = 'logo' where $whereShop and A.id_city = B.id and A.id_district = C.id and A.id_wards = D.id order by A.numb,A.id desc limit $startpoint,$perPage";

                /* SQL num */
                $sqlShopNum = "select count(*) as 'num' from #_$tableShop as A inner join #_$tableShopChat as CH on CH.id = (select id from #_$tableShopChat as LJ_CH where A.id = LJ_CH.id_shop and LJ_CH.id_parent = 0 and LJ_CH.id_member = $iduser limit 0,1) inner join #_city as B inner join #_district as C inner join #_wards as D left join #_photo as P on A.id = P.id_shop and P.sector_prefix = ? and P.type = 'logo' where $whereShop and A.id_city = B.id and A.id_district = C.id and A.id_wards = D.id order by A.numb,A.id desc";

                /* Get data */
                if (!empty($sqlShop)) {
                    $shops = $cache->get($sqlShop, $paramsShop, 'result', 7200);
                    $count = $cache->get($sqlShopNum, $paramsShop, 'fetch', 7200);
                    $total = (!empty($count)) ? $count['num'] : 0;
                    $url = $func->getCurrentPageURL();
                    $paging = $func->pagination($total, $perPage, $curPage, $url);
                }
            } else {
                $func->transfer("Dữ liệu không hợp lệ", $configBase, false);
            }
        } else {
            /* Redirect */
            $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
        }
    }
}

function detailChatMember()
{
    global $d, $func, $cache, $config, $defineSectors, $sector, $IDSector, $IDShop, $IDChat, $loginMember, $configBase, $configBaseShop, $lang, $chatDetail, $messages, $limitLoad, $total;

    $iduser = $_SESSION[$loginMember]['id'];
    $IDSector = (!empty($_GET['sector'])) ? $_GET['sector'] : 0;
    $IDShop = (!empty($_GET['id_shop'])) ? $_GET['id_shop'] : 0;
    $IDChat = (!empty($_GET['id_chat'])) ? $_GET['id_chat'] : 0;

    /* Sector detail */
    if (!empty($IDSector) && !empty($IDShop) && !empty($IDChat)) {
        $sectorDetail = $cache->get("select id, type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

        /* Check sector */
        if (!empty($sectorDetail) && $func->hasShop($sectorDetail)) {
            /* Sector list */
            $sector = $defineSectors['types'][$sectorDetail['type']];

            /* Tables */
            $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';
            $tableShopChat = (!empty($sector['tables']['shop-chat'])) ? $sector['tables']['shop-chat'] : '';

            if (!empty($tableShopChat)) {
                /* Get data detail */
                $chatDetail = $d->rawQueryOne("select A.*, B.avatar as avatar, B.fullname as fullname, B.address as address, B.phone as phone, B.email as email, S.name as shopName, S.slug_url as shopUrl, P.photo as logo from #_$tableShopChat as A inner join #_member as B inner join #_$tableShop as S left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = ? and P.type = 'logo' where A.id_shop = ? and A.id_member = ? and A.id_parent = 0 and A.id = ? and A.id_member = B.id and A.id_shop = S.id limit 0,1", array($sector['prefix'], $IDShop, $iduser, $IDChat));

                /* Check data detail */
                if (!empty($chatDetail)) {
                    /* Logo for shop */
                    $chatDetail['logo'] = (!empty($chatDetail['logo'])) ? $chatDetail['logo'] : ((!empty($sampleData['logo'])) ? $sampleData['logo'] : array());

                    /* Sample data */
                    $sampleData = $cache->get("select id_interface, logo from #_sample", null, 'result', 7200);

                    if (!empty($sampleData)) {
                        $sampleData['interface'] = array();
                        foreach ($sampleData as $k => $v) {
                            if ($func->isNumber($k)) {
                                $sampleData['interface'][$v['id_interface']] = $v;
                            }
                        }
                    }

                    /* Update status */
                    $d->rawQuery("update #_$tableShopChat set status = replace(status, 'new-member', '') where id_shop = ? and id_member = ? and status = ?", array($IDShop, $iduser, 'new-member'));

                    /* SQL messages */
                    $sqlMessages = "select * from #_$tableShopChat where id_shop = $IDShop and id_member = ? order by date_posted desc";

                    /* SQL num */
                    $sqlMessagesNum = "select count(*) as 'num' from #_$tableShopChat where id_shop = $IDShop and id_member = ? order by date_posted desc";

                    /* For load more ajax */
                    $limitLoad = $config['website']['load-more']['chat'];
                    $limitFrom = (!empty($_GET['limitFrom'])) ? htmlspecialchars($_GET['limitFrom']) : 0;
                    $limitGet = (!empty($_GET['limitGet'])) ? htmlspecialchars($_GET['limitGet']) : $limitLoad['show'];
                    $messages = $d->rawQuery($sqlMessages . " limit " . $limitFrom . "," . $limitGet, array($iduser));
                    $count = $d->rawQueryOne($sqlMessagesNum, array($iduser));
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
                                $params['config_base_shop'] = $configBaseShop;
                                $params['detail'] = $chatDetail;
                                $params['message'] = $v_message;

                                $resultAjax['data'] .= $func->markdown('chat/lists', $params);
                            }
                        }

                        echo json_encode($resultAjax);
                        exit();
                    }
                } else {
                    if ($func->isAjax()) {
                        /* Is ajax */
                        $resultAjax['error'] = true;
                        $resultAjax['message'] = 'Dữ liệu không hợp lệ';
                        echo json_encode($resultAjax);
                        exit();
                    } else {
                        $func->transfer("Dữ liệu không có thực", $configBase, false);
                    }
                }
            }
        } else {
            if ($func->isAjax()) {
                /* Is ajax */
                $resultAjax['error'] = true;
                $resultAjax['message'] = 'Dữ liệu không hợp lệ';
                echo json_encode($resultAjax);
                exit();
            } else {
                /* Redirect */
                $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
            }
        }
    } else {
        if ($func->isAjax()) {
            /* Is ajax */
            $resultAjax['error'] = true;
            $resultAjax['message'] = 'Dữ liệu không hợp lệ';
            echo json_encode($resultAjax);
            exit();
        } else {
            $func->transfer("Trang không tồn tại", $configBase, false);
        }
    }
}

function sortingChatMember($messages)
{
    function compareChat($data1, $data2)
    {
        return $data1['date_posted'] > $data2['date_posted'];
    }

    usort($messages, "compareChat");

    return $messages;
}

function sendChatMember()
{
    global $d, $func, $cache, $defineSectors, $sector, $IDSector, $IDShop, $IDChat, $loginMember, $configBase, $lang, $chatDetail, $messages, $getPage;

    if (empty($_POST['action-chat-user']) || $_POST['action-chat-user'] != 'send-message') {
        $func->transfer("Trang không tồn tại", $configBase, false);
    }

    $iduser = $_SESSION[$loginMember]['id'];
    $IDSector = (!empty($_POST['id_sector'])) ? $_POST['id_sector'] : 0;
    $IDShop = (!empty($_POST['id_shop'])) ? $_POST['id_shop'] : 0;
    $IDChat = (!empty($_POST['id_chat'])) ? $_POST['id_chat'] : 0;

    /* Sector detail */
    if (!empty($IDSector) && !empty($IDShop) && !empty($IDChat)) {
        $sectorDetail = $cache->get("select id, type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

        /* Check sector */
        if (!empty($sectorDetail) && $func->hasShop($sectorDetail)) {
            /* Sector list */
            $sector = $defineSectors['types'][$sectorDetail['type']];

            /* Tables */
            $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';
            $tableShopChat = (!empty($sector['tables']['shop-chat'])) ? $sector['tables']['shop-chat'] : '';

            if (!empty($tableShopChat)) {
                /* Get data detail */
                $chatDetail = $d->rawQueryOne("select A.*, B.avatar as avatar, B.fullname as fullname, B.address as address, B.phone as phone, B.email as email, S.name as shopName, P.photo as logo from #_$tableShopChat as A inner join #_member as B inner join #_$tableShop as S left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = ? and P.type = 'logo' where A.id_shop = ? and A.id_member = ? and A.id_parent = 0 and A.id = ? and A.id_shop = S.id limit 0,1", array($sector['prefix'], $IDShop, $iduser, $IDChat));

                /* Check data detail */
                if (!empty($chatDetail)) {
                    /* Data */
                    $message = '';
                    $response = array();
                    $data = (!empty($_POST['data'])) ? $_POST['data'] : null;

                    /* Check data main */
                    if ($data) {
                        $data['id_shop'] = $IDShop;
                        $data['id_parent'] = $IDChat;
                        $data['id_member'] = $iduser;

                        foreach ($data as $column => $value) {
                            $data[$column] = htmlspecialchars($func->sanitize($value));
                        }

                        $data['poster'] = 'member';
                        $data['status'] = "new-shop";
                        $data['date_posted'] = time();
                    }

                    /* Valid data */
                    if (empty($data['message'])) {
                        $response['messages'][] = 'Nội dung tin nhắn không được trống';
                    }

                    if (!empty($response)) {
                        $response['status'] = 'danger';
                        $message = base64_encode(json_encode($response));
                        $flash->set('message', $message);
                        $func->redirect($configBase . "account/chi-tiet-tro-chuyen?sector=" . $IDSector . "&id_shop=" . $IDShop . "&id_chat=" . $IDChat);
                    }

                    /* Save or insert data by sectors */
                    if ($d->insert($tableShopChat, $data)) {
                        $cache->delete();
                        $func->redirect($configBase . "account/chi-tiet-tro-chuyen?sector=" . $IDSector . "&id_shop=" . $IDShop . "&id_chat=" . $IDChat);
                    } else {
                        $func->transfer("Gửi tin nhắn bị lỗi. Vui lòng thử lại sau", $configBase . "account/chi-tiet-tro-chuyen?sector=" . $IDSector . "&id_shop=" . $IDShop . "&id_chat=" . $IDChat, false);
                    }
                } else {
                    $func->transfer("Dữ liệu không có thực", $configBase, false);
                }
            }
        } else {
            /* Redirect */
            $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
        }
    } else {
        $func->transfer("Trang không tồn tại", $configBase, false);
    }
}

function totalChatMember($sector = array(), $idShop = 0, $id_member = 0)
{
    global $d;

    /* Tables */
    $tableShopChat = (!empty($sector['tables']['shop-chat'])) ? $sector['tables']['shop-chat'] : '';

    $row = $d->rawQueryOne("select count(*) as num from #_$tableShopChat where id_shop = $idShop and id_member = ?", array($id_member));
    return (!empty($row)) ? $row['num'] : 0;
}

/* New */
function newChatMember($sector = array(), $idShop = 0, $id_member = 0)
{
    global $d;

    /* Tables */
    $tableShopChat = (!empty($sector['tables']['shop-chat'])) ? $sector['tables']['shop-chat'] : '';

    $row = $d->rawQueryOne("select count(*) as num from #_$tableShopChat where id_shop = $idShop and id_member = ? and find_in_set('new-member',status)", array($id_member));
    return (!empty($row)) ? $row['num'] : 0;
}

function shopMember()
{
    global $d, $func, $cache, $defineSectors, $sector, $IDSector, $IDStore, $loginMember, $configBase, $lang, $getPage, $shops, $stores, $sampleData, $memberSubscribe, $paging;

    $iduser = $_SESSION[$loginMember]['id'];
    $IDSector = (!empty($_GET['sector'])) ? $_GET['sector'] : 0;
    $IDStore = (!empty($_GET['store'])) ? $_GET['store'] : 0;

    /* Sector detail */
    if (!empty($IDSector)) {
        $sectorDetail = $cache->get("select type, id from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

        /* Check sector */
        if (!empty($sectorDetail) && $func->hasShop($sectorDetail)) {
            /* Sector list */
            $sector = $defineSectors['types'][$sectorDetail['type']];
            $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';
            $tableShopRating = (!empty($sector['tables']['shop-rating'])) ? $sector['tables']['shop-rating'] : '';
            $tableShopSubscribe = (!empty($sector['tables']['shop-subscribe'])) ? $sector['tables']['shop-subscribe'] : '';

            /* Sample data */
            $sampleData = $cache->get("select id_interface, logo from #_sample", null, 'result', 7200);

            if (!empty($sampleData)) {
                $sampleData['interface'] = array();
                foreach ($sampleData as $k => $v) {
                    if ($func->isNumber($k)) {
                        $sampleData['interface'][$v['id_interface']] = $v;
                    }
                }
            }

            /* Member subscribe */
            $memberSubscribe = (!empty($iduser)) ? $cache->get("select id_shop from #_member_subscribe where id_member = ? and sector_prefix = ?", array($iduser, $sector['prefix']), 'result', 7200) : array();
            $memberSubscribe = (!empty($memberSubscribe)) ? explode(",", $func->joinCols($memberSubscribe, 'id_shop')) : array();

            if (!empty($tableShop)) {
                /* Stores by sector */
                $stores = $cache->get("select name$lang, photo, slugvi, slugen, id, id_list from #_store where id_list = ? and find_in_set('hienthi',status) order by numb,id desc", array($sector['id']), 'result', 7200);

                /* Shops */
                $curPage = $getPage;
                $perPage = 30;
                $startpoint = ($curPage * $perPage) - $perPage;
                $whereShop = "A.status != ? and A.status != ? and A.id_member = ?";
                $paramsShop = array($sector['prefix'], 'taman', 'deleted', $iduser);

                /* Where store */
                if (!empty($IDStore)) {
                    $whereShop .= ' and A.id_store = ?';
                    array_push($paramsShop, $IDStore);
                }

                /* SQL shop */
                $sqlShop = "select A.id as id, A.id_interface as interface, A.status as status, A.status_user as status_user, A.date_created as date_created, A.name as name, A.photo as photo, A.slug_url as slug_url, B.name as nameCity, C.name as nameDistrict, D.name as nameWard, R.score as score, R.hit as hit, S.quantity as subscribeNumb, P.photo as logo from #_$tableShop as A inner join #_city as B inner join #_district as C inner join #_wards as D left join #_$tableShopRating as R on A.id = R.id_shop left join #_$tableShopSubscribe as S on A.id = S.id_shop left join #_photo as P on A.id = P.id_shop and P.sector_prefix = ? and P.type = 'logo' where $whereShop and A.id_city = B.id and A.id_district = C.id and A.id_wards = D.id order by A.numb,A.id desc limit $startpoint,$perPage";

                /* SQL num */
                $sqlShopNum = "select count(*) as 'num' from #_$tableShop as A inner join #_city as B inner join #_district as C inner join #_wards as D left join #_$tableShopRating as R on A.id = R.id_shop left join #_$tableShopSubscribe as S on A.id = S.id_shop left join #_photo as P on A.id = P.id_shop and P.sector_prefix = ? and P.type = 'logo' where $whereShop and A.id_city = B.id and A.id_district = C.id and A.id_wards = D.id order by A.numb,A.id desc";

                /* Get data */
                if (!empty($sqlShop)) {
                    $shops = $cache->get($sqlShop, $paramsShop, 'result', 7200);
                    $count = $cache->get($sqlShopNum, $paramsShop, 'fetch', 7200);
                    $total = (!empty($count)) ? $count['num'] : 0;
                    $url = $func->getCurrentPageURL();
                    $paging = $func->pagination($total, $perPage, $curPage, $url);
                }
            } else {
                $func->transfer("Dữ liệu không hợp lệ", $configBase, false);
            }
        } else {
            /* Redirect */
            $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
        }
    }
}

function detailShopMember()
{
    global $d, $func, $cache, $defineSectors, $sector, $IDSector, $loginMember, $configBase, $lang, $shopDetail;

    $iduser = $_SESSION[$loginMember]['id'];
    $IDSector = (!empty($_GET['sector'])) ? $_GET['sector'] : 0;
    $IDShopDetail = (!empty($_GET['id'])) ? $_GET['id'] : 0;

    /* Sector detail */
    if (!empty($IDSector) && !empty($IDShopDetail)) {
        $sectorDetail = $cache->get("select type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

        /* Check sector */
        if (!empty($sectorDetail)) {
            /* Sector list */
            $sector = $defineSectors['types'][$sectorDetail['type']];

            /* Tables */
            $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';

            /* Get detail */
            $shopDetail = $cache->get("select A.id as id, A.name as name, A.photo as photo, A.slug_url as slug_url, A.photo as photo, A.name as name, A.email as email, A.phone as phone, A.password as password, A.status as status, B.name as nameCity, C.name as nameDistrict, D.name as nameWard, E.name$lang as nameInterface, E.photo as photoInterface, F.name$lang as nameStore, G.name$lang as nameSectorCat from #_$tableShop as A, #_city as B, #_district as C, #_wards as D, #_interface as E, #_store as F, #_product_cat as G where A.id_list = ? and A.id = ? and A.id_member = ? and A.id_city = B.id and A.id_district = C.id and A.id_wards = D.id and A.id_interface = E.id and A.id_store = F.id and A.id_cat = G.id limit 0,1", array($sector['id'], $IDShopDetail, $iduser), 'fetch', 7200);

            /* Check exist */
            if (empty($shopDetail)) {
                header('HTTP/1.0 404 Not Found', true, 404);
                include("404.php");
                exit();
            }

            /* Return if posting has 'Vi Pham' */
            if ($shopDetail['status'] == 'vipham') {
                return false;
            }
        } else {
            /* Redirect */
            $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
        }
    } else {
        $func->transfer("Trang không tồn tại", $configBase, false);
    }
}

function updateShopMember()
{
    global $d, $configBase, $func, $loginMember, $flash, $cache, $defineSectors;

    /* Data */
    $iduser = $_SESSION[$loginMember]['id'];
    $IDSector = (!empty($_POST['IDSector'])) ? $_POST['IDSector'] : 0;
    $IDShop = (!empty($_POST['IDShop'])) ? $_POST['IDShop'] : 0;
    $action = (!empty($_POST['action-shop-user'])) ? $_POST['action-shop-user'] : 0;

    /* Check */
    if (empty($_POST) || empty($action) || empty($IDSector) || empty($IDShop)) {
        $func->transfer("Trang không tồn tại", $configBase, false);
    } else {
        $sectorDetail = $cache->get("select type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

        /* Check sector */
        if (!empty($sectorDetail)) {
            /* Sector list */
            $sector = $defineSectors['types'][$sectorDetail['type']];

            /* Tables */
            $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';

            /* Get detail */
            $shopDetail = $d->rawQueryOne("select id from #_$tableShop where id = ? and (status = ? or status = ?) limit 0,1", array($IDShop, 'xetduyet', 'dangsai'));

            if (!empty($shopDetail)) {
                /* Data */
                $message = '';
                $response = array();
                $dataShopMember = (!empty($_POST['dataShopMember'])) ? $_POST['dataShopMember'] : null;

                /* Check data main */
                $dataShopMember['date_updated'] = time();

                /* Valid data */
                if (empty($dataShopMember['password'])) {
                    $response['messages'][] = 'Mật khẩu không được trống';
                }

                if (!empty($response)) {
                    $response['status'] = 'danger';
                    $message = base64_encode(json_encode($response));
                    $flash->set('message', $message);
                    $func->redirect($configBase . "account/chi-tiet-gian-hang?sector=" . $IDSector . "&id=" . $IDShop);
                }

                /* Update data */
                $d->where('id', $IDShop);
                $d->where('id_member', $iduser);
                if ($d->update($sector['tables']['shop'], $dataShopMember)) {
                    /* Delete cache */
                    $cache->delete();

                    /* Avatar */
                    if (!empty($_FILES["file_shop"])) {
                        $photoShop = array();
                        $file_name = $func->uploadName($_FILES["file_shop"]["name"]);
                        if ($file = $func->uploadImage("file_shop", '.jpg|.png|.gif|.JPG|.PNG|.GIF', UPLOAD_SHOP_L, $file_name)) {
                            /* Delete old photo */
                            $row = $d->rawQueryOne("select id, photo from #_" . $sector['tables']['shop'] . " where id = ? limit 0,1", array($IDShop));
                            if (!empty($row['id'])) $func->deleteFile(UPLOAD_SHOP_L . $row['photo']);

                            /* Update new photo */
                            $photoShop['photo'] = $file;
                            $d->where('id', $IDShop);
                            $d->update($sector['tables']['shop'], $photoShop);
                            unset($photoShop);
                        }
                    }

                    /* Check action */
                    if ($action == 'update-shop') {
                        /* Redirect */
                        $func->transfer("Cập nhật gian hàng thành công.", $configBase . "account/chi-tiet-gian-hang?sector=" . $IDSector . "&id=" . $IDShop);
                    } else if ($action == 'fix-shop') {
                        /* Confirm fixed */
                        confirmFixShopMember($sector, $IDShop);
                    }
                }
            } else {
                /* Redirect */
                $func->transfer("Dữ liệu không hợp lệ", $configBase, false);
            }
        } else {
            /* Redirect */
            $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
        }
    }
}

function confirmFixShopMember($sector = array(), $IDShop = 0)
{
    global $d, $func, $emailer, $setting, $configBase, $loginMember;

    if (empty($sector) || empty($IDShop)) {
        $func->transfer("Xác nhận không thành công. Vui lòng thử lại sau", $configBase, false);
    }

    /* Detail shop */
    $detailShop = $d->rawQueryOne("select name, slug_url, id from #_" . $sector['tables']['shop'] . " where id = ? limit 0,1", array($IDShop));

    /* Data send email */
    $dataSend = array();
    $dataSend['variant'] = 'shop';
    $dataSend['shopData'] = $detailShop;
    $dataSend['sectorInfo'] = $sector;

    /* Defaults attributes email */
    $emailDefaultAttrs = $emailer->defaultAttrs();

    /* Variables email */
    $emailVars = array(
        '{emailSectorListName}',
        '{emailShopName}',
        '{emailLinkReport}'
    );
    $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

    /* Values email */
    $emailVals = array(
        $dataSend['sectorInfo']['name'],
        $dataSend['shopData']['name'],
        $configBase . 'admin/index.php?com=report&act=edit_report_shop&id_list=' . $dataSend['sectorInfo']['id'] . '&id_shop=' . $dataSend['shopData']['id']
    );
    $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

    /* Send email */
    $arrayEmail = null;
    $subject = "Thư thông báo từ " . $setting['namevi'];
    $message = str_replace($emailVars, $emailVals, $emailer->markdown('member/confirm-fix-shop'));
    $file = null;

    if ($emailer->send("admin", $arrayEmail, $subject, $message, $file)) {
        $func->transfer("Xác nhận chỉnh sửa thành công. Vui lòng chờ Ban Quản Trị duyệt xác nhận", $configBase . "account/chi-tiet-gian-hang?sector=" . $sector['id'] . "&id=" . $IDShop);
    } else {
        $func->transfer("Xác nhận chỉnh sửa thất bại. Vui lòng thử lại sau", $configBase . "account/chi-tiet-gian-hang?sector=" . $sector['id'] . "&id=" . $IDShop, false);
    }
}

function favouritePostingMember()
{
    global $d, $func, $cache, $defineSectors, $sector, $IDSector, $loginMember, $iduser, $configBase, $lang, $getPage, $products, $favourites, $sampleData, $tableProductVariation, $paging;

    $iduser = $_SESSION[$loginMember]['id'];
    $IDSector = (!empty($_GET['sector'])) ? $_GET['sector'] : 0;

    /* Sector detail */
    if (!empty($IDSector)) {
        $sectorDetail = $cache->get("select type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

        /* Check sector */
        if (!empty($sectorDetail)) {
            /* Sector list */
            $sector = $defineSectors['types'][$sectorDetail['type']];
            $tableProductMain = (!empty($sector['tables']['main'])) ? $sector['tables']['main'] : '';
            $tableProductVariation = (!empty($sector['tables']['variation'])) ? $sector['tables']['variation'] : '';
            $tableProductInfo = (!empty($sector['tables']['info'])) ? $sector['tables']['info'] : '';
            $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';

            if (!empty($tableProductMain)) {
                /* Sample data */
                if (!empty($tableShop)) {
                    $sampleData = $cache->get("select id_interface, logo from #_sample", null, 'result', 7200);

                    if (!empty($sampleData)) {
                        $sampleData['interface'] = array();
                        foreach ($sampleData as $k => $v) {
                            if ($func->isNumber($k)) {
                                $sampleData['interface'][$v['id_interface']] = $v;
                            }
                        }
                    }
                }

                /* Get favourite */
                $favourites = $cache->get("select id_variant from #_member_favourite where id_member = ? and type = ? and variant = ?", array($iduser, $sector['type'], 'product'), "result", 7200);

                /* Check favourite */
                if (!empty($favourites)) {
                    /* Progess favourite */
                    $IDFavourites = (!empty($favourites)) ? $func->joinCols($favourites, 'id_variant') : '';
                    $favourites = (!empty($IDFavourites)) ? explode(",", $IDFavourites) : array();

                    /* Where product */
                    $whereProduct = "A.status = ?";
                    $paramsProduct = array('xetduyet');

                    /* Where logic when owner or shop unactive */
                    $whereLogicOwner = $func->getLogicOwner($tableShop, $sector);
                    $whereProduct .= $whereLogicOwner['where'];

                    /* Where favourite */
                    $whereProduct .= " and A.id in ($IDFavourites)";

                    /* SQL paging */
                    $curPage = $getPage;
                    $perPage = 15;
                    $startpoint = ($curPage * $perPage) - $perPage;

                    /* SQL sector */
                    if (in_array($sector['type'], array($config['website']['sectors']))) {
                        /* Where sector */
                        $whereProduct .= " and A.id_city = C.id and A.id_district = D.id";

                        /* Where logic when shop unactive */
                        $whereProduct .= $func->getLogicShop($tableShop, $whereLogicOwner);

                        /* SQL main */
                        $sqlProduct = "select A.id as id, A.id_shop as id_shop, A.id_member as id_member, A.id_admin as id_admin, A.id_shop as id_shop, A.status as status, A.status_user as status_user, A.name$lang as name$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, C.name as name_city, D.name as name_district, S.id_interface as shopInterface, S.name as shopName, S.slug_url as shopUrl, P.photo as shopLogo, M.avatar as memberAvatar, M.fullname as memberFullname, U.avatar as adminAvatar, U.fullname as adminFullname from #_$tableProductMain as A inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where $whereProduct order by A.date_created desc limit $startpoint,$perPage";

                        /* SQL num */
                        $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where $whereProduct order by A.date_created desc";
                    }

                    /* Get data */
                    if (!empty($sqlProduct)) {
                        $products = $cache->get($sqlProduct, $paramsProduct, 'result', 7200);
                        $count = $cache->get($sqlProductNum, $paramsProduct, 'fetch', 7200);
                        $total = (!empty($count)) ? $count['num'] : 0;
                        $url = $func->getCurrentPageURL();
                        $paging = $func->pagination($total, $perPage, $curPage, $url);
                    }
                }
            } else {
                $func->transfer("Dữ liệu không hợp lệ", $configBase, false);
            }
        } else {
            /* Redirect */
            $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
        }
    }
}

function newPostingMember()
{
    global $d, $idShop, $config, $func, $cache, $defineSectors, $sector, $IDSector, $IDCat, $IDItem, $sectorItems, $loginMember, $iduser, $configBase, $lang, $getPage, $products, $favourites, $ownedShop, $sampleData, $tableProductVariation, $paging;

    $iduser = $_SESSION[$loginMember]['id'];
    $IDSector = (!empty($_GET['sector'])) ? $_GET['sector'] : 0;
    $IDCat = (!empty($_GET['cat'])) ? $_GET['cat'] : 0;
    $IDItem = (!empty($_GET['item'])) ? $_GET['item'] : 0;

    /* Sector detail */
    if (!empty($IDSector)) {
        $sectorDetail = $cache->get("select type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

        /* Check sector */
        if (!empty($sectorDetail)) {
            /* Sector list */
            $sector = $defineSectors['types'][$sectorDetail['type']];
            $tableProductMain = (!empty($sector['tables']['main'])) ? $sector['tables']['main'] : '';
            $tableProductVariation = (!empty($sector['tables']['variation'])) ? $sector['tables']['variation'] : '';
            $tableProductInfo = (!empty($sector['tables']['info'])) ? $sector['tables']['info'] : '';
            $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';

            if (!empty($tableProductMain)) {
                /* Get sector new posting */
                $newPostings = $cache->get("select id_cat from #_member_new_posting where id_member = ? and id_list = ?", array($iduser, $sector['id']), "result", 7200);

                if (!empty($newPostings)) {
                    /* Join ID sector cat */
                    $IDSectorCatNewPosting = (!empty($newPostings)) ? $func->joinCols($newPostings, 'id_cat') : '';

                    /* Get sector item */
                    $sectorItems = $cache->get("select name$lang, photo, photo2, slugvi, slugen, id, id_cat from #_product_item where id_list = ? and id_cat in ($IDSectorCatNewPosting) and find_in_set('hienthi',status) order by numb,id desc", array($sector['id']), 'result', 7200);

                    /* Get ID viewed new posting */
                    $IDViewed = $func->getViewedNewPost($sector['id']);

                    /* Get favourite */
                    $favourites = $cache->get("select id_variant from #_member_favourite where id_member = ? and type = ? and variant = ?", array($iduser, $sector['type'], 'product'), "result", 7200);
                    $IDFavourites = (!empty($favourites)) ? $func->joinCols($favourites, 'id_variant') : '';
                    $favourites = (!empty($IDFavourites)) ? explode(",", $IDFavourites) : array();

                    /* Get owned shop + sample data */
                    if (!empty($tableShop)) {
                        $ownedShop = $cache->get("select id from #_$tableShop where id_member = ?", array($iduser), 'result', 7200);
                        $ownedShop = (!empty($ownedShop)) ? explode(",", $func->joinCols($ownedShop, 'id')) : array();

                        /* Sample data */
                        $sampleData = $cache->get("select id_interface, logo from #_sample", null, 'result', 7200);

                        if (!empty($sampleData)) {
                            $sampleData['interface'] = array();
                            foreach ($sampleData as $k => $v) {
                                if ($func->isNumber($k)) {
                                    $sampleData['interface'][$v['id_interface']] = $v;
                                }
                            }
                        }
                    }

                    /* Where product: Get products posted in some days ago */
                    $daysAgo = $config['website']['dayNewPost'];
                    $daysAgoTimestamp = strtotime(date("d-m-Y", strtotime("-" . $daysAgo . " day")));
                    $whereProduct = "A.status = ? and A.date_created >= ? and A.id_member != ?";
                    $paramsProduct = array('xetduyet', $daysAgoTimestamp, $iduser);

                    /* Where cat: new posting */
                    if (!empty($IDCat)) {
                        $whereProduct .= " and A.id_cat = ?";
                        array_push($paramsProduct, $IDCat);
                    } else {
                        $whereProduct .= " and A.id_cat in ($IDSectorCatNewPosting)";
                    }

                    /* Where item */
                    if (!empty($IDItem)) {
                        $whereProduct .= " and A.id_item = ?";
                        array_push($paramsProduct, $IDItem);
                    }

                    /* Where ID viewed from file */
                    if (!empty($IDViewed)) {
                        $whereProduct .= " and A.id not in ($IDViewed)";
                    }

                    /* Where logic when owner or shop unactive */
                    $whereLogicOwner = $func->getLogicOwner($tableShop, $sector);
                    $whereProduct .= $whereLogicOwner['where'];

                    /* SQL paging */
                    $curPage = $getPage;
                    $perPage = 15;
                    $startpoint = ($curPage * $perPage) - $perPage;

                    /* SQL sector */
                    if (in_array($sector['type'], array($config['website']['sectors']))) {
                        /* Where sector */
                        $whereProduct .= " and A.id_city = C.id and A.id_district = D.id";

                        /* Where logic when shop unactive */
                        $whereProduct .= $func->getLogicShop($tableShop, $whereLogicOwner);

                        /* SQL main */
                        $sqlProduct = "select A.id as id, A.id_shop as id_shop, A.id_member as id_member, A.id_admin as id_admin, A.status as status, A.name$lang as name$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created, C.name as name_city, D.name as name_district, S.id_interface as shopInterface, S.name as shopName, S.slug_url as shopUrl, P.photo as shopLogo, M.avatar as memberAvatar, M.fullname as memberFullname, U.avatar as adminAvatar, U.fullname as adminFullname from #_$tableProductMain as A inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where $whereProduct order by A.date_created desc limit $startpoint,$perPage";

                        /* SQL num */
                        $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A inner join #_city as C inner join #_district as D left join #_$tableShop as S on A.id_shop = S.id left join #_photo as P on A.id_shop = P.id_shop and P.sector_prefix = '" . $sector['prefix'] . "' and P.type = 'logo' left join #_member as M on A.id_member = M.id left join #_user as U on A.id_admin = U.id where $whereProduct order by A.date_created desc";
                    }

                    /* Get data */
                    if (!empty($sqlProduct)) {
                        $products = $cache->get($sqlProduct, $paramsProduct, 'result', 7200);
                        $count = $cache->get($sqlProductNum, $paramsProduct, 'fetch', 7200);
                        $total = (!empty($count)) ? $count['num'] : 0;
                        $url = $func->getCurrentPageURL();
                        $paging = $func->pagination($total, $perPage, $curPage, $url);
                    }
                }
            } else {
                $func->transfer("Dữ liệu không hợp lệ", $configBase, false);
            }
        } else {
            /* Redirect */
            $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
        }
    }
}

function postingMember()
{
    global $d, $idShop, $func, $cache, $defineSectors, $sector, $IDSector, $loginMember, $configBase, $lang, $getPage, $products, $tableProductVariation, $paging;

    $iduser = $_SESSION[$loginMember]['id'];
    $IDSector = (!empty($_GET['sector'])) ? $_GET['sector'] : 0;

    /* Sector detail */
    if (!empty($IDSector)) {
        $sectorDetail = $cache->get("select type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

        /* Check sector */
        if (!empty($sectorDetail)) {
            /* Sector list */
            $sector = $defineSectors['types'][$sectorDetail['type']];
            $tableProductMain = (!empty($sector['tables']['main'])) ? $sector['tables']['main'] : '';
            $tableProductVariation = (!empty($sector['tables']['variation'])) ? $sector['tables']['variation'] : '';
            $tableProductInfo = (!empty($sector['tables']['info'])) ? $sector['tables']['info'] : '';

            if (!empty($tableProductMain)) {
                /* Where product */
                $whereProduct = "A.id_shop = $idShop and A.status != ? and A.id_member = ?";
                $paramsProduct = array('taman', $iduser);

                /* SQL paging */
                $curPage = $getPage;
                $perPage = 28;
                $startpoint = ($curPage * $perPage) - $perPage;

                /* SQL sector */
                if (in_array($sector['type'], array($config['website']['sectors']))) {
                    /* SQL main */
                    $sqlProduct = "select A.id as id, A.status as status, A.status_user as status_user, A.name$lang as name$lang, A.photo as photo, A.slugvi as slugvi, A.slugen as slugen, A.regular_price as regular_price, A.date_created as date_created from #_$tableProductMain as A where $whereProduct order by A.numb,A.id desc limit $startpoint,$perPage";

                    /* SQL num */
                    $sqlProductNum = "select count(*) as 'num' from #_$tableProductMain as A where $whereProduct order by A.numb,A.id desc";
                }

                /* Get data */
                if (!empty($sqlProduct)) {
                    $products = $cache->get($sqlProduct, $paramsProduct, 'result', 7200);
                    $count = $cache->get($sqlProductNum, $paramsProduct, 'fetch', 7200);
                    $total = (!empty($count)) ? $count['num'] : 0;
                    $url = $func->getCurrentPageURL();
                    $paging = $func->pagination($total, $perPage, $curPage, $url);
                }
            } else {
                $func->transfer("Dữ liệu không hợp lệ", $configBase, false);
            }
        } else {
            /* Redirect */
            $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
        }
    }
}

function detailPostingMember()
{
    global $d, $idShop, $func, $cache, $defineSectors, $sector, $IDSector, $loginMember, $configBase, $lang, $productDetail, $tableProductVariation;

    $iduser = $_SESSION[$loginMember]['id'];
    $IDSector = (!empty($_GET['sector'])) ? $_GET['sector'] : 0;
    $IDPostingDetail = (!empty($_GET['id'])) ? $_GET['id'] : 0;

    /* Sector detail */
    if (!empty($IDSector) && !empty($IDPostingDetail)) {
        $sectorDetail = $cache->get("select type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

        /* Check sector */
        if (!empty($sectorDetail)) {
            /* Sector list */
            $sector = $defineSectors['types'][$sectorDetail['type']];

            /* Tables */
            $tableProductMain = (!empty($sector['tables']['main'])) ? $sector['tables']['main'] : '';
            $tableProductContent = (!empty($sector['tables']['content'])) ? $sector['tables']['content'] : '';
            $tableProductInfo = (!empty($sector['tables']['info'])) ? $sector['tables']['info'] : '';
            $tableProductPhoto = (!empty($sector['tables']['photo'])) ? $sector['tables']['photo'] : '';
            $tableProductTag = (!empty($sector['tables']['tag'])) ? $sector['tables']['tag'] : '';
            $tableProductSale = (!empty($sector['tables']['sale'])) ? $sector['tables']['sale'] : '';
            $tableProductVideo = (!empty($sector['tables']['video'])) ? $sector['tables']['video'] : '';
            $tableProductContact = (!empty($sector['tables']['contact'])) ? $sector['tables']['contact'] : '';
            $tableProductVariation = (!empty($sector['tables']['variation'])) ? $sector['tables']['variation'] : '';

            /* Get detail */
            $colsDetailSelect = "id, id_cat, id_item, id_sub, id_city, id_district, id_wards, id_member, id_admin, regular_price, date_created, name$lang, slugvi, slugen, photo, options, status";

            if (in_array($sector['type'], array($config['website']['sectors']))) {
                $colsDetailSelect .= ", status_attr";
            }

            if (in_array("acreage", $sector['attributes'])) {
                $colsDetailSelect .= ", acreage";
            }

            if (in_array("coordinates", $sector['attributes'])) {
                $colsDetailSelect .= ", coordinates";
            }

            $productDetail = $cache->get("select $colsDetailSelect from #_$tableProductMain where id_shop = $idShop and id_list = ? and id_member = ? and id = ? limit 0,1", array($sector['id'], $iduser, $IDPostingDetail), 'fetch', 7200);

            /* Check exist */
            if (empty($productDetail)) {
                header('HTTP/1.0 404 Not Found', true, 404);
                include("404.php");
                exit();
            }

            /* Return if posting has 'Vi Pham' */
            if ($productDetail['status'] == 'vipham') {
                return false;
            }

            /* Sector cat detail */
            $sectorCatDetail = $cache->get("select name$lang from #_product_cat where id = ? and find_in_set('hienthi',status) limit 0,1", array($productDetail['id_cat']), 'fetch', 7200);

            /* Insert data into product Detail */
            $productDetail['sectorCatDetail'] = $sectorCatDetail;

            /* Sector item detail */
            $sectorItemDetail = $cache->get("select name$lang from #_product_item where id = ? and find_in_set('hienthi',status) limit 0,1", array($productDetail['id_item']), 'fetch', 7200);

            /* Insert data into product Detail */
            $productDetail['sectorItemDetail'] = $sectorItemDetail;

            /* Sector sub detail */
            if (in_array($sector['type'], array($config['website']['sectors']))) {
                $func->set('hasSectorSub', true);

                $sectorSubDetail = $cache->get("select name$lang from #_product_sub where id = ? and find_in_set('hienthi',status) limit 0,1", array($productDetail['id_sub']), 'fetch', 7200);

                /* Insert data into product Detail */
                $productDetail['sectorSubDetail'] = $sectorSubDetail;
            }

            /* City */
            $cityDetail = $cache->get("select name from #_city where id = ? and find_in_set('hienthi',status) limit 0,1", array($productDetail['id_city']), 'fetch', 7200);

            /* Insert data into product Detail */
            $productDetail['cityDetail'] = $cityDetail;

            /* District */
            $districtDetail = $cache->get("select name from #_district where id = ? and find_in_set('hienthi',status) limit 0,1", array($productDetail['id_district']), 'fetch', 7200);

            /* Insert data into product Detail */
            $productDetail['districtDetail'] = $districtDetail;

            /* Wards */
            $wardsDetail = $cache->get("select name from #_wards where id = ? and find_in_set('hienthi',status) limit 0,1", array($productDetail['id_wards']), 'fetch', 7200);

            /* Insert data into product Detail */
            $productDetail['wardsDetail'] = $wardsDetail;

            /* Content */
            $rowDetailContent = $cache->get("select content$lang from #_$tableProductContent where id_parent = ? limit 0,1", array($productDetail['id']), 'fetch', 7200);

            /* Insert data into product Detail */
            $productDetail['rowDetailContent'] = $rowDetailContent;

            /* Info */
            if (in_array($sector['type'], array('nha-tuyen-dung'))) {
                $rowDetailInfo = $cache->get("select fullname, application_deadline, age_requirement, trial_period, employee_quantity, gender, address, phone, email, 	introduce from #_$tableProductInfo where id_parent = ? limit 0,1", array($productDetail['id']), 'fetch', 7200);
            } else if (in_array($sector['type'], array('ung-vien'))) {
                $rowDetailInfo = $cache->get("select first_name, last_name, birthday, gender, address, phone, email from #_$tableProductInfo where id_parent = ? limit 0,1", array($productDetail['id']), 'fetch', 7200);
            }

            /* Insert data into product Detail */
            $productDetail['rowDetailInfo'] = (!empty($rowDetailInfo)) ? $rowDetailInfo : array();

            /* Video */
            $rowDetailVideo = $cache->get("select photo, video, name$lang, type from #_$tableProductVideo where id_parent = ? and name$lang != '' and video != ''", array($productDetail['id']), 'fetch', 7200);

            /* Insert data into product Detail */
            $productDetail['rowDetailVideo'] = $rowDetailVideo;

            /* Photo */
            if (in_array($sector['type'], array($config['website']['sectors']))) {
                $rowDetailPhoto = $cache->get("select id, photo, name$lang from #_$tableProductPhoto where id_parent = ?", array($productDetail['id']), 'result', 7200);

                /* Insert data into product Detail */
                $productDetail['rowDetailPhoto'] = $rowDetailPhoto;
            }

            /* Tags */
            $IDTags = $cache->get("select id_tag from #_$tableProductTag where id_parent = ?", array($productDetail['id']), 'result', 7200);

            if (!empty($IDTags)) {
                $IDTags = $func->joinCols($IDTags, 'id_tag');
                $rowDetailTags = $cache->get("select id, name$lang, slugvi, slugen from #_product_tags where id_list = ? and id in ($IDTags) and find_in_set('hienthi',status) order by numb,id desc", array($sector['id']), 'result', 7200);

                /* Insert data into product Detail */
                $productDetail['rowDetailTags'] = $rowDetailTags;
            }

            /* Sale */
            if ($func->hasCart($sector) && !strstr($productDetail['status_attr'], 'dichvu')) {
                $rowDetailSale = $cache->get("select id, id_color, id_size from #_$tableProductSale where id_parent = ?", array($productDetail['id']), 'result', 7200);

                /* Join data */
                $IDColors = (!empty($rowDetailSale)) ? $func->joinCols($rowDetailSale, 'id_color') : '';
                $IDSizes = (!empty($rowDetailSale)) ? $func->joinCols($rowDetailSale, 'id_size') : '';

                /* Get colors */
                if (!empty($IDColors)) {
                    $colors = $cache->get("select id, namevi from #_product_color where id in ($IDColors) and find_in_set('hienthi',status) order by numb,id desc", null, 'result', 7200);
                }

                /* Get sizes */
                if (!empty($IDSizes)) {
                    $sizes = $cache->get("select id, namevi from #_product_size where id_list = ? and id in ($IDSizes) and find_in_set('hienthi',status) order by numb,id desc", array($sector['id']), 'result', 7200);
                }

                /* Insert data into product Detail */
                $productDetail['rowDetailSale']['colors'] = (!empty($colors)) ? $colors : array();
                $productDetail['rowDetailSale']['sizes'] = (!empty($sizes)) ? $sizes : array();
            }

            /* Contact */
            $rowDetailContact = $cache->get("select fullname, phone, address, email from #_$tableProductContact where id_parent = ?", array($productDetail['id']), 'fetch', 7200);

            /* Insert data into product Detail */
            $productDetail['rowDetailContact'] = $rowDetailContact;

            /* Labels detail */
            if (in_array($sector['type'], array($config['website']['sectors']))) {
                $func->set('price-label', 'Giá');
                $func->set('content-label', 'Thông tin mô tả');
                $func->set('content-desc', 'Mô tả chi tiết các thông tin về tin đăng');
                $func->set('photo-label', 'Hình ảnh');
            }
        } else {
            /* Redirect */
            $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
        }
    } else {
        $func->transfer("Trang không tồn tại", $configBase, false);
    }
}

function updatePostingMember()
{
    global $d, $idShop, $configBase, $func, $loginMember, $flash, $cache, $defineSectors;

    /* Data */
    $iduser = $_SESSION[$loginMember]['id'];
    $IDSector = (!empty($_POST['IDSector'])) ? $_POST['IDSector'] : 0;
    $IDPosting = (!empty($_POST['IDPosting'])) ? $_POST['IDPosting'] : 0;
    $action = (!empty($_POST['action-posting-user'])) ? $_POST['action-posting-user'] : 0;

    /* Check */
    if (empty($_POST) || empty($action) || empty($IDSector) || empty($IDPosting)) {
        $func->transfer("Trang không tồn tại", $configBase, false);
    } else {
        $sectorDetail = $cache->get("select type from #_product_list where id = ? and find_in_set('hienthi',status) limit 0,1", array($IDSector), 'fetch', 7200);

        /* Check sector */
        if (!empty($sectorDetail)) {
            /* Sector list */
            $sector = $defineSectors['types'][$sectorDetail['type']];

            /* Tables */
            $tableProductMain = (!empty($sector['tables']['main'])) ? $sector['tables']['main'] : '';

            /* Get detail */
            $productDetail = $d->rawQueryOne("select id from #_$tableProductMain where id_shop = $idShop and id = ? and (status = ? or status = ?) limit 0,1", array($IDPosting, 'xetduyet', 'dangsai'));

            if (!empty($productDetail)) {
                /* Data */
                $message = '';
                $response = array();
                $dataPostingMember = array();
                $dataPostingMemberInfo = (!empty($_POST['dataPostingMemberInfo'])) ? $_POST['dataPostingMemberInfo'] : null;
                $dataPostingMemberContent = (!empty($_POST['dataPostingMemberContent'])) ? $_POST['dataPostingMemberContent'] : null;

                /* Check data main */
                $dataPostingMember['date_updated'] = time();

                /* Check data info */
                if ($dataPostingMemberInfo) {
                    foreach ($dataPostingMemberInfo as $column => $value) {
                        $dataPostingMemberInfo[$column] = htmlspecialchars($func->sanitize($value));
                    }
                }

                /* Check data content */
                if ($dataPostingMemberContent) {
                    foreach ($dataPostingMemberContent as $column => $value) {
                        $dataPostingMemberContent[$column] = htmlspecialchars($func->sanitize($value));
                    }
                }

                /* Valid data */
                if (empty($dataPostingMemberContent['contentvi'])) {
                    $response['messages'][] = 'Nội dung không được trống';
                }

                if (in_array("info-employer", $sector['attributes'])) {
                    if (empty($dataPostingMemberInfo['introduce'])) {
                        $response['messages'][] = 'Giới thiệu không được trống';
                    }
                }

                if (!empty($response)) {
                    $response['status'] = 'danger';
                    $message = base64_encode(json_encode($response));
                    $flash->set('message', $message);
                    $func->redirect($configBase . "account/chi-tiet-tin-dang?sector=" . $IDSector . "&id=" . $IDPosting);
                }

                /* Update data */
                $d->where('id_shop', $idShop);
                $d->where('id', $IDPosting);
                $d->where('id_member', $iduser);
                if ($d->update($sector['tables']['main'], $dataPostingMember)) {
                    /* Info */
                    if ($dataPostingMemberInfo) {
                        $d->where('id_parent', $IDPosting);
                        $d->update($sector['tables']['info'], $dataPostingMemberInfo);
                    }

                    /* Content */
                    $d->where('id_parent', $IDPosting);
                    $d->update($sector['tables']['content'], $dataPostingMemberContent);

                    /* Delete cache */
                    $cache->delete();

                    /* Check action */
                    if ($action == 'update-posting') {
                        /* Redirect */
                        $func->transfer("Cập nhật tin đăng thành công.", $configBase . "account/chi-tiet-tin-dang?sector=" . $IDSector . "&id=" . $IDPosting);
                    } else if ($action == 'fix-posting') {
                        /* Confirm fixed */
                        confirmFixPostingMember($sector, $IDPosting);
                    }
                }
            } else {
                /* Redirect */
                $func->transfer("Dữ liệu không hợp lệ", $configBase, false);
            }
        } else {
            /* Redirect */
            $func->transfer("Lĩnh vực kinh doanh không hợp lệ", $configBase, false);
        }
    }
}

function confirmFixPostingMember($sector = array(), $IDPosting = 0)
{
    global $d, $func, $emailer, $setting, $configBase, $loginMember;

    if (empty($sector) || empty($IDPosting)) {
        $func->transfer("Xác nhận không thành công. Vui lòng thử lại sau", $configBase, false);
    }

    /* Detail posting */
    $detailProduct = $d->rawQueryOne("select namevi, id, id_shop from #_" . $sector['tables']['main'] . " where id = ? limit 0,1", array($IDPosting));

    /* Data send email */
    $dataSend = array();
    $dataSend['variant'] = 'product';
    $dataSend['productData'] = $detailProduct;
    $dataSend['sectorInfo'] = $sector;

    /* Defaults attributes email */
    $emailDefaultAttrs = $emailer->defaultAttrs();

    /* Variables email */
    $emailVars = array(
        '{emailSectorListName}',
        '{emailProductName}',
        '{emailLinkReport}'
    );
    $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

    /* Values email */
    $emailVals = array(
        $dataSend['sectorInfo']['name'],
        $dataSend['productData']['namevi'],
        $configBase . 'admin/index.php?com=report&act=edit_report_posting&id_list=' . $dataSend['sectorInfo']['id'] . '&id_shop=' . $dataSend['productData']['id_shop'] . '&id_product=' . $dataSend['productData']['id']
    );
    $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

    /* Send email */
    $arrayEmail = null;
    $subject = "Thư thông báo từ " . $setting['namevi'];
    $message = str_replace($emailVars, $emailVals, $emailer->markdown('member/confirm-fix-product'));
    $file = null;

    if ($emailer->send("admin", $arrayEmail, $subject, $message, $file)) {
        $func->transfer("Xác nhận chỉnh sửa thành công. Vui lòng chờ Ban Quản Trị duyệt xác nhận", $configBase . "account/chi-tiet-tin-dang?sector=" . $sector['id'] . "&id=" . $IDPosting);
    } else {
        $func->transfer("Xác nhận chỉnh sửa thất bại. Vui lòng thử lại sau", $configBase . "account/chi-tiet-tin-dang?sector=" . $sector['id'] . "&id=" . $IDPosting, false);
    }
}

function cartMember()
{
    global $d, $idShop, $func, $cache, $loginMember, $configBase, $lang, $getPage, $cartMain, $paging, $city, $district, $wards, $minTotal, $maxTotal, $price_from, $price_to, $allNewOrder, $totalNewOrder, $allConfirmOrder, $totalConfirmOrder, $allDeliveriedOrder, $totalDeliveriedOrder, $allCanceledOrder, $totalCanceledOrder;

    $iduser = $_SESSION[$loginMember]['id'];

    /* Where cart */
    $whereCart = "A.id_member = ? and A.id_order = O.id and A.id_order = B.id_order and A.order_status = S.id and O.order_payment = N.id";
    $paramsCart = array($iduser);

    /* Where filter */
    $order_status = (!empty($_REQUEST['order_status'])) ? htmlspecialchars($_REQUEST['order_status']) : 0;
    $order_payment = (!empty($_REQUEST['order_payment'])) ? htmlspecialchars($_REQUEST['order_payment']) : 0;
    $order_date = (!empty($_REQUEST['order_date'])) ? htmlspecialchars($_REQUEST['order_date']) : 0;
    $order_range_price = (!empty($_REQUEST['order_range_price'])) ? htmlspecialchars($_REQUEST['order_range_price']) : 0;
    $order_city = (!empty($_REQUEST['order_city'])) ? htmlspecialchars($_REQUEST['order_city']) : 0;
    $order_district = (!empty($_REQUEST['order_district'])) ? htmlspecialchars($_REQUEST['order_district']) : 0;
    $order_wards = (!empty($_REQUEST['order_wards'])) ? htmlspecialchars($_REQUEST['order_wards']) : 0;

    if ($order_status) $whereCart .= " and A.order_status=$order_status";
    if ($order_payment) $whereCart .= " and O.order_payment=$order_payment";
    if ($order_date) {
        $order_date = explode("-", $order_date);
        $date_from = trim($order_date[0] . ' 12:00:00 AM');
        $date_to = trim($order_date[1] . ' 11:59:59 PM');
        $date_from = strtotime(str_replace("/", "-", $date_from));
        $date_to = strtotime(str_replace("/", "-", $date_to));
        $whereCart .= " and A.date_created<=$date_to and A.date_created>=$date_from";
    }
    if ($order_range_price) {
        $order_range_price = explode(":", $order_range_price);
        $price_from = trim($order_range_price[0]);
        $price_to = trim($order_range_price[1]);
        $whereCart .= " and A.total_price<=$price_to and A.total_price>=$price_from";
    }
    if ($order_city) $whereCart .= " and B.id_city=$order_city";
    if ($order_district) $whereCart .= " and B.id_district=$order_district";
    if ($order_wards) $whereCart .= " and B.id_wards=$order_wards";

    /* SQL paging */
    $curPage = $getPage;
    $perPage = 15;
    $startpoint = ($curPage * $perPage) - $perPage;

    /* SQL main */
    $sqlCart = "select A.id as id, A.total_price as total_price, A.date_created as date_created, O.code as code, B.fullname as fullname, S.name$lang as statusName, S.class_order as statusClass, N.name$lang as paymentName from #_order_group as A, #_order as O, #_order_info as B, #_order_status as S, #_news as N where $whereCart order by A.date_created desc limit $startpoint,$perPage";

    /* SQL num */
    $sqlCartNum = "select count(*) as 'num' from #_order_group as A, #_order as O, #_order_info as B, #_order_status as S, #_news as N where $whereCart order by A.date_created desc";

    /* Get data */
    if (!empty($sqlCart)) {
        $cartMain = $cache->get($sqlCart, $paramsCart, 'result', 7200);
        $count = $cache->get($sqlCartNum, $paramsCart, 'fetch', 7200);
        $total = (!empty($count)) ? $count['num'] : 0;
        $url = $func->getCurrentPageURL();
        $paging = $func->pagination($total, $perPage, $curPage, $url);

        /* Lấy tổng giá min */
        $minTotal = $d->rawQueryOne("select min(total_price) from #_order_group where id_member = $iduser");
        if ($minTotal['min(total_price)']) $minTotal = $minTotal['min(total_price)'];
        else $minTotal = 0;

        /* Lấy tổng giá max */
        $maxTotal = $d->rawQueryOne("select max(total_price) from #_order_group where id_member = $iduser");
        if ($maxTotal['max(total_price)']) $maxTotal = $maxTotal['max(total_price)'];
        else $maxTotal = 0;

        /* Lấy đơn hàng - mới đặt */
        $order_count = $d->rawQueryOne("select count(id), sum(total_price) from #_order_group where id_member = $iduser and order_status = 1");
        $allNewOrder = $order_count['count(id)'];
        $totalNewOrder = $order_count['sum(total_price)'];

        /* Lấy đơn hàng - đã xác nhận */
        $order_count = $d->rawQueryOne("select count(id), sum(total_price) from #_order_group where id_member = $iduser and order_status = 2");
        $allConfirmOrder = $order_count['count(id)'];
        $totalConfirmOrder = $order_count['sum(total_price)'];

        /* Lấy đơn hàng - đã giao */
        $order_count = $d->rawQueryOne("select count(id), sum(total_price) from #_order_group where id_member = $iduser and order_status = 4");
        $allDeliveriedOrder = $order_count['count(id)'];
        $totalDeliveriedOrder = $order_count['sum(total_price)'];

        /* Lấy đơn hàng - đã hủy */
        $order_count = $d->rawQueryOne("select count(id), sum(total_price) from #_order_group where id_member = $iduser and order_status = 5");
        $allCanceledOrder = $order_count['count(id)'];
        $totalCanceledOrder = $order_count['sum(total_price)'];

        /* City */
        $city = $cache->get("select name, id from #_city where find_in_set('hienthi',status) order by numb,id asc", null, 'result', 7200);

        /* District */
        if ($order_city) {
            $district = $cache->get("select name, id from #_district where id_city = ? and find_in_set('hienthi',status) order by numb,id asc", array($order_city), 'result', 7200);
        }

        /* Wards */
        if ($order_city && $order_district) {
            $wards = $cache->get("select name, id from #_wards where id_city = ? and id_district = ? and find_in_set('hienthi',status) order by numb,id asc", array($order_city, $order_district), 'result', 7200);
        }
    }
}

function detailCartMember()
{
    global $d, $idShop, $func, $cache, $loginMember, $configBase, $lang, $orderGroupDetail, $orderDetail;

    $iduser = $_SESSION[$loginMember]['id'];
    $IDOrderGroupDetail = (!empty($_GET['id'])) ? $_GET['id'] : 0;

    if (!empty($IDOrderGroupDetail)) {
        /* Order detail */
        $orderGroupDetail = $cache->get("select A.id as id, A.id_order as id_order, A.total_price as total_price, A.notes as notes, A.order_status as order_status, A.date_created as date_created, A.date_updated as date_updated, O.code as code, N.name$lang as paymentName, B.fullname as fullname, B.phone as phone, B.email as email, B.address as address from #_order_group as A, #_order as O, #_order_info as B, #_news as N where A.id_order = O.id and A.id_order = B.id_order and O.order_payment = N.id and A.id = ? limit 0,1", array($IDOrderGroupDetail), 'fetch', 7200);

        /* Check order */
        if (!empty($orderGroupDetail)) {
            /* Get order detail */
            if (!empty($orderGroupDetail)) {
                $orderDetail = $cache->get("select * from #_order_detail where id_order = ? and id_group = ?", array($orderGroupDetail['id_order'], $IDOrderGroupDetail), 'result', 7200);
            }
        } else {
            /* Redirect */
            $func->transfer("Đơn hàng không tồn tại", $configBase, false);
        }
    } else {
        $func->transfer("Trang không tồn tại", $configBase, false);
    }
}

function updateCartMember()
{
    global $d, $idShop, $configBase, $func, $loginMember, $cache;

    /* Data */
    $iduser = $_SESSION[$loginMember]['id'];
    $IDOrderGroup = (!empty($_POST['IDOrderGroup'])) ? $_POST['IDOrderGroup'] : 0;
    $dataOrderGroupMember = (!empty($_POST['data'])) ? $_POST['data'] : null;

    /* Check */
    if (empty($_POST) || empty($IDOrderGroup)) {
        $func->transfer("Trang không tồn tại", $configBase, false);
    } else {
        $orderGroupDetail = $cache->get("select id from #_order_group where id = ? limit 0,1", array($IDOrderGroup), 'fetch', 7200);

        /* Check order */
        if (!empty($orderGroupDetail)) {
            /* Data */
            foreach ($dataOrderGroupMember as $column => $value) {
                $dataOrderGroupMember[$column] = htmlspecialchars($func->sanitize($value));
            }

            $dataOrderGroupMember['date_updated'] = time();

            /* Update data */
            $d->where('id', $IDOrderGroup);
            if ($d->update('order_group', $dataOrderGroupMember)) {
                /* Check order status for order main */
                $func->updateOrderMainStatus($IDOrderGroup);

                /* Delete cache */
                $cache->delete();

                /* Redirect */
                $func->transfer("Cập nhật đơn hàng thành công.", $configBase . "account/chi-tiet-dat-hang?id=" . $IDOrderGroup);
            } else {
                /* Redirect */
                $func->transfer("Cập nhật đơn hàng thất bại. Vui lòng thử lại sau", $configBase . "account/chi-tiet-dat-hang?id=" . $IDOrderGroup, false);
            }
        } else {
            /* Redirect */
            $func->transfer("Đơn hàng không tồn tại", $configBase, false);
        }
    }
}

function orderMember()
{
    global $d, $idShop, $func, $cache, $loginMember, $configBase, $lang, $getPage, $orderMain, $paging;

    $iduser = $_SESSION[$loginMember]['id'];

    /* Where order */
    $whereOrder = "A.id_user = ? and A.id = B.id_order and A.order_status = C.id";
    $paramsOrder = array($iduser);

    /* SQL paging */
    $curPage = $getPage;
    $perPage = 15;
    $startpoint = ($curPage * $perPage) - $perPage;

    /* SQL main */
    $sqlOrder = "select A.id as id, A.code as code, A.total_price as total_price, A.date_created as date_created, B.id_region as id_region, B.id_city as id_city, B.id_district as id_district, B.id_wards as id_wards, B.fullname as fullname, B.phone as phone, B.email as email, B.address as address, C.namevi as statusName, C.class_order as statusClass, D.name as detailFirst, (select count(id) from #_order_detail D_SUB where D_SUB.id_order = A.id) as detailLists from #_order as A inner join #_order_info as B inner join #_order_status as C left join #_order_detail as D on D.id = (select id from #_order_detail as LJ_D where A.id = LJ_D.id_order group by LJ_D.id_order order by LJ_D.id asc limit 0,1) where $whereOrder order by A.date_created limit $startpoint,$perPage";

    /* SQL num */
    $sqlOrderNum = "select count(*) as 'num' from #_order as A inner join #_order_info as B inner join #_order_status as C left join #_order_detail as D on D.id = (select id from #_order_detail as LJ_D where A.id = LJ_D.id_order group by LJ_D.id_order order by LJ_D.id asc limit 0,1) where $whereOrder order by A.date_created desc";

    /* Get data */
    if (!empty($sqlOrder)) {
        $orderMain = $cache->get($sqlOrder, $paramsOrder, 'result', 7200);
        $count = $cache->get($sqlOrderNum, $paramsOrder, 'fetch', 7200);
        $total = (!empty($count)) ? $count['num'] : 0;
        $url = $func->getCurrentPageURL();
        $paging = $func->pagination($total, $perPage, $curPage, $url);
    }
}

function detailOrderMember()
{
    global $d, $idShop, $func, $cache, $loginMember, $configBase, $lang, $orderDetail, $orderGroup;

    $iduser = $_SESSION[$loginMember]['id'];
    $IDOrderDetail = (!empty($_GET['id'])) ? $_GET['id'] : 0;

    if (!empty($IDOrderDetail)) {
        /* Order detail */
        $orderDetail = $cache->get("select A.*, B.fullname as fullname, B.phone as phone, B.email as email, B.address as address from #_order as A, #_order_info as B where A.id = B.id_order and A.id = ? limit 0,1", array($IDOrderDetail), 'fetch', 7200);

        /* Check order */
        if (!empty($orderDetail)) {
            /* Get order group */
            $orderGroup = $cache->get("select A.*, B.namevi as statusName, B.class_order as statusClass from #_order_group as A, #_order_status as B where A.order_status = B.id and A.id_order = ?", array($IDOrderDetail), 'result', 7200);

            /* Get order detail and order group info */
            if (!empty($orderGroup)) {
                foreach ($orderGroup as $k_orderGroup => $v_orderGroup) {
                    /* Get order group info */
                    $groupInfo = array();
                    if (!empty($v_orderGroup['id_shop'])) {
                        $groupInfo = $cache->get("select id, name as name, slug_url from #_shop_" . $v_orderGroup['sector_prefix'] . " where id = ?", array($v_orderGroup['id_shop']), 'fetch', 7200);
                    } else if (!empty($v_orderGroup['id_member'])) {
                        $groupInfo = $cache->get("select id, fullname as name, phone from #_member where id = ?", array($v_orderGroup['id_member']), 'fetch', 7200);
                    }

                    $orderGroup[$k_orderGroup]['infos'] = $groupInfo;

                    /* Get order detail */
                    $orderGroup[$k_orderGroup]['detail-lists'] = $cache->get("select * from #_order_detail where id_order = ? and id_group = ?", array($IDOrderDetail, $v_orderGroup['id']), 'result', 7200);
                }
            }
        } else {
            /* Redirect */
            $func->transfer("Đơn hàng không tồn tại", $configBase, false);
        }
    } else {
        $func->transfer("Trang không tồn tại", $configBase, false);
    }
}

function updateOrderMember()
{
    global $d, $idShop, $configBase, $func, $loginMember, $flash, $cache;

    /* Data */
    $iduser = $_SESSION[$loginMember]['id'];
    $IDOrder = (!empty($_POST['IDOrder'])) ? $_POST['IDOrder'] : 0;
    $action = (!empty($_POST['actionOrder'])) ? $_POST['actionOrder'] : 0;

    /* Check */
    if (empty($_POST) || empty($action) || empty($IDOrder)) {
        $func->transfer("Trang không tồn tại", $configBase, false);
    } else {
        $orderDetail = $cache->get("select id, order_status from #_order where id = ? limit 0,1", array($IDOrder), 'fetch', 7200);

        /* Check order */
        if (!empty($orderDetail)) {
            /* Data */
            $message = '';
            $response = array();
            $dataOrderMember = array();

            /* Check data main */
            $dataOrderMember['order_status'] = 5;
            $dataOrderMember['date_updated'] = time();

            /* Valid data */
            if ($orderDetail['order_status'] == 6) {
                $response['messages'][] = 'Không thể hủy khi đơn hàng đang trong quá trình giao dịch';
            } else if ($orderDetail['order_status'] == 5) {
                $response['messages'][] = 'Đơn hàng đã bị hủy';
            }

            if (!empty($response)) {
                $response['status'] = 'danger';
                $message = base64_encode(json_encode($response));
                $flash->set('message', $message);
                $func->redirect($configBase . "account/chi-tiet-don-hang?id=" . $IDOrder);
            }

            /* Update data */
            $d->where('id', $IDOrder);
            $d->where('id_user', $iduser);
            if ($d->update('order', $dataOrderMember)) {
                /* update status for order Group */
                $dataOrderGroupMember = array();
                $dataOrderGroupMember['order_status'] = 5;
                $d->where('id_order', $IDOrder);
                $d->update('order_group', $dataOrderGroupMember);

                /* Delete cache */
                $cache->delete();

                /* Redirect */
                $func->transfer("Hủy đơn hàng thành công.", $configBase . "account/chi-tiet-don-hang?id=" . $IDOrder);
            } else {
                /* Redirect */
                $func->transfer("Hủy đơn hàng thất bại. Vui lòng thử lại sau", $configBase . "account/chi-tiet-don-hang?id=" . $IDOrder, false);
            }
        } else {
            /* Redirect */
            $func->transfer("Đơn hàng không tồn tại", $configBase, false);
        }
    }
}

function changePasswordMember()
{
    global $d, $func, $flash, $city, $district, $wards, $detailMember, $configBase, $loginMember;

    $iduser = $_SESSION[$loginMember]['id'];

    if ($iduser && !empty($_POST['change-password-user'])) {
        $detailMember = $d->rawQueryOne("select id_city, id_district, id_wards, first_name, last_name, fullname, avatar, username, gender, birthday, phone, email, address from #_member where id = ? limit 0,1", array($iduser));
        $old_password = (!empty($_POST['old-password'])) ? $_POST['old-password'] : '';
        $old_passwordMD5 = md5($old_password);
        $new_password = (!empty($_POST['new-password'])) ? $_POST['new-password'] : '';
        $new_passwordMD5 = md5($new_password);
        $new_password_confirm = (!empty($_POST['new-password-confirm'])) ? $_POST['new-password-confirm'] : '';

        if (empty($old_password)) {
            $response['messages'][] = 'Mật khẩu cũ không được trống';
        } else {
            $row = $d->rawQueryOne("select id from #_member where id = ? and password = ? limit 0,1", array($iduser, $old_passwordMD5));
        }

        if (!empty($old_password) && empty($row['id'])) {
            $response['messages'][] = 'Mật khẩu cũ không chính xác';
        } else if (!empty($old_password) && empty($new_password)) {
            $response['messages'][] = 'Mật khẩu mới không được trống';
        } else if (!empty($new_password) && !$func->isPassword($new_password)) {
            $response['messages'][] = 'Mật khẩu ít nhất 8 ký tự';
            $response['messages'][] = 'Mật khẩu ít nhất 1 chữ thường';
            $response['messages'][] = 'Mật khẩu ít nhất 1 chữ hoa';
            $response['messages'][] = 'Mật khẩu ít nhất 1 chữ số';
            $response['messages'][] = 'Mật khẩu ít nhất 1 ký tự: !, @, #, &, $, *';
        } else if (!empty($new_password) && empty($new_password_confirm)) {
            $response['messages'][] = 'Xác nhận mật khẩu mới không được trống';
        } else if ($new_password != $new_password_confirm) {
            $response['messages'][] = 'Mật khẩu mới và xác nhận mật khẩu mới không chính xác';
        }

        if (!empty($response)) {
            $response['status'] = 'danger';
            $message = base64_encode(json_encode($response));
            $flash->set('message', $message);
            $func->redirect($configBase . "account/doi-mat-khau");
        }

        $data['password'] = $new_passwordMD5;

        $d->where('id', $iduser);
        if ($d->update('member', $data)) {
            unset($_SESSION[$loginMember]);
            setcookie('login_member_id', "", -1, '/');
            setcookie('login_member_session', "", -1, '/');
            $func->transfer("Thay đổi mật khẩu thành công", $configBase . "account/dang-nhap");
        } else {
            $func->transfer("Thay đổi mật khẩu thất bại", $configBase . "account/doi-mat-khau", false);
        }
    }
}

function infoMember()
{
    global $d, $func, $flash, $city, $district, $wards, $detailMember, $configBase, $loginMember;

    $iduser = $_SESSION[$loginMember]['id'];

    if ($iduser) {
        $detailMember = $d->rawQueryOne("select id_city, id_district, id_wards, first_name, last_name, fullname, avatar, username, gender, birthday, phone, email, address from #_member where id = ? limit 0,1", array($iduser));

        /* Get place */
        $city = $d->rawQuery("select name, id from #_city where find_in_set('hienthi',status) order by numb,id asc");
        $district = (!empty($detailMember['id_city'])) ? $d->rawQuery("select name, id from #_district where id_city = ? and find_in_set('hienthi',status) order by numb,id asc", array($detailMember['id_city'])) : array();
        $wards = (!empty($detailMember['id_city']) && !empty($detailMember['id_district'])) ? $d->rawQuery("select name, id from #_wards where id_city = ? and id_district = ? and find_in_set('hienthi',status) order by numb,id asc", array($detailMember['id_city'], $detailMember['id_district'])) : array();

        if (!empty($_POST['info-user'])) {
            $message = '';
            $response = array();
            $codeCaptcha = $_POST['captcha-info-account'];
            $sessionCaptcha = (!empty($_SESSION["captcha"]["info-account"])) ? $_SESSION["captcha"]["info-account"] : null;
            $first_name = (!empty($_POST['first_name'])) ? htmlspecialchars($_POST['first_name']) : '';
            $last_name = (!empty($_POST['last_name'])) ? htmlspecialchars($_POST['last_name']) : '';
            $id_city = (!empty($_POST['city'])) ? htmlspecialchars($_POST['city']) : 0;
            $cityInfo = (!empty($id_city)) ? $func->getInfoDetail('id_region', 'city', $id_city) : array();
            $id_region = (!empty($cityInfo)) ? $cityInfo['id_region'] : 0;
            $id_district = (!empty($_POST['district'])) ? htmlspecialchars($_POST['district']) : 0;
            $id_wards = (!empty($_POST['wards'])) ? htmlspecialchars($_POST['wards']) : 0;
            $address = (!empty($_POST['address'])) ? htmlspecialchars($_POST['address']) : '';
            $gender = (!empty($_POST['gender'])) ? htmlspecialchars($_POST['gender']) : 0;
            $phone = (!empty($_POST['phone'])) ? htmlspecialchars($_POST['phone']) : '';
            $birthday = (!empty($_POST['birthday'])) ? htmlspecialchars($_POST['birthday']) : '';

            /* Valid data */
            if (empty($first_name) || empty($last_name)) {
                $response['messages'][] = 'Họ tên không được trống';
            }

            if (empty($gender)) {
                $response['messages'][] = 'Chưa chọn giới tính';
            }

            if (empty($birthday)) {
                $response['messages'][] = 'Ngày sinh không được trống';
            }

            if (!empty($birthday) && !$func->isDate($birthday)) {
                $response['messages'][] = 'Ngày sinh không hợp lệ';
            }

            if (empty($address)) {
                $response['messages'][] = 'Địa chỉ không được trống';
            }

            if (empty($id_city)) {
                $response['messages'][] = 'Chưa chọn tỉnh/thành phố';
            }

            if (empty($id_district)) {
                $response['messages'][] = 'Chưa chọn quận/huyện';
            }

            if (empty($id_wards)) {
                $response['messages'][] = 'Chưa chọn phường/xã';
            }

            if (empty($phone)) {
                $response['messages'][] = 'Số điện thoại không được trống';
            }

            if (!empty($phone) && !$func->isPhone($phone)) {
                $response['messages'][] = 'Số điện thoại không hợp lệ';
            }

            if (empty($codeCaptcha)) {
                $response['messages'][] = 'Mã bảo mật không được trống';
            }

            if (!empty($codeCaptcha) && !empty($sessionCaptcha) && $codeCaptcha != $sessionCaptcha) {
                $response['messages'][] = 'Mã bảo mật không chính xác';
            }

            if (!empty($response)) {
                /* Destroy session captcha */
                unset($_SESSION["captcha"]["info-account"]);

                /* Flash data */
                $flash->set('first_name', $first_name);
                $flash->set('last_name', $last_name);
                $flash->set('gender', $gender);
                $flash->set('address', $address);
                $flash->set('birthday', $birthday);
                $flash->set('email', $email);
                $flash->set('phone', $phone);

                /* Errors */
                $response['status'] = 'danger';
                $message = base64_encode(json_encode($response));
                $flash->set('message', $message);
                $func->redirect($configBase . "account/thong-tin");
            }

            /* Save data */
            $data['id_region'] = $id_region;
            $data['id_city'] = $id_city;
            $data['id_district'] = $id_district;
            $data['id_wards'] = $id_wards;
            $data['first_name'] = $first_name;
            $data['last_name'] = $last_name;
            $data['fullname'] = trim($first_name) . ' ' . trim($last_name);
            $data['address'] = $address;
            $data['gender'] = $gender;
            $data['phone'] = $phone;
            $data['birthday'] = strtotime(str_replace("/", "-", $birthday));

            $d->where('id', $iduser);
            if ($d->update('member', $data)) {
                /* Photo */
                if ($func->hasFile("file_avatar")) {
                    $photoUpdate = array();
                    $file_name = $func->uploadName($_FILES["file_avatar"]["name"]);

                    if ($avatar = $func->uploadImage("file_avatar", '.jpg|.png|.JPG|.PNG', UPLOAD_USER_L, $file_name)) {
                        $row = $d->rawQueryOne("select id, avatar from #_member where id = ? limit 0,1", array($iduser));

                        if (!empty($row)) {
                            $func->deleteFile(UPLOAD_USER_L . $row['avatar']);
                        }

                        $photoUpdate['avatar'] = $avatar;
                        $d->where('id', $iduser);
                        $d->update('member', $photoUpdate);
                        unset($photoUpdate);
                    }
                }

                /* Destroy session captcha */
                unset($_SESSION["captcha"]["info-account"]);

                $func->transfer("Cập nhật thông tin thành công", $configBase . "account/thong-tin");
            } else {
                /* Destroy session captcha */
                unset($_SESSION["captcha"]["info-account"]);

                $func->transfer("Cập nhật thông tin thất bại", $configBase . "account/thong-tin", false);
            }
        }
    } else {
        $func->transfer("Trang không tồn tại", $configBase, false);
    }
}

function checkActivationMember()
{
    global $d, $func, $flash, $detailMember, $configBase;

    $id = (!empty($_GET['id'])) ? htmlspecialchars($_GET['id']) : 0;

    if (!empty($_POST['activation-user'])) {
        /* Data */
        $message = '';
        $response = array();
        $confirm_code = (!empty($_POST['confirm_code'])) ? htmlspecialchars($_POST['confirm_code']) : '';

        /* Valid data */
        if (empty($id)) {
            $response['messages'][] = 'Người dùng không tồn tại';
        } else {
            $detailMember = $d->rawQueryOne("select status, confirm_code, id from #_member where id = ? limit 0,1", array($id));

            if (empty($detailMember)) {
                $response['messages'][] = 'Tài khoản của bạn không tồn tại';
            } else if (!empty($detailMember['status']) && strstr($detailMember['status'], 'hienthi')) {
                $func->transfer("Trang không tồn tại", $configBase, false);
            } else {
                if (empty($confirm_code)) {
                    $response['messages'][] = 'Mã xác nhận không được trống';
                }

                if (!empty($confirm_code) && ($detailMember['confirm_code'] != $confirm_code)) {
                    $response['messages'][] = 'Mã xác nhận không đúng. Vui lòng nhập lại mã xác nhận.';
                }
            }
        }

        if (!empty($response)) {
            $response['status'] = 'danger';
            $message = base64_encode(json_encode($response));
            $flash->set("message", $message);
            $func->redirect($configBase . "account/kich-hoat?id=" . $id);
        }

        /* Save data */
        $data['status'] = 'hienthi';
        $data['confirm_code'] = '';
        $d->where('id', $id);
        if ($d->update('member', $data)) {
            $func->transfer("Kích hoạt tài khoản thành công.", $configBase . "account/dang-nhap");
        }
    } else {
        /* Valid data */
        if (empty($id)) {
            $func->transfer("Trang không tồn tại", $configBase, false);
        } else {
            $detailMember = $d->rawQueryOne("select status, confirm_code, id from #_member where id = ? limit 0,1", array($id));

            if (empty($detailMember) || (!empty($detailMember['status']) && strstr($detailMember['status'], 'hienthi'))) {
                $func->transfer("Trang không tồn tại", $configBase, false);
            }
        }
    }
}

function loginMember()
{
    global $d, $func, $restApi, $flash, $loginMember, $configBase, $apiRoutes;

    /* Data */
    $message = '';
    $response = array();
    $back = $func->backUrl();
    $isRemember = (!empty($_POST['isRemember'])) ? true : false;

    /* Payload */
    $payload = [
        'username' => (!empty($_POST['username'])) ? htmlspecialchars($_POST['username']) : '',
        'password' => (!empty($_POST['password'])) ? $_POST['password'] : ''
    ];

    /* Validate data */
    $apiResp = $restApi->post($apiRoutes['storefront']['member']['login'], $payload);
    $apiResp = $restApi->decode($apiResp, true);

    if (!empty($apiResp) && !empty($apiResp['errors'])) {
        foreach ($apiResp['errors'] as $v) {
            $response['messages'][] = $v;
        }
    }

    if (!empty($response)) {
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set("message", $message);
        $func->redirect($configBase . "account/dang-nhap" . $back['redirect']);
    }
        // var_dump($response);
        // die();

    if (!empty($apiResp) && $apiResp['status'] == 200) {
        /* Create session login */
        $_SESSION[$loginMember]['active'] = true;
        $_SESSION[$loginMember]['id'] = $apiResp['data']['id'];
        $_SESSION[$loginMember]['avatar'] = $apiResp['data']['avatar'];
        $_SESSION[$loginMember]['username'] = $apiResp['data']['username'];
        $_SESSION[$loginMember]['address'] = $apiResp['data']['address'];
        $_SESSION[$loginMember]['email'] = $apiResp['data']['email'];
        $_SESSION[$loginMember]['phone'] = $apiResp['data']['phone'];
        $_SESSION[$loginMember]['first_name'] = $apiResp['data']['first_name'];
        $_SESSION[$loginMember]['last_name'] = $apiResp['data']['last_name'];
        $_SESSION[$loginMember]['fullname'] = $apiResp['data']['fullname'];
        $_SESSION[$loginMember]['login_session'] = $apiResp['data']['login_session'];

        // $detailMember = $d->rawQueryOne("select id_city, id_district, id_wards, first_name, last_name, fullname, avatar, username, gender, birthday, phone, email, address from #_member where id = ? limit 0,1", array($apiResp['data']['id']));

        // $data['id_region'] = $id_region;
        // $data['id_city'] = $id_city;
        // $data['id_district'] = $id_district;
        // $data['id_wards'] = $id_wards;
        // $data['first_name'] = $apiResp['data']['first_name'];
        // $data['last_name'] = $apiResp['data']['last_name'];
        // $data['fullname'] = $apiResp['data']['fullname'];
        // $data['username'] = $apiResp['data']['username'];
        // $data['email'] = $apiResp['data']['email'];
        // $data['address'] = $address;
        // $data['gender'] = $gender;
        // $data['birthday'] = strtotime(str_replace("/", "-", $birthday));
        // $data['confirm_code'] = $confirm_code;
        // $data['status'] = $apiResp['data']['fullname'];



        /* Create cookie login */
        setcookie('cookieLoginMemberId', '', 0, '', '', false, true);
        setcookie('cookieLoginMemberSession', '', 0, '', '', false, true);
        if ($isRemember) {
            $time_expiry = time() + 3600 * 24;
            setcookie('cookieLoginMemberId', $apiResp['data']['id'], $time_expiry, '/', '', false, true);
            setcookie('cookieLoginMemberSession', $apiResp['data']['login_session'], $time_expiry, '/', '', false, true);
        }
        $func->redirect((!empty($back['transfer'])) ? $back['transfer'] : $configBase);
    }
}

function signupMember()
{
    global $d, $restApi, $city, $func, $flash, $configBase, $apiRoutes;

    $city = $d->rawQuery("select name, id from #_city where find_in_set('hienthi',status) order by numb,id asc");

    if (!empty($_POST['registration-user'])) {
        /* Data */
        $message = '';
        $response = array();
        $codeCaptcha = $_POST['captcha-registration-account'];
        $sessionCaptcha = (!empty($_SESSION["captcha"]["registration-account"])) ? $_SESSION["captcha"]["registration-account"] : null;

        /* Payload */
        $payload = [
            'file_avatar' => $func->curlFile('file_avatar'),
            'username' => (!empty($_POST['username'])) ? htmlspecialchars($_POST['username']) : '',
            'password' => (!empty($_POST['password'])) ? $_POST['password'] : '',
            'repassword' => (!empty($_POST['repassword'])) ? $_POST['repassword'] : '',
            'first_name' => (!empty($_POST['first_name'])) ? htmlspecialchars($_POST['first_name']) : '',
            'last_name' => (!empty($_POST['last_name'])) ? htmlspecialchars($_POST['last_name']) : '',
            'city' => (!empty($_POST['city'])) ? htmlspecialchars($_POST['city']) : 0,
            'district' => (!empty($_POST['district'])) ? htmlspecialchars($_POST['district']) : 0,
            'wards' => (!empty($_POST['wards'])) ? htmlspecialchars($_POST['wards']) : 0,
            'email' => (!empty($_POST['email'])) ? htmlspecialchars($_POST['email']) : '',
            'address' => (!empty($_POST['address'])) ? htmlspecialchars($_POST['address']) : '',
            'gender' => (!empty($_POST['gender'])) ? htmlspecialchars($_POST['gender']) : 0,
            'birthday' => (!empty($_POST['birthday'])) ? htmlspecialchars($_POST['birthday']) : '',
            'rules' => (!empty($_POST['rules'])) ? htmlspecialchars($_POST['rules']) : ''
        ];

        /* Validate data */
        if (empty($codeCaptcha)) {
            $response['messages'][] = 'Mã bảo mật không được trống';
        } else if (!empty($sessionCaptcha) && $codeCaptcha != $sessionCaptcha) {
            $response['messages'][] = 'Mã bảo mật không chính xác';
        } else {
            $apiResp = $restApi->post($apiRoutes['storefront']['member']['register'], $payload);
            $apiResp = $restApi->decode($apiResp, true);

            if (!empty($apiResp) && !empty($apiResp['errors'])) {
                foreach ($apiResp['errors'] as $v) {
                    $response['messages'][] = $v;
                }
            }
        }

        if (!empty($response)) {
            /* Destroy session captcha */
            unset($_SESSION["captcha"]["registration-account"]);

            /* Flash data */
            $flash->set('first_name', $payload['first_name']);
            $flash->set('last_name', $payload['last_name']);
            $flash->set('username', $payload['username']);
            $flash->set('gender', $payload['gender']);
            $flash->set('birthday', $payload['birthday']);
            $flash->set('email', $payload['email']);

            /* Errors */
            $response['status'] = 'danger';
            $message = base64_encode(json_encode($response));
            $flash->set('message', $message);
            $func->redirect($configBase . "account/dang-ky");
        }

        /* Save data */
        if (!empty($apiResp) && $apiResp['status'] == 200) {
            sendActivation($payload['username']);

            /* Destroy session captcha */
            unset($_SESSION["captcha"]["registration-account"]);

            $func->transfer("Đăng ký thành viên thành công. Vui lòng kiểm tra email: " . $payload['email'] . " để kích hoạt tài khoản", $configBase . "account/dang-nhap");
        } else {
            /* Destroy session captcha */
            unset($_SESSION["captcha"]["registration-account"]);

            $func->transfer("Đăng ký thành viên thất bại. Vui lòng thử lại sau.", $configBase, false);
        }
    }
}

function sendActivation($username)
{
    global $d, $setting, $emailer, $func, $configBase, $lang;

    /* Lấy thông tin người dùng */
    $row = $d->rawQueryOne("select id, confirm_code, username, password, fullname, email, address from #_member where username = ? limit 0,1", array($username));

    /* Gán giá trị gửi email */
    $iduser = $row['id'];
    $confirm_code = $row['confirm_code'];
    $tendangnhap = $row['username'];
    $matkhau = $row['password'];
    $tennguoidung = $row['fullname'];
    $emailnguoidung = $row['email'];
    $diachinguoidung = $row['address'];
    $linkkichhoat = $configBase . "account/kich-hoat?id=" . $iduser;

    /* Defaults attributes email */
    $emailDefaultAttrs = $emailer->defaultAttrs();

    /* Variables email */
    $emailVars = array(
        '{emailMemberUsername}',
        '{emailMemberPassword}',
        '{emailMemberConfirmCode}',
        '{emailMemberFullname}',
        '{emailMemberEmail}',
        '{emailMemberAddress}',
        '{emailLinkActivation}'
    );
    $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

    /* Values email */
    $emailVals = array(
        $tendangnhap,
        substr($matkhau, -3),
        $confirm_code,
        $tennguoidung,
        $emailnguoidung,
        $diachinguoidung,
        $linkkichhoat
    );
    $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

    /* Send email admin */
    $arrayEmail = array(
        "dataEmail" => array(
            "name" => $row['username'],
            "email" => $row['email']
        )
    );
    $subject = "Thư kích hoạt tài khoản thành viên từ " . $setting['name' . $lang];
    $message = str_replace($emailVars, $emailVals, $emailer->markdown('member/activation'));
    $file = '';

    if (!$emailer->send("customer", $arrayEmail, $subject, $message, $file)) {
        $func->transfer("Có lỗi xảy ra trong quá trình kích hoạt tài khoản. Vui lòng liên hệ với chúng tôi.", $configBase . "lien-he", false);
    }
}

function forgotPasswordMember()
{
    global $d, $setting, $emailer, $func, $flash, $loginMember, $configBase, $lang;

    /* Data */
    $message = '';
    $response = array();
    $username = (!empty($_POST['username'])) ? htmlspecialchars($_POST['username']) : '';
    $email = (!empty($_POST['email'])) ? htmlspecialchars($_POST['email']) : '';
    $newpass = substr(md5(rand(0, 999) * time()), 15, 6);
    $newpassMD5 = md5($newpass);

    /* Valid data */
    if (empty($username)) {
        $response['messages'][] = 'Tài khoản không được trống';
    }

    if (!empty($username) && !$func->isPhone($username)) {
        $response['messages'][] = 'Tài khoản không hợp lệ';
    }

    if (empty($email)) {
        $response['messages'][] = 'Email không được trống';
    }

    if (!empty($email) && !$func->isEmail($email)) {
        $response['messages'][] = 'Email không hợp lệ';
    }

    if (!empty($username) && !empty($email)) {
        $row = $d->rawQueryOne("select id from #_member where username = ? and email = ? limit 0,1", array($username, $email));

        if (empty($row)) {
            $response['messages'][] = 'Tên đăng nhập hoặc/và email không tồn tại';
        }
    }

    if (!empty($response)) {
        $response['status'] = 'danger';
        $message = base64_encode(json_encode($response));
        $flash->set('message', $message);
        $func->redirect($configBase . "account/quen-mat-khau");
    }

    /* Cập nhật mật khẩu mới */
    $data['password'] = $newpassMD5;
    $d->where('username', $username);
    $d->where('email', $email);
    $d->update('member', $data);

    /* Lấy thông tin người dùng */
    $row = $d->rawQueryOne("select id, username, password, fullname, phone, email, address from #_member where username = ? limit 0,1", array($username));

    /* Gán giá trị gửi email */
    $iduser = $row['id'];
    $tendangnhap = $row['username'];
    $matkhau = $row['password'];
    $tennguoidung = $row['fullname'];
    $emailnguoidung = $row['email'];
    $dienthoainguoidung = $row['phone'];
    $diachinguoidung = $row['address'];

    /* Defaults attributes email */
    $emailDefaultAttrs = $emailer->defaultAttrs();

    /* Variables email */
    $emailVars = array(
        '{emailMemberUsername}',
        '{emailMemberPhone}',
        '{emailMemberFullname}',
        '{emailMemberEmail}',
        '{emailMemberAddress}',
        '{emailMemberPhone}',
        '{emailMemberNewPassword}'
    );
    $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

    /* Values email */
    $emailVals = array(
        $tendangnhap,
        $dienthoainguoidung,
        $tennguoidung,
        $emailnguoidung,
        $diachinguoidung,
        $dienthoainguoidung,
        $newpass
    );
    $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

    /* Send email admin */
    $arrayEmail = array(
        "dataEmail" => array(
            "name" => $tennguoidung,
            "email" => $email
        )
    );
    $subject = "Thư cấp lại mật khẩu từ " . $setting['name' . $lang];
    $message = str_replace($emailVars, $emailVals, $emailer->markdown('member/forgot-password'));
    $file = '';

    if ($emailer->send("customer", $arrayEmail, $subject, $message, $file)) {
        unset($_SESSION[$loginMember]);
        setcookie('login_member_id', "", -1, '/');
        setcookie('login_member_session', "", -1, '/');
        $func->transfer("Cấp lại mật khẩu thành công. Vui lòng kiểm tra email: " . $email, $configBase);
    } else {
        $func->transfer("Có lỗi xảy ra trong quá trình cấp lại mật khẩu. Vui lòng liện hệ với chúng tôi.", $configBase . "account/quen-mat-khau", false);
    }
}

function logoutMember()
{
    global $d, $func, $loginMember, $configBase;

    unset($_SESSION[$loginMember]);

    setcookie('cookieLoginMemberId', "", -1, '/');
    setcookie('cookieLoginMemberSession', "", -1, '/');

    $func->redirect($configBase);
}
