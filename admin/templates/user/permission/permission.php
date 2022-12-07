<?php if ((!empty($configSector) && $func->hasShop($configSector)) || $func->getGroup('loggedByLeader')) { ?>
    <!-- Begin Permssion - Shop -->
    <div class="card card-primary card-outline card-perms <?= (!in_array('shop', $mainPermissions)) ? 'd-none' : '' ?>" id="perms-shop">
        <div class="card-header">
            <h3 class="card-title">Quản lý gian hàng</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <?php
            $array_perms = array(
                'com' => 'shop',
                'acts' => array(
                    'man' => 'Xem danh sách',
                    'add' => 'Thêm mới',
                    'edit' => 'Chỉnh sửa',
                    'delete' => 'Xóa'
                )
            );
            ?>
            <?php if (!empty($defineSectors) && !empty($typePermsSector) && !empty($array_perms)) {
                $shopSector = (!empty($defineSectors['types'][$typePermsSector])) ? $defineSectors['types'][$typePermsSector] : array();
                if (!empty($shopSector)) { ?>
                    <div class="form-group row">
                        <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Gian hàng - <span class="text-primary"><?= $shopSector['name'] ?></span>:</label>
                        <div class="col-md-7">
                            <?php $com_perms = $array_perms['com'];
                            foreach ($array_perms['acts'] as $k => $v) {
                                $leader_perms = true;
                                if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, $shopSector['type'])) $leader_perms = false;
                                if ($leader_perms) { ?>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="permissionLists[shop][]" id="perm-<?= $com_perms ?>-<?= $k ?>-<?= $shopSector['type'] ?>" value="<?= $com_perms ?>_<?= $k ?>_<?= $shopSector['type'] ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_' . $shopSector['type'], $listPermissions)) ? 'checked' : ''; ?>>
                                        <label for="perm-<?= $com_perms ?>-<?= $k ?>-<?= $shopSector['type'] ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
            <?php }
            } ?>
            <div class="form-group row">
                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Danh sách giao diện:</label>
                <div class="col-md-7">
                    <?php
                    $array_perms = array(
                        'com' => 'interface',
                        'acts' => array(
                            'man' => 'Xem danh sách',
                            'edit' => 'Chỉnh sửa'
                        )
                    );

                    if (!empty($array_perms)) {
                        $com_perms = $array_perms['com'];
                        foreach ($array_perms['acts'] as $k => $v) {
                            $leader_perms = true;
                            if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, '')) $leader_perms = false;
                            if ($leader_perms) { ?>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="permissionLists[shop][]" id="perm-<?= $com_perms ?>-<?= $k ?>" value="<?= $com_perms ?>_<?= $k ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k, $listPermissions)) ? 'checked' : ''; ?>>
                                    <label for="perm-<?= $com_perms ?>-<?= $k ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                </div>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Danh sách cửa hàng:</label>
                <div class="col-md-7">
                    <?php
                    $array_perms = array(
                        'com' => 'store',
                        'acts' => array(
                            'man' => 'Xem danh sách',
                            'add' => 'Thêm mới',
                            'edit' => 'Chỉnh sửa',
                            'delete' => 'Xóa'
                        )
                    );

                    if (!empty($array_perms)) {
                        $com_perms = $array_perms['com'];
                        foreach ($array_perms['acts'] as $k => $v) {
                            $leader_perms = true;
                            if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, '')) $leader_perms = false;
                            if ($leader_perms) { ?>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="permissionLists[shop][]" id="perm-<?= $com_perms ?>-<?= $k ?>" value="<?= $com_perms ?>_<?= $k ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k, $listPermissions)) ? 'checked' : ''; ?>>
                                    <label for="perm-<?= $com_perms ?>-<?= $k ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                </div>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Tìm hiểu gian hàng:</label>
                <div class="col-md-7">
                    <?php
                    $array_perms = array(
                        'com' => 'static',
                        'type' => 'tim-hieu-gian-hang',
                        'acts' => array(
                            'update' => 'Chỉnh sửa'
                        )
                    );

                    if (!empty($array_perms)) {
                        $com_perms = $array_perms['com'];
                        $type_perms = $array_perms['type'];
                        foreach ($array_perms['acts'] as $k => $v) {
                            $leader_perms = true;
                            if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, $type_perms)) $leader_perms = false;
                            if ($leader_perms) { ?>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="permissionLists[shop][]" id="perm-<?= $com_perms ?>-<?= $k ?>-<?= $type_perms ?>" value="<?= $com_perms ?>_<?= $k ?>_<?= $type_perms ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_' . $type_perms, $listPermissions)) ? 'checked' : ''; ?>>
                                    <label for="perm-<?= $com_perms ?>-<?= $k ?>-<?= $type_perms ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                </div>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Hoàn tất gian hàng:</label>
                <div class="col-md-7">
                    <?php
                    $array_perms = array(
                        'com' => 'static',
                        'type' => 'hoan-tat-gian-hang',
                        'acts' => array(
                            'update' => 'Chỉnh sửa'
                        )
                    );

                    if (!empty($array_perms)) {
                        $com_perms = $array_perms['com'];
                        $type_perms = $array_perms['type'];
                        foreach ($array_perms['acts'] as $k => $v) {
                            $leader_perms = true;
                            if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, $type_perms)) $leader_perms = false;
                            if ($leader_perms) { ?>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="permissionLists[shop][]" id="perm-<?= $com_perms ?>-<?= $k ?>-<?= $type_perms ?>" value="<?= $com_perms ?>_<?= $k ?>_<?= $type_perms ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_' . $type_perms, $listPermissions)) ? 'checked' : ''; ?>>
                                    <label for="perm-<?= $com_perms ?>-<?= $k ?>-<?= $type_perms ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                </div>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Dữ liệu mẫu:</label>
                <div class="col-md-7">
                    <?php
                    $array_perms = array(
                        'com' => 'sample',
                        'acts' => array(
                            'update' => 'Chỉnh sửa'
                        )
                    );

                    if (!empty($array_perms)) {
                        $com_perms = $array_perms['com'];
                        foreach ($array_perms['acts'] as $k => $v) {
                            $leader_perms = true;
                            if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, '')) $leader_perms = false;
                            if ($leader_perms) { ?>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="permissionLists[shop][]" id="perm-<?= $com_perms ?>-<?= $k ?>" value="<?= $com_perms ?>_<?= $k ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k, $listPermissions)) ? 'checked' : ''; ?>>
                                    <label for="perm-<?= $com_perms ?>-<?= $k ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                </div>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Permssion - Shop -->
<?php } ?>

<!-- Begin Permssion - Product -->
<div class="card card-primary card-outline card-perms <?= (!in_array('product', $mainPermissions)) ? 'd-none' : '' ?>" id="perms-product">
    <div class="card-header">
        <h3 class="card-title">Quản lý tin đăng</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Danh mục cấp 3:</label>
            <div class="col-md-7">
                <?php
                $array_perms = array(
                    'com' => 'product',
                    'acts' => array(
                        'man_item' => 'Xem danh sách',
                        'add_item' => 'Thêm mới',
                        'edit_item' => 'Chỉnh sửa',
                        'delete_item' => 'Xóa'
                    )
                );

                if (!empty($array_perms)) {
                    $com_perms = $array_perms['com'];
                    foreach ($array_perms['acts'] as $k => $v) {
                        $leader_perms = true;
                        if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, '')) $leader_perms = false;
                        if ($leader_perms) { ?>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="permissionLists[product][]" id="perm-<?= $com_perms ?>-<?= $k ?>" value="<?= $com_perms ?>_<?= $k ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k, $listPermissions)) ? 'checked' : ''; ?>>
                                <label for="perm-<?= $com_perms ?>-<?= $k ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                            </div>
                <?php }
                    }
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Danh mục cấp 4:</label>
            <div class="col-md-7">
                <?php
                $array_perms = array(
                    'com' => 'product',
                    'acts' => array(
                        'man_sub' => 'Xem danh sách',
                        'add_sub' => 'Thêm mới',
                        'edit_sub' => 'Chỉnh sửa',
                        'delete_sub' => 'Xóa'
                    )
                );

                if (!empty($array_perms)) {
                    $com_perms = $array_perms['com'];
                    foreach ($array_perms['acts'] as $k => $v) {
                        $leader_perms = true;
                        if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, '')) $leader_perms = false;
                        if ($leader_perms) { ?>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="permissionLists[product][]" id="perm-<?= $com_perms ?>-<?= $k ?>" value="<?= $com_perms ?>_<?= $k ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k, $listPermissions)) ? 'checked' : ''; ?>>
                                <label for="perm-<?= $com_perms ?>-<?= $k ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                            </div>
                <?php }
                    }
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Danh mục tags:</label>
            <div class="col-md-7">
                <?php
                $array_perms = array(
                    'com' => 'product',
                    'acts' => array(
                        'man_tags' => 'Xem danh sách',
                        'add_tags' => 'Thêm mới',
                        'edit_tags' => 'Chỉnh sửa',
                        'delete_tags' => 'Xóa'
                    )
                );

                if (!empty($array_perms)) {
                    $com_perms = $array_perms['com'];
                    foreach ($array_perms['acts'] as $k => $v) {
                        $leader_perms = true;
                        if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, '')) $leader_perms = false;
                        if ($leader_perms) { ?>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="permissionLists[product][]" id="perm-<?= $com_perms ?>-<?= $k ?>" value="<?= $com_perms ?>_<?= $k ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k, $listPermissions)) ? 'checked' : ''; ?>>
                                <label for="perm-<?= $com_perms ?>-<?= $k ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                            </div>
                <?php }
                    }
                }
                ?>
            </div>
        </div>
        <?php if (!empty($configSector) && $func->hasCart($configSector)) { ?>
            <div class="form-group row">
                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Danh mục màu sắc:</label>
                <div class="col-md-7">
                    <?php
                    $array_perms = array(
                        'com' => 'product',
                        'acts' => array(
                            'man_color' => 'Xem danh sách',
                            'add_color' => 'Thêm mới',
                            'edit_color' => 'Chỉnh sửa',
                            'delete_color' => 'Xóa'
                        )
                    );

                    if (!empty($array_perms)) {
                        $com_perms = $array_perms['com'];
                        foreach ($array_perms['acts'] as $k => $v) {
                            $leader_perms = true;
                            if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, '')) $leader_perms = false;
                            if ($leader_perms) { ?>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="permissionLists[product][]" id="perm-<?= $com_perms ?>-<?= $k ?>" value="<?= $com_perms ?>_<?= $k ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k, $listPermissions)) ? 'checked' : ''; ?>>
                                    <label for="perm-<?= $com_perms ?>-<?= $k ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                </div>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Danh mục kích cỡ:</label>
                <div class="col-md-7">
                    <?php
                    $array_perms = array(
                        'com' => 'product',
                        'acts' => array(
                            'man_size' => 'Xem danh sách',
                            'add_size' => 'Thêm mới',
                            'edit_size' => 'Chỉnh sửa',
                            'delete_size' => 'Xóa'
                        )
                    );

                    if (!empty($array_perms)) {
                        $com_perms = $array_perms['com'];
                        foreach ($array_perms['acts'] as $k => $v) {
                            $leader_perms = true;
                            if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, '')) $leader_perms = false;
                            if ($leader_perms) { ?>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="permissionLists[product][]" id="perm-<?= $com_perms ?>-<?= $k ?>" value="<?= $com_perms ?>_<?= $k ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k, $listPermissions)) ? 'checked' : ''; ?>>
                                    <label for="perm-<?= $com_perms ?>-<?= $k ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                </div>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
        <?php
        $array_perms = array(
            'com' => 'product',
            'acts' => array(
                'man' => 'Xem danh sách',
                'add' => 'Thêm mới',
                'edit' => 'Chỉnh sửa',
                'delete' => 'Xóa'
            )
        );
        ?>
        <?php if (!empty($defineSectors) && !empty($typePermsSector) && !empty($array_perms)) {
            $productSector = (!empty($defineSectors['types'][$typePermsSector])) ? $defineSectors['types'][$typePermsSector] : array();
            if (!empty($shopSector)) { ?>
                <div class="form-group row">
                    <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Tin đăng - <span class="text-primary"><?= $shopSector['name'] ?></span>:</label>
                    <div class="col-md-7">
                        <?php $com_perms = $array_perms['com'];
                        foreach ($array_perms['acts'] as $k => $v) {
                            $leader_perms = true;
                            if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, $shopSector['type'])) $leader_perms = false;
                            if ($leader_perms) { ?>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="permissionLists[product][]" id="perm-<?= $com_perms ?>-<?= $k ?>-<?= $shopSector['type'] ?>" value="<?= $com_perms ?>_<?= $k ?>_<?= $shopSector['type'] ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_' . $shopSector['type'], $listPermissions)) ? 'checked' : ''; ?>>
                                    <label for="perm-<?= $com_perms ?>-<?= $k ?>-<?= $shopSector['type'] ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>
        <?php }
        } ?>
    </div>
</div>
<!-- End Permssion - Product -->

<!-- Begin Permssion - Variation -->
<div class="card card-primary card-outline card-perms <?= (!in_array('variation', $mainPermissions)) ? 'd-none' : '' ?>" id="perms-variation">
    <div class="card-header">
        <h3 class="card-title">Quản lý biến thể</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <?php if (!empty($config['variation'])) {
            foreach ($config['variation'] as $k_variation => $v_variation) { ?>
                <div class="form-group row">
                    <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3"><?= $v_variation['title_main'] ?>:</label>
                    <div class="col-md-7">
                        <?php
                        $array_perms = array(
                            'com' => 'variation',
                            'acts' => array(
                                'man' => 'Xem danh sách',
                                'add' => 'Thêm mới',
                                'edit' => 'Chỉnh sửa',
                                'delete' => 'Xóa'
                            )
                        );

                        if (!empty($array_perms)) {
                            $com_perms = $array_perms['com'];
                            foreach ($array_perms['acts'] as $k => $v) {
                                $leader_perms = true;
                                if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, $k_variation)) $leader_perms = false;
                                if ($leader_perms) { ?>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="permissionLists[variation][]" id="perm-<?= $com_perms ?>-<?= $k ?>-<?= $k_variation ?>" value="<?= $com_perms ?>_<?= $k ?>_<?= $k_variation ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_' . $k_variation, $listPermissions)) ? 'checked' : ''; ?>>
                                        <label for="perm-<?= $com_perms ?>-<?= $k ?>-<?= $k_variation ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                    </div>
                        <?php }
                            }
                        }
                        ?>
                    </div>
                </div>
        <?php }
        } ?>
    </div>
</div>
<!-- End Permssion - Variation -->

<!-- Begin Permssion - Report -->
<div class="card card-primary card-outline card-perms <?= (!in_array('report', $mainPermissions)) ? 'd-none' : '' ?>" id="perms-report">
    <div class="card-header">
        <h3 class="card-title">Quản lý báo xấu</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Tình trạng:</label>
            <div class="col-md-7">
                <?php
                $array_perms = array(
                    'com' => 'report',
                    'acts' => array(
                        'man' => 'Xem danh sách',
                        'add' => 'Thêm mới',
                        'edit' => 'Chỉnh sửa',
                        'delete' => 'Xóa'
                    )
                );

                if (!empty($array_perms)) {
                    $com_perms = $array_perms['com'];
                    foreach ($array_perms['acts'] as $k => $v) {
                        $leader_perms = true;
                        if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, '')) $leader_perms = false;
                        if ($leader_perms) { ?>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="permissionLists[report][]" id="perm-<?= $com_perms ?>-<?= $k ?>" value="<?= $com_perms ?>_<?= $k ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k, $listPermissions)) ? 'checked' : ''; ?>>
                                <label for="perm-<?= $com_perms ?>-<?= $k ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                            </div>
                <?php }
                    }
                }
                ?>
            </div>
        </div>
        <?php
        $array_perms = array(
            'com' => 'report',
            'acts' => array(
                'man_report_posting' => 'Xem danh sách',
                'edit_report_posting' => 'Chỉnh sửa',
                'delete_report_posting' => 'Xóa'
            )
        );
        ?>
        <?php if (!empty($defineSectors) && !empty($typePermsSector) && !empty($array_perms)) {
            $productSector = (!empty($defineSectors['types'][$typePermsSector])) ? $defineSectors['types'][$typePermsSector] : array();
            if (!empty($productSector)) { ?>
                <div class="form-group row">
                    <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Tin đăng - <span class="text-primary"><?= $productSector['name'] ?></span>:</label>
                    <div class="col-md-7">
                        <?php $com_perms = $array_perms['com'];
                        foreach ($array_perms['acts'] as $k => $v) {
                            $leader_perms = true;
                            if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, $productSector['type'])) $leader_perms = false;
                            if ($leader_perms) { ?>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="permissionLists[report][]" id="perm-<?= $com_perms ?>-<?= $k ?>-<?= $productSector['type'] ?>" value="<?= $com_perms ?>_<?= $k ?>_<?= $productSector['type'] ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_' . $productSector['type'], $listPermissions)) ? 'checked' : ''; ?>>
                                    <label for="perm-<?= $com_perms ?>-<?= $k ?>-<?= $productSector['type'] ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>
        <?php }
        } ?>
        <?php if (!empty($configSector) && $func->hasShop($configSector)) { ?>
            <?php
            $array_perms = array(
                'com' => 'report',
                'acts' => array(
                    'man_report_shop' => 'Xem danh sách',
                    'edit_report_shop' => 'Chỉnh sửa',
                    'delete_report_shop' => 'Xóa'
                )
            );
            ?>
            <?php if (!empty($defineSectors) && !empty($typePermsSector) && !empty($array_perms)) {
                $productSector = (!empty($defineSectors['types'][$typePermsSector])) ? $defineSectors['types'][$typePermsSector] : array();
                if (!empty($productSector)) { ?>
                    <div class="form-group row">
                        <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Gian hàng - <span class="text-primary"><?= $productSector['name'] ?></span>:</label>
                        <div class="col-md-7">
                            <?php $com_perms = $array_perms['com'];
                            foreach ($array_perms['acts'] as $k => $v) {
                                $leader_perms = true;
                                if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, $productSector['type'])) $leader_perms = false;
                                if ($leader_perms) { ?>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="permissionLists[report][]" id="perm-<?= $com_perms ?>-<?= $k ?>-<?= $productSector['type'] ?>" value="<?= $com_perms ?>_<?= $k ?>_<?= $productSector['type'] ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_' . $productSector['type'], $listPermissions)) ? 'checked' : ''; ?>>
                                        <label for="perm-<?= $com_perms ?>-<?= $k ?>-<?= $productSector['type'] ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
            <?php }
            } ?>
        <?php } ?>
    </div>
