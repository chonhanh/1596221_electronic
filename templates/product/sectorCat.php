<?php if (!empty($sectorCats)) { ?>
    <div class="sector-scroll-cats sector-scroll custom-mcsrcoll-x filter-cat d-flex align-items-start justify-content-start border p-2 mb-2">
        <?php foreach ($sectorCats as $v_cat) { ?>
            <div class="sectors sectors-cat float-left mr-2 <?= (!empty($IDCat) && $IDCat == $v_cat['id']) ? 'active' : '' ?>" data-id="<?= $v_cat['id'] ?>">
                <a class="sectors-image scale-img" href="javascript:void(0)" title="<?= $v_cat['name' . $lang] ?>">
                    <?= $func->getImage(['class' => 'w-100', 'isLazy' => false, 'sizes' => '290x300x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v_cat['photo'], 'alt' => $v_cat['name' . $lang]]) ?>
                </a>
                <h3 class="sectors-name d-flex align-items-center justify-content-center w-100 mt-2 mb-0 px-2 text-center">
                    <a class="text-decoration-none text-primary-hover <?= (!empty($IDCat) && $IDCat == $v_cat['id']) ? 'active' : '' ?> text-uppercase transition" href="javascript:void(0)" title="<?= $v_cat['name' . $lang] ?>"><?= $v_cat['name' . $lang] ?></a>
                </h3>
            </div>
        <?php } ?>
    </div>
<?php } ?>