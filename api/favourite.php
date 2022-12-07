<?php
include "config.php";

$variant = (!empty($_POST['variant'])) ? htmlspecialchars($_POST['variant']) : '';
$type = (!empty($_POST['type'])) ? htmlspecialchars($_POST['type']) : '';
$id_variant = (!empty($_POST['id_variant'])) ? htmlspecialchars($_POST['id_variant']) : 0;
$isLogin = $func->getMember('active');
$idMember = $func->getMember('id');
$result = array();

if (!empty($isLogin) && !empty($variant) && !empty($type) && !empty($id_variant)) {
    /* Sector  */
    $sector = $defineSectors['types'][$type];
    $tableProductMain = (!empty($sector['tables']['main'])) ? $sector['tables']['main'] : '';
    $tableShop = (!empty($sector['tables']['shop'])) ? $sector['tables']['shop'] : '';

    /* Get detail */
    $detail = $d->rawQueryOne("select id, id_member, id_shop from #_$tableProductMain where id = ? limit 0,1", array($id_variant));

    /* Check detail */
    if (!empty($detail)) {
        /* Get shop owned */
        $ownedShop = array();

        if (!empty($tableShop)) {
            $ownedShop = $d->rawQueryOne("select id from #_$tableShop where id = ? and id_member = ? limit 0,1", array($detail['id_shop'], $idMember));
        }

        /* Check owned */
        if (($detail['id_member'] == $idMember) || (!empty($ownedShop) && $detail['id_shop'] == $ownedShop['id'])) {
            $result['owned'] = true;
        } else {
            /* Get favourite  */
            $favourite = $d->rawQueryOne("select id, id_member, id_variant, type, variant from #_member_favourite where id_member = ? and id_variant = ? and type = ? and variant = ? limit 0,1", array($idMember, $id_variant, $type, $variant));

            if (empty($favourite)) {
                $data = array();
                $data['id_member'] = $idMember;
                $data['id_variant'] = $id_variant;
                $data['type'] = $type;
                $data['variant'] = $variant;

                if ($d->insert('member_favourite', $data)) {
                    /* Delete cache */
                    $cache->delete();

                    /* Added success */
                    $result['added'] = true;
                } else {
                    $result['failed'] = true;
                }
            } else {
                $d->rawQuery("delete from #_member_favourite where id_member = ? and id_variant = ? and type = ? and variant = ?", array($idMember, $id_variant, $type, $variant));

                /* Delete cache */
                $cache->delete();

                /* Deleted success */
                $result['deleted'] = true;
            }
        }
    } else {
        $result['failed'] = true;
    }
} else {
    $result['failed'] = true;
}

echo json_encode($result);
