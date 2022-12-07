<div class="content-main ">
    <?php if (!empty($products)) {
        foreach ($products as $k_product => $v_product) {
     
            $v_product['name'] = $v_product['name' . $lang];
            $v_product['desc'] = $v_product['desc' . $lang];
            $v_product['href'] = BASE_MAIN . $sectorDetail['type'] . '/' . $v_product[$sluglang] . '/' . $v_product['id'];          
            $v_product['sector'] = $sector;
            $v_product['shopUrl'] = '';
            $v_product['shopName'] = $setting['name' . $lang];
            $v_product['shopLogo'] = $logo['photo'];

            $v_product['clsMain'] = 'product-shadow';
            $v_product['favourites'] = (!empty($favourites)) ? $favourites : array();
            $v_product['showFavourite'] = true;
            $v_product['showInfo'] = true;
            $v_product['idMember'] = $idMember;
            $v_product['ownedShop'] = (!empty($ownedShop)) ? $ownedShop : array();
            $v_product['sample'] = (!empty($sampleData)) ? $sampleData : array();
            $v_product['priceType'] = $variation->get($tableProductVariation, $v_product['id'], 'loai-gia', $lang);
      
        ?>
            <div class="w-clear mb-3"><?= $func->getProduct($v_product) ?></div>
        <?php }
    } else { ?>
        <div class="col-12">
            <div class="alert alert-warning w-100" role="alert">
                <strong><?= khongtimthayketqua ?></strong>
            </div>
        </div>
    <?php } ?>
    <div class="clear"></div>
    <div class="col-12">
        <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
    </div>
</div>