</div>
<!-- End Permssion - Report -->

<?php if (!empty($configSector) && $func->hasCart($configSector)) { ?>
    <!-- Begin Permssion - Order -->
    <div class="card card-primary card-outline card-perms <?= (!in_array('order', $mainPermissions)) ? 'd-none' : '' ?>" id="perms-order">
        <div class="card-header">
            <h3 class="card-title">Quản lý đơn hàng</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <?php
            $array_perms = array(
                'com' => 'order',
                'acts' => array(
                    'man' => 'Xem danh sách',
                    'edit' => 'Chỉnh sửa',
                    'delete' => 'Xóa'
                )
            );

            if (!empty($array_perms)) {
                $com_perms = $array_perms['com'];
                foreach ($array_perms['acts'] as $k => $v) {
                    $leader_perms = true;
                    if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, '')) $leader_perms = false;
                    if ($leader_perms) { ?>
                        <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                            <input type="checkbox" class="custom-control-input" name="permissionLists[order][]" id="perm-<?= $com_perms ?>-<?= $k ?>" value="<?= $com_perms ?>_<?= $k ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k, $listPermissions)) ? 'checked' : ''; ?>>
                            <label for="perm-<?= $com_perms ?>-<?= $k ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                        </div>
            <?php }
                }
            }
            ?>
        </div>
    </div>
    <!-- End Permssion - Order -->
