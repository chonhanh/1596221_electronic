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
}

echo $result;
