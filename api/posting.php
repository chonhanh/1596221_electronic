<?php
include "config.php";

$type = (!empty($_POST['type'])) ? htmlspecialchars($_POST['type']) : '';
$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$isLogin = $func->getMember('active');
$idMember = $func->getMember('id');
$result = array();

if (!empty($isLogin) && !empty($type) && !empty($id) && !empty($defineSectors['types'][$type])) {
    /* Sector */
    $sector = $defineSectors['types'][$type];

    /* Get data detail */
    $row = $d->rawQueryOne("select id, photo from #_" . $sector['tables']['main'] . " where id_shop = $idShop and id = ? and id_list = ? and id_member = ? limit 0,1", array($id, $sector['id'], $idMember));

    /* Check data detail */
    if (!empty($row['id'])) {
        /* Delete action */
        $func->deleteProduct($row, $sector, UPLOAD_PRODUCT);

        /* Delete cache */
        $cache->delete();

        /* Run Maintain database */
        $d->runMaintain();

        $result['success'] = true;
    } else {
        $result['failed'] = true;
    }
} else {
    $result['failed'] = true;
}

echo json_encode($result);
