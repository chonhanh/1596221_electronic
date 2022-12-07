<?php
if (!defined('SOURCES')) die("Error");

if (!empty($id)) {
    /* Lấy bài viết detail */
    $rowDetail = $d->rawQueryOne("select A.id as id, A.view as view, A.date_created as date_created, A.type as type, A.name$lang as name$lang, A.slugvi as slugvi, A.slugen as slugen, A.photo as photo, A.options as options, B.desc$lang as desc$lang, B.content$lang as content$lang from #_news as A, #_news_content as B where A.id_shop = $idShop and B.id_parent = A.id and A.id = ? and A.type = ? and find_in_set('hienthi',A.status) limit 0,1", array($id, $type));

    /* Check exist */
    if (empty($rowDetail)) {
        header('HTTP/1.0 404 Not Found', true, 404);
        include("404.php");
        exit();
    }

    /* Cập nhật lượt xem */
    $data_view['view'] = $rowDetail['view'] + 1;
    $d->where('id_shop', $idShop);
    $d->where('id', $rowDetail['id']);
    $d->update('news', $data_view);

    /* Lấy bài viết cùng loại */
    $where = "";
    $where = "A.id_shop = $idShop and A.id <> ? and A.type = ? and find_in_set('hienthi',A.status)";
    $params = array($id, $type);

    $curPage = $getPage;
    $perPage = 10;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select A.id as id, A.name$lang as name$lang, A.slugvi as slugvi, A.slugen as slugen, A.photo as photo, A.date_created as date_created, B.desc$lang as desc$lang from #_news as A, #_news_content as B where B.id_parent = A.id and $where order by A.numb,A.id desc $limit";
    $news = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_news as A, #_news_content as B where B.id_parent = A.id and $where order by A.numb,A.id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);

    /* SEO */
    $seoDB = $seo->getOnDB('*', 'news_seo', $rowDetail['id']);
    $seo->set('h1', $rowDetail['name' . $lang]);
    if (!empty($seoDB['title' . $seolang])) $seo->set('title', $seoDB['title' . $seolang]);
    else $seo->set('title', $rowDetail['name' . $lang]);
    if (!empty($seoDB['keywords' . $seolang])) $seo->set('keywords', $seoDB['keywords' . $seolang]);
    if (!empty($seoDB['description' . $seolang])) $seo->set('description', $seoDB['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $img_json_bar = (!empty($rowDetail['options'])) ? json_decode($rowDetail['options'], true) : null;
    if (empty($img_json_bar) || ($img_json_bar['p'] != $rowDetail['photo'])) {
        $img_json_bar = $func->getImgSize($rowDetail['photo'], UPLOAD_NEWS_L . $rowDetail['photo']);
        $seo->updateSeoDB(json_encode($img_json_bar), 'news', $rowDetail['id']);
    }
    if (!empty($img_json_bar)) {
        $seo->set('photo', $configBase . THUMBS . '/' . $img_json_bar['w'] . 'x' . $img_json_bar['h'] . 'x2/' . UPLOAD_NEWS_L . $rowDetail['photo']);
        $seo->set('photo:width', $img_json_bar['w']);
        $seo->set('photo:height', $img_json_bar['h']);
        $seo->set('photo:type', $img_json_bar['m']);
    }
} else {
    /* SEO */
    $seopage = $d->rawQueryOne("select * from #_seopage where id_shop = $idShop and type = ? limit 0,1", array($type));
    $seo->set('h1', $title_crumb);
    if (!empty($seopage['title' . $seolang])) $seo->set('title', $seopage['title' . $seolang]);
    else $seo->set('title', $title_crumb);
    if (!empty($seopage['keywords' . $seolang])) $seo->set('keywords', $seopage['keywords' . $seolang]);
    if (!empty($seopage['description' . $seolang])) $seo->set('description', $seopage['description' . $seolang]);
    $seo->set('url', $func->getPageURL());
    $img_json_bar = (!empty($seopage['options'])) ? json_decode($seopage['options'], true) : null;
    if (!empty($seopage['photo'])) {
        if (empty($img_json_bar) || ($img_json_bar['p'] != $seopage['photo'])) {
            $img_json_bar = $func->getImgSize($seopage['photo'], UPLOAD_SEOPAGE_L . $seopage['photo']);
            $seo->updateSeoDB(json_encode($img_json_bar), 'seopage', $seopage['id']);
        }
        if (!empty($img_json_bar)) {
            $seo->set('photo', $configBase . THUMBS . '/' . $img_json_bar['w'] . 'x' . $img_json_bar['h'] . 'x2/' . UPLOAD_SEOPAGE_L . $seopage['photo']);
            $seo->set('photo:width', $img_json_bar['w']);
            $seo->set('photo:height', $img_json_bar['h']);
            $seo->set('photo:type', $img_json_bar['m']);
        }
    }

    /* Lấy tất cả bài viết */
    $where = "";
    $where = "A.id_shop = $idShop and B.id_parent = A.id and A.type = ? and find_in_set('hienthi',A.status)";
    $params = array($type);

    $curPage = $getPage;
    $perPage = 20;
    $startpoint = ($curPage * $perPage) - $perPage;
    $limit = " limit " . $startpoint . "," . $perPage;
    $sql = "select A.id as id, A.name$lang as name$lang, A.slugvi as slugvi, A.slugen as slugen, A.photo as photo, A.date_created as date_created, B.desc$lang as desc$lang, B.content$lang as content$lang from #_news as A, #_news_content as B where $where order by A.numb,A.id desc $limit";
    $news = $d->rawQuery($sql, $params);
    $sqlNum = "select count(*) as 'num' from #_news as A, #_news_content as B where $where order by A.numb,A.id desc";
    $count = $d->rawQueryOne($sqlNum, $params);
    $total = (!empty($count)) ? $count['num'] : 0;
    $url = $func->getCurrentPageURL();
    $paging = $func->pagination($total, $perPage, $curPage, $url);
}
