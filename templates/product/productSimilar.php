<!-- Products similar -->
<?php if (!empty($productSimilar)) { ?>
    <div class="block-product-similar mt-5">
        <div class="title-main"><span>Tin đăng cùng loại</span></div>
        <div class="position-relative">
            <div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:4|margin:20" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="500" data-autoplayspeed="500" data-autoplaytimeout="5000" data-autoplayhoverpause="1" data-dots="0" data-nav="1" data-navcontainer=".control-product-similar">
                <?php foreach ($productSimilar as $v_product) {
                    $v_product['name'] = $v_product['name' . $lang];
                    $v_product['href'] = $sector['type'] . '/' . $v_product[$sluglang] . '/' . $v_product['id'];
                    $v_product['sector'] = $sector;
                    $v_product['favourites'] = (!empty($favourites)) ? $favourites : array();
                    $v_product['showFavourite'] = true;
                    $v_product['showInfo'] = true;
                    $v_product['priceType'] = $variation->get($tableProductVariation, $v_product['id'], 'loai-gia', $lang);

                    if (in_array($sector['type'], array('ung-vien', 'nha-tuyen-dung'))) {
                        $v_product['experience'] = $variation->get($tableProductVariation, $v_product['id'], 'kinh-nghiem', $lang);
                    }

                    echo $func->getProduct($v_product);
                } ?>
            </div>
            <div class="control-product-similar control-owl transition <?= (count($productSimilar) <= 4) ? 'd-none' : '' ?>"></div>
        </div>
    </div>
<?php } ?>