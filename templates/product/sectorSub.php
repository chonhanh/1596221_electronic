<?php if (!empty($sectorSubs)) { ?>
    <div class="filter-sub ">
        <?php foreach ($sectorSubs as $v_sub) { ?>
            <div class="sectors sectors-sub <?= $sector['prefix'] ?> mb-3 <?= (!empty($IDSub) && $IDSub == $v_sub['id']) ? 'active' : '' ?>" data-id="<?= $v_sub['id'] ?>" data-idcat="<?= $v_sub['id_cat'] ?>" data-iditem="<?= $v_sub['id_item'] ?>">
                <a class="sectors-image scale-img" href="javascript:void(0)" title="<?= $v_sub['name' . $lang] ?>">
                    <?= $func->getImage(['class' => 'w-100', 'isLazy' => false, 'sizes' => '315x230x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v_sub['photo'], 'alt' => $v_sub['name' . $lang]]) ?>
                </a>
                <h3 class="sectors-name d-flex align-items-center justify-content-center w-100 mt-2 mb-0 px-2 text-center">
                    <a class="text-decoration-none text-primary-hover <?= (!empty($IDSub) && $IDSub == $v_sub['id']) ? 'active' : '' ?> text-uppercase transition" href="javascript:void(0)" title="<?= $v_sub['name' . $lang] ?>"><?= $v_sub['name' . $lang] ?></a>
                </h3>
            </div>
        <?php } ?>
    </div>
<?php } ?>