<?php if ($source != "index") { ?>
    <div class="w-clear"></div>
    <div class="addPos mb-3">
        <div class="position-relative">
            <div class="box-Pos">
                <div class="box-menu p-3 ">
                    <!-- Stores -->
                    <?php if (in_array($sector['type'], array($config['website']['sectors'])) && !empty($stores)) { ?>
                        <div class="block-stores mb-2">
                            <div class="block-label d-flex align-items-center justify-content-between mb-2">
                                <div class="block-label-text">Danh sách cửa hàng <?= $func->get('sector-label') ?></div>
                            </div>
                            <div class="position-relative">
                                <div class="owl-page owl-carousel owl-theme" data-items="screen:0|items:3|margin:30" data-rewind="1" data-autoplay="1" data-loop="0" data-lazyload="0" data-mousedrag="1" data-touchdrag="1" data-smartspeed="500" data-autoplayspeed="500" data-autoplaytimeout="5000" data-autoplayhoverpause="1" data-dots="0" data-nav="1" data-navcontainer=".control-store">
                                    <?php foreach ($stores as $v_store) { ?>
                                        <div class="store">
                                            <a class="store-image rounded-main scale-img" href="cua-hang/<?= $v_store['slug' . $lang] ?>/<?= $v_store['id'] ?>?sector=<?= $sector['id'] ?>" title="<?= $v_store['name' . $lang] ?>">
                                                <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '300x240x1', 'upload' => UPLOAD_STORE_L, 'image' => $v_store['photo'], 'alt' => $v_store['name' . $lang]]) ?>
                                            </a>
                                            <h3 class="store-name w-100 mb-0 text-center">
                                                <a class="text-decoration-none text-primary-hover text-uppercase transition" href="cua-hang/<?= $v_store['slug' . $lang] ?>/<?= $v_store['id'] ?>?sector=<?= $sector['id'] ?>" title="<?= $v_store['name' . $lang] ?>"><?= $v_store['name' . $lang] ?></a>
                                            </h3>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="control-store control-owl transition <?= (count($stores) <= 4) ? 'd-none' : '' ?>"></div>
                            </div>
                        </div>
                    <?php } ?>


                    <!-- Filters -->
                    <div class="d-flex ">
                        <div class="block-filters border flex-grow-1">
                            <div class="d-flex  justify-content-around px-2 py-3">
                                <?php if ($func->hasShop($sectorListDetail)) { ?>
                                    <!-- By variant - All -->
                                    <div class="filter-variant-post mx-1">
                                        <a class="filter-icon variant-post text-primary-hover text-decoration-none transition <?= (!empty($variantPost) && $variantPost == 'all') ? 'active' : '' ?>" href="javascript:void(0)" data-variant-post="all" data-plugin="tooltip" data-placement="top" title="Lọc tin đăng của Cửa hàng và Cá nhân">
                                            <?= $func->getImage(['class' => 'lazy mb-2', 'size-error' => '35x35x2', 'upload' => 'assets/images/', 'image' => 'ic_all.png', 'alt' => 'Tất cả']) ?>
                                            <div class="">Tất cả</div>
                                        </a>
                                    </div>

                                    <!-- By variant - Shop -->
                                    <div class="filter-variant-post mx-1">
                                        <a class="filter-icon variant-post text-primary-hover text-decoration-none transition <?= (!empty($variantPost) && $variantPost == 'shop') ? 'active' : '' ?>" href="javascript:void(0)" data-variant-post="shop" data-plugin="tooltip" data-placement="top" title="Lọc tin đăng của Cửa hàng">
                                            <?= $func->getImage(['class' => 'lazy mb-2', 'size-error' => '30x30x2', 'upload' => 'assets/images/', 'image' => 'ic_shop.png', 'alt' => 'Tin đăng công ty']) ?>
                                            <div class="">Tin đăng<br>Công ty</div>
                                        </a>
                                    </div>

                                    <!-- By variant - Personal -->
                                    <div class="filter-variant-post mx-1">
                                        <a class="filter-icon variant-post text-primary-hover text-decoration-none transition <?= (!empty($variantPost) && $variantPost == 'personal') ? 'active' : '' ?>" href="javascript:void(0)" data-variant-post="personal" data-plugin="tooltip" data-placement="top" title="Lọc tin đăng của Cá nhân">
                                            <?= $func->getImage(['class' => 'lazy mb-2', 'size-error' => '30x30x2', 'upload' => 'assets/images/', 'image' => 'ic_user.png', 'alt' => 'Tin đăng cá nhân']) ?>
                                            <div class="">Tin đăng<br>Cá nhân</div>
                                        </a>
                                    </div>
                                <?php } ?>

                                <?php if ($func->get('formWork-active')) { ?>
                                    <!-- By form work -->
                                    <a class="filter-icon dropdown-icon text-primary-hover text-decoration-none transition mx-1" href="javascript:void(0)" data-toggle="modal" data-target="#modal-filter-form-work" data-plugin="tooltip" data-placement="top" title="Lọc tin đăng theo hình thức làm việc">
                                        <?= $func->getImage(['class' => 'lazy mb-2', 'size-error' => '70x50x1', 'upload' => 'assets/images/', 'image' => 'icon-form-work.png', 'alt' => $func->get('formWork-label')]) ?>
                                        <div class=""><?= $func->get('formWork-label') ?></div>
                                    </a>
                                <?php } ?>

                                <?php if ($func->get('priceRange-active')) { ?>
                                    <!-- By price range -->
                                    <a class="filter-icon dropdown-icon text-primary-hover text-decoration-none transition mx-1" href="javascript:void(0)" data-toggle="modal" data-target="#modal-filter-price-range" data-plugin="tooltip" data-placement="top" title="Lọc tin đăng theo <?= $func->textConvert($func->get('priceRange-label'), 'lower') ?>">
                                        <?= $func->getImage(['class' => 'lazy mb-2', 'size-error' => '70x50x1', 'upload' => 'assets/images/', 'image' => 'icon-price-range.png', 'alt' => $func->get('priceRange-label')]) ?>
                                        <div class=""><?= $func->get('priceRange-label') ?></div>
                                    </a>
                                <?php } ?>

                                <?php if ($func->get('acreage-active')) { ?>
                                    <!-- By acreage -->
                                    <a class="filter-icon dropdown-icon text-primary-hover text-decoration-none transition mx-1" href="javascript:void(0)" data-toggle="modal" data-target="#modal-filter-acreage" data-plugin="tooltip" data-placement="top" title="Lọc tin đăng theo diện tích">
                                        <?= $func->getImage(['class' => 'lazy mb-2', 'size-error' => '70x50x1', 'upload' => 'assets/images/', 'image' => 'icon-acreage.png', 'alt' => $func->get('acreage-label')]) ?>
                                        <div class=""><?= $func->get('acreage-label') ?></div>
                                    </a>
                                <?php } ?>

                                <!-- By date post -->
                                <a class="filter-icon dropdown-icon text-primary-hover text-decoration-none transition" href="javascript:void(0)" data-toggle="modal" data-target="#modal-filter-date-post" data-plugin="tooltip" data-placement="top" title="Lọc tin đăng theo thời gian đăng tin">
                                    <?= $func->getImage(['class' => 'lazy mb-2', 'size-error' => '70x50x1', 'upload' => 'assets/images/', 'image' => 'icon-date-post.png', 'alt' => $func->get('datePost-label')]) ?>
                                    <div class=""><?= $func->get('datePost-label') ?></div>
                                </a>
                            </div>

                        </div>
                        <div class="block-filters border dknt ml-3">
                            <div class="filter-variant-post px-3 py-2">
                                <a class="filter-icon variant-post text-primary-hover text-decoration-none transition show-new-posting" href="javascript:void(0)" title="Đăng ký nhận tin mới">
                                    <?= $func->getImage(['class' => 'lazy mb-1', 'size-error' => '60x65x2', 'upload' => 'assets/images/', 'image' => 'ic_dknt.png', 'alt' => 'Đăng ký nhận tin mới']) ?>
                                    <div class="text-uppercase">Đăng ký<br>Nhận tin mới</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php /*if (in_array($source, array('product', 'store'))) {
                        include TEMPLATE . "product/sectorBarCat.php";
                        include TEMPLATE . "product/barTools.php";
                    }*/ ?>
                            
                    <!-- Wards -->
                    <?php /*
                    <div class="block-wards text-right mb-2">
                        <a class="show-ward btn btn-outline-secondary dropdown-icon text-uppercase rounded-0" href="javascript:void(0)" data-label="<?= $func->get('ward-label') ?>" data-plugin="tooltip" data-placement="bottom" title="Tìm kiếm tin đăng theo phường/xã">Chọn phường/xã</a>
                    </div>
                    */ ?>
                    <!-- Sectors -->
                    <?php /*if (($func->hasService($sector) || $func->hasAccessary($sector)) && !empty($sectorItems)) {
                        $dataStatusPost = ($func->hasService($sector)) ? 'service' : (($func->hasAccessary($sector)) ? 'accessary' : ''); ?>
                        <div class="block-sectors filter-status-post form-row mb-3">
                            <a class="col col-left status-post-img status-post <?= (!empty($statusPost) && in_array($statusPost, array('service', 'accessary'))) ? 'active' : '' ?> position-relative lazy" data-status-post="<?= $dataStatusPost ?>" data-src="<?= ASSET . THUMBS ?>/240x340x1/<?= UPLOAD_PRODUCT_L . $sectorListDetail['photo3'] ?>" href="javascript:void(0)" data-plugin="tooltip" data-placement="top" title="Lọc các tin đăng về <?= ($dataStatusPost == 'service') ? 'dịch vụ giấy tờ' : (($dataStatusPost == 'accessary') ? 'phụ tùng xe' : '') ?>"><span class="transition"><?= ($dataStatusPost == 'service') ? 'Dịch vụ giấy tờ' : (($dataStatusPost == 'accessary') ? 'Phụ tùng xe' : '') ?></span></a>
                            <div class="col col-right">
                                <?php require_once TEMPLATE . "product/sectorItem.php"; ?>
                                <?php require_once TEMPLATE . "product/sectorSub.php"; ?>
                            </div>
                        </div>
                    <?php } else if (in_array($sector['type'], array('ung-vien', 'nha-tuyen-dung')) && !empty($sectorCats)) { ?>
                        <div class="block-label text-left mb-2">
                            <div class="block-label-text d-inline-block text-uppercase mr-4" id="job">Chợ Nhanh</div>
                            <div class="block-label-filter d-inline-block" id="job">
                                <strong class="mr-3"><?= $func->get('sector-label') ?></strong>
                                <span><?= $func->get('place-label') ?></span>
                            </div>
                        </div>
                        <div class="block-sectors mb-3">
                            <?php require_once TEMPLATE . "product/sectorCat.php"; ?>
                            <?php require_once TEMPLATE . "product/sectorItem.php"; ?>
                        </div>
                    <?php } else if (in_array($sector['type'], array('dien-tu', 'thoi-trang')) && !empty($sectorItems)) { ?>
                        <div class="block-sectors mb-3">
                            <?php require_once TEMPLATE . "product/sectorItem.php"; ?>
                            <?php require_once TEMPLATE . "product/sectorSub.php"; ?>
                        </div>
                    <?php }*/ ?>

                </div>
                <div class="box-hide-dm bt_hide" data-cont=".addPos">
                    <div class="bt_open">Mở danh sách cửa hàng và bảng điều khiển</div>
                    <div class="bt_close">Đóng danh sách cửa hàng và bảng điều khiển</div>      
                </div>
            </div>
        </div>
    </div>

    <!-- Filters actived -->
    <?php if (!empty($FiltersActived)) { ?>
        <div class="block-filters-actived mb-3">
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
                    <div class="filter-remove-all-posting-criteria mb-1">
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
<?php } ?>

