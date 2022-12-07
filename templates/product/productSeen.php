<!-- Products seen -->
<?php if (!empty($productSeen)) { ?>
    <div class="block-product-seen bg-f">
        <div class="card-header text-uppercase"><strong>Sản phẩm đã xem gần đây</strong></div>
     
        <div class="position-relative">
            <?php foreach ($productSeen as $v_product) {
                $v_product['name'] = $v_product['name' . $lang];
                $v_product['desc'] = $v_product['desc' . $lang];
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

            ?>
                <div class="w-clear mb-3"><?= $func->getProduct($v_product); ?></div>
            <?php } ?>
            <?php /*
            <div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:4|margin:20" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="500" data-autoplayspeed="500" data-autoplaytimeout="5000" data-autoplayhoverpause="1" data-dots="0" data-nav="1" data-navcontainer=".control-product-seen">
            </div>
            <div class="control-product-seen control-owl transition <?= (count($productSeen) <= 4) ? 'd-none' : '' ?>"></div>
            */ ?>
        </div>
    </div>
<?php } ?>