<?php } ?>

<!-- Begin Permssion - Newsletter -->
<div class="card card-primary card-outline card-perms <?= (!in_array('newsletter', $mainPermissions)) ? 'd-none' : '' ?>" id="perms-newsletter">
    <div class="card-header">
        <h3 class="card-title">Quản lý nhận tin</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <?php if (!empty($config['newsletter'])) {
            foreach ($config['newsletter'] as $k_newsletter => $v_newsletter) { ?>
                <div class="form-group row">
                    <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3"><?= $v_newsletter['title_main'] ?>:</label>
                    <div class="col-md-7">
                        <?php
                        $array_perms = array(
                            'com' => 'newsletter',
                            'acts' => array(
                                'man' => 'Xem danh sách',
                                'add' => 'Thêm mới',
                                'edit' => 'Chỉnh sửa',
                                'delete' => 'Xóa'
                            )
                        );

                        if (!empty($array_perms)) {
                            $com_perms = $array_perms['com'];
                            foreach ($array_perms['acts'] as $k => $v) {
                                $leader_perms = true;
                                if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, $k_newsletter)) $leader_perms = false;
                                if ($leader_perms) { ?>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="permissionLists[newsletter][]" id="perm-<?= $com_perms ?>-<?= $k ?>-<?= $k_newsletter ?>" value="<?= $com_perms ?>_<?= $k ?>_<?= $k_newsletter ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_' . $k_newsletter, $listPermissions)) ? 'checked' : ''; ?>>
                                        <label for="perm-<?= $com_perms ?>-<?= $k ?>-<?= $k_newsletter ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                    </div>
                        <?php }
                            }
                        }
                        ?>
                    </div>
                </div>
        <?php }
        } ?>
    </div>
