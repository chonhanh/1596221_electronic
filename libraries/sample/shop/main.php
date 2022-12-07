<div class="<?= $params['shop']['clsMain'] ?> <?= $params['shop']['clsSmall'] ?> shop">
    <a class="shop-image <?= $params['shop']['imgDisabled'] ?> scale-img mb-3" <?= $params['shop']['target'] ?> href="<?= $params['shop']['href'] ?>" title="<?= $params['shop']['name'] ?>">
        <?= $this->getImage(['class' => 'lazy w-100', 'sizes' => '330x310x2', 'upload' => UPLOAD_SHOP_L, 'image' => $params['shop']['photo'], 'alt' => $params['shop']['name']]); ?>
    </a>
    <?php /*
    <div class="shop-rating px-2" data-id="<?= $params['shop']['id'] ?>">
        <div id="star-rating-<?= $params['shop']['id'] ?>" data-rating="<?= $params['shop']['rating'] ?>"></div>
    </div>
    */ ?>
    <div class="shop-content">
        <div class="shop-logo">
            <a class="shop-logo-image" <?= $params['shop']['target'] ?> href="<?= $params['shop']['href'] ?>" title="<?= $params['shop']['name'] ?>">
                <?= $this->getImage(['class' => 'lazy w-100', 'sizes' => '70x70x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $params['shop']['logo'], 'alt' => $params['shop']['name']]); ?>
            </a>
        </div>

        <div class="shop-info">
            <h3 class="shop-name mb-1"><a class="text-decoration-none text-uppercase text-primary-hover transition" <?= $params['shop']['target'] ?> href="<?= $params['shop']['href'] ?>" title="<?= $params['shop']['name'] ?>"><?= $params['shop']['name'] ?></a></h3>
            <div class="shop-address mb-1"><strong class="pr-1">Địa chỉ:</strong><span><?= $this->joinPlace($params['shop']) ?></span></div>

            <?php $activeFavourite = ((!empty($params['shop']['memberSubscribe']) && in_array($params['shop']['id'], $params['shop']['memberSubscribe']))) ? 'active' : ''; ?>

            <div class="shop-subscribe-count"><span class="text-capitalize"><?= $this->shortNumber($params['shop']['subscribeNumb']) ?></span> <strong>người quan tâm</strong><i class="fas fa-heart <?= $activeFavourite ?> ml-1"></i></div>
        </div>
    </div>

    <?php if (!empty($params['shop']['isAccount'])) { ?>
        <div class="shop-account mt-3 mb-1">
            <div class="d-flex align-items-center justify-content-between border px-2 py-1 mb-2">
                <div class="shop-switch custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="shop-<?= $params['shop']['id'] ?>" <?= $params['statusUser']['active'] ?> value="<?= $params['shop']['id'] ?>" data-name="<?= $params['shop']['name'] ?>">
                    <label class="custom-control-label cursor-pointer pt-1" for="shop-<?= $params['shop']['id'] ?>"><?= $params['statusUser']['text'] ?></label>
                </div>
                <strong class="text-<?= $params['shop']['statusCls'] ?> text-uppercase"><?= $params['shop']['statusText'] ?></strong>
            </div>
            <div class="text-secondary">Ngày tạo: <?= date('d/m/Y', $params['shop']['date_created']) ?></div>
        </div>

        <?php if (!empty($params['shop']['status'])) { ?>
            <div class="shop-tools mt-2">
                <?php if ($params['shop']['status'] == 'xetduyet' || $params['shop']['status'] == 'dangsai') { ?>
                    <a class="btn btn-sm btn-outline-info mr-2" target="_blank" href="<?= $params['shop']['href'] ?>" title="Chỉnh sửa"><small>Chỉnh sửa</small></a>
                <?php } ?>

                <a class="btn btn-sm btn-outline-success mr-2" target="_blank" href="<?= $params['shop']['href-detail'] ?>" title="Xem shop"><small>Xem shop</small></a>

                <a class="btn btn-sm btn-outline-danger delete-shop-account" data-type="<?= $params['shop']['sector']['type'] ?>" data-id="<?= $params['shop']['id'] ?>" data-name="<?= $params['shop']['name'] ?>" href="javascript:void(0)" title="Xóa shop"><small>Xóa shop</small></a>
            </div>
        <?php } ?>
    <?php } ?>
</div>