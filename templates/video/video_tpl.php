<?php if (empty($IDSector)) { ?>
    <div class="title-main"><span><?= @$title_crumb ?></span></div>
    <div class="content-main">
        <div class="form-row">
            <?php foreach ($sectors as $v_sector) { ?>
                <div class="col-4 mb-3">
                    <div class="sectors sectors-list">
                        <a class="sectors-image scale-img" href="video?sector=<?= $v_sector['id'] ?>" title="<?= $v_sector['name' . $lang] ?>">
                            <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '380x275x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v_sector['photo'], 'alt' => $v_sector['name' . $lang]]) ?>
                        </a>
                        <h3 class="sectors-name d-flex align-items-center justify-content-center w-100 mt-3 mb-0 px-2 text-center">
                            <a class="text-decoration-none text-primary-hover text-uppercase transition" href="video?sector=<?= $v_sector['id'] ?>" title="<?= $v_sector['name' . $lang] ?>"><?= $v_sector['name' . $lang] ?></a>
                        </h3>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } else { ?>
    <div class="content-main">
        <div class="video-sectors form-row mb-4">
            <div class="col-3">
                <div class="sector-list-video">
                    <div class="sector-list-video-image">
                        <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '200x200x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $detailSector['photo'], 'alt' => $detailSector['name' . $lang]]) ?>
                    </div>
                    <div class="sector-list-video-name text-uppercase text-center p-2"><?= $detailSector['name' . $lang] ?></div>
                </div>
            </div>
            <div class="col-9">
                <?php if (!empty($sectorCats)) { ?>
                    <div class="sector-scroll-cats sector-scroll custom-mcsrcoll-x filter-cat-video d-flex align-items-start justify-content-start border p-2 mb-3">
                        <?php foreach ($sectorCats as $v_cat) { ?>
                            <div class="sectors sectors-cat float-left mr-2 <?= (!empty($IDCat) && $IDCat == $v_cat['id']) ? 'active' : '' ?>" data-id="<?= $v_cat['id'] ?>">
                                <a class="sectors-image scale-img" href="javascript:void(0)" title="<?= $v_cat['name' . $lang] ?>">
                                    <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '290x300x1', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v_cat['photo'], 'alt' => $v_cat['name' . $lang]]) ?>
                                </a>
                                <h3 class="sectors-name font-weight-bold d-flex align-items-center justify-content-center w-100 mt-2 mb-0 px-2 text-center">
                                    <a class="text-decoration-none text-primary-hover <?= (!empty($IDCat) && $IDCat == $v_cat['id']) ? 'active' : '' ?> text-uppercase text-split transition" href="javascript:void(0)" title="<?= $v_cat['name' . $lang] ?>"><?= $v_cat['name' . $lang] ?></a>
                                </h3>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="video-filters d-flex align-items-center justify-content-start">
                    <?php if ($func->hasShop($detailSector)) { ?>
                        <!-- Search shop -->
                        <div class="video-search-shop search-block d-flex align-items-center justify-content-start mr-3">
                            <input class="search-text" type="text" id="keyword" placeholder="Tìm kiếm trang video Cửa hàng" onkeypress="doEnter(event, 'keyword-video-shop');" value="<?= (!empty($_GET['keyword']) && $com == 'tim-kiem-cua-hang-video') ? $_GET['keyword'] : '' ?>" autocomplete="off" />
                            <div class="search-button" onclick="onSearchVideo('keyword-video-shop');">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="25" height="25" viewBox="0 0 24 24" stroke-width="1.5" stroke="#a0a0a0" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <circle cx="10" cy="10" r="7" />
                                    <line x1="21" y1="21" x2="15" y2="15" />
                                </svg>
                            </div>
                        </div>

                        <?php if (empty($shopDetail)) { ?>
                            <!-- By variant - All -->
                            <div class="filter-variant-video mr-3">
                                <a class="nav-icon filter-icon variant-post text-primary-hover text-decoration-none transition <?= (!empty($variantPost) && $variantPost == 'all') ? 'active' : '' ?>" id="all" href="javascript:void(0)" data-variant-post="all" data-plugin="tooltip" data-placement="top" title="Lọc video của Cửa hàng và Cá nhân">
                                    <?= $func->getImage(['class' => 'lazy mr-2', 'sizes' => '40x0x3', 'upload' => 'assets/images/', 'image' => 'icon-filter-all.png', 'alt' => 'Tất cả']) ?>
                                    <span class="font-weight-normal">Tất cả</span>
                                </a>
                            </div>

                            <!-- By variant - Shop -->
                            <div class="filter-variant-video mr-3">
                                <a class="nav-icon filter-icon variant-post text-primary-hover text-decoration-none transition <?= (!empty($variantPost) && $variantPost == 'shop') ? 'active' : '' ?>" id="shop" href="javascript:void(0)" data-variant-post="shop" data-plugin="tooltip" data-placement="top" title="Lọc video của Cửa hàng">
                                    <?= $func->getImage(['class' => 'lazy mr-2', 'sizes' => '25x0x3', 'upload' => 'assets/images/', 'image' => 'icon-filter-shop.png', 'alt' => 'Video cửa hàng']) ?>
                                    <span class="font-weight-normal">Video Cửa hàng</span>
                                </a>
                            </div>

                            <!-- By variant - Personal -->
                            <div class="filter-variant-video mr-3">
                                <a class="nav-icon filter-icon variant-post text-primary-hover text-decoration-none transition <?= (!empty($variantPost) && $variantPost == 'personal') ? 'active' : '' ?>" id="personal" href="javascript:void(0)" data-variant-post="personal" data-plugin="tooltip" data-placement="top" title="Lọc video của Cá nhân">
                                    <?= $func->getImage(['class' => 'lazy mr-2', 'sizes' => '25x0x3', 'upload' => 'assets/images/', 'image' => 'icon-filter-personal.png', 'alt' => 'Video cá nhân']) ?>
                                    <span class="font-weight-normal">Video Cá nhân</span>
                                </a>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <!-- By date post -->
                    <a class="nav-icon filter-icon dropdown-icon text-primary-hover text-decoration-none transition" href="javascript:void(0)" data-toggle="modal" data-target="#modal-filter-date-post" data-plugin="tooltip" data-placement="top" title="Lọc video theo thời gian đăng">
                        <?= $func->getImage(['class' => 'lazy mr-2', 'sizes' => '25x0x3', 'upload' => 'assets/images/', 'image' => 'icon-date-post.png', 'alt' => 'Thời gian đăng video']) ?>
                        <span class="font-weight-normal mt-0">Thời gian đăng video</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters actived -->
        <?php if (!empty($FiltersActived)) { ?>
            <div class="block-filters-actived mb-4">
                <div class="d-flex flex-wrap align-items-center justify-content-start py-2">
                    <?php foreach ($FiltersActived as $v_filter) { ?>
                        <div class="<?= $v_filter['clsFilter'] ?> mr-1 mb-1">
                            <div class="btn btn-sm btn-primary filter-remove <?= $v_filter['clsMain'] ?>" data-remove="true">
                                <span class="text-white"><?= $v_filter['name'] ?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x align-top pt-1 pl-1" width="18" height="18" viewBox="0 0 24 24" stroke-width="2.5" stroke="#ffc107" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (count($FiltersActived) >= 2) { ?>
                        <div class="filter-remove-all-video-criteria mb-1">
                            <div class="btn btn-sm btn-danger filter-remove">
                                <span class="text-white">Xóa tất cả</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x align-top pt-1 pl-1" width="18" height="18" viewBox="0 0 24 24" stroke-width="2.5" stroke="#ffc107" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <?php if (!empty($shops)) { ?>
            <div class="title-main"><span><?= @$title_crumb ?></span></div>
            <div class="content-main">
                <div class="form-row">
                    <?php foreach ($shops as $v_shop) { ?>
                        <?php
                        $v_shop['hrefMain'] = $configBaseShop . $v_shop['slug_url'] . '/';
                        $v_shop['hrefVideo'] = $configBase . 'video?sector=' . $sector['id'] . '&shop=' . $v_shop['id'];
                        $v_shop['sample'] = !empty($sampleData) ? $sampleData : array();
                        ?>
                        <div class="col-4 mb-3"><?= $func->getShopMini($v_shop) ?></div>
                    <?php } ?>
                </div>
                <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
            </div>
            <?php } else if (!empty($shopDetail) || !empty($videos)) {
            if (!empty($shopDetail)) { ?>
                <div class="shop-panel mb-4">
                    <div class="shop-panel-avatar">
                        <a class="shop-panel-avatar-image" target="_blank" href="<?= $shopDetail['href'] ?>" title="<?= $shopDetail['name'] ?>">
                            <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '85x85x2', 'upload' => UPLOAD_PHOTO_L, 'image' => $shopDetail['logo'], 'alt' => $shopDetail['name']]) ?>
                        </a>
                    </div>
                    <div class="shop-panel-info">
                        <div class="shop-panel-name font-weight-bold text-uppercase mb-2"><?= $shopDetail['name'] ?></div>
                        <ul class="shop-panel-params list-unstyled mb-3 p-0">
                            <li class="d-inline-block align-top mr-3 mb-1" id="subscribe"><i class="fas fa-heart <?= $shopDetail['subscribeActive'] ?> align-top mr-2"></i><span class="d-inline-block font-weight-500"><?= $func->shortNumber($shopDetail['subscribeNumb']) ?> người quan tâm trang</span></li>
                            <li class="d-inline-block align-top mr-3 mb-1"><?= $func->getImage(['class' => 'lazy mr-2', 'sizes' => '28x0x3', 'upload' => 'assets/images/', 'image' => 'video.png', 'alt' => 'Trang có: ' . $total . ' video']) ?><span class="d-inline-block align-top">Trang có: <b class="font-weight-500"><?= $total ?></b> video</span></li>
                            <li class="d-inline-block align-top" id="favourite"><i class="fas fa-heart <?= $shopDetail['favouriteActive'] ?> align-top mr-2"></i><span class="d-inline-block font-weight-500"><?= $func->shortNumber($shopDetail['favourited-product-members']) ?> người quan tâm sản phẩm</span></li>
                        </ul>
                        <div class="shop-panel-control">
                            <?php if (empty($ownedShop)) { ?>
                                <a class="shop-panel-subscribe btn btn-sm <?= (!empty($shopDetail['subscribeActive'])) ? 'btn-danger' : 'btn-primary' ?> subscribe-button font-weight-500 text-uppercase rounded-0 mr-2 py-2 px-3" href="javascript:void(0)" data-id="<?= $IDShop ?>" title="<?= (!empty($shopDetail['subscribeActive'])) ? 'Đã quan tâm' : 'Quan tâm trang' ?>"><?= (!empty($shopDetail['subscribeActive'])) ? 'Đã quan tâm' : 'Quan tâm trang' ?></a>
                            <?php } ?>
                            <a class="shop-panel-view btn btn-sm btn-success font-weight-500 text-uppercase rounded-0 py-2 px-3" target="_blank" href="<?= $shopDetail['href'] ?>" title="Xem shop">Xem shop</a>
                        </div>
                    </div>
                </div>
            <?php }
            if (!empty($videos)) { ?>
                <div class="video-loader">
                    <div class="form-row">
                        <?php foreach ($videos as $k_video => $v_video) {
                            $v_video['clsMain'] = 'product-shadow';
                            $v_video['name'] = $v_video['videoName' . $lang];
                            $v_video['photo'] = $v_video['videoPhoto'];
                            $v_video['href'] = $sector['type'] . '/' . $v_video[$sluglang] . '/' . $v_video['id'] . '?video=' . $v_video['videoId'];
                            $v_video['sector'] = $sector;
                            $v_video['favourites'] = (!empty($favourites)) ? $favourites : array();
                            $v_video['idMember'] = $idMember;
                            $v_video['ownedShop'] = (!empty($ownedShop)) ? $ownedShop : array();
                            $v_video['detailShop'] = (!empty($shopDetail)) ? true : false;
                            $v_video['sample'] = (!empty($sampleData)) ? $sampleData : array(); ?>
                            <div class="col-3 mb-4"><?= $func->getVideo($v_video) ?></div>
                        <?php } ?>
                    </div>
                </div>
                <?php if ($total > $limitLoad['show']) { ?>
                    <div class="load-more-control text-center" id="video">
                        <input type="hidden" class="limit-from" value="<?= $limitLoad['show'] ?>">
                        <input type="hidden" class="limit-get" value="<?= $limitLoad['get'] ?>">
                        <a class="load-more-button d-inline-block align-top text-primary-hover text-decoration-none text-uppercase transition" id="video">
                            <span class="d-inline-block align-top transition">Xem thêm video ngành <?= $detailSector['name' . $lang] ?></span>
                        </a>
                    </div>
                <?php }
            } else { ?>
                <div class="alert alert-warning w-100" role="alert">
                    <strong><?= khongtimthayketqua ?></strong>
                </div>
            <?php }
        } else { ?>
            <div class="alert alert-warning w-100" role="alert">
                <strong><?= khongtimthayketqua ?></strong>
            </div>
        <?php } ?>

        <!-- Lists video ID -->
        <div class="lists-video-id d-none">
            <input type="hidden" id="id-shop" value="<?= (!empty($IDShop)) ? $IDShop : '' ?>">
            <input type="hidden" id="id-cat" value="<?= (!empty($IDCat)) ? $IDCat : '' ?>">
            <input type="hidden" id="id-variant-post" value="<?= (!empty($variantPost)) ? $variantPost : '' ?>">
            <input type="hidden" id="id-date-post" value="<?= (!empty($IDDatePost)) ? $IDDatePost : '' ?>">
        </div>
    </div>
<?php } ?>