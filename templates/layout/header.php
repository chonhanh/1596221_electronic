<div class="header" id="header">
    <div class="block-content d-flex align-items-center justify-content-between">

        <a class="header-logo text-decoration-none" href="" title="<?= $setting['name' . $lang] ?>">
            <?= $func->getImage(['sizes' => '240x0x3', 'upload' => UPLOAD_PHOTO_L, 'image' => $logo['photo'], 'alt' => $setting['name' . $lang]]) ?>
        </a>

        <a class="header-qrcode nav-icon text-decoration-none" href="" title="Trang chủ">
            <?= $func->getImage(['class' => 'lazy mr-2', 'size-error' => '40x40x2', 'upload' => 'assets/images/', 'image' => 'ic_home.png', 'alt' => 'Trang chủ']) ?>
            <span class="text-uppercase">Trang chủ</span>
        </a>

        <a class="sectors-by-list header-info nav-icon text-decoration-none" data-name = "<?=$config['website']['name']?>" data-id="<?=$config['website']['list']?>" href="javascript:void(0)" data-plugin="tooltip" data-placement="bottom" title="Danh mục chính">
            <?= $func->getImage(['class' => 'lazy mr-2', 'size-error' => '30x25x2', 'upload' => 'assets/images/', 'image' => 'ic_bar.png', 'alt' => 'Danh mục thời trang']) ?>
            <span class="text-uppercase">Danh mục<br><?=$config['website']['name']?></span>
        </a>

        <div class="header-search search-box shadow-primary-hover transition">
            <input type="text" id="keyword" placeholder="Tìm kiếm sản phẩm" onkeypress="doEnter(event,'keyword');" value="<?= (!empty($com) && $com == 'tim-kiem' && !empty($_GET['keyword'])) ? $_GET['keyword'] : '' ?>" autocomplete="off" />
            <span onclick="onSearch('keyword');"></span>
        </div>

        <?php if ($template == 'product/product' || $template == 'store/store' || $template == 'account/newsfeed' ) { ?>
        <a class="header-city show-city header-info nav-icon text-decoration-none" href="javascript:void(0)" title="Tỉnh thành">
            <?= $func->getImage(['class' => 'lazy mr-2', 'size-error' => '50x50x1', 'upload' => 'assets/images/', 'image' => 'ic_map.png', 'alt' => 'Tỉnh thành']) ?>
            <span class="text-uppercase">Chọn<br>Tỉnh thành</span>
        </a>
        <?php } ?>

        <?php /*if ($template != 'account/newsfeed') { ?>
            <a class="header-notify header-info nav-icon text-decoration-none" href="thong-bao" data-plugin="tooltip" data-placement="bottom" title="Các thông báo chính">
                <?= $func->getImage(['class' => 'lazy mr-2', 'size-error' => '50x50x1', 'upload' => 'assets/images/', 'image' => 'icon-notify.png', 'alt' => 'Thông báo']) ?>
                <span class="text-uppercase">Thông báo</span>
            </a>
        <?php }*/ ?>
        <?php if (!empty($func->getMember('active'))) { ?>
            <a class="header-account-dashboard header-info nav-icon text-decoration-none" href="<?=BASE_URL_API?>account/dashboard" data-plugin="tooltip" data-placement="bottom" title="Trang cá nhân">
                <?= $func->getImage(['class' => 'lazy rounded-circle mr-2', 'size-error' => '40x40x1', 'url' => $func->getMember('avatar'), 'alt' => 'Trang cá nhân']) ?>
                <span class="text-dark">Xin chào "<strong><?= $func->textConvert($func->getMember('last_name'), 'capitalize') ?></strong>"</span>
            </a>
            
        <?php } else { ?>
            <?php if ($template == 'account/login') { ?>
                <a class="header-login header-info nav-icon text-decoration-none" href="account/dang-ky" title="Đăng ký">
                    <?= $func->getImage(['class' => 'lazy mr-2', 'size-error' => '50x35x1', 'upload' => 'assets/images/', 'image' => 'icon-account.png', 'alt' => 'Đăng ký']) ?>
                    <span class="text-uppercase">Đăng ký</span>
                </a>
            <?php } else { ?>
                <a class="header-login header-info nav-icon go-login text-decoration-none" href="javascript:void(0)" title="Đăng nhập">
                    <?= $func->getImage(['class' => 'lazy mr-2', 'size-error' => '50x35x1', 'upload' => 'assets/images/', 'image' => 'icon-account.png', 'alt' => 'Đăng nhập']) ?>
                    <span class="text-uppercase">Đăng nhập</span>
                </a>
            <?php } ?>
        <?php } ?>
        <a class="header-cart" href="gio-hang" data-plugin="tooltip" data-trigger="focus" data-html="true" data-placement="bottom" title="<div class='text-left mb-2'><i class='fas fa-shopping-basket text-warning mr-1'></i><span class='text-white'>Giỏ hàng của bạn</span></div><a class='btn btn-sm btn-danger' href='gio-hang'>Xem giỏ hàng và thanh toán</a>">
            <?= $func->getImage(['size-error' => '35x30x2', 'upload' => 'assets/images/', 'image' => 'ic_cart.png', 'alt' => 'Giỏ hàng']) ?>
        </a>
    </div>
</div>