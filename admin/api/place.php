<?php
include "config.php";

if (!empty($_POST["id"])) {
    $level = (!empty($_POST["level"])) ? htmlspecialchars($_POST["level"]) : 0;
    $table = (!empty($_POST["table"])) ? htmlspecialchars($_POST["table"]) : '';
    $id = (!empty($_POST["id"])) ? htmlspecialchars($_POST["id"]) : 0;
    $row = null;
    $where = '';
    $isGroup = $func->getGroup('active');
    $idcityByGroup = $func->getGroup('citys');

    switch ($level) {
        case '0':
            $id_temp = "id_region";
            if ($isGroup) $where = ' and id in (' . $idcityByGroup . ')';
            break;

        case '1':
            $id_temp = "id_city";
            break;

        case '2':
            $id_temp = "id_district";
            break;

        default:
            echo 'error ajax';
            exit();
            break;
    }

    if ($id) {
        $row = $d->rawQuery("select name, id from $table where $id_temp = ? $where order by id asc", array($id));
    }

    $str = '<option value="">Chọn danh mục</option>';
    if (!empty($row)) {
        foreach ($row as $v) {
            $str .= '<option value=' . $v["id"] . '>' . $v["name"] . '</option>';
        }
    }
} else {
    $str = '<option value="">Chọn danh mục</option>';
}

echo $str;
