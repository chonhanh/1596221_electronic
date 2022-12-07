<?php
include "config.php";

$idCat = (!empty($_POST["idCat"])) ? htmlspecialchars($_POST["idCat"]) : 0;

if (!empty($idCat)) {
    $rowCat = $cache->get("select label_posting_sub$lang from #_product_cat where id = ?", array($idCat), 'fetch', 7200);
    $func->set('sector-label-posting-sub', (!empty($rowCat['label_posting_sub' . $lang])) ? $rowCat['label_posting_sub' . $lang] : 'Chọn danh mục');
}

if (!empty($_POST["id"])) {
    $level = (!empty($_POST["level"])) ? htmlspecialchars($_POST["level"]) : 0;
    $table = (!empty($_POST["table"])) ? htmlspecialchars($_POST["table"]) : '';
    $id = (!empty($_POST["id"])) ? htmlspecialchars($_POST["id"]) : 0;
    $params = array();
    $where = '';
    $row = null;

    switch ($level) {
        case '0':
            $id_temp = "id_list";
            break;

        case '1':
            $id_temp = "id_cat";
            break;

        case '2':
            $id_temp = "id_item";
            break;

        default:
            echo 'error ajax';
            exit();
            break;
    }

    if (!empty($id)) {
        $where .= ' and ' . $id_temp . ' = ?';
        array_push($params, $id);
        $row = $cache->get("select name$lang, id from $table where id > 0 $where order by numb,id desc", $params, 'result', 7200);
    }

    $str = '<option value="">' . $func->get('sector-label-posting-sub') . '</option>';
    if (!empty($row)) {
        foreach ($row as $v) {
            $str .= '<option value=' . $v["id"] . '>' . $v["name" . $lang] . '</option>';
        }
    }
} else {
    $str = '<option value="">' . $func->get('sector-label-posting-sub') . '</option>';
}

echo $str;
