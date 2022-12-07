<div class="product-comment product-shadow small product position-relative rounded transition">
    <a class="product-image scale-img rounded mb-1" target="_blank" href="<?= $params['href'] ?>" title="<?= $params['name'] ?>">
        <?= $this->getImage(['class' => 'lazy w-100', 'sizes' => '300x300x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $params['photo'], 'alt' => $params['name']]); ?>
    </a>
    <div class="product-info px-1 py-2">
        <div class="product-datepost text-secondary mb-1">Đăng ngày: <?= date('d/m/Y', $params['date_created']) ?></div>
        <div class="product-label mb-2">
            <h3 class="product-name mt-0 mb-0">
                <a class="d-block small font-weight-500 text-decoration-none text-primary-hover text-uppercase transition" target="_blank" href="<?= $params['href'] ?>" title="<?= $params['name'] ?>"><?= $params['name'] ?></a>
            </h3>
        </div>
        <div class="product-comment-statistic text-uppercase">
            <a class="btn btn-sm btn-primary text-capitalize mr-2" target="_blank" href="<?= $params['href'] ?>" title="Tổng (<?= $params['totalComment'] ?>) bình luận">
                Tổng <span class="badge badge-light align-middle"><?= $params['totalComment'] ?></span>
            </a>

            <?php if (!empty($params['newComment'])) { ?>
                <a class="btn btn-sm btn-danger text-capitalize" target="_blank" href="<?= $params['href'] ?>" title="(<?= $params['newComment'] ?>) bình luận mới">
                    Mới <span class="badge badge-light align-middle"><?= $params['newComment'] ?></span>
                </a>
            <?php } ?>
        </div>
    </div>
    <a class="btn btn-sm btn-outline-primary d-block" target="_blank" href="<?= $params['href'] ?>" title="Chi tiết"><small>Chi tiết</small></a>
</div>