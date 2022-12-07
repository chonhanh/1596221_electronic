<?php if (!empty($productSelling)) { ?>
    <div class="block-product-selling mb-5">
        <div class="block-content">
            <div class="title-main d-flex align-items-center justify-content-between">
                <span>Sản phẩm bán chạy</span>
                <a class="font-weight-500 font-italic text-decoration-none" href="san-pham-ban-chay" title="Xem tất cả">Xem tất cả</a>
            </div>
            <div class="position-relative">
                <div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:4|margin:20" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="800" data-autoplayspeed="800" data-autoplaytimeout="5000" data-dots="0" data-nav="1" data-navcontainer=".control-product-selling">
                    <?php foreach ($productSelling as $v_product) {
                        $v_product['name'] = $v_product['name' . $lang];
                        $v_product['href'] = BASE_MAIN . $sectorDetail['type'] . '/' . $v_product[$sluglang] . '/' . $v_product['id'];
                        $v_product['interface'] = INTERFACE_SHOP;
                        $v_product['priceType'] = $variation->get($tableProductVariation, $v_product['id'], 'loai-gia', $lang); ?>
                        <?= $func->getProduct($v_product) ?>
                    <?php } ?>
                </div>
                <div class="control-product-selling control-owl transition <?= (count($productSelling) <= 4) ? 'd-none' : '' ?>"></div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (!empty($sectorItemsPage['hightlight'])) {
    foreach ($sectorItemsPage['hightlight'] as $k_item => $v_item) { ?>
        <div class="block-sector-item mb-5">
            <div class="block-content">
                <div class="title-main d-flex align-items-center justify-content-between">
                    <span><?= $v_item['name' . $lang] ?></span>
                    <a class="font-weight-500 font-italic text-decoration-none" href="san-pham?item=<?= $v_item['id'] ?>" title="Xem tất cả">Xem tất cả</a>
                </div>
                <div class="paging-sector-item paging-sector-item-<?= $v_item['id'] ?>" data-item="<?= $v_item['id'] ?>"></div>
            </div>
        </div>
<?php }
} ?>