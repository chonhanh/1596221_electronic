<!-- Bar tools -->
<div class="block-bar border rounded-bottom px-2 bg-white transition mb-3">
    <div class="d-flex align-items-center justify-content-start py-2">
        <?php if (in_array($sector['type'], array($config['website']['sectors']))) { ?>
            <a class="nav-icon text-primary-hover text-decoration-none transition mr-3" href="javascript:void(0)" data-toggle="modal" data-target="#modal-sectors-cat" data-plugin="tooltip" data-placement="top" title="Các danh mục về <?= $func->get('sector-label') ?>">
                <?= $func->getImage(['class' => 'lazy mr-2', 'size-error' => '55x30x1', 'upload' => 'assets/images/', 'image' => 'icon-sectorCats.png', 'alt' => 'Danh mục ' . $func->get('sector-label')]) ?>
                <span>Danh mục <?= $func->get('sector-label') ?></span>
            </a>
        <?php } ?>

        <?php if ($template == 'product/product' || $template == 'store/store') { ?>
            <a class="show-district nav-icon text-primary-hover text-decoration-none transition mr-3" href="javascript:void(0)" data-label="<?= $func->get('district-label') ?>" data-plugin="tooltip" data-placement="top" title="Tìm kiếm tin đăng theo quận/huyện">
                <?= $func->getImage(['class' => 'lazy mr-2', 'size-error' => '50x35x1', 'upload' => 'assets/images/', 'image' => 'icon-district.png', 'alt' => 'Quận/Huyện']) ?>
                <span>Quận/Huyện</span>
            </a>
        <?php } ?>

        <a class="nav-icon text-primary-hover text-decoration-none transition mr-3" href="video?sector=<?= $sector['id'] ?>" data-plugin="tooltip" data-placement="top" title="Danh sách video về <?= $func->get('sector-label') ?>">
            <?= $func->getImage(['class' => 'lazy mr-2', 'size-error' => '50x35x1', 'upload' => 'assets/images/', 'image' => 'video.png', 'alt' => 'Video']) ?>
            <span>Video</span>
        </a>

        <?php if ($func->hasShop($sector)) { ?>
            <a class="go-shop nav-icon text-primary-hover text-decoration-none transition mr-3" href="javascript:void(0)" data-plugin="tooltip" data-placement="top" title="Tạo gian hàng kinh doanh về <?= $func->get('sector-label') ?>">
                <?= $func->getImage(['class' => 'lazy mr-2', 'size-error' => '50x35x1', 'upload' => 'assets/images/', 'image' => 'icon-shop.png', 'alt' => 'Đăng ký Gian Hàng']) ?>
                <span>Đăng ký Gian Hàng</span>
            </a>
        <?php } ?>

        <?php if (in_array($sector['type'], array($config['website']['sectors']))) { ?>
            <a class="go-posting nav-icon text-primary-hover text-decoration-none transition mr-3" href="javascript:void(0)" data-plugin="tooltip" data-placement="top" title="Đăng tin về <?= $func->get('sector-label') ?>">
                <?= $func->getImage(['class' => 'lazy mr-2', 'size-error' => '50x35x1', 'upload' => 'assets/images/', 'image' => 'icon-posting.png', 'alt' => 'Đăng tin Cá Nhân']) ?>
                <span>Đăng tin Cá Nhân</span>
            </a>
        <?php }  ?>

        <?php if ($source == 'product') { ?>
            <a class="nav-icon show-new-posting text-primary-hover text-decoration-none transition mr-3" href="javascript:void(0)" data-plugin="tooltip" data-placement="top" title="Đăng ký để nhận thông báo các tin mới của các lĩnh vực">
                <?= $func->getImage(['class' => 'lazy mr-2', 'size-error' => '50x35x1', 'upload' => 'assets/images/', 'image' => 'icon-new-posting.png', 'alt' => 'Đăng ký nhận Tin Mới']) ?>
                <span>Đăng ký nhận Tin Mới</span>
            </a>
        <?php } ?>

        <?php if ($template == 'product/product_detail' && $func->hasShop($sector)) { ?>
            <div class="product-search-shop search-block rounded d-flex align-items-center justify-content-start">
                <input class="search-text rounded-left" type="text" id="keyword-shop-<?= $sector['id'] ?>" placeholder="Tìm kiếm Cửa hàng" onkeypress="doEnter(event, 'keyword-shop|<?= $sector['id'] ?>');" autocomplete="off" />
                <div class="search-button rounded-right" onclick="onSearchShop('keyword-shop|<?= $sector['id'] ?>');">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="25" height="25" viewBox="0 0 24 24" stroke-width="1.5" stroke="#a0a0a0" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <circle cx="10" cy="10" r="7" />
                        <line x1="21" y1="21" x2="15" y2="15" />
                    </svg>
                </div>
            </div>
        <?php } ?>
    </div>
</div>