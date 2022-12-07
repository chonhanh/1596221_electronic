<?php
include "config.php";

$cmd = (!empty($_POST['cmd'])) ? htmlspecialchars($_POST['cmd']) : '';
$sector = (!empty($_POST['sector'])) ? $_POST['sector'] : array();
$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$isLogin = $func->getMember('active');
$idMember = $func->getMember('id');
$result = array();

if (!empty($isLogin)) {
    if ($cmd == 'shop-status') {
        $statusUser = $d->rawQueryOne("select id, status_user from #_" . $sector['tables']['shop'] . " where id_member = ? and id = ? and status = ? limit 0,1", array($idMember, $id, 'xetduyet'));

        if (!empty($statusUser['id'])) {
            $data = array();

            if ($statusUser['status_user'] == 'hienthi') {
                $data['status_user'] = 'taman';
                $result['status'] = 'warning';
                $result['message'] = 'Đã tạm ẩn';
            } else if (empty($statusUser['status_user']) || $statusUser['status_user'] == 'taman') {
                $data['status_user'] = 'hienthi';
                $result['status'] = 'success';
                $result['message'] = 'Đã hiển thị';
            }

            if (!empty($data)) {
                $d->where('id', $id);

                if ($d->update($sector['tables']['shop'], $data)) {
                    /* Delete cache */
                    $cache->delete();

                    /* Update success */
                    $result['success'] = true;
                } else {
                    $result['failed'] = true;
                }
            } else {
                $result['failed'] = true;
            }
        } else {
            $result['failed'] = true;
        }
    } else if ($cmd == 'posting-status') {
        $statusUser = $d->rawQueryOne("select id, status_user from #_" . $sector['tables']['main'] . " where id_shop = $idShop and id_member = ? and id = ? and status = ? limit 0,1", array($idMember, $id, 'xetduyet'));

        if (!empty($statusUser['id'])) {
            $data = array();

            if ($statusUser['status_user'] == 'hienthi') {
                $data['status_user'] = 'taman';
                $result['status'] = 'warning';
                $result['message'] = 'Đã tạm ẩn';
            } else if (empty($statusUser['status_user']) || $statusUser['status_user'] == 'taman') {
                $data['status_user'] = 'hienthi';
                $result['status'] = 'success';
                $result['message'] = 'Đã hiển thị';
            }

            if (!empty($data)) {
                $d->where('id_shop', $idShop);
                $d->where('id', $id);

                if ($d->update($sector['tables']['main'], $data)) {
                    /* Delete cache */
                    $cache->delete();

                    /* Update success */
                    $result['success'] = true;
                } else {
                    $result['failed'] = true;
                }
            } else {
                $result['failed'] = true;
            }
        } else {
            $result['failed'] = true;
        }
    }
} else {
    $result['failed'] = true;
}

echo json_encode($result);
