<?php
$actLinkMan = ($func->getGroup('virtual')) ? 'man_admin_virtual' : 'man_admin';
$linkMan = "index.php?com=user&act=" . $actLinkMan;
$linkSave = "index.php?com=user&act=save_admin_perms";
?>
<!-- Content Header -->
<section class="content-header text-sm">
    <div class="container-fluid">
        <div class="row">
            <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="index.php" title="Bảng điều khiển">Bảng điều khiển</a></li>
                <li class="breadcrumb-item active">Chi tiết tài khoản admin</li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <form method="post" action="<?= $linkSave ?>" enctype="multipart/form-data">
        <div class="card-footer text-sm sticky-top">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-admin-child"><i class="far fa-save mr-2"></i>Lưu</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
        </div>

        <?= $flash->getMessages('admin') ?>

        <div class="card card-primary card-outline text-sm">
            <div class="card-header">
                <h3 class="card-title">Thông tin tài khoản</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="username">Tài khoản:</label>
                        <input type="text" class="form-control text-sm" placeholder="Tài khoản" value="<?= @$item['username'] ?>" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="fullname">Họ tên:</label>
                        <input type="text" class="form-control text-sm" placeholder="Tài khoản" value="<?= @$item['fullname'] ?>" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control text-sm" placeholder="Tài khoản" value="<?= @$item['email'] ?>" readonly>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-md text-capitalize mb-2"><strong>Danh sách quyền</strong></div>
        <?php include_once(TEMPLATE . './user/permission/permission.php'); ?>

        <div class="card-footer text-sm">
            <button type="submit" class="btn btn-sm bg-gradient-primary submit-admin-child"><i class="far fa-save mr-2"></i>Lưu</button>
            <a class="btn btn-sm bg-gradient-danger" href="<?= $linkMan ?>" title="Thoát"><i class="fas fa-sign-out-alt mr-2"></i>Thoát</a>
            <input type="hidden" name="id" value="<?= (isset($item['id']) && $item['id'] > 0) ? $item['id'] : '' ?>">
        </div>
    </form>
</section>