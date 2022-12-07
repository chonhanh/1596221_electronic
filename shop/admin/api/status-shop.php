<?php
include "config.php";

$result = 0;
$table = (!empty($_POST['table'])) ? htmlspecialchars($_POST['table']) : '';
$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$attr = (!empty($_POST['attr'])) ? htmlspecialchars($_POST['attr']) : '';

if ($id) {
    $status_detail = $d->rawQueryOne("select id, status from #_$table where id_parent = $id and id_shop = $idShop and sector_prefix = ? limit 0,1", array($prefixSector));

    if (!empty($status_detail)) {
        $status_array = (!empty($status_detail['status'])) ? explode(',', $status_detail['status']) : array();

        if (array_search($attr, $status_array) !== false) {
            $key = array_search($attr, $status_array);
            unset($status_array[$key]);
        } else {
            array_push($status_array, $attr);
        }

        $data = array();
        $data['status'] = (!empty($status_array)) ? implode(',', $status_array) : "";
        $d->where('id', $status_detail['id']);

        if ($d->update($table, $data)) {
            $result = 1;
            $cache->delete();
        }
    } else {
        $dataStatusShop = array();
        $dataStatusShop['id_parent'] = $id;
        $dataStatusShop['id_shop'] = $idShop;
        $dataStatusShop['sector_prefix'] = $prefixSector;
        $dataStatusShop['status'] = $attr;
        $d->insert($table, $dataStatusShop);
        $cache->delete();
    }
}

echo $result;
