<?php if (!empty($sectorCats)) { ?>
    <div class="sector-bar-cats sector-scroll custom-mcsrcoll-x <?= $func->get('actionClsModal-cat-clsMain') ?> w-clear mb-3">
        <?php foreach ($sectorCats as $v_cat) { ?>
            <div class="sectors sectors-cat float-left mr-2 <?= (!empty($IDCat) && $IDCat == $v_cat['id']) ? 'active' : '' ?>" data-id="<?= $v_cat['id'] ?>">
                <h3 class="sectors-name m-0 text-center">
                    <a class="text-decoration-none text-primary-hover text-uppercase <?= (!empty($IDCat) && $IDCat == $v_cat['id']) ? 'active' : '' ?> transition" href="javascript:void(0)" title="<?= $v_cat['name' . $lang] ?>"><?= $v_cat['name' . $lang] ?></a>
                </h3>
            </div>
        <?php } ?>
    </div>
<?php } ?>