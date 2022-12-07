<?php
include "config.php";

$cmd = (!empty($_POST['cmd'])) ? htmlspecialchars($_POST['cmd']) : '';
$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$table = (!empty($_POST['table'])) ? htmlspecialchars($_POST['table']) : '';

if (!empty($cmd)) {
    if ($cmd == 'send-info') {
        /* Get shop info */
        $result = false;
        $postingDetail = $cache->get("select A.id as id, A.id_shop as id_shop, A.id_list as id_list, A.id_member as id_member, A.id_admin as id_admin, A.slugvi as slugvi, A.namevi as namevi, B.namevi as nameSectorList, B.slugvi as slugSectorList from #_$table as A, #_product_list as B where A.id_list = B.id and A.id = ? and A.status = ? limit 0,1", array($id, 'xetduyet'), 'fetch', 7200);

        if (!empty($postingDetail)) {
            /* Get owner info */
            if (!empty($postingDetail['id_shop'])) {
                $detailSector = $func->getInfoDetail('type', 'product_list', $postingDetail['id_list']);
                $sector = $defineSectors['types'][$detailSector['type']];
                $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';

                $shopDetail = $cache->get("select id_member, id_admin, name from #_$tableShop where id = ? limit 0,1", array($postingDetail['id_shop']), 'fetch', 7200);

                if (!empty($shopDetail['id_member'])) {
                    $ownerPosting = $cache->get("select fullname, email from #_member where id = ? and find_in_set('hienthi',status) limit 0,1", array($shopDetail['id_member']), 'fetch', 7200);
                } else {
                    $ownerPosting = $cache->get("select fullname, email from #_user where id = ? and find_in_set('hienthi',status) limit 0,1", array($shopDetail['id_admin']), 'fetch', 7200);
                }
            } else {
                if (!empty($postingDetail['id_member'])) {
                    $ownerPosting = $cache->get("select fullname, email from #_member where id = ? and find_in_set('hienthi',status) limit 0,1", array($postingDetail['id_member']), 'fetch', 7200);
                } else {
                    $ownerPosting = $cache->get("select fullname, email from #_user where id = ? and find_in_set('hienthi',status) limit 0,1", array($postingDetail['id_admin']), 'fetch', 7200);
                }
            }

            /* Send email customer */
            if (!empty($ownerPosting)) {
                /* Defaults attributes email */
                $emailDefaultAttrs = $emailer->defaultAttrs();

                /* Variables email */
                $emailVars = array(
                    '{emailShopName}',
                    '{emailSectorListName}',
                    '{emailProductName}',
                    '{emailProductURL}'
                );
                $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

                /* Values email */
                $emailVals = array(
                    $shopDetail['name'],
                    $postingDetail['nameSectorList'],
                    $postingDetail['namevi'],
                    $configBase . $postingDetail['slugSectorList'] . '/' . $postingDetail['slugvi'] . '/' . $postingDetail['id']
                );
                $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

                /* Info to send */
                $arrayEmail = array(
                    "dataEmail" => array(
                        "name" => $ownerPosting['fullname'],
                        "email" => $ownerPosting['email']
                    )
                );
                $subject = "Thư thông báo từ " . $setting['name' . $lang];
                $message = str_replace($emailVars, $emailVals, $emailer->markdown('product/active-posting', ['id_shop' => $postingDetail['id_shop']]));
                $file = null;

                if ($emailer->send("customer", $arrayEmail, $subject, $message, $file)) {
                    $result = true;
                }
            }
        }

        echo $result;
    }
}