<!-- Products -->
<div class="block-products">
    <?php if (!empty($products)) { ?>
        <div class="">
            <?php foreach ($products as $v_product) {
                $v_product['name'] = $v_product['name' . $lang];
                $v_product['desc'] = $v_product['desc' . $lang];
                $v_product['href'] = $sector['type'] . '/' . $v_product[$sluglang] . '/' . $v_product['id'];
                $v_product['sector'] = $sector;
                $v_product['clsMain'] = 'product-shadow';
                $v_product['favourites'] = (!empty($favourites)) ? $favourites : array();
                $v_product['showFavourite'] = true;
                $v_product['showInfo'] = true;
                $v_product['idMember'] = $idMember;
                $v_product['ownedShop'] = (!empty($ownedShop)) ? $ownedShop : array();
                $v_product['sample'] = (!empty($sampleData)) ? $sampleData : array();
                $v_product['priceType'] = $variation->get($tableProductVariation, $v_product['id'], 'loai-gia', $lang);
            ?>

                <div class="w-clear mb-3"><?= $func->getProduct($v_product) ?></div>
            <?php } ?>
        </div>
        
        <div class="pagination-home w-100"><?= (!empty($paging)) ? $paging : '' ?></div>
    <?php } else { ?>
        <div class="alert alert-warning w-100" role="alert">
            <strong><?= khongtimthayketqua ?></strong>
        </div>
    <?php } ?>
   

    <!-- Lists posting ID -->
    <div class="lists-posting-id d-none">
        <input type="hidden" id="id-cat" value="<?= (!empty($IDCat)) ? $IDCat : '' ?>">
        <input type="hidden" id="id-item" value="<?= (!empty($IDItem)) ? $IDItem : '' ?>">
        <input type="hidden" id="id-sub" value="<?= (!empty($IDSub)) ? $IDSub : '' ?>">
        <input type="hidden" id="id-city" value="<?= (!empty($IDCity)) ? $IDCity : '' ?>">
        <input type="hidden" id="id-district" value="<?= (!empty($IDDistrict)) ? $IDDistrict : '' ?>">
        <input type="hidden" id="id-ward" value="<?= (!empty($IDWard)) ? $IDWard : '' ?>">
        <input type="hidden" id="id-variant-post" value="<?= (!empty($variantPost)) ? $variantPost : '' ?>">
        <input type="hidden" id="id-form-work" value="<?= (!empty($IDFormWork)) ? $IDFormWork : '' ?>">
        <input type="hidden" id="id-price-range" value="<?= (!empty($IDPriceRange)) ? $IDPriceRange : '' ?>">
        <input type="hidden" id="id-acreage" value="<?= (!empty($IDAcreage)) ? $IDAcreage : '' ?>">
        <input type="hidden" id="id-date-post" value="<?= (!empty($IDDatePost)) ? $IDDatePost : '' ?>">
        <input type="hidden" id="id-status-post" value="<?= (!empty($statusPost)) ? $statusPost : '' ?>">
    </div>
</div>