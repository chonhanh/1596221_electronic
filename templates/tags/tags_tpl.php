<div class="title-main"><span><?= @$title_crumb ?></span></div>
<div class="content-main">
    <?php if (!empty($products)) { ?>
        <div class="form-row">
            <?php foreach ($products as $v_product) {
                $v_product['name'] = $v_product['name' . $lang];
                $v_product['href'] = $sector['type'] . '/' . $v_product[$sluglang] . '/' . $v_product['id'];
                $v_product['sector'] = $sector;
                $v_product['clsMain'] = 'product-shadow';
                $v_product['favourites'] = (!empty($favourites)) ? $favourites : array();
                $v_product['showFavourite'] = true;
                $v_product['showInfo'] = true;
                $v_product['idMember'] = $idMember;
                $v_product['ownedShop'] = (!empty($ownedShop)) ? $ownedShop : array();
                $v_product['sample'] = (!empty($sampleData)) ? $sampleData : array();
                $v_product['priceType'] = $variation->get($tableProductVariation, $v_product['id'], 'loai-gia', $lang);

                if (in_array($sector['type'], array('ung-vien', 'nha-tuyen-dung'))) {
                    $v_product['experience'] = $variation->get($tableProductVariation, $v_product['id'], 'kinh-nghiem', $lang);
                } ?>
                <div class="col-3 mb-4"><?= $func->getProduct($v_product) ?></div>
            <?php } ?>
        </div>
        <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
    <?php } else { ?>
        <div class="alert alert-warning w-100" role="alert">
            <strong><?= khongtimthayketqua ?></strong>
        </div>
    <?php } ?>
</div>