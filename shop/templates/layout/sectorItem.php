<?php if (!empty($sectorItemsPage['hightlight'])) { ?>
    <div class="block-sector-items block-content">
        <div class="sector-scroll-items sector-scroll custom-mcsrcoll-x d-flex align-items-start justify-content-start mb-4">
            <?php foreach ($sectorItemsPage['hightlight'] as $v_item) { ?>
                <div class="sectors-item float-left text-center <?= (!empty($IDItem) && $IDItem == $v_item['id']) ? 'active' : '' ?>">
                    <a class="sectors-image d-block mb-2" href="nha-dat?item=<?= $v_item['id'] ?>" title="<?= $v_item['name' . $lang] ?>">
                        <?= $func->getImage(['sizes' => '315x230x1', 'upload' => UPLOAD_PRODUCT_THUMB, 'image' => $v_item['photo'], 'alt' => $v_item['name' . $lang]]) ?>
                    </a>
                    <h3 class="sectors-name m-0">
                        <a class="text-decoration-none text-split text-dark text-uppercase transition" href="nha-dat?item=<?= $v_item['id'] ?>" title="<?= $v_item['name' . $lang] ?>"><?= $v_item['name' . $lang] ?></a>
                    </h3>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>