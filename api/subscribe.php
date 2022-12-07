<?php
include "config.php";

$isLogin = $func->getMember('active');
$idMember = $func->getMember('id');
$sector = (!empty($_POST['sector'])) ? $_POST['sector'] : array();
$idShop = (!empty($_POST['idShop'])) ? htmlspecialchars($_POST['idShop']) : 0;
$result = $subscribe = array();

if (!empty($isLogin)) {
    $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';
    $tableShopSubscribe = (!empty($sector['tables']['shop-subscribe'])) ? $sector['tables']['shop-subscribe'] : '';

    $shopInfo = $d->rawQueryOne("select id_member from #_$tableShop where id = ? limit 0,1", array($idShop));

    if (empty($shopInfo) || $idMember == $shopInfo['id_member']) {
        $result['status'] = 'error';
        $result['message'] = 'Dữ liệu không hợp lệ';
    } else {
        $subscribeMember = $d->rawQueryOne("select id from #_member_subscribe where id_member = ? and id_shop = ? and sector_prefix = ? limit 0,1", array($idMember, $idShop, $sector['prefix']));
        $subscribeDetail = $d->rawQueryOne("select id, quantity from #_$tableShopSubscribe where id_shop = ? limit 0,1", array($idShop));

        if (empty($subscribeMember)) {
            /* Insert member subscribe */
            $data = array();
            $data['id_member'] = $idMember;
            $data['id_shop'] = $idShop;
            $data['sector_prefix'] = $sector['prefix'];

            if ($d->insert("member_subscribe", $data)) {
                /* Update subscribe */
                $data = array();

                if (!empty($subscribeDetail)) {
                    $data['quantity'] = $subscribeDetail['quantity'] + 1;

                    $d->where('id_shop', $idShop);

                    if ($d->update($tableShopSubscribe, $data)) {
                        /* Delete cache */
                        $cache->delete();

                        $result['status'] = 'success';
                        $result['message'] = 'Đã quan tâm trang';
                        $result['isSubscribe'] = true;
                    } else {
                        $result['status'] = 'error';
                        $result['message'] = 'Quan tâm trang thất bại. Vui lòng thử lại sau';
                    }
                } else {
                    $data['quantity'] = 1;
                    $data['id_shop'] = $idShop;

                    if ($d->insert($tableShopSubscribe, $data)) {
                        /* Delete cache */
                        $cache->delete();

                        $result['status'] = 'success';
                        $result['message'] = 'Đã quan tâm trang';
                        $result['isSubscribe'] = true;
                    } else {
                        $result['status'] = 'error';
                        $result['message'] = 'Quan tâm trang thất bại. Vui lòng thử lại sau';
                    }
                }
            } else {
                $result['status'] = 'error';
                $result['message'] = 'Quan tâm trang thất bại. Vui lòng thử lại sau';
            }
        } else {
            /* Delete member subscribe */
            $d->rawQuery("delete from #_member_subscribe where id_member = ? and id_shop = ? and sector_prefix = ?", array($idMember, $idShop, $sector['prefix']));

            /* Update subscribe */
            $data = array();
            $data['quantity'] = (!empty($subscribeDetail) && $subscribeDetail['quantity'] >= 0) ? $subscribeDetail['quantity'] - 1 : 0;

            $d->where('id_shop', $idShop);

            if ($d->update($tableShopSubscribe, $data)) {
                /* Delete cache */
                $cache->delete();

                $result['status'] = 'warning';
                $result['message'] = 'Đã bỏ quan tâm trang';
                $result['isSubscribe'] = false;
            } else {
                $result['status'] = 'error';
                $result['message'] = 'Bỏ quan tâm trang thất bại. Vui lòng thử lại sau';
            }
        }

        /* Get quantity subscribe shop */
        $shopDetail = $d->rawQueryOne("select S.quantity as subscribeNumb from #_$tableShop as A left join #_$tableShopSubscribe as S on A.id = S.id_shop where A.id = ? limit 0,1", array($idShop));
        $result['subscribeActive'] = (!empty($result['isSubscribe'])) ? true : false;
        $result['subscribeNumb'] = (!empty($shopDetail)) ? $func->shortNumber($shopDetail['subscribeNumb']) : 0;
    }
} else {
    $result['status'] = 'error';
    $result['message'] = 'Vui lòng đăng nhập để quan tâm trang';
}

echo json_encode($result);
