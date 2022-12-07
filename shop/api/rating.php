<?php
include "config.php";

$flag = false;
$result = array();
$score = (!empty($_POST['score'])) ? htmlspecialchars($_POST['score']) : 0;

if (!empty($score)) {
    $rating = $d->rawQueryOne("select id_shop, score, hit from #_$tableShopRating where id_shop = ? limit 0,1", array($idShop));

    if (!empty($rating)) {
        $rating['score'] += $score;
        $rating['hit'] += 1;

        $d->where('id_shop', $idShop);

        if ($d->update($tableShopRating, $rating)) {
            $flag = true;

            /* Delete cache */
            $cache->delete();
        }
    } else {
        $data = array();
        $data['id_shop'] = $idShop;
        $data['score'] = $score;
        $data['hit'] = 1;

        if ($d->insert($tableShopRating, $data)) {
            $flag = true;

            /* Delete cache */
            $cache->delete();
        }
    }
}

if (!empty($flag)) {
    $result['status'] = 'success';
    $result['message'] = 'Cảm ơn bạn đã đánh giá gian hàng';
} else {
    $result['status'] = 'error';
    $result['message'] = 'Đánh giá thất bại. Vui lòng thử lại sau';
}

echo json_encode($result);
