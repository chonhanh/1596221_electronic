<?php
if ($act == "add_group") $labelAct = "Thêm mới";
else if ($act == "edit_group") $labelAct = "Chỉnh sửa";

$linkMan = "index.php?com=user&act=man_group";
if ($act == 'add_group') $linkFilter = "index.php?com=user&act=add_group";
else if ($act == 'edit_group') $linkFilter = "index.php?com=user&act=edit_group&id=" . $id;
$linkSave = "index.php?com=user&act=save_group";
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active"><?= $labelAct ?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-user-group"><i class="far fa-save mr-2"></i>Lưu</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <?= $flash->getMessages('admin') ?>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title"><?= $labelAct ?></h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <?php $status_array = (!empty($item['status'])) ? explode(',', $item['status']) : array(); ?>
                    <?php if (isset($config['user']['check_group'])) {
                        foreach ($config['user']['check_group'] as $key => $value) { ?>
                            <div class="form-group d-inline-block mb-2 mr-2">
                                <label for="<?= $key ?>-checkbox" class="d-inline-block align-middle mb-0 mr-2"><?= $value ?>:</label>
                                <div class="custom-control custom-checkbox d-inline-block align-middle">
                                    <input type="checkbox" class="custom-control-input <?= $key ?>-checkbox" name="status[<?= $key ?>]" id="<?= $key ?>-checkbox" <?= (empty($status_array) && empty($item['id']) ? 'checked' : in_array($key, $status_array)) ? 'checked' : '' ?> value="<?= $key ?>">
                                    <label for="<?= $key ?>-checkbox" class="custom-control-label"></label>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
                <div class="form-group">
                    <label for="numb" class="d-inline-block align-middle mb-0 mr-2">Số thứ tự:</label>
                    <input type="number" class="form-control form-control-mini d-inline-block align-middle" min="0" name="data[numb]" id="numb" placeholder="Số thứ tự" value="<?= isset($item['numb']) ? $item['numb'] : 1 ?>">
                </div>
                <div class="form-group-category row">
                    <div class="form-group col-xl-4 col-sm-4">
                        <label class="d-block" for="id_type">Loại nhóm:</label>
                        <select id="id_type" name="data[id_type]" onchange="onchangeCategory($(this))" class="form-control select2 filter-category text-sm" required>
                            <option <?= (isset($_GET['id_type']) && $_GET['id_type'] == 1) ? 'selected' : '' ?> value="1">Nhóm quản lý thường</option>
                            <option <?= (isset($_GET['id_type']) && $_GET['id_type'] == 2) ? 'selected' : '' ?> value="2">Nhóm quản lý ảo</option>
                        </select>
                    </div>
                    <div class="form-group col-xl-4 col-sm-4 d-none">
                        <label class="d-block" for="id_list">Danh mục chính:</label>
                        <?= $func->getLinkCategory('product', 'list') ?>
                    </div>
                    <div class="form-group col-xl-4 col-sm-4">
                        <label class="d-block" for="id_cat">Danh mục cấp 1:</label>
                        <?= $func->getMultiCategoryCatByGroup() ?>
                    </div>
              
                    <div class="form-group col-xl-4 col-sm-4">
                        <label class="d-block" for="place_group">Tỉnh/thành phố:</label>
                        <?= $func->getMultiPlace(@$strIdPlaces) ?>
                    </div>
                    <div class="form-group col-xl-4 col-sm-4">
                        <label class="d-block" for="admin_group">Danh sách admin:</label>
                        <div class="form-group-category"><?= $func->getMultiAdmin(@$strIdAdmins, $id) ?></div>
                    </div>
                    <div class="form-group col-xl-4 col-sm-4">
                        <label class="d-block" for="permission_group">Danh sách quyền:</label>
                        <div class="form-group-category"><?= $func->getPermissionGroup(@$mainPermissions, @$configSector) ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-12">
                        <label class="d-block">Chọn trưởng nhóm: <span class="font-weight-normal text-danger">(Chọn danh sách Admin ở trên)</span></label>
                        <div id="admin-leader">
                            <?php if (!empty($itemAdmins)) {
                                foreach ($itemAdmins as $v) {
                                    $nameAdmin = $func->getInfoDetail('fullname', 'user', $v['id_admin']); ?>
                                    <div class="btn btn-sm btn-outline-info mr-2 mb-2">
                                        <div class="custom-control custom-radio my-custom-radio d-block text-sm">
                                            <input type="radio" class="custom-control-input" name="leader" id="admin-<?= $v['id_admin'] ?>" value="<?= $v['id_admin'] ?>" <?= (!empty($v['is_leader'])) ? 'checked' : '' ?>>
                                            <label for="admin-<?= $v['id_admin'] ?>" class="custom-control-label font-weight-normal"><?= $nameAdmin['fullname'] ?></label>
                                        </div>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="d-block" for="name">Tên nhóm:</label>
                        <input type="text" class="form-control text-sm" name="data[name]" id="name" placeholder="Tên nhóm" value="<?= @$item['name'] ?>" required>
                    </div>
                </div>
                <?php if (!empty($defineSectors['permissions']['lists'])) { ?>
                    <div class="form-group">
                        <label class="d-block font-weight-bold">CHI TIẾT QUYỀN <span class="font-weight-normal text-danger">(Chọn danh sách Quyền ở trên)</span></label>
                        <?php include_once(TEMPLATE . './user/permission/permission.php'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-user-group"><i class="far fa-save mr-2"></i>Lưu</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>