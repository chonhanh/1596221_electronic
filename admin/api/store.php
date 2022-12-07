<?php
include "config.php";

if (!empty($_POST["id_list"])) {
    $id_list = (!empty($_POST["id_list"])) ? htmlspecialchars($_POST["id_list"]) : 0;
    $id_cat = (!empty($_POST["id_cat"])) ? htmlspecialchars($_POST["id_cat"]) : 0;
    $params = array($id_list);
    $where = '';
    $row = null;

    if (!empty($id_cat)) {
        $where .= ' and id_cat = ?';
        array_push($params, $id_cat);
    }

    $row = $d->rawQuery("select namevi, id from #_store where id > 0 and id_list = ? $where order by numb,id desc", $params);

    $str = '<option value="">Chọn danh mục</option>';
    if (!empty($row)) {
        foreach ($row as $v) {
            $str .= '<option value=' . $v["id"] . '>' . $v["namevi"] . '</option>';
        }
    }
    echo $str;
}
