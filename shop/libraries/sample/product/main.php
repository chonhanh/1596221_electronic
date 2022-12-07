<div class="<?= $params['product']['clsMain'] ?> <?= $params['product']['clsSmall'] ?> <?= $params['product']['clsNewPost'] ?> product position-relative rounded transition">
    <a class="product-image <?= $params['product']['imgDisabled'] ?> scale-img mb-1" <?= $params['product']['target'] ?> href="<?= $params['product']['href'] ?>" data-type="<?= $params['product']['sector']['type'] ?>" data-id="<?= $params['product']['id'] ?>" title="<?= $params['product']['name'] ?>">
        <?= $this->getImage(['class' => 'lazy w-100', 'sizes' => '700x350x1', 'upload' => UPLOAD_PRODUCT_THUMB, 'image' => $params['product']['photo'], 'alt' => $params['product']['name']]); ?>
    </a>
    <div class="product-info px-3 py-2 d-flex  <?= $params['product']['variant'] ?>">
        <?php
        if (!empty($params['product']['id_shop'])) {
            $params['product']['ownerLabel'] = 'Cửa hàng';
            $params['product']['ownerHref'] = '';
            $params['product']['ownerName'] = '<a class="text-decoration-none text-primary-hover transition" ' . $params['product']['target'] . ' href="' . $params['product']['ownerHref'] . '" title="' . $params['product']['shopName'] . '">' . $params['product']['shopName'] . '</a>';
            $params['product']['logo-image'] = $params['product']['shopLogo'];
            $params['product']['logo-error'] = '';
            $params['product']['logo-name'] = $params['product']['shopName'];
            $params['product']['logo-upload'] = UPLOAD_PHOTO_THUMB;
        } else if (!empty($params['product']['id_member'])) {
            $params['product']['ownerLabel'] = 'Cá nhân';
            $params['product']['ownerName'] = $params['product']['memberFullname'];
            $params['product']['ownerHref'] = $params['product']['href'];
            $params['product']['logo-image'] = $params['product']['memberAvatar'];
            $params['product']['logo-error'] = 'user.png';
            $params['product']['logo-name'] = $params['product']['memberFullname'];
            $params['product']['logo-upload'] = UPLOAD_USER_THUMB;
        } else if (!empty($params['product']['id_admin'])) {
            $params['product']['ownerLabel'] = 'Quản trị';
            $params['product']['ownerName'] = $params['product']['adminFullname'];
            $params['product']['ownerHref'] = $params['product']['href'];
            $params['product']['logo-image'] = $params['product']['adminAvatar'];
            $params['product']['logo-error'] = 'user.png';
            $params['product']['logo-name'] = $params['product']['adminFullname'];
            $params['product']['logo-upload'] = UPLOAD_USER_THUMB;
        }
        ?>

        <div class="product-variant-avatar">
            <a class="product-variant-avatar-image" <?= $params['product']['target'] ?> href="<?= $params['product']['ownerHref'] ?>" title="<?= $params['product']['logo-name'] ?>">
                <?= $this->getImage(['class' => 'lazy w-100', 'sizes' => '70x70x2', 'upload' => $params['product']['logo-upload'], 'image-error' => (!empty($params['product']['logo-error'])) ? $params['product']['logo-error'] : '', 'image' => $params['product']['logo-image'], 'alt' => $params['product']['logo-name']]); ?>
            </a>
        </div>
        <div class="product-variant">

            <?php if (!empty($params['product']['isAccount'])) { ?>
                <div class="product-account mb-1">
                    <div class="d-flex align-items-center justify-content-between border px-2 py-1 mb-2">
                        <div class="product-switch custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="product-<?= $params['product']['id'] ?>" <?= $params['statusUser']['active'] ?> value="<?= $params['product']['id'] ?>" data-name="<?= $params['product']['name'] ?>">
                            <label class="custom-control-label cursor-pointer pt-1" for="product-<?= $params['product']['id'] ?>"><?= $params['statusUser']['text'] ?></label>
                        </div>
                        <strong class="text-<?= $params['product']['statusCls'] ?> text-uppercase"><?= $params['product']['statusText'] ?></strong>
                    </div>
                    <div class="text-secondary">Đăng ngày: <?= date('d/m/Y', $params['product']['date_created']) ?></div>
                </div>
            <?php } ?>
            <div class="d-flex justify-content-between w-100">
                <div class="product-label ">

                    <h3 class="product-name mt-0 mb-1">
                        <a class="d-block <?= $params['product']['clsSmall'] ?> font-weight-500 text-decoration-none text-primary-hover text-uppercase transition" <?= $params['product']['target'] ?> href="<?= $params['product']['href'] ?>" data-type="<?= $params['product']['sector']['type'] ?>" data-id="<?= $params['product']['id'] ?>" title="<?= $params['product']['name'] ?>"><?= $params['product']['name'] ?></a>
                    </h3>
                    <div class="product-desc"><?= $params['product']['desc']?></div>
                </div>

                <div class="w-clear">
                    <a href="<?= $params['product']['href'] ?>" title="Xem chi tiết" class="button_more">Xem chi tiết</a>
                </div>
            </div>
            <div class="d-flex justify-content-between w-100">

            <?php if (!empty($params['product']['showInfo'])) {  ?>
                <div class="product-price my-1"><strong class="pr-1">Giá:</strong><span class="font-weight-bold text-danger"><?= $params['product']['regular_price'] . ' ' . $params['product']['priceType'] ?></span></div>


                
                <div class="product-variant-info">
                    <div class="product-datepost my-1"><strong class="pr-1">Ngày đăng:</strong><span><?= date('d/m/Y', $params['product']['date_created']) ?></span></div>
                </div>
            <?php  } ?>

                <?php if (!empty($params['product']['showFavourite'])) {
                    if (!empty($params['product']['isOwned'])) {
                        $activeFavourite = 'text-secondary';
                        $titleFavourite = 'Tin đăng thuộc quyền sở hữu của bạn';
                    } else {
                        if (!empty($params['product']['favourites']) && in_array($params['product']['id'], $params['product']['favourites'])) {
                            $activeFavourite = 'active';
                            $titleFavourite = 'Bỏ quan tâm (' . $params['product']['name'] . ')';
                        } else {
                            $activeFavourite = '';
                            $titleFavourite = 'Quan tâm (' . $params['product']['name'] . ')';
                        }
                    } ?>
                    <div class="product-favourite my-1 favourite-action <?= $params['product']['isOwned'] ?>" data-type="<?= $params['product']['sector']['type'] ?>" data-variant="product" data-id="<?= $params['product']['id'] ?>" data-text="<?= $params['product']['name'] ?>" data-plugin="tooltip" data-html="true" data-placement="top" title="<?= $titleFavourite ?>">Lưu tin <i class="fas fa-heart <?= $activeFavourite ?>"></i></div>
                <?php } ?>
            </div>
            

        </div>
    </div>

    <?php if (!empty($params['product']['isAccount']) && !empty($params['product']['status'])) { ?>
        <div class="product-tools">
            <?php if ($params['product']['status'] == 'xetduyet' || $params['product']['status'] == 'dangsai') { ?>
                <a class="btn btn-sm btn-outline-info mr-2" target="_blank" href="<?= $params['product']['href'] ?>" title="Chỉnh sửa"><small>Chỉnh sửa</small></a>
            <?php } ?>

            <a class="btn btn-sm btn-outline-success mr-2" target="_blank" href="<?= $params['product']['href-detail'] ?>" title="Chi tiết"><small>Chi tiết</small></a>
            <a class="btn btn-sm btn-outline-danger delete-posting-account" data-type="<?= $params['product']['sector']['type'] ?>" data-id="<?= $params['product']['id'] ?>" data-name="<?= $params['product']['name'] ?>" href="javascript:void(0)" title="Xóa tin"><small>Xóa tin</small></a>
        </div>
    <?php } ?>
</div>