<?php
header("Content-Type: text/xml; charset=utf-8");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="https://www.sitemaps.org/schemas/sitemap/0.9 https://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
echo '<url><loc>' . $configBase . '</loc><lastmod>' . date('c', time()) . '</lastmod><changefreq>daily</changefreq><priority>0.1</priority></url>';

/* Static */
$smTypesStatic = ['gioi-thieu', 'lien-he'];

foreach ($smTypesStatic as $key => $value) {
    $smStatic = $d->rawQueryOne("select date_created from #_static where type = ?", array($value));

    if (!empty($smStatic)) {
        $func->createSitemap($configBase . $value, $smStatic['date_created'], 'daily', 1);
    }
}

/* News */
$smTypesNews = [
    'thong-bao' => [
        'type' => 'thong-bao',
        'menu' => true
    ],
    'tuyen-dung' => [
        'type' => 'tuyen-dung',
        'menu' => false
    ],
    'chinh-sach-ho-tro' => [
        'type' => 'chinh-sach-ho-tro',
        'menu' => false
    ],
    'ho-tro-thanh-toan' => [
        'type' => 'ho-tro-thanh-toan',
        'menu' => false
    ],
];

foreach ($smTypesNews as $key => $value) {
    if (!empty($value['menu'])) {
        $func->createSitemap($configBase . $value['type'], time(), 'daily', 1);
    }

    $smNews = $d->rawQuery("select id, slugvi, date_created from #_news where type = ?", array($value['type']));

    if (!empty($smNews)) {
        foreach ($smNews as $v) {
            $func->createSitemap($configBase . $value['type'] . '/' . $v['slugvi'] . '/' . $v['id'], $v['date_created'], 'daily', 1);
        }
    }
}

/* By sector */
foreach ($defineSectors['sectors']['types'] as $key => $value) {
    /* Type Sector */
    $typeSector = $defineSectors['types'][$value];

    /* List */
    $func->createSitemap($configBase . $value, time(), 'daily', 1);

    /* Cat */
    $smCat = $d->rawQuery("select id, id_list, slugvi, date_created from #_product_cat where id_list = ?", array($typeSector['id']));

    if (!empty($smCat)) {
        foreach ($smCat as $k => $v) {
            $func->createSitemap($configBase . $value . '?cat=' . $v['id'], $v['date_created'], 'daily', 1);
            $func->createSitemap($configBase . 'nhom-cua-hang/' . $v['slugvi'] . '/' . $v['id'] . '?sector=' . $v['id_list'], $v['date_created'], 'daily', 1);
        }
    }

    /* Item */
    $smItem = $d->rawQuery("select id, id_cat, date_created from #_product_item where id_list = ?", array($typeSector['id']));

    if (!empty($smItem)) {
        foreach ($smItem as $k => $v) {
            $func->createSitemap($configBase . $value . '?cat=' . $v['id_cat'] . '&amp;item=' . $v['id'], $v['date_created'], 'daily', 1);
        }
    }

    /* Sub */
    $smSub = $d->rawQuery("select id, id_cat, id_item, date_created from #_product_sub where id_list = ?", array($typeSector['id']));

    if (!empty($smSub)) {
        foreach ($smSub as $k => $v) {
            $func->createSitemap($configBase . $value . '?cat=' . $v['id_cat'] . '&amp;item=' . $v['id_item'] . '&amp;sub=' . $v['id'], $v['date_created'], 'daily', 1);
        }
    }

    /* Shop */
    if (in_array($value, $defineSectors['hasShop']['types'])) {
        $smShop = $d->rawQuery("select slug_url, date_created from #_shop_" . $typeSector['prefix'] . "");

        if (!empty($smShop)) {
            foreach ($smShop as $k => $v) {
                $func->createSitemap($configBase . 'shop/' . $v['slug_url'] . '/', $v['date_created'], 'daily', 1);
            }
        }
    }

    /* Posting */
    $smPosting = $d->rawQuery("select id, slugvi, date_created from #_product_" . $typeSector['prefix'] . "");

    if (!empty($smPosting)) {
        foreach ($smPosting as $k => $v) {
            $func->createSitemap($configBase . $value . '/' . $v['slugvi'] . '/' . $v['id'], $v['date_created'], 'daily', 1);

            /* Video of posting */
            $smPostingVideo = $d->rawQueryOne("select id from #_product_" . $typeSector['prefix'] . "_video where id_parent = ? limit 0,1", array($v['id']));

            if (!empty($smPostingVideo)) {
                $func->createSitemap($configBase . $value . '/' . $v['slugvi'] . '/' . $v['id'] . '?video=' . $smPostingVideo['id'], $v['date_created'], 'daily', 1);
            }
        }
    }

    /* Video */
    $func->createSitemap($configBase . 'video?sector=' . $typeSector['id'], $v['date_created'], 'daily', 1);
}

/* Tags */
$smTags = $d->rawQuery("select id, id_list, slugvi, date_created from #_product_tags");

if (!empty($smTags)) {
    foreach ($smTags as $v) {
        $func->createSitemap($configBase . 'tags/' . $v['slugvi'] . '/' . $v['id'] . '?sector=' . $v['id_list'], $v['date_created'], 'daily', 1);
    }
}

echo '</urlset>';
