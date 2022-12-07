<?php
if (!defined('SOURCES')) die("Error");
$apiResp = $restApi->get($apiRoutes['storefront']['product']['lists']);
$apiResp = $restApi->decode($apiResp, true);
$dm_list = array();

if (!empty($apiResp) && ($apiResp['status'])==200) {
    foreach ($apiResp['data'] as $key => $v) {
        $dm_list[$key]= $v;
    }
}

/* Query allpage */
$favicon = $cache->get("select photo from #_photo where id_shop = $idShop and sector_prefix = ? and type = ? and act = ? and find_in_set('hienthi',status) limit 0,1", array($prefixSector, 'favicon', 'photo_static'), 'fetch', 7200);
$favicon = (!empty($favicon)) ? $favicon : ((!empty($sampleData['favicon'])) ? $sampleData['favicon'] : array());
$logo_main = $cache->get("select id, photo, options from #_photo where id_shop = 0 and type = ? and act = ? limit 0,1", array('logo', 'photo_static'), 'fetch', 7200);

$logo = $cache->get("select id, photo, options from #_photo where id_shop = $idShop and sector_prefix = ? and type = ? and act = ? limit 0,1", array($prefixSector, 'logo', 'photo_static'), 'fetch', 7200);
$logo = (!empty($logo)) ? $logo : ((!empty($sampleData['logo'])) ? $sampleData['logo'] : array());
// $social = $cache->get("select name$lang, photo, link from #_photo where id_shop = $idShop and sector_prefix = ? and type = ? and find_in_set('hienthi',status) order by numb,id desc", array($prefixSector, 'social'), 'result', 7200);
// $social = (!empty($social)) ? $social : ((!empty($sampleData['social'])) ? $sampleData['social'] : array());
// $footer = $cache->get("select A.name$lang as name$lang, B.content$lang as content$lang from #_static as A, #_static_content as B where A.id_shop = $idShop and sector_prefix = ? and A.id = B.id_parent and A.type = ? and find_in_set('hienthi',A.status) limit 0,1", array($prefixSector, 'footer'), 'fetch', 7200);

$social = $cache->get("select name$lang, photo, link from #_photo where id_shop = 0 and type = ? and find_in_set('hienthi',status) order by numb,id desc", array('social'), 'result', 7200);
$policy = $cache->get("select name$lang, slugvi, slugen, id from #_news where id_shop = 0 and type = ? and find_in_set('hienthi',status) order by numb,id desc", array('chinh-sach-ho-tro'), 'result', 7200);
$recruitment = $cache->get("select name$lang, slugvi, slugen, id from #_news where id_shop = 0 and type = ? and find_in_set('hienthi',status) order by numb,id desc", array('tuyen-dung'), 'result', 7200);
$support = $cache->get("select name$lang, slugvi, slugen, id from #_news where id_shop = 0 and type = ? and find_in_set('hienthi',status) order by numb,id desc", array('ho-tro-thanh-toan'), 'result', 7200);
$ministry = $cache->get("select photo, link from #_photo where id_shop = 0 and type = ? and act = ? and find_in_set('hienthi',status) limit 0,1", array('bo-cong-thuong', 'photo_static'), 'fetch', 7200);

$advertisesHome = $cache->get("select name$lang, photo, link from #_photo where id_shop = 0 and type = ? and find_in_set('hienthi',status) order by numb,id desc", array('advertise-home'), 'result', 7200);

$shopDetail = $d->rawQueryOne("select S.quantity as subscribeNumb,A.id_cat as id_cat from #_$tableShop as A left join #_$tableShopSubscribe as S on A.id = S.id_shop where A.id = ? limit 0,1", array($idShop));

$sectorItems = $cache->get("select name$lang, photo, photo2, slugvi, slugen, id, id_cat from #_product_item where id_cat = ? and find_in_set('hienthi',status) order by numb,id desc", array($shopDetail['id_cat']), 'result', 7200);

/* Query by interface */

$header = $cache->get("select id, photo, options from #_photo where id_shop = $idShop and sector_prefix = ? and type = ? and act = ? limit 0,1", array($prefixSector, 'header', 'photo_static'), 'fetch', 7200);
$header = (!empty($header)) ? $header : ((!empty($sampleData['header'])) ? $sampleData['header'] : array());
$banner = $cache->get("select id, photo, options from #_photo where id_shop = $idShop and sector_prefix = ? and type = ? and act = ? limit 0,1", array($prefixSector, 'banner', 'photo_static'), 'fetch', 7200);
$banner = (!empty($banner)) ? $banner : ((!empty($sampleData['banner'])) ? $sampleData['banner'] : array());

            
$whereShop = " A.id_store = ? and  A.id <> ? and A.status = ? and A.status_user = ? ";
$paramsShop = array($prefixSector,$shopInfo['id_store'], $shopInfo['id'], 'xetduyet', 'hienthi');
    
$sqlShop = "select A.id as id, A.id_interface as interface, A.name as name, A.photo as photo, A.slug_url as slug_url, B.name as nameCity, C.name as nameDistrict, D.name as nameWard, R.score as score, R.hit as hit, S.quantity as subscribeNumb, P.photo as logo from #_$tableShop as A inner join #_city as B inner join #_district as C inner join #_wards as D left join #_$tableShopRating as R on A.id = R.id_shop left join #_$tableShopSubscribe as S on A.id = S.id_shop left join #_photo as P on A.id = P.id_shop and P.sector_prefix = ? and P.type = 'logo' where $whereShop and A.id_city = B.id and A.id_district = C.id and A.id_wards = D.id order by A.numb,A.id desc limit 0,10";       
$shopsOther = $cache->get($sqlShop, $paramsShop, 'result', 7200);


/* Get statistic */
$counter = $statistic->getCounter();
$online = $statistic->getOnline();
