<?php
include "config.php";

$result = 0;
$table = (!empty($_POST['table'])) ? htmlspecialchars($_POST['table']) : '';
$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$attr = (!empty($_POST['attr'])) ? htmlspecialchars($_POST['attr']) : '';
$col = (!empty($_POST['col'])) ? htmlspecialchars($_POST['col']) : 'status';

if ($id) {
    $status_detail = $d->rawQueryOne("select $col from #_$table where id = $id limit 0,1");
    $status_array = (!empty($status_detail[$col])) ? explode(',', $status_detail[$col]) : array();

    if (array_search($attr, $status_array) !== false) {
        $key = array_search($attr, $status_array);
        unset($status_array[$key]);
    } else {
        array_push($status_array, $attr);
    }

    $data = array();
    $data[$col] = (!empty($status_array)) ? implode(',', $status_array) : "";
    $d->where('id', $id);
    if ($d->update($table, $data)) {
        $result = 1;
        $cache->delete();
    }

    /* Write json */
    if (in_array($table, ['product_list', 'product_cat', 'product_item'])) {
        /* Data json */
        $dataJson = array('type' => str_replace('product_', '', $table));
        $func->writeJson($dataJson);
    } else if ($table == 'region') {
        $dataJson = array('type' => 'region');
        $func->writeJson($dataJson);
    } else if ($table == 'city') {
        $dataJson = array('type' => 'city');
        $func->writeJson($dataJson);
    } else if ($table == 'district') {
        /* Data json */
        $detail = $func->getInfoDetail('id_city', 'district', $id);
        $dataJson = array('type' => 'district', 'idCity' => $detail['id_city']);
        $func->writeJson($dataJson);
    } else if ($table == 'wards') {
        $detail = $func->getInfoDetail('id_city, id_district', 'wards', $id);
        $dataJson = array('type' => 'wards', 'idCity' => $detail['id_city'], 'idDistrict' => $detail['id_district']);
        $func->writeJson($dataJson);
    }
}

echo $result;
