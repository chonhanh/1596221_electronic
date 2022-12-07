<?php if (!empty($sectorItems)) { ?>
    <div class="sector-scroll-items sector-scroll custom-mcsrcoll-x filter-item d-flex align-items-start justify-content-start border p-2">
        <?php foreach ($sectorItems as $v_item) { ?>
            <div class="sectors sectors-item <?= $sector['prefix'] ?> float-left mr-2 <?= (!empty($IDItem) && $IDItem == $v_item['id']) ? 'active' : '' ?>" data-id="<?= $v_item['id'] ?>" data-idcat="<?= $v_item['id_cat'] ?>">
                <a class="sectors-image scale-img" href="javascript:void(0)" title="<?= $v_item['name' . $lang] ?>">
                    <?= $func->getImage(['class' => 'w-100', 'isLazy' => false, 'sizes' => '315x230x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v_item['photo'], 'alt' => $v_item['name' . $lang]]) ?>
                </a>
                <h3 class="sectors-name d-flex align-items-center justify-content-center w-100 mt-2 mb-0 px-2 text-center">
                    <a class="text-decoration-none text-primary-hover <?= (!empty($IDItem) && $IDItem == $v_item['id']) ? 'active' : '' ?> text-uppercase transition" href="javascript:void(0)" title="<?= $v_item['name' . $lang] ?>"><?= $v_item['name' . $lang] ?></a>
                </h3>
            </div>
        <?php } ?>
    </div>
<?php } ?>