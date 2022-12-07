<?php
include "config.php";

$idList = (!empty($_POST['idList'])) ? htmlspecialchars($_POST['idList']) : 0;
$limitFrom = (!empty($_POST['limitFrom'])) ? htmlspecialchars($_POST['limitFrom']) : 0;
$limitGet = (!empty($_POST['limitGet'])) ? htmlspecialchars($_POST['limitGet']) : 0;
$result = array();
$result['html'] = '';
$result['all'] = 0;

if (!empty($idList) && in_array($idList, $defineSectors['sectors']['IDs']) && !empty($limitFrom) && !empty($limitGet)) {
    $sector = $defineSectors['types'][$defineSectors['IDs'][$idList]];
    $catsAll = $cache->get("select count(id) as total from #_product_cat where id_list = ? and find_in_set('hienthi',status)", array($idList), 'fetch', 7200);
    $cats = $cache->get("select name$lang, name_store$lang, slugvi, slugen, id, photo, photo2 from #_product_cat where id_list = ? and find_in_set('hienthi',status) order by numb,id desc limit $limitFrom, $limitGet", array($idList), 'result', 7200);

    if (!empty($cats)) {
        $result['all'] = $catsAll['total'];

        foreach ($cats as $k => $v) {
            $v['name-main'] = $v['name' . $lang];
            $v['href-main'] = $sector['type'] . '?cat=' . $v['id'];
            $v['name-store'] = $v['name_store' . $lang];
            $v['href-store'] = "nhom-cua-hang/" . $v[$sluglang] . "/" . $v['id'] . "?sector=" . $sector['id'];

            $result['html'] .= '<div class="col-3 p-0">' . $func->getGroupCat($v) . '</div>';
        }
    }
} else {
    $result['error'] = true;
}

echo json_encode($result);
