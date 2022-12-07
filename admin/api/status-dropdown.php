<?php
include "config.php";

$result = 0;
$table = (!empty($_POST['table'])) ? htmlspecialchars($_POST['table']) : '';
$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$attr = (!empty($_POST['attr'])) ? htmlspecialchars($_POST['attr']) : '';

if ($id && $attr) {
    $status_detail = $d->rawQueryOne("select status from #_$table where id = $id limit 0,1");

    if (!empty($status_detail)) {
        $data = array();
        $data['status'] = $attr;
        $d->where('id', $id);
        if ($d->update($table, $data)) {
            $result = 1;
            $cache->delete();
        }
    }
}

echo $result;
