<div class="header-account bg-warning rounded px-3 py-2 text-center text-dark text-capitalize mb-4">
    <strong><?= $title_crumb ?></strong>
</div>
<div class="content-account pt-1">
    <?php if (empty($IDSector)) { ?>
        <div class="form-row">
            <?php foreach ($sectors as $v_sector) { ?>
                <div class="col-4 mb-3">
                    <div class="sectors sectors-list">
                        <a class="sectors-image scale-img" href="account/binh-luan?sector=<?= $v_sector['id'] ?>" title="<?= $v_sector['name' . $lang] ?>">
                            <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '380x275x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v_sector['photo'], 'alt' => $v_sector['name' . $lang]]) ?>
                        </a>
                        <h3 class="sectors-name d-flex align-items-center justify-content-center w-100 mt-3 mb-0 px-2 text-center">
                            <a class="small font-weight-500 text-decoration-none text-primary-hover text-uppercase transition" href="account/binh-luan?sector=<?= $v_sector['id'] ?>" title="<?= $v_sector['name' . $lang] ?>"><?= $v_sector['name' . $lang] ?></a>
                        </h3>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="lists-sector mb-4">
            <?php foreach ($sectors as $v_sector) { ?>
                <a class="btn btn-sm <?= ($IDSector == $v_sector['id']) ? 'btn-primary' : 'btn-outline-primary' ?> d-inline-block text-capitalize py-2 px-3 mr-2" href="account/binh-luan?sector=<?= $v_sector['id'] ?>" title="<?= $v_sector['name' . $lang] ?>"><?= $v_sector['name' . $lang] ?></a>
            <?php } ?>
        </div>
        <?php if (!empty($products)) { ?>
            <div class="form-row">
                <?php foreach ($products as $v_product) { ?>
                    <?php
                    $v_product['name'] = $v_product['name' . $lang];
                    $v_product['href'] = 'account/chi-tiet-binh-luan?sector=' . $sector['id'] . '&id=' . $v_product['id'];
                    $v_product['totalComment'] = $comment->totalByID($v_product['id']);
                    $v_product['newComment'] = $comment->newPost($v_product['id'], 'new-member');
                    ?>
                    <div class="col-product-comment col-3 mb-4"><?= $func->getProductComment($v_product) ?></div>
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