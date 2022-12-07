<?php
include "config.php";

$cmd = (!empty($_POST['cmd'])) ? htmlspecialchars($_POST['cmd']) : '';
$text = (!empty($_POST['text'])) ? htmlspecialchars($_POST['text']) : '';
$type = (!empty($_POST['type'])) ? htmlspecialchars($_POST['type']) : '';
$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$isLogin = $func->getMember('active');
$idMember = $func->getMember('id');

if (!empty($cmd)) {
    if ($cmd == 'check-shop' && !empty($text) && !empty($type)) {
        if ($type == 'name') {
            $data = array();
            $data['slug'] = $func->changeTitle($text);
            $data['slug_url'] = str_replace("-", "", $data['slug']);
            echo $func->checkShop($data, 'name');
        } else if ($type == 'restricted') {
            $data = array();
            $data['slug'] = $func->changeTitle($text);
            $data['slug_url'] = str_replace("-", "", $data['slug']);
            echo $func->checkShop($data, 'restricted', $id);
        } else if ($type == 'username') {
            $data = array();
            $data['username'] = trim($text);
            echo $func->checkShop($data, 'username');
        } else if ($type == 'email') {
            $data = array();
            $data['email'] = trim($text);
            echo $func->checkShop($data, 'email');
        }
    } else if ($cmd == 'delete-shop' && !empty($isLogin) && !empty($type) && !empty($id)) {
        /* Data */
        $data = array();
        $result = array();

        /* Sector */
        $sector = $defineSectors['types'][$type];

        /* Get data detail */
        $row = $d->rawQueryOne("select id, status from #_" . $sector['tables']['shop'] . " where id = ? and id_list = ? and id_member = ? limit 0,1", array($id, $sector['id'], $idMember));

        /* Check data detail */
        if (!empty($row['id'])) {
            $data['status'] = 'deleted';

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

        echo json_encode($result);
    }
}