</div>
<!-- End Permssion - Newsletter -->

<!-- Begin Permssion - News -->
<div class="card card-primary card-outline card-perms <?= (!in_array('news', $mainPermissions)) ? 'd-none' : '' ?>" id="perms-news">
    <div class="card-header">
        <h3 class="card-title">Quản lý bài viết</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <?php if (!empty($config['static'])) { ?>
            <div class="form-group row">
                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Giới thiệu:</label>
                <div class="col-md-7">
                    <?php
                    $array_perms = array(
                        'com' => 'static',
                        'type' => 'gioi-thieu',
                        'acts' => array(
                            'update' => 'Chỉnh sửa'
                        )
                    );

                    if (!empty($array_perms)) {
                        $com_perms = $array_perms['com'];
                        $type_perms = $array_perms['type'];
                        foreach ($array_perms['acts'] as $k => $v) {
                            $leader_perms = true;
                            if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, $type_perms)) $leader_perms = false;
                            if ($leader_perms) { ?>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="permissionLists[news][]" id="perm-<?= $com_perms ?>-<?= $k ?>-<?= $type_perms ?>" value="<?= $com_perms ?>_<?= $k ?>_<?= $type_perms ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_' . $type_perms, $listPermissions)) ? 'checked' : ''; ?>>
                                    <label for="perm-<?= $com_perms ?>-<?= $k ?>-<?= $type_perms ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                </div>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="form-group row">
                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Liên hệ:</label>
                <div class="col-md-7">
                    <?php
                    $array_perms = array(
                        'com' => 'static',
                        'type' => 'lien-he',
                        'acts' => array(
                            'update' => 'Chỉnh sửa'
                        )
                    );

                    if (!empty($array_perms)) {
                        $com_perms = $array_perms['com'];
                        $type_perms = $array_perms['type'];
                        foreach ($array_perms['acts'] as $k => $v) {
                            $leader_perms = true;
                            if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, $type_perms)) $leader_perms = false;
                            if ($leader_perms) { ?>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="permissionLists[news][]" id="perm-<?= $com_perms ?>-<?= $k ?>-<?= $type_perms ?>" value="<?= $com_perms ?>_<?= $k ?>_<?= $type_perms ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_' . $type_perms, $listPermissions)) ? 'checked' : ''; ?>>
                                    <label for="perm-<?= $com_perms ?>-<?= $k ?>-<?= $type_perms ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                </div>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
        <?php } ?>

        <?php if (!empty($config['news'])) {
            foreach ($config['news'] as $k_news => $v_news) { ?>
                <div class="form-group row">
                    <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3"><?= $v_news['title_main'] ?>:</label>
                    <div class="col-md-7">
                        <?php
                        $array_perms = array(
                            'com' => 'news',
                            'acts' => array(
                                'man' => 'Xem danh sách',
                                'add' => 'Thêm mới',
                                'edit' => 'Chỉnh sửa',
                                'delete' => 'Xóa'
                            )
                        );

                        if (!empty($array_perms)) {
                            $com_perms = $array_perms['com'];
                            foreach ($array_perms['acts'] as $k => $v) {
                                $leader_perms = true;
                                if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, $k_news)) $leader_perms = false;
                                if ($leader_perms) { ?>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="permissionLists[news][]" id="perm-<?= $com_perms ?>-<?= $k ?>-<?= $k_news ?>" value="<?= $com_perms ?>_<?= $k ?>_<?= $k_news ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_' . $k_news, $listPermissions)) ? 'checked' : ''; ?>>
                                        <label for="perm-<?= $com_perms ?>-<?= $k ?>-<?= $k_news ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                    </div>
                        <?php }
                            }
                        }
                        ?>
                    </div>
                </div>
        <?php }
        } ?>
    </div>
