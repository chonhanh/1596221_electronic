<div class="sector-group-cat d-flex flex-column align-items-start justify-content-start">
    <div class="sectors transition" id="main-cat">
        <a class="sectors-image scale-img" href="<?= $params['href-main'] ?>" title="<?= $params['name-main'] ?>">
            <?= $this->getImage(['class' => 'lazy w-100', 'sizes' => '290x300x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $params['photo'], 'alt' => $params['name-main']]); ?>
        </a>
        <h3 class="sectors-name d-flex align-items-center justify-content-center w-100 mt-3 mb-0 px-2 text-center">
            <a class="text-decoration-none text-split text-primary-hover text-uppercase transition" href="<?= $params['href-main'] ?>" title="<?= $params['name-main'] ?>"><?= $params['name-main'] ?></a>
        </h3>
    </div>
    <div class="sectors transition" id="store-cat">
        <a class="sectors-image scale-img" href="<?= $params['href-store'] ?>" title="<?= $params['name-store'] ?>">
            <?= $this->getImage(['class' => 'lazy w-100', 'sizes' => '290x300x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $params['photo2'], 'alt' => $params['name-store']]); ?>
        </a>
        <h3 class="sectors-name d-flex align-items-center justify-content-center w-100 mt-3 mb-0 px-2 text-center">
            <a class="text-decoration-none text-split text-primary-hover text-uppercase transition" href="<?= $params['href-store'] ?>" title="<?= $params['name-store'] ?>"><?= $params['name-store'] ?></a>
        </h3>
    </div>
</div>