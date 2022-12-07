<div class="product-video <?= $params['clsMain'] ?> product position-relative rounded transition">
    <div class="product-photo position-relative mb-1">
        <a class="product-image scale-img rounded" <?= $params['target'] ?> href="<?= $params['href'] ?>" title="<?= $params['name'] ?>">
            <?= $this->getImage(['class' => 'lazy w-100', 'sizes' => '300x210x1', 'upload' => UPLOAD_PHOTO_L, 'image' => $params['photo'], 'alt' => $params['name']]); ?>
        </a>
        <a class="play-icon" <?= $params['target'] ?> href="<?= $params['href'] ?>" title="<?= $params['name'] ?>">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" height="55px" width="55px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                <path class="play-icon-stroke-solid" fill="none" stroke="white" d="M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7
				C97.3,23.7,75.7,2.3,49.9,2.5" />
                <path class="play-icon-stroke-dotted" fill="none" stroke="white" d="M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7
				C97.3,23.7,75.7,2.3,49.9,2.5" />
                <path class="play-icon-icon" fill="white" d="M38,69c-1,0.5-1.8,0-1.8-1.1V32.1c0-1.1,0.8-1.6,1.8-1.1l34,18c1,0.5,1,1.4,0,1.9L38,69z" />
            </svg>
        </a>
    </div>
    <div class="product-info px-1 py-2">
        <div class="product-label mb-1">

            <?php
            if (!empty($params['isOwned'])) {
                $activeFavourite = 'text-secondary';
                $titleFavourite = 'Tin đăng thuộc quyền sở hữu của bạn';
            } else {
                if (!empty($params['favourites']) && in_array($params['id'], $params['favourites'])) {
                    $activeFavourite = 'active';
                    $titleFavourite = 'Bỏ quan tâm (' . $params['name'] . ')';
                } else {
                    $activeFavourite = '';
                    $titleFavourite = 'Quan tâm (' . $params['name'] . ')';
                }
            }
            ?>

            <div class="product-favourite favourite-action <?= $params['isOwned'] ?>" data-type="<?= $params['sector']['type'] ?>" data-variant="product" data-id="<?= $params['id'] ?>" data-text="<?= $params['name'] ?>" data-plugin="tooltip" data-html="true" data-placement="top" title="<?= $titleFavourite ?>"><i class="fas fa-heart <?= $activeFavourite ?>"></i></div>

            <h3 class="product-name mt-0 mb-0">
                <a class="d-block font-weight-500 text-decoration-none text-primary-hover text-uppercase transition" <?= $params['target'] ?> href="<?= $params['href'] ?>" data-type="<?= $params['sector']['type'] ?>" data-id="<?= $params['id'] ?>" title="<?= $params['name'] ?>"><?= $params['name'] ?></a>
            </h3>
        </div>
        <div class="product-variant <?= $params['variant'] ?>">

            <?php if (empty($params['detailShop'])) { ?>
                <?php
                if (!empty($params['id_shop'])) {
                    $params['ownerLabel'] = 'Cửa hàng';
                    $params['ownerHref'] = 'shop/' . $params['shopUrl'] . '/';
                    $params['ownerName'] = '<a class="text-decoration-none text-primary-hover transition" ' . $params['target'] . ' href="' . $params['ownerHref'] . '" title="' . $params['shopName'] . '">' . $params['shopName'] . '</a>';
                    $params['logo-image'] = (!empty($params['shopLogo'])) ? $params['shopLogo'] : $params['sample']['interface'][$params['shopInterface']]['logo'];
                    $params['logo-error'] = '';
                    $params['logo-name'] = $params['shopName'];
                    $params['logo-upload'] = UPLOAD_PHOTO_L;
                } else if (!empty($params['id_member'])) {
                    $params['ownerLabel'] = 'Cá nhân';
                    $params['ownerName'] = $params['memberFullname'];
                    $params['ownerHref'] = $params['href'];
                    $params['logo-image'] = $params['memberAvatar'];
                    $params['logo-error'] = 'user.png';
                    $params['logo-name'] = $params['memberFullname'];
                    $params['logo-upload'] = UPLOAD_USER_L;
                } else if (!empty($params['id_admin'])) {
                    $params['ownerLabel'] = 'Quản trị';
                    $params['ownerName'] = $params['adminFullname'];
                    $params['ownerHref'] = $params['href'];
                    $params['logo-image'] = $params['adminAvatar'];
                    $params['logo-error'] = 'user.png';
                    $params['logo-name'] = $params['adminFullname'];
                    $params['logo-upload'] = UPLOAD_USER_L;
                }
                ?>

                <div class="product-variant-avatar">
                    <a class="product-variant-avatar-image" <?= $params['target'] ?> href="<?= $params['ownerHref'] ?>" title="<?= $params['logo-name'] ?>">
                        <?= $this->getImage(['class' => 'lazy w-100', 'sizes' => '65x65x2', 'upload' => $params['logo-upload'], 'image-error' => (!empty($params['logo-error'])) ? $params['logo-error'] : '', 'image' => $params['logo-image'], 'alt' => $params['logo-name']]); ?>
                    </a>
                </div>
                <div class="product-variant-info">
                    <div class="product-owner mb-1"><span class="pr-1"><?= $params['ownerLabel'] ?>:</span><span class="font-weight-500 text-capitalize"><?= $params['ownerName'] ?></span></div>
                    <div class="product-datepost mb-1"><strong class="pr-1">Ngày đăng:</strong><span><?= date('d/m/Y', $params['date_created']) ?></span></div>
                    <div class="product-address"><strong class="pr-1">Nơi đăng:</strong><span><?= $this->joinPlace($params) ?></span></div>
                </div>
            <?php } else { ?>
                <div class="product-variant-info w-100">
                    <div class="product-datepost mb-1"><strong class="pr-1">Ngày đăng:</strong><span><?= date('d/m/Y', $params['date_created']) ?></span></div>
                    <div class="product-address"><strong class="pr-1">Nơi đăng:</strong><span><?= $this->joinPlace($params) ?></span></div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>