</div>
<!-- End Permssion - News -->

<!-- Begin Permssion - Photo -->
<div class="card card-primary card-outline card-perms <?= (!in_array('photo', $mainPermissions)) ? 'd-none' : '' ?>" id="perms-photo">
    <div class="card-header">
        <h3 class="card-title">Quản lý hình ảnh</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <?php if (!empty($config['photo']['photo_static'])) {
            foreach ($config['photo']['photo_static'] as $k_photo => $v_photo) { ?>
                <div class="form-group row">
                    <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3"><?= $v_photo['title_main'] ?>:</label>
                    <div class="col-md-7">
                        <?php
                        $array_perms = array(
                            'com' => 'photo',
                            'acts' => array(
                                'photo_static' => 'Chỉnh sửa'
                            )
                        );

                        if (!empty($array_perms)) {
                            $com_perms = $array_perms['com'];
                            foreach ($array_perms['acts'] as $k => $v) {
                                $leader_perms = true;
                                if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, $k_photo)) $leader_perms = false;
                                if ($leader_perms) { ?>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="permissionLists[photo][]" id="perm-<?= $com_perms ?>-<?= $k ?>-<?= $k_photo ?>" value="<?= $com_perms ?>_<?= $k ?>_<?= $k_photo ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_' . $k_photo, $listPermissions)) ? 'checked' : ''; ?>>
                                        <label for="perm-<?= $com_perms ?>-<?= $k ?>-<?= $k_photo ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                    </div>
                        <?php }
                            }
                        }
                        ?>
                    </div>
                </div>
        <?php }
        } ?>

        <?php if (!empty($config['photo']['man_photo'])) {
            foreach ($config['photo']['man_photo'] as $k_photo => $v_photo) { ?>
                <div class="form-group row">
                    <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3"><?= $v_photo['title_main_photo'] ?>:</label>
                    <div class="col-md-7">
                        <?php
                        $array_perms = array(
                            'com' => 'photo',
                            'acts' => array(
                                'man_photo' => 'Xem danh sách',
                                'add_photo' => 'Thêm mới',
                                'edit_photo' => 'Chỉnh sửa',
                                'delete_photo' => 'Xóa'
                            )
                        );

                        if (!empty($array_perms)) {
                            $com_perms = $array_perms['com'];
                            foreach ($array_perms['acts'] as $k => $v) {
                                $leader_perms = true;
                                if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, $k_photo)) $leader_perms = false;
                                if ($leader_perms) { ?>
                                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                        <input type="checkbox" class="custom-control-input" name="permissionLists[photo][]" id="perm-<?= $com_perms ?>-<?= $k ?>-<?= $k_photo ?>" value="<?= $com_perms ?>_<?= $k ?>_<?= $k_photo ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_' . $k_photo, $listPermissions)) ? 'checked' : ''; ?>>
                                        <label for="perm-<?= $com_perms ?>-<?= $k ?>-<?= $k_photo ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                    </div>
                        <?php }
                            }
                        }
                        ?>
                    </div>
                </div>
        <?php }
        } ?>
    </div>
