<?php
if (!defined('SOURCES')) die("Error");

/* Lấy bài viết tĩnh */
$static = $d->rawQueryOne("select A.id as id, A.name$lang as name$lang, A.type as type, A.photo as photo, A.date_created as date_created, A.date_updated as date_updated, A.options as options, B.content$lang as content$lang from #_static as A, #_static_content as B where A.id_shop = $idShop and A.sector_prefix = ? and B.id_parent = A.id and A.type = ? and find_in_set('hienthi',A.status) limit 0,1", array($prefixSector, $type));

/* SEO */
if (!empty($static)) {
    $seoDB = $seo->getOnDB('*', 'static_seo', $static['id']);
    $seo->set('h1', $static['name' . $lang]);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
    else $seo->set('title', $static['name' . $lang]);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $img_json_bar = (!empty($static['options'])) ? json_decode($static['options'], true) : null;
    if (empty($img_json_bar) || ($img_json_bar['p'] != $static['photo'])) {
        $img_json_bar = $func->getImgSize($static['photo'], UPLOAD_NEWS_SOURCE . $static['photo']);
        $seo->updateSeoDB(json_encode($img_json_bar), 'static', $static['id']);
    }
    if (!empty($img_json_bar)) {
        $seo->set('photo', $configBase . THUMBS_SOURCE . '/' . $img_json_bar['w'] . 'x' . $img_json_bar['h'] . 'x2/' . UPLOAD_NEWS_THUMB . $static['photo']);
        $seo->set('photo:width', $img_json_bar['w']);
        $seo->set('photo:height', $img_json_bar['h']);
        $seo->set('photo:type', $img_json_bar['m']);
    }
}
