<div class="shop-chat shop">
    <a class="shop-image scale-img mb-2" target="_blank" href="<?= $params['href'] ?>" title="<?= $params['name'] ?>">
        <?= $this->getImage(['class' => 'lazy w-100', 'sizes' => '380x260x1', 'upload' => UPLOAD_SHOP_L, 'image' => $params['photo'], 'alt' => $params['name']]); ?>
    </a>

    <div class="shop-chat-statistic text-uppercase mb-3">
        <a class="btn btn-sm btn-primary text-capitalize mr-2" target="_blank" href="<?= $params['href'] ?>" title="Tổng (<?= $params['totalChat'] ?>) tin nhắn">
            Tổng <span class="badge badge-light align-middle"><?= $params['totalChat'] ?></span>
        </a>

        <?php if (!empty($params['newChat'])) { ?>
            <a class="btn btn-sm btn-danger text-capitalize" target="_blank" href="<?= $params['href'] ?>" title="(<?= $params['newChat'] ?>) tin nhắn mới">Mới <span class="badge badge-light align-middle"><?= $params['newChat'] ?></span></a>
        <?php } ?>
    </div>

    <div class="shop-content">
        <div class="shop-logo">
            <a class="shop-logo-image" target="_blank" href="<?= $params['href'] ?>" title="<?= $params['name'] ?>">
                <?= $this->getImage(['class' => 'lazy w-100', 'sizes' => '65x65x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $params['logo'], 'alt' => $params['name']]); ?>
            </a>
        </div>

        <div class="shop-info">
            <h3 class="shop-name mb-1"><a class="text-decoration-none text-uppercase text-primary-hover transition" target="_blank" href="<?= $params['href'] ?>" title="<?= $params['name'] ?>"><?= $params['name'] ?></a></h3>
            <div class="shop-address mb-1"><strong class="pr-1">Địa chỉ:</strong><span><?= $this->joinPlace($params) ?></span></div>
        </div>
    </div>
</div>