</div>
<!-- End Permssion - Photo -->

<!-- Begin Permssion - Place -->
<div class="card card-primary card-outline card-perms <?= (!in_array('place', $mainPermissions)) ? 'd-none' : '' ?>" id="perms-place">
    <div class="card-header">
        <h3 class="card-title">Quản lý địa điểm</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <?php
        $array_place = array(
            'region' => 'Vùng/miền',
            'city' => 'Tỉnh/thành phố',
            'district' => 'Quận/huyện',
            'wards' => 'Phường/xã'
        );
        ?>
        <?php foreach ($array_place as $k_place => $v_place) { ?>
            <div class="form-group row">
                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3"><?= $v_place ?>:</label>
                <div class="col-md-7">
                    <?php
                    $array_perms = array(
                        'com' => 'places',
                        'acts' => array(
                            'man_' . $k_place => 'Xem danh sách',
                            'add_' . $k_place => 'Thêm mới',
                            'edit_' . $k_place => 'Chỉnh sửa',
                            'delete_' . $k_place => 'Xóa'
                        )
                    );

                    if (!empty($array_perms)) {
                        $com_perms = $array_perms['com'];
                        foreach ($array_perms['acts'] as $k => $v) {
                            $leader_perms = true;
                            if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, '')) $leader_perms = false;
                            if ($leader_perms) { ?>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="permissionLists[place][]" id="perm-<?= $com_perms ?>-<?= $k ?>" value="<?= $com_perms ?>_<?= $k ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k, $listPermissions)) ? 'checked' : ''; ?>>
                                    <label for="perm-<?= $com_perms ?>-<?= $k ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                </div>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<!-- End Permssion - Place -->

<!-- Begin Permssion - SEO page -->
<div class="card card-primary card-outline card-perms <?= (!in_array('seopage', $mainPermissions)) ? 'd-none' : '' ?>" id="perms-seopage">
    <div class="card-header">
        <h3 class="card-title">Quản lý SEO page</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Thông báo:</label>
            <div class="col-md-7">
                <?php
                $array_perms = array(
                    'com' => 'seopage',
                    'acts' => array(
                        'update' => 'Chỉnh sửa'
                    )
                );

                if (!empty($array_perms)) {
                    $com_perms = $array_perms['com'];
                    foreach ($array_perms['acts'] as $k => $v) {
                        $leader_perms = true;
                        if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, 'thong-bao')) $leader_perms = false;
                        if ($leader_perms) { ?>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="permissionLists[seopage][]" id="perm-<?= $com_perms ?>-<?= $k ?>-thong-bao" value="<?= $com_perms ?>_<?= $k ?>_thong-bao" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_thong-bao', $listPermissions)) ? 'checked' : ''; ?>>
                                <label for="perm-<?= $com_perms ?>-<?= $k ?>-thong-bao" class="custom-control-label font-weight-normal"><?= $v ?></label>
                            </div>
                <?php }
                    }
                }
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Video:</label>
            <div class="col-md-7">
                <?php
                $array_perms = array(
                    'com' => 'seopage',
                    'acts' => array(
                        'update' => 'Chỉnh sửa'
                    )
                );

                if (!empty($array_perms)) {
                    $com_perms = $array_perms['com'];
                    foreach ($array_perms['acts'] as $k => $v) {
                        $leader_perms = true;
                        if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, 'video')) $leader_perms = false;
                        if ($leader_perms) { ?>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="permissionLists[seopage][]" id="perm-<?= $com_perms ?>-<?= $k ?>-video" value="<?= $com_perms ?>_<?= $k ?>_video" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_video', $listPermissions)) ? 'checked' : ''; ?>>
                                <label for="perm-<?= $com_perms ?>-<?= $k ?>-video" class="custom-control-label font-weight-normal"><?= $v ?></label>
                            </div>
                <?php }
                    }
                }
                ?>
            </div>
        </div>
        <?php if (!empty($configSector)) { ?>
            <div class="form-group row">
                <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Video - <?= $configSector['name'] ?>:</label>
                <div class="col-md-7">
                    <?php
                    $array_perms = array(
                        'com' => 'seopage',
                        'acts' => array(
                            'update' => 'Chỉnh sửa'
                        )
                    );

                    if (!empty($array_perms)) {
                        $com_perms = $array_perms['com'];
                        foreach ($array_perms['acts'] as $k => $v) {
                            $leader_perms = true;
                            if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, $configSector['type'])) $leader_perms = false;
                            if ($leader_perms) { ?>
                                <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                    <input type="checkbox" class="custom-control-input" name="permissionLists[seopage][]" id="perm-<?= $com_perms ?>-<?= $k ?>-video-<?= $configSector['type'] ?>" value="<?= $com_perms ?>_<?= $k ?>_video-<?= $configSector['type'] ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k . '_video' . '-' . $configSector['type'], $listPermissions)) ? 'checked' : ''; ?>>
                                    <label for="perm-<?= $com_perms ?>-<?= $k ?>-video-<?= $configSector['type'] ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                                </div>
                    <?php }
                        }
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<!-- End Permssion - SEO page -->

<!-- Begin Permssion - Member -->
<div class="card card-primary card-outline card-perms <?= (!in_array('user', $mainPermissions)) ? 'd-none' : '' ?>" id="perms-user">
    <div class="card-header">
        <h3 class="card-title">Quản lý thành viên</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label class="d-inline-block align-middle mb-2 mr-2 text-md col-md-3">Danh sách thành viên:</label>
            <div class="col-md-7">
                <?php
                $array_perms = array(
                    'com' => 'user',
                    'acts' => array(
                        'man_member' => 'Xem danh sách',
                        'edit_member' => 'Chỉnh sửa',
                    )
                );

                if (!empty($array_perms)) {
                    $com_perms = $array_perms['com'];
                    foreach ($array_perms['acts'] as $k => $v) {
                        $leader_perms = true;
                        if ($func->getGroup('loggedByLeader') && !$func->checkAccess($com_perms, $k, '')) $leader_perms = false;
                        if ($leader_perms) { ?>
                            <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                                <input type="checkbox" class="custom-control-input" name="permissionLists[user][]" id="perm-<?= $com_perms ?>-<?= $k ?>" value="<?= $com_perms ?>_<?= $k ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k, $listPermissions)) ? 'checked' : ''; ?>>
                                <label for="perm-<?= $com_perms ?>-<?= $k ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                            </div>
                <?php }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- End Permssion - Member -->

<!-- Begin Permssion - Setting -->
<?php
$leader_perms = true;
if ($func->getGroup('loggedByLeader') && !$func->checkAccess('setting', 'update', '')) $leader_perms = false;
if ($leader_perms) { ?>
    <div class="card card-primary card-outline card-perms <?= (!in_array('setting', $mainPermissions)) ? 'd-none' : '' ?>" id="perms-setting">
        <div class="card-header">
            <h3 class="card-title">Quản lý cài đặt</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <?php
            $array_perms = array(
                'com' => 'setting',
                'acts' => array(
                    'update' => 'Chỉnh sửa'
                )
            );

            if (!empty($array_perms)) {
                $com_perms = $array_perms['com'];
                foreach ($array_perms['acts'] as $k => $v) { ?>
                    <div class="custom-control custom-checkbox d-inline-block align-middle mb-1 mr-4 text-md">
                        <input type="checkbox" class="custom-control-input" name="permissionLists[setting][]" id="perm-<?= $com_perms ?>-<?= $k ?>" value="<?= $com_perms ?>_<?= $k ?>" <?= (!empty($listPermissions) && in_array($com_perms . '_' . $k, $listPermissions)) ? 'checked' : ''; ?>>
                        <label for="perm-<?= $com_perms ?>-<?= $k ?>" class="custom-control-label font-weight-normal"><?= $v ?></label>
                    </div>
            <?php }
            }
            ?>
        </div>
    </div>
<?php } ?>
<!-- End Permssion - Setting -->