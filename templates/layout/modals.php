    <!-- Modal sectors -->
    <div class="modal modal-general fade" id="modal-sectors" tabindex="-1" role="dialog" aria-labelledby="modal-sectors-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal-sectors-label">Danh mục chính</div>
                    <div class="modal-close" data-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="modal-data form-row"></div>
                </div>
            </div>
        </div>
    </div>

<?php if (!empty($sectorCats) && in_array($sector['type'], array($config['website']['sectors']))) { ?>
    <!-- Modal sectors cat -->
    <div class="modal modal-general fade" id="modal-sectors-cat" tabindex="-1" role="dialog" aria-labelledby="modal-sectors-cat-label" aria-hidden="true">
        <div class="modal-dialog w-dialog-1190" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal-sectors-cat-label">Danh mục <?= $func->get('sector-label') ?></div>
                    <div class="modal-close" data-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="modal-data form-row <?= $func->get('actionClsModal-cat-clsMain') ?>">
                        <?php foreach ($sectorCats as $v_cat) { ?>
                            <div class="col-2 mb-3">
                                <div class="sectors sectors-cat <?= (!empty($IDCat) && $IDCat == $v_cat['id']) ? 'active' : '' ?>" data-id="<?= $v_cat['id'] ?>">
                                    <a class="sectors-image scale-img" href="javascript:void(0)" title="<?= $v_cat['name' . $lang] ?>">
                                        <?= $func->getImage(['class' => 'lazy w-100', 'sizes' => '290x300x2', 'upload' => UPLOAD_PRODUCT_L, 'image' => $v_cat['photo'], 'alt' => $v_cat['name' . $lang]]) ?>
                                    </a>
                                    <h3 class="sectors-name d-flex align-items-center justify-content-center w-100 mt-2 mb-0 px-2 text-center">
                                        <a class="text-decoration-none text-primary-hover <?= (!empty($IDCat) && $IDCat == $v_cat['id']) ? 'active' : '' ?> text-uppercase transition" href="javascript:void(0)" title="<?= $v_cat['name' . $lang] ?>"><?= $v_cat['name' . $lang] ?></a>
                                    </h3>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($func->get('formWork-active')) { ?>
    <!-- Modal filter form work -->
    <div class="modal modal-general fade" id="modal-filter-form-work" tabindex="-1" role="dialog" aria-labelledby="modal-filter-form-work-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal-filter-form-work-label"><?= $func->get('formWork-label') ?></div>
                    <div class="modal-close" data-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="modal-data">
                        <div class="px-3">
                            <div class="modal-data modal-grid filter-form-work row">
                                <?php if ($func->has('formWork-data')) {
                                    foreach ($func->get('formWork-data') as $v_formwork) { ?>
                                        <a class="col-grid col-12 form-work text-decoration-none text-primary-hover transition p-2 ml-0 <?= (!empty($IDFormWork) && $IDFormWork == $v_formwork['id']) ? 'active' : '' ?>" href="javascript:void(0)" data-id="<?= $v_formwork['id'] ?>" title="<?= $v_formwork['name' . $lang] ?>"><?= $v_formwork['name' . $lang] ?></a>
                                <?php }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($func->get('priceRange-active')) { ?>
    <!-- Modal filter price range -->
    <div class="modal modal-general fade" id="modal-filter-price-range" tabindex="-1" role="dialog" aria-labelledby="modal-filter-price-range-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal-filter-price-range-label"><?= $func->get('priceRange-label') ?></div>
                    <div class="modal-close" data-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="px-3">
                        <div class="modal-data modal-grid filter-price-range row">
                            <?php if ($func->has('priceRange-data')) {
                                foreach ($func->get('priceRange-data') as $v_pricerange) { ?>
                                    <a class="col-grid col-12 price-range text-decoration-none text-primary-hover transition p-2 ml-0 <?= (!empty($IDPriceRange) && $IDPriceRange == $v_pricerange['id']) ? 'active' : '' ?>" href="javascript:void(0)" data-id="<?= $v_pricerange['id'] ?>" title="<?= $v_pricerange['name' . $lang] ?>"><?= $v_pricerange['name' . $lang] ?></a>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($func->get('acreage-active')) { ?>
    <!-- Modal filter acreage -->
    <div class="modal modal-general fade" id="modal-filter-acreage" tabindex="-1" role="dialog" aria-labelledby="modal-filter-acreage-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal-filter-acreage-label"><?= $func->get('acreage-label') ?></div>
                    <div class="modal-close" data-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="modal-data">
                        <div class="px-3">
                            <div class="modal-data modal-grid filter-acreage row">
                                <?php if ($func->has('acreage-data')) {
                                    foreach ($func->get('acreage-data') as $v_acreage) { ?>
                                        <a class="col-grid col-12 acreage text-decoration-none text-primary-hover transition p-2 ml-0 <?= (!empty($IDAcreage) && $IDAcreage == $v_acreage['id']) ? 'active' : '' ?>" href="javascript:void(0)" data-id="<?= $v_acreage['id'] ?>" title="<?= $v_acreage['name' . $lang] ?>"><?= $v_acreage['name' . $lang] ?></a>
                                <?php }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($func->get('datePost-active')) { ?>
    <!-- Modal filter date post -->
    <div class="modal modal-general fade" id="modal-filter-date-post" tabindex="-1" role="dialog" aria-labelledby="modal-filter-date-post-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal-filter-date-post-label"><?= $func->get('datePost-label') ?></div>
                    <div class="modal-close" data-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="modal-data">
                        <div class="px-3">
                            <div class="modal-data modal-grid <?= $func->get('datePost-clsFilter') ?> row">
                                <?php if ($func->has('datePost-data')) {
                                    foreach ($func->get('datePost-data') as $v_datepost) { ?>
                                        <a class="col-grid col-12 <?= $func->get('datePost-clsMain') ?> text-decoration-none text-primary-hover transition p-2 ml-0 <?= (!empty($IDDatePost) && $IDDatePost == $v_datepost['id']) ? 'active' : '' ?>" href="javascript:void(0)" data-id="<?= $v_datepost['id'] ?>" title="<?= $v_datepost['name' . $lang] ?>"><?= $v_datepost['name' . $lang] ?></a>
                                <?php }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Sector cat for posting -->
<div class="modal modal-general fade" id="modal-sector-posting" tabindex="-1" role="dialog" aria-labelledby="modal-sector-posting-label" aria-hidden="true">
    <div class="modal-dialog w-dialog-1190" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="modal-sector-posting-label"></div>
                <div class="modal-close" data-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </div>
            </div>
            <div class="modal-body">
                <div class="modal-data"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal places -->
<div class="modal modal-general fade" id="modal-places" tabindex="-1" role="dialog" aria-labelledby="modal-place-label" aria-hidden="true">
    <div class="modal-dialog w-dialog-1190" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="modal-place-label"></div>
                <div class="modal-close" data-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </div>
            </div>
            <div class="modal-body">
                <div class="modal-data <?= $func->get('actionClsModal-city-clsMain') ?>"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal district -->
<div class="modal modal-general fade" id="modal-districts" tabindex="-1" role="dialog" aria-labelledby="modal-districts-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="modal-districts-label"></div>
                <div class="modal-close" data-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </div>
            </div>
            <div class="modal-body">
                <div class="px-3">
                    <div class="modal-data modal-grid <?= $func->get('actionClsModal-district-clsMain') ?> row"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal ward -->
<div class="modal modal-general fade" id="modal-wards" tabindex="-1" role="dialog" aria-labelledby="modal-wards-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="modal-wards-label"></div>
                <div class="modal-close" data-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </div>
            </div>
            <div class="modal-body">
                <div class="px-3">
                    <div class="modal-data modal-grid <?= $func->get('actionClsModal-ward-clsMain') ?> row"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($func->getMember('active')) { ?>
    <!-- Modal new posting -->
    <div class="modal modal-general fade" id="modal-new-posting" tabindex="-1" role="dialog" aria-labelledby="modal-new-posting-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal-new-posting-label"></div>
                    <div class="modal-close" data-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="form-new-posting" method="post" action="" enctype="multipart/form-data">
                        <div class="modal-data"></div>
                        <div class="text-center">
                            <input type="submit" class="btn btn-sm btn-primary d-inline-block text-capitalize py-2 px-3" name="new-posting" value="Đăng ký">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Modal stores -->
<div class="modal modal-general fade" id="modal-stores" tabindex="-1" role="dialog" aria-labelledby="modal-store-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="modal-store-label"></div>
                <div class="modal-close" data-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </div>
            </div>
            <div class="modal-body">
                <div class="modal-data"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal video -->
<div class="modal modal-general fade" id="modal-video" tabindex="-1" role="dialog" aria-labelledby="modal-video-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="modal-video-label"></div>
                <div class="modal-close" data-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </div>
            </div>
            <div class="modal-body p-0">
                <div class="modal-data"></div>
            </div>
        </div>
    </div>
</div>

<?php if ($func->getMember('active')) { ?>
    <!-- Modal interface -->
    <div class="modal modal-general fade" id="modal-interface" tabindex="-1" role="dialog" aria-labelledby="modal-interface-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal-interface-label"></div>
                    <div class="modal-close" data-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                </div>
                <div class="modal-body p-0">
                    <div class="modal-data"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal learn-shop -->
    <div class="modal modal-general fade" id="modal-learn-shop" tabindex="-1" role="dialog" aria-labelledby="modal-learn-shop-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal-learn-shop-label"></div>
                    <div class="modal-close" data-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                </div>
                <div class="modal-body p-0">
                    <div class="modal-data"></div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if ($func->getMember('active')) { ?>
    <!-- Modal report -->
    <div class="modal modal-general fade" id="modal-report" tabindex="-1" role="dialog" aria-labelledby="modal-report-label" aria-hidden="true">
        <div class="modal-dialog w-dialog-800" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal-report-label">Vui lòng thông báo cho chúng tôi biết những tin đăng vi phạm để chúng tôi có hướng giải quyết kịp thời!</div>
                    <div class="modal-close transition" data-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x transition" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="modal-data">
                        <form id="form-report" method="post" action="" enctype="multipart/form-data">
                            <div class="modal-form">
                                <div class="row">
                                    <div class="col-4">
                                        <?php if (!empty($reportStatus)) { ?>
                                            <div class="report-status">
                                                <?php foreach ($reportStatus as $v_reportStatus) { ?>
                                                    <label class="btn btn-sm btn-warning custom-control custom-radio text-left text-sm py-2 pr-3 mb-2" for="report-<?= $v_reportStatus['id'] ?>">
                                                        <input type="radio" id="report-<?= $v_reportStatus['id'] ?>" name="dataReport[id_status]" class="custom-control-input" value="<?= $v_reportStatus['id'] ?>">
                                                        <span class="custom-control-label text-dark"><strong><?= $v_reportStatus['name' . $lang] ?></strong></span>
                                                        <div class="d-none" id="report-status-text"><?= $v_reportStatus['desc' . $lang] ?></div>
                                                    </label>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-8">
                                        <div class="response-report"></div>
                                        <div class="form-group row align-items-center">
                                            <div class="col-sm-3">
                                                <label for="fullname-report">Họ tên:</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control text-sm rounded-0" id="fullname-report" name="dataReport[fullname]" placeholder="Họ tên liên hệ" value="<?= $func->getMember('fullname') ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <div class="col-sm-3">
                                                <label for="phone-report">Số điện thoại:</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control text-sm rounded-0" id="phone-report" name="dataReport[phone]" placeholder="Số điện thoại liên hệ" value="<?= $func->getMember('phone') ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <div class="col-sm-3">
                                                <label for="email-report">Email:</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control text-sm rounded-0" id="email-report" name="dataReport[email]" placeholder="Email liên hệ" value="<?= $func->getMember('email') ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label for="content-report">Nội dung:</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <textarea class="form-control text-sm rounded-0" id="content-report" name="dataReport[content]" placeholder="Nội dung báo xấu" required /></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9">
                                                <div class="input-group align-items-center captcha-image">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text text-sm rounded-0 border-0">Mã bảo mật</span>
                                                    </div>
                                                    <input type="text" class="form-control text-sm" id="captcha-report" name="captcha-report" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text rounded-0 border-0">
                                                            <img onerror="this.src='<?= THUMBS ?>/80x30x1/assets/images/noimage.png';" src="<?= $configBase ?>captcha/<?= base64_encode('report') ?>/" alt="Mã bảo mật" />
                                                            <a class="captcha-reload ml-2" href="javascript:void(0)" data-type="report">
                                                                <i class="fas fa-sync-alt"></i>
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9 text-center">
                                                <input type="submit" class="btn btn-action btn-sm btn-primary px-3 mx-2" name="submit-report" value="Gửi" />
                                                <input type="reset" class="btn btn-action btn-sm btn-danger px-3 mx-2" value="Hủy" />
                                                <input type="hidden" name="recaptcha_response_report" id="recaptchaResponseReport">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php if (!empty($sector) && $func->hasService($sector) && !empty($rowDetail['status_attr']) && strstr($rowDetail['status_attr'], 'dichvu')) { ?>
    <!-- Modal booking -->
    <div class="modal modal-general fade" id="modal-booking" tabindex="-1" role="dialog" aria-labelledby="modal-booking-label" aria-hidden="true">
        <div class="modal-dialog w-dialog-630" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title" id="modal-booking-label">Vui lòng nhập thông tin để liên hệ với chủ sở hữu</div>
                    <div class="modal-close transition" data-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x transition" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="modal-data">
                        <div class="modal-form">
                            <form id="form-booking" method="post" action="" enctype="multipart/form-data">
                                <div class="form-group response-booking"></div>
                                <div class="form-group row align-items-center">
                                    <div class="col-sm-3">
                                        <label for="fullname-booking">Họ tên:</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-sm rounded-0" id="fullname-booking" name="dataBooking[fullname]" placeholder="Họ tên liên hệ" required>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <div class="col-sm-3">
                                        <label for="phone-booking">Số điện thoại:</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-sm rounded-0" id="phone-booking" name="dataBooking[phone]" placeholder="Số điện thoại liên hệ" required>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <div class="col-sm-3">
                                        <label for="email-booking">Email:</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-sm rounded-0" id="email-booking" name="dataBooking[email]" placeholder="Email liên hệ" required>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <div class="col-sm-3">
                                        <label for="address-booking">Địa chỉ:</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text-sm rounded-0" id="address-booking" name="dataBooking[address]" placeholder="Địa chỉ liên hệ" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label for="content-booking">Nội dung:</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <textarea class="form-control text-sm rounded-0" id="content-booking" name="dataBooking[content]" placeholder="Nội dung liên hệ" required /></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9">
                                        <div class="input-group align-items-center captcha-image">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-sm rounded-0 border-0">Vui lòng nhập mã bảo mật</span>
                                            </div>
                                            <input type="text" class="form-control text-sm" id="captcha-booking" name="captcha-booking" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text rounded-0 border-0">
                                                    <img onerror="this.src='<?= THUMBS ?>/80x30x1/assets/images/noimage.png';" src="<?= $configBase ?>captcha/<?= base64_encode('booking') ?>/" alt="Mã bảo mật" />
                                                    <a class="captcha-reload ml-2" href="javascript:void(0)" data-type="booking">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-center">
                                        <input type="submit" class="btn btn-action btn-sm btn-primary px-3 mx-2" name="submit-booking" value="Đăng ký" />
                                        <input type="reset" class="btn btn-action btn-sm btn-danger px-3 mx-2" value="Hủy" />
                                        <input type="hidden" name="recaptcha_response_booking" id="recaptchaResponseBooking">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Modal feedback -->
<a class="show-feedback text-decoration-none text-uppercase transition" href="javascript:void(0)" data-toggle="modal" data-target="#modal-feedback"></a>
<div class="modal modal-general fade" id="modal-feedback" tabindex="-1" role="dialog" aria-labelledby="modal-feedback-label" aria-hidden="true">
    <div class="modal-dialog w-dialog-630" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="modal-feedback-label">Vui lòng đóng góp ý kiến để chúng tôi phục vụ các bạn tốt hơn</div>
                <div class="modal-close transition" data-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x transition" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333333" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </div>
            </div>
            <div class="modal-body">
                <div class="modal-data">
                    <div class="modal-form">
                        <form id="form-feedback" method="post" action="" enctype="multipart/form-data">
                            <div class="form-group response-feedback"></div>
                            <div class="form-group row align-items-center">
                                <div class="col-sm-3">
                                    <label for="fullname-feedback">Họ tên:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-sm rounded-0" id="fullname-feedback" name="dataFeedback[fullname]" placeholder="Họ tên liên hệ" required>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <div class="col-sm-3">
                                    <label for="phone-feedback">Số điện thoại:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-sm rounded-0" id="phone-feedback" name="dataFeedback[phone]" placeholder="Số điện thoại liên hệ" required>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <div class="col-sm-3">
                                    <label for="email-feedback">Email:</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control text-sm rounded-0" id="email-feedback" name="dataFeedback[email]" placeholder="Email liên hệ" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="content-feedback">Nội dung:</label>
                                </div>
                                <div class="col-sm-9">
                                    <textarea class="form-control text-sm rounded-0" id="content-feedback" name="dataFeedback[content]" placeholder="Nội dung liên hệ" required /></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <div class="input-group align-items-center captcha-image">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-sm rounded-0 border-0">Vui lòng nhập mã bảo mật</span>
                                        </div>
                                        <input type="text" class="form-control text-sm" id="captcha-feedback" name="captcha-feedback" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text rounded-0 border-0">
                                                <img onerror="this.src='<?= THUMBS ?>/80x30x1/assets/images/noimage.png';" src="<?= $configBase ?>captcha/<?= base64_encode('feedback') ?>/" alt="Mã bảo mật" />
                                                <a class="captcha-reload ml-2" href="javascript:void(0)" data-type="feedback">
                                                    <i class="fas fa-sync-alt"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-center">
                                    <input type="submit" class="btn btn-action btn-sm btn-primary px-3 mx-2" name="submit-feedback" value="Gửi" />
                                    <input type="reset" class="btn btn-action btn-sm btn-danger px-3 mx-2" value="Hủy" />
                                    <input type="hidden" name="recaptcha_response_feedback" id="recaptchaResponseFeedback">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>