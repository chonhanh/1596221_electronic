<div class="shop-mini">
    <div class="shop-logo">
        <a class="shop-logo-image" href="<?= $params['hrefVideo'] ?>" title="<?= $params['name'] ?>">
            <?= $this->getImage(['class' => 'lazy w-100', 'sizes' => '65x65x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $params['logo'], 'alt' => $params['name']]); ?>
        </a>
    </div>

    <div class="shop-info">
        <h3 class="shop-name mb-1"><a class="text-decoration-none text-uppercase text-primary-hover transition" href="<?= $params['hrefVideo'] ?>" title="<?= $params['name'] ?>"><?= $params['name'] ?></a></h3>
        <div class="shop-address mb-1"><strong class="pr-1">Địa chỉ:</strong><span><?= $this->joinPlace($params) ?></span></div>
        <div class="shop-view"><a class="text-decoration-none text-success" target="_blank" href="<?= $params['hrefMain'] ?>" title="Xem shop">Xem shop</a></div>
    </div>
</div>