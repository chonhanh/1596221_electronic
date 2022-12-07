<?php
include "config.php";

if (!empty($_POST["id_list"]) && !empty($_POST["id_cat"])) {
    $id_list = (!empty($_POST["id_list"])) ? htmlspecialchars($_POST["id_list"]) : 0;
    $id_cat = (!empty($_POST["id_cat"])) ? htmlspecialchars($_POST["id_cat"]) : 0;
    $row = null;

    $row = $cache->get("select namevi, id from #_store where id > 0 and id_list = ? and id_cat = ? order by numb,id desc", array($id_list, $id_cat), 'result', 7200);

    $str = '<option value="">Chọn cửa hàng</option>';
    if (!empty($row)) {
        foreach ($row as $v) {
            $str .= '<option value=' . $v["id"] . '>' . $v["namevi"] . '</option>';
        }
    }
} else {
    $str = '<option value="">Chọn cửa hàng</option>';
}

echo $str;
