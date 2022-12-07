<div class="header-account bg-warning rounded px-3 py-2 text-center text-dark text-capitalize mb-4">
    <strong><?= $title_crumb ?></strong>
</div>
<div class="content-account pt-1">
    <?php if (empty($IDSector)) { ?>
        <div class="form-row">
            <?php foreach ($sectors as $v_sector) {
                if (in_array($v_sector['type'], $defineSectors['hasShop']['types'])) { ?>
                    <div class="col-4 mb-3">
                        <div class="sectors sectors-list">
                            <a class="sectors-image scale-img" href="account/gian-hang?sector=<?= $v_sector['id'] ?>" title="<?= $v_sector['name' . $lang] ?>">
                                <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '380x275x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v_sector['photo'], 'alt' => $v_sector['name' . $lang]]) ?>
                            </a>
                            <h3 class="sectors-name d-flex align-items-center justify-content-center w-100 mt-3 mb-0 px-2 text-center">
                                <a class="small font-weight-500 text-decoration-none text-primary-hover text-uppercase transition" href="account/gian-hang?sector=<?= $v_sector['id'] ?>" title="<?= $v_sector['name' . $lang] ?>"><?= $v_sector['name' . $lang] ?></a>
                            </h3>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    <?php } else { ?>
        <div class="lists-sector mb-4">
            <?php foreach ($sectors as $v_sector) {
                if (in_array($v_sector['type'], $defineSectors['hasShop']['types'])) { ?>
                    <a class="btn btn-sm <?= ($IDSector == $v_sector['id']) ? 'btn-primary' : 'btn-outline-primary' ?> d-inline-block text-capitalize py-2 px-3 mr-2" href="account/gian-hang?sector=<?= $v_sector['id'] ?>" title="<?= $v_sector['name' . $lang] ?>"><?= $v_sector['name' . $lang] ?></a>
            <?php }
            } ?>
        </div>
        <?php if (!empty($stores)) { ?>
            <div class="block-stores mb-4">
                <div class="position-relative">
                    <div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:4|margin:20" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="500" data-autoplayspeed="500" data-autoplaytimeout="5000" data-autoplayhoverpause="1" data-dots="0" data-nav="1" data-navcontainer=".control-store">
                        <?php foreach ($stores as $v_store) { ?>
                            <div class="store">
                                <a class="store-image rounded-main scale-img" href="account/gian-hang?sector=<?= $v_store['id_list'] ?>&store=<?= $v_store['id'] ?>" title="<?= $v_store['name' . $lang] ?>">
                                    <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '285x200x1', 'upload' => UPLOAD_STORE_L, 'image' => $v_store['photo'], 'alt' => $v_store['name' . $lang]]) ?>
                                </a>
                                <h3 class="store-name w-100 mb-0 text-center">
                                    <a class="text-decoration-none text-primary-hover <?= (!empty($IDStore) && $IDStore == $v_store['id']) ? 'active' : '' ?> text-uppercase transition" href="account/gian-hang?sector=<?= $v_store['id_list'] ?>&store=<?= $v_store['id'] ?>" title="<?= $v_store['name' . $lang] ?>"><?= $v_store['name' . $lang] ?></a>
                                </h3>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="control-store control-owl transition <?= (count($stores) <= 4) ? 'd-none' : '' ?>"></div>
                </div>
            </div>
        <?php } ?>
        <?php if (!empty($shops)) { ?>
            <div class="form-row">
                <?php foreach ($shops as $v_shop) { ?>
                    <?php
                    $v_shop['clsMain'] = 'shop-account';
                    $v_shop['clsSmall'] = 'small';
                    $v_shop['href'] = 'account/chi-tiet-gian-hang?sector=' . $sector['id'] . '&id=' . $v_shop['id'];
                    $v_shop['href-detail'] = $configBaseShop . $v_shop['slug_url'] . '/';
                    $v_shop['sector'] = $sector;
                    $v_shop['isAccount'] = true;
                    $v_shop['sample'] = !empty($sampleData) ? $sampleData : array();
                    $v_shop['memberSubscribe'] = !empty($memberSubscribe) ? $memberSubscribe : array();
                    ?>
                    <div class="col-shop-account col-4 mb-3"><?= $func->getShop($v_shop) ?></div>
                <?php } ?>
            </div>
            <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
        <?php } else { ?>
            <div class="alert alert-warning w-100" role="alert">
                <strong><?= khongtimthayketqua ?></strong>
            </div>
        <?php } ?>
    <?php } ?>
</div>