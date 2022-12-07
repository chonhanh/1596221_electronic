<?php
include "config.php";

$levelNewsfeed = (!empty($_POST['levelNewsfeed'])) ? htmlspecialchars($_POST['levelNewsfeed']) : '';
$id = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;
$isLogin = $func->getMember('active');
$idMember = $func->getMember('id');
$result = array();

if (!empty($isLogin) && !empty($id)) {
    $sectorNewsfeed = $d->rawQueryOne("select id from #_product_$levelNewsfeed where id = ? and find_in_set('hienthi',status) limit 0,1", array($id));

    if (!empty($sectorNewsfeed)) {
        $newsfeed = $d->rawQueryOne("select id from #_member_newsfeed where id_member = ? limit 0,1", array($idMember));

        $data = array();
        $data['id_member'] = $idMember;
        $data['id_newsfeed'] = $id;
        $data['level'] = $levelNewsfeed;

        if (!empty($newsfeed)) {
            $d->where("id", $newsfeed['id']);

            if ($d->update("member_newsfeed", $data)) {
                /* Delete cache */
                $cache->delete();
            } else {
                $result['error'] = true;
            }
        } else {
            if ($d->insert('member_newsfeed', $data)) {
                /* Delete cache */
                $cache->delete();
            } else {
                $result['error'] = true;
            }
        }
    } else {
        $result['error'] = true;
    }
}

echo json_encode($result);
