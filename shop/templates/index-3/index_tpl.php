<?php if (!empty($productHighlight)) { ?>
    <div class="block-product-highlight">
        <div class="block-content py-5">
            <div class="position-relative">
                <div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:4|margin:20" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="800" data-autoplayspeed="800" data-autoplaytimeout="3500" data-dots="0" data-nav="1" data-navcontainer=".control-product-highlight">
                    <?php foreach ($productHighlight as $v_product) {
                        $v_product['name'] = $v_product['name' . $lang];
                        $v_product['href'] = BASE_MAIN . $sectorDetail['type'] . '/' . $v_product[$sluglang] . '/' . $v_product['id'];
                        $v_product['interface'] = INTERFACE_SHOP; ?>
                        <div class="product-home"><?= $func->getProduct($v_product) ?></div>
                    <?php } ?>
                </div>
                <div class="control-product-highlight control-owl transition <?= (count($productHighlight) <= 4) ? 'd-none' : '' ?>"></div>
            </div>
        </div>
    </div>
<?php